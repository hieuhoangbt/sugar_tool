<?php
class UsersViewPopup extends ViewPopup{


    function display(){
        $activityId = 0;
        if(!empty($_REQUEST['request_data'])){
            $request_data_json = json_decode(str_replace('&quot;', '"', $_REQUEST['request_data']), true);
            if(!empty($request_data_json) && !empty($request_data_json['call_back_function']) && $request_data_json['call_back_function'] == 'set_return_cgx_user_assign' && !empty($request_data_json['passthru_data']['activity_id'])){
                $activityId = $request_data_json['passthru_data']['activity_id'];
            }
        }
        if($activityId || (!empty($_REQUEST['genix_custom']) && !empty($_REQUEST['activity_id']))
            || (!empty($_REQUEST['genix_custom']) && !empty($_REQUEST['bulk_actions'])) ){
            if (empty($_REQUEST['bulk_actions'])) {
                if(!empty($_REQUEST['activity_id'])){
                    $activityId = $_REQUEST['activity_id'];
                }
                global $popupMeta;
                require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
                $userKit = CGX_Kit_Factory::create('users');
                $res = $userKit->findAssigneesFor($activityId);
                $listUser = array();
                if ($res->error == null) {
                    $response = $res->response;
                    if (isset($response['users']) && count($response['users'])) {
                        foreach ($response['users'] as $val) {
                            $listUser[] = $val['userName'];
                        }
                    }
                }
                $listUserName = '';
                if (count($listUser)) {
                    $listUserName = implode("','", $listUser);
                }
                $popupMeta['whereStatement'] = " users.user_name IN ('{$listUserName}') ";
            } else {
                global $popupMeta;
                $listUserName = '';
                $uids = !empty($_REQUEST['uids']) ? json_decode(html_entity_decode($_REQUEST['uids'])) : [];
                if (!empty($uids) && is_array($uids)) {
                    require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
                    $userKit = CGX_Kit_Factory::create('users');
                    $listUser = [];

                    foreach ($uids as $taskId) {
                        $task = BeanFactory::getBean('Tasks', $taskId);

                        if (!empty($task->activity_id_c)) {
                            $res = $userKit->findAssigneesFor($task->activity_id_c);
                            if ($res->error == null) {
                                $response = $res->response;
                                if (isset($response['users']) && count($response['users'])) {
                                    foreach ($response['users'] as $val) {
                                        $listUser[] = $val['userName'];
                                    }
                                }
                            }
                        }
                    }

                    if (count($listUser)) {
                        $listUserName = count($listUser) ? implode("','", $listUser) : '';
                    }
                }

                $popupMeta['whereStatement'] = " users.user_name IN ('{$listUserName}') ";
            }
        }
        parent::display(); 
    }
}