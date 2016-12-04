//SE-332
function checkCGXFieldsChange() {
    var cgxFields = [
        'name',
        'status',
        'parent_type',
        'parent_id'
    ];
    if(Number($('input[name=cgx_check]').val())) {
        var isAlerts = false;
        for($i = 0; $i < cgxFields.length; $i++) {
            var new_val = $("[name='"+cgxFields[$i] +"']").val();
            var old_val = $("[name='old_"+cgxFields[$i] +"']").val();
            if(new_val != old_val) {
                mms = "WARNING: \n" + SUGAR.language.get("Tasks", 'LBL_WARNING_UPDATE');
                alert(mms);
                return false;                   
            }
        }
        return true;
    }
}

function check_form(formname) {
    if (typeof (siw) != 'undefined' && siw && typeof (siw.selectingSomething) != 'undefined' && siw.selectingSomething)
        return false;
    return checkCGXFieldsChange() & validate_form(formname, '');
}
//end SE332