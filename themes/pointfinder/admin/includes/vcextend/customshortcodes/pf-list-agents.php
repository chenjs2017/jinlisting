<?php
add_shortcode( 'pf_agentlist', 'pf_agentlist_func' );
function pf_agentlist_func( $atts ) {
   extract( shortcode_atts( array(
   		'pagelimit' => 10
   	), $atts ) );
  
	$output = '';

	ob_start();

		if ( is_front_page() ) {
	        $pfg_paged = (esc_sql(get_query_var('page'))) ? esc_sql(get_query_var('page')) : 1;   
	    } else {
	        $pfg_paged = (esc_sql(get_query_var('paged'))) ? esc_sql(get_query_var('paged')) : 1; 
	    }

		$setup3_pointposttype_pt8 = PFSAIssetControl('setup3_pointposttype_pt8','','agents');

		$args = array(
			'post_type' => $setup3_pointposttype_pt8,
			'posts_per_page' => $pagelimit
		);

		$args['paged'] = $pfg_paged;

		// The Query
		
		echo '<div class="pf-row">'; 

		global $wpdb;

		$loop = new WP_Query( $args );
		$im = 1;
		// The Loop

		$setup3_pointposttype_pt3 = PFSAIssetControl('setup3_pointposttype_pt3','','PF Items');
		$setup3_pointposttype_pt2 = PFSAIssetControl('setup3_pointposttype_pt2','','PF Item');
		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

		$setup42_itempagedetails_contact_photo = PFSAIssetControl('setup42_itempagedetails_contact_photo','','1');
		$setup42_itempagedetails_contact_moreitems = PFSAIssetControl('setup42_itempagedetails_contact_moreitems','','1');
		$setup42_itempagedetails_contact_phone = PFSAIssetControl('setup42_itempagedetails_contact_phone','','1');
		$setup42_itempagedetails_contact_mobile = PFSAIssetControl('setup42_itempagedetails_contact_mobile','','1');
		$setup42_itempagedetails_contact_email = PFSAIssetControl('setup42_itempagedetails_contact_email','','1');
		$setup42_itempagedetails_contact_url = PFSAIssetControl('setup42_itempagedetails_contact_url','','1');
		$setup42_itempagedetails_contact_form = PFSAIssetControl('setup42_itempagedetails_contact_form','','1');

		while ( $loop->have_posts() ) : $loop->the_post();

			$author_id = get_the_id();

			$agent_featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id( $author_id ), 'full' );

			if (empty($agent_featured_image)) {
				$user_photo = '<img src="'.get_template_directory_uri().'/images/empty_avatar.jpg"/>';
			}else{
				if ($agent_featured_image[2] >= 280) {
					$agent_featured_image[0] = aq_resize($agent_featured_image[0],300,280,true);
					$agent_featured_image[1] = 300;
					$agent_featured_image[2] = 280;
				}
				$user_photo = '<img src="'.$agent_featured_image[0].'" width="'.$agent_featured_image[1].'" height="'.$agent_featured_image[2].'" alt="" />';
			}


				$user_description = get_the_title($author_id);
				$user_phone = esc_attr(get_post_meta( $author_id, 'webbupointfinder_agent_tel', true ));
				$user_mobile = esc_attr(get_post_meta( $author_id, 'webbupointfinder_agent_mobile', true ));

				$user_socials = array();
				$user_email = sanitize_email(get_post_meta( $author_id, 'webbupointfinder_agent_email', true ));
				
				if($setup42_itempagedetails_contact_photo == 0){$user_photo = '';}
				$tabinside = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 agentlistmaincol" >';
				$tabinside .= '<section role="itempagesidebarinfo" class="pf-itempage-sidebarinfo pfpos2 pf-itempage-elements pf-agentlist-pageitem">';
					
					$tabinside .= '<div class="pf-itempage-sidebarinfo-elname">'.get_the_title().'</div>';
					$tabinside .= '<div id="pf-itempage-sidebarinfo">';
						$tabinside .= '<div class="pf-row clearfix"><div class="col-lg-5 col-md-4">';
						$tabinside .= '<div class="pf-itempage-sidebarinfo-photo"><a href="'.get_permalink($author_id).'">'.$user_photo.'</a></div>';


						$tabinside .= '</div><div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">';
						$tabinside .= '<div class="pf-itempage-sidebarinfo-userdetails pfpos2">
							<ul>';

							if($setup42_itempagedetails_contact_moreitems == 1){

								$agentitemcount = pointfinder_agentitemcount_calc($author_id, $setup3_pointposttype_pt1,'count');

								$agentitemcount = (isset($agentitemcount['count']))?$agentitemcount['count']:0;

								if ($agentitemcount > 0) {
									if ($agentitemcount > 1) {
										$agentitemcount_keyword = $agentitemcount.' '.$setup3_pointposttype_pt3;
									}elseif ($agentitemcount == 1) {
										$agentitemcount_keyword = '1 '.$setup3_pointposttype_pt2;
									}
								}else{
									$agentitemcount_keyword = sprintf(esc_html__('No %s','pointfindert2d'),$setup3_pointposttype_pt2);
								}
								$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="'.get_permalink($author_id).'"><i class="pfadmicon-glyph-510"></i> '.$agentitemcount_keyword.'</a></li>';
							}
							if(!empty($user_phone ) && $setup42_itempagedetails_contact_phone == 1){
								$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="tel:'.antispambot($user_phone).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-765"></i> '.$user_phone.'</a></li>';
							}
							if(!empty($user_mobile) && $setup42_itempagedetails_contact_mobile == 1){
								$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="tel:'.antispambot($user_mobile).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-351"></i> '.$user_mobile.'</a></li>';
							}
							if(!empty($user_email) && $setup42_itempagedetails_contact_email == 1){
								$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="mailto:'.antispambot($user_email).'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-354"></i> '.esc_html__("Email Us!","pointfindert2d").'</a></li>';
							}
							
							$tabinside .= '</ul>
						</div>';
						$tabinside .= '</div></div>';
					$tabinside .= '</div>';
				$tabinside .= '</section>';
			$tabinside .= '</div>';
			echo $tabinside;

		endwhile;
		echo '</div>';
		echo '<div class="pfajax_paginate pf-agentlistpaginate" >';
		$big = 999999999;
		echo paginate_links(array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?page=%#%',
			'current' => max(1, $pfg_paged),
			'total' => $loop->max_num_pages,
			'type' => 'list',
		));
		echo '</div>';
		
		// Reset Query
		wp_reset_postdata();

	$output = ob_get_contents();

	ob_end_clean();

	return $output;

}
?>