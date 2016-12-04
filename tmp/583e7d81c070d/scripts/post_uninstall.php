<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
post_uninstall();

function post_uninstall() {
    require_once('modules/ModuleBuilder/Module/StudioModule.php');
    //SE-356
    if (file_exists("cache/include/javascript/sugar_grp1.js")) {
        unlink("cache/include/javascript/sugar_grp1.js");
    }
    //end
    // Remove table
    if (isset($_REQUEST['remove_tables']) && isset($_REQUEST['mode'])) {
        if ($_REQUEST['remove_tables'] == 'true' && $_REQUEST['mode'] == 'Uninstall') {
            global $db;
            if ($db->tableExists('role_based_queue_permission')) {
                $db->dropTableName('role_based_queue_permission');
            }
        }
    }


    /**
     * SE-431
     * Remove file _headerModuleList.tpl in all themes
     */
    //In SuiteP theme
    if (file_exists("custom/themes/SuiteP/tpls/_headerModuleList.tpl")) {
        @unlink("custom/themes/SuiteP/tpls/_headerModuleList.tpl");
        echo "<strong>Removed file _headerModuleList.tpl in SuiteP Theme!</strong><br/>";
    }

    //In SuiteR theme
    if (file_exists("custom/themes/SuiteR/tpls/_headerModuleList.tpl")) {
        @unlink("custom/themes/SuiteR/tpls/_headerModuleList.tpl");
        echo "<strong>Removed file _headerModuleList.tpl in SuiteR Theme!</strong><br/>";
    }

    //remove unavailable_date_from_c, unavailable_date_to_c
    $usm = new StudioModule("Users");
    $usm->removeFieldFromLayouts('unavailable_date_from_c');
    $usm->removeFieldFromLayouts('unavailable_date_to_c');
}

