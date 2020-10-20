<?php

$selected_tab = elgg_extract('tab', $vars);
$tabs = ['today', 'week', 'all'];
$selected_tab = (in_array($selected_tab, $tabs)) ? $selected_tab : 'today';
$params = [
	'tabs' => [],
];

foreach ($tabs as $tab) {
	$params['tabs'][] = [
		'text' => elgg_echo("avatar_wall:{$tab}"),
		'href' => "avatar_wall/{$tab}",
		'selected' => ($tab === $selected_tab),
	];
}

$content = elgg_view('navigation/tabs', $params);

if (elgg_view_exists("avatar_wall/{$selected_tab}")) {
	$content .= elgg_view("avatar_wall/{$selected_tab}");
}

$title = elgg_echo('avatar_wall:title');

// Format page
$body = elgg_view('page/layouts/default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
	'breadcrumbs' => [
		[
			'text' => elgg_echo('avatar_wall:title'),
			'href' => 'avatar_wall/today',
		],
	],
]);

// Draw it
echo elgg_view_page($title, $body);
