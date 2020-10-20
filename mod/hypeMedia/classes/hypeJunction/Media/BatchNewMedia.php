<?php

namespace hypeJunction\Media;

use Elgg\Hook;
use Elgg\Values;
use hypeJunction\Post\River;

class BatchNewMedia {

	/**
	 * Batch new media objects
	 *
	 * @param Hook $hook Hook
	 * @return void
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();
		if (!$entity instanceof MediaCollection) {
			return;
		}

		$guids = $entity->getVolatileData('batch') ? : [];
		$entity->setVolatileData('batch', []);

		if (empty($guids)) {
			return;
		}

		$batch = elgg_call(ELGG_IGNORE_ACCESS, function() use ($entity, $guids) {
			$batch = new MediaBatch();
			$batch->album_guid = $entity->guid;
			$batch->container_guid = $entity->container_guid;
			$batch->access_id = $entity->access_id;
			$batch->syncs_with = $entity->guid;
			$batch->published_status = $entity->published_status;
			$batch->save();

			$batch->addItems($guids);

			$river = new River();
			$river->add($batch);

			return $batch;
		});

		if ($batch->published_status == 'published') {
			elgg_trigger_event('publish', 'object', $batch);
		}
	}
}