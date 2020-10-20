<?php

namespace hypeJunction\Media;

use ElggFile;
use hypeJunction\Trees\TreeService;

class MediaFile extends ElggFile implements MediaObject {

	const SUBTYPE = 'media_file';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		$name = parent::getDisplayName();
		if ($name === $this->originalfilename) {
			$name = elgg_echo('untitled');
		}

		return $name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollections(array $options = []) {
		return TreeService::instance()->getRoots($this, $options);
	}
}