<article id="post-<?php the_ID(); ?>" <?php post_class('pointfinder-post'); ?>>
    
    <?php 
    pf_singlepost_thumbnail(); 
    pf_singlepost_title();
    
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
                    echo '<li><img src="'.$large_image_url[0].'" /></li>';

                }
            
            echo '</ul>';
            echo '</div>';
            ?>
            <script type="text/javascript">(function($) {"use strict";
                $(function() {
                    $("#<?php echo $gridrandno_orj;?>").owlCarousel({items : 1,navigation : true,paginationNumbers : false,pagination : false,autoPlay : false,slideSpeed:7000,mouseDrag:true,touchDrag:true,itemSpaceWidth: 10,autoHeight : false,responsive:true,transitionStyle: 'fade', itemsScaleUp : false,navigationText:false,theme:"owl-theme",singleItem : true,itemsCustom : true,itemsDesktop : [1199,1],itemsDesktopSmall : [980,1],itemsTablet: [768,1],itemsTabletSmall: false,itemsMobile : [479,1]});
                });
            })(jQuery);</script>
            <?php
            }
        }

    }


    echo '<div class="post-content">';
    
    remove_shortcode('gallery');
    $output = do_shortcode(get_the_content('' . esc_html__('Read more', 'pointfindert2d') . ''));
    $output = preg_replace('/\[gallery(.*?)\]/', '', $output);
    $output = apply_filters('convert_chars', $output);
    $output = apply_filters('the_content', $output);
    
    echo $output;

    
    echo '</div>';
    $defaults = array(
        'before'           => '<p>' . esc_html__( 'Pages:', 'pointfindert2d' ),
        'after'            => '</p>',
        'link_before'      => '',
        'link_after'       => '',
        'next_or_number'   => 'number',
        'separator'        => ' ',
        'nextpagelink'     => esc_html__( 'Next page', 'pointfindert2d' ),
        'previouspagelink' => esc_html__( 'Previous page', 'pointfindert2d' ),
        'pagelink'         => '%',
        'echo'             => 1
    );

    wp_link_pages( array(
    'before'      => '<div class="pf-page-links"><span class="pf-page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
    'after'       => '</div>',
    'link_before' => '<span>',
    'link_after'  => '</span>',
    ) );
    echo '<script type="text/javascript">jQuery(document).ready(function(){jQuery(".post-content").fitVids();});</script>';

    pf_singlepost_info();
    pf_singlepost_comments();
    ?>
    
</article>