<?php
/**********************************************************************************************************************************
*
* Custom AJAX Handler for faster load.
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
define('DOING_AJAX', true);
if (!isset( $_POST['action'])){
    if ( !isset($_GET['action'])) {
        die('Not supported.');
    };
};
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
header('Content-Type: text/html');
send_nosniff_header();
header('Cache-Control: no-cache');
header('Pragma: no-cache');
if(!empty($_POST['action'])){
    $action = esc_attr(trim($_POST['action']));
}
if (empty($action)) {
   $action = esc_attr(trim($_GET['action']));
}
$allowed_actions = array(
    'pfget_onoffsystem',
    'pfget_nagsystem',
    'pfget_infowindow',
    'pfget_markers',
    'pfget_taxpoint',
    'pfget_listitems',
    'pfget_usersystem',
    'pfget_modalsystem',
    'pfget_usersystemhandler',
    'pfget_modalsystemhandler',
    'pfget_favorites',
    'pfget_reportitem',
    'pfget_flagreview',
    'pfget_paymentsystem',
    'pfget_quicksetupprocess',
    'pfget_grabtweets',
    'pfget_autocomplete',
    'pfget_createorder',
    'pfget_claimitem',
    'pfget_searchitems',
    'pfget_imageupload',
    'pfget_imagesystem',
    'pfget_featuresystem',
    'pfget_fieldsystem',
    'pfget_membershipsystem',
    'pfget_membershippaymentsystem',
    'pfget_itemsystem',
    'pfget_listingtype',
    'pfget_listingtypelimits',
    'pfget_posttag',
    'pfget_fileupload',
    'pfget_filesystem',
    'pfget_authorchangesystem',
    'pfget_listingpaymentsystem',
    'pfget_featuresfilter',
);

if(in_array($action, $allowed_actions)){
    if(is_user_logged_in()){
        do_action('PF_AJAX_HANDLER_'.$action);
    }else{
        do_action('PF_AJAX_HANDLER_nopriv_'.$action);
    }
}else{
	die('-2');
} 
?>