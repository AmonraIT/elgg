<?php

$items = elgg_extract('items', $vars);
$count = elgg_extract('count', $vars);

if (!$items) {
	return;
}

$thumbs = '';

foreach ($items as $item) {
	$thumbs .= elgg_view('media/thumb', [
		'entity' => $item,
		'album' => $entity,
	]);
}

if ($limit && $count > $limit) {
	$more = $count - $limit;
	$link = elgg_view('output/url', [
		'href' => $entity->getURL(),
		'text' => "+{$more}",
	]);

	$thumbs .= elgg_format_element('div',[
		'class' => 'media-album-item media-album-more',
	], $link);
}

echo elgg_format_element('div', [
	'class' => 'media-album-grid',
], $thumbs);