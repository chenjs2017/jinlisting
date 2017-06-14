<?php 
/**********************************************************************************************************************************
*
* User Dashboard Page - Profile Form Request
* 
* Author: Webbu Design
***********************************************************************************************************************************/


if(isset($_GET['ua']) && $_GET['ua']!=''){
	$ua_action = esc_attr($_GET['ua']);
}
if(isset($ua_action)){
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$errorval = '';
	$sccval = '';
	/**
	*Start: Profile Form Request
	**/
		if(isset($_POST) && $_POST!='' && count($_POST)>0){

			if (esc_attr($_POST['action']) == 'pfget_updateuserprofile') {

				$nonce = esc_attr($_POST['security']);
				if ( ! wp_verify_nonce( $nonce, 'pfget_updateuserprofile' ) ) {
					die( 'Security check' ); 
				}	

				
					$vars = $_POST;

				    $vars = PFCleanArrayAttr('PFCleanFilters',$vars);
					
					$newupload = '';
					if($user_id != 0){

						global $wpdb;

						// Sanitize the new username
		                $pf_username       = sanitize_user( $_POST['username'] );
		                $pf_username       = esc_sql( $pf_username );
		                $pf_username_old   = esc_sql( $_POST['username_old'] );

	                    $current_user = wp_get_current_user();

                    	if( username_exists( $pf_username ) && $current_user->user_login != $pf_username ) {
	                        /*Username already exist. */
	                    	$errorval .= esc_html__( 'Username already exist. Not changed.', 'pointfindert2d' );
	                    } else{
	                    	if($current_user->user_login == $pf_username_old){
		                    	if( $pf_username != $pf_username_old ) {
			                        /* Update username*/
			                        $result_username = $wpdb->query($wpdb->prepare( "UPDATE $wpdb->users SET user_login = %s WHERE user_login = %s", $pf_username, $pf_username_old ));

			                        if( $result_username === false ) {
			                            $errorval .= sprintf( esc_html__( 'A database error occurred : %s', 'pointfindert2d' ), $wpdb->last_error );
			                        }else{
			                        	$sccval .= sprintf( esc_html__( 'New Username : %s', 'pointfindert2d' ), $pf_username ).'<br/><strong>'.esc_html__('You must be login again. Now redirecting to Home Page in 3 seconds.','pointfindert2d').'</strong><br/> ';
			                        	$sccval .= "
										   <script type='text/javascript'>
									      (function($) {
									      'use strict';
										      $(function(){
												setTimeout(function() {
													window.location = '".esc_url(home_url())."';
												}, 3000);
										      });
									      })(jQuery);
									      </script>
			                        	";
			                        }
			                    }else{
			                    	/*Username not changed.*/
			                    }
			                }else{
			                	/*Current user login and old username not same. There is a cheat.*/
			                }
	                    }
	                    
		                

						$arg = array('ID' => $user_id);

						$arg['user_url'] = esc_url($vars['webaddr']);


						if(isset($vars['email'])){
						$arg['user_email'] = $vars['email'];
						}

						if(isset($vars['nickname'])){
						$arg['nickname'] = $vars['nickname'];
						}

						if(isset($vars['password']) && isset($vars['password2']) && $vars['password'] != '' && $vars['password2'] != ''){
							wp_set_password( $vars['password'], $user_id );
						}

						wp_update_user($arg); 

						update_user_meta($user_id, 'first_name', $vars['firstname']);
						update_user_meta($user_id, 'last_name', $vars['lastname']);
						update_user_meta($user_id, 'description', $vars['descr']);
						update_user_meta($user_id, 'user_facebook', $vars['facebook']);
						update_user_meta($user_id, 'user_googleplus', $vars['googleplus']);
						update_user_meta($user_id, 'user_linkedin', $vars['linkedin']);
						update_user_meta($user_id, 'user_twitter', $vars['twitter']);
						update_user_meta($user_id, 'user_phone', $vars['phone']);
						update_user_meta($user_id, 'user_mobile', $vars['mobile']);
						
						if(isset($vars['vatnumber'])){update_user_meta($user_id, 'user_vatnumber', $vars['vatnumber']);}
						if(isset($vars['country'])){update_user_meta($user_id, 'user_country', $vars['country']);}
						if(isset($vars['address'])){update_user_meta($user_id, 'user_address', $vars['address']);}
						

						
						
						if ( isset($_FILES['userphoto'])) {   
							if ( $_FILES['userphoto']['size'] >0) {      
							    $file = array(
							      'name'     => $_FILES['userphoto']['name'],
							      'type'     => $_FILES['userphoto']['type'],
							      'tmp_name' => $_FILES['userphoto']['tmp_name'],
							      'error'    => $_FILES['userphoto']['error'],
							      'size'     => $_FILES['userphoto']['size']
							    );
							    $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');
							    
							    if(!in_array($_FILES['userphoto']['type'], $allowed_file_types)) { // wrong file type
							      $errorval .= esc_html__("Please upload a JPG, GIF, or PNG file.<br>",'pointfindert2d');
							    }else{

								    $_FILES = array("userphoto" => $file);
								    foreach ($_FILES as $file => $array) {
								      $newupload = pft_insert_attachment($file);
								      update_user_meta($user_id, 'user_photo', $newupload); 
								    }
								}
							}
						}

						if(isset($vars['deletephoto'])){
						if($vars['deletephoto'] == 1){

						  if(wp_delete_attachment(get_user_meta( $user_id, 'user_photo',true ),true)){
						     update_user_meta($user_id, 'user_photo', '');
						     $newuploadphoto = get_template_directory_uri().'/images/noimg.png';
						  }
						  
						}
						}

						if($newupload != '' && !isset($newuploadphoto)){
						$newuploadphoto = wp_get_attachment_image_src( $newupload );
						$newuploadphoto = $newuploadphoto[0];
						}else{
						if(!isset($newuploadphoto)){
						  $newuploadphoto = '';
						}

						}

						$sccval .= '<strong>'.esc_html__('Your update was successful.','pointfindert2d').'</strong>';

					}else{
					    $errorval .= esc_html__('Please login again to update profile (Invalid UserID).','pointfindert2d');
				  	}

				
			}
		}
	/**
	*End: Profile Form Request
	**/
}
?>