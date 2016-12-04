<?php

/**
 * Task model for Tasks
 */
class TasksModel
{

    public $_db;

    /**
     * Construction
     *
     * @global type $db
     */
    public function __construct()
    {
        global $db;
        $this->_db = $db;
    }

    /*
     * get role_ids of the user
     * @params $user_id
     * @return Array  $user_role_ids
     */
    public function getAllRoleIds($user_id)
    {
        $user_roles = BeanFactory::getBean('ACLRoles')->getUserRoles($user_id, false);
        $user_role_ids = [];
        foreach ($user_roles as $user_role) {
            $user_role_ids[] = $user_role->id;
        }
        return $user_role_ids;
    }

    /*
     * get all task allowed display in List View
     * @params $user_id
     * @return Array $task_ids
     */
    public function getAllTasksHasViewPermission($user_id)
    {
        // get role_ids of the user
        $user_role_ids = $this->getAllRoleIds($user_id);
        $user_role_ids = !empty($user_role_ids) ? '"' . implode('","', $user_role_ids) . '"' : '""';

        $task_ids = [];
        $query = 'SELECT task_id, assigned_user_id, SUM(view) AS view, SUM(sa) AS SA, SUM(su) AS SU, SUM(ua) AS UA, SUM(uu) AS UU
                    FROM role_based_queue_permission
                    WHERE role_id IN (' . $user_role_ids . ') AND role_id != ""
                    GROUP BY task_id, assigned_user_id
                    HAVING view > 0 OR SA > 0 OR SU > 0 OR UA > 0 OR UU > 0 ';
        $result = $this->_db->query($query);
        while ($row = $this->_db->fetchByAssoc($result)) {
            $task_ids[] = $row['task_id'];
        }

        return $task_ids;
    }

    /*
     * get permission of the task of the user
     * @params String $taskId
     * @params String $userId
     * @return Object or Null
     */
    public function getPermissions($taskId, $user_id)
    {
        // get role_ids of the user
        $user_role_ids = $this->getAllRoleIds($user_id);
        $user_role_ids = !empty($user_role_ids) ? '"' . implode('","', $user_role_ids) . '"' : '""';

        $query = 'SELECT SUM(sa) AS SA, SUM(su) AS SU, SUM(ua) AS UA, SUM(uu) AS UU
                  FROM role_based_queue_permission
                  WHERE ( (task_id = "' . $taskId  .'" AND role_id IN (' . $user_role_ids . ') AND role_id != "") 
                        OR (task_id = "' . $taskId  .'" AND assigned_user_id = "'. $user_id .'") ) AND deleted = 0
                  GROUP BY task_id';
        $row = $this->_db->fetchOne($query);
        if (!empty($row)) {
            $permission = new stdClass();
            $permission->sa = $row['SA'];
            $permission->su = $row['SU'];
            $permission->ua = $row['UA'];
            $permission->uu = $row['UU'];
            return $permission;
        }
        return null;
    }

    /*
     * get all queues name of the task
     * @params String $taskId
     * @return String  - implode queues name
     */
    public function getQueuesName($taskId)
    {
        $queue_names = [];
        $query = "SELECT queue_name FROM role_based_queue_permission WHERE task_id = '" . $taskId . "'";
        $res = $this->_db->query($query);
        while ($row = $this->_db->fetchByAssoc($res)) {
            $queue_names[] = $row['queue_name'];
        }
        $queue_names = array_unique($queue_names);
        return implode(',', $queue_names);
    }

    /*
     * check Task CGX
     * @params String $taskId
     * @return boolean - true (CGX Task) - false (not CGX Task)
     */
    public function isTaskCGX($taskId)
    {
        $query = "SELECT * FROM role_based_queue_permission WHERE task_id = '$taskId' LIMIT 1";
        $row = $this->_db->fetchOne($query);
        return !empty($row) ? true : false;
    }

    /*
     * get all completions
     * @return Array
     */
    public function getAllCompletions()
    {
        $completion_options = [];
        $query = "SELECT completion_options_c FROM  tasks INNER JOIN  tasks_cstm ON tasks.id =  tasks_cstm.id_c WHERE deleted = 0 GROUP BY completion_options_c";
        $res = $this->_db->query($query);
        while ($row = $this->_db->fetchByAssoc($res)) {
            $completion_options =  array_merge($completion_options, unencodeMultienum($row['completion_options_c']));
        }

        return array_unique($completion_options);
    }

    /*
     * delete queue permission records
     * @params String $taskId
     */
    public function deleteQueuePermissionRecords($taskId)
    {
        $query = "UPDATE role_based_queue_permission SET deleted = 1 WHERE task_id = '$taskId'";
        $this->_db->query($query);
    }

    /**
     * Find User name by ID
     * @param integer $userId
     * @return array
     */
    public function findUserNameById($userId)
    {
        $user = array();
        if (!empty($userId)) {
            $query = "SELECT user_name "
                    . "FROM users "
                    . "WHERE id = '{$userId}'";
            $res = $this->_db->query($query);
            $user = $this->_db->fetchByAssoc($res);
        }
        $username = !empty($user['user_name']) ? $user['user_name'] : '';
        return $username;
    }

    /**
     *
     * @param type $userId
     * @return type
     */
    public function getStartedTaskByUserId($userId)
    {
        $task = array();
        if (!empty($userId)) {
            $query = "SELECT tasks.*
                    FROM  tasks
                    LEFT JOIN  tasks_cstm ON  tasks.id =  tasks_cstm.id_c
                    WHERE  deleted =0
                    AND  assigned_user_id = '{$userId}'
                    AND  status LIKE  '%started%'
                    ORDER BY  tasks_cstm.activity_id_c DESC";
            $res = $this->_db->query($query);
            $task = $this->_db->fetchByAssoc($res);
        }
        return $task;
    }

    /**
     * Assign or Unassigned task to user
     * @param string $taskId
     * @param integer $userId
     * @return bool|resource
     */
    public function assignOrUnassignedTaskToUser($taskId, $userId, $operator, $userAssignedId = null)
    {
        $res = false;
        $userAssignedId = $userAssignedId != null ? $userAssignedId : $userId;

        require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');
        $currentDate = getCurrentDate();
        if (!empty($taskId) && !empty($userId) && !empty($operator)) {
            if ($operator == 'SA' || $operator == 'UA') {
                $query = "UPDATE tasks "
                        . "SET "
                        . "modified_user_id='{$userId}',"
                        . "assigned_user_id='{$userAssignedId}',"
                        . "date_modified='{$currentDate}',"
                        . "deleted='0',"
                        . "status='created' "
                        . "WHERE id = '{$taskId}'";
            }
            if ($operator == 'SU' || $operator == 'UU') {
                $query = "UPDATE tasks "
                        . "SET "
                        . "modified_user_id='{$userId}',"
                        . "assigned_user_id = NULL, "
                        . "date_modified='{$currentDate}', "
                        . "status='suspended' "
                        . "WHERE id = '{$taskId}'";
            }
            if ($operator == 'FF') {
                $query = "UPDATE tasks "
                        . "SET "
                        . "modified_user_id='{$userId}',"
                        . "assigned_user_id='{$userAssignedId}',"
                        . "date_modified='{$currentDate}',"
                        . "deleted='0',"
                        . "status='started' "
                        . "WHERE id = '{$taskId}'";
            }

            $res = $this->_db->query($query);
        }
        return (boolean) $res;
    }

    /**
     *
     * @global type $timedate
     * @param type $id
     * @param type $status
     * @param type $modified_by
     * @return type
     */
    public function updateStatus($id, $status, $modified_by)
    {
        global $timedate;
        $CurrenrDateTime = $timedate->getInstance()->nowDb();
        $res = false;
        if (!empty($id) && !empty($status) && !empty($modified_by)) {
            $query = "UPDATE tasks SET status = '{$status}',"
                    . "date_modified = '{$CurrenrDateTime}',"
                    . " modified_user_id = '{$modified_by}'"
                    . " WHERE id='{$id}'";
            $res = $this->_db->query($query);
        }
        return $res;
    }

    /**
     * get Activity by Task Id
     * @param string $taskId
     * @return boolean
     */
    public function getAtivityByTaskId($taskId = null)
    {
        if (!$taskId) {
            return false;
        }
        try {
            $sqlQuery = "SELECT activity_id_c FROM tasks_cstm WHERE id_c = '{$taskId}'";
            $result = $this->_db->query($sqlQuery);
            $data = $this->_db->fetchByAssoc($result);
            return isset($data['activity_id_c']) ? $data['activity_id_c'] : false;
        } catch (Exception $e) {
            $GLOBALS['log']->debug($e->getMessage());
            return false;
        }
    }
     /**
      *
      * @param type $userId
      * @param type $taskId
      * @return type
      */
    public function getStartedTaskEx($userId, $taskId)
    {
        $tasks = array();
        if (!empty($userId) && !empty($taskId)) {
            $query = "SELECT *
                    FROM  tasks
                    LEFT JOIN  tasks_cstm ON  tasks.id =  tasks_cstm.id_c
                    WHERE  assigned_user_id = '{$userId}'
                    AND  status = 'started'
                    AND deleted = 0
                    AND tasks.id <> '{$taskId}'";
            $res = $this->_db->query($query);
            while ($task = $this->_db->fetchByAssoc($res)) {
                $tasks[] = $task;
            }
        }
        return $tasks;
    }
     /**
      *
      * @param type $list
      * @return type
      */
    public function updateListStatus($list, $modified_id)
    {
        global $timedate;
        $CurrenrDateTime = $timedate->getInstance()->nowDb();
        if (empty($list) || empty($modified_id)) {
            return false;
        }

        $query = "UPDATE tasks SET status = 'suspended',"
                . "date_modified = '{$CurrenrDateTime}',"
                . "modified_user_id = '{$modified_id}' "
                . "WHERE id IN ($list)";
        $res = $this->_db->query($query);

        return (boolean) $res;
    }


    /**
     * complete a task
     * @param type $taskId
     * @param type $userId
     */
    public function completeTask($taskId, $userId, $activityId, $completionOption)
    {
        require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');
        $currentDate = getCurrentDate();
        $updateSqlTask = "UPDATE tasks SET status = 'completed', date_modified = '{$currentDate}', modified_user_id = '{$userId}' WHERE id='{$taskId}'";
        $this->_db->query($updateSqlTask);
        $updateSqlTaskCustom = "UPDATE tasks_cstm SET selected_completion_option_c = '{$completionOption}' WHERE id_c='{$taskId}'";
        $this->_db->query($updateSqlTaskCustom);

        $query = "UPDATE role_based_queue_permission SET deleted = 1 WHERE task_id = '$taskId'";
        $this->_db->query($query);

        return 1;
    }
    public function updateWorkFlowName($task_id, $work_name) {
        $sql_update = "UPDATE role_based_queue_permission SET workflow_name = '{$work_name}' WHERE deleted = 0 AND task_id='{$task_id}'";
        $rs = $GLOBALS['db']->query($sql_update);
        return $rs;
    }
    public function getBusinessNameByTaskId($taskId) {
        $task = array();
        if (!empty($taskId)) {
            $query = "SELECT workflow_name AS business_process_name
                    FROM role_based_queue_permission
                    WHERE task_id = '{$taskId}'";
            $res = $this->_db->query($query);
            $task = $this->_db->fetchByAssoc($res);
        }
        return $task;
    }
    function checkListItemsHaveBeenCompleted($task_id)
    {
        if (!empty($task_id)) {
            $task = new Task();
            $task->retrieve($task_id);
            $task->load_relationship('cgx_checklist_tasks');
            $check_list_items = $task->cgx_checklist_tasks->getBeans();
            foreach ($check_list_items as $item) {
                if (empty($item->completed_on) && $item->mandatory) {
                    return false;
                }
            }
            return true;
        } else {
            $GLOBALS['log']->debug('Task ' . $task_id . 'does not exist');
            return fasle;
        }
    }

    function getCheckListItemsByTask($task_id) {
        $check_list_items = array();
        $task = new Task();
        $task->retrieve($task_id);
        $task->load_relationship('cgx_checklist_tasks');
        $check_list_beans = $task->cgx_checklist_tasks->getBeans();
        if(count($check_list_beans) > 0) {
            foreach($check_list_beans as $item_bean) {
                $check_list_items[] = array(
                    'id' => $item_bean->id,
                    'mandatory' => $item_bean->mandatory,
                    'name' => $item_bean->name,
                    'description' => $item_bean->description,
                    'completed_on' => (!empty($item_bean->completed_on)) ? 1 : 0
                );
            }
        }
        return $check_list_items;
    }

    function updateStatusAllCGXTask() {
        $sql = "UPDATE tasks
                SET STATUS = 'completed'
                WHERE
                    tasks.deleted = 0
                AND STATUS <> 'completed'
                AND tasks.id IN (
                    SELECT
                        tasks_cstm.id_c
                    FROM
                        tasks_cstm
                    WHERE
                        tasks_cstm.activity_id_c IS NOT NULL
                )";
        $GLOBALS['db']->query($sql);
    }
}
