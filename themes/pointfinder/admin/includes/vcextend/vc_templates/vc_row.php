<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$el_class = $full_height = $full_width = $equal_height = $atts_new = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$output = $after_output = $myoutput = $widthopt = $footerrow = $colorfortext = $colorfortexth = '';


$attsex = vc_map_get_attributes( $this->getShortcode(), $atts );
$atts = array_merge($atts,$attsex);
extract(shortcode_atts(array(
    'columns_placement' => '',
    'full_height' => '',
    'equal_height' => '',
    'gap' => '',
    'content_placement' => '',
    'video_bg' => '',
    'video_bg_url' => '',
    'video_bg_parallax' => '',
    'parallax'        => '',
    'parallax_image'        => '',
    'el_id'        => '',
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
    'css' => '',
    'gbfooterrow' => '',
    'pgfooterrow' => ''
), $atts));

/* Start: Pointfinder Full Width Fix */
    if ($widthopt === 'yes') {
        $full_width = 'stretch_row_content_no_spaces';
    }
/* End: Pointfinder Full Width Fix */

wp_enqueue_style( 'js_composer_front' );


/* Start: Pointfinder Footer Row */
    if($footerrow == 'yes' || $gbfooterrow == 'yes' || $pgfooterrow == 'yes'){
        if ($footerrow == 'yes') {
            $footer_text = ' id="pf-footer-row"';
            $footer_ex_classes = ' pointfinderexfooterclass';
            $footer_ex_classes2 = ' pointfinderexfooterclassx';
            $myoutput = '<script>
            (function($) {
            "use strict";
            $(document).ready(function(){
                $(".pointfinderexfooterclass a").hover(function(){
                    $(this).css({ color: "'.$colorfortexth.'"});
                }, function(){
                    $(this).css({ color: "'.$colorfortext.'"});
                });
                $(".pointfinderexfooterclass").css("color","'.$colorfortext.'!important");
                $(".pointfinderexfooterclass a").css("color","'.$colorfortext.'!important");
            });
           
            })(jQuery);
            </script>';
            $output .= $myoutput;
        }elseif ($pgfooterrow == 'yes') {
            $footer_text = ' id="pf-footer-row"';
            $footer_ex_classes = ' pointfinderexfooterclasspg';
            $footer_ex_classes2 = ' pointfinderexfooterclassxpg';
        }elseif ($gbfooterrow == 'yes') {
            $footer_text = ' id="pf-footer-row"';
            $footer_ex_classes = ' pointfinderexfooterclassgb';
            $footer_ex_classes2 = ' pointfinderexfooterclassxgb';
        }
    }else{
        $footer_text = $footer_ex_classes = $footer_ex_classes2 = '';
    }
/* End: Pointfinder Footer Row */


$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
    'vc_row',
    'wpb_row', //deprecated
    'vc_row-fluid',
    $el_class,
    vc_shortcode_custom_css_class( $css ),
);


if (function_exists('vc_shortcode_custom_css_has_property')) {
    if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
        $css_classes[]='vc_row-has-fill';
    }
}

if (!empty($atts['gap'])) {
    $css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
    $wrapper_attributes[] = 'data-vc-full-width="true"';
    $wrapper_attributes[] = 'data-vc-full-width-init="false"';
    if ( 'stretch_row_content' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
    } elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
        $css_classes[] = 'vc_row-no-padding';
    }
    //$after_output .= '<div class="vc_row-full-width"></div>';
}

if ( ! empty( $full_height ) ) {
    $css_classes[] = ' vc_row-o-full-height';
    if ( ! empty( $columns_placement ) ) {
        $flex_row = true;
        $css_classes[] = ' vc_row-o-columns-' . $columns_placement;
    }
}

if ( ! empty( $equal_height ) ) {
    $flex_row = true;
    $css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
    $flex_row = true;
    $css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
    $css_classes[] = ' vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

if ( $has_video_bg ) {
    $parallax = $video_bg_parallax;
    $parallax_image = $video_bg_url;
    $css_classes[] = ' vc_video-bg-container';
    wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
    wp_enqueue_script( 'vc_jquery_skrollr_js' );
    $wrapper_attributes[] = 'data-vc-parallax="1.5"'; // parallax speed
    $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
    if ( false !== strpos( $parallax, 'fade' ) ) {
        $css_classes[] = 'js-vc_parallax-o-fade';
        $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
    } elseif ( false !== strpos( $parallax, 'fixed' ) ) {
        $css_classes[] = 'js-vc_parallax-o-fixed';
    }
}

if ( ! empty( $parallax_image ) ) {
    if ( $has_video_bg ) {
        $parallax_image_src = $parallax_image;
    } else {
        $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
        $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
        if ( ! empty( $parallax_image_src[0] ) ) {
            $parallax_image_src = $parallax_image_src[0];
        }
    }
    $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}

$fixedbg_text = ($fixedbg != '') ? ' pf-fixed-background' : '' ;

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) .$fixedbg_text.$footer_ex_classes2. '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
if($widthopt !== 'yes' && 'stretch_row_content_no_spaces' !== $full_width ){  
    $output .= '<div'.$footer_text.' class="pf-container'.$footer_ex_classes.'">';
    $output .= '<div class="pf-row">';
    $output .= wpb_js_remove_wpautop( $content );
    $output .= '</div>';
    $output .= '</div>';
}else{
    $output .= '<div'.$footer_text.' class="pf-fullwidth'.$footer_ex_classes.'">';
    $output .= wpb_js_remove_wpautop( $content );
    $output .= '</div>';
}
$output .= '</div>';
$output .= $after_output;


echo $output;
