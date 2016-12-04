<?php
 // created: 2016-11-08 11:27:03
$layout_defs["Tasks"]["subpanel_setup"]['cgx_checklist_tasks'] = array (
  'order' => 100,
  'module' => 'CGX_CheckList',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CGX_CHECKLIST_TASKS_FROM_CGX_CHECKLIST_TITLE',
  'get_subpanel_data' => 'cgx_checklist_tasks',
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
