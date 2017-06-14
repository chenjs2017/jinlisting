<?php
/**********************************************************************************************************************************
*
* Orders post type detail pages.
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

/**
*Enqueue Styles
**/
function pointfinder_invoices_styles(){
	$screen = get_current_screen();
	if ($screen->post_type == 'pointfinderinvoices') {
		wp_register_style('metabox-custom.', get_template_directory_uri() . '/admin/core/css/metabox-custom.css', array(), '1.0', 'all');
		wp_enqueue_style('metabox-custom.'); 
	}
}
add_action('admin_enqueue_scripts','pointfinder_invoices_styles' );

	/**
	*Start : Add Metaboxes
	**/
		function pointfinder_minvoices_add_meta_box($post_type) {
			if ($post_type == 'pointfinderinvoices') {
				
				add_meta_box(
					'pointfinder_invoices_info',
					esc_html__( 'INVOICE INFO', 'pointfindert2d' ),
					'pointfinder_minvoices_meta_box_orderinfo',
					'pointfinderinvoices',
					'side',
					'high'
				);

				add_meta_box(
					'pointfinder_invoices_process',
					esc_html__( 'INVOICE DETAIL', 'pointfindert2d' ),
					'pointfinder_minvoices_meta_box_orderprocess',
					'pointfinderinvoices',
					'normal',
					'core'
				);
			}

			
		}
		add_action( 'add_meta_boxes', 'pointfinder_minvoices_add_meta_box', 10,1);
	/**
	*End : Add Metaboxes
	**/

	/**
	*Start : Invoice Info Content
	**/
		function pointfinder_minvoices_meta_box_orderinfo( $post ) {

			$prderinfo_itemid = get_post_meta( $post->ID, 'pointfinder_invoice_packageid', true );
			$inv_prefix = PFASSIssetControl('setup_invoices_prefix','','PFI');
			$current_post_status = get_post_status();

			if($current_post_status == 'publish'){
			    $prderinfo_statusorder = '<span class="pforders-orderdetails-lblcompleted">'.esc_html__('PUBLISH','pointfindert2d').'</span>';
			}elseif($current_post_status == 'pendingpayment'){
				$prderinfo_statusorder = '<span class="pforders-orderdetails-lblpending">'.esc_html__('PENDING PAYMENT','pointfindert2d').'</span>';
			}
			$itemnamex = get_the_title($prderinfo_itemid);

			$itemname = ($itemnamex!= false)? $itemnamex:esc_html__('Plan Deleted','pointfindert2d');

			echo '<ul class="pforders-orderdetails-ul">';
				echo '<li>';
				esc_html_e( 'INVOICE ID : ', 'pointfindert2d' );
				echo '<div class="pforders-orderdetails-lbltext">'.$inv_prefix.get_the_id().'</div>';
				echo '</li> ';

				if (!empty($prderinfo_statusorder) && !isset($_GET['oa'])) {
					echo '<li>';
					esc_html_e( 'INVOICE STATUS : ', 'pointfindert2d' );
					echo '<div class="pforders-orderdetails-lbltext">'.$prderinfo_statusorder.'</div>';
					echo '</li> ';
				}
				

			echo '</ul>';
		}
	/**
	*End : Invoice Info Content
	**/


	

	
	/**
	*Start : Invoice Detail Content
	**/
		function pointfinder_minvoices_meta_box_orderprocess( $post ) {
			echo '<ul class="pforders-orderdetails-ul">';

				global $wpdb;
				$post_author = $wpdb->get_var($wpdb->prepare("SELECT post_author FROM $wpdb->posts WHERE post_type = %s and ID = %d",'pointfinderinvoices',$post->ID));

				$user = get_user_by( 'id', $post_author );

				echo '<li>';
				esc_html_e( 'USER : ', 'pointfindert2d' );
				echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_user_link($post_author).'" target="_blank" title="'.esc_html__('Click for user details','pointfindert2d').'">'.$user->nickname.'('.$post_author.')</a></div>';
				echo '</li> ';


				echo '<li>';
				esc_html_e( 'AMOUNT : ', 'pointfindert2d' );
				echo '<div class="pforders-orderdetails-lbltext">'.get_post_meta( $post->ID, 'pointfinder_invoice_amount', true ).'</div>';
				echo '</li> ';

				$orderid = get_post_meta( $post->ID, 'pointfinder_invoice_orderid', true );

				if (!empty($orderid)) {
					echo '<li>';
					esc_html_e( 'ORDER ID : ', 'pointfindert2d' );
					echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($orderid).'">'.get_the_title($orderid).'</a></div>';
					echo '</li> ';
				}

				

				echo '<li>';
				esc_html_e( 'TYPE : ', 'pointfindert2d' );
				echo '<div class="pforders-orderdetails-lbltext">'.get_post_meta( $post->ID, 'pointfinder_invoice_invoicetype', true ).'</div>';
				echo '</li> ';

				$invoice_itemid = get_post_meta( $post->ID, 'pointfinder_invoice_itemid', true );
				$invoice_packid = get_post_meta( $post->ID, 'pointfinder_invoice_packageid', true );

				if (!empty($invoice_itemid)) {
					echo '<li>';
					esc_html_e( 'INVOICE ITEM : ', 'pointfindert2d' );
					echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($invoice_itemid).'">'.$invoice_itemid.'-'.get_the_title($invoice_itemid).'</a></div>';
					echo '</li> ';
				}

				if (!empty($invoice_packid)) {
					echo '<li>';
					esc_html_e( 'INVOICE PLAN : ', 'pointfindert2d' );
					echo '<div class="pforders-orderdetails-lbltext"><a href="'.get_edit_post_link($invoice_packid).'">'.get_the_title($invoice_packid).'</a></div>';
					echo '</li> ';
				}

				echo '<li>';
				esc_html_e( 'DATE : ', 'pointfindert2d' );
				echo '<div class="pforders-orderdetails-lbltext">'.PFU_DateformatS(get_post_meta( $post->ID, 'pointfinder_invoice_date', true ),1).'</div>';
				echo '</li> ';
				

			echo '</ul>';
		}
	/**
	*End : Invoice Detail Content
	**/


?>