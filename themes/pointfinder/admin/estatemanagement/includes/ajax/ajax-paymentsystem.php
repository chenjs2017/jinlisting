<?php
/**********************************************************************************************************************************
*
* Ajax Payment System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

add_action( 'PF_AJAX_HANDLER_pfget_paymentsystem', 'pf_ajax_paymentsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_paymentsystem', 'pf_ajax_paymentsystem' );

function pf_ajax_paymentsystem(){
  
  check_ajax_referer( 'pfget_paymentsystem', 'security');
  
	header('Content-Type: application/json; charset=UTF-8;');

  if(isset($_POST['formtype']) && $_POST['formtype']!=''){$formtype = esc_attr($_POST['formtype']);}
  if(isset($_POST['itemid']) && $_POST['itemid']!=''){$item_post_id = esc_attr($_POST['itemid']);}else{$item_post_id = '';}
  if(isset($_POST['otype']) && $_POST['otype']!=''){$otype = esc_attr($_POST['otype']);}else{$otype = 0;}

  $icon_processout = 62;
  $msg_output = $pfreturn_url = $overlar_class = $output_html = '';
  $current_user = wp_get_current_user();
  $user_id = isset($current_user->ID)?$current_user->ID:0;
  $user_email = isset($current_user->user_email)?$current_user->user_email:'';

  if($user_id != 0){
    if ($item_post_id != '') {

      $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','',site_url());
      $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
      $pfmenu_perout = PFPermalinkCheck();
      $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');


      /*Check if item user s item*/
      global $wpdb;

      $result = $wpdb->get_results( $wpdb->prepare( 
        "SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
        $item_post_id,
        $user_id,
        $setup3_pointposttype_pt1
      ) );

      
      if (is_array($result) && count($result)>0) {  
        if ($result[0]->ID == $item_post_id) {
          
          /*Meta for order*/
          $result_id = $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", 'pointfinder_order_itemid',$item_post_id));

          /* Check is this a change */
          $pointfinder_sub_order_change = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_change', true ));


        	switch($formtype){

            /*Paypal Request*/
        		case 'paypalrequest':

              $setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
              $setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
              $setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');
              $pointfinder_order_pricesign = esc_attr(get_post_meta( $result_id, 'pointfinder_order_pricesign', true ));

              if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                $pointfinder_order_listingtime = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_listingtime', true ));
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                $pointfinder_order_listingtime = ($pointfinder_order_listingtime == '') ? 0 : $pointfinder_order_listingtime ;
                $pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpid', true)); 
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true)); 

                $total_package_price =  number_format($pointfinder_order_price, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);

                $paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

                $billing_description = $pointfinder_order_recurring = $total_package_price_recurring = $featured_package_price = $featuredrecurring  = $billing_description_featured = '';


                $response = pointfinder_paypal_request(
                  array(
                    'returnurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_rec',
                    'cancelurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_cancel',
                    'total_package_price' => $total_package_price,
                    'total_package_price_recurring' => $total_package_price_recurring,
                    'featured_package_price' => $featured_package_price,
                    'payment_custom_field' => $item_post_id,
                    'recurring' => $pointfinder_order_recurring,
                    'billing_description' => $billing_description,
                    'paymentName' => $paymentName,
                    'apipackage_name' => $pointfinder_order_listingpname,
                    'featuredrecurring' => $featuredrecurring,
                    'featured_billing_description' => $billing_description_featured,
                    'payment_custom_field1' => $otype,
                    'payment_custom_field3' => $paymentName.' '.$pointfinder_order_listingpname
                  )
                );


              }else{
                
                $pointfinder_order_listingtime = esc_attr(get_post_meta( $result_id, 'pointfinder_order_listingtime', true ));
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                $pointfinder_order_recurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurring', true ));
                $pointfinder_order_listingtime = ($pointfinder_order_listingtime == '') ? 0 : $pointfinder_order_listingtime ;
                $pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpid', true)); 
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 

                $total_package_price =  number_format($pointfinder_order_price, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);

                $paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

                $billing_description = $total_package_price_recurring = $featured_package_price = $featuredrecurring  = $billing_description_featured = '';

                if ($pointfinder_order_recurring == 1) {

                  /* Added with v1.6.4 */
                  $pointfinder_order_featured = esc_attr(get_post_meta($result_id, 'pointfinder_order_featured', true)); 
                  if ($pointfinder_order_featured == 1) {
                    $setup31_userpayments_pricefeatured = PFSAIssetControl('setup31_userpayments_pricefeatured','','5');
                    $stp31_daysfeatured = PFSAIssetControl('stp31_daysfeatured','','3');

                    $total_package_price_recurring = $pointfinder_order_price -  $setup31_userpayments_pricefeatured;

                    $total_package_price_recurring = number_format($total_package_price_recurring, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);
                    $setup31_userpayments_pricefeatured = number_format($setup31_userpayments_pricefeatured, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands);

                    $billing_description_featured = sprintf(
                    esc_html__('%s / %s / Recurring: %s%s per %s days / For: (%s)','pointfindert2d'),
                    $paymentName,
                    esc_html__('Featured Point','pointfindert2d'),
                    $setup31_userpayments_pricefeatured,
                    $pointfinder_order_pricesign,
                    $stp31_daysfeatured,
                    $item_post_id
                    );

                    $featuredrecurring = 1;
                    $featured_package_price = $setup31_userpayments_pricefeatured;
                  }else{
                    $total_package_price_recurring = $total_package_price;
                    $featuredrecurring = $billing_description_featured = $featured_package_price = '';
                  }

                  $billing_description = sprintf(
                    esc_html__('%s / %s / Recurring: %s%s per %s days / For: (%s)','pointfindert2d'),
                    $paymentName,
                    $pointfinder_order_listingpname,
                    $total_package_price_recurring,
                    $pointfinder_order_pricesign,
                    $pointfinder_order_listingtime,
                    $item_post_id
                    );
                }


                $response = pointfinder_paypal_request(
                  array(
                    'returnurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_rec',
                    'cancelurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&action=pf_cancel',
                    'total_package_price' => $total_package_price,
                    'total_package_price_recurring' => $total_package_price_recurring,
                    'featured_package_price' => $featured_package_price,
                    'payment_custom_field' => $item_post_id,
                    'recurring' => $pointfinder_order_recurring,
                    'billing_description' => $billing_description,
                    'paymentName' => $paymentName,
                    'apipackage_name' => $pointfinder_order_listingpname,
                    'featuredrecurring' => $featuredrecurring,
                    'featured_billing_description' => $billing_description_featured
                  )
                );
              }
              
              if(!$response){ 
                $msg_output .= esc_html__( 'Error: No Response', 'pointfindert2d' ).'<br>';
                $icon_processout = 485;
                /*$errorval .= $paypal->getErrors();*/
              }
             
              if(is_array($response) && ($response['ACK'] == 'Success')) { 
                $token = $response['TOKEN']; 
                
                if ($pointfinder_sub_order_change == 1) {
                  update_post_meta($result_id, 'pointfinder_sub_order_token', $token ); 
                }else{
                  update_post_meta($result_id, 'pointfinder_order_token', $token ); 
                }

                /*Create a payment record for this process */
                PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $item_post_id,
                    'order_post_id' =>  $result_id,
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
                
                $msg_output .= esc_html__('Payment process started. Please wait redirection.(Sub order)','pointfindert2d');

              }else{
                /*Create a payment record for this process */
           
                PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $item_post_id,
                    'order_post_id' =>  $result_id,
                    'response'  =>  $response,
                    'token' =>  '',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  $response['ACK'],
                    )
                  );

                $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                if (isset($response['L_SHORTMESSAGE0'])) {
                 $msg_output .= '<small>'.$response['L_SHORTMESSAGE0'].'</small><br/>';
                }
                if (isset($response['L_LONGMESSAGE0'])) {
                 $msg_output .= '<small>'.$response['L_LONGMESSAGE0'].'</small><br/>';
                }
                $icon_processout = 485;
                
              }
            break;

            /*Stripe Request*/
            case 'creditcardstripe':

                $setup20_stripesettings_decimals = PFSAIssetControl('setup20_stripesettings_decimals','','2');
                $setup20_stripesettings_publishkey = PFSAIssetControl('setup20_stripesettings_publishkey','','');
                $setup20_stripesettings_currency = PFSAIssetControl('setup20_stripesettings_currency','','USD');
                $setup20_stripesettings_sitename = PFSAIssetControl('setup20_stripesettings_sitename','','');
                
                if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                   $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                   $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true)); 
                }else{
                   $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                   $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 
                }
               
                if ($setup20_stripesettings_decimals == 0) {
                  $total_package_price =  $pointfinder_order_price;
                }else{
                  $total_package_price =  $pointfinder_order_price.'00';
                }
            break;

            /*Stripe Response*/
            case 'stripepayment':
              
              require_once( get_template_directory().'/admin/core/stripe/init.php');

              $setup20_stripesettings_decimals = PFSAIssetControl('setup20_stripesettings_decimals','','2');
              $setup20_stripesettings_secretkey = PFSAIssetControl('setup20_stripesettings_secretkey','','');
              $setup20_stripesettings_publishkey = PFSAIssetControl('setup20_stripesettings_publishkey','','');
              $setup20_stripesettings_currency = PFSAIssetControl('setup20_stripesettings_currency','','USD');

              if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true));
                $pointfinder_order_listingpname .= esc_html__('(Plan/Featured/Category Change)','pointfindert2d'); 
              }else{
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 
              }

              if ($setup20_stripesettings_decimals == 0) {
                $total_package_price =  $pointfinder_order_price;
                $total_package_price_ex =  $pointfinder_order_price;
              }else{
                $total_package_price =  $pointfinder_order_price.'00';
                $total_package_price_ex =  $pointfinder_order_price.'.00';
              }
              
              $stripe = array("secret_key" => $setup20_stripesettings_secretkey,"publishable_key" => $setup20_stripesettings_publishkey);

              \Stripe\Stripe::setApiKey($stripe['secret_key']);
              

              $token  = $_POST['token'];
              $token = PFCleanArrayAttr('PFCleanFilters',$token);
         
              $charge = '';

              if ($total_package_price != 0) {
                try {

                  $charge = \Stripe\Charge::create(array(
                    'amount'   => $total_package_price,
                    'currency' => ''.$setup20_stripesettings_currency.'',
                    'source'  => $token['id'],
                    'description' => "Charge for ".$pointfinder_order_listingpname.'(ItemID: '.$item_post_id.' / UserID: '.$user_id.')'
                  ));

                  if ($charge->status == 'succeeded') {

                    pointfinder_order_fallback_operations($result_id,$pointfinder_order_price);
                    
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $item_post_id,
                      'order_post_id' => $result_id,
                      'processname' =>  'DoExpressCheckoutPaymentStripe',
                      'status'  =>  $charge->status
                      )
                    );

                    PF_CreateInvoice(
                      array( 
                        'user_id' => $user_id,
                        'item_id' => $item_post_id,
                        'order_id' => $result_id,
                        'description' => $pointfinder_order_listingpname,
                        'processname' => esc_html__('Credit Card Payment','pointfindert2d'),
                        'amount' => $total_package_price_ex,
                        'datetime' => strtotime("now"),
                        'packageid' => 0,
                        'status' => 'publish'
                      )
                    );

                    if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                      
                      $pointfinder_sub_order_changedvals = get_post_meta( $result_id, 'pointfinder_sub_order_changedvals', true );
                                      
                      pointfinder_additional_orders(
                        array(
                          'changedvals' => $pointfinder_sub_order_changedvals,
                          'order_id' => $result_id,
                          'post_id' => $item_post_id
                        )
                      );

                    }else{
                      $setup31_userlimits_userpublish = PFSAIssetControl('setup31_userlimits_userpublish','','0');
                      $publishstatus = ($setup31_userlimits_userpublish == 1) ? 'publish' : 'pendingapproval' ;

                      wp_update_post(array('ID' => $item_post_id,'post_status' => $publishstatus) );
                      wp_update_post(array('ID' => $result_id,'post_status' => 'completed') );

                      $admin_email = get_option( 'admin_email' );
                      $setup33_emailsettings_mainemail = PFMSIssetControl('setup33_emailsettings_mainemail','',$admin_email);
                      $mail_item_title = get_the_title($item_post_id);
                      
                      pointfinder_mailsystem_mailsender(
                        array(
                          'toemail' => $user_email,
                              'predefined' => 'paymentcompleted',
                              'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($total_package_price_ex),'packagename' => $pointfinder_order_listingpname),
                          )
                        );

                      pointfinder_mailsystem_mailsender(
                        array(
                          'toemail' => $setup33_emailsettings_mainemail,
                              'predefined' => 'newpaymentreceived',
                              'data' => array('ID' => $item_post_id,'title'=>$mail_item_title,'paymenttotal' => pointfinder_price_output_set($total_package_price_ex),'packagename' => $pointfinder_order_listingpname),
                          )
                        );
                    }

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

            /*Pagseguro*/
            case 'pags':

              require_once( get_template_directory(). '/admin/core/PagSeguroLibrary/PagSeguroLibrary.php' );
           
              $pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpid', true)); 
              $paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

              if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true));
              }else{
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 
              }

              $paymentRequest = new PagSeguroPaymentRequest();
              $paymentRequest->setCurrency("BRL");
              $paymentRequest->setReference($result_id.'-'.$otype); 
              $paymentRequest->addItem($item_post_id, $paymentName.' '.get_the_title($pointfinder_order_listingpid) , 1, $pointfinder_order_price);
              $paymentRequest->addParameter('notificationURL', $setup4_membersettings_dashboard_link);

              try {

                  $credentials = PagSeguroConfig::getAccountCredentials();
                  $url = $paymentRequest->register($credentials);

                  
                  PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $item_post_id,
                    'order_post_id' =>  $result_id,
                    'token' =>  $result_id.'-'.$item_post_id.'- PagSeguro',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  'success',
                    )
                  );

                  $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                  $pfreturn_url = $url;

              } catch (PagSeguroServiceException $e) {

                  
                  PF_CreatePaymentRecord(
                    array(
                    'user_id' =>  $user_id,
                    'item_post_id'  =>  $item_post_id,
                    'order_post_id' =>  $result_id,
                    'token' =>  $result_id.'-'.$item_post_id.'- PagSeguro',
                    'processname' =>  'SetExpressCheckout',
                    'status'  =>  $e->getMessage(),
                    )
                  );

                  $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                  $msg_output .= '<small>'.$e->getMessage().'</small><br/>';
                  $icon_processout = 485;
                  $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
              }
            break;

            /*Payu Money*/
            case 'payu':

              $payu_key = PFPGIssetControl('payu_key','','');
              $payu_salt = PFPGIssetControl('payu_salt','','');

              if (!empty($payu_key) && !empty($payu_salt)) {

                if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                  $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                  $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true));
                }else{
                  $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                  $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 
                }

                $paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

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

                update_post_meta($result_id, 'pointfinder_order_txnid', $txnid );

                /*First name */
                $firstname = $current_user->user_firstname;
                if (empty($firstname)) {
                  $firstname = $current_user->user_login;
                }

                /*Email*/
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
                  
                    PF_CreatePaymentRecord(
                      array(
                      'user_id' =>  $user_id,
                      'item_post_id'  =>  $item_post_id,
                      'order_post_id' =>  $result_id,
                      'token' =>  $result_id.'-'.$item_post_id.'- PAYUMONEY',
                      'processname' =>  'SetExpressCheckout',
                      'status'  =>  'Failure: Phone '.$user_phone,
                      )
                    );

                    $msg_output .= esc_html__( 'Error: Not Success (Phone)', 'pointfindert2d' ).'<br>';
                    $msg_output .= '<small>'.esc_html__( 'Please update your phone from profile page.', 'pointfindert2d' ).'</small><br/>';
                    $icon_processout = 485;
                    $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';

                    break;
                }

                $productinfo = str_replace(":", "-", $paymentName).' '.$result_id;


                $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

                $createOrder = array();

                $createOrder['key'] = $payu_key;
                $createOrder['txnid'] = $txnid;
                $createOrder['amount'] = $pointfinder_order_price;
                $createOrder['firstname'] = $firstname;
                $createOrder['email'] = $user_email;
                $createOrder['phone'] = $user_phone;
                $createOrder['productinfo'] = $productinfo;
                $createOrder['surl'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=s';
                $createOrder['furl'] = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=f';
                $createOrder['service_provider'] = $service_provider;
                $createOrder['udf1'] = $result_id;
                $createOrder['udf2'] = $otype;
                $createOrder['udf3'] = $item_post_id;


                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';

                foreach($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($createOrder[$hash_var]) ? $createOrder[$hash_var] : '';
                    $hash_string .= '|';
                }

                $hash_string .= $payu_salt;
                $hash = strtolower(hash('sha512', $hash_string));
                
                $pfreturn_url = $PAYU_BASE_URL . '/_payment';

                
                PF_CreatePaymentRecord(
                  array(
                  'user_id' =>  $user_id,
                  'item_post_id'  =>  $item_post_id,
                  'order_post_id' =>  $result_id,
                  'token' =>  $result_id.'-'.$item_post_id.'- PAYUMONEY',
                  'processname' =>  'SetExpressCheckout',
                  'status'  =>  'success',
                  )
                );
  
                $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
              }else{
                $msg_output .= esc_html__("PAYU: Key or salt empty.",'pointfindert2d');
                $icon_processout = 485;
              }
            break;


            /*iDeal*/
            case 'ideal':
              require_once( get_template_directory(). '/admin/core/Mollie/API/Autoloader.php' );
        
              $pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpid', true)); 

              $ideal_id = PFPGIssetControl('ideal_id','','');
              $mollie = new Mollie_API_Client;
              $mollie->setApiKey($ideal_id);


              if(isset($_POST['token']) && $_POST['token']!=''){
                $ideal_issuer = esc_attr($_POST['token']);
              }else{
                $ideal_issuer = '';
              }

              if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true));
              }else{
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 
              }

              $paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

              try{
                $payment = $mollie->payments->create(array(
                  "amount"       => $pointfinder_order_price,
                  "method"       => Mollie_API_Object_Method::IDEAL,
                  "description"  => $paymentName." ".get_the_title($pointfinder_order_listingpid),
                  "redirectUrl"  => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&il='.$result_id,
                  "metadata"     => array(
                    "order_id" => $result_id,
                    "item_post_id" => $item_post_id,
                    "user_id" => $user_id,
                    "otype" => $otype
                  ),
                  "issuer"       => !empty($ideal_issuer) ? $ideal_issuer : NULL
                ));

                update_post_meta($result_id, 'pointfinder_order_ideal', $payment->id );

                PF_CreatePaymentRecord(
                  array(
                  'user_id' =>  $user_id,
                  'item_post_id'  =>  $item_post_id,
                  'order_post_id' =>  $result_id,
                  'token' =>  $result_id.'-'.$item_post_id.'- iDeal',
                  'processname' =>  'SetExpressCheckout',
                  'status'  =>  'success',
                  )
                );

                $msg_output .= esc_html__('Payment process started. Please wait redirection.','pointfindert2d');
                $pfreturn_url = $payment->getPaymentUrl();
              }catch (Mollie_API_Exception $e){
                PF_CreatePaymentRecord(
                  array(
                  'user_id' =>  $user_id,
                  'item_post_id'  =>  $item_post_id,
                  'order_post_id' =>  $result_id,
                  'token' =>  $result_id.'-'.$item_post_id.'- iDeal',
                  'processname' =>  'SetExpressCheckout',
                  'status'  =>  $e->getMessage(),
                  )
                );

                $msg_output .= esc_html__( 'Error: Not Success', 'pointfindert2d' ).'<br>';
                $msg_output .= '<small>'.htmlspecialchars($e->getMessage()).'</small><br/>';
                $icon_processout = 485;
                $pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&il='.$result_id;
              }    
            break;


            /*Robokassa*/
            case 'robo':
              $pointfinder_order_listingpid = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpid', true)); 

              $robo_mode = PFPGIssetControl('robo_mode','',0);
              $robo_login = PFPGIssetControl('robo_login','','');
              $robo_pass1 = PFPGIssetControl('robo_pass1','','');
              $robo_currency = PFPGIssetControl('robo_currency','','');
              $robo_lang = PFPGIssetControl('robo_lang','','ru');
              
              if ($pointfinder_sub_order_change == 1 && $otype == 1) {
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_sub_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_sub_order_listingpname', true));
              }else{
                $pointfinder_order_price = esc_attr(get_post_meta( $result_id, 'pointfinder_order_price', true ));
                $pointfinder_order_listingpname = esc_attr(get_post_meta($result_id, 'pointfinder_order_listingpname', true)); 
              }

              $paymentName = PFSAIssetControl('setup20_paypalsettings_paypal_api_packagename','',esc_html__('PointFinder Payment:','pointfindert2d'));

              $inv_desc = $paymentName." ".get_the_title($pointfinder_order_listingpid);

              if (!empty($robo_currency)) {
                $crc  = md5("$robo_login:$pointfinder_order_price:$result_id:$robo_currency:$robo_pass1:Shp_itemnum=$item_post_id:Shp_otype=$otype:Shp_user=$user_id");
              }else{
                $crc  = md5("$robo_login:$pointfinder_order_price:$result_id:$robo_pass1:Shp_itemnum=$item_post_id:Shp_otype=$otype:Shp_user=$user_id");
              }
              
              $robo_html = "<form action='https://auth.robokassa.ru/Merchant/Index.aspx' method='POST' name='roboForm'>".
                    "<input type=hidden name='MrchLogin' value='$robo_login'>".
                    "<input type=hidden name='OutSum' value='$pointfinder_order_price'>".
                    "<input type=hidden name='InvId' value='$result_id'>".
                    "<input type=hidden name='Desc' value='$inv_desc'>".
                    "<input type=hidden name='SignatureValue' value='$crc'>".
                    "<input type=hidden name='Shp_itemnum' value='$item_post_id'>".
                    "<input type=hidden name='Shp_user' value='$user_id'>".
                    "<input type=hidden name='Shp_otype' value='$otype'>".
                    "<input type=hidden name='Culture' value='$robo_lang'>";
                    
                    if (!empty($robo_currency)) {
                      $robo_html .= "<input type=hidden name='OutSumCurrency' value='$robo_currency'>";
                    }
                    if ($robo_mode == 0) {
                      $robo_html .= "<input type=hidden name='IsTest' value='1'>";
                    }
                    $robo_html .= "</form>";

              update_post_meta($result_id, 'pointfinder_order_robo', $result_id );
              update_post_meta($result_id, 'pointfinder_order_robo2', $result_id );

              PF_CreatePaymentRecord(
                array(
                'user_id' =>  $user_id,
                'item_post_id'  =>  $item_post_id,
                'order_post_id' =>  $result_id,
                'token' =>  $result_id.'-'.$item_post_id.'- Robokassa',
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
          $msg_output .= esc_html__('Wrong item ID (It is not your item!). Payment process is stopped.','pointfindert2d');
          $icon_processout = 485;
      }
      }
    }else{
      $msg_output .= esc_html__('Wrong item ID.','pointfindert2d');
      $icon_processout = 485;
    }
  }else{
    $msg_output .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
    $icon_processout = 485;
  }

  if ($icon_processout == 62) {
    $overlar_class = ' pfoverlayapprove';
  }

  $output_html = '';
  $output_html .= '<div class="golden-forms wrapper mini" style="height:200px">';
  $output_html .= '<div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay">';
  
  $output_html .= "<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div>";
  $output_html .= "<div class='pfrevoverlaytext".$overlar_class."'><i class='pfadmicon-glyph-".$icon_processout."'></i><span>".$msg_output."</span></div>";
  
  $output_html .= '</div>';
  $output_html .= '</div>';



  if ($icon_processout == 485) {  
    echo json_encode( array( 'process'=>false, 'mes'=>$output_html, 'returnurl' => $pfreturn_url));
  }else{

    if ($formtype != 'payu' && $formtype != 'creditcardstripe' && $formtype != 'stripepayment' && $formtype != 'robo') {

      echo json_encode( array( 'process'=>true, 'mes'=>$output_html, 'returnurl' => $pfreturn_url));

    }elseif ($formtype == 'payu'){

      $payumail = '';
      $payumail .= '<form action="'.$pfreturn_url.'" method="post" name="payuForm">
      <input type="hidden" name="hash" value="'.$hash.'"/>
      <input type="hidden" name="key" value="'.$payu_key.'" />
      <input type="hidden" name="txnid" value="'.$txnid.'" />
      <input type="hidden" name="amount" value="'.$pointfinder_order_price.'" />
      <input type="hidden" name="firstname" value="'.$firstname.'" />
      <input type="hidden" name="email" value="'.$user_email.'" />
      <input type="hidden" name="phone" value="'.$user_phone.'" />
      <input type="hidden" name="productinfo" value="'.$productinfo.'" />
      <input type="hidden" name="surl" value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=s'.'" />
      <input type="hidden" name="furl" value="'.$setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems&payu=f'.'" />
      <input type="hidden" name="service_provider" value="'.$service_provider.'" size="64" />
      <input type="hidden" name="udf1" value="'.$result_id.'" />
      <input type="hidden" name="udf2" value="'.$otype.'" />
      <input type="hidden" name="udf3" value="'.$item_post_id.'" />
      </form>';

      echo json_encode( array( 'process'=>true, 'mes'=>$output_html, 'returnurl' => $pfreturn_url,'payumail' => $payumail));

    }elseif ($formtype == 'robo'){

      $output_html .= $robo_html;

      echo json_encode( array( 'process'=>true, 'mes'=>$output_html, 'returnurl' => $pfreturn_url));


    }elseif ($formtype == 'creditcardstripe') {
     
      echo json_encode( array( 'process'=>true, 'otype'=>$otype, 'name'=>$setup20_stripesettings_sitename, 'description'=>$pointfinder_order_listingpname, 'amount' => $total_package_price,'key'=>$setup20_stripesettings_publishkey,'email'=>$user_email,'currency'=>$setup20_stripesettings_currency));

    }elseif ($formtype == 'stripepayment') {
      echo json_encode( array( 'process'=>true, 'mes'=>$output_html, 'returnurl' => $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems'));
    }
    
  }

die();


}

?>