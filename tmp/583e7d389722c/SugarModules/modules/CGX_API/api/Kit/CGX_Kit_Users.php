<?php

require_once(__DIR__ . '/CGX_Kit_Base.php');

/**
 * CGX Users API
 */
class CGX_Kit_Users extends CGX_Kit_Base
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetch the assignees of the given activity
     * #-2.13#
     *
     * @param int $activityInstanceId
     * @return CGX_Response
     */
    public function findAssigneesFor($activityInstanceId)
    {
        $activityInstanceId = (int) $activityInstanceId;
        $params = array($activityInstanceId => $activityInstanceId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'users', 'findAssigneesFor', $params);
        return $res;
    }

    /**
     * Fetching the user details by given user id
     * #-3.1#
     *
     * @param int $userId
     * @return CGX_Response
     */
    public function findById($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findById', $params);

        return $res;
    }

    /**
     * Fetching the user details by given user name
     * #-3.2#
     *
     * @param string $userName
     * @return CGX_Response
     */
    public function findByName($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findByName', $params);

        return $res;
    }

    /**
     * Fetching the user details in the system
     * #-3.3#
     *
     * @return CGX_Response
     */
    public function findAllUsers()
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findAllUsers', null);

        return $res;
    }

    /**
     * Fetching all the users having given work area role
     * #-3.4#
     *
     * @param int $roleId
     * @return CGX_Response
     */
    public function findUsersWithRole($roleId)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findUsersWithRole', $params);

        return $res;
    }

    /**
     * Fetching all users that participate in roles  belong
     * #-3.5#
     *
     * @param int $workAreaId
     * @return CGX_Response
     */
    public function findUsersForWorkArea($workAreaId)
    {
        $params = array($workAreaId => $workAreaId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findUsersForWorkArea', $params);

        return $res;
    }

    /**
     * Create new system user
     * #-3.6#
     *
     * @param array $postData
     * @return CGX_Response
     */
    public function create($postData)
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'create', null, $postData, 'V1.0');

        return $res;
    }

    /**
     * Update system user
     * #-3.7#
     *
     * @param array $postData
     * @return CGX_Response
     */
    public function update($postData)
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'update', null, $postData);

        return $res;
    }

    /**
     * Update role user mapping
     * #-3.8#
     *
     * @param int $roleId
     * @param array $postData
     * @return CGX_Response
     */
    public function updateRoleUserMapping($roleId, $postData)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'updateRoleUserMapping', $params, $postData, 'V1.0');

        return $res;
    }

    /**
     * Remove role from current users
     * #-3.9#
     *
     * @param int $roleId
     * @return CGX_Response
     */
    public function removeRoleFromCurrentUsers($roleId)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'removeRoleFromCurrentUsers', $params);

        return $res;
    }

    /**
     * Assign user roles
     * #-3.11#
     *
     * @param string $userName
     * @param array $postData
     *
     * @return CGX_Response
     */
    public function assignUserRoles($userName, $postData)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'assignUserRoles', $params, $postData);

        return $res;
    }

    /**
     * Authenticate and retrieve user appropriate case configuration details
     * #-3.13#
     *
     * @param string $userName
     * @param array $postData
     *
     * @return CGX_Response
     */
    public function authenticate($userName, $password)
    {
        $params = array($userName => $userName);
        $postData = array('username' => $userName, 'password' => $password);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'authenticate', $params, $postData);

        return $res;
    }

    /**
     * Create new system user information
     * #-4.1#
     *
     * @param array $postData
     *
     * @return CGX_Response
     */
    public function createInformation($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'create', null, $postData, 'V1.0', 'information');

        return $res;
    }

    /**
     * Fetching the user information details by given user information id
     * #-4.2#
     *
     * @param int $userId
     *
     * @return CGX_Response
     */
    public function findByUserInformationId($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findByUserInformationId', $params, null, 'V1.0', 'information');

        return $res;
    }

    /**
     * Count not read user information details by given system user id
     * #-4.3#
     *
     * @param int $userId
     *
     * @return CGX_Response
     */
    public function countUnreadedUserInformation($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'countUnreadedUserInformation', $params, null, 'V1.0', 'information');

        return $res;
    }

    /**
     * Fetch user information details for given system user id
     * #-4.4#
     *
     * @param int $userId
     *
     * @return CGX_Response
     */
    public function findByRelevantSystemUser($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findByRelevantSystemUser', $params, null, 'V1.0', 'information');

        return $res;
    }

    /**
     * Count user information details by given system user id
     * #-4.5#
     *
     * @param int $userId
     *
     * @return CGX_Response
     */
    public function findTotalCountBySystemUser($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findTotalCountBySystemUser', $params, null, 'V1.0', 'information');

        return $res;
    }

    /**
     * Update system user information details
     * #-4.6#
     *
     * @param array $postData
     *
     * @return CGX_Response
     */
    public function updateInformation($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'update', null, $postData, 'V1.0', 'information');

        return $res;
    }

    /**
     * Mark user information details as read
     * #-4.7#
     *
     * @param int $userId
     * @param boolean $isRead
     *
     * @return CGX_Response
     */
    public function markUserInformationRead($userId, $isRead)
    {
        $params = array($userId => $userId, $isRead => $isRead);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'markUserInformationRead', $params, null, 'V1.0', 'information');

        return $res;
    }

    /**
     * Fetch user information details by position
     * #-4.8#
     *
     * @param int $userId
     *
     * @return CGX_Response
     */
    public function findUserInfoByPosition($userId)
    {
        $queryParams = array(
            '&amp;start' => 0,
            '&amp;max' => 1
        );
        
        $params = array(
            $userId => $userId,
            'queryParams' => $queryParams
        );
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findUserInfoByPosition', $params, null, 'V1.0', 'information');

        return $res;
    }

    /**
     * Delete user information details by given user information details
     * #-4.9#
     *
     * @param array $postData
     *
     * @return CGX_Response
     */
    public function delete($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'delete', null, $postData, 'V1.0', 'information');

        return $res;
    }
}
