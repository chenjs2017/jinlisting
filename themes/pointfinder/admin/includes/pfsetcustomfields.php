<?php
/**********************************************************************************************************************************
*
* Custom Detail Fields Class
* This class prepared for help to create auto config file.
* Author: Webbu Design
*
***********************************************************************************************************************************/
if ( ! class_exists( 'PFGetFields' ) ){
	class PFGetFields{
			
			public $CDFoutput;
			public $GFoutput;
			
			function pf_py_slice($input, $slice) {
					$arg = explode(':', $slice);
					$start = intval($arg[0]);
					if ($start < 0) {
						$start += strlen($input);
					}
					if (count($arg) === 1) {
						return substr($input, $start, 1);
					}
					if (trim($arg[1]) === '') {
						return substr($input, $start);
					}
					$end = intval($arg[1]);
					if ($end < 0) {
						$end += strlen($input);
					}
					return substr($input, $start, $end - $start);
			}
			
			function GF($params = array()){

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
				if(empty($fdata['options'])){$fdata['options'] = array('0' => esc_html__('Hide', 'pointfindert2d'),'1' => esc_html__('Show', 'pointfindert2d'));};
						
				switch($ftype){
					case 'info':
						$this->GFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => 'info',
							'notice' => $fdata['notice'],
							'style' => $fdata['style'],
							'desc' => $fdesc
						);
						break;
						
					case 'textarea':
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

						if($fdata['required'] != ''){

							$field_output_arr['required'] = array($fdata['required'], $fdata['condition'], $fdata['required_condition_text']);

						}

						if($fdata['on'] != ''){	
							$field_output_arr['on'] = $fdata['on'];
							$field_output_arr['off'] = $fdata['off'];
						}

						$this->GFoutput = $field_output_arr;
						break;
					case 'button_set':
						$field_output_arr = array(
							'id' => $fid,
							'title' => $ftitle,
							'type' => $ftype,
							'hint' => array('content' => $fdesc),
							'default' => $fdata['default'],
							'options' => $fdata['options']
						);

						if($fdata['required'] != ''){

							$field_output_arr['required'] = array($fdata['required'], $fdata['condition'], $fdata['required_condition_text']);
						}

						$this->GFoutput = $field_output_arr;
						break;
					
					case 'indentstart':
						$this->GFoutput = array(
								'id' => 'section-'.$fid.'-start',
								'type' => 'section',
								'indent' => true 
							);
						break;
					
					case 'indentend':
						$this->GFoutput = array(
								'id' => 'section-'.$fid.'-end',
								'type' => 'section',
								'indent' => false 
							);
						break;
						
					case 'selectparent': 
							
						$this->GFoutput = array(
							'id' => $fid,
							'title' => $ftitle,
							'data' => 'terms',
							'args' => array('taxonomies'=>'pointfinderltypes', 'hide_empty'=>0, 'args'=>array()),
							'type' => 'select',
							'multi' => true,
							'desc' => $fdesc
						);
						
						break;
					
							
				}
				
				return $this->GFoutput;
			
			}
			
			function PFGetDefaultFieldValuesofThis($slug,$field,$exclude=0){
				
				switch($field){

					case 'defaults':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_parent',
								'ftitle' =>	esc_html__('Listing Type Relation','pointfindert2d'),
								'ftype' => 'selectparent',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Show this field only in selected listing types.','pointfindert2d').'<br>'.esc_html__('This option is required for infowindow, item list, search window and item detail information. If you do not select any listing type, this field will be available for all listing types.','pointfindert2d')
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_defaultvalue',
								'ftitle' =>	esc_html__('Default Value','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Default value to see on backend add new item page.','pointfindert2d')
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_description',
								'ftitle' =>	esc_html__('Description (Backend)','pointfindert2d'),
								'ftype' => 'textarea',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Add new item page description for this field.','pointfindert2d')
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_sitempage',
								'ftitle' =>	esc_html__('Item Details Page','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the item details page?','pointfindert2d'),
								'fdata' => array('default'=>1, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							),
							
							array(
								'fid' => 'setupcustomfields_'.$slug.'_sinfowindow_hidename',
								'ftitle' =>	esc_html__('Field Title','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field title in the front end pages?','pointfindert2d'),
								'fdata' => array('default'=>1, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							)
						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							
							if(!($single_arr['fid'] == 'setupcustomfields_'.$slug.'_defaultvalue' && $exclude == 9)){
								$this_field_arr_output[] = $this->GF($single_arr);
							}
						}
						return $this_field_arr_output;
						break;

					case 'extra':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_sinfowindow',
								'ftitle' =>	esc_html__('Info Window','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the info window?','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_linfowindow',
								'ftitle' =>	esc_html__('Grid List Items','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the grid list items?','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_shortname',
								'ftitle' =>	esc_html__('Field Title Short Name','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('This field\'s short title name.','pointfindert2d'),
							),
							
							array(
								'fid' => 'setupcustomfields_'.$slug.'_sortoption',
								'ftitle' =>	esc_html__('Sort by (Select Box)','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the SORT BY select box?','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_sortname',
								'ftitle' =>	esc_html__('Sort by Title (Select Box)','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Short field name for SORT BY listing box.','pointfindert2d'),
								'fdata' => array('required'=>'setupcustomfields_'.$slug.'_sortoption')
							)

						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;

					case 'currency':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_currency_check',
								'ftitle' =>	esc_html__('Currency Options','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Please enable and set options if this field is a currency field.','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_currency_check',
								'ftype' => 'indentstart',
							),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_currency_prefix',
									'ftitle' =>	esc_html__('Prefix','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Prefix for currency. Ex: $','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_currency_check')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_currency_suffix',
									'ftitle' =>	esc_html__('Suffix','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Suffix for currency. Ex: $','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_currency_check')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_currency_decima',
									'ftitle' =>	esc_html__('Decimals','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Decimals. Ex: 0','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_currency_check','default'=>0)
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_currency_decimp',
									'ftitle' =>	esc_html__('Decimal Point','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Decimal point. Ex: .','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_currency_check','default'=>'.')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_currency_decimt',
									'ftitle' =>	esc_html__('Thousands Separator','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Thousands separator. Ex: ,','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_currency_check','default'=>',')
								),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_currency_check',
								'ftype' => 'indentend',
							),

						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;

					case 'size':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_size_check',
								'ftitle' =>	esc_html__('Size (Area) Options','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Please enable and set options if this field is a size field.','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_size_check',
								'ftype' => 'indentstart',
							),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_size_prefix',
									'ftitle' =>	esc_html__('Prefix','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Prefix for size. Ex: sqm','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_size_check')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_size_suffix',
									'ftitle' =>	esc_html__('Suffix','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Suffix for currency. Ex: sqm','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_size_check')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_size_decimp',
									'ftitle' =>	esc_html__('Decimal Point','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Decimal point. Ex: .','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_size_check','default'=>'.')
								),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_size_check',
								'ftype' => 'indentend',
							),

						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;

					case 'year':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_yearrange1',
								'ftitle' =>	esc_html__('Start Year','pointfindert2d'),
								'ftype' => 'text'
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_yearrange2',
								'ftitle' =>	esc_html__('End Year','pointfindert2d'),
								'ftype' => 'text'
							)

						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;

					case 'textff':

						$this_field_arr = 
						array(array(
							'fid' => 'setupcustomfields_'.$slug.'_linkoption',
							'ftitle' =>	esc_html__('Link Option','pointfindert2d'),
							'ftype' => 'button_set',
							'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Is this field value a link?','pointfindert2d'),
							'fdata' => array(
								'default'=>0, 
								'required'=>'setupcustomfields_'.$slug.'_sitempage',
								'options'=> array(
									'0' => esc_html__('Not', 'pointfindert2d'),
									'1' => esc_html__('Web Link', 'pointfindert2d'),
									'2' => esc_html__('Mail Link', 'pointfindert2d'),
									'3' => esc_html__('Tel Link', 'pointfindert2d')
								)
							)

						));

						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;
						
					case 'frontend':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_frontupload',
								'ftitle' =>	esc_html__('Submit New Item: Option','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the submit new item form?','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_frontupload',
								'ftype' => 'indentstart',
							),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_fwr',
									'ftitle' =>	esc_html__('Full Width Field','pointfindert2d'),
									'ftype' => 'button_set',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the full width?','pointfindert2d'),
									'fdata' => array(
										'default'=> 0, 
										'options'=> array(
												'0' => esc_html__('1/3 Width', 'pointfindert2d'),
												'1' => esc_html__('Full Width', 'pointfindert2d'),
												'2' => esc_html__('1/2 Width', 'pointfindert2d'),
											),
										'required'=>'setupcustomfields_'.$slug.'_frontupload'
										)
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_frontendname',
									'ftitle' =>	esc_html__('Submit New Item: Name','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Field name to show Submit New Item form.','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_frontupload')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_descriptionfront',
									'ftitle' =>	esc_html__('Submit New Item: Tooltip','pointfindert2d'),
									'ftype' => 'textarea',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Tooltip to show Submit New Item form.','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_frontupload')
								),	
								array(
									'fid' => 'setupcustomfields_'.$slug.'_validation_required',
									'ftitle' =>	esc_html__('Submit New Item: Validation','pointfindert2d'),
									'ftype' => 'switch',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to validate this field?','pointfindert2d'),
									'fdata' => array('default'=>0, 'on'=>esc_html__('Enable','pointfindert2d'),'off'=>esc_html__('Disable','pointfindert2d'),'required'=>'setupcustomfields_'.$slug.'_frontupload')
								),
								array(
									'fid' => 'setupcustomfields_'.$slug.'_message',
									'ftitle' =>	esc_html__('Validation Error Msg','pointfindert2d'),
									'ftype' => 'text',
									'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Custom error message to be seen when field is not valid.','pointfindert2d'),
									'fdata' => array('required'=>'setupcustomfields_'.$slug.'_validation_required')
								),
								
							array(
								'fid' => 'setupcustomfields_'.$slug.'_frontupload',
								'ftype' => 'indentend',
							),

						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							if($exclude == 9 || $exclude == 7){
								if($single_arr['fid'] != 'setupcustomfields_'.$slug.'_validation_required' && $single_arr['fid'] != 'setupcustomfields_'.$slug.'_column'){
									$this_field_arr_output[] = $this->GF($single_arr);
								}
							}elseif($exclude == 14){
								if($single_arr['fid'] != 'setupcustomfields_'.$slug.'_validation_required'){
									$this_field_arr_output[] = $this->GF($single_arr);
								}
							}else{
								$this_field_arr_output[] = $this->GF($single_arr);
							}
						}
						return $this_field_arr_output;
						break;

					case 'rvalues':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_rvalues',
								'ftitle' =>	esc_html__('Values','pointfindert2d'),
								'ftype' => 'multi_text',
								'fdesc' => esc_html__('Please enter values like this: value=Title Ex: 1=1 Bedroom','pointfindert2d')
							)
						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;

					case 'rvalues2':
						$this_field_arr = 
						array(
							array(
								'fid' => 'setupcustomfields_'.$slug.'_linfowindow',
								'ftitle' =>	esc_html__('Grid List Items','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the grid list items?','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_sinfowindow',
								'ftitle' =>	esc_html__('Info Window','pointfindert2d'),
								'ftype' => 'switch',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('Do you want to show this field in the info window?','pointfindert2d'),
								'fdata' => array('default'=>0, 'on'=>esc_html__('Show','pointfindert2d'),'off'=>esc_html__('Hide','pointfindert2d'))
							),
							array(
								'fid' => 'setupcustomfields_'.$slug.'_shortname',
								'ftitle' =>	esc_html__('Field Title Short Name','pointfindert2d'),
								'ftype' => 'text',
								'fdesc' => '<strong>'.esc_html__('OPTIONAL : ','pointfindert2d').'</strong>'.esc_html__('This field\'s short title name.','pointfindert2d'),
							),
						);
						$this_field_arr_output = array();
						foreach ($this_field_arr as $single_arr) {
							$this_field_arr_output[] = $this->GF($single_arr);
						}
						return $this_field_arr_output;
						break;
						
				}
			}

			function CDF($title, $slug, $field){
				
				if($slug != '' && $field != '' && $title != ''){
					
					$this->CDFoutput = array(
						'id' => 'setupcustomfields_'.$slug.'',
						'title' => sprintf(esc_html__('%s Field','pointfindert2d'),$title),
						'subsection' => true,
						'fields' => array()
					);

					
					$getfields = $this->PFGetDefaultFieldValuesofThis($slug,'defaults',$field);
					
					

					switch($field){
						case '15'://Date Field
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'year');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}

							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							
							break;
						case '5'://TextArea Field
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
						case '1'://Text Field
						case '2'://URL Field
						case '3'://Email Field
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'textff');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'extra');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}

							break;
						case '4'://Number
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'extra');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'currency');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'size');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
						case '9'://Checkbox Field
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend',$field);
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
						case '8'://Select Box
						case '14'://Select Box Multiple
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues2');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend',$field);
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
						case '7'://Radio Button
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'rvalues');
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							$multiple_val = $this->PFGetDefaultFieldValuesofThis($slug,'frontend',$field);
							foreach ($multiple_val as $single_arr) {
								array_push($getfields, $single_arr);
							}
							break;
						
					}
					$this->CDFoutput['fields'] = $getfields;
					
				}
				
				return $this->CDFoutput;
			}
	}
}
?>