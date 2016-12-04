$(document).ready(function () {
    /**
     * Comment
     */

    $('body').delegate('.actionAssignment', 'click', function () {
        var that = $(this);
        var parent = that.parents('ul.dropdown-menu').first();
        var taskid = parent.data('taskid');
        var activityid = parent.data('activityid');
        var userid = parent.data('userid');
        var assignment = that.data('assignment');
        var parentType = parent.data('parenttype');
        var parentID = parent.data('parentid');
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
            url: 'index.php?module=Tasks&action=assignment',
            type: 'POST',
            data: {
                'task_id': taskid,
                'activity_id': activityid,
                'user_id': userid,
                'operator': assignment
            },
            success: function (data) {
                if (data != 1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
                }
                //Begin SE-333
                if (!Number(data)) {
                    alert("ERROR: \n".SUGAR.language.get('app_strings', 'LBL_ERROR_MESSMAGE_CALL_API_UA'));
                } else {    //End SE-333
                    if (assignment == 'FF') {
                        window.open("index.php?module=" + parentType + "&action=DetailView&record=" + parentID, "_blank");
                        SUGAR.ajaxUI.hideLoadingPanel();
                        window.location.reload();
                    } else {
                        SUGAR.ajaxUI.hideLoadingPanel();
                        window.location.reload();
                    }
                }
            },
            error: function (xhr) {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
                //Begin SE-333
                if (!Number(0)) {
                    alert("ERROR: \n".SUGAR.language.get('app_strings', 'LBL_ERROR_MESSMAGE_CALL_API_UA'));
                } //End SE-333
            }
        });
    });

    $('body').delegate('.actionFastForward', 'click', function () {
        var that = $(this);
        var taskid = that.data('taskid');
        var activityid = that.data('activityid');
        var userid = that.data('userid');
        var assignment = that.data('assignment');
        var parentType = that.data('parenttype');
        var parentID = that.data('parentid');
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
            url: 'index.php?module=Tasks&action=assignment',
            type: 'POST',
            data: {
                'task_id': taskid,
                'activity_id': activityid,
                'user_id': userid,
                'operator': assignment
            },
            success: function (data) {
                console.log(data);
                if (data != 1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
                }
                //Begin SE-333
                if (!Number(data)) {
                    alert("ERROR: \n".SUGAR.language.get('app_strings', 'LBL_ERROR_MESSMAGE_CALL_API_UA'));
                } else {    //End SE-333
                    window.open("index.php?module=" + parentType + "&action=DetailView&record=" + parentID, "_blank");
                    SUGAR.ajaxUI.hideLoadingPanel();
                    window.location.reload();
                }
            },
            error: function (xhr) {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
                //Begin SE-333
                if (!Number(0)) {
                    alert("ERROR: \n".SUGAR.language.get('app_strings', 'LBL_ERROR_MESSMAGE_CALL_API_UA'));
                } //End SE-333
            }
        });
    });

    $('body').delegate('.actionDefer', 'click', function () {
        var that = $(this);
        var taskid = that.data('taskid');
        var activityid = that.data('activityid');
        var userid = that.data('userid');
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

    $('body').delegate('.actionCompletion', 'click', function () {
        var that = $(this);
        var parent = that.parents('ul.dropdown-menu').first();
        var taskid = parent.data('taskid');
        var activityid = parent.data('activityid');
        var userid = parent.data('userid');
        SUGAR.ajaxUI.showLoadingPanel();
        if (!SUGAR.ajaxUI.errorPanel) {
            SUGAR.ajaxUI.errorPanel = new YAHOO.widget.Panel("ajaxUIErrorPanel", {
                modal: false,
                visible: true,
                constraintoviewport: true,
                width: "700px",
                height: "200px",
                close: true
            });
        }
        $.ajax({
            url: 'index.php?module=Tasks&action=completion',
            type: 'POST',
            data: {
                'task_id': taskid,
                'activity_id': activityid,
                'user_id': userid,
                'completion_option': that.data('completion')
            },
            success: function (data) {
                if (data == 1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    window.location.reload();
                } else if (data == -1) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage(SUGAR.language.get('Tasks', 'LBL_MSG_CAN_NOT_BE_COMPLETE_TASK'));
                } else {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete completion action');
                }
            },
            error: function (xhr) {
                alert('aba');
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete completion action');
            }
        });
    });
});

/**
 * 
 * @param {type} data
 * @returns {undefined}
 */
function set_return_cgx_user_assign(data) {
    from_popup_return = true;
    var name_to_value_array = data.name_to_value_array;
    var assignedUserId = name_to_value_array.assigned_user_id;
    var activityId = data.passthru_data.activity_id;
    var taskid = data.passthru_data.task_id;
    var userid = data.passthru_data.current_user_id;
    var params = {
        'taskid': taskid,
        'userid': userid,
        'activityId': activityId,
        'assignedUserId': assignedUserId,
    };
    doAjaxLoad(params);
}

/**
 * Comment
 */
function doAjaxLoad(params) {
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
        url: 'index.php?module=Tasks&action=userAssign',
        type: 'POST',
        data: {
            'task_id': params.taskid,
            'activity_id': params.activityId,
            'user_id': params.userid,
            'assigned_user_id': params.assignedUserId
        },
        success: function (data) {
            if (data == 1) {
                SUGAR.ajaxUI.hideLoadingPanel();
                window.location.reload();
            } else {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
                //Begin SE-333
                if (!Number(data)) {
                    alert("ERROR: \n".SUGAR.language.get('app_strings', 'LBL_ERROR_MESSMAGE_CALL_API_UA'));
                } //End SE-333
            }
        },
        error: function (xhr) {
            SUGAR.ajaxUI.hideLoadingPanel();
            SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
            //Begin SE-333
            if (!Number(0)) {
                alert("ERROR: \n".SUGAR.language.get('app_strings', 'LBL_ERROR_MESSMAGE_CALL_API_UA'));
            } //End SE-333
        }
    });
}
