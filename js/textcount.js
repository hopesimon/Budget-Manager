$(function(){
   $('textarea').on('keyup', function(){
      var charLength = 140 - $(this).val().length;
      $(this).next().find('.charcount').html(charLength);
   });
});