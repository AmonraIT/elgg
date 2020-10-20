<?php

namespace hypeJunction\Media;

use ElggEntity;
use hypeJunction\Fields\Field;
use hypeJunction\Scraper\ScraperService;
use hypeJunction\Scraper\WebResource;
use Symfony\Component\HttpFoundation\ParameterBag;

class ImportField extends Field {

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

		$urls = $parameters->get($this->name);
		$urls = preg_split('/$\R?^/m', $urls);
		$urls = array_map(function($url) {
			return trim($url);
		}, $urls);
		$urls = array_unique($urls);

		foreach ($urls as $url) {

			if (empty($url)) {
				continue;
			}

			$data = ScraperService::instance()->scrape($url);
			if (!$data) {
				register_error(elgg_echo('media:import:error', [$url]));
				continue;
			}

			$resource = new WebResource($data);

			$import = new MediaImport();
			$import->container_guid = $entity->container_guid;
			$import->title = $resource->title;
			$import->tags = $resource->tags;
			$import->description = $resource->description;
			$import->web_location = $resource->url;
			$import->access_id = $entity->access_id;
			$import->published_status = $entity->published_status;
			$import->syncs_with = $entity->guid;

			$import->save();

			$batch = $entity->getVolatileData('batch') ? : [];
			$batch[] = $import->guid;
			$entity->setVolatileData('batch', $batch);

			$entity->addMedia($import);
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
			'subtype' => 'media_import',
		]);
	}
}