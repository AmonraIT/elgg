<?php

elgg_register_event_handler('init','system','email_postscript_init');

/**
 * Initialise the Email Postscript plugin
 *
 */
function email_postscript_init() {

	// Register a hook to add the postscript text to email notifications
	elgg_register_plugin_hook_handler('email', 'system', 'email_postscript_handler', 999);
}


/**
 * Add the postscript text to the body of email notifications
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function email_postscript_handler($hook, $type, $returnvalue, $params) {

	if (!is_array($returnvalue) || !is_array($returnvalue['params'])) {
		// another hook handler returned a non-array, let's not override it
		return;
	}

	$to_address = '';
	$contact = $returnvalue['to'];
	$containsName = preg_match('/<(.*)>/', $contact, $matches) == 1;
	if ($containsName) {
		$to_address = $matches[1];
	} else {
		$to_address = $contact;
	}

	if (!$to_address) {
		return $returnvalue;
	}

	$users = get_user_by_email($to_address);
	$recipient = $users[0];

	if (!($recipient instanceof ElggUser)) {
		return $returnvalue;
	}

	$site_url = elgg_get_site_url();
	$notification_settings_url = $site_url . '/notifications/personal/' . $recipient->username;
	$group_notification_settings_url =  $site_url . '/notifications/group/' . $recipient->username;
	$recipient_language = ($recipient->language) ? $recipient->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');

	$returnvalue['body'] = $returnvalue['body'] . elgg_echo('email_postscript:content', [$notification_settings_url, $group_notification_settings_url], $recipient_language);

	return $returnvalue;
}
