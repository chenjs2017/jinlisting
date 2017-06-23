<?php

/**********************************************************************************************************************************
*
* Common functions for posts
* 
* Author: Webbu Design
* Please do not modify below functions.
***********************************************************************************************************************************/

function pf_singlepost_title(){
   echo '<div class="post-mtitle">'.get_the_title().'</div>';
}

function pf_singlepost_title_list(){
    
    echo '<div class="post-mtitle" ><a href="'.get_the_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></div>';
}

function pf_singlepost_thumbnail(){
    if ( has_post_thumbnail() && wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) !== false) { 

        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        if ($large_image_url[1]>=850) {
            $large_image_urlforview = aq_resize($large_image_url[0],850,267,true);
            $csstext = '';

            if ($large_image_urlforview == false) {
                $large_image_urlforview = $large_image_url[0];
            }
        }else{
            $large_image_urlforview = aq_resize($large_image_url[0],$large_image_url[1],267,true);

            if ($large_image_urlforview == false) {
                $large_image_urlforview = $large_image_url[0];
            }
            
            $csstext = ' style="width:100%" ';
        }
        $output = '<div class="post-mthumbnail"><div class="inner-postmthumb">';
        $output .= '<a href="' . $large_image_url[0] . '" rel="prettyPhoto">';
            $output .= '<img src="'.$large_image_urlforview.'" class="attachment-full wp-post-image pf-wp-postimg"'.$csstext.' />';
            $output .= '<div class="PStyleHe"></div>';
        $output .= '</a>';
        $output .= '</div></div>';
        echo $output;
    }
}

function pf_singlepost_thumbnail_list(){
    if ( has_post_thumbnail() && wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) !== false) { 

        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        if ($large_image_url[1]>=850) {
            $large_image_urlforview = aq_resize($large_image_url[0],850,267,true);
            $csstext = '';

            if ($large_image_urlforview == false) {
                $large_image_urlforview = $large_image_url[0];
            }
        }else{
            $large_image_urlforview = aq_resize($large_image_url[0],$large_image_url[1],267,true);
            $csstext = ' style="width:100%" ';

            if ($large_image_urlforview == false) {
                $large_image_urlforview = $large_image_url[0];
            }
        }
        $output = '<div class="post-mthumbnail"><div class="inner-postmthumb">';
        $output .= '<a href="' . get_the_permalink() . '">';
            $output .= '<img src="'.$large_image_urlforview.'" class="attachment-full wp-post-image pf-wp-postimg"'.$csstext.' />';
            $output .= '<div class="PStyleHe"></div>';
        $output .= '</a>';
        $output .= '</div></div>';
        echo $output;
    }
}

function pf_singlepost_thumbnail_list_small(){
    if ( has_post_thumbnail() && wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) !== false) { 

        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
        $large_image_url_out = aq_resize($large_image_url[0],680,270,true);
        if ($large_image_url_out == false) {
            $large_image_url_out = $large_image_url[0];
        }
     

        $output = '<div class="post-mthumbnail"><div class="pflist-imagecontainer">';
            $output .= '<img src="'.$large_image_url_out.'" class="attachment-full wp-post-image pf-wp-smallthumbpost"/>';
            $output .= '
                <div class="pfImageOverlayH hidden-xs"></div>
                    <div class="pfButtons pfStyleV2 pfStyleVAni hidden-xs">
                        <span class="pfHoverButtonStyle pfHoverButtonWhite pfHoverButtonSquare clearfix">
                            <a class="pficon-imageclick" href="'.$large_image_url[0].'" rel="prettyPhoto">
                                <i class="pfadmicon-glyph-684"></i>
                            </a>
                        </span>
                        <span class="pfHoverButtonStyle pfHoverButtonWhite pfHoverButtonSquare">
                            <a href="' . get_the_permalink() . '">
                                <i class="pfadmicon-glyph-794"></i>
                            </a>
                        </span>
                    </div>
            ';
        $output .= '</div></div>';

        echo $output;
    }
}

function pf_singlepost_info(){
    $cats_arr = get_the_category();
    echo '<div class="post-minfo"><i class="pfadmicon-glyph-28"></i>';
    echo get_the_time(get_option('date_format')).' / ';
    echo comments_popup_link( '', '<i class="pfadmicon-glyph-382"></i> '.esc_html__( '1 Comment / ', 'pointfindert2d' ), '<i class="pfadmicon-glyph-382"></i> '.esc_html__( '% Comments / ', 'pointfindert2d' ),'', '');
    echo esc_html__( 'by ', 'pointfindert2d' );
    echo the_author_posts_link();
    echo get_the_tags('/ <i class="pfadmicon-glyph-22"></i>',', ','');
    echo (PFControlEmptyArr($cats_arr))? ' / '.esc_html__( 'in ', 'pointfindert2d' )  : '';
    echo the_category(', ');
    echo '</div>'; 
}


function pf_singlepost_info_list(){
    $cats_arr = get_the_category();
    echo '<div class="post-minfo"><i class="pfadmicon-glyph-28"></i>';
    echo get_the_time(get_option('date_format')).' / ';
    echo comments_popup_link( '', '<i class="pfadmicon-glyph-382"></i> '.esc_html__( '1 Comment / ', 'pointfindert2d' ), '<i class="pfadmicon-glyph-382"></i> '.esc_html__( '% Comments / ', 'pointfindert2d' ),'', '');
    echo esc_html__( 'by ', 'pointfindert2d' );
    echo the_author_posts_link();
    echo get_the_tags('/ <i class="pfadmicon-glyph-22"></i>',', ','');
    echo (PFControlEmptyArr($cats_arr))? ' / '.esc_html__( 'in ', 'pointfindert2d' )  : '';
    echo the_category(', ');

    echo '<div class="meta-comment-link pull-right">';
    echo '<a class="pull-right post-link" href="'.get_the_permalink().'" title="'.get_the_title().'">'.esc_html__('Read more','pointfindert2d').'&nbsp;<i class="pfadmicon-glyph-858"></i></a>';
    echo '</div>';

    echo '</div>';   
}



function pf_singlepost_content(){
	

	if ( has_shortcode( get_the_content(), 'gallery' ) ) {

		$gallery = get_post_gallery(get_the_id(),false);
		if (isset($gallery['ids'])) {
			$gallery_ids = explode(',', $gallery['ids']);

			if (is_array($gallery_ids)) {
			
			$gridrandno_orj = PF_generate_random_string_ig();
			echo '<div class="vc-image-carousel">';
			echo '<ul id="'.$gridrandno_orj.'" class="pf-gallery-slider">';

				foreach ($gallery_ids as $gallery_id) {

					$large_image_url = wp_get_attachment_image_src( $gallery_id, 'full' );
                    $large_image_url_out = aq_resize($large_image_url[0],680,270,true);
			        echo '<li>
                    <div class="pflist-imagecontainer">
                    <img src="'.$large_image_url_out.'" alt=""/>
                    <div class="pfImageOverlayH hidden-xs"></div>
                    <div class="pfButtons pfStyleV2 pfStyleVAni hidden-xs">
                        <span class="pfHoverButtonStyle pfHoverButtonWhite pfHoverButtonSquare clearfix">
                            <a class="pficon-imageclick" href="'.$large_image_url[0].'" rel="prettyPhoto">
                                <i class="pfadmicon-glyph-684"></i>
                            </a>
                        </span>
                        <span class="pfHoverButtonStyle pfHoverButtonWhite pfHoverButtonSquare">
                            <a href="' . get_the_permalink() . '">
                                <i class="pfadmicon-glyph-794"></i>
                            </a>
                        </span>
                    </div>
                    </div>
                    </li>';

				}
			
			echo '</ul>';
			echo '</div>';
			?>
			<script type="text/javascript">
			(function($) {
				"use strict";
				$(function() {
					$("#<?php echo $gridrandno_orj;?>").owlCarousel({
							items : 1,
							navigation : true,
							paginationNumbers : false,
							pagination : false,
							autoPlay : false,
							slideSpeed:7000,
							mouseDrag:true,
							touchDrag:true,
							itemSpaceWidth: 10,
							autoHeight : false,
							responsive:true,
							transitionStyle: 'fade', 
							itemsScaleUp : false,
							navigationText:false,
							theme:"owl-theme",
							singleItem : true,
							itemsCustom : true,
							itemsDesktop : [1199,1],
							itemsDesktopSmall : [980,1],
							itemsTablet: [768,1],
							itemsTabletSmall: false,
							itemsMobile : [479,1],

						});
				});

			})(jQuery);
			</script>
	        <?php
	        }
		}

	}


    echo '<div class="post-content">';
    echo pointfinderwp_excerpt_single();
    echo '</div>';
    echo '<script type="text/javascript">
		  jQuery(document).ready(function(){
		    jQuery(".post-content").fitVids();
		  });
		  </script>';
}


function pf_singlepost_content_list(){
    echo '<div class="post-content clearfix">';
    echo pointfinderwp_excerpt();
    echo '</div>';
}



function pf_singlepost_comments(){
    echo '<div class="pfsinglecommentheader" id="comments">';
        if ( comments_open() ){
           ob_start();
           comments_popup_link( esc_html__('No comments yet','pointfindert2d'), esc_html__('1 comment','pointfindert2d'), esc_html__('% comments','pointfindert2d'), 'comments-link', esc_html__('Comments are off for this post','pointfindert2d'));
           $clink = ob_get_contents();
           ob_end_clean();
        }else{
           $clink = esc_html__('Comments','pointfindert2d');
        };
        echo '
        <div class="pf-singlepost-clink">'.$clink.'</div>';

    echo '</div>';
    echo '<div class="pftcmcontainer singleblogcomments">';
        comments_template();
    echo '</div>';
}
?>