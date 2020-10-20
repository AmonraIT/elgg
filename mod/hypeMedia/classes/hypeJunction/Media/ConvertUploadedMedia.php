<?php

namespace hypeJunction\Media;

use Elgg\Event;

class ConvertUploadedMedia {

	/**
	 * Convert uploaded video file to a web compatible format
	 *
	 * @elgg_event create object
	 * @elgg_event update:after object
	 *
	 * @param Event $event Event
	 *
	 * @return void
	 */
	public function __invoke(Event $event) {

		$entity = $event->getObject();

		if (!$entity instanceof \ElggFile) {
			return;
		}

		elgg_register_event_handler('shutdown', 'system', function() use ($entity) {
			Converter::instance()->convert($entity);
		});
	}
}