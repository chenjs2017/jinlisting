<?php
/**********************************************************************************************************************************
*
* VC Templates
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

/* Remove all premade templates. */
add_filter( 'vc_load_default_templates', 'pointfinder_custom_template_modify_array' );
function pointfinder_custom_template_modify_array($data) {
    return array();
}


// Add homepage template
add_action('vc_load_default_templates_action','pointfinder_custom_template_for_vc');
function pointfinder_custom_template_for_vc() {

    $data               = array();
    $data['name']       = esc_html__( 'Blank Page with Right Sidebar', 'pointfindert2d' );
    $data['weight']     = 0; // Weight of your template in the template list
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1418308024667{padding-top: 50px !important;padding-bottom: 50px !important;}"][vc_column width="3/4"][/vc_column][vc_column width="1/4"][vc_widget_sidebar sidebar_id="pointfinder-widget-area"][/vc_column][/vc_row]
CONTENT;
 
    vc_add_default_templates( $data );


    $data               = array();
    $data['name']       = esc_html__( 'Blank Page with Left Sidebar', 'pointfindert2d' );
    $data['weight']     = 0; // Weight of your template in the template list
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1418308024667{padding-top: 50px !important;padding-bottom: 50px !important;}"][vc_column width="1/4"][vc_widget_sidebar sidebar_id="pointfinder-widget-area"][/vc_column][vc_column width="3/4"][/vc_column][/vc_row]
CONTENT;
 
    vc_add_default_templates( $data );


    $data               = array();
    $data['name']       = esc_html__( 'Full Width Page', 'pointfindert2d' );
    $data['weight']     = 0; // Weight of your template in the template list
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1418308024667{padding-top: 50px !important;padding-bottom: 50px !important;}"][vc_column width="1/1" css=""][/vc_column][/vc_row]
CONTENT;
 
    vc_add_default_templates( $data );


    $data               = array();
    $data['name']       = esc_html__( '100% Width Page', 'pointfindert2d' );
    $data['weight']     = 0; // Weight of your template in the template list
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1418308024667{padding-top: 50px !important;padding-bottom: 50px !important;}" widthopt="yes"][vc_column width="1/1" css=""][/vc_column][/vc_row]
CONTENT;
 
    vc_add_default_templates( $data );
}

?>