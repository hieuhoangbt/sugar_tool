<?php

require_once('include/MVC/Controller/SugarController.php');
require_once('custom/modules/Tasks/Tasks.php');

/**
 * Tasks controller
 */
class TasksController extends SugarController
{

    /**
     * Override function massupdate - Delete
     * Custom list task_id
     * @return parent method is called
     * @Fixed SE-461
     */
    public function action_massupdate()
    {
        if (!empty($_REQUEST['Delete']) && $_REQUEST['Delete'] == 'true' && ACLController::checkAccess('Tasks', 'delete', true)) {
            $seed = $_REQUEST['module'];
            if (isset($_REQUEST['entire']) && empty($_POST['mass'])) {
                $task = BeanFactory::newBean($seed);
                $db = $GLOBALS['db'];
                $order_by = '';
                $query = $task->create_new_list_query($order_by, '', array(), array(), 0, '', false, $this, true, true);
                $result = $db->query($query, true);
                $new_arr = array();
                while ($val = $db->fetchByAssoc($result, false)) {
                    $task = BeanFactory::getBean($seed, $val['id']);
                    if (trim($task->activity_id_c) == '') {
                        array_push($new_arr, $val['id']);
                    }
                }
                $_POST['mass'] = $_REQUEST['mass'] = $new_arr;
                $_REQUEST['uid'] = implode(",", $new_arr);
            } else {
                $tmp = $_POST['mass'];
                $nArr = array();
                foreach ($tmp as $id) {
                    $task = BeanFactory::getBean($seed, $id);
                    if (trim($task->activity_id_c) == '') {
                        array_push($nArr, $id);
                    }
                }
                $_POST['mass'] = $_REQUEST['mass'] = $nArr;
                $_REQUEST['uid'] = implode(",", $nArr);
            }
        }
        if (empty($_POST['mass'])) {
            $queryParams = array(
                'module' => 'Tasks',
                'action' => 'index'
            );
            return SugarApplication::redirect('index.php?' . http_build_query($queryParams));
        }

        parent::action_massupdate();
    }

    /*
     * Return Data Business Process from Request Ajax to display on TOP Bar
     *
     * @return: json
     */

    public function action_requestBusiness()
    {
        global $current_user;

        require_once("custom/modules/Tasks/TasksModel.php");
        $taskModel = new TasksModel();

        $activityID = $completionOptions = $businessProcessName = $urlBusinessProcess = $parentName = $relateToUrl = $linkToTask = '';
        $startedTask = $taskModel->getStartedTaskByUserId($current_user->id);

        if (!empty($startedTask)) {
            $taskId = !empty($startedTask['id']) ? $startedTask['id'] : '';
            $queueM = $taskModel->getBusinessNameByTaskId($taskId);
            $businessProcessName = !empty($queueM['business_process_name']) ? $queueM['business_process_name'] : '';

            if (!empty($startedTask['parent_type'])) {
                $parentType = $startedTask['parent_type'];
                $bean = BeanFactory::getBean($parentType);
                if (!empty($startedTask['parent_id'])) {
                    $parent = $bean->retrieve($startedTask['parent_id']);
                    if (!empty($parent)) {
                        $parentName = $parent->name;
                        $relateToUrl = "?module={$startedTask['parent_type']}&action=DetailView&record={$startedTask['parent_id']}";
                    }
                }
            }

            require_once("custom/modules/Tasks/Tasks.php");
            $taskM = new TaskCustom();

            $taskObj = $taskM->retrieve($taskId);
            if (!empty($taskObj)) {
                require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');
                $completionOptions = parsecompletionFunction($taskObj->completion_options_c);
            }

            $workflowInstanceId = !empty($taskObj->cgx_wf_id_c) ? $taskObj->cgx_wf_id_c : '';

            require_once('modules/Configurator/Configurator.php');
            $configurator = new Configurator();
            $configurator->loadConfig();

            $urlBusinessProcess = $configurator->config['CGX_API_cgx_public_url'] . '?workflowInstanceId=' . $workflowInstanceId;
            $activityID = !empty($taskObj->activity_id_c) ? $taskObj->activity_id_c : '';
            $linkToTask = "?module=Tasks&action=DetailView&record={$startedTask['id']}";
        }

        $data = [
            'activityID' => $activityID,
            'completionOptions' => $completionOptions,
            'businessProcessName' => $businessProcessName,
            'urlBusinessProcess' => $urlBusinessProcess,
            'parentName' => $parentName,
            'relateToUrl' => $relateToUrl,
            'linkToTask' => $linkToTask,
            'startedTask' => $startedTask,
            'checkListItemsCompleted' => $taskModel->checkListItemsHaveBeenCompleted($taskId) ? 1 : 0,
            'checkListItems' => (count($taskModel->getCheckListItemsByTask($taskId)) > 0) ? $taskModel->getCheckListItemsByTask($taskId) : 0
        ];

        $json = getJSONobj();
        echo $json->encode($data);
        exit();
    }

    /**
     * list view
     */
    public function action_listview()
    {
        $this->bean = new TaskCustom();
        parent::action_listview();
    }

    /**
     * Workflow assign/un-assigned to user by activityId and username
     *
     * ex: {"user_id":"1", "activity_id", "operator":"SA", "task_id":"3"}
     * @return int $status 0:error , 1:success
     */
    public function action_assignment()
    {
        $userId = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
        $activityId = isset($_REQUEST['activity_id']) && $_REQUEST['activity_id'] ? $_REQUEST['activity_id'] : '';
        $operator = isset($_REQUEST['operator']) && $_REQUEST['operator'] ? $_REQUEST['operator'] : '';
        $taskId = isset($_REQUEST['task_id']) && $_REQUEST['task_id'] ? $_REQUEST['task_id'] : '';

        $status = $this->assignment($userId, $activityId, $operator, $taskId);
        echo $status;
        exit();
    }

    /**
     * Defer
     *
     * @return string
     */
    public function action_defer()
    {
        $userId = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
        $activityId = isset($_REQUEST['activity_id']) && $_REQUEST['activity_id'] ? $_REQUEST['activity_id'] : '';
        $taskId = isset($_REQUEST['task_id']) && $_REQUEST['task_id'] ? $_REQUEST['task_id'] : '';
        $data = 0;
        if ($userId && $userId && $activityId) {
            require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
            require_once("TasksModel.php");
            $kit = CGX_Kit_Factory::create("workflow");
            $obj = new TasksModel();
            $username = $obj->findUserNameById($userId);
            if (!empty($username)) {
                $holdOn = $kit->holdActivityFor($username, (int) $activityId);

                if ($holdOn->error == null) {
                    $defer = $obj->updateStatus($taskId, 'suspended', $userId);
                    if ($defer == true) {
                        $data = 1;
                    }
                }
            }
            /**
             * @todo if $data->error == null
             * get model to assign/unassigned task to user
             */
        }
        echo $data;
        exit();
    }

    /**
     * Completion
     *
     */
    function action_completion()
    {
        $userId = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
        $activityId = isset($_REQUEST['activity_id']) && $_REQUEST['activity_id'] ? $_REQUEST['activity_id'] : '';
        $completionOption = isset($_REQUEST['completion_option']) && $_REQUEST['completion_option'] ? $_REQUEST['completion_option'] : '';
        $taskId = isset($_REQUEST['task_id']) && $_REQUEST['task_id'] ? $_REQUEST['task_id'] : '';

        $status = $this->completion($userId, $activityId, $completionOption, $taskId);
        echo $status;
        exit();
    }

    public function suppendOtherTask($taskStarts, $taskM, $username, $userId)
    {
        require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
        $kit = CGX_Kit_Factory::create('workflow');

        $idsError = $ids = array();
        foreach ($taskStarts as $taskStart) {
            $activityIdAssign = !empty($taskStart['activity_id_c']) ? $taskStart['activity_id_c'] : '';
            $holdOn = $kit->holdActivityFor($username, (int) $activityIdAssign);

            if ($holdOn->error != null) {
                $idsError[] = $taskStart['id'];
                continue;
            } else {
                $ids[] = "'" . $taskStart['id'] . "'";
            }
        }
        $listId = implode(',', $ids);
        if (count($idsError)) {
            $GLOBALS['log']->fatal("Can't not holdOn Activity : " . json_encode($idsError, true));
        }
        $updateStatus = $taskM->updateListStatus($listId, $userId);
        return $updateStatus;
    }

    public function action_userAssign()
    {
        $userId = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
        $activityId = isset($_REQUEST['activity_id']) && $_REQUEST['activity_id'] ? $_REQUEST['activity_id'] : '';
        $taskId = isset($_REQUEST['task_id']) && $_REQUEST['task_id'] ? $_REQUEST['task_id'] : '';
        $userAssignId = isset($_REQUEST['assigned_user_id']) && $_REQUEST['assigned_user_id'] ? $_REQUEST['assigned_user_id'] : '';

        $status = $this->assignment_userassign($userId, $activityId, $taskId, $userAssignId);
        echo $status;
        exit();
    }

    public function apiUserAssign($taskId = '', $activityId = '', $userId = '', $userAssignId = '')
    {
        if (empty($userId) || empty($activityId) || empty($taskId) || empty($userAssignId)) {
            return 0;
        }

        require_once('modules/CGX_API/api/CGX_Kit.php');
        require_once('TasksModel.php');
        $kit = new CGX_Kit();
        $obj = new TasksModel();
        $user = new User();
        $user->retrieve($userAssignId);
        if (!$user->id) {
            $GLOBALS['log']->debug("Error update database with user id::" . $userAssignId);
            return 0;
        }

        $res = $kit->getWorkflowAssignUnassignActivityFor($user->user_name, (int) $activityId, 'UA');
        if ($res->error != null) {
            $GLOBALS['log']->debug("Error update database with task id::" . $taskId);
            return 0;
        }

        $assignment = $obj->assignOrUnassignedTaskToUser($taskId, $userId, 'UA', $userAssignId);
        if (!$assignment) {
            $GLOBALS['log']->debug("Error update database with task id::" . $taskId);
            return 0;
        }

        $obj->updatePermissionFlags($activityId);
        $GLOBALS['log']->debug("Call CGX webservice successfully with task id::" . $taskId);

        return 1;
    }

    /*
     * Bulk: Assignment with list task_ids
     */

    public function action_assignmentBulk()
    {
        $userId = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
        $operator = isset($_REQUEST['operator']) && $_REQUEST['operator'] ? $_REQUEST['operator'] : '';
        $taskIds = isset($_REQUEST['task_ids']) && $_REQUEST['task_ids'] ? explode(',', $_REQUEST['task_ids']) : [];

        require_once('TasksModel.php');
        $taskModel = new TasksModel();
        $fails = 0;
        $operator_lower = ($operator == "FF") ? "sa" : strtolower($operator);
        foreach ($taskIds as $taskId) {
            $task = BeanFactory::getBean('Tasks', $taskId);
            $permission = $taskModel->getPermissions($taskId, $userId);
            // check CGX Task
            if (!empty($task->activity_id_c) && $task->status != 'Completed' && !empty($permission) && !empty($permission->$operator_lower)) {
                $res = $this->assignment($userId, $task->activity_id_c, $operator, $taskId);
                if (empty($res))
                    $fails++;
            }
        }

        echo $fails == 0 ? 1 : 0;
        exit();
    }

    /*
     * Assignment for every activity
     * @params $userId
     * @params $activityId
     * @params $operator
     * @params $taskId
     */

    public function assignment($userId, $activityId, $operator, $taskId)
    {
        $status = 0;
        if (empty($userId) || empty($activityId) || empty($operator) || empty($taskId)) {
            return $status;
        }

        require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
        require_once('TasksModel.php');

        $kit = CGX_Kit_Factory::create("workflow");

        /**
         * @todo: get $username from $userId
         */
        $obj = new TasksModel();
        $userName = $obj->findUserNameById($userId);
        if (in_array($operator, array('SA', 'SU', 'UU'))) {
            $res = $kit->assignUnassignActivityFor($userName, (int) $activityId, $operator);

            if ($res->error != null) {
                $GLOBALS['log']->debug("Error call API Casegenix::" . $res->error->Msg);
                return $status;
            }
        }

        // Do the fast forward first
        if ($operator == 'FF') {
            // Selected tasks
            $taskM = new Task();
            $taskM->retrieve($taskId);
            $res = $kit->fastForwardActivity($userName, (int) $activityId);
            if (isset($res->response['checklistItems'])) {
                require_once('modules/CGX_CheckList/CGX_CheckList.php');
                $checkList = new CGX_CheckList();
                $checkList->saveCheckListOfTask($taskId, $res->response['checklistItems']);
            }
            if ($res->error != null) {
                $GLOBALS['log']->debug("Error call API Casegenix::" . $res->error->Msg);
                return $status;
            }
            // get all the other task exclude selected tasks
            $taskStarts = $obj->getStartedTaskEx($userId, $taskId);
            if (count($taskStarts)) {
                $this->suppendOtherTask($taskStarts, $obj, $userName, $userId);
            }

            if (isset($res->response['workflowName'])) {
                $obj->updateWorkFlowName($taskId, $res->response['workflowName']);
            }

            if (empty($res) || $res->error != null) {
                // error
                $GLOBALS['log']->debug("Call CGX webservice fail with user::" . $userName . " & activityID::" . $activityId);
                return $status;
            }
            $GLOBALS['log']->debug("Call CGX webservice successfully with user::" . $userName . " & activityID::" . $activityId);
        }

        $assignment = $obj->assignOrUnassignedTaskToUser($taskId, $userId, $operator);

        if (!$assignment) {
            $GLOBALS['log']->debug("Error update database with TASK ID::" . $taskId);
            return $status;
        }

        return 1;
    }

    /*
     * Bulk : Completion
     */

    public function action_completionBulk()
    {
        $userId = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] ? $_REQUEST['user_id'] : '';
        $completionOption = isset($_REQUEST['completion_option']) && $_REQUEST['completion_option'] ? $_REQUEST['completion_option'] : '';
        $taskIds = isset($_REQUEST['task_ids']) && $_REQUEST['task_ids'] ? explode(',', $_REQUEST['task_ids']) : [];

        require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');
        $fails = 0;
        foreach ($taskIds as $taskId) {
            $task = BeanFactory::getBean('Tasks', $taskId);
            $completionOptions = !empty($task->completion_options_c) ? parsecompletionFunction($task->completion_options_c) : [];

            // check CGX Task
            if (!empty($task->activity_id_c) && $task->status != 'Completed' && in_array($completionOption, $completionOptions)) {
                $res = $this->completion($userId, $task->activity_id_c, $completionOption, $taskId);
                if (empty($res))
                    $fails++;
            }
        }

        echo $fails == 0 ? 1 : 0;
        exit();
    }

    /*
     * Completion for every activity
     * @params $userId
     * @params $activityId
     * @params $completionOption
     * @params $taskId
     */

    public function completion($userId, $activityId, $completionOption, $taskId)
    {
        require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
        require_once('TasksModel.php');
        $taskModel = new TasksModel();
        //  Check all mandatory checklist items have been completed
        if (!$taskModel->checkListItemsHaveBeenCompleted($taskId)) {
            return -1;
        }
        $userName = $taskModel->findUserNameById($userId);
        $queueKit = CGX_Kit_Factory::create('workflow');
        $response = $queueKit->completeActivityFor($userName, $activityId, urlencode($completionOption));

        $responseError = @$response->getError();
        $status = 0;
        if ($responseError) {
            return $status;
        }

        $status = $taskModel->completeTask($taskId, $userId, $activityId, $completionOption);
        return $status;
    }

    /*
     * Bulk: User Assign
     */

    public function action_userAssignBulk()
    {
        global $current_user;
        $userId = $current_user->id;
        $taskIds = isset($_REQUEST['task_ids']) && $_REQUEST['task_ids'] ? explode(',', $_REQUEST['task_ids']) : [];
        $userAssignId = isset($_REQUEST['assigned_user_id']) && $_REQUEST['assigned_user_id'] ? $_REQUEST['assigned_user_id'] : '';

        require_once("custom/modules/Tasks/TasksModel.php");
        require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
        $taskModel = new TasksModel();
        $userKit = CGX_Kit_Factory::create('users');
        $fails = 0;
        foreach ($taskIds as $taskId) {
            $task = BeanFactory::getBean('Tasks', $taskId);

            $permission = $taskModel->getPermissions($taskId, $userId);

            // do only for CGX Task and the status of the task not Completed
            if (!empty($task->activity_id_c) && !empty($permission) && !empty($permission->ua) && $task->status != 'Completed') {
                // list users who are allow to do assignment to the task
                $res = $userKit->findAssigneesFor($task->activity_id_c);
                $listUser = [];
                if ($res->error == null) {
                    $response = $res->response;
                    if (isset($response['users']) && count($response['users'])) {
                        foreach ($response['users'] as $val) {
                            $listUser[] = $val['userName'];
                        }
                    }
                }

                // check userId who allow to do assignment to the task
                if (in_array($current_user->user_name, $listUser)) {
                    $res1 = $this->assignment_userassign($userId, $task->activity_id_c, $taskId, $userAssignId);
                    if (empty($res1))
                        $fails++;
                }
            }
        }

        echo $fails == 0 ? 1 : 0;
        exit();
    }

    /*
     * User assign for every activity
     * @params $userId
     * @params $activityId
     * @params $taskId
     * @params $userAssignId
     */

    public function assignment_userassign($userId, $activityId, $taskId, $userAssignId)
    {
        $status = 0;
        if (empty($userId) || empty($activityId) || empty($taskId) || empty($userAssignId)) {
            return $status;
        }

        require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
        require_once('TasksModel.php');
        $kit = CGX_Kit_Factory::create('workflow');
        $obj = new TasksModel();
        $userM = new User();
        $user = $userM->retrieve($userAssignId);
        if ($user == null) {
            $GLOBALS['log']->debug("Error update database with user id::" . $userAssignId);
            return $status;
        }

        $res = $kit->assignUnassignActivityFor($user->user_name, (int) $activityId, 'UA');
        if ($res->error != null) {
            $GLOBALS['log']->debug("Error update database with task id::" . $taskId);
            return $status;
        }

        $assignment = $obj->assignOrUnassignedTaskToUser($taskId, $userId, 'UA', $userAssignId);
        if (!$assignment) {
            $GLOBALS['log']->debug("Error update database with task id::" . $taskId);
            return $status;
        }

        $GLOBALS['log']->debug("Call CGX webservice successfully with task id::" . $taskId);
        return 1;
    }

    /*
     * This function using to update check list info by task
     */

    public function action_updateCheckListItem()
    {
        global $timedate, $current_user;
        $item_id = $_POST['item_id'];
        if (!empty($item_id)) {
            $check_list = new CGX_CheckList();
            $check_list->retrieve($item_id);
            $check_list->completed_on = ($_POST['mandatory']) ? $timedate->nowDb() : '';
            $check_list->completed_by = ($_POST['mandatory']) ? $current_user->id : '';
            $check_list->save();
            echo 1;
        } else {
            echo 0;
        }
    }

}
