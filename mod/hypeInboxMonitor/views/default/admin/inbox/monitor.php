<?php

// Get all received messages fromId != owner_guid
$dbprefix = elgg_get_config('dbprefix');
$fromId = elgg_get_metastring_id('fromId');

echo elgg_view('admin/inbox/search');

$query = get_input('query');

$options = array(
	'types' => 'object',
	'subtypes' => 'messages',
	'joins' => array(
		"JOIN {$dbprefix}metadata md ON md.entity_guid = e.guid AND md.name_id = $fromId",
		"JOIN {$dbprefix}metastrings fromId ON fromId.id = md.value_id",
	),
	'wheres' => array(
		'fromId.string != e.owner_guid',
	),
	'preload_owners' => true,
	'no_results' => elgg_echo('inbox:monitor:no_results'),
	'item_view' => 'object/messages/admin',
);

if ($query) {
	$query = sanitize_string($query);
	$options['query'] = $query;

	$options['joins'][] = "JOIN {$dbprefix}objects_entity oe ON e.guid = oe.guid";

	$fields = array('title', 'description');
	$where = search_get_where_sql('oe', $fields, $options);

	$options['wheres'][] = $where;
}

$module = elgg_view('object/messages/controls');

$module .= elgg_list_entities($options);

echo elgg_format_element('div', array(
	'class' => 'inbox-monitor-module',
		), $module);

