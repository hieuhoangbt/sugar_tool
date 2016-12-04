<?php

require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
require_once ('custom/modules/ACLRoles/RoleBasedQueuePermission.php');

class ACLRoles_Save
{
    /*
     * all Roles from CaseGenix
     */

    private static $cgx_roles = [];

    /*
     * get all Roles from CaseGenix
     *
     * @return array Roles
     */

    private function requestRolesFromCaseGenix()
    {
        try {
            // get All Roles from CaseGenix
            $cgx_kit_roles = CGX_Kit_Factory::create('roles');
            $this->setAccessConfigForAdmin($cgx_kit_roles);
            $cgx_response = $cgx_kit_roles->findAll();
            $cgx_response_error = $cgx_response->getError();

            $cgx_response = $cgx_response->getResponse();
            if (isset($cgx_response['roles'])) {
                $cgx_roles = [];
                if (!empty($cgx_response['roles']['roleId'])) {
                    // only 1 item
                    $cgx_roles[] = $cgx_response['roles'];
                } else {
                    $cgx_roles = $cgx_response['roles'];
                }

                self::$cgx_roles = $cgx_roles;
            } else {
                if ($cgx_response_error) {
                    $cgx_response_error_message = $cgx_response_error->getMsg();

                    $GLOBALS['log']->debug($cgx_response_error_message);
                }
            }
        } catch (Exception $e) {
            $GLOBALS['log']->debug($e->getMessage());
        }
    }

    /*
     * get id from role name
     *
     * @return role_id
     */

    private function getRoleId($role_name)
    {
        // request list if empty
        if (empty(self::$cgx_roles)) {
            $this->requestRolesFromCaseGenix();
        }

        $role_id = null;
        foreach (self::$cgx_roles as $role) {
            if (!empty($role['roleName']) && trim($role['roleName']) == trim($role_name)) {
                $role_id = $role['roleId'];
                break;
            }
        }

        return $role_id;
    }

    /*
     * Get list user_name has role_id
     *
     * @params $bean
     * @return array
     */

    private function getListUserNames($bean)
    {
        $user_names = [];

        try {
            // load relationships
            if ($bean->load_relationship('users')) {
                $users = $bean->users->getBeans();
                if (!empty($users)) {
                    foreach ($users as $user) {
                        if (!empty($user->user_name)) {
                            $user_names[] = trim($user->user_name);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $GLOBALS['log']->debug($e->getMessage());
        }

        return $user_names;
    }

    /*
     * get list roles of the user_name
     *
     * @return array
     */

    private function getListRoles($user_name)
    {
        $roles = [];

        try {
            $cgx_kit_roles = CGX_Kit_Factory::create('roles');
            $this->setAccessConfigForAdmin($cgx_kit_roles);
            $cgx_response = $cgx_kit_roles->findUserRoles($user_name);
            $cgx_response_error = $cgx_response->getError();

            $cgx_response = $cgx_response->getResponse();
            if (isset($cgx_response['roles'])) {
                if (!empty($cgx_response['roles'])) {
                    // only 1 item
                    if (!empty($cgx_response['roles']['roleId'])) {
                        $roles[] = $cgx_response['roles']['roleId'];
                    } else {
                        foreach ($cgx_response['roles'] as $item) {
                            if (!empty($item['roleId'])) {
                                $roles[] = $item['roleId'];
                            }
                        }
                    }
                }
            } else {
                if ($cgx_response_error) {
                    $cgx_response_error_message = $cgx_response_error->getMsg();
                    $GLOBALS['log']->debug($cgx_response_error_message);
                }
            }
        } catch (Exception $e) {
            $GLOBALS['log']->debug($e->getMessage());
        };

        return $roles;
    }

    /*
     * Trigger ACLRoles After Save
     */

    public function triggerCasegenixACLRolesSave($bean, $event, $arguments)
    {
        try {
            // new ACLRoles
            if (empty($bean->fetched_row['id'])) {
                // check whether casegenix_role value
                if (!empty($bean->casegenix_role)) {
                    // get role_id
                    $role_id = $this->getRoleId($bean->casegenix_role);
                    if (!empty($role_id)) {
                        
                    } else {
                        // display a warning message "Invalid Casegenix role"
                        $_SESSION['invalid-casegenix-role'] = true;
                        SugarApplication::redirect('index.php?action=EditView&module=ACLRoles&record=' . $bean->id);
                    }
                }
            }

            // update ACLRoles
            if (!empty($bean->fetched_row['id']) && $bean->fetched_row['casegenix_role'] != $bean->casegenix_role) {
                // Update role base queue permission
                $rbqp = new RoleBasedQueuePermission();
                $rbqp->process($bean->casegenix_role);

                //get role_id from role_name
                $cgx_role_id_old = $this->getRoleId($bean->fetched_row['casegenix_role']);
                $cgx_role_id_new = $this->getRoleId($bean->casegenix_role);

                // get list user has the old role
                $user_names = $this->getListUserNames($bean);

                // create Kit Users
                $cgx_kit_users = CGX_Kit_Factory::create('users');
                $this->setAccessConfigForAdmin($cgx_kit_users);
                foreach ($user_names as $user_name) {
                    $user_roles = $this->getListRoles($user_name);

                    // remove old role_id out list
                    if (!empty($cgx_role_id_old)) {
                        $user_roles = array_diff($user_roles, [$cgx_role_id_old]);
                    }

                    // append new role_id to list if not empty
                    if (!empty($cgx_role_id_new)) {
                        $user_roles[] = $cgx_role_id_new;
                    }

                    // @ToDo : current only update to CaseGenix if user_roles not empty.
                    if (!empty($user_roles)) {
                        try {
                            $postData = '{
                                "longListWrapperDetails": {
                                    "longData": ' . (count($user_roles) == 1 ? current(array_values($user_roles)) : ('[' . implode(',', $user_roles) . ']')) . '
                                }
                            }
                            ';

                            // assign user_roles to user
                            $response = $cgx_kit_users->assignUserRoles($user_name, $postData);
                            $GLOBALS['log']->debug(" --- API: Add Role $cgx_role_id_new and Remove Role $cgx_role_id_old of User $user_name  with data : $postData with response : " . print_r($response, 1));
                        } catch (Exception $e) {
                            $GLOBALS['log']->fatal($e->getMessage());
                        }
                    } else {
                        $GLOBALS['log']->debug(" --- API-TODO : Add Role $cgx_role_id_new and Remove Role $cgx_role_id_old of User $user_name with list user_roles : " . print_r($user_roles, 1));
                    }
                }
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal($e->getMessage());
            return $e->getMessage();
        }
    }

    /*
     * Trigger ACLRoles After Save
     */

    public function triggerCasegenixACLRolesBeforeSave($bean, $event, $arguments)
    {
        try {
            // new ACLRoles
            if (empty($bean->fetched_row['id'])) {
                // check whether casegenix_role value
                if (!empty($bean->casegenix_role)) {
                    // get role_id
                    $role_id = $this->getRoleId($bean->casegenix_role);
                    if (empty($role_id)) {
                        // display a warning message "Invalid Casegenix role"
                        $_SESSION['invalid-casegenix-role'] = true;
                        $_SESSION['data-invalid-casegenix-role'] = $_REQUEST;
                        SugarApplication::redirect('index.php?action=EditView&module=ACLRoles');
                    }
                }
            }

            // update ACLRoles
            if (!empty($bean->fetched_row['id']) && $bean->fetched_row['casegenix_role'] != $bean->casegenix_role) {
                // get new role_id
                $cgx_role_id_new = $this->getRoleId($bean->casegenix_role);

                // check valid
                if (empty($cgx_role_id_new)) {
                    // display a warning message "Invalid Casegenix role"
                    $_SESSION['invalid-casegenix-role'] = true;
                    SugarApplication::redirect('index.php?action=EditView&module=ACLRoles&record=' . $bean->id);
                }
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal($e->getMessage());
            return $e->getMessage();
        }
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