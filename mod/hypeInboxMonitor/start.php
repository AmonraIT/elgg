<?php

/**
 * Inbox monitor
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2016, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init', 'system', 'hypeapps_inbox_monitor_init');

/**
 * Initialize the plugin
 * @return void
 */
function hypeapps_inbox_monitor_init() {

	elgg_extend_view('css/elgg', 'admin/inbox/monitor.css');
	elgg_extend_view('css/admin', 'admin/inbox/monitor.css');

	elgg_register_event_handler('create', 'object', 'hypeapps_inbox_monitor_flag_suspicious_messages', 999);

	elgg_register_action('inbox/monitor/delete', __DIR__ . '/actions/inbox/monitor/delete.php', 'admin');

	elgg_extend_view('object/messages', 'object/messages/warning', 400);

	elgg_register_menu_item('admin', array(
		'name' => 'inbox-monitor',
		'href' => "admin/inbox/monitor",
		'text' => elgg_echo('admin:inbox:monitor'),
		'section' => 'administer',
		'parent_name' => 'administer_utilities',
	));
}

/**
 * Flag suspicious messages
 *
 * @param string     $event  "create"
 * @param string     $type   "object"
 * @param ElggObject $entity Message
 * @return void
 */
function hypeapps_inbox_monitor_flag_suspicious_messages($event, $type, $entity) {

	if ($entity->getSubtype() != 'messages') {
		return;
	}

	$policy = elgg_get_plugin_setting('policy', 'hypeInboxMonitor', 'nothing');

	$blacklist = hypeapps_inbox_monitor_get_blacklist();

	$options = array(
		'also_check' => $blacklist,
	);

	$filter = new \JCrowe\BadWordFilter\BadWordFilter($options);

	$badWords = $filter->getDirtyWordsFromString("$entity->title $entity->description");
	$entity->badwords = $badWords;

	switch ($policy) {
		case 'mask' :
			$entity->title = $filter->clean($entity->title);
			$entity->description = $filter->clean($entity->title);
			break;

		case 'silence' :
			$replacement = '<span rel="bwsilent">$0</span>';
			$entity->title = $filter->clean($entity->title, $replacement);
			$entity->description = $filter->clean($entity->description, $replacement);
			break;
		
		case 'remove' :
			$replacement = '<span rel="bwremoved">[' . elgg_echo('inbox:monitor:removed') . ']</span>';
			$entity->title = $filter->clean($entity->title, $replacement);
			$entity->description = $filter->clean($entity->description, $replacement);
			break;
	}

	$entity->save();
}

/**
 * Returns blacklisted words
 * @return array
 */
function hypeapps_inbox_monitor_get_blacklist() {

	$blacklist = elgg_get_plugin_setting('blacklist', 'hypeInboxMonitor', '');
	$blacklist = explode(PHP_EOL, $blacklist);
	$blacklist = array_map('trim', $blacklist);
	$blacklist = array_filter($blacklist);
	$blacklist = array_map('strip_tags', $blacklist);
	$blacklist = array_map('strtolower', $blacklist);
	$blacklist = array_unique($blacklist);

	sort($blacklist);

	return $blacklist;
}
