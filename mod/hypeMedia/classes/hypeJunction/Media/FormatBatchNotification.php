<?php

namespace hypeJunction\Media;

use Elgg\Hook;
use Elgg\Notifications\Notification;
use Elgg\Notifications\NotificationEvent;

class FormatBatchNotification {

	/**
	 * Prepare a notification message about a new batch
	 *
	 * @param Hook $hook Hook
	 * @return \Elgg\Notifications\Notification|null
	 */
	public function __invoke(Hook $hook) {
		$notification = $hook->getValue();
		/* @var $notification Notification */

		$event = $hook->getParam('event');
		/* @var $event NotificationEvent */

		$entity = $event->getObject();
		if (!$entity instanceof MediaBatch) {
			return null;
		}

		$album = $entity->getAlbum();
		if (!$album instanceof MediaCollection) {
			return null;
		}

		$owner = $event->getActor();

		$recipient = $notification->getRecipient();
		/* @var $recipient \ElggUser */
		$language = $recipient->getLanguage();

		$count = $entity->getItems(['count' => true]);

		$notification->subject = elgg_echo('media:notify:subject', [
			$entity->getDisplayName()
		], $language);

		$notification->body = elgg_echo('media:notify:body', [
			$owner->getDisplayName(),
			$count,
			$album->getDisplayName(),
			elgg_view('media/notification', [
				'items' => $entity->getItems(['limit' => 0]),
			]),
			$album->getURL()
		], $language);

		$notification->summary = elgg_echo('media:notify:summary', [$entity->getDisplayName()], $language);

		$notification->url = $album->getURL();

		return $notification;
	}
}