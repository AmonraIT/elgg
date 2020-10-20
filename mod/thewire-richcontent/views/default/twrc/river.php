<?php

$item = $vars['item'];

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

$message = elgg_extract('message', $vars);

if ($item->subtype == "thewire") {
    
    $message = elgg_extract('message', $vars);
    
    echo elgg_view('twrc/cards', ['text' => $message, 'entity_id' => $item->object_guid]);

}