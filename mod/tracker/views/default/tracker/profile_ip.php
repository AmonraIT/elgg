<?php
/**
 * Elgg Tracker plugin
 * @license: GPL v 2.
 * @author slyhne
 * @copyright Zurf.dk
 * @link http://zurd.dk/elgg
 */

// Only admins should see this
if (elgg_is_admin_logged_in()) {
	// Get GUID of the user who owns this profile
	$owner_guid = $vars['entity']->guid;
 
	// Get owner entity
	$owner = get_user($owner_guid);
 
	// Get IP address
	$ip_address = $owner->ip_address;
	if (empty($ip_address)) {
		// Display error text
		$link = elgg_echo('tracker:none:recorded');
	} else {
		// Create for IP information
		$link = elgg_view('output/url', [
					'text' => $ip_address,
					'href' => "tracker/view/{$ip_address}",
					'title' => elgg_echo('tracker:moreinfo'),
					'is_trusted' => true,
					'target' => '_blank',
					]);
					
	}

	// Display IP address
	$output = elgg_view('object/elements/field', [
		'label' => elgg_echo("tracker:ip"),
		'value' => elgg_format_element('span', ['class' => $class], $link),
		'name' => 'tracker',
	]);
	
	echo elgg_format_element('div', ['class' => 'elgg-profile-fields'], $output);
}


