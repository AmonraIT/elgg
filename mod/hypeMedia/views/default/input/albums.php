<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view('input/autocomplete', [
	'match_on' => 'media_albums',
	'options' => [
		'target_guid' => $entity->container_guid,
	],
]);