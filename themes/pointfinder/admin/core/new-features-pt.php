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

add_action('post_tag_add_form_fields', 'tag_extra_fields', 10, 2);
add_action('post_tag_edit_form_fields', 'tag_extra_fields', 10, 2);
add_action('edited_post_tag', 'save_extra_fields', 10, 2);
add_action('created_post_tag', 'save_extra_fields', 10, 2);

function save_extra_fields($term_id) {
    if(isset($_POST['addInTags']) && strlen($_POST['addInTags'])>0) {
			 	global $wpdb;
				$sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id,term_order)
					select distinct object_id, " . $term_id . ", 0 from $wpdb->term_relationships r 
					inner join $wpdb->terms t on t.term_id=r.term_taxonomy_id 
					where t.name like '%". $_POST['addInTags']."%'
					and	object_id not in (select object_id from $wpdb->term_relationships where term_taxonomy_id=". $term_id . ")";
				error_log ('jchen:' . $sql);
				$count = $wpdb->query($sql);
		}
}

function tag_extra_fields($term_obj){
    $term_id        = isset($term_obj->term_id)?$term_obj->term_id:'';
    ?>
        <div class="form-field ultimate_layouts_extra_fields">
            <label for="ultimate_layouts_color">需要合并的TAG</label><br/>
            <input type="text" id="addInTags" name="addInTags" value="" autocomplete="off" width="100%">
				</div>
       <?php
}
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
