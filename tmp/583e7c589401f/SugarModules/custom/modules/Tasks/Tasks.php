<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once("modules/Tasks/Task.php");
require_once("custom/modules/Tasks/TasksModel.php");

/**
 * TaskCustom overwrite Task
 */
class TaskCustom extends Task {

    /**
     * Prepare data of list view
     *
     * @global type $current_user
     * @return string
     */
    public function get_list_view_data() {
        global $mod_strings, $app_list_strings;

        $temp_array = parent::get_list_view_data(); //let it work as it does by default
        //now do our customization
        global $current_user;
        $assignments = $completionOptions = array();
        $taskId = $activityId = $userId = 0;
        $parentType = $parentId = null;
        if (!empty($temp_array['ID'])) {
            try {
                require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');
                $tasks = new Task();
                $tasks->retrieve($temp_array['ID']);
                if (!empty($tasks->completion_options_c)) {
                    $completionOptions = parsecompletionFunction($tasks->completion_options_c);
                }
                if (!empty($tasks->id)) {
                    $taskId = $tasks->id;
                }
                if (!empty($tasks->activity_id_c)) {
                    $activityId = $tasks->activity_id_c;
                }

                if (!empty($tasks->assigned_user_id)) {
                    $userId = $tasks->assigned_user_id;
                }

                $parentType = !empty($tasks->parent_type) ? $tasks->parent_type : null;
                $parentId = !empty($tasks->parent_id) ? $tasks->parent_id : null;

                require_once("TasksModel.php");
                $taskModel = new TasksModel();
                $permission = $taskModel->getPermissions($temp_array['ID'], $current_user->id);
                if (!empty($permission)) {
                    if (!empty($permission->sa)) {
                        $assignments['FF'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_FF'];
                    }
                    if (!empty($permission->sa) && (int) $userId === 0) {
                        $assignments['SA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SA'];
                    }
                    if (!empty($permission->su) && $userId == $current_user->id) {
                        $assignments['SU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SU'];
                    }
                    if (!empty($permission->ua) && (int) $userId === 0) {
                        $assignments['UA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UA'];
                    }
                    if (!empty($permission->uu) && $userId != $current_user->id && (int)$userId > 0) {
                        $assignments['UU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UU'];
                    }
                }
            } catch (Exception $ex) {
                $GLOBALS['log']->debug($ex->getMessage());
            }
        }
        //$temp_array['PARENT_TYPE'] = isset($app_list_strings['parent_type_display'][$temp_array['PARENT_TYPE']]) ? $app_list_strings['parent_type_display'][$temp_array['PARENT_TYPE']] : '';
        $temp_array['PARENT_NAME'] = !empty($temp_array['PARENT_NAME']) ? $temp_array['PARENT_NAME'] : '';

        if ($temp_array['STATUS'] != 'Completed') {
            if (empty($temp_array['ACTIONS_C'])) {
                $liSubMenuAssignment = $liSubMenuCompletion = $dropdownAssignment = $dropdownCompletion = '';
                if (!empty($assignments)) {
                    $dropdownAssignment = '<ul class="dropdown-menu" data-taskid="' . $taskId . '" data-activityid="' . $activityId . '" data-userid="' . $current_user->id . '" data-parenttype="' . $parentType . '" data-parentid="' . $parentId . '" >';

                    $popup = " if(typeof win != 'undefined'){win.close();}; open_popup( 'Users', 600, 400, '&genix_custom=1&activity_id={$activityId}', true, false, {'call_back_function': 'set_return_cgx_user_assign', 'field_to_name_array': {'id':'assigned_user_id','user_name':'assigned_user_name'}, 'passthru_data': {'activity_id' : '{$activityId}', 'current_user_id': '{$current_user->id}', 'task_id': '{$taskId}' }}, 'single',true, false);";
                    foreach ($assignments as $key => $assignment) {
                        if ($key == 'UA') {
                            $dropdownAssignment .= '<li><a href="javascript:void(0);" onclick="' . $popup . '" data-assignment="' . $key . '" >' . $assignment . '</a></li>';
                        } else {
                            $dropdownAssignment .= '<li><a href="javascript:void(0);" class="actionAssignment" data-assignment="' . $key . '" >' . $assignment . '</a></li>';
                        }
                    }
                    $dropdownAssignment .='</ul>';
                    $liSubMenuAssignment = !empty($dropdownAssignment) ? 'class="dropdown-submenu"' : "";
                }
                if (!empty($completionOptions)) {
                    $dropdownCompletion = '<ul class="dropdown-menu" data-taskid="' . $taskId . '" data-activityid="' . $activityId . '" data-userid="' . $current_user->id . '" >';
                    foreach ($completionOptions as $completion) {
                        $dropdownCompletion .= '<li><a href="javascript:void(0);" class="actionCompletion" data-completion="' . $completion . '" >' . $completion . '</a></li>';
                    }
                    $dropdownCompletion .= '</ul>';
                    $liSubMenuCompletion = !empty($dropdownCompletion) ? 'class="dropdown-submenu"' : "";
                }
                if (!empty($assignments) || !empty($completionOptions)) {
                    $dropdownActions = '<div class="dropdown">
                    <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">' . $mod_strings['LBL_ACTION_DROP_DOWN'] . ' <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">';
                    $dropdownActions .=!empty($assignments) ? '<li ' . $liSubMenuAssignment . '><a href="javascript:void(0);">Assignment</a>' . $dropdownAssignment . '</li>' : '';
                    $dropdownActions .=!empty($completionOptions) ?
                            '<li ' . $liSubMenuCompletion . '><a tabindex="-1" href="javascript:void(0);">Completion</a>' . $dropdownCompletion . '</li>' : '';
                    $dropdownActions .= ' </ul></div>';
                } else {
                    $dropdownActions = '';
                }
                /*if (in_array('CGX_Queue', $GLOBALS['moduleList'])) {
                    $temp_array['ACTIONS_C'] = !empty($dropdownActions) ? $dropdownActions : '';
                }*/
                $temp_array['ACTIONS_C'] = !empty($dropdownActions) ? $dropdownActions : '';
            }
        }
        if (empty($temp_array['QUEUES_C'])) {
            require_once("TasksModel.php");
            $taskModel = new TasksModel();
            $queueName = $taskModel->getQueuesName($temp_array['ID']);
            $temp_array['QUEUES_C'] = $queueName;
        }
        return $temp_array;
    }

}
