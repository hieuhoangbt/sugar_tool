<?php
require_once('modules/CGX_API/api/CGX_Kit_Factory.php');
require_once('custom/modules/ACLRoles/ACLRoleCustom.php');
require_once ('modules/Configurator/Configurator.php');

class triggerCasegenixUsersSaveTest extends PHPUnit_Framework_TestCase{
    
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
    
    public function test_get_user_roles(){
    
        try {
            $roles = array();
            $role = new ACLRoleCustom();
            $acl_roles = $role->getUserRoles(1, false);
            if($acl_roles){
                foreach($acl_roles as $acl_role){
                    if(!empty($acl_role->casegenix_role)){
                        if(!in_array($acl_role->casegenix_role, $roles)){
                            $roles[] = $acl_role->casegenix_role;
                        }
                    }
                }
                $this->assertTrue(is_array($roles));
            } else {
                $this->assertNotNull($acl_roles);
            }
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }
    
    public function test_get_casegenix_roles(){
    
        try {
        
            $cgx_roles = array();
            $cgx_kit = CGX_Kit_Factory::create('roles');
            $inOutTest = self::getConfig();
            $cgx_kit->setInOut($inOutTest);
            $roleExists = $cgx_kit->findAll();
            $response = @$roleExists->getResponse();
            if(!empty($response['roles'])){
            
                if(!empty($response['roles']['roleId'])){
                
                    $cgx_roles[] = $response['roles'];
                }else{
                
                    foreach($response['roles'] as $cgx_role){
                    
                        if(!empty($cgx_role['roleId'])){
                        
                            $cgx_roles[] = $cgx_role;
                        }
                    }
                }
            }
            $this->assertTrue(is_array($cgx_roles));
        } catch (Exception $e) {
        
            $this->fail($e->getMessage());
        }
    }
}
