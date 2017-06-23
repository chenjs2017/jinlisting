<?php
/**********************************************************************************************************************************
*
* Schedule Configurations 
* 
* Author: Webbu Design
* Please do not modify below functions.
***********************************************************************************************************************************/

/**
*Activate all schedule hooks
**/
add_action( 'after_switch_theme', 'pointfinder_activation_twicedaily' );
function pointfinder_activation_twicedaily() {
	wp_schedule_event( strtotime(date('Y-m-d H:s:i',mktime(23,59,59,date('m'),date('d'),date('Y')) )), 'twicedaily', 'pointfinder_schedule_hooks_hourly' );
}
add_action( 'after_switch_theme', 'pointfinder_activation_daily' );
function pointfinder_activation_daily() {
	flush_rewrite_rules();/*added with v1.5.8*/
	wp_schedule_event( strtotime(date('Y-m-d H:s:i',mktime(23,59,59,date('m'),date('d'),date('Y')) )), 'daily', 'pointfinder_schedule_hooks_daily' );
}

/**
*Deactivate all schedule hooks 
**/
add_action( 'switch_theme', 'pointfinder_deactivation_daily' );
function pointfinder_deactivation_daily() {
	wp_clear_scheduled_hook( 'pointfinder_schedule_hooks_daily' );
}
add_action( 'switch_theme', 'pointfinder_deactivation_hourly' );
function pointfinder_deactivation_hourly() {
	wp_clear_scheduled_hook( 'pointfinder_activation_twicedaily' );
}

$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

if ($setup4_membersettings_paymentsystem == 2) {

	/**
	*Start: Membership System Schedule
	**/
		/**
		*Start: Check Expired Plans & Expire
		**/
			add_action( 'pointfinder_schedule_hooks_hourly', 'pointfinder_check_expires_member' );
			function pointfinder_check_expires_member() {
				
				/*
				Direct payment:

					- Change order status to pending payment. 
					- Change User status to expired.
					- Send an email to user.
					- Add a process record for this action.
				*/

				$exptime = strtotime("now");

				global $wpdb;
				/*
				print_r(strtotime("now"));
				echo '<br>';
				print_r(PFU_DateformatS(strtotime("now"),1));
				echo '<br>';
				*/
				
				$results = $wpdb->get_results( $wpdb->prepare( 
					"SELECT p.ID, p.post_author, pm.meta_value, p.post_date FROM $wpdb->posts as p 
					INNER JOIN $wpdb->postmeta as pm  
						ON ( p.ID = pm.post_id )
					INNER JOIN $wpdb->postmeta as pm2 
						ON ( pm.post_id = pm2.post_id ) 
					WHERE p.post_type = %s 
					and p.post_status = %s 
					and pm.meta_key = %s 
					and pm.meta_value <= %s 
					and pm2.meta_key = %s 
					and pm2.meta_value = %d", 
					'pointfindermorders',
					'completed',
					'pointfinder_order_expiredate',
					$exptime,
					'pointfinder_order_recurring',
					0
				),'OBJECT_K' );
				
		
				$setup33_emaillimits_listingexpired = PFMSIssetControl('setup33_emaillimits_listingexpired','','1');

				if (PFControlEmptyArr($results)) {
					foreach ($results as $result) {

						/* This is direct payment */
						PFExpireItemManualMember(
							array( 
							    'order_id' => $result->ID,
							    'post_author' => $result->post_author,
								'payment_type' => 'direct'
							)
						);

						if ($setup33_emaillimits_listingexpired == 1) {
							$packageid = get_post_meta($result->ID,'pointfinder_order_packageid',true );
							$packageinfo = pointfinder_membership_package_details_get($packageid);
							$user_info = get_userdata( $result->post_author);
							pointfinder_mailsystem_mailsender(
								array(
								'toemail' => $user_info->user_email,
							    'predefined' => 'directafterexpiremember',
							    'data' => array(
							    	'orderid' => $result->ID, 
							    	'expiredate' => PFU_DateformatS($result->meta_value),
							    	'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],
							    	'packagename' => $packageinfo['webbupointfinder_mp_title']
							    	),
								)
							);
						}
						

					}/*Foreach end*/
				}

			}
		/**
		*End: Check Expired Plans & Expire
		**/

		/**
		*Start: Check expiring packages and send email 1 day before.
		**/
			add_action( 'pointfinder_schedule_hooks_daily', 'pointfinder_check_expiring_member' );
			function pointfinder_check_expiring_member() {
				
				/*
				Only for Direct payments. And this schedule will check item 1 day before expire.
				*/
				$setup33_emaillimits_listingautowarning = PFMSIssetControl('setup33_emaillimits_listingautowarning','','1');
				if ($setup33_emaillimits_listingautowarning == 1) {
					$exptime = strtotime(date("Y-m-d H:s:i", strtotime("-1 day")));
					$exptime = strtotime(date('Y-m-d H:s:i',mktime(23,59,59,date('m',$exptime),date('d',$exptime),date('Y',$exptime)) ));

					$exptime2 = strtotime(date("Y-m-d H:s:i", strtotime("+1 day")));
					$exptime2 = strtotime(date('Y-m-d H:s:i',mktime(23,59,59,date('m',$exptime2),date('d',$exptime2),date('Y',$exptime2)) ));

					global $wpdb;
					$results = $wpdb->get_results( $wpdb->prepare(
						"SELECT p.ID, p.post_author, pm.meta_value, p.post_date FROM $wpdb->posts as p 
						INNER JOIN $wpdb->postmeta as pm  
							ON ( p.ID = pm.post_id )
						INNER JOIN $wpdb->postmeta as pm2 
							ON ( pm.post_id = pm2.post_id ) 
						WHERE p.post_type = %s 
						and p.post_status = %s
						and pm.meta_key = %s
						and pm.meta_value >= %s
						and pm.meta_value <= %s
						and pm2.meta_key = %s
						and pm2.meta_value = 0",
						"pointfindermorders",
						"completed",
						"pointfinder_order_expiredate",
						$exptime,
						$exptime2,
						"pointfinder_order_recurring"
						)
					,'OBJECT_K' );

					if (PFControlEmptyArr($results)) {
						foreach ($results as $result) {
							
							$user_info = get_userdata( $result->post_author);

								$mail_ok = 0;

								if ( PFcheck_postmeta_exist('pointfinder_order_exemail', $result->ID) ) { 

									$mail_info = get_post_meta( $result->ID, 'pointfinder_order_exemail',true); 
									
									if (!empty($mail_info)) {
										$mail_info = json_decode($mail_info,true);
									}
									

									if (is_array($mail_info)) {
										$mail_info_count = count($mail_info);

										if ($mail_info_count > 0) {
											$mail_info_date = (isset($mail_info[($mail_info_count-1)]['date']))? $mail_info[($mail_info_count-1)]['date'] : 0;
										}else{
											$mail_info_date = 0;
										}

										if ($mail_info_date != 0 && strtotime($mail_info_date) < strtotime(date("Y-m-d"))) {
											$mail_ok = 1;
											$mail_info[$mail_info_count] = array('date'=>date("Y-m-d"));
											delete_post_meta($result->ID, 'pointfinder_order_exemail');
											add_post_meta($result->ID, 'pointfinder_order_exemail', json_encode($mail_info) );	
										}

									}

								}else{
									$mail_info = array();
									$mail_info[] = array('date'=>date("Y-m-d"));
									add_post_meta($result->ID, 'pointfinder_item_exemail', json_encode($mail_info));
									$mail_ok = 1;
								}

								if ($mail_ok == 1) {
									$packageid = get_post_meta($result->ID,'pointfinder_order_packageid',true );
									$packageinfo = pointfinder_membership_package_details_get($packageid);

									pointfinder_mailsystem_mailsender(
										array(
										'toemail' => $user_info->user_email,
								        'predefined' => 'directbeforeexpiremember',
								        'data' => array(
								        	'orderid' => $result->ID, 
									    	'expiredate' => PFU_DateformatS($result->meta_value),
									    	'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],
									    	'packagename' => $packageinfo['webbupointfinder_mp_title']
								        	),
										)
									);
								}
							

						}/*Foreach end*/
					}
				}

			}
		/**
		*End: Check expiring packages and send email 1 day before.
		**/

	/**
	*End: Membership System Schedule
	**/

}else{

	/**
	*Start: Pay per post Schedule
	**/

		/**
		*Start: Check Pending Orders and Delete if they reached waiting limit.
		**/
			add_action( 'pointfinder_schedule_hooks_hourly', 'pointfinder_clean_pending_orders' );

			function pointfinder_clean_pending_orders() {
				/* 
				Clean orders if waited longer then 10 days & if status is pending payment.
				This function will remove the old pendingpayment records from system.
				*/

				$setup31_userpayments_pendinglimit = PFSAIssetControl('setup31_userpayments_pendinglimit','','10');

				if ($setup31_userpayments_pendinglimit > 0) {
					$exptime = date("Y-m-d",strtotime("-".$setup31_userpayments_pendinglimit." days"));
					global $wpdb;
					$results = $wpdb->get_results( $wpdb->prepare( 
						"SELECT p.ID, p.post_author, pm.meta_value, p.post_date 
						FROM $wpdb->posts as p 
						INNER JOIN $wpdb->postmeta as pm  
						ON ( p.ID = pm.post_id ) 
						WHERE p.post_type = %s and p.post_status = %s and p.post_parent = %d  and p.post_date <= %s and pm.meta_key = %s", 
						'pointfinderorders',
						'pendingpayment',
						0,
						$exptime,
						'pointfinder_order_itemid'	
					),'OBJECT_K' );
					
					if (PFControlEmptyArr($results)) {
						foreach ($results as $result) {
							/*Delete Images First*/
							$delete_item_images = get_post_meta($result->meta_value, 'webbupointfinder_item_images');
							if(!empty($delete_item_images)){
								foreach ($delete_item_images as $item_image) {
									wp_delete_attachment(esc_attr($item_image),true);
								}
							}
							wp_delete_attachment(get_post_thumbnail_id( $result->meta_value ),true);

							/*Delete Post*/
							$delete_item_images = get_post_meta($result->meta_value, 'webbupointfinder_item_images');
							if (!empty($delete_item_images)) {
								foreach ($delete_item_images as $item_image) {
									wp_delete_attachment(esc_attr($item_image),true);
								}
							}
							wp_delete_attachment(get_post_thumbnail_id( $result->meta_value ),true);
							wp_delete_post($result->meta_value);

							$wpdb->update($wpdb->posts,array('post_status'=>'pfcancelled'),array('ID'=>$result->ID));
							/* - Creating record for process system. */
							PFCreateProcessRecord(
								array( 
							        'user_id' => $result->post_author,
							        'item_post_id' => $result->meta_value,
									'processname' => sprintf(esc_html__('Item deleted by Auto System: (Pendingpayment Waiting Time Reached/ Order : Cancelled.). (Order Date: %s)','pointfindert2d'),$result->post_date)
							    )
							);
						}	
					}
					
				}
				
			}
		/**
		*End: Check Pending Orders and Delete if they reached waiting limit.
		**/



		/**
		*Start: Check Expired Items & Expire
		**/
			add_action( 'pointfinder_schedule_hooks_hourly', 'pointfinder_check_expires' );
			/*add_action( 'init', 'pointfinder_check_expires' );*/
			function pointfinder_check_expires() {
				
				/*
				Direct payment:

					- Change order status to pending payment. 
					- Change Item status to pending payment.
					- Send an email to user.
					- Add a process record for this action.
				*/

				$exptime = date("Y-m-d H:s:i");

				global $wpdb;
				$results = $wpdb->get_results( $wpdb->prepare( 
					"SELECT p.ID, p.post_author, pm.meta_value, p.post_date FROM $wpdb->posts as p 
					INNER JOIN $wpdb->postmeta as pm  
						ON ( p.ID = pm.post_id )
					INNER JOIN $wpdb->postmeta as pm2 
						ON ( pm.post_id = pm2.post_id ) 
					WHERE p.post_type = %s 
					and p.post_status = %s 
					and p.post_parent = %d 
					and pm.meta_key = %s 
					and pm.meta_value <= %s 
					and pm2.meta_key = %s 
					and pm2.meta_value = %d", 
					'pointfinderorders',
					'completed',
					0,
					'pointfinder_order_expiredate',
					$exptime,
					'pointfinder_order_recurring',
					0
				),'OBJECT_K' );

				
				$setup33_emaillimits_listingexpired = PFMSIssetControl('setup33_emaillimits_listingexpired','','1');

				if (PFControlEmptyArr($results)) {
					foreach ($results as $result) {

						$item_id = esc_attr(get_post_meta( $result->ID, 'pointfinder_order_itemid', true ));

						if (  false != get_post_status( $item_id ) ) {
							/* This is direct payment */
							PFExpireItemManual(
							array( 
							    'order_id' => $result->ID,
							    'post_id' => $item_id,
							    'post_author' => $result->post_author,
								'payment_type' => 'direct'
							)
							);

							if ($setup33_emaillimits_listingexpired == 1) {
								$user_info = get_userdata( $result->post_author);
								pointfinder_mailsystem_mailsender(
								array(
								'toemail' => $user_info->user_email,
							    'predefined' => 'directafterexpire',
							    'data' => array('ID' => $item_id, 'expiredate' => $result->meta_value,'orderid' => $result->ID),
								)
								);
							}
						}

					}/*Foreach end*/
				}

			}
		/**
		*End: Check Expired Items & Expire
		**/


		/**
		*Start: Check Expired Featured Items & Expire Featured option - v1.6.4
		**/
			add_action( 'pointfinder_schedule_hooks_hourly', 'pointfinder_check_expires_featured' );
			function pointfinder_check_expires_featured() {
				
				/*
				Direct payment:

					- Change order status to pending payment. 
					- Change Item status to pending payment.
					- Send an email to user.
					- Add a process record for this action.
				*/

				$exptime = date("Y-m-d H:s:i");

				global $wpdb;
				$results = $wpdb->get_results( $wpdb->prepare( 
					"SELECT p.ID, p.post_author, pm.meta_value, p.post_date FROM $wpdb->posts as p 
					INNER JOIN $wpdb->postmeta as pm  
						ON ( p.ID = pm.post_id )
					INNER JOIN $wpdb->postmeta as pm2 
						ON ( pm.post_id = pm2.post_id ) 
					WHERE p.post_type = %s 
					and p.post_status = %s 
					and p.post_parent = %d 
					and pm.meta_key = %s 
					and pm.meta_value <= %s
					and pm2.meta_key = %s 
					and pm2.meta_value = %d",  
					'pointfinderorders',
					'completed',
					0,
					'pointfinder_order_expiredate_featured',
					$exptime,
					'pointfinder_order_frecurring',
					0
				),'OBJECT_K' );

				
				$setup33_emaillimits_listingexpired = PFMSIssetControl('setup33_emaillimits_listingexpired','','1');

				if (PFControlEmptyArr($results)) {
					foreach ($results as $result) {
						
						$item_id = esc_attr(get_post_meta( $result->ID, 'pointfinder_order_itemid', true ));
						
						update_post_meta($result->ID, 'pointfinder_order_featured', 0);
						delete_post_meta($result->ID, 'pointfinder_order_expiredate_featured');
						update_post_meta($item_id, 'webbupointfinder_item_featuredmarker', 0);


						PFCreateProcessRecord(
							array( 
						        'user_id' => $result->post_author,
						        'item_post_id' => $item_id,
								'processname' => esc_html__('Featured Item option expired and disabled by Auto System','pointfindert2d')
						    )
						);
											

						if ($setup33_emaillimits_listingexpired == 1) {
							/*$user_info = get_userdata( $result->post_author);
							pointfinder_mailsystem_mailsender(
							array(
							'toemail' => $user_info->user_email,
						    'predefined' => 'directafterexpire',
						    'data' => array('ID' => $item_id, 'expiredate' => $result->meta_value,'orderid' => $result->ID),
							)
							);*/
						}
						

					}/*Foreach end*/
				}

			}
		/**
		*End: Check Expired Featured Items & Expire Featured option
		**/



		/**
		*Start: Check expiring items and send email 1 day before.
		**/
			add_action( 'pointfinder_schedule_hooks_daily', 'pointfinder_check_expiring' );

			function pointfinder_check_expiring() {
				
				/*
				Only for Direct payments. And this schedule will check item 1 day before expire.
				*/
				$setup33_emaillimits_listingautowarning = PFMSIssetControl('setup33_emaillimits_listingautowarning','','1');
				if ($setup33_emaillimits_listingautowarning == 1) {
					$exptime = strtotime(date("Y-m-d H:s:i", strtotime("-1 day")));
					$exptime = date('Y-m-d H:s:i',mktime(23,59,59,date('m',$exptime),date('d',$exptime),date('Y',$exptime)) );

					$exptime2 = strtotime(date("Y-m-d H:s:i", strtotime("+1 day")));
					$exptime2 = date('Y-m-d H:s:i',mktime(23,59,59,date('m',$exptime2),date('d',$exptime2),date('Y',$exptime2)) );

					global $wpdb;
					$results = $wpdb->get_results( $wpdb->prepare(
						"SELECT p.ID, p.post_author, pm.meta_value, p.post_date FROM $wpdb->posts as p 
						INNER JOIN $wpdb->postmeta as pm  
							ON ( p.ID = pm.post_id )
						INNER JOIN $wpdb->postmeta as pm2 
							ON ( pm.post_id = pm2.post_id ) 
						WHERE p.post_type = %s 
						and p.post_status = %s
						and p.post_parent = %d 
						and pm.meta_key = %s
						and pm.meta_value >= %s
						and pm.meta_value <= %s
						and pm2.meta_key = %s
						and pm2.meta_value = 0",
						"pointfinderorders",
						"completed",
						0,
						"pointfinder_order_expiredate",
						$exptime,
						$exptime2,
						"pointfinder_order_recurring"
						)
					,'OBJECT_K' );

					if (PFControlEmptyArr($results)) {
						foreach ($results as $result) {
							
							$user_info = get_userdata( $result->post_author);
							$item_id = esc_attr(get_post_meta( $result->ID, 'pointfinder_order_itemid', true ));

							if (  false != get_post_status( $item_id ) ) {
								
								$mail_ok = 0;

								if ( PFcheck_postmeta_exist('webbupointfinder_item_exemail', $item_id) ) { 

									$mail_info = get_post_meta( $item_id, 'webbupointfinder_item_exemail',true); 
									
									if (!empty($mail_info)) {
										$mail_info = json_decode($mail_info,true);
									}
									

									if (is_array($mail_info)) {
										$mail_info_count = count($mail_info);

										if ($mail_info_count > 0) {
											$mail_info_date = (isset($mail_info[($mail_info_count-1)]['date']))? $mail_info[($mail_info_count-1)]['date'] : 0;
										}else{
											$mail_info_date = 0;
										}

										if ($mail_info_date != 0 && strtotime($mail_info_date) < strtotime(date("Y-m-d"))) {
											$mail_ok = 1;
											$mail_info[$mail_info_count] = array('date'=>date("Y-m-d"));
											delete_post_meta($item_id, 'webbupointfinder_item_exemail');
											add_post_meta($item_id, 'webbupointfinder_item_exemail', json_encode($mail_info) );	
										}

									}

								}else{
									$mail_info = array();
									$mail_info[] = array('date'=>date("Y-m-d"));
									add_post_meta($item_id, 'webbupointfinder_item_exemail', json_encode($mail_info));
									$mail_ok = 1;
								}

								if ($mail_ok == 1) {
									pointfinder_mailsystem_mailsender(
										array(
										'toemail' => $user_info->user_email,
								        'predefined' => 'directbeforeexpire',
								        'data' => array('ID' => $item_id, 'expiredate' => $result->meta_value,'orderid' => $result->ID),
										)
									);
								}
							}

						}/*Foreach end*/
					}
				}

			}
		/**
		*End: Check expiring items and send email 1 day before.
		**/
	/**
	*End: Pay per post Schedule
	**/

}
	


/**
*Start: Clear unused images from user upload
**/
add_action( 'pointfinder_schedule_hooks_daily', 'pointfinder_clear_unusedimages' );
function pointfinder_clear_unusedimages() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( 
		"SELECT post_id FROM $wpdb->postmeta where meta_key = %s and meta_value = %d",
		"pointfinder_delete_unused",
		1
	),'OBJECT_K' );
	print_r($results);
	if (PFControlEmptyArr($results)) {
		foreach ($results as $result) {
			delete_post_meta( $result->post_id, 'pointfinder_delete_unused');
			wp_delete_attachment( $result->post_id);
		}
	}
}
/**
*End: Clear unused images from user upload
**/

?>