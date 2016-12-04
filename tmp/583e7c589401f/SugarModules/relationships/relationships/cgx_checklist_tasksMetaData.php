<?php
// created: 2016-11-08 11:27:03
$dictionary["cgx_checklist_tasks"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'cgx_checklist_tasks' => 
    array (
      'lhs_module' => 'Tasks',
      'lhs_table' => 'tasks',
      'lhs_key' => 'id',
      'rhs_module' => 'CGX_CheckList',
      'rhs_table' => 'cgx_checklist',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'cgx_checklist_tasks_c',
      'join_key_lhs' => 'cgx_checklist_taskstasks_ida',
      'join_key_rhs' => 'cgx_checklist_taskscgx_checklist_idb',
    ),
  ),
  'table' => 'cgx_checklist_tasks_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'cgx_checklist_taskstasks_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'cgx_checklist_taskscgx_checklist_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'cgx_checklist_tasksspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'cgx_checklist_tasks_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cgx_checklist_taskstasks_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'cgx_checklist_tasks_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'cgx_checklist_taskscgx_checklist_idb',
      ),
    ),
  ),
);