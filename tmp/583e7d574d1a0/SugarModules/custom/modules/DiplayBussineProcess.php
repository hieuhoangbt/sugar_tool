<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class DiplayBussineProcessButtons { 
    function add() {
        switch ($GLOBALS['app']->controller->action) {
            case "DetailView":
                global $app_list_strings, $sugar_config;
                $parent_type = $parent_id = 0;
                if (isset($_REQUEST['module']) && !empty($_REQUEST['module'])) {
                    $parent_type = $_REQUEST['module'];
                }
                if (isset($_REQUEST['record']) && !empty($_REQUEST['record'])) {
                    $parent_id = $_REQUEST['record'];
                }
                if (!empty($parent_id) && !empty($parent_type) && $parent_type != 'Tasks') {
                    $displayprocessbutton = '';
                    try {
                        //Url Business Process
                        $workflowInstanceId = '';
                        require_once('modules/Configurator/Configurator.php');
                        $configurator = new Configurator();
                        $configurator->loadConfig();
                        $default_date_format = $configurator->config['default_date_format'];
                        $default_time_format = $configurator->config['default_time_format'];
                        $caseDetail = $this->getWorkflowByIdAndModuleType($parent_id, $parent_type);
                        if ($caseDetail) {
                            $dropdownBusiness = '<a href=\"javascript:void(0);\" data-toggle=\"dropdown\" class=\"dropdown-toggle\">'.$app_list_strings['moduleList']['DisplayBusinessProcess'].'</a>';
                            $dropdownBusiness .= '<ul class=\"dropdown-menu business-wrapper\">';
                             foreach ($caseDetail as $case) {
                                $time_entered = $case['timestamp'];
                                $datetime = new DateTime($time_entered);
                                $time = $datetime->format($default_date_format.' '.$default_time_format);
                                $module = $app_list_strings['parent_type_display'][$parent_type];
                                $name_record = $case['name'];
                                $wf_instance_name = str_replace($parent_type, $module, $name_record);
                                $wf_instance_id = $case['cgx_workflow_instance_id'];
                                $urlBusinessProcess = $configurator->config['CGX_API_cgx_public_url'] . '?workflowInstanceId=' . $wf_instance_id;
                                $dropdownBusiness .= '<li><a class=\"displayBp\" >'.$wf_instance_name.' - ' .$time .'</a></li>';
                            }
                            $dropdownBusiness .= '</ul>';
                            $displayprocessbutton = '<script type="text/javascript">
                                $(document).ready(function(){
                                        var height = $(window).height();
                                        var width = Math.ceil(($(window).width() * 2) / 3);
                                        if("'.$sugar_config['default_theme'].'" == "SuiteP"){
                                            $("#tab-actions .dropdown-menu").first().addActionMenuCus("<li>'.$dropdownBusiness.'</li>");
                                            var that = $("#tab-actions .dropdown-menu .displayBp");
                                        }else{
                                            $("#detail_header_action_menu .sugar_action_button .subnav").addActionMenuCus("<li>'.$dropdownBusiness.'</li>");  
                                            var that = $("#detail_header_action_menu .sugar_action_button .subnav .displayBp");
                                        }
                                        that.click(function (){
                                            window.open(\''.$urlBusinessProcess.'\', \'\', \'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=\'+width+\',height=\'+height+\'\');
                                        
                                        })
                                });
                            </script>';
                        }
                    } catch (Exception $ex) {
                        $GLOBALS['log']->debug($ex->getMessage());
                    }
                    echo $displayprocessbutton;
                }
                break;
        }
    }

    private function getWorkflowByIdAndModuleType($id = '', $module_type = '') {
        global $db;
        $query = "SELECT * FROM cgx_workflow WHERE parent_id = '{$id}' AND parent_type = '{$module_type}' ORDER BY timestamp DESC";
        $res = $db->query($query);
        $cases = array();
        while ($row = $db->fetchByAssoc($res)) {
            $cases[] = $row;
        }
        return $cases;
    }

}
