<?php

/**********************************************************************************************************************************
*
* User Dashboard Actions
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if(isset($_GET['ua']) && $_GET['ua']!=''){
$ua_action = esc_attr($_GET['ua']);
}
$setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');

if(isset($ua_action)){
	$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
	$pfmenu_perout = PFPermalinkCheck();

	if(is_user_logged_in() || $ua_action='newitem' ){

		if($setup4_membersettings_dashboard != 0){

				if ($ua_action == 'profile') {
					/**
					*Start: Profile Form Request
					**/
						get_template_part('admin/estatemanagement/includes/pages/dashboard/form','profilereq');
					/**
						*End: Profile Form Request
					**/
				}
				$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
				$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
				$setup4_submitpage_status_old = PFSAIssetControl('setup4_submitpage_status_old','','0');

				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;
				/**
				*Start: Member Page Actions
				**/
				if (is_page($setup4_membersettings_dashboard)) {

								/**
					*Start: Page Start Actions / Divs etc...
					**/
						switch ($ua_action) {
							case 'purchaseplan':
								$case_text = 'purchaseplan';
							break;
							case 'renewplan':
								$case_text = 'renewplan';
							break;
							case 'upgradeplan':
								$case_text = 'upgradeplan';
							break;
							case 'profile':
								$case_text = 'profile';
							break;
							case 'favorites':
								$case_text = 'favs';
							break;
							case 'newitem':
							case 'edititem':
								$case_text = 'submit';
							break;
							case 'reviews':
								$case_text = 'rev';
							break;
							case 'myitems':
								$case_text = 'my';
							break;
							case 'invoices':
								$case_text = 'inv';
							break;
							default:
								$case_text = 'my';
							break;

						}

						if (!in_array($case_text, array('purchaseplan','renewplan','upgradeplan'))) {
						
							$setup29_dashboard_contents_my_page = PFSAIssetControl('setup29_dashboard_contents_'.$case_text.'_page','','');
							$setup29_dashboard_contents_my_page_pos = PFSAIssetControl('setup29_dashboard_contents_'.$case_text.'_page_pos','','1');
							$setup29_dashboard_contents_my_page_layout = PFSAIssetControl('setup29_dashboard_contents_profile_page_layout','','3');
							if ($ua_action == 'edititem') {
								$setup29_dashboard_contents_my_page_title = PFSAIssetControl('setup29_dashboard_contents_'.$case_text.'_page_titlee','','');
							}else{
								$setup29_dashboard_contents_my_page_title = PFSAIssetControl('setup29_dashboard_contents_'.$case_text.'_page_menuname','','');
							}
						}else{
							$setup29_dashboard_contents_my_page = PFSAIssetControl('setup29_dashboard_contents_submit_page','','');
							$setup29_dashboard_contents_my_page_layout = PFSAIssetControl('setup29_dashboard_contents_profile_page_layout','','3');
							$setup29_dashboard_contents_my_page_pos = PFSAIssetControl('setup29_dashboard_contents_submit_page_pos','','1');
							$membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );

							switch ($case_text) {
								case 'purchaseplan':
									$setup29_dashboard_contents_my_page_title = esc_html__("Purchase New Plan","pointfindert2d" );
									break;
								
								case 'renewplan':
									if (!empty($membership_user_package_id)) {
										$setup29_dashboard_contents_my_page_title = esc_html__("Renew Current Plan","pointfindert2d" );
									}else{
										$setup29_dashboard_contents_my_page_title = esc_html__("Purchase New Plan","pointfindert2d" );
									}
									
									break;

								case 'upgradeplan':
									if (!empty($membership_user_package_id)) {
										$setup29_dashboard_contents_my_page_title = esc_html__("Upgrade Plan","pointfindert2d" );
									}else{
										$setup29_dashboard_contents_my_page_title = esc_html__("Purchase New Plan","pointfindert2d" );
									}
									
									break;
							}
						}
					
						$pf_ua_col_codes = '<div class="col-lg-9 col-md-9">';
						$pf_ua_col_close = '</div>';
						$pf_ua_prefix_codes = '<section role="main"><div class="pf-container clearfix"><div class="pf-row clearfix"><div class="pf-uadashboard-container clearfix">';
						$pf_ua_suffix_codes = '</div></div></div></section>';
						

						PFGetHeaderBar('',$setup29_dashboard_contents_my_page_title);

						$content_of_section = '';
						if ($setup29_dashboard_contents_my_page != '') {	
							$content_of_section = do_shortcode(get_post_field( 'post_content', $setup29_dashboard_contents_my_page, 'raw' ));
						}
						if ($setup29_dashboard_contents_my_page_pos == 1 && $setup29_dashboard_contents_my_page != '') {
							echo $content_of_section;
						}


						switch($setup29_dashboard_contents_my_page_layout) {
							case '3':
							echo $pf_ua_prefix_codes.$pf_ua_col_codes;	
							break;
							case '2':
							echo $pf_ua_prefix_codes.$pf_ua_sidebar_codes.$sidebar_output;
							echo $pf_ua_sidebar_close.$pf_ua_col_codes;	
							break;
						}
					/**
					*End: Page Start Actions / Divs etc...
					**/

					
					get_template_part('admin/estatemanagement/includes/pages/dashboard/dashboard','frontend');
				
					$errorval = '';
					$sccval = '';

					

					

					switch ($ua_action) {

						case 'purchaseplan':
						case 'renewplan':
						case 'upgradeplan':
							/**
							*Start: My Items Page Content
							**/
	              				$membership_user_activeorder_ex = get_user_meta( $user_id, 'membership_user_activeorder_ex', true );
	              				if (!empty($membership_user_activeorder_ex)) {
	              					$pointfinder_order_pagscheck = get_post_meta( $membership_user_activeorder_ex, 'pointfinder_order_pagscheck', true );
	              				}else{
	              					$pointfinder_order_pagscheck = '';
	              				}
	              				if (!empty($pointfinder_order_pagscheck)) {
	              					if (!empty($sccval)) {
	              						$sccval .= '</br>';
	              					}
	              					switch ($ua_action) {
	              						case 'renewplan':
	              							$sccval .= esc_html__('Your previous order is waiting for approval. Please wait until we receive notification from PagSeguro. If you renew this plan, this may create duplicate payment. ','pointfindert2d');
	              							break;
	              						
	              						case 'upgradeplan':
	              							$sccval .= esc_html__('Your previous order is waiting for approval. Please wait until we receive notification from PagSeguro. If you upgrade to new plan, this may create duplicate payment.','pointfindert2d');
	              							break;

	              						case 'purchaseplan':
	              							$sccval .= esc_html__('Your previous order is waiting for approval. Please wait until we receive notification from PagSeguro. If you purchase new plan, this may create duplicate payment.','pointfindert2d');
	              							break;
	              					}
									
								}
							/**
							*End: My Items Form Request
							**/


							/**
							*Start: Purchase/Renew/Upgrade Plan Page Content
							**/
								$output = new PF_Frontend_Fields(
										array(
											'formtype' => $ua_action,
											'current_user' => $user_id,
											'sccval' => $sccval
										)
									);
								echo $output->FieldOutput;
								
								echo '<script type="text/javascript">
								(function($) {
									"use strict";
									$(function(){
									'.$output->ScriptOutput;
									echo '
									var pfsearchformerrors = $(".pfsearchformerrors");
										$("#pfuaprofileform").validate({
											  debug:false,
											  onfocus: false,
											  onfocusout: false,
											  onkeyup: false,
											  rules:{'.$output->VSORules.'},messages:{'.$output->VSOMessages.'},
											  ignore: ".select2-input, .select2-focusser, .pfignorevalidation",
											  validClass: "pfvalid",
											  errorClass: "pfnotvalid pfadmicon-glyph-858",
											  errorElement: "li",
											  errorContainer: pfsearchformerrors,
											  errorLabelContainer: $("ul", pfsearchformerrors),
											  invalidHandler: function(event, validator) {
												var errors = validator.numberOfInvalids();
												if (errors) {
													pfsearchformerrors.show("slide",{direction : "up"},100)
													$(".pfsearch-err-button").click(function(){
														pfsearchformerrors.hide("slide",{direction : "up"},100)
														return false;
													});
												}else{
													pfsearchformerrors.hide("fade",300)
												}
											  }
										});
									});'.$output->ScriptOutputDocReady;
								
								echo '	
								})(jQuery);
								</script>';
								unset($output);
							/**
							*End: Purchase/Renew/Upgrade Plan Page Content
							**/
							break;
							
						case 'newitem':
						case 'edititem':

							/**
							*Start: New/Edit Item Page Content
							**/
								$confirmed_postid = '';
								$formtype = 'upload';
								$dontshowpage = 0;
								if ($ua_action == 'edititem') {
									if (!empty($_GET['i'])) {
										$edit_postid = (is_numeric($_GET['i']))? esc_attr($_GET['i']):'';
										if(!empty($edit_postid)){
											$result = $wpdb->get_results( $wpdb->prepare( 
												"
													SELECT ID, post_author
													FROM $wpdb->posts 
													WHERE ID = %s and post_author = %s and post_type = %s
												", 
												$edit_postid,
												$user_id,
												$setup3_pointposttype_pt1
											) );


											if (is_array($result) && count($result)>0) {

												if ($result[0]->ID == $edit_postid) {
													$confirmed_postid = $edit_postid;
													$formtype = 'edititem';
												}else{
													$dontshowpage = 1;
													$errorval .= esc_html__('This is not your item.','pointfindert2d');
												}
											}else{
												$dontshowpage = 1;
												$errorval .= esc_html__('This is not your item.','pointfindert2d');
											}
										}else{
											$dontshowpage = 1;
											$errorval .= esc_html__('Please select an item for edit.','pointfindert2d');
										}
									} else{
										$dontshowpage = 1;
										$errorval .= esc_html__('Please select an item for edit.','pointfindert2d');
									}
									
									
								}

								/**
								*Start : Item Image & Featured Image Delete (OLD Image Upload)
								**/
									if($formtype == 'edititem'){
										if(isset($_GET) && isset($_GET['action'])){
											if (esc_attr($_GET['action']) == 'delfimg' && $setup4_submitpage_status_old == 1) {
												wp_delete_attachment(get_post_thumbnail_id( $confirmed_postid ),true);
												delete_post_thumbnail( $confirmed_postid );
												$sccval .= esc_html__('Featured image removed. Redirecting to item details...','pointfindert2d');

										  		$output = new PF_Frontend_Fields(
													array(
														'formtype' => 'errorview',
														'sccval' => $sccval
														)
													);

												echo $output->FieldOutput;											
											  	
												echo '<script type="text/javascript">
													<!--
													window.location = "'.$setup4_membersettings_dashboard_link.'/?ua=edititem&i='.$confirmed_postid.'"
													//-->
													</script>';
												break;
											}elseif (esc_attr($_GET['action']) == 'delimg' && $setup4_submitpage_status_old == 1) {
												$delimg_id = '';
												$delimg_id = esc_attr($_GET['ii']);

												if($delimg_id != ''){
													delete_post_meta( $confirmed_postid, 'webbupointfinder_item_images', $delimg_id );
													if(isset($confirmed_postid)){
														wp_delete_attachment( $delimg_id, true );
													}

													$sccval .= esc_html__('Image removed. Redirecting item details...','pointfindert2d');

											  		$output = new PF_Frontend_Fields(
														array(
															'formtype' => 'errorview',
															'sccval' => $sccval
															)
														);

													echo $output->FieldOutput;											
												  	
													echo '<script type="text/javascript">
														<!--
														window.location = "'.$setup4_membersettings_dashboard_link.'/?ua=edititem&i='.$confirmed_postid.'"
														//-->
														</script>';
													break;
												}
											}
										}
									}
								/**
								*End : Item Image & Featured Image Delete (OLD Image Upload)
								**/								
							
								$output = new PF_Frontend_Fields(
									array(
										'fields'=>'', 
										'formtype' => $formtype,
										'sccval' => $sccval,
										'post_id' => $confirmed_postid,
										'errorval' => $errorval,
										'current_user' => $user_id,
										'dontshowpage' => $dontshowpage
										)
									);

								echo $output->FieldOutput;
								echo '<script type="text/javascript">
								(function($) {
									"use strict";
									$(function(){
									'.$output->ScriptOutput;
									echo '
									
									var pfsearchformerrors = $(".pfsearchformerrors");
										$("#pfuaprofileform").validate({
											  debug:false,
											  onfocus: false,
											  onfocusout: false,
											  onkeyup: false,
											  rules:{'.$output->VSORules.'},messages:{'.$output->VSOMessages.'},
											  ignore: ".select2-input, .select2-focusser, .pfignorevalidation",
											  validClass: "pfvalid",
											  errorClass: "pfnotvalid pfadmicon-glyph-858",
											  errorElement: "li",
											  errorContainer: pfsearchformerrors,
											  errorLabelContainer: $("ul", pfsearchformerrors),
											  invalidHandler: function(event, validator) {
												var errors = validator.numberOfInvalids();
												if (errors) {
													pfsearchformerrors.show("slide",{direction : "up"},100)
													$(".pfsearch-err-button").click(function(){
														pfsearchformerrors.hide("slide",{direction : "up"},100)
														return false;
													});
												}else{
													pfsearchformerrors.hide("fade",300)
												}
											  }
										});
									});'.$output->ScriptOutputDocReady;
								
								echo '	
								})(jQuery);
								</script>';
								unset($output);
							/**
							*End: New/Edit Item Page Content
							**/
							break;

						case 'myitems':
							/**
							*Start: Pagseguro Check Item
							**/
								if (isset($_GET['transaction_id'])) {
							    	$pags_transaction_id = $_GET['transaction_id'];
							    	require_once( get_template_directory(). '/admin/core/PagSeguroLibrary/PagSeguroLibrary.php' );
							        try {

							            $pags_credentials = PagSeguroConfig::getAccountCredentials();
							            $pags_transaction = PagSeguroTransactionSearchService::searchByCode($pags_credentials, $pags_transaction_id);

							            $pags_status = $pags_transaction->getStatus()->getValue();
							            $pags_reference = $pags_transaction->getreference();
							            
							            if (isset($pags_reference)) {
							            	$pags_reference_exp = explode("-", $pags_reference);
							            	if(count($pags_reference_exp) == 2){
							            		$order_id = $pags_reference_exp[0];
							            		$otype = $pags_reference_exp[1];
							            	}elseif (count($pags_reference_exp) == 1) {
							            		$order_id = $pags_reference_exp[0];
							            		$otype = 0;
							            	}
							            }

							            if (!empty($order_id)) {
							            	if (in_array($pags_status, array(1,2))) {
							            		/* Cancel */
							            		if ($setup4_membersettings_paymentsystem == 2) {
							            			/* Membership */
							            			update_post_meta( $order_id, 'pointfinder_order_pagscheck', 1);
							            		}else{
							            			/* Pay per post*/
							            			if ($otype != 1) {
							            				global $wpdb;
								            			$item_post_id = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s and post_id = %s", 'pointfinder_order_itemid',$order_id));
														$status_of_post = get_post_status($order_id);

														if($status_of_post == 'pendingpayment'){
															$wpdb->UPDATE($wpdb->posts,array('post_status' => 'pendingapproval'),array('ID' => $item_post_id));
														}
														switch (intval($pags_status)) {
															case 1:
																	PFCreateProcessRecord(
																		array( 
																        'user_id' => $user_id,
																        'item_post_id' => $item_post_id,
																		'processname' => esc_html__('PagSeguro: The buyer initiated the transaction, but so far the PagSeguro not received any payment information.','pointfindert2d')
																	    )
																	);
																	$sccval .= esc_html__('PagSeguro: Your payment under review. Please wait until approval.','pointfindert2d');
																break;
															
															case 2:
																	PFCreateProcessRecord(
																		array( 
																        'user_id' => $user_id,
																        'item_post_id' => $item_post_id,
																		'processname' => esc_html__('PagSeguro: Payment under review.','pointfindert2d')
																	    )
																	);
																	$sccval .= esc_html__('PagSeguro: Your payment under review. Please wait until approval.','pointfindert2d');
																break;
														}
														
							            			}
							            		}
							            	}
							            }

							        } catch (PagSeguroServiceException $e) {/*$e->getMessage();*/}
							    }
							/**
							*End: Pagseguro Check Item
							**/


							/**
							*Start: Payu Process
							**/
								if (isset($_GET['payu'])) {

									$payu_mihd = (isset($_POST["mihpayid"]))?$_POST["mihpayid"]:'';
									$payu_status = (isset($_POST["status"]))?$_POST["status"]:'';
									$payu_firstname = (isset($_POST["firstname"]))?$_POST["firstname"]:'';
									$payu_amount = (isset($_POST["amount"]))?$_POST['amount']:'';
									$payu_txnid = (isset($_POST["txnid"]))?$_POST['txnid']:'';
									$payu_posted_hash = (isset($_POST["hash"]))?$_POST['hash']:'';
									$payu_key = (isset($_POST["key"]))?$_POST['key']:'';
									$payu_productinfo = (isset($_POST["productinfo"]))?$_POST['productinfo']:'';
									$payu_email = (isset($_POST["email"]))?$_POST['email']:'';
									$order_id = (isset($_POST["udf1"]))?$_POST['udf1']:'';
									$otype = (isset($_POST["udf2"]))?$_POST['udf2']:'';
									$item_post_id = (isset($_POST["udf3"]))?$_POST['udf3']:'';
									$payu_salt = PFPGIssetControl('payu_salt','','');

									if (!empty($payu_mihd) && !empty($payu_status)) {
										if (!empty($payu_posted_hash)) {
											if (isset($_POST["additionalCharges"])) {
												$additionalCharges=$_POST["additionalCharges"];
												$retHashSeq = $additionalCharges.'|'.$payu_salt.'|'.$payu_status.'||||||||'.$item_post_id.'|'.$otype.'|'.$order_id.'|'.$payu_email.'|'.$payu_firstname.'|'.$payu_productinfo.'|'.$payu_amount.'|'.$payu_txnid.'|'.$payu_key;
											}else{	  
												$retHashSeq = $payu_salt.'|'.$payu_status.'||||||||'.$item_post_id.'|'.$otype.'|'.$order_id.'|'.$payu_email.'|'.$payu_firstname.'|'.$payu_productinfo.'|'.$payu_amount.'|'.$payu_txnid.'|'.$payu_key;
											}
											$retHashSeq2 = hash("sha512", $retHashSeq);

											if ($payu_posted_hash == $retHashSeq2) {

												$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

												switch ($payu_status) {
													case 'success':
															$check_process = get_post_meta( $order_id, 'pointfinder_order_txnid', true );
															if (!empty($check_process)) {
																pointfinder_directpayment_success_process(
																	array(
																		'paymentsystem' => $setup4_membersettings_paymentsystem,
																        'item_post_id' => $item_post_id,
																        'order_post_id' => $order_id,
																        'otype' => $otype,
																        'user_id' => $user_id,
																		'paymentsystem_name' => esc_html__("PayU Money","pointfindert2d"),
																		'checkout_process_name' => 'DoExpressCheckoutPaymentPayu'
																	)
																);
																$sccval .= esc_html__('Thanks for your payment. PayU Money payment process completed. Please wait for auto page refresh.','pointfindert2d');
																
																$sccval .= '<script>setTimeout(function(){window.location.reload(1);}, 3000);</script>';
															}
																
														break;
													
													case 'pending':
															if ($setup4_membersettings_paymentsystem == 2) {
																PFCreateProcessRecord(
												                  array( 
												                    'user_id' => $user_id,
												                    'item_post_id' => $order_post_id,
												                    'processname' => esc_html__('Payu Money: Payment pending.','pointfindert2d').'ID:'.$_REQUEST['mihpayid'],
												                    'membership' => 1
												                    )
												                );
															}else{
											            		PFCreateProcessRecord(
																	array( 
															        'user_id' => $user_id,
															        'item_post_id' => $item_post_id,
																	'processname' => esc_html__('Payu Money: Payment pending.','pointfindert2d').'ID:'.$_REQUEST['mihpayid']
																    )
																);
											            	}
											            	$sccval .= esc_html__('Thank you for shopping with us. Right now your payment status is pending.','pointfindert2d');
														break;

													case 'failure':
															$payu_error = (isset($_POST["error"]))?$_POST['error']:'';
															$payu_error_Message = (isset($_POST["error_Message"]))?$_POST['error_Message']:'';
															if ($setup4_membersettings_paymentsystem == 2) {
																PFCreateProcessRecord(
												                  array( 
												                    'user_id' => $user_id,
												                    'item_post_id' => $order_post_id,
												                    'processname' => esc_html__('Payu Money: Payment canceled.','pointfindert2d').' - '.$payu_error.' - '.$payu_error_Message.' - ID:'.$_REQUEST['mihpayid'],
												                    'membership' => 1
												                    )
												                );
															}else{
											            		PFCreateProcessRecord(
																	array( 
															        'user_id' => $user_id,
															        'item_post_id' => $item_post_id,
																	'processname' => esc_html__('Payu Money: Payment canceled.','pointfindert2d').' - '.$payu_error.' - '.$payu_error_Message.' - ID:'.$_REQUEST['mihpayid']
																    )
																);
											            	}
											            	$errorval .= esc_html__('Thank you for shopping with us. However, the transaction has been declined.','pointfindert2d');
														break;
												}
											}else{
												if (!empty($errorval)) {
													$errorval .= "<br>";
												}
												$errorval .= esc_html__("Invalid Transaction. Please try again","pointfindert2d");
											}
										}
									}
								}
							/**
							*End: Payu Process
							**/


							/**
							*Start: iDeal Process
							**/	
								if (isset($_GET['il'])) {
									$ideal_check = get_post_meta( sanitize_text_field($_GET['il']), 'pointfinder_order_ideal', true );

									if (!empty($ideal_check)) {
										require_once( get_template_directory(). '/admin/core/Mollie/API/Autoloader.php' );
										$ideal_id = PFPGIssetControl('ideal_id','','');
							          	$mollie = new Mollie_API_Client;
							          	$mollie->setApiKey($ideal_id);

							          	$payment  = $mollie->payments->get($ideal_check);
							          	$status = $payment->status;

							          	if (isset($status)) {
							          		if ($payment->isPaid()){
											    $sccval .= esc_html__('Thanks for your payment. iDeal payment process completed.','pointfindert2d');
											}elseif (! $payment->isOpen()){
											    $errorval .= esc_html__('Unfortunately iDeal payment process not completed.','pointfindert2d');
											}

											delete_post_meta( sanitize_text_field($_GET['il']), 'pointfinder_order_ideal');
							          	}
									}
								}
							/**
							*End: iDeal Process
							**/


							/**
							*Start: Robokassa Process
							**/
								if (isset($_GET['ro'])) {
									
									$robo_pass1 = PFPGIssetControl('robo_pass1','','');

									$order_id = esc_attr($_POST["InvId"]);
									$out_summ = esc_attr($_POST["out_summ"]);
									$item_post_id = esc_attr($_POST["Shp_itemnum"]);
									$user_id = esc_attr($_POST["Shp_user"]);
									$otype = esc_attr($_POST["Shp_otype"]);
									$robo_crc = isset($_POST["SignatureValue"])?esc_attr($_POST["SignatureValue"]):'';


									$robo_check = get_post_meta( sanitize_text_field($order_id), 'pointfinder_order_robo', true );

									if (esc_attr($_GET['ro']) == 's' && !empty($robo_check)) {
										
										$robo_crc = strtoupper($robo_crc);

										$robo_new_crc = strtoupper(md5("$out_summ:$order_id:$robo_pass1:Shp_itemnum=$item_post_id:Shp_otype=$otype:Shp_user=$user_id"));

										if ($robo_new_crc == $robo_crc){
											$sccval .= esc_html__('Thanks for your payment. Robokassa payment process completed.','pointfindert2d');
										}else{
											$errorval .= esc_html__('Unfortunately Robokassa payment process not completed. 2','pointfindert2d');
										}

										
									}elseif (esc_attr($_GET['ro']) == 'f' && !empty($robo_check)){
										/* Cancel */
										if ($setup4_membersettings_paymentsystem == 2) {
											PFCreateProcessRecord(
							                  array( 
							                    'user_id' => $user_id,
							                    'item_post_id' => $order_id,
							                    'processname' => esc_html__('Robokassa: Payment canceled.','pointfindert2d'),
							                    'membership' => 1
							                    )
							                );
										}else{
						            		PFCreateProcessRecord(
												array( 
										        'user_id' => $user_id,
										        'item_post_id' => $item_post_id,
												'processname' => esc_html__('Robokassa: Payment canceled.','pointfindert2d')
											    )
											);
						            	}
						            	$errorval .= esc_html__('Unfortunately Robokassa payment process not completed.','pointfindert2d');
									}

									delete_post_meta( sanitize_text_field($order_id), 'pointfinder_order_robo');
								}
							/**
							*End: Robokassa Process
							**/


							


							/**
							*Start: My Items Form Request
							**/
								$redirectval = false;
								if(isset($_GET)){
									if (isset($_GET['action'])) {
								
										$action_ofpage = esc_attr($_GET['action']);
									
										/**
										* Process for Membership System
										**/

											/**
											*Start:Response Membership Package
											**/
												
												if ($action_ofpage == 'pf_recm') {

													
													if($user_id != 0){

														if (isset($_GET['token'])) {
															global $wpdb;

															/*Check token*/
															$order_post_id = $wpdb->get_var( $wpdb->prepare( 
																"SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s and meta_key = %s", 
																esc_attr($_GET['token']),
																'pointfinder_order_token'
															) );

															
															$package_post_id = $item_post_id = $wpdb->get_var( $wpdb->prepare(
																"SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s and post_id = %s", 
																'pointfinder_order_packageid',
																$order_post_id
															) );
										
															$result = $wpdb->get_results( $wpdb->prepare( 
																"SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
																$package_post_id,
																$user_id,
																$setup3_pointposttype_pt1
															) );


															
															if (!empty($package_post_id) && !empty($order_post_id)) {	

																	$paypal_price_unit = PFSAIssetControl('setup20_paypalsettings_paypal_price_unit','','USD');
																	$paypal_sandbox = PFSAIssetControl('setup20_paypalsettings_paypal_sandbox','','0');
																	$paypal_api_user = PFSAIssetControl('setup20_paypalsettings_paypal_api_user','','');
																	$paypal_api_pwd = PFSAIssetControl('setup20_paypalsettings_paypal_api_pwd','','');
																	$paypal_api_signature = PFSAIssetControl('setup20_paypalsettings_paypal_api_signature','','2');

																	$setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
																	$setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
																	$setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');

																	$packageinfo = pointfinder_membership_package_details_get($package_post_id);
																	$apipackage_name = $packageinfo['webbupointfinder_mp_title'];
																	$infos = array();
																	$infos['USER'] = $paypal_api_user;
																	$infos['PWD'] = $paypal_api_pwd;
																	$infos['SIGNATURE'] = $paypal_api_signature;

																	if($paypal_sandbox == 1){$sandstatus = true;}else{$sandstatus = false;}
																	
																	$paypal = new Paypal($infos,$sandstatus);

																	$tokenparams = array(
																	   'TOKEN' => esc_attr($_GET['token']), 
																	);

																	$response = $paypal -> request('GetExpressCheckoutDetails',$tokenparams);
																	
																	

																	if (is_array($response)) {

																		if(isset($response['CHECKOUTSTATUS'])){

																			if($response['CHECKOUTSTATUS'] != 'PaymentActionCompleted'){
																				
																				/*Create a payment record for this process */
																				PF_CreatePaymentRecord(
																					array(
																						'user_id'	=>	$user_id,
																						'order_post_id'	=> $order_post_id,
																						'response'	=>	$response,
																						'token'	=>	$response['TOKEN'],
																						'payerid'	=>	$response['PAYERID'],
																						'processname'	=>	'GetExpressCheckoutDetails',
																						'status'	=>	$response['ACK'],
																						'membership' => 1
																						)
																				);

																				/*Check Payer id check for hack*/
																				if($response['ACK'] == 'Success' &&  esc_attr($_GET['PayerID'] == $response['PAYERID'])){

																					$setup20_paypalsettings_paypal_verified = PFSAIssetControl('setup20_paypalsettings_paypal_verified','','0');

																					if ($setup20_paypalsettings_paypal_verified == 1) {
																						if($response['PAYERSTATUS'] == 'verified'){
																							$work_status = 'accepted';
																						}else{
																							$work_status = 'declined';
																						}
																					}else{
																						$work_status = 'accepted';
																					}

																					if ($work_status == 'accepted') {
																						
																						if(isset($response['CUSTOM'])){
																							$custom_val_ex = explode(',', $response['CUSTOM']);
																							$process_type = $custom_val_ex[1];
																						}else{
																							$process_type = 'n';
																						}

																						$newpackage_id = (isset($response['PAYMENTREQUEST_0_NOTETEXT']))?$response['PAYMENTREQUEST_0_NOTETEXT']:0;
																						if (!empty($newpackage_id)) {
																							$packageinfo_n = pointfinder_membership_package_details_get($newpackage_id);
																						}else{$packageinfo_n = $packageinfo;}
																						$pointfinder_order_pricesign = esc_attr(get_post_meta( $order_post_id, 'pointfinder_order_pricesign', true ));
																						$pointfinder_order_listingtime = esc_attr(get_post_meta( $order_post_id, 'pointfinder_order_listingtime', true ));
																						$pointfinder_order_price = esc_attr(get_post_meta( $order_post_id, 'pointfinder_order_price', true ));
																						$pointfinder_order_recurring = esc_attr(get_post_meta( $order_post_id, 'pointfinder_order_recurring', true ));
																						$pointfinder_order_listingtime = ($pointfinder_order_listingtime == '') ? 0 : $pointfinder_order_listingtime ;
																						$pointfinder_order_listingpid = esc_attr(get_post_meta($order_post_id, 'pointfinder_order_listingpid', true ));	

																						if ($process_type == 'u') {
																							$total_package_price =  number_format($packageinfo_n['webbupointfinder_mp_price'], $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);
																						} else {
																							$total_package_price =  number_format($packageinfo['webbupointfinder_mp_price'], $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);
																						}
																						
																						$user_info = get_userdata( $user_id );
																						

																						$admin_email = get_option( 'admin_email' );
										 												$setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);

										 												

																						if ($pointfinder_order_recurring == 1) {
																							/**
																							*Start : Recurring Payment Process
																							**/
																								/** Express Checkout **/
																								$expresspay_paramsr = array(
																									'TOKEN' => $response['TOKEN'],
																									'PAYERID' => $response['PAYERID'],
																									'PAYMENTREQUEST_0_AMT' => $total_package_price,
																									'PAYMENTREQUEST_0_CURRENCYCODE' => $paypal_price_unit,
																									'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
																								);
																								
																								$response_expressr = $paypal -> request('DoExpressCheckoutPayment',$expresspay_paramsr);
																								
																								if (isset($response_expressr['TOKEN'])) {
																									$tokenr = $response_expressr['TOKEN'];
																								}else{
																									$tokenr = '';
																								}
																								/*Create a payment record for this process */
																								PF_CreatePaymentRecord(
																										array(
																										'user_id'	=>	$user_id,
																										'order_post_id'	=> $order_post_id,
																										'response'	=>	$response_expressr,
																										'token'	=>	$tokenr,
																										'processname'	=>	'DoExpressCheckoutPayment',
																										'status'	=>	$response_expressr['ACK'],
																										'membership' => 1
																										)
																									);

																								if($response_expressr['ACK'] == 'Success'){
																									
																									if(isset($response_expressr['PAYMENTINFO_0_PAYMENTSTATUS'])){
																										if ($response_expressr['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {	

																											switch ($process_type) {
																												case 'n':
																													$exp_date = strtotime("+".$packageinfo['webbupointfinder_mp_billing_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."");
																													$app_date = strtotime("now");

																													update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
																													update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
																													update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 0);
																													

																									                $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

																									                /*Create User Limits*/
																									                update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
																									                update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
																									                update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
																									                update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
																									                update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
																									                update_user_meta( $user_id, 'membership_user_trialperiod', 0);
																									                update_user_meta( $user_id, 'membership_user_recurring', 0);
																									                update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);

																									                /* Create an invoice for this */
																										              PF_CreateInvoice(
																										                array( 
																										                  'user_id' => $user_id,
																										                  'item_id' => 0,
																										                  'order_id' => $order_post_id,
																										                  'description' => $packageinfo['webbupointfinder_mp_title'],
																										                  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																										                  'amount' => $packageinfo['packageinfo_priceoutput_text'],
																										                  'datetime' => strtotime("now"),
																										                  'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
																										                  'status' => 'publish'
																										                )
																										              );
																													break;

																												case 'u':
																													if (!empty($newpackage_id)) {
																														
																														$exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo_n,'order_id'=>$order_post_id,'process'=>'u'));
																														$app_date = strtotime("now");

																														update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
																														update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
																														update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 0);
																														update_post_meta( $order_post_id, 'pointfinder_order_packageid', $newpackage_id);

																										                $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

																										                /* Start: Calculate item/featured item count and remove from new package. */
																									                        $total_icounts = pointfinder_membership_count_ui($user_id);

																									                        /*Count User's Items*/
																									                        $user_post_count = 0;
																									                        $user_post_count = $total_icounts['item_count'];

																									                        /*Count User's Featured Items*/
																									                        $users_post_featured = 0;
																									                        $users_post_featured = $total_icounts['fitem_count'];

																									                        if ($packageinfo_n['webbupointfinder_mp_itemnumber'] != -1) {
																									                          $new_item_limit = $packageinfo_n['webbupointfinder_mp_itemnumber'] - $user_post_count;
																									                        }else{
																									                          $new_item_limit = $packageinfo_n['webbupointfinder_mp_itemnumber'];
																									                        }
																									                        
																									                        $new_fitem_limit = $packageinfo_n['webbupointfinder_mp_fitemnumber'] - $users_post_featured;


																									                        /*Create User Limits*/
																									                        update_user_meta( $user_id, 'membership_user_package_id', $packageinfo_n['webbupointfinder_mp_packageid']);
																									                        update_user_meta( $user_id, 'membership_user_package', $packageinfo_n['webbupointfinder_mp_title']);
																									                        update_user_meta( $user_id, 'membership_user_item_limit', $new_item_limit);
																									                        update_user_meta( $user_id, 'membership_user_featureditem_limit', $new_fitem_limit);
																									                        update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo_n['webbupointfinder_mp_images']);
																									                        update_user_meta( $user_id, 'membership_user_trialperiod', 0);
																									                        update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
																									                        update_user_meta( $user_id, 'membership_user_recurring', 0);
																									                     /* End: Calculate new limits */

																									                     /* Create an invoice for this */
																											              PF_CreateInvoice(
																											                array( 
																											                  'user_id' => $user_id,
																											                  'item_id' => 0,
																											                  'order_id' => $order_post_id,
																											                  'description' => $packageinfo_n['webbupointfinder_mp_title'].'-'.esc_html__('Upgrade','pointfindert2d'),
																											                  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																											                  'amount' => $packageinfo_n['packageinfo_priceoutput_text'],
																											                  'datetime' => strtotime("now"),
																											                  'packageid' => $packageinfo_n['webbupointfinder_mp_packageid'],
																											                  'status' => 'publish'
																											                )
																											              );

																													}
																													
																													break;

																												case 'r':
																													$exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process'=>'r'));
																													$app_date = strtotime("now");

																													update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
																													update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);

																									                $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

																									                /* Create an invoice for this */
																										              PF_CreateInvoice(
																										                array( 
																										                  'user_id' => $user_id,
																										                  'item_id' => 0,
																										                  'order_id' => $order_post_id,
																										                  'description' => $packageinfo['webbupointfinder_mp_title'].'-'.esc_html__('Renew','pointfindert2d'),
																										                  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																										                  'amount' => $packageinfo['packageinfo_priceoutput_text'],
																										                  'datetime' => strtotime("now"),
																										                  'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
																										                  'status' => 'publish'
																										                )
																										              );

																													break;
																											}
																										}
																									}
																									
																									if ($process_type == 'u') {
																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $user_info->user_email,
																										        'predefined' => 'paymentcompletedmember',
																										        'data' => array('paymenttotal' => $packageinfo_n['packageinfo_priceoutput_text'],'packagename' => $packageinfo_n['webbupointfinder_mp_title']),
																												)
																											);

																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $setup33_emailsettings_mainemail,
																										        'predefined' => 'newpaymentreceivedmember',
																										        'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo_n['packageinfo_priceoutput_text'],'packagename' => $packageinfo_n['webbupointfinder_mp_title']),
																												)
																											);
																									}else{
																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $user_info->user_email,
																										        'predefined' => 'paymentcompletedmember',
																										        'data' => array('paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $apipackage_name),
																												)
																											);

																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $setup33_emailsettings_mainemail,
																										        'predefined' => 'newpaymentreceivedmember',
																										        'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $apipackage_name),
																												)
																											);
																									}
																									
																									
																									$sccval .= esc_html__('Thanks for your payment. Please wait while redirecting...','pointfindert2d');
																									$redirectval = true;
																									/*Start : Creating Recurring Payment*/
																									$timestamp_forprofile = strtotime("+".$packageinfo['webbupointfinder_mp_billing_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."");
																									
																									$billing_description = sprintf(
																					                  esc_html__('%s / %s / Recurring: %s per %s','pointfindert2d'),
																					                  $packageinfo['webbupointfinder_mp_title'],
																					                  $packageinfo['packageinfo_itemnumber_output_text'].' '.esc_html__('Item','pointfindert2d'),
																					                  $packageinfo['packageinfo_priceoutput_text'],
																					                  $packageinfo['webbupointfinder_mp_billing_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text']                 
																					                 );

																									$recurringpay_params = array(
																										'TOKEN' => $response_expressr['TOKEN'],
																										'PAYERID' => $response['PAYERID'],
																										'PROFILESTARTDATE' => date("Y-m-d\TH:i:s\Z",$timestamp_forprofile),
																										'DESC' => $billing_description,
																										'BILLINGPERIOD' => pointfinder_billing_timeunit_text_paypal($packageinfo['webbupointfinder_mp_billing_time_unit']),
																										'BILLINGFREQUENCY' => $packageinfo['webbupointfinder_mp_billing_period'],
																										'AMT' => $total_package_price,
																										'CURRENCYCODE' => $paypal_price_unit,
																										'MAXFAILEDPAYMENTS' => 1
																									);
																									
																									$item_arr_rec = array(
																									   'L_PAYMENTREQUEST_0_NAME0' => $packageinfo['webbupointfinder_mp_title'],
																									   'L_PAYMENTREQUEST_0_AMT0' => $total_package_price,
																									   'L_PAYMENTREQUEST_0_QTY0' => '1',
																									   //'L_PAYMENTREQUEST_0_ITEMCATEGORY0'	=> 'Digital',
																									);
																									
																									$response_recurring = $paypal -> request('CreateRecurringPaymentsProfile',$recurringpay_params,$item_arr_rec);
																									unset($paypal);
																									/*Create a payment record for this process */
																									PF_CreatePaymentRecord(
																											array(
																											'user_id'	=>	$user_id,
																											'order_post_id'	=> $order_post_id,
																											'response'	=>	$response_recurring,
																											'token'	=>	$response_expressr['TOKEN'],
																											'processname'	=>	'CreateRecurringPaymentsProfile',
																											'status'	=>	$response_recurring['ACK'],
																											'membership' => 1
																											)

																										);


																										if($response_recurring['ACK'] == 'Success'){
																											
																											update_post_meta($order_post_id, 'pointfinder_order_recurringid', $response_recurring['PROFILEID'] );
																											update_post_meta($order_post_id, 'pointfinder_order_recurring', 1 );
																											update_user_meta($user_id, 'membership_user_recurring', 1);

																											
																											pointfinder_mailsystem_mailsender(
																												array(
																													'toemail' => $user_info->user_email,
																											        'predefined' => 'recprofilecreatedmember',
																											        'data' => array('title'=>get_the_title($order_post_id),'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $apipackage_name,'nextpayment' => date("Y-m-d", strtotime("+".$pointfinder_order_listingtime." days")),'profileid' => $response_recurring['PROFILEID']),
																													)
																												);

																											pointfinder_mailsystem_mailsender(
																												array(
																													'toemail' => $setup33_emailsettings_mainemail,
																											        'predefined' => 'recurringprofilecreatedmember',
																											        'data' => array(
																											        	'ID' => $user_id,
																											        	'title'=>get_the_title($order_post_id),
																											        	'orderid'=>$order_post_id,
																											        	'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],
																											        	'packagename' => $apipackage_name,
																											        	'nextpayment' => date("Y-m-d", strtotime("+".$pointfinder_order_listingtime." days")),
																											        	'profileid' => $response_recurring['PROFILEID']),
																													)
																												);
																											
																											$sccval .= esc_html__('Recurring payment profile created.','pointfindert2d');
																										}else{
																											
																											update_post_meta($order_post_id, 'pointfinder_order_recurring', 0 );	
																											$errorval .= esc_html__('Error: Recurring profile creation is failed. Recurring payment option cancelled.','pointfindert2d');
																										}
																										
																										/*End : Creating Recurring Payment*/
																										
																								}else{
																									
																									$errorval .= esc_html__('Sorry: The operation could not be completed. Recurring profile creation is failed and payment process could not completed.','pointfindert2d').'<br>';
																									if (isset($response_expressr['L_SHORTMESSAGE0'])) {
																										$errorval .= '<br>'.esc_html__('Paypal Message:','pointfindert2d').' '.$response_expressr['L_SHORTMESSAGE0'];
																									}
																									if (isset($response_expressr['L_LONGMESSAGE0'])) {
																										$errorval .= '<br>'.esc_html__('Paypal Message Details:','pointfindert2d').' '.$response_expressr['L_LONGMESSAGE0'];
																									}
																								}
																								
																								/** Express Checkout **/

																							/**
																							*End : Recurring Payment Process
																							**/
																						
																						}else{
																							/**
																							*Start : Express Payment Process
																							**/
																								
																								$expresspay_params = array(
																									'TOKEN' => $response['TOKEN'],
																									'PAYERID' => $response['PAYERID'],
																									'PAYMENTREQUEST_0_AMT' => $total_package_price,
																									'PAYMENTREQUEST_0_CURRENCYCODE' => $paypal_price_unit,
																									'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
																								);

																								$response_express = $paypal -> request('DoExpressCheckoutPayment',$expresspay_params);
																							
																								unset($paypal);

																								

																									
																								/*Create a payment record for this process */
																								if (isset($response_express['TOKEN'])) {
																									$token = $response_express['TOKEN'];
																								}else{
																									$token = '';
																								}
																								PF_CreatePaymentRecord(
																										array(
																										'user_id'	=>	$user_id,
																										'order_post_id'	=> $order_post_id,
																										'response'	=>	$response_express,
																										'token'	=>	$token,
																										'processname'	=>	'DoExpressCheckoutPayment',
																										'status'	=>	$response_express['ACK']
																										)
																									);
																							

																								if($response_express['ACK'] == 'Success'){
																									
																									if(isset($response_express['PAYMENTINFO_0_PAYMENTSTATUS'])){
																										if ($response_express['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {	
																											switch ($process_type) {
																												case 'n':
																													$exp_date = strtotime("+".$packageinfo['webbupointfinder_mp_billing_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."");
																													$app_date = strtotime("now");

																													update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
																													update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
																													update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 0);
																													

																									                $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

																									                /*Create User Limits*/
																									                update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
																									                update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
																									                update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
																									                update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
																									                update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
																									                update_user_meta( $user_id, 'membership_user_trialperiod', 0);
																									                update_user_meta( $user_id, 'membership_user_recurring', 0);
																									                update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);

																									                /* Create an invoice for this */
																										              PF_CreateInvoice(
																										                array( 
																										                  'user_id' => $user_id,
																										                  'item_id' => 0,
																										                  'order_id' => $order_post_id,
																										                  'description' => $packageinfo['webbupointfinder_mp_title'],
																										                  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																										                  'amount' => $packageinfo['packageinfo_priceoutput_text'],
																										                  'datetime' => strtotime("now"),
																										                  'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
																										                  'status' => 'publish'
																										                )
																										              );
																													break;

																												case 'u':

																													if (!empty($newpackage_id)) {

																														$exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo_n,'order_id'=>$order_post_id,'process'=>'u'));

																														$app_date = strtotime("now");

																														update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
																														update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);
																														update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 0);
																														update_post_meta( $order_post_id, 'pointfinder_order_packageid', $newpackage_id);

																										                $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

																										                /* Start: Calculate item/featured item count and remove from new package. */
																									                        $total_icounts = pointfinder_membership_count_ui($user_id);

																									                        /*Count User's Items*/
																									                        $user_post_count = 0;
																									                        $user_post_count = $total_icounts['item_count'];

																									                        /*Count User's Featured Items*/
																									                        $users_post_featured = 0;
																									                        $users_post_featured = $total_icounts['fitem_count'];

																									                        if ($packageinfo_n['webbupointfinder_mp_itemnumber'] != -1) {
																									                          $new_item_limit = $packageinfo_n['webbupointfinder_mp_itemnumber'] - $user_post_count;
																									                        }else{
																									                          $new_item_limit = $packageinfo_n['webbupointfinder_mp_itemnumber'];
																									                        }
																									                        
																									                        $new_fitem_limit = $packageinfo_n['webbupointfinder_mp_fitemnumber'] - $users_post_featured;


																									                        /*Create User Limits*/
																									                        update_user_meta( $user_id, 'membership_user_package_id', $packageinfo_n['webbupointfinder_mp_packageid']);
																									                        update_user_meta( $user_id, 'membership_user_package', $packageinfo_n['webbupointfinder_mp_title']);
																									                        update_user_meta( $user_id, 'membership_user_item_limit', $new_item_limit);
																									                        update_user_meta( $user_id, 'membership_user_featureditem_limit', $new_fitem_limit);
																									                        update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo_n['webbupointfinder_mp_images']);
																									                        update_user_meta( $user_id, 'membership_user_trialperiod', 0);
																									                        update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
																									                        update_user_meta( $user_id, 'membership_user_recurring', 0);
																									                    /* End: Calculate new limits */

																									                    /* Create an invoice for this */
																											              PF_CreateInvoice(
																											                array( 
																											                  'user_id' => $user_id,
																											                  'item_id' => 0,
																											                  'order_id' => $order_post_id,
																											                  'description' => $packageinfo_n['webbupointfinder_mp_title'].'-'.esc_html__('Upgrade','pointfindert2d'),
																											                  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																											                  'amount' => $packageinfo_n['packageinfo_priceoutput_text'],
																											                  'datetime' => strtotime("now"),
																											                  'packageid' => $packageinfo_n['webbupointfinder_mp_packageid'],
																											                  'status' => 'publish'
																											                )
																											              );
																										              
																													}
																													break;

																												case 'r':
																													$exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process'=>'r'));
																													$app_date = strtotime("now");

																													update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
																													update_post_meta( $order_post_id, 'pointfinder_order_datetime_approval', $app_date);

																									                $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));
																									                /* Create an invoice for this */
																										              PF_CreateInvoice(
																										                array( 
																										                  'user_id' => $user_id,
																										                  'item_id' => 0,
																										                  'order_id' => $order_post_id,
																										                  'description' => $packageinfo['webbupointfinder_mp_title'].'-'.esc_html__('Renew','pointfindert2d'),
																										                  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																										                  'amount' => $packageinfo['packageinfo_priceoutput_text'],
																										                  'datetime' => strtotime("now"),
																										                  'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
																										                  'status' => 'publish'
																										                )
																										              );
																													break;
																											}
																										}
																									}
																									

																									if ($process_type == 'u') {
																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $user_info->user_email,
																										        'predefined' => 'paymentcompletedmember',
																										        'data' => array('paymenttotal' => $packageinfo_n['packageinfo_priceoutput_text'],'packagename' => $packageinfo_n['webbupointfinder_mp_title']),
																												)
																											);

																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $setup33_emailsettings_mainemail,
																										        'predefined' => 'newpaymentreceivedmember',
																										        'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo_n['packageinfo_priceoutput_text'],'packagename' => $packageinfo_n['webbupointfinder_mp_title']),
																												)
																											);
																									}else{
																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $user_info->user_email,
																										        'predefined' => 'paymentcompletedmember',
																										        'data' => array('paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $apipackage_name),
																												)
																											);

																										pointfinder_mailsystem_mailsender(
																											array(
																												'toemail' => $setup33_emailsettings_mainemail,
																										        'predefined' => 'newpaymentreceivedmember',
																										        'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $apipackage_name),
																												)
																											);
																									}
																										

																									$sccval .= esc_html__('Thanks for your payment. Please wait while redirecting...','pointfindert2d');
																									$redirectval = true;
																								}else{
																									$errorval .= esc_html__('Sorry: The operation could not be completed. Payment is failed.','pointfindert2d').'<br>';
																									if (isset($response_express['L_SHORTMESSAGE0'])) {
																										$errorval .= '<br>'.esc_html__('Paypal Message:','pointfindert2d').' '.$response_express['L_SHORTMESSAGE0'];
																									}
																									if (isset($response_express['L_LONGMESSAGE0'])) {
																										$errorval .= '<br>'.esc_html__('Paypal Message Details:','pointfindert2d').' '.$response_express['L_LONGMESSAGE0'];
																									}
																								}
																								
																							/**
																							*End : Express Payment Process
																							**/
																						}
																					
																						

																					
																					}else{
																						$errorval .= esc_html__('Sorry: Our payment system only accepts verified Paypal Users. Payment is failed.','pointfindert2d');
																					}
																					
																				}else{
																					$errorval .= esc_html__('Can not get express checkout informations. Payment is failed.','pointfindert2d');
																				}
																			}elseif($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
																				$sccval .= esc_html__('Payment Completed.','pointfindert2d').'';
																			}else{
																				$errorval .= esc_html__('Response could not be received. Payment is failed.','pointfindert2d').'(1)';
																			}
																		}else{
																			$errorval .= esc_html__('Response could not be received. Payment is failed.','pointfindert2d').'(2)';
																		}

																	}else{
																		$errorval .= esc_html__('Response could not be received. Payment is failed.','pointfindert2d');
																	}

															}

														}else{
															$errorval .= esc_html__('Need token value.','pointfindert2d');
														}

													}else{
													    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
												  	}
												}
												
											/**
											*End:Response Membership Package
											**/

											/**
											*Start:Bank Transfer Membership
											**/
												
												if ($action_ofpage == 'pf_pay2m') {

													if($user_id != 0){
												        $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder_ex', true );
														$sccval .= esc_html__('Bank Transfer Process; Waiting payment...','pointfindert2d');
													}else{
													    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
												  	}

												  	/**
													*Start: Bank Transfer Page Content
													**/
														$output = new PF_Frontend_Fields(
																array(
																	'formtype' => 'banktransfer',
																	'sccval' => $sccval,
																	'errorval' => $errorval,
																	'post_id' => get_the_title($order_post_id),

																)
															);
														echo $output->FieldOutput;
														break;
													/**
													*End: Bank Transfer Page Content
													**/
												}
											/**
											*End:Bank Transfer Membership
											**/

											/**
											*Start:Cancel Bank Transfer Membership
											**/
												
												if ($action_ofpage == 'cancelbankm') {

													if($user_id != 0){
												        $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder_ex', true );

												        update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 0);

												        delete_user_meta($user_id, 'membership_user_package_id_ex');
										                delete_user_meta($user_id, 'membership_user_activeorder_ex');
										                delete_user_meta($user_id, 'membership_user_subaction_ex');
										                delete_user_meta($user_id, 'membership_user_invnum_ex');

										                PFCreateProcessRecord(
										                  array( 
										                    'user_id' => $user_id,
										                    'item_post_id' => $order_post_id,
										                    'processname' => esc_html__('Bank Transfer Cancelled by User','pointfindert2d'),
										                    'membership' => 1
										                    )
										                );

										                /*Create email record for this*/
														$user_info = get_userdata( $user_id );
														pointfinder_mailsystem_mailsender(
															array(
																'toemail' => $user_info->user_email,
														        'predefined' => 'bankpaymentcancelmember',
														        'data' => array('ID' => $order_post_id),
																)
															);

														$sccval .= esc_html__('Bank Transfer Cancelled. Redirecting...','pointfindert2d');
														$redirectval = true;
													}else{
													    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
												  	}

												}
											/**
											*End:Cancel Bank Transfer Membership
											**/

										/**
										* Process for Membership System
										**/






										/**
										* Process for Basic Listing
										**/

											/**
											*Start:Extend free listing
											**/
												if ($action_ofpage == 'pf_extend') {
													$stp31_userfree = PFSAIssetControl("stp31_userfree","","0");
													
													if ($stp31_userfree == 1) {
														if($user_id != 0){

															$item_post_id = (is_numeric($_GET['i']))? esc_attr($_GET['i']):'';

															if ($item_post_id != '') {

																/*Check if item user s item*/
																global $wpdb;
											
																$result = $wpdb->get_results( $wpdb->prepare( 
																	"SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
																	$item_post_id,
																	$user_id,
																	$setup3_pointposttype_pt1
																) );


																
																if (is_array($result) && count($result)>0) {	
																	
																	if ($result[0]->ID == $item_post_id) {

																		/*Meta for order*/
																		global $wpdb;
																		$result_id = $wpdb->get_var( $wpdb->prepare(
																			"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", 
																			'pointfinder_order_itemid',
																			$item_post_id
																		) );

																		$status_of_post = get_post_status($item_post_id);

																		$pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
																		if ($status_of_post == 'pendingpayment' && $pointfinder_order_price == 0) {
																			/*Extend listing*/
																			$pointfinder_order_listingtime = esc_attr(get_post_meta( $result_id, 'pointfinder_order_listingtime', true ));
																			

														        			$old_expire_date = get_post_meta( $result_id, 'pointfinder_order_expiredate', true);

														        			$exp_date = date("Y-m-d H:i:s",strtotime($old_expire_date .'+'.$pointfinder_order_listingtime.' day'));
																			$app_date = date("Y-m-d H:i:s");
																		
																			update_post_meta( $result_id, 'pointfinder_order_expiredate', $exp_date);
																			update_post_meta( $result_id, 'pointfinder_order_datetime_approval', $app_date);

																			$wpdb->update($wpdb->posts,array('post_status'=>'publish'),array('ID'=>$item_post_id));
																			$wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$result_id));

																			PFCreateProcessRecord(
																				array( 
																		        'user_id' => $user_id,
																		        'item_post_id' => $item_post_id,
																				'processname' => sprintf(esc_html__('Expire date extended by User (Free Listing): (Order Date: %s / Expire Date: %s)','pointfindert2d'),
																					$app_date,
																					$exp_date
																					)
																			    )
																			);
																			$sccval .= esc_html__('Item expire date extended.','pointfindert2d');
																		}else{
																			$errorval .= esc_html__('Item could not extend.','pointfindert2d');
																		}

																		
																	}else{
																		$errorval .= esc_html__('Wrong item ID (It is not your item!). Payment process is stopped.','pointfindert2d');
																	}
																}
															}else{
																$errorval .= esc_html__('Wrong item ID.','pointfindert2d');
															}
														}else{
														    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
													  	}
													}
												}
											/**
											*End:Extend Free Listing
											**/


											/**
											*Start:Bank Transfer
											**/
												
												if ($action_ofpage == 'pf_pay2') {

													if($user_id != 0){

														$item_post_id = (is_numeric($_GET['i']))? esc_attr($_GET['i']):'';

														if ($item_post_id != '') {

															/*Check if item user s item*/
															global $wpdb;
										
															$result = $wpdb->get_results( $wpdb->prepare( 
																"SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
																$item_post_id,
																$user_id,
																$setup3_pointposttype_pt1
															) );


															
															if (is_array($result) && count($result)>0) {	
																
																if ($result[0]->ID == $item_post_id) {

																	/*Meta for order*/
																	global $wpdb;
																	$result_id = $wpdb->get_var( $wpdb->prepare(
																		"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", 
																		'pointfinder_order_itemid',
																		$item_post_id
																	) );

																	$pointfinder_order_recurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurring', true ));

																	$pointfinder_order_frecurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_frecurring', true ));

																	if($pointfinder_order_recurring != 1 && $pointfinder_order_frecurring != 1){
												
																		update_post_meta($result_id, 'pointfinder_order_bankcheck', '1');

																		

																		/*Create a payment record for this process */
																		PF_CreatePaymentRecord(
																			array(
																			'user_id'	=>	$user_id,
																			'item_post_id'	=>	$item_post_id,
																			'order_post_id'	=>	$result_id,
																			'processname'	=>	'BankTransfer',
																			)
																		);

																		/*Create email record for this*/
																		$user_info = get_userdata( $user_id );
																		$mail_item_title = get_the_title($item_post_id);

																		$setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
																		$setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
																		$setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');
																		$pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));

																		$total_package_price =  number_format($pointfinder_order_price, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);

																		$pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpid', true ));	
																		$pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true ));	

																		$paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));
																	
																		$apipackage_name = $pointfinder_order_listingpname;


																		/* Create an invoice for this */
																		$invoice_id = PF_CreateInvoice(
																			array( 
																			  'user_id' => $user_id,
																			  'item_id' => $item_post_id,
																			  'order_id' => $result_id,
																			  'description' => $apipackage_name,
																			  'processname' => esc_html__('Bank Payment','pointfindert2d'),
																			  'amount' => $pointfinder_order_price,
																			  'datetime' => strtotime("now"),
																			  'packageid' => 0,
																			  'status' => 'pendingpayment'
																			)
																		);
																		update_post_meta($result_id, 'pointfinder_order_invoice', $invoice_id);

																		pointfinder_mailsystem_mailsender(
																			array(
																			'toemail' => $user_info->user_email,
																	        'predefined' => 'bankpaymentwaiting',
																	        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => $total_package_price,'packagename' => $apipackage_name),
																			)
																		);

																		$admin_email = get_option( 'admin_email' );
											 							$setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
																		pointfinder_mailsystem_mailsender(
																			array(
																				'toemail' => $setup33_emailsettings_mainemail,
																		        'predefined' => 'newbankpreceived',
																		        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => $total_package_price,'packagename' => $apipackage_name),
																				)
																			);

																		$sccval .= esc_html__('Bank Transfer Process; Completed','pointfindert2d');
																	}else{
																		$errorval .= esc_html__('Recurring Payment Orders not accepted for bank transfer.','pointfindert2d');
																	}
																}else{
																	$errorval .= esc_html__('Wrong item ID (It is not your item!). Payment process is stopped.','pointfindert2d');
																}
															}
														}else{
															$errorval .= esc_html__('Wrong item ID.','pointfindert2d');
														}
													}else{
													    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
												  	}

												  	/**
													*Start: Bank Transfer Page Content
													**/

														$output = new PF_Frontend_Fields(
																array(
																	'formtype' => 'banktransfer',
																	'sccval' => $sccval,
																	'errorval' => $errorval,
																	'post_id' => $item_post_id
																)
															);
														echo $output->FieldOutput;
														break;
													/**
													*End: Bank Transfer Page Content
													**/
												}
											/**
											*End:Bank Transfer
											**/


											/**
											*Start:Cancel Bank Transfer
											**/
												
												if ($action_ofpage == 'pf_pay2c') {

													if($user_id != 0){

														$item_post_id = (is_numeric($_GET['i']))? esc_attr($_GET['i']):'';

														if ($item_post_id != '') {

															/*Check if item user s item*/
															global $wpdb;
										
															$result = $wpdb->get_results( $wpdb->prepare( 
																"SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
																$item_post_id,
																$user_id,
																$setup3_pointposttype_pt1
															) );

															
															if (is_array($result) && count($result)>0) {	
																
																if ($result[0]->ID == $item_post_id) {

																	/*Meta for order*/
																	global $wpdb;
																	$result_id = $wpdb->get_var( $wpdb->prepare(
																		"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", 
																		'pointfinder_order_itemid',
																		$item_post_id
																	) );

																	update_post_meta($result_id, 'pointfinder_order_bankcheck', '0');
																	delete_post_meta( $result_id, 'pointfinder_order_invoice');

																	/*Create a payment record for this process */
																	PF_CreatePaymentRecord(
																			array(
																			'user_id'	=>	$user_id,
																			'item_post_id'	=>	$item_post_id,
																			'order_post_id'	=>	$result_id,
																			'processname'	=>	'BankTransferCancel',
																			)
																		);

																	/*Create email record for this*/
																	$user_info = get_userdata( $user_id );
																	$mail_item_title = get_the_title($item_post_id);
																	pointfinder_mailsystem_mailsender(
																		array(
																			'toemail' => $user_info->user_email,
																	        'predefined' => 'bankpaymentcancel',
																	        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title),
																			)
																		);


																	$sccval .= esc_html__('Bank Transfer Process; Cancelled','pointfindert2d');

																}else{
																	$errorval .= esc_html__('Wrong item ID (It is not your item!). Payment process is stopped.','pointfindert2d');
																}
															}
														}else{
															$errorval .= esc_html__('Wrong item ID.','pointfindert2d');
														}
													}else{
													    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
												  	}

												  	
												}

											/**
											*End:Cancel Bank Transfer
											**/


											/**
											*Start:Response Basic Listing
											**/
												
												if ($action_ofpage == 'pf_rec') {

													
													if($user_id != 0){

														if (isset($_GET['token'])) {
															global $wpdb;
															$otype = 0;

															/*Check token*/
															$order_post_id = $wpdb->get_var( $wpdb->prepare( 
																"SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s and meta_key = %s", 
																esc_attr($_GET['token']),
																'pointfinder_order_token'
															) );
																/* Check if sub order */
																if (empty($order_post_id)) {
																	$order_post_id = $wpdb->get_var( $wpdb->prepare( 
																		"SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s and meta_key = %s", 
																		esc_attr($_GET['token']),
																		'pointfinder_sub_order_token'
																	) );
																	if (!empty($order_post_id)) {
																		$otype = 1;
																	}
																}

															
															$item_post_id = $wpdb->get_var( $wpdb->prepare(
																"SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s and post_id = %s", 
																'pointfinder_order_itemid',
																$order_post_id
															) );
										
															$result = $wpdb->get_results( $wpdb->prepare( 
																"SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
																$item_post_id,
																$user_id,
																$setup3_pointposttype_pt1
															) );


															
															if (is_array($result) && count($result)>0) {	
																
																if ($result[0]->ID == $item_post_id) {
																

																	$paypal_price_unit = PFSAIssetControl('setup20_paypalsettings_paypal_price_unit','','USD');
																	$paypal_sandbox = PFSAIssetControl('setup20_paypalsettings_paypal_sandbox','','0');
																	$paypal_api_user = PFSAIssetControl('setup20_paypalsettings_paypal_api_user','','');
																	$paypal_api_pwd = PFSAIssetControl('setup20_paypalsettings_paypal_api_pwd','','');
																	$paypal_api_signature = PFSAIssetControl('setup20_paypalsettings_paypal_api_signature','','2');

																	$setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
																	$setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
																	$setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');

																	$infos = array();
																	$infos['USER'] = $paypal_api_user;
																	$infos['PWD'] = $paypal_api_pwd;
																	$infos['SIGNATURE'] = $paypal_api_signature;

																	if($paypal_sandbox == 1){$sandstatus = true;}else{$sandstatus = false;}
																	
																	$paypal = new Paypal($infos,$sandstatus);

																	$tokenparams = array(
																	   'TOKEN' => esc_attr($_GET['token']), 
																	);

																	$response = $paypal -> request('GetExpressCheckoutDetails',$tokenparams);
																	
																	
																	if (is_array($response)) {

																			if(isset($response['CHECKOUTSTATUS'])){

																				if($response['CHECKOUTSTATUS'] != 'PaymentActionCompleted'){
																					/*Create a payment record for this process */
																					PF_CreatePaymentRecord(
																						array(
																							'user_id'	=>	$user_id,
																							'item_post_id'	=>	$item_post_id,
																							'order_post_id'	=> $order_post_id,
																							'response'	=>	$response,
																							'token'	=>	$response['TOKEN'],
																							'payerid'	=>	$response['PAYERID'],
																							'processname'	=>	'GetExpressCheckoutDetails',
																							'status'	=>	$response['ACK']
																							)
																					);

																		
																					/*Check Payer id*/
																					if($response['ACK'] == 'Success' &&  esc_attr($_GET['PayerID'] == $response['PAYERID'])){

																						$setup20_paypalsettings_paypal_verified = PFSAIssetControl('setup20_paypalsettings_paypal_verified','','0');

																						if ($setup20_paypalsettings_paypal_verified == 1) {
																							if($response['PAYERSTATUS'] == 'verified'){
																								$work_status = 'accepted';
																							}else{
																								$work_status = 'declined';
																							}
																						}else{
																							$work_status = 'accepted';
																						}

																						if ($work_status == 'accepted') {
																							
																							$result_id = $order_post_id;

																							$pointfinder_sub_order_change = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_change', true ));
              
              																				if ($pointfinder_sub_order_change == 1 && $otype == 1 ) {

																								$pointfinder_order_pricesign = esc_attr(get_post_meta( $result_id, 'pointfinder_order_pricesign', true ));
																								$pointfinder_order_listingtime = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_listingtime', true ));
																								$pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
																								$pointfinder_order_listingtime = ($pointfinder_order_listingtime == '') ? 0 : $pointfinder_order_listingtime ;

																								$pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpid', true ));
																								$pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true ));		


																								$total_package_price = number_format($pointfinder_order_price, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);
																								
																								$paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

																								$apipackage_name = $pointfinder_order_listingpname. esc_html__('(Plan/Featured/Category Change)','pointfindert2d');

												 												/* Create an invoice for this */
																								PF_CreateInvoice(
																									array( 
																									  'user_id' => $user_id,
																									  'item_id' => $item_post_id,
																									  'order_id' => $result_id,
																									  'description' => $apipackage_name,
																									  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																									  'amount' => $total_package_price,
																									  'datetime' => strtotime("now"),
																									  'packageid' => 0,
																									  'status' => 'publish'
																									)
																								);

																								/**
																								*Start : Express Payment Process
																								**/
																									
																									$expresspay_params = array(
																										'TOKEN' => $response['TOKEN'],
																										'PAYERID' => $response['PAYERID'],
																										'PAYMENTREQUEST_0_AMT' => $total_package_price,
																										'PAYMENTREQUEST_0_CURRENCYCODE' => $paypal_price_unit,
																										'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
																									);
																									
																									$response_express = $paypal -> request('DoExpressCheckoutPayment',$expresspay_params);
																									/*print_r($response_express);*/
																									unset($paypal);

																										
																										/*Create a payment record for this process */
																										if (isset($response_express['TOKEN'])) {
																											$token = $response_express['TOKEN'];
																										}else{
																											$token = '';
																										}

																										
																										PF_CreatePaymentRecord(
																												array(
																												'user_id'	=>	$user_id,
																												'item_post_id'	=>	$item_post_id,
																												'order_post_id'	=> $order_post_id,
																												'response'	=>	$response_express,
																												'token'	=>	$token,
																												'processname'	=>	'DoExpressCheckoutPayment',
																												'status'	=>	$response_express['ACK']
																												)
																											);
																									

																										if($response_express['ACK'] == 'Success'){
																											
																											if(isset($response_express['PAYMENTINFO_0_PAYMENTSTATUS'])){
																												if ($response_express['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {						
																													$pointfinder_sub_order_changedvals = get_post_meta( $order_post_id, 'pointfinder_sub_order_changedvals', true );
																													
																													pointfinder_additional_orders(
																														array(
																															'changedvals' => $pointfinder_sub_order_changedvals,
																															'order_id' => $order_post_id,
																															'post_id' => $item_post_id
																														)
																													);
																												}
																											}
																											$sccval .= esc_html__('Thanks for your payment. All changes completed.','pointfindert2d');
																											
																										}else{
																											$errorval .= esc_html__('Sorry: The operation could not be completed. Payment is failed.','pointfindert2d').'<br>';
																											if (isset($response_express['L_SHORTMESSAGE0'])) {
																												$errorval .= '<br>'.esc_html__('Paypal Message:','pointfindert2d').' '.$response_express['L_SHORTMESSAGE0'];
																											}
																											if (isset($response_express['L_LONGMESSAGE0'])) {
																												$errorval .= '<br>'.esc_html__('Paypal Message Details:','pointfindert2d').' '.$response_express['L_LONGMESSAGE0'];
																											}
																										}
																									
																								/**
																								*End : Express Payment Process
																								**/

																							}else{
																								$pointfinder_order_pricesign = esc_attr(get_post_meta( $result_id, 'pointfinder_order_pricesign', true ));
																								$pointfinder_order_listingtime = esc_attr(get_post_meta( $result_id, 'pointfinder_order_listingtime', true ));
																								$pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
																								$pointfinder_order_recurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurring', true ));
																								$pointfinder_order_listingtime = ($pointfinder_order_listingtime == '') ? 0 : $pointfinder_order_listingtime ;

																								$pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpid', true ));
																								$pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true ));		


																								$total_package_price = number_format($pointfinder_order_price, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);
																								
																								$paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

																								$apipackage_name = $pointfinder_order_listingpname;

																								$setup31_userlimits_userpublish = PFSAIssetControl('setup31_userlimits_userpublish','','0');
																								$publishstatus = ($setup31_userlimits_userpublish == 1) ? 'publish' : 'pendingapproval' ;
																								
																								$user_info = get_userdata( $user_id );
																								$mail_item_title = get_the_title($item_post_id);

																								$admin_email = get_option( 'admin_email' );
												 												$setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);

												 												/* Create an invoice for this */
																								PF_CreateInvoice(
																									array( 
																									  'user_id' => $user_id,
																									  'item_id' => $item_post_id,
																									  'order_id' => $result_id,
																									  'description' => $apipackage_name,
																									  'processname' => esc_html__('Paypal Payment','pointfindert2d'),
																									  'amount' => $total_package_price,
																									  'datetime' => strtotime("now"),
																									  'packageid' => 0,
																									  'status' => 'publish'
																									)
																								);

																								if ($pointfinder_order_recurring == 1) {
																									/**
																									*Start : Recurring Payment Process
																									**/

																										

																										/** Express Checkout **/
																										$expresspay_paramsr = array(
																											'TOKEN' => $response['TOKEN'],
																											'PAYERID' => $response['PAYERID'],
																											'PAYMENTREQUEST_0_AMT' => $total_package_price,
																											'PAYMENTREQUEST_0_CURRENCYCODE' => $paypal_price_unit,
																											'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
																										);
																										
																										$response_expressr = $paypal -> request('DoExpressCheckoutPayment',$expresspay_paramsr);
																										
																										if (isset($response_expressr['TOKEN'])) {
																											$tokenr = $response_expressr['TOKEN'];
																										}else{
																											$tokenr = '';
																										}
																										/*Create a payment record for this process */
																										PF_CreatePaymentRecord(
																												array(
																												'user_id'	=>	$user_id,
																												'item_post_id'	=>	$item_post_id,
																												'order_post_id'	=> $order_post_id,
																												'response'	=>	$response_expressr,
																												'token'	=>	$tokenr,
																												'processname'	=>	'DoExpressCheckoutPayment',
																												'status'	=>	$response_expressr['ACK']
																												)
																											);
																									

																										if($response_expressr['ACK'] == 'Success'){
																											
																											if(isset($response_expressr['PAYMENTINFO_0_PAYMENTSTATUS'])){
																												if ($response_expressr['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {						
																														wp_update_post(array('ID' => $item_post_id,'post_status' => $publishstatus) );
																														wp_reset_postdata();
																														wp_update_post(array('ID' => $order_post_id,'post_status' => 'completed') );
																														wp_reset_postdata();

																														pointfinder_order_fallback_operations($order_post_id,$pointfinder_order_price);
																												}
																											}

																											pointfinder_mailsystem_mailsender(
																												array(
																													'toemail' => $user_info->user_email,
																											        'predefined' => 'paymentcompleted',
																											        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => $total_package_price,'packagename' => $apipackage_name),
																													)
																												);

																											pointfinder_mailsystem_mailsender(
																												array(
																													'toemail' => $setup33_emailsettings_mainemail,
																											        'predefined' => 'newpaymentreceived',
																											        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => $total_package_price,'packagename' => $apipackage_name),
																													)
																												);

																											$sccval .= sprintf(esc_html__('Thanks for your payment. %s Now please wait until our admin approve your payment and activate your item.','pointfindert2d'),'<br>');
																												
																												/*Start : Creating Recurring Payment*/

																												/* Added with v1.6.4 */
																								                $pointfinder_order_featured = esc_attr(get_post_meta($result_id, 'pointfinder_order_featured', true)); 
																								                if ($pointfinder_order_featured == 1) {
																								                  $setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','5');
																								                  $total_package_price_recurring = $total_package_price -  $setup31_userpayments_pricefeatured;
																								                }else{
																								                  $total_package_price_recurring = $total_package_price;
																								                }

																								                $total_package_price_recurring = number_format($total_package_price_recurring, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);


																												$timestamp_forprofile = strtotime('+ '.$pointfinder_order_listingtime.' days');
																										
																												$recurringpay_params = array(
																													'TOKEN' => $response_expressr['TOKEN'],
																													'PAYERID' => $response['PAYERID'],
																													'PROFILESTARTDATE' => date("Y-m-d\TH:i:s\Z",$timestamp_forprofile),
																													'DESC' => sprintf(
																														esc_html__('%s / %s / Recurring: %s%s per %s days / For: (%s)','pointfindert2d'),
																														$paymentName,
																														$apipackage_name,
																														$total_package_price_recurring,
																														$pointfinder_order_pricesign,
																														$pointfinder_order_listingtime,
																														$item_post_id
																													),
																													'BILLINGPERIOD' => 'Day',
																													'BILLINGFREQUENCY' => $pointfinder_order_listingtime,
																													'AMT' => $total_package_price_recurring,
																													'CURRENCYCODE' => $paypal_price_unit,
																													'MAXFAILEDPAYMENTS' => 1
																												);
																												
																												$item_arr_rec = array(
																												   'L_PAYMENTREQUEST_0_NAME0' => $paymentName.' : '.$apipackage_name,
																												   'L_PAYMENTREQUEST_0_AMT0' => $total_package_price_recurring,
																												   'L_PAYMENTREQUEST_0_QTY0' => '1',
																												);


																												/*If featured package enabled create a profile for this package*/
																												if ($pointfinder_order_featured == 1) {

																														$stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');
																														$timestamp_forprofile_featured = strtotime('+ '.$stp31_daysfeatured.' days');
																														
																														$setup31_userpayments_pricefeatured = number_format($setup31_userpayments_pricefeatured, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);

																														$recurringpay_params_featured = array(
																															'TOKEN' => $response_expressr['TOKEN'],
																															'PAYERID' => $response['PAYERID'],
																															'PROFILESTARTDATE' => date("Y-m-d\TH:i:s\Z",$timestamp_forprofile_featured),
																															'DESC' => sprintf(
																																esc_html__('%s / %s / Recurring: %s%s per %s days / For: (%s)','pointfindert2d'),
																																$paymentName,
																																esc_html__('Featured Point','pointfindert2d'),
																																$setup31_userpayments_pricefeatured,
																																$pointfinder_order_pricesign,
																																$stp31_daysfeatured,
																																$item_post_id
																															),
																															'BILLINGPERIOD' => 'Day',
																															'BILLINGFREQUENCY' => $stp31_daysfeatured,
																															'AMT' => $setup31_userpayments_pricefeatured,
																															'CURRENCYCODE' => $paypal_price_unit,
																															'MAXFAILEDPAYMENTS' => 1
																														);
																														if ($total_package_price_recurring > 0) {
																															$item_arr_rec_featured = array(
																															   'L_PAYMENTREQUEST_0_NAME1' => $paymentName.' : '.$apipackage_name,
																															   'L_PAYMENTREQUEST_0_AMT1' => $setup31_userpayments_pricefeatured,
																															   'L_PAYMENTREQUEST_0_QTY1' => '1',
																															);
																														}else{
																															$item_arr_rec_featured = array(
																															   'L_PAYMENTREQUEST_0_NAME0' => $paymentName.' : '.$apipackage_name,
																															   'L_PAYMENTREQUEST_0_AMT0' => $setup31_userpayments_pricefeatured,
																															   'L_PAYMENTREQUEST_0_QTY0' => '1',
																															);
																														}
																														
																														
																														$response_recurring_featured = $paypal -> request('CreateRecurringPaymentsProfile',$recurringpay_params_featured,$item_arr_rec_featured);
																														

																														/*Create a payment record for this process */
																														PF_CreatePaymentRecord(
																																array(
																																'user_id'	=>	$user_id,
																																'item_post_id'	=>	$item_post_id,
																																'order_post_id'	=> $order_post_id,
																																'response'	=>	$response_recurring_featured,
																																'token'	=>	$response_expressr['TOKEN'],
																																'processname'	=>	'CreateRecurringPaymentsProfile',
																																'status'	=>	$response_recurring_featured['ACK']
																																)

																															);

																														if($response_recurring_featured['ACK'] == 'Success'){
																															update_post_meta($order_post_id, 'pointfinder_order_frecurringid', $response_recurring_featured['PROFILEID'] );	

																															pointfinder_mailsystem_mailsender(
																																array(
																																	'toemail' => $user_info->user_email,
																															        'predefined' => 'recprofilecreated',
																															        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($setup31_userpayments_pricefeatured),'packagename' => esc_html__('Featured Point','pointfindert2d'),'nextpayment' => date("Y-m-d", strtotime("+".$stp31_daysfeatured." days")),'profileid' => $response_recurring_featured['PROFILEID']),
																																	)
																																);

																															pointfinder_mailsystem_mailsender(
																																array(
																																	'toemail' => $setup33_emailsettings_mainemail,
																															        'predefined' => 'recurringprofilecreated',
																															        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($setup31_userpayments_pricefeatured),'packagename' => esc_html__('Featured Point','pointfindert2d'),'nextpayment' => date("Y-m-d", strtotime("+".$stp31_daysfeatured." days")),'profileid' => $response_recurring_featured['PROFILEID']),
																																	)
																																);
																															$sccval .= '<br>'.esc_html__('Recurring payment profile created for Featured Point.','pointfindert2d');
																														}else{
																															update_post_meta($order_post_id, 'pointfinder_order_frecurring', 0 );
																															$errorval .= '<br>'.esc_html__('Error: Recurring profile creation is failed for Featured Point. Recurring payment option cancelled for featured point.','pointfindert2d');
																														}
																												}

																												if ($total_package_price_recurring > 0) {
																													$response_recurring = $paypal -> request('CreateRecurringPaymentsProfile',$recurringpay_params,$item_arr_rec);
																												
																													/*Create a payment record for this process */
																													PF_CreatePaymentRecord(
																															array(
																															'user_id'	=>	$user_id,
																															'item_post_id'	=>	$item_post_id,
																															'order_post_id'	=> $order_post_id,
																															'response'	=>	$response_recurring,
																															'token'	=>	$response_expressr['TOKEN'],
																															'processname'	=>	'CreateRecurringPaymentsProfile',
																															'status'	=>	$response_recurring['ACK']
																															)

																														);


																													if($response_recurring['ACK'] == 'Success'){
																														
																														update_post_meta($order_post_id, 'pointfinder_order_recurringid', $response_recurring['PROFILEID'] );	

																														pointfinder_mailsystem_mailsender(
																															array(
																																'toemail' => $user_info->user_email,
																														        'predefined' => 'recprofilecreated',
																														        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($total_package_price),'packagename' => $apipackage_name,'nextpayment' => date("Y-m-d", strtotime("+".$pointfinder_order_listingtime." days")),'profileid' => $response_recurring['PROFILEID']),
																																)
																															);

																														pointfinder_mailsystem_mailsender(
																															array(
																																'toemail' => $setup33_emailsettings_mainemail,
																														        'predefined' => 'recurringprofilecreated',
																														        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($total_package_price),'packagename' => $apipackage_name,'nextpayment' => date("Y-m-d", strtotime("+".$pointfinder_order_listingtime." days")),'profileid' => $response_recurring['PROFILEID']),
																																)
																															);

																														$sccval .= '<br>'.esc_html__('Recurring payment profile created for Listing.','pointfindert2d');
																													}else{
																														
																														update_post_meta($order_post_id, 'pointfinder_order_recurring', 0 );	
																														$errorval .= '<br>'.esc_html__('Error: Recurring profile creation is failed. Recurring payment option cancelled.','pointfindert2d');
																													}
																												}else{
																													update_post_meta($order_post_id, 'pointfinder_order_recurring', 0 );
																												}
																												unset($paypal);
																												
																												/*End : Creating Recurring Payment*/
																												
																										}else{
																											
																											$errorval .= '<br>'.esc_html__('Sorry: The operation could not be completed. Recurring profile creation is failed and payment process could not completed.','pointfindert2d').'<br>';
																											if (isset($response_expressr['L_SHORTMESSAGE0'])) {
																												$errorval .= '<br>'.esc_html__('Paypal Message:','pointfindert2d').' '.$response_expressr['L_SHORTMESSAGE0'];
																											}
																											if (isset($response_expressr['L_LONGMESSAGE0'])) {
																												$errorval .= '<br>'.esc_html__('Paypal Message Details:','pointfindert2d').' '.$response_expressr['L_LONGMESSAGE0'];
																											}
																										}
																										
																										/** Express Checkout **/

																									/**
																									*End : Recurring Payment Process
																									**/
																								
																								}else{
																									/**
																									*Start : Express Payment Process
																									**/
																										
																										$expresspay_params = array(
																											'TOKEN' => $response['TOKEN'],
																											'PAYERID' => $response['PAYERID'],
																											'PAYMENTREQUEST_0_AMT' => $total_package_price,
																											'PAYMENTREQUEST_0_CURRENCYCODE' => $paypal_price_unit,
																											'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
																										);
																										
																										$response_express = $paypal -> request('DoExpressCheckoutPayment',$expresspay_params);
																										/*print_r($response_express);*/
																										unset($paypal);

																											
																											/*Create a payment record for this process */
																											if (isset($response_express['TOKEN'])) {
																												$token = $response_express['TOKEN'];
																											}else{
																												$token = '';
																											}

																											
																											PF_CreatePaymentRecord(
																													array(
																													'user_id'	=>	$user_id,
																													'item_post_id'	=>	$item_post_id,
																													'order_post_id'	=> $order_post_id,
																													'response'	=>	$response_express,
																													'token'	=>	$token,
																													'processname'	=>	'DoExpressCheckoutPayment',
																													'status'	=>	$response_express['ACK']
																													)
																												);
																										

																											if($response_express['ACK'] == 'Success'){
																												
																												if(isset($response_express['PAYMENTINFO_0_PAYMENTSTATUS'])){
																													if ($response_express['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {						
																														wp_update_post(array('ID' => $item_post_id,'post_status' => $publishstatus) );
																														wp_reset_postdata();
																														wp_update_post(array('ID' => $order_post_id,'post_status' => 'completed') );
																														wp_reset_postdata();
																														
																														pointfinder_order_fallback_operations($order_post_id,$pointfinder_order_price);

																													}
																												}

																												pointfinder_mailsystem_mailsender(
																													array(
																														'toemail' => $user_info->user_email,
																												        'predefined' => 'paymentcompleted',
																												        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($total_package_price),'packagename' => $apipackage_name),
																														)
																													);

																												pointfinder_mailsystem_mailsender(
																													array(
																														'toemail' => $setup33_emailsettings_mainemail,
																												        'predefined' => 'newpaymentreceived',
																												        'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($total_package_price),'packagename' => $apipackage_name),
																														)
																													);

																												$sccval .= esc_html__('Thanks for your payment. Now please wait until our system approve your payment and activate your item listing.','pointfindert2d');
																											}else{
																												$errorval .= esc_html__('Sorry: The operation could not be completed. Payment is failed.','pointfindert2d').'<br>';
																												if (isset($response_express['L_SHORTMESSAGE0'])) {
																													$errorval .= '<br>'.esc_html__('Paypal Message:','pointfindert2d').' '.$response_express['L_SHORTMESSAGE0'];
																												}
																												if (isset($response_express['L_LONGMESSAGE0'])) {
																													$errorval .= '<br>'.esc_html__('Paypal Message Details:','pointfindert2d').' '.$response_express['L_LONGMESSAGE0'];
																												}
																											}
																										
																									/**
																									*End : Express Payment Process
																									**/
																								}
										
																							}
																							
																						}else{
																							$errorval .= esc_html__('Sorry: Our payment system only accepts verified Paypal Users. Payment is failed.','pointfindert2d');
																						}
																						
																					}else{
																						$errorval .= esc_html__('Can not get express checkout informations. Payment is failed.','pointfindert2d');
																					}
																				}elseif($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
																					$sccval .= esc_html__('Payment Completed.','pointfindert2d').'';
																				}else{
																					$errorval .= esc_html__('Response could not be received. Payment is failed.','pointfindert2d').'(1)';
																				}
																			}else{
																				$errorval .= esc_html__('Response could not be received. Payment is failed.','pointfindert2d').'(2)';
																			}

																	}else{
																		$errorval .= esc_html__('Response could not be received. Payment is failed.','pointfindert2d');
																	}
																	

																}else{
																	$errorval .= esc_html__('Wrong item ID (It is not your item!). Payment process is stopped.','pointfindert2d');
																}
															}

														}else{
															$errorval .= esc_html__('Need token value.','pointfindert2d');
														}
														
														

													}else{
													    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
												  	}
												}
												
											/**
											*End:Response Basic Listing
											**/


											/**
											*Start:Cancel Basic Listing
											**/
											
												if ($action_ofpage == 'pf_cancel') {
													$returned_token = esc_attr($_GET['token']);
													if(!empty($returned_token)){
														/*Create a payment record for this process */
														PF_CreatePaymentRecord(
																array(
																'user_id'	=>	$user_id,
																'token'	=>	$returned_token,
																'processname'	=>	'CancelPayment'
																)
															);
													}

													$errorval .= esc_html__('Sale process cancelled.','pointfindert2d');
												}
												
											/**
											*End:Cancel Basic Listing
											**/

										/**
										* Process Basic Listing
										**/

									}
								}

				
								/**
								*Start: Refine Listing
								**/
									if(isset($_GET['action'])){

										if (esc_attr($_GET['action']) == 'pf_refineitemlist') {
											/*
											$nonce = esc_attr($_POST['security']);
											if ( ! wp_verify_nonce( $nonce, 'pf_refineitemlist' ) ) {
												die( 'Security check' ); 
											}*/

											$vars = $_GET;
											
											$vars = PFCleanArrayAttr('PFCleanFilters',$vars);
										    
											if($user_id != 0){

												$output = new PF_Frontend_Fields(
														array(
															'formtype' => 'myitems',
															'fields' => $vars,
														)
													);
												echo $output->FieldOutput;
												echo '<script type="text/javascript">
												(function($) {
													"use strict";
													'.$output->ScriptOutput.'
												})(jQuery);</script>';
												unset($output);
												break;
												
											}else{
											    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
										  	}
										}
									}
								/**
								*End: Refine Listing
								**/
							/**
							*End: My Items Form Request
							**/

							/**
							*Start: My Items Page Content
							**/
	              				$membership_user_activeorder_ex = get_user_meta( $user_id, 'membership_user_activeorder_ex', true );
	              				if (!empty($membership_user_activeorder_ex)) {
	              					$pointfinder_order_pagscheck = get_post_meta( $membership_user_activeorder_ex, 'pointfinder_order_pagscheck', true );
	              				}else{
	              					$pointfinder_order_pagscheck = '';
	              				}
	              				if (!empty($pointfinder_order_pagscheck)) {
	              					if (!empty($sccval)) {
	              						$sccval .= '</br>';
	              					}
									$sccval .= esc_html__('Your order is waiting for approval. Please wait until we receive notification from PagSeguro.','pointfindert2d');
								}
							/**
							*End: My Items Form Request
							**/

							/**
							*Start: My Items Page Content
							**/

								$output = new PF_Frontend_Fields(
										array(
											'formtype' => 'myitems',
											'sccval' => $sccval,
											'errorval' => $errorval,
											'redirect' => $redirectval
										)
									);
								echo $output->FieldOutput;
								echo '<script type="text/javascript">
								(function($) {
									"use strict";
									'.$output->ScriptOutput.'
								})(jQuery);</script>';
								unset($output);

							/**
							*End: My Items Page Content
							**/
							break;

						case 'reviews':
							/**
							*Review Page Content
							**/
								$output = new PF_Frontend_Fields(
										array(
											'formtype' => 'reviews',
											'current_user' => $user_id
										)
									);
								echo $output->FieldOutput;
							/**
							*Review Page Content
							**/
							break;

						case 'profile':
							/**
							*Start: Profile Page Content
							**/
								$output = new PF_Frontend_Fields(
									array(
										'formtype' => 'profile',
										'current_user' => $user_id,
										'sccval' => $sccval,
										'errorval' => $errorval
									)
									);
								echo $output->FieldOutput;
								echo '<script type="text/javascript">
								(function($) {
									"use strict";
									'.$output->ScriptOutput.'
								})(jQuery);</script>';
								unset($output);
							/**
							*End: Profile Page Content
							**/
							break;

						case 'favorites':

							/**
							*Favs Page Content
							**/
								if(isset($_POST) && $_POST!='' && count($_POST)>0){

									if (esc_attr($_POST['action']) == 'pf_refinefavlist') {

										$nonce = esc_attr($_POST['security']);
										if ( ! wp_verify_nonce( $nonce, 'pf_refinefavlist' ) ) {
											die( 'Security check' ); 
										}

										$vars = $_POST;
										
										$vars = PFCleanArrayAttr('PFCleanFilters',$vars);
									    
										if($user_id != 0){

											$output = new PF_Frontend_Fields(
													array(
														'formtype' => 'favorites',
														'fields' => $vars,
														'current_user' => $user_id
													)
												);
											echo $output->FieldOutput;
											echo '<script type="text/javascript">
											(function($) {
												"use strict";
												'.$output->ScriptOutput.'
											})(jQuery);</script>';
											unset($output);
											break;
											
										}else{
										    $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
									  	}
									}
								}
							/**
							*Favs Page Content
							**/

							$output = new PF_Frontend_Fields(
										array(
											'formtype' => 'favorites',
											'current_user' => $user_id
										)
									);
								echo $output->FieldOutput;
							
							break;

						case 'invoices':
							/**
							*Invoices Page Content
							**/
								$output = new PF_Frontend_Fields(
										array(
											'formtype' => 'invoices',
											'current_user' => $user_id
										)
									);
								echo $output->FieldOutput;
							/**
							*Invoices Page Content
							**/
							break;

					}
					
					/**
					*Start: Page End Actions / Divs etc...
					**/
						switch($setup29_dashboard_contents_my_page_layout) {
							case '3':
							echo $pf_ua_col_close.$pf_ua_sidebar_codes.$sidebar_output;
							echo $pf_ua_sidebar_close.$pf_ua_suffix_codes;	
							break;
							case '2':
							echo $pf_ua_col_close.$pf_ua_suffix_codes;
							break;						
						}


						if ($setup29_dashboard_contents_my_page_pos == 0 && $setup29_dashboard_contents_my_page != '') {
							echo $content_of_section;
						}
					/**
					*End: Page End Actions / Divs etc...
					**/

				}
				/**
				*End: Member Page Actions
				**/
		}


	}else{
		
	   PFLoginWidget();
	}
}else{
	$content = get_the_content();
	if (!empty($setup4_membersettings_dashboard)) {
		if (is_page($setup4_membersettings_dashboard)) {
			$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
			$pfmenu_perout = PFPermalinkCheck();
			pf_redirect(''.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=profile');
		}else{
			if(function_exists('PFGetHeaderBar')){
			  PFGetHeaderBar();
			}
			
			if (!has_shortcode( $content , 'vc_row' )) {
				echo '<div class="pf-blogpage-spacing pfb-top"></div>';
	            echo '<section role="main">';
	                echo '<div class="pf-container">';
	                    echo '<div class="pf-row">';
	                        echo '<div class="col-lg-12">';
	                            the_content();
	                        echo '</div>';
	                    echo '</div>';
	                echo '</div>';
	            echo '</section>';
	            echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
			}else{
				the_content();
			}
		    
		}
	}else{
		if(function_exists('PFGetHeaderBar')){
		  PFGetHeaderBar();
		}
		if (!has_shortcode( $content , 'vc_row' )) {
			echo '<div class="pf-blogpage-spacing pfb-top"></div>';
	        echo '<section role="main">';
	            echo '<div class="pf-container">';
	                echo '<div class="pf-row">';
	                    echo '<div class="col-lg-12">';
	                        the_content();
	                    echo '</div>';
	                echo '</div>';
	            echo '</div>';
	        echo '</section>';
	        echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
		}else{
			the_content();
		}
	}
	
	
}
?>
