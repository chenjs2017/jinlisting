<?php
/**********************************************************************************************************************************
*
* Change Post Submitbox in default wp.
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/



/**
*Start: Change order record to new user if exist
**/
function pointfinder_correctowneroforder($post_ID, $post_after, $post_before){

	if ($post_after->post_author != $post_before->post_author) {

		global $wpdb;
		$order_post_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %d", 
			'pointfinder_order_itemid',
			$post_ID
		) );

		$post_images = get_post_meta( $post_ID, 'webbupointfinder_item_images', false );
  	

	    if (is_array($post_images)) {
	    	foreach ($post_images as $post_image) {
	    		$results = $wpdb->update($wpdb->posts,array('post_author'=>$post_after->post_author),array('ID'=>$post_image));
	    	}
	    }

	    $post_thumb = get_post_thumbnail_id( $post_ID );
	    $results = $wpdb->update($wpdb->posts,array('post_author'=>$post_after->post_author),array('ID'=>$post_thumb));

		if (!empty($order_post_id)) {
	
			$order_post_owner = $wpdb->get_var( $wpdb->prepare(
				"SELECT post_author FROM $wpdb->posts WHERE ID = %d", 
				$order_post_id
			) );

			

			if ($order_post_owner != $post_after->post_author) {
				$results = $wpdb->update($wpdb->posts,array('post_author'=>$post_after->post_author),array('ID'=>$order_post_id));
				update_post_meta( $order_post_id , 'pointfinder_order_userid', $post_after->post_author );

				/* - Creating record for process system. */
				PFCreateProcessRecord(
					array( 
				        'user_id' => $new_post_author,
				        'item_post_id' => $post_ID,
						'processname' => esc_html__('Item post author changed by ADMIN','pointfindert2d')
				    )
				);

			}
		}
		
		
	}
}
add_action( 'post_updated', 'pointfinder_correctowneroforder',10, 3 );
/**
*End: Change order record to new user if exist
**/

/**
*Start: Change, Status change selection
**/

	function pointfinder_add_altered_submit_box($post_type, $post = '') {
		if (!empty($post)) {
			$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
			$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

			if ($post_type == $setup3_pointposttype_pt1) {
				global $wpdb;
				$post_author = $wpdb->get_var( $wpdb->prepare(
					"SELECT post_author FROM $wpdb->posts WHERE ID = %d", 
					$post->ID
				) );
				if (!user_can($post_author,'activate_plugins')) {
					remove_meta_box( 'submitdiv', $setup3_pointposttype_pt1, 'side' );

					if ($setup4_membersettings_paymentsystem == 2) {
						add_meta_box(
							'pointfinder_orders_status',
							esc_html__( 'User Plan Status', 'pointfindert2d' ),
							'pointfinder_morders_meta_box_orderstatus',
							$setup3_pointposttype_pt1, 
							'side',
							'high'
						);
					} else {
						add_meta_box(
							'pointfinder_orders_status',
							esc_html__( 'Order Status', 'pointfindert2d' ),
							'pointfinder_orders_meta_box_orderstatus',
							$setup3_pointposttype_pt1, 
							'side',
							'high'
						);
					}
					
					
					add_meta_box(
						'submitdiv',
						esc_html__( 'Status Actions','pointfindert2d'),
						'PF_Modified_post_submit_meta_box',
						$setup3_pointposttype_pt1, 
						'side', 
						'high'
					);
				}
				
			}
		}
	}
	add_action( 'add_meta_boxes' , 'pointfinder_add_altered_submit_box', 101, 2 );
/**
*End: Change, Status change selection
**/



/**
*Start : Plan Info Content (For membership)
**/


	function pointfinder_morders_meta_box_orderstatus( $post ) {
		$user_id = $post->post_author;
		$userdata = get_user_by('id',$user_id);
		$membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
		$membership_user_package = get_user_meta( $user_id, 'membership_user_package', true );

		$membership_user_activeorder = get_user_meta( $user_id, 'membership_user_activeorder', true );
		$expire_date = get_post_meta( $membership_user_activeorder, 'pointfinder_order_expiredate', true );
		$ex_text = '';
		if(!empty($expire_date)){
			if(pf_membership_expire_check($expire_date) == false){
			    $prderinfo_statusorder = '<span class="pforders-orderdetails-lblcompleted">'.esc_html__('ACTIVE UNTIL: ','pointfindert2d').PFU_DateformatS($expire_date).'</span>';
			}else{
				$prderinfo_statusorder = '<span class="pforders-orderdetails-lblcancel">'.esc_html__('EXPIRED','pointfindert2d').'</span>';
			}
		}else{
			$ex_text = '<br/>'.__("Probably user's order removed by admin. You should rollback this action or create new membership plan for this user.","pointfindert2d").
			'<br/><br/>'.esc_html__("You can create new plan by using user's profile page.",'pointfindert2d').''.
			'<br/><br/><a href="'.get_edit_user_link($user_id).'" class="button button-primary button-normal">'.esc_html__("CREATE NEW PLAN",'pointfindert2d').'</a>';
		}

		echo '<ul class="pforders-orderdetails-ul">';
		if (empty($prderinfo_statusorder)) {
			echo '<li>';
			esc_html_e( 'PLAN STATUS : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext">'.esc_html__('This user has no plan.','pointfindert2d').'<br/>'.$ex_text.'</div>';
			echo '</li> ';
		}else{

			echo '<li>';
			esc_html_e( 'PLAN INFO : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext">'.$membership_user_package.'</div>';
			echo '</li> ';


			echo '<li>';
			esc_html_e( 'PLAN STATUS : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext">'.$prderinfo_statusorder.'</div>';
			echo '</li> ';

			
			echo '<li>';
			esc_html_e( 'USER : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_user_link($user_id).'" target="_blank" title="'.esc_html__('Click for user details','pointfindert2d').'">'.$user_id.' - '.$userdata->nickname.'</a></div>';
			echo '</li> ';
		}
		echo '</ul>';
		
	}
/**
*End : Plan Info Content 
**/



/**
*Start : Order Info Content
**/


	function pointfinder_orders_meta_box_orderstatus( $post ) {

		global $wpdb;
		$order_post_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %d", 
			'pointfinder_order_itemid',
			$post->ID
		) );
		$prderinfo_itemid = esc_attr(get_post_meta( $order_post_id , 'pointfinder_order_itemid', true ));
		$prderinfo_user = esc_attr(get_post_meta( $order_post_id , 'pointfinder_order_userid', true ));
		$order_post_status = get_post_status($order_post_id);

		if($order_post_status == 'completed'){
		    $prderinfo_statusorder = '<span class="pforders-orderdetails-lblcompleted">'.esc_html__('PAYMENT COMPLETED','pointfindert2d').'</span>';
		}elseif($order_post_status == 'pendingpayment'){
			$prderinfo_statusorder = '<span class="pforders-orderdetails-lblpending">'.esc_html__('PENDING PAYMENT','pointfindert2d').'</span>';
		}elseif($order_post_status == 'pfcancelled'){
			$prderinfo_statusorder = '<span class="pforders-orderdetails-lblcancel">'.esc_html__('CANCELLED','pointfindert2d').'</span>';
		}elseif($order_post_status == 'pfsuspended'){
			$prderinfo_statusorder = '<span class="pforders-orderdetails-lblpending">'.esc_html__('SUSPENDED','pointfindert2d').'</span>';
		}

		echo '<ul class="pforders-orderdetails-ul">';
		if (empty($prderinfo_statusorder)) {
			echo '<li>';
			esc_html_e( 'STATUS : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext">
			'.esc_html__('This item has no order info. If you claimed this item to another user please click to create order button for create a new order for this user.','pointfindert2d').'<br/>
			<a class="button button-primary button-large" id="createorder">'.esc_html__('CREATE ORDER','pointfindert2d').'</a>
			</div>';
			echo '</li> ';
		}else{
			echo '<li>';
			esc_html_e( 'ORDER ID : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($order_post_id).'" target="_blank" title="'.esc_html__('Click for order details','pointfindert2d').'"><strong>'.get_the_title($order_post_id).'</strong></a></div>';
			//echo edit_post_link( get_the_title($order_post_id), '<div class="pforders-orderdetails-lbltext">', '</div>', $order_post_id );
			echo '</li> ';

			echo '<li>';
			esc_html_e( 'ORDER STATUS : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext">'.$prderinfo_statusorder.'</div>';
			echo '</li> ';

			$userdata = get_user_by('id',$prderinfo_user);
			echo '<li>';
			esc_html_e( 'USER : ', 'pointfindert2d' );
			echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_user_link($prderinfo_user).'" target="_blank" title="'.esc_html__('Click for user details','pointfindert2d').'">'.$prderinfo_user.' - '.$userdata->nickname.'</a></div>';
			echo '</li> ';
		}
		echo '</ul>';

		if (empty($prderinfo_statusorder)) {
			echo '
				<script>
				(function($) {
 				 "use strict";
 				 $("#createorder").click(function(){
					$("#createorder").text("'.esc_html__('Please wait...','pointfindert2d').'");
					$("#createorder").attr("disabled", true);';
			echo "
					$.ajax({
			            type: 'POST',
			            dataType: 'json',
			            url: '".get_template_directory_uri()."/admin/core/pfajaxhandler.php',
			            data: { 
			                'action': 'pfget_createorder',
			                'newauthor': ".$post->post_author.",
			                'itemid': ".$post->ID.",
			                'security': '".wp_create_nonce('pfget_createorder')."'
			            },
			            success:function(data){

			            	var obj = [];
							$.each(data, function(index, element) {
								obj[index] = element;
							});

							if(obj.process == true){
								window.location.reload();
							}

			            },
			            error: function (request, status, error) {},
			            complete: function(){
								$('#createorder').text('".esc_html__('Refreshing...','pointfindert2d')."');
			            },
			        });

					return false;
 				 });


				})(jQuery);
				</script>
			";
		}
		
	}
/**
*End : Order Info Content 
**/





/**
*Start : Custom Publish Box
**/
	function PF_Modified_post_submit_meta_box($post, $args = array() ) {
		global $action;

		$post_type = $post->post_type;
		$post_type_object = get_post_type_object($post_type);
		$can_publish = current_user_can($post_type_object->cap->publish_posts);
	?>
	<div class="submitbox pointfinder" id="submitpost">

		<div id="minor-publishing">

		
			<div style="display:none;">
			<?php submit_button( esc_html__( 'Save' ,'pointfindert2d'), 'button', 'save' ); ?>
			</div>


			<div class="clear"></div>
		</div><!-- #minor-publishing-actions -->

		<div id="misc-publishing-actions">

			<div class="misc-pub-section misc-pub-post-status"><label for="post_status"><?php esc_html_e('Status:','pointfindert2d') ?></label>
				<span id="post-status-display">
				<?php
				switch ( $post->post_status ) {
					case 'publish':
						esc_html_e('Published','pointfindert2d');
						break;
					case 'pendingpayment':
						esc_html_e('Pending Payment','pointfindert2d');
						break;
					case 'pendingapproval':
						esc_html_e('Pending Approval','pointfindert2d');
						break;
					case 'rejected':
						esc_html_e('Rejected','pointfindert2d');
						break;
				}
				?>
				</span>
				<?php if ( 'publish' == $post->post_status || 'pendingpayment' == $post->post_status || 'pendingapproval' == $post->post_status || $can_publish ) { ?>
				<a href="#post_status" <?php if ( 'private' == $post->post_status ) { ?>style="display:none;" <?php } ?>class="edit-post-status hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit','pointfindert2d' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit status' ,'pointfindert2d'); ?></span></a>

				<div id="post-status-select" class="hide-if-js">
					<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('pendingapproval' == $post->post_status ) ? 'pendingapproval' : $post->post_status); ?>" />
					<select name='post_status' id='post_status'>

					<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php esc_html_e('Published','pointfindert2d') ?></option>
					<option<?php selected( $post->post_status, 'pendingpayment' ); ?> value='pendingpayment'><?php esc_html_e('Pending Payment','pointfindert2d') ?></option>
					<option<?php selected( $post->post_status, 'pendingapproval' ); ?> value='pendingapproval'><?php esc_html_e('Pending Approval','pointfindert2d') ?></option>
					<option<?php selected( $post->post_status, 'rejected' ); ?> value='rejected'><?php esc_html_e('Rejected','pointfindert2d') ?></option>

					</select>
					 <a href="#post_status" class="save-post-status hide-if-no-js button"><?php esc_html_e('OK','pointfindert2d'); ?></a>
					 <a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel"><?php esc_html_e('Cancel','pointfindert2d'); ?></a>
				</div>

				<?php } ?>
			</div><!-- .misc-pub-section -->

			<div class="misc-pub-section misc-pub-visibility" id="visibility">
				<?php esc_html_e('Visibility:','pointfindert2d'); ?> <span id="post-visibility-display"><?php

				if ( 'private' == $post->post_status ) {
					$post->post_password = '';
					$visibility = 'private';
					$visibility_trans = esc_html__('Private','pointfindert2d');
				} elseif ( !empty( $post->post_password ) ) {
					$visibility = 'password';
					$visibility_trans = esc_html__('Password protected','pointfindert2d');
				} elseif ( $post_type == 'post' && is_sticky( $post->ID ) ) {
					$visibility = 'public';
					$visibility_trans = esc_html__('Public, Sticky','pointfindert2d');
				} else {
					$visibility = 'public';
					$visibility_trans = esc_html__('Public','pointfindert2d');
				}

				echo esc_html( $visibility_trans ); ?></span>
				<?php if ( $can_publish ) { ?>
				<a href="#visibility" class="edit-visibility hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit' ,'pointfindert2d'); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit visibility' ,'pointfindert2d'); ?></span></a>

				<div id="post-visibility-select" class="hide-if-js">
					<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php echo esc_attr($post->post_password); ?>" />
					<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php echo esc_attr( $visibility ); ?>" />
					<input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php checked( $visibility, 'public' ); ?> /> <label for="visibility-radio-public" class="selectit"><?php esc_html_e('Public','pointfindert2d'); ?></label><br />
					<input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php checked( $visibility, 'password' ); ?> /> <label for="visibility-radio-password" class="selectit"><?php esc_html_e('Password protected','pointfindert2d'); ?></label><br />
					<span id="password-span"><label for="post_password"><?php esc_html_e('Password:','pointfindert2d'); ?></label> <input type="text" name="post_password" id="post_password" value="<?php echo esc_attr($post->post_password); ?>"  maxlength="20" /><br /></span>
					<input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked( $visibility, 'private' ); ?> /> <label for="visibility-radio-private" class="selectit"><?php esc_html_e('Private','pointfindert2d'); ?></label><br />

					<p>
					 <a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php esc_html_e('OK','pointfindert2d'); ?></a>
					 <a href="#visibility" class="cancel-post-visibility hide-if-no-js button-cancel"><?php esc_html_e('Cancel','pointfindert2d'); ?></a>
					</p>
				</div>
				<?php } ?>

			</div><!-- .misc-pub-section -->

			<?php
			/* translators: Publish box date format, see http://php.net/date */
			$datef = 'M j, Y @ G:i';
			if ( 0 != $post->ID ) {
				if ( 'future' == $post->post_status ) { // scheduled for publishing at a future date
					$stamp = esc_attr__('Scheduled for: <b>%1$s</b>','pointfindert2d');
				} else if ( 'publish' == $post->post_status || 'private' == $post->post_status ) { // already published
					$stamp = esc_attr__('Published on: <b>%1$s</b>','pointfindert2d');
				} else if ( '0000-00-00 00:00:00' == $post->post_date_gmt ) { // draft, 1 or more saves, no date specified
					$stamp = esc_attr__('Publish <b>immediately</b>','pointfindert2d');
				} else if ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
					$stamp = esc_attr__('Schedule for: <b>%1$s</b>','pointfindert2d');
				} else { // draft, 1 or more saves, date specified
					$stamp = esc_attr__('Publish on: <b>%1$s</b>','pointfindert2d');
				}
				$date = date_i18n( $datef, strtotime( $post->post_date ) );
			} else { // draft (no saves, and thus no date specified)
				$stamp = esc_attr__('Publish <b>immediately</b>','pointfindert2d');
				$date = date_i18n( $datef, strtotime( current_time('mysql') ) );
			}

			if ( ! empty( $args['args']['revisions_count'] ) ){
				$revisions_to_keep = wp_revisions_to_keep( $post );
			?>


			<div class="misc-pub-section misc-pub-revisions">
				<?php
					if ( $revisions_to_keep > 0 && $revisions_to_keep <= $args['args']['revisions_count'] ) {
						echo '<span title="' . esc_attr( sprintf( esc_html__( 'Your site is configured to keep only the last %s revisions.','pointfindert2d'),
							number_format_i18n( $revisions_to_keep ) ) ) . '">';
						printf( esc_html__( 'Revisions: %s','pointfindert2d' ), '<b>' . number_format_i18n( $args['args']['revisions_count'] ) . '+</b>' ,'pointfindert2d');
						echo '</span>';
					} else {
						printf( esc_html__( 'Revisions: %s','pointfindert2d' ), '<b>' . number_format_i18n( $args['args']['revisions_count'] ) . '</b>' ,'pointfindert2d');
					}
				?>
				<a class="hide-if-no-js" href="<?php echo esc_url( get_edit_post_link( $args['args']['revision_id'] ) ); ?>"><span aria-hidden="true"><?php esc_html__( 'Browse', 'revisions' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Browse revisions' ,'pointfindert2d'); ?></span></a>
			</div>
			<?php };

			if ( $can_publish){ // Contributors don't get to choose the date of publish ?>
			<div class="misc-pub-section curtime misc-pub-curtime" style="display:none;">
				<span id="timestamp">
				<?php printf($stamp, $date); ?></span>
				<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit' ,'pointfindert2d'); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit date and time' ,'pointfindert2d'); ?></span></a>
				<div id="timestampdiv" class="hide-if-js"><?php touch_time(($action == 'edit'), 1); ?></div>
			</div><?php // /misc-pub-section ?>
			<?php }; ?>

			<?php
			/**
			 * Fires after the post time/date setting in the Publish meta box.
			 *
			 * @since 2.9.0
			 */
			do_action( 'post_submitbox_misc_actions' );
			?>
		</div>


	</div>
		<div class="clear"></div>
	

		<div id="major-publishing-actions">
			<?php
			/**
			 * Fires at the beginning of the publishing actions section of the Publish meta box.
			 *
			 * @since 2.7.0
			 */
			do_action( 'post_submitbox_start' );
			?>
			<div id="delete-action">
			<?php
			if ( current_user_can( "delete_post", $post->ID ) ) {
				if ( !EMPTY_TRASH_DAYS )
					$delete_text = esc_html__('Delete Permanently','pointfindert2d');
				else
					$delete_text = esc_html__('Move to Trash','pointfindert2d');
				?>
			<a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
			} ?>
		</div>

		<div id="publishing-action">
			<span class="spinner"></span>
			
			<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_html_e('Update','pointfindert2d') ?>" />
			<input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php esc_html_e('Update','pointfindert2d') ?>" />
			
		</div>
		<div class="clear"></div>
	
	</div>

	<?php
	}
/**
*End : Custom Publish Box
**/




/**
*Start : Item Reviewer Messages
**/
	if(PFSAIssetControl('setup4_membersettings_loginregister','','1') == 1 && PFSAIssetControl('setup4_membersettings_frontend','','1') == 1 && PFSAIssetControl('setup4_submitpage_messagetorev','','1') == 1){
		
		function pf_reviewer_message_metabox() {
			$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
			$screens = array( $setup3_pointposttype_pt1 );

			foreach ( $screens as $screen ) {

				add_meta_box(
					'pf_reviewer_message_metabox_id',
					esc_html__( 'Reviewer Message', 'pointfindert2d' ),
					'pf_reviewer_message_metabox_cb',
					$screen
				);
			}
		}
		add_action( 'add_meta_boxes', 'pf_reviewer_message_metabox' );


		
		function pf_reviewer_message_metabox_cb( $post ) {

			
			$old_mesrev = get_post_meta($post->ID, 'webbupointfinder_items_mesrev', true);
			$old_mesrev = json_decode($old_mesrev,true);
			if (!empty($old_mesrev)) {
				$old_mesrev = array_reverse($old_mesrev);
				foreach ($old_mesrev as $old_mesrev_single) {

					if (!empty($old_mesrev_single['message'])) {
						echo '<div class="pfdateshow">';
						echo esc_attr($old_mesrev_single['date']);
						echo '</div><div class="pfmsgshow">';
						echo wp_kses_post($old_mesrev_single['message']);
						echo '</div>';
					}
					
				}
				echo '<small>'.esc_html__("These messages has been sent by This Item Owner","pointfindert2d").'</small>';

			}else{
				echo '<small>'.esc_html__("There is no message yet.","pointfindert2d").'</small>';
			}

			
		}
	}
/**
*End : Item Reviewer Messages
**/


/*
 * ========================================================================
 * Change Author Box
 * ========================================================================
 */
 	if(current_user_can('activate_plugins')){
		foreach( array( 'edit.php', 'post.php' ) as $hook )
		add_action( "load-$hook", 'wpse39084_replace_post_meta_author' );       
	
		/* Show Subscribers in post author dropdowns - edit and quickEdit */
		function wpse39084_replace_post_meta_author()
		{
			global $typenow;

			$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
			if( $setup3_pointposttype_pt1 != $typenow )
				return;
		
			add_action( 'admin_head', 'pointfinder_wpse50827_author_metabox_remove' );
			add_action( 'post_submitbox_misc_actions', 'pointfinder_wpse50827_author_metabox_move' );
		}
		
		/* Remove Author meta box from post editing */
		function pointfinder_wpse50827_author_metabox_remove()
		{
			remove_meta_box( 'authordiv', 'post', 'normal' );
		}
		
		/* Move Author meta box inside Publish Actions meta box */
		function pointfinder_wpse50827_author_metabox_move()
		{
			global $post;
			
			
			echo '<div class="pointfinder-current-auth">'.esc_html__("Current Author:","pointfindert2d").' '.get_the_author_meta('login',$post->post_author).'</div>';
			echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">'.esc_html__('Change Author: ','pointfindert2d').' ';
			echo '<input type="hidden" name="post_author_override" id="post_author_override" />';
			echo '<br/><small>'.esc_html__('Important: Author change will be effect order records. Please be carefull.','pointfindert2d').'</small>';
			echo '</div>';

		}
	}
/*
 * ========================================================================
 * Finished
 * ========================================================================
*/



?>