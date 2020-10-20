<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid);

$vars['entity'] = get_entity($guid);

echo elgg_view('media/info', $vars);