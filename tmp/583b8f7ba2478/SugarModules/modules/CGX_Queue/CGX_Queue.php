<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/CGX_Queue/CGX_Queue_sugar.php');
require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');
require_once('custom/modules/Tasks/TasksModel.php');

class CGX_Queue extends CGX_Queue_sugar
{
    /**
     * Override : Prepare data of list view
     *
     * @global type $current_user
     * @return string
     */
    public function get_list_view_data()
    {
        global $current_user, $mod_strings, $app_list_strings;

        $row_data = parent::get_list_view_data(); //let it work as it does by default
        $assignments = $completionOptions = array();
        $userId = $activityId = $taskId = null;
        $parentType = $parentId = null;
        if (!empty($row_data['ID'])) {
            try {
                $queue = new CGX_Queue();
                $queue->retrieve_by_string_fields(array('id' => $row_data['ID']));

                if (!empty($queue)) {
                    if (!empty($queue->task_id_c)) {
                        $taskModel = new TasksModel();
                        $task = $taskModel->getTaskById($queue->task_id_c);

                        if (!empty($task)) {
                            $row_data['PARENT_TYPE_C'] = isset($app_list_strings['parent_type_display'][$task->parent_type]) ? $app_list_strings['parent_type_display'][$task->parent_type] : '';
                            $row_data['PARENT_NAME_C'] = '';
                            if (!empty($task->parent_id)) {
                                $taskParent = BeanFactory::getBean("{$task->parent_type}", $task->parent_id);
                                if (!empty($taskParent->name)) {
                                    $row_data['PARENT_NAME_C'] = '<a href="index.php?module='. $task->parent_type .'&action=DetailView&record=' . $task->parent_id . '">' . $taskParent->name . '</a>';
                                }
                            }

                            if (!empty($task->assigned_user_id)) {
                                $user_assigned = new User();
                                $user_assigned->retrieve($task->assigned_user_id);

                                if (!empty($user_assigned) && !empty($user_assigned->id)) {
                                    $row_data['ASSIGNED_USER_NAME'] =  $user_assigned->first_name . ' ' . $user_assigned->last_name;
                                    $row_data['ASSIGNED_USER_ID'] = $user_assigned->id;
                                }
                            } else {
                                $row_data['ASSIGNED_USER_NAME'] = '';
                            }

                            $userId = $task->assigned_user_id;
                            $activityId = $task->activity_id_c;
                            $taskId = $task->id;
                            $parentType = $task->parent_type;
                            $parentId = $task->parent_id;

                            if (!empty($task->completion_options_c)) {
                                $completionOptions = parsecompletionFunction($task->completion_options_c);
                            }
                        }

                        $queueName = !empty($queue->queue_name) ? array_unique(parsecompletionFunction($queue->queue_name)) : array();
                        $row_data['QUEUES_C'] = is_array($queueName) && !empty($queueName) ? implode(', ', $queueName) : '';

                        if (!empty($queue->sa) || $current_user->id == $userId) {
                            $assignments['FF'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_FF'];
                        }
                        if (!empty($queue->sa)) {
                            $assignments['SA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SA'];
                        }
                        if (!empty($queue->su)) {
                            $assignments['SU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SU'];
                        }
                        if (!empty($queue->ua)) {
                            $assignments['UA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UA'];
                        }
                        if (!empty($queue->uu)) {
                            $assignments['UU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UU'];
                        }
                    }
                }

            } catch (Exception $ex) {
                $GLOBALS['log']->debug($ex->getMessage());
            }
        }

        // dropdown actions
        $liSubMenuAssignment = $liSubMenuCompletion = $dropdownAssignment = $dropdownCompletion = '';
        if (!empty($assignments)) {
            $dropdownAssignment = '<ul class="dropdown-menu" data-taskid="' . $taskId . '" data-activityid="' . $activityId . '" data-userid="' . $current_user->id . '" data-parenttype="'. $parentType .'" data-parentid="' . $parentId .'" >';

            $popup = " if(typeof win != 'undefined'){win.close();}; open_popup( 'Users', 600, 400, '&genix_custom=1&activity_id={$activityId}', true, false, {'call_back_function': 'set_return_cgx_user_assign', 'field_to_name_array': {'id':'assigned_user_id','user_name':'assigned_user_name'}, 'passthru_data': {'activity_id' : '{$activityId}', 'current_user_id': '{$current_user->id}', 'task_id': '{$taskId}' }}, 'single',true, false);";
            foreach ($assignments as $key => $assignment) {
                if ($key == 'UA') {
                    $dropdownAssignment .= '<li><a href="javascript:void(0);" onclick="' . $popup . '" data-assignment="' . $key . '" >' . $assignment . '</a></li>';
                }else{
                    $dropdownAssignment .= '<li><a href="javascript:void(0);" class="actionAssignment" data-assignment="' . $key . '" >' . $assignment . '</a></li>';
                }
            }
            $dropdownAssignment .= '</ul>';
            $liSubMenuAssignment = !empty($dropdownAssignment) ? 'class="dropdown-submenu"' : "";
        }

        if (!empty($completionOptions)) {
            $dropdownCompletion = '<ul class="dropdown-menu" data-taskid="' . $taskId . '" data-activityid="' . $activityId . '" data-userid="' . $current_user->id . '">';
            foreach ($completionOptions as $completion) {
                $dropdownCompletion .= '<li><a href="javascript:void(0);" class="actionCompletion" data-completion="' . $completion . '" >' . $completion . '</a></li>';
            }
            $dropdownCompletion .= '</ul>';
            $liSubMenuCompletion = !empty($dropdownCompletion) ? 'class="dropdown-submenu"' : "";
        }

        if(!empty($assignments) || !empty($completionOptions)){
            $dropdownActions = '<div class="dropdown">
                    <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">' . $mod_strings['LBL_QUEUES_ACTION'] .' <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">';
            $dropdownActions .= !empty($assignments) ? '<li ' . $liSubMenuAssignment . '><a href="javascript:void(0);">Assignment</a>' . $dropdownAssignment . '</li>' : '';
            $dropdownActions .=!empty($completionOptions) ?
                '<li ' . $liSubMenuCompletion . '><a tabindex="-1" href="javascript:void(0);">Completion</a>' . $dropdownCompletion . '</li>' : '';
            $dropdownActions .= ' </ul></div>';
        }else{
            $dropdownActions = $mod_strings['LBL_QUEUES_ACTION'];
        }

        $row_data['ACTIONS_C'] = !empty($dropdownActions) ? $dropdownActions : '';

        return $row_data;
    }
}
