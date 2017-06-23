<?php
/**********************************************************************************************************************************
*
* Size Control Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_sizecontrol_Config")) {
	

    class Redux_Framework_PF_sizecontrol_Config{

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
			
            /**
            *Start : Image Sizes 
            **/
                $this->sections[] = array(
                    'id' => 'setupsizelimitconf_general',
                    'title' => esc_html__('Image Size Settings', 'pointfindert2d'),
                    'icon' => 'el-icon-resize-full',
                    'fields' => array(
                        array(
                            'id'     => 'setupsizelimitconf_general_gridsize1_help1',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'IMPORTANT', 'pointfindert2d' ),
                            'desc'   => __( 'Please make sure you are changing correctly. Because these settings will change all your image sizes.', 'pointfindert2d' )
                        ),
                        /*Start:(Ajax Grid / Static Grid / Item Carousel)*/
                        array(
                           'id' => 'setupsizelimitconf_general_gridsize1-start',
                           'type' => 'section',
                           'title' => __('Item Image Sizes', 'pointfindert2d'),
                           'subtitle' => __('This sizes will effect Ajax Grid / Static Grid / Item Carousel / Item Page Image Gallery', 'pointfindert2d'),
                           'indent' => true 
                        ),
                            array(
                                'id'             => 'setupsizelimitconf_general_gridsize1',
                                'type'           => 'dimensions',
                                'units'          => false,
                                'units_extended' => false,
                                'title'          => __('Grid Photos Min. Size (Width/Height)', 'pointfindert2d'),
                                'desc'           => __('All size units (px)', 'pointfindert2d'),
                                'default'        => array(
                                    'width'  => 440,
                                    'height' => 330,
                                )
                            ),
                            array(
                                'id'             => 'setupsizelimitconf_general_gallerysize1',
                                'type'           => 'dimensions',
                                'units'          => false,
                                'units_extended' => false,
                                'title'          => __('Item Page Gallery Photos Min. Size (Width/Height)', 'pointfindert2d'),
                                'desc'           => __('All size units (px)', 'pointfindert2d'),
                                'default'        => array(
                                    'width'  => 848,
                                    'height' => 566,
                                )
                            ),
                            array(
                                'id'             => 'setupsizelimitconf_general_gallerysize2',
                                'type'           => 'dimensions',
                                'units'          => false,
                                'units_extended' => false,
                                'title'          => __('Item Page Gallery (THUMB) Photos Min. Size (Width/Height)', 'pointfindert2d'),
                                'desc'           => __('All size units (px)', 'pointfindert2d'),
                                'default'        => array(
                                    'width'  => 112,
                                    'height' => 100,
                                )
                            ),
                        array(
                           'id' => 'setupsizelimitconf_general_gridsize1-end',
                           'type' => 'section',
                           'indent' => false 
                        ),
                        /*End:(Ajax Grid / Static Grid / Item Carousel)*/   


                        /*Start:(VC_Carousel, VC_Image_Carousel, VC_Client Carousel, VC_Gallery)*/
                        array(
                           'id' => 'setupsizelimitconf_general_gridsize2-start',
                           'type' => 'section',
                           'title' => __('Visual Composer Elements Image Size', 'pointfindert2d'),
                           'subtitle' => __('This sizes will effect Visual Composer Post Carousel, Image Carousel, Client Carousel, Gallery', 'pointfindert2d'),
                           'indent' => true 
                        ),
                             
                            array(
                                'id'             => 'setupsizelimitconf_general_gridsize2',
                                'type'           => 'dimensions',
                                'units'          => false,
                                'units_extended' => false,
                                'title'          => __('2 Cols. Min Size (Width/Height)', 'pointfindert2d'),
                                'desc'           => __('All size units (px)', 'pointfindert2d'),
                                'default'        => array(
                                    'width'  => 555,
                                    'height' => 416,
                                )
                            ),
                            array(
                                'id'             => 'setupsizelimitconf_general_gridsize3',
                                'type'           => 'dimensions',
                                'units'          => false,
                                'units_extended' => false,
                                'title'          => __('3 Cols. Min Size (Width/Height)', 'pointfindert2d'),
                                'desc'           => __('All size units (px)', 'pointfindert2d'),
                                'default'        => array(
                                    'width'  => 360,
                                    'height' => 270,
                                )
                            ),
                            array(
                                'id'             => 'setupsizelimitconf_general_gridsize4',
                                'type'           => 'dimensions',
                                'units'          => false,
                                'units_extended' => false,
                                'title'          => __('4 Cols. Min Size (Width/Height)', 'pointfindert2d'),
                                'desc'           => __('All size units (px)', 'pointfindert2d'),
                                'default'        => array(
                                    'width'  => 263,
                                    'height' => 197,
                                )
                            ),

                        array(
                           'id' => 'setupsizelimitconf_general_gridsize2-start',
                           'type' => 'section',
                           'indent' => false 
                        ),
                        /*End:(VC_Carousel, VC_Image_Carousel, VC_Client Carousel, VC_Gallery)*/

                    )
                );
            /**
            *End : Image Sizes
            **/

            /**
            *Start : Word Limits
            **/
                $this->sections[] = array(
                    'id' => 'setupsizelimitwordconf_general',
                    'title' => esc_html__('Word Size Settings', 'pointfindert2d'),
                    'icon' => 'el-icon-resize-full',
                    'fields' => array(
                        array(
                            'id'     => 'setupsizelimitwordconf_general_grid_help1',
                            'type'   => 'info',
                            'notice' => true,
                            'style'  => 'critical',
                            'title'  => __( 'IMPORTANT', 'pointfindert2d' ),
                            'desc'   => __( 'Please make sure you are changing correctly. Because these settings will change all your text area limit sizes.', 'pointfindert2d' )
                        ),

                        array(
                           'id' => 'setupsizelimitwordconf_general_grid22-start',
                           'type' => 'section',
                           'title' => __('Info Window Word Limit Sizes', 'pointfindert2d'),
                           'subtitle' => __('This sizes will effect Info Window. (Numeric Only)', 'pointfindert2d'),
                           'indent' => true 
                        ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_infowindowtitle',
                                'type'     => 'text',
                                'title'    => __( 'Info Window Title Char Limit', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 20,
                            ), 
                            array(
                                'id'       => 'setupsizelimitwordconf_general_infowindowaddress',
                                'type'     => 'text',
                                'title'    => __( 'Info Window Address Char Limit', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 28,
                            ),
                        array(
                           'id' => 'setupsizelimitwordconf_general_grid22-end',
                           'type' => 'section',
                           'indent' => false 
                        ),

                        
                        array(
                           'id' => 'setupsizelimitwordconf_general_grid-start',
                           'type' => 'section',
                           'title' => __('Item Grid & Carousel Word Limit Sizes', 'pointfindert2d'),
                           'subtitle' => __('This sizes will effect Ajax Grid / Static Grid / Item Carousel. (Numeric Only)', 'pointfindert2d'),
                           'indent' => true 
                        ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid1title',
                                'type'     => 'text',
                                'title'    => __( 'Title Area (1 col)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 120,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid1address',
                                'type'     => 'text',
                                'title'    => __( 'Address/Excerpt Area (1 col)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 120,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid2title',
                                'type'     => 'text',
                                'title'    => __( 'Title Area (2 cols)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 96,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid2address',
                                'type'     => 'text',
                                'title'    => __( 'Address/Excerpt Area (2 cols)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 96,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid3title',
                                'type'     => 'text',
                                'title'    => __( 'Title Area (3 cols)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 32,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid3address',
                                'type'     => 'text',
                                'title'    => __( 'Address/Excerpt Area (3 cols)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 32,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid4title',
                                'type'     => 'text',
                                'title'    => __( 'Title Area (4 cols)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 32,
                            ),
                            array(
                                'id'       => 'setupsizelimitwordconf_general_grid4address',
                                'type'     => 'text',
                                'title'    => __( 'Address/Excerpt Area (4 cols)', 'pointfindert2d' ),
                                'validate' => 'numeric',
                                'default'  => 32,
                            ),
                        array(
                           'id' => 'setupsizelimitwordconf_general_grid-end',
                           'type' => 'section',
                           'indent' => false 
                        ),
                    )
                );
            /**
            *End : Word Limits
            **/


			
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pfsizecontrol_options',
                'display_name'         => esc_html__('Point Finder Size Limits','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Size Limits Config','pointfindert2d'),
                'page_title'           => esc_html__('Size Limits Config', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pfsizelimitconf',
                'save_defaults'        => false,
                'default_show'         => false,
                'default_mark'         => '',
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => false,
                'output_tag'           => false,
                'database'             => '',
                'system_info'          => false,
                'domain'               => 'redux-framework',
                'hide_reset'           => true,
                'update_notice'        => false,  
            );


        }

    }

    new Redux_Framework_PF_sizecontrol_Config();
	
}