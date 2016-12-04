<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 * ****************************************************************************** */

require_once('include/MVC/Controller/SugarController.php');

/**
 * API Controller for test api
 */
class CGX_APIController extends SugarController
{

    public $admin_actions = array('Settings', 'RunTest');

    public function process()
    {
        if (!is_admin($GLOBALS['current_user']) && in_array($this->action, $this->admin_actions)) {
            $this->hasAccess = false;
        }
        parent::process();
    }

    public function pre_save()
    {
        
    }

    public function post_save()
    {
        
    }

    public function action_TestConnection()
    {

        if ($_POST) {
            $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
            $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
            /**
             * If: 
             *    + password has been configured before
             *    + $_POST['password'] is null
             */
            if ($password == '') {
                require_once 'modules/Configurator/Configurator.php';
                $configurator = new Configurator();
                $configurator->loadConfig();
                $password = isset($configurator->config['CGX_API_cgx_api_password']) && $configurator->config['CGX_API_cgx_api_password'] ? $configurator->config['CGX_API_cgx_api_password'] : '';
            }
            $wsdl = isset($_REQUEST['wsdl']) ? $_REQUEST['wsdl'] : '';
            if ($username == '' || $password == '') {
                echo 0;
                exit();
            }

            require_once('api/CGX_Kit_Factory.php');
            require_once('api/CGX_IO.php');
            $kit_users = CGX_Kit_Factory::create('users');
            $inOut = new CGX_IO();

            $configurator = new Configurator();
            $configurator->loadConfig();
            $configurator->config['CGX_API_cgx_api_url'] = $wsdl;
            $configurator->config['CGX_API_cgx_public_url'] = '';
            $newPassword = $inOut->encryptPassword($password);
            $pad = $inOut->getPad();
            $accessConfig = array(
                'sys_config' => $configurator,
                'user_config' => array(
                    'username' => $username,
                    'password' => $newPassword,
                    'pad' => $pad
                )
            );

            $inOut->setAccessConfig($accessConfig);

            $kit_users->setInOut($inOut);
            $data = $kit_users->authenticate($username, $newPassword);
            $responseError = @$data->getError();

            if ($responseError) {
                echo 0;
                exit();
            }
            echo 1;
            exit();
        }
    }

    /**
     * Function setAccessConfigForAdmin User
     * SE-474 - update
     */
    public function setAccessConfigForAdmin($cgx_kit, $configurator)
    {
        /**
         * Check if is admin && encrypted password is null
         * SE-474 - update
         */
        $io = $cgx_kit->getInOut();
        $username = $configurator->config['CGX_API_cgx_api_username'];
        $password = $configurator->config['CGX_API_cgx_api_password'];
        $newPassword = $io->encryptPassword($password);
        $pad = $io->getPad();
        $accessConfig = array(
            'sys_config' => $configurator,
            'user_config' => array(
                'username' => $username,
                'password' => $newPassword,
                'pad' => $pad
            )
        );
        $io->setAccessConfig($accessConfig);
        /**
         * End update
         */
    }

    /**
     * Setting
     */
    public function action_Settings()
    {

//        $sugarSmarty = new Sugar_Smarty();
        $this->view = 'settings';
        $GLOBALS['view'] = $this->view;

        require_once 'modules/Configurator/Configurator.php';
        $configurator = new Configurator();
        $configurator->loadConfig();
        $url = isset($configurator->config['CGX_API_cgx_api_url']) && $configurator->config['CGX_API_cgx_api_url'] ? $configurator->config['CGX_API_cgx_api_url'] : '';
        $publicUrl = isset($configurator->config['CGX_API_cgx_public_url']) && $configurator->config['CGX_API_cgx_public_url'] ? $configurator->config['CGX_API_cgx_public_url'] : '';
        $username = isset($configurator->config['CGX_API_cgx_api_username']) && $configurator->config['CGX_API_cgx_api_username'] ? $configurator->config['CGX_API_cgx_api_username'] : '';
        $password = isset($configurator->config['CGX_API_cgx_api_password']) && $configurator->config['CGX_API_cgx_api_password'] ? $configurator->config['CGX_API_cgx_api_password'] : '';
        $environment = isset($configurator->config['CGX_API_cgx_api_environment']) && $configurator->config['CGX_API_cgx_api_environment'] ? $configurator->config['CGX_API_cgx_api_environment'] : '';
        $aesSecret = isset($configurator->config['Casegenix.aes.encryption.secret.key']) && $configurator->config['Casegenix.aes.encryption.secret.key'] ? $configurator->config['Casegenix.aes.encryption.secret.key'] : '';
        $CGX_role_default = isset($configurator->config['CGX_API_cgx_role']) && $configurator->config['CGX_API_cgx_role'] ? $configurator->config['CGX_API_cgx_role'] : '';

        if ($_POST) {
            $configurator->config['CGX_API_cgx_api_url'] = isset($_REQUEST['cgx_api_url']) ? $_REQUEST['cgx_api_url'] : $url;
            $configurator->config['CGX_API_cgx_public_url'] = isset($_REQUEST['cgx_public_url']) ? $_REQUEST['cgx_public_url'] : $publicUrl;
            $configurator->config['CGX_API_cgx_api_username'] = isset($_REQUEST['cgx_api_username']) ? $_REQUEST['cgx_api_username'] : $username;
            $configurator->config['CGX_API_cgx_api_password'] = isset($_REQUEST['cgx_api_password']) ? $_REQUEST['cgx_api_password'] : $password;
            $configurator->config['CGX_API_cgx_api_environment'] = isset($_REQUEST['cgx_api_environment']) ? $_REQUEST['cgx_api_environment'] : $environment;
            $configurator->config['Casegenix.aes.encryption.secret.key'] = isset($_REQUEST['aesSecret']) ? $_REQUEST['aesSecret'] : $aesSecret;
            $configurator->config['CGX_API_cgx_role'] = isset($_REQUEST['CGX_role']) ? $_REQUEST['CGX_role'] : $CGX_role_default;

            if ($aesSecret != $_REQUEST['aesSecret']) {
                $user_obj = new User();
                $sql = $user_obj->create_new_list_query('', '');
                $result = $GLOBALS['db']->query($sql);

                /**
                 * @todo Refactor later for run this feature in background.
                 */
                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    if (boolval($row['is_admin']) === true && trim($row['cgx_encrypted_password_c']) == '') {
                        continue;
                    }
                    $user = BeanFactory::getBean('Users', $row['id']);
                    if (empty($user)) {
                        continue;
                    }
                    require_once('api/CGX_IO.php');
                    $io = new CGX_IO();

                    // Get old original password
                    $encrypt_pass_old = $user->cgx_encrypted_password_c;
                    $decrypt_pass = $io->decryptPassword($encrypt_pass_old);
                    $oldPad = $user->cgx_pad_password_c;
                    $original_pass = $io->getOriginalPassword($decrypt_pass, $oldPad);
                    // Encode for new pass
                    $encrypt_pass_new = $io->encryptPassword($original_pass, $_REQUEST['aesSecret']);
                    $newPad = $io->getPad();

                    $user->cgx_encrypted_password_c = $encrypt_pass_new;
                    $user->cgx_pad_password_c = $newPad;
                    $user->save();
                }
            }
            $configurator->saveConfig();
        }
    }

    #-2.1-#

    public function action_getWorkflowInitiate()
    {
        $postData = '
        {
            "initiateWorkflowDetails":{
                "cgxCase":{
                     "caseCategory":"Inquiry",
                     "caseSubType":"Inquiry Subtype 12",
                     "caseTitle":"Case Title DEMO",
                     "caseType":"Inquiry Type 1",
                     "date":"12-12-2012 23:23",
                     "userName":"hdwebsoft",
                     "workarea":"HDWEBSOFT"
                },
            }
        }

        ';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->workflowInitiate($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.2
    /* Create Queue */

    function action_TestWorkflowInitiateEx()
    {
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();

        $postData = '{
            "InitiateWorkflowDetailsEx": {
                    "caseDetailsExList": {
                            "caseCategory": "FWBC",
                            "caseDescription": "Test 123",
                            "caseSubType": "AllQueries",
                            "caseTitle": "Application",
                            "caseType": "Query",
                            "crossReferenceId": "Ref-No-98",
                            "date": "21-06-2016 23:23",
                            "sourceSystem": "Portal",
                            "userName": "baovu",
                            "workarea": "Fair Work Building and Construction",
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

        $data = $kit->getWorkflowInitiateEx($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.3-#

    public function action_getWorkflowAssignUnassignActivityFor()
    {
        $user = 'hdwebsoft';
        $activityId = '2877';
        $operation = 'SU';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowAssignUnassignActivityFor($user, (int) $activityId, $operation);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.4
    /* Create task */

    function action_TestWorkflowStartActivityFor()
    {
        $user = 'hdwebsoft';
        $activityId = '2877';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowStartActivityFor($user, (int) $activityId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.5-#
    /**
     * each id is only use 1 time
     * */

    public function action_getWorkflowcompleteActivityFor()
    {
        $user = 'hdwebsoft';
        $activityId = '2862';
        $completionOption = 'Classify+as+Information+Report';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowcompleteActivityFor($user, (int) $activityId, $completionOption);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.6

    public function action_TestWorkflowCompleteOpenActivity()
    {
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();

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
		"caseId": "INCI0000000780S",
		"completionResult": "Classify as Information Report",
		"taskName": "Review query & create investigation",
		"userName": "hdwebsoft"
	}
}
';

        $data = $kit->getWorkflowCompleteOpenActivity($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.7-#

    public function action_getWorkflowActivity()
    {
        require_once 'modules/Configurator/Configurator.php';
        $configurator = new Configurator();
        $configurator->loadConfig();
        $user = 'hdwebsoft';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowActivity($user);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.8
    /* Find data after init */

    function action_TestQueuesFindDataFor()
    {
        $user = 'hdwebsoft';
        $rowOffset = '0';
        $maximumRows = '5';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getQueuesFindDataFor($user, (int) $rowOffset, (int) $maximumRows);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.9-#

    function action_getTasksFindDataFor()
    {
        $user = 'hdwebsoft';
        $rowOffset = '1';
        $maximumRows = '5';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getTasksFindDataFor($user, (int) $rowOffset, (int) $maximumRows);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.10

    public function action_TestTasksCountDataOf()
    {
        $user = 'hdwebsoft';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getTasksCountDataOf($user);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.11-#

    public function action_getWorkflowHoldActivityFor()
    {
        $user = 'hdwebsoft';
        $activityInstanceId = '2877';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowHoldActivityFor($user, (int) $activityInstanceId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.12

    public function action_TestQueuesFindQueuesOf()
    {
        $user = 'hdwebsoft';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getQueuesFindQueuesOf($user);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.13-#
    //activity id -> blank

    public function action_getUsersFindAssigneesFor()
    {
        $activityInstanceId = '2815';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersFindAssigneesFor((int) $activityInstanceId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.14

    public function action_TestWorkflowFindHistoryFor()
    {
        $workflowId = '771';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowFindHistoryFor((int) $workflowId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.15-#
    //activity id wrong

    function action_getWorkflowResumeActivityFor()
    {
        $user = 'hdwebsoft';
        $activityInstanceId = '2877';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowResumeActivityFor($user, (int) $activityInstanceId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.16

    public function action_TestWorkflowFindActivityStatusFor()
    {
        $activityId = '2841';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowFindActivityStatusFor((int) $activityId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.17-#

    public function action_getCaseFindCaseDetailsFor()
    {
        $caseId = '2';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getCaseFindCaseDetailsFor((int) $caseId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.18

    public function action_TestWorkflowFindCaseNotesFor()
    {
        $caseId = '758';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getWorkflowFindCaseNotesFor((int) $caseId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.19-#

    public function action_getCaseFindCaseIdByActivityId()
    {
        $taskId = 2841;
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getCaseFindCaseIdByActivityId($taskId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #2.20 task->workflow --- taskId->activityId

    public function action_TestTaskFindCompletionResultsFor()
    {
        $activityId = '2841';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getTaskFindCompletionResultsFor((int) $activityId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-2.21-#

    public function action_getTaskFindFirstUserActivityFor()
    {
        $workflowId = 758;
        $timeout = 3000;
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getTaskFindFirstUserActivityFor((int) $workflowId, (int) $timeout);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.1-#

    public function action_findUserById()
    {
        $userId = '29';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->findUserById((int) $userId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #3.2

    public function action_TestUsersFindByName()
    {
        $user = 'C';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersFindByName($user);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.3-#

    public function action_findAllUsersById()
    {
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->findAllUsersById();
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #3.4

    public function action_TestUsersFindUsersWithRole()
    {
        $roleId = '1';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersFindUsersWithRole((int) $roleId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.5-#

    public function action_findUsersForWorkArea()
    {
        $workAreaId = '1';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->findUsersForWorkArea((int) $workAreaId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #3.6

    public function action_TestUsersCreate()
    {
        $postData = '
            { 
                "SystemUserDetails" :
                {
                    "addressLine1" : "",
                    "addressLine2" : "",
                    "email" : "",
                    "faxNo" : "",
                    "firstName" : "Tuyen",
                    "groupMailAddress" : "",
                    "password" : "123123123",
                    "phoneNumber" : "",
                    "postcode" : "",
                    "staffNumber" : "",
                    "state" : "",
                    "suburb" : "",
                    "surname" : "Vu",
                    "userName" : "C"
                } 
            }';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersCreate($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.7-#

    public function action_updateUser()
    {
        $postData = '{
         "SystemUserDetails" : 
            { "addressLine1" : "High St",
                "addressLine2" : "",
                "email" : "james@xyz.com",
                "faxNo" : "01111223344",
                "firstName" : "Bao",
                "groupMailAddress" : "james@mobile.com",
                "id" :29,
                "password" : "123123123",
                "phoneNumber" : "07111223344",
                "postcode" : 7610,
                "staffNumber" : 1002,
                "state" : "NSW",
                "suburb" : "Sydney",
                "surname" : "Vu",
                "userName" : "Bao"
            } 
         }

        ';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->updateUser($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #3.8

    public function action_TestUsersUpdateRoleUserMapping()
    {
        $roleId = '10';
        $postData = '
            {
                "longListWrapperDetails": {
                    "longData": 20
                }
            }';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersUpdateRoleUserMapping((int) $roleId, $postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.9-#

    public function action_removeRoleFromCurrentUsers()
    {
        $roleId = '10'; //6 or 7 or 8
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->removeRoleFromCurrentUsers((int) $roleId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #3.10

    public function action_TestRolesFindAll()
    {
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getRolesFindAll();
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.11-#
    //not valid wordkarea
    //API wrong. Request not have workareaRoleId but error workareaRoleId is invalid

    public function action_assignUserRoles()
    {
        $userName = 'jstewart';
        $postData = '{
            "longListWrapperDetails": {
                "longData": 537,
            }
        }
        ';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->assignUserRoles($userName, $postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #3.12

    public function action_TestRolesfindUserRoles()
    {
        $user = 'hdwebsoft';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getRolesfindUserRoles($user);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-3.13-#
    //User Authentication Failed
    //Not example to set value

    public function action_authenticateUser()
    {
        $userName = 'hdwebsoft';
        $postData = 'dragon459';
        require_once('api/CGX_Kit_Factory.php');
        $kit_users = CGX_Kit_Factory::create('users');
        $data = $kit_users->authenticate($userName, $postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-4.1-#
    /**
     * id: id of user detail
     * Return id user info
     */

    public function action_createUserInformation()
    {
        $postData = '{ 
        "UserInformationDetails" : { 
              "alertType" : "PARTY_ALERT",
              "caseName" : "CASE 123",
              "createDate" : "2013-04-24T11:52:31.368+05:30",
              "details" : "test case details",
              "due" : "2013-04-24T11:52:31.368+05:30",
              "fromIdentity" : "test",
              "id" : 27,
              "markRead" : false,
              "priority" : 2,
              "relevantUser" : { "id" : 9088,
                  "password" : "sandra123",
                  "userName" : "sandra"
                }
            } }
        ';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->createUserInformation($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #4.2

    public function action_TestUsersFindByUserInformationId()
    {
        $userId = '2';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersFindByUserInformationId((int) $userId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-4.3-#

    public function action_countUnreadedUserInformation()
    {
        $userId = '29';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->countUnreadedUserInformation((int) $userId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #4.4 No same API -- Output in API same Output 4.2

    public function action_TestUsersFindByRelevantSystemUser()
    {
        $userId = '2';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersFindByRelevantSystemUser((int) $userId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-4.5-#

    public function action_findTotalCountBySystemUser()
    {
        $userId = '29';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->findTotalCountBySystemUser((int) $userId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #4.6

    public function action_TestUsersUpdate()
    {
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
                    "id" : 2,
                    "markRead" : false,
                    "priority" : 2,
                    "relevantUser" : {
                        "id" : 27,
                        "password" : "sandra123",
                        "userName" : "sandra"
                      }
                }
            }';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersUpdate($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-4.7-#

    public function action_markUserInformationRead()
    {
        $userId = '6';
        $isRead = 'false';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->markUserInformationRead((int) $userId, $isRead);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #4.8 (404)

    public function action_TestUsersFindUserInfoByPosition()
    {
        $userId = '36';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getUsersFindUserInfoByPosition((int) $userId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    #-4.9-#

    public function action_TestDeleteUserInfo()
    {
        $postData = '{ 
          "UserInformationDetails" : { 
          "alertType" : "PARTY_ALERT",
          "caseName" : "cgx test case",
          "createDate" : "2013-04-24T11:52:31.368+05:30",
          "details" : "test case details",
          "due" : "2013-04-24T11:52:31.368+05:30",
          "fromIdentity" : "test",
          "id" : 2,
          "markRead" : false,
          "priority" : 2,
          "relevantUser" : { 
              "id" : 9088,
              "password" : "sandra123",
              "userName" : "sandra"
            }
        } }
        ';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->deleteUserInformation($postData);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    public function action_TestCompletionOptions()
    {
        $activityId = '2841';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->getCompletionOptions((int) $activityId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    /**
     *
     */
    function action_TestTaskStatus()
    {
        $userName = 'hdwebsoft';
        $activityInstanceId = '2877';
        require_once('api/CGX_Kit.php');
        $kit = new CGX_Kit();
        $data = $kit->updateTaskStatus($userName, $activityInstanceId);
        echo "<pre> \n <br />";
        var_dump($data);
        die("\n <br /> Debug: " . __METHOD__);
    }

    /**
     * Resync task controller
     */
    function action_Resync()
    {
        $sql = "UPDATE tasks
                SET STATUS = 'completed'
                WHERE
                    tasks.deleted = 0
                AND STATUS <> 'completed'
                AND tasks.id IN (
                    SELECT
                        tasks_cstm.id_c
                    FROM
                        tasks_cstm
                    WHERE
                        tasks_cstm.activity_id_c IS NOT NULL
                )";
        try {
            // resync task
            require_once('api/CGX_Kit_Factory.php');
            $kit_workflow = CGX_Kit_Factory::create('workflow');
            $resync = $kit_workflow ->resyncQueue();
            if(isset($resync->response)
                && isset($resync->response['statusMessage'])
                && $resync->response['statusMessage'] == 'Success')
            {
                // Update Task status on Suite
                $GLOBALS['db']->query($sql);

                echo json_encode(array(
                    'status' => 1,
                    'mess' => "Success!"
                ));
            }else{
                echo json_encode(array(
                    'status' => 0,
                    'mess' => "Fails! Cannot Resync Task from CGX."
                ));
            }
            exit;
        } catch (Exception $e) {
            $GLOBALS['log']->debug("CGX_API : ACTION RESYNC - " . $e->getMessage());
            echo json_encode(array(
                'status' => 0,
                'mess' => $e->getMessage()
            ));
            exit;
        }
    }
}
