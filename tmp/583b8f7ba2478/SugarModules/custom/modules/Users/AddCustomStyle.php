<?php
class AddCustomStyle{
    public function addStyle(){
        if($_REQUEST['module'] && isset($_REQUEST['module']) && $_REQUEST['module'] == 'Users'){
            echo '<script type="text/javascript" src="custom/modules/Users/js/customStyle.js"></script>';
        }
    }
}