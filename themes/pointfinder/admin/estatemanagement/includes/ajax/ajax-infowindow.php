<?php

/**********************************************************************************************************************************
*
* Ajax Info Window Get Results
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


	add_action( 'PF_AJAX_HANDLER_nopriv_pfget_infowindow', 'pf_ajax_infowindow' );
	add_action( 'PF_AJAX_HANDLER_pfget_infowindow', 'pf_ajax_infowindow' );


function pf_ajax_infowindow(){
	check_ajax_referer( 'pfget_infowindow', 'security' );
    header('Content-Type: text/html; charset=UTF-8;');

	if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
		$id = esc_attr($_REQUEST['id']);
		
		
		/** 
		*Start: ajax-infowindow.php Functions
		**/
			function PFCheckMultipleMarker($coordinates,$id){
				if (PFControlEmptyArr($coordinates)) {
					$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
					$args = array('post_type' => $setup3_pointposttype_pt1,'meta_query' => array(array('key' => 'webbupointfinder_items_location','value' => ''.$coordinates[0].','.$coordinates[1].'')),'fields' => 'ids');
					$q_vid = new WP_Query( $args );
					if ( ! empty( $q_vid->posts ) ) {
						$posts = $q_vid->posts;
						wp_reset_postdata();
						if(count($posts) > 1){
							return $posts;
						}else{
							return array();
						}
					}else{
						wp_reset_postdata();
						return array();
					}
				}else{
					return array();
				}
			}

			function PFIF_ItemDetails($id){
				$ItemDetailArr = array();
				$setup10_infowindow_img_width  = PFSAIssetControl('setup10_infowindow_img_width','','154');
				$setup10_infowindow_img_height  = PFSAIssetControl('setup10_infowindow_img_height','','136');
				$setup10_infowindow_hide_image  = PFSAIssetControl('setup10_infowindow_hide_image','','0');
				$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
				if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}
				
				$setup10_infowindow_img_width  = $setup10_infowindow_img_width*$pf_retnumber;
				$setup10_infowindow_img_height  = $setup10_infowindow_img_height*$pf_retnumber;
			
				$itemvars[$id]['featured_image']  = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
				if( $setup10_infowindow_hide_image == 0){
					$ItemDetailArr['featured_image_big'] = $itemvars[$id]['featured_image'][0];
					if($itemvars[$id]['featured_image'][0] != '' && $itemvars[$id]['featured_image'][0] != NULL){$ItemDetailArr['featured_image'] = aq_resize($itemvars[$id]['featured_image'][0],$setup10_infowindow_img_width,$setup10_infowindow_img_height,true);}else{$ItemDetailArr['featured_image'] = '';}
					
					if($ItemDetailArr['featured_image'] === false) {
						if($general_retinasupport == 1){
							$ItemDetailArr['featured_image'] = aq_resize($itemvars[$id]['featured_image'][0],$setup10_infowindow_img_width/2,$setup10_infowindow_img_height/2,true);
							if($ItemDetailArr['featured_image'] === false) {
								$ItemDetailArr['featured_image'] = $itemvars[$id]['featured_image'][0];
							}
						}else{
							$ItemDetailArr['featured_image'] = '';
						}
						
					}
				}else{
					$ItemDetailArr['featured_image'] = '';
					$ItemDetailArr['featured_image_big'] = '';
				}
				//Title
				$ItemDetailArr['if_title'] = html_entity_decode(get_the_title($id));
				//Featured Video
				$ItemDetailArr['featured_video'] =  get_post_meta( $id, 'webbupointfinder_item_video', true );
				//Permalink
				$ItemDetailArr['if_link'] = get_permalink($id);
				//Address
				$ItemDetailArr['if_address'] = esc_html(get_post_meta( $id, 'webbupointfinder_items_address', true )); //9 word limit for address
				
				return $ItemDetailArr;
			}

			function PFIF_OutputData($itemvars,$id){
				$output_data = '';
				$st22srlinknw = PFSAIssetControl('st22srlinknw','','0');
				$targetforitem = '';
				if ($st22srlinknw == 1) {
					$targetforitem = ' target="_blank"';
				}
				$setup10_infowindow_animation_image  = PFSAIssetControl('setup10_infowindow_animation_image','','WhiteSquare');
				$setup10_infowindow_hover_image  = PFSAIssetControl('setup10_infowindow_hover_image','','0');
				$setup10_infowindow_hover_video  = PFSAIssetControl('setup10_infowindow_hover_video','','0');
				$setup10_infowindow_hide_address  = PFSAIssetControl('setup10_infowindow_hide_address','','0');
				
				$setup16_featureditemribbon_hide = PFSAIssetControl('setup16_featureditemribbon_hide','','1');
				$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');

				if (is_user_logged_in()) {
					$user_favorites_arr = get_user_meta( get_current_user_id(), 'user_favorites', true );
					if (!empty($user_favorites_arr)) {
						$user_favorites_arr = json_decode($user_favorites_arr,true);
					}else{
						$user_favorites_arr = array();
					}
				}			

				$pfbuttonstyletext = 'pfHoverButtonStyle ';
							
				switch($setup10_infowindow_animation_image){
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
				
				$single_point = 0;

				if(isset($_POST['single']) && !empty($_POST['single'])){
					$single_point = esc_attr($_POST['single']);
				}
				$disable_itempr = (!empty($_POST['disable']))?esc_attr($_POST['disable']):0;
			
				
				if($itemvars['featured_image'] != ''){
					$output_data .= "<div class='wpfimage clearfix'><div class='wpfimage-wrapper clearfix'>";
						$setup10_infowindow_hide_ratings = PFSAIssetControl('setup10_infowindow_hide_ratings','','1');
						if($setup10_infowindow_hover_image == 1 && $single_point == 0){
							$output_data .= "<a href='".$itemvars['if_link']."'".$targetforitem."><img src='".$itemvars['featured_image'] ."' alt='' /></a>";
							
							if($setup4_membersettings_favorites == 1 && $disable_itempr != 1){
												
								$fav_check = 'false';
								$favtitle_text = esc_html__('Add to Favorites','pointfindert2d');

								if (is_user_logged_in() && count($user_favorites_arr)>0) {
									if (in_array($id, $user_favorites_arr)) {
										$fav_check = 'true';
										$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
									}
								}

								$output_data .= '<div class="RibbonCTR">
		                            <span class="Sign"><a class="pf-favorites-link" data-pf-num="'.$id.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'"><i class="pfadmicon-glyph-629"></i></a>
		                            </span>
		                            <span class="Triangle"></span>
		                        </div>';
		                    }

		                    $setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);
		                    if ($setup3_pt14_check == 1) {

		                    	$item_defaultvalue = wp_get_post_terms($id, 'pointfinderconditions', array("fields" => "all"));
								if (isset($item_defaultvalue[0]->term_id)) {																
		            				$contidion_colors = pf_get_condition_color($item_defaultvalue[0]->term_id);

		            				$condition_c = (isset($contidion_colors['cl']))? $contidion_colors['cl']:'#494949';
		            				$condition_b = (isset($contidion_colors['bg']))? $contidion_colors['bg']:'#f7f7f7';

		                			$output_data .= '
		                			<div class="pfribbon-wrapper-featured3" style="color:'.$condition_c.';background-color:'.$condition_b.'">
		                			<div class="pfribbon-featured3">'.$item_defaultvalue[0]->name.'</div>
		                			</div>';
		            			}

		                    	
		                    }

		                    if ($setup16_featureditemribbon_hide != 0) {
		                    	$featured_marker = get_post_meta( $id, 'webbupointfinder_item_featuredmarker', true );
		                    	if (!empty($featured_marker)) {
		                			$output_data .= '
		                			<div class="pfribbon-wrapper-featured2">
		                			<div class="pfribbon-featured2">'.esc_html__('FEATURED','pointfindert2d').'</div>
		                			</div>';
		                    	}

		                    }

		                    if (PFREVSIssetControl('setup11_reviewsystem_check','','0') == 1 && $setup10_infowindow_hide_ratings == 0) {
		                    	$setup22_searchresults_hide_re = PFREVSIssetControl('setup22_searchresults_hide_re','','1');
		                    	$setup16_reviewstars_nrtext = PFREVSIssetControl('setup16_reviewstars_nrtext','','0');
		                    	if ($setup22_searchresults_hide_re == 0) {
		                    		$reviews = pfcalculate_total_review($id);
		                    		
		                    		if (!empty($reviews['totalresult'])) {
		                    			$rev_total_res = round($reviews['totalresult']);
		                    			
		                    			$output_data .= '<div class="pfrevstars-wrapper-review pf-infowindow-review">';
		                    			$output_data .= ' <div class="pfrevstars-review">';
		                    				for ($ri=0; $ri < $rev_total_res; $ri++) { 
		                    					$output_data .= '<i class="pfadmicon-glyph-377"></i>';
		                    				}
		                    				for ($ki=0; $ki < (5-$rev_total_res); $ki++) { 
		                    					$output_data .= '<i class="pfadmicon-glyph-378"></i>';
		                    				}

		                    			$output_data .= '</div></div>';
		                    		}else{
		                    			if($setup16_reviewstars_nrtext == 0){
		                        			$output_data .= '<div class="pfrevstars-wrapper-review pf-infowindow-review">';
		                        			$output_data .= ' <div class="pfrevstars-review">'.esc_html__('Not rated.','pointfindert2d').'';
		                        			$output_data .= '</div></div>';
		                    			}
		                    		}
		                    	}

		                    }

						}elseif($setup10_infowindow_hover_image == 0 && $single_point == 0){
							$output_data .= "<img src='".$itemvars['featured_image'] ."' alt='' />";

							if($setup4_membersettings_favorites == 1 && $disable_itempr != 1){
												
								$fav_check = 'false';
								$favtitle_text = esc_html__('Add to Favorites','pointfindert2d');

								if (is_user_logged_in() && count($user_favorites_arr)>0) {
									if (in_array($id, $user_favorites_arr)) {
										$fav_check = 'true';
										$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
									}
								}

								$output_data .= '<div class="RibbonCTR">
		                            <span class="Sign"><a class="pf-favorites-link" data-pf-num="'.$id.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'"><i class="pfadmicon-glyph-629"></i></a>
		                            </span>
		                            <span class="Triangle"></span>
		                        </div>';
		                    }

		                    if($disable_itempr != 1){
							$buton_q_text = ($setup10_infowindow_hover_video != 1 && !empty($itemvars['featured_video']))? 'pfStyleV':'pfStyleV2';
							$output_data .= '<div class="pfImageOverlayH"></div><div class="pfButtons '.$buton_q_text.' pfStyleVAni"><span class="'.$pfbuttonstyletext.' clearfix"><a class="pficon-imageclick" data-pf-link="'.$itemvars['featured_image_big'].'" style="cursor:pointer"><i class="pfadmicon-glyph-684"></i></a></span>';
							
							if($setup10_infowindow_hover_video != 1 && !empty($itemvars['featured_video'])){			
							$output_data .= '<span class="'.$pfbuttonstyletext.'"><a class="pficon-videoclick" data-pf-link="'.$itemvars['featured_video'] .'" style="cursor:pointer"><i class="pfadmicon-glyph-573"></i></a></span>';
							}
							
							$output_data .='<span class="'.$pfbuttonstyletext.'"><a href="'.$itemvars['if_link'].'"'.$targetforitem.'><i class="pfadmicon-glyph-794"></i></a></span></div>';
							}

							$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);
		                    if ($setup3_pt14_check == 1) {

		                    	$item_defaultvalue = wp_get_post_terms($id, 'pointfinderconditions', array("fields" => "all"));
								if (isset($item_defaultvalue[0]->term_id)) {																
		            				$contidion_colors = pf_get_condition_color($item_defaultvalue[0]->term_id);

		            				$condition_c = (isset($contidion_colors['cl']))? $contidion_colors['cl']:'#494949';
		            				$condition_b = (isset($contidion_colors['bg']))? $contidion_colors['bg']:'#f7f7f7';

		                			$output_data .= '
		                			<div class="pfribbon-wrapper-featured3" style="color:'.$condition_c.';background-color:'.$condition_b.'">
		                			<div class="pfribbon-featured3">'.$item_defaultvalue[0]->name.'</div>
		                			</div>';
		            			}

		                    	
		                    }



							if ($setup16_featureditemribbon_hide != 0) {
		                    	if (PFcheck_postmeta_exist('webbupointfinder_item_featuredmarker',$id)) {
		                    		if (esc_attr(get_post_meta( $id, 'webbupointfinder_item_featuredmarker', true )) == 1) {
		                    			$output_data .= '
		                    			<div class="pfribbon-wrapper-featured2">
		                    			<div class="pfribbon-featured2">'.esc_html__('FEATURED','pointfindert2d').'</div>
		                    			</div>';
		                    		}
		                    	}

		                    }


		                    if (PFREVSIssetControl('setup11_reviewsystem_check','','0') == 1 && $setup10_infowindow_hide_ratings == 0) {
		                    	$setup22_searchresults_hide_re = PFREVSIssetControl('setup22_searchresults_hide_re','','1');
		                    	$setup16_reviewstars_nrtext = PFREVSIssetControl('setup16_reviewstars_nrtext','','0');

		                    	if ($setup22_searchresults_hide_re == 0) {

		                    		$reviews = pfcalculate_total_review($id);
		                    		if (!empty($reviews['totalresult'])) {
		                    			$rev_total_res = round($reviews['totalresult']);
		                    			$output_data .= '<div class="pfrevstars-wrapper-review pf-infowindow-review">';
		                    			$output_data .= ' <div class="pfrevstars-review">';
		                    				for ($ri=0; $ri < $rev_total_res; $ri++) { 
		                    					$output_data .= '<i class="pfadmicon-glyph-377"></i>';
		                    				}
		                    				for ($ki=0; $ki < (5-$rev_total_res); $ki++) { 
		                    					$output_data .= '<i class="pfadmicon-glyph-378"></i>';
		                    				}

		                    			$output_data .= '</div></div>';
		                    		}else{
		                    			if($setup16_reviewstars_nrtext == 0){
		                        			$output_data .= '<div class="pfrevstars-wrapper-review pf-infowindow-review">';
		                        			$output_data .= ' <div class="pfrevstars-review">  '.esc_html__('Not rated yet.','pointfindert2d').'';
		                        			$output_data .= '</div></div>';
		                    			}
		                    		}
		                    	}

		                    }

						}elseif($single_point == 1){
							$output_data .= "<img src='".$itemvars['featured_image'] ."'>";
						}
						
					$output_data .= "</div></div>";		
				}
				
				$limit_chr_title = PFSizeSIssetControl('setupsizelimitwordconf_general_infowindowtitle','',20);
				
				$title_extra = (strlen($itemvars['if_title'])<=$limit_chr_title ) ? '' : '...' ;
				$output_data .= "<div class='wpftext'>";
				$output_data .= "<span class='wpftitle'><a href='".$itemvars['if_link']."'".$targetforitem.">".mb_substr($itemvars['if_title'], 0, $limit_chr_title,'UTF-8').$title_extra."</a></span>";
				

				$limit_chr = PFSizeSIssetControl('setupsizelimitwordconf_general_infowindowaddress','',28);
				$limit_chr2 = $limit_chr*2;

				$setup10_infowindow_row_address = PFSAIssetControl('setup10_infowindow_row_address','','1');
				$addresscount = strlen($itemvars['if_address']);
				$addresscount = (strlen($itemvars['if_address'])<=$limit_chr ) ? '' : '...' ;
				
				if ($setup10_infowindow_row_address == 1) {
					$address_text = mb_substr($itemvars['if_address'], 0, $limit_chr,'UTF-8').$addresscount;
				}else{
					$address_text = mb_substr($itemvars['if_address'], 0, $limit_chr2,'UTF-8').$addresscount;
				}
				

				if($setup10_infowindow_hide_address == 0){
					$output_data .= "<span class='wpfaddress'>".$address_text."</span>";
				}
				
				$output_data .= "<span class='wpfdetail'>".PFIF_DetailText($id)."</span>";
				$output_data .= "</div>";
				return $output_data;
			}

			function PFIF_DetailText($id){
				//Current Language
				if(isset($_POST['cl']) && $_POST['cl']!=''){
					$pflang = esc_attr($_POST['cl']);
					
					if(function_exists('icl_t')) {
						if (!empty($pflang)) {
							do_action( 'wpml_switch_language', $pflang );
						}
					}
				}else{
					$pflang = '';
				}


				$setup10_infowindow_animation_image  = PFSAIssetControl('setup10_infowindow_animation_image','','WhiteSquare');
				$setup10_infowindow_hover_image  = PFSAIssetControl('setup10_infowindow_hover_image','','0');
				$setup10_infowindow_hover_video  = PFSAIssetControl('setup10_infowindow_hover_video','','0');
				$setup10_infowindow_hide_address  = PFSAIssetControl('setup10_infowindow_hide_address','','0');
				$setup10_infowindow_hide_lt  = PFSAIssetControl('setup10_infowindow_hide_lt','','0');
				$setup10_infowindow_hide_it  = PFSAIssetControl('setup10_infowindow_hide_it','','0');
				$setup10_infowindow_hide_lt = PFSAIssetControl('setup10_infowindow_hide_lt','','0');
				$setup10_infowindow_hide_it = PFSAIssetControl('setup10_infowindow_hide_it','','0');
				$setup14_multiplepointsettings_check = PFSAIssetControl('setup14_multiplepointsettings_check','','1');
				
				$pfstart = PFCheckStatusofVar('setup1_slides');
				
				if($pfstart == true){
					
					$if_detailtext = '<ul class="pfinfowindowdlist">';
					
						$PF_CF_Val = new PF_CF_Val($id);
						$setup1_slides = PFSAIssetControl('setup1_slides','','');	
						if(is_array($setup1_slides)){
							foreach ($setup1_slides as &$value) {
								
								$customfield_infocheck = PFCFIssetControl('setupcustomfields_'.$value['url'].'_sinfowindow','','0');
								$available_fields = array(1,2,3,4,5,7,8,14);
								
								if(in_array($value['select'], $available_fields) && $customfield_infocheck != 0){
									$ClassReturnVal = $PF_CF_Val->GetValue($value['url'],$id,$value['select'],$value['title']);
									if($ClassReturnVal != ''){
										$if_detailtext .= $ClassReturnVal;
									}
								}
								
							}
						}
						unset($PF_CF_Val);
						
					
					if($setup10_infowindow_hide_lt == 0){
						
						$setup10_infowindow_hide_lt_text = PFSAIssetControl('setup10_infowindow_hide_lt_text','','');
						if($setup10_infowindow_hide_lt_text != ''){ $pfitemtext = $setup10_infowindow_hide_lt_text;}else{$pfitemtext = '';}
						$if_detailtext .= '<li class="pfiflitype pfliittype"><span class="wpfdetailtitle">'.$pfitemtext.'</span>';
						if($pfitemtext != ''){
							$if_detailtext .= ' '.GetPFTermInfoWindow($id,'pointfinderltypes',$pflang).'<span class="pf-fieldspace"></span></li>';
						}else{
							$if_detailtext .= ' <span class="wpfdetailtitle">'.GetPFTermInfoWindow($id,'pointfinderltypes',$pflang).'</span><span class="pf-fieldspace"></span></li>';
						}
					}
					
					
					
					if($setup10_infowindow_hide_it == 0){
						$setup10_infowindow_hide_it_text = PFSAIssetControl('setup10_infowindow_hide_it_text','','');
						if($setup10_infowindow_hide_it_text != ''){ $pfitemtext = $setup10_infowindow_hide_it_text;}else{$pfitemtext = '';}
						$if_detailtext .= '<li class="pfifittype pfliittype"><span class="wpfdetailtitle">'.$pfitemtext.'</span>';
						if($pfitemtext != ''){
							$if_detailtext .= ' '.GetPFTermInfoWindow($id,'pointfinderitypes',$pflang).'<span class="pf-fieldspace"></span></li>';
						}else{
							$if_detailtext .= ' <span class="wpfdetailtitle">'.GetPFTermInfoWindow($id,'pointfinderitypes',$pflang).'</span><span class="pf-fieldspace"></span></li>';
						}
					}
					
					$if_detailtext .= '</ul>';
				
				}
				unset($PF_CF_Val);
				return $if_detailtext;
			}
		/** 
		*End: ajax-infowindow.php Functions
		**/
		

		$multiplemarkers = array();

		$coordinates = explode( ',', esc_attr(get_post_meta( $id, 'webbupointfinder_items_location', true )) );
		$multiplemarkers[0] = PFCheckMultipleMarker($coordinates,$id);
		
		
		/*Info Window*/
		$output_data = '';
		$itemvars = array();

		if(count($multiplemarkers[0])>0 && $setup14_multiplepointsettings_check == 1){
		$output_data .= '<div id="pf_infowindow_owl" class="owl-carousel">';

			foreach($multiplemarkers[0] as $multiplemarker){
				$output_data .= '<div class="item">';
				$itemvars[$multiplemarker] = PFIF_ItemDetails($multiplemarker);
				$output_data .= PFIF_OutputData($itemvars[$multiplemarker],$multiplemarker);
				$output_data .= '</div>';
			}
		$output_data .= '</div>';
		$output_data .= "<div class='pfifprev pfifbutton'><i class='pfadmicon-glyph-857'></i></div><div class='pfifnext pfifbutton'><i class='pfadmicon-glyph-858'></i></div>";
		}else{
			$itemvars[$id] = PFIF_ItemDetails($id);
			$output_data .= PFIF_OutputData($itemvars[$id],$id);
		}
		
		$output_data .= "<div class='wpf-closeicon'><i class='pfadmicon-glyph-65'></i></div>";
	}
	
	echo $output_data;
	die();
}

?>