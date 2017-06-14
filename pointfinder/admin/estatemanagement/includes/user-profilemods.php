<?php
/**********************************************************************************************************************************
*
* User Profile Modifications
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

function pf_modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['user_twitter'] = esc_html__('Twitter','pointfindert2d');
	$profile_fields['user_facebook'] = esc_html__('Facebook','pointfindert2d');
	$profile_fields['user_googleplus'] = esc_html__('Google+','pointfindert2d');
	$profile_fields['user_linkedin'] = esc_html__('LinkedIn','pointfindert2d');
	$profile_fields['user_phone'] = esc_html__('Telephone','pointfindert2d');
	$profile_fields['user_mobile'] = esc_html__('Mobile','pointfindert2d');
	$profile_fields['user_vatnumber'] = esc_html__('Vat Number','pointfindert2d');
	$profile_fields['user_country'] = esc_html__('Country','pointfindert2d');
	$profile_fields['user_address'] = esc_html__('Address','pointfindert2d');


	return $profile_fields;
}
add_filter('user_contactmethods', 'pf_modify_contact_methods');

function pf_custom_user_profile_fields($user) {
	$setup3_pointposttype_pt6_status = PFSAIssetControl('setup3_pointposttype_pt6_status','','1');
	$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
	?>
	<table class="form-table">

		<?php if(current_user_can('activate_plugins')){?>
			<!-- User Photo -->
				<tr>
					<th>
						<label for="user_photo"><?php esc_html_e('Photo','pointfindert2d'); ?></label>
					</th>
					<td>
						<?php echo wp_get_attachment_image(get_user_meta( $user->ID, 'user_photo', true )); ?>
					</td>
				</tr>
			<!-- /User Photo -->
		<?php } ?>


		<?php if($setup3_pointposttype_pt6_status == 1 && current_user_can('activate_plugins')){?>
			<!-- User Agent Link -->
				<tr>
					<th>
						<label for="user_photo2"><?php esc_html_e('Link User to Agent','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="user_agent_link"><input type="text" name="user_agent_link" id="user_agent_link" value="<?php 
						echo get_user_meta( $user->ID, 'user_agent_link', true );
						?>" class="regular-text"><br/> <small><?php 
						esc_html_e("You can link an agent to this user. After this action this agent's contact information will seen this user's items.",'pointfindert2d');
						echo '<br/>';
						esc_html_e("This field only accept single agent ID number. And must be numeric.",'pointfindert2d');
						?></small></label>
					</td>
				</tr>
			<!-- /User Agent Link -->
		<?php } ?>


		<?php if(current_user_can('activate_plugins') && $setup4_membersettings_paymentsystem == 2){
			$membership_package_id = get_user_meta( $user->ID, 'membership_user_package_id', true );
			if (empty($membership_package_id)) {
				echo '
				<tr>
					<th>
						<label for="membership_user_package_head">'.esc_html__('Package','pointfindert2d').'</label>
					</th>
					<td>
						'.esc_html__('This user not have a package!','pointfindert2d').'
					</td>
				</tr>
				';
			?>
			<!-- New Package Create -->
				<tr>
					<th>
						<label for="membership_user_newplan_head"><?php esc_html_e('Setup New Plan','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_newplan">
						<select name="membership_user_newplan" id="membership_user_newplan">
						<?php
							$membership_query = new WP_Query(array('post_type' => 'pfmembershippacks','posts_per_page' => -1,'order_by'=>'ID','order'=>'ASC'));
							if ( $membership_query->have_posts() ) {
								echo '<option value="">'.__("Please Select A Plan","pointfindert2d").'</option>';
								while ( $membership_query->have_posts() ) {
									$membership_query->the_post();

									$post_id = get_the_id();

									$packageinfo = pointfinder_membership_package_details_get($post_id);

									if ($packageinfo['webbupointfinder_mp_showhide'] == 1) {
										echo '<option value="'.$packageinfo['webbupointfinder_mp_packageid'].'">'.$packageinfo['webbupointfinder_mp_title'].'('.$packageinfo['packageinfo_priceoutput_text'].')</option>';
									}
								}
							}
						?>
						</select>
						<br/><small>
						<?php _e("You have administrator rights. So this package price will not charged.",'pointfindert2d');?></small>
						</label>
					</td>
				</tr>
			<!-- /New Package Create -->
			<?php
			}else{
			$membership_user_activeorder = get_user_meta( $user->ID, 'membership_user_activeorder', true );
            $membership_user_expiredate = get_post_meta( $membership_user_activeorder, 'pointfinder_order_expiredate', true );
			?>
			<!-- User Package -->
				<tr>
					<th>
						<label for="membership_user_package_head"><?php esc_html_e('Package','pointfindert2d'); ?></label>
					</th>
					<td>
						<?php echo get_user_meta( $user->ID, 'membership_user_package', true ); echo '/'; echo $membership_package_id;?>
					</td>
				</tr>
			<!-- /User Package -->

			<!-- User Limit -->
				<tr>
					<th>
						<label for="membership_user_item_limit_head"><?php esc_html_e('Item Limit','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_item_limit"><input type="text" name="membership_user_item_limit" id="membership_user_item_limit" value="<?php 
						echo get_user_meta( $user->ID, 'membership_user_item_limit', true );?>" class="regular-text"><br/><small>
						<?php esc_html_e("You can change with numeric values. Write -1 for unlimited items.",'pointfindert2d');?></small></label>
					</td>
				</tr>
			<!-- /User Limit -->

			<!-- User Featured Limit -->
				<tr>
					<th>
						<label for="membership_user_featureditem_limit_head"><?php esc_html_e('Featured Limit','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_featureditem_limit"><input type="text" name="membership_user_featureditem_limit" id="membership_user_featureditem_limit" value="<?php 
						echo get_user_meta( $user->ID, 'membership_user_featureditem_limit', true );?>" class="regular-text"><br/><small>
						<?php esc_html_e("You can change with numeric values.",'pointfindert2d');?></small></label>
					</td>
				</tr>
			<!-- /User Featured Limit -->


			<!-- User Image Limit -->
				<tr>
					<th>
						<label for="membership_user_image_limit_head"><?php esc_html_e('Image Limit','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_image_limit"><input type="text" name="membership_user_image_limit" id="membership_user_image_limit" value="<?php 
						echo get_user_meta( $user->ID, 'membership_user_image_limit', true );?>" class="regular-text"><br/><small>
						<?php esc_html_e("You can change with numeric values.",'pointfindert2d');?></small></label>
					</td>
				</tr>
			<!-- /User Image Limit -->

			<?php if(!empty($membership_user_expiredate)){?>
			<!-- User Expire Date -->
				<tr>
					<th>
						<label for="membership_user_expiredate_head"><?php esc_html_e('Expire Date','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_expiredate"><input type="text" name="membership_user_expiredate" id="membership_user_expiredate" value="<?php 
						echo PFU_DateformatS($membership_user_expiredate,1);
						?>" class="regular-text"><br/><small>
						<?php _e("Please only use this format: <strong>day-month-year(yyyy) hour:minute:second</strong> (All msut be numeric) - New date must be bigger than today!",'pointfindert2d');?></small></label>
					</td>
				</tr>
			<!-- /User Expire Date -->
			<?php }else{ ?>
			<!-- User Expire Date -->
				<tr>
					<th>
						<label for="membership_user_expiredate_head"><?php esc_html_e('Expire Date','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_expiredate"><p><?php _e("This user's order record looks like REMOVED.",'pointfindert2d');?></p></label>
					</td>
				</tr>
			<!-- /User Expire Date -->


			<!-- New Package Create -->
				<tr>
					<th>
						<label for="membership_user_newplan_head"><?php esc_html_e('Expire Date','pointfindert2d'); ?></label>
					</th>
					<td>
						<label for="membership_user_newplan">
						<select name="membership_user_newplan" id="membership_user_newplan">
						<?php
							$membership_query = new WP_Query(array('post_type' => 'pfmembershippacks','posts_per_page' => -1,'order_by'=>'ID','order'=>'ASC'));
							if ( $membership_query->have_posts() ) {
								echo '<option value="">'.__("Please Select A Plan","pointfindert2d").'</option>';
								while ( $membership_query->have_posts() ) {
									$membership_query->the_post();

									$post_id = get_the_id();

									$packageinfo = pointfinder_membership_package_details_get($post_id);

									if ($packageinfo['webbupointfinder_mp_showhide'] == 1) {
										echo '<option value="'.$packageinfo['webbupointfinder_mp_packageid'].'">'.$packageinfo['webbupointfinder_mp_title'].'('.$packageinfo['packageinfo_priceoutput_text'].')</option>';
									}
								}
							}
						?>
						</select>
						<br/><small>
						<?php _e("You have administrator rights. So this package price will not charged.",'pointfindert2d');?></small>
						</label>
					</td>
				</tr>
			<!-- /New Package Create -->
			<?php } ?>
		<?php }} ?>

	</table>
	<?php
}
add_action('show_user_profile', 'pf_custom_user_profile_fields');
add_action('edit_user_profile', 'pf_custom_user_profile_fields');

function pf_update_extra_profile_fields($user_id) {
	 
	 $setup3_pointposttype_pt6_status = PFSAIssetControl('setup3_pointposttype_pt6_status','','1');
     
     if ( current_user_can('edit_user',$user_id) && $setup3_pointposttype_pt6_status == 1 ){
         update_user_meta($user_id, 'user_agent_link', $_POST['user_agent_link']);
     }

     $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
     if ($setup4_membersettings_paymentsystem == 2) {
     	if ($_POST['membership_user_item_limit'] != '') {
     		update_user_meta($user_id, 'membership_user_item_limit', $_POST['membership_user_item_limit']);
     	}
     	if ($_POST['membership_user_featureditem_limit'] != '') {
     		update_user_meta($user_id, 'membership_user_featureditem_limit', $_POST['membership_user_featureditem_limit']);
     	}
     	if ($_POST['membership_user_image_limit'] != '') {
     		update_user_meta($user_id, 'membership_user_image_limit', $_POST['membership_user_image_limit']);
     	}
     	
     	if (isset($_POST['membership_user_expiredate'])) {
     		$new_expire_date = date_parse_from_format('d-m-Y H:i:s', $_POST['membership_user_expiredate']);

     		if (empty($new_expire_date['error_count'])) {
     			$new_expire_date_output = mktime(
				        $new_expire_date['hour'], 
				        $new_expire_date['minute'], 
				        $new_expire_date['second'], 
				        $new_expire_date['month'], 
				        $new_expire_date['day'], 
				        $new_expire_date['year']
				);
				if ($new_expire_date_output > strtotime("now")) {
					$order_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
					update_post_meta( $order_id, 'pointfinder_order_expiredate', $new_expire_date_output);
				}
				
     		}
     	}

     	if (isset($_POST['membership_user_newplan'])) {

			$vars['selectedpackageid'] = $_POST['membership_user_newplan'];
			$packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
			
			/*Create Order Record*/
			$order_post_id = pointfinder_membership_create_order(
			  array(
			    'user_id' => $user_id,
			    'packageinfo' => $packageinfo,
			    'autoexpire_create' => 1
			  )
			);

			global $wpdb;
			$wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

			/*Create User Limits*/
			update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
			update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
			update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
			update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
			update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
			update_user_meta( $user_id, 'membership_user_trialperiod', 0);
			update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
			update_post_meta( $order_post_id, 'pointfinder_order_expiredate', strtotime("+".$packageinfo['webbupointfinder_mp_billing_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."") );

     	}
     }


 }

add_action( 'edit_user_profile_update', 'pf_update_extra_profile_fields' );
add_action( 'personal_options_update', 'pf_update_extra_profile_fields' );
?>