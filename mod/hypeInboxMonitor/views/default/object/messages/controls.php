<?php
elgg_require_js('object/messages/controls');

$label = elgg_echo('inbox:monitor:toggle');
$checkbox = elgg_format_element('input', array(
	'type' => 'checkbox',
	'class' => 'inbox-monitor-checkbox-toggle',
		));

$view = elgg_format_element('button', array(
	'data-href' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/inbox/monitor/delete')),
	'class' => 'inbox-monitor-action elgg-button elgg-button-action elgg-state-disabled',
	'disabled' => true,
	'title' => elgg_echo('inbox:monitor:delete:help'),
		), elgg_echo('inbox:monitor:delete'));
?>
<div class="inbox-monitor-list-item inbox-monitor-module-controls" data-guid="<?= $entity->guid ?>">
	<div class="inbox-monitor-view inbox-monitor-buttonbank"><label><?= $checkbox . $label ?></label><?= $view ?></div>
</div>