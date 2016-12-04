(function($){
    if(SUGAR.themes.theme_name == "SuiteP"){
        $("#tab-actions .dropdown-menu").first().addClass("subnav");
    }
   
    $.fn.addActionMenuCus = function($cusCode) {
    return this.each(function() {
       $(this).append($($cusCode));
    });
};
})(jQuery);