<?php
 // created: 2016-11-15 04:21:44
$layout_defs["Tasks"]["subpanel_setup"]['cgx_slanotification_tasks'] = array (
  'order' => 100,
  'module' => 'CGX_SLANotification',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CGX_SLANOTIFICATION_TASKS_FROM_CGX_SLANOTIFICATION_TITLE',
  'get_subpanel_data' => 'cgx_slanotification_tasks',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
