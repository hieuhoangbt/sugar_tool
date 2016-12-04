<?php

require_once(__DIR__ . '/CGX_IO.php');

/**
 * CGX Kit
 */
class CGX_Kit
{

    private static $inOut;

    /**
     * Construct
     *
     * @return api/CGX_Kit
     */
    public function __construct()
    {
        $inOut = new CGX_IO();
        $this->setInOut($inOut);

        return $this;
    }

    /**
     * get IO
     *
     * @return type
     */
    public static function getInOut()
    {
        return self::$inOut;
    }

    /**
     * set IO
     *
     * @param mix $inOut
     *
     * @return mix
     */
    public static function setInOut($inOut)
    {
        self::$inOut = $inOut;
    }
    
    /**
     * Initiale workflow
     * #-2.1-#
     * 
     * @param array $postData
     * @return CGX_Response
     */

    public function workflowInitiate($postData)
    {
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
    public function workflowInitiateEx($postData)
    {
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'initiateEx', null, $postData, 'V2.0');

        return $res;
    }
    /*
     * Old #-2.2-#
     */
    public function getWorkflowInitiateEx($postData)
    {
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
    public function assignUnassignActivityFor($userName, $activityId, $operation)
    {
        $params = array($userName => $userName, $activityId => $activityId, $operation => $operation);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'assignUnassignActivityFor', $params);

        return $res;
    }
    /*
     * Old #-2.3-#
     */
    public function getWorkflowAssignUnassignActivityFor($userName, $activityId, $operation)
    {
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
        $params = array($userName => $userName, $activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'startActivityFor', $params);

        return $res;
    }
    /*
     * Old #-2.4#
     */
    public function getWorkflowStartActivityFor($userName, $activityId)
    {
        $params = array(
            $userName => $userName,
            $activityId => $activityId
        );
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'startActivityFor', $params);

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
    public function completeActivityFor($userName, $activityId, $completionOption)
    {
        $params = array($userName => $userName, $activityId => $activityId, $completionOption => $completionOption);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'completeActivityFor', $params);
        return $res;
    }
    /*
     * Old #-2.5#
     */
    public function getWorkflowcompleteActivityFor($userName, $activityId, $completionOption)
    {
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
    public function completeOpenActivityByName($postData)
    {
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'completeOpenActivityByName', null, $postData, 'V2.0');

        return $res;
    }
    /*
     * Old #-2.6#
     */
    public function getWorkflowCompleteOpenActivity($postData)
    {
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'completeOpenActivityByName', null, $postData, 'V2.0');

        return $res;
    }

    /**
     * Count of the queue
     * #-2.7#
     *
     * @param string $userName
     * @return CGX_Response
     */

    public function countDataOfQueues($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'countDataOf', $params);
        return $res;
    }
    /*
     * Old #-2.7#
     */
    public function getWorkflowActivity($userName)
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
    public function findDataFor($userName, $rowOffset = 0, $maximumRows)
    {
        $params = array(
            $userName => $userName,
            '?rowOffset' => $rowOffset
        );

        if (!empty($maximumRows)) {
            $params['&maximumRows'] = $maximumRows;
        }

        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findDataFor', $params);

        return $res;
    }
    /*
     * Old #-2.8#
     */
    public function getQueuesFindDataFor($userName, $rowOffset, $maximumRows)
    {
        $params = array(
            $userName => $userName,
            '?rowOffset' => $rowOffset,
            '&maximumRows' => $maximumRows
        );
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findDataFor', $params);

        return $res;
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
    public function findDataForTasks($userName, $rowOffset = 0, $maximumRows)
    {
        $params = array(
            $userName => $userName,
            '?rowOffset' => $rowOffset
        );

        if (!empty($maximumRows)) {
            $params['&maximumRows'] = $maximumRows;
        }

        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'tasks', 'findDataFor', $params);
        return $res;
    }
    /*
     * Old #-2.9#
     */
    public function getTasksFindDataFor($userName, $rowOffset, $maximumRows)
    {
        $params = array(
            $userName => $userName,
            '?rowOffset' => $rowOffset,
            '&maximumRows' => $maximumRows
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
    public function countDataOfTasks($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'tasks', 'countDataOf', $params);

        return $res;
    }
    /*
     * Old #-2.10#
     */
    public function getTasksCountDataOf($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'tasks', 'countDataOf', $params);

        return $res;
    }

    /**
     * Put the given workflow task on hold of a given user
     * #-2.11#
     *
     * @param string $userName
     * @param int $activityInstanceId
     * @return CGX_Response
     */
    public function holdActivityForWorkflow($userName, $activityInstanceId)
    {
        $params = array($userName => $userName, $activityInstanceId => $activityInstanceId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'holdActivityFor', $params);
        return $res;
    }
    /*
     * Old #-2.11#
     */
    public function getWorkflowHoldActivityFor($userName, $activityInstanceId)
    {
        $params = array($userName => $userName, $activityInstanceId => $activityInstanceId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'holdActivityFor', $params);
        return $res;
    }

    /**
     * Fetch all queues of the given user
     * #-2.12#
     *
     * @param string $userName
     * @return CGX_Response
     */
    public function findQueuesOfQueues($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findQueuesOf', $params);

        return $res;
    }
    /*
     * Old #-2.12#
     */
    public function getQueuesFindQueuesOf($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findQueuesOf', $params);

        return $res;
    }

    /**
     * Fetch the assignees of the given activity
     * #-2.13#
     *
     * @param int $activityInstanceId
     * @return CGX_Response
     */
    public function findAssigneesForUsers($activityInstanceId)
    {
        $params = array($activityInstanceId => $activityInstanceId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'users', 'findAssigneesFor', $params);
        return $res;
    }
    /*
     * Old #-2.13#
     */
    public function getUsersFindAssigneesFor($activityInstanceId)
    {
        $params = array($activityInstanceId => $activityInstanceId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'users', 'findAssigneesFor', $params);
        return $res;
    }

    /**
     * Fetch the history of the given workflow
     * #-2.14#
     *
     * @param int $workflow
     * @return CGX_Response
     */
    public function findHistoryForWorkflow($workflow)
    {
        $params = array($workflow => $workflow);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findHistoryFor', $params);

        return $res;
    }
    /*
     * Old #-2.14#
     */
    public function getWorkflowFindHistoryFor($workflow)
    {
        $params = array($workflow => $workflow);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findHistoryFor', $params);

        return $res;
    }

    /**
     * Resume the given task of the given user
     * #-2.15#
     *
     * @param string $userName
     * @param int $activityInstanceId
     * @return CGX_Response
     */
    public function resumeActivityForWorkflow($userName, $activityInstanceId)
    {
        $params = array($userName => $userName, $activityInstanceId => $activityInstanceId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'resumeActivityFor', $params);
        return $res;
    }
    /*
     * Old #-2.15#
     */
    public function getWorkflowResumeActivityFor($userName, $activityInstanceId)
    {
        $params = array($userName => $userName, $activityInstanceId => $activityInstanceId);
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
    public function findActivityStatusForWorkflow($activityId)
    {
        $params = array($activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findActivityStatusFor', $params);

        return $res;
    }
    /*
     * Old #-2.16#
     */
    public function getWorkflowFindActivityStatusFor($activityId)
    {
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
    public function findCaseDetailsForWorkflow($caseId)
    {
        $params = array($caseId => $caseId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCaseDetailsFor', $params);
        return $res;
    }
    /*
     * Old #-2.17#
     */
    public function getCaseFindCaseDetailsFor($caseId)
    {
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
    public function findCaseNotesForWorkflow($caseId)
    {
        $params = array($caseId => $caseId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCaseNotesFor', $params);

        return $res;
    }
    /*
     * Old #-2.18#
     */
    public function getWorkflowFindCaseNotesFor($caseId)
    {
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
    public function findCaseIdByActivityIdWorkflow($taskId)
    {
        $params = array($taskId => $taskId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCaseIdByActivityId', $params);
        return $res;
    }
    /*
     * Old #-2.19#
     */
    public function getCaseFindCaseIdByActivityId($taskId)
    {
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
    public function findCompletionResultsForWorkflow($activityId)
    {
        $params = array($activityId => $activityId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findCompletionResultsFor', $params);

        return $res;
    }
    /*
     * Old #-2.20#
     */
    public function getTaskFindCompletionResultsFor($activityId)
    {
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
    public function findFirstUserActivityForWorkflow($workflowId, $timeout)
    {
        $params = array($workflowId => $workflowId, '?timeout' => $timeout);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findFirstUserActivityFor', $params);
        return $res;
    }
    /*
     * Old #-2.21#
     */
    public function getTaskFindFirstUserActivityFor($workflowId, $timeout)
    {
        $params = array($workflowId => $workflowId, '?timeout' => $timeout);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'workflow', 'findFirstUserActivityFor', $params);
        return $res;
    }

    /**
     * Fetching the user details by given user id
     * #-3.1#
     *
     * @param int $userId
     * @return CGX_Response
     */
    public function findByIdUsers($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findById', $params);

        return $res;
    }
    /*
     * 3.1
     */
    public function findUserById($userId)
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
    public function findByNameUsers($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findByName', $params);

        return $res;
    }
    /*
     * 3.2
     */
    public function getUsersFindByName($userName)
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
    public function findAllUsersUsers()
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findAllUsers', null);

        return $res;
    }
    /*
     * 3.3
     */
    public function findAllUsersById()
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
    public function findUsersWithRoleUsers($roleId)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findUsersWithRole', $params);

        return $res;
    }
    /*
     * 3.4
     */
    public function getUsersFindUsersWithRole($roleId)
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
    public function findUsersForWorkAreaUsers($workAreaId)
    {
        $params = array($workAreaId => $workAreaId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'findUsersForWorkArea', $params);

        return $res;
    }
    /*
     * 3.5
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
    public function createUsers($postData)
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'create', null, $postData, 'V1.0');

        return $res;
    }
    /*
     * 3.6
     */
    public function getUsersCreate($postData)
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
    public function updateUsers($postData)
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'update', null, $postData);

        return $res;
    }
    /*
     * 3.7
     */
    public function updateUser($postData)
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
    public function updateRoleUserMappingUsers($roleId, $postData)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'updateRoleUserMapping', $params, $postData, 'V1.0');

        return $res;
    }
    /*
     * 3.8
     */
    public function getUsersUpdateRoleUserMapping($roleId, $postData)
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
    public function removeRoleFromCurrentUsersUsers($roleId)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'removeRoleFromCurrentUsers', $params);

        return $res;
    }
    /*
     * 3.9
     */
    public function removeRoleFromCurrentUsers($roleId)
    {
        $params = array($roleId => $roleId);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'removeRoleFromCurrentUsers', $params);

        return $res;
    }

    /**
     * Fetch all roles in the system
     * #-3.10#
     *
     * @return CGX_Response
     */
    public function findAllRoles()
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'roles', 'findAll');

        return $res;
    }
    /*
     * 3.10
     */
    public function getRolesFindAll()
    {
        $res = self::$inOut->sendRequest('UserServiceRest', 'roles', 'findAll');

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
    public function assignUserRolesUsers($userName, $postData)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'assignUserRoles', $params, $postData);

        return $res;
    }
    /*
     * 3.11
     */
    public function assignUserRoles($userName, $postData)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'assignUserRoles', $params, $postData);

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
    public function findUserRolesRoles($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'roles', 'findUserRoles', $params);

        return $res;
    }
    /*
     * 3.12
     */
    public function getRolesFindUserRoles($userName)
    {
        $params = array($userName => $userName);
        $res = self::$inOut->sendRequest('UserServiceRest', 'roles', 'findUserRoles', $params);

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
    public function authenticateUsers($userName, $password)
    {
        $params = array($userName => $userName);
        $postData = array('username' => $userName, 'password' => $password);
        $res = self::$inOut->sendRequest('UserServiceRest', 'users', 'authenticate', $params, $postData);

        return $res;
    }
    /*
     * 3.13
     */
    public function authenticateUser($userName, $postData)
    {
        $params = array($userName => $userName);
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
    public function createUsers_1($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'create', null, $postData, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.1
     */
    public function createUserInformation($postData)
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
    public function findByUserInformationIdUsers($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findByUserInformationId', $params, null, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.2
     */
    public function getUsersFindByUserInformationId($userId)
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
    public function countUnreadedUserInformationUsers($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'countUnreadedUserInformation', $params, null, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.3
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
    public function findByRelevantSystemUserUsers($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findByRelevantSystemUser', $params, null, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.4
     */
    public function getUsersFindByRelevantSystem($userId)
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
    public function findTotalCountBySystemUserUsers($userId)
    {
        $params = array($userId => $userId);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findTotalCountBySystemUser', $params, null, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.5
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
    public function UpdateUsers_1($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'update', null, $postData, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.6
     */
    public function getUsersUpdate($postData)
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
    public function markUserInformationReadUsers($userId, $isRead)
    {
        $params = array($userId => $userId, $isRead => $isRead);
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'markUserInformationRead', $params, null, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.7
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
    public function findUserInfoByPositionUsers($userId)
    {
        $params = array(
            $userId => $userId,
            '?start' => 0,
            '&max' => 1
        );
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'findUserInfoByPosition', $params, null, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.8
     */
    public function getUsersFindUserInfoByPosition($userId)
    {
        $params = array(
            $userId => $userId,
            '?start' => 0,
            '&max' => 1
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
    public function deleteUsers($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'delete', null, $postData, 'V1.0', 'information');

        return $res;
    }
    /*
     * 4.9
     */
    public function deleteUserInformation($postData)
    {
        $res = self::$inOut->sendRequest('UserInformationServiceRest', 'users', 'delete', null, $postData, 'V1.0', 'information');

        return $res;
    }


    /**
     * 
     * @param type $activityId
     * @return array results
     */
    public function getCompletionOptions($activityId)
    {
        $responseAPI = $this->getTaskFindCompletionResultsFor($activityId);
        $completionList = array();
        if (isset($responseAPI) && !$responseAPI->error) {
            $data = $responseAPI->getResponse();
            foreach ($data['results'] as $option) {
                $completionList[] = $option['key'];
            }
        }
        return $completionList;
    }
 
    public function updateTaskStatus($userName, $activityInstanceId)
    {
        $reponseAPI = $this->getWorkflowHoldActivityFor($userName, $activityInstanceId);
        $completionList = array();
        if (isset($responseAPI) && !$responseAPI->error) {
            $data = $responseAPI->getResponse();
            foreach ($data['results'] as $option) {
                $completionList[] = $option['key'];
            }
        }
        return $completionList;
    }

    /**
     * Find Queue data by User name, activity id, queue id
     * @param $userName
     * @param $activityId
     * @param $queueId
     * @return object
     */
    public function CGX_findQueueDataFor($userName, $activityId, $queueId){
        $params = array($userName => $userName, $activityId => $activityId, $queueId => $queueId);
        $res = self::$inOut->sendRequest('WorkflowServiceRest', 'queues', 'findQueueDataFor', $params);
        return $res;
    }
}
