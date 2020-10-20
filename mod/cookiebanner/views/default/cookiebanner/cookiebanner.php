<?php

if ($_COOKIE['eu-cookie'] != '1' && !elgg_is_admin_logged_in()) {
	$form_vars = [
		'action' => 'action/cookiebanner/agree',
	];

	$content .= elgg_view_form('cookiebanner/agree', $form_vars);

	echo elgg_format_element('div', ['id' => 'eu-cookie-message'], $content);
}
