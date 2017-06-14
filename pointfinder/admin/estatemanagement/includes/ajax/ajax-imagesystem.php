<?php
/**********************************************************************************************************************************
*
* Ajax Image System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_imagesystem', 'pf_ajax_imagesystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_imagesystem', 'pf_ajax_imagesystem' );

function pf_ajax_imagesystem(){
  
	//Security
	check_ajax_referer( 'pfget_imagesystem', 'security');
  
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

	$oldup = $olduptext = '';
	if(isset($_POST['oldup']) && $_POST['oldup']!=''){
		$oldup = sanitize_text_field($_POST['oldup']);
	}

	if ($oldup == 1) {
		$olduptext = '-old';
	}


	/*Image Remove Process*/
	if (!empty($iid) && !empty($id) && $process == 'd') {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;
		
		if (get_current_user_id() == $post_author) {
			wp_delete_attachment( $iid, true );
			delete_post_meta( $id, 'webbupointfinder_item_images', $iid );
		}
		
	};

	/*Image Change Process*/
	if (!empty($iid) && !empty($id) && $process == 'c') {
		/*Check this image if this user uploaded*/
		$content_post = get_post($iid);
		$post_author = $content_post->post_author;

		if (get_current_user_id() == $post_author) {
			$imageID_of_featured = get_post_thumbnail_id($id);
			add_post_meta($id, 'webbupointfinder_item_images', $imageID_of_featured);
			delete_post_meta( $id, 'webbupointfinder_item_images', $iid );
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
				$images_of_thispost = get_post_meta($id,'webbupointfinder_item_images');
				/*Featured Image*/
				$imageID_of_featured = get_post_thumbnail_id($id);

				if (PFControlEmptyArr($images_of_thispost) || !empty($imageID_of_featured)) {
					$images_count = count($images_of_thispost) + 1;
					$output_images = '';

					/*Start:First export featured*/
					$image_src = wp_get_attachment_image_src( $imageID_of_featured, 'thumbnail' );
					$output_images .= '<li>';
					$output_images .= '<div class="pf-itemimage-container">';
					$output_images .= '<img src="'.aq_resize($image_src[0],90,90,true).'">';
					$output_images .= '<div class="pf-itemimage-delete"><a class="pf-delete-standartimg'.$olduptext.'" data-pfimgno="'.$imageID_of_featured.'" data-pfpid="'.$id.'" data-pffeatured="yes">'.esc_html__('Remove', 'pointfindert2d').'</a></div><div class="pfitemedit-featured"><div>'.esc_html__('Cover Photo', 'pointfindert2d').'</div></div>';
					$output_images .= '</div>';
					$output_images .= '</li>';
					
					/*End:First export featured*/

					foreach ($images_of_thispost as $image_number) {
						$image_src = wp_get_attachment_image_src( $image_number, 'thumbnail' );
						$output_images .= '<li>';
						$output_images .= '<div class="pf-itemimage-container">';
						$output_images .= '<img src="'.aq_resize($image_src[0],90,90,true).'">';
						$output_images .= '<div class="pf-itemimage-delete"><a class="pf-delete-standartimg'.$olduptext.'" data-pfimgno="'.$image_number.'" data-pfpid="'.$id.'" data-pffeatured="no">'.esc_html__( 'Remove', 'pointfindert2d' ).'</a></div><div class="pfitemedit-featured"><a class="pf-change-standartimg'.$olduptext.'" data-pfimgno="'.$image_number.'" data-pfpid="'.$id.'" title="'.esc_html__('You can change your cover photo by clicking here', 'pointfindert2d').'">'.esc_html__('Set as Cover', 'pointfindert2d').'</a></div>';
						$output_images .= '</div>';
						$output_images .= '</li>';
					}
					$output .= '<section class="pfuploadform-mainsec">';
						$output .= '<label for="file" class="lbl-text">'.esc_html__('UPLOADED IMAGES','pointfindert2d').':</label>';
						$output .= '<ul class="pfimages-ul">'.$output_images.'</ul>';
					$output .= '</section>';
					
					echo $output;
				}
			}
		}
	}

	die();
}

?>