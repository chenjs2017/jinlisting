<?php
/**********************************************************************************************************************************
*
* Review System Custom Metaboxes
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

/**
*Start: Review metabox for item detail page on admin
**/

	function pf_add_additional_review_metabox($post_type, $post = '') {
		if (!empty($post)) {
			$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
			if ($post_type == $setup3_pointposttype_pt1) {
				
				add_meta_box(
					'pointfinder_reviews_status',
					esc_html__( 'Reviews', 'pointfindert2d' ),
					'pointfinder_item_meta_box_reviews',
					$setup3_pointposttype_pt1, 
					'side',
					'high'
				);
				
			}
		}
	}
	add_action( 'add_meta_boxes' , 'pf_add_additional_review_metabox', 101, 2 );
/**
*End: Review metabox for item detail page on admin
**/

function pointfinder_item_meta_box_reviews( $post ){
	$reviews = pfcalculate_total_review_ot($post->ID);

	$reviewtext = (is_array($reviews)) ? $reviews['totalresult'] : 0 ;
	echo esc_html__('Total Rating','pointfindert2d').' : '.$reviewtext.' / '.esc_html__('Total Reviews','pointfindert2d').' : '.pfcalculate_total_rusers($post->ID);
	echo '<br/>';
	echo '    <a href="'.admin_url('edit.php?post_type=pointfinderreviews&itemnumber='.$post->ID).'" class="pf-seeallrevs">'.esc_html__("See all reviews","pointfindert2d" ).'</a>';
}
?>