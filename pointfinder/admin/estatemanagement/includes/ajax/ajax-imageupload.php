<?php
/**********************************************************************************************************************************
*
* Ajax Image Upload
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_imageupload', 'pf_ajax_imageupload' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_imageupload', 'pf_ajax_imageupload' );

function pf_ajax_imageupload(){
  
	//Security
	check_ajax_referer( 'pfget_imageupload', 'security');
  
  	if(isset($_POST['oldup']) && $_POST['oldup']!=''){
		$oldup = esc_attr($_POST['oldup']);
	}else{
		$oldup = 0;
	}

	if ($oldup == 1) {
		header('Content-Type: text/html;charset=UTF-8;');
	}else{
		header('Content-Type: application/json;charset=UTF-8;');
	}
	
	$iid = $newupload = $id = '';
	$output = array();

	if(isset($_POST['iid']) && $_POST['iid']!=''){
		$iid = esc_attr($_POST['iid']);
	}

	if(isset($_POST['id']) && $_POST['id']!=''){
		$id = esc_attr($_POST['id']);
	}

	if(isset($_POST['exid']) && $_POST['exid']!=''){
		$exid = esc_attr($_POST['exid']);
	}

	if (!empty($exid)) {
		if (strpos($exid, ",")) {
			$exarray = pfstring2BasicArray($exid);
			if (is_array($exarray)) {
				foreach ($exarray as $exarrayval) {
					$result = delete_post_meta( $exarrayval, 'pointfinder_delete_unused', '1', true);
					if ($result) {
						wp_delete_attachment( $exarrayval, true );
						$output['process'] = 'del';
						$output['id'] = $exarrayval;
					}
				}
			}
		}else{
			$result = delete_post_meta( $exid, 'pointfinder_delete_unused', '1', true);
			if ($result) {
				wp_delete_attachment( $exid, true );
				$output['process'] = 'del';
				$output['id'] = $exid;
			}
		}
		echo json_encode($output);
		die();
	}


	/*Image Remove Process*/
	if (!empty($iid)) {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;
		
		if (get_current_user_id() == $post_author) {
			if (!empty($id)) {
				delete_post_meta( $id, 'webbupointfinder_item_images', $iid );
			}
			wp_delete_attachment( $iid, true );
			
			$output['process'] = 'del';
			$output['id'] = $iid;
			echo json_encode($output);
			
		}
		die();
	};


	/* Upload Images */	
	$allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

	foreach ($_FILES as $key => $array) {
		
		if ( isset($_FILES[$key])) {   
			if ( $_FILES[$key]['error'] <= 0) {      
			    if(in_array($_FILES[$key]['type'], $allowed_file_types)) {
			    	if (!empty($id)) {
			    		$newupload = pft_insert_attachment($key);
			      		add_post_meta($id, 'webbupointfinder_item_images', $newupload);
			    	}else{
			    		$newupload = pft_insert_attachment($key);
			      		add_post_meta( $newupload, 'pointfinder_delete_unused', '1', true);
			    	}
			      
			      $output['process'] = 'up';
			      $output['id'] = $newupload;
			      echo json_encode($output);
			      die();
				}
			}
		}
		
	}


}

?>