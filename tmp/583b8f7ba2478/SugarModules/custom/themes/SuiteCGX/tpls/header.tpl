{include file="_head.tpl" theme_template=true}
<body onMouseOut="closeMenus();">
<div class="color-line"></div>
{$DCSCRIPT}
{if $AUTHENTICATED}


    <div class="header">
        <div id="logo" class="light-version">
                <span>
                    <a href="index.php" title="Home">
                        {php}$file_ext = pathinfo($stored_file_name, PATHINFO_EXTENSION);{/php}
                        <img src="themes/SuiteCGX/images/company_logo.png?time={php}echo time(){/php}" alt="Home">
                    </a>
                </span>
        </div>

        <nav role="navigation">
            <div id="leftSidebarToggle" class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        </nav>

        <form id="searchform" class="navbar-form" name='UnifiedSearch' action='index.php' onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
            <input type="hidden" class="form-control" name="action" value="UnifiedSearch">
            <input type="hidden" class="form-control" name="module" value="Home">
            <input type="hidden" class="form-control" name="search_form" value="false">
            <input type="hidden" class="form-control" name="advanced" value="false">
            <div class="input-group">
                <input name="query_string" id="query_string" type="text" class="form-control" placeholder="Search Site ..." value="{$SEARCH}" />
            </div>
        </form>

        <div class="navbar-right">
            {* START: Business Process CaseGenix  *}

            <script id="tpl-business-process-data-top-bar" type="text/template">
                <a title="Display Bussiness Process" id="autoClickMe" href="javascipt:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="themes/SuiteCGX/images/icon_process.png" /></span>
                </a>
                <ul class="dropdown-menu hdropdown animated flipInX businessProcessMenu" role="menu" style="width: 400px">
                    <li><b>Task:</b> <a target="_blank" href='%=linkToTask%'>%=Name%</a></li>
                    <li><b>Relate to:</b> <a target="_blank" href='%=relateToUrl%'>%=parentName%</a></li>
                    <li><b>Business process name:</b> <a href='javascript:void(0);'>%=businessProcessName%</a></li>
                    <li style="border-bottom: none">%=completionOptions%</li>
                    <li style="border-top: 1px solid #e4e5e7"><a href="javascript:void(0);" onClick="window.open('%=urlBusinessProcess%', '', 'toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=1000,height=1000');" style="display: inline">Display business process</a></li>
                    <li><a href='javascript:void(0);' class="actionDeferTop" data-userid="%=assigned_user_id%" data-activityid="%=activityID%" data-taskid="%=taskid%" style="display: inline">Defer</a></li>
                    %=checkListItems%
                </ul>

            </script>
            <script id="tpl-completion-option-business-process" type="text/template">
                <li style="border: none"><a href="javascript:void(0);" class="actionCompletionTop" data-userid="%=assigned_user_id%" data-activityid="%=activityID%" data-taskid="%=taskid%" data-completion="%=completion%" style = 'display: inline; %=style-disabled%'>%=completion%</a></li>
            </script>
            <script id="tpl-check-list-item" type="text/template">
                <li item-id="%=item-id%" style="list-style: none;"><input style="margin-left: 10px;" type="checkbox" onclick="updateCheckListTask(this);" name="completed-on" id="completed-on" class="completed-on" %=completed-on%> %=mandatory% <span class="item-completed-on"><div class="ctooltip">%=name% <span class="ctooltiptext">%=item-desc%</span></div></span></li>
            </script>
            <script type="text/javascript" src='{sugar_getjspath file="custom/themes/default/js/custom_global.js"}'></script>

            {literal}
                <script>
                    $(document).ready(function () {
                        processDisplayBPIcon();
                    });
                </script>
            {/literal}
            {*END : Business Process CaseGenix*}
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown businessProcessDropdown" id="business-process-data-top-bar"></li>
                <li class="dropdown">
                    <a title="Check Notifications" class="dropdown-toggle label-menu-corner" href="javascript: void(0);" data-toggle="dropdown">
                        <i class="pe-7s-mail green bigger-130" style="margin-top: 9px;"></i>
                        <span class="label label-success">0</span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">You have 0 new message.</div>
                        {*                            <li class="bold">Sceheduled Maintenance will occur on 28/02/2016 starting at 20:00.</li>*}
                        <li class="summary"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <li>
                    <a title="Show Right Sidebar" href="javascript: void(0);" id="rightSidebarToggle" class="right-sidebar-toggle">
                        <i class="pe-7s-news-paper orange bigger-130"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a title="Settings" class="dropdown-toggle label-menu-corner" onclick="javascript: location.href = 'index.php?module=Users&action=EditView&record={$CURRENT_USER_ID}';" href='#' data-toggle="dropdown">
                        <i class="pe-7s-config purple bigger-130"></i>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
                            <li role="presentation">
                                <a id="{$gcl_key}_link" href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a>
                            </li>
                        {/foreach}
                        <li role="presentation"><a role="menuitem" id="logout_link" href='{$LOGOUT_LINK}' class='utilsLink'>{$LOGOUT_LABEL}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="leftSidebar">
        {include file="_leftSidebar.tpl" theme_template=true}
    </div>
    <div class="rightSidebar">
        {include file="_rightSidebar.tpl" theme_template=true}
    </div>
{/if}
{literal}
    <iframe id='ajaxUI-history-iframe' src='index.php?entryPoint=getImage&imageName=blank.png' title='empty' style='display:none'></iframe>
<input id='ajaxUI-history-field' type='hidden'>
<script type='text/javascript'>
    if (SUGAR.ajaxUI && !SUGAR.ajaxUI.hist_loaded) {
        YAHOO.util.History.register('ajaxUILoc', "", SUGAR.ajaxUI.go);
        {/literal}{if $smarty.request.module != "ModuleBuilder"}{* Module builder will init YUI history on its own *}
        YAHOO.util.History.initialize("ajaxUI-history-field", "ajaxUI-history-iframe");
        {/if}{literal}
    }

    $(document).ready(function () {

        $('.generateSchedule').click(function () {
            $.ajax({
                type: "POST",
                url: 'index.php?module=Opturion&action=generate_schedule',
                async: true,
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);

                    alert('Generate Schedule process could not be initialised. Please try again later.');
                },
                success: function (data) {
                    if ($.parseJSON(data) == "1") {
                        alert('Schedule has been initialised successfully!');
                    } else {
                        alert('Generate Schedule process could not be initialised. Please try again later.');
                    }
                }
            });
        });

        $('.viewSchedule').click(function () {
            location.href = 'index.php?module=Opturion';
        });

        $('.acceptSchedule').click(function () {
            $.ajax({
                type: "POST",
                url: 'index.php?module=Opturion&action=accept_schedule',
                async: true,
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);

                    alert('Accept Schedule process could not be initialised. Please try again later.');
                },
                success: function (data) {
                    if ($.parseJSON(data) == "1") {
                        alert('Accept schedule has been initialised successfully!');
                    } else {
                        alert('Accept Schedule process could not be initialised. Please try again later.');
                    }
                }
            });
        });

        var workflowInstanceId = $('#workflowInstanceId').val();
        $('#following').click(function () {
            if (workflowInstanceId != '') {
                //DCMenu.showQELoadingPanel();
                YAHOO.util.Connect.asyncRequest('GET', 'index.php?to_pdf=1&module=Tasks&action=showWorkflow&workflowInstanceId=' + workflowInstanceId, {
                    success: function (o) {
                        window.open(o.responseText, '_blank', 'toolbar=no,location=no,status=no,menubar=no,height=700,width=1300,scrollbars=yes,resizable=yes');
                        return false;
                    }
                });
            }
        });

        var taskWS_id = $('#taskWS_id').val();
        if (taskWS_id == '') {
            taskWS_id = '00000';
        }

        var idTask = $('#idTask').val();
        $('#Defer').click(function () {
            ajaxStatus.showStatus('Defering task');
            YAHOO.util.Connect.asyncRequest('GET', '/crm/index.php?to_pdf=1&module=Tasks&action=defer&activityInstanceId=' + taskWS_id + '&idTask=' + idTask, {
                success: function (o) {
                    if ($.browser.msie) {
                        str = $.trim(o.responseText);
                    } else {
                        str = o.responseText.trim();
                    }

                    if (str == '000') {
                        ajaxStatus.showStatus('Success');

                        $('.businessProcessDropdown').remove();
                    } else {
                        ajaxStatus.showStatus('Failure: The task cannot be updated due to the update failure in CaseGenix.');
                    }

                    window.setTimeout(function () {
                        if (document.getElementById('search_form'))
                            document.getElementById('search_form').submit();
                        else
                            window.location.reload(true);
                    }, 0);
                },
                failure: function (o) {
                    ajaxStatus.showStatus('Ajax request failed');
                    window.setTimeout(function () {
                        window.location.reload(true);
                    }, 300);
                }
            });

        });

        $('.completed_action').click(function () {
            completionOption = $(this).prop('id');
            ajaxStatus.showStatus('Completing task...');
            YAHOO.util.Connect.asyncRequest('GET', '/crm/index.php?module=Tasks&action=completion&completionOption=' + completionOption + '&taskWS_id=' + taskWS_id + '&record_id=' + idTask, {
                success: function (o) {

                    if ($.browser.msie) {
                        str = $.trim(o.responseText);
                    } else {
                        str = o.responseText.trim();
                    }

                    if (str == '000') {
                        ajaxStatus.showStatus('Success');

                        $('.businessProcessDropdown').remove();

                        window.setTimeout(function () {
                            ajaxStatus.hideStatus();
                        }, 400);
                    } else {
                        ajaxStatus.showStatus('Failure: The task cannot be updated due to the update failure in CaseGenix.');
                        window.setTimeout(function () {
                            ajaxStatus.hideStatus();
                        }, 400);
                    }
                    window.setTimeout(function () {
                        if (document.getElementById('search_form'))
                            document.getElementById('search_form').submit();
                        else
                            window.location.reload(true);
                    }, 0);
                },
                failure: function (o) {
                    ajaxStatus.showStatus('Ajax request failed');
                    window.setTimeout(function () {
                        window.location.reload(true);
                    }, 300);
                }
            });
        });

    });
</script>
{/literal}
<!-- Start of page content -->
{if $AUTHENTICATED}
<div id="bootstrap-container"  style="{if $THEME_CONFIG.display_sidebar && $smarty.cookies.leftSidebarToggle != 'collapsed'}margin-left:190px;{/if}" class="main">
    <div id="content">
        <div id="pagecontent">
{/if}