<?php
/**
 * All page handlers are bundled here
 */

/**
 * Promo page handler
 *
 * @param array $page page elements
 *
 * @return bool
 */
function promo_widget_page_handler($page) {
	$include_file = false;
	
	switch ($page[0]) {
		case 'thumb':
			set_input('guid', elgg_extract(1, $page));
			set_input('side', elgg_extract(2, $page));
			set_input('name', elgg_extract(3, $page));
			
			$include_file = dirname(dirname(__FILE__)) . '/pages/thumb.php';
			break;
	}
	
	if (!empty($include_file)) {
		include($include_file);
		return true;
	}
	
	return false;
}