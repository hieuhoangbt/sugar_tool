<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/ACLRoles/views/view.classic.php');

class CustomACLRolesViewClassic extends ACLRolesViewClassic {
     function display(){
        $this->dv->process();

        $file = SugarController::getActionFilename($this->action);
        if(file_exists('custom/modules/'. $this->module . '/'. $file . '.php')){
            $this->includeClassicFile('custom/modules/'. $this->module . '/'. $file . '.php');
        }else{
            $this->includeClassicFile('modules/'. $this->module . '/'. $file . '.php');
        }
    }
}

?>
