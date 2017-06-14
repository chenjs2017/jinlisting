<?php
/**********************************************************************************************************************************
*
* Search Fields Config
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PFS_Fields_Config")) {


require_once(get_template_directory().'/admin/includes/pfsetsearchfields.php');

    class Redux_Framework_PFS_Fields_Config extends PFGetSFields{

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( !class_exists("ReduxFramework" ) ) {return;}
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {$this->initSettings();} else {add_action('plugins_loaded', array($this, 'initSettings'), 10);    }
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
            $filename = trailingslashit($uploads['basedir']) . '/pfstyles/pf-style-search' . '.css';
            
            if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }
            if( $wp_filesystem ) {$wp_filesystem->put_contents($filename,$css,$chmod_file);}
        }
        

        public function setSections() {

			
			global $pointfindertheme_option; 
			$setup1_slides = PFSAIssetControl('setup1s_slides','','');
			$pfstart = PFCheckStatusofVar('setup1s_slides');
			
			if(!$pfstart){
			
				$this->sections[] = array(
				'id' => 'setup1',
				'title' => 'Information',
				'icon' => 'el-icon-info-sign',
				'fields' => array (
					array(
						'id' => 'setup1_help',
						'id' => 'notice_critical',
						'type' => 'info',
						'notice' => true,
						'style' => 'critical',
						'desc' => esc_html__('Please first create search fields from <strong>PF Options > System Setup > Search Fields</strong> then you can see field detail setting on this control panel. If you install theme first time, please check installation steps from help documentations.', 'pointfindert2d')
						),
					
					)
				);
				
			}else{
				$this->sections[] = array(
				'id' => 'setup1',
				'title' => 'Search Fields',
				'icon' => 'el-icon-search-alt',
				'fields' => array (
					array(
						'id' => 'setup1_help',
						'id' => 'notice_critical',
						'type' => 'info',
						'notice' => true,
						'style' => 'info',
                        'desc'  => sprintf(esc_html__('Please check help documentation for information about this panel. Section name %s','pointfindert2d'),'<strong>'.esc_html__('PF Search Fields','pointfindert2d').'</strong>')
						),
					
					)
				);
				
				
				
				foreach ($setup1_slides as &$value) {

					$this->sections[] = $this->SDF($value['title'],$value['url'],$value['select']);
					
				}
				
			}
			
		
        }

        

        public function setArguments() {


            $this->args = array(
                'opt_name'             => 'pfsearchfields_options',
                'display_name'         => esc_html__('Point Finder Search Fields','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Search Fields Config','pointfindert2d'),
                'page_title'           => esc_html__('Point Finder Search Fields', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-search',
                'page_slug'            => '_pfsifoptions',
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

    new Redux_Framework_PFS_Fields_Config();
}