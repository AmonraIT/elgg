<?php

/**
 * set_no_notification
 *
 * @author Gustavo Bellino
 * @link http://community.elgg.org/pg/profile/gushbellino
 * @copyright (c) Keetup 2010
 * @link http://www.keetup.com/
 * @license GNU General Public License (GPL) version 2
 *
 * updated and modified for Elgg 1.8 and newer by iionly
 * (c) iionly
 */

$plugin = $vars['entity'];

// quantity of users
$users_count = elgg_get_entities([
	'type' => 'user',
	'count' => true,
]);

// users with set notifications disabled
$users_count_true = elgg_get_entities([
	'metadata_name' => 'notification:method:email',
	'metadata_value' => true,
	'count' => true,
]);
$user_count_true_percentage = $users_count_true * 100 / $users_count;

// users with set notifications enabled
$users_count_false = $users_count - $users_count_true;
$user_count_false_percentage = 100 - $user_count_true_percentage;

if (!isset($plugin->setNoNotif_type)) {
	$plugin->setNoNotif_type = 'a';
	$plugin->setNoNotif_time = mktime(0, 0, 0, 0, 0, 1900);
}

if ($plugin->setNoNotif_type == 'a') {
	$plugin->setNoNotif_time = mktime(0, 0, 0, 0, 0, 1900);
} else {
	$plugin->setNoNotif_time = time();
}

echo elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('set_no_notifications:choose:type'),
	'#help' => elgg_echo('set_no_notifications:description'),
	'name' => 'params[setNoNotif_type]',
	'value' => $plugin->setNoNotif_type,
	'options' => [
		elgg_echo('set_no_notifications:choose:type:a') => 'a',
		elgg_echo('set_no_notifications:choose:type:b') => 'b'
	],
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name'=> 'params[setNoNotif_time]',
	'value' => $plugin->setNoNotif_time,
]);

$content = elgg_format_element('li', [], elgg_echo('set_no_notifications:enabled') . $users_count_true . ' (' . round($user_count_true_percentage, 2) . '%)');
$content .= elgg_format_element('li', [], elgg_echo('set_no_notifications:disabled') . $users_count_false . ' (' . round($user_count_false_percentage, 2) . '%)');
$content = elgg_format_element('ul', [], $content);
$label = elgg_format_element('label', [], elgg_echo('set_no_notifications:statistics'));
$content = $label . $content;
echo elgg_format_element('div', [], $content);
