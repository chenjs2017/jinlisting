<?php
/**********************************************************************************************************************************
*
* Point Finder Item Add Page Metabox.
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

/**
*Start:Enqueue Styles
**/
function pointfinder_orders_styles_ex(){
	$screen = get_current_screen();
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	if ($screen->post_type == $setup3_pointposttype_pt1) {

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');	

		wp_register_style( 'jquery-ui-core', get_template_directory_uri() ."/admin/estatemanagement/meta-box-master/css/jqueryui/jquery.ui.core.css", array(), '1.8.17' );
		wp_register_style( 'jquery-ui-theme', get_template_directory_uri() ."/admin/estatemanagement/meta-box-master/css/jqueryui/jquery.ui.theme.css", array(), '1.8.17' );
		wp_enqueue_style( 'jquery-ui-datepicker', get_template_directory_uri() ."/admin/estatemanagement/meta-box-master/css/jqueryui/jquery.ui.datepicker.css", array( 'jquery-ui-core', 'jquery-ui-theme' ), '1.8.17' );

		wp_register_script(
			'metabox-custom-cf-scriptspf', 
			get_template_directory_uri() . '/admin/core/js/metabox-scripts.js', 
			array('jquery'),
			'1.0.0',
			true
		); 
        wp_enqueue_script('metabox-custom-cf-scriptspf'); 

        wp_register_style('pfsearch-goldenforms-css', get_template_directory_uri() . '/css/golden-forms.css', array(), '1.0', 'all');
		wp_enqueue_style('pfsearch-goldenforms-css');


	}
}
add_action('admin_enqueue_scripts','pointfinder_orders_styles_ex' );
/**
*End:Enqueue Styles
**/



/**
*Start : Add Metaboxes
**/
	function pointfinder_orders_add_meta_box_ex($post_type) {
		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

		if ($post_type == $setup3_pointposttype_pt1) {
			$setup3_pointposttype_pt7s = PFSAIssetControl('setup3_pointposttype_pt7s','','Listing Type');
			$setup3_pointposttype_pt6 = PFSAIssetControl('setup3_pointposttype_pt6','','Features');
			$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
			$setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4','','Item Types');
			$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');
			$setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
			$setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','',0);
			$setup3_pt14s = PFSAIssetControl('setup3_pt14s','','Condition');


			remove_meta_box( 'pointfinderltypesdiv', $setup3_pointposttype_pt1, 'side' );
			remove_meta_box( 'pointfinderconditionsdiv', $setup3_pointposttype_pt1, 'side' );
			remove_meta_box( 'pointfinderfeaturesdiv', $setup3_pointposttype_pt1, 'side' );
			remove_meta_box( 'pointfinderitypesdiv', $setup3_pointposttype_pt1, 'side' );
			
			add_meta_box(
				'pointfinder_itemdetailcf_process_lt',
				$setup3_pointposttype_pt7s,
				'pointfinder_itemdetailcf_process_lt_function',
				$setup3_pointposttype_pt1,
				'normal',
				'high'
			);

			add_meta_box(
				'pointfinder_itemdetailcf_process',
				esc_html__( 'Additional Details', 'pointfindert2d' ),
				'pointfinder_itemdetailcf_process_function',
				$setup3_pointposttype_pt1,
				'normal',
				'high'
			);

			
			if ($setup3_pointposttype_pt6_check ) {
				add_meta_box(
					'pointfinder_itemdetailcf_process_fe',
					$setup3_pointposttype_pt6,
					'pointfinder_itemdetailcf_process_fe_function',
					$setup3_pointposttype_pt1,
					'normal',
					'core'
				);
			}

			
			if ($setup3_modulessetup_openinghours == 1) {
				add_meta_box(
					'pointfinder_itemdetailoh_process_fe',
					esc_html__( 'Opening Hours', 'pointfindert2d' ).' <small>('.esc_html__('Leave blank to show closed','pointfindert2d' ).')</small>',
					'pointfinder_itemdetailoh_process_fe_function',
					$setup3_pointposttype_pt1,
					'normal',
					'high'
				);
			}


			
			if ($setup3_pt14_check == 1) {
				add_meta_box(
					'pointfinder_itemdetailcf_process_co',
					$setup3_pt14s,
					'pointfinder_itemdetailcf_process_co_function',
					$setup3_pointposttype_pt1,
					'side',
					'core'
				);
			}


			
			if ($setup3_pointposttype_pt4_check == 1) {
				add_meta_box(
					'pointfinder_itemdetailcf_process_it',
					$setup3_pointposttype_pt4,
					'pointfinder_itemdetailcf_process_it_function',
					$setup3_pointposttype_pt1,
					'side',
					'core'
				);
			}

		}

		
	}
	add_action( 'add_meta_boxes', 'pointfinder_orders_add_meta_box_ex', 9,1);
/**
*End : Add Metaboxes
**/



/**
*Start : Listing Type
**/
function pointfinder_itemdetailcf_process_lt_function( $post ) {
	
	/* Get admin panel defaults */
	$setup4_submitpage_listingtypes_title = PFSAIssetControl('setup4_submitpage_listingtypes_title','','Listing Type');
	$setup4_submitpage_sublistingtypes_title = PFSAIssetControl('setup4_submitpage_sublistingtypes_title','','Sub Listing Type');
	$setup4_submitpage_subsublistingtypes_title = PFSAIssetControl('setup4_submitpage_subsublistingtypes_title','','Sub Sub Listing Type');

    $st4_sp_med = PFSAIssetControl('st4_sp_med','','1');
	$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
	$setup4_submitpage_locationtypes_check = PFSAIssetControl('setup4_submitpage_locationtypes_check','','1');
	$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
	$setup4_submitpage_itemtypes_check = PFSAIssetControl('setup4_submitpage_itemtypes_check','','1');
	$setup4_submitpage_imageupload = PFSAIssetControl('setup4_submitpage_imageupload','','1');
	$stp4_fupl = PFSAIssetControl("stp4_fupl","","0");


	/* WPML Check */
	if(function_exists('icl_t')) {$lang_custom = PF_current_language();}else{$lang_custom = '';}

	/* Get Limits */
	$cat_extra_opts = get_option('pointfinderltypes_covars');

	/* Get selected listing types */
	$item_level_value = 0;
    $item_defaultvalue = ($post->ID != '') ? wp_get_post_terms($post->ID, 'pointfinderltypes', array("fields" => "ids")) : '' ;
	$item_defaultvalue_output = $sub_level = $sub_sub_level = $item_defaultvalue_output_orj = '';
	
	if (count($item_defaultvalue) > 1) {
		if (isset($item_defaultvalue[0])) {
			$item_defaultvalue_output_orj = $item_defaultvalue[0];
			$find_top_parent = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');

			$ci=1;
			foreach ($item_defaultvalue as $value) {
				$sub_level .= $value;
				if ($ci < count($item_defaultvalue)) {
					$sub_level .= ',';
				}
				$ci++;
			}
			$item_defaultvalue_output = $find_top_parent['parent'];
			$item_level_value = (isset($find_top_parent['level']))?$find_top_parent['level']:0;
		}
	}else{
		if (isset($item_defaultvalue[0])) {
			$item_defaultvalue_output_orj = $item_defaultvalue[0];
			$find_top_parent = pf_get_term_top_most_parent($item_defaultvalue[0],'pointfinderltypes');

			switch ($find_top_parent['level']) {
				case '1':
					$sub_level = $item_defaultvalue[0];
					break;
				
				case '2':
					$sub_sub_level = $item_defaultvalue[0];
					$sub_level = pf_get_term_top_parent($item_defaultvalue[0],'pointfinderltypes');
					break;
			}
			

			$item_defaultvalue_output = $find_top_parent['parent'];
			$item_level_value = (isset($find_top_parent['level']))?$find_top_parent['level']:0;
		}
	}

    echo '<div class="form-field">';
    echo '<section>';
    
    $listingtype_values = get_terms('pointfinderltypes',array('hide_empty'=>false,'parent'=> 0)); 
											
	echo '<input type="hidden" name="pfupload_listingtypes" id="pfupload_listingtypes" value="'.$item_defaultvalue_output.'"/>';

	echo '<div class="pflistingtype-selector-main-top clearfix" data-pfajaxurl="'.get_template_directory_uri().'/admin/core/pfajaxhandler.php" data-pflang="'.$lang_custom.'" data-pfnonce="'.wp_create_nonce('pfget_listingtypelimits').'" data-pfnoncef="'.wp_create_nonce('pfget_featuresystem').'" data-pfid="'.$post->ID.'" data-pfplaceh="'.esc_html__("Search for a user","pointfindert2d").'">';

	$subcatsarray = "var pfsubcatselect = [";
	$multiplesarray = "var pfmultipleselect = [";
		foreach ($listingtype_values as $listingtype_value) {
			
			/* Multiple select & Subcat Select */
			$multiple_select = (isset($cat_extra_opts[$listingtype_value->term_id]['pf_multipleselect']))?$cat_extra_opts[$listingtype_value->term_id]['pf_multipleselect']:2;
			$subcat_select = (isset($cat_extra_opts[$listingtype_value->term_id]['pf_subcatselect']))?$cat_extra_opts[$listingtype_value->term_id]['pf_subcatselect']:2;

			if ($multiple_select == 1) {$multiplesarray .= $listingtype_value->term_id.',';}
			if ($subcat_select == 1) {$subcatsarray .= $listingtype_value->term_id.',';}


			echo '<div class="pflistingtype-selector-main">';
			echo '<input type="radio" name="radio" id="pfltypeselector'.$listingtype_value->term_id.'" class="pflistingtypeselector" value="'.$listingtype_value->term_id.'" '.checked( $item_defaultvalue_output, $listingtype_value->term_id,0).'/>';
			echo '<label for="pfltypeselector'.$listingtype_value->term_id.'">'.$listingtype_value->name.'</label>';
			echo '</div>';

		}
	echo '</div>';

	$subcatsarray .= "];";
	$multiplesarray .= "];";

	echo '<div style="margin-left:10px" class="pf-sub-listingtypes-container"></div>';

    echo '</section>';

    echo '
    <script>
    (function($) {
  	"use strict";';
  	echo $subcatsarray.$multiplesarray;

  	/* Start: Function for sub listing types */
  	echo "
	
		$.pf_get_sublistingtypes = function(itemid,defaultv){
			if ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) != -1) {
				var multiple_ex = 1;
			}else{
				var multiple_ex = 0;
			}
			$.ajax({
		    	beforeSend:function(){
		    		$('#pointfinder_itemdetailcf_process_lt .inside').pfLoadingOverlay({action:'show',message: '".esc_html__('Loading fields...','pointfindert2d')."'});
		    	},
				url: '".get_template_directory_uri()."/admin/core/pfajaxhandler.php',
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
					$('#pfupload_sublistingtypes').select2({
						placeholder: '".esc_html__('Please select','pointfindert2d')."', 
						formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
						allowClear: true, 
						minimumResultsForSearch: 10
					});";

					if (empty($sub_sub_level)) {
					echo " if ($('#pfupload_sublistingtypes').val() != 0 && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
						$.pf_get_subsublistingtypes($('#pfupload_sublistingtypes').val(),'');
					}";
					}
					echo "

					$('#pfupload_sublistingtypes').change(function(){
						if($('#pfupload_sublistingtypes').val() != 0){
							if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
								$('#pfupload_listingtypes').val($(this).val()).trigger('change');
							}else{
								$('#pfupload_listingtypes').val($(this).val());
							}
							if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
								$.pf_get_subsublistingtypes($(this).val(),'');
							}
						}else{
							if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
								$('#pfupload_listingtypes').val($('input.pflistingtypeselector:checked').val());
							}else{
								$('#pfupload_listingtypes').val($('input.pflistingtypeselector:checked').val()).trigger('change');
							}
						}
						$('.pfsubsublistingtypes').remove();
					});

					if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
						$('#pfupload_sublistingtypes').on('select2-removed', function(e) {
							$('#pfupload_listingtypes').val($('input.pflistingtypeselector:checked').val()).trigger('change');
						});
					}
				}

			}).complete(function(obj,obj2){

				if (obj.responseText != '') {
				if (defaultv != '') {
					if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
						";
						if ($item_level_value == 2 && $post->ID != '') {
							echo "$('#pfupload_listingtypes').val(defaultv);
							";
						}else{
							echo "$('#pfupload_listingtypes').val(defaultv).trigger('change');";
						}
						echo "
					}else{
						$('#pfupload_listingtypes').val(defaultv);
					}
				}else{
					
					if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
						";
						if ($item_level_value == 1 && $post->ID != '') {
							echo "$('#pfupload_listingtypes').val(itemid).trigger('change');";
						}elseif (empty($post->ID)) {
							echo "$('#pfupload_listingtypes').val(itemid);";
						}elseif (!empty($post->ID) && $item_level_value == 2) {
							echo "$('#pfupload_listingtypes').val(itemid);
							";
						}
						echo "
					}else{
						$('#pfupload_listingtypes').val(itemid);
					}
				}
				}
				setTimeout(function(){
					$('#pointfinder_itemdetailcf_process_lt .inside').pfLoadingOverlay({action:'hide'});
				},1000);
				";
				
				if (!empty($sub_sub_level)) {
					echo "
					if (".$sub_level." == $('#pfupload_sublistingtypes').val()) {
						$.pf_get_subsublistingtypes('".$sub_level."','".$sub_sub_level."');
					}
					";
				}
				echo "
			});
		}

		$.pf_get_subsublistingtypes = function(itemid,defaultv){
			$.ajax({
		    	beforeSend:function(){
		    		$('#pointfinder_itemdetailcf_process_lt .inside').pfLoadingOverlay({action:'show',message: '".esc_html__('Loading fields ...','pointfindert2d')."'});
		    	},
				url: '".get_template_directory_uri()."/admin/core/pfajaxhandler.php',
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
					$('#pfupload_subsublistingtypes').select2({
						placeholder: '".esc_html__('Please select','pointfindert2d')."', 
						formatNoMatches:'".esc_html__('No match found','pointfindert2d')."',
						allowClear: true, 
						minimumResultsForSearch: 10
					});

					$('#pfupload_subsublistingtypes').change(function(){
						if($('#pfupload_subsublistingtypes').val() != 0){
							
							if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
								$('#pfupload_listingtypes').val($(this).val()).trigger('change');
							}else{
								$('#pfupload_listingtypes').val($(this).val());
							}

						}else{
							
							if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
								$('#pfupload_listingtypes').val($('#pfupload_sublistingtypes').val()).trigger('change');
							}else{
								$('#pfupload_listingtypes').val($('#pfupload_sublistingtypes').val());
							}
						}
					});
					}
			}).complete(function(obj,obj2){
				if (obj.responseText != '') {
				if (defaultv != '') {
					if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
						$('#pfupload_listingtypes').val(defaultv).trigger('change');
					}else{
						$('#pfupload_listingtypes').val(defaultv);
					}
				}else{
					
					if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfsubcatselect) == -1) && ($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) == -1)) {
						";
						if ($item_level_value == 2 && $post->ID != '') {
							echo "$('#pfupload_listingtypes').val(itemid).trigger('change');";
						}elseif (empty($post->ID)) {
							echo "$('#pfupload_listingtypes').val(itemid);";
						}
						echo "
					}else{
						$('#pfupload_listingtypes').val(itemid);
					}
				}
				}
				setTimeout(function(){
					$('#pointfinder_itemdetailcf_process_lt .inside').pfLoadingOverlay({action:'hide'});
				},1000);
			});
		}
	
	";
	/* End: Function for sub listing types */

	echo "$.pflimitarray = [";
		$pflimittext = '';
		/*Get Limits for Areas*/
		if ($st4_sp_med == 1) {
			$pflimittext .= "'pf_address_area'";
		}

		/*Get Limits for Image Area*/
		if($setup4_submitpage_imageupload == 1){
			if (!empty($pflimittext)) {$pflimittext .= ",";}
			$pflimittext .= "'pf_image_area'";
		}

		/*Get Limits for File Area*/
		if($stp4_fupl == 1){
			if (!empty($pflimittext)) {$pflimittext .= ",";}
			$pflimittext .= "'pf_file_area'";
		}

		echo $pflimittext;
		echo "];";


	echo "$(function(){";
		if ($post->ID != '') {
			echo "$.pf_get_checklimits('".$item_defaultvalue_output."',$.pflimitarray);";
			echo "$.pf_get_sublistingtypes($('#pfupload_listingtypes').val(),'".$sub_level."');";
			echo "
			if (($.inArray(parseInt($('input.pflistingtypeselector:checked').val()),pfmultipleselect) != -1)) {
				$.pf_getmodules_now(".$item_defaultvalue_output.");
			}else{";
			if ($item_level_value == 0 && $post->ID != '') {
				echo "$.pf_getmodules_now($('#pfupload_listingtypes').val());";
			}elseif(empty($post->ID)){
				echo "$.pf_getmodules_now($('#pfupload_listingtypes').val());";
			}
			echo "
			}";

			if (empty($sub_sub_level) && !empty($sub_level)) {
				echo "$('#pfupload_listingtypes').val('".$sub_level."');";
			}
		}
	echo "});";


	echo "})(jQuery);</script></div>";
	
}
/**
*End : Listing Type
**/



/**
*Start : Custom Fields Content
**/
function pointfinder_itemdetailcf_process_function( $post ) {
	echo "<div class='golden-forms'>";
	echo "<section class='pfsubmit-inner pfsubmit-inner-customfields'></section>";
	echo "</div>";
}
/**
*End : Custom Fields Content
**/


/**
*Start : Features
**/
function pointfinder_itemdetailcf_process_fe_function( $post ) {
	$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');
	if ($setup3_pointposttype_pt6_check ) {
		echo "<a class='pfitemdetailcheckall'>";
		echo esc_html__('Check All','pointfindert2d');
		echo "</a>";
		echo " / ";
		echo "<a class='pfitemdetailuncheckall'>";
		echo esc_html__('Uncheck All','pointfindert2d');
		echo "</a>";
		echo "<section class='pfsubmit-inner pfsubmit-inner-features'></section>";
	}
}
/**
*End : Features
**/


/**
*Start : Conditions
**/
function pointfinder_itemdetailcf_process_co_function( $post ) {

	echo '<section class="pfsubmit-inner pfsubmit-inner-sub-conditions"></section>';
	
}
/**
*End : Conditions
**/



/**
*Start : Item Types
**/
function pointfinder_itemdetailcf_process_it_function( $post ) {

	echo '<section class="pfsubmit-inner pfsubmit-inner-sub-itype"></section>';
	
}
/**
*End : Item Types
**/



/**
*Start : Opening Hours
**/
function pointfinder_itemdetailoh_process_fe_function( $post ) {
	$setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
	$setup3_modulessetup_openinghours_ex = PFSAIssetControl('setup3_modulessetup_openinghours_ex','','1');
	$setup3_modulessetup_openinghours_ex2 = PFSAIssetControl('setup3_modulessetup_openinghours_ex2','','1');
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
	wp_register_script('theme-timepicker', get_template_directory_uri() . '/js/jquery-ui-timepicker-addon.js', array('jquery','jquery-ui-datepicker'), '4.0',true); 
	wp_enqueue_script('theme-timepicker');
	wp_enqueue_style('jquery-ui-smoothnesspf3', get_template_directory_uri() . "/css/jquery-ui.min.css", false, null);
	wp_enqueue_style('jquery-ui-smoothnesspf2', get_template_directory_uri() . "/css/jquery-ui.structure.min.css", false, null);
	wp_enqueue_style('jquery-ui-smoothnesspf', get_template_directory_uri() . "/css/jquery-ui.theme.min.css", false, null);

	echo '<section class="pfsubmit-inner pf-openinghours-div golden-forms openinghourstab-output-container"></section>';
}
/**
*End : Opening Hours
**/



/**
*Start : Save Metadata and other inputs
**/
function pointfinder_item_save_meta_box_data( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['pfupload_listingtypes'] ) ) {
		return;
	}

	$pfupload_listingtypes = sanitize_text_field($_POST['pfupload_listingtypes']);

	if (!empty($pfupload_listingtypes)) {

			
		/*Listing Type*/
			if(isset($pfupload_listingtypes)){
				if(PFControlEmptyArr($pfupload_listingtypes)){
					$pftax_terms = $pfupload_listingtypes;
				}else if(!PFControlEmptyArr($pfupload_listingtypes) && isset($pfupload_listingtypes)){
					$pftax_terms = $pfupload_listingtypes;
					if (strpos($pftax_terms, ",") != false) {
						$pftax_terms = pfstring2BasicArray($pftax_terms);
					}else{
						$pftax_terms = array($pfupload_listingtypes);
					}
				}
				wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderltypes');
			}

			
		
		/*Item Types*/
		if (isset($_POST['pfupload_itemtypes'])) {
			$pfupload_itemtypes = $_POST['pfupload_itemtypes'];
			
			if (is_array($pfupload_itemtypes)) {
				$pfupload_itemtypes = PFCleanArrayAttr('PFCleanFilters',$pfupload_itemtypes);
			}else{
				$pfupload_itemtypes = sanitize_text_field($pfupload_itemtypes );
			}

			if(PFControlEmptyArr($pfupload_itemtypes)){
				$pftax_terms = $pfupload_itemtypes;
			}else{
				$pftax_terms = $pfupload_itemtypes;
				if (strpos($pftax_terms, ",") != false) {
					$pftax_terms = pfstring2BasicArray($pftax_terms);
				}else{
					$pftax_terms = array($pfupload_itemtypes);
				}
			}
			wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderitypes');
			
		}


		/*Conditions*/
		if (isset($_POST['pfupload_conditions'])) {
			$pfupload_conditions = sanitize_text_field($_POST['pfupload_conditions']);
			if (!empty($pfupload_conditions)) {
				wp_set_post_terms( $post_id, array($pfupload_conditions), 'pointfinderconditions');
			}else{
				wp_set_post_terms( $post_id, "", 'pointfinderconditions');
			}
		}
			

		/*Custom fields loop*/
			$pfstart = PFCheckStatusofVar('setup1_slides');
			$setup1_slides = PFSAIssetControl('setup1_slides','','');

			if($pfstart == true){

				foreach ($setup1_slides as &$value) {

		          $available_fields = array(1,2,3,4,5,7,8,9,14,15);
		          
		          if(in_array($value['select'], $available_fields)){

		           	if (isset($_POST[''.$value['url'].''])) {
			           	
			           	if (is_array($_POST[''.$value['url'].''])) {
			           		$post_value_url = PFCleanArrayAttr('PFCleanFilters',$_POST[''.$value['url'].'']);
			           	}else{
			           		$post_value_url = sanitize_text_field($_POST[''.$value['url'].'']);
			           	}

						if(isset($post_value_url)){
							
							if ($value['select'] == 15) {
								$setup4_membersettings_dateformat = PFSAIssetControl('setup4_membersettings_dateformat','','1');
								switch ($setup4_membersettings_dateformat) {
									case '1':$datetype = "d/m/Y";break;
									case '2':$datetype = "m/d/Y";break;
									case '3':$datetype = "Y/m/d";break;
									case '4':$datetype = "Y/d/m";break;
								}

								$pfvalue = date_parse_from_format($datetype, $post_value_url);
								$post_value_url = strtotime(date("Y-m-d", mktime(0, 0, 0, $pfvalue['month'], $pfvalue['day'], $pfvalue['year'])));
							}

							if(!is_array($post_value_url)){ 
								update_post_meta($post_id, 'webbupointfinder_item_'.$value['url'], $post_value_url);	
							}else{
								if(PFcheck_postmeta_exist('webbupointfinder_item_'.$value['url'],$post_id)){
									delete_post_meta($post_id, 'webbupointfinder_item_'.$value['url']);
								};
								
								foreach ($post_value_url as $val) {
									add_post_meta ($post_id, 'webbupointfinder_item_'.$value['url'], $val);
								};

							};
						}else{
							delete_post_meta($post_id, 'webbupointfinder_item_'.$value['url']);
						};
					};

		          };
		          
		        };
			};


		/*Features*/
			if (!empty($_POST['pffeature'])) {
				$feature_values = PFCleanArrayAttr('PFCleanFilters',$_POST['pffeature']);
			
				if(isset($feature_values)){				
					if(PFControlEmptyArr($feature_values)){
						$pftax_terms = $feature_values;
					}else if(!PFControlEmptyArr($feature_values) && isset($feature_values)){
						$pftax_terms = array($feature_values);
					}
					wp_set_post_terms( $post_id, $pftax_terms, 'pointfinderfeatures');
				}else{
					wp_set_post_terms( $post_id, '', 'pointfinderfeatures');
				}
			}
			

		/*Opening Hours*/
			$setup3_modulessetup_openinghours = PFSAIssetControl('setup3_modulessetup_openinghours','','0');
			$setup3_modulessetup_openinghours_ex = PFSAIssetControl('setup3_modulessetup_openinghours_ex','','1');
			if ($setup3_modulessetup_openinghours == 1 &&  $setup3_modulessetup_openinghours_ex == 2) {
				$i = 1;
				while ( $i <= 7) {
					if(isset($_POST['o'.$i.'_1']) && isset($_POST['o'.$i.'_2'])){
						update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, sanitize_text_field($_POST['o'.$i.'_1']).'-'.sanitize_text_field($_POST['o'.$i.'_2']));	
					}
					$i++;
				}
			}elseif ($setup3_modulessetup_openinghours == 1 &&  $setup3_modulessetup_openinghours_ex == 0) {
				$i = 1;
				while ( $i <= 7) {
					if(isset($_POST['o'.$i])){
						update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, sanitize_text_field($_POST['o'.$i]));	 
					}
					$i++;
				}
			}elseif ($setup3_modulessetup_openinghours == 1 &&  $setup3_modulessetup_openinghours_ex == 1) {
				$i = 1;
				while ( $i <= 1) {
					if(isset($_POST['o'.$i])){
						update_post_meta($post_id, 'webbupointfinder_items_o_o'.$i, sanitize_text_field($_POST['o'.$i]));	 
					}
					$i++;
				}
			}


	}
	
}
add_action( 'save_post', 'pointfinder_item_save_meta_box_data' );
/**
*End : Save Metadata and other inputs
**/

?>