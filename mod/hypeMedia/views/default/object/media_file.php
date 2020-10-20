<?php

$entity = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars, false);

if ($full) {
	$vars['cover'] = false;
	$vars['attachments'] = elgg_view('media/view', $vars);
	echo elgg_view('post/elements/full', $vars);
} else {
	echo elgg_view('media/thumb', $vars);
}
