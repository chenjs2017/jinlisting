<?php
/**********************************************************************************************************************************
*
* VC Mutate Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

function pf_vc_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'pf_vc_remove_wp_admin_bar_button' );

function pf_vc_remove_frontend_links() {
    vc_disable_frontend(); 
}
add_action( 'vc_after_init', 'pf_vc_remove_frontend_links' );


//VC Fix classes.
function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag) {
  if ($tag=='vc_column' || $tag=='vc_column_inner' || $tag=='vc_row' || $tag=='vc_row_inner') {
  $class_string = preg_replace('/vc_col-sm-(\d{1,2})/', 'col-lg-$1 col-md-$1', $class_string);
  $class_string = preg_replace('/vc_span(\d{1,2})/', 'col-lg-$1 col-md-$1', $class_string);
  $class_string = preg_replace('/vc_column_container/', '', $class_string);
  }

  return $class_string;
}
add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);

add_action( 'vc_before_init', 'pf_vc_remove_all_pointers' );
function pf_vc_remove_all_pointers() {
   remove_action( 'admin_enqueue_scripts', 'vc_pointer_load' );
}


if(is_admin()){	
	$vc_layout_sub_controls = array(
	  array('link_post', esc_html__("Link to post", "pointfindert2d")),
	  array("no_link", esc_html__("No link", "pointfindert2d")),
	  array("link_image", esc_html__("Link to bigger image", "pointfindert2d"))
	);
	  
	vc_remove_element("vc_wp_links");
	vc_remove_element("vc_wp_meta");
	vc_remove_element("vc_wp_text");
	vc_remove_element("vc_wp_rss");
	vc_remove_element("vc_wp_pages");
	vc_remove_element("vc_wp_archives");
	vc_remove_element("vc_wp_posts");
	vc_remove_element("vc_wp_tagcloud");
	vc_remove_element("vc_wp_recentcomments");
	vc_remove_element("vc_wp_categories");
	vc_remove_element("vc_wp_calendar");
	vc_remove_element("vc_wp_custommenu");
	vc_remove_element("vc_wp_search");
	
	// REMOVE & ADD PARAMS VC
	
	//Row Modifications 
	vc_add_param('vc_row',
		  array(
			  "type" => 'checkbox',
			  "heading" => esc_html__("100% Width", "pointfindert2d"),
			  "param_name" => "widthopt",
			  "description" => esc_html__("Enables %100 width for this row.", "pointfindert2d"),
			  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
			  'save_always' => true
		  )
	);
	vc_add_param('vc_row',
		  array(
			  "type" => 'checkbox',
			  "heading" => esc_html__("Fixed Background", "pointfindert2d"),
			  "param_name" => "fixedbg",
			  "description" => esc_html__("This option enable fixed background if background image added from css design section.", "pointfindert2d"),
			  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
			  'save_always' => true
		  )
	);
	vc_add_param('vc_row',
		  array(
			  "type" => 'checkbox',
			  "heading" => esc_html__("Footer Row", "pointfindert2d"),
			  "param_name" => "footerrow",
			  "description" => esc_html__("If this row is footer. Please check this.", "pointfindert2d"),
			  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes'),
			  'save_always' => true
		  )
	);
	vc_add_param('vc_row',
		  array(
			"type" => "colorpicker",
			"heading" => esc_html__('Text Color', 'pointfindert2d'),
			"param_name" => "colorfortext",
			"dependency" => array('element' => 'footerrow','not_empty' => true),
			'save_always' => true
		  )
	);
	vc_add_param('vc_row',
		  array(
			"type" => "colorpicker",
			"heading" => esc_html__('Text Color Hover', 'pointfindert2d'),
			"param_name" => "colorfortexth",
			"dependency" => array('element' => 'footerrow','not_empty' => true),
			'save_always' => true
		  )
	);

	//Posts Slider  -------------------------------------------------------------------------------------------------------
		vc_remove_param('vc_posts_slider','el_class');
		vc_remove_param('vc_posts_slider','type');
		vc_remove_param('vc_posts_slider','posttypes');
		vc_remove_param('vc_posts_slider','thumb_size');
		vc_add_param('vc_posts_slider',
			  array(
				  "type" => "dropdown",
				  "heading" => esc_html__("Slider Effect", "pointfindert2d"),
				  "param_name" => "mode",
				  "value" => array(esc_html__("Fade", "pointfindert2d") => 'fade', esc_html__("Fade Up", "pointfindert2d") => 'fadeUp',esc_html__("Back Slide", "pointfindert2d") => 'backSlide', esc_html__("Go Down", "pointfindert2d") => 'goDown'),
				  "description" => esc_html__("If slider enabled (1 Column) You can select a transition effect for it.", "pointfindert2d")
			  )
		);
		vc_add_param('vc_posts_slider',
			  array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Slider autoplay", "pointfindert2d"),
				  "param_name" => "autoplay",
				  "description" => esc_html__("Enables autoplay mode.", "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		vc_add_param('vc_posts_slider',
			  array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Hide pagination control", "pointfindert2d"),
				  "param_name" => "hide_pagination_control",
				  "description" => esc_html__("If YES pagination control will be removed.", "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		vc_add_param('vc_posts_slider',
			  array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Hide prev/next buttons", "pointfindert2d"),
				  "param_name" => "hide_prev_next_buttons",
				  "description" => esc_html__('If "YES" prev/next control will be removed.', "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		vc_add_param('vc_posts_slider',
			  array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Numbered Pagination Controls", "pointfindert2d"),
				  "param_name" => "numbered_pagination",
				  "description" => esc_html__("Enables numbered pagination mode. ! Pagination controls must be enabled.", "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		WPBMap::mutateParam('vc_posts_slider',
			array(
				  "type" => "textfield",
				  "heading" => esc_html__("Slider speed", "pointfindert2d"),
				  "param_name" => "interval",
				  "value" => "5000",
				  "description" => esc_html__("Duration of animation between slides (in ms)", "pointfindert2d")
			  )
		);
		WPBMap::mutateParam('vc_posts_slider',
			array(
				"type" => "textfield",
				"heading" => esc_html__("Widget title", "pointfindert2d"),
				"param_name" => "title",
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", "pointfindert2d"),
				"admin_label" => true
			  )
		);

		WPBMap::mutateParam('vc_custom_heading',
			array(
	            'type' => 'font_container',
	            'param_name' => 'font_container',
	            'value'=>'',
	            'settings'=>array(
	                'fields'=>array(
	                    'tag'=>'h2', 
	                    'text_align',
	                    'font_size',
	                    'line_height',
	                    'color',
	                    'tag_description' => esc_html__('Select element tag.','pointfindert2d'),
	                    'text_align_description' => esc_html__('Select text alignment.','pointfindert2d'),
	                    'font_size_description' => esc_html__('Enter font size. Ex: 18','pointfindert2d'),
	                    'line_height_description' => esc_html__('Enter line height. Ex: 20px (You must enter px at the end of number)','pointfindert2d'),
	                    'color_description' => esc_html__('Select color for your element.','pointfindert2d'),
	                ),
	            ),
	        )
		);



		
		
		
	//Posts Grid -------------------------------------------------------------------------------------------------------
		vc_remove_param('vc_posts_grid','grid_thumb_size');
		vc_remove_param('vc_posts_grid','el_class');
		vc_add_param("vc_posts_grid", 
			array(
				  "type" => 'colorpicker',
				  "heading" => esc_html__("Post box background", "pointfindert2d"),
				  "param_name" => "itembox_bg",
				  "description" => esc_html__("Optional: You can select a color for item box background.", "pointfindert2d"),
				  "value" => ''
			  )
		);
		vc_add_param("vc_posts_grid", 
			array(
				  "type" => 'colorpicker',
				  "heading" => esc_html__("Post box font color", "pointfindert2d"),
				  "param_name" => "itembox_font",
				  "description" => esc_html__("Optional: You can select a color for item box font.", "pointfindert2d"),
				  "value" => ''
			  )
		);
		WPBMap::mutateParam('vc_posts_grid',
			array(
				"type" => "loop",
				"heading" => esc_html__("Carousel content", "pointfindert2d"),
				"param_name" => "loop",
				'settings' => array(
				  'size' => array('hidden' => false, 'value' => 10),
				  'post_type' => array('hidden' => true, 'value' => 'post'),
				  'tax_query' => array('hidden' => true),
				  'by_id' => array('hidden' => true),
				  'order_by' => array('value' => 'date'),
				  'order' => array('value' => 'DESC')
				),
				"description" => esc_html__("Create WordPress loop, to populate content from your site.", "pointfindert2d"),
			)
		);
		WPBMap::mutateParam('vc_posts_grid',
			array(
				  "type" => "sorted_list",
				  "heading" => esc_html__("Teaser layout", "pointfindert2d"),
				  "param_name" => "grid_layout",
				  "description" => esc_html__("Control teasers look. Enable blocks and place them in desired order. Note: This setting can be overrriden on post to post basis.", "pointfindert2d"),
				  "value" => "image,title,bloginfo,text",
				  "options" => array(
					  array('image', esc_html__('Thumbnail', "pointfindert2d"), $vc_layout_sub_controls),
					  array('title', esc_html__('Title', "pointfindert2d"), $vc_layout_sub_controls),
					  array('text', esc_html__('Text', "pointfindert2d"), array(
						  array('excerpt', esc_html__('Teaser/Excerpt', "pointfindert2d")),
						  array('text', esc_html__('Full content', "pointfindert2d"))
					  )),
					  array('link', esc_html__('Read more link', "pointfindert2d")),
					  array('bloginfo', esc_html__('Blog info', "pointfindert2d"),array(
							array('date', esc_html__("Date Only", "pointfindert2d")),
							array("comments", esc_html__("Comments only", "pointfindert2d")),
							array("datecomments", esc_html__("Date + Comments", "pointfindert2d"))
						)
					  )
				  )
			  )
		);
		
	
	
	// Posts Carousel ---------------------------------------------------------------------------------------------------
		vc_remove_param("vc_carousel", "slides_per_view");
		vc_remove_param("vc_carousel", "partial_view");
		vc_remove_param("vc_carousel", "el_class");
		vc_remove_param("vc_carousel", "mode");
		vc_add_param("vc_carousel", 
			array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Numbered Pagination Controls", "pointfindert2d"),
				  "param_name" => "numbered_pagination",
				  "description" => esc_html__("Enables numbered pagination mode. ! Pagination controls must be enabled.", "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		vc_add_param("vc_carousel", 
			array(
				  "type" => 'colorpicker',
				  "heading" => esc_html__("Post box background", "pointfindert2d"),
				  "param_name" => "itembox_bg",
				  "description" => esc_html__("Optional: You can select a color for item box background.", "pointfindert2d"),
				  "value" => ''
			  )
		);
		vc_add_param("vc_carousel", 
			array(
				  "type" => 'colorpicker',
				  "heading" => esc_html__("Post box font color", "pointfindert2d"),
				  "param_name" => "itembox_font",
				  "description" => esc_html__("Optional: You can select a color for item box font.", "pointfindert2d"),
				  "value" => ''
			  )
		);
		WPBMap::mutateParam('vc_carousel',
			array(
				  "type" => "textfield",
				  "heading" => esc_html__("Slider speed", "pointfindert2d"),
				  "param_name" => "speed",
				  "value" => "300",
				  "description" => esc_html__("Duration of animation between slides (in ms)", "pointfindert2d")
			  )
		);
		
		WPBMap::mutateParam('vc_carousel',
			array(
				  "type" => "textfield",
				  "heading" => esc_html__("Widget title", "pointfindert2d"),
				  "param_name" => "title",
				  "description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", "pointfindert2d"),
				  "admin_label" => true
			  )
		);
		WPBMap::mutateParam('vc_carousel',
			array(
				"type" => "loop",
				"heading" => esc_html__("Carousel content", "pointfindert2d"),
				"param_name" => "posts_query",
				'settings' => array(
				  'size' => array('hidden' => false, 'value' => 10),
				  'post_type' => array('hidden' => true, 'value' => 'post'),
				  'tax_query' => array('hidden' => true),
				  'by_id' => array('hidden' => true),
				  'order_by' => array('value' => 'date'),
				  'order' => array('value' => 'DESC')
				),
				"description" => esc_html__("Create WordPress loop, to populate content from your site.", "pointfindert2d"),
			)
		);
		WPBMap::mutateParam('vc_carousel',
			array(
				  "type" => "sorted_list",
				  "heading" => esc_html__("Teaser layout", "pointfindert2d"),
				  "param_name" => "layout",
				  "description" => esc_html__("Control teasers look. Enable blocks and place them in desired order. Note: This setting can be overrriden on post to post basis.", "pointfindert2d"),
				  "value" => "image,title,bloginfo,text",
				  "options" => array(
					  array('image', esc_html__('Thumbnail', "pointfindert2d"), $vc_layout_sub_controls),
					  array('title', esc_html__('Title', "pointfindert2d"), $vc_layout_sub_controls),
					  array('text', esc_html__('Text', "pointfindert2d"), array(
						  array('excerpt', esc_html__('Teaser/Excerpt', "pointfindert2d")),
						  array('text', esc_html__('Full content', "pointfindert2d"))
					  )),
					  array('link', esc_html__('Read more link', "pointfindert2d")),
					  array('bloginfo', esc_html__('Blog info', "pointfindert2d"),array(
							array('date', esc_html__("Date Only", "pointfindert2d")),
							array("comments", esc_html__("Comments only", "pointfindert2d")),
							array("datecomments", esc_html__("Date + Comments", "pointfindert2d"))
						)
					  )
				  )
			  )
		);
		WPBMap::mutateParam('vc_carousel',
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Column Number", "pointfindert2d"),
				"param_name" => "thumb_size",
				"value" => array(esc_html__("5 Columns", "pointfindert2d") => "grid5", esc_html__("4 Columns - Default", "pointfindert2d") => "grid4",esc_html__("3 Columns", "pointfindert2d") => "grid3",esc_html__("2 Columns", "pointfindert2d") => "grid2"),
				"description" => esc_html__("How many item want to see in viewport? (On mobile and tablet it will resize auto.)", "pointfindert2d"),
			  )
		);
	
	
	
	
	
	// Image Carousel ---------------------------------------------------------------------------------------------------
		vc_remove_param("vc_images_carousel", "slides_per_view");
		vc_remove_param("vc_images_carousel", "partial_view");
		vc_remove_param("vc_images_carousel", "el_class");
		vc_remove_param("vc_images_carousel", "wrap");
		vc_add_param("vc_images_carousel", 
			array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Numbered Pagination Controls", "pointfindert2d"),
				  "param_name" => "numbered_pagination",
				  "description" => esc_html__("Enables numbered pagination mode. ! Pagination controls must be enabled.", "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		vc_add_param('vc_images_carousel',
			  array(
				  "type" => 'checkbox',
				  "heading" => esc_html__("Disable Auto Crop", "pointfindert2d"),
				  "param_name" => "autocrop",
				  "description" => esc_html__("Disables auto crop on image.(Not recommended.)", "pointfindert2d"),
				  "value" => Array(esc_html__("Yes, please", "pointfindert2d") => 'yes')
			  )
		);
		vc_add_param("vc_images_carousel", 
			array(
				  "type" => "textfield",
				  "heading" => esc_html__("Custom Size (Optional)", "pointfindert2d"),
				  "param_name" => "customsize",
				  "value" => "",
				  "description" => esc_html__("Ex: 300x200  | Custom size value (Optional). Please leave blank for auto resize. (in px)", "pointfindert2d")
			  )
		);
		WPBMap::mutateParam('vc_images_carousel',
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Items", "pointfindert2d"),
				"param_name" => "img_size",
				"value" => array(
				esc_html__("5 Item", "pointfindert2d") => "grid5", 
				esc_html__("4 Item - Default", "pointfindert2d") => "grid4",
				esc_html__("3 Item", "pointfindert2d") => "grid3",
				esc_html__("2 Item", "pointfindert2d") => "grid2",
				esc_html__("1 Item - (Slider Mode)", "pointfindert2d") => "grid1"
				),
				"description" => esc_html__("How many item want to see in viewport? (On mobile and tablet it will resize auto.)", "pointfindert2d"),
			  )
		);
		WPBMap::mutateParam('vc_images_carousel',
			array(
				  "type" => "dropdown",
				  "heading" => esc_html__("Slider Effect", "pointfindert2d"),
				  "param_name" => "mode",
				  "value" => array(esc_html__("Fade", "pointfindert2d") => 'fade', esc_html__("Fade Up", "pointfindert2d") => 'fadeUp',esc_html__("Back Slide", "pointfindert2d") => 'backSlide', esc_html__("Go Down", "pointfindert2d") => 'goDown'),
				  "description" => esc_html__("If slider enabled (1 Column) You can select a transition effect for it.", "pointfindert2d")
			  )
		);
	
	
	
	
	
	//  Gallery ---------------------------------------------------------------------------------------------------
		vc_remove_param("vc_gallery", "img_size");
		vc_remove_param("vc_gallery", "el_class");
		vc_remove_param("vc_gallery", "type");
		vc_remove_param("vc_gallery", "interval");
		vc_add_param("vc_gallery", 
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Column Number", "pointfindert2d"),
				"param_name" => "pfgrid",
				"value" => array(esc_html__("4 Columns - Default", "pointfindert2d") => "grid4",esc_html__("3 Columns", "pointfindert2d") => "grid3",esc_html__("2 Columns", "pointfindert2d") => "grid2"),
				"description" => esc_html__("How many column?", "pointfindert2d"),
			  )
		);
}
?>