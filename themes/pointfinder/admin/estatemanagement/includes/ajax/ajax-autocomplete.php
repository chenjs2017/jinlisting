<?php

/**********************************************************************************************************************************
*
* Ajax Auto Complete
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


	add_action( 'PF_AJAX_HANDLER_pfget_autocomplete', 'pf_ajax_autocomplete' );
	add_action( 'PF_AJAX_HANDLER_nopriv_pfget_autocomplete', 'pf_ajax_autocomplete' );
	
	
function pf_ajax_autocomplete(){
	//Security
	check_ajax_referer( 'pfget_autocomplete', 'security' );
	header('Content-Type: application/javascript; charset=UTF-8;');
	
	//Get form type 
	if(isset($_GET['ftype']) && $_GET['ftype']!=''){
		$ftype = sanitize_text_field($_GET['ftype']);
	}

	//Get search key
	if(isset($_GET['q']) && $_GET['q']!=''){
		$searchword = sanitize_text_field(big2gb($_GET['q']));
	}

	//Get search key
	if(isset($_GET['callback']) && $_GET['callback']!=''){
		$callback = sanitize_text_field($_GET['callback']);
	}

	$tax_query = false;

	/* Get admin values */
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	$args = array( 'post_type' => $setup3_pointposttype_pt1, 'post_status' => 'publish','posts_per_page' => 5);


		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
		$args['search_prod_title'] = $searchword;


	$output_arr = array();

    global $wpdb;
//    $vSQL= "SELECT * FROM `wp_terms` where name like '%".$searchword."%' limit 10 " ;
    $vSQL ="SELECT wp_terms.* FROM wp_terms INNER JOIN wp_term_taxonomy ON wp_terms.term_id=wp_term_taxonomy.term_id where wp_term_taxonomy.taxonomy='pointfinderltypes' and wp_terms.name like '%".$searchword."%' limit 10 ";
    $terms = $wpdb->get_results($vSQL);

    foreach ( $terms as $term )
    {
        $output_arr[] =$term->name;
    }

    $vSQL =" SELECT * FROM `wp_posts` where post_status='publish' and post_type='listing' and post_title like '%".$searchword."%' limit 10";
    $listings = $wpdb->get_results($vSQL);

    foreach ( $listings as $listing )
    {
        $output_arr[] =$listing->post_title;
    }


	echo $callback.'('.json_encode($output_arr).');';
		
	die();
}

?>