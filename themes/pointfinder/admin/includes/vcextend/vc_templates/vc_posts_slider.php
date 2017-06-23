<?php
$output = $title = $type = $count = $interval = $slides_content = $link = '';
$custom_links = $thumb_size = $posttypes = $posts_in = $categories = '';
$orderby = $order = $el_class = $link_image_start = '';
extract(shortcode_atts(array(
    'title' => '',
    'type' => '',
    'count' => 3,
    'interval' => 5000,
    'slides_content' => '',
    'slides_title' => '',
    'link' => 'link_post',
    'custom_links' => site_url().'/',
    'thumb_size' => 'full',
    'posttypes' => 'post',
    'posts_in' => '',
    'categories' => '',
    'orderby' => NULL,
    'order' => 'DESC',
    'el_class' => '',
	'mode' => 'fade',
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
	'numbered_pagination' => ''
), $atts));

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass($el_class);

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

// Post types
$pt = array();
if ( $posttypes != '' ) {
    $posttypes = explode(",", $posttypes);
    foreach ( $posttypes as $post_type ) {
        array_push($pt, $post_type);
    }
    $query_args['post_type'] = $pt;
}

// Narrow by categories
if ( $categories != '' ) {
    $categories = explode(",", $categories);
    $gc = array();
    foreach ( $categories as $grid_cat ) {
        array_push($gc, $grid_cat);
    }
    $gc = implode(",", $gc);
    ////http://snipplr.com/view/17434/wordpress-get-category-slug/
    $query_args['category_name'] = $gc;

    $taxonomies = get_taxonomies('', 'object');
    $query_args['tax_query'] = array('relation' => 'OR');
    foreach ( $taxonomies as $t ) {
        if ( in_array($t->object_type[0], $pt) ) {
            $query_args['tax_query'][] = array(
                'taxonomy' => $t->name,//$t->name,//'portfolio_category',
                'terms' => $categories,
                'field' => 'slug',
            );
        }
    }
}

/* Order posts*/
if ( $orderby != NULL ) {
    $query_args['orderby'] = $orderby;
}
$query_args['order'] = $order;

// Run query
$my_query = new WP_Query($query_args);

$pretty_rel_random = 'rel-'.rand();
if ( $link == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
$teasers = '';
$i = -1;

while ( $my_query->have_posts() ) {
    $i++;
    $my_query->the_post();
    $post_title = the_title("", "", false);
    $post_id = $my_query->post->ID;
    //$teaser_post_type = 'posts_slider_teaser_'.$my_query->post->post_type . ' ';
    if ( $slides_content == 'teaser' ) {
        $content = apply_filters('the_excerpt', get_the_excerpt());//get_the_excerpt();
    } else {
        $content = '';
    }
    $thumbnail = '';

    // Thumbnail logic
    $post_thumbnail = $p_img_large = '';

    $post_thumbnail = wpb_getImageBySize(array( 'post_id' => $post_id, 'thumb_size' => $thumb_size ));
    $thumbnail = $post_thumbnail['thumbnail'];
    $p_img_large = $post_thumbnail['p_img_large'];

    // if ( $thumbnail == '' ) $thumbnail = esc_html__("No Featured image set.", "pointfindert2d");

    // Link logic
    if ( $link != 'link_no' ) {
        if ( $link == 'link_post' ) {
            $link_image_start = '<a class="link_image" href="'.get_permalink($post_id).'" title="'.sprintf( esc_html__( 'Permalink to %s', 'pointfindert2d' ), the_title_attribute( 'echo=0' ) ).'">';
        }
        else if ( $link == 'link_image' ) {
            $p_video = get_post_meta($post_id, "_p_video", true);
            //
            if ( $p_video != "" ) {
                $p_link = $p_video;
            } else {
                $p_link = $p_img_large[0]; // TODO!!!
            }
            $link_image_start = '<a class="link_image prettyphoto" href="'.$p_link.'" title="'.the_title_attribute('echo=0').'" >';
        }
        else if ( $link == 'custom_link' ) {
            if (isset($custom_links[$i])) {
                $slide_custom_link = $custom_links[$i];
            } else {
                $slide_custom_link = $custom_links[0];
            }
            $link_image_start = '<a class="link_image" href="'.$slide_custom_link.'">';
        }

        $link_image_end = '</a>';
    } else {
        $link_image_start = '';
        $link_image_end = '';
    }

    $description = '';
    if ( $slides_content != '' && $content != '' ) {
        $description = '<div class="pf-slider-caption">';
        if ($slides_title==true) $description .= '<h2 class="post-title">' . $link_image_start . $post_title . $link_image_end .'</h2>';
        $description .= $content;
        $description .= '</div>';
    }

    $teasers .= $el_start . $link_image_start . $thumbnail . $link_image_end . $description . $el_end;
} // endwhile loop
wp_reset_postdata();

if ( $teasers ) { $teasers = $slides_wrap_start. $teasers . $slides_wrap_end; }
else { $teasers = esc_html__("Nothing found." , "pointfindert2d"); }

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_posts_slider wpb_content_element'.$el_class, $this->settings['base']);

$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_posts_slider_heading'));
$output .= '<div class="wpb_gallery_slides pf_posts_sliderWrapper">'.$teasers.'</div>';
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');
$output .= '
<script type="text/javascript">
(function($) {
	"use strict";
	$(function() {
		$("#'.$myrandno.'").owlCarousel({
				items : 1,';
				if($hide_prev_next_buttons !== 'yes'){ $output .= 'navigation : true,';}else{$output .= 'navigation : false,';}
				if($numbered_pagination === 'yes'){ $output .= 'paginationNumbers : true,';}else{$output .= 'paginationNumbers : false,';}
				if($hide_pagination_control !== 'yes'){ $output .= 'pagination : true,';}else{$output .= 'pagination : false,';}
				if($autoplay === 'yes'){ $output .= 'autoPlay : true,stopOnHover : true,';}else{$output .= 'autoPlay : false,';}
				$output .= 'slideSpeed:'.$interval.',
				mouseDrag:true,
				touchDrag:true,
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

echo $output;