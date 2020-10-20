<?php

return [
	'bootstrap' => \AvatarWallBootstrap::class,
	'routes' => [
		'avatar_wall' => [
			'path' => '/avatar_wall/{tab?}',
			'resource' => 'avatar_wall/wall',
		],
	],
	'settings' => [
		'maxIcons' => 300,
		'onlyWithAvatar' => 'yes',
		'wallIconSize' => 'small',
	],
	'view_extensions' => [
		'css/elgg' => [
			'avatar_wall/css' => [],
		],
	],
];
