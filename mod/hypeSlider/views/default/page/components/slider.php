<?php

/**
 * Generates a new slider
 *
 * @uses $vars['slides'] An array of slide views
 * @uses $vars['slick']  An array of slick slider settings
 */
elgg_load_css('slick');
elgg_load_css('slick-theme');
elgg_load_css('elgg.slick');

elgg_require_js('page/components/slider');

$slides = elgg_extract('slides', $vars);

if (empty($slides)) {
	return;
}

$slick = elgg_extract('slick', $vars);

$slider = '';
foreach ($slides as $slide) {
	$slider .= elgg_format_element('div', array(
		'class' => 'elgg-slick-slide',
			), $slide);
}

echo elgg_format_element('div', array(
	'class' => 'elgg-slick-slider elgg-state-loading',
	'data-slick' => (!empty($slick) && is_array($slick)) ? json_encode($slick) : false,
		), $slider);
