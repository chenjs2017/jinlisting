<?php
/**********************************************************************************************************************************
*
* Reviews post type detail pages.
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

/**
*Enqueue Styles
**/
function pointfinder_reviews_styles(){
	$screen = get_current_screen();
	if ($screen->post_type == 'pointfinderreviews') {
		wp_register_style('metabox-custom.', get_template_directory_uri() . '/admin/core/css/metabox-custom.css', array(), '1.0', 'all');
		wp_enqueue_style('metabox-custom.');
	}
}
add_action('admin_enqueue_scripts','pointfinder_reviews_styles' );

/**
*Start : Add Metaboxes
**/
	function pointfinder_reviews_add_meta_box($post_type) {
		if ($post_type == 'pointfinderreviews') {
			add_meta_box(
				'submitdiv',
				esc_html__( 'Status Actions','pointfindert2d'),
				'PF_Modified_review_submit_meta_box',
				'pointfinderreviews', 
				'side', 
				'high'
			);
			add_meta_box(
				'pointfinder_reviews_info',
				esc_html__( 'REVIEW INFO', 'pointfindert2d' ),
				'pointfinder_reviews_meta_box_revinfo',
				'pointfinderreviews',
				'side',
				'high'
			);

			add_meta_box(
				'pointfinder_reviews_details',
				esc_html__( 'REVIEW DETAILS', 'pointfindert2d' ),
				'pointfinder_reviews_meta_box_details',
				'pointfinderreviews',
				'side',
				'core'
			);

		}

		
	}
	add_action( 'add_meta_boxes', 'pointfinder_reviews_add_meta_box', 10,1);
/**
*End : Add Metaboxes
**/



/**
*Start : Review Info Content
**/
	function pointfinder_reviews_meta_box_revinfo( $post ) {
		//get_edit_user_link($prderinfo_user)
		$itemid = esc_attr(get_post_meta( $post->ID, 'webbupointfinder_review_itemid', true ));
		$email = esc_attr(get_post_meta( $post->ID, 'webbupointfinder_review_email', true ));


		$output = '<ul>';
			$output .= '<li><span class="rev-cr-title">'.esc_html__('Item','pointfindert2d').' : </span><a href="'.get_edit_post_link($itemid).'" target="_blank">'.get_the_title($itemid).'('.$itemid.')</a></li>';
			
			if (PFcheck_postmeta_exist('webbupointfinder_review_userid',$post->ID)) {
				$userid = esc_attr(get_post_meta( $post->ID, 'webbupointfinder_review_userid', true ));
				$output .= '<li><span class="rev-cr-title">'.esc_html__('Reviewer','pointfindert2d').' : </span><a href="'.get_edit_user_link($userid).'" target="_blank">'.get_the_title($post->ID).'</a></li>';
			}else{
				$output .= '<li><span class="rev-cr-title">'.esc_html__('Reviewer','pointfindert2d').' : </span>'.get_the_title($post->ID).'</li>';
			}
			
			$output .= '<li><span class="rev-cr-title">'.esc_html__('Email','pointfindert2d').' : </span>'.$email.'</li>';

			$flagstatus = (PFcheck_postmeta_exist('webbupointfinder_review_flag',$post->ID))? get_post_meta( $post->ID, 'webbupointfinder_review_flag', true ) : '' ;
			$output .=  ($flagstatus == 1)? '<li style="background:red;padding:8px 10px;"><a href="'.admin_url('post.php?post='.$post->ID.'&action=edit&flag=0').'" style="color:white; font-weight:bold;">'.esc_html__('This review flagged for check. Click here for remove flag.','pointfindert2d').'</a></li>' : '';

		$output .= '</ul>';
		echo $output;

	}
/**
*End : Review Info Content
**/




/**
*Start : Review Details
**/
	function pointfinder_reviews_meta_box_details( $post ) {
		echo '<div class="pf-single-rev">'.esc_html__('Review Total','pointfindert2d').' : '.pfcalculate_single_review($post->ID).'</div>';
		echo pfget_reviews_peritem($post->ID);

	}
/**
*End : Review Details
**/





/**
*Start : Custom Publish Box
**/
	function PF_Modified_review_submit_meta_box($post, $args = array() ) {
		global $action;

		$post_type = $post->post_type;
		$post_type_object = get_post_type_object($post_type);
		$can_publish = current_user_can($post_type_object->cap->publish_posts);
	?>
	<div class="submitbox" id="submitpost">

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
					case 'pendingapproval':
						esc_html_e('Pending Approval','pointfindert2d');
						break;
				}
				?>
				</span>
				<?php if ( 'publish' == $post->post_status || 'pendingapproval' == $post->post_status || $can_publish ) { ?>
				<a href="#post_status" <?php if ( 'private' == $post->post_status ) { ?>style="display:none;" <?php } ?>class="edit-post-status hide-if-no-js"><span aria-hidden="true"><?php esc_html_e( 'Edit','pointfindert2d' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit status' ,'pointfindert2d'); ?></span></a>

				<div id="post-status-select" class="hide-if-js">
					<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('pendingapproval' == $post->post_status ) ? 'pendingapproval' : $post->post_status); ?>" />
					<select name='post_status' id='post_status'>

					<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php esc_html_e('Published','pointfindert2d') ?></option>
					<option<?php selected( $post->post_status, 'pendingapproval' ); ?> value='pendingapproval'><?php esc_html_e('Pending Approval','pointfindert2d') ?></option>

					</select>
					 <a href="#post_status" class="save-post-status hide-if-no-js button"><?php esc_html_e('OK','pointfindert2d'); ?></a>
					 <a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel"><?php esc_html_e('Cancel','pointfindert2d'); ?></a>
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
				<a class="hide-if-no-js" href="<?php echo esc_url( get_edit_post_link( $args['args']['revision_id'] ) ); ?>"><span aria-hidden="true"><?php esc_html_e( 'Browse', 'revisions' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Browse revisions' ,'pointfindert2d'); ?></span></a>
			</div>
			<?php };

			if ( $can_publish ){ // Contributors don't get to choose the date of publish ?>
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


?>