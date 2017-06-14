<?php
add_shortcode( 'pftext_separator', 'pf_textseparator_func' );
function pf_textseparator_func( $atts,$content ) {
    extract(shortcode_atts(array(
        'title' => '',
        'title_align' => '',
    ), $atts));
    $class = "pf_pageh_title";

    $class .= ($title_align!='') ? ' pf_'.$title_align : '';
    $output = '<div class="'.$class.'">';	
    	if($title!=''){
            $output .= '<div class="pf_pageh_title_inner">'.$title.'</div>';
        }
    $output .= '</div>';
    return $output;
}
?>