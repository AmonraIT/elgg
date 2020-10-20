<?php

namespace hypeJunction\Media;

use Elgg\Hook;
use ElggFile;

class AddMediaModules {

	/**
	 * Add media object modules
	 *
	 * @param Hook $hook Hook
	 *
	 * @return array
	 */
	public function __invoke(Hook $hook) {
		$value = $hook->getValue();

		$entity = $hook->getEntityParam();

		if ($entity instanceof ElggFile) {
			$value['exif'] = [
				'enabled' => true,
				'position' => 'sidebar',
				'priority' => 500,
			];
		}

		return $value;
	}
}