<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Media\MediaCollection) {
	return;
}

$limit = elgg_extract('limit', $vars, 12);

$collection = $entity->getMedia();

$count = $collection->getList()->count();

if (!$count) {
	if ($entity->canWriteToContainer()) {
		echo elgg_view('input/media/upload', $vars);
	}

	return;
}

$items = $collection->getList()->batch($limit);

echo elgg_view('media/grid', [
	'items' => $items,
	'count' => $count,
]);
