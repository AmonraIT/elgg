<?php

if(elgg_get_context()=="whoviewedme"){
    $ent = $vars['entity'];

    if (!elgg_instanceof($ent, 'user', 'member')) {
        $relationship = check_entity_relationship($ent->guid, "viewed", elgg_get_logged_in_user_guid());
        $date = elgg_view_friendly_time($relationship->time_created);
        echo $date;

    }
}
