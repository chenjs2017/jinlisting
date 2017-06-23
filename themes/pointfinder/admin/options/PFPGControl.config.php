<?php
/**********************************************************************************************************************************
*
* Size Control Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_PGcontrol_Config")) {
	

    class Redux_Framework_PF_PGcontrol_Config{

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
            *Start : iDeal
            **/
                $this->sections[] = array(
                    'id' => 'idealapi',
                    'title' => esc_html__('iDeal API', 'pointfindert2d'),
                    'icon' => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id' => 'stp_hlp3',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => esc_html__('iDeal only accepts EURO currency. If you planning to use this gateway please change other gateway currency Sign ($) before enable this gateway. (From PF Settings > Options Panel > Frontend Upload System > Payment Settings)', 'pointfindert2d')
                        ),
                        array(
                            'id' => 'ideal_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Status', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                        ) ,
                        array(
                            'id' => 'ideal_mode',
                            'type' => 'button_set',
                            'title' => esc_html__('Mode', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Live Mode', 'pointfindert2d') ,
                                '0' => esc_html__('Test Mode', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                            'required' => array('ideal_status','=',1)
                        ) ,

                        array(
                            'id' => 'ideal_id',
                            'type' => 'text',
                            'title' => esc_html__('Mollie API Key', 'pointfindert2d'),
                            'required' => array('ideal_status','=',1)
                        ) ,
                    )
                );
            /**
            *End : iDeal
            **/


            /**
            *Start : Payumoney
            **/
                $this->sections[] = array(
                    'id' => 'payumoneyapi',
                    'title' => esc_html__('PayU Money API', 'pointfindert2d'),
                    'icon' => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id' => 'stp_hlp2',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => esc_html__('PayU Money only accepts INR currency. If you planning to use this gateway please change other gateway currency Sign ($) before enable this gateway. (From PF Settings > Options Panel > Frontend Upload System > Payment Settings)', 'pointfindert2d')
                        ),
                        array(
                            'id' => 'payu_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Status', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                        ) ,
                        array(
                            'id' => 'payu_mode',
                            'type' => 'button_set',
                            'title' => esc_html__('Mode', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Live Mode', 'pointfindert2d') ,
                                '0' => esc_html__('Test Mode', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                            'required' => array('payu_status','=',1)
                        ) ,
                        array(
                            'id' => 'payu_provider',
                            'type' => 'button_set',
                            'title' => esc_html__('Provider', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('PayUmoney', 'pointfindert2d') ,
                                '0' => esc_html__('PayUbiz', 'pointfindert2d')
                            ) , 
                            'default' => 1,
                            'required' => array('payu_status','=',1)
                        ) ,
                        array(
                            'id' => 'payu_key',
                            'type' => 'text',
                            'title' => esc_html__('Merchant Key', 'pointfindert2d'),
                            'required' => array('payu_status','=',1)
                        ) ,

                        array(
                            'id' => 'payu_salt',
                            'type' => 'text',
                            'title' => esc_html__('Merchant Salt', 'pointfindert2d'),
                            'required' => array('payu_status','=',1)
                        ) ,
                    )
                );
            /**
            *End : Payumoney
            **/

            /**
            *Start : Pagseguro
            **/
                $this->sections[] = array(
                    'id' => 'pagsapi',
                    'title' => esc_html__('PagSeguro API', 'pointfindert2d'),
                    'icon' => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id' => 'stp_hlp1',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => esc_html__('PagSeguro only accepts BRL currency. If you planning to use this gateway please change other gateway currency Sign ($) before enable this gateway. (From PF Settings > Options Panel > Frontend Upload System > Payment Settings)', 'pointfindert2d')
                        ),
                        array(
                            'id' => 'pags_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Status', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                        ) ,
                        array(
                            'id' => 'pags_mode',
                            'type' => 'button_set',
                            'title' => esc_html__('Mode', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Live Mode', 'pointfindert2d') ,
                                '0' => esc_html__('Test Mode', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                            'required' => array('pags_status','=',1)
                        ) ,

                        array(
                            'id' => 'pags_email',
                            'type' => 'text',
                            'title' => esc_html__('PagSeguro Email', 'pointfindert2d'),
                            'required' => array('pags_status','=',1)
                        ) ,

                        array(
                            'id' => 'pags_token',
                            'type' => 'text',
                            'title' => esc_html__('PagSeguro Token', 'pointfindert2d'),
                            'required' => array('pags_status','=',1)
                        )
                    )
                );
            /**
            *End : Pagseguro
            **/


            /**
            *Start : 2Checkout
            **/
            /**
            *End : 2Checkout
            **/


            /**
            *Start : Skrill
            **
                $this->sections[] = array(
                    'id' => 'skrillapi',
                    'title' => esc_html__('Skrill API', 'pointfindert2d'),
                    'icon' => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id' => 'skrill_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Status', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                        ) ,
                        array(
                            'id' => 'skrill_mail',
                            'type' => 'text',
                            'title' => esc_html__('Skrill Mail', 'pointfindert2d'),
                            'required' => array('skrill_status','=',1)
                        ) ,

                        array(
                            'id' => 'skrill_secret',
                            'type' => 'text',
                            'title' => esc_html__('Skrill Secret Word', 'pointfindert2d'),
                            'required' => array('skrill_status','=',1)
                        ) ,

                        array(
                            'id' => 'skrill_apipass',
                            'type' => 'text',
                            'title' => esc_html__('API/MQI Password', 'pointfindert2d'),
                            'required' => array('skrill_status','=',1)
                        ) ,
                    )
                );
            **
            *End : Skrill
            **/


            /**
            *Start : Robokassa API
            **/
                $this->sections[] = array(
                    'id' => 'robokassaapi',
                    'title' => esc_html__('Robokassa API', 'pointfindert2d'),
                    'icon' => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id' => 'robo_status',
                            'type' => 'button_set',
                            'title' => esc_html__('Status', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                        ) ,
                        array(
                            'id' => 'robo_mode',
                            'type' => 'button_set',
                            'title' => esc_html__('Mode', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Live Mode', 'pointfindert2d') ,
                                '0' => esc_html__('Test Mode', 'pointfindert2d')
                            ) , 
                            'default' => 0,
                            'required' => array('robo_status','=',1)
                        ) ,
                        array(
                            'id' => 'robo_login',
                            'type' => 'text',
                            'title' => esc_html__('Robokassa Shop ID', 'pointfindert2d'),
                            'required' => array('robo_status','=',1)
                        ) ,
                        array(
                            'id' => 'robo_pass1',
                            'type' => 'text',
                            'title' => esc_html__('Robokassa Password #1', 'pointfindert2d'),
                            'required' => array('robo_status','=',1)
                        ) ,

                        array(
                            'id' => 'robo_pass2',
                            'type' => 'text',
                            'title' => esc_html__('Robokassa Password #2', 'pointfindert2d'),
                            'required' => array('robo_status','=',1)
                        ),
                        array(
                            'id' => 'robo_currency',
                            'type' => 'text',
                            'title' => esc_html__('Robokassa Currency', 'pointfindert2d'),
                            'desc' => esc_html__('Please leave blank for Ruble otherwise please enter currency code like USD or EUR', 'pointfindert2d') ,
                            'required' => array('robo_status','=',1)
                        ) ,
                        array(
                            'id' => 'robo_lang',
                            'type' => 'button_set',
                            'title' => esc_html__('Language', 'pointfindert2d') ,
                            'options' => array(
                                'en' => esc_html__('EN', 'pointfindert2d') ,
                                'ru' => esc_html__('RU', 'pointfindert2d')
                            ) , 
                            'default' => 'ru',
                            'required' => array('robo_status','=',1)
                        ) ,
                    )
                );
            /**
            *End : Robokassa API
            **/


			
        }

        

        public function setArguments() {


            $this->args = array(
                'opt_name'             => 'pfpgcontrol_options',
                'display_name'         => esc_html__('Point Finder Payment Gateways','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Payment Gateways','pointfindert2d'),
                'page_title'           => esc_html__('Payment Gateways', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-twitter',
                'page_slug'            => '_pfpgconf',
                'save_defaults'        => false,
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
                'compiler'             => true,
            );


        }

    }

    new Redux_Framework_PF_PGcontrol_Config();
	
}