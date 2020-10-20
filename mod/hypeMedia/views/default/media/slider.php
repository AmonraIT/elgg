<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Media\MediaCollection) {
	return;
}

\hypeJunction\Slider\Slider::load();

$collection = $entity->getMedia()->getList()->batch(0);

$selected_guid = elgg_extract('selected', $vars);
$selected = get_entity($selected_guid);

?>
<div class="media-slider-container">
    <div class="is-sticky">
        <div class="elgg-ajax-loader"></div>
        <div class="media-slider hidden">
			<?php
			foreach ($collection as $item) {
				if (!$selected) {
					$selected = $item;
				}

				$slide = elgg_view('media/thumb', [
					'entity' => $item,
					'album' => $entity,
				]);

				echo elgg_format_element('div', [
					'class' => 'media-slider-slide',
					'data-current' => $selected->guid == $item->guid,
					'data-guid' => $item->guid,
					'data-title' => $item->getDisplayName(),
					'data-info' => elgg_generate_entity_url($item, 'info'),
                    'data-href' => elgg_generate_entity_url($entity, 'view', 'slider', [
						'selected' => $item->guid,
					]),
                ], $slide);
			}
			?>
        </div>
    </div>

    <div class="media-slider-info"></div>
</div>


<script>
	require(['media/slider']);
</script>