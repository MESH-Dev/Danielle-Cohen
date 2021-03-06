Track = function (trackId){
    var currentTrack = "";

    SC.stream("http://api.soundcloud.com/tracks/" + trackId, function(sound){
        currentTrack = sound;
    });

    this.play = function() {
        currentTrack.play();

    };

    this.pause = function() {
        currentTrack.pause();

    };

    this.stop = function() {
        currentTrack.stop();

    };
};

Rotation = function(tracks) {
    var currentTrack = tracks[0];

    this.currentTrack = function () {
        return currentTrack;
    };

    this.nextTrack = function () {
        var currentIndex = tracks.indexOf(currentTrack);

        if (currentIndex == (tracks.length - 1)) {
          var nextTrackIndex = 0;
        } else {
          var nextTrackIndex = currentIndex + 1;
        }

        var nextTrackId = tracks[nextTrackIndex];
        currentTrack = nextTrackId;
        return currentTrack
    };

    this.prevTrack = function() {
      var currentIndex = tracks.indexOf(currentTrack);

      if (currentIndex == 0) {
        var prevTrackIndex = tracks.length - 1;
      } else {
        var prevTrackIndex = currentIndex - 1;
      }

      var prevTrackId = tracks[prevTrackIndex];
      currentTrack = prevTrackId;
      return currentTrack;
    }
};



/* Custom Front-End jQuery scripts */
jQuery(document).ready(function($) {

	"use strict";

	var h = $(window).height();
	var scrolled = true;

	$('#header-container').height(h);

	var m = h - 350;

	/* Soundbar */

	// var playing = false;
  //
	// SC.stream("/tracks/75921125", function(sound){
	// 	SC.sound = sound;
	// });
  //
	// $('.play').click(function() {
	// 	if (playing == false) {
	// 		SC.sound.play();
	// 		playing = true;
	// 	} else {
	// 		SC.sound.pause();
	// 		playing = false;
	// 	}
	// 	$(this).find('i').toggleClass('fa-play fa-pause')
	// });

  var playing = false;
  var first = true;

  var rotation;
  var currentTrack;
  var currentPlayingTrack;

  var songs;

  SC.get("/groups/34324/tracks", function(tracks){

    songs = tracks;

    rotation = new Rotation(tracks);
    currentTrack = rotation.currentTrack();
    currentPlayingTrack = new Track(currentTrack.id);

    if (first == true) {
      $('.trackTitle').html(currentTrack.title);
      first = false;
    }
  });

  // var songs = [{"title":"Sad Trombone","song_url":"https://soundcloud.com/sheckylovejoy/sad-trombone","soundcloud_id":"18321000"},{"title":"AraabMUZIK - \"Beauty\"","song_url":"    https://soundcloud.com/selftitledmag/araabmuzik-beauty","soundcloud_id":"79408289"}]
  // console.log(songs);


  $('#play').on('click', function(event){
      playing = true;
      currentPlayingTrack.play();
      $('.trackTitle').html(currentTrack.title);
      $('#pause').show();
      $('#play').hide();
  });

  $('#pause').on('click', function(event){
      playing = false;
      currentPlayingTrack.pause();
      $('#pause').hide();
      $('#play').show();
  });

  $('#stop').on('click', function(event){
      playing = false;
      currentPlayingTrack.stop();
      $('#pause').hide();
      $('#play').show();
  });


  $('#next').on('click', function(event){
      currentPlayingTrack.stop();
      currentTrack = rotation.nextTrack();
      currentPlayingTrack = new Track(currentTrack.id);
      if (playing == true) {
        currentPlayingTrack.play();
      }
      console.log(currentTrack);

      $('.trackTitle').html(currentTrack.title);
      $('.artistTitle').html(currentTrack.artist);
  });

  $('#prev').on('click', function(event){
      currentPlayingTrack.stop();
      currentTrack = rotation.prevTrack();
      currentPlayingTrack = new Track(currentTrack.id);
      if (playing == true) {
        currentPlayingTrack.play();
      }
      $('.trackTitle').html(currentTrack.title);
  });

	var fullPath = window.location.pathname + window.location.search + window.location.hash;

	if (fullPath != "/") {
		$('#header-container').css('margin-top', -m);
	}
	else {
		$('.soundbar').hide();
		$(window).scroll(sticky_relocate);
	}

	function sticky_relocate() {

		var window_top = $(window).scrollTop();
		var div_top = $('#branding').offset().top - 100;

		if (div_top < window_top) {

			if (scrolled) {
				scrolled = false;
				$('#header-container').css('margin-top', -m);
				$('html, body').animate({
					scrollTop: 0
				}, 0);
				$('.soundbar').fadeIn();
			}
		}
	}

	/* add hover on current menu item */

	/* Nav Menu */
	$(function(){

		$('.menu .sub-links').not($('.sub-menu .sub-links')).wrap('<div class="sub-menu" />');/* Fix for Custom Link only */

		$('.main-menu > ul > li > .sub-menu').each(function (index, element) {
			if ($(element).children().hasClass('sub-posts') && $(element).children().hasClass('sub-links')) {
				$(element).parent().addClass('sub-menu-two-columns');
			} else if ($(element).children().hasClass('sub-posts') && (!$(element).children().hasClass('sub-links'))) {
				$(element).parent().addClass('sub-menu-full-width');
			} else if ($(element).find('.sub-links').length > 2) {
				$(element).parent().addClass('sub-menu-columns');
			} else {
				$(element).parent().addClass('sub-links-only');
			}

			if ($(element).children().length) {
				$(element).parent().addClass('link-arrow');
			}
		});

		$('.sub-menu-columns > .sub-menu > .sub-links').each(function (index, element) {
			var count = $(element).children().length;
			$(element).parents('.sub-menu-columns').addClass('sub-menu-columns-'+count);
		});

		$('.sub-menu').each(function (index, element) {
			if ($(element).children().length === 0) {
				$(element).remove();
			}
		});

		$('#pageslide .menu li').find('.sub-menu').before('<span class="plus"></span>');
		$('#pageslide .menu li .plus').on('click', function (e) {
			$(this).toggleClass("expanded");
			$(this).next().slideToggle();
		});

		$( '.main-menu li:has(ul),.secondary-menu li:has(ul)' ).doubleTapToGo();

	});


	/* Sticky menu */
	$('.main-menu-fixed').hcSticky({
		offResolutions: [-960],
		stickTo: document,
		wrapperClassName: 'sticky-menu-container'
	});


	/* Sidebar in Mobile View */
	var sidebar = $('#pageslide');
	$('.main-menu, #masthead:not(.hide-strip) .secondary-menu').children().clone().removeAttr('id').appendTo($(sidebar));
	$(sidebar).children().nextUntil().wrap('<div class="block" />');

	$('#open-pageslide').click(function(event) {
		event.preventDefault();
		$('body').toggleClass('st-menu-open');
	});

	$('#close-pageslide').click(function(event) {
		event.preventDefault();
		$('body').removeClass('st-menu-open');
	});


	if ($().flexslider){
		// Widget sliders
		$('.widget .flexslider').flexslider({
			useCSS: false,
			animation: 'slide',
			controlNav: false,
			smoothHeight: true,
			allowOneSlide: true,
			nextText: '<i class="icomoon-chevron-right"></i>',
			prevText: '<i class="icomoon-chevron-left"></i>'
		});

		// Home page & Category sliders
		$('.posts-slider').flexslider({
			useCSS: false,
			animation: 'slide',
			controlNav: false,
			smoothHeight: true,
			allowOneSlide: true,
			nextText: '<i class="icomoon-chevron-right"></i>',
			prevText: '<i class="icomoon-chevron-left"></i>',
			start: function(slider) {
				$('.posts-slider').removeClass('loading');
			}
		});
	}



	/* Post Format gallery carousel */
	if ($('#gallery-carousel')[0]) {

		var gallery = $('#gallery-carousel .carousel');

		enquire.register("screen and (min-width:751px)", function() {
			gallery.carouFredSel({
				width:'100%',
				align:false,
				auto:false,
				scroll:{
					items:1
				},
				items:{
					visible:1
				},
				prev:'#gallery-carousel .prev',
				next:'#gallery-carousel .next',
				swipe:{
					onTouch:true
				}
			});

		});

		enquire.register("screen and (max-width:750px)", function() {
			gallery.carouFredSel({
				responsive:true,
				items:{
					visible:{
						max:1
					}
				},
				align:'center',
				auto:false,
				prev:'#gallery-carousel .prev',
				next:'#gallery-carousel .next',
				swipe:{
					onTouch:true
				}
			});

		});

	}



	/* Related posts */
	if ($('.related-posts')[0]) {

		var carousel = $('.related-posts .carousel');
		var n = $(carousel).find('.item').length;

		enquire.register("screen and (min-width:751px)", {
			match : function() {
				if (n > 3) {
					$(carousel).carouFredSel({
						scroll: 1,
						items: {
							start: 'random',
							visible: {
								min: 3
							}
						},
						align: 'left',
						auto: false,
						prev: '.related-posts .prev',
						next: '.related-posts .next'
					});
				}

				if (n <= 3) {
					$('.related-posts .carousel-nav').hide();
				}
			}
		});

		enquire.register("screen and (max-width:750px)", {
			match : function() {
				$(carousel).carouFredSel({
					responsive: true,
					scroll: 1,
					items: {
						height: '90%',
						start: 'random',
					},
					align: 'left',
					auto: false,
					prev: '.related-posts .prev',
					next: '.related-posts .next',
					swipe: {
						onTouch: true
					}
				});

				if (n <= 1) {
					$('.related-posts .carousel-nav').hide();
				}
			}
		});

	}


	/* Authors widget */
	if ($('.sidebar .widget_ti_site_authors .carousel')[0]) {

		$(function(){

			var carousel = $('.sidebar .widget_ti_site_authors .carousel');
			var n = $(carousel).find('li').length;
			if (n > 5) {

				$(carousel).after('<ul id="carouselX" class="carousel" />').next().html($(carousel).html());
				$(carousel).find('li:odd').remove();
				$("#carouselX li:even").remove();

				$("#carouselX").carouFredSel({
					width: '100%',
					auto: false
				});
			}

			$(carousel).carouFredSel({
				width: '100%',
				auto: false,
				scroll: 1,
				synchronise: '#carouselX',
				prev: '.sidebar .widget_ti_site_authors .prev',
				next: '.sidebar .widget_ti_site_authors .next'
			});

		});

	}

	if ($('.footer-sidebar .widget_ti_site_authors .carousel')[0]) {

		$(function(){

			var carousel = $('.footer-sidebar .widget_ti_site_authors .carousel');
			var n = $(carousel).find('li').length;
			if (n > 5) {

				$(carousel).after('<ul id="carouselXX" class="carousel" />').next().html($(carousel).html());
				$(carousel).find('li:odd').remove();
				$("#carouselXX li:even").remove();

				$("#carouselXX").carouFredSel({
					width: '100%',
					auto: false
				});
			}

			$(carousel).carouFredSel({
				width: '100%',
				auto: false,
				scroll: 1,
				synchronise: '#carouselXX',
				prev: '.footer-sidebar .widget_ti_site_authors .prev',
				next: '.footer-sidebar .widget_ti_site_authors .next'
			});

		});

	}


	/* Author Box Tabs */
	var tabContainers = $('.single-author-box .author-tabs-content .inner > div');
	tabContainers.hide().filter(':first').show();

	$('.single-author-box .author-tabs-button a').click(function() {
		tabContainers.hide();
		tabContainers.filter(this.hash).show();
		$('.single-author-box .author-tabs-button a').removeClass('active');
		$(this).addClass('active');
		return false;
	}).filter(':first').click();


	/* Animate search field width fallback */
	if ($('.no-csstransitions')[0]) {
		$('.top-strip input#s').focus(function() {
			$(this).animate({width: 300}, 400);
		});

		$('.top-strip input#s').blur(function() {
			$(this).animate({width: 100}, 400);
		});
	}


	/* Masonry Layout */
	if ( $().masonry ){

		var $m_container = $('.masonry-layout');

		enquire.register("screen and (min-width: 750px)", function() {
			$m_container.imagesLoaded( function(){
				$m_container.masonry({
					itemSelector : '.hentry'
				});
			});
		}, true);

	}


	/* Gallery */
	if ( $().imgLiquid ){
		$('.custom-gallery').find('.gallery-item').imgLiquid({
			fill:true
		});
	}


	/* Sticky sidebar */
	$('.sidebar-fixed').hcSticky({
		top: 60,
		bottomEnd: 30,
		offResolutions: [-750],
		wrapperClassName: 'sticky-bar-container'
	});


	/* Knob (post rating) */
	if ( $().knob ){
		$('.knob').knob({
			min: 0,
			max: 10,
			step: 1
		});
	}


	/* Show a smooth animation when images are loaded */
	$('.entry-image').on('inview', function(event, isInView) {
		if (isInView) {
			$(this).addClass('inview');
		}
	});


	/* Show bottom single post slide dock */
	if ($('.slide-dock')[0]) {

		var random_post = $('.slide-dock');
		$('#footer').on('inview', function(event, isInView) {
			if (isInView) {
				random_post.addClass('slide-dock-on');
			} else {
				random_post.removeClass('slide-dock-on');
			}
		});

		$('.close-dock').click(function(e){
			e.preventDefault();
			$('.slide-dock').toggleClass('slide-dock-on slide-dock-off');
		});

	}


	/* Sitemap toogle */
	$('.sitemap .row .trigger').click(function(e){
		e.preventDefault();
		$(this).toggleClass('active').next().slideToggle('fast');
	});


	 /* Color Box */
	if ( $().swipebox ){
		$('.custom-gallery .gallery-item a').swipebox({
			useCSS: true,
			hideBarsDelay: 5000
		});
	}


	/* Fluid Width Video */
	if ( $().fitVids ){
		$('.video-wrapper, .entry-content, .page-content, .advertising').fitVids({ignore:'[src*="youtube.com/subscribe_widget"]'});
	}


	/* Back to Top link */
	$('.back-top').click(function(){
		$('html, body').animate({scrollTop:0}, 'fast');
		return false;
	});

});// - document ready
