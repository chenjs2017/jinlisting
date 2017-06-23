<?php
/**********************************************************************************************************************************
*
* PF Items Post Type Custom Filters
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
	
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	

	/**
	*Start: PF Items Item Filter
	**/
	    add_action( 'restrict_manage_posts', 'pointfinder_items_item_filter' );
	    if (is_admin()) {
	    	add_filter('parse_query','pointfinder_items_item_filter_query');
		}
	    function pointfinder_items_item_filter() {
	        global $typenow;
	        $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	        if ($typenow == $setup3_pointposttype_pt1 ) {
	            echo '<input type="text" name="itemnumber" value="" placeholder="'.esc_html__('Item Number','pointfindert2d').'" />';
	        }
	    }

	    function pointfinder_items_item_filter_query($query) {
	        global $pagenow;
	        global $typenow;
	        $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	        if ($pagenow=='edit.php' && $typenow == $setup3_pointposttype_pt1 && isset($_GET['itemnumber'])) {
	            $query->query_vars['p'] = $_GET['itemnumber'];
	        }
	        return $query;
	    }
	/**
	*End: PF Items Item Filter
	**/

	add_filter( 'manage_edit-'.$setup3_pointposttype_pt1.'_columns', 'pointfinder_items_edit_columns' ) ;
	function pointfinder_items_edit_columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => esc_html__( 'Title','pointfindert2d'),
			'istatus' => esc_html__( 'Status','pointfindert2d'),
			'ltype' => esc_html__( 'List Type','pointfindert2d'),
			'author' => esc_html__( 'Author','pointfindert2d'),
			'date' => esc_html__( 'Date','pointfindert2d'),
			'estatephoto' => esc_html__( 'Photo','pointfindert2d'),
		);
		return $columns;
	}

	
	add_filter( 'manage_edit-'.$setup3_pointposttype_pt1.'_sortable_columns', 'pointfinder_items_sortable_columns' );
	function pointfinder_items_sortable_columns( $columns ) {
		$columns['author'] = 'author';
		$columns['istatus'] = 'istatus';
		$columns['ltype'] = 'ltype';
		return $columns;
	}


	
	add_action( 'manage_'.$setup3_pointposttype_pt1.'_posts_custom_column', 'pointfinder_items_manage_columns', 10, 2 );
	function pointfinder_items_manage_columns( $column, $post_id ) {
		
		global $post;
		$noimg_url = get_template_directory_uri().'/images/noimg.png';

		switch( $column ) {
			case 'estatephoto' :
				$post_featured_image = get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'pointfinderlistthumbimg' )); 
				if ($post_featured_image) {  
					echo $post_featured_image;  
				} else {  
					echo '<img src="' . $noimg_url.'" width="101" height="67" alt="" />';  
				}  
				break;

			case 'istatus' :
				switch ($post->post_status) {
					case 'publish':
						echo '<span style="color:green">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
						break;
					case 'pendingapproval':
						echo '<span style="color:red">'.esc_html__( 'Pending Approval', 'pointfindert2d' ).'</span>';
						break;
					case 'pendingpayment':
						echo '<span style="color:red">'.esc_html__( 'Pending Payment', 'pointfindert2d' ).'</span>';
						break;
					case 'rejected':
						echo '<span style="color:red">'.esc_html__( 'Rejected', 'pointfindert2d' ).'</span>';
						break;
					default:
						echo '';
						break;
				}
				break;

			case 'ltype':
				echo get_the_term_list( $post_id, 'pointfinderltypes', '<ul class="pointfinderpflistterms"><li>', ',</li><li>', '</li></ul>' );
				break;		
				
		}
	}
	
?>