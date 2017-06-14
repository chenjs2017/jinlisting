/* global redux_change, wp */
function rand(min, max) {
  //  discuss at: http://phpjs.org/functions/rand/


  var argc = arguments.length;
  if (argc === 0) {
    min = 0;
    max = 2147483647;
  } else if (argc === 1) {
    throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
  }
  return Math.floor(Math.random() * (max - min + 1)) + min;

}


jQuery(document).ready(function () {
	
    jQuery('.redux-sidebar-slides-remove').live('click', function () {
        redux_change(jQuery(this));
        jQuery(this).parent().siblings().find('input[type="text"]').val('');
        jQuery(this).parent().siblings().find('textarea').val('');
        jQuery(this).parent().siblings().find('input[type="hidden"]').val('');
		jQuery(this).parent().siblings().find('select').val('');

        var slideCount = jQuery(this).parents('.redux-container-extension_sidebar_slides:first').find('.redux-sidebar-slides-accordion-group').length;

        if (slideCount > 1) {
            jQuery(this).parents('.redux-sidebar-slides-accordion-group:first').slideUp('medium', function () {
                jQuery(this).remove();
            });
        } else {
            jQuery(this).parents('.redux-sidebar-slides-accordion-group:first').find('.remove-image').click();
            jQuery(this).parents('.redux-container-extension_sidebar_slides:first').find('.redux-sidebar-slides-accordion-group:last').find('.redux-sidebar-slides-header').text("New Slide");            
        }
    });

    jQuery('.redux-sidebar-slides-add').click(function () {

        var newSlide = jQuery(this).prev().find('.redux-sidebar-slides-accordion-group:last').clone(true);
        var slideCount = jQuery(newSlide).find('input[type="text"]').attr("name").match(/[0-9]+(?!.*[0-9])/);
        var slideCount1 = slideCount*1 + 1;

        jQuery(newSlide).find('input[type="text"], input[type="hidden"], textarea, select').each(function(){

            jQuery(this).attr("name", jQuery(this).attr("name").replace(/[0-9]+(?!.*[0-9])/, slideCount1) ).attr("id", jQuery(this).attr("id").replace(/[0-9]+(?!.*[0-9])/, slideCount1) );
            jQuery(this).val('');
			
            if (jQuery(this).hasClass('slide-sort')){
                jQuery(this).val(slideCount1);
            }
			
			if (jQuery(this).hasClass('slide-url')){
                jQuery(this).val('field'+rand(1,999999999999999999999));
            }
						
        });
		
        jQuery(newSlide).find('.screenshot').removeAttr('style');
        jQuery(newSlide).find('.screenshot').addClass('hide');
        jQuery(newSlide).find('.screenshot a').attr('href', '');
        jQuery(newSlide).find('.remove-image').addClass('hide');
        jQuery(newSlide).find('.redux-sidebar-slides-image').attr('src', '').removeAttr('id');
        jQuery(newSlide).find('h3').text('').append('<span class="redux-sidebar-slides-header">New field</span><span class="ui-accordion-header-icon ui-icon ui-icon-plus"></span>');		
        jQuery(this).prev().append(newSlide);
    });

    jQuery('.slide-title').keyup(function(event) {
        var newTitle = event.target.value;
        jQuery(this).parents().eq(3).find('.redux-sidebar-slides-header').text(newTitle);
    });

    jQuery(function () {
        jQuery(".redux-sidebar-slides-accordion")
            .accordion({
                header: "> div > fieldset > h3",
                collapsible: true,
                active: false,
                heightStyle: "content",
                icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" }
            })
            .sortable({
                axis: "y",
                handle: "h3",
                connectWith: ".redux-sidebar-slides-accordion",
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                },
                placeholder: "ui-state-highlight",
                stop: function (event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children("h3").triggerHandler("focusout");
                    var inputs = jQuery('input.slide-sort');
                    inputs.each(function(idx) {
                        jQuery(this).val(idx);
                    });
                }
            });
    });




});