<?php

/**
 * Unvalidatedemailchange plugin
 * (c) iionly 2012
 * Contact: iionly@gmx.de
 * Website: https://github.com/iionly
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

elgg_register_event_handler('init', 'system', 'unvalidatedemailchange_init');

function unvalidatedemailchange_init() {
	elgg_register_ajax_view('unvalidatedemailchange/change_email');
	elgg_register_plugin_hook_handler('register', 'menu:user:unvalidated', 'unvalidatedemailchange_menu');
}

function unvalidatedemailchange_menu(\Elgg\Hook $hook) {
	if (!elgg_is_admin_logged_in()) {
		return;
	}

	$entity = $hook->getEntityParam();
	if (!$entity instanceof ElggUser) {
		return;
	}

	$return = $hook->getValue();

	$return[] = ElggMenuItem::factory([
		'name' => 'unvalidatedemailchange:change_email',
		'text' => elgg_echo('unvalidatedemailchange:change_email'),
		'href' => elgg_http_add_url_query_elements('ajax/view/unvalidatedemailchange/change_email', [
			'user_guid' => $entity->guid,
			'user_name' => $entity->name,
			'user_email' => $entity->email,
		]),
		'class' => 'elgg-lightbox',
		'priority' => 101,
	]);

	return $return;
}
