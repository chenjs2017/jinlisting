<?php
/**********************************************************************************************************************************
*
* Ajax Favorites System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_favorites', 'pf_ajax_favorites' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_favorites', 'pf_ajax_favorites' );

function pf_ajax_favorites(){
  
	//Security
	check_ajax_referer( 'pfget_favorites', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

	$fav_item = $fav_active = '';
	$results = array();
	if(isset($_POST['item']) && $_POST['item']!=''){
		$fav_item = esc_attr($_POST['item']);
	}
	if(isset($_POST['active']) && $_POST['active']!=''){
		$fav_active = esc_attr($_POST['active']);
	}

	$results['active'] = $fav_active; // Status of fav link.
	$results['item'] = $fav_item; // Item id number


	if (is_user_logged_in()) {
		
		$cur_user = get_current_user_id();
		$results['user'] = $cur_user;
		$json_array = get_user_meta( $cur_user, 'user_favorites', true );
		
		if (PFcheck_postmeta_exist('webbupointfinder_items_favorites',$fav_item)) { 

			$fav_number = esc_attr(get_post_meta( $fav_item, 'webbupointfinder_items_favorites', true ));

			if ($fav_active == 'false') {

				$fav_number = $fav_number + 1;

			}elseif ($fav_active == 'true' && $fav_number > 0) {

				$fav_number = $fav_number - 1;

			}

			update_post_meta($fav_item, 'webbupointfinder_items_favorites', $fav_number );	

		}else{

			if ($fav_active == 'false') {

				add_post_meta($fav_item, 'webbupointfinder_items_favorites', 1 );

			}elseif ($fav_active == 'true') {

				add_post_meta($fav_item, 'webbupointfinder_items_favorites', 0 );	

			}
		};




		if ($json_array) {

			$json_array = json_decode($json_array,true);
			if (is_array($json_array)) {
				$fav_item_pos = array_search($fav_item, $json_array);
			}else{
				$fav_item_pos = false;
			}
			

		}else{

			$json_array = array();
			$fav_item_pos = false;

		}


		

		if ($fav_active == 'false') {
			/*Add to favorites*/
			if($fav_item_pos === false){
				$json_array[] = $fav_item;
				update_user_meta( $cur_user, 'user_favorites', json_encode($json_array));
				$results['active'] = 'true';
				$results['favtext'] = esc_html__('Remove Favorite','pointfindert2d');
			}else{
				$results['active'] = 'true';
				$results['favtext'] = esc_html__('Remove Favorite','pointfindert2d');
			}
		}else{

			if($fav_item_pos !== false){

				if(!empty($json_array)){

					unset($json_array[$fav_item_pos]);

				}else{

					$json_array = array();

				}
				
				update_user_meta( $cur_user, 'user_favorites', json_encode($json_array));

				$results['active'] = 'false';
				$results['favtext'] = esc_html__('Add to Favorite','pointfindert2d');

			}else{

				$results['active'] = 'false';
				$results['favtext'] = esc_html__('Add to Favorite','pointfindert2d');

			}
			
		}

	}else{
		$results['user'] = 0;
	}


	echo json_encode($results);
die();
}

?>