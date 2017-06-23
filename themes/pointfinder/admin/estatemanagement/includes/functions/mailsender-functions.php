<?php
/**********************************************************************************************************************************
*
* Email system
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

/**
*Start : User system emails
**/
		
		/**
		*Start : Mail system filters & actions
		**/
			add_filter( 'wp_mail_from_name', function($name){
				$setup33_emailsettings_fromname = esc_attr(PFMSIssetControl('setup33_emailsettings_fromname','',''));
				if($setup33_emailsettings_fromname != ''){
					return $setup33_emailsettings_fromname;
				}
			});
			if ( !function_exists( 'wp_password_change_notification' ) ) {
			 function wp_password_change_notification() {}
			}
			add_filter( 'wp_mail_from', function($email){
				$setup33_emailsettings_fromemail = esc_attr(PFMSIssetControl('setup33_emailsettings_fromemail','',''));
				if($setup33_emailsettings_fromemail != ''){
					return $setup33_emailsettings_fromemail;
				}
			});
			add_filter( 'wp_mail_content_type', 'pointfinder_mail_content_type' );
			function pointfinder_mail_content_type( $content_type ) {
				$setup33_emailsettings_mailtype = esc_attr(PFMSIssetControl('setup33_emailsettings_mailtype','','1'));
			    if( $setup33_emailsettings_mailtype == 1 ) {
			        return 'text/HTML';
			    } else {
			        return 'text/plain';
			    }
			}


			add_action( 'phpmailer_init', 'pointfinder_phpmailer_edit' );
			function pointfinder_phpmailer_edit( $phpmailer ) {

				
				$setup33_emailsettings_ed = esc_attr(PFMSIssetControl('setup33_emailsettings_ed','',1));

				if(empty($setup33_emailsettings_ed)){
                    return;
                }

				

				$setup33_emailsettings_debug = esc_attr(PFMSIssetControl('setup33_emailsettings_debug','',0));
				$setup33_emailsettings_secure = esc_attr(PFMSIssetControl('setup33_emailsettings_secure','',''));
				$setup33_emailsettings_auth = esc_attr(PFMSIssetControl('setup33_emailsettings_auth','','0'));
				$setup33_emailsettings_smtpport = esc_attr(PFMSIssetControl('setup33_emailsettings_smtpport','','25'));
				$setup33_emailsettings_smtp = esc_attr(PFMSIssetControl('setup33_emailsettings_smtp','',''));
				$setup33_emailsettings_fromemail = esc_attr(PFMSIssetControl('setup33_emailsettings_fromemail','',''));
				$setup33_emailsettings_fromname = esc_attr(PFMSIssetControl('setup33_emailsettings_fromname','',''));
				$setup33_emailsettings_auth = ($setup33_emailsettings_auth == 1) ? true : false ;
				$setup33_emailsettings_secure = ($setup33_emailsettings_secure == '')? false : $setup33_emailsettings_secure;

				if ($setup33_emailsettings_smtp != '') {

					global $pointfindermail_option;

					$phpmailer->isSMTP();
					$phpmailer->From = $setup33_emailsettings_fromemail;
					$phpmailer->FromName = $setup33_emailsettings_fromname;
					$phpmailer->Sender = $phpmailer->From;
					$phpmailer->SetFrom($phpmailer->From, $phpmailer->FromName);
					$phpmailer->AddReplyTo($phpmailer->From,$phpmailer->FromName);
				    $phpmailer->Host = $setup33_emailsettings_smtp;
				    $phpmailer->SMTPAuth = $setup33_emailsettings_auth;

				    if($phpmailer->SMTPAuth){
						$phpmailer->Username = (isset($pointfindermail_option['setup33_emailsettings_smtpaccount']))? ''.esc_attr($pointfindermail_option['setup33_emailsettings_smtpaccount']['username']).'':'';
						$phpmailer->Password = (isset($pointfindermail_option['setup33_emailsettings_smtpaccount']))? ''.esc_attr($pointfindermail_option['setup33_emailsettings_smtpaccount']['password']).'':'';
					}
				    $phpmailer->Port = $setup33_emailsettings_smtpport;
				    $phpmailer->SMTPSecure = $setup33_emailsettings_secure;
				    //$phpmailer->isHTML(true);
				    
				    //PHPMailer 5.2.10 introduced this option. However, this might cause issues if the server is advertising TLS with an invalid certificate.
				    if (empty($setup33_emailsettings_secure)) {
				    	$phpmailer->SMTPAutoTLS = false;
				    }
				    
				    if (!empty($setup33_emailsettings_debug)) {
				    	//$phpmailer->SMTPDebug = 2;
				    	//echo '<br>';
				    	if (!empty( $phpmailer->ErrorInfo)) {
				    		print_r( $phpmailer->ErrorInfo);
				    	}
				    }
				}

			}

		/**
		*End : Mail system filters & actions
		**/



		/**
		*Start : Mail HTML Template
		**/
			function pointfinder_mailsystem_template_html($emailcontent,$emailtitle){

				global $pointfindermail_option;

				$sitename = esc_attr(PFMSIssetControl('setup33_emailsettings_sitename','',''));

				$setup35_template_footertext = PFMSIssetControl('setup35_template_footertext','','');
				$siteurl = get_site_url();

				$footer_text = str_replace( '%%sitename%%', $sitename, $setup35_template_footertext );
				$footer_text = str_replace( '%%siteurl%%', $siteurl, $footer_text );


				$setup35_template_logo = PFMSIssetControl('setup35_template_logo','','1');
				$setup35_template_logotext = esc_attr(PFMSIssetControl('setup35_template_logotext','',''));
				$setup35_template_mainbgcolor = (isset($pointfindermail_option['setup35_template_mainbgcolor']))?$pointfindermail_option['setup35_template_mainbgcolor']: '';
				$setup35_template_headerfooter = (isset($pointfindermail_option['setup35_template_headerfooter']))?$pointfindermail_option['setup35_template_headerfooter']: '#f7f7f7';
				$setup35_template_headerfooter_line = (isset($pointfindermail_option['setup35_template_headerfooter_line']))?$pointfindermail_option['setup35_template_headerfooter_line']: '#F25555';
				$setup35_template_headerfooter_text = (isset($pointfindermail_option['setup35_template_headerfooter_text']))?$pointfindermail_option['setup35_template_headerfooter_text']: array('hover'=>'#F25555','regular'=>'#494949');
				$setup35_template_contentbg = (isset($pointfindermail_option['setup35_template_contentbg']))?$pointfindermail_option['setup35_template_contentbg']: '#ffffff';
				$setup35_template_contenttext = (isset($pointfindermail_option['setup35_template_contenttext']))?$pointfindermail_option['setup35_template_contenttext']: array('hover'=>'#F25555','regular'=>'#494949');
				$setup17_logosettings_sitelogo = PFSAIssetControl('setup17_logosettings_sitelogo','','');

				$setup35_template_rtl = esc_attr(PFMSIssetControl('setup35_template_rtl','','0'));

				if($setup35_template_rtl == 1){$rtl_text = 'right';}else{$rtl_text = 'left';}

				ob_start();
				?>

				<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html>
				  <head>
				    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				    <meta name="viewport" content="width=320, target-densitydpi=device-dpi">
				    <style type="text/css">
						@media only screen and (max-width:660px){ table[class=w0],td[class=w0]{ width:0 !important}
							table[class=w10], td[class=w10], img[class=w10]{ width:10px !important}
							table[class=w15], td[class=w15], img[class=w15]{ width:5px !important}
							table[class=w30], td[class=w30], img[class=w30]{ width:10px !important}
							table[class=w60], td[class=w60], img[class=w60]{ width:10px !important}
							table[class=w125], td[class=w125], img[class=w125]{ width:80px !important}
							table[class=w130], td[class=w130], img[class=w130]{ width:55px !important}
							table[class=w140], td[class=w140], img[class=w140]{ width:90px !important}
							table[class=w160], td[class=w160], img[class=w160]{ width:180px !important}
							table[class=w170], td[class=w170], img[class=w170]{ width:100px !important}
							table[class=w180], td[class=w180], img[class=w180]{ width:80px !important}
							table[class=w195], td[class=w195], img[class=w195]{ width:80px !important}
							table[class=w220], td[class=w220], img[class=w220]{ width:80px !important}
							table[class=w240], td[class=w240], img[class=w240]{ width:180px !important}
							table[class=w255], td[class=w255], img[class=w255]{ width:185px !important}
							table[class=w275], td[class=w275], img[class=w275]{ width:135px !important}
							table[class=w280], td[class=w280], img[class=w280]{ width:135px !important}
							table[class=w300], td[class=w300], img[class=w300]{ width:140px !important}
							table[class=w325], td[class=w325], img[class=w325]{ width:95px !important}
							table[class=w360], td[class=w360], img[class=w360]{ width:140px !important}
							table[class=w410], td[class=w410], img[class=w410]{ width:180px !important}
							table[class=w470], td[class=w470], img[class=w470]{ width:200px !important}
							table[class=w580], td[class=w580], img[class=w580]{ width:280px !important}
							table[class=w640], td[class=w640], img[class=w640]{ width:300px !important}
							table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide]{ display:none !important}
							table[class=h0], td[class=h0]{ height:0 !important}
							p[class=footer-content-left]{ text-align:center !important}
							#headline p{ font-size:30px !important}
							.article-content, #left-sidebar{ -webkit-text-size-adjust:90% !important;  -ms-text-size-adjust:90% !important}
							.header-content, .footer-content-left{ -webkit-text-size-adjust:80% !important;  -ms-text-size-adjust:80% !important}
							img{ height:auto;  line-height:100%}
						}
						 
						 
						 #outlook a{ padding:0}
						 
						 body{ width:100% !important}
						 .ReadMsgBody{ width:100%}
						 .ExternalClass{ width:100%;  display:block !important}
						 
						 body{ background-color:<?php echo $setup35_template_mainbgcolor;?>;  margin:0;  padding:0;text-decoration:none}
						 *{text-decoration:none;}
						 a{text-decoration:none;}
						 a:hover{text-decoration:none;}
						 img{ outline:none;  text-decoration:none;  display:block}
						 br, strong br, b br, em br, i br{ line-height:100%}
						 h1, h2, h3, h4, h5, h6{ line-height:100% !important;  -webkit-font-smoothing:antialiased}
						 h1 a, h2 a, h3 a, h4 a, h5 a, h6 a{ color:blue !important}
						 h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active{color:red !important}
						 
						
						  
						 table td, table tr{ border-collapse:collapse}
						 .yshortcuts, .yshortcuts a, .yshortcuts a:link, .yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span{color:black;  text-decoration:none !important;  border-bottom:none !important;  background:none !important}
						 
						 
						 code{ white-space:normal;  word-break:break-all}
						 #background-table{ background-color:<?php echo $setup35_template_mainbgcolor;?>}
						 #sitelogoleft{text-align:left; margin-bottom:30px;}
						 #sitelogoright{text-align:right; margin-bottom:30px; float:right;}
						 
						 body, td{ font-family:HelveticaNeue,sans-serif}
						 .header-content, .footer-content-left, .footer-content-right{ -webkit-text-size-adjust:none;  -ms-text-size-adjust:none}
						 
						 .header-content{ font-size:12px;  color:<?php echo $setup35_template_headerfooter_text['regular'];?>;text-decoration:none}
						 .header-content a{ font-weight:bold;  color:#eee;  text-decoration:none}
						 #headline p{ color:<?php echo $setup35_template_headerfooter_text['regular'];?>;  font-family:HelveticaNeue,sans-serif;  font-size:36px;  text-align:<?php echo $rtl_text;?>;  margin-top:0px;  margin-bottom:30px;text-decoration:none}
						 #headline a p { color:<?php echo $setup35_template_headerfooter_text['regular'];?>;  text-decoration:none}
						 #headline a:hover p { color:<?php echo $setup35_template_headerfooter_text['hover'];?>;text-decoration:none}
						
						 .article-title{ font-size:18px;  line-height:24px;  color:#7d7d7d;  font-weight:bold;  margin-top:0px;  margin-bottom:18px;  font-family:HelveticaNeue,sans-serif;text-align:<?php echo $rtl_text;?>;}
						 .article-title a{ color:<?php echo $setup35_template_contenttext['regular'];?>;  text-decoration:none}
						 .article-title.with-meta{ margin-bottom:0}
						 .article-meta{ font-size:13px;  line-height:20px;  color:#ccc;  font-weight:bold;  margin-top:0}
						 .article-content{ font-size:13px;  line-height:18px;  color:#444;  margin-top:0px;  margin-bottom:18px;  font-family:HelveticaNeue,sans-serif;text-align:<?php echo $rtl_text;?>;}
						 .article-content a{ color:<?php echo $setup35_template_contenttext['regular'];?>;  font-weight:bold;  text-decoration:none;}
						 .article-content a:hover{ color:<?php echo $setup35_template_contenttext['hover'];?>;}
						 .article-content img{ max-width:100%}
						 .article-content ol, .article-content ul{ margin-top:0px;  margin-bottom:18px;  margin-<?php echo $rtl_text;?>:19px;  padding:0}
						 .article-content li{ font-size:13px;  line-height:18px;  color:#444}
						 .article-content li a{ color:<?php echo $setup35_template_contenttext['regular'];?>;  text-decoration:none}
						 .article-content p{ margin-bottom:15px}

						 .footer-content-left{ font-size:12px;  line-height:15px;  color:<?php echo $setup35_template_headerfooter_text['regular'];?>;  margin-top:0px;  margin-bottom:15px}
						 .footer-content-left a{ color:<?php echo $setup35_template_headerfooter_text['regular'];?>;  font-weight:bold;  text-decoration:none}
						 .footer-content-left a:hover{ color:<?php echo $setup35_template_headerfooter_text['hover'];?>;  font-weight:bold;  text-decoration:none}
						 
						 #simple-content-row,.contentrow{background-color:<?php echo $setup35_template_contentbg;?>;color:<?php echo $setup35_template_contenttext['regular'];?>;text-align:<?php echo $rtl_text;?>;}
						 #header{ border-top:3px solid <?php echo $setup35_template_headerfooter_line;?>; background-color:<?php echo $setup35_template_headerfooter;?>;color:<?php echo $setup35_template_headerfooter_text['regular'];?>;}
						 #footer{ border-bottom:3px solid <?php echo $setup35_template_headerfooter_line;?>;  background-color:<?php echo $setup35_template_headerfooter;?>;color:<?php echo $setup35_template_headerfooter_text['regular'];?>;}
						 #footer a{ color:<?php echo $setup35_template_headerfooter_text['regular'];?>;  text-decoration:none;  font-weight:bold}
						 
				  	</style>
					<!--[if gte mso 9]>
						<style _tmplitem="763" >
						.article-content ol, .article-content ul {
						margin: 0 0 0 24px;
						padding: 0;
						list-style-position: inside;
						}
						</style>
					<![endif]-->
				  </head>
				  <body>
				    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table" style="table-layout:fixed" align="center">
				      <tbody>
				        <tr>
				          <td align="center">
				        	<table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
				              <tbody>
				                <tr>
				                  <td class="w640" width="640" height="20">
				                  </td>
				                </tr>
				                
				                  
				                  <tr>
				                    <td id="header" class="w640" width="640" align="center">
				                      
				                      <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
				                        <tbody>
				                          <tr>
				                            <td class="w30" width="30">
				                            </td>
				                            <td class="w580" width="580" height="30">
				                            </td>
				                            <td class="w30" width="30">
				                            </td>
				                          </tr>
				                          <tr>
				                            <td class="w30" width="30">
				                            </td>
				                            <td class="w580" width="580">
				                              <div align="center" id="headline">
				                                    <a href="<?php echo $siteurl;?>">
				                                      
				                                        <?php 
				                                        if(esc_attr($setup35_template_logo) == 0){
				                                        	echo '<p><strong><singleline label="Title">'.$setup35_template_logotext.'</singleline></p></strong>';
				                                        }else{
				                                        	if(is_array($setup17_logosettings_sitelogo)){
																if(count($setup17_logosettings_sitelogo)>0){
																	echo '<div id="sitelogo'.$rtl_text.'"><img src="'.esc_url($setup17_logosettings_sitelogo["url"]).'" width="'.$setup17_logosettings_sitelogo["width"].'" height="'.$setup17_logosettings_sitelogo["height"].'" alt=""></div>';
																}
															}
				                                        }
				                                       ?>
				                                      
				                                    </a>
				                              </div>
				                            </td>
				                            <td class="w30" width="30">
				                            </td>
				                          </tr>
				                        </tbody>
				                      </table>
				                      
				                      
				                    </td>
				                  </tr>
				                  
				                  <tr class="contentrow">
				                    <td class="w640" width="640" height="30">
				                    </td>
				                  </tr>
				                  <tr id="simple-content-row">
				                    <td class="w640" width="640">
				                      <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
				                        <tbody>
				                          <tr>
				                            <td class="w30" width="30">
				                            </td>
				                            <td class="w580" width="580">
				                              <repeater>
				                                <layout label="Text only">
				                                  <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
				                                    <tbody>
				                                      <tr>
				                                        <td class="w580" width="580">
				                                          <p class="article-title">
				                                            <singleline label="Title">
				                                              <?php echo $emailtitle; ?>
				                                            </singleline>
				                                          </p>
				                                          <div class="article-content">
				                                            <multiline label="Description">
				                                              <?php echo $emailcontent; ?>
				                                            </multiline>
				                                          </div>
				                                        </td>
				                                      </tr>
				                                      <tr>
				                                        <td class="w580" width="580" height="10">
				                                        </td>
				                                      </tr>
				                                    </tbody>
				                                  </table>
				                                </layout>
				                              </repeater>
				                            </td>
				                            <td class="w30" width="30">
				                            </td>
				                          </tr>
				                        </tbody>
				                      </table>
				                    </td>
				                  </tr>
				                  <tr class="contentrow">
				                    <td class="w640" width="640" height="15">
				                    </td>
				                  </tr>
				                  <tr class="contentrow">
				                    <td class="w640" width="640">
				                      <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
				                        <tbody>
				                          <tr>
				                            <td class="w30" width="30">
				                            </td>
				                            <td class="w580 h0" height="30">
				                            </td>
				                            <td class="w30" width="30">
				                            </td>
				                          </tr>
				                          <tr>
				                            <td class="w30" width="30">
				                            </td>
				                            <td class="w580" valign="top">
				                              <span>
				                                <p class="footer-content-left">
				                                
				                                   <?php echo $footer_text; ?>
				                                 
				                                </p>
				                              </span>
				                            </td>
				                            <td class="w30" width="30">
				                            </td>
				                          </tr>
				                          <tr>
				                            <td class="w30" width="30">
				                            </td>
				                            <td class="w580 h0" height="15">
				                            </td>
				                            <td class="w30" width="30">
				                            </td>
				                          </tr>
				                        </tbody>
				                      </table>
				                    </td>
				                  </tr>
				                  <tr>
				                    <td class="w640" width="640" height="60">
				                    </td>
				                  </tr>
				              </tbody>
				          </table>
				  </td>
				      </tr>
				  </tbody>
				  </table>
				  </body>
				</html>

				<?php
				$output =  ob_get_contents();
	            ob_end_clean();

				return $output;
			}

		/**
		*End : Mail HTML Template
		**/


		/**
		*Start : Mail Template
		**/
			
			function pointfinder_mailsystem_mailsender($params = array()){

				$defaults = array( 
			        'toemail' => '',
			        'subject' => '',
			        'content' => '',
			        'title' => '',
			        'predefined' => '',
			        'data' => ''
			    );
			   
			    $params = array_merge($defaults, $params);

			    if(isset($params['predefined'])){
			    	$output_predefined = PFPredefinedEmails($params['predefined'],$params['data']);
			    	if(PFControlEmptyArr($output_predefined)){
				    	$params['title'] = $output_predefined['title'];
				    	$params['subject'] = $output_predefined['subject'];
				    	$params['content'] = $output_predefined['content'];
				    }
			    }

			    $setup33_emailsettings_mailtype = PFMSIssetControl('setup33_emailsettings_mailtype','','1');
			    if( $setup33_emailsettings_mailtype == 1 ) {
			        $email_content = pointfinder_mailsystem_template_html(wpautop($params['content']),$params['title']);
			    } else {
			        $email_content = $params['content'];
			    }

				$mail = wp_mail( $params['toemail'], $params['subject'], $email_content );

				return $mail;
			}

		/**
		*End : Mail Template
		**/


		/**
		*Start : Get emails from admin.
		**/
			function PFPredefinedEmails($value,$data){
				switch ($value) {

					case 'registration':
						$setup35_loginemails_register_subject = esc_attr(PFMSIssetControl('setup35_loginemails_register_subject','',''));
						$setup35_loginemails_register_title = esc_attr(PFMSIssetControl('setup35_loginemails_register_title','',''));
						$mail_text = $setup35_loginemails_register_contents = PFMSIssetControl('setup35_loginemails_register_contents','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%password%%', $data['password'], $mail_text );
							$mail_text = str_replace( '%%username%%', $data['username'], $mail_text );
						}

						return array(
							'subject' => $setup35_loginemails_register_subject, 
							'title' => $setup35_loginemails_register_title,
							'content' => $mail_text);

						break;


					case 'registrationadmin':
						$setup35_loginemails_register_subject = esc_attr(PFMSIssetControl('setup35_loginemails_registeradm_subject','',''));
						$setup35_loginemails_register_title = esc_attr(PFMSIssetControl('setup35_loginemails_registeradm_title','',''));
						$mail_text = $setup35_loginemails_register_contents = PFMSIssetControl('setup35_loginemails_registeradm_contents','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%username%%', $data['username'], $mail_text );
						}

						return array(
							'subject' => $setup35_loginemails_register_subject, 
							'title' => $setup35_loginemails_register_title,
							'content' => $mail_text);

						break;


					case 'lostpassword':
						$setup35_loginemails_forgot_subject = esc_attr(PFMSIssetControl('setup35_loginemails_forgot_subject','',''));
						$setup35_loginemails_forgot_title = esc_attr(PFMSIssetControl('setup35_loginemails_forgot_title','',''));
						$mail_text = $setup35_loginemails_forgot_contents = PFMSIssetControl('setup35_loginemails_forgot_contents','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%keylink%%', $data['keylink'], $mail_text );
							$mail_text = str_replace( '%%username%%', $data['username'], $mail_text );
						}

						return array(
							'subject' => $setup35_loginemails_forgot_subject, 
							'title' => $setup35_loginemails_forgot_title,
							'content' => $mail_text);

						break;

					case 'itemapproved':/*to USER*/

						$setup35_submissionemails_approveditem_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_approveditem_subject','',''));
						$setup35_submissionemails_approveditem_title = esc_attr(PFMSIssetControl('setup35_submissionemails_approveditem_title','',''));
						$mail_text = $setup35_submissionemails_approveditem = PFMSIssetControl('setup35_submissionemails_approveditem','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%itemlink%%', get_permalink($data['ID']), $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_approveditem_subject, 
							'title' => $setup35_submissionemails_approveditem_title,
							'content' => $mail_text);

						break;

					case 'itemrejected':/*to USER*/

						$setup35_submissionemails_rejected_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_rejected_subject','',''));
						$setup35_submissionemails_rejected_title = esc_attr(PFMSIssetControl('setup35_submissionemails_rejected_title','',''));
						$mail_text = $setup35_submissionemails_rejected = PFMSIssetControl('setup35_submissionemails_rejected','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_rejected_subject, 
							'title' => $setup35_submissionemails_rejected_title,
							'content' => $mail_text);

						break;

					case 'itemdeleted':/*to USER*/

						$setup35_submissionemails_deleted_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_deleted_subject','',''));
						$setup35_submissionemails_deleted_title = esc_attr(PFMSIssetControl('setup35_submissionemails_deleted_title','',''));
						$mail_text = $setup35_submissionemails_deleted = PFMSIssetControl('setup35_submissionemails_deleted','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_deleted_subject, 
							'title' => $setup35_submissionemails_deleted_title,
							'content' => $mail_text);

						break;

					case 'waitingapproval':/*to USER*/

						$setup35_submissionemails_waitingapproval_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingapproval_subject','',''));
						$setup35_submissionemails_waitingapproval_title = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingapproval_title','',''));
						$mail_text = $setup35_submissionemails_waitingapproval = PFMSIssetControl('setup35_submissionemails_waitingapproval','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_waitingapproval_subject, 
							'title' => $setup35_submissionemails_waitingapproval_title,
							'content' => $mail_text);

						break;

					case 'waitingpayment': /*to USER*/

						$setup35_submissionemails_waitingpayment_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingpayment_subject','',''));
						$setup35_submissionemails_waitingpayment_title = esc_attr(PFMSIssetControl('setup35_submissionemails_waitingpayment_title','',''));
						$mail_text = $setup35_submissionemails_waitingpayment = PFMSIssetControl('setup35_submissionemails_waitingpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_waitingpayment_subject, 
							'title' => $setup35_submissionemails_waitingpayment_title,
							'content' => $mail_text);

						break;

					case 'updateditemsubmission': /*to ADMIN*/
						
						$setup35_submissionemails_updateditem_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_updateditem_subject','',''));
						$setup35_submissionemails_updateditem_title = esc_attr(PFMSIssetControl('setup35_submissionemails_updateditem_title','',''));
						$mail_text = $setup35_submissionemails_updateditem = PFMSIssetControl('setup35_submissionemails_updateditem','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%itemlinkadmin%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_updateditem_subject, 
							'title' => $setup35_submissionemails_updateditem_title,
							'content' => $mail_text);

						break;

					case 'newitemsubmission': /*to ADMIN*/

						$setup35_submissionemails_newitem_subject = esc_attr(PFMSIssetControl('setup35_submissionemails_newitem_subject','',''));
						$setup35_submissionemails_newitem_title = esc_attr(PFMSIssetControl('setup35_submissionemails_newitem_title','',''));
						$mail_text = $setup35_submissionemails_newitem = PFMSIssetControl('setup35_submissionemails_newitem','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%itemlinkadmin%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
						}

						return array(
							'subject' => $setup35_submissionemails_newitem_subject, 
							'title' => $setup35_submissionemails_newitem_title,
							'content' => $mail_text);

						break;

					case 'newpaymentreceived': /*to ADMIN*/

						$setup35_paymentemails_newdirectpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_newdirectpayment_subject','',''));
						$setup35_paymentemails_newdirectpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_newdirectpayment_title','',''));
						$mail_text = $setup35_paymentemails_newdirectpayment = PFMSIssetControl('setup35_paymentemails_newdirectpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%itemadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_newdirectpayment_subject, 
							'title' => $setup35_paymentemails_newdirectpayment_title,
							'content' => $mail_text);

						break;

					case 'recurringprofilecreated': /*to ADMIN*/

						$setup35_paymentemails_newrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_newrecpayment_subject','',''));
						$setup35_paymentemails_newrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_newrecpayment_title','',''));
						$mail_text = $setup35_paymentemails_newrecpayment = PFMSIssetControl('setup35_paymentemails_newrecpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%itemadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
							$mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
							$mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_newrecpayment_subject, 
							'title' => $setup35_paymentemails_newrecpayment_title,
							'content' => $mail_text);

						break;

					case 'newbankpreceived': /*to ADMIN*/

						$setup35_paymentemails_newbankpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_newbankpayment_subject','',''));
						$setup35_paymentemails_newbankpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_newbankpayment_title','',''));
						$mail_text = $setup35_paymentemails_newbankpayment = PFMSIssetControl('setup35_paymentemails_newbankpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%itemadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_newbankpayment_subject, 
							'title' => $setup35_paymentemails_newbankpayment_title,
							'content' => $mail_text);

						break;

					case 'paymentcompleted': /*to USER*/

						$setup35_paymentemails_paymentcompleted_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompleted_subject','',''));
						$setup35_paymentemails_paymentcompleted_title = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompleted_title','',''));
						$mail_text = $setup35_paymentemails_paymentcompleted = PFMSIssetControl('setup35_paymentemails_paymentcompleted','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_paymentcompleted_subject, 
							'title' => $setup35_paymentemails_paymentcompleted_title,
							'content' => $mail_text);

						break;

					case 'recprofilecreated': /*to USER*/

						$setup35_paymentemails_paymentcompletedrec_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompletedrec_subject','',''));
						$setup35_paymentemails_paymentcompletedrec_title = esc_attr(PFMSIssetControl('setup35_paymentemails_paymentcompletedrec_title','',''));
						$mail_text = $setup35_paymentemails_paymentcompletedrec = PFMSIssetControl('setup35_paymentemails_paymentcompletedrec','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
							$mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
							$mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_paymentcompletedrec_subject, 
							'title' => $setup35_paymentemails_paymentcompletedrec_title,
							'content' => $mail_text);

						break;

					case 'bankpaymentwaiting': /*to USER*/

						$setup35_paymentemails_bankpaymentwaiting_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentwaiting_subject','',''));
						$setup35_paymentemails_bankpaymentwaiting_title = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentwaiting_title','',''));
						$mail_text = $setup35_paymentemails_bankpaymentwaiting = PFMSIssetControl('setup35_paymentemails_bankpaymentwaiting','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_bankpaymentwaiting_subject, 
							'title' => $setup35_paymentemails_bankpaymentwaiting_title,
							'content' => $mail_text);

						break;

					case 'bankpaymentcancel': /*to USER*/

						$setup35_paymentemails_bankpaymentcancel_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentcancel_subject','',''));
						$setup35_paymentemails_bankpaymentcancel_title = esc_attr(PFMSIssetControl('setup35_paymentemails_bankpaymentcancel_title','',''));
						$mail_text = $setup35_paymentemails_bankpaymentcancel = PFMSIssetControl('setup35_paymentemails_bankpaymentcancel','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', $data['title'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_bankpaymentcancel_subject, 
							'title' => $setup35_paymentemails_bankpaymentcancel_title,
							'content' => $mail_text);

						break;

					case 'directafterexpire': /*to USER*/

						$setup35_autoemailsadmin_directafterexpire_subject = esc_attr(PFMSIssetControl('setup35_autoemailsadmin_directafterexpire_subject','',''));
						$setup35_autoemailsadmin_directafterexpire_title = esc_attr(PFMSIssetControl('setup35_autoemailsadmin_directafterexpire_title','',''));
						$mail_text = $setup35_autoemailsadmin_directafterexpire = PFMSIssetControl('setup35_autoemailsadmin_directafterexpire','','');

						
						if(PFControlEmptyArr($data)){
							$pointfinder_order_price = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_price', true ));
							$pointfinder_order_listingpname = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_listingpname', true ));
							$pointfinder_order_pricesign = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_pricesign', true ));

							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', get_the_title($data['ID']), $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $pointfinder_order_price.'('.$pointfinder_order_pricesign.')', $mail_text );
							$mail_text = str_replace( '%%packagename%%', $pointfinder_order_listingpname, $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_directafterexpire_subject, 
							'title' => $setup35_autoemailsadmin_directafterexpire_title,
							'content' => $mail_text
						);

						break;

					case 'directbeforeexpire': /*to USER*/

						$setup35_autoemailsadmin_directbeforeexpire_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_directbeforeexpire_subject','',''));
						$setup35_autoemailsadmin_directbeforeexpire_title = esc_attr(PFMSIssetControl('setup35_paymentemails_directbeforeexpire_title','',''));
						$mail_text = $setup35_autoemailsadmin_directbeforeexpire = PFMSIssetControl('setup35_paymentemails_directbeforeexpire','','');

						
						if(PFControlEmptyArr($data)){
							$pointfinder_order_price = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_price', true ));
							$pointfinder_order_listingpname = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_listingpname', true ));
							$pointfinder_order_pricesign = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_pricesign', true ));

							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', '<a href="'.get_permalink( $data['ID'] ).'">'.get_the_title($data['ID']).'</a>', $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $pointfinder_order_price.'('.$pointfinder_order_pricesign.')', $mail_text );
							$mail_text = str_replace( '%%packagename%%', $pointfinder_order_listingpname, $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_directbeforeexpire_subject, 
							'title' => $setup35_autoemailsadmin_directbeforeexpire_title,
							'content' => $mail_text
						);

						break;

					case 'expiredrecpayment': /*to USER*/

						$setup35_autoemailsadmin_expiredrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentemails_expiredrecpayment_subject','',''));
						$setup35_autoemailsadmin_expiredrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentemails_expiredrecpayment_title','',''));
						$mail_text = $setup35_autoemailsadmin_expiredrecpayment = PFMSIssetControl('setup35_paymentemails_expiredrecpayment','','');

						
						if(PFControlEmptyArr($data)){
							$pointfinder_order_price = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_price', true ));
							$pointfinder_order_listingpname = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_listingpname', true ));
							$pointfinder_order_pricesign = esc_attr(get_post_meta( $data['orderid'], 'pointfinder_order_pricesign', true ));

							$mail_text = str_replace( '%%itemid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%itemname%%', get_the_title($data['ID']), $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $pointfinder_order_price.'('.$pointfinder_order_pricesign.')', $mail_text );
							$mail_text = str_replace( '%%packagename%%', $pointfinder_order_listingpname, $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_expiredrecpayment_subject, 
							'title' => $setup35_autoemailsadmin_expiredrecpayment_title,
							'content' => $mail_text
						);

						break;

					case 'enquiryformuser': /*to USER*/

						$setup35_itemcontact_enquiryformuser_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformuser_subject','',''));
						$setup35_itemcontact_enquiryformuser_title = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformuser_title','',''));
						$mail_text = $setup35_itemcontact_enquiryformuser = PFMSIssetControl('setup35_itemcontact_enquiryformuser','','');

						
						if(PFControlEmptyArr($data)){
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							if(!empty($data['phone'])){
								$mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
							}else{
								$mail_text = str_replace( '%%phone%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemcontact_enquiryformuser_subject, 
							'title' => $setup35_itemcontact_enquiryformuser_title,
							'content' => $mail_text
						);

						break;

					case 'enquiryformadmin': /*to ADMIN*/

						$setup35_itemcontact_enquiryformadmin_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformadmin_subject','',''));
						$setup35_itemcontact_enquiryformadmin_title = esc_attr(PFMSIssetControl('setup35_itemcontact_enquiryformadmin_title','',''));
						$mail_text = $setup35_itemcontact_enquiryformadmin = PFMSIssetControl('setup35_itemcontact_enquiryformadmin','','');

						
						if(PFControlEmptyArr($data)){
							 
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
							}
							if(!empty($data['user'])){
								$user = get_user_by( 'id', $data['user'] );
								if($user != false){
									$mail_text = str_replace( '%%userinfo%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
								}else{
									$mail_text = str_replace( '%%userinfo%%', '', $mail_text );
								}
							}else{
								$mail_text = str_replace( '%%userinfo%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							if(!empty($data['phone'])){
								$mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
							}else{
								$mail_text = str_replace( '%%phone%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemcontact_enquiryformadmin_subject, 
							'title' => $setup35_itemcontact_enquiryformadmin_title,
							'content' => $mail_text
						);

						break;

					case 'reviewformuser': /*to USER*/

						$setup35_itemreview_reviewformuser_subject = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformuser_subject','',''));
						$setup35_itemreview_reviewformuser_title = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformuser_title','',''));
						$mail_text = $setup35_itemreview_reviewformuser = PFMSIssetControl('setup35_itemreview_reviewformuser','','');

						
						if(PFControlEmptyArr($data)){
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemreview_reviewformuser_subject, 
							'title' => $setup35_itemreview_reviewformuser_title,
							'content' => $mail_text
						);

						break;

					case 'reviewformadmin': /*to ADMIN*/

						$setup35_itemreview_reviewformadmin_subject = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformadmin_subject','',''));
						$setup35_itemreview_reviewformadmin_title = esc_attr(PFMSIssetControl('setup35_itemreview_reviewformadmin_title','',''));
						$mail_text = $setup35_itemreview_reviewformadmin = PFMSIssetControl('setup35_itemreview_reviewformadmin','','');

						
						if(PFControlEmptyArr($data)){
							
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
							}
							if(!empty($data['user'])){
								$user = get_user_by( 'id', $data['user'] );
								$mail_text = str_replace( '%%userinfo%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%userinfo%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%reveditlink%%', '<a href="'.admin_url('post.php?post='.$data['revid'].'&action=edit').'">'.esc_html__('Edit Review','pointfindert2d').'</a>', $mail_text );
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemreview_reviewformadmin_subject, 
							'title' => $setup35_itemreview_reviewformadmin_title,
							'content' => $mail_text
						);

						break;

					case 'reportitemmail': /*to ADMIN*/

						$setup35_itemcontact_report_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_report_subject','',''));
						$setup35_itemcontact_report_title = esc_attr(PFMSIssetControl('setup35_itemcontact_report_title','',''));
						$mail_text = $setup35_itemcontact_report = PFMSIssetControl('setup35_itemcontact_report','','');

						
						if(PFControlEmptyArr($data)){
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
							}
							if(!empty($data['user'])){
								$user = get_user_by( 'id', $data['user'] );
								$mail_text = str_replace( '%%userid%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%userid%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemcontact_report_subject, 
							'title' => $setup35_itemcontact_report_title,
							'content' => $mail_text
						);

						break;

					case 'claimitemmail': /*to ADMIN*/

						$setup35_itemcontact_claim_subject = esc_attr(PFMSIssetControl('setup35_itemcontact_claim_subject','',''));
						$setup35_itemcontact_claim_title = esc_attr(PFMSIssetControl('setup35_itemcontact_claim_title','',''));
						$mail_text = $setup35_itemcontact_claim = PFMSIssetControl('setup35_itemcontact_claim','','');

						
						if(PFControlEmptyArr($data)){
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%iteminfo%%', '<a href="'.get_permalink( $data['item'] ).'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%iteminfo%%', '', $mail_text );
							}
							if(!empty($data['user'])){
								$user = get_user_by( 'id', $data['user'] );
								$mail_text = str_replace( '%%userid%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%userid%%', '', $mail_text );
							}
							if(!empty($data['phone'])){
								$mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
							}else{
								$mail_text = str_replace( '%%phone%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemcontact_claim_subject, 
							'title' => $setup35_itemcontact_claim_title,
							'content' => $mail_text
						);

						break;

					case 'reviewflagemail': /*to ADMIN*/

						$setup35_itemreview_reviewflagformadmin_subject = esc_attr(PFMSIssetControl('setup35_itemreview_reviewflagformadmin_subject','',''));
						$setup35_itemreview_reviewflagformadmin_title = esc_attr(PFMSIssetControl('setup35_itemreview_reviewflagformadmin_title','',''));
						$mail_text = $setup35_itemreview_reviewflagformadmin = PFMSIssetControl('setup35_itemreview_reviewflagformadmin','','');

						
						if(PFControlEmptyArr($data)){
							if(!empty($data['item'])){
								$mail_text = str_replace( '%%reviewinfo%%', '<a href="'.admin_url('post.php?post='.$data['item'].'&action=edit').'">'.$data['item'].' - '.get_the_title($data['item']).'</a>', $mail_text );
							}
							if(!empty($data['user'])){
								$user = get_user_by( 'id', $data['user'] );
								$mail_text = str_replace( '%%userinfo%%', '<a href="'.get_edit_user_link().'?user_id='.$data['user'].'">'.$user->nickname.'</a>', $mail_text );
							}else{
								$mail_text = str_replace( '%%userinfo%%', '', $mail_text );
							}
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							$mail_text = str_replace( '%%message%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%date%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_itemreview_reviewflagformadmin_subject, 
							'title' => $setup35_itemreview_reviewflagformadmin_title,
							'content' => $mail_text
						);

						break;
						
					case 'contactformemail': /*to ADMIN*/

						$setup35_contactform_subject = esc_attr(PFMSIssetControl('setup35_contactform_subject','',''));
						$setup35_contactform_title = esc_attr(PFMSIssetControl('setup35_contactform_title','',''));
						$mail_text = $setup35_contactform_contents = PFMSIssetControl('setup35_contactform_contents','','');

						
						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%name%%', $data['name'], $mail_text );
							$mail_text = str_replace( '%%email%%', $data['email'], $mail_text );
							$mail_text = str_replace( '%%msg%%', $data['message'], $mail_text );
							$mail_text = str_replace( '%%subject%%', $data['subject'], $mail_text );
							$mail_text = str_replace( '%%phone%%', $data['phone'], $mail_text );
							$mail_text = str_replace( '%%datetime%%', date(get_option('date_format')." ".get_option('time_format')), $mail_text );
						}

						return array(
							'subject' => $setup35_contactform_subject, 
							'title' => $setup35_contactform_title,
							'content' => $mail_text
						);

						break;

					/*Membership Emails*/

					case 'expiredrecpaymentmember': /*to USER*/

						$setup35_autoemailsadmin_expiredrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_expiredrecpayment_subject','',''));
						$setup35_autoemailsadmin_expiredrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_expiredrecpayment_title','',''));
						$mail_text = $setup35_autoemailsadmin_expiredrecpayment = PFMSIssetControl('setup35_paymentmemberemails_expiredrecpayment','','');

						
						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', get_the_title($data['orderid']), $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text);
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_expiredrecpayment_subject, 
							'title' => $setup35_autoemailsadmin_expiredrecpayment_title,
							'content' => $mail_text
						);

						break;

					case 'recprofilecreatedmember': /*to USER*/

						$setup35_paymentemails_paymentcompletedrec_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompletedrec_subject','',''));
						$setup35_paymentemails_paymentcompletedrec_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompletedrec_title','',''));
						$mail_text = $setup35_paymentemails_paymentcompletedrec = PFMSIssetControl('setup35_paymentmemberemails_paymentcompletedrec','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%ordernumber%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
							$mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
							$mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_paymentcompletedrec_subject, 
							'title' => $setup35_paymentemails_paymentcompletedrec_title,
							'content' => $mail_text);

						break;

					case 'freecompletedmember': /*to USER*/

						$setup35_paymentemails_paymentcompleted_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_freecompleted_subject','',''));
						$setup35_paymentemails_paymentcompleted_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_freecompleted_title','',''));
						$mail_text = $setup35_paymentemails_paymentcompleted = PFMSIssetControl('setup35_paymentmemberemails_freecompleted','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_paymentcompleted_subject, 
							'title' => $setup35_paymentemails_paymentcompleted_title,
							'content' => $mail_text);

						break;

					case 'paymentcompletedmember': /*to USER*/

						$setup35_paymentemails_paymentcompleted_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompleted_subject','',''));
						$setup35_paymentemails_paymentcompleted_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_paymentcompleted_title','',''));
						$mail_text = $setup35_paymentemails_paymentcompleted = PFMSIssetControl('setup35_paymentmemberemails_paymentcompleted','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_paymentcompleted_subject, 
							'title' => $setup35_paymentemails_paymentcompleted_title,
							'content' => $mail_text);

						break;

					case 'directafterexpiremember': /*to USER*/

						$setup35_autoemailsadmin_directafterexpire_subject = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_subject','',''));
						$setup35_autoemailsadmin_directafterexpire_title = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_title','',''));
						$mail_text = $setup35_autoemailsadmin_directafterexpire = PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire','','');

						
						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', get_the_title($data['orderid']), $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_directafterexpire_subject, 
							'title' => $setup35_autoemailsadmin_directafterexpire_title,
							'content' => $mail_text
						);

						break;

					case 'directafterexpiremember': /*to USER*/

						$setup35_autoemailsadmin_directafterexpire_subject = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_subject','',''));
						$setup35_autoemailsadmin_directafterexpire_title = esc_attr(PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire_title','',''));
						$mail_text = $setup35_autoemailsadmin_directafterexpire = PFMSIssetControl('setup35_autoemailsmemberadmin_directafterexpire','','');

						
						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', $data['orderid'], $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_directafterexpire_subject, 
							'title' => $setup35_autoemailsadmin_directafterexpire_title,
							'content' => $mail_text
						);

						break;

					case 'directbeforeexpiremember': /*to USER*/

						$setup35_autoemailsadmin_directbeforeexpire_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_directbeforeexpire_subject','',''));
						$setup35_autoemailsadmin_directbeforeexpire_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_directbeforeexpire_title','',''));
						$mail_text = $setup35_autoemailsadmin_directbeforeexpire = PFMSIssetControl('setup35_paymentmemberemails_directbeforeexpire','','');

						
						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', $data['orderid'], $mail_text );
							$mail_text = str_replace( '%%expiredate%%', $data['expiredate'], $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_autoemailsadmin_directbeforeexpire_subject, 
							'title' => $setup35_autoemailsadmin_directbeforeexpire_title,
							'content' => $mail_text
						);

						break;

					case 'bankpaymentwaitingmember': /*to USER*/

						$setup35_paymentemails_bankpaymentwaiting_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentwaiting_subject','',''));
						$setup35_paymentemails_bankpaymentwaiting_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentwaiting_title','',''));
						$mail_text = $setup35_paymentemails_bankpaymentwaiting = PFMSIssetControl('setup35_paymentmemberemails_bankpaymentwaiting','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', get_the_title($data['ID']), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_bankpaymentwaiting_subject, 
							'title' => $setup35_paymentemails_bankpaymentwaiting_title,
							'content' => $mail_text);

						break;

					case 'bankpaymentcancelmember': /*to USER*/

						$setup35_paymentemails_bankpaymentcancel_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentcancel_subject','',''));
						$setup35_paymentemails_bankpaymentcancel_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentcancel_title','',''));
						$mail_text = $setup35_paymentemails_bankpaymentcancel = PFMSIssetControl('setup35_paymentmemberemails_bankpaymentcancel','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', $data['ID'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_bankpaymentcancel_subject, 
							'title' => $setup35_paymentemails_bankpaymentcancel_title,
							'content' => $mail_text);

						break;

					case 'bankpaymentapprovedmember': /*to USER*/

						$setup35_paymentemails_bankpaymentapp_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentapp_subject','',''));
						$setup35_paymentemails_bankpaymentapp_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_bankpaymentapp_title','',''));
						$mail_text = $setup35_paymentemails_bankpaymentapp = PFMSIssetControl('setup35_paymentmemberemails_bankpaymentapp','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', get_the_title($data['ID']), $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_bankpaymentapp_subject, 
							'title' => $setup35_paymentemails_bankpaymentapp_title,
							'content' => $mail_text);

						break;

					case 'recurringprofilecreatedmember': /*to ADMIN*/

						$setup35_paymentemails_newrecpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newrecpayment_subject','',''));
						$setup35_paymentemails_newrecpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newrecpayment_title','',''));
						$mail_text = $setup35_paymentemails_newrecpayment = PFMSIssetControl('setup35_paymentmemberemails_newrecpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%userid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%ordernumber%%', $data['title'], $mail_text );
							$mail_text = str_replace( '%%ordereditadminlink%%', admin_url('post.php?post='.$data['orderid'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
							$mail_text = str_replace( '%%nextpayment%%', $data['nextpayment'], $mail_text );
							$mail_text = str_replace( '%%profileid%%', $data['profileid'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_newrecpayment_subject, 
							'title' => $setup35_paymentemails_newrecpayment_title,
							'content' => $mail_text);

						break;

					case 'freepaymentreceivedmember': /*to ADMIN*/

						$setup35_paymentmemberemails_newdirectpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newfreepayment_subject','',''));
						$setup35_paymentmemberemails_newdirectpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newfreepayment_title','',''));
						$mail_text = $setup35_paymentmemberemails_newdirectpayment = PFMSIssetControl('setup35_paymentmemberemails_newfreepayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%ordereditlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentmemberemails_newdirectpayment_subject, 
							'title' => $setup35_paymentmemberemails_newdirectpayment_title,
							'content' => $mail_text);

						break;

					case 'newpaymentreceivedmember': /*to ADMIN*/

						$setup35_paymentmemberemails_newdirectpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newdirectpayment_subject','',''));
						$setup35_paymentmemberemails_newdirectpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newdirectpayment_title','',''));
						$mail_text = $setup35_paymentmemberemails_newdirectpayment = PFMSIssetControl('setup35_paymentmemberemails_newdirectpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', $data['ID'], $mail_text );
							$mail_text = str_replace( '%%ordereditlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentmemberemails_newdirectpayment_subject, 
							'title' => $setup35_paymentmemberemails_newdirectpayment_title,
							'content' => $mail_text);

						break;

					case 'newbankpreceivedmember': /*to ADMIN*/

						$setup35_paymentemails_newbankpayment_subject = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newbankpayment_subject','',''));
						$setup35_paymentemails_newbankpayment_title = esc_attr(PFMSIssetControl('setup35_paymentmemberemails_newbankpayment_title','',''));
						$mail_text = $setup35_paymentemails_newbankpayment = PFMSIssetControl('setup35_paymentmemberemails_newbankpayment','','');

						if(PFControlEmptyArr($data)){
							$mail_text = str_replace( '%%orderid%%', get_the_title($data['ID']), $mail_text );
							$mail_text = str_replace( '%%orderadminlink%%', admin_url('post.php?post='.$data['ID'].'&action=edit'), $mail_text );
							$mail_text = str_replace( '%%paymenttotal%%', $data['paymenttotal'], $mail_text );
							$mail_text = str_replace( '%%packagename%%', $data['packagename'], $mail_text );
						}

						return array(
							'subject' => $setup35_paymentemails_newbankpayment_subject, 
							'title' => $setup35_paymentemails_newbankpayment_title,
							'content' => $mail_text);

						break;


				}
			}
		/**
		*End : Get emails from admin.
		**/

/**
*End : User system emails
**/
?>