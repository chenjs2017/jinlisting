<?php
/**********************************************************************************************************************************
*
* Custom Detail Fields Retrieve Value Class
* This class prepared for help to create auto config file.
* Author: Webbu Design
*
***********************************************************************************************************************************/
if ( ! class_exists( 'PF_CF_Val' ) ){
	class PF_CF_Val{
		
		public $FieldOutput;

		private $PFCFOptions;

		private $PFLTCOVars;

		private $PFCLang;

		private $FieldListingTax;

		private $PFTMParent;

		private $setup4_membersettings_dateformat;
		
		public function __construct($post_id){
			/* Get Custom Field Options*/
			if (function_exists('icl_t')) {
				$pfcustomfields_options = get_option('pfcustomfields_options');
			}else{
				global $pfcustomfields_options;
			}
			
			$this->PFCFOptions = $pfcustomfields_options;
			$this->PFLTCOVars = get_option('pointfinderltypes_covars');
			$this->PFCLang = PF_current_language();

			$this->FieldListingTax = wp_get_post_terms( $post_id, 'pointfinderltypes',array('fields'=> 'ids'));
			$this->FieldListingTax = (isset($this->FieldListingTax['0']))?$this->FieldListingTax['0']:'';
			
			if(!empty($this->FieldListingTax)){
				$this->PFTMParent = pf_get_term_top_most_parent($this->FieldListingTax,'pointfinderltypes');
				$this->PFTMParent = (isset($this->PFTMParent['parent']))?$this->PFTMParent['parent']:'';
			}

			$this->setup4_membersettings_dateformat = PFSAIssetControl('setup4_membersettings_dateformat','','1');
		}

		function ShortNameCheck($title,$slug){
			
			$ShortName = isset($this->PFCFOptions['setupcustomfields_'.$slug.'_shortname'])?$this->PFCFOptions['setupcustomfields_'.$slug.'_shortname']:'';
			
			if($ShortName != ''){
				
				$output = $ShortName;
				
			}else{
				$output = $title;	
			}
			
			return $output;

		}
		
		function PriceValueCheck($slug,$FieldValue,$FieldTitle,$pfsys=NULL){
			
			$control = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_currency_check']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_currency_check']:0;
			if($control == 1){

				$CFPrefix = $this->PFCFOptions['setupcustomfields_'.$slug.'_currency_prefix'];
				$CFSuffix = $this->PFCFOptions['setupcustomfields_'.$slug.'_currency_suffix'];
				$CFDecima = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_currency_decima']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_currency_decima']:0;
				$CFDecimp = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_currency_decimp']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_currency_decimp']:'.';
				$CFDecimt = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_currency_decimt']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_currency_decimt']:',';
				
				if (!empty($CFSuffix)) {
					$CFSuffix = '<span class="pf-price-suffix">'.$CFSuffix.'</span>';
				}else{
					$CFSuffix = '';
				}
				/*Check field value empty? if yes write 0*/
				if($FieldValue == ''){ $FieldValue = 0;};


				if($pfsys == NULL){
					return '<li class="pf-price">'.$CFPrefix .''. number_format($FieldValue, $CFDecima, $CFDecimp, $CFDecimt) . $CFSuffix.'</li>';
				}elseif($pfsys == 1){
					return '<div class="pflistingitem-subelement pf-price">'.$CFPrefix .''. number_format($FieldValue, $CFDecima, $CFDecimp, $CFDecimt) . $CFSuffix.'</div>';
				}elseif($pfsys == 2){
					return ''.$FieldTitle.'<span class="pfdetail-ftext pf-pricetext">'.$CFPrefix .''. number_format($FieldValue, $CFDecima, $CFDecimp, $CFDecimt) . $CFSuffix.'</span></div>';
				}
			
			}
		
		}
		
		
		function SizeValueCheck($slug,$FieldValue,$FieldTitle,$pfsys=NULL){
			
			$control = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_size_check']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_size_check']:0;

			if($control == 1){

				$CFPrefix = $this->PFCFOptions['setupcustomfields_'.$slug.'_size_prefix'];
				$CFSuffix = $this->PFCFOptions['setupcustomfields_'.$slug.'_size_suffix'];
				$CFDecima = 0;
				$CFDecimp = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_size_decimp']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_size_decimp']:'.';
				$CFDecimt = '.';
				
				//Check field value empty? if yes write 0
				if($FieldValue == ''){ $FieldValue = 0;};
				
				if($pfsys == NULL){
					return '<li>'.$FieldTitle . $CFPrefix .''. number_format($FieldValue, $CFDecima, $CFDecimp, $CFDecimt) .''. $CFSuffix.'<span class="pf-fieldspace"></span></li>';
				}elseif($pfsys == 1){
					return ''.$FieldTitle .'<span class="pf-ftext">'. $CFPrefix .''. number_format($FieldValue, $CFDecima, $CFDecimp, $CFDecimt) .''. $CFSuffix.'</span></div>';
				}elseif($pfsys == 2){
					return ''.$FieldTitle .'<span class="pfdetail-ftext">'. $CFPrefix .''. number_format($FieldValue, $CFDecima, $CFDecimp, $CFDecimt) .''. $CFSuffix.'</span></div>';
				}
			
			}
		
		}



		
		function GetValue($slug,$post_id,$ftype,$title,$pfsys=NULL){
			
			$this->FieldOutput = '';
									
			$HideTitleValue = $this->PFCFOptions['setupcustomfields_'.$slug.'_sinfowindow_hidename'];
			
			if($HideTitleValue == 1){
				if($pfsys == NULL){
					$FieldTitle = '<span class="wpfdetailtitle">'.$this->ShortNameCheck($title,$slug).':</span> ';
				}elseif($pfsys == 1){
					$FieldTitle = '<div class="pflistingitem-subelement pf-onlyitem"><span class="pf-ftitle">'.$this->ShortNameCheck($title,$slug).': </span>';
				}elseif($pfsys == 2){
					$FieldTitle = '<div class="pfdetailitem-subelement pf-onlyitem clearfix"><span class="pf-ftitle">'.$this->ShortNameCheck($title,$slug).' : </span>';
				}
			}else{
				if($pfsys == NULL){
					$FieldTitle = '';
				}elseif($pfsys == 1){
					$FieldTitle = '<div class="pflistingitem-subelement pf-onlyitem"><span class="pf-ftitle"></span>';
				}elseif($pfsys == 2){
					$FieldTitle = '<div class="pfdetailitem-subelement pf-onlyitem clearfix"><span class="pf-ftitle"></span>';
				}
			}
				
			
			/*If not have a parent field*/
			$SourceFieldValue = rwmb_meta( 'webbupointfinder_item_'.$slug, '', $post_id);

			/* Select box get value */
			if($ftype == 8 || $ftype == 7 ){
				
				$SourceFieldArray = pfstring2KeyedArray($this->PFCFOptions['setupcustomfields_'.$slug.'_rvalues']);							
				$SourceFieldValue = (isset($SourceFieldArray[$SourceFieldValue])) ? $SourceFieldArray[$SourceFieldValue] : '' ;
			
			}elseif($ftype == 14 || $ftype == 9){
				
				$SourceFieldValue = get_post_meta( $post_id, 'webbupointfinder_item_'.$slug, false );
				$SourceFieldArray = pfstring2KeyedArray($this->PFCFOptions['setupcustomfields_'.$slug.'_rvalues']);
			
				
				if(count($SourceFieldValue) > 1){

					$SourceFieldValueOut = array();
					foreach($SourceFieldValue as $SourceFieldValueSingle){
						array_push($SourceFieldValueOut,$SourceFieldArray[$SourceFieldValueSingle]);
					}
					
					$SourceFieldValue = implode(", ", $SourceFieldValueOut);
					
				}else{
					$SourceFieldValue = get_post_meta( $post_id, 'webbupointfinder_item_'.$slug, true );
					$SourceFieldValue = (isset($SourceFieldArray[$SourceFieldValue])) ? $SourceFieldArray[$SourceFieldValue] : '' ;
				}

			}elseif ($ftype == 15) {
				
				switch ($this->setup4_membersettings_dateformat) {
					case '1':$date_field_format = 'd/m/Y';break;
					case '2':$date_field_format = 'm/d/Y';break;
					case '3':$date_field_format = 'Y/m/d';break;
					case '4':$date_field_format = 'Y/d/m';break;
					default:$date_field_format = 'd/m/Y';break;
				}	

				$SourceFieldValue = get_post_meta( $post_id, 'webbupointfinder_item_'.$slug, true );
				if (!empty($SourceFieldValue)) {
					$SourceFieldValue = date($this->date_field_format0,$SourceFieldValue);
				}

			}
		
			/*Check if element price*/
			$FieldValue = $this->PriceValueCheck($slug,$SourceFieldValue,$FieldTitle,$pfsys);
			
			/*Check if element size*/
			$FieldValue .= $this->SizeValueCheck($slug,$SourceFieldValue,$FieldTitle,$pfsys);
			
			$ParentItem = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_parent']))?$this->PFCFOptions['setupcustomfields_'.$slug.'_parent']:'';
			
			if(PFControlEmptyArr($ParentItem)){
				if (function_exists('icl_t')) {
					$NewParentItemArr = array();
					foreach ($ParentItem as $ParentItemSingle) {
						$NewParentItemArr[] = apply_filters('wpml_object_id', $ParentItemSingle, 'pointfinderltypes', TRUE);
					}
					$ParentItem = $NewParentItemArr;
				}else{
					$ParentItem = $ParentItem;
				}
			}
				

			/*Get link option*/
			$linkoption = (isset($this->PFCFOptions['setupcustomfields_'.$slug.'_linkoption']))? $this->PFCFOptions['setupcustomfields_'.$slug.'_linkoption']: 0;
			switch ($linkoption) {
				case 1:
					$link_addon = 'http://';$link_addon2 = 'https://';$link_target = "target='_blank'";
					break;
				case 2:
					$link_addon = 'mailto:';$link_target = "";
					break;
				case 3:
					$link_addon = 'tel:';$link_target = "";
					break;
				default:
					$link_addon = 'http://';$link_target = "target='_blank'";
					break;
			}

			/*Check http and https*/
			if ($linkoption == 1) {

				$pf_httpcheck = strpos($SourceFieldValue, 'http://');
				$pf_httpscheck = strpos($SourceFieldValue, 'https://');

				$pfweblink_field = $SourceFieldValue;

				if ($pf_httpcheck === false) {
					if ($pf_httpscheck !== false && $pf_httpcheck === false) {
						$pfweblink_field = $SourceFieldValue;
					}elseif ($pf_httpscheck === false && $pf_httpcheck !== false) {
						$pfweblink_field = $SourceFieldValue;
					}elseif ($pf_httpscheck === false && $pf_httpcheck === false) {
						$pfweblink_field = $link_addon.$SourceFieldValue;
					}
				}
			}else{
				$pfweblink_field = $link_addon. $SourceFieldValue;
			}

			/*If it have a parent element*/
			if(PFControlEmptyArr($ParentItem)){
				
				/*If that parent field = selected taxonomy show*/
				if(!empty($this->FieldListingTax)){
					

					if(function_exists('icl_t')) {
						foreach ($ParentItem as $key => $value) {
							$ParentItem[$key] = icl_object_id($value,'pointfinderltypes',true,$this->PFCLang);
						}
					}
					
					/* Check if this field not need sub cat. */
					$ChoosenTermID = $this->FieldListingTax;

					if (isset($this->PFLTCOVars[$this->PFTMParent]['pf_subcatselect'])) {
						if ($this->PFLTCOVars[$this->PFTMParent]['pf_subcatselect'] == 1) {
							$ChoosenTermID = $this->PFTMParent;
						}
					}
					
					
					

					if(in_array($ChoosenTermID, $ParentItem) ){					
						
						if($FieldValue == ''){

							if($pfsys == NULL){
								if ($linkoption == 0) {
									$FieldValue = '<li>'.$FieldTitle . $SourceFieldValue.'<span class="pf-fieldspace"></span></li>';
								}else{
									$FieldValue = '<li>'.$FieldTitle .'<a href="'.$pfweblink_field.'" '.$link_target.'>'. $SourceFieldValue.'</a><span class="pf-fieldspace"></span></li>';
								}
							}elseif($pfsys == 1){
								if ($linkoption == 0) {
									$FieldValue = ''.$FieldTitle .'<span class="pf-ftext">'. $SourceFieldValue.'</span></div> ';
								}else{
									$FieldValue = ''.$FieldTitle .'<span class="pf-ftext"><a href="'.$pfweblink_field.'" '.$link_target.'>'. $SourceFieldValue.'</a></span></div> ';
								}
							}elseif($pfsys == 2){
								if ($linkoption == 0) {
									$FieldValue = ''.$FieldTitle .'<span class="pfdetail-ftext">'. $SourceFieldValue.'</span></div> ';
								}else{
									$FieldValue = ''.$FieldTitle .'<span class="pfdetail-ftext"><a href="'.$pfweblink_field.'" '.$link_target.'>'. $SourceFieldValue.'</a></span></div> ';
								}
							}

						}

						$this->FieldOutput = $FieldValue;												
				
					}
				}
				
			}else{
				
				
				if($FieldValue == ''){
					
					if($pfsys == NULL){
						if ($linkoption == 0) {
							$FieldValue = '<li>'.$FieldTitle . $SourceFieldValue.'<span class="pf-fieldspace"></span></li>';
						}else{
							$FieldValue = '<li>'.$FieldTitle .'<a href="'.$pfweblink_field.'" '.$link_target.'>'. $SourceFieldValue.'</a><span class="pf-fieldspace"></span></li>';	
						}
					}elseif($pfsys == 1){
						if ($linkoption == 0) {
							$FieldValue = ''.$FieldTitle .'<span class="pf-ftext">'. $SourceFieldValue.'</span></div> ';
						}else{
							$FieldValue = ''.$FieldTitle .'<span class="pf-ftext"><a href="'.$pfweblink_field.'" '.$link_target.'>'. $SourceFieldValue.'</a></span></div> ';
						}
					}elseif($pfsys == 2){
						if ($linkoption == 0) {
							$FieldValue = ''.$FieldTitle .'<span class="pfdetail-ftext">'. $SourceFieldValue.'</span></div> ';
						}else{
							$FieldValue = ''.$FieldTitle .'<span class="pfdetail-ftext"><a href="'.$pfweblink_field.'" '.$link_target.'>'. $SourceFieldValue.'</a></span></div> ';
						}
					}
					
				}
				$this->FieldOutput = $FieldValue;
				
				
			}
			
			if ($SourceFieldValue != '') {
				return $this->FieldOutput;
			} 
							 
		}
			
	}
}
?>