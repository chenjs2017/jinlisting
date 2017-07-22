<?php
/**********************************************************************************************************************************
*
* Ajax Modal System Actions
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_modalsystemhandler', 'pf_ajax_modalsystemhandler' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_modalsystemhandler', 'pf_ajax_modalsystemhandler' );

function pf_ajax_modalsystemhandler(){
	//Security
  check_ajax_referer( 'pfget_modalsystemhandler', 'security' );

	header('Content-Type: application/json; charset=UTF-8;');

	//Get form type
	if(isset($_POST['formtype']) && $_POST['formtype']!=''){
		$formtype = esc_attr($_POST['formtype']);
	}


  //Get form data
  if(isset($_POST['vars']) && $_POST['vars']!=''){
    $vars = array();
    parse_str($_POST['vars'], $vars);

    if (is_array($vars)) {
        $vars = PFCleanArrayAttr('PFCleanFilters',$vars);
    } else {
        $vars = esc_attr($vars);
    }
  }
  $pfrecheck = PFRECIssetControl('setupreCaptcha_general_status','','0');
  $pfrecheckcon = PFRECIssetControl('setupreCaptcha_general_con_agent_status','','0');

  $recaptcha_err1 = esc_html__('Wrong reCaptcha. Please verify first.','pointfindert2d' );
  $recaptcha_err2 = esc_html__( 'Please enter reCaptcha!','pointfindert2d' );

  $item_err1 = esc_html__('The e-mail could not be sent.','pointfindert2d') . "<br />\n" . esc_html__('Possible reason: Your host may have disabled the mail() function...','pointfindert2d');
  $item_err2 = sprintf(esc_html__('Your %s received successfully.','pointfindert2d' ),esc_html__('message','pointfindert2d'));
  $item_err3 = esc_html__( 'Undefined Item. Please send this form by using contact link.','pointfindert2d' );
  $item_err4 = esc_html__( 'Your review is successfull but information email could not be sent.','pointfindert2d' ). "<br />\n" . esc_html__('Possible reason: Your host may have disabled the mail() function...','pointfindert2d');
  $item_err5 = sprintf(esc_html__('Your %s received successfully.','pointfindert2d' ),esc_html__('review','pointfindert2d'));
  $item_err6 = esc_html__('We will add your review after check.','pointfindert2d');
  $item_err7 = esc_html__('Sorry, but you have already reviewed this item.','pointfindert2d');
  $item_err8 = esc_html__('Sorry, but you could not review your item.','pointfindert2d');
  $item_err9 = sprintf(esc_html__('Your %s received successfully.','pointfindert2d' ),esc_html__('report','pointfindert2d'));
  $item_err10 = sprintf(esc_html__('Your %s received successfully.','pointfindert2d' ),esc_html__('review flag','pointfindert2d'));
  $item_err11 = sprintf(esc_html__('Your %s received successfully.','pointfindert2d' ),esc_html__('contact form','pointfindert2d'));
  $item_err12 = sprintf(esc_html__('Your %s received successfully.','pointfindert2d' ),esc_html__('claim request','pointfindert2d'));

	switch($formtype){
/**
*Enquiry Form
**/
		case 'enquiryform':
      if (is_array($vars)) {
        $workdone = 0;

        if (isset($vars['itemid'])) {
          global $wpdb;
          $user_id = $wpdb->get_var( $wpdb->prepare("SELECT post_author FROM $wpdb->posts where ID = %d",$vars['itemid']) );
        
          $user = get_user_by( 'id', $user_id );

          /* Normally contact with user */
          $user_req_email = $user->user_email;


          /* If post have agent */
          if(isset($vars['itemid'])){
            if(PFcheck_postmeta_exist('webbupointfinder_item_agents',$vars['itemid'])){
              $item_agents = esc_attr(get_post_meta( $vars['itemid'], "webbupointfinder_item_agents", true ));
            }
            
            if(isset($item_agents)){
              $user_req_email = esc_attr(get_post_meta( $item_agents, 'webbupointfinder_agent_email', true ));
            }
          }


          /* If user and agent linked pass the item's agent and user contact */
          $user_agent_link = get_user_meta( $user_id, 'user_agent_link', true );

          if(!empty($user_agent_link)){

            $setup3_pointposttype_pt8 = PFSAIssetControl('setup3_pointposttype_pt8','','agents');
            $user_agent_link_correction = $wpdb->get_var( $wpdb->prepare("SELECT post_title FROM $wpdb->posts where post_type = %s and ID = %d",$setup3_pointposttype_pt8,$user_agent_link));

            if(!empty($user_agent_link_correction)){
              $user_req_email = sanitize_email(get_post_meta( $user_agent_link, 'webbupointfinder_agent_email', true ));
            }
          
          }


          $setup33_emaillimits_copyofcontactform = PFMSIssetControl('setup33_emaillimits_copyofcontactform','','1');
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');

          if ( $pfrecheck == 1 && $pfrecheckcon == 1) {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;
                  
              }else{
                echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{
            $workdone = 1;
          }




          if ($workdone == 1) {
            $phone_inf = (isset($vars['phone']))?$vars['phone']:'';
            $message_reply = pointfinder_mailsystem_mailsender(
              array(
                'toemail' => $user_req_email,
                'predefined' => 'enquiryformuser',
                'data' => array('name' => $vars['name'],'email'=>$vars['email'],'phone'=>$phone_inf,'message'=>$vars['msg'],'item' => $vars['itemid']),
              )
            );

            if($setup33_emaillimits_copyofcontactform == 1){
              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'enquiryformadmin',
                  'data' => array('name' => $vars['name'],'email'=>$vars['email'],'phone'=>$phone_inf,'message'=>$vars['msg'],'item' => $vars['itemid'],'user'=>$user_id),
                )
              );
            }


            if ( !$message_reply){   
              echo json_encode( array( 'process'=>false, 'mes'=>$item_err1));
            }else{
              echo json_encode( array( 'process'=>true, 'mes'=>$item_err2));
            }
          }


        }else{
          echo json_encode( array( 'process'=>false, 'mes'=>$item_err3));
        }
        
      }
		break;


/**
*Enquiry Form Author
**/
    case 'enquiryformauthor':

      if (is_array($vars)) {
        $workdone = 0;
        if(isset($vars['userid'])){
          global $wpdb;
          $user_id = $vars['userid'];
        
          $user = get_user_by( 'id', $user_id ); 

          if($user == false){
            /* If user and agent linked pass the item's agent and user contact */
            $user_req_email = sanitize_email(get_post_meta( $user_id, 'webbupointfinder_agent_email', true ));
          }else{
            /* Normally contact with user */
            $user_req_email = $user->user_email;
          }


          $setup33_emaillimits_copyofcontactform = PFMSIssetControl('setup33_emaillimits_copyofcontactform','','1');
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');

          if ( $pfrecheck == 1 && $pfrecheckcon == 1 ) {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;

              }else{
                echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{

            $workdone = 1;

          }



          if ($workdone == 1) {
            $message_reply = pointfinder_mailsystem_mailsender(
              array(
                'toemail' => $user_req_email,
                'predefined' => 'enquiryformuser',
                'data' => array('name' => $vars['name'],'email'=>$vars['email'],'phone'=>$vars['phone'],'message'=>$vars['msg'],'item'=>''),
              )
            );

            if($setup33_emaillimits_copyofcontactform == 1){
              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'enquiryformadmin',
                  'data' => array('name' => $vars['name'],'email'=>$vars['email'],'phone'=>$vars['phone'],'message'=>$vars['msg'],'user'=>$user_id,'item'=>''),
                )
              );
            }
         
            if ( !$message_reply){   
              echo json_encode( array( 'process'=>false, 'mes'=>$item_err1));
            }else{
              echo json_encode( array( 'process'=>true, 'mes'=>$item_err2));
            }
           }

        }else{
          echo json_encode( array( 'process'=>false, 'mes'=>$item_err3));
        }
        
      }
    break;
		case 'imageform':
					$msg = pf_paginated_gallery($vars);	
          echo json_encode( array( 'process'=>true, 'mes'=>$msg));
					break;

		case 'eventform':
			$delete_id = isset($vars['delete-event-id']) ? $vars['delete-event-id'] : '';
			if ($delete_id != '') {
				wp_delete_post($delete_id);	
				echo json_encode( array( 'process'=>true, 'mes'=>$delete_id));
			}else {
				$item_id = isset($vars['itemid']) ? $vars['itemid'] : '';
				if ($item_id == '') {
					echo json_encode( array( 'process'=>false, 'mes'=>'no item_id,wrong parameter'));
				}else {
					$title = isset($vars['event_title']) ?  esc_html($vars['event_title']) : '';
					$content = isset($vars['event_content']) ? esc_html($vars['event_content']) : '';
					if (!empty($title) && !empty($content)) {
						$arg = array(
							 'post_type'    => 'pointfinderevents',
							 'post_title'    => $title,
							 'post_content'  => $content,
							 'post_status'   => 'publish',
							 'post_parent'  => $item_id,
						);
						if (is_user_logged_in()) {
							$arg['post_author'] = get_current_user_id();
						}
						$post_id = wp_insert_post($arg);
						add_post_meta($post_id, 'webbupointfinder_event_itemid', $item_id);
//						wp_update_post(array( 'ID' => $post_id, 'post_parent' => $item_id));
					}

					$images = isset($vars['pfuploadimagesrc']) ? $vars['pfuploadimagesrc'] : '';
					if ($images != '') {
						$uploadimages = pfstring2BasicArray($vars['pfuploadimagesrc']);
						foreach ($uploadimages as $uploadimage) {
							add_post_meta($item_id, 'webbupointfinder_item_images', $uploadimage);
							wp_update_post(array( 'ID' => $uploadimage, 'post_parent' => $item_id));
						}
					}
					echo json_encode( array( 'process'=>true, 'mes'=>'success'));
				}
			}
		break;

/**
*Review Form
**/
    case 'reviewform':
      if (is_array($vars)) {
        $workdone = 0;

        if (isset($vars['itemid'])) {

          global $wpdb;
          $user_id = $wpdb->get_var( $wpdb->prepare("SELECT post_author FROM $wpdb->posts where ID = %d",$vars['itemid']) );

          $setup11_reviewsystem_singlerev = PFREVSIssetControl('setup11_reviewsystem_singlerev','','0');
          if($setup11_reviewsystem_singlerev == 1){

            $reviewID = $wpdb->get_results($wpdb->prepare("SELECT key1.post_id FROM $wpdb->postmeta as key1 
              INNER JOIN $wpdb->postmeta as key2 ON key1.post_id = key2.post_id and key2.meta_value = %s 
              where key1.meta_key = %s and key1.meta_value = %d",$vars['email'],'webbupointfinder_review_itemid',$vars['itemid']),
            'ARRAY_A');

            if (!empty($reviewID)) {
              echo json_encode( array( 'process'=>false, 'mes'=> $item_err7));
              break;
              die();
            }
          }

          

          if (is_user_logged_in() && isset($vars['email'])) {
            $user = get_user_by( 'id', $user_id ); 
            if ($user->user_email == $vars['email']) {
              echo json_encode( array( 'process'=>false, 'mes'=> $item_err8));
              break;
              die();
            }
          }elseif(!is_user_logged_in() && isset($vars['email'])) {
            $user = get_user_by( 'id', $user_id ); 
            if ($user->user_email != $vars['email']) {
              echo json_encode( array( 'process'=>false, 'mes'=> $item_err8));
              break;
              die();
            }
          }else{
            $user = get_user_by( 'id', $user_id ); 
          }

          $setup33_emaillimits_copyofreviewform = PFMSIssetControl('setup33_emaillimits_copyofreviewform','','1');
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');
          $pfrecheckrev = PFRECIssetControl('setupreCaptcha_general_rev_status','','0');

          $setup11_reviewsystem_revstatus = PFREVSIssetControl('setup11_reviewsystem_revstatus','','0');
          $post_status = ($setup11_reviewsystem_revstatus == 0) ? 'pendingapproval' : 'publish' ;
          

          if ( $pfrecheck == 1 && $pfrecheckrev == 1) {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;

                  
              }else{
                echo json_encode( array( 'process'=>false, 'mes'=> $recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{

            $workdone = 1;

          }


          if ($workdone == 1) {
            $arg = array(
              'post_type'    => 'pointfinderreviews',
              'post_title'    => esc_html($vars['name']),
              'post_content'  => esc_html($vars['msg']),
              'post_status'   => $post_status,
            );

            if (is_user_logged_in()) {
              $arg['post_author'] = get_current_user_id();
            }
            
            $post_id = wp_insert_post($arg);



            if(isset($vars['email'])){
              add_post_meta($post_id, 'webbupointfinder_review_email', $vars['email']);
            }

            add_post_meta($post_id, 'webbupointfinder_review_itemid', $vars['itemid']);

            if(isset($vars['userid'])){
              add_post_meta($post_id, 'webbupointfinder_review_userid', $vars['userid']);
            }

            $ratingarray = array();

            for ($i=0; $i <= $vars['revcrno']; $i++) { 
              $ratingarray[$i] = $vars['rating'.$i];
            }

            add_post_meta($post_id, 'webbupointfinder_review_rating', json_encode($ratingarray));


            if ($setup11_reviewsystem_revstatus == 1) {
              $total_results_exit = pfcalculate_total_review_ot($vars['itemid']);
              
              if (!empty($total_results_exit)) {
                update_post_meta( $vars['itemid'], "webbupointfinder_item_reviewcount", $total_results_exit['totalresult']);
              } else {
                update_post_meta( $vars['itemid'], "webbupointfinder_item_reviewcount", 0);
              }
            }

						$message_reply = true;
            if($setup33_emaillimits_copyofreviewform == 1){
	            $message_reply = pointfinder_mailsystem_mailsender(
               array(
                  'toemail' => $user->user_email,
                  'predefined' => 'reviewformuser',
                  'data' => array(
                    'name' => $vars['name'],
                    'email'=>$vars['email'],
                    'message'=>$vars['msg'],
                    'item' => $vars['itemid']
                  ),
                )
              );

              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'reviewformadmin',
                  'data' => array(
                    'name' => $vars['name'],
                    'email'=>$vars['email'],
                    'message'=>$vars['msg'],
                    'item' => $vars['itemid'],
                    'revid' => $post_id,
                    'user'=>$user_id
                  ),
                )
              );
            }


            if ( !$message_reply){   
              echo json_encode( array( 'process'=>false, 'mes'=>$item_err4));
            }else{
              if($setup11_reviewsystem_revstatus == 1){
                echo json_encode( array( 'process'=>true, 'mes'=>$item_err5));
              }else{
                echo json_encode( array( 'process'=>true, 'mes'=>$item_err5.'<br/>'.$item_err6));
              }
              
            }
          }


        }else{
          echo json_encode( array( 'process'=>false, 'mes'=>$item_err3));
        }
        
      }
    break;


/**
*Report Form Item
**/
    case 'reportitem':

      if (is_array($vars)) {
        $workdone = 0;

          $pfrecheckreport = PFRECIssetControl('setupreCaptcha_general_report_status','','0');
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');

          if ( $pfrecheck == 1 && $pfrecheckreport == 1) {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;

              }else{
                echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{

            $workdone = 1;

          }


          if ($workdone == 1) {
            $message_reply = pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'reportitemmail',
                  'data' => array('name' => $vars['name'],'email'=>$vars['email'],'user'=>$vars['userid'],'item'=>$vars['itemid'],'message'=>$vars['msg']),
                )
              );


            if ( !$message_reply){   
              echo json_encode( array( 'process'=>false, 'mes'=>$item_err1));
            }else{
              echo json_encode( array( 'process'=>true, 'mes'=>$item_err9));
            }
          }

        
      }
    break;

/**
*Claim Form Item
**/
    case 'claimitem':

      if (is_array($vars)) {
        $workdone = 0;

          $pfrecheckreport = PFRECIssetControl('setupreCaptcha_general_claim_status','','0');
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');

          if ( $pfrecheck == 1 && $pfrecheckreport == 1) {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;

              }else{
                echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{

            $workdone = 1;

          }


          if ($workdone == 1) {
            $message_reply = pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'claimitemmail',
                  'data' => array(
                    'name' => $vars['name'],
                    'email'=>$vars['email'],
                    'user'=>$vars['userid'],
                    'item'=>$vars['itemid'],
                    'message'=>isset($vars['msg'])? $vars['msg']:'',
                    'phone'=> isset($vars['phonenum'])? $vars['phonenum']:''
                    ),
                )
              );


            if ( !$message_reply){   
              echo json_encode( array( 'process'=>false, 'mes'=>$item_err1));
            }else{
              echo json_encode( array( 'process'=>true, 'mes'=>$item_err12));
            }
          }

        
      }
    break;

/** 
*Review Flag
**/
    case 'flagreview':

      if (is_array($vars)) {
        $workdone = 0;

          $pfrecheckreport = PFRECIssetControl('setupreCaptcha_general_flagrev_status','','0');
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');

          

          

          if ( $pfrecheck == 1 && $pfrecheckreport == 1) {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;

              }else{
                echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{

            $workdone = 1;

          }


            if ($workdone == 1) {
              $flagstatus = (PFcheck_postmeta_exist('webbupointfinder_review_flag',$vars['reviewid']))? esc_attr(get_post_meta( $vars['reviewid'], 'webbupointfinder_review_flag', true )) : '' ;
              ($flagstatus == '') ? add_post_meta( $vars['reviewid'], 'webbupointfinder_review_flag', 1 ) : update_post_meta( $vars['reviewid'], 'webbupointfinder_review_flag', 1 );
              if($flagstatus == ''){
              $message_reply = pointfinder_mailsystem_mailsender(
                  array(
                    'toemail' => $setup33_emailsettings_mainemail,
                    'predefined' => 'reviewflagemail',
                    'data' => array('name' => $vars['name'],'email'=>$vars['email'],'user'=>$vars['userid'],'item'=>$vars['reviewid'],'message'=>$vars['msg']),
                  )
                );


              if ( !$message_reply){   
                echo json_encode( array( 'process'=>false, 'mes'=>$item_err1));
              }else{
                echo json_encode( array( 'process'=>true, 'mes'=>$item_err10));
              }
            }else{
              echo json_encode( array( 'process'=>true, 'mes'=>$item_err10));
            }
          }

        
      }
    break;

/**
*Contact Form
**/
    case 'contactform':

      if (is_array($vars)) {
        $workdone = 0;

          $pfrecheckreport = $vars['contact_re'];
          $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','','1');

          if ( $pfrecheck == 1 && $pfrecheckreport == 'yes') {
            if (isset($vars['g-recaptcha-response'])) {
              $pfReResult = PFCGreCaptcha($vars['g-recaptcha-response']);
              if ($pfReResult == 1) {

                  $workdone = 1;

              }else{
                echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err1));
              }
            }else{
              echo json_encode( array( 'process'=>false, 'mes'=>$recaptcha_err2));
            }
          }else{

            $workdone = 1;

          }


          if ($workdone == 1) {
            $message_reply = pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                  'predefined' => 'contactformemail',
                  'data' => array(
                    'name' => $vars['name'],
                    'email'=>$vars['email'],
                    'subject'=>(isset($vars['subject']))?$vars['subject']:'',
                    'phone'=>(isset($vars['phone']))?$vars['phone']:'',
                    'message'=>(isset($vars['msg']))?$vars['msg']:''
                  ),
                )
              );


            if ( !$message_reply){   
              echo json_encode( array( 'process'=>false, 'mes'=>$item_err1));
            }else{
              echo json_encode( array( 'process'=>true, 'mes'=>$item_err11));
            }
          }

        
      }
    break;
 
	}
die();
}

?>
