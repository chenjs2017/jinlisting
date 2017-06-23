<?php
/**********************************************************************************************************************************
*
* Size Control Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_advancedcontrol_Config")) {
	

    class Redux_Framework_PF_advancedcontrol_Config{

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
			

             global $pfsidebargenerator_options;
             $setup25_sidebargenerator_sidebars = (isset($pfsidebargenerator_options['setup25_sidebargenerator_sidebars']))?$pfsidebargenerator_options['setup25_sidebargenerator_sidebars']:'';
             $widget_arr = array();

             if (!empty($setup25_sidebargenerator_sidebars) && isset($setup25_sidebargenerator_sidebars)) {
                 
                 foreach ($setup25_sidebargenerator_sidebars as $single_widget) {
                     $widget_arr[$single_widget['url']] = $single_widget['title']; 
                 }
             }
             

            /**
            *Start : Advanced Controls
            **/

                $taxonomies = array( 'pointfinderltypes');

                $args = array(
                    'orderby'           => 'name', 
                    'order'             => 'ASC',
                    'hide_empty'        => false, 
                    'exclude'           => array(), 
                    'exclude_tree'      => array(), 
                    'include'           => array(),
                    'number'            => '', 
                    'fields'            => 'all', 
                    'slug'              => '',
                    'parent'            => 0,
                    'hierarchical'      => true, 
                    'child_of'          => 0, 
                    'get'               => '', 
                    'name__like'        => '',
                    'description__like' => '',
                    'pad_counts'        => false, 
                    'offset'            => '', 
                    'search'            => '', 
                    'cache_domain'      => 'core'
                ); 

                $terms = get_terms($taxonomies, $args);
                
                foreach ($terms as $term) {
                    $this->sections[] = array(
                        'id' => 'setupadvancedconfig_'.$term->term_id,
                        'title' => $term->name,
                        'icon' => 'el-icon-cogs',
                        'fields' => array(
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_advanced_status',
                                'type'     => 'button_set',
                                'title'    => __( 'Advanced Settings', 'pointfindert2d' ),
                                'desc'     => __( 'If this enabled, you can enable/disable modules on item page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Enable','pointfindert2d'),
                                    '0' => esc_html__('Disable','pointfindert2d')
                                ),
                                'default'  => '0'
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_reviewmodule',
                                'type'     => 'button_set',
                                'title'    => __( 'Reviews', 'pointfindert2d' ),
                                'desc'     => __( 'Show/Hide this module on the item detail page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Show','pointfindert2d'),
                                    '0' => esc_html__('Hide','pointfindert2d')
                                ),
                                'default'  => '1',
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_commentsmodule',
                                'type'     => 'button_set',
                                'title'    => __( 'Comments', 'pointfindert2d' ),
                                'desc'     => __( 'Show/Hide this module on the item detail page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Show','pointfindert2d'),
                                    '0' => esc_html__('Hide','pointfindert2d')
                                ),
                                'default'  => '1',
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_featuresmodule',
                                'type'     => 'button_set',
                                'title'    => __( 'Features', 'pointfindert2d' ),
                                'desc'     => __( 'Show/Hide this module on the item detail page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Show','pointfindert2d'),
                                    '0' => esc_html__('Hide','pointfindert2d')
                                ),
                                'default'  => '1',
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_ohoursmodule',
                                'type'     => 'button_set',
                                'title'    => __( 'Opening Hours', 'pointfindert2d' ),
                                'desc'     => __( 'Show/Hide this module on the item detail page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Show','pointfindert2d'),
                                    '0' => esc_html__('Hide','pointfindert2d')
                                ),
                                'default'  => '1',
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_videomodule',
                                'type'     => 'button_set',
                                'title'    => __( 'Video Module on Upload Page', 'pointfindert2d' ),
                                'desc'     => __( 'Show/Hide this module on the item detail page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Show','pointfindert2d'),
                                    '0' => esc_html__('Hide','pointfindert2d')
                                ),
                                'default'  => '1',
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_claimsmodule',
                                'type'     => 'button_set',
                                'title'    => __( 'Claim Listings', 'pointfindert2d' ),
                                'desc'     => __( 'Show/Hide this module on the item detail page.', 'pointfindert2d' ),
                                'options'  => array(
                                    '1' => esc_html__('Show','pointfindert2d'),
                                    '0' => esc_html__('Hide','pointfindert2d')
                                ),
                                'default'  => '1',
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id' => 'setupadvancedconfig_'.$term->term_id.'_configuration',
                                'type' => 'extension_itempage',
                                'title' => esc_html__('Page Section Config', 'pointfindert2d') ,
                                'subtitle' => esc_html__('You can reorder positions of sections by using move icon. If want to disable any section please click and select disable.', 'pointfindert2d').'<br/><br/>'.esc_html__('Please check below options to edit Information Tab Content', 'pointfindert2d'),
                                'default' => array(),
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id'       => 'setupadvancedconfig_'.$term->term_id.'_sidebar',
                                'type'     => 'select',
                                'title'    => __('Custom Sidebar', 'pointfindert2d'), 
                                'desc'     => __('Custom sidebar for only this category.', 'pointfindert2d'),
                                'options'  => $widget_arr,
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                            array(
                                'id' => 'setupadvancedconfig_'.$term->term_id.'_headersection',
                                'type' => 'button_set',
                                'title' => esc_html__('Page Header', 'pointfindert2d') ,
                                'options' => array(
                                    0 => esc_html__('Standart Header', 'pointfindert2d') ,
                                    1 => esc_html__('Map Header', 'pointfindert2d'),
                                    2 => esc_html__('No Header', 'pointfindert2d'),
                                    3 => esc_html__('Image Header', 'pointfindert2d'),
                                ) ,
                                'desc'     => __('Page Header for only this category.', 'pointfindert2d'),
                                'default' => 2,
                                'required' => array('setupadvancedconfig_'.$term->term_id.'_advanced_status','=',1)
                            ),
                        )
                    );
                }
                
            /**
            *End : Advanced Controls
            **/

            


			
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pfadvancedcontrol_options',
                'display_name'         => esc_html__('Point Finder Advanced Listing Type Settings','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Advanced Listing Type Config','pointfindert2d'),
                'page_title'           => esc_html__('Advanced Listing Type Config', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pfadvancedlimitconf',
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

    new Redux_Framework_PF_advancedcontrol_Config();
	
}