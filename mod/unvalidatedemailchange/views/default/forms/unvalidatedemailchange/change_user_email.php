<?php

$user_guid = elgg_extract('user_guid', $vars);
$user_name = elgg_extract('user_name', $vars);
$user_email = elgg_extract('user_email', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'user_guid',
	'value' => $user_guid,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('unvalidatedemailchange:new_user_email', [$user_name]),
	'name' => 'new_email',
	'value' => $user_email,
	'required' => true,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('unvalidatedemailchange:change_email'),
]);

elgg_set_form_footer($footer);
