<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once 'ACLRoleCustom.php';

class RoleBasedQueuePermission {

    /**
     * Check CGX Role is Mapped to SuiteCRM ACL Role via $cgx_role
     * @param type $cgx_role
     * @return boolean
     */
    public function checkCGXRoleIsMapped($cgx_role) {
        $role = new ACLRole();
        $roleMapped = $role->retrieve_by_string_fields(array('casegenix_role' => addslashes($cgx_role)));
        return (!empty($roleMapped)) ? $roleMapped->id : false;
    }

    /**
     * If CGX Role and SuiteCRM Role is mapped
     *
     */
    public function process($cgx_role){
        $sRoleId = $this->checkCGXRoleIsMapped($cgx_role);
        if($sRoleId){
           /**
            * Check in based role table
            * @param $sRoleId
            * @return $count record in role based by $sRoleId
            * (1) $count > 0
            * *@If $count = 1 => set based role record with role_id = NULL
            * *@If $count > 1 => Delete all record with role_id = $sRoleId
            * (2) $count = 0
            * *@If (count record in based role where role_id is NULL) > 0 => set role_id from NULL to $sRoleId
            * *@If (count record in based role where role_id is NULL) = 0 => duplicate all record (has $cgx_role) in based role set role_id = $sRoleId
            */
           $num_record = $this->getNumRecordBySuiteRole($sRoleId);
            if($num_record > 0) {
                $this->updateSuiteRoleInRoleBase($sRoleId, $num_record);
            }
            else {
                $this->processWithOutSuiteRoleMapped($cgx_role, $sRoleId);
            }
        }
    }

    /*
     * Set Suite Role in role base to blank
     * @Params: $s_role_id
     */
    public function setSuiteRoleToBlank($s_role_id) {
        global $db;
        $query = "UPDATE role_based_queue_permission  SET deleted=0 AND role_id = NULL WHERE role_id='{$s_role_id}'";
        $db->query($query);
    }

    /*
     * Remove all record in role base by Suite Role
     * Params: $s_role_id
     */
    public function removeRecordBySuiteRole($s_role_id) {
        global $db;
        $query = "UPDATE role_based_queue_permission  SET deleted=1 WHERE deleted=0 AND role_id='{$s_role_id}'";
        $db->query($query);
    }

    /*
     * Update Suite Role for record in role base
     * @Params: $s_role_id, $num_record
     */
    public function updateSuiteRoleInRoleBase($s_role_id, $num_record) {
        if($num_record == 1) {
            $this->setSuiteRoleToBlank($s_role_id);
        }
        else {
            $this->removeRecordBySuiteRole($s_role_id);
        }
    }

    /**
     * Process option 2
     */
    public function processWithOutSuiteRoleMapped($cgx_role, $sRoleId){
        $count = $this->countNullRole();
        if($count == 0)
            $this->duplicateBasedRoleRecord ($cgx_role, $sRoleId);
        else
            $this->updateBasedRole ($sRoleId);
    }

    /*
     * Get num record role base by Suite role
     * @Params: $s_role_id
     */
    public function getNumRecordBySuiteRole($s_role_id) {
        global $db;
        $query = "SELECT COUNT(*) FROM role_based_queue_permission WHERE deleted=0 AND role_id='{$s_role_id}'";
        $num_record = $db->getOne($query);
        return $num_record;
    }

    /**
     * Count record in based role
     * @param role_id is NULL
     */
    public function countNullRole(){
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT COUNT(*) AS total FROM `role_based_queue_permission` WHERE deleted=0 AND `role_id` IS NULL OR `role_id` = ''";
        $total = $db->getOne($sql);
        return $total;
    }

    /**
     * Update based role
     * @param $sRoleId
     * @return result
     */
    public function updateBasedRole($sRoleId){
        $db = DBManagerFactory::getInstance();
        $sql = "UPDATE `role_based_queue_permission` SET `role_id` = '".  addslashes($sRoleId)."' WHERE deleted=0 AND `role_id` IS NULL OR `role_id` = ''";
        return $db->query($sql);
    }

    /**
     * Duplicate based role record by cgx_role
     * @param $cgx_role: casegenix role
     * @param $sRoleId: Suite Role has mapped to $cgx_role
     */
    public function duplicateBasedRoleRecord($cgx_role, $sRoleId){
        $db = DBManagerFactory::getInstance();
        // Get all based role record have cgx_role
        $basedRoleRecords = $this->getAllBasedRoleRecord($cgx_role);
        $values = array();
        while($record = $db->fetchByAssoc($basedRoleRecords)){
            $value = array($record['cgx_role'], $record['activity_id'], $record['task_id'], $record['queue_id'], $record['queue_name'], $sRoleId, $record['assigned_user_id'], $record['view'], $record['sa'], $record['su'], $record['ua'], $record['uu']);
            $value = "'".implode("','", $value) . "'";
            $values[] = $value;
        }
        $values = "(".implode("),(", $values).")";
        $this->duplicateRecordWithSRoleId($values);
    }

    /**
     * getAllBasedRoleRecord
     * @param $cgx_role
     * @return Data Role
     */
    public function getAllBasedRoleRecord($cgx_role){
        $db = DBManagerFactory::getInstance();
        $sql = "SELECT * FROM `role_based_queue_permission` WHERE deleted=0 AND `cgx_role` = '".addslashes($cgx_role)."'";
        return $db->query($sql);
    }

    /**
     * duplicateRecordWithSRoleId
     * @param $values data to insert
     */
    public function duplicateRecordWithSRoleId($values){
        $db = DBManagerFactory::getInstance();
        $sql = "INSERT INTO `role_based_queue_permission` (`cgx_role`, `activity_id`, `task_id`, `queue_id`, `queue_name`, `role_id`, `assigned_user_id`, `view`, `sa`, `su`, `ua`, `uu`) VALUES " . $values;
        $db->query($sql);
    }
}
