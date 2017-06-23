(function($) {
	"use strict";

	// CORE FUNCTIONS STARTED --------------------------------------------------------------------------------------------
	if ($('.pfcontrol-locate img').length) {$('.pfcontrol-locate img').svgInject();};
	if ($('.pf-search-locatemebut').length) {$('.pf-search-locatemebut').svgInject();};
	$.pfclearallmarkers = function(){ $('#wpf-map').gmap3({clear:"marker"});}
	$.pfclearcircle = function(){$('#wpf-map').gmap3({clear: {id: 'geoloccircle'}});}
	$.pfclearoverlay = function(){$('#wpf-map').gmap3({clear:{id: 'infowindowoverlay'}});};
	
	$.pfaftersearch = function(){$("#wpf-map").gmap3("autofit");};
	$.pfremovebyresults = function(){        	
		if($('.pfsearchgridview').length>0){
			$('.pfsearchgridview').remove();
		};
		$('.pfsearchgridview').hide('fade',{ direction: "up" },300)
		
		$.pfscrolltotop();
	};

	$.pftogglewnotification = function(message,timeout){
			$.pftogglestatus = true;
			setTimeout(function(){
				if($.pftogglestatus == true){
					$.pftogglewnotificationclear();
				}
			},timeout);
			$('#pfnot-err-button-menu').hide({ effect: "fade",direction: "up" },0);
			$('#pfnot-err-button').show({ effect: "fade",direction: "up" },0);
			$('.pfnotificationwindow .pfnottext').html(message);
			$( ".pfnotificationwindow" ).show({ effect: "fade",direction: "up" },0);
		
	};
	$.pftogglewnotificationclear = function(){
			if($('.pfnotificationwindow').is(':visible')){
				$('.pfnotificationwindow').hide({ effect: "fade",direction: "up" },0);
				$('#pfnot-err-button').hide();
				$('#pfnot-err-button-menu').show({ effect: "fade",direction: "up" },1000,function(){
					if($.pf_tablet_check()){$(this).addClass('animated flash')};
				});
				$.pftogglestatus = false;
			}else{
				$('.pfnotificationwindow').show({ effect: "fade",direction: "up" },0);
				$('#pfnot-err-button').show({ effect: "fade",direction: "up" },0);
				$('#pfnot-err-button-menu').hide({ effect: "fade",direction: "up" },0);
				$.pftogglestatus = true;
			}
		
	};

	

	// CORE FUNCTIONS FINISHED --------------------------------------------------------------------------------------------

	
	// INFO WINDOW LOAD STARTED --------------------------------------------------------------------------------------------
	    $.pfloadinfowindow = function(marker,event,dataid){
	        var map = $.pfgmap3static.pfmapobj;
	        var pos = marker.getPosition();
			
				if($.pf_mobile_check()){
					$.pfmap_recenter(map,marker.getPosition(),0,0);
					var mypi = -175;
				}else{
					$.pfmap_recenter(map,marker.getPosition(),0,0);
					var mypi = -92;
				}

				$.pfclearoverlay();
				
				var cof_marker_height_s = marker.getHeight();

		        $('#wpf-map').gmap3(
		            {overlay:{
						id:'infowindowoverlay',
		                latLng: marker.getPosition(),
		                options:{
		                    content: "<div class='wpfinfowindow'><div class='pfinfoloading pfloadingimg'></div></div><div class='wpfarrow'></div>",
		                    offset: {
		                    	x:((mypi) - $.pfgmap3static.widthbetweenitems),
		                    	y:((-144 - cof_marker_height_s) - $.pfgmap3static.heightbetweenitems)},
		                }
		            }
		            
		        });


	        $.ajax({
	            type: 'POST',
	            dataType: 'html',
	            url: theme_map_functionspf.ajaxurl,
	            data: { 
	                'action': 'pfget_infowindow',
	                'id': dataid,
	                'cl': $.pfgmap3static.currentlang,
	                'single':$.pfgmap3static.pfmapsingle,
	                'security': theme_map_functionspf.pfget_infowindow
	            },
	            success:function(data){
					$('.pfinfoloading').fadeOut('fast');
					$('.wpfinfowindow').append(data);
					$('.pfButtons a').click(function() {
						if($(this).attr('data-pf-link')){
							$.prettyPhoto.open($(this).attr('data-pf-link'));
						}
					});
					
					//Close overlay trigger.
					$('.wpf-closeicon').hover(function(){
						$(this).find('i').switchClass('pfadmicon-glyph-65','pfadmicon-glyph-64');
					},function(){
						$(this).find('i').switchClass('pfadmicon-glyph-64','pfadmicon-glyph-65');
					});
					$('.wpf-closeicon').click(function(){ $.pfclearoverlay();});
					//Fix for touch drag map on multiple window.
					$('#pf_infowindow_owl').live({
						touchstart: function(event) { $.pfgmap3static.pfmapobj.setOptions({draggable: false});},
						touchend: function(event) { $.pfgmap3static.pfmapobj.setOptions({draggable: true});}
					});
					
					//Carousel for multiple view.
					var pfmultipleowl = $("#pf_infowindow_owl");
					$.pfmultipleowlsetdefaults(pfmultipleowl);
					//Prev Next buttons for multiple preview.
					$(".pfifnext").click(function(){pfmultipleowl.trigger('owl.next');})
					$(".pfifprev").click(function(){pfmultipleowl.trigger('owl.prev');})
					//Mouseoverbutton action for multiple preview.
					if($.pfgmap3static.hidemultiplenav != true){
						$('.pfifbutton').hide('fade',400);
						$('.wpfinfowindow').mouseenter(function(){$('.pfifbutton').show('fade',300)}).mouseleave(function(){$('.pfifbutton').hide('fade',300)});
					}

					/**/

					$('.pf-favorites-link').click(function(){
						$.maindivfav = $(this);
						$.ajax({
				            type: 'POST',
				            dataType: 'json',
				            url: theme_scriptspf.ajaxurl,
				            data: { 
				                'action': 'pfget_favorites',
				                'item': $.maindivfav.attr('data-pf-num'),
				                'active':$.maindivfav.attr('data-pf-active'),
				                'security': theme_scriptspf.pfget_favorites
				            },
				            success:function(data){
								var obj = [];
								$.each(data, function(index, element) {
									obj[index] = element;
								});

								if (!$.isEmptyObject(obj)) {

									if (obj.user == 0) {
										$.pfOpenLogin('open','login');
									}else{
										if (obj.active == 'true') {
											var datatextfv = 'true';
										}else{
											var datatextfv = 'false';
										};
										$.maindivfav.attr('data-pf-active',datatextfv);
										$.maindivfav.attr('title',obj.favtext);		
										if ($.maindivfav.data('pf-item') == true) {
											
											if (obj.active == 'true') {
												$.maindivfav.children('i').switchClass('pfadmicon-glyph-376','pfadmicon-glyph-375');
											}else{
												$.maindivfav.children('i').switchClass('pfadmicon-glyph-375','pfadmicon-glyph-376');
											}

											$.maindivfav.children('#itempage-pffav-text').html(obj.favtext);
										};				
									};
								};

				            },
				            
				        });
					});

					/**/
	            },
	            error: function (request, status, error) {
	                $('.wpfinfowindow').html('Error:'+request.responseText);
					
	            },
	            complete: function(){$('.pfinfoloading').fadeOut('slow');},
	        });
	    }
    // INFO WINDOW LOAD FINISHED --------------------------------------------------------------------------------------------


    // LOAD MARKER STARTED --------------------------------------------------------------------------------------------
		$.pfloadmarker_itempage = function(singlepoint){
			$.ajax({
			  type: 'POST',
			  dataType: 'script',
			  url: theme_map_functionspf.ajaxurl,
			  cache:false,
			  data: { 'action': 'pfget_markers','singlepoint': singlepoint,'security': theme_map_functionspf.pfget_markers,'cl':theme_map_functionspf.pfcurlang},
			  success:function(data){

				$('#pf-itempage-header-map').gmap3({
				  marker: {
					values: wpflistdata, 
					callback: function(){
							var map = $('#pf-itempage-header-map').gmap3('get');
							var marker = $("#pf-itempage-header-map").gmap3({get:"marker"});
							$.pfmap_recenter(map,marker.getPosition(),0,0);
					}

				  },

				  
				});

			  },
			});
			
		};
	// LOAD MARKER FINISHED --------------------------------------------------------------------------------------------


	// LOAD MARKER FOR PAGE HEADER STARTED --------------------------------------------------------------------------------------------
		$.pfloadmarker_itempage_top = function(singlepoint,wbi,hbi,curlang){
			$.ajax({
			  type: 'POST',
			  dataType: 'script',
			  url: theme_map_functionspf.ajaxurl,
			  cache:false,
			  data: { 'action': 'pfget_markers','singlepoint': singlepoint,'security': theme_map_functionspf.pfget_markers,'cl':theme_map_functionspf.pfcurlang},
			  success:function(data){

				$('#item-map-page').gmap3({
				  marker: {
					values: wpflistdata, 
					events:{
					  click: function(marker, event, context){
					  		if($.pf_mobile_check()){
						  		var map = $('#item-map-page').gmap3('get');
								$.pfloadinfowindow_top(marker, '', context.data.id,map,wbi,hbi,curlang);
							}
					  },
					},
					callback: function(){

						var map = $('#item-map-page').gmap3('get');
						var marker = $("#item-map-page").gmap3({get:"marker"});
						$.pfmap_recenter(map,marker.getPosition(),0,0);

						if($.pf_mobile_check()){
							setTimeout(function(){$.pfloadinfowindow_top(marker, '', singlepoint,map,wbi,hbi,curlang);},1000);
						}
							
					}

				  },

				  
				});

			  },
			});
			
		};
	// LOAD MARKER FOR PAGE HEADER FINISHED --------------------------------------------------------------------------------------------


	// INFO WINDOW FOR PAGE HEADER LOAD STARTED --------------------------------------------------------------------------------------------
	    $.pfloadinfowindow_top = function(marker,event,dataid,map,widthbetweenitems,heightbetweenitems,currentlang){
		
			var pos = marker.getPosition();
			if($.pf_mobile_check()){
				$.pfmap_recenter(map,marker.getPosition(),0,-70);
			}else{
				$.pfmap_recenter(map,marker.getPosition(),0,-70);
			}
			$.pfclearoverlay_topmap = function(){
				$('#item-map-page').gmap3(
					{clear:
						{id: 'infowindowoverlay'}
					})
			};
			$.pfclearoverlay_topmap();

			var cof_marker_height_s = marker.getHeight();

	        $('#item-map-page').gmap3(
	            {overlay:{
					id:'infowindowoverlay',
	                latLng: marker.getPosition(),

	                options:{
	                    content: "<div class='wpfinfowindow'><div class='pfinfoloading pfloadingimg'></div></div><div class='wpfarrow'></div>",
	                    offset: {
	                    	x:((-183 + 7) - widthbetweenitems),
	                    	y:((-144 - cof_marker_height_s) - heightbetweenitems)},
	                }
	            }
	            
	        });



	        $.ajax({
	            type: 'POST',
	            dataType: 'html',
	            url: theme_map_functionspf.ajaxurl,
	            data: { 
	                'action': 'pfget_infowindow',
	                'id': dataid,
	                'cl': currentlang,
	                'single': '0',
	                'disable': 1,
	                'security': theme_map_functionspf.pfget_infowindow
	            },
	            success:function(data){
					$('.pfinfoloading').fadeOut('fast');
					$('.wpfinfowindow').append(data);
					$('.pfButtons a').click(function() {
						if($(this).attr('data-pf-link')){
							$.prettyPhoto.open($(this).attr('data-pf-link'));
						}
					});
					
					//Close overlay trigger.
					$('.wpf-closeicon').hover(function(){
						$(this).find('i').switchClass('pfadmicon-glyph-65','pfadmicon-glyph-64');
					},function(){
						$(this).find('i').switchClass('pfadmicon-glyph-64','pfadmicon-glyph-65');
					});
					$('.wpf-closeicon').on('click',function(){ $.pfclearoverlay_topmap();});
					
					var mymap = $('#item-map-page').gmap3('get');
					//Fix for touch drag map on multiple window.
					$('#pf_infowindow_owl').live({
						touchstart: function(event) { mymap.setOptions({draggable: false});},
						touchend: function(event) { mymap.setOptions({draggable: true});}
					});
					$.pfmultipleowlsetdefaults = function(owl){
					
						owl.owlCarousel({
							navigation : false,
							singleItem : true,
							autoPlay:true,
							slideSpeed:5000,
							mouseDrag:false,
							touchDrag:true,
							transitionStyle : "fade",
							autoHeight : false,
						});
					
					};
					//Carousel for multiple view.
					var pfmultipleowl = $("#pf_infowindow_owl");
					$.pfmultipleowlsetdefaults(pfmultipleowl);
					//Prev Next buttons for multiple preview.
					$(".pfifnext").click(function(){pfmultipleowl.trigger('owl.next');})
					$(".pfifprev").click(function(){pfmultipleowl.trigger('owl.prev');})
					//Mouseoverbutton action for multiple preview.
					$('.pfifbutton').hide('fade',400);
					$('.wpfinfowindow').mouseenter(function(){$('.pfifbutton').show('fade',300)}).mouseleave(function(){$('.pfifbutton').hide('fade',300)});

					$('.pf-favorites-link').click(function(){
						$.maindivfav = $(this);
						$.ajax({
				            type: 'POST',
				            dataType: 'json',
				            url: theme_scriptspf.ajaxurl,
				            data: { 
				                'action': 'pfget_favorites',
				                'item': $.maindivfav.attr('data-pf-num'),
				                'active':$.maindivfav.attr('data-pf-active'),
				                'security': theme_scriptspf.pfget_favorites
				            },
				            success:function(data){
								var obj = [];
								$.each(data, function(index, element) {
									obj[index] = element;
								});

								if (!$.isEmptyObject(obj)) {

									if (obj.user == 0) {
										$.pfOpenLogin('open','login');
									}else{
										if (obj.active == 'true') {
											var datatextfv = 'true';
										}else{
											var datatextfv = 'false';
										};
										$.maindivfav.attr('data-pf-active',datatextfv);
										$.maindivfav.attr('title',obj.favtext);		
										if ($.maindivfav.data('pf-item') == true) {
											
											if (obj.active == 'true') {
												$.maindivfav.children('i').switchClass('pfadmicon-glyph-376','pfadmicon-glyph-375');
											}else{
												$.maindivfav.children('i').switchClass('pfadmicon-glyph-375','pfadmicon-glyph-376');
											}

											$.maindivfav.children('#itempage-pffav-text').html(obj.favtext);
										};				
									};
								};

				            },
				            
				        });
					});

					/**/
	            },
	            error: function (request, status, error) {
	                $('.wpfinfowindow').html('Error:'+request.responseText);
					
	            },
	            complete: function(){$('.pfinfoloading').fadeOut('slow');},
	        });
				
	    }
    // INFO WINDOW FOR PAGE HEADER LOAD FINISHED --------------------------------------------------------------------------------------------
		
	
	// LIST SEARCH DATA TO PAGE FUNCTION STARTED --------------------------------------------------------------------------------------------
		$.fn.pfgetpagelistdata = function( options ) {
	        var settings = $.extend({
	            saction : '',
	            sdata : '',
	            dtx : '',
	            show : 1,
	            ne : '',
	            sw : '',
	            ne2 : '',
	            sw2 : '',
	            grid : '',
	            cl:$.pfgmap3static.currentlang,
	            pfg_orderby : '',
	            pfg_order : '',
	            pfg_number : '',
	            page : '',
	            pfcontainerdiv : '.pfsearchresults',
	            pfcontainershow : '.pfsearchgridview'
	        }, options );
	 

			var pfscrolltoresults = function(){
				$.smoothScroll({
					scrollTarget: '.pfsearchgridview',
					offset: -60
				});
			};

			var pfgridloadingtoggle = function(status){
				if(status == 'hide'){
					if($('.pfsearchgridview .pfsearchresults-loading').length>0){
						$('.pfsearchgridview').remove();
						$('.pfsearchgridview').hide('fade',{ direction: "up" },300)
					};
				}else{
					$('.pfsearchresults-container').append('<div class= "pfsearchresults pfsearchgridview"><div class="pfsearchresults-loading"><div class="pfsresloading pfloadingimg"></div></div></div>');
					$('.pfsearchgridview').show('fade',{ direction: "up" },300)
					pfscrolltoresults();
				}
			}

			var pfscrolltotop = function(){$.smoothScroll();};

			if($('.pfsearchgridview').length <= 0){
				
				$.ajax({
					beforeSend:function(){pfgridloadingtoggle('show');},
					type: 'POST',
					cache:false,
					dataType: 'html',
					url: theme_map_functionspf.ajaxurl,
					data: { 
						'action': 'pfget_listitems',
						'act': settings.saction,
						'dt': settings.sdata,
						'dtx': settings.dtx,
						'ne': settings.ne,
						'sw': settings.sw,
						'ne2': settings.ne2,
						'sw2': settings.sw2,
						'cl': settings.cl,
						'grid': settings.grid,
						'pfg_orderby': settings.pfg_orderby,
						'pfg_order': settings.pfg_order,
						'pfg_number': settings.pfg_number,
						'pfcontainerdiv': '.pfsearchresults',
						'pfcontainershow': '.pfsearchgridview',
						'page': settings.page,
						'security': theme_map_functionspf.pfget_listitems
					},
					success:function(data){
						pfgridloadingtoggle('hide')
						//DEFAULT VARS STARTED ---------------------------
						if($.isEmptyObject($.pfsortformvars)){
							$.pfsortformvars = {};
						};
						
						if(settings.page == '' || settings.page == null || settings.page <= 0){$.pfsortformvars.page = 1;}
						if(!$.isEmptyObject($.pfsearchformvars)){
							$.pfsortformvars.saction = $.pfsearchformvars.action;
							$.pfsortformvars.sdata = $.pfsearchformvars.vars;
						}else{
							$.pfsortformvars.saction = '';
							$.pfsortformvars.sdata = '';
						};
						
						
						//DEFAULT VARS FINISHED ---------------------------
						
				
						//SHOW SEARCH RESULTS STARTED ---------------------------
						$('.pfsearchresults-container').append(data);
						if(settings.show){
							$('.pfsearchgridview').show('fade',{ direction: "up" },300)
							pfscrolltoresults();
						}
						//SHOW SEARCH RESULTS FINISHED ---------------------------
						
						
						//HIDE SEARCH RESULTS STARTED ---------------------------
						$('.pfsearchresults-filters .pfgridlist6').click(function(){
							$.pfremovebyresults();
						});
						//HIDE SEARCH RESULTS FINISHED ---------------------------

						
						//MASONRY OR FITROWS
						var layout_modes = {fitrows: "fitRows",masonry: "masonry"};
						var pfajaxlistdmip = function(){
							$('.pfsearchresults-content').each(function(){
					            var $container = $(this);
					            var $thumbs = $container.find(".pfitemlists-content-elements");
					            var layout_mode = $thumbs.attr("data-layout-mode");
					            $thumbs.isotope({
					                itemSelector : ".isotope-item",
					                layoutMode : (layout_modes[layout_mode]==undefined ? "fitRows" : layout_modes[layout_mode])
					            });
					           
					        });
						};


						setTimeout(function() {pfajaxlistdmip();}, 300);
						setTimeout(function() {pfajaxlistdmip();}, 500);
						setTimeout(function() {pfajaxlistdmip();}, 700);
						setTimeout(function() {pfajaxlistdmip();}, 1500);
						setTimeout(function() {pfajaxlistdmip();}, 2000);
						setTimeout(function() {pfajaxlistdmip();}, 2500);
						setTimeout(function() {pfajaxlistdmip();}, 3500);
						//MASONRY OR FITROWS

						
						//PAGINATION CLICK STARTED ---------------------------
						$('.pfajax_paginate a').click(function(){
							if($(this).hasClass('prev')){
								$.pfsortformvars.page--;
							}else if($(this).hasClass('next')){
								$.pfsortformvars.page++;
							}else{
								$.pfsortformvars.page = $(this).text();
							}
							

							$.pfsortformvars.pfg_orderby = $('.pfsearchgridview').find('.pfsearch-filter').val();
							$.pfsortformvars.pfg_order = $('.pfsearchgridview').find('.pfsearch-filter-order').val();
							$.pfsortformvars.pfg_number = $('.pfsearchgridview').find('.pfsearch-filter-number').val();


							if($.isEmptyObject($.pfsortformvars.pfg_grid)){$.pfsortformvars.pfg_grid = '';}
							
							if(!$.isEmptyObject($.pfsortformvars)){

								$.pfremovebyresults();

								$.fn.pfgetpagelistdata({
									saction : $.pfsortformvars.saction,
									sdata : $.pfsortformvars.sdata,
									dtx : settings.dtx,
									ne : settings.ne,
									sw : settings.sw,
									ne2 : settings.ne2,
									sw2 : settings.sw2,
									grid : $.pfsortformvars.pfg_grid,
									pfg_orderby : $.pfsortformvars.pfg_orderby,
									pfg_order : $.pfsortformvars.pfg_order,
									pfg_number : $.pfsortformvars.pfg_number,
									page : $.pfsortformvars.page,
								});


							};
							
							return false;
						})
						//PAGINATION CLICK FINISHED ---------------------------
						
						//GRID & SEARCH LIST TYPE CHANGE STARTED ---------------------------
						$('.pfsearchresults-filters-right .pfgridlistit').click(function(){
								
							$.pfsortformvars.pfg_orderby = $('.pfsearchgridview').find('.pfsearch-filter').val();
							$.pfsortformvars.pfg_order = $('.pfsearchgridview').find('.pfsearch-filter-order').val();
							$.pfsortformvars.pfg_number = $('.pfsearchgridview').find('.pfsearch-filter-number').val();
							
							$.pfsortformvars.pfg_grid = $(this).attr('data-pf-grid');
							
							$.pfremovebyresults();
							
							$.fn.pfgetpagelistdata({
								saction : $.pfsortformvars.saction,
								sdata : $.pfsortformvars.sdata,
								dtx : settings.dtx,
								ne : settings.ne,
								sw : settings.sw,
								ne2 : settings.ne2,
								sw2 : settings.sw2,
								grid : $.pfsortformvars.pfg_grid,
								pfg_orderby : $.pfsortformvars.pfg_orderby,
								pfg_order : $.pfsortformvars.pfg_order,
								pfg_number : $.pfsortformvars.pfg_number,
								page : $.pfsortformvars.page,
							});

						});
						//GRID & SEARCH LIST TYPE CHANGE FINISHED ---------------------------
						
						
						// SEARCH SORT & FILTER & ORDER STARTED ---------------------------
						$('.pfsearchresults-filters-left > li > label > select').change(function(){
							
							$.pfsortformvars.pfg_orderby = $('.pfsearchgridview').find('.pfsearch-filter').val();
							$.pfsortformvars.pfg_order = $('.pfsearchgridview').find('.pfsearch-filter-order').val();
							$.pfsortformvars.pfg_number = $('.pfsearchgridview').find('.pfsearch-filter-number').val();
						
							if($.isEmptyObject($.pfsortformvars.pfg_grid)){$.pfsortformvars.pfg_grid = '';}
							
							$.pfremovebyresults();
							
							$.fn.pfgetpagelistdata({
								saction : $.pfsortformvars.saction,
								sdata : $.pfsortformvars.sdata,
								dtx : settings.dtx,
								ne : settings.ne,
								sw : settings.sw,
								ne2 : settings.ne2,
								sw2 : settings.sw2,
								grid : $.pfsortformvars.pfg_grid,
								pfg_orderby : $.pfsortformvars.pfg_orderby,
								pfg_order : $.pfsortformvars.pfg_order,
								pfg_number : $.pfsortformvars.pfg_number,
								page : $.pfsortformvars.page,
							});
						});
						// SEARCH SORT & FILTER & ORDER FINISHED -----------------------------
						
						//PRETTY PHOTO STARTED ---------------------------
						$('.pfButtons a').click(function() {
							if($(this).attr('data-pf-link')){
								$.prettyPhoto.open($(this).attr('data-pf-link'));
							}
						});
						//PRETTY PHOTO FINISHED ---------------------------
						
					},
					error: function (request, status, error) {
						pfgridloadingtoggle('hide')
						$('.pfsearchresults-container').append('<div class= "pfsearchresults"><div class="pfsearchresults-loading" style="text-align:center"><strong>An error occured!</strong></div></div>');
					},
					complete: function(){
						
					},
				});
			}else{
				$('.pfsearchgridview').show('fade',{ direction: "up" },300)
				pfscrolltoresults();
			}
	    };
	// LIST SEARCH DATA TO PAGE FUNCTION FINISHED --------------------------------------------------------------------------------------------
		
	
	
	// SEARCH FUNCTION STARTED --------------------------------------------------------------------------------------------
	$('#pf-search-button').click(function(){

		$.pfremovebyresults();
		var form = $('#pointfinder-search-form');
		form.validate();
		form.find("div:hidden[id$='_main']").each(function(){ 
			$(this).find('input[type=hidden]').val(""); 
			$(this).find('input[type=text]').val($.pfsliderdefaults.fields[$(this).attr('id')]);
			$(this).find('.slider-wrapper .ui-slider-range').css('width','0%');
			$(this).find('.slider-wrapper a:nth-child(2)').css('left','0%');
			$(this).find('.slider-wrapper a:nth-child(3)').css('left','100%');
		});
		$.pfsearchformvars = {};
		$.pfsearchformvars.action = 'search';
		$.pfsearchformvars.vars = form.serializeArray();
		
		if(form.valid()){
			if ($('#pfsearch-draggable').hasClass('pfsearch-draggable-full')) {
				$( "#pfsearch-draggable" ).toggle( "slide",{direction:"up",mode:"hide"},function(){
			  		$('.pfsopenclose').fadeToggle("fast");
			  		$('.pfsopenclose2').fadeToggle("fast");
			  	});
			};
			
			if ($('#wpf-map').css('z-index') == -1) {
				$('#wpf-map').css('z-index','1').css('position','');
				$('#pfcontrol').css('z-index','2').show();
				$('.pfnot-err-button').css('z-index','3');
				$('.pfnotificationwindow').css('z-index','2');
				$(".pfnot-err-button-menu").show();
				$('#wpf-map').show();
				$('#wpf-map').gmap3({trigger:"resize"});
				$("#wpf-map-container").css("min-height","");
				$('.pf-ex-search-text').remove();
				$('#wpf-map-container').closest('.pf-fullwidth').prev('.upb_video-wrapper').remove();/*Video bg remove*/
				$('#wpf-map-container').closest('.pf-fullwidth').prev('.upb_row_bg').remove();/*Image bg remove*/
			};

			$.pfremovebyresults();
			$.pfclearoverlay();
			$.pfclearallmarkers();
			if ($('#pointfinder_google_search_coord').length > 0) {
				$.pfgmap3static.geocircleBounds = null;
			}

			 if($.pfgmap3static.geocircleBounds != null){
			 	
				 var bounds = $.pfgmap3static.geocircleBounds;
				 var necoor = bounds.getNorthEast();
				 var swcoor = bounds.getSouthWest();
				 $.pfloadmarkers(necoor.lat(),swcoor.lat(),necoor.lng(),swcoor.lng(),$.pfsearchformvars.action,$.pfsearchformvars.vars);
			 }else{
			 

				 if ($('#pointfinder_google_search_coord').length > 0 && $('#pointfinder_google_search_coord').val().length !== 0) {
				 	
				 	$.pfremovebyresults();
				 	$.pfclearallmarkers();
				 	$.pfclearcircle();
				 	var mysplitp = $('#pointfinder_google_search_coord').val().split(',');
				 	var mylatlng = new google.maps.LatLng(parseFloat(mysplitp[0]),parseFloat(mysplitp[1]));
				 	
				 	var form_radius_val = $('#pointfinder_radius_search-view2').val();
				 	var form_radius_unit = $('#pointfinder_google_search_coord_unit').val();
				 	var form_radius_unit_name = 'mi';

				 	if (form_radius_unit != 'Mile') {
				 		form_radius_val = parseInt(form_radius_val);
				 		if (isNaN(form_radius_val)) {
				 			form_radius_val = theme_map_functionspf.defmapdist;
				 		}
				 		var form_radius_val_ex = (parseInt(form_radius_val)*1000);
				 		form_radius_unit_name='km';
				 	} else{
				 		form_radius_val = parseInt(form_radius_val);
				 		if (isNaN(form_radius_val)) {
				 			form_radius_val = theme_map_functionspf.defmapdist;
				 		}
				 		var form_radius_val_ex = ((parseInt(form_radius_val)*1000)*1.60934);
				 		form_radius_unit_name='mi';
				 	}
				 	

				 	$('#wpf-map').gmap3({
					  circle:{
						values:[{id:'geoloccircle'}],
						options:{
						  center: mylatlng,
						  editable: false,
						  draggable:false,
						  clickable:true,
						  radius : form_radius_val_ex,//,
						  fillColor : "#008BB2",
						  fillOpacity: "0.3",
						  strokeColor : "#005BB7",
						  strokeOpacity: "0.6",
						},
						
						callback: function(){

							$.pfgmap3static.geocircle = $(this).gmap3({get: {id: 'geoloccircle'}});
							$.pfgmap3static.pfmapobj.setCenter(mylatlng);
							
							$.pfGeolocationDefaults = {};
							$.pfGeolocationDefaults.icon1 = theme_map_functionspf.template_directory + '/images/geo.png';
							$.pfGeolocationDefaults.icon2 =	theme_map_functionspf.template_directory + '/images/geo2.png';
							$.pfGeolocationDefaults.latLng = mylatlng;
							$.pfGeolocationDefaults.distance = form_radius_val;
							$.pfGeolocationDefaults.hideinfo = true;
							$.pfGeolocationDefaults.unit = form_radius_unit_name;
							$.pfGeolocationDefaults.automove = true;
							var distanceWidget = new $.pfDistanceWidget($(this).gmap3('get'));
							var bounds = $.pfgmap3static.geocircle.getBounds();
							var necoor = bounds.getNorthEast();
							var swcoor = bounds.getSouthWest();
							$.pfloadmarkers(necoor.lat(),swcoor.lat(),necoor.lng(),swcoor.lng(),$.pfsearchformvars.action,$.pfsearchformvars.vars);
							 
						},
						
					  }
					  
					  
					});

				 } else{
				 	
				 	//function(ne,sw,ne2,sw2,saction,sdata)
				 	$.pfloadmarkers('','','','',$.pfsearchformvars.action,$.pfsearchformvars.vars);
				 };
			 }

			 if (!$.pf_mobile_check()) {
			 	if($('#pfsearch-draggable').hasClass('pfshowmobile') == true){
					$('#pf-primary-search-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-627', 'fast',"easeInOutQuad");
					$('#pfsearch-draggable').removeClass('pfshowmobile');
					$('#pfsearch-draggable').hide("fade",{ direction: "up" }, "fast", function(){});	
				}
			 };
			 

		};
		return false;
	});	
	// SEARCH FUNCTION FINISHED --------------------------------------------------------------------------------------------
	



	
	
	
	// MAP CONTROL FUNCTIONS STARTED --------------------------------------------------------------------------------------------
	$(function() {


		$('.pfcontrol-plus').click(function(){
			$.pfclearoverlay();
			var currentzoom = $.pfgmap3static.pfmapobj.getZoom();
			var newzoom = currentzoom + 1;
			$.pfgmap3static.pfmapobj.setZoom(newzoom);
		});

		
		$('.pfcontrol-minus').click(function(){
			$.pfclearoverlay();
			var currentzoom = $.pfgmap3static.pfmapobj.getZoom();
			var newzoom = currentzoom - 1;
			$.pfgmap3static.pfmapobj.setZoom(newzoom);
		});
		
		$('.pfcontrol-home').click(function(){
			$.pfsearchformvars = null;
			var position = new google.maps.LatLng($.pfgmap3static.center[0],$.pfgmap3static.center[1]);
			$.pfgmap3static.pfmapobj.panTo(position);
			$.pfgmap3static.pfmapobj.setZoom($.pfgmap3static.zoom);
			if($.pfgmap3static.geocircle){
				$.pfclearcircle();
				$.pfgmap3static.geocircle = null;
				$.pfgmap3static.geocircleBounds = null;
			};
			$.pfremovebyresults();
			$.pfloadmarkers();	
		});

		$('.pfcontrol-lock').click(function(){

			var icon = $(this).find('i');
			var map = $.pfgmap3static.pfmapobj;
			if (icon.hasClass('pfadmicon-glyph-151')) {
				icon.switchClass('pfadmicon-glyph-151','pfadmicon-glyph-152');
				map.draggable=true;
			}else{
				icon.switchClass('pfadmicon-glyph-152','pfadmicon-glyph-151');
				map.draggable=false;
			};
		});
		
		$('.pfcontrol-locate').click(function(){
			$(".pfmaploading").fadeIn("slow");
			$.pfremovebyresults();
			$.pfgeolocation();
		});
		
		$('.pfmaptype-control .pfmaptype-control-ul .pfmaptype-control-li').click(function(){
			$('.pfmaptype-control .pfmaptype-control-ul .pfmaptype-control-li').each(function() {
				$(this).attr('data-mapopt-status','passive');
			});
			$(this).attr('data-mapopt-status','active');
			var maptype = $(this).attr('data-mapopt-type');
			$.pfmapoptcontrol(maptype,'p1');
		});
		
		$('.pfmaptype-control .pfmaptype-control-layers-ul .pfmaptype-control-layers-li').click(function(){
			var maptype = $(this).attr('data-mapopt-type');
			if($(this).attr('data-mapopt-status') == 'active'){
				$(this).attr('data-mapopt-status','passive');
				$.pfmapoptcontrol(maptype,'p3');
			}else{
				$(this).attr('data-mapopt-status','active');
				$.pfmapoptcontrol(maptype,'p2');
			}
		});
	});

	$.pfmapoptcontrol = function(type, process){
		var map = $('#wpf-map').gmap3('get');
		if(process == 'p1'){
			if(type == 'hybrid'){
					map.setMapTypeId(google.maps.MapTypeId.HYBRID);
			}else if(type == 'satellite'){
					map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
			}else if(type == 'roadmap'){
					map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
			}else if(type == 'terrain'){
					map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
			}
		}else if(process == 'p2'){
			if(type == 'traffic'){
				$("#wpf-map").gmap3({trafficlayer:{}});
			}else if(type == 'bicycle'){
				$("#wpf-map").gmap3({bicyclinglayer:{}});
			}
		
		}else if(process == 'p3'){
			if(type == 'traffic'){
				$('#wpf-map').gmap3({clear: {name:["trafficlayer"],all: true}});
			}else if(type == 'bicycle'){
				$('#wpf-map').gmap3({clear: {name:["bicyclinglayer"],all: true}});
			}
		
		}
		
	}
	// MAP CONTROL FUNCTIONS FINISHED --------------------------------------------------------------------------------------------
	
	
	
	
	
	// DRAGGABLE SEARCH FORM FUNCTIONS STARTED --------------------------------------------------------------------------------------------
	$.fn.WPFST = function(element){
		this.ov = {direction:''};
		this.te = element;
		this.tc = '.pf'+$(this.te).attr('data-pf-content')+'-content';
		this.ti1 = $(this.te).attr('data-pf-icon1');
		this.ti2 = $(this.te).attr('data-pf-icon2');
		this.sp = 300;
		this.st = 'data-pf-toggle';
		

		this.PFSTCheck = function(element){
			var status;
			function strcmp(str1, str2) {
			  return ((str1 == str2) ? 0 : ((str1 > str2) ? 1 : -1));
			}
			
			
			$(".pftogglemenulist > li").each(function(e) {
				
				var te = $(this);
				var tc = '.pf'+$(te).attr('data-pf-content')+'-content';
				var ti1 = $(te).attr('data-pf-icon1');
				var ti2 = $(te).attr('data-pf-icon2');
				
				if($(te).attr('data-pf-toggle') == 'active'){
					
					if(strcmp(te[0]['className'],element) != 0){
						$(tc).css('display','none');
						if($(te).find('i').hasClass(ti1)){
							$(te).find('i').switchClass(ti1,ti2)
						}else{
							$(te).find('i').switchClass(ti2,ti1);
						};
						$(te).attr('data-pf-toggle', 'passive');
						status = 1;
					}
					
				}				
				
			});
			if(status == 1){this.PFSTRun(10)}else{this.PFSTRun(0)}
			
		};
			
		this.PFSTRun = function(t){
				$(this.tc).fadeToggle(this.sp+t);
				if($(this.te).attr(this.st) == 'active'){
					this.PFCheck();
					$(this.te).attr(this.st, 'passive');
				}else{
					this.PFCheck();
					$(this.te).attr(this.st, 'active');
				}
			
	
		};
		
		this.PFCheck = function(){
			if($(this.te).find('i').hasClass(this.ti1)){
				$(this.te).find('i').switchClass(this.ti1,this.ti2)
			}else{
				$(this.te).find('i').switchClass(this.ti2,this.ti1);
			};
		};
		
		this.PFSTCheck(this.te.replace('.',''));
	};

	$(function() {
		//Draggable search
		$( "#pfsearch-draggable" ).draggable({ 
			containment: "#wpf-map-container", 
			scroll: false, 
			handle: ".pftoggle-move",
			drag: function( event, ui ) {
				$( ".pfsearch-header ul li" ).tooltip( "close" );
			}
		});

		$( "#pfsearch-draggable" ).css('top',function(){return $('#wpf-map').css('top');});
		$( "#pfsearch-draggable" ).css('left',function(){return $('#wpf-map').css('left');});

		
		//Search tooltips
		if($.pf_tablet2_check()){
			$( '.pfsearch-header ul li' ).tooltip({
			  tooltipClass: "wpfui-tooltip",
			  position: {
				my: "left top",
				at: "left bottom+1",
				of: ".pfsearch-header",
				collision: 'flip'
			  },
			  show: {
				duration: "fast"
			  },
			  hide: {
				effect: "hide"
			  }
			});
			$('.pfsearch-header ul li').on('mouseleave',function(){
				$('.ui-helper-hidden-accessible').hide();
			});

		}
		
		$(".pftoggle-search" ).attr('data-pf-toggle','active');	
		$(".pftoggle-itemlist" ).attr('data-pf-toggle','passive');	
		$(".pftoggle-mapopt" ).attr('data-pf-toggle','passive');	
		
		$('.pftoggle-search').click(function(){
			$(this).WPFST('.pftoggle-search');
		});
		
		$('.pftoggle-itemlist').click(function(){
			$(this).WPFST('.pftoggle-itemlist');
		});
		
		$('.pftoggle-mapopt').click(function(){
			$(this).WPFST('.pftoggle-mapopt');
		});
		
		$('.pftoggle-user').click(function(){
			$(this).WPFST('.pftoggle-user');
		});
	
	});
	// DRAGGABLE SEARCH FORM FUNCTIONS FINISHED --------------------------------------------------------------------------------------------
	
	
	
	
	
	// MAP RE CENTER FUNCTION STARTED --------------------------------------------------------------------------------------------
    $.pfmap_recenter = function(map,latlng,offsetx,offsety) {
        var point1 = map.getProjection().fromLatLngToPoint(
            (latlng instanceof google.maps.LatLng) ? latlng : map.getCenter()
        );
        var point2 = new google.maps.Point(
            ( (typeof(offsetx) == 'number' ? offsetx : 0) / Math.pow(2, map.getZoom()) ) || 0,
            ( (typeof(offsety) == 'number' ? offsety : 0) / Math.pow(2, map.getZoom()) ) || 0
        );  
        map.panTo(map.getProjection().fromPointToLatLng(new google.maps.Point(
            point1.x - point2.x,
            point1.y + point2.y
        )));
    }
	// MAP RE CENTER FUNCTION FINISHED --------------------------------------------------------------------------------------------
	
	
	
	
	
	// GEOCIRCLE FUNCTIONS STARTED --------------------------------------------------------------------------------------------
	$.pfDistanceWidget = function(map) {
		
		this.set('map', map);
		this.set('position', $.pfGeolocationDefaults.latLng);
	
		var marker = new google.maps.Marker({
			draggable: false,
			icon: {
				url: $.pfGeolocationDefaults.icon1,
				scaledSize: new google.maps.Size(21,21),
				anchor: {x: 10,y: 10}
			}
		});
		
		marker.bindTo('map', this);
		marker.bindTo('position', this);
		var radiusWidget = new pfRadiusWidget();
		radiusWidget.bindTo('map', this);
		radiusWidget.bindTo('center', this, 'position');
		this.bindTo('distance', radiusWidget);
		this.bindTo('bounds', radiusWidget);
	}
	
	$.pfDistanceWidget.prototype = new google.maps.MVCObject();
	
	function pfRadiusWidget() {
		var bounds = $.pfgmap3static.geocircle.getBounds();
		
		this.set('distance', $.pfGeolocationDefaults.distance);
		this.bindTo('bounds', $.pfgmap3static.geocircle);
		$.pfgmap3static.geocircle.bindTo('center', this);
		$.pfgmap3static.geocircle.bindTo('map', this);
		$.pfgmap3static.geocircle.bindTo('radius', this);
	
	
		if (bounds) {
			var ne = bounds.getNorthEast();
			var sw = bounds.getSouthWest();
			
			if($.pfGeolocationDefaults.automove == false){
				if(!$.isEmptyObject($.pfsearchformvars)){
					$.pfloadmarkers('','','','',$.pfsearchformvars.action,$.pfsearchformvars.vars);
				 }else{
					$.pfloadmarkers();
				 }
			}else{
				if(!$.isEmptyObject($.pfsearchformvars)){
					$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng(),$.pfsearchformvars.action,$.pfsearchformvars.vars);
				 }else{
					$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng());
				 }
				$('#wpf-map').gmap3('get').fitBounds(bounds);
			}
			
		}
	
		this.addSizer_();
	}
	pfRadiusWidget.prototype = new google.maps.MVCObject();
	
	pfRadiusWidget.prototype.distance_changed = function () {
		
		if( $.pfGeolocationDefaults.unit == 'mi'){
			this.set('radius', ((this.get('distance') * 1000)*1.609344));
		}else{
			this.set('radius', this.get('distance') * 1000);
		}
	};
  
	pfRadiusWidget.prototype.addSizer_ = function () {
		var sizer = new google.maps.Marker({
			draggable: true,
			title: theme_map_functionspf.resizeword,
			icon: {
				url: $.pfGeolocationDefaults.icon2,
				scaledSize: new google.maps.Size(21,21),
				anchor: {x: 10,y: 10}
			}
		});
	
		sizer.bindTo('map', this);
		sizer.bindTo('position', this, 'sizer_position');
	
		var me = this;
		google.maps.event.addListener(sizer, 'drag', function () {
			me.setDistance();
		});
		google.maps.event.addListener(sizer, 'dragend', function () {
			me.setNewPoints();
			$.pfremovebyresults
			$.pfgmap3static.geocircle = $('#wpf-map').gmap3({get: {id: 'geoloccircle'}});
			$.pfgmap3static.geocircleBounds = $.pfgmap3static.geocircle.getBounds();
		});
	};
	
	pfRadiusWidget.prototype.center_changed = function () {
		var circle = $('#wpf-map').gmap3({
			get: {
				id: 'geoloccircle'
			}
		});
		var bounds = circle.getBounds();
		if (bounds) {
			var lng = bounds.getNorthEast().lng();
			var position = new google.maps.LatLng(this.get('center').lat(), lng);
			this.set('sizer_position', position);
		}
	};
	
	pfRadiusWidget.prototype.setNewPoints = function () {
		
		var bounds = $.pfgmap3static.geocircle.getBounds();
		if (bounds) {
			
			var ne = bounds.getNorthEast();
			var sw = bounds.getSouthWest();
			if(!$.isEmptyObject($.pfsearchformvars)){
				$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng(),$.pfsearchformvars.action,$.pfsearchformvars.vars);
			}else{
				$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng());
			}
			$('#wpf-map').gmap3('get').fitBounds(bounds);
			
			if($.pfGeolocationDefaults.hideinfo == false){
				//Overlay window for information
				$('#wpf-map').gmap3({
					clear: "overlay"
				}, {
					overlay: {
						latLng: $.pfgmap3static.geocircle.getCenter(),
						options: {
							content: "<div id='wpfkmwindow' class='wpfkmwindow'><div class='wpftext'>" + this.getDistance() + "</div></div>",
							offset: {
								x: -37,
								y: 5
							}
						}
					}
				});
			}
		}
	};
	
	pfRadiusWidget.prototype.distanceBetweenPoints_ = function (p1, p2) {
		if (!p1 || !p2) {
			return 0;
		}
		
		if( $.pfGeolocationDefaults.unit == 'mi'){
			var R = 3959; // Radius of the Earth in km
		}else{
			var R = 6371; // Radius of the Earth in km
		}

		var dLat = (p2.lat() - p1.lat()) * Math.PI / 180;
		var dLon = (p2.lng() - p1.lng()) * Math.PI / 180;
		var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
			Math.cos(p1.lat() * Math.PI / 180) * Math.cos(p2.lat() * Math.PI / 180) *
			Math.sin(dLon / 2) * Math.sin(dLon / 2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		var d = R * c;
		
		return d;
		
	};
	
	pfRadiusWidget.prototype.setDistance = function () {
		var pos = this.get('sizer_position');
		var center = this.get('center');
		var distance = this.distanceBetweenPoints_(center, pos);
		this.set('distance', distance);
	};
	
	pfRadiusWidget.prototype.getDistance = function () {
		var pos = this.get('sizer_position');
		var center = this.get('center');
		var distance = this.distanceBetweenPoints_(center, pos);
		if( $.pfGeolocationDefaults.unit == 'km'){
			return distance.toFixed(2)+' km'; 
		}else{
			return (distance/1.609).toFixed(2)+' mi';
		}
		
	};
	// GEOCIRCLE FUNCTIONS FINISHED --------------------------------------------------------------------------------------------
	
})(jQuery);

