<?php
// created: 2016-06-14 04:33:42
$searchFields['Tasks'] = array(
  'name' =>
  array(
    'query_type' => 'default',
  ),
  'contact_name' =>
  array(
    'query_type' => 'default',
    'db_field' =>
    array(
      0 => 'contacts.first_name',
      1 => 'contacts.last_name',
    ),
    'force_unifiedsearch' => true,
  ),
  'current_user_only' =>
  array(
    'query_type' => 'default',
    'db_field' =>
    array(
      0 => 'assigned_user_id',
    ),
    'my_items' => true,
    'vname' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
  ),
  'assigned_user_id' =>
  array(
    'query_type' => 'default',
  ),
  'status' =>
  array(
    'query_type' => 'default',
    'options' => 'task_status_dom',
    'template_var' => 'STATUS_FILTER',
  ),
  'open_only' =>
  array(
    'query_type' => 'default',
    'db_field' =>
    array(
      0 => 'status',
    ),
    'operator' => 'not in',
    'closed_values' =>
    array(
      0 => 'Completed',
      1 => 'Deferred',
    ),
    'type' => 'bool',
  ),
  'favorites_only' =>
  array(
    'query_type' => 'format',
    'operator' => 'subquery',
    'subquery' => 'SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = "Tasks"
			                        and favorites.assigned_user_id = "1") OR NOT ({0}',
    'db_field' =>
    array(
      0 => 'id',
    ),
  ),
);
