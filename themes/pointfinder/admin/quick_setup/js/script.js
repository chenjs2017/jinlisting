(function($) {
	"use strict";

	$(function(){
		$('.pfclloading').hide();
		$('.pfclloading').css('background','url('+theme_quickjs.loadingimg+')');

		$('#pfimportformbutton').click(function(){
			$('.pfclloading').show();
			$('#pfimportformbutton').val(theme_quickjs.buttonwait);
			$('#pfimportformbutton').attr("disabled", true);
			$('#pfqsform').submit();
		});


		if ($('#pf_setup_mode').val() == 0) {
			$('#pfimportformbutton').hide()
		}
			
		$('#pf_setup_mode').change(function(){
			
			$('#pfimportformbutton').val(theme_quickjs.buttonwait);
			$('#pfimportformbutton').attr("disabled", true);

			if ($(this).val() == 0) {
				$('#pfimportformbutton').hide()
			}else{
				$('#pfimportformbutton').show()
				$.ajax({
					beforeSend:function(){$('.pfclloading').show();},
		            type: 'POST',
		            dataType: 'json',
		            url: theme_quickjs.ajaxurl,
		            data: { 
		                'action': 'pfget_quicksetupprocess',
		                'myval': $(this).val(),
		                'security': theme_quickjs.pfget_quicksetupprocess
		            },
		            success:function(data){
		            	
		            	var obj = [];
						$.each(data, function(index, element) {
							obj[index] = element;
						});

					
						if(obj.process == true){
							$('#pfimportformbutton').val(theme_quickjs.buttonok);
							$('#pfimportformbutton').attr("disabled", false);

						}else{
							$('#pfimportformbutton').val(theme_quickjs.buttonerror);
							$('#pfimportformbutton').attr("disabled", true);
						}

		            },
		            error: function (request, status, error) {},
		            complete: function(){$('.pfclloading').hide();},
		        });
			}

		});
	});

})(jQuery);