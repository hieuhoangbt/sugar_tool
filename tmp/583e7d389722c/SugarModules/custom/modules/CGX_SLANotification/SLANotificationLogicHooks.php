<?php
class SLANotificationLogicHook {
    // This function using to set relationship between task and sla notification when sla notification create from casegenix
    public function setRelationshipToTaskByActivityId(&$bean) {
        if(!empty($bean->activity_id) && empty($bean->cgx_slanotification_taskstasks_ida)) {
            $task = new Task();
            $task->retrieve_by_string_fields(array('activity_id_c' => $bean->activity_id));
            $relate_values = array(
                'cgx_slanotification_taskscgx_slanotification_idb' => $bean->id,
                'cgx_slanotification_taskstasks_ida' => $task->id
            );
            $bean->set_relationship('cgx_slanotification_tasks_c',$relate_values, true, true);
        }
    }
}