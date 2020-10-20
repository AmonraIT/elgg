<?php

namespace hypeJunction\Media;

use ElggObject;
use hypeJunction\Trees\TreeService;

class MediaImport extends ElggObject implements MediaObject {

	const SUBTYPE = 'media_import';

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
		if (!$name) {
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