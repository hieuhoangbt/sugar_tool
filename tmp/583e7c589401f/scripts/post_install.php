<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function post_install()
{
	//SE-356
	if(file_exists("cache/include/javascript/sugar_grp1.js")) {
		unlink("cache/include/javascript/sugar_grp1.js");
	}   
	//end 
    global $db;
    try {
        $field_defs = array(
            'id' => array(
                'name' => 'id',
                'type' => 'int',
                'len' => 11,
                'auto_increment' => true,
                'isnull' => false,
                'required' => true,
            ),
            'cgx_role' => array(
                'name' => 'cgx_role',
                'type' => 'varchar',
                'len' => '255',
            ),
            'activity_id' => array(
                'name' => 'activity_id',
                'type' => 'char',
                'len' => '36',
                'isnull' => false,
                'required' => true,
            ),
            'task_id' => array(
                'name' => 'task_id',
                'type' => 'char',
                'len' => '36',
                'isnull' => false,
                'required' => true,
            ),
            'queue_id' => array(
                'name' => 'queue_id',
                'type' => 'char',
                'len' => '36',
                'isnull' => false,
                'required' => true,
            ),
            'queue_name' => array(
                'name' => 'queue_name',
                'type' => 'varchar',
                'len' => '255',
            ),
            'role_id' => array(
                'name' => 'role_id',
                'type' => 'char',
                'len' => '36'
            ),
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'type' => 'char',
                'len' => '36',
            ),
            'view' => array(
                'name' => 'view',
                'type' => 'tinyint',
                'len' => '1',
                'default' => '0',
                'isnull' => false,
                'required' => true,
            ),
            'sa' => array(
                'name' => 'sa',
                'type' => 'tinyint',
                'len' => '1',
                'default' => '0',
                'isnull' => false,
                'required' => true,
            ),
            'su' => array(
                'name' => 'su',
                'type' => 'tinyint',
                'len' => '1',
                'default' => '0',
                'isnull' => false,
                'required' => true,
            ),
            'ua' => array(
                'name' => 'ua',
                'type' => 'tinyint',
                'len' => '1',
                'default' => '0',
                'isnull' => false,
                'required' => true,
            ),
            'uu' => array(
                'name' => 'uu',
                'type' => 'tinyint',
                'len' => '1',
                'default' => '0',
                'isnull' => false,
                'required' => true,
            ),
            'deleted' => array(
                'name' => 'deleted',
                'type' => 'tinyint',
                'len' => '1',
                'default' => '0',
                'isnull' => false,
                'required' => true,
            ),
			'workflow_name' => array(
                'name' => 'workflow_name',
                'type' => 'varchar',
                'len' => '255',
            )
        );
        $indices = array(
            array('name' => 'role_based_queue_permission_pk', 'type' => 'primary', 'fields' => array('id')),
            array('name' => 'role_based_queue_permission_idx', 'type' => 'index', 'fields' => array('task_id')),
        );
        $db->repairTableParams('role_based_queue_permission', $field_defs, $indices, true, "InnoDB");
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
    }
    try {
        $field_defs = array(
            'name' => array(
                'name' => 'name',
                'type' => 'varchar',
                'len' => 255,
                'isnull' => false,
            ),
            'cgx_workflow_instance_id' => array(
                'name' => 'cgx_workflow_instance_id',
                'type' => 'int',
                'len' => '20',
            ),
            'parent_type' => array(
                'name' => 'parent_type',
                'type' => 'varchar',
                'len' => '255',
            ),
            'parent_id' => array(
                'name' => 'parent_id',
                'type' => 'id',
                'len' => '36',
            ),
            'timestamp' => array(
                'name' => 'timestamp',
                'type' => 'datetime',
            ),
            'id' => array(
                'name' => 'id',
                'type' => 'bigint',
                'len' => '20',
                'auto_increment' => true,
                'isnull' => false,
                'required' => true
            ),
        );
        $indices = array(
            array('name' => 'cgx_workflow_index', 'type' => 'index', 'fields' => array('parent_type', 'parent_id')),
            array('name' => 'cgx_workflowpk', 'type' => 'primary', 'fields' => array('id'))
        );
        $db->repairTableParams('cgx_workflow', $field_defs, $indices, true, "InnoDB");
    } catch (Exception $e) {
        $GLOBALS['log']->debug($e->getMessage());
    }

    //SE-489
    //define fields to add to the UI
    $layoutFields = array(
        0 => array(
            'name' => 'unavailable_date_from_c',
            'label' => 'LBL_UNAVAILABLE_DATE_FROM_C',
        ),
        1 => array(
            'name' => 'unavailable_date_to_c',
            'label' => 'LBL_UNAVAILABLE_DATE_TO_C',
        )
    );
    addField2View($layoutFields, 'detailview');
    addField2View($layoutFields, 'editview');
    //END

    require_once("modules/Administration/QuickRepairAndRebuild.php");
    $randc = new RepairAndClear();
    $randc->repairAndClearAll(array('clearAll'), array(translate('LBL_ALL_MODULES')), false, true);
}

//SE-489
function addField2View ($layoutFields, $view) {
    require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
    $parser = ParserFactory::getParser($view, 'Users');
    if (!$parser) {
        $GLOBALS['log']->fatal("No parser found for Users | $view");
    }
    $check_exist = false;
    foreach($parser->_viewdefs['panels']['LBL_USER_INFORMATION'] as $k => $row){
        if($row
            && is_array($row)
            && in_array('unavailable_date_from_c', $row)
            && in_array('unavailable_date_to_c', $row))
        {
            $check_exist = true;
        }
        if($check_exist) break;
    }
    $position = count($parser->_viewdefs['panels']['LBL_USER_INFORMATION']);
    if($check_exist == false){
        $parser->_viewdefs['panels']['LBL_USER_INFORMATION'][$position] = $layoutFields;
        echo ("<strong>unavailable_date_from_c</strong> and <strong>unavailable_date_to_c</strong> fields added to Users $view View.<br />");
    }
    $parser->handleSave(false);
}
//end
