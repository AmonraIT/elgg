<?php
/**
 * Wrapped for a select input with predefined colors
 *
 * @see input/dropdown
 */

$options_values = array(
	'' => elgg_echo('promo_widget:background:select'),
	'promo-widget-light-blue' => elgg_echo('promo_widget:background:light_blue'),
	'promo-widget-blue' => elgg_echo('promo_widget:background:blue'),
	'promo-widget-light-grey' => elgg_echo('promo_widget:background:light_grey'),
	'promo-widget-grey' => elgg_echo('promo_widget:background:grey'),
	'promo-widget-dark-grey' => elgg_echo('promo_widget:background:dark_grey')
);

$vars['options_values'] = $options_values;

echo elgg_view('input/dropdown', $vars);
