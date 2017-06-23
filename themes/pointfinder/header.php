<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<?php
			if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
        		header('X-UA-Compatible: IE=edge,chrome=1');
        	}
		?>
		
		<meta name="description" content="<?php esc_html(bloginfo('description')); ?>">
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<![endif]-->
		<?php

		$general_responsive = esc_attr(PFSAIssetControl('general_responsive','','1'));
		if($general_responsive == 1){
			$as_mobile_zoom = PFASSIssetControl('as_mobile_zoom','','1');
			if ($as_mobile_zoom == 1) {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';
			} else {
				echo '<meta name="viewport" content="width=device-width">';
			}
		}
		
		$iostouchicon_1 = esc_url(PFSAIssetControl('setup17_logosettings_sitefavicon','url',''));
		if($iostouchicon_1){
			echo '<link rel="shortcut icon" href="'.$iostouchicon_1.'" type="image/x-icon">';
			echo '<link rel="icon" href="'.$iostouchicon_1.'" type="image/x-icon">';
		}

		/* Start: Transparent Header Addon */
			global $post;
			$transparent_header_text = $style_text = $logocsstext = "";
			if (isset($post->ID) && !is_search()) {
				$transparent_header = get_post_meta( $post->ID, 'webbupointfinder_page_transparent', true );
				if (!empty($transparent_header)) {
					$transparent_header_text = " pftransparenthead";

					$menulinecolor = get_post_meta( $post->ID, 'webbupointfinder_page_menulinecolor', true );
					$menucolor = get_post_meta( $post->ID, 'webbupointfinder_page_menucolor', true );
					$menubg = get_post_meta( $post->ID, 'webbupointfinder_page_headerbarsettings_bgcolor', true );
					$menubg_sticky = get_post_meta( $post->ID, 'webbupointfinder_page_headerbarsettings_bgcolor2', true );
					$menutextb = get_post_meta( $post->ID, 'webbupointfinder_page_menutextsize', true );
					$logoadditional = get_post_meta( $post->ID, 'webbupointfinder_page_logoadditional', true );

					if (!empty($logoadditional)) {

						/* Logo for this bar */
						$setup18_headerbarsettings_padding = PFSAIssetControl('setup18_headerbarsettings_padding','margin-top','30');
						$setup18_headerbarsettings_padding_number = str_replace('px', '', $setup18_headerbarsettings_padding);
						
						$setup17_logosettings_sitelogo = PFSAIssetControl('setup17_logosettings_sitelogo2','','');
						if (!is_array($setup17_logosettings_sitelogo)) {
							$setup17_logosettings_sitelogo = array('url'=>'','width'=>188,'height'=>30);
						} 
						$setup17_logosettings_sitelogo_height = (!empty($setup17_logosettings_sitelogo["height"]))?$setup17_logosettings_sitelogo["height"]:30;
						$setup17_logosettings_sitelogo_height_number = str_replace('px', '', $setup17_logosettings_sitelogo_height);
						$setup17_logosettings_sitelogo_width = (!empty($setup17_logosettings_sitelogo["width"]))?$setup17_logosettings_sitelogo["width"]:188;
						$setup17_logosettings_sitelogo_width_number = str_replace('px', '', $setup17_logosettings_sitelogo_width);

						$setup17_logosettings_sitelogo2x = PFSAIssetControl('setup17_logosettings_sitelogo22x','','');
						if (!is_array($setup17_logosettings_sitelogo2x)) {
							$setup17_logosettings_sitelogo2x = array('url'=>'','width'=>188,'height'=>30);
						}
						$setup17_logosettings_sitelogo2x_height = (!empty($setup17_logosettings_sitelogo2x["height"]))?$setup17_logosettings_sitelogo2x["height"]:30;
						$setup17_logosettings_sitelogo2x_height_number = str_replace('px', '', $setup17_logosettings_sitelogo2x_height);
						$setup17_logosettings_sitelogo2x_width = (!empty($setup17_logosettings_sitelogo2x["width"]))?$setup17_logosettings_sitelogo2x["width"]:188;
						$setup17_logosettings_sitelogo2x_width_number = str_replace('px', '', $setup17_logosettings_sitelogo2x_width);

						$pfpadding_half = $setup18_headerbarsettings_padding_number / 2;

						/*Logo Settings*/
							$logocsstext .= '.wpf-header.pftransparenthead .pf-logo-container{margin:'.$setup18_headerbarsettings_padding.' 0;height: '.$setup17_logosettings_sitelogo_height_number.'px;}';
							$logocsstext .= '.wpf-header.pftransparenthead .pf-logo-container{background-image:url('.$setup17_logosettings_sitelogo["url"].');background-size:'.$setup17_logosettings_sitelogo_width_number.'px '.$setup17_logosettings_sitelogo_height_number.'px;width: '.$setup17_logosettings_sitelogo_width_number.'px;}';

							$logocsstext .= '.wpf-header.pftransparenthead.pfshrink .pf-logo-container{height: '.($setup17_logosettings_sitelogo_height_number/2).'px;margin:'.$pfpadding_half.'px 0;}';
							$logocsstext .= '.wpf-header.pftransparenthead.pfshrink .pf-logo-container{background-size:'.($setup17_logosettings_sitelogo_width_number/2).'px '.($setup17_logosettings_sitelogo_height_number/2).'px;width: '.($setup17_logosettings_sitelogo_width_number/2).'px;}';

							$logocsstext .= '@media (max-width: 568px) {.wpf-header.pftransparenthead .pf-logo-container{height: '.($setup17_logosettings_sitelogo_height_number/2).'px;margin:'.$pfpadding_half.'px 0;}.wpf-header.pftransparenthead .pf-logo-container{background-size:'.($setup17_logosettings_sitelogo_width_number/2).'px '.($setup17_logosettings_sitelogo_height_number/2).'px;width: '.($setup17_logosettings_sitelogo_width_number/2).'px;}}';



						/* Retina Logo Settings */
							if(is_array($setup17_logosettings_sitelogo2x)){
								if(count($setup17_logosettings_sitelogo2x)>0){
									$logocsstext .= '@media only screen and (-webkit-min-device-pixel-ratio: 1.5),(min-resolution: 144dpi){.wpf-header.pftransparenthead .pf-logo-container{background-image:url('.$setup17_logosettings_sitelogo2x["url"].');background-size:'.($setup17_logosettings_sitelogo2x_width_number/2).'px '.($setup17_logosettings_sitelogo2x_height_number/2).'px;width: '.($setup17_logosettings_sitelogo2x_width_number/2).'px;}}';
								}
							}
					}



					$style_text = "<style>";
					
					$style_text .= "@media (min-width: 992px) {";
					$style_text .= $logocsstext;
					if (!empty($menutextb)) {
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li a,.wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li.selected > a{font-weight:bold;}";
					}

					if (!empty($menucolor)) {
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li a,.wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li.selected > a{color:".$menucolor['regular'].";}";
	                    $style_text .= ".wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li a:hover,.wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li.selected > a:hover{color:".$menucolor['hover'].";}";
					}

					if (!empty($menulinecolor)) {
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav li.current_page_item > a,.wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li > a:hover{border-bottom: 2px solid ".$menulinecolor.";}";
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav .pf-megamenu-main.current_page_item > a,.wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu .pf-megamenu-main > a:hover{border-bottom: 0;}";
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav li.current_page_item.selected > a,.wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li.selected > a:hover{border-bottom: 0}";
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu li.selected > .pfnavsub-menu{border-top: 2px solid ".$menulinecolor.";}";
						$style_text .= ".wpf-header.pftransparenthead #pf-primary-nav .pfnavmenu .pfnav-megasubmenu li.selected > .pfnavsub-menu{border-top:0;}";
					}

					if (!empty($menubg)) {
						$style_text .= ".wpf-header.pftransparenthead{background:".$menubg['color'].";background:".$menubg['rgba'].";}";
					}
					if (!empty($menubg_sticky)) {
						$style_text .= ".wpf-header.pftransparenthead.pfshrink{background:".$menubg_sticky['color'].";background:".$menubg_sticky['rgba'].";}";
					}

					$style_text .= "}";
					$style_text .= "</style>";
					echo $style_text;
				}
			}
		/* End: Transparent Header Addon */
		
		wp_head();


		?> 
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1777841339155093');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1777841339155093&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->		
	</head>
	<body <?php body_class(); ?> >
	<?php
	$general_rtlsupport = PFSAIssetControl('general_rtlsupport','','0');
	$pflogintext = "";
    ?>
		<?php if (!is_page_template('pf-empty-page.php' )  && !is_page_template('terms-conditions.php' )) {?>
		<div id="pf-loading-dialog" class="pftsrwcontainer-overlay"></div>
        <header class="wpf-header hidden-print<?php echo $transparent_header_text;?>" id="pfheadernav">
        	<?php
        	$as_topline_status = PFASSIssetControl('as_topline_status','','1');
        	if ($as_topline_status == 1) {
        	?>
        	<div class="pftopline wpf-transition-all">
        		<div class="pf-container">
					<div class="pf-row">
						<div class="col-lg-12 col-md-12">
							<?php 
							
        					$setup19_socialiconsbarsettings_main = esc_attr(PFSAIssetControl('setup19_socialiconsbarsettings_main','','0'));

							$setup4_membersettings_frontend = esc_attr(PFSAIssetControl('setup4_membersettings_frontend','','0'));
							$setup4_membersettings_loginregister = esc_attr(PFSAIssetControl('setup4_membersettings_loginregister','','0'));

							$setup19_socialiconsbarsettings_theme = esc_attr(PFSAIssetControl('setup19_socialiconsbarsettings_theme','',''));
							

							$setup19_socialiconsbarsettings_envelope = esc_html(PFSAIssetControl('setup19_socialiconsbarsettings_envelope','',''));
							$setup19_socialiconsbarsettings_envelope_link = esc_html(PFSAIssetControl('setup19_socialiconsbarsettings_envelope_link','',''));
							$setup19_socialiconsbarsettings_phone = esc_html(PFSAIssetControl('setup19_socialiconsbarsettings_phone','',''));
							$setup19_socialiconsbarsettings_phone_link = esc_html(PFSAIssetControl('setup19_socialiconsbarsettings_phone_link','',''));
						
							?>
							<div class="wpf-toplinewrapper">
								<?php
								if($setup19_socialiconsbarsettings_main == 1){
								?>
								<div class="pf-toplinks-left clearfix">
									<ul class="pf-sociallinks">
										<?php
									//		$pf_socialname_arr = array("facebook","twitter","linkedin","google-plus","pinterest","dribbble","dropbox","flickr","github","instagram","rss","skype","tumblr","vk","youtube");
											$pf_socialname_arr = array();
											$output = '';
											$output_num = 1;
											foreach ($pf_socialname_arr as $socialname) {
												if($socialname != ''){
													$social_admin_var = esc_url(PFSAIssetControl('setup19_socialiconsbarsettings_'.$socialname,'',''));
													if($social_admin_var != '' && $output_num < 8){
														$output .= '<li class="pf-sociallinks-item '.$socialname.'  wpf-transition-all"><a href="'.$social_admin_var.'" target="_blank"><i class="pfadmicon-'.pfsocialtoicon($socialname).'"></i></a></li>';
														$output_num++;
													}
												}
											}
											echo $output;							
										?>
										
									<?php if ($setup19_socialiconsbarsettings_phone != '') {?>
									<li class="pf-sociallinks-item pf-infolinks-item envelope  wpf-transition-all">
										<a href="<?php echo $setup19_socialiconsbarsettings_phone_link;?>"><i class="pfadmicon-glyph-765"></i> <span class="pf-infolink-item-text"><?php echo $setup19_socialiconsbarsettings_phone;?></span></a>
									</li>
									<?php } ?>

									<?php if ($setup19_socialiconsbarsettings_envelope != '') {?>
									<li class="pf-sociallinks-item pf-infolinks-item  envelope  wpf-transition-all">
										<a href="<?php echo $setup19_socialiconsbarsettings_envelope_link;?>"><i class="pfadmicon-glyph-823"></i><span class="pf-infolink-item-text"><?php echo $setup19_socialiconsbarsettings_envelope;?></span></a>
									</li>
									<?php } ?>
									<li class="pf-sociallinks-item pf-infolinks-item pflast envelope  wpf-transition-all">
										<a href="http://www.jinlisting.com/weLive.apk"><i class="fa fa-android"></i><span class="pf-infolink-item-text">安卓客户端</span></a>
									</li>


									</li>


	
									</ul>

								
								</div>
								<?php }?>
								<?php
								if($setup4_membersettings_loginregister == 1){
									if(is_user_logged_in()){$pflogintext = " pfloggedin";}else{$pflogintext = "";}
								?>
								<div class="pf-toplinks-right clearfix">
									<nav id="pf-topprimary-nav" class="pf-topprimary-nav pf-nav-dropdown clearfix hidden-sm hidden-xs">
										<ul class="pf-nav-dropdown pfnavmenu pf-topnavmenu ">
											<li class="pf-my-account pfloggedin">
												<?php 
												if(function_exists('icl_t')) {
													$pf_languages = icl_get_languages('skip_missing=1&orderby=KEY&order=DIR'); 
												
													foreach ($pf_languages as $pf_languagex) {
														if (PF_current_language() == $pf_languagex['language_code']) {
															echo '<a href="#" class="pf_language_selects"><img src="'.$pf_languagex['country_flag_url'].'"/>'.$pf_languagex['translated_name'].'</a>';
														}
													}
													echo '<ul class="pfnavsub-menu sub-menu menu-odd  menu-depth-1 hidden-xs hidden-sm">';
													
													
													foreach ($pf_languages as $pf_language) {
														echo '<li>';
															echo '<a href="'.esc_url($pf_language['url']).'" class="pf_language_selects"><img src="'.esc_url($pf_language['country_flag_url']).'"/>'.esc_html($pf_language['translated_name']).'</a>';
														echo '</li>';
													}

													echo '</ul>';
												}
												?>
												
											</li>
											<?php 
											if ( !is_user_logged_in() ){
											?>
											<li class="pf-login-register" id="pf-login-trigger-button"><a href="#"><i class="pfadmicon-glyph-584"></i> <?php  echo esc_html__('Login','pointfindert2d')?></a></li>
											<li class="pf-login-register" ><a href="/wp-login.php?action=register"><i class="pfadmicon-glyph-365"></i> <?php  echo esc_html__('Register','pointfindert2d')?></a></li>
											<li class="pf-login-register" id="pf-lp-trigger-button"><a href="#"><i class="pfadmicon-glyph-889"></i> <?php  echo esc_html__('Forgot Password','pointfindert2d')?></a></li>
											<?php 
											}else {
												global $current_user;
											?>
											<li class="pf-my-account pfloggedin">
												<a href="#">
												<i class="pfadmicon-glyph-632"></i> 
												<?php  echo $current_user->nickname?>
												</a>
												<ul class="pfnavsub-menu sub-menu menu-odd  menu-depth-1 hidden-xs hidden-sm">
													<?php 													
													$setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
													$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');
													$setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');
													$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
													$setup_invoices_sh = PFASSIssetControl('setup_invoices_sh','','1');

													$setup29_dashboard_contents_my_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_my_page_menuname','',''));
													$setup29_dashboard_contents_inv_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_inv_page_menuname','',''));
													$setup29_dashboard_contents_favs_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_favs_page_menuname','',''));
													$setup29_dashboard_contents_profile_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_profile_page_menuname','',''));
													$setup29_dashboard_contents_submit_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','',''));
													$setup29_dashboard_contents_rev_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_rev_page_menuname','',''));

													$pfmenu_output = '';
													$pfmenu_perout = PFPermalinkCheck();

													$pfmenu_output .= '<li ><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=profile"><i class="pfadmicon-glyph-406"></i> '. $setup29_dashboard_contents_profile_page_menuname.'</a></li>';
													$pfmenu_output .= ($setup4_membersettings_frontend == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=newitem"><i class="pfadmicon-glyph-475"></i> '. $setup29_dashboard_contents_submit_page_menuname.'</a></li>' : '' ;
													$pfmenu_output .= ($setup4_membersettings_frontend == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems"><i class="pfadmicon-glyph-460"></i> '. $setup29_dashboard_contents_my_page_menuname.'</a></li>' : '' ;
													$pfmenu_output .= ($setup4_membersettings_frontend == 1 && $setup_invoices_sh == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=invoices"><i class="pfadmicon-glyph-33"></i> '. $setup29_dashboard_contents_inv_page_menuname.'</a></li>' : '' ;
													$pfmenu_output .= ($setup4_membersettings_favorites == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=favorites"><i class="pfadmicon-glyph-375"></i> '. $setup29_dashboard_contents_favs_page_menuname.'</a></li>' : '';
													$pfmenu_output .= ($setup11_reviewsystem_check == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=reviews"><i class="pfadmicon-glyph-377"></i> '. $setup29_dashboard_contents_rev_page_menuname.'</a></li>' : '';
													$pfmenu_output .= '<li><a href="'.wp_logout_url( home_url() ).'"><i class="pfadmicon-glyph-476"></i> '. esc_html__('Logout','pointfindert2d').'</a></li>';
													echo $pfmenu_output;
													?>
												</ul>
												
											</li>
											<?php } ?>
										</ul>
									</nav>
								</div>
								<?php }else{
									if(function_exists('icl_t')) {
								?>
								<div class="pf-toplinks-right clearfix">
									<nav id="pf-topprimary-nav" class="pf-topprimary-nav pf-nav-dropdown clearfix hidden-sm hidden-xs">
										<ul class="pf-nav-dropdown pfnavmenu pf-topnavmenu ">
											<li class="pf-my-account pfloggedin">
												<?php 
											
												$pf_languages = icl_get_languages('skip_missing=1&orderby=KEY&order=DIR'); 
												
													foreach ($pf_languages as $pf_languagex) {
														if (PF_current_language() == $pf_languagex['language_code']) {
															echo '<a href="#" class="pf_language_selects"><img src="'.$pf_languagex['country_flag_url'].'"/>'.$pf_languagex['translated_name'].'</a>';
														}
													}
													echo '<ul class="pfnavsub-menu sub-menu menu-odd  menu-depth-1 hidden-xs hidden-sm">';
													
													
													foreach ($pf_languages as $pf_language) {
														echo '<li>';
															echo '<a href="'.esc_url($pf_language['url']).'" class="pf_language_selects"><img src="'.esc_url($pf_language['country_flag_url']).'"/>'.esc_html($pf_language['translated_name']).'</a>';
														echo '</li>';
													}

													echo '</ul>';
												
												?>
												
											</li>
										</ul>
										</nav>
									</div>
								<?php } }?>
							</div>
						</div>
					</div>
				</div>
        	</div>
            <?php 
            }
            ?>
            <div class="wpf-navwrapper">
	            <?php 
				$pf_navmenu = wp_nav_menu(array(
				        'echo' => FALSE,
				        'theme_location'  => 'pointfinder-main-menu',
				        'fallback_cb' => '__return_false'
				    	)
				);

				if ( ! empty ( $pf_navmenu ) ){
				?>
					<a id="pf-primary-nav-button" title="<?php echo esc_html__('Menu','pointfindert2d');?>"><i class="pfadmicon-glyph-500"></i></a>
				<?php }?>
			
				<?php 
				if (!isset($setup4_membersettings_loginregister)) {
					$setup4_membersettings_loginregister = esc_attr(PFSAIssetControl('setup4_membersettings_loginregister','','0'));
				}
				if ($setup4_membersettings_loginregister == 1) {
				?>
				<a id="pf-topprimary-nav-button" title="<?php echo esc_html__('User Menu','pointfindert2d');?>"><i class="pfadmicon-glyph-632"></i></a>
				<a id="pf-topprimary-nav-button2" title="<?php echo esc_html__('User Menu','pointfindert2d');?>"><i class="pfadmicon-glyph-787"></i></a>
				<?php 
				}
				?>
				<a id="pf-primary-search-button" title="<?php echo esc_html__('Search','pointfindert2d');?>"><i class="pfadmicon-glyph-627"></i></a>
				<div class="pf-container pf-megamenu-container">
					<div class="pf-row">
						<?php
						function pointfinder_logocolumn_get(){
						?>
						<div class="col-lg-3 col-md-3">
							<a class="pf-logo-container" href="<?php echo esc_url(home_url());?>"></a>
						</div>
						<?php	
						}
						?>

						<?php
						function pointfinder_menucolumn_get(){
						?>
						<div class="col-lg-9 col-md-9" id="pfmenucol1">
							<div class="pf-menu-container">

								<nav id="pf-primary-nav" class="pf-nav-dropdown clearfix">
									<ul class="pf-nav-dropdown pfnavmenu pf-topnavmenu">
										<?php pointfinder_navigation_menu ();?>
										<?php if (PFPBSIssetControl('general_postitembutton_status','','1') == 1) {?>
										<li id="pfpostitemlink" class="main-menu-item  menu-item-even menu-item-depth-0 menu-item menu-item-type-post_type menu-item-object-page current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children">
										<a class="menu-link main-menu-link">
										<div class="postanitem-inner">
										<span class="pfadmicon-glyph-478"></span><?php echo PFPBSIssetControl('general_postitembutton_buttontext','','Post an Item');?>
										</div>
										</a>
										</li>
										<?php };?>
									</ul>
								</nav>	

								<nav id="pf-topprimary-navmobi" class="pf-topprimary-nav pf-nav-dropdown clearfix">
									<ul class="pf-nav-dropdown  pfnavmenu pf-topnavmenu pf-nav-dropdownmobi">
										<?php 
										if ( !is_user_logged_in() ){
										?>
										<li class="pf-login-register" id="pf-login-trigger-button-mobi"><a href="#"><i class="pfadmicon-glyph-584"></i> <?php  echo esc_html__('Login','pointfindert2d')?></a></li>
										<li class="pf-login-register" id="pf-register-trigger-button-mobi"><a href="#"><i class="pfadmicon-glyph-365"></i> <?php  echo esc_html__('Register','pointfindert2d')?></a></li>
										<li class="pf-login-register" id="pf-lp-trigger-button-mobi"><a href="#"><i class="pfadmicon-glyph-889"></i><?php  echo esc_html__('Forgot Password','pointfindert2d')?></a></li>
										<?php 
										}else {
										
										global $current_user;
										
										$setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
										$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');
										$setup11_reviewsystem_check = PFREVSIssetControl('setup11_reviewsystem_check','','0');
										$setup4_membersettings_dashboard_link = esc_url(get_permalink($setup4_membersettings_dashboard));


										$setup29_dashboard_contents_my_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_my_page_menuname','',''));
										$setup29_dashboard_contents_inv_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_inv_page_menuname','',''));
										$setup29_dashboard_contents_favs_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_favs_page_menuname','',''));
										$setup29_dashboard_contents_profile_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_profile_page_menuname','',''));
										$setup29_dashboard_contents_submit_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','',''));
										$setup29_dashboard_contents_rev_page_menuname = esc_html(PFSAIssetControl('setup29_dashboard_contents_rev_page_menuname','',''));
										$setup4_membersettings_frontend = esc_html(PFSAIssetControl('setup4_membersettings_frontend','','0'));
										$setup_invoices_sh = PFASSIssetControl('setup_invoices_sh','','1');
										$pfmenu_output = '';
										$pfmenu_perout = PFPermalinkCheck();

										$pfmenu_output .= '<li ><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=profile"><i class="pfadmicon-glyph-406"></i> '. $setup29_dashboard_contents_profile_page_menuname.'</a></li>';
										$pfmenu_output .= ($setup4_membersettings_frontend == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=newitem"><i class="pfadmicon-glyph-475"></i> '. $setup29_dashboard_contents_submit_page_menuname.'</a></li>' : '' ;
										$pfmenu_output .= ($setup4_membersettings_frontend == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems"><i class="pfadmicon-glyph-460"></i> '. $setup29_dashboard_contents_my_page_menuname.'</a></li>' : '' ;
										$pfmenu_output .= ($setup4_membersettings_frontend == 1 && $setup_invoices_sh == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=invoices"><i class="pfadmicon-glyph-33"></i> '. $setup29_dashboard_contents_inv_page_menuname.'</a></li>' : '' ;
										$pfmenu_output .= ($setup4_membersettings_favorites == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=favorites"><i class="pfadmicon-glyph-375"></i> '. $setup29_dashboard_contents_favs_page_menuname.'</a></li>' : '';
										$pfmenu_output .= ($setup11_reviewsystem_check == 1) ? '<li><a href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=reviews"><i class="pfadmicon-glyph-377"></i> '. $setup29_dashboard_contents_rev_page_menuname.'</a></li>' : '';
										$pfmenu_output .= '<li><a href="'.wp_logout_url( home_url() ).'"><i class="pfadmicon-glyph-476"></i> '. esc_html__('Logout','pointfindert2d').'</a></li>';
										echo $pfmenu_output;
										
										} 
										?>
									</ul>
								</nav>

								<nav id="pf-topprimary-navmobi2" class="pf-topprimary-nav pf-nav-dropdown clearfix">
									<ul class="pf-nav-dropdown  pfnavmenu pf-topnavmenu pf-nav-dropdownmobi">
										<?php 
										if(function_exists('icl_t')) {
											$pf_languages = icl_get_languages('skip_missing=1&orderby=KEY&order=DIR'); 
											foreach ($pf_languages as $pf_language) {
													echo '<li>';
														echo '<a href="'.esc_url($pf_language['url']).'" class="pf_language_selects"><img src="'.esc_url($pf_language['country_flag_url']).'"/>'.esc_html($pf_language['translated_name']).'</a>';
													echo '</li>';
											}
										}
										?>
									</ul>
								</nav>
					
							</div>
						</div>
						<?php	
						}
						?>
						<?php
						if ($general_rtlsupport == 1) {
							pointfinder_menucolumn_get();
							pointfinder_logocolumn_get();
						}else{
							pointfinder_logocolumn_get();
							pointfinder_menucolumn_get();
						}
						?>
					</div>
				</div>
			</div>

        </header>
		
        <div class="wpf-container<?php echo $transparent_header_text;?>">
        	<div id="pfmaincontent" class="wpf-container-inner">
        <?php }?>
