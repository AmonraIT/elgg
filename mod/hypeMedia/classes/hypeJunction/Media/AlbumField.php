<?php

namespace hypeJunction\Media;

use ElggEntity;
use hypeJunction\Fields\Field;
use hypeJunction\Trees\TreeService;
use Symfony\Component\HttpFoundation\ParameterBag;

class AlbumField extends Field {

	/**
	 * Store raw value as an entity property
	 *
	 * @param ElggEntity   $entity     Entity
	 * @param ParameterBag $parameters Raw data
	 *
	 * @return bool
	 */
	public function save(ElggEntity $entity, ParameterBag $parameters) {

		$guids = (array) $parameters->get($this->name);

		if (!$entity instanceof MediaObject) {
			return false;
		}

		foreach ($guids as $guid) {
			$album = get_entity($guid);

			if (!$album instanceof MediaCollection) {
				continue;
			}

			$album->addMedia($entity);
		}

		return true;
	}

	/**
	 * Retrieve entity property
	 *
	 * @param ElggEntity $entity Entity
	 *
	 * @return mixed
	 */
	public function retrieve(ElggEntity $entity) {
		// @todo: Add method to retrieve all tree nodes this object belogs to
	}

}