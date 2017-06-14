<?php
/**********************************************************************************************************************************
*
* Ajax Payment System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_membershipsystem', 'pf_ajax_membershipsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_membershipsystem', 'pf_ajax_membershipsystem' );

function pf_ajax_membershipsystem(){
  check_ajax_referer( 'pfget_membershipsystem', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

  if(isset($_POST['formtype']) && $_POST['formtype']!=''){
    $formtype = esc_attr($_POST['formtype']);
  }

  $vars = array();
  if(isset($_POST['dt']) && $_POST['dt']!=''){
    
    if ($formtype != 'stripepay') {
      $vars = array();
      parse_str($_POST['dt'], $vars);

      if (is_array($vars)) {
          $vars = PFCleanArrayAttr('PFCleanFilters',$vars);
      } else {
          $vars = esc_attr($vars);
      }
    }
    
  }


  if (empty($vars['subaction'])) {
    $vars['subaction'] = "n";
  }

  $msg_output = $pfreturn_url = '';
  $current_user = wp_get_current_user();
  $user_id = isset($current_user->ID)?$current_user->ID:0;
  $icon_processout = 62;

  if (!isset($vars['pf_membership_payment_selection'])) {
    $vars['pf_membership_payment_selection'] = '';
  }

  if(!empty($user_id)){

    $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','',site_url());
    $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
    $pfmenu_perout = PFPermalinkCheck();


    switch ($formtype) {
      case 'purchasepackage':
       
        if (isset($vars['selectedpackageid'])) {
          
          switch ($vars['pf_membership_payment_selection']){
            case 'paypal':
            case 'paypal2':
                $processname = 'paypal';
                
                $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

                $setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
                $setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
                $setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');
                $setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);

                $total_package_price =  number_format($packageinfo['webbupointfinder_mp_price'], $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);
                
                if ($vars['pf_membership_payment_selection'] == 'paypal2') {
                  $vars['recurringlistingitemval'] = 1;
                }else{
                  $vars['recurringlistingitemval'] = 0;
                }

                $billing_description = '';

                if ($vars['recurringlistingitemval'] == 1) {
                  $billing_description = sprintf(
                    esc_html__('%s / %s / Recurring: %s per %s','pointfindert2d'),
                    $packageinfo['webbupointfinder_mp_title'],
                    $packageinfo['packageinfo_itemnumber_output_text'].' '.esc_html__('Item','pointfindert2d'),
                    $packageinfo['packageinfo_priceoutput_text'],
                    $packageinfo['webbupointfinder_mp_billing_period'].' '.$packageinfo['webbupointfinder_mp_billing_time_unit_text']                 
                    );
                }

                $response = pointfinder_paypal_request(
                  array(
                    'returnurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_recm',
                    'cancelurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_cancel',
                    'total_package_price' => $total_package_price,
                    'payment_custom_field' => $user_id,
                    'payment_custom_field1' => $vars['subaction'],
                    'payment_custom_field3' => $packageinfo['webbupointfinder_mp_title'],
                    'payment_custom_field2' => $vars['selectedpackageid'],
                    'recurring' => $vars['recurringlistingitemval'],
                    'billing_description' => $billing_description,
                    'paymentName' => $packageinfo['webbupointfinder_mp_title'],
                    'apipackage_name' => $packageinfo['webbupointfinder_mp_title']
                  )
                );

               
                
                if(!$response){ $msg_output .= esc_html__( 'Error: No Response', 'pointfindert2d' ).'<br>';}

                if(is_array($response) && ($response['ACK'] == 'Success')) { 
                  $token = $response['TOKEN'];

                  if ($vars['subaction'] == 'r') {
                    /*Get Order Record*/
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    update_post_meta($order_post_id,'pointfinder_order_token',$token );
                    if ($vars['recurringlistingitemval'] == 1) {
                      update_post_meta($order_post_id,'pointfinder_order_recurring',1 );
                    }
                  }elseif ($vars['subaction'] == 'u') {
                    /*Get Order Record*/
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    update_post_meta($order_post_id,'pointfinder_order_token',$token );
                    if ($vars['recurringlistingitemval'] == 1) {
                      update_post_meta($order_post_id,'pointfinder_order_recurring',1 );
                    }
                  }else{
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'recurring' => $vars['recurringlistingitemval'],
                        'token' =>$token
                      )
                    );
                  }
                  

                  /*Create a payment record for this process */
                  PF_CreatePaymentRecord(
                      array(
                      'user_id' => $user_id,
                      'item_post_id'  =>  $vars['selectedpackageid'],
                      'order_post_id' =>  $order_post_id,
                      'response'  =>  $response,
                      'token' =>  $response['TOKEN'],
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  $response['ACK'],
                      )
                  );
                
                  $paypal_sandbox = PFSAIssetControl('setup20_paypalsettings_paypal_sandbox','','0');
                  
                  if($paypal_sandbox == 0){
                    $pfreturn_url = 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token).'';
                  }else{
                    $pfreturn_url = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token).'';
                  }
                  
                  $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                }else{

                  if ($vars['subaction'] == 'r') {
                    /*Get Order Record*/
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    if ($vars['recurringlistingitemval'] == 1) {
                      update_post_meta($order_post_id,'pointfinder_order_recurring',1 );
                    }
                  }elseif ($vars['subaction'] == 'u') {
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'autoexpire_create' => 1
                      )
                    );
                  }else{
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'recurring' => $vars['recurringlistingitemval']
                      )
                    );
                  }

                  /*Create a payment record for this process */
                  PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $vars['selectedpackageid'],
                      'order_post_id' =>  $order_post_id,
                      'response'  =>  $response,
                      'token' =>  '',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  $response['ACK'],
                      )
                    );

                  $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                  if (isset($response['L_SHORTMESSAGE0'])) {$msg_output .= '<small>'.$response['L_SHORTMESSAGE0'].'</small><br/>';}
                  if (isset($response['L_LONGMESSAGE0'])) {$msg_output .= '<small>'.$response['L_LONGMESSAGE0'].'</small><br/>';}
                  $icon_processout = 485;
                }
              break;

            case 'stripe':
                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'stripe';

                $setup20_stripesettings_decimals = PFSAIssetControl('setup20_stripesettings_decimals','','2');
                $setup20_stripesettings_publishkey = PFSAIssetControl('setup20_stripesettings_publishkey','','');
                $setup20_stripesettings_currency = PFSAIssetControl('setup20_stripesettings_currency','','USD');
                $setup20_stripesettings_sitename = PFSAIssetControl('setup20_stripesettings_sitename','','');
                $user_email = $current_user->user_email;

                if ($setup20_stripesettings_decimals == 0) {
                  $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
                }else{
                  $total_package_price =  $packageinfo['webbupointfinder_mp_price'].'00';
                }  

                $stripe_array = array( 
                  'process'=>true,
                  'processname'=>$processname, 
                  'name'=>$setup20_stripesettings_sitename, 
                  'description'=>$packageinfo['webbupointfinder_mp_title'], 
                  'amount' => $total_package_price,
                  'key'=>$setup20_stripesettings_publishkey,
                  'email'=>$user_email,
                  'currency'=>$setup20_stripesettings_currency
                );

                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Package Renew Process Started with Stripe Payment','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Package Upgrade Process Started with Stripe Payment','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }
                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);

                PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' => $order_post_id,
                      'processname' =>  'SetExpressCheckoutStripe',
                      'status'  => 'Success',
                      'membership' => 1
                      )
                    );
              break;

            case 'bank':
                $processname = 'bank';

                $active_order_ex = get_user_meta($user_id, 'membership_user_activeorder_ex',true );
                if ($active_order_ex != false || !empty($active_order_ex)) {
                  $bank_current = get_post_meta( $active_order_ex, 'pointfinder_order_bankcheck', 1);
                } else {
                  $bank_current = false;
                }

                if ($bank_current == false && empty($bank_current)) {
                  
                  if ($vars['subaction'] == 'r') {
                    $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                    $vars['selectedpackageid'] = $membership_user_package_id;
                  }

                  $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);


                  if ($vars['subaction'] == 'r') {
                    
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('Package Renew Process Started with Bank Transfer','pointfindert2d'),
                        'membership' => 1
                        )
                    );

                  }elseif ($vars['subaction'] == 'u') {

                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('Package Upgrade Process Started with Bank Transfer','pointfindert2d'),
                        'membership' => 1
                        )
                    );

                  }else{

                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                      )
                    );

                  }

                  
                  if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                  }

                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                  update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);
                  update_post_meta( $order_post_id, 'pointfinder_order_bankcheck', 1);


                  PF_CreatePaymentRecord(
                        array(
                        'user_id' =>  $user_id,
                        'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                        'order_post_id' => $order_post_id,
                        'processname' =>  'BankTransfer',
                        'membership' => 1
                        )
                      );

                  /* Create an invoice for this */
                  $invoicenum = PF_CreateInvoice(
                    array( 
                      'user_id' => $user_id,
                      'item_id' => 0,
                      'order_id' => $order_post_id,
                      'description' => $packageinfo['webbupointfinder_mp_title'],
                      'processname' => esc_html__('Bank Transfer','pointfindert2d'),
                      'amount' => $packageinfo['packageinfo_priceoutput_text'],
                      'datetime' => strtotime("now"),
                      'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                      'status' => 'pendingpayment'
                    )
                  );
                  
                  update_user_meta( $user_id, 'membership_user_invnum_ex', $invoicenum);

                  $user_info = get_userdata( $user_id );
                  pointfinder_mailsystem_mailsender(
                    array(
                    'toemail' => $user_info->user_email,
                        'predefined' => 'bankpaymentwaitingmember',
                        'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $packageinfo['webbupointfinder_mp_title']),
                    )
                  );

                  $admin_email = get_option( 'admin_email' );
                  $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
                  pointfinder_mailsystem_mailsender(
                    array(
                      'toemail' => $setup33_emailsettings_mainemail,
                          'predefined' => 'newbankpreceivedmember',
                          'data' => array('ID' => $order_post_id,'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],'packagename' => $packageinfo['webbupointfinder_mp_title']),
                      )
                    );

                  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_pay2m';
                }else{
                  $msg_output .= esc_html__('You already have a bank transfer.','pointfindert2d');
                  $icon_processout = 485;
                  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
                }
              break;
              
            case 'free':
                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'free';

                /*This is free item so check again*/
                if ($packageinfo['packageinfo_priceoutput'] == 0) {

                    if ($vars['subaction'] == 'r') {
                      /*Get Order Record*/
                      $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                      $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process'=>'r'));
                      $app_date = strtotime("now");
                      update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
                    }elseif ($vars['subaction'] == 'u') {
                      /*Create Order Record*/
                      $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                      update_post_meta( $order_post_id, 'pointfinder_order_packageid', $vars['selectedpackageid']);
                      $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process'=>'u'));

                      /* Start: Calculate item/featured item count and remove from new package. */
                        $total_icounts = pointfinder_membership_count_ui($user_id);

                        /*Count User's Items*/
                        $user_post_count = 0;
                        $user_post_count = $total_icounts['item_count'];

                        /*Count User's Featured Items*/
                        $users_post_featured = 0;
                        $users_post_featured = $total_icounts['fitem_count'];

                        if ($packageinfo['webbupointfinder_mp_itemnumber'] != -1) {
                          $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'] - $user_post_count;
                        }else{
                          $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'];
                        }
                        
                        $new_fitem_limit = $packageinfo['webbupointfinder_mp_fitemnumber'] - $users_post_featured;


                        /*Create User Limits*/
                        update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                        update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                        update_user_meta( $user_id, 'membership_user_item_limit', $new_item_limit);
                        update_user_meta( $user_id, 'membership_user_featureditem_limit', $new_fitem_limit);
                        update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                        update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                        update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                        update_user_meta( $user_id, 'membership_user_recurring', 0);
                      /* End: Calculate new limits */
                    }else{
                      /*Create Order Record*/
                      $order_post_id = pointfinder_membership_create_order(
                        array(
                          'user_id' => $user_id,
                          'packageinfo' => $packageinfo,
                          'autoexpire_create' => 1
                        )
                      );
                      update_post_meta( $order_post_id, 'pointfinder_order_expiredate', strtotime("+".$packageinfo['webbupointfinder_mp_billing_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."") );
                      
                      /*Create User Limits*/
                      update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                      update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                      update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
                      update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
                      update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                      update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                      update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);

                      $user_info = get_userdata( $user_id );
                      pointfinder_mailsystem_mailsender(
                        array(
                        'toemail' => $user_info->user_email,
                            'predefined' => 'freecompletedmember',
                            'data' => array('packagename' => $packageinfo['webbupointfinder_mp_title']),
                        )
                      );

                      $admin_email = get_option( 'admin_email' );
                      $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
                      pointfinder_mailsystem_mailsender(
                        array(
                          'toemail' => $setup33_emailsettings_mainemail,
                              'predefined' => 'freepaymentreceivedmember',
                              'data' => array('ID' => $order_post_id,'packagename' => $packageinfo['webbupointfinder_mp_title']),
                          )
                        );
                    }

                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

                    /* Create an invoice for this */
                    PF_CreateInvoice(
                      array( 
                        'user_id' => $user_id,
                        'item_id' => 0,
                        'order_id' => $order_post_id,
                        'description' => $packageinfo['webbupointfinder_mp_title'],
                        'processname' => esc_html__('Free Package','pointfindert2d'),
                        'amount' => 0,
                        'datetime' => strtotime("now"),
                        'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                        'status' => 'publish'
                      )
                    );
                    
                    

                } else {
                  $msg_output .= esc_html__('Wrong package info. Process stopped.','pointfindert2d');
                  $icon_processout = 485;
                }
              break;

            case 'trial':
                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'trial';

                $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );

                /*This is free item so check again*/
                if ($packageinfo['webbupointfinder_mp_trial'] == 1 && $membership_user_package_id == false) {
                    
                    /*Create Order Record*/
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                        'autoexpire_create' => 1,
                        'trial' => 1
                      )
                    );

                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

                    /* Create an invoice for this */
                    PF_CreateInvoice(
                      array( 
                        'user_id' => $user_id,
                        'item_id' => 0,
                        'order_id' => $order_post_id,
                        'description' => $packageinfo['webbupointfinder_mp_title'],
                        'processname' => esc_html__('Trial Package','pointfindert2d'),
                        'amount' => 0,
                        'datetime' => strtotime("now"),
                        'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                        'status' => 'publish'
                      )
                    );

                    /*Create User Limits*/
                    update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                    update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                    update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
                    update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
                    update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                    update_user_meta( $user_id, 'membership_user_trialperiod', 1);
                    update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                    update_post_meta( $order_post_id, 'pointfinder_order_expiredate', strtotime("+".$packageinfo['webbupointfinder_mp_trial_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."") );

                } else {
                  $msg_output .= esc_html__("This package doesn't support trial period or user already have a package. Process stopped.",'pointfindert2d');
                  $icon_processout = 485;
                }
              break;

            case 'pags':

                require_once( get_template_directory(). '/admin/core/PagSeguroLibrary/PagSeguroLibrary.php' );

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }

                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'pags';

                $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
              

                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Pagseguro: Package Renew Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Pagseguro: Package Upgrade Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }



                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);

                $paymentRequest = new PagSeguroPaymentRequest();
                $paymentRequest->setCurrency("BRL");
                $paymentRequest->setReference($order_post_id.'-'.$vars['subaction']); 
                $paymentRequest->addItem($order_post_id, $packageinfo['webbupointfinder_mp_title'] , 1, $total_package_price);
                $paymentRequest->addParameter('notificationURL', $setup4_membersettings_dashboard_link);

                try {

                    $credentials = PagSeguroConfig::getAccountCredentials();
                    $url = $paymentRequest->register($credentials);

                    /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' => $order_post_id,
                      'processname' =>  'SetExpressCheckout',
                      'token' =>  $order_post_id.'- PagSeguro',
                      'status'  => 'Success',
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                    $pfreturn_url = $url;

                } catch (PagSeguroServiceException $e) {

                    /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' => $order_post_id,
                      'processname' =>  'SetExpressCheckout',
                      'token' =>  $order_post_id.'- PagSeguro',
                      'status'  =>  $e->getMessage(),
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                    $msg_output .= '<small>'.$e->getMessage().'</small><br/>';
                    $icon_processout = 485;
                    $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';

                }
              break;

            case 'payu':

                $payu_key = PFPGIssetControl('payu_key','','');
                $payu_salt = PFPGIssetControl('payu_salt','','');

                if (!empty($payu_key) && !empty($payu_salt)) {

                  $membership_user_package_id = '';

                  if ($vars['subaction'] == 'r') {
                    $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                    $vars['selectedpackageid'] = $membership_user_package_id;
                  }

                  $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                  $processname = 'payu';

                  $total_package_price =  $packageinfo['webbupointfinder_mp_price'];


                  if ($vars['subaction'] == 'r') {
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('PayU Money: Package Renew Process Started','pointfindert2d'),
                        'membership' => 1
                        )
                    );
                  }elseif ($vars['subaction'] == 'u') {
                    $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                    /* - Creating record for process system. */
                    PFCreateProcessRecord(
                      array( 
                        'user_id' => $user_id,
                        'item_post_id' => $order_post_id,
                        'processname' => esc_html__('PayU Money: Package Upgrade Process Started','pointfindert2d'),
                        'membership' => 1
                        )
                    );
                  }else{
                    $order_post_id = pointfinder_membership_create_order(
                      array(
                        'user_id' => $user_id,
                        'packageinfo' => $packageinfo,
                      )
                    );
                  }


                  if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                    global $wpdb;
                    $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                  }

                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                  update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


                  /* Start PayU Works */
                    $payu_mode = PFPGIssetControl('payu_mode','',0);
                    if (empty($payu_mode)) {
                      $PAYU_BASE_URL = "https://test.payu.in";
                    }else{
                      $PAYU_BASE_URL = "https://secure.payu.in";
                    }


                    $payu_provider = PFPGIssetControl('payu_provider','',1);
                    if (empty($payu_provider)) {
                      $service_provider = "";
                    }else{
                      $service_provider = "payu_paisa";
                    }
                    

                    /* Generate a transaction ID */
                    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

                    update_post_meta($order_post_id, 'pointfinder_order_txnid', $txnid );

                    /*First name */
                    $firstname = $current_user->user_firstname;
                    if (empty($firstname)) {
                      $firstname = $current_user->user_login;
                    }

                    /*Email*/
                    $user_email = $current_user->user_email;
                    if (empty($user_email)) {
                      $domain_name = $_SERVER['SERVER_NAME'];
                      $user_email = $current_user->user_login.'@'.$domain_name;
                    }

                    /*Phone*/
                    $user_phone = get_user_meta( $user_id, 'user_phone', true );
                    if(isset($_POST['user_phone']) && $_POST['user_phone']!=''){
                      $user_phone = esc_attr($_POST['user_phone']);
                    }
                    
                    if (empty($user_phone)) {
                      /*Create a payment record for this process */
                        PF_CreatePaymentRecord(
                          array(
                          'user_id' =>  $user_id,
                          'item_post_id'  =>  $membership_user_package_id,
                          'order_post_id' =>  $order_post_id,
                          'token' =>  $order_post_id.' - PAYUMONEY',
                          'processname' =>  'SetExpressCheckout',
                          'status'  =>  'Failure: Phone '.$user_phone,
                          'membership' => 1
                          )
                        );

                        $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                        $msg_output .= '<small>'.esc_html__( 'Phone Required', 'pointfindert2d' ).'</small><br/>';
                        $icon_processout = 485;
                        $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
                    }
                  /* End: PayU Works */


                  $productinfo = $packageinfo['webbupointfinder_mp_title'].' - '.$order_post_id;

                  // Hash Sequence
                  $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

                  $createOrder = array();

                  $createOrder['key'] = $payu_key;
                  $createOrder['txnid'] = $txnid;
                  $createOrder['amount'] = $total_package_price;
                  $createOrder['firstname'] = $firstname;
                  $createOrder['email'] = $user_email;
                  $createOrder['phone'] = $user_phone;
                  $createOrder['productinfo'] = $productinfo;
                  $createOrder['surl'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=s';
                  $createOrder['furl'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=f';
                  $createOrder['service_provider'] = $service_provider;
                  $createOrder['udf1'] = $order_post_id;
                  $createOrder['udf2'] = $vars['subaction'];
                  $createOrder['udf3'] = $membership_user_package_id;


                  $hashVarsSeq = explode('|', $hashSequence);
                  $hash_string = '';

                  foreach($hashVarsSeq as $hash_var) {
                      $hash_string .= isset($createOrder[$hash_var]) ? $createOrder[$hash_var] : '';
                      $hash_string .= '|';
                  }

                  $hash_string .= $payu_salt;
                  $hash = strtolower(hash('sha512', $hash_string));
                  
                  $pfreturn_url = $PAYU_BASE_URL . '/_payment';

                  /*Create a payment record for this process */
                  PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                    'order_post_id' =>  $order_post_id,
                    'token' =>  $order_post_id.' - PAYUMONEY',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  'Success',
                    'membership' => 1
                    )
                  );
    
                  $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');

                  $payumail = '';
                  $payumail .= '<form action="'.$pfreturn_url.'" method="post" name="payuForm">
                  <input type="hidden" name="hash" value="'.$hash.'"/>
                  <input type="hidden" name="key" value="'.$payu_key.'" />
                  <input type="hidden" name="txnid" value="'.$txnid.'" />
                  <input type="hidden" name="amount" value="'.$total_package_price.'" />
                  <input type="hidden" name="firstname" value="'.$firstname.'" />
                  <input type="hidden" name="email" value="'.$user_email.'" />
                  <input type="hidden" name="phone" value="'.$user_phone.'" />
                  <input type="hidden" name="productinfo" value="'.$productinfo.'" />
                  <input type="hidden" name="surl" value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=s'.'" />
                  <input type="hidden" name="furl" value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=f'.'" />
                  <input type="hidden" name="service_provider" value="'.$service_provider.'" size="64" />
                  <input type="hidden" name="udf1" value="'.$order_post_id.'" />
                  <input type="hidden" name="udf2" value="'.$vars['subaction'].'" />
                  <input type="hidden" name="udf3" value="'.$membership_user_package_id.'" />
                  </form>';

                }
              break;

            case 'ideal':
                require_once( get_template_directory(). '/admin/core/Mollie/API/Autoloader.php' );

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }

                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                $processname = 'pags';

                $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
              

                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('iDeal: Package Renew Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('iDeal: Package Upgrade Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }



                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


                $ideal_id = PFPGIssetControl('ideal_id','','');
                $mollie = new Mollie_API_Client;
                $mollie->setApiKey($ideal_id);

                $ideal_issuer = '';

                if (isset($vars['issuer'])) {
                  $ideal_issuer = $vars['issuer'];
                }


                try{
                  $payment = $mollie->payments->create(array(
                    "amount"       => $total_package_price,
                    "method"       => Mollie_API_Object_Method::IDEAL,
                    "description"  => $packageinfo['webbupointfinder_mp_title'],
                    "redirectUrl"  => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&il='.$order_post_id,
                    "metadata"     => array(
                      "order_id" => $order_post_id,
                      "item_post_id" => $packageinfo['webbupointfinder_mp_packageid'],
                      "user_id" => $user_id,
                      "otype" => $vars['subaction']
                    ),
                    "issuer"       => !empty($ideal_issuer) ? $ideal_issuer : NULL
                  ));

                  update_post_meta($order_post_id, 'pointfinder_order_ideal', $payment->id );

                  /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' =>  $order_post_id,
                      'token' =>  $order_post_id.'-'.$packageinfo['webbupointfinder_mp_packageid'].'- iDeal',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  'success',
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                    $pfreturn_url = $payment->getPaymentUrl();

                }catch (Mollie_API_Exception $e){
                  /*Create a payment record for this process */
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $packageinfo['webbupointfinder_mp_packageid'],
                      'order_post_id' =>  $order_post_id,
                      'token' =>  $order_post_id.'-'.$packageinfo['webbupointfinder_mp_packageid'].'- iDeal',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  $e->getMessage(),
                      'membership' => 1
                      )
                    );

                    $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                    $msg_output .= '<small>'.htmlspecialchars($e->getMessage()).'</small><br/>';
                    $icon_processout = 485;
                    $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&il='.$order_post_id;
                }
              break;

            case 'robo':

                $membership_user_package_id = '';
                $processname = 'robo';

                if ($vars['subaction'] == 'r') {
                  $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
                  $vars['selectedpackageid'] = $membership_user_package_id;
                }

                $packageinfo = pointfinder_membership_package_details_get($vars['selectedpackageid']);
                

                $total_package_price =  $packageinfo['webbupointfinder_mp_price'];


                if ($vars['subaction'] == 'r') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Robokassa: Package Renew Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }elseif ($vars['subaction'] == 'u') {
                  $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder', true );
                  /* - Creating record for process system. */
                  PFCreateProcessRecord(
                    array( 
                      'user_id' => $user_id,
                      'item_post_id' => $order_post_id,
                      'processname' => esc_html__('Robokassa: Package Upgrade Process Started','pointfindert2d'),
                      'membership' => 1
                      )
                  );
                }else{
                  $order_post_id = pointfinder_membership_create_order(
                    array(
                      'user_id' => $user_id,
                      'packageinfo' => $packageinfo,
                    )
                  );
                }


                if ($vars['subaction'] != 'r' && $vars['subaction'] != 'u') {
                  global $wpdb;
                  $wpdb->update($wpdb->posts,array('post_status'=>'pendingpayment'),array('ID'=>$order_post_id));
                }

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id_ex', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_activeorder_ex', $order_post_id);
                update_user_meta( $user_id, 'membership_user_subaction_ex', $vars['subaction']);


                /* Start Robo Works */
                $robo_mode = PFPGIssetControl('robo_mode','',0);
                $robo_login = PFPGIssetControl('robo_login','','');
                $robo_pass1 = PFPGIssetControl('robo_pass1','','');
                $robo_currency = PFPGIssetControl('robo_currency','','');
                $robo_lang = PFPGIssetControl('robo_lang','','ru');

                if (!empty($robo_currency)) {
                  $crc  = md5("$robo_login:$total_package_price:$order_post_id:$robo_currency:$robo_pass1:Shp_itemnum=$membership_user_package_id:Shp_otype=".$vars['subaction'].":Shp_user=$user_id");
                }else{
                  $crc  = md5("$robo_login:$total_package_price:$order_post_id:$robo_pass1:Shp_itemnum=$membership_user_package_id:Shp_otype=".$vars['subaction'].":Shp_user=$user_id");
                }


                $productinfo = $packageinfo['webbupointfinder_mp_title'].' - '.$order_post_id;
    
                $robo_html = "<form action='https://auth.robokassa.ru/Merchant/Index.aspx' method='POST' name='roboForm'>".
                "<input type=hidden name='MrchLogin' value='$robo_login'>".
                "<input type=hidden name='OutSum' value='$total_package_price'>".
                "<input type=hidden name='InvId' value='$order_post_id'>".
                "<input type=hidden name='Desc' value='$productinfo'>".
                "<input type=hidden name='SignatureValue' value='$crc'>".
                "<input type=hidden name='Shp_itemnum' value='$membership_user_package_id'>".
                "<input type=hidden name='Shp_user' value='$user_id'>".
                "<input type=hidden name='Shp_otype' value='".$vars['subaction']."'>".
                "<input type=hidden name='Culture' value='$robo_lang'>";
                
                if (!empty($robo_currency)) {
                  $robo_html .= "<input type=hidden name='OutSumCurrency' value='$robo_currency'>";
                }
                if ($robo_mode == 0) {
                  $robo_html .= "<input type=hidden name='IsTest' value='1'>";
                }
                $robo_html .= "</form>";

                update_post_meta($order_post_id, 'pointfinder_order_robo', $order_post_id );
                update_post_meta($order_post_id, 'pointfinder_order_robo2', $order_post_id );

                PF_CreatePaymentRecord(
                  array(
                  'user_id' =>  $user_id,
                  'item_post_id'  =>  $membership_user_package_id,
                  'order_post_id' =>  $order_post_id,
                  'token' =>  $order_post_id.'-'.$membership_user_package_id.'- Robokassa',
                  'processname' =>  'SetExpressCheckout',
                  'status'  =>  'success',
                  )
                );

                $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                $pfreturn_url = '';
                $icon_processout = 62;
                
              break;
          }

        }else{
          $msg_output .= esc_html__('Please select a package.','pointfindert2d');
          $icon_processout = 485;
        }

      break;

      case 'stripepay':
        $processname = 'stripepay';
        $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id_ex', true );
        $packageinfo = pointfinder_membership_package_details_get($membership_user_package_id);

        $order_post_id = get_user_meta( $user_id, 'membership_user_activeorder_ex', true );
        $sub_action = get_user_meta( $user_id, 'membership_user_subaction_ex', true );

        $setup20_stripesettings_decimals = PFSAIssetControl('setup20_stripesettings_decimals','','2');
        $user_email = $current_user->user_email;

        if ($setup20_stripesettings_decimals == 0) {
          $total_package_price =  $packageinfo['webbupointfinder_mp_price'];
          $total_package_price_ex =  $packageinfo['webbupointfinder_mp_price'];
        }else{
          $total_package_price =  $packageinfo['webbupointfinder_mp_price'].'00';
          $total_package_price_ex =  $packageinfo['webbupointfinder_mp_price'].'.00';
        }

        $apipackage_name = $packageinfo['webbupointfinder_mp_title'];

        $setup20_stripesettings_secretkey = PFSAIssetControl('setup20_stripesettings_secretkey','','');
        $setup20_stripesettings_publishkey = PFSAIssetControl('setup20_stripesettings_publishkey','','');
        $setup20_stripesettings_currency = PFSAIssetControl('setup20_stripesettings_currency','','USD');

        require_once( get_template_directory().'/admin/core/stripe/init.php');

        $stripe = array(
          "secret_key"      => $setup20_stripesettings_secretkey,
          "publishable_key" => $setup20_stripesettings_publishkey
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        

        $token  = $_POST['dt'];
        $token = PFCleanArrayAttr('PFCleanFilters',$token);
   
        $charge = '';
        if ($total_package_price != 0) {
          try {

            $charge = \Stripe\Charge::create(array(
              'amount'   => $total_package_price,
              'currency' => ''.$setup20_stripesettings_currency.'',
              'source'  => $token['id'],
              'description' => "Charge for ".$apipackage_name.'(PackageID: '.$membership_user_package_id.' / UserID: '.$user_id.')'
            ));

            if ($charge->status == 'succeeded') {
              PF_CreatePaymentRecord(
                array(
                'user_id' =>  $user_id,
                'item_post_id'  =>  $membership_user_package_id,
                'order_post_id' => $order_post_id,
                'processname' =>  'DoExpressCheckoutPaymentStripe',
                'status'  =>  $charge->status,
                'membership' => 1
                )
              );

              delete_user_meta($user_id, 'membership_user_package_id_ex');
              delete_user_meta($user_id, 'membership_user_activeorder_ex');
              delete_user_meta($user_id, 'membership_user_subaction_ex');

              if ($sub_action == 'r') {
                $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process' => 'r'));
                $app_date = strtotime("now");
                update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
               
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Package Renew Process Completed with Stripe Payment','pointfindert2d'),
                    'membership' => 1
                    )
                );

                /* Create an invoice for this */
                PF_CreateInvoice(
                  array( 
                    'user_id' => $user_id,
                    'item_id' => 0,
                    'order_id' => $order_post_id,
                    'description' => $packageinfo['webbupointfinder_mp_title'].'-'.esc_html__('Renew','pointfindert2d'),
                    'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                    'amount' => $packageinfo['packageinfo_priceoutput_text'],
                    'datetime' => strtotime("now"),
                    'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                    'status' => 'publish'
                  )
                );
              }elseif ($sub_action == 'u') {
                $exp_date = pointfinder_reenable_expired_items(array('user_id'=>$user_id,'packageinfo'=>$packageinfo,'order_id'=>$order_post_id,'process' => 'u'));
                update_post_meta( $order_post_id, 'pointfinder_order_expiredate', $exp_date);
                update_post_meta( $order_post_id, 'pointfinder_order_packageid', $membership_user_package_id);

                /* Start: Calculate item/featured item count and remove from new package. */
                  $total_icounts = pointfinder_membership_count_ui($user_id);

                  /*Count User's Items*/
                  $user_post_count = 0;
                  $user_post_count = $total_icounts['item_count'];

                  /*Count User's Featured Items*/
                  $users_post_featured = 0;
                  $users_post_featured = $total_icounts['fitem_count'];

                  if ($packageinfo['webbupointfinder_mp_itemnumber'] != -1) {
                    $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'] - $user_post_count;
                  }else{
                    $new_item_limit = $packageinfo['webbupointfinder_mp_itemnumber'];
                  }
                  
                  $new_fitem_limit = $packageinfo['webbupointfinder_mp_fitemnumber'] - $users_post_featured;


                  /*Create User Limits*/
                  update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                  update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                  update_user_meta( $user_id, 'membership_user_item_limit', $new_item_limit);
                  update_user_meta( $user_id, 'membership_user_featureditem_limit', $new_fitem_limit);
                  update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                  update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                  update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                  update_user_meta( $user_id, 'membership_user_recurring', 0);
                /* End: Calculate new limits */

                /* Create an invoice for this */
                PF_CreateInvoice(
                  array( 
                    'user_id' => $user_id,
                    'item_id' => 0,
                    'order_id' => $order_post_id,
                    'description' => $packageinfo['webbupointfinder_mp_title'].'-'.esc_html__('Upgrade','pointfindert2d'),
                    'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                    'amount' => $packageinfo['packageinfo_priceoutput_text'],
                    'datetime' => strtotime("now"),
                    'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                    'status' => 'publish'
                  )
                );

                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Package Upgrade Process Completed with Stripe Payment','pointfindert2d'),
                    'membership' => 1
                    )
                );
              }else{
                update_post_meta( $order_post_id, 'pointfinder_order_expiredate', strtotime("+".$packageinfo['webbupointfinder_mp_billing_period']." ".pointfinder_billing_timeunit_text_ex($packageinfo['webbupointfinder_mp_billing_time_unit'])."") );
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $order_post_id,
                    'processname' => esc_html__('Package Purchase Process Completed with Stripe Payment','pointfindert2d'),
                    'membership' => 1
                    )
                );

                /*Create User Limits*/
                update_user_meta( $user_id, 'membership_user_package_id', $packageinfo['webbupointfinder_mp_packageid']);
                update_user_meta( $user_id, 'membership_user_package', $packageinfo['webbupointfinder_mp_title']);
                update_user_meta( $user_id, 'membership_user_item_limit', $packageinfo['webbupointfinder_mp_itemnumber']);
                update_user_meta( $user_id, 'membership_user_featureditem_limit', $packageinfo['webbupointfinder_mp_fitemnumber']);
                update_user_meta( $user_id, 'membership_user_image_limit', $packageinfo['webbupointfinder_mp_images']);
                update_user_meta( $user_id, 'membership_user_trialperiod', 0);
                update_user_meta( $user_id, 'membership_user_activeorder', $order_post_id);
                update_user_meta( $user_id, 'membership_user_recurring', 0);

                /* Create an invoice for this */
                PF_CreateInvoice(
                  array( 
                    'user_id' => $user_id,
                    'item_id' => 0,
                    'order_id' => $order_post_id,
                    'description' => $packageinfo['webbupointfinder_mp_title'],
                    'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                    'amount' => $packageinfo['packageinfo_priceoutput_text'],
                    'datetime' => strtotime("now"),
                    'packageid' => $packageinfo['webbupointfinder_mp_packageid'],
                    'status' => 'publish'
                  )
                );
              }

              global $wpdb;
              $wpdb->update($wpdb->posts,array('post_status'=>'completed'),array('ID'=>$order_post_id));

              

              $admin_email = get_option( 'admin_email' );
              $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
              
              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $user_email,
                      'predefined' => 'paymentcompletedmember',
                      'data' => array(
                        'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],
                        'packagename' => $apipackage_name),
                  )
                );

              pointfinder_mailsystem_mailsender(
                array(
                  'toemail' => $setup33_emailsettings_mainemail,
                      'predefined' => 'newpaymentreceivedmember',
                      'data' => array(
                        'ID'=> $order_post_id,
                        'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'],
                        'packagename' => $apipackage_name),
                  )
                );


              $msg_output .= esc_html__('Payment is successful.','pointfindert2d');
            }

          } catch(\Stripe\Error\Card $e) {
            if(isset($e)){
              $error_mes = json_decode($e->httpBody,true);
              $icon_processout = 485;
              $msg_output = (isset($error_mes['error']['message']))? $error_mes['error']['message']:'';
              if (empty($msg_output)) {
                $msg_output .= esc_html__('Payment not completed.','pointfindert2d');
              }
            }
          }
        }else{
          $msg_output .= esc_html__('Price can not be 0!). Payment process is stopped.','pointfindert2d');
          $icon_processout = 485;
        }
        
        if ($icon_processout != 485) {
          $overlar_class = ' pfoverlayapprove';
        }else{
          $overlar_class = '';
        }

      break;


      case 'cancelrecurring':
        $processname = 'cancelrecurring';
        
        $membership_user_activeorder = get_user_meta( $user_id, 'membership_user_activeorder', true );   
        $membership_user_recurring = get_user_meta( $user_id, 'membership_user_recurring', true );

        $order_id = $membership_user_activeorder;

        $recurring_status = esc_attr(get_post_meta( $order_id, 'pointfinder_order_recurring',true));

        if (!empty($order_id) && $recurring_status == 1 && $membership_user_recurring == 1) {
          
            $pointfinder_order_expiredate = get_post_meta( $order_id, 'pointfinder_order_expiredate', true );
            $pointfinder_order_recurringid = get_post_meta( $order_id, 'pointfinder_order_recurringid', true );
            $pointfinder_order_packageid = get_post_meta( $order_id, 'pointfinder_order_packageid', true );
            $packageinfo = pointfinder_membership_package_details_get($pointfinder_order_packageid);
            
            update_post_meta( $order_id, 'pointfinder_order_recurring', 0 );
            update_user_meta( $user_id, 'membership_user_recurring', 0);
            
            PF_Cancel_recurring_payment_member(
             array( 
                    'user_id' => $user_id,
                    'profile_id' => $pointfinder_order_recurringid,
                    'item_post_id' => $order_id,
                    'order_post_id' => $order_id,
                )
             );

            PFCreateProcessRecord(
              array( 
                'user_id' => $user_id,
                'item_post_id' => $order_id,
                'processname' => esc_html__('Recurring Payment Profile Cancelled by User (User Profile Cancel)','pointfindert2d'),
                'membership' => 1
                )
            );

            $setup33_emaillimits_listingexpired = PFMSIssetControl('setup33_emaillimits_listingexpired','','1');

            if ($setup33_emaillimits_listingexpired == 1) {
              $user_info = get_userdata( $user_id);
              pointfinder_mailsystem_mailsender(
                array(
                'toemail' => $user_info->user_email,
                    'predefined' => 'expiredrecpaymentmember',
                    'data' => array(
                      'packagename' => $packageinfo['webbupointfinder_mp_title'], 
                      'paymenttotal' => $packageinfo['packageinfo_priceoutput_text'], 
                      'expiredate' => PFU_DateformatS($pointfinder_order_expiredate),
                      'orderid' => $order_id
                      ),
                )
              );
            }
          }else{
            $icon_processout = 485;
            $msg_output = esc_html__("Recurring Profile can't found.",'pointfindert2d');
          }
      break;
    }
  }else{
    $msg_output .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
    $icon_processout = 485;
  }

  if ($icon_processout == 62) {
    $overlar_class = ' pfoverlayapprove';
  }else{
    $overlar_class = '';
  }

  $output_html = '';
  $output_html .= '<div class="golden-forms wrapper mini" style="height:200px">';
  $output_html .= '<div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay">';
  
  $output_html .= "<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div>";
  $output_html .= "<div class='pfrevoverlaytext".$overlar_class."'><i class='pfadmicon-glyph-".$icon_processout."'></i><span>".$msg_output."</span></div>";
  
  $output_html .= '</div>';
  $output_html .= '</div>';

  if ($icon_processout == 485) {  
    echo json_encode( array( 'process'=>false, 'processname'=>$processname, 'mes'=>$output_html, 'returnurl' => $pfreturn_url));
  }else{
    
    if ($vars['pf_membership_payment_selection'] == 'stripe' && $formtype == 'purchasepackage') {
      
      echo json_encode($stripe_array);

    }elseif ($vars['pf_membership_payment_selection'] == 'payu' && $formtype == 'purchasepackage') {

      echo json_encode( array( 'process'=>true, 'mes'=>'','processname'=>$processname, 'returnurl' => $pfreturn_url,'payumail' => $payumail));

    }elseif ($vars['pf_membership_payment_selection'] == 'robo' && $formtype == 'purchasepackage') {

      echo json_encode( array( 'process'=>true, 'mes'=>$output_html.$robo_html,'processname'=>$processname, 'returnurl' => $pfreturn_url));
  
    } else {

      echo json_encode( 
        array( 
          'process'=>true, 
          'processname'=>$processname, 
          'mes'=>'', 
          'returnurl' => $pfreturn_url)
        );

    }
     
  }
  
die();
}

?>