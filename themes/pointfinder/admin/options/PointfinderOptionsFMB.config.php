<?php
/**********************************************************************************************************************************
*
* Meta Box Admin Options Config File
*
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PFFMB_Theme_Config")) {

	class Redux_Framework_PFFMB_Theme_Config{

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFrameworkpf;
		
		public function __construct(){

            if (!class_exists("ReduxFramework")) {
            	return;
            }

            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

		}

		

		public function initSettings(){
			$this->setArguments();
			$this->setSections();

			if (!isset($this->args['opt_name'])) {
				return;
			}
			$this->ReduxFrameworkpf = new ReduxFramework($this->sections, $this->args);
		}

		
		
		public function setSections()
		{
			

			$this->sections[] = array(
				'id' => 'sadasdefergdvd12312fsdfsd',
				'title' => 'yyy',
				'fields' => array()
			);
		
		}



		public function setArguments() {

            $this->args = array(

                'opt_name'             => 'pointfinderthemefmb_options',
                'display_name'         => 'Point Finder FMB Options Panel',
                'menu_type'            => 'hidden',
                'menu_title'           => 'PF FMB Options',
                'page_title'           => 'PF FMB Options',
                'admin_bar'            => false,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-admin-tools',
                'page_slug'            => '_optsdsdsions',
                'save_defaults'        => false,
                'default_show'         => false,
                'default_mark'         => '',
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                'output_tag'           => true,
                'database'             => '',
                'system_info'          => false,
                'domain'               => 'redux-framework',
                'hide_reset'           => true,
                'update_notice'        => false,
    
            );


            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
            } 

        }

	}
	new Redux_Framework_PFFMB_Theme_Config();
}