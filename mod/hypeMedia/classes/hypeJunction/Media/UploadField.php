<?php

namespace hypeJunction\Media;

use ElggEntity;
use hypeJunction\Fields\Field;
use Symfony\Component\HttpFoundation\ParameterBag;

class UploadField extends Field {

	/**
	 * Store raw value as an entity property
	 *
	 * @param ElggEntity   $entity     Entity
	 * @param ParameterBag $parameters Raw data
	 *
	 * @return bool
	 * @throws \DatabaseException
	 */
	public function save(ElggEntity $entity, ParameterBag $parameters) {
		/* @var $entity MediaCollection */

		$guids = (array) $parameters->get($this->name);

		foreach ($guids as $guid) {
			$file = get_entity($guid);
			if (!$file instanceof MediaFile) {
				$file->delete();
				continue;
			}

			$file->container_guid = $entity->container_guid;
			$file->access_id = $entity->access_id;
			$file->published_status = $entity->published_status;
			$file->syncs_with = $entity->guid;

			$file->save();

			$batch = $entity->getVolatileData('batch') ? : [];
			$batch[] = $file->guid;
			$entity->setVolatileData('batch', $batch);

			$entity->addMedia($file);
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
		/* @var $entity \hypeJunction\Media\MediaCollection */

		return $entity->getMedia([
			'subtype' => 'media_file',
		]);
	}
}