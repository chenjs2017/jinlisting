<?php

/**********************************************************************************************************************************
*
* Item Page Functions
* 
* Author: Webbu Design
* Please do not modify below functions.
***********************************************************************************************************************************/


get_template_part('admin/estatemanagement/includes/pages/itemdetail/itempage-content','part');

function PFGetItemPageCol1(){

	global $claim_list_permission;
	global $ohour_list_permission;
//-jschen, add location me button
echo '<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12" jstcache="0">
	<a href="#" id="aglId"><img src="/wp-content/themes/pointfinder/images/ge.png" width="25px" heigh="25px">定位位置</img> </a> 
	<span id="aglResult"></span>
</div>';
/*
echo '<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12" jstcache="0">
<input name="field296725954161956900000" id="field296725954161956900000" class="input" placeholder="输入地址，查看附近商家" value="" autocomplete="off" type="search">
<input name="pointfinder_google_search_coord" id="pointfinder_google_search_coord" class="input" value="" type="hidden">
	<a href="#" id="aglSearch"><img src="/se.png" width="25px" heigh="25px"></img></a> 
	<a href="#" id="aglId"><img src="/ge.png" width="25px" heigh="25px"></img> </a> 
	<br><span id="aglResult"></span>
</div>';
*/
	$claim_list_permission = 1;
	$review_list_permission = 1;
	$comment_list_permission = 1;
	$ohour_list_permission = 1;
	$features_list_permission = 1;

	$the_post_id = get_the_id();

	/*Item Count*/
	$item_old_count = get_post_meta( $the_post_id, 'webbupointfinder_page_itemvisitcount', true );

	if (empty($item_old_count)) {
		$item_old_count = 1;
	}else{
		$item_old_count = $item_old_count + 1;
	}

	update_post_meta( $the_post_id, 'webbupointfinder_page_itemvisitcount',$item_old_count);

	$item_term = pf_get_item_term_id($the_post_id);
	$listing_meta = get_option('pointfinderltypes_fevars');

	$setup42_itempagedetails_sidebarpos = PFSAIssetControl('setup42_itempagedetails_sidebarpos','','2');
	if ($setup42_itempagedetails_sidebarpos == 3) {
		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
	}else{
		echo '<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">';
	}

	$setup42_itempagedetails_claim_status = PFSAIssetControl('setup42_itempagedetails_claim_status','','0');
	$verified_badge_text = "";

	

	$listing_verified = get_post_meta( $the_post_id, 'webbupointfinder_item_verified', true );
	if($setup42_itempagedetails_claim_status == 1 && $listing_verified == 1 ){
		$setup42_itempagedetails_claim_validtext = PFSAIssetControl('setup42_itempagedetails_claim_validtext','','');
		$verified_badge_text = '<span class="pfverified-bagde-text"> <i class="pfadmicon-glyph-62" style="  color: #59C22F;font-size: 18px;"></i> '.$setup42_itempagedetails_claim_validtext.'</span>';

	}
	

	/*Check Advanced Settings*/
	$advanced_term_status = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_advanced_status','',0);

	/* Check New Advanced Settings */
	$advanced_term_status_new = 0;
	$st8_nasys = PFASSIssetControl('st8_nasys','',0);
	
	if ( $st8_nasys == 1) {
		$advanced_term_status = 0;

		$listing_config_meta = get_option('pointfinderltypes_aslvars');
		if (isset($listing_config_meta[$item_term])) {
			if (!empty($listing_config_meta[$item_term]['pflt_advanced_status'])) {
				$advanced_term_status_new = 1; 
			}
		}
	}


	if ($advanced_term_status == 0 && $advanced_term_status_new == 0) {
		 global $pointfindertheme_option;
		 $setup42_itempagedetails_configuration = (isset($pointfindertheme_option['setup42_itempagedetails_configuration']))? $pointfindertheme_option['setup42_itempagedetails_configuration'] : array();

	}else{
		if ($advanced_term_status == 1) {
			global $pfadvancedcontrol_options;
			$setup42_itempagedetails_configuration = (isset($pfadvancedcontrol_options['setupadvancedconfig_'.$item_term.'_configuration']))? $pfadvancedcontrol_options['setupadvancedconfig_'.$item_term.'_configuration'] : array();

			/*Extra Settings*/
			$review_list_permission = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_reviewmodule','','1');
			$claim_list_permission = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_claimsmodule','','1');
			$comment_list_permission = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_commentsmodule','','1');
			$ohour_list_permission = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_ohoursmodule','','1');
			$features_list_permission = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_featuresmodule','','1');
		}

		if($advanced_term_status_new == 1){
			$setup42_itempagedetails_configuration = (isset($listing_config_meta[$item_term]['pflt_configuration']))? $listing_config_meta[$item_term]['pflt_configuration'] : array();
			/*Extra Settings*/
			$review_list_permission = (!empty($listing_config_meta[$item_term]['pflt_reviewmodule']))?1:0;
			$claim_list_permission = (!empty($listing_config_meta[$item_term]['pflt_claimsmodule']))?1:0;
			$comment_list_permission = (!empty($listing_config_meta[$item_term]['pflt_commentsmodule']))?1:0;
			$ohour_list_permission = (!empty($listing_config_meta[$item_term]['pflt_ohoursmodule']))?1:0;
			$features_list_permission = (!empty($listing_config_meta[$item_term]['pflt_featuresmodule']))?1:0;
		}
		 
	}


	$setup3_modulessetup_headersection = PFSAIssetControl('setup3_modulessetup_headersection','',1);

	if (!empty($item_term)) {
		if ($advanced_term_status == 1) {
			$setup3_modulessetup_headersection = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_headersection','','2');
		}
		if($advanced_term_status_new == 1){
			$setup3_modulessetup_headersection = (!empty($listing_config_meta[$item_term]['pflt_headersection']))?$listing_config_meta[$item_term]['pflt_headersection']:0;
		}
	}

	$postd_hideshow = PFSAIssetControl('postd_hideshow','',1);
	$viewcount_hideshow = PFSAIssetControl('viewcount_hideshow','',1);

	if ($viewcount_hideshow == 1) {
		$viewcount_text = ' <strong><i class="pfadmicon-glyph-729"></i> '.$item_old_count.'</strong>';
	}else{
		$viewcount_text = '';
	}
	
	if ($postd_hideshow == 1) {
		$postd_text = ''.esc_html__('Posted on','pointfindert2d').' '.get_the_time(get_option('date_format')).' /';
	}else{
		$postd_text = '';
	}


	if ($setup3_modulessetup_headersection == 1 || $setup3_modulessetup_headersection == 2 ) {
		echo '<div class="pf-item-title-bar"><span class="pf-item-title-text" itemprop="name">'.get_the_title().'</span> <span class="pf-item-subtitle"> '.esc_html(pf_get_address_with_distance( get_the_id())).'</span></div><div class="pf-item-extitlebar"><div class="pf-itemdetail-pdate">'.$postd_text.$viewcount_text.' '.$verified_badge_text.'</div></div>'; 
	}elseif($setup3_modulessetup_headersection == 0){
		echo '<div class="pf-item-title-bar">'.$verified_badge_text.'<div class="pf-itemdetail-pdate">'.$postd_text.$viewcount_text.'</div></div>'; 
	}
  

	$i = 1;
	$tabinside = $tabinsidesp = $tabinside_output = $tabinside_first = $taboutside_w1 = $taboutside_w2 = '';
	
	$contact_check_re = 0; /* Contact status check for recaptcha */
	$tabcontactform = '';
	
	foreach ($setup42_itempagedetails_configuration as $key => $value) {
		$valtext = ($i == 2) ? 'checked' : '' ;

		switch ($key) {
			case 'gallery':
				$tabinside = '';
				if ($value['status'] == 1) {
					/** 
					*Start: Gallery 
					**/

						$general_crop = PFSAIssetControl('general_crop','',1);

						$images = rwmb_meta( 'webbupointfinder_item_images', array( 'type'=>'image' ));

						$setupsizelimitconf_general_gallerysize1_w = PFSizeSIssetControl('setupsizelimitconf_general_gallerysize1','width',848);
						$setupsizelimitconf_general_gallerysize1_h = PFSizeSIssetControl('setupsizelimitconf_general_gallerysize1','height',566);

						$setupsizelimitconf_general_gallerysize2_w = PFSizeSIssetControl('setupsizelimitconf_general_gallerysize2','width',112);
						$setupsizelimitconf_general_gallerysize2_h = PFSizeSIssetControl('setupsizelimitconf_general_gallerysize2','height',100);

						$featured_image_orj = wp_get_attachment_image_src( get_post_thumbnail_id( $the_post_id ), 'full' );

						switch ($general_crop) {
							case 1:
								$featured_image = aq_resize($featured_image_orj[0],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h,true,true,true);
								$featured_image_thumb = aq_resize($featured_image_orj[0],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true,true,true);
								break;
							
							case 2:
								$featured_image = aq_resize($featured_image_orj[0],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h,true);
								$featured_image_thumb = aq_resize($featured_image_orj[0],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true);
								break;

							case 3:
								$featured_image = false;
								$featured_image_thumb = $featured_image_orj[0];
								break;
						}

						if ($featured_image == false) {
							$featured_image = array($featured_image_orj[0],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h);
						}else{
							$featured_image = array($featured_image,$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h);
						}


						$general_rtlsupport = PFSAIssetControl('general_rtlsupport','','0');
						if((!empty($images) || !empty($featured_image[0]))){
							$tabinside .= '<div class="ui-tab'.$i.'">';
							$tabinside .= '<section role="itempagegallery" class="pf-itempage-gallery pf-itempage-elements">';

								$tabinside .= '<div id="pf-itempage-gallery">';

								$autoplay_status = PFSAIssetControl('setup42_itempagedetails_gallery_autoplay','','0');
								$autoheight_status = PFSAIssetControl('setup42_itempagedetails_gallery_autoheight','','0');

								if ($autoplay_status == 1) {
									$autoplay = 'autoPlay:true,stopOnHover : true,slideSpeed:'.PFSAIssetControl('setup42_itempagedetails_gallery_interval','','300').',';
								}else{
									$autoplay = 'slideSpeed:1000,';
								}

								if ($autoheight_status == 1) {
									$autoheightval = 'autoHeight:true,';
								}else{
									$autoheightval = 'autoHeight:false,';
								}

								$thumbs_status = (PFSAIssetControl('setup42_itempagedetails_gallery_thumbs','','0') == 1) ? ' pfdispnone' : '' ;
								
								$output = $output2 = '';
								
								if(PFSAIssetControl('setup42_itempagedetails_featuredimage','','1') == 1 && $general_rtlsupport != 1){
									$output .= "<li class='item'><a href='".$featured_image_orj[0]."' rel='prettyPhoto'><img itemprop='image' src='".$featured_image[0]."' alt='' /></a></li>";
									$output2 .= "<li class='item'><img src='".$featured_image_thumb."' alt='' /></li>";
								}

								if(!empty($images)){
									$kl = 0;
									if ($general_rtlsupport == 1) {
										foreach ( array_reverse($images) as $image ){

										switch ($general_crop) {
											case 1:
												$image_orj = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h,true,true,true);
												$image_orj_thumb = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true,true,true);
												break;
											
											case 2:
												$image_orj = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h,true);
												$image_orj_thumb = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true);
												break;

											case 3:
												$image_orj = false;
												$image_orj_thumb = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true);
												break;
										}


										if ($image_orj == false) {
											$image = array('url'=>$image['full_url'],'full_url'=>$image['full_url'],'width'=>$setupsizelimitconf_general_gallerysize1_w,'height'=>$setupsizelimitconf_general_gallerysize1_h,'alt'=>$image['alt']);
										}else{
											$image = array('url'=>$image_orj_thumb,'full_url'=>$image_orj,'width'=>$setupsizelimitconf_general_gallerysize1_w,'height'=>$setupsizelimitconf_general_gallerysize1_h,'alt'=>$image['alt']);
										}

										if($kl == 0){
											$firstimage = "<img src='{$image['full_url']}' alt='{$image['alt']}' />";
										}
									    $output .= "<li class='item'><a href='{$image['full_url']}' rel='prettyPhoto'><img src='{$image['full_url']}' alt='{$image['alt']}' /></a></li>";
									    $output2 .= "<li class='item'><img src='{$image['url']}' alt='{$image['alt']}' /></li>";
									    $kl++;
									}
									}else{
										foreach ( $images as $image ){

											switch ($general_crop) {
												case 1:
													$image_orj = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h,true,true,true);
													$image_orj_thumb = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true,true,true);
													break;
												
												case 2:
													$image_orj = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize1_w,$setupsizelimitconf_general_gallerysize1_h,true);
													$image_orj_thumb = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true);
													break;

												case 3:
													$image_orj = false;
													$image_orj_thumb = aq_resize($image['full_url'],$setupsizelimitconf_general_gallerysize2_w,$setupsizelimitconf_general_gallerysize2_h,true);
													break;
											}
											

											if ($image_orj == false) {
												$image = array('url'=>$image['full_url'],'full_url'=>$image['full_url'],'width'=>$setupsizelimitconf_general_gallerysize1_w,'height'=>$setupsizelimitconf_general_gallerysize1_h,'alt'=>$image['alt']);
											}else{
												$image = array('url'=>$image_orj_thumb,'full_url'=>$image_orj,'width'=>$setupsizelimitconf_general_gallerysize1_w,'height'=>$setupsizelimitconf_general_gallerysize1_h,'alt'=>$image['alt']);
											}

											if($kl == 0){
												$firstimage = "<img src='{$image['full_url']}' alt='{$image['alt']}' />";
											}
										    $output .= "<li class='item'><a href='{$image['full_url']}' rel='prettyPhoto'><img src='{$image['full_url']}' alt='{$image['alt']}' /></a></li>";
										    $output2 .= "<li class='item'><img src='{$image['url']}' alt='{$image['alt']}' /></li>";
										    $kl++;
										}
									}
								}else{
									$firstimage = "<img src='".$featured_image[0]."' alt='' />";
								
								}

								if(PFSAIssetControl('setup42_itempagedetails_featuredimage','','1') == 1 && $general_rtlsupport == 1){
									$output .= "<li class='item'><a href='".$featured_image_orj[0]."' rel='prettyPhoto'><img itemprop='image' src='".$featured_image[0]."' alt='' /></a></li>";
									$output2 .= "<li class='item'><img src='".$featured_image_thumb."' alt='' /></li>";
								}

								$tabinside .= '<div class="visible-print">'.$firstimage.'</div>';

								if(empty($images)){$css_text_slider = " style='margin-bottom:0;'";}else{$css_text_slider = '';};

								$tabinside .= '<ul id="pfitemdetail-slider" class="owl-carousel hidden-print"'.$css_text_slider.'>';
									$tabinside .= $output;
								$tabinside .= '</ul>';
								if(!empty($images)){
									$tabinside .= '<ul id="pfitemdetail-slider-sub" class="owl-carousel hidden-print hidden-xs'.$thumbs_status.'">';
										$tabinside .= $output2;
									$tabinside .= '</ul>';
								}
								$tabinside .= '
								<script type="text/javascript">
								(function($) {
						  			"use strict";
									$(document).ready(function() {
						 
									  var sync1 = $("#pfitemdetail-slider");
									  var sync2 = $("#pfitemdetail-slider-sub");
									 
									  sync1.owlCarousel({
									    singleItem : true,
									    '.$autoplay.'
									    transitionStyle: "'.PFSAIssetControl('setup42_itempagedetails_gallery_effect','','fadeUp').'",
									    navigation: true,
									    '.$autoheightval.'
									    responsive:true,
									    pagination:false,
									    itemsScaleUp : false,
										navigationText:false,
										theme:"owl-theme",
									    afterAction : syncPosition,
									    responsiveRefreshRate : 200,
									  });
									 
									  sync2.owlCarousel({
									    pagination:false,
									    autoHeight : false,
									    responsiveRefreshRate : 100,
									    navigation: true,
									    responsive:true,
									    itemsScaleUp : false,
										navigationText:false,
										theme:"owl-theme",
									    itemSpaceWidth: 10,
									    singleItem : false,
									    items:7,
									    itemsDesktop:[1024,5],
									    itemsDesktopSmall: [979,4],
									    itemsTablet: [768,6],
									    itemsTabletSmall: [638,5],
						    			itemsMobile: [479,3],
									    afterInit : function(el){
									      el.find(".owl-item").eq(0).addClass("synced");
									    }
									  });
									 
									  function syncPosition(el){
									    var current = this.currentItem;
									    $("#pfitemdetail-slider-sub")
									      .find(".owl-item")
									      .removeClass("synced")
									      .eq(current)
									      .addClass("synced")
									    if($("#pfitemdetail-slider-sub").data("owlCarousel") !== undefined){
									      center(current)
									    }
									  }
									 
									  $("#pfitemdetail-slider-sub").on("click", ".owl-item", function(e){
									    e.preventDefault();
									    var number = $(this).data("owlItem");
									    sync1.trigger("owl.goTo",number);
									  });
									 
									  function center(number){
									    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
									    var num = number;
									    var found = false;
									    for(var i in sync2visible){
									      if(num === sync2visible[i]){
									        var found = true;
									      }
									    }
									 
									    if(found===false){
									      if(num>sync2visible[sync2visible.length-1]){
									        sync2.trigger("owl.goTo", num - sync2visible.length+2)
									      }else{
									        if(num - 1 === -1){
									          num = 0;
									        }
									        sync2.trigger("owl.goTo", num);
									      }
									    } else if(num === sync2visible[sync2visible.length-1]){
									      sync2.trigger("owl.goTo", sync2visible[1])
									    } else if(num === sync2visible[0]){
									      sync2.trigger("owl.goTo", num-1)
									    }
									    
									  }
									 
									});
								})(jQuery);
								</script>
								';
								$tabinside .= '</div>';
							$tabinside .= '</section>';
							$tabinside .= '</div>';

							if($i > 1){
								$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
								$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.$value['title'].'</span></label>';
							}

						}
					/** 
					*End: Gallery 
					**/
					
				}
				break;

			case 'informationbox':
					
					$tabinside = $tabinsidesp = '';
					/** 
					*Start: Information Box 
					**/
						if($value['status'] == 1){

							global $pointfindertheme_option;

							$tabinsidesp .= '<div class="ui-tab'.$i.' uix-tabx-desc">';

							$setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
							$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');

							if ($setup3_modulessetup_openinghours == 0) {
								$setup42_itempagedetails_config3 = $pointfindertheme_option['setup42_itempagedetails_config4'];
							}elseif ($setup3_modulessetup_openinghours == 1) {
								$setup42_itempagedetails_config3 = $pointfindertheme_option['setup42_itempagedetails_config3'];
							}
							foreach ($setup42_itempagedetails_config3['enabled'] as $single_arr_val => $val) {	

								switch ($single_arr_val) {

									/*Details & O. Hours*/
									case 'details':
										$tabinsidesp .= pf_itemdetail_halfcol(pfitempage_details_block(),pfitempage_ohours_block());
										break;


									/*Details*/
									case 'details1':
										$tabinsidesp .= pf_itemdetail_fullcol(pfitempage_details_block());
										break;


									/*Details & Description*/
									case 'details2':
										$tabinsidesp .= pf_itemdetail_thirdcol(pfitempage_details_block(),pfitempage_description_block());
										break;


									/*Details & Description*/
									case 'details2x':
										$tabinsidesp .= pf_itemdetail_thirdcolx(pfitempage_description_block(),pfitempage_details_block());
										break;



									/*Details + Opening Hours & Description*/
									case 'details4':
										$tabinsidesp .= pf_itemdetail_forthcol(pfitempage_details_block(),pfitempage_ohours_block(),pfitempage_description_block());
										break;

									/*Description & Details + Opening Hours*/
									case 'details4x':
										$tabinsidesp .= pf_itemdetail_forthcolx(pfitempage_description_block(),pfitempage_details_block(),pfitempage_ohours_block());
										break;

									


									/*Description*/
									case 'description':
										$tabinsidesp .= pf_itemdetail_fullcol(pfitempage_description_block());
										break;
									
									
									


									/*Opening Hours*/
									case 'ohours1':
										$tabinsidesp .= pf_itemdetail_fullcol(pfitempage_ohours_block());
										break;

									

									/*Opening Hours & Description*/
									case 'ohours3':
										$tabinsidesp .= pf_itemdetail_thirdcol(pfitempage_ohours_block(),pfitempage_description_block());
										break;

									


								}
								
								
							}

							
							$tabinsidesp .= '</div>';

							/* Desc */
							$tabinside .= $tabinsidesp;

						}		
					/** 
					*End: Information Box 
					**/
				break;

			case 'description1':
					$tabinside = '';
					/** 
					*Start: Description 1
					**/
						if($value['status'] == 1){

							$tabinside .= '<div class="ui-tab'.$i.' ui-desc-single">';

							if ($value['fimage'] == 1) {
								$tabinside .= pf_itemdetail_thirdcols1(pfitempage_fimage_block(),pfitempage_description_block1());
							}elseif ($value['fimage'] == 2) {
								$tabinside .= pf_itemdetail_thirdcolxs1(pfitempage_description_block1(),pfitempage_fimage_block());
							}else{
								$tabinside .= pfitempage_description_block1();
							}
							
							$tabinside .= '</div>';

							/* Desc */
						}		
					/** 
					*End: Description  1
					**/
				break;

			case 'description2':
					$tabinside = '';
					/** 
					*Start: Description 2
					**/
						if($value['status'] == 1){

							$tabinside .= '<div class="ui-tab'.$i.'">';

							if ($value['fimage'] == 1) {
								$tabinside .= pf_itemdetail_thirdcols1(pfitempage_fimage_block(),pfitempage_description_block2());
							}elseif ($value['fimage'] == 2) {
								$tabinside .= pf_itemdetail_thirdcolxs1(pfitempage_description_block2(),pfitempage_fimage_block());
							}else{
								$tabinside .= pfitempage_description_block2();
							}

							$tabinside .= '</div>';

							/* Desc */
						}		
					/** 
					*End: Description  2
					**/
				break;
				
			case 'location':
				$tabinside = '';
				if ($value['status'] == 1 && pf_get_listingmeta_limit($listing_meta, $item_term, 'pf_address_area') == 1) {
					
					/** 
					*Start: Map 
					**/
						$tabinside .= '<div class="ui-tab'.$i.'">';
							$tabinside .= '<section role="itempagemap" class="pf-itempage-maparea pf-itempage-elements">';
								$tabinside .= '<div id="pf-itempage-header-map"></div>';
								$tabinside .= '<div id="pf-itempage-page-map-directions" class="golden-forms pf-container"><form id="pf-itempage-page-map-directions-form">';
									$tabinside .= '<div class="pf-row">';
										$tabinside .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">';
										$tabinside .= '<section>
														<label for="gdtype" class="lbl-ui select">
							                              <select id="gdtype" name="gdtype">
							                                  <option value="DRIVING">'.esc_html__('Driving','pointfindert2d').'</option>
														      <option value="WALKING">'.esc_html__('Walking','pointfindert2d').'</option>
														      <option value="BICYCLING">'.esc_html__('Bicycling','pointfindert2d').'</option>
														      <option value="TRANSIT">'.esc_html__('Transit','pointfindert2d').'</option>
							                              </select>
							                            </label>                            
							                           </section>';
										$tabinside .= '</div>';
										$tabinside .= '<div class="col-lg-5 col-md-4 col-sm-3 col-xs-12">';
										$tabinside .= '<section>
							                            <label class="lbl-ui gdlocations">
							                            	<input type="hidden" name="gdlocationend" id="gdlocationend" value="'.esc_html(get_post_meta( get_the_id(), 'webbupointfinder_items_address', true )).'">
							                            	<input type="text" name="gdlocations" id="gdlocations" class="input" placeholder="'.esc_html__('Enter Location','pointfindert2d').'">
							                            	<a class="button" id="pf_gdirections_geolocateme">
															<img src="'.get_template_directory_uri().'/images/geoicon.svg" width="16px" height="16px" class="pf-gdirections-locatemebut" alt="'.esc_html__('Locate me!','pointfindert2d').'">
															<div class="pf-search-locatemebutloading"></div>
															</a>
							                            </label>                            
							                           </section>';
										$tabinside .= '</div>';
										$tabinside .= '<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">';
										$tabinside .= '<a class="button gdbutton" style="cursor:pointer;">'.esc_html__('Get Directions','pointfindert2d').'</a>';
										$tabinside .= '</div>';
										$tabinside .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">';
										$tabinside .= '<a class="button gdbutton2" href="https://maps.google.com?saddr=Current+Location&daddr='.esc_html(get_post_meta( get_the_id(), 'webbupointfinder_items_location', true )).'" target="_blank" rel="nofollow">'.esc_html__('Map Directions','pointfindert2d').'</a>';
										$tabinside .= '</div>';
									$tabinside .= '</form></div>';
								$tabinside .= '</div>';
								$tabinside .= '<div id="directions-panel"></div>';
							$tabinside .= '</section>';
						$tabinside .= '</div>';
					/** 
					*End: Map 
					**/
				}
				break;

			case 'streetview':
				$tabinside = '';
				if ($value['status'] == 1 && pf_get_listingmeta_limit($listing_meta, $item_term, 'pf_address_area') == 1) {
					
					/** 
					*Start: Streetview 
					**/
						
						$tabinside .= '<div class="ui-tab'.$i.'">';
							$tabinside .= '<section role="itempagemap" class="pf-itempage-maparea pf-itempage-elements">';
								$tabinside .= '<div id="pf-itempage-header-streetview"></div>';
							$tabinside .= '</section>';
						$tabinside .= '</div>';

						if($i > 1){
							$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
							$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.$value['title'].'</span></label>';
						}
						
					/** 
					*End: Streetview 
					**/
				}
				break;

			case 'video':
				$tabinside = '';
				if ($value['status'] == 1) {
					
					/** 
					*Start: Video 
					**/
						
						$video_output = redux_post_meta("pointfinderthemefmb_options", $the_post_id, "webbupointfinder_item_video");
					
						if(!empty($video_output)){
							$tabinside .= '<div class="ui-tab'.$i.' hidden-print">';
								$tabinside .= '<section role="itempagevideo" class="pf-itempage-video pf-itempage-elements">';
									$tabinside .= '<div id="pf-itempage-video">';
										$tabinside .= wp_oembed_get($video_output);
										$tabinside .= '
										<script type="text/javascript">
										  jQuery(document).ready(function(){
										    jQuery("#pf-itempage-video").fitVids();
										  });
										</script>
										';
									$tabinside .= '</div>';
								$tabinside .= '</section>';
							$tabinside .= '</div>';

							if($i > 1){
								$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
								$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.$value['title'].'</span></label>';
							}
						}
						
					/** 
					*End: Video 
					**/
				}
				break;

			case 'contact':
				$tabinside = '';
				if($value['status'] == 1){
					

					/** 
					*Start: Contact 
					**/
						/* Get Admin Options */
						
						$setup42_itempagedetails_contact_photo = PFSAIssetControl('setup42_itempagedetails_contact_photo','','1');
						$setup42_itempagedetails_contact_moreitems = PFSAIssetControl('setup42_itempagedetails_contact_moreitems','','1');
						$setup42_itempagedetails_contact_phone = PFSAIssetControl('setup42_itempagedetails_contact_phone','','1');
						$setup42_itempagedetails_contact_mobile = PFSAIssetControl('setup42_itempagedetails_contact_mobile','','1');
						$setup42_itempagedetails_contact_email = PFSAIssetControl('setup42_itempagedetails_contact_email','','1');
						$setup42_itempagedetails_contact_url = PFSAIssetControl('setup42_itempagedetails_contact_url','','1');
						$setup42_itempagedetails_contact_form = PFSAIssetControl('setup42_itempagedetails_contact_form','','1');
						
			            $item_agents = get_post_meta( $the_post_id, 'webbupointfinder_item_agents', true );

			            $show_usercon = 0;
			            $show_agentcon = 0;
						$item_agents_count = (!empty($item_agents))? 1 : 0 ;
						$show_agent_user_con = 0;
						
						if ($item_agents_count == 0) {
							$show_usercon = 1;
							$show_agentcon = 0;
						} 

						if ($item_agents_count > 0 ) {
							$show_usercon = 0;
							$show_agentcon = 1;
						}

								global $wpdb;

							/**
							*Start: Check Connection with an Agent
							**/
								
								/*
								* Added a patch v1.0.6 for fix author problem.
								*$user_login = get_the_author();
								*/
								$user_login = get_the_author_meta('user_login');

								$user = get_user_by( 'login', $user_login );

								$user_agent_link = get_user_meta( $user->ID, 'user_agent_link', true );

								if(!empty($user_agent_link)){

									$setup3_pointposttype_pt8 = PFSAIssetControl('setup3_pointposttype_pt8','','agents');

									$user_agent_link_correction = $wpdb->get_var( $wpdb->prepare("SELECT post_title FROM $wpdb->posts where post_type = %s and ID = %d",$setup3_pointposttype_pt8,$user_agent_link));

									if(!empty($user_agent_link_correction)){
										$show_usercon = 0;
										$show_agentcon = 1;
										$show_agent_user_con = 1;
									}
								
								}
							/**
							*End: Check Connection with an Agent
							**/

							

							/**
							*Start: User Contact
							**/
								if($show_usercon == 1){
									$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
									$user_posts = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts where post_type = %s and post_author = %d and post_status = %s",
										$setup3_pointposttype_pt1,
										$user->ID,
										"publish"
										) 
									);

									$user_photo =  wp_get_attachment_image(get_user_meta( $user->ID, 'user_photo', true ),'medium');

									if (empty($user_photo)) {
										$user_photo = '<img src="'.get_template_directory_uri().'/images/empty_avatar.jpg"/>';
									}
									$user_description = get_user_meta( $user->ID, 'description', true );
									$user_phone = get_user_meta( $user->ID, 'user_phone', true );
									$user_mobile = get_user_meta( $user->ID, 'user_mobile', true );
								
									
									if($setup42_itempagedetails_contact_photo == 0){$user_photo = '';}
									
									$tabinside .= '<div class="ui-tab'.$i.' hidden-print">';
									$tabinside .= '<section role="itempagesidebarinfo" class="pf-itempage-sidebarinfo pfpos2 pf-itempage-elements">';
										
										$contact_user_title = $user->nickname;
										$tabinside .= '<div id="pf-itempage-sidebarinfo">';

										if($user_photo != ''){
											$tabinside .= '<div class="pf-row clearfix"><div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pfcols">';
											$tabinside .= '<div class="pf-itempage-sidebarinfo-photo"><a href="'.get_author_posts_url($user->ID).'">'.$user_photo.'</a></div>';
											
										
										
											$tabinside .= '</div>';
											$tabinside .= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 pfcols">';
										}else{
											$tabinside .= '<div class="pf-row clearfix">';
											if ($setup42_itempagedetails_contact_form == 0) {
												$tabinside .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pfcols">';
											}else{
												$tabinside .= '<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pfcols">';
											}
										}
											
										

											$tabinside .= '<div class="pf-itempage-sidebarinfo-userdetails pfpos2">
												<ul>';
												if($user_posts > 0 && $setup42_itempagedetails_contact_moreitems == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="'.get_author_posts_url($user->ID).'"><i class="pfadmicon-glyph-510"></i> '.esc_html__('More Items','pointfindert2d').' ('.$user_posts.')</a></li>';
												}
												if(!empty($user_phone ) && $setup42_itempagedetails_contact_phone == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="tel:'.antispambot($user_phone).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-765"></i> '.$user_phone.'</a></li>';
												}
												if(!empty($user_mobile) && $setup42_itempagedetails_contact_mobile == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="tel:'.antispambot($user_mobile).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-351"></i> '.$user_mobile.'</a></li>';
												}
												if(!empty($user->user_email) && $setup42_itempagedetails_contact_email == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="mailto:'.antispambot( $user->user_email ).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-823"></i> '.esc_html__("Email Us!","pointfindert2d").'</a></li>';
												}
												if(!empty($user->user_url) && $setup42_itempagedetails_contact_url == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="'.$user->user_url.'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-434"></i> '.$user->user_url.'</a></li>';
												}
												$tabinside .= '</ul>
											</div>';
											$tabinside .= '</div>';

											if ($setup42_itempagedetails_contact_form == 1) {
												
												if($user_photo != ''){
												
													if ($setup42_itempagedetails_contact_phone == 0 && $setup42_itempagedetails_contact_mobile == 0 && $setup42_itempagedetails_contact_email == 0 && $setup42_itempagedetails_contact_moreitems == 0) {
														$tabinside .= '<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 pfcols">';
													}else{
														$tabinside .= '<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 pfcols">';
													}
												}else{
													if ($setup42_itempagedetails_contact_phone == 0 && $setup42_itempagedetails_contact_mobile == 0 && $setup42_itempagedetails_contact_email == 0 && $setup42_itempagedetails_contact_moreitems == 0) {
														$tabinside .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pfcols">';
													}else{
														$tabinside .= '<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pfcols">';
													}
												
												}

												
												$pfrecheck = PFRECIssetControl('setupreCaptcha_general_status','','0');
												if ($pfrecheck == 1) {
													$recaptcha2 = '<section style="margin-bottom: 10px;"><div id="recaptcha_div_mod">';
													$recaptcha2 .= '<div id="g_recaptcha_agentcontact" class="g-recaptcha-field" data-rekey="widgetIdagentcontact"></div>';
													$recaptcha2 .= '</div></section>';
												}else{
													$recaptcha2 = '';
												}


												$pfrechecklg = PFRECIssetControl('setupreCaptcha_general_con_agent_status','','0');
												if ( $pfrecheck == 1 && $pfrechecklg != 1) {
													$recaptcha2 = '';
												}

									  			$val1 = $val2 = $val3 = $rowval = '';

									  			if (!empty($recaptcha2)) {
								    				$exstyles = ' style="margin-bottom: 10px;"';
								    			} else {
								    				$exstyles = '';
								    			}

												if (is_user_logged_in()) {
												$current_user = wp_get_current_user();
												$user_id = $current_user->ID;
												$val2 = $current_user->user_email;
												$rowval = '';//' style="display:none!important;"';
												$val1 = get_user_meta($user_id, 'first_name', true);
												$val1 .= ' '.get_user_meta($user_id, 'last_name', true);

													if (empty($val1) || $val1 == ' ') {
														$val1 = $current_user->user_login;
														if (empty($val1) || $val1 == ' ') {
															$val1 = 'user';
														}
													} 

													$val3 = get_user_meta($user_id, 'user_mobile', true);
												    if ($val3 == '') {
												      $val3 = get_user_meta($user_id, 'user_phone', true);
												    }
												

													$namefield = '<section'.$exstyles.'><label class="lbl-ui"><input type="text" name="name" class="input" placeholder="'.esc_html__('Name  & Surname','pointfindert2d').'" value="'.$val1.'" /></label></section>';
													$emailfield = '<section'.$exstyles.'><label class="lbl-ui"><input type="email" name="email" class="input" placeholder="'.esc_html__('Email Address','pointfindert2d').'" value="'.$val2.'"/></label></section>  ';
													$phonefield = '<section><label class="lbl-ui"><input type="tel" name="phone" class="input" placeholder="'.esc_html__('Phone Number','pointfindert2d').'" value="'.$val3.'"/></label></section>';
												}else{
													$namefield = '<section'.$exstyles.'><label class="lbl-ui"><input type="text" name="name" class="input" placeholder="'.esc_html__('Name  & Surname','pointfindert2d').'"/></label></section>';
													$emailfield = '<section'.$exstyles.'><label class="lbl-ui"><input type="email" name="email" class="input" placeholder="'.esc_html__('Email Address','pointfindert2d').'"/></label></section>  ';
													$phonefield = '<section'.$exstyles.'><label class="lbl-ui"><input type="tel" name="phone" class="input" placeholder="'.esc_html__('Phone Number','pointfindert2d').'"/></label></section>  ';
												}

								    			
								    			
												$tabinside .= '
												<div class="golden-forms">
													<div id="pfmdcontainer-overlaynew" class="pftrwcontainer-overlay"></div>
													<form id="pf-ajax-enquiry-form">
													    <div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button">'.esc_html__('CLOSE','pointfindert2d').'</a></div>
													    <div class="row"'.$rowval.'><div class="col6 first">'.$namefield.'</div><div class="col6 last">'.$phonefield.'</div></div>
													    <div class="row"'.$rowval.'><div class="col12">'.$emailfield.'</div></div>
													    <section'.$exstyles.'><label class="lbl-ui"><textarea name="msg" class="textarea no-resize" placeholder="'.esc_html__('Message','pointfindert2d').'" ></textarea></label></section> 
													    '.$recaptcha2.'
													    <section'.$exstyles.'><input type="hidden" name="itemid" class="input" value="'.get_the_id().'"/><button id="pf-ajax-enquiry-button" class="button blue">'.esc_html__('Send Contact Form','pointfindert2d').'</button></section>                
													</form>
												</div>			
												';
												
												$tabinside .= '</div>';
											}

										

										$tabinside .= '</div>';
									$tabinside .= '</section>';
									$tabinside .= '</div>';
								}
							/**
							*End: User Contact
							**/
						
							
							/**
							*Start: Agent Contact
							**/
								if ($show_agentcon == 1) {

									$kx = 0;
									$tabinside .= '<div class="ui-tab'.$i.' hidden-print">';
									$tabinside .= '<section role="itempagesidebarinfo" class="pf-itempage-sidebarinfo pfpos2 pf-itempage-elements">';
									$tabinside .= '<div id="pf-itempage-sidebarinfo"><div class="pf-row clearfix">';

									if ($show_agent_user_con == 1) {
										$item_agents = $user_agent_link;
										$item_agents_count = 1;
									}

									$item_agent = $item_agents;
										
										if ($kx <= 1) {
										
										
											$agent_featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id( $item_agent ), 'full' );

											if (empty($agent_featured_image)) {
												$user_photo = '<img src="'.get_template_directory_uri().'/images/empty_avatar.jpg"/>';
											}else{
												$user_photo = '<img src="'.$agent_featured_image[0].'" width="'.$agent_featured_image[1].'" height="'.$agent_featured_image[2].'" alt="" />';
											}

											$user_description = get_the_content($item_agent);
											$user_phone = esc_attr(get_post_meta( $item_agent, 'webbupointfinder_agent_tel', true ));
											$user_mobile = esc_attr(get_post_meta( $item_agent, 'webbupointfinder_agent_mobile', true ));
											$user_web = esc_attr(get_post_meta( $item_agent, 'webbupointfinder_agent_web', true ));
											$user_email = sanitize_email(get_post_meta( $item_agent, 'webbupointfinder_agent_email', true ));
											
											if($setup42_itempagedetails_contact_photo == 0){$user_photo = '';}
											$ex_text = '';
											

											$contact_user_title = get_the_title($item_agent);

											
											if($user_photo != ''){
												$tabinside .= '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 pfcols">';
												$tabinside .= '<div class="pf-itempage-sidebarinfo-photo"><a href="'.get_permalink($item_agent).'" >'.$user_photo.'</a></div>';
												
											
											
												$tabinside .= '</div>';
												$tabinside .= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 pfcols">';
											}else{
												if ($setup42_itempagedetails_contact_form == 0) {
													$tabinside .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pfcols">';
												}else{
													$tabinside .= '<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pfcols">';
												}
											}
											
										
											
											$tabinside .= '<div class="pf-itempage-sidebarinfo-userdetails pfpos2'.$ex_text.'">
												<ul>';
												if($setup42_itempagedetails_contact_moreitems == 1){
													/*$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="'.get_permalink($item_agent).'" ><i class="pfadmicon-glyph-632"></i> '.esc_html__("Full profile",'pointfindert2d').'</a></li>';*/
												
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="'.get_permalink($item_agent).'"><i class="pfadmicon-glyph-510"></i> '.esc_html__("Other items",'pointfindert2d').'</a></li>';
												}
												if(!empty($user_phone ) && $setup42_itempagedetails_contact_phone == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="tel:'.antispambot($user_phone).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-765"></i> '.$user_phone.'</a></li>';
												}
												if(!empty($user_mobile) && $setup42_itempagedetails_contact_mobile == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="tel:'.antispambot($user_mobile).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-351"></i> '.$user_mobile.'</a></li>';
												}
												if(!empty($user_email) && $setup42_itempagedetails_contact_email == 1){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="mailto:'.antispambot( $user_email).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-823"></i> '.esc_html__("Email Us!","pointfindert2d").'</a></li>';
												}
												if(!empty($user_web)){
													$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="http://'.$user_web.'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-592"></i> '.$user_web.'</a></li>';
												}
												

												$tabinside .= '</ul>
											</div>';
											$tabinside .= '</div>';


											if ($setup42_itempagedetails_contact_form == 1) {
												if($user_photo != ''){
												
													if ($setup42_itempagedetails_contact_phone == 0 && $setup42_itempagedetails_contact_mobile == 0 && $setup42_itempagedetails_contact_email == 0 && $setup42_itempagedetails_contact_moreitems == 0) {
														$tabinside .= '<div class="col-lg-9 col-md-6 col-sm-6 col-xs-12 pfcols">';
													}else{
														$tabinside .= '<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 pfcols">';
													}
												}else{
													if ($setup42_itempagedetails_contact_phone == 0 && $setup42_itempagedetails_contact_mobile == 0 && $setup42_itempagedetails_contact_email == 0 && $setup42_itempagedetails_contact_moreitems == 0) {
														$tabinside .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pfcols">';
													}else{
														$tabinside .= '<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pfcols">';
													}
												
												}
												$pfrecheck = PFRECIssetControl('setupreCaptcha_general_status','','0');
												$recaptcha2 = '';
												
												$pfrechecklg = PFRECIssetControl('setupreCaptcha_general_con_agent_status','','0');

												if ( $pfrecheck == 1 && $pfrechecklg != 1) {
													$recaptcha2 = '';
												}elseif ( $pfrecheck == 1 && $pfrechecklg == 1) {
													$recaptcha2 = '<section style="margin-bottom: 10px;"><div id="recaptcha_div_mod">';
													$recaptcha2 .= '<div id="g_recaptcha_agentcontact" class="g-recaptcha-field" data-rekey="widgetIdagentcontact"></div>';
													$recaptcha2 .= '</div></section>';
												}

									  			$val1 = $val2 = $val3 = $rowval = '';

									  			if (!empty($recaptcha2)) {
								    				$exstyles = ' style="margin-bottom: 10px;"';
								    			} else {
								    				$exstyles = '';
								    			}

												if (is_user_logged_in()) {
												$current_user = wp_get_current_user();
												$user_id = $current_user->ID;
												$val2 = $current_user->user_email;
												$rowval = '';//' style="display:none!important;"';
												$val1 = get_user_meta($user_id, 'first_name', true);
												$val1 .= ' '.get_user_meta($user_id, 'last_name', true);
													if (empty($val1) || $val1 == ' ') {
														$val1 = $current_user->user_login;
														if (empty($val1) || $val1 == ' ') {
															$val1 = 'user';
														}
													} 
												$val3 = get_user_meta($user_id, 'user_mobile', true);
												    if ($val3 == '') {
												      $val3 = get_user_meta($user_id, 'user_phone', true);
												    }

													$namefield = '<section'.$exstyles.'><label class="lbl-ui"><input type="text" name="name" class="input" placeholder="'.esc_html__('Name  & Surname','pointfindert2d').'" value="'.$val1.'" /></label></section>';
													$emailfield = '<section'.$exstyles.'><label class="lbl-ui"><input type="email" name="email" class="input" placeholder="'.esc_html__('Email Address','pointfindert2d').'" value="'.$val2.'"/></label></section>  ';
													$phonefield = '<section><label class="lbl-ui"><input type="tel" name="phone" class="input" placeholder="'.esc_html__('Phone Number','pointfindert2d').'" value="'.$val3.'"/></label></section>';
												}else{
												$namefield = '<section'.$exstyles.'><label class="lbl-ui"><input type="text" name="name" class="input" placeholder="'.esc_html__('Name  & Surname','pointfindert2d').'"/></label></section>';
												$emailfield = '<section'.$exstyles.'><label class="lbl-ui"><input type="email" name="email" class="input" placeholder="'.esc_html__('Email Address','pointfindert2d').'"/></label></section>  ';
												$phonefield = '<section'.$exstyles.'><label class="lbl-ui"><input type="tel" name="phone" class="input" placeholder="'.esc_html__('Phone Number','pointfindert2d').'"/></label></section>  ';
												}

							    			
							    			
												$tabinside .= '
												<div class="golden-forms">
													<div id="pfmdcontainer-overlaynew" class="pftrwcontainer-overlay"></div>
													<form id="pf-ajax-enquiry-form">
													    <div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button">'.esc_html__('CLOSE','pointfindert2d').'</a></div>
													    <div class="row"'.$rowval.'><div class="col6 first">'.$namefield.'</div><div class="col6 last">'.$phonefield.'</div></div>
													    <div class="row"'.$rowval.'><div class="col12">'.$emailfield.'</div></div>
													    <section'.$exstyles.'><label class="lbl-ui"><textarea name="msg" style="max-width:99.99%;" class="textarea no-resize" placeholder="'.esc_html__('Message','pointfindert2d').'" ></textarea></label></section> 
													    '.$recaptcha2.'
													    <section'.$exstyles.'><input type="hidden" name="itemid" class="input" value="'.get_the_id().'"/><button id="pf-ajax-enquiry-button" class="button blue">'.esc_html__('Send Contact Form','pointfindert2d').'</button></section>                
													</form>
												</div>			
												';
												$tabinside .= '</div>';
										}
										$kx++;
									
										
									}
									$tabinside .= '</div>';
									$tabinside .= '</div>';
									$tabinside .= '</section>';
									$tabinside .= '</div>';
								}
							/**
							*End: Agent Contact
							**/
							
							if ($i > 1 && ($show_agentcon == 1 || $show_usercon == 1) ) {
								

								$tabcontactform = '<div class="pftrwcontainer hidden-print pf-itempagedetail-element pf-itempage-contactinfo">
									<div class="pfitempagecontainerheader">'.$contact_user_title.'</div>
									<div class="pfmaincontactinfo">';
								$tabcontactform .= $tabinside;
								$tabcontactform .= '</div>
								</div>';
								$tabinside = '';
							}

						
					/** 
					*End: Contact 
					**/
				}
				break;

			case 'details':
			case 'ohours':
			case 'features':
				$tabinside = '';
				break;
			case 'customtab1':
			case 'customtab2':
			case 'customtab3':
				$tabinside = '';
				if ($value['status'] == 1) {
					switch ($key) {case 'customtab1':$ctabid = 1;break;case 'customtab2':$ctabid = 2;break;case 'customtab3':$ctabid = 3;break;}
					$customb_content = get_post_meta( $the_post_id, 'webbupointfinder_item_custombox'.$ctabid, true );
					if (!empty($customb_content)) {
						
						/** 
						*Start: Custom Tab x 
						**/
							$tabinside .= '<div class="ui-tab'.$i.' hidden-print">';
								$tabinside .= '<section role="itempagecustomtabs" class="pf-itempage-customtabs pf-itempage-elements">';
									$tabinside .= '<div id="pf-itempage-customtabs'.$i.'">';
										$tabinside .= do_shortcode($customb_content);
									$tabinside .= '</div>';
								$tabinside .= '</section>';
							$tabinside .= '</div>';
						/** 
						*End: Custom Tab x
						**/

						if($i > 1){
							$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
							$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.$value['title'].'</span></label>';
						}
					}else{
						$tabinside = '';
					}
				}
				break;

			
		}

		if ($key == 'contact' && $value['status'] == 1) {
			$contact_check_re = 1;
		}


		$excludeobj_arr = array('twitter','description','video','contact','streetview','gallery','customtab1','customtab2','customtab3');
		$itemvalimg = '';

		if($i > 1 && !in_array($key, $excludeobj_arr)){
			if ($value['status'] == 1 && $key != 'location') {
				$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
				$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.$value['title'].'</span></label>';
			}elseif ($value['status'] == 1 && $key == 'location') {
				if (pf_get_listingmeta_limit($listing_meta, $item_term, 'pf_address_area') == 1) {
					$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
					$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.$value['title'].'</span></label>';
				}
			}
		}elseif($i > 1 && $key == 'description'){
			if ($value['status'] == 1) {
				$taboutside_w1 .= '<input class="ui-tab'.$i.'" type="radio" id="tgroup_f_tab'.$i.'" name="tgroup_f" '.$valtext.' />';
				$taboutside_w2 .= '<label id="pfidp'.$key.'" class="ui-tab'.$i.' hidden-print" for="tgroup_f_tab'.$i.'"><span class="pfitp-title">'.esc_html__('Information','pointfindert2d').'</span></label>';
		}	}

		if ($i > 1) {
			if ($value['status'] == 1) {
				$tabinside_output .= $tabinside;
			}
		}else{
			if ($value['status'] == 1) {
				$tabinside_first .= '<div class="pf-itempagedetail-element pf-tabfirst"><div class="pf-itempage-firsttab">'.$tabinside.'</div></div>';
			}
			
		}
		if ($value['status'] == 1 && ($key != 'contact' && $key != 'details' && $key != 'ohours' && $key != 'features' && $key != 'twitter' && $key != 'description')) {
			$i++;
		}
		
	}
	
	echo $tabinside_first;
	
	/** 
	*Start: Share bar 
	**/
		get_template_part('admin/estatemanagement/includes/pages/itemdetail/sharebar','part');
	/** 
	*End: Share bar 
	**/


	echo '<div class="pftabcontainer  pf-itempagedetail-element">';
		echo '<div class="ui-tabgroup">';
		echo $taboutside_w1;

			echo '<div class="ui-tabs">';
			echo $taboutside_w2;
			echo '</div>';

			echo '<div class="ui-panels">';
			echo $tabinside_output;
			echo '</div>';
			

		echo '</div>';
	echo '</div>';


	/**
	*Start: Tags Widget
	**/
		$this_tags = wp_get_post_tags($the_post_id);

		if (!empty($this_tags)) {
			echo pfitempage_tags_block();
		}
	/**
	*End: Tags Widget
	**/


	/**
	*Start: Files Widget
	**/
		echo pfitempage_files_block();
	/**
	*End: Files Widget
	**/


	/**
	*Start: Features Widget
	**/
		if ($features_list_permission == 1) {

			$cat_extra_opts = get_option('pointfinderltypes_covars');
			$multiple_select = (isset($cat_extra_opts[$item_term]['pf_multipleselect']))?$cat_extra_opts[$item_term]['pf_multipleselect']:2;
			$subcat_select = (isset($cat_extra_opts[$item_term]['pf_subcatselect']))?$cat_extra_opts[$item_term]['pf_subcatselect']:2;
			$cols = 4;
			echo pfitempage_features_block($cols,$subcat_select,$multiple_select);
		}
	/**
	*End: Features Widget
	**/


	/**
	*Start: Contact Widget
	**/
		echo $tabcontactform;
	/**
	*End: Contact Widget
	**/


	/**
	*Start: Review System
	**/
		if ($review_list_permission == 1) {
			get_template_part('admin/estatemanagement/includes/pages/itemdetail/review','part');
		}
	/**
	*End: Review System
	**/


	/**
	*Start: Comment System
	**/
		if ($comment_list_permission == 1) {
			get_template_part('admin/estatemanagement/includes/pages/itemdetail/comment','part');
		}
	/**
	*End: Comment System
	**/
	echo '</div>';


	/**
	*Start: Recaptcha for Agent Contact and Review Form
	* Added with v1.0.6
	**/
	$pfrecheck = PFRECIssetControl('setupreCaptcha_general_status','','0');
	$pfrecheckrv = PFRECIssetControl('setupreCaptcha_general_rev_status','','0');
	$pfrechecklg = PFRECIssetControl('setupreCaptcha_general_con_agent_status','','0');
	$setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');

	if($pfrecheck == 1){
		
		
		if(($setup11_reviewsystem_check != 0 && $review_list_permission == 1) || $contact_check_re != 0){
			$publickey = PFRECIssetControl('setupreCaptcha_general_pubkey','','');
			$lang = PFRECIssetControl('setupreCaptcha_general_lang','','en');
			echo '
			<script type="text/javascript">
				var PFFonloadCallback = function() {';
			if ($pfrechecklg == 1 && $contact_check_re == 1) {
				echo 'var g_recaptcha_agentcontact = grecaptcha.render("g_recaptcha_agentcontact", {"sitekey" : "'.$publickey.'"});';
			}
			if ($pfrecheckrv == 1 && $setup11_reviewsystem_check == 1 && $review_list_permission == 1) {
				echo 'var g_recaptcha_reviewformex = grecaptcha.render("g_recaptcha_reviewformex", {"sitekey" : "'.$publickey.'"});';
			}
			echo '	
				};
		    </script>
			<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl='.$lang.'&onload=PFFonloadCallback&render=explicit" async defer></script>';
		}
	}

	/**
	*End: Recaptcha for Agent Contact and Review Form
	**/
}




function PFGetItemPageCol2($pointfinder_customsidebar){

	echo '<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 hidden-print">';
	echo '<section role="itempagesidebar" class="pf-itempage-sidebar">';
		echo '<div id="pf-itempage-sidebar">';
			echo '<div class="sidebar-widget">';
				if (!empty($pointfinder_customsidebar)) {
					if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($pointfinder_customsidebar));
				}else{
					if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('pointfinder-itempage-area'));
				}
			echo '</div>';
		echo '</div>';
	echo '</section>';
	echo '</div>';
}


?>
