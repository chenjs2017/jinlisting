<?php
/**********************************************************************************************************************************
*
* Sscripts & Styles
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
/*------------------------------------*\
	Info circle fix for ultimate addon.
\*------------------------------------*/
function wpdocs_dequeue_script() {
	wp_deregister_script("info-circle-ui-effect");
	wp_dequeue_script("info-circle-ui-effect");
}
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );


/*------------------------------------*\
	Scripts & Styles
\*------------------------------------*/

function pf_styleandscripts()
{		
		$usemin = 1;
		$general_rtlsupport = PFSAIssetControl('general_rtlsupport','','0');

    	wp_enqueue_script('jquery'); 		
    	wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-tooltip');
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-effects-fade');
		wp_enqueue_script('jquery-effects-slide');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-autocomplete');
		wp_deregister_script('wpb_composer_front_js');
		wp_register_script( 'wpb_composer_front_js', get_template_directory_uri() .'/js/js_composer_front.min.js', array( 'jquery' ), '4.9.1.1', true );

		/*------------------------------------*\
			Special Styles
		\*------------------------------------*/
		
		wp_register_script('pfsearch-select2-js', get_template_directory_uri() . '/js/select2.min.js', array('jquery'), '3.5.4',true); 
		wp_register_style('pfsearch-select2-css', get_template_directory_uri() . '/css/select2.css', array(), '3.5.4', 'all');

        /* All Scripts Packaged */
		wp_register_script('pftheme-minified-package', get_template_directory_uri() . '/js/pointfinder.min.package.js', array('jquery'), '1.0',true); 
        wp_enqueue_script('pftheme-minified-package'); 
        wp_localize_script( 'pftheme-minified-package', 'pftheme_minified_package', array(
        	'w1' => esc_html__("This field is required","pointfindert2d")
        ));

        /* Dropzone */
		wp_register_script('theme-dropzone', get_template_directory_uri() . '/js/dropzone.min.js', array('jquery'), '4.0',true); 

		/* Infinite scroll */
		wp_register_script('theme-infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'), '2.0',true); 
 
		
		/* Owl Carousel */
		if ($general_rtlsupport == 1) {
			wp_register_script('theme-OwlCarousel', get_template_directory_uri() . '/js/owl.carousel.min.rtl.js', array('jquery'), '1.3.1',true); 
		}else{
			wp_register_script('theme-OwlCarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '1.3.2',true); 
		}
		
        wp_enqueue_script('theme-OwlCarousel'); 


		/* Resp. Menu Nav*/
		if ($usemin == 1) {$script_file_3n = "responsive_menu.min.js";}else{$script_file_3n = "responsive_menu.js";}

		if ($general_rtlsupport == 1) {
			wp_register_script('theme-menunav', get_template_directory_uri() . '/js/responsive_menu_rtl.js', array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-tooltip','jquery-effects-core','pftheme-minified-package','jquery-ui-slider','jquery-effects-fade','jquery-effects-slide','jquery-ui-dialog'), '1.0.0',true); 
		}else{
			wp_register_script('theme-menunav', get_template_directory_uri() . '/js/'.$script_file_3n, array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-tooltip','jquery-effects-core','pftheme-minified-package','jquery-ui-slider','jquery-effects-fade','jquery-effects-slide','jquery-ui-dialog'), '1.0.0',true); 
		}
        wp_enqueue_script('theme-menunav'); 

        if(is_user_logged_in()){
        	$login_register_system = PFSAIssetControl('setup4_membersettings_loginregister','','1');
        	wp_register_script('theme-upload-map-functions', get_template_directory_uri() . '/js/theme-upload-map-functions.js', array('theme-gmap3'), '1.0',true); 

        	if( $login_register_system == 1){
	        	if(!wp_style_is('pfsearch-select2-css', 'enqueued')){wp_enqueue_style('pfsearch-select2-css');}
				if(!wp_script_is('pfsearch-select2-js', 'enqueued')){wp_enqueue_script('pfsearch-select2-js');}	
			}
   	 	}

   	 	if ($usemin == 1) {$script_file_4n = "theme-scripts-header.min.js";}else{$script_file_4n = "theme-scripts-header.js";}
   	 	wp_register_script('theme-scriptsheader', get_template_directory_uri() . '/js/'.$script_file_4n, array('jquery'), '1.0.0'); 
        wp_enqueue_script('theme-scriptsheader'); 

        $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
        $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
		$pfmenu_perout = PFPermalinkCheck();

		if ($usemin == 1) {$script_file_1n = "theme-scripts.min.js";}else{$script_file_1n = "theme-scripts.js";}

		wp_register_script('theme-scriptspf', get_template_directory_uri() . '/js/'.$script_file_1n, array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-tooltip','jquery-effects-core','pftheme-minified-package','jquery-ui-slider','jquery-effects-fade','jquery-effects-slide','jquery-ui-dialog','pftheme-minified-package'), '1.0.0',true); 
        wp_enqueue_script('theme-scriptspf'); 
        wp_localize_script( 'theme-scriptspf', 'theme_scriptspf', array( 
			'ajaxurl' => get_template_directory_uri().'/admin/core/pfajaxhandler.php',
			'homeurl' => esc_url(home_url()),
			'pfget_usersystem' => wp_create_nonce('pfget_usersystem'),
			'pfget_modalsystem' => wp_create_nonce('pfget_modalsystem'),
			'pfget_usersystemhandler' => wp_create_nonce('pfget_usersystemhandler'),
			'pfget_modalsystemhandler' => wp_create_nonce('pfget_modalsystemhandler'),
			'pfget_favorites' => wp_create_nonce('pfget_favorites'),
			'pfget_searchitems' => wp_create_nonce('pfget_searchitems'),
			'pfget_reportitem' => wp_create_nonce('pfget_reportitem'),
			'pfget_claimitem' => wp_create_nonce('pfget_claimitem'),
			'pfget_flagreview' => wp_create_nonce('pfget_flagreview'),
			'pfget_grabtweets' => wp_create_nonce('pfget_grabtweets'),
			'pfget_autocomplete' => wp_create_nonce('pfget_autocomplete'),
			'recaptchapkey' => PFRECIssetControl('setupreCaptcha_general_pubkey','','""'),
			'pfnameerr' => esc_html__('Please write name','pointfindert2d'),
			'pfemailerr' => esc_html__('Please write email','pointfindert2d'),
			'pfemailerr2' => esc_html__('Please write correct email','pointfindert2d'),
			'pfmeserr' => esc_html__('Please write message','pointfindert2d'),
			'userlog' => (is_user_logged_in())? 1:0,
			'dashurl' => ''.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=newitem',
			'profileurl' => ''.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=profile',
			'pfselectboxtex' => esc_html__('Please Select','pointfindert2d'),
			'pfcurlang' => PF_current_language()
		));
		
		

		if ($usemin == 1) {$script_file_member = "theme-scripts-dash.min.js";}else{$script_file_member = "theme-scripts-dash.js";}
		if (is_page($setup4_membersettings_dashboard)) {

			$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');
			wp_register_script('theme-scriptspfm', get_template_directory_uri() . '/js/'.$script_file_member, array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-tooltip','jquery-effects-core','pftheme-minified-package','jquery-ui-slider','jquery-effects-fade','jquery-effects-slide','jquery-ui-dialog','theme-scriptspf'), '1.0.0',true); 
	        wp_enqueue_script('theme-scriptspfm'); 
	        wp_localize_script( 'theme-scriptspfm', 'theme_scriptspfm', array( 
				'delmsg' => esc_html__('Are you sure that you want to delete this? (This action cannot rollback.)','pointfindert2d'),
				'pfget_imagesystem' => wp_create_nonce('pfget_imagesystem'),
				'pfget_onoffsystem' => wp_create_nonce('pfget_onoffsystem'),
				'pfget_filesystem' => wp_create_nonce('pfget_filesystem'),
				'pfget_itemsystem' => wp_create_nonce('pfget_itemsystem'),
				'pfget_fieldsystem' => wp_create_nonce('pfget_fieldsystem'),
				'pfget_featuresystem' => wp_create_nonce('pfget_featuresystem'),
				'pfget_customtabsystem' => wp_create_nonce('pfget_customtabsystem'),
				'pfget_posttag' => wp_create_nonce('pfget_posttag'),
				'pfget_lprice' => wp_create_nonce('pfget_lprice'),
				'pfcurlang' => PF_current_language(),
				'mobiledropdowns' => $as_mobile_dropdowns,
				'pfget_paymentsystem' => wp_create_nonce('pfget_paymentsystem'),
				'pfget_membershipsystem' => wp_create_nonce('pfget_membershipsystem'),
				'paypalredirect' => esc_html__('Redirecting to Paypal','pointfindert2d'),
				'generalredirect' => esc_html__('Redirecting','pointfindert2d'),
				'paypalredirect2' => esc_html__('Process Starting','pointfindert2d'),
				'paypalredirect3' => esc_html__('Finishing Process','pointfindert2d'),
				'paypalredirect4' => esc_html__('Done. Redirecting...','pointfindert2d'),
				'buttonwait' => esc_html__('Please wait...','pointfindert2d'),
				'buttonwaitex' => esc_html__('Submit Again','pointfindert2d'),
				'buttonwaitex2' => PFSAIssetControl('setup29_dashboard_contents_submit_page_menuname','',''),
				'dashurl' => ''.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=newitem',
				'dashurl2' => ''.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems',
				'dashtext1' => esc_html__("This is your cover photo and can not remove. Please change your cover photo first.","pointfindert2d" ),
				'dashtext2' => esc_html__("Are you sure want to delete this item? (This action can not be rollback.","pointfindert2d" ),
			));
		}		
		
		
		$maplanguage = PFSAIssetControl('setup5_mapsettings_maplanguage','','en');
		$setup5_map_key = PFSAIssetControl('setup5_map_key','','');
		if (!empty($setup5_map_key)) {
			$setup5_map_key = '&key='.$setup5_map_key;
		}else{
			$setup5_map_key = '';
		}

		if ($usemin == 1) {$script_file_2n = "theme-map-functions.min.js";}else{$script_file_2n = "theme-map-functions.js";}

		wp_register_script('theme-google-api', 'https://maps.googleapis.com/maps/api/js?v=3.23&libraries=places&language='.$maplanguage.$setup5_map_key, array('jquery'), '',true); 
		wp_register_script('theme-gmap3', get_template_directory_uri() . '/js/gmap3.js', array('theme-google-api'), '6.1',true); 
		wp_register_script('theme-map-functionspf', get_template_directory_uri() . '/js/'.$script_file_2n, array('theme-gmap3','pftheme-minified-package','theme-scriptspf'), '1.0.0',true);
		
		global $post;

		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		$pfpage_post_type = get_post_type();

		if (isset($post)) {
			if (!is_single() && (has_shortcode($post->post_content,'pf_itemgrid2') || is_archive() || is_category() || is_search())) {
				wp_enqueue_script('theme-infinitescroll'); 
			}
			if( (is_single() || has_shortcode( $post->post_content, 'pf_contact_map') || has_shortcode( $post->post_content, 'pf_directory_map')) || $pfpage_post_type == $setup3_pointposttype_pt1 || (isset($_GET['action']) && $_GET['action'] == 'pfs')) {
		       /* Map */
		        wp_enqueue_script('theme-google-api');
				wp_enqueue_script('theme-gmap3'); 
				
				if(!wp_style_is('pfsearch-select2-css', 'enqueued')){wp_enqueue_style('pfsearch-select2-css');}
				if(!wp_script_is('pfsearch-select2-js', 'enqueued')){wp_enqueue_script('pfsearch-select2-js');}	
			
				/* Map Functions */
				wp_enqueue_script('theme-map-functionspf');
				wp_localize_script( 'theme-map-functionspf', 'theme_map_functionspf', array( 
					'ajaxurl' => get_template_directory_uri().'/admin/core/pfajaxhandler.php',
					'template_directory' => get_template_directory_uri(),
					'pfget_infowindow' => wp_create_nonce('pfget_infowindow'),
					'pfget_markers' => wp_create_nonce('pfget_markers'),
					'pfget_taxpoint' => wp_create_nonce('pfget_taxpoint'),
					'pfget_listitems' => wp_create_nonce('pfget_listitems'),
					'resizeword' => esc_html__('Resize','pointfindert2d'),
					'pfcurlang' => PF_current_language(),
					'defmapdist' => PFSAIssetControl('setup7_geolocation_distance','',10),
				));
		    }
		}


		if ( is_active_widget( false, '', 'pf_twitter_w', true ) ) {
			wp_register_script('pointfinder-twitterspf', get_template_directory_uri() . '/js/twitterwebbu.js', array('jquery'), '1.0.0',true); 
	        wp_enqueue_script('pointfinder-twitterspf'); 
	        wp_localize_script( 'pointfinder-twitterspf', 'pointfinder_twitterspf', array( 
				'ajaxurl' => get_template_directory_uri().'/admin/core/pfajaxhandler.php',
				'pfget_grabtweets' => wp_create_nonce('pfget_grabtweets'),
				'grabtweettext' => esc_html__('Please control secret keys!','pointfindert2d')
			));
		}
		
		

		
		/*------------------------------------*\
			Styles
		\*------------------------------------*/
		
		wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.2', 'all');
		wp_enqueue_style('bootstrap'); 

	    wp_register_style('fontellopf', get_template_directory_uri() . '/css/fontello.min.css', array(), '1.0', 'all');
	    wp_enqueue_style( 'fontellopf' );
	    
	    wp_register_style('flaticons', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0', 'all');

	    wp_register_style('theme-dropzone', get_template_directory_uri() . '/css/dropzone.min.css', array(), '1.0', 'all');

	    if (isset($post)) {
		    if( (has_shortcode( $post->post_content, 'pf_directory_map')) || $pfpage_post_type == $setup3_pointposttype_pt1 || (isset($_GET['action']) && $_GET['action'] == 'pfs')) {
			    wp_enqueue_style( 'flaticons' );
		    }
		}

	    global $wp_styles;
	    $wp_styles->add('fontello-pf-ie7', get_template_directory_uri() . '/css/fontello-ie7.css');
	    $wp_styles->add_data('fontello-pf-ie7', 'conditional', 'IE 7');
	    $wp_styles->add('fontello-pf-ie8x', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
	    $wp_styles->add_data('fontello-pf-ie8x', 'conditional', 'lte IE 8');


				
		wp_register_style('theme-prettyphotocss', get_template_directory_uri() . '/css/prettyPhoto.css', array(), '1.0', 'all',true);
		wp_enqueue_style('theme-prettyphotocss'); 
		
		wp_register_style('theme-style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
		wp_enqueue_style('theme-style');

		if ($general_rtlsupport == 1) {
			wp_register_style('theme-owlcarousel', get_template_directory_uri() . '/css/owl.carousel.min.rtl.css', array(), '1.0', 'all');
		}else{
			wp_register_style('theme-owlcarousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '1.0', 'all');
		}
		wp_enqueue_style('theme-owlcarousel');	
		
		wp_register_style('pfcss-animations', get_template_directory_uri() . '/css/animate.min.css', array(), '1.0', 'all');
		wp_enqueue_style('pfcss-animations'); 	
		
		if ($usemin == 1) {$script_file_4n = "golden-forms.min.css";}else{$script_file_4n = "golden-forms.css";}
		wp_register_style('pfsearch-goldenforms-css', get_template_directory_uri() . '/css/'.$script_file_4n, array(), '1.0', 'all');
		wp_enqueue_style('pfsearch-goldenforms-css');
		

		
		/*-------------------------------------------*\
			Dynamic Styles - Backup compiler export.
		\*-------------------------------------------*/
		$uploads = wp_upload_dir();
		$pfcssstyle = get_option( 'pointfinder_cssstyle');
		$pfcssstyle = ($pfcssstyle)? $pfcssstyle : 'realestate';
		

		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-frontend.css' )) {
			wp_register_style('pf-frontend-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-frontend.css', array(), time(), 'all');
			wp_enqueue_style('pf-frontend-compiler');
		}else{
			if($pfcssstyle == 'realestate' || empty($pfcssstyle)){
				wp_register_style('pf-frontend-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/pf-style-frontend.css', array(), '', 'all');
				wp_enqueue_style('pf-frontend-compiler-local');
			}elseif ($pfcssstyle == 'directory') {
				wp_register_style('pf-frontend-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/directory/pf-style-frontend.css', array(), '', 'all');
				wp_enqueue_style('pf-frontend-compiler-local');
			}elseif ($pfcssstyle == 'multidirectory') {
				wp_register_style('pf-frontend-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/multidirectory/pf-style-frontend.css', array(), '', 'all');
				wp_enqueue_style('pf-frontend-compiler-local');
			}elseif ($pfcssstyle == 'cardealer') {
				wp_register_style('pf-frontend-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/cardealer/pf-style-frontend.css', array(), '', 'all');
				wp_enqueue_style('pf-frontend-compiler-local');
			}elseif ($pfcssstyle == 'construction') {
				wp_register_style('pf-frontend-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/construction/pf-style-frontend.css', array(), '', 'all');
				wp_enqueue_style('pf-frontend-compiler-local');
			}
		}

		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-main.css' ) ) {
			wp_register_style('pf-main-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-main.css', array(), time(), 'all');
			wp_enqueue_style('pf-main-compiler'); 	
		}else{

			wp_register_style('pf-opensn', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), '', 'all');
			wp_enqueue_style('pf-opensn');

			if($pfcssstyle == 'realestate'){
				wp_register_style('pf-main-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/pf-style-main.css', array(), '', 'all');
				wp_enqueue_style('pf-main-compiler-local');
			}elseif ($pfcssstyle == 'directory') {
				wp_register_style('pf-main-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/directory/pf-style-main.css', array(), '', 'all');
				wp_enqueue_style('pf-main-compiler-local');
			}elseif ($pfcssstyle == 'multidirectory') {
				wp_register_style('pf-main-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/multidirectory/pf-style-main.css', array(), '', 'all');
				wp_enqueue_style('pf-main-compiler-local');
			}elseif ($pfcssstyle == 'cardealer') {
				wp_register_style('pf-main-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/cardealer/pf-style-main.css', array(), '', 'all');
				wp_enqueue_style('pf-main-compiler-local');
			}elseif ($pfcssstyle == 'construction') {
				wp_register_style('pf-main-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/construction/pf-style-main.css', array(), '', 'all');
				wp_enqueue_style('pf-main-compiler-local');
			}
		}

		if (PFASSIssetControl('st8_npsys','',0) == 1) {
			wp_register_style('pf-ncpt-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-ncpt.css', array(), time(), 'all');
			wp_enqueue_style('pf-ncpt-compiler');
		}else{


			if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-custompoints.css' ) ) {
				wp_register_style('pf-customp-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-custompoints.css', array(), time(), 'all');
				wp_enqueue_style('pf-customp-compiler');
			}else{
				if($pfcssstyle == 'realestate'){
					wp_register_style('pf-customp-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/pf-style-custompoints.css', array(), '', 'all');
					wp_enqueue_style('pf-customp-compiler-local');
				}elseif ($pfcssstyle == 'directory') {
					wp_register_style('pf-customp-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/directory/pf-style-custompoints.css', array(), '', 'all');
					wp_enqueue_style('pf-customp-compiler-local');
				}elseif ($pfcssstyle == 'multidirectory') {
					wp_register_style('pf-customp-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/multidirectory/pf-style-custompoints.css', array(), '', 'all');
					wp_enqueue_style('pf-customp-compiler-local');
				}elseif ($pfcssstyle == 'cardealer') {
					wp_register_style('pf-customp-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/cardealer/pf-style-custompoints.css', array(), '', 'all');
					wp_enqueue_style('pf-customp-compiler-local');
				}elseif ($pfcssstyle == 'construction') {
					wp_register_style('pf-customp-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/construction/pf-style-custompoints.css', array(), '', 'all');
					wp_enqueue_style('pf-customp-compiler-local');
				}
			}
		}

		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-pbstyles.css' ) ) {
			wp_register_style('pf-pbstyles-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-pbstyles.css', array(), time(), 'all');
			wp_enqueue_style('pf-pbstyles-compiler');
		}else{
			wp_register_style('pf-pbstyles-compiler-local', get_template_directory_uri() . '/admin/options/pfstyles/pf-style-pbstyles.css', array(), '', 'all');
			wp_enqueue_style('pf-pbstyles-compiler-local');
		}

		
		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-custom.css' ) ) {
			wp_register_style('pf-custom-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-custom.css', array(), time(), 'all');
			wp_enqueue_style('pf-custom-compiler');
		}
		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-search.css' ) ) {
			wp_register_style('pf-search-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-search.css', array(), time(), 'all');
			wp_enqueue_style('pf-search-compiler');
		}else{
			if ($pfcssstyle == 'cardealer') {
				wp_register_style('pf-customp-search-local', get_template_directory_uri() . '/admin/options/pfstyles/cardealer/pf-style-search.css', array(), '', 'all');
				wp_enqueue_style('pf-customp-search-local');
			}
		}

		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-review.css' ) ) {
			wp_register_style('pf-review-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-review.css', array(), time(), 'all');
			wp_enqueue_style('pf-review-compiler');
		}else{
			if ($pfcssstyle == 'directory') {
				wp_register_style('pf-main-review-local', get_template_directory_uri() . '/admin/options/pfstyles/directory/pf-style-review.css', array(), '', 'all');
				wp_enqueue_style('pf-main-review-local');
			}
		}


		if ( file_exists( $uploads['basedir'] . '/pfstyles/pf-style-review.css' ) ) {
			wp_register_style('pf-review-compiler', $uploads['baseurl'] . '/pfstyles/pf-style-review.css', array(), time(), 'all');
			wp_enqueue_style('pf-review-compiler');
		}else{
			if ($pfcssstyle == 'multidirectory') {
				wp_register_style('pf-main-review-local', get_template_directory_uri() . '/admin/options/pfstyles/multidirectory/pf-style-review.css', array(), '', 'all');
				wp_enqueue_style('pf-main-review-local');
			}
		}


		/*
		*Added with v1.6.2 Update - Stripe Checkout JS
		*/
		if(isset($_GET['ua']) && $_GET['ua']!=''){
			$ua_action = esc_attr($_GET['ua']);
			if (in_array($ua_action, array('newitem','edititem','myitems','purchaseplan','renewplan','upgradeplan'))) {
				$setup20_stripesettings_status = PFSAIssetControl('setup20_stripesettings_status','','0');
				if ($setup20_stripesettings_status == 1) {
					wp_register_script('theme-stripeaddon', 'https://checkout.stripe.com/checkout.js', array('jquery'), '1.0.0'); 
        			wp_enqueue_script('theme-stripeaddon'); 

        			wp_register_script('theme-stripeaddon2', 'https://js.stripe.com/v2/', array('jquery'), '2.0.0');
        			wp_enqueue_script('theme-stripeaddon2'); 
				}
			} 
			
		}
		

}



function pf_admin_styleandscripts(){
	$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
	
	//Script and styles
    wp_register_style('pfadminstyles', get_template_directory_uri() . '/admin/core/css/style.css', array(), '1.0', 'all');
    wp_register_style('redux-custompf-css', get_template_directory_uri() . '/admin/options/custom/custom.css', array() , '','all');
   
	global $pagenow; global $post_type;
	

    $pagename = (isset($_GET['page']))?$_GET['page']:'';

    if ($pagenow == 'admin.php' && $pagename == '_pointfinderoptions') {
		wp_enqueue_style('redux-custompf-css');
    }

	if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && in_array($post_type, array($setup3_pointposttype_pt1,'page','post')) ){
		wp_enqueue_style('pfadminstyles');
	}

	if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && in_array($post_type, array('pointfinderreviews')) ){
		wp_register_style('fontellopf', get_template_directory_uri() . '/css/fontello.min.css', array(), '1.0', 'all');
		wp_enqueue_style('fontellopf');
		wp_enqueue_style('pfadminstyles');
	}

	//Script and styles
	wp_register_script('pfa-select2-js', get_template_directory_uri() . '/admin/includes/vcextend/assets/js/select2.min.js', array('jquery'), '3.5.4',true); 
	wp_register_style('pfa-select2-css', get_template_directory_uri() . '/admin/includes/vcextend/assets/css/select2.css', array(), '3.5.4', 'all');
	wp_register_style('pfa-vcextend-css', get_template_directory_uri() . '/admin/includes/vcextend/assets/css/vc_extend.css', array(), '1.0.0', 'all');
	wp_register_script('pfa-scripts-js', get_template_directory_uri() . '/admin/includes/vcextend/assets/js/scripts.js', array('jquery'), '1.0',true); 
    wp_register_style('fontellopf', get_template_directory_uri() . '/css/fontello.min.css', array(), '1.0', 'all');

    wp_register_script('pfa-contactmap-js', get_template_directory_uri() . '/admin/includes/vcextend/assets/js/contactmap.js', array('jquery'), '1.0',true); 
    wp_register_style('pfa-contactmap-css', get_template_directory_uri() . '/admin/includes/vcextend/assets/css/contactmap.css', array(), '1.0', 'all');
   
	global $pagenow; global $post_type;
	
	if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && in_array($post_type, array($setup3_pointposttype_pt1,'page','post','pointfinderreviews')) ){
    	
    	wp_enqueue_script('pfa-contactmap-js');
    	wp_enqueue_style('pfa-contactmap-css');
		wp_enqueue_script('pfa-scripts-js');
		wp_enqueue_script('pfa-select2-js');
		wp_enqueue_style('pfa-select2-css');
		wp_enqueue_style('pfa-vcextend-css');
		wp_enqueue_style('fontellopf');


		global $wp_styles;
	    $wp_styles->add('fontello-pf-ie7', get_template_directory_uri() . '/css/fontello-ie7.css');
	    $wp_styles->add_data('fontello-pf-ie7', 'conditional', 'IE 7');
	}


	if ($post_type == $setup3_pointposttype_pt1) {
		wp_register_style('itempage-custom.', get_template_directory_uri() . '/admin/core/css/itempage-custom.css', array(), '1.0', 'all');
		wp_enqueue_style('itempage-custom.'); 
	}
	if ($post_type == $setup3_pointposttype_pt1 && PFSAIssetControl('general_rtlsupport','','0') == 1) {
		wp_register_style('itempage-custom-rtl.', get_template_directory_uri() . '/admin/core/css/itempage-custom-rtl.css', array(), '1.0', 'all');
		wp_enqueue_style('itempage-custom-rtl.'); 
	}

	$special_codes = get_current_screen();

	if ((($pagenow == "term.php" || $pagenow == 'edit-tags.php') && in_array($special_codes->taxonomy, array('pointfinderitypes', 'pointfinderfeatures', 'pointfinderconditions'))) || ($pagenow == 'post.php' && $post_type == $setup3_pointposttype_pt1) || ($pagenow == 'post-new.php' && $post_type == $setup3_pointposttype_pt1)) {

		wp_enqueue_script('jquery'); 

		wp_register_style('bootstrap-fadmincss', get_template_directory_uri() . '/admin/core/css/bootstrap-3.3.2.min.css', array(), '3.3.2', 'all');
		wp_enqueue_style('bootstrap-fadmincss');

		wp_register_style('bootstrap-mselect', get_template_directory_uri() . '/admin/core/css/bootstrap-multiselect.css', array(), '2.0', 'all');
		wp_enqueue_style('bootstrap-mselect');

		wp_register_script('bootstrap-fadmin', get_template_directory_uri() . '/admin/core/js/bootstrap-3.3.2.min.js', array('jquery'), '3.3.2',true); 
		wp_enqueue_script('bootstrap-fadmin'); 

		wp_register_script('bootstrap-mselectjs', get_template_directory_uri() . '/admin/core/js/bootstrap-multiselect.js', array('jquery','bootstrap-fadmin'), '2.0',true); 
		wp_enqueue_script('bootstrap-mselectjs');

		wp_register_script('pointfinder-itempagescripts', get_template_directory_uri() . '/admin/core/js/itempage.js', array('jquery'), '1.0',true); 
		wp_enqueue_script('pointfinder-itempagescripts'); 
	}


}



?>