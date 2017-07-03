<?php
//echo $_GET['jobskeyword'];
/*
$cookie_name = "jinlisting_zipcode";
$cookie_value = $_GET['field296725954161956900000'];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

$vQUERYSTRING=$_SERVER["QUERY_STRING"];

$useragent=$_SERVER['HTTP_USER_AGENT'];
$if_mobile=False;
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	$if_mobile=True;
}
$location=$_GET['field296725954161956900000'];

if ( empty($location) && ($if_mobile == true))
{
	$location='10001';
}
//echo $vQUERYSTRING;
if ($_GET['jobskeyword']<>'') {
	$term = get_term_by('name', $_GET['jobskeyword'], 'pointfinderltypes');
    $term_link = get_term_link( $term );
	$new_url="?field_listingtype=".$term->term_id."&pointfinder_radius_search=".$_GET['pointfinder_radius_search']."&field296725954161956900000=".$location."&ne=&ne2=&sw=&sw2=&s=&serialized=1&action=pfs";
if (!(is_wp_error( $term_link ))) {
	header("Location: " . $new_url);
}
}
*/
get_header();

	if (isset($_GET['action']) && $_GET['action'] == 'pfs') {

		/**
		*Start: Get search data & apply to query arguments.
		**/
			$pfgetdata = $_GET;
			$pfne = $pfne2 = $pfsw = $pfsw2 = $pfpointfinder_google_search_coord = '';
			$hidden_output = $search_output = '';
			$searchkeys = array('s', 'pageIndex', 'pfsearch-filter','pfsearch-filter-order','pfsearch-filter-number','pfsearch-filter-col');
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
//					$hidden_output .= '<input type="hidden" name="s" value=""/>';

					
					
					$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
					$args = array( 'post_type' => $setup3_pointposttype_pt1, 'post_status' => 'publish');
					

					if(isset($_GET['pfsearch-filter']) && $_GET['pfsearch-filter']!=''){$pfg_orderbyx = esc_attr($_GET['pfsearch-filter']);}else{$pfg_orderbyx = '';}
					if(isset($_POST['pfg_order']) && $_POST['pfg_order']!=''){$pfg_orderx = esc_attr($_POST['pfg_order']);}else{$pfg_orderx = '';}
					if(isset($_POST['pfg_number']) && $_POST['pfg_number']!=''){$pfg_numberx = esc_attr($_POST['pfg_number']);}else{$pfg_numberx = '';}

					$setup22_searchresults_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
					$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','ID');
					$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','ASC');


					if($pfg_orderbyx == ''){
//jschen remark, leave next 
//						$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
//						$args['orderby'] = array('meta_value_num' => 'DESC' , $setup22_searchresults_defaultsortbytype => $setup22_searchresults_defaultsorttype);
						$args['posts_per_page'] = $setup22_searchresults_defaultppptype;
					}else{
//						$args['meta_key'] = 'webbupointfinder_item_featuredmarker';
//						$args['orderby'] = array('meta_value_num' => 'DESC');
						$args['posts_per_page'] = $pfg_numberx;
					}

					if(isset($args['meta_query']) == false || isset($args['meta_query']) == NULL){
						$args['meta_query'] = array();
					}	

					if(isset($args['tax_query']) == false || isset($args['tax_query']) == NULL){
						$args['tax_query'] = array();
					}

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

						$location=isset($_GET['field296725954161956900000']) ? $_GET['field296725954161956900000']: '';
/*
						if ((empty($location))&&(empty($_REQUEST['jobskeyword'])))
                        {

                            $location=get_zip();

                        }
*/

						if (isset($_GET['pointfinder_radius_search'])) {
							$Miles = $_GET['pointfinder_radius_search'];
						}else {
							$Miles = 0;
						}

						if ($Miles<> 0 &&  isset($location) && !empty($location)) {
							if (!class_exists('RadiusCheck')) {
								require_once( get_stylesheet_directory().'/includes/location_check.php');
							}
							$address = esc_html($location);

							$prepAddr = str_replace(array(' '), array('+'), $address);

							$geocode = file_get_contents('http://google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');

							$output = json_decode($geocode);
							//echo $address;
							//exit();
							if (!empty($output) && $output->status != 'ZERO_RESULTS') {
								$Latitude = $output->results[0]->geometry->location->lat;

								$Longitude = $output->results[0]->geometry->location->lng;

								if (isset($Latitude) && $Latitude <> '' && isset($Longitude) && $Longitude <> '') {

									$zcdRadius = new RadiusCheck($Latitude, $Longitude, $Miles);
									$minLat = $zcdRadius->MinLatitude();
									$maxLat = $zcdRadius->MaxLatitude();
									$minLong = $zcdRadius->MinLongitude();
									$maxLong = $zcdRadius->MaxLongitude();
								}


							}
							$args['meta_query'][] = array(
								'key' => 'latitude',
								'value' => array($minLat, $maxLat),
								'compare' => 'BETWEEN',
								'type' => 'CHAR'
							);
							$args['meta_query'][] =array(
								'key' => 'longitude',
								'value' => array($maxLong,$minLong ),
								'compare' => 'BETWEEN',
								'type' => 'CHAR'
							);
						}



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
											$pfvalue=big2gb($pfvalue);
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
/*
		echo 'jschen: menualargs=';
		print_r($args);
*/
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
                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                        if(false && preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
                            ?>
                            <div class="sidebar-widget">
                                <div id="pf_search_items_w-14" class="widget_pfitem_recent_entries">
                                    <div class="pfwidgettitle">
                                        <div class="widgetheader">商家搜索</div>
                                    </div>
                                    <div class="pfwidgetinner">
                                        <form id="pointfinder-search-form-manual" method="get"
                                              action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
                                            <div class="pfsearch-content golden-forms">
                                                <div class="pfsearchformerrors">
                                                    <ul>
                                                    </ul>
                                                    <a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE', 'pointfindert2d') ?></a>
                                                </div>
                                                <?php
                                                $setup1s_slides = PFSAIssetControl('setup1s_slides', '', '');

                                                if (is_array($setup1s_slides)) {

                                                    /**
                                                     *Start: Get search data & apply to query arguments.
                                                     **/

                                                    $pfgetdata = $_GET;

                                                    if (is_array($pfgetdata)) {

                                                        $pfformvars = array();

                                                        foreach ($pfgetdata as $key => $value) {
                                                            if (!empty($value) && $value != 'pfs') {
                                                                $pfformvars[$key] = $value;
                                                            }
                                                        }

                                                        $pfformvars = PFCleanArrayAttr('PFCleanFilters', $pfformvars);

                                                    }
                                                    /**
                                                     *End: Get search data & apply to query arguments.
                                                     **/
                                                    $PFListSF = new PF_SF_Val();
                                                    foreach ($setup1s_slides as &$value) {

                                                        $PFListSF->GetValue($value['title'], $value['url'], $value['select'], 1, $pfformvars);

                                                    }


                                                    /*Sense Category*/
                                                    $current_post_id = get_the_id();

                                                    if (!empty($current_post_id) && (is_single())) {
                                                        $current_post_terms = get_the_terms($current_post_id, 'pointfinderltypes');

                                                        if (isset($current_post_terms) && $current_post_terms != false) {
                                                            foreach ($current_post_terms as $key => $value) {
                                                                $category_selected_auto = $value->term_id;
                                                            }

                                                        }
                                                    } elseif (!empty($current_post_id) && (is_category() || is_archive() || is_tag())) {
                                                        global $wp_query;

                                                        if (isset($wp_query->query_vars['taxonomy'])) {
                                                            $taxonomy_name = $wp_query->query_vars['taxonomy'];
                                                            if ($taxonomy_name == 'pointfinderltypes') {
                                                                $term_slug = $wp_query->query_vars['term'];
                                                                $term_name = get_term_by('slug', $term_slug, $taxonomy_name, 'ARRAY_A');
                                                                if (isset($term_name['term_id'])) {
                                                                    $category_selected_auto = $term_name['term_id'];
                                                                }
                                                            }

                                                        }
                                                    }


                                                    /*Get Listing Type Item Slug*/
                                                    $fltf = pointfinder_find_requestedfields('pointfinderltypes');
                                                    $features_field = pointfinder_find_requestedfields('pointfinderfeatures');
                                                    $itemtypes_field = pointfinder_find_requestedfields('pointfinderitypes');
                                                    $conditions_field = pointfinder_find_requestedfields('pointfinderconditions');

                                                    $stp_syncs_it = PFSAIssetControl('stp_syncs_it', '', 1);
                                                    $stp_syncs_co = PFSAIssetControl('stp_syncs_co', '', 1);
                                                    $setup4_sbf_c1 = PFSAIssetControl('setup4_sbf_c1', '', 1);

                                                    $second_request_process = false;
                                                    $second_request_text = "{features:'',itemtypes:'',conditions:''}";
                                                    $multiple_itemtypes = $multiple_features = $multiple_conditions = '';

                                                    if (!empty($features_field) || !empty($itemtypes_field) || !empty($conditions_field)) {
                                                        $second_request_process = true;
                                                        $second_request_text = '{';
                                                        if (!empty($features_field) && $setup4_sbf_c1 == 0) {
                                                            $second_request_text .= "features:'$features_field'";
                                                            $multiple_features = PFSFIssetControl('setupsearchfields_' . $features_field . '_multiple', '', '0');
                                                        }
                                                        if (!empty($itemtypes_field) && $stp_syncs_it == 0) {
                                                            $second_request_text .= ",itemtypes:'$itemtypes_field'";
                                                            $multiple_itemtypes = PFSFIssetControl('setupsearchfields_' . $itemtypes_field . '_multiple', '', '0');
                                                        }
                                                        if (!empty($conditions_field) && $stp_syncs_co == 0) {
                                                            $second_request_text .= ",conditions:'$conditions_field'";
                                                            $multiple_conditions = PFSFIssetControl('setupsearchfields_' . $conditions_field . '_multiple', '', '0');
                                                        }

                                                        if (!empty($multiple_itemtypes)) {
                                                            $second_request_text .= ",mit:'1'";
                                                        }

                                                        if (!empty($multiple_features)) {
                                                            $second_request_text .= ",mfe:'1'";
                                                        }

                                                        if (!empty($multiple_conditions)) {
                                                            $second_request_text .= ",mco:'1'";
                                                        }


                                                        $second_request_text .= '}';
                                                    }

                                                    $pfformvars_json = (isset($pfformvars)) ? json_encode($pfformvars) : json_encode(array());

                                                    echo $PFListSF->FieldOutput;
                                                    echo '<div id="pfsearchsubvalues"></div>';
                                                    echo '<input type="hidden" name="s" value=""/>';
                                                    echo '<input type="hidden" name="serialized" value="1"/>';
                                                    echo '<input type="hidden" name="action" value="pfs"/>';
                                                    echo  '<input type="submit" style="display:none"/>';
                                                    echo '<a class="button pfsearch" id="pf-search-button-manual"><i class="pfadmicon-glyph-627"></i> ' . esc_html__('搜索', 'pointfindert2d') . '</a>';
                                                    echo '<script type="text/javascript">
                    (function($) {
                        "use strict";
                        $.pffieldsids = ' . $second_request_text . '
                        $.pfsliderdefaults = {};$.pfsliderdefaults.fields = Array();

                        $(function(){
                        ' . $PFListSF->ScriptOutput;
                                                    echo 'var pfsearchformerrors = $(".pfsearchformerrors");
                        
                            $("#pointfinder-search-form-manual").validate({
                                  debug:false,
                                  onfocus: false,
                                  onfocusout: false,
                                  onkeyup: false,
                                  rules:{' . $PFListSF->VSORules . '},messages:{' . $PFListSF->VSOMessages . '},
                                  ignore: ".select2-input, .select2-focusser, .pfignorevalidation",
                                  validClass: "pfvalid",
                                  errorClass: "pfnotvalid pfadmicon-glyph-858",
                                  errorElement: "li",
                                  errorContainer: pfsearchformerrors,
                                  errorLabelContainer: $("ul", pfsearchformerrors),
                                  invalidHandler: function(event, validator) {
                                    var errors = validator.numberOfInvalids();
                                    if (errors) {
                                        pfsearchformerrors.show("slide",{direction : "up"},100)
                                        $(".pfsearch-err-button").click(function(){
                                            pfsearchformerrors.hide("slide",{direction : "up"},100)
                                            return false;
                                        });
                                    }else{
                                        pfsearchformerrors.hide("fade",300)
                                    }
                                  }
                            });
                        ';

                                                    if ($fltf != 'none') {
                                                        $as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns', '', '0');

                                                        if ($as_mobile_dropdowns == 1) {
                                                            echo '
                                $(function(){
                                    $("#' . $fltf . '" ).change(function(e) {
                                      $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                      ';
                                                            if ($second_request_process) {
                                                                echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                            }
                                                            echo '
                                    });
                                    $(document).one("ready",function(){
                                        if ($("#' . $fltf . '" ).val() !== 0) {
                                           $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                           ';
                                                            if ($second_request_process) {
                                                                echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                            }
                                                            echo '
                                        }
                                    });
                                    setTimeout(function(){
                                       $(".select2-container" ).attr("title","");
                                       $("#' . $fltf . '" ).attr("title","")
                                        
                                    },300);
                                });
                                ';
                                                        } else {
                                                            echo '
                               
                                $("#' . $fltf . '" ).change(function(e) {
                                  $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                  ';
                                                            if ($second_request_process) {
                                                                echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                            }
                                                            echo '
                                });
                                $(document).one("ready",function(){
                                    if ($("#' . $fltf . '" ).val() !== 0) {
                                       $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                       ';
                                                            if ($second_request_process) {
                                                                echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                            }
                                                            echo '
                                    }
                                });
                                setTimeout(function(){
                                   $(".select2-container" ).attr("title","");
                                   $("#' . $fltf . '" ).attr("title","")
                                    
                                },300);
                              
                                ';
                                                        }
                                                    }
                                                    echo '
                        });' . $PFListSF->ScriptOutputDocReady;
                                                }

                                                if (!empty($category_selected_auto)) {
                                                    echo '
                            $(document).ready(function(){
                                if ($("#' . $fltf . '" )) {
                                    $("#' . $fltf . '" ).select2("val","' . $category_selected_auto . '");
                                }
                            });
                        ';
                                                }
                                                echo '   
                        
                    })(jQuery);
                    </script>';

                                                unset($PFListSF);
                                                ?>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }

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
