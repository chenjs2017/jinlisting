<?php
/**********************************************************************************************************************************
*
* Additional  Custom Post Type Statuses
*  
*  
*
* Author: Webbu Design
*
***********************************************************************************************************************************/


/**
*Start: Custom Post Statuses
**/
	function pf_custom_post_status(){
		register_post_status( 'pendingapproval', array(
			'label'                     => esc_html__( 'Pending Approval', 'pointfindert2d' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Pending Approval <span class="count">(%s)</span>', 'Pending Approval <span class="count">(%s)</span>' , 'pointfindert2d'),
		) );

		register_post_status( 'rejected', array(
			'label'                     => esc_html__( 'Rejected', 'pointfindert2d' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>' , 'pointfindert2d'),
		) );


		register_post_status( 'pendingpayment', array(
			'label'                     => esc_html__( 'Pending Payment', 'pointfindert2d' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>' , 'pointfindert2d'),
		) );

		register_post_status( 'completed', array(
			'label'                     => esc_html__( 'Payment Completed', 'pointfindert2d' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Payment Completed <span class="count">(%s)</span>', 'Payment Completed <span class="count">(%s)</span>', 'pointfindert2d' ),
		) );

		register_post_status( 'pfcancelled', array(
			'label'                     => esc_html__( 'Payment Cancelled', 'pointfindert2d' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Payment Cancelled <span class="count">(%s)</span>', 'Payment Cancelled <span class="count">(%s)</span>', 'pointfindert2d' ),
		) );

		register_post_status( 'pfsuspended', array(
			'label'                     => esc_html__( 'Payment Suspended', 'pointfindert2d' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Payment Suspended <span class="count">(%s)</span>', 'Payment Suspended <span class="count">(%s)</span>', 'pointfindert2d' ),
		) );
	}
	add_action( 'init', 'pf_custom_post_status' );
/**
*End: Custom Post Statuses
**/

?>