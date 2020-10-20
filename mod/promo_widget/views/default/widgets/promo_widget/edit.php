<?php

$widget = elgg_extract('entity', $vars);

$sides = array(
	'left',
	'right'
);

$type_options = array(
	'text' => elgg_echo('promo_widget:widget:edit:type:text'),
	'image' => elgg_echo('promo_widget:widget:edit:type:image'),
	'image_upload' => elgg_echo('promo_widget:widget:edit:type:image_upload'),
);

foreach ($sides as $side) {
	$type = $widget->get("{$side}_type");
	if (empty($type)) {
		$type = 'text';
	}
	
	$content = '<div>';
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:type") . '</label>';
	$content .= elgg_view('input/dropdown', array(
		'name' => "params[{$side}_type]",
		'value' => $type,
		'options_values' => $type_options,
		'class' => 'mls',
		'onchange' => 'elgg.promo_widget_change_type(this);'
	));
	$content .= '</div>';
	
	// text
	$text_class = 'promo-widget-type promo-widget-type-text';
	if ($type !== 'text') {
		$text_class .= ' hidden';
	}
	$content .= "<div class='{$text_class}'>";
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:text") . '</label>';
	$content .= elgg_view('input/promo_widget_text', array(
		'name' => "params[{$side}_text]",
		'value' => $widget->get("{$side}_text")
	));
	$content .= '</div>';
	
	$content .= "<div class='{$text_class}'>";
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:background") . '</label>';
	$content .= elgg_view('input/promo_widget_background', array(
		'name' => "params[{$side}_background]",
		'value' => $widget->get("{$side}_background")
	));
	$content .= '</div>';
	
	// image
	$image_class = 'promo-widget-type promo-widget-type-image';
	if ($type !== 'image') {
		$image_class .= ' hidden';
	}
	$content .= "<div class='{$image_class}'>";
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:image") . '</label>';
	$content .= elgg_view('input/url', array(
		'name' => "params[{$side}_image]",
		'value' => $widget->get("{$side}_image")
	));
	$content .= '</div>';
	
	// image upload
	$image_upload_class = 'promo-widget-type promo-widget-type-image_upload hidden';
	$content .= "<div class='{$image_upload_class}'>";
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:image_upload") . '</label>';
	$content .= elgg_view('input/file', array(
		'name' => "{$side}_image_upload"
	));
	$content .= '</div>';
	
	// for both
	$content .= '<div>';
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:link") . '</label>';
	$content .= elgg_view('input/url', array(
		'name' => "params[{$side}_link]",
		'value' => $widget->get("{$side}_link")
	));
	$content .= '</div>';
	
	$content .= '<div>';
	$content .= '<label>' . elgg_echo("promo_widget:widget:edit:wrapper_text") . '</label>';
	$content .= elgg_view('input/text', array(
		'name' => "params[{$side}_wrapper_text]",
		'value' => $widget->get("{$side}_wrapper_text")
	));
	$content .= '</div>';
	
	echo elgg_view_module('aside', elgg_echo("promo_widget:widget:edit:{$side}:title"), $content);
}

?>
<script>
	$('#widget-edit-<?php echo $widget->getGUID(); ?> form').attr('enctype', 'multipart/form-data').submit(function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();
	});
</script>