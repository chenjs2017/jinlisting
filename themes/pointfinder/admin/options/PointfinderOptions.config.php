<?php
/**********************************************************************************************************************************
*
* Main Admin Options Config File
*
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_Theme_Config")) {
	class Redux_Framework_PF_Theme_Config{

			public $args = array();
			public $sections = array();
			public $theme;
			public $ReduxFramework;
			

			public function __construct(){
	            if (!class_exists("ReduxFramework")) {return;}
	            if (  true == Redux_Helpers::isTheme(__FILE__) ) {$this->initSettings();} else {add_action('plugins_loaded', array($this, 'initSettings'), 10);}
			}

			

			public function initSettings(){
				$this->setArguments();
				$this->setSections();
				if (!isset($this->args['opt_name'])) {return;}

				add_action('redux/plugin/hooks', array($this,'remove_demo'));
				add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this,'dynamic_section'));
				add_filter('redux/options/' . $this->args['opt_name'] . '/compiler', array($this,'compiler_action') , 10, 2);
				
				$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
			}

			function compiler_action($options, $css){
				global $wp_filesystem;

				if ( defined( 'FS_CHMOD_FILE' ) ) {
				    $chmod_file = FS_CHMOD_FILE;
				} else {
				    $chmod_file = 0644;
				}

				if ( defined( 'FS_CHMOD_DIR' ) ) {
				    $chmod_dir = FS_CHMOD_DIR;
				} else {
				    $chmod_dir = 0755;
				}

	
				$uploads = wp_upload_dir();
				$upload_dir = trailingslashit($uploads['basedir']);
				$upload_dir = $upload_dir . '/pfstyles';
				if (! is_dir($upload_dir)) {mkdir( $upload_dir, $chmod_dir );}
				$filename = trailingslashit($uploads['basedir']) . '/pfstyles/pf-style-main' . '.css';
				
				if (empty($wp_filesystem)) {
					require_once (ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}
				if ($wp_filesystem) {$wp_filesystem->put_contents($filename, $css, $chmod_file);}
			}

			function dynamic_section( $sections ) {
                return $sections;
            }

			function remove_demo(){
				if (class_exists('ReduxFrameworkPlugin')) {remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance() ,'plugin_meta_demo_mode_link') , null, 2);}
				remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance() ,'admin_notices'));
				
			}

			public function setSections(){
			
			/**
			*Start : GENERAL SETTINS 
			**/
				/**
				*General Settings
				**/
				$this->sections[] = array(
					'id' => 'general',
					'title' => esc_html__('General Settings', 'pointfindert2d'),
					'icon' => 'el-icon-cogs',
					'fields' => array(
						array(
							'id' => 'general_hideadminbar',
							'type' => 'button_set',
							'title' => esc_html__('Admin Bar to Admins', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Show', 'pointfindert2d') ,
								'0' => esc_html__('Hide', 'pointfindert2d')
							) , 
							'default' => '1',
						) ,
						array(
							'id' => 'setup4_membersettings_hideadminbar',
							'type' => 'button_set',
							'title' => esc_html__('Admin Bar to Users', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Show', 'pointfindert2d') ,
								'0' => esc_html__('Hide', 'pointfindert2d')
							) ,
							'default' => '0'
						) ,
						array(
							'id' => 'general_retinasupport',
							'type' => 'button_set',
							'title' => esc_html__('Retina Images', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => '1',
						) ,
						array(
							'id' => 'general_crop',
							'type' => 'button_set',
							'title' => esc_html__('Crop Images', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Force Crop', 'pointfindert2d') ,
								'2' => esc_html__('Use Default', 'pointfindert2d'),
								'3' => esc_html__("Do NOT Change", 'pointfindert2d')
							) , 
							'default' => 2,
						) ,
						array(
							'id' => 'general_responsive',
							'type' => 'button_set',
							'title' => esc_html__('Responsive Feature', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => '1',
						) ,
						array(
							'id' => 'setup3_modulessetup_breadcrumbs',
							'type' => 'button_set',
							'title' => esc_html__('Breadcrumbs Module', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '1'
						) ,
						
						array(
							'id' => 'general_rtlsupport',
							'type' => 'button_set',
							'title' => esc_html__('RTL Support', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '0'
						) ,
						
					) ,
				);

				/**
				*Logo Settings
				**/
				$this->sections[] = array(
					'id' => 'setup18_headerbarsettings',
					'subsection' => true,
					'title' => esc_html__('Logo Settings', 'pointfindert2d'),
					'fields' => array(
							
							array(
		                        'id'        => 'setup17_logosettings_sitelogo',
		                        'type'      => 'media',
		                        'url'       => true,
		                        'title'     => esc_html__('Logo', 'pointfindert2d'),
		                        'hint'     => array('content' => esc_html__('This is non-retina logo.', 'pointfindert2d')),
		                    ),
		                    array(
		                        'id'        => 'setup17_logosettings_sitelogo2x',
		                        'type'      => 'media',
		                        'url'       => true,
		                        'title'     => esc_html__('Retina Logo (2x)', 'pointfindert2d'),
		                        'hint'     => array('content' => esc_html__('This is retina logo. Please upload 2x size.', 'pointfindert2d')),
		                    ),

		                    array(
		                        'id'        => 'setup17_logosettings_sitelogo2',
		                        'type'      => 'media',
		                        'url'       => true,
		                        'title'     => esc_html__('Additional Logo', 'pointfindert2d'),
		                        'hint'     => array('content' => esc_html__('This is non-retina logo. Note: Additional logo designed for second logo which for use in pages.', 'pointfindert2d')),
		                    ),
		                    array(
		                        'id'        => 'setup17_logosettings_sitelogo22x',
		                        'type'      => 'media',
		                        'url'       => true,
		                        'title'     => esc_html__('Retina Additonal Logo (2x)', 'pointfindert2d'),
		                        'hint'     => array('content' => esc_html__('This is retina logo. Please upload 2x size.', 'pointfindert2d')),
		                    ),

		                    array(
		                        'id'        => 'setup17_logosettings_sitefavicon',
		                        'type'      => 'media',
		                        'url'       => true,
		                        'preview'   => false,
		                        'title'     => esc_html__('Favicon', 'pointfindert2d'),
		                        'hint'     => array('content' => esc_html__('Recommended size 57px/57px.', 'pointfindert2d')),
		                    ),
		                    array(
		                        'id'            => 'setup18_headerbarsettings_padding',
		                        'type'          => 'spacing',
		                        'mode'          => 'margin',   
		                        'all'			=> false,
		                        'right'         => false,
		                        'bottom'        => false,
		                        'left'          => false,
		                        'units'         => array('px'),
		                        'units_extended'=> 'false',
		                        'display_units' => 'true',
		                        'title'         => esc_html__('Logo Top Margin', 'pointfindert2d'),
		                        'desc'          => esc_html__('Logo area top margin.', 'pointfindert2d'),
		                        'default'       => array(
		                            'margin-top'    => '30px', 
		                        )
		                    )
		                    
					) ,
				);


				/**
				*Google Analytics
				**/
				$this->sections[] = array(
					'id' => 'general_google',
					'title' => esc_html__('Google Analytics', 'pointfindert2d'),
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'googleanalytics_code',
							'type' => 'ace_editor',
							'title' => esc_html__('Google Analytics Code', 'pointfindert2d') ,
							'mode' => 'javascript',
							'theme' => 'chrome',
							'desc' => '<strong>'.esc_html__('Please copy & paste your google analytic code without <script> </script> tags.', 'pointfindert2d').'</strong>'
						) 
					) ,
				);


				/**
				*Custom Css
				**/
				$this->sections[] = array(
					'id' => 'general_css',
					'title' => esc_html__('Custom Css', 'pointfindert2d'),
					'subsection' => true,
					'fields' => array(
						array(
	                        'id'        => 'pf_general_csscode',
	                        'type'      => 'ace_editor',
	                        'title'     => esc_html__('CSS Code', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('Paste your CSS code here.', 'pointfindert2d'),
	                        'mode'      => 'css',
	                        'theme'     => 'monokai',
	                        'desc'      => __('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'pointfindert2d'),
	                        'default'   => ""
	                    ),
					) ,
				);
			/**
			*End : GENERAL SETTINS 
			**/




			/**
			*Start : THEME CUSTOMIZER
			**/
				$this->sections[] = array(
					'id' => 'general_tcus',
					'title' => esc_html__('Theme Customizer', 'pointfindert2d'),
					'icon' => 'el-icon-magic',
					'fields' => array()
						
				);
				/**
				*Top Line: Styles
				**/
				$this->sections[] = array(
					'id' => 'setup27_socialiconsbarstyles',
					'subsection' => true,
					'title' => esc_html__('Top Line: Layout', 'pointfindert2d'),
					'desc' => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to top page line.<br /> You can change styles of this area by using below options.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_topline.png" class="description-img" />'),
					'fields' => array(
							array(
								'id' => 'setup19_socialiconsbarsettings_phoneemail_typo',
								'type' => 'typography',
								'title' => esc_html__('Top Line Area Typography', 'pointfindert2d') ,
								'subtitle' => esc_html__('This section will affect Phone/Email/My Account menu texts', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'color' => false,
								'line-height' => false,
								'compiler' => array(
									'.wpf-header .pf-sociallinks .pf-infolinks-item a span',
									'#pf-topprimary-nav .pfnavmenu li a'
								) ,
								'units' => 'px',
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '13px',
									
								) ,
								
							) ,
							array(
								'id' => 'setup19_socialiconsbarsettings_theme_bg',
								'type' => 'color',
								'mode' => 'background',
								'transparent' => false,
								'compiler' => array(
									'.wpf-header .pftopline'
								) ,
								'title' => esc_html__('Top Line Area Background', 'pointfindert2d') ,
								'default' => '#28353d',
								'validate' => 'color',
								
							) ,
							array(
								'id' => 'setup27_socialiconsbarstyles_theme_textcolor',
								'type' => 'link_color',
								'title' => esc_html__('Top Line Area Text Color', 'pointfindert2d') ,
								'active' => false,
								'compiler' => array(
									'.wpf-header .pf-sociallinks .pf-sociallinks-item a',
									'.wpf-header .pf-sociallinks .pf-sociallinks-item.pf-infolinks-item a',
									'#pf-topprimary-nav .pfnavmenu li a',
									'.wpf-header .pf-sociallinks .pf-sociallinks-item',
									'.wpf-header .pf-sociallinks .pf-sociallinks-item.pf-infolinks-item',
									'#pf-topprimary-nav .pfnavmenu li'
								) ,
								'default' => array(
									'regular' => '#e8e8e8',
									'hover' => '#fff'
								) ,
							) ,
							array(
								'id' => 'setup27_socialiconsbarstyles_dropdown_backgrounds',
								'type' => 'extension_custom_link_color',
								'mode' => 'background',
								'transparent' => false,
								'active' => false,
								'compiler' => array(
									'#pf-topprimary-nav .pfnavmenu .pfnavsub-menu li'
								) ,
								'title' => esc_html__('My Account: Dropdown Menu Background', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#28353d',
									'hover' => '#a32221'
								) ,
								'validate' => 'color',
								
							) ,
							array(
								'id' => 'setup27_socialiconsbarstyles_dropdown_textc',
								'type' => 'link_color',
								'transparent' => false,
								'active' => false,
								'compiler' => array(
									'#pf-topprimary-nav .pfnavmenu .pfnavsub-menu li'
								) ,
								'title' => esc_html__('My Account: Dropdown Menu Text', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#fff',
									'hover' => '#fff'
								) ,
								'validate' => 'color',
								
							) ,
							
					)
				);
				
				/**
				*Top Line: Social Links
				**/
				$this->sections[] = array(
					'id' => 'setup19_socialiconsbarsettings',
					'subsection' => true,
					'title' => esc_html__('Top Line: Social Links', 'pointfindert2d'),
					'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to social links.', 'pointfindert2d').'<br />'.esc_html__('You can change styles of this area by using below options. You can add 8 socials links at most simultaneously.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_toplinesc.png" class="description-img" />'),
					'fields' => array(
							
							array(
								'id' => 'setup19_socialiconsbarsettings_main',
								'type' => 'switch',
								'title' => esc_html__('Top Line: Social Links', 'pointfindert2d') ,
								'on' => esc_html__('Enable', 'pointfindert2d') ,
								'off' => esc_html__('Disable', 'pointfindert2d'),
								'default' => '1'
							) ,
							array(
		                        'id'        => 'setup19_socialiconsbarsettings_envelope',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Email Link Text', 'pointfindert2d'),
								'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_envelope_link',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Email Link URL', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_phone',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Phone Link Text', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_phone_link',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Phone Link URL', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),

		                    
							array(
		                        'id'        => 'setup19_socialiconsbarsettings_facebook',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Facebook Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_twitter',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Twitter Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_linkedin',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Linkedin Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_google-plus',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Google Plus Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_pinterest',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Pinterest Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_dribbble',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Dribbble Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_dropbox',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Dropbox Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_flickr',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Flickr Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_github',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Github Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_instagram',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Instagram Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_rss',
		                        'type'      => 'text',
		                        'title'     => esc_html__('RSS Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_skype',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Skype Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_tumblr',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Tumblr Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_vk',
		                        'type'      => 'text',
		                        'title'     => esc_html__('VK Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup19_socialiconsbarsettings_youtube',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Youtube Link', 'pointfindert2d'),
		                        'required' => array('setup19_socialiconsbarsettings_main','=',1)
		                    ),

						) ,
				);
				

				
				/**
				*Menu Layout
				**/
				$this->sections[] = array(
					'id' => 'setup28_menustyles',
					'subsection' => true,
					'title' => esc_html__('Menu Layout', 'pointfindert2d'),
					'fields' => array(
							array(
								'id' => 'setup18_headerbarsettings_info',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to Menu Bar.<br /> You can change styles of this area by using below options. You can also change styles of sticky menu.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_menubar.png" class="description-img" />'),
							) ,
							array(
		                        'id'        => 'setup18_headerbarsettings_bgcolor',
		                        'type'      => 'color_rgba',
		                        'title'     => esc_html__('Menu Bar Background', 'pointfindert2d'),
		                        'default'   => array('color' => '#f7f7f7', 'alpha' => '1'),
		                        'compiler'    => array('.wpf-header','#pf-topprimary-navmobi','#pf-topprimary-navmobi2'),
		                        'mode'      => 'background',
		                        'transparent' => false,
		                        'validate'  => 'colorrgba',
		                    ),
		                    array(
		                        'id'        => 'setup18_headerbarsettings_bgcolor2',
		                        'type'      => 'color_rgba',
		                        'title'     => esc_html__('Menu Bar Background', 'pointfindert2d'),
		                        'subtitle'     => esc_html__('Sticky Menu', 'pointfindert2d'),
		                        'default'   => array('color' => '#f7f7f7', 'alpha' => '0.9'),
		                        'compiler'    => array('.wpf-header.pfshrink'),
		                        'mode'      => 'background',
		                        'transparent' => false,
		                        'validate'  => 'colorrgba',
		                    ),
		                    array(
		                        'id'        => 'setup18_headerbarsettings_bordersettings',
		                        'type'      => 'border',
		                        'title'     => esc_html__('Menu Bottom Border Color', 'pointfindert2d'),
		                        'compiler'    => array('.wpf-header'), 
		                        'all' => false,
		                        'right'  => false,
		                        'top'  => false,
		                        'left'  => false,
		                        'style' => false,
		                        'bottom' => true,
		                        'default'   => array(
		                            'border-color'  => '#c4c4c4', 
		                            'border-style'  => 'solid', 
		                            'border-top'    => '0', 
		                            'border-right'  => '0', 
		                            'border-bottom' => '1px', 
		                            'border-left'   => '0'
		                        )
		                    ),


		                    array(
								'id' => 'setup18_headerbarsettings_info2',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to Dropdown Menu.<br /> You can change styles of this area by using below options. ', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_menustyles.png" class="description-img" />'),
							) ,
							
							array(
								'id' => 'setup18_headerbarsettings_menulinecolor',
								'type' => 'color',
								'mode' => 'background',
								'transparent' => false,
								'title' => esc_html__('Main Menu: Active Line Color', 'pointfindert2d') ,
								'desc' => esc_html__('Colored line at bottom of the menu links.', 'pointfindert2d'),
								'default' => '#a32222',
								'validate' => 'color',
							) ,
							array(
								'id' => 'setup18_headerbarsettings_menucolor',
								'type' => 'link_color',
								'title' => esc_html__('Main Menu: Menu Link Color', 'pointfindert2d') ,
								'active' => false,
								'compiler' => array(
									'.wpf-header #pf-primary-nav .pfnavmenu li a',
									'.wpf-header #pf-primary-nav .pfnavmenu li.selected > a',
									'#pf-topprimary-navmobi .pf-nav-dropdownmobi li a',
									'#pf-topprimary-navmobi2 .pf-nav-dropdownmobi li a',
									'.pf-blank-th',
									'#pf-primary-nav-button',
									'#pf-topprimary-nav-button2',
									'#pf-topprimary-nav-button',
									'#pf-primary-search-button',
									'.anemptystylesheet'
								) ,
								'default' => array(
									'regular' => '#444444',
									'hover' => '#a32221'
								) ,
							) ,
							array(
								'id' => 'setup18_headerbarsettings_menutypo',
								'type' => 'typography',
								'title' => esc_html__('Main Menu: Menu Typography', 'pointfindert2d') ,
								'google' => true,
								'color' => false,
								'font-backup' => true,
								'compiler' => array(
									'.wpf-header #pf-primary-nav .pfnavmenu li a',
									'#pf-topprimary-navmobi .pf-nav-dropdownmobi li a',
									'#pf-topprimary-navmobi2 .pf-nav-dropdownmobi li a'
								) ,
								'units' => 'px',
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Open Sans',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '18px',
								) ,
								
							) ,
							array(
								'id' => 'setup18_headerbarsettings_help1',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc' => sprintf(esc_html__('%s Below settings will affect Sub Menus', 'pointfindert2d'),'<strong>'.esc_html__('Info:','pointfindert2d').'</strong>')
							) ,
							array(
			                        'id'            => 'setup18_headerbarsettings_menusubmenuwidth',
			                        'type'          => 'slider',
			                        'title'         => esc_html__( 'Sub Menu: Menu Width', 'pointfindert2d' ),
			                        'default'       => 214,
			                        'min'           => 50,
			                        'step'          => 1,
			                        'max'           => 1170,
			                        'display_value' => 'text'
			                    ),
							array(
								'id' => 'setup18_headerbarsettings_menucolor2_bg3',
								'type' => 'extension_custom_link_color',
								'mode' => 'background',
								'transparent' => false,
								'active' => false,
								'compiler' => array(
									'.wpf-header #pf-primary-nav .pfnavmenu .pfnavsub-menu li',
									'.anemptystylesheet'
								) ,
								'title' => esc_html__('Sub Menu: Background Color', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#ffffff',
									'hover' => '#ededed'
								) ,
								'validate' => 'color',
								
							) ,
							array(
								'id' => 'setup18_headerbarsettings_menucolor2',
								'type' => 'link_color',
								'title' => esc_html__('Sub Menu: Text Color', 'pointfindert2d') ,
								'active' => false,
								'compiler' => array(
									'.wpf-header #pf-primary-nav .pfnavmenu .pfnavsub-menu > li a.sub-menu-link',
									'.anemptystylesheet'
								) ,
								'default' => array(
									'regular' => '#282828',
									'hover' => '#000000'
								) ,
							) ,
							array(
		                        'id'        => 'setup18_headerbarsettings_bordersettingssub',
		                        'type'      => 'border',
		                        'title'     => esc_html__('Sub Menu: Bottom Border', 'pointfindert2d'),
		                        'all' => false,
		                        'right'  => false,
		                        'top'  => false,
		                        'left'  => false,
		                        'style' => false,
		                        'bottom' => false,
		                        'default'   => array(
		                            'border-color'  => '#ffffff', 
		                            'border-style'  => 'solid', 
		                            'border-top'    => '0', 
		                            'border-right'  => '0', 
		                            'border-bottom' => '1px', 
		                            'border-left'   => '0'
		                        )
		                    ),
							array(
								'id' => 'setup18_headerbarsettings_menutypo2',
								'type' => 'typography',
								'title' => esc_html__('Sub Menu: Menu Typography', 'pointfindert2d') ,
								'google' => true,
								'color' => false,
								'font-backup' => true,
								'compiler' => array(
									'.wpf-header #pf-primary-nav .pfnavmenu .pfnavsub-menu > li a.sub-menu-link'
								) ,
								'units' => 'px',
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Open Sans',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '18px',
								) ,
							) ,

					)
				);
				
				/**
				*Header Bar Layout
				**/
				$this->sections[] = array(
					'id' => 'setup43_themecustomizer1',
					'title' => esc_html__('Header Bar', 'pointfindert2d'),
					'subsection' => true,
					'heading'     => esc_html__('Default Page Header Bar', 'pointfindert2d'),
	                'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to Default Header Bar.<br /> You can define a default header bar when header bar could not be created by user. Ex:bbPress inner pages, DSI IDX inner pages, 404 page, category page, archive page etc..', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_forheader.png" class="description-img" />'),
					'fields' => array(
							array(
								'id' => 'setup43_themecustomizer_headerbar_shadowopt',
								'type' => 'button_set',
								'title' => esc_html__('Header Bar Shadow', 'pointfindert2d') ,
								'options' => array( 
									0 => esc_html__('Disabled', 'pointfindert2d'),
									1 => esc_html__('Shadow 1', 'pointfindert2d'),
									2 => esc_html__('Shadow 2', 'pointfindert2d'),
									),
								'default' => 2
							) ,
		                    array(
			                    'id'        => 'setup43_themecustomizer_titlebarcustomtext_color',
			                    'type'      => 'color',
			                    'compiler'    => array('.pf-defaultpage-header .main-titlebar-text','.pf-defaultpage-header .pf-breadcrumbs #pfcrumbs li a','.pf-defaultpage-header .pf-breadcrumbs #pfcrumbs li','.pf-itempage-header','.pf-breadcrumbs #pfcrumbs li a','.pf-breadcrumbs #pfcrumbs li'),
			                    'title'     => esc_html__('Text Color', 'pointfindert2d'),
			                    'validate'  => 'color',
			                    'default'	=> '#333333',
			                    'transparent'  => false,
			                ),
			                array(
		                        'id'       => 'setup43_themecustomizer_titlebarcustomtext_bgcolor',
		                        'type'     => 'color',
		                        'transparent' => false,
		                        'validate' => 'color',
		                        'title'    => esc_html__( 'Text Background Color', 'pointfindert2d' )
		                    ),
		                    array(
		                        'id'            => 'setup43_themecustomizer_titlebarcustomtext_bgcolorop',
		                        'type'          => 'slider',
		                        'title'         => esc_html__( 'Text Background Color Opacity', 'pointfindert2d' ),
		                        'default'       => 0,
		                        'min'           => 0,
		                        'step'          => .1,
		                        'max'           => 1,
		                        'resolution'    => 0.1,
		                        'display_value' => 'text'
		                    ),
							array(
								'id' => 'setup43_themecustomizer_titlebarcustomheight',
								'type' => 'dimensions',
								'compiler'  => array('.pf-defaultpage-header','.pf-defaultpage-header .col-lg-12','.pf-itempage-header','.pf-itempage-header .col-lg-12'),
								'units' => 'px',
								'units_extended' => 'false',
								'width' => 'false',
								'title' => esc_html__('Height', 'pointfindert2d') ,
								'default' => array(
									'height' => 100,
								)
							) ,
							array(
		                        'id'        => 'setup43_themecustomizer_titlebarcustombg',
		                        'type'      => 'background',
		                        'compiler'    => array('.pf-defaultpage-header','.pf-itempage-header'),
		                        'title'     => esc_html__('Background', 'pointfindert2d'),	
		                        'default'  => array(
							        'background-color' => '#f9f9f9',
							    )	
		                                            
		                    )
		                    
					)
				);


				/**
				*Page Layout
				**/
				$this->sections[] = array(
					'id' => 'general_typography',
					'subsection' => true,
					'title' => esc_html__('Page Layout', 'pointfindert2d') ,
					'heading' => esc_html__('Default Page Layout', 'pointfindert2d') ,
					'fields' => array(
					/**
					*Body Area
					**/
						array(
							'id' => 'tcustomizer_styles_info',
							'type' => 'info',
							'notice' => true,
							'style' => 'info',
							'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to Page Body.<br /> You can change styles of this area by using below options.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_formainbody.png" class="description-img" />'),
						) ,
						array(
							'id' => 'tcustomizer_colors_linkcolor',
							'type' => 'link_color',
							'title' => esc_html__('Body: Link Color', 'pointfindert2d') ,
							'compiler' => array(
								'a'
							) ,
							'default' => array(
								'regular' => '#444',
								'hover' => '#000',
								'active' => '#000'
							) ,
						) ,
						array(
							'id' => 'tcustomizer_typographyh_main_fontheading',
							'type' => 'typography',
							'title' => esc_html__('Body: Heading Typography', 'pointfindert2d') ,
							'google' => true,
							'font-backup' => true,
							'compiler' => array(
								'.pfwidgettitle .widgetheader',
								'.dsidx-prop-title',
								'.dsidx-prop-title a',
								'.pfuaformsidebar .pf-sidebar-header',
								'#dsix-listings .dsidx-primary-data',
								'#dsidx-listings .dsidx-primary-data a',
								'.ui-tabgroup >.ui-tabs >[class^="ui-tab"]',
								'.pfitempagecontainerheader',
								'.pf-item-title-bar .pf-item-title-text',
								'.pf_pageh_title .pf_pageh_title_inner',
								'.pfdetailitem-subelement .pfdetail-ftext.pf-pricetext',
								'.pf-agentlist-pageitem .pf-itempage-sidebarinfo-elname',
								'.pf-authordetail-page .pf-itempage-sidebarinfo-elname',
								'.post-mtitle'
							) ,
							'units' => 'px',
							'default' => array(
								'color' => '#333333',
								'font-weight' => '600',
								'font-family' => 'Open Sans',
								'google' => true,
								'font-size' => '16px',
								'line-height' => '20px',
							) ,
						) ,
						array(
							'id' => 'tcustomizer_typographyh_main',
							'type' => 'typography',
							'title' => esc_html__('Body: Typography', 'pointfindert2d') ,
							'google' => true,
							'font-backup' => true,
							'compiler' => array(
								'body',
								'.pfwidgetinner div.dsidx-results-widget',
								'.pfwidgetinner div.dsidx-results-widget p'
							) ,
							'units' => 'px',
							'default' => array(
								'color' => '#494949',
								'font-weight' => '400',
								'font-family' => 'Open Sans',
								'google' => true,
								'font-size' => '12px',
								'line-height' => '16px',
							) ,
						) ,
						array(
							'id' => 'tcustomizer_typographyh_main_bg',
							'type' => 'background',
							'title' => esc_html__('Body: Background', 'pointfindert2d') ,
							'compiler' => array(
								'body'
							) ,
						
						) ,
						array(
		                    'id'        => 'setup30_dashboard_styles_bodyborder',
		                    'type'      => 'color',
		                    'mode'		=> 'background',
		                    'title'     => esc_html__('Body: Border Color', 'pointfindert2d'),
		                    'default'   => '#ebebeb',
		                    'transparent' => false
		                ),
					/**
					*Content Area
					**/
						
						
						array(
						    'id'       => 'setup42_itempagedetails_8_styles_buttoncolor',
						    'type'     => 'extension_custom_link_color',
						    'mode'     => 'background',
						    'title'    => esc_html__('Body: Button Color', 'pointfindert2d'),
						    'compiler' => array(
						    	'.pf-uadashboard-container .golden-forms .pfmyitempagebuttons',
						    	'.pf-uadashboard-container .golden-forms .pfmyitempagebuttonsex',
						    	'.pf-itempage-maindiv .golden-forms .button',
						    	'.pf-notfound-page .btn-success',
						    	'.pfuaformsidebar .pf-sidebar-menu li',
						    	'.widget_pfitem_recent_entries .golden-forms .button.pfsearch',
						    	'.pftcmcontainer.golden-forms .button',
						    	'#pf-contact-form-submit',
						    	'.pf-enquiry-form-ex',
						    	'.golden-forms #commentform .button',
						    	'#pf-itempage-page-map-directions .gdbutton',
						    	'.woocommerce ul.products li.product .button',
						    	'.woocommerce a.added_to_cart',
						    	'.woocommerce #respond input#submit', 
						    	'.woocommerce a.button', 
						    	'.woocommerce button.button', 
						    	'.woocommerce input.button',
						    	'.anemptystylesheet'
						    	) ,
						    'active'	=> false,
						    'visited'	=> false,
						    'default'  => array(
						        'regular'  => '#f7f7f7', 
						        'hover'    => '#a32221',
						    )
						),
						array(
						    'id'       => 'setup42_itempagedetails_8_styles_buttontextcolor',
						    'type'     => 'link_color',
						    'title'    => esc_html__('Body: Button Text Color', 'pointfindert2d'),
						    'compiler' => array(
						    	'.pf-uadashboard-container .golden-forms .pfmyitempagebuttons',
						    	'.pf-uadashboard-container .golden-forms .pfmyitempagebuttonsex',
						    	'.pf-itempage-maindiv .golden-forms .button',
						    	'.pf-notfound-page .btn-success',
						    	'.pfuaformsidebar .pf-sidebar-menu li a',
						    	'.pfuaformsidebar .pf-dash-usernamef',
						    	'.widget_pfitem_recent_entries .golden-forms .button.pfsearch',
						    	'.pftcmcontainer.golden-forms .button',
						    	'#pf-contact-form-submit',
						    	'.golden-forms #commentform .button',
						    	'.pf-enquiry-form-ex',
						    	'#pf-itempage-page-map-directions .gdbutton',
						    	'.woocommerce ul.products li.product .button',
						    	'.woocommerce a.added_to_cart',
						    	'.woocommerce #respond input#submit', 
						    	'.woocommerce a.button', 
						    	'.woocommerce button.button', 
						    	'.woocommerce input.button',
						    	'.anemptystylesheet'
						    	) ,
						    'active'	=> false,
						    'visited'	=> false,
						    'default'  => array(
						        'regular'  => '#4c4c4c', 
						        'hover'    => '#ffffff',
						    )
						),
						array(
						    'id'       => 'setup42_itempagedetails_8_styles_elementcolor',
						    'type'     => 'color',
						    'transparent'	=> false,
						    'title'    => esc_html__('Body: Title Subline Color', 'pointfindert2d'),
						    'default'  => '#a32221',
						    'validate' => 'color'
						)

					)
				);

				


				
				

				


				/**
				*Validation Error Styles
				**/
				$this->sections[] = array(
					'id' => 'setup16_searchnotifications',
					'subsection' => true,
					'title' => esc_html__('Error Notification Layout', 'pointfindert2d') ,
					'desc' => '<p class="description">'.esc_html__('You can edit Validation Error Notification Layout by using below options.', 'pointfindert2d').'</p>' ,
					'heading' => esc_html__('Validation Error Notification Layout', 'pointfindert2d') ,
					'fields' => array(
						array(
							'id' => 'setup16_searchnotifications_searcherrorbg',
							'type' => 'color_rgba',
							'title' => esc_html__('Background', 'pointfindert2d') ,
							'hint' => array(
								'content' => sprintf(esc_html__('%s color of error window.', 'pointfindert2d'),'Background'),
							) ,
							'default' => array(
								'color' => '#921c1c',
								'alpha' => '0.95'
							) ,
							'compiler' => array(
								'.pfsearchformerrors'
							) ,
							'mode' => 'background',
							'validate' => 'colorrgba',
							'transparent' => false,
						) ,
						array(
							'id' => 'setup16_searchnotifications_searcherrortext',
							'type' => 'color',
							'transparent' => false,
							'compiler' => array(
								'.pfsearchformerrors > ul'
							) ,
							'title' => esc_html__('Text Color', 'pointfindert2d') ,
							'hint' => array(
								'content' => sprintf(esc_html__('%s color of error window.', 'pointfindert2d'),'Text'),
							) ,
							'default' => '#FFFFFF',
							'validate' => 'color'
						) ,
						array(
							'id' => 'setup16_searchnotifications_searcherrorclosebg_ex',
							'type' => 'link_color',
							'mode' => 'background',
							'transparent' => false,
							'active' => false,
							'compiler' => array(
								'#pfsearch-err-button'
							) ,
							'title' => esc_html__('Close Button Background', 'pointfindert2d') ,
							'default' => array(
								'regular' => '#FFFFFF',
								'hover' => '#efefef'
							) ,
							'validate' => 'color',
							'hint' => array(
								'content' => sprintf(esc_html__('%s color of close button.', 'pointfindert2d'),'Background'),
							) ,
							
								
						) ,
						
						array(
							'id' => 'setup16_searchnotifications_searcherrorclosetext',
							'type' => 'color',
							'compiler' => array(
								'#pfsearch-err-button'
							) ,
							'title' => esc_html__('Close Button Text Color', 'pointfindert2d') ,
							'default' => '#530000',
							'validate' => 'color',
							'transparent' => false,
							'hint' => array(
								'content' => sprintf(esc_html__('%s color of close button.', 'pointfindert2d'),'Text'),
							) ,
						) ,
					)
				);



				/**
				*Featured Item Ribbon
				**/
				$this->sections[] = array(
					'id' => 'setup16_featureditemribbon',
					'subsection' => true,
					'title' => esc_html__('Featured Item Ribbon', 'pointfindert2d') ,
					'fields' => array(
						array(
							'id' => 'setup16_featureditemribbon_bg',
							'type' => 'color_rgba',
							'title' => esc_html__('Background Color', 'pointfindert2d') ,
							'default' => array(
								'color' => '#5eb524',
								'alpha' => '0.9'
							) ,
							'compiler' => array('.pfribbon-featured','.pfribbon-featured2') ,
							'mode' => 'background',
							'validate' => 'colorrgba',
							'transparent' => false,
						) ,
						array(
							'id' => 'setup16_featureditemribbon_text',
							'type' => 'color',
							'transparent' => false,
							'compiler' => array('.pfribbon-featured','.pfribbon-featured2') ,
							'title' => esc_html__('Text Color', 'pointfindert2d') ,
							'default' => '#FFFFFF',
							'validate' => 'color'
						) ,

						array(
							'id' => 'setup16_featureditemribbon_hide',
							'type' => 'button_set',
							'title' => esc_html__('Ribbon Status', 'pointfindert2d') ,
							'default' => 1,
							'options' => array(
								'1' => esc_html__('Show', 'pointfindert2d') ,
								'0' => esc_html__('Hide', 'pointfindert2d')
							),
							'desc' => esc_html__('If this enabled, Featured Item Ribbon will be hidden for all items.', 'pointfindert2d') ,
						),
					)
				);

		
			/**
			*END : THEME CUSTOMIZER
			**/



			/**
			*START: FOOTER AREA
			**/
				$this->sections[] = array(
					'id' => 'setup_footerbar',
					'title' => esc_html__('Footer Bar', 'pointfindert2d'),
					'icon' => 'el-icon-inbox',
					'fields' => array(
							array(
	                            'id'       => 'setup_footerbar_status',
	                            'type'     => 'button_set',
	                            'title'    => esc_html__( 'Footer Bar', 'pointfindert2d' ),
	                            'options'  => array(
	                                '1' => esc_html__( 'Enable', 'pointfindert2d' ),
	                                '0' => esc_html__( 'Disable', 'pointfindert2d' ),
	                            ),
	                            'default'  => '1'
	                        ),
	                        array(
	                            'id'       => 'setup_footerbar_width',
	                            'type'     => 'button_set',
	                            'title'    => esc_html__( '100% Width', 'pointfindert2d' ),
	                            'options'  => array(
	                                '1' => esc_html__( 'Enable', 'pointfindert2d' ),
	                                '0' => esc_html__( 'Disable', 'pointfindert2d' ),
	                            ),
	                            'default'  => '0'
	                        ),
							array(
		                        'id'        => 'setup_footerbar_border',
		                        'type'      => 'border',
		                        'title'     => esc_html__('Border Color', 'pointfindert2d'),
		                        'compiler'    => array(
		                        	'.wpf-footer'
		                        	), 
		                        'all'		=> false,
		                        'default'   => array(
		                            'border-color'  => '#efefef', 
		                            'border-style'  => 'dotted', 
		                            'border-top'    => '1px', 
		                            'border-right'  => '0px', 
		                            'border-bottom' => '0px', 
		                            'border-left'   => '0px'
		                        ),
		                        'required' => array('setup_footerbar_status','=','1')
		                    ),
	                        array(
	                            'id'       => 'setup_footerbar_bg',
	                            'type'     => 'color',
	                            'mode'     => 'background',
	                            'compiler'   => array( '.wpf-footer' ),
	                            'title'    => esc_html__( 'Background Color', 'pointfindert2d' ),
	                            'default'  => '#494949',
	                            'validate' => 'color',
	                            'required' => array('setup_footerbar_status','=','1')
	                        ),
	                        array(
	                            'id'       => 'setup_footerbar_text',
	                            'type'     => 'link_color',
	                            'title'    => esc_html__( 'Text Color', 'pointfindert2d' ),
	                            'compiler'   => array( '.wpf-footer a' ),
	                            'active'    => false,
	                            'visited'   => false,
	                            'default'  => array(
	                                'regular' => '#ffffff',
	                                'hover'   => '#efefef',
	                            ),
	                            'required' => array('setup_footerbar_status','=','1')
	                        ),
	                        array(
	                            'id'       => 'setup_footerbar_text_copy',
	                            'type'     => 'textarea',
	                            'title'    => esc_html__( 'Copyright Text', 'pointfindert2d' ),
	                            'subtitle' => esc_html__( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'pointfindert2d' ),
	                            'validate' => 'html',
	                            'required' => array('setup_footerbar_status','=','1')
	                        ),
	                        array(
	                            'id'       => 'setup_footerbar_text_copy_align',
	                            'type'     => 'button_set',
	                            'title'    => esc_html__( 'Copyright Text Align', 'pointfindert2d' ),
	                            'options'  => array(
	                                'left' => esc_html__( 'Left', 'pointfindert2d' ),
	                                'center' => esc_html__( 'Center', 'pointfindert2d' ),
	                                'right' => esc_html__( 'Right', 'pointfindert2d' ),
	                            ),
	                            'default'  => 'left',
	                            'required' => array('setup_footerbar_status','=','1')
	                        ),
					)
						
				);
			/**
			*END: FOOTER AREA
			**/



			
			/**
			*Start : GRID LIST SETTINGS
			**/
				$this->sections[] = array(
					'id' => 'setup22_searchresults',
					'title' => esc_html__('Grid & Search List Settings', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('You can customize all item listing variables. This changes will affect search results and all listing areas like item carousel, item listing grid.', 'pointfindert2d').'</p>',
					'icon' => 'el-icon-th',
					'fields' => array(
							
							array(
								'id' => 'setup22_searchresults_grid_layout_mode',
								'type' => 'button_set',
								'title' => esc_html__('Default Grid Layout View', 'pointfindert2d') ,
								'default' => 1,
								'options' => array(
									'1' => esc_html__('Fitrows', 'pointfindert2d') ,
									'0' => esc_html__('Masonry', 'pointfindert2d')
								),
							),
							array(
								'id' => 'stp22_infscrl_s',
								'type' => 'button_set',
								'title' => esc_html__('Infinite Scroll for Search Results', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									1 => esc_html__('Enable', 'pointfindert2d'),
									0 => esc_html__('Disable', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'stp22_infscrl_s2',
								'type' => 'button_set',
								'title' => esc_html__('Infinite Scroll - Load More Button for Search Results', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									1 => esc_html__('Enable', 'pointfindert2d'),
									0 => esc_html__('Disable', 'pointfindert2d')	
								),
								'required' => array('stp22_infscrl_s','=',1)
							),
							array(
								'id' => 'stp22_infscrl_c',
								'type' => 'button_set',
								'title' => esc_html__('Infinite Scroll for Category/Tags', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									1 => esc_html__('Enable', 'pointfindert2d'),
									0 => esc_html__('Disable', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'stp22_infscrl_c2',
								'type' => 'button_set',
								'title' => esc_html__('Infinite Scroll - Load More Button for Category/Tags', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									1 => esc_html__('Enable', 'pointfindert2d'),
									0 => esc_html__('Disable', 'pointfindert2d')	
								),
								'required' => array('stp22_infscrl_c','=',1)
							),

							array(
								'id' => 'setup22_searchresults_defaultlistingtype',
								'type' => 'select',
								'title' => esc_html__('Listing Columns for Search Results', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('1 Column', 'pointfindert2d') ,
									'2' => esc_html__('2 Columns', 'pointfindert2d') ,
									'3' => esc_html__('3 Columns', 'pointfindert2d') ,
									'4' => esc_html__('4 Columns', 'pointfindert2d')
								) ,
								'default' => '4',
								'desc' => esc_html__('This section is only for desktop view. On mobile and tablet view, system will make auto selection and hide other grid options.','pointfindert2d')
								
							),
							array(
								'id' => 'setup22_dlcfc',
								'type' => 'select',
								'title' => esc_html__('Listing Columns for Category/Tags', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('1 Column', 'pointfindert2d') ,
									'2' => esc_html__('2 Columns', 'pointfindert2d') ,
									'3' => esc_html__('3 Columns', 'pointfindert2d') ,
									'4' => esc_html__('4 Columns', 'pointfindert2d')
								) ,
								'default' => '3',
								'desc' => esc_html__('This section is only for desktop view. On mobile and tablet view, system will make auto selection and hide other grid options.','pointfindert2d')
								
							),
							array(
								'id' => 'setup22_searchresults_defaultsortbytype',
								'type' => 'select',
								'title' => esc_html__('Default: Sortby Type', 'pointfindert2d') ,
								'options' => array(
									'distance' => esc_html__('distance', 'pointfindert2d') ,
									'recommend' => esc_html__('recommend', 'pointfindert2d') ,
									'date' => esc_html__('date', 'pointfindert2d') ,
								) ,
								'default' => 'distance',
								'desc' => esc_html__('Default sortby type for listings.','pointfindert2d'),
							),
							array(
								'id' => 'setup22_searchresults_defaultsorttype',
								'type' => 'select',
								'title' => esc_html__('Default: Sort Type', 'pointfindert2d') ,
								'options' => array(
									'ASC' => esc_html__('ASC', 'pointfindert2d') ,
									'DESC' => esc_html__('DESC', 'pointfindert2d') ,
								) ,
								'default' => 'ASC',
								'desc' => esc_html__('Default sort type for listings.','pointfindert2d'),
							),
							array(
								'id' => 'setup22_searchresults_defaultppptype',
								'type' => 'select',
								'title' => esc_html__('Default: Item Per Page', 'pointfindert2d') ,
								'options' => array(
									'3' => 3,
									'4' =>  4,
									'5' =>  5,
									'6' =>  6,
									'7' =>  7,
									'8' =>  8,
									'9' =>  9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									'25' => 25,
									'50' => 50,
									'75' => 75,
								) ,
								'default' => '10',
								'desc' => esc_html__('Default item per page for listings.','pointfindert2d'),
							),
					    	array(
								'id' => 'setup22_searchresults_status_sortby',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: Sort By Selection', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								)
							),
							array(
								'id' => 'setup22_searchresults_status_ascdesc',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: Asc/Desc Selection', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'setup22_searchresults_status_number',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: Number of Item Selection', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'setup22_searchresults_status_2colh',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: 1 Column Listing Box', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'setup22_searchresults_status_2col',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: 2 Column Listing Box', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'setup22_searchresults_status_3col',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: 3 Column Listing Box', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'setup22_searchresults_status_4col',
								'type' => 'button_set',
								'title' => esc_html__('Search Results: 4 Column Listing Box', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							array(
								'id' => 'setup22_searchresults_status_catfilters',
								'type' => 'button_set',
								'title' => esc_html__('Filters on Category Page', 'pointfindert2d') ,
								'default' => 1,
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d'),
									'0' => esc_html__('Hide', 'pointfindert2d')	
								),
							),
							
					) ,
				);


				/**
				*Item Box Settings
				**/
				$this->sections[] = array(
					'id' => 'setup22_searchresults_0',
					'subsection' => true,
					'title' => esc_html__('Item Box Settings', 'pointfindert2d'),
					'desc' => '<p class="description">'.esc_html__('Below options will affect item box styles on the search listing and item box setting for grid listing (Only Address & Excerpt Settings).', 'pointfindert2d').'</p>',
					'fields' => array(
							array(
								'id' => 'setup22_searchresults_background',
								'type' => 'color',
								'title' => esc_html__('Search Results Container Background', 'pointfindert2d') ,
								'default' => '#28353d',
								'compiler' => array(
									'.pfsearchresults .pfsearchresults-content'
								) ,
								'transparent' => false,
								'mode' => 'background',
								'validate' => 'color',
								'hint' => array(
									'content' => esc_html__('Item search listing area container background color', 'pointfindert2d')
								)
							) ,
							array(
								'id' => 'setup22_searchresults_headerbackground',
								'type' => 'color',
								'title' => esc_html__('Search/Grid Default Header Background', 'pointfindert2d') ,
								'default' => '#fafafa',
								'compiler' => array(
									'.pfsearchresults .pfsearchresults-header'
								) ,
								'transparent' => false,
								'mode' => 'background',
								'validate' => 'color',
								'hint' => array(
									'content' => esc_html__('Item search results listing area header background color', 'pointfindert2d')
								)
							) ,
							array(
								'id' => 'setup22_searchresults_headerborder',
								'type' => 'color',
								'title' => esc_html__('Search/Grid Default Header Border (Select box)', 'pointfindert2d') ,
								'default' => '#ebebeb',
								'transparent' => false,
								'validate' => 'color',
								'hint' => array(
									'content' => esc_html__('Item search results sort etc box borders.', 'pointfindert2d')
								)
							) ,
							array(
								'id' => 'setup22_searchresults_background2',
								'type' => 'color',
								'title' => esc_html__('Default Item Box Background', 'pointfindert2d') ,
								'default' => '#ffffff',
								'compiler' => array(
									'.pfsearchresults-content .pflist-item'
								) ,
								'transparent' => false,
								'mode' => 'background',
								'validate' => 'color',
								'hint' => array(
									'content' => esc_html__('Item box text area background color (Under the Image Area)', 'pointfindert2d')
								)
							) ,
							array(
								'id' => 'setup22_searchresults_hide_address',
								'type' => 'button_set',
								'title' => esc_html__('Default Item Box Address Area', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
									'1' => esc_html__('Hide', 'pointfindert2d')
								),
								
							),
							array(
								'id' => 'setup22_searchresults_hide_lt',
								'type' => 'button_set',
								'title' => esc_html__('Listing Type Text', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'0' => esc_html__('Show', 'pointfindert2d'),
									'1' => esc_html__('Hide', 'pointfindert2d')
								),
								
							) ,
							array(
								'id' => 'st22srlinklt',
								'type' => 'button_set',
								'title' => esc_html__('Listing Type Text Link', 'pointfindert2d') ,
								'default' => 1,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d'),
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								
							) ,
							array(
								'id' => 'st22srlinknw',
								'type' => 'button_set',
								'title' => esc_html__('Open New Window for Item Detail', 'pointfindert2d') ,
								'default' => 0,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d'),
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								
							) ,
							
							
							array(
								'id' => 'setup22_searchresults_hide_excerpt',
								'type' => 'checkbox',
								'title' => esc_html__('Item Box Excerpt Area', 'pointfindert2d') ,
								'subtitle' => esc_html__('This function will show/hide excerpt area by item box columns.', 'pointfindert2d') ,
								'options' => array(
									'1' => '' . esc_html__('1 Columns Box Excerpt', 'pointfindert2d') ,
									'2' => '' . esc_html__('2 Columns Box Excerpt', 'pointfindert2d') ,
									'3' => '' . esc_html__('3 Columns Box Excerpt', 'pointfindert2d'),
									'4' => '' . esc_html__('4 Columns Box Excerpt', 'pointfindert2d')
								) ,
								'default' => array(
									'1' => '1',
									'2' => '0',
									'3' => '0',
									'4' => '0'
								)
							) ,
							array(
								'id' => 'setup22_searchresults_hide_excerpt_rl',
								'type' => 'button_set',
								'title' => esc_html__('Excerpt Area Row Limit', 'pointfindert2d') ,
								'default' => 2,
								'options' => array(
									'1' => esc_html__('1 Row', 'pointfindert2d'),
									'2' => esc_html__('2 Row', 'pointfindert2d')
								),
								
							) ,

							array(
								'id' => 'setup22_searchresults_showmapfeature',
								'type' => 'button_set',
								'title' => esc_html__('Show On Map Link', 'pointfindert2d') ,
								'default' => 1,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d'),
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								
							) ,
							
						
						
							
					) ,
				);


				/**
				*Item Box Image Settings
				**/
				$this->sections[] = array(
					'id' => 'setup22_searchresults_1',
					'subsection' => true,
					'title' => esc_html__('Item Box Image Settings', 'pointfindert2d'),
					'desc' => '<p class="description">'.esc_html__('Below settings will affect item image on the listing.', 'pointfindert2d').'</p>',
					'fields' => array(
						array(
							'id' => 'setup22_searchresults_hover_image',
							'type' => 'button_set',
							'title' => esc_html__('Image Hover Buttons', 'pointfindert2d') ,
							'default' => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
							)
						) ,
						array(
							'id' => 'setup22_searchresults_1_linkcolor',
							'type' => 'link_color',
							'title' => esc_html__('Icon Link Color', 'pointfindert2d') ,
							'compiler' => array(
								'.pflist-item .pfHoverButtonStyle > a'
							) ,
							'active' => false,
							'default' => array(
								'regular' => '#000000',
								'hover' => '#B32E2E'
							),
							'required' => array('setup22_searchresults_hover_image','=','0')
						) ,
						
						array(
							'id' => 'setup22_searchresults_hover_video',
							'type' => 'button_set',
							'required' => array('setup22_searchresults_hover_image','=','0'),
							'title' => esc_html__('Image Hover Video Button', 'pointfindert2d'),
							'default' => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d'),
								'1' => esc_html__('Hide', 'pointfindert2d')	
							),
							
						) ,
						array(
							'id' => 'setup22_searchresults_animation_image',
							'type' => 'select',
							'required' => array('setup22_searchresults_hover_image','=','0') ,
							'title' => esc_html__('Image Hover Button Styles', 'pointfindert2d') ,
							'options' => array(
								'WhiteRounded' => esc_html__('White Rounded', 'pointfindert2d') ,
								'BlackRounded' => esc_html__('Black Rounded', 'pointfindert2d') ,
								'WhiteSquare' => esc_html__('White Square', 'pointfindert2d') ,
								'BlackSquare' => esc_html__('Black Square', 'pointfindert2d')
							) ,
							'default' => 'WhiteSquare',
							
						)
						
					) ,
				);


				/**
				*Item Box Typography
				**/
				$this->sections[] = array(
					'id' => 'setup22_searchresults_2',
					'subsection' => true,
					'title' => esc_html__('Item Box Typography', 'pointfindert2d'),
					'desc' => '<p class="description">'.esc_html__('Below settings will affect listing item variables such as Title, Address, Text color font etc.', 'pointfindert2d').'</p>',
					'fields' => array(
							array(
								'id' => 'setup22_searchresults_title_color',
								'type' => 'link_color',
								'title' => esc_html__('Title Area Link Color', 'pointfindert2d') ,
								'compiler' => array(
									'.pflist-itemdetails .pflist-itemtitle a'
								) ,
								'active' => false,
								'default' => array(
									'regular' => '#2b7ff5',
									'hover' => '#7a7a7a'
								)
							) ,
							array(
								'id' => 'setup22_searchresults_title_typo',
								'type' => 'typography',
								'title' => esc_html__('Title Area', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.pflist-itemdetails .pflist-itemtitle a'
								) ,
								'units' => 'px',
								'color' => false,
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Ubuntu Condensed',
									'google' => true,
									'font-size' => '18px',
									'line-height' => '21px',
									'text-align' => 'left'
								)
							) ,
							array(
								'id' => 'setup22_searchresults_text_typo',
								'type' => 'typography',
								'title' => esc_html__('Detail Text Area', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.pflistingitem-subelement.pf-onlyitem .pf-ftext', 
									'.pflistingitem-subelement.pf-onlyitem .pf-ftitle', 
									'.pfshowmaplink',
									'.pflistingitem-subelement.pf-ititem .pf-ftitle',
									'.pflist-item .pflist-excerpt',
									'.anemptystylesheet'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '16px',
									'color' => '#7a7a7a',
									'text-align' => 'left'
								)
							) ,
							array(
								'id' => 'setup22_searchresults_text_typo2',
								'type' => 'color',
								'compiler' => array(
									'.pflistingitem-subelement.pf-onlyitem .pf-ftitle',
									'.pfshowmaplink',
									'.pflistingitem-subelement.pf-ititem .pf-ftitle'
								) ,
								'transparent' => false,
								'title' => esc_html__('Detail Text Area Title Color', 'pointfindert2d') ,
								'default' => '#494949',
								'validate' => 'color',
								
							) ,
							array(
								'id' => 'setup22_searchresults_price_typo',
								'type' => 'typography',
								'title' => esc_html__('Price & Listing Type Area', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.pflistingitem-subelement.pf-price',
									'.pflistingitem-subelement.pf-price a'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Ubuntu Condensed',
									'google' => true,
									'font-size' => '20px',
									'line-height' => '20px',
									'color' => '#ffffff',
									'text-align' => 'right'
								)
							) ,
							array(
								'id' => 'setup22_searchresults_address_typo',
								'type' => 'typography',
								'title' => esc_html__('Address Area', 'pointfindert2d') ,
								'required' => array('setup22_searchresults_hide_address', '=', 0),
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.pflist-itemdetails > .pflist-address'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Ubuntu Condensed',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '17px',
									'color' => '#686868',
									'text-align' => 'left'
								)
							) ,
					) ,
				);

				
			/**
			*End : GRID LIST SETTINGS
			**/




			/**
			*Start : FRONTEND SUBMISSON SETTINS
			**/

				/**
				*Submission System
				**/
				$this->sections[] = array(
					'id' => 'setup26_frontend',
					'title' => esc_html__('Frontend Upload System', 'pointfindert2d') ,
					'icon' => 'el-icon-upload',
					'fields' => array(
							array(
								'id' => 'setup4_membersettings_dashboard',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Dashboard Page', 'pointfindert2d') ,
								'desc' => esc_html__('This page is welcome page which will be seen by users after login. It must be selected.', 'pointfindert2d') ,
							) ,
							array(
								'id' => 'setup4_membersettings_loginregister',
								'desc' => esc_html__('Warning: If it is disabled, User Submission, Favorite, Review Systems will be disabled. (Former data will not be affected.)', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('User Login / Register System', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0'
							) ,
							array(
								'id' => 'setup4_membersettings_frontend',
								'desc' => esc_html__('If it is disabled, only User Item Submission will be disabled. Favorite & Review Systems will not be affected.', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('User Item Submission', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0'
							) ,
							array(
	                        'id'        => 'setup4_membersettings_dateformat',
	                        'type'      => 'select',
	                        'title'     => esc_html__('Expiry Date Format', 'pointfindert2d'),
	                        'options'   => array(
	                            '1' => 'dd/mm/yyyy', 
	                            '2' => 'mm/dd/yyyy', 
	                            '3' => 'yyyy/mm/dd',
	                            '4' => 'yyyy/dd/mm'
	                        ),
	                        'default'   => '1'
	                    	),
							array(
								'id' => 'setup31_userpayments_orderprefix',
								'type' => 'text',
								'title' => esc_html__('Order ID Prefix', 'pointfindert2d') ,
								'default' => 'PF',
								'hint'      => array(
	                        		'content' => esc_html__('Prefix for order ID number. Ex: PF276325', 'pointfindert2d')
	                        	),
							) ,
	                    	array(
								'id' => 'setup4_membersettings_paymentsystem',
								'desc' => esc_html__('Please do not change system after begin to use the site.', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('Payment System', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Pay Per Post System', 'pointfindert2d') ,
									'2' => esc_html__('Membership Package System', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
							array(
								'id' => 'setup4_mem_terms',
								'desc' => esc_html__('Enable/Disable Terms and Conditions while purchasing plan.', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('Terms & Conditions for Membership', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'required' => array('setup4_membersettings_paymentsystem','=',2),
								'default' => '1'
							) ,

							array(
								'id' => 'setup4_ppp_terms',
								'desc' => esc_html__('Enable/Disable Terms and Conditions while uploading item.', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('Terms & Conditions for Item Upload', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
							array(
								'id' => 'setup4_ppp_catprice',
								'type' => 'button_set',
								'title' => esc_html__('Category Pricing', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'required' => array('setup4_membersettings_paymentsystem','=',1),
								'default' => '0'
							) ,


					),
					
				);


				/**
				* Payment Settings
				**/
				$this->sections[] = array(
					'id' => 'setup20_dbp',
					'subsection' => true,
					'title' => esc_html__('Payment Settings', 'pointfindert2d'),
					'fields' => array(
						array(
		                        'id'        => 'setup20_paypalsettings_info1',
		                        'type'      => 'info',
		                        'notice'    => true,
		                        'style'     => 'info',
		                        'required' => array('setup20_paypalsettings_paypal_status','=','1'),
		                        'desc'      => esc_html__('Below settings will affect price value which is used in payment gateways.', 'pointfindert2d')
		                    ),
							array(
		                        'id'        => 'setup20_paypalsettings_paypal_api_packagename',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Payment Title', 'pointfindert2d'),
		                        'default'	=> esc_html__('PointFinder Payment:','pointfindert2d')
		                    ),
		                    array(
		                        'id'        => 'setup20_paypalsettings_paypal_price_short',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Money Sign', 'pointfindert2d'),
		                        'default'	=> '$'
		                    ),
		                    array(
								'id' => 'setup20_paypalsettings_paypal_price_pref',
								'type' => 'button_set',
								'title' => esc_html__('Money Sign Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Before the price', 'pointfindert2d') ,
									'0' => esc_html__('After the price', 'pointfindert2d')
								),
								'default' => '1'
							) ,
		                    array(
		                        'id'        => 'setup20_paypalsettings_decimals',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('Decimals', 'pointfindert2d'),
		                        'desc'      => esc_html__('Decimal number for price value. ', 'pointfindert2d'),
		                        'default'   => '2',
		                        'min'       => '0',
		                        'step'      => '1',
		                        'max'       => '4'
		                    ),
		                    array(
								'id' => 'setup20_paypalsettings_decimalpoint',
								'type' => 'text',
								'title' => esc_html__('Decimal Point', 'pointfindert2d') ,
								'default' => '.',
								'class' => 'small-text'
							) ,
							array(
								'id' => 'setup20_paypalsettings_thousands',
								'type' => 'text',
								'title' => esc_html__('Thousands Separator', 'pointfindert2d') ,
								'default' => ',',
								'class' => 'small-text'
							)
						)
				);


				/**
				*Upload Settings
				**/
					$this->sections[] = array(
						'id' => 'setup31_userpayments',
						'subsection' => true,
						'title' => esc_html__('Uploaded Item Settings', 'pointfindert2d') ,
						'fields' => array(
				                
								array(
									'id' => 'stp_hlp1',
									'type' => 'info',
									'notice' => true,
									'style' => 'info',
									'title' => esc_html__('Rules for Items', 'pointfindert2d') ,
									'desc' => esc_html__('Below options will affect all new uploaded items.', 'pointfindert2d')
								) ,
								array(
									'id' => 'setup31_userlimits_userpublish',
									'type' => 'button_set',
									'title' => esc_html__('New Uploaded Item Status', 'pointfindert2d') ,
									'desc' => '<strong>'.esc_html__('Warning:','pointfindert2d').'</strong>'.esc_html__('If this option is changed to "Publish"; all items directly will be published after payment is completed. We recommend you to use "Pending for Approval" option to check and approve all submitted items before releasing on your website.', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Publish Directly', 'pointfindert2d') ,
										'0' => esc_html__('Pending for Approval', 'pointfindert2d')
									) ,
									'default' => '0'
									
								) ,
								array(
									'id' => 'setup31_userlimits_userpublishonedit',
									'type' => 'button_set',
									'title' => esc_html__('Edited Item Status', 'pointfindert2d') ,
									'desc' => '<strong>'.esc_html__('Warning:','pointfindert2d').'</strong>'.esc_html__(' If this option is changed to "Publish"; all items directly will be published after payment is completed. We recommend you to use "Pending for Approval" option to check and approve all submitted items before releasing on your website.', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Publish Directly', 'pointfindert2d') ,
										'0' => esc_html__('Pending for Approval', 'pointfindert2d')
									) ,
									'default' => '0'
									
								) ,
								array(
			                        'id'        => 'setup31_userpayments_pendinglimit',
			                        'type'      => 'spinner',
			                        'title'     => esc_html__('Pending Payment Waiting Time', 'pointfindert2d'),
			                        'desc'		=> esc_html__('This is the waiting period for pending payment. Item or Membership Subscription will be removed after waiting period runs out. Please set variable 0 to disable.', 'pointfindert2d'),
			                        'default'   => '10',
			                        'min'       => '0',
			                        'step'      => '1',
			                        'max'       => '1000000',
			                    )
						)
					);
				/**
				*Upload Settings
				**/

				/**
				*Dashboard Page Configurations
				**/
				$this->sections[] = array(
					'id' => 'setup29_dashboard_contents',
					'subsection' => true,
					'title' => esc_html__('User Menu & Page Configurations', 'pointfindert2d'),
					'desc' => '<p class="description">'.esc_html__('You can add a different content page for every section into user dashboard pages and change section names.', 'pointfindert2d').'</p>' ,
					'fields' => array(

						array(
	                        'id'        => 'setup29_dashboard_contents_profile_page_layout',
	                        'type'      => 'image_select',
	                        'title'     => esc_html__('Page Layout for Dashboard', 'pointfindert2d'),
	                        'options'   => array(
	                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
	                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
	                        ),
	                        'default'   => '3'
	                    ),
						/* Profile Page */
						array(
	                        'id'        => 'setup29_dashboard_contents_profile_start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Profile Page', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('Profile Page Content :','pointfindert2d').esc_html__('You can add a content page & set the position of it by using below options.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
	                    	array(
		                        'id'        => 'setup29_dashboard_contents_profile_page_title',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title', 'pointfindert2d'),
		                        'default'   => 'Profile Page'
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_profile_page_menuname',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Menu Name', 'pointfindert2d'),
		                        'default'   => 'Profile'
		                    ),
							array(
								'id' => 'setup29_dashboard_contents_profile_page',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Content Page', 'pointfindert2d') ,
							) ,
							array(
								'id' => 'setup29_dashboard_contents_profile_page_pos',
								'type' => 'button_set',
								'title' => esc_html__('Content Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Top of the Page', 'pointfindert2d') ,
									'0' => esc_html__('Bottom of the Page', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup29_dashboard_contents_profile_page','!=','')

							),
	                    array(
	                        'id'        => 'setup29_dashboard_contents_profile_end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),

	                    /* Submit Page */
	                    array(
	                        'id'        => 'setup29_dashboard_contents_submit-start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Submit Item Page', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('Submit Item Page Content :','pointfindert2d').esc_html__('You can add a content page & set the position of it by using below options.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
	                    	array(
		                        'id'        => 'setup29_dashboard_contents_submit_page_title',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title', 'pointfindert2d'),
		                        'default'   => 'Submit New Item'
		                        
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_submit_page_menuname',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Menu Name', 'pointfindert2d'),
		                        'default'   => 'Submit Item'
		                        
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_submit_page_titlee',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title (Edit)', 'pointfindert2d'),
		                        'default'   => 'Edit Item'
		                        
		                    ),
							array(
								'id' => 'setup29_dashboard_contents_submit_page',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Content Page', 'pointfindert2d') 
								
							) ,
							array(
								'id' => 'setup29_dashboard_contents_submit_page_pos',
								'type' => 'button_set',
								'title' => esc_html__('Content Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Top of the Page', 'pointfindert2d') ,
									'0' => esc_html__('Bottom of the Page', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup29_dashboard_contents_submit_page','!=','')
								
							) ,
							
	                    array(
	                        'id'        => 'setup29_dashboard_contents_submit-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),

	                    /* My Items Page */
	                    array(
	                        'id'        => 'setup29_dashboard_contents_my_start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('My Items Page', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('My Items Page Content :','pointfindert2d').esc_html__('You can add a content page & set the position of it by using below options.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
	                    	array(
		                        'id'        => 'setup29_dashboard_contents_my_page_title',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title', 'pointfindert2d'),
		                        'default'   => 'My Items Page'
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_my_page_menuname',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Menu Name', 'pointfindert2d'),
		                        'default'   => 'My Items'
		                    ),
							array(
								'id' => 'setup29_dashboard_contents_my_page',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Content Page', 'pointfindert2d') ,
							) ,
							array(
								'id' => 'setup29_dashboard_contents_my_page_pos',
								'type' => 'button_set',
								'title' => esc_html__('Content Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Top of the Page', 'pointfindert2d') ,
									'0' => esc_html__('Bottom of the Page', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup29_dashboard_contents_my_page','!=','')
							) ,
							
	                    array(
	                        'id'        => 'setup29_dashboard_contents_my_end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),

	                    /* Favorites page */
	                    array(
	                        'id'        => 'setup29_dashboard_contents_favs_start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Favorites Page', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('Favorites Page Content :','pointfindert2d').esc_html__('You can add a content page & set the position of it by using below options.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
	                    	array(
		                        'id'        => 'setup29_dashboard_contents_favs_page_title',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title', 'pointfindert2d'),
		                        'default'   => 'My Favorites Page'
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_favs_page_menuname',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Menu Name', 'pointfindert2d'),
		                        'default'   => 'My Favorites'
		                    ),
							array(
								'id' => 'setup29_dashboard_contents_favs_page',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Content Page', 'pointfindert2d') ,
							) ,
							array(
								'id' => 'setup29_dashboard_contents_favs_page_pos',
								'type' => 'button_set',
								'title' => esc_html__('Content Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Top of the Page', 'pointfindert2d') ,
									'0' => esc_html__('Bottom of the Page', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup29_dashboard_contents_favs_page','!=','')
							) ,
							
	                    array(
	                        'id'        => 'setup29_dashboard_contents_favs_end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),


	                    /* Reviews Page */
	                    array(
	                        'id'        => 'setup29_dashboard_contents_rev_start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('My Reviews Page', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('My Reviews Page Content :','pointfindert2d').esc_html__('You can add a content page & set the position of it by using below options.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
	                    	array(
		                        'id'        => 'setup29_dashboard_contents_rev_page_title',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title', 'pointfindert2d'),
		                        'default'   => 'My Reviews Page'
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_rev_page_menuname',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Menu Name', 'pointfindert2d'),
		                        'default'   => 'My Reviews'
		                    ),
							array(
								'id' => 'setup29_dashboard_contents_rev_page',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Content Page', 'pointfindert2d') ,
							) ,
							array(
								'id' => 'setup29_dashboard_contents_rev_page_pos',
								'type' => 'button_set',
								'title' => esc_html__('Content Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Top of the Page', 'pointfindert2d') ,
									'0' => esc_html__('Bottom of the Page', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup29_dashboard_contents_rev_page','!=','')
							) ,
							
	                    array(
	                        'id'        => 'setup29_dashboard_contents_rev_end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),

	                    /* Invoices Page */
	                    array(
	                        'id'        => 'setup29_dashboard_contents_inv_start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('My Invoices Page', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('My Invoices Page Content :','pointfindert2d').esc_html__('You can add a content page & set the position of it by using below options.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
	                    	array(
		                        'id'        => 'setup29_dashboard_contents_inv_page_title',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Title', 'pointfindert2d'),
		                        'default'   => 'My Invoices Page'
		                    ),
		                    array(
		                        'id'        => 'setup29_dashboard_contents_inv_page_menuname',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Page Menu Name', 'pointfindert2d'),
		                        'default'   => 'My Invoices'
		                    ),
							array(
								'id' => 'setup29_dashboard_contents_inv_page',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Content Page', 'pointfindert2d') ,
							) ,
							array(
								'id' => 'setup29_dashboard_contents_inv_page_pos',
								'type' => 'button_set',
								'title' => esc_html__('Content Position', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Top of the Page', 'pointfindert2d') ,
									'0' => esc_html__('Bottom of the Page', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup29_dashboard_contents_rev_page','!=','')
							) ,
							
	                    array(
	                        'id'        => 'setup29_dashboard_contents_rev_end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),
	                    
	                    

					)
					 
				);
				

				
				
				/**
				*Submission Page Settings
				**/
				$this->sections[] = array(
					'id' => 'setup4_submitpage',
					'subsection' => true,
					'title' => esc_html__('Upload Page Settings', 'pointfindert2d') ,
					'fields' => array(
						
						array(
	                        'id'        => 'setup4_submitpage_titletip',
	                        'type'      => 'textarea',
	                        'title'     => esc_html__('Title Area Tooltip', 'pointfindert2d'),
	                        'subtitle'  => '<strong>'.esc_html__('OPTIONAL :','pointfindert2d').' </strong>'.sprintf(esc_html__('You can add a tooltip on %s field.', 'pointfindert2d'),'Title'),
	                        'validate'  => 'no_html',
	                        
	                    ),
						array(
							'id' => 'setup4_submitpage_titleverror',
							'type' => 'text',
							'title' => esc_html__('Title Validation Error', 'pointfindert2d') ,
							'default' => esc_html__('Please type a title.', 'pointfindert2d')
						) ,
	                    array(
							'id' => 'setup4_submitpage_descriptionvcheck',
							'type' => 'button_set',
							'title' => esc_html__('Description Validation', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							),
							'default' => '0'
							
						) ,
						array(
							'id' => 'setup4_submitpage_description_verror',
							'type' => 'text',
							'title' => esc_html__('Description Validation Error', 'pointfindert2d') ,
							'required'	=> array('setup4_submitpage_descriptionvcheck','=','1'),
							'default' => esc_html__('Please write a description', 'pointfindert2d')
						) ,
	                    

                    	array(
							'id' => 'st4_sp_med',
							'type' => 'button_set',
							'title' => esc_html__('Address/Map Area', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '1'
						) ,
						array(
	                        'id'        => 'setup4_submitpage_maparea-start',
	                        'title' => esc_html__('Address/Map Selection Area', 'pointfindert2d') ,
	                        'type'      => 'section',
	                        'indent'    => true,
	                        'required' => array('st4_sp_med','=',1)
	                    ),
	                    	array(
								'id' => 'setup5_mapsettings_lat',
								'type' => 'text',
								'title' => esc_html__('Default Latitude', 'pointfindert2d') ,
								'desc' => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>') ,
								'default' => '40.712784',
								'required' => array('st4_sp_med','=',1)
							) ,
							array(
								'id' => 'setup5_mapsettings_lng',
								'type' => 'text',
								'title' => esc_html__('Default Longitude', 'pointfindert2d') ,
								'desc' => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>') ,
								'default' => '-74.005941',
								'required' => array('st4_sp_med','=',1)
							) ,
							array(
								'id' => 'setup5_mapsettings_zoom',
								'type' => 'spinner',
								'title' => esc_html__('View Zoom', 'pointfindert2d') ,
								"default" => "12",
								"min" => "6",
								"step" => "1",
								"max" => "18",
								'required' => array('st4_sp_med','=',1)
							) ,
							array(
								'id' => 'setup5_mapsettings_type',
								'title' => esc_html__('Map Type', 'pointfindert2d') ,
								'type' => 'button_set',
								'options' => array(
									'ROADMAP' => esc_html__('ROADMAP', 'pointfindert2d') ,
									'SATELLITE' => esc_html__('SATELLITE', 'pointfindert2d') ,
									'HYBRID' => esc_html__('HYBRID', 'pointfindert2d') ,
									'TERRAIN' => esc_html__('TERRAIN', 'pointfindert2d')
								) ,
								'default' => 'ROADMAP',
								'required' => array('st4_sp_med','=',1)		
							) ,
							array(
								'id' => 'setup4_submitpage_maparea_title',
								'type' => 'text',
								'title' => esc_html__('Address/Map Area Title', 'pointfindert2d') ,
								'default' => esc_html__('Address', 'pointfindert2d'),
								'required' => array('st4_sp_med','=',1)
							) ,
							array(
		                        'id'        => 'setup4_submitpage_maparea_tooltip',
		                        'type'      => 'textarea',
		                        'title'     => esc_html__('Address/Map Area Tooltip', 'pointfindert2d'),
		                        'subtitle'  => '<strong>'.esc_html__('OPTIONAL :','pointfindert2d').' </strong>'.sprintf(esc_html__('You can add a tooltip on %s area.', 'pointfindert2d'),'Address'),
		                        'validate'  => 'no_html',
								'default' => esc_html__('Please select a location by moving marker.', 'pointfindert2d'),
								'required' => array('st4_sp_med','=',1)
		                        
		                    ),
		                    array(
								'id' => 'st4_sp_med2',
								'type' => 'button_set',
								'title' => esc_html__('Validation', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
		                    
							array(
								'id' => 'setup4_submitpage_maparea_verror',
								'type' => 'text',
								'title' => esc_html__('Address/Map Area Validation Error', 'pointfindert2d') ,
								'required' => array(array('st4_sp_med','=',1),array('st4_sp_med2','=',1)),
								'default' => esc_html__('Please select a marker location or type lat/lng.', 'pointfindert2d')
							) ,
						array(
	                        'id'        => 'setup4_submitpage_maparea-end',
	                        'type'      => 'section',
	                        'indent'    => false,
	                        'required' => array('st4_sp_med','=',1)
	                    ),
						array(
							'id' => 'setup4_submitpage_video',
							'type' => 'button_set',
							'title' => esc_html__('Featured Video Area', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '1'							
						) ,
						array(
							'id' => 'stp4_ctt1',
							'type' => 'button_set',
							'title' => esc_html__('Custom Tab 1', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '0'							
						) ,
						array(
							'id' => 'stp4_ctt2',
							'type' => 'button_set',
							'title' => esc_html__('Custom Tab 2', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '0'							
						) ,
						array(
							'id' => 'stp4_ctt3',
							'type' => 'button_set',
							'title' => esc_html__('Custom Tab 3', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '0'							
						) ,
						array(
							'id' => 'stp4_psttags',
							'type' => 'button_set',
							'title' => esc_html__('Post Tags Area', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '1'							
						) ,
	                    array(
							'id' => 'setup4_submitpage_imageupload',
							'type' => 'button_set',
							'title' => esc_html__('Image Upload Area', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '1'
							
						) ,
						array(
	                        'id'        => 'setup4_submitpage_imageupload-start',
	                        'type'      => 'section',
	                        'indent'    => true, 
	                        'required'	=> array('setup4_submitpage_imageupload','=',1)
	                    ),
	                    	array(
								'id' => 'setup4_submitpage_status_old',
								'type' => 'button_set',
								'title' => esc_html__('Old Style Upload System', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0',
								'required'	=> array('setup4_submitpage_imageupload','=','1'),
								
							) ,
		                    array(
		                        'id'        => 'setup4_submitpage_imagelimit',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('Image Upload Limit', 'pointfindert2d'),
		                        
		                        'default'   => '10',
		                        'min'       => '1',
		                        'step'      => '1',
		                        'max'       => '100',
		                        'required'	=> array('setup4_submitpage_imageupload','=',1)
		                    ),
		                    array(
		                        'id'        => 'setup4_submitpage_imagesizelimit',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('Image Upload Size Limit', 'pointfindert2d'),
		                        'desc'     => esc_html__('mb (megabayt)', 'pointfindert2d'),
		                        'default'   => '2',
		                        'min'       => '1',
		                        'step'      => '1',
		                        'max'       => '20',
		                        'required'	=> array('setup4_submitpage_imageupload','=',1)
		                    ),
		                    array(
								'id' => 'setup4_submitpage_featuredverror_status',
								'type' => 'button_set',
								'title' => esc_html__('Image Validation', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('setup4_submitpage_imageupload','=','1'),
								
							) ,
		                    array(
								'id' => 'setup4_submitpage_featuredverror',
								'type' => 'text',
								'title' => esc_html__('Image Validation Error', 'pointfindert2d') ,
								'required'	=> array('setup4_submitpage_imageupload','=','1'),
								'default' => esc_html__('Please select a featured image.', 'pointfindert2d')
							) ,
							
		                   
		                array(
	                        'id'        => 'setup4_submitpage_imageupload-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                        'required'	=> array('setup4_submitpage_imageupload','=',1)
	                    ),


		                 array(
							'id' => 'stp4_fupl',
							'type' => 'button_set',
							'title' => esc_html__('File Upload Area', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '0'
							
						) ,

	                    array(
	                        'id'        => 'stp4_fupl-start',
	                        'type'      => 'section',
	                        'indent'    => true, 
	                        'required'	=> array('stp4_fupl','=',1)
	                    ),
	                    	
		                    array(
		                        'id'        => 'stp4_Filelimit',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('File Upload Limit', 'pointfindert2d'),
		                        
		                        'default'   => '10',
		                        'min'       => '1',
		                        'step'      => '1',
		                        'max'       => '100',
		                        'required'	=> array('stp4_fupl','=',1)
		                    ),
		                    array(
		                        'id'        => 'stp4_Filesizelimit',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('File Upload Size Limit', 'pointfindert2d'),
		                        'desc'     => esc_html__('mb (megabayt)', 'pointfindert2d'),
		                        'default'   => '2',
		                        'min'       => '1',
		                        'step'      => '1',
		                        'max'       => '20',
		                        'required'	=> array('stp4_fupl','=',1)
		                    ),
		                    array(
								'id' => 'stp4_err_st',
								'type' => 'button_set',
								'title' => esc_html__('File Validation', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1',
								'required'	=> array('stp4_fupl','=','1'),
								
							) ,
		                    array(
								'id' => 'stp4_err',
								'type' => 'text',
								'title' => esc_html__('File Validation Error', 'pointfindert2d') ,
								'required'	=> array('stp4_fupl','=','1'),
								'default' => esc_html__('Please upload an attachment.', 'pointfindert2d')
							) ,

							array(
								'id' => 'stp4_allowed',
								'type' => 'text',
								'title' => esc_html__('Allowed file extensions', 'pointfindert2d') ,
								'required'	=> array('stp4_fupl','=','1'),
								'desc' => esc_html__('Please write like: doc,pdf,zip', 'pointfindert2d'),
								'default' => 'jpg,jpeg,gif,png,pdf,rtf,csv,zip, x-zip, x-zip-compressed,rar,doc,docx,docm,dotx,dotm,docb,xls,xlt,xlm,xlsx,xlsm,xltx,xltm,ppt,pot,pps,pptx,pptm'
							) ,
							
							
		                   
		                array(
	                        'id'        => 'stp4_fupl-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                        'required'	=> array('stp4_fupl','=',1)
	                    ),
						array(
							'id' => 'setup4_submitpage_messagetorev',
							'type' => 'button_set',
							'title' => esc_html__('Message to Reviewer Area', 'pointfindert2d') ,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							) ,
							'default' => '1'
							
						) ,

						array(
								'id' => 'stp_hlp2',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc' => esc_html__('You can change taxonomy select boxes configuration by using below options.', 'pointfindert2d')
							),
						/** listing Types **/
						array(
	                        'id'        => 'setup4_submitpage_listingtypes-start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Listing Types Options', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('You can change select box variables by using below controls.', 'pointfindert2d'),
	                        'indent'    => true, 
	                    ),
							array(
								'id' => 'setup4_submitpage_listingtypes_title',
								'type' => 'text',
								'title' => esc_html__('Selection Box Title', 'pointfindert2d') ,
								'default' => esc_html__('Listing Type', 'pointfindert2d')
							) ,

							array(
								'id' => 'setup4_submitpage_sublistingtypes_title',
								'type' => 'text',
								'title' => esc_html__('Sub Selection Box Title', 'pointfindert2d') ,
								'default' => esc_html__('Sub Listing Type', 'pointfindert2d')
							) ,

							array(
								'id' => 'setup4_submitpage_subsublistingtypes_title',
								'type' => 'text',
								'title' => esc_html__('2nd Sub Selection Box Title', 'pointfindert2d') ,
								'default' => esc_html__('Sub Sub Listing Type', 'pointfindert2d')
							) ,
							array(
								'id' => 'setup4_submitpage_listingtypes_verror',
								'type' => 'text',
								'title' => esc_html__('Selection Box Validation Error', 'pointfindert2d') ,
								'default' => esc_html__('Please select a listing type.', 'pointfindert2d')
							),
							array(
								'id' => 'stp4_forceu',
								'type' => 'button_set',
								'title' => esc_html__('Force users to select sub category.', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => 0
								
							),
	                    array(
	                        'id'        => 'setup4_submitpage_listingtypes-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                    ),
	                    /** Item Types **/
	                    array(
	                        'id'        => 'setup4_submitpage_itemtypes-start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Item Types Options', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('You can change select box variables by using below controls.', 'pointfindert2d'),
	                        'indent'    => true, 
	                        'required'	=> array('setup3_pointposttype_pt4_check','=','1'),
	                    ),
	                    	array(
								'id' => 'setup4_submitpage_itemtypes_check',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								) ,
								'required'	=> array('setup3_pointposttype_pt4_check','=','1'),
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup4_submitpage_itemtypes_title',
								'type' => 'text',
								'title' => esc_html__('Selection Box Title', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_itemtypes_check','=','1'),
									array('setup3_pointposttype_pt4_check','=','1')
								),
								'default' => esc_html__('Item Type', 'pointfindert2d')
							) ,
							array(
								'id' => 'setup4_submitpage_itemtypes_multiple',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Multiple', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Multiple Selection', 'pointfindert2d') ,
									'0' => esc_html__('Single Selection', 'pointfindert2d')
								) ,
								'required'	=> array(
									array('setup4_submitpage_itemtypes_check','=','1'),
									array('setup3_pointposttype_pt4_check','=','1')
								),
								'default' => '0'
								
							) ,
							array(
								'id' => 'setup4_submitpage_itemtypes_validation',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Validation', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								'required'	=> array('setup4_submitpage_itemtypes_check','=','1'),
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup4_submitpage_itemtypes_verror',
								'type' => 'text',
								'title' => esc_html__('Selection Box Validation Error', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_itemtypes_check','=','1'),
									array('setup4_submitpage_itemtypes_validation','=','1')
								),
								'default' => esc_html__('Please select an item type.', 'pointfindert2d')
							) ,
							array(
								'id' => 'stp_hlp3',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc' => esc_html__('This post type currently disabled by Post Type Setup', 'pointfindert2d'),
								'required'	=> array('setup3_pointposttype_pt4_check','=','0'),
							) ,
	                    array(
	                        'id'        => 'setup4_submitpage_itemtypes-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                        'required'	=> array('setup3_pointposttype_pt4_check','=','1'),
	                    ),

	                    /** Location Types **/
	                    array(
	                        'id'        => 'setup4_submitpage_locationtypes-start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Location Options', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('You can change select box variables by using below controls.', 'pointfindert2d'),
	                        'indent'    => true, 
	                        'required'	=> array('setup3_pointposttype_pt5_check','=','1'),
	                    ),
	                    	array(
								'id' => 'setup4_submitpage_locationtypes_check',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								) ,
								'required'	=> array('setup3_pointposttype_pt5_check','=','1'),
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup4_submitpage_locationtypes_title',
								'type' => 'text',
								'title' => esc_html__('Selection Box Title', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup3_pointposttype_pt5_check','=','1'),
								),
								'default' => esc_html__('Location', 'pointfindert2d')
							) ,
							
							array(
								'id' => 'stp4_loc_new',
								'type' => 'button_set',
								'title' => esc_html__('Location System with AJAX', 'pointfindert2d') ,
								'desc' => esc_html__('This options enable 3 level location with AJAX load & User locations option. But disable multiple location select & group options.', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								) ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup3_pointposttype_pt5_check','=','1')
								),
								'default' => '0'
								
							) ,
							array(
								'id' => 'stp4_loc_add',
								'type' => 'button_set',
								'title' => esc_html__('Users Can Add Location', 'pointfindert2d') ,
								'desc' => esc_html__('This options enable to add locations for users.', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup3_pointposttype_pt5_check','=','1'),
									array('stp4_loc_new','=','1')
								),
								'default' => '0'
								
							) ,
							array(
								'id' => 'stp4_sublotyp_title',
								'type' => 'text',
								'title' => esc_html__('2nd Selection Box Title', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup3_pointposttype_pt5_check','=','1'),
									array('stp4_loc_new','=','1')
								),
								'default' => esc_html__('Sub Location', 'pointfindert2d')
							) ,
							array(
								'id' => 'stp4_subsublotyp_title',
								'type' => 'text',
								'title' => esc_html__('3rd Selection Box Title', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup3_pointposttype_pt5_check','=','1'),
									array('stp4_loc_new','=','1')
								),
								'default' => esc_html__('Sub Sub Location', 'pointfindert2d')
							) ,
							
							array(
								'id' => 'setup4_submitpage_locationtypes_multiple',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Multiple', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Multiple Selection', 'pointfindert2d') ,
									'0' => esc_html__('Single Selection', 'pointfindert2d')
								) ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup3_pointposttype_pt5_check','=','1'),
									array('stp4_loc_new','=','0')
								),
								'default' => '0'
								
							) ,
							array(
								'id' => 'setup4_submitpage_locationtypes_validation',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Validation', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								'required'	=> array('setup4_submitpage_locationtypes_check','=','1'),
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup4_submitpage_locationtypes_verror',
								'type' => 'text',
								'title' => esc_html__('Selection Box Validation Error', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_locationtypes_check','=','1'),
									array('setup4_submitpage_locationtypes_validation','=','1')
								),
								'default' => esc_html__('Please select a location type.', 'pointfindert2d')
							) ,
							array(
								'id' => 'stp_hlp4',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc' => esc_html__('This post type currently disabled by Post Type Setup', 'pointfindert2d'),
								'required'	=> array('setup3_pointposttype_pt5_check','=','0'),
							) ,
	                    array(
	                        'id'        => 'setup4_submitpage_locationtypes-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                        'required'	=> array('setup3_pointposttype_pt5_check','=','1'),
	                    ),

	                    /** Features Types **/
	                    array(
	                        'id'        => 'setup4_submitpage_featurestypes-start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Features Options', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('You can change select box variables by using below controls.', 'pointfindert2d'),
	                        'indent'    => true, 
	                        'required'	=> array('setup3_pointposttype_pt6_check','=','1'),
	                    ),
	                    	array(
								'id' => 'setup4_submitpage_featurestypes_title',
								'type' => 'text',
								'title' => __('Selection Box Title', 'pointfindert2d') ,
								'required'	=> array(
									array('setup3_pointposttype_pt6_check','=','1')
								),
								'default' => __('Features', 'pointfindert2d')
							) ,
	                    	array(
								'id' => 'setup4_submitpage_featurestypes_check',
								'type' => 'button_set',
								'title' => esc_html__('Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'required'	=> array('setup3_pointposttype_pt6_check','=','1'),
								'default' => '1'
								
							) ,
							array(
								'id' => 'stp_hlp5',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc' => esc_html__('This post type currently disabled by Post Type Setup', 'pointfindert2d'),
								'required'	=> array('setup3_pointposttype_pt6_check','=','0'),
							) ,
	                    array(
	                        'id'        => 'setup4_submitpage_featurestypes-end',
	                        'type'      => 'section',
	                        'indent'    => false, 
	                        'required'	=> array('setup3_pointposttype_pt6_check','=','1'),
	                    ),

	                    /** Conditions Types **/
	                    array(
	                        'id'        => 'stp4_conditions-start',
	                        'type'      => 'section',
	                        'title'     => esc_html__('Conditions Options', 'pointfindert2d'),
	                        'subtitle'  => esc_html__('You can change select box variables by using below controls.', 'pointfindert2d'),
	                        'indent'    => true
	                    ),
	                    	array(
								'id' => 'setup4_submitpage_conditions_title',
								'type' => 'text',
								'title' => __('Selection Box Title', 'pointfindert2d') ,
								'default' => __('Conditions', 'pointfindert2d')
							) ,
	                    	array(
								'id' => 'setup4_submitpage_conditions_check',
								'type' => 'button_set',
								'title' => esc_html__('Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => 0
								
							) ,
							array(
								'id' => 'setup4_submitpage_conditions_validation',
								'type' => 'button_set',
								'title' => esc_html__('Selection Box Validation', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								'required'	=> array('setup4_submitpage_conditions_check','=','1'),
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup4_submitpage_conditions_verror',
								'type' => 'text',
								'title' => esc_html__('Selection Box Validation Error', 'pointfindert2d') ,
								'required'	=> array(
									array('setup4_submitpage_conditions_check','=','1'),
									array('setup4_submitpage_conditions_validation','=','1')
								),
								'default' => esc_html__('Please select a condition.', 'pointfindert2d')
							) ,
	                    array(
	                        'id'        => 'stp4_conditions-end',
	                        'type'      => 'section',
	                        'indent'    => false
	                    ),
					)
				);

				
				/**
				*Profile Page Settings
				**/
					$this->sections[] = array(
						'id' => 'stp_prf',
						'subsection' => true,
						'title' => esc_html__('Profile Page Settings', 'pointfindert2d') ,
						'fields' => array(
								array(
									'id' => 'stp_prf_vat',
									'type' => 'button_set',
									'title' => esc_html__('Vat Field', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									) ,
									'default' => 1
									
								) ,
								array(
									'id' => 'stp_prf_country',
									'type' => 'button_set',
									'title' => esc_html__('Country Field', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									) ,
									'default' => 1
									
								) ,
								array(
									'id' => 'stp_prf_address',
									'type' => 'button_set',
									'title' => esc_html__('Address Field', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									) ,
									'default' => 1
									
								) ,
								
						)
					);
				/**
				*Profile Page Settings
				**/

				
				
				/**
				*Pay per post Settings
				**/
				$this->sections[] = array(
					'id' => 'st31_up2',
					'subsection' => true,
					'title' => esc_html__('Pay Per Post Packages', 'pointfindert2d') ,
					'fields' => array(
							array(
								'id' => 'stp31_up2_pn',
								'type' => 'text',
								'title' => esc_html__('First Package: Name', 'pointfindert2d') ,
								'default' => esc_html__('Basic Package', 'pointfindert2d'),
								'hint'      => array(
	                        		'content' => esc_html__('This is the first pay per post package name area.', 'pointfindert2d')
	                        	),
							),
							array(
		                        'id'        => 'setup31_userpayments_priceperitem',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('First Package: Price', 'pointfindert2d'),
		                        'desc'		=> esc_html__('Write 0 for free. You can define price sign and currency from Paypal Settings.', 'pointfindert2d'),
		                        'default'   => '10',
		                        'min'       => '0',
		                        'step'      => '1',
		                        'max'       => '100000'
		                    ),
		                    array(
		                        'id'        => 'setup31_userpayments_timeperitem',
		                        'type'      => 'spinner',
		                        'title'     => esc_html__('First Package: Duration', 'pointfindert2d'),
		                        'desc'		=> esc_html__('Time unit: days', 'pointfindert2d'),
		                        'default'   => '10',
		                        'min'       => '0',
		                        'step'      => '1',
		                        'max'       => '1000000'
		                    ),
		                    array(
								'id' => 'stp_hlp6',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'desc' => sprintf(esc_html__('Please check %s Listing Packages page %s for define more package.', 'pointfindert2d'),'<a href="'.admin_url('edit.php?post_type=pflistingpacks').'"><strong>','</strong></a>')
							),
							array(
								'id' => 'stp31_userfree',
								'type' => 'button_set',
								'title' => esc_html__('User Free Plan Renew', 'pointfindert2d') ,
								'desc'		=> esc_html__('If this enabled, user can renew free plans forever.', 'pointfindert2d'),
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => 0
								
							) ,
			                
					)
					
				);


				/**
				*Pay per post Limits
				**/
				$this->sections[] = array(
					'id' => 'setup31_userpayments_1',
					'subsection' => true,
					'title' => esc_html__('My Items Page Limits', 'pointfindert2d') ,
					'fields' => array(
							array(
								'id' => 'stp_hlp7',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'title' => esc_html__('Limits for Items', 'pointfindert2d') ,
								'desc' => esc_html__('Below options will affect all user items.', 'pointfindert2d')
							) ,
							array(
								'id' => 'setup31_userlimits_useredit',
								'type' => 'button_set',
								'title' => esc_html__('Can user edit published items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
							array(
								'id' => 'setup31_userlimits_userdelete',
								'type' => 'button_set',
								'title' => esc_html__('Can user remove published items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup31_userlimits_userdelete_pendingapproval',
								'type' => 'button_set',
								'title' => esc_html__('Can user remove pending approval items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1'
								
							) ,
							array(
								'id' => 'setup31_userlimits_useredit_pendingpayment',
								'type' => 'button_set',
								'title' => esc_html__('Can user edit pending payment items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1',
								'required' => array('setup4_membersettings_paymentsystem','=',1)
							) ,
							array(
								'id' => 'setup31_userlimits_userdelete_pendingpayment',
								'type' => 'button_set',
								'title' => esc_html__('Can user remove pending payment items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1',
								'required' => array('setup4_membersettings_paymentsystem','=',1)
								
							) ,
							array(
								'id' => 'setup31_userlimits_useredit_rejected',
								'type' => 'button_set',
								'title' => esc_html__('Can user edit rejected items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
							array(
								'id' => 'setup31_userlimits_userdelete_rejected',
								'type' => 'button_set',
								'title' => esc_html__('Can user remove rejected items?', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Yes', 'pointfindert2d') ,
									'0' => esc_html__('No', 'pointfindert2d')
								) ,
								'default' => '1'
								
							) ,
						)
				);


				/**
				*Featured Item Settings
				**/
				$this->sections[] = array(
					'id' => 'setup32_featureditems',
					'subsection' => true,
					'title' => esc_html__('Featured Item Settings', 'pointfindert2d') ,
					'fields' => array(
		                    array(
								'id' => 'setup31_userpayments_featuredoffer',
								'type' => 'button_set',
								'title' => esc_html__('Featured Item Offer Area', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1'
								
							) ,
							array(
		                        'id'        => 'setup31_userpayments_featuredoffer-start',
		                        'type'      => 'section',
		                        'indent'    => true, 
		                        'required'	=>array('setup31_userpayments_featuredoffer','=','1'),
		                    ),
		                    	
		                    	array(
									'id' => 'setup31_userpayments_titlefeatured',
									'type' => 'text',
									'title' => esc_html__('Title for Featured Item', 'pointfindert2d') ,
									'required'	=>array('setup31_userpayments_featuredoffer','=','1'),
									'default' => esc_html__('Featured Item','pointfindert2d')
								) ,
			                    array(
			                        'id'        => 'setup31_userpayments_pricefeatured',
			                        'type'      => 'spinner',
			                        'title'     => esc_html__('Price for Featured Item', 'pointfindert2d'),
			                        'desc'		=> esc_html__('This option can not be free! You can define price sign and currency on Paypal Settings. This price only works with Pay Per Post System', 'pointfindert2d'),
			                        'default'   => '5',
			                        'min'       => '1',
			                        'step'      => '1',
			                        'max'       => '10000000',
			                        'required'	=> array(array('setup31_userpayments_featuredoffer','=',1),array('setup4_membersettings_paymentsystem','=',1))
			                    ),

			                    array(
			                        'id'        => 'stp31_daysfeatured',
			                        'type'      => 'spinner',
			                        'title'     => esc_html__('Duration for Featured Item', 'pointfindert2d'),
			                        'desc'		=> esc_html__('You can define duration for featured item option. This option only works with Pay Per Post System', 'pointfindert2d'),
			                        'default'   => '3',
			                        'min'       => '1',
			                        'step'      => '1',
			                        'max'       => '10000000',
			                        'required'	=> array(array('setup31_userpayments_featuredoffer','=',1),array('setup4_membersettings_paymentsystem','=',1))
			                    ),
			                    
			                    array(
				                    'id'        => 'setup31_userpayments_textfeatured',
				                    'type'      => 'textarea',
				                    'title'     => esc_html__('Description for Featured Item Box', 'pointfindert2d'),
				                    'validate'  => 'no_html',
				                    'default'	=> esc_html__('Featured item option have more visibility than others. Enable this option and appear on top of listings.','pointfindert2d')
				                    ,'required'	=> array('setup31_userpayments_featuredoffer','=',1)
				                ),
				                array(
			                        'id'        => 'setup31_userpayments_featuredbgc',
			                        'type'      => 'color',
			                        'transparent' => false,
			                        'compiler'	=> array('#pfuaprofileform .pfupload-featured-item-box'),
			                        'mode'      => 'background',
			                        'title'     => esc_html__('Background Color for Box', 'pointfindert2d'),
			                        'default'   => '#fae7a2',
			                        'validate'  => 'color',
			                        'required'	=> array('setup31_userpayments_featuredoffer','=',1)
			                    ),
			                    array(
			                        'id'        => 'setup31_userpayments_featuredtextc',
			                        'type'      => 'color',
			                        'compiler'	=> array('#pfuaprofileform .pfupload-featured-item-box'),
			                        'transparent' => false,
			                        'title'     => esc_html__('Text Color for Box', 'pointfindert2d'),
			                        'default'   => '#494949',
			                        'validate'  => 'color',
			                        'required'	=> array('setup31_userpayments_featuredoffer','=',1)
			                    ),
			                    
			                array(
		                        'id'        => 'setup31_userpayments_featuredoffer-end',
		                        'type'      => 'section',
		                        'indent'    => false, 
		                        'required'	=>array('setup31_userpayments_featuredoffer','=','1')
		                    ),
		                  )
				);
				

				
				

				/**
				*Paypal Settings
				**/
				$this->sections[] = array(
					'id' => 'setup20_paypalsettings',
					'subsection' => true,
					'title' => esc_html__('Paypal Settings', 'pointfindert2d'),
					'fields' => array(
							array(
								'id' => 'setup20_paypalsettings_paypal_status',
								'type' => 'button_set',
								'title' => esc_html__('Paypal Payment System', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => 0
							) ,
							array(
								'id' => 'setup20_paypalsettings_paypal_sandbox',
								'desc' => esc_html__('If you are using LIVE site please disable this after test.', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('Sandbox(TEST) Mode', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1',
								'required' => array('setup20_paypalsettings_paypal_status','=','1')
							) ,
							array(
								'id' => 'setup31_userpayments_recurringoption',
								'type' => 'button_set',
								'title' => esc_html__('Paypal Recurring Payments', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1',
                                'required' => array('setup20_paypalsettings_paypal_status','=','1')
							) ,
							
							array(
								'id' => 'setup20_paypalsettings_paypal_verified',
								'desc' => esc_html__('If this option is enabled: Pointfinder will only accept payments from verified Paypal Users', 'pointfindert2d') ,
								'type' => 'button_set',
								'title' => esc_html__('Accept Only Verified Users', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0',
								'required' => array('setup20_paypalsettings_paypal_status','=','1')
							) ,
							array(
		                        'id'        => 'setup20_paypalsettings_paypal_price_unit',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Paypal Price Unit', 'pointfindert2d'),
		                        'default'	=> 'USD',
		                        'hide'	=> true,
		                        'required' => array('setup20_paypalsettings_paypal_status','=','1'),
		                        'desc'		=> sprintf(esc_html__('You can find all currency codes on this page %s', 'pointfindert2d'),'<a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">https://developer.paypal.com/docs/classic/api/currency_codes/</a>'),
		                    ),
							array(
		                        'id'        => 'setup20_paypalsettings_paypal_api_user',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Paypal API User', 'pointfindert2d'),
		                        'required' => array('setup20_paypalsettings_paypal_status','=','1')
		                    ),
		                    array(
		                        'id'        => 'setup20_paypalsettings_paypal_api_pwd',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Paypal API Password', 'pointfindert2d'),
		                        'required' => array('setup20_paypalsettings_paypal_status','=','1')
		                    ),
		                    array(
		                        'id'        => 'setup20_paypalsettings_paypal_api_signature',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Paypal API Signature', 'pointfindert2d'),
		                        'required' => array('setup20_paypalsettings_paypal_status','=','1')
		                    )
						) ,
				);
				

				/**
				*Stripe Settings
				**/
				$this->sections[] = array(
					'id' => 'setup20_stripesettings',
					'subsection' => true,
					'title' => esc_html__('Stripe Settings', 'pointfindert2d'),
					'fields' => array(
							array(
								'id' => 'setup20_stripesettings_status',
								'type' => 'button_set',
								'title' => esc_html__('Stripe Payment System', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0'
							) ,
							array(
		                        'id'        => 'setup20_stripesettings_secretkey',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Secret Key', 'pointfindert2d'),
		                        'required' => array('setup20_stripesettings_status','=','1')
		                    ),
		                    array(
		                        'id'        => 'setup20_stripesettings_publishkey',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Publishable Key', 'pointfindert2d'),
		                        'required' => array('setup20_stripesettings_status','=','1')
		                    ),
		                    array(
		                        'id'        => 'setup20_stripesettings_sitename',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Site Name', 'pointfindert2d'),
		                        'desc' => esc_html__('This will seen in payment box. Ex: Stripe.com', 'pointfindert2d') ,
		                        'required' => array('setup20_stripesettings_status','=','1')
		                    ),
		                    array(
		                        'id'        => 'setup20_stripesettings_currency',
		                        'type'      => 'text',
		                        'title'     => esc_html__('Stripe Currency', 'pointfindert2d'),
		                        'default'	=> 'USD',
		                        'required' => array('setup20_stripesettings_status','=','1'),
		                        'desc'		=> sprintf(esc_html__('Please check this page for other currencies: %s CURRENCY CODES %s', 'pointfindert2d'),'<a href="https://support.stripe.com/questions/which-currencies-does-stripe-support" target="_blank">','</a>'),
		                    ),
		                    array(
								'id' => 'setup20_stripesettings_decimals',
								'type' => 'button_set',
								'title' => esc_html__('Decimals', 'pointfindert2d') ,
								'desc'      => sprintf(esc_html__('Please check this page: %s DECIMAL INFO %s %s If your currency listed in this page please use decimal number 0', 'pointfindert2d'),'<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">','</a>','<br/>'),
								'options' => array(
									'2' => esc_html__('2', 'pointfindert2d') ,
									'0' => esc_html__('0', 'pointfindert2d')
								) ,
								'default' => '2',
								'required' => array('setup20_stripesettings_status','=','1'),
							)
					)
				);

				/**
				*Bank Deposit Settings
				**/
				$this->sections[] = array(
					'id' => 'setup20_bankdepositsettings',
					'subsection' => true,
					'title' => esc_html__('Bank Deposit Settings', 'pointfindert2d'),
					'fields' => array(
							array(
								'id' => 'setup20_paypalsettings_bankdeposit_status',
								'type' => 'button_set',
								'title' => esc_html__('Bank Deposit System', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0'
							) ,
							array(
		                        'id'        => 'setup20_bankdepositsettings_text',
		                        'type'      => 'textarea',
		                        'title'     => esc_html__('Bank Deposit Page Instruction', 'pointfindert2d'),
		                        'subtitle'  => esc_html__('This text will be seen after bank transfer payment option is selected.', 'pointfindert2d'),
		                        'required'	=> array('setup20_paypalsettings_bankdeposit_status','=','1'),
		                        'validate'      => 'html_custom',
		                        'allowed_html'  => array( 'a' => array( 'href' => array(), 'title' => array() ), 'br' => array(), 'em' => array(), 'strong' => array(), 'p' => array( 'align' => true, 'dir' => true, 'lang' => true, 'xml:lang' => true, ), 'b' => array(), 'blockquote' => array( 'cite' => true, 'lang' => true, 'xml:lang' => true, ), 'div' => array( 'align' => true, 'dir' => true, 'lang' => true, 'xml:lang' => true, ), 'font' => array( 'color' => true, 'face' => true, 'size' => true, ), 'h1' => array( 'align' => true, ), 'h2' => array( 'align' => true, ), 'h3' => array( 'align' => true, ), 'h4' => array( 'align' => true, ), 'h5' => array( 'align' => true, ), 'h6' => array( 'align' => true, ), 'ul' => array( 'type' => true, ), 'li' => array( 'align' => true, 'value' => true, ), ) ),
							
						) ,
				);
			/**
			*End : FRONTEND SUBMISSON SETTINS
			**/
			



			/**
			*Start : SYSTEM SETUP 
			**/
				$this->sections[] = array(
					'id' => 'setup23_systemsetup',
					'title' => esc_html__('System Setup', 'pointfindert2d'),
					'icon' => 'el-icon-wrench',
					'fields' => array(
							array(
								'id' => 'stp_hlp8',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'title' => esc_html__('Informations', 'pointfindert2d') ,
								'desc' => '<br/>'.esc_html__('System Setup is the section which provides you to create Custom Detail & Search Fields, edit Post Types, Review, Favorites and Extra Modules.', 'pointfindert2d')
							) ,
							array(
								'id' => 'stp_hlp9',
								'type' => 'info',
								'notice' => true,
								'style' => 'info',
								'title' => esc_html__('Suggestions', 'pointfindert2d') ,
								'desc' => '<br/>'.esc_html__('1-) Please click "Save Changes" button after you finish changing options.','pointfindert2d').'<br/>'.esc_html__('2-) After you finish configuration please backup by using Import/Export area. This backup provides you to go back if you make a mistake.', 'pointfindert2d')
							) ,
						) ,
				);


				/**
				*Custom Detail Fields
				**/
				$this->sections[] = array(
					'id' => 'setup1',
					'title' => 'Custom Detail Fields',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'stp_hlp10',
							'type' => 'info',
							'notice' => true,
							'style' => 'critical',
							'title' => esc_html__('IMPORTANT NOTICE', 'pointfindert2d'),
							'desc' => esc_html__('Please configure these sections before you use theme. If you change configuration after using theme, data which is related to these sections will be lost.', 'pointfindert2d')
						) ,
						array(
							'id' => 'stp_hlp11',
							'type' => 'info',
							'notice' => true,
							'style' => 'critical',
							'title' => esc_html__('Slug Term', 'pointfindert2d') ,
							'desc' => '<br/>'.esc_html__('The "Slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens. (No Spaces) This key is unique. If you change the key name, data which is related to the key will be lost.', 'pointfindert2d')
						) ,
						array(
							'id' => 'stp_hlp12',
							'type' => 'info',
							'notice' => true,
							'style' => 'warning',
							'desc' => esc_html__('1-) You can define custom & search fields as much as you wish.','pointfindert2d').'<br/>'.esc_html__('2-) If you change sort of fields, sort of that field will be affected in whole system.', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup1_slides',
							'type' => 'extension_custom_slides',
							'title' => esc_html__('Custom Fields', 'pointfindert2d') ,
							'placeholder' => array(
								'title' => esc_html__('Write a field name like Bedroom', 'pointfindert2d') ,
								'select' => esc_html__('Select Field Type', 'pointfindert2d') ,
								'url' => esc_html__('Slug: unique name. Leave blank for auto assign.', 'pointfindert2d') ,
							) ,
							'options' => array(
								"1" => esc_html__("Text","pointfindert2d"),
								"2" => esc_html__("URL","pointfindert2d"),
								"3" => esc_html__("Email","pointfindert2d"),
								"4" => esc_html__("Number","pointfindert2d"),
								"5" => esc_html__("Textarea","pointfindert2d"),
								"9" => esc_html__("Checkbox","pointfindert2d"),
								"7" => esc_html__("Radio Button","pointfindert2d"),
								"8" => esc_html__("Select Box","pointfindert2d"),
								"14" => esc_html__("Select Box(Multiple)","pointfindert2d"),
								"15" => esc_html__("Date","pointfindert2d"),
							) ,
						
						) ,
					)
				);



				/**
				*Search Fields
				**/
				$this->sections[] = array(
					'id' => 'setup1s',
					'title' => esc_html__('Search Fields', 'pointfindert2d'),
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'stp_hlp13',
							'type' => 'info',
							'notice' => true,
							'style' => 'critical',
							'title' => esc_html__('IMPORTANT NOTICE', 'pointfindert2d'),
							'desc' => esc_html__('Please configure these sections before you use theme. If you change configuration after using theme, data which is related to these sections will be lost.', 'pointfindert2d')
						) ,
						array(
							'id' => 'stp_hlp14',
							'type' => 'info',
							'notice' => true,
							'style' => 'critical',
							'title' => esc_html__('Slug Term', 'pointfindert2d') ,
							'desc' => '<br/>'.esc_html__('The "Slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens. (No Spaces) This key is unique. If you change the key name, data which is related to the key will be lost.', 'pointfindert2d')
						) ,
						array(
							'id' => 'stp_hlp15',
							'type' => 'info',
							'notice' => true,
							'style' => 'warning',
							'desc' => esc_html__('1-) You can define custom & search fields as much as you wish.','pointfindert2d').'<br/>'.esc_html__('2-) If you change sort of fields, sort of that field will be affected in whole system.', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup1s_slides',
							'type' => 'extension_custom_slides',
							'title' => esc_html__('Custom Search Fields', 'pointfindert2d') ,
							'placeholder' => array(
								'title' => esc_html__('Write a search field name like Price', 'pointfindert2d') ,
								'select' => esc_html__('Select Field Type', 'pointfindert2d') ,
								'url' => esc_html__('Slug: unique name. Leave blank for auto assign.', 'pointfindert2d') ,
							) ,
							'options' => array(
								"1" => esc_html__("Select Box (Dropdown)","pointfindert2d"),
								"2" => esc_html__("Slider","pointfindert2d"),
								"4" => esc_html__("Text Field","pointfindert2d"),
								"5" => esc_html__("Date","pointfindert2d"),
								"6" => esc_html__("Checkbox","pointfindert2d")
							)
						) ,
					)
				);


				/**
				*Post types Setup
				**/
				$this->sections[] = array(
					'id' => 'setup3_pointposttype',
					'title' => esc_html__('Post Type Setup', 'pointfindert2d') ,
					'subsection' => true,
					'fields' => array(
						
						array(
							'id' => 'stp_hlp16',
							'type' => 'info',
							'notice' => true,
							'style' => 'critical',
							'title' => esc_html__('IMPORTANT NOTICE', 'pointfindert2d'),
							'desc' => esc_html__('Please configure these sections before you use theme. If you change configuration after using theme, data which is related to these sections will be lost.', 'pointfindert2d').'<br/ >'.esc_html__('You may need to flush the rewrite rules after changing this. You can do it manually by going to the Permalink Settings page and re-saving the rules', 'pointfindert2d').'<br/ ><strong>'.esc_html__('Please use small caps on "Post Type Name & Category x Pretty Name','pointfindert2d').'</strong>'
						) ,
						array(
							'id' => 'section-setup3_pointposttype_pt1-start',
							'type' => 'section',
							'title' => esc_html__('Item Post Type', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt1',
								'type' => 'text',
								'title' => esc_html__('Post Type Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " pfitemfinder ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('Please do not change after adding any map point. Otherwise your existing Points in the system might be lost.', 'pointfindert2d') ,
								'subtitle' => esc_html__('Must be only text or numbers, no spaces and special chars & please use small caps!!', 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'pfitemfinder'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt2',
								'type' => 'text',
								'title' => esc_html__('Singular Name', 'pointfindert2d') ,
								'desc' => '<strong>'.esc_html__('Important:','pointfindert2d').'</strong>'.esc_html__('This change will not affect your existing agents.', 'pointfindert2d') ,
								'default' => 'PF Item'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt3',
								'type' => 'text',
								'title' => esc_html__('Plural Name', 'pointfindert2d') ,
								'desc' => '<strong>'.esc_html__('Important:','pointfindert2d').'</strong>'.esc_html__('This change will not affect your existing agents.', 'pointfindert2d') ,
								'default' => 'PF Items'
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt1-end',
							'type' => 'section',
							'indent' => false
						) ,
						array(
							'id' => 'section-setup3_pointposttype_pt7-start',
							'type' => 'section',
							'title' => esc_html__('Category 0 Options', 'pointfindert2d') ,
							'subtitle' => esc_html__('"Listing Types" category options', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt7',
								'type' => 'text',
								'title' => esc_html__('Category 0 Plural Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Listing Types ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Listing Types'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt7s',
								'type' => 'text',
								'title' => esc_html__('Category 0 Single Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Listing Type ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Listing Type'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt7p',
								'type' => 'text',
								'title' => esc_html__('Category 0 Pretty Name', 'pointfindert2d') ,
								'desc' => esc_html__("Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy (taxonomy's name slug) & please use small caps!!", 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'listings'
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt7-end',
							'type' => 'section',
							'indent' => false
						) ,
						array(
							'id' => 'section-setup3_pointposttype_pt4-start',
							'type' => 'section',
							'title' => esc_html__('Category 1 Options', 'pointfindert2d') ,
							'subtitle' => esc_html__('"Item Types" category options', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt4',
								'type' => 'text',
								'title' => esc_html__('Category Plural Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', "Item Types ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Item Types'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt4s',
								'type' => 'text',
								'title' => esc_html__('Category Single Name', 'pointfindert2d') ,								
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Item Type").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Item Type'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt4p',
								'type' => 'text',
								'title' => esc_html__('Category 1 Pretty Name', 'pointfindert2d') ,
								'desc' => esc_html__("Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy (taxonomy's name slug) & please use small caps!!", 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'types'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt4_check',
								'type' => 'button_set',
								'title' => esc_html__('Category Status', 'pointfindert2d') ,
								"default" => '1',
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt4-end',
							'type' => 'section',
							'indent' => false
						) ,
						array(
							'id' => 'section-setup3_pointposttype_pt5-start',
							'type' => 'section',
							'title' => esc_html__('Category 2 Options', 'pointfindert2d') ,
							'subtitle' => esc_html__('"Locations" category options', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt5',
								'type' => 'text',
								'title' => esc_html__('Category 2 Plural Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Locations ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Locations'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt5s',
								'type' => 'text',
								'title' => esc_html__('Category 2 Single Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Location ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Location'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt5p',
								'type' => 'text',
								'title' => esc_html__('Category 2 Pretty Name', 'pointfindert2d') ,
								'desc' => esc_html__("Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy (taxonomy's name slug) & please use small caps!!", 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'area'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt5_check',
								'type' => 'button_set',
								'title' => esc_html__('Category Status', 'pointfindert2d') ,
								"default" => '1',
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt5-end',
							'type' => 'section',
							'indent' => false
						) ,
						array(
							'id' => 'section-setup3_pointposttype_pt6-start',
							'type' => 'section',
							'title' => esc_html__('Category 3 Options', 'pointfindert2d') ,
							'subtitle' => esc_html__('"Features" category options', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt6',
								'type' => 'text',
								'title' => esc_html__('Category 3 Plural Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Features ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Features'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt6s',
								'type' => 'text',
								'title' => esc_html__('Category 3 Single Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Feature ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Feature'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt6p',
								'type' => 'text',
								'title' => esc_html__('Category 3 Pretty Name', 'pointfindert2d') ,
								'desc' => esc_html__("Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy (taxonomy's name slug) & please use small caps!!", 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'feature'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt6_check',
								'type' => 'button_set',
								'title' => esc_html__('Category Status', 'pointfindert2d') ,
								"default" => 1,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt6-end',
							'type' => 'section',
							'indent' => false
						) ,

						array(
							'id' => 'section-pt14-start',
							'type' => 'section',
							'title' => esc_html__('Category 4 Options', 'pointfindert2d') ,
							'subtitle' => esc_html__('"Condition" category options', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pt14',
								'type' => 'text',
								'title' => esc_html__('Category 4 Plural Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Conditions ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Conditions'
							) ,
							array(
								'id' => 'setup3_pt14s',
								'type' => 'text',
								'title' => esc_html__('Category 4 Single Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " Condition ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'Condition'
							) ,
							array(
								'id' => 'setup3_pt14p',
								'type' => 'text',
								'title' => esc_html__('Category 4 Pretty Name', 'pointfindert2d') ,
								'desc' => esc_html__("Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy (taxonomy's name slug) & please use small caps!!", 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'condition'
							) ,
							array(
								'id' => 'setup3_pt14_check',
								'type' => 'button_set',
								'title' => esc_html__('Category Status', 'pointfindert2d') ,
								"default" => 0,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								
							) ,
						array(
							'id' => 'section-pt14-end',
							'type' => 'section',
							'indent' => false
						) ,


						array(
							'id' => 'section-setup3_pointposttype_pt8-start',
							'type' => 'section',
							'title' => esc_html__('Agents Post Type', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt6_status',
								'type' => 'button_set',
								'title' => esc_html__('Agents Post Type Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => 1
							) ,
							array(
								'id' => 'setup3_pointposttype_pt8',
								'type' => 'text',
								'title' => esc_html__('Post Type Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " agents ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('Please do not change after adding any map point. Otherwise your existing "Points" in the system might be lost.', 'pointfindert2d') ,
								'subtitle' => esc_html__('Must be only text or numbers, no spaces and special chars & please use small caps!!', 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'agents'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt9',
								'type' => 'text',
								'title' => esc_html__('Singular Name', 'pointfindert2d') ,
								'desc' => '<strong>'.esc_html__('Important:', 'pointfindert2d').'</strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'PF Agent'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt10',
								'type' => 'text',
								'title' => esc_html__('Plural Name', 'pointfindert2d') ,
								'desc' => '<strong>'.esc_html__('Important:', 'pointfindert2d').'</strong>'.esc_html__('This change will not affect your existing points.', 'pointfindert2d') ,
								'default' => 'PF Agents'
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt8-end',
							'type' => 'section',
							'indent' => false
						) ,
						array(
							'id' => 'section-setup3_pointposttype_pt12-start',
							'type' => 'section',
							'title' => esc_html__('Testimonials Post Type', 'pointfindert2d') ,
							'indent' => true
						) ,
							array(
								'id' => 'setup3_pointposttype_pt11',
								'type' => 'text',
								'title' => esc_html__('Post Type Name', 'pointfindert2d') ,
								'desc' => sprintf('<strong>'.esc_html__('Existing name: %s','pointfindert2d').'</strong>', " pftestimonials ").'<br/><strong> '.esc_html__('Important :','pointfindert2d').' </strong>'.esc_html__('Please do not change after adding any map point. Otherwise your existing "Testimonials" in the system might be lost.', 'pointfindert2d') ,
								'subtitle' => esc_html__('Must be only text or numbers, no spaces and special chars & please use small caps!!.', 'pointfindert2d') ,
								'validate' => 'no_special_chars',
								'default' => 'testimonials'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt13',
								'type' => 'text',
								'title' => esc_html__('Singular Name', 'pointfindert2d') ,
								'desc' => '<strong>'.esc_html__('Important:', 'pointfindert2d').'</strong>'.esc_html__('This change will not affect your existing testimonials.', 'pointfindert2d') ,
								'default' => 'Testimonial'
							) ,
							array(
								'id' => 'setup3_pointposttype_pt12',
								'type' => 'text',
								'title' => esc_html__('Plural Name', 'pointfindert2d') ,
								'desc' => '<strong>'.esc_html__('Important:', 'pointfindert2d').'</strong>'.esc_html__('This change will not affect your existing testimonials.', 'pointfindert2d') ,
								'default' => 'PF Testimonials'
							) ,
						array(
							'id' => 'section-setup3_pointposttype_pt12-end',
							'type' => 'section',
							'indent' => false
						) ,
					)
				);



				/**
				*Connections Setup
				**/
				$this->sections[] = array(
					'id' => 'stp_syncs',
					'title' => esc_html__('Listing Type Connections', 'pointfindert2d') ,
					'subsection' => true,
					'fields' => array(
						
						array(
							'id' => 'stp_hlplt1',
							'type' => 'info',
							'notice' => true,
							'style' => 'warning',
							'title' => esc_html__('INFO', 'pointfindert2d'),
							'desc' => esc_html__("You can manage connection between Listing Types and other taxonomies by using below settings. If you can't find your taxonomy setting on the below, please check Post Type Setup from left menu.",'pointfindert2d').'<br/><br/>'.esc_html__("If this selection enabled, system will hide all taxonomy elements until Listing Type select which connected with this taxonomy element.","pointfindert2d"),
							
						) ,
						array(
							'id' => 'section-stp_syncs1-start',
							'type' => 'section',
							'title' => esc_html__('Connection between Listing Type and Features Taxonomy', 'pointfindert2d') ,
							'indent' => true,
							'required'	=> array('setup3_pointposttype_pt6_check','=','1'),
						) ,
							array(
								'id' => 'setup4_sbf_c1',
								'type' => 'button_set',
								'title' => esc_html__('Features Taxonomy Connection Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Disable Connection', 'pointfindert2d') ,
									'0' => esc_html__('Enable Connection', 'pointfindert2d')
								) ,
								
								'required'	=> array('setup3_pointposttype_pt6_check','=','1'),
								'default' => 1
								
							) ,
						array(
							'id' => 'section-stp_syncs1-end',
							'type' => 'section',
							'indent' => false,
							'required'	=> array('setup3_pointposttype_pt6_check','=','1'),
						),


						array(
							'id' => 'section-stp_syncs2-start',
							'type' => 'section',
							'title' => esc_html__('Connection between Listing Type and Item Types Taxonomy', 'pointfindert2d') ,
							'indent' => true,
							'required'	=> array('setup3_pointposttype_pt4_check','=','1'),
						) ,
							array(
								'id' => 'stp_syncs_it',
								'type' => 'button_set',
								'title' => esc_html__('Item Types Taxonomy Connection Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Disable Connection', 'pointfindert2d') ,
									'0' => esc_html__('Enable Connection', 'pointfindert2d')
								) ,
								'required'	=> array('setup3_pointposttype_pt4_check','=','1'),
								'default' => 1
								
							) ,
						array(
							'id' => 'section-stp_syncs2-end',
							'type' => 'section',
							'indent' => false,
							'required'	=> array('setup3_pointposttype_pt4_check','=','1'),
						),



						array(
							'id' => 'section-stp_syncs3-start',
							'type' => 'section',
							'title' => esc_html__('Connection between Listing Type and Conditions Taxonomy', 'pointfindert2d') ,
							'indent' => true,
							'required'	=> array('setup3_pt14_check','=','1'),
						) ,
							array(
								'id' => 'stp_syncs_co',
								'type' => 'button_set',
								'title' => esc_html__('Conditions Taxonomy Connection Status', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Disable Connection', 'pointfindert2d') ,
									'0' => esc_html__('Enable Connection', 'pointfindert2d')
								) ,
								'required'	=> array('setup3_pt14_check','=','1'),
								'default' => 1
								
							) ,
						array(
							'id' => 'section-stp_syncs3-end',
							'type' => 'section',
							'indent' => false,
							'required'	=> array('setup3_pt14_check','=','1'),
						)
					)
				);

			/**
			*End: SYSTEM SETUP
			**/



			/**
			*START: Favorites SYSTEM
			**/
			$this->sections[] = array(
				'id' => 'setup41_favsystem',
				'title' => esc_html__('Favorites System', 'pointfindert2d') ,
				'icon' => 'el-icon-star',
				'fields' => array(
					array(
						'id' => 'stp_hlp17',
						'type' => 'info',
						'notice' => true,
						'style' => 'warning',
						'desc' => esc_html__('Activation & Deactivation will not cause any data loss.', 'pointfindert2d')
					) ,
					array(
						'id' => 'setup4_membersettings_favorites',
						'type' => 'button_set',
						'title' => esc_html__('Favorites System', 'pointfindert2d') ,
						'options' => array(
							'1' => esc_html__('Enable', 'pointfindert2d') ,
							'0' => esc_html__('Disable', 'pointfindert2d')
						) ,
						'default' => '1',
					) ,
					array(
						'id' => 'setup41_favsystem_linkcolor',
						'type' => 'link_color',
						'title' => esc_html__('Heart Icon Color', 'pointfindert2d') ,
						'compiler' => array(
							'.pflist-imagecontainer .RibbonCTR .Sign i',
							'.wpfimage-wrapper .RibbonCTR .Sign i',
							'.anemptystylesheet'
						) ,
						'active' => false,
						'default' => array(
							'regular' => '#000000',
							'hover' => '#B32E2E'
						),
						'required' => array('setup4_membersettings_favorites','=','1')
					) ,
					array(
						'id' => 'setup41_favsystem_bgcolor',
						'type' => 'color',
						'transparent' => false,
						'title' => esc_html__('Heart Icon Background', 'pointfindert2d') ,
						'default' => '#fff',
						'required' => array('setup4_membersettings_favorites','=','1')
					) ,
					
				)
			);
			/**
			*END: Favorites SYSTEM
			**/
			
			
			
			
			
			
			
			/**
			*Start : MAP SETTINS
			**/
				$this->sections[] = array(
					'id' => 'setup5_mapsettings',
					'title' => esc_html__('Map Settings', 'pointfindert2d') ,
					'icon' => 'el-icon-globe',
					'fields' => array(
						array(
                            'id'       => 'setup5_mapsettings_maplanguage',
                            'type'     => 'select',
                            'title'    => __( 'Map Language', 'pointfindert2d' ),
                            'desc'     => __( 'You can change google map language.', 'pointfindert2d' ),
                            'options'  => array( 'ar'=>'ARABIC', 'eu'=>'BASQUE', 'bg'=>'BULGARIAN', 'bn'=>'BENGALI', 'ca'=>'CATALAN', 'cs'=>'CZECH', 'da'=>'DANISH', 'de'=>'GERMAN', 'el'=>'GREEK', 'en'=>'ENGLISH', 'en'=>'ENGLISH (AUSTRALIAN)', 'en'=>'ENGLISH (GREAT BRITAIN)', 'es'=>'SPANISH', 'fa'=>'FARSI', 'fi'=>'FINNISH', 'fi'=>'FILIPINO', 'fr'=>'FRENCH', 'gl'=>'GALICIAN', 'gu'=>'GUJARATI', 'hi'=>'HINDI', 'hr'=>'CROATIAN', 'hu'=>'HUNGARIAN', 'id'=>'INDONESIAN', 'it'=>'ITALIAN', 'iw'=>'HEBREW', 'ja'=>'JAPANESE', 'kn'=>'KANNADA', 'ko'=>'KOREAN', 'lt'=>'LITHUANIAN', 'lv'=>'LATVIAN', 'ml'=>'MALAYALAM', 'mr'=>'MARATHI', 'nl'=>'DUTCH', 'no'=>'NORWEGIAN', 'pl'=>'POLISH', 'pt'=>'PORTUGUESE', 'pt'=>'PORTUGUESE (BRAZIL)', 'pt'=>'PORTUGUESE (PORTUGAL)', 'ro'=>'ROMANIAN', 'ru'=>'RUSSIAN', 'sk'=>'SLOVAK', 'sl'=>'SLOVENIAN', 'sr'=>'SERBIAN', 'sv'=>'SWEDISH', 'tl'=>'TAGALOG', 'ta'=>'TAMIL', 'te'=>'TELUGU', 'th'=>'THAI', 'tr'=>'TURKISH', 'uk'=>'UKRAINIAN', 'vi'=>'VIETNAMESE', 'zh'=>'CHINESE (SIMPLIFIED)', 'zh'=>'CHINESE (TRADITIONAL)', ),
                            'default'  => 'en'
                        ),
						array(
							'id' => 'setup5_mapsettings_mapautoopen',
							'title' => esc_html__('Auto Open Search Results', 'pointfindert2d') ,
							'type' => 'button_set',
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d'),
								0 => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => 0
						) ,
						array(
							'id' => 'setup5_map_key',
							'title' => esc_html__('Google Map API Key', 'pointfindert2d') ,
							'type' => 'text',
							'desc' => sprintf(esc_html__("For API Usage Limits : %s","pointfindert2d"),"<a href=\"https://developers.google.com/maps/documentation/roads/usage-limits\" target=\"_blank\">https://developers.google.com/maps/documentation/roads/usage-limits</a>")
						) ,
						array(
							'id' => 'setup5_mzoom',
							'type' => 'spinner',
							'title' => esc_html__('Max Map Zoom', 'pointfindert2d') ,
							"default" => "20",
							"min" => "1",
							"step" => "1",
							"max" => "40",
							
						) ,
						),

				);


				/**
				*Map Notifications
				**/
				$this->sections[] = array(
					'id' => 'setup15_mapnotifications',
					'title' => esc_html__('Map Notifications', 'pointfindert2d') ,
					'subsection' => true,
	                'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Map Notifications: This notification will create a toggle window on the top of the map and show number of found items after search and site entrance.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_formapnotify.png" class="description-img" />'),
					'fields' => array(
						
						array(
							'id' => 'setup15_mapnotifications_notbg',
							'type' => 'color_rgba',
							'title' => esc_html__('Notification Content Background', 'pointfindert2d') ,
							'default' => array(
								'color' => '#f7f7f7',
								'alpha' => '0.9'
							) ,
							'compiler' => array(
								'.pfnotificationwindow'
							) ,
							'mode' => 'background',
							'validate' => 'colorrgba',
							'transparent' => false,
						) ,
						array(
	                        'id'        => 'setup15_mapnotifications_notbg_border',
	                        'type'      => 'border',
	                        'title'     => esc_html__('Notification Content Border Color', 'pointfindert2d'),
	                        'compiler'    => array('.pfnotificationwindow'), 
	                        'all' => true,
	                        'right'  => true,
	                        'top'  => true,
	                        'left'  => true,
	                        'style' => true,
	                        'bottom' => true,
	                        'color' => true,
	                        'default'   => array(
	                            'border-color'  => '#e0e0e0', 
	                            'border-style'  => 'solid', 
	                            'border-top'    => '1px', 
	                            'border-right'  => '1px', 
	                            'border-bottom' => '1px', 
	                            'border-left'   => '1px'
	                        )
	                    ),
						
						array(
							'id' => 'setup15_mapnotifications_nottext_typo',
							'type' => 'typography',
							'title' => esc_html__('Notification Content Text Typography', 'pointfindert2d') ,
							'google' => true,
							'font-backup' => true,
							'compiler' => array(
								'.pfnotificationwindow','.pfnotificationwindow a'
							) ,
							'units' => 'px',
							'default' => array(
								'color' => '#9e2121',
								'font-weight' => '400',
								'font-family' => 'Roboto',
								'google' => true,
								'font-size' => '12px',
								'line-height' => '16px',
							) ,
						) ,
						array(
								'id' => 'setup15_mapnotifications_searcherrorclosebg_ex',
								'type' => 'extension_custom_link_color',
								'mode' => 'background',
								'transparent' => false,
								'active' => false,
								'compiler' => array(
									'.pfnot-err-button'
								) ,
								'title' => esc_html__('Notification Indicator Background', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#9e2121',
									'hover' => '#721414'
								) ,
								'validate' => 'color',
								
							) ,
						array(
							'id' => 'setup15_mapnotifications_searcherrorclosetext',
							'type' => 'color',
							'compiler' => array(
								'.pfnot-err-button',
								'.pfnot-err-button:hover'
							) ,
							'title' => esc_html__('Notification Indicator Icon Color', 'pointfindert2d') ,
							'default' => '#ffffff',
							'validate' => 'color',
							'transparent' => false,
						) ,
						array(
							'id' => 'stp_hlp18',
							'type' => 'info',
							'notice' => true,
							'style' => 'info',
							'desc' => '<strong>'.esc_html__('Info:', 'pointfindert2d').'</strong>'.esc_html__('Below settings will affect "Not Found" error notification.', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup15_mapnotifications_autoplay_e',
							'type' => 'switch',
							'title' => esc_html__('Notification Mode', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('If you choose Auto option, You should arrange a time range below.', 'pointfindert2d')
							) ,
							'default' => 1,
							'on' => esc_html__('Auto', 'pointfindert2d') ,
							'off' => esc_html__('Manual', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup15_mapnotifications_autoclosetime_e',
							'required' => array('setup15_mapnotifications_autoplay_e',"=",1),
							'type' => 'spinner',
							'title' => esc_html__('Auto Close Duration', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('1000 milisec = 1 sec.', 'pointfindert2d')
							) ,
							'default' => '5000',
							'min' => '1000',
							'step' => '1000',
							'max' => '20000',
						) ,
						array(
							'id' => 'setup5_mapsettings_notfound',
							'type' => 'text',
							'title' => esc_html__('Not Found Text', 'pointfindert2d') ,
							'default' => esc_html__('We could not find any results.', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'stp_hlp19',
							'type' => 'info',
							'notice' => true,
							'style' => 'info',
							'desc' => '<strong>'.esc_html__('Info:', 'pointfindert2d').'</strong>'.esc_html__('Below settings will affect "Items Found" info notification.', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup15_mapnotifications_dontshow_i',
							'type' => 'switch',
							'title' => esc_html__('On Site Entrance', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('Show/Hide items found notification on site entrance.', 'pointfindert2d')
							) ,
							'default' => '0',
							'on' => esc_html__('Hide', 'pointfindert2d') ,
							'off' => esc_html__('Show', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup15_mapnotifications_autoplay_i',
							'type' => 'switch',
							'title' => esc_html__('Notification Mode', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('If you choose Auto option, You should arrange a time range below.', 'pointfindert2d')
							) ,
							'default' => 1,
							'on' => esc_html__('Auto', 'pointfindert2d') ,
							'off' => esc_html__('Manual', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup15_mapnotifications_autoclosetime_i',
							'required' => array('setup15_mapnotifications_autoplay_i',"=",1) ,
							'type' => 'spinner',
							'title' => esc_html__('Auto Close Duration', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('1000 milisec = 1 sec.', 'pointfindert2d')
							) ,
							'default' => '5000',
							'min' => '1000',
							'step' => '1000',
							'max' => '20000',
						) ,
						array(
							'id' => 'setup15_mapnotifications_foundtext',
							'type' => 'text',
							'title' => esc_html__('Found Item Text', 'pointfindert2d') ,
							'default' => esc_html__('ITEMS FOUND! CLICK FOR LIST', 'pointfindert2d')
						) ,
					)
				);

				/**
				*Map Control Settings
				**/
				$this->sections[] = array(
					'id' => 'setup13_mapcontrols',
					'title' => esc_html__('Map Control Settings', 'pointfindert2d') ,
					'subsection' => true,
					'heading'   => esc_html__('Map Control Buttons', 'pointfindert2d'),
	                'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Below settings will affect map zoom, geolocate, home button controls.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_formapcontrols.png" class="description-img" />'),
					'fields' => array(
						array(
							'id' => 'setup13_mapcontrols_buttonconfig',
							'type' => 'checkbox',
							'title' => esc_html__('Buttons Config', 'pointfindert2d') ,
							'subtitle' => esc_html__('This function will enable/disable buttons on map control.', 'pointfindert2d') ,
							'options' => array(
								'1' => '<i class="el-icon-plus"></i> ' . esc_html__('Enable Zoom In Button', 'pointfindert2d') ,
								'2' => '<i class="el-icon-minus"></i> ' . esc_html__('Enable Map Zoom Out Button', 'pointfindert2d') ,
								'3' => '<i class="el-icon-screenshot"></i> ' . esc_html__('Enable Locate Me Button', 'pointfindert2d') ,
								'4' => '<i class="el-icon-home"></i> ' . esc_html__('Enable Home Button', 'pointfindert2d')
							) ,
							'default' => array(
								'1' => '1',
								'2' => '1',
								'3' => '1',
								'4' => '1'
							)
						) ,
						array(
							'id' => 'dragiconstatus',
							'title' => esc_html__('Map Drag Status', 'pointfindert2d') ,
							'type' => 'button_set',
							'options' => array(
								1 => esc_html__('Locked', 'pointfindert2d'),
								0 => esc_html__('Unlocked', 'pointfindert2d')
							) , 
							'default' => 0
						) ,
						array(
							'id' => 'setup13_mapcontrols_position',
							'title' => esc_html__('Position of Map Buttons', 'pointfindert2d') ,
							'type' => 'button_set',
							'options' => array(
								1 => esc_html__('Left', 'pointfindert2d'),
								0 => esc_html__('Right', 'pointfindert2d')
							) , 
							'default' => 0
						) ,
						array(
							'id' => 'setup13_mapcontrols_position_tooltip',
							'title' => esc_html__('Map Button Tooltips', 'pointfindert2d') ,
							'type' => 'button_set',
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d'),
								0 => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => 1
						) ,
						array(
							'id' => 'setup13_mapcontrols_barbackground',
							'type' => 'color',
							'title' => esc_html__('Button Background', 'pointfindert2d') ,
							'default' => '#28353d',
							'compiler' => array(
								'#pfcontrol > .pfcontrol-header ul li'
							) ,
							'mode' => 'background',
							'validate' => 'color',
							'transparent' => false,
							
						) ,
						array(
							'id' => 'setup13_mapcontrols_barhoverbackground',
							'type' => 'color',
							'title' => esc_html__('Button Hover', 'pointfindert2d') ,
							'default' => '#3c4e5a',
							'compiler' => array(
								'#pfcontrol > .pfcontrol-header ul li:hover'
							) ,
							'mode' => 'background',
							'validate' => 'color',
							'transparent' => false,
							
						) ,
						array(
							'id' => 'setup13_mapcontrols_barhovercolor',
							'type' => 'color',
							'title' => esc_html__('Icon Color', 'pointfindert2d') ,
							'default' => '#ffffff',
							'compiler' => array(
								'#pfcontrol > .pfcontrol-header ul li > i'
							) ,
							'validate' => 'color',
							'transparent' => false,
							
						) ,
					)
				);
				

				/**
				*Search Window
				**/
				$this->sections[] = array(
					'id' => 'setup12_searchwindowpf',
					'title' => esc_html__('Map Search Window', 'pointfindert2d') ,
					'heading'   => esc_html__('Draggable Search Tab Window Settings', 'pointfindert2d'),
	                'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Below settings will affect draggable search tab window on the map.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_formapsearch.png" class="description-img" />'),
	                'subsection' => true,
					'fields' => array(						
						array(
							'id' => 'setup12_searchwindow_buttonconfig1',
							'type' => 'button_set',
							'title' => '<i class="el-icon-move"></i> ' . esc_html__('Drag Window Tab Button', 'pointfindert2d') ,
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d'),
								0 => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => 1,
						) ,
						array(
							'id' => 'setup12_searchwindow_buttonconfig2',
							'type' => 'button_set',
							'title' => '<i class="el-icon-info-sign"></i> ' . esc_html__('Map Info Tab Button', 'pointfindert2d') ,
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d'),
								0 => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => 1,
						) ,
						array(
							'id' => 'setup12_searchwindow_buttonconfig3',
							'type' => 'button_set',
							'title' => '<i class="el-icon-cog"></i> ' . esc_html__('Map Options Tab Button', 'pointfindert2d') ,
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d'),
								0 => esc_html__('Disable', 'pointfindert2d')
							) , 
							'default' => 1,
						) ,
						array(
							'id' => 'setup12_searchwindow_startpositions',
							'type' => 'button_set',
							'title' => esc_html__('Start Position', 'pointfindert2d') ,
							'options' => array(
								1 => esc_html__('Left', 'pointfindert2d'),
								0 => esc_html__('Right', 'pointfindert2d')
							) , 
							'default' => 1
						) ,
						
						array(
							'id' => 'setup12_searchwindow_tooltips',
							'type' => 'button_set',
							'title' => esc_html__('Tooltips', 'pointfindert2d') ,
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d'),
								0 => esc_html__('Disable', 'pointfindert2d')
							) , 
							'hint' => array(
								'content' => esc_html__('Mouseover tooltips.', 'pointfindert2d')
							) ,
							'default' => 1
						) ,
						array(
							'id' => 'setup12_searchwindow_tooltips_text',
							'type' => 'sortable',
							'required' => array('setup12_searchwindow_tooltips','=','1') ,
							'title' => esc_html__('Tooltip Texts', 'pointfindert2d') ,
							'options' => array(
								'si0' => esc_html__('Drag this window.', 'pointfindert2d'),
								'si1' => esc_html__('Search window.', 'pointfindert2d'),
								'si2' => esc_html__('Display map info.', 'pointfindert2d'),
								'si3' => esc_html__('Display map options', 'pointfindert2d')
							) ,
							'default' => array(
								'si0' => esc_html__('Drag this window.', 'pointfindert2d'),
								'si1' => esc_html__('Search window.', 'pointfindert2d'),
								'si2' => esc_html__('Display map info.', 'pointfindert2d'),
								'si3' => esc_html__('Display map options', 'pointfindert2d')
							) ,
							'hint' => array(
								'content' => esc_html__('You can define your custom tip texts.', 'pointfindert2d')
							) ,
						) ,
						array(
							'id' => 'setup12_searchwindow_mapinfotext',
							'type' => 'editor',
							'title' => esc_html__('MapInfo Content', 'pointfindert2d') ,
							'default' => esc_html__('This is map info content.', 'pointfindert2d'),
							'subtitle' => esc_html__('You can edit mapinfo tab content from this editor.', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup12_searchwindow_mapinfotypo',
							'type' => 'typography',
							'title' => esc_html__('MapInfo Typography', 'pointfindert2d') ,
							'google' => true,
							'color' => false,
							'font-backup' => true,
							'compiler' => array(
								'#pfsearch-draggable .pfitemlist-content'
							) ,
							'units' => 'px',
							'default' => array(
								'color' => '#fff',
								'font-weight' => '400',
								'font-family' => 'Roboto',
								'google' => true,
								'font-size' => '12px',
								'line-height' => '16px',
							) ,
						) ,
					) ,
				);


				/**
				*Search Window Styles
				**/
				$this->sections[] = array(
					'id' => 'setup12_searchwindowpf_1',
					'subsection' => true,
					'title' => esc_html__('Map Search Window Styles', 'pointfindert2d') ,
					'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Below settings will affect draggable search window on the map.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_formapsearch.png" class="description-img" />'),
					'fields' => array(
							array(
								'id' => 'setup12_searchwindow_background',
								'type' => 'color_rgba',
								'title' => esc_html__('Content Background', 'pointfindert2d') ,
								'default' => array(
									'color' => '#000000',
									'alpha' => '0.5'
								) ,
								'compiler' => array(
									'#pfsearch-draggable .pfsearch-content',
									'#pfsearch-draggable .pfitemlist-content',
									'#pfsearch-draggable .pfmapopt-content',
									'#pfsearch-draggable .pfuser-content'
								) ,
								'mode' => 'background',
								'validate' => 'colorrgba',
								'transparent' => false,
							) ,
							array(
								'id' => 'setup12_searchwindow_background_mobile',
								'type' => 'color',
								'title' => esc_html__('Content Background for Mobile', 'pointfindert2d') ,
								'default' => '#384b56',
								'mode' => 'background',
								'validate' => 'color',
								'transparent' => false,
							) ,
							array(
								'id' => 'setup12_searchwindow_context',
								'type' => 'color',
								'title' => esc_html__('Content Text Color', 'pointfindert2d') ,
								'default' => '#FFFFFF',
								'compiler' => array(
									'#pfsearch-draggable label',
									'#pfsearch-draggable .slider-input',
									'#pfsearch-draggable .pfdragcontent'
								) ,
								'validate' => 'color',
								'transparent' => false,
								
							) ,
							array(
								'id' => 'setup12_searchwindow_topbarbackground_ex',
								'type' => 'extension_custom_link_color',
								'mode' => 'background',
								'transparent' => false,
								'active' => false,
								'compiler' => array(
									'#pfsearch-draggable > .pfsearch-header ul li',
									'.wpfui-tooltip'
								) ,
								'title' => esc_html__('Top Bar Background', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#28353d',
									'hover' => '#3c4e5a'
								) ,
								'validate' => 'color',
								
									
							) ,
							
							array(
								'id' => 'setup12_searchwindow_topbarhovercolor',
								'type' => 'link_color',
								'title' => esc_html__('Top Bar Icon Color', 'pointfindert2d') ,
								'active' => false,
								'default' => array('regular'=>'#ffffff','hover'=>'#ffffff'),
								'compiler' => array(
									'#pfsearch-draggable > .pfsearch-header ul li > i',
									'.wpfui-tooltip'
								) ,								
							) ,
							array(
								'id' => 'setup12_searchwindow_background_activeline',
								'type' => 'color',
								'title' => esc_html__('Top Bar Button Active Line', 'pointfindert2d') ,
								'default' => '#b00000',
								'mode' => 'background',
								'validate' => 'color'
								) ,
							array(
								'id' => 'setup12_searchwindow_sbuttonbackground1_ex',
								'type' => 'extension_custom_link_color',
								'mode' => 'background',
								'transparent' => false,
								'compiler' => array(
									'#pf-search-button',
									'.pfmaptype-control .pfmaptype-control-ul .pfmaptype-control-li',
									'.pfmaptype-control .pfmaptype-control-layers-ul .pfmaptype-control-layers-li',
									'.anemptystylesheet'
								) ,
								'active' => false,
								'title' => esc_html__('Search Button Color', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#28353d',
									'hover' => '#284862',
								) 
							) ,
							array(
								'id' => 'setup12_searchwindow_sbuttonbackground1_exfont',
								'type' => 'link_color',
								'transparent' => false,
								'compiler' => array(
									'#pf-search-button',
									'.pfmaptype-control .pfmaptype-control-ul .pfmaptype-control-li',
									'.pfmaptype-control .pfmaptype-control-layers-ul .pfmaptype-control-layers-li',
									'.anemptystylesheet'
								) ,
								'active' => false,
								'title' => esc_html__('Search Button Font Color', 'pointfindert2d') ,
								'default' => array(
									'regular' => '#ffffff',
									'hover' => '#FFFFFF',
								) 
							) ,
							
						
					)
				);

				/**
				*Cluster Settings
				**/
				$this->sections[] = array(
					'id' => 'setup6_clustersettings',
					'title' => esc_html__('Cluster Settings', 'pointfindert2d') ,
					'subsection' => true,
	                'desc'      => '<p class="description">'.esc_html__('Cluster feature will put markers into a container and show only number of total marker in this container. You can enable or disable this feature as you want.', 'pointfindert2d').'</p>',
					'fields' => array(
						
						array(
							'id' => 'setup6_clustersettings_status',
							'type' => 'switch',
							'title' => esc_html__('Cluster Feature', 'pointfindert2d') ,
							"default" => '1',
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('Cluster feature must be enabled to see cluster options.', 'pointfindert2d')
							)
						) ,
						array(
							'id' => 'setup6_clustersettings_minsize',
							'required' => array('setup6_clustersettings_status','=','1'),
							'type' => 'spinner',
							'title' => esc_html__('Cluster Size 1', 'pointfindert2d') ,
							"default" => "10",
							"min" => "2",
							"step" => "1",
							"max" => "9999",
							
						) ,
						array(
							'id' => 'setup6_clustersettings_size2',
							'required' => array('setup6_clustersettings_status','=','1'),
							'type' => 'spinner',
							'title' => esc_html__('Cluster Size 2', 'pointfindert2d') ,
							"default" => "20",
							"min" => "11",
							"step" => "1",
							"max" => "9999",
							
						) ,
						array(
							'id' => 'setup6_clustersettings_size3',
							'required' => array('setup6_clustersettings_status','=','1'),
							'type' => 'spinner',
							'title' => esc_html__('Cluster Size 3', 'pointfindert2d') ,
							"default" => "50",
							"min" => "11",
							"step" => "1",
							"max" => "9999",
							
						) ,
						array(
							'id' => 'setup6_clustersettings_size4',
							'required' => array('setup6_clustersettings_status','=','1'),
							'type' => 'spinner',
							'title' => esc_html__('Cluster Size 4', 'pointfindert2d') ,
							"default" => "75",
							"min" => "11",
							"step" => "1",
							"max" => "9999",
							
						) ,
						array(
							'id' => 'setup6_clustersettings_size5',
							'required' => array('setup6_clustersettings_status','=','1'),
							'type' => 'spinner',
							'title' => esc_html__('Cluster Size 5', 'pointfindert2d') ,
							"default" => "100",
							"min" => "11",
							"step" => "1",
							"max" => "9999",
							
						) ,
					)
				);

				/**
				*Geolocation Settings
				**/
				$this->sections[] = array(
					'id' => 'setup7_geolocation',
					'title' => esc_html__('Geolocation Settings', 'pointfindert2d') ,
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'setup7_geolocation_status',
							'type' => 'switch',
							'title' => esc_html__('Geolocation Feature', 'pointfindert2d') ,
							"default" => 0,
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
							'desc' => esc_html__('If this option is enabled, visitors will see geolocation of themselves on site entrance.', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup7_geolocation_move',
							'type' => 'switch',
							'required' => array('setup7_geolocation_status','=','1') ,
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
							'title' => esc_html__('Move Map to User Location', 'pointfindert2d') ,
							"default" => 0,
							'hint' => array(
								'content' => esc_html__('If this option is enabled. Map visible area will move visitor\'s detected location and system will hide markers outside of visitor\'s area. ', 'pointfindert2d') ,
							)
						) ,
						array(
							'id' => 'stp7_geo_newx',
							'type' => 'button_set',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('No Point Action', 'pointfindert2d') ,
							"default" => 0,
							"options" => array(1=>esc_html__('Stay user location', 'pointfindert2d'),0=>esc_html__('Show default location', 'pointfindert2d')),
							'desc' =>esc_html__('What if no point found on user location? (Move map to user location must be enabled)', 'pointfindert2d')
						) ,
						array(
							'id' => 'setup7_geolocation_autofit',
							'type' => 'switch',
							'title' => esc_html__('AutoFit Points After Geolocation', 'pointfindert2d') ,
							'required' => array('setup7_geolocation_status','=','1') ,
							"default" => 0,
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup7_geolocation_distance',
							'type' => 'spinner',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Default Distance', 'pointfindert2d') ,
							"default" => "10",
							"min" => "1",
							"step" => "1",
							"max" => "1000",
							'hint' => array(
								'content' => esc_html__('This is the default geolocation circle radius distance.  Default:10', 'pointfindert2d') ,
							)
						) ,
						array(
							'id' => 'setup7_geolocation_distance_unit',
							'type' => 'button_set',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Distance Unit', 'pointfindert2d') ,
							'options' => array(
								'km' => 'Km',
								'm' => 'Mile'
							) , 
							'default' => 'km',
						) ,
						array(
							'id' => 'setup7_geolocation_hideinfo',
							'type' => 'switch',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Distance Unit Info Popup', 'pointfindert2d') ,
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
							"default" => '1',
						) ,
						array(
							'id' => 'setup7_geolocation_fillcolor',
							'type' => 'color',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Circle Fill Color', 'pointfindert2d') ,
							'transparent' => false,
							'default' => '#008BB2',
							'validate' => 'color',
						) ,
						array(
							'id' => 'setup7_geolocation_fillopacity',
							'type' => 'slider',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Circle Background Opacity', 'pointfindert2d') ,
							'default' => 0.3,
							'min' => 0,
							'step' => .1,
							'max' => 1,
							'resolution' => 0.1,
							'display_value' => 'text'
						) ,
						array(
							'id' => 'setup7_geolocation_strokecolor',
							'type' => 'color',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Circle Border Color', 'pointfindert2d') ,
							'transparent' => false,
							'default' => '#005BB7',
							'validate' => 'color',
							
						) ,
						array(
							'id' => 'setup7_geolocation_strokeopacity',
							'type' => 'slider',
							'required' => array('setup7_geolocation_status','=','1') ,
							'title' => esc_html__('Circle Background Opacity', 'pointfindert2d') ,
							'default' => 0.6,
							'min' => 0,
							'step' => .1,
							'max' => 1,
							'resolution' => 0.1,
							'display_value' => 'text'
						) ,
						array(
							'id' => 'setup7_geolocation_resize_icon',
							'type' => 'media',
							'title' => esc_html__('Circle Resize Icon', 'pointfindert2d') ,
							'required' => array('setup7_geolocation_status','=','1') ,
							'hint' => array(
								'content' => '<strong>'.esc_html__('Optional:', 'pointfindert2d').'</strong>'.esc_html__('Upload a geolocation resize icon. You can find example resize icon in the sources > icons folder.', 'pointfindert2d')
							)
						) ,
						array(
							'id' => 'setup7_geolocation_point_icon',
							'type' => 'media',
							'title' => esc_html__('Geolocation Point Icon', 'pointfindert2d') ,
							'required' => array('setup7_geolocation_status','=','1') ,
							'hint' => array(
								'content' => '<strong>'.esc_html__('Optional:', 'pointfindert2d').'</strong>'.esc_html__('Upload a geolocated point icon. You can find example geo point icon in the sources > icons folder.', 'pointfindert2d')
							)
						) ,
					)
				);
				
			/**
			*End : MAP SETTINS 
			**/
			
			



	
			/**
			*Start : POINT SETTINS 
			**/
				$this->sections[] = array(
					'id' => 'setup8_pointsettings',
					'title' => esc_html__('Point Settings', 'pointfindert2d') ,
					'icon' => 'el-icon-map-marker',
					'fields' => array(
						
						array(
							'id' => 'setup8_pointsettings_retinapoints',
							'type' => 'switch',
							'title' => esc_html__('Retina Point Icons', 'pointfindert2d') ,							
							"default" => 1,
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup8_pointsettings_pointopacity',
							'type' => 'slider',
							'title' => esc_html__('Point Opacity', 'pointfindert2d') ,
							'default' => 0.7,
							'min' => 0,
							'step' => .1,
							'max' => 1,
							'resolution' => 0.1,
							'display_value' => 'text'
						) ,
						array(
							'id' => 'stp_hlp20',
							'type' => 'info',
							'notice' => true,
							'style' => 'info',
							'desc' => '<strong>'.esc_html__('Multiple Point:', 'pointfindert2d').'</strong>'.esc_html__('More than one point in the same place.', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup14_multiplepointsettings_check',
							'type' => 'switch',
							'title' => esc_html__('Multiple Point Feature', 'pointfindert2d') ,							
							"default" => 1,
							'on' => esc_html__('Enable', 'pointfindert2d') ,
							'off' => esc_html__('Disable', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup14_multiplepointsettings_autoplay',
							'required' => array('setup14_multiplepointsettings_check','=','1') ,
							'type' => 'switch',
							'title' => esc_html__('Info Window Autoplay', 'pointfindert2d') ,
							"default" => 1,
						) ,
						array(
							'id' => 'setup14_multiplepointsettings_slidespeed',
							'required' => array('setup14_multiplepointsettings_check','=','1') ,
							'type' => 'spinner',
							'title' => esc_html__('Autoplay: Slide Speed', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('4 sec = 400', 'pointfindert2d')
							) ,
							'default' => '400',
							'min' => '400',
							'step' => '100',
							'max' => '2000',
						) ,
						array(
							'id' => 'setup14_multiplepointsettings_navigation',
							'required' => array('setup14_multiplepointsettings_check','=','1') ,
							'type' => 'switch',
							'title' => esc_html__('Autoplay: Navigation', 'pointfindert2d') ,
							"default" => 1,
							'on' => esc_html__('Auto Hide', 'pointfindert2d') ,
							'off' => esc_html__('Always Show', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup14_multiplepointsettings_navigation_bg',
							'required' => array('setup14_multiplepointsettings_check','=','1') ,
							'type' => 'color_rgba',
							'title' => esc_html__('Navigation: Button Background', 'pointfindert2d') ,
							'default' => array(
								'color' => '#000000',
								'alpha' => '0.5'
							) ,
							'compiler' => array(
								'.wpfinfowindow .pfifnext',
								'.wpfinfowindow .pfifprev'
							) ,
							'mode' => 'background',
							'validate' => 'colorrgba',
							'transparent' => false
						) ,
						array(
							'id' => 'setup14_multiplepointsettings_navigation_text',
							'required' => array('setup14_multiplepointsettings_check','=','1') ,
							'type' => 'color',
							'title' => esc_html__('Navigation: Icon Text', 'pointfindert2d') ,
							'default' => '#ffffff',
							'compiler' => array(
								'.wpfinfowindow .pfifnext',
								'.wpfinfowindow .pfifprev'
							) ,
							'validate' => 'color',
							'transparent' => false
						) ,
					
					)
				);



				/**
				*Info Window Settings
				**/
				$this->sections[] = array(
					'id' => 'setup10_infowindow',
					'title' => esc_html__('Info Window', 'pointfindert2d') ,
					'heading'   => esc_html__('Info Window Settings', 'pointfindert2d'),
					'icon' => 'el-icon-comment',
					'fields' => array(
						array(
							'id' => 'stp_hlp21',
							'type' => 'info',
							'notice' => true,
							'style' => 'info',
							'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Below settings will affect all info windows on the map.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_infowindow.png" class="description-img" />'),
						) ,
						array(
							'id' => 'setup10_infowindow_width',
							'type' => 'spinner',
							'title' => esc_html__('Window Width for Desktop', 'pointfindert2d') ,
							'default' => 350,
							'min' => 196,
							'step' => 1,
							'max' => 600							
						) ,
						array(
							'id' => 'setup10_infowindow_height',
							'type' => 'spinner',
							'title' => esc_html__('Window Height for Desktop', 'pointfindert2d') ,
							'default' => 136,
							'min' => 136,
							'step' => 1,
							'max' => 300
						) ,
						array(
							'id' => 's10_iw_w_m',
							'type' => 'spinner',
							'title' => esc_html__('Window Width for Mobile', 'pointfindert2d') ,
							'default' => 184,
							'min' => 184,
							'step' => 1,
							'max' => 600						
						) ,
						array(
							'id' => 's10_iw_h_m',
							'type' => 'spinner',
							'title' => esc_html__('Window Height for Mobile', 'pointfindert2d') ,
							'default' => 136,
							'min' => 136,
							'step' => 1,
							'max' => 300
						) ,
						array(
							'id' => 'setup10_infowindow_background',
							'type' => 'color_rgba',
							'title' => esc_html__('Background Color', 'pointfindert2d') ,
							'default' => array(
								'color' => '#fffbf5',
								'alpha' => '1.0'
							) ,
							'compiler' => array(
								'.wpfinfowindow',
								'.wpfinfowindow .pfinfoloading'
							) ,
							'transparent' => false,
							'mode' => 'background',
							'validate' => 'colorrgba',
						) ,
						array(
							'id' => 'setup10_infowindow_hide_lt',
							'type' => 'button_set',
							'title' => esc_html__('Listing Type Text', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
						) ,
						array(
							'id' => 'setup10_infowindow_hide_lt_text',
							'required' => array('setup10_infowindow_hide_lt','=','0') ,
							'type' => 'text',
							'title' => esc_html__('Listing Type Text Title', 'pointfindert2d') ,
							'default' => '',
						) ,
						array(
							'id' => 'setup10_infowindow_hide_it',
							'type' => 'button_set',
							'title' => esc_html__('Item Type Text', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
						) ,
						array(
							'id' => 'setup10_infowindow_hide_it_text',
							'required' => array('setup10_infowindow_hide_it','=','0') ,
							'type' => 'text',
							'title' => esc_html__('Item Type Shortname', 'pointfindert2d') ,
							'default' => esc_html__('Type:', 'pointfindert2d'),
						) ,
						array(
							'id' => 'setup10_infowindow_hide_image',
							'type' => 'button_set',
							'title' => esc_html__('Image Area', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
						) ,
						array(
							'id' => 'setup10_infowindow_hide_image-start',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'type' => 'section',
							'indent' => true
						) ,
						array(
							'id' => 'setup10_infowindow_img_width',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'type' => 'slider',
							'title' => esc_html__('Image Width', 'pointfindert2d') ,
							'default' => 154,
							'min' => 154,
							'step' => 1,
							'max' => 200,
							'display_value' => 'text',
							'hint' => array(
								'content' => esc_html__('(px) (Only for desktop site / Not mobile) Default: 154', 'pointfindert2d')
							)
						) ,
						array(
							'id' => 'setup10_infowindow_img_height',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'type' => 'slider',
							'title' => esc_html__('Image Height', 'pointfindert2d') ,
							'default' => 136,
							'min' => 136,
							'step' => 1,
							'max' => 300,
							'display_value' => 'text',
							'hint' => array(
								'content' => esc_html__('(px) (Only for desktop site / Not mobile) Default: 136', 'pointfindert2d')
							)
						) ,
						array(
							'id' => 'setup10_infowindow_hide_ratings',
							'type' => 'button_set',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'title' => esc_html__('Image Review Stars', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
							
						) ,/*
						array(
							'id' => 'sd10_image',
							'type' => 'button_set',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'title' => esc_html__('Disable Images on the Grid List', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'1' => esc_html__('Yes', 'pointfindert2d') ,
								'0' => esc_html__('No', 'pointfindert2d')
							),
						) ,*/
						array(
							'id' => 'setup10_infowindow_hover_image',
							'type' => 'button_set',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'title' => esc_html__('Image Hover Buttons', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
						) ,
						array(
							'id' => 'setup10_infowindow_hover_video',
							'type' => 'button_set',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'title' => esc_html__('Image Video Button', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
						) ,
						array(
							'id' => 'setup10_infowindow_animation_image',
							'type' => 'select',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'title' => esc_html__('Hover Button Styles', 'pointfindert2d') ,
							'options' => array(
								'WhiteRounded' => esc_html__('White Rounded', 'pointfindert2d') ,
								'BlackRounded' => esc_html__('Black Rounded', 'pointfindert2d') ,
								'WhiteSquare' => esc_html__('White Square', 'pointfindert2d') ,
								'BlackSquare' => esc_html__('Black Square', 'pointfindert2d')
							) ,
							'default' => 'WhiteSquare',
						) ,
						array(
							'id' => 'setup10_infowindow_hide_image-end',
							'required' => array('setup10_infowindow_hide_image','=','0') ,
							'type' => 'section',
							'indent' => false
						) ,
						array(
							'id' => 'setup10_infowindow_hide_address',
							'type' => 'button_set',
							'title' => esc_html__('Address Area', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'0' => esc_html__('Show', 'pointfindert2d') ,
								'1' => esc_html__('Hide', 'pointfindert2d')
							),
						) ,
						array(
							'id' => 'setup10_infowindow_row_address',
							'type' => 'button_set',
							'title' => esc_html__('Address Area Row Limit', 'pointfindert2d') ,
							'default' => 1,
							'options' => array(
								'1' => esc_html__('1 Row', 'pointfindert2d'),
								'2' => esc_html__('2 Row', 'pointfindert2d')
							),
							
						) ,
						
					) ,
				);

				/**
				*Info Window Typography
				**/
				$this->sections[] = array(
					'id' => 'setup10_infowindow_1',
					'title' => esc_html__('Info Window Typography', 'pointfindert2d') ,
					'subsection' => true,
					'fields' => array(
							array(
								'id' => 'setup10_infowindow_title_color',
								'type' => 'link_color',
								'title' => esc_html__('Title Area Link Color', 'pointfindert2d') ,
								'compiler' => array(
									'.wpfinfowindow .wpftext > .wpftitle a',
									'.wpfinfowindow .wptitle a',
									'.wpfinfowindow .wpf-closeicon i'
								) ,
								'active' => false,
								'default' => array(
									'regular' => '#333333',
									'hover' => '#b00000'
								)
							) ,
							array(
								'id' => 'setup10_infowindow_title_typo',
								'type' => 'typography',
								'title' => esc_html__('Title Area Typography', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.wpfinfowindow .wpftext > .wpftitle a'
								) ,
								'units' => 'px',
								'color' => false,
								'default' => array(
									'font-weight' => '700',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '15px',
									'line-height' => '18px'
								)
							) ,
							array(
								'id' => 'setup10_infowindow_text_typo',
								'type' => 'typography',
								'title' => esc_html__('Text Area Typography', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.wpfinfowindow .wpftext .wpfdetail'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '400',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '20px',
									'color' => '#3a3a3a'
								)
							) ,
							array(
								'id' => 'setup10_infowindow_text_typo2',
								'type' => 'color',
								'compiler' => array(
									'.wpfdetailtitle'
								) ,
								'transparent' => false,
								'title' => esc_html__('Text Area Title Color', 'pointfindert2d') ,
								'default' => '#3a3a3a',
								'validate' => 'color',
								'hint' => array(
									'content' => esc_html__('Pick a color for text area title. Ex: Beds:', 'pointfindert2d')
								)
							) ,
							array(
								'id' => 'setup10_infowindow_price_typo',
								'type' => 'typography',
								'title' => esc_html__('Price Area Typography', 'pointfindert2d') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.pfinfowindowdlist > .pf-price'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '700',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '16px',
									'line-height' => '19px',
									'color' => '#b00000'
								) ,
							) ,
							array(
								'id' => 'setup10_infowindow_address_typo',
								'type' => 'typography',
								'title' => esc_html__('Address Typography', 'pointfindert2d') ,
								'required' => array('setup10_infowindow_hide_address','=','0') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.wpfinfowindow .wpftext > .wpfaddress'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '700',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '18px',
									'color' => '#3a3a3a'
								) 
							) ,
							array(
								'id' => 'setup10_infowindow_lt_it_typo',
								'type' => 'typography',
								'title' => esc_html__('Listing/Item Type Typography', 'pointfindert2d') ,
								'required' => array('setup10_infowindow_hide_address','=','0') ,
								'google' => true,
								'font-backup' => true,
								'compiler' => array(
									'.wpfinfowindow .wpfdetail .pfliittype'
								) ,
								'units' => 'px',
								'color' => true,
								'default' => array(
									'font-weight' => '700',
									'font-family' => 'Roboto Condensed',
									'google' => true,
									'font-size' => '13px',
									'line-height' => '18px',
									'color' => '#747474'
								) 
							) ,
							array(
								'id' => 'setup10_infowindow_lt_it_typo_a',
								'type' => 'link_color',
								'title' => esc_html__('Listing/Item Type Link Color', 'pointfindert2d') ,
								'compiler' => array(
									'.wpfinfowindow .wpfdetail .pfliittype a'
								) ,
								'active' => false,
								'default' => array(
									'regular' => '#333333',
									'hover' => '#b00000'
								)
							) ,
					) ,
				);
			/**
			*End : POINT SETTINS 
			**/






			/**
			*Start : ITEM PAGE DETAILS SETTINS 
			**/	

				$this->sections[] = array(
					'id' => 'setup42_itempagedetails',
					'title' => esc_html__('Item Detail Page', 'pointfindert2d'),
					'icon' => 'el-icon-file-edit-alt',
					'fields' => array(
							array(
								'id' => 'setup3_modulessetup_headersection',
								'type' => 'button_set',
								'title' => esc_html__('Page Header', 'pointfindert2d') ,
								'options' => array(
									0 => esc_html__('Standart Header', 'pointfindert2d') ,
									1 => esc_html__('Map Header', 'pointfindert2d'),
									2 => esc_html__('No Header', 'pointfindert2d'),
									3 => esc_html__('Image Header', 'pointfindert2d'),
								) ,
								'default' => 2
							) ,
							array(
		                        'id'        => 'setup42_itempagedetails_sidebarpos',
		                        'type'      => 'image_select',
		                        'title'     => esc_html__('Sidebar Position for Item Detail', 'pointfindert2d'),
		                        'options'   => array(
		                            '1' => array('alt' => esc_html__('Left','pointfindert2d'),  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
		                            '2' => array('alt' => esc_html__('Right','pointfindert2d'), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
		                            '3' => array('alt' => esc_html__('Disable','pointfindert2d'), 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
		                        ),
		                        'default'   => '2'
		                    ),
		                    array(
		                        'id'        => 'setup42_itempagedetails_sidebarpos_auth',
		                        'type'      => 'image_select',
		                        'title'     => esc_html__('Sidebar Position for Author/Agent', 'pointfindert2d'),
		                        'options'   => array(
		                            '1' => array('alt' => esc_html__('Left','pointfindert2d'),  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
		                            '2' => array('alt' => esc_html__('Right','pointfindert2d'), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
		                            '3' => array('alt' => esc_html__('Disable','pointfindert2d'), 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
		                        ),
		                        'default'   => '2'
		                    ),
		                    array(
								'id' => 'postd_hideshow',
								'type' => 'button_set',
								'title' => esc_html__('Post Date', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								),
							),
							array(
								'id' => 'viewcount_hideshow',
								'type' => 'button_set',
								'title' => esc_html__('View Count', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								),
							),

		                    array(
								'id' => 'setup3_modulessetup_awfeatures',
								'type' => 'button_set',
								'title' => esc_html__('Features Show Only Available', 'pointfindert2d') ,
								'desc' => esc_html__('If this enabled, Features section will hide unavailable options.', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0'
							) ,
							array(
								'id' => 'setup3_modulessetup_openinghours',
								'type' => 'button_set',
								'title' => esc_html__('Opening Hours Module', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '0'
							) ,
							array(
								'id' => 'setup3_modulessetup_openinghours_ex',
								'type' => 'button_set',
								'title' => esc_html__('Opening Hours Type', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Type 1 (Single Field)', 'pointfindert2d') ,
									'0' => esc_html__('Type 2 (Daily)', 'pointfindert2d'),
									'2' => esc_html__('Type 3 (Daily with Selector)', 'pointfindert2d')
								) ,
								'default' => '1',
								'required' => array('setup3_modulessetup_openinghours','=','1')
							) ,
							array(
								'id' => 'setup3_modulessetup_openinghours_ex2',
								'type' => 'button_set',
								'title' => esc_html__('Opening Hours Start Day', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Monday', 'pointfindert2d') ,
									'0' => esc_html__('Sunday', 'pointfindert2d')
								) ,
								'default' => '1',
								
							) ,
							array(
								'id' => 'setup3_modulessetup_allow_comments',
								'type' => 'button_set',
								'title' => esc_html__('Comments Module', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
		                    array(
								'id' => 'setup42_itempagedetails_share_bar',
								'type' => 'button_set',
								'title' => esc_html__('Share Bar Module', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
							),
							array(
								'id' => 'setup42_itempagedetails_featuredimage',
								'type' => 'button_set',
								'title' => esc_html__('Featured Image on Gallery', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								),
							),
							array(
								'id' => 're_li_1',
								'type' => 'button_set',
								'title' => esc_html__('Related Listings', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								),
							),
							array(
								'id' => 're_li_2',
								'type' => 'button_set',
								'title' => esc_html__('Related Listing Type', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Carousel', 'pointfindert2d') ,
									'0' => esc_html__('Ajax Grid', 'pointfindert2d')
								),
								'required' => array('re_li_1','=','1')
							),
							array(
								'id' => 're_li_3',
								'type' => 'button_set',
								'title' => esc_html__('Related Listing Filters', 'pointfindert2d') ,
								'default' => '1',
								'options' => array(
									'1' => esc_html__('Listing Type Only', 'pointfindert2d') ,
									'2' => esc_html__('Listing Type & Location', 'pointfindert2d')
								),
								'required' => array('re_li_1','=','1')
							),
							array(
								'id' => 're_li_4',
								'type' => 'button_set',
								'title' => esc_html__('Related Listing Agent Filter', 'pointfindert2d') ,
								'default' => '0',
								'options' => array(
									'1' => esc_html__('Enable', 'pointfindert2d') ,
									'0' => esc_html__('Disable', 'pointfindert2d')
								),
								'required' => array('re_li_1','=','1')
							),
							array(
								'id' => 're_li_5',
								'type' => 'spinner',
								'title' => esc_html__('Related Listing Carousel Limit', 'pointfindert2d') ,
								'default' => 20,
								'min'       => 0,
								'step'      => 1,
								'max'       => 100,
								'required' => array(array('re_li_1','=','1'),array('re_li_2','=','1'))
							),
							array(
								'id' => 'setup42_itempagedetails_configuration',
								'type' => 'extension_itempage',
								'title' => esc_html__('Page Section Config', 'pointfindert2d') ,
								'subtitle' => esc_html__('You can reorder positions of sections by using move icon. If want to disable any section please click and select disable.', 'pointfindert2d').'<br/><br/>'.esc_html__('Please check below options to edit Information Tab Content', 'pointfindert2d'),
								'default' => array()
							),
		                
							
							array(
		                        'id'        => 'setup42_itempagedetails_config3',
		                        'type'      => 'extension_custom_sorter',
		                        'title'     => esc_html__('Information Section', 'pointfindert2d'),
		                        'subtitle'      => esc_html__('You can organize Information Section Content by using area.', 'pointfindert2d'),
		                        'options'   => array(
		                            'enabled'   => array(
		                                'description'	=> array('name'=>esc_html__('Description', 'pointfindert2d'),'clstype'=>'pfsingle'),
		                                'details'	=> array('name'=>sprintf('%s & %s',esc_html__('Details', 'pointfindert2d'),esc_html__('Opening Hours', 'pointfindert2d')),'clstype'=>'pfdouble'),
		                            ),
		                            'disabled'  => array(
		                            	'details1'	=> array('name'=>esc_html__("Details", 'pointfindert2d'),'clstype'=>'pfsingle'),
		                                'ohours1'	=> array('name'=>esc_html__("Opening Hours", 'pointfindert2d'),'clstype'=>'pfsingle'),
		                                'ohours3'	=> array('name'=>sprintf('%s & %s',esc_html__("Opening Hours", 'pointfindert2d'),esc_html__("Description", 'pointfindert2d')),'clstype'=>'pfdouble'),
		                                'details2'	=> array('name'=>sprintf('%s & %s',esc_html__("Details", 'pointfindert2d'),esc_html__("Description", 'pointfindert2d')),'clstype'=>'pfdouble'),
		                                'details2x'	=> array('name'=>sprintf('%s & %s',esc_html__("Description", 'pointfindert2d'),esc_html__("Details", 'pointfindert2d')),'clstype'=>'pfdouble'),
		                                'details4'	=> array('name'=>sprintf('%s + %s & %s',esc_html__("Details", 'pointfindert2d'),esc_html__("Opening Hours", 'pointfindert2d'),esc_html__("Description", 'pointfindert2d')),'clstype'=>'pftriple1'),
		                                'details4x'	=> array('name'=>sprintf('%s & %s + %s',esc_html__("Description", 'pointfindert2d'),esc_html__("Details", 'pointfindert2d'),esc_html__("Opening Hours", 'pointfindert2d')),'clstype'=>'pftriple2'),
		                            ),
									
		                        ),
								'required' => array(
									array('setup3_modulessetup_openinghours','=','1')
								)

		                    ),
							array(
		                        'id'        => 'setup42_itempagedetails_config4',
		                        'type'      => 'extension_custom_sorter',
		                        'title'     => esc_html__("Information Section", 'pointfindert2d'),
		                        'subtitle'      => esc_html__("You can organize Information Tab Content by using this section.", 'pointfindert2d'),
		                        'options'   => array(
		                            'enabled'   => array(
		                                'details2'	=> array('name'=>sprintf('%s & %s',esc_html__("Details", 'pointfindert2d'),esc_html__("Description", 'pointfindert2d')),'clstype'=>'pfdouble'),
		                            ),
		                            'disabled'  => array(
		                            	'description'	=> array('name'=>esc_html__("Description", 'pointfindert2d'),'clstype'=>'pfsingle'),
		                            	'details2x'	=> array('name'=>sprintf('%s & %s',esc_html__("Description", 'pointfindert2d'),esc_html__("Details", 'pointfindert2d')),'clstype'=>'pfdouble'),
		                            	'details1'	=> array('name'=>esc_html__("Details", 'pointfindert2d'),'clstype'=>'pfsingle'),
		                            ),
									
		                        ),
		                        'required' => array(
									array('setup3_modulessetup_openinghours','=','0')
								)

		                    ),

							
					)
				);
				
				/**
				*Author Page Settings
				**/
				$this->sections[] = array(
					'id' => 'setup42_itempagedetails_55',
					'subsection' => true,
					'title' => esc_html__('Author Page Settings', 'pointfindert2d'),
					'heading'   => esc_html__('Author/Agent Page Settings ', 'pointfindert2d').esc_html__('Gallery Options', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('Gallery area options and styles.', 'pointfindert2d').'</p>',
					'fields' => array(

							array(
								'id' => 'setup3_modulessetup_authorpageposts',
								'type' => 'button_set',
								'title' => esc_html__('Blog Posts', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								) ,
								'default' => '1'
							) ,
							array(
								'id' => 'setup3_modulessetup_authornrf',
								'type' => 'button_set',
								'title' => esc_html__('Record Not Found Error', 'pointfindert2d') ,
								'options' => array(
									'1' => esc_html__('Show', 'pointfindert2d') ,
									'0' => esc_html__('Hide', 'pointfindert2d')
								) ,
								'default' => '0'
							) 
					)
				);


				/**
				*Gallery Settings
				**/
				$this->sections[] = array(
					'id' => 'setup42_itempagedetails_3',
					'subsection' => true,
					'title' => esc_html__('Gallery Settings', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('Gallery area options and styles.', 'pointfindert2d').'</p>',
					'fields' => array(
								
		                    	array(
									'id' => 'setup42_itempagedetails_gallery_thumbs',
									'type' => 'button_set',
									'title' => esc_html__('Thumbnails', 'pointfindert2d') ,
									'default' => 0,
									'options' => array(
										'1' => esc_html__('Hide', 'pointfindert2d') ,
										'0' => esc_html__('Show', 'pointfindert2d')
									),
									'hint' => array(
										'content' => esc_html__('If you want to hide thumbnails under the gallery photo please change this option.', 'pointfindert2d')
									),
								) ,
								array(
									'id' => 'setup42_itempagedetails_gallery_effect',
									'type' => 'button_set',
									'title' => esc_html__('Image Effect', 'pointfindert2d') ,
									'default' => 'fadeUp',
									'options' => array(
										'fade' => esc_html__('fade', 'pointfindert2d') ,
										'fadeUp' => esc_html__('fadeUp', 'pointfindert2d'),
										'backSlide' => esc_html__('backSlide', 'pointfindert2d'),
										'goDown' => esc_html__('goDown', 'pointfindert2d')
									),
								) ,
								array(
									'id' => 'setup42_itempagedetails_gallery_autoplay',
									'type' => 'button_set',
									'title' => esc_html__('Auto Play for Slide Photos', 'pointfindert2d') ,
									'default' => 0,
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									),
								) ,
								array(
									'id'        => 'setup42_itempagedetails_gallery_interval',
									'type'      => 'spinner',
									'title' => esc_html__('Auto Slider Speed', 'pointfindert2d') ,
									'default'   => 300,
									'min'       => 0,
									'step'      => 100,
									'max'       => 20000,
									'required'	=> array(
										array('setup42_itempagedetails_gallery_autoplay','=','1'),
										
										)
									
								),
								array(
									'id' => 'setup42_itempagedetails_gallery_autoheight',
									'type' => 'button_set',
									'title' => esc_html__('Auto Height for Slide Photos', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									),
								) ,
					) 
				);



				/**
				*Contact Settings
				**/
				$this->sections[] = array(
					'id' => 'setup42_itempagedetails_4',
					'subsection' => true,
					'title' => esc_html__('Contact Settings', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('You can change contact options by using below options.', 'pointfindert2d').'</p>',
					'fields' => array(
						
							array(
		                        'id'        => 'setup42_itempagedetails_contact_status-start',
		                        'type'      => 'section',
		                        'title'     => esc_html__('Extra Options', 'pointfindert2d'),
		                        'indent'    => true, 
		                    ),
		                    	array(
									'id' => 'setup42_itempagedetails_contact_photo',
									'type' => 'button_set',
									'title' => esc_html__('Photo', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,
								array(
									'id' => 'setup42_itempagedetails_contact_moreitems',
									'type' => 'button_set',
									'title' => esc_html__('More Items', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,
								array(
									'id' => 'setup42_itempagedetails_contact_phone',
									'type' => 'button_set',
									'title' => esc_html__('Phone', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,
								array(
									'id' => 'setup42_itempagedetails_contact_mobile',
									'type' => 'button_set',
									'title' => esc_html__('Mobile Phone', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,
								array(
									'id' => 'setup42_itempagedetails_contact_email',
									'type' => 'button_set',
									'title' => esc_html__('Email Address', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,
								array(
									'id' => 'setup42_itempagedetails_contact_url',
									'type' => 'button_set',
									'title' => esc_html__('Web Address', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,
								array(
									'id' => 'setup42_itempagedetails_contact_form',
									'type' => 'button_set',
									'title' => esc_html__('Contact Form', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Show', 'pointfindert2d') ,
										'0' => esc_html__('Hide', 'pointfindert2d')
									)
								) ,

		                    array(
		                        'id'        => 'setup42_itempagedetails_contact_status-end',
		                        'type'      => 'section',
		                        'indent'    => false, 
		                    ),

		                    	
					) 
				);


				/**
				*Report Settings
				**/
				$this->sections[] = array(
					'id' => 'setup42_itempagedetails_report',
					'subsection' => true,
					'title' => esc_html__('Report Item Settings', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('You can change report item setting by using below options. All reports will sent to your main email which defined on PF Mail System. Also you can configure report mail template by using PF Mail System Options Panel.', 'pointfindert2d').'</p>',
					'fields' => array(
								array(
									'id' => 'stp_hlp22',
									'type' => 'info',
									'notice' => true,
									'style' => 'critical',
									'title' => esc_html__('IMPORTANT NOTICE', 'pointfindert2d') ,
									'desc' => esc_html__('It seems like you disabled Share Bar from Item Detail Page > Share Bar section. Please enable this feature first.', 'pointfindert2d'),
									'required' => array('setup42_itempagedetails_share_bar','=','0')
								) ,
		                    	array(
									'id' => 'setup42_itempagedetails_report_status',
									'type' => 'button_set',
									'title' => esc_html__('Status', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									),
									'required' => array('setup42_itempagedetails_share_bar','=','1')
								) ,

								array(
									'id' => 'setup42_itempagedetails_report_regstatus',
									'type' => 'button_set',
									'title' => esc_html__('Registered User', 'pointfindert2d') ,
									'default' => 1,
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									),
									'desc' => esc_html__('If this enabled, only registered users can report an item.', 'pointfindert2d') ,
									'required' => array('setup42_itempagedetails_share_bar','=','1')
								) ,
								
					) 
				);


				/**
				*Claim Settings
				**/
				$this->sections[] = array(
					'id' => 'setup42_itempagedetails_claim',
					'subsection' => true,
					'title' => esc_html__('Claim Item Settings', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('You can change claim item setting by using below options. All reports will sent to your main email which defined on PF Mail System. Also you can configure claim mail template by using PF Mail System Options Panel.', 'pointfindert2d').'</p>',
					'fields' => array(
								array(
									'id' => 'stp_hlp23',
									'type' => 'info',
									'notice' => true,
									'style' => 'critical',
									'title' => esc_html__('IMPORTANT NOTICE', 'pointfindert2d') ,
									'desc' => esc_html__('It seems like you disabled Share Bar from Item Detail Page > Share Bar section. Please enable this feature first.', 'pointfindert2d'),
									'required' => array('setup42_itempagedetails_share_bar','=','0')
								) ,
		                    	array(
									'id' => 'setup42_itempagedetails_claim_status',
									'type' => 'button_set',
									'title' => esc_html__('Status', 'pointfindert2d') ,
									'default' => 0,
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									),
									'required' => array('setup42_itempagedetails_share_bar','=','1')
								) ,

								array(
									'id' => 'setup42_itempagedetails_claim_regstatus',
									'type' => 'button_set',
									'title' => esc_html__('Registered User', 'pointfindert2d') ,
									'default' => 0,
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									),
									'desc' => esc_html__('If this enabled, only registered users can claim an item.', 'pointfindert2d') ,
									'required' => array('setup42_itempagedetails_share_bar','=','1')
								) ,
								array(
									'id' => 'setup42_itempagedetails_claim_validtext',
									'type' => 'text',
									'title' => esc_html__('Valid Badge Text', 'pointfindert2d') ,
									'default' => esc_html__('Listing verified by admin as genuine', 'pointfindert2d'),
									'required' => array('setup42_itempagedetails_share_bar','=','1')
								) ,
								
					) 
				);
				

			/**
			*End : ITEM PAGE DETAILS SETTINS 
			**/




			/**
			*Start : SEARCH RESULTS PAGE SETTINGS
			**/	

				$this->sections[] = array(
					'id' => 'setup42_searchpagemap',
					'title' => esc_html__('Search Results Page', 'pointfindert2d'),
					'heading'   => esc_html__('Search Widget: Results Page', 'pointfindert2d'),
	                'desc'      => '<p class="description">'.esc_html__('Below settings will customize search widget results page.', 'pointfindert2d').'</p>',
					'icon' => 'el-icon-search-alt',
					'fields' => array(
						array(
							'id' => 'setup42_searchpagemap_headeritem',
							'type' => 'button_set',
							'title' => esc_html__('Header of Page', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								1 => esc_html__('MAP HEADER', 'pointfindert2d') ,
								0 => esc_html__('DEFAULT HEADER', 'pointfindert2d')
							)
						) ,
						array(
							'id' => 'setup42_searchpagemap_lat',
							'type' => 'text',
							'title' => esc_html__('Default Latitude', 'pointfindert2d') ,
							'desc' => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>') ,
							'default' => '40.712784',
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_lng',
							'type' => 'text',
							'title' => esc_html__('Default Longitude', 'pointfindert2d') ,
							'desc' => sprintf(esc_html__('This coordinate for auto center on that point. %s Please click here for finding your coordinates', 'pointfindert2d'),'<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">','</a>') ,
							'default' => '-74.005941',
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_height',
							'type' => 'dimensions',
							'units' => 'px',
							'units_extended' => 'false',
							'width' => 'false',
							'title' => esc_html__('Map Area Height', 'pointfindert2d') ,
							'default' => array('height' => 550),
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_zoom',
							'type' => 'spinner',
							'title' => esc_html__('Desktop View Zoom', 'pointfindert2d') ,
							"default" => "12",
							"min" => "6",
							"step" => "1",
							"max" => "18",
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_mobile',
							'type' => 'spinner',
							'title' => esc_html__('Mobile View Zoom', 'pointfindert2d') ,
							"default" => "10",
							"min" => "6",
							"step" => "1",
							"max" => "18",
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_autofitsearch',
							'type' => 'button_set',
							'title' => esc_html__('AutoFit Points After Search', 'pointfindert2d') ,
							"default" => 1,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							),
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_type',
							'title' => esc_html__('Map Type', 'pointfindert2d') ,
							'type' => 'button_set',
							'options' => array(
								'ROADMAP' => esc_html__('ROADMAP', 'pointfindert2d') ,
								'SATELLITE' => esc_html__('SATELLITE', 'pointfindert2d') ,
								'HYBRID' => esc_html__('HYBRID', 'pointfindert2d') ,
								'TERRAIN' => esc_html__('TERRAIN', 'pointfindert2d')
							) ,
							'default' => 'ROADMAP',
							'required' => array('setup42_searchpagemap_headeritem','=','1')
							
						) ,
						array(
							'id' => 'setup42_searchpagemap_business',
							'type' => 'button_set',
							'title' => esc_html__('Business Points', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							),
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_streetViewControl',
							'type' => 'button_set',
							'title' => esc_html__('Street View Control', 'pointfindert2d') ,
							"default" => '1',
							'options' => array(
								'1' => esc_html__('Enable', 'pointfindert2d') ,
								'0' => esc_html__('Disable', 'pointfindert2d')
							),
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_style',
							'type' => 'textarea',
							'title' => esc_html__('Map Style', 'pointfindert2d') ,
							'hint' => array(
								'content' => esc_html__('You can copy and paste style codes here. Please check help documentation for this area.', 'pointfindert2d') ,
							),
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'stp_hlp24',
							'type' => 'info',
							'notice' => true,
							'style' => 'info',
							'required' => array('setup42_searchpagemap_headeritem','=','1'),
							'desc' => esc_html__('Below settings will affect Visible Area AJAX Load config for map points.', 'pointfindert2d') ,
						) ,
						array(
							'id' => 'setup42_searchpagemap_ajax',
							'type' => 'button_set',
							'title' => esc_html__('Visible Area AJAX Load', 'pointfindert2d') ,
							'desc' => esc_html__('If this option is enabled; Map will start to load points in visible area. Enable option is recrommended if there are too much points. Ex: If you have 10.000 points and do not want to load all of them at the same time, you can enable this option.', 'pointfindert2d') ,
							"default" => 0,
							'options' => array(
								1 => esc_html__('Enable', 'pointfindert2d') ,
								0 => esc_html__('Disable', 'pointfindert2d')
							),
							'required' => array('setup42_searchpagemap_headeritem','=','1')
						) ,
						array(
							'id' => 'setup42_searchpagemap_ajax-start',
							'type' => 'section',
							'required' => array(array('setup42_searchpagemap_ajax','=','1'),array('setup42_searchpagemap_headeritem','=','1')) ,
							'indent' => true
						) ,
						array(
							'id' => 'setup42_searchpagemap_ajax_drag',
							'type' => 'switch',
							'required' => array(array('setup42_searchpagemap_ajax','=','1'),array('setup42_searchpagemap_headeritem','=','1')) ,
							'title' => esc_html__('Drag Load', 'pointfindert2d') ,
							'desc' => esc_html__('Loading after drag end.', 'pointfindert2d') ,
							"default" => 0
						) ,
						array(
							'id' => 'setup42_searchpagemap_ajax_zoom',
							'type' => 'switch',
							'required' => array(array('setup42_searchpagemap_ajax','=','1'),array('setup42_searchpagemap_headeritem','=','1')) ,
							'title' => esc_html__('Zoom Load', 'pointfindert2d') ,
							'desc' => esc_html__('Loading after zoom up.', 'pointfindert2d') ,
							"default" => 0
						) ,
						array(
							'id' => 'setup42_searchpagemap_ajax-end',
							'type' => 'section',
							'required' => array(array('setup42_searchpagemap_ajax','=','1'),array('setup42_searchpagemap_headeritem','=','1')) ,
							'indent' => false
						) ,

					)
				);

			/**
			*End : SEARCH RESULTS PAGE SETTINGS
			**/	
		}

		public function setArguments(){
			$this->args = array(
				'opt_name'             => 'pointfindertheme_options',
				'global_variable' 	   => 'pointfindertheme_option',
                'display_name'         => esc_html__('Point Finder Options Panel','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Options Panel','pointfindert2d'),
                'page_title'           => esc_html__('Point Finder Options Panel', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-admin-tools',
                'page_slug'            => '_pointfinderoptions',
                'save_defaults'        => true,
                'default_show'         => false,
                'default_mark'         => '',
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                'output_tag'           => false,
                'database'             => '',
                'system_info'          => false,
                'domain'               => 'redux-framework',
                'hide_reset'           => true,
                'update_notice'        => false,
                'google_api_key' 	   => "AIzaSyBhuxzrgSLeZn6jvnRU3bSuVgxuMbwqWF0",
                'google_update_weekly' => true,
                'async_typography' 	   => true,
                'compiler' 			   => true,
			);
			$this->args['global_variable'] = 'pointfindertheme_option';

			$this->args['share_icons'][] = array(
				'url' => 'https://github.com/webbudesign',
				'title' => 'Visit us on GitHub',
				'icon' => 'el-icon-github'

			);
			$this->args['share_icons'][] = array(
				'url' => 'https://www.facebook.com/Webbudesign',
				'title' => 'Like us on Facebook',
				'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
				'url' => 'http://twitter.com/WebbuDesign',
				'title' => 'Follow us on Twitter',
				'icon' => 'el-icon-twitter'
			);


			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				}
				else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
			}
			
		}


	}
	global $pointfinder_main_options_fw;
 	$pointfinder_main_options_fw = new Redux_Framework_PF_Theme_Config();
}
