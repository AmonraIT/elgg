<?php

namespace hypeJunction\Media;

use ElggObject;
use hypeJunction\Trees\TreeService;

class MediaAlbum extends ElggObject implements MediaCollection {

	const SUBTYPE = 'media_album';

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
			$name = date('F Y', $this->time_created);
		}

		return $name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addMedia(MediaObject $media_object) {
		/* @var $media_object \ElggEntity */

		if (TreeService::instance()->isNode($this, $media_object)) {
			return true;
		}

		return (bool) TreeService::instance()->addNode($this, $media_object);
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeMedia(MediaObject $media_object) {
		/* @var $media_object \ElggEntity */

		return TreeService::instance()->removeNode($this, $media_object);
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasMedia(MediaObject $media_object) {
		/* @var $media_object \ElggEntity */

		return TreeService::instance()->isNode($this, $media_object);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMedia(array $options = []) {
		/* @var $media_object \ElggEntity */

		if (!isset($options['sort'])) {
			$options['sort'] = 'weight::asc';
		}

		return elgg_get_collection('collection:media:album', $this, $options);
	}
}