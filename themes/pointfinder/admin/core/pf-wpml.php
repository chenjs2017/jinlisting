<?php
/**********************************************************************************************************************************
*
* Point Finder dynamic WPML String Generator.
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
add_action( 'admin_menu', 'pf_register_wpml_string_output' );

function pf_register_wpml_string_output(){
    add_submenu_page('pointfinder_tools', '', esc_html__('WPML Config','pointfindert2d'), 'switch_themes', 'pfwpmlstring', 'pf_wpml_string_output');
}

function pf_wpml_string_output(){

	global $pointfindertheme_option;


	echo '<p>';
	    echo esc_html__('Please follow steps below;','pointfindert2d');
	    echo '  <ol>
				  <li>'.esc_html__('Please finish to configure PF Settings > Options Panel, Custom Fields Config, Search Fields Config and Review System Config','pointfindert2d').'</li>
				  <li>'.esc_html__('Click to "GENERATE WPML STRINGS" button.','pointfindert2d').'</li>
				  <li>'.esc_html__('Copy below text code and paste to wp-content > pointfinder > wpml-config.xml','pointfindert2d').'</li>
				  <li>'.esc_html__('Then you can use WPML > String Translation.','pointfindert2d').'</li>
				</ol>
				<br/>
				'.esc_html__('Note: This system will create custom strings for WPML by using admin & field options configuration. Please re create this file after change dynamic fields.','pointfindert2d').'
			';
		echo '<br/><br/><form method="GET" action="'.admin_url('admin.php?page=pfwpmlstring').'">
		<input type="hidden" value="pfwpmlstring" name="page">
		<input type="hidden" value="1" name="wpmlgenerate">
		<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="'.esc_html__( 'GENERATE WPML STRINGS', 'pointfindert2d' ).'" accesskey="p"></form>';
		echo '<br/><br/>'.esc_html__('On mouse click system will select all text into textarea. You only need to copy it.','pointfindert2d');

		echo '<textarea rows="24" style="width:100%;font-size:10px;" name="pfwpmlconfg" id="pfwpmlconfg">';
		
		if (isset($_GET['wpmlgenerate'])) {
			# code...
		
			echo '<wpml-config>'.PHP_EOL;
				echo '<admin-texts>'.PHP_EOL;

				/**
				*Start: PF Page Builder Settings
				**/
					echo '<key name="pfpbcontrol_options">';
						echo '<key name="general_postitembutton_buttontext" />';
					echo '</key>'.PHP_EOL;
				/**
				*END: PF Page Builder Settings
				**/


				/**
				*Start: PF Review System Settings
				**/
					echo '<key name="pfitemreviewsystem_options">';
						echo '<key name="setup11_reviewsystem_criterias">'.PHP_EOL;

								$setup11_reviewsystem_criterias = PFREVSIssetControl('setup11_reviewsystem_criterias','','');
								if(count($setup11_reviewsystem_criterias) > 0){
									for ($i=0; $i < (count($setup11_reviewsystem_criterias)) ; $i++) { 
										echo '<key name="'.$i.'" />'.PHP_EOL;
									}
								}
					        
						echo '</key>'.PHP_EOL;
					echo '</key>'.PHP_EOL;
				/**
				*END: PF Review System Settings
				**/


				/**
				*Start: PF Main Options
				**/
					echo '<key name="pointfindertheme_options">';

						/* General Settings */
							echo '
							<key name="setup17_logosettings_sitelogo">
				        		<key name="url" />
				        	</key>
				        	<key name="setup17_logosettings_sitelogo">
				        		<key name="url" />
				        	</key>
				        	<key name="setup17_logosettings_sitelogo2x">
				        		<key name="url" />
				        	</key>
				        	<key name="setup17_logosettings_sitefavicon">
				        		<key name="url" />
				        	</key>
							';

							echo '<key name="general_rtlsupport" />';

						/* Theme Customizer */
							echo '
				        	<key name="setup19_socialiconsbarsettings_phone" />
		        			<key name="setup19_socialiconsbarsettings_phone_link" />
							';

						/* Submission System */
							echo '
				        	<key name="setup4_membersettings_dashboard" />
		        			<key name="setup29_dashboard_contents_profile_page_title" />
				            <key name="setup29_dashboard_contents_profile_page_menuname" />
				            <key name="setup29_dashboard_contents_profile_page" />
				            <key name="setup29_dashboard_contents_submit_page_title" />
				            <key name="setup29_dashboard_contents_submit_page_menuname" />
				            <key name="setup29_dashboard_contents_submit_page_titlee" />
				            <key name="setup29_dashboard_contents_submit_page" />
				            <key name="setup29_dashboard_contents_my_page_title" />
				            <key name="setup29_dashboard_contents_my_page_menuname" />
				            <key name="setup29_dashboard_contents_my_page" />
				            <key name="setup29_dashboard_contents_favs_page_title" />
				            <key name="setup29_dashboard_contents_favs_page_menuname" />
				            <key name="setup29_dashboard_contents_favs_page" />
				            <key name="setup29_dashboard_contents_rev_page_title" />
				            <key name="setup29_dashboard_contents_rev_page_menuname" />
				            <key name="setup29_dashboard_contents_rev_page" />
				            <key name="setup29_dashboard_contents_inv_page_title" />
				            <key name="setup29_dashboard_contents_inv_page_menuname" />
				            <key name="setup4_submitpage_titletip" />
				            <key name="setup4_submitpage_titleverror" />
				            <key name="setup4_submitpage_descriptiontip" />
				            <key name="setup4_submitpage_description_verror" />
				            <key name="setup4_submitpage_maparea_tooltip" />
				            <key name="setup4_submitpage_maparea_verror" />
				            <key name="setup4_submitpage_featuredverror" />
				            <key name="setup4_submitpage_listingtypes_title" />
				            <key name="setup4_submitpage_sublistingtypes_title" />
				            <key name="setup4_submitpage_subsublistingtypes_title" />
				            <key name="setup4_submitpage_listingtypes_verror" />
				            <key name="setup4_submitpage_itemtypes_title" />
				            <key name="setup4_submitpage_itemtypes_verror" />
				            <key name="setup4_submitpage_locationtypes_title" />
				            <key name="stp4_sublotyp_title" />
				            <key name="stp4_subsublotyp_title" />
				            <key name="setup4_submitpage_locationtypes_verror" />
				            <key name="setup4_submitpage_featurestypes_title" />
				            <key name="setup4_submitpage_featurestypes_verror" />
				            <key name="setup4_submitpage_conditions_title" />
				            <key name="setup4_submitpage_conditions_verror" />
				            <key name="setup31_userpayments_titlefeatured" />
				            <key name="setup31_userpayments_textfeatured" />
				            <key name="setup20_paypalsettings_paypal_api_packagename" />
				            <key name="setup20_bankdepositsettings_text" />
							<key name="stp31_up2_pn" />
							<key name="setup42_itempagedetails_claim_validtext" />
							<key name="setup4_submitpage_maparea_title" />
							<key name="setup4_submitpage_maparea_tooltip" />
							';

						/* Custom Fields Setup */
							echo '<key name="setup1_slides">'.PHP_EOL;

									$setup1_slides = PFSAIssetControl('setup1_slides','','');
									$pfstart = PFCheckStatusofVar('setup1_slides');
									if($pfstart){
										for ($i=0; $i < (count($setup1_slides) - 1) ; $i++) { 
											echo '<key name="'.$i.'"><key name="title" /></key>'.PHP_EOL;
										}
									}
						        
							echo '</key>'.PHP_EOL;

							/* Search Fields Setup */
							echo '<key name="setup1s_slides">'.PHP_EOL;

									$setup1s_slides = PFSAIssetControl('setup1s_slides','','');
									$pfstart = PFCheckStatusofVar('setup1s_slides');
									if($pfstart){
										for ($i=0; $i < (count($setup1s_slides) - 1) ; $i++) { 
											echo '<key name="'.$i.'"><key name="title" /></key>'.PHP_EOL;
										}
									}
						        
							echo '</key>'.PHP_EOL;

						/* Post Types */
							echo '
							<key name="setup3_pointposttype_pt2" />
				            <key name="setup3_pointposttype_pt3" />
				            <key name="setup3_pointposttype_pt7" />
				            <key name="setup3_pointposttype_pt7s" />
				            <key name="setup3_pointposttype_pt4" />
				            <key name="setup3_pointposttype_pt4s" />
				            <key name="setup3_pointposttype_pt5" />
				            <key name="setup3_pointposttype_pt5s" />
				            <key name="setup3_pointposttype_pt6" />
				            <key name="setup3_pointposttype_pt6s" />
				            <key name="setup3_pointposttype_pt9" />
				            <key name="setup3_pointposttype_pt10" />
				            <key name="setup3_pointposttype_pt13" />
				            <key name="setup3_pointposttype_pt12" />
							';

						/* Review Criterias */

						/* Map Settings */
							echo '
							<key name="setup5_mapsettings_notfound" />
		            		<key name="setup15_mapnotifications_foundtext" />

		            		<key name="setup12_searchwindow_tooltips_text">
				            	<key name="si0" />
				            	<key name="si1" />
				            	<key name="si2" />
				            	<key name="si3" />
				            </key>

				            <key name="setup12_searchwindow_mapinfotext" />
							';

						/* Point Settings */
							echo '
							<key name="setup10_infowindow_hide_lt_text" />
		        			<key name="setup10_infowindow_hide_it_text" />
							';

						/* Item Detail Page */
							echo '<key name="setup42_itempagedetails_configuration">'.PHP_EOL;

									echo '
									<key name="gallery">
						            	<key name="title" />
						            </key>
						            <key name="location">
						            	<key name="title" />
						            </key>
						            <key name="informationbox">
						            	<key name="title" />
						            </key>
						            <key name="customtab1">
						            	<key name="title" />
						            </key>
						            <key name="customtab2">
						            	<key name="title" />
						            </key>
						            <key name="customtab3">
						            	<key name="title" />
						            </key>
						            <key name="description">
						            	<key name="title" />
						            </key>
						            <key name="details">
						            	<key name="title" />
						            </key>
						            <key name="features">
						            	<key name="title" />
						            </key>
						            <key name="video">
						            	<key name="title" />
						            </key>
						            <key name="contact">
						            	<key name="title" />
						            </key>
						            <key name="ohours">
						            	<key name="title" />
						            </key>
									';
						        
							echo '</key>'.PHP_EOL;

					echo '</key>'.PHP_EOL;
				/**
				*End: PF Main Options
				**/



				/**
				*Start: PF Custom Fields Options
				**/
					echo '<key name="pfcustomfields_options">';

					
							$setup1_slides = PFSAIssetControl('setup1_slides','','');
							$pfstart = PFCheckStatusofVar('setup1_slides');
							if($pfstart){

								$exclude_list = array(10,16,14,9,8,7);
								$exclude_list2 = array(14,9,8,7);

								foreach ($setup1_slides as &$value) {
									echo '<key name="setupcustomfields_'.$value['url'].'_parent" />';
									if(!in_array($value['select'], $exclude_list)){
										echo '
										<key name="setupcustomfields_'.$value['url'].'_message" />
							            <key name="setupcustomfields_'.$value['url'].'_frontendname" />
							            <key name="setupcustomfields_'.$value['url'].'_descriptionfront" />
							            <key name="setupcustomfields_'.$value['url'].'_sortname" />
							            <key name="setupcustomfields_'.$value['url'].'_shortname" />
							            <key name="setupcustomfields_'.$value['url'].'_description" />
							            <key name="setupcustomfields_'.$value['url'].'_defaultvalue" />
							            <key name="setupcustomfields_'.$value['url'].'_currency_prefix" />
							            <key name="setupcustomfields_'.$value['url'].'_currency_decima" />
							            <key name="setupcustomfields_'.$value['url'].'_currency_suffix" />
							            <key name="setupcustomfields_'.$value['url'].'_currency_decimp" />
							            <key name="setupcustomfields_'.$value['url'].'_currency_decimt" />
							            <key name="setupcustomfields_'.$value['url'].'_size_prefix" />
							            <key name="setupcustomfields_'.$value['url'].'_size_suffix" />
							            <key name="setupcustomfields_'.$value['url'].'_size_decimp" />
										';
									}
									if(in_array($value['select'], $exclude_list2)) {

										echo '<key name="setupcustomfields_'.$value['url'].'_rvalues">';
										$calc_rvalues = PFCFIssetControl('setupcustomfields_'.$value['url'].'_rvalues','','');
										if (is_array($calc_rvalues)) {
											for ($i=0; $i < (count($calc_rvalues)) ; $i++) { 
												echo '<key name="'.$i.'" />'.PHP_EOL;
											}
										}
										echo '</key>';
										echo '<key name="setupcustomfields_'.$value['url'].'_frontendname" />
							            <key name="setupcustomfields_'.$value['url'].'_descriptionfront" />
							            <key name="setupcustomfields_'.$value['url'].'_sortname" />
							            <key name="setupcustomfields_'.$value['url'].'_shortname" />
							            <key name="setupcustomfields_'.$value['url'].'_description" />';
									}
									
								}
							}
					        

					echo '</key>'.PHP_EOL;
				/**
				*End: PF Custom Fields Options
				**/



				/**
				*Start: PF Search Fields Options
				**/
					echo '<key name="pfsearchfields_options">';

						$setup1s_slides = PFSAIssetControl('setup1s_slides','','');
						$pfstart = PFCheckStatusofVar('setup1s_slides');
						if($pfstart){
							
							foreach ($setup1s_slides as &$value) {
					
								echo '
								<key name="setupsearchfields_'.$value['url'].'_fieldtext" />
					            <key name="setupsearchfields_'.$value['url'].'_placeholder" />
					            <key name="setupsearchfields_'.$value['url'].'_message" />
					            <key name="setupsearchfields_'.$value['url'].'_posttax_selected" />
					            <key name="setupsearchfields_'.$value['url'].'_nomatch" />
								';

								if(PFSFIssetControl('setupsearchfields_'.$value['url'].'_rvalues_check','','0') == 1) {
									echo '<key name="setupsearchfields_'.$value['url'].'_rvalues">';
									$calc_rvalues = PFSFIssetControl('setupsearchfields_'.$value['url'].'_rvalues','','');
									if (is_array($calc_rvalues)) {
										for ($i=0; $i < (count($calc_rvalues)) ; $i++) { 
											echo '<key name="'.$i.'" />'.PHP_EOL;
										}
									}
									echo '</key>';
								}
								
							}
						}

					echo '</key>'.PHP_EOL;
				/**
				*End: PF Search Fields Options
				**/



				/**
				*Start: PF Mail Fields Options
				**/
					echo '<key name="pointfindermail_options">';

						echo '
						<key name="setup35_contactform_subject" />
						<key name="setup35_contactform_contents" />
						<key name="setup35_contactform_title" />

						<key name="setup33_emailsettings_fromname" />

						<key name="setup33_emailsettings_sitename" />

						<key name="setup35_autoemailsadmin_directafterexpire" />

						<key name="setup35_autoemailsadmin_directafterexpire_subject" />
						<key name="setup35_autoemailsadmin_directafterexpire_title" />
						<key name="setup35_itemcontact_enquiryformadmin" />
						<key name="setup35_itemcontact_enquiryformadmin_subject" />
						<key name="setup35_itemcontact_enquiryformadmin_title" />
						<key name="setup35_itemcontact_enquiryformuser" />
						<key name="setup35_itemcontact_enquiryformuser_subject" />
						<key name="setup35_itemcontact_enquiryformuser_title" />
						<key name="setup35_itemcontact_report" />
						<key name="setup35_itemcontact_report_subject" />
						<key name="setup35_itemcontact_report_title" />
						<key name="setup35_itemreview_reviewflagformadmin" />
						<key name="setup35_itemreview_reviewflagformadmin_subject" />
						<key name="setup35_itemreview_reviewflagformadmin_title" />
						<key name="setup35_itemreview_reviewformadmin" />
						<key name="setup35_itemreview_reviewformadmin_subject" />
						<key name="setup35_itemreview_reviewformadmin_title" />
						<key name="setup35_itemreview_reviewformuser" />
						<key name="setup35_itemreview_reviewformuser_subject" />
						<key name="setup35_itemreview_reviewformuser_title" />
						<key name="setup35_loginemails_forgot_contents" />
						<key name="setup35_loginemails_forgot_subject" />
						<key name="setup35_loginemails_forgot_title" />
						<key name="setup35_loginemails_register_contents" />
						<key name="setup35_loginemails_register_subject" />
						<key name="setup35_loginemails_register_title" />
						<key name="setup35_paymentemails_bankpaymentcancel" />
						<key name="setup35_paymentemails_bankpaymentcancel_subject" />
						<key name="setup35_paymentemails_bankpaymentcancel_title" />
						<key name="setup35_paymentemails_bankpaymentwaiting" />
						<key name="setup35_paymentemails_bankpaymentwaiting_subject" />
						<key name="setup35_paymentemails_bankpaymentwaiting_title" />

						<key name="setup35_paymentmemberemails_bankpaymentcancel" />
						<key name="setup35_paymentmemberemails_bankpaymentcancel_subject" />
						<key name="setup35_paymentmemberemails_bankpaymentcancel_title" />
						<key name="setup35_paymentmemberemails_bankpaymentwaiting" />
						<key name="setup35_paymentmemberemails_bankpaymentwaiting_subject" />
						<key name="setup35_paymentmemberemails_bankpaymentwaiting_title" />
						<key name="setup35_paymentmemberemails_newbankpayment" />
						<key name="setup35_paymentmemberemails_newbankpayment_subject" />
						<key name="setup35_paymentmemberemails_newbankpayment_title" />
						<key name="setup35_paymentmemberemails_paymentcompleted" />
						<key name="setup35_paymentmemberemails_paymentcompleted_subject" />
						<key name="setup35_paymentmemberemails_paymentcompleted_title" />
						<key name="setup35_paymentmemberemails_paymentcompletedrec" />
						<key name="setup35_paymentmemberemails_paymentcompletedrec_subject" />
						<key name="setup35_paymentmemberemails_paymentcompletedrec_title" />
						<key name="setup35_paymentmemberemails_newdirectpayment" />
						<key name="setup35_paymentmemberemails_newdirectpayment_subject" />
						<key name="setup35_paymentmemberemails_newdirectpayment_title" />
						<key name="setup35_paymentmemberemails_newrecpayment" />
						<key name="setup35_paymentmemberemails_newrecpayment_subject" />
						<key name="setup35_paymentmemberemails_newrecpayment_title" />

						<key name="setup35_paymentemails_directbeforeexpire" />
						<key name="setup35_paymentemails_directbeforeexpire_subject" />
						<key name="setup35_paymentemails_directbeforeexpire_title" />
						<key name="setup35_paymentemails_expiredrecpayment" />
						<key name="setup35_paymentemails_expiredrecpayment_subject" />
						<key name="setup35_paymentemails_expiredrecpayment_title" />
						<key name="setup35_paymentemails_newbankpayment" />
						<key name="setup35_paymentemails_newbankpayment_subject" />
						<key name="setup35_paymentemails_newbankpayment_title" />
						<key name="setup35_paymentemails_newdirectpayment" />
						<key name="setup35_paymentemails_newdirectpayment_subject" />
						<key name="setup35_paymentemails_newdirectpayment_title" />
						<key name="setup35_paymentemails_newrecpayment" />
						<key name="setup35_paymentemails_newrecpayment_subject" />
						<key name="setup35_paymentemails_newrecpayment_title" />
						<key name="setup35_paymentemails_paymentcompleted" />
						<key name="setup35_paymentemails_paymentcompleted_subject" />
						<key name="setup35_paymentemails_paymentcompleted_title" />
						<key name="setup35_paymentemails_paymentcompletedrec" />
						<key name="setup35_paymentemails_paymentcompletedrec_subject" />
						<key name="setup35_paymentemails_paymentcompletedrec_title" />
						<key name="setup35_submissionemails_approveditem" />
						<key name="setup35_submissionemails_approveditem_subject" />
						<key name="setup35_submissionemails_approveditem_title" />
						<key name="setup35_submissionemails_deleted" />
						<key name="setup35_submissionemails_deleted_subject" />
						<key name="setup35_submissionemails_deleted_title" />
						<key name="setup35_submissionemails_newitem" />
						<key name="setup35_submissionemails_newitem_subject" />
						<key name="setup35_submissionemails_newitem_title" />
						<key name="setup35_submissionemails_rejected" />
						<key name="setup35_submissionemails_rejected_subject" />
						<key name="setup35_submissionemails_rejected_title" />
						<key name="setup35_submissionemails_updateditem" />
						<key name="setup35_submissionemails_updateditem_subject" />
						<key name="setup35_submissionemails_updateditem_title" />
						<key name="setup35_submissionemails_waitingapproval" />
						<key name="setup35_submissionemails_waitingapproval_subject" />
						<key name="setup35_submissionemails_waitingapproval_title" />
						<key name="setup35_submissionemails_waitingpayment" />
						<key name="setup35_submissionemails_waitingpayment_subject" />
						<key name="setup35_submissionemails_waitingpayment_title" />
						<key name="setup35_template_footertext" />
						<key name="setup35_template_logotext" />
						';

					echo '</key>'.PHP_EOL;
				/**
				*End: PF Mail Fields Options
				**/



				/**
				*Start: PF reCaptcha Options
				**/
					echo '<key name="pfrecaptcha_options">';

						echo '<key name="setupreCaptcha_general_lang" />';

					echo '</key>'.PHP_EOL;
				/**
				*End: PF reCaptcha Options
				**/


				echo '</admin-texts>'.PHP_EOL;
			echo '</wpml-config>';
		}else{
			echo esc_html__( 'Click to "GENERATE WPML STRINGS" button.', 'pointfindert2d' );
		}
		echo '</textarea>';

		echo '
		<script type="text/javascript">
		    var textBox = document.getElementById("pfwpmlconfg");
		    textBox.onfocus = function() {
		        textBox.select();

		        textBox.onmouseup = function() {
		            textBox.onmouseup = null;
		            return false;
		        };
		    };
		</script>
		';
	    echo '<br/>';
    echo '</p>';
}

?>