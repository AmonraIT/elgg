<?php

namespace hypeJunction\Media;

use Elgg\Hook;

class SetObjectFields {

	public function __invoke(Hook $hook) {

		$fields = $hook->getValue();
		/* @var $fields \hypeJunction\Fields\Collection */

		$entity = $hook->getEntityParam();

		if ($entity instanceof MediaCollection) {
			if ($fields->has('title')) {
				$fields->get('title')->value = function(\ElggEntity $entity) {
					if (!$entity->guid) {
						return date('F Y');
					}
				};
			}

			if ($fields->has('description')) {
				$fields->get('description')->required = false;
				$fields->get('description')->{'data-parsley-required'} = false;
			}

			$fields->add('uploads', new UploadField([
				'type' => 'media/upload',
				'priority' => 10,
				'contexts' => ['media/upload'],
				'is_create_field' => true,
				'is_edit_field' => false,
				'is_profile_field' => false,
			]));

			$fields->add('imports', new ImportField([
				'type' => 'plaintext',
				'priority' => 11,
				'contexts' => ['media/upload'],
				'is_create_field' => true,
				'is_edit_field' => false,
				'is_profile_field' => false,
			]));

		} else if ($entity instanceof MediaObject) {
//			$fields->add('albums', new AlbumField([
//				'type' => 'albums',
//				'section' => 'sidebar',
//			]));

			if ($fields->has('description')) {
				$fields->get('description')->required = false;
				$fields->get('description')->{'data-parsley-required'} = false;
			}

			if ($entity instanceof MediaFile) {
				// @todo: Add upload file field
			}
		}

		return $fields;
	}
}