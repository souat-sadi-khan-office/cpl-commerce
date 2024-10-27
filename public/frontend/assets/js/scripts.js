(function($) {
	'use strict';

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

	// for country
	$('#global_country_id').select2({
		width: '100%',
		templateResult: formatState,
		templateSelection: formatState
	});

	toastr.options = {
		"preventDuplicates": true,
		"preventOpenDuplicates": true
	};

	$(document).on('click', '#change-global-method', function() {
		let global_country_id = $('#global_country_id').val();
		let global_currency_id = $('#global_currency_id').val();
		$.post('/currency/change',{global_country_id:global_country_id, global_currency_id:global_currency_id}, function(data){
			location.reload();
		});
	})

	function formatState(state) {
		if (!state.id) {
			return state.text;
		}
	
		var imageUrl = $(state.element).data('image');
		var $state = $(
			'<span><img src="' + imageUrl + '" class="img-flag" /> ' + state.text + '</span>'
		);
		return $state;
	}

	/*===================================*
	01. LOADING JS
	/*===================================*/
	$(window).on('load', function() {
		setTimeout(function () {
			$(".preloader").delay(700).fadeOut(700).addClass('loaded');
		}, 600);
	});

	/*===================================*
	02. BACKGROUND IMAGE JS
	*===================================*/
	/*data image src*/
	$(".background_bg").each(function() {
		var attr = $(this).attr('data-img-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background-image', 'url(' + attr + ')');
		}
	});
	
	/*===================================*
	03. ANIMATION JS
	*===================================*/
	$(function() {
	
		function ckScrollInit(items, trigger) {
			items.each(function() {
				var ckElement = $(this),
					AnimationClass = ckElement.attr('data-animation'),
					AnimationDelay = ckElement.attr('data-animation-delay');
	
				ckElement.css({
					'-webkit-animation-delay': AnimationDelay,
					'-moz-animation-delay': AnimationDelay,
					'animation-delay': AnimationDelay,
					opacity: 0
				});
	
				var ckTrigger = (trigger) ? trigger : ckElement;
	
				ckTrigger.waypoint(function() {
					ckElement.addClass("animated").css("opacity", "1");
					ckElement.addClass('animated').addClass(AnimationClass);
				}, {
					triggerOnce: true,
					offset: '90%',
				});
			});
		}
	
		ckScrollInit($('.animation'));
		ckScrollInit($('.staggered-animation'), $('.staggered-animation-wrap'));
	
	});
	
	/*===================================*
	04. MENU JS
	*===================================*/
	//Main navigation scroll spy for shadow
	$(window).on('scroll', function() {
		var scroll = $(window).scrollTop();

	    if (scroll >= 150) {
	        $('header.fixed-top').addClass('nav-fixed');
	    } else {
	        $('header.fixed-top').removeClass('nav-fixed');
	    }

	});
	
	//Show Hide dropdown-menu Main navigation 
	$(document).ready(function () {
		$( '.dropdown-menu a.dropdown-toggler' ).on( 'click', function () {
			//var $el = $( this );
			//var $parent = $( this ).offsetParent( ".dropdown-menu" );
			if ( !$( this ).next().hasClass( 'show' ) ) {
				$( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
			}
			var $subMenu = $( this ).next( ".dropdown-menu" );
			$subMenu.toggleClass( 'show' );
			
			$( this ).parent( "li" ).toggleClass( 'show' );
	
			$( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function () {
				$( '.dropdown-menu .show' ).removeClass( "show" );
			} );
			
			return false;
		});
	});
	
	//Hide Navbar Dropdown After Click On Links
	var navBar = $(".header_wrap");
	var navbarLinks = navBar.find(".navbar-collapse ul li a.page-scroll");

    $.each( navbarLinks, function() {

      var navbarLink = $(this);

        navbarLink.on('click', function () {
          navBar.find(".navbar-collapse").collapse('hide');
		  $("header").removeClass("active");
        });

    });
	
	//Main navigation Active Class Add Remove
	$('.navbar-toggler').on('click', function() {
		$("header").toggleClass("active");
		if($('.search-overlay').hasClass('open'))
		{
			$(".search-overlay").removeClass('open');
			$(".search_trigger").removeClass('open');
		}
	});
	
	$(window).on('load', function() {
		if ($(".header_wrap").length > 0){
			if ($('.header_wrap').hasClass("fixed-top") && !$('.header_wrap').hasClass("transparent_header") && !$('.header_wrap').hasClass("no-sticky")) {
				$(".header_wrap").before('<div class="header_sticky_bar d-none"></div>');
			}
		}
	});

	var homePage = $('#isHomePage').val();
	
	$(window).on('scroll', function() {
		var scroll = $(window).scrollTop();
		
	    if (scroll >= 250) {
	        $('.header_sticky_bar').removeClass('d-none');
			$('header.no-sticky').removeClass('nav-fixed');

			if(homePage == 1) {
				$('#navCatContent').removeClass('nav_cat');
			}
			
	    } else {
	        $('.header_sticky_bar').addClass('d-none');

			if(homePage == 1) {
				$('#navCatContent').addClass('nav_cat');
			}
	    }
	});

	$(document).on('click', '#logout', function(e) {
		e.preventDefault();
		var url = $(this).data('url');
		$(this).html('Loading...');
		
		$.ajax({
			url: url,
			method: 'POST',
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'JSON',
			success: function(data) {
				setTimeout(function() {
					window.location.href = data.goto;
				}, 2000);
			},
			error: function(data) {
				var jsonValue = $.parseJSON(data.responseText);
				const errors = jsonValue.errors
				var i = 0;
				$.each(errors, function(key, value) {
					toastr.success(value);
					i++;
				});
			}
		});
	});

	$(document).on('keyup', '.number', function() {
		let value = $(this).val();
		$(this).val(allowOnlyNumbers(value));
	});

	$('.select').select2({
		width: '100%'
	});

	$(document).on('click', '.system-selector', function() {
		$('#globalSelector').css('display', 'block');
	})
	
	$(document).on('click', '.close-global-selector', function() {
		$('#globalSelector').css('display', 'none');
	})
	
	function allowOnlyNumbers(input) {
		return input.replace(/\D/g, '');
	}

	$(document).on('click', '.close', function() {
		$('#m-cart').removeClass('open');
		$('#m-cart').fadeOut();
		$('.overlay-loader').removeClass('open');
		$("body").removeClass('no-scroll')
	})
	
	var setHeight = function() {
		var height_header = $(".header_wrap").height();
		$('.header_sticky_bar').css({'height':height_header});
	};
	
	$(window).on('load', function() {
	  setHeight();
	});
	
	$(window).on('resize', function() {
	  setHeight();
	});
	
	$('.sidetoggle').on('click', function () {
		$(this).addClass('open');
		$('body').addClass('sidetoggle_active');
		$('.sidebar_menu').addClass('active');
		$("body").append('<div id="header-overlay" class="header-overlay"></div>');
	});
	
	$(document).on('click', '#header-overlay, .sidemenu_close',function() {
		$('.sidetoggle').removeClass('open');
		$('body').removeClass('sidetoggle_active');
		$('.sidebar_menu').removeClass('active');
		$('#header-overlay').fadeOut('3000',function(){
			$('#header-overlay').remove();
		});  
		 return false;
	});
	
	$(".categories_btn").on('click', function() {
		$('.side_navbar_toggler').attr('aria-expanded', 'false');
		$('#navbarSidetoggle').removeClass('show');
	});
	
	$(".side_navbar_toggler").on('click', function() {
		$('.categories_btn').attr('aria-expanded', 'false');
		$('#navCatContent').removeClass('show');
	});
	
	$(".pr_search_trigger").on('click', function() {
		$(this).toggleClass('show');
		$('.product_search_form').toggleClass('show');
	});

	var rclass = true;
	
	$("html").on('click', function () {
		if (rclass) {
			$('.categories_btn').addClass('collapsed');
			$('.categories_btn,.side_navbar_toggler').attr('aria-expanded', 'false');
			$('#navCatContent,#navbarSidetoggle').removeClass('show');
		}
		rclass = true;
	});
	
	$(".categories_btn,#navCatContent,#navbarSidetoggle .navbar-nav,.side_navbar_toggler").on('click', function() {
		rclass = false;
	});
	
	/*===================================*
	05. SMOOTH SCROLLING JS
	*===================================*/
	// Select all links with hashes
	
	var topheaderHeight = $(".top-header").innerHeight();
	var mainheaderHeight = $(".header_wrap").innerHeight();
	var headerHeight = mainheaderHeight - topheaderHeight - 20;
    $('a.page-scroll[href*="#"]:not([href="#"])').on('click', function() {
		$('a.page-scroll.active').removeClass('active');
		$(this).closest('.page-scroll').addClass('active');
        // On-page links
        if ( location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname ) {
          // Figure out element to scroll to
          var target = $(this.hash),
              speed= $(this).data("speed") || 800;
              target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

          // Does a scroll target exist?
          if (target.length) {
            // Only prevent default if animation is actually gonna happen
            event.preventDefault();
            $('html, body').animate({
              scrollTop: target.offset().top - headerHeight
            }, speed);
          }
        }
    });
	$(window).on('scroll', function(){
		var lastId,
			// All list items
			menuItems = $(".header_wrap").find("a.page-scroll"),
			topMenuHeight = $(".header_wrap").innerHeight() + 20,
			// Anchors corresponding to menu items
			scrollItems = menuItems.map(function(){
			  var items = $($(this).attr("href"));
			  if (items.length) { return items; }
			});
		var fromTop = $(this).scrollTop()+topMenuHeight;
	   
	   // Get id of current scroll item
		var cur = scrollItems.map(function(){
		 if ($(this).offset().top < fromTop)
		   return this;
	   });
	   // Get the id of the current element
	   cur = cur[cur.length-1];
	   var id = cur && cur.length ? cur[0].id : "";
	   
	   if (lastId !== id) {
		   lastId = id;
		   // Set/remove active class
		   menuItems.closest('.page-scroll').removeClass("active").end().filter("[href='#"+id+"']").closest('.page-scroll').addClass("active");
	   }  
		
	});
	
	$('.more_slide_open').slideUp();	
    $('.more_categories').on('click', function (){
		$(this).toggleClass('show');
		$('.more_slide_open').slideToggle();
    });
	
	/*===================================*
	06. SEARCH JS
	*===================================*/
    
	$(".close-search").on("click", function() {
		$(".search_wrap,.search_overlay").removeClass('open');
		$("body").removeClass('search_open');
	});
	
	var removeClass = true;
	$(".search_wrap").after('<div class="search_overlay"></div>');
	$(".search_trigger").on('click', function () {
		$(".search_wrap,.search_overlay").toggleClass('open');
		$("body").toggleClass('search_open');
		removeClass = false;
		if($('.navbar-collapse').hasClass('show'))
		{
			$(".navbar-collapse").removeClass('show');
			$(".navbar-toggler").addClass('collapsed');
			$(".navbar-toggler").attr("aria-expanded", false);
		}
	});
	$(".search_wrap form").on('click', function() {
		removeClass = false;
	});
	$("html").on('click', function () {
		if (removeClass) {
			$("body").removeClass('open');
			$(".search_wrap,.search_overlay").removeClass('open');
			$("body").removeClass('search_open');
		}
		removeClass = true;
	});
	
	/*===================================*
	07. SCROLLUP JS
	*===================================*/
	$(window).on('scroll', function() {
		if ($(this).scrollTop() > 150) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	
	$(".scrollup").on('click', function (e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, 600);
		return false;
	});
	
	/*===================================*
	08. PARALLAX JS
	*===================================*/
	// $(window).on('load', function() {
    //     $('.parallax_bg').parallaxBackground();
	// });
	
	/*===================================*
	09. MASONRY JS
	*===================================*/
	// $( window ).on( "load", function() {
	// 	var $grid_selectors  = $(".grid_container");
	// 	var filter_selectors = ".grid_filter > li > a";
	// 	if( $grid_selectors.length > 0 ) {
	// 		$grid_selectors.imagesLoaded(function(){
	// 			if ($grid_selectors.hasClass("masonry")){
	// 				$grid_selectors.isotope({
	// 					itemSelector: '.grid_item',
	// 					percentPosition: true,
	// 					layoutMode: "masonry",
	// 					masonry: {
	// 						columnWidth: '.grid-sizer'
	// 					},
	// 				});
	// 			} 
	// 			else {
	// 				$grid_selectors.isotope({
	// 					itemSelector: '.grid_item',
	// 					percentPosition: true,
	// 					layoutMode: "fitRows",
	// 				});
	// 			}
	// 		});
	// 	}
	
	// 	//isotope filter
	// 	$(document).on( "click", filter_selectors, function() {
	// 		$(filter_selectors).removeClass("current");
	// 		$(this).addClass("current");
	// 		var dfselector = $(this).data('filter');
	// 		if ($grid_selectors.hasClass("masonry")){
	// 			$grid_selectors.isotope({
	// 				itemSelector: '.grid_item',
	// 				layoutMode: "masonry",
	// 				masonry: {
	// 					columnWidth: '.grid_item'
	// 				},
	// 				filter: dfselector
	// 			});
	// 		} 
	// 		else {
	// 			$grid_selectors.isotope({
	// 				itemSelector: '.grid_item',
	// 				layoutMode: "fitRows",
	// 				filter: dfselector
	// 			});
	// 		}
	// 		return false;
	// 	});

	$('#search').on('keyup', function(){
		search();
	});

	$('#search').on('focus', function(){
		search();
	});

	function search(){
		var searchKey = $('#search').val();
		if(searchKey.length > 0){

			$('#search-content').html(null);
			$('.typed-search-box').removeClass('d-none');
			$('.searching-preloader').removeClass('d-none');
			$.post('/ajax-search', { 
				search_module: 'ajax_search',
				search:searchKey
			}, function(data){
				if(data == '0'){
					$('#search-content').html(null);
					$('.typed-search-box .search-nothing').removeClass('d-none').html('Sorry, nothing found for <strong>"'+searchKey+'"</strong>');
					$('.searching-preloader').addClass('d-none');

				} else {
					$('.typed-search-box .search-nothing').addClass('d-none').html(null);
					$('#search-content').html(data);
					$('.searching-preloader').addClass('d-none');
				}
			});
		} else {
			$('.typed-search-box').addClass('d-none');
		}
	}
		
	// 	$('.portfolio_filter').on('change', function() {
	// 		$grid_selectors.isotope({
	// 		  filter: this.value
	// 		});
	// 	});

	// 	$(window).on("resize", function () {
	// 		setTimeout(function () {
	// 			$grid_selectors.find('.grid_item').removeClass('animation').removeClass('animated'); // avoid problem to filter after window resize
	// 			$grid_selectors.isotope('layout');
	// 		}, 300);
	// 	});
	// });
	
	$('.link_container').each(function () {
		$(this).magnificPopup({
			delegate: '.image_popup',
			type: 'image',
			mainClass: 'mfp-zoom-in',
			removalDelay: 500,
			gallery: {
				enabled: true
			}
		});
	});
	
	/*===================================*
	10. SLIDER JS
	*===================================*/
	function carousel_slider() {
		$('.carousel_slider').each( function() {
			var $carousel = $(this);
			$carousel.owlCarousel({
				dots : $carousel.data("dots"),
				loop : $carousel.data("loop"),
				items: $carousel.data("items"),
				margin: $carousel.data("margin"),
				mouseDrag: $carousel.data("mouse-drag"),
				touchDrag: $carousel.data("touch-drag"),
				autoHeight: $carousel.data("autoheight"),
				center: $carousel.data("center"),
				nav: $carousel.data("nav"),
				rewind: $carousel.data("rewind"),
				navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
				autoplay : $carousel.data("autoplay"),
				animateIn : $carousel.data("animate-in"),
				animateOut: $carousel.data("animate-out"),
				autoplayTimeout : $carousel.data("autoplay-timeout"),
				smartSpeed: $carousel.data("smart-speed"),
				responsive: $carousel.data("responsive")
			});	
		});
	}
	
	function slick_slider() {
		$('.slick_slider').each( function() {
			var $slick_carousel = $(this);
			$slick_carousel.not('.slick-initialized').slick({
				arrows: $slick_carousel.data("arrows"),
				dots: $slick_carousel.data("dots"),
				infinite: $slick_carousel.data("infinite"),
				centerMode: $slick_carousel.data("center-mode"),
				vertical: $slick_carousel.data("vertical"),
				fade: $slick_carousel.data("fade"),
				cssEase: $slick_carousel.data("css-ease"),
				autoplay: $slick_carousel.data("autoplay"),
				verticalSwiping: $slick_carousel.data("vertical-swiping"),
				autoplaySpeed: $slick_carousel.data("autoplay-speed"),
				speed: $slick_carousel.data("speed"),
				pauseOnHover: $slick_carousel.data("pause-on-hover"),
				draggable: $slick_carousel.data("draggable"),
				slidesToShow: $slick_carousel.data("slides-to-show"),
				slidesToScroll: $slick_carousel.data("slides-to-scroll"),
				asNavFor: $slick_carousel.data("as-nav-for"),
				focusOnSelect: $slick_carousel.data("focus-on-select"),
				responsive: $slick_carousel.data("responsive")
			});	
		});
	}

	/*===================================*
	11. CONTACT FORM JS
	*===================================*/
	$("#submitButton").on("click", function(event) {
	    event.preventDefault();
	    var mydata = $("form").serialize();
	    $.ajax({
	        type: "POST",
	        dataType: "json",
	        url: "contact.php",
	        data: mydata,
	        success: function(data) {
	            if (data.type === "error") {
	                $("#alert-msg").removeClass("alert, alert-success");
	                $("#alert-msg").addClass("alert, alert-danger");
	            } else {
	                $("#alert-msg").addClass("alert, alert-success");
	                $("#alert-msg").removeClass("alert, alert-danger");
	                $("#first-name").val("Enter Name");
	                $("#email").val("Enter Email");
					$("#phone").val("Enter Phone Number");
	                $("#subject").val("Enter Subject");
	                $("#description").val("Enter Message");

	            }
	            $("#alert-msg").html(data.msg);
	            $("#alert-msg").show();
	        },
	        error: function(xhr, textStatus) {
	            alert(textStatus);
	        }
	    });
	});
	
	/*===================================*
	12. POPUP JS
	*===================================*/
	// $('.content-popup').magnificPopup({
	// 	type: 'inline',
	// 	preloader: true,
	// 	mainClass: 'mfp-zoom-in',
	// });
	
	$('.image_gallery').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: 'a', // the selector for gallery item
			type: 'image',
			gallery: {
			  enabled: true,
			},
		});
	});
	
	// $('.video_popup, .iframe_popup').magnificPopup({
	// 	type: 'iframe',
	// 	removalDelay: 160,
	// 	mainClass: 'mfp-zoom-in',
	// 	preloader: false,
	// 	fixedContentPos: false
	// });
	
	/*===================================*
	13. Select dropdowns
	*===================================*/
	
	if ($('select').length) {
	// Traverse through all dropdowns
	$.each($('select'), function (i, val) {
		var $el = $(val);
		
		if ($el.val()===""){ 
			$el.addClass('first_null'); 
		}
		
		if (!$el.val()) {
			$el.addClass('not_chosen');
		}
		
		$el.on('change', function () {
			if (!$el.val())
				$el.addClass('not_chosen');
			else
				$el.removeClass('not_chosen');
		});
		
	  });
	}
	
	/*==============================================================
    14. FIT VIDEO JS
    ==============================================================*/
    if ($(".fit-videos").length > 0){
		$(".fit-videos").fitVids({ 
			customSelector: "iframe[src^='https://w.soundcloud.com']"
		});
	}
	
	/*==============================================================
    15. DROPDOWN JS
    ==============================================================*/
	if ($(".custome_select").length > 0){
		$(document).ready(function () {
			$(".custome_select").msDropdown();
		});
	}
	
	/*===================================*
    16.MAP JS
    *===================================*/	
	if ($("#map").length > 0){
		google.maps.event.addDomListener(window, 'load', init);
	}
	
	var map_selector = $('#map');
	function init() {
		
		var mapOptions = {
			zoom: map_selector.data("zoom"),
			mapTypeControl: false,
			center: new google.maps.LatLng(map_selector.data("latitude"), map_selector.data("longitude")), // New York
		  };
		var mapElement = document.getElementById('map');
		var map = new google.maps.Map(mapElement, mapOptions);
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(map_selector.data("latitude"), map_selector.data("longitude")),
			map: map,
			icon: map_selector.data("icon"),
			
			title: map_selector.data("title"),
		});
		marker.setAnimation(google.maps.Animation.BOUNCE);
	}	

	
	/*===================================*
    17. COUNTDOWN JS
    *===================================*/
    // $('.countdown_time').each(function() {
    //     var endTime = $(this).data('time');
    //     $(this).countdown(endTime, function(tm) {
    //         $(this).html(tm.strftime('<div class="countdown_box"><div class="countdown-wrap"><span class="countdown days">%D </span><span class="cd_text">Days</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown hours">%H</span><span class="cd_text">Hours</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown minutes">%M</span><span class="cd_text">Minutes</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown seconds">%S</span><span class="cd_text">Seconds</span></div></div>'));
    //     });
    // });
	
	/*===================================*
	18. List Grid JS
	*===================================*/
	$('.shorting_icon').on('click',function() {
		if ($(this).hasClass('grid')) {
			$('.shop_container').removeClass('list').addClass('grid');
			$(this).addClass('active').siblings().removeClass('active');
		}
		else if($(this).hasClass('list')) {
			$('.shop_container').removeClass('grid').addClass('list');
			$(this).addClass('active').siblings().removeClass('active');
		}
		$(".shop_container").append('<div class="loading_pr"><div class="mfp-preloader"></div></div>');
		setTimeout(function(){
			$('.loading_pr').remove();
			//$container.isotope('layout');
		}, 800);
	});
	
	/*===================================*
	19. TOOLTIP JS
	*===================================*/
	$(function () {
		$('[data-toggle="tooltip"]').tooltip({
			trigger: 'hover',
		});
	});
	$(function () {
		$('[data-toggle="popover"]').popover();
	});
	
	/*===================================*
	20. PRODUCT COLOR JS
	*===================================*/
	function product_color_switch() {
		$('.product_color_switch span').each(function() {
			var get_color = $(this).attr('data-color');
			$(this).css("background-color", get_color);
		});
		
		$('.product_color_switch span,.product_size_switch span').on("click", function() {
			$(this).siblings(this).removeClass('active').end().addClass('active');
		});
	}
	
	/*Product quantity js*/
	function pluseminus() {
		$('.plus').on('click', function() {
			if ($(this).prev().val()) {
				$(this).prev().val(+$(this).prev().val() + 1);
			}
		});
		$('.minus').on('click', function() {
			if ($(this).next().val() > 1) {
				if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
			}
		});
	}


	/*===================================*
	21. QUICKVIEW POPUP + ZOOM IMAGE + PRODUCT SLIDER JS
	*===================================*/
	function galleryZoomProduct() {
		var image = $('#product_img');
		//var zoomConfig = {};
		var zoomActive = false;
		
		zoomActive = !zoomActive;
		if(zoomActive) {
			if ($(image).length > 0){
				$(image).elevateZoom({
					cursor: "crosshair",
					easing : true, 
					gallery:'pr_item_gallery',
					zoomType: "inner",
					galleryActiveClass: "active"
				}); 
			}
		}
		else {
			$.removeData(image, 'elevateZoom');//remove zoom instance from image
			$('.zoomContainer:last-child').remove();// remove zoom container from DOM
		}
		
		$.magnificPopup.defaults.callbacks = {
		open: function() {
		  $('body').addClass('zoom_image');
		},
		close: function() {
		  // Wait until overflow:hidden has been removed from the html tag
		  setTimeout(function() {
			$('body').removeClass('zoom_image');
			$('body').removeClass('zoom_gallery_image');
			//$('.zoomContainer:last-child').remove();// remove zoom container from DOM
			$('.zoomContainer').slice(1).remove();
			}, 100);
		  }
		};
		
		// Set up gallery on click
		var galleryZoom = $('#pr_item_gallery');
		galleryZoom.magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery:{
				enabled: true
			},
			callbacks: {
				elementParse: function(item) {
					item.src = item.el.attr('data-zoom-image');
				}
			}
		});
		
		// Zoom image when click on icon
		$('.product_img_zoom').on('click', function(){
			var actual = $('#pr_item_gallery a').attr('data-zoom-image');
			$('body').addClass('zoom_gallery_image');
			$('#pr_item_gallery .item').each(function(){
				if( actual == $(this).find('.product_gallery_item').attr('data-zoom-image') ) {
					return galleryZoom.magnificPopup('open', $(this).index());
				}
			});
		});
	}


	/*INIT JS*/
	$(document).ready(function () {
		pluseminus();
		product_color_switch();
		galleryZoomProduct();
		carousel_slider();
		slick_slider();
		ajax_magnificPopup();
	});


	/*===================================*
	22. PRICE FILTER JS
	*===================================*/
	$('#price_filter').each( function() {
		var $filter_selector = $(this);
		var a = $filter_selector.data("min-value");
		var b = $filter_selector.data("max-value");
		var c = $filter_selector.data("price-sign");
		$filter_selector.slider({
			range: true,
			min: $filter_selector.data("min"),
			max: $filter_selector.data("max"),
			values: [ a, b ],
			slide: function( event, ui ) {
				$( "#flt_price" ).html( c + ui.values[ 0 ] + " - " + c + ui.values[ 1 ] );
				$( "#price_first" ).val(ui.values[ 0 ]);
				$( "#price_second" ).val(ui.values[ 1 ]);
			}
		});
		$( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
	});
	
	/*===================================*
	23. RATING STAR JS
	*===================================*/
	$(document).ready(function () {
	  	$('.star_rating span').on('click', function(){
			var onStar = parseFloat($(this).data('value'), 10); // The star currently selected
			$('.star_rating_field').val(onStar);			
			var stars = $(this).parent().children('.star_rating span');
			for (var i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}
			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}
		});
	});
	
	/*===================================*
	24. CHECKBOX CHECK THEN ADD CLASS JS
	*===================================*/
	$('.create-account,.different_address').hide();
	$('#createaccount:checkbox').on('change', function(){
		if($(this).is(":checked")) {
			$('.create-account').slideDown();
		} else {
			$('.create-account').slideUp();
		}
	});
	$('#differentaddress:checkbox').on('change', function(){
		if($(this).is(":checked")) {
			$('.different_address').slideDown();
		} else {
			$('.different_address').slideUp();
		}
	});
	
	/*===================================*
	25. Cart Page Payment option
	*===================================*/	
	$(document).ready(function () {
		$('[name="payment_option"]').on('change', function() {
			var $value = $(this).attr('value');
			$('.payment-text').slideUp();
			$('[data-method="'+$value+'"]').slideDown();
		});
	});
	
	/*===================================*
	26. ONLOAD POPUP JS
	*===================================*/
	
	// $(window).on('load',function(){
	// 	setTimeout(function() {
	// 		$("#onload-popup").modal('show', {}, 500);
	// 	}, 3000);
	// });	

	// mobile listing menu open
	$(document).on('click', '#lc-toggle', function() {
		$('#column-left').addClass('open');
		$('.overlay-loader').addClass('open');
		$("body").addClass('no-scroll')
	})

	// mobile listing menu close
	$(document).on('click', '.lc-close', function() {
		$('#column-left').removeClass('open');
		$('.overlay-loader').removeClass('open');
		$("body").removeClass('no-scroll');
	});

	// Product Add to Compare List
	$(document).on('click', '.add_compare', function() {
        let id = $(this).data('id');
        $(this).html('<i class="fas fa-spin fa-spinner"></i>');
        $.ajax({
            url: '/add-to-compare-list',
            method: 'POST',
            data: {
                id: id 
            },
            dataType: 'JSON',
            success: function(data) {
                if(data.status) {
                    $('.compare_counter').html(data.counter);
                    toastr.success(data.message);
                } else {
                    toastr.warning(data.message);
                }
                $('.add_compare').html('<i class="fas fa-random"></i>');
            }
        });
    });

	// Product Add to Wish List
	$(document).on('click', '.add_wishlist', function() {
        let id = $(this).data('id');
        let wish_list_counter = parseInt($('#wish_list_counter').html());
        $(this).html('<i class="fas fa-spin fa-spinner"></i>');
        $.ajax({
            url: '/add-to-wish-list',
            method: 'POST',
            data: {
                id: id 
            },
            dataType: 'JSON',
            success: function(data) {
                if(data.status) {
                    $('#wish_list_counter').html(parseInt(wish_list_counter) + 1);
                    toastr.success(data.message);
                } else {
                    toastr.warning(data.message);
                }
                $('.add_wishlist').html('<i class="far fa-heart"></i>');
            }
        })
    })

	$('.add-to-cart').click(function () {
		// Get product data
		let productSlug = $(this).data('id');
		let quantity =  $('#product-'+productSlug).val();

		if(quantity === undefined) {
			quantity = 1;
		}

        $(this).html('<i class="fas fa-spin fa-spinner"></i>');

		$.ajax({
			url: '/cart/add',
			method: 'POST',
			data: {
				slug: productSlug,
				quantity: quantity
			},
			dataType: 'JSON',
			success: function (response) {
				if(response.status) {
					toastr.success(response.message);

					$('#cart-total-quantity').text(response.total_quantity);
					$('#cart-total-price').text(response.total_price);
				} else {
					toastr.warning(response.message);
				}
				
				$('.add-to-cart').html('<i class="fas fa-shopping-bag"></i> Add to Cart');
			},
			error: function (error) {
				toastr.error("Something went wrong! Please try again");
				
				$('.add-to-cart').html('<i class="fas fa-shopping-bag"></i> Add to Cart');
			}
		});
	});
	
	function ajax_magnificPopup() {
		$('.popup-ajax').magnificPopup({
			type: 'ajax',
			callbacks: {
				ajaxContentAdded: function() {
					pluseminus(); 
					product_color_switch();
					galleryZoomProduct();
					slick_slider();
					carousel_slider();
				 }
			}
		});
	}

	$(document).on('click', '.cart-container', function() {
		$('#m-cart').addClass('open');
		$('#m-cart').fadeIn();
		$('.overlay-loader').addClass('open');

		getCartItems('main-cart-area');
	});

	function getCartItems(showArea) {
		$.ajax({
			url: '/get-cart-items',
			method: 'POST',
			data: {
				show: showArea 
			},
			dataType: 'JSON',
			success: function(data) {
				if(showArea == 'main-cart-area') {
					$('.cart-content').html(data.content);
					$('.amount').html(data.total_price);
					if(data.counter > 0) {
						$('.checkout-btn').show();
					}
				} else {
					$('.cart_total_price').html(data.total_price);
					$('.cart_count').html(data.counter);
					$('.cart-container .counter').html(data.counter);
					$('.mobile_cart_list').html(data.content);
					if(data.counter > 0) {
						$('.cart_footer').show();
					}
					$('.cart-loader').hide();
				}
			}
		})
	}

	getCartItems();

	function removeCartItems(id, showArea = null, load = false) {
		$.ajax({
			url: '/remove-cart-items',
			method: 'DELETE',
			data: {
				show: showArea,
				id: id
			},
			dataType: 'JSON',
			success: function(data) {
				if(data.status) {
					toastr.success(data.message);
					if(showArea == 'main-cart-area') {
						$('.cart-content').html(data.content);
						$('.amount').html(data.total_price);
						if(data.counter > 0) {
							$('.checkout-btn').show();
						}
					} else {
						$('.cart_total_price').html(data.total_price);
						$('.cart_count').html(data.counter);
						$('.cart-container .counter').html(data.counter);
						$('.mobile_cart_list').html(data.content);
						if(data.counter > 0) {
							$('.cart_footer').show();
						}
						$('.cart-loader').hide();
					}
				} else {
					toastr.error(data.message);
				}
				
				if(data.load) {
					window.location.href="";
				}
			}
		})
	}

	$(document).on('click', '.remove-item-from-cart', function() {
		let id = $(this).data('id');
		let load = false;
		if($(this).data('load')) {
			load = true;
		}
		$(this).html('<i class="fas fa-spin fa-spinner"></i>')
		removeCartItems(id, 'main-cart-area', load);
	});

	document.addEventListener('DOMContentLoaded', function () {
		const dropdownLinks = document.querySelectorAll('.dropdown-item.dropdown-toggler');
	
		dropdownLinks.forEach(function (link) {
			link.addEventListener('click', function (e) {
				e.preventDefault(); // Default behavior (dropdown) বন্ধ করা
				window.location.href = this.getAttribute('href'); // লিংকে রিডাইরেক্ট করা
			});
		});
	});

	
})(jQuery);

var _newsletterFormValidation = function () {
	$('#newsletter_submit').show();
	$('#newsletter_submitting').hide();

	if ($('#newsletter-form').length > 0) {
		$('#newsletter-form').parsley().on('field:validated', function () {
			var ok = $('.parsley-error').length === 0;
			$('.bs-callout-info').toggleClass('hidden', !ok);
			$('.bs-callout-warning').toggleClass('hidden', ok);
		});
	}

	$('#newsletter-form').on('submit', function (e) {
		e.preventDefault();

		$('#newsletter_submit').hide();
		$('#newsletter_submitting').show();

		$(".ajax_error").remove();

		var submit_url = $('#newsletter-form').attr('action');
		var formData = new FormData($("#newsletter-form")[0]);

		$.ajax({
			url: submit_url,
			type: 'POST',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'JSON',
			success: function (data) {
				if (!data.status) {
					if (data.validator) {
						for (const [key, messages] of Object.entries(data.message)) {
							messages.forEach(message => {
								toastr.error(message);
							});
						}
					} else {
						toastr.warning(data.message);
					}
				} else {
					toastr.success(data.message);
					
					$('#newsletter-form')[0].reset();
					if (data.load) {
						setTimeout(function () {

							window.location.href = "";
						}, 500);
					}
				}

				$('#newsletter_submit').show();
				$('#newsletter_submitting').hide();
			},
			error: function (data) {
				var jsonValue = $.parseJSON(data.responseText);
				const errors = jsonValue.errors;
				if (errors) {
					var i = 0;
					$.each(errors, function (key, value) {
						const first_item = Object.keys(errors)[i]
						const message = errors[first_item][0];
						if ($('#' + first_item).length > 0) {
							$('#' + first_item).parsley().removeError('required', {
								updateClass: true
							});
							$('#' + first_item).parsley().addError('required', {
								message: value,
								updateClass: true
							});
						}
						toastr.error(value);
						i++;

					});
				} else {
					toastr.warning(jsonValue.message);
				}

				$('#newsletter_submit').show();
				$('#newsletter_submitting').hide();
			}
		});
	});
};