<?php

$listViewDefs ['Tasks'] = array(
    'SET_COMPLETE' => array(
        'width' => '1', 
        'label' => 'LBL_LIST_CLOSE', 
        'link' => true,
        'sortable' => false,
        'default' => true,
        'inline_edit' => false,
        'related_fields' => array('status')),
    'ACTIONS_C' =>
    array(
        'label' => 'LBL_ACTIONS_DROP_DOWN',
        'width' => '10%',
        'default' => true,
        'sortable' => false,
        'inline_edit' => false,
    ),
    'NAME' =>
    array(
        'width' => '40%',
        'label' => 'LBL_LIST_SUBJECT',
        'link' => true,
        'default' => true,
        'related_fields' =>
        array(
            0 => 'activity_id_c',
        ),
    ),
    'PARENT_TYPE' =>
    array(
        'type' => 'enum',
        'label' => 'LBL_PARENT_NAME',
        'width' => '10%',
        'default' => true,
    ),
    'PARENT_NAME' =>
    array(
        'width' => '20%',
        'label' => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' =>
        array(
            0 => 'parent_id',
            1 => 'parent_type',
        ),
    ),
    'ASSIGNED_USER_NAME' =>
    array(
        'width' => '2%',
        'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'STATUS' =>
    array(
        'width' => '10%',
        'label' => 'LBL_LIST_STATUS',
        'link' => false,
        'default' => true,
    ),
    'QUEUES_C' =>
    array(
        'label' => 'LBL_QUEUES_TASKS',
        'width' => '20%',
        'default' => true,
        'sortable' => false,
    ),
);
