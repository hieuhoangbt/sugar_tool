<?php
// created: 2016-11-15 04:21:44
$dictionary["cgx_slanotification_tasks"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'cgx_slanotification_tasks' => 
    array (
      'lhs_module' => 'Tasks',
      'lhs_table' => 'tasks',
      'lhs_key' => 'id',
      'rhs_module' => 'CGX_SLANotification',
      'rhs_table' => 'cgx_slanotification',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'cgx_slanotification_tasks_c',
      'join_key_lhs' => 'cgx_slanotification_taskstasks_ida',
      'join_key_rhs' => 'cgx_slanotification_taskscgx_slanotification_idb',
    ),
  ),
  'table' => 'cgx_slanotification_tasks_c',
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
      'name' => 'cgx_slanotification_taskstasks_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'cgx_slanotification_taskscgx_slanotification_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'cgx_slanotification_tasksspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'cgx_slanotification_tasks_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'cgx_slanotification_taskstasks_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'cgx_slanotification_tasks_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'cgx_slanotification_taskscgx_slanotification_idb',
      ),
    ),
  ),
);