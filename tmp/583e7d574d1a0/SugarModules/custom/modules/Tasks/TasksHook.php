<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("custom/modules/Tasks/TasksModel.php");
class TasksHook {
    /*
     * Hook: Deletion of Records
     */
    function deleteCGXRecords($bean, $event, $arguments)
    {
        if (!empty($bean->id)) {
            $taskModel = new TasksModel();
            $taskModel->deleteQueuePermissionRecords($bean->id);
        }
    }

    /*
     * Hook: Bulk operation  in ListView
     */
    function displayAssignmentActions()
    {
        global $app, $current_user, $app_list_strings;
        if (!empty($app) && $app->controller->module == 'Tasks' && $app->controller->action == 'listview'){
            // get list actions
            $assignments = [];
            $assignments['FF'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_FF'];
            $assignments['SA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SA'];
            $assignments['SU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_SU'];
            $assignments['UA'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UA'];
            $assignments['UU'] = $app_list_strings['LBL_ASSIGNMENT']['LBL_UU'];
            // build html list actions
            $dropdownAssignment = '<ul class="dropdown-menu" data-userid="' . $current_user->id . '">';
            foreach ($assignments as $key => $assignment) {
                if ($key == 'UA') {
                    $dropdownAssignment .= '<li><a href="javascript:void(0);" onclick="cgx_bulk_open_popup()" data-assignment="' . $key . '" >' . $assignment . '</a></li>';
                } else{
                    $dropdownAssignment .= '<li><a href="javascript:void(0);" class="actionAssignmentBulk" data-assignment="' . $key . '" >' . $assignment . '</a></li>';
                }
            }
            $dropdownAssignment .='</ul>';

            // get list completions
            $taskModel = new TasksModel();
            $completionOptions = $taskModel->getAllCompletions();
            // build html list completions
            if (!empty($completionOptions)) {
                $dropdownCompletion = '<ul class="dropdown-menu"  data-userid="' . $current_user->id . '" >';
                foreach ($completionOptions as $completion) {
                    $dropdownCompletion .= '<li><a href="javascript:void(0);" class="actionCompletionBulk" data-completion="' . $completion . '" >' . $completion . '</a></li>';
                }
                $dropdownCompletion .= '</ul>';
            }

            $scrip_actions = <<<EOF
<script type="text/javascript">
$(document).ready(function(){
    // assignment
    if (!$(".clickMenu.selectActions .BulkAssignments").length) {
        $("#actionLinkTop").sugarActionMenu('addItem',{item: $('<li><a class="BulkAssignments" href="javascript: void(0)" onclick="open_popup_ext(\'change_log\')" >Assignment</a> $dropdownAssignment</li>')});
        $("#actionLinkBottom").sugarActionMenu('addItem',{item: $('<li><a class="BulkAssignments" href="javascript: void(0)" onclick="open_popup_ext(\'change_log\')" >Assignment</a> $dropdownAssignment</li>')});
    }
    
    // completion
    if (!$(".clickMenu.selectActions .BulkCompletions").length) {
        $("#actionLinkTop").sugarActionMenu('addItem',{item: $('<li><a class="BulkCompletions" href="javascript: void(0)" onclick="open_popup_ext(\'change_log\')" >Completion</a> $dropdownCompletion</li>')});
        $("#actionLinkBottom").sugarActionMenu('addItem',{item: $('<li><a class="BulkCompletions" href="javascript: void(0)" onclick="open_popup_ext(\'change_log\')" >Completion</a> $dropdownCompletion</li>')});
    }
});
</script>
EOF;
            echo $scrip_actions; 
        }
    }
}
