<?php
/**********************************************************************************************************************************
*
* Google reCaptcha Settings
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_REVSGenerator_Config")) {
	

    class Redux_Framework_PF_REVSGenerator_Config{

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
            add_filter('redux/options/' . $this->args['opt_name'] . '/compiler', array($this,'compiler_action') , 10, 2);
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

        }

        function compiler_action($options, $css){
            
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
            $filename = trailingslashit($uploads['basedir']) . '/pfstyles/pf-style-review' . '.css';
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once (ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            if ($wp_filesystem) {$wp_filesystem->put_contents($filename, $css, $chmod_file);}
        }
		

        

        public function setSections() {        
			
           /**
            *START: REVIEW SYSTEM
            **/
                $this->sections[] = array(
                    'id' => 'setup11_reviewsystem',
                    'title' => esc_html__('Review System', 'pointfindert2d') ,
                    'icon' => 'el-icon-tasks',
                    'fields' => array(
                        array(
                            'id' => 'setup1_help2_rw',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'critical',
                            'title' => esc_html__('IMPORTANT NOTICE', 'pointfindert2d'),
                            'desc' => esc_html__('Please configure these sections before you use theme. If you change configuration after using theme, data which is related to these sections will be lost.', 'pointfindert2d')
                        ) ,
                        
                        array(
                            'id' => 'setup1_help3_rw',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'warning',
                            'desc' => esc_html__('Activation & Deactivation will not cause any data loss.', 'pointfindert2d')
                        ) ,
                        array(
                            'id' => 'setup11_reviewsystem_check',
                            'type' => 'button_set',
                            'title' => esc_html__('Review System', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            "default" => 0
                        ) ,
                        array(
                            'id' => 'setup11_reviewsystem_usertype',
                            'type' => 'button_set',
                            'title' => esc_html__('Registered Users', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            "default" => 0,
                            'desc' => esc_html__('Only registered user can review.', 'pointfindert2d'),
                            'required' => array('setup11_reviewsystem_check','=','1') ,
                        ) ,
                        array(
                            'id' => 'setup11_reviewsystem_flagfeature',
                            'type' => 'button_set',
                            'title' => esc_html__('Review Flag Feature', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            "default" => 1,
                            'desc' => esc_html__('Only registered user can flag a review.', 'pointfindert2d'),
                            'required' => array('setup11_reviewsystem_check','=','1') ,
                        ) ,
                        array(
                            'id' => 'setup11_reviewsystem_singlerev',
                            'type' => 'button_set',
                            'title' => esc_html__('Single Review', 'pointfindert2d') ,
                            'options' => array(
                                '1' => esc_html__('Enable', 'pointfindert2d') ,
                                '0' => esc_html__('Disable', 'pointfindert2d')
                            ) ,
                            "default" => 1,
                            'desc' => esc_html__('Users can send only one review per item.', 'pointfindert2d'),
                            'required' => array('setup11_reviewsystem_check','=','1')
                        ) ,
                        array(
                            'id' => 'setup11_reviewsystem_revstatus',
                            'type' => 'button_set',
                            'title' => esc_html__('New Submitted Review Status', 'pointfindert2d') ,
                            'options' => array(
                                    '1' => esc_html__('Publish Directly', 'pointfindert2d') ,
                                    '0' => esc_html__('Pending for Approval', 'pointfindert2d')
                                ) ,
                            "default" => 0,
                            'required' => array('setup11_reviewsystem_check','=','1') ,
                        ) ,
                        array(
                            'id'            => 'setup11_reviewsystem_revperpage',
                            'type'          => 'slider',
                            'title'         => esc_html__( 'Review Per Page', 'pointfindert2d' ),
                            'desc'          => esc_html__( 'How many review want to show per page in item detail?', 'pointfindert2d' ),
                            'default'       => 3,
                            'min'           => 0,
                            'step'          => 1,
                            'max'           => 15,
                            'display_value' => 'text',
                            'required' => array('setup11_reviewsystem_check','=','1') ,
                        ),
                        array(
                            'id' => 'setup11_reviewsystem_criterias',
                            'type' => 'multi_text',
                            'required' => array('setup11_reviewsystem_check','=','1') ,
                            'title' => esc_html__('Review Criterias', 'pointfindert2d') ,
                            'desc' => esc_html__('Please enter custom criterias here. Ex: Neigborhood', 'pointfindert2d')
                        ) ,

                        
                        
                    )
                );


                /**
                *Review Fields
                **/
                $this->sections[] = array(
                    'id' => 'setup11_reviewsystemfields',
                    'title' => esc_html__('Review Fields', 'pointfindert2d') ,
                    'icon' => 'el-icon-wrench-alt',
                    'fields' => array(
                        array(
                            'id' => 'setup1_help4_rw',
                            'type' => 'info',
                            'notice' => true,
                            'style' => 'info',
                            'desc' => esc_html__('You can edit review field by using below options.', 'pointfindert2d'),
                        ) ,
                        array(
                            'id'        => 'setup11_reviewsystem_emailarea-start',
                            'type'      => 'section',
                            'title'     => esc_html__('Email Area', 'pointfindert2d'),
                            'indent'    => true, 
                            'subtitle'  => esc_html__('Email address field options.', 'pointfindert2d'),
                        ),
                            array(
                                'id' => 'setup11_reviewsystem_emailarea',
                                'type' => 'button_set',
                                'title' => esc_html__('Email Address Field', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Show', 'pointfindert2d') ,
                                    '0' => esc_html__('Hide', 'pointfindert2d')
                                ) ,
                                "default" => 1,
                            ) ,
                            array(
                                'id' => 'setup11_reviewsystem_emailarea_req',
                                'type' => 'button_set',
                                'title' => esc_html__('Email Address Status', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Required', 'pointfindert2d') ,
                                    '0' => esc_html__('Optional', 'pointfindert2d')
                                ) ,
                                'default' => 0,
                                'required' => array('setup11_reviewsystem_emailarea','=','1')
                                    
                            ) ,
                        array(
                            'id'        => 'setup11_reviewsystem_emailarea-end',
                            'type'      => 'section',
                            'indent'    => false, 
                        ),
                        array(
                            'id'        => 'setup11_reviewsystem_mesarea-start',
                            'type'      => 'section',
                            'title'     => esc_html__('Message Area', 'pointfindert2d'),
                            'indent'    => true, 
                            'subtitle'  => esc_html__('Message field options.', 'pointfindert2d'),
                        ),
                            array(
                                'id' => 'setup11_reviewsystem_mesarea',
                                'type' => 'button_set',
                                'title' => esc_html__('Message Area Field', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Show', 'pointfindert2d') ,
                                    '0' => esc_html__('Hide', 'pointfindert2d')
                                ) ,
                                "default" => 1,
                            ) ,
                            array(
                                'id' => 'setup11_reviewsystem_mesarea_req',
                                'type' => 'button_set',
                                'title' => esc_html__('Message Area Status', 'pointfindert2d') ,
                                'options' => array(
                                    '1' => esc_html__('Required', 'pointfindert2d') ,
                                    '0' => esc_html__('Optional', 'pointfindert2d')
                                ) ,
                                'default' => 0,
                                'required' => array('setup11_reviewsystem_mesarea','=','1')
                            ) ,
                        array(
                            'id'        => 'setup11_reviewsystem_mesarea-end',
                            'type'      => 'section',
                            'indent'    => false, 
                        ),

                    )
                );

                /**
                *Review Stars
                **/
                $this->sections[] = array(
                    'id' => 'setup16_reviewstars',
                    'title' => esc_html__('Review Band', 'pointfindert2d') ,
                    'icon' => 'el-icon-brush',
                    'fields' => array(
                        array(
                            'id' => 'setup16_reviewstars_bg',
                            'type' => 'color_rgba',
                            'title' => esc_html__('Info Window Review Band BG Color', 'pointfindert2d') ,
                            'default' => array(
                                'color' => '#000000',
                                'alpha' => '0.5'
                            ) ,
                            'compiler' => array('.wpfinfowindow .pfrevstars-wrapper-review','.wpfinfowindow2 .pfrevstars-wrapper-review') ,
                            'mode' => 'background',
                            'validate' => 'colorrgba',
                            'transparent' => false,
                        ) ,
                        array(
                            'id' => 'setup16_reviewstars_text3',
                            'type' => 'color',
                            'transparent' => false,
                            'compiler' => array(
                                '.wpfinfowindow .pflist-imagecontainer .pfrevstars-wrapper-review i',
                                '.wpfinfowindow  .pfrevstars-wrapper-review .pfrevstars-review',
                                '.wpfinfowindow2 .pflist-imagecontainer .pfrevstars-wrapper-review i',
                                '.wpfinfowindow2  .pfrevstars-wrapper-review .pfrevstars-review'
                                ) ,
                            'title' => esc_html__('Text/Star Icon Color(For Info Window)', 'pointfindert2d') ,
                            'default' => '#FFB400',
                            'validate' => 'color'
                        ) ,
                        array(
                            'id' => 'setup16_reviewstars_text',
                            'type' => 'color',
                            'transparent' => false,
                            'compiler' => array('.pflist-imagecontainer .pfrevstars-wrapper-review i','.pfrevstars-wrapper-review .pfrevstars-review') ,
                            'title' => esc_html__('Text/Star Icon Color', 'pointfindert2d') ,
                            'default' => '#FFB400',
                            'validate' => 'color'
                        ) ,

                        array(
                            'id' => 'setup16_reviewstars_text2',
                            'type' => 'color',
                            'transparent' => false,
                            'compiler' => array('.pfrevstars-wrapper-review .pfrevstars-review.pfrevstars-reviewbl') ,
                            'title' => esc_html__('Text/Star Icon Color(Empty Stars)', 'pointfindert2d') ,
                            'default' => '#9E9E9E',
                            'validate' => 'color'
                        ) ,

                        array(
                            'id' => 'setup22_searchresults_hide_re',
                            'type' => 'button_set',
                            'title' => esc_html__('Review Band Status', 'pointfindert2d') ,
                            'default' => 1,
                            'options' => array(
                                '0' => esc_html__('Show', 'pointfindert2d') ,
                                '1' => esc_html__('Hide', 'pointfindert2d')
                            )
                        ),

                        array(
                            'id' => 'setup16_reviewstars_nrtext',
                            'type' => 'button_set',
                            'title' => esc_html__('Empty Reviews', 'pointfindert2d') ,
                            'default' => 0,
                            'options' => array(
                                '0' => esc_html__('Show empty stars', 'pointfindert2d') ,
                                '1' => esc_html__('Show nothing', 'pointfindert2d')
                            )
                        )
                    )
                );
            /**
            *End: REVIEW SYSTEM
            **/
			
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pfitemreviewsystem_options',
                'display_name'         => esc_html__('Point Finder Review System','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Review System Config','pointfindert2d'),
                'page_title'           => esc_html__('Review System Config', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => '',
                'page_slug'            => '_pfrevsystemconf',
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

    new Redux_Framework_PF_REVSGenerator_Config();
	
}