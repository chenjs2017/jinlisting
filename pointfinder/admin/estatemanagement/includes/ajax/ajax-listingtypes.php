<?php

/**********************************************************************************************************************************
*
* Ajax Listing Types
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

add_action( 'PF_AJAX_HANDLER_pfget_listingtype', 'pf_ajax_listingtype' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_listingtype', 'pf_ajax_listingtype' );
	
	
function pf_ajax_listingtype(){
	
	check_ajax_referer( 'pfget_listingtype', 'security' );
	header('Content-Type: text/html; charset=UTF-8;');

	$id = $default = $lang = '';

	if(isset($_POST['id']) && $_POST['id']!=''){
		$id = sanitize_text_field($_POST['id']);
	}

	if(isset($_POST['lang']) && $_POST['lang']!=''){
		$lang = sanitize_text_field($_POST['lang']);
	}

	if(isset($_POST['default']) && $_POST['default']!=''){
		$default = sanitize_text_field($_POST['default']);
		if (strpos($default, ",")) {
			$default = pfstring2BasicArray($default);
		}
	}

	if(isset($_POST['sname']) && $_POST['sname']!=''){
		$sname = sanitize_text_field($_POST['sname']);
	}

	if(isset($_POST['stext']) && $_POST['stext']!=''){
		$stext = sanitize_text_field($_POST['stext']);
	}

	if(isset($_POST['stype']) && $_POST['stype']!=''){
		$stype = sanitize_text_field($_POST['stype']);
	}

	if(isset($_POST['stax']) && $_POST['stax']!=''){
		$stax = sanitize_text_field($_POST['stax']);
	}

	if(isset($_POST['multiple']) && $_POST['multiple']!=''){
		$multiple = sanitize_text_field($_POST['multiple']);
	}else{
		$multiple = 0;
	}

	/* WPML Fix */
	if(function_exists('icl_t')) {
		if (!empty($lang)) {
			do_action( 'wpml_switch_language', $lang );
		}
	}

	function PF_GET_LType_FUP($params = array()){
	    $defaults = array( 
	        'listname' => '',
	        'listtype' => '',
	        'listtitle' => '',
	        'listsubtype' => '',
	        'listdefault' => '',
	        'listmultiple' => 0,
	        'parent' => 0
	    );
		
	    $params = array_merge($defaults, $params);
	    	
	    	$output_options = '';
	    	if (is_array($params['listdefault'])) {
	    		$params['listmultiple'] = 1;
	    	}
	    	if($params['listmultiple'] == 1){ $multiplevar = ' multiple';$multipletag = '[]';}else{$multiplevar = '';$multipletag = '';};
			$fieldvalues = get_terms($params['listsubtype'],array('hide_empty'=>false,'parent'=>$params['parent'],'fields'=>'id=>name')); 
			$output = '';

			if (count((array)$fieldvalues) > 0) {

			
				foreach( $fieldvalues as $fieldkey => $fieldname){
					$fieldtaxSelectedValue = 0;

					if($params['listdefault'] != ''){
						if(is_array($params['listdefault'])){
							if(in_array($fieldkey, $params['listdefault'])){ $fieldtaxSelectedValue = 1;}
						}else{
							if(strcmp($params['listdefault'],$fieldkey) == 0){ $fieldtaxSelectedValue = 1;}
						}
					}
					
					if($fieldtaxSelectedValue == 1){
						$output_options .= '<option value="'.$fieldkey.'" selected>'.$fieldname.'</option>';
					}else{
						$output_options .= '<option value="'.$fieldkey.'">'.$fieldname.'</option>';
					}
							
				}
			

				$output .= '<div class="pf_fr_inner" data-pf-parent="">';
				

				if (!empty($params['listtitle'])) {
					$output .= '<label for="'.$params['listname'].'" class="lbl-text">'.$params['listtitle'].':</label>';
				}

				$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

				if ($as_mobile_dropdowns == 1 && $params['listmultiple'] != 1) {
					$as_mobile_dropdowns_text = 'class="pf-special-selectbox" data-pf-plc="'.esc_html__('Please select','pointfindert2d').'"';
				} else {
					$as_mobile_dropdowns_text = '';
				}
				
				if($params['listmultiple'] == 1){$stext1 = 'select-multiple';}else{$stext1 = 'select';}

				$output .= '
		        <label class="lbl-ui '.$stext1.'">
		        <select'.$multiplevar.' name="'.$params['listname'].$multipletag.'" id="'.$params['listname'].'" '.$as_mobile_dropdowns_text.'>';
		        if ($params['listmultiple'] != 1) {
		        	$output .= '<option></option>';
		        }
		    
		        $output .= $output_options.'
		        </select>
		        </label>';
		   		$output .= '</div>';

	   		}

	    return $output;
	}
	

	if (!empty($id) && !empty($sname) && !empty($stext)) {
		$fields_output_arr = array(
			'listname' => $sname,
	        'listtype' => $stype,
	        'listtitle' => $stext,
	        'listsubtype' => $stax,
	        'listdefault' => $default,
	        'listmultiple' => $multiple,
	        'parent' => $id
		);
		echo PF_GET_LType_FUP($fields_output_arr);
	}
	
	die();
}

?>