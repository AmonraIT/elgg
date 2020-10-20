<?php

namespace hypeJunction\Media;

use Elgg\Includer;
use Elgg\PluginBootstrap;
use Elgg\Values;

class Bootstrap extends PluginBootstrap {

	/**
	 * Get plugin root
	 * @return string
	 */
	protected function getRoot() {
		return $this->plugin->getPath();
	}

	/**
	 * {@inheritdoc}
	 */
	public function load() {
		Includer::requireFileOnce($this->getRoot() . '/autoloader.php');
	}


	/**
	 * {@inheritdoc}
	 */
	public function boot() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		elgg_register_collection('collection:object:media_album:all', DefaultAlbumCollection::class);
		elgg_register_collection('collection:object:media_album:owner', OwnedAlbumCollection::class);
		elgg_register_collection('collection:object:media_album:friends', FriendsAlbumCollection::class);
		elgg_register_collection('collection:object:media_album:group', GroupAlbumCollection::class);

		elgg_register_collection('collection:media:owner', OwnedMediaCollection::class);
		elgg_register_collection('collection:media:group', GroupMediaCollection::class);
		elgg_register_collection('collection:media:album', AlbumMediaCollection::class);

		elgg_register_event_handler('create', 'object', ConvertUploadedMedia::class);
		elgg_register_event_handler('update:after', 'object', ConvertUploadedMedia::class);

		elgg_register_event_handler('create', 'object', ExtractExifTags::class);

		elgg_register_plugin_hook_handler('fields', 'object', SetObjectFields::class, 800);

		elgg_register_plugin_hook_handler('uses:location', 'object:media_album', [Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('uses:river', 'object:media_album', [Values::class, 'getFalse']);
		elgg_register_plugin_hook_handler('uses:autosave', 'object:media_album', [Values::class, 'getFalse']);

		elgg_register_plugin_hook_handler('uses:location', 'object:media_file', [Values::class, 'getTrue']);

		elgg_register_plugin_hook_handler('uses:web_location', 'object:media_import', [Values::class, 'getTrue']);

		elgg_register_plugin_hook_handler('post:after', 'object:media_album', BatchNewMedia::class);
		elgg_register_plugin_hook_handler('uses:river', 'object:media_batch', [Values::class, 'getTrue']);

		elgg_register_plugin_hook_handler('likes:is_likable', 'object:media_album', [Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:media_file', [Values::class, 'getTrue']);
		elgg_register_plugin_hook_handler('likes:is_likable', 'object:media_import', [Values::class, 'getTrue']);

		elgg_register_plugin_hook_handler('register', 'menu:entity', EntityMenu::class);
		elgg_register_plugin_hook_handler('register', 'menu:title', TitleMenu::class);
		elgg_register_plugin_hook_handler('register', 'menu:owner_block', OwnerBlockMenu::class);

		elgg_register_menu_item('site', [
			'name' => 'albums',
			'text' => elgg_echo('collection:object:media_album:all'),
			'href' => elgg_generate_url('collection:object:media_album:all'),
			'icon' => 'images',
		]);

		elgg_register_event_handler('create', 'object', SyncMediaFiles::class);

		elgg_register_event_handler('update', 'object', SyncMediaObjects::class);
		elgg_register_event_handler('publish', 'object', SyncMediaObjects::class);
		elgg_register_event_handler('unpublish', 'object', SyncMediaObjects::class);

		elgg_register_plugin_hook_handler('modules', 'object', AddMediaModules::class);

		elgg_extend_view('elgg.css', 'media/media.css');
		elgg_extend_view('elgg.css', 'videojs/video-js.min.css');

		elgg_define_js('videojs', [
			'src' => elgg_get_simplecache_url('videojs/video.min.js'),
		]);

		elgg()->group_tools->register('media');

		elgg_register_notification_event('object', 'media_batch', ['publish']);
		elgg_register_plugin_hook_handler('prepare', 'notification:publish:object:media_batch', FormatBatchNotification::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {
		MediaCollectionsService::instance()->register('media_album', [
			'media_file',
			'media_import',
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function shutdown() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function activate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function deactivate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function upgrade() {

	}
}