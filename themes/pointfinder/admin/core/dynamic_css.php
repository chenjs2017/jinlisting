<?php
/*------------------------------------*\
	External Output Styles
\*------------------------------------*/
global $pointfindertheme_option;

function pf_hex_color_mod($hex, $diff) {
	$rgb = str_split(trim($hex, '# '), 2);
 
	foreach ($rgb as &$hex) {
		$dec = hexdec($hex);
		if ($diff >= 0) {
			$dec += $diff;
		}
		else {
			$dec -= abs($diff);			
		}
		$dec = max(0, min(255, $dec));
		$hex = str_pad(dechex($dec), 2, '0', STR_PAD_LEFT);
	}
 
	return '#'.implode($rgb);
}

function PointFindergetContrast( $color) {

	$hex = str_replace( '#', '', $color );

	$c_r = hexdec( substr( $hex, 0, 2 ) );
	$c_g = hexdec( substr( $hex, 2, 2 ) );
	$c_b = hexdec( substr( $hex, 4, 2 ) );

	$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

	return $brightness > 155 ? 'black' : 'white';
}

function pointfindermobilehex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }

   return $r.','.$g.','.$b;
}


/*
* Get variables
*/

$setup18_headerbarsettings_bordersettings = PFSAIssetControl('setup18_headerbarsettings_padding_menu','border-color','#cccccc');
$setup22_searchresults_text_typo = PFSAIssetControl('setup22_searchresults_text_typo','color','#000');
$setup18_headerbarsettings_menusubmenuwidth = PFSAIssetControl('setup18_headerbarsettings_menusubmenuwidth','','190');
$setup_footerbar_text = PFSAIssetControl('setup_footerbar_text','regular','#ffffff');
$setup_footerbar_text_copy_align = PFSAIssetControl('setup_footerbar_text_copy_align','','left');
$setup21_widgetsettings_3_slider_capt = PFPBSIssetControl('setup21_widgetsettings_3_slider_capt','color','#000');
$general_postitembutton_bordercolor = PFPBSIssetControl('general_postitembutton_bordercolor','color','#ededed');
$general_postitembutton_button_height = PFPBSIssetControl('general_postitembutton_button_height','','30');
$general_postitembutton_button_mtop = PFPBSIssetControl('general_postitembutton_button_mtop','','30');
$general_postitembutton_button_mtop2 = PFPBSIssetControl('general_postitembutton_button_mtop2','','6');
$setup_footerbar_status = PFSAIssetControl('setup_footerbar_status','','1');
$setup_footerbar_bg = PFSAIssetControl('setup_footerbar_bg','','#fff');
$setupsizelimitconf_general_gallerysize2_h = PFSizeSIssetControl('setupsizelimitconf_general_gallerysize2','height','100px');

/*Info Window*/
$setup10_infowindow_width = PFSAIssetControl('setup10_infowindow_width','','350');
$setup10_infowindow_height = PFSAIssetControl('setup10_infowindow_height','','136');
$setup10_infowindow_img_width = PFSAIssetControl('setup10_infowindow_img_width','','154');
$setup12_searchwindow_background_mobile = PFSAIssetControl('setup12_searchwindow_background_mobile','','#384b56');
$setup10_infowindow_background = (isset($pointfindertheme_option['setup10_infowindow_background']['color']))?$pointfindertheme_option['setup10_infowindow_background']['color']:'#ffffff';
$s10_iw_w_m = PFSAIssetControl('s10_iw_w_m','','184');
$s10_iw_h_m = PFSAIssetControl('s10_iw_h_m','','136');

/*Start: Menu Variables*/

	/*Top Bar Variables*/
	$setup12_searchwindow_topbarbackground_ex = PFSAIssetControl('setup12_searchwindow_topbarbackground_ex','hover','#ffffff');
	$setup12_searchwindow_topbarhovercolor = PFSAIssetControl('setup12_searchwindow_topbarhovercolor','hover','#b00000');
	$setup12_searchwindow_sbuttonbackground1_ex = PFSAIssetControl('setup12_searchwindow_sbuttonbackground1_ex','hover','#ffffff');
	$setup12_searchwindow_background_activeline = PFSAIssetControl('setup12_searchwindow_background_activeline','','#b00000');

	/*Sub Menu: Bottom Border*/
	$setup18_headerbarsettings_bordersettingssub = (isset($pointfindertheme_option['setup18_headerbarsettings_bordersettingssub']))?$pointfindertheme_option['setup18_headerbarsettings_bordersettingssub']:'';
	$setup18_headerbarsettings_bordersettingssub_color = (isset($setup18_headerbarsettings_bordersettingssub['border-color']))?$setup18_headerbarsettings_bordersettingssub['border-color']:'#efefef';

/*End: Menu variables*/


/*Search Window Variables*/
	$setup12_searchwindow_background = PFSAIssetControl('setup12_searchwindow_background','rgba','#494949');
	$setup12_searchwindow_context = PFSAIssetControl('setup12_searchwindow_context','','#ffffff');
	$setup12_searchwindow_background_mobile = PFSAIssetControl('setup12_searchwindow_background_mobile','','#ffffff');


$setup42_itempagedetails_8_styles_buttoncolor = PFSAIssetControl('setup42_itempagedetails_8_styles_buttoncolor','regular','#494949');
$setup42_itempagedetails_8_styles_buttoncolor_h = PFSAIssetControl('setup42_itempagedetails_8_styles_buttoncolor','hover','#494949');
$setup42_itempagedetails_8_styles_buttontextcolor = PFSAIssetControl('setup42_itempagedetails_8_styles_buttontextcolor','regular','#ffffff');
$setup42_itempagedetails_8_styles_buttontextcolor_h = PFSAIssetControl('setup42_itempagedetails_8_styles_buttontextcolor','hover','#ffffff');
$tcustomizer_typographyh_main_bg = (isset($pointfindertheme_option['tcustomizer_typographyh_main_bg']['background-color']))?$pointfindertheme_option['tcustomizer_typographyh_main_bg']['background-color']:'#ffffff';
$setup43_themecustomizerf_content_bgcolor = PFSAIssetControl('setup43_themecustomizerf_content_bgcolor','','#fafafa');
$tcustomizer_typographyh_main = PFSAIssetControl('tcustomizer_typographyh_main','font-size','14px');
$tcustomizer_typographyh_main_color = (isset($pointfindertheme_option['tcustomizer_typographyh_main']['color']))?$pointfindertheme_option['tcustomizer_typographyh_main']['color']:'#494949';
$setup30_dashboard_styles_bodyborder = PFSAIssetControl('setup30_dashboard_styles_bodyborder','','#ebebeb');
$setup42_itempagedetails_8_styles_elementcolor = PFSAIssetControl('setup42_itempagedetails_8_styles_elementcolor','','#a32221');
$setup18_headerbarsettings_menulinecolor = PFSAIssetControl('setup18_headerbarsettings_menulinecolor','','');


$setup12_searchwindow_context = PFSAIssetControl('setup12_searchwindow_context','','#ffffff');
$setup13_mapcontrols_barhovercolor = PFSAIssetControl('setup13_mapcontrols_barhovercolor','','#ffffff');
$setup8_pointsettings_pointopacity = PFSAIssetControl('setup8_pointsettings_pointopacity','','0.7');
$setup22_searchresults_headerborder = (isset($pointfindertheme_option['setup22_searchresults_headerborder']))?$pointfindertheme_option['setup22_searchresults_headerborder']:'';
$setup18_headerbarsettings_menucolor = (isset($pointfindertheme_option['setup18_headerbarsettings_menucolor']))?$pointfindertheme_option['setup18_headerbarsettings_menucolor']['regular']:'#fafafa';
$setup13_mapcontrols_position = PFSAIssetControl('setup13_mapcontrols_position','','1');
$setup13_mapcontrols_position_tooltip = PFSAIssetControl('setup13_mapcontrols_position_tooltip','','1');
$setup13_mapcontrols_barhovercolor = PFSAIssetControl('setup13_mapcontrols_barhovercolor','','#fff');


	$csstext = '';

	/*v1.6.1.3 footer bar fix*/
	if ($setup_footerbar_status == 1) {
		$csstext .= 'html{background-color:'.$setup_footerbar_bg.'}';
	}

	$csstext .= '.pfshowmaplink:hover{color:'.pf_hex_color_mod($setup22_searchresults_text_typo,-40).'}';

	/*Lighter text for Ui Item*/
		$csstext .= '.pfnavmenu .pfnavsub-menu{min-width:'.$setup18_headerbarsettings_menusubmenuwidth.'px;}';
		$csstext .= '.wpf-footer,.wpf-footer-text{color:'.$setup_footerbar_text.'!important;}';
		$csstext .= '.wpf-footer-text{text-align:'.$setup_footerbar_text_copy_align.'}';
		$csstext .= '.pf-item-slider .pf-item-slider-golink:hover{background-color:'.$setup21_widgetsettings_3_slider_capt.'}';


	/* Start: WPML Language Selector for Mobile*/
		if (function_exists('icl_t')) {
			$csstext .= '#pf-topprimary-nav-button2{right:55px;}';
			$csstext .= '#pf-primary-search-button{right:135px;}';
			$csstext .= '#pf-primary-nav-button{right:95px;}';
		}else{
			$csstext .= '#pf-topprimary-nav-button2{display:none!important}';
		}
	/* End: WPML Language Selector for Mobile*/

	/* Start: Info Window*/
		$csstext .= '#pfsearch-draggable.pfshowmobile,#pfsearch-draggable.pfshowmobile .pfsearch-content,#pfsearch-draggable.pfshowmobile .pfitemlist-content,#pfsearch-draggable.pfshowmobile .pfmapopt-content,#pfsearch-draggable.pfshowmobile .pfuser-content{background-color:'.$setup12_searchwindow_background_mobile.'}';
		$csstext .= '.wpfarrow{border-color:'.$setup10_infowindow_background.' transparent transparent transparent;}';
		if (PointFindergetContrast($setup10_infowindow_background) == 'white') {
			$csstext .= '.wpfinfowindow .pfloadingimg{background-image: url('.get_template_directory_uri().'/images/info-loading-bl.gif)!important;background-size: 24px 24px;background-repeat: no-repeat;background-position: center;}';	
		}

		if (PointFindergetContrast($tcustomizer_typographyh_main_bg) == 'white') {
			$csstext .= '.pfsearchresults-loading .pfloadingimg{background-image: url('.get_template_directory_uri().'/images/info-loading-bl.gif)!important;background-size: 24px 24px;background-repeat: no-repeat;background-position: center;}';	
		}

		if($setup10_infowindow_width != 350){ 
			$csstext .= '@media (min-width: 568px){#wpf-map .wpfarrow,#item-map-page .wpfarrow{left:'.(($setup10_infowindow_width/2)-8).'px!important;}}';
		}

		if($s10_iw_w_m != 184){ 
			$csstext .= '@media (max-width: 568px){#wpf-map .wpfarrow,#item-map-page .wpfarrow{left:'.(($s10_iw_w_m/2)-8).'px!important;}}';
		}

		if($setup10_infowindow_img_width != 154){ 
			$csstext .= '#wpf-map .wpfinfowindow .wpfimage-wrapper,#item-map-page .wpfinfowindow .wpfimage-wrapper{width:'.$setup10_infowindow_img_width.'px!important}';
		}

		if($setup10_infowindow_width != 350 || $setup10_infowindow_height != 136){
			$csstext .= '@media (min-width: 568px){#wpf-map .wpfinfowindow,#item-map-page .wpfinfowindow{width:'.$setup10_infowindow_width.'px;height:'.$setup10_infowindow_height.'px;}.wpfinfowindow .wpftext{height:'.$setup10_infowindow_height.'px;}}';
		}

		if ($s10_iw_w_m != 184 && $s10_iw_h_m != 136) {
			$csstext .= '@media (max-width: 568px){#wpf-map .wpfinfowindow,#item-map-page .wpfinfowindow{width:'.$s10_iw_w_m.'px;height:'.$s10_iw_h_m.'px;}.wpfinfowindow .wpftext{height:'.$s10_iw_h_m.'px;}}';
		}

	/* End: Info Window*/






	/* Start: Search Window & Map Controls Buttons/Colors/etc... */

		$searchconfig_count = 0;
		for ($i=1; $i <= 3; $i++) { 
			if (PFSAIssetControl('setup12_searchwindow_buttonconfig'.$i,'','1') == 1) {
				$searchconfig_count = $searchconfig_count + 1;
			} 
		}
		if($searchconfig_count == 2){
			$csstext .= '.pfsearch-draggable-window .pfsearch-header ul li{width:33.333333334%;}@media (max-width: 568px) {.pfsearch-draggable-window .pfsearch-header ul li{width:50%;}}';
		}elseif($searchconfig_count == 1){
			$csstext .= '.pfsearch-draggable-window .pfsearch-header ul li{width:50%;}@media (max-width: 568px) {.pfsearch-draggable-window .pfsearch-header ul li{width:100%;}}';
		}elseif($searchconfig_count == 0){
			$csstext .= '.pfsearch-draggable-window .pfsearch-header ul li{width:100%;}';
		}

		$csstext .= '#pfsearch-draggable .pfdragcontent{color:'.$setup12_searchwindow_context.'!important;}';
		$csstext .= '.pfadditional-filters:after{border-bottom-color:rgb('.pointfindermobilehex2rgb($setup12_searchwindow_context).');border-bottom-color:rgba('.pointfindermobilehex2rgb($setup12_searchwindow_context).',0.5);}';
		$csstext .= '.pfsopenclose i,.pfsopenclose2 i,.pfsopenclose2{color:'.$setup12_searchwindow_context.'}.pfsopenclose2:hover{color:'.pf_hex_color_mod($setup12_searchwindow_context,-20).'}';
		$csstext .= '.pfcontrol-locate{fill: '.$setup13_mapcontrols_barhovercolor.';}';
		if ($setup13_mapcontrols_position_tooltip == 0) {$csstext .= '.golden-forms .info-tip3 .pftooltipx {display:none!important;}';}
		if($setup13_mapcontrols_position == 1){$csstext .= '#pfcontrol{left: 5px;}';}else{$csstext .= '#pfcontrol{right: 5px;}';}
		$csstext .= '.pfsearchresults-header .select,.pfsearchresults-header .select:hover{border:1px solid '.$setup22_searchresults_headerborder.'}';
		/* Pin Opacities */
		$csstext .= '.pf-map-pin-1{opacity:'.$setup8_pointsettings_pointopacity.';}.pf-map-pin-1:hover,.pf-map-pin-x:hover{opacity:1!important}';
		$csstext .= '.pfmaptype-control{color:'.$setup13_mapcontrols_barhovercolor.'!important;}';

	/* End: Search Window Buttons */


	/*Box shadow color change for different bg*/
		$setup18_headerbarsettings_menucolor2_bg3 = (isset($pointfindertheme_option['setup18_headerbarsettings_menucolor2_bg3']['regular']))?$pointfindertheme_option['setup18_headerbarsettings_menucolor2_bg3']['regular']:'#ffffff';



	/* Start: General Settings (Border etc...) */
		$csstext .= '.wpf-header #pf-primary-nav .pfnavmenu .pfnavsub-menu{background-color:'.$setup18_headerbarsettings_menucolor2_bg3.'!important}';
		$csstext .= '.wpf-header #pf-primary-nav .pfnavmenu .pfnavsub-menu li,#pf-topprimary-nav .pfnavmenu .pfnavsub-menu li{border-bottom:1px solid '.$setup18_headerbarsettings_bordersettingssub_color.'}';
		$csstext .= 'hr,.widgetheader,.dsidx-prop-title,#dsidx-listings .dsidx-primary-data,.pfwidgetinner .select,.pfwidgetinner .select:hover,.widget_pfitem_recent_entries ul li,#jstwitter .tweet,.pfwidgetinner .dsidx-search-widget select,.pf-bbpress-forum-container .bbp-pagination,.pf-bbpress-forum-container .bbp-topic-form,.pf-bbpress-forum-container .bbp-reply-form,#bbpress-forums fieldset.bbp-form input,#bbpress-forums fieldset.bbp-form textarea,#bbpress-forums li.bbp-header,.bbp-search-form input,.bbp-submit-wrapper button,.dsidx-widget li, .dsidx-list li,#dsidx-actions,#dsidx-header,#dsidx-description,#dsidx-secondary-data,.dsidx-supplemental-data,#dsidx-map,.dsidx-contact-form,#dsidx-contact-form-header,.dsidx-details h3,#dsidx-property-types,#bbp-user-navigation,#dsidx textarea,#dsidx table,#dsidx-contact-form-submit,.dsidx-search-widget input,.widget_search input,.pf_pageh_title .pf_pageh_title_inner,.pf-agentlist-pageitem .pf-itempage-sidebarinfo-elname,.pfajax_paginate >.page-numbers >li >a,.pfstatic_paginate >.page-numbers >li >a,.pf-item-title-bar,.pf-itempage-sharebar,.pf-itempage-sharebar .pf-sharebar-others li a,.pf-itempage-sharebar .pf-sharebar-others li:first-child,.pf-itempage-sharebar .pf-sharebar-icons li,.pf-itempage-sharebar .pf-sharebar-others li:last-child a,.ui-tabgroup >.ui-panels >[class^="ui-tab"],.pfitempagecontainerheader,.pf-itempage-ohours ul li,.pfdetailitem-subelement,.pfmainreviewinfo,.pf-itempage-subheader,.review-flag-link,.pf-itemrevtextdetails,.comments .comment-body,.pfreviews .pfreview-body,.pfajax_paginate >.page-numbers >li,.pfstatic_paginate >.page-numbers >li,.pf-authordetail-page .pf-itempage-sidebarinfo-elname,.pf-itempage-sidebarinfo .pf-itempage-sidebarinfo-userdetails ul .pf-itempage-sidebarinfo-elitem i,.pf-itempage-subheader,.pf-itempage-maindiv .ui-tabs,.pf-itempage-maindiv .pf-itempagedetail-element, .pftrwcontainer.pfrevformex,.pf-itempage-uaname,#pfuaprofileform .select, #pfuaprofileform .button, .pfmu-payment-area .select, .pfmu-payment-area .select:hover, .pfmu-itemlisting-inner .pfmu-userbuttonlist-item .button, .pfmu-itemlisting-inner .pfmu-userbuttonlist-item .button:hover,.pfuaformsidebar .pf-sidebar-cartitems .pftotal,.pfuaformsidebar .pf-sidebar-menu li:last-child,.pfuaformsidebar .pf-sidebar-menu li:first-child,.pfuaformsidebar .pf-sidebar-menu li,#pfuaprofileform .pfmu-itemlisting-inner,#bbpress-forums li.bbp-body ul.forum, #bbpress-forums li.bbp-body ul.topic,.post-minfo,.pf-post-comment-inner,.pointfinder-post .post-minfo,.post-mtitle,.widget_pfitem_recent_entries .golden-forms .button.pfsearch,.pf-uadashboard-container .pfalign-right,.post,.post-mtitle,.single-post .post-minfo,.pf-singlepost-clink,#pf-contact-form-submit,.pf-notfound-page .btn-success,.golden-forms .input,.pflist-item-inner .pflist-subitem,.pflistgridview .pflistcommonview-header .searchformcontainer-filters .pfgridlist2, .pflistgridview .pflistcommonview-header .searchformcontainer-filters .pfgridlist3, .pflistgridview .pflistcommonview-header .searchformcontainer-filters .pfgridlist4, .pflistgridview .pflistcommonview-header .searchformcontainer-filters .pfgridlist5,.pflistgridview .pflistcommonview-header .searchformcontainer-filters .pfgridlist6,.pfheaderbarshadow2,.comment-reply-title small a,.comment-body .reply,#item-map-page,.widget_pfitem_recent_entries .pf-widget-itemlist li:last-child,.widget_pfitem_recent_entries .pf-widget-itemlist li,.pf-enquiry-form-ex,.pointfinder-comments-paging a,.pfwidgetinner,.pf-page-links,.pfsubmit-title,.pfsubmit-inner,.pf-itempage-br-xm-nh,.pf-itempage-br-xm,.pf-item-extitlebar,.itp-featured-img,.wpf-header.pfshrink,#pf-itempage-page-map-directions .gdbutton,#pf-itempage-page-map-directions .gdbutton2,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.pf-dash-userprof .pf-dash-packageinfo .pf-dash-pinfo-col,.pf-membership-package-box,.pf-membership-upload-option,.pf-lpacks-upload-option,.pf-membership-price-header,.pf-dash-errorview-plan,#pfuaprofileform .mce-panel,.pf-listing-item-inner-addinfo ul li,.pf-listing-item-inner-addinfo,#pfuaprofileform .pfhtitle .pfmu-itemlisting-htitle,#pfuaprofileform .pfhtitle,#pfuaprofileform .pfmu-itemlisting-container .pfmu-itemlisting-inner,#pfuaprofileform .pfmu-itemlisting-container.pfmu-itemlisting-container-new .pfmu-itemlisting-inner,.pflistingtype-selector-main label,.pfpack-selector-main label,.pfitemlists-content-elements.pf1col .pflist-item {border-color:'.$setup30_dashboard_styles_bodyborder.'!important;}';
		$csstext .= '.pfuaformsidebar .pf-sidebar-menu li.pf-dash-userprof:hover,.pf-membership-price-header{background-color:'.$setup42_itempagedetails_8_styles_buttoncolor.';color:'.$setup42_itempagedetails_8_styles_buttontextcolor.';}';

		$csstext .= '.widget_pfitem_recent_entries .pf-widget-itemlist li:hover {box-shadow: 0 0 10px '.$setup30_dashboard_styles_bodyborder.';}';
		$csstext .= '.pfwidgetinner.pfemptytitle{border-top:1px solid '.$setup30_dashboard_styles_bodyborder.'}';
		$csstext .= '.pfdetailitem-subelement .pfdetail-ftext.pf-pricetext{color:'.$setup42_itempagedetails_8_styles_elementcolor.'!important;}';
		$csstext .= '.pf-arrow-up {border-bottom-color:'.$setup30_dashboard_styles_bodyborder.'}';
		$csstext .= '.pfwidgettitle .widgetheader:after,.pf_pageh_title .pf_pageh_title_inner:after,.pf-item-title-bar:after,.pfitempagecontainerheader:after,.pf-itempage-subheader:after,.pfmu-itemlisting-htitle.pfexhtitle:after,.pf-agentlist-pageitem .pf-itempage-sidebarinfo-elname:after,.post-mtitle:after,.single-post .post-title:after,.dsidx-prop-title:after, #dsidx-listings .dsidx-listing .dsidx-primary-data:after,#dsidx-actions:after,.pf-itempage-sidebarinfo .pf-itempage-sidebarinfo-userdetails ul .pf-itempage-sidebarinfo-elname:after{border-color:'.$setup42_itempagedetails_8_styles_elementcolor.'}';


		/*General Button Style*/
		$csstext .= '#pointfinder-search-form .golden-forms .slider-wrapper, #pointfinder-search-form .golden-forms .sliderv-wrapper{background:'.$setup12_searchwindow_sbuttonbackground1_ex.'!important;}';
		$csstext .= '#pfsearch-draggable .slider-input,.golden-forms input, .golden-forms button, .golden-forms select, .golden-forms select optgroup, .golden-forms textarea, .wpcf7 input, .wpcf7 button, .wpcf7 select, .wpcf7 textarea,.select2-results .select2-result-label,.woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt,.woocommerce .cart .button, .woocommerce .cart input.button .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt,#pf-itempage-page-map-directions .gdbutton,#pf-itempage-page-map-directions .gdbutton2{font-size:'.$tcustomizer_typographyh_main.';}';
		$csstext .= '#pfuaprofileform .select,#pfuaprofileform .select-multiple,#pfuaprofileform .button,.pfmu-payment-area .select,.pfmu-payment-area .select:hover,.pfmu-itemlisting-inner .pfmu-userbuttonlist-item .button,.widget_tag_cloud a,.golden-forms #commentform .button,.ui-tabgroup >.ui-tabs >[class^="ui-tab"],.pfmu-itemlisting-inner .pfmu-userbuttonlist-item .button:hover,.woocommerce #content input.button.alt,.woocommerce .cart .button, .woocommerce .cart input.button .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt{border:1px solid '.$setup30_dashboard_styles_bodyborder.'}';
		
		/*Woocommerce addons */
		$csstext .= '.woocommerce #content input.button.alt,.woocommerce .cart .button, .woocommerce .cart input.button .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt{color:'.$setup42_itempagedetails_8_styles_buttontextcolor.';}';
		$csstext .= '.woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce .cart .button:hover, .woocommerce .cart input.button:hover .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover{color:'.$setup42_itempagedetails_8_styles_buttontextcolor_h.';}';
		
		$csstext .= '.woocommerce #content input.button.alt,.woocommerce .cart .button, .woocommerce .cart input.button .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt{background-color:'.$setup42_itempagedetails_8_styles_buttoncolor.';}';
		$csstext .= '.woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce .cart .button:hover, .woocommerce .cart input.button:hover .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover{background-color:'.$setup42_itempagedetails_8_styles_buttoncolor_h.';}';


		$csstext .= '.pf-sidebar-menu li a .pfbadge{background-color:'.$setup42_itempagedetails_8_styles_buttontextcolor.';color:'.$setup42_itempagedetails_8_styles_buttoncolor.';}';
		$csstext .= '.widget_tag_cloud a{background-color:'.$setup42_itempagedetails_8_styles_buttoncolor.';color:'.$setup42_itempagedetails_8_styles_buttontextcolor.';}';
		$csstext .= '.pfajax_paginate > .page-numbers > li > .current,.pfstatic_paginate > .page-numbers > li > .current,.pointfinder-comments-paging .current,.pointfinder-comments-paging a:hover,.pfajax_paginate > .page-numbers > li > a:hover,.pfstatic_paginate > .page-numbers > li > a:hover{border-color:'.$setup42_itempagedetails_8_styles_elementcolor.'!important;}';


		/*Tab System*/
		$csstext .= '.pftogglemenulist li[data-pf-toggle="active"]{background-color:'.$setup12_searchwindow_background.'!important;}';
		$csstext .= '.pftogglemenulist li[data-pf-toggle="active"] i{color:'.$setup12_searchwindow_context.'!important;}';
		$csstext .= '@media (max-width: 568px) {.pftogglemenulist li[data-pf-toggle="active"]{background-color:'.$setup12_searchwindow_background_mobile.'!important;}}';
		$csstext .= '.pftogglemenulist li[data-pf-toggle="active"]:after{border-color:'.$setup12_searchwindow_background_activeline.'!important;}';
		$csstext .= '.ui-tabgroup >.ui-tabs >[class^="ui-tab"]{color:'.pf_hex_color_mod($tcustomizer_typographyh_main_color,30).';background-color:'.pf_hex_color_mod($tcustomizer_typographyh_main_bg,-5).'}';
		$csstext .= '.ui-tabgroup >.ui-tabs >[class^="ui-tab"]:hover{color:'.$setup42_itempagedetails_8_styles_elementcolor.';}';
		$csstext .= '.comment-reply-title small a,.comment-body .reply{background-color:'.pf_hex_color_mod($tcustomizer_typographyh_main_bg,-5).'}';
		$csstext .= '.ui-tabgroup >input.ui-tab1:checked ~ .ui-tabs >.ui-tab1, .ui-tabgroup >input.ui-tab2:checked ~ .ui-tabs >.ui-tab2, .ui-tabgroup >input.ui-tab3:checked ~ .ui-tabs >.ui-tab3, .ui-tabgroup >input.ui-tab4:checked ~ .ui-tabs >.ui-tab4, .ui-tabgroup >input.ui-tab5:checked ~ .ui-tabs >.ui-tab5, .ui-tabgroup >input.ui-tab6:checked ~ .ui-tabs >.ui-tab6, .ui-tabgroup >input.ui-tab7:checked ~ .ui-tabs >.ui-tab7, .ui-tabgroup >input.ui-tab8:checked ~ .ui-tabs >.ui-tab8, .ui-tabgroup >input.ui-tab9:checked ~ .ui-tabs >.ui-tab9{color:'.$setup42_itempagedetails_8_styles_elementcolor.'; background-color:'.$tcustomizer_typographyh_main_bg.';}';
		$csstext .= '.ui-tabgroup >input.ui-tab1:checked ~ .ui-tabs >.ui-tab1:after, .ui-tabgroup >input.ui-tab2:checked ~ .ui-tabs >.ui-tab2:after, .ui-tabgroup >input.ui-tab3:checked ~ .ui-tabs >.ui-tab3:after, .ui-tabgroup >input.ui-tab4:checked ~ .ui-tabs >.ui-tab4:after, .ui-tabgroup >input.ui-tab5:checked ~ .ui-tabs >.ui-tab5:after, .ui-tabgroup >input.ui-tab6:checked ~ .ui-tabs >.ui-tab6:after, .ui-tabgroup >input.ui-tab7:checked ~ .ui-tabs >.ui-tab7:after, .ui-tabgroup >input.ui-tab8:checked ~ .ui-tabs >.ui-tab8:after, .ui-tabgroup >input.ui-tab9:checked ~ .ui-tabs >.ui-tab9:after{border-color:'.$tcustomizer_typographyh_main_bg.'}';
		$csstext .= '.ui-tabgroup >input.ui-tab1:checked ~ .ui-tabs >.ui-tab1:before, .ui-tabgroup >input.ui-tab2:checked ~ .ui-tabs >.ui-tab2:before, .ui-tabgroup >input.ui-tab3:checked ~ .ui-tabs >.ui-tab3:before, .ui-tabgroup >input.ui-tab4:checked ~ .ui-tabs >.ui-tab4:before, .ui-tabgroup >input.ui-tab5:checked ~ .ui-tabs >.ui-tab5:before, .ui-tabgroup >input.ui-tab6:checked ~ .ui-tabs >.ui-tab6:before, .ui-tabgroup >input.ui-tab7:checked ~ .ui-tabs >.ui-tab7:before, .ui-tabgroup >input.ui-tab8:checked ~ .ui-tabs >.ui-tab8:before, .ui-tabgroup >input.ui-tab9:checked ~ .ui-tabs >.ui-tab9:before{border-color:'.$setup42_itempagedetails_8_styles_elementcolor.'}';

		/*Footer Extra Styles*/
			$csstext .= '#pf-footer-row #wp-calendar tbody td:hover{background-color:'.pf_hex_color_mod($setup43_themecustomizerf_content_bgcolor,10).'}';
			$csstext .= '#pf-footer-row #wp-calendar tbody #today{background-color:'.pf_hex_color_mod($setup43_themecustomizerf_content_bgcolor,10).'}';
			$csstext .= '#pf-footer-row .widget_pfitem_recent_entries ul li,#pf-footer-row #jstwitter .tweet{border-bottom-color:'.$setup30_dashboard_styles_bodyborder.'!important}';	
	/* End: General Settings (Border etc...) */



	/* Start: Favorites Ribbon */
		$setup41_favsystem_bgcolor = PFSAIssetControl('setup41_favsystem_bgcolor','','#fff');
		$setup41_favsystem_linkcolor_hover = PFSAIssetControl('setup41_favsystem_linkcolor','hover','#B32E2E');
		$csstext .= '.pflist-imagecontainer .RibbonCTR .Triangle:after,.wpfimage-wrapper .RibbonCTR .Triangle:after{border-top: 40px solid '.$setup41_favsystem_bgcolor.';}';
		$csstext .= '.pflist-imagecontainer .RibbonCTR .Sign a[data-pf-active=true] i,.wpfimage-wrapper .RibbonCTR .Sign a[data-pf-active=true] i{color:'.$setup41_favsystem_linkcolor_hover.'}';
	/* End: Favorites Ribbon */




	/* Start: Menu Bar configuration */
		$setup18_headerbarsettings_padding = PFSAIssetControl('setup18_headerbarsettings_padding','margin-top','30');
		$setup18_headerbarsettings_padding_number = str_replace('px', '', $setup18_headerbarsettings_padding);
		
		$setup17_logosettings_sitelogo = PFSAIssetControl('setup17_logosettings_sitelogo','','');
		if (!is_array($setup17_logosettings_sitelogo)) {
			$setup17_logosettings_sitelogo = array('url'=>'','width'=>188,'height'=>30);
		} 
		$setup17_logosettings_sitelogo_height = (!empty($setup17_logosettings_sitelogo["height"]))?$setup17_logosettings_sitelogo["height"]:30;
		$setup17_logosettings_sitelogo_height_number = str_replace('px', '', $setup17_logosettings_sitelogo_height);
		$setup17_logosettings_sitelogo_width = (!empty($setup17_logosettings_sitelogo["width"]))?$setup17_logosettings_sitelogo["width"]:188;
		$setup17_logosettings_sitelogo_width_number = str_replace('px', '', $setup17_logosettings_sitelogo_width);

		$setup17_logosettings_sitelogo2x = PFSAIssetControl('setup17_logosettings_sitelogo2x','','');
		if (!is_array($setup17_logosettings_sitelogo2x)) {
			$setup17_logosettings_sitelogo2x = array('url'=>'','width'=>188,'height'=>30);
		}
		$setup17_logosettings_sitelogo2x_height = (!empty($setup17_logosettings_sitelogo2x["height"]))?$setup17_logosettings_sitelogo2x["height"]:30;
		$setup17_logosettings_sitelogo2x_height_number = str_replace('px', '', $setup17_logosettings_sitelogo2x_height);
		$setup17_logosettings_sitelogo2x_width = (!empty($setup17_logosettings_sitelogo2x["width"]))?$setup17_logosettings_sitelogo2x["width"]:188;
		$setup17_logosettings_sitelogo2x_width_number = str_replace('px', '', $setup17_logosettings_sitelogo2x_width);


		/*
		* New variables
		* $pointfinder_navwrapper_height = Logo & Margin heights calculated.
		* $pfpadding_half = Half of the padding height for scrolled menu.
		* $pointfinder_navwrapper_height_shrink = Half of the navwrapper height for scrolled. (For mobile and scrolled menu)
		*/
		$pointfinder_navwrapper_height = ($setup18_headerbarsettings_padding_number*2) + $setup17_logosettings_sitelogo_height_number;
		$pfpadding_half = $setup18_headerbarsettings_padding_number / 2;
		$pointfinder_navwrapper_height_shrink = ($pfpadding_half * 2) + ($setup17_logosettings_sitelogo_height_number/2);
		$as_topline_status = PFASSIssetControl('as_topline_status','','1');
		if ($as_topline_status == 1) {
			$topmenubarsize = 30;
			$btoplinefix = 60;
			$btoplinefix_shrink = 29;
		}else {
			$topmenubarsize = 0;
			$btoplinefix = 29;
			$btoplinefix_shrink = 29;
		}
		

		
		/*Navigation Wrapper Setting*/
		$csstext .= '@media (max-width: 568px) {.wpf-header .wpf-navwrapper{height:'.$pointfinder_navwrapper_height_shrink.'px;}}';



		/*Main Menu Settings - #pf-primary-nav li.current_page_item > a, */
			$csstext .= '#pf-primary-nav .pfnavmenu li.selected > .pfnavsub-menu{ border-top:2px solid '.$setup18_headerbarsettings_menulinecolor.';}';
			$csstext .= '#pf-primary-nav .pfnavmenu li > a:hover{ border-bottom:2px solid '.$setup18_headerbarsettings_menulinecolor.';}';
			$csstext .= '.wpf-header .pf-menu-container{margin-top:0;}';
			$csstext .= '.wpf-header.pfshrink .pf-menu-container{margin:0;}';

			$csstext .= '.wpf-header.pfshrink #pf-primary-nav .pfnavmenu .main-menu-item > a{height:'.$pointfinder_navwrapper_height_shrink.'px;line-height:'.$pointfinder_navwrapper_height_shrink.'px;}';
			$csstext .= '.wpf-header #pf-primary-nav .pfnavmenu .main-menu-item > a{height:'.$pointfinder_navwrapper_height.'px;line-height:'.$pointfinder_navwrapper_height.'px;}';


		/*Logo Settings*/
			$csstext .= '.wpf-header .pf-logo-container{margin:'.$setup18_headerbarsettings_padding_number.'px 0;height: '.$setup17_logosettings_sitelogo_height_number.'px;}';
			$csstext .= '.pf-logo-container{background-image:url('.$setup17_logosettings_sitelogo["url"].');background-size:'.$setup17_logosettings_sitelogo_width_number.'px '.$setup17_logosettings_sitelogo_height_number.'px;width: '.$setup17_logosettings_sitelogo_width_number.'px;}';

			$csstext .= '.wpf-header.pfshrink .pf-logo-container{height: '.($setup17_logosettings_sitelogo_height_number/2).'px;margin:'.$pfpadding_half.'px 0;}';
			$csstext .= '.wpf-header.pfshrink .pf-logo-container{background-size:'.($setup17_logosettings_sitelogo_width_number/2).'px '.($setup17_logosettings_sitelogo_height_number/2).'px;width: '.($setup17_logosettings_sitelogo_width_number/2).'px;}';

			$csstext .= '@media (max-width: 568px) {.wpf-header .pf-logo-container{height: '.($setup17_logosettings_sitelogo_height_number/2).'px;margin:'.$pfpadding_half.'px 0;}.wpf-header .pf-logo-container{background-size:'.($setup17_logosettings_sitelogo_width_number/2).'px '.($setup17_logosettings_sitelogo_height_number/2).'px;width: '.($setup17_logosettings_sitelogo_width_number/2).'px;}}';



		/* Retina Logo Settings */
			if(is_array($setup17_logosettings_sitelogo2x)){
				if(count($setup17_logosettings_sitelogo2x)>0){
					$csstext .= '@media only screen and (-webkit-min-device-pixel-ratio: 1.5),(min-resolution: 144dpi){ .pf-logo-container{background-image:url('.$setup17_logosettings_sitelogo2x["url"].');background-size:'.($setup17_logosettings_sitelogo2x_width_number/2).'px '.($setup17_logosettings_sitelogo2x_height_number/2).'px;width: '.($setup17_logosettings_sitelogo2x_width_number/2).'px;}}';
				}
			}



		/*Mobile Menu Settings*/
		$csstext .= '#pf-topprimary-navmobi,#pf-topprimary-navmobi2{border:1px solid '.$setup18_headerbarsettings_bordersettings.';}';
		$csstext .= '#pf-topprimary-navmobi .pf-nav-dropdownmobi li,#pf-topprimary-navmobi2 .pf-nav-dropdownmobi li{border-bottom:1px solid '.$setup18_headerbarsettings_bordersettings.';}';
		$csstext .= '#pf-primary-nav-button,#pf-topprimary-nav-button2,#pf-topprimary-nav-button,#pf-primary-search-button{border-color: '.$setup18_headerbarsettings_menucolor.';}';
		$csstext .= '@media (max-width: 992px) {#pf-topprimary-nav-button,#pf-topprimary-nav-button2,#pf-primary-nav-button,#pf-primary-search-button{top: '.$setup18_headerbarsettings_padding_number.'px;z-index:3}}';
		$csstext .= '@media (max-width: 568px) {#pf-topprimary-nav-button,#pf-topprimary-nav-button2,#pf-primary-nav-button,#pf-primary-search-button{top:'.(round($pfpadding_half/2)).'px;z-index:3}}';


		/*Body Container*/
		$csstext .= '.wpf-container,#pfuaprofileform div.mce-fullscreen{margin:'.($pointfinder_navwrapper_height + $topmenubarsize ).'px 0 0 0;}';
		$csstext .= '@media (max-width:1199px){#pfpostitemlink{top:'.(($pointfinder_navwrapper_height + $topmenubarsize)-$btoplinefix ).'px}.wpf-header.pfshrink #pfpostitemlink{top:'.(($pointfinder_navwrapper_height_shrink)-$btoplinefix_shrink ).'px}}';

		/*Box shadow color change for different bg*/
		if (PointFindergetContrast($setup18_headerbarsettings_menucolor2_bg3) == 'white') {
			$csstext .= '.pfnavmenu .pfnavsub-menu{box-shadow: 0 0 80px rgba(255, 255, 255, 0.04)!important;}';
		}

	/* End: Menu Bar configuration */


	$csstext .= '.postanitem-inner{border-color:'.$general_postitembutton_bordercolor.';}';
	$csstext .= '#pfpostitemlink a {height: '.$general_postitembutton_button_height.'px!important;line-height: '.($general_postitembutton_button_height-1).'px!important;margin-top: '.$general_postitembutton_button_mtop.'px!important;}';
	$csstext .= '@media (min-width: 1199px){.wpf-header.pfshrink #pf-primary-nav .pfnavmenu #pfpostitemlink > a{margin-top: '.$general_postitembutton_button_mtop2.'px!important;}}';

	$csstext .= '#pfuaprofileform .pfhtitle,.pf-listing-item-inner-addinfo{background-color:'.pf_hex_color_mod($tcustomizer_typographyh_main_bg,-5).'}';

	$csstext .= "#pfitemdetail-slider-sub li img{height:".$setupsizelimitconf_general_gallerysize2_h."px;}";

	/* Custom CSS */
	if (!empty($pointfindertheme_option['pf_general_csscode'])) {
		$csstext .= $pointfindertheme_option['pf_general_csscode'];
	}



	if (!empty($setup17_logosettings_sitelogo["url"])) {
		/*Create file if not exist and changed.*/
		global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		if( ! function_exists( 'WP_Filesystem' ) ) {
		    return false;
		}


		if ( defined( 'FS_CHMOD_FILE' ) ) {
		    $chmod_file = FS_CHMOD_FILE;
		} else {
		    $chmod_file = 0644;
		}

		if ( defined( 'FS_CHMOD_DIR' ) ) {
		    $chmod_dir = FS_CHMOD_DIR;
		} else {
		    $chmod_dir = 0755;
		}

		$uploads = wp_upload_dir();
		$upload_dir = trailingslashit($uploads['basedir']);
		if (substr($upload_dir, -1) != '/' ) {$upload_dir = $upload_dir . '/pfstyles';}else{$upload_dir = $upload_dir . 'pfstyles';}

		if ( ! $wp_filesystem->is_dir( $upload_dir ) ) {
			if ( ! $wp_filesystem->mkdir( $upload_dir, $chmod_dir ) ) {
				add_action('admin_notices', 'pointfinder_css_system_status2');
				function pointfinder_css_system_status2() {
					global $wp_filesystem;
					echo '<div class="error"><p>'; 
		        	echo '<h3>'.esc_html__('Point Finder: CSS Folder System Error','pointfindert2d').'</h3>';
					echo 'Error Code: '.$wp_filesystem->errors->get_error_code();
					echo '<br/>Error Message: '.esc_html__( 'Folder can not create.', 'pointfindert2d' );
					echo '<br/>Error Detail: '.$wp_filesystem->errors->get_error_message();
					echo "</p></div>";
				}
			}
		}

			

		if (substr($upload_dir , -1) != '/' ) {
			$filename = $upload_dir . '/pf-style-frontend' . '.css';
		}else{
			$filename = $upload_dir . 'pf-style-frontend' . '.css';
		}


		if ( ! $wp_filesystem->put_contents($filename, $csstext, $chmod_file) ) {
			if ( is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
				add_action('admin_notices', 'pointfinder_css_system_status');
				function pointfinder_css_system_status() {
					global $wp_filesystem;
					echo '<div class="error"><p>'; 
		        	echo '<h3>'.esc_html__('Point Finder: CSS File System Error','pointfindert2d').'</h3>';
					echo 'Error Code: '.$wp_filesystem->errors->get_error_code();
					echo '<br/>Error Message: '.esc_html__( 'Something went wrong: dynamic_css.css could not be created.', 'pointfindert2d' );
					echo '<br/>Error Detail: '.$wp_filesystem->errors->get_error_message();
					echo "</p></div>";
				}
			} elseif ( ! $wp_filesystem->connect() ) {
				add_action('admin_notices', 'pointfinder_css_system_status');
				function pointfinder_css_system_status() {
					global $wp_filesystem;
					echo '<div class="error"><p>'; 
		        	echo '<h3>'.esc_html__('Point Finder: CSS File System Error','pointfindert2d').'</h3>';
					echo 'Error Code: '.$wp_filesystem->errors->get_error_code();
					echo '<br/>Error Message: '.esc_html__( 'dynamic_css.css could not be created. Connection error.', 'pointfindert2d' );
					echo "</p></div>";
				}
			} elseif ( ! $wp_filesystem->is_writable($filename) ) {
				add_action('admin_notices', 'pointfinder_css_system_status');
				function pointfinder_css_system_status() {
					global $wp_filesystem;

					$uploads = wp_upload_dir();
					$upload_dir = trailingslashit($uploads['basedir']);
					if (substr($upload_dir , -1) != '/' ) {
						$filename = $upload_dir . '/pfstyles/pf-style-frontend' . '.css';
					}else{
						$filename = $upload_dir . 'pfstyles/pf-style-frontend' . '.css';
					}

					echo '<div class="error"><p>'; 
		        	echo '<h3>'.esc_html__('Point Finder: CSS File System Error','pointfindert2d').'</h3>';
					echo 'Error Code: '.$wp_filesystem->errors->get_error_code();
					echo '<br/>Error Message: '.sprintf(esc_html__( 'dynamic_css.css could not be created. Cannot write dynamic_css css to %s', 'pointfindert2d' ),$filename);
					echo "</p></div>";
				}
			} else {
				add_action('admin_notices', 'pointfinder_css_system_status');
				function pointfinder_css_system_status() {
					global $wp_filesystem;
					echo '<div class="error"><p>'; 
		        	echo '<h3>'.esc_html__('Point Finder: CSS File System Error','pointfindert2d').'</h3>';
					echo 'Error Code: '.$wp_filesystem->errors->get_error_code();
					echo '<br/>Error Message: '.esc_html__( 'dynamic_css.css could not be created. Problem with access.', 'pointfindert2d' );
					echo "</p></div>";
				}
			}

		}
	}