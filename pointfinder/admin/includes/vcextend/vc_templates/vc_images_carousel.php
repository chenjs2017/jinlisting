<?php
$output = $title =  $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = '';
$mode = $wrap = $autoplay = $autocrop = $customsize = $hide_pagination_control = $hide_prev_next_buttons = $speed ='';
extract(shortcode_atts(array(
    'title' => '',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'grid4',//Change
    'images' => '',
    'el_class' => '',
	'autocrop' => '',
	'customsize' => '',
    'mode' => 'fade',
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'speed' => '5000',
	'numbered_pagination' => ''
	
), $atts));

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$pretty_rand = $onclick == 'link_image' ? rand() : '';

$el_class = $this->getExtraClass($el_class);

$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}

$setupsizelimitconf_general_gridsize2_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','width',555);
$setupsizelimitconf_general_gridsize2_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','height',416);

$setupsizelimitconf_general_gridsize3_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','width',360);
$setupsizelimitconf_general_gridsize3_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','height',270);

$setupsizelimitconf_general_gridsize4_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','width',263);
$setupsizelimitconf_general_gridsize4_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','height',197);

switch($img_size){
	case 'grid1':
		$pf_grid_size = 1;
		$featured_image_width = 0;
		$featured_image_height = 0;
		break;
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


if($pf_grid_size > 1){ $pfstyletext = 'pf-vcimage-carousel'; }else{$pfstyletext = '';}
if ( $images == '' ) $images = '-1,-2,-3';

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }

$images = explode( ',', $images);
$i = -1;
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_images_carousel wpb_content_element'.$el_class.' vc_clearfix', $this->settings['base']);
$carousel_id = 'vc-images-carousel-'.WPBakeryShortCode_VC_images_carousel::getCarouselIndex();
$slider_width = $this->getSliderWidth($img_size);
?>
<div class="<?php echo apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base']) ?>">
    <div class="wpb_wrapper">
        <?php echo  wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading')) ?>
        <div id="<?php echo $carousel_id ?>"  class="vc-slide vc-image-carousel vc-image-carousel-<?php echo $pf_grid_size;?>">
            <?php if($pf_grid_size == 1){$pf_classtext = 'pf1gridslider';}else{$pf_classtext = '';}?>
            <!-- Wrapper for slides -->
            <div class="vc-carousel-inner<?php echo ' '.$pf_classtext;?>">
            	
                <div class="vc-carousel-slideline"><div class="vc-carousel-slideline-inner" id="<?php 
					$myrandno = rand(1, 99999999999);
					$myrandno = md5($myrandno);
					echo $myrandno;
				?>">
                    <?php foreach($images as $attach_id): ?>
                    <?php
                    $i++;
                    if ($attach_id > 0) {
                        $post_thumbnail = wp_get_attachment_image_src( $attach_id, 'full' );//wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
                    }
                    else {
                        $thumbnail = '<img src="'.$this->assetUrl('vc/no_image.png').'" />';
        				$p_img_large = $this->assetUrl('vc/no_image.png');
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
                    ?>
                    <div class="vc-item"><div class="vc-inner">
                    <?php if ($onclick == 'link_image'){ ?>
                        <?php $p_img_large = $post_thumbnail[0]; ?>
                        <a class="prettyphoto wbp_vc_gallery_pfwrapper <?php echo $pfstyletext?>" href="<?php echo $p_img_large ?>" <?php echo ' rel="prettyPhoto[rel-'.$pretty_rand.']"' ?>>
                        <div class="pf-pad-area">
                            <?php echo '<img src="'.$thumbnail.'" alt="">' ?>
                        <div class="PStyleHe"></div></div></a>
                    <?php }elseif($onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != ''){ ?>
                        <a href="<?php echo $custom_links[$i] ?>"<?php echo (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') ?> class="wbp_vc_gallery_pfwrapper <?php echo $pfstyletext?>">
                            <?php echo '<img src="'.$thumbnail.'" alt="">' ?>
                        <div class="PStyleHe"></div></a>
                    <?php }else{ ?>
                        <?php echo '<img src="'.$thumbnail.'" alt="" class="'.$pfstyletext.'">' ?>
                    <?php }; ?>
                    </div></div>
                    <?php endforeach; ?>
                    
                </div>
                
                </div>
            </div>
        </div>
    </div><?php echo $this->endBlockComment('.wpb_wrapper') ?>
</div><?php echo $this->endBlockComment('.wpb_images_carousel') ?>
<script type="text/javascript">
(function($) {
	"use strict";
	$(function() {
		$("#<?php echo $myrandno;?>").owlCarousel({
				items : <?php echo $pf_grid_size ?>,
				<?php if($hide_prev_next_buttons !== 'yes'){ echo 'navigation : true,';}else{echo 'navigation : false,';}?>
				<?php if($numbered_pagination === 'yes'){ echo 'paginationNumbers : true,';}else{echo 'paginationNumbers : false,';}?>
				<?php if($hide_pagination_control !== 'yes'){ echo 'pagination : true,';}else{echo 'pagination : false,';}?>
				<?php if($autoplay == 'yes'){ echo 'autoPlay : true,stopOnHover : true,';}else{echo 'autoPlay : false,';}?>
				slideSpeed:<?php echo $speed; ?>,
				mouseDrag:true,
				touchDrag:true,
				itemSpaceWidth: 10,
				autoHeight : false,
				responsive:true,
				transitionStyle: '<?php echo $mode; ?>', 
				itemsScaleUp : false,
				navigationText:false,
				theme:"owl-theme"
				<?php if($pf_grid_size == 1){?>
				,singleItem : true,
				itemsCustom : true,
				itemsDesktop : [1199,1],
				itemsDesktopSmall : [980,1],
				itemsTablet: [768,1],
				itemsTabletSmall: false,
				itemsMobile : [479,1],
				<?php }else{?>
				,singleItem : false,
				<?php }?>
			});
	});

})(jQuery);
</script>