<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package	   TGM-Plugin-Activation
 * @subpackage Example
 * @version	   2.5.0
 * @author	   Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author	   Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license	   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'pointfinderh_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function pointfinderh_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

        array(
            'name'      => 'Redux Framework',
            'slug'      => 'redux-framework',
            'required'          => true, 
            'force_activation'      => true, 
            'force_deactivation'    => false, 
        ),

		array(
            'name'			=> 'WPBakery Visual Composer',
            'slug'			=> 'js_composer', 
            'source'			=> get_stylesheet_directory() . '/admin/plugins/js_composer.zip', 
            'required'			=> true, 
            'version'			=> '4.11.2.1', 
            'force_activation'		=> true, 
            'force_deactivation'	=> false, 
            'external_url'		=> '', 
        ),

        
		array(
            'name'			=> 'Templatera',
            'slug'			=> 'templatera', 
            'source'			=> get_stylesheet_directory() . '/admin/plugins/templatera.zip', 
            'required'			=> false, 
            'version'			=> '1.1.11', 
            'force_activation'		=> true, 
            'force_deactivation'	=> false, 
            'external_url'		=> '', 
        ),


        array(
            'name'          => 'Ultimate Addons for Visual Composer',
            'slug'          => 'Ultimate_VC_Addons', 
            'source'            => get_stylesheet_directory() . '/admin/plugins/Ultimate_VC_Addons.zip', 
            'required'          => false, 
            'version'           => '3.16.2', 
            'force_activation'      => true, 
            'force_deactivation'    => false, 
            'external_url'      => '', 
        ),


        array(
            'name'                  => 'Revolution Slider',
            'slug'                  => 'revslider', 
            'source'                => get_stylesheet_directory() . '/admin/plugins/revslider.zip', 
            'required'              => false, 
            'version'               => '5.2.5', 
            'force_activation'      => false, 
            'force_deactivation'    => false, 
            'external_url'          => '', 
        ),

		
	);

	
	
	 $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa( $plugins, $config );

}
