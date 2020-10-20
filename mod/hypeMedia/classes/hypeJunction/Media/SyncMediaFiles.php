<?php

namespace hypeJunction\Media;

use Elgg\Event;

class SyncMediaFiles {

	/**
	 * Populate media files with necessary properties
	 *
	 * @param Event $event Event
	 *
	 * @return void
	 * @throws \DatabaseException
	 */
	public function __invoke(Event $event) {

		$file = $event->getObject();
		if (!$file instanceof MediaFile) {
			return;
		}

		$album_guid = get_input('album_guid');
		$album = get_entity($album_guid);

		if ($album instanceof MediaCollection) {
			// only do this for files uploaded into an existing album

			$file->access_id = $album->access_id;
			$file->container_guid = $album->container_guid;
			$file->published_status = $album->published_status;
			$file->syncs_with = $album->guid;

			$file->save();

			$album->addMedia($file);
		}
	}
}