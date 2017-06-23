<?php
/**********************************************************************************************************************************
*
* PF Quick Installer
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

class PointFinder_Theme_Importer {

  /* Real Estates 
  tof : Theme option file
  */
  public $realestate_tof_main;
  public $realestate_tof_customfields;
  public $realestate_tof_searchfields;
  public $realestate_tof_mailsettings;
  public $realestate_tof_custompoints;
  public $realestate_content_demo;


  /* Directory
  tof : Theme option file
  */
  public $directory_tof_main;
  public $directory_tof_customfields;
  public $directory_tof_searchfields;
  public $directory_tof_mailsettings;
  public $directory_tof_custompoints;
  public $directory_tof_reviews;
  public $directory_content_demo;



  /* Multi Directory
  tof : Theme option file
  */
  public $directory2_tof_main;
  public $directory2_tof_customfields;
  public $directory2_tof_searchfields;
  public $directory2_tof_mailsettings;
  public $directory2_tof_custompoints;
  public $directory2_tof_advanced;
  public $directory2_tof_reviews;
  public $directory2_content_demo;


  /* Car Dealer
  tof : Theme option file
  */
  public $cardealer_tof_main;
  public $cardealer_tof_customfields;
  public $cardealer_tof_searchfields;
  public $cardealer_tof_mailsettings;
  public $cardealer_tof_custompoints;
  public $cardealer_content_demo;


  /* Default with Content
  tof : Theme option file
  */
  public $withcontent_tof_main;
  public $withcontent_tof_customfields;
  public $withcontent_tof_searchfields;
  public $withcontent_tof_mailsettings;
  public $withcontent_content_demo;


  /* Default with NO Content
  tof : Theme option file
  */
  public $nocontent_tof_main;
  public $nocontent_tof_customfields;
  public $nocontent_tof_searchfields;
  public $nocontent_tof_mailsettings;
  public $nocontent_content_demo;


   /* Construction
  tof : Theme option file
  */
  public $construction_tof_main;
  public $construction_tof_customfields;
  public $construction_tof_searchfields;
  public $construction_tof_custompoints;
  public $construction_tof_mailsettings;
  public $construction_content_demo;


  public $widgets;

  public $flag_as_imported = array();

    private static $instance;

    public function __construct() {

        self::$instance = $this;
        
       

        /* Real Estate */
        $this->realestate_tof_main = $this->dfp . $this->tofn_main;
        $this->realestate_tof_customfields = $this->dfp . $this->tofn_customfields;
        $this->realestate_tof_searchfields = $this->dfp . $this->tofn_searchfields;
        $this->realestate_tof_mailsettings = $this->dfp . $this->tofn_mailsettings;
        $this->realestate_tof_custompoints = $this->dfp . $this->tofn_custompoints;

        $this->realestate_content_demo = $this->dfp . $this->cfn_realestate;
        $this->realestate_widgets = $this->dfp . $this->wfn_realestate;


        /* Directory */
        $this->directory_tof_main = $this->dfp . $this->tofn_main_d;
        $this->directory_tof_customfields = $this->dfp . $this->tofn_customfields_d;
        $this->directory_tof_searchfields = $this->dfp . $this->tofn_searchfields_d;
        $this->directory_tof_mailsettings = $this->dfp . $this->tofn_mailsettings_d;
        $this->directory_tof_custompoints = $this->dfp . $this->tofn_custompoints_d;
        $this->directory_tof_reviews = $this->dfp . $this->tofn_reviews_d;

        $this->directory_content_demo = $this->dfp . $this->cfn_directory;
        $this->directory_widgets = $this->dfp . $this->wfn_directory;


        /* Multi Directory */
        $this->directory2_tof_main = $this->dfp . $this->tofn_main_dm2;
        $this->directory2_tof_customfields = $this->dfp . $this->tofn_customfields_dm2;
        $this->directory2_tof_searchfields = $this->dfp . $this->tofn_searchfields_dm2;
        $this->directory2_tof_mailsettings = $this->dfp . $this->tofn_mailsettings_dm2;
        $this->directory2_tof_custompoints = $this->dfp . $this->tofn_custompoints_dm2;
        $this->directory2_tof_advanced = $this->dfp . $this->tofn_advanced_dm2;
        $this->directory2_tof_reviews = $this->dfp . $this->tofn_reviews_dm2;

        $this->directory2_content_demo = $this->dfp . $this->cfn_directorym2;
        $this->directory2_widgets = $this->dfp . $this->wfn_directorym2;




        /* Car Dealer */
        $this->cardealer_tof_main = $this->dfp . $this->tofn_main_c;
        $this->cardealer_tof_customfields = $this->dfp . $this->tofn_customfields_c;
        $this->cardealer_tof_searchfields = $this->dfp . $this->tofn_searchfields_c;
        $this->cardealer_tof_mailsettings = $this->dfp . $this->tofn_mailsettings_c;
        $this->cardealer_tof_custompoints = $this->dfp . $this->tofn_custompoints_c;

        $this->cardealer_content_demo = $this->dfp . $this->cfn_cardealer;
        $this->cardealer_widgets = $this->dfp . $this->wfn_cardealer;


        /* with content */
        $this->withcontent_tof_main = $this->dfp . $this->tofn_main_d1;
        $this->withcontent_tof_customfields = $this->dfp . $this->tofn_customfields_d1;
        $this->withcontent_tof_searchfields = $this->dfp . $this->tofn_searchfields_d1;
        $this->withcontent_tof_mailsettings = $this->dfp . $this->tofn_mailsettings_d1;

        $this->withcontent_content_demo = $this->dfp . $this->cfn_withcontent;
        $this->withcontent_widgets = $this->dfp . $this->wfn_withcontent;



        /* no content */
        $this->nocontent_tof_main = $this->dfp . $this->tofn_main_d2;
        $this->nocontent_tof_customfields = $this->dfp . $this->tofn_customfields_d2;
        $this->nocontent_tof_searchfields = $this->dfp . $this->tofn_searchfields_d2;
        $this->nocontent_tof_mailsettings = $this->dfp . $this->tofn_mailsettings_d2;

        $this->nocontent_content_demo = $this->dfp . $this->cfn_nocontent;



        /* Construction */
        $this->construction_tof_main = $this->dfp . $this->tofn_main_d3;
        $this->construction_tof_customfields = $this->dfp . $this->tofn_customfields_d3;
        $this->construction_tof_searchfields = $this->dfp . $this->tofn_searchfields_d3;
        $this->construction_tof_mailsettings = $this->dfp . $this->tofn_mailsettings_d3;
        $this->construction_tof_custompoints = $this->dfp . $this->tofn_custompoints_d3;

        $this->construction_content_demo = $this->dfp . $this->cfn_withcontent_d3;
        $this->construction_widgets = $this->dfp . $this->wfn_withcontent_d3;




        
        add_action( 'admin_menu', array($this, 'add_admin'),8);
        

        function load_customoptionpage_styles() {
            global $pagenow; global $post_type;
  

            $pagename = (isset($_GET['page']))?$_GET['page']:'';

            if ($pagenow == 'admin.php' && $pagename == 'pointfinder_demo_installer') {
                wp_register_script( 'pfcp-quickjs', get_template_directory_uri() . '/admin/quick_setup/js/script.js',  array('jquery'),true, '1.0.0' );
                wp_enqueue_script( 'pfcp-quickjs' );
                wp_localize_script( 'pfcp-quickjs', 'theme_quickjs', array( 
                  'ajaxurl' => get_template_directory_uri().'/admin/core/pfajaxhandler.php',
                  'pfget_quicksetupprocess' => wp_create_nonce('pfget_quicksetupprocess'),
                  'buttonwait' => esc_html__('Please wait...','pointfindert2d'),
                  'buttonok' => esc_html__('Run Quick Setup','pointfindert2d'),
                  'buttonerror' => esc_html__('An error occured.','pointfindert2d'),
                  'loadingimg' => get_template_directory_uri().'/images/info-loading.gif'
                ));
            }
        }
        add_action( 'admin_enqueue_scripts', 'load_customoptionpage_styles' );
    }
   

    public function add_admin() {

        add_submenu_page('pointfinder_tools', '', esc_html__("Quick Setup","pointfindert2d"), 'manage_options', 'pointfinder_demo_installer', array($this, 'pfd_demo_installer'));
    }

    public function pfd_demo_installer() {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

        if( 'pf-demo-data' == $action && check_admin_referer('pointfinder-quick-setup' , 'pfqsetup')){
        ?>
        <div class="wrap about-wrap">

          <h1><?php echo esc_html__('Welcome to PointFinder','pointfindert2d');?></h1>

          <div class="about-text"><?php echo esc_html__('Quick setup done!','pointfindert2d');?></div>

          <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('admin.php?page=pointfinder_tools');?>" class="nav-tab nav-tab">
           <?php echo esc_html__('Instruction','pointfindert2d');?></a>
            <a href="<?php echo admin_url('admin.php?page=pointfinder_demo_installer');?>" class="nav-tab nav-tab-active">
               <?php echo esc_html__('Result','pointfindert2d');?></a>
          </h2>
          <div style="margin:20px 0;padding: 0;color: #494949; width:100%; line-height:18px;font-size:13px"><p class="tie_message_hint">
          <?php
              $pf_setup_mode = isset($_REQUEST['pf_setup_mode']) ? $_REQUEST['pf_setup_mode'] : '';
              

              if (empty($pf_setup_mode)) {wp_die(esc_html__( 'Setup Mode not selected. Please try again.', 'pointfindert2d' ),'',array( 'back_link' => true ));}

              add_option('pf_quick_setup',1 );

              switch ($pf_setup_mode) {
                case '1':
                    /* Real Estate : Admin Options */
                    $this->set_demo_data( $this->realestate_content_demo );

                    $this->set_demo_theme_options( $this->realestate_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->realestate_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->realestate_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->realestate_tof_searchfields, 3 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->realestate_tof_custompoints, 5 ,$pf_setup_mode);

                    $this->process_widget_import_file( $this->realestate_widgets );

                    $this->pf_set_demo_menus();

                    $page_number = get_page_by_title('Home Page','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    /* CSS dosyalarını çalıştır. */
                    add_option( 'pointfinder_cssstyle','realestate' );
                    global $wpdb;
                    $megamenu_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",46));
                    $hide_id1 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",47));
                    $hide_id2 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",54));
                    $hide_id3 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",61));
                    $hide_id4 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",68));

                    update_post_meta( $megamenu_id, '_menu_item_megamenu', 1 );
                    update_post_meta( $megamenu_id, '_menu_item_columnvalue', 4 );

                    update_post_meta( $hide_id1, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id2, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id3, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id4, '_menu_item_megamenu_hide', 1 );
                  break;
                
                case '2':
                    /* Directory : Admin Options */
                    $this->set_demo_data( $this->directory_content_demo );

                    $this->set_demo_theme_options( $this->directory_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory_tof_searchfields, 3 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory_tof_custompoints, 5 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory_tof_reviews, 6 ,$pf_setup_mode);

                    $this->process_widget_import_file( $this->directory_widgets );

                    $this->pf_set_other_menus();

                    $page_number = get_page_by_title('Home Page','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    add_option( 'pointfinder_cssstyle','directory' );
                  break;

                 case '7':
                    /* Multi Directory : Admin Options */
                    $this->set_demo_data( $this->directory2_content_demo );

                    $this->set_demo_theme_options( $this->directory2_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory2_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory2_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory2_tof_searchfields, 3 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory2_tof_custompoints, 5 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory2_tof_reviews, 6 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->directory2_tof_advanced, 7 ,$pf_setup_mode);

                    $this->process_widget_import_file( $this->directory2_widgets );

                    $this->pf_set_other_menus();

                    
                    $page_number = get_page_by_title('Home Page + Mini Search','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    add_option( 'pointfinder_cssstyle','multidirectory' );

                    global $wpdb;
                    $megamenu_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",12));
                    $hide_id1 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",13));
                    $hide_id2 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",20));
                    $hide_id3 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",27));
                    $hide_id4 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",34));
                    $megamenu_id2 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",41));
                    $hide_id5 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",56));
                    $hide_id6 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",72));

                    update_post_meta( $megamenu_id, '_menu_item_megamenu', 1 );
                    update_post_meta( $megamenu_id, '_menu_item_columnvalue', 4 );

                    update_post_meta( $megamenu_id2, '_menu_item_megamenu', 1 );
                    update_post_meta( $megamenu_id2, '_menu_item_columnvalue', 4 );

                    update_post_meta( $hide_id1, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id2, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id3, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id4, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id5, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id6, '_menu_item_megamenu_hide', 1 );

                  break;

                case '3':
                    /* Car Dealer : Admin Options */
                    $this->set_demo_data( $this->cardealer_content_demo );

                    $this->set_demo_theme_options( $this->cardealer_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->cardealer_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->cardealer_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->cardealer_tof_searchfields, 3 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->cardealer_tof_custompoints, 5 ,$pf_setup_mode);

                    $this->process_widget_import_file( $this->cardealer_widgets );

                    $this->pf_set_other_menus();

                    $page_number = get_page_by_title('Home','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    add_option( 'pointfinder_cssstyle','cardealer' );
                  break;

                case '5':
                    /* Demo with demo content */
                    $this->set_demo_data( $this->withcontent_content_demo );

                    $this->set_demo_theme_options( $this->withcontent_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->withcontent_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->withcontent_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->withcontent_tof_searchfields, 3 ,$pf_setup_mode);

                    $this->process_widget_import_file( $this->withcontent_widgets );

                    $this->pf_set_other_menus();

                    $page_number = get_page_by_title('Home Page','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    add_option( 'pointfinder_cssstyle','realestate' );
                    global $wpdb;
                    $megamenu_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",46));
                    $hide_id1 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",47));
                    $hide_id2 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",54));
                    $hide_id3 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",61));
                    $hide_id4 = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts where post_type = %s and menu_order = %d","nav_menu_item",68));

                    update_post_meta( $megamenu_id, '_menu_item_megamenu', 1 );
                    update_post_meta( $megamenu_id, '_menu_item_columnvalue', 4 );

                    update_post_meta( $hide_id1, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id2, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id3, '_menu_item_megamenu_hide', 1 );
                    update_post_meta( $hide_id4, '_menu_item_megamenu_hide', 1 );
                  break;

                case '4':
                    /* Demo without demo content */
                    $this->set_demo_data( $this->nocontent_content_demo );

                    $this->set_demo_theme_options( $this->nocontent_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->nocontent_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->nocontent_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->nocontent_tof_searchfields, 3 ,$pf_setup_mode);

                    $this->pf_set_other_menus();

                    $page_number = get_page_by_title('Home Page','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    add_option( 'pointfinder_cssstyle','realestate' );
                  break;

                case '6':
                    /* Construction */
                    $this->set_demo_data( $this->construction_content_demo );

                    $this->set_demo_theme_options( $this->construction_tof_main, 1 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->construction_tof_mailsettings, 4 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->construction_tof_customfields, 2 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->construction_tof_searchfields, 3 ,$pf_setup_mode);
                    $this->set_demo_theme_options( $this->construction_tof_custompoints, 5 ,$pf_setup_mode);
                    
                    $this->process_widget_import_file( $this->construction_widgets );

                    $this->pf_set_other_menus();

                    $page_number = get_page_by_title('Home Page','OBJECT','page');

                    if (isset($page_number)) {
                      $page_number = $page_number->ID;
                    }else{
                      $page_number = 7;
                    }
                    add_option( 'pointfinder_cssstyle','construction' );
                  break;

              }

              /* Set Home Pages */
              $page_on_front = get_option('page_on_front');
              $show_on_front = get_option('show_on_front');
              if (false !== $page_on_front) {update_option( 'page_on_front', $page_number );}else{add_option( 'page_on_front', $page_number );}
              if ($show_on_front ==! false) {update_option( 'show_on_front', 'page' );}else{add_option( 'show_on_front', 'page' );}

          ?>
          </p></div>
        </div>
        <?php
        }else{
        ?>
        <div class="wrap about-wrap">

          <h1><?php echo esc_html__('Welcome to PointFinder','pointfindert2d');?></h1>

          <div class="about-text"><?php echo esc_html__('Thank you for purchase Point Finder! You can setup theme quickly by using the installer below.','pointfindert2d');?></div>

          <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('admin.php?page=pointfinder_tools');?>" class="nav-tab nav-tab">
           <?php echo esc_html__('Instruction','pointfindert2d');?></a>
            <a href="<?php echo admin_url('admin.php?page=pointfinder_demo_installer');?>" class="nav-tab nav-tab-active">
               <?php echo esc_html__('Quick Setup','pointfindert2d');?></a>
          </h2>
          
          <?php
          
          if ( is_plugin_active('redux-framework/redux-framework.php') ) {
            $is_pfsetup_done = get_option('pf_quick_setup');
            if (isset($is_pfsetup_done) && $is_pfsetup_done == 1) {
            ?>
              <div style="margin:20px 0;padding: 0;color: #494949; width:100%; line-height:18px;font-size:13px"><p class="tie_message_hint">
              <strong><?php echo esc_html__('This setup was already run before.','pointfindert2d');?></strong>
              </p></div>

              <div style="margin:20px 0;padding: 0;color: #494949; width:100%; line-height:18px;font-size:13px"><p class="tie_message_hint">
              <?php echo esc_html__('If you make a mistake and install theme with wrong mode don’t worry you can still change it. Please follow below steps and reset all wp settings. Then re run quick setup.','pointfindert2d');?>
              <?php
                $wpaction = 'install-plugin';
                $wpslug = 'wordpress-reset';
                $wpurl = wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => $wpaction,
                            'plugin' => $wpslug
                        ),
                        admin_url( 'update.php' )
                    ),
                    $wpaction.'_'.$wpslug
                );
              ?>
              <ol>
                <li><?php echo sprintf(esc_html__('Install & Activate %s WordPress Reset Plugin %s','pointfindert2d'),'<a href="'.$wpurl.'">','</a>');?></li>
                <li><?php echo esc_html__('After activate this plugin go to Tools > Reset section','pointfindert2d');?></li>
                <li><?php echo esc_html__('Type “reset” to the box and apply reset action.','pointfindert2d');?></li>
                <li><?php echo esc_html__('Now all your wordpress data cleaned. Please of PF Settings > Quick Setup and re install it.','pointfindert2d');?></li>
              </ol>

              <?php echo __('<strong>Note:</strong> This plugin will reset all your saved settings. I do not recommend to use this plugin, if you begin to use site.','pointfindert2d');?>
              </p></div>
            <?php
            }else{
            ?>

              <div class="changelog headline-feature" style="margin-left:0">
                <div style="margin:20px 0;padding: 0;color: #494949;width:100%; line-height:18px;font-size:13px">
                    <p class="tie_message_hint"><?php echo esc_html__('Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will
                    allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:','pointfindert2d');?></p>
                      <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
                          <li><?php echo esc_html__('No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified .','pointfindert2d');?></li>
                          <li><?php echo esc_html__('No WordPress settings will be modified .','pointfindert2d');?></li>
                          <li><?php echo esc_html__('Posts, pages, some images, some widgets and menus will get imported .','pointfindert2d');?></li>
                          <li style="font-weight:bold;"><?php echo esc_html__('Please select Setup Mode carefully! Site admin options & custom fields will be imported with this setting.','pointfindert2d');?></li>
                          <li style="font-weight:bold;"><?php echo esc_html__("DEMO IMAGES DOESN'T INCLUDED TO THE QUICK SETUP. AFTER SETUP YOU WILL GET ONLY DEMO SITE WITHOUT DEMO IMAGES!",'pointfindert2d');?></li>
                      </ul>
                </div>

                <form method="post" id="pfqsform">
                <table class="form-table">
                  <tbody>
                  
                  <tr>
                    <th scope="row"><?php echo esc_html__('Select Setup Mode','pointfindert2d');?></th>
                    <td id="front-static-pages">
                      <label for="page_on_front">
                        <select name="pf_setup_mode" id="pf_setup_mode">
                          <option value="0"><?php echo esc_html__('Please select','pointfindert2d');?></option>
                          <option value="4"><?php echo esc_html__('Default without Demo Content','pointfindert2d');?></option>
                          <option value="5"><?php echo esc_html__('Default with Demo Content','pointfindert2d');?></option>
                          <option value="7"><?php echo esc_html__('Multi Directory with Demo Content','pointfindert2d');?></option>
                          <option value="1"><?php echo esc_html__('Real Estate with Demo Content','pointfindert2d');?></option>
                          <option value="2"><?php echo esc_html__('Directory with Demo Content','pointfindert2d');?></option>
                          <option value="3"><?php echo esc_html__('Car Dealer with Demo Content','pointfindert2d');?></option>
                          <option value="6"><?php echo esc_html__('Construction with Demo Content','pointfindert2d');?></option>
                        </select>
                      </label> 
                     
                    </td>
                  </tr>

                  </tbody>
                </table>
                    <input type="hidden" name="pfqsetup" value="<?php echo wp_create_nonce('pointfinder-quick-setup'); ?>" />
                    <input name="importformbutton" id="pfimportformbutton" class="panel-save button-primary" type="submit" value="<?php echo esc_html__('Run Quick Setup','pointfindert2d');?>" />
                    <div class="pfclloading" style="background-size: 24px 24px!important;background-repeat: no-repeat!important;background-position: right!important;width: 24px;height: 24px;display: inline-block;margin-left: 20px;vertical-align: middle;background-size: 24px 24px!important;"></div>
                    <input type="hidden" name="action" value="pf-demo-data" />
                </form>
                <br />
                <br />
              <?php } ?>

            <?php }else{?>
            <div style="margin:20px 0;padding: 0;color: #494949; width:100%; line-height:18px;font-size:13px"><p class="tie_message_hint">
            <?php echo esc_html__('Please install & activate required plugins. Then you can use quick setup.','pointfindert2d');?><br>
            <b><?php echo esc_html__('How to setup required plugins?','pointfindert2d');?></b><br>
            <iframe width="560" height="315" src="http://www.youtube.com/embed/1MuJ5Xv_XqM" frameborder="0" allowfullscreen=""></iframe>
            </p></div>
            <?php } ?>


            <div class="clear"></div>
          </div>

        </div>

        <?php
      }

    }

    public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()){

        $sidebars_widgets = get_option('sidebars_widgets');

        if(!isset($sidebars_widgets[$sidebar_slug]))
           $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

        $newWidget = get_option('widget_'.$widget_slug);

        if(!is_array($newWidget))
            $newWidget = array();

        $count = count($newWidget)+1+$count_mod;
        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

        $newWidget[$count] = $widget_settings;

        update_option('sidebars_widgets', $sidebars_widgets);
        update_option('widget_'.$widget_slug, $newWidget);

    }

    public function set_demo_data( $file ) {

      if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

        require_once ABSPATH . 'wp-admin/includes/import.php';

        $importer_error = false;

        if ( !class_exists( 'WP_Importer' ) ) {

            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
  
            if ( file_exists( $class_wp_importer ) ){

                require_once($class_wp_importer);

            } else {

                $importer_error = true;

            }

        }

        if ( !class_exists( 'WP_Import' ) ) {

            $class_wp_import = dirname( __FILE__ ) .'/wordpress-importer.php';

            if ( file_exists( $class_wp_import ) ) 
                require_once($class_wp_import);
            else
                $importer_error = true;

        }

        if($importer_error){

            die("Error on import");

        } else {
      
            if(!is_file( $file )){

                echo esc_html__("The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ", 'pointfindert2d' );

            } else {

               $wp_import = new WP_Import();
               $wp_import->fetch_attachments = true;
               $wp_import->import( $file );

          }

      }

    }

    public function pf_set_demo_menus() {}

    public function set_demo_theme_options( $file , $type ,$pf_setup_mode) {

      // File exists?
      if ( ! file_exists( $file ) ) {
        wp_die(
          esc_html__( 'Theme options Import file could not be found. Please try again.', 'pointfindert2d' ),
          '',
          array( 'back_link' => true )
        );
      }

      /*
       
        // Have valid data?
        // If no data or could not decode) 

       
        // Hook before import
      */

      switch ($type) {
        case '1':
          // Get file contents and decode
          $data = file_get_contents( $file );

          /* Define dashboard page */
          
          $dashboard_page_name = get_page_by_title('Dashboard','OBJECT','page');
          if (isset($dashboard_page_name)) {
            $data = str_replace('"setup4_membersettings_dashboard":"4"', '"setup4_membersettings_dashboard":"'.$dashboard_page_name->ID.'"', $data);
          }


          $data = json_decode($data,true);
          $statusofthis = update_option($this->theme_option_name, $data);
          if ($statusofthis) {
            echo esc_html__( 'PF Options done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Options NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;

        case '2':
          // Get file contents and decode
          $data = file_get_contents( $file );

          /* Define new term ids */
          if ($pf_setup_mode == 1) {

            $term_forsale = term_exists('For Sale','pointfinderltypes');
            $term_forrent = term_exists('For Rent','pointfinderltypes');

            if (isset($term_forsale['term_taxonomy_id'])) {
              $data = str_replace('_parent":["2"]', '_parent":["'.$term_forsale['term_taxonomy_id'].'"]', $data);
            }

            if (isset($term_forrent['term_taxonomy_id'])) {
              $data = str_replace('_parent":["3"]', '_parent":["'.$term_forrent['term_taxonomy_id'].'"]', $data);
            }

          }

          $data = json_decode($data,true);

          $statusofthis = update_option($this->theme_option_name_c, $data);
          if ($statusofthis) {
            echo esc_html__( 'PF Custom Fields done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Custom Fields NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;

        case '3':
          // Get file contents and decode
          $data = file_get_contents( $file );
          $data = json_decode($data,true);
          $statusofthis = update_option($this->theme_option_name_s, $data);
          if ($statusofthis) {
            echo esc_html__( 'PF Search Fields done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Search Fields NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;

        case '4':
          // Get file contents and decode
          $data = file_get_contents( $file );
          $data = json_decode($data,true);
          $statusofthis = update_option($this->theme_option_name_m, $data);
          if ($statusofthis) {
            echo esc_html__( 'PF Mail System done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Mail System NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;

        case '5':
          // Get file contents and decode
          $data = file_get_contents( $file );

          /* Define new term ids */
          if ($pf_setup_mode == 1) {

            $term_forsale = term_exists('For Sale','pointfinderltypes');
            $term_forrent = term_exists('For Rent','pointfinderltypes');

            if (isset($term_forsale['term_taxonomy_id'])) {
              $data = str_replace('pscp_2', 'pscp_'.$term_forsale['term_taxonomy_id'], $data);
            }

            if (isset($term_forrent['term_taxonomy_id'])) {
              $data = str_replace('pscp_3', 'pscp_'.$term_forrent['term_taxonomy_id'], $data);
            }

          }

          $data = json_decode($data,true);

          $statusofthis = update_option($this->theme_option_name_cp, $data);

          if ($statusofthis) {
            echo esc_html__( 'PF Custom Points done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Custom Points NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;
        case '6':
          // Get file contents and decode
          $data = file_get_contents( $file );
          $data = json_decode($data,true);
          $statusofthis = update_option($this->theme_option_name_re, $data);
          if ($statusofthis) {
            echo esc_html__( 'PF Review System done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Review System NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;
        case '7':
          // Get file contents and decode
          $data = file_get_contents( $file );
          $data = json_decode($data,true);
          $statusofthis = update_option($this->theme_option_name_ad, $data);
          if ($statusofthis) {
            echo esc_html__( 'PF Advanced Listing System done.', 'pointfindert2d' ).'<br/>';
          }else{
            echo esc_html__( 'PF Advanced Listing System NOT done.', 'pointfindert2d' ).'<br/>';          
          }
          break;
      }

    }

    function available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ( $widget_controls as $widget ) {

          if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

            $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
            $available_widgets[$widget['id_base']]['name'] = $widget['name'];

          }

        }

        return apply_filters( 'pointfinder_theme_import_widget_available_widgets', $available_widgets );

    }

    function process_widget_import_file( $file ) {

      // File exists?
      if ( ! file_exists( $file ) ) {
        wp_die(esc_html__( 'Widget Import file could not be found. Please try again.', 'pointfindert2d' ),'',array( 'back_link' => true ));
      }

      // Get file contents and decode
      $data = file_get_contents( $file );
      $data = json_decode( $data );
      
      $this->widget_import_results = $this->import_widgets( $data );

    }

    public function import_widgets( $data ) {

      global $wp_registered_sidebars;

      // Have valid data?
      // If no data or could not decode
      if ( empty( $data ) || ! is_object( $data ) ) {wp_die(esc_html__( 'Widget import data could not be read. Please try a different file.', 'pointfindert2d' ),'',array( 'back_link' => true ));}

      // Hook before import
      $data = apply_filters( 'pointfinder_theme_import_widget_data', $data );

      // Get all available widgets site supports
      $available_widgets = $this->available_widgets();

      // Get all existing widget instances
      $widget_instances = array();
      foreach ( $available_widgets as $widget_data ) {
        $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
      }

      // Begin results
      $results = array();

      // Loop import data's sidebars
      foreach ( $data as $sidebar_id => $widgets ) {

        // Skip inactive widgets
        // (should not be in export file)
        if ( 'wp_inactive_widgets' == $sidebar_id ) {
          continue;
        }

        // Check if sidebar is available on this site
        // Otherwise add widgets to inactive, and say so
        if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
          $sidebar_available = true;
          $use_sidebar_id = $sidebar_id;
          $sidebar_message_type = 'success';
          $sidebar_message = '';
        } else {
          $sidebar_available = false;
          $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
          $sidebar_message_type = 'error';
          $sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'pointfindert2d' );
        }

        // Result for sidebar
        $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
        $results[$sidebar_id]['message_type'] = $sidebar_message_type;
        $results[$sidebar_id]['message'] = $sidebar_message;
        $results[$sidebar_id]['widgets'] = array();

        // Loop widgets
        foreach ( $widgets as $widget_instance_id => $widget ) {

          $fail = false;

          // Get id_base (remove -# from end) and instance ID number
          $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
          $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

          // Does site support this widget?
          if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
            $fail = true;
            $widget_message_type = 'error';
            $widget_message = esc_html__( 'Site does not support widget', 'pointfindert2d' ); // explain why widget not imported
          }

          // Filter to modify settings before import
          // Do before identical check because changes may make it identical to end result (such as URL replacements)
          $widget = apply_filters( 'pointfinder_theme_import_widget_settings', $widget );

          // Does widget with identical settings already exist in same sidebar?
          if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

            // Get existing widgets in this sidebar
            $sidebars_widgets = get_option( 'sidebars_widgets' );
            $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

            // Loop widgets with ID base
            $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
            foreach ( $single_widget_instances as $check_id => $check_widget ) {

              // Is widget in same sidebar and has identical settings?
              if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

                $fail = true;
                $widget_message_type = 'warning';
                $widget_message = esc_html__( 'Widget already exists', 'pointfindert2d' ); // explain why widget not imported

                break;

              }

            }

          }

          // No failure
          if ( ! $fail ) {

            // Add widget instance
            $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
            $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
            $single_widget_instances[] = (array) $widget; // add it

              // Get the key it was given
              end( $single_widget_instances );
              $new_instance_id_number = key( $single_widget_instances );

              // If key is 0, make it 1
              // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
              if ( '0' === strval( $new_instance_id_number ) ) {
                $new_instance_id_number = 1;
                $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                unset( $single_widget_instances[0] );
              }

              // Move _multiwidget to end of array for uniformity
              if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                $multiwidget = $single_widget_instances['_multiwidget'];
                unset( $single_widget_instances['_multiwidget'] );
                $single_widget_instances['_multiwidget'] = $multiwidget;
              }

              // Update option with new widget
              update_option( 'widget_' . $id_base, $single_widget_instances );

            // Assign widget instance to sidebar
            $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
            $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
            $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
            update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

            // Success message
            if ( $sidebar_available ) {
              $widget_message_type = 'success';
              $widget_message = esc_html__( 'Imported', 'pointfindert2d' );
            } else {
              $widget_message_type = 'warning';
              $widget_message = esc_html__( 'Imported to Inactive', 'pointfindert2d' );
            }

          }

          // Result for widget instance
          $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
          $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = (isset($widget->title))? $widget->title : esc_html__( 'No Title', 'pointfindert2d' );
          $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
          $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

        }

      }

      // Hook after import
      do_action( 'pointfinder_theme_import_widget_after_import' );

      // Return results
      return apply_filters( 'pointfinder_theme_import_widget_results', $results );

    }

}

?>