<?php

$guids = (array) get_input('guids', array());

$count = count($guids);
$deleted = array();
$success = 0;
$error = 0;

foreach ($guids as $guid) {
	$entity = get_entity($guid);
	if ($entity && $entity->delete()) {
		$deleted[] = $guid;
		$success++;
	} else {
		$error++;
	}
}

if ($error == $count) {
	register_error(elgg_echo('inbox:monitor:delete:error'));
} else if ($error) {
	system_message(elgg_echo('inbox:monitor:delete:partial_success', array($success, $count)));
} else {
	system_message(elgg_echo('inbox:monitor:delete:success', array($count)));
}

if (elgg_is_xhr()) {
	echo json_encode(array(
		'clear' => $deleted,
	));
}
