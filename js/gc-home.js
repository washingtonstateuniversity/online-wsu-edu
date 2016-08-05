/* global Backbone, jQuery, _ */
var wsuGCHome = wsuGCHome || {};

(function (window, Backbone, $, _, wsuGCHome) {
	'use strict';

	wsuGCHome.appView = Backbone.View.extend({
		el: 'main',

		// Setup the events used in the overall application view.
		events: {
			'click .column': 'togglePanel'
		},

		togglePanel: function(evt) {
			var $target = $(evt.target);

			if ( $target.is('a') ) {
				return;
			}

			if ( ! $target.is('.column') ) {
				$target = $target.parents('.column' );
			}

			if ( $target.hasClass('active-panel') ) {
				$target.removeClass('active-panel');
			} else {
				$target.addClass('active-panel');
			}

		}
	});

	$(document).ready(function() {
		window.wsuGCHome.app = new wsuGCHome.appView();
	});
})(window, Backbone, jQuery, _, wsuGCHome);
