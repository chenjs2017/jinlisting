<?php
global $vc_teaser_box;
$posts_query = $el_class = $args = $my_query = $speed = $swiper_options = '';
$content = $link = $layout = $thumb_size = $link_target =  $wrap = '';
$autoplay = $hide_pagination_control = $hide_prev_next_buttons = $title = '';
$posts = array();
extract(shortcode_atts(array(
    'el_class' => '',
    'posts_query' => '',
    'speed' => '300',
    'swiper_options' => '',
	'thumb_size' => 'grid4',
    'wrap' => '',
    'autoplay' => 'no',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'layout' => 'thumbnail,title,excerpt',
    'link_target' => '',
    'thumb_size' => 'thumbnail',
    'title' => '',
	'numbered_pagination' => '',
	'itembox_bg' => '',
	'itembox_font' => '',
), $atts));
$itemboxstyle = 'style="';
if($itembox_bg != '' ){
	$itemboxstyle .= 'background:'.$itembox_bg.'; ';
}else{
	$itemboxstyle .= 'background: rgba(255,255,255,0.7); ';
}

if($itembox_font != '' ){
	$itemboxstyle .= 'color:'.$itembox_font.'; ';
}else{
	$itemboxstyle .= 'color:#494949; ';
}
$itemboxstyle .= '"';

$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}
					
$setupsizelimitconf_general_gridsize2_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','width',555);
$setupsizelimitconf_general_gridsize2_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','height',416);

$setupsizelimitconf_general_gridsize3_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','width',360);
$setupsizelimitconf_general_gridsize3_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','height',270);

$setupsizelimitconf_general_gridsize4_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','width',263);
$setupsizelimitconf_general_gridsize4_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','height',197);

switch($thumb_size){

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
$thumb_size = $featured_image_width.'x'.$featured_image_height;

list($args, $my_query) = vc_build_loop_query($posts_query); //
$teaser_blocks = vc_sorted_list_parse_value($layout);
while ( $my_query->have_posts() ) {
    $my_query->the_post(); // Get post from query
    $post = new stdClass(); // Creating post object.
    $post->id = get_the_ID();
    $post->link = get_permalink($post->id);
    $post->post_type = get_post_type();

    if($vc_teaser_box->getTeaserData('enable', $post->id) === '1') {
        $post->custom_user_teaser = true;
        $data = $vc_teaser_box->getTeaserData('data', $post->id);
        if(!empty($data)){$data = json_decode($data);};
        $post->bgcolor = $vc_teaser_box->getTeaserData('bgcolor', $post->id );
        $post->custom_teaser_blocks = array();
        $post->title_attribute = the_title_attribute('echo=0');

        if(!empty($data)){
            foreach($data as $block) {
                $settings = array();
                if($block->name === 'title') {
                    $post->title = the_title("", "", false);
                } elseif($block->name === 'image') {
                    if($block->image === 'featured') {
                        $post->thumbnail_data = $this->getPostThumbnail($post->id, $thumb_size);
                    } elseif(!empty($block->image)) {
                        $post->thumbnail_data = wpb_getImageBySize(array('attach_id' => (int)$block->image, 'thumb_size' => $thumb_size));
                    } else {
                        $post->thumbnail_data = false;
                    }
                    $post->thumbnail = $post->thumbnail_data && isset($post->thumbnail_data['thumbnail']) ? $post->thumbnail_data['thumbnail'] : '';
                    $post->image_link =  empty($video) && $post->thumbnail && isset($post->thumbnail_data['p_img_large'][0]) ? $post->thumbnail_data['p_img_large'][0] : $video;
                } elseif($block->name === 'text') {
                    if($block->mode === 'custom') {
                        $settings[] = 'text';
                        $post->content = $block->text;
                    } elseif($block->mode === 'excerpt') {
                        $settings[] = $block->mode;
                        $post->excerpt = $this->getPostExcerpt();
                    } else {
                        $settings[] = $block->mode;
                        $post->content = $this->getPostContent();
                    }
                }
                if(isset($block->link)) {
                    if($block->link === 'post') {
                        $settings[] = 'link_post';
                    } elseif($block->link === 'big_image') {
                        $settings[] = 'link_image';
                    } else {
                        $settings[] = 'no_link';
                    }
                    $settings[] = '';
                }
				
                $post->custom_teaser_blocks[] = array($block->name, $settings,);
            }
        }
    } else {
		//Array ( [thumbnail] => 3640110857_db80356eba_b [p_img_large] => Array ( [0] => http://192.168.2.3/realtor/wp-content/uploads/2014/03/3640110857_db80356eba_b-700x466.jpg [1] => 700 [2] => 466 [3] => 1 ) )
        $post->custom_user_teaser = false;
        $post->title = the_title("", "", false);
        $post->title_attribute = the_title_attribute('echo=0');
        $post->post_type = get_post_type();
        $post->content = $this->getPostContent();
        $post->excerpt = $this->getPostExcerpt();
        if(has_post_thumbnail( $post->id )){
            $post->thumbnail_data = $this->getPostThumbnail( $post->id, $thumb_size );
            $post->thumbnail = $post->thumbnail_data && isset($post->thumbnail_data['thumbnail']) ? $post->thumbnail_data['thumbnail'] : '';
        }else{
            $post->thumbnail_data = array();
            $post->thumbnail = '';
        }

        
        $video = get_post_meta($post->id, "_p_video", true);
        $post->image_link =  empty($video) && $post->thumbnail && isset($post->thumbnail_data['p_img_large'][0]) ? $post->thumbnail_data['p_img_large'][0] : $video;
    }

    $post->categories_css = $this->getCategoriesCss($post->id);

    $posts[] = $post;
}
wp_reset_postdata();
$tmp_options = vc_parse_options_string($swiper_options, $this->shortcode, 'swiper_options');
$this->setLinktarget($link_target);


$options = array();
// Convert keys to Camel case.
foreach($tmp_options as $key => $value) {
    $key = preg_replace('/_([a-z])/e', "strtoupper('\\1')", $key);
    $options[$key] = $value;
}
if((int)$autoplay > 0) {$options['autoplay'] = (int)$autoplay;};


$css_class = $this->settings['base'].' vc_carousel_'.(empty($el_class) ? '' : ' '.$el_class);
$carousel_id = 'vc-carousel-'.WPBakeryShortCode_Vc_Carousel::getCarouselIndex();
?>
<div class="<?php echo apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base']) ?>">
    <div class="wpb_wrapper">
        <?php echo  wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading')) ?>
        <div id="<?php echo $carousel_id ?>" class="vc-carousel vc-slide">
            
            
            <!-- Wrapper for slides -->
            <div class="vc-carousel-inner">
           
                <div class="vc-carousel-slideline"><div class="vc-carousel-slideline-inner" id="<?php 
					$myrandno = rand(1, 99999999999);
					$myrandno = md5($myrandno);
					echo $myrandno;
				?>">
                <?php foreach($posts as $post): ?>
                <?php
                $blocks_to_build = $post->custom_user_teaser === true ? $post->custom_teaser_blocks :  $teaser_blocks;
                $block_style = isset($post->bgcolor) ? ' style="background-color: '.$post->bgcolor.'"' : '';
                ?>
                <div class="vc-item vc_slide_<?php echo $post->post_type ?>"<?php echo $block_style ?>>
                    <div class="vc-inner">
                    	<div class="vc-inner-div" <?php echo $itemboxstyle?>>
                        <?php foreach($blocks_to_build as $block_data): ?>
                        <?php include $this->getBlockTemplate() ?>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div></div>
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
(function($) {
	"use strict";
	$(function() {
		$("#<?php echo $myrandno;?>").owlCarousel({
				items : <?php echo $pf_grid_size ?>,
				<?php if($numbered_pagination !== 'yes'){ echo 'navigation : true,';}else{echo 'navigation : false,';}?>
				<?php if($numbered_pagination == 'yes'){ echo 'paginationNumbers : true,';}else{echo 'paginationNumbers : false,';}?>
				<?php if($hide_pagination_control !== 'yes'){ echo 'pagination : true,';}else{echo 'pagination : false,';}?>
				<?php if($autoplay == 'yes'){ echo 'autoPlay : true,stopOnHover : true,';}else{echo 'autoPlay : false,';}?>
				slideSpeed:<?php echo $speed; ?>,
				singleItem : false,
				mouseDrag:true,
				touchDrag:true,
				autoHeight : false,
				responsive:true,
				itemsScaleUp : false,
				navigationText:false,
                itemsDesktop : [1199,<?php echo $pf_grid_size ?>],
                itemsDesktopSmall : [980,<?php echo $pf_grid_size ?>],
                itemsTablet: [768,<?php echo $pf_grid_size ?>],
                itemsTabletSmall: false,
                itemsMobile : [479,1],
				theme:"owl-theme"
			});
	});

})(jQuery);
</script>
<?php return; ?>