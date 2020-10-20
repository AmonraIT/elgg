<?php

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
if (!$object instanceof \hypeJunction\Media\MediaBatch) {
	return;
}

$album = $object->getAlbum();
if (!$album instanceof \hypeJunction\Media\MediaCollection) {
	return;
}

$owner = $object->getOwnerEntity();
if (!$owner) {
	return;
}

$album_link = elgg_view('output/url', [
	'href' => $album->getURL(),
	'text' => $album->getDisplayName(),
]);

$owner_link = elgg_view('output/url', [
	'href' => $owner->getURL(),
	'text' => $owner->getDisplayName(),
]);

$count = $object->getItems(['count' => true]);

$vars['summary'] = elgg_echo('river:object:media_batch:create', [$owner_link, $count, $album_link]);

$attachment = elgg_view('object/media_batch/elements/grid', [
	'entity' => $object,
]);

$vars['attachments'] = elgg_format_element('div', [
	'class' => 'elgg-river-attachment',
], $attachment);

echo elgg_view('river/elements/layout', $vars);