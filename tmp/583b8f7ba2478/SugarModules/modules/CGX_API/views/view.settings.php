<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 * ****************************************************************************** */

/**
 * ShowView
 */
class CGX_APIViewSettings extends ViewEdit {

    public function __construct()
    {
        $this->useForSubpanel = false;
        $this->useModuleQuickCreateTemplate = false;
        parent::__construct();
    }

    public function preDisplay()
    {
        
        require_once 'modules/Configurator/Configurator.php';
        $configurator = new Configurator();
        $configurator->loadConfig();
        $url = isset($configurator->config['CGX_API_cgx_api_url']) && $configurator->config['CGX_API_cgx_api_url'] ? $configurator->config['CGX_API_cgx_api_url'] : '';
        $publicUrl = isset($configurator->config['CGX_API_cgx_public_url']) && $configurator->config['CGX_API_cgx_public_url'] ? $configurator->config['CGX_API_cgx_public_url'] : '';
        $username = isset($configurator->config['CGX_API_cgx_api_username']) && $configurator->config['CGX_API_cgx_api_username'] ? $configurator->config['CGX_API_cgx_api_username'] : '';
        $password = isset($configurator->config['CGX_API_cgx_api_password']) && $configurator->config['CGX_API_cgx_api_password'] ? $configurator->config['CGX_API_cgx_api_password'] : '';
        $secretKey = isset($configurator->config['Casegenix.aes.encryption.secret.key']) && $configurator->config['Casegenix.aes.encryption.secret.key'] ? $configurator->config['Casegenix.aes.encryption.secret.key'] : '';
        $environment = isset($configurator->config['CGX_API_cgx_api_environment']) && $configurator->config['CGX_API_cgx_api_environment'] ? $configurator->config['CGX_API_cgx_api_environment'] : '';
        $cgx_role = isset($configurator->config['CGX_API_cgx_role']) && $configurator->config['CGX_API_cgx_role'] ? $configurator->config['CGX_API_cgx_role'] : '';
        
        $this->ss->assign('cgx_api_url', $url);
        $this->ss->assign('cgx_public_url', $publicUrl);
        $this->ss->assign('cgx_api_username', $username);
        $this->ss->assign('cgx_api_password', $password);
        $this->ss->assign('cgx_api_secretkey', $secretKey);
        $this->ss->assign('cgx_api_environment', $environment);
        $this->ss->assign('id', 1);
        $this->ss->assign('cgx_role', $cgx_role);
        
        $metadataFile = $this->getMetaDataFile();
        $this->ev = $this->getEditView();
        $this->ev->ss = & $this->ss;
        $this->bean->additional_meta_fields = array('id'=> 1, 'name'=>'CGX_API');
        $this->ev->setup($this->module, $this->bean, $metadataFile, get_custom_file_if_exists('modules/CGX_API/tpls/settings.tpl'));
    }

}
