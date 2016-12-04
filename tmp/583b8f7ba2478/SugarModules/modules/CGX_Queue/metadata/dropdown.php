<?php
function listBusinessProcess($focus, $field, $value, $view){
    require_once('custom/modules/Tasks/TasksModel.php');
    $taskModel = new TasksModel();
    $list = $taskModel->getDistinctBusinessProcessName();

    $html = '';
    $selected = !empty($_REQUEST[$field .'_basic']) ? $_REQUEST[$field .'_basic'] : [];
    foreach ($list as $item) {
        $html .= '<option value="' . $item . '" ' . (in_array($item, $selected) ? 'selected' : '') .' >' . $item .'</option>';
    }
    
    return $html;
}

function listQueueName($focus, $field, $value, $view){
    require_once('custom/modules/Tasks/TasksModel.php');
    $taskModel = new TasksModel();
    $list = $taskModel->getAllQueueName();

    // distinct queue name
    $queue_names = [];
    foreach ($list as $item) {
        $queue_names = array_merge($queue_names, unencodeMultienum($item));
    }
    $queue_names = array_unique($queue_names);

    $html = '';
    $selected = !empty($_REQUEST[$field .'_basic']) ? $_REQUEST[$field .'_basic'] : [];
    foreach ($queue_names as $item) {
        $html .= '<option value="' . $item . '" ' . (in_array($item, $selected) ? 'selected' : '') .' >' . $item .'</option>';
    }

    return $html;
}