<?php

/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 * ****************************************************************************** */

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/CGX_CheckList/CGX_CheckList_sugar.php');

class CGX_CheckList extends CGX_CheckList_sugar {

    function __construct() {
        parent::__construct();
    }

    function saveCheckListOfTask($task_id, $check_list_items) {
        if (!empty($check_list_items)) {
            $task = new Task();
            $task->retrieve($task_id);
            $task->load_relationship('cgx_checklist_tasks');
            $check_list_beans = $task->cgx_checklist_tasks->getBeans();
            $item_ids = $this->getCheckListItemIdsFromSuiteByTask($check_list_beans);
            $item_cgx_ids = array_keys($item_ids);
            // Update if exist and add new if does not exist check list
            foreach ($check_list_items as $item) {
                // If checklist exist then do update
                $check_list = new CGX_CheckList();
                if (in_array($item['id'], $item_cgx_ids)) {
                    $check_list->retrieve($item_ids[$item['id']]);
                }
                $check_list->check_list_id = $item['id'];
                $check_list->priority = $item['priority'];
                $check_list->mandatory = ($item['mandatory'] == "Mandatory") ? 1 : 0;
                $check_list->name = $item['itemName'];
                $check_list->description = $item['itemDescription'];
                $check_list->save();
                // Add relationship
                $task->cgx_checklist_tasks->add($check_list->id);
            }
            return true;
        } else {
            $GLOBALS['log']->debug('Task not have any item');
        }
    }

    function checkListItemsHaveBeenCompleted($task_id) {
        if (!empty($task_id)) {
            $task = new Task();
            $task->retrieve($task_id);
            $task->load_relationship('cgx_checklist_tasks');
            $check_list_items = $task->cgx_checklist_tasks->getBeans();
            foreach ($check_list_items as $item) {
                if ($item->mandatory == 0)
                    return false;
            }
            return true;
        } else {
            $GLOBALS['log']->debug('Task ' . $task_id . 'does not exist');
            return fasle;
        }
    }

    function getCheckListItemIdsFromSuiteByTask($check_list_beans) {
        $item_ids = array();
        foreach ($check_list_beans as $bean) {
            $item_ids[$bean->check_list_id] = $bean->id;
        }
        return $item_ids;
    }

}

?>