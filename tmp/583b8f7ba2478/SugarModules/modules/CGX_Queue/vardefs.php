<?php
/*********************************************************************************
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
 ********************************************************************************/

$dictionary['CGX_Queue'] = array(
    'table'=>'cgx_queue',
    'audited'=>true,
    'inline_edit'=>false,
        'duplicate_merge'=>false,
        'fields'=>array(
  'task_id_c' =>
  array(
    'required' => false,
    'name' => 'task_id_c',
    'vname' => 'LBL_TASKS_TASK_ID_TASK_ID',
    'type' => 'id',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'inline_edit' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 36,
    'size' => '20',
  ),
  'tasks_task_id' =>
  array(
    'required' => false,
    'source' => 'non-db',
    'name' => 'tasks_task_id',
    'vname' => 'LBL_TASKS_TASK_ID',
    'type' => 'relate',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '255',
    'size' => '20',
    'id_name' => 'task_id_c',
    'ext2' => 'Tasks',
    'module' => 'Tasks',
    'rname' => 'name',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
  ),
  'queue_name' =>
  array(
    'required' => false,
    'name' => 'queue_name',
    'vname' => 'LBL_QUEUE_NAME',
    'type' => 'text',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
  ),
  'business_process_name' =>
  array(
    'required' => false,
    'name' => 'business_process_name',
    'vname' => 'LBL_BUSINESS_PROCESS_NAME',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '255',
    'size' => '20',
  ),
  'queue_activity_id' =>
  array(
    'required' => false,
    'name' => 'queue_activity_id',
    'vname' => 'LBL_QUEUE_ACTIVITY_ID',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '20',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
  'sa' =>
  array(
    'required' => false,
    'name' => 'sa',
    'vname' => 'LBL_SA',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '1',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
  'su' =>
  array(
    'required' => false,
    'name' => 'su',
    'vname' => 'LBL_SU',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '1',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
  'ua' =>
  array(
    'required' => false,
    'name' => 'ua',
    'vname' => 'LBL_UA',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '1',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
  'uu' =>
  array(
    'required' => false,
    'name' => 'uu',
    'vname' => 'LBL_UU',
    'type' => 'int',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '1',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
'queue_id' =>
  array(
    'required' => false,
    'name' => 'queue_id',
    'vname' => 'LBL_QUEUE_ID',
    'type' => 'varchar',
    'massupdate' => 0,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'inline_edit' => '',
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
    'min' => false,
    'max' => false,
  ),
),
    'relationships'=>array(
),
    'optimistic_locking'=>true,
        'unified_search'=>true,
    );

$dictionary['CGX_Queue']['fields']['actions_c'] = array(
        'name' => 'actions_c',
        'vname' => 'LBL_QUEUES_ACTIONS',
        'type' => 'varchar',
        'source' => 'non-db',
        'inline_edit' => false
);
$dictionary['CGX_Queue']['fields']['parent_type_c'] = array(
        'name' => 'parent_type_c',
        'vname' => 'LBL_QUEUES_PARENT_MODULE',
        'type' => 'varchar',
        'source' => 'non-db',
        'inline_edit' => false
);
$dictionary['CGX_Queue']['fields']['parent_name_c'] = array(
        'name' => 'parent_name_c',
        'vname' => 'LBL_QUEUES_RELATES_TO',
        'type' => 'varchar',
        'source' => 'non-db',
        'inline_edit' => false
);
$dictionary['CGX_Queue']['fields']['queues_c'] = array(
        'name' => 'queues_c',
        'vname' => 'LBL_QUEUES',
        'type' => 'varchar',
        'source' => 'non-db',
        'inline_edit' => false
);

$dictionary["CGX_Queue"]["fields"]["business_process_name"]['function'] = array('name' => 'listBusinessProcess', 'returns' => 'html', 'include' => 'modules/CGX_Queue/metadata/dropdown.php');
$dictionary["CGX_Queue"]["fields"]["queue_name"]['function'] = array('name' => 'listQueueName', 'returns' => 'html', 'include' => 'modules/CGX_Queue/metadata/dropdown.php');
$dictionary["CGX_Queue"]["fields"]["queue_name"]['isMultiSelect'] = true;
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('CGX_Queue', 'CGX_Queue', array('basic', 'assignable', 'security_groups'));
