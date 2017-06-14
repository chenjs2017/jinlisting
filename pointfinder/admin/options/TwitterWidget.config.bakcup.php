<?php
/**********************************************************************************************************************************
*
* Point Finder Twitter Widget
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if ( ! class_exists( 'Redux' ) ) {
    return;
}

$opt_name = "pftwitterwidget_options";
$args = array(
    'opt_name'             => $opt_name,
    'display_name'         =>  esc_html__('Point Finder Twitter Widget','pointfindert2d'),
    'menu_type'            => 'submenu',
    'page_parent'          => 'pointfinder_tools',
    'allow_sub_menu'       => false,
    'menu_title'           => esc_html__('Twitter Widget Config','pointfindert2d'),
    'page_title'           => esc_html__('Twitter Widget Config', 'pointfindert2d'),
    'admin_bar'            => false,
    'global_variable'      => '',
    'admin_bar_priority'   => 50,
    'dev_mode'             => false,
    'update_notice'        => false,
    'customizer'           => false,
    'page_priority'        => null,
    'page_parent'          => 'pointfinder_tools',
    'page_permissions'     => 'manage_options',
    'menu_icon'            => 'dashicons-twitter',
    'page_slug'            => '_pftwitteroptions',
    'save_defaults'        => false,
    'default_show'         => false,
    'default_mark'         => '',
    'show_import_export'   => true,
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => false,
    'output_tag'           => false,
    'database'             => '',
    'use_cdn'              => false,
    'hide_reset'           => true,
    'system_info'          => false,
);

Redux::setArgs( $opt_name, $args );


Redux::setSection( $opt_name, array(
    'id' => 'setuptwitter_widget',
    'title' => esc_html__('Twitter Widget', 'pointfindert2d'),
    'icon' => 'el-icon-twitter',
    'fields' => array(
        array(
            'id' => 'setuptwitterwidget_general_help',
            'type' => 'info',
            'notice' => true,
            'style' => 'info',
            'desc' => esc_html__('Please check help docs for setup below settings.', 'pointfindert2d')
        ) ,

        array(
            'id' => 'setuptwitterwidget_conkey',
            'type' => 'text',
            'title' => esc_html__('Consumer Key', 'pointfindert2d') ,
        ) ,
        array(
            'id' => 'setuptwitterwidget_consecret',
            'type' => 'text',
            'title' => esc_html__('Consumer Secret', 'pointfindert2d') ,
        ),

        array(
            'id' => 'setuptwitterwidget_acckey',
            'type' => 'text',
            'title' => esc_html__('Access Token Key', 'pointfindert2d') ,
        ) ,
        array(
            'id' => 'setuptwitterwidget_accsecret',
            'type' => 'text',
            'title' => esc_html__('Access Token Secret', 'pointfindert2d') ,
        ), 

    )
    
) );