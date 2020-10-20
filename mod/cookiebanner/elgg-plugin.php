<?php

return [
	'actions' => [
		'cookiebanner/agree' => ['access' => 'public'],
	],
	'view_extensions' => [
		'css/elgg' => [
			'cookiebanner/css' => [],
		],
		'page/elements/head' => [
			'cookiebanner/cookiebanner' => [],
		],
	],
];
