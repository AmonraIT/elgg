<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggFile) {
	return;
}

$svc = new \hypeJunction\Media\ExtractExifTags();
$exif = $svc->getData($entity);

if (empty($exif)) {
	return;
}

$output = '';

foreach ($exif as $key => $values) {
	$output .= elgg_view('post/output/field', [
		'#label' => $values['label'],
		'value' => $values['clean'],
	]);
}

echo elgg_view('post/module', [
	'title' => elgg_echo('media:exif'),
	'body' => $output,
	'collapsed' => true,
	'class' => 'post-exif has-list',
]);