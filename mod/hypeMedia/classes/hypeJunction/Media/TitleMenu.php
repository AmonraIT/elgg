<?php

namespace hypeJunction\Media;

use Elgg\Hook;

class TitleMenu {

	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();
		$menu = $hook->getValue();

		if ($entity instanceof MediaFile) {
			if ($entity->canDownload()) {
				$menu[] = \ElggMenuItem::factory([
					'name' => 'download',
					'icon' => 'download',
					'href' => $entity->getDownloadURL(),
					'text' => elgg_echo('download'),
					'class' => 'elgg-button elgg-button-action',
				]);
			}
		}

		if ($entity instanceof MediaCollection) {
			if ($entity->canWriteToContainer()) {
				$menu[] = \ElggMenuItem::factory([
					'name' => 'upload',
					'icon' => 'upload',
					'href' => elgg_generate_entity_url($entity, 'edit', 'upload'),
					'text' => elgg_echo('upload:object:media_album'),
					'class' => 'elgg-button elgg-button-action',
				]);
			}
		}

		return $menu;
	}
}