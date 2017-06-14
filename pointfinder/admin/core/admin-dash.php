<?php
/**********************************************************************************************************************************
*
* System Status Widget for PointFinder Theme
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (is_user_logged_in()) {
	if (current_user_can('activate_plugins')) {
		add_action( 'admin_enqueue_scripts', 'pf_dashboard_widget_scripts' );

		function pf_dashboard_widget_scripts() {
			$screen = get_current_screen();
			if ($screen->id == 'dashboard') {
				wp_register_style( 'dashboard-widget-style', get_template_directory_uri() . '/admin/core/css/dashboard-custom.css', false, '1.0.0' );
		        wp_enqueue_style( 'dashboard-widget-style' );
			}     
		}

		add_action( 'wp_dashboard_setup', 'pf_prefix_add_dashboard_widget' );

		function pf_prefix_add_dashboard_widget() {
		    wp_add_dashboard_widget( 'pfstatusofsystemwidget', esc_html__( 'PF SYSTEM STATUS', 'pointfindert2d' ), 'pf_status_of_system' );
		}


		function pf_status_of_system() {

			global $wpdb;
			$theme = wp_get_theme();

			
			echo '<div class="pfawidget">';
			echo '<div class="pfawidget-body">';
		 	echo '<div class="pfaflash">'.esc_html__('You are using','pointfindert2d').'  <strong>Point Finder v'.$theme->version.'</div>';
		 	
		 	global $current_user;
        	$user_id = $current_user->ID;

		 	$user_update_not = get_user_meta($user_id, 'pointfinder_afterinstall_admin_notice',true );
		 	$user_update_not2 = get_user_meta($user_id, 'pointfinder_afterv16_admin_notice',true );
		 	if (!empty($user_update_not)) {		 	
		 		//echo '<div class="updatenotpf1"><a href="?pointfinderafterinstall_nag_enable=0"><strong>View Point Finder Help Doc Information</strong></a></div>';
		 	}
		 	if (!empty($user_update_not2)) {		 	
		 		//echo '<div class="updatenotpf1"><a href="?pointfinderafterv16_nag_enable=0"><strong>View v1.6 Update Notification</strong></a></div>';
		 	}

		 	echo '<div class="accordion">';

			if(PFSAIssetControl('setup4_membersettings_loginregister','','1') == 1){


				$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
				$pf_published_items = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->posts where post_type='%s' and post_status='%s'",$setup3_pointposttype_pt1,'publish'));

				if(PFSAIssetControl('setup4_membersettings_frontend','','1') == 1){
					
					$pf_pendingapproval_items = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->posts where post_type='%s' and post_status='%s'",$setup3_pointposttype_pt1,'pendingapproval'));
					$pf_pendingpayment_items = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->posts where post_type='%s' and post_status='%s'",$setup3_pointposttype_pt1,'pendingpayment'));

					echo '
					<div class="accordion-header"><h2>'.esc_html__('MAIN SYSTEM STATUS','pointfindert2d').'</h2></div>
					<div class="accordion-body">
						<div class="accordion-mainit">
							<div class="accordion-status-text"><a href="'.admin_url("edit.php?post_status=publish&post_type=$setup3_pointposttype_pt1").'">'.$pf_published_items.'</a></div>
							'.esc_html__('Published','pointfindert2d').'         
						</div>
						<div class="accordion-mainit">
							<div class="accordion-status-text"><a href="'.admin_url("edit.php?post_status=pendingapproval&post_type=$setup3_pointposttype_pt1").'">'.$pf_pendingapproval_items.'</a></div>
							'.esc_html__('Pending Approval','pointfindert2d').'          
						</div>
						<div class="accordion-mainit">
							<div class="accordion-status-text"><a href="'.admin_url("edit.php?post_status=pendingpayment&post_type=$setup3_pointposttype_pt1").'">'.$pf_pendingpayment_items.'</a></div>
							'.esc_html__('Pending Payment','pointfindert2d').'
						</div>
					</div>
					';

				}else{
					echo '
					<div class="accordion-header"><h2>'.esc_html__('MAIN SYSTEM STATUS','pointfindert2d').'</h2></div>
					<div class="accordion-body">
						<div class="accordion-mainit">
							<div class="accordion-status-text">'.$pf_published_items.'</div>
							'.esc_html__('Published','pointfindert2d').'         
						</div>
					</div>
					';

				}
			}


			if (PFREVSIssetControl('setup11_reviewsystem_check','','0') == 1) {
				$pf_published_reviews = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->posts where post_type='%s' and post_status='%s'",'pointfinderreviews','publish'));
				$pf_pendingapproval_reviews = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->posts where post_type='%s' and post_status='%s'",'pointfinderreviews','pendingapproval'));
				$pf_pendingpayment_reviews = $wpdb->get_var($wpdb->prepare("select count(*) from $wpdb->posts where post_type='%s' and post_status='%s'",'pointfinderreviews','pendingpayment'));
				
				echo '
				<div class="accordion-header">
					<h2>'.esc_html__('REVIEW SYSTEM STATUS','pointfindert2d').'</h2>
				</div>
				<div class="accordion-body">
					<div class="accordion-mainit">
						<div class="accordion-status-text">'.$pf_published_reviews.'</div>
						'.esc_html__('Published','pointfindert2d').'        
					</div>
					<div class="accordion-mainit">
						<div class="accordion-status-text">'.$pf_pendingapproval_reviews.'</div>
						'.esc_html__('Pending Approval','pointfindert2d').'          
					</div>
					<div class="accordion-mainit">
						<div class="accordion-status-text">'.$pf_pendingpayment_reviews.'</div>
						'.esc_html__('Pending Check','pointfindert2d').'
					</div>
				</div>
				';
			}

			echo '</div></div></div>';
		}
	}

	
}