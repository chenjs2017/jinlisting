<?php
/**********************************************************************************************************************************
*
* Size Control Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_PBcontrol_Config")) {
	

    class Redux_Framework_PF_PBcontrol_Config{

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
            add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }


        function compiler_action($options, $css) {
            global $wp_filesystem;
            $uploads = wp_upload_dir();
            $upload_dir = trailingslashit($uploads['basedir']);
            $upload_dir = $upload_dir . '/pfstyles';
            if (! is_dir($upload_dir)) {mkdir( $upload_dir, 0755 );}
            $filename = trailingslashit($uploads['basedir']) . '/pfstyles/pf-style-pbstyles' . '.css';
            
            if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }
            if( $wp_filesystem ) {$wp_filesystem->put_contents($filename,$css,FS_CHMOD_FILE);}
        }
		

        

        public function setSections() {        
			
            /**
            *Start : PAGE BUILDER SETTINS 
            **/
                $this->sections[] = array(
                    'id' => 'general_pbcustomizer',
                    'title' => esc_html__('Page Builder Styles', 'pointfindert2d'),
                    'icon' => 'el-icon-website',
                    'fields' => array()
                        
                );
                /**
                *Page Builder: Info Boxes
                **/
                $this->sections[] = array(
                    'id' => 'setup21_widgetsettings_4',
                    'subsection' => true,
                    'title' => esc_html__('Page Builder: Info Boxes', 'pointfindert2d'),
                    'desc'      => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s You can change PF Info Box Typography.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_infobox.png" class="description-img" />'),
                    'fields' => array(
                            array(
                                'id' => 'setup21_iconboxsettings_title_typo',
                                'type' => 'typography',
                                'title' => esc_html__('Info Box Title Area', 'pointfindert2d') ,
                                'google' => true,
                                'font-backup' => true,
                                'font-size' => false,
                                'line-height' => false,
                                'text-align' => false,
                                'compiler' => array(
                                    '.pf-iconbox-wrapper .pf-iconbox-title'
                                ) ,
                                'units' => 'px',
                                'color' => false,
                                'default' => array(
                                    'font-weight' => '600',
                                    'font-family' => 'Open Sans',
                                    'google' => true,
                                    
                                ) ,
                            ) ,
                            array(
                                'id' => 'setup21_iconboxsettings_typ1_typo',
                                'type' => 'typography',
                                'title' => esc_html__('Info Box Text Area', 'pointfindert2d') ,
                                'google' => true,
                                'font-backup' => true,
                                'font-size' => false,
                                'line-height' => false,
                                'text-align' => false,
                                'color' => false,
                                'compiler' => array(
                                    '.pf-iconbox-wrapper .pf-iconbox-text',
                                    '.pf-iconbox-wrapper .pf-iconbox-readmore'
                                ) ,
                                'units' => 'px',
                                'default' => array(
                                    'font-weight' => '400',
                                    'font-family' => 'Open Sans',
                                    'google' => true,
                                ) ,
                            )
                    ) 
                );
                
                
                
                /**
                *Page Builder: Item Slider
                **/
                $this->sections[] = array(
                    'id' => 'setup21_widgetsettings_3',
                    'subsection' => true,
                    'title' => esc_html__('Page Builder: Item Slider', 'pointfindert2d'),
                    'desc' => sprintf('<p class="description descriptionpf descriptionpfimg">'.esc_html__('%s Blue area on the image refers to PF Items Slider.','pointfindert2d').'<br/>'.esc_html__('You can change styles of this area by using below options.', 'pointfindert2d').'</p>','<img src="'.get_template_directory_uri(). '/admin/options/images/image_itemslider.png" class="description-img" />'),
                    'fields' => array(
                            array(
                                'id'        => 'setup21_widgetsettings_3_slider_capt',
                                'type'      => 'color_rgba',
                                'title'     => esc_html__('Description Box Background', 'pointfindert2d'),
                                'default'   => array('color' => '#000', 'alpha' => '0.8'),
                                'compiler'  => array(
                                    '.pf-item-slider .pf-item-slider-description',
                                    '.pf-item-slider .pf-item-slider-price',
                                    '.pf-item-slider .pf-item-slider-golink'
                                ),
                                'mode'      => 'background',
                                'validate'  => 'colorrgba',
                            ),
                            array(
                                'id' => 'setup21_widgetsettings_3_title_color',
                                'type' => 'link_color',
                                'title' => esc_html__('Title/Type Area Link Color', 'pointfindert2d') ,
                                'compiler' => array(
                                    '.pf-item-slider-description .pf-item-slider-title a',
                                    '.pf-item-slider .pflistingitem-subelement.pf-price',
                                    '.pf-item-slider .pf-item-slider-golink a',
                                    '.anemptystylesheet'                                
                                ) ,
                                'active' => false,
                                'default' => array(
                                    'regular' => '#fff',
                                    'hover' => '#efefef'
                                )
                            ) ,
                            array(
                                'id' => 'setup21_widgetsettings_3_title_typo',
                                'type' => 'typography',
                                'title' => esc_html__('Title Area Typography', 'pointfindert2d') ,
                                'google' => true,
                                'font-backup' => true,
                                'compiler' => array(
                                    '.pf-item-slider-description .pf-item-slider-title',
                                    '.pf-item-slider .pflistingitem-subelement.pf-price',
                                    '.pf-item-slider .pf-item-slider-golink'
                                ) ,
                                'units' => 'px',
                                'color' => false,
                                'default' => array(
                                    'font-weight' => '400',
                                    'font-family' => 'Roboto Condensed',
                                    'google' => true,
                                    'font-size' => '25px',
                                    'line-height' => '25px',
                                    'text-align' => 'left'
                                )
                            ) ,
                            array(
                                'id' => 'setup21_widgetsettings_3_address_color',
                                'type' => 'link_color',
                                'title' => esc_html__('Address Area Link Color', 'pointfindert2d') ,
                                'compiler' => array(
                                    '.pf-item-slider-description .pf-item-slider-address a'
                                ) ,
                                'active' => false,
                                'default' => array(
                                    'regular' => '#fff',
                                    'hover' => '#efefef'
                                )
                            ) ,
                            array(
                                'id' => 'setup21_widgetsettings_3_address_typo',
                                'type' => 'typography',
                                'title' => esc_html__('Address Typography', 'pointfindert2d') ,
                                'google' => true,
                                'font-backup' => true,
                                'compiler' => array(
                                    '.pf-item-slider-description .pf-item-slider-address'
                                ) ,
                                'units' => 'px',
                                'color' => false,
                                'default' => array(
                                    'font-weight' => '400',
                                    'font-family' => 'Open Sans',
                                    'google' => true,
                                    'font-size' => '14px',
                                    'line-height' => '16px',
                                    'text-align' => 'left'
                                )
                            ),
                            array(
                                'id' => 'setup21_widgetsettings_3_typ1_typo',
                                'type' => 'typography',
                                'title' => esc_html__('Excerpt Area Typography', 'pointfindert2d') ,
                                'google' => true,
                                'font-backup' => true,
                                'compiler' => array(
                                    '.pf-item-slider-description .pf-item-slider-excerpt'
                                ) ,
                                'units' => 'px',
                                'color' => true,
                                'default' => array(
                                    'font-weight' => '400',
                                    'font-family' => 'Open Sans',
                                    'google' => true,
                                    'font-size' => '12px',
                                    'line-height' => '15px',
                                    'color' => '#fff',
                                    'text-align' => 'left'
                                )
                            ) 
                    ) 
                );
            /**
            *End : PAGE BUILDER SETTINS 
            **/



            /**
            *Start : POST BUTTON STYLES
            **/

                 $this->sections[] = array(
                    'id' => 'general_postitembutton',
                    'title' => esc_html__('Post Item Button Styles', 'pointfindert2d'),
                    'icon' => 'el-icon-plus',
                    'fields' => array(
                        array(
                            'id' => 'general_postitembutton_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Button Status', 'pointfindert2d') ,
                            'default' => 1,
                            'options' => array(
                                '1' => esc_html__('Show', 'pointfindert2d') ,
                                '0' => esc_html__('Hide', 'pointfindert2d')
                            ),
                        ),
                        array(
                            'id' => 'general_postitembutton_linkcolor',
                            'type' => 'link_color',
                            'title' => esc_html__('Text Color', 'pointfindert2d') ,
                            'compiler' => array(
                                '.wpf-header #pf-primary-nav .pfnavmenu #pfpostitemlink a',
                                '.anemptystylesheet'                                
                            ) ,
                            'active' => false,
                            'default' => array(
                                'regular' => '#fff',
                                'hover' => '#efefef'
                            )
                        ) ,

                        array(
                            'id' => 'general_postitembutton_linkcolor_typo',
                            'type' => 'typography',
                            'title' => esc_html__('Text Typography', 'pointfindert2d') ,
                            'google' => true,
                            'font-backup' => true,
                            'compiler' => array(
                                '.wpf-header #pf-primary-nav .pfnavmenu #pfpostitemlink a'
                            ) ,
                            'units' => 'px',
                            'color' => false,
                            'line-height' => false,
                            'text-align' => false,
                            'default' => array(
                                'font-weight' => '400',
                                'font-family' => 'Open Sans',
                                'google' => true,
                                'font-size' => '12px'
                            )
                        ),
                        array(
                            'id' => 'general_postitembutton_bgcolor',
                            'type' => 'extension_custom_link_color',
                            'mode' => 'background',
                            'title' => esc_html__('Background Color', 'pointfindert2d') ,
                            'compiler' => array(
                                '.wpf-header #pf-primary-nav .pfnavmenu #pfpostitemlink a',
                                '.anemptystylesheet'                                
                            ) ,
                            'active' => false,
                            'default' => array(
                                'regular' => '#ad2424',
                                'hover' => '#ce2f2f'
                            )
                        ) ,
                       
                        array(
                            'id' => 'general_postitembutton_buttontext',
                            'type' => 'text',
                            'title' => esc_html__('Button Text', 'pointfindert2d') ,
                            'default' => esc_html__('Post New Point', 'pointfindert2d') ,
                        ) ,

                        array(
                            'id'      => 'general_postitembutton_button_height',
                            'type'    => 'spinner',
                            'title'   => __( 'Button Height', 'pointfindert2d' ),
                            'desc'    => __( 'px', 'pointfindert2d' ),
                            'default' => '30',
                            'min'     => '20',
                            'step'    => '1',
                            'max'     => '100',
                        ),

                        array(
                            'id'      => 'general_postitembutton_button_mtop',
                            'type'    => 'spinner',
                            'title'   => __( 'Button Top Margin', 'pointfindert2d' ),
                            'desc'    => __( 'px', 'pointfindert2d' ),
                            'default' => '30',
                            'min'     => '0',
                            'step'    => '1',
                            'max'     => '300',
                        ),

                        array(
                            'id'      => 'general_postitembutton_button_mtop2',
                            'type'    => 'spinner',
                            'title'   => __( 'Button Top Margin (Scrolled)', 'pointfindert2d' ),
                            'desc'    => __( 'px', 'pointfindert2d' ),
                            'default' => '6',
                            'min'     => '0',
                            'step'    => '1',
                            'max'     => '300',
                        ),
                    )
                        
                );

            /**
            *End : POST BUTTON STYLES
            **/
			
        }

        

        public function setArguments() {


            $this->args = array(
                'opt_name'             => 'pfpbcontrol_options',
                'display_name'         => esc_html__('Point Finder Extra Styles','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Extra Styles','pointfindert2d'),
                'page_title'           => esc_html__('Extra Styles', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pfpbconf',
                'save_defaults'        => false,
                'default_show'         => false,
                'default_mark'         => '',
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                'output_tag'           => false,
                'database'             => '',
                'system_info'          => false,
                'domain'               => 'redux-framework',
                'google_api_key'       => "AIzaSyBhuxzrgSLeZn6jvnRU3bSuVgxuMbwqWF0",
                'hide_reset'           => true,
                'update_notice'        => false,
                'compiler'             => true,
            );


        }

    }

    new Redux_Framework_PF_PBcontrol_Config();
	
}