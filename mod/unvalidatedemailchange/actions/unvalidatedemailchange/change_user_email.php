<?php

/**
 * Unvalidatedemailchange plugin
 * iionly
 * Contact: iionly@gmx.de
 *
 * The Unvalidatedemailchange is based on:
 *
 * @package simpleusermanagement
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pjotr Savitski
 * @copyright (C) Pjotr Savitski
 * @link http://code.google.com/p/simpleusermanagement/
 **/

// Set access status to perform needed operation
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$user_guid = (int) get_input('user_guid');
$new_email = get_input('new_email', '');
$user = get_entity($user_guid);

if (!($user instanceof ElggUser)) {
	access_show_hidden_entities($access_status);
	return elgg_error_response(elgg_echo('unvalidatedemailchange:no_user_guid_provided'), REFERER);
}

if (empty($new_email)) {
	access_show_hidden_entities($access_status);
	return elgg_error_response(elgg_echo('unvalidatedemailchange:no_email_address_provided'), REFERER);
}

if (!is_email_address($new_email)) {
	access_show_hidden_entities($access_status);
	return elgg_error_response(elgg_echo('unvalidatedemailchange:email_address_invalid', [$new_email]), REFERER);
}

// Change user email
$user->email = $new_email;
$user->save();

access_show_hidden_entities($access_status);

return elgg_ok_response('', elgg_echo('unvalidatedemailchange:user_email_changed_to', [$user->name, $new_email]), REFERER);
