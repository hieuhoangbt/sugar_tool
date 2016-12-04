<!DOCTYPE html>
<html {$langHeader}>
<head>
    <link rel="SHORTCUT ICON" href="{$FAVICON_URL}">
    <meta http-equiv="Content-Type" content="text/html; charset={$APP.LBL_CHARSET}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <!-- Bootstrap -->
    <link href="themes/SuiteCGX/css/bootstrap.min.css" rel="stylesheet">
    <link href="themes/SuiteCGX/css/footable.core.css" rel="stylesheet" type="text/css" />
    
    <link href="themes/SuiteCGX/css/fonts.css" rel="stylesheet" type="text/css" />

    <link href="themes/SuiteCGX/fonts/fontawesome/css/fontawesome.css" rel="stylesheet" type="text/css" />

    <link href="themes/SuiteCGX/fonts/pe-icon-7-stroke/css/helper.css" rel="stylesheet" type="text/css" />
    <link href="themes/SuiteCGX/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />
    <!-- Tooltip for BP Icon CGX Conntector V3-->
    <link href="custom/themes/default/css/custom_tooltip.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->
    <title>{$APP.LBL_BROWSER_TITLE}</title>
    {$SUGAR_JS}
    {literal}
    <script type="text/javascript">
        <!--
        SUGAR.themes.theme_name      = '{/literal}{$THEME}{literal}';
        SUGAR.themes.theme_ie6compat = '{/literal}{$THEME_IE6COMPAT}{literal}';
        SUGAR.themes.hide_image      = '{/literal}{sugar_getimagepath file="hide.gif"}{literal}';
        SUGAR.themes.show_image      = '{/literal}{sugar_getimagepath file="show.gif"}{literal}';
        SUGAR.themes.loading_image   = '{/literal}{sugar_getimagepath file="img_loading.gif"}{literal}';
        SUGAR.themes.allThemes       = eval({/literal}{$allThemes}{literal});
        if ( YAHOO.env.ua )
            UA = YAHOO.env.ua;
        -->
    </script>
    {/literal}
    {$SUGAR_CSS}
    <link rel="stylesheet" type="text/css" href="themes/SuiteCGX/css/colourSelector.php">
    <link rel="stylesheet" type="text/css" href="custom/themes/default/css/customCGX.css">
    <script type="text/javascript" src='{sugar_getjspath file="themes/SuiteCGX/js/jscolor.js"}'></script>
    <script type="text/javascript" src='{sugar_getjspath file="cache/include/javascript/sugar_field_grp.js"}'></script>
</head>