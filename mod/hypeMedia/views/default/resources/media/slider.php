<?php

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object');

$entity = get_entity($guid);
if (!$entity instanceof \hypeJunction\Media\MediaCollection) {
	throw new \Elgg\EntityNotFoundException();
}

$content = elgg_view('media/slider', [
	'entity' => $entity,
	'selected' => elgg_extract('selected', $vars),
]);

if (get_input('iframe', false)) {
	echo elgg_view_page('', $content, 'default', [
		'sections' => [
			'body' => elgg_view('page/elements/body', [
				'body' => $content,
			]),
		],
		'page_attrs' => [
			'class' => 'page-media-slider',
		],
	]);
	return;
}

elgg_push_entity_breadcrumbs($entity);

$title = $entity->getDisplayName();

$layout = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'sidebar' => false,
	'class' => 'media-slider-layout',
	'entity' => $entity,
]);

echo elgg_view_page($title, $layout, 'default', [
	'header' => false,
]);