/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */

jQuery(document).ready(function($){

  $(function(){
    $('#slides').slides({
      generateNextPrev: true,
      preload: true,
      preloadImage: '/wp-content/themes/eriksfonsterputs/img/inline/loading.gif',
      play: 7000,
      pause: 2500,
      slideSpeed: 500,
      hoverPause: true,
      animationStart: function(current){
        $('.caption').animate({
          bottom:-35
        },100);
        if (window.console && console.log) {
          // example return of current slide number
          console.log('animationStart on slide: ', current);
        };
      },
      animationComplete: function(current){
        $('.caption').animate({
          bottom:0
        },200);
        if (window.console && console.log) {
          // example return of current slide number
          console.log('animationComplete on slide: ', current);
        };
      },
      slidesLoaded: function() {
        $('.caption').animate({
          bottom:0
        },200);
      }
    });
  });





  /*** overlays ***/    
  function hideAllOverlays(){
    $('#terms-overlay').hide('slow');
    $('#rut-info-overlay').hide('slow');
    $('#price-overlay').hide('slow');
  } 
  
  $("#terms-link").click(function(event) {
    event.preventDefault();
    $("#terms-overlay").show();
  }); 
    
  $("#rut-info-link").click(function(event) {
    event.preventDefault();
    $("#rut-info-overlay").show();
  }); 

  $("#price-link").click(function(event) {
    event.preventDefault();
    $("#price-overlay").show();
  }); 
 
  $('.overlay').click(function(event) {
    hideAllOverlays();
  });


});