<?php
/**********************************************************************************************************************************
*
* Welcome to Point Finder Page
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

// add page visible to editors
add_action( 'admin_menu', 'pointfinder_register_my_page',7);
function pointfinder_register_my_page(){
    add_menu_page( esc_html__('Point Finder Settings','pointfindert2d'), esc_html__('PF Settings','pointfindert2d'), 'manage_options', 'pointfinder_tools', 'pointfinder_tools_content', 'dashicons-location' ); 
}
add_action( 'admin_enqueue_scripts', 'pf_welcomepage_scripts' );

function pf_welcomepage_scripts() {
  $screen = get_current_screen();
  if ($screen->id == 'toplevel_page_pointfinder_tools') {
    wp_register_style( 'welcome-widget-style', get_template_directory_uri() . '/admin/core/css/welcome-custom.css', false, '1.0.0' );
    wp_enqueue_style( 'welcome-widget-style' );
  }     
}


function pointfinder_tools_content(){
?>
	<div class="wrap about-wrap">

      <h1><?php echo esc_html__('Welcome to PointFinder','pointfindert2d');?></h1>

      <div class="about-text"><?php echo esc_html__('Thank you for purchase Point Finder!','pointfindert2d');?></div>

      <h2 class="nav-tab-wrapper">
      	<a href="<?php echo admin_url('admin.php?page=pointfinder_tools');?>" class="nav-tab nav-tab-active">
           <?php echo esc_html__('Instruction','pointfindert2d');?></a>
       
        <a href="<?php echo admin_url('admin.php?page=pointfinder_demo_installer');?>" class="nav-tab nav-tab">
           <?php echo esc_html__('Quick Setup','pointfindert2d');?></a>

      </h2>
      
      <div class="pointfinder-main-window">
        
        <br/>
        <ul>

            <li><strong><?php echo esc_html__('Online Help Documentation','pointfindert2d');?> : </strong>
            <a href="http://docs.pointfindertheme.com" target="_blank">http://docs.pointfindertheme.com</a>
            </li>

            <li><strong><?php echo esc_html__('Ideal Hosting Settings','pointfindert2d');?> : </strong>
            <a href="http://docs.pointfindertheme.com/?p=142" target="_blank"><?php echo esc_html__('View','pointfindert2d');?></a>
            </li>

            <li><strong><?php echo esc_html__('Common Installation Errors & Solutions','pointfindert2d');?> : </strong>
            <a href="http://docs.pointfindertheme.com/?p=140" target="_blank"><?php echo esc_html__('View','pointfindert2d');?></a>
            </li>

            <li><strong><?php echo esc_html__('Changelog','pointfindert2d');?> : </strong>
            <a href="http://support.webbudesign.com/forums/topic/changelog/" target="_blank"><?php echo esc_html__('View','pointfindert2d');?></a>
            </li>

        </ul>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
      </div>

    </div>
    <?php
}
?>
