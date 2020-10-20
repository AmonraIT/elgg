<?php

$items = elgg_extract('items', $vars);
$count = elgg_extract('count', $vars);

if (!$items) {
	return;
}

foreach ($items as $item) {
	/* @var $item ElggEntity */

	$thumb = elgg_view('output/img', [
		'src' => $item->getIconURL([
			'size' => 'small',
			'use_cookie' => false,
		]),
	]);

	$list .= elgg_format_element('div', [
		'class' => 'elgg-item mas',
	], $thumb);
}

echo elgg_format_element('div', [
	'class' => 'elgg-gallery',
], $list);