<?php
/**********************************************************************************************************************************
*
* Ajax Member System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
add_action( 'PF_AJAX_HANDLER_pfget_usersystem', 'pf_ajax_usersystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_usersystem', 'pf_ajax_usersystem' );

function pf_ajax_usersystem(){
  check_ajax_referer( 'pfget_usersystem', 'security');
	header('Content-Type: text/html; charset=UTF-8;');
  if(isset($_POST['formtype']) && $_POST['formtype']!=''){
    $formtype = esc_attr($_POST['formtype']);
  }
  if(isset($_POST['redirectpage']) && $_POST['redirectpage']!=''){
    $redirectpage = esc_attr($_POST['redirectpage']);
  }else{$redirectpage = 0;};
  $pfrecheck = PFRECIssetControl('setupreCaptcha_general_status','','0');
  if ($pfrecheck == 1) {
    $recaptcha_vars = '<section><div id="recaptcha_div_us">'.PFreCaptchaWidget().'</div></section>';
  }else{
    $recaptcha_vars = '';
  }

  $lang = '';
  if(isset($_POST['lang']) && $_POST['lang']!=''){
    $lang = sanitize_text_field($_POST['lang']);
  }

  if(function_exists('icl_t')) {
    if (!empty($lang)) {
      do_action( 'wpml_switch_language', $lang );
    }
  }

  
	switch($formtype){
/**
*Login
**/
	case 'login':
	 $setup4_membersettings_dashboard_link = esc_url(home_url());
	 $pfmenu_perout = PFPermalinkCheck();
   $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_login_status','','0');
   if ( $pfrecheck == 1 && $pfrechecklg != 1) {$recaptcha_vars = '';}

    $facebook_login_check = PFASSIssetControl('setup4_membersettings_facebooklogin','','0');
    $twitter_login_check = PFASSIssetControl('setup4_membersettings_twitterlogin','','0');
    $google_login_check = PFASSIssetControl('setup4_membersettings_googlelogin','','0');
	 if($twitter_login_check == 1){
		$twitter_login_text = '<section><div class="social-btns full"><a id="pf-ajax-logintwitter" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'uaf=twlogin" class="tws"><i class="pfadmicon-glyph-769"></i><span>'.esc_html__('LOGIN WITH TWITTER','pointfindert2d').'</span></a></div></section>';
	 }else{$twitter_login_text = '';}

    if($facebook_login_check == 1){
    $facebook_login_text = '<section><div class="social-btns full"><a id="pf-ajax-loginfacebook" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'uaf=fblogin" class="fbs"><i class="pfadmicon-glyph-770"></i><span>'.esc_html__('LOGIN WITH FACEBOOK','pointfindert2d').'</span></a></div></section>';
    }else{$facebook_login_text = '';}

    if($google_login_check == 1){
    $google_login_text = '<section><div class="social-btns full"><a id="pf-ajax-logingoogle" href="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'uaf=gologin" class="gbs"><i class="pfadmicon-glyph-813"></i><span>'.esc_html__('LOGIN WITH GOOGLE','pointfindert2d').'</span></a></div></section>';
    }else{$google_login_text = '';}
    ?><script type='text/javascript'>(function($) {"use strict";$.pfAjaxUserSystemVars = {};$.pfAjaxUserSystemVars.username_err = '<?php echo esc_html__('Please write username','pointfindert2d');?>';$.pfAjaxUserSystemVars.username_err2 = '<?php echo esc_html__('Please enter at least 3 characters for Username.','pointfindert2d');?>';$.pfAjaxUserSystemVars.password_err = '<?php echo esc_html__('Please write password','pointfindert2d');?>';})(jQuery);</script><div class="golden-forms wrapper mini"><div id="pflgcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-login-form"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Account Login','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><?php echo $facebook_login_text;echo $twitter_login_text;echo $google_login_text;?><section><label class="cxb"><?php echo esc_html__('Not a member yet?','pointfindert2d');?> <strong><a id="pf-register-trigger-button-inner" class="glink ext"><?php echo esc_html__('Register Now','pointfindert2d');?></a></strong> <?php echo esc_html__('- Its  Free','pointfindert2d');?></label><div class="tagline"><span><?php echo esc_html__('OR','pointfindert2d');?></span></div></section><section><label for="usernames" class="lbl-text"><?php echo esc_html__('Username:','pointfindert2d');?></label><label class="lbl-ui append-icon"><input type="text" name="username" class="input" placeholder="<?php echo esc_html__('Enter Username','pointfindert2d');?>" autofocus /><span><i class="pfadmicon-glyph-632"></i></span></label></section> <section><label for="pass" class="lbl-text"><?php echo esc_html__('Password:','pointfindert2d');?></label><label class="lbl-ui append-icon"><input type="password" name="password" class="input" placeholder="<?php echo esc_html__('Enter Password','pointfindert2d');?>" /><span><i class="pfadmicon-glyph-465"></i></span></label></section><?php echo $recaptcha_vars;?><section><span class="gtoggle"><label class="toggle-switch blue"><input type="checkbox" name="rem" id="toggle1_rememberme" /><label for="toggle1_rememberme" data-on="<?php echo esc_html__('YES','pointfindert2d');?>" data-off="<?php echo esc_html__('NO','pointfindert2d');?>"></label></label><label for="toggle1"><?php echo esc_html__('Remember me','pointfindert2d');?> <strong><a id="pf-lp-trigger-button-inner" class="glink ext"><?php echo esc_html__('Forgot Password?','pointfindert2d');?></a></strong></label></span></section></div></div><div class="form-buttons"><section><input type="hidden" name="redirectpage" value="<?php echo $redirectpage;?>"/><button id="pf-ajax-login-button" class="button blue"><?php echo esc_html__('Login Now','pointfindert2d');?></button></section></div></form></div><?php
		break;
/**
*Register
**/
  case 'register':
    $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_reg_status','','0');
    if ( $pfrecheck == 1 && $pfrechecklg != 1) {
      $recaptcha_vars = '';
    }
    ?><script type='text/javascript'>(function($) {"use strict";$.pfAjaxUserSystemVars2 = {};$.pfAjaxUserSystemVars2.username_err = '<?php echo esc_html__('Please write username','pointfindert2d');?>';$.pfAjaxUserSystemVars2.username_err2 = '<?php echo esc_html__('Please enter at least 3 characters for Username.','pointfindert2d');?>';$.pfAjaxUserSystemVars2.email_err = '<?php echo esc_html__('Please write an email','pointfindert2d');?>';$.pfAjaxUserSystemVars2.email_err2 = '<?php echo esc_html__('Your email address must be in the format of name@domain.com','pointfindert2d');?>';})(jQuery);</script><div class="golden-forms wrapper mini"><div id="pflgcontainer-overlay" class="pftrwcontainer-overlay"></div><form id="pf-ajax-register-form"><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Register an Account','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><section><label class="cxb"><?php echo esc_html__('Already have an account?','pointfindert2d');?> <strong><a id="pf-login-trigger-button-inner" class="glink ext"><?php echo esc_html__('Login now','pointfindert2d');?></a></strong></label><div class="tagline"><span><?php echo esc_html__('OR','pointfindert2d');?></span></div></section><section><label for="usernames" class="lbl-text"><?php echo esc_html__('Username:','pointfindert2d');?></label><label class="lbl-ui append-icon"><input type="text" name="username" class="input" placeholder="<?php echo esc_html__('Enter Username','pointfindert2d');?>" autofocus /><span><i class="pfadmicon-glyph-632"></i></span></label></section> <section><label for="pass" class="lbl-text"><?php echo esc_html__('Email:','pointfindert2d');?></label><label class="lbl-ui append-icon"><input type="text" name="email" class="input" placeholder="<?php echo esc_html__('Enter Email Address','pointfindert2d');?>" /><span><i class="pfadmicon-glyph-823"></i></span></label></section><?php echo $recaptcha_vars;?></div></div><div class="form-buttons"><section><button class="button blue" id="pf-ajax-register-button"><?php echo esc_html__('Register Now','pointfindert2d');?></button></section></div></form></div><?php
    break;
/**
*Lost Password
**/
  case 'lp':
    $pfrechecklg = PFRECIssetControl('setupreCaptcha_general_fb_status','','0');
    if ( $pfrecheck == 1 && $pfrechecklg != 1) {
      $recaptcha_vars = '';
    }
    ?><script type='text/javascript'>(function($) {"use strict";$.pfAjaxUserSystemVars3 = {};$.pfAjaxUserSystemVars3.username_err = '<?php echo esc_html__('Username or Email must be filled.','pointfindert2d');?>';$.pfAjaxUserSystemVars3.username_err2 = '<?php echo esc_html__('Please enter at least 3 characters for Username.','pointfindert2d');?>';$.pfAjaxUserSystemVars3.email_err2 = '<?php echo esc_html__('Your email address must be in the format of name@domain.com','pointfindert2d');?>';})(jQuery);</script><div class="golden-forms wrapper mini"><div id="pflgcontainer-overlay" class="pftrwcontainer-overlay"></div><div class="pfmodalclose"><i class="pfadmicon-glyph-707"></i></div><form id="pf-ajax-lp-form"><div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a></div><div class="form-title"><h2><?php echo esc_html__('Forgot Password','pointfindert2d');?></h2></div><div class="form-enclose"><div class="form-section"><section><label class="lbl-text"><strong><?php echo esc_html__('Please Enter;','pointfindert2d');?></strong></label></section><section><label for="usernames" class="lbl-text"><?php echo esc_html__('Username:','pointfindert2d');?></label><label class="lbl-ui append-icon"><input type="text" name="username" class="input" placeholder="<?php echo esc_html__('Enter Username','pointfindert2d');?>" autofocus /><span><i class="pfadmicon-glyph-632"></i></span></label></section> <section><div class="tagline"><span><?php echo esc_html__('OR','pointfindert2d');?></span></div></section><section><label for="pass" class="lbl-text"><?php echo esc_html__('Email:','pointfindert2d');?></label><label class="lbl-ui append-icon"><input type="text" name="email" class="input" placeholder="<?php echo esc_html__('Enter Email Address','pointfindert2d');?>" /><span><i class="pfadmicon-glyph-823"></i></span></label></section><?php echo $recaptcha_vars;?></div></div><div class="form-buttons"><section><button class="button blue" id="pf-ajax-lp-button"><?php echo esc_html__('Send Password','pointfindert2d');?></button></section></div></form></div><?php
    break;
/**
*Error Window
**/
  case 'error': 
	if(isset($_POST['errortype']) && $_POST['errortype']!=''){
		$errortype = esc_attr($_POST['errortype']);
	}
	if (empty($errortype)) {
		$errortype = 0;
	}

	if ($errortype == 1) {
		$pfkeyarray = array(
	      0 => esc_html__('Information','pointfindert2d'), 
	      1 => esc_html__('Details;','pointfindert2d'), 
	      2 => esc_html__('Close','pointfindert2d'), 
	    );
	}elseif($errortype == 0){
		$pfkeyarray = array(
	      0 => esc_html__('Error','pointfindert2d'), 
	      1 => esc_html__('Error Details;','pointfindert2d'), 
	      2 => esc_html__('Close','pointfindert2d'), 
	    );
	}

    ?><div class="golden-forms wrapper mini"><form id="pf-ajax-cl-form"><div class="form-title"><h2><?php echo $pfkeyarray[0];?></h2></div><div class="form-enclose"><div class="form-section"><section><label class="lbl-text"><strong><?php echo $pfkeyarray[1];?></strong></label><p id="pf-ajax-cl-details"></p></section></div></div><div class="form-buttons"><section><button class="button blue" id="pf-ajax-cl-button"><?php echo $pfkeyarray[2];?></button></section></div></form></div><?php
    break;
	}
die();
}
?>