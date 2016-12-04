<?php
$dictionary['User']['fields']['unavailable_date_from_c'] = array(
    'required' => false,
    'name' => 'unavailable_date_from_c',
    'vname' => 'LBL_UNAVAILABLE_DATE_FROM_C',
    'type' => 'datetimecombo',
    'inline_edit' => false,
    'validation' => array('type' => 'isbefore', 'compareto' => 'unavailable_date_to_c', 'blank' => false),
);