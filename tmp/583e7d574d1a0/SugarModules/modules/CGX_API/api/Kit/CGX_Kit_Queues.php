<?php

require_once(__DIR__ . '/CGX_Kit_Base.php');

/**
 * CGX Queues API
 */
class CGX_Kit_Queues extends CGX_Kit_Base
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Count of the queue
     * #-2.7#
     *
     * @param string $userName
     * @return CGX_Response
     */
    public function countDataOf($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'countDataOf', $params);
        return $res;
    }

    /**
     * Fetch list of queue data
     * #-2.8#
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

        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findDataFor', $params);

        return $res;
    }

    /**
     * Fetch all queues of the given user
     * #-2.12#
     *
     * @param string $userName
     * @return CGX_Response
     */
    public function findQueuesOf($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findQueuesOf', $params);

        return $res;
    }
}
