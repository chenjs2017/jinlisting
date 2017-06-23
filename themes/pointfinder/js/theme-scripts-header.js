/***************************************************************************************************************
*
*
* HEADER FUNCTIONS
*
*
***************************************************************************************************************/
(function($) {
  "use strict";

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


	$.fn.pfLoadingOverlayex = function(args) {
		var defaults = {
	      action:'',
	      message:''        
	    };
	    var settings = $.extend(defaults, args);

	    if (settings.action == 'show') {
	    	if(settings.message != ''){
	    		$(this).append("<div class='pfuserloadingex pfloadingimg'><div class='pfloadingmessageex'>"+settings.message+"</div></div>");
	    	}else{
	    		$(this).append("<div class='pfuserloadingex pfloadingimg'></div>");
	    	}
	    } else if(settings.action == 'hide'){
	    	$(this).find('.pfuserloading').remove();
	    };
	}
	// LOADING --------------------------------------------------------------------------------------------
})(jQuery);