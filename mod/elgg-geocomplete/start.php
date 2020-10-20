<?php
/**
 * Elgg geocomplete
 * Dries de Krom
 * Datlonmedia.be
 */
elgg_register_event_handler('init', 'system', 'geocomplete_init');



function geocomplete_init() {
	//Extend the locationfield 
	elgg_extend_view("input/location", "geocomplete/extend");
    //define the JS
    elgg_define_js('geocomplete/geocomplete', [
        'deps' => ['jquery','google.places.loader'],
        'src' => elgg_get_simplecache_url('js/geocomplete', 'jquery.geocomplete.min.js'),
        'exports' => 'geocomplete/geocomplete',
    ]);
}
