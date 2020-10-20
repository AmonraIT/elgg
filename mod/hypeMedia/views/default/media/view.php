<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \hypeJunction\Media\MediaObject) {
	return;
}

if ($entity instanceof \hypeJunction\Media\MediaFile) {
	if (\hypeJunction\Media\Converter::instance()->isConvertible($entity)) {
		$view = elgg_view('media/players/videojs', $vars);
	} else {
		if ($entity->hasIcon('master') && $entity->getIcon('large')->getSize()) {
			$bg_url = $entity->getIconURL('master');
		} else if ($entity->getSimpleType() === 'image') {
			$bg_url = elgg_get_inline_url($entity, true);
		}

		$view = elgg_format_element('div', [
			'class' => 'media-album-item-thumb',
			'style' => "background-image:url($bg_url)"
		]);
	}
} else if ($entity instanceof \hypeJunction\Media\MediaImport) {
	$view = elgg_view('output/player', [
		'href' => $entity->web_location,
	]);
}

echo elgg_format_element('div', [
	'class' => 'media-album-item',
], $view);
