/*SE-356   */
SUGAR.util.doWhen(
    function(){
        return $('body').length > 0;
    },
    function() {           
        if(!$('link[href="custom/themes/default/css/dropdownCGX.css"]').length)
            $('body').append('<link rel="stylesheet" type="text/css" href="custom/themes/default/css/dropdownCGX.css">'); 
    }
);     
/*End-356*/