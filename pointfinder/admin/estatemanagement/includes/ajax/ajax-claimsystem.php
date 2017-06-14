<?php
/**********************************************************************************************************************************
*
* Item Claim System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_claimitem', 'pf_ajax_claimitem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_claimitem', 'pf_ajax_claimitem' );

function pf_ajax_claimitem(){
  
	//Security
	check_ajax_referer( 'pfget_claimitem', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

	$claimed_item = '';

	$results = array();

	if(isset($_POST['item']) && $_POST['item']!=''){
		$claimed_item = esc_attr($_POST['item']);
	}
	
	$results['item'] = $claimed_item;
	$setup42_itempagedetails_claim_regstatus = PFSAIssetControl('setup42_itempagedetails_claim_regstatus','','1');
	$results['rs'] = $setup42_itempagedetails_claim_regstatus;

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