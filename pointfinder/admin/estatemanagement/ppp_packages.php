<?php
/**********************************************************************************************************************************
*
* Pay per post Packages Post Type
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action('admin_menu','pointfinder_ppp_pack_function',9);
if(function_exists('icl_t')) {add_action('init','pointfinder_ppp_pack_function');}/*WPML Fix*/
function pointfinder_ppp_pack_function(){
    $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
    /**
    *Start: Membership Post Type
    **/
        if($setup4_membersettings_paymentsystem == 1){
            register_post_type('pflistingpacks', 
                array(
                'labels' => array(
                    'name' => esc_html__('Listing Packs','pointfindert2d'), 
                    'singular_name' => esc_html__('Package','pointfindert2d'),
                    'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'edit' => esc_html__('Edit', 'pointfindert2d'),
                    'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),esc_html__('Listing Packages','pointfindert2d')),
                    'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                    'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),esc_html__('Listing Package','pointfindert2d')),
                ),
                'public' => true,
                //'menu_position' => 205,
                'menu_icon' => 'dashicons-admin-generic',
                'hierarchical' => true, 
                'show_tagcloud' => false, 
                'show_in_nav_menus' => false, 
                'has_archive' => true,
                'show_in_menu' => 'pointfinder_tools',
                'supports' => array(
                    'title'
                ), 
                'can_export' => true, 
                'taxonomies' => array()
                
            ));
        }

    /**
    *End: Membership Post Type
    **/
}


add_action( 'manage_pflistingpacks_posts_custom_column', 'pointfinder_listingpacks_manage_columns', 10, 2 );

    function pointfinder_listingpacks_manage_columns( $column, $post_id ) {
        global $post;

        switch( $column ) {
            
            case 'price' :
                echo get_post_meta( $post_id, 'webbupointfinder_lp_price', true ); 
                break;

            case 'status' :

                $statusofitem = get_post_meta( $post_id, 'webbupointfinder_lp_showhide', true );

                if ($statusofitem == 2) {
                    echo esc_html__('Hidden','pointfindert2d' );
                }else{
                    echo esc_html__('Visible','pointfindert2d' );
                }
                break;

            case 'cycle':
                $billingp = get_post_meta( $post_id, 'webbupointfinder_lp_billing_period', true ); 
                $cycleofitem = 'daily';

                if ($billingp == 0) {
                    echo esc_html__('Unlimited','pointfindert2d' );
                }else{
                    echo $billingp.esc_html__('Day(s)','pointfindert2d' );
                    echo '</small>';
                }

                break;    
          
        }
    }




add_filter( 'manage_pflistingpacks_posts_columns', 'pointfinder_listingpacks_edit_columns' ) ;

    function pointfinder_listingpacks_edit_columns( $columns ) {
            $newcolumns = array(
                'cycle' => esc_html__( 'Cycle','pointfindert2d'),
                'price' => esc_html__( 'Price','pointfindert2d'),
                'status' => esc_html__( 'Status','pointfindert2d'),
            );

            $result_array = array_merge($columns, $newcolumns);
            $datefield = $result_array['date'];
            unset($result_array['date']);
            $result_array['date'] = $datefield;
            return $result_array;
    }

?>