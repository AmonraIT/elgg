<?php

$terms_page_url = elgg_view('output/url', [
	'text' => elgg_echo('expages:terms'),
	'href' => elgg_get_site_url() . '/terms',
	'is_trusted' => true,
]);

echo elgg_echo('cookiebanner:message', [$terms_page_url]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('cookiebanner:accept'),
	'name' => 'btnCookieOk',
	'class' => 'eu-cookie-message-button',
]);

elgg_set_form_footer($footer);
