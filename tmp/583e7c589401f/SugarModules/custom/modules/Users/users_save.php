<?php

require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
require_once('custom/modules/ACLRoles/ACLRoleCustom.php');

class Users_Save
{

    public function triggerCasegenixUsersSave($bean, $event, $arguments)
    {
        try {
            if (!empty($bean->id)) {
                $cgx_kit = CGX_Kit_Factory::create('users');
                $this->setAccessConfigForAdmin($cgx_kit);
                if ($_REQUEST['action'] == 'delete') {
                    if (!empty($bean->user_name)) {
                        $deleted = $this->deleteUser($bean->user_name);
                        if ($deleted) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                    return true;
                }
                $postData = array();
                $email = $password = $id = '';
                $userName = $bean->user_name;
                $firstName = $bean->first_name;
                $lastName = $bean->last_name;
                $addresses = $bean->emailAddress;
                $unavailableDateFrom = $bean->unavailable_date_from_c ? $bean->unavailable_date_from_c : '';
                $unavailableDateTo = $bean->unavailable_date_to_c ? $bean->unavailable_date_to_c : '';

                if($unavailableDateFrom){
                    $date_obj = date_create($unavailableDateFrom);
                    $date = date_format($date_obj, 'Y-m-d H:i:s');
                    $unavailableDateFrom = str_replace(' ', 'T', $date);
                }
                if($unavailableDateTo){
                    $date_obj = date_create($unavailableDateTo);
                    $date = date_format($date_obj, 'Y-m-d H:i:s');
                    $unavailableDateTo = str_replace(' ', 'T', $date);
                }

                if (!empty($_SESSION['casegenix_password_' . $userName])) {
                    $password = $_SESSION['casegenix_password_' . $userName];
                    unset($_SESSION['casegenix_password_' . $userName]);
                } else {
                    if (!empty($_REQUEST['new_password'])) {
                        $password = $_REQUEST['new_password'];
                    }
                }
                //Check update user using service    
                if(isset($_REQUEST['method'])){
                    $rest_data = isset($_REQUEST['rest_data']) && $_REQUEST['rest_data'] ? json_decode(str_replace('&quot;', '"', $_REQUEST['rest_data']), true) : array();
                    if($_REQUEST['method'] == 'set_entry'){
                        if(isset($rest_data['name_value_list']) && count($rest_data['name_value_list'])){
                           foreach($rest_data['name_value_list'] as $item){
                                if(isset($item['name']) && $item['name'] == 'origin_pass'){
                                    $password = isset($item['value']) && $item['value'] ? $item['value'] : '';
                                }
                            } 
                        }
                    }
                    if($_REQUEST['method'] == 'update_user'){
                        if(isset($rest_data['params']) && isset($rest_data['params']['user_hash'])){
                           $password = $rest_data['params']['user_hash'];
                        }
                    }
                }
                if (!empty($addresses->addresses)) {
                    foreach ($addresses->addresses as $address) {
                        if ($address['primary_address'] == 1 && $address['invalid_email'] == 0) {
                            $email = $address['email_address'];
                        }
                    }
                }
                $systemUserDetails = array(
                    'userName' => $userName,
                    'firstName' => $firstName,
                    'surname' => $lastName,
                    'email' => $email,
                    'unavailableFrom' => $unavailableDateFrom,
                    'unavailableTo' => $unavailableDateTo,
                );
                if (!empty($password)) {
                    $systemUserDetails['password'] = $password;
                }
                $id = $this->getCasegenixId($userName);
                $GLOBALS['log']->debug('triggerCasegenixUsersSave::getCasegenixId::' . $userName . '::' . $id);
                $post_response = array();
                if ($id) {
                    $systemUserDetails['id'] = $id;
                    $postData['SystemUserDetails'] = $systemUserDetails;
                    $post_response = $cgx_kit->update(json_encode($postData));
                    if(isset($post_response->error) && count($post_response->error)){
                        $GLOBALS['log']->debug('triggerCasegenixUsersSave::UserUpdate::' . $post_response->error->MSG);
                        return false;
                    }
                } else {
                    if (empty($systemUserDetails['password'])) {
                        $GLOBALS['log']->debug('triggerCasegenixUsersSave::systemSendPassword::' . $userName);
                        return true;
                    }
                    $postData['SystemUserDetails'] = $systemUserDetails;
                    $post_response = $cgx_kit->create(json_encode($postData));
                    if(isset($post_response->error) && count($post_response->error)){
                        $GLOBALS['log']->debug('triggerCasegenixUsersSave::CreateUpdate::' . $post_response->error->MSG);
                        return false;
                    }
                    if (!empty($post_response)) {
                        $response = @$post_response->getResponse();
                        if (!empty($response['statusCode']) && $response['statusCode'] == '000') {
                            $role_id = $this->getCurrentRoleId();
                            $this->assignRoleDefaultForUser($userName, $role_id);
                            $this->setDefaultRoleList($bean);
                        }
                    }
                }

                if (!empty($password)) {
                    // update encrypted password
                    if ($bean->id == "1") {
                        return true;
                    }
                    $kitInOut = $cgx_kit->getInOut();
                    $np = $kitInOut->encryptPassword($password);
                    $bean->cgx_encrypted_password_c = $np;
                    $bean->cgx_pad_password_c = $kitInOut->getPad();
                }
            }
            return true;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal($e->getMessage());
            return false;
        }
    }

    public function getCasegenixId($userName = null)
    {
        try {
            $cgx_kit = CGX_Kit_Factory::create('users');
            $this->setAccessConfigForAdmin($cgx_kit);
            $userExists = $cgx_kit->findByName($userName);
            $response = @$userExists->getResponse();
            if (!empty($response['users']['id'])) {
                return (int) $response['users']['id'];
            } else {
                if (!empty($response['status']['statusCode']) && $response['status']['statusCode'] = '001') {
                    $GLOBALS['log']->debug('getCasegenixId::userNotExists::' . $userName);
                    return 0;
                }
                $GLOBALS['log']->fatal(print_r($userExists, true));
                return 0;
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal('getCasegenixId::' . $e->getMessage());
            return 0;
        }
    }

    public function getUserRoles($beanId = 0)
    {
        try {
            $roles = array();
            $role = new ACLRoleCustom();
            $acl_roles = $role->getUserRoles($beanId, false);
            if ($acl_roles) {
                foreach ($acl_roles as $acl_role) {
                    if (!empty($acl_role->casegenix_role)) {
                        if (!in_array($acl_role->casegenix_role, $roles)) {
                            $roles[] = $acl_role->casegenix_role;
                        }
                    }
                }
            }
            return $roles;
        } catch (Exception $e) {
            $GLOBALS['log']->debug('getUserRoles::' . $e->getMessage());
            return 0;
        }
    }

    public function getCasegenixRoles()
    {
        try {
            $cgx_roles = array();
            $cgx_kit = CGX_Kit_Factory::create('roles');
            $this->setAccessConfigForAdmin($cgx_kit);
            $roleExists = $cgx_kit->findAll();
            $response = @$roleExists->getResponse();
            if (!empty($response['roles'])) {
                if (!empty($response['roles']['roleId'])) {
                    $cgx_roles[] = $response['roles'];
                } else {
                    foreach ($response['roles'] as $cgx_role) {
                        if (!empty($cgx_role['roleId'])) {
                            $cgx_roles[] = $cgx_role;
                        }
                    }
                }
            }
            return $cgx_roles;
        } catch (Exception $e) {
            $GLOBALS['log']->debug('getCasegenixRoles::' . $e->getMessage());
            return 0;
        }
    }

    public function updateUserRoles($userName = null, $roles = array(), $cgx_roles = array())
    {
        try {
            $role_ids = array();
            foreach ($roles as $rolename) {
                foreach ($cgx_roles as $cgx_role) {
                    if ($cgx_role['roleName'] == $rolename) {
                        if (!in_array($cgx_role['roleId'], $role_ids)) {
                            $role_ids[] = $cgx_role['roleId'];
                        }
                    }
                }
            }
            if ($role_ids) {
                $cgx_kit = CGX_Kit_Factory::create('users');
                $this->setAccessConfigForAdmin($cgx_kit);
                $postData = array(
                    'longListWrapperDetails' => array('longData' => $role_ids)
                );
                $post_response = $cgx_kit->assignUserRoles($userName, json_encode($postData));
                $response = @$post_response->getResponse();
                if (!empty($response['statusCode']) && $response['statusCode'] == '000') {
                    return 1;
                } else {
                    $GLOBALS['log']->fatal(print_r($post_response, true));
                    return 0;
                }
            }
            return 1;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal('updateUserRoles::' . $e->getMessage());
            return 0;
        }
    }

    public function deleteUser($userName)
    {
        $role_id = $this->getCurrentRoleId();
        $this->assignRoleDefaultForUser($userName, $role_id);
    }

    private function getCurrentRoleId()
    {
        global $sugar_config;
        $role_id = '';
        $cgx_role_default = $sugar_config['CGX_API_cgx_role'];
        if (isset($cgx_role_default) && !empty($cgx_role_default)) {
            $default_role = ltrim(rtrim($cgx_role_default));
            $cgx_roles = $this->getCasegenixRoles();
            if ($cgx_roles) {
                foreach ($cgx_roles as $role) {
                    $cgx_role = ltrim(rtrim($role['roleName']));
                    if ($cgx_role == $default_role) {
                        $role_id = $role['roleId'];
                        break;
                    }
                }
            }
        }

        return $role_id;
    }

    private function setDefaultRoleList($beanUser)
    {
        global $sugar_config;
        $cgx_role_default = $sugar_config['CGX_API_cgx_role'];
        $acl_role = new ACLRole();
        $list_role_query = $acl_role->create_new_list_query('', "casegenix_role = '" . $cgx_role_default . "'");
        try {
            $rows = $GLOBALS['db']->query($list_role_query);
        } catch (Exception $e) {
            $GLOBALS['log']->debug("Query get role id by default role (CGX config) : " . $e->getMessage());
        }
        if (!$rows) {
            return;
        }
        while ($row = $GLOBALS['db']->fetchByAssoc($rows)) {
            $beanUser->load_relationship('aclroles');
            $beanUser->aclroles->add($row['id']);
        }
    }

    private function assignRoleDefaultForUser($userName, $role_id)
    {
        try {
            $cgx_kit = CGX_Kit_Factory::create('users');
            $this->setAccessConfigForAdmin($cgx_kit);
            $postData = array(
                'longListWrapperDetails' => array('longData' => array($role_id))
            );
            $post_response = $cgx_kit->assignUserRoles($userName, json_encode($postData));
            $response = @$post_response->getResponse();
            if (!empty($response['statusCode']) && $response['statusCode'] == '000') {
                return 1;
            } else {
                $GLOBALS['log']->fatal(print_r($post_response, true));
                return 0;
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal('assignUserRoles::' . $e->getMessage());
            return 0;
        }
    }

    // Trigger map role
    public function setRoleForUserToCGX(&$bean, $event, $args)
    {
        if ($args['relationship'] == 'acl_roles_users') {
            $user_id = $bean->id;
            $role_id = $args['related_id'];
            $user = $bean;
            if ($args['module'] == 'ACLRoles') {
                $user_id = $args['related_id'];
                $role_id = $bean->id;
                $user = new User();
                $user->retrieve($user_id);
            }
            if ($user_id) {
                $cgx_user_id = $this->getCasegenixId($user->user_name);
                if ($cgx_user_id) {
                    $roles = $this->getUserRoles($user->id);
                    $cgx_roles = $this->getCasegenixRoles();
                    if ($roles) {
                        if ($cgx_roles) {
                            $updated = $this->updateUserRoles($user->user_name, $roles, $cgx_roles);
                            if ($updated) {
                                return true;
                            } else {
                                $sb = new SugarBean();
                                $related_values = array(
                                    'role_id' => $role_id,
                                    'user_id' => $user_id
                                );
                                $data_values = array(
                                    'deleted' => 0
                                );
                                $sb->set_relationship('acl_roles_users', $related_values, true, true, $data_values);
                                $GLOBALS['log']->debug("Can't update role for User: " . $user->id);
                                return false;
                            }
                        }
                    }
                } else {
                    $GLOBALS['log']->debug("User: " . $user->id . " does not exist in CGX");
                }
            }
        }
    }

    // Get cgx role id by Role name
    private function getCGXRoleIdByRoleName($cgx_role_list, $role_name)
    {
        foreach ($cgx_role_list as $cgx_role) {
            if ($cgx_role['roleName'] == $role_name) {
                return $cgx_role['roleId'];
            }
        }
        return false;
    }

    /**
     * Function setAccessConfigForAdmin User
     * SE-474 - update
     */
    public function setAccessConfigForAdmin($cgx_kit)
    {
        /**
         * Check if is admin && encrypted password is null
         * SE-474 - update
         */
        global $current_user;
        $io = $cgx_kit->getInOut();
        if (boolval($current_user->is_admin) === true && trim($current_user->cgx_encrypted_password_c) == '') {
            $configurator = new Configurator();
            $configurator->loadConfig();
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
        }
        /**
         * End update
         */
    }

}

?>