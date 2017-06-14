<?php

/**********************************************************************************************************************************
*
* Ajax Listing Type Limits
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

add_action( 'PF_AJAX_HANDLER_pfget_listingtypelimits', 'pf_ajax_listingtypelimits' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_listingtypelimits', 'pf_ajax_listingtypelimits' );
	
	
function pf_ajax_listingtypelimits(){
	
	check_ajax_referer( 'pfget_listingtypelimits', 'security' );
	header('Content-Type: application/json; charset=UTF-8;');

	$id = $lang = '';

	if(isset($_POST['id']) && $_POST['id']!=''){
		$id = sanitize_text_field($_POST['id']);
	}

	if(isset($_POST['limit']) && $_POST['limit']!=''){
		$limit = $_POST['limit'];
		$limit = PFCleanArrayAttr('PFCleanFilters',$limit);
	}


	if(isset($_POST['lang']) && $_POST['lang']!=''){
		$lang = sanitize_text_field($_POST['lang']);
	}

	/* WPML Fix */
	if(function_exists('icl_t')) {
		if (!empty($lang)) {
			do_action( 'wpml_switch_language', $lang );
		}
	}
	
	$listing_meta = get_option('pointfinderltypes_fevars');

	$this_limit_check = array();

	if (!empty($id)) {
	 	if (isset($listing_meta[$id]) && is_array($limit)) {
			foreach ($limit as $key => $value) {
				$this_limit_check[$value] = (isset($listing_meta[$id][$value]))? $listing_meta[$id][$value]:'';
			}
			echo json_encode($this_limit_check);
		}else{
			foreach ($limit as $key => $value) {
				$this_limit_check[$value] = '';
			}
			echo json_encode($this_limit_check);
		}
	}

	die();
}

?>