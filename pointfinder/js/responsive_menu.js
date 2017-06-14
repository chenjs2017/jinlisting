
(function($) {
  "use strict";
  $.fn.pfresponsivenav = function(args) {
    // Default settings
    var defaults = {
      responsive: true,
      width: 992,                           
      animation: {                        
        effect: 'fade',                  
        show: 120,
        hide: 100
      },
      selected: 'selected',               
      arrow: 'pfadmicon-glyph-860',
      mleft: 10
    };
    var settings = $.extend(defaults, args);
    
    // Initialize the menu and the button
    init($(this).attr('id'), settings.button);
    
    function init(menuid) {
      setupMenu(menuid);
      $(window).bind('resize orientationchange', function(){
        if ($.pf_tablet_check()) {resizeMenu(menuid);};
      });
      resizeMenu(menuid);
    }
    
    function setupMenu(menuid) {
      var $mainmenu = $('#'+menuid+'>ul');
      
      var $headers = $mainmenu.find("ul").parent();

      $headers.each(function(i) {
        var $curobj = $(this);
        $curobj.children('a:eq(0)').append('<span class="'+settings.arrow+'"></span>');
      });
    }
    
    function resizeMenu(menuid) {
      var $ww = document.body.clientWidth;
      if ( $ww > settings.width || $ww >= settings.width || !settings.responsive) {
        $('#'+menuid).removeClass('pfmobileview');
      } else {
        $('#'+menuid).addClass('pfmobileview');
      }
      
      var $headers = $('#'+menuid+'>ul').find('ul').parent();
      
      $headers.each(function(i) {
        var $curobj = $(this);
        var $link = $curobj.children('a:eq(0)');
        var $subul = $curobj.find('ul:eq(0)');
        
        // Unbind events
        $curobj.unbind('mouseenter mouseleave');
        $link.unbind('click');
        animateHide($curobj.children('ul:eq(0)'));
        
        if ( $ww > settings.width  || !settings.responsive ) {
          // Full menu
          $curobj.hover(function(e) {
            var $targetul = $(this).children('ul:eq(0)');
            
            var $dims = { w: this.offsetWidth,
                          h: this.offsetHeight,
                          subulw: $subul.outerWidth(),
                          subulh: $subul.outerHeight()
                        };
                       
            var $istopheader = $curobj.parents('ul').length == 1 ? true : false;
            $subul.css($istopheader ? {} : { top: 0 });
            var $offsets = { left: $(this).offset().left, 
                             top: $(this).offset().top
                           };
            var $menuleft = $istopheader ? settings.mleft : $dims.w;
            $menuleft = ( $offsets.left + $menuleft + $dims.subulw > $(window).width() ) ? ( $istopheader ? -$dims.subulw + $dims.w : -$dims.w ) : $menuleft;
            $targetul.css({ left:$menuleft+'px', 
                           width:$dims.subulw+'px' 
                          });
          
            if (!$targetul.parent().closest('ul').hasClass('pfnav-megasubmenu')) {
              animateShow($targetul);
            };

          },
          function(e) {
            var $targetul = $(this).children('ul:eq(0)');
            if (!$targetul.parent().closest('ul').hasClass('pfnav-megasubmenu')) {
              animateHide($targetul);
            };
            
          });
        } else {
          // Compact menu
          $link.click(function(e) {
            e.preventDefault();

            var $targetul = $curobj.children('ul:eq(0)');
            if ( isSelected($curobj) ) {
              collapseChildren($targetul);
              animateHide($targetul);
            } else {
              //collapseSiblings($curobj);
              animateShow($targetul);
            }
          });
        }
      });
      
      collapseChildren('#'+menuid);
    }
    
    function collapseChildren(elementid) {
      // Closes all submenus of the specified element
      var $headers = $(elementid).find('ul');
      $headers.each(function(i) {
        if ( isSelected($(this).parent())) {
          animateHide($(this));
        }
      });
    }
    
    function collapseSiblings(element) {
      var $siblings = element.siblings('li');
      $siblings.each(function(i) {
        collapseChildren($(this));
      });
    }
    
    function isSelected(element) {
      return element.hasClass(settings.selected);
    }
    
    function animateShow(menu, button) {
      if ( !button ) { var button = menu.parent(); }
     
      button.addClass(settings.selected);
      
      if ( settings.animation.effect == 'fade' ) {
        menu.fadeIn(settings.animation.show);
      } else if ( settings.animation.effect == 'slide' ) {
        menu.slideDown(settings.animation.show);
      } else {
        menu.show();
        menu.removeClass('hide');
      }

    }
    
    function animateHide(menu, button) {
      if ( !button ) { var button = menu.parent(); }
      
      if ( settings.animation.effect == 'fade' ) {
        menu.fadeOut(settings.animation.hide, function() { 
          menu.removeAttr('style');
          button.removeClass(settings.selected);
        });
      } else if ( settings.animation.effect == 'slide' ) {
        menu.slideUp(settings.animation.hide, function() { 
          menu.removeAttr('style');
          button.removeClass(settings.selected);
        });
      } else {
        menu.hide();
        menu.addClass('hide');
        menu.removeAttr('style');
        button.removeClass(settings.selected);
      }
    }
  };
})(jQuery);