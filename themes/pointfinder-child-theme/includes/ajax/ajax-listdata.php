<?php

/**********************************************************************************************************************************
*
* Ajax list data
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


//add_action( 'PF_AJAX_HANDLER_pfget_listitems', 'pf_ajax_list_items' );
//add_action( 'PF_AJAX_HANDLER_nopriv_pfget_listitems', 'pf_ajax_list_items' );
	
	
function pf_ajax_list_items_new(){
	check_ajax_referer( 'pfget_listitems', 'security' );
	header('Content-Type: text/html; charset=UTF-8;');

		function PFIF_SortFields_ld($searchvars,$orderarg_value = NULL){

			$pfstart = PFCheckStatusofVar('setup1_slides');
			$if_sorttext = '';
			if($pfstart == true){
				$if_sorttext = '';
				$available_fields = array(1,2,3,4,5,7,8,14);
				$setup1_slides = PFSAIssetControl('setup1_slides','','');	
				
				
				/* Prepare detailtext */
				foreach ($setup1_slides as &$value) {
					$stext = '';
					if(!empty($orderarg_value)){
						if(strcmp($orderarg_value,$value['url']) == 0){
							$stext = 'selected';
						}else{
							$stext = '';
						}
					}
					$Parentcheckresult = PFIF_CheckItemsParent_ld($value['url']);
					if(is_array($searchvars)){$res = PFIF_CheckFormVarsforExist_ld($searchvars,$Parentcheckresult);}else{$res = false;}
					$customfield_sortcheck = PFCFIssetControl('setupcustomfields_'.$value['url'].'_sortoption','','0');
					
					if($Parentcheckresult == 'none'){
						if(in_array($value['select'], $available_fields) && $customfield_sortcheck != 0){
							$if_sorttext .= '<option value="'.$value['url'].'" '.$stext.'>'.$value['title'].'</option>';
						}
					}else{
						if($res == true){
							$sortnamecheck = PFCFIssetControl('setupcustomfields_'.$value['url'].'_sortname','','');
							if($sortnamecheck == ''){$sortnamecheck = $value['title'];}
							if(in_array($value['select'], $available_fields) && $customfield_sortcheck != 0){
								$if_sorttext .= '<option value="'.$value['url'].'" '.$stext.'>'.$sortnamecheck.'</option>';
							}
						}
					
					}
					
				}
				
			}
			return $if_sorttext;
		}


		/* Defaults */
		$wpflistdata = $wpflistdata_output = $pfaction = $pfgrid = $pfg_ltype = $pfg_itype = $pfg_lotype = $pfheaderfilters = $pfitemboxbg = $pfcontainershow = $pfcontainerdiv = $pfgrid = $pflang = $pfgetdata = $pf1colfix = $pf1colfix2 = '';
		$pfg_authormode = $pfg_agentmode = $setup22_searchresults_status_sortby = $setup22_searchresults_status_ascdesc = $setup22_searchresults_status_number = $setup22_searchresults_status_2col = $setup22_searchresults_status_3col = $setup22_searchresults_status_4col = $setup22_searchresults_status_2colh = 0;
		$user_loggedin_check = is_user_logged_in();
		$favtitle_text = esc_html__('Add to Favorites','pointfindert2d');

		/* Get admin values */
		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		
		/* Define Coordinates */
			if(isset($_POST['ne']) && $_POST['ne']!=''){$ne = esc_attr($_POST['ne']);}else{$ne = 360;}
			if(isset($_POST['ne2']) && $_POST['ne2']!=''){$ne2 = esc_attr($_POST['ne2']);}else{$ne2 = 360;}
			if(isset($_POST['sw']) && $_POST['sw']!=''){$sw = esc_attr($_POST['sw']);}else{$sw = -360;}
			if(isset($_POST['sw2']) && $_POST['sw2']!=''){$sw2 = esc_attr($_POST['sw2']);}else{$sw2 = -360;}


		/* WPML - Current language fix */
			if(isset($_POST['cl']) && $_POST['cl']!=''){
				$pflang = esc_attr($_POST['cl']);
				if(function_exists('icl_t')) {
					if (!empty($pflang)) {
						do_action( 'wpml_switch_language', $pflang );
					}
				}
			}


		/* Get Grid Layout Mode */
			$setup22_searchresults_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
			$grid_layout_mode = ($setup22_searchresults_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;

		/* Grid random number (id) */
			if(isset($_POST['gdt']) && $_POST['gdt']!=''){
				$variables_gdt = $_POST['gdt'];
				$pfaction = 'grid';
			}

		/* Search form check */
			if(isset($_POST['act']) && $_POST['act']!=''){
				$pfaction = esc_attr($_POST['act']);
			}

		/* Get default Grid settings from admin */
			$setup22_searchresults_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
			$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','ID');
			$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','ASC');
			$setup22_searchresults_defaultlistingtype = PFSAIssetControl('setup22_searchresults_defaultlistingtype','','4');
			$review_system_statuscheck = PFREVSIssetControl('setup11_reviewsystem_check','','0');
			$setup16_reviewstars_revtextbefore = PFREVSIssetControl('setup16_reviewstars_revtextbefore','','');
			$st22srlinknw = PFSAIssetControl('st22srlinknw','','0');
			$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);
			$targetforitem = '';
			if ($st22srlinknw == 1) {
				$targetforitem = ' target="_blank"';
			}

		/* Post Type status check */
			$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
			$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
			$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');

		/* Container & show check */
			if(isset($_POST['pfcontainerdiv']) && $_POST['pfcontainerdiv']!=''){
				$pfcontainerdiv = str_replace('.', '', esc_attr($_POST['pfcontainerdiv']));
			}
			if(isset($_POST['pfcontainershow']) && $_POST['pfcontainershow']!=''){
				$pfcontainershow = str_replace('.', '', esc_attr($_POST['pfcontainershow']));
				if (isset($_POST['pfex']) && !empty($_POST['pfex'])) {$pfcontainershow .= ' pfajaxgridview';}
			}

			if ($pfcontainerdiv == 'pfsearchresults') {

				$setup22_searchresults_status_sortby = PFSAIssetControl('setup22_searchresults_status_sortby','','0');
				$setup22_searchresults_status_ascdesc = PFSAIssetControl('setup22_searchresults_status_ascdesc','','0');
				$setup22_searchresults_status_number = PFSAIssetControl('setup22_searchresults_status_number','','0');
				$setup22_searchresults_status_2col = PFSAIssetControl('setup22_searchresults_status_2col','','0');
				$setup22_searchresults_status_3col = PFSAIssetControl('setup22_searchresults_status_3col','','0');
				$setup22_searchresults_status_4col = PFSAIssetControl('setup22_searchresults_status_4col','','0');
				$setup22_searchresults_status_2colh = PFSAIssetControl('setup22_searchresults_status_2colh','','0');
			}

		/* Grid type for HTML strings */

			if(isset($_POST['grid']) && $_POST['grid']!=''){
				$pfgrid = esc_attr($_POST['grid']);
			}
			

		/* Settings for Retina Feature */
			$general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
			if($general_retinasupport == 1){$pf_retnumber = 2;}else{$pf_retnumber = 1;}
			$setupsizelimitconf_general_gridsize1_width = PFSizeSIssetControl('setupsizelimitconf_general_gridsize1','width',440);
			$setupsizelimitconf_general_gridsize1_height = PFSizeSIssetControl('setupsizelimitconf_general_gridsize1','height',330);
			$featured_image_width = $setupsizelimitconf_general_gridsize1_width*$pf_retnumber;
			$featured_image_height = $setupsizelimitconf_general_gridsize1_height*$pf_retnumber;
		

		/* Get if sort/order/number values exist */
			if(isset($_POST['pfg_orderby']) && $_POST['pfg_orderby']!=''){$pfg_orderby = esc_attr($_POST['pfg_orderby']);}else{$pfg_orderby = '';}
			if(isset($_POST['pfg_order']) && $_POST['pfg_order']!=''){$pfg_order = esc_attr($_POST['pfg_order']);}else{$pfg_order = '';}
			if(isset($_POST['pfg_number']) && $_POST['pfg_number']!=''){$pfg_number = esc_attr($_POST['pfg_number']);}else{$pfg_number = '';}
			if(isset($_POST['page']) && $_POST['page']!=''){$pfg_paged = esc_attr($_POST['page']);}else{$pfg_paged = '';}
			
			if(isset($_POST['pfsearch_filter_ltype']) && !empty($_POST['pfsearch_filter_ltype'])){$pfg_ltype = esc_attr($_POST['pfsearch_filter_ltype']);}
			if(isset($_POST['pfsearch_filter_itype']) && !empty($_POST['pfsearch_filter_itype'])){$pfg_itype = esc_attr($_POST['pfsearch_filter_itype']);}
			if(isset($_POST['pfsearch_filter_location']) && !empty($_POST['pfsearch_filter_location'])){$pfg_lotype = esc_attr($_POST['pfsearch_filter_location']);}


		/* Start: Create arguments for get post */
			$args = array( 'post_type' => $setup3_pointposttype_pt1, 'post_status' => 'publish');



			/* Start: Category Filters */
				if ( !empty($pfg_ltype)) {
					$fieldtaxname_lt = 'pointfinderltypes';
					if (!isset($args['tax_query'])) {
						$args['tax_query'] = array();
					}
					if(count($args['tax_query']) > 0){
						$args['tax_query'][(count($args['tax_query'])-1)]=
						array(
								'taxonomy' => $fieldtaxname_lt,
								'field' => 'id',
								'terms' => $pfg_ltype,
								'operator' => 'IN'
						);
					}else{
						$args['tax_query']=
						array(
							'relation' => 'AND',
							array(
								'taxonomy' => $fieldtaxname_lt,
								'field' => 'id',
								'terms' => $pfg_ltype,
								'operator' => 'IN'
							)
						);
					}
				}

				if ( !empty($pfg_itype) && $setup3_pointposttype_pt4_check == 1) {
					$fieldtaxname_it = 'pointfinderitypes';
					if (!isset($args['tax_query'])) {
						$args['tax_query'] = array();
					}
					if(count($args['tax_query']) > 0){
						$args['tax_query'][(count($args['tax_query'])-1)]=
						array(
								'taxonomy' => $fieldtaxname_it,
								'field' => 'id',
								'terms' => $pfg_itype,
								'operator' => 'IN'
						);
					}else{
						$args['tax_query']=
						array(
							'relation' => 'AND',
							array(
								'taxonomy' => $fieldtaxname_it,
								'field' => 'id',
								'terms' => $pfg_itype,
								'operator' => 'IN'
							)
						);
					}
				}

				if ( !empty($pfg_lotype) && $setup3_pointposttype_pt5_check == 1) {
					$fieldtaxname_loc = 'pointfinderlocations';
					if (!isset($args['tax_query'])) {
						$args['tax_query'] = array();
					}
					if(count($args['tax_query']) > 0){
						$args['tax_query'][(count($args['tax_query'])-1)]=
						array(
								'taxonomy' => $fieldtaxname_loc,
								'field' => 'id',
								'terms' => $pfg_lotype,
								'operator' => 'IN'
						);
					}else{
						$args['tax_query']=
						array(
							'relation' => 'AND',
							array(
								'taxonomy' => $fieldtaxname_loc,
								'field' => 'id',
								'terms' => $pfg_lotype,
								'operator' => 'IN'
							)
						);
					}
				}
			/* End: Category Filters */


			/* Start: Order Filters*/
				if($pfg_orderby != ''){
					if($pfg_orderby == 'date' || $pfg_orderby == 'title'){
						$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
						$args['orderby'] = array('meta_value_num' => 'DESC' , $pfg_orderby => $pfg_order);
					}else{
						$args['meta_key']='webbupointfinder_item_'.$pfg_orderby;
						if(PFIF_CheckFieldisNumeric_ld($pfg_orderby) == false){
							$args['orderby']= array('meta_value' => $pfg_order);
						}else{
							$args['orderby']= array('meta_value_num' => $pfg_order);
						}
					}
				}else{
					$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
					$args['orderby'] = array('meta_value_num' => 'DESC' , $setup22_searchresults_defaultsortbytype => $setup22_searchresults_defaultsorttype);
				}
			/* End: Order Filters*/
		
		
			/* Page number / post per page values */
			if($pfg_number != ''){$args['posts_per_page'] = $pfg_number;}else{$args['posts_per_page'] = $setup22_searchresults_defaultppptype;}
			if($pfg_paged != ''){$args['paged'] = $pfg_paged;}
			
			if(isset($args['meta_query']) == false || isset($args['meta_query']) == NULL){
				$args['meta_query'] = array();
			}	

			if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
				$args['tax_query'] = array();
			}

			if($pfaction == 'search'){
				/*
				* If query is a search result
				*/
					if(isset($_POST['dt']) && $_POST['dt']!=''){$pfgetdata = $_POST['dt'];}

					if(is_array($pfgetdata)){

						$pfformvars = array();
						
							foreach($pfgetdata as $singledata){
								
								/* Get Values & clean */
								if(esc_attr($singledata['value']) != ''){
									
									if(isset($pfformvars[esc_attr($singledata['name'])])){
										$pfformvars[esc_attr($singledata['name'])] = $pfformvars[esc_attr($singledata['name'])]. ',' .$singledata['value'];
									}else{
										$pfformvars[esc_attr($singledata['name'])] = $singledata['value'];
									}
			
								}
							
							}
							$pfsearchvars = $pfformvars;
							foreach($pfformvars as $pfformvar => $pfvalue){
								
								$thiskeyftype = '';
								$thiskeyftype = PFFindKeysInSearchFieldA_ld($pfformvar);
								
								/* Get target field & condition */
								$target = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target','','');
								$target_condition = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_target_according','','');

								switch($thiskeyftype){
									case '1':/* Select Box */
										$multiple = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_multiple','','0');
										
										/*
										* Find Select box type
										* Check element: is it a taxonomy?
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
											$target_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target','','');
											if (empty($target_r)) {
												$target_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target_target','','');
											}
											$target_condition_r = PFSFIssetControl('setupsearchfields_'.$pfformvar.'_rvalues_target_according','','');
											
											if(is_numeric($pfvalue)){
												$pfcomptype = 'NUMERIC';
											}else{
												$pfcomptype = 'CHAR';
											}
											
											$args['meta_query'][] = array(
												'key' => 'webbupointfinder_item_'.$target_r,
												'value' => $pfvalue,
												'compare' => $target_condition_r,
												'type' => $pfcomptype
											);
											
										}
										
										break;
										
									case '2':/* Slider */
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
										
									case '4':/* Text field */
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
								}

							}
						
					}
			}else if( $pfaction == 'grid'){
				/*
				* If query is a Ajax Grid
				*/
				$pfgetdata = $variables_gdt;
				$grid_layout_mode = $pfgetdata['grid_layout_mode'];

					if(is_array($pfgetdata)){
						if ($pfgetdata['related'] == 1) {

							if(!empty($pfgetdata['relatedcpi'])){$args['post__not_in'] = array($pfgetdata['relatedcpi']);}

							$agent_id = redux_post_meta("pointfinderthemefmb_options", $pfgetdata['relatedcpi'], "webbupointfinder_item_agents");

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

						$pfg_authormode = $pfgetdata['authormode'];
						$pfg_agentmode = $pfgetdata['agentmode'];

						if($pfgetdata['posts_in']!=''){
							$args['post__in'] = pfstring2BasicArray($pfgetdata['posts_in']);
						}

						if($pfgetdata['authormode'] != 0){
							if (!empty($pfgetdata['author'])) {
								$args['author'] = $pfgetdata['author'];
							}
						}

						/* Listing type */
							if($pfgetdata['listingtype'] != ''){
								$pfvalue_arr_lt = PFGetArrayValues_ld($pfgetdata['listingtype']);
								$fieldtaxname_lt = 'pointfinderltypes';
								$args['tax_query'][] = array(
									'taxonomy' => $fieldtaxname_lt,
									'field' => 'id',
									'terms' => $pfvalue_arr_lt,
									'operator' => 'IN'
								);
							}

						/* Location type */
							if($setup3_pointposttype_pt5_check == 1){
								if($pfgetdata['locationtype'] != ''){
									$pfvalue_arr_loc = PFGetArrayValues_ld($pfgetdata['locationtype']);
									$fieldtaxname_loc = 'pointfinderlocations';
									$args['tax_query'][] = array(
											'taxonomy' => $fieldtaxname_loc,
											'field' => 'id',
											'terms' => $pfvalue_arr_loc,
											'operator' => 'IN'
									);
								}
							}

						/* Item type */
							if($setup3_pointposttype_pt4_check == 1){
								if($pfgetdata['itemtype'] != ''){
									$pfvalue_arr_it = PFGetArrayValues_ld($pfgetdata['itemtype']);
									$fieldtaxname_it = 'pointfinderitypes';
									$args['tax_query'][] = array(
											'taxonomy' => $fieldtaxname_it,
											'field' => 'id',
											'terms' => $pfvalue_arr_it,
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

						/* Features type */
							if($setup3_pointposttype_pt6_check == 1){
								if($pfgetdata['features'] != ''){
									$pfvalue_arr_fe = PFGetArrayValues_ld($pfgetdata['features']);
									$fieldtaxname_fe = 'pointfinderfeatures';
									$args['tax_query'][] = array(
											'taxonomy' => $fieldtaxname_fe,
											'field' => 'id',
											'terms' => $pfvalue_arr_fe,
											'operator' => 'IN'
									);
								}
							}


						$pfitemboxbg = ' style="background-color:'.$pfgetdata['itemboxbg'].';"';
						$pfheaderfilters = ($pfgetdata['filters']=='true') ? '' : 'false' ;

						if($pfgetdata['cols'] != '' && $pfgrid == ''){$pfgrid = 'grid'.$pfgetdata['cols'];}

						/* Changed values by user (Order / Sort / paging number) */
							if($pfg_orderby != ''){
								if($pfg_orderby == 'date' || $pfg_orderby == 'title'){
									$args['orderby']=$pfg_orderby;
								}else{
									$args['meta_key']='webbupointfinder_item_'.$pfg_orderby;
									if(PFIF_CheckFieldisNumeric_ld($pfg_orderby) == false){
										$args['orderby']='meta_value';
									}else{
										$args['orderby']='meta_value_num';
									}
									
								}
								if($pfg_orderby == 'date' || $pfg_orderby == 'title'){
									if ($pfgetdata['featureditemshide'] != 'yes') {
										$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
										$args['orderby'] = array('meta_value_num' => 'DESC' , $pfg_orderby => $pfg_order);
									}else{
										unset($args['meta_key']);
										$args['orderby'] = array($pfg_orderby => $pfg_order);
									}
									
								}else{
									$args['meta_key']='webbupointfinder_item_'.$pfg_orderby;
									if(PFIF_CheckFieldisNumeric_ld($pfg_orderby) == false){
										$args['orderby']=array('meta_value' => $pfg_order);
									}else{
										$args['orderby']= array('meta_value_num' => $pfg_order);
									}
									
								}
							}else{
								if($pfgetdata['orderby'] != ''){
									if ($pfgetdata['featureditemshide'] != 'yes') {
										$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
										$order_user_dt = (isset($pfgetdata['sortby'])) ? $pfgetdata['sortby'] : 'ASC' ;
										$args['orderby'] = array('meta_value_num' => 'DESC',$pfgetdata['orderby'] => $order_user_dt);
									}else{
										unset($args['meta_key']);
										$order_user_dt = (isset($pfgetdata['sortby'])) ? $pfgetdata['sortby'] : 'ASC' ;
										$args['orderby'] = array($pfgetdata['orderby'] => $order_user_dt);
									}
								}else{
									if ($pfgetdata['featureditemshide'] != 'yes') {
										$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
										$args['orderby'] = array('meta_value_num' => 'DESC' , $setup22_searchresults_defaultsortbytype => $setup22_searchresults_defaultsorttype);
									}else{
										unset($args['meta_key']);
										$args['orderby'] = array($setup22_searchresults_defaultsortbytype => $setup22_searchresults_defaultsorttype);
									}
								}
							}
						
						
							if($pfg_number != ''){
								$args['posts_per_page'] = $pfg_number;
							}else{
								if($pfgetdata['items'] != ''){
									$args['posts_per_page'] = $pfgetdata['items'];
								}else{
									$args['posts_per_page'] = $setup22_searchresults_defaultppptype;
								}
							}
							
							if($pfg_paged != ''){$args['paged'] = $pfg_paged;}

						/* Show only Featured items filter */
							if($pfgetdata['featureditems'] == 'yes' && $pfgetdata['featureditemshide'] != 'yes'){
								$args['meta_query'][] = array(
									'key' => 'webbupointfinder_item_featuredmarker',
									'value' => 1,
									'compare' => '=',
									'type' => 'NUMERIC'
								);
							}

						/* Hide Featured items filter */
							if ($pfgetdata['featureditemshide'] == 'yes') {
								$args['meta_query'][] = array(
									'key' => 'webbupointfinder_item_featuredmarker',
									'value' => 0,
									'compare' => '=',
									'type' => 'NUMERIC'
								);
							}
					}
			}else{
				/*
				* If query is a map search list grid
				*/
				$pfsearchvars = array();
				if(isset($_POST['dtx']) && $_POST['dtx']!=''){

					$pfgetdatax = $_POST['dtx'];
					$pfgetdatax = PFCleanArrayAttr('PFCleanFilters',$pfgetdatax);


					if (is_array($pfgetdatax)) {
						foreach ($pfgetdatax as $key => $value) {

							if(isset($value['value'])){
								if (!empty($value['value'])) {
								
									if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
										$args['tax_query'] = array();
									}
									if(count($args['tax_query']) > 0){
										$args['tax_query'][(count($args['tax_query'])-1)]=
										array(
												'taxonomy' => $value['name'],
												'field' => 'id',
												'terms' => pfstring2BasicArray($value['value']),
												'operator' => 'IN'
										);
									}else{
										$args['tax_query']=
										array(
											'relation' => 'AND',
											array(
												'taxonomy' => $value['name'],
												'field' => 'id',
												'terms' => pfstring2BasicArray($value['value']),
												'operator' => 'IN'
											)
										);
									}
								}
							}
						}
					}
				}
			}

			/* If address not exist - if author mode not on*/
				/*if ($pfcontainerdiv == 'pfsearchresults') {
					$args['meta_query'][] = array(
						'key' => 'webbupointfinder_items_location',
						'compare' => 'EXISTS'
						
					);
					
				}*/


			/* On/Off filter for items */
				/*$args['meta_query'][] = array('relation' => 'OR',
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
	                
				);*/
				
				
				
			/* If point is visible */
				/*$args['meta_query'][] = array(
					'key' => 'webbupointfinder_item_point_visibility',
					'compare' => 'NOT EXISTS'
					
				);*/
				
		
		/* Start: Coordinate Filter */
			if ($sw != -360 && (!empty($sw) && !empty($sw2) && !empty($ne) && !empty($ne2))) {
				$loop_ex_posts = array();
				$args2 = $args;
				$args2['posts_per_page'] = -1;
				$loop_ex = new WP_Query( $args2 );
				if($loop_ex->post_count > 0){
					while ( $loop_ex->have_posts() ) : $loop_ex->the_post();
					if($pfaction != 'grid'){
						$coordinates = explode( ',', rwmb_meta('webbupointfinder_items_location') );
					}else{
						$coordinates = '0,0';
					}
					if (!empty($coordinates[0])) {
						if($coordinates[0] > $sw && $coordinates[0] < $ne && $coordinates[1] > $sw2 && $coordinates[1] < $ne2 && $coordinates[0] != '' && $coordinates[1] != ''){
							$loop_ex_posts[] = get_the_id();
						}
					}
					endwhile;
				}
				
				if (count($loop_ex_posts) > 0) {
					$args['post__in'] = $loop_ex_posts;
				}else{
					$args['post__in'] = array(12312312371263751263415234);
				}
				wp_reset_postdata();
			}
		/* End: Coordinate Filter */


		/* Start: Image Settings and hover elements */
			$setup22_searchresults_animation_image  = PFSAIssetControl('setup22_searchresults_animation_image','','WhiteSquare');
			$setup22_searchresults_hover_image  = PFSAIssetControl('setup22_searchresults_hover_image','','0');
			$setup22_searchresults_hover_video  = PFSAIssetControl('setup22_searchresults_hover_video','','0');
			$setup22_searchresults_hide_address  = PFSAIssetControl('setup22_searchresults_hide_address','','0');

			$setup16_featureditemribbon_hide = PFSAIssetControl('setup16_featureditemribbon_hide','','1');
			$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');
			$setup22_searchresults_hide_re = PFREVSIssetControl('setup22_searchresults_hide_re','','1');
			$setup22_searchresults_hide_excerpt_rl = PFSAIssetControl('setup22_searchresults_hide_excerpt_rl','','2');
			$setup16_reviewstars_nrtext = PFREVSIssetControl('setup16_reviewstars_nrtext','','0');

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

			/* Grid type for HTML strings */
			
			if($pfgrid == ''){
				switch($setup22_searchresults_defaultlistingtype){
					case '2':
					case '3':
					case '4':$pfgrid = 'grid'.$setup22_searchresults_defaultlistingtype;break;
					case '1':$pfgrid = 'grid1';break;
				}
			}

			switch($pfgrid){
				case 'grid1':$pfgrid_output = 'pf1col';$pfgridcol_output = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';break;
				case 'grid2':$pfgrid_output = 'pf2col';$pfgridcol_output = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';break;
				case 'grid3':$pfgrid_output = 'pf3col';$pfgridcol_output = 'col-lg-4 col-md-6 col-sm-6 col-xs-12';break;
				case 'grid4':$pfgrid_output = 'pf4col';$pfgridcol_output = 'col-lg-3 col-md-4 col-sm-4 col-xs-12';break;
				default:$pfgrid_output = 'pf4col';$pfgridcol_output = 'col-lg-3 col-md-4 col-sm-4 col-xs-12';break;
			}
		
			switch($pfgrid_output){case 'pf1col':$pfboptx_text = $pfboptx1_text;break;case 'pf2col':$pfboptx_text = $pfboptx2_text;break;case 'pf3col':$pfboptx_text = $pfboptx3_text;break;case 'pf4col':$pfboptx_text = $pfboptx4_text;break;}
		/* End: Image Settings and hover elements */

		/* Start: Favorites check */
			if ($user_loggedin_check) {
				$user_favorites_arr = get_user_meta( get_current_user_id(), 'user_favorites', true );
				if (!empty($user_favorites_arr)) {
					$user_favorites_arr = json_decode($user_favorites_arr,true);
				}else{
					$user_favorites_arr = array();
				}
			}
		/* End: Favorites check */

		/* Start: Size Limits */
			switch($pfgrid){	
				case 'grid1':
					$pf1colfix = ' hidden-lg hidden-md';
					$limit_chr = PFSizeSIssetControl('setupsizelimitwordconf_general_grid1address','',120);
					$limit_chr_title = PFSizeSIssetControl('setupsizelimitwordconf_general_grid1title','',120);
					break;								
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
		/* End: Size Limits */
		
		
		/* Start: Grid (HTML) */
			$wpflistdata .= '<div class="pfsearchresults '.$pfcontainershow.' pflistgridview">';

          	/* Start: Header Area for filters (HTML) */
	            if($pfheaderfilters == ''){

	            	$wpflistdata .= '<div class="'.$pfcontainerdiv.'-header pflistcommonview-header">';

		                if ($pfcontainerdiv === 'pfsearchresults') {
		                	$wpflistdata .= '<div class="pf-container"><div class="pf-row"><div class="col-lg-12">';
		                } 
		                			/*
		                            * Start: Left Filter Area
		                            */
			                            $wpflistdata .= '<ul class="'.$pfcontainerdiv.'-filters-left '.$pfcontainerdiv.'-filters searchformcontainer-filters searchformcontainer-filters-left golden-forms clearfix col-lg-9 col-md-9 col-sm-9 col-xs-12">';


				                            /*
				                            * Start: SORT BY Section
				                            */	   
												if($setup22_searchresults_status_sortby == 0){
												   	$wpflistdata .= '<li>';
													   	$wpflistdata .= '<label for="pfsearch-filter" class="lbl-ui select pfsortby">';
														   	$wpflistdata .= '<select class="pfsearch-filter" name="pfsearch-filter" id="pfsearch-filter">';

																	if($args['orderby'] == 'ID' && $args['orderby'] != 'meta_value_num' && $args['orderby'] != 'meta_value'){
																		$wpflistdata .= '<option value="" selected>'.esc_html__('SORT BY','pointfindert2d').'</option>';
																	}else{
																		$wpflistdata .= '<option value="">'.esc_html__('SORT BY','pointfindert2d').'</option>';
																	}

																	$pfgform_values3 = array('title','date');
																	$pfgform_values3_texts = array('title'=>esc_html__('Title','pointfindert2d'),'date'=>esc_html__('Date','pointfindert2d'));
																	
																	if (PFREVSIssetControl('setup11_reviewsystem_check','','0') == 1) {
																		array_push($pfgform_values3, 'reviewcount');
																		$pfgform_values3_texts['reviewcount'] = esc_html__('Review','pointfindert2d');
																	}

																	foreach($pfgform_values3 as $pfgform_value3){
																	   if(isset($pfg_orderby)){

																		   if(strcmp($pfgform_value3, $pfg_orderby) == 0){
																			   $wpflistdata .= '<option value="'.$pfgform_value3.'" selected>'.$pfgform_values3_texts[$pfgform_value3].'</option>';
																		   }else{
																			   $wpflistdata .= '<option value="'.$pfgform_value3.'">'.$pfgform_values3_texts[$pfgform_value3].'</option>';
																		   }

																		}else{

																		   if(strcmp($pfgform_value3, $setup22_searchresults_defaultsortbytype)){
																			   $wpflistdata .= '<option value="'.$pfgform_value3.'" selected>'.$pfgform_values3_texts[$pfgform_value3].'</option>';
																		   }else{
																			   $wpflistdata .= '<option value="'.$pfgform_value3.'">'.$pfgform_values3_texts[$pfgform_value3].'</option>';
																		   }

																		}
																	}

																	if(!isset($pfsearchvars)){$pfsearchvars = array();}
																		if(!isset($pfg_orderby)){
																			$wpflistdata .= PFIF_SortFields_ld($pfsearchvars);
																		}else{
																			$wpflistdata .= PFIF_SortFields_ld($pfsearchvars,$pfg_orderby);
																		}
																	
															$wpflistdata .='</select>';
														$wpflistdata .= '</label>';
													$wpflistdata .= '</li>';
												}
											/*
				                            * End: SORT BY Section
				                            */



				                            /*
				                            * Start: ASC/DESC Section
				                            */	
												if($setup22_searchresults_status_ascdesc == 0){
													$wpflistdata .= '<li>';
														$wpflistdata .= '<label for="pfsearch-filter-order" class="lbl-ui select pforderby">';
															$wpflistdata .= '<select class="pfsearch-filter-order" name="pfsearch-filter-order" id="pfsearch-filter-order" >';

															$pfgform_values2 = array('ASC','DESC');
															
															$pfgform_values2_texts = array('ASC'=>esc_html__('ASC','pointfindert2d'),'DESC'=>esc_html__('DESC','pointfindert2d'));
															
															foreach($pfgform_values2 as $pfgform_value2){
															   if(isset($pfg_order)){
						                                           if(strcmp($pfgform_value2,$pfg_order) == 0){
																  	   $wpflistdata .= '<option value="'.$pfgform_value2.'" selected>'.$pfgform_values2_texts[$pfgform_value2].'</option>';
																   }else{
																	   $wpflistdata .= '<option value="'.$pfgform_value2.'">'.$pfgform_values2_texts[$pfgform_value2].'</option>';
																   }
																}else{
																	if(strcmp($pfgform_value2,$setup22_searchresults_defaultsorttype) == 0){
																  	   $wpflistdata .= '<option value="'.$pfgform_value2.'" selected>'.$pfgform_values2_texts[$pfgform_value2].'</option>';
																   }else{
																	   $wpflistdata .= '<option value="'.$pfgform_value2.'">'.$pfgform_values2_texts[$pfgform_value2].'</option>';
																   }
																}
															}
															$wpflistdata .= '</select>';
														$wpflistdata .= '</label>';
													$wpflistdata .= '</li>';
												}
											/*
				                            * End: ASC/DESC Section
				                            */



				                            /*
				                            * Start: Number Section
				                            */
												if($setup22_searchresults_status_number == 0 && $pfg_authormode == 0 && $pfg_agentmode == 0){
													$wpflistdata .= '<li>';
														$wpflistdata .= '<label for="pfsearch-filter-number" class="lbl-ui select pfnumberby">';
															$wpflistdata .= '<select class="pfsearch-filter-number" name="pfsearch-filter-number" id="pfsearch-filter-number" >';

																$pfgform_values = PFIFPageNumbers();
															
																if($args['posts_per_page'] != ''){
																	$pagevalforn = $args['posts_per_page'];
																}else{
																	$pagevalforn = $setup22_searchresults_defaultppptype;
																}
																
																foreach($pfgform_values as $pfgform_value){
						                                           if(strcmp($pfgform_value,$pagevalforn) == 0){
																  	   $wpflistdata .= '<option value="'.$pfgform_value.'" selected>'.$pfgform_value.'</option>';
																   }else{
																	   $wpflistdata .= '<option value="'.$pfgform_value.'">'.$pfgform_value.'</option>';
																   }
																}

															$wpflistdata .= '</select>';
														$wpflistdata .= '</label>';
													$wpflistdata .= '</li>';
												}
											/*
				                            * End: Number Section
				                            */
											


											/*
				                            * Start: Category Filters
				                            */
					                            /*
					                            * Start: Listing Type Filter
					                            */
													if (isset($pfgetdata['listingtypefilters'])) {
														if($pfgetdata['listingtypefilters'] == 'yes'){
															$wpflistdata .= '
								                            <li class="pfltypebyli">
								                                <label for="pfsearch_filter_ltype" class="lbl-ui select pfltypeby">';
								                                ob_start();
																$pfltypeby_args = array(
																	'show_option_all'    => '',
																	'show_option_none'   => esc_html__('Listing Types','pointfindert2d'),
																	'option_none_value'  => '0',
																	'orderby'            => 'ID', 
																	'order'              => 'ASC',
																	'show_count'         => PFASSIssetControl('setup_gridsettings_ltype_filter_c','',0),
																	'hide_empty'         => PFASSIssetControl('setup_gridsettings_ltype_filter_h','',0), 
																	'child_of'           => 0,
																	'exclude'            => '',
																	'echo'               => 1,
																	'selected'           => (!empty($pfg_ltype))?$pfg_ltype:0,
																	'hierarchical'       => 1, 
																	'name'               => 'pfsearch_filter_ltype',
																	'id'                 => 'pfsearch_filter_ltype',
																	'class'              => 'pfsearch-filter-ltype',
																	'depth'              => 0,
																	'tab_index'          => 0,
																	'taxonomy'           => 'pointfinderltypes',
																	'hide_if_empty'      => false,
																	'value_field'	     => 'term_id',
																	'pointfinder'		 => 'directorylist'
																);
																wp_dropdown_categories($pfltypeby_args);
																$wpflistdata .= ob_get_contents();
																ob_end_clean();
															$wpflistdata .= '
								                                </label>
								                            </li>
															';
														}
													}
												/*
					                            * End: Listing Type Filter
					                            */


					                            /*
					                            * Start: Item Type Filter
					                            */
													if (isset($pfgetdata['itemtypefilters'])) {
														if($pfgetdata['itemtypefilters'] == 'yes' && $setup3_pointposttype_pt4_check == 1){
															$wpflistdata .= '
								                            <li class="pfitypebyli">
								                                <label for="pfsearch_filter_itype" class="lbl-ui select pfitypeby">';
																ob_start();
																$pfitypeby_args = array(
																	'show_option_all'    => '',
																	'show_option_none'   => esc_html__('Item Types','pointfindert2d'),
																	'option_none_value'  => '0',
																	'orderby'            => 'ID', 
																	'order'              => 'ASC',
																	'show_count'         => PFASSIssetControl('setup_gridsettings_itype_filter_c','',0),
																	'hide_empty'         => PFASSIssetControl('setup_gridsettings_itype_filter_h','',0), 
																	'child_of'           => 0,
																	'exclude'            => '',
																	'echo'               => 1,
																	'selected'           => (!empty($pfg_itype))?$pfg_itype:0,
																	'hierarchical'       => 1, 
																	'name'               => 'pfsearch_filter_itype',
																	'id'                 => 'pfsearch_filter_itype',
																	'class'              => 'pfsearch-filter-itype',
																	'depth'              => 0,
																	'tab_index'          => 0,
																	'taxonomy'           => 'pointfinderitypes',
																	'hide_if_empty'      => false,
																	'value_field'	     => 'term_id',	
																);
																wp_dropdown_categories($pfitypeby_args);
																$wpflistdata .= ob_get_contents();
																ob_end_clean();
															$wpflistdata .= '
								                                </label>
								                            </li>
															';
														}
													}
												/*
					                            * End: Item Type Filter
					                            */


												/*
					                            * Start: Location Type Filter
					                            */
													if (isset($pfgetdata['locationfilters'])) {
							                        	if($pfgetdata['locationfilters'] == 'yes' && $setup3_pointposttype_pt5_check == 1){
															$wpflistdata .= '
								                            <li class="pflocationbyli">
								                                <label for="pfsearch_filter_location" class="lbl-ui select pflocationby">';
																ob_start();
																$pflocationby_args = array(
																	'show_option_all'    => '',
																	'show_option_none'   => esc_html__('Locations','pointfindert2d'),
																	'option_none_value'  => '0',
																	'orderby'            => 'ID', 
																	'order'              => 'ASC',
																	'show_count'         => PFASSIssetControl('setup_gridsettings_location_filter_c','',0),
																	'hide_empty'         => PFASSIssetControl('setup_gridsettings_location_filter_h','',0), 
																	'child_of'           => 0,
																	'exclude'            => '',
																	'echo'               => 1,
																	'selected'           => (!empty($pfg_lotype))?$pfg_lotype:0,
																	'hierarchical'       => 1, 
																	'name'               => 'pfsearch_filter_location',
																	'id'                 => 'pfsearch_filter_location',
																	'class'              => 'pfsearch-filter-location',
																	'depth'              => 0,
																	'tab_index'          => 0,
																	'taxonomy'           => 'pointfinderlocations',
																	'hide_if_empty'      => false,
																	'value_field'	     => 'term_id',	
																);
																wp_dropdown_categories($pflocationby_args);
																$wpflistdata .= ob_get_contents();
																ob_end_clean();
															$wpflistdata .= '
								                                </label>
								                            </li>
															';
														}
													}
												/*
					                            * End: Location Type Filter
					                            */
					                        /*
				                            * End: Category Filters
				                            */

											if (!isset($_POST['pfex']) && empty($_POST['pfex'])) {$wpflistdata .= '<li class="pfgridlist6"></li>';}

										$wpflistdata .= '</ul>';
									/*
		                            * End: Left Filter Area
		                            */


		                            /*
		                            * Start: Right Filter Area
		                            */
				                        if($pfg_authormode == 0 && $pfg_agentmode == 0){
					                        $wpflistdata .= '<ul class="'.$pfcontainerdiv.'-filters-right '.$pfcontainerdiv.'-filters searchformcontainer-filters searchformcontainer-filters-right clearfix col-lg-3 col-md-3 col-sm-3 col-xs-12">';
											
			                                    if($setup22_searchresults_status_2col == 0){$wpflistdata .= '<li class="pfgridlist2 pfgridlistit" data-pf-grid="grid2" ></li>';}
			                                    if($setup22_searchresults_status_3col == 0){$wpflistdata .= '<li class="pfgridlist3 pfgridlistit" data-pf-grid="grid3" ></li>';}
			                                    if($setup22_searchresults_status_4col == 0){$wpflistdata .= '<li class="pfgridlist4 pfgridlistit" data-pf-grid="grid4" ></li>';}
			                                    if($setup22_searchresults_status_2colh == 0){$wpflistdata .= '<li class="pfgridlist5 pfgridlistit" data-pf-grid="grid1" ></li>';}
			                                    
												$wpflistdata .= '<li class="pfgridlist6"></li>';
			                                
											$wpflistdata .= '</ul>';
										}
									/*
		                            * End: Right Filter Area
		                            */

		                    

		                if ($pfcontainerdiv === 'pfsearchresults') {
		                    $wpflistdata .='</div></div></div>';
		            	}

					$wpflistdata .= '</div>';
	            }
        	/* End: Header Area for filters (HTML) */


        	/* Start: Grid List Area - HEAD (HTML) */
                $wpflistdata .='<div class="'.$pfcontainerdiv.'-content pflistcommonview-content" data-layout-mode="'.$grid_layout_mode.'">';
                
                if ($pfcontainerdiv === 'pfsearchresults') {
                	$wpflistdata.='<div class="pf-container"><div class="pf-row clearfix"><div class="col-lg-12">';
                }

            	$wpflistdata .='<ul class="pfitemlists-content-elements '.$pfgrid_output.'" data-layout-mode="'.$grid_layout_mode.'">';
            /* End: Grid List Area - HEAD (HTML) */



			/* Start: Loop for grid List */
				$loop = new WP_Query( $args );
				/*
				Check Results
					//print_r($loop->query).PHP_EOL;
					echo $loop->request.PHP_EOL;
					echo $loop->found_posts.PHP_EOL;
				*/
				if($loop->post_count > 0){
					while ( $loop->have_posts() ) : $loop->the_post();
						$post_id = get_the_id();
					
						/* Start: Prepare Item Elements */
							$ItemDetailArr = array();
							
							/* Get Item's WPML ID */
							if ($pflang) {$pfitemid = PFLangCategoryID_ld($post_id,$pflang);}else{$pfitemid = $post_id;}

							/* Start: Setup Featured Image */
								$featured_image = '';
								$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $pfitemid ), 'full' );
								$ItemDetailArr['featured_image_org'] = $featured_image[0];
								if($featured_image[0] != '' && $featured_image[0] != NULL){
									$ItemDetailArr['featured_image'] = aq_resize($featured_image[0],$featured_image_width,$featured_image_height,true);

									if($ItemDetailArr['featured_image'] === false) {
										if($general_retinasupport == 1){
											$ItemDetailArr['featured_image'] = aq_resize($featured_image[0],$featured_image_width/2,$featured_image_height/2,true);
											if($ItemDetailArr['featured_image'] === false) {
												$ItemDetailArr['featured_image'] = aq_resize($featured_image[0],$featured_image_width/4,$featured_image_height/4,true);
												if ($ItemDetailArr['featured_image'] === false) {
													$ItemDetailArr['featured_image'] = $ItemDetailArr['featured_image_org'];
													if($ItemDetailArr['featured_image'] == '') {
														$ItemDetailArr['featured_image'] = get_template_directory_uri().'/images/noimg.png';
													}
												}
											}
										}else{
											$ItemDetailArr['featured_image'] = aq_resize($featured_image[0],$featured_image_width/2,$featured_image_height/2,true);
											if ($ItemDetailArr['featured_image'] === false) {
												$ItemDetailArr['featured_image'] = $ItemDetailArr['featured_image_org'];
												if($ItemDetailArr['featured_image'] == '') {
													$ItemDetailArr['featured_image'] = get_template_directory_uri().'/images/noimg.png';
												}
											}
										}
										
									}
						
								}else{
									$ItemDetailArr['featured_image'] = get_template_directory_uri().'/images/noimg.png';
								}
							/* End: Setup Featured Image */

							/* Start: Setup Details */
								$ItemDetailArr['if_title'] = get_the_title($pfitemid);
								$ItemDetailArr['if_excerpt'] = get_the_excerpt();
								$ItemDetailArr['if_link'] = get_permalink($pfitemid);;
								$ItemDetailArr['if_address'] = esc_html(get_post_meta( $pfitemid, 'webbupointfinder_items_address', true ));
								$ItemDetailArr['featured_video'] =  get_post_meta( $pfitemid, 'webbupointfinder_item_video', true );
							
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
							/* End: Setup Details */

						/* End: Prepare Item Elements */	
						

						/* Start: Item Box */
							$fav_check = 'false';

							$wpflistdata_output .= '<li class="'.$pfgridcol_output.' wpfitemlistdata isotope-item">';
								$wpflistdata_output .= '<div class="pflist-item"'.$pfitemboxbg.'>';
									$wpflistdata_output .= '<div class="pflist-item-inner">';
									
										/* Start: Image Container */
											$wpflistdata_output .= '<div class="pflist-imagecontainer pflist-subitem">';
												$wpflistdata_output .= "<a href='".$ItemDetailArr['if_link']."'".$targetforitem."><img src='".$ItemDetailArr['featured_image'] ."' alt='' /></a>";
															
												/* Start: Favorites */
													if($setup4_membersettings_favorites == 1){
														if ($user_loggedin_check && count($user_favorites_arr)>0) {
															if (in_array($pfitemid, $user_favorites_arr)) {
																$fav_check = 'true';
																$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
															}
														}

														$wpflistdata_output .= '
														<div class="RibbonCTR">
							                                <span class="Sign">
								                                <a class="pf-favorites-link" data-pf-num="'.$pfitemid.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'">
								                                	<i class="pfadmicon-glyph-629"></i>
								                                </a>
							                                </span>
							                                <span class="Triangle"></span>
							                            </div>';
							                        }
							                    /* End: Favorites */

									            /* Start: Hover mode enabled */
													if($setup22_searchresults_hover_image == 0){
														$wpflistdata_output .= '<div class="pfImageOverlayH hidden-xs"></div>';
														
															if($setup22_searchresults_hover_video == 0 && !empty($ItemDetailArr['featured_video'])){	
																$wpflistdata_output .= '<div class="pfButtons pfStyleV pfStyleVAni hidden-xs">';
															}else{
																$wpflistdata_output .= '<div class="pfButtons pfStyleV2 pfStyleVAni hidden-xs">';
															}

															$wpflistdata_output .= '
															<span class="'.$pfbuttonstyletext.' clearfix">
																<a class="pficon-imageclick" data-pf-link="'.$ItemDetailArr['featured_image_org'].'" style="cursor:pointer">
																	<i class="pfadmicon-glyph-684"></i>
																</a>
															</span>';

															if($setup22_searchresults_hover_video == 0 && !empty($ItemDetailArr['featured_video'])){	
																$wpflistdata_output .= '
																<span class="'.$pfbuttonstyletext.'">
																	<a class="pficon-videoclick" data-pf-link="'.$ItemDetailArr['featured_video'].'" style="cursor:pointer">
																		<i class="pfadmicon-glyph-573"></i>
																	</a>
																</span>';
															}
															$wpflistdata_output .= '
															<span class="'.$pfbuttonstyletext.'">
																<a href="'.$ItemDetailArr['if_link'].'"'.$targetforitem.'>
																	<i class="pfadmicon-glyph-794"></i>
																</a>
															</span>';

														$wpflistdata_output .= '</div>';
													}
												/* End: Hover mode enabled */

												/* Start: Featured Item Ribbon */
													if ($setup16_featureditemribbon_hide != 0) {
						                        		$featured_check_x = get_post_meta( $pfitemid, 'webbupointfinder_item_featuredmarker', true );

		                        						if (!empty($featured_check_x)) {
						                        			$wpflistdata_output .= '<div class="pfribbon-wrapper-featured"><div class="pfribbon-featured">'.esc_html__('FEATURED','pointfindert2d').'</div></div>';
						                        		}
							                        	
							                        }
							                    /* End: Featured Item Ribbon */

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


								                /* Start: Price Value Check and Output */
													if ($output_data_priceval != '' || $output_data_ltypes != '') {

														$wpflistdata_output .= '<div class="pflisting-itemband'.$pf1colfix.'">';
													
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
												/* End: Price Value Check and Output */

											$wpflistdata_output .='</div>';

										/* End: Image Container */
									
										/* Start: Detail Texts */	
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
											/* Title and address area */
											$wpflistdata_output .= '
												<div class="pflist-detailcontainer pflist-subitem">
													<ul class="pflist-itemdetails">
														<li class="pflist-itemtitle"><a href="'.$ItemDetailArr['if_link'].'"'.$targetforitem.'>'.$title_text.'</a></li>
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
														if (!empty($output_data_ltypes) && $pfgrid == 'grid1') {
															$wpflistdata_output .= '<li class="pflist-category visible-lg visible-md"><i class="pfadmicon-glyph-534"></i>';
																$output_data_ltypes_f1col = str_replace("<div class=\"pflistingitem-subelement pf-price\">", "", $output_data_ltypes);
																$output_data_ltypes_f1col = str_replace("</div>", "", $output_data_ltypes_f1col);
																$output_data_ltypes_f1col = str_replace("<ul class=\"pointfinderpflisttermsgr\">", "", $output_data_ltypes_f1col);
																$output_data_ltypes_f1col = str_replace("</ul>", "", $output_data_ltypes_f1col);
																$output_data_ltypes_f1col = str_replace("<li>", "", $output_data_ltypes_f1col);
																$output_data_ltypes_f1col = str_replace("</li>", "", $output_data_ltypes_f1col);
																$wpflistdata_output .= $output_data_ltypes_f1col;
															$wpflistdata_output .= '</li>';
														}
														$wpflistdata_output .= '
													</ul>
													';
													if($pfboptx_text != 'style="display:none"' && $pfgrid == 'grid1'){
													$wpflistdata_output .= '
														<div class="pflist-excerpt pflist-subitem" '.$pfboptx_text.'>'.$excerpt_text.'</div>
													';
													}
													$wpflistdata_output .= '
												</div>
											';
												
											if($pfboptx_text != 'style="display:none"' && $pfgrid != 'grid1'){
												$wpflistdata_output .= '<div class="pflist-excerpt pflist-subitem" '.$pfboptx_text.'>'.$excerpt_text.'</div>';
											}

											if ((!empty($output_data_content) || !empty($output_data_priceval))) {
												if (!empty($pf1colfix)) {
													$pf1colfix2 = '<div class="pflist-customfield-price">'.$output_data_priceval.'</div>';
												}
												$wpflistdata_output .= '<div class="pflist-subdetailcontainer pflist-subitem">'.$pf1colfix2.'<div class="pflist-customfields">'.$output_data_content.'</div></div>';
											}

											/* Show on map text for search results and search page */
											if ($pfcontainerdiv === 'pfsearchresults' && PFSAIssetControl('setup22_searchresults_showmapfeature','','1') == 1) {
												$wpflistdata_output .= '
												<div class="pflist-subdetailcontainer pflist-subitem">
													<a data-pfitemid="'.$pfitemid.'" class="pfshowmaplink">
														<i class="pfadmicon-glyph-372"></i>
														'.esc_html__('SHOW ON MAP','pointfindert2d').'
													</a>
												</div>';
											}
										/* End: Detail Texts */
												
									$wpflistdata_output .= '</div>';
								$wpflistdata_output .= '</div>';
							$wpflistdata_output .= '</li>';

						/* End: Item Box */

					endwhile;
					$wpflistdata .= $wpflistdata_output;
				}
				$wpflistdata .= '</ul>';

				if($loop->found_posts == 0){
					/* No Record Found Area */
		            $wpflistdata .= '<div class="golden-forms">';
		            $wpflistdata .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>';
					$wpflistdata .= '<strong>'.esc_html__('No record found!','pointfindert2d').'</strong></p>';
					$wpflistdata .= '</div></div>';
				}
	        /* End: Loop for grid List */


            /* Start: Paginate */
				$wpflistdata .= '<div class="pfajax_paginate" >';
					$big = 999999999;
					$wpflistdata .= paginate_links(array(
						'base' => '%_%',
						'format' => '',
						'current' => max(1, $pfg_paged),
						'total' => $loop->max_num_pages,
						'type' => 'list',
					));
				$wpflistdata .= '</div>';
			/* End: Paginate */


			/* Start: Grid List Area - FOOTER (HTML) */
				if ($pfcontainerdiv === 'pfsearchresults') {
					$wpflistdata .= '</div></div></div>';
				}
				$wpflistdata .= '</div></div>';
			/* End: Grid List Area - FOOTER (HTML) */

			wp_reset_postdata();
		
	   echo $wpflistdata;
		
	die();
}

?>