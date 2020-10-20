<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('media:settings:ffmpeg_bin'),
	'#help' => elgg_echo('media:settings:ffmpeg_bin:help'),
	'name' => 'params[ffmpeg_bin]',
	'value' => $entity->ffmpeg_bin,
]);