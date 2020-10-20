define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');
	var spinner = require('elgg/spinner');

	function toggleUiElements($container) {
		var $container = $container || $('body');
		if ($('.inbox-monitor-checkbox:visible:checked', $container).length) {
			$('.inbox-monitor-action', $container).removeClass('elgg-state-disabled').prop('disabled', false);
		} else {
			$('.inbox-monitor-action', $container).addClass('elgg-state-disabled').prop('disabled', true);
		}
		if ($('.inbox-monitor-checkbox:visible:checked', $container).length === $('.inbox-monitor-checkbox:visible').length) {
			$('.inbox-monitor-checkbox-toggle', $container).prop('checked', true);
		} else {
			$('.inbox-monitor-checkbox-toggle', $container).prop('checked', false);
		}
	}

	$(document).on('change', '.inbox-monitor-checkbox-toggle', function () {
		var $container = $(this).closest('.inbox-monitor-module');
		$('.inbox-monitor-checkbox:visible').prop('checked', $(this).is(':checked'));
		toggleUiElements($container);
	});

	$(document).on('change', '.inbox-monitor-checkbox', function () {
		var $container = $(this).closest('.inbox-monitor-module');
		toggleUiElements($container);
	});

	$(document).on('click', '.inbox-monitor-action', function (e) {
		if (!confirm(elgg.echo('question:areyousure'))) {
			return false;
		}

		e.preventDefault();
		var $container = $(this).closest('.inbox-monitor-module');
		var href = $(this).data('href');
		var $checked = $('.inbox-monitor-checkbox:visible:checked', $container);
		var guids = [];
		$checked.each(function() {
			guids.push($(this).val());
		});
		elgg.action(href, {
			data: {
				guids: guids
			},
			beforeSend: spinner.start,
			complete: spinner.stop,
			success: function (response) {
				if (response.status >= 0 && response.output.clear) {
					$.each(response.output.clear, function(index, value) {
						$('#elgg-object-' + value).fadeOut().remove();
					});
					toggleUiElements($container);
					$container.find('.elgg-list').trigger('refresh');
				}
			}
		});
	});

});
