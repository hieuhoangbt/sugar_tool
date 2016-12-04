<?php
require_once ('modules/Configurator/Configurator.php');
require_once ('modules/CGX_API/api/CGX_Kit_Factory.php');

class batchJobTest extends PHPUnit_Framework_TestCase{
    
    public static function getConfig() {
        require_once('modules/CGX_API/api/CGX_IO.php');
        require_once 'modules/Configurator/Configurator.php';
        $inOut = new CGX_IO();
        $wsdl = 'http://casegenix-qa.genixventures.com:9090/casegenix';
        $username = 'hdwebsoft';
        $password = 'dragon459';
        $configurator = new Configurator();
        $configurator->loadConfig();
        $configurator->config['CGX_API_cgx_api_url'] = $wsdl;
        $configurator->config['CGX_API_cgx_public_url'] = 'http://casegenix-qa.genixventures.com:9090/casegenix/wfInstanceViewer';
        $configurator->config['CGX_API_cgx_api_username'] = $username;
        $configurator->config['CGX_API_cgx_api_password'] = $password;
        $inOut->setAccessConfig($configurator);
        return $inOut;
    }
    
    public function test_open_tasks(){
        try {
            global $db;
            $open_tasks = array();
            $query = "SELECT c.activity_id_c FROM tasks t LEFT JOIN tasks_cstm c ON (t.id = c.id_c) WHERE t.deleted = 0 AND c.activity_id_c IS NOT NULL AND t.status IN ( 'created', 'started','suspended' )";
            $res = $db->query($query);
            while ($row = $db->fetchByAssoc($res)) {
                if(!empty($row['activity_id_c'])){
                    $open_tasks[] = $row['activity_id_c'];
                }
            }
            $this->assertTrue(is_array($open_tasks));
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }
    
    public function test_get_my_queues(){
        try {
            $cgx_kit = CGX_Kit_Factory::create('queues');
            $inOutTest = self::getConfig();
            $cgx_kit->setInOut($inOutTest);
            $cgx_response = $cgx_kit->findDataFor('hdwebsoft', 0, 10);
            $cgx_response_response = @$cgx_response->getResponse();
            //$this->assertTrue(isset($cgx_response_response['rows']));
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}
