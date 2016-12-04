<?php
// created: 2016-11-15 04:21:44
$dictionary["CGX_SLANotification"]["fields"]["cgx_slanotification_tasks"] = array (
  'name' => 'cgx_slanotification_tasks',
  'type' => 'link',
  'relationship' => 'cgx_slanotification_tasks',
  'source' => 'non-db',
  'module' => 'Tasks',
  'bean_name' => 'Task',
  'vname' => 'LBL_CGX_SLANOTIFICATION_TASKS_FROM_TASKS_TITLE',
  'id_name' => 'cgx_slanotification_taskstasks_ida',
);
$dictionary["CGX_SLANotification"]["fields"]["cgx_slanotification_tasks_name"] = array (
  'name' => 'cgx_slanotification_tasks_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CGX_SLANOTIFICATION_TASKS_FROM_TASKS_TITLE',
  'save' => true,
  'id_name' => 'cgx_slanotification_taskstasks_ida',
  'link' => 'cgx_slanotification_tasks',
  'table' => 'tasks',
  'module' => 'Tasks',
  'rname' => 'name',
);
$dictionary["CGX_SLANotification"]["fields"]["cgx_slanotification_taskstasks_ida"] = array (
  'name' => 'cgx_slanotification_taskstasks_ida',
  'type' => 'link',
  'relationship' => 'cgx_slanotification_tasks',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CGX_SLANOTIFICATION_TASKS_FROM_CGX_SLANOTIFICATION_TITLE',
);
