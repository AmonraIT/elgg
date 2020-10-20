<?php

$entity = elgg_extract('entity', $vars);

$full = elgg_extract('full_view', $vars, false);
$is_gallery = elgg_in_context('gallery');
$is_widget = elgg_in_context('widgets');

if ($full) {

	$vars['limit'] = 0;
	$vars['attachments'] = elgg_view('object/media_album/elements/grid', $vars);

	echo elgg_view('post/elements/full', $vars);
} else if ($is_widget) {

	$vars['limit'] = 8;
	$vars['content'] = elgg_view('object/media_album/elements/grid', $vars);

	echo elgg_view('post/elements/summary', $vars);
} else if ($is_gallery) {

	echo elgg_view('post/elements/card', $vars);
} else {

	$vars['limit'] = elgg_in_context('activity') ? 8 : 12;
	$vars['content'] = elgg_view('object/media_album/elements/grid', $vars);

	echo elgg_view('post/elements/summary', $vars);
}