<?php

$entity = elgg_extract('entity', $vars);
/* @var $entity ElggEntity */

if (!$entity instanceof \hypeJunction\Media\MediaObject) {
	return;
}

$album = elgg_extract('album', $vars);
if (!$album) {
	$album_count = $entity->getCollections(['count' => true]);

	if ($album_count === 1) {
		$albums = $entity->getCollections();
		$album = array_shift($albums);
	}
}

if ($entity instanceof \hypeJunction\Media\MediaFile) {
	if ($entity->hasIcon('large') && $entity->getIcon('large')->getSize()) {
		$bg_url = $entity->getIconURL('large');
	} else if ($entity->hasIcon('master') && $entity->getIcon('large')->getSize()) {
		$bg_url = $entity->getIconURL('master');
	} else if ($entity instanceof ElggFile && $entity->getSimpleType() === 'image') {
		$bg_url = elgg_get_inline_url($entity, true);

		if (elgg_is_active_plugin('hypeShutdown')) {
			// Try to create the thumbnail again on shutdown
			elgg_register_event_handler('shutdown', 'system', function () use ($entity) {
				$entity->saveIconFromElggFile($entity);
			});
		}
	}
} else if ($entity instanceof \hypeJunction\Media\MediaImport) {
	$location = new \hypeJunction\Scraper\WebLocation($entity->web_location);
	$bg_url = $location->getData()->thumbnail_url;
}

$view = elgg_format_element('div', [
	'class' => 'media-album-item-thumb',
	'style' => "background-image:url($bg_url)"
]);

if (elgg_extract('use_link', $vars) !== false) {
	if ($album) {
		$view = elgg_view('output/url', [
			'href' => elgg_generate_entity_url($album, 'view', 'slider', [
				'selected' => $entity->guid,
			]),
			'text' => $view,
		]);
	} else {
		$view = elgg_view('output/url', [
			'href' => elgg_generate_entity_url($entity, 'info', null, [
				'is_lightbox' => true,
			]),
			'text' => $view,
			'class' => 'elgg-lightbox elgg-lightbox-photo',
		]);
	}
}

echo elgg_format_element('div', [
	'class' => 'media-album-item',
	'data-guid' => $entity->guid,
	'data-album-guid' => $album->guid,
], $view);