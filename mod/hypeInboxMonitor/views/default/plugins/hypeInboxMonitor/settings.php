<?php

$entity = elgg_extract('entity', $vars);

?>
<div>
	<label><?php echo elgg_echo('inbox:monitor:blacklist') ?></label>
	<div class="elgg-text-help"><?php echo elgg_echo('inbox:monitor:blacklist:help') ?></div>
	<?php
	echo elgg_view('input/plaintext', array(
		'name' => 'params[blacklist]',
		'value' => implode(PHP_EOL, hypeapps_inbox_monitor_get_blacklist()),
	));
	?>
</div>

<div>
	<label><?php echo elgg_echo('inbox:monitor:policy') ?></label>
	<div class="elgg-text-help"><?php echo elgg_echo('inbox:monitor:policy:help') ?></div>
	<?php
	echo elgg_view('input/select', array(
		'name' => 'params[policy]',
		'value' => $entity->policy ? : 'mask',
		'options_values' => array(
			'nothing' => elgg_echo('inbox:monitor:policy:nothing'),
			'mask' => elgg_echo('inbox:monitor:policy:mask'),
			'silence' => elgg_echo('inbox:monitor:policy:silence'),
			'remove' => elgg_echo('inbox:monitor:policy:remove'),
		),
	));
	?>
</div>