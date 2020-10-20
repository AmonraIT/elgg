<?php

$guid = (int) get_input('guid');
$side = get_input('side');
$name = get_input('name');

// If is the same ETag, content didn"t changed.
$etag = md5($guid . $name . $side);
if (isset($_SERVER["HTTP_IF_NONE_MATCH"])) {
	list ($etag_header) = explode("-", trim($_SERVER["HTTP_IF_NONE_MATCH"], "\""));
	if ($etag_header === $etag) {
		header("HTTP/1.1 304 Not Modified");
		exit;
	}
}

$widget = get_entity($guid);
if (empty($widget) || !elgg_instanceof($widget, 'object', 'widget')) {
	header("HTTP/1.1 404 Not Found");
	exit;
}

$fh = new ElggFile();
$fh->owner_guid = $widget->getGUID();

$fh->setFilename("{$side}_image.jpg");
if (!$fh->exists()) {
	header("HTTP/1.1 404 Not Found");
	exit;
}

$contents = $fh->grabFile();

$filesize = strlen($contents);

header("Content-type: image/jpeg");
header("Expires: " . gmdate("D, d M Y H:i:s \G\M\T", strtotime("+6 months")), true);
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: $filesize");
header("ETag: \"$etag\"");

echo $contents;
exit();