<?php

$ip_address = elgg_extract('ip', $vars);

$title = elgg_echo('tracker:title', [$ip_address]);

$json_result = file_get_contents('http://ip-api.com/json/' . $ip_address);

$result = json_decode($json_result, true);

$content = elgg_format_element('h3', [], elgg_echo('tracker:moreinfo'));

if ($result['status'] != 'success') {
	$content .= elgg_format_element('p', ['class' => 'elgg-no-results'], elgg_echo('tracker:info:none'));
} else {
	foreach($result as $key => $val) {
		$label = elgg_format_element('td', ['class' => 'tracker-label'], $key);
		$value = elgg_format_element('td', ['class' => ''], $val);
		$tr .= elgg_format_element('tr', ['class' => ''], $label . $value);
	}
	$content .= elgg_format_element('table', ['class' => 'elgg-table-alt'], $tr);
}

$content .= elgg_format_element('h3', [], elgg_echo('tracker:users'));

$content .= elgg_list_entities([
	'type' => 'user',
	'metadata_name_value_pairs' => ['ip_address' => $ip_address],
	'no_results' => elgg_echo('tracker:users:none'),
	'full_view' => false,
	'pagination' => true,
]);

echo elgg_view_page($title, [
	'content' => $content,
	'show_owner_block_menu' => false,
]);
