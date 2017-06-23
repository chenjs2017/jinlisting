<?php

/**********************************************************************************************************************************
*
* Listing type connection with other taxonomies
* 
* Author: Webbu Design
* Please do not modify below functions.
***********************************************************************************************************************************/

add_action('pointfinderfeatures_add_form_fields', 'pointfinder_category_form_custom_field_add', 10 );
add_action('pointfinderfeatures_edit_form_fields', 'pointfinder_category_form_custom_field_edit', 10, 2 );

add_action('pointfinderitypes_add_form_fields', 'pointfinder_category_form_custom_field_add', 10 );
add_action('pointfinderitypes_edit_form_fields', 'pointfinder_category_form_custom_field_edit', 10, 2 );

add_action('pointfinderconditions_add_form_fields', 'pointfinder_category_form_custom_field_add', 10 );
add_action('pointfinderconditions_edit_form_fields', 'pointfinder_category_form_custom_field_edit', 10, 2 );


/* For add screen */
function pointfinder_category_form_custom_field_add( $taxonomy ) {
    switch ($taxonomy) {
        case 'pointfinderfeatures':
        case 'pointfinderitypes':
        case 'pointfinderconditions':
            pointfinder_taxonomy_connection_field_creator('');
            break;

    }
}


/* For edit screen */
function pointfinder_category_form_custom_field_edit( $tag, $taxonomy ) {
    
    $process = false;

    switch ($taxonomy) {
        case 'pointfinderfeatures':
            $option_name = 'pointfinder_features_customlisttype_' . $tag->term_id;
            $selected_value = get_option( $option_name );
            $process = true;
            break;

        case 'pointfinderitypes':
            $selected_value = get_term_meta($tag->term_id,'pointfinder_itemtype_clt',true);
            $process = true;
            break;

        case 'pointfinderconditions':
            $selected_value = get_term_meta($tag->term_id,'pointfinder_condition_clt',true);
            $process = true;
            break;
    }

    if ($process) {
        pointfinder_taxonomy_connection_field_creator($selected_value);
    }
}


/** Save Custom Field Of Category Form */
add_action( 'created_pointfinderfeatures', 'pointfinder_category_form_custom_field_save', 10, 2 ); 
add_action( 'edited_pointfinderfeatures', 'pointfinder_category_form_custom_field_save', 10, 2 );

add_action( 'created_pointfinderitypes', 'pointfinder_category_form_custom_field_save', 10, 2 ); 
add_action( 'edited_pointfinderitypes', 'pointfinder_category_form_custom_field_save', 10, 2 );

add_action( 'created_pointfinderconditions', 'pointfinder_category_form_custom_field_save', 10, 2 ); 
add_action( 'edited_pointfinderconditions', 'pointfinder_category_form_custom_field_save', 10, 2 );

function pointfinder_category_form_custom_field_save( $term_id, $tt_id ) {

    if (isset($_POST['taxonomy'])) {

        $taxonomy = $_POST['taxonomy'];
        $pflist = (isset($_POST['pfupload_listingtypes']))?$_POST['pfupload_listingtypes']:'';
    
        switch ($taxonomy) {
            case 'pointfinderfeatures':
                if ( isset( $pflist ) ) { 
                    $option_name = 'pointfinder_features_customlisttype_' . $term_id;
                    update_option( $option_name, $pflist );
                }else{
                    $option_name = 'pointfinder_features_customlisttype_' . $term_id;
                    update_option( $option_name, "" );
                }
                break;

            case 'pointfinderitypes':
                update_term_meta($term_id, 'pointfinder_itemtype_clt',$pflist);
                break;

            case 'pointfinderconditions':
                update_term_meta($term_id, 'pointfinder_condition_clt',$pflist);
                break;

        }   
    }   
}
?>