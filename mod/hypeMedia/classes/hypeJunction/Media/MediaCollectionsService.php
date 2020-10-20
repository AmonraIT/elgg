<?php

namespace hypeJunction\Media;

use Elgg\Di\ServiceFacade;
use hypeJunction\Trees\TreeService;

class MediaCollectionsService {

	use ServiceFacade;

	/**
	 * @var TreeService
	 */
	protected $trees;

	/**
	 * @var array
	 */
	protected $types = [];

	/**
	 * {@inheritdoc}
	 */
	public static function name() {
		return 'media.collections';
	}

	/**
	 * Register a new collection type
	 *
	 * @param string   $type     Subtype of the collection object
	 * @param string[] $subtypes An array of subtypes that can be contained by the collection
	 *
	 * @return void
	 */
	public function register($type, array $subtypes) {
		$this->types[$type] = $subtypes;
	}

	/**
	 * Unregister a collection type
	 *
	 * @param string $type Collection entity subtype
	 * @return void
	 */
	public function unregister($type) {
		unset($this->types[$type]);
	}

	/**
	 * Add subtypes that can be contained by collection
	 *
	 * @param string $type Subtype of the collection object
	 * @param array $subtypes An array of subtypes that can be contained by the collection
	 */
	public function extend($type, array $subtypes) {
		if (!isset($this->types[$type])) {
			$this->types[$type] = [];
		}

		$this->types[$type] = array_merge($this->types, $subtypes);
	}

	/**
	 * Returns collection type definitions
	 * @return array
	 */
	public function all() {
		return $this->types;
	}
}