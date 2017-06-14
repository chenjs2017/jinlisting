<?php
/**********************************************************************************************************************************
*
* Point Finder Twitter Widget
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_TWGenerator_Config")) {
    

    class Redux_Framework_PF_TWGenerator_Config{

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
            *Start : Twitter Widget
            **/
                $this->sections[] = array(
                    'id' => 'setuptwitter_widget',
                    'title' => esc_html__('Twitter Widget', 'pointfindert2d'),
                    'icon' => 'el-icon-twitter',
                    'fields' => array(
                        array(
                            'id' => 'setuptwitterwidget_general_help',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => esc_html__('Please check help docs for setup below settings.', 'pointfindert2d')
                        ) ,

                        array(
                            'id' => 'setuptwitterwidget_conkey',
                            'type' => 'text',
                            'title' => esc_html__('Consumer Key', 'pointfindert2d') ,
                        ) ,
                        array(
                            'id' => 'setuptwitterwidget_consecret',
                            'type' => 'text',
                            'title' => esc_html__('Consumer Secret', 'pointfindert2d') ,
                        ),

                        array(
                            'id' => 'setuptwitterwidget_acckey',
                            'type' => 'text',
                            'title' => esc_html__('Access Token Key', 'pointfindert2d') ,
                        ) ,
                        array(
                            'id' => 'setuptwitterwidget_accsecret',
                            'type' => 'text',
                            'title' => esc_html__('Access Token Secret', 'pointfindert2d') ,
                        ),
                        
                        

                    )
                );
            /**
            *End : Twitter Widget
            **/
            
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pftwitterwidget_options',
                'display_name'         => esc_html__('Point Finder Twitter Widget','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Twitter Widget Config','pointfindert2d'),
                'page_title'           => esc_html__('Twitter Widget Config', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pftwitteroptions',
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

    new Redux_Framework_PF_TWGenerator_Config();
    
}