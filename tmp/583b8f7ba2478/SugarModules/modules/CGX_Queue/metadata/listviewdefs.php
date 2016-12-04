<?php
$module_name = 'CGX_Queue';
$listViewDefs [$module_name] = 
array (
  'ACTIONS_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_QUEUES_ACTIONS',
    'width' => '20%',
    'default' => true,
    'sortable' => false,
  ),
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => false,
  ),
  'PARENT_TYPE_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_QUEUES_PARENT_MODULE',
    'width' => '10%',
    'default' => true,
    'sortable' => false,
  ),
  'PARENT_NAME_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_QUEUES_RELATES_TO',
    'width' => '10%',
    'default' => true,
    'sortable' => false,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'sortable' => false,
  ),
  'BUSINESS_PROCESS_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BUSINESS_PROCESS_NAME',
    'width' => '15%',
    'default' => true,
  ),
  'QUEUES_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_QUEUES',
    'width' => '10%',
    'default' => true,
    'sortable' => false,
  ),
);
?>
