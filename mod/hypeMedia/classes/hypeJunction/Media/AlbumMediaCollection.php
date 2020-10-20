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

class AlbumMediaCollection extends Collection {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return 'collection:media:album';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		return elgg_echo('collection:media:album');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getType() {
		return 'object';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubtypes() {
		$types = MediaCollectionsService::instance()->all();

		return elgg_extract('media_album', $types);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCollectionType() {
		return 'album';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryOptions(array $options = []) {
		$options = array_merge([
			'types' => $this->getType(),
			'subtypes' => $this->getSubtypes(),
			'preload_owners' => true,
			'preload_containers' => true,
			'distinct' => true,
		], $options);

		$options = TreeService::instance()->getNodesQueryOptions($options, $this->target);

		return $options;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getURL() {
		return elgg_generate_url($this->getId());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListOptions(array $options = []) {
		$list_type = get_input('list_type', 'gallery');
		return array_merge([
			'full_view' => false,
			'no_results' => elgg_echo('collection:media:album:no_results'),
			'pagination_type' => 'infinite',
			'list_class' => 'post-list',
			'list_type' => $list_type,
			'gallery_class' => 'media-album-grid',
			'limit' => 48,
		], $options);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSortOptions() {
		return [
			Weight::id() => Weight::class,
			TimeCreated::id() => TimeCreated::class,
			LastAction::id() => LastAction::class,
			LikesCount::id() => LikesCount::class,
			ResponsesCount::id() => ResponsesCount::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSearchOptions() {
		$fields = parent::getSearchOptions();

		$fields[] = Subtype::class;
		$fields[] = CreatedBetween::class;

		return $fields;
	}
}