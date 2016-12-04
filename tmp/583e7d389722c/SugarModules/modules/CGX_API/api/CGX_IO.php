<?php

require_once('modules/Configurator/Configurator.php');
require_once(__DIR__ . '/CGX_Response.php');

/**
 * CGX_IO
 * class using to process Input/Output
 */
class CGX_IO {

    private static $accessConfig;
    private static $developModes;
    private static $printInputAndOutputXml;
    protected $pad;

    /**
     * Constructor
     *
     * @return API\CGX_IO
     */
    public function __construct() {
        // get Configuration
        global $current_user;
        $configurator = new Configurator();
        $configurator->loadConfig();

        $cgx_api_environment = isset($configurator->config['CGX_API_cgx_api_environment']) ? $configurator->config['CGX_API_cgx_api_environment'] : 'development';

        // init IO param
        // get param from config
        $isDevelopMod = false; // set default modes
        if ($cgx_api_environment == 'development') {
            $isDevelopMod = true;
        }

        // Set modes
        $this->setDevelopModes($isDevelopMod);
        
        $username = $current_user->user_name;
        $password = $current_user->cgx_encrypted_password_c;
        $pad = $current_user->cgx_pad_password_c;
        if($current_user->user_name == 'admin'){
            $username = isset($configurator->config['CGX_API_cgx_api_username']) ? $configurator->config['CGX_API_cgx_api_username'] : '';
            $password = isset($configurator->config['CGX_API_cgx_api_password']) ? $configurator->config['CGX_API_cgx_api_password'] : '';
            if (trim($password) != '') {
                $password = $this->encryptPassword($password);
                $pad = $this->getPad();
            }else{
                $GLOBALS['log']->debug("CGX_IO::__construct --> Can not set new config for admin user.");
            }
        }
        $arrayConfig = array(
            'sys_config' => $configurator,
            'user_config' => array( 
                'username' => $username,
                'password' => $password,
                'pad' => $pad,
                )
        );
        // set access config
        $this->setAccessConfig($arrayConfig);

        return $this;
    }

    /**
     * Get Access Config
     *
     * @return array
     */
    public static function getAccessConfig() {
        return self::$accessConfig;
    }

    /**
     * Set Access Config
     * @param array $accessParams
     *
     * @return array
     */
    public static function setAccessConfig($accessParams) {
        
        $wsdl = !empty($accessParams['sys_config']->config['CGX_API_cgx_api_url']) ? $accessParams['sys_config']->config['CGX_API_cgx_api_url'] : '';
        $public_url = !empty($accessParams['sys_config']->config['CGX_API_cgx_public_url']) ? $accessParams['sys_config']->config['CGX_API_cgx_public_url'] : '';
        $aesSecret = !empty($accessParams['sys_config']->config['Casegenix.aes.encryption.secret.key']) ? $accessParams['sys_config']->config['Casegenix.aes.encryption.secret.key'] : 'TheBestSecretKey';

        // init config;
        $accessConfig = array(
            'wsdl' => $wsdl,
            'public_url' => $public_url,
            'username' => $accessParams['user_config']['username'],
            'password' => $accessParams['user_config']['password'],
            'pad' => $accessParams['user_config']['pad'],
            'aesSecret' => $aesSecret
        );

        self::$accessConfig = $accessConfig;
    }

    /**
     * Get Develop modes
     *
     * @return Boolean
     */
    public static function getDevelopModes() {
        return self::$developModes;
    }

    /**
     * Set develop modes
     *
     * @param Boolean $developModes
     *
     * @return Boolean
     */
    public static function setDevelopModes($developModes) {
        self::$developModes = $developModes;
    }

    /**
     * Get IO
     *
     * @return Boolean
     */
    public static function getPrintInputAndOutputXml() {
        return self::$printInputAndOutputXml;
    }

    /**
     * Set IO
     *
     * @param Boolean $printInputAndOutputXml
     *
     * @return Boolean
     */
    public static function setPrintInputAndOutputXml($printInputAndOutputXml) {
        self::$printInputAndOutputXml = $printInputAndOutputXml;
    }

    /**
     * Send request
     *
     * @param String $methodName
     * @param array  $params
     * @param String $version
     *
     * @return ApiResponse
     */
    //'WorkflowServiceRest', 'tasks', 'findDataFor', $params
    public function sendRequest($serviceName = null, $resource = null, $action = null, $params = null, $postData = '', $version = 'V1.0', $info = '') {
        $wsdl = self::$accessConfig['wsdl'];
        $httpHeader = $this->buildHttpPath($serviceName, $resource, $action, $version, $params, $info);
        $this->printDebugLog($wsdl);
        $username = self::$accessConfig['username'];
        $password = $this->decryptPassword(self::$accessConfig['password']);
        $password = $this->getOriginalPassword($password, self::$accessConfig['pad']);
        $users_authenticate = strpos($httpHeader['httpPath'], '/users/authenticate/') !== false;
        $headers = array(
            "Content-type: application/json;charset=utf-8",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Authorization: Basic " . base64_encode("{$username}:{$password}"),
            "HttpPath: " . $httpHeader['httpPath'],
            "HttpQuery: " . $httpHeader['httpQuery']
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $wsdl);
        //curl_setopt($ch, CURLOPT_COOKIEJAR, tempnam('/tmp', 'cookie'));    //SE363
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if ($postData) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_USERPWD, "{$username}:{$password}");

            if (is_string($postData)) {
                $postData = json_decode($postData, true);
            }

            if (!empty($postData['SystemUserDetails']['password'])) {
                $postData['SystemUserDetails']['password'] = $this->encryptPassword($postData['SystemUserDetails']['password']);
            }
            if (!empty($postData['UserInformationDetails']['relevantUser']['password'])) {
                $postData['UserInformationDetails']['relevantUser']['password'] = $this->encryptPassword($postData['UserInformationDetails']['relevantUser']['password']);
            }

            if ($users_authenticate) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData['password']);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $errorData = new CGX_Error('500', 'curl_err : ' . curl_error($ch));
            $responseData = new CGX_Response();
            $responseData->setError($errorData);
            $this->printDebugLog($responseData->getError());
            return $responseData;
        } else {
            $returnCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($returnCode) {
                case 200:
                    //General parsing
                    $content = json_decode($response, true);
                    $this->printDebugLog($content);
                    curl_close($ch);
                    return new CGX_Response($content);
                case 204:
                    $errorData = new CGX_Error('204', "Server has received the request but there is no information to send back");
                    break;
                case 400:
                    $errorData = new CGX_Error('400', "Bad Request : The server cannot or will not process the request due to " .
                            "something that is perceived to be a client error");
                    break;
                case 401:
                    $errorData = new CGX_Error('401', "HTTP Basic Authentication : Unauthorized, please contact admin");
                    break;
                case 403:
                    $errorData = new CGX_Error('403', "IP is not allowed to access CGX API, please contact admin");
                    break;
                case 404:
                    $errorData = new CGX_Error('404', "Check that the access URLs are correct. If yes, please contact admin");
                    break;
                case 500:
                    $errorData = new CGX_Error('500', "Internal server error, please contact admin");
                    break;
                default:
                    break;
            }

            curl_close($ch);
            $responseData = new CGX_Response();
            $responseData->setError($errorData);
            $this->printDebugLog($responseData->getError());
            return $responseData;
            die();
        }
    }

    /**
     * build HttpPath Header
     * @param string $serviceName
     * @param string $resource
     * @param string $action
     * @param string $version
     * @param string $params
     * @param string $info
     * @return string
     */
    public function buildHttpPath($serviceName, $resource, $action, $version, $params = array(), $info) {
        $httpPath = "/services/$serviceName/$version/$resource/$action";
        $httpQuery = "";
        if ($info != '') {
            $httpPath = "/services/$serviceName/$version/$resource/$info/$action";
        }
        if (count($params)) {
            foreach ($params as $key => $val) {
                if (is_numeric($key) || $key === $val) {
                    $httpPath .= "/$val";
                } else {
                    foreach ($val as $k => $v) {
                        $httpQuery .= $k . "=" . $v;
                    }
                }
            }
        }
        return array(
            "httpPath" => $httpPath,
            "httpQuery" => $httpQuery,
        );
    }

    public function printDebugLog($resource) {
        if ($this->getDevelopModes()) {
            $GLOBALS['log']->debug($resource);
        }
    }

    public function encryptPassword($password = null, $secret_key = null) {
        if (empty($password)) {
            return null;
        }
        if (empty($secret_key)) {
            $secret_key = self::$accessConfig['aesSecret'];
        }
        if (empty($secret_key)) {
            $secret_key = 'TheBestSecretKey';
        }
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($password, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $secret_key, $iv);
        $encPassword = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encPassword);
    }

    public function decryptPassword($password = null, $secret_key = null) {
        if (empty($password)) {
            return null;
        }
        if (empty($secret_key)) {
            $secret_key = self::$accessConfig['aesSecret'];
        }
        if (empty($secret_key)) {
            $secret_key = 'TheBestSecretKey';
        }
        return mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128, $secret_key, base64_decode($password), MCRYPT_MODE_ECB);
    }

    public function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        $this->setPad($pad);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function setPad($pad) {
        $this->pad = $pad;
    }

    public function getPad() {
        return $this->pad;
    }

    public function getOriginalPassword($text, $pad) {
        return str_replace(chr($pad), '', $text);
    }

}
