<?php
$post_contents = get_input('body', '', false);

$owner_guid = elgg_get_logged_in_user_entity()->guid;

// don't filter since we strip and filter escapes some characters
$body = get_input('body', '', false);

$access_id = ACCESS_PUBLIC;
$method = 'site';
$parent_guid = (int) get_input('parent_guid');

// make sure the post isn't blank
if (empty($body)) {
	register_error(elgg_echo("thewire:blank"));
	forward(REFERER);
}

//this is where we check to see all of the custom fields, starting with "rc_"
$rc_fields = array();
foreach($_POST as $key => $value) {
    if (strpos($key, 'rc_') === 0) {
        
        //Adds the new value from $_POST to $rc_fields
        $rc_fields = array_merge($rc_fields, array($key => $_POST[$key]));

    }
}

$guid = thewire_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method);

$entity = get_entity($guid);

elgg_trigger_plugin_hook('twrc', 'add', $entity, $rc_fields);

if (!$guid) {
	register_error(elgg_echo("thewire:notsaved"));
	forward(REFERER);
}

// if reply, forward to thread display page
if ($parent_guid) {
	$parent = get_entity($parent_guid);
	forward("thewire/thread/$parent->wire_thread");
}

system_message(elgg_echo("thewire:posted"));
forward(REFERER);