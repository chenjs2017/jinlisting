<?php
/**********************************************************************************************************************************
*
* Item Report System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_flagreview', 'pf_ajax_flagreview' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_flagreview', 'pf_ajax_flagreview' );

function pf_ajax_flagreview(){
  
	//Security
	check_ajax_referer( 'pfget_flagreview', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

	$reported_item = '';

	$results = array();

	if(isset($_POST['item']) && $_POST['item']!=''){
		$reported_item = esc_attr($_POST['item']);
	}
	
	$results['item'] = $reported_item;

	if (is_user_logged_in()) {
		$cur_user = get_current_user_id();
		$results['user'] = $cur_user;
		


	}else{
		$results['user'] = 0;
	}


	echo json_encode($results);
die();
}

?>