/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */

jQuery(document).ready(function($){

	$(function(){
		$('#slides').slides({
			generateNextPrev: true,
			preload: true,
			preloadImage: 'img/inline/loading.gif',
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

});