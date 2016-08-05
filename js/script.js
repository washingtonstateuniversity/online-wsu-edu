/* global Backbone, jQuery, _ */
var wsuFOS = wsuFOS || {};
var wsuGCTheme = wsuGCTheme || {};

(function (window, Backbone, $, _, wsuGCTheme, wsuFOS) {
	'use strict';

	var header_original_position = false,
		headline_current_height = false,
		stop_position = false,
		is_sticky = false,
		is_mobile = '',
		main_header_text = '',
		$anchor_nav_wrapper = '';

	wsuGCTheme.appView = Backbone.View.extend({
		initialize : function() {
			$(document).scroll(this.scrollStickyHeader);
			$(document).on('touchmove', this.scrollStickyHeader);
			$(document).trigger('scroll');
		},

		scrollStickyHeader: function() {
			var scroll_position = $(document).scrollTop();

			if ( '' == is_mobile ) {
				if ( $('.size-lt-large').length > 0 ) {
					is_mobile = true;
				} else {
					is_mobile = false;
				}
			}
			if ( false === stop_position ) {
				if ( is_mobile ) {
					stop_position = 50;
				} else {
					stop_position = $('.main-header-sitename').height() + $('.main-header-sitename').offset().top;
				}
			}

			if ( '' === main_header_text ) {
				main_header_text = $('.sup-header-default').text();
			}

			if ( '' === $anchor_nav_wrapper ) {
				if ( $('.anchor-nav-wrapper').length > 0 ) {
					$anchor_nav_wrapper = $('.anchor-nav-wrapper');
				} else {
					$anchor_nav_wrapper = false;
				}
			}

			if ( false === $anchor_nav_wrapper ) {
				return; // nothing to do here.
			}

			if ( false === header_original_position ) {
				header_original_position = $anchor_nav_wrapper.offset().top;
			}

			if ( false === headline_current_height ) {
				headline_current_height = $anchor_nav_wrapper.outerHeight();
			}

			var sticky_position = header_original_position - scroll_position;

			if ( sticky_position <= stop_position && false === is_sticky ) {
				is_sticky = true;
				jQuery('.sup-header-default').fadeOut(100, function() { jQuery(this).text( $('.gc-headline h1').text()).fadeIn(200); });
				$('body').addClass('fixed-header');
			}

			if ( sticky_position > stop_position && true === is_sticky ) {
				is_sticky = false;
				jQuery('.sup-header-default').fadeOut(100, function() { jQuery(this).text(main_header_text).fadeIn(200); });
				$('body').removeClass('fixed-header');
				$anchor_nav_wrapper.css('top','');
			}
		}
	});

	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});

	var setup_form_modals = function() {
		$('.trigger-modal').on('click',function(e){
			e.preventDefault();
			var modal_id = $(this).data('modal');
			$('body').addClass('noscroll');
			$('#' + modal_id).show();
			$('.close-modal').on('click', function() {
				$('#' + modal_id).hide();
				$('body').removeClass('noscroll');
			});
		});
	};

	var last_section_height = function() {
		var doc_height = $(document).height();
		var win_height = $(window).height();
		var extra_height = 0;

		if ( $('.admin-bar').length > 0 ) {
			doc_height = doc_height - 32;
			extra_height = 32;
		}

		if ( win_height == doc_height ) {
			console.log('test');
			var $last_section = $('div.page section').last();
			var min_height = $last_section.outerHeight() + ( doc_height - $('.main-footer-sitename').offset().top ) - 30 + extra_height;

			$last_section.css('min-height',min_height);
		}

	};

	$(document).ready(function() {
		window.wsuGCTheme.app = new wsuGCTheme.appView();
		if ( undefined !== wsuFOS.appView ) {
			wsuFOS.app = new wsuFOS.appView();
		}
		last_section_height();
		setup_form_modals();
	});
})(window, Backbone, jQuery, _, wsuGCTheme, wsuFOS);
