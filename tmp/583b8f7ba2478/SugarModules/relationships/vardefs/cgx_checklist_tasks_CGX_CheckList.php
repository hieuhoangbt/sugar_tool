<?php
// created: 2016-11-08 11:27:03
$dictionary["CGX_CheckList"]["fields"]["cgx_checklist_tasks"] = array (
  'name' => 'cgx_checklist_tasks',
  'type' => 'link',
  'relationship' => 'cgx_checklist_tasks',
  'source' => 'non-db',
  'module' => 'Tasks',
  'bean_name' => 'Task',
  'vname' => 'LBL_CGX_CHECKLIST_TASKS_FROM_TASKS_TITLE',
  'id_name' => 'cgx_checklist_taskstasks_ida',
);
$dictionary["CGX_CheckList"]["fields"]["cgx_checklist_tasks_name"] = array (
  'name' => 'cgx_checklist_tasks_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CGX_CHECKLIST_TASKS_FROM_TASKS_TITLE',
  'save' => true,
  'id_name' => 'cgx_checklist_taskstasks_ida',
  'link' => 'cgx_checklist_tasks',
  'table' => 'tasks',
  'module' => 'Tasks',
  'rname' => 'name',
);
$dictionary["CGX_CheckList"]["fields"]["cgx_checklist_taskstasks_ida"] = array (
  'name' => 'cgx_checklist_taskstasks_ida',
  'type' => 'link',
  'relationship' => 'cgx_checklist_tasks',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CGX_CHECKLIST_TASKS_FROM_CGX_CHECKLIST_TITLE',
);
