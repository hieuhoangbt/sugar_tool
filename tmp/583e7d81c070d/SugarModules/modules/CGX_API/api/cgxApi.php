<?php

require_once('modules/Configurator/Configurator.php');
require_once('CGX_Response.php');

/**
 * cgxApi
 * class using to process cgxApi call
 */
class cgxApi {

    private static $accessConfig;
    /**
     * Constructor
     *
     * @return cgxApi
     */
    public function __construct() {
        // get Configuration
        $configurator = new Configurator();
        $configurator->loadConfig();
        // set access config
        $this->setAccessConfig($configurator);

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

        $wsdl = !empty($accessParams->config['CGX_API_cgx_api_url']) ? $accessParams->config['CGX_API_cgx_api_url'] : '';
        $public_url = !empty($accessParams->config['CGX_API_cgx_public_url']) ? $accessParams->config['CGX_API_cgx_public_url'] : '';
        $username = !empty($accessParams->config['CGX_API_cgx_api_username']) ? $accessParams->config['CGX_API_cgx_api_username'] : '';
        $password = !empty($accessParams->config['CGX_API_cgx_api_password']) ? $accessParams->config['CGX_API_cgx_api_password'] : '';
        $aesSecret = !empty($accessParams->config['Casegenix.aes.encryption.secret.key']) ? $accessParams->config['Casegenix.aes.encryption.secret.key'] : 'TheBestSecretKey';
        // init config;
        $accessConfig = array(
            'wsdl' => $wsdl,
            'public_url' => $public_url,
            'username' => $username,
            'password' => $password,
            'aesSecret' => $aesSecret
        );

        self::$accessConfig = $accessConfig;
    }
    /**
     * Send request
     *
     * @param string $endpoint
     * @param array $params
     * @param string $method
     *
     * @return CGX_Response
     */
    public function requestJSON($endpoint = null, $params = array(), $method = 'GET') {
        try{
            $wsdl = trim(self::$accessConfig['wsdl'], '/ ') . '/services/' . trim($endpoint, '/ ');
            if($params && $method == 'GET'){
                if(is_string($params)){
                    $wsdl .= '?' . ltrim($params, '? ');
                }else{
                   $wsdl .= '?' . http_build_query($params);
                }
            }
            $username = self::$accessConfig['username'];
            $password = self::$accessConfig['password'];
            $users_authenticate = strpos($wsdl, '/users/authenticate/') !== false;
            $headers = array(
                "Content-type: application/json;charset=utf-8",
                "Accept: application/json",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Authorization: Basic " . base64_encode("{$username}:{$password}")
            );
    
            $ch = curl_init($wsdl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 600);
            if ($method == 'POST' && $params) {
                curl_setopt($ch, CURLOPT_POST, true);
                if(is_string($params)){
                    $params = json_decode($params, true);
                    if(!empty($params['password'])){
                        $params['password'] = $this->encryptPassword($params['password']);
                    }
                    if(!empty($params['SystemUserDetails']['password'])){
                        $params['SystemUserDetails']['password'] = $this->encryptPassword($params['SystemUserDetails']['password']);
                    }
                    if(!empty($params['UserInformationDetails']['relevantUser']['password'])){
                        $params['UserInformationDetails']['relevantUser']['password'] = $this->encryptPassword($params['UserInformationDetails']['relevantUser']['password']);
                    }
                    if($users_authenticate){
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params['password']);
                    }else{
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                    }
                }else{
                    if(!empty($params['password'])){
                        $params['password'] = $this->encryptPassword($params['password']);
                    }
                    if(!empty($params['SystemUserDetails']['password'])){
                        $params['SystemUserDetails']['password'] = $this->encryptPassword($params['SystemUserDetails']['password']);
                    }
                    if(!empty($params['UserInformationDetails']['relevantUser']['password'])){
                        $params['UserInformationDetails']['relevantUser']['password'] = $this->encryptPassword($params['UserInformationDetails']['relevantUser']['password']);
                    }
                    if($users_authenticate){
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params['password']);
                    }else{
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                    }
                }
            }
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $errorData = new CGX_Error('500', 'curl_err : ' . curl_error($ch));
                $responseData = new CGX_Response();
                $responseData->setError($errorData);
                return $responseData;
            } else {
                $returnCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
                switch ($returnCode) {
                    case 200:
                        //General parsing
                        $content = json_decode($response, true);
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
                return $responseData;
            }
        }catch(Exception $e){
            $errorData = new CGX_Error('500', $e->getmessage());
            $responseData = new CGX_Response();
            $responseData->setError($errorData);
            return $responseData;
        }
    }
    
    public function encryptPassword($password = null) {
        if(empty($password)){
            return null;
        }
        $key = self::$accessConfig['aesSecret'];
        if(empty($key)){
            $key = 'TheBestSecretKey';
        }
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($password, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $encPassword = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encPassword);
    }
    
    public function decryptPassword($password = null) {
        if(empty($password)){
            return null;
        }
        $key = self::$accessConfig['aesSecret'];
        if(empty($key)){
            $key = 'TheBestSecretKey';
        }
        return trim(mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128, $key, base64_decode($password), MCRYPT_MODE_ECB));
    }
    
    public function pkcs5_pad ($text, $blocksize)
    { 
        $pad = $blocksize - (strlen($text) % $blocksize); 
        return $text . str_repeat(chr($pad), $pad); 
    }
}
