<?php
/**********************************************************************************************************************************
*
* Ajax Quick Setup Process
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_quicksetupprocess', 'pf_ajax_quicksetupprocess' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_quicksetupprocess', 'pf_ajax_quicksetupprocess' );

function pf_ajax_quicksetupprocess(){
  
	//Security
	check_ajax_referer( 'pfget_quicksetupprocess', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

	$fav_item = $fav_active = '';
	$results = array();

	if(isset($_POST['myval']) && $_POST['myval']!=''){
		$myval = esc_attr($_POST['myval']);
	}

	if ($myval) {
		global $pointfinder_main_options_fw;
		global $pointfinder_main_options_sb;
		switch ($myval) {
			case 1:
				$json_sidebar = '{"1":{"title":"Footer Row 1","url":"2a71f3bb7b87b918080d4bb52f71fc41","sort":"2"},"2":{"title":"Footer Row 2","url":"fe40854170224f62cd9431542bbd6c3f","sort":"3"},"3":{"title":"Footer Row 3","url":"621eeb90603ad963bd8c7a7b8876c55c","sort":"4"},"4":{"title":"Footer Row 4","url":"9dcae1b8d323f04a55fb4e8e7023eabe","sort":"5"}}';
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'properties');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt11', 'pftestimonials');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pt14_check', '1');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pt14', 'conditions');
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', json_decode($json_sidebar,true));				
				break;
			case 2:
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'places');
				break;
			case 7:
				$json_sidebar = '{"1":{"title":"Footer Row 1","url":"2a71f3bb7b87b918080d4bb52f71fc41","sort":"2"},"2":{"title":"Footer Row 2","url":"fe40854170224f62cd9431542bbd6c3f","sort":"3"},"3":{"title":"Footer Row 3","url":"621eeb90603ad963bd8c7a7b8876c55c","sort":"4"},"4":{"title":"Footer Row 4","url":"9dcae1b8d323f04a55fb4e8e7023eabe","sort":"5"},"7":{"title":"Real Estate Item Sidebar","url":"field811922713182866600000","sort":"6"},"8":{"title":"General Item Sidebar","url":"field397038915194571000000","sort":"7"}}';
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'listing');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pt14_check', 1);
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', json_decode($json_sidebar,true));
				break;
			case 3:
				$json_sidebar = '{"1":{"title":"Footer Row 1","url":"2a71f3bb7b87b918080d4bb52f71fc41","sort":"0"},"2":{"title":"Footer Row 2","url":"fe40854170224f62cd9431542bbd6c3f","sort":"1"},"3":{"title":"Footer Row 3","url":"621eeb90603ad963bd8c7a7b8876c55c","sort":"2"},"4":{"title":"Footer Row 4","url":"9dcae1b8d323f04a55fb4e8e7023eabe","sort":"3"}}';
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'cars');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt8', 'dealers');
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', json_decode($json_sidebar,true));
				break;
			case 4:
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'pfitemfinder');
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', array());
				break;
			case 5:
				$json_sidebar = '{"1":{"title":"Footer Row 1","url":"2a71f3bb7b87b918080d4bb52f71fc41","sort":"2"},"2":{"title":"Footer Row 2","url":"fe40854170224f62cd9431542bbd6c3f","sort":"3"},"3":{"title":"Footer Row 3","url":"621eeb90603ad963bd8c7a7b8876c55c","sort":"4"},"4":{"title":"Footer Row 4","url":"9dcae1b8d323f04a55fb4e8e7023eabe","sort":"5"}}';
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'properties');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt11', 'pftestimonials');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pt14_check', '1');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pt14', 'conditions');
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', json_decode($json_sidebar,true));
				break;
			case 6:
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'projects');
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt8', 'company');
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', array());
				break;
			default:
				$pointfinder_main_options_fw->ReduxFramework->set('setup3_pointposttype_pt1', 'pfitemfinder');
				$pointfinder_main_options_sb->ReduxFramework->set('setup25_sidebargenerator_sidebars', array());		
				break;
		}
		echo json_encode( array( 'process'=>true, 'mes'=>$myval));
	}else{
		echo json_encode( array( 'process'=>false, 'mes'=>'novalue'));
	}

	
die();
}

?>