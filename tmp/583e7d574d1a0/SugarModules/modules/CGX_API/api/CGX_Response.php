<?php

require_once('modules/CGX_API/entity/CGX_Error.php');

/**
 * CGX API Response class
 */
class CGX_Response {

    public $response;
    public $error;

    /**
     * Constructor
     * @param type $responseData
     */
    public function __construct($responseData = array())
    {
        $response = $this->responseParser($responseData);

        if (isset($response['statusCode'])) {
            $status = $response;
        } else {
            $status = isset($response['status']['statusCode']) ? $response['status'] : false;
        }

        if ($status && $status['statusCode'] !== '000') {
            $this->error = new CGX_Error($status['statusCode'], $status['statusMessage']);
        } else {
            $this->response = $response;
        }
    }

    /**
     * responseParser
     *
     * @param type $responseData
     * @return type
     */
    protected function responseParser($responseData)
    {
        $key = current(array_keys($responseData));
        $response = null;
        switch ($key) {
            case 'integerWrapperDetails':
                $response = $responseData['integerWrapperDetails'];
                break;
            case 'initiateWorkflowReturnDetails':
                $response = $responseData['initiateWorkflowReturnDetails'];
                break;
            case 'statusDetails':
                $response = $responseData['statusDetails'];
                break;
            case 'myTasksPageDataDetails':
                $response = $responseData['myTasksPageDataDetails'];
                break;
            case 'caseDetails':
                $response = $responseData['caseDetails'];
                break;
            case 'activityInformationDetails':
                $response = $responseData['activityInformationDetails'];
                break;
            case 'myQueueTablePageDataDetails':
                $response = $responseData['myQueueTablePageDataDetails'];
                break;
            case 'myQueueDetailsCollection':
                $response = $responseData['myQueueDetailsCollection'];
                break;
            case 'workflowHistoryViewDetailsCollection':
                $response = $responseData['workflowHistoryViewDetailsCollection'];
                break;
            case 'activityStatusDetails':
                $response = $responseData['activityStatusDetails'];
                break;
            case 'caseNoteDetailsCollection':
                $response = $responseData['caseNoteDetailsCollection'];
                break;
            case 'systemUserDetailsCollection':
                $response = $responseData['systemUserDetailsCollection'];
                break;
            case 'cgxRoleDetailsCollection':
                $response = $responseData['cgxRoleDetailsCollection'];
                break;
            case 'userInformationDetailsCollection':
                $response = $responseData['userInformationDetailsCollection'];
                break;
            case 'completionResultDetailsCollection':
                $response = $responseData['completionResultDetailsCollection'];
                break;
            case 'initiateWorkflowReturnDetailsEx':
                $response = $responseData['initiateWorkflowReturnDetailsEx'];
                break;
            case 'longWrapperDetails':
                $response = $responseData['longWrapperDetails'];
                break;
            case 'authenticationDetails':
                $response = $responseData['authenticationDetails'];
                break;
            /** UPDATE NEW RESPONSE - CGX CONNECTOR V3 **/
            case 'activityInformationDetailsV2':
                $response = $responseData['activityInformationDetailsV2'];
                break;
            /** END UPDATE **/
            default:
                $response = null;
                break;
        }

        return $response;
    }

    /**
     * Get response
     *
     * @return String
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get Error
     *
     * @return String
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set Response
     * @param array $response
     *
     * @return api\CGX_Response
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Set Error
     * @param entity/CGX_Error $error
     *
     * @return api\CGX_Response
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

}
