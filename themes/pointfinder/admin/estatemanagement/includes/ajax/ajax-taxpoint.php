<?php

/**********************************************************************************************************************************
*
* Ajax Taxonomy Point Values
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


	add_action( 'PF_AJAX_HANDLER_pfget_taxpoint', 'pf_ajax_taxpoint' );
	add_action( 'PF_AJAX_HANDLER_nopriv_pfget_taxpoint', 'pf_ajax_taxpoint' );
	
	
function pf_ajax_taxpoint(){
	//Security
	check_ajax_referer( 'pfget_taxpoint', 'security' );

	header('Content-type: text/javascript');

	//Current Language
	if(isset($_POST['cl']) && $_POST['cl']!=''){
		$pflang = esc_attr($_POST['cl']);
		if(function_exists('icl_t')) {
            if (!empty($pflang)) {
                do_action( 'wpml_switch_language', $pflang );
            }
        }
	}else{
		$pflang = '';
	}


	if(!is_array($_POST['id'])){
	$ScriptOutput = '';
	$pf_get_term_details = get_terms('pointfinderlocations',array('hide_empty'=>false)); 

	if(count($pf_get_term_details) > 0){
			
			$meta = get_option('pointfinderlocations_vars');
			
			if (empty($meta)) $meta = array();
			if (!is_array($meta)) $meta = (array) $meta;
			
			
			if ( $pf_get_term_details && ! is_wp_error( $pf_get_term_details ) ) {
				$pf_item_terms_ids = array();
				
				foreach ( $pf_get_term_details as $pf_get_term_detail) {
					if($pf_get_term_detail->term_id == esc_attr($_POST['id'])){
						
						$term_idx = $pf_get_term_detail->term_id;
					
						if(empty($meta[$term_idx]['pf_lat_of_location']) == false){ $latoflocation = $meta[$term_idx]['pf_lat_of_location'];}else{$latoflocation = '';}
						if(empty($meta[$term_idx]['pf_lng_of_location']) == false){ $lngoflocation = $meta[$term_idx]['pf_lng_of_location'];}else{$lngoflocation = '';}
						
						if($lngoflocation != '' && $latoflocation != ''){
							$ScriptOutput .= '(function($) {"use strict";$.pfgmap3static.movemaplatlng['.esc_js($_POST['id']).'] = ['.esc_js($latoflocation).','.esc_js($lngoflocation).'];})(jQuery);';
						}
						break;
					}
					
					
					
				}
				
				
			} 
		echo $ScriptOutput;
	}	
	}	
	die();
}

?>