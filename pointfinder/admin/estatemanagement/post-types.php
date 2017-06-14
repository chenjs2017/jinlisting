<?php
/**********************************************************************************************************************************
*
* Custom Post Types
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


function create_post_type_pointfinder()
{	

    /**
    *Start: Get Admin Values
    **/
        $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
        $setup3_pointposttype_pt2 = PFSAIssetControl('setup3_pointposttype_pt2','','PF Item');
        $setup3_pointposttype_pt3 = PFSAIssetControl('setup3_pointposttype_pt3','','PF Items');
        $setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4','','Item Types');
        $setup3_pointposttype_pt4s = PFSAIssetControl('setup3_pointposttype_pt4s','','Item Type');
        $setup3_pointposttype_pt4p = PFSAIssetControl('setup3_pointposttype_pt4p','','types');
        $setup3_pointposttype_pt5 = PFSAIssetControl('setup3_pointposttype_pt5','','Locations');
        $setup3_pointposttype_pt5s = PFSAIssetControl('setup3_pointposttype_pt5s','','Location');
        $setup3_pointposttype_pt5p = PFSAIssetControl('setup3_pointposttype_pt5p','','area');
        $setup3_pointposttype_pt6 = PFSAIssetControl('setup3_pointposttype_pt6','','Features');
        $setup3_pointposttype_pt6s = PFSAIssetControl('setup3_pointposttype_pt6s','','Feature');
        $setup3_pointposttype_pt6p = PFSAIssetControl('setup3_pointposttype_pt6p','','feature');
        $setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
        $setup3_pointposttype_pt7s = PFSAIssetControl('setup3_pointposttype_pt7s','','Listing Type');
        $setup3_pointposttype_pt7p = PFSAIssetControl('setup3_pointposttype_pt7p','','listing');
        $setup3_pointposttype_pt8 = PFSAIssetControl('setup3_pointposttype_pt8','','agents');
        $setup3_pointposttype_pt9 = PFSAIssetControl('setup3_pointposttype_pt9','','PF Agent');
        $setup3_pointposttype_pt10 = PFSAIssetControl('setup3_pointposttype_pt10','','PF Agents');
        $setup3_pointposttype_pt11 = PFSAIssetControl('setup3_pointposttype_pt11','','testimonials');
        $setup3_pointposttype_pt12 = PFSAIssetControl('setup3_pointposttype_pt12','','PF Testimonials');
        $setup3_pointposttype_pt13 = PFSAIssetControl('setup3_pointposttype_pt13','','Testimonial');

        $setup3_pt14 = PFSAIssetControl('setup3_pt14','','Conditions');
        $setup3_pt14s = PFSAIssetControl('setup3_pt14s','','Condition');
        $setup3_pt14p = PFSAIssetControl('setup3_pt14p','','condition');
        $setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','','0');

        $setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
        $setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
        $setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');

        $setup3_pointposttype_pt6_status = PFSAIssetControl('setup3_pointposttype_pt6_status','','1');


        $setup4_membersettings_loginregister = PFSAIssetControl('setup4_membersettings_loginregister','','1');
        $setup4_membersettings_frontend = PFSAIssetControl('setup4_membersettings_frontend','','1');

        $setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');
        $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
    /**
    *End: Get Admin Values
    **/


    /**
    *Start: Reviews Post Type
    **/
        if($setup11_reviewsystem_check == 1){
           
            register_post_type('pointfinderreviews', 
                array(
                'labels' => array(
                    'name' => esc_html__( 'PF Reviews', 'pointfindert2d' ), 
                    'singular_name' => esc_html__( 'PF Review', 'pointfindert2d' ),
                    'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'edit' => esc_html__('Edit', 'pointfindert2d'),
                    'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                    'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),esc_html__( 'Review', 'pointfindert2d' )),
                ),
                'public' => true,
        		'menu_position' => 209,
        		'menu_icon' => 'dashicons-format-status',
                'hierarchical' => true, 
        		'show_tagcloud' => false, 
                'show_in_nav_menus' => false,
                'has_archive' => true,
                'supports' => array('title','editor'), 
                'can_export' => true, 
        		'taxonomies' => array(),
        		'register_meta_box_cb' => 'pointfinder_reviews_add_meta_box',		
            ));
        	
        }	
    /**
    *End: Reviews Post Type
    **/


    /**
    *Start: Orders Post Type
    **/
        if($setup4_membersettings_frontend == 1 && $setup4_membersettings_loginregister == 1 && $setup4_membersettings_paymentsystem == 1){
           
            register_post_type('pointfinderorders', 
                array(
                'labels' => array(
                    'name' => esc_html__( 'PF Orders', 'pointfindert2d' ), 
                    'singular_name' => esc_html__( 'PF Order', 'pointfindert2d' ),
                    'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'edit' => esc_html__('Edit', 'pointfindert2d'),
                    'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),esc_html__( 'Orders', 'pointfindert2d' )),
                    'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                ),
                'public' => true,
        		'menu_position' => 208,
        		'menu_icon' => 'dashicons-feedback',
                'hierarchical' => true, 
        		'show_tagcloud' => false,
                'show_in_nav_menus' => false, 
                'has_archive' => true,
                'supports' => false,
                'can_export' => true, 
        		'taxonomies' => array(),
        		'register_meta_box_cb' => 'pointfinder_orders_add_meta_box',
        		
            ));
        	
        }	
    /**
    *End: Orders Post Type
    **/

    /**
    *Start: Orders for membership Post Type
    **/
        if($setup4_membersettings_frontend == 1 && $setup4_membersettings_loginregister == 1 && $setup4_membersettings_paymentsystem == 2){
           
            register_post_type('pointfindermorders', 
                array(
                'labels' => array(
                    'name' => esc_html__( 'PF Orders', 'pointfindert2d' ), 
                    'singular_name' => esc_html__( 'PF Order', 'pointfindert2d' ),
                    'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'edit' => esc_html__('Edit', 'pointfindert2d'),
                    'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),esc_html__( 'Orders', 'pointfindert2d' )),
                    'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                    'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),esc_html__( 'Order', 'pointfindert2d' )),
                ),
                'public' => true,
                'menu_position' => 208,
                'menu_icon' => 'dashicons-feedback',
                'hierarchical' => true, 
                'show_tagcloud' => false,
                'show_in_nav_menus' => false, 
                'has_archive' => true,
                'supports' => false,
                'can_export' => true, 
                'taxonomies' => array(),
                'register_meta_box_cb' => 'pointfinder_morders_add_meta_box',
                
            ));
            
        }   
    /**
    *End: Orders for membership Post Type
    **/

    /**
    *Start: Invoices Post Type
    **/
        if($setup4_membersettings_frontend == 1 && $setup4_membersettings_loginregister == 1){
           
            register_post_type('pointfinderinvoices', 
                array(
                'labels' => array(
                    'name' => esc_html__( 'PF Invoices', 'pointfindert2d' ), 
                    'singular_name' => esc_html__( 'PF Invoice', 'pointfindert2d' ),
                    'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'edit' => esc_html__('Edit', 'pointfindert2d'),
                    'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),esc_html__( 'Invoices', 'pointfindert2d' )),
                    'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                    'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),esc_html__( 'Invoice', 'pointfindert2d' )),
                ),
                'public' => true,
                'menu_position' => 210,
                'menu_icon' => 'dashicons-list-view',
                'hierarchical' => true, 
                'show_tagcloud' => false,
                'show_in_nav_menus' => false, 
                'has_archive' => true,
                'supports' => false,
                'can_export' => true, 
                'taxonomies' => array(),
                'register_meta_box_cb' => 'pointfinder_minvoices_add_meta_box',
                
            ));
            
        }   
    /**
    *End: Invoices Post Type
    **/


    /**
    *Start: Testimonials Post Type
    **/
        register_post_type(''.$setup3_pointposttype_pt11.'', 
            array(
            'labels' => array(
                'name' => ''.$setup3_pointposttype_pt12.'', 
                'singular_name' => ''.$setup3_pointposttype_pt13.'',
                'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'edit' => esc_html__('Edit', 'pointfindert2d'),
                'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt12),
                'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),$setup3_pointposttype_pt13),
                'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),$setup3_pointposttype_pt13),
            ),
            'public' => true,
    		'menu_position' => 207,
    		'menu_icon' => 'dashicons-format-chat',
            'hierarchical' => true, 
    		'show_tagcloud' => false, 
            'show_in_nav_menus' => false,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
            ), 
            'can_export' => true, 
    		'taxonomies' => array(),
    		
        ));
    /**
    *End: Testimonials Post Type
    **/



    /**
    *Start: Agents Post Type
    **/
        if($setup3_pointposttype_pt6_status == 1){
            register_post_type(''.$setup3_pointposttype_pt8.'', 
                array(
                'labels' => array(
                    'name' => ''.$setup3_pointposttype_pt10.'', 
                    'singular_name' => ''.$setup3_pointposttype_pt9.'',
                    'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'edit' => esc_html__('Edit', 'pointfindert2d'),
                    'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt10),
                    'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                    'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),$setup3_pointposttype_pt9),
                ),
                'public' => true,
        		'menu_position' => 206,
        		'menu_icon' => 'dashicons-businessman',
                'hierarchical' => true, 
        		'show_tagcloud' => false, 
                'has_archive' => true,
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                ), 
                'can_export' => true, 
        		'taxonomies' => array(),
                'rewrite' => true
        		
            ));
        }
    /**
    *End: Agents Post Type
    **/



    /**
    *Start: PF Items Post Type
    **/
        register_post_type(''.$setup3_pointposttype_pt1.'', 
            array(
            'labels' => array(
                'name' => ''.$setup3_pointposttype_pt3.'', 
                'singular_name' => ''.$setup3_pointposttype_pt2.'',
                'add_new' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'edit' => esc_html__('Edit', 'pointfindert2d'),
                'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'new_item' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'view' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'view_item' => sprintf(esc_html__( 'View %s', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt3),
                'not_found' => sprintf(esc_html__( 'No %s found', 'pointfindert2d' ),$setup3_pointposttype_pt2),
                'not_found_in_trash' => sprintf(esc_html__( 'No %s found in Trash', 'pointfindert2d' ),$setup3_pointposttype_pt2),
            ),
            'public' => true,
    		'menu_position' => 202,
    		'menu_icon' => 'dashicons-location-alt',
            'hierarchical' => true, 
    		'show_tagcloud' => false, 
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
    			'excerpt',
                'page-attributes',
                'tags'
            ), 
            'can_export' => true, 
    		'taxonomies' => array('post_tag')
    		
        ));
    /**
    *End: PF Items Post Type
    **/



    /**
    *Start: Listing Types Taxonomy
    **/
    	  $labels = array(
    		'name' => ''.$setup3_pointposttype_pt7.'',
    		'singular_name' => ''.$setup3_pointposttype_pt7s.'',
    		'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt7),
    		'popular_items' => sprintf(esc_html__( 'Popular %s', 'pointfindert2d' ),$setup3_pointposttype_pt7),
    		'all_items' => sprintf(esc_html__( 'All %s', 'pointfindert2d' ),$setup3_pointposttype_pt7),
    		'parent_item' => null,
    		'parent_item_colon' => null,
    		'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt7s),
    		'update_item' => sprintf(esc_html__( 'Update %s', 'pointfindert2d' ),$setup3_pointposttype_pt7s),
    		'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt7s),
    		'new_item_name' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt7s),
    		'separate_items_with_commas' => sprintf(esc_html__( 'Separate %s with commas', 'pointfindert2d' ),$setup3_pointposttype_pt7),
    		'add_or_remove_items' => sprintf(esc_html__( 'Add or remove %s', 'pointfindert2d' ),$setup3_pointposttype_pt7s),
    		'choose_from_most_used' => sprintf(esc_html__( 'Choose from the most used %s', 'pointfindert2d' ),$setup3_pointposttype_pt7s),
    		'menu_name' => ''.$setup3_pointposttype_pt7.'',
    	  ); 
    	  
    	  
    	  register_taxonomy('pointfinderltypes',''.$setup3_pointposttype_pt1.'',array(
    		'hierarchical' => true,
    		'labels' => $labels,
    		'show_ui' => true,
    		'show_admin_column' => true,
            'show_in_nav_menus' => true,
    		'update_count_callback' => '_update_post_term_count',
    		'query_var' => true,
    		'rewrite' => array( 'slug' => $setup3_pointposttype_pt7p,'hierarchical'=>true ),
    		'sort' => true,
    	  ));
    /**
    *End: Listing Types Taxonomy
    **/


    	
    /**
    *Start: Item Types Taxonomy
    **/
        if($setup3_pointposttype_pt4_check == 1){
        	  $labels = array(
        		'name' => ''.$setup3_pointposttype_pt4.'',
        		'singular_name' => ''.$setup3_pointposttype_pt4.'',
        		'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt4),
        		'popular_items' => sprintf(esc_html__( 'Popular %s', 'pointfindert2d' ),$setup3_pointposttype_pt4),
        		'all_items' => sprintf(esc_html__( 'All %s', 'pointfindert2d' ),$setup3_pointposttype_pt4),
        		'parent_item' => null,
        		'parent_item_colon' => null,
        		'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt4s),
        		'update_item' => sprintf(esc_html__( 'Update %s', 'pointfindert2d' ),$setup3_pointposttype_pt4s),
        		'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt4s),
        		'new_item_name' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt4s),
        		'separate_items_with_commas' => sprintf(esc_html__( 'Separate %s with commas', 'pointfindert2d' ),$setup3_pointposttype_pt4),
        		'add_or_remove_items' => sprintf(esc_html__( 'Add or remove %s', 'pointfindert2d' ),$setup3_pointposttype_pt4s),
        		'choose_from_most_used' => sprintf(esc_html__( 'Choose from the most used %s', 'pointfindert2d' ),$setup3_pointposttype_pt4s),
        		'menu_name' => ''.$setup3_pointposttype_pt4.'',
        	  ); 
        	  
        	  
        	  register_taxonomy('pointfinderitypes',''.$setup3_pointposttype_pt1.'',array(
                'show_in_nav_menus' => true,
        		'hierarchical' => true,
        		'labels' => $labels,
        		'show_ui' => true,
        		'show_admin_column' => false,
                'show_in_nav_menus' => true,
        		'update_count_callback' => '_update_post_term_count',
        		'query_var' => true,
        		'rewrite' => array( 'slug' => $setup3_pointposttype_pt4p,'hierarchical'=>true),
        		'sort' => true,
        	  ));
        }
    /**
    *End: Item Types Taxonomy
    **/



    /**
    *Start: Locations Taxonomy
    **/
        if($setup3_pointposttype_pt5_check == 1){
        	  $labels = array(
        		'name' => ''.$setup3_pointposttype_pt5.'',
        		'singular_name' => ''.$setup3_pointposttype_pt5.'',
        		'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt5),
        		'popular_items' => sprintf(esc_html__( 'Popular %s', 'pointfindert2d' ),$setup3_pointposttype_pt5),
        		'all_items' => sprintf(esc_html__( 'All %s', 'pointfindert2d' ),$setup3_pointposttype_pt5),
        		'parent_item' => null,
        		'parent_item_colon' => null,
        		'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt5s),
        		'update_item' => sprintf(esc_html__( 'Update %s', 'pointfindert2d' ),$setup3_pointposttype_pt5s),
        		'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt5s),
        		'new_item_name' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt5s),
        		'separate_items_with_commas' => sprintf(esc_html__( 'Separate %s with commas', 'pointfindert2d' ),$setup3_pointposttype_pt5),
        		'add_or_remove_items' => sprintf(esc_html__( 'Add or remove %s', 'pointfindert2d' ),$setup3_pointposttype_pt5s),
        		'choose_from_most_used' => sprintf(esc_html__( 'Choose from the most used %s', 'pointfindert2d' ),$setup3_pointposttype_pt5s),
        		'menu_name' => ''.$setup3_pointposttype_pt5.'',
        	  ); 

        	  register_taxonomy('pointfinderlocations',''.$setup3_pointposttype_pt1.'',array(
        		'hierarchical' => true,
        		'labels' => $labels,
        		'show_ui' => true,
        		'show_admin_column' => false,
                'show_in_nav_menus' => true,
        		'update_count_callback' => '_update_post_term_count',
        		'query_var' => true,
        		'rewrite' => array( 'slug' => $setup3_pointposttype_pt5p,'hierarchical'=>true ),
        	  ));
        	  
        }
    /**
    *End: Locations Taxonomy
    **/ 
    	


    /**
    *Start: Features Taxonomy
    **/	

        if($setup3_pointposttype_pt6_check == 1){
        	  $labels = array(
        		'name' => ''.$setup3_pointposttype_pt6.'',
        		'singular_name' => ''.$setup3_pointposttype_pt6.'',
        		'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pointposttype_pt6),
        		'popular_items' => sprintf(esc_html__( 'Popular %s', 'pointfindert2d' ),$setup3_pointposttype_pt6),
        		'all_items' => sprintf(esc_html__( 'All %s', 'pointfindert2d' ),$setup3_pointposttype_pt6),
        		'parent_item' => null,
        		'parent_item_colon' => null,
        		'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pointposttype_pt6s),
        		'update_item' => sprintf(esc_html__( 'Update %s', 'pointfindert2d' ),$setup3_pointposttype_pt6s),
        		'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pointposttype_pt6s),
        		'new_item_name' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pointposttype_pt6s),
        		'separate_items_with_commas' => sprintf(esc_html__( 'Separate %s with commas', 'pointfindert2d' ),$setup3_pointposttype_pt6),
        		'add_or_remove_items' => sprintf(esc_html__( 'Add or remove %s', 'pointfindert2d' ),$setup3_pointposttype_pt6s),
        		'choose_from_most_used' => sprintf(esc_html__( 'Choose from the most used %s', 'pointfindert2d' ),$setup3_pointposttype_pt6s),
        		'menu_name' => ''.$setup3_pointposttype_pt6.'',
        	  ); 

        	  register_taxonomy('pointfinderfeatures',''.$setup3_pointposttype_pt1.'',array(
        		'hierarchical' => true,
        		'labels' => $labels,
        		'show_ui' => true,
        		'show_admin_column' => false,
                'show_in_nav_menus' => true,
        		'update_count_callback' => '_update_post_term_count',
        		'query_var' => true,
        		'rewrite' => array( 'slug' => $setup3_pointposttype_pt6p,'hierarchical'=>true ),
        	  ));
          

        	}
        	 
    /**
    *End: Features Taxonomy
    **/



    /**
    *Start: Conditions Taxonomy
    **/ 

        if($setup3_pt14_check == 1){
              $labels = array(
                'name' => ''.$setup3_pt14.'',
                'singular_name' => ''.$setup3_pt14.'',
                'search_items' =>  sprintf(esc_html__( 'Search %s', 'pointfindert2d' ),$setup3_pt14),
                'popular_items' => sprintf(esc_html__( 'Popular %s', 'pointfindert2d' ),$setup3_pt14),
                'all_items' => sprintf(esc_html__( 'All %s', 'pointfindert2d' ),$setup3_pt14),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => sprintf(esc_html__( 'Edit %s', 'pointfindert2d' ),$setup3_pt14s),
                'update_item' => sprintf(esc_html__( 'Update %s', 'pointfindert2d' ),$setup3_pt14s),
                'add_new_item' => sprintf(esc_html__( 'Add New %s', 'pointfindert2d' ),$setup3_pt14s),
                'new_item_name' => sprintf(esc_html__( 'New %s', 'pointfindert2d' ),$setup3_pt14s),
                'separate_items_with_commas' => sprintf(esc_html__( 'Separate %s with commas', 'pointfindert2d' ),$setup3_pt14),
                'add_or_remove_items' => sprintf(esc_html__( 'Add or remove %s', 'pointfindert2d' ),$setup3_pt14s),
                'choose_from_most_used' => sprintf(esc_html__( 'Choose from the most used %s', 'pointfindert2d' ),$setup3_pt14s),
                'menu_name' => ''.$setup3_pt14.'',
              ); 

              register_taxonomy('pointfinderconditions',''.$setup3_pointposttype_pt1.'',array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'show_in_nav_menus' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array( 'slug' => $setup3_pt14p,'hierarchical'=>true ),
              ));
          

            }
             
    /**
    *End: Conditions Taxonomy
    **/


}

/* Disable parent selection for conditions */
add_action('init', 'create_post_type_pointfinder',0);


add_action( 'admin_head-edit-tags.php', 'pfconditions_remove_parent_category' );

function pfconditions_remove_parent_category()
{
    if ( 'pointfinderconditions' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}

/**
*Start: Post Type Column Filters
**/
    /*Start:Added with v1.6.2*/
    add_action('admin_menu', 'pointfinder_remove_submenu_cpts');
    function pointfinder_remove_submenu_cpts() {
        global $submenu;
        unset($submenu['edit.php?post_type=pointfinderinvoices'][10]);
        unset($submenu['edit.php?post_type=pointfindermorders'][10]);
        unset($submenu['edit.php?post_type=pointfinderorders'][10]);
        unset($submenu['edit.php?post_type=pointfinderreviews'][10]); 
    }

    add_action('admin_head', 'pointfinder_remove_unwanted_cpts');
    function pointfinder_remove_unwanted_cpts(){
        $screen = get_current_screen();
        $setup3_pointposttype_pt11 = PFSAIssetControl('setup3_pointposttype_pt11','','testimonials');

        if (isset($screen->post_type)) {
            switch ($screen->post_type) {
                case 'pointfinderorders':
                    echo '<style type="text/css">#titlediv{margin-bottom: 10px;}.row-actions .view {display:none;}.wrap .page-title-action{display:none;}</style>';
                    break;
                case 'pointfindermorders':
                    echo '<style type="text/css">#titlediv{margin-bottom: 10px;}.row-actions .view {display:none;}.wrap .page-title-action{display:none;}</style>';
                    break;
                case 'pointfinderreviews':
                    echo '<style type="text/css">#titlediv{margin-bottom: 10px;}#edit-slug-box{display: none;}#favorite-actions {display:none;}.wrap .page-title-action{display:none;}.tablenav .bulkactions{display:none;}</style>';
                    break;
                case $setup3_pointposttype_pt11:
                    echo '<style type="text/css">#edit-slug-box{display: none;}</style>';
                    break;
            }
        }
        
    };

    function pointfinder_remove_unwanted_pra($actions, $page_object){   
        global $post;
        $setup3_pointposttype_pt11 = PFSAIssetControl('setup3_pointposttype_pt11','','testimonials');
        $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

        switch ($page_object->post_type) {
            case 'pointfindermorders':
            case 'pointfinderorders':
            case 'pointfinderinvoices':
                unset($actions['edit']);unset($actions['inline hide-if-no-js']);unset($actions['edit_as_new_draft']);
                break;
            case 'pointfinderreviews':
                unset($actions['view']);
                unset($actions['inline hide-if-no-js']);
                unset($actions['edit_as_new_draft']);
                unset( $actions['trash'] );
                $actions['trash'] = "<a class='submitdelete' title='" . esc_attr(esc_html__('Delete this item permanently','pointfindert2d')) . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . esc_html__('Delete','pointfindert2d') . "</a>";
                if ($post->post_status == 'pendingapproval') {
                    $actions['view'] = "<a class='submitdelete' title='" . esc_attr(esc_html__('Publish this item permanently','pointfindert2d')) . "' href='" . admin_url("edit.php?post_type=pointfinderreviews&publishrevid=".$post->ID) . "'>" . esc_html__('Publish','pointfindert2d') . "</a>";
                }
                break;
            case $setup3_pointposttype_pt11:
                unset($actions['view']);
                break;
            case $setup3_pointposttype_pt1:
                unset($actions['inline hide-if-no-js']);
                if ($post->post_status == 'pendingapproval' || $post->post_status == 'pendingpayment') {
                    $actions['inline'] = "<a class='submitdelete' title='" . esc_attr(esc_html__('Publish this item permanently','pointfindert2d')) . "' href='" . admin_url("edit.php?post_type=".$setup3_pointposttype_pt1."&publishitemid=".$post->ID) . "'>" . esc_html__('Publish','pointfindert2d') . "</a>";
                }
                break;
        }
        return $actions;
    }
    add_filter('page_row_actions', 'pointfinder_remove_unwanted_pra', 10, 2);

    function pointfinder_unwanted_remove_meta_box($post_type) {
        $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

        switch ($post_type) {
            case 'pfmembershippacks':
                remove_meta_box( 'mymetabox_revslider_0', 'pfmembershippacks', 'normal' );
                break;
            case 'pointfinderorders':
                remove_meta_box( 'submitdiv', 'pointfinderorders','side');
                remove_meta_box( 'slugdiv', 'pointfinderorders','normal');
                remove_meta_box( 'mymetabox_revslider_0', 'pointfinderorders', 'normal' );
                break;
            case 'pointfindermorders':
                remove_meta_box( 'submitdiv', 'pointfindermorders','side');
                remove_meta_box( 'slugdiv', 'pointfindermorders','normal');
                remove_meta_box( 'mymetabox_revslider_0', 'pointfindermorders', 'normal' );
                break;
            case $setup3_pointposttype_pt1:
                remove_meta_box( 'authordiv', $setup3_pointposttype_pt1, 'normal' );
                remove_meta_box( 'mymetabox_revslider_0', $setup3_pointposttype_pt1, 'normal' );
                break;
            case 'pointfinderreviews':
                remove_meta_box( 'submitdiv', 'pointfinderreviews','side');
                remove_meta_box( 'slugdiv', 'pointfinderreviews','normal');
                remove_meta_box( 'mymetabox_revslider_0', 'pointfinderreviews', 'normal' );
                break;
            case 'pointfinderinvoices':
                remove_meta_box( 'submitdiv', 'pointfinderinvoices','side');
                remove_meta_box( 'slugdiv', 'pointfinderinvoices','normal');
                remove_meta_box( 'mymetabox_revslider_0', 'pointfinderinvoices', 'normal' );
                break;
        }
    }
    add_action( 'add_meta_boxes', 'pointfinder_unwanted_remove_meta_box', 10,1);
    /*End:Added with v1.6.2*/


    get_template_part('admin/estatemanagement/ptfilters/pfitems-pt','filters');
    get_template_part('admin/estatemanagement/ptfilters/review-pt','filters');
    get_template_part('admin/estatemanagement/ptfilters/orders-pt','filters');
    get_template_part('admin/estatemanagement/ptfilters/invoices-pt','filters');
/**
*End: Post Type Column Filters
**/


/**
*Start: Post Type Listing Page Works
**/


    add_action( 'admin_head-edit.php', 'pointfinder_admin_head_custompost_listing' );
    function pointfinder_admin_head_custompost_listing() {
        global $post_type;
        
        /* Main post type filters */
        $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
        if($post_type == $setup3_pointposttype_pt1){
            $setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
            $setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
            $pftaxarray = array('pointfinderltypes');
            if($setup3_pointposttype_pt4_check == 1){$pftaxarray[] = 'pointfinderitypes';}  
            if($setup3_pointposttype_pt5_check == 1){$pftaxarray[] = 'pointfinderlocations';}
            
            
            if (PFASSIssetControl('st8_ncptsys','',0) != 1) {
                require_once( get_template_directory().'/admin/estatemanagement/taxonomy-filter-class.php');
                new Tax_CTP_Filter(array($setup3_pointposttype_pt1 => $pftaxarray));
            }

            /* One click item approval */
            if (isset($_GET['publishitemid']) && current_user_can( 'activate_plugins' )) {
               if (!empty($_GET['publishitemid'])) {
                    $itemid = sanitize_text_field($_GET['publishitemid']);
                    if (get_post_status($itemid) != 'publish') {
                        wp_update_post(array('ID' => $itemid, 'post_status' => 'publish'));
                    }
               }
            }

        }

        /* One click review approval */
        if ($post_type == 'pointfinderreviews') {
            if (isset($_GET['publishrevid']) && current_user_can( 'activate_plugins' )) {
               if (!empty($_GET['publishrevid'])) {
                    $revid = sanitize_text_field($_GET['publishrevid']);
                    if (get_post_status($revid) != 'publish') {
                        wp_update_post(array('ID' => $revid, 'post_status' => 'publish'));
                    }
               }
            }
        }

    }

    /* Additional Filters
    add_action( 'admin_head-post.php', 'pointfinder_admin_head_post_editing' );
    add_action( 'admin_head-post-new.php',  'pointfinder_admin_head_post_new' );

    function pointfinder_admin_head_post_editing() {
        //edit
    }

    function pointfinder_admin_head_post_new() {
      //edit
    }
    */

/**
*End: Post Type Listing Page Works
**/

?>