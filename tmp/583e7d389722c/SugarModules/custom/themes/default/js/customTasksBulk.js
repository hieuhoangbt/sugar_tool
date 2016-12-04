$(document).ready(function () {
    // bulk actions request
    $(document).delegate('.actionAssignmentBulk', 'click', function () {
        var that = $(this);
        var parent = that.parents('ul.dropdown-menu').first();
        var userid = parent.data('userid');
        var assignment = that.data('assignment');

        var uids = "";
        $('input[name="mass[]"]:checked').each(function(){
            uids += $(this).val() + ',';
        });
        uids = uids.replace(/(,\s*$)/g, '');
        var taskids = uids;

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
            url: 'index.php?module=Tasks&action=assignmentBulk',
            type: 'POST',
            data: {
                'task_ids': taskids,
                'user_id': userid,
                'operator': assignment
            },
            success: function (data) {
                SUGAR.ajaxUI.hideLoadingPanel();
                window.location.reload();
            },
            error: function (xhr) {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
            }
        });

    });

    $(document).delegate('.actionCompletionBulk', 'click', function () {
        var that = $(this);
        var parent = that.parents('ul.dropdown-menu').first();
        var userid = parent.data('userid');

        var uids = "";
        $('input[name="mass[]"]:checked').each(function(){
            uids += $(this).val() + ',';
        });
        uids = uids.replace(/(,\s*$)/g, '');
        var taskids = uids;

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
            url: 'index.php?module=Tasks&action=completionBulk',
            type: 'POST',
            data: {
                'task_ids': taskids,
                'user_id': userid,
                'completion_option': that.data('completion')
            },
            success: function (data) {
                SUGAR.ajaxUI.hideLoadingPanel();
                window.location.reload();
            },
            error: function (xhr) {
                SUGAR.ajaxUI.hideLoadingPanel();
                SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete completion action');
            }
        });
    });

});

function cgx_callback_user_assign_bulk(data) {
    var name_to_value_array = data.name_to_value_array;
    var assignedUserId = name_to_value_array.assigned_user_id;
    var userid = data.passthru_data.current_user_id;

    var uids = "";
    $('input[name="mass[]"]:checked').each(function(){
        uids += $(this).val() + ',';
    });
    uids = uids.replace(/(,\s*$)/g, '');
    var taskids = uids;

    var params = {
        'taskids': taskids,
        'assignedUserId': assignedUserId,
    };

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
        url: 'index.php?module=Tasks&action=userAssignBulk',
        type: 'POST',
        data: {
            'task_ids': params.taskids,
            'assigned_user_id': params.assignedUserId
        },
        success: function (data) {
            SUGAR.ajaxUI.hideLoadingPanel();
            window.location.reload();
        },
        error: function (xhr) {
            SUGAR.ajaxUI.hideLoadingPanel();
            SUGAR.ajaxUI.showErrorMessage('Fail: Unable to complete assignment action');
        }
    });
}

function cgx_bulk_open_popup() {
    if(typeof win != 'undefined'){
        win.close();
    };

    var uids = [];
    $('input[name="mass[]"]:checked').each(function(){
        uids.push($(this).val());
    });

    var data = {
        'call_back_function': 'cgx_callback_user_assign_bulk',
        'field_to_name_array': {
            'id':'assigned_user_id',
            'user_name':'assigned_user_name'
        },
        'passthru_data': {}
    };

    open_popup( 'Users', 600, 400, '&genix_custom=1&bulk_actions=1&uids=' + JSON.stringify(uids), true, false, data, 'single',true, false);
}