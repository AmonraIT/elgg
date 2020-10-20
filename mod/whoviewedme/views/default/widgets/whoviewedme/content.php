<?php
/**
 * Who viewed me widget display view
 */

$widget = elgg_extract('entity', $vars);

$options = array('type' => 'user', 'full_view' => false);

$options['relationship'] = 'viewed';
$options['inverse_relationship'] = true;
$options['relationship_guid'] = $widget->owner_guid;
$options['limit'] = $widget->num_display;
$options['pagination'] = false;


$content = elgg_list_entities_from_relationship($options);

    if(!$content){
        $content = elgg_echo("whoviewedme:nobody");
    }
echo $content;

