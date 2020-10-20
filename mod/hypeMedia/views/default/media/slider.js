define(function(require) {

	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');
	var Hammer = require('hammer');
	require('slick');


	$(document).on('init', '.media-slider', function(e, slick) {
		$.each(slick.$slides, function(i, elem) {
			if ($(elem).data('current')) {
				slick.slickGoTo(i);
			}
		});

		var mc = new Hammer($('.media-slider-info')[0]);
		mc.on('swipeleft', function() {
			slick.next();
		});
		mc.on('swiperight', function() {
			slick.prev();
		})
	});

	$(document).on('afterChange', '.media-slider', function(e, slick, slide) {
		var $slide = $(slick.$slides[slide]);

		var ajax = new Ajax(false);

		$('.media-slider-info').html('<div class="elgg-ajax-loader" />');

		var info = $slide.data('info');
		var href = $slide.data('href');
		var title = $slide.data('title');

		ajax.path(info).done(function(output) {
			window.history.pushState({
				slide: $slide.data('slickIndex'),
			}, title, href);

			$('.media-slider-info').html(output);
		});
	});

	window.onpopstate = function(event) {
		if (!event.state.slide) {
			return;
		}

		$('.media-slider').slick('goTo', event.state.slide);
	};

	$(document).on('click', '.media-slider-slide', function(e) {
		e.preventDefault();

		if ($(this).is('.slick-current')) {
			return;
		}

		$('.media-slider').slick('goTo', $(this).data('slickIndex'));
	});

	$('.media-slider').show().siblings('.elgg-ajax-loader').remove();

	$('.media-slider').slick({
		infinite: true,
		centerMode: true,
		arrows: true,
		slidesToShow: 1,
		variableWidth: true
	});
});