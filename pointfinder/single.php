<?php 
get_header();

	$post_type = get_post_type();
	$post_id = get_the_id();

	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	$setup3_pointposttype_pt8 = PFSAIssetControl('setup3_pointposttype_pt8','','agents');
		
    switch ($post_type) {
		case $setup3_pointposttype_pt1: /*Items*/
			if ( have_posts() ){
			the_post();
				$post_status = get_post_status($post_id);

				$current_status_onoff = get_post_meta( $post_id, "pointfinder_item_onoffstatus", true );

				if ($post_status != 'publish' || !empty($current_status_onoff)) {
					PFPageNotFound();
				}else{
					echo '<div itemscope itemtype="http://schema.org/Product">';
					$item_term = pf_get_item_term_id($post_id);

					get_template_part('admin/estatemanagement/includes/pages/itemdetail/itempage','content');
						
					$setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
					$setup3_modulessetup_headersection = PFSAIssetControl('setup3_modulessetup_headersection','',1);

					$st8_nasys = PFASSIssetControl('st8_nasys','',0);
	
					if ( $st8_nasys == 1) {
						$listing_config_meta = get_option('pointfinderltypes_aslvars');
					}

					if (!empty($item_term)) {
						if ( $st8_nasys == 1) {
							if (isset($listing_config_meta[$item_term])) {
								if (!empty($listing_config_meta[$item_term]['pflt_advanced_status'])) {
									$setup3_modulessetup_headersection = $listing_config_meta[$item_term]['pflt_headersection']; 
								}
							}
						}else{
							if (PFADVIssetControl('setupadvancedconfig_'.$item_term.'_advanced_status','','0') == 1) {
								$setup3_modulessetup_headersection = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_headersection','','2');
							}
						}
					}

					if ($setup3_modulessetup_headersection == 1) {
						echo '<section role="itempagemapheader" class="pf-itempage-mapheader">';
						echo '<div class="pfheaderbarshadow2"></div>';
						echo '<div id="item-map-page"></div>';
						echo '</section>';
						$setup3_modulessetup_breadcrumbs = PFSAIssetControl('setup3_modulessetup_breadcrumbs','','1');
						if ($setup3_modulessetup_breadcrumbs == 1) {
							echo '<div class="pf-fullwidth pf-itempage-br-xm"><div class="pf-container"><div class="pf-row"><div class="col-lg-12">';
							$br_output = pf_the_breadcrumb();
							echo '<div class="pf-breadcrumbs pf-breadcrumbs-special">'.$br_output.'</div></div></div></div></div>';
		                }
						
					} elseif ($setup3_modulessetup_headersection == 0) {
						if(function_exists('PFGetDefaultPageHeader')){
							PFGetDefaultPageHeader(array('itemname' => get_the_title(), 'itemaddress' => esc_html(get_post_meta( get_the_id(), 'webbupointfinder_items_address', true ))));
						}
					}elseif ($setup3_modulessetup_headersection == 3){
						$header_image = get_post_meta( $post_id, 'webbupointfinder_item_headerimage', true );

						$header_image_url = $header_image_width = $header_image_height = '';

						if (!empty($header_image['url'])) {
							$header_image_url = $header_image['url'];
							$header_image_width = $header_image['width'];
							$header_image_height = $header_image['height'];
						}else{
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
							$header_image_url = $featured_image[0];
							$header_image_width = $featured_image[1];
							$header_image_height = $featured_image[2];
						}

						$postd_hideshow = PFSAIssetControl('postd_hideshow','',1);
						if ($postd_hideshow == 1) {
							$postd_text = ''.esc_html__('Posted on','pointfindert2d').' '.get_the_time(get_option('date_format')).' /';
						}else{
							$postd_text = '';
						}

						$verified_badge_text = "";

						$setup42_itempagedetails_claim_status = PFSAIssetControl('setup42_itempagedetails_claim_status','','0');
						$verified_badge_text = "";

						$listing_verified = get_post_meta( $post_id, 'webbupointfinder_item_verified', true );
						if($setup42_itempagedetails_claim_status == 1 && $listing_verified == 1 ){
							$setup42_itempagedetails_claim_validtext = PFSAIssetControl('setup42_itempagedetails_claim_validtext','','');
							$verified_badge_text = '<span class="pfverified-bagde-text"> <i class="pfadmicon-glyph-62" style="  color: #59C22F;font-size: 18px;"></i> '.$setup42_itempagedetails_claim_validtext.'</span>';

						}

						$item_old_count = get_post_meta( $post_id, 'webbupointfinder_page_itemvisitcount', true );




						echo '<section role="itempageimageheader" class="pf-itempage-imageheader pf-itempage-imageheaderheight" style="background-image: url('.$header_image_url.');">';

						echo '<div class="pf-container clearfix"><div class="pf-row"><div class="col-lg-12"><div class="pf-image-headercapts">';
						echo '
								<div class="pf-item-title-barimg">
									<span class="pf-item-title-textimg" itemprop="name">'.get_the_title().'</span>
									<span class="pf-item-subtitleimg"> '.esc_html(get_post_meta( $post_id, 'webbupointfinder_items_address', true )).'</span>
								</div>
								<div class="pf-item-extitlebarimg">
									<div class="pf-itemdetail-pdateimg">'.$postd_text.' <i class="pfadmicon-glyph-729"></i> '.$item_old_count.' '.$verified_badge_text.'</div>
								</div>'; 
						echo '</div></div></div></div>';

						echo '<div class="pfheaderbarshadow2 pf-itempage-imageheaderheight"></div>';
						echo '<div class="pfitempageimageheadsh pf-itempage-imageheaderheight"></div>';
						echo '<div id="item-image-page"></div>';
						echo '</section>';
						$setup3_modulessetup_breadcrumbs = PFSAIssetControl('setup3_modulessetup_breadcrumbs','','1');
						if ($setup3_modulessetup_breadcrumbs == 1) {
							echo '<div class="pf-fullwidth pf-itempage-br-xm"><div class="pf-container"><div class="pf-row"><div class="col-lg-12">';
							$br_output = pf_the_breadcrumb();
							echo '<div class="pf-breadcrumbs pf-breadcrumbs-special">'.$br_output.'</div></div></div></div></div>';
		                }
					}else{
						$setup3_modulessetup_breadcrumbs = PFSAIssetControl('setup3_modulessetup_breadcrumbs','','1');
						if ($setup3_modulessetup_breadcrumbs == 1) {
							echo '<div class="pf-fullwidth pf-itempage-br-xm pf-itempage-br-xm-nh"><div class="pf-container"><div class="pf-row"><div class="col-lg-12">';
							$br_output = pf_the_breadcrumb();
							echo '<div class="pf-breadcrumbs pf-breadcrumbs-special">'.$br_output.'</div></div></div></div></div>';
		                }
					}

					get_template_part('admin/estatemanagement/includes/pages/itemdetail/theme-map-scripts','itemdetail');

					$setup42_itempagedetails_sidebarpos = PFSAIssetControl('setup42_itempagedetails_sidebarpos','','2');


					
					
					if (!empty($item_term)) {
	
						if ( $st8_nasys == 1) {
							$pointfinder_customsidebar = '';
							if (isset($listing_config_meta[$item_term])) {
								if (!empty($listing_config_meta[$item_term]['pflt_advanced_status'])) {
									$pointfinder_customsidebar = $listing_config_meta[$item_term]['pflt_sidebar']; 
								}
							}
						}else{
							$pointfinder_customsidebar = PFADVIssetControl('setupadvancedconfig_'.$item_term.'_sidebar','','');
						}
						
					}else{
						$pointfinder_customsidebar = '';
					}
					

					echo '<section role="main" class="pf-itempage-maindiv">';
						echo '<div class="pf-container clearfix">';
						echo '<div class="pf-row clearfix">';
						if ($setup42_itempagedetails_sidebarpos == 2) {
							if(function_exists('PFGetItemPageCol1')){PFGetItemPageCol1();}
		              		if(function_exists('PFGetItemPageCol2')){PFGetItemPageCol2($pointfinder_customsidebar);}
						} elseif ($setup42_itempagedetails_sidebarpos == 1) {
							if(function_exists('PFGetItemPageCol2')){PFGetItemPageCol2($pointfinder_customsidebar);}
		              		if(function_exists('PFGetItemPageCol1')){PFGetItemPageCol1();}
						}else{
							if(function_exists('PFGetItemPageCol1')){PFGetItemPageCol1();}
						}
						
	                	echo '</div>';

	                	echo '<div class="pf-row clearfix">';
	                	$re_li_1 = PFSAIssetControl('re_li_1','','1');
						if ($re_li_1 == 1) {

							$re_li_3 = PFSAIssetControl('re_li_3','','1');

							$r_post_terms = '';
							$r_post_count = 0;

							$r_post_locs = '';

							/*Listing Type Filter*/
		                    $current_post_terms = get_the_terms( get_the_id(), 'pointfinderltypes');
		                    if (isset($current_post_terms) && $current_post_terms != false) {
		                        foreach ($current_post_terms as $current_post_term) {
		                            $r_post_terms .= $current_post_term->term_id.',';
		                            $r_post_count = $r_post_count + $current_post_term->count;
		                        }
		                        
		                    }

		                    /*Location Type Filter*/
		                    $setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
		                    if($setup3_pointposttype_pt5_check == 1 && $re_li_3 == 2){
		                    	$current_post_terms = get_the_terms( get_the_id(), 'pointfinderlocations');
			                    if (isset($current_post_terms) && $current_post_terms != false) {
			                        foreach ($current_post_terms as $current_post_term) {
			                            $r_post_locs .= $current_post_term->term_id.',';
			                        }
			                        
			                    }
		                    }
			                
							$re_li_2 = PFSAIssetControl('re_li_2','','1');


							/*Defaults*/
							$setup22_searchresults_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
							$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','ID');
							$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','ASC');
							$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#f7f7f7');
							$re_li_5 = PFSAIssetControl('re_li_5','',20);
							
							if ($re_li_2 == 1) {
								$relatex_listing_text = '[pf_pfitemcarousel listingtype="'.$r_post_terms.'" itemtype="" locationtype="'.$r_post_locs.'" itemlimit="'.$re_li_5.'" features="" orderby="'.$setup22_searchresults_defaultsortbytype.'" sortby="'.$setup22_searchresults_defaultsorttype.'" cols="4" itemboxbg="'.$setup22_searchresults_background2.'" related="1"]';
							}else{
								$relatex_listing_text = '[pf_itemgrid listingtype="'.$r_post_terms.'" itemtype="" locationtype="'.$r_post_locs.'" features="" orderby="'.$setup22_searchresults_defaultsortbytype.'" sortby="'.$setup22_searchresults_defaultsorttype.'" items="4" cols="4" filters="false" itemboxbg="'.$setup22_searchresults_background2.'" related="1" relatedcpi="'.$post_id.'"]';
							}
							$relatex_listing_text_output = do_shortcode($relatex_listing_text);

							if ($r_post_count > 0 && !empty($relatex_listing_text_output)) {
								echo '
									<div class="col-lg-12">
									<div class="pftrwcontainer hidden-print pf-itempagedetail-element pitempagedetail-relatedlistings">
										<div class="pfitempagecontainerheader">'.esc_html__('Related Listings','pointfindert2d').'</div>
										<div class="pfmaincontactinfo">
											<section role="itempagedetails" class="pf-itempage-features-block pf-itempage-elements">
												<div class="pf-itempage-features">'.
												$relatex_listing_text_output
												.'</div>
											</section>
										</div>
									</div>
									</div>
								';
							}
						}
						echo '</div>';
	                	echo '</div>';
	                echo '</section>';
	            echo '</div>';
	            };
        	};
			break;

		case $setup3_pointposttype_pt8: /*Agents*/

			
			if ( have_posts() ){
				the_post();
				get_template_part('admin/estatemanagement/includes/functions/agentpage','functions');
				if(function_exists('PFGetDefaultPageHeader')){
					PFGetDefaultPageHeader(array('agent_id' => $post_id));
				}

				$setup42_itempagedetails_sidebarpos_auth = PFSAIssetControl('setup42_itempagedetails_sidebarpos_auth','','2');
				echo '<section role="main" class="pf-itempage-maindiv">';
					echo '<div class="pf-container clearfix">';
					echo '<div class="pf-row clearfix">';
		    		if ($setup42_itempagedetails_sidebarpos_auth == 2) {
						if(function_exists('PFGetAgentPageCol1')){PFGetAgentPageCol1($post_id);}
		          		if(function_exists('PFGetAgentPageCol2')){PFGetAgentPageCol2();}
					} elseif ($setup42_itempagedetails_sidebarpos_auth == 1) {
						if(function_exists('PFGetAgentPageCol2')){PFGetAgentPageCol2();}
		          		if(function_exists('PFGetAgentPageCol1')){PFGetAgentPageCol1($post_id);}
					}else{
						if(function_exists('PFGetAgentPageCol1')){PFGetAgentPageCol1($post_id);}
					}
		    		echo '</div>';
		        	echo '</div>';
		        echo '</section>';
			};	                
			break;

		case 'post':/*Blog Posts*/
			if(function_exists('PFGetHeaderBar')){
				PFGetDefaultPageHeader();
			}
	        $setup_item_blogpage_sidebarpos = PFASSIssetControl('setup_item_blogpage_sidebarpos','','2');
	        get_template_part( 'admin/core/post', 'functions' );
	        if ( have_posts() ){
	        	the_post();
				echo '<section role="main">';
			        echo '<div class="pf-blogpage-spacing pfb-top"></div>';
			        echo '<div class="pf-container"><div class="pf-row">';
			        	if ($setup_item_blogpage_sidebarpos == 3) {
			        		echo '<div class="col-lg-12">';

								get_template_part('sloop');

							echo '</div>';
			        	}else{
			        	
				            if($setup_item_blogpage_sidebarpos == 1){
				                echo '<div class="col-lg-3 col-md-4">';
				                    if (is_active_sidebar( 'pointfinder-blogpages-area' )) {

				                    	get_sidebar('singleblog' );
				                    } else {
				                    	get_sidebar();
				                    }
				                    
				                echo '</div>';
				            }
				              
				            echo '<div class="col-lg-9 col-md-8">'; 
				            
				            get_template_part('sloop');

				            echo '</div>';
				            if($setup_item_blogpage_sidebarpos == 2){
				                echo '<div class="col-lg-3 col-md-4">';
				                    if (is_active_sidebar( 'pointfinder-blogpages-area' )) {
				                    	get_sidebar('singleblog' );
				                    } else {
				                    	get_sidebar();
				                    }
				                echo '</div>';
				            }

			            }
			        echo '</div></div>';
			        echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
			    echo '</section>';
			};
			break;
	}
    

get_footer();
?>