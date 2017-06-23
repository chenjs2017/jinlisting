<?php
/**********************************************************************************************************************************
*
* Invoice System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/

/**
*Start : Invoice Print
**/

		/**
		*Start : Invoice HTML Template
		**/
			function pointfinder_invoicesystem_template_html($params = array()){
				
				$defaults = array( 
			        'userid' => '',
			        'invoiceid' => ''
			    );
			   
			    $params = array_merge($defaults, $params);

			    $user = get_user_by( 'id', $params['userid']);
			    $user_meta = get_user_meta($params['userid']);
			    $invoice_meta = get_post_meta($params['invoiceid']);
			    
			    $inv_prefix = PFASSIssetControl('setup_invoices_prefix','','PFI');
			    

			    /* Prepare Invoice Data */
			    $inv_date = date('d M Y',get_post_time('U',false,$invoice_meta['pointfinder_invoice_orderid'][0],true));
			    $inv_no = $inv_prefix.$params['invoiceid'];
			    $order_no = $invoice_meta['pointfinder_invoice_orderid'][0];
			    $order_no_out = get_the_title($order_no);
			    $inv_paid_via = $invoice_meta['pointfinder_invoice_invoicetype'][0];

			    /* User Info */
			    $inv_user_title = (isset($user_meta['first_name'][0])?$user_meta['first_name'][0]:'');
			    if (isset($user_meta['last_name'][0])) {
			    	$inv_user_title .= ' '.$user_meta['last_name'][0];
			    }
			    $inv_user_vat = (isset($user_meta['user_vatnumber'][0]))?$user_meta['user_vatnumber'][0]:'';
			    $inv_user_country = (isset($user_meta['user_country'][0]))?$user_meta['user_country'][0]:'';
			    $inv_user_address = (isset($user_meta['user_address'][0]))?$user_meta['user_address'][0]:'';

			    /* Admin Info */
			    $inv_adm_vat = PFASSIssetControl('setup_invoices_vatnum','','-');
			    $inv_adm_title = PFASSIssetControl('setup_invoices_usertit','','-');
			    $inv_adm_country = PFASSIssetControl('setup_invoices_usercountry','','-');
			    $inv_adm_address = PFASSIssetControl('setup_invoices_address','','-');
			    
			    /* Order Info */
			    $inv_order_desc = $inv_order_price = $inv_pack_id = '';
			    if (isset($invoice_meta['pointfinder_invoice_packageid'][0])) {
			    	$package_meta = pointfinder_membership_package_details_get($invoice_meta['pointfinder_invoice_packageid'][0]);
			    	$inv_order_desc = $package_meta['webbupointfinder_mp_title'];
					if (!empty($package_meta['webbupointfinder_mp_description'])) {
						$inv_order_desc .= '('.$package_meta['webbupointfinder_mp_description'].')';
					}
				    

					$setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
					$setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
					$setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');
					//$pointfinder_order_price = esc_attr(get_post_meta( $order_no, 'pointfinder_order_price', true ));

					$pointfinder_invoice_amount = get_post_meta( $params['invoiceid'], 'pointfinder_invoice_amount', true );
					
					$setup20_paypalsettings_paypal_price_pref = PFSAIssetControl('setup20_paypalsettings_paypal_price_pref','',1);
					$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');

					
					if (strpos($pointfinder_invoice_amount, $setup20_paypalsettings_paypal_price_short) >= 0) {
						$total_package_price = $inv_pack_price = $pointfinder_invoice_amount;
					}else{
						$total_package_price =  ($pointfinder_invoice_amount != 0)?number_format($pointfinder_invoice_amount, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands):0;
					}
					
					if(empty($inv_pack_price)){
						if ($setup20_paypalsettings_paypal_price_pref != 1) {
							/*Before*/
							$inv_pack_price = $total_package_price.' '.$setup20_paypalsettings_paypal_price_short;
						}else{
							$inv_pack_price = $setup20_paypalsettings_paypal_price_short.' '.$total_package_price;
						}
					}
					$inv_pack_id = $invoice_meta['pointfinder_invoice_packageid'][0];
			    }else{
			    	$setup20_paypalsettings_decimals = PFSAIssetControl('setup20_paypalsettings_decimals','','2');
					$setup20_paypalsettings_decimalpoint = PFSAIssetControl('setup20_paypalsettings_decimalpoint','','.');
					$setup20_paypalsettings_thousands = PFSAIssetControl('setup20_paypalsettings_thousands','',',');
					//$pointfinder_order_price = esc_attr(get_post_meta( $order_no, 'pointfinder_order_price', true ));

					$pointfinder_invoice_amount = get_post_meta( $params['invoiceid'], 'pointfinder_invoice_amount', true );

					$setup20_paypalsettings_paypal_price_pref = PFSAIssetControl('setup20_paypalsettings_paypal_price_pref','',1);
					$setup20_paypalsettings_paypal_price_short = PFSAIssetControl('setup20_paypalsettings_paypal_price_short','','$');


					$total_package_price =  ($pointfinder_invoice_amount != 0)?number_format($pointfinder_invoice_amount, $setup20_paypalsettings_decimals, $setup20_paypalsettings_decimalpoint, $setup20_paypalsettings_thousands):0;

					if ($setup20_paypalsettings_paypal_price_pref != 1) {
						/*Before*/
						$inv_pack_price = $total_package_price.' '.$setup20_paypalsettings_paypal_price_short;
					}else{
						$inv_pack_price = $setup20_paypalsettings_paypal_price_short.' '.$total_package_price;
					}

			    	$inv_order_desc = get_the_title($params['invoiceid']);
			    }
			    

				global $pfascontrol_options;

				$sitename = esc_attr(PFASSIssetControl('setup_invoices_sitename','',''));

				$setup_inv_temp_footertext = PFASSIssetControl('setup_inv_temp_footertext','','');
				$siteurl = get_site_url();

				$footer_text = str_replace( '%%sitename%%', $sitename, $setup_inv_temp_footertext );
				$footer_text = str_replace( '%%siteurl%%', $siteurl, $footer_text );


				$setup_inv_temp_logo = PFASSIssetControl('setup_inv_temp_logo','','1');
				$setup_inv_temp_logotext = esc_attr(PFASSIssetControl('setup_inv_temp_logotext','',''));
				$setup_inv_temp_mainbgcolor = (isset($pfascontrol_options['setup_inv_temp_mainbgcolor']))?$pfascontrol_options['setup_inv_temp_mainbgcolor']: '';
				$setup_inv_temp_headerfooter = (isset($pfascontrol_options['setup_inv_temp_headerfooter']))?$pfascontrol_options['setup_inv_temp_headerfooter']: '#f7f7f7';
				$setup_inv_temp_headerfooter_line = (isset($pfascontrol_options['setup_inv_temp_headerfooter_line']))?$pfascontrol_options['setup_inv_temp_headerfooter_line']: '#F25555';
				$setup_inv_temp_headerfooter_text = (isset($pfascontrol_options['setup_inv_temp_headerfooter_text']))?$pfascontrol_options['setup_inv_temp_headerfooter_text']: array('hover'=>'#F25555','regular'=>'#494949');
				$setup_inv_temp_contentbg = (isset($pfascontrol_options['setup_inv_temp_contentbg']))?$pfascontrol_options['setup_inv_temp_contentbg']: '#ffffff';
				$setup_inv_temp_contenttext = (isset($pfascontrol_options['setup_inv_temp_contenttext']))?$pfascontrol_options['setup_inv_temp_contenttext']: array('hover'=>'#F25555','regular'=>'#494949');
				$setup17_logosettings_sitelogo = PFSAIssetControl('setup17_logosettings_sitelogo','','');

				$setup_inv_temp_rtl = esc_attr(PFASSIssetControl('setup_inv_temp_rtl','','0'));

				if($setup_inv_temp_rtl == 1){$rtl_text = 'right';}else{$rtl_text = 'left';}

				$invoicecontent = $invoicetitle = '';

				ob_start();
				?>

				<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html>
				  <head>
				    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				    <meta name="viewport" content="width=320, target-densitydpi=device-dpi">
				    <style type="text/css" media="all">
				    	@media screen{table[class=w640]{ width:1024px !important}}
						@media all and (max-width:660px){ table[class=w0],td[class=w0]{ width:0 !important}
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
							table[class=w640], td[class=w640], img[class=w640]{ width:100% }
							table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide]{ display:none !important}
							table[class=h0], td[class=h0]{ height:0 !important}
							p[class=footer-content-left]{ text-align:center !important}
							#headline p{ font-size:30px !important}
							.article-content, #left-sidebar{ -webkit-text-size-adjust:90% !important;  -ms-text-size-adjust:90% !important}
							.header-content, .footer-content-left{ -webkit-text-size-adjust:80% !important;  -ms-text-size-adjust:80% !important}
							img{ height:auto;  line-height:100%}}
						 #outlook a{ padding:0}
						 body{ width:100% !important}
						 .ReadMsgBody{ width:100%}
						 .ExternalClass{ width:100%;  display:block !important}
						 body{ background-color:<?php echo $setup_inv_temp_mainbgcolor;?>;  margin:0;  padding:0;text-decoration:none}
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
						 #background-table{ background-color:<?php echo $setup_inv_temp_mainbgcolor;?>}
						 #sitelogoleft{text-align:left; margin-bottom:30px;}
						 #sitelogoright{text-align:right; margin-bottom:30px; float:right;}
						 body, td{ font-family:HelveticaNeue,sans-serif}
						 .header-content, .footer-content-left, .footer-content-right{ -webkit-text-size-adjust:none;  -ms-text-size-adjust:none}
						 .header-content{ font-size:12px;  color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;text-decoration:none}
						 .header-content a{ font-weight:bold;  color:#eee;  text-decoration:none}
						 #headline p{ color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;  font-family:HelveticaNeue,sans-serif;  font-size:36px;  text-align:<?php echo $rtl_text;?>;  margin-top:0px;  margin-bottom:30px;text-decoration:none}
						 #headline a p { color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;  text-decoration:none}
						 #headline a:hover p { color:<?php echo $setup_inv_temp_headerfooter_text['hover'];?>;text-decoration:none}
						 .article-title{ font-size:18px;  line-height:24px;  color:#7d7d7d;  font-weight:bold;  margin-top:0px;  margin-bottom:18px;  font-family:HelveticaNeue,sans-serif;text-align:<?php echo $rtl_text;?>;}
						 .article-title a{ color:<?php echo $setup_inv_temp_contenttext['regular'];?>;  text-decoration:none}
						 .article-title.with-meta{ margin-bottom:0}
						 .article-meta{ font-size:13px;  line-height:20px;  color:#ccc;  font-weight:bold;  margin-top:0}
						 .article-content{ font-size:13px;  line-height:18px;  color:#444;  margin-top:0px;  margin-bottom:18px;  font-family:HelveticaNeue,sans-serif;text-align:<?php echo $rtl_text;?>;}
						 .article-content a{ color:<?php echo $setup_inv_temp_contenttext['regular'];?>;  font-weight:bold;  text-decoration:none;}
						 .article-content a:hover{ color:<?php echo $setup_inv_temp_contenttext['hover'];?>;}
						 .article-content img{ max-width:100%}
						 .article-content ol, .article-content ul{ margin-top:0px;  margin-bottom:18px;  margin-<?php echo $rtl_text;?>:19px;  padding:0}
						 .article-content li{ font-size:13px;  line-height:18px;  color:#444}
						 .article-content li a{ color:<?php echo $setup_inv_temp_contenttext['regular'];?>;  text-decoration:none}
						 .article-content p{ margin-bottom:15px}

						 .footer-content-left{ font-size:12px;  line-height:15px;  color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;  margin-top:0px;  margin-bottom:15px}
						 .footer-content-left a{ color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;  font-weight:bold;  text-decoration:none}
						 .footer-content-left a:hover{ color:<?php echo $setup_inv_temp_headerfooter_text['hover'];?>;  font-weight:bold;  text-decoration:none}
						 
						 #simple-content-row,.contentrow{background-color:<?php echo $setup_inv_temp_contentbg;?>;color:<?php echo $setup_inv_temp_contenttext['regular'];?>;text-align:<?php echo $rtl_text;?>;}
						 #header{ border-top:3px solid <?php echo $setup_inv_temp_headerfooter_line;?>; background-color:<?php echo $setup_inv_temp_headerfooter;?>;color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;}
						 #footer{ border-bottom:3px solid <?php echo $setup_inv_temp_headerfooter_line;?>;  background-color:<?php echo $setup_inv_temp_headerfooter;?>;color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;}
						 #footer a{ color:<?php echo $setup_inv_temp_headerfooter_text['regular'];?>;  text-decoration:none;  font-weight:bold}

						 @media print {#sitelogoleft{text-align:left; margin-bottom:30px;}#sitelogoright{text-align:right; margin-bottom:30px; float:right;}}
						table.w580 {margin: 0 auto;}.h-pull-right{float:right}.financial_document{background:#f5f5f5;font:14px/21px sans-serif}@media print{.financial_document{background:#fff}}.invoice{border-radius:4px;margin:0 auto;width:900px;position:relative;background:#fff;font-size:16px;line-height:1.5;color:#999}.invoice a{color:#0084b4}.invoice strong{color:#444}.pfinv-column{float:left;padding-right:15px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pfinv-column.-span-10{width:10%}.pfinv-column.-span-20{width:20%}.pfinv-column.-span-25{width:25%}.pfinv-column.-span-30{width:30%}.pfinv-column.-span-35{width:35%}.pfinv-column.-span-40{width:40%}.pfinv-column.-span-50{width:50%}.pfinv-column.-span-60{width:60%}.pfinv-column.-span-75{width:75%}.pfinv-column.-last{float:right;padding:0}.pfinv-column.-left-padded{padding-left:25px}.pfinv-header{background:#444;border-radius:4px 4px 0 0;color:#fff;display:block;height:60px;line-height:60px;width:100%}@media print{.pfinv-header{background:#f5f5f5;color:#444}}.pfinv-supplier{margin-top:20px}.pfinv-envato-logo{float:left;width:150px;padding-left:20px}.pfinv-envato-logo img{height:16px}.envato-logo--print{display:none}@media print{.envato-logo--print{display:inline}}.envato-logo--screen{display:inline}@media print{.envato-logo--screen{display:none}}.pfinv-document-title{float:right;padding-right:20px;font-size:16px;font-weight:700}.pfinv-details{padding:20px 40px}.pfinv-details .right span{display:inline-block}.pfinv-details-label{vertical-align:top;padding-right:30px;font-weight:700;color:#444}.pfinv-details-content{display:inline-block}.pfinv-details:after{content:"";display:table;clear:both}.pfinv-item-container{background:#f5f5f5;padding:20px;margin-bottom:20px}.pfinv-lines{padding:40px}.pfinv-lines h3{font-size:16px;font-weight:700;padding-bottom:20px;color:#444}.pfinv-lines table{border-collapse:separate;font-size:14px;width:100%;page-break-inside:auto}.pfinv-lines table .pfinv-th--price,.pfinv-lines table .pfinv-th--rate,.pfinv-lines table .pfinv-td--price,.pfinv-lines table .pfinv-td--rate{text-align:right;padding:0}.pfinv-lines table th{line-height:2;text-align:left;font-weight:bold;color:#444;padding-right:15px}.pfinv-lines table tr{page-break-inside:avoid;page-break-after:auto}.pfinv-lines table td{text-align:left;vertical-align:top;padding-right:15px;padding-top:2px}.pfinv-lines table td.pfinv-td--id{width:10%}.pfinv-lines table td.pfinv-td--entity{width:20%}.pfinv-lines table td.pfinv-td--description{width:60%}.pfinv-lines table td.pfinv-td--quantity{width:10%}.pfinv-lines table td.pfinv-td--price{text-align:right;width:20%}.pfinv-lines table td.pfinv-td--rate{text-align:right;width:10%}.pfinv-lines table td.pfinv-td--total{text-align:right}.pfinv-lines table td.pfinv-th--rate{text-align:right}.pfinv-footer{padding:0 40px}.pfinv-notice{font-size:14px}.pfinv-notice.-margin-top{margin-top:10px}.pfinv-notice.-margin-bottom{margin-bottom:10px}.pfinv-footnotes{padding:40px;padding-top:0px;text-align:center}.pfinv-footnotes.-left-align{text-align:left}.pfinv-total{color:#444;font-weight:700;text-align:right;margin-top:10px}.pfinv-total.-outside-container{padding-right:20px;margin-top:0}.pfinv-total.-amount{font-size:24px}.pfinv-total-amount{color:#444;font-size:32px;font-weight:700;line-height:1;padding-right:20px;text-align:right}.pfinv-payment-method{text-align:right}.pfinv-footer:after{content:"";display:table;clear:both}
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
					<script> 
					window.print();
					window.history.pushState("", "", "/?p=<?php echo $params['invoiceid'];?>");
					</script>
				  </head>
				  <body>
				    <table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table" style="table-layout:fixed" align="center">
				      <tbody>
				        <tr>
				          <td align="center">
				        	<table class="w640" cellpadding="0" cellspacing="0" border="0">
				              <tbody>
				                
				                  <tr>
				                    <td id="header" class="w640" width="100%" align="center">
				                      
				                      <table class="w640" width="100%" cellpadding="0" cellspacing="0" border="0">
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
				                                        if(esc_attr($setup_inv_temp_logo) == 0){
				                                        	echo '<p><strong><singleline label="Title">'.$setup_inv_temp_logotext.'</singleline></p></strong>';
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
				                    <td class="w640" width="100%" height="30">
				                    </td>
				                  </tr>
				                  <tr id="simple-content-row">
				                    <td class="w640" width="100%">
				                      <table class="w640" width="100%" cellpadding="0" cellspacing="0" border="0">
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
				                                          
				                                          <div class="article-content invoice">

															


				                                            <div class="pfinv-details">
															  <table class="h-pull-right">
															    <tbody><tr class="pfinv-date">
															      <td class="pfinv-details-label"><?php esc_html_e('Date:','pointfindert2d');?></td>
															      <td><?php echo $inv_date;?></td>
															    </tr>
															    <tr class="pfinv-number">
															      <td class="pfinv-details-label"><?php esc_html_e('Invoice No:','pointfindert2d');?></td>
															      <td><?php echo $inv_no;?></td>
															    </tr>
															      <tr class="pfinv-order-number">
															        <td class="pfinv-details-label"><?php esc_html_e('Order No:','pointfindert2d');?></td>
															        <td><?php echo $order_no_out;?></td>
															      </tr>
															  </tbody></table>
															</div>

															<div class="pfinv-details">
															  <div class="pfinv-column -span-50">
															    <div class="pfinv-buyer">
															      <strong><?php esc_html_e('To:','pointfindert2d');?></strong><br>
															      <?php echo $inv_user_title;?><br>
															      <?php echo $inv_user_address;?><br>
															      <?php echo $inv_user_country;?><br>
															      <?php echo $inv_user_vat;?>
															    </div>
															  </div>


															  <div class="pfinv-column -span-50 -last">
															    <div class="pfinv-seller">
															      <strong><?php esc_html_e('Site Owner:','pointfindert2d');?></strong><br>
															      <?php echo $inv_adm_title;?><br>
															      <?php echo $inv_adm_address;?><br>
															      <?php echo $inv_adm_country;?><br>
															      <?php echo $inv_adm_vat;?>
															    </div>


															  </div>
															</div>
															
															<div class="pfinv-lines">
															    <div class="pfinv-item-container">
															      <table>
															        <thead>
															          <tr>
															            <?php if(!empty($inv_pack_id)){?><th><?php esc_html_e('Item ID','pointfindert2d');?></th><?php }?>
															            <th><?php esc_html_e('Qty','pointfindert2d');?></th>
															            <th><?php esc_html_e('Description','pointfindert2d');?></th>
															            <th class="pfinv-th--price"><?php esc_html_e('Amount','pointfindert2d');?></th>
															          </tr>
															        </thead>

															        <tbody>
															            <tr>
															              <?php if(!empty($inv_pack_id)){?><td class="pfinv-td--id"><?php echo $inv_pack_id;?></td><?php }?>
															              <td class="pfinv-td--quantity">1</td>
															              <td class="pfinv-td--description"><?php echo $inv_order_desc;?></td>
															              <td class="pfinv-td--price"><?php echo $inv_pack_price;?></td>
															            </tr>
															        </tbody>
															      </table>
															      <div class="pfinv-total">
															        <?php echo esc_html__('Invoice Total:','pointfindert2d').' '.$inv_pack_price;?>
															      </div>
															      <div class="pfinv-payment-method">
															        <?php echo esc_html__('Paid via','pointfindert2d').' '.$inv_paid_via;?>
															      </div>
															    </div>
															  </div>



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
				                    <td class="w640" width="100%" height="15">
				                    </td>
				                  </tr>
				                  <tr class="contentrow">
				                    <td class="w640" width="100%">
				                      <table id="footer" class="w640" width="100%" cellpadding="0" cellspacing="0" border="0">
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
				                    <td class="w640" width="100%" height="60">
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
		*End : Invoice HTML Template
		**/

/**
*End : User system emails
**/
?>