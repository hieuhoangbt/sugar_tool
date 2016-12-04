<?php 
$manifest = array (
  0 => 
  array (
    'acceptable_sugar_versions' => 
    array (
      0 => '',
    ),
  ),
  1 => 
  array (
    'acceptable_sugar_flavors' => 
    array (
      0 => 'CE',
      1 => 'PRO',
      2 => 'ENT',
    ),
  ),
  'readme' => '',
  'key' => 'CGX Connector',
  'author' => '',
  'description' => 'Casegenix Connector',
  'icon' => '',
  'is_uninstallable' => true,
  'name' => 'CGX Connector',
  'published_date' => '2016-11-24 00:00:00',
  'type' => 'module',
  'version' => '3.0.3',
  'remove_tables' => 'prompt',
);




$installdefs = array (
  'id' => 'CGX Connector',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'CGX_API',
      'class' => 'CGX_API',
      'path' => 'modules/CGX_API/CGX_API.php',
      'tab' => false,
    ),
    1 => 
    array (
      'module' => 'CGX_CheckList',
      'class' => 'CGX_CheckList',
      'path' => 'modules/CGX_CheckList/CGX_CheckList.php',
      'tab' => true,
    ),
    2 => 
    array (
      'module' => 'CGX_SLANotification',
      'class' => 'CGX_SLANotification',
      'path' => 'modules/CGX_SLANotification/CGX_SLANotification.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/cgx_checklist_tasks_Tasks.php',
      'to_module' => 'Tasks',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/cgx_slanotification_tasks_Tasks.php',
      'to_module' => 'Tasks',
    ),
  ),
  'relationships' => 
  array (
    0 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/cgx_checklist_tasksMetaData.php',
    ),
    1 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/cgx_slanotification_tasksMetaData.php',
    ),
  ),
  'image_dir' => '<basepath>/icons',
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/CGX_CheckList.php',
      'to_module' => 'CGX_CheckList',
      'language' => 'en_us',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/Tasks.php',
      'to_module' => 'Tasks',
      'language' => 'en_us',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/custom/include/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/CGX_SLANotification.php',
      'to_module' => 'CGX_SLANotification',
      'language' => 'en_us',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/language/en_us.lang.php',
      'to_module' => 'CGX_CheckList',
      'language' => 'en_us',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/language/en_us.lang.php',
      'to_module' => 'CGX_SLANotification',
      'language' => 'en_us',
    ),
  ),
  'vardefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_checklist_tasks_CGX_CheckList.php',
      'to_module' => 'CGX_CheckList',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_checklist_tasks_Tasks.php',
      'to_module' => 'Tasks',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_slanotification_tasks_CGX_SLANotification.php',
      'to_module' => 'CGX_SLANotification',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_slanotification_tasks_Tasks.php',
      'to_module' => 'Tasks',
    ),
  ),
  'layoutfields' => 
  array (
    0 => 
    array (
      'additional_fields' => 
      array (
      ),
    ),
  ),
  'custom_fields' => 
  array (
    'Tasksactivity_id_c' => 
    array (
      'id' => 'Tasksactivity_id_c',
      'name' => 'activity_id_c',
      'label' => 'LBL_ACTIVITY_ID',
      'comments' => '',
      'help' => 'CGX activityid',
      'module' => 'Tasks',
      'type' => 'int',
      'max_size' => '20',
      'require_option' => '0',
      'default_value' => '',
      'date_modified' => '2016-06-14 03:04:46',
      'deleted' => '0',
      'audited' => '0',
      'mass_update' => '0',
      'duplicate_merge' => '0',
      'reportable' => '1',
      'importable' => 'false',
      'ext1' => '',
      'ext2' => '',
      'ext3' => '',
      'ext4' => '',
      'inline_edit' => false,
    ),
    'Taskscgx_wf_id_c' => 
    array (
      'id' => 'Taskscgx_wf_id_c',
      'name' => 'cgx_wf_id_c',
      'label' => 'LBL_CGX_WF_ID',
      'comments' => '',
      'help' => 'CGX workflow instance',
      'module' => 'Tasks',
      'type' => 'int',
      'max_size' => '20',
      'require_option' => '0',
      'default_value' => '',
      'date_modified' => '2016-06-14 03:05:54',
      'deleted' => '0',
      'audited' => '0',
      'mass_update' => '0',
      'duplicate_merge' => '0',
      'reportable' => '1',
      'importable' => 'false',
      'ext1' => '',
      'ext2' => '',
      'ext3' => '',
      'ext4' => '',
      'inline_edit' => false,
    ),
    'Taskscompletion_options_c' => 
    array (
      'id' => 'Taskscompletion_options_c',
      'name' => 'completion_options_c',
      'label' => 'LBL_COMPLETION_OPTIONS',
      'comments' => '',
      'help' => 'Completion',
      'module' => 'Tasks',
      'type' => 'text',
      'max_size' => NULL,
      'require_option' => '0',
      'default_value' => '',
      'date_modified' => '2016-06-14 03:07:00',
      'deleted' => '0',
      'audited' => '0',
      'mass_update' => '0',
      'duplicate_merge' => '0',
      'reportable' => '1',
      'importable' => 'false',
      'ext1' => '',
      'ext2' => '',
      'ext3' => '',
      'ext4' => '',
      'inline_edit' => false,
    ),
    'Tasksselected_completion_option_c' => 
    array (
      'id' => 'Tasksselected_completion_option_c',
      'name' => 'selected_completion_option_c',
      'label' => 'LBL_SELECTED_COMPLETION_OPTION',
      'comments' => '',
      'help' => 'Selected completion',
      'module' => 'Tasks',
      'type' => 'text',
      'max_size' => NULL,
      'require_option' => '0',
      'default_value' => '',
      'date_modified' => '2016-06-14 03:07:51',
      'deleted' => '0',
      'audited' => '0',
      'mass_update' => '0',
      'duplicate_merge' => '0',
      'reportable' => '1',
      'importable' => 'false',
      'ext1' => '',
      'ext2' => '',
      'ext3' => '',
      'ext4' => '',
      'inline_edit' => false,
    ),
    'Tasksbusiness_process_name_c' => 
    array (
      'id' => 'Tasksbusiness_process_name_c',
      'name' => 'business_process_name_c',
      'label' => 'LBL_SELECTED_COMPLETION_OPTION',
      'comments' => '',
      'help' => 'Selected completion',
      'module' => 'Tasks',
      'type' => 'text',
      'max_size' => NULL,
      'require_option' => '0',
      'default_value' => '',
      'date_modified' => '2016-06-14 03:07:51',
      'deleted' => '0',
      'audited' => '0',
      'mass_update' => '0',
      'duplicate_merge' => '0',
      'reportable' => '1',
      'importable' => 'false',
      'ext1' => '',
      'ext2' => '',
      'ext3' => '',
      'ext4' => '',
      'inline_edit' => false,
    ),
    'Userscgx_encrypted_password_c' => 
    array (
      'id' => 'Userscgx_encrypted_password_c',
      'name' => 'cgx_encrypted_password_c',
      'label' => 'CGX PASSWORD',
      'comments' => '',
      'help' => 'Password to be encrypted using AES algorithm',
      'module' => 'Users',
      'type' => 'text',
      'max_size' => NULL,
      'require_option' => '0',
      'default_value' => '',
      'date_modified' => '2016-11-08 04:21:00',
      'deleted' => '0',
      'audited' => '0',
      'mass_update' => '0',
      'duplicate_merge' => '0',
      'reportable' => '1',
      'importable' => 'false',
      'ext1' => '',
      'ext2' => '',
      'ext3' => '',
      'ext4' => '',
      'inline_edit' => false,
    ),
  ),
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/EntryPointRegistry/cgx_entrypoint_registry.php',
      'to' => 'custom/Extension/application/Ext/EntryPointRegistry/cgx_entrypoint_registry.php',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/EntryPointRegistry/entrypoint_registry_esb.php',
      'to' => 'custom/Extension/application/Ext/EntryPointRegistry/entrypoint_registry_esb.php',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/JSGroupings/jsgroup_addCGXActionMenuCus.js.php',
      'to' => 'custom/Extension/application/Ext/JSGroupings/jsgroup_addCGXActionMenuCus.js.php',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/JSGroupings/jsgroup_customCGXStyle.css.js.php',
      'to' => 'custom/Extension/application/Ext/JSGroupings/jsgroup_customCGXStyle.css.js.php',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/JSGroupings/jsgroup_customTasks.js.php',
      'to' => 'custom/Extension/application/Ext/JSGroupings/jsgroup_customTasks.js.php',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/JSGroupings/jsgroup_customTasksBulk.js.php',
      'to' => 'custom/Extension/application/Ext/JSGroupings/jsgroup_customTasksBulk.js.php',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/application/Ext/JSGroupings/jsgroup_dropdownCGX.css.js.php',
      'to' => 'custom/Extension/application/Ext/JSGroupings/jsgroup_dropdownCGX.css.js.php',
    ),
    7 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/ACLRoles/Ext/Language/en_us.ACLRoles.php',
      'to' => 'custom/Extension/modules/ACLRoles/Ext/Language/en_us.ACLRoles.php',
    ),
    8 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/ACLRoles/Ext/Vardefs/customfield_casegenix_role.php',
      'to' => 'custom/Extension/modules/ACLRoles/Ext/Vardefs/customfield_casegenix_role.php',
    ),
    9 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/ACLRoles/Ext/Vardefs/sugarfield_casegenix_role.php',
      'to' => 'custom/Extension/modules/ACLRoles/Ext/Vardefs/sugarfield_casegenix_role.php',
    ),
    10 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/AOW_Actions/Ext/Actions/AOW_Actions.php',
      'to' => 'custom/Extension/modules/AOW_Actions/Ext/Actions/AOW_Actions.php',
    ),
    11 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/AOW_Actions/Ext/Language/en_us.AOW_Actions.php',
      'to' => 'custom/Extension/modules/AOW_Actions/Ext/Language/en_us.AOW_Actions.php',
    ),
    12 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Administration/Ext/Administration/CGXAPI_Module.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Administration/CGXAPI_Module.php',
    ),
    13 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Administration/Ext/Language/en_us.CGXAPI_Module.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Language/en_us.CGXAPI_Module.php',
    ),
    14 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/CGX_Queue/Ext/Vardefs/sugarfield_assigned_user_name.php',
      'to' => 'custom/Extension/modules/CGX_Queue/Ext/Vardefs/sugarfield_assigned_user_name.php',
    ),
    15 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/CGX_Queue/Ext/Vardefs/sugarfield_name.php',
      'to' => 'custom/Extension/modules/CGX_Queue/Ext/Vardefs/sugarfield_name.php',
    ),
    16 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Schedulers/Ext/Language/en_us.send_out_notification_batch_job.php',
      'to' => 'custom/Extension/modules/Schedulers/Ext/Language/en_us.send_out_notification_batch_job.php',
    ),
    17 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Schedulers/Ext/ScheduledTasks/send_out_notification_batch_job.php',
      'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/send_out_notification_batch_job.php',
    ),
    18 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Language/en_us.CGX.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Language/en_us.CGX.php',
    ),
    19 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/LogicHooks/CGXConnector.logic_hooks.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/LogicHooks/CGXConnector.logic_hooks.php',
    ),
    20 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/actions_c.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/actions_c.php',
    ),
    21 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/custom_field_is_assignment_ff.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/custom_field_is_assignment_ff.php',
    ),
    22 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/queues_c.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/queues_c.php',
    ),
    23 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_activity_id_c.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_activity_id_c.php',
    ),
    24 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_assigned_user_name.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_assigned_user_name.php',
    ),
    25 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_cgx_wf_id_c.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_cgx_wf_id_c.php',
    ),
    26 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_completion_options_c.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_completion_options_c.php',
    ),
    27 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_name.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_name.php',
    ),
    28 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_parent_name.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_parent_name.php',
    ),
    29 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_parent_type.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_parent_type.php',
    ),
    30 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_set_complete.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_set_complete.php',
    ),
    31 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_status.php',
      'to' => 'custom/Extension/modules/Tasks/Ext/Vardefs/sugarfield_status.php',
    ),
    32 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Users/Ext/Language/en_us.lang.ext.php',
      'to' => 'custom/Extension/modules/Users/Ext/Language/en_us.lang.ext.php',
    ),
    33 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Users/Ext/Vardefs/customfield_assigned_user_id.php',
      'to' => 'custom/Extension/modules/Users/Ext/Vardefs/customfield_assigned_user_id.php',
    ),
    34 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Users/Ext/Vardefs/customfield_cgx_pad_password_c.php',
      'to' => 'custom/Extension/modules/Users/Ext/Vardefs/customfield_cgx_pad_password_c.php',
    ),
    35 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Users/Ext/Vardefs/customfield_unavailable_date_from_c.php',
      'to' => 'custom/Extension/modules/Users/Ext/Vardefs/customfield_unavailable_date_from_c.php',
    ),
    36 => 
    array (
      'from' => '<basepath>/SugarModules/custom/Extension/modules/Users/Ext/Vardefs/customfield_unavailable_date_to_c.php',
      'to' => 'custom/Extension/modules/Users/Ext/Vardefs/customfield_unavailable_date_to_c.php',
    ),
    37 => 
    array (
      'from' => '<basepath>/SugarModules/custom/entrypoint_registry.php',
      'to' => 'custom/entrypoint_registry.php',
    ),
    38 => 
    array (
      'from' => '<basepath>/SugarModules/custom/include/SugarFields/Fields/Enum/SugarFieldEnum.php',
      'to' => 'custom/include/SugarFields/Fields/Enum/SugarFieldEnum.php',
    ),
    39 => 
    array (
      'from' => '<basepath>/SugarModules/custom/include/javascripts/customCGXStyle.css.js',
      'to' => 'custom/include/javascripts/customCGXStyle.css.js',
    ),
    40 => 
    array (
      'from' => '<basepath>/SugarModules/custom/include/javascripts/dropdownCGX.css.js',
      'to' => 'custom/include/javascripts/dropdownCGX.css.js',
    ),
    41 => 
    array (
      'from' => '<basepath>/SugarModules/custom/include/language/en_us.lang.php',
      'to' => 'custom/include/language/en_us.lang.php',
    ),
    42 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/ACLRoleCustom.php',
      'to' => 'custom/modules/ACLRoles/ACLRoleCustom.php',
    ),
    43 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/DetailView.php',
      'to' => 'custom/modules/ACLRoles/DetailView.php',
    ),
    44 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/DetailView.tpl',
      'to' => 'custom/modules/ACLRoles/DetailView.tpl',
    ),
    45 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/EditView.php',
      'to' => 'custom/modules/ACLRoles/EditView.php',
    ),
    46 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/EditView.tpl',
      'to' => 'custom/modules/ACLRoles/EditView.tpl',
    ),
    47 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/RoleBasedQueuePermission.php',
      'to' => 'custom/modules/ACLRoles/RoleBasedQueuePermission.php',
    ),
    48 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/Save.php',
      'to' => 'custom/modules/ACLRoles/Save.php',
    ),
    49 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/aclrole_save.php',
      'to' => 'custom/modules/ACLRoles/aclrole_save.php',
    ),
    50 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/metadata/listviewdefs.php',
      'to' => 'custom/modules/ACLRoles/metadata/listviewdefs.php',
    ),
    51 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/ACLRoles/views/view.classic.php',
      'to' => 'custom/modules/ACLRoles/views/view.classic.php',
    ),
    52 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/AOW_Actions/actions/actionTriggerCasegenixBusinessProcess.js',
      'to' => 'custom/modules/AOW_Actions/actions/actionTriggerCasegenixBusinessProcess.js',
    ),
    53 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/AOW_Actions/actions/actionTriggerCasegenixBusinessProcess.php',
      'to' => 'custom/modules/AOW_Actions/actions/actionTriggerCasegenixBusinessProcess.php',
    ),
    54 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/CGX_SLANotification/SLANotificationLogicHooks.php',
      'to' => 'custom/modules/CGX_SLANotification/SLANotificationLogicHooks.php',
    ),
    55 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/DiplayBussineProcess.php',
      'to' => 'custom/modules/DiplayBussineProcess.php',
    ),
    56 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/CGXConnectorTaskLogichook.php',
      'to' => 'custom/modules/Tasks/CGXConnectorTaskLogichook.php',
    ),
    57 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/CGXEndPoint.php',
      'to' => 'custom/modules/Tasks/CGXEndPoint.php',
    ),
    58 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/Ext/Language/en_us.lang.ext.php',
      'to' => 'custom/modules/Tasks/Ext/Language/en_us.lang.ext.php',
    ),
    59 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/Ext/Utils/custom_utils.ext.php',
      'to' => 'custom/modules/Tasks/Ext/Utils/custom_utils.ext.php',
    ),
    60 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/Ext/Vardefs/vardefs.ext.php',
      'to' => 'custom/modules/Tasks/Ext/Vardefs/vardefs.ext.php',
    ),
    61 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/Tasks.php',
      'to' => 'custom/modules/Tasks/Tasks.php',
    ),
    62 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/TasksHook.php',
      'to' => 'custom/modules/Tasks/TasksHook.php',
    ),
    63 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/TasksModel.php',
      'to' => 'custom/modules/Tasks/TasksModel.php',
    ),
    64 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/Utils/custom_utils.ext.php',
      'to' => 'custom/modules/Tasks/Utils/custom_utils.ext.php',
    ),
    65 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/controller.php',
      'to' => 'custom/modules/Tasks/controller.php',
    ),
    66 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/js/CGX_Connector_Editview.js',
      'to' => 'custom/modules/Tasks/js/CGX_Connector_Editview.js',
    ),
    67 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/language/en_us.lang.php',
      'to' => 'custom/modules/Tasks/language/en_us.lang.php',
    ),
    68 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/metadata/SearchFields.php',
      'to' => 'custom/modules/Tasks/metadata/SearchFields.php',
    ),
    69 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/metadata/detailviewdefs.php',
      'to' => 'custom/modules/Tasks/metadata/detailviewdefs.php',
    ),
    70 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/metadata/editviewdefs.php',
      'to' => 'custom/modules/Tasks/metadata/editviewdefs.php',
    ),
    71 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/metadata/listviewdefs.php',
      'to' => 'custom/modules/Tasks/metadata/listviewdefs.php',
    ),
    72 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/tpls/ListViewTasks.tpl',
      'to' => 'custom/modules/Tasks/tpls/ListViewTasks.tpl',
    ),
    73 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/tpls/SearchForm/SearchFormTasks.tpl',
      'to' => 'custom/modules/Tasks/tpls/SearchForm/SearchFormTasks.tpl',
    ),
    74 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/views/view.detail.php',
      'to' => 'custom/modules/Tasks/views/view.detail.php',
    ),
    75 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Tasks/views/view.list.php',
      'to' => 'custom/modules/Tasks/views/view.list.php',
    ),
    76 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/ChangePassword.php',
      'to' => 'custom/modules/Users/ChangePassword.php',
    ),
    77 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/Changenewpassword.php',
      'to' => 'custom/modules/Users/Changenewpassword.php',
    ),
    78 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/Save.php',
      'to' => 'custom/modules/Users/Save.php',
    ),
    79 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/metadata/popupdefs.php',
      'to' => 'custom/modules/Users/metadata/popupdefs.php',
    ),
    80 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/users_save.php',
      'to' => 'custom/modules/Users/users_save.php',
    ),
    81 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/utils/helpers.php',
      'to' => 'custom/modules/Users/utils/helpers.php',
    ),
    82 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Users/views/view.popup.php',
      'to' => 'custom/modules/Users/views/view.popup.php',
    ),
    83 => 
    array (
      'from' => '<basepath>/SugarModules/custom/modules/cgxEndpoint.php',
      'to' => 'custom/modules/cgxEndpoint.php',
    ),
    84 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/images/diagram-icon_01.png',
      'to' => 'custom/themes/SuiteCGX/images/diagram-icon_01.png',
    ),
    85 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/images/diagram-icon_02.png',
      'to' => 'custom/themes/SuiteCGX/images/diagram-icon_02.png',
    ),
    86 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/images/diagram-icon_03.png',
      'to' => 'custom/themes/SuiteCGX/images/diagram-icon_03.png',
    ),
    87 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/images/icon_basic.png',
      'to' => 'custom/themes/SuiteCGX/images/icon_basic.png',
    ),
    88 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/images/icon_process.png',
      'to' => 'custom/themes/SuiteCGX/images/icon_process.png',
    ),
    89 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/tpls/_head.tpl',
      'to' => 'custom/themes/SuiteCGX/tpls/_head.tpl',
    ),
    90 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteCGX/tpls/header.tpl',
      'to' => 'custom/themes/SuiteCGX/tpls/header.tpl',
    ),
    91 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteP/css/customADVStyle.css',
      'to' => 'custom/themes/SuiteP/css/customADVStyle.css',
    ),
    92 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteP/css/customCGXStyle.css',
      'to' => 'custom/themes/SuiteP/css/customCGXStyle.css',
    ),
    93 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteP/images/icon_basic.png',
      'to' => 'custom/themes/SuiteP/images/icon_basic.png',
    ),
    94 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteP/images/icon_process.png',
      'to' => 'custom/themes/SuiteP/images/icon_process.png',
    ),
    95 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteP/tpls/_headerModuleList.tpl',
      'to' => 'custom/themes/SuiteP/tpls/_headerModuleList.tpl',
    ),
    96 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/SuiteR/tpls/_headerModuleList.tpl',
      'to' => 'custom/themes/SuiteR/tpls/_headerModuleList.tpl',
    ),
    97 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/css/customCGX.css',
      'to' => 'custom/themes/default/css/customCGX.css',
    ),
    98 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/css/custom_tooltip.css',
      'to' => 'custom/themes/default/css/custom_tooltip.css',
    ),
    99 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/css/dropdownCGX.css',
      'to' => 'custom/themes/default/css/dropdownCGX.css',
    ),
    100 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/images/diagram-icon_01.png',
      'to' => 'custom/themes/default/images/diagram-icon_01.png',
    ),
    101 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/images/diagram-icon_02.png',
      'to' => 'custom/themes/default/images/diagram-icon_02.png',
    ),
    102 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/images/diagram-icon_03.png',
      'to' => 'custom/themes/default/images/diagram-icon_03.png',
    ),
    103 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/images/icon_basic.png',
      'to' => 'custom/themes/default/images/icon_basic.png',
    ),
    104 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/images/icon_process.png',
      'to' => 'custom/themes/default/images/icon_process.png',
    ),
    105 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/js/addADVActionMenuCus.js',
      'to' => 'custom/themes/default/js/addADVActionMenuCus.js',
    ),
    106 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/js/addCGXActionMenuCus.js',
      'to' => 'custom/themes/default/js/addCGXActionMenuCus.js',
    ),
    107 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/js/customTasks.js',
      'to' => 'custom/themes/default/js/customTasks.js',
    ),
    108 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/js/customTasksBulk.js',
      'to' => 'custom/themes/default/js/customTasksBulk.js',
    ),
    109 => 
    array (
      'from' => '<basepath>/SugarModules/custom/themes/default/js/custom_global.js',
      'to' => 'custom/themes/default/js/custom_global.js',
    ),
    110 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/CGX_API.php',
      'to' => 'modules/CGX_API/CGX_API.php',
    ),
    111 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/CGX_API_sugar.php',
      'to' => 'modules/CGX_API/CGX_API_sugar.php',
    ),
    112 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/Menu.php',
      'to' => 'modules/CGX_API/Menu.php',
    ),
    113 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/CGX_IO.php',
      'to' => 'modules/CGX_API/api/CGX_IO.php',
    ),
    114 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/CGX_Kit.php',
      'to' => 'modules/CGX_API/api/CGX_Kit.php',
    ),
    115 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/CGX_Kit_Factory.php',
      'to' => 'modules/CGX_API/api/CGX_Kit_Factory.php',
    ),
    116 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/CGX_Response.php',
      'to' => 'modules/CGX_API/api/CGX_Response.php',
    ),
    117 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/ESB_Factory.php',
      'to' => 'modules/CGX_API/api/ESB_Factory.php',
    ),
    118 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit.php',
    ),
    119 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit_Base.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit_Base.php',
    ),
    120 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit_Queues.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit_Queues.php',
    ),
    121 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit_Roles.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit_Roles.php',
    ),
    122 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit_Tasks.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit_Tasks.php',
    ),
    123 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit_Users.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit_Users.php',
    ),
    124 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/Kit/CGX_Kit_Workflow.php',
      'to' => 'modules/CGX_API/api/Kit/CGX_Kit_Workflow.php',
    ),
    125 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/api/cgxApi.php',
      'to' => 'modules/CGX_API/api/cgxApi.php',
    ),
    126 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/controller.php',
      'to' => 'modules/CGX_API/controller.php',
    ),
    127 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/entity/CGX_Error.php',
      'to' => 'modules/CGX_API/entity/CGX_Error.php',
    ),
    128 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/entity/Competition.php',
      'to' => 'modules/CGX_API/entity/Competition.php',
    ),
    129 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/language/en_us.lang.php',
      'to' => 'modules/CGX_API/language/en_us.lang.php',
    ),
    130 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/SearchFields.php',
      'to' => 'modules/CGX_API/metadata/SearchFields.php',
    ),
    131 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/dashletviewdefs.php',
      'to' => 'modules/CGX_API/metadata/dashletviewdefs.php',
    ),
    132 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/detailviewdefs.php',
      'to' => 'modules/CGX_API/metadata/detailviewdefs.php',
    ),
    133 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/dropdown.php',
      'to' => 'modules/CGX_API/metadata/dropdown.php',
    ),
    134 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/editviewdefs.php',
      'to' => 'modules/CGX_API/metadata/editviewdefs.php',
    ),
    135 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/listviewdefs.php',
      'to' => 'modules/CGX_API/metadata/listviewdefs.php',
    ),
    136 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/metafiles.php',
      'to' => 'modules/CGX_API/metadata/metafiles.php',
    ),
    137 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/popupdefs.php',
      'to' => 'modules/CGX_API/metadata/popupdefs.php',
    ),
    138 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/quickcreatedefs.php',
      'to' => 'modules/CGX_API/metadata/quickcreatedefs.php',
    ),
    139 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/searchdefs.php',
      'to' => 'modules/CGX_API/metadata/searchdefs.php',
    ),
    140 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/studio.php',
      'to' => 'modules/CGX_API/metadata/studio.php',
    ),
    141 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/metadata/subpanels/default.php',
      'to' => 'modules/CGX_API/metadata/subpanels/default.php',
    ),
    142 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/tpls/settings.tpl',
      'to' => 'modules/CGX_API/tpls/settings.tpl',
    ),
    143 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/vardefs.php',
      'to' => 'modules/CGX_API/vardefs.php',
    ),
    144 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/views/view.edit.php',
      'to' => 'modules/CGX_API/views/view.edit.php',
    ),
    145 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_API/views/view.settings.php',
      'to' => 'modules/CGX_API/views/view.settings.php',
    ),
    146 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/CGX_CheckList.php',
      'to' => 'modules/CGX_CheckList/CGX_CheckList.php',
    ),
    147 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/CGX_CheckList_sugar.php',
      'to' => 'modules/CGX_CheckList/CGX_CheckList_sugar.php',
    ),
    148 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/Menu.php',
      'to' => 'modules/CGX_CheckList/Menu.php',
    ),
    149 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/SearchFields.php',
      'to' => 'modules/CGX_CheckList/metadata/SearchFields.php',
    ),
    150 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/dashletviewdefs.php',
      'to' => 'modules/CGX_CheckList/metadata/dashletviewdefs.php',
    ),
    151 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/detailviewdefs.php',
      'to' => 'modules/CGX_CheckList/metadata/detailviewdefs.php',
    ),
    152 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/editviewdefs.php',
      'to' => 'modules/CGX_CheckList/metadata/editviewdefs.php',
    ),
    153 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/listviewdefs.php',
      'to' => 'modules/CGX_CheckList/metadata/listviewdefs.php',
    ),
    154 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/metafiles.php',
      'to' => 'modules/CGX_CheckList/metadata/metafiles.php',
    ),
    155 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/popupdefs.php',
      'to' => 'modules/CGX_CheckList/metadata/popupdefs.php',
    ),
    156 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/quickcreatedefs.php',
      'to' => 'modules/CGX_CheckList/metadata/quickcreatedefs.php',
    ),
    157 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/searchdefs.php',
      'to' => 'modules/CGX_CheckList/metadata/searchdefs.php',
    ),
    158 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/studio.php',
      'to' => 'modules/CGX_CheckList/metadata/studio.php',
    ),
    159 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/metadata/subpanels/default.php',
      'to' => 'modules/CGX_CheckList/metadata/subpanels/default.php',
    ),
    160 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_CheckList/vardefs.php',
      'to' => 'modules/CGX_CheckList/vardefs.php',
    ),
    161 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/CGX_SLANotification.php',
      'to' => 'modules/CGX_SLANotification/CGX_SLANotification.php',
    ),
    162 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/CGX_SLANotification_sugar.php',
      'to' => 'modules/CGX_SLANotification/CGX_SLANotification_sugar.php',
    ),
    163 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/Dashlets/CGX_SLANotificationDashlet/CGX_SLANotificationDashlet.meta.php',
      'to' => 'modules/CGX_SLANotification/Dashlets/CGX_SLANotificationDashlet/CGX_SLANotificationDashlet.meta.php',
    ),
    164 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/Dashlets/CGX_SLANotificationDashlet/CGX_SLANotificationDashlet.php',
      'to' => 'modules/CGX_SLANotification/Dashlets/CGX_SLANotificationDashlet/CGX_SLANotificationDashlet.php',
    ),
    165 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/Menu.php',
      'to' => 'modules/CGX_SLANotification/Menu.php',
    ),
    166 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/SearchFields.php',
      'to' => 'modules/CGX_SLANotification/metadata/SearchFields.php',
    ),
    167 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/dashletviewdefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/dashletviewdefs.php',
    ),
    168 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/detailviewdefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/detailviewdefs.php',
    ),
    169 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/editviewdefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/editviewdefs.php',
    ),
    170 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/listviewdefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/listviewdefs.php',
    ),
    171 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/metafiles.php',
      'to' => 'modules/CGX_SLANotification/metadata/metafiles.php',
    ),
    172 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/popupdefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/popupdefs.php',
    ),
    173 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/quickcreatedefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/quickcreatedefs.php',
    ),
    174 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/searchdefs.php',
      'to' => 'modules/CGX_SLANotification/metadata/searchdefs.php',
    ),
    175 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/studio.php',
      'to' => 'modules/CGX_SLANotification/metadata/studio.php',
    ),
    176 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/metadata/subpanels/default.php',
      'to' => 'modules/CGX_SLANotification/metadata/subpanels/default.php',
    ),
    177 => 
    array (
      'from' => '<basepath>/SugarModules/modules/CGX_SLANotification/vardefs.php',
      'to' => 'modules/CGX_SLANotification/vardefs.php',
    ),
    178 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/cgx_checklist_tasks_Tasks.php',
      'to' => 'relationships/layoutdefs/cgx_checklist_tasks_Tasks.php',
    ),
    179 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/cgx_slanotification_tasks_Tasks.php',
      'to' => 'relationships/layoutdefs/cgx_slanotification_tasks_Tasks.php',
    ),
    180 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/relationships/cgx_checklist_tasksMetaData.php',
      'to' => 'relationships/relationships/cgx_checklist_tasksMetaData.php',
    ),
    181 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/relationships/cgx_slanotification_tasksMetaData.php',
      'to' => 'relationships/relationships/cgx_slanotification_tasksMetaData.php',
    ),
    182 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_checklist_tasks_CGX_CheckList.php',
      'to' => 'relationships/vardefs/cgx_checklist_tasks_CGX_CheckList.php',
    ),
    183 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_checklist_tasks_Tasks.php',
      'to' => 'relationships/vardefs/cgx_checklist_tasks_Tasks.php',
    ),
    184 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_slanotification_tasks_CGX_SLANotification.php',
      'to' => 'relationships/vardefs/cgx_slanotification_tasks_CGX_SLANotification.php',
    ),
    185 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/cgx_slanotification_tasks_Tasks.php',
      'to' => 'relationships/vardefs/cgx_slanotification_tasks_Tasks.php',
    ),
    186 => 
    array (
      'from' => '<basepath>/SugarModules/tests/suitecrm_enhancements/bootstrap.php',
      'to' => 'tests/suitecrm_enhancements/bootstrap.php',
    ),
    187 => 
    array (
      'from' => '<basepath>/SugarModules/tests/suitecrm_enhancements/phpunit.xml.dist',
      'to' => 'tests/suitecrm_enhancements/phpunit.xml.dist',
    ),
    188 => 
    array (
      'from' => '<basepath>/SugarModules/tests/suitecrm_enhancements/tests/ApiTest.php',
      'to' => 'tests/suitecrm_enhancements/tests/ApiTest.php',
    ),
    189 => 
    array (
      'from' => '<basepath>/SugarModules/tests/suitecrm_enhancements/tests/batchJobTest.php',
      'to' => 'tests/suitecrm_enhancements/tests/batchJobTest.php',
    ),
    190 => 
    array (
      'from' => '<basepath>/SugarModules/tests/suitecrm_enhancements/tests/configTest.php',
      'to' => 'tests/suitecrm_enhancements/tests/configTest.php',
    ),
    191 => 
    array (
      'from' => '<basepath>/SugarModules/tests/suitecrm_enhancements/tests/modules/Users/triggerCasegenixUsersSaveTest.php',
      'to' => 'tests/suitecrm_enhancements/tests/modules/Users/triggerCasegenixUsersSaveTest.php',
    ),
  ),
  'logic_hooks' => 
  array (
    0 => 
    array (
      'module' => 'ACLRoles',
      'hook' => 'after_save',
      'order' => 99,
      'description' => 'Casegenix Trigger ACLRoles Save',
      'file' => 'custom/modules/ACLRoles/aclrole_save.php',
      'class' => 'ACLRoles_Save',
      'function' => 'triggerCasegenixACLRolesSave',
    ),
    1 => 
    array (
      'module' => 'ACLRoles',
      'hook' => 'before_save',
      'order' => 99,
      'description' => 'Casegenix Trigger ACLRoles Save',
      'file' => 'custom/modules/ACLRoles/aclrole_save.php',
      'class' => 'ACLRoles_Save',
      'function' => 'triggerCasegenixACLRolesBeforeSave',
    ),
    2 => 
    array (
      'module' => 'ACLRoles',
      'hook' => 'after_relationship_add',
      'order' => 1,
      'description' => 'Map role to CGX after add role from suitecrm',
      'file' => 'custom/modules/Users/users_save.php',
      'class' => 'Users_Save',
      'function' => 'setRoleForUserToCGX',
    ),
    3 => 
    array (
      'module' => 'ACLRoles',
      'hook' => 'after_relationship_delete',
      'order' => 1,
      'description' => 'Map role to CGX after deleted role from suitecrm',
      'file' => 'custom/modules/Users/users_save.php',
      'class' => 'Users_Save',
      'function' => 'setRoleForUserToCGX',
    ),
    4 => 
    array (
      'hook' => 'after_ui_frame',
      'order' => 2,
      'description' => 'Add Diplay Bussine Process button for all module',
      'file' => 'custom/modules/DiplayBussineProcess.php',
      'class' => 'DiplayBussineProcessButtons',
      'function' => 'add',
    ),
    5 => 
    array (
      'module' => 'Users',
      'hook' => 'before_save',
      'order' => 99,
      'description' => 'Casegenix Trigger Users Before Save',
      'file' => 'custom/modules/Users/users_save.php',
      'class' => 'Users_Save',
      'function' => 'triggerCasegenixUsersSave',
    ),
    6 => 
    array (
      'hook' => 'after_ui_frame',
      'order' => 99,
      'description' => 'Display Assignment Actions in List View',
      'file' => 'custom/modules/Tasks/TasksHook.php',
      'class' => 'TasksHook',
      'function' => 'displayAssignmentActions',
    ),
    7 => 
    array (
      'hook' => 'after_delete',
      'order' => 99,
      'description' => 'CGX Deletion of Records',
      'file' => 'custom/modules/Tasks/TasksHook.php',
      'class' => 'TasksHook',
      'function' => 'deleteCGXRecords',
    ),
    8 => 
    array (
      'module' => 'Tasks',
      'hook' => 'after_save',
      'order' => 101,
      'description' => 'Update Assigned User',
      'file' => 'custom/modules/Tasks/CGXConnectorTaskLogichook.php',
      'class' => 'CGXConnectorTaskLogichook',
      'function' => 'updateAssignedUserRoleBasePermission',
    ),
    9 => 
    array (
      'module' => 'Users',
      'hook' => 'after_relationship_add',
      'order' => 1,
      'description' => 'Map role to CGX after add role from suitecrm',
      'file' => 'custom/modules/Users/users_save.php',
      'class' => 'Users_Save',
      'function' => 'setRoleForUserToCGX',
    ),
    10 => 
    array (
      'module' => 'Users',
      'hook' => 'after_relationship_delete',
      'order' => 1,
      'description' => 'Map role to CGX after deleted role from suitecrm',
      'file' => 'custom/modules/Users/users_save.php',
      'class' => 'Users_Save',
      'function' => 'setRoleForUserToCGX',
    ),
    11 => 
    array (
      'module' => 'CGX_SLANotification',
      'hook' => 'before_save',
      'order' => 1,
      'description' => 'Set relationship between SLA Notification and Tasks when create SLA Notification via WS',
      'file' => 'custom/modules/CGX_SLANotification/SLANotificationLogicHooks.php',
      'class' => 'SLANotificationLogicHook',
      'function' => 'setRelationshipToTaskByActivityId',
    ),
  ),
  'post_uninstall' => 
  array (
    0 => '<basepath>/scripts/post_uninstall.php',
  ),
);





?>