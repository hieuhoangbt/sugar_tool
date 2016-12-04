//SE-356
SUGAR.util.doWhen(
    function(){
        return ($('body').length > 0) && ((typeof SUGAR['themes']['theme_name']).toLowerCase() == 'string');
    },
    function() {
        if(SUGAR['themes']['theme_name'] == 'SuiteP' && !$('link[href="custom/themes/SuiteP/css/customCGXStyle.css"]').length )
            $('body').append('<link rel="stylesheet" type="text/css" href="custom/themes/SuiteP/css/customCGXStyle.css">');
    }
);   

//End-356