<?php

/**********************************************************************************************************************************
*
* Ajax POI data
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


	add_action( 'PF_AJAX_HANDLER_pfget_markers', 'pf_ajax_markers' );
	add_action( 'PF_AJAX_HANDLER_nopriv_pfget_markers', 'pf_ajax_markers' );
	
	
function pf_ajax_markers(){
	check_ajax_referer( 'pfget_markers', 'security' );
	header('Content-type: text/javascript');		
	
		if(isset($_POST['cl']) && $_POST['cl']!=''){
			$pflang = esc_attr($_POST['cl']);
		}else{
			$pflang = '';
		}

		/* WPML Fix */
		if(function_exists('icl_t')) {
			if (!empty($pflang)) {
				do_action( 'wpml_switch_language', $pflang );
			}
		}



		/** 
		*Start: ajax-poidata.php Functions
		**/
			
			function pf_term_sub_check($myval){
				$term_sub_check = get_term_by( 'term_id', $myval, 'pointfinderltypes');
			
				if ($term_sub_check != false) {

					if ($term_sub_check->parent == 0) {
						$output = $myval;
					}else{
						$output = pf_term_sub_check($term_sub_check->parent);
					}
				}else{
					$output = $myval;
				}

				return $output;
			}

			function pf_term_sub_check_ex($myval){
				$term_sub_check = get_term_by( 'term_id', $myval, 'pointfinderltypes');
			
				if ($term_sub_check != false) {

					if ($term_sub_check->parent == 0) {
						return true;
					}else{
						return false;
					}
				}
			}

			/** 
			*Start: GET - Marker Point Vars
			**/
				function pf_get_markerimage($postid,$setup8_pointsettings_pointopacity,$setup8_pointsettings_retinapoints,$st8_npsys){
					
					$pfitemicon = array();

					/* Check if item have a custom icon */

					$webbupointfinder_item_point_type = esc_attr(get_post_meta( $postid, "webbupointfinder_item_point_type", true ));
					$webbupointfinder_item_point_typenew = (empty($webbupointfinder_item_point_type))? 3:$webbupointfinder_item_point_type;

					switch ($webbupointfinder_item_point_typenew) {
						case 1:
							$pf_custom_point_images = redux_post_meta("pointfinderthemefmb_options", $postid, "webbupointfinder_item_custom_marker");

							/** 
							*Start: Custom icon check result = Image Icon
							**/
								$pfitemicon['is_image'] = 1;
								$pfitemicon['is_cat'] = 0;

								$pf_custom_point_image_height = (!empty($pf_custom_point_images['height']))? $pf_custom_point_images['height'] : 0;
								$pf_custom_point_image_width = (!empty($pf_custom_point_images['width']))? $pf_custom_point_images['width'] : 0;

								$retina_number = ($setup8_pointsettings_retinapoints == 1)?2:1;

								$width_calculated = $pf_custom_point_image_width/$retina_number;
								$height_calculated = $pf_custom_point_image_height/$retina_number;

								$pfitemicon['content']= '<div class=\'pf-map-pin-x\' style=\'background-image:url('.$pf_custom_point_images['url'].'); background-size:'.$width_calculated.'px '.$height_calculated.'px; width:'.$width_calculated.'px; height:'.$height_calculated.'px;opacity:'.$setup8_pointsettings_pointopacity.'\' ></div>';
							/** 
							*End: Custom icon check result = Image Icon
							**/
						break;

					case 2:

						/** 
						*Start: Custom icon check result = Css Icon
						**/
							$cssmarker_icontype = esc_attr(get_post_meta( $postid, 'webbupointfinder_item_cssmarker_icontype', true ));
							$cssmarker_icontype = (empty($cssmarker_icontype)) ? 1 : $cssmarker_icontype ;
							$cssmarker_iconsize = esc_attr(get_post_meta( $postid, 'webbupointfinder_item_cssmarker_iconsize', true ));
							$cssmarker_iconsize = (empty($cssmarker_iconsize)) ? 'middle' : $cssmarker_iconsize ;
							$cssmarker_iconname = esc_attr(get_post_meta( $postid, 'webbupointfinder_item_cssmarker_iconname', true ));

							$cssmarker_bgcolor = esc_attr(get_post_meta( $postid, 'webbupointfinder_item_cssmarker_bgcolor', true ));
							$cssmarker_bgcolor = (empty($cssmarker_bgcolor)) ? '#b00000' : $cssmarker_bgcolor ;
							$cssmarker_bgcolorinner = esc_attr(get_post_meta( $postid, 'webbupointfinder_item_cssmarker_bgcolorinner', true ));
							$cssmarker_bgcolorinner = (empty($cssmarker_bgcolorinner)) ? '#ffffff' : $cssmarker_bgcolorinner ;
							$cssmarker_iconcolor = esc_attr(get_post_meta( $postid, 'webbupointfinder_item_cssmarker_iconcolor', true ));
							$cssmarker_iconcolor = (empty($cssmarker_iconcolor)) ? '#b00000' : $cssmarker_iconcolor ;
							
							$arrow_text = ($cssmarker_icontype == 2)? '<div class=\'pf-pinarrow\' style=\'border-color: '.$cssmarker_bgcolor.' transparent transparent transparent;\'></div>': '';

							$pfitemicon['is_image'] = 1;
							$pfitemicon['is_cat'] = 0;

							$pfitemicon['content'] = '';
							
							
							$pfitemicon['content'] .= '<div ';
							$pfitemicon['content'] .= 'class=\'pfcatdefault-mapicon pf-map-pin-'.$cssmarker_icontype.' pf-map-pin-'.$cssmarker_icontype.'-'.$cssmarker_iconsize.' pfcustom-mapicon-'.$postid.'\'';
							$pfitemicon['content'] .= ' style=\'background-color:'.$cssmarker_bgcolor.';opacity:'.$setup8_pointsettings_pointopacity.';\' >';
							$pfitemicon['content'] .= '<i class=\''.$cssmarker_iconname.'\' style=\'color:'.$cssmarker_iconcolor.'\' ></i></div>'.$arrow_text;
							$pfitemicon['content'] .= '<style>.pfcustom-mapicon-'.$postid.':after{background-color:'.$cssmarker_bgcolorinner.'!important}</style>';

						/** 
						*End: Custom icon check result = Css Icon
						**/	
						break;

					default:
						/** 
						*Start: Check category icon 
						**/
							$pfitemicon['is_image'] = 0;
							$pfitemicon['is_cat'] = 1;

							$pf_item_terms = get_the_terms( $postid, 'pointfinderltypes');
							
							/* If marker term is available and array not empty */
							if(count($pf_item_terms) > 0){

								if ( $pf_item_terms && ! is_wp_error( $pf_item_terms ) ) {
									
									if($st8_npsys == 1){
										foreach ( $pf_item_terms as $pf_item_term ) {
											$pf_item_term_id = $pf_item_term->term_id;
										}
									}else{
										foreach ( $pf_item_terms as $pf_item_term ) {
										
											if ($pf_item_term->parent != 0) {
												$pf_item_term_subcheck = pf_term_sub_check_ex($pf_item_term->parent);
												if ($pf_item_term_subcheck) {
													$pf_item_term_id = $pf_item_term->term_id;
												}else{
													$pf_item_term_id = pf_term_sub_check($pf_item_term->term_id);
												}
												if (!empty($pf_item_term_id)) {
													break;
												}
											}else{
												$pf_item_term_id = $pf_item_term->term_id;
											}
											
											
										}
									}
									

								} 

								if(function_exists('icl_t')) { /* If wpml enabled */
									$pf_item_term_id = icl_object_id($pf_item_term_id,'pointfinderltypes',true,PF_default_language());
								}

								if (!empty($pf_item_term_id)) {
									$pfitemicon['cat'] = 'pfcat'.$pf_item_term_id;
								}else{
									$pfitemicon['cat'] = 'pfcatdefault';
								}
							
								
							}
							
						/** 
						*End: Check category icon 
						**/
						break;
					}
					
					return $pfitemicon;
				}
			/** 
			*End: GET - Marker Point Vars
			**/
			



			/** 
			*Start: GET - Marker Category CSS Name - minimized
			**/
				function pointfinder_get_category_points($params = array()){

					$defaults = array( 
				        'pf_get_term_detail_idm' => '',
				        'listing_meta' => '',
				        'setup8_pointsettings_pointopacity' => 1,
				        'cpoint_type' => 0,
						'cpoint_icontype' => 1,
						'cpoint_iconsize' => 'middle',
						'cpoint_iconname' => '',
						'cpoint_bgcolor' => '#b00000',
						'setup8_pointsettings_retinapoints' => 1,
						'dlang' => '',
						'clang' => '',
						'st8_npsys' => 0
				    );

					$params = array_merge($defaults, $params);

					$listing_meta = $params['listing_meta'];
				   
					$pf_get_term_detail_id = $pf_get_term_detail_idxx = $params['pf_get_term_detail_idm'];
					
					$output_data = '';

					if(function_exists('icl_t')) {
						$pf_get_term_detail_id = icl_object_id($params['pf_get_term_detail_idm'],'pointfinderltypes',true,$params['dlang']);
						$pf_get_term_detail_idxx = icl_object_id($params['pf_get_term_detail_idm'],'pointfinderltypes',true,$params['clang']);
					}

					if ($params['st8_npsys'] == 1) {


						$slisting_meta = (isset($listing_meta[$pf_get_term_detail_id]))?$listing_meta[$pf_get_term_detail_id]:'';

						$icon_type = (isset($slisting_meta['cpoint_type']))?$slisting_meta['cpoint_type']:2;
						$icon_layout_type = (isset($slisting_meta['cpoint_icontype']))?$slisting_meta['cpoint_icontype']:1;
						$icon_size = (isset($slisting_meta['cpoint_iconsize']))?$slisting_meta['cpoint_iconsize']:'middle';
						$icon_bg_color = (isset($slisting_meta['cpoint_bgcolor']))?$slisting_meta['cpoint_bgcolor']:'#b00000';
						$icon_name = (isset($slisting_meta['cpoint_iconname']))?$slisting_meta['cpoint_iconname']:'';

						if (!empty($slisting_meta)) {
							if ($icon_type == 2) {
								$arrow_text = ($icon_layout_type == 2)? '<div class=\'pf-pinarrow\' style=\'border-color: '.$icon_bg_color.' transparent transparent transparent;\'></div>': '';

								$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
								$output_data .= ' "<div ';
								$output_data .= 'class=\'pfcat'.$pf_get_term_detail_id.'-mapicon pf-map-pin-'.$icon_layout_type.' pf-map-pin-'.$icon_layout_type.'-'.$icon_size.'\'';
								$output_data .= '>';
								$output_data .= '<i class=\''.$icon_name.'\'></i></div>'.$arrow_text.'";'.PHP_EOL;
							}else{
								$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
								$output_data .= ' "<div ';
								$output_data .= 'class=\'pfcat'.$pf_get_term_detail_id.'-mapicon\'';
								$output_data .= '>';
								$output_data .= '</div>";'.PHP_EOL;
							}
						}else{
							
							if ($params['cpoint_type'] == 0) {
								$arrow_text = ($params['cpoint_icontype'] == 2)? '<div class=\'pf-pinarrow\' style=\'border-color: '.$params['cpoint_bgcolor'].' transparent transparent transparent;\'></div>': '';

								$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
								$output_data .= ' "<div ';
								$output_data .= 'class=\'pfcatdefault-mapicon pf-map-pin-'.$params['cpoint_icontype'].' pf-map-pin-'.$params['cpoint_icontype'].'-'.$params['cpoint_iconsize'].'\'';
								$output_data .= ' >';
								$output_data .= '<i class=\''.$params['cpoint_iconname'].'\' ></i></div>'.$arrow_text.'";'.PHP_EOL;
							}else{
								$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
								$output_data .= ' "<div ';
								$output_data .= 'class=\'pfcatdefault-mapicon\'';
								$output_data .= '>';
								$output_data .= '</div>";'.PHP_EOL;
							}
						}
							
					}else{
						
						$retina_number = ($params['setup8_pointsettings_retinapoints'] == 1)?2:1;

						$icon_type = PFPFIssetControl('pscp_'.$pf_get_term_detail_id.'_type','','0');

						$icon_bg_image = PFPFIssetControl('pscp_'.$pf_get_term_detail_id.'_bgimage','','0');

						$icon_layout_type = PFPFIssetControl('pscp_'.$pf_get_term_detail_id.'_icontype','','1');
						$icon_name = PFPFIssetControl('pscp_'.$pf_get_term_detail_id.'_iconname','','');
						$icon_size = PFPFIssetControl('pscp_'.$pf_get_term_detail_id.'_iconsize','','middle');
						$icon_bg_color = PFPFIssetControl('pscp_'.$pf_get_term_detail_id.'_bgcolor','','#b00000');
						
						$arrow_text = ($icon_layout_type == 2)? '<div class=\'pf-pinarrow\' style=\'border-color: '.$icon_bg_color.' transparent transparent transparent;\'></div>': '';

						if ($icon_type == 0 && empty($icon_bg_image)) {

							$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
							$output_data .= ' "<div ';
							$output_data .= 'class=\'pfcat'.$pf_get_term_detail_id.'-mapicon pf-map-pin-'.$icon_layout_type.' pf-map-pin-'.$icon_layout_type.'-'.$icon_size.'\'';
							$output_data .= ' >';
							$output_data .= '<i class=\''.$icon_name.'\' ></i></div>";'.PHP_EOL;
						
						}elseif ($icon_type != 0 && !empty($icon_bg_image)){

							$height_calculated = $icon_bg_image['height']/$retina_number;
							$width_calculated = $icon_bg_image['width']/$retina_number;

							$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
							$output_data .= ' "<div ';
							$output_data .= 'class=\'pf-map-pin-x\' ';
							$output_data .= 'style=\'background-image:url('.$icon_bg_image['url'].');opacity:'.$params['setup8_pointsettings_pointopacity'].'; background-size:'.$width_calculated.'px '.$height_calculated.'px; width:'.$width_calculated.'px; height:'.$height_calculated.'px;\'';
							$output_data .= ' >';
							$output_data .= '</div>";'.PHP_EOL;
						
						}else{

							$output_data .= 'var pfcat'.$pf_get_term_detail_id.' =';
							$output_data .= ' "<div ';
							$output_data .= 'class=\'pfcat'.$pf_get_term_detail_id.'-mapicon pf-map-pin-'.$icon_layout_type.' pf-map-pin-'.$icon_layout_type.'-'.$icon_size.'\'';
							$output_data .= ' >';
							$output_data .= '<i class=\''.$icon_name.'\' ></i></div>'.$arrow_text.'";'.PHP_EOL;

						}
					}
					
					return $output_data;
				}
			/** 
			*End: GET - Marker Category CSS Name
			**/


			/** 
			*Start: GET - Cats Point Vars - minimized
			**/
				function pf_get_default_cat_images($pflang = ''){
					
					$wpflistdata = '';

					/**
					*Start: Default Point Variables
					**/
						if (PFASSIssetControl('st8_npsys','',0) != 1) {
							$icon_layout_type = PFPFIssetControl('pscp_pfdefaultcat_icontype','','1');
							$icon_name = PFPFIssetControl('pscp_pfdefaultcat_iconname','','');
							$icon_size = PFPFIssetControl('pscp_pfdefaultcat_iconsize','','middle');
							$icon_bg_color = PFPFIssetControl('pscp_pfdefaultcat_bgcolor','','#b00000');

							$arrow_text = ($icon_layout_type == 2)? '<div class=\'pf-pinarrow\' style=\'border-color: '.$icon_bg_color.' transparent transparent transparent;\'></div>': '';

							$wpflistdata .= 'var pfcatdefault =';
							$wpflistdata .= ' "<div ';
							$wpflistdata .= 'class=\'pfcatdefault-mapicon pf-map-pin-'.$icon_layout_type.' pf-map-pin-'.$icon_layout_type.'-'.$icon_size.'\'';
							$wpflistdata .= ' >';
							$wpflistdata .= '<i class=\''.$icon_name.'\' ></i></div>'.$arrow_text.'";'.PHP_EOL;
						}else{
							$icon_layout_type = PFASSIssetControl('cpoint_icontype','',1);
							$icon_name = PFASSIssetControl('cpoint_iconname','','');
							$icon_size = PFASSIssetControl('cpoint_iconsize','','middle');
							$icon_bg_color = PFASSIssetControl('cpoint_bgcolor','','#b00000');

							$arrow_text = ($icon_layout_type == 2)? '<div class=\'pf-pinarrow\' style=\'border-color: '.$icon_bg_color.' transparent transparent transparent;\'></div>': '';

							$wpflistdata .= 'var pfcatdefault =';
							$wpflistdata .= ' "<div ';
							$wpflistdata .= 'class=\'pfcatdefault-mapicon pf-map-pin-'.$icon_layout_type.' pf-map-pin-'.$icon_layout_type.'-'.$icon_size.'\'';
							$wpflistdata .= ' >';
							$wpflistdata .= '<i class=\''.$icon_name.'\' ></i></div>'.$arrow_text.'";'.PHP_EOL;
						}
					/**
					*End: Default Point Variables
					**/



					/**
					*Start: Cat Point Variables
					**/
						
						$pf_get_term_details = get_terms('pointfinderltypes',array('hide_empty'=>false)); 

						if (!empty($pflang) && function_exists('icl_t')) {
							global $sitepress;
							do_action( 'wpml_switch_language', $pflang );
						}

						if(count($pf_get_term_details) > 0){
							$default_language = $current_language = $listing_meta = $cpoint_type = $cpoint_icontype = $cpoint_iconsize = $cpoint_iconname = $cpoint_bgcolor = '';
							
							if (function_exists('icl_t')) {
								$default_language = PF_default_language();
								$current_language = PF_current_language();
							}

							if (PFASSIssetControl('st8_npsys','',0) == 1) {
								$listing_meta = get_option('pointfinderltypes_style_vars');
								$cpoint_type = PFASSIssetControl('cpoint_type','',0);
								$cpoint_icontype = PFASSIssetControl('cpoint_icontype','',1);
								$cpoint_iconsize = PFASSIssetControl('cpoint_iconsize','','middle');
								$cpoint_iconname = PFASSIssetControl('cpoint_iconname','','');
								$cpoint_bgcolor = PFASSIssetControl('cpoint_bgcolor','','#b00000');
							}
							$st8_npsys = PFASSIssetControl('st8_npsys','',0);
						    $setup8_pointsettings_pointopacity = PFSAIssetControl('setup8_pointsettings_pointopacity','','0.7');
						    $setup8_pointsettings_retinapoints = PFSAIssetControl('setup8_pointsettings_retinapoints','','1');

						    if ($st8_npsys == 1) {
						    	foreach ( $pf_get_term_details as $pf_get_term_detail ) {

								$wpflistdata .= pointfinder_get_category_points(
									array(
									'pf_get_term_detail_idm' => $pf_get_term_detail->term_id,
							        'listing_meta' => $listing_meta,
							        'setup8_pointsettings_pointopacity' => $setup8_pointsettings_pointopacity,
							        'cpoint_type' => $cpoint_type,
									'cpoint_icontype' => $cpoint_icontype,
									'cpoint_iconsize' => $cpoint_iconsize,
									'cpoint_iconname' => $cpoint_iconname,
									'cpoint_bgcolor' => $cpoint_bgcolor,
									'setup8_pointsettings_retinapoints' => $setup8_pointsettings_retinapoints,
									'dlang' => $default_language,
									'clang' => $current_language,
									'st8_npsys' => $st8_npsys
									));

								}
						    }else{
						    	foreach ( $pf_get_term_details as $pf_get_term_detail ) {
									if ($pf_get_term_detail->parent == 0) {
										
										$wpflistdata .= pointfinder_get_category_points(
											array(
											'pf_get_term_detail_idm' => $pf_get_term_detail->term_id,
									        'listing_meta' => $listing_meta,
									        'setup8_pointsettings_pointopacity' => $setup8_pointsettings_pointopacity,
									        'cpoint_type' => $cpoint_type,
											'cpoint_icontype' => $cpoint_icontype,
											'cpoint_iconsize' => $cpoint_iconsize,
											'cpoint_iconname' => $cpoint_iconname,
											'cpoint_bgcolor' => $cpoint_bgcolor,
											'setup8_pointsettings_retinapoints' => $setup8_pointsettings_retinapoints,
											'dlang' => $default_language,
											'clang' => $current_language,
											'st8_npsys' => $st8_npsys
											));

										$pf_get_term_details_sub = get_terms('pointfinderltypes',array('hide_empty'=>false,'parent'=>$pf_get_term_detail->term_id)); 

										foreach ($pf_get_term_details_sub as $pf_get_term_detail_sub) {
											$wpflistdata .= pointfinder_get_category_points(
												array(
													'pf_get_term_detail_idm' => $pf_get_term_detail_sub->term_id,
											        'listing_meta' => $listing_meta,
											        'setup8_pointsettings_pointopacity' => $setup8_pointsettings_pointopacity,
											        'cpoint_type' => $cpoint_type,
													'cpoint_icontype' => $cpoint_icontype,
													'cpoint_iconsize' => $cpoint_iconsize,
													'cpoint_iconname' => $cpoint_iconname,
													'cpoint_bgcolor' => $cpoint_bgcolor,
													'setup8_pointsettings_retinapoints' => $setup8_pointsettings_retinapoints,
													'dlang' => $default_language,
													'clang' => $current_language,
													'st8_npsys' => $st8_npsys
												));
										}

									}
									
								}
						    }
							
							/*
								Loop End from PF Custom Points
							*/

				
						}

					/**
					*End: Cat Point Variables
					**/

					return $wpflistdata;
				}
			/** 
			*End: GET - Marker Cats Vars
			**/

		/** 
		*End: ajax-poidata.php Functions
		**/

		/* Define taxonomy point icons */
		echo pf_get_default_cat_images();
		/* Define taxonomy point icons finished */

		/* Get admin values */
		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		
		/*Get point limits*/
		if(isset($_POST['spl']) && $_POST['spl']!=''){
			$setup8_pointsettings_limit = $_POST['spl'];
			$setup8_pointsettings_orderby = $_POST['splob'];
			$setup8_pointsettings_order = $_POST['splo'];
		}else{
			$setup8_pointsettings_limit = -1;
		}
		$setup14_multiplepointsettings_check = PFSAIssetControl('setup14_multiplepointsettings_check','','1');
		
		/*Search form check*/
		if(isset($_POST['act']) && $_POST['act']!=''){
			$pfaction = esc_attr($_POST['act']);
		}else{
			$pfaction = '';
		}
		

		$pfgetdata['manual_args'] = (!empty($manualargs))? maybe_unserialize(base64_decode($manualargs)): '';
		
		$args = array( 'post_type' => $setup3_pointposttype_pt1, 'posts_per_page' => $setup8_pointsettings_limit, 'post_status' => 'publish');
		
		if(isset($args['meta_query']) == false || isset($args['meta_query']) == NULL){
			$args['meta_query'] = array();
		}

		if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
			$args['tax_query'] = array();
		}
		
		if($setup8_pointsettings_limit > 0){
			
			if($setup8_pointsettings_orderby != ''){$args['orderby']=$setup8_pointsettings_orderby;};
			if($setup8_pointsettings_order != ''){$args['order']=$setup8_pointsettings_order;};
			
		}
		
					
		if($pfaction == 'search'){
			if(isset($_POST['dt']) && $_POST['dt']!=''){
				$pfgetdata = $_POST['dt'];
				if (!is_array($pfgetdata)) {
					$pfgetdata = maybe_unserialize(base64_decode($pfgetdata,true));
					if (is_array($pfgetdata)) {
						foreach ($pfgetdata as $key => $value) {
							$pfnewgetdata[] = array('name' => $key, 'value'=>$value);
						}
						$pfgetdata = $pfnewgetdata;
					}
				}
			}else{
				$pfgetdata = '';
			}
			
				if(is_array($pfgetdata)){
					
					$pfformvars = array();
					
						foreach($pfgetdata as $singledata){
							
							/*Get Values & clean*/
							if (is_array($singledata['value'])) {
								$pfformvars[esc_attr($singledata['name'])] = $singledata['value'];
							}else{
								if(esc_attr($singledata['value']) != ''){
									
									if(isset($pfformvars[esc_attr($singledata['name'])])){
										$pfformvars[esc_attr($singledata['name'])] = $pfformvars[esc_attr($singledata['name'])]. ',' .$singledata['value'];
									}else{
										$pfformvars[esc_attr($singledata['name'])] = $singledata['value'];
									}
								}
							}
						
						}

						$pfgetdata = PFCleanArrayAttr('PFCleanFilters',$pfgetdata);

						foreach($pfformvars as $pfformvar => $pfvalue){
							
							$thiskeyftype = '';
							$thiskeyftype = PFFindKeysInSearchFieldA_ld($pfformvar);
							
							/*Get target field & condition*/
							$target = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target','','');
							$target_condition = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target_according','','');
							
							switch($thiskeyftype){
								case '1':/*select*/
									/*is_Multiple*/
									$multiple = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_multiple','','0');
									
									/*
									Find Select box type
									Check element: is it a taxonomy?
									*/
									$rvalues_check = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_check','','0');
									
									if($rvalues_check == 0){
										
										$pfvalue_arr = PFGetArrayValues_ld($pfvalue);
										
										$fieldtaxname = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_posttax','','');
										
										$args['tax_query'][]= array(
												'taxonomy' => $fieldtaxname,
												'field' => 'id',
												'terms' => $pfvalue_arr,
												'operator' => 'IN'
										);
						
									}else{
										$target_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target_target','','');
										$target_condition_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target_according','','');
										
										if (is_array($pfvalue)) {
											if ($target_condition_r == '=') {
												$compare_x = 'IN';
											}else{
												$compare_x = $target_condition_r;
											}
											$pfcomptype = 'NUMERIC';
										}else{
											if(is_numeric($pfvalue)){
												$pfcomptype = 'NUMERIC';
											}else{
												$pfcomptype = 'CHAR';
											}

											if (strpos($pfvalue, ",") != 0) {
												$pfvalue = pfstring2BasicArray($pfvalue);
												if ($target_condition_r == '=') {
													$compare_x = 'IN';
												}else{
													$compare_x = $target_condition_r;
												}
											}else{
												$compare_x = $target_condition_r;
											}
										}
										$args['meta_query'][] = array(
											'key' => 'webbupointfinder_item_'.$target_r,
											'value' => $pfvalue,
											'compare' => $compare_x,
											'type' => $pfcomptype
											
										);


									}
									
									break;
									
								case '2':/*slider*/
									/*Find Slider Type from slug*/
									$slidertype = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_type','','');
									$pfcomptype = 'NUMERIC';
									
									if($slidertype == 'range'){ 
										$pfvalue = trim($pfvalue,"\0");
										$pfvalue_exp = explode(',',$pfvalue);

										$args['meta_query'][] = array(
											'key' => 'webbupointfinder_item_'.$target,
											'value' => array($pfvalue_exp[0],$pfvalue_exp[1]),
											'compare' => 'BETWEEN',
											'type' => $pfcomptype
										);
									}else{

										$args['meta_query'][] = array(
											'key' => 'webbupointfinder_item_'.$target,
											'value' => $pfvalue,
											'compare' => $target_condition,
											'type' => $pfcomptype
										);
									}
									
									
									break;
									
								case '4':/*text field*/
									$target = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target_target','','');
									
									switch ($target) {
										case 'title':
												$args['search_prod_title'] = $pfvalue;
												function title_filter( $where, &$wp_query )
												{
													global $wpdb;
													if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
														if($search_term != ''){
															$search_term = $wpdb->esc_like( $search_term );
															$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql(  $search_term ) . '%\'';
														}
													}
													return $where;
												}

										  		add_filter( 'posts_where', 'title_filter', 10, 2 );

											break;

										case 'description':
												$args['search_prod_desc'] = $pfvalue;
												function pf_description_filter( $where, &$wp_query )
												{
													global $wpdb;
													if ( $search_term = $wp_query->get( 'search_prod_desc' ) ) {
														if($search_term != ''){
															$search_term = $wpdb->esc_like( $search_term );
															$where .= ' AND ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql(  $search_term ) . '%\'';
														}
													}
													return $where;
												}

										  		add_filter( 'posts_where', 'pf_description_filter', 10, 3 );

											break;

										case 'address':
												$pfcomptype = 'CHAR';
												$args['meta_query'][] = array(
													'key' => 'webbupointfinder_items_address',
													'value' => $pfvalue,
													'compare' => 'LIKE',
													'type' => $pfcomptype
												);
											break;

										case 'google':
											break;
										
										case 'post_tags':
										case 'pointfinderltypes':
										case 'pointfinderitypes':
										case 'pointfinderlocations':
										case 'pointfinderfeatures':
										case 'pointfinderconditions':
											if ($target == 'post_tags') {
												$args['tag'] = "$pfvalue";
											}else{
												$args['tax_query'][] = array(
													'taxonomy' => $target,
													'field' => 'name',
													'terms' => $pfvalue,
													'operator' => 'IN'
												);
											}
											break;
										default:
												$pfcomptype = 'CHAR';
												$args['meta_query'][] = array(
													'key' => 'webbupointfinder_item_'.$target,
													'value' => $pfvalue,
													'compare' => 'LIKE',
													'type' => $pfcomptype
												);
												
											break;
									}
									
									break;

								case '5':

									$pfcomptype = 'NUMERIC';

									$setup4_membersettings_dateformat = PFSAIssetControl('setup4_membersettings_dateformat','','1');
									switch ($setup4_membersettings_dateformat) {
										case '1':$datetype = "d-m-Y";break;
										case '2':$datetype = "m-d-Y";break;
										case '3':$datetype = "Y-m-d";break;
										case '4':$datetype = "Y-d-m";break;
									}

									$pfvalue = date_parse_from_format($datetype, $pfvalue);

									$pfvalue = strtotime(date("Y-m-d", mktime(0, 0, 0, $pfvalue['month'], $pfvalue['day'], $pfvalue['year'])));

						     		if (!empty($pfvalue)) {
										$args['meta_query'][] = array(
											'key' => 'webbupointfinder_item_'.$target,
											'value' => intval($pfvalue),
											'compare' => "$target_condition",
											'type' => "$pfcomptype"
										);
									}
									break;

								case '6':/*checkbox*/
									
									
									if (is_array($pfvalue)) {
										$compare_x = 'IN';
										$pfcomptype = 'NUMERIC';
									}else{
										if(is_numeric($pfvalue)){
											$pfcomptype = 'NUMERIC';
										}else{
											$pfcomptype = 'CHAR';
										}

										if (strpos($pfvalue, ",") != 0) {
											$pfvalue = pfstring2BasicArray($pfvalue);
											$compare_x = 'IN';
										}else{
											$compare_x = '=';
										}
									}
									$args['meta_query'][] = array(
										'key' => 'webbupointfinder_item_'.$target,
										'value' => $pfvalue,
										'compare' => $compare_x,
										'type' => $pfcomptype
										
									);
									
									break;
							}
							
						}
					
				}
		}else{
			
			if(isset($_POST['singlepoint']) && !empty($_POST['singlepoint'])){
				$pfitem_singlepoint = esc_attr($_POST['singlepoint']);
				$args['p'] = $pfitem_singlepoint;
				$args['suppress_filters'] = true;
			}
			
		}


		if(isset($_POST['dtx']) && $_POST['dtx']!='' && isset($_POST['dt']) == false ){

			$pfgetdatax = $_POST['dtx'];
			$pfgetdatax = PFCleanArrayAttr('PFCleanFilters',$pfgetdatax);


			if (is_array($pfgetdatax)) {
				foreach ($pfgetdatax as $key => $value) {

					if(isset($value['value'])){
						if (!empty($value['value'])) {
							$args['tax_query'][]=array(
									'taxonomy' => $value['name'],
									'field' => 'id',
									'terms' => pfstring2BasicArray($value['value']),
									'operator' => 'IN'
							);
						}
					}
				}
			}

		}

		/* Check if lat,lng empty */
		if(isset($_POST['ne']) && $_POST['ne']!=''){
			$ne = esc_attr($_POST['ne']);
		}else{
			$ne = 360;
		}
		
		if(isset($_POST['ne2']) && $_POST['ne2']!=''){
			$ne2 = esc_attr($_POST['ne2']);
		}else{
			$ne2 = 360;
		}
		
		if(isset($_POST['sw']) && $_POST['sw']!=''){
			$sw = esc_attr($_POST['sw']);
		}else{
			$sw = -360;
		}
		
		if(isset($_POST['sw2']) && $_POST['sw2']!=''){
			$sw2 = esc_attr($_POST['sw2']);
		}else{
			$sw2 = -360;
		}

		$args['meta_query'][] = array(
			'key' => 'webbupointfinder_items_location',
			'compare' => 'EXISTS'
			
		);

		
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
		

		/* If point is visible */
			$args['meta_query'][] = array(
				'key' => 'webbupointfinder_item_point_visibility',
				'compare' => 'NOT EXISTS'
			);
			

		$setup8_pointsettings_pointopacity = PFSAIssetControl('setup8_pointsettings_pointopacity','','0.7');
		$setup8_pointsettings_retinapoints = PFSAIssetControl('setup8_pointsettings_retinapoints','','1');
		$st8_npsys = PFASSIssetControl('st8_npsys','',0);

		echo PHP_EOL.'var wpflistdata = [';
		$loop = new WP_Query( $args );
			/*
				Check Results	
					print_r($loop->query).PHP_EOL;
					echo $loop->request.PHP_EOL;
					echo $loop->found_posts.PHP_EOL;
				*/
			
			if($loop->post_count > 0){
		
				while ( $loop->have_posts() ) : $loop->the_post();
				
				$coordinates = explode( ',', rwmb_meta('webbupointfinder_items_location') );
				if (!empty($coordinates[0])) {
					$post_id = get_the_id();

						$pfitemicon = pf_get_markerimage($post_id,$setup8_pointsettings_pointopacity,$setup8_pointsettings_retinapoints,$st8_npsys);

						if($coordinates[0] > $sw && $coordinates[0] < $ne && $coordinates[1] > $sw2 && $coordinates[1] < $ne2 && $coordinates[0] != '' && $coordinates[1] != ''){
								
							echo  '{latLng:['.$coordinates[0].','.$coordinates[1].'],';
							if (!empty($pflang)) {
								echo 'data:{id:'.PFLangCategoryID_ld($post_id,$pflang).'},id:'.PFLangCategoryID_ld($post_id,$pflang).',';
							}else{
								echo 'data:{id:'.$post_id.'},id:'.$post_id.',';
							}
							echo 'options:{';
							if(PFControlEmptyArr($pfitemicon)){
								
								if ($pfitemicon['is_cat'] == 1) {
									echo "content:".$pfitemicon['cat'].",flat: true,";
								}

								if ($pfitemicon['is_image'] == 1) {
									echo "content:\"".$pfitemicon['content']."\",flat: true,";
								}
								
							}
							//$wpflistdata .= 'visible: '.$pfitemvisibility.'';
							echo 'tag:"pfmarker"';
								
							echo '}},'.PHP_EOL;
						}
								
							
					
				}	
				endwhile;
			
			}
			
			
		echo '];';
		
	die();
}

?>