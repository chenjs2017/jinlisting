function pointfinder_numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789").indexOf(keychar) > -1))
   return true;

else if (((",").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}

(function($) {
  "use strict";

  $(function(){
      var container = $('.pflistingtype-selector-main-top');
      var pfurl = container.data('pfajaxurl');
      var pfnonce = container.data('pfnoncef');
      var pfplaceh = container.data('pfplaceh');

      $('#post_author_override').select2({
         placeholder: pfplaceh,
         minimumInputLength: 3,
         ajax: {
           type: 'POST',
           dataType: "json",
           url: pfurl,
           quietMillis: 250,
           data: function (term, page) {
               return {
                   q: term,
                   action: 'pfget_authorchangesystem',
                   security: pfnonce
               };
           },
           results: function (data) {
               return {results: data};
           }
         },
         formatResult: formatValues,
         formatSelection: formatValues
      });

      function formatValues(data) {
          return data.nickname;
      }
  });

})(jQuery);