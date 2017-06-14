<?php 
get_header();
	
	global $wp_query;
	global $post_type;
	$pf_category = 0;
	
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

	if(isset($wp_query->query_vars['tag_id'])){
		$tag_id = $wp_query->query_vars['tag_id'];
		$customquery = new WP_Query( array( "post_type" => $setup3_pointposttype_pt1, "tag_id" => $tag_id ) );
		wp_reset_postdata();
		if ($customquery->found_posts > 0) {
				
				$term_slug = $wp_query->query_vars['tag'];
				$pf_category = 1;
				$get_termname = $wp_query->query_vars['tag'];

				$get_term_nameforlink = '<a href="'.get_term_link( $wp_query->query_vars['tag_id'], 'post_tag' ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $get_termname) ) . '">'.$get_termname.'</a>';

				$filter_text = 'tag = "'.$tag_id.'"';;
		}
	}
	
	
	
	
	
	if ($pf_category == 0) {
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

	}else{

        $setup_item_catpage_sidebarpos = PFASSIssetControl('setup_item_catpage_sidebarpos','','2');
        
		if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader(array('taxname' => urldecode($get_termname),'taxnamebr' => $get_term_nameforlink,'taxinfo'=>''));}
		$setup42_authorpagedetails_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
		$setup42_authorpagedetails_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');

		$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','Date');
		$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','DESC');
		$setup22_searchresults_defaultlistingtype = PFSAIssetControl('setup22_dlcfc','','3');

		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		$setup42_authorpagedetails_grid_layout_mode = ($setup42_authorpagedetails_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;
		$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#ffffff');
		$setup22_searchresults_status_catfilters = PFSAIssetControl('setup22_searchresults_status_catfilters','','1');
		
		if ($setup22_searchresults_status_catfilters == 1) {
			$filters_text = 'true';
		}else{
			$filters_text = 'false';
		}

		$listing_cat_filter = (PFASSIssetControl('setup_gridsettings_ltype_filter','',0) == 1)?'yes':'';
		$item_cat_filter = (PFASSIssetControl('setup_gridsettings_itype_filter','',0) == 1)?'yes':'';
		$loc_cat_filter = (PFASSIssetControl('setup_gridsettings_location_filter','',0) == 1)?'yes':'';

			echo '<section role="main">';
		        echo '<div class="pf-page-spacing"></div>';
		        echo '<div class="pf-container"><div class="pf-row clearfix">';
		        	if ($setup_item_catpage_sidebarpos == 3) {
		        		echo '<div class="col-lg-12"><div class="pf-page-container">';
							echo do_shortcode('[pf_itemgrid2 listingtypefilters="'.$listing_cat_filter.'" itemtypefilters="'.$item_cat_filter.'" locationfilters="'.$loc_cat_filter.'" orderby="'.$setup22_searchresults_defaultsortbytype.'" sortby="'.$setup22_searchresults_defaultsorttype.'" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="'.$filters_text.'" itemboxbg="'.$setup22_searchresults_background2.'" '.$filter_text.']' );
						echo '</div></div>';
		        	}else{
		        		if($setup_item_catpage_sidebarpos == 1){
			                echo '<div class="col-lg-3 col-md-4">';
			                    get_sidebar('itemcats' ); 
			                echo '</div>';
			            }
			              
			            echo '<div class="col-lg-9 col-md-8"><div class="pf-page-container">'; 
			            
			            echo do_shortcode('[pf_itemgrid2 listingtypefilters="'.$listing_cat_filter.'" itemtypefilters="'.$item_cat_filter.'" locationfilters="'.$loc_cat_filter.'" orderby="'.$setup22_searchresults_defaultsortbytype.'" sortby="'.$setup22_searchresults_defaultsorttype.'" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="'.$filters_text.'" itemboxbg="'.$setup22_searchresults_background2.'" '.$filter_text.']' );

			            echo '</div></div>';
			            if($setup_item_catpage_sidebarpos == 2){
			                echo '<div class="col-lg-3 col-md-4">';
			                    get_sidebar('itemcats' );
			                echo '</div>';
			            }
		        	}
		            
		        echo '</div></div>';
		        echo '<div class="pf-page-spacing"></div>';
		    echo '</section>';
	}


get_footer();
?>