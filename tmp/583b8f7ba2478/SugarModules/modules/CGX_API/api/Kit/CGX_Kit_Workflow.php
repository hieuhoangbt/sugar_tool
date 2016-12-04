<?php

require_once(__DIR__ . '/CGX_Kit_Base.php');

/**
 * CGX Workflow API
 */
class CGX_Kit_Workflow extends CGX_Kit_Base {

    /**
     * Construct
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Initiale workflow
     * #-2.1-#
     *
     * @param array $postData
     * @return CGX_Response
     */
    public function initiate($postData) {
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'initiate', null, $postData);

        return $res;
    }

    /**
     * Initiale workflow - Extended Version
     * #-2.2-#
     *
     * @param array $postData
     * @return CGX_Response
     */
    public function initiateEx($postData) {
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'initiateEx', null, $postData, 'V2.0');

        return $res;
    }

    /**
     * Assign/UnAssign workflow to user with activity & username
     * #-2.3-#
     *
     * @param string $userName
     * @param string $activityId
     * @param string $operation SS,SU,US,UU
     * @return CGX_Response
     */
    public function assignUnassignActivityFor($userName, $activityId, $operation) {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId, $operation => $operation);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'assignUnassignActivityFor', $params);

        return $res;
    }
    
    /**
     * Open or start a workflow activity with activity & username
     * #-2.4#
     *
     * @param string $userName
     * @param string $activityId
     * @return CGX_Response
     */
    public function startActivityFor($userName, $activityId)
    {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'startActivityFor', $params);

        return $res;
    }

    /**
     * Open or start a workflow activity with activity & username
     * #-2.23#
     *
     * @param string $userName
     * @param string $activityId
     * @return CGX_Response
     */
    public function startActivityFor_V2($userName, $activityId) {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'startActivityFor', $params, '', 'V2.0');

        return $res;
    }

    /**
     * fastForward a workflow activity with activity & username
     * #-2.22#
     *
     * @param string $userName
     * @param string $activityId
     * @return CGX_Response
     */
    public function fastForwardActivity($userName, $activityId) {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'fastForwardActivity', $params, '', 'V2.0');

        return $res;
    }

    /**
     * (workflow) Activity will be completed and removed into next workflow.
     * #-2.5#
     *
     * @param string $userName
     * @param string $activityId
     * @param string $completionOption
     * @return CGX_Response
     */
    public function completeActivityFor($userName, $activityId, $completionOption) {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId, $completionOption => $completionOption);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'completeActivityFor', $params);
        return $res;
    }

    /**
     * Update Case and complete Task
     * #-2.6#
     *
     * @param array $postData
     * @return CGX_Response
     */
    public function completeOpenActivityByName($postData) {
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'completeOpenActivityByName', null, $postData, 'V2.0');

        return $res;
    }

    /**
     * Put the given workflow task on hold of a given user
     * #-2.11#
     *
     * @param string $userName
     * @param int $activityId
     * @return CGX_Response
     */
    public function holdActivityFor($userName, $activityId) {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'holdActivityFor', $params);
        return $res;
    }

    /**
     * Fetch the history of the given workflow
     * #-2.14#
     *
     * @param int $workflow
     * @return CGX_Response
     */
    public function findHistoryFor($workflow) {
        $params = array($workflow => $workflow);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findHistoryFor', $params);

        return $res;
    }

    /**
     * Resume the given task of the given user
     * #-2.15#
     *
     * @param string $userName
     * @param int $activityId
     * @return CGX_Response
     */
    public function resumeActivityFor($userName, $activityId) {
        $activityId = (int) $activityId;
        $params = array($userName => $userName, $activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'resumeActivityFor', $params);
        return $res;
    }

    /**
     * Fetching state of workflow activity for given activity id
     * #-2.16#
     *
     * @param int $activityId
     * @return CGX_Response
     */
    public function findActivityStatusFor($activityId) {
        $activityId = (int) $activityId;
        $params = array($activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findActivityStatusFor', $params);

        return $res;
    }

    /**
     * Fetching case details by case id
     * #-2.17#
     *
     * @param int $caseId
     * @return CGX_Response
     */
    public function findCaseDetailsFor($caseId) {
        $params = array($caseId => $caseId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCaseDetailsFor', $params);
        return $res;
    }

    /**
     * Fetching the notes associated with a paricular case with given id
     * #-2.18#
     *
     * @param int $caseId
     * @return CGX_Response
     */
    public function findCaseNotesFor($caseId) {
        $params = array($caseId => $caseId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCaseNotesFor', $params);

        return $res;
    }

    /**
     * Fetching the case id of the case associated with a particular task
     * #-2.19#
     *
     * @param int $taskId
     * @return CGX_Response
     */
    public function findCaseIdByActivityId($taskId) {
        $params = array($taskId => $taskId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCaseIdByActivityId', $params);
        return $res;
    }

    /**
     * Fetching the valid completion result options for a particular task
     * #-2.20# task->workflow --- taskId->activityId
     *
     * @param int $activityId
     * @return CGX_Response
     */
    public function findCompletionResultsFor($activityId) {
        $activityId = (int) $activityId;
        $params = array($activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCompletionResultsFor', $params);

        return $res;
    }

    /**
     * Fetching the task id of the first available user task in a particular workflow
     * #-2.21#
     *
     * @param int $workflowId
     * @param int $timeout
     * @return CGX_Response
     */
    public function findFirstUserActivityFor($workflowId, $timeout) {
        $workflowId = (int) $workflowId;
        $params = array($workflowId => $workflowId, '?timeout' => $timeout);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findFirstUserActivityFor', $params);
        return $res;
    }

    /**
     * Resync task
     *
     * @return CGX_Response
     */
    public function resyncQueue(){
        global $current_user;
        $current_user_name = $current_user->user_name;
        $params = array($current_user_name => $current_user_name);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'resyncQueue', $params, '', 'V2.0');
        return $res;
    }

}
