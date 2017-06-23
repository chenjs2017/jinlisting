<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $colorfortext = $padding = $margin_bottom = $css = '';
/*
        Array
(
    [full_width] = stretch_row
    [full_height] = yes
    [content_placement] = middle
    [video_bg] = yes
    [video_bg_url] = https://www.youtube.com/watch?v=lMJXxhRFO1k
    [video_bg_parallax] = 
    [parallax] = 
    [parallax_image] = 
    [el_id] = 123123123
    [el_class] = 3221321
    [css] = 
)

*/
$attsex = vc_map_get_attributes( $this->getShortcode(), $atts );

extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'widthopt'        => '',
    'fixedbg'         => '',
    'footerrow'       => '',
    'full_width' => false,
    'colorfortext' => '',
    'colorfortexth' => '',
    'css' => ''
), $atts));

$wrapper_attributes = '';
if (isset($attsex['el_id'])) {
    if (!empty($attsex['el_id'])) {
        $wrapper_attributes = 'id="' . esc_attr( $attsex['el_id'] ) . '"';
    }
}

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

if($footerrow == 'yes'){
    $footer_text = ' id="pf-footer-row"';
    $footer_ex_classes = ' pointfinderexfooterclass';
    $footer_ex_classes2 = ' pointfinderexfooterclassx';
    $myoutput = '<style>#pf-footer-row.pointfinderexfooterclass a{color:'.$colorfortext.'!important}#pf-footer-row.pointfinderexfooterclass a:hover{color:'.$colorfortexth.'!important}</style>';
    $output .= $myoutput;
}else{
    $footer_text = $footer_ex_classes = $footer_ex_classes2 = '';
}

$el_class = $this->getExtraClass($el_class);
$fixedbg_text = ($fixedbg != '') ? ' pf-fixed-background' : '' ;

$vc_version_current = pointfinder_get_vc_version();
if (version_compare($vc_version_current, '4.8') >= 0) {
    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
    $style = ' style="color:'.$colorfortext.'!important"';
}else{
    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class().$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
    $style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $colorfortext, $padding, $margin_bottom);
}

$output .= '<div '.$wrapper_attributes.' class="'.$css_class.$fixedbg_text.$footer_ex_classes2.'';
if ( $full_width == 'stretch_row_content_no_spaces' ){ $output .= ' vc_row-no-padding'; };
$output .= '"';
if ( ! empty( $full_width ) ) {
    $output .= ' data-vc-full-width="true"';
    if ( $full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces' ) {
        $output .=  ' data-vc-stretch-content="true"';
    }
}
$output .= $style.'>';
if($widthopt !== 'yes'){
    $output .= "\n\t\t".'<div'.$footer_text.' class="pf-container'.$footer_ex_classes.'">';
    $output .= "\n\t\t".'<div class="pf-row">';
    $output .= wpb_js_remove_wpautop($content);
    $output .= "\n\t\t".'</div>';
    $output .= "\n\t\t".'</div>';
}else{
    $output .= "\n\t\t".'<div'.$footer_text.' class="pf-fullwidth'.$footer_ex_classes.' clearfix">';
    $output .= wpb_js_remove_wpautop($content);
    $output .= "\n\t\t".'</div>';
}

$output .= '</div>'.$this->endBlockComment('row');
echo $output;