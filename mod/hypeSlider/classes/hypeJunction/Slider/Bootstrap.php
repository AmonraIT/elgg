<?php

namespace hypeJunction\Slider;

use Elgg\Database\Annotations;
use Elgg\Event;
use Elgg\Includer;
use Elgg\PluginBootstrap;

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
		elgg_register_css('slick', elgg_get_simplecache_url('slick/slick.css'));
		elgg_register_css('slick-theme', elgg_get_simplecache_url('slick/slick-theme.css'));

		elgg_define_js('slick', [
			'src' => elgg_get_simplecache_url('slick/slick.min.js'),
			'deps' => ['jquery'],
		]);

		elgg_extend_view('elgg.css', 'page/components/slider.css');
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {

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