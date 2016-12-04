<?php

class ESB_Factory {

    public static $esbUri;

    public function __construct() {
        // get Configuration
        $configurator = new Configurator();
        $configurator->loadConfig();

        self::$esbUri = !empty($configurator->config['CGX_API_cgx_api_url']) ? $configurator->config['CGX_API_cgx_api_url'] : '';
    }

    public function test_post_to_ESB() {
        $GLOBALS['log']->fatal('ESB URL : ' . self::$esbUri);
        $postData = '
            { 
                "SystemUserDetails" :
                {
                    "addressLine1" : "",
                    "addressLine2" : "",
                    "email" : "",
                    "faxNo" : "",
                    "firstName" : "hieu",
                    "groupMailAddress" : "",
                    "password" : "dev1",
                    "phoneNumber" : "",
                    "postcode" : "",
                    "staffNumber" : "",
                    "state" : "",
                    "suburb" : "",
                    "surname" : "hoang",
                    "userName" : "dev1"
                } 
            }';
        $postData = json_decode($postData, true);
        //open connection
        $ch = curl_init();
        $headers = array(
            "Content-type: application/json;charset=utf-8",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache"
        );
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, self::$esbUri);
        curl_setopt($ch, CURLOPT_COOKIEJAR, tempnam('/tmp', 'cookie'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        echo "<pre> \n <br />";
        var_dump($result);
        die("\n <br /> Debug: " . __METHOD__);
    }

}
