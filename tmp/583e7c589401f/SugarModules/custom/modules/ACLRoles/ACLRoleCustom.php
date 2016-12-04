<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'modules/ACLRoles/ACLRole.php';
class ACLRoleCustom extends ACLRole{
    var $casegenix_role;
    /**
    *  toArray()
    * returns this role as an array
    *
    * @return array of fields with id, name, description, casegenix_role
    */
    function toArray($dbOnly = false, $stringOnly = false, $upperKeys=false){
        $array_fields = array('id', 'name', 'description', 'casegenix_role');
        $arr = array();
        foreach($array_fields as $field){
            if (!empty($_SESSION['data-invalid-casegenix-role'])) {
                // display input value
                if(isset($_SESSION['data-invalid-casegenix-role'][$field])){
                    $arr[$field] = $_SESSION['data-invalid-casegenix-role'][$field];
                }else{
                    $arr[$field] = '';
                }
            } else {
                if(isset($this->$field)){
                    $arr[$field] = $this->$field;
                }else{
                    $arr[$field] = '';
                }
            }
        }
        if (!empty($_SESSION['data-invalid-casegenix-role'])) {
            unset($_SESSION['data-invalid-casegenix-role']);
        }
        return $arr;
    }
}

?>