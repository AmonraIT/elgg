<?php
/**
 * Provides theme and modifications.
 */


/**
 * Modify owner menu items
 *
 * @param \Elgg\Hook $hook Hook information
 *
 * @return void|\ElggMenuItem[]
 *
 * @internal
 * @since 3.0
 */
function tracker_admin_hover_menu(\Elgg\Hook $hook) {
	$user = $hook->getEntityParam();
	if (!$user) {
		return;
	}
	if (!$user instanceof \ElggUser) {
		return;
	}

	if (!elgg_is_admin_logged_in()) {
		return $return;
	}
	
	$return = $hook->getValue();

	// Get IP address
	$ip_address = $user->ip_address;

	$return[] = ElggMenuItem::factory([
		'name' => 'tracker',
		'text' => elgg_echo('tracker:adminlink'),
		'icon' => elgg_view_icon('network-wired'),
		'href' => elgg_generate_url('collection:tracker:ip', ['ip' => $ip_address]),
		'section' => 'admin',
	]);

	return $return;


}

