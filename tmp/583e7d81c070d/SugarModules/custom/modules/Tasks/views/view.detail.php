<?php

require_once("custom/modules/Tasks/TasksModel.php");
require_once('custom/modules/Tasks/Utils/custom_utils.ext.php');

/**
 * View of list task
 */
class TasksViewDetail extends ViewDetail {

    /**
     * Reused parent
     */
    public function TasksViewDetail()
    {
        parent::ViewDetail();
    }

    /**
     * @see SugarView::display()
     *
     * We are overridding the display method to manipulate the portal information.
     * If portal is not enabled then don't show the portal fields.
     */
    public function display()
    {
        global $current_user, $app_list_strings;
        if (!empty($this->bean)) {
            $taskId = $activityId = $userId = 0;
            if (!empty($this->bean->id)) {
                try {
                    if (!empty($this->bean->completion_options_c)) {
                        $completionOptions = parsecompletionFunction($this->bean->completion_options_c);
                    }
                    if (!empty($this->bean->id)) {
                        $taskId = $this->bean->id;
                    }
                    if (!empty($this->bean->activity_id_c)) {
                        $activityId = $this->bean->activity_id_c;
                    }

                    if (!empty($this->bean->assigned_user_id)) {
                        $userId = $this->bean->assigned_user_id;
                    }
                    $parentType = !empty($this->bean->parent_type) ? $this->bean->parent_type : null;
                    $parentId = !empty($this->bean->parent_id) ? $this->bean->parent_id : null;

                    $taskModel = new TasksModel();
                    $permission = $taskModel->getPermissions($this->bean->id, $current_user->id);
                    if (!empty($permission)) {
                        if (!empty($permission->sa) || $current_user->id == $userId) {
                            $assignments['FF'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_FF'];
                        }
                        if (!empty($permission->sa)) {
                            $assignments['SA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SA'];
                        }
                        if (!empty($permission->su)) {
                            $assignments['SU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SU'];
                        }
                        if (!empty($permission->ua)) {
                            $assignments['UA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UA'];
                        }
                        if (!empty($permission->uu)) {
                            $assignments['UU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UU'];
                        }
                    }
                } catch (Exception $ex) {
                    $GLOBALS['log']->fatal($ex->getMessage());
                }
            }

            $dropdownAssignment = $dropdownCompletion = '';
            if (!empty($assignments)) {
                $dropdownAssignment = '<a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">Assignment</a>'
                        . '<ul class="dropdown-menu" data-taskid="' . $taskId . '" data-activityid="' . $activityId . '" data-userid="' . $current_user->id . '" data-parenttype="' . $parentType . '" data-parentid="' . $parentId . '" >';
                $popup = " if(typeof win != 'undefined'){win.close();}; open_popup( 'Users', 600, 400, '&genix_custom=1&activity_id={$activityId}', true, false, {'call_back_function': 'set_return_cgx_user_assign', 'field_to_name_array': {'id':'assigned_user_id','user_name':'assigned_user_name'}, 'passthru_data': {'activity_id' : '{$activityId}', 'current_user_id': '{$current_user->id}', 'task_id': '{$taskId}' }}, 'single',true, false);";
                foreach ($assignments as $key => $assignment) {
                    $dropdownAssignment .= '<li>';
                    if ($key == 'UA') {
                        $dropdownAssignment .= '<a href="javascript:void(0);" onclick="' . $popup . '" data-assignment="' . $key . '" >' . $assignment . '</a>';
                    } else {
                        $dropdownAssignment .= '<a href="javascript:void(0);" class="actionAssignment" data-assignment="' . $key . '" >' . $assignment . '</a>';
                    }
                    $dropdownAssignment .= '</li>';
                }
                $dropdownAssignment .= '</ul>';
            }
            if ($this->bean->status != 'completed') {
                if (!empty($completionOptions)) {
                    $dropdownCompletion = '<a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">Completion</a>'
                            . '<ul class="dropdown-menu" data-taskid="' . $taskId . '" data-activityid="' . $activityId . '" data-userid="' . $current_user->id . '" >';
                    foreach ($completionOptions as $completion) {
                        $dropdownCompletion .= '<li><a href="javascript:void(0);" class="actionCompletion" data-completion="' . $completion . '" >' . $completion . '</a></li>';
                    }
                    $dropdownCompletion .= '</ul>';
                }
            }

            if (in_array('CGX_Queue', $GLOBALS['moduleList'])) {
                $this->ss->assign("dropdownAssignment", $dropdownAssignment);
                $this->ss->assign("dropdownCompletion", $dropdownCompletion);
            }

            //Url Business Process
            $workflowInstanceId = !empty($this->bean->cgx_wf_id_c) ? $this->bean->cgx_wf_id_c : '';
            require_once('modules/Configurator/Configurator.php');
            $configurator = new Configurator();
            $configurator->loadConfig();
            $urlBusinessProcess = $configurator->config['CGX_API_cgx_public_url'] . '?workflowInstanceId=' . $workflowInstanceId;
            $this->ss->assign('businessProcess', $urlBusinessProcess);
        }

        if ((!empty($this->bean->activity_id_c)) || $workflowInstanceId) {
            $this->dv->defs['templateMeta']['form']['buttons'] = array(
                0 => "EDIT", //SE-332
                1 =>
                array(
                    'customCode' => '<input type="submit" id="display_business_process" class="button" title="Display Business Process" name="display_business_process" value="Display Business Process" onClick="window.open(\'{$businessProcess}\', \'\', \'toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=1000,height=1000\')"/>',
                ),
                2 =>
                array(
                    'customCode' => '{$dropdownAssignment}',
                ),
                3 =>
                array(
                    'customCode' => '{$dropdownCompletion}',
                ),
            );
        }
        $detailViewTpl = 'cache/modules/' . $this->module . '/DetailView.tpl';
        if (file_exists($detailViewTpl)) {
            unlink($detailViewTpl);
        }
        parent::display();
    }  
}     