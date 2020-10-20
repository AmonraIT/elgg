<?php

namespace hypeJunction\Media;

class OwnedAlbumCollection extends DefaultAlbumCollection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:object:media_album:owner';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollectionType() {
		return 'owner';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		$options['owner_guids'] = (int) $this->target->guid;

		return parent::getQueryOptions($options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		return elgg_generate_url($this->getId(), [
			'username' => $this->target->username,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilterOptions() {
		return [];
	}
}