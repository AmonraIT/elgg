<?php

namespace hypeJunction\Media;

use hypeJunction\Lists\Collection;
use hypeJunction\Lists\SearchFields\CreatedBetween;
use hypeJunction\Lists\SearchFields\Subtype;
use hypeJunction\Lists\Sorters\Alpha;
use hypeJunction\Lists\Sorters\LastAction;
use hypeJunction\Lists\Sorters\LikesCount;
use hypeJunction\Lists\Sorters\ResponsesCount;
use hypeJunction\Lists\Sorters\TimeCreated;
use hypeJunction\Trees\TreeService;

class GroupMediaCollection extends AlbumMediaCollection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:media:group';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		return elgg_echo('collection:object:media_album:all');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollectionType() {
		return 'group';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		$options = array_merge([
			'types' => $this->getType(),
			'subtypes' => $this->getSubtypes(),
			'container_guids' => (int) $this->getTarget()->guid,
			'preload_owners' => true,
			'preload_containers' => true,
			'distinct' => true,
		], $options);

		return $options;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		return elgg_generate_url($this->getId(), [
			'guid' => $this->getTarget()->guid,
		]);
	}
	
}