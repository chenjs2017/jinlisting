<?php 
get_header();
	
	
	if (isset($_GET['action']) && $_GET['action'] == 'pfs') {

		/**
		*Start: Get search data & apply to query arguments.
		**/
			$pfgetdata = $_GET;
			$pfne = $pfne2 = $pfsw = $pfsw2 = $pfpointfinder_google_search_coord = '';
			$hidden_output = $search_output = '';
			$searchkeys = array('pfsearch-filter','pfsearch-filter-order','pfsearch-filter-number','pfsearch-filter-col');
			if(is_array($pfgetdata)){

				$pfformvars = array();


					/*Data clean*/
					$pfgetdata = PFCleanArrayAttr('PFCleanFilters',$pfgetdata);


					foreach($pfgetdata as $key=>$value){
						

						//Get Values & clean
						if($value != ''){
							
							if(isset($pfformvars[$key])){
								$pfformvars[$key] = $pfformvars[$key]. ',' .$value;
							}else{
								$pfformvars[$key] = $value;
							}
							if (!is_array($value)) {
								if(!in_array($key, $searchkeys)){
									$hidden_output .= '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';
								}
							}
							

						}

						if ($key == 'ne') {$pfne = sanitize_text_field($value);}
						if ($key == 'ne2') {$pfne2 = sanitize_text_field($value);}
						if ($key == 'sw') {$pfsw = sanitize_text_field($value);}
						if ($key == 'sw2') {$pfsw2 = sanitize_text_field($value);}
						if ($key == 'pointfinder_google_search_coord') {$pfpointfinder_google_search_coord = sanitize_text_field($value);}

					
					}
					$hidden_output .= '<input type="hidden" name="s" value=""/>';

					
					
					$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
					$args = array( 'post_type' => $setup3_pointposttype_pt1, 'post_status' => 'publish');
					

					if(isset($_GET['pfsearch-filter']) && $_GET['pfsearch-filter']!=''){$pfg_orderbyx = esc_attr($_GET['pfsearch-filter']);}else{$pfg_orderbyx = '';}
					if(isset($_POST['pfg_order']) && $_POST['pfg_order']!=''){$pfg_orderx = esc_attr($_POST['pfg_order']);}else{$pfg_orderx = '';}
					if(isset($_POST['pfg_number']) && $_POST['pfg_number']!=''){$pfg_numberx = esc_attr($_POST['pfg_number']);}else{$pfg_numberx = '';}

					$setup22_searchresults_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
					$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','ID');
					$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','ASC');


					if($pfg_orderbyx == ''){
						$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
						$args['orderby'] = array('meta_value_num' => 'DESC' , $setup22_searchresults_defaultsortbytype => $setup22_searchresults_defaultsorttype);
						$args['posts_per_page'] = $setup22_searchresults_defaultppptype;
					}else{
						$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
						$args['orderby'] = array('meta_value_num' => 'DESC');
						$args['posts_per_page'] = $pfg_numberx;
					}

					if(isset($args['meta_query']) == false || isset($args['meta_query']) == NULL){
						$args['meta_query'] = array();
					}	

					if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
						$args['tax_query'] = array();
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

					foreach($pfformvars as $pfformvar => $pfvalue){
						
						if(!in_array($pfformvar, $searchkeys)){
							$thiskeyftype = '';
							$thiskeyftype = PFFindKeysInSearchFieldA_ld($pfformvar);
							
							//Get target field & condition
							$target = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target','','');
							$target_condition = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target_according','','');

							switch($thiskeyftype){
								case '1'://select
									//is_Multiple
									$multiple = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_multiple','','0');
								
									
									//Find Select box type
									//Check element: is it a taxonomy?
									$rvalues_check = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_check','','0');
									
									if($rvalues_check == 0){
										$pfvalue_arr = PFGetArrayValues_ld($pfvalue);
										$fieldtaxname = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_posttax','','');
										$args['tax_query'][]=array(
											'taxonomy' => $fieldtaxname,
											'field' => 'id',
											'terms' => $pfvalue_arr,
											'operator' => 'IN'
										);
									}else{
										
										$target_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target','','');
										if (empty($target_r)) {
											$target_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target_target','','');
										}
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
									
								case '2'://slider
									//Find Slider Type from slug
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
									
								case '4'://text field

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
									
									if(is_numeric($pfvalue)){
										$pfcomptype = 'NUMERIC';
									}else{
										$pfcomptype = 'CHAR';
									}
									if (is_array($pfvalue)) {
										$compare_x = 'IN';
									}else{
										$compare_x = '=';
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
			}		
		/**
		*End: Get search data & apply to query arguments.
		**/

		$manualargs = base64_encode(maybe_serialize($args));
		$hidden_output = base64_encode(maybe_serialize($hidden_output));
				
        $setup_item_searchresults_sidebarpos = PFASSIssetControl('setup_item_searchresults_sidebarpos','','2');

		$setup42_searchpagemap_headeritem = PFSAIssetControl('setup42_searchpagemap_headeritem','','1');
		if ($setup42_searchpagemap_headeritem != 1) {
			if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader();}
		}else{

			/* Get Variables and apply */
			$setup42_searchpagemap_height = PFSAIssetControl('setup42_searchpagemap_height','height','550');
			$setup42_searchpagemap_lat = PFSAIssetControl('setup42_searchpagemap_lat','','');
			$setup42_searchpagemap_lng = PFSAIssetControl('setup42_searchpagemap_lng','','');
			$setup42_searchpagemap_zoom = PFSAIssetControl('setup42_searchpagemap_zoom','','12');
			$setup42_searchpagemap_mobile = PFSAIssetControl('setup42_searchpagemap_mobile','','10');
			$setup42_searchpagemap_autofitsearch = PFSAIssetControl('setup42_searchpagemap_autofitsearch','','1');
			$setup42_searchpagemap_type = PFSAIssetControl('setup42_searchpagemap_type','','ROADMAP');
			$setup42_searchpagemap_business = PFSAIssetControl('setup42_searchpagemap_business','','0');
			$setup42_searchpagemap_streetViewControl = PFSAIssetControl('setup42_searchpagemap_streetViewControl','','1');
			$setup42_searchpagemap_style = preg_replace('/\s+/', '',PFSAIssetControl('setup42_searchpagemap_style','',''));
			if (mb_substr($setup42_searchpagemap_style, 0, 1,'UTF-8') == '[' && mb_substr($setup42_searchpagemap_style, -1, 1,'UTF-8') == ']') {
				$setup42_searchpagemap_style = mb_substr($setup42_searchpagemap_style, 1, -1,'UTF-8');
			}
			$setup42_searchpagemap_style = base64_encode( strip_tags( $setup42_searchpagemap_style ));
			$setup42_searchpagemap_ajax = PFSAIssetControl('setup42_searchpagemap_ajax','','0');
			$setup42_searchpagemap_ajax_drag = PFSAIssetControl('setup42_searchpagemap_ajax_drag','','0');
			$setup42_searchpagemap_ajax_zoom = PFSAIssetControl('setup42_searchpagemap_ajax_zoom','','0');
			$setup42_searchpagemap_height = str_replace('px', '', $setup42_searchpagemap_height);
			
			echo do_shortcode('[pf_directory_map setup5_mapsettings_height="'.$setup42_searchpagemap_height.'" setup5_mapsettings_zoom="'.$setup42_searchpagemap_zoom.'" setup5_mapsettings_zoom_mobile="'.$setup42_searchpagemap_mobile.'" setup8_pointsettings_ajax="'.$setup42_searchpagemap_ajax.'" setup8_pointsettings_ajax_drag="'.$setup42_searchpagemap_ajax_drag.'" setup8_pointsettings_ajax_zoom="'.$setup42_searchpagemap_ajax_zoom.'" setup5_mapsettings_autofit="0" setup5_mapsettings_autofitsearch="'.$setup42_searchpagemap_autofitsearch.'" setup5_mapsettings_type="'.$setup42_searchpagemap_type.'" setup5_mapsettings_business="'.$setup42_searchpagemap_business.'" setup5_mapsettings_streetViewControl="'.$setup42_searchpagemap_streetViewControl.'" mapsearch_status="0" mapnot_status="0" setup5_mapsettings_lat="'.$setup42_searchpagemap_lat.'" setup5_mapsettings_lng="'.$setup42_searchpagemap_lng.'" setup5_mapsettings_style="'.$setup42_searchpagemap_style.'" ne="'.$pfne.'" ne2="'.$pfne2.'" sw="'.$pfsw.'" sw2="'.$pfsw2.'" manualargs="'.$manualargs.'" neaddress="'.$pfpointfinder_google_search_coord.'"]');
		}

        
		$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#ffffff');
		$setup42_authorpagedetails_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
		$setup22_searchresults_defaultlistingtype = PFSAIssetControl('setup22_searchresults_defaultlistingtype','','4');
		$setup42_authorpagedetails_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
		$setup42_authorpagedetails_grid_layout_mode = ($setup42_authorpagedetails_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;

		$setup22_searchresults_status_catfilters = PFSAIssetControl('setup22_searchresults_status_catfilters','','1');

		$stp22_infscrl_s = PFSAIssetControl('stp22_infscrl_s','',0);
		$stp22_infscrl_s2 = PFSAIssetControl('stp22_infscrl_s2','',0);
		
		if ($setup22_searchresults_status_catfilters == 1) {
			$filters_text = 'true';
		}else{
			$filters_text = 'false';
		}

			echo '<section role="main">';
		        echo '<div class="pf-page-spacing"></div>';
		        echo '<div class="pf-container"><div class="pf-row clearfix">';
		        	if ($setup_item_searchresults_sidebarpos == 3) {
		        		echo '<div class="col-lg-12"><div class="pf-page-container">';

							echo do_shortcode('[pf_itemgrid2 filters="'.$filters_text.'" manualargs="'.$manualargs.'" orderby="" sortby="" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" itemboxbg="'.$setup22_searchresults_background2.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" ne="'.$pfne.'" ne2="'.$pfne2.'" sw="'.$pfsw.'" sw2="'.$pfsw2.'" infinite_scroll="'.$stp22_infscrl_s.'" infinite_scroll_lm="'.$stp22_infscrl_s2.'" ]' );


						echo '</div></div>';
		        	}else{
		        		if($setup_item_searchresults_sidebarpos == 1){
			                echo '<div class="col-lg-3 col-md-3">';
			                    get_sidebar('itemsearchres' ); 
			                echo '</div>';
			            }
			              
			            echo '<div class="col-lg-9 col-md-9"><div class="pf-page-container">'; 
			            echo do_shortcode('[pf_itemgrid2 filters="'.$filters_text.'" hidden_output="'.$hidden_output.'" manualargs="'.$manualargs.'" orderby="" sortby="" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" itemboxbg="'.$setup22_searchresults_background2.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" ne="'.$pfne.'" ne2="'.$pfne2.'" sw="'.$pfsw.'" sw2="'.$pfsw2.'" infinite_scroll="'.$stp22_infscrl_s.'" infinite_scroll_lm="'.$stp22_infscrl_s2.'" ]' );


			            echo '</div></div>';
			            if($setup_item_searchresults_sidebarpos == 2){
			                echo '<div class="col-lg-3 col-md-3">';
			                    get_sidebar('itemsearchres' );
			                echo '</div>';
			            }
		        	}
		            
		        echo '</div></div>';
		        echo '<div class="pf-page-spacing"></div>';
		    echo '</section>';
		

		
	}else{
		if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader();}

		echo '<div class="pf-blogpage-spacing pfb-top"></div>';
		echo '<section role="main">';
			echo '<div class="pf-container">';
				echo '<div class="pf-row">';
					echo '<div class="col-lg-12">';
						
						get_template_part('loop');

					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</section>';
		echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
	}


get_footer();
?>