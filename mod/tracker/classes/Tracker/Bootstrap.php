<?php

namespace Tracker;

use Elgg\PluginBootstrap;
use Elgg\Includer;
use Elgg\Hook;
use Elgg\Event;

class Bootstrap extends PluginBootstrap {

	protected function getRoot() {
		return $this->plugin->getPath();
	}
	/**
	 * Executed during 'plugin_boot:before', 'system' event
	 *
	 * Allows the plugin to require additional files, as well as configure services prior to booting the plugin
	 *
	 * @return void
	 */
	public function load() {
		Includer::requireFileOnce($this->getRoot() . '/lib/hooks.php');
		Includer::requireFileOnce($this->getRoot() . '/lib/tracker.php');
	}

	/**
	 * Executed during 'plugin_boot:before', 'system' event
	 *
	 * Allows the plugin to register handlers for 'plugin_boot', 'system' and 'init', 'system' events,
	 * as well as implement boot time logic
	 *
	 * @return void
	 */
	public function boot() {
		
	}

	/**
	 * Executed during 'init', 'system' event
	 *
	 * Allows the plugin to implement business logic and register all other handlers
	 *
	 * @return void
	 */
	public function init() {

		$this->elgg()->events->registerHandler('login:after', 'user', 'tracker_log_ip');
		$this->elgg()->events->registerHandler('create', 'user', 'tracker_log_ip');
		
		elgg_extend_view('elgg.css', 'tracker/tracker.css');

		if (elgg_get_plugin_setting('tracker_display', 'tracker') == 'profile') {
			elgg_extend_view('profile/fields', 'tracker/profile_ip', 450);
		} else {
			// Extend avatar hover menu
			elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'tracker_admin_hover_menu');
		}
	}

	/**
	 * Executed during 'ready', 'system' event
	 *
	 * Allows the plugin to implement logic after all plugins are initialized
	 *
	 * @return void
	 */
	public function ready() {

	}

	/**
	 * Executed during 'shutdown', 'system' event
	 *
	 * Allows the plugin to implement logic during shutdown
	 *
	 * @return void
	 */
	public function shutdown() {

	}

	/**
	 * Executed when plugin is activated, after 'activate', 'plugin' event and before activate.php is included
	 *
	 * @return void
	 */
	public function activate() {

	}

	/**
	 * Executed when plugin is deactivated, after 'deactivate', 'plugin' event and before deactivate.php is included
	 *
	 * @return void
	 */
	public function deactivate() {

	}

	/**
	 * Registered as handler for 'upgrade', 'system' event
	 *
	 * Allows the plugin to implement logic during system upgrade
	 *
	 * @return void
	 */
	public function upgrade() {

	}
}
