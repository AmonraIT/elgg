<?php
$query = elgg_extract('query', $vars);
$entity = elgg_extract('entity', $vars);
/* @var $entity ElggObject */

$size = elgg_extract('size', $vars, 'small');

$type = $entity->getType();
$subtype = $entity->getSubtype();
$recipient = $entity->getOwnerEntity();
$sender = get_entity($entity->fromId);

$display_name = $entity->getDisplayName() ? : $entity->title;
if (!$display_name) {
	$display_name = elgg_get_excerpt($entity->description, 50);
}

if ($query) {
	$title = search_get_highlighted_relevant_substrings($display_name, $query);
	$entity->setVolatileData('search_matched_title', $title);
} else {
	$entity->setVolatileData('search_matched_title', $display_name);
}

$flag = '';
if ($entity->badwords) {
	$flag = elgg_view_icon('inbox-monitor-red-flag');
}
$title = elgg_view('output/url', array(
	'text' => $entity->getVolatileData('search_matched_title'),
	'href' => $entity->getURL(),
		));

$content .= elgg_format_element('strong', array(
	'class' => $entity->badwords ? 'inbox-monitor-flagged' : '',
		), $flag . $title);

if ($query) {
	$desc = search_get_highlighted_relevant_substrings($entity->description, $query);
	$entity->setVolatileData('search_matched_description', '<div>' . $desc . '</div>');
} else {
	$desc = elgg_view('output/longtext', array(
		'value' => $entity->description,
	));
	$entity->setVolatileData('search_matched_description', $desc);
}

$content .= $entity->getVolatileData('search_matched_description');

$subtitle = elgg_echo('inbox:monitor:subtitle', array(
	$sender->getDisplayName(),
	$recipient->getDisplayName(),
	elgg_view_friendly_time($entity->time_created),
		));

$metadata = elgg_view_menu('entity', array(
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
		));

$sender_icon = elgg_view_entity_icon($sender, $size);
$recipient_icon = elgg_view_entity_icon($recipient, $size);

$summary = elgg_view("$type/elements/summary", array(
	'entity' => $entity,
	'tags' => false,
	'title' => false,
	'subtitle' => $subtitle,
	'content' => $content,
	'metadata' => $metadata,
		));

$checkbox = elgg_format_element('input', array(
	'type' => 'checkbox',
	'name' => 'guids[]',
	'value' => $entity->guid,
	'class' => 'inbox-monitor-checkbox',
		));

$image = $checkbox . $sender_icon . elgg_view_icon('inbox-monitor-to') . $recipient_icon;
$view = elgg_view_image_block($image, $summary);
?>
<div class="inbox-monitor-list-item" data-guid="<?= $entity->guid ?>">
	<?= $view ?>
</div>
