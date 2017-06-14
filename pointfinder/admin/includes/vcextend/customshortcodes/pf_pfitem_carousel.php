<?php
add_shortcode( 'pf_pfitemcarousel', 'pf_pfitemcarousel_func' );
function pf_pfitemcarousel_func( $atts ) {
$output = $title =  $onclick = $custom_links = $img_size = $custom_links_target = $images = '';
$autoplay = $autocrop = $customsize = $hide_pagination_control =  $speed = $zeropadding ='';
extract(shortcode_atts(array(
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'speed' => '500',
    'zeropadding' => '',
    'listingtype' => '',
	'itemtype' => '',
	'conditions' => '',
	'locationtype' => '',
	'posts_in' => '',
	'sortby' => 'ASC',
	'orderby' => 'title',
	'cols' => 4,
	'features'=>array(),
	'itemboxbg' => '',
	'featureditems'=>'',
	'featureditemshide' => '',
	'itemlimit' => 20,
	'related' => 0
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

$myrandno = rand(1, getrandmax());
$myrandno = md5($myrandno);
$carousel_id = 'vc-images-carousel-'.$myrandno;

$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');
$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);

$gridrandno_orj = PF_generate_random_string_ig();
$gridrandno = 'pf_'.$gridrandno_orj;

$listingtype_x = PFEX_extract_type_ig($listingtype);
$itemtype_x = ($setup3_pointposttype_pt4_check == 1) ? PFEX_extract_type_ig($itemtype) : '' ;
$conditions_x = ($setup3_pointposttype_pt4_check == 1) ? PFEX_extract_type_ig($conditions) : '' ;
$locationtype_x = ($setup3_pointposttype_pt5_check == 1) ? PFEX_extract_type_ig($locationtype) : '' ;
$features_x = ($setup3_pointposttype_pt6_check == 1) ? PFEX_extract_type_ig($features) : '' ;

$wpflistdata = "<div class='pflistgridview".$gridrandno_orj."-container pflistgridviewgr-container'>";

/* Get admin values */
$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');


//Container & show check
$pfcontainerdiv = 'pflistgridview'.$gridrandno_orj.'';
$pfcontainershow = 'pflistgridviewshow'.$gridrandno_orj.'';


//Defaults
$pfgrid = '';
$pfitemboxbg = '';		

$pfgetdata = array();
$pfgetdata['sortby'] = $sortby;
$pfgetdata['orderby'] = $orderby;
$pfgetdata['posts_in'] = $posts_in;

$pfgetdata['cols'] = $cols;
$pfgetdata['itemboxbg'] = $itemboxbg;
$pfgetdata['listingtype'] = $listingtype_x;
$pfgetdata['itemtype'] = $itemtype_x;
$pfgetdata['conditions'] = $conditions_x;
$pfgetdata['locationtype'] = $locationtype_x;
$pfgetdata['features'] = $features_x;	
$pfgetdata['featureditems'] = $featureditems;
$pfgetdata['featureditemshide'] = $featureditemshide;

if($pfgetdata['cols'] != ''){$pfgrid = 'grid'.$pfgetdata['cols'];}


$args = array( 'post_type' => $setup3_pointposttype_pt1, 'post_status' => 'publish');
$args['posts_per_page'] = $itemlimit;

if($pfgetdata['posts_in']!=''){
	$args['post__in'] = pfstring2BasicArray($pfgetdata['posts_in']);
}

if(isset($args['meta_query']) == false || isset($args['meta_query']) == NULL){
	$args['meta_query'] = array();
}	

if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
	$args['tax_query'] = array();
}


if ($related == 1) {
	$the_current_post_id = get_the_id();
	if(!empty($the_current_post_id)){$args['post__not_in'] = array($the_current_post_id);}
	$agent_id = redux_post_meta("pointfinderthemefmb_options", $the_current_post_id, "webbupointfinder_item_agents");

	$re_li_4 = PFSAIssetControl('re_li_4','','0');
	
	//Agent Filter for Related Listings
	if(!empty($agent_id) && $re_li_4 == 1){
		$args['meta_query'][] = array(
			'key' => 'webbupointfinder_item_agents',
			'value' => $agent_id,
			'compare' => '=',
			'type' => 'NUMERIC'
		);
	}
}


$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');

$review_system_statuscheck = PFREVSIssetControl('setup11_reviewsystem_check','','0');

if(is_array($pfgetdata)){

	// listing type
	if($pfgetdata['listingtype'] != ''){
		$pfvalue_arr_lt = PFGetArrayValues_ld($pfgetdata['listingtype']);
		$fieldtaxname_lt = 'pointfinderltypes';
		$args['tax_query'][]=array(
			'taxonomy' => $fieldtaxname_lt,
			'field' => 'id',
			'terms' => $pfvalue_arr_lt,
			'operator' => 'IN'
		);
	}


	if($setup3_pointposttype_pt4_check == 1){
		// location type
		if($pfgetdata['locationtype'] != ''){
			$pfvalue_arr_loc = PFGetArrayValues_ld($pfgetdata['locationtype']);
			$fieldtaxname_loc = 'pointfinderlocations';
			$args['tax_query'][]=array(
				'taxonomy' => $fieldtaxname_loc,
				'field' => 'id',
				'terms' => $pfvalue_arr_loc,
				'operator' => 'IN'
			);
		}
	}

	if($setup3_pointposttype_pt5_check == 1){
		// item type
		if($pfgetdata['itemtype'] != ''){
			$pfvalue_arr_it = PFGetArrayValues_ld($pfgetdata['itemtype']);
			$fieldtaxname_it = 'pointfinderitypes';
			$args['tax_query'][]=array(
				'taxonomy' => $fieldtaxname_it,
				'field' => 'id',
				'terms' => $pfvalue_arr_it,
				'operator' => 'IN'
			);
		}
	}

	if($setup3_pointposttype_pt6_check == 1){
		// features type
		if($pfgetdata['features'] != ''){
			$pfvalue_arr_fe = PFGetArrayValues_ld($pfgetdata['features']);
			$fieldtaxname_fe = 'pointfinderfeatures';
			$args['tax_query'][]=array(
				'taxonomy' => $fieldtaxname_fe,
				'field' => 'id',
				'terms' => $pfvalue_arr_fe,
				'operator' => 'IN'
			);
		}
	}

	/* Condition */
	$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);
	if($setup3_pt14_check == 1){
		if($pfgetdata['conditions'] != ''){
			$pfvalue_arr_it = PFGetArrayValues_ld($pfgetdata['conditions']);
			$fieldtaxname_it = 'pointfinderconditions';
			$args['tax_query'][] = array(
				'taxonomy' => $fieldtaxname_it,
				'field' => 'id',
				'terms' => $pfvalue_arr_it,
				'operator' => 'IN'
			);
		}
	}


	if ($zeropadding !== "yes") {
		$itemspacebetween = 17;
		$pfitemboxbg = ' style="background-color:'.$pfgetdata['itemboxbg'].';"';
	}else{
		$itemspacebetween = 0;
		$pfitemboxbg = ' style="background-color:'.$pfgetdata['itemboxbg'].'; margin:0!important"';
	}

	
	$meta_key_featured = 'webbupointfinder_item_featuredmarker';
	

	if($pfgetdata['orderby'] == 'date' || $pfgetdata['orderby'] == 'title'){
		$args['orderby'] = array('meta_value_num' => 'DESC' , $pfgetdata['orderby'] => $pfgetdata['sortby']);
		$args['meta_key'] = $meta_key_featured;
	}

	

	//Featured items filter
	if($pfgetdata['featureditems'] == 'yes'){
		$args['meta_query'][] = array(
			'key' => 'webbupointfinder_item_featuredmarker',
			'value' => 1,
			'compare' => '=',
			'type' => 'NUMERIC'
		);
	}

	//Featured items filter
	if($pfgetdata['featureditemshide'] == 'yes'){
		$args['orderby'] = array($pfgetdata['orderby'] => $pfgetdata['sortby']);
		$args['meta_value'] = '0';
		$args['meta_type'] = 'NUMERIC';
		$args['meta_compare'] = '=';
	}	
}


/* On/Off filter for items */
	$args['meta_query'][] = array('relation' => 'OR',
		array(
			'key' => 'pointfinder_item_onoffstatus',
			'compare' => 'NOT EXISTS'
			
		),
		array(
	            'key'=>'pointfinder_item_onoffstatus',
	            'value'=> 0,
	            'compare'=>'=',
	            'type' => 'NUMERIC'
	    )
	    
	);



$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}
	

$setupsizelimitconf_general_gridsize1_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize1','width',440);
$setupsizelimitconf_general_gridsize1_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize1','height',330);

$featured_image_width = $setupsizelimitconf_general_gridsize1_width*$pf_retnumber;
$featured_image_height = $setupsizelimitconf_general_gridsize1_height*$pf_retnumber;

switch($pfgrid){

	case 'grid1':
		$pf_grid_size = 1;
		$pfgrid_output = 'pf1col';
		$pfgridcol_output = '';
		break;
	case 'grid2':
		$pf_grid_size = 2;
		$pfgrid_output = 'pf2col';
		$pfgridcol_output = '';
		break;
	case 'grid3':
		$pf_grid_size = 3;
		$pfgrid_output = 'pf3col';
		$pfgridcol_output = '';
		break;
	case 'grid4':
		$pf_grid_size = 4;
		$pfgrid_output = 'pf4col';
		$pfgridcol_output = '';
		break;
	default:
		$pf_grid_size = 4;
		$pfgrid_output = 'pf4col';
		$pfgridcol_output = '';
		break;
}


$loop = new WP_Query( $args );
$foundedposts = $loop->found_posts;
/*
print_r($loop->query).PHP_EOL;
echo $loop->request.PHP_EOL;
echo $loop->post_count ;
*/

//Create html codes
$pflang = PF_current_language();

$wpflistdata .= '
    <div class="pfsearchresults '.$pfcontainershow.' pflistgridview pflistgridview-static">';

        $wpflistdata .=
        '<div class="'.$pfcontainerdiv.'-content pflistcommonview-content" style="padding:0"  id="'.$carousel_id.'">';//List Content begin
        
        
            $wpflistdata .='
                <div class="pfitemlists-content-elements '.$pfgrid_output.'" id="'.$myrandno.'">';/*ul*/


			$wpflistdata_output = '';
			
			/* Variables */

				$setup22_searchresults_animation_image  = PFSAIssetControl('setup22_searchresults_animation_image','','WhiteSquare');
				$setup22_searchresults_hover_image  = PFSAIssetControl('setup22_searchresults_hover_image','','0');
				$setup22_searchresults_hover_video  = PFSAIssetControl('setup22_searchresults_hover_video','','0');
				$setup22_searchresults_hide_address  = PFSAIssetControl('setup22_searchresults_hide_address','','0');
				
				$pfbuttonstyletext = 'pfHoverButtonStyle ';
				
				switch($setup22_searchresults_animation_image){
					case 'WhiteRounded':
						$pfbuttonstyletext .= 'pfHoverButtonWhite pfHoverButtonRounded';
						break;
					case 'BlackRounded':
						$pfbuttonstyletext .= 'pfHoverButtonBlack pfHoverButtonRounded';
						break;
					case 'WhiteSquare':
						$pfbuttonstyletext .= 'pfHoverButtonWhite pfHoverButtonSquare';
						break;
					case 'BlackSquare':
						$pfbuttonstyletext .= 'pfHoverButtonBlack pfHoverButtonSquare';
						break;
					
				} 

				
				$pfboptx1 = PFSAIssetControl('setup22_searchresults_hide_excerpt','1','0');
				$pfboptx2 = PFSAIssetControl('setup22_searchresults_hide_excerpt','2','0');
				$pfboptx3 = PFSAIssetControl('setup22_searchresults_hide_excerpt','3','0');
				$pfboptx4 = PFSAIssetControl('setup22_searchresults_hide_excerpt','4','0');
				
				if($pfboptx1 != 1){$pfboptx1_text = 'style="display:none"';}else{$pfboptx1_text = '';}
				if($pfboptx2 != 1){$pfboptx2_text = 'style="display:none"';}else{$pfboptx2_text = '';}
				if($pfboptx3 != 1){$pfboptx3_text = 'style="display:none"';}else{$pfboptx3_text = '';}
				if($pfboptx4 != 1){$pfboptx4_text = 'style="display:none"';}else{$pfboptx4_text = '';}
				
				switch($pfgrid_output){case 'pf1col':$pfboptx_text = $pfboptx1_text;break;case 'pf2col':$pfboptx_text = $pfboptx2_text;break;case 'pf3col':$pfboptx_text = $pfboptx3_text;break;case 'pf4col':$pfboptx_text = $pfboptx4_text;break;}		
				
				if (is_user_logged_in()) {
					$user_favorites_arr = get_user_meta( get_current_user_id(), 'user_favorites', true );
					if (!empty($user_favorites_arr)) {
						$user_favorites_arr = json_decode($user_favorites_arr,true);
					}else{
						$user_favorites_arr = array();
					}
				}						
				
				$setup16_featureditemribbon_hide = PFSAIssetControl('setup16_featureditemribbon_hide','','1');
				$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');
				$setup22_searchresults_hide_re = PFREVSIssetControl('setup22_searchresults_hide_re','','1');
				$setup22_searchresults_hide_excerpt_rl = PFSAIssetControl('setup22_searchresults_hide_excerpt_rl','','2');
				$setup16_reviewstars_nrtext = PFREVSIssetControl('setup16_reviewstars_nrtext','','0');
			
			if($loop->post_count > 0){
		
				while ( $loop->have_posts() ) : $loop->the_post();
				
				$post_id = get_the_id();
				
				/* Print out icon visibility --------------------------------------------------------------------*/
		
					$pfitemvisibility = 'true';
				
				/* Print out icon visibility --------------------------------------------------------------------*/

					
					
					if($pfitemvisibility == 'true'){				
						$ItemDetailArr = array();
						
						if ($pflang) {// If WPML working..
							$pfitemid = PFLangCategoryID_ld($post_id,$pflang);
						}else{
							$pfitemid = $post_id;
						}

						
						$featured_image = '';
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $pfitemid ), 'full' );
						$ItemDetailArr['featured_image_org'] = $featured_image[0];
						if($featured_image[0] != '' && $featured_image[0] != NULL){
							$ItemDetailArr['featured_image'] = aq_resize($featured_image[0],$featured_image_width,$featured_image_height,true);

							if($ItemDetailArr['featured_image'] === false) {
								if($general_retinasupport == 1){
									$ItemDetailArr['featured_image'] = aq_resize($featured_image[0],$featured_image_width/2,$featured_image_height/2,true);
									if($ItemDetailArr['featured_image'] === false) {
										$ItemDetailArr['featured_image'] = $ItemDetailArr['featured_image_org'];
										if($ItemDetailArr['featured_image'] == '') {
											$ItemDetailArr['featured_image'] = get_template_directory_uri().'/images/noimg.png';
										}
									}
								}else{
									$ItemDetailArr['featured_image'] = $ItemDetailArr['featured_image_org'];
									if($ItemDetailArr['featured_image'] == '') {
										$ItemDetailArr['featured_image'] = get_template_directory_uri().'/images/noimg.png';
									}
								}
								
							}
				
						}else{
							$ItemDetailArr['featured_image'] = get_template_directory_uri().'/images/noimg.png';
						}
						//Title
						$ItemDetailArr['if_title'] = get_the_title($pfitemid);
						//Title
						$ItemDetailArr['if_excerpt'] = get_the_excerpt();
						//Permalink
						$ItemDetailArr['if_link'] = get_permalink($pfitemid);;
						//Address
						$ItemDetailArr['if_address'] = esc_html(get_post_meta( $pfitemid, 'webbupointfinder_items_address', true ));
						//Featured Video
						$ItemDetailArr['featured_video'] =  esc_url(get_post_meta( $pfitemid, 'webbupointfinder_item_video', true ));
						
						$output_data = PFIF_DetailText_ld($pfitemid);
						if (is_array($output_data)) {
							if (!empty($output_data['ltypes'])) {
								$output_data_ltypes = $output_data['ltypes'];
							} else {
								$output_data_ltypes = '';
							}
							if (!empty($output_data['content'])) {
								$output_data_content = $output_data['content'];
							} else {
								$output_data_content = '';
							}
							if (!empty($output_data['priceval'])) {
								$output_data_priceval = $output_data['priceval'];
							} else {
								$output_data_priceval = '';
							}
						} else {
							$output_data_priceval = '';
							$output_data_content = '';
							$output_data_ltypes = '';
						}
						
						
						/*li*/$wpflistdata_output .= '
							<div class="'.$pfgridcol_output.' wpfitemlistdata">
								<div class="pflist-item"'.$pfitemboxbg.'>
								<div class="pflist-item-inner">
									<div class="pflist-imagecontainer pflist-subitem">
									';
									
									if($setup22_searchresults_hover_image == 1){
										$wpflistdata_output .= "<a href='".$ItemDetailArr['if_link']."'><img src='".$ItemDetailArr['featured_image'] ."' alt='' /></a>";
										if($setup4_membersettings_favorites == 1){
											
											$fav_check = 'false';
											$favtitle_text = esc_html__('Add to Favorites','pointfindert2d');

											if (is_user_logged_in() && count($user_favorites_arr)>0) {
												if (in_array($pfitemid, $user_favorites_arr)) {
													$fav_check = 'true';
													$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
												}
											}

											$wpflistdata_output .= '<div class="RibbonCTR">
				                                <span class="Sign"><a class="pf-favorites-link" data-pf-num="'.$pfitemid.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'"><i class="pfadmicon-glyph-629"></i></a>
				                                </span>
				                                <span class="Triangle"></span>
				                            </div>';
				                        }
									}else{
										$wpflistdata_output .= "<a href='".$ItemDetailArr['if_link']."'><img src='".$ItemDetailArr['featured_image'] ."' alt='' /></a>";
										if($setup4_membersettings_favorites == 1){
											
											$fav_check = 'false';
											$favtitle_text = esc_html__('Add to Favorites','pointfindert2d');

											if (is_user_logged_in() && count($user_favorites_arr)>0) {
												if (in_array($pfitemid, $user_favorites_arr)) {
													$fav_check = 'true';
													$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
												}
											}

											$wpflistdata_output .= '<div class="RibbonCTR">
				                                <span class="Sign"><a class="pf-favorites-link" data-pf-num="'.$pfitemid.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'"><i class="pfadmicon-glyph-629"></i></a>
				                                </span>
				                                <span class="Triangle"></span>
				                            </div>';
				                        }

										$wpflistdata_output .= '
										<div class="pfImageOverlayH hidden-xs"></div>
										';
										if($setup22_searchresults_hover_video != 1 && !empty($ItemDetailArr['featured_video'])){	
										$wpflistdata_output .= '
										<div class="pfButtons pfStyleV pfStyleVAni hidden-xs">';
										}else{
										$wpflistdata_output .= '
										<div class="pfButtons pfStyleV2 pfStyleVAni hidden-xs">';
										}
											$wpflistdata_output .= '
											<span class="'.$pfbuttonstyletext.' clearfix">
												<a class="pficon-imageclick" data-pf-link="'.$ItemDetailArr['featured_image_org'].'" style="cursor:pointer">
													<i class="pfadmicon-glyph-684"></i>
												</a>
											</span>';
											if($setup22_searchresults_hover_video != 1 && !empty($ItemDetailArr['featured_video'])){	
											$wpflistdata_output .= '
											<span class="'.$pfbuttonstyletext.'">
												<a class="pficon-videoclick" data-pf-link="'.$ItemDetailArr['featured_video'].'" style="cursor:pointer">
													<i class="pfadmicon-glyph-573"></i>
												</a>
											</span>';
											}
											$wpflistdata_output .= '
											<span class="'.$pfbuttonstyletext.'">
												<a href="'.$ItemDetailArr['if_link'].'">
													<i class="pfadmicon-glyph-794"></i>
												</a>
											</span>
										</div>';
									}

									if ($setup16_featureditemribbon_hide != 0) {
										$featured_check_x = get_post_meta( $pfitemid, 'webbupointfinder_item_featuredmarker', true );

		                        		if (!empty($featured_check_x)) {
		                        			$wpflistdata_output .= '<div class="pfribbon-wrapper-featured"><div class="pfribbon-featured">'.esc_html__('FEATURED','pointfindert2d').'</div></div>';
		                        		}
			                        }

			                        
			                        /* Start: Conditions */

				                        if ($setup3_pt14_check == 1) {
		                        			$item_defaultvalue = wp_get_post_terms($pfitemid, 'pointfinderconditions', array("fields" => "all"));
											
											if (isset($item_defaultvalue[0]->term_id)) {																
		                        				$contidion_colors = pf_get_condition_color($item_defaultvalue[0]->term_id);

		                        				$condition_c = (isset($contidion_colors['cl']))? $contidion_colors['cl']:'#494949';
		                        				$condition_b = (isset($contidion_colors['bg']))? $contidion_colors['bg']:'#f7f7f7';

		                        				$wpflistdata_output .= '<div class="pfconditions-tag" style="color:'.$condition_c.';background-color:'.$condition_b.'">';
			                        			$wpflistdata_output .= '<a href="' . esc_url( get_term_link( $item_defaultvalue[0]->term_id, 'pointfinderconditions' ) ) . '" style="color:'.$condition_c.';">'.$item_defaultvalue[0]->name.'</a>';
			                        			$wpflistdata_output .= '</div>';
		                        			}

				                        }
					                /* End: Conditions */
									
									if ($output_data_priceval != '' || $output_data_ltypes != '') {
										$wpflistdata_output .= '<div class="pflisting-itemband">';
									
										$wpflistdata_output .= '<div class="pflist-pricecontainer">';
										if ($output_data_ltypes != '') {
											$wpflistdata_output .= $output_data_ltypes;
											
										}
										if ($output_data_priceval != '') {
											$wpflistdata_output .= $output_data_priceval;
										}else{
											$wpflistdata_output .= '<div class="pflistingitem-subelement pf-price" style="visibility: hidden;"><i class="pfadmicon-glyph-553"></i></div>';
										}
										
										$wpflistdata_output .= '</div>';
								
										$wpflistdata_output .= '</div>';
									}

									if($pfgrid_output == 'pf1col'){
										$wpflistdata_output .= '</div><div class="pfrightcontent">';
									}else{
										$wpflistdata_output .='
										
									</div>
									';
									}

									switch($pfgrid){
												
										case 'grid2':
											$limit_chr = PFSizeSIssetControl('setupsizelimitwordconf_general_grid2address','',96);
											$limit_chr_title = PFSizeSIssetControl('setupsizelimitwordconf_general_grid2title','',96);
											break;
										case 'grid3':
											$limit_chr = PFSizeSIssetControl('setupsizelimitwordconf_general_grid3address','',32);
											$limit_chr_title = PFSizeSIssetControl('setupsizelimitwordconf_general_grid3title','',32);
											break;
										case 'grid4':
											$limit_chr = PFSizeSIssetControl('setupsizelimitwordconf_general_grid4address','',32);
											$limit_chr_title = PFSizeSIssetControl('setupsizelimitwordconf_general_grid4title','',32);
											break;
										default:
											$limit_chr = PFSizeSIssetControl('setupsizelimitwordconf_general_grid4address','',32);
											$limit_chr_title = PFSizeSIssetControl('setupsizelimitwordconf_general_grid4title','',32);
											break;
									}
									
									$titlecount = strlen($ItemDetailArr['if_title']);
									$titlecount = (strlen($ItemDetailArr['if_title'])<=$limit_chr_title ) ? '' : '...' ;
									$title_text = mb_substr($ItemDetailArr['if_title'], 0, $limit_chr_title ,'UTF-8').$titlecount;

									$addresscount = strlen($ItemDetailArr['if_address']);
									$addresscount = (strlen($ItemDetailArr['if_address'])<=$limit_chr ) ? '' : '...' ;
									$address_text = mb_substr($ItemDetailArr['if_address'], 0, $limit_chr ,'UTF-8').$addresscount;

									$excerpt_text = mb_substr($ItemDetailArr['if_excerpt'], 0, ($limit_chr*$setup22_searchresults_hide_excerpt_rl),'UTF-8').$addresscount;
									if (strlen($ItemDetailArr['if_excerpt']) > ($limit_chr*$setup22_searchresults_hide_excerpt_rl)) {
										$excerpt_text .= '...';
									}

									$wpflistdata_output .= '
									<div class="pflist-detailcontainer pflist-subitem">
										<ul class="pflist-itemdetails">
											<li class="pflist-itemtitle"><a href="'.$ItemDetailArr['if_link'].'">'.$title_text.'</a></li>
											';

											/* Start: Review Stars */
						                        if ($review_system_statuscheck == 1) {
						                        	if ($setup22_searchresults_hide_re == 0) {

						                        		$reviews = pfcalculate_total_review($pfitemid);

						                        		if (!empty($reviews['totalresult'])) {
						                        			$wpflistdata_output .= '<li class="pflist-reviewstars">';
						                        			$rev_total_res = round($reviews['totalresult']);
						                        			$wpflistdata_output .= '<div class="pfrevstars-wrapper-review">';
						                        			$wpflistdata_output .= ' <div class="pfrevstars-review">';
						                        				for ($ri=0; $ri < $rev_total_res; $ri++) { 
						                        					$wpflistdata_output .= '<i class="pfadmicon-glyph-377"></i>';
						                        				}
						                        				for ($ki=0; $ki < (5-$rev_total_res); $ki++) { 
						                        					$wpflistdata_output .= '<i class="pfadmicon-glyph-378"></i>';
						                        				}

						                        			$wpflistdata_output .= '</div></div>';
						                        			$wpflistdata_output .= '</li>';
						                        		}else{
						                        			if($setup16_reviewstars_nrtext == 0){
						                        				$wpflistdata_output .= '<li class="pflist-reviewstars">';
							                        			$wpflistdata_output .= '<div class="pfrevstars-wrapper-review">';
							                        			$wpflistdata_output .= '<div class="pfrevstars-review pfrevstars-reviewbl"><i class="pfadmicon-glyph-378"></i><i class="pfadmicon-glyph-378"></i><i class="pfadmicon-glyph-378"></i><i class="pfadmicon-glyph-378"></i><i class="pfadmicon-glyph-378"></i></div></div>';
							                        			$wpflistdata_output .= '</li>';
						                        			}
						                        		}
						                        	}
						                        }
							                /* End: Review Stars */


											if($setup22_searchresults_hide_address == 0){
											$wpflistdata_output .= '
											<li class="pflist-address"><i class="pfadmicon-glyph-109"></i> '.$address_text.'</li>
											';
											}
											$wpflistdata_output .= '
										</ul>
									</div>
									';
									if($pfboptx_text != 'style="display:none"'){
									$wpflistdata_output .= '
										<div class="pflist-excerpt pflist-subitem" '.$pfboptx_text.'>'.$excerpt_text.'</div>
									';
									}
									$wpflistdata_output .= '<div class="pflist-subdetailcontainer pflist-subitem"><div class="pflist-customfields">'.$output_data_content.'</div></div>';
									
									$wpflistdata_output .= '
									</div>
								</div>
								
							</div>
						';/*li*/
					}
				
					
					
				endwhile;
				
				$wpflistdata .= $wpflistdata_output;               
	            $wpflistdata .= '</div>';/*ul*/
			}
           

			wp_reset_postdata();

			$wpflistdata .= '</div>';//List Content End
			$wpflistdata .= "</div></div> ";//Form End . List Data End
	
			if ($foundedposts > 0) {
				$wpflistdata .= "
				<script type='text/javascript'>
				(function($) {
					'use strict'
					";
					$wpflistdata .= '
					$(function() {
					$("#'.$myrandno.'").owlCarousel({
							items : '.$pf_grid_size .',';
							 if($hide_prev_next_buttons !== "yes"){ $wpflistdata .= 'navigation : true,';}else{$wpflistdata .= "navigation : false,";}
							 if($hide_pagination_control !== "yes"){ $wpflistdata .= 'pagination : true,';}else{$wpflistdata .= "pagination : false,";}
							 if($autoplay == "yes"){ $wpflistdata .= 'autoPlay : true,stopOnHover : true,';}else{$wpflistdata .= 'autoPlay : false,';}
							 $wpflistdata .='
							slideSpeed:'.$speed.',
							mouseDrag:true,
							touchDrag:true,
							itemSpaceWidth: '.$itemspacebetween.',';
							if($autoplay === "yes"){ $wpflistdata .= 'itemBorderWidth : 0,';}else{$wpflistdata .= 'itemBorderWidth : '.$pf_grid_size.',';}
							$wpflistdata .='
							autoHeight : false,
							responsive:true,
							itemsScaleUp : false,
							navigationText:false,
							theme:"owl-theme",
							singleItem : false,
							itemsDesktop : [1199,'.$pf_grid_size .'],
							itemsDesktopSmall : [980,'.$pf_grid_size .'],
							itemsTablet: [768, 2],
							itemsTabletSmall: false,
							itemsMobile : [479,1],
						});
				});
					$(".pfButtons a").click(function() {
						if($(this).attr("data-pf-link")){
							$.prettyPhoto.open($(this).attr("data-pf-link"));
						}
					});

				})(jQuery);
				</script>
				';
			}
			


	if ($foundedposts > 0) {
		return $wpflistdata;
	}else{
		return '';
	}
 }
?>