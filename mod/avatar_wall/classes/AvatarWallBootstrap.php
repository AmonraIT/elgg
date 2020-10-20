<?php

class AvatarWallBootstrap extends \Elgg\DefaultPluginBootstrap {

	public function init() {
		elgg_register_menu_item('site', [
			'name' => elgg_echo('avatar_wall:shorttitle'),
			'text' => elgg_echo('avatar_wall:shorttitle'),
			'href' => 'avatar_wall/today',
			'icon' => 'user-ninja',
		]);
	}
}
