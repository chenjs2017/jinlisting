<?php
/**********************************************************************************************************************************
*
* VC Extend Settings
* 
* Author: Webbu Design
*
* $debug_data = $PFVEXFields_ItemGrid;
* echo str_replace(array('&lt;?php&nbsp;','?&gt;'), '', highlight_string( '<?php ' .     var_export($debug_data, true) . ' ?>', true ) );
***********************************************************************************************************************************/

if (!defined('ABSPATH')) die('-1');


	function pf_remove_vcmeta_boxes() {
		global $pagenow;
		if($pagenow == 'post.php' || $pagenow == 'post-new.php'){
			$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
			remove_meta_box( 'vc_teaser', 'post', 'side');
			remove_meta_box( 'vc_teaser', 'page',  'side');
			remove_meta_box( 'vc_teaser', $setup3_pointposttype_pt1, 'side');
		}
	}
	add_action( 'admin_head', 'pf_remove_vcmeta_boxes' );
	

	function PFVEX_GetTaxValues($taxname,$optionvar,$defaultname){
		$listingtype_terms = array();
		$terms = get_terms($taxname, array('hide_empty'=>false,'orderby'=>'title'));
			$listingtype_terms[esc_html__("All : ", 'pointfindert2d').PFSAIssetControl($optionvar,'',$defaultname)] = '';
			if ( !empty( $terms ) && !is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$listingtype_terms[$term->term_id] =  $term->name;
			}
		}
		return $listingtype_terms;
	}

	function PFVEX_GetTaxValues2($taxname,$optionvar,$defaultname){
		$listingtype_terms = array();
		$terms = get_terms($taxname, array('hide_empty'=>false,'orderby'=>'title','parent'=>0));
			$listingtype_terms[esc_html__("All : ", 'pointfindert2d').PFSAIssetControl($optionvar,'',$defaultname)] = '';
			if ( !empty( $terms ) && !is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$listingtype_terms[$term->term_id] =  $term->name;
			}
		}
		return $listingtype_terms;
	}
	
	global $pagenow;
	if($pagenow == 'post.php' || $pagenow == 'post-new.php'){
		
		function fontelloie7_pfa () {
			echo '<!--[if IE 7]>
			<link rel="stylesheet" href="'.get_template_directory_uri() . '/css/fontello-ie7.css">
			<![endif]-->
			<script type="text/javascript" src="'.get_template_directory_uri() . '/admin/includes/vcextend/assets/jquery.qtip-1.0.0-rc3.js"></script>
			';
		}
		add_action('admin_head', 'fontelloie7_pfa',200);
	}
		
	
	// Custom Elements --------------------------------------------------------------------------------------------------
	function PFVC_Add_custompf_fields(){
		$setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
		$setup3_pointposttype_pt6 = PFSAIssetControl('setup3_pointposttype_pt6','','Features');
		$setup3_pointposttype_pt5 = PFSAIssetControl('setup3_pointposttype_pt5','','Locations');
		$setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4','','Item Types');

		$setup3_pt14 = PFSAIssetControl('setup3_pt14','','Conditions');
        $setup3_pt14_check = PFSAIssetControl('setup3_pt14_check','','0');

		//Css Animation common field.
		$add_css_animation = array(
			"type" => "dropdown",
			"heading" => esc_html__("CSS Animation", "pointfindert2d"),
			"param_name" => "css_animation",
			"admin_label" => true,
			"value" => array(esc_html__("No", "pointfindert2d") => '', esc_html__("Top to bottom", "pointfindert2d") => "top-to-bottom", esc_html__("Bottom to top", "pointfindert2d") => "bottom-to-top", esc_html__("Left to right", "pointfindert2d") => "left-to-right", esc_html__("Right to left", "pointfindert2d") => "right-to-left", esc_html__("Appear from center", "pointfindert2d") => "appear"),
			"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "pointfindert2d")
		  );
		

		//Check taxonomies
		$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
		$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
		$setup3_pointposttype_pt6_check = PFSAIssetControl('setup3_pointposttype_pt6_check','','1');
		$setup3_pointposttype_pt6_status = PFSAIssetControl('setup3_pointposttype_pt6_status','','1');

		//Default grid settings from admin
		$setup22_searchresults_background = PFSAIssetControl('setup22_searchresults_background','','#ffffff');
		$setup22_searchresults_headerbackground = PFSAIssetControl('setup22_searchresults_headerbackground','','#fafafa');
		$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#fafafa');


		$PFVEX_GetTaxValues1 = PFVEX_GetTaxValues('pointfinderltypes','setup3_pointposttype_pt7','Listing Types');
		$PFVEX_GetTaxValues2 = PFVEX_GetTaxValues('pointfinderitypes','setup3_pointposttype_pt4','Item Types');
		$PFVEX_GetTaxValues3 = PFVEX_GetTaxValues('pointfinderlocations','setup3_pointposttype_pt5','Locations');
		$PFVEX_GetTaxValues4 = PFVEX_GetTaxValues('pointfinderfeatures','setup3_pointposttype_pt6','Features');
		$PFVEX_GetTaxValues5 = PFVEX_GetTaxValues('pointfinderconditions','setup3_pt14','Conditions');

		/** 
		*Start : PF Text Separator ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
				'name' => esc_html__( 'PF Text Separator', 'pointfindert2d' ),
				'base' => 'pftext_separator',
				'icon' => 'icon-wpb-ui-separator-label',
				'category' => esc_html__( 'Point Finder', 'pointfindert2d' ),
				'description' => esc_html__( 'Horizontal separator line with heading', 'pointfindert2d' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'pointfindert2d' ),
						'param_name' => 'title',
						'holder' => 'div',
						'value' => esc_html__( 'Title', 'pointfindert2d' ),
						'description' => esc_html__( 'Separator title.(Required)', 'pointfindert2d' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Title position', 'pointfindert2d' ),
						'param_name' => 'title_align',
						'value' => array(
							esc_html__( 'Align left', 'pointfindert2d' ) => 'separator_align_left',
							esc_html__( 'Align center', 'pointfindert2d' ) => 'separator_align_center',
							esc_html__( 'Align right', 'pointfindert2d' ) => "separator_align_right"
						),
						'description' => esc_html__( 'Select title location.', 'pointfindert2d' )
					)
				)
			) );

		/** 
		*End : PF Text Separator ---------------------------------------------------------------------------------------------------- 
		**/


		/** 
		*Start : Agent List ---------------------------------------------------------------------------------------------------- 
		**/
			if ($setup3_pointposttype_pt6_status == 1) {
				vc_map( array(
				"name" => esc_html__("PF Agent List", 'pointfindert2d'),
				"base" => "pf_agentlist",
				"icon" => "pf_agentlist",
				"category" => esc_html__("Point Finder", "pointfindert2d"),
				"description" => esc_html__('List of Agents', 'pointfindert2d'),
				"params" => array(			
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Items Per Page", "pointfindert2d"),
							"param_name" => "pagelimit",
							"value" => array(2=>2,4=>4,6=>6,8=>8,10=>10,12=>12,14=>14,16=>16,18=>18,20=>20,22=>22,24=>24,26=>26,28=>28,30=>30),
							"description" => esc_html__("How many agents would you like to display per page?", "pointfindert2d"),
						)
					)
				) );
			}
		/** 
		*End : Agent List ---------------------------------------------------------------------------------------------------- 
		**/



		/** 
		*Start : Item Grid AJAX ---------------------------------------------------------------------------------------------------- 
		**/
			$PFVEXFields_ItemGrid = array();
			$PFVEXFields_ItemGrid['name'] = esc_html__("PF Item Grid AJAX", 'pointfindert2d');
			$PFVEXFields_ItemGrid['base'] = "pf_itemgrid";
			$PFVEXFields_ItemGrid['class'] = "pfa-itemgrid";
			$PFVEXFields_ItemGrid['controls'] = "full";
			$PFVEXFields_ItemGrid['icon'] = "pfaicon-th";
			$PFVEXFields_ItemGrid['category'] = "Point Finder";
			$PFVEXFields_ItemGrid['description'] = esc_html__("Point Finder item grid with AJAX.", 'pointfindert2d');
			$PFVEXFields_ItemGrid['params'] = "";
			$PFVEXFields_ItemGrid['params'] = array(
				array(
				  "type" => "pfa_select2",
				  "heading" => $setup3_pointposttype_pt7,
				  "param_name" => "listingtype",
				  "value" => $PFVEX_GetTaxValues1,
				  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
				  "admin_label" => true
				),
				  
			  );
			
				
			if($setup3_pointposttype_pt4_check == 1){
				array_push($PFVEXFields_ItemGrid['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt4,
					  "param_name" => "itemtype",
					  "value" => $PFVEX_GetTaxValues2,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt5_check == 1){
				array_push($PFVEXFields_ItemGrid['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt5,
					  "param_name" => "locationtype",
					  "value" => $PFVEX_GetTaxValues3,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt6_check == 1){
				array_push($PFVEXFields_ItemGrid['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt6,
					  "param_name" => "features",
					  "value" => $PFVEX_GetTaxValues4,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}

			if($setup3_pt14_check == 1){
				array_push($PFVEXFields_ItemGrid['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pt14,
					  "param_name" => "conditions",
					  "value" => $PFVEX_GetTaxValues5,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			array_push($PFVEXFields_ItemGrid['params'],
				//If possible add custom fields filter on here.
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order by", "pointfindert2d"),
					"param_name" => "orderby",
					"value" => array(esc_html__("Title", "pointfindert2d")=>'title',esc_html__("Date", "pointfindert2d")=>'date'),
					"description" => esc_html__("Please select an order by filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6'
					
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order", "pointfindert2d"),
					"param_name" => "sortby",
					"value" => array(esc_html__("ASC", "pointfindert2d")=>'ASC',esc_html__("DESC", "pointfindert2d")=>'DESC'),
					"description" => esc_html__("Please select an order filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					
				),
				array(
			        "type" => "textfield",
			        "heading" => esc_html__("Item IDs", "pointfindert2d"),
			        "param_name" => "posts_in",
			        "description" => esc_html__('Fill this field with items ID numbers separated by commas (,), to retrieve only them. Ex: 171,172,173 (Optional) This option will show only selected items.', "pointfindert2d")
			     ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Items Per Page", "pointfindert2d"),
					"param_name" => "items",
					"value" => array(4=>4,6=>6,8=>8,12=>12,15=>15,16=>16,18=>18,21=>21,24=>24,25=>25,50=>50,75=>75),
					"description" => esc_html__("How many items would you like to display per page?", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					
				),
				array(
					  "type" => "dropdown",
					  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
					  "param_name" => "cols",
					  "value" => array('4 Columns'=>'4','2 Columns'=>'2','3 Columns'=>'3','1 Column'=>'1'),
					  "description" => esc_html__("Please choose default column number for this grid.", "pointfindert2d"),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
					  
				),
				array(
			        "type" => "dropdown",
			        "heading" => esc_html__("Layout mode", "pointfindert2d"),
			        "param_name" => "grid_layout_mode",
			        "value" => array(esc_html__("Fit rows", "pointfindert2d") => "fitRows", esc_html__('Masonry', "pointfindert2d") => 'masonry'),
			        "description" => esc_html__("Gridview layout template.", "pointfindert2d"),
			        "edit_field_class" => 'vc_col-sm-6 vc_column'
			      ),
				array(
					  "type" => "dropdown",
					  "heading" => esc_html__("Enable filters on grid header?", "pointfindert2d"),
					  "param_name" => "filters",
					  "value" => array(esc_html__("Yes", "pointfindert2d")=>'true',esc_html__("No", "pointfindert2d")=>'false'),
					  "description" => esc_html__("This function will enable grid filtering (Sortby / Order etc..)", "pointfindert2d"),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
					  
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Only show featured items", "pointfindert2d"),
					  "param_name" => "featureditems",
					  "description" => esc_html__("Enables featured items and hide another items on query.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
					),
				array(
					  "type" => "colorpicker",
					  "heading" => esc_html__("Item Box Area Background", 'pointfindert2d'),
					  "param_name" => "itemboxbg",
					  "value" => $setup22_searchresults_background2, 
					  "description" => esc_html__("Item box area background color of the grid listing area. Optional", 'pointfindert2d'),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("HIDE featured items", "pointfindert2d"),
					  "param_name" => "featureditemshide",
					  "description" => esc_html__("Disable featured items and show another items on query. You can not use with Only show featured items", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("SHOW Listing Type Filter", "pointfindert2d"),
					  "param_name" => "listingtypefilters",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("SHOW Item Type Filter", "pointfindert2d"),
					  "param_name" => "itemtypefilters",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("SHOW Location Filter", "pointfindert2d"),
					  "param_name" => "locationfilters",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					)
				
			);
			vc_map($PFVEXFields_ItemGrid);
		/**
		*End : Item Grid AJAX
		**/




		/** 
		*Start : Item Grid Static ---------------------------------------------------------------------------------------------------- 
		**/
			$PFVEXFields_ItemGrid2 = array();
			$PFVEXFields_ItemGrid2['name'] = esc_html__("PF Item Grid Static", 'pointfindert2d');
			$PFVEXFields_ItemGrid2['base'] = "pf_itemgrid2";
			$PFVEXFields_ItemGrid2['controls'] = "full";
			$PFVEXFields_ItemGrid2['icon'] = "pfaicon-th";
			$PFVEXFields_ItemGrid2['category'] = "Point Finder";
			$PFVEXFields_ItemGrid2['description'] = esc_html__("Point Finder item grid without AJAX.", 'pointfindert2d');
			$PFVEXFields_ItemGrid2['params'] = "";
			$PFVEXFields_ItemGrid2['params'] = array(
				array(
				  "type" => "pfa_select2",
				  "heading" => $setup3_pointposttype_pt7,
				  "param_name" => "listingtype",
				  "value" => $PFVEX_GetTaxValues1,
				  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
				  "admin_label" => true
				),
				  
			  );
			
			
			if($setup3_pointposttype_pt4_check == 1){
				array_push($PFVEXFields_ItemGrid2['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt4,
					  "param_name" => "itemtype",
					  "value" => $PFVEX_GetTaxValues2,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt5_check == 1){
				array_push($PFVEXFields_ItemGrid2['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt5,
					  "param_name" => "locationtype",
					  "value" => $PFVEX_GetTaxValues3,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt6_check == 1){
				array_push($PFVEXFields_ItemGrid2['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt6,
					  "param_name" => "features",
					  "value" => $PFVEX_GetTaxValues4,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}

			if($setup3_pt14_check == 1){
				array_push($PFVEXFields_ItemGrid2['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pt14,
					  "param_name" => "conditions",
					  "value" => $PFVEX_GetTaxValues5,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			array_push($PFVEXFields_ItemGrid2['params'],
				//If possible add custom fields filter on here.
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order by", "pointfindert2d"),
					"param_name" => "orderby",
					"value" => array(esc_html__("Title", "pointfindert2d")=>'title',esc_html__("Date", "pointfindert2d")=>'date'),
					"description" => esc_html__("Please select an order by filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order", "pointfindert2d"),
					"param_name" => "sortby",
					"value" => array(esc_html__("ASC", "pointfindert2d")=>'ASC',esc_html__("DESC", "pointfindert2d")=>'DESC'),
					"description" => esc_html__("Please select an order filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
			        "type" => "textfield",
			        "heading" => esc_html__("Item IDs", "pointfindert2d"),
			        "param_name" => "posts_in",
			        "description" => esc_html__('Fill this field with items ID numbers separated by commas (,), to retrieve only them. Ex: 171,172,173 (Optional) This option will show only selected items.', "pointfindert2d")
			     ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Items Per Page", "pointfindert2d"),
					"param_name" => "items",
					"value" => array(4=>4,6=>6,8=>8,12=>12,15=>15,16=>16,18=>18,21=>21,24=>24,25=>25,50=>50,75=>75),
					"description" => esc_html__("How many items would you like to display per page?", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
					  "type" => "dropdown",
					  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
					  "param_name" => "cols",
					  "value" => array('4 Columns'=>'4','2 Columns'=>'2','3 Columns'=>'3','1 Column'=>'1'),
					  "description" => esc_html__("Please choose default column number for this grid.", "pointfindert2d"),	
					  "edit_field_class" => 'vc_col-sm-6 vc_column'			  
				),
				array(
			        "type" => "dropdown",
			        "heading" => esc_html__("Layout mode", "pointfindert2d"),
			        "param_name" => "grid_layout_mode",
			        "value" => array(esc_html__("Fit rows", "pointfindert2d") => "fitRows", esc_html__('Masonry', "pointfindert2d") => 'masonry'),
			        "description" => esc_html__("Gridview layout template.", "pointfindert2d"),
			        "edit_field_class" => 'vc_col-sm-6 vc_column'
			      ),
				array(
					  "type" => "dropdown",
					  "heading" => esc_html__("Enable filters on grid header?", "pointfindert2d"),
					  "param_name" => "filters",
					  "value" => array(esc_html__("Yes", "pointfindert2d")=>'true',esc_html__("No", "pointfindert2d")=>'false'),
					  "description" => esc_html__("This function will enable grid filtering (Sortby / Order etc..)", "pointfindert2d"),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Only show featured items", "pointfindert2d"),
					  "param_name" => "featureditems",
					  "description" => esc_html__("Enables featured items and hide another items on query.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
					),
				array(
					  "type" => "colorpicker",
					  "heading" => esc_html__("Item Box Area Background", 'pointfindert2d'),
					  "param_name" => "itemboxbg",
					  "value" => $setup22_searchresults_background2, 
					  "description" => esc_html__("Item box area background color of the grid listing area. Optional", 'pointfindert2d'),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("HIDE featured items", "pointfindert2d"),
					  "param_name" => "featureditemshide",
					  "description" => esc_html__("Disable featured items and show another items on query. You can not use with Only show featured items", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("SHOW Listing Type Filter", "pointfindert2d"),
					  "param_name" => "listingtypefilters",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("SHOW Item Type Filter", "pointfindert2d"),
					  "param_name" => "itemtypefilters",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("SHOW Location Filter", "pointfindert2d"),
					  "param_name" => "locationfilters",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Infinite Scroll", "pointfindert2d"),
					  "param_name" => "infinite_scroll",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => '1')
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Infinite Scroll Load More Button", "pointfindert2d"),
					  "param_name" => "infinite_scroll_lm",
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => '1')
					)
				
			);
			vc_map($PFVEXFields_ItemGrid2);
		/**
		*End : Item Grid Static
		**/




		/** 
		*Start : Item Carousel Static ---------------------------------------------------------------------------------------------------- 
		**/
			$PFVEXFields_ItemCarousel = array();
			$PFVEXFields_ItemCarousel['name'] = esc_html__("PF Item Carousel", 'pointfindert2d');
			$PFVEXFields_ItemCarousel['base'] = "pf_pfitemcarousel";
			$PFVEXFields_ItemCarousel['controls'] = "full";
			$PFVEXFields_ItemCarousel['icon'] = "pfaicon-th";
			$PFVEXFields_ItemCarousel['category'] = "Point Finder";
			$PFVEXFields_ItemCarousel['description'] = esc_html__("Point Finder item carousel", 'pointfindert2d');
			$PFVEXFields_ItemCarousel['params'] = "";
			$PFVEXFields_ItemCarousel['params'] = array(
				array(
				  "type" => "pfa_select2",
				  "heading" => $setup3_pointposttype_pt7,
				  "param_name" => "listingtype",
				  "value" => $PFVEX_GetTaxValues1,
				  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
				  "admin_label" => true
				),
				  
			  );
			
			
			if($setup3_pointposttype_pt4_check == 1){
				array_push($PFVEXFields_ItemCarousel['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt4,
					  "param_name" => "itemtype",
					  "value" => $PFVEX_GetTaxValues2,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt5_check == 1){
				array_push($PFVEXFields_ItemCarousel['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt5,
					  "param_name" => "locationtype",
					  "value" => $PFVEX_GetTaxValues3,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt6_check == 1){
				array_push($PFVEXFields_ItemCarousel['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt6,
					  "param_name" => "features",
					  "value" => $PFVEX_GetTaxValues4,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}

			if($setup3_pt14_check == 1){
				array_push($PFVEXFields_ItemCarousel['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pt14,
					  "param_name" => "conditions",
					  "value" => $PFVEX_GetTaxValues5,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			array_push($PFVEXFields_ItemCarousel['params'],
				//If possible add custom fields filter on here.
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order by", "pointfindert2d"),
					"param_name" => "orderby",
					"value" => array(esc_html__("Title", "pointfindert2d")=>'title',esc_html__("Date", "pointfindert2d")=>'date'),
					"description" => esc_html__("Please select an order by filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6'
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order", "pointfindert2d"),
					"param_name" => "sortby",
					"value" => array(esc_html__("ASC", "pointfindert2d")=>'ASC',esc_html__("DESC", "pointfindert2d")=>'DESC'),
					"description" => esc_html__("Please select an order filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
			        "type" => "textfield",
			        "heading" => esc_html__("Item IDs", "pointfindert2d"),
			        "param_name" => "posts_in",
			        "description" => esc_html__('Fill this field with items ID numbers separated by commas (,), to retrieve only them. Ex: 171,172,173 (Optional) This option will show only selected items.', "pointfindert2d")
			     ),
				
				array(
					  "type" => "dropdown",
					  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
					  "param_name" => "cols",
					  "value" => array('4 Columns'=>'4','2 Columns'=>'2','3 Columns'=>'3'),
					  "description" => esc_html__("Please choose default column number for this grid.", "pointfindert2d"),		  
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Only show featured items", "pointfindert2d"),
					  "param_name" => "featureditems",
					  "description" => esc_html__("Enables featured items and hide another items on query.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("HIDE featured items", "pointfindert2d"),
					  "param_name" => "featureditemshide",
					  "description" => esc_html__("Disable featured items and show another items on query. You can not use with Only show featured items", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-6 vc_column'
					),
				
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Item Limit', 'pointfindert2d' ),
					'param_name' => 'itemlimit',
					'value' => '20',
					'description' => esc_html__( 'You can limit items.', 'pointfindert2d' ),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'pointfindert2d' ),
					'param_name' => 'speed',
					'value' => '500',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'pointfindert2d' ),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
				),
				array(
					  "type" => "colorpicker",
					  "heading" => esc_html__("Item Box Area Background", 'pointfindert2d'),
					  "param_name" => "itemboxbg",
					  "value" => $setup22_searchresults_background2, 
					  "description" => esc_html__("Item box area background color of the grid listing area. Optional", 'pointfindert2d')
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'pointfindert2d' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'pointfindert2d' ),
					'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'pointfindert2d' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If YES pagination control will be removed.', 'pointfindert2d' ),
					'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'pointfindert2d' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed.', 'pointfindert2d' ),
					'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Disable Item Padding', 'pointfindert2d' ),
					'param_name' => 'zeropadding',
					'description' => esc_html__( 'This will disable padding between items.', 'pointfindert2d' ),
					'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
				)
				
			);
			vc_map($PFVEXFields_ItemCarousel);
		/**
		*End : Item Carousel Static
		**/


		
		/** 
		*Start : Item Slider ---------------------------------------------------------------------------------------------------- 
		**/
			$PFVEXFields_Item_Slider = array();
			$PFVEXFields_Item_Slider['name'] = esc_html__("PF Item Slider", 'pointfindert2d');
			$PFVEXFields_Item_Slider['base'] = "pf_itemslider";
			$PFVEXFields_Item_Slider['controls'] = "full";
			$PFVEXFields_Item_Slider['icon'] = "pfaicon-doc-landscape";
			$PFVEXFields_Item_Slider['category'] = "Point Finder";
			$PFVEXFields_Item_Slider['description'] = esc_html__("Item slider", 'pointfindert2d');
			$PFVEXFields_Item_Slider['params'] = "";
			$PFVEXFields_Item_Slider['params'] = array();
			
			array_push($PFVEXFields_Item_Slider['params'],
				
				array(
			        "type" => "textfield",
			        "heading" => esc_html__("Item IDs", "pointfindert2d"),
			        "param_name" => "posts_in",
			        "description" => esc_html__('Fill this field with items ID numbers separated by commas (,), to retrieve only them. Ex: 171,172,173 (Optional)', "pointfindert2d")
			     ),
				array(
				  "type" => "pfa_select2",
				  "heading" => $setup3_pointposttype_pt7,
				  "param_name" => "listingtype",
				  "value" => $PFVEX_GetTaxValues1,
				  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
				  "admin_label" => true
				)
			);

			if($setup3_pointposttype_pt4_check == 1){
				array_push($PFVEXFields_Item_Slider['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt4,
					  "param_name" => "itemtype",
					  "value" => $PFVEX_GetTaxValues2,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt5_check == 1){
				array_push($PFVEXFields_Item_Slider['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt5,
					  "param_name" => "locationtype",
					  "value" => $PFVEX_GetTaxValues3,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt6_check == 1){
				array_push($PFVEXFields_Item_Slider['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt6,
					  "param_name" => "features",
					  "value" => $PFVEX_GetTaxValues4,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			array_push($PFVEXFields_Item_Slider['params'],
				
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order by", "pointfindert2d"),
					"param_name" => "orderby",
					"value" => array(esc_html__("Title", "pointfindert2d")=>'title',esc_html__("Date", "pointfindert2d")=>'date'),
					"description" => esc_html__("Please select an order by filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Order", "pointfindert2d"),
					"param_name" => "sortby",
					"value" => array(esc_html__("ASC", "pointfindert2d")=>'ASC',esc_html__("DESC", "pointfindert2d")=>'DESC'),
					"description" => esc_html__("Please select an order filter.", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Slides count", "pointfindert2d"),
					"param_name" => "count",
					"value" => "5",
					"description" => esc_html__('How many slides to show? Enter number or word "All".', "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-4 vc_column'
				),
				array(
					  "type" => "textfield",
					  "heading" => esc_html__("Slider speed", "pointfindert2d"),
					  "param_name" => "interval",
					  "value" => "5000",
					  "description" => esc_html__("Duration of animation between slides (in ms)", "pointfindert2d"),
					  "edit_field_class" => 'vc_col-sm-4 vc_column'
				 ),
				
				array(
				  "type" => "dropdown",
				  "heading" => esc_html__("Slider Effect", "pointfindert2d"),
				  "param_name" => "mode",
				  "value" => array(esc_html__("Fade", "pointfindert2d") => 'fade', esc_html__("Fade Up", "pointfindert2d") => 'fadeUp',esc_html__("Back Slide", "pointfindert2d") => 'backSlide', esc_html__("Go Down", "pointfindert2d") => 'goDown'),
				  "description" => esc_html__("If slider enabled (1 Column) You can select a transition effect for it.", "pointfindert2d"),
				  "edit_field_class" => 'vc_col-sm-4 vc_column'
				),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Slider autoplay", "pointfindert2d"),
					  "param_name" => "autoplay",
					  "description" => esc_html__("Enables autoplay mode.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-4 vc_column'
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Only show featured items", "pointfindert2d"),
					  "param_name" => "featureditems",
					  "description" => esc_html__("Enables featured items and hide another items on query.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-4 vc_column'
					),
				array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Hide Description Box", "pointfindert2d"),
					  "param_name" => "descbox",
					  "description" => esc_html__("If want to hide description box please check.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					  "edit_field_class" => 'vc_col-sm-4 vc_column'
					)
				
			);
			vc_map($PFVEXFields_Item_Slider);
		/** 
		*End : Item Slider ---------------------------------------------------------------------------------------------------- 
		**/
		
		


		
		/** 
		*Start : Directory Map ---------------------------------------------------------------------------------------------------- 
		**/
			$PFVexFields_dmap = array();
			$PFVexFields_dmap['name'] = esc_html__("PF Directory Map", 'pointfindert2d');
			$PFVexFields_dmap['base'] = "pf_directory_map";
			$PFVexFields_dmap['controls'] = "full";
			$PFVexFields_dmap['icon'] = "pf_directory_map";
			$PFVexFields_dmap['category'] = "Point Finder";
			$PFVexFields_dmap['description'] = esc_html__("Directory Map", 'pointfindert2d');
			$PFVexFields_dmap['params'] = array();
			
			array_push($PFVexFields_dmap['params'],
				array(
				  "type" => "pfa_select2",
				  "heading" => $setup3_pointposttype_pt7,
				  "param_name" => "listingtype",
				  "value" => $PFVEX_GetTaxValues1,
				  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
				  "admin_label" => true
				)
			);

			if($setup3_pointposttype_pt4_check == 1){
				array_push($PFVexFields_dmap['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt4,
					  "param_name" => "itemtype",
					  "value" => $PFVEX_GetTaxValues2,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt5_check == 1){
				array_push($PFVexFields_dmap['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt5,
					  "param_name" => "locationtype",
					  "value" => $PFVEX_GetTaxValues3,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			if($setup3_pointposttype_pt6_check == 1){
				array_push($PFVexFields_dmap['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pointposttype_pt6,
					  "param_name" => "features",
					  "value" => $PFVEX_GetTaxValues4,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}

			if($setup3_pt14_check == 1){
				array_push($PFVexFields_dmap['params'],
					array(
					  "type" => "pfa_select2",
					  "heading" => $setup3_pt14,
					  "param_name" => "conditions",
					  "value" => $PFVEX_GetTaxValues5,
					  "description"=>esc_html__('Leave empty for select all.','pointfindert2d'),
					  "admin_label" => true
					)
				);
			}
			
			array_push($PFVexFields_dmap['params'],
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field10",
					  ),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Default Latitude", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_lat",
						"description" => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates %s', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>'),
					  	"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Default Longitude", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_lng",
						"description" => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates %s', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>'),
					  	"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field7",
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Map Height", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_height",
						"value"	=> '550',
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Desktop View Zoom", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_zoom",
						"value"	=> '12',
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Mobile View Zoom", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_zoom_mobile",
						"value"	=> '10',
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field6",
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Limit Points", "pointfindert2d"),
						"param_name" => "setup8_pointsettings_limit",
						"value"	=> '',
						"description" => esc_html__('After changing map point limit then you will see order/orderby filter options. The limit number must be higher than zero. If you set it empty, going to be unlimited.', 'pointfindert2d')
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Limit Points: Order By", "pointfindert2d"),
						  "param_name" => "setup8_pointsettings_orderby",
						  "edit_field_class" => 'vc_col-sm-6 vc_column',
						  "dependency" => array('element' => 'setup8_pointsettings_limit','not_empty' => true),
						  "value" => array(esc_html__("Title", "pointfindert2d") => 'title',esc_html__("ID", "pointfindert2d") => 'id',esc_html__("Date", "pointfindert2d") => 'date'),
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Limit Points: Order", "pointfindert2d"),
						  "param_name" => "setup8_pointsettings_order",
						  "edit_field_class" => 'vc_col-sm-6 vc_column',
						  "dependency" => array('element' => 'setup8_pointsettings_limit','not_empty' => true),
						  "value" => array(esc_html__("DESC", "pointfindert2d") => 'DESC',esc_html__("ASC", "pointfindert2d") => 'ASC'),
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field5",
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Background Mode", "pointfindert2d"),
						  "param_name" => "backgroundmode",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "description" => esc_html__('If this option is enabled; You can use video background or static image background.', 'pointfindert2d') ,
					  ),
					array(
			            "type" => "textarea_html",
			            "class" => "",
			            "heading" => __( "Background Mode Text", "pointfindert2d" ),
			            "param_name" => "content",
			            "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "pointfindert2d" ),
			            "description" => __( "Enter your content.", "pointfindert2d" ),
			            "dependency" => array('element' => 'backgroundmode','value' => '1'),
			         ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__('Left Margin for BG Mode Text (px)', 'pointfindert2d'),
						"param_name" => "box_leftmargin",
						"description" => esc_html__("Leave empty for use default size. (Optional)", "pointfindert2d"),
						"value"	=> 350,
						"dependency" => array('element' => 'backgroundmode','value' => '1'),
						"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__('Top Margin for BG Mode Text (px)', 'pointfindert2d'),
						"param_name" => "box_topmargin",
						"description" => esc_html__("Leave empty for use default size. (Optional)", "pointfindert2d"),
						"value"	=> 100,
						"dependency" => array('element' => 'backgroundmode','value' => '1'),
						"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Horizontal Search Mode", "pointfindert2d"),
						  "param_name" => "horizontalmode",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "description" => esc_html__('If this option is enabled; Map search will be horizontal.', 'pointfindert2d') ,
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Visible Area AJAX Load", "pointfindert2d"),
						  "param_name" => "setup8_pointsettings_ajax",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "description" => esc_html__('If this option is enabled; Map will start to load points in visible area. Enable option is recrommended if there are too much points. Ex: If you have 10.000 points and do not want to load all of them at the same time, you can enable this option.', 'pointfindert2d') ,
					  ),
						array(
							  "type" => "dropdown",
							  "heading" => esc_html__("Ajax Drag & Load", "pointfindert2d"),
							  "param_name" => "setup8_pointsettings_ajax_drag",
							  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => 1),
							  "description" => esc_html__('Loading after drag end.', 'pointfindert2d'),
							  "dependency" => array('element' => 'setup8_pointsettings_ajax','value' => '1'),
							  "edit_field_class" => 'vc_col-sm-6 vc_column'
						  ),
						array(
							  "type" => "dropdown",
							  "heading" => esc_html__("Ajax Zoom & Load", "pointfindert2d"),
							  "param_name" => "setup8_pointsettings_ajax_zoom",
							  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => 1),
							  "description" => esc_html__('Loading after zoom up/down.', 'pointfindert2d'),
							  "dependency" => array('element' => 'setup8_pointsettings_ajax','value' => '1'),
							  "edit_field_class" => 'vc_col-sm-6 vc_column'
						  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field4",
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("AutoFit Points", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_autofit",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("AutoFit Points After Search", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_autofitsearch",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						  "type" => "pf_info_field",
						  "param_name" => "pf_info_field1",
						  "description" => esc_html__('Autofit options zooms all the points in such a way that shows all of those points appears on the screen.', 'pointfindert2d'),
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field3",
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Map Type", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_type",
						  "value" => array(
						  	esc_html__('ROADMAP', 'pointfindert2d') => 'ROADMAP' ,
							esc_html__('SATELLITE', 'pointfindert2d') => 'SATELLITE' ,
							esc_html__('HYBRID', 'pointfindert2d') =>  'HYBRID',
							esc_html__('TERRAIN', 'pointfindert2d') => 'TERRAIN'
						  ),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Business Points", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_business",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Street View Control", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_streetviewcontrol",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field2",
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Map Search", "pointfindert2d"),
						  "param_name" => "mapsearch_status",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-6 vc_column',
						  "description" => esc_html__("You can show map search by using this option.", "pointfindert2d"),
					  ),
					
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Map Notification Window", "pointfindert2d"),
						  "param_name" => "mapnot_status",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-6 vc_column',
						  "description" => esc_html__("You can show map notification window by using this option.", "pointfindert2d"),
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field8",
					  ),
					array(
						  "type" => "textarea_raw_html",
						  "heading" => esc_html__("Map Style", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_style",
						  "value" => " ",
						  "description" => esc_html__('You can copy and paste style codes here. <strong>Please check help documentation for this area.</strong>', 'pointfindert2d'),
					  )

				);
			vc_map($PFVexFields_dmap);
		/** 
		*End : Directory Map ---------------------------------------------------------------------------------------------------- 
		**/



		/** 
		*Start : Contact Map ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
			"name" => esc_html__("PF Contact Map", 'pointfindert2d'),
			"base" => "pf_contact_map",
			"icon" => "pf_contact_map",
			"category" => esc_html__("Point Finder", "pointfindert2d"),
			"description" => esc_html__('Contact Map', 'pointfindert2d'),
			"params" => array(		
						
					array(
						"type" => "textfield",
						"heading" => esc_html__("Map Center Latitude", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_lat",
						"description" => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates %s', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>'),
					  	"edit_field_class" => 'vc_col-sm-6'
					  ),
					array(
						"type" => "textfield",
						"heading" => esc_html__("Map Center Longitude", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_lng",
						"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field122",
					  ),
					array(
						  "type" => "pf_custom_pointsx",
						  "param_name" => "pfcustompoint",
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field130",
					  ),
					array(
						"type" => "colorpicker",
						"heading" => esc_html__('Pointer Color', 'pointfindert2d'),
						"param_name" => "colorp",
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field37",
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Map Height", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_height",
						"value"	=> '350',
						"edit_field_class" => 'vc_col-sm-4 vc_column',
						"description"	=> esc_html__("Min. 350px", "pointfindert2d"),
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Desktop View Zoom", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_zoom",
						"value"	=> '12',
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Mobile View Zoom", "pointfindert2d"),
						"param_name" => "setup5_mapsettings_zoom_mobile",
						"value"	=> '10',
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "pf_info_line_field",
						  "param_name" => "pf_info_field644",
					  ),
					
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Map Type", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_type",
						  "value" => array(
						  	esc_html__('ROADMAP', 'pointfindert2d') => 'ROADMAP' ,
							esc_html__('SATELLITE', 'pointfindert2d') => 'SATELLITE' ,
							esc_html__('HYBRID', 'pointfindert2d') =>  'HYBRID',
							esc_html__('TERRAIN', 'pointfindert2d') => 'TERRAIN'
						  ),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Business Points", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_business",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Street View Control", "pointfindert2d"),
						  "param_name" => "setup5_mapsettings_streetviewcontrol",
						  "value" => array(esc_html__("Disabled", "pointfindert2d") => '0',esc_html__("Enabled", "pointfindert2d") => '1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
					  )

				)
			) );
		/** 
		*End : Contact Map ---------------------------------------------------------------------------------------------------- 
		**/



		/** 
		*Start : Contact Form ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
			"name" => esc_html__("PF Contact Form", 'pointfindert2d'),
			"base" => "pf_contactform",
			"icon" => "pf_contactform",
			"category" => esc_html__("Point Finder", "pointfindert2d"),
			"description" => esc_html__('Contact Form', 'pointfindert2d'),
			"params" => array(			
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Subject Field", "pointfindert2d"),
					  "param_name" => "contact_subject",
					  "description" => esc_html__("Enables subject field.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
					),
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Phone Field", "pointfindert2d"),
					  "param_name" => "contact_phone",
					  "description" => esc_html__("Enables phone field.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					),
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Message Field", "pointfindert2d"),
					  "param_name" => "contact_mes",
					  "description" => esc_html__("Enables message field.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					),
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("reCaptcha Field", "pointfindert2d"),
					  "param_name" => "contact_re",
					  "description" => esc_html__("Enables reCaptcha field.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					)
				)
			) );
		/** 
		*Start : Contact Form ---------------------------------------------------------------------------------------------------- 
		**/



		/** 
		*Start : Client Carousel ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
			"name" => esc_html__("PF Client Carousel", 'pointfindert2d'),
			"base" => "pf_clientcarousel",
			"icon" => "pfaicon-users",
			"category" => esc_html__("Point Finder", "pointfindert2d"),
			"description" => esc_html__('Client carousel', 'pointfindert2d'),
			"params" => array(
					array(
					  "type" => "textfield",
					  "heading" => esc_html__("Widget title", "pointfindert2d"),
					  "param_name" => "title",
					  "description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", "pointfindert2d")
					),
					array(
					  "type" => "attach_images",
					  "heading" => esc_html__("Images", "pointfindert2d"),
					  "param_name" => "images",
					  "value" => "",
					  "description" => esc_html__("Select images from media library.", "pointfindert2d")
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Items", "pointfindert2d"),
						"param_name" => "img_size",
						"value" => array(
							esc_html__("4 Item - Default", "pointfindert2d") => "grid4",
							esc_html__("5 Item", "pointfindert2d") => "grid5", 
							esc_html__("3 Item", "pointfindert2d") => "grid3",esc_html__("2 Item", "pointfindert2d") => "grid2"
						),
						"description" => esc_html__("How many item want to see in viewport? (On mobile and tablet it will resize auto.)", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					),
					array(
					  "type" => "textfield",
					  "heading" => esc_html__("Slider speed", "pointfindert2d"),
					  "param_name" => "speed",
					  "value" => "5000",
					  "description" => esc_html__("Duration of animation between slides (in ms)", "pointfindert2d"),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					),
					array(
					  "type" => "dropdown",
					  "heading" => esc_html__("On click", "pointfindert2d"),
					  "param_name" => "onclick",
					  "value" => array(
						   esc_html__("Open prettyPhoto", "pointfindert2d") => "link_image",
						   esc_html__("Do nothing", "pointfindert2d") => "link_no", 
						   esc_html__("Open custom link", "pointfindert2d") => "custom_link"
					   ),
					  "description" => esc_html__("What to do when slide is clicked?", "pointfindert2d")
					),
					array(
					  "type" => "exploded_textarea",
					  "heading" => esc_html__("Custom links", "pointfindert2d"),
					  "param_name" => "custom_links",
					  "description" => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'pointfindert2d'),
					  "dependency" => array('element' => "onclick", 'value' => array('custom_link'))
					),

					array(
					  "type" => "dropdown",
					  "heading" => esc_html__("Custom link target", "pointfindert2d"),
					  "param_name" => "custom_links_target",
					  "description" => esc_html__('Select where to open  custom links.', 'pointfindert2d'),
					  "dependency" => array('element' => "onclick", 'value' => array('custom_link')),
					  'value' => array(esc_html__("Same window", "pointfindert2d") => "_self", esc_html__("New window", "pointfindert2d") => "_blank")
					),
					
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Slider autoplay", "pointfindert2d"),
					  "param_name" => "autoplay",
					  "description" => esc_html__("Enables autoplay mode.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					),
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Hide pagination control", "pointfindert2d"),
					  "param_name" => "hide_pagination_control",
					  "description" => esc_html__("If YES pagination control will be removed.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					),
					array(
					  "type" => 'checkbox',
					  "heading" => esc_html__("Hide borders", "pointfindert2d"),
					  "param_name" => "hide_borders",
					  "description" => esc_html__("If YES borders control will be removed.", "pointfindert2d"),
					  "value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					),
					array(
					"type" => 'checkbox',
					"heading" => esc_html__("Disable Auto Crop", "pointfindert2d"),
					"param_name" => "autocrop",
					"description" => esc_html__("Disables auto crop on image.(Not recommended.)", "pointfindert2d"),
					"value" => array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
					"edit_field_class" => 'vc_col-sm-6 vc_column'
					),
					array(
					"type" => "textfield",
					"heading" => esc_html__("Custom Size (Optional)", "pointfindert2d"),
					"param_name" => "customsize",
					"value" => "",
					"description" => esc_html__("Ex: 300x200  | Custom size value (Optional). Please leave blank for auto resize. (in px)", "pointfindert2d")
					),
			)
			) );
		/** 
		*End : Client Carousel ---------------------------------------------------------------------------------------------------- 
		**/
		
		

		/** 
		*Start : Info Box ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
			"name" => esc_html__("PF Info Box", 'pointfindert2d'),
			"base" => "pf_infobox",
			"icon" => "pfaicon-archive-2",
			"category" => esc_html__("Point Finder", "pointfindert2d"),
			"description" => esc_html__('Info Boxes', 'pointfindert2d'),
			"params" => array(
					 array(
						"type" => "dropdown",
						"heading" => esc_html__("Infobox Style", "pointfindert2d"),
						"param_name" => "iconbox_style",
						"value" => array(esc_html__("Simple Infobox", "pointfindert2d") => "type1", esc_html__("Boxed Simple Infobox", "pointfindert2d") => "type2",esc_html__("Icon at Top & Boxed Title + Text", "pointfindert2d") => "type3",esc_html__("Simple Infobox & Icon at Right", "pointfindert2d") => "type4",esc_html__("Simple Infobox & Icon at Left", "pointfindert2d") => "type5",),
					  ),
					  
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Icon Type", "pointfindert2d"),
						"param_name" => "icon_type",
						"value" => array(esc_html__("Predefined Font Icon", "pointfindert2d") => "font", esc_html__("No Icon", "pointfindert2d") => "no_icon"),
						"description" => esc_html__("Please select an icon type.", "pointfindert2d"),
						"dependency" => array('element' => "iconbox_style", 'value' => array('type2'))
					  ),
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Icon Style", "pointfindert2d"),
						"param_name" => "icon_style_outside",
						"value" => array(esc_html__("No border & No Background", "pointfindert2d") => "", esc_html__("Rounded Border & Background", "pointfindert2d") => "rounded", esc_html__("Rounded Square Border & Background", "pointfindert2d") => "rectangle", esc_html__("Square Border & Background", "pointfindert2d") => "square"),
						"description" => esc_html__("Please select an icon style for outside area of icon.", "pointfindert2d")
					  ),
					  array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Info Box Border Radius", "pointfindert2d"),
						"param_name" => "box_border_radius",
						"description" => esc_html__("Please write a border radius value (px) (Optional) (Numeric only)", "pointfindert2d"),
						"value"	=> '0',
					  ),
					  $add_css_animation,
					  
					  array(
						"type" => "pfa_select1",
						"heading" => esc_html__("Please Select an Icon", "pointfindert2d"),
						"param_name" => "iconbox_icon_name",
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Icon Color', 'pointfindert2d'),
						"param_name" => "box_icon_color",
					    "edit_field_class" => 'vc_col-sm-3 vc_column'
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Icon Background', 'pointfindert2d'),
						"param_name" => "box_icon_bg_color",
						"edit_field_class" => 'vc_col-sm-3 vc_column'
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Icon Border Color', 'pointfindert2d'),
						"param_name" => "box_icon_border_color",
						"edit_field_class" => 'vc_col-sm-3 vc_column'
					  ),
					  array(
						"type" => "pfa_numeric",
						"heading" => esc_html__("Icon Size", "pointfindert2d"),
						"param_name" => "box_icon_size",
						"value"	=> '16',
						"edit_field_class" => 'vc_col-sm-3 vc_column'
					  ),

					  array(
						"type" => "textfield",
						"heading" => esc_html__("Infobox Title", "pointfindert2d"),
						"param_name" => "box_title",
						"admin_label" => true
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Title Color', 'pointfindert2d'),
						"param_name" => "box_title_color",
						"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Title Hover Color', 'pointfindert2d'),
						"param_name" => "box_title_hover_color",
						"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					  array(
						"type" => "pfa_numeric",
						"heading" => esc_html__('Title Text Size', 'pointfindert2d'),
						"param_name" => "box_title_textsize",
						"description" => esc_html__("Leave empty for use default size. (Optional)", "pointfindert2d"),
						"edit_field_class" => 'vc_col-sm-4 vc_column',
						"value"	=> 16
					  ),
					  array(
						"type" => "textarea_html",
						"class" => "box_content",
						"heading" => esc_html__("Infobox Content", "pointfindert2d"),
						"param_name" => "content",
						"value" => '<p>'.esc_html__("Box content goes here, click edit button to change this text.", "pointfindert2d").'</p>',
						"description" => esc_html__("Icon box content.", "pointfindert2d")
					  ),
					  array(
						"type" => "pfa_numeric",
						"heading" => esc_html__('Content Text Size', 'pointfindert2d'),
						"param_name" => "box_content_textsize",
						"description" => esc_html__("Leave empty for use default size. (Optional)", "pointfindert2d"),
						"value"	=> 13,
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Content Background', 'pointfindert2d'),
						"param_name" => "box_content_bg_color",
						"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					  array(
						"type" => "colorpicker",
						"heading" => esc_html__('Content Border Color', 'pointfindert2d'),
						"param_name" => "box_content_border_color",
						"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
						"edit_field_class" => 'vc_col-sm-4 vc_column'
					  ),
					  
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Title & Content Text Align", "pointfindert2d"),
						"param_name" => "icon_box_align",
						"value" => array(esc_html__("Left", "pointfindert2d") => "left", esc_html__("Center", "pointfindert2d") => "center", esc_html__("Right", "pointfindert2d") => "right"),
						"dependency" => array('element' => "iconbox_style", 'value' => array('type2','type3','type4','type5')),
						
					  ),
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Infobox Background Transparency", "pointfindert2d"),
						"param_name" => "box_bg_opacity",
						"value" => array(
						 esc_html__("No Transparency", "pointfindert2d") => "1",
						 esc_html__("%100", "pointfindert2d") => "0",
						 esc_html__("%90", "pointfindert2d") => "0.1",
						 esc_html__("%80", "pointfindert2d") => "0.2",
						 esc_html__("%70", "pointfindert2d") => "0.3",
						 esc_html__("%60", "pointfindert2d") => "0.4",
						 esc_html__("%50", "pointfindert2d") => "0.5",
						 esc_html__("%40", "pointfindert2d") => "0.6",
						 esc_html__("%30", "pointfindert2d") => "0.7",
						 esc_html__("%20", "pointfindert2d") => "0.8",
						 esc_html__("%10", "pointfindert2d") => "0.9",
						 
						 ),
						"description" => esc_html__("Please select a transparency value if want to use for background. (Optional) %100 = transparent bg", "pointfindert2d"),
						"dependency" => array('element' => "iconbox_style", 'value' => array('type2','type3','type4','type5')),
						
					  ),
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("On click", "pointfindert2d"),
						"param_name" => "onclick",
						"value" => array(esc_html__("Do nothing", "pointfindert2d") => "link_no", esc_html__("Open custom link", "pointfindert2d") => "custom_link"),
						"description" => esc_html__("Define action for onclick event if needed.", "pointfindert2d")
					  ),
					  array(
						"type" => "vc_link",
						"heading" => esc_html__("URL (Link)", "pointfindert2d"),
						"param_name" => "link",
						"description" => esc_html__("Infobox link url.", "pointfindert2d"),
						"dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
					  ),
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Read More: Add to Box", "pointfindert2d"),
						"param_name" => "readmore",
						"value" => array(esc_html__("No Text", "pointfindert2d") => "text_no", esc_html__("Yes, I want to use it.", "pointfindert2d") => "text_link"),
						"description" => esc_html__("Are you want to put a read more text below the box?", "pointfindert2d")
					  ),
					  array(
						"type" => "textfield",
						"heading" => esc_html__("Read More: Text", "pointfindert2d"),
						"param_name" => "readmore_text",
						"value" => 'Read more',
						"description" => esc_html__("Please enter read more text", "pointfindert2d"),
						"dependency" => array('element' => "readmore", 'value' => array('text_link'))
					  ),
					  
				)
				) 
			);
		/** 
		*End : Info Box ---------------------------------------------------------------------------------------------------- 
		**/
		
		

		/** 
		*Start : Testimonials ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
			"name" => esc_html__("PF Testimonials", 'pointfindert2d'),
			"base" => "pf_testimonials",
			"icon" => "pfaicon-chat-empty"/*pfadmicon-glyph-381*/,
			"category" => esc_html__("Point Finder", "pointfindert2d"),
			"description" => esc_html__('Testimonial shortcut', 'pointfindert2d'),
			"params" => array(
					  array(
						"type" => "textfield",
						"heading" => esc_html__("Widget title", "pointfindert2d"),
						"param_name" => "title",
						"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", "pointfindert2d"),
						"admin_label" => true
					  ),
					  array(
						"type" => "textfield",
						"heading" => esc_html__("Slides count", "pointfindert2d"),
						"param_name" => "count",
						"description" => esc_html__('How many slides to show? Enter number or word "All" or Enter "1" for disable slider and show only one item.', "pointfindert2d"),
						"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					  array(
						  "type" => "textfield",
						  "heading" => esc_html__("Slider speed", "pointfindert2d"),
						  "param_name" => "interval",
						  "value" => "5000",
						  "description" => esc_html__("Duration of animation between slides (in ms)", "pointfindert2d"),
						  "edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					  array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Slider Effect", "pointfindert2d"),
						  "param_name" => "mode",
						  "value" => array(esc_html__("Fade", "pointfindert2d") => 'fade', esc_html__("Back Slide", "pointfindert2d") => 'backSlide'),
					  ),
					  array(
						"type" => "textfield",
						"heading" => esc_html__("Testimonial IDs", "pointfindert2d"),
						"param_name" => "posts_in",
						"description" => esc_html__('Fill this field with testimonial item IDs separated by commas (,), to retrieve only them. Use this in conjunction with "PF Testimonials" field.', "pointfindert2d")
					  ),
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Order by", "pointfindert2d"),
						"param_name" => "orderby",
						"value" => array( "", esc_html__("Date", "pointfindert2d") => "date", esc_html__("ID", "pointfindert2d") => "ID", esc_html__("Author", "pointfindert2d") => "author", esc_html__("Title", "pointfindert2d") => "title", esc_html__("Modified", "pointfindert2d") => "modified", esc_html__("Random", "pointfindert2d") => "rand", esc_html__("Comment count", "pointfindert2d") => "comment_count", esc_html__("Menu order", "pointfindert2d") => "menu_order" ),
						"description" => sprintf(esc_html__('Select how to sort retrieved posts. More at %s.', 'pointfindert2d'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
						"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
					  array(
						"type" => "dropdown",
						"heading" => esc_html__("Order", "pointfindert2d"),
						"param_name" => "order",
						"value" => array( esc_html__("Descending", "pointfindert2d") => "DESC", esc_html__("Ascending", "pointfindert2d") => "ASC" ),
						"description" => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'pointfindert2d'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
						"edit_field_class" => 'vc_col-sm-6 vc_column'
					  ),
				)
				) 
			);
		/** 
		*End : Testimonials ---------------------------------------------------------------------------------------------------- 
		**/




		/** 
		*Start : Directory List ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
				"name" => esc_html__("PF Directory List", 'pointfindert2d'),
				"base" => "pf_dlist_widget",
				"icon" => "pfaicon-chat-empty",
				"category" => esc_html__("Point Finder", "pointfindert2d"),
				"description" => esc_html__("Directory List Widget", 'pointfindert2d'),
				"params" => array(
						array(
						  "type" => "pf_info_line_vc_field",
						  "heading" => esc_html__("If want to change main category colors please visit Listing Types > Category edit. You will find icon upload and color options.", "pointfindert2d"),
						  "param_name" => "informationfield",
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field5",
						 ),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
						  "param_name" => "cols",
						  "value" => array('4 Columns'=>'4','3 Columns'=>'3','2 Columns'=>'2','1 Column'=>'1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order By", "pointfindert2d"),
						  "param_name" => "orderby",
						  "value" => array('name'=>'name','id'=>'id','count'=>'count'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order", "pointfindert2d"),
						  "param_name" => "order",
						  "value" => array('ASC'=>'ASC','DESC'=>'DESC'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field1",
						 ),
						array(
						  "type" => "pfa_select2",
						  "heading" => esc_html__("Excluding Categories", "pointfindert2d"),
						  "param_name" => "excludingcats",
						  "value" => $PFVEX_GetTaxValues1,
						  "description"=>esc_html__('These categories will be hidden. (optional)','pointfindert2d')
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field2",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Categories for Main Category', 'pointfindert2d' ),
							'param_name' => 'hideemptyformain',
							'description' => esc_html__( 'If "YES", empty categories will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),

						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Categories for Sub Category', 'pointfindert2d' ),
							'param_name' => 'hideemptyforsub',
							'description' => esc_html__( 'If "YES", empty categories will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field3",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Main Categories', 'pointfindert2d' ),
							'param_name' => 'showcountmain',
							'description' => esc_html__( 'If "YES", category count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Sub Categories', 'pointfindert2d' ),
							'param_name' => 'showcountsub',
							'description' => esc_html__( 'If "YES", category count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field4",
						 ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. BG Color', 'pointfindert2d'),
							"param_name" => "subcatbgcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Hover Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor2",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field6",
						 ),
						
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Sub Category Limit", "pointfindert2d"),
						  "param_name" => "subcatlimit",
						  "description"=>esc_html__('How many sub categories will be visible.','pointfindert2d'),
						  "value" => array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','30'=>'30','40'=>'40','50'=>'50'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
							"type" => "checkbox",
							"heading" => esc_html__('View All Link', 'pointfindert2d'),
							"param_name" => "viewalllink",
							"description" => esc_html__("Do you want to see View All link?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
						array(
							"type" => "checkbox",
							"heading" => esc_html__('Title Uppercase', 'pointfindert2d'),
							"param_name" => "titleuppercase",
							"description" => esc_html__("Do you want to see uppercase titles?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
					)
				)
			);
		/** 
		*End : Directory List ---------------------------------------------------------------------------------------------------- 
		**/


		/** 
		*Start : Search ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
				"name" => esc_html__("PF Search", 'pointfindert2d'),
				"base" => "pf_searchw",
				"icon" => "pfaicon-chat-empty",
				"category" => esc_html__("Point Finder", "pointfindert2d"),
				"description" => esc_html__("Search Widget", 'pointfindert2d'),
				"params" => array(
						array(
						  "type" => "pf_info_line_vc_field",
						  "heading" => esc_html__("Please do not try to use Mini Search with other search elements at the same page.", "pointfindert2d"),
						  "param_name" => "informationfield",
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field1",
						 ),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Search Field Columns", "pointfindert2d"),
						  "param_name" => "minisearchc",
						  "value" => array('1 Column'=>'1','2 Columns'=>'2','3 Columns'=>'3'),	
						  "edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Container Background Color', 'pointfindert2d'),
							"param_name" => "mini_bg_color",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Search Button Background Color', 'pointfindert2d'),
							"param_name" => "searchbg",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Search Button Text Color', 'pointfindert2d'),
							"param_name" => "searchtext",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						  ),
						
						 array(
							"type" => "pfa_numeric",
							"heading" => esc_html__("Container Padding (Top & Bottom)", "pointfindert2d"),
							"param_name" => "mini_padding_tb",
							"description" => esc_html__("Please write a padding value (px) (Optional) (Numeric only)", "pointfindert2d"),
							"value"	=> '0',
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						  ),
						 array(
							"type" => "pfa_numeric",
							"heading" => esc_html__("Container Padding ( Left & Right )", "pointfindert2d"),
							"param_name" => "mini_padding_lr",
							"description" => esc_html__("Please write a padding value (px) (Optional) (Numeric only)", "pointfindert2d"),
							"value"	=> '0',
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						  )
					)
				)
			);
		/** 
		*End : Search ---------------------------------------------------------------------------------------------------- 
		**/	


		/** 
		*Start : Location List ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
				"name" => esc_html__("PF Location List", 'pointfindert2d'),
				"base" => "pf_llist_widget",
				"icon" => "pfaicon-chat-empty",
				"category" => esc_html__("Point Finder", "pointfindert2d"),
				"description" => esc_html__("Location List Element", 'pointfindert2d'),
				"params" => array(
						array(
						  "type" => "pf_info_line_vc_field",
						  "heading" => esc_html__("If want to change main category colors please visit Locations > Category edit. You will find color options.", "pointfindert2d"),
						  "param_name" => "informationfield",
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field5",
						 ),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
						  "param_name" => "cols",
						  "value" => array('4 Columns'=>'4','3 Columns'=>'3','2 Columns'=>'2','1 Column'=>'1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order By", "pointfindert2d"),
						  "param_name" => "orderby",
						  "value" => array('name'=>'name','id'=>'id','count'=>'count'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order", "pointfindert2d"),
						  "param_name" => "order",
						  "value" => array('ASC'=>'ASC','DESC'=>'DESC'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field1",
						 ),
						array(
						  "type" => "pfa_select2",
						  "heading" => esc_html__("Excluding Locations", "pointfindert2d"),
						  "param_name" => "excludingcats",
						  "value" => $PFVEX_GetTaxValues1,
						  "description"=>esc_html__('These locations will be hidden. (optional)','pointfindert2d')
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field2",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Locations for Main Locations', 'pointfindert2d' ),
							'param_name' => 'hideemptyformain',
							'description' => esc_html__( 'If "YES", empty locations will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),

						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Locations for Sub Locations', 'pointfindert2d' ),
							'param_name' => 'hideemptyforsub',
							'description' => esc_html__( 'If "YES", empty locations will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field3",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Main Locations', 'pointfindert2d' ),
							'param_name' => 'showcountmain',
							'description' => esc_html__( 'If "YES", location count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Sub Locations', 'pointfindert2d' ),
							'param_name' => 'showcountsub',
							'description' => esc_html__( 'If "YES", location count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field4",
						 ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. BG Color', 'pointfindert2d'),
							"param_name" => "subcatbgcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Hover Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor2",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field6",
						 ),
						
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Sub Location Limit", "pointfindert2d"),
						  "param_name" => "subcatlimit",
						  "description"=>esc_html__('How many sub categories will be visible.','pointfindert2d'),
						  "value" => array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
							"type" => "checkbox",
							"heading" => esc_html__('View All Link', 'pointfindert2d'),
							"param_name" => "viewalllink",
							"description" => esc_html__("Do you want to see View All link?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
						array(
							"type" => "checkbox",
							"heading" => esc_html__("Title Uppercase", 'pointfindert2d'),
							"param_name" => "titleuppercase",
							"description" => esc_html__("Do you want to see uppercase titles?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
					)
				)
			);
		/** 
		*End : Location List ---------------------------------------------------------------------------------------------------- 
		**/
	}
	add_action('admin_init','PFVC_Add_custompf_fields');