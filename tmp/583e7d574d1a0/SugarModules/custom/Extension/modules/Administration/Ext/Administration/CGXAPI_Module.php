<?php

// initialize a temp array that will hold the options we want to create
$links = array();
// add button1 to $links
$links['CGX_API']['api_settings'] = array(
    // pick an image from /themes/Sugar5/images
    // and drop the file extension
    'CGX_API',
    // title of the link
    'LBL_CGXAPI_MODULE_TITLE',
    // description for the link
    'LBL_CGXAPI_MODULE_DESCRIPTION',
    // where to send the user when the link is clicked
    './index.php?module=CGX_API&action=Settings',
);
// add our new admin section to the main admin_group_header array
$admin_group_header [] = array(
    // The title for the group of links
    'LBL_CGXAPI_OPTIONS',
    // leave empty, it's used for something in /include/utils/layout_utils.php
    // in the get_module_title() function
    '',
    // set to false, it's used for something in /include/utils/layout_utils.php
    // in the get_module_title() function
    false,
    // the array of links that you created above
    // to be placed in this section
    $links,
    // a description for what this section is about
    'LBL_CGXAPI_OPTIONS_DESCRIPTION'
);
