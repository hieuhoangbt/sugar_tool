
(function($){
    'use strict';

    var button_save = $('#SAVE_HEADER').attr('onclick');

    $("body").append("<script type='text/javascript'>" +
        "function checkValidate() {" +
        "var fr = $('#unavailable_date_from_c_date').val()? $('#unavailable_date_from_c_date').val(): 0;" +
        "var to = $('#unavailable_date_to_c_date').val()?$('#unavailable_date_to_c_date').val() : 0;" +
        "if(fr)" +
        "fr = parseDateCus(fr).getTime();" +
        "if(to)" +
        "to = parseDateCus(to).getTime();" +
        "if(fr != 0 && to !=0){" +
        "if(fr > to){" +
        "alert('Unavailable From Date cannot be after Unavailable To Date');" +
        "$('#unavailable_date_to_c_date').focus();" +
        "return false;" +
        "}return true;}return true;}" +
        "function parseDateCus(str) {" +
        "var mdy = str.split('/');" +
        "return new Date(mdy[2], mdy[0], mdy[1]);" +
        "} </script>");

    var custom_js = "if(!checkValidate())return false;"+button_save;

    $('#SAVE_HEADER').attr('onclick', custom_js);
    $('#SAVE_FOOTER').attr('onclick', custom_js);

})(jQuery);