/*global redux_change, wp, redux*/

(function( $ ) {
    "use strict";



    redux.field_objects = redux.field_objects || {};
    redux.field_objects.extension_itempage = redux.field_objects.extension_itempage || {};

    $( document ).ready(
        function() {
            //redux.field_objects.slides.init();
        }
    );


    redux.field_objects.extension_itempage.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-extension_itempage:visible' );
        }

        $( selector ).each(
            function() {
                var el = $( this );

                /*redux.field_objects.media.init(el);*/

                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                
                if ( parent.hasClass( 'redux-container-extension_itempage' ) ) {
                    parent.addClass( 'redux-field-init' );    
                }
                
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }

                
               

                el.find( '.itempage-title' ).keyup(
                    function( event ) {
                        var newTitle = event.target.value;
                        $( this ).parents().eq( 3 ).find( '.redux-extension_itempage-header' ).text( newTitle );
                    }
                );


                el.find( ".redux-extension_itempage-accordion" )
                    .accordion(
                    {
                        header: "> div > fieldset > h3",
                        collapsible: true,
                        active: false,
                        heightStyle: "content",
                        icons: {
                            "header": "ui-icon-plus",
                            "activeHeader": "ui-icon-minus"
                        }
                    }
                )
                    .sortable(
                    {
                        axis: "y",
                        handle: "h3",
                        connectWith: ".redux-extension_itempage-accordion",
                        start: function( e, ui ) {
                            ui.placeholder.height( ui.item.height() );
                            ui.placeholder.width( ui.item.width() );
                        },
                        placeholder: "ui-state-highlight",
                        stop: function( event, ui ) {
                            // IE doesn't register the blur when sorting
                            // so trigger focusout handlers to remove .ui-state-focus
                            ui.item.children( "h3" ).triggerHandler( "focusout" );
                            var inputs = $( 'input.itempage-sort' );
                            inputs.each(
                                function( idx ) {
                                    $( this ).val( idx );
                                }
                            );
                        }
                    }
                );
            }
        );
        

        


    };
})( jQuery );
