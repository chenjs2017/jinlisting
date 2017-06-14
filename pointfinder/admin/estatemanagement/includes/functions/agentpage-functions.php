<?php

/**********************************************************************************************************************************
*
* Author Page Functions
* 
* Author: Webbu Design
* Please do not modify below functions.
***********************************************************************************************************************************/



function PFGetAgentPageCol1($author_id){
	$setup42_itempagedetails_sidebarpos_auth = PFSAIssetControl('setup42_itempagedetails_sidebarpos_auth','','2');
	if ($setup42_itempagedetails_sidebarpos_auth == 3) {
		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="pfauthordetail">';
	}else{
		echo '<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12"><div class="pfauthordetail">';
	}

	$agent_featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id( $author_id ), 'full' );

	if (empty($agent_featured_image)) {
		$user_photo = '<img src="'.get_template_directory_uri().'/images/empty_avatar.jpg"/>';
	}else{
		$user_photo = '<img src="'.$agent_featured_image[0].'" width="'.$agent_featured_image[1].'" height="'.$agent_featured_image[2].'" alt="" />';
	}


	$user_description = get_the_title($author_id);
	$user_phone = esc_attr(get_post_meta( $author_id, 'webbupointfinder_agent_tel', true ));
	$user_mobile = esc_attr(get_post_meta( $author_id, 'webbupointfinder_agent_mobile', true ));
	$user_web = esc_attr(get_post_meta( $author_id, 'webbupointfinder_agent_web', true ));

	$user_socials = array();

	$user_facebook = esc_url(get_post_meta( $author_id, 'webbupointfinder_agent_face', true ));
	$user_twitter = esc_url(get_post_meta( $author_id, 'webbupointfinder_agent_twitter', true ));
	$user_linkedin = esc_url(get_post_meta( $author_id, 'webbupointfinder_agent_linkedin', true ));
	$user_googleplus = esc_url(get_post_meta( $author_id, 'webbupointfinder_agent_googlel', true ));

	$user_email = sanitize_email(get_post_meta( $author_id, 'webbupointfinder_agent_email', true ));


	if(!empty($user_facebook)){$user_socials['facebook'] = $user_facebook;}
	if(!empty($user_twitter)){$user_socials['twitter'] = $user_twitter;}
	if(!empty($user_linkedin)){$user_socials['linkedin'] = $user_linkedin;}
	if(!empty($user_googleplus)){$user_socials['google-plus'] = $user_googleplus;}

	$css_text = (count($user_socials) < 4)? ' col'.count($user_socials).'pfit':'';

	$user_socials_count = count($user_socials);
	

	switch ($user_socials_count) {
		case '4':
			$col_text = 'col-lg-3 col-md-3 col-xs-3';
			break;
		case '3':
			$col_text = 'col-lg-4 col-md-4 col-xs-4';
			break;
		case '2':
			$col_text = 'col-lg-6 col-md-6 col-xs-6';
			break;
		default:
			$col_text = 'col-lg-12 col-md-12 col-xs-12';
			break;
	}

	
		$setup42_itempagedetails_contact_photo = PFSAIssetControl('setup42_itempagedetails_contact_photo','','1');
		$setup42_itempagedetails_contact_moreitems = PFSAIssetControl('setup42_itempagedetails_contact_moreitems','','1');
		$setup42_itempagedetails_contact_phone = PFSAIssetControl('setup42_itempagedetails_contact_phone','','1');
		$setup42_itempagedetails_contact_mobile = PFSAIssetControl('setup42_itempagedetails_contact_mobile','','1');
		$setup42_itempagedetails_contact_email = PFSAIssetControl('setup42_itempagedetails_contact_email','','1');
		$setup42_itempagedetails_contact_url = PFSAIssetControl('setup42_itempagedetails_contact_url','','1');
		$setup42_itempagedetails_contact_form = PFSAIssetControl('setup42_itempagedetails_contact_form','','1');
		
		if($setup42_itempagedetails_contact_photo == 0){$user_photo = '';}
		$tabinside = '';
		$tabinside .= '<section role="itempagesidebarinfo" class="pf-itempage-sidebarinfo pfpos2 pf-itempage-elements pf-authordetail-page">';
			
			
			$tabinside .= '<div id="pf-itempage-sidebarinfo">';
				$tabinside .= '<div class="pf-row clearfix"><div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">';
				$tabinside .= '<div class="pf-itempage-sidebarinfo-photo">'.$user_photo.'</div>';
				if(count($user_socials) > 0){
					$tabinside .= '<ul class="pf-itempage-sidebarinfo-social'.$css_text.' pf-row clearfix">';
						foreach ($user_socials as $key => $value) {
							$tabinside .= '<li class="pf-sociallinks-item '.$key.'  wpf-transition-all '.$col_text.'"><a href="'.$value.'" target="_blank"><i class="pfadmicon-'.pfsocialtoicon($key).'"></i></a></li>';
						}
					$tabinside .= '</ul>';
				}

				if(!empty($user_email) && $setup42_itempagedetails_contact_form == 1 ){
					$tabinside .= '<a id="pf-enquiry-trigger-button-author" class="pf-enquiry-form-ex" data-pf-user="'.$author_id.'">'.esc_html__('CONTACT FORM','pointfindert2d').'</a>';
				}


				$tabinside .= '</div><div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">';
				$tabinside .= '<div class="pf-itempage-sidebarinfo-userdetails pfpos2">
					<ul>';
					$tabinside .= '<li class="pf-itempage-sidebarinfo-elname">'.get_the_title().'</li>';
					if(!empty($user_description)){
						$tabinside .= '<li class="pf-itempage-sidebarinfo-eldesc pf-itempage-sidebarinfo-elitem">'.do_shortcode(get_the_content()).'</li>';
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
					if(!empty($user_web)){
						$tabinside .= '<li class="pf-itempage-sidebarinfo-elurl pf-itempage-sidebarinfo-elitem"><a href="http://'.$user_web.'" target="_blank" rel="nofollow"><i class="pfadmicon-glyph-592"></i> '.$user_web.'</a></li>';
					}
					$tabinside .= '</ul>
				</div>';
				$tabinside .= '</div></div>';
			$tabinside .= '</div>';
		$tabinside .= '</section>';
		
	echo $tabinside;


	$setup42_authorpagedetails_background2 = PFSAIssetControl('setup22_searchresults_background2','','#f7f7f7');
	$setup42_authorpagedetails_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
	$setup42_authorpagedetails_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	$setup42_authorpagedetails_grid_layout_mode = ($setup42_authorpagedetails_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;
	
	$agentposts = pointfinder_agentitemcount_calc($author_id, $setup3_pointposttype_pt1,'ids');

	$agentposts = (isset($agentposts['ids']))?$agentposts['ids']:'';


	
		echo '<div id="pfauthor-items">';
		if (!empty($agentposts)) {
		echo do_shortcode('[pf_itemgrid posts_in="'.$agentposts.'" orderby="title" sortby="ASC" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="3" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="true" itemboxbg="'.$setup42_authorpagedetails_background2.'" agentmode="1" author="'.$author_id.'"]' );
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	
}




function PFGetAgentPageCol2(){
	echo '<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 hidden-print">';
	echo '<section role="itempagesidebar" class="pf-itempage-sidebar">';
		echo '<div id="pf-itempage-sidebar">';
			echo '<div class="sidebar-widget">';
				if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('pointfinder-authorpage-area'))
			echo '</div>';
		echo '</div>';
	echo '</section>';
	echo '</div>';
}

?>