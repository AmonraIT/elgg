<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Media\MediaBatch) {
	return;
}

$limit = elgg_extract('limit', $vars, 12);

$count = $entity->getItems(['count' => true]);
if (!$count) {
	return;
}

$items = $entity->getItems(['limit' => $limit]);

echo elgg_view('media/grid', [
	'items' => $items,
	'count' => $count,
]);
