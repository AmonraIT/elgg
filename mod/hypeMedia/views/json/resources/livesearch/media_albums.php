<?php

elgg_gatekeeper();

$limit = get_input('limit', elgg_get_config('default_limit'));
$query = get_input('term', get_input('q'));

$target_guid = (int) get_input('target_guid');
$target = get_entity($target_guid);

$options = [
	'query' => $query,
	'type' => 'object',
	'subtype' => 'media_album',
	'limit' => $limit,
	'sort' => 'title',
	'order' => 'ASC',
	'fields' => ['metadata' => ['title']],
];

if ($target instanceof ElggGroup) {
	$options['container_guid'] = $target->guid;
} else {
	$options['owner_guid'] = $target->guid ? : elgg_get_logged_in_user_guid();
}

$albums = elgg_search($options) ? : [];

foreach ($albums as $key => $album) {
	if (!$album->canWriteToContainer()) {
		unset($albums[$key]);
	}
}

elgg_set_http_header("Content-Type: application/json;charset=utf-8");

echo elgg_list_entities($albums, [
	'item_view' => 'search/entity',
]);



