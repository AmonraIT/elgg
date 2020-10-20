<?php

$entity = elgg_extract('entity', $vars);

if (empty($vars['full_view'])) {
	return;
}
if (empty($entity->badwords)) {
	return;
}

echo elgg_format_element('div', array(
	'class' => 'inbox-monitor-user-warning',
), elgg_echo('inbox:monitor:flagged'));

