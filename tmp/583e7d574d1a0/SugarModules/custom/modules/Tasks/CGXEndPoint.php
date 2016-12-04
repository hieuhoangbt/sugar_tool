<?php

///**
// * @param $response
// * @return bool
// */
require_once('custom/modules/ACLRoles/RoleBasedQueuePermission.php');
require_once('modules/CGX_CheckList/CGX_CheckList.php');
$response = file_get_contents('php://input');
$GLOBALS['log']->debug($response);
$response = json_decode($response, true);
processResponseData($response['myQueueRowDataDetails']);

function processResponseData($my_queue_row_data_details)
{
    $action = $my_queue_row_data_details['action'];
    switch ($action) {
        case "ADD": {
            // Create Message
            $GLOBALS['log']->debug('---BEGIN CREATE MESSAGE---');
            createMessage($my_queue_row_data_details);
            $GLOBALS['log']->debug('---END CREATE MESSAGE---');
            break;
        }
        case "UPDATE": {
            // Update Message
            $GLOBALS['log']->debug('---BEGIN UPDATE MESSAGE---');
            updateMessage($my_queue_row_data_details);
            $GLOBALS['log']->debug('---END UPDATE MESSAGE---');
            break;
        }
        case "REMOVE": {
            // Remove Message
            $GLOBALS['log']->debug('---BEGIN REMOVE MESSAGE---');
            deleteMessage($my_queue_row_data_details);
            $GLOBALS['log']->debug('---END REMOVE MESSAGE---');
            break;
        }
        default: {
            // Do nothing
            break;
        }
    }
    return true;
}

/**
 * Create message
 * @params: queue data
 * Flow:
 * If note found the CGX Role mapped in SuiteCRM then add new ACLRole map to the CGX Role
 */
function createMessage($my_queue_row_data_details)
{
    $activity_ids = processQueueList($my_queue_row_data_details);
}

/**
 * Update message
 * @params: $my_queue_row_data_details
 */
function updateMessage($my_queue_row_data_details)
{
    // Update task to completed if completion option not empty
    $rows = $my_queue_row_data_details['rows'];
    if (isset($rows['activityId']) && !empty($rows['activityId'])) {
        $checkAssignment = isAssignmentFF($rows['activityId']);
        if (!$checkAssignment['flg']) {
            $task_id = updateOrCreateTask($rows);
            $GLOBALS['log']->debug(print_r($checkAssignment, true));
        } else {
            $task_id = $checkAssignment['task_id'];
        }
        // Remove all records by task, queue and CGX Role
        if (!empty($task_id)) {
            updateOrCreateRoleBasePermission($task_id, $rows);
        }
    } else {
        foreach ($rows as $row) {
            if (isset($row['activityId']) && !empty($row['activityId'])) {
                $checkAssignment = isAssignmentFF($row['activityId']);
                if (!$checkAssignment['flg']) {
                    $task_id = updateOrCreateTask($row);
                } else {
                    $task_id = $checkAssignment['task_id'];
                }
                // Remove all records by task, queue and CGX Role
                if (isset($row['activityId']) && isset($row['queueId']) && isset($row['roleName'])) {
                    updateOrCreateRoleBasePermission($task_id, $row);
                }
            }
        }
    }
}

/**
 * Check if state of activity is *FF*
 * return 1 => update *FF* to 0 => stop process
 * return 0 => continue process
 */
function isAssignmentFF($activityId)
{
    $task = new Task();
    $task->retrieve_by_string_fields(array('activity_id_c' => $activityId), true, true);
    $flg = false;
    if ($task->is_assignment_ff == 1) {
        $flg = true;
    }
    return array(
        'flg' => $flg,
        'task_id' => $task->id
    );
}

/**
 * Remove message
 * @params: $my_queue_row_data_details
 * @return task id
 */
function deleteMessage($my_queue_row_data_details)
{
    // Update task to completed if completion option not empty
    $rows = $my_queue_row_data_details['rows'];
    if (isset($rows['activityId']) && !empty($rows['activityId'])) {
        $task = new Task();
        $task->retrieve_by_string_fields(array('activity_id_c' => $rows['activityId']));
        if (!empty($task->id)) {
            $task->status = "completed";
            if (isset($rows['selectedCompletionOption']['description'])) {
                $task->selected_completion_option_c = $rows['selectedCompletionOption']['description'];
            }
            $task->save();
        }
        // Remove all records by task, queue and CGX Role
        if (isset($rows['activityId']) && isset($rows['queueId']) && isset($rows['roleName'])) {
            removeRoleBasePermission($rows['activityId'], $rows['queueId'], $rows['roleName']);
        }
    } else {
        foreach ($rows as $row) {
            $task = new Task();
            $task->retrieve_by_string_fields(array('activity_id_c' => $row['activityId']));
            if (!empty($task->id)) {
                $task->status = "completed";
                if (isset($row['selectedCompletionOption']['description'])) {
                    $task->selected_completion_option_c = $row['selectedCompletionOption']['description'];
                }
                $task->save();
            }
            // Remove all records by task, queue and CGX Role
            if (isset($row['activityId']) && isset($row['queueId']) && isset($row['roleName'])) {
                removeRoleBasePermission($row['queueId'], $row['activityId'], $row['queueId'], $row['roleName']);
            }
        }
    }
}

/*
 * Update or create new task
 * @params: $data = array()
 * @return: int | string
 */

function updateOrCreateTask($row = array())
{
    if (!$row) {
        return 0;
    }
    try {
        $completion = '';
        if (isset($row['completionOptions']) && !empty($row['completionOptions'])) {
            foreach ($row['completionOptions'] as $key => $value) {
                if (!empty($value['description'])) {
                    $completion .= '^' . trim($value['description']) . '^,';
                } else if ($key == 'description') {
                    // fix: only has 1 result, eg : results => ['description' => '...', 'key' => '...', 'label' => '...']
                    $completion = '^' . trim($value) . '^';
                }
            }
        }
        $completion = trim($completion, ', ');
        $cgx_wf_id = $row['workflowInstanceId'];
        $parent_type = $parent_id = '';
        if (!empty($row['workflowVariables']['dataMap']['entry'])) {
            foreach ($row['workflowVariables']['dataMap']['entry'] as $entry) {
                if ($entry['key'] == 'Business_Object') {
                    $parent_type = @$entry['value'];
                }
                if ($entry['key'] == 'Business_Object_Id') {
                    $parent_id = @$entry['value'];
                }
            }
        }
        $task = new Task();
        $task->retrieve_by_string_fields(array('activity_id_c' => $row['activityId']), true, true);
        $status = getSuiteCrmTaskStatus($row['activityState']);
        if ($task->id) {
            $task->retrieve($task->id);
            $task->status = $status;
            $task->name = trim($row['activityDescription']);
            $task->completion_options_c = $completion;
            $task->cgx_wf_id_c = $cgx_wf_id;
            $task->parent_type = $parent_type;
            $task->parent_id = $parent_id;
            $task->deleted = 0;
        } else {
            $task->name = trim($row['activityDescription']);
            $task->activity_id_c = $row['activityId'];
            $task->cgx_wf_id_c = $cgx_wf_id;
            $task->parent_type = $parent_type;
            $task->parent_id = $parent_id;
            $task->status = $status;
            $task->completion_options_c = $completion;
            $task->deleted = 0;
        }
        // Set assigned_user_id
        $user_id = '';
        if (isset($row['assignedUserUserName'])) {
            if (!empty($row['assignedUserUserName'])) {
                $user_id = getUserIdByUserName($row['assignedUserUserName']);
                $task->assigned_user_id = $user_id;
            }
        }

        $task->assigned_user_id = $user_id;
        if (empty($user_id))
            $task->assigned_user_name = '';
        $task->save();
		if(isset($row['checklistItems'])){
			$checkList = new CGX_CheckList();
			$checkList->saveCheckListOfTask($task->id, $row['checklistItems']);
		}
        return $task->id;
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

function updateOrCreateRoleBasePermission($task_id = null, $role_base_data = array())
{
    if (!$task_id || !$role_base_data) {
        return 0;
    }
    try {
        $user_id = null;
        if (isset($role_base_data['assignedUserUserName'])) {
            if (!empty($role_base_data['assignedUserUserName'])) {
                $user_id = getUserIdByUserName($role_base_data['assignedUserUserName']);
            }
        }
        $role_base_data['task_id'] = $task_id;
        $role_base_data['assigned_user_id'] = $user_id;
        if (isQueueExist($role_base_data['queueId'], $role_base_data['activityId'], $role_base_data['roleName'])) {
            return updateRoleBasePermission($role_base_data);
        } else {
            return createRoleBasePermission($role_base_data);
        }
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * Create new Suite Role if not exist
 * @param $cgx_role
 * @return int|string
 */
function createACLRole($cgx_role)
{
    $acl = new ACLRole();
    try {
        $acl->name = $cgx_role;
        $acl->casegenix_role = $cgx_role;
        $acl->save();
        return $acl->id;
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * @param $data
 * @return int
 */
function createRoleBasePermission($role_base_data)
{
    global $db;
    $role_base_data['selfAssignGranted'] = ($role_base_data['selfAssignGranted']) ? 1 : 0;
    $role_base_data['selfUnassignGranted'] = ($role_base_data['selfUnassignGranted']) ? 1 : 0;
    $role_base_data['userAssignGranted'] = ($role_base_data['userAssignGranted']) ? 1 : 0;
    $role_base_data['userUnassignGranted'] = ($role_base_data['userUnassignGranted']) ? 1 : 0;
    try {
        $value = array($role_base_data['roleName'], $role_base_data['activityId'], $role_base_data['task_id'], $role_base_data['queueId'], $role_base_data['queueName'], $role_base_data['role_id'], $role_base_data['assigned_user_id'], 1, $role_base_data['selfAssignGranted'], $role_base_data['selfUnassignGranted'], $role_base_data['userAssignGranted'], $role_base_data['userUnassignGranted']);
        $value_str = "VALUES('" . implode("','", $value) . "')";
        $query = "INSERT INTO role_based_queue_permission (cgx_role, activity_id, task_id, queue_id, queue_name, role_id, assigned_user_id, view, sa, su, ua, uu) " . $value_str;
        $db->query($query);
        return 1;
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * @param $data
 * @return int
 */
function updateRoleBasePermission($role_base_data)
{
    global $db;
    $role_base_data['selfAssignGranted'] = (isset($role_base_data['selfAssignGranted']) && $role_base_data['selfAssignGranted']) ? 1 : 0;
    $role_base_data['selfUnassignGranted'] = (isset($role_base_data['selfUnassignGranted']) && $role_base_data['selfUnassignGranted']) ? 1 : 0;
    $role_base_data['userAssignGranted'] = (isset($role_base_data['userAssignGranted']) && $role_base_data['userAssignGranted']) ? 1 : 0;
    $role_base_data['userUnassignGranted'] = (isset($role_base_data['userUnassignGranted']) && $role_base_data['userUnassignGranted']) ? 1 : 0;

    try {
        $query = "UPDATE role_based_queue_permission
                  SET sa = '" . $role_base_data['selfAssignGranted'] . "',
                      su = '" . $role_base_data['selfUnassignGranted'] . "',
                      ua = '" . $role_base_data['userAssignGranted'] . "',
                      uu = '" . $role_base_data['userUnassignGranted'] . "',
                      assigned_user_id = '" . $role_base_data['assigned_user_id'] . "'
                  WHERE
                      deleted = 0 AND cgx_role = '" . $role_base_data['roleName'] . "' AND activity_id = '" . $role_base_data['activityId'] . "' AND queue_id = '" . $role_base_data['queueId'] . "'";
        $db->query($query);
        return 1;
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * @param $data
 * @return int
 */
function removeRoleBasePermission($activity_id, $queue_id, $cgx_role)
{
    global $db;
    try {
        $query = "UPDATE role_based_queue_permission SET deleted=1 WHERE activity_id='" . $activity_id . "' AND queue_id='" . $queue_id . "' AND cgx_role='" . $cgx_role . "'";
        $db->query($query);
        return 1;
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * @param $queue_list
 * @return array
 */
function processQueueList($queue_list)
{
    $activity_ids = array();
    if (isset($queue_list['rows']) && !empty($queue_list['rows'])) {
        if (isset($queue_list['rows']['activityId']) && !empty($queue_list['rows']['activityId'])) {
            $row = $queue_list['rows'];
            $activity_id = processQueueData($row);
            if ($activity_id) {
                $activity_ids[] = $activity_id;
            }
        } else {
            foreach ($queue_list['rows'] as $row) {
                $activity_id = processQueueData($row);
                if ($activity_id) {
                    $activity_ids[] = $activity_id;
                }
            }
        }
    }
    return $activity_ids;
}

/**
 * @param $queue_id
 * @param $activity_id
 * @param $cgx_role
 * @return array
 */
function isQueueExist($queue_id, $activity_id, $cgx_role)
{
    global $db;
    $query = "SELECT COUNT(*) FROM role_based_queue_permission WHERE deleted=0 AND queue_id = '" . $queue_id . "' AND activity_id = '" . $activity_id . "' AND cgx_role='" . $cgx_role . "'";
    $count = $db->getOne($query);
    return $count;
}

function processQueueData($queue_data)
{
    $task_id = updateOrCreateTask($queue_data);
    $rbqp = new RoleBasedQueuePermission();
    $queue_data['role_id'] = '';
    if (isset($queue_data['roleName']) && !empty($queue_data['roleName'])) {
        $suite_role_id = $rbqp->checkCGXRoleIsMapped($queue_data['roleName']);
        if (!empty($suite_role_id)) {
            $queue_data['role_id'] = $suite_role_id;
        } else {
            createACLRole($queue_data['roleName']);
        }
    }
    if ($task_id) {
        $success = updateOrCreateRoleBasePermission($task_id, $queue_data);
        if ($success) {
            return $queue_data['activityId'];
        }
    }
    return false;
}

/**
 * @param string $status
 * @return string
 */
function getSuiteCrmTaskStatus($status = 'Created')
{
    $status = trim($status);
    switch ($status) {
        case 'Created':
            return 'created';
        case 'Started':
            return 'started';
        case 'Suspended':
            return 'suspended';
        case 'Completed':
            return 'completed';
        case 'Failed':
            return 'failed_processsing';
        default:
            return 'created';
    }
}

function getUserIdByUserName($user_name)
{
    try {
        $user = new User();
        $user->retrieve_by_string_fields(array('user_name' => $user_name));
        return $user->id;
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return false;
    }
}


