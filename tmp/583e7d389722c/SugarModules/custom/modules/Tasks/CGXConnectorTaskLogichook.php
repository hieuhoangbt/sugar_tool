<?php
    class CGXConnectorTaskLogichook{

        /**
        * SE-332
        * 
        * @param mixed $bean
        * @param mixed $event
        * @param mixed $arg
        */
        function resetDataBeforeSave(&$bean, $event, $arg) {
            if(!(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Tasks' && isset($_REQUEST['record'])) ) {
                return;
            }
            if(isset($bean->fetched_row) && !empty($bean->fetched_row['activity_id_c'])) {
                $cgxFields = array(
                    'name',
                    'status',
                    'parent_type',
                    'parent_id'
                );

                foreach($cgxFields as $cgxField) {
                    if($bean->$cgxField != $bean->fetched_row[$cgxField]) {
                        $bean->$cgxField = $bean->fetched_row[$cgxField];
                    }
                }
            }
        }

        function updateAssignedUserRoleBasePermission(&$bean, $event, $args) {
            if($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id) {
                global $db;
                $sql = "UPDATE role_based_queue_permission SET assigned_user_id = '{$bean->assigned_user_id}' WHERE deleted=0 AND task_id='{$bean->id}'";
                $db->query($sql);
            }
        }
    }
?>
