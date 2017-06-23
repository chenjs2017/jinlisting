<?php
/**********************************************************************************************************************************
*
* Orders Post Type Custom Filters
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


/**
*Start: Invoices Filters
**/

	add_action( 'restrict_manage_posts', 'pf_invoices_item_filter' );
    add_filter('parse_query','pf_invoices_item_filter_query');
    function pf_invoices_item_filter() {
        global $typenow;
        if ($typenow == 'pointfinderinvoices' ) {
            echo '<input type="text" name="invoicenum" value="" placeholder="'.esc_html__('Invoice Number','pointfindert2d').'" />';
        }
    }

	function pf_invoices_item_filter_query($query) {
        global $pagenow;
        global $typenow;
        if ($pagenow=='edit.php' && $typenow == 'pointfinderinvoices' && isset($_GET['invoicenum'])) {

        	$inv_prefix = PFASSIssetControl('setup_invoices_prefix','','PFI');
        	$invoicenum = str_replace($inv_prefix, "", $_GET['invoicenum']);

            $query->query_vars['p'] = sanitize_text_field($invoicenum );
        }
        return $query;
    }

	
	add_filter( 'manage_edit-pointfinderinvoices_columns', 'pointfinder_edit_invoices_columns' );
	function pointfinder_edit_invoices_columns( $columns ) {
		$columns = array(
            'cb' => '<input type="checkbox" />',
            'invid' => esc_html__( 'ID','pointfindert2d' ),
            'itype' => esc_html__( 'Process','pointfindert2d' ),
            'ititle' => esc_html__( 'Desc','pointfindert2d' ),
            'istatus' => esc_html__( 'Status','pointfindert2d' ),
            'userinfo' => esc_html__( 'User','pointfindert2d' ),
            
            'date' => esc_html__( 'Date','pointfindert2d' ),
        );
	    return $columns;
	}

	
	add_filter( 'manage_edit-pointfinderinvoices_sortable_columns', 'pointfinder_invoices_sortable_columns' );

	function pointfinder_invoices_sortable_columns( $columns ) {

	    $columns['istatus'] = 'istatus';

	    return $columns;
	}


	
	add_action( 'manage_pointfinderinvoices_posts_custom_column', 'pointfinder_manage_invoices_columns', 10, 2 );

	function pointfinder_manage_invoices_columns( $column, $post_id ) {
	    global $post;

	    $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
	    $user_login = get_the_author_meta('user_login');
		$user = get_user_by( 'login', $user_login );

	    switch( $column ) {

	    	case 'invid':
	    		$inv_prefix = PFASSIssetControl('setup_invoices_prefix','','PFI');
	    		echo '<strong><a href="'.admin_url('post.php?post='.get_the_id().'&action=edit').'">'.$inv_prefix.get_the_id().'</a> - <a href="'.get_permalink().'" target="_blank">'.esc_html__("View","pointfindert2d").'</a></strong>';
	    		break;

	        case 'istatus' :

	            $value2 = '';
	            
	            $value2 = get_post_status( $post_id );
	            
	            if($value2 == 'publish'){ 
	                $value2 = '<span style="color:green;font-weight:bold;">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
	            }elseif ($value2 == 'pendingpayment') {
	                $value2 = '<span style="color:red;font-weight:bold;">'.esc_html__( 'Pending Payment', 'pointfindert2d' ).'</span>';
	            }
	            echo $value2;
	            break;

	        case 'userinfo':

            	echo '<a href="'.get_edit_user_link($user->ID).'" target="_blank" title="'.esc_html__('Click for user details','pointfindert2d').'">'.$user->ID.' - '.$user->nickname.'</a>';
	            break;

	        case 'itype':
	        	echo '<strong>'.get_post_meta( $post_id,'pointfinder_invoice_invoicetype', true ).'</strong>';
	            break;

	        case 'ititle':
	        	echo '<strong>'.get_the_title().'</strong>';
	            break;
	    }
	}
/**
*End: Invoices Filters
**/
	

?>