<?php
/**
 * Dropdown menu for adding new items
 * 
 */

elgg_register_event_handler('init', 'system', 'emoticons_css');

function emoticons_css() {
	elgg_extend_view("css/elgg", "emoticons_css/css");
    elgg_register_js('jquery-emoticons', elgg_get_site_url().'mod/emoticons_css/vendors/jquery.cssemoticons.min.js', 'head');	

	$emote_js = elgg_get_simplecache_url('js', 'emoticons_css/emote');
    elgg_register_simplecache_view('js/emoticons_css/emote');
    elgg_register_js('emote', $emote_js, 'head');
	
	elgg_load_js('jquery-emoticons');	
	elgg_load_js('emote');
}