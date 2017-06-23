<?php
/**********************************************************************************************************************************
*
* Ajax Notification System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_nagsystem', 'pf_ajax_nagsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_nagsystem', 'pf_ajax_nagsystem' );

function pf_ajax_nagsystem(){
  	check_ajax_referer( 'pfget_nagsystem', 'security');
	header('Content-Type: application/json; charset=UTF-8;');

	$ntype = $nstatus = $result = '';

	if(isset($_POST['ntype']) && $_POST['ntype']!=''){
		$ntype = esc_attr($_POST['ntype']);
	}

	if(isset($_POST['nstatus']) && $_POST['nstatus']!=''){
		$nstatus = esc_attr($_POST['nstatus']);
	}


	global $current_user;
    $user_id = $current_user->ID;

    if (!empty($user_id)) {

	    switch ($ntype) {
	    	case 'install':
	    		if ($nstatus == 0) {
	    			update_user_meta($user_id, 'pointfinder_afterinstall_admin_notice', true);
	    			$result = 1;
	    		}else{
	    			delete_user_meta($user_id, 'pointfinder_afterinstall_admin_notice');
	    			$result = 1;
	    		}
	    	case 'install2':
	    		if ($nstatus == 0) {
	    			update_user_meta($user_id, 'pointfinder_afterinstall_admin_notice2', true);
	    			$result = 1;
	    		}else{
	    			delete_user_meta($user_id, 'pointfinder_afterinstall_admin_notice2');
	    			$result = 1;
	    		}
    		break;
	    }

    }

	echo json_encode($result);
die();
}

?>