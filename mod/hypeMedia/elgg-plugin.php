<?php

require_once __DIR__ . '/autoloader.php';

$conf = [
	'bootstrap' => \hypeJunction\Media\Bootstrap::class,

	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'media_album',
			'class' => \hypeJunction\Media\MediaAlbum::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => 'media_file',
			'class' => \hypeJunction\Media\MediaFile::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => 'media_import',
			'class' => \hypeJunction\Media\MediaImport::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => 'media_batch',
			'class' => \hypeJunction\Media\MediaBatch::class,
			'searchable' => true,
		],
	],
];

$conf['routes'] = [
	'add:object:media_album' => [
		'path' => '/media/add/{guid}',
		'resource' => 'post/add',
		'defaults' => [
			'type' => 'object',
			'subtype' => 'media_album',
		],
	],
	'edit:object:media_album' => [
		'path' => '/media/edit/{guid}',
		'resource' => 'post/edit',
	],
	'edit:object:media_album:upload' => [
		'path' => '/media/upload/{guid}',
		'resource' => 'media/upload',
	],
	'view:object:media_album' => [
		'path' => '/media/view/{guid}/{title?}',
		'resource' => 'post/view',
	],
	'view:object:media_album:slider' => [
		'path' => '/media/slider/{guid}/{selected?}/{title?}',
		'resource' => 'media/slider',
	],
	'collection:object:media_album:all' => [
		'path' => '/media/all',
		'resource' => 'collection/all',
	],
	'collection:object:media_album:owner' => [
		'path' => '/media/owner/{username?}',
		'resource' => 'collection/owner',
	],
	'collection:object:media_album:friends' => [
		'path' => '/media/friends/{username?}',
		'resource' => 'collection/friends',
	],
	'collection:object:media_album:group' => [
		'path' => '/media/group/{guid}',
		'resource' => 'collection/group',
	],
];

$media_types = [
	'media_file',
	'media_import',
];

foreach ($media_types as $media_type) {
	$conf['routes']["add:object:$media_type"] = [
		'path' => "/media/upload/{guid}",
		'resource' => 'post/add',
		'defaults' => [
			'type' => 'object',
			'subtype' => $media_type,
		],
	];

	$conf['routes']["edit:object:$media_type"] = [
		'path' => "/media/edit/{guid}",
		'resource' => 'post/edit',
	];

	$conf['routes']["view:object:$media_type"] = [
		'path' => '/media/view/{guid}/{title?}',
		'resource' => 'post/view',
	];

	$conf['routes']["info:object:$media_type"] = [
		'path' => '/media/info/{guid}/{title?}',
		'resource' => 'media/info',
		'middleware' => [
			\Elgg\Router\Middleware\AjaxGatekeeper::class,
		],
	];
}

$plugin_root = __DIR__;
$root = dirname(dirname($plugin_root));
$alt_root = dirname(dirname(dirname($root)));

if (file_exists("$plugin_root/vendor/autoload.php")) {
	$path = $plugin_root;
} else if (file_exists("$root/vendor/autoload.php")) {
	$path = $root;
} else {
	$path = $alt_root;
}

$conf['views'] = [
	'default' => [
		'slick/' => $path . '/vendor/bower-asset/slick-carousel/slick/',
		'videojs/' => $path . '/vendors/video-js-6.8.0/',
		'hammer.js' => $path . '/vendor/bower-asset/hammerjs/hammer.min.js',
	],
];

$conf['widgets'] = [
	'media_albums' => [
		'context' => ['profile', 'dashboard', 'group'],
	],
];

return $conf;