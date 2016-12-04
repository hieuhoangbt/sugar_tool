$(document).ready(function () {
    $('#business-process-data-top-bar').delegate('.actionDeferTop', 'click', function () {
        var that = $(this);
        var taskid = that.data('taskid');
        var activityid = that.data('activityid');
        var userid = that.data('userid');

        // loading
        SUGAR.ajaxUI.showLoadingPanel();

        $.ajax({
            url: 'index.php?module=Tasks&action=defer',
            type: 'POST',
            data: {
                'task_id': taskid,
                'activity_id': activityid,
                'user_id': userid,
            },
            success: function (data) {
                if (data == 1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    window.location.reload();
                } else {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
                }
            },
            error: function (xhr) {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
            }
        });

    });

    $('#business-process-data-top-bar').delegate('.actionCompletionTop', 'click', function () {
        var that = $(this);
        var taskid = that.data('taskid');
        var activityid = that.data('activityid');
        var userid = that.data('userid');
        var completion = that.data('completion');

        // loading
        SUGAR.ajaxUI.showLoadingPanel();

        $.ajax({
            url: 'index.php?module=Tasks&action=completion',
            type: 'POST',
            data: {
                'task_id': taskid,
                'activity_id': activityid,
                'user_id': userid,
                'completion_option': completion
            },
            success: function (data) {
                SUGAR.ajaxUI.errorPanel = new YAHOO.widget.Panel("ajaxUIErrorPanel", {
                    modal: false,
                    visible: true,
                    constraintoviewport: true,
                    width: "700px",
                    height: "200px",
                    close: true
                });
                if (data == 1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    window.location.reload();
                }
                else if(data == -1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage(SUGAR.language.get('Tasks', 'LBL_MSG_CAN_NOT_BE_COMPLETE_TASK'));
                }
                else {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete completion action');
                }
            },
            error: function (xhr) {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete completion action');
            }
        });
    });
    displayDescription();
});
/*
    This function using to display description of checklist when mouseover in check list name
 */
function displayDescription() {
    $('.item-name').tooltip();
}

function processDisplayBPIcon(flg) {
    // clear HTML
    $("#business-process-data-top-bar").html("");

    $.ajax({
        url: "index.php?module=Tasks&action=requestBusiness",
        type: "GET",
        success: function(data){
            try{
                data = JSON.parse(data);

                if (data.activityID) {
                    var template = $("#tpl-business-process-data-top-bar").html();

                    var completionOptions = "";
                    if (data.completionOptions && Array.isArray(data.completionOptions)) {
                        data.completionOptions.forEach(function(item){
                            var sub_tpl = $("#tpl-completion-option-business-process").html();

                            // Replace
                            sub_tpl = sub_tpl.replace(/%=completion%/g, item);
                            if(data.checkListItemsCompleted == 0) {
                                sub_tpl = sub_tpl.replace(/%=style-disabled%/g, "pointer-events:none; opacity:0.4;");
                            }
                            else {
                                sub_tpl = sub_tpl.replace(/%=style-disabled%/g, "");
                            }
                            completionOptions += sub_tpl;
                        });
                    }
                    if (completionOptions) completionOptions += '<li role="separator" class="divider"></li>';

                    // Set data for check list items
                    var checkListItems = "";
                    if(data.checkListItems && Array.isArray(data.checkListItems)) {
                        checkListItems = "<li><b>" + SUGAR.language.get('app_strings', 'LBL_CHECK_LIST_ITEMS') + "</b>";
                        data.checkListItems.forEach(function(item){
                            var item_tpl = $("#tpl-check-list-item").html();

                            // Replace
                            item_tpl = item_tpl.replace(/%=item-id%/g, item.id);
                            item_tpl = item_tpl.replace(/%=completed-on%/g, (item.completed_on == 1) ? "checked" : "");
                            item_tpl = item_tpl.replace(/%=mandatory%/g, (item.mandatory == 1) ? "<span class='required'>*</span>" : "<span style='margin-left: 8px;'></span>");
                            item_tpl = item_tpl.replace(/%=name%/g, item.name);
                            item_tpl = item_tpl.replace(/%=item-desc%/g, item.description);

                            checkListItems += item_tpl;// + '<li role="separator" class="divider"></li>';
                        });
                        checkListItems += "</li>";
                    }

                    // Replace template
                    template = template.replace(/%=completionOptions%/g, completionOptions); // MUST First
                    template = template.replace(/%=linkToTask%/g, data.linkToTask);
                    template = template.replace(/%=Name%/g, data.startedTask.name);
                    template = template.replace(/%=relateToUrl%/g, data.relateToUrl);
                    template = template.replace(/%=parentName%/g, data.parentName);
                    template = template.replace(/%=businessProcessName%/g, data.businessProcessName);
                    template = template.replace(/%=urlBusinessProcess%/g, data.urlBusinessProcess);
                    template = template.replace(/%=assigned_user_id%/g, data.startedTask.assigned_user_id);
                    template = template.replace(/%=activityID%/g, data.activityID);
                    template = template.replace(/%=taskid%/g, data.startedTask.id);
                    template = template.replace(/%=checkListItems%/g, checkListItems);

                    $("#business-process-data-top-bar").html(template);
                    if(flg){
                        $("#autoClickMe").click();
                    }
                }

            } catch (err) {
                console.log(err);
            }
        },
        error: function(xhr){
            SUGAR.ajaxUI.hideLoadingPanel();
        }
    });
}

function updateCheckListTask(el) {
    $("#autoClickMe").click();
    if (!SUGAR.ajaxUI.loadingPanel)
    {
        SUGAR.ajaxUI.loadingPanel = new YAHOO.widget.Panel("ajaxloading",
            {
                width:"240px",
                fixedcenter:true,
                close:false,
                draggable:false,
                constraintoviewport:false,
                modal:true,
                visible:false
            });
        SUGAR.ajaxUI.loadingPanel.setBody('<div id="loadingPage" align="center" style="vertical-align:middle;"><img src="' + SUGAR.themes.loading_image + '" align="absmiddle" /> <b>' + SUGAR.language.get('app_strings', 'LBL_LOADING_PAGE') +'</b></div>');
        SUGAR.ajaxUI.loadingPanel.render(document.body);
    }
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
    SUGAR.ajaxUI.showLoadingPanel();
    $.ajax({
        url: "index.php?module=Tasks&action=updateCheckListItem&sugar_body_only=1",
        type: "POST",
        data: {
            "item_id": $(el).closest('li').attr('item-id'),
            "mandatory": ($(el).closest('li').find('#completed-on').is(':checked')) ? 1: 0
        },
        success: function(updated){
            if(updated) {
                var checklistUpdated = true;
                processDisplayBPIcon(checklistUpdated);
                SUGAR.ajaxUI.hideLoadingPanel();
            }
            else {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Undentify Check list Item ID');
            }
            $('#business-process-data-top-bar').find('.dropdown-menu').show();
        },
        error: function(xhr){
            SUGAR.ajaxUI.hideLoadingPanel();
            SUGAR.ajaxUI.showErrorMessage('Fail: Can not update check list item');
        }
    });
}
