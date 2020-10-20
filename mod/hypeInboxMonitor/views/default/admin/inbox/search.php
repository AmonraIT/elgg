<?php

$query = get_input('query');

if (function_exists('mb_convert_encoding')) {
	$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
} else {
	// if no mbstring extension, we just strip characters
	$display_query = preg_replace("/[^\x01-\x7F]/", "", $query);
}

// render placeholder separately so it will double-encode if needed
$placeholder = htmlspecialchars(elgg_echo('search'), ENT_QUOTES, 'UTF-8');

$search_attrs = elgg_format_attributes(array(
	'type' => 'text',
	'class' => 'search-input',
	'size' => '21',
	'name' => 'query',
	'autocapitalize' => 'off',
	'autocorrect' => 'off',
	'value' => $display_query,
));
?>

<form class="inbox-monitor-search" action="<?php echo elgg_get_site_url(); ?>admin/inbox/monitor" method="get">
	<fieldset>
		<input placeholder="<?php echo $placeholder; ?>" <?php echo $search_attrs; ?> />
		<input type="submit" value="<?php echo elgg_echo('search:go'); ?>" class="search-submit-button" />
	</fieldset>
</form>
