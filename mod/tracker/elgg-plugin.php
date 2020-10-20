<?php

return [
	'bootstrap' => \Tracker\Bootstrap::class,
	'routes' => [
		'collection:tracker:ip' => [
			'path' => '/tracker/view/{ip}',
			'resource' => 'tracker/view',
		],
	],
];
