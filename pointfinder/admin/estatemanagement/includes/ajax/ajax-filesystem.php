<?php
/**********************************************************************************************************************************
*
* Ajax File System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_filesystem', 'pf_ajax_filesystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_filesystem', 'pf_ajax_filesystem' );

function pf_ajax_filesystem(){
  
	//Security
	check_ajax_referer( 'pfget_filesystem', 'security');
  
	header('Content-Type: text/html; charset=UTF-8;');

	$iid = '';
	$output = '';

	if(isset($_POST['iid']) && $_POST['iid']!=''){
		$iid = sanitize_text_field($_POST['iid']);
	}

	if(isset($_POST['id']) && $_POST['id']!=''){
		$id = sanitize_text_field($_POST['id']);
	}

	if(isset($_POST['process']) && $_POST['process']!=''){
		$process = sanitize_text_field($_POST['process']);
	}


	/*Image Remove Process*/
	if (!empty($iid) && !empty($id) && $process == 'd') {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;
		
		if (get_current_user_id() == $post_author) {
			wp_delete_attachment( $iid, true );
			delete_post_meta( $id, 'webbupointfinder_item_files', $iid );
		}
		
	};

	/*Image Change Process*/
	if (!empty($iid) && !empty($id) && $process == 'c') {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;

		if (get_current_user_id() == $post_author) {
			$imageID_of_featured = get_post_thumbnail_id($id);
			add_post_meta($id, 'webbupointfinder_item_files', $imageID_of_featured);
			delete_post_meta( $id, 'webbupointfinder_item_files', $iid );
			set_post_thumbnail( $id, $iid );
		}
	}


	/*Image List Process*/
	if (!empty($id) && $process == 'l') {
		$content_post = get_post($id);
		$post_author = $content_post->post_author;
		
		if (get_current_user_id() == $post_author) {

			/*Create HTML*/
			if ($id != '') {
				$files_of_thispost = get_post_meta($id,'webbupointfinder_item_files');
				

				if (PFControlEmptyArr($files_of_thispost)) {
					$files_count = count($files_of_thispost);
					$output_files = '';
					$i = 1;
					foreach ($files_of_thispost as $file_number) {
						$file_src_link = wp_get_attachment_url($file_number);//sprintf(esc_html__('Uploaded File (%d)','pointfindert2d'),$i)
						$file_src = get_attached_file($file_number);
						$output_files .= '<li>';
						$output_files .= '<div class="pf-itemfile-container">';
						$output_files .= '<i class="pfadmicon-glyph-33"></i> <a href="'.$file_src_link.'" target="_blank">'.basename($file_src).'</a>';
						$output_files .= '<div class="pf-itemfile-delete"><a class="pf-delete-standartfile" data-pffileno="'.$file_number.'" data-pfpid="'.$id.'" data-pffeatured="no"><i class="pfadmicon-glyph-644"></i></a></div>';
						$output_files .= '</div>';
						$output_files .= '</li>';
						$i++;
					}
					$output .= '<section class="pfuploadform-mainsec">';
						$output .= '<label for="file" class="lbl-text">'.esc_html__('UPLOADED FILES','pointfindert2d').':</label>';
						$output .= '<ul class="pffiles-ul">'.$output_files.'</ul>';
					$output .= '</section>';
					
					echo $output;
				}
			}
		}
	}

	die();
}

?>