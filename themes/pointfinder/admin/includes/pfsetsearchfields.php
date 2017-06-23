<?php
/**********************************************************************************************************************************
*
* Search Fields Class
* This class prepared for help to create auto config file.
* Author: Webbu Design
*
***********************************************************************************************************************************/
if ( ! class_exists( 'PFGetSFields' ) ){
	class PFGetSFields{
			
			public $SDFoutput;
			public $GFoutput;
			
			
			function GSF($params = array()){
				
				$defaults = array( 
			        'fid' => '',
			        'ftitle' => '',
			        'fdesc' => '',
			        'ftype' => '',
			        'fdata' => array()
			    );

			    $params = array_merge($defaults, $params);

			    $fdata = $params['fdata'];
			    $fid = $params['fid'];
			    $ftitle = $params['ftitle'];
			    $fdesc = $params['fdesc'];
			    $ftype = $params['ftype'];


			    //Defaults
				if(empty($fdata['required'])){$fdata['required'] = '';};
				if(!isset($fdata['default'])){$fdata['default'] = '';};
				if(empty($fdata['notice'])){$fdata['notice'] = '';};
				if(empty($fdata['style'])){$fdata['style'] = '';};
				if(empty($fdata['on'])){$fdata['on'] = '';};
				if(empty($fdata['off'])){$fdata['off'] = '';};
				if(empty($fdata['condition'])){$fdata['condition'] = '=';};
				if(!isset($fdata['required_condition_text'])){$fdata['required_condition_text'] = '1';};


				
				if(empty($fdata['validate'])){$fdata['validate'] = '';};
				if(empty($fdata['on'])){$fdata['on'] = '';};
				if(empty($fdata['off'])){$fdata['off'] = '';};
				
				switch($ftype){
					case 'selectt':
					case 'selectt2':
					case 'selectt3':
						global $pointfindertheme_option;
						//$pointfindertheme_option = get_option('pointfindertheme_options');
							
							$selectableptypes = array();
							
							$pfstart = PFCheckStatusofVar('setup1_slides');
							
							if(!$pfstart){
								$selectableptypes['0'] = esc_html__('There is no custom field.','pointfindert2d');
							}else{
								
								foreach ($pointfindertheme_option['setup1_slides'] as &$value) {
								
									if($value['select'] != 10 && $value['select'] != 16){
										
										$selectableptypes[$value['url']] = $value['title'];
									}
									
								}
		
							}
							break;
				
				}


				switch($ftype){	
					case 'button_set':
						$this->GSFoutput = array(
	                        'id' => $fid,
							'title' => $ftitle,
	                        'type' => 'button_set',
	                        'hint' => array('content' => $fdesc),
	                        'options'   => array(
	                            'min' => esc_html__('Min Slider','pointfindert2d'), 
	                            'max' => esc_html__('Max Slider','pointfindert2d'),
								'range' => esc_html__('Range Slider','pointfindert2d'),
	                        ), 
	                        'default'   => 'min'
	                    );
						break;
					case 'info':
						$this->GSFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'info',
							'notice' => $fdata['notice'],
							'style' => $fdata['style'],
							'desc' => $fdesc
						);
						break;
					case 'color':
						$this->GSFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'color',
							'hint' => array('content' => $fdesc),
							'transparent' => false,
							'mode' => 'background-color',
							'default' => $fdata['default'],
							'compiler'   => $fdata['output'],
							'validate' => 'color'
						);
						break;
					case 'switch':
					case 'multi_text':
					case 'text':
						$field_output_arr = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => $ftype,
							'hint' => (!empty($fdesc))?array('content' => $fdesc):'',
							'default' => $fdata['default']
						);	

						if($fdata['on'] != ''){	
							$field_output_arr['on'] = $fdata['on'];
							$field_output_arr['off'] = $fdata['off'];
						}
						if($fdata['required'] != ''){
							$field_output_arr['required'] = array($fdata['required'], $fdata['condition'], $fdata['required_condition_text']);
						}
						if($fdata['validate'] != ''){
							$field_output_arr['validate'] = $fdata['validate'];	
						}

						$this->GSFoutput = $field_output_arr;

						
						break;

					case 'selectp':
					
						/* Post Type Taxonomy Selection*/
						$setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4','','Item Types');
						$setup3_pointposttype_pt5 = PFSAIssetControl('setup3_pointposttype_pt5','','Locations');
						$setup3_pointposttype_pt6 = PFSAIssetControl('setup3_pointposttype_pt6','','Features');
						$setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
						$setup3_pt14 = PFSAIssetControl('setup3_pt14','','Conditions');
						
						$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
						$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
						$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');
						$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','','1');

						$selectableptypes = array();
						
						$selectableptypes['pointfinderltypes'] = $setup3_pointposttype_pt7;
						
						if($setup3_pointposttype_pt4_check == 1){$selectableptypes['pointfinderitypes'] = $setup3_pointposttype_pt4;};
						if($setup3_pointposttype_pt5_check == 1){$selectableptypes['pointfinderlocations'] = $setup3_pointposttype_pt5;};
						if($setup3_pointposttype_pt6_check == 1){$selectableptypes['pointfinderfeatures'] = $setup3_pointposttype_pt6;};
						$selectableptypes['post_tag'] = esc_html__("Tags","pointfindert2d");
						if($setup3_pt14_check == 1){$selectableptypes['pointfinderconditions'] = $setup3_pt14;};
						
						$this->GSFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'select',
							'hint' => array('content' => $fdesc),
							'options' => $selectableptypes,
						);
						break;
					
					
					case 'selectt2': //Target for select box for select box
						$field_output_arr = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'select',
							'hint' => array('content' => $fdesc),
							'options' => $selectableptypes,
						);
						if($fdata['required'] != ''){
							$field_output_arr['required'] = array($fdata['required'], $fdata['condition'], $fdata['required_condition_text']);
						}
						$this->GSFoutput = $field_output_arr;
						break;
						
					
					
					case 'selectt3': //Target for select box for text field
					
						$selectableptypes['title'] = esc_html__('Title of the item','pointfindert2d');
					    $selectableptypes['description'] = esc_html__('Content(Desc.) of the item','pointfindert2d');
						$selectableptypes['address'] = esc_html__('Address field of the item','pointfindert2d');
						$selectableptypes['google'] = esc_html__('Google Places API','pointfindert2d');

						$selectableptypes['post_tags'] = esc_html__('Post Tags','pointfindert2d');
						

						$this->GSFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'select',
							'hint' => array('content' => $fdesc),
							'options' => $selectableptypes,
						);
						
						break;
					
						
					case 'selectac': //Target and field search operator
						
						$field_output_arr = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'select',
							'hint' => array('content' => $fdesc),
							'options' => array('='=>esc_html__('Equals(=)','pointfindert2d'),'>'=>esc_html__('Greater than(>)','pointfindert2d'),'<'=>esc_html__('Smaller than(<)','pointfindert2d'),'>='=>esc_html__('Greater than or Equal(=>)','pointfindert2d'),'<='=>esc_html__('Smaller than or Equal(<=)','pointfindert2d'))
						);

						if($fdata['required'] != ''){
							$field_output_arr['required'] = array($fdata['required'], $fdata['condition'], $fdata['required_condition_text']);
						}
						$this->GSFoutput = $field_output_arr;

						break;
						
					
					case 'textnumeric':
						$this->GSFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'text',
							'hint' => array('content' => $fdesc),
							'default' => $fdata['default'],
							'class' => 'text',
							'validate' => 'numeric',
							'default' => $fdata['default']
						);
						break;

					case 'indentstart':
						$this->GSFoutput = array(
								'id' => $fid,
								'type' => 'section',
								'indent' => true 
							);
						break;
					
					case 'indentend':
						$this->GSFoutput = array(
								'id' => $fid,
								'type' => 'section',
								'indent' => false 
							);
						break;
							
				}
				
				return $this->GSFoutput;
			
			}
			

			function PFGetDefaultFieldValuesofThis($slug,$field,$exclude=0){
				
				switch($field){

					case 'indentstart':
						$this_field_arr = array(
							'fid' => 'setupcustomfields_'.$slug.'ind'.$exclude.'-start',
							'ftype' => 'indentstart',
						);
						return $this->GSF($this_field_arr);
						break;

					case 'indentend':
						$this_field_arr = array(
							'fid' => 'setupcustomfields_'.$slug.'ind'.$exclude.'-end',
							'ftype' => 'indentend',
						);
						return $this->GSF($this_field_arr);
						break;

					case 'fieldtext':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_fieldtext',
								'ftitle' =>	esc_html__('Field Text','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Field text for this slider value. Ex: Price range','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;
							
					case 'defaultvalue':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_defaultvalue',
								'ftitle' => '<strong>'.esc_html__('IMPORTANT : ','pointfindert2d').'</strong>',
								'ftype' => 'info',
								'fdesc' => esc_html__('Please only choose one filter. Like "Post Taxonomy Filter" or "Custom Select Box Filter". If you choose more than one filter then "Custom Select Box Filter" will work.','pointfindert2d'),
								'fdata' =>  array('style'=>'critical', 'notice'=>'true')
						);
						
						return $this->GSF($this_field_arr);
						break;

					case 'placeholder':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_placeholder',
								'ftitle' => esc_html__('Placeholder Text','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('You can set a placeholder text for this field.','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'posttax':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_posttax',
								'ftitle' => esc_html__('Post Taxonomy Filter','pointfindert2d'),
								'ftype' => 'selectp',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Please select a post type taxonomy for filter.','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'showonlytop':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_parentso',
								'ftitle' => esc_html__('Show Only Parent Taxonomies','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If it is enabled, Post Taxonomy List only show parent taxonomies.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'),'required'=>'setupsearchfields_'.$slug.'_rvalues_check', 'condition' => '=', 'required_condition_text' => '0')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'ajaxloads':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_ajaxloads',
								'ftitle' => esc_html__('Ajax Load for Listing Type & Location','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If it is enabled, Post Taxonomy List will show only parent taxonomies and load sub categories with ajax. This function does not work with mini search. THIS FEATURE ONLY WORKING WITH LISTING TYPES AND LOCATIONS','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'),'required'=>'setupsearchfields_'.$slug.'_rvalues_check', 'condition' => '=', 'required_condition_text' => '0')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'posttax_selected':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_posttax_selected',
								'ftitle' => esc_html__('Selected Value','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Please write option value for default selected item. (Tip: You can get this number from taxonomy field edit page.)','pointfindert2d'),
								'fdata' =>  array('required'=>'setupsearchfields_'.$slug.'_posttax', 'condition' => 'not_empty_and', 'required_condition_text' => '', 'validate'=>'number')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'posttax_move':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_posttax_move',
								'ftitle' => esc_html__('Move Map On Select','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Enable moving map when selected a list item from the list. This setting will enable ajax move map on selected option. And only working with Location taxonomy.','pointfindert2d'),
								'fdata' => array('required'=>'setupsearchfields_'.$slug.'_posttax', 'condition' => '=', 'required_condition_text' => 'pointfinderlocations','on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'rvalues_check':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_rvalues_check',
								'ftitle' => esc_html__('Custom Select Box Filter','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If it is enabled, you can put custom select box values into this field and Post Taxonomy Filter will be disabled by system.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					

					case 'rvalues1':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_rvalues',
								'ftitle' => esc_html__('Custom Values','pointfindert2d'),
								'ftype' => 'multi_text',
								'fdesc' => esc_html__('Please enter values like this: value=Title Ex: 1=1 Bedroom','pointfindert2d'),
								'fdata' => array('required'=>'setupsearchfields_'.$slug.'_rvalues_check')			
						);
						return $this->GSF($this_field_arr);
						break;

					case 'rvalues2':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_rvalues',
								'ftitle' => esc_html__('Custom Values','pointfindert2d'),
								'ftype' => 'multi_text',
								'fdesc' => esc_html__('Please enter values like this: value=Title Ex: 1=1 Bedroom','pointfindert2d')						);
						return $this->GSF($this_field_arr);
						break;

					case 'rvalues_target_target':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_rvalues_target_target',
								'ftitle' => esc_html__('Target Field','pointfindert2d'),
								'ftype' => 'selectt2',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please select a target field for this field. ','pointfindert2d'),
								'fdata' => array('required'=>'setupsearchfields_'.$slug.'_rvalues_check')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'rvalues_target_according':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_rvalues_target_according',
								'ftitle' => esc_html__('Condition','pointfindert2d'),
								'ftype' => 'selectac',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please select a search condition between this search filter and target ','pointfindert2d'),
								'fdata' => array('required'=>'setupsearchfields_'.$slug.'_rvalues_check')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'validation_required':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_validation_required',
								'ftitle' => esc_html__('Validation','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If you want to validate this option please enable.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'message':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_message',
								'ftitle' => esc_html__('Validation Error Msg','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Custom error message to be seen when field is not valid.','pointfindert2d'),
								'fdata' => array('required'=>'setupsearchfields_'.$slug.'_validation_required')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'multiple': /*pointfinderltypes*/
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_multiple',
								'ftitle' => esc_html__('Multiple Selection','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If it is enabled, you can use multiple selection on this select box.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'),'required'=>'setupsearchfields_'.$slug.'_posttax', 'condition' => '!=', 'required_condition_text' => 'pointfinderltypes')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'select2':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_select2',
								'ftitle' => esc_html__('Select Box Inner Search','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If it is enabled, you can search texts in select box field.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'nomatch':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_nomatch',
								'ftitle' => esc_html__('Select Box Inner Search: No Matches Text','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('You can set a no matches found text for this select box inner search.','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'column':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_column',
								'ftitle' => esc_html__('Field Half Column','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('Do you want to show this field column %50 width?','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Yes','pointfindert2d'),'off'=>esc_html__('No','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'geolocfield':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_geolocfield',
								'ftitle' => esc_html__('Radius Unit','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('Please select radius unit. This option only for Google Places API','pointfindert2d'),
								'fdata' => array('default'=>1,'on'=>esc_html__('Mile','pointfindert2d'),'off'=>esc_html__('Km','pointfindert2d'),'required'=>'setupsearchfields_'.$slug.'_target_target','condition'=> '=', 'required_condition_text' => 'google')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'geolocfield2':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_geolocfield2',
								'ftitle' => esc_html__('Radius Max','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => esc_html__('Max radius size number. This option only for Google Places API','pointfindert2d'),
								'fdata' => array('default'=>100,'required'=>'setupsearchfields_'.$slug.'_target_target','condition'=> '=', 'required_condition_text' => 'google')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'showonlywidget':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_showonlywidget',
								'ftitle' => esc_html__('Show Only Widget Search','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If you want to show this field only on widget search then enable.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'minisearch':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_minisearch',
								'ftitle' => esc_html__('Mini Search','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If you want to show this field into the mini search.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'minisearchso':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_minisearchso',
								'ftitle' => esc_html__('Show Only Mini Search','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If you want to show this field only into the mini search.','pointfindert2d'),
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'),'required'=>'setupsearchfields_'.$slug.'_minisearch', 'condition' => '=', 'required_condition_text' => '1')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'yearselection':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_yearselection',
								'ftitle' => esc_html__('Month & Year Selection','pointfindert2d'),
								'ftype' => 'switch',
								'fdata' => array('default'=>0,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'yearrange1':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_yearrange1',
								'ftitle' => esc_html__('Start Year','pointfindert2d'),
								'ftype' => 'text'
						);
						return $this->GSF($this_field_arr);
						break;

					case 'yearrange2':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_yearrange2',
								'ftitle' => esc_html__('End Year','pointfindert2d'),
								'ftype' => 'text'
						);
						return $this->GSF($this_field_arr);
						break;



					/*
					* Added on v1.0.6
					* Auto complete feature for title and address.
					*/
					case 'autocmplete':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_autocmplete',
								'ftitle' => esc_html__('Ajax Auto Complete','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => esc_html__('If want to use autocomplete for title, address and taxonomies then enable.','pointfindert2d'),
								'fdata' => array('default'=>1,'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'),'required'=>'setupsearchfields_'.$slug.'_target_target','condition'=> '!=', 'required_condition_text' => array('google'))
						);
						return $this->GSF($this_field_arr);
						break;


					case 'type':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_type',
								'ftitle' => esc_html__('Slider Type','pointfindert2d'),
								'ftype' => 'button_set',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please select a slider type. ','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'target':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_target',
								'ftitle' => esc_html__('Target Field','pointfindert2d'),
								'ftype' => 'selectt2',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please select a target field for this field. ','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'target_according':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_target_according',
								'ftitle' => esc_html__('Condition','pointfindert2d'),
								'ftype' => 'selectac',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please select a search condition between this search filter and target ','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;

					case 'min':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_min',
								'ftitle' => esc_html__('Min Value','pointfindert2d'),
								'ftype' => 'textnumeric',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please write minimum number.Default:0','pointfindert2d'),
								'fdata' => array('default'=>0)
						);
						return $this->GSF($this_field_arr);
						break;

					case 'max':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_max',
								'ftitle' => esc_html__('Max Value','pointfindert2d'),
								'ftype' => 'textnumeric',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please write maximum number.','pointfindert2d'),
								'fdata' => array('default'=>1000000)
						);
						return $this->GSF($this_field_arr);
						break;

					case 'steps':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_steps',
								'ftitle' => esc_html__('Steps','pointfindert2d'),
								'ftype' => 'textnumeric',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please write number of steps. Default:1','pointfindert2d'),
								'fdata' => array('default'=>1)
						);
						return $this->GSF($this_field_arr);
						break;

					case 'colorslider':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_colorslider',
								'ftitle' => esc_html__('Range Area Color','pointfindert2d'),
								'ftype' => 'color',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('color for range area.','pointfindert2d'),
								'fdata' => array('default'=>'#3D637C', 'output'=>array('.ui-slider-'.$slug.' > .ui-slider-range'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'colorslider2':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_colorslider2',
								'ftitle' => esc_html__('Range Point Color','pointfindert2d'),
								'ftype' => 'color',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('color for range area sliding point outside.','pointfindert2d'),
								'fdata' => array('default'=>'#444444', 'output'=>array('.ui-slider-'.$slug.' > .ui-slider-handle'))
						);
						return $this->GSF($this_field_arr);
						break;

					case 'target_target':
						$this_field_arr = array(
								'fid' => 'setupsearchfields_'.$slug.'_target_target',
								'ftitle' => esc_html__('Target Field','pointfindert2d'),
								'ftype' => 'selectt3',
								'fdesc' => '<strong>'.esc_html__('REQUIRED : ','pointfindert2d').'</strong>'.esc_html__('Please select a target field for this field. ','pointfindert2d')
						);
						return $this->GSF($this_field_arr);
						break;
						
				}
			}





			function SDF($title, $slug, $field){
				
				if($slug != '' && $field != '' && $title != ''){
					
					$this->SDFoutput = array(
						'id' => 'setupsearchfields_'.$slug.'',
						'title' => ''.$title.' '.esc_html__('Field','pointfindert2d').'',
						'subsection' => true,
						'fields' => array ()
					);

					
					$multiple_val = $getfields = array();
					switch($field){
						case '1':
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'fieldtext');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'defaultvalue');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'placeholder');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'posttax');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'showonlytop');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'ajaxloads');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'posttax_selected');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'posttax_move');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues_check');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues1');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues_target_target');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues_target_according');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'validation_required');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'message');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'multiple');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'select2');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'nomatch');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'column');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'showonlywidget');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearch');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearchso');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
							
						
						case '2':
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'fieldtext');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'type');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'target');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'target_according');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'min');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'max');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'steps');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'colorslider');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'colorslider2');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'column');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'showonlywidget');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearch');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearchso');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
							
							
						case '4'://Text Field
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'fieldtext');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'target_target');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'geolocfield');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'geolocfield2');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'placeholder');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'validation_required');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'message');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'column');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'autocmplete');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'showonlywidget');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearch');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearchso');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;

						case '5'://Date Field
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'fieldtext');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'target');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'target_according');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'placeholder');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'validation_required');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'message');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'column');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'showonlywidget');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearch');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'minisearchso');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'yearselection');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'yearrange1');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'yearrange2');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;

						case '6':
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'fieldtext');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues2');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'target');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'validation_required');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'message');
							$multiple_val[] = $this->PFGetDefaultFieldValuesofThis($slug,'showonlywidget');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
						
					}

					

					/*
					$debug_data = $getfields;
					wp_die(str_replace(array('&lt;?php&nbsp;','?&gt;'), '', highlight_string( '<?php ' .     var_export($debug_data, true) . ' ?>', true ) ));
					*/

					$this->SDFoutput['fields'] = $getfields;
					
				}
				
				return $this->SDFoutput;
			}
	}
}
?>