<?php
/**
 * Create message
 * @params: queue data
 * Flow:
 * If note found the CGX Role mapped in SuiteCRM then add new ACLRole map to the CGX Role
 */
function createMessage($data)
{
    return true;
}

/**
 * Update message
 * @params:
 */
function updateMessage($data)
{
    return true;
}

/**
 * Remove message
 * @params:
 * @return task id
 */
function deleteMessage($data)
{
    // Update task to completed if completion option not empty
    if(!empty($data['completion_option'])) {
        $task = new Task();
        $task->retrieve_by_string_fields(array('activity_id_c' => $data['activity_id']));
        $task->status = "completed";
        $task->completion_options_c = $data['completion'];
        $task->save();
        // Remove all records by task, queue and CGX Role
        $params = array(
            'task_id' => $task->id,
            'cgx_role' => $data['cgx_role'],
            'queue_id' => $data['queue_id']
        );
        removeRoleBasePermission($params);
    }
}

/*
 * Create new task
 * @params: $data = array()
 * @return: int | string
 */
function createTask($data)
{
    try {
        $task = new Task();
        $task->name = trim($data['activityDescription']);
        $task->activity_id_c = $data['activityId'];
        $task->cgx_wf_id_c = $data['work_flow_id'];
        $task->parent_type = $data['parent_type'];
        $task->parent_id = $data['parent_id'];
        $task->status = "created";
        $task->completion_options_c = $data['completion'];
        $task->assigned_user_id = $data['assigned_user_id'];
        $task->save();
        return $task->id;
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
        $acl->save();
        return $acl->id;
    }
    catch(Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * @param $data
 * @return int
 */
function createRoleBasePermission($data)
{
    global $db;
    try {
        $value = array($data['cgx_role'], $data['activity_id'], $data['task_id'], $data['queue_id'], $data['queue_name'], $data['role_id'], $data['assigned_user_id'], $data['view'], $data['sa'], $data['su'], $data['ua'], $data['uu']);
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
function updateRoleBasePermission($data)
{
    global $db;
    try {
        $query = "UPDATE role_based_queue_permission 
                  SET sa = '" . $data['sa'] . "',
                      su = '" . $data['su'] . "',
                      ua = '" . $data['ua'] . "',
                      uu = '" . $data['uu'] . "' 
                  WHERE
                      cgx_role = '" . $data['cgx_role'] ."' AND task_id = '" . $data['task_id'] . "' AND queue_id = '" . $data['queue_id'] . "'";
        $db->query($query);
        return 1;
    }
    catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}

/**
 * @param $data
 * @return int
 */
function removeRoleBasePermission($data) {
    global $db;
    try {
        $query = "DELETE FROM role_based_queue_permission WHERE task_id='" . $data ['task_id'] . "' AND queue_id='" . $data['queue_id'] . "' AND cgx_role='" . $data['cgx_role'] . "'";
        $db->query($query);
        return 1;
    }
    catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
        return 0;
    }
}
