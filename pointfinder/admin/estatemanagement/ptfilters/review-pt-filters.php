<?php
/**********************************************************************************************************************************
*
* Review Post Type Custom Filters
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
	
	/**
	*Start: Reviews Item Filter
	**/
	    add_action( 'restrict_manage_posts', 'pf_reviews_item_filter' );
	    add_filter('parse_query','pf_reviews_item_filter_query');
	    function pf_reviews_item_filter() {
	        global $typenow;
	        if ($typenow == 'pointfinderreviews' ) {
	            echo '<input type="text" name="itemnumber" value="" placeholder="'.esc_html__('Item Number','pointfindert2d').'" />';
	        }
	    }

	    function pf_reviews_item_filter_query($query) {
	        global $pagenow;
	        global $typenow;
	        if ($pagenow=='edit.php' && $typenow == 'pointfinderreviews' && isset($_GET['itemnumber'])) {
	            $query->query_vars['meta_key'] = 'webbupointfinder_review_itemid';
	            $query->query_vars['meta_value'] = $_GET['itemnumber'];
	        }
	        return $query;
	    }
	/**
	*End: Reviews Item Filter
	**/
	add_action('admin_head','pf_clear_flagged_review' );
	function pf_clear_flagged_review(){
		global $post,$post_type,$pagenow;

		if($post_type == 'pointfinderreviews' && $pagenow == 'post.php' && isset($_GET['flag'])){
			if ($_GET['flag'] == 0) {
				update_post_meta($post->ID,'webbupointfinder_review_flag',0);
			}
		}
	}



	add_filter( 'manage_edit-pointfinderreviews_columns', 'pointfinder_edit_reviews_columns' );
	function pointfinder_edit_reviews_columns( $columns ) {
	    
	        $columns = array(
	            'cb' => '<input type="checkbox" />',
	            'title' => esc_html__( 'Title','pointfindert2d' ),
	            'istatus' => esc_html__( 'Status','pointfindert2d' ),
	            'itemname' => esc_html__( 'Item','pointfindert2d' ),
	            'stars' => esc_html__( 'Rating','pointfindert2d' ),
	            'date' => esc_html__( 'Date','pointfindert2d' ),
	        );
	    

	    return $columns;
	}

	
	add_filter( 'manage_edit-pointfinderreviews_sortable_columns', 'pointfinder_reviews_sortable_columns' );

	function pointfinder_reviews_sortable_columns( $columns ) {

	    $columns['istatus'] = 'istatus';
	    $columns['stars'] = 'stars';

	    return $columns;
	}


	
	add_action( 'manage_pointfinderreviews_posts_custom_column', 'pointfinder_manage_reviews_columns', 10, 2 );

	function pointfinder_manage_reviews_columns( $column, $post_id ) {
	    global $post;

	    switch( $column ) {
	        
	        case 'title1' :
				echo '<a href="post.php?post='.$post_id.'&action=edit" style="font-weight:bold">'.get_the_title( $post_id ).'</a>';
	            break;
	        
	        case 'istatus' :

	            $value2 = '';

	            $value2 = get_post_status( $post_id );
	            
	            switch ($value2) {
	            	case 'publish':
	            		$value2_text = '<span style="color:green">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
	            		break;
	            	case 'pendingapproval':
	            		$value2_text = '<span style="color:orange">'.esc_html__( 'Pending Approval', 'pointfindert2d' ).'</span>';
	            		break;
	            	case 'pendingpayment':
	            		$value2_text = '<span style="color:red">'.esc_html__( 'Pending Payment', 'pointfindert2d' ).'</span>';
	            		break;
	            	case 'rejected':
	            		$value2_text = '<span style="color:red">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
	            		break;
	            	
	            	default:
	            		$value2_text = '<span style="color:green">'.esc_html__( 'Rejected', 'pointfindert2d' ).'</span>';
	            		break;
	            }
	            echo $value2_text;
	            break;

	        case 'itemname':

	            $item_id = esc_attr(get_post_meta( $post_id, 'webbupointfinder_review_itemid', true ));
	            if(!empty($item_id)){
	                echo '<a href="'.get_permalink($item_id).'" target="_blank">'.get_the_title($item_id).'('.$item_id.')</a>';
	            }
	            break;

	        case 'stars':
	            $total = pfcalculate_single_review($post_id);

	            if (empty($total)) {
	                echo '0';
	            }else{
	                echo $total;
	            }
	            break;

	    }
	}
?>