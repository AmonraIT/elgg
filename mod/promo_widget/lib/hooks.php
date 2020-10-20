<?php
/**
 * All plugin hooks are bundled here
 */

/**
 * Listen to widget save action
 *
 * @param string $hook   the name of the hook
 * @param stirng $type   the type of the hook
 * @param mixed  $return current return value
 * @param mixed  $params supplied params
 *
 * @return void
 */
function promo_widget_widget_save_action_hook($hook, $type, $return, $params) {
	
	$guid = (int) get_input('guid');
	$widget = get_entity($guid);
	if (empty($widget) || !elgg_instanceof($widget, 'object', 'widget')) {
		return;
	}
	
	if ($widget->handler !== 'promo_widget') {
		return;
	}
	
	if (!$widget->canEdit()) {
		return;
	}
	
	$params = get_input('params');
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	foreach ($params as $name => $value) {
		if (stristr($name, '_type') === false) {
			continue;
		}
		
		if ($value !== 'image_upload') {
			continue;
		}
		
		$side = str_ireplace('_type', '', $name);
		$contents = get_resized_image_from_uploaded_file("{$side}_image_upload", 1024, 1024);
		if (empty($contents)) {
			$params[$name] = 'text';
		}
		
		$fh = new ElggFile();
		$fh->owner_guid = $widget->getGUID();
		
		$fh->setFilename("{$side}_image.jpg");
		$fh->open('write');
		$fh->write($contents);
		$fh->close();
		
		$params["{$side}_icontime"] = time();
		$params[$name] = 'image';
		
		$url = "promo_widget/thumb/{$widget->getGUID()}/{$side}/" . $params["{$side}_icontime"] . ".jpg";
		$params["{$side}_image"] = elgg_normalize_url($url);
	}
	
	set_input('params', $params);
}
