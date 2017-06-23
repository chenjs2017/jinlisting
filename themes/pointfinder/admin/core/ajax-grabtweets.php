<?php
/**********************************************************************************************************************************
*
* Ajax Quick Setup Process
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_grabtweets', 'pf_ajax_grabtweets' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_grabtweets', 'pf_ajax_grabtweets' );

function pf_ajax_grabtweets(){
  
	//Security
	check_ajax_referer( 'pfget_grabtweets', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');


	$setuptwitterwidget_conkey = PFTWIssetControl('setuptwitterwidget_conkey','','');
	$setuptwitterwidget_consecret = PFTWIssetControl('setuptwitterwidget_consecret','','');
	$setuptwitterwidget_acckey = PFTWIssetControl('setuptwitterwidget_acckey','','');
	$setuptwitterwidget_accsecret = PFTWIssetControl('setuptwitterwidget_accsecret','','');

	$CONSUMER_KEY = $setuptwitterwidget_conkey;
	$CONSUMER_SECRET = $setuptwitterwidget_consecret;
	$ACCESS_TOKEN = $setuptwitterwidget_acckey;
	$ACCESS_TOKEN_SECRET = $setuptwitterwidget_accsecret;

	if(!empty($CONSUMER_KEY) && !empty($CONSUMER_SECRET) && !empty($ACCESS_TOKEN) && !empty($ACCESS_TOKEN_SECRET)){
		
		//https://github.com/mynetx/codebird-php
		require_once( get_template_directory().'/admin/core/codebird.php');


		//Get authenticated
		\Codebird\Codebird::setConsumerKey($CONSUMER_KEY, $CONSUMER_SECRET); 
		$cb = \Codebird\Codebird::getInstance();
		$cb->setToken($ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);

		//retrieve posts
		$q = $_POST['q'];
		$count = $_POST['count'];
		$api = 'statuses_userTimeline';

	
		$params = array(
			'screen_name' => $q,
			'q' => $q,
			'count' => $count
		);
		$data123 = (array) $cb->$api($params);
		echo json_encode($data123);
	}else{
		echo json_encode(array('httpstatus'=>404));
	}

	
die();
}

?>