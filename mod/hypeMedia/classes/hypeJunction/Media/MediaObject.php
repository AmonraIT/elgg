<?php

namespace hypeJunction\Media;

interface MediaObject {

	/**
	 * Get albums this item belongs to
	 *
	 * @param array $options Options
	 * @return MediaCollection[]
	 */
	public function getCollections(array $options = []);
}