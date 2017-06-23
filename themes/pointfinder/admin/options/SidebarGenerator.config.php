<?php
/**********************************************************************************************************************************
*
* Point Finder Sidebar Generator
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_SBGenerator_Config")) {
	

    class Redux_Framework_PF_SBGenerator_Config{

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
            *Start : SIDEBAR GENERATOR STARTED
            **/
                $this->sections[] = array(
                    'id' => 'setup25_sidebargenerator',
                    'title' => esc_html__('Sidebar Generator', 'pointfindert2d'),
                    'icon' => 'el-icon-view-mode',
                    'fields' => array(
                        array(
                            'id'=>'setup25_sidebargenerator_sidebars',
                            'type' => 'extension_sidebar_slides',
                            'title' => esc_html__('Sidebar Name', 'pointfindert2d'),
                            'subtitle' => esc_html__('Please add sidebar name per line.', 'pointfindert2d'),
                            'add_text' => esc_html__('Add More', 'pointfindert2d'),
                            'show_empty' => false
                        )
                    )
                );
            /**
            *End : SIDEBAR GENERATOR STARTED
            **/
			
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pfsidebargenerator_options',
                'display_name'         => esc_html__('Point Finder Sidebar Generator','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Sidebar Generator','pointfindert2d'),
                'page_title'           => esc_html__('Sidebar Generator', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-analytics',
                'page_slug'            => '_pfsidebaroptions',
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
    global $pointfinder_main_options_sb;
    $pointfinder_main_options_sb = new Redux_Framework_PF_SBGenerator_Config();
	
}