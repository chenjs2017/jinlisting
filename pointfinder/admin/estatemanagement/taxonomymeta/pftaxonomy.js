(function( $ ) {
    "use strict";
 
    $( document ).ready(
        function() {
            $('.pointfinder-tax-header > span').live('click', function(event) {
                event.preventDefault();
                /* Act on the event */
                if ($(this).hasClass('dashicons-arrow-up-alt2')) {
                    $(this).parent('.pointfinder-tax-header').next('.pointfinder-tax-header-body').hide();
                    $(this).removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
                }else{
                    $(this).parent('.pointfinder-tax-header').next('.pointfinder-tax-header-body').show();
                    $(this).removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
                }
                
                
            });
        }
    );


})( jQuery );
