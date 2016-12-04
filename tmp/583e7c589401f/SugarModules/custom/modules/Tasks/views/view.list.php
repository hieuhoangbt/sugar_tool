<?php

require_once("custom/modules/Tasks/TasksModel.php");

class TasksViewList extends ViewList {

    /**
     * Process data of view
     *
     * @return type
     */
    public function listViewProcess()
    {
        // filter visible for a user via Task List CGX .
        global $current_user;

        // list task_ids allowed view by User
        $taskModel = new TasksModel();
        $task_ids = $taskModel->getAllTasksHasViewPermission($current_user->id);
        $task_ids = !empty($task_ids) ? '"' . implode('","', $task_ids) . '"' : '""';

        if (!is_admin($current_user)) {
            $this->params['custom_where'] = ' 
            AND (
                tasks_cstm.activity_id_c is NULL 
                OR (tasks_cstm.activity_id_c is NOT NULL 
                    AND ( tasks.assigned_user_id = "' . $current_user->id . '" OR ( tasks.id IN ('. $task_ids .') ) 
                    )
                ) 
            
            )';
        }
        // end filter

        $this->processSearchForm();
        $this->lv->searchColumns = $this->searchForm->searchColumns;
        if (!$this->headers) {
            return;
        }
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->ss->assign("SEARCH", true);
            $this->lv->multiSelect = true; //This removes Check Box
            $this->lv->quickViewLinks = true; //This removes Edit Link
            $this->lv->setup($this->seed, 'custom/modules/Tasks/tpls/ListViewTasks.tpl', $this->where, $this->params);

            $listQueue = array();
            if (isset($this->lv->data['pageData']['idIndex']) && is_array($this->lv->data['pageData']['idIndex'])) {
                $taskModel = new TasksModel();
                foreach ($this->lv->data['pageData']['idIndex'] as $taskId => $task) {
                    $isTaskCGX = $taskModel->isTaskCGX($taskId);
                    $listQueue[$taskId] = $isTaskCGX;
                }
            }
            $this->lv->ss->assign("queue_list", $listQueue);

            echo $this->lv->display();
        }
    }

}
