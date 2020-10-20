<?php
/**
 * Main plugin file
 *
 */

require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/page_handlers.php');

// register default elgg events
elgg_register_event_handler('init', 'system', 'promo_widget_init');

/**
 * Called during system init
 *
 * @return void
 */
function promo_widget_init() {
	
	// extend css/js
	elgg_extend_view('css/elgg', 'css/promo_widget/site');
	elgg_extend_view('js/elgg', 'js/promo_widget/site');
	
	// page handler
	elgg_register_page_handler('promo_widget', 'promo_widget_page_handler');
	
	// regsiter widget
	elgg_register_widget_type('promo_widget', elgg_echo('promo_widget:widget:title'), elgg_echo('promo_widget:widget:description'), 'index,groups', true);
	
	// plugin hooks
	elgg_register_plugin_hook_handler('action', 'widgets/save', 'promo_widget_widget_save_action_hook');
}