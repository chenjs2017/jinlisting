<?php
/**********************************************************************************************************************************
*
* Size Control Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_AScontrol_Config")) {
	

    class Redux_Framework_PF_AScontrol_Config{

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( !class_exists("ReduxFramework" ) ) {return;}
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {$this->initSettings();} else {add_action('plugins_loaded', array($this, 'initSettings'), 10);}
        }

        public function initSettings() {
            $this->setArguments(); 
            $this->setSections();
            if (!isset($this->args['opt_name'])) { return;}
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }


        public function setSections() {   
             
			$pf_sidebar_options = array(
                '1' => array('alt' => esc_html__('Left','pointfindert2d'),  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                '2' => array('alt' => esc_html__('Right','pointfindert2d'), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                '3' => array('alt' => esc_html__('Disable','pointfindert2d'), 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
            );

            /**
            *Start : General
            **/
                $this->sections[] = array(
                    'id' => 'sys_redirect',
                    'icon' => 'el-icon-cogs',
                    'title' => esc_html__('General', 'pointfindert2d'),
                    'fields' => array(
                            array(
                                'id' => 'as_redirect_logins',
                                'type' => 'button_set',
                                'title' => esc_html__('Redirect Login Attemps', 'pointfindert2d') ,
                                'desc' => esc_html__('If this setting enabled, all login attemps redirect to Point Finder Login System.', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d'),
                                ) ,
                                'default' => '0',
                            ) ,

                            array(
                                'id' => 'as_autologin',
                                'type' => 'button_set',
                                'title' => esc_html__('Auto Login After Registration', 'pointfindert2d') ,
                                'desc' => esc_html__('If this setting enabled, all users auto login after registration without email confirmation', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d'),
                                ) ,
                                'default' => '0',
                            ) ,

                            array(
                                'id' => 'as_topline_status',
                                'type' => 'button_set',
                                'title' => esc_html__('Topline Status', 'pointfindert2d') ,
                                'desc' => esc_html__('If this setting disabled, top line will be hidden.', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d'),
                                ) ,
                                'default' => '1',
                            ) ,

                            array(
                                'id' => 'as_mobile_dropdowns',
                                'type' => 'button_set',
                                'title' => esc_html__('Mobile Dropdowns', 'pointfindert2d') ,
                                'desc' => esc_html__('If this setting enabled, system will use mobile friendly dropdowns.', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d'),
                                ) ,
                                'default' => '1',
                            ) ,

                            array(
                                'id' => 'as_mobile_zoom',
                                'type' => 'button_set',
                                'title' => esc_html__('Mobile Zoom Limit', 'pointfindert2d') ,
                                'desc' => esc_html__('If this setting enabled, system will limit screen zoom. (Recommended for click zoom problem for slect boxes.)', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d'),
                                ) ,
                                'default' => '1',
                            ) ,


                            array(
                                'id' => 'as_hormode_close',
                                'type' => 'button_set',
                                'title' => esc_html__('Map Search: Horizontal Mode Close', 'pointfindert2d') ,
                                'desc' => esc_html__('If this setting enabled, horizontal map search window will be closed at start.', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d'),
                                ) ,
                                'default' => '0',
                            ) ,

                            array(
                                'id'        => 'as_tags_cloud',
                                'type'      => 'spinner',
                                'title'     => esc_html__('Tags Cloud Limit', 'pointfindert2d'),
                                'desc'      => esc_html__('Limit for tags cloud widget.', 'pointfindert2d'),
                                'default'   => '45',
                                'min'       => '2',
                                'step'      => '1',
                                'max'       => '100'
                            ),
                            array(
                                'id'        => 'as_anonymous_id',
                                'type'      => 'text',
                                'title'     => esc_html__('匿名用户User ID', 'pointfindert2d'),
                                'desc'      => esc_html__('匿名用户User ID', 'pointfindert2d')
                            ),

														array(
                                'id'        => 'as_search_distance',
                                'type'      => 'spinner',
                                'title'     => esc_html__('显示商家范围', 'pointfindert2d'),
                                'desc'      => esc_html__('显示商家范围.', 'pointfindert2d'),
                                'default'   => '1',
                                'min'       => '1',
                                'step'      => '1',
                                'max'       => '10'
                            ),
                        )

                );
            /**
            *End : General
            **/



            /**
            *Start : Global Footer
            **/
                $this->sections[] = array(
                    'id' => 'setup_gbf',
                    'title' => esc_html__('Global Footer', 'pointfindert2d'),
                    'icon' => 'el-icon-download-alt',
                    'fields' => array(
                        array(
                            'id' => 'gbf_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Global Footer', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d'),
                            ) ,
                            'default' => 0,
                        ),
                        array(
                            'id' => 'gbf_cols',
                            'type' => 'button_set',
                            'title' => esc_html__('Column Number', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('1', 'pointfindert2d') ,
                                '2' => esc_html__('2', 'pointfindert2d'),
                                '3' => esc_html__('3', 'pointfindert2d'),
                                '4' => esc_html__('4', 'pointfindert2d'),
                            ) ,
                            'default' => 4,
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'       => 'gbf_sidebar1',
                            'type'     => 'select',
                            'title'    => esc_html__('1st Column Widget Area', 'pointfindert2d'),
                            'data'     => 'sidebars',
                            'default'  => '',
                            'required' => array(array( 'gbf_cols', '>=', 1 ),array('gbf_status','=',1))
                        ),
                        array(
                            'id'       => 'gbf_sidebar2',
                            'type'     => 'select',
                            'title'    => esc_html__('2nd Column Widget Area', 'pointfindert2d'),
                            'data'     => 'sidebars',
                            'default'  => '',
                            'required' => array(array( 'gbf_cols', '>=', 2 ),array('gbf_status','=',1))
                        ),
                        array(
                            'id'       => 'gbf_sidebar3',
                            'type'     => 'select',
                            'title'    => esc_html__('3rd Column Widget Area', 'pointfindert2d'),
                            'data'     => 'sidebars',
                            'default'  => '',
                            'required' => array(array( 'gbf_cols', '>=', 3 ),array('gbf_status','=',1))
                        ),
                        array(
                            'id'       => 'gbf_sidebar4',
                            'type'     => 'select',
                            'title'    => esc_html__('4th Column Widget Area', 'pointfindert2d'),
                            'data'     => 'sidebars',
                            'default'  => '',
                            'required' => array(array( 'gbf_cols', '>=', 4 ),array('gbf_status','=',1))
                        ),
                        array(
                            'id'       => 'gbf_bgopt2',
                            'type'     => 'background',
                            'output'   => array( '.wpf-footer-row-move:before' ),
                            'title'    => esc_html__('Background (Before Row)', 'pointfindert2d'),
                            'default'   => '#FFFFFF',
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'             => 'gbf_bgopt2w',
                            'type'           => 'dimensions',
                            'units'          => array( 'em', 'px', '%' ),
                            'units_extended' => 'true',
                            'output'   => array( '.wpf-footer-row-move:before' ),
                            'title'          => esc_html__('Background (Before Row) Height', 'pointfindert2d'),
                            'width'         => false,
                            'default'        => array(
                                'height' => 0,
                            ),
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'             => 'gbf_bgopt2m',
                            'type'           => 'spacing',
                            'mode'           => 'margin',
                            'output'   => array( '.wpf-footer-row-move:before' ),
                            'all'            => false,
                            'left'            => false,
                            'right'            => false,
                            'units'          => array( 'em', 'px', '%' ),
                            'units_extended' => 'true',
                            'title'          => esc_html__( 'Margin (Before Row)', 'pointfindert2d' ),
                            'default'        => array(
                                'margin-top'    => '0',
                                'margin-bottom' => '0'
                            ),
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'       => 'gbf_bgopt',
                            'type'     => 'background',
                            'output'   => array( '.pointfinderexfooterclassxgb' ),
                            'title'    => esc_html__('Background', 'pointfindert2d'),
                            'default'   => '#FFFFFF',
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'        => 'gbf_textcolor1',
                            'type'      => 'color',
                            'output'   => array( '.pointfinderexfooterclassgb'),
                            'title'     => esc_html__('Text Color', 'pointfindert2d'),
                            'default' => '#000000',
                            'transparent'   => false,
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'        => 'gbf_textcolor2',
                            'type'      => 'link_color',
                            'output'   => array('.pointfinderexfooterclassgb a' ),
                            'title'     => esc_html__('Link Color', 'pointfindert2d'),
                            'active' => false,
                            'default' => array(
                                'regular' => '#000000',
                                'hover' => '#B32E2E'
                            ),
                            'transparent'   => false,
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'             => 'gbf_spacing',
                            'type'           => 'spacing',
                            'mode'           => 'padding',
                            'output'   => array( '.pointfinderexfooterclassgb' ),
                            'all'            => false,
                            'units'          => array( 'em', 'px', '%' ),
                            'units_extended' => 'true',
                            'left'            => false,
                            'right'            => false,
                            'title'          => esc_html__( 'Padding', 'pointfindert2d' ),
                            'default'        => array(
                                'padding-top'    => '50px',
                                'padding-bottom' => '50px'
                            ),
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'             => 'gbf_spacing2',
                            'type'           => 'spacing',
                            'mode'           => 'margin',
                            'output'   => array( '.pointfinderexfooterclassxgb' ),
                            'all'            => false,
                            'left'            => false,
                            'right'            => false,
                            'units'          => array( 'em', 'px', '%' ),
                            'units_extended' => 'true',
                            'title'          => esc_html__( 'Margin', 'pointfindert2d' ),
                            'default'        => array(
                                'margin-top'    => '0',
                                'margin-bottom' => '0'
                            ),
                            'required' => array('gbf_status','=',1)
                        ),
                        array(
                            'id'       => 'gbf_border',
                            'type'     => 'border',
                            'title'    => esc_html__( 'Border', 'pointfindert2d' ),
                            'output'   => array( '.pointfinderexfooterclassxgb' ),
                            'all'      => false,
                            'left'            => false,
                            'right'            => false,
                            'default'  => array(
                                'border-color'  => 'transparent',
                                'border-style'  => 'solid',
                                'border-top'    => '0',
                                'border-right'  => '0',
                                'border-bottom' => '0',
                                'border-left'   => '0'
                            ),
                            'required' => array('gbf_status','=',1)
                        ),
                        
                    
                    )
                );
            /**
            *End : Global Footer
            **/



            /**
            *Start : SOCIAL LOGIN SETTINGS
            **/
                $this->sections[] = array(
                    'id' => 'setup40_sociallogins',
                    'icon' => 'el-icon-key',
                    'title' => esc_html__('Social Login Settings', 'pointfindert2d'),
                    'fields' => array(
                            array(
                                'id'        => 'setup40_sociallogins_info1',
                                'type'      => 'info',
                                'notice'    => true,
                                'style'     => 'info',
                                'desc'      => esc_html__('This section required User Login System activation. Please activate from Frontend Settings.', 'pointfindert2d'),
                            ),
                            array(
                                'id' => 'setup4_membersettings_requestupdateinfo',
                                'type' => 'button_set',
                                'title' => esc_html__('Redirection Page', 'pointfindert2d') ,
                                'desc' => esc_html__('Where do you want to redirect user after login with a social system?', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('User Profile Page', 'pointfindert2d') ,
                                    '2' => esc_html__('User Itemlist Page', 'pointfindert2d'),
                                    '3' => esc_html__('Home Page', 'pointfindert2d')
                                ) ,
                                'default' => '1',
                            ) ,
                            array(
                                'id' => 'setup4_membersettings_facebooklogin',
                                'type' => 'button_set',
                                'title' => esc_html__('Facebook Login', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d')
                                ) ,
                                'default' => '0',
                            ) ,
                            array(
                                'id'        => 'setup4_membersettings_facebooklogin_appid',
                                'type'      => 'text',
                                'title'     => esc_html__('Facebook Login: APP ID', 'pointfindert2d'),
                                'hint'      => array('content' =>esc_html__('Please check help documentation for instruction.', 'pointfindert2d')),
                                'default'   => '',
                                'required' => array(
                                    array('setup4_membersettings_facebooklogin','=','1'),
                                )
                            ),
                            array(
                                'id'        => 'setup4_membersettings_facebooklogin_secretid',
                                'type'      => 'text',
                                'title'     => esc_html__('Facebook Login: Secret ID', 'pointfindert2d'),
                                'hint'      => array('content' =>esc_html__('Please check help documentation for instruction.', 'pointfindert2d')),
                                'default'   => '',
                                'required' => array(
                                    array('setup4_membersettings_facebooklogin','=','1'),
                                )
                            ),


                            array(
                                'id' => 'setup4_membersettings_twitterlogin',
                                'type' => 'button_set',
                                'title' => esc_html__('Twitter Login', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d')
                                ) ,
                                'default' => '0',
                            ) ,

                            array(
                                'id'        => 'setup4_membersettings_twitterlogin_appid',
                                'type'      => 'text',
                                'title'     => esc_html__('Twitter Login: Key', 'pointfindert2d'),
                                'hint'      => array('content' =>esc_html__('Please check help documentation for instruction.', 'pointfindert2d')),
                                'default'   => '',
                                'required' => array(
                                    array('setup4_membersettings_twitterlogin','=','1'),
                                )
                            ),
                            array(
                                'id'        => 'setup4_membersettings_twitterlogin_secretid',
                                'type'      => 'text',
                                'title'     => esc_html__('Twitter Login: Secret Key', 'pointfindert2d'),
                                'hint'      => array('content' =>esc_html__('Please check help documentation for instruction.', 'pointfindert2d')),
                                'default'   => '',
                                'required' => array(
                                    array('setup4_membersettings_twitterlogin','=','1'),
                                )
                            ),




                            array(
                                'id' => 'setup4_membersettings_googlelogin',
                                'type' => 'button_set',
                                'title' => esc_html__('Google + Login', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Enable', 'pointfindert2d') ,
                                    '0' => esc_html__('Disable', 'pointfindert2d')
                                ) ,
                                'default' => '0',
                            ) ,

                            array(
                                'id'        => 'setup4_membersettings_googlelogin_clientid',
                                'type'      => 'text',
                                'title'     => esc_html__('Google + Login: Clien ID', 'pointfindert2d'),
                                'hint'      => array('content' =>esc_html__('Please check help documentation for instruction.', 'pointfindert2d')),
                                'default'   => '',
                                'required' => array(
                                    array('setup4_membersettings_googlelogin','=','1'),
                                )
                            ),
                            array(
                                'id'        => 'setup4_membersettings_googlelogin_secretid',
                                'type'      => 'text',
                                'title'     => esc_html__('Google + Login: Client Secret', 'pointfindert2d'),
                                'hint'      => array('content' =>esc_html__('Please check help documentation for instruction.', 'pointfindert2d')),
                                'default'   => '',
                                'required' => array(
                                    array('setup4_membersettings_googlelogin','=','1'),
                                )
                            ),


                        )

                );
            /**
            *End : SOCIAL LOGIN SETTINGS
            **/


            /**
            *Start : PAGE SIDEBAR SETTINGS
            **/
                $this->sections[] = array(
                        'id' => 'setup_item_pagessidebars',
                        'title' => esc_html__('Inner Page Sidebars', 'pointfindert2d'),
                        'icon' => 'el-icon-indent-right',
                        'fields' => array(
                            array(
                                'id'        => 'setup_item_blogpage_sidebarpos',
                                'type'  => 'image_select',
                                'title'     => esc_html__('Sidebar Position : Single Blog Page', 'pointfindert2d'),
                                'subtitle' => esc_html__('This settings only cover single blog page.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > PF Blog Sidebar', 'pointfindert2d'),
                                'options'   => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                            array(
                                'id'        => 'setup_item_blogcatpage_sidebarpos',
                                'type'  => 'image_select',
                                'title'     => esc_html__('Sidebar Position : Blog Category Page', 'pointfindert2d'),
                                'subtitle' => esc_html__('This settings only cover blog category page.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > PF Blog Category Sidebar', 'pointfindert2d'),
                                'options'   => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                            array(
                                'id'        => 'setup_item_catpage_sidebarpos',
                                'type'  => 'image_select',
                                'title'     => esc_html__('Sidebar Position : Item Category Page', 'pointfindert2d'),
                                'subtitle' => esc_html__('This settings will help you to change item category listing page settings.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > PF Category Sidebar', 'pointfindert2d'),
                                'options'   => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                            array(
                                'id' => 'setup_item_searchresults_sidebarpos',
                                'type'  => 'image_select',
                                'title' => esc_html__('Sidebar Position : Item Search Result Page', 'pointfindert2d'),
                                'subtitle' => esc_html__('This settings will help you to change item search results listing page settings.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > PF Search Results Sidebar', 'pointfindert2d'),
                                'options' => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                            array(
                                'id' => 'setupbbpress_general_sidebarpos',
                                'type'  => 'image_select',
                                'title' => esc_html__('Sidebar Position : bbPress Inner Page', 'pointfindert2d'),
                                'subtitle' => esc_html__('If you are using bbPress forums, below settings will help you to change inner page settings.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > bbPress Inner Widget', 'pointfindert2d'),
                                'options' => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                            array(
                                'id' => 'setup_item_idx_sidebarpos',
                                'type'  => 'image_select',
                                'title' => esc_html__('Sidebar Position : dsIDX Page', 'pointfindert2d'),
                                'subtitle' => esc_html__('This settings only cover dsIDX page.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > PF dsidxpress Sidebar', 'pointfindert2d'),
                                'options' => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                            array(
                                'id' => 'setup_item_woocom_sidebarpos',
                                'type'  => 'image_select',
                                'title' => esc_html__('Sidebar Position : Woocommerce Pages', 'pointfindert2d'),
                                'subtitle' => esc_html__('This settings only cover WooCommerce pages.', 'pointfindert2d'),
                                'desc' => esc_html__('Please edit widgets on Appearance > Widgets > PF WooCommerce Sidebar', 'pointfindert2d'),
                                'options' => $pf_sidebar_options,
                                'default'   => '2'
                            ),
                        
                        )
                    );
            /**
            *End : PAGE SIDEBAR SETTINGS
            **/


            /**
            *Start : Auto Update
            **/
                $this->sections[] = array(
                    'id' => 'setup_autoupdate',
                    'title' => esc_html__('Auto Theme Update', 'pointfindert2d'),
                    'icon' => 'el-icon-cog-alt',
                    'fields' => array(
                        array(
                            'id'    => 'setup_autoupdate_info',
                            'type'  => 'info',
                            'style' => 'info',
                            'title' => __( 'Auto Update System', 'pointfindert2d' ),
                            'desc'  => __( 'You can get auto updates for Point Finder from Envato. if below fields filled correctly.', 'pointfindert2d' )
                        ),
                        array(
                            'id' => 'setup_autoupdate_username',
                            'type' => 'text',
                            'title' => esc_html__('Envato Username', 'pointfindert2d') ,
                            'desc' => esc_html__('Please write your username which you already using in Envato (Themeforest)', 'pointfindert2d')
                        ) ,
                        array(
                            'id' => 'setup_autoupdate_apikey',
                            'type' => 'text',
                            'title' => esc_html__('Envato API Key', 'pointfindert2d') ,
                            'desc' => sprintf(esc_html__("Please write your Envato Api Key. If don't know how to get it please %s click here.%s", 'pointfindert2d'),"<a href='http://www.webbudesign.com/envato/apikeyget.png' target='_blank'>","</a>")
                        ) ,
                    
                    )
                );
            /**
            *End : Auto Update
            **/



            /**
            *Start : Invoice Settings
            **/
                $this->sections[] = array(
                    'id' => 'setup_invoices',
                    'title' => esc_html__('Invoice Settings', 'pointfindert2d'),
                    'icon' => 'el-icon-file-edit-alt',
                    'fields' => array(
                        array(
                            'id' => 'setup_invoices_sh',
                            'type' => 'button_set',
                            'title' => esc_html__('Invoices in Menu', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Show', 'pointfindert2d') ,
                                '0' => esc_html__('Hide', 'pointfindert2d')
                            ) ,
                            'default' => 1
                            
                        ) ,

                        array(
                            'id'    => 'setup_invoices_info',
                            'type'  => 'info',
                            'style' => 'info',
                            'title' => __( 'Invoice System', 'pointfindert2d' ),
                            'desc'  => __( 'You can set an invoice prefix and change some settings by using below options.', 'pointfindert2d' )
                        ),
                        array(
                            'id' => 'setup_invoices_prefix',
                            'type' => 'text',
                            'title' => esc_html__('Invoice Prefix', 'pointfindert2d') ,
                            'desc' => esc_html__('Ex: PFI for PFI121318', 'pointfindert2d'),
                            'default' => 'PFI'
                        ),
                        
                        array(
                            'id' => 'setup_invoices_vatnum',
                            'type' => 'text',
                            'title' => esc_html__('Your VAT Number', 'pointfindert2d')
                        ),
                        array(
                            'id' => 'setup_invoices_usertit',
                            'type' => 'text',
                            'title' => esc_html__('Invoice Title', 'pointfindert2d'),
                            'desc' => esc_html__('Company name or full name.', 'pointfindert2d'),
                        ),
                        array(
                            'id' => 'setup_invoices_usercountry',
                            'type' => 'text',
                            'title' => esc_html__('Invoice Country', 'pointfindert2d'),
                            'desc' => esc_html__('Your country name', 'pointfindert2d'),
                        ),
                        array(
                            'id' => 'setup_invoices_address',
                            'type' => 'textarea',
                            'title' => esc_html__('Invoice Address', 'pointfindert2d'),
                            'desc' => esc_html__('Your full address', 'pointfindert2d'),
                        ),
                        
                    

                /**
                *Start: Invoice Template Settings
                **/
                        array(
                            'id'        => 'setup_invoices_sitename',
                            'type'      => 'text',
                            'title'     => esc_html__('Site Name', 'pointfindert2d'),
                            'default'   => '',
                            'hint' => array(
                                'content'   => esc_html__('Please write site name for invoice header.','pointfindert2d')
                            )
                        ),
                        array(
                            'id' => 'setup_inv_temp_rtl',
                            'type' => 'button_set',
                            'title' => esc_html__('Text Direction', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Show Right to Left', 'pointfindert2d') ,
                                '0' => esc_html__('Show Left to Right', 'pointfindert2d')
                            ) ,
                            'default' => '0'
                            
                        ) ,

                        array(
                            'id' => 'setup_inv_temp_logo',
                            'type' => 'button_set',
                            'title' => esc_html__('Template Logo', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Show Logo', 'pointfindert2d') ,
                                '0' => esc_html__('Show Text', 'pointfindert2d')
                            ) ,
                            'default' => '1'
                            
                        ) ,

                        array(
                            'id'        => 'setup_inv_temp_logotext',
                            'type'      => 'text',
                            'title'     => esc_html__('Logo Text', 'pointfindert2d'),
                            'required'   => array('setup_inv_temp_logo','=','0'),
                            'text_hint' => array(
                                'title'     => '',
                                'content'   => esc_html__('Please type your logo text. Ex: Pointfinder','pointfindert2d')
                            )
                        ),

                        array(
                            'id'        => 'setup_inv_temp_mainbgcolor',
                            'type'      => 'color',
                            'title'     => esc_html__('Main Background Color', 'pointfindert2d'),
                            'default'   => '#F0F1F3',
                            'validate'  => 'color',
                            'transparent'   => false
                        ),

                        array(
                            'id'        => 'setup_inv_temp_headerfooter',
                            'type'      => 'color',
                            'title'     => esc_html__('Header / Footer: Background Color', 'pointfindert2d'),
                            'default'   => '#f7f7f7',
                            'validate'  => 'color',
                             'transparent'  => false
                        ),

                        array(
                            'id'        => 'setup_inv_temp_headerfooter_line',
                            'type'      => 'color',
                            'title'     => esc_html__('Header / Footer: Line Color', 'pointfindert2d'),
                            'default'   => '#F25555',
                            'validate'  => 'color',
                             'transparent'  => false
                        ),

                        
                        array(
                            'id'        => 'setup_inv_temp_headerfooter_text',
                            'type'      => 'link_color',
                            'title'     => esc_html__('Header / Footer: Text/Link Color', 'pointfindert2d'),
                            'active'    => false,
                            'visited'   => false,
                            'default'   => array(
                                'regular'   => '#494949',
                                'hover'     => '#F25555',
                            )
                        ),

                        array(
                            'id'        => 'setup_inv_temp_contentbg',
                            'type'      => 'color',
                            'title'     => esc_html__('Content: Background Color', 'pointfindert2d'),
                            'default'   => '#ffffff',
                            'validate'  => 'color',
                             'transparent'  => false
                        ),

                        array(
                            'id'        => 'setup_inv_temp_contenttext',
                            'type'      => 'link_color',
                            'title'     => esc_html__('Content: Text/Link Color', 'pointfindert2d'),
                            'active'    => false,
                            'visited'   => false,
                            'default'   => array(
                                'regular'   => '#494949',
                                'hover'     => '#F25555',
                            )
                        ),

                        array(
                            'id'        => 'setup_inv_temp_footertext',
                            'type'      => 'textarea',
                            'title'     => esc_html__('Footer Text', 'pointfindert2d'),
                            'desc'      => esc_html__('%%siteurl%% : Site URL', 'pointfindert2d').'<br>'.esc_html__('%%sitename%% : Site Name', 'pointfindert2d'),
                            'default'   => 'This is an automated email from <a href="%%siteurl%%">%%sitename%%</a>'
                        ),
                            
                )
            );
                /**
                *End: Invoice Template Settings
                **/
            /**
            *End : Invoice Settings
            **/



            /**
            *Start : Grid Settings
            **/
                $this->sections[] = array(
                    'id' => 'setup_gridsettings',
                    'title' => esc_html__('Grid Filters', 'pointfindert2d'),
                    'icon' => 'el-icon-th',
                    'fields' => array(
                        array(
                            'id'    => 'setup_gridsettings_info',
                            'type'  => 'info',
                            'style' => 'info',
                            'title' => __( 'Additional Grid Settings', 'pointfindert2d' ),
                            'desc'  => __( 'You can enable/disable newly added functions by using this section. Please select filter type from left menu and edit.', 'pointfindert2d' )
                        ),
                        
                        
                    )
                );

                $this->sections[] = array(
                    'id' => 'setup_gridsettings_ltf',
                    'title' => esc_html__('Listing Type Filter', 'pointfindert2d'),
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id' => 'setup_gridsettings_ltype_filter',
                            'type' => 'button_set',
                            'title' => esc_html__('Listing Type Filter: For Category Pages', 'pointfindert2d') ,
                            'desc' => esc_html__('Show counts for terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                        array(
                            'id' => 'setup_gridsettings_ltype_filter_c',
                            'type' => 'button_set',
                            'title' => esc_html__('Listing Type Filter: Counts', 'pointfindert2d') ,
                            'desc' => esc_html__('Show counts for terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                        array(
                            'id' => 'setup_gridsettings_ltype_filter_h',
                            'type' => 'button_set',
                            'title' => esc_html__('Listing Type Filter: Hide Empty', 'pointfindert2d') ,
                            'desc' => esc_html__('Hide empty terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                    )
                );

                $this->sections[] = array(
                    'id' => 'setup_gridsettings_itf',
                    'title' => esc_html__('Item Type Filter', 'pointfindert2d'),
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id' => 'setup_gridsettings_itype_filter',
                            'type' => 'button_set',
                            'title' => esc_html__('Item Type Filter: For Category Pages', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                        array(
                            'id' => 'setup_gridsettings_itype_filter_c',
                            'type' => 'button_set',
                            'title' => esc_html__('Item Type Filter: Counts', 'pointfindert2d') ,
                            'desc' => esc_html__('Show counts for terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                        array(
                            'id' => 'setup_gridsettings_itype_filter_h',
                            'type' => 'button_set',
                            'title' => esc_html__('Item Type Filter: Hide Empty', 'pointfindert2d') ,
                            'desc' => esc_html__('Hide empty terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                    )
                );

                $this->sections[] = array(
                    'id' => 'setup_gridsettings_lotf',
                    'title' => esc_html__('Location Filter', 'pointfindert2d'),
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id' => 'setup_gridsettings_location_filter',
                            'type' => 'button_set',
                            'title' => esc_html__('Location Filter:  For Category Pages', 'pointfindert2d') ,
                            'desc' => esc_html__('Show counts for terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                        array(
                            'id' => 'setup_gridsettings_location_filter_c',
                            'type' => 'button_set',
                            'title' => esc_html__('Location Filter: Counts', 'pointfindert2d') ,
                            'desc' => esc_html__('Show counts for terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                        array(
                            'id' => 'setup_gridsettings_location_filter_h',
                            'type' => 'button_set',
                            'title' => esc_html__('Location Filter: Hide Empty', 'pointfindert2d') ,
                            'desc' => esc_html__('Hide empty terms', 'pointfindert2d'),
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            'default' => '0',
                        ) ,
                    
                    )
                );
            /**
            *End : Grid Settings
            **/

            /**
            *Start : Speed Up Settings
            **/
                $this->sections[] = array(
                    'id' => 'setup_speed',
                    'title' => esc_html__('Speed Up Settings', 'pointfindert2d'),
                    'icon' => 'el-icon-wrench',
                    'fields' => array(
                        
                        array(
                            'id' => 'st8_ncptsys',
                            'type' => 'button_set',
                            'title' => esc_html__("PF Listings Page Additional Filters", 'pointfindert2d') ,
                            'desc' => esc_html__('This will disable Listing type and location filter for PF Listings page. Then you can see listings more faster on admin backend.', 'pointfindert2d') ,
                            "default" => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                        ) ,
                        array(
                            'id' => 'st8_nasys',
                            'type' => 'button_set',
                            'title' => esc_html__('New Advanced Listing Types System', 'pointfindert2d') ,
                            'desc' => esc_html__('If you planning to use more than 50 listing type,then this system recommended. If this enabled, Advanced Listing Types Config Panel will disappeared.', 'pointfindert2d') ,
                            "default" => 1,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                        ) ,
                        array(
                            'id' => 'st8_npsys',
                            'type' => 'button_set',
                            'title' => esc_html__('New Custom Point Style System', 'pointfindert2d') ,
                            'desc' => esc_html__('If you planning to use more than 50 listing type,then this system recommended. If this enabled, Custom Point Styles Config Panel will disappeared.', 'pointfindert2d') ,
                            "default" => 1,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                        ) ,
                        array(
                            'id'        => 'st8_npsys-start',
                            'type'      => 'section',
                            'title'     => esc_html__('Default Point Setting', 'pointfindert2d'),
                            'subtitle' => esc_html__("If system can not found a configuration for the listing type then will use this settings. Configuration strongly recommended. This system only working with New Custom Point Style System", 'pointfindert2d') ,
                            'indent'    => true, 
                            'required'  => array('st8_npsys','=',1)
                        ),
                            array(
                                'id' => 'cpoint_type',
                                'type' => 'button_set',
                                'title' => esc_html__('Point Type','pointfindert2d'),
                                "default" => 0,
                                'options' => array(1 => esc_html__('Custom Image','pointfindert2d'), 0 => esc_html__('Predefined Icon','pointfindert2d')),
                                'required'  => array('st8_npsys','=',1)
                            ) ,
                            array(
                                'id' => 'cpoint_bgimage',
                                'type' => 'media',
                                'title' => esc_html__('Point Image','pointfindert2d'),
                                'required'  => array(array('st8_npsys','=',1),array('cpoint_type','=',1))
                            ) ,

                            array(
                                'id' => 'cpoint_icontype',
                                'type' => 'button_set',
                                'title' => esc_html__('Point Icon Type','pointfindert2d'),
                                "default" => 1,
                                'options' => array(1 => esc_html__('Round','pointfindert2d'), 2 => esc_html__('Square','pointfindert2d'),3 => esc_html__('Dot','pointfindert2d')),
                                'required'  => array('st8_npsys','=',1)
                            ) ,
                            array(
                                'id' => 'cpoint_iconsize',
                                'type' => 'button_set',
                                'title' => esc_html__('Point Icon Type','pointfindert2d'),
                                "default" => 'middle',
                                'options' => array('small' => esc_html__('Small','pointfindert2d'), 'middle' => esc_html__('Middle','pointfindert2d'), 'large' => esc_html__('Large','pointfindert2d'), 'xlarge' => esc_html__('X-Large','pointfindert2d')),
                                'required'  => array('st8_npsys','=',1)
                            ) ,
                            array(
                                'id' => 'cpoint_bgcolor',
                                'type' => 'color',
                                'title' => esc_html__('Point Color','pointfindert2d'),
                                "default" => '#b00000',
                                'required'  => array('st8_npsys','=',1)
                            ) ,
                            array(
                                'id' => 'cpoint_bgcolorinner',
                                'type' => 'color',
                                'title' => esc_html__('Point Inner Color','pointfindert2d'),
                                "default" => '#ffffff',
                                'required'  => array('st8_npsys','=',1)
                            ) ,
                            array(
                                'id' => 'cpoint_iconcolor',
                                'type' => 'color',
                                'title' => esc_html__('Point Icon Color','pointfindert2d'),
                                "default" => '#b00000',
                                'required'  => array('st8_npsys','=',1)
                            ) ,
                            array(
                                'id' => 'cpoint_iconname',
                                'type' => 'extension_custom_icon',
                                'title' => esc_html__('Point Icon Color','pointfindert2d'),
                                'required'  => array('st8_npsys','=',1)
                            ) ,


                        array(
                            'id' => 'st8_npsys-end',
                            'type' => 'section',
                            'required' => array(array('setup42_searchpagemap_ajax','=','1'),array('setup42_searchpagemap_headeritem','=','1')) ,
                            'indent' => false,
                            'required'  => array('st8_npsys','=',1)
                        ) ,


                    
                    )
                );
            /**
            *End : Speed Up Settings
            **/

			
        }

        

        public function setArguments() {


            $this->args = array(
                'opt_name'             => 'pfascontrol_options',
                'display_name'         => esc_html__('Point Finder Additional Settings','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Additional Settings','pointfindert2d'),
                'page_title'           => esc_html__('Additional Settings', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pfasconf',
                'save_defaults'        => false,
                'default_show'         => false,
                'default_mark'         => '',
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                'output_tag'           => true,
                'database'             => '',
                'system_info'          => false,
                'domain'               => 'redux-framework',
                'hide_reset'           => true,
                'update_notice'        => false,
                'compiler'             => true,
            );


        }

    }

    new Redux_Framework_PF_AScontrol_Config();
	
}
