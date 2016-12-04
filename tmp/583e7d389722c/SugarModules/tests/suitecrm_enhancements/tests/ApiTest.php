<?php

require_once ('modules/Configurator/Configurator.php');
require_once ('modules/CGX_API/api/CGX_Kit_Factory.php');

class ApiTest extends PHPUnit_Framework_TestCase {

    public static function getConfig() {
        require_once('modules/CGX_API/api/CGX_IO.php');
        require_once 'modules/Configurator/Configurator.php';
        $inOut = new CGX_IO();
        $wsdl = 'http://casegenix-qa.genixventures.com:9090/casegenix';
        $username = 'hdwebsoft';
        $password = 'dragon459';
        $configurator = new Configurator();
        $configurator->loadConfig();
        $configurator->config['CGX_API_cgx_api_url'] = $wsdl;
        $configurator->config['CGX_API_cgx_public_url'] = 'http://casegenix-qa.genixventures.com:9090/casegenix/wfInstanceViewer';
        $configurator->config['CGX_API_cgx_api_username'] = $username;
        $configurator->config['CGX_API_cgx_api_password'] = $password;
        $configurator->config['Casegenix.aes.encryption.secret.key'] = 'TheBestSecretKey';
        $inOut->setAccessConfig($configurator);
        return $inOut;
    }

//    public function test_connection() {
//        $kit_users = CGX_Kit_Factory::create('users');
//        $inOutTest = self::getConfig();
//        $kit_users->setInOut($inOutTest);
//        $username = 'hdwebsoft';
//        $password = 'dragon459';
//        $data = $kit_users->authenticate($username, $password);
//        $responseError = @$data->getError();
//        $this->assertEmpty($responseError);
//    }
//
//    public function test_users_create() {
//        $userName = "test" . rand(0000000000, 10000000000);
//        $postData = '
//            { 
//                "SystemUserDetails" :
//                {
//                    "addressLine1" : "",
//                    "addressLine2" : "",
//                    "email" : "",
//                    "faxNo" : "",
//                    "firstName" : "test",
//                    "groupMailAddress" : "",
//                    "password" : "123123123",
//                    "phoneNumber" : "",
//                    "postcode" : "",
//                    "staffNumber" : "",
//                    "state" : "",
//                    "suburb" : "",
//                    "surname" : "test",
//                    "userName" : ' . $userName . ',
//                } 
//            }';
//        $kit = CGX_Kit_Factory::create('users');
//        $inOutTest = self::getConfig();
//        $kit->setInOut($inOutTest);
//        $data = $kit->create($postData);
//        $responseError = @$data->getError();
//        $this->assertEmpty($responseError);
//    }

    public function test_find_all_users_by_id() {
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findAllUsers();
        $response = $data->response;
        $this->assertNotEmpty($response);
        $user = array('userName' => 'hdwebsoft');
        if (!empty($response['users'])) {
            foreach ($response['users'] as $val) {
                $check_user = in_array('hdwebsoft', $val);
                if ($check_user) {
                    $user = $val;
                }
            }
        }
        return $user;
    }

    /**
     * @depends test_find_all_users_by_id
     */
//    public function test_update_user($user) {
//        $postData = '{
//         "SystemUserDetails" : 
//            { "addressLine1" : "High St",
//                "addressLine2" : "",
//                "email" : "hdwebsoft@hdwebsoft.com",
//                "faxNo" : "HDWEBSOFT",
//                "firstName" : "Bao",
//                "groupMailAddress" : "hdwebsoft@hdwebsoft.com",
//                "id" : ' . (int) $user['id'] . ',
//                "password" : "dragon459",
//                "phoneNumber" : "07111223344",
//                "postcode" : 7610,
//                "staffNumber" : 1002,
//                "state" : "NSW",
//                "suburb" : "Sydney",
//                "surname" : "HDWEBSOFT",
//                "userName" : ' . $user['userName'] . ',
//            } 
//         }
//
//        ';
//        $kit = CGX_Kit_Factory::create('users');
//        $inOutTest = self::getConfig();
//        $kit->setInOut($inOutTest);
//        $data = $kit->update($postData);
//        $responseError = @$data->getError();
//        $this->assertEmpty($responseError);
//    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_count_data_of_queues($user) {

        $kit_queues = CGX_Kit_Factory::create('queues');

        $configurator = new Configurator();
        $configurator->loadConfig();
        $username = $user['userName'];

        $data = $kit_queues->countDataOf($username);
        $count = ($data && $data->response && isset($data->response['integerData'])) ? $data->response['integerData'] : -1;

        $this->assertGreaterThanOrEqual(0, $count);
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_users_find_by_name($user) {
        $username = $user['userName'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findByName($username);
        $response = @$data->response;
        $this->assertNotEmpty($response);
        $userId = array('id' => 3);
        if (!empty($response)) {
            $userId = $response['users'];
        }
        return $userId;
    }

    /**
     * @depends test_users_find_by_name
     */
    public function test_find_user_by_id($userId) {
        $kit_users = CGX_Kit_Factory::create('users');
        $userIdTest = $userId['id'];
        $data = $kit_users->findById($userIdTest);
        $reponse = $data && $data->response ? $data->response : null;
        $checkUser = $reponse && !empty($reponse['users']) ? $reponse['users'] : null;
        $this->assertNotEmpty($checkUser, 'SuiteCRM config is empty');
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_workflow_initiate($user) {
        $postData = '
        {
            "initiateWorkflowDetails":{
                "cgxCase":{
                     "caseCategory":"Inquiry",
                     "caseSubType":"Inquiry Subtype 12",
                     "caseTitle":"Case Title DEMO",
                     "caseType":"Inquiry Type 1",
                     "date":"12-12-2012 23:23",
                     "userName":"' . $user['userName'] . '",
                     "workarea":"HDWEBSOFT"
                }
            }
        }
        ';
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->initiate($postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_workflow_initiate_ex($user) {
        $postData = '{
            "InitiateWorkflowDetailsEx": {
                    "caseDetailsExList": {
                            "caseCategory": "Inquiry",
                            "caseDescription": "Test 123",
                            "caseSubType": "Inquiry Subtype 12",
                            "caseTitle": "Case Title DEMO",
                            "caseType": "Inquiry Type 1",
                            "crossReferenceId": "Ref-No-98",
                            "date": "21-06-2016 23:23",
                            "sourceSystem": "Portal",
                            "userName": "' . $user['userName'] . '",
                            "workarea": "HDWEBSOFT",
                            "parties": [{
                                    "cgxPartyId": "",
                                    "partyRole": "APPLICANT",
                                    "sourcePartyId": 2233,
                                    "dataList": {
                                            "entry": [{
                                                    "key": "GIVEN_NAME",
                                                    "value": "Richi"
                                            },
                                            {
                                                    "key": "FAMILY_NAME",
                                                    "value": "Hart"
                                            },
                                            {
                                                    "key": "STREET_ADDRESS",
                                                    "value": "65  Marbel Street"
                                            },
                                            {
                                                    "key": "SUBURB_NAME",
                                                    "value": "Melbourne"
                                            },
                                            {
                                                    "key": "POSTCODE",
                                                    "value": 3997
                                            }]
                                    }
                            },
                            {
                                    "cgxPartyId": "",
                                    "partyRole": "APPLICANT",
                                    "sourcePartyId": 4455,
                                    "dataList": {
                                            "entry": [{
                                                    "key": "GIVEN_NAME",
                                                    "value": "James"
                                            },
                                            {
                                                    "key": "FAMILY_NAME",
                                                    "value": "Fox"
                                            },
                                            {
                                                    "key": "STREET_ADDRESS",
                                                    "value": "61  Team Road"
                                            },
                                            {
                                                    "key": "SUBURB_NAME",
                                                    "value": "Melbourne"
                                            },
                                            {
                                                    "key": "POSTCODE",
                                                    "value": 112233
                                            }]
                                    }
                            }]
                    }
                }
            }';
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->initiateEx($postData);
        $caseId = $data->response['caseStatusList']['caseStatus']['caseId'];
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
        return $caseId;
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_queues_find_data_for($user) {
        $username = $user['userName'];
        $rowOffset = '0';
        $maximumRows = '5';
        $kit = CGX_Kit_Factory::create('queues');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findDataFor($username, (int) $rowOffset, (int) $maximumRows);
        $response_data = $data->response;
        $this->assertNotEmpty($response_data);
        return $response_data;
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_queues_find_data_for
     */
    public function test_workflow_assign_unassign_activity_for($user, $response_data) {
        $username = $user['userName'];
        $activityId = $response_data['rows'][0]['activityId'];
        $operation = 'SU';
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->assignUnassignActivityFor($username, (int) $activityId, $operation);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_queues_find_data_for
     */
    function test_workflow_start_activity_for($user, $response_data) {
        $username = $user['userName'];
        $activityId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->startActivityFor($username, (int) $activityId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_workflow_activity($user) {
        $username = $user['userName'];
        $kit = CGX_Kit_Factory::create('queues');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->countDataOf($username);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_tasks_find_data_for($user) {
        $username = $user['userName'];
        $rowOffset = '1';
        $maximumRows = '5';
        $kit = CGX_Kit_Factory::create('tasks');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findDataFor($username, (int) $rowOffset, (int) $maximumRows);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_queues_find_data_for
     */
    public function test_workflow_hold_activity_for($user, $response_data) {
        $username = $user['userName'];
        $activityInstanceId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->holdActivityFor($username, (int) $activityInstanceId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_queues_find_data_for
     */
    public function test_workflow_resume_activity_for($user, $response_data) {
        $username = $user['userName'];
        $activityInstanceId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->resumeActivityFor($username, (int) $activityInstanceId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_queues_find_queues_of($user) {
        $username = $user['userName'];
        $kit = CGX_Kit_Factory::create('queues');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findQueuesOf($username);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_users_find_assignees_for($response_data) {
        $activityInstanceId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findAssigneesFor((int) $activityInstanceId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_workflow_find_history_for($response_data) {
        $workflowId = $response_data['rows'][0]['workflowInstanceId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findHistoryFor((int) $workflowId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_workflow_find_activity_status_for($response_data) {
        $activityId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findActivityStatusFor((int) $activityId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_case_find_case_id_by_activity_id($response_data) {
        $taskId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findCaseIdByActivityId((int) $taskId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_case_find_case_details_for($response_data) {
        $caseId = $response_data['rows'][0]['caseId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findCaseDetailsFor((int) $caseId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_workflow_find_case_notes_for($response_data) {
        $caseId = $response_data['rows'][0]['caseId'];

        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findCaseNotesFor((int) $caseId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_task_find_completion_results_for($response_data) {
        $activityId = $response_data['rows'][0]['activityId'];
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findCompletionResultsFor((int) $activityId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_queues_find_data_for
     */
    public function test_task_find_first_user_activity_for($response_data) {
        $workflowId = $response_data['rows'][0]['workflowInstanceId'];
        $timeout = 3000;
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findFirstUserActivityFor((int) $workflowId, (int) $timeout);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    public function test_roles_find_all() {
        $kit = CGX_Kit_Factory::create('roles');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findAll();
        $data_role = $data->getResponse();
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
        $role = $data_role['roles'][0];
        return $role;
    }

    /**
     * @depends test_roles_find_all
     */
    public function test_users_find_users_with_role($role) {
        $roleId = $role['roleId'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findUsersWithRole((int) $roleId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_roles_find_all
     */
    public function test_find_users_for_workarea($role) {
        $workAreaId = $role['workareaId'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findUsersForWorkArea((int) $workAreaId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_roles_find_all
     */
    public function test_users_update_role_user_mapping($role) {
        $roleId = $role['roleId'];
        $postData = '
            {
                "longListWrapperDetails": {
                    "longData": ' . (int) $role['roleId'] . '
                }
            }';
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->updateRoleUserMapping((int) $roleId, $postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_roles_find_all
     */
    public function test_remove_role_from_current_users($role) {
        $roleId = '10'; //6 or 7 or 8
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->removeRoleFromCurrentUsers((int) $roleId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_roles_find_all
     */
    public function test_assign_user_roles($role) {
        $userName = "testhd213";
        $postData = '
            {
                "longListWrapperDetails": {
                    "longData": ' . (int) $role['roleId'] . '
                }
            }';
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->assignUserRoles($userName, $postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     */
    public function test_roles_find_user_roles($user) {
        $username = $user['userName'];
        $kit = CGX_Kit_Factory::create('roles');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findUserRoles($username);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_users_find_by_name
     */
    public function test_create_user_information($user, $userId) {
        $postData = '{ 
        "UserInformationDetails" : { 
              "alertType" : "PARTY_ALERT",
              "caseName" : "CASE 123",
              "createDate" : "2013-04-24T11:52:31.368+05:30",
              "details" : "test case details",
              "due" : "2013-04-24T11:52:31.368+05:30",
              "fromIdentity" : "test",
              "id" : 101,
              "markRead" : false,
              "priority" : 2,
              "relevantUser" : { "id" : ' . (int) $userId['id'] . ',
                  "password" : "dragon459",
                  "userName" : "' . $user['userName'] . '"
                }
            } }
        ';
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->createInformation($postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_users_find_by_name
     */
    public function test_users_find_by_relevant_system_user($userId) {
        $userIdTest = $userId['id'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findByRelevantSystemUser((int) $userIdTest);
        $response = @$data->getResponse();
        $this->assertNotEmpty($response);
        $infoId = '3';
        if (!empty($response)) {
            $infoId = $response['userInformations'][0]['id'];
        }
        return $infoId;
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_users_find_by_name
     * @depends test_users_find_by_relevant_system_user
     */
    public function test_users_update($user, $userId, $infoId) {
        $postData = '
            {
                "UserInformationDetails" :
                {
                    "alertType" : "PARTY_ALERT",
                    "caseName" : "cgx test case",
                    "createDate" : "2013-04-24T11:52:31.368+05:30",
                    "details" : "test case details",
                    "due" : "2013-04-24T11:52:31.368+05:30",
                    "fromIdentity" : "test",
                    "id" : ' . (int) $infoId . ',
                    "markRead" : true,
                    "priority" : 2,
                    "relevantUser" : {
                        "id" : ' . (int) $userId['id'] . ',
                        "userName" : "' . $user['userName'] . '"
                      }
                }
            }';
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->updateInformation($postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_users_find_by_name
     */
    public function test_count_unreaded_user_information($userId) {
        $userIdTest = $userId['id'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->countUnreadedUserInformation((int) $userIdTest);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_users_find_by_name
     */
    public function test_find_total_count_by_system_user($userId) {
        $userIdTest = $userId['id'];
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findTotalCountBySystemUser((int) $userIdTest);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_users_find_by_relevant_system_user
     */
    public function test_mark_user_information_read($infoId) {
        $userId = $infoId;
        $isRead = 'false';
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->markUserInformationRead((int) $userId, $isRead);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_users_find_by_relevant_system_user
     */
    public function test_users_find_by_user_information_id($infoId) {
        $userId = $infoId;
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->findByUserInformationId((int) $userId);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_users_find_by_name
     * @depends test_users_find_by_relevant_system_user
     */
    public function test_delete_user_info($user, $userId, $infoId) {
        $postData = '{ 
          "UserInformationDetails" : { 
          "alertType" : "PARTY_ALERT",
          "caseName" : "cgx test case",
          "createDate" : "2013-04-24T11:52:31.368+05:30",
          "details" : "test case details",
          "due" : "2013-04-24T11:52:31.368+05:30",
          "fromIdentity" : "test",
          "id" : ' . (int) $infoId . ',
          "markRead" : false,
          "priority" : 2,
          "relevantUser" : { 
               "id" : ' . (int) $userId['id'] . ',
               "userName" : "' . $user['userName'] . '"
            }
        } }
        ';
        $kit = CGX_Kit_Factory::create('users');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->delete($postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_find_all_users_by_id
     * @depends test_queues_find_data_for
     */
    public function test_workflow_complete_activity_for($user, $response_data) {
        $userName = $user['userName'];
        $activityId = $response_data['rows'][0]['activityId'];
        $completionOption = 'Approve';
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $data = $kit->completeActivityFor($userName, (int) $activityId, $completionOption);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

    /**
     * @depends test_workflow_initiate_ex
     */
    public function test_workflow_complete_open_activity($caseId) {
        $kit = CGX_Kit_Factory::create('workflow');
        $inOutTest = self::getConfig();
        $kit->setInOut($inOutTest);
        $postData = '
            {
	"completeActivityDetailsEx": {
		"artifacts": {
			"dataMap": {
				"entry": [{
					"key": "LINK_1",
					"value": "http:\/\/abcd:8080\/abcd1.pdf"
				},
				{
					"key": "LINK_2",
					"value": "http:\/\/abcd:8080\/abcd2.pdf"
				},
				{
					"key": "LINK_3",
					"value": "http:\/\/abcd:8080\/abcd3.pdf"
				},
				{
					"key": "LINK_4",
					"value": "http:\/\/abcd:8080\/abcd4.pdf"
				}]
			}
		},
		"caseId": "' . $caseId . '",
		"completionResult": "Approve",
		"taskName": "Review Inquiry",
		"userName": "hdwebsoft"
            }
        }
        ';
        $data = $kit->completeOpenActivityByName($postData);
        $responseError = @$data->getError();
        $this->assertEmpty($responseError);
    }

}

