<?php

namespace hypeJunction\Media;


use Elgg\Event;

class SyncMediaObjects {

	/**
	 * Sync album published status and access
	 *
	 * @param Event $event Event
	 * @return void
	 */
	public function __invoke(Event $event) {

		$object = $event->getObject();
		if (!$object instanceof MediaCollection) {
			return;
		}

		$dependants = elgg_get_entities([
			'batch' => true,
			'limit' => 0,
			'metadata_name_value_pairs' => [
				'syncs_with' => $object->guid,
			],
		]);

		foreach ($dependants as $dependant) {

			$prev_published_status = $dependant->published_status;
			$dependant->published_status = $object->published_status;

			if ($dependant->published_status !== $prev_published_status && $dependant->published_status == 'published') {
				elgg_trigger_event('publish', 'object', $dependant);
			}

			if (!$dependant->location && $object->location) {
				$dependant->location = $object->location;
			}

			if ($dependant->access_id !== $object->access_id || $dependant->container_guid !== $object->container_guid) {
				$dependant->access_id = $object->access_id;
				$dependant->container_guid = $object->container_guid;
				$dependant->save();
			}
		}
	}
}