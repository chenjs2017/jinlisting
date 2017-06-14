<?php
/**********************************************************************************************************************************
*
* Ajax Taxonomy filter per listing type
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_featuresfilter', 'pf_ajax_featuresfilter' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_featuresfilter', 'pf_ajax_featuresfilter' );

function pf_ajax_featuresfilter(){
  	check_ajax_referer( 'pfget_searchitems', 'security');

    header('Content-Type: application/json; charset=UTF-8;');

    if(isset($_POST['cl']) && $_POST['cl']!=''){
        $pflang = esc_attr($_POST['cl']);
    }

    if(function_exists('icl_t')) {
        if (!empty($pflang)) {
            do_action( 'wpml_switch_language', $pflang );
        }
    }


	if(isset($_POST['pfcat']) && $_POST['pfcat']!=''){
		$id = sanitize_text_field($_POST['pfcat']);
	}

    if(isset($_POST['rq']) && $_POST['rq']!=''){
        $rq = $_POST['rq'];
        $rq = PFCleanArrayAttr('PFCleanFilters',$rq);
    }


    function PFGetListFA_Search($params = array()){
        $defaults = array( 
            'listsubtype' => '',
            'connectionkey' => '',
            'connectionvalue' => '',
            'connectionstatus' => 1,
        );
        
        $params = array_merge($defaults, $params);

        $i = 0;
        $output_options = '';

        $fieldvalues = get_terms($params['listsubtype'],array('hide_empty'=>false));

        foreach( $fieldvalues as $parentfieldvalue){
            if($parentfieldvalue->parent == 0){
                /* If connection enabled */
                if ($params['connectionstatus'] == 0) {
                    $process = false;

                    $term_meta_check = get_term_meta($parentfieldvalue->term_id,$params['connectionkey'],true);
                    if (is_array($term_meta_check)) {
                        if (in_array($params['connectionvalue'], $term_meta_check)) {
                            $process = true;
                        }
                    }
                }else{
                    $process = true;
                }


                if ($process) {

                    $i++;
                    
                    $output_options .= '<option class="pointfinder-parent-field" value="'.$parentfieldvalue->term_id.'">'.$parentfieldvalue->name.'</option>';
                    

                    foreach( $fieldvalues as $fieldvalue){

                        if($fieldvalue->parent == $parentfieldvalue->term_id){

                            /* If connection enabled */
                            if ($params['connectionstatus'] == 0) {
                                $process_child = false;

                                $term_meta_check = get_term_meta($fieldvalue->term_id,$params['connectionkey'],true);
                                if (is_array($term_meta_check)) {
                                    if (in_array($params['connectionvalue'], $term_meta_check)) {
                                        $process_child = true;
                                    }
                                }
                            }else{
                                $process_child = true;
                            }


                            if ($process_child) {
                                $output_options .= '<option value="'.$fieldvalue->term_id.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalue->name.'</option>';
                            }
                        }
                    }
                        
                    
                }
            
            }
        }


        if ($i > 0 ) {
            return $output_options;
        }
       
    }


    $output_features = $output_itypes = $output_conditions = '';

    if (in_array('features', $rq)) {
        $args = array(
            'orderby'           => 'name', 
            'order'             => 'ASC',
            'hide_empty'        => false, 
            'exclude'           => array(), 
            'exclude_tree'      => array(), 
            'include'           => array(),
            'number'            => '', 
            'fields'            => 'all', 
            'slug'              => '',
            'parent'            => '',
            'hierarchical'      => true, 
            'child_of'          => 0, 
            'get'               => '', 
            'name__like'        => '',
            'description__like' => '',
            'pad_counts'        => false, 
            'offset'            => '', 
            'search'            => '', 
            'cache_domain'      => 'core'
        ); 

        $terms = get_terms('pointfinderfeatures', $args);


        if (isset($terms)) {
            if (is_array($terms)) {
                foreach ($terms as $term) {

                    $term_parent = get_option( 'pointfinder_features_customlisttype_' . $term->term_id );
                
                    $output_check = pointfinder_features_tax_output_check($term_parent,$id,'pointfinderfeatures');

                    if ($output_check == 'ok') {
                        $output_features .= '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                    }

                }
            }
        }
    }

    if (in_array('itypes', $rq)) {
        $stp_syncs_it = PFSAIssetControl('stp_syncs_it','',1);
        $fields_output_arr = array(
            'listsubtype' => 'pointfinderitypes',
            'connectionkey' => 'pointfinder_itemtype_clt',
            'connectionvalue' => $id,
            'connectionstatus' => $stp_syncs_it,
        );

        $output_itypes = PFGetListFA_Search($fields_output_arr);
    }

    if (in_array('conditions', $rq)) {
        $stp_syncs_co = PFSAIssetControl('stp_syncs_co','',1);
        $fields_output_arr = array(
            'listsubtype' => 'pointfinderconditions',
            'connectionkey' => 'pointfinder_condition_clt',
            'connectionvalue' => $id,
            'connectionstatus' => $stp_syncs_co,
        );

        $output_conditions = PFGetListFA_Search($fields_output_arr);
    }

    echo json_encode(array('features' => $output_features, 'itypes' => $output_itypes, 'conditions' => $output_conditions));
    
die();
}

?>