<?php
/**
 * whoviewedme index
 *
 */

$title = elgg_echo('whoviewedme');

$options = array('type' => 'user', 'full_view' => false);

$options['relationship'] = 'viewed';
$options['inverse_relationship'] = true;
$options['relationship_guid'] = elgg_get_logged_in_user_guid();

$content = elgg_list_entities_from_relationship($options);

    if(!$content){
        $content = elgg_echo("whoviewedme:nobody");
    }


$params = array(
	'content' => $content,
	'title' => $title,
	'filter_override' => "",
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

