<?php
add_shortcode( 'pf_testimonials', 'pf_testimonials_func' );
function pf_testimonials_func( $atts ) {
$output = $title = $count = $interval = $posts_in = '';
$orderby = $order = $mode = $el_class = '';
extract(shortcode_atts(array(
    'title' => '',
    'count' => 3,
    'interval' => 5000,
    'slides_title' => '',
    'posts_in' => '',
    'orderby' => NULL,
    'order' => 'DESC',
	'mode' => 'backSlide',
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
), $atts));

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$setup3_pointposttype_pt11 = PFSAIssetControl('setup3_pointposttype_pt11','','testimonials');
	$myrandno = rand(1, 99999999999);
	$myrandno = md5($myrandno);
				
    $el_start = '<div class="pfslides-item">';
    $el_end = '</div>';
    $slides_wrap_start = '<div class="pfslides" id="'.$myrandno.'">';
    $slides_wrap_end = '</div>';

$query_args = array();

//exclude current post/page from query
if ( $posts_in == '' ) {
    global $post;
    $query_args['post__not_in'] = array($post->ID);
}
else if ( $posts_in != '' ) {
    $query_args['post__in'] = explode(",", $posts_in);
}

// Post teasers count
if ( $count != '' && !is_numeric($count) ) $count = -1;
if ( $count != '' && is_numeric($count) ) $query_args['posts_per_page'] = $count;

// Post type
$query_args['post_type'] = $setup3_pointposttype_pt11;



// Order posts
if ( $orderby != NULL ) {
    $query_args['orderby'] = $orderby;
}
$query_args['order'] = $order;

// Run query
$my_query = new WP_Query($query_args);

$pretty_rel_random = 'rel-'.rand();
$teasers = '';
$i = -1;

while ( $my_query->have_posts() ) {
    $i++;
    $my_query->the_post();
    $post_title = the_title("", "", false);
    $post_id = $my_query->post->ID;
    $content = apply_filters('the_content', get_the_excerpt());
    
    $description = '';
    
	// Content start.
	$description = '<div class="pf-testslider-content">';
	$description .= $content;
	$description .= '<div class="pf-test-arrow"> </div>';
	$description .= '<div class="pf-test-icon"></div><div class="pf-test-name">'.$post_title.'</div>';
	$description .= '</div>';
	// Content end

    $teasers .= $el_start  . $description . $el_end;
} // endwhile loop
wp_reset_postdata();

if ( $teasers ) { $teasers = $slides_wrap_start. $teasers . $slides_wrap_end; }
else { $teasers = esc_html__("Nothing found." , "pointfindert2d"); }

$css_class = 'pf_testimonials ';

$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .=  wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_posts_slider_heading'));
$output .= '<div class="pf_testimonials_sliderWrapper">'.$teasers.'';
$output .= '</div>';
$output .= "\n\t\t".'</div> ';
$output .= "\n\t".'</div> ';
if($count > 1){
$output .= '
<script type="text/javascript">
(function($) {
	"use strict";
	$(function() {
		$("#'.$myrandno.'").owlCarousel({
				items : 1,
				navigation : false,
				pagination : false,
				autoPlay : true,stopOnHover : true,
				slideSpeed:'.$interval.',
				paginationNumbers : false,
				mouseDrag:false,
				touchDrag:false,
				autoHeight : false,
				responsive:true,
				transitionStyle: "'.$mode.'", 
				itemsScaleUp : false,
				navigationText:false,
				theme:"owl-theme"
				,singleItem : true,
				itemsCustom : true,
				itemsDesktop : [1199,1],
				itemsDesktopSmall : [980,1],
				itemsTablet: [768,1],
				itemsTabletSmall: false,
				itemsMobile : [479,1],
			});
	});

})(jQuery);
</script>';
}
return $output;
}