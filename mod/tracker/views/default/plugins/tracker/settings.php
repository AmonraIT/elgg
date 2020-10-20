<?php
/**
 * Elgg Tracker plugin
 * @license: GPL v 2.
 * @author slyhne
 * @copyright Zurf.dk
 * @link http://zurd.dk/elgg
 */

if (!$vars['entity']->tracker_display) {
	$vars['entity']->tracker_display = "profile";
}
 
echo elgg_format_element('hr', [], false);

echo elgg_view_field([
	'#type' => 'dropdown',
	'name' => 'params[tracker_display]',
	'value' => $vars['entity']->tracker_display,
	'#label' => elgg_echo('tracker:display'),
	'options_values' => [
		'profile' => elgg_echo('tracker:display:profile'),
		'adminmenu' => elgg_echo('tracker:display:adminmenu'),
	],
]);

