<?php

require_once(__DIR__ . '/CGX_Kit_Base.php');

/**
 * CGX Tasks API
 */
class CGX_Kit_Tasks extends CGX_Kit_Base
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetch list of task data
     * #-2.9#
     *
     * @param string $userName
     * @param int $rowOffset
     * @param int $maximumRows
     * @return CGX_Response
     */
    public function findDataFor($userName, $rowOffset = 0, $maximumRows = 1000)
    {
        $queryParams = array(
            '&amp;rowOffset' => $rowOffset,
            '&amp;maximumRows' => $maximumRows
        );
        
        $params = array(
            $userName => $userName,
            'queryParams' => $queryParams
        );

        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'tasks', 'findDataFor', $params);
        return $res;
    }

    /**
     * Count data of Task
     * #-2.10#
     *
     * @param string $userName
     * @return CGX_Response
     */
    public function countDataOf($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'tasks', 'countDataOf', $params);

        return $res;
    }
}
