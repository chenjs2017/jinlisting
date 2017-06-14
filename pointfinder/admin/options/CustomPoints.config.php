<?php
/**********************************************************************************************************************************
*
* Custom Detail Fields Config
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_Points_Config")) {
	
require_once(get_template_directory().'/admin/includes/pfsetcustompoints.php');

    class Redux_Framework_PF_Points_Config extends PFGetPoints{

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
            $filename = trailingslashit($uploads['basedir']) . '/pfstyles/pf-style-custompoints' . '.css';
            
            if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
                WP_Filesystem();
            }

            if( $wp_filesystem ) {$wp_filesystem->put_contents($filename,$css,$chmod_file);}
             
        }

        

        public function setSections() {        
			
            $taxonomies = array( 
                'pointfinderltypes'
            );

            $args = array(
                'orderby'           => 'name', 
                'order'             => 'ASC',
                'hide_empty'        => false, 
                'parent'            => 0,
            ); 

            $pf_get_term_details = get_terms($taxonomies,$args); 
            
            $pfstart = (!empty($pf_get_term_details))? true:false;

			if(!$pfstart){
				
				$this->sections[] = array(
				'id' => 'setup1xx',
				'title' => 'Information',
				'icon' => 'el-icon-info-sign',
				'fields' => array (
					array(
						'id' => 'setup1_help',
						'id' => 'notice_critical',
						'type' => 'info',
						'notice' => true,
						'style' => 'critical',
						'desc' => esc_html__('You have to set listing categories for edit this options panel.', 'pointfindert2d')
						),
					
					)
				);
				
			}else{
				$this->sections[] = array(
				'id' => 'setup1xx',
				'title' => 'Custom Points',
				'icon' => 'el-icon-wrench-alt',
				'fields' => array (
					array(
						'id' => 'setup1_help',
						'id' => 'notice_critical',
						'type' => 'info',
						'notice' => true,
						'style' => 'info',
                        'desc'  => sprintf(esc_html__('Please check help documentation for information about this panel. Section name %s','pointfindert2d'),'<strong>'.esc_html__('PF Custom Points','pointfindert2d').'</strong>')
						),
					)
				);
				
			 
				foreach ($pf_get_term_details as &$pf_get_term_detail) {
					if ($pf_get_term_detail->parent == 0) {
                       
                        $this->sections[] = $this->PFDF($pf_get_term_detail->name,$pf_get_term_detail->term_id,'parent');

                        /* Get Sub Terms */
                        $args2 = array(
                            'orderby'           => 'name', 
                            'order'             => 'ASC',
                            'hide_empty'        => false, 
                            'parent'            => $pf_get_term_detail->term_id,
                        ); 
                       
                        $pf_get_term_details_sub = get_terms($taxonomies,$args2);

                        $pfstart2 = (!empty($pf_get_term_details_sub))? true:false;
                        
                        if ($pfstart2) {
                            foreach ($pf_get_term_details_sub as &$pf_get_term_detail_sub) {
                                $this->sections[] = $this->PFDF($pf_get_term_detail_sub->name,$pf_get_term_detail_sub->term_id,'sub');
                            }
                        }
                        

                    }
				}

                $this->sections[] = $this->PFDF(esc_html__('Uncategorized','pointfindert2d'),'pfdefaultcat','parent');
				
			}
			
        }

        

        public function setArguments() {


            $this->args = array(

                'opt_name'             => 'pfcustompoints_options',
                'display_name'         => esc_html__('Custom Point Styles for Listing Types','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Custom Point Styles','pointfindert2d'),
                'page_title'           => esc_html__('Custom Point Styles for Listing Types', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-location',
                'page_slug'            => '_pfpifoptions',
                'save_defaults'        => true,
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

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
            } 

        }

    }

    new Redux_Framework_PF_Points_Config();
	
}