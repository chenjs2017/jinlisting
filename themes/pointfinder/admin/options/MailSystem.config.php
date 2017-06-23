<?php
/**********************************************************************************************************************************
*
* Main Admin Options Config File
*
* Author: Webbu Design
*
***********************************************************************************************************************************/

if (!class_exists("Redux_Framework_PF_Mail_Config")) {
	class Redux_Framework_PF_Mail_Config

	{
		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;
		
		public function __construct(){
			if (!class_exists("ReduxFramework")) {return;}
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {$this->initSettings();} else {add_action('plugins_loaded', array($this, 'initSettings'), 10);}
		}


		public function initSettings(){

			$this->setArguments();
			$this->setSections();
			if (!isset($this->args['opt_name'])) { return;}
			 
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
		}

		


		public function setSections(){
			

			/**
			*EMAIL SETTINS 
			**/
				/**
				*Start: Email Limits
				**/
					$this->sections[] = array(
						'id' => 'setup33_emaillimits',
						'icon' => 'el-icon-unlock-alt',
						'title' => esc_html__('Email Permissions', 'pointfindert2d'),
						'fields' => array(
								array(
									'id' => 'setup33_emaillimits_listingautowarning',
									'type' => 'button_set',
									'title' => esc_html__('Item Expire Date Warning', 'pointfindert2d') ,
									'desc'		=> esc_html__('If this option is enabled, the owner of item will receive an email before item expires.','pointfindert2d').'<br>'.esc_html__('(Sending time: 24 hours before expire time.)', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,
								array(
									'id' => 'setup33_emaillimits_listingexpired',
									'type' => 'button_set',
									'title' => esc_html__('Item Expiration', 'pointfindert2d') ,
									'desc'		=> esc_html__('If this option is enabled, the owner of item will receive an email after item expires.', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,
								array(
									'id' => 'setup33_emaillimits_adminemailsafterupload',
									'type' => 'button_set',
									'title' => esc_html__('New Upload: Admin Notification', 'pointfindert2d') ,
									'desc'		=> esc_html__('Do you want to receive an email after new item is uploaded?', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,
								array(
									'id' => 'setup33_emaillimits_adminemailsafteredit',
									'type' => 'button_set',
									'title' => esc_html__('Item Edit: Admin Notification', 'pointfindert2d') ,
									'desc'		=> esc_html__('Do you want to receive an email after item is edited?', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,

								array(
									'id' => 'setup33_emaillimits_useremailsaftertrash',
									'type' => 'button_set',
									'title' => esc_html__('Item Delete: User Notification', 'pointfindert2d') ,
									'desc'		=> esc_html__('Do you want to send an email after item is deleted by admin?', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,

								array(
									'id' => 'setup33_emaillimits_copyofcontactform',
									'type' => 'button_set',
									'title' => esc_html__('Item Contact Form: Send a copy to Admin', 'pointfindert2d') ,
									'desc'		=> esc_html__('Do you want to send a copy of every single item contact form to yourself?', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,

								array(
									'id' => 'setup33_emaillimits_copyofreviewform',
									'type' => 'button_set',
									'title' => esc_html__('Item Review Form: Send a copy to Admin', 'pointfindert2d') ,
									'desc'		=> esc_html__('Do you want to send a copy of every single item review form to yourself?', 'pointfindert2d'),
									'options' => array(
										'1' => esc_html__('Yes', 'pointfindert2d') ,
										'0' => esc_html__('No', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,
							)
					);
				
				/**
				*End: Email Limits
				**/






				/**
				*Start: Email Settings
				**/
					$this->sections[] = array(
						'id' => 'setup33_emailsettings',
						'icon' => ' el-icon-wrench-alt',
						'title' => esc_html__('Email Settings', 'pointfindert2d'),
						'fields' => array(
								array(
									'id' => 'setup33_emailsettings_ed',
									'type' => 'button_set',
									'title' => esc_html__('PointFinder Email System', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Enabled', 'pointfindert2d') ,
										'0' => esc_html__('Disabled', 'pointfindert2d')
									) ,
									'desc' => esc_html__('If this disabled, then you can use another smtp plugin. Note: System will use PointFinder templates while sending email even if you disable this.','pointfindert2d'),
									'default' => 1
									
								) ,
								array(
			                        'id'        => 'setup33_emailsettings_sitename',
			                        'type'      => 'text',
			                        'title'     => esc_html__('Site Name', 'pointfindert2d'),
			                        'default'   => '',
									'hint' => array(
										'content'   => esc_html__('Please write site name for email header.','pointfindert2d')
									),
									'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
								array(
			                        'id'        => 'setup33_emailsettings_fromname',
			                        'type'      => 'text',
			                        'title'     => esc_html__('From Name', 'pointfindert2d'),
			                        'default'   => '',
									'hint' => array(
										'content'   => esc_html__('Email from this name.','pointfindert2d')
									),
									'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
								array(
			                        'id'        => 'setup33_emailsettings_fromemail',
			                        'type'      => 'text',
			                        'title'     => esc_html__('From Email', 'pointfindert2d'),
			                        'validate'  => 'email',
			                        'msg'       => esc_html__('Please write a correct email.','pointfindert2d'),
			                        'default'   => '',
									'text_hint' => array(
										'title'     => esc_html__('Valid Email Required!','pointfindert2d'),
										'content'   => esc_html__('This field required a valid email address.','pointfindert2d')
									),
									'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
			                    array(
			                        'id'        => 'setup33_emailsettings_mainemail',
			                        'type'      => 'text',
			                        'title'     => esc_html__('Receive Email', 'pointfindert2d'),
			                        'validate'  => 'email',
			                        'msg'       => esc_html__('Please write a correct email.','pointfindert2d'),
			                        'desc'       => esc_html__('This email address will receive all system emails such as payment, item submission, etc.','pointfindert2d'),
			                        'default'   => '',
									'text_hint' => array(
										'title'     => esc_html__('Valid Email Required!','pointfindert2d'),
										'content'   => esc_html__('This field required a valid email address.','pointfindert2d')
									),
									'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
			                    array(
									'id' => 'setup33_emailsettings_mailtype',
									'type' => 'button_set',
									'title' => esc_html__('Content Type', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('HTML', 'pointfindert2d') ,
										'0' => esc_html__('Plain Text', 'pointfindert2d')
									) ,
									'hint' => array(
										'content'   => esc_html__('Do you want to send emails Plain Text or HTML format? Recommended: HTML','pointfindert2d')
									),
									'default' => '1',
									'required' => array('setup33_emailsettings_ed','=',1)
									
								) ,
			                    array(
									'id' => 'setup33_emailsettings_auth',
									'type' => 'button_set',
									'title' => esc_html__('SMTP Authentication', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Enable', 'pointfindert2d') ,
										'0' => esc_html__('Disable', 'pointfindert2d')
									) ,
									'default' => '0',
									'required' => array('setup33_emailsettings_ed','=',1)
									
								) ,
								array(
			                        'id'        => 'setup33_emailsettings_smtpaccount',
			                        'type'      => 'password',
			                        'username'  => true,
			                        'title'     => 'SMTP Account',
			                        'hint' => array(
										'content'   => esc_html__('Email server outgoing username & password.','pointfindert2d')
									),
									'required'	=> array(array('setup33_emailsettings_auth','=',1),array('setup33_emailsettings_ed','=',1))
			                    ),
			                    array(
			                        'id'        => 'setup33_emailsettings_smtp',
			                        'type'      => 'text',
			                        'title'     => esc_html__('SMTP Server', 'pointfindert2d'),
			                        'default'   => '',
									'hint' => array(
										'content'   => esc_html__('Please write your SMTP server host name or IP address.','pointfindert2d')
									),
									'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
			                    array(
			                        'id'        => 'setup33_emailsettings_smtpport',
			                        'type'      => 'text',
			                        'title'     => esc_html__('SMTP Port', 'pointfindert2d'),
			                        'default'   => '25',
			                        'class'	=> 'small-text',
			                        'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
			                    array(
			                        'id'        => 'setup33_emailsettings_secure',
			                        'type'      => 'button_set',
			                        'title'     => esc_html__('SMTP Secure', 'pointfindert2d'),
			                        'options'   => array(
			                            '' => esc_html__('None','pointfindert2d'), 
			                            'ssl' => esc_html__('SSL','pointfindert2d'), 
			                            'tls' => esc_html__('TLS','pointfindert2d')
			                        ), 
			                        'default'   => '',
			                        'required' => array('setup33_emailsettings_ed','=',1)
			                    ),
			                    array(
			                        'id'        => 'setup33_emailsettings_debug',
			                        'type'      => 'button_set',
			                        'title'     => esc_html__('SMTP DEBUG', 'pointfindert2d'),
			                        'options'   => array(
			                            '1' => esc_html__('Enable','pointfindert2d'), 
			                            '0' => esc_html__('Disable','pointfindert2d')
			                        ), 
			                        'default'   => 0,
			                        'desc'     => esc_html__('Warning: If this enabled then you will see the error text on smtp error. Recommended: Disabled', 'pointfindert2d'),
			                        'required' => array('setup33_emailsettings_ed','=',1)
			                    )
			                   
								
							)
					);

					$this->sections[] = array(
						'id' => 'setup34_emailcontents',
						'icon' => 'el-icon-pencil-alt',
						'title' => esc_html__('Email Contents', 'pointfindert2d'),
						'fields' => array(
								
							)
					);
				/**
				*End: Email Settings
				**/

			
			
				/**
				*Start: Email Contents
				**/
					/**
					*Start: User System Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_loginemails',
							'subsection' => true,
							'title' => esc_html__('User Registration', 'pointfindert2d'),
							'desc'	=> esc_html__('You can change email contents by using below options.', 'pointfindert2d'),
							'fields' => array(
									/**
									*Registration Email
									**/
										array(
					                        'id'        => 'setup35_loginemails_register-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Registration Email', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after user registration.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
											array(
						                        'id'        => 'setup35_loginemails_register_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Registration Completed','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_loginemails_register_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New User Registration','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_loginemails_register_contents',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true,
						                        	'wpautop' => true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display username', 'pointfindert2d'),'%%username%%').'<br>'.sprintf(esc_html__('%s : Display password', 'pointfindert2d'),'%%password%%'),
						                        'validate'  => 'html',
						                    ),
										array(
					                        'id'        => 'setup35_loginemails_register-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                    array(
					                        'id'    => 'opt-divide',
					                        'type'  => 'divide'
					                    ),


					                /**
									*Registration Email to Admin
									**/
										array(
					                        'id'        => 'setup35_loginemails_registeradm-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Registration Email to Admin', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after user registration.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
											array(
						                        'id'        => 'setup35_loginemails_registeradm_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Registration Completed','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_loginemails_registeradm_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New User Registration','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_loginemails_registeradm_contents',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true,
						                        	'wpautop' => true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display username', 'pointfindert2d'),'%%username%%'),
						                        'validate'  => 'html',
						                    ),
										array(
					                        'id'        => 'setup35_loginemails_registeradm-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                    array(
					                        'id'    => 'opt-divide',
					                        'type'  => 'divide'
					                    ),


				                    /**
									*Forgot Password Email
									**/
						                array(
					                        'id'        => 'setup35_loginemails_forgot-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Forgot Password Email', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when forgotten password requests.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
						                    array(
						                        'id'        => 'setup35_loginemails_forgot_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Lost Password Reset','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_loginemails_forgot_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Lost Password Reset','pointfindert2d'),
						                    ),
						                    array(
						                        'id'        => 'setup35_loginemails_forgot_contents',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display username', 'pointfindert2d'),'%%username%%').'<br>'.sprintf(esc_html__('%s : Display reset password link', 'pointfindert2d'),'%%keylink%%'),
						                        'validate'  => 'html',
						                    ),
					                    array(
					                        'id'        => 'setup35_loginemails_forgot-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
								)
						);
					/**
					*End: User System Email Contents
					**/









					/**
					*Start: CONTACT Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_contactformemails',
							'subsection' => true,
							'title' => esc_html__('Contact Form', 'pointfindert2d'),
							'desc'	=> esc_html__('You can change email contents by using below options.', 'pointfindert2d'),
							'fields' => array(
								
								array(
			                        'id'        => 'setup35_contactform_subject',
			                        'type'      => 'text',
			                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
			                        'default'	=> esc_html__('Contact Form','pointfindert2d'),
			                    ),
								array(
			                        'id'        => 'setup35_contactform_title',
			                        'type'      => 'text',
			                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
			                        'default'	=> esc_html__('New Contact Form','pointfindert2d'),
			                    ),
								array(
			                        'id'        => 'setup35_contactform_contents',
			                        'type'      => 'editor',
			                        'args'	=> array(
			                        	'media_buttons'	=> false,
			                        	'teeny'	=> true,
			                        	'wpautop' => true
			                        	),
			                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
			                        'subtitle'	=> sprintf(esc_html__('%s : Display name', 'pointfindert2d'),'%%name%%').
			                        '<br>'.sprintf(esc_html__('%s : Display email', 'pointfindert2d'),'%%email%%').
			                        '<br>'.sprintf(esc_html__('%s : Display subject', 'pointfindert2d'),'%%subject%%').
			                        '<br>'.sprintf(esc_html__('%s : Display phone', 'pointfindert2d'),'%%phone%%').
			                        '<br>'.sprintf(esc_html__('%s : Display message', 'pointfindert2d'),'%%msg%%').
			                        '<br>'.sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%datetime%%'),
			                        'validate'  => 'html',
			                    ),
								

								)
						);
					/**
					*End: CONTACT Email Contents
					**/








					/**
					*Start: Submission Email Contents to USER
					**/
						$this->sections[] = array(
							'id' => 'setup35_submissionemails',
							'subsection' => true,
							'title' => sprintf(esc_html__('Item Submission (%s)', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
							'heading' => esc_html__('New Uploaded Item User Notification Emails', 'pointfindert2d'),
							'desc'	=> sprintf(esc_html__('You can change email contents for %s notification by using below options.', 'pointfindert2d'),esc_html__('user','pointfindert2d')),
							'fields' => array(

									 /**
									*Waiting for PAYMENT email
									**/

					                    array(
					                        'id'        => 'setup35_submissionemails_waitingpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('New Item; Waiting for PAYMENT', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when an item is uploaded and waiting for payment process', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_waitingpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item is waiting for payment','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_waitingpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item is waiting for payment','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_waitingpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_waitingpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),



									/**
									*Waiting for APPROVAL Email
									**/

									 	array(
					                        'id'        => 'setup35_submissionemails_waitingapproval-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('New Item; Waiting for APPROVAL', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after an item is uploaded and payment process is completed.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_waitingapproval_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item is waiting for approval','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_waitingapproval_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item is waiting for approval','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_waitingapproval',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_waitingapproval-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),


						           
					                /**
									*Item APPROVED email
									**/

										array(
					                        'id'        => 'setup35_submissionemails_approveditem-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item; APPROVED', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after an item is approved by admin.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_approveditem_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been approved for listing','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_approveditem_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Approved','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_approveditem',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'.sprintf(esc_html__('%s : Display item link', 'pointfindert2d'),'%%itemlink%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_approveditem-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),


					                /**
									*Item REJECTED email
									**/

					                    array(
					                        'id'        => 'setup35_submissionemails_rejected-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item; REJECTED', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when an item is rejected by admin.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_rejected_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been rejected for listing','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_rejected_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Rejected','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_rejected',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_rejected-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Item DELETED email
									**/

					                    array(
					                        'id'        => 'setup35_submissionemails_deleted-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item; DELETED', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when an item is sent to trash (removed) by admin.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_deleted_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been deleted','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_deleted_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Deleted','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_deleted',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_deleted-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
								)
						);
					/**
					*End: Submission Email Contents to USER
					**/






					/**
					*Start: Submission Email Contents to ADMIN
					**/
						$this->sections[] = array(
							'id' => 'setup35_submissionemailsadmin',
							'subsection' => true,
							'title' => sprintf(esc_html__('Item Submission (%s)', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
							'heading' => esc_html__('Item Upload Emails for the Admin', 'pointfindert2d'),
							'desc'	=> sprintf(esc_html__('You can change email contents for %s notification by using below options.', 'pointfindert2d'),esc_html__('admin','pointfindert2d')),
							'fields' => array(

									/**
									*New item submitted
									**/

					                    array(
					                        'id'        => 'setup35_submissionemails_newitem-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('New Item; Uploaded', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when new item is uploaded and waiting for approval process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_newitem_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('New item has been uploaded','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_newitem_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New item has been uploaded','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_newitem',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'.sprintf(esc_html__('%s : Display item link (For admin)', 'pointfindert2d'),'%%itemlinkadmin%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_newitem-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),


									/**
									*Item Updated email
									**/

					                    array(
					                        'id'        => 'setup35_submissionemails_updateditem-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item; Edited', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when existing item is updated and waiting for approval process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_submissionemails_updateditem_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item edited','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_submissionemails_updateditem_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item edited','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_submissionemails_updateditem',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'.sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'.sprintf(esc_html__('%s : Display item link (For admin)', 'pointfindert2d'),'%%itemlinkadmin%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_submissionemails_updateditem-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
								)
						);
					/**
					*End: Submission Email Contents to ADMIN
					**/





					/**
					*Start: Payment Email Contents (USER)
					**/
						$this->sections[] = array(
							'id' => 'setup35_paymentemails',
							'subsection' => true,
							'title' => sprintf(esc_html__('Payments (PPP) (%s)', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
							'heading' => sprintf(esc_html__('Payment System (PAY PER POST): %s Notifications', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
							'fields' => array(
									/**
									*Direct Payment completed email to USER
									**/
					                    array(
					                        'id'        => 'setup35_paymentemails_paymentcompleted-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_paymentcompleted_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Payment completed','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_paymentcompleted_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Payment completed','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_paymentcompleted',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_paymentcompleted-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

									/**
									*Recurring Payment completed email to USER
									**/

					                    array(
					                        'id'        => 'setup35_paymentemails_paymentcompletedrec-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Recurring Payment Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_paymentcompletedrec_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_paymentcompletedrec_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_paymentcompletedrec',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
						                        .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_paymentcompletedrec-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                
					                /**
									*Bank Payment waiting email to USER
									**/
					                    array(
					                        'id'        => 'setup35_paymentemails_bankpaymentwaiting-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_bankpaymentwaiting_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_bankpaymentwaiting_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_bankpaymentwaiting',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_bankpaymentwaiting-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Bank Payment cancelled email to USER
									**/
					                    array(
					                        'id'        => 'setup35_paymentemails_bankpaymentcancel-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Cancelled', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a cancelled bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_bankpaymentcancel_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_bankpaymentcancel_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_bankpaymentcancel',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_bankpaymentcancel-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

								)
						);
					/**
					*End: Payment Email Contents (USER)
					**/




					/**
					*Start: Payment Email Contents (ADMIN)
					**/
						$this->sections[] = array(
							'id' => 'setup35_paymentemailsadmin',
							'subsection' => true,
							'title' => sprintf(esc_html__('Payments (PPP) (%s)', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
							'heading' => sprintf(esc_html__('Payment System (PAY PER POST): %s Notifications', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
							'fields' => array(
					                /**
									*Direct Payment completed email to ADMIN
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_paymentemails_newdirectpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_newdirectpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('New payment has been received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_newdirectpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New payment has been received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_newdirectpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%itemadminlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_newdirectpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
				                   	/**
									*Recurring Payment completed email to ADMIN
									**/
					                    
					                    array(
					                        'id'        => 'setup35_paymentemails_newrecpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Recurring Payment Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_newrecpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_newrecpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_newrecpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%itemadminlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
						                        .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_newrecpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Bank Payment received email to ADMIN
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_paymentemails_newbankpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_newbankpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_newbankpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_newbankpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%itemadminlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentemails_newbankpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
								)
						);
					/**
					*End: Payment Email Contents (ADMIN)
					**/



					/**
					*Start: Payment Membership Email Contents (USER)
					**/
						$this->sections[] = array(
							'id' => 'setup35_paymentmemberemails',
							'subsection' => true,
							'title' => sprintf(esc_html__('Payments (Member) (%s)', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
							'heading' => sprintf(esc_html__('Payment System (Membership System): %s Notifications', 'pointfindert2d'),esc_html__('User','pointfindert2d')),
							'fields' => array(

									/**
									*Free Payment completed email to USER - done
									**/
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_freecompleted-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Free Plan Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded free plan process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_freecompleted_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Package Activated','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_freecompleted_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Package Activated','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_freecompleted',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display package title', 'pointfindert2d'),'%%packagename%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_freecompleted-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

									/**
									*Direct Payment completed email to USER - done
									**/
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_paymentcompleted-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_paymentcompleted_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Payment completed','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_paymentcompleted_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Payment completed','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_paymentcompleted',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display package title', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_paymentcompleted-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

									/**
									*Recurring Payment completed email to USER - done
									**/

					                    array(
					                        'id'        => 'setup35_paymentmemberemails_paymentcompletedrec-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Recurring Payment Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_paymentcompletedrec_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_paymentcompletedrec_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring profile has been created','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_paymentcompletedrec',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order number', 'pointfindert2d'),'%%ordernumber%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
						                        .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_paymentcompletedrec-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                
					                /**
									*Bank Payment waiting email to USER
									**/
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Completed', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer waiting','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        ,
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_bankpaymentwaiting-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Bank Payment cancelled email to USER
									**/
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_bankpaymentcancel-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Cancelled', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a cancelled bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentcancel_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentcancel_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer request cancelled','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentcancel',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_bankpaymentcancel-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Bank Payment approved email to USER
									**/
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_bankpaymentapp-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Approved', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a approved bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentapp_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer request approved','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentapp_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Bank transfer request approved','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_bankpaymentapp',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%'),
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_bankpaymentapp-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

								)
						);
					/**
					*End: Payment Membership Email Contents (USER)
					**/


					/**
					*Start: Payment Membership Email Contents (ADMIN)
					**/
						$this->sections[] = array(
							'id' => 'setup35_paymentmemberemailsadmin',
							'subsection' => true,
							'title' => sprintf(esc_html__('Payments (Member) (%s)', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
							'heading' => sprintf(esc_html__('Payment System (Membership System): %s Notifications', 'pointfindert2d'),esc_html__('Admin','pointfindert2d')),
							'fields' => array(
									/**
									*Free Payment completed email to ADMIN - done
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_newfreepayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_newfreepayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('New free plan ordered','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_newfreepayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New free plan ordered','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_newfreepayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%ordereditlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_newfreepayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Direct Payment completed email to ADMIN - done
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_newdirectpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded direct payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_newdirectpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('New payment has been received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_newdirectpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New payment has been received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_newdirectpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%ordereditlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_newdirectpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
				                   	/**
									*Recurring Payment completed email to ADMIN - done
									**/
					                    
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_newrecpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Recurring Payment Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded recurring payment process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_newrecpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_newrecpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring Profile has been created','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_newrecpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display User ID', 'pointfindert2d'),'%%userid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display order number', 'pointfindert2d'),'%%ordernumber%%').'<br>'
						                        .sprintf(esc_html__('%s : Display order edit link', 'pointfindert2d'),'%%ordereditadminlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display next payment date', 'pointfindert2d'),'%%nextpayment%%').'<br>'
						                        .sprintf(esc_html__('%s : Display recurring profile ID', 'pointfindert2d'),'%%profileid%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_newrecpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Bank Payment received email to ADMIN
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_paymentmemberemails_newbankpayment-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Bank Payment Request Received Email Content', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent after a succeeded bank payment request process.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_newbankpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_newbankpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('New bank payment transfer request received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_newbankpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display edit link', 'pointfindert2d'),'%%orderadminlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_paymentmemberemails_newbankpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
								)
						);
					/**
					*End: Payment Membership Email Contents (ADMIN)
					**/




					/**
					*Start: Expiry/Expired Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_autoemailsadmin',
							'subsection' => true,
							'title' => esc_html__('Auto System (PPP/Expiry)', 'pointfindert2d'),
							'fields' => array(
					                /**
									*Direct Payment before expire email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_autoemailsadmin_directbeforeexpire-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment: Item Expiring Notification ', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent before item expires.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_directbeforeexpire_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_directbeforeexpire_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_directbeforeexpire',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_autoemailsadmin_directbeforeexpire-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                /**
									*Direct Payment after expire email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_autoemailsadmin_directafterexpire-start',
					                        'type'      => 'section',
					                        'title'     => sprintf(esc_html__('%s: Item Expired Notification', 'pointfindert2d'),esc_html__('Direct Payment','pointfindert2d')),
					                        'subtitle'  => esc_html__('This email will be sent after item is expired.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_autoemailsadmin_directafterexpire_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_autoemailsadmin_directafterexpire_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_autoemailsadmin_directafterexpire',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_autoemailsadmin_directafterexpire-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
				                   	/**
									*Recurring Payment expired email content
									**/
					                    
					                    array(
					                        'id'        => 'setup35_autoemailsadmin_expiredrecpayment-start',
					                        'type'      => 'section',
					                        'title'     => sprintf(esc_html__('%s: Item Expired Notification', 'pointfindert2d'),esc_html__('Recurring Payment','pointfindert2d')),
					                        'subtitle'  => esc_html__('This email will be sent after item is expired.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentemails_expiredrecpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentemails_expiredrecpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentemails_expiredrecpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item ID', 'pointfindert2d'),'%%itemid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display item title', 'pointfindert2d'),'%%itemname%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_autoemailsadmin_expiredrecpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                    

								)
						);
					/**
					*End: Expiry/Expired Email Contents
					**/


					/**
					*Start: Membership Expiry/Expired Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_autoemailsmemberadmin',
							'subsection' => true,
							'title' => esc_html__('Auto System (Member/Expiry)', 'pointfindert2d'),
							'fields' => array(
					                /**
									*Direct Payment before expire email content - done
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_autoemailsmemberadmin_directbeforeexpire-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Direct Payment: Plan Expiring Notification ', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent before plan expires.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_directbeforeexpire_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_directbeforeexpire_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Expiration date of your item','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_directbeforeexpire',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_autoemailsmemberadmin_directbeforeexpire-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                /**
									*Direct Payment after expire email content - done
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_autoemailsmemberadmin_directafterexpire-start',
					                        'type'      => 'section',
					                        'title'     => sprintf(esc_html__('%s: Plan Expired Notification', 'pointfindert2d'),esc_html__('Direct Payment','pointfindert2d')),
					                        'subtitle'  => esc_html__('This email will be sent after plan is expired.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_autoemailsmemberadmin_directafterexpire_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_autoemailsmemberadmin_directafterexpire_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Your item has been expired','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_autoemailsmemberadmin_directafterexpire',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_autoemailsmemberadmin_directafterexpire-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
				                   	/**
									*Recurring Payment expired email content - done
									**/
					                    
					                    array(
					                        'id'        => 'setup35_autoemailsmemberadmin_expiredrecpayment-start',
					                        'type'      => 'section',
					                        'title'     => sprintf(esc_html__('%s: Plan Expired Notification', 'pointfindert2d'),esc_html__('Recurring Payment','pointfindert2d')),
					                        'subtitle'  => esc_html__('This email will be sent after plan is expired.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_paymentmemberemails_expiredrecpayment_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring Profile Cancelled','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_paymentmemberemails_expiredrecpayment_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Recurring Profile Cancelled','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_paymentmemberemails_expiredrecpayment',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display order ID', 'pointfindert2d'),'%%orderid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display payment total', 'pointfindert2d'),'%%paymenttotal%%').'<br>'
						                        .sprintf(esc_html__('%s : Display packagename', 'pointfindert2d'),'%%packagename%%').'<br>'
						                        .sprintf(esc_html__('%s : Display expire date', 'pointfindert2d'),'%%expiredate%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_autoemailsmemberadmin_expiredrecpayment-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
								)
						);
					/**
					*End: Membership Expiry/Expired Email Contents
					**/




					/**
					*Start: Item Contact Form Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_itemcontact',
							'subsection' => true,
							'title' => esc_html__('Item Contact Form', 'pointfindert2d'),
							'fields' => array(
					                /**
									*Item Contact Form to User email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemcontact_enquiryformuser-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Contact Form: To User', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a user item contact form submitted.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemcontact_enquiryformuser_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Contact Form Received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemcontact_enquiryformuser_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Contact Form Received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemcontact_enquiryformuser',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender phone', 'pointfindert2d'),'%%phone%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemcontact_enquiryformuser-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                /**
									*Item Contact Form to Admin email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemcontact_enquiryformadmin-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Contact Form: To Admin', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a user item contact form submitted.(A copy to Admin)', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemcontact_enquiryformadmin_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('(User) Contact Form Received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemcontact_enquiryformadmin_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('(User) Contact Form Received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemcontact_enquiryformadmin',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display user info', 'pointfindert2d'),'%%userinfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender phone', 'pointfindert2d'),'%%phone%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemcontact_enquiryformadmin-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

								)
						);
					/**
					*End: Item Contact Form Email Contents
					**/





					/**
					*Start: Item Review Form Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_itemreview',
							'subsection' => true,
							'title' => esc_html__('Item Review Form', 'pointfindert2d'),
							'fields' => array(
					                /**
									*Item Review Form to User email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemreview_reviewformuser-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Review Form: To User', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a user item review form submitted.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemreview_reviewformuser_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Review Form Received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemreview_reviewformuser_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Review Form Received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemreview_reviewformuser',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemreview_reviewformuser-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					                /**
									*Item Review Form to Admin email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemreview_reviewformadmin-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Review Form: To Admin', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a user item review form submitted.(A copy to Admin)', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemreview_reviewformadmin_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('(User) Review Form Received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemreview_reviewformadmin_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('(User) Review Form Received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemreview_reviewformadmin',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display review edit link', 'pointfindert2d'),'%%reveditlink%%').'<br>'
						                        .sprintf(esc_html__('%s : Display user info', 'pointfindert2d'),'%%userinfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemreview_reviewformadmin-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

					                /**
									*Item Review Flag Form to Admin email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemreview_reviewflagformadmin-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Review Flag Form: To Admin', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a review comment has been flagged.(to Admin)', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemreview_reviewflagformadmin_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('A review flagged for re-check','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemreview_reviewflagformadmin_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('A review flagged for re-check','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemreview_reviewflagformadmin',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display review info', 'pointfindert2d'),'%%reviewinfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display user info', 'pointfindert2d'),'%%userinfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender reason', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemreview_reviewflagformadmin-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),

								)
						);
					/**
					*End: Item Review Form Email Contents
					**/



					/**
					*Start: Item Report Form Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_itemreport',
							'subsection' => true,
							'title' => esc_html__('Item Report Form', 'pointfindert2d'),
							'fields' => array(
					                /**
									*Item Report Form to User email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemcontact_report-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Report Form: To User', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a user item report form, submitted.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemcontact_report_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Report Form Received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemcontact_report_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Report Form Received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemcontact_report',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender UserID', 'pointfindert2d'),'%%userid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemcontact_report-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					               

								)
						);
					/**
					*End: Item Report Form Email Contents
					**/


					/**
					*Start: Item Claim Form Email Contents
					**/
						$this->sections[] = array(
							'id' => 'setup35_itemclaim',
							'subsection' => true,
							'title' => esc_html__('Item Claim Form', 'pointfindert2d'),
							'fields' => array(
					                /**
									*Item Claim Form to Admin email content
									**/
				                    	
					                    array(
					                        'id'        => 'setup35_itemcontact_claim-start',
					                        'type'      => 'section',
					                        'title'     => esc_html__('Item Claim Form: To Admin', 'pointfindert2d'),
					                        'subtitle'  => esc_html__('This email will be sent when a user item claim form, submitted.', 'pointfindert2d'),
					                        'indent'    => true, 
					                        
					                    ),
					                    	array(
						                        'id'        => 'setup35_itemcontact_claim_subject',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Subject', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Claim Form Received','pointfindert2d'),
						                    ),
											array(
						                        'id'        => 'setup35_itemcontact_claim_title',
						                        'type'      => 'text',
						                        'title'     => esc_html__('Email Title', 'pointfindert2d'),
						                        'default'	=> esc_html__('Item Claim Form Received','pointfindert2d'),
						                    ),
										 	array(
						                        'id'        => 'setup35_itemcontact_claim',
						                        'type'      => 'editor',
						                        'args'	=> array(
						                        	'media_buttons'	=> false,
						                        	'teeny'	=> true
						                        	),
						                        'title'     => esc_html__('Email Content', 'pointfindert2d'),
						                        'subtitle'	=> sprintf(esc_html__('%s : Display item info', 'pointfindert2d'),'%%iteminfo%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender name', 'pointfindert2d'),'%%name%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender email', 'pointfindert2d'),'%%email%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender phone', 'pointfindert2d'),'%%phone%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender message', 'pointfindert2d'),'%%message%%').'<br>'
						                        .sprintf(esc_html__('%s : Display sender UserID', 'pointfindert2d'),'%%userid%%').'<br>'
						                        .sprintf(esc_html__('%s : Display date time', 'pointfindert2d'),'%%date%%').'<br>',
						                        'validate'  => 'html',
						                    ),
						                array(
					                        'id'        => 'setup35_itemcontact_claim-end',
					                        'type'      => 'section',
					                        'indent'    => false, 
					                    ),
					               

								)
						);
					/**
					*End: Item Claim Form Email Contents
					**/



				/**
				*End: Email Contents
				**/


				/**
				*Start: Email Template Settings
				**/
					$this->sections[] = array(
						'id' => 'setup35_template',
						'icon' => 'el-icon-website-alt',
						'title' => esc_html__('Email Template', 'pointfindert2d'),
						'fields' => array(
								array(
									'id' => 'setup35_template_rtl',
									'type' => 'button_set',
									'title' => esc_html__('Text Direction', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Show Right to Left', 'pointfindert2d') ,
										'0' => esc_html__('Show Left to Right', 'pointfindert2d')
									) ,
									'default' => '0'
									
								) ,

								array(
									'id' => 'setup35_template_logo',
									'type' => 'button_set',
									'title' => esc_html__('Template Logo', 'pointfindert2d') ,
									'options' => array(
										'1' => esc_html__('Show Logo', 'pointfindert2d') ,
										'0' => esc_html__('Show Text', 'pointfindert2d')
									) ,
									'default' => '1'
									
								) ,

								array(
			                        'id'        => 'setup35_template_logotext',
			                        'type'      => 'text',
			                        'title'     => esc_html__('Logo Text', 'pointfindert2d'),
			                        'required'   => array('setup35_template_logo','=','0'),
			                        'text_hint' => array(
			                            'title'     => '',
			                            'content'   => esc_html__('Please type your logo text. Ex: Pointfinder','pointfindert2d')
			                        )
			                    ),

								array(
			                        'id'        => 'setup35_template_mainbgcolor',
			                        'type'      => 'color',
			                        'title'     => esc_html__('Main Background Color', 'pointfindert2d'),
			                        'default'   => '#F0F1F3',
			                        'validate'  => 'color',
			                        'transparent'	=> false
			                    ),

								array(
			                        'id'        => 'setup35_template_headerfooter',
			                        'type'      => 'color',
			                        'title'     => esc_html__('Header / Footer: Background Color', 'pointfindert2d'),
			                        'default'   => '#f7f7f7',
			                        'validate'  => 'color',
			                         'transparent'	=> false
			                    ),

			                    array(
			                        'id'        => 'setup35_template_headerfooter_line',
			                        'type'      => 'color',
			                        'title'     => esc_html__('Header / Footer: Line Color', 'pointfindert2d'),
			                        'default'   => '#F25555',
			                        'validate'  => 'color',
			                         'transparent'	=> false
			                    ),

			                    
			                    array(
			                        'id'        => 'setup35_template_headerfooter_text',
			                        'type'      => 'link_color',
			                        'title'     => esc_html__('Header / Footer: Text/Link Color', 'pointfindert2d'),
			                        //'regular'   => false, 
			                        //'hover'     => false,
			                        'active'    => false,
			                        'visited'   => false,
			                        'default'   => array(
			                            'regular'   => '#494949',
			                            'hover'     => '#F25555',
			                        )
			                    ),

			                    array(
			                        'id'        => 'setup35_template_contentbg',
			                        'type'      => 'color',
			                        'title'     => esc_html__('Content: Background Color', 'pointfindert2d'),
			                        'default'   => '#ffffff',
			                        'validate'  => 'color',
			                         'transparent'	=> false
			                    ),

			                    array(
			                        'id'        => 'setup35_template_contenttext',
			                        'type'      => 'link_color',
			                        'title'     => esc_html__('Content: Text/Link Color', 'pointfindert2d'),
			                        //'regular'   => false, 
			                        //'hover'     => false,
			                        'active'    => false,
			                        'visited'   => false,
			                        'default'   => array(
			                            'regular'   => '#494949',
			                            'hover'     => '#F25555',
			                        )
			                    ),

								array(
			                        'id'        => 'setup35_template_footertext',
			                        'type'      => 'textarea',
			                        'title'     => esc_html__('Footer Text', 'pointfindert2d'),
			                        'desc'		=> esc_html__('%%siteurl%% : Site URL', 'pointfindert2d').'<br>'.esc_html__('%%sitename%% : Site Name', 'pointfindert2d'),
			                        'default'	=> 'This is an automated email from <a href="%%siteurl%%">%%sitename%%</a>'
			                    ),
							)
					);
				/**
				*End: Email Template Settings
				**/
			/**
			*EMAIL SETTINS
			**/
			
		}

		public function setArguments(){
			$this->args = array(
				'opt_name'             => 'pointfindermail_options',
				"global_variable" 	   => "pointfindermail_option",
                'display_name'         => esc_html__('Point Finder Mail System Config','pointfindert2d'),
                'menu_type'            => 'submenu',
                'page_parent'          => 'pointfinder_tools',
                'menu_title'           => esc_html__('Mail System Config','pointfindert2d'),
                'page_title'           => esc_html__('Point Finder Mail System Config', 'pointfindert2d'),
                'admin_bar'            => false,
                'allow_sub_menu'       => false,
                'admin_bar_priority'   => 50,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,
                'menu_icon'            => 'dashicons-email',
                'page_slug'            => '_pfmailoptions',
                'save_defaults'        => true,
                'default_show'         => false,
                'default_mark'         => '',
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => false,
                'output_tag'           => false,
                'database'             => '',
                'system_info'          => false,
                'domain'               => 'redux-framework',
                'hide_reset'           => true,
                'update_notice'        => false,

			);
			$this->args['global_variable'] = 'pointfindermail_option';

		}
	}
	new Redux_Framework_PF_Mail_Config();
}