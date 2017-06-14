/***************************************************************************************************************
*
*
* METABOX FUNCTIONS
*
*
***************************************************************************************************************/
(function($) {
  "use strict";

  	$.pf_mobile_check = function(){
		if ($(window).width() > 568) {return true;} else{return false;};
	}

	$.pf_tablet_check = function(){
		if ($(window).width() > 992) {return true;} else{return false;};
	}

	$.pf_tablet2_check = function(){
		if ($(window).width() > 1024) {return true;} else{return false;};
	}
	
	// LOADING --------------------------------------------------------------------------------------------
	$.fn.pfLoadingOverlay = function(args) {
		var defaults = {
	      action:'',
	      message:'',
	      opacity:1       
	    };
	    var settings = $.extend(defaults, args);

	    if (settings.action == 'show') {
	    	if(settings.message != ''){
	    		$(this).append("<div class='pfuserloading pfloadingimg' style='opacity:"+settings.opacity+"'><div class='pfloadingmessage'>"+settings.message+"</div></div>");
	    	}else{
	    		$(this).append("<div class='pfuserloading pfloadingimg' style='opacity:"+settings.opacity+"'></div>");
	    	}
	    } else if(settings.action == 'hide'){
	    	$(this).find('.pfuserloading').remove();
	    };
	}
	$('.pfitemdetailcheckall').on('click',function(event) {
		/* Act on the event */
		$.each($('[name="pffeature[]"]'), function(index, val) {
			 $(this).attr('checked', true);
		});
	});

	$('.pfitemdetailuncheckall').on('click',function(event) {
		/* Act on the event */
		$.each($('[name="pffeature[]"]'), function(index, val) {
			 $(this).attr('checked', false);
		});
	});
	// LOADING --------------------------------------------------------------------------------------------



	// CHECK LIMITS FOR BACKEND
		$.pf_get_checklimits = function(itemid,limitvalue){
			var container = $('.pflistingtype-selector-main-top');
			var pfurl = container.data('pfajaxurl');
			var pflang = container.data('pflang');
			var pfnonce = container.data('pfnonce');

			$.ajax({
				url: pfurl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'pfget_listingtypelimits',
					id: itemid,
					limit: limitvalue,
					lang: pflang,
					security: pfnonce
				},
			}).success(function(obj) {
					if (obj !== null) {
						if (obj.pf_address_area == 2) {
							
						}else{
							$('#pointfinder_map').show();
							$('#redux-pointfinderthemefmb_options-metabox-pf_item_streetview').show();
						}
					

						if (obj.pf_image_area == 2) {
							$('#gallery').hide();
						}else{
							$('#gallery').show();
						}

						if (obj.pf_file_area == 2) {
							$('#attachment-upload').hide();
						}else{
							$('#attachment-upload').show();
						}

						if (obj.pf_condition_area == 2) {
							$('#pointfinder_itemdetailcf_process_co').hide();
						}else{
							$('#pointfinder_itemdetailcf_process_co').show();
						}
					}

			}).complete(function(){});
		}
	// CHECK LIMITS FOR BACKEND


	// MODULES GET
		$.pf_getmodules_now = function(itemid){
			var container = $('.pflistingtype-selector-main-top');
			var pfurl = container.data('pfajaxurl');
			var pflang = container.data('pflang');
			var pfnonce = container.data('pfnoncef');
			var pfid = container.data('pfid');

			$.ajax({
		    	beforeSend:function(){
		    		$('.pfsubmit-inner-features').pfLoadingOverlay({action:'show'});
		    	},
				url: pfurl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'pfget_featuresystem',
					id: itemid,
					place: 'backend',
					postid: pfid,
					lang: pflang,
					security: pfnonce
				},
			})
			.done(function(obj) {

				if (obj.features == null || obj.features == '' || obj.features == 'undefined') {
					$('.pfsubmit-inner-features').hide();
					$('.pfsubmit-inner-features-title').hide();
					$('#pfupload_itemtypes').rules('remove');
				} else {
					$('.pfsubmit-inner-features').html(obj.features);
					$('.pfsubmit-inner-features').show();
					$('.pfsubmit-inner-features-title').show();

					if ($('input[name="pointfinderfeaturecount"]').val() == 0) {
						$('.pfsubmit-inner-features').hide();
						$('.pfsubmit-inner-features-title').hide();
					}else{
						$('.pfsubmit-inner-features').show();
						$('.pfsubmit-inner-features-title').show();
					}

					$('.pfitemdetailcheckall').on('click',function(event) {
						$.each($('[name="pffeature[]"]'), function(index, val) {
							 $(this).attr('checked', true);
						});
					});

					$('.pfitemdetailuncheckall').on('click',function(event) {
						$.each($('[name="pffeature[]"]'), function(index, val) {
							 $(this).attr('checked', false);
						});
					});
				}




				if (obj.itemtypes == null || obj.itemtypes == '' || obj.itemtypes == 'undefined') {
					$('.pfsubmit-inner-sub-itype').hide();
				}else{
					$('.pfsubmit-inner.pfsubmit-inner-sub-itype').html(obj.itemtypes);
					$('.pfsubmit-inner-sub-itype').show();
				}



				if (obj.conditions == null || obj.conditions == '' || obj.conditions == 'undefined') {
					$('.pfsubmit-inner-sub-conditions').hide();
				}else{
					$('.pfsubmit-inner.pfsubmit-inner-sub-conditions').html(obj.conditions);
					$('.pfsubmit-inner-sub-conditions').show();
				}

				if (obj.customfields == null || obj.customfields == '' || obj.customfields == 'undefined') {
					$('.pfsubmit-inner-customfields').hide();
					$('.pfsubmit-inner-customfields-title').hide();
				}else{
					$('.pfsubmit-inner-customfields').html(obj.customfields);
					$('.pfsubmit-inner-customfields').show();
					$('.pfsubmit-inner-customfields-title').show();
				}


				if (obj.ohours == null || obj.ohours == '' || obj.ohours == 'undefined') {
					$('.openinghourstab-output-container').hide();
				}else{
					$('.openinghourstab-output-container').html(obj.ohours);
					$('.openinghourstab-output-container').show();
				}




			}).error(function(xhr,states,message){
				console.log(message);
			});
		}
	// MODULES GET



	$('.pflistingtypeselector').change(function(){
		$('.pf-sub-listingtypes-container').html('');
		$('#pfupload_listingtypes').val($(this).val()).trigger('change');
		$.pf_get_sublistingtypes($(this).val(),'');
		$.pf_get_checklimits($(this).val(),$.pflimitarray);
	});

	$( '#pfupload_listingtypes' ).change(function(){	
		$.pf_getmodules_now($(this).val());
	});


})(jQuery);