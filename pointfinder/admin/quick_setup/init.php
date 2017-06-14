<?php
/**********************************************************************************************************************************
*
* PF Quick Installer
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

require_once(  dirname( __FILE__ ) .'/importer/radium-importer.php' ); 
require_once(  dirname( __FILE__ ) .'/ajax-process.php' ); 

class PointFinder_Demo_Data_Importer extends PointFinder_Theme_Importer {

    private static $instance;

    public $theme_option_name = 'pointfindertheme_options';
    public $theme_option_name_c = 'pfcustomfields_options';
    public $theme_option_name_s = 'pfsearchfields_options';
    public $theme_option_name_m = 'pointfindermail_options';
    public $theme_option_name_cp = 'pfcustompoints_options';
    public $theme_option_name_re = 'pfitemreviewsystem_options';
    public $theme_option_name_ad = 'pfadvancedcontrol_options';


    /* Real Estates 
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main = 'realestate/theme_options.txt';
	public $tofn_customfields = 'realestate/theme_options_customfields.txt';
	public $tofn_searchfields = 'realestate/theme_options_searchfields.txt';
	public $tofn_mailsettings = 'realestate/theme_options_mail.txt';
	public $tofn_custompoints = 'realestate/theme_options_custompoints.txt';
	public $wfn_realestate =  'realestate/widgets.json';
	public $cfn_realestate = 'realestate/content.xml';

	/* Directory
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main_d = 'directory/theme_options.txt';
	public $tofn_customfields_d = 'directory/theme_options_customfields.txt';
	public $tofn_searchfields_d = 'directory/theme_options_searchfields.txt';
	public $tofn_mailsettings_d = 'directory/theme_options_mail.txt';
	public $tofn_custompoints_d = 'directory/theme_options_custompoints.txt';
	public $tofn_reviews_d = 'directory/theme_options_reviews.txt';
	public $wfn_directory =  'directory/widgets.json';
	public $cfn_directory = 'directory/content.xml';


	/* Multi Directory
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main_dm2 = 'multidirectory/theme_options.txt';
	public $tofn_customfields_dm2 = 'multidirectory/theme_options_customfields.txt';
	public $tofn_searchfields_dm2 = 'multidirectory/theme_options_searchfields.txt';
	public $tofn_mailsettings_dm2 = 'multidirectory/theme_options_mail.txt';
	public $tofn_custompoints_dm2 = 'multidirectory/theme_options_custompoints.txt';
	public $tofn_advanced_dm2 = 'multidirectory/theme_options_advanced.txt';
	public $tofn_reviews_dm2 = 'multidirectory/theme_options_reviews.txt';
	public $wfn_directorym2 =  'multidirectory/widgets.json';
	public $cfn_directorym2 = 'multidirectory/content.xml';



	/* Car Dealer
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main_c = 'cardealer/theme_options.txt';
	public $tofn_customfields_c = 'cardealer/theme_options_customfields.txt';
	public $tofn_searchfields_c = 'cardealer/theme_options_searchfields.txt';
	public $tofn_mailsettings_c = 'cardealer/theme_options_mail.txt';
	public $tofn_custompoints_c = 'cardealer/theme_options_custompoints.txt';
	public $wfn_cardealer =  'cardealer/widgets.json';
	public $cfn_cardealer = 'cardealer/content.xml';



	/* Default With Content
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main_d1 = 'withcontent/theme_options.txt';
	public $tofn_customfields_d1 = 'withcontent/theme_options_customfields.txt';
	public $tofn_searchfields_d1 = 'withcontent/theme_options_searchfields.txt';
	public $tofn_mailsettings_d1 = 'withcontent/theme_options_mail.txt';
	public $wfn_withcontent =  'withcontent/widgets.json';
	public $cfn_withcontent = 'withcontent/content.xml';


	/* Default With NO Content
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main_d2 = 'nocontent/theme_options.txt';
	public $tofn_customfields_d2 = 'nocontent/theme_options_customfields.txt';
	public $tofn_searchfields_d2 = 'nocontent/theme_options_searchfields.txt';
	public $tofn_mailsettings_d2 = 'nocontent/theme_options_mail.txt';
	public $wfn_nocontent =  'nocontent/widgets.json';
	public $cfn_nocontent = 'nocontent/content.xml';



	/* Construction Mode
	tofn : Theme option file name
	mfn : menu file name
	cfn : content file name
	wfn : widget file name
    */
	public $tofn_main_d3 = 'construction/theme_options.txt';
	public $tofn_customfields_d3 = 'construction/theme_options_customfields.txt';
	public $tofn_searchfields_d3 = 'construction/theme_options_searchfields.txt';
	public $tofn_custompoints_d3 = 'construction/theme_options_custompoints.txt';
	public $tofn_mailsettings_d3 = 'construction/theme_options_mail.txt';
	public $wfn_withcontent_d3 =  'construction/widgets.json';
	public $cfn_withcontent_d3 = 'construction/content.xml';



	public $widget_import_results;
    public function __construct() {
    
		$this->dfp = dirname(__FILE__) . '/demo-files/';

        self::$instance = $this;
		parent::__construct();

    }
	
	public function pf_set_demo_menus(){
	
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
		$footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');

		set_theme_mod( 'nav_menu_locations', array(
                'pointfinder-main-menu' => $main_menu->term_id,
                'pointfinder-footer-menu' => $footer_menu->term_id
            )
        );

	}

	public function pf_set_other_menus(){
	
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
		$footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');

		set_theme_mod( 'nav_menu_locations', array(
                'pointfinder-main-menu' => $main_menu->term_id,
                'pointfinder-footer-menu' => $footer_menu->term_id
            )
        );

	}

}

new PointFinder_Demo_Data_Importer;