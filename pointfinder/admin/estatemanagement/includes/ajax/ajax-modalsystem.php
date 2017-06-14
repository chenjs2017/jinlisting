<?php
/**********************************************************************************************************************************
*
* Ajax Modal System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
add_action( 'PF_AJAX_HANDLER_pfget_modalsystem', 'pf_ajax_modalsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_modalsystem', 'pf_ajax_modalsystem' );

function pf_ajax_modalsystem(){
  check_ajax_referer( 'pfget_modalsystem', 'security'); 
	header('Content-Type: text/html; charset=UTF-8;');
  if(isset($_POST['formtype']) && $_POST['formtype']!=''){$formtype = esc_attr($_POST['formtype']);}
  if(isset($_POST['itemid']) && $_POST['itemid']!=''){
    $itemid = esc_attr($_POST['itemid']);
    $itemname = ($itemid != '') ? get_the_title($itemid) : '' ;
  }else{$itemid = $itemname = '';}
  if(isset($_POST['userid']) && $_POST['userid']!=''){$userid = esc_attr($_POST['userid']);}else{$userid = '';}
  $pfrecheck = PFRECIssetControl('setupreCaptcha_general_status','','0');
  if ($pfrecheck == 1) {$recaptcha2 = '<section><div id="recaptcha_div_mod">'.PFreCaptchaWidget().'</div></section>';}else{$recaptcha2 = '';}

	switch($formtype){
/**
*Enquiry Form
**/
	case 'enquiryform':
  $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_con_agent_status','','0');
  if ( $pfrecheck == 1 && $pfrechecklg != 1) {$recaptcha2 = '';}

  $val1 = $val2 = $val3 = '';

  if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $val2 = $current_user->user_email;

    $val1 = get_user_meta($user_id, 'first_name', true);
    $val1 .= ' '.get_user_meta($user_id, 'last_name', true);
    
    $val3 = get_user_meta($user_id, 'user_mobile', true);
    if ($val3 == '') {
      $val3 = get_user_meta($user_id, 'user_phone', true);
    }
    $namefield = '<section><label class="lbl-ui"><input type="hidden" name="name" class="input" placeholder="" value="'.$val1.'" /></label></section>';
    $emailfield = '<section><label class="lbl-ui"><input type="hidden" name="email" class="input" placeholder="" value="'.$val2.'"/></label></section>';
    $phonefield = '<section><label class="lbl-ui"><input type="hidden" name="phone" class="input" placeholder="" value="'.$val3.'"/></label></section>';
  }else{
    $namefield = '<section><label for="names" class="lbl-text">'.esc_html__('Name  & Surname','pointfindert2d').':</label><label class="lbl-ui"><input type="text" name="name" class="input" placeholder=""/></label></section>';
    $emailfield = '<section><label for="email" class="lbl-text">'.esc_html__('Email Address','pointfindert2d').':</label><label class="lbl-ui"><input type="email" name="email" class="input" placeholder=""/></label></section>';
    $phonefield = '';
  }
  ?><div class="golden-forms wrapper mini"><div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-enquiry-form"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Contact Form','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><section><label for="name" class="lbl-text"><?php echo esc_html__('Form Info','pointfindert2d');?>:</label><label class="lbl-ui"><?php echo $itemname;?></label></section><?php echo $namefield;echo $emailfield;echo $phonefield;?><section><label for="phone" class="lbl-text"><?php echo esc_html__('Phone (Optional)','pointfindert2d');?>:</label><label class="lbl-ui"><input type="tel" name="phone" class="input" placeholder="" value="<?php echo $val3;?>"/></label></section><section><label for="msg" class="lbl-text"><?php echo esc_html__('Message','pointfindert2d');?>:</label><label class="lbl-ui"><textarea name="msg" class="textarea no-resize" ></textarea></label></section> <?php echo $recaptcha2;?></div></div><div class="form-buttons"><section><input type="hidden" name="itemid" class="input" value="<?php echo $itemid;?>"/><button id="pf-ajax-enquiry-button" class="button blue"><?php echo esc_html__('Send Contact Form','pointfindert2d');?></button></section></div></form></div>			
    <?php
		break;

/**
*Enquiry Form Author
**/
  case 'enquiryformauthor':
  $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_con_agent_status','','0');
  if ( $pfrecheck == 1 && $pfrechecklg != 1) {
    $recaptcha2 = '';
  }

  $val1 = $val2 = $val3 = '';

  if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $val2 = $current_user->user_email;

    $val1 = get_user_meta($user_id, 'first_name', true);
    $val1 .= ' '.get_user_meta($user_id, 'last_name', true);

    if (empty($val1)) {
      $val1 = $current_user->user_login;
    }
    
    $val3 = get_user_meta($user_id, 'user_mobile', true);
    if ($val3 == '') {
      $val3 = get_user_meta($user_id, 'user_phone', true);
    }  
    $namefield = '<section><label class="lbl-ui"><input type="hidden" name="name" class="input" placeholder="" value="'.$val1.'" /></label></section>';
    $emailfield = '<section><label class="lbl-ui"><input type="hidden" name="email" class="input" placeholder="" value="'.$val2.'"/></label></section>';
  }else{
    $namefield = '<section><label for="names" class="lbl-text">'.esc_html__('Name  & Surname','pointfindert2d').':</label><label class="lbl-ui"><input type="text" name="name" class="input" placeholder=""/></label></section>';
    $emailfield = '<section><label for="email" class="lbl-text">'.esc_html__('Email Address','pointfindert2d').':</label><label class="lbl-ui"><input type="email" name="email" class="input" placeholder=""/></label></section>';
  }
  ?><div class="golden-forms wrapper mini"><div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-enquiry-form-author"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Contact Form','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><?php echo $namefield; echo $emailfield;?>  <section><label for="phone" class="lbl-text"><?php echo esc_html__('Phone (Optional)','pointfindert2d');?>:</label><label class="lbl-ui"><input type="tel" name="phone" class="input" placeholder="" value="<?php echo $val3;?>"/></label></section><section><label for="msg" class="lbl-text"><?php echo esc_html__('Message','pointfindert2d');?>:</label><label class="lbl-ui"><textarea name="msg" class="textarea no-resize" ></textarea></label></section> <?php echo $recaptcha2;?></div></div><div class="form-buttons"><section><input type="hidden" name="userid" class="input" value="<?php echo $userid;?>"/><button id="pf-ajax-enquiry-button-author" class="button blue"><?php echo esc_html__('Send Contact Form','pointfindert2d');?></button></section></div></form></div>      
    <?php
    break;

/**
*Report Form
**/
  case 'reportform':
  $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_report_status','','0');
  if ( $pfrecheck == 1 && $pfrechecklg != 1) {
    $recaptcha2 = '';
  }

  $val1 = $val2 = $val3 = $user_id = '';

  if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $val2 = $current_user->user_email;

    $val1 = get_user_meta($user_id, 'first_name', true);
    $val1 .= ' '.get_user_meta($user_id, 'last_name', true);
    
    if (empty($val1) || $val1 == ' ') {
      $val1 = $user_id;
    }
    $namefield = '<section><label class="lbl-ui"><input type="hidden" name="name" class="input" placeholder="" value="'.$val1.'" /></label></section>';
    $emailfield = '<section><label class="lbl-ui"><input type="hidden" name="email" class="input" placeholder="" value="'.$val2.'"/></label></section>';
  }else{
    $namefield = '<section><label for="names" class="lbl-text">'.esc_html__('Name  & Surname','pointfindert2d').':</label><label class="lbl-ui"><input type="text" name="name" class="input" placeholder=""/></label></section>';
    $emailfield = '<section><label for="email" class="lbl-text">'.esc_html__('Email Address','pointfindert2d').':</label><label class="lbl-ui"><input type="email" name="email" class="input" placeholder=""/></label></section>';
  } 
  ?><div class="golden-forms wrapper mini"><div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-report-form"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Report Form','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><section><label for="name" class="lbl-text"><?php echo esc_html__('Reported Item','pointfindert2d');?>:</label><label class="lbl-ui"><?php echo $itemname;?></label></section><?php echo $namefield;echo $emailfield;?><section><label for="msg" class="lbl-text"><?php echo esc_html__('Message','pointfindert2d');?>:</label><label class="lbl-ui"><textarea name="msg" class="textarea no-resize" ></textarea></label></section> <?php echo $recaptcha2;?></div></div><div class="form-buttons"><section><input type="hidden" name="itemid" class="input" value="<?php echo $itemid;?>"/><input type="hidden" name="userid" class="input" value="<?php echo $user_id;?>"/><button id="pf-ajax-report-button" class="button blue"><?php echo esc_html__('Report This!','pointfindert2d');?></button></section></div></form></div>      
    <?php
    break;
/**
*Claim Form
**/
  case 'claimform':
  $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_report_status','','0');
  if ( $pfrecheck == 1 && $pfrechecklg != 1) {
    $recaptcha2 = '';
  }

  $val1 = $val2 = $val3 = $user_id = '';

  if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $val2 = $current_user->user_email;

    $val1 = get_user_meta($user_id, 'first_name', true);
    $val1 .= ' '.get_user_meta($user_id, 'last_name', true);
    
    if (empty($val1) || $val1 == ' ') {
      $val1 = $user_id;
    }
    $namefield = '<section><label class="lbl-ui"><input type="hidden" name="name" class="input" placeholder="" value="'.$val1.'" /></label></section>';
    $emailfield = '<section><label class="lbl-ui"><input type="hidden" name="email" class="input" placeholder="" value="'.$val2.'"/></label></section>';
  }else{
    $namefield = '<section><label for="name" class="lbl-text">'.esc_html__('Name  & Surname','pointfindert2d').':</label><label class="lbl-ui"><input type="text" name="name" class="input" placeholder=""/></label></section>';
    $emailfield = '<section><label for="email" class="lbl-text">'.esc_html__('Email Address','pointfindert2d').':</label><label class="lbl-ui"><input type="email" name="email" class="input" placeholder=""/></label></section>';
  }
  ?><div class="golden-forms wrapper mini"><div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-claim-form"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Claim Form','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><section><label for="name" class="lbl-text"><?php echo esc_html__('Claim Item','pointfindert2d');?>:</label><label class="lbl-ui"><?php echo $itemname;?></label></section><?php echo $namefield;echo $emailfield;?> <section><label for="phonenum" class="lbl-text"><?php echo esc_html__('Phone Number','pointfindert2d');?>:</label><label class="lbl-ui"><input type="phonenum" name="phonenum" class="input" placeholder=""/></label></section><section><label for="msg" class="lbl-text"><?php echo esc_html__('Message','pointfindert2d');?>:</label><label class="lbl-ui"><textarea name="msg" class="textarea no-resize" ></textarea></label></section> <?php echo $recaptcha2;?></div></div><div class="form-buttons"><section><input type="hidden" name="itemid" class="input" value="<?php echo $itemid;?>"/><input type="hidden" name="userid" class="input" value="<?php echo $user_id;?>"/><button id="pf-ajax-claim-button" class="button blue"><?php echo esc_html__('Claim Now!','pointfindert2d');?></button></section></div></form></div>      
    <?php
    break;
/**
*Flag Review Form
**/
  case 'flagreview':
  $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_flagrev_status','','0');
  if ( $pfrecheck == 1 && $pfrechecklg != 1) {$recaptcha2 = '';}

  $val1 = $val2 = $val3 = $user_id = '';

  if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $val2 = $current_user->user_email;

    $val1 = get_user_meta($user_id, 'first_name', true);
    $val1 .= ' '.get_user_meta($user_id, 'last_name', true);

    $namefield = '<section><label class="lbl-ui"><input type="hidden" name="name" class="input" placeholder="" value="'.$val1.'" /></label></section>';
    $emailfield = '<section><label class="lbl-ui"><input type="hidden" name="email" class="input" placeholder="" value="'.$val2.'"/></label></section>';
  }
    
  ?><div class="golden-forms wrapper mini"><div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-flag-form"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Flag Review Form','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><?php echo $namefield;?><?php echo $emailfield;?><section><label for="msg" class="lbl-text"><?php echo esc_html__('Reason','pointfindert2d');?>:</label><label class="lbl-ui"><textarea name="msg" class="textarea no-resize" ></textarea></label></section> <?php echo $recaptcha2;?></div></div><div class="form-buttons"><section><input type="hidden" name="reviewid" class="input" value="<?php echo $itemid;?>"/><input type="hidden" name="userid" class="input" value="<?php echo $user_id;?>"/><button id="pf-ajax-flag-button" class="button blue"><?php echo esc_html__('Flag This Review!','pointfindert2d');?></button></section></div></form></div>
    <?php
    break;
	}
die();
}?>