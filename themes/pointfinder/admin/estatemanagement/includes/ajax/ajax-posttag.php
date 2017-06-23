<?php

/**********************************************************************************************************************************
*
* Ajax Post Tags
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

add_action( 'PF_AJAX_HANDLER_pfget_posttag', 'pf_ajax_posttag' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_posttag', 'pf_ajax_posttag' );
	
	
function pf_ajax_posttag(){
	
	check_ajax_referer( 'pfget_posttag', 'security' );
	header('Content-Type: text/html; charset=UTF-8;');

	$id = $lang = '';

	if (is_user_logged_in()) {
		
		if(isset($_POST['id']) && $_POST['id']!=''){
			$id = sanitize_text_field($_POST['id']);
		}

		if (!empty($id)) {
			
			if(isset($_POST['pid']) && $_POST['pid']!=''){
				$pid = sanitize_text_field($_POST['pid']);
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

			$user_id = get_current_user_id();

			/*Check if item user s item*/
            global $wpdb;

            $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

            $result = $wpdb->get_results( $wpdb->prepare( 
              "SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
              $pid,
              $user_id,
              $setup3_pointposttype_pt1
            ) );
            
            if (is_array($result) && count($result)>0) {  
              if ($result[0]->ID == $pid) {
              	$result = wp_remove_object_terms( (int)$pid, (int)$id, 'post_tag');
              	if ($result) {
              		echo 1;
              	}
              }
          	}

		}
		

	}

	
	
	die();
}

?>