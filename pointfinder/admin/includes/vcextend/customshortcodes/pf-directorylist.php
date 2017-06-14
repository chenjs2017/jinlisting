<?php
add_shortcode( 'pf_dlist_widget', 'pf_dlist_widget_func' );
function pf_dlist_widget_func( $atts ) {
	$output = $title = $number = $el_class = '';
	extract( shortcode_atts( array(
		'cols' => 4,
		'order' => 'ASC',
		'orderby' => 'name',
		'excludingcats' => array(),
		'hideemptyformain' => '',
		'hideemptyforsub' => '',
		'showcountmain' => false,
		'showcountsub' => false,
		'subcatbgcolor' => '#fafafa',
		'subcattextcolor' => '#494949',
		'subcattextcolor2' => '#000',
		'viewalllink' => '',
		'titleuppercase' => '',
		'subcatlimit' => 0,
	), $atts ) );
	

	switch ($cols) {
		case 4:
			$cols_output = 'col-lg-3 col-md-4 col-sm-6 col-xs-12';
			break;
		case 3:
			$cols_output = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
			break;
		case 2:
			$cols_output = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
			break;
		case 1:
			$cols_output = 'col-lg-12';
			break;
		
		default:
			$cols_output = 'col-lg-3 col-md-4 col-sm-6 col-xs-12';
			break;
	}

	if ($hideemptyformain == 'yes') {$hideemptyformain = true;}else{$hideemptyformain = false;}
	if ($hideemptyforsub == 'yes') {$hideemptyforsub = true;}else{$hideemptyforsub = false;}
	if ($showcountsub == 'yes') {$show_count_child = 1;}else{$show_count_child = 0;}
	if ($showcountmain == 'yes') {$show_count_main = 1;}else{$show_count_main = 0;}
	if ($viewalllink == 'yes') {$show_viewall_child = 1;}else{$show_viewall_child = 0;}

	if($subcatlimit != 0){$subcat_limit = $subcatlimit - 1;}else{$subcat_limit = 0;}
	$title_uppercase = $titleuppercase;


	/*Extra Styles*/
	$style_text_main = $style_text_child =' style="';

		$style_text_main .= 'font-weight:bold;';
		$style_text_child .= 'font-weight:normal;background-color:'.$subcatbgcolor.';color:'.$subcattextcolor.';';

		if ($title_uppercase == 1) {
			$style_text_main .= 'text-transform:uppercase;';
			$style_text_child .= 'text-transform:none;';
		}

	$style_text_child .= $style_text_main .= '"';


	$taxonomies = array( 
	    'pointfinderltypes'
	);
	if (!empty($excludingcats)) {
		$excludingcats = pfstring2BasicArray($excludingcats);
	}
	$args = array(
	    'orderby'           => $orderby, 
	    'order'             => $order,
	    'hide_empty'        => $hideemptyformain, 
	    'exclude'           => array(), 
	    'exclude_tree'      => $excludingcats, 
	    'include'           => array(),
	    'number'            => '', 
	    'fields'            => 'all', 
	    'slug'              => '',
	    'parent'            => '',
	    'hierarchical'      => true, 
	    'child_of'          => 0, 
	    'get'               => '', 
	    'name__like'        => '',
	    'description__like' => '',
	    'pad_counts'        => true, 
	    'offset'            => '', 
	    'search'            => '', 
	    'cache_domain'      => 'core',
	    'pointfinder'		=> 'directorylist'
	); 

	$listing_terms = get_terms($taxonomies, $args);
	$listing_meta = get_option('pointfinderltypes_vars');

	$output = '<div class="vc_wp_posts wpb_content_element'.$el_class.'">';

	if ( ! empty( $listing_terms ) && ! is_wp_error( $listing_terms ) ) {
	    $count = count( $listing_terms );
	    $i = 0;
	    $term_list = '<ul class="pointfinder-terms-archive pf-row">';
		    foreach ( $listing_terms as $term ) {
		        if ($term->parent == 0) {

		        	/*get term specifications*/
		        	$style_text_main_custom = $iconimage_url = $this_term_icon = $this_term_catbg = $this_term_cattext = $this_term_cattext2 = $this_term_iconwidth = $hover_text = '';

		        	if (isset($listing_meta[$term->term_id])) {
		        		$this_term_icon = (isset($listing_meta[$term->term_id]['pf_icon_of_listing']))? $listing_meta[$term->term_id]['pf_icon_of_listing']:'';
		        		$this_term_iconwidth = (isset($listing_meta[$term->term_id]['pf_iconwidth_of_listing']))? $listing_meta[$term->term_id]['pf_iconwidth_of_listing']:'';
		        		$this_term_catbg = (isset($listing_meta[$term->term_id]['pf_catbg_of_listing']))? $listing_meta[$term->term_id]['pf_catbg_of_listing']:'#ededed';
		        		$this_term_cattext = (isset($listing_meta[$term->term_id]['pf_cattext_of_listing']))? $listing_meta[$term->term_id]['pf_cattext_of_listing']:'#494949';
		        		$this_term_cattext2 = (isset($listing_meta[$term->term_id]['pf_cattext2_of_listing']))? $listing_meta[$term->term_id]['pf_cattext2_of_listing']:'#000';

		        		if (empty($this_term_iconwidth)) {
		        			$this_term_iconwidth = 20;
		        		}
		        		/*icon*/
		        		if (!empty($this_term_icon) && is_array($this_term_icon)) {
		        			$iconimage = wp_get_attachment_image_src($this_term_icon[0], 'full');
		        			$iconimage_url = '<span class="pf-main-term-icon"><img src="'.$iconimage[0].'" width="'.$this_term_iconwidth.'"></span>';
		        		}

		        		$style_text_main_custom .=' style="';
		        		$style_text_main_custom .= 'background-color:'.$this_term_catbg.';';
		        		$style_text_main_custom .= 'color:'.$this_term_cattext.';';

		        		$hover_text = ' data-hovercolor="'.$this_term_cattext2.'" data-standartc="'.$this_term_cattext.'"';
		        		
		        		$style_text_main_custom .='"';
		        	}



		        	$term_list .= '<li class="pf-grid-item '.$cols_output.' pf-main-term"'.$style_text_main.'>';
		        	$term_list .= '<a href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all posts under %s', 'pointfindert2d' ), $term->name ) . '"'.$style_text_main_custom.''.$hover_text.'>'. $iconimage_url . $term->name . ' ';
		        	if ($show_count_main == 1) {
		        	$term_list .= '<span class="pull-right pf-main-term-number">('.$term->count.')</span>';
		        	}
		        	$term_list .= '</a>';
		        	
		        	/* Check term childs */

		        		$k = 0;
		        		$term_list_ex = '';
		        		if ($subcat_limit > 0) {
			        		$args_sub = array(
							    'orderby'           => $orderby, 
		   						'order'             => $order,
							    'hide_empty'        => $hideemptyforsub, 
							    'exclude'           => array(), 
							    'exclude_tree'      => array(), 
							    'include'           => array(),
							    'number'            => '', 
							    'fields'            => 'all', 
							    'slug'              => '',
							    'parent'            => $term->term_id,
							    'hierarchical'      => true, 
							    'child_of'          => '', 
							    'get'               => '', 
							    'name__like'        => '',
							    'description__like' => '',
							    'pad_counts'        => true, 
							    'offset'            => '', 
							    'search'            => '', 
							    'cache_domain'      => 'core',
    							'pointfinder'		=> 'directorylist'
							); 
			        		$listing_terms_child = get_terms($taxonomies, $args_sub);
			        		foreach ($listing_terms_child as $term_child) {

			        			if($k <= $subcat_limit){
			        				

			        				$args_sub_sub = array(
									    'orderby'           => $orderby, 
				   						'order'             => $order,
									    'hide_empty'        => $hideemptyforsub, 
									    'exclude'           => array(), 
									    'exclude_tree'      => array(), 
									    'include'           => array(),
									    'number'            => '', 
									    'fields'            => 'all', 
									    'slug'              => '',
									    'parent'            => $term_child->term_id,
									    'hierarchical'      => true, 
									    'child_of'          => '', 
									    'get'               => '', 
									    'name__like'        => '',
									    'description__like' => '',
									    'pad_counts'        => true, 
									    'offset'            => '', 
									    'search'            => '', 
									    'cache_domain'      => 'core',
		    							'pointfinder'		=> 'directorylist'
									); 
			        				$listing_terms_child_child = get_terms($taxonomies, $args_sub_sub);
			        				
			        				if (isset($listing_terms_child_child->count)) {
			        					$current_subtermcount = (int)$term_child->count + (int)$listing_terms_child_child->count;
			        				}else{
			        					$current_subtermcount = (int)$term_child->count;
			        				}
			        				

			        				$term_list_ex .= '<li class="pf-child-term"'.$style_text_child.'>';
			        				$term_list_ex .= '<a href="' . get_term_link( $term_child ) . '" title="' . sprintf( __( 'View all posts under %s', 'pointfindert2d' ), $term_child->name ) . '" data-hovercolor="'.$subcattextcolor2.'" data-standartc="'.$subcattextcolor.'">' . $term_child->name . '</a>';
			        				if ($show_count_child == 1) {
			        					$term_list_ex .= '<span class="pull-right">('.$current_subtermcount.')</span>';
			        				}
			        				$term_list_ex .= '</li>';
			        				$k++;
			        			};
			        		}
		        		}
		        		if ($k > 0) {
		        			$term_list .= '<ul class="pf-child-term-main">';
		        			$term_list .= $term_list_ex;
		        			if ($show_viewall_child == 1) {
		        				$term_list .= '<li class="pf-child-term pf-child-term-viewall"'.$style_text_child.'><a href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all posts under %s', 'pointfindert2d' ), $term->name ) . '" data-hovercolor="'.$subcattextcolor2.'" data-standartc="'.$subcattextcolor.'">' . esc_html__('View All','pointfindert2d') . '</a></li>';
		        			}
		        			$term_list .= '</ul>';
		        		}

		        	$term_list .= '</li>';
		        }
		    }
	    $term_list .= '</ul>';
	    $term_list .= '</div>';

	    $output .=  $term_list;
	}
	if ($cols != 1) {
		$output .= '
		<script>
		(function($) {
		  	"use strict";
				$(document).ready( function() {

				  $(".pointfinder-terms-archive").isotope({
				  	layoutMode: "fitRows",
				    itemSelector: ".pf-grid-item",
				    percentPosition: false
				  });

				});
		})(jQuery);
		</script>
		';
	}

	
	return $output;
}