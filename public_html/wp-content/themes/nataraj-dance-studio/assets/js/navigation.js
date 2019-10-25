/* global nataraj_dance_studioScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function( $ ) {
	// NAVIGATION CALLBACK FOR WOCOMMERCE MENU
	var ww = jQuery(window).width();
	jQuery(document).ready(function() { 
		jQuery(".top-header .nav li a").each(function() {
			if (jQuery(this).next().length > 0) {
				jQuery(this).addClass("parent");
			};
		})
		jQuery(".togglewooMenu").click(function(e) { 
			e.preventDefault();
			jQuery(this).toggleClass("active");
			jQuery(".top-header .nav").slideToggle('fast');
		});
		adjustMenu();
	})

	// navigation orientation resize callbak
	jQuery(window).bind('resize orientationchange', function() {
		ww = jQuery(window).width();
		adjustMenu();
	});

	var adjustMenu = function() {
		if (ww < 720) {
			jQuery(".togglewooMenu").css("display", "block");
			if (!jQuery(".togglewooMenu").hasClass("active")) {
				jQuery(".top-header .nav").hide();
			} else {
				jQuery(".top-header .nav").show();
			}
			jQuery(".top-header .nav li").unbind('mouseenter mouseleave');
		} else {
			jQuery(".togglewooMenu").css("display", "none");
			jQuery(".top-header .nav").show();
			jQuery(".top-header .nav li").removeClass("hover");
			jQuery(".top-header .nav li a").unbind('click');
			jQuery(".top-header .nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
				jQuery(this).toggleClass('hover');
			});
		}
	}

	// NAVIGATION CALLBACK FOR MAIN MENU
	var ww = jQuery(window).width();
	jQuery(document).ready(function() { 
		jQuery(".menu-section .nav li a").each(function() {
			if (jQuery(this).next().length > 0) {
				jQuery(this).addClass("parent");
			};
		})
		jQuery(".toggleMenu").click(function(e) { 
			e.preventDefault();
			jQuery(this).toggleClass("active");
			jQuery(".menu-section .nav").slideToggle('fast');
		});
		adjustMenu();
	})

	// navigation orientation resize callbak
	jQuery(window).bind('resize orientationchange', function() {
		ww = jQuery(window).width();
		adjustMenu();
	});

	var adjustMenu = function() {
		if (ww < 720) {
			jQuery(".toggleMenu").css("display", "block");
			if (!jQuery(".toggleMenu").hasClass("active")) {
				jQuery(".menu-section .nav").hide();
			} else {
				jQuery(".menu-section .nav").show();
			}
			jQuery(".menu-section .nav li").unbind('mouseenter mouseleave');
		} else {
			jQuery(".toggleMenu").css("display", "none");
			jQuery(".menu-section .nav").show();
			jQuery(".menu-section .nav li").removeClass("hover");
			jQuery(".menu-section .nav li a").unbind('click');
			jQuery(".menu-section .nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
				jQuery(this).toggleClass('hover');
			});
		}
	}

	/**** Hidden search box ***/
	jQuery('document').ready(function($){
		$('.search-box span i').click(function(){
	        $(".serach_outer").slideDown(700);
	    });

	    $('.closepop i').click(function(){
	        $(".serach_outer").slideUp(700);
	    });
	});

	$(document).ready(function(){
		$(".product-cat").hide();
	    $("button").click(function(){
	        $(".product-cat").toggle();
	    });
	});	
	
})( jQuery );
