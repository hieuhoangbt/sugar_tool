<?php

require_once(__DIR__ . '/CGX_Kit_Base.php');

/**
 * CGX Roles API
 */
class CGX_Kit_Roles extends CGX_Kit_Base
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetch all roles in the system
     * #-3.10#
     *
     * @return CGX_Response
     */
    public function findAll()
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'roles', 'findAll');

        return $res;
    }

    /**
     * Fetch user roles
     * #-3.12#
     *
     * @param string $userName
     *
     * @return CGX_Response
     */
    public function findUserRoles($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'roles', 'findUserRoles', $params);

        return $res;
    }
}
