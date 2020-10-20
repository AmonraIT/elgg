<?php

namespace hypeJunction\Media;

use Elgg\Values;
use ElggObject;

class MediaBatch extends ElggObject {

	const SUBTYPE = 'media_batch';
	const RELATIONSHIP = 'batches';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * Add item to batch
	 *
	 * @param mixed $guids GUID(s)
	 *
	 * @return void
	 */
	public function addItems($guids) {
		try {
			$guids = Values::normalizeGuids($guids);
			foreach ($guids as $guid) {
				add_entity_relationship($this->guid, self::RELATIONSHIP, $guid);
			}
		} catch (\DataFormatException $ex) {

		}
	}

	/**
	 * Get items in the batch
	 *
	 * @param array $options ege* options
	 *
	 * @return \ElggEntity|int|mixed
	 */
	public function getItems(array $options = []) {
		$options['relationship'] = self::RELATIONSHIP;
		$options['relationship_guid'] = (int) $this->guid;
		$options['inverse_relationship'] = false;

		return elgg_get_entities($options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		$album = $this->getAlbum();
		if (!$album) {
			return false;
		}

		return $album->getURL();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		$album = $this->getAlbum();
		if (!$album) {
			return parent::getDisplayName();
		}

		return $album->getDisplayName();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIconURL($params = []) {
		$album = $this->getAlbum();
		if (!$album) {
			return false;
		}

		return $album->getIconURL($params);
	}

	/**
	 * Returns album
	 * @return MediaCollection|false
	 */
	public function getAlbum() {
		return get_entity($this->album_guid);
	}
}