<?php
$output = $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $interval = '';
extract(shortcode_atts(array(
    'title' => '',
    'type' => '#444',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'pfgrid' => 'grid4',
    'images' => '',
    'el_class' => '',
    'interval' => '5',
), $atts));
$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass($el_class);
$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}


$setupsizelimitconf_general_gridsize2_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','width',555);
$setupsizelimitconf_general_gridsize2_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize2','height',416);

$setupsizelimitconf_general_gridsize3_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','width',360);
$setupsizelimitconf_general_gridsize3_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize3','height',270);

$setupsizelimitconf_general_gridsize4_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','width',263);
$setupsizelimitconf_general_gridsize4_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize4','height',197);


switch($pfgrid){
	case 'grid2':
		$pfgrid_output = 'pf2col';
		$pfgridcol_output = 'col-lg-6 col-md-6 col-sm-6';
		$featured_image_width = $setupsizelimitconf_general_gridsize2_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize2_height*$pf_retnumber;
		break;
	case 'grid3':
		$pfgrid_output = 'pf3col';
		$pfgridcol_output = 'col-lg-4 col-md-6 col-sm-6';
		$featured_image_width = $setupsizelimitconf_general_gridsize3_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize3_height*$pf_retnumber;
		break;
	case 'grid4':
		$pfgrid_output = 'pf4col';
		$pfgridcol_output = 'col-lg-3 col-md-4 col-sm-6';
		$featured_image_width = $setupsizelimitconf_general_gridsize4_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize4_height*$pf_retnumber;
		break;
	default:
		$pfgrid_output = 'pf4col';
		$pfgridcol_output = 'col-lg-3 col-md-4 col-sm-6';
		$featured_image_width = $setupsizelimitconf_general_gridsize4_width*$pf_retnumber;
		$featured_image_height = $setupsizelimitconf_general_gridsize4_height*$pf_retnumber;
	break;
}
		
		
$el_start = '<li class="pfgallery-item '.$pfgridcol_output.'"><div class="pfgallery-inner">';
$el_end = '</div></li>';
$slides_wrap_start = '<ul class="pf_image_grid_ul pf-row '.$pfgrid_output.' clearfix">';
$slides_wrap_end = '</ul>';


if ( $onclick == 'link_image' ) {
    if(!wp_script_is('theme-PrettyPhoto', 'enqueued')){wp_enqueue_script( 'theme-PrettyPhoto' );};
    if(!wp_style_is('theme-prettyphoto', 'enqueued')){wp_enqueue_style('theme-prettyphoto');};
}

if ( $images == '' ) $images = '-1,-2,-3';

$pretty_rel_random = ' rel="prettyPhoto[rel-'.rand().']"'; //rel-'.rand();

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
$images = explode( ',', $images);
$i = -1;

foreach ( $images as $attach_id ) {
    $i++;
    if ($attach_id > 0) {
        $post_thumbnail = wp_get_attachment_image_src( $attach_id, 'full' );//wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => 'full' ));
    }
    else {
        $thumbnail = '<img src="'.$this->assetUrl('vc/no_image.png').'" />';
        $p_img_large = $this->assetUrl('vc/no_image.png');
    }

	$thumbnail = aq_resize($post_thumbnail[0],$featured_image_width,$featured_image_height,true);
	if($thumbnail === false) {
		if($general_retinasupport == 1){
			$thumbnail = aq_resize($post_thumbnail[0],$featured_image_width/2,$featured_image_height/2,true);
			if($thumbnail === false) {
				$thumbnail = $post_thumbnail[0];
			}
		}else{
			$thumbnail = $post_thumbnail[0];
		}
		
	}
    $p_img_large = $post_thumbnail[0];
    $link_start = $link_end = '';

    if ( $onclick == 'link_image' ) {
        $link_start = '<a class="prettyphoto wbp_vc_gallery_pfwrapper clearfix" href="'.$p_img_large.'"'.$pretty_rel_random.'>';
        $link_end = '<div class="PStyleHe"></div></a>';
    }
    else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
        $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . ' class="wbp_vc_gallery_pfwrapper">';
        $link_end = '<div class="PStyleHe"></div></a>';
    }
    $gal_images .= $el_start . $link_start . '<img src="'.$thumbnail.'" alt="">' . $link_end . $el_end;
}
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element'.$el_class.' vc_clearfix', $this->settings['base']);
$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
if($title!=''){
$output .= '<h2 class="wpb_heading wpb_gallery_heading" style="color:'.$type.'">'.$title.'</h2>';
}
$output .= '<div class="wpb_pf_gallery_slides pf_image_grid pf-container">'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');

echo $output;