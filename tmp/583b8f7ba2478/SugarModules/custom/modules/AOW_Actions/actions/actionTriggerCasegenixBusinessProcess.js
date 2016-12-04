function change_casegenixValueType(cln, type_value, value){
    if (typeof value === 'undefined') { value = ''; }
    var callback = {
        success: function(result) {
            document.getElementById(cln+'_td').innerHTML = result.responseText;
        },
        failure: function(result) {
            document.getElementById(cln+'_td').innerHTML = '';
        }
    }

    flow_module = document.getElementById('flow_module').value;
    YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOW_WorkFlow&action=getModuleFieldTypeSet&aow_module="+flow_module+"&alt_module="+flow_module+"&aow_fieldname=name&aow_newfieldname="+cln+"&aow_value="+value+"&aow_type="+type_value,callback);
}

function load_cgxcrline(field, cln, type_value, value){
	console.log(cln);
    document.getElementById(field+"_value_type").value = type_value;
    change_casegenixValueType(cln, type_value, value);
}
