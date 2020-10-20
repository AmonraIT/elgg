<?php
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggFile || !\hypeJunction\Media\Converter::instance()->isConvertible($entity)) {
	return;
}

$defaults = [
	'class' => 'video-js scraper-card-flex',
	'id' => "video-player-$entity->guid",
	'title' => $entity->getDisplayName(),
	'controls' => true,
	'preload' => 'metadata',
	'autoplay' => false,
];

$options = elgg_extract('config', $vars, []);

$options = array_merge($defaults, $options);

if (\hypeJunction\Media\Converter::instance()->isVideo($entity)) {
    if ($entity->hasIcon('master')) {
        $options['poster'] = $entity->getIconURL('master');
    } else {
		$options['poster'] = elgg_get_simplecache_url('media/video.jpg');
	}

	$tag = 'video';
	$extensions = (array) elgg_get_config('media:web_video_formats', ['mp4', 'webm', 'ogv']);
} else if (\hypeJunction\Media\Converter::instance()->isAudio($entity)) {
	if ($entity->hasIcon('master')) {
		$options['poster'] = $entity->getIconURL('master');
	} else {
		$options['poster'] = elgg_get_simplecache_url('media/audio.jpg');
	}

	$tag = 'audio';
	$extensions = (array) elgg_get_config('media:web_audio_formats', ['mpeg', 'ogg', 'wav']);
}

$sources = '';

foreach ($extensions as $extension) {
	$source = \hypeJunction\Media\Converter::instance()->getConvertedFile($entity, $extension);

	if (!$source->exists() && elgg_get_config('media:convert_at_runtime', true)) {
		$source = \hypeJunction\Media\Converter::instance()->createConvertedFile($entity, $extension);
	}

	if ($source->exists()) {
		$sources .= elgg_format_element('source', [
			'src' => $source->getDownloadURL(),
			'type' => $mime,
		]);
	}
}

if (empty($sources)) {
	return;
}

?>
<div class="elgg-col elgg-col-1of1 clearfix">
	<?php
	echo elgg_format_element($tag, $options, $sources);
	?>
</div>

<script>
	require(['media/players/videojs'], function (videojs) {
		videojs('<?php echo "video-player-$entity->guid" ?>');
	});
</script>