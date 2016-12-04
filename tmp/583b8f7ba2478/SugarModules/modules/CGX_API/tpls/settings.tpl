<div id="bootstrap-container" class="main">
    <div id="content">
        <div id="pagecontent">
            <div class="moduleTitle">
                <h2>API Setting</h2>
                <div class="clear"></div>
            </div>
            <div class="dashletPanelMenu wizard">
                <div class="bd">
                    <div class="screen">
                        <form name="ConfigureSettings" id="EditView" method="POST" class="form-horizontal">
                            <div class="form-group"> 
                                <label for="cgx_api_url" class="col-lg-1 control-label">API URL:</label> 
                                <div class="col-lg-10">
                                    <input type="text" id="cgx_api_url" name="cgx_api_url" value="{$cgx_api_url}" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label for="cgx_public_url" class="col-lg-1 control-label">PUBLIC URL:</label> 
                                <div class="col-lg-10">
                                    <input type="text" id="cgx_public_url" name="cgx_public_url" value="{$cgx_public_url}" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label for="cgx_api_username" class="col-lg-1 control-label">USER NAME:</label> 
                                <div class="col-lg-10">
                                    <input type="text" id="cgx_api_username" name="cgx_api_username" value="{$cgx_api_username}" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label for="cgx_api_password" class="col-lg-1 control-label">PASSWORD:</label> 
                                <div class="col-lg-10">
                                    <input type="password" id="cgx_api_password" name="cgx_api_password" class="form-control" value="{$cgx_api_password}"/>
                                </div>
                            </div>
                            <div class="form-group" id="confirm_password"> 
                                <label for="cgx_api_confirm_password" class="col-lg-1 control-label">CONFIRM PASSWORD:</label> 
                                <div class="col-lg-10">
                                    <input type="password" id="cgx_api_confirm_password" name="cgx_api_confirm_password" class="form-control"  value="{$cgx_api_password}"/>
                                    <br/>
                                    <div id="confirm_password_error" class="has-error" style="display:none;">The passwords do not match.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="aesSecret" class="col-lg-1 control-label">ENCRYPTION KEY:</label> 
                                <div class="col-lg-10">
                                    <input type="password" id="aesSecret" name="aesSecret" class="form-control" value="{$cgx_api_secretkey}"/>
                                </div>
                            </div>
                            <div class="form-group" id="confirm_aesSecret_group"> 
                                <label for="confirm_aesSecret" class="col-lg-1 control-label">CONFIRM ENCRYPTION KEY:</label> 
                                <div class="col-lg-10">
                                    <input type="password" id="confirm_easSecret" name="confirm_aesSecret" class="form-control" value="{$cgx_api_secretkey}"/>
                                    <br/>
                                    <div id="confirm_aesSecret_error" class="has-error" style="display:none;">The Encryption Key do not match.</div>
                                </div>
                            </div>
                            <div class="form-group" id="cgx_role_default"> 
                                <label for="input_cgx_role_default" class="col-lg-1 control-label">CGX ROLE DEFAULT:</label> 
                                <div class="col-lg-10">
                                    <input type="text" id="input_cgx_role_default" name="CGX_role" class="form-control" value="{$cgx_role}"/>
                                </div>
                            </div>       
                            <div class="form-group"> 
                                <label for="cgx_api_environment" class="col-lg-1 control-label">Enable CGX web service debug logs:</label> 
                                <div class="col-lg-10">
                                    <select name="cgx_api_environment" class="form-control" style="padding: 0 0 0 0">
                                        <option value="development" {if $cgx_api_environment == 'development'}selected{/if}>On (development)</option>
                                        <option value="production" {if $cgx_api_environment == 'production'}selected{/if}>Off (production)</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="module" value="CGX_API">
                            <input type="hidden" name="action" value="Settings">


                            <button type='submit' title='Save Configuration' class="button" onclick="confirmEncryption();" />Save Configuration</button>
                            <button type="button" title="Test connection" class="button" onclick="testConnection();">Test Connection</button>
                            <button type="button" title="Resync" class="button" onclick="resync();">Resync</button>
                        </form>
                        <script language='javascript' type='text/javascript'>
                            {literal} 
                            $("#create_link").attr('href', 'javascript: void(0);');
                            $("#create_image").attr('href', 'javascript: void(0);');
                            $("#create_image").hide();
                            $("#create_link").hide();

                            function confirmEncryption() {
                                SUGAR.ajaxUI.showLoadingPanel();
                                var aesSecretField = document.getElementById('aesSecret');
                                var confirmSecretField = document.getElementById('confirm_aesSecret');

                                if (easSecretField.value != confirmEasSecretField.value) {
                                    SUGAR.ajaxUI.hideLoadingPanel();
                                    $("#confirm_aesSecret_error").hide();
                                    $("#confirm_aesSecret").addClass('has-error');
                                    // has-error
                                    confirmSecretField.setCustomValidity('The Encryption Key do not match.');
                                    $("#confirm_aesSecret_error").show();
                                    return 0;
                                }

                                $("#confirm_aesSecret_error").hide();
                                SUGAR.ajaxUI.hideLoadingPanel();
                                return 1;
                            }
                            function testConnection() {
                                SUGAR.ajaxUI.showLoadingPanel();

                                if (!SUGAR.ajaxUI.errorPanel) {
                                    SUGAR.ajaxUI.errorPanel = new YAHOO.widget.Panel("ajaxUIErrorPanel", {
                                        modal: false,
                                        visible: true,
                                        constraintoviewport: true,
                                        width: "400px",
                                        height: "300px",
                                        close: true
                                    });
                                }
                                var wsdlField = document.getElementById('cgx_api_url');
                                var usernameField = document.getElementById('cgx_api_username');
                                var passwField = document.getElementById('cgx_api_password');
                                $.ajax({
                                    url: 'index.php?module=CGX_API&action=TestConnection',
                                    type: 'POST',
                                    data: {
                                        'wsdl': wsdlField.value,
                                        'username': usernameField.value,
                                        'password': passwField.value
                                    },
                                    success: function (data) {
                                        if (data == 1) {
                                            SUGAR.ajaxUI.hideLoadingPanel();
                                            SUGAR.ajaxUI.showErrorMessage("Success");
                                        } else {
                                            SUGAR.ajaxUI.hideLoadingPanel();
                                            SUGAR.ajaxUI.showErrorMessage('Unable to connect to Casegenix');
                                        }
                                    },
                                    error: function (xhr) {
                                        SUGAR.ajaxUI.hideLoadingPanel();
                                        SUGAR.ajaxUI.showErrorMessage('Unable to connect to Casegenix');
                                    }
                                });

                            }

                            function resync(){
                                SUGAR.ajaxUI.showLoadingPanel();

                                if (!SUGAR.ajaxUI.errorPanel) {
                                    SUGAR.ajaxUI.errorPanel = new YAHOO.widget.Panel("ajaxUIErrorPanel", {
                                        modal: false,
                                        visible: true,
                                        constraintoviewport: true,
                                        width: "400px",
                                        height: "300px",
                                        close: true
                                    });
                                }
                                $.ajax({
                                    url: 'index.php?module=CGX_API&action=Resync',
                                    method: 'POST',
                                    dataType: 'json',
                                    success: function (data) {
                                        SUGAR.ajaxUI.hideLoadingPanel();
                                        SUGAR.ajaxUI.showErrorMessage(data.mess);
                                    }
                                });
                            }
                            {/literal}
                        </script>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
