<?php
require_once('modules/AOW_Actions/actions/actionBase.php');

class actionTriggerCasegenixBusinessProcess extends actionBase {

    function actionTriggerCasegenixBusinessProcess($id = '') {

        parent::actionBase($id);
    }

    function loadJS() {

        return array('custom/modules/AOW_Actions/actions/actionTriggerCasegenixBusinessProcess.js');
    }

    function edit_display($line, SugarBean $bean = null, $params = array()) {
        $html = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>";
        $html .= '<td colspan="4" scope="row"><table id="cgx_triggger_business_process_table" width="100%"><tbody id="cgx_triggger_business_process_table_body">';
        $html .= '<tr id="cgx_workarea_tr"><td>' . translate("LBL_WORKAREA", "AOW_Actions") . ':<span class="required">*</span>&nbsp;&nbsp;</td>';
        $html .= '<td id="cgx_workarea_value_type_td"><select type="text" style="width:178px;" name="aow_actions_param[0][cgx_workarea_value_type]" id="cgx_workarea_value_type" title="" tabindex="116" onchange="change_casegenixValueType(' . "'aow_actions_param[0][cgx_workarea]'" . ', this.value)"><option value="Value">Value</option><option value="Field">Field</option></select></td>';
        $html .= '<td id="aow_actions_param[0][cgx_workarea]_td"><input type="text" id="aow_actions_param[0][cgx_workarea]" name="aow_actions_param[0][cgx_workarea]" size="30" maxlength="255" tabindex="1"/></td></tr>';
        $html .= '<tr id="cgx_casecategory_tr"><td>' . translate("LBL_CASECATEGORY", "AOW_Actions") . ':<span class="required">*</span>&nbsp;&nbsp;</td>';
        $html .= '<td id="cgx_casecategory_value_type_td"><select type="text" style="width:178px;" name="aow_actions_param[0][cgx_casecategory_value_type]" id="cgx_casecategory_value_type" title="" tabindex="116" onchange="change_casegenixValueType(' . "'aow_actions_param[0][cgx_casecategory]'" . ', this.value)"><option value="Value">Value</option><option value="Field">Field</option></select></td>';
        $html .= '<td id="aow_actions_param[0][cgx_casecategory]_td"><input type="text" id="aow_actions_param[0][cgx_casecategory]" name="aow_actions_param[0][cgx_casecategory]" size="30" maxlength="255" tabindex="1"/></td></tr>';
        $html .= '<tr id="cgx_casetype_tr"><td>' . translate("LBL_CASETYPE", "AOW_Actions") . ':<span class="required">*</span>&nbsp;&nbsp;</td>';
        $html .= '<td id="cgx_casetype_value_type_td"><select type="text" style="width:178px;" name="aow_actions_param[0][cgx_casetype_value_type]" id="cgx_casetype_value_type" title="" tabindex="116" onchange="change_casegenixValueType(' . "'aow_actions_param[0][cgx_casetype]'" . ', this.value)"><option value="Value">Value</option><option value="Field">Field</option></select></td>';
        $html .= '<td id="aow_actions_param[0][cgx_casetype]_td"><input type="text" id="aow_actions_param[0][cgx_casetype]" name="aow_actions_param[0][cgx_casetype]" size="30" maxlength="255" tabindex="1"/></td></tr>';
        $html .= '<tr id="cgx_casesubtype_tr"><td>' . translate("LBL_CASESUBTYPE", "AOW_Actions") . ':<span class="required">*</span>&nbsp;&nbsp;</td>';
        $html .= '<td id="cgx_casesubtype_value_type_td"><select type="text" style="width:178px;" name="aow_actions_param[0][cgx_casesubtype_value_type]" id="cgx_casesubtype_value_type" title="" tabindex="116" onchange="change_casegenixValueType(' . "'aow_actions_param[0][cgx_casesubtype]'" . ', this.value)"><option value="Value">Value</option><option value="Field">Field</option></select></td>';
        $html .= '<td id="aow_actions_param[0][cgx_casesubtype]_td"><input type="text" id="aow_actions_param[0][cgx_casesubtype]" name="aow_actions_param[0][cgx_casesubtype]" size="30" maxlength="255" tabindex="1"/></td></tr>';
        $html .= '<tr id="cgx_casename_tr"><td>' . translate("LBL_CASENAME", "AOW_Actions") . ':<span class="required">*</span>&nbsp;&nbsp;</td>';
        $html .= '<td id="cgx_casename_value_type_td"><select type="text" style="width:178px;" name="aow_actions_param[0][cgx_casename_value_type]" id="cgx_casename_value_type" title="" tabindex="116" onchange="change_casegenixValueType(' . "'aow_actions_param[0][cgx_casename]'" . ', this.value)"><option value="Value">Value</option><option value="Field">Field</option></select></td>';
        $html .= '<td id="aow_actions_param[0][cgx_casename]_td"><input type="text" id="aow_actions_param[0][cgx_casename]" name="aow_actions_param[0][cgx_casename]" size="30" maxlength="255" tabindex="1"/></td></tr>';
        $html .= '</tbody></table></td>';
        $html .= "</tr>";
        $html .= "<script id ='aow_script0'>";
        $fields = array('cgx_workarea', 'cgx_casecategory', 'cgx_casetype', 'cgx_casesubtype', 'cgx_casename');
        foreach ($fields as $field) {
            $field_type_name = $field . '_value_type';
            if (!empty($params[$field_type_name])) {
                $field_value = @$params[$field];
                $field_type = @$params[$field_type_name];
                $cln = 'aow_actions_param[0][' . $field . ']';
                $html .= "load_cgxcrline('" . $field . "','" . $cln . "','" . $field_type . "','" . $field_value . "');";
            }
        }
        $html .= "</script>";
        return $html;
    }

    function run_action(SugarBean $bean, $params = array(), $in_save = false) {
        $workArea = $caseCategory = $caseType = $caseSubtype = $caseName = "";
        if (!empty($params) && $in_save == true) {
            if (!empty($params['cgx_workarea_value_type'])) {
                if ($params['cgx_workarea_value_type'] == 'Field') {
                    $workArea = $bean->{$params['cgx_workarea']};
                } else {
                    $workArea = $params['cgx_workarea'];
                }
            }
            if (!empty($params['cgx_casetype_value_type'])) {
                if ($params['cgx_casetype_value_type'] == 'Field') {
                    $caseType = $bean->{$params['cgx_casetype']};
                } else {
                    $caseType = $params['cgx_casetype'];
                }
            }
            if (!empty($params['cgx_casesubtype_value_type'])) {
                if ($params['cgx_casesubtype_value_type'] == 'Field') {
                    $caseSubtype = $bean->{$params['cgx_casesubtype']};
                } else {
                    $caseSubtype = $params['cgx_casesubtype'];
                }
            }
            if (!empty($params['cgx_casename_value_type'])) {
                if ($params['cgx_casename_value_type'] == 'Field') {
                    $caseName = $bean->{$params['cgx_casename']};
                } else {
                    $caseName = $params['cgx_casename'];
                }
            }
            if (!empty($params['cgx_casecategory_value_type'])) {
                if ($params['cgx_casecategory_value_type'] == 'Field') {
                    $caseCategory = $bean->{$params['cgx_casecategory']};
                } else {
                    $caseCategory = $params['cgx_casecategory'];
                }
            }
        }
        if (!empty($workArea) && !empty($caseName) && !empty($caseCategory) && !empty($caseType) && !empty($caseSubtype)) {
            try {
                $GLOBALS ["log"]->debug("Triggering of CGX workflows:: start");

                require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
                $kit = CGX_Kit_Factory::create('workflow');

                global $current_user;
                $date = new DateTime ();
                $dateFMT = $date->format('d-m-Y H:i');
                $parentType = !empty($bean->module_name) ? $bean->module_name : "";
                $parentId = !empty($bean->id) ? $bean->id : "";
                $workfolowNameStatic = "[{$bean->module_name}][{$caseName}]";
                $entry = array(
                    array(
                        'key' => 'Business_Object',
                        'value' => $parentType
                    ),
                    array(
                        'key' => 'Business_Object_Id',
                        'value' => $parentId
                    ),
                );

                $cgxCaseDetails = array(
                    "initiateWorkflowDetails" => array(
                        "cgxCase" => array(
                            "caseCategory" => $caseCategory,
                            "caseSubType" => $caseSubtype,
                            "caseTitle" => $caseName,
                            "caseType" => $caseType,
                            "date" => $dateFMT,
                            "userName" => $current_user->user_name,
                            "workarea" => $workArea
                        ),
                        "workflowVariables" => array(
                            "dataMap" => array(
                                "entry" => $entry
                            )
                        )
                    )
                );
                $data = $kit->initiate($cgxCaseDetails);
                if ($data->error != NULL) {
                    $GLOBALS ["log"]->fatal("Triggering of CGX workflows Error" . json_encode($data));
                    return false;
                } else {
                    if (!empty($data->response)) {
                        $respone = $data->response;
                        if (isset($respone['status']) && $respone['status']['statusCode'] == '000') {
                            global $db;
                            $workflowInstanceId = !empty($respone['workflowInstanceId']) ? $respone['workflowInstanceId'] : '';
                            $workflowName = !empty($respone['workflowName']) ? $respone['workflowName'] : $workfolowNameStatic;
                            // Update query by Nhat
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
                                    'type' => 'timestamp',
                                ),
                                'id' => array(
                                    'name' => 'id',
                                    'type' => 'bigint',
                                    'len' => '20',
                                    'auto_increment' => true,
                                    'isnull' => false,
                                )
                            );
                                $data = array(
                                    'name' => $workflowName,
                                    'cgx_workflow_instance_id' => $workflowInstanceId,
                                    'parent_type' => $parentType,
                                    'parent_id' => $parentId,
                                    'timestamp' => date('Y-m-d H:i:s'),
                                );
                            $db->insertParams('cgx_workflow', $field_defs, $data, null, true);
                            // End
//                            $query = "INSERT INTO cgx_workflow (name, cgx_workflow_instance_id, parent_type, parent_id, timestamp)"
//                                    . " VALUES ('{$workflowName}', '{$workflowInstanceId}', '{$parentType}', '{$parentId}');";
//                            $db->query($query);
                            return true;
                        }
                    }
                    $GLOBALS ["log"]->fatal("Triggering of CGX workflows Error" . json_encode($data->response));
                    return false;
                }
            } catch (Exception $exc) {
                $GLOBALS ["log"]->fatal("Triggering of CGX workflows Error" . $exc->getMessage());
                return false;
            }
        }
        return false;
    }
}
