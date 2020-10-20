<?php

/**
 * Unvalidatedemailchange plugin
 * (c) iionly 2012
 * Contact: iionly@gmx.de
 * Website: https://github.com/iionly
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

$user_guid = elgg_extract('user_guid', $vars);
$user_name = elgg_extract('user_name', $vars);
$user_email = elgg_extract('user_email', $vars);

$form_vars = [
	'action' => "action/unvalidatedemailchange/change_user_email",
	'class' => 'elgg-form-settings',
];
$body_vars = [
	'user_guid' => $user_guid,
	'user_name' => $user_name,
	'user_email' => $user_email,
];

echo elgg_view_form('unvalidatedemailchange/change_user_email', $form_vars, $body_vars);
