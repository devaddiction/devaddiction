$(function() {
      $('ul.hover-block li').hover(function(){
        $(this).find('.hover-content').animate({top:'-3px'},{queue:false,duration:500});
      }, function(){
        $(this).find('.hover-content').animate({top:'155px'},{queue:false,duration:500});
      });
});
