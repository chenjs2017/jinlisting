<?php
/**********************************************************************************************************************************
*
* Google reCaptcha Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_RECGenerator_Config")) {
	

    class Redux_Framework_PF_RECGenerator_Config{

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
            *Start : reCaptcha
            **/
                $this->sections[] = array(
                    'id' => 'setupreCaptcha_general',
                    'title' => esc_html__('reCaptcha Settings', 'pointfindert2d'),
                    'icon' => 'el-icon-lock',
                    'fields' => array(
                        array(
                            'id' => 'setupreCaptcha_general_help',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => sprintf(esc_html__('Secure your forms with %s. To use reCaptcha you must obtain a free API key for your domain. To obtain one, visit: %s', 'pointfindert2d'),'<a href="https://www.google.com/recaptcha/admin" target="_blank">reCapthca</a>','<a href="https://www.google.com/recaptcha/admin" target="_blank">https://www.google.com/recaptcha/admin</a>')
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_status',
                            'type' => 'button_set',
                            'title' => esc_html__('reCaptcha Security', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            )
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_help2',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'warning',
                            'desc' => esc_html__('Please enable reCaptcha for write a free API key.', 'pointfindert2d'),
                            'required' => array('setupreCaptcha_general_status','=',0)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_pubkey',
                            'type' => 'text',
                            'title' => esc_html__('Public Key', 'pointfindert2d') ,
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_prikey',
                            'type' => 'text',
                            'title' => esc_html__('Private Key', 'pointfindert2d') ,
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ),
                        array(
                            'id' => 'setupreCaptcha_general_lang',
                            'type' => 'text',
                            'title' => esc_html__('Language Code', 'pointfindert2d') ,
                            'default' => 'en',
                            'desc' => sprintf(esc_html__('Please type your language code %s','pointfindert2d'),'<a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a>'),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ),
                        array(
                            'id' => 'setupreCaptcha_general_helpe',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => esc_html__('Below settings are for reCaptcha form activation controls. You can Enable/Disable form security.', 'pointfindert2d'),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_login_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Login', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_fb_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Forgot Password', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_reg_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Registration', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_con_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Contact Form', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_con_agent_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Agent/User Contact Form', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_rev_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Review Form', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        array(
                            'id' => 'setupreCaptcha_general_report_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Report Form', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,

                        array(
                            'id' => 'setupreCaptcha_general_flagrev_status',
                            'type' => 'button_set',
                            'title' => esc_html__('For Flag Review Form', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ),
                            'required' => array('setupreCaptcha_general_status','=',1)
                        ) ,
                        

                    )
                );
            /**
            *End : reCaptcha
            **/
			
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pfrecaptcha_options',
                'display_name'         => esc_html__('Point Finder Google reCaptcha','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('reCaptcha Config','pointfindert2d'),
                'page_title'           => esc_html__('Google reCaptcha Config', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pfrecaptchaconf',
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

    new Redux_Framework_PF_RECGenerator_Config();
	
}