<?php

namespace hypeJunction\Media;

use Elgg\Hook;

class OwnerBlockMenu {

	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();
		$menu = $hook->getValue();

		if ($entity instanceof \ElggUser) {
			$menu[] = \ElggMenuItem::factory([
				'name' => 'media',
				'href' => elgg_generate_url('collection:object:media_album:owner', [
					'username' => $entity->username,
				]),
				'text' => elgg_echo('collection:object:media_album:all'),
			]);
		} else if ($entity instanceof \ElggGroup && $entity->isToolEnabled('media')) {
			$menu[] = \ElggMenuItem::factory([
				'name' => 'media',
				'href' => elgg_generate_url('collection:object:media_album:group', [
					'guid' => $entity->guid,
				]),
				'text' => elgg_echo('collection:object:media_album:all'),
			]);
		}

		return $menu;
	}
}