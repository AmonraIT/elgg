<?php
?>
//<script>
elgg.provide('elgg.promo_widget');

elgg.promo_widget_change_type = function(elem) {

	var $wrapper = $(elem).parents('.elgg-module:first');
	var value = $(elem).val();
	
	$wrapper.find('.promo-widget-type').addClass('hidden');
	$wrapper.find('.promo-widget-type-' + value).removeClass('hidden');
};
