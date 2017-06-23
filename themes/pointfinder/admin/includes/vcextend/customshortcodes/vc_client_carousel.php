<?php
add_shortcode( 'pf_clientcarousel', 'pf_clientcarousel_func' );
function pf_clientcarousel_func( $atts ) {
$output = $title =  $onclick = $custom_links = $img_size = $custom_links_target = $images = '';
$autoplay = $autocrop = $customsize = $hide_pagination_control =  $speed ='';
extract(shortcode_atts(array(
    'title' => '',
    'onclick' => 'link_no',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'grid4',//Change
    'images' => '',
	'hide_borders' => '',
	'autocrop' => '',
	'customsize' => '',
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'numbered_pagination' => '',
    'speed' => '5000'
), $atts));

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$pretty_rand = $onclick == 'link_image' ? rand() : '';


$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}

$setupsizelimitconf_general_gridsize2_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','width',555);
$setupsizelimitconf_general_gridsize2_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','height',416);

$setupsizelimitconf_general_gridsize3_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','width',360);
$setupsizelimitconf_general_gridsize3_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','height',270);

$setupsizelimitconf_general_gridsize4_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','width',263);
$setupsizelimitconf_general_gridsize4_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','height',197);



switch($img_size){
	case 'grid2':
		$pf_grid_size = 2;
		$featured_image_width = $setupsizelimitconf_general_gridsize2_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize2_height*$pf_retnumber;
		break;
	case 'grid3':
		$pf_grid_size = 3;
		$featured_image_width = $setupsizelimitconf_general_gridsize3_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize3_height*$pf_retnumber;
		break;
	case 'grid4':
		$pf_grid_size = 4;
		$featured_image_width = $setupsizelimitconf_general_gridsize4_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize4_height*$pf_retnumber;
		break;
	case 'grid5':
		$pf_grid_size = 5;
		$featured_image_width = $setupsizelimitconf_general_gridsize4_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize4_height*$pf_retnumber;
		break;
	default:
		$pf_grid_size = 4;
		$featured_image_width = $setupsizelimitconf_general_gridsize4_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize4_height*$pf_retnumber;
	break;
}

if($customsize!=''){
	$customsize = explode('x',$customsize);
	if(is_array($customsize)){
		$featured_image_width = $customsize[0]*$pf_retnumber;
		$featured_image_height = $customsize[1]*$pf_retnumber;
	}
}
$myrandno = rand(1, 99999999999);
$myrandno = md5($myrandno);

if($pf_grid_size > 1){ $pfstyletext = 'pf-vcimage-carousel'; }else{$pfstyletext = '';}
if ( $images == '' ) $images = '-1,-2,-3';

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }

$images = explode( ',', $images);
$i = -1;
$css_class =  'wpb_images_carousel wpb_content_element';
$carousel_id = 'vc-images-carousel-'.$myrandno;
$output_text = '
<div class="'.$css_class.'">
    <div class="wpb_wrapper">';
	$output_text .=  wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading')) ;
	$output_text .= '
        <div id="'.$carousel_id.'"  class="vc-slide vc-image-carousel pf-client-carousel vc-image-carousel-'.$pf_grid_size.'">
            <!-- Wrapper for slides -->
            <div class="vc-carousel-inner">
            	
                <div class="vc-carousel-slideline"><div class="vc-carousel-slideline-inner" id="'.$myrandno.'">';?>
                    <?php foreach($images as $attach_id): ?>
                    <?php
                    $i++;
                    if ($attach_id > 0) {
                        $post_thumbnail = wp_get_attachment_image_src( $attach_id, 'full' );
                    }
                    else {
                        $thumbnail = get_template_directory_uri().'/images/noimg.png';
        				$p_img_large = get_template_directory_uri().'/images/noimg.png';
                    }
				   if($featured_image_width > 0){
					   
					   if($autocrop === 'yes'){
                   	   	   $thumbnail = aq_resize($post_thumbnail[0],$featured_image_width,false);
						   if($thumbnail === false) {
								if($general_retinasupport == 1){
									$thumbnail = aq_resize($post_thumbnail[0],$featured_image_width/2,false);
									if($thumbnail === false) {
										$thumbnail = $post_thumbnail[0];
									}
								}else{
									$thumbnail = $post_thumbnail[0];
								}
								
							}
					   }else{
					   	   $thumbnail = aq_resize($post_thumbnail[0],$featured_image_width,$featured_image_height,true);
						   if($thumbnail === false) {
								if($general_retinasupport == 1){
									$thumbnail = aq_resize($post_thumbnail[0],$featured_image_width/2,$featured_image_height/2,false);
									if($thumbnail === false) {
										$thumbnail = $post_thumbnail[0];
									}
								}else{
									$thumbnail = $post_thumbnail[0];
								}
								
							}
					   
					   }

				   }else{
					   $thumbnail = $post_thumbnail[0];
				   }
   				   $p_img_large = $post_thumbnail[0];
                   
                   $output_text .=' <div class="vc-item"><div class="vc-inner"';?> <?php if($hide_borders !== 'yes'){$output_text .= ' style="border:1px solid rgba(60,60,60,0.07)"';}
                   $output_text .= '>';
                     if ($onclick == 'link_image'){
                        $p_img_large = $post_thumbnail[0];
                        $output_text .= '<a class="prettyphoto wbp_vc_gallery_pfwrapper '.$pfstyletext.'" href="'.$p_img_large.'" rel="prettyPhoto[rel-'.$pretty_rand.']">
                        <div class="pf-pad-area">
                            <img src="'.$thumbnail.'" alt="">
                        <div class="PStyleHe"></div></div></a>';
						}elseif($onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != ''){ 
                        $output_text .= '<a href="'.$custom_links[$i].'"'.(!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '').' class="wbp_vc_gallery_pfwrapper '.$pfstyletext.'">
                            <img src="'.$thumbnail.'" alt="">
                        <div class="PStyleHe2"></div></a>';
                    }else{ 
                        $output_text .= '<img src="'.$thumbnail.'" alt="" class="'.$pfstyletext.'">';
                    }; 
                   $output_text .=' </div></div>';
                   endforeach;
                    $output_text .='
                </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
(function($) {
	"use strict";
	$(function() {
		$("#'.$myrandno.'").owlCarousel({
				items : '.$pf_grid_size .',';
				 if($hide_prev_next_buttons !== "yes"){ $output_text .= 'navigation : true,';}else{$output_text .= "navigation : false,";}
				 if($numbered_pagination === "yes"){ $output_text .= 'paginationNumbers : true,';}else{$output_text .= "paginationNumbers : false,";}
				 if($hide_pagination_control !== "yes"){ $output_text .= 'pagination : true,';}else{$output_text .= "pagination : false,";}
				 if($autoplay == "yes"){ $output_text .= 'autoPlay : true,stopOnHover : true,';}else{$output_text .= 'autoPlay : false,';}
				 $output_text .='
				slideSpeed:'.$speed.',
				mouseDrag:true,
				touchDrag:true,
				itemSpaceWidth: 10,';
				if($autoplay === "yes"){ $output_text .= 'itemBorderWidth : 0,';}else{$output_text .= 'itemBorderWidth : '.$pf_grid_size.',';}
				$output_text .='
				autoHeight : false,
				responsive:true,
				itemsScaleUp : false,
				navigationText:false,
				theme:"owl-theme",
				singleItem : false,
			});
	});

})(jQuery);
</script>';
return $output_text;
 }?>