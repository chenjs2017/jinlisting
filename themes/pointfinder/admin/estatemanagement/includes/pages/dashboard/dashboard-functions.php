<?php 
/**********************************************************************************************************************************
*
* User Dashboard Page - Functions
* 
* Author: Webbu Design
***********************************************************************************************************************************/


/**
*Start: Update & Add function for new item
**/
	function PFU_AddorUpdateRecord($params = array())
	{	

		$defaults = array( 
	        'post_id' => '',
	        'order_post_id' => '',
	        'order_title' => '',
			'vars' => array(),
			'user_id' => ''
	    );

	    $params = array_merge($defaults, $params);


	    $vars = $params['vars'];


	    $user_id = $params['user_id'];
	    $returnval = array();
	    $returnval['sccval'] = $returnval['errorval'] = $returnval['post_id'] = $returnval['ppps'] = $selectedpayment = $returnval['pppso'] ='';

		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		$setup31_userlimits_userpublish = PFSAIssetControl('setup31_userlimits_userpublish','','0');
		$setup31_userpayments_priceperitem = PFSAIssetControl('setup31_userpayments_priceperitem','','0');
		$setup31_userlimits_userpublishonedit = PFSAIssetControl('setup31_userlimits_userpublishonedit','','0');
		$setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','0');
		$setup31_userpayments_featuredoffer = PFSAIssetControl('setup31_userpayments_featuredoffer','','0');
		$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
		$setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
		$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
		$pfmenu_perout = PFPermalinkCheck();
		$setup4_ppp_catprice = PFSAIssetControl('setup4_ppp_catprice','','0');
		

		$autoexpire_create = $is_item_recurring = 0;

		/* Selected Payment Method for PPP */
		if (isset($vars['pf_lpacks_payment_selection']) && $setup4_membersettings_paymentsystem == 1) {
			if ($vars['pf_lpacks_payment_selection'] == 'paypal' || $vars['pf_lpacks_payment_selection'] == 'paypal2') {
				$selectedpayment = 'paypal';
			}else{
				$selectedpayment = $vars['pf_lpacks_payment_selection'];
			}
			if ($vars['pf_lpacks_payment_selection'] == 'paypal2') {
				$is_item_recurring = 1;
			}
			$returnval['ppps'] = $selectedpayment;
		}


		if($params['post_id'] == ''){
			$userpublish = ($setup31_userlimits_userpublish == 0) ? 'pendingapproval' : 'publish' ;

			if ($setup4_membersettings_paymentsystem == 2) {
				$membership_user_activeorder = get_user_meta( $params['user_id'], 'membership_user_activeorder', true );
				$post_status = $userpublish;
				$checkemail_poststatus = $post_status;
			}else{
				if ($vars['pf_lpacks_payment_selection'] == 'free') {
					$pricestatus = 'publish';
					$autoexpire_create = 1;
				}else{
					$pricestatus = 'pendingpayment';
				}

				if($userpublish == 'publish' && $pricestatus == 'publish'){
					$post_status = 'publish';
				}elseif($userpublish == 'publish' && $pricestatus == 'pendingpayment'){
					$post_status = 'pendingpayment';
				}elseif($userpublish == 'pendingapproval' && $pricestatus == 'publish'){
					$post_status = 'pendingapproval';
				}elseif($userpublish == 'pendingapproval' && $pricestatus == 'pendingpayment'){
					$post_status = 'pendingpayment';
				}
				
			}

		}else{
			if ($setup4_membersettings_paymentsystem == 2) {
				$membership_user_activeorder = get_user_meta( $params['user_id'], 'membership_user_activeorder', true );
				$post_status = ($setup31_userlimits_userpublishonedit == 0) ? 'pendingapproval' : 'publish' ;
				$checkemail_poststatus = get_post_status( $params['post_id']);
				if($post_status == 'publish'){
					PFCreateProcessRecord(
						array( 
					        'user_id' => $user_id,
					        'item_post_id' => $membership_user_activeorder,
							'processname' => esc_html__('Published post edited by USER.','pointfindert2d'),
							'membership' => 1
					    )
					);
				}else{
					PFCreateProcessRecord(
						array( 
					        'user_id' => $user_id,
					        'item_post_id' => $membership_user_activeorder,
							'processname' => esc_html__('Pending Approval post edited by USER.','pointfindert2d'),
							'membership' => 1
					    )
					);
				}
			}else{
				/**
				*Rules;
				*	- If post editing
				*	- If post status not pending payment create a post meta item edited.
				*		- If post status pending approval and not approved before. don't create edit record for order meta.
				*	- If post status pending payment don't change status and not create record for edit.
				**/
				$checkemail_poststatus = get_post_status( $params['post_id']);
				if($checkemail_poststatus != 'pendingpayment'){
					if($checkemail_poststatus != 'pendingapproval'){
						$post_status = ($setup31_userlimits_userpublishonedit == 0) ? 'pendingapproval' : 'publish' ;
					}else{
						$post_status = 'pendingapproval';
						PFCreateProcessRecord(
							array( 
						        'user_id' => $user_id,
						        'item_post_id' => $params['post_id'],
								'processname' => esc_html__('Pending Approval post edited by USER.','pointfindert2d')
						    )
						);
					}

					update_post_meta($params['order_post_id'], 'pointfinder_order_itemedit', 1 );
					
				}else{
					$post_status = 'pendingpayment';

					/* - Creating record for process system. */
					PFCreateProcessRecord(
						array( 
					        'user_id' => $user_id,
					        'item_post_id' => $params['post_id'],
							'processname' => esc_html__('Pending Payment post edited by USER.','pointfindert2d')
					    )
					);
				}

				if($checkemail_poststatus == 'publish'){
					/* - Creating record for process system. */
					PFCreateProcessRecord(
						array( 
					        'user_id' => $user_id,
					        'item_post_id' => $params['post_id'],
							'processname' => esc_html__('Published post edited by USER.','pointfindert2d')
					    )
					);
				}


				/* New Payment system  with v1.6.4 */
				if ($checkemail_poststatus == 'publish') {

					$pf_changed_value = array();
					$current_category_change = $pf_plan_changed_val = '';
					$pf_category_change = $pf_featured_change = $pf_plan_change = 0;

					/* Detect Featured Change */ 
					$pf_changed_featured = get_post_meta( $params['post_id'], "webbupointfinder_item_featuredmarker", true );
					if (empty($pf_changed_featured) && !empty($vars['featureditembox'])) {
						$pf_featured_change = 1;
						$pf_changed_value['featured'] = 1;
					}else{
						$pf_featured_change = 0;
						$pf_changed_value['featured'] = 0;
					}


					/* Detect Category Change if paid category selected */
					if (isset($vars['radio'])) {
						$item_defaultvalue = wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids"));
						if (isset($item_defaultvalue[0])) {
							$current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
							$current_category = $current_category['parent'];
						}
						if ($vars['radio'] == $current_category) {
							$pf_category_change = 0;
							$pf_changed_value['category'] = 0;
						}else{
							$pf_category_change = 1;
							$pf_changed_value['category'] = 1;
							$current_category_change = $vars['radio'];
						}
					}else{
						$pf_changed_value['category'] = 0;
						$pf_category_change = 0;
					}

					

					if (isset($vars['radio'])) {
						$current_category = $vars['radio'];
					}else{
						$item_defaultvalue = wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids"));
						if (isset($item_defaultvalue[0])) {
							$current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
							$current_category = $current_category['parent'];
						}
					}

					/* Detect Package Change */
					if (isset($vars['pfpackselector'])) {
						$current_selected_plan = get_post_meta( $params['order_post_id'], 'pointfinder_order_listingpid', true );

						if ($current_selected_plan == $vars['pfpackselector']) {
							$pf_plan_change = 0;
							$pf_changed_value['plan'] = 0;
						}else{
							$pf_plan_change = 1;
							$pf_changed_value['plan'] = 1;
							$pf_plan_changed_val = $vars['pfpackselector'];
						}
					}
					
					$pack_results = pointfinder_calculate_listingtypeprice($current_category_change,$pf_featured_change,$pf_plan_changed_val);

				    $total_pr = $pack_results['total_pr'];
				    $cat_price = $pack_results['cat_price'];
				    $pack_price = $pack_results['pack_price'];
				    $featured_price = $pack_results['featured_price'];
				    $total_pr_output = $pack_results['total_pr_output'];
				    $featured_pr_output = $pack_results['featured_pr_output'];
				    $pack_pr_output = $pack_results['pack_pr_output'];
				    $cat_pr_output = $pack_results['cat_pr_output'];
				    $pack_title = $pack_results['pack_title'];


				    if ($vars['pfpackselector'] == 1) {
				    	$duration_package = PFSAIssetControl('setup31_userpayments_timeperitem','','');
				    }else{
				    	$duration_package =  get_post_meta( $vars['pfpackselector'], 'webbupointfinder_lp_billing_period', true );
						if (empty($duration_package)) {
							$duration_package = 0;
						}
				    };

					/* Create Order Sub Fields */
					update_post_meta($params['order_post_id'], 'pointfinder_sub_order_change', 1);
					update_post_meta($params['order_post_id'], 'pointfinder_sub_order_changedvals', $pf_changed_value);

					update_post_meta($params['order_post_id'], 'pointfinder_sub_order_price', $total_pr);
				    update_post_meta($params['order_post_id'], 'pointfinder_sub_order_detailedprice', json_encode(array($pack_title => $total_pr)));
				    update_post_meta($params['order_post_id'], 'pointfinder_sub_order_listingtime', $duration_package);
				    update_post_meta($params['order_post_id'], 'pointfinder_sub_order_listingpname', $pack_title);	
					update_post_meta($params['order_post_id'], 'pointfinder_sub_order_listingpid', $vars['pfpackselector']);
					update_post_meta($params['order_post_id'], 'pointfinder_sub_order_category_price', $cat_price);

					
					if ($pf_featured_change == 1) {
						update_post_meta($params['order_post_id'], 'pointfinder_sub_order_featured', 1);
					}

					$returnval['pppso'] = 1;

				}elseif ($checkemail_poststatus == 'pendingpayment') {
					
					if ($vars['pf_lpacks_payment_selection'] == 'free') {
						$pricestatus = 'publish';
						$autoexpire_create = 1;
					}else{
						$pricestatus = 'pendingpayment';
					}

					if ($setup4_ppp_catprice == 1) {
						if (isset($vars['radio'])) {
							$current_category = $vars['radio'];
						}else{
							$item_defaultvalue = wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids"));
							if (isset($item_defaultvalue[0])) {
								$current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
								$current_category = $current_category['parent'];
							}
						}
					}else{
						$current_category = '';
					}
					
					if(empty($vars['featureditembox'])){
						$featured_item_box = 0;
						update_post_meta($params['order_post_id'], 'pointfinder_order_featured', 0);
						delete_post_meta($params['order_post_id'], 'pointfinder_order_expiredate_featured');
						update_post_meta($params['post_id'], 'webbupointfinder_item_featuredmarker', 0);
					}else{
						$featured_item_box = 1;
					}

					if (isset($vars['pfpackselector']) && isset($vars['radio'])) {
						if ($featured_item_box == 1 && (pointfinder_get_package_price_ppp($vars['pfpackselector']) != 0 || pointfinder_get_category_price_ppp($vars['radio']) != 0)) {
							update_post_meta($params['order_post_id'], 'pointfinder_order_fremoveback2', 1);
						}
					}


					$pack_results = pointfinder_calculate_listingtypeprice($current_category,$featured_item_box,$vars['pfpackselector']);

				    $total_pr = $pack_results['total_pr'];
				    $cat_price = $pack_results['cat_price'];
				    $pack_price = $pack_results['pack_price'];
				    $featured_price = $pack_results['featured_price'];
				    $total_pr_output = $pack_results['total_pr_output'];
				    $featured_pr_output = $pack_results['featured_pr_output'];
				    $pack_pr_output = $pack_results['pack_pr_output'];
				    $cat_pr_output = $pack_results['cat_pr_output'];
				    $pack_title = $pack_results['pack_title'];

				    if ($vars['pfpackselector'] == 1) {
				    	$duration_package = PFSAIssetControl('setup31_userpayments_timeperitem','','');
				    }else{
				    	$duration_package =  get_post_meta( $vars['pfpackselector'], 'webbupointfinder_lp_billing_period', true );
						if (empty($duration_package)) {
							$duration_package = 0;
						}
				    };

					$setup31_userpayments_orderprefix = PFSAIssetControl('setup31_userpayments_orderprefix','','PF');
					
					$order_post_status = ($total_pr == 0)? 'completed' : 'pendingpayment';
				
					$arg_order = array(
					  'ID' => $params['order_post_id'],
					  'post_type'    => 'pointfinderorders',
					  'post_status'   => $order_post_status
					);

					$order_post_id = wp_update_post($arg_order);

					$order_recurring = ($is_item_recurring == 1 && $total_pr != 0 ) ? '1' : '0';
					
					$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','');
					$stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

					/* Order Meta */
					update_post_meta($params['order_post_id'], 'pointfinder_order_itemid', $params['post_id']);
					update_post_meta($params['order_post_id'], 'pointfinder_order_userid', $user_id);
					update_post_meta($params['order_post_id'], 'pointfinder_order_recurring', $order_recurring);
					update_post_meta($params['order_post_id'], 'pointfinder_order_price', $total_pr);
					update_post_meta($params['order_post_id'], 'pointfinder_order_detailedprice', json_encode(array($pack_title => $total_pr)));
					update_post_meta($params['order_post_id'], 'pointfinder_order_listingtime', $duration_package);
					update_post_meta($params['order_post_id'], 'pointfinder_order_listingpname', $pack_title);	
					update_post_meta($params['order_post_id'], 'pointfinder_order_listingpid', $vars['pfpackselector']);
					update_post_meta($params['order_post_id'], 'pointfinder_order_pricesign', $setup20_paypalsettings_paypal_price_short);
					update_post_meta($params['order_post_id'], 'pointfinder_order_category_price', $cat_price);

					if ($featured_item_box == 1) {
						update_post_meta($params['order_post_id'], 'pointfinder_order_featured', 1);
						update_post_meta($params['order_post_id'], 'pointfinder_order_frecurring', $order_recurring);
					}

					if ($selectedpayment == 'bank') {
						$returnval['pppsru'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2&i='.$params['post_id'];
						update_post_meta($params['order_post_id'], 'pointfinder_order_bankcheck', '1');
					}else{
						update_post_meta($params['order_post_id'], 'pointfinder_order_bankcheck', '0');
					}

					/* Start: Add expire date if this item is ready to publish (free listing) */
					if($autoexpire_create == 1){

						$userpublish = ($setup31_userlimits_userpublish == 0) ? 'pendingapproval' : 'publish' ;

						if($userpublish == 'publish' && $pricestatus == 'publish'){
							$post_status = 'publish';
						}elseif($userpublish == 'publish' && $pricestatus == 'pendingpayment'){
							$post_status = 'pendingpayment';
						}elseif($userpublish == 'pendingapproval' && $pricestatus == 'publish'){
							$post_status = 'pendingapproval';
						}elseif($userpublish == 'pendingapproval' && $pricestatus == 'pendingpayment'){
							$post_status = 'pendingpayment';
						}

						wp_update_post(array('ID' => $params['post_id'],'post_status' => $post_status) );
						
						$exp_date = date("Y-m-d H:i:s", strtotime("+".$duration_package." days"));
						$app_date = date("Y-m-d H:i:s");

						if ($featured_item_box == 1) {
							$exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));
							update_post_meta( $params['order_post_id'], 'pointfinder_order_expiredate_featured', $exp_date_featured);
						}
						
						update_post_meta( $params['order_post_id'], 'pointfinder_order_expiredate', $exp_date);
						update_post_meta( $params['order_post_id'], 'pointfinder_order_datetime_approval', $app_date);
						update_post_meta( $params['order_post_id'], 'pointfinder_order_bankcheck', '0');

						global $wpdb;
						$wpdb->UPDATE($wpdb->posts,array('post_status' => 'completed'),array('ID' => $params['order_post_id']));
						
						/* - Creating record for process system. */
						PFCreateProcessRecord(
							array( 
						        'user_id' => $user_id,
						        'item_post_id' => $params['post_id'],
								'processname' => esc_html__('Item status changed to Publish by Autosystem (Free Plan)','pointfindert2d')
						    )
						);
					}
					/* End: Add expire date if this item is ready to publish (free listing) */

					/* - Creating record for process system. */
					PFCreateProcessRecord(array( 'user_id' => $user_id,'item_post_id' => $params['post_id'],'processname' => esc_html__('An item edited by USER.','pointfindert2d')));	
				}
			}

		}

		$arg = array(
		  'ID'=> $params['post_id'],
		  'post_type'    => $setup3_pointposttype_pt1,
		  'post_title'    => esc_html($vars['item_title']),
		  'post_content'  => $vars['item_desc'],
		  'post_status'   => $post_status,
		  'post_author'   => $user_id,
		);

		if ($params['post_id']!='') {
			$update_work = "ok";
			wp_update_post($arg);
			$post_id = $params['post_id'];
			$old_status_featured = get_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', true );
		}else{
			$update_work = "not";
			$post_id = wp_insert_post($arg);
			$old_status_featured = false;
			update_post_meta( $post_id, "webbupointfinder_item_reviewcount", 0);
		}



		if ($setup4_membersettings_paymentsystem == 2) {
			PFCreateProcessRecord(
				array( 
			        'user_id' => $user_id,
			        'item_post_id' => $membership_user_activeorder,
					'processname' => esc_html__('New item uploaded by USER.','pointfindert2d'),
					'membership' => 1
			    )
			);
		}
		
		/** 
		*Send email to the user;
		*	- Check $post_id for edit
		*	- Don't send email if direct publish enabled on edit.
		*	- Don't send email if edited post status pendingpayment & pendingapproval
		**/
			if ($params['post_id'] != '') {
				
				if($checkemail_poststatus != 'pendingpayment' && $checkemail_poststatus != 'pendingapproval'){
					if ($setup31_userlimits_userpublishonedit == 0) {
						$user_email_action = 'send';
					}else{
						$user_email_action = 'cancel';
					}
				}else{
					$user_email_action = 'cancel';
				}
				
			}elseif ($params['post_id'] == '') {
				$user_email_action = 'send';
			}

			if($user_email_action == 'send'){

				if ($post_status == 'publish') {
					$email_subject = 'itemapproved';
				}elseif ($post_status == 'pendingpayment') {
					$email_subject = 'waitingpayment';
				}elseif ($post_status == 'pendingapproval') {
					$email_subject = 'waitingapproval';
				}
				$user_info = get_userdata( $user_id );
				
				pointfinder_mailsystem_mailsender(
					array(
						'toemail' => $user_info->user_email,
				        'predefined' => $email_subject,
				        'data' => array('ID' => $post_id,'title'=>esc_html($vars['item_title'])),
						)
					);
			}
		

		/**
		*Send email to the admin;
		*	- System will not send email if disabled by PF Mail System
		*	- Don't send email if edited post status pendingpayment & pendingapproval
		**/

			 $admin_email = get_option( 'admin_email' );
			 $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
			 

			 if ($setup33_emailsettings_mainemail != '') {
			 	
			 	if ($params['post_id']!='') {
			 		$adminemail_subject = 'updateditemsubmission';
			 		$setup33_emaillimits_adminemailsafteredit = PFMSIssetControl('setup33_emaillimits_adminemailsafteredit','','1');
			 		if($checkemail_poststatus != 'pendingpayment' && $checkemail_poststatus != 'pendingapproval'){
				 		if ($setup33_emaillimits_adminemailsafteredit == 1) {
				 			$admin_email_action = 'send';
				 		}else{
				 			$admin_email_action = 'cancel';
				 		}
				 	}else{
				 		$admin_email_action = 'cancel';
				 	}
			 	}else{
			 		$adminemail_subject = 'newitemsubmission';
			 		$setup33_emaillimits_adminemailsafterupload = PFMSIssetControl('setup33_emaillimits_adminemailsafterupload','','1');
			 		if ($setup33_emaillimits_adminemailsafterupload == 1) {
			 			$admin_email_action = 'send';
			 		}else{
			 			$admin_email_action = 'cancel';
			 		}
			 	}

			 	if ($admin_email_action == 'send') {
			 		
			 		pointfinder_mailsystem_mailsender(
					array(
						'toemail' => $setup33_emailsettings_mainemail,
				        'predefined' => $adminemail_subject,
				        'data' => array('ID' => $post_id,'title'=>esc_html($vars['item_title'])),
						)
					);
			 	}
			 }
		
		$returnval['post_id'] = $post_id;

		if (isset($vars['issuer'])) {
			$returnval['issuer'] = $vars['issuer'];
		}
		

		/** Start: Taxonomies **/

			/*Listing Types*/

				$pftax_terms = '';

				if(isset($vars['pfupload_listingtypes'])){
					if(PFControlEmptyArr($vars['pfupload_listingtypes'])){
						$pftax_terms = $vars['pfupload_listingtypes'];
					}else if(!PFControlEmptyArr($vars['pfupload_listingtypes']) && isset($vars['pfupload_listingtypes'])){
						$pftax_terms = $vars['pfupload_listingtypes'];
						if (strpos($pftax_terms, ",") != false) {
							$pftax_terms = pfstring2BasicArray($pftax_terms);
						}else{
							$pftax_terms = array($vars['pfupload_listingtypes']);
						}
					}
				}

				if(!empty($pftax_terms)){
					if ($setup4_membersettings_paymentsystem == 2) {

						wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');

					}else{

						if ($setup4_ppp_catprice == 1) {

							if ($update_work == "not") {

								wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');

							}else{

								$item_defaultvalue = wp_get_post_terms($post_id, 'pointfinderltypes', array("fields" => "ids"));
								
								if (isset($item_defaultvalue[0])) {
									$current_category = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');
									$current_category = $current_category['parent'];
								}

								if (isset($vars['radio'])) {

									if ($post_status != "pendingpayment") {
										$category_price_status = pointfinder_get_category_price_ppp($vars['radio']);

										if (empty($category_price_status)) {
											wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
										}else{
											update_post_meta($params['order_post_id'], 'pointfinder_sub_order_termsmc', $current_category);
											update_post_meta($params['order_post_id'], 'pointfinder_sub_order_termsms', $vars['radio']);
											update_post_meta($params['order_post_id'], 'pointfinder_sub_order_terms', $pftax_terms);
										}

									}else{

										wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');

									}
									
								}else{
									wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
								}
							}

						}else{
							wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
						}

					}
				}


			/*Item Types*/
			if(isset($vars['pfupload_itemtypes'])){
				if(PFControlEmptyArr($vars['pfupload_itemtypes'])){
					$pftax_terms = $vars['pfupload_itemtypes'];
				}else if(!PFControlEmptyArr($vars['pfupload_itemtypes']) && isset($vars['pfupload_itemtypes'])){
					$pftax_terms = array($vars['pfupload_itemtypes']);
				}
				wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderitypes');
			}

			/*Conditions*/
			if(isset($vars['pfupload_conditions'])){
				if(PFControlEmptyArr($vars['pfupload_conditions'])){
					$pftax_terms = $vars['pfupload_conditions'];
				}else if(!PFControlEmptyArr($vars['pfupload_conditions']) && isset($vars['pfupload_conditions'])){
					$pftax_terms = array($vars['pfupload_conditions']);
				}
				wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderconditions');
			}


			/*Locations Types*/
			if(isset($vars['pfupload_locations'])){

				$stp4_loc_new = PFSAIssetControl('stp4_loc_new','','0');
				$stp4_loc_add = PFSAIssetControl('stp4_loc_add','','0');
				
				if ($stp4_loc_new == 1 && $stp4_loc_add == 1 && !empty($vars['customlocation'])) {
					$retunlocation = wp_insert_term( $vars['customlocation'], 'pointfinderlocations', array('parent'=>$vars['pfupload_sublocations']) );
					$pftax_terms = $retunlocation['term_id'];
				}else{
					if(PFControlEmptyArr($vars['pfupload_locations'])){
						$pftax_terms = $vars['pfupload_locations'];
					}else if(!PFControlEmptyArr($vars['pfupload_locations']) && isset($vars['pfupload_locations'])){
						$pftax_terms = array($vars['pfupload_locations']);
					}
				}

				wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderlocations');
				//set_lat_lng($post_id)

			}


			/*Features Types*/
			if(isset($vars['pffeature'])){				
				if(PFControlEmptyArr($vars['pffeature'])){
					$pftax_terms = $vars['pffeature'];
				}else if(!PFControlEmptyArr($vars['pffeature']) && isset($vars['pffeature'])){
					$pftax_terms = array($vars['pffeature']);
				}
				wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderfeatures');
			}else{
				wp_set_post_terms( $post_id, '', 'pointfinderfeatures');
			}


			/* Post Tags */
			if (isset($vars['posttags'])) {wp_set_post_tags( $post_id, $vars['posttags'], true );}

		/** End: Taxonomies **/


		/** Start: Opening Hours **/
			$setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
			$setup3_modulessetup_openinghours_ex = PFSAIssetControl('setup3_modulessetup_openinghours_ex','','1');

			if($setup3_modulessetup_openinghours == 1 && $setup3_modulessetup_openinghours_ex == 0){

				$i = 1;
				while ( $i <= 7) {
					if(isset($vars['o'.$i])){
						update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, $vars['o'.$i]);	
					}
					$i++;
				}

			}elseif($setup3_modulessetup_openinghours == 1 && $setup3_modulessetup_openinghours_ex == 1){

				$i = 1;
				while ( $i <= 1) {
					if(isset($vars['o'.$i])){
						update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, $vars['o'.$i]);	
					}
					$i++;
				}

			}elseif($setup3_modulessetup_openinghours == 1 && $setup3_modulessetup_openinghours_ex == 2){

				$i = 1;
				while ( $i <= 7) {
					if(isset($vars['o'.$i.'_1']) && isset($vars['o'.$i.'_2'])){
						update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, $vars['o'.$i.'_1'].'-'.$vars['o'.$i.'_2']);	
					}
					$i++;
				}

			}
		/** End: Opening Hours **/

		
		/** Start: Post Meta **/

			/*Featured*/

				if(!empty($vars['featureditembox']) && $params['post_id'] == ''){
					if($vars['featureditembox'] == 'on'){
						update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 1);	
					}else{
						update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 0);	
					}
				}elseif(empty($vars['featureditembox']) && $params['post_id'] == ''){
					update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 0);
				}
				

			/*Location*/
				if(isset($vars['pfupload_lat']) && isset($vars['pfupload_lng'])){
					update_post_meta($post_id, 'webbupointfinder_items_location', $vars['pfupload_lat'].','.$vars['pfupload_lng']);	
    			update_post_meta($post_id, 'latitude', $vars['pfupload_lat']);
    			update_post_meta($post_id, 'longitude', $vars['pfupload_lng']);
				}

			/*Addrress*/
				if(isset($vars['pfupload_address'])){
					update_post_meta($post_id, 'webbupointfinder_items_address', $vars['pfupload_address']);	
				}

			/*Message to Reviewer*/
				if (isset($vars['item_mesrev'])) {
					if (PFcheck_postmeta_exist('webbupointfinder_items_mesrev',$post_id)) { 
						$old_mesrev = get_post_meta($post_id, 'webbupointfinder_items_mesrev', true);
						$old_mesrev = json_decode($old_mesrev,true);

						if (is_array($old_mesrev)) {
							$old_mesrev = PFCleanArrayAttr('PFCleanFilters',$old_mesrev);
						} 

						$old_mesrev[] = array('message' => $vars['item_mesrev'], 'date' => date("Y-m-d H:i:s"));
						$old_mesrev = json_encode($old_mesrev);

						update_post_meta($post_id, 'webbupointfinder_items_mesrev', $old_mesrev);	
					}else{

						$old_mesrev = array();
						$old_mesrev[] = array('message' => $vars['item_mesrev'], 'date' => date("Y-m-d H:i:s"));
						$old_mesrev = json_encode($old_mesrev);

						add_post_meta ($post_id, 'webbupointfinder_items_mesrev', $old_mesrev);
					}; 
				}

			/** Start: Featured Video **/
				if(isset($vars['pfuploadfeaturedvideo'])){
					update_post_meta($post_id, 'webbupointfinder_item_video', esc_url($vars['pfuploadfeaturedvideo']));	
				}
			/** End: Featured Video **/

			/*Custom fields loop*/
				$pfstart = PFCheckStatusofVar('setup1_slides');
				$setup1_slides = PFSAIssetControl('setup1_slides','','');

				if($pfstart == true){

					foreach ($setup1_slides as &$value) {

			          $customfield_statuscheck = PFCFIssetControl('setupcustomfields_'.$value['url'].'_frontupload','','0');
			          $available_fields = array(1,2,3,4,5,7,8,9,14,15);
			          
			          if(in_array($value['select'], $available_fields) && $customfield_statuscheck != 0){
			           	 
						if(isset($vars[''.$value['url'].''])){

							if ($value['select'] == 15) {
								$setup4_membersettings_dateformat = PFSAIssetControl('setup4_membersettings_dateformat','','1');
								switch ($setup4_membersettings_dateformat) {
									case '1':$datetype = "d/m/Y";break;
									case '2':$datetype = "m/d/Y";break;
									case '3':$datetype = "Y/m/d";break;
									case '4':$datetype = "Y/d/m";break;
								}

								$pfvalue = date_parse_from_format($datetype, $vars[''.$value['url'].'']);
								$vars[''.$value['url'].''] = strtotime(date("Y-m-d", mktime(0, 0, 0, $pfvalue['month'], $pfvalue['day'], $pfvalue['year'])));
							}

							if(!is_array($vars[''.$value['url'].''])){ 
								update_post_meta($post_id, 'webbupointfinder_item_'.$value['url'], $vars[''.$value['url'].'']);
							}else{
								if(PFcheck_postmeta_exist('webbupointfinder_item_'.$value['url'],$post_id)){
									delete_post_meta($post_id, 'webbupointfinder_item_'.$value['url']);
								};

								foreach ($vars[''.$value['url'].''] as $val) {
									add_post_meta ($post_id, 'webbupointfinder_item_'.$value['url'], $val);
								};

							};
						}else{
							if (PFcheck_postmeta_exist('webbupointfinder_item_'.$value['url'],$post_id)) { 
								delete_post_meta($post_id, 'webbupointfinder_item_'.$value['url']);
							}; 
						};

			          };
			          
			        };
				};		

		/** End: Post Meta **/

		/*Old Image upload for Backup*/
			$setup4_submitpage_status_old = PFSAIssetControl('setup4_submitpage_status_old','','0');

			if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9') !== false || $setup4_submitpage_status_old == 1) {

				if (!empty($vars['pfuploadimagesrc'])) {
				
					$uploadimages = pfstring2BasicArray($vars['pfuploadimagesrc']);
					$i = 0;
					foreach ($uploadimages as $uploadimage) {
						delete_post_meta( $uploadimage, 'pointfinder_delete_unused');
						$postthumbid = get_post_thumbnail_id($post_id);
						if ($update_work == "ok" && $postthumbid != false) {
							add_post_meta($post_id, 'webbupointfinder_item_images', $uploadimage);
						}else{
							if($i != 0){
								 add_post_meta($post_id, 'webbupointfinder_item_images', $uploadimage);
							}else{
								 set_post_thumbnail( $post_id, $uploadimage );
							}
						}
						$i++;
					}
					
				}
			}elseif ($setup4_submitpage_status_old == 0){
				if (!empty($vars['pfuploadimagesrc'])) {
					if ($params['order_post_id'] == '') {
						$uploadimages = pfstring2BasicArray($vars['pfuploadimagesrc']);
						$i = 0;
						foreach ($uploadimages as $uploadimage) {
							delete_post_meta( $uploadimage, 'pointfinder_delete_unused');
							if($i != 0){
								 add_post_meta($post_id, 'webbupointfinder_item_images', $uploadimage);	
							}else{
								 set_post_thumbnail( $post_id, $uploadimage );
							}
							$i++;
						}
					}
				}
			}

		/*File Upload System*/
			$stp4_fupl = PFSAIssetControl('stp4_fupl','','0');

			if($stp4_fupl == 1) {

				if (!empty($vars['pfuploadfilesrc'])) {
				
					$uploadfiles = pfstring2BasicArray($vars['pfuploadfilesrc']);
					$i = 0;
					foreach ($uploadfiles as $uploadfile) {
						delete_post_meta( $uploadfile, 'pointfinder_delete_unused');
						add_post_meta($post_id, 'webbupointfinder_item_files', $uploadfile);
						$i++;
					}
					
				}
			}

		/*Custom Tabs System*/
		
			if (!empty($vars['webbupointfinder_item_custombox1'])) {
				update_post_meta($post_id, 'webbupointfinder_item_custombox1', $vars['webbupointfinder_item_custombox1']);	
			}
		
		
			if (!empty($vars['webbupointfinder_item_custombox2'])) {
				update_post_meta($post_id, 'webbupointfinder_item_custombox2', $vars['webbupointfinder_item_custombox2']);	
			}
		
		
			if (!empty($vars['webbupointfinder_item_custombox3'])) {
				update_post_meta($post_id, 'webbupointfinder_item_custombox3', $vars['webbupointfinder_item_custombox3']);	
			}
			
		
		
		if ($setup4_membersettings_paymentsystem == 2) {
			/* - Creating record for process system. */
			PFCreateProcessRecord(array( 'user_id' => $user_id,'item_post_id' => $membership_user_activeorder,'processname' => esc_html__('A new item uploaded by USER.','pointfindert2d'),'membership' => 1));	
		}else{
			/** Orders: Post Info **/
			if ($params['order_post_id'] == '' && $params['post_id'] == '') {

				/* New order system
				$vars['pfpackselector'];//2461 paket
				$vars['featureditembox'];//on
				$vars['radio'];// pf listing type
				$vars['pf_lpacks_payment_selection'];//payment selector
				*/
				if(empty($vars['featureditembox'])){
					$featured_item_box = 0;
				}else{
					$featured_item_box = 1;
				}


				$pack_results = pointfinder_calculate_listingtypeprice($vars['radio'],$featured_item_box,$vars['pfpackselector']);

			    $total_pr = $pack_results['total_pr'];
			    $cat_price = $pack_results['cat_price'];
			    $pack_price = $pack_results['pack_price'];
			    $featured_price = $pack_results['featured_price'];
			    $total_pr_output = $pack_results['total_pr_output'];
			    $featured_pr_output = $pack_results['featured_pr_output'];
			    $pack_pr_output = $pack_results['pack_pr_output'];
			    $cat_pr_output = $pack_results['cat_pr_output'];
			    $pack_title = $pack_results['pack_title'];

			    if ($vars['pfpackselector'] == 1) {
			    	$duration_package = PFSAIssetControl('setup31_userpayments_timeperitem','','');
			    }else{
			    	$duration_package =  get_post_meta( $vars['pfpackselector'], 'webbupointfinder_lp_billing_period', true );
					if (empty($duration_package)) {
						$duration_package = 0;
					}
			    };

				srand(pfmake_seed());

				$setup31_userpayments_orderprefix = PFSAIssetControl('setup31_userpayments_orderprefix','','PF');
				
				$order_post_title = ($params['order_title'] != '') ? $params['order_title'] : $setup31_userpayments_orderprefix.rand();
				$order_post_status = ($total_pr == 0)? 'completed' : 'pendingpayment';
			
				$arg_order = array(
				  'post_type'    => 'pointfinderorders',
				  'post_title'	=> $order_post_title,
				  'post_status'   => $order_post_status,
				  'post_author'   => $user_id,
				);

				$order_post_id = wp_insert_post($arg_order);

				$order_recurring = ($is_item_recurring == 1 && $total_pr != 0 ) ? '1' : '0';
				
				$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','');
				$stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

				/* Order Meta */
				add_post_meta($order_post_id, 'pointfinder_order_itemid', $post_id, true );
				add_post_meta($order_post_id, 'pointfinder_order_userid', $user_id, true );
				add_post_meta($order_post_id, 'pointfinder_order_recurring', $order_recurring, true );
				add_post_meta($order_post_id, 'pointfinder_order_price', $total_pr, true );
				add_post_meta($order_post_id, 'pointfinder_order_detailedprice', json_encode(array($pack_title => $total_pr)), true );
				add_post_meta($order_post_id, 'pointfinder_order_listingtime', $duration_package, true );
				add_post_meta($order_post_id, 'pointfinder_order_listingpname', $pack_title, true );	
				add_post_meta($order_post_id, 'pointfinder_order_listingpid', $vars['pfpackselector'], true );
				add_post_meta($order_post_id, 'pointfinder_order_pricesign', $setup20_paypalsettings_paypal_price_short, true );
				add_post_meta($order_post_id, 'pointfinder_order_category_price', $cat_price);

				if ($featured_item_box == 1) {
					add_post_meta($order_post_id, 'pointfinder_order_featured', 1);
					add_post_meta($order_post_id, 'pointfinder_order_frecurring', $order_recurring, true );
				}

				if ($selectedpayment == 'bank') {
					$returnval['pppsru'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2&i='.$post_id;
					add_post_meta($order_post_id, 'pointfinder_order_bankcheck', '1');
				}else{
					add_post_meta($order_post_id, 'pointfinder_order_bankcheck', '0');
				}
				
				if (isset($vars['pfpackselector'])) {
					if ($featured_item_box == 1 && pointfinder_get_package_price_ppp($vars['pfpackselector']) == 0) {
						update_post_meta($order_post_id, 'pointfinder_order_fremoveback', 1);
					}
				}

				if (isset($vars['pfpackselector']) && isset($vars['radio'])) {
					if ($featured_item_box == 1 && (pointfinder_get_package_price_ppp($vars['pfpackselector']) != 0 || pointfinder_get_category_price_ppp($vars['radio']) != 0)) {
						update_post_meta($order_post_id, 'pointfinder_order_fremoveback2', 1);
					}
				}
				


				/* Start: Add expire date if this item is ready to publish (free listing) */
				if($autoexpire_create == 1){
					
					$exp_date = date("Y-m-d H:i:s", strtotime("+".$duration_package." days"));
					$app_date = date("Y-m-d H:i:s");

					if ($featured_item_box == 1) {
						$exp_date_featured = date("Y-m-d H:i:s", strtotime("+".$stp31_daysfeatured." days"));
						update_post_meta( $order_post_id, 'pointfinder_order_expiredate_featured', $exp_date_featured);
					}
					
					update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
					update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);

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
				}
				/* End: Add expire date if this item is ready to publish (free listing) */

				/* - Creating record for process system. */
				PFCreateProcessRecord(array( 'user_id' => $user_id,'item_post_id' => $post_id,'processname' => esc_html__('A new item uploaded by USER.','pointfindert2d')));	
			}
			/** Orders: Post Info **/
		}
			
		
		if ($params['post_id'] == '') {
			$returnval['sccval'] = sprintf(esc_html__('信息提交成功','pointfindert2d'),'<br/>');
		}else{
			$returnval['sccval'] = sprintf(esc_html__('信息提交成功','pointfindert2d'),'<br/>');
		}
		
		/*Membership limits for item /featured limit*/
		if ($setup4_membersettings_paymentsystem == 2) {
			
				$membership_user_item_limit = get_user_meta( $user_id, 'membership_user_item_limit', true );
				$membership_user_featureditem_limit = get_user_meta( $user_id, 'membership_user_featureditem_limit', true );
				
				if (!empty($membership_user_item_limit)){
					if ($update_work == "not") {
						$membership_user_item_limit = $membership_user_item_limit - 1;
						update_user_meta( $user_id, 'membership_user_item_limit', $membership_user_item_limit);
					}
				}


				if(!empty($vars['featureditembox'])){
					
					if($vars['featureditembox'] == 'on' && $update_work == "not"){
						
						$membership_user_featureditem_limit = $membership_user_featureditem_limit - 1;
						update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
					
					}elseif ($vars['featureditembox'] == 'on' && $update_work == "ok") {
						
						if (empty($old_status_featured) && $membership_user_featureditem_limit > 0) {
							$membership_user_featureditem_limit = $membership_user_featureditem_limit - 1;
							update_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', 1);
							update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
						}elseif (empty($old_status_featured) && $membership_user_featureditem_limit <= 0) {
							update_post_meta( $post_id, 'webbupointfinder_item_featuredmarker', 0);
						}

					}
				}else{
					if ($old_status_featured != false && $old_status_featured != 0) {
						update_post_meta($post_id, 'webbupointfinder_item_featuredmarker', 0);
						$membership_user_featureditem_limit = $membership_user_featureditem_limit + 1;
						update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
					}
				}
		}

		return $returnval;
	}
/**
*End: Update & Add function for new item
**/
?>
