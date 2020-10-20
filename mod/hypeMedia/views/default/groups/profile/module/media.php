<?php

$group = elgg_extract('entity', $vars);
if (!$group instanceof ElggGroup) {
	return;
}

if (!$group->isToolEnabled('media')) {
	return;
}

$all_link = elgg_view('output/url', [
	'href' => elgg_generate_url('collection:object:media_album:group', [
		'guid' => $group->guid,
	]),
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
]);

$collection = elgg_get_collection('collection:media:group', $group);

elgg_push_context('widgets');
$content = $collection->render($vars);
elgg_pop_context();


echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('collection:object:media_album:all'),
	'content' => $content,
	'all_link' => $all_link,
]);
