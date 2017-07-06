<?php
/**********************************************************************************************************************************
*
* Custom Search Fields Retrieve Value Class
* This class prepared for help to create auto config file.
* Author: Webbu Design
*
***********************************************************************************************************************************/
if ( ! class_exists( 'PF_SF_Val' ) ){
	class PF_SF_Val{
		
		public $FieldOutput;
		public $PFHalf = 1;
		public $ScriptOutput;
		public $ScriptOutputDocReady;
		public $VSORules;
		public $VSOMessages;
		public $ListingTypeField;
		public $LocationField;


		public function __construct(){}
		
		function PriceFieldCheck($slug){
			if(PFCFIssetControl('setupcustomfields_'.$slug.'_currency_check','','0') == 1){
				return array(
					'CFPrefix' => PFCFIssetControl('setupcustomfields_'.$slug.'_currency_prefix','',''),
					'CFSuffix' => PFCFIssetControl('setupcustomfields_'.$slug.'_currency_suffix','',''),
					'CFDecima' => PFCFIssetControl('setupcustomfields_'.$slug.'_currency_decima','','0'),
					'CFDecimp' => PFCFIssetControl('setupcustomfields_'.$slug.'_currency_decimp','','.'),
					'CFDecimt' => PFCFIssetControl('setupcustomfields_'.$slug.'_currency_decimt','',',')
				);
			}else{return 'none';	}
		}
		
		function SizeFieldCheck($slug){
			if(PFCFIssetControl('setupcustomfields_'.$slug.'_size_check','','0') == 1){
				return array(
					'CFPrefix' => PFCFIssetControl('setupcustomfields_'.$slug.'_size_prefix','',''),
					'CFSuffix' => PFCFIssetControl('setupcustomfields_'.$slug.'_size_suffix','',''),
					'CFDecima' => 0,
					'CFDecimp' => PFCFIssetControl('setupcustomfields_'.$slug.'_size_decimp','','.'),
					'CFDecimt' => '.'
				);
			}else{return 'none';	}
		}
		
		function CheckItemsParent($slug){
			$RelationFieldName = 'setupcustomfields_'.$slug.'_parent';

			$ParentItem = PFCFIssetControl($RelationFieldName,'','');
			
	
			if(!empty($ParentItem)){
				
				if(function_exists('icl_t')) {
					if (is_array($ParentItem)) {
						foreach ($ParentItem as $key => $value) {
							$ParentItem[$key] = icl_object_id($value,'pointfinderltypes',true,PF_current_language());
						}
					}else{
						$ParentItem = icl_object_id($ParentItem,'pointfinderltypes',true,PF_current_language());
					}
					return $ParentItem;
					
				} else {
					return $ParentItem;
				}
			}else{
				return 'none';
			}
		}

		function GetMiniSearch($minisearchc=1){
			switch ($minisearchc) {
				case '1':
					return '<div class="col-lg-6 col-md-6 col-sm-6 colhorsearch">';
					break;
				
				case '2':
					return '<div class="col-lg-4 col-md-4 col-sm-4 colhorsearch">';
					break;

				case '3':
					return '<div class="col-lg-3 col-md-3 col-sm-3 colhorsearch">';
					break;

				default:
					return '<div class="col-lg-6 col-md-6 col-sm-6 colhorsearch">';
					break;
			}
		}

		function ShowOnlyWidgetCheck($widget,$slug,$minisearch){
			$showonlywidget_check = 'show';
			
			$showonlywidget = PFSFIssetControl('setupsearchfields_'.$slug.'_showonlywidget','','0');
			$minisearchadm = PFSFIssetControl('setupsearchfields_'.$slug.'_minisearch','','0');
			$minisearchso = PFSFIssetControl('setupsearchfields_'.$slug.'_minisearchso','','0');
			
			if ($showonlywidget == 0 && $widget == 0) {
				$showonlywidget_check = 'show';
			}elseif ($showonlywidget == 1 && $widget == 0) {
				$showonlywidget_check = 'hide';
			}else{
				$showonlywidget_check = 'show';
			}

			if ($minisearch == 1 && $minisearchadm == 0) {
				$showonlywidget_check = 'hide';
			}elseif ($minisearch == 0 && $minisearchso == 1) {
				$showonlywidget_check = 'hide';
			}

			return $showonlywidget_check;
		}
		
		
		function GetValue($title,$slug,$ftype,$widget=0,$pfgetdata=array(),$hormode=0,$minisearch=0,$minisearchc=1){
					global $pfsearchfields_options;
					
					$showonlywidget_check = $this->ShowOnlyWidgetCheck($widget,$slug,$minisearch);

					$lang_custom = '';

					if(function_exists('icl_t')) {
						$lang_custom = PF_current_language();
					}

					switch($ftype){
						case '1':
						/* Select Box */
							if ($showonlywidget_check == 'show') {
								$target = PFSFIssetControl('setupsearchfields_'.$slug.'_rvalues_target_target','','');

								$parentshowonly = PFSFIssetControl('setupsearchfields_'.$slug.'_parentso','','0');
								$ajaxloads = PFSFIssetControl('setupsearchfields_'.$slug.'_ajaxloads','','0');


								$itemparent = $this->CheckItemsParent($target);
								/*Check element: is it a taxonomy?*/
								$rvalues_check = PFSFIssetControl('setupsearchfields_'.$slug.'_rvalues_check','','0');

								if ($rvalues_check == 0) {
									$fieldtaxname = PFSFIssetControl('setupsearchfields_'.$slug.'_posttax','','');
									$fieldtaxSelected = PFSFIssetControl('setupsearchfields_'.$slug.'_posttax_selected','','');
								}

								if($itemparent == 'none'){
									$validation_check = PFSFIssetControl('setupsearchfields_'.$slug.'_validation_required','','0');
									if($validation_check == 1){
										$validation_message = PFSFIssetControl('setupsearchfields_'.$slug.'_message','','');
										if($this->VSOMessages != ''){
											$this->VSOMessages .= ','.$slug.':"'.$validation_message.'"';
										}else{
											$this->VSOMessages = $slug.':"'.$validation_message.'"';
										}
										
										if($this->VSORules != ''){
											$this->VSORules .= ','.$slug.':"required"';
										}else{
											$this->VSORules = $slug.':"required"';
										}
									}
									
									$select2_style = PFSFIssetControl('setupsearchfields_'.$slug.'_select2','','0');
									if($select2_style == 0){
										$select2sh = ', minimumResultsForSearch: -1';
									}else{ $select2sh = '';}
									
									$placeholder = PFSFIssetControl('setupsearchfields_'.$slug.'_placeholder','','');
									if($placeholder == ''){ $placeholder = esc_html__('Please select','pointfindert2d');};
									$nomatch = (isset($pfsearchfields_options['setupsearchfields_'.$slug.'_nomatch']))?$pfsearchfields_options['setupsearchfields_'.$slug.'_nomatch']:'';
									if($nomatch == ''){ $nomatch = '';};
									
									$column_type = PFSFIssetControl('setupsearchfields_'.$slug.'_column','','0');
									$multiple = PFSFIssetControl('setupsearchfields_'.$slug.'_multiple','','0');
									if($multiple == 1){ $multiplevar = 'multiple';}else{$multiplevar = '';};
									
									if ($multiple == 1 && ($widget == 1 || $minisearch == 1)) {
										$taxmultipletype = '[]';
									}else{
										$taxmultipletype = '';
									}
									
									
									if($column_type == 1){
										if ($this->PFHalf % 2 == 0) {
											$this->FieldOutput .= '<div class="col6 last"><div id="'.$slug.'_main">';
										}else{
											if ($hormode == 1 && $widget == 0) {
												$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
											}
											if ($hormode == 1 && $widget == 1 && $minisearch == 1) {
												$this->FieldOutput .= $this->GetMiniSearch($minisearchc);
											}
											$this->FieldOutput .= '<div class="row"><div class="col6 first"><div id="'.$slug.'_main">';
										}
										$this->PFHalf++;
									}else{
										if ($hormode == 1 && $widget == 0) {
											$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
										}
										if ($hormode == 1 && $widget == 1 && $minisearch == 1) {
											$this->FieldOutput .= $this->GetMiniSearch($minisearchc);
										}
										$this->FieldOutput .= '<div id="'.$slug.'_main">';
									};


									/*/Begin to create Select Box*/
									if ($ajaxloads == 1 && $minisearch != 1 && $rvalues_check == 0 && ($fieldtaxname == 'pointfinderltypes' || $fieldtaxname == 'pointfinderlocations')) {
										if ($fieldtaxname == 'pointfinderltypes') {
											$this->ListingTypeField = $slug;
										}else{
											$this->LocationField = $slug;
										}
										$this->ScriptOutput .= '$("#'.$slug.'_sel").select2({placeholder: "'.esc_js($placeholder).'", formatNoMatches:"'.esc_js($nomatch).'",allowClear: true'.$select2sh.'});';
									}else{
										$this->ScriptOutput .= '$("#'.$slug.'").select2({placeholder: "'.esc_js($placeholder).'", formatNoMatches:"'.esc_js($nomatch).'",allowClear: true'.$select2sh.'});';
									}
									

									$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');
									if ($as_mobile_dropdowns == 1) {
										if ($ajaxloads == 1 && $minisearch != 1 && $rvalues_check == 0 && ($fieldtaxname == 'pointfinderltypes' || $fieldtaxname == 'pointfinderlocations')) {
											$this->ScriptOutput .= 'if(!$.pf_tablet_check()){$("#'.$slug.'_sel").select2("destroy");}';
										}else{
											$this->ScriptOutput .= 'if(!$.pf_tablet_check()){$("#'.$slug.'").select2("destroy");}';
										}
									}

									$fieldtext = PFSFIssetControl('setupsearchfields_'.$slug.'_fieldtext','','');
									$this->FieldOutput .= '<div class="pftitlefield">'.$fieldtext.'</div>';
									if ($ajaxloads == 1 && $minisearch != 1 && $rvalues_check == 0 && ($fieldtaxname == 'pointfinderltypes' || $fieldtaxname == 'pointfinderlocations')) {
										$this->FieldOutput .= '<label for="'.$slug.'_sel" class="lbl-ui select">';
									}else{
										$this->FieldOutput .= '<label for="'.$slug.'" class="lbl-ui select">';
									}

									$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

									if ($as_mobile_dropdowns == 1) {
										$as_mobile_dropdowns_text = 'class="pf-special-selectbox" data-pf-plc="'.$placeholder.'"';
									} else {
										$as_mobile_dropdowns_text = '';
									}

									

									if ($ajaxloads == 1 && $minisearch != 1 && $rvalues_check == 0 && ($fieldtaxname == 'pointfinderltypes' || $fieldtaxname == 'pointfinderlocations')) {

										$item_defaultvalue_output = $sub_level = $sub_sub_level = $item_defaultvalue_output_orj = '';

										if ($fieldtaxname == 'pointfinderltypes') {
											if (!empty($this->ListingTypeField)) {
												if (!empty($pfgetdata[$this->ListingTypeField])) {
													$fieldtaxSelected = $pfgetdata[$this->ListingTypeField];
												}
											}
										}else{
											if (!empty($this->LocationField)) {
												if (!empty($pfgetdata[$this->LocationField])) {
													$fieldtaxSelected = $pfgetdata[$this->LocationField];
												}
											}
										}
										
										if (!empty($fieldtaxSelected)) {
											if (count($fieldtaxSelected) > 1) {
												if (isset($fieldtaxSelected)) {
													$item_defaultvalue_output_orj = $fieldtaxSelected;
													$find_top_parent = pf_get_term_top_most_parent($fieldtaxSelected,$fieldtaxname);

													$ci=1;
													foreach ($fieldtaxSelected as $value) {
														$sub_level .= $value;
														if ($ci < count($fieldtaxSelected)) {
															$sub_level .= ',';
														}
														$ci++;
													}
													$item_defaultvalue_output = $find_top_parent['parent'];
												}
											}else{
												if (isset($fieldtaxSelected)) {
													$item_defaultvalue_output_orj = $fieldtaxSelected;
													$find_top_parent = pf_get_term_top_most_parent($fieldtaxSelected,$fieldtaxname);

													switch ($find_top_parent['level']) {
														case '1':
															$sub_level = $fieldtaxSelected;
															break;
														
														case '2':
															$sub_sub_level = $fieldtaxSelected;
															$sub_level = pf_get_term_top_parent($fieldtaxSelected,$fieldtaxname);
															break;
													}
													

													$item_defaultvalue_output = $find_top_parent['parent'];
												}
											}
										}

										$this->FieldOutput .= '<input type="hidden" name="'.$slug.'" id="'.$slug.'" value="'.$fieldtaxSelected.'"/>';
										if ($fieldtaxname == 'pointfinderltypes') {
											$cat_extra_opts = get_option('pointfinderltypes_covars');
										
											$subcatsarray = "var pfsubcatselect = [";
											$multiplesarray = "var pfmultipleselect = [";
										}
										$this->FieldOutput .= '<select '.$multiplevar.' id="'.$slug.'_sel" name="'.$slug.'_sel" '.$as_mobile_dropdowns_text.'>';
										
									
									}else{
										$this->FieldOutput .= '<select '.$multiplevar.' id="'.$slug.'" name="'.$slug.$taxmultipletype.'" '.$as_mobile_dropdowns_text.'>';
									}
									
									

									if($rvalues_check == 0){
									/* If this is a taxonomy */
										$fieldtaxname = PFSFIssetControl('setupsearchfields_'.$slug.'_posttax','','');
										$fieldtaxmove = PFSFIssetControl('setupsearchfields_'.$slug.'_posttax_move','','0');

										$mylat = PFSAIssetControl('setup5_mapsettings_lat','','');
										$mylng = PFSAIssetControl('setup5_mapsettings_lng','','');
										
										if($fieldtaxmove == 1 && $multiple != 1 && $widget == 0 && $ajaxloads != 1){ 
											/* If this is location and select move enabled. */
											/* GET - points per location */
											$this->ScriptOutput .= '$( "#'.$slug.'" ).change(function(){
													if($( "#'.$slug.'" ).val() != ""){
															if($.pfgmap3static.movemaplatlng[$( "#'.$slug.'" ).val()] != null){
																var mylatlng = new google.maps.LatLng($.pfgmap3static.movemaplatlng[$( "#'.$slug.'" ).val()][0],$.pfgmap3static.movemaplatlng[$( "#'.$slug.'" ).val()][1]);
																if($.pfgmap3static.pfmapobj != null && mylatlng != null){
																	$.pfmap_recenter($.pfgmap3static.pfmapobj,mylatlng,0,0);
																}
															}else{
																$.ajax({
																	beforeSend: function(){$(".pfmaploading").fadeIn("fast");},
																	type: "POST",
																	dataType: "script",
																	url: theme_map_functionspf.ajaxurl,
																	data: { 
																		"action": "pfget_taxpoint",
																		"id": $( "#'.$slug.'" ).val(),
																		"security": theme_map_functionspf.pfget_taxpoint,
																		"cl":$.pfgmap3static.currentlang
																	},
																	success:function(data){
																		if($.pfgmap3static.movemaplatlng[$( "#'.$slug.'" ).val()] != null){
																			var mylatlng = new google.maps.LatLng($.pfgmap3static.movemaplatlng[$( "#'.$slug.'" ).val()][0],$.pfgmap3static.movemaplatlng[$( "#'.$slug.'" ).val()][1]);
																		}else{
																			var mylatlng = new google.maps.LatLng('.$mylat.','.$mylng.');	
																		};
																		
																		if($.pfgmap3static.pfmapobj != null && mylatlng != null){
																			$.pfmap_recenter($.pfgmap3static.pfmapobj,mylatlng,0,0);
																		}
																	},
																	error: function (request, status, error) {},
																	complete: function(){$(".pfmaploading").fadeOut("slow");},
																	
																});
														}
													}else{
														$(".pfmaploading").fadeOut("slow");
														var mylatlng = new google.maps.LatLng('.$mylat.','.$mylng.');
														if($.pfgmap3static.pfmapobj != null && mylatlng != null){
															$.pfmap_recenter($.pfgmap3static.pfmapobj,mylatlng,0,0);
														}
													}
													
													});
												';
										}
										$process = 'ok';
										if($fieldtaxname != ''){

											$setup4_sbf_c1 = PFSAIssetControl('setup4_sbf_c1','','1');
											$stp_syncs_it = PFSAIssetControl('stp_syncs_it','',1);
											$stp_syncs_co = PFSAIssetControl('stp_syncs_co','',1);
											
											if ($fieldtaxname == 'pointfinderfeatures') {
												if ($setup4_sbf_c1 == 0) {
													$process = 'not';
												}
											}

											if ($fieldtaxname == 'pointfinderitypes') {
												if ($stp_syncs_it == 0) {
													$process = 'not';
												}
											}

											if ($fieldtaxname == 'pointfinderconditions') {
												if ($stp_syncs_co == 0) {
													$process = 'not';
												}
											}
											
											if ($ajaxloads == 1 && $minisearch != 1) {$parentshowonly = 1;}
											
											/*Select tax auto on cat page*/
												if (isset($pfgetdata['pointfinderltypes'])) {
																					
													if ($widget == 1 && !empty($pfgetdata['pointfinderltypes'])) {
														
														global $wp_query;
														if(isset($wp_query->query_vars['taxonomy'])){
															$taxonomy_name = $wp_query->query_vars['taxonomy'];
															
															if ($taxonomy_name == 'pointfinderltypes') {
																
																$term_slug = $wp_query->query_vars['term'];
												
																$term_name = get_term_by('slug', $term_slug, $taxonomy_name,'ARRAY_A');
																
																$fieldtaxSelected = $term_name['term_id'];

															}
														}
													}
												}
												
											if ($process == 'ok') {
												$fieldvalues = get_terms($fieldtaxname,array('hide_empty'=>false)); 
												
												$this->FieldOutput .= '	<option></option>';

												foreach( $fieldvalues as $parentfieldvalue){
													if($parentfieldvalue->parent == 0){

															if ($fieldtaxname == 'pointfinderltypes') {
																/* Multiple select & Subcat Select */
																$multiple_select = (isset($cat_extra_opts[$parentfieldvalue->term_id]['pf_multipleselect']))?$cat_extra_opts[$parentfieldvalue->term_id]['pf_multipleselect']:2;
																$subcat_select = (isset($cat_extra_opts[$parentfieldvalue->term_id]['pf_subcatselect']))?$cat_extra_opts[$parentfieldvalue->term_id]['pf_subcatselect']:2;

																if ($multiple_select == 1) {$multiplesarray .= $parentfieldvalue->term_id.',';}
																if ($subcat_select == 1) {$subcatsarray .= $parentfieldvalue->term_id.',';}
															}
														
															$mypf_text = '';
															
															if (empty($parentshowonly)) {
																$tax_class_text = 'class="pfoptheader"';
															}else{$tax_class_text = '';}

															if($fieldtaxSelected != ''){
																if (!empty($item_defaultvalue_output)) {
																	if(strcmp($item_defaultvalue_output,$parentfieldvalue->term_id) == 0){$mypf_text = " selected";}
																}else{
																	if(strcmp($fieldtaxSelected,$parentfieldvalue->term_id) == 0){$mypf_text = " selected";}
																}
																
															}

															if (isset($pfgetdata[$slug]) && ($widget == 1 || $minisearch == 1)) {
																if (is_array($pfgetdata[$slug])) {
																	if (in_array($parentfieldvalue->term_id, $pfgetdata[$slug])) {
																		$mypf_text = " selected";
																	}
																}else{
																	if ($parentfieldvalue->term_id == $pfgetdata[$slug]) {
																		$mypf_text = " selected";
																	}
																}
															}

															$this->FieldOutput .= '<option value="'.$parentfieldvalue->term_id.'"'.$mypf_text.' '.$tax_class_text.'>'.$parentfieldvalue->name.'</option>';
															
															if (empty($parentshowonly)) {
																foreach( $fieldvalues as $fieldvalue){
																	if($fieldvalue->parent == $parentfieldvalue->term_id){

																		if($fieldtaxSelected != ''){
																			if(strcmp($fieldtaxSelected,$fieldvalue->term_id) == 0){ $fieldtaxSelectedValue = 1;}else{ $fieldtaxSelectedValue = 0;}
																		}else{
																			$fieldtaxSelectedValue = 0;
																		}

																		
																		$tax_normal_output = '<option value="'.$fieldvalue->term_id.'">&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalue->name.'</option>';
																		$tax_selected_output = '<option value="'.$fieldvalue->term_id.'" selected>&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalue->name.'</option>';

																		if($fieldtaxSelectedValue == 1 && $widget == 0){
																			$this->FieldOutput .= $tax_normal_output;
																		}else{
																			if (array_key_exists($slug,$pfgetdata)) {
																				if (isset($pfgetdata[$slug])) {
																					if (is_array($pfgetdata[$slug])) {
																						if (in_array($fieldvalue->term_id, $pfgetdata[$slug])) {
																							$tax_normal_output = $tax_selected_output;
																						}
																					}else{
																						if ($fieldvalue->term_id == $pfgetdata[$slug]) {
																							$tax_normal_output = $tax_selected_output;
																						}else{
																							if ($fieldtaxSelectedValue == 1) {
																								$tax_normal_output = $tax_selected_output;
																							}
																						}
																					}
																					
																				}
																				
																			}
																			$this->FieldOutput .= $tax_normal_output;
																		}



																		$has_this_term_children = get_term_children( $fieldvalue->term_id, $fieldtaxname );

																		if (count($has_this_term_children) > 0) {

																			foreach( $fieldvalues as $fieldvalues2){

																				if($fieldvalues2->parent == $fieldvalue->term_id){
																					if($fieldtaxSelected != ''){
																						if(strcmp($fieldtaxSelected,$fieldvalues2->term_id) == 0){ $fieldtaxSelectedValues2 = 1;}else{ $fieldtaxSelectedValues2 = 0;}
																					}else{
																						$fieldtaxSelectedValues2 = 0;
																					}

																					$subtax_normal_output = '<option value="'.$fieldvalues2->term_id.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalues2->name.'</option>';
																					$subtax_selected_output = '<option value="'.$fieldvalues2->term_id.'" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fieldvalues2->name.'</option>';

																					if($fieldtaxSelectedValues2 == 1 && $widget == 0){
																						$this->FieldOutput .= $subtax_normal_output;
																					}else{
																						if (array_key_exists($slug,$pfgetdata)) {
																							if (isset($pfgetdata[$slug])) {

																								if (is_array($pfgetdata[$slug])) {
																									if (in_array($fieldvalue2->term_id, $pfgetdata[$slug])) {
																										$subtax_normal_output = $subtax_selected_output;
																									}
																								}else{
																									if ($fieldvalues2->term_id == $pfgetdata[$slug]) {
																										$subtax_normal_output = $subtax_selected_output;
																									}else{
																										if ($fieldtaxSelectedValue == 1) {
																											$subtax_normal_output = $subtax_selected_output;
																										}
																									}
																								}
																							}
																						}
																						$this->FieldOutput .= $subtax_normal_output;
																					}
																				}
																			}
																		}



																	}
																}
															}
															
													}
												}

											}else{
												$this->FieldOutput .= '	<option></option>';
											}
											


										}
									}elseif($rvalues_check == 1){
									/* If not a taxonomy */

										$rvalues = PFSFIssetControl('setupsearchfields_'.$slug.'_rvalues','','');

										if(count($rvalues) > 0){$fieldvalues = $rvalues;}else{$fieldvalues = '';}/* Get element's custom values.*/

										if(count($fieldvalues) > 0){
											
											$this->FieldOutput .= '	<option></option>';

											$ikk = 0;
											foreach ($fieldvalues as $s) { 

												if (function_exists('icl_t')) {
													$s = icl_t('admin_texts_pfsearchfields_options', '[pfsearchfields_options][setupsearchfields_'.$slug.'_rvalues]'.$ikk, $s);
												}

												if ($pos = strpos($s, '=')) { 

													$tax_normal_output = '<option value="'.trim(substr($s, 0, $pos)).'">'.trim(substr($s, $pos + strlen('='))).'</option>';
													$tax_selected_output = '<option value="'.trim(substr($s, 0, $pos)).'" selected>'.trim(substr($s, $pos + strlen('='))).'</option>';

													if($widget == 1){

														if (array_key_exists($slug,$pfgetdata)) {
															if (isset($pfgetdata[$slug])) {
																if (is_array($pfgetdata[$slug])) {
																	if (in_array(trim(substr($s, 0, $pos)), $pfgetdata[$slug])) {
																		$tax_normal_output = $tax_selected_output;
																	}
																}else{
																	if (trim(substr($s, 0, $pos)) == $pfgetdata[$slug]) {
																		$tax_normal_output = $tax_selected_output;
																	}
																}
															}
														}
													}
													$this->FieldOutput .= $tax_normal_output;

												}
												$ikk++;
											}
										}
									}

									$this->FieldOutput .= '</select>';
									$this->FieldOutput .= '</label>';

									if ($ajaxloads == 1 && $minisearch != 1 && $rvalues_check == 0 && ($fieldtaxname == 'pointfinderltypes' || $fieldtaxname == 'pointfinderlocations')) {
										
										if ($fieldtaxname == 'pointfinderlocations') {
											$this->FieldOutput .= '<div class="pf-sub-locations-container"></div>';
											$stp4_sublotyp_title = PFSAIssetControl('stp4_sublotyp_title','',esc_html__('Sub Location', 'pointfindert2d'));
											$stp4_subsublotyp_title = PFSAIssetControl('stp4_subsublotyp_title','',esc_html__('Sub Sub Location', 'pointfindert2d'));

											$this->ScriptOutput .= "
											/* Start: Function for sub location types */
												$.pf_get_sublocations = function(itemid,defaultv){
													$.ajax({
												    	beforeSend:function(){
												    		$('.pfsearch-content').pfLoadingOverlay({action:'show',opacity:0.5});
												    	},
														url: theme_scriptspf.ajaxurl,
														type: 'POST',
														dataType: 'html',
														data: {
															action: 'pfget_listingtype',
															id: itemid,
															default: defaultv,
															sname: 'pfupload_sublocations',
															stext: '".$stp4_sublotyp_title."',
															stype: 'locations',
															stax: 'pointfinderlocations',
															lang: '".$lang_custom."',
															security: '".wp_create_nonce('pfget_listingtype')."'
														},
													}).success(function(obj) {
														$('.pf-sub-locations-container').append('<div class=\'pfsublocations\'>'+obj+'</div>');
														if (obj != '') {
															if ($.pf_tablet_check()) {
																$('#pfupload_sublocations').select2({
																	placeholder: '".esc_html__('Please select','pointfindert2d')."', 
																	formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
																	allowClear: true, 
																	minimumResultsForSearch: 10
																});
															}";

															if (empty($sub_sub_level)) {
															$this->ScriptOutput .= "
																$.pf_get_subsublocations($('#pfupload_sublocations').val(),'');
															";
															}

															
															$this->ScriptOutput .= "
															$('#pfupload_sublocations').change(function(){
																if($(this).val() != 0 && $(this).val() != null){
																	$('#".$slug."').val($(this).val()).trigger('change');
																	$.pf_get_subsublocations($(this).val(),'');
																}else{
																	$('#".$slug."').val($('#".$slug."_sel').val());
																}
																$('.pfsubsublocations').remove();
															});
														}
													}).complete(function(obj,obj2){
														if (obj.responseText != '') {
															if (defaultv != '') {
																$('#".$slug."').val(defaultv).trigger('change');
															}else{
																$('#".$slug."').val(itemid).trigger('change');
															}";
																		
															if (!empty($sub_sub_level)) {
																$this->ScriptOutput .= "
																if (".$sub_level." == $('#pfupload_sublocations').val()) {
																	$.pf_get_subsublocations('".$sub_level."','".$sub_sub_level."');
																}
																";
															}
															$this->ScriptOutput .= "
														}
														setTimeout(function(){
															$('.pfsearch-content').pfLoadingOverlay({action:'hide'});
														},1000);
														
														
													});
												}


												$.pf_get_subsublocations = function(itemid,defaultv){
													$.ajax({
												    	beforeSend:function(){
												    		$('.pfsearch-content').pfLoadingOverlay({action:'show',opacity:0.5});
												    	},
														url: theme_scriptspf.ajaxurl,
														type: 'POST',
														dataType: 'html',
														data: {
															action: 'pfget_listingtype',
															id: itemid,
															default: defaultv,
															sname: 'pfupload_subsublocations',
															stext: '".$stp4_subsublotyp_title."',
															stype: 'locations',
															stax: 'pointfinderlocations',
															lang: '".$lang_custom."',
															security: '".wp_create_nonce('pfget_listingtype')."'
														},
													}).success(function(obj) {
														$('.pf-sub-locations-container').append('<div class=\'pfsubsublocations\'>'+obj+'</div>');
														if ($.pf_tablet_check()) {
															$('#pfupload_subsublocations').select2({
																placeholder: '".esc_html__('Please select','pointfindert2d')."', 
																formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
																allowClear: true, 
																minimumResultsForSearch: 10
															});
														}
															


															$('#pfupload_subsublocations').change(function(){
																if($(this).val() != 0){
																	$('#".$slug."').val($(this).val()).trigger('change');
																}else{
																	$('#".$slug."').val($('#pfupload_sublocations').val())
																}
															});

													}).complete(function(obj,obj2){
														if (obj.responseText != '') {
															if (defaultv != '') {
																$('#".$slug."').val(defaultv).trigger('change');
															}else{
																$('#".$slug."').val(itemid).trigger('change');
															}
														}
														setTimeout(function(){
															$('.pfsearch-content').pfLoadingOverlay({action:'hide'});
														},1000);
													});
												}

											/* End: Function for sub location types */
											";
											$this->ScriptOutput .= "
											$('#".$slug."_sel').change(function(){
												$('.pf-sub-locations-container').html('');
												$('#".$slug."').val($(this).val()).trigger('change');
												$.pf_get_sublocations($(this).val(),'');
											});
											";
										}

										if ($fieldtaxname == 'pointfinderltypes') {
											$subcatsarray .= "];";
											$multiplesarray .= "];";

											$this->ScriptOutput .= $subcatsarray . $multiplesarray;

											$this->FieldOutput .= '<div class="pf-sub-listingtypes-container"></div>';

											$setup4_submitpage_listingtypes_title = PFSAIssetControl('setup4_submitpage_listingtypes_title','','Listing Type');
											$setup4_submitpage_sublistingtypes_title = PFSAIssetControl('setup4_submitpage_sublistingtypes_title','','Sub Listing Type');
											$setup4_submitpage_subsublistingtypes_title = PFSAIssetControl('setup4_submitpage_subsublistingtypes_title','','Sub Sub Listing Type');
											$setup4_submitpage_listingtypes_verror = PFSAIssetControl('setup4_submitpage_listingtypes_verror','','Please select a listing type.');
											$stp4_forceu = PFSAIssetControl('stp4_forceu','',0);
										

											$this->ScriptOutput .= "
												$.pf_get_sublistingtypes = function(itemid,defaultv){
													if ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) != -1) {
														var multiple_ex = 1;
													}else{
														var multiple_ex = 0;
													}
													$.ajax({
												    	beforeSend:function(){
												    		$('.pfsearch-content').pfLoadingOverlay({action:'show',opacity:0.5});
												    	},
														url: theme_scriptspf.ajaxurl,
														type: 'POST',
														dataType: 'html',
														data: {
															action: 'pfget_listingtype',
															id: itemid,
															default: defaultv,
															sname: 'pfupload_sublistingtypes',
															stext: '".$setup4_submitpage_sublistingtypes_title."',
															stype: 'listingtypes',
															stax: 'pointfinderltypes',
															lang: '".$lang_custom."',
															multiple: multiple_ex,
															security: '".wp_create_nonce('pfget_listingtype')."'
														},
													}).success(function(obj) {
														
														$('.pf-sub-listingtypes-container').append('<div class=\'pfsublistingtypes\'>'+obj+'</div>');

														if (obj != '') {
														";
														
														if ($stp4_forceu == 1) {
															$this->ScriptOutput .= "$('#pfupload_sublistingtypes').rules('add',{
																required: true,
																messages:{required:'".$setup4_submitpage_listingtypes_verror."'
															}});";
														}
														

														$this->ScriptOutput .= "

															if ($.pf_tablet_check()) {
																$('#pfupload_sublistingtypes').select2({
																	placeholder: '".esc_html__("Please select",'pointfindert2d')."', 
																	formatNoMatches:'".esc_html__("No match found",'pointfindert2d')."',
																	allowClear: true, 
																	minimumResultsForSearch: 10
																});
															}

															if ($.pf_tablet_check() == false) {
																$('.pf-special-selectbox').each(function(index, el) {
																	$(this).children('option:first').remove();

																	var dataplc = $(this).data('pf-plc');
																	if (dataplc) {
																		$(this).prepend('<option value=\"\">'+dataplc+'</option>');
																	}else{
																		$(this).prepend('<option value=\"\">'+theme_scriptspf.pfselectboxtex+'</option>');
																	};
																});
															};";

															if (empty($sub_sub_level)) {
															$this->ScriptOutput .= " if ($('#pfupload_sublistingtypes').val() != 0 && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																$.pf_get_subsublistingtypes($('#pfupload_sublistingtypes').val(),'');
															}";
															}

															
															$this->ScriptOutput .= "
															$('#pfupload_sublistingtypes').change(function(){
																if($(this).val() != 0 && $(this).val() != null){
																	if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																		$('#".$slug."').val($(this).val()).trigger('change');
																	}else{
																		$('#".$slug."').val($(this).val());
																	}
																	if (($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																		$.pf_get_subsublistingtypes($(this).val(),'');
																	}
																}else{
																	if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																		$('#".$slug."').val($('#".$slug."_sel').val());
																	}else{
																		$('#".$slug."').val($('#".$slug."_sel').val()).trigger('change');
																	}
																	
																}
																$('.pfsubsublistingtypes').remove();
															});
														}

													}).complete(function(obj,obj2){
														if (obj.responseText != '') {

															if (defaultv != '') {
																if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																	$('#".$slug."').val(defaultv).trigger('change');
																}else{
																	$('#".$slug."').val(defaultv);
																}
															}else{
																
																if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																	$('#".$slug."').val(itemid).trigger('change');
																}else{
																	$('#".$slug."').val(itemid);
																}
															}
															";
															
															if (!empty($sub_sub_level)) {
																$this->ScriptOutput .= "
																if (".$sub_level." == $('#pfupload_sublistingtypes').val()) {
																	$.pf_get_subsublistingtypes('".$sub_level."','".$sub_sub_level."');
																}
																";
															}

														$this->ScriptOutput .= "
														}
														setTimeout(function(){
															$('.pfsearch-content').pfLoadingOverlay({action:'hide'});
														},1000);
													});
												}

												$.pf_get_subsublistingtypes = function(itemid,defaultv){
													$.ajax({
												    	beforeSend:function(){
												    		$('.pfsearch-content').pfLoadingOverlay({action:'show',opacity:0.5});
												    	},
														url: theme_scriptspf.ajaxurl,
														type: 'POST',
														dataType: 'html',
														data: {
															action: 'pfget_listingtype',
															id: itemid,
															default: defaultv,
															sname: 'pfupload_subsublistingtypes',
															stext: '".$setup4_submitpage_subsublistingtypes_title."',
															stype: 'listingtypes',
															stax: 'pointfinderltypes',
															lang: '".$lang_custom."',
															security: '".wp_create_nonce('pfget_listingtype')."'
														},
													}).success(function(obj) {
														$('.pf-sub-listingtypes-container').append('<div class=\'pfsubsublistingtypes\'>'+obj+'</div>');
														if (obj != '') {
														";

														if ($stp4_forceu == 1) {
															$this->ScriptOutput .= "$('#pfupload_subsublistingtypes').rules('add',{required: true,messages:{required:'".$setup4_submitpage_listingtypes_verror."'}});";
														}
														$this->ScriptOutput .= "
														if ($.pf_tablet_check()) {
															$('#pfupload_subsublistingtypes').select2({
																placeholder: '".esc_html__('Please select','pointfindert2d')."', 
																formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
																allowClear: true, 
																minimumResultsForSearch: 10
															});
														}

														if ($.pf_tablet_check() == false) {
																$('.pf-special-selectbox').each(function(index, el) {
																	$(this).children('option:first').remove();

																	var dataplc = $(this).data('pf-plc');
																	if (dataplc) {
																		$(this).prepend('<option value=\"\">'+dataplc+'</option>');
																	}else{
																		$(this).prepend('<option value=\"\">'+theme_scriptspf.pfselectboxtex+'</option>');
																	};
																});
															};


															$('#pfupload_subsublistingtypes').change(function(){
																if($('#pfupload_subsublistingtypes').val() != 0){
																	
																	if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																		$('#".$slug."').val($(this).val()).trigger('change');
																	}else{
																		$('#".$slug."').val($(this).val());
																	}

																}else{
																	
																	if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																		$('#".$slug."').val($('#pfupload_sublistingtypes').val()).trigger('change');
																	}else{
																		$('#".$slug."').val($('#pfupload_sublistingtypes').val());
																	}
																}
															});
														}

													}).complete(function(obj,obj2){
														if (obj.responseText != '') {

															if (defaultv != '') {
																
																if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																	$('#".$slug."').val(defaultv).trigger('change');
																}else{
																	$('#".$slug."').val(defaultv);
																}
															}else{
																
																if (($.inArray(parseInt($('#".$slug."_sel').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('#".$slug."_sel').val()),pfmultipleselect) == -1)) {
																	$('#".$slug."').val(itemid).trigger('change');
																}else{
																	$('#".$slug."').val(itemid);
																}
															}
														}
														setTimeout(function(){
															$('.pfsearch-content').pfLoadingOverlay({action:'hide'});
														},1000);
													});
												}


												$('#".$slug."_sel').change(function(){

													$('.pf-sub-listingtypes-container').html('');

													$('#".$slug."').val($(this).val()).trigger('change');

													$.pf_get_sublistingtypes($(this).val(),'');

												});
											";

											$this->ScriptOutput .= "$(function(){
											$.pf_get_sublistingtypes($('#".$slug."_sel').val(),'".$sub_level."');
											";
											if (empty($sub_sub_level) && !empty($sub_level)) {
												$this->ScriptOutput .= "$('#".$slug."').val('".$sub_level."');";
											}
											$this->ScriptOutput .= "});";
										}
									}

									
									
									if($column_type == 1){
										if ($this->PFHalf % 2 == 0) {
											$this->FieldOutput .= '</div></div>';
										}else{
											if (($hormode == 1 && $widget == 0) || ($hormode == 1 && $widget == 1 && $minisearch == 1)) {
												$this->FieldOutput .= '</div>';
											}
											$this->FieldOutput .= '</div></div></div>';
										}
									}else{
										if (($hormode == 1 && $widget == 0) || ($hormode == 1 && $widget == 1 && $minisearch == 1)) {
											$this->FieldOutput .= '</div>';
										}
										$this->FieldOutput .= '</div>';
									};

									
								}/*Parent Check*/
							}
							break;
						
						case '2':
						/* Slider Field */
							if ($showonlywidget_check == 'show') {
								
								$target = PFSFIssetControl('setupsearchfields_'.$slug.'_target','','');

								$itemparent = $this->CheckItemsParent($target);
								
								if($itemparent == 'none'){								
									
									$fieldtext = PFSFIssetControl('setupsearchfields_'.$slug.'_fieldtext','','');

									//Check price item
									$itempriceval = $this->PriceFieldCheck($target);
									
									
									//Check size item
									$itemsizeval = $this->SizeFieldCheck($target);
										
									// Get slider type.
									$slidertype = PFSFIssetControl('setupsearchfields_'.$slug.'_type','','');
									if($slidertype == 'range'){ $slidertype = 'true';}


									//Min value, max value, steps, color
									$fmin = PFSFIssetControl('setupsearchfields_'.$slug.'_min','','0');
									$fmax = PFSFIssetControl('setupsearchfields_'.$slug.'_max','','1000000');
									$fsteps = PFSFIssetControl('setupsearchfields_'.$slug.'_steps','','1');
									$fcolor = PFSFIssetControl('setupsearchfields_'.$slug.'_colorslider','','#3D637C');
									$fcolor2 = PFSFIssetControl('setupsearchfields_'.$slug.'_colorslider2','','#444444');
									$svalue = '';
									
									
									if (array_key_exists($slug,$pfgetdata)) {
										if($slidertype == 'true'){ 
											$valuestext = 'values:'.'['.$pfgetdata[$slug].'],'; 
											$slidertypetext = 'range: '.$slidertype.',';
										}
										if($slidertype == 'min'){ 
											$valuestext = 'value:'.$pfgetdata[$slug].',';
											$slidertypetext = 'range: \''.$slidertype.'\',';
										}
										if($slidertype == 'max'){ 
											$valuestext = 'value:'.$pfgetdata[$slug].',';
											$slidertypetext = 'range: \''.$slidertype.'\',';
										}
									}else{
										if($slidertype == 'true'){ 
											$valuestext = 'values:'.'['.$fmin.','.$fmax.'],'; 
											$slidertypetext = 'range: '.$slidertype.',';
										}
										if($slidertype == 'min'){ 
											$valuestext = 'value:'.$fmin.',';
											$slidertypetext = 'range: \''.$slidertype.'\',';
										}
										if($slidertype == 'max'){ 
											$valuestext = 'value:'.$fmax.',';
											$slidertypetext = 'range: \''.$slidertype.'\',';
										}
									}
									
									if($itempriceval != 'none'){
										$suffixtext = '+"'.$itempriceval['CFSuffix'].'"';
										$suffixtext2 = '+" - "';
										$prefixtext = '"'.$itempriceval['CFPrefix'].'"+';
										$prefixtext2 = '+"'.$itempriceval['CFPrefix'].'"+';
										$prefixtext3 = $itempriceval['CFPrefix'];
									}elseif($itemsizeval != 'none'){
										$suffixtext = '+"'.$itemsizeval['CFSuffix'].'"';
										$suffixtext2 = '+" - "';
										$prefixtext = '"'.$itemsizeval['CFPrefix'].'"+';
										$prefixtext2 = '+"'.$itemsizeval['CFPrefix'].'"+';
										$prefixtext3 = $itemsizeval['CFPrefix'];
									}else{
										$suffixtext = '';
										$suffixtext2 = '" - "';
										$prefixtext = '';
										$prefixtext2 = '';
										$prefixtext3 = '';
									}
									
									//Create script for this slider.

									$this->ScriptOutput .= '$( "#'.$slug.'" ).slider({'.$slidertypetext.''.$valuestext.'min: '.esc_js($fmin).',max: '.esc_js($fmax).',step: '.esc_js($fsteps).',slide: function(event, ui) {';
										
									$this->ScriptOutput .= '$("#'.$slug.'-view").';
									if($slidertype == 'true'){
										if($itempriceval != 'none'){
											$this->ScriptOutput .='val('.$prefixtext.' number_format(ui.values[0], '.$itempriceval['CFDecima'].', "'.$itempriceval['CFDecimp'].'", "'.$itempriceval['CFDecimt'].'") + " - '.$prefixtext3.'" + number_format(ui.values[1], '.$itempriceval['CFDecima'].', "'.$itempriceval['CFDecimp'].'", "'.$itempriceval['CFDecimt'].'") '.$suffixtext.');';
											
											
										}elseif($itemsizeval != 'none'){
											$this->ScriptOutput .='val('.$prefixtext.' number_format(ui.values[0], '.$itemsizeval['CFDecima'].', "'.$itemsizeval['CFDecimp'].'", "'.$itemsizeval['CFDecimt'].'") + " - '.$prefixtext3.'" + number_format(ui.values[1], '.$itemsizeval['CFDecima'].', "'.$itemsizeval['CFDecimp'].'", "'.$itemsizeval['CFDecimt'].'")  '.$suffixtext.');';
											
										}else{
											$this->ScriptOutput .='val(ui.values[0] + " - " + ui.values[1]);';
											
										}
									}else{
										if($itempriceval != 'none'){
											$this->ScriptOutput .='val('.$prefixtext.' ui.value '.$suffixtext.');';
											
										}elseif($itemsizeval != 'none'){
											$this->ScriptOutput .='val('.$prefixtext.' ui.value '.$suffixtext.');';
											
										}else{
											$this->ScriptOutput .='val(ui.value);';
											
										}
									}
									
									$this->ScriptOutput .= '$("#'.$slug.'-view2").';
									if($slidertype == 'true'){
										$this->ScriptOutput .='val(ui.values[0]+","+ui.values[1]);';
									}else{
										$this->ScriptOutput .='val(ui.value);';
									}
									
									
									
									
									$this->ScriptOutput .='}});';
									
									$this->ScriptOutput .='$( "#'.$slug.'" ).addClass("ui-slider-'.$slug.'");';
									
									if($slidertype == 'true'){
										if($itempriceval != 'none'){
											$this->ScriptOutput .='$("#'.$slug.'-view").val('.$prefixtext.' number_format($("#'.$slug.'").slider("values",0), '.$itempriceval['CFDecima'].', "'.$itempriceval['CFDecimp'].'", "'.$itempriceval['CFDecimt'].'") '.$suffixtext2.''.$prefixtext2.'number_format($("#'.$slug.'").slider("values",1), '.$itempriceval['CFDecima'].', "'.$itempriceval['CFDecimp'].'", "'.$itempriceval['CFDecimt'].'") '.$suffixtext.');';
										}elseif($itemsizeval != 'none'){
											$this->ScriptOutput .='$("#'.$slug.'-view").val('.$prefixtext.' number_format($("#'.$slug.'").slider("values", 0), '.$itemsizeval['CFDecima'].', "'.$itemsizeval['CFDecimp'].'", "'.$itemsizeval['CFDecimt'].'")  '.$suffixtext2.''.$prefixtext2.' number_format($("#'.$slug.'").slider("values", 1), '.$itemsizeval['CFDecima'].', "'.$itemsizeval['CFDecimp'].'", "'.$itemsizeval['CFDecimt'].'") '.$suffixtext.');';
										}else{
											$this->ScriptOutput .='$("#'.$slug.'-view").val($("#'.$slug.'").slider("values", 0) + " - " + $("#'.$slug.'").slider("values", 1));';
										}
									}else{
										if($itempriceval != 'none'){
											$this->ScriptOutput .='$("#'.$slug.'-view").val( '.$prefixtext.' number_format($("#'.$slug.'").slider("value"), '.$itempriceval['CFDecima'].', "'.$itempriceval['CFDecimp'].'", "'.$itempriceval['CFDecimt'].'") '.$suffixtext.');';
										}elseif($itemsizeval != 'none'){
											$this->ScriptOutput .='$("#'.$slug.'-view").val( '.$prefixtext.' number_format($("#'.$slug.'").slider("value"), '.$itemsizeval['CFDecima'].', "'.$itemsizeval['CFDecimp'].'", "'.$itemsizeval['CFDecimt'].'") '.$suffixtext.');';
										}else{
											$this->ScriptOutput .='$("#'.$slug.'-view").val( $("#'.$slug.'").slider("value"));';
										}
									}
									
									
									$this->ScriptOutputDocReady .= '$(document).one("ready",function(){$.pfsliderdefaults.fields["'.$slug.'_main"] = $("#'.$slug.'-view").val()});';
									
									$column_type = PFSFIssetControl('setupsearchfields_'.$slug.'_column','','0');						
									
									

									if($column_type == 1){
										if ($this->PFHalf % 2 == 0) {
											$this->FieldOutput .= '<div class="col6 last">';
										}else{
											if ($hormode == 1 && $widget == 0) {
												$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
											}
											if ($hormode == 1 && $widget == 1 && $minisearch == 1) {
												$this->FieldOutput .= $this->GetMiniSearch($minisearchc);
											}
											$this->FieldOutput .= '<div class="row"><div class="col6 first">';
										}
										$this->PFHalf++;
									}else{
										if ($hormode == 1 && $widget == 0) {
											$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
										}
										if ($hormode == 1 && $widget == 1 && $minisearch == 1) {
											$this->FieldOutput .= $this->GetMiniSearch($minisearchc);
										}
									};
									
									//Slider size calculate
									if(strlen($fmax) <=3){
										$slidersize = ((strlen($fmax)*8))+4;
									}else{
										if($suffixtext != ''){
											$slidersize = ((strlen($fmax)*8)*2)+50;
										}else{
											$slidersize = ((strlen($fmax)*8)*2)+20;
										}
									}
									//Output for this field
									$this->FieldOutput .= ' <div id="'.$slug.'_main"><label for="'.$slug.'-view" class="pfrangelabel">'.$fieldtext.'</label>
															<input type="text" id="'.$slug.'-view" class="slider-input" style="width:'.$slidersize.'px" disabled>';
									
									$this->FieldOutput .= '<input name="'.$slug.'" id="'.$slug.'-view2" type="hidden" class="pfignorevalidation" value="">';
									
									$this->FieldOutput .= ' <div class="slider-wrapper">
																<div id="'.$slug.'"></div>  
															</div></div>';
									if($column_type == 1){
										if ($this->PFHalf % 2 == 0) {
											$this->FieldOutput .= '</div>';
										}else{
											if (($hormode == 1 && $widget == 0) || ($hormode == 1 && $widget == 1 && $minisearch == 1)) {
												$this->FieldOutput .= '</div>';
											}
											$this->FieldOutput .= '</div></div>';
										}
									}else{
										if (($hormode == 1 && $widget == 0) || ($hormode == 1 && $widget == 1 && $minisearch == 1)) {
											$this->FieldOutput .= '</div>';
										}
									};
									

									
									if (array_key_exists($slug,$pfgetdata)) {
										$this->ScriptOutput .= '$( "#'.$slug.'-view2" ).val("'.$pfgetdata[$slug].'");';
									}
								}
							}
							break;
						
						case '4':
						/* Text Field */
							if ($showonlywidget_check == 'show') {
								
								$target = PFSFIssetControl('setupsearchfields_'.$slug.'_target_target','','');

								$itemparent = $this->CheckItemsParent($target);
								
								if($itemparent == 'none'){

									if ($hormode == 1) {
										$divBegin = '<div class="col-keyword col-md-3 col-sm-3 colhorsearch">';
										$divEnd ='</div>';	
										$labColor = 'color:white;';
										$txtWidth= 300;
									}else {
										$txtWidth= 230;
									}
									if ($target == 'google') {
											$vals = pf_get_location(); 
											$this->FieldOutput .= $divBegin . '
																<span style="' . $labColor . 'font-size:18px">Near</span>
																<span>
																<input id="aglAddress" value="'. $vals['addr'] . '" placeholder="输入地址"  type="text" style="width:'. $txtWidth .'px;height: 36px;">
																</span>
																<a id="aglId"><img src="/wp-content/themes/pointfinder/images/ge.png" width="25px" heigh="25px"></img> </a>
										 ' . $divEnd;
									}elseif ($target == 'title' ) {
										$placeholder = PFSFIssetControl('setupsearchfields_'.$slug.'_placeholder','','');
										$this->FieldOutput .= $divBegin . '
													<span style="'. $labColor .'font-size:18px">Find</span>
													<span ><input type="text" name="pfsearch-filter-keyword" id="jobskeyword" placeholder="'.$placeholder.'"'.$valtext.' style="width:'. ($txtWidth + 36) .'px;height: 36px;"/></span>
										 ' . $divEnd;
									}								
								}
							}
							break;

						case '5':
						/* Date Field */
							if ($showonlywidget_check == 'show') {
								wp_enqueue_script('jquery-ui-core');
								wp_enqueue_script('jquery-ui-datepicker');
								//wp_enqueue_style('jquery-ui-smoothnesspf2', get_template_directory_uri() . "/css/jquery-ui.structure.min.css", false, null);
								//wp_enqueue_style('jquery-ui-smoothnesspf', get_template_directory_uri() . "/css/jquery-ui.theme.min.css", false, null);

								$column_type = PFSFIssetControl('setupsearchfields_'.$slug.'_column','','0');
								$target = PFSFIssetControl('setupsearchfields_'.$slug.'_target','','');
								if (empty($target)) {
									$target = PFSFIssetControl('setupsearchfields_'.$slug.'_target_target','','');
								}

								$itemparent = $this->CheckItemsParent($target);
								if($itemparent == 'none'){

									$validation_check = PFSFIssetControl('setupsearchfields_'.$slug.'_validation_required','','0');
									$field_autocmplete = PFSFIssetControl('setupsearchfields_'.$slug.'_autocmplete','','1');

									if($validation_check == 1){
										$validation_message = PFSFIssetControl('setupsearchfields_'.$slug.'_message','','');
										
										if($this->VSOMessages != ''){
											$this->VSOMessages .= ','.$slug.':"'.$validation_message.'"';
										}else{
											$this->VSOMessages = $slug.':"'.$validation_message.'"';
										}
										
										if($this->VSORules != ''){
											$this->VSORules .= ','.$slug.':"required"';
										}else{
											$this->VSORules = $slug.':"required"';
										}
									}
									
									$fieldtext = PFSFIssetControl('setupsearchfields_'.$slug.'_fieldtext','','');
									$placeholder = PFSFIssetControl('setupsearchfields_'.$slug.'_placeholder','','');
									$column_type = PFSFIssetControl('setupsearchfields_'.$slug.'_column','','0');
									
									if($column_type == 1){
										if ($this->PFHalf % 2 == 0) {
											$this->FieldOutput .= '<div class="col6 last">';
										}else{
											if ($hormode == 1 && $widget == 0 && $target != 'google') {
												$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
											}
											if ($hormode == 1 && $widget == 1 && $minisearch == 1) {
												$this->FieldOutput .= $this->GetMiniSearch($minisearchc);
											}
											$this->FieldOutput .= '<div class="row"><div class="col6 first">';
										}
										$this->PFHalf++;
									}else{
										if ($hormode == 1 && $widget == 0) {
											$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
										}
										if ($hormode == 1 && $widget == 1 && $minisearch == 1) {
											$this->FieldOutput .= $this->GetMiniSearch($minisearchc);
										}
									};
									

									if (array_key_exists($slug,$pfgetdata)) {
										$valtext = ' value = "'.$pfgetdata[$slug].'" ';;
									}else{
										$valtext = '';
									}

									
										
									$this->FieldOutput .= '
									<div id="'.$slug.'_main">
									<label for="'.$slug.'" class="pftitlefield">'.$fieldtext.'</label>
									<label class="lbl-ui pflabelfixsearch pflabelfixsearch'.$slug.'">
										<input type="text" name="'.$slug.'" id="'.$slug.'" class="input" placeholder="'.$placeholder.'"'.$valtext.' />
									</label>    
									</div>                        
									';

									$setup4_membersettings_dateformat = PFSAIssetControl('setup4_membersettings_dateformat','','1');
									$setup3_modulessetup_openinghours_ex2 = PFSAIssetControl('setup3_modulessetup_openinghours_ex2','','1');
									$general_rtlsupport = PFSAIssetControl('general_rtlsupport','','0');
									$yearselection = PFSFIssetControl('setupsearchfields_'.$slug.'_yearselection','','0');
									$date_field_rtl = (empty($general_rtlsupport))? 'false':'true';
									$date_field_ys = (empty($yearselection))?'false':'true';

									switch ($setup4_membersettings_dateformat) {
										case '1':$date_field_format = 'dd/mm/yy';break;
										case '2':$date_field_format = 'mm/dd/yy';break;
										case '3':$date_field_format = 'yy/mm/dd';break;
										case '4':$date_field_format = 'yy/dd/mm';break;
										default:$date_field_format = 'dd/mm/yy';break;
									}

									$yearrange1 = PFSFIssetControl('setupsearchfields_'.$slug.'_yearrange1','','2000');
									$yearrange2 = PFSFIssetControl('setupsearchfields_'.$slug.'_yearrange2','',date("Y"));

									if (!empty($yearrange1) && !empty($yearrange2)) {
										$yearrangesetting = 'yearRange:"'.$yearrange1.':'.$yearrange2.'",';
									}elseif (!empty($yearrange1) && empty($yearrange2)) {
										$yearrangesetting = 'yearRange:"'.$yearrange1.':'.date("Y").'",';
									}else{
										$yearrangesetting = '';
									}

									$this->FieldOutput .= "
									<script>
									(function($) {
										'use strict';
										$(function(){
											$( '#".$slug."' ).datepicker({
										      changeMonth: $date_field_ys,
										      changeYear: $date_field_ys,
										      isRTL: $date_field_rtl,
										      dateFormat: '$date_field_format',
										      firstDay: $setup3_modulessetup_openinghours_ex2,/* 0 Sunday 1 monday*/
										      $yearrangesetting
										      prevText: '',
										      nextText: '',
										      beforeShow: function(input, inst) {
											       $('#ui-datepicker-div').addClass('pointfinder-map-datepicker');
											   }
										    });
										});
									})(jQuery);
									</script>
						            ";

									if($column_type == 1){
										if ($this->PFHalf % 2 == 0) {
											$this->FieldOutput .= '</div>';
										}else{
											if (($hormode == 1 && $widget == 0 && $target != 'google') || ($hormode == 1 && $widget == 1 && $minisearch == 1)) {
												$this->FieldOutput .= '</div>';
											}
											$this->FieldOutput .= '</div></div>';
										}
									}else{
										if (($hormode == 1 && $widget == 0) || ($hormode == 1 && $widget == 1 && $minisearch == 1)) {
											$this->FieldOutput .= '</div>';
										}
									};
									
									
								}
							}
							break;

						case '6':
						/* check Box */
							if ($showonlywidget_check == 'show') {
								$target = PFSFIssetControl('setupsearchfields_'.$slug.'_rvalues_target_target','','');

								$itemparent = $this->CheckItemsParent($target);

								if($itemparent == 'none'){
									$validation_check = PFSFIssetControl('setupsearchfields_'.$slug.'_validation_required','','0');
									if($validation_check == 1){
										$validation_message = PFSFIssetControl('setupsearchfields_'.$slug.'_message','','');
										if($this->VSOMessages != ''){
											$this->VSOMessages .= ','.$slug.':"'.$validation_message.'"';
										}else{
											$this->VSOMessages = $slug.':"'.$validation_message.'"';
										}
										
										if($this->VSORules != ''){
											$this->VSORules .= ','.$slug.':"required"';
										}else{
											$this->VSORules = $slug.':"required"';
										}
									}
									
									if ($hormode == 1 && $widget == 0) {
										$this->FieldOutput .= '<div class="col-lg-3 col-md-4 col-sm-4 colhorsearch">';
									}
									
									$this->FieldOutput .= '<div id="'.$slug.'_main">';
									
									$fieldtext = PFSFIssetControl('setupsearchfields_'.$slug.'_fieldtext','','');
									$this->FieldOutput .= '<div class="pftitlefield">'.$fieldtext.'</div>';
									//$this->FieldOutput .= '<label for="'.$slug.'" class="lbl-ui checkbox">';
									$this->FieldOutput .= '<div class="option-group">';

									$rvalues = PFSFIssetControl('setupsearchfields_'.$slug.'_rvalues','','');

									if(count($rvalues) > 0){$fieldvalues = $rvalues;}else{$fieldvalues = '';}

									if(count($fieldvalues) > 0){
										
										$ikk = 0;
										$widget_checkbox = '';
										if ($widget != 0) {
											$widget_checkbox = '[]';
										}

										foreach ($fieldvalues as $s) { 

											if (function_exists('icl_t')) {
												$s = icl_t('admin_texts_pfsearchfields_options', '[pfsearchfields_options][setupsearchfields_'.$slug.'_rvalues]'.$ikk, $s);
											}

											if ($pos = strpos($s, '=')) { 

												$this->FieldOutput .= '<span class="goption">';
				   								$this->FieldOutput .= '<label class="options">';


												$checkbox_output = '<input type="checkbox" name="'.$slug.$widget_checkbox.'" value="'.trim(substr($s, 0, $pos)).'" /><span class="checkbox"></span></label><label for="'.$slug.'">'.trim(substr($s, $pos + strlen('='))).'</label>';

												if (array_key_exists($slug,$pfgetdata)) {
													if (isset($pfgetdata[$slug])) {
														if (is_array($pfgetdata[$slug])) {
															if (in_array(trim(substr($s, 0, $pos)), $pfgetdata[$slug])) {
																$checkbox_output = '<input type="checkbox" name="'.$slug.$widget_checkbox.'" value="'.trim(substr($s, 0, $pos)).'" checked /><span class="checkbox"></span></label><label for="'.$slug.'">'.trim(substr($s, $pos + strlen('='))).'</label>';
															}
														}else{
															if (trim(substr($s, 0, $pos)) == $pfgetdata[$slug]) {
																$checkbox_output = '<input type="checkbox" name="'.$slug.$widget_checkbox.'" value="'.trim(substr($s, 0, $pos)).'" checked /><span class="checkbox"></span></label><label for="'.$slug.'">'.trim(substr($s, $pos + strlen('='))).'</label>';
															}
														}
													}
												}

												$this->FieldOutput .= $checkbox_output;

												
											}
											$this->FieldOutput .= '</span>';
											$ikk++;
										}
									}

									$this->FieldOutput .= '</div>';
									
									
									if (($hormode == 1 && $widget == 0)) {
										$this->FieldOutput .= '</div>';
									}
									$this->FieldOutput .= '</div>';
									

									
								}/*Parent Check*/
							}
							break;
					}
					
					
		}

				
	}
}
?>
