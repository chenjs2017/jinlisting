<?php

/**********************************************************************************************************************************
*
* Ajax Owner Chnage Works
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

add_action( 'PF_AJAX_HANDLER_pfget_createorder', 'pf_ajax_createorder' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_createorder', 'pf_ajax_createorder' );
	
	
function pf_ajax_createorder(){

	check_ajax_referer( 'pfget_createorder', 'security' );
	header('Content-Type: application/json; charset=UTF-8;');
	

	if(isset($_POST['itemid']) && $_POST['itemid']!=''){
		$post_id = sanitize_text_field($_POST['itemid']);
	}

	if(isset($_POST['newauthor']) && $_POST['newauthor']!=''){
		$user_id = sanitize_text_field($_POST['newauthor']);
	}

	/** Orders: Post Info **/

	/*Check if any order exist about this property?*/
	
		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		$setup31_userlimits_userpublish = PFSAIssetControl('setup31_userlimits_userpublish','','0');
		$setup31_userpayments_priceperitem = PFSAIssetControl('setup31_userpayments_priceperitem','','0');
		$setup31_userlimits_userpublishonedit = PFSAIssetControl('setup31_userlimits_userpublishonedit','','0');
		$setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','0');
		$setup31_userpayments_featuredoffer = PFSAIssetControl('setup31_userpayments_featuredoffer','','0');


		srand(pfmake_seed());

		$setup31_userpayments_orderprefix = PFSAIssetControl('setup31_userpayments_orderprefix','','PF');
		
		$order_post_title = $setup31_userpayments_orderprefix.rand();

		if ($setup31_userpayments_priceperitem != 0) {
			$order_post_status = 'pendingpayment';
		}elseif($setup31_userpayments_priceperitem == 0){
			$order_post_status = 'completed';
		}else{
			$order_post_status = 'pendingpayment';
		}

		$arg_order = array(
		  'post_type'    => 'pointfinderorders',
		  'post_title'	=> $order_post_title,
		  'post_status'   => $order_post_status,
		  'post_author'   => $user_id,
		);

		$order_post_id = wp_insert_post($arg_order);


		/*Order Meta*/
		$ordered_package_name = '';
		$ordered_package_id = 1;
		$order_total_price = $setup31_userpayments_priceperitem;

		$ordered_package_name = $stp31_up2_pn = PFSAIssetControl('stp31_up2_pn','',esc_html__('Basic Listing Payment','pointfindert2d'));

		$order_detailed_price = array($stp31_up2_pn => $setup31_userpayments_priceperitem);

		$setup31_userpayments_timeperitem = PFSAIssetControl('setup31_userpayments_timeperitem','','');
		$order_recurring = 0;

		$check_featured = get_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', true );

		if(!empty($check_featured)){
			if($check_featured == 1){
				$setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','');
				$setup31_userpayments_featuredoffer = PFSAIssetControl('setup31_userpayments_featuredoffer','','1');
				$setup31_userpayments_titlefeatured = PFSAIssetControl('setup31_userpayments_titlefeatured','',esc_html__('Featured Item','pointfindert2d'));
				$ordered_package_id = 1;
				$order_total_price = $order_total_price + $setup31_userpayments_pricefeatured;
				$order_detailed_price[$ordered_package_name] = $setup31_userpayments_pricefeatured;

				$order_recurring = (!empty($vars['recurringlistingitem']) && ($setup31_userpayments_priceperitem != 0 || $setup31_userpayments_pricefeatured != 0)) ? '1' : '0' ;
			}

		}

		$pack_results = pointfinder_calculate_listingtypeprice('',$check_featured,$ordered_package_id);

	    $total_pr = $pack_results['total_pr'];
	    $cat_price = $pack_results['cat_price'];
	    $pack_price = $pack_results['pack_price'];
	    $featured_price = $pack_results['featured_price'];
	    $total_pr_output = $pack_results['total_pr_output'];
	    $featured_pr_output = $pack_results['featured_pr_output'];
	    $pack_pr_output = $pack_results['pack_pr_output'];
	    $cat_pr_output = $pack_results['cat_pr_output'];
	    $pack_title = $pack_results['pack_title'];


		$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','');

		/* - Creating record for process system. */
		PFCreateProcessRecord(
			array( 
		        'user_id' => $user_id,
		        'item_post_id' => $post_id,
				'processname' => esc_html__('Order created by Admin (User change function)','pointfindert2d')
		    )
		);	

		add_post_meta($order_post_id, 'pointfinder_order_itemid', $post_id, true );	
		add_post_meta($order_post_id, 'pointfinder_order_userid', $user_id, true );	
		add_post_meta($order_post_id, 'pointfinder_order_recurring', $order_recurring, true );	
		add_post_meta($order_post_id, 'pointfinder_order_price', $order_total_price, true );	
		add_post_meta($order_post_id, 'pointfinder_order_detailedprice', json_encode($order_detailed_price), true );	
		add_post_meta($order_post_id, 'pointfinder_order_listingtime', $setup31_userpayments_timeperitem, true );	
		add_post_meta($order_post_id, 'pointfinder_order_listingpname', $ordered_package_name, true );	
		add_post_meta($order_post_id, 'pointfinder_order_listingpid', $ordered_package_id, true );	
		add_post_meta($order_post_id, 'pointfinder_order_pricesign', $setup20_paypalsettings_paypal_price_short, true );
		add_post_meta($order_post_id, 'pointfinder_order_category_price', $cat_price);


		/* Start: Add expire date if this item is ready to publish (free listing) */

			$exp_date = date("Y-m-d H:i:s", strtotime("+".$setup31_userpayments_timeperitem." days"));
			$app_date = date("Y-m-d H:i:s");

			update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
			update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
			
			
			
			if ($check_featured == 1) {
				update_post_meta($order_post_id, 'pointfinder_order_frecurring', $order_recurring);
				update_post_meta($order_post_id, 'pointfinder_order_featured', 1);
				$stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');
				$exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));
				update_post_meta( $order_post_id, 'pointfinder_order_expiredate_featured', $exp_date_featured);
			}
			if (PFcheck_postmeta_exist('pointfinder_order_bankcheck',$order_post_id)) { 
				update_post_meta($order_post_id, 'pointfinder_order_bankcheck', '0');	
			};
			global $wpdb;
			$wpdb->UPDATE($wpdb->posts,array('post_status' => 'completed'),array('ID' => $order_post_id));
			
			/* - Creating record for process system. */
			PFCreateProcessRecord(
				array( 
			        'user_id' => $user_id,
			        'item_post_id' => $post_id,
					'processname' => esc_html__('Item status changed to Publish by Autosystem','pointfindert2d')
			    )
			);

		
		/* End: Add expire date if this item is ready to publish (free listing) */


		echo json_encode(array('process'=>true));
		

	/** Orders: Post Info **/
		
	die();
}

?>