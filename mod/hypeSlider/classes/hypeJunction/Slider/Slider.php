<?php
/**
 *
 */

namespace hypeJunction\Slider;


class Slider {

	public static function load() {
		elgg_require_js('page/components/slider');
		elgg_load_css('slick');
		elgg_load_css('slick-theme');
	}
}