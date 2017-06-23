<?php
/**********************************************************************************************************************************
*
* Custom Detail Fields Frontend Class
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if ( ! class_exists( 'PF_Frontend_Fields' ) ){
	class PF_Frontend_Fields
	{
		public $FieldOutput;
		public $ScriptOutput;
		public $ScriptOutputDocReady;
		public $VSORules;
		public $VSOMessages;
		public $PFHalf = 1;
		private $itemrecurringstatus = 0;

		function __construct($params = array()){	

			$defaults = array( 
		        'fields' => '',
		        'formtype' => '',
		        'sccval' => '',
				'errorval' => '',
				'post_id' => '',
				'sheader' => '',
				'sheadermes' => '',
				'current_user' => '',
				'dontshowpage' => 0,
				'redirect' => false
		    );

		    $params = array_merge($defaults, $params);

		    $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
			$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
			$pfmenu_perout = PFPermalinkCheck();

			$lang_custom = '';

			if(function_exists('icl_t')) {
				$lang_custom = PF_current_language();
			}

			/**
			*Start: Page Header Actions / Divs / Etc...
			**/ 
				$this->FieldOutput = '<div class="golden-forms">';
				if ($params['formtype'] == 'myitems') {
					$this->FieldOutput .= '<form id="pfuaprofileform" enctype="multipart/form-data" name="pfuaprofileform" method="GET" action=""><input type="hidden" value="myitems" name="ua">';
				}else{
					$this->FieldOutput .= '<form id="pfuaprofileform" enctype="multipart/form-data" name="pfuaprofileform" method="POST" action="">';
				}
				
				$this->FieldOutput .= '<div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button">'.esc_html__('CLOSE','pointfindert2d').'</a></div>';
				if($params['sccval'] != ''){
					$this->FieldOutput .= '<div class="notification success" id="pfuaprofileform-notify"><div class="row"><p>'.$params['sccval'].'<br>'.$params['sheadermes'].'</p></div></div>';
					$this->ScriptOutput .= '$(document).ready(function(){$.pfmessagehide();});';
				}
				if($params['errorval'] != ''){
					$this->FieldOutput .= '<div class="notification error" id="pfuaprofileform-notify"><p>'.$params['errorval'].'</p></div>';
					$this->ScriptOutput .= '$(document).ready(function(){$.pfmessagehide();});';
				}
				$this->FieldOutput .= '<div class="">';
				$this->FieldOutput .= '<div class="">';
				$this->FieldOutput .= '<div class="row">';

			/**
			*End: Page Header Actions / Divs / Etc...
			**/
				$main_submit_permission = true;
				$main_package_purchase_permission = false;
				$main_package_renew_permission = false;
				$main_package_limit_permission = false;
				$main_package_upgrade_permission = false;
				$main_package_expire_problem = false;

				$hide_button = false;
				switch ($params['formtype']) {
					case 'purchaseplan':
					case 'renewplan':
					case 'upgradeplan':
						$formaction = 'pfget_membershipsystem';
						$noncefield = wp_create_nonce($formaction);
						$free_membership = false;
						/**
						*Start: Purchase Plan Content
						**/
							/*If membership activated*/
							$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
							$user_idx = $params['current_user']; 
							$membership_user_package_id = get_user_meta( $user_idx, 'membership_user_package_id', true );
							$membership_user_package = get_user_meta( $user_idx, 'membership_user_package', true );
							$membership_user_item_limit = get_user_meta( $user_idx, 'membership_user_item_limit', true );
							$membership_user_featureditem_limit = get_user_meta( $user_idx, 'membership_user_featureditem_limit', true );
							$membership_user_image_limit = get_user_meta( $user_idx, 'membership_user_image_limit', true );
							$membership_user_trialperiod = get_user_meta( $user_idx, 'membership_user_trialperiod', true );

							$membership_user_activeorder = get_user_meta( $user_idx, 'membership_user_activeorder', true );
							$membership_user_expiredate = get_post_meta( $membership_user_activeorder, 'pointfinder_order_expiredate', true );
							$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');


							if(empty($membership_user_package_id) && $params['formtype'] == 'purchaseplan'){
								$main_package_purchase_permission = true;
							}
							if ($params['formtype'] == 'renewplan' && !empty($membership_user_package_id)) {
								$main_package_renew_permission = true;
							}elseif ($params['formtype'] == 'renewplan' && empty($membership_user_package_id)){
								$main_package_renew_permission = false;
								$main_package_purchase_permission = true;
								$params['formtype'] = 'purchaseplan';
							}
							if ($params['formtype'] == 'upgradeplan' && !empty($membership_user_package_id)) {
								$main_package_upgrade_permission = true;
							}elseif ($params['formtype'] == 'upgradeplan' && empty($membership_user_package_id)){
								$main_package_upgrade_permission = false;
								$main_package_purchase_permission = true;
								$params['formtype'] = 'purchaseplan';
							}
							

							/*
							* Start: Order removed expire problem - Membership package
							*/
								if ($main_package_expire_problem) {
									$hide_button = true;
									echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("Please contact with your site Admin. Your membership order have problem.","pointfindert2d").'</div>';
								}
							/*
							* End: Order removed expire problem - Membership package
							*/


							/*
							* Start: Show Limit Full Message - Membership package
							*/
								if ($main_package_limit_permission) {
									$hide_button = true;
									echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("Your membership plan limits reached. Please upgrade your package or contact with your site admin.","pointfindert2d").'</div>';
								}
							/*
							* End: Show Limit Full Message - Membership package
							*/


							/*
							* Start: Purchase Membership package
							*/
								if ($main_package_purchase_permission == true || $main_package_upgrade_permission == true || $main_package_renew_permission == true) {

									$p_continue = true;
									
									switch ($params['formtype']) {
										case 'purchaseplan':
											$buttonid = 'pf-ajax-purchasepack-button';
											$buttontext = esc_html__('Complete Purchase',"pointfindert2d"  );
											break;
										
										case 'renewplan':
											$buttonid = 'pf-ajax-purchasepack-button';
											$buttontext = esc_html__('Renew Plan',"pointfindert2d"  );
											break;

										case 'upgradeplan':
											$buttonid = 'pf-ajax-purchasepack-button';
											$buttontext = esc_html__('Upgrade Plan',"pointfindert2d"  );
											break;
									}
									
									if($p_continue){
										/** 
										*Purchase Membership Package 
										**/
												$is_pack = 0;
												
												switch ($params['formtype']) {
													case 'purchaseplan':
														$membership_query = new WP_Query(array('post_type' => 'pfmembershippacks','posts_per_page' => -1,'order_by'=>'ID','order'=>'ASC'));
														break;
													
													case 'renewplan':
														$stp31_userfree = PFSAIssetControl("stp31_userfree","","0");
														if ($stp31_userfree == 0) {
															$membership_query = new WP_Query(array(
															'post_type' => 'pfmembershippacks',
															'posts_per_page' => -1,
															'order_by'=>'ID',
															'order'=>'ASC',
															'p'=>$membership_user_package_id,
															'meta_query' => array(
																'relation' => 'AND',
																array(
																	'key'     => 'webbupointfinder_mp_showhide',
																	'value'   => 1,
																	'compare' => '=',
																	'type' => 'NUMERIC'
																),
																array(
																	'key'     => 'webbupointfinder_mp_price',
																	'value'   => 0,
																	'compare' => '>',
																	'type' => 'NUMERIC'
																),

															),
															));
														}else{
															$membership_query = new WP_Query(array(
															'post_type' => 'pfmembershippacks',
															'posts_per_page' => -1,
															'order_by'=>'ID',
															'order'=>'ASC',
															'p'=>$membership_user_package_id,
															'meta_query' => 
																array(
																	'key'     => 'webbupointfinder_mp_showhide',
																	'value'   => 1,
																	'compare' => '=',
																	'type' => 'NUMERIC'
																)
															));
														}
														
														
														break;

													case 'upgradeplan':

														$total_icounts = pointfinder_membership_count_ui($user_idx);

														/*Count User's Items*/
														$user_post_count = 0;
														$user_post_count = $total_icounts['item_count'];

														/*Count User's Featured Items*/
														$users_post_featured = 0;
														$users_post_featured = $total_icounts['fitem_count'];

														
														if ($user_post_count == 0 && $users_post_featured == 0) {
															$membership_query = new WP_Query(array(
																'post_type' => 'pfmembershippacks',
																'posts_per_page' => -1,
																'order_by'=>'ID',
																'order'=>'ASC',
																'post__not_in' => array($membership_user_package_id),
																'meta_query' => array(
																	
																	'relation' => 'AND',
																	array(
																		'relation' => 'OR',
																		array(
																			'key'     => 'webbupointfinder_mp_itemnumber',
																			'value'   => $user_post_count,
																			'compare' => '>=',
																			'type' => 'NUMERIC'
																		),
																		array(
																			'key'     => 'webbupointfinder_mp_itemnumber',
																			'value'   => 0,
																			'compare' => '<',
																			'type' => 'NUMERIC'
																		)
																	),
																	array(
																		'key'     => 'webbupointfinder_mp_fitemnumber',
																		'value'   => $users_post_featured,
																		'compare' => '>=',
																		'type' => 'NUMERIC'
																	),
																	array(
																		'key'     => 'webbupointfinder_mp_showhide',
																		'value'   => 1,
																		'compare' => '=',
																		'type' => 'NUMERIC'
																	),
																	array(
																		'key'     => 'webbupointfinder_mp_price',
																		'value'   => 0,
																		'compare' => '>',
																		'type' => 'NUMERIC'
																	),

																),
															));
														}else{
															$membership_query = new WP_Query(array(
																'post_type' => 'pfmembershippacks',
																'posts_per_page' => -1,
																'order_by'=>'ID',
																'order'=>'ASC',
																'post__not_in' => array($membership_user_package_id),
																'meta_query' => array(
																	
																	'relation' => 'AND',
																	array(
																		'relation' => 'OR',
																		array(
																			'key'     => 'webbupointfinder_mp_itemnumber',
																			'value'   => $user_post_count,
																			'compare' => '>=',
																			'type' => 'NUMERIC'
																		),
																		array(
																			'key'     => 'webbupointfinder_mp_itemnumber',
																			'value'   => 0,
																			'compare' => '<',
																			'type' => 'NUMERIC'
																		)
																	),
																	array(
																		'key'     => 'webbupointfinder_mp_fitemnumber',
																		'value'   => $users_post_featured,
																		'compare' => '>=',
																		'type' => 'NUMERIC'
																	),
																	array(
																		'key'     => 'webbupointfinder_mp_images',
																		'value'   => $membership_user_image_limit,
																		'compare' => '>=',
																		'type' => 'NUMERIC'
																	),
																	array(
																		'key'     => 'webbupointfinder_mp_showhide',
																		'value'   => 1,
																		'compare' => '=',
																		'type' => 'NUMERIC'
																	),

																),
															));
														}
														
														
														break;
												}

												/*print_r($membership_query->request);*/
												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-title-membershippack"><i class="pfadmicon-glyph-10"></i> '.esc_html__('PLEASE SELECT A PLAN','pointfindert2d').'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-membership">';
												if ($params['formtype'] == "renewplan") {
													if (!$membership_query->have_posts()) {
														$this->FieldOutput .= '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("Free plan can't renew. Please try to upgrade.","pointfindert2d").'</div>';
														$free_membership = true;
														$this->ScriptOutput = 'window.location = "'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=upgradeplan'.'"';
													}else{
														$this->ScriptOutput = "$.pfmembershipgetp(".$membership_user_package_id.",'".$params['formtype']."');";
														$this->FieldOutput .= '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("You can only select your current plan. If want to change with another plan, please try to upgrade.","pointfindert2d").'</div>';
													}
												}
												if ($params['formtype'] == "upgradeplan" && $membership_query->have_posts()) {
													if ($user_post_count == 0 && $users_post_featured == 0) {
														/*$this->FieldOutput .= '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.sprintf(esc_html__("Your current limits require %d item and %d featured item limit. Only below packages available for upgrade. You can remove some items if want to use lower limited packages.","pointfindert2d"),$user_post_count,$users_post_featured).'</div>';*/
													}else{
														$this->FieldOutput .= '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.sprintf(esc_html__("Your current limits require %d item and %d featured item and %d image limit. Only below packages available for upgrade. You can remove some items if want to use lower limited packages.","pointfindert2d"),$user_post_count,$users_post_featured,$membership_user_image_limit).'</div>';
													}
												}
												if ($params['formtype'] == "upgradeplan" && !$membership_query->have_posts()) {
													$this->FieldOutput .= '<div class="pf-dash-errorview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.sprintf(esc_html__("We can't find an available plan for you. Your current limits require %d item and %d featured item and %d image limit. Please try to remove some items or contact with administrator of your site.","pointfindert2d"),$user_post_count,$users_post_featured,$membership_user_image_limit).'</div>';
												}
												if ( $membership_query->have_posts() ) {
												  $this->FieldOutput .= '<ul class="pf-membership-package-list">';
												 
												  while ( $membership_query->have_posts() ) {
												    $membership_query->the_post();

												    $post_id = get_the_id();

												    $packageinfo = pointfinder_membership_package_details_get($post_id);

												    if ($packageinfo['webbupointfinder_mp_showhide'] == 1) {
													    $this->FieldOutput .= '<li>
													    <div class="pf-membership-package-box">
													    	<div class="pf-membership-package-title">' . get_the_title() . '</div>
													    	<div class="pf-membership-package-info">
																<ul>
																	<li><span class="pf-membership-package-info-title">'.esc_html__('Price:','pointfindert2d').' </span> '.$packageinfo['packageinfo_priceoutput_text'].'</li>
																	<li><span class="pf-membership-package-info-title">'.esc_html__('Number of listings included in the package:','pointfindert2d').' </span> '.$packageinfo['packageinfo_itemnumber_output_text'].'</li>
																	<li><span class="pf-membership-package-info-title">'.esc_html__('Number of featured listings included in the package:','pointfindert2d').' </span> '.$packageinfo['webbupointfinder_mp_fitemnumber'].'</li>
																	<li><span class="pf-membership-package-info-title">'.esc_html__('Number of images (per listing) included in the package:','pointfindert2d').' </span> '.$packageinfo['webbupointfinder_mp_images'].'</li>
																	<li><span class="pf-membership-package-info-title">'.esc_html__('Listings can be submitted within:','pointfindert2d').' </span> '.$packageinfo['webbupointfinder_mp_billing_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text'].'</li>
																	';
																	if ($packageinfo['webbupointfinder_mp_trial'] == 1 && $packageinfo['packageinfo_priceoutput'] != 0) {
																		$this->FieldOutput .= '<li><span class="pf-membership-package-info-title">'.esc_html__('Trial Period:','pointfindert2d').' </span> '.$packageinfo['webbupointfinder_mp_trial_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text'].' <br/><small>'.esc_html__('Note: Your listing will expire end of trial period.','pointfindert2d').'</small></li>';
																	}
																	if (!empty($packageinfo['webbupointfinder_mp_description'])) {
																		$this->FieldOutput .= '<li><span class="pf-membership-package-info-title">'.esc_html__('Description:','pointfindert2d').' </span> '.$packageinfo['webbupointfinder_mp_description'].'</li>';
																	}
																	
																	$this->FieldOutput .= '
																</ul>
													    	</div>
													    	<div class="pf-membership-splan-button">
							                                    <a data-id="'.$post_id.'" data-ptype="'.$params['formtype'].'">'.esc_html__('Select','pointfindert2d').'</a>
							                                </div>
													    </div>
													    </li>';
													    $is_pack++;
													}
												  }
												  if ($is_pack == 0) {
												  	$this->FieldOutput .= esc_html__("Please set visible one of your plans.",'pointfindert2d');
												  }
												  $this->FieldOutput .= '</ul>';
												} else {
													if ($params['formtype'] == 'purchaseplan') {
														$this->FieldOutput .= esc_html__("Please create some membership plans.",'pointfindert2d' );
													}
												  
												}

											$this->FieldOutput .= '</section>';
										/**
										*Purchase Membership Package 
										**/

										/** 
										*PAY Membership Package 
										**/
											$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-title-membershippack-payment"><i class="pfadmicon-glyph-11"></i> '.esc_html__('PLEASE SELECT PAYMENT TYPE','pointfindert2d').'</div>';
											$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-membership-payment">';
													
													$this->FieldOutput .= '<div class="pfm-payment-plans"><div class="pfm-payment-plans-inner">'.esc_html__('Please select a plan for payment options.','pointfindert2d' ).'</div></div>';
													
											$this->PFValidationCheckWrite(1,esc_html__('Please select a payment type.','pointfindert2d' ),'pf_membership_payment_selection');
											$this->PFValidationCheckWrite(1,esc_html__('Please select a plan type','pointfindert2d' ),'selectedpackageid');


											
											
											$this->FieldOutput .= '</section>';
										/**
										*PAY Membership Package 
										**/

										/**
										*Terms and conditions
										**/
											$setup4_mem_terms = PFSAIssetControl('setup4_mem_terms','','1');
											if ($setup4_mem_terms == 1) {

												$this->PFValidationCheckWrite(1,esc_html__('You must accept terms and conditions.','pointfindert2d' ),'pftermsofuser');

												global $wpdb;
												$terms_conditions_template = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s ",'_wp_page_template','terms-conditions.php'), ARRAY_A);
												if (isset($terms_conditions_template[0]['post_id'])) {
													$terms_permalink = get_permalink($terms_conditions_template[0]['post_id']);
												}else{
													$terms_permalink = '#';
												}
												
												
												if ($params['formtype'] == 'edititem') {
													$checktext1 = ' checked=""';
												}else{$checktext1 = '';}
												
												$pfmenu_perout = PFPermalinkCheck();

												$this->FieldOutput .= '<section style="margin-top: 20px;margin-bottom: 10px;">';
												$this->FieldOutput .= '
													<span class="goption upt">
					                                    <label class="options">
					                                        <input type="checkbox" id="pftermsofuser" name="pftermsofuser" value="1"'.$checktext1.'>
					                                        <span class="checkbox"></span>
					                                    </label>
					                                    <label for="check1">'.sprintf(esc_html__( 'I have read the %s terms and conditions %s and accept them.', 'pointfindert2d' ),'<a href="'.$terms_permalink.$pfmenu_perout.'ajax=true&width=800&height=400" rel="prettyPhoto[ajax]"><strong>','</strong></a>').'</label>
					                               </span>
												';
												
								                $this->FieldOutput .= '</section>';
								            }
										/**
										*Terms and conditions
										**/

										
									}
								}elseif (empty($membership_user_package_id) == false && $main_package_purchase_permission == false && $params['formtype'] == 'purchaseplan') {
									$hide_button = true;
									echo '<div class="pf-dash-errorview-plan"><i class="pfadmicon-glyph-485" style="color:black;font-size: 16px;"></i> '.esc_html__("You can't purchase new plan. Because already have one.","pointfindert2d").'</div>';
									$p_continue = false;
								}
							/*
							* End: Purchase - Membership package
							*/



						/**
						*End: Purchase Plan Content
						**/
						break;

					case 'upload':
					case 'edititem':
						/**
						*Start: New Item Page Content
						**/
							global $pointfindertheme_option;

							if($params['formtype'] == 'upload'){
								$formaction = 'pfget_uploaditem';
								$buttonid = 'pf-ajax-uploaditem-button';
								$buttontext = PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','','');
								
							}else{
								$formaction = 'pfget_edititem';
								$buttonid = 'pf-ajax-uploaditem-button';
								$buttontext = PFSAIssetControl('setup29_dashboard_contents_submit_page_titlee','','');

							}

							$noncefield = wp_create_nonce($formaction);


							if ($params['dontshowpage'] != 1) {
							
							wp_enqueue_script('theme-dropzone');
							wp_enqueue_script('theme-google-api');
							wp_enqueue_script('theme-gmap3');
							wp_enqueue_style('theme-dropzone');
							wp_enqueue_script('jquery-ui-core');
							wp_enqueue_script('jquery-ui-datepicker');
							wp_enqueue_style('jquery-ui-smoothnesspf2', get_template_directory_uri() . "/css/jquery-ui.structure.min.css", false, null);
							wp_enqueue_style('jquery-ui-smoothnesspf', get_template_directory_uri() . "/css/jquery-ui.theme.min.css", false, null);

							wp_enqueue_script('jquery-ui-core');
							wp_enqueue_script('jquery-ui-datepicker');
							wp_enqueue_script('jquery-ui-slider');
							wp_register_script('theme-timepicker', get_template_directory_uri() . '/js/jquery-ui-timepicker-addon.js', array('jquery','jquery-ui-datepicker'), '4.0',true); 
							wp_enqueue_script('theme-timepicker');


							

							/* Get Admin Settings for Default Fields */
							$setup4_submitpage_titletip = PFSAIssetControl('setup4_submitpage_titletip','','');
							$maplanguage= PFSAIssetControl('setup5_mapsettings_maplanguage','','en');
							
							/*If membership activated*/
							$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
							if ($setup4_membersettings_paymentsystem == 2) {
								$user_idx = $params['current_user']; 
								$membership_user_package_id = get_user_meta( $user_idx, 'membership_user_package_id', true );

								if (!empty($membership_user_package_id)) {
									$packageinfo = pointfinder_membership_package_details_get($membership_user_package_id);
								}
								$membership_user_package = get_user_meta( $user_idx, 'membership_user_package', true );
								$membership_user_item_limit = get_user_meta( $user_idx, 'membership_user_item_limit', true );
								$membership_user_featureditem_limit = get_user_meta( $user_idx, 'membership_user_featureditem_limit', true );
								$membership_user_image_limit = get_user_meta( $user_idx, 'membership_user_image_limit', true );
								$membership_user_trialperiod = get_user_meta( $user_idx, 'membership_user_trialperiod', true );

								$membership_user_activeorder = get_user_meta( $user_idx, 'membership_user_activeorder', true );
								$membership_user_expiredate = get_post_meta( $membership_user_activeorder, 'pointfinder_order_expiredate', true );
							}

							$current_post_status = get_post_status($params['post_id']);
							if ($params['post_id'] != '') {

								$order_id_current = PFU_GetOrderID($params['post_id'],1);

								$is_this_itemrecurring = get_post_meta( $order_id_current, 'pointfinder_order_recurring', true );
								if ($is_this_itemrecurring == false) {
									$is_this_itemrecurring = get_post_meta( $order_id_current, 'pointfinder_order_frecurring', true );
								}

								if (($current_post_status == 'publish' || $current_post_status == 'pendingapproval') && !empty($is_this_itemrecurring) ) {
									$this->itemrecurringstatus = 1;
								}

								/* Clean sub order values if exist. */
								$change_value_status = get_post_meta( $order_id_current, "pointfinder_sub_order_change", true);
								
								if ($change_value_status != false) {
									pointfinder_remove_sub_order_metadata($order_id_current);
								}
								
							}

							/*** DEFAULTS FOR FIRST COLUMN ***/
								$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
								$setup4_submitpage_itemtypes_check = PFSAIssetControl('setup4_submitpage_itemtypes_check','','1');
								$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
								$setup4_submitpage_locationtypes_check = PFSAIssetControl('setup4_submitpage_locationtypes_check','','1');
								$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');
								$setup4_submitpage_featurestypes_check = PFSAIssetControl('setup4_submitpage_featurestypes_check','','1');
								$setup4_submitpage_maparea_verror = PFSAIssetControl('setup4_submitpage_maparea_verror','','');
								$st4_sp_med = PFSAIssetControl('st4_sp_med','','1');
								$setup4_submitpage_locationtypes_validation = PFSAIssetControl('setup4_submitpage_locationtypes_validation','','1');
								$setup4_submitpage_locationtypes_verror = PFSAIssetControl('setup4_submitpage_locationtypes_verror','','Please select a location.');
								
								
								$stp4_fupl = PFSAIssetControl("stp4_fupl","","0");

								$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');
								$setup20_paypalsettings_paypal_price_pref = PFSAIssetControl('setup20_paypalsettings_paypal_price_pref','',1);

							/*** DEFAULTS FOR SECOND COLUMN ***/
								$setup4_submitpage_video = PFSAIssetControl('setup4_submitpage_video','','1');
								$setup4_submitpage_imageupload = PFSAIssetControl('setup4_submitpage_imageupload','','1');
								$setup4_submitpage_imagelimit = PFSAIssetControl('setup4_submitpage_imagelimit','','10');
								$setup4_submitpage_messagetorev = PFSAIssetControl('setup4_submitpage_messagetorev','','1');
								$setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','0');
								$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard );
								$setup4_submitpage_featuredverror = PFSAIssetControl('setup4_submitpage_featuredverror','','');
								$setup4_submitpage_featuredverror_status = PFSAIssetControl('setup4_submitpage_featuredverror_status','',1);
								$stp4_err_st = PFSAIssetControl("stp4_err_st","","0");
								$stp4_err = PFSAIssetControl("stp4_err","",esc_html__('Please upload an attachment.', 'pointfindert2d'));
								$pfmenu_perout = PFPermalinkCheck();

								
								$setup4_submitpage_conditions_check = PFSAIssetControl('setup4_submitpage_conditions_check','',0);
								$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);
								$st4_sp_med2 = PFSAIssetControl('st4_sp_med2','',1);

								$package_featuredcheck = '';
								if ($params['post_id'] != '') {
									$package_featuredcheck = get_post_meta( $params['post_id'], 'webbupointfinder_item_featuredmarker', true );
								}

								$default_package = 1;

								if ($params['post_id'] != '' && $setup4_membersettings_paymentsystem == 1) {
									$default_package_meta = get_post_meta( PFU_GetOrderID($params['post_id'],1), 'pointfinder_order_listingpid',true);
									
									if (!empty($default_package_meta)) {
										if ($default_package_meta == 1 || $default_package_meta == 2) {
											$default_package = 1;
										}else{
											$default_package = $default_package_meta;
										}
									}
								}

							

							if ($setup4_membersettings_paymentsystem == 2) {
								if(empty($membership_user_package_id)){
									$main_submit_permission = false;
									$main_package_purchase_permission = true;
								}else{
									
									if (!empty($membership_user_expiredate)) {
										if (pf_membership_expire_check($membership_user_expiredate)) {
											$main_submit_permission = false;
											$main_package_renew_permission = true;
										}else{
											if ($membership_user_item_limit == 0 && $params['formtype'] == 'upload') {
												$main_submit_permission = false;
												$main_package_limit_permission = true;
											}elseif ($membership_user_item_limit == -1 && $params['formtype'] == 'upload') {
												$main_submit_permission = true;
											}
											
										}
									} else {
										$main_submit_permission = false;
										$main_package_expire_problem = true;
									}
									

									$setup4_submitpage_imagelimit = $membership_user_image_limit;
								}
								
							}

							if ($setup4_membersettings_paymentsystem == 2) {

								/*
								* Start: Order removed expire problem - Membership package
								*/
									if ($main_package_expire_problem) {
										$hide_button = true;
										echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("Please contact with your site Admin. Your membership order have problem.","pointfindert2d").'</div>';
									}
								/*
								* End: Order removed expire problem - Membership package
								*/


								/*
								* Start: Show Limit Full Message - Membership package
								*/
									if ($main_package_limit_permission) {
										$hide_button = true;
										echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("Your membership plan limits reached. Please upgrade your package or contact with your site admin.","pointfindert2d").'</div>';
									}
								/*
								* End: Show Limit Full Message - Membership package
								*/


								/*
								* Start: Renew Membership package
								*/
									if ($main_package_renew_permission) {
										echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("Your membership plan expired. You are redirecting...","pointfindert2d").'</div>';
										echo '<script>window.location = "'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=renewplan'.'";</script>';}
								/*
								* End: Renew Membership package
								*/


								/*
								* Start: Upgrade Membership package
								*/
									if ($main_package_upgrade_permission) {
										echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("You are redirecting to Upgrade area...","pointfindert2d").'</div>';
										echo '<script>window.location = "'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=upgradeplan'.'";</script>';}
								/*
								* End: Upgrade Membership package
								*/

								/*
								* Start: Purchase Membership package
								*/
									if ($main_package_purchase_permission) {
										echo '<div class="pf-dash-errorview-plan pf-dash-infoview-plan"><i class="pfadmicon-glyph-482" style="color:black;font-size: 16px;"></i> '.esc_html__("You should purchase a new membership plan. You are redirecting...","pointfindert2d").'</div>';
										echo '<script>window.location = "'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=purchaseplan'.'";</script>';}
								/*
								* End: Purchase Membership package
								*/
							}


							if ($main_submit_permission) {
								/** 
								*Start : First Column (Custom Fields)
								**/
							            $is_editor=current_user_can( 'edit_others_posts' );
							            
										if ($this->itemrecurringstatus == 1) {
											$this->FieldOutput .= '<div class="notification warning" style="border:1px solid rgba(255, 206, 94, 0.99)!important" id="pfuaprofileform-notify"><div class="row"><p><i class="pfadmicon-glyph-731"></i> '.esc_html__("You can not change Listing Type, Featured Option and Listing Plan while this item using recurring payment. Please cancel recurring payment option for change these values.",'pointfindert2d').'<br></p></div></div>';
										}
										if ($is_editor )
										{
										/**
										*Listing Types
										**/
											$setup4_submitpage_listingtypes_title = PFSAIssetControl('setup4_submitpage_listingtypes_title','','Listing Type');
											$setup4_submitpage_sublistingtypes_title = PFSAIssetControl('setup4_submitpage_sublistingtypes_title','','Sub Listing Type');
											$setup4_submitpage_subsublistingtypes_title = PFSAIssetControl('setup4_submitpage_subsublistingtypes_title','','Sub Sub Listing Type');
											$setup4_submitpage_listingtypes_verror = PFSAIssetControl('setup4_submitpage_listingtypes_verror','','Please select a listing type.');
											$stp4_forceu = PFSAIssetControl('stp4_forceu','',0);

											$setup4_ppp_catprice = PFSAIssetControl('setup4_ppp_catprice','','0');

											$itemfieldname = 'pfupload_listingtypes';
											$this_cat_price_output = $status_selector = $status_pc = '';

											$this->PFValidationCheckWrite(1,$setup4_submitpage_listingtypes_verror,$itemfieldname);

											$item_defaultvalue = ($params['post_id'] != '') ? wp_get_post_terms($params['post_id'], 'pointfinderltypes', array("fields" => "ids")) : '' ;
											$item_defaultvalue_output = $sub_level = $sub_sub_level = $item_defaultvalue_output_orj = '';


											
											/* Get Prices For All Cats & Category options for this listing */
											
											$cat_extra_opts = get_option('pointfinderltypes_covars');
											$item_level_value = 0;
											if (count($item_defaultvalue) > 1) {
												if (isset($item_defaultvalue[0])) {
													$item_defaultvalue_output_orj = $item_defaultvalue[0];
													$find_top_parent = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');

													$ci=1;
													foreach ($item_defaultvalue as $value) {
														$sub_level .= $value;
														if ($ci < count($item_defaultvalue)) {
															$sub_level .= ',';
														}
														$ci++;
													}
													$item_defaultvalue_output = $find_top_parent['parent'];
													$item_level_value = (isset($find_top_parent['level']))?$find_top_parent['level']:0;
												}
											}else{
												if (isset($item_defaultvalue[0])) {
													$item_defaultvalue_output_orj = $item_defaultvalue[0];
													$find_top_parent = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');

													switch ($find_top_parent['level']) {
														case '1':
															$sub_level = $item_defaultvalue[0];
															break;
														
														case '2':
															$sub_sub_level = $item_defaultvalue[0];
															$sub_level = pf_get_term_top_parent($item_defaultvalue[0],'pointfinderltypes');
															break;
													}
													

													$item_defaultvalue_output = $find_top_parent['parent'];
													$item_level_value = (isset($find_top_parent['level']))?$find_top_parent['level']:0;
												}
											}
											
											$this->FieldOutput .= '<div class="pfsubmit-title">'.$setup4_submitpage_listingtypes_title.'</div>';
											$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-listingtype pferrorcontainer">';
											$this->FieldOutput .= '<section class="pfsubmit-inner-sub" style="margin-left: -10px!important;">';

												$listingtype_values = get_terms('pointfinderltypes',array('hide_empty'=>false,'parent'=> 0)); 
												
												$this->FieldOutput .= '<input type="hidden" name="pfupload_listingtypes" id="pfupload_listingtypes" value="'.$item_defaultvalue_output.'"/>';
												$this->FieldOutput .= '<input type="hidden" name="pfupload_listingpid" id="pfupload_listingpid" value="'.$params['post_id'].'"/>';
												$this->FieldOutput .= '<input type="hidden" name="pfupload_type" id="pfupload_type" value="'.$setup4_membersettings_paymentsystem .'"/>';

												if ($params['formtype'] == 'edititem' && $current_post_status != 'pendingpayment' && $setup4_ppp_catprice == 1 && $setup4_membersettings_paymentsystem == 1) {
													$control_cat_price = (isset($cat_extra_opts[$item_defaultvalue_output]['pf_categoryprice']))?$cat_extra_opts[$item_defaultvalue_output]['pf_categoryprice']:0;
													if ($control_cat_price != 0) {
														$status_selector = ' disabled="disabled"';
														$status_pc = 1;
													}
												}

												if ($this->itemrecurringstatus == 1) {
													$status_selector = ' disabled="disabled"';
												}

												if ($params['post_id'] != '') {
													$this->FieldOutput .= '<input type="hidden" name="pfupload_o" id="pfupload_o" value="'.PFU_GetOrderID($params['post_id'],1).'"/>';
												}

												if ($current_post_status != 'pendingpayment' && $params['formtype'] == 'edititem') {
													$this->FieldOutput .= '<input type="hidden" name="pfupload_c" id="pfupload_c" value="'.$status_pc.'"/>';
													$this->FieldOutput .= '<input type="hidden" name="pfupload_f" id="pfupload_f" value="'.$package_featuredcheck.'"/>';
													$this->FieldOutput .= '<input type="hidden" name="pfupload_p" id="pfupload_p" value="'.$default_package.'"/>';
												}else{
													$this->FieldOutput .= '<input type="hidden" name="pfupload_c" id="pfupload_c" />';
													$this->FieldOutput .= '<input type="hidden" name="pfupload_f" id="pfupload_f" />';
													$this->FieldOutput .= '<input type="hidden" name="pfupload_p" id="pfupload_p" />';
													if ($params['formtype'] == 'edititem') {
														$this->ScriptOutput .= "$(document).ready(function(){
														$.pf_get_priceoutput();
													});";
													}
													
												}
												if ($params['formtype'] == 'edititem' && $current_post_status != 'pendingpayment'){
													$this->FieldOutput .= '<input type="hidden" name="pfupload_px" id="pfupload_px" value="1"/>';
												}
												
												

												$this->FieldOutput .= '<div class="pflistingtype-selector-main-top clearfix">';

												$subcatsarray = "var pfsubcatselect = [";
												$multiplesarray = "var pfmultipleselect = [";

												
												foreach ($listingtype_values as $listingtype_value) {
													
													/* Multiple select & Subcat Select */
													$multiple_select = (isset($cat_extra_opts[$listingtype_value->term_id]['pf_multipleselect']))?$cat_extra_opts[$listingtype_value->term_id]['pf_multipleselect']:2;
													$subcat_select = (isset($cat_extra_opts[$listingtype_value->term_id]['pf_subcatselect']))?$cat_extra_opts[$listingtype_value->term_id]['pf_subcatselect']:2;

													if ($multiple_select == 1) {$multiplesarray .= $listingtype_value->term_id.',';}
													if ($subcat_select == 1) {$subcatsarray .= $listingtype_value->term_id.',';}

													if ($setup4_ppp_catprice == 1 && $setup4_membersettings_paymentsystem == 1) {
														$this_cat_price = (isset($cat_extra_opts[$listingtype_value->term_id]['pf_categoryprice']))?$cat_extra_opts[$listingtype_value->term_id]['pf_categoryprice']:0;
														if ($this_cat_price == 0) {
															$this_cat_price_output = '';
														}else{
															if ($setup20_paypalsettings_paypal_price_pref == 1) {
																$this_cat_price_output = ' <span style="font-weight:600;" title="'.esc_html__("This category price is ",'pointfindert2d' ).'('.$setup20_paypalsettings_paypal_price_short.$this_cat_price.')'.'">('.$setup20_paypalsettings_paypal_price_short.$this_cat_price.')</span>';
															}else{
																$this_cat_price_output = ' <span style="font-weight:600;" title="'.esc_html__("This category price is ",'pointfindert2d' ).'('.$this_cat_price.$setup20_paypalsettings_paypal_price_short.')'.'">('.$this_cat_price.$setup20_paypalsettings_paypal_price_short.')</span>';
															}
														}
													}

													
													$this->FieldOutput .= '<div class="pflistingtype-selector-main">';
													$this->FieldOutput .= '<input type="radio" name="radio" id="pfltypeselector'.$listingtype_value->term_id.'" class="pflistingtypeselector"'.$status_selector.' value="'.$listingtype_value->term_id.'" '.checked( $item_defaultvalue_output, $listingtype_value->term_id, 0 ).'/>';
													$this->FieldOutput .= '<label for="pfltypeselector'.$listingtype_value->term_id.'" style="font-weight:600;">'.$listingtype_value->name.$this_cat_price_output.'</label>';
													$this->FieldOutput .= '</div>';
													
												}

												$this->FieldOutput .= '</div>';
												$subcatsarray .= "];";
												$multiplesarray .= "];";

												$this->ScriptOutput .= $subcatsarray.$multiplesarray;

											$this->FieldOutput .= '<div style="margin-left:10px" class="pf-sub-listingtypes-container"></div>';
											

											$this->FieldOutput .= '</section>';
											$this->FieldOutput .= '</section>';

											/* Start: Function for sub listing types */
												$this->ScriptOutput .= "
													$.pf_get_sublistingtypes = function(itemid,defaultv){

														if ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) != -1) {
															var multiple_ex = 1;
														}else{
															var multiple_ex = 0;
														}
														$.ajax({
													    	beforeSend:function(){
													    		$('.pfsubmit-inner-listingtype').pfLoadingOverlay({action:'show',message: '".esc_html__("Loading fields...",'pointfindert2d')."'});
													    	},
															url: theme_scriptspf.ajaxurl,
															type: 'POST',
															dataType: 'html',
															data: {
																action: 'pfget_listingtype',
																id: itemid,
																default: defaultv,
																sname: 'pfupload_sublistingtypes',
																stext: '".$setup4_submitpage_sublistingtypes_title."',
																stype: 'listingtypes',
																stax: 'pointfinderltypes',
																lang: '".$lang_custom."',
																multiple: multiple_ex,
																security: '".wp_create_nonce('pfget_listingtype')."'
															},
														}).success(function(obj) {
															
															$('.pf-sub-listingtypes-container').append('<div class=\'pfsublistingtypes\'>'+obj+'</div>');

															if (obj != '') {
															";
															
															if ($stp4_forceu == 1) {
																$this->ScriptOutput .= "$('#pfupload_sublistingtypes').rules('add',{required: true,messages:{required:'".$setup4_submitpage_listingtypes_verror."'}});";
															}
															
															$this->ScriptOutput .= "

																if ($.pf_tablet_check()) {
																	$('#pfupload_sublistingtypes').select2({
																		placeholder: '".esc_html__("Please select",'pointfindert2d')."', 
																		formatNoMatches:'".esc_html__("No match found",'pointfindert2d')."',
																		allowClear: true, 
																		minimumResultsForSearch: 10
																	});
																}

																if ($.pf_tablet_check() == false) {
																	$('.pf-special-selectbox').each(function(index, el) {
																		$(this).children('option:first').remove();

																		var dataplc = $(this).data('pf-plc');
																		if (dataplc) {
																			$(this).prepend('<option value=\"\">'+dataplc+'</option>');
																		}else{
																			$(this).prepend('<option value=\"\">'+theme_scriptspf.pfselectboxtex+'</option>');
																		};
																	});
																};";

																if (empty($sub_sub_level)) {
																$this->ScriptOutput .= " if ($('#pfupload_sublistingtypes').val() != 0 && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																	$.pf_get_subsublistingtypes($('#pfupload_sublistingtypes').val(),'');
																}";
																}

																
																$this->ScriptOutput .= "
																$('#pfupload_sublistingtypes').change(function(){
																	if($(this).val() != 0 && $(this).val() != null){
																		if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																			$('#pfupload_listingtypes').val($(this).val()).trigger('change');
																		}else{
																			$('#pfupload_listingtypes').val($(this).val());
																		}
																		if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																			$.pf_get_subsublistingtypes($(this).val(),'');
																		}
																	}else{
																		if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																			$('#pfupload_listingtypes').val($('input.pflistingtypeselector:checked').val());
																		}else{
																			$('#pfupload_listingtypes').val($('input.pflistingtypeselector:checked').val()).trigger('change');
																		}
																		
																	}
																	$('.pfsubsublistingtypes').remove();

																});
																if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																	$('#pfupload_sublistingtypes').live('select2-removed', function(e) {
																		$('#pfupload_listingtypes').val($('input.pflistingtypeselector:checked').val()).trigger('change');
																	});
																}
															}

														}).complete(function(obj,obj2){
															if (obj.responseText != '') {

																if (defaultv != '') {
																	if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																		";
																		if ($item_level_value == 2 && $params['post_id'] != '') {
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(defaultv);
																			";
																		}else{
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(defaultv).trigger('change');";
																		}
																		$this->ScriptOutput .= "
																	}else{
																		$('#pfupload_listingtypes').val(defaultv);
																	}
																}else{
																	
																	if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																		";
																		if ($item_level_value == 1 && $params['post_id'] != '') {
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(itemid).trigger('change');";
																		}elseif (empty($params['post_id'])) {
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(itemid);";
																		}elseif (!empty($params['post_id']) && $item_level_value == 2) {
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(itemid);
																			";
																		}
																		$this->ScriptOutput .= "

																	}else{
																		$('#pfupload_listingtypes').val(itemid);
																	}
																}
																";
																
																if (!empty($sub_sub_level)) {
																	$this->ScriptOutput .= "
																	if (".$sub_level." == $('#pfupload_sublistingtypes').val()) {
																		$.pf_get_subsublistingtypes('".$sub_level."','".$sub_sub_level."');
																	}
																	";
																}
															$this->ScriptOutput .= "
															}
															setTimeout(function(){
																$('.pfsubmit-inner-listingtype').pfLoadingOverlay({action:'hide'});
															},1000);


														});
													}
												";
											/* End: Function for sub listing types */

											/* Start: Function for sub sub listing types */
												$this->ScriptOutput .= "
													$.pf_get_subsublistingtypes = function(itemid,defaultv){
														$.ajax({
													    	beforeSend:function(){
													    		$('.pfsubmit-inner-listingtype').pfLoadingOverlay({action:'show',message: '".esc_html__("Loading fields ...",'pointfindert2d')."'});
													    	},
															url: theme_scriptspf.ajaxurl,
															type: 'POST',
															dataType: 'html',
															data: {
																action: 'pfget_listingtype',
																id: itemid,
																default: defaultv,
																sname: 'pfupload_subsublistingtypes',
																stext: '".$setup4_submitpage_subsublistingtypes_title."',
																stype: 'listingtypes',
																stax: 'pointfinderltypes',
																lang: '".$lang_custom."',
																security: '".wp_create_nonce('pfget_listingtype')."'
															},
														}).success(function(obj) {
															$('.pf-sub-listingtypes-container').append('<div class=\'pfsubsublistingtypes\'>'+obj+'</div>');
															if (obj != '') {
															";

															if ($stp4_forceu == 1) {
																$this->ScriptOutput .= "$('#pfupload_subsublistingtypes').rules('add',{required: true,messages:{required:'".$setup4_submitpage_listingtypes_verror."'}});";
															}
															$this->ScriptOutput .= "
															if ($.pf_tablet_check()) {
																$('#pfupload_subsublistingtypes').select2({
																	placeholder: '".esc_html__("Please select",'pointfindert2d')."', 
																	formatNoMatches:'".esc_html__("No match found",'pointfindert2d')."',
																	allowClear: true, 
																	minimumResultsForSearch: 10
																});
															}

															if ($.pf_tablet_check() == false) {
																	$('.pf-special-selectbox').each(function(index, el) {
																		$(this).children('option:first').remove();

																		var dataplc = $(this).data('pf-plc');
																		if (dataplc) {
																			$(this).prepend('<option value=\"\">'+dataplc+'</option>');
																		}else{
																			$(this).prepend('<option value=\"\">'+theme_scriptspf.pfselectboxtex+'</option>');
																		};
																	});
																};


																$('#pfupload_subsublistingtypes').change(function(){
																	if($('#pfupload_subsublistingtypes').val() != 0){
																		
																		if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																			$('#pfupload_listingtypes').val($(this).val()).trigger('change');
																		}else{
																			$('#pfupload_listingtypes').val($(this).val());
																		}

																	}else{
																		
																		if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																			$('#pfupload_listingtypes').val($('#pfupload_sublistingtypes').val()).trigger('change');
																		}else{
																			$('#pfupload_listingtypes').val($('#pfupload_sublistingtypes').val());
																		}
																	}
																});
															}

														}).complete(function(obj,obj2){
															if (obj.responseText != '') {

																if (defaultv != '') {
																	
																	if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																		$('#pfupload_listingtypes').val(defaultv).trigger('change');
																	}else{
																		$('#pfupload_listingtypes').val(defaultv);
																	}
																}else{
																	
																	if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
																		";
																		if ($item_level_value == 2 && $params['post_id'] != '') {
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(itemid).trigger('change');";
																		}elseif (empty($params['post_id'])) {
																			$this->ScriptOutput .= "$('#pfupload_listingtypes').val(itemid);";
																		}
																		$this->ScriptOutput .= "
																	}else{
																		$('#pfupload_listingtypes').val(itemid);
																	}
																}
															}
															setTimeout(function(){
																$('.pfsubmit-inner-listingtype').pfLoadingOverlay({action:'hide'});
															},1000);
														});
													}
												";
											/* End: Function for sub sub listing types */
										

											/* Start: Create Limit Array */

												$this->ScriptOutput .= "var pflimitarray = [";
												$pflimittext = '';
												/*Get Limits for Areas*/
												if ($st4_sp_med == 1) {
													$pflimittext .= "'pf_address_area'";
												}

												/*Get Limits for Areas*/
												if ($setup3_pointposttype_pt5_check == 1 && $setup4_submitpage_locationtypes_check == 1) {
													if (!empty($pflimittext)) {$pflimittext .= ",";}
													$pflimittext .= "'pf_location_area'";
												}
												

												/*Get Limits for Image Area*/
												if($setup4_submitpage_imageupload == 1){
													if (!empty($pflimittext)) {$pflimittext .= ",";}
													$pflimittext .= "'pf_image_area'";
												}

												/*Get Limits for File Area*/
												if($stp4_fupl == 1){
													if (!empty($pflimittext)) {$pflimittext .= ",";}
													$pflimittext .= "'pf_file_area'";
												}

												$this->ScriptOutput .= $pflimittext;
												$this->ScriptOutput .= "];";
											/* End: Create Limit Array */


											/* Start: Check Limits */
												$this->ScriptOutput .= "
												$.pf_get_checklimits = function(itemid,limitvalue){
													$.ajax({
														url: theme_scriptspf.ajaxurl,
														type: 'POST',
														dataType: 'json',
														data: {
															action: 'pfget_listingtypelimits',
															id: itemid,
															limit: limitvalue,
															lang: '".$lang_custom."',
															security: '".wp_create_nonce('pfget_listingtypelimits')."'
														},
													}).success(function(obj) {";

														/* Address Area Check */
														if ($st4_sp_med == 1) {
															$this->ScriptOutput .= "
															if (obj.pf_address_area == 2) {
																$('.pfsubmit-inner-sub-address').hide();";
																if ($st4_sp_med2 == 1) {
																	$this->ScriptOutput .= "
																	$('#pfupload_address').rules('remove');
																	$('#pfupload_lng_coordinate').rules('remove');
																	$('#pfupload_lat_coordinate').rules('remove');
																	";
																}
																$this->ScriptOutput .= "
															}else{
																$('.pfsubmit-inner-sub-address').show();";
																if ($st4_sp_med2 == 1) {
																	$this->ScriptOutput .= "
																	$('#pfupload_address').rules('add',{required: true,messages:{required:\"".esc_html__("Please enter an address",'pointfindert2d')."\"}});
																	$('#pfupload_lng_coordinate').rules('add',{required: true,messages:{required:\"".$setup4_submitpage_maparea_verror."\"}});
																	$('#pfupload_lat_coordinate').rules('add',{required: true,messages:{required:\"".$setup4_submitpage_maparea_verror."\"}});
																	";
																}
																$this->ScriptOutput .= "
																$.pf_submit_page_map();
															}
															";
														}	

														/* Location Check */
														if ($setup3_pointposttype_pt5_check == 1 && $setup4_submitpage_locationtypes_check == 1) {
															$this->ScriptOutput .= "
															if (obj.pf_location_area == 2) {
																$('.pfsubmit-inner-sub-location').hide();
															";
															if ($setup4_submitpage_locationtypes_validation == 1) {
																$this->ScriptOutput .= "$('#pfupload_locations').rules('remove');";
															}
															$this->ScriptOutput .= "
															}else{
																$('.pfsubmit-inner-sub-location').show();
															";
															if ($setup4_submitpage_locationtypes_validation == 1) {
																$this->ScriptOutput .= "$('#pfupload_locations').rules('add',{required: true,messages:{required:\"".$setup4_submitpage_locationtypes_verror."\"}});";
															}
															$this->ScriptOutput .= "
															}";
														}

														
														/* Image Area Check */
														if ($setup4_submitpage_imageupload == 1) {
															$this->ScriptOutput .= "
															if (obj.pf_image_area == 2) {
																$('.pfsubmit-inner-sub-image').hide();
															";
															$itemfieldname = 'pfuploadimagesrc' ;
															if ($params['formtype'] != 'edititem' && $setup4_submitpage_featuredverror_status == 1) {
																$this->ScriptOutput .= "$('#".$itemfieldname."').rules('remove');";
															}
															$this->ScriptOutput .= "
															}else{
																$('.pfsubmit-inner-sub-image').show();
															";
															if ($params['formtype'] != 'edititem' && $setup4_submitpage_featuredverror_status == 1) {
																$this->ScriptOutput .= "$('#".$itemfieldname."').rules('add',{required: true,messages:{required:\"".$setup4_submitpage_featuredverror."\"}});";
															}
															$this->ScriptOutput .= "
															}";
														}

														/* File Area Check */
														if ($stp4_fupl == 1) {
															$this->ScriptOutput .= "
															if (obj.pf_file_area == 2) {
																$('.pfsubmit-inner-sub-file').hide();
															";
															$itemfieldname = 'pfuploadfilesrc' ;
															if ($params['formtype'] != 'edititem' && $stp4_err_st == 1) {
																$this->ScriptOutput .= "$('#".$itemfieldname."').rules('remove');";
															}
															$this->ScriptOutput .= "
															}else{
																$('.pfsubmit-inner-sub-file').show();
															";
															if ($params['formtype'] != 'edititem' && $stp4_err_st == 1) {
																$this->ScriptOutput .= "$('#".$itemfieldname."').rules('add',{required: true,messages:{required:\"".$stp4_err."\"}});";
															}
															$this->ScriptOutput .= "
															}";
														}
														
													$this->ScriptOutput .= "
													}).complete(function(){
														";
														/* if this is edit show button and sub exclude area */
														if ($params['post_id'] != '') {
															$this->ScriptOutput .= "$('.pf-excludecategory-container').show();$('#pf-ajax-uploaditem-button').show();";
														}
														$this->ScriptOutput .= "
													});
												};";
											/* End: Check Limits */

											
											/* Start: Page Loading functions */
												$this->ScriptOutput .= "$(function(){";
													/* Edit Functions */
													if ($params['post_id'] != '') {

														$this->ScriptOutput .= "
														$.pf_get_checklimits('".$item_defaultvalue_output."',pflimitarray);

														$.pf_get_sublistingtypes($('#pfupload_listingtypes').val(),'".$sub_level."');
														

														if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) != -1)) {
															
															$.pf_get_modules_now(".$item_defaultvalue_output.");
															
														}

														if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) != -1)) {

															$.pf_get_modules_now(".$item_defaultvalue_output.");
															
														}else{
															";
															if ($item_level_value == 0 && $params['post_id'] != '') {
																$this->ScriptOutput .= "$.pf_get_modules_now($('#pfupload_listingtypes').val());";
															}elseif(empty($params['post_id'])){
																$this->ScriptOutput .= "$.pf_get_modules_now($('#pfupload_listingtypes').val());";
															}
															$this->ScriptOutput .= "
														}

														";
														if (empty($sub_sub_level) && !empty($sub_level)) {
															$this->ScriptOutput .= "$('#pfupload_listingtypes').val('".$sub_level."');";
														}
													}
												$this->ScriptOutput .= "});";
											/* End: Page Loading functions */
											

											/* Start: Listing Type Change Functions */
												$this->ScriptOutput .= "
												$('#pfupload_listingtypes').change(function(){

													$.pf_get_modules_now($(this).val(),'pointfinderfeatures');

													$('.pf-excludecategory-container').show();

													$('#pf-ajax-uploaditem-button').show();

												});

												$('.pflistingtypeselector').change(function(){

													$('.pf-sub-listingtypes-container').html('');

													$('#pfupload_listingtypes').val($(this).val()).trigger('change');

													$.pf_get_sublistingtypes($(this).val(),'');

													$.pf_get_checklimits($(this).val(),pflimitarray);

													$.pf_get_priceoutput();
												});

												
												";
											/* End: Listing Type Change Functions */

										/**
										*Listing Types
										**/
										} //end of is_editor
										$user_id = get_current_user_id();
										$msg = '为了保证发布信息的质量，所有信息需要经过审核后才能发布。如果您是<a href="/wp-login.php?action=register" style="color:blue">注册</a>用户，您可以在‘信息列表’中查看自己已经发布的信息。如果您是匿名用户，我们的编辑人员会在通过信息审核后，把信息的链接通过邮件发送给您';
										if ($user_id>0) {
												global $current_user;
												$msg= '欢迎您归来' . $current_user->nickname ;	
										}
										/**
										* Title & Description Area
										**/
											$this->FieldOutput .= '<div class="pf-excludecategory-container">';
											
											$this->FieldOutput .= '<div class="pfsubmit-title">'. $msg .'</div>';
											$this->FieldOutput .= '<section class="pfsubmit-inner">';

											/**
												*Title
												**/
													$setup4_submitpage_titleverror = PFSAIssetControl('setup4_submitpage_titleverror','','Please type a title.');
													$item_title = ($params['post_id'] != '') ? get_the_title($params['post_id']) : '' ;
													$this->FieldOutput .= '
													<section class="pfsubmit-inner-sub">
								                        <label for="item_title" class="lbl-text">'.esc_html__('商家名称','pointfindert2d').':</label>
								                        <label class="lbl-ui">
								                        	<input type="text" name="item_title" id="item_title" class="input" value="'.$item_title.'"/>';
													if ($setup4_submitpage_titletip!='') {
														$this->FieldOutput .= '<b class="tooltip left-bottom"><em>'.$setup4_submitpage_titletip.'</em></b>';
													} 
								                    $this->FieldOutput .= '</label>                          
								                   </section>  
													';
													$this->PFValidationCheckWrite(1,$setup4_submitpage_titleverror,'item_title');
												/**
												*Title
												**/
													//jschen added telephoe
												if ($user_id == 0)
												{
														
													$this->PFValidationCheckWrite(1,'请输入电话','item_phone');
													$this->FieldOutput .= '
													<section class="pfsubmit-inner-sub">
								                        <label for="item_phone" class="lbl-text">'.esc_html__('联系电话','pointfindert2d').':</label>
								                        <label class="lbl-ui">
								                        	<input type="text" name="item_phone" id="item_phone" class="input" value=""/>';
												          $this->FieldOutput .= '</label> </section>';

													$this->PFValidationCheckWrite(1,'请输入电子邮件','item_email');
													$this->FieldOutput .= '
													<section class="pfsubmit-inner-sub">
								                        <label for="item_email" class="lbl-text">'.esc_html__('电子邮件','pointfindert2d').':</label>
								                        <label class="lbl-ui">
								                        	<input type="text" name="item_email" id="item_email" class="input" value=""/>';
												          $this->FieldOutput .= '</label> </section>';

													}
													$this->FieldOutput .= '<input type="hidden" name="item_url" id="item_url" value="'.html_entity_decode( urldecode($_GET['url'])) . '"/>';
												

												/**
												*Desc
												**/
													
													$setup4_sbp_dh = PFSAIssetControl('setup4_sbp_dh','','1');
													if ($setup4_sbp_dh == 1) {
														$setup4_submitpage_descriptionvcheck = PFSAIssetControl('setup4_submitpage_descriptionvcheck','','0');
														$setup4_submitpage_description_verror = PFSAIssetControl('setup4_submitpage_description_verror','','Please write a description');
														$item_desc = ($params['post_id'] != '') ? get_post_field('post_content',$params['post_id']) : '' ;

														$this->FieldOutput .= '
														<section class="pfsubmit-inner-sub">
									                        <label for="item_desc" class="lbl-text">'.esc_html__('请输入商家描述，打折优惠信息，联系电话','pointfindert2d').':</label>
									                        <label class="lbl-ui">';

									                        $this->FieldOutput .= do_action( 'pf_desc_editor_hook',$item_desc);
									                        $this->FieldOutput .= '<textarea id="item_desc" name="item_desc" class="textarea mini">'.$item_desc.'</textarea>';

									                    $this->FieldOutput .= '</label></section>';
														$this->PFValidationCheckWrite($setup4_submitpage_descriptionvcheck,$setup4_submitpage_description_verror,'item_desc');
													}
												/**
												*Desc
												**/

											$this->FieldOutput .= '</section>';
										/**
										* Title & Description Area
										**/


										/**
										*Item Types
										**/
											if($is_editor && $setup3_pointposttype_pt4_check == 1 && $setup4_submitpage_itemtypes_check == 1){
												$setup4_submitpage_itemtypes_title = PFSAIssetControl('setup4_submitpage_itemtypes_title','','Item Type');

												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-sub-itype">'.$setup4_submitpage_itemtypes_title.'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-sub-itype"></section>';
											}
										/**
										*Item Types
										**/



										/**
										*Conditions
										**/	
											if($is_editor && $setup3_pt14_check == 1 && $setup4_submitpage_conditions_check == 1){
												
												$setup4_submitpage_conditions_title = PFSAIssetControl('setup4_submitpage_conditions_title','','Conditions');												

												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-sub-conditions">'.$setup4_submitpage_conditions_title.'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-sub-conditions"></section>';
											}
										/**
										*Conditions
										**/


                                        if($is_editor) {

										/** 
										*Start : Event Details
										**/
											$this->FieldOutput .= '<div class="eventdetails-output-container"></div>';
										/** 
										*End : Event Details
										**/




										/** 
										*Start : Custom Fields
										**/
											$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-customfields-title">'.esc_html__('ADDITIONAL INFO','pointfindert2d').'</div>';
											$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-customfields"></section>';
										/** 
										*End : Custom Fields
										**/
                                        }



										/**
										*Features
										**/
											if($is_editor && $setup3_pointposttype_pt6_check == 1 && $setup4_submitpage_featurestypes_check == 1){
												$setup4_submitpage_featurestypes_title = PFSAIssetControl('setup4_submitpage_featurestypes_title','','Features');

												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-features-title">'.$setup4_submitpage_featurestypes_title.'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-features"></section>';
											}
										/**
										*Features
										**/


										/**
										*Custom Tabs
										**/	
											$this->FieldOutput .= '<div class="customtab-output-container"></div>';
											
										/**
										*Custom Tabs
										**/


										/**
										*Post Tags
										**/
											$stp4_psttags = PFSAIssetControl('stp4_psttags','','1');
											if ($is_editor && $stp4_psttags == 1) {
												$this->FieldOutput .= '<div class="pfsubmit-title">'.esc_html__('Tags','pointfindert2d').'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner">';
												$this->FieldOutput .= '
												<section class="pfsubmit-inner-sub">
							                     
							                        <label class="lbl-ui">
							                        	<input type="text" name="posttags" id="posttags" class="input" placeholder="'.esc_html__('Please add post tags with comma like: keyword,keyword2,keyword3','pointfindert2d').'" value=""/>
													</label>
												
							                    ';

							                    $post_tags = wp_get_post_tags( $params['post_id']);
												if (isset($post_tags) && $params['formtype'] == 'edititem') {
													$this->FieldOutput .= '<div class="pf-posttag-container">';
							                    	foreach ($post_tags as $value) {
							                    		$this->FieldOutput .= '<div class="pf-item-posttag">'.$value->name.'';
							                    		$this->FieldOutput .= '<a data-pid="'.$value->term_taxonomy_id.'" data-pid2="'.$params['post_id'].'"  id="pf-delete-tag-'.$value->term_taxonomy_id.'" title="'.esc_html__('Delete','pointfindert2d').'"><i class="pfadmicon-glyph-644"></i></a></div>';
							                    	}
							                    	$this->FieldOutput .= '</div>';
												}
												$this->FieldOutput .= '</section></section>';
											}
										/**
										*Post Tags
										**/

										if ($setup4_submitpage_video == 1) {
											$taxonomies = array( 
								                'pointfinderltypes'
								            );

								            $args = array(
								                'orderby'           => 'name', 
								                'order'             => 'ASC',
								                'hide_empty'        => false, 
								                'parent'            => 0,
								            ); 
											$pf_get_term_details = get_terms($taxonomies,$args); 
										}

										/**
										*Opening Hours
										**/
											$this->FieldOutput .= '<div class="openinghourstab-output-container"></div>';

											$setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
											$setup3_modulessetup_openinghours_ex = PFSAIssetControl('setup3_modulessetup_openinghours_ex','','1');
										/**
										*Opening Hours
										**/



										/**
										*Featured Video 
										**/
											$this->FieldOutput .= '<div class="pfvideotab-output-container"></div>';
										/** 
										*Featured Video 
										**/


										
										/**
										*Locations
										**/
											if($is_editor && $setup3_pointposttype_pt5_check == 1 && $setup4_submitpage_locationtypes_check == 1){
													
													$stp4_loc_new = PFSAIssetControl('stp4_loc_new','','0');
													$setup4_submitpage_locationtypes_title = PFSAIssetControl('setup4_submitpage_locationtypes_title','','Location');

													$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-sub-location">'.$setup4_submitpage_locationtypes_title.'</div>';
													$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-sub-location pfsubmit-location-errc">';

													if ($stp4_loc_new == 1) {
														
														$stp4_sublotyp_title = PFSAIssetControl('stp4_sublotyp_title','',esc_html__('Sub Location', 'pointfindert2d'));
														$stp4_subsublotyp_title = PFSAIssetControl('stp4_subsublotyp_title','',esc_html__('Sub Sub Location', 'pointfindert2d'));
														
														$itemfieldname = 'pfupload_locations' ;

														$this->PFValidationCheckWrite($setup4_submitpage_locationtypes_validation,$setup4_submitpage_locationtypes_verror,$itemfieldname);


														$item_defaultvalue = ($params['post_id'] != '') ? wp_get_post_terms($params['post_id'], 'pointfinderlocations', array("fields" => "ids")) : '' ;
														$item_defaultvalue_output = $sub_level = $sub_sub_level = $item_defaultvalue_output_orj = '';


	
														if (isset($item_defaultvalue[0])) {
															$item_defaultvalue_output_orj = $item_defaultvalue[0];
															$find_top_parent = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderlocations');

															switch ($find_top_parent['level']) {
																case '1':
																	$sub_level = $item_defaultvalue[0];
																	break;
																
																case '2':
																	$sub_sub_level = $item_defaultvalue[0];
																	$sub_level = pf_get_term_top_parent($item_defaultvalue[0],'pointfinderlocations');
																	break;
															}
															

															$item_defaultvalue_output = $find_top_parent['parent'];
														}

														$this->FieldOutput .= '<input type="hidden" name="pfupload_locations" id="pfupload_locations" value="'.$item_defaultvalue_output.'"/>';

														$this->FieldOutput .= '<section class="pfsubmit-inner-sub pfsubmit-inner-sub-locloader">';
														$fields_output_arr = array(
															'listname' => 'pflocationselector',
													        'listtype' => 'locations',
													        'listtitle' => $setup4_submitpage_locationtypes_title,
													        'listsubtype' => 'pointfinderlocations',
													        'listdefault' => $item_defaultvalue_output,
													        'listmultiple' => 0,
													        'parentonly' => 1
														);
														$this->FieldOutput .= $this->PFGetList($fields_output_arr);
														$this->FieldOutput .= '<div class="pf-sub-locations-container"></div>';

														/* Custom location */
														$stp4_loc_add = PFSAIssetControl('stp4_loc_add','','0');
														if ($stp4_loc_add == 1) {
															
															$this->FieldOutput .= '<section class="pfsubmit-inner-sub-customcity">';
															$this->FieldOutput .= ' <label for="item_title" class="lbl-text">'.esc_html__('Custom City','pointfindert2d').': '.esc_html__('(Optional)','pointfindert2d').'</label>';
																$this->FieldOutput .= '
									                            <label for="file" class="lbl-ui" >
									                            <input class="input" name="customlocation" placeholder="'.esc_html__("If you couldn't find your city. Please type custom city here.",'pointfindert2d').'" value="">
									                            </label> 
																';
															$this->FieldOutput .= '</section>';
														}


														$this->FieldOutput .= '</section>';
														$this->ScriptOutput .= '
														if ($.pf_tablet_check()) {
														$("#pflocationselector").select2({
															placeholder: "'.esc_html__("Please select","pointfindert2d").'", 
															formatNoMatches:"'.esc_html__("Nothing found.","pointfindert2d").'",
															allowClear: true, 
															minimumResultsForSearch: 10
														});
														}
														';
											
														$this->ScriptOutput .= "
															/* Start: Function for sub location types */
																$.pf_get_sublocations = function(itemid,defaultv){
																	$.ajax({
																    	beforeSend:function(){
																    		$('.pfsubmit-inner-sub-locloader').pfLoadingOverlay({action:'show',message: '".esc_html__('Loading locations...','pointfindert2d')."'});
																    	},
																		url: theme_scriptspf.ajaxurl,
																		type: 'POST',
																		dataType: 'html',
																		data: {
																			action: 'pfget_listingtype',
																			id: itemid,
																			default: defaultv,
																			sname: 'pfupload_sublocations',
																			stext: '".$stp4_sublotyp_title."',
																			stype: 'locations',
																			stax: 'pointfinderlocations',
																			lang: '".$lang_custom."',
																			security: '".wp_create_nonce('pfget_listingtype')."'
																		},
																	}).success(function(obj) {
																		$('.pf-sub-locations-container').append('<div class=\'pfsublocations\'>'+obj+'</div>');
																		if (obj != '') {
																			if ($.pf_tablet_check()) {
																				$('#pfupload_sublocations').select2({
																					placeholder: '".esc_html__('Please select','pointfindert2d')."', 
																					formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
																					allowClear: true, 
																					minimumResultsForSearch: 10
																				});
																			}";

																			if (empty($sub_sub_level)) {
																			$this->ScriptOutput .= "
																				$.pf_get_subsublocations($('#pfupload_sublocations').val(),'');
																			";
																			}

																			
																			$this->ScriptOutput .= "
																			$('#pfupload_sublocations').change(function(){
																				if($(this).val() != 0 && $(this).val() != null){
																					$('#pfupload_locations').val($(this).val()).trigger('change');
																					$.pf_get_subsublocations($(this).val(),'');
																					$('.pfsubmit-inner-sub-customcity').show();
																				}else{
																					$('#pfupload_locations').val(itemid);
																					$('.pfsubmit-inner-sub-customcity').hide();
																				}
																				$('.pfsubsublocations').remove();
																			});
																		}
																	}).complete(function(obj,obj2){
																		if (obj.responseText != '') {
																			if (defaultv != '') {
																				$('#pfupload_locations').val(defaultv).trigger('change');
																				//$.pf_get_subsublocations($('#pfupload_sublocations').val(),'');
																				$('.pfsubmit-inner-sub-customcity').show();
																			}else{
																				$('#pfupload_locations').val(itemid).trigger('change');
																			}";
																						
																			if (!empty($sub_sub_level)) {
																				$this->ScriptOutput .= "
																				if (".$sub_level." == $('#pfupload_sublocations').val()) {
																					$.pf_get_subsublocations('".$sub_level."','".$sub_sub_level."');
																				}
																				";
																			}
																			$this->ScriptOutput .= "
																		}
																		setTimeout(function(){
																			$('.pfsubmit-inner-sub-locloader').pfLoadingOverlay({action:'hide'});
																		},1000);
																		
																		
																	});
																}


																$.pf_get_subsublocations = function(itemid,defaultv){
																	$.ajax({
																    	beforeSend:function(){
																    		$('.pfsubmit-inner-sub-locloader').pfLoadingOverlay({action:'show',message: '".esc_html__('Loading locations...','pointfindert2d')."'});
																    	},
																		url: theme_scriptspf.ajaxurl,
																		type: 'POST',
																		dataType: 'html',
																		data: {
																			action: 'pfget_listingtype',
																			id: itemid,
																			default: defaultv,
																			sname: 'pfupload_subsublocations',
																			stext: '".$stp4_subsublotyp_title."',
																			stype: 'locations',
																			stax: 'pointfinderlocations',
																			lang: '".$lang_custom."',
																			security: '".wp_create_nonce('pfget_listingtype')."'
																		},
																	}).success(function(obj) {
																		$('.pf-sub-locations-container').append('<div class=\'pfsubsublocations\'>'+obj+'</div>');
																		if ($.pf_tablet_check()) {
																			$('#pfupload_subsublocations').select2({
																				placeholder: '".esc_html__('Please select','pointfindert2d')."', 
																				formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
																				allowClear: true, 
																				minimumResultsForSearch: 10
																			});
																		}
																			


																			$('#pfupload_subsublocations').change(function(){
																				if($(this).val() != 0){
																					$('#pfupload_locations').val($(this).val()).trigger('change');
																				}else{
																					$('#pfupload_locations').val($('#pfupload_sublocations').val())
																				}
																			});

																	}).complete(function(obj,obj2){
																		if (obj.responseText != '') {
																			if (defaultv != '') {
																				$('#pfupload_locations').val(defaultv).trigger('change');
																			}else{
																				$('#pfupload_locations').val(itemid).trigger('change');
																			}
																		}
																		setTimeout(function(){
																			$('.pfsubmit-inner-sub-locloader').pfLoadingOverlay({action:'hide'});
																		},1000);
																	});
																}

															/* End: Function for sub location types */
															";


														$this->ScriptOutput .= "$(function(){";

															if ($params['post_id'] != '') {
																$this->ScriptOutput .= "$.pf_get_sublocations($('#pfupload_locations').val(),'".$sub_level."');";
																if (empty($sub_sub_level) && !empty($sub_level)) {
																	$this->ScriptOutput .= "$('#pfupload_locations').val('".$sub_level."');";
																}
															}

														$this->ScriptOutput .= "});";
														
														$this->ScriptOutput .= "
														$('#pflocationselector').change(function(){
															$('.pf-sub-locations-container').html('');
															$('#pfupload_locations').val($(this).val()).trigger('change');
															$.pf_get_sublocations($(this).val(),'');
														});
														";

													}else{
														
														$setup4_submitpage_locationtypes_multiple = PFSAIssetControl('setup4_submitpage_locationtypes_multiple','','0');

														$itemfieldname = ($setup4_submitpage_locationtypes_multiple == 1) ? 'pfupload_locations[]' : 'pfupload_locations' ;

														$this->PFValidationCheckWrite($setup4_submitpage_locationtypes_validation,$setup4_submitpage_locationtypes_verror,$itemfieldname);

														$item_defaultvalue = ($params['post_id'] != '') ? wp_get_post_terms($params['post_id'], 'pointfinderlocations', array("fields" => "ids")) : '' ;

														$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';
														$fields_output_arr = array(
															'listname' => 'pfupload_locations',
													        'listtype' => 'locations',
													        'listtitle' => $setup4_submitpage_locationtypes_title,
													        'listsubtype' => 'pointfinderlocations',
													        'listdefault' => $item_defaultvalue,
													        'listmultiple' => $setup4_submitpage_locationtypes_multiple
														);
														$this->FieldOutput .= $this->PFGetList($fields_output_arr);
														$this->FieldOutput .= '</section>';
														$this->ScriptOutput .= '
														if ($.pf_tablet_check()) {
														$("#pfupload_locations").select2({
															placeholder: "'.esc_html__("Please select","pointfindert2d").'", 
															formatNoMatches:"'.esc_html__("Nothing found.","pointfindert2d").'",
															allowClear: true, 
															minimumResultsForSearch: 10
														});
														}
														';
														
													}
												
													$this->FieldOutput .= '</section>';
											}
										/**
										*Locations 
										**/


										/** 
										*Map  & Locations
										**/	
											
											if($st4_sp_med == 1){
												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-sub-address">'.esc_html__('地址','pointfindert2d').'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-sub-address pfsubmit-address-errc">';

											
												$setup4_submitpage_maparea_title = PFSAIssetControl('setup4_submitpage_maparea_title','','');
												$setup4_submitpage_maparea_tooltip = PFSAIssetControl('setup4_submitpage_maparea_tooltip','','');
/*jschen , remove lat and lng verification												

												$this->PFValidationCheckWrite($st4_sp_med2,$setup4_submitpage_maparea_verror,'pfupload_lat');
												$this->PFValidationCheckWrite($st4_sp_med2,$setup4_submitpage_maparea_verror,'pfupload_lng');
*/
												$this->PFValidationCheckWrite($st4_sp_med2,esc_html__('Please enter an address','pointfindert2d'),'pfupload_address');


												$setup5_mapsettings_zoom = PFSAIssetControl('setup5_mapsettings_zoom','','6');
												$setup5_mapsettings_type = PFSAIssetControl('setup5_mapsettings_type','','ROADMAP');
												$setup5_mapsettings_lat = PFSAIssetControl('setup5_mapsettings_lat','','');
												$setup5_mapsettings_lng = PFSAIssetControl('setup5_mapsettings_lng','','');

												$setup5_mapsettings_lat_text = $setup5_mapsettings_lng_text = '';

												if($params['post_id'] != ''){
													$coordinates = get_post_meta( $params['post_id'], 'webbupointfinder_items_location', true );
													
													if(isset($coordinates)){
														$coordinates = explode(',', $coordinates);
														
														if (isset($coordinates[1])) {
															$setup5_mapsettings_lat = $setup5_mapsettings_lat_text = $coordinates[0];
															$setup5_mapsettings_lng = $setup5_mapsettings_lng_text = $coordinates[1];
														}else{
															$setup5_mapsettings_lat = $setup5_mapsettings_lat_text = '';
															$setup5_mapsettings_lng = $setup5_mapsettings_lng_text = '';
														}
														
													}
												}

												$description = ($setup4_submitpage_maparea_tooltip!='') ? ' <a href="javascript:;" class="info-tip" aria-describedby="helptooltip">?<span role="tooltip">'.$setup4_submitpage_maparea_tooltip.'</span></a>' : '' ;

												$pfupload_address = ($params['post_id'] != '') ? esc_html(get_post_meta($params['post_id'], 'webbupointfinder_items_address', true)) : '' ;

												
												$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';
													$this->FieldOutput .= '<label for="pfupload_address" class="lbl-text">'.$setup4_submitpage_maparea_title.':'.$description.'</label>';
													$this->FieldOutput .= '<label class="lbl-ui pflabelfixsearch search">';
													$this->FieldOutput .= '<input id="pfupload_address" value="'.$pfupload_address.'" name="pfupload_address" class="controls input" type="text" placeholder="'.esc_html__('Please type an address...','pointfindert2d').'">';
													$this->FieldOutput .= '<a class="button" id="pf_search_geolocateme" data-istatus="false" title="'.esc_html__('Locate me!','pointfindert2d').'">
													<img src="'.get_template_directory_uri().'/images/geoicon.svg" width="16px" height="16px" class="pf-search-locatemebut" alt="'.esc_html__('Locate me!','pointfindert2d').'">
													<div class="pf-search-locatemebutloading"></div>
													</a>';
													$this->FieldOutput .= '</label>';
													$this->FieldOutput .= '<div id="pfupload_map" style="width: 100%;height: 300px;border:0" data-pf-zoom="'.$setup5_mapsettings_zoom.'" data-pf-type="'.$setup5_mapsettings_type.'" data-pf-lat="'.$setup5_mapsettings_lat.'" data-pf-lng="'.$setup5_mapsettings_lng.'" data-pf-istatus="false"></div>';


												$this->FieldOutput .= '</section>';


												$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';

													$this->FieldOutput .= '<div class="row">';


													$this->FieldOutput .= '<div class="col6 first"><div id="pfupload_lat">';
														 $this->FieldOutput .= '<label for="pfupload_lat" class="lbl-text">'.esc_html__('Lat Coordinate','pointfindert2d').':</label>
						                                <label class="lbl-ui">
						                                	<input type="text" name="pfupload_lat" id="pfupload_lat_coordinate" class="input" value="'.$setup5_mapsettings_lat_text.'" />
						                                </label>';
													$this->FieldOutput .= '</div></div>';/*inner*//*col6 first*/



													$this->FieldOutput .= '<div class="col6 last colspacer-two"><div id="pfupload_lng">';
														$this->FieldOutput .= '<label for="pfupload_lng" class="lbl-text">'.esc_html__('Lng Coordinate','pointfindert2d').':</label>
						                                <label class="lbl-ui">
						                                	<input type="text" name="pfupload_lng" id="pfupload_lng_coordinate" class="input" value="'.$setup5_mapsettings_lng_text.'"/>
						                                </label>';
													$this->FieldOutput .= '</div></div>';/*inner*//*col6 last*/


													$this->FieldOutput .= '<div>';/*row*/
												$this->FieldOutput .= '</section>';
												

											$this->FieldOutput .= '</section>';
											}
										/**
										*Map & Locations
										**/


										/**
										*Image Upload
										**/
											if ($setup4_submitpage_imageupload == 1) {
												$setup4_submitpage_status_old = PFSAIssetControl('setup4_submitpage_status_old','','0');
												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-sub-image">'.esc_html__('上传图片,为了更好展示图片，请您横向拍摄图片','pointfindert2d' ).'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfitemimgcontainer pferrorcontainer pfsubmit-inner-sub-image">';
												
												
												
												if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9') !== false || $setup4_submitpage_status_old == 1) {
													/** 
													*Old Image Upload - if this is an ie9 or 8
													**/
														wp_register_script('moxieformforie', get_template_directory_uri() . '/js/moxie.min.js', array('jquery'), '1.4.1',true); 
														wp_enqueue_script('moxieformforie'); 

														$this->FieldOutput .= '<div class="pfuploadedimages"></div>';

														$this->FieldOutput .= '
														<script type="text/javascript">
														(function($) {
														"use strict";
															$(function(){
																';
																if(!empty($params['post_id'])){
																$this->FieldOutput .= '$.pfitemdetail_listimages_old('.$params['post_id'].');';
																}
														$this->FieldOutput .= ' 	
															});
															
														})(jQuery);
														</script>';

														$pfimageuploadimit = $setup4_submitpage_imagelimit + 1;
														$imagesvalue = '';
														if ($params['formtype'] != 'edititem') {
															$images_count = 0;
															$images_newlimit = $pfimageuploadimit;
														}else{

															$images_of_thispost = get_post_meta($params['post_id'],'webbupointfinder_item_images');
															$featuredimagenum = get_post_thumbnail_id($params['post_id']);

															$images_count = count($images_of_thispost) + 1;
															$images_newlimit = $pfimageuploadimit - $images_count;
														}

														$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';
														
														
														$this->FieldOutput .= '<label for="file" class="lbl-text">'.esc_html__('UPLOAD NEW IMAGES','pointfindert2d').': ('.esc_html__('MAX','pointfindert2d').': '.$pfimageuploadimit.'/<span class="pfmaxtext">'.$images_newlimit.'</span>) '.esc_html__('(Allowed: JPG,GIF,PNG)','pointfindert2d').':</label><small style="margin-bottom:4px;display:block;">'.esc_html__('First image will be main image.','pointfindert2d').'</small>';
														$this->FieldOutput .= '<div class="pfuploadfeaturedimg-container"><a id="pfuploadfeaturedimg_remove" style="font-size: 12px;line-height: 14px;"><i class="pfadmicon-glyph-64" style="font-size: 14px;"></i> '.esc_html__('Remove Uploaded Images','pointfindert2d').'</a></div>';
														$this->FieldOutput .= '<div class="pfuploadfeaturedimgupl-container">';
														$this->FieldOutput .= '
							                            <label for="file" class="lbl-ui file-input">
								                            <div id="pffeaturedimageuploadcontainer">
														        <a id="pffeaturedimageuploadfilepicker" href="javascript:;"><i class="pfadmicon-glyph-512"></i> '.esc_html__('Choose Images','pointfindert2d').'</a>
														    </div>
							                            </label> 
							                            </div>
														';
														
														$this->FieldOutput .= '</section>';

														$this->FieldOutput .= '<input type="hidden" name="pfuploadimagesrc" id="pfuploadimagesrc" value="'.$imagesvalue.'">';
														
														if($setup4_submitpage_featuredverror_status == 1 && $params['formtype'] != 'edititem'){
															
															if($this->VSOMessages != ''){
																$this->VSOMessages .= ',pfuploadimagesrc:"'.$setup4_submitpage_featuredverror.'"';
															}else{
																$this->VSOMessages = 'pfuploadimagesrc:"'.$setup4_submitpage_featuredverror.'"';
															}

															if($this->VSORules != ''){
																$this->VSORules .= ',pfuploadimagesrc:"required"';
															}else{
																$this->VSORules = 'pfuploadimagesrc:"required"';
															}
														}

														$nonceimgup = wp_create_nonce('pfget_imageupload');
														

														$this->ScriptOutput .= "$.pfuploadimagelimit = ".$images_newlimit.";";

														if ($params['formtype'] == 'edititem') {
															$this->ScriptOutput .= "
															if ($.pfuploadimagelimit <= 0) {
																$('.pfuploadfeaturedimg-container').css('display','none');
																$('.pfuploadfeaturedimgupl-container').css('display','none');
															}
															
															if ($.pfuploadimagelimit <= ".$pfimageuploadimit."){
																$('.pfuploadfeaturedimgupl-container').css('display','inline-block');
															}

															if (".$images_newlimit." == 0) {
																$('.pfuploadfeaturedimgupl-container').css('display','none');
															}
															
															";
														}

														$this->ScriptOutput .= "

														/*Image upload featured image AJAX */
															var FeaturedfileInput = new mOxie.FileInput({
													            browse_button: document.getElementById('pffeaturedimageuploadfilepicker'),
													            container: 'pffeaturedimageuploadcontainer',
													            accept: [{title: 'Image files', extensions: 'jpg,gif,png'}],
													            multiple: true
													        });

													        $.pfuploadedfilecount = 0;

													        $.pfuploadoldimages = function(id){
													        	var numberi = id;
													        	numberi = numberi + 1;
												        		$('.pfitemimgcontainer').pfLoadingOverlay({action:'show',message: '".esc_html__('Uploading file: ','pointfindert2d')."'+numberi});

																if ($.pfuploadimagelimit > 0 && $.pfuploadedfilecount < $.pfuploadmaximage) {
																
														            var formData = new mOxie.FormData();
														            formData.append('action','pfget_imageupload');
																    formData.append('security','".$nonceimgup."');
																    formData.append('oldup',1);
																    formData.append('pfuploadfeaturedimg', FeaturedfileInput.files[id]);

																    var featured_xhr = new mOxie.XMLHttpRequest();
																    featured_xhr.open('POST', theme_scriptspf.ajaxurl, true);
																    featured_xhr.responseType = 'text';
																    featured_xhr.send(formData);

																    var clearfeaturedinterval = function(){

																    	clearInterval(featureimgint);

																    	$.pfuploadedfilecount = $.pfuploadedfilecount + 1;
																		$.pfuploadimagelimit = $.pfuploadimagelimit - 1;

																    	if ($.pfuploadedfilecount == $.pfuploadmaximage) {
																	    	if ($.pfuploadimagelimit > 0) {
																	    		$('.pfuploadfeaturedimgupl-container').css('display','inline-block');
																	    	}else{
																	    		$('.pfuploadfeaturedimgupl-container').css('display','none');
																	    	}
																			$('.pfuploadfeaturedimg-container').css('display','inline-block');
																			$('.pfitemimgcontainer').pfLoadingOverlay({action:'hide'});
																	    }

																	    if ($.pfuploadimagelimit > 0) {
																    		$('.pfuploadfeaturedimgupl-container').css('display','inline-block');
																    	}else{
																    		$('.pfuploadfeaturedimgupl-container').css('display','none');
																    	}

																	    $('.pfmaxtext').text($.pfuploadimagelimit);
																	    $.pfuploadoldimages($.pfuploadedfilecount);
																    }

																    var featureimgint = setInterval(function(){
																    	if (featured_xhr.readyState == 4) {
																    		var obj = featured_xhr.response;
																    		obj = $.parseJSON(obj)
																    		
																	    		if (obj.process == 'up') {

																					var uploadedimages = $('#pfuploadimagesrc').val();
																					if (uploadedimages.length > 0) {
																						uploadedimages = uploadedimages+','+obj.id;
																						$('#pfuploadimagesrc').val(uploadedimages);
																					}else{
																						$('#pfuploadimagesrc').val(obj.id);
																					}
																				}
																			clearfeaturedinterval();
																    	}
																    }, 1000);																	
																}else{
																	if ($.pfuploadimagelimit > 0) {
															    		$('.pfuploadfeaturedimgupl-container').css('display','inline-block');
															    	}else{
															    		$('.pfuploadfeaturedimgupl-container').css('display','none');
															    	}
																	$('.pfuploadfeaturedimg-container').css('display','inline-block');
																	$('.pfitemimgcontainer').pfLoadingOverlay({action:'hide'});
																	$.pfuploadmaximage = $.pfuploadedfilecount = 0;
																};
													        };

													        FeaturedfileInput.onchange = function(e) {
													        	if (FeaturedfileInput.files && FeaturedfileInput.files.length) {
														       		$.pfuploadmaximage = FeaturedfileInput.files.length;
														       		$.pfuploadoldimages(0);
													       		}
													        };


													        FeaturedfileInput.onready = function(e) {
														        $('#pffeaturedimageuploadfilepicker').on('touchend',function(){
														        	 $('#'+e.target.ruid).trigger('click');
														        }); 
													        };

											        
													        FeaturedfileInput.init();

														/* Remove Featured Image Ajax */
															$('#pfuploadfeaturedimg_remove').live('click touchstart',function(){

																$('.pfitemimgcontainer').pfLoadingOverlay({action:'show',message: '".esc_html__('Removing file(s)...','pointfindert2d')."'});

															    var formData = new mOxie.FormData();
													            formData.append('action','pfget_imageupload');
															    formData.append('security','".$nonceimgup."');
															    formData.append('oldup',1);
															    formData.append('exid', $('#pfuploadimagesrc').val());

															    var remove_xhr = new mOxie.XMLHttpRequest();
															    remove_xhr.open('POST', theme_scriptspf.ajaxurl, true);
															    remove_xhr.responseType = 'text';
															    remove_xhr.send(formData);
															    var clearfeaturedinterval = function(){
															    	clearInterval(removefeaturedimg);
															    }
															    var removefeaturedimg = setInterval(function(){
															    	if (remove_xhr.readyState == 4) {
															    		var obj = remove_xhr.response;
															    		obj = $.parseJSON(obj)
															    		
															    		if (obj.process == 'del') {
																			$('.pfuploadfeaturedimgupl-container').css('display','inline-block');
																			$('.pfuploadfeaturedimg-container').css('display','none');
																			$.pfuploadimagelimit = ".$images_newlimit.";
																			$('.pfmaxtext').text($.pfuploadimagelimit);
																		}
																		$('.pfitemimgcontainer').pfLoadingOverlay({action:'hide'});
																		clearfeaturedinterval();
															    	}
															    	$('#pfuploadimagesrc').val('');
															    	$.pfuploadmaximage = $.pfuploadedfilecount = 0;

															    }, 1000);
															});

														";
													/** 
													*Old Image Upload 
													**/

												}elseif ($setup4_submitpage_status_old == 0) {
												
													/**
													*Dropzone Upload
													**/
														$setup42_itempagedetails_configuration = (isset($pointfindertheme_option['setup42_itempagedetails_configuration']))? $pointfindertheme_option['setup42_itempagedetails_configuration'] : array();
														$images_count = 0;
														if($setup4_submitpage_imageupload == 1){
															
															$images_of_thispost = get_post_meta($params['post_id'],'webbupointfinder_item_images');
															$images_count = count($images_of_thispost) + 1;

															$this->FieldOutput .= '<div class="pfuploadedimages"></div>';

															/* Validation for upload */
															if ($params['formtype'] != 'edititem' && $setup4_submitpage_featuredverror_status == 1) {
															if($this->VSOMessages != ''){
																$this->VSOMessages .= ',pfuploadimagesrc:"'.$setup4_submitpage_featuredverror.'"';
															}else{
																$this->VSOMessages = 'pfuploadimagesrc:"'.$setup4_submitpage_featuredverror.'"';
															}

															if($this->VSORules != ''){
																$this->VSORules .= ',pfuploadimagesrc:"required"';
															}else{
																$this->VSORules = 'pfuploadimagesrc:"required"';
															}
															}
															if ($params['formtype'] != 'edititem') {
																$upload_limited = $setup4_submitpage_imagelimit;
															}else{
																$upload_limited = $setup4_submitpage_imagelimit - $images_count;
															}
															$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';
															

															$setup4_submitpage_imagesizelimit = PFSAIssetControl('setup4_submitpage_imagesizelimit','','2');/*Image size limit*/

															$this->FieldOutput .= '<div id="pfdropzoneupload" class="dropzone"></div>';
															if ($params['formtype'] != 'edititem') {
															$this->FieldOutput .= '<input type="hidden" class="pfuploadimagesrc" name="pfuploadimagesrc" id="pfuploadimagesrc">';
															}
															$this->FieldOutput .= '
															<script type="text/javascript">
															(function($) {
															"use strict";
																$(function(){
																	';
																	if(!empty($params['post_id'])){
																	$this->FieldOutput .= '$.pfitemdetail_listimages('.$params['post_id'].');';
																	}
																	$this->FieldOutput .= '
																	
																	$.drzoneuploadlimit = '.$upload_limited.';
																	var myDropzone = new Dropzone("div#pfdropzoneupload", {
																		url: theme_scriptspf.ajaxurl,
																		params: {
																	      action: "pfget_imageupload",
																	      security: "'.wp_create_nonce('pfget_imageupload').'",
																	      ';
																	      if ($params['formtype'] == 'edititem') {
																	      	$this->FieldOutput .= ' id:'.$params['post_id'];
																	      }
																		$this->FieldOutput .= ' 
																	    },
																		autoProcessQueue: true,
																		acceptedFiles:"image/*",
																		maxFilesize: '.$setup4_submitpage_imagesizelimit.',
																		maxFiles: '.$upload_limited.',
																		parallelUploads:1,
																		uploadMultiple: false,
																		';
																	      if ($params['formtype'] != 'edititem') {
																	      	$this->FieldOutput .= 'addRemoveLinks:true,';
																	      }
																		$this->FieldOutput .= ' 
																		dictDefaultMessage: "'.esc_html__( '','pointfindert2d').'<br/>'.esc_html__( '你可以最多上传','pointfindert2d').' <div class=\'pfuploaddrzonenum\'>{0}</div> '.esc_html__( '张图片','pointfindert2d').' '.sprintf(esc_html__('(最大%dMB 每张图片)','pointfindert2d'),$setup4_submitpage_imagesizelimit).' ".format($.drzoneuploadlimit),
																		dictFallbackMessage: "'.esc_html__( 'Your browser does not support drag and drop file upload', 'pointfindert2d' ).'",
																		dictInvalidFileType: "'.esc_html__( 'Unsupported file type', 'pointfindert2d' ).'",
																		dictFileTooBig: "'.sprintf(esc_html__( 'File size is too big. (Max file size: %dmb)', 'pointfindert2d' ),$setup4_submitpage_imagesizelimit).'",
																		dictCancelUpload: "",
																		dictRemoveFile: "'.esc_html__( 'Remove', 'pointfindert2d' ).'",
																		dictMaxFilesExceeded: "'.esc_html__( 'Max file exceeded', 'pointfindert2d' ).'",
																		clickable: "#pf-ajax-fileuploadformopen"
																	});
																	
																	Dropzone.autoDiscover = false;
																	
																	var uploadeditems = new Array();

																	myDropzone.on("success", function(file,responseText) {
																		var obj = [];
																		$.each(responseText, function(index, element) {
																			obj[index] = element;
																		});
																		';
																		
																	    if ($params['formtype'] != 'edititem') {
																		    $this->FieldOutput .= '

																			if (obj.process == "up" && obj.id.length != 0) {
																				file._removeLink.id = obj.id;
																				uploadeditems.push(obj.id);
																				$("#pfuploadimagesrc").val(uploadeditems);
																			}
																			';
																		}else{
																			$this->FieldOutput .= '
																				$(".pfuploaddrzonenum").text($.drzoneuploadlimit -1);
																				$.drzoneuploadlimit = $.drzoneuploadlimit -1
																		    	$.pfitemdetail_listimages('.$params['post_id'].');
																		    	myDropzone.options.maxFiles = $.drzoneuploadlimit;
																	      	';
																		}
																	    
																	$this->FieldOutput .= ' 
																		
																	});

function getOrientation(file, callback) {
  var reader = new FileReader();
  reader.onload = function(event) {
    var view = new DataView(event.target.result);
    if (view.getUint16(0, false) != 0xFFD8) return callback(-2);
    var length = view.byteLength,
        offset = 2;
    while (offset < length) {
      var marker = view.getUint16(offset, false);
      offset += 2;
      if (marker == 0xFFE1) {
        if (view.getUint32(offset += 2, false) != 0x45786966) {
          return callback(-1);
        }
        var little = view.getUint16(offset += 6, false) == 0x4949;
        offset += view.getUint32(offset + 4, little);
        var tags = view.getUint16(offset, little);
        offset += 2;
        for (var i = 0; i < tags; i++)
          if (view.getUint16(offset + (i * 12), little) == 0x0112)
            return callback(view.getUint16(offset + (i * 12) + 8, little));
      }
      else if ((marker & 0xFF00) != 0xFF00) break;
      else offset += view.getUint16(offset, false);
    }
    return callback(-1);
  };
  reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
};


myDropzone.on("addedfile", function(origFile) {
        getOrientation(origFile, function(orientation) {
                var reader = new FileReader();
                reader.addEventListener("load", function(event) {
                        var origImg = new Image();
                        origImg.src = event.target.result;
                        origImg.addEventListener("load", function(event) {
                                var w = event.target.width;
                                var h = event.target.height;

                                if ([5,6,7,9].indexOf(orientation) > -1) {
                                        var t = w; w = h; h = t;
                                }
                                if (w > h ) {
                                } else {
                                        alert("为了保证显示效果，请选择横向的图片。如果您用手机拍摄图片，请横向拍摄图片");
                                        myDropzone.removeFile(origFile);
                                }
                        });
                });
                reader.readAsDataURL(origFile);
         });
});



																	myDropzone.on("totaluploadprogress",function(uploadProgress,totalBytes,totalBytesSent){
																		
																		if (uploadProgress > 0 ) {
																			$("#pf-ajax-uploaditem-button").val("'.esc_html__( 'Please Wait for Image Upload...', 'pointfindert2d' ).'");
																			$("#pf-ajax-uploaditem-button").attr("disabled", true);
																		}
																		if(totalBytes == 0) {
																			$("#pf-ajax-uploaditem-button").attr("disabled", false);
																			$("#pf-ajax-uploaditem-button").val("'.PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','','').'");
																		}
																	});
																	';
																	if ($params['formtype'] != 'edititem') {
																		$this->FieldOutput .= ' 	
																			myDropzone.on("removedfile", function(file) {
																			    if (file.upload.progress != 0) {
																					if(file._removeLink.id.length != 0){
																						var removeditem = file._removeLink.id;
																						removeditem.replace(\'"\', "");
																						$.ajax({
																						    type: "POST",
																						    dataType: "json",
																						    url: theme_scriptspf.ajaxurl,
																						    data: { 
																						        action: "pfget_imageupload",
																				      			security: "'.wp_create_nonce('pfget_imageupload').'",
																				      			iid:removeditem
																						    }
																						});
																						for(var i = uploadeditems.length; i--;) {
																					          if(uploadeditems[i] == removeditem) {
																					              uploadeditems.splice(i, 1);
																					          }
																					      }
																						
																						$("#pfuploadimagesrc").val(uploadeditems);

																						$("#pf-ajax-uploaditem-button").attr("disabled", false);
																						$("#pf-ajax-uploaditem-button").val("'.PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','','').'");
																					}
																			    }
																			});
																			

																			myDropzone.on("queuecomplete",function(file){
																				$("#pf-ajax-uploaditem-button").attr("disabled", false);
																				$("#pf-ajax-uploaditem-button").val("'.PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','','').'");
																			});
																		';
																	}else{
																		$this->FieldOutput .= '
																			myDropzone.on("queuecomplete",function(file){
																				myDropzone.removeAllFiles();
																			});
																			
																			myDropzone.on("queuecomplete",function(file){
																				$("#pf-ajax-uploaditem-button").attr("disabled", false);
																				$("#pf-ajax-uploaditem-button").val("'.PFSAIssetControl('setup29_dashboard_contents_submit_page_titlee','','').'");
																			});
																		';
																	}
																$this->FieldOutput .= ' 	
																});
																
															})(jQuery);
															</script>
															
															<a id="pf-ajax-fileuploadformopen" class="button pfmyitempagebuttonsex" style="width:100%"><i class="pfadmicon-glyph-512"></i> '.esc_html__( '手机拍照上传图片', 'pointfindert2d' ).'</a>
															';
															$this->FieldOutput .= '</section>';
														}
													/**
													*Dropzone Upload
													**/
												}
												$this->FieldOutput .= '</section>';
											}
										/**
										*Image Upload
										**/



										/**
										*File Upload
										**/
											

											if ($is_editor && $stp4_fupl == 1) {
												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-sub-file">'.esc_html__('ATTACHMENT UPLOAD','pointfindert2d' ).'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfitemfilecontainer pferrorcontainer pfsubmit-inner-sub-file">';
												

												$stp4_Filelimit = PFSAIssetControl("stp4_Filelimit","","10");
												$stp4_Filesizelimit = PFSAIssetControl("stp4_Filesizelimit","","2");
												
												wp_register_script('moxieformforie', get_template_directory_uri() . '/js/moxie.min.js', array('jquery'), '1.4.1',true); 
												wp_enqueue_script('moxieformforie'); 

												$this->FieldOutput .= '<div class="pfuploadedfiles"></div>';

												$this->FieldOutput .= '
												<script type="text/javascript">
												(function($) {
												"use strict";
													$(function(){
														';
														if(!empty($params['post_id'])){
														$this->FieldOutput .= '$.pfitemdetail_listfiles('.$params['post_id'].');';
														}
												$this->FieldOutput .= ' 	
													});
													
												})(jQuery);
												</script>';

												$pffileuploadlimit = $stp4_Filelimit;
												$imagesvalue = '';
												if ($params['formtype'] != 'edititem') {
													$files_count = 0;
													$files_newlimit = $pffileuploadlimit;
												}else{

													$images_of_thispost = get_post_meta($params['post_id'],'webbupointfinder_item_files');

													$files_count = count($images_of_thispost);
													$files_newlimit = $pffileuploadlimit - $files_count;
												}

												$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';
												
												
												$this->FieldOutput .= '<label for="file" class="lbl-text">'.esc_html__('UPLOAD NEW ATTACHMENT','pointfindert2d').': ('.esc_html__('MAX','pointfindert2d').': '.$pffileuploadlimit.'/<span class="pfmaxtext2">'.$files_newlimit.'</span>) '.sprintf(esc_html__('(Allowed: Documents / Max. Size: %d MB)','pointfindert2d'),$stp4_Filesizelimit).':</label>';
												$this->FieldOutput .= '<div class="pfuploadfeaturedfile-container"><a id="pfuploadfeaturedfile_remove" style="font-size: 12px;line-height: 14px;"><i class="pfadmicon-glyph-64" style="font-size: 14px;"></i> '.esc_html__('Remove Uploaded Files','pointfindert2d').'</a></div>';
												$this->FieldOutput .= '<div class="pfuploadfeaturedfileupl-container">';
												$this->FieldOutput .= '
					                            <label for="file" class="lbl-ui file-input">
						                            <div id="pffeaturedfileuploadcontainer">
												        <a id="pffeaturedfileuploadfilepicker" href="javascript:;"><i class="pfadmicon-glyph-512"></i> '.esc_html__('Choose Files','pointfindert2d').'</a>
												    </div>
					                            </label> 
					                            </div>
												';
												
												$this->FieldOutput .= '</section>';

												$this->FieldOutput .= '<input type="hidden" name="pfuploadfilesrc" id="pfuploadfilesrc" value="'.$imagesvalue.'">';
												
												if($stp4_err_st == 1 && $params['formtype'] != 'edititem'){
													
													if($this->VSOMessages != ''){
														$this->VSOMessages .= ',pfuploadfilesrc:"'.$stp4_err.'"';
													}else{
														$this->VSOMessages = 'pfuploadfilesrc:"'.$stp4_err.'"';
													}

													if($this->VSORules != ''){
														$this->VSORules .= ',pfuploadfilesrc:"required"';
													}else{
														$this->VSORules = 'pfuploadfilesrc:"required"';
													}
												}

												$nonceimgup = wp_create_nonce('pfget_fileupload');
												

												$this->ScriptOutput .= "$.pfuploadfilelimit = ".$files_newlimit.";";

												if ($params['formtype'] == 'edititem') {
													$this->ScriptOutput .= "
													if ($.pfuploadfilelimit <= 0) {
														$('.pfuploadfeaturedfile-container').css('display','none');
														$('.pfuploadfeaturedfileupl-container').css('display','none');
													}
													
													if ($.pfuploadfilelimit <= ".$pffileuploadlimit."){
														$('.pfuploadfeaturedfileupl-container').css('display','inline-block');
													}

													if (".$files_newlimit." == 0) {
														$('.pfuploadfeaturedfileupl-container').css('display','none');
													}
													
													";
												}

												$stp4_allowed = PFSAIssetControl("stp4_allowed","",'jpg,jpeg,gif,png,pdf,rtf,csv,zip, x-zip, x-zip-compressed,rar,doc,docx,docm,dotx,dotm,docb,xls,xlt,xlm,xlsx,xlsm,xltx,xltm,ppt,pot,pps,pptx,pptm');

												$this->ScriptOutput .= "
												
												/*File upload featured image AJAX */
													var PFfileInput = new mOxie.FileInput({
											            browse_button: document.getElementById('pffeaturedfileuploadfilepicker'),
											            container: 'pffeaturedfileuploadcontainer',
											            accept: [{ title: 'Documents', extensions: '".$stp4_allowed."' }],
											            multiple: true
											        });
													



											        $.pfuploadedfilecount = 0;

											        $.pfuploadoldfiles = function(id){
											        	var numberi = id;
											        	numberi = numberi + 1;
										        		$('.pfitemfilecontainer').pfLoadingOverlay({action:'show',message: '".esc_html__('Uploading file: ','pointfindert2d')."'+numberi});

														if ($.pfuploadfilelimit > 0 && $.pfuploadedfilecount < $.pfuploadmaxfile) {
														
												            var formData = new mOxie.FormData();
												            formData.append('action','pfget_fileupload');
														    formData.append('security','".$nonceimgup."');
														    formData.append('oldup',1);
														    formData.append('pfuploadfeaturedfile', PFfileInput.files[id]);

														    var featured_xhr = new mOxie.XMLHttpRequest();
														    featured_xhr.open('POST', theme_scriptspf.ajaxurl, true);
														    featured_xhr.responseType = 'text';
														    featured_xhr.send(formData);

														    var clearfeaturedinterval = function(){

														    	clearInterval(featureimgint);

														    	$.pfuploadedfilecount = $.pfuploadedfilecount + 1;
																$.pfuploadfilelimit = $.pfuploadfilelimit - 1;

														    	if ($.pfuploadedfilecount == $.pfuploadmaxfile) {
															    	if ($.pfuploadfilelimit > 0) {
															    		$('.pfuploadfeaturedfileupl-container').css('display','inline-block');
															    	}else{
															    		$('.pfuploadfeaturedfileupl-container').css('display','none');
															    	}
																	$('.pfuploadfeaturedfile-container').css('display','inline-block');
																	$('.pfitemfilecontainer').pfLoadingOverlay({action:'hide'});
															    }

															    if ($.pfuploadfilelimit > 0) {
														    		$('.pfuploadfeaturedfileupl-container').css('display','inline-block');
														    	}else{
														    		$('.pfuploadfeaturedfileupl-container').css('display','none');
														    	}

															    $('.pfmaxtext2').text($.pfuploadfilelimit);
															    $.pfuploadoldfiles($.pfuploadedfilecount);
														    }

														    var featureimgint = setInterval(function(){
														    	if (featured_xhr.readyState == 4) {
														    		var obj = featured_xhr.response;
														    		obj = $.parseJSON(obj)
														    		
															    		if (obj.process == 'up') {

																			var uploadedfiles = $('#pfuploadfilesrc').val();
																			if (uploadedfiles.length > 0) {
																				uploadedfiles = uploadedfiles+','+obj.id;
																				$('#pfuploadfilesrc').val(uploadedfiles);
																			}else{
																				$('#pfuploadfilesrc').val(obj.id);
																			}
																		}
																	clearfeaturedinterval();
														    	}
														    }, 1000);																	
														}else{
															if ($.pfuploadfilelimit > 0) {
													    		$('.pfuploadfeaturedfileupl-container').css('display','inline-block');
													    	}else{
													    		$('.pfuploadfeaturedfileupl-container').css('display','none');
													    	}
															$('.pfuploadfeaturedfile-container').css('display','inline-block');
															$('.pfitemfilecontainer').pfLoadingOverlay({action:'hide'});
															$.pfuploadmaxfile = $.pfuploadedfilecount = 0;
														};
											        };

											        PFfileInput.onchange = function(e) {
											        	if (PFfileInput.files && PFfileInput.files.length) {
												       		$.pfuploadmaxfile = PFfileInput.files.length;
												       		$.pfuploadoldfiles(0);
											       		}
											        };

													PFfileInput.onready = function(e) {
												        $('#pffeaturedfileuploadcontainer').on('touchend',function(){
												        	 $('#'+e.target.ruid).trigger('click');
												        }); 
											        };

											        
											        PFfileInput.init();

												/* Remove Featured Files Ajax */
													$('#pfuploadfeaturedfile_remove').live('click touchstart',function(){

														$('.pfitemfilecontainer').pfLoadingOverlay({action:'show',message: '".esc_html__('Removing file(s)...','pointfindert2d')."'});

													    var formData = new mOxie.FormData();
											            formData.append('action','pfget_fileupload');
													    formData.append('security','".$nonceimgup."');
													    formData.append('oldup',1);
													    formData.append('exid', $('#pfuploadfilesrc').val());

													    var remove_xhr = new mOxie.XMLHttpRequest();
													    remove_xhr.open('POST', theme_scriptspf.ajaxurl, true);
													    remove_xhr.responseType = 'text';
													    remove_xhr.send(formData);
													    var clearfeaturedinterval = function(){
													    	clearInterval(removefeaturedimg);
													    }
													    var removefeaturedimg = setInterval(function(){
													    	if (remove_xhr.readyState == 4) {
													    		var obj = remove_xhr.response;
													    		obj = $.parseJSON(obj)
													    		
													    		if (obj.process == 'del') {
																	$('.pfuploadfeaturedfileupl-container').css('display','inline-block');
																	$('.pfuploadfeaturedfile-container').css('display','none');
																	$.pfuploadfilelimit = ".$files_newlimit.";
																	$('.pfmaxtext2').text($.pfuploadfilelimit);
																}
																$('.pfitemfilecontainer').pfLoadingOverlay({action:'hide'});
																clearfeaturedinterval();
													    	}
													    	$('#pfuploadfilesrc').val('');
													    	$.pfuploadmaxfile = $.pfuploadedfilecount = 0;

													    }, 1000);
													});

												";
												$this->FieldOutput .= '</section>';

											}
										/**
										*File Upload
										**/


										/**
										*Message to Reviewer
										**/
											if($is_editor && $setup4_submitpage_messagetorev == 1){

												$this->FieldOutput .= '<div class="pfsubmit-title">'.esc_html__('打折优惠','pointfindert2d').'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner">';
												$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';
												$this->FieldOutput .= '
							                        <label class="lbl-ui">
							                        	<textarea id="item_mesrev" name="item_mesrev" class="textarea mini"></textarea>';
												$this->FieldOutput .= '<b class="tooltip left-bottom"><em>'.esc_html__('OPTIONAL:','pointfindert2d').esc_html__('打折优惠','pointfindert2d').'</em></b>';
												 
							                    $this->FieldOutput .= '</label>';
							                    $this->FieldOutput .= '</section>';                     
							                  	$this->FieldOutput .= '</section>'; 
												
											}
										/**
										*Message to Reviewer
										**/


										/** 
										*Featured Item 
										**/
											$featured_permission = true;
                                            if ($is_editor) {
    											if ($setup4_membersettings_paymentsystem == 2) {
    												if ($params['formtype'] == 'edititem') {
    													if ($packageinfo['webbupointfinder_mp_fitemnumber'] <= 0) {
    														$featured_permission = false;
    													}elseif ($membership_user_featureditem_limit <= 0 && $package_featuredcheck != 1) {
    														$featured_permission = false;
    													}
    												}else{
    													if ($membership_user_featureditem_limit <= 0) {
    														$featured_permission = false;
    													}
    												}
    											}else{
    												if ($params['formtype'] == 'edititem') {
    													$featured_permission = true;
    												}
    												if (PFSAIssetControl('setup31_userpayments_featuredoffer','','1') != 1) {
    													$featured_permission = false;
    												}
    											}
                                            }

											if ($is_editor && $featured_permission) {
												if ($setup4_membersettings_paymentsystem != 2) {

													$setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','5');
													$stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

													if ($stp31_daysfeatured > 1) {
														$featured_day_word = esc_html__(' days','pointfindert2d');
													}else{
														$featured_day_word = esc_html__(' day','pointfindert2d');
													}

													$featured_price_output = '';
													if ($package_featuredcheck != 1) {
														if ($setup31_userpayments_pricefeatured == 0) {
															$featured_price_output = '<span class="pfitem-featuredprice" title="'.sprintf(esc_html__('For %d %s','pointfindert2d' ),$stp31_daysfeatured,$featured_day_word).'">'.$stp31_daysfeatured.$featured_day_word.'</span>';
														}else{

															$setup31_userpayments_pricefeatured_rf = pointfinder_reformat_pricevalue_for_frontend($setup31_userpayments_pricefeatured);

															$featured_price_output = ' <span class="pfitem-featuredprice" title="'.sprintf(esc_html__('Price is %s for %d %s','pointfindert2d' ),$setup31_userpayments_pricefeatured,$stp31_daysfeatured,$featured_day_word).'">'.$setup31_userpayments_pricefeatured_rf.' / '.$stp31_daysfeatured.$featured_day_word.'</span>';
														}
													}

													$this->FieldOutput .= '<div class="pfsubmit-title">'.PFSAIssetControl('setup31_userpayments_titlefeatured','','Featured Item').$featured_price_output.'</div>';
													$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-nopadding">';

													
								                    if($package_featuredcheck == 1 && $current_post_status != 'pendingpayment'){
														$pointfinder_order_expiredate_featured = esc_attr(get_post_meta( PFU_GetOrderID($params['post_id'],1), 'pointfinder_order_expiredate_featured', true ));
														$featured_listing_expiry = PFU_Dateformat($pointfinder_order_expiredate_featured);
														$status_featured_it_text = sprintf(esc_html__('This item is featured until %s','pointfindert2d'),'<b>'.$featured_listing_expiry.'</b>');
								                    }else{
								                    	$status_featured_it_text = PFSAIssetControl('setup31_userpayments_textfeatured','','');
								                    }

													$this->FieldOutput .= '								
							                            <div class="gspace pfupload-featured-item-box" style="border:0;padding: 12px;">
							                            	<p>
															';
																$pp_status_checked = $pp_status_checked2 = '';

																if ($this->itemrecurringstatus == 1) {
																	$pp_status_checked2 = ' disabled="disabled"';
																}


																if($package_featuredcheck == 1 && $current_post_status != 'pendingpayment'){
																	$this->FieldOutput .='<input type="hidden" name="featureditembox" id="featureditembox">';
																}else{

																	if ($current_post_status == 'pendingpayment') {
																		if ($package_featuredcheck == 1) {
																			$pp_status_checked = ' checked="checked"';
																		}
																	}
																	
																	
																	$this->FieldOutput .='
																	<label class="toggle-switch blue">
																	<input type="checkbox" name="featureditembox" id="featureditembox"'.$pp_status_checked.$pp_status_checked2.'>
																	<label for="featureditembox" data-on="'.esc_html__('YES','pointfindert2d').'" data-off="'.esc_html__('NO','pointfindert2d').'"></label>
																	</label>';
																	
																}
																$this->FieldOutput .= $status_featured_it_text;
															  $this->FieldOutput .= '
															</p>
							                            </div>';
								                    
								                    $this->FieldOutput .= '</section>';
												}else{
													$pf_member_checked_t = '';

													$pf_member_checked = get_post_meta( $params['post_id'], 'webbupointfinder_item_featuredmarker', true );

													if (!empty($pf_member_checked)) {
														$pf_member_checked_t = ' checked';
													}
													$setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','');

													$this->FieldOutput .= '<div class="pfsubmit-title">'.PFSAIssetControl('setup31_userpayments_titlefeatured','','Featured Item').'</div>';
													$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-nopadding">';
													

													$this->FieldOutput .= '								
							                            <div class="gspace pfupload-featured-item-box" style="border:0;padding: 12px;">
							                            	<p>
															<label class="toggle-switch blue">
																<input type="checkbox" name="featureditembox" id="featureditembox"'.$pf_member_checked_t.'>
																<label for="featureditembox" data-on="'.esc_html__('YES','pointfindert2d').'" data-off="'.esc_html__('NO','pointfindert2d').'"></label>
															</label> 
															 <span>
															   '.PFSAIssetControl('setup31_userpayments_textfeatured','','').'
															  </span>
															</p>          
															

							                            </div>';
							                        $this->FieldOutput .= '</section>';
												}
												
												
						                    	
						                    	
						                    }
										/**
										*Featured Item 
										**/


										/**
										*Select package
										**/
											if ($is_editor && $setup4_membersettings_paymentsystem == 1) {
												
												$stp31_up2_pn = PFSAIssetControl('stp31_up2_pn','','Basic Package');
												$setup31_userpayments_priceperitem = PFSAIssetControl('setup31_userpayments_priceperitem','','10');
												$setup31_userpayments_timeperitem = PFSAIssetControl('setup31_userpayments_timeperitem','','10');

												$this->FieldOutput .= '<div class="pfsubmit-title">'.esc_html__('Listing Packages','pointfindert2d').'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner">';
												$this->FieldOutput .= '<section class="pfsubmit-inner-sub" style="margin-left: -7px;">';

													$this->FieldOutput .= '<div class="pflistingtype-selector-main-top clearfix">';
													/* Add first package - Price/Time/Name */
													$ppp_packages = array();
													$ppp_packages[] = array('id'=>1,'price'=>$setup31_userpayments_priceperitem,'time'=>$setup31_userpayments_timeperitem,'title'=>$stp31_up2_pn);


													$listing_query = new WP_Query(array('post_type' => 'pflistingpacks','posts_per_page' => -1,'order_by'=>'ID','order'=>'ASC'));
													$this_pack_price = $this_pack_info = '';

													$founded_listingpacks = 0;
													$founded_listingpacks = $listing_query->found_posts;

													if ($founded_listingpacks > 0) {
														if ( $listing_query->have_posts() ) {
															$this->FieldOutput .= '<ul>';
															while ( $listing_query->have_posts() ) {
																$listing_query->the_post();
																$lp_post_id = get_the_id();

																$lp_price = get_post_meta( $lp_post_id, 'webbupointfinder_lp_price', true );
																if (empty($lp_price)) {
																	$lp_price = 0;
																}

																$lp_time = get_post_meta( $lp_post_id, 'webbupointfinder_lp_billing_period', true );
																if (empty($lp_time)) {
																	$lp_time = 0;
																}

																$lp_show = get_post_meta( $lp_post_id, 'webbupointfinder_lp_showhide', true );

																if ($lp_show == 1) {
																	array_push($ppp_packages, array('id'=>$lp_post_id, 'price'=>$lp_price, 'time'=>$lp_time, 'title'=>get_the_title($lp_post_id)));
																}
															}
															$this->FieldOutput .= '</ul>';
															wp_reset_postdata();
														}
													}
													
													if ($this->itemrecurringstatus == 1) {
														$status_checked_pack = ' disabled="disabled"';
													}else{
														$status_checked_pack = '';
													}

													$stp31_userfree = PFSAIssetControl("stp31_userfree","","0");

													$status_package_selection = true;

													

													if ($ppp_packages > 0) {

														foreach ($ppp_packages as $ppp_package) {
															
															if ($ppp_package['price'] == 0) {
																$this_pack_price = esc_html__('Free','pointfindert2d');
															}else{

																$this_pack_price = pointfinder_reformat_pricevalue_for_frontend($ppp_package['price']);

																$this_pack_price = ' <span style="font-weight:600;" title="'.esc_html__('This package price is ','pointfindert2d' ).$this_pack_price.'">'.$this_pack_price.'</span>';
															}

															if ($current_post_status == 'publish') {
																if ($default_package == $ppp_package['id']) {
																	$status_package_selection = true;
																}else{
																	if ($ppp_package['price'] == 0 && $params['formtype'] == 'edititem' && $stp31_userfree == 0) {
																		$status_package_selection = false;
																	}else{
																		$status_package_selection = true;
																	}
																}
																
															}elseif ($current_post_status == 'pendingpayment') {
																if ($params['formtype'] == 'edititem') {
																	$pointfinder_order_expiredate = esc_attr(get_post_meta( PFU_GetOrderID($params['post_id'],1), 'pointfinder_order_expiredate', true ));
																}else{
																	$pointfinder_order_expiredate = false;
																}
																
																
																if ($ppp_package['price'] == 0 && $pointfinder_order_expiredate != false && $params['formtype'] == 'edititem' && $stp31_userfree == 0) {
																	$status_package_selection = false;
																}else{
																	$status_package_selection = true;
																}
															}

															if ($status_package_selection) {
																$this->FieldOutput .= '<div class="pfpack-selector-main">';
																$this->FieldOutput .= '<input type="radio" name="pfpackselector" id="pfpackselector'.$ppp_package['id'].'" class="pfpackselector" value="'.$ppp_package['id'].'"'.$status_checked_pack.' '.checked( $default_package, $ppp_package['id'],0).'/>';
																$this->FieldOutput .= '<label for="pfpackselector'.$ppp_package['id'].'" style="font-weight:600;">
																<span class="packselector-title">'.$ppp_package['title'].'</span>
																<span class="packselector-info">'.sprintf(esc_html__("For %s day(s)",'pointfindert2d' ),$ppp_package['time']).'</span>
																<span class="packselector-price">'.$this_pack_price.'</span>
																</label>';
																$this->FieldOutput .= '</div>';
															}

															
															
															

														}
													}
													
													
													$this->FieldOutput .= '</div>';

							                    $this->FieldOutput .= '</section>';                     
							                  	$this->FieldOutput .= '</section>';
							                  	$this->PFValidationCheckWrite(1,esc_html__('Please select a package.','pointfindert2d' ),'pfpackselector');
							                }
										/**
										*Select package
										**/


										/**
										*Total Cost
										**/
											if ($is_editor && $setup4_membersettings_paymentsystem == 1) {
												
												$this->FieldOutput .= '<div class="pfsubmit-title pfsubmit-inner-payment">'.esc_html__('Payment','pointfindert2d').'</div>';
												$this->FieldOutput .= '<section class="pfsubmit-inner pfsubmit-inner-payment">';
												$this->FieldOutput .= '<section class="pfsubmit-inner-sub">';

													$this->FieldOutput .= '<div class="pfsubmit-inner-totalcost-output"></div>';

							                    $this->FieldOutput .= '</section>';                     
							                  	$this->FieldOutput .= '</section>';
							                  	$this->PFValidationCheckWrite(1,esc_html__('Please select a payment type.','pointfindert2d' ),'pf_lpacks_payment_selection');
							                }
										/**
										*Total Cost
										**/


										/**
										*Terms and conditions
										**/
											$setup4_ppp_terms = PFSAIssetControl('setup4_ppp_terms','','1');
											if ($is_editor && $setup4_ppp_terms == 1) {
												if($this->VSOMessages != ''){
													$this->VSOMessages .= ',pftermsofuser:"'.esc_html__( 'You must accept terms and conditions.', 'pointfindert2d' ).'"';
												}else{
													$this->VSOMessages = 'pftermsofuser:"'.esc_html__( 'You must accept terms and conditions.', 'pointfindert2d' ).'"';
												}

												if($this->VSORules != ''){
													$this->VSORules .= ',pftermsofuser:"required"';
												}else{
													$this->VSORules = 'pftermsofuser:"required"';
												}

												global $wpdb;
												$terms_conditions_template = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s ",'_wp_page_template','terms-conditions.php'), ARRAY_A);
												if (isset($terms_conditions_template[0]['post_id'])) {
													$terms_permalink = get_permalink($terms_conditions_template[0]['post_id']);
												}else{
													$terms_permalink = '#';
												}
												
												
												if ($params['formtype'] == 'edititem') {
													$checktext1 = ' checked=""';
												}else{$checktext1 = '';}
												$pfmenu_perout = PFPermalinkCheck();
												$this->FieldOutput .= '<section>';
												$this->FieldOutput .= '
													<span class="goption upt">
					                                    <label class="options">
					                                        <input type="checkbox" id="pftermsofuser" name="pftermsofuser" value="1"'.$checktext1.'>
					                                        <span class="checkbox"></span>
					                                    </label>
					                                    <label for="check1">'.sprintf(esc_html__( 'I have read the %s terms and conditions %s and accept them.', 'pointfindert2d' ),'<a href="'.$terms_permalink.$pfmenu_perout.'ajax=true&width=800&height=400" rel="prettyPhoto[ajax]"><strong>','</strong></a>').'</label>
					                               </span>
												';
												
								                $this->FieldOutput .= '</section>';
								            }
										/**
										*Terms and conditions
										**/

									$this->FieldOutput .= '</div>';
									if (!$is_editor) {
									    $this->ScriptOutput .= '$("#pf-ajax-uploaditem-button").show();';
                                        $this->ScriptOutput .= '$(".pf-excludecategory-container").show();';
                                        $this->ScriptOutput .= '$.pf_submit_page_map();';
                                        
									}
								
								/** 
								*End : First Column (Map area, Image upload etc..)
								**/
							}


						/**
						*End: New Item Page Content
						**/
						}
						break;

					case 'profile':
						/**
						*Start: Profile Page Content
						**/
								$noncefield = wp_create_nonce('pfget_updateuserprofile');
								$formaction = 'pfget_updateuserprofile';
								$buttonid = 'pf-ajax-profileupdate-button';
								$buttontext = esc_html__('UPDATE INFO','pointfindert2d');
								$current_user = get_user_by( 'id', $params['current_user'] ); 
								$user_id = $current_user->ID;
								$usermetaarr = get_user_meta($user_id);
								$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

								$stp_prf_vat = PFSAIssetControl('stp_prf_vat','','1');
								$stp_prf_country = PFSAIssetControl('stp_prf_country','','1');
								$stp_prf_address = PFSAIssetControl('stp_prf_address','','1');
								$stp_prf_city = PFSAIssetControl('stp_prf_city','','1');
								
								if(!isset($usermetaarr['first_name'])){$usermetaarr['first_name'][0] = '';}
								if(!isset($usermetaarr['last_name'])){$usermetaarr['last_name'][0] = '';}
								if(!isset($usermetaarr['user_phone'])){$usermetaarr['user_phone'][0] = '';}
								if(!isset($usermetaarr['user_mobile'])){$usermetaarr['user_mobile'][0] = '';}
								if(!isset($usermetaarr['description'])){$usermetaarr['description'][0] = '';}
								if(!isset($usermetaarr['nickname'])){$usermetaarr['nickname'][0] = '';}
								if(!isset($usermetaarr['user_twitter'])){$usermetaarr['user_twitter'][0] = '';}
								if(!isset($usermetaarr['user_facebook'])){$usermetaarr['user_facebook'][0] = '';}
								if(!isset($usermetaarr['user_googleplus'])){$usermetaarr['user_googleplus'][0] = '';}
								if(!isset($usermetaarr['user_linkedin'])){$usermetaarr['user_linkedin'][0] = '';}
								if(!isset($usermetaarr['user_vatnumber'])){$usermetaarr['user_vatnumber'][0] = '';}
								if(!isset($usermetaarr['user_country'])){$usermetaarr['user_country'][0] = '';}
								if(!isset($usermetaarr['user_address'])){$usermetaarr['user_address'][0] = '';}
								if(!isset($usermetaarr['user_city'])){$usermetaarr['user_city'][0] = '';}

								if(!isset($usermetaarr['user_photo'])){
									$usermetaarr['user_photo'][0] = '<img src= "'.get_template_directory_uri().'/images/noimg.png">';
								}else{
									if($usermetaarr['user_photo'][0]!= ''){
										$usermetaarr['user_photo'][0] = wp_get_attachment_image( $usermetaarr['user_photo'][0] );
									}else{
										$usermetaarr['user_photo'][0] = '<img src= "'.get_template_directory_uri().'/images/noimg.png" width:"50" height="50">';
									}
								}

								$this->ScriptOutput = "
									$.pfAjaxUserSystemVars4 = {};
									$.pfAjaxUserSystemVars4.email_err = '".esc_html__('Please write an email','pointfindert2d')."';
									$.pfAjaxUserSystemVars4.email_err2 = '".esc_html__('Your email address must be in the format of name@domain.com','pointfindert2d')."';
									$.pfAjaxUserSystemVars4.nickname_err = '".esc_html__('Please write nickname','pointfindert2d')."';
									$.pfAjaxUserSystemVars4.nickname_err2 = '".esc_html__('Please enter at least 3 characters for nickname.','pointfindert2d')."';
									$.pfAjaxUserSystemVars4.passwd_err = '".esc_html__('Enter at least 7 characters','pointfindert2d')."';
									$.pfAjaxUserSystemVars4.passwd_err2 = '".esc_html__('Enter the same password as above','pointfindert2d')."';
								";

								$this->FieldOutput .= '
		                           <div class="col6 first">
		                           	   <section>
		                                    <label for="username" class="lbl-text"><strong>'.esc_html__('User Name','pointfindert2d').'</strong>:</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="username" class="input" value="'.$current_user->user_login.'" />
		                                    	<input type="hidden" name="username_old" class="input" value="'.$current_user->user_login.'" />
		                                    </label>
		                               </section>
		                               <section>
		                                    <label for="email" class="lbl-text"><strong>'.esc_html__('Email Address','pointfindert2d').'(*)</strong>:</label>
		                                    <label class="lbl-ui">
		                                    	<input  type="email" name="email" class="input" value="'.$current_user->user_email.'" />
		                                    </label>
		                                </section>
		                               <section>
		                                    <label for="nickname" class="lbl-text"><strong>'.esc_html__('Nickname (Display Name)','pointfindert2d').'(*)</strong>:</label>
		                                    <label class="lbl-ui">
		                                    	<input  type="text" name="nickname" class="input" value="'.$usermetaarr['nickname'][0].'" />
		                                    </label>
		                                </section>
		                               <section>
		                                    <label for="descr" class="lbl-text">'.esc_html__('Biographical Info','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<textarea name="descr" class="textarea mini no-resize">'.$usermetaarr['description'][0].'</textarea>
		                                    </label>                          
		                               </section> 
		                               <section>
		                                    <label for="userphoto" class="lbl-text">'.esc_html__('User Photo (Recommend:200px W/H)','pointfindert2d').' (.jpg, .png, .gif):</label>
		                                    <div class="col-lg-3">
		                                    <div class="pfuserphoto-container">
		                               		'.$usermetaarr['user_photo'][0].'
		                               		</div>
		                               		</div>
		                                    <div class="col-lg-9">
		                                    <label for="userphoto" class="lbl-ui file-input">
		                                    <input type="file" name="userphoto" />
		                                    <div class="clearfix" style="margin-bottom:10px"></div>     
		                                    <span class="goption">
				                                <label class="options">
				                                    <input type="checkbox" name="deletephoto" value="1">
				                                    <span class="checkbox"></span>
				                                </label>
				                                <label for="check1">'.esc_html__('Remove Photo','pointfindert2d').'</label>
				                           </span>
		                                    </div>
		                                    </label>  
		                                    <div class="clearfix"></div>             
		                               </section>
		                               <section>
		                                    <label for="password" class="lbl-text">'.esc_html__('New Password','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="password" name="password" id="password" class="input" />
		                                    </label>                          
		                               </section> 
		                               <section>
		                                    <label for="password2" class="lbl-text">'.esc_html__('Repeat New Password','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="password" name="password2" class="input" />
		                                    </label>                          
		                               </section>   
		                               <section><small><strong>
		                               		'. esc_html__('Hint:','pointfindert2d').'</strong> '. esc_html__('The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).','pointfindert2d').'</small>
		                               </section> 
		                               ';
		                                if (!empty($stp_prf_address)) {
			                                $this->FieldOutput .= '
			                                 <section>
			                                    <label for="address" class="lbl-text">'.esc_html__('Address','pointfindert2d').':</label>
			                                    <label class="lbl-ui">
			                                    	<textarea name="address" class="textarea mini no-resize">'.$usermetaarr['user_address'][0].'</textarea>
			                                    </label>                          
			                               </section>          
			                                ';
		                            	}
		                               $this->FieldOutput .= '
		                                                
		                           </div>


		                           <div class="col6 last">
		                           		<section>
		                                    <label for="firstname" class="lbl-text">'.esc_html__('First name','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="firstname" class="input" value="'.$usermetaarr['first_name'][0].'" />
		                                    </label>
		                                </section>
		                           		<section>
		                                    <label for="lastname" class="lbl-text">'.esc_html__('Last Name','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="lastname" class="input" value="'.$usermetaarr['last_name'][0].'" />
		                                    </label>
		                                </section>                                                           
		                           		<section>
		                                    <label for="webaddr" class="lbl-text">'.esc_html__('Website','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="webaddr" class="input" value="'.$current_user->user_url.'" />
		                                    </label>
		                                </section>
		                                <section>
		                                    <label for="phone" class="lbl-text">'.esc_html__('Telephone','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="tel" name="phone" class="input" placeholder="" value="'.$usermetaarr['user_phone'][0].'" />
		                                    </label>                            
		                                </section> 
		                                <section>
		                                    <label for="mobile" class="lbl-text">'.esc_html__('Mobile','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="tel" name="mobile" class="input" placeholder="" value="'.$usermetaarr['user_mobile'][0].'"/>
		                                    </label>                            
		                                </section> 
		                                <section>
		                                    <label for="twitter" class="lbl-text">'.esc_html__('Twitter','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="twitter" class="input" value="'.$usermetaarr['user_twitter'][0].'"/>
		                                    </label>
		                                </section>   
		                                <section>
		                                    <label for="facebook" class="lbl-text">'.esc_html__('Facebook','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="facebook" class="input" value="'.$usermetaarr['user_facebook'][0].'" />
		                                    </label>
		                                </section> 
		                                <section>
		                                    <label for="googleplus" class="lbl-text">'.esc_html__('Google+','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="googleplus" class="input" value="'.$usermetaarr['user_googleplus'][0].'" />
		                                    </label>
		                                </section> 
		                                <section>
		                                    <label for="linkedin" class="lbl-text">'.esc_html__('LinkedIn','pointfindert2d').':</label>
		                                    <label class="lbl-ui">
		                                    	<input type="text" name="linkedin" class="input" value="'.$usermetaarr['user_linkedin'][0].'"/>
		                                    </label>
		                                </section>
		                                ';
		                                if (!empty($stp_prf_vat)) {
			                                $this->FieldOutput .= '
			                                 <section>
			                                    <label for="vatnumber" class="lbl-text">'.esc_html__('VAT Number','pointfindert2d').':</label>
			                                    <label class="lbl-ui">
			                                    	<input type="text" name="vatnumber" class="input" value="'.$usermetaarr['user_vatnumber'][0].'"/>
			                                    </label>
			                                </section>
			                                ';
		                            	}

		                            	if (!empty($stp_prf_country)) {
			                                $this->FieldOutput .= '
			                                <section>
			                                    <label for="country" class="lbl-text">'.esc_html__('Country','pointfindert2d').':</label>
			                                    <label class="lbl-ui">
			                                    	<input type="text" name="country" class="input" value="'.$usermetaarr['user_country'][0].'"/>
			                                    </label>
			                                </section>     
			                                ';
		                            	}

		                            	if (!empty($stp_prf_city)) {
			                                $this->FieldOutput .= '
			                                <section>
			                                    <label for="city" class="lbl-text">'.esc_html__('City','pointfindert2d').':</label>
			                                    <label class="lbl-ui">
			                                    	<input type="text" name="city" class="input" value="'.$usermetaarr['user_city'][0].'"/>
			                                    </label>
			                                </section>     
			                                ';
		                            	}
		                                $this->FieldOutput .= '     
		                                                 
		                           </div>
		                          
					            ';

					            if ($setup4_membersettings_paymentsystem == 2) {
									/*Get user meta*/
									$membership_user_activeorder = get_user_meta( $user_id, 'membership_user_activeorder', true );
									$membership_user_recurring = get_user_meta( $user_id, 'membership_user_recurring', true );
									$recurring_status = esc_attr(get_post_meta( $membership_user_activeorder, 'pointfinder_order_recurring',true));
									if($recurring_status == 1 && $membership_user_recurring == 1){
										$this->FieldOutput .= '
											<div class="row"><div class="col12">
											<hr/>
											<div class="col8 first">
											<section>
			                                    <label for="recurring" class="lbl-text" style="margin-top:12px"><strong>'.esc_html__('Recurring Profile','pointfindert2d').'</strong>:</label>
			                                    <label class="lbl-ui">
											<p>'.__("You are using Paypal Recurring Payments. If want to upgrade your membership plan please cancel this option. Be careful this action can not roll back.",'pointfindert2d').'</p></label></section></div>
											<div class="col4 last"><section style="text-align:right;margin-top: 35px;">
			                                    	<a class="pf-dash-cancelrecurring" title="'.esc_html__('This option for cancel recurring payment profile.','pointfindert2d').'">'.esc_html__('Cancel Recurring Profile','pointfindert2d').'</a></section></div>
			                                    
			                            	</div></div>';
			                        }
								}
				        /**
						*End: Profile Page Content
						**/
						break;

					case 'myitems':
						/**
						*Start: My Items Page Content
						**/
							$formaction = 'pf_refineitemlist';
							$noncefield = wp_create_nonce($formaction);
							$buttonid = 'pf-ajax-itemrefine-button';
							$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

							if ($params['redirect']) {
								echo '<script>window.location = "'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems'.'";</script>';
							}
							
							/**
							*Start: Content Area
							**/
								$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
								$setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');

								/*User Limits*/
								$setup31_userlimits_useredit = PFSAIssetControl('setup31_userlimits_useredit','','1');
								$setup31_userlimits_userdelete = PFSAIssetControl('setup31_userlimits_userdelete','','1');
								$setup31_userlimits_useredit_pending = PFSAIssetControl('setup31_userlimits_useredit_pending','','1');
								$setup31_userlimits_userdelete_pending = PFSAIssetControl('setup31_userlimits_userdelete_pending','','1');

								$setup4_membersettings_loginregister = PFSAIssetControl('setup4_membersettings_loginregister','','1');
								$setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');
								$setup31_userpayments_featuredoffer = PFSAIssetControl('setup31_userpayments_featuredoffer','','1');



								$this->FieldOutput .= '<div class="pfmu-itemlisting-container pfmu-itemlisting-container-new">';
									if ($params['fields']!= '') {
										$fieldvars = $params['fields'];
									}else{
										$fieldvars = '';
									}

									$selected_lfs = $selected_lfl = $selected_lfo2 = $selected_lfo = '';

									if (PFControlEmptyArr($fieldvars)) {
										
			                            if(isset($fieldvars['listing-filter-status'])){
			                           		if ($fieldvars['listing-filter-status'] != '') {
			                           			$selected_lfs = $fieldvars['listing-filter-status'];
			                           		}
			                            }

				                        if(isset($fieldvars['listing-filter-ltype'])){
				                       		if ($fieldvars['listing-filter-ltype'] != '') {
				                       			$selected_lfl = $fieldvars['listing-filter-ltype'];
				                       		}
				                        }

			                            if(isset($fieldvars['listing-filter-orderby'])){
			                           		if ($fieldvars['listing-filter-orderby'] != '') {
			                           			$selected_lfo = $fieldvars['listing-filter-orderby'];
			                           		}
			                            }

			                            if(isset($fieldvars['listing-filter-order'])){
			                           		if ($fieldvars['listing-filter-order'] != '') {
			                           			$selected_lfo2 = $fieldvars['listing-filter-order'];
			                           		}
			                            }

									}

									$current_user = wp_get_current_user();
									$user_id = $current_user->ID;

									$paged = ( esc_sql(get_query_var('paged')) ) ? esc_sql(get_query_var('paged')) : '';
									if (empty($paged)) {
										$paged = ( esc_sql(get_query_var('page')) ) ? esc_sql(get_query_var('page')) : 1;
									}

									$output_args = array(
											'post_type'	=> $setup3_pointposttype_pt1,
											'author' => $user_id,
											'posts_per_page' => 10,
											'paged' => $paged,
											'order'	=> 'DESC',
											'orderby' => 'ID'
										);

									if($selected_lfs != ''){$output_args['post_status'] = $selected_lfs;}
									if($selected_lfo != ''){$output_args['orderby'] = $selected_lfo;}
									if($selected_lfo2 != ''){$output_args['order'] = $selected_lfo2;}
									if($selected_lfl != ''){
										$output_args['tax_query']=
											array(
												'relation' => 'AND',
												array(
													'taxonomy' => 'pointfinderltypes',
													'field' => 'id',
													'terms' => $selected_lfl,
													'operator' => 'IN'
												)
											);
									}

									

									if($params['post_id'] != ''){
										$output_args['p'] = $params['post_id'];
									}

									$output_loop = new WP_Query( $output_args );

									/**
									*Header for search
									**/
										
										if($params['sheader'] != 'hide'){
											
											$this->FieldOutput .= '<section><div class="row"><div class="col1-5 first">';
												
												$this->FieldOutput .= '<label for="listing-filter-status" class="lbl-ui select">
					                              <select id="listing-filter-status" name="listing-filter-status">';

					                                $this->FieldOutput .= '<option value="">'.esc_html__('Status','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfs == 'publish') ? '<option value="publish" selected>'.esc_html__('Published','pointfindert2d').'</option>' : '<option value="publish">'.esc_html__('Published','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfs == 'pendingapproval') ? '<option value="pendingapproval" selected>'.esc_html__('Pending Approval','pointfindert2d').'</option>' : '<option value="pendingapproval">'.esc_html__('Pending Approval','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfs == 'pendingpayment') ? '<option value="pendingpayment" selected>'.esc_html__('Pending Payment','pointfindert2d').'</option>' : '<option value="pendingpayment">'.esc_html__('Pending Payment','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfs == 'rejected') ? '<option value="rejected" selected>'.esc_html__('Rejected','pointfindert2d').'</option>' : '<option value="rejected">'.esc_html__('Rejected','pointfindert2d').'</option>';
					                               
					                              $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';

					                        $this->FieldOutput .= '<div class="col1-5 first">';
												$this->FieldOutput .= '<label for="listing-filter-ltype" class="lbl-ui select">
					                              <select id="listing-filter-ltype" name="listing-filter-ltype">
					                                <option value="">'.$setup3_pointposttype_pt7.'</option>
					                                ';
					                                 
					                                $fieldvalues = get_terms('pointfinderltypes',array('hide_empty'=>false)); 
													foreach( $fieldvalues as $fieldvalue){
														
														$this->FieldOutput  .= ($selected_lfl == $fieldvalue->term_id) ? '<option value="'.$fieldvalue->term_id.'" selected>'.$fieldvalue->name.'</option>' : '<option value="'.$fieldvalue->term_id.'">'.$fieldvalue->name.'</option>';	
														
													}

					                                $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';


					                        $this->FieldOutput .= '<div class="col1-5">';
												$this->FieldOutput .= '<label for="listing-filter-orderby" class="lbl-ui select">
					                              <select id="listing-filter-orderby" name="listing-filter-orderby">';

					                                $this->FieldOutput .= '<option value="">'.esc_html__('Order By','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo == 'title') ? '<option value="title" selected>'.esc_html__('Title','pointfindert2d').'</option>' : '<option value="title">'.esc_html__('Title','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo == 'date') ? '<option value="date" selected>'.esc_html__('Date','pointfindert2d').'</option>' : '<option value="date">'.esc_html__('Date','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo == 'ID') ? '<option value="ID" selected>'.esc_html__('ID','pointfindert2d').'</option>' : '<option value="ID">'.esc_html__('ID','pointfindert2d').'</option>';


					                              $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';

					                        $this->FieldOutput .= '<div class="col1-5">';
												$this->FieldOutput .= '<label for="listing-filter-order" class="lbl-ui select">
					                              <select id="listing-filter-order" name="listing-filter-order">';

					                                $this->FieldOutput .= '<option value="">'.esc_html__('Order','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo2 == 'ASC') ? '<option value="ASC" selected>'.esc_html__('ASC','pointfindert2d').'</option>' : '<option value="ASC">'.esc_html__('ASC','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo2 == 'DESC') ? '<option value="DESC" selected>'.esc_html__('DESC','pointfindert2d').'</option>' : '<option value="DESC">'.esc_html__('DESC','pointfindert2d').'</option>';

					                              $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';

					                        

					                        $this->FieldOutput .= '<div class="col1-5 last">';
												$this->FieldOutput .= '<button type="submit" value="" id="'.$buttonid.'" class="button blue pfmyitempagebuttons" title="'.esc_html__('SEARCH','pointfindert2d').'"  ><i class="pfadmicon-glyph-627"></i></button>';
												$this->FieldOutput .= '<a class="button pfmyitempagebuttons" style="margin-left:4px;" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems" title="'.esc_html__('RESET','pointfindert2d').'"><i class="pfadmicon-glyph-825"></i></a>';
												$this->FieldOutput .= '<a class="button pfmyitempagebuttons" style="margin-left:4px;" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=newitem" title="'.esc_html__('ADD NEW','pointfindert2d').'"><i class="pfadmicon-glyph-722"></i></a>';
											$this->FieldOutput .= '</div></div></section>';
										}


									if ( $output_loop->have_posts() ) {
										/**
										*Start: Column Headers
										**/
										$setup3_pointposttype_pt7s = PFSAIssetControl('setup3_pointposttype_pt7s','','Listing Type');
										$this->FieldOutput .= '<section>';

										$this->FieldOutput .= '<div class="pfhtitle pf-row clearfix hidden-xs">';
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfmu-itemlisting-htitlenc col-lg-1 col-md-1 col-sm-2 hidden-xs">';
											
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-4 col-md-4 col-sm-4 hidden-xs">';
											$this->FieldOutput .= esc_html__('Information','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= $setup3_pointposttype_pt7s;
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= esc_html__('Posted on','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle col-lg-3 col-md-3 col-sm-2">';
											$this->FieldOutput .= '</div>';
										/**
										*End: Column Headers
										**/
										$this->FieldOutput .= '</div>';

										while ( $output_loop->have_posts() ) {
											$output_loop->the_post(); 

											$author_post_id = get_the_ID();
												
												
												
													/*Post Meta Info*/
													global $wpdb;
													if ($setup4_membersettings_paymentsystem == 2) {
														$current_user = wp_get_current_user();
														$user_id = $current_user->ID;
														$result_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
													}else{
														$result_id = $wpdb->get_var( $wpdb->prepare( 
															"
																SELECT post_id
																FROM $wpdb->postmeta 
																WHERE meta_key = %s and meta_value = %s
															", 
															'pointfinder_order_itemid',
															$author_post_id
														) );
													}
													
													if ($setup4_membersettings_paymentsystem == 2) {
														$pointfinder_order_datetime = PFU_GetPostOrderDate($author_post_id);
													} else {
														$pointfinder_order_datetime = PFU_GetPostOrderDate($result_id);
													}
													
													
													$pointfinder_order_datetime = PFU_Dateformat($pointfinder_order_datetime);
													
													$pointfinder_order_datetime_approval = esc_attr(get_post_meta( $result_id, 'pointfinder_order_datetime_approval', true ));
													$pointfinder_order_pricesign = esc_attr(get_post_meta( $result_id, 'pointfinder_order_pricesign', true ));
													$pointfinder_order_listingtime = esc_attr(get_post_meta( $result_id, 'pointfinder_order_listingtime', true ));
													$pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
													$pointfinder_order_recurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurring', true ));
													$pointfinder_order_frecurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_frecurring', true ));
													$pointfinder_order_expiredate = esc_attr(get_post_meta( $result_id, 'pointfinder_order_expiredate', true ));
													$pointfinder_order_bankcheck = esc_attr(get_post_meta( $result_id, 'pointfinder_order_bankcheck', true ));

													$featured_enabled = esc_attr(get_post_meta( $author_post_id, 'webbupointfinder_item_featuredmarker', true ));

													$pointfinder_order_listingtime = ($pointfinder_order_listingtime == '') ? 0 : $pointfinder_order_listingtime ;
													

													if($pointfinder_order_expiredate != ''){
														$item_listing_expiry = PFU_Dateformat($pointfinder_order_expiredate);
													}else{
														$item_listing_expiry = '';
													}
												
													$item_recurring_text = ($pointfinder_order_recurring == 1)? '('.esc_html__('Recurring','pointfindert2d').')' : '';


													$status_of_post = get_post_status($author_post_id);

													$status_of_order = get_post_status($result_id);

													switch ($status_of_post) {
														case 'pendingpayment':
															if ($status_of_order == 'pfsuspended') {
																$status_text = sprintf(esc_html__('Suspended (Required Paypal Activation)','pointfindert2d'));
																$status_payment = 1;
																$status_icon = 'pfadmicon-glyph-411';
																$status_lbl = 'lblpending';
															}else{
/*jschen: remark, it will cause system crush 
																if ($setup4_membersettings_paymentsystem == 2) {
																	$status_text = esc_html__('Suspended','pointfindert2d');
																} else {
												
																	$pf_price_output = pointfinder_reformat_pricevalue_for_frontend($pointfinder_order_price);
																	
																	if ($pointfinder_order_price == 0) {
																		$status_text = sprintf(esc_html__('Pending Payment %s Please edit this item and change plan.','pointfindert2d'),'<br/>');
																	}else{
																		$status_text = sprintf(esc_html__('Pending Payment (%s)','pointfindert2d'),$pf_price_output);
																	}
																}
																$status_payment = 0;
																$status_icon = 'pfadmicon-glyph-411';
																$status_lbl = 'lblpending';
*/
															}
															break;
														
														case 'rejected':
															$status_text = esc_html__('Rejected','pointfindert2d');
															$status_payment = 1;
															$status_icon = 'pfadmicon-glyph-411';
															$status_lbl = 'lblcancel';
															break;

														case 'pendingapproval':
															$status_text = esc_html__('Pending Approval','pointfindert2d');
															$status_payment = 1;
															$status_icon = 'pfadmicon-glyph-411';
															$status_lbl = 'lblpending';
															break;

														case 'publish':
															if ($setup4_membersettings_paymentsystem == 2) {
																$status_text = esc_html__('Active','pointfindert2d');
															} else {
																$status_text = sprintf(esc_html__('Active until: %s','pointfindert2d'),$item_listing_expiry);
															}
															$status_payment = 1;
															$status_icon = 'pfadmicon-glyph-411';
															$status_lbl = 'lblcompleted';
															break;

														case 'pfonoff':
															/*$status_text = esc_html__('Deactivated by user','pointfindert2d');
															$status_lbl = 'lblpending';
															$status_icon = 'pfadmicon-glyph-411';
															$status_payment = 1;*/
															if ($setup4_membersettings_paymentsystem == 2) {
																$status_text = sprintf(esc_html__('Active until: %s','pointfindert2d'),$item_listing_expiry);
															}
															$status_payment = 1;
															$status_icon = 'pfadmicon-glyph-411';
															$status_lbl = 'lblcompleted';
															break;
													}

													/*
														Reviews Store in $review_output:
													*/
														$setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');
														if ($setup11_reviewsystem_check == 1) {
															global $pfitemreviewsystem_options;
															$setup11_reviewsystem_criterias = $pfitemreviewsystem_options['setup11_reviewsystem_criterias'];
															$review_status = PFControlEmptyArr($setup11_reviewsystem_criterias);

															if($review_status != false){
																$review_output = '';
																$setup11_reviewsystem_singlerev = PFREVSIssetControl('setup11_reviewsystem_singlerev','','0');
																$criteria_number = pf_number_of_rev_criteria();
																$return_results = pfcalculate_total_review($author_post_id);
																if ($return_results['totalresult'] > 0) {
																	
																	$review_output .= '<span class="pfiteminfolist-infotext pfreviews" title="'.esc_html__('Reviews','pointfindert2d').'"><i class="pfadmicon-glyph-631"></i>';
																		$review_output .=  $return_results['totalresult'].' (<a title="'.esc_html__('Review Total','pointfindert2d').'" style="cursor:pointer">'.pfcalculate_total_rusers($author_post_id).'</a>)';
																	$review_output .= '</span>';
																}else{
																	
																	$review_output .= '<span class="pfiteminfolist-infotext pfreviews" title="'.esc_html__('Reviews','pointfindert2d').'"><i class="pfadmicon-glyph-631"></i>';
																		$review_output .=  '0 (<a title="'.esc_html__('Review Total','pointfindert2d').'" style="cursor:pointer">0</a>)';
																	$review_output .= '</span>';
																}
															}
														}else{
															$review_output = '';
														}

													/*
														Favorites Store in $fav_output:
													*/
														$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');
														if($setup4_membersettings_favorites == 1){
															$fav_number = esc_attr(get_post_meta( $author_post_id, 'webbupointfinder_items_favorites', true ));
															$fav_number = ($fav_number == false) ? '0' : $fav_number ;
															$fav_output = '';
															if ($fav_number > 0) {
																$fav_output .= '<span class="pfiteminfolist-title pfstatus-title pfreviews" title="'.esc_html__('Favorites','pointfindert2d').'"><i class="pfadmicon-glyph-376"></i> </span>';
																$fav_output .= '<span class="pfiteminfolist-infotext pfreviews">';
																	$fav_output .=  $fav_number;
																$fav_output .= '</span>';
															}else{
																$fav_output .= '<span class="pfiteminfolist-title pfstatus-title pfreviews" title="'.esc_html__('Favorites','pointfindert2d').'"><i class="pfadmicon-glyph-376"></i></span>';
																$fav_output .= '<span class="pfiteminfolist-infotext pfreviews">0</span>';
															}
														}else{
															$fav_output = '';
														}

													/*
														View Count for item.
													*/
														$viewcount_hideshow_f = PFSAIssetControl('viewcount_hideshow_f','',1);

														if($viewcount_hideshow_f == 1){
															$view_count_num = esc_attr(get_post_meta($author_post_id,"webbupointfinder_page_itemvisitcount",true));
															if (!empty($view_count_num)) {
																$view_outputx = $view_count_num;
															}else{
																$view_outputx = 0;
															}
															$view_output = '<span class="pfiteminfolist-title pfstatus-title pfreviews" title="'.esc_html__('Views','pointfindert2d').'"><i class="pfadmicon-glyph-729"></i></span>';
															$view_output .= '<span class="pfiteminfolist-infotext pfreviews">'.$view_outputx.'</span>';
														}
					
													$setup4_membersettings_loginregister = PFSAIssetControl('setup4_membersettings_loginregister','','1');


												$this->FieldOutput .= '<div class="pfmu-itemlisting-inner pfmu-itemlisting-inner'.$author_post_id.' pf-row clearfix">';
														if ($status_of_post == 'pfonoff') {
															$addthistextstyle = ' style="display:block"';
														}else{$addthistextstyle = '';}
														$this->FieldOutput .= '<div class="pfmu-itemlisting-inner-overlay pfmu-itemlisting-inner-overlay'.$author_post_id.'"'.$addthistextstyle.'></div>';
														if (get_post_status($author_post_id) == 'publish') {
															$permalink_item = get_permalink($author_post_id);
														}else{
															$permalink_item = '#';
														}

														/*Item Photo Area*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-photo col-lg-1 col-md-1 col-sm-2 hidden-xs">';
															if ( has_post_thumbnail()) {
															   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(),'full');
															   $this->FieldOutput .= '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" rel="prettyPhoto">';
															   $this->FieldOutput .= '<img src="'.aq_resize($large_image_url[0],60,60,true).'" alt="" />';
															   $this->FieldOutput .= '</a>';
															}else{
															   $this->FieldOutput .= '<a href="#" style="border:1px solid #efefef">';
															   $this->FieldOutput .= '<img src="'.get_template_directory_uri().'/images/noimg.png'.'" alt="" />';
															   $this->FieldOutput .= '</a>';
															}
														$this->FieldOutput .= '</div>';



														/* Item Title */
														$this->FieldOutput .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pfmu-itemlisting-title-wd">';
														$this->FieldOutput .= '<div class="pfmu-itemlisting-title">';
														$this->FieldOutput .= '<a href="'.$permalink_item.'">'.get_the_title().'</a>';
														$this->FieldOutput .= '</div>';

														/*Status*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfmu-itemlisting-info-'.$author_post_id.' pffirst" data-deactivatedt="'.esc_html__('Deactivated by user','pointfindert2d').'">';
															$this->FieldOutput .= '<ul class="pfiteminfolist">';



																/** Basic & Featured Listing Setting **/																
																$this->FieldOutput .= '<li>';
																/*$this->FieldOutput .= '<span class="pfiteminfolist-title pfstatus-title">'.esc_html__('Listing Status','pointfindert2d').' '.$item_recurring_text.'  : </span>';*/
															
																
																if($status_payment == 1 && $status_of_post == 'pendingapproval'){
																	$this->FieldOutput .= '<span class="pfiteminfolist-infotext '.$status_lbl.'"><a href="javascript:;" class="info-tip info-tipex" aria-describedby="helptooltip"> <i class="'.$status_icon.'"></i> <span role="tooltip">'.esc_html__('This item is waiting for approval. Please be patient while this process goes on.','pointfindert2d').'</span></a>';
																}else{
																	if (empty($item_listing_expiry) && $status_of_post == 'publish') {
																		$this->FieldOutput .= '<span class="pfiteminfolist-infotext '.$status_lbl.'">';
																	}else{
																		$this->FieldOutput .= '<span class="pfiteminfolist-infotext '.$status_lbl.'"><i class="'.$status_icon.'"></i>';
																	}
																}
																if (empty($item_listing_expiry) && $status_of_post == 'publish') {
																	$this->FieldOutput .= '</span>';
																}else{
																	$this->FieldOutput .= ' '.$status_text.'</span>';
																}
																
																$this->FieldOutput .= '</li>';

																/** Basic & Featured Listing Setting **/


																
																
																
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';
														$this->FieldOutput .= '</div>';

														
														
														/*Type of item*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-2 col-md-2 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';														
																$this->FieldOutput .= '<li><strong>'.get_the_term_list( $author_post_id, 'pointfinderltypes', '<ul class="pointfinderpflistterms"><li>', ',</li><li>', '</li></ul>' ).'</strong></li>';

																
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';

														/*Date Creation*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-2 col-md-2 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';
																$this->FieldOutput .= '<li>'.$pointfinder_order_datetime.'</li>';
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';



														


														/*Item Footer*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-footer col-lg-3 col-md-3 col-sm-2 col-xs-12">';
													    $this->FieldOutput .= '<ul class="pfmu-userbuttonlist">';

													    if ($this->PF_UserLimit_Check('delete',$status_of_post) == 1 || $status_of_post == 'pfonoff') {
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-delete-item-button wpf-transition-all pf-itemdelete-link" data-pid="'.$author_post_id.'" id="pf-delete-item-'.$author_post_id.'" title="'.esc_html__('Delete','pointfindert2d').'"><i class="pfadmicon-glyph-644"></i></a></li>';
														}
														
														if($status_of_post == 'publish' || $status_of_post == 'pfonoff'){
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-view-item-button wpf-transition-all" href="'.$permalink_item.'" title="'.esc_html__('View','pointfindert2d').'"><i class="pfadmicon-glyph-410"></i></a></li>';
														}

														if (($this->PF_UserLimit_Check('edit',$status_of_post) == 1 && $status_of_order != 'pfsuspended') || ($this->PF_UserLimit_Check('edit',$status_of_post) == 1 && $status_of_post == 'pfonoff')) {
															
															$show_edit_button = 1;

															if (($setup4_membersettings_paymentsystem == 2 && $status_of_post == 'pendingpayment') || ($setup4_membersettings_paymentsystem == 2 && $status_of_post == 'pfonoff')) {
																$show_edit_button = 0;
															}
															if ($show_edit_button == 1) {
																$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-edit-item-button wpf-transition-all" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=edititem&i='.$author_post_id.'" title="'.esc_html__('Edit','pointfindert2d').'"><i class="pfadmicon-glyph-685"></i></a></li>';
															} 
															
														}


														$this->FieldOutput .= '</ul>';

														if ($setup4_membersettings_paymentsystem != 2) {
															$stp31_userfree = PFSAIssetControl("stp31_userfree","","0");


															$pointfinder_order_listingpid = get_post_meta($result_id, "pointfinder_order_listingpid",true);
															$package_price_check = pointfinder_get_package_price_ppp($pointfinder_order_listingpid);
															
															$ip_process = true;

															if (empty($package_price_check) && !empty($pointfinder_order_expiredate) && $status_of_post == 'pendingpayment' && $stp31_userfree == 0) {
																$ip_process = false;
															}


															if ($ip_process) {
																if ($status_payment == 0 && $pointfinder_order_price != 0) {

													            	$this->FieldOutput .= '<div class="pfmu-payment-area golden-forms pf-row clearfix">';

													            	if($pointfinder_order_bankcheck == 0){

														            	$this->FieldOutput .= '<label for="paymenttype" class="lbl-text">'.esc_html__('PAY WITH:','pointfindert2d');
														            		if($pointfinder_order_recurring == 1){
														            			$this->FieldOutput .= '<a href="javascript:;" class="info-tip info-tipex" aria-describedby="helptooltip" style="background-color:#b00000"> ? <span role="tooltip">'.esc_html__('Recurring payments do not support BANK TRANSFER & CREDIT CARD PAYMENTS.','pointfindert2d').'</span></a>';
														            		}
														            		$this->FieldOutput .= '</label>';

														            
														            	$this->FieldOutput .= '<div class="col-lg-7 col-md-7 col-sm-12 col-xs-8">';
															            	
															                $this->FieldOutput .= '<label class="lbl-ui select">';
															            
																	        	$this->FieldOutput .= '<select name="paymenttype">';
																	        		if (PFSAIssetControl('setup20_paypalsettings_paypal_status','','1') == 1) {	
																	        			if ($pointfinder_order_recurring == 1 || $pointfinder_order_frecurring == 1) {
					        																$this->FieldOutput .= '<option value="paypal">'.esc_html__('PAYPAL REC.','pointfindert2d').'</option>';
					        															}else{
					        																$this->FieldOutput .= '<option value="paypal">'.esc_html__('PAYPAL','pointfindert2d').'</option>';
					        															}
																		       			
																		       		}
																		       		
																		       		if (($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFSAIssetControl('setup20_stripesettings_status','','0') == 1) {
																		       			$this->FieldOutput .= '<option value="creditcard">'.esc_html__('CREDIT CARD','pointfindert2d').'</option>';
																		       		}
																		       		
																		       		if (($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFPGIssetControl('pags_status','',0) == 1) {
																		       			$this->FieldOutput .= '<option value="pags">'.esc_html__('PAGSEGURO','pointfindert2d').'</option>';
																		       		}

																		       		if (($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFPGIssetControl('payu_status','',0) == 1) {
																		       			$this->FieldOutput .= '<option value="payu">'.esc_html__('PAYUMONEY','pointfindert2d').'</option>';
																		       		}

																		       		if (($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFPGIssetControl('ideal_status','',0) == 1) {
																		       			$this->FieldOutput .= '<option value="ideal">'.esc_html__('iDeal','pointfindert2d').'</option>';
																		       		}

																		       		if (($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFPGIssetControl('robo_status','',0) == 1) {
																		       			$this->FieldOutput .= '<option value="robo">'.esc_html__('Robokassa','pointfindert2d').'</option>';
																		       		}

																		       		if (($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFPGIssetControl('iyzico_status','',0) == 1) {
																		       			$this->FieldOutput .= '<option value="iyzico">'.esc_html__('Iyzico','pointfindert2d').'</option>';
																		       		}

																		       		if(($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1) && PFSAIssetControl('setup20_paypalsettings_bankdeposit_status','',0) == 1){
																		       			$this->FieldOutput .= '<option value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2&i='.$author_post_id.'">'.esc_html__('BANK TRANS.','pointfindert2d').'</option>';
																		       		}

																		        $this->FieldOutput .= '</select>';
																		       
																	        $this->FieldOutput .= '</label>';

																        $this->FieldOutput .= '</div>';

																        $this->FieldOutput .= '<div class="col-lg-5 col-md-5 col-sm-12 col-xs-4">';
														            		$this->FieldOutput .= '<a class="button buttonpaymentb pfbuttonpaymentb" data-pfitemnum="'.$author_post_id.'" title="'.esc_html__('Click for Payment','pointfindert2d').'">'.esc_html__('PAY','pointfindert2d').'</a>';
														            	$this->FieldOutput .= '</div>';
														            }else{
														            	$this->FieldOutput .= '<div class="col-lg-12">';
														            		$this->FieldOutput .= '<div class="pfcanceltext">';
														            		$this->FieldOutput .= '<label class="lbl-text"><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2c&i='.$author_post_id.'">'.esc_html__('CANCEL TRANSFER','pointfindert2d').'</a> ';
														            		$this->FieldOutput .= '<a href="javascript:;" class="info-tip info-tipex" aria-describedby="helptooltip" style="background-color:#b00000"> ? <span role="tooltip">'.esc_html__('Waiting Bank Transfer, but you can cancel this transfer and make payment with another payment method.','pointfindert2d').'</span></a>';
														            		$this->FieldOutput .= '</label>';
														            		$this->FieldOutput .= '</div>';
														            	$this->FieldOutput .= '</div>';
														            }

														            $this->FieldOutput .= '</div>';
													           
													        	}elseif ($status_payment == 0 && $pointfinder_order_price == 0 && $stp31_userfree == 1) {
													        		/*If user is free user then extend it free.*/
/*jschen remark, user cannot change the status of a listing

													        		$this->FieldOutput .= '<div class="col-lg-12">';
														            		$this->FieldOutput .= '<div class="pfcanceltext">';
														            		$this->FieldOutput .= '<label class="lbl-text">
														            		<a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_extend&i='.$author_post_id.'" class="button buttonrenewpf" title="'.esc_html__('Click for renew (Extend)','pointfindert2d').'"><i class="pfadmicon-glyph-486"></i> '.esc_html__('RENEW','pointfindert2d').'</a>';
														            		$this->FieldOutput .= '</label>';
														            		$this->FieldOutput .= '</div>';
														            	$this->FieldOutput .= '</div>';
*/
													        	}
															}else{
																$this->FieldOutput .= '<div class="pfmu-payment-area golden-forms pf-row clearfix">';
																$this->FieldOutput .= '<label for="paymenttype" class="lbl-text">'.esc_html__('Payment Notification ','pointfindert2d');
																$this->FieldOutput .= '<a href="javascript:;" class="info-tip info-tipex" aria-describedby="helptooltip" style="background-color:#b00000"> ? <span role="tooltip">
																'.esc_html__('If you want to extend this listing, please edit and change package.','pointfindert2d').'</span></a></label>';
																$this->FieldOutput .= '</div>';
															}

															
												        }

														$this->FieldOutput .= '</div>';

													

													$this->FieldOutput .= '</div>';
													$this->FieldOutput .= '<div class="pf-listing-item-inner-addinfo">
													<ul>';
														/** Reviews: show **/
														$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');
														if($setup4_membersettings_favorites == 1 && !empty($review_output)){
															$this->FieldOutput .= '<li>';
															$this->FieldOutput .= $review_output;
															$this->FieldOutput .= '</li>';
														}

														/** Favorites: show **/
														$setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');
														if ($setup11_reviewsystem_check == 1 && !empty($fav_output)) {
															$this->FieldOutput .= '<li>';
															$this->FieldOutput .= $fav_output;
															$this->FieldOutput .= '</li>';
														}

														/** View: show **/
														if ($viewcount_hideshow_f == 1) {
															$this->FieldOutput .= '<li>';
															$this->FieldOutput .= $view_output;
															$this->FieldOutput .= '</li>';
														}
														

														if ($featured_enabled == 1) {
															$pf_featured_exptime = get_post_meta( $result_id, 'pointfinder_order_expiredate_featured', true );
															if ($pf_featured_exptime != false) {
																$pf_featured_exptime = sprintf(esc_html__('Featured until %s','pointfindert2d'),PFU_Dateformat($pf_featured_exptime));
															}else{
																$pf_featured_exptime = esc_html__('Featured','pointfindert2d');
															}
															/** Featured: show **/
															$this->FieldOutput .= '<li>';
															$this->FieldOutput .= '<span class="pfiteminfolist-title pfstatus-title pffeaturedbuttondash" title="'.$pf_featured_exptime.'"><i class="pfadmicon-glyph-379"></i></span>';
															$this->FieldOutput .= '</li>';
														}

														$is_listing_recurring = get_post_meta($result_id, 'pointfinder_order_recurring', true );
														if ($is_listing_recurring == false) {
															$is_listing_recurring = get_post_meta($result_id, 'pointfinder_order_frecurring', true );
														}
														if ($is_listing_recurring != false) {
															/** Recurring: show **/
															$this->FieldOutput .= '<li>';
															$this->FieldOutput .= '<span class="pfiteminfolist-title pfstatus-title pfrecurringbuttonactive" title="'.esc_html__('Recurring Payment','pointfindert2d').'"><i class="pfadmicon-glyph-655"></i></span>';
															$this->FieldOutput .= '</li>';
														}

														/** on/off: show **/
														$old_post_status = get_post_status($author_post_id);
														if ($old_post_status != 'pfonoff') {
															$onoff_text = 'pfstatusbuttonactive';
															$onoff_word = esc_html__("Your listing is active","pointfindert2d" );
														}else{
															$onoff_text = 'pfstatusbuttondeactive';
															$onoff_word = esc_html__("Your listing is deactive","pointfindert2d" );
														}
														if (!in_array($status_of_post, array('pendingapproval','pendingpayment','rejected'))) {
															$this->FieldOutput .= '<li>';
														
															$this->FieldOutput .= '<span data-pfid="'.$author_post_id.'" class="pfiteminfolist-title pfstatus-title '.$onoff_text.' pfstatusbuttonaction" title="'.$onoff_word.'" data-pf-deactive="'.esc_html__("Your listing is deactive","pointfindert2d" ).'" data-pf-active="'.esc_html__("Your listing is active","pointfindert2d" ).'"><i class="pfadmicon-glyph-348"></i></span>';
															$this->FieldOutput .= '</li>';
														}

													$this->FieldOutput .= '
													</ul>
													</div>';
												
										}

										$this->FieldOutput .= '</section>';
									}else{
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>';
										if (PFControlEmptyArr($fieldvars)) {
											$this->FieldOutput .= '<strong>'.esc_html__('No record found!','pointfindert2d').'</strong><br>'.esc_html__('Please refine your search criteria and try to check again. Or you can press <strong>Reset</strong> button to see all items.','pointfindert2d').'</p></div>';
										}else{
											$this->FieldOutput .= '<strong>'.esc_html__('No record!','pointfindert2d').'</strong><br>'.esc_html__('If you see this error first time please upload new items for list on this page.','pointfindert2d').'</p></div>';
										}
										$this->FieldOutput .= '</section>';
									}
									$this->FieldOutput .= '<div class="pfstatic_paginate" >';
									$big = 999999999;
									$this->FieldOutput .= paginate_links(array(
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max(1, $paged),
										'total' => $output_loop->max_num_pages,
										'type' => 'list',
									));
									$this->FieldOutput .= '</div>';
									wp_reset_postdata();

								$this->FieldOutput .= '</div>';

							/**
							*End: Content Area
							**/
						/**
						*End: My Items Page Content
						**/
						break;

					case 'errorview':
						/**
						*Start: Error Page Content
						**/
							
							
						/**
						*End: Error Page Content
						**/
						break;

					case 'banktransfer':
						/**
						*Start: Bank Transfer Page Content
						**/
							$this->FieldOutput .= '<div class="pf-banktransfer-window">';

								$this->FieldOutput .= '<span class="pf-orderid-text">';
								$this->FieldOutput .= esc_html__('Your Order ID:','pointfindert2d').' '.$params['post_id'];
								$this->FieldOutput .= '</span>';

								$this->FieldOutput .= '<span class="pf-order-text">';
								global $pointfindertheme_option;
								$setup20_bankdepositsettings_text = ($pointfindertheme_option['setup20_bankdepositsettings_text'])? wp_kses_post($pointfindertheme_option['setup20_bankdepositsettings_text']):'';
								$this->FieldOutput .= $setup20_bankdepositsettings_text;
								$this->FieldOutput .= '</span>';

							$this->FieldOutput .= '</div>';
							
						/**
						*End: Bank Transfer Page Content
						**/
						break;

					case 'favorites':
						$formaction = 'pf_refinefavlist';
						$noncefield = wp_create_nonce($formaction);
						$buttonid = 'pf-ajax-itemrefine-button';

						/**
						*Start: Favorites Page Content
						**/
							
							$user_favorites_arr = get_user_meta( $params['current_user'], 'user_favorites', true );

							if (!empty($user_favorites_arr)) {
								$user_favorites_arr = json_decode($user_favorites_arr,true);
							}else{
								$user_favorites_arr = array();
							}


							$output_arr = '';
							$countarr = count($user_favorites_arr);
							
							if($countarr>0){
								
								$this->FieldOutput .= '<div class="pfmu-itemlisting-container">';
									
									if ($params['fields']!= '') {
										$fieldvars = $params['fields'];
									}else{
										$fieldvars = '';
									}

									$selected_lfs = $selected_lfl = $selected_lfo2 = $selected_lfo = '';

									$paged = ( esc_sql(get_query_var('paged')) ) ? esc_sql(get_query_var('paged')) : '';
									if (empty($paged)) {
										$paged = ( esc_sql(get_query_var('page')) ) ? esc_sql(get_query_var('page')) : 1;
									}

									$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
									$setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');

									if (PFControlEmptyArr($fieldvars)) {

				                        if(isset($fieldvars['listing-filter-ltype'])){
				                       		if ($fieldvars['listing-filter-ltype'] != '') {
				                       			$selected_lfl = $fieldvars['listing-filter-ltype'];
				                       		}
				                        }

			                            if(isset($fieldvars['listing-filter-orderby'])){
			                           		if ($fieldvars['listing-filter-orderby'] != '') {
			                           			$selected_lfo = $fieldvars['listing-filter-orderby'];
			                           		}
			                            }

			                            if(isset($fieldvars['listing-filter-order'])){
			                           		if ($fieldvars['listing-filter-order'] != '') {
			                           			$selected_lfo2 = $fieldvars['listing-filter-order'];
			                           		}
			                            }

									}

									$user_id = $params['current_user'];


									$output_args = array(
											'post_type'	=> $setup3_pointposttype_pt1,
											'posts_per_page' => 10,
											'paged' => $paged,
											'order'	=> 'ASC',
											'orderby' => 'Title',
											'post__in' => $user_favorites_arr
									);

									if($selected_lfs != ''){$output_args['post_status'] = $selected_lfs;}
									if($selected_lfo != ''){$output_args['orderby'] = $selected_lfo;}
									if($selected_lfo2 != ''){$output_args['order'] = $selected_lfo2;}
									if($selected_lfl != ''){
										$output_args['tax_query']=
											array(
												'relation' => 'AND',
												array(
													'taxonomy' => 'pointfinderltypes',
													'field' => 'id',
													'terms' => $selected_lfl,
													'operator' => 'IN'
												)
											);
									}

									

									if($params['post_id'] != ''){
										$output_args['p'] = $params['post_id'];
									}

									$output_loop = new WP_Query( $output_args );
									
									/**
									*START: Header for search
									**/
										
										if($params['sheader'] != 'hide'){
											
											$this->FieldOutput .= '<section><div class="row">';
												

					                        $this->FieldOutput .= '<div class="col3 first">';
												$this->FieldOutput .= '<label for="listing-filter-ltype" class="lbl-ui select">
					                              <select id="listing-filter-ltype" name="listing-filter-ltype">
					                                <option value="">'.$setup3_pointposttype_pt7.'</option>
					                                ';
					                                 
					                                $fieldvalues = get_terms('pointfinderltypes',array('hide_empty'=>false)); 
													foreach( $fieldvalues as $fieldvalue){
														
														$this->FieldOutput  .= ($selected_lfl == $fieldvalue->term_id) ? '<option value="'.$fieldvalue->term_id.'" selected>'.$fieldvalue->name.'</option>' : '<option value="'.$fieldvalue->term_id.'">'.$fieldvalue->name.'</option>';	
														
													}

					                                $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';


					                        $this->FieldOutput .= '<div class="col3">';
												$this->FieldOutput .= '<label for="listing-filter-orderby" class="lbl-ui select">
					                              <select id="listing-filter-orderby" name="listing-filter-orderby">';

					                                $this->FieldOutput .= '<option value="">'.esc_html__('Order By','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo == 'title') ? '<option value="title" selected>'.esc_html__('Title','pointfindert2d').'</option>' : '<option value="title">'.esc_html__('Title','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo == 'date') ? '<option value="date" selected>'.esc_html__('Date','pointfindert2d').'</option>' : '<option value="date">'.esc_html__('Date','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo == 'ID') ? '<option value="ID" selected>'.esc_html__('ID','pointfindert2d').'</option>' : '<option value="ID">'.esc_html__('ID','pointfindert2d').'</option>';


					                              $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';

					                        $this->FieldOutput .= '<div class="col3">';
												$this->FieldOutput .= '<label for="listing-filter-order" class="lbl-ui select">
					                              <select id="listing-filter-order" name="listing-filter-order">';

					                                $this->FieldOutput .= '<option value="">'.esc_html__('Order','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo2 == 'ASC') ? '<option value="ASC" selected>'.esc_html__('ASC','pointfindert2d').'</option>' : '<option value="ASC">'.esc_html__('ASC','pointfindert2d').'</option>';
					                                $this->FieldOutput  .= ($selected_lfo2 == 'DESC') ? '<option value="DESC" selected>'.esc_html__('DESC','pointfindert2d').'</option>' : '<option value="DESC">'.esc_html__('DESC','pointfindert2d').'</option>';

					                              $this->FieldOutput .= '
					                              </select>
					                            </label>';
					                        $this->FieldOutput .= '</div>';

					                        

					                        $this->FieldOutput .= '<div class="col3 last">';
												$this->FieldOutput .= '<button type="submit" value="" id="'.$buttonid.'" class="button blue pfmyitempagebuttons" title="'.esc_html__('SEARCH','pointfindert2d').'"  ><i class="pfadmicon-glyph-627"></i></button>';
												$this->FieldOutput .= '<a class="button pfmyitempagebuttons" style="margin-left:4px;" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=favorites" title="'.esc_html__('RESET','pointfindert2d').'"><i class="pfadmicon-glyph-825"></i></a>';
											$this->FieldOutput .= '</div></div></section>';
										}

									/**
									*END: Header for search
									**/

									if ( $output_loop->have_posts() ) {
										
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="pfhtitle pf-row clearfix hidden-xs">';

										$setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4s','','Item Type');
										$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
										$setup3_pointposttype_pt5 = PFSAIssetControl('setup3_pointposttype_pt5s','','Location');
										$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
										$setup3_pointposttype_pt7s = PFSAIssetControl('setup3_pointposttype_pt7s','','Listing Type');
										/**
										*Start: Column Headers
										**/
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfmu-itemlisting-htitlenc col-lg-1 col-md-1 col-sm-2 hidden-xs">';
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-4 col-md-4 col-sm-4 hidden-xs">';
											$this->FieldOutput .= esc_html__('Information','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= $setup3_pointposttype_pt7s;
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
												
												if($setup3_pointposttype_pt5_check == 1){
													$this->FieldOutput .= $setup3_pointposttype_pt5;
												}else{
													if($setup3_pointposttype_pt4_check == 1){
														$this->FieldOutput .= $setup3_pointposttype_pt4;
													}
												}
											
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfmu-itemlisting-htitlenc col-lg-3 col-md-3 col-sm-2">';
											$this->FieldOutput .= '</div>';
										/**
										*End: Column Headers
										**/

										$this->FieldOutput .= '</div>';

										while ( $output_loop->have_posts() ) {
											$output_loop->the_post(); 

											$author_post_id = get_the_ID();
												
												$this->FieldOutput .= '<div class="pfmu-itemlisting-inner pf-row clearfix">';
														
														$permalink_item = get_permalink($author_post_id);
														

														/*Item Photo Area*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-photo col-lg-1 col-md-1 col-sm-2 hidden-xs">';
															if ( has_post_thumbnail()) {
															   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(),'full');
															   $this->FieldOutput .= '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" rel="prettyPhoto">';
															   $this->FieldOutput .= '<img src="'.aq_resize($large_image_url[0],60,60,true).'" alt="" />';
															   $this->FieldOutput .= '</a>';
															}else{
															   $this->FieldOutput .= '<a href="#" style="border:1px solid #efefef">';
															   $this->FieldOutput .= '<img src="'.get_template_directory_uri().'/images/noimg.png'.'" alt="" />';
															   $this->FieldOutput .= '</a>';
															}
														$this->FieldOutput .= '</div>';



														/* Item Title */
														$this->FieldOutput .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pfmu-itemlisting-title-wd">';
														$this->FieldOutput .= '<div class="pfmu-itemlisting-title">';
														$this->FieldOutput .= '<a href="'.$permalink_item.'">'.get_the_title().'</a>';
														$this->FieldOutput .= '</div>';


														/*Other Infos*/
														$output_data = PFIF_DetailText_ld($author_post_id);
														$rl_pfind = '/pflistingitem-subelement pf-price/';
														$rl_pfind2 = '/pflistingitem-subelement pf-onlyitem/';
					                                    $rl_preplace = 'pf-fav-listing-price';
					                                    $rl_preplace2 = 'pf-fav-listing-item';
					                                    $mcontent = preg_replace( $rl_pfind, $rl_preplace, $output_data);
					                                    $mcontent = preg_replace( $rl_pfind2, $rl_preplace2, $mcontent );

					                                    if (isset($mcontent['content'])) {
					                                    	$this->FieldOutput .= '<div class="pfmu-itemlisting-info pffirst">';
						                                    $this->FieldOutput .= $mcontent['content'];
															$this->FieldOutput .= '</div>';
					                                    }

					                                    if (isset($mcontent['priceval'])) {
					                                    	$this->FieldOutput .= '<div class="pfmu-itemlisting-info pffirst">';
						                                    $this->FieldOutput .= $mcontent['priceval'];
															$this->FieldOutput .= '</div>';
					                                    }

					                                    $this->FieldOutput .= '</div>';
														

														
														
														/*Type of item*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-2 col-md-2 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';														
																$this->FieldOutput .= '<li>'.GetPFTermName($author_post_id, 'pointfinderltypes').'</li>';
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';

														/*Location*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-3 col-md-3 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';
																if($setup3_pointposttype_pt5_check == 1){
																	$this->FieldOutput .= '<li>'.GetPFTermName($author_post_id, 'pointfinderlocations').'</li>';
																}else{
																	if($setup3_pointposttype_pt4_check == 1){
																		$this->FieldOutput .= '<li>'.GetPFTermName($author_post_id, 'pointfinderitypes').'</li>';
																	}
																}
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';



														


														/*Item Footer*/
															
														
														$fav_check = 'true';
														$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
														
														
														
														$this->FieldOutput .= '<div class="pfmu-itemlisting-footer col-lg-2 col-md-2 col-sm-2 col-xs-12">';
													    $this->FieldOutput .= '<ul class="pfmu-userbuttonlist">';
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-delete-item-button wpf-transition-all pf-favorites-link" data-pf-num="'.$author_post_id.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'"><i class="pfadmicon-glyph-644"></i></a></li>';
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-view-item-button wpf-transition-all" href="'.$permalink_item.'" title="'.esc_html__('View','pointfindert2d').'"><i class="pfadmicon-glyph-410"></i></a></li>';
														$this->FieldOutput .= '</ul>';
														
														$this->FieldOutput .= '</div>';


													$this->FieldOutput .= '</div>';

												
										}

										$this->FieldOutput .= '</section>';
									}else{
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>';
										if (PFControlEmptyArr($fieldvars)) {
											$this->FieldOutput .= '<strong>'.esc_html__('No record found!','pointfindert2d').'</strong><br>'.esc_html__('Please refine your search criteria and try to check again. Or you can press <strong>Reset</strong> button to see all.','pointfindert2d').'</p></div>';
										}else{
											$this->FieldOutput .= '<strong>'.esc_html__('No record found!','pointfindert2d').'</strong></p></div>';
										}
										$this->FieldOutput .= '</section>';
									}
									$this->FieldOutput .= '<div class="pfstatic_paginate" >';
									$big = 999999999;
									$this->FieldOutput .= paginate_links(array(
										//'base' => @add_query_arg('page','%#%'),
										//'format' => '?page=%#%',
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max(1, $paged),
										'total' => $output_loop->max_num_pages,
										'type' => 'list',
									));
									$this->FieldOutput .= '</div>';
									

								$this->FieldOutput .= '</div>';
							}else{
								$this->FieldOutput .= '<section>';
								$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>'.esc_html__('No record found!','pointfindert2d').'</p></div>';
								$this->FieldOutput .= '</section>';
							}
						/**
						*End: Favorites Page Content
						**/
						break;

					case 'reviews':
						$formaction = 'pf_refinerevlist';
						$noncefield = wp_create_nonce($formaction);
						$buttonid = 'pf-ajax-revrefine-button';

						/**
						*Start: Reviews Page Content
						**/
							/*Post Meta Info*/
							global $wpdb;
							$results = $wpdb->get_results( $wpdb->prepare( 
								"
									SELECT ID
									FROM $wpdb->posts
									WHERE post_type = '%s' and post_author = %d
								", 
								'pointfinderreviews',
								$params['current_user']
							),'ARRAY_A' );

							function pf_arraya_2_array($aval = array()){
								$aval_output = array();
								foreach ($aval as $aval_single) {

									$aval_output[] = (isset($aval_single['ID']))? $aval_single['ID'] : '';
								}
								return $aval_output;
							}
							$results = pf_arraya_2_array($results);

							$output_arr = '';
							$countarr = count($results);

							
							if($countarr>0){
								
								$this->FieldOutput .= '<div class="pfmu-itemlisting-container">';

									$paged = ( esc_sql(get_query_var('paged')) ) ? esc_sql(get_query_var('paged')) : '';
									if (empty($paged)) {
										$paged = ( esc_sql(get_query_var('page')) ) ? esc_sql(get_query_var('page')) : 1;
									}

									
									$user_id = $params['current_user'];


									$output_args = array(
											'post_type'	=> 'pointfinderreviews',
											'posts_per_page' => 10,
											'paged' => $paged,
											'order'	=> 'DESC',
											'orderby' => 'Date',
											'post__in' => $results
									);


									$output_loop = new WP_Query( $output_args );
									/*
									print_r($output_loop->query).PHP_EOL;
									echo $output_loop->request.PHP_EOL;
									*/
									

									if ( $output_loop->have_posts() ) {
										
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="pfhtitle pf-row clearfix hidden-xs">';

										$setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4s','','Item Type');
										$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
										$setup3_pointposttype_pt5 = PFSAIssetControl('setup3_pointposttype_pt5s','','Location');
										$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
										$setup3_pointposttype_pt7s = PFSAIssetControl('setup3_pointposttype_pt7s','','Listing Type');
										/**
										*Start: Column Headers
										**/
											
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-4 col-md-4 col-sm-4 hidden-xs">';
											$this->FieldOutput .= esc_html__('Title','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= esc_html__('Review','pointfindert2d');
											$this->FieldOutput .= '</div>';

											
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-4 col-md-4 col-sm-4 hidden-xs">';
											$this->FieldOutput .= esc_html__('Date','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfmu-itemlisting-htitlenc col-lg-2 col-md-2 col-sm-2">';
											$this->FieldOutput .= '</div>';
										/**
										*End: Column Headers
										**/

										$this->FieldOutput .= '</div>';

										while ( $output_loop->have_posts() ) {
											$output_loop->the_post(); 

											$author_post_id = get_the_ID();
											$item_post_id = esc_attr(get_post_meta( $author_post_id, 'webbupointfinder_review_itemid', true ));

												$this->FieldOutput .= '<div class="pfmu-itemlisting-inner pf-row clearfix">';
														

														/* Item Title */
														$this->FieldOutput .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pfmu-itemlisting-title-wd">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list" style="padding-left:10px">';
																$this->FieldOutput .= '<a href="'.get_permalink($item_post_id).'">'.get_the_title($item_post_id).'</a>';
															$this->FieldOutput .= '</div>';
					                                    $this->FieldOutput .= '</div>';


					                                    /* Review Title */
														$this->FieldOutput .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pfmu-itemlisting-title-wd">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list">';

																	
																		$review_output = '';
																		$return_results = pfcalculate_single_review($author_post_id);
																		
																		if (!empty($return_results)) {
																			$review_output .= '<span class="pfiteminfolist-infotext pfreviews" style="padding-left:10px">';
																				$review_output .=  $return_results;
																			$review_output .= '</span>';
																		}else{
																			$review_output .= ''.esc_html__('Reviews','pointfindert2d').' : ';
																			$review_output .= '<span class="pfiteminfolist-infotext pfreviews" style="padding-left:10px">';
																				$review_output .=  '0 (<a title="'.esc_html__('Review Total','pointfindert2d').'" style="cursor:pointer">0</a>)';
																			$review_output .= '</span>';
																		}
																	
																$this->FieldOutput .= $review_output;

															$this->FieldOutput .= '</div>';
					                                    $this->FieldOutput .= '</div>';

														
														
														/*Type of item*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-4 col-md-4 col-sm-4 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';														
																$this->FieldOutput .= '<li>'.sprintf( esc_html__('%1$s at %2$s', 'pointfindert2d'), get_the_date(),  get_the_time()).'</li>';
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';


														/*Item Footer*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-footer col-lg-2 col-md-2 col-sm-2 col-xs-12">';
													    $this->FieldOutput .= '<ul class="pfmu-userbuttonlist" style="padding-left:10px">';
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-view-item-button wpf-transition-all" href="'.get_permalink($item_post_id).'" title="'.esc_html__('View','pointfindert2d').'"><i class="pfadmicon-glyph-410"></i></a></li>';
														$this->FieldOutput .= '</ul>';
														
														$this->FieldOutput .= '</div>';


													$this->FieldOutput .= '</div>';

												
										}

										$this->FieldOutput .= '</section>';
									}else{
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>';
										
										$this->FieldOutput .= esc_html__('No record found!','pointfindert2d').'</p></div>';
										
										$this->FieldOutput .= '</section>';
									}
									$this->FieldOutput .= '<div class="pfstatic_paginate" >';
									$big = 999999999;
									$this->FieldOutput .= paginate_links(array(
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max(1, $paged),
										'total' => $output_loop->max_num_pages,
										'type' => 'list',
									));
									$this->FieldOutput .= '</div>';
									wp_reset_postdata();

								$this->FieldOutput .= '</div>';
							}else{
								$this->FieldOutput .= '<section>';
								$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>'.esc_html__('No record found!','pointfindert2d').'</p></div>';
								$this->FieldOutput .= '</section>';
							}
						/**
						*End: Reviews Page Content
						**/
						break;

					case 'invoices':
						$formaction = 'pf_refineinvlist';
						$noncefield = wp_create_nonce($formaction);
						$buttonid = 'pf-ajax-invrefine-button';

						/**
						*Start: Invoices Page Content
						**/
							/*Post Meta Info*/
							global $wpdb;
							$results = $wpdb->get_results( $wpdb->prepare( 
								"
									SELECT ID
									FROM $wpdb->posts
									WHERE post_type = '%s' and post_author = %d
								", 
								'pointfinderinvoices',
								$params['current_user']
							),'ARRAY_A' );

							function pf_arraya_2_array($aval = array()){
								$aval_output = array();
								foreach ($aval as $aval_single) {

									$aval_output[] = (isset($aval_single['ID']))? $aval_single['ID'] : '';
								}
								return $aval_output;
							}
							$results = pf_arraya_2_array($results);

							$output_arr = '';
							$countarr = count($results);

							
							if($countarr>0){
								
								$this->FieldOutput .= '<div class="pfmu-itemlisting-container">';

									$paged = ( esc_sql(get_query_var('paged')) ) ? esc_sql(get_query_var('paged')) : '';
									if (empty($paged)) {
										$paged = ( esc_sql(get_query_var('page')) ) ? esc_sql(get_query_var('page')) : 1;
									}

									
									$user_id = $params['current_user'];


									$output_args = array(
											'post_type'	=> 'pointfinderinvoices',
											'posts_per_page' => 10,
											'paged' => $paged,
											'order'	=> 'DESC',
											'orderby' => 'Date',
											'post__in' => $results
									);


									$output_loop = new WP_Query( $output_args );
									/*
									print_r($output_loop->query).PHP_EOL;
									echo $output_loop->request.PHP_EOL;
									*/
									

									if ( $output_loop->have_posts() ) {

										$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
										$paypal_price_unit = PFSAIssetControl('setup20_paypalsettings_paypal_price_unit','','USD');
										
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="pfhtitle pf-row clearfix hidden-xs">';

										/**
										*Start: Column Headers
										**/
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= esc_html__('Print/ID','pointfindert2d');
											$this->FieldOutput .= '</div>';
											
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-3 col-md-3 col-sm-3 hidden-xs">';
											$this->FieldOutput .= esc_html__('Desc','pointfindert2d');
											$this->FieldOutput .= '</div>';


											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= esc_html__('Status','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= esc_html__('Type','pointfindert2d');
											$this->FieldOutput .= '</div>';
											
											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle pfexhtitle col-lg-2 col-md-2 col-sm-2 hidden-xs">';
											$this->FieldOutput .= esc_html__('Date','pointfindert2d');
											$this->FieldOutput .= '</div>';

											$this->FieldOutput .= '<div class="pfmu-itemlisting-htitle col-lg-1 col-md-1 col-sm-1">';
											$this->FieldOutput .= $paypal_price_unit;
											$this->FieldOutput .= '</div>';
										/**
										*End: Column Headers
										**/

										$this->FieldOutput .= '</div>';

										
										$inv_prefix = PFASSIssetControl('setup_invoices_prefix','','PFI');
										$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');

										while ( $output_loop->have_posts() ) {
											$output_loop->the_post(); 

											$author_post_id = get_the_ID();
											$pf_inv_type = get_post_meta( $author_post_id,'pointfinder_invoice_invoicetype', true );
											$price_val_inv = get_post_meta( $author_post_id, 'pointfinder_invoice_amount', true );
											
											if (strpos($price_val_inv, $setup20_paypalsettings_paypal_price_short) === false) {
												$price_val_inv =  ($price_val_inv != 0)?pointfinder_reformat_pricevalue_for_frontend((int)$price_val_inv):0;
											}

												switch (get_post_status()) {
													case 'publish':
														$item_post_status_out = esc_html__('Completed','pointfindert2d');
														break;
													case 'pendingpayment':
														$item_post_status_out = esc_html__('Pending Payment','pointfindert2d');
														break;
													case 'pendingapproval':
														$item_post_status_out = esc_html__('Pending Approval','pointfindert2d');
														break;
													case 'rejected':
														$item_post_status_out = esc_html__('Rejected','pointfindert2d');
														break;
												}
											

												$this->FieldOutput .= '<div class="pfmu-itemlisting-inner pf-row clearfix">';
														
														/* Item ID */
														$this->FieldOutput .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pfmu-itemlisting-title-wd">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list">';
																$this->FieldOutput .= '<a href="'.get_permalink().'" style="font-weight:bold" title="'.esc_html__('View/Print','pointfindert2d').'" target="_blank" ><i class="pfadmicon-glyph-388"></i> '.$inv_prefix.$author_post_id.'</a>';
															$this->FieldOutput .= '</div>';
					                                    $this->FieldOutput .= '</div>';


														/* Item Title */
														$this->FieldOutput .= '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pfmu-itemlisting-title-wd">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list">';
																$this->FieldOutput .= get_the_title();
															$this->FieldOutput .= '</div>';
					                                    $this->FieldOutput .= '</div>';

					                                    /* Status */
														$this->FieldOutput .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pfmu-itemlisting-title-wd">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list">';
																		$this->FieldOutput .= $item_post_status_out;
															$this->FieldOutput .= '</div>';
					                                    $this->FieldOutput .= '</div>';


					                                    /* Type */
														$this->FieldOutput .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 pfmu-itemlisting-title-wd">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list">';
																		$this->FieldOutput .= $pf_inv_type;
															$this->FieldOutput .= '</div>';
					                                    $this->FieldOutput .= '</div>';

							
														/*Date*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-2 col-md-2 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list">';													
																$this->FieldOutput .= '<li>'.sprintf( esc_html__('%1$s', 'pointfindert2d'), get_the_date()).'</li>';
															$this->FieldOutput .= '</div>';
														$this->FieldOutput .= '</div>';


														/*Item Footer*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-footer col-lg-1 col-md-1 col-sm-1 col-xs-12">';
														    $this->FieldOutput .= '<div class="pfmu-itemlisting-title pf-review-list" style="text-align:right">';
														    	
														    	$this->FieldOutput .= $price_val_inv;
																
															$this->FieldOutput .= '</div>';
														$this->FieldOutput .= '</div>';

													$this->FieldOutput .= '</div>';

												
										}

										$this->FieldOutput .= '</section>';
									}else{
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>';
										
										$this->FieldOutput .= esc_html__('No record found!','pointfindert2d').'</p></div>';
										
										$this->FieldOutput .= '</section>';
									}
									$this->FieldOutput .= '<div class="pfstatic_paginate" >';
									$big = 999999999;
									$this->FieldOutput .= paginate_links(array(
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max(1, $paged),
										'total' => $output_loop->max_num_pages,
										'type' => 'list',
									));
									$this->FieldOutput .= '</div>';
									wp_reset_postdata();

								$this->FieldOutput .= '</div>';
							}else{
								$this->FieldOutput .= '<section>';
								$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>'.esc_html__('No record found!','pointfindert2d').'</p></div>';
								$this->FieldOutput .= '</section>';
							}
						/**
						*End: Invoices Page Content
						**/
						break;

				}

			/**
			*Start: Page Footer Actions / Divs / Etc...
			**/
				$this->FieldOutput .= '</div>';/*row*/
				$this->FieldOutput .= '</div>';/*form-section*/
				$this->FieldOutput .= '</div>';/*form-enclose*/

				
				if($params['formtype'] != 'myitems' && $params['formtype'] != 'favorites' && $params['formtype'] != 'reviews'){$xtext = '';}else{$xtext = 'style="background:transparent;background-color:transparent;display:none!important"';}
				


				$this->FieldOutput .= '
				<div class="pfalign-right" '.$xtext.'>';
				if($params['formtype'] != 'errorview' && $params['formtype'] != 'banktransfer'){
					if($params['formtype'] != 'myitems' && $params['formtype'] != 'favorites' && $params['formtype'] != 'reviews' && $params['formtype'] != 'invoices' && $params['dontshowpage'] != 1 && $main_package_expire_problem != true){
			            $this->FieldOutput .='    
			                <section '.$xtext.'> ';
			                if($params['formtype'] == 'upload'){
				                $setup31_userpayments_recurringoption = PFSAIssetControl('setup31_userpayments_recurringoption','','1');
				         
			                }elseif ($params['formtype'] == 'edititem') {
			                	
			                	$this->FieldOutput .='
				                   <input type="hidden" name="edit_pid" value="'.$params['post_id'].'">';
			                }
			                if ($main_package_purchase_permission == true || $main_package_upgrade_permission == true) {
			                	$this->FieldOutput .='<input type="hidden" name="selectedpackageid" value="">';
			                }elseif ($main_package_renew_permission == true && !empty($membership_user_package_id)) {
			                	if ($free_membership == false) {
			                		$this->FieldOutput .='<input type="hidden" name="selectedpackageid" value="'.$membership_user_package_id.'">';
			                	}else{
			                		$this->FieldOutput .='<input type="hidden" name="selectedpackageid">';
			                	}
			                }
			                if ($main_package_renew_permission == true) {
			                	$this->FieldOutput .='<input type="hidden" name="subaction" value="r">';
			                }elseif ($main_package_purchase_permission == true) {
			                	$this->FieldOutput .='<input type="hidden" name="subaction" value="n">';
			                }elseif ($main_package_upgrade_permission == true) {
			                	$this->FieldOutput .='<input type="hidden" name="subaction" value="u">';
			                }
			                $this->FieldOutput .= '
			                   <input type="hidden" value="'.$formaction.'" name="action" />
			                   <input type="hidden" value="'.$noncefield.'" name="security" />
			                   ';
			                if (!$hide_button) {
			                	$this->FieldOutput .= '
				                   <input type="submit" value="'.$buttontext.'" id="'.$buttonid.'" class="button blue pfmyitempagebuttonsex" data-edit="'.$params['post_id'].'"  />
			                   ';
			                }
			                
			                $this->FieldOutput .= '
			                </section>  
			            ';
		         	}else{
		       			$this->FieldOutput .='    
			                <section  '.$xtext.'> 
			                   <input type="hidden" value="'.$formaction.'" name="action" />
			                   <input type="hidden" value="'.$noncefield.'" name="security" />
			                </section>  
			            ';
		       		}
		       	}
	        
	            $this->FieldOutput.='              
	            </div>
				';
				
				$this->FieldOutput .= '</form>';
				$this->FieldOutput .= '</div>';/*golden-forms*/
			/**
			*End: Page Footer Actions / Divs / Etc...
			**/


		}

		/**
		*Start: Class Functions
		**/
			public function PFGetList($params = array())
			{
			    $defaults = array( 
			        'listname' => '',
			        'listtype' => '',
			        'listtitle' => '',
			        'listsubtype' => '',
			        'listdefault' => '',
			        'listmultiple' => 0,
			        'parentonly' => 0
			    );
				
			    $params = array_merge($defaults, $params);
			    	
			    	$output_options = '';
			    	if($params['listmultiple'] == 1){ $multiplevar = ' multiple';$multipletag = '[]';}else{$multiplevar = '';$multipletag = '';};

			    	if ($params['parentonly'] == 1) {
			    		$fieldvalues = get_terms($params['listsubtype'],array('hide_empty'=>false,'parent'=>0));
			    	}else{
			    		$fieldvalues = get_terms($params['listsubtype'],array('hide_empty'=>false));
			    	}

					foreach( $fieldvalues as $parentfieldvalue){
						if($parentfieldvalue->parent == 0){

							$fieldParenttaxSelectedValuex = 0;
						
							if(is_array($params['listdefault'])){
								if(in_array($parentfieldvalue->term_id, $params['listdefault'])){ $fieldParenttaxSelectedValuex = 1;}
							}else{
								if(strcmp($params['listdefault'],$parentfieldvalue->term_id) == 0){ $fieldParenttaxSelectedValuex = 1;}
							}

							if($fieldParenttaxSelectedValuex == 1){
								$output_options .= '<option class="pointfinder-parent-field" value="'.$parentfieldvalue->term_id.'" selected>'.$parentfieldvalue->name.'</option>';
							}else{
								$output_options .= '<option class="pointfinder-parent-field" value="'.$parentfieldvalue->term_id.'">'.$parentfieldvalue->name.'</option>';
							}
							
							foreach( $fieldvalues as $fieldvalue){
								if($fieldvalue->parent == $parentfieldvalue->term_id){
									$fieldtaxSelectedValue = 0;

									if($params['listdefault'] != ''){
										if(is_array($params['listdefault'])){
											if(in_array($fieldvalue->term_id, $params['listdefault'])){ $fieldtaxSelectedValue = 1;}
										}else{
											if(strcmp($params['listdefault'],$fieldvalue->term_id) == 0){ $fieldtaxSelectedValue = 1;}
										}
									}
									
									if($fieldtaxSelectedValue == 1){
										$output_options .= '<option value="'.$fieldvalue->term_id.'" selected>&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalue->name.'</option>';
									}else{
										$output_options .= '<option value="'.$fieldvalue->term_id.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalue->name.'</option>';
									}
								}
							}
						}
					}
					


			    	$output = '';
					$output .= '<div class="pf_fr_inner" data-pf-parent="">';
		   			
			   		
	   				if (!empty($params['listtitle'])) {
		   				$output .= '<label for="'.$params['listname'].'" class="lbl-text">'.$params['listtitle'].':</label>';
	   				}

	   				$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

					if ($as_mobile_dropdowns == 1) {
						$as_mobile_dropdowns_text = 'class="pf-special-selectbox"';
					} else {
						$as_mobile_dropdowns_text = '';
					}
					
	   				$output .= '
	                <label class="lbl-ui select">
	                <select'.$multiplevar.' name="'.$params['listname'].$multipletag.'" id="'.$params['listname'].'" '.$as_mobile_dropdowns_text.'>';
	                $output .= '<option></option>';
	                $output .= $output_options.'
	                </select>
	                </label>';
			   		

			   		$output .= '</div>';

	            return $output;
			}

			private function PFValidationCheckWrite($field_validation_check,$field_validation_text,$itemid){
				
				$itemname = (string)trim($itemid);
				$itemname = (strpos($itemname, '[]') == false) ? $itemname : "'".$itemname."'" ;

				if($field_validation_check == 1){
					if($this->VSOMessages != ''){
						$this->VSOMessages .= ','.$itemname.':"'.$field_validation_text.'"';
					}else{
						$this->VSOMessages = $itemname.':"'.$field_validation_text.'"';
					}

					if($this->VSORules != ''){
						$this->VSORules .= ','.$itemname.':"required"';
					}else{
						$this->VSORules = $itemname.':"required"';
					}
				}
			}

			private function PF_UserLimit_Check($action,$post_status){
	
				switch ($post_status) {
					case 'publish':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;
					
					case 'pendingpayment':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit_pendingpayment','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete_pendingpayment','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;

					case 'rejected':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit_rejected','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete_rejected','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;

					case 'pendingapproval':
							switch ($action) {
								case 'edit':
									$output = 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete_pendingapproval','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;

					case 'pfonoff':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;
				}

				return $output;
			}
	    /**
		*End: Class Functions
		**/


	   function __destruct() {
		  $this->FieldOutput = '';
		  $this->ScriptOutput = '';
	    }
	}
}

?>
