<?php

/*/
 * KeyCode: 78jk45ui
 * e-Webstar.net/KeyCode?id=78jk45ui
 *
/*/




elgg_register_event_handler('init', 'system', 'links_thewire_init');

include 'lib/elgg_preview.php';

elgg_extend_view('css/elgg', 'elgg-thewire-links-preview/css');

function links_thewire_init() {
	global $CONFIG;
}
