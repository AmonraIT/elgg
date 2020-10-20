<?php

namespace hypeJunction\Media;

use Elgg\Di\ServiceFacade;
use Elgg\Project\Paths;
use ElggFile;

class Converter {

	use ServiceFacade;

	/**
	 * {@inheritdoc}
	 */
	public static function name() {
		return 'media.converter';
	}

	/**
	 * Check if this file is convertible
	 *
	 * @param ElggFile $file File
	 *
	 * @return bool
	 */
	public function isConvertible(ElggFile $file) {
		return $this->isAudio($file) || $this->isVideo($file);
	}

	/**
	 * Check if this file is a video
	 *
	 * @param ElggFile $file File
	 *
	 * @return bool
	 */
	public function isVideo(ElggFile $file) {

		if ($file->getSimpleType() == 'video') {
			return true;
		}

		$ext = pathinfo($file->getFilenameOnFilestore(), PATHINFO_EXTENSION);
		if (in_array($ext, ['aiff', 'asf', 'avi', 'bfi', 'caf', 'flv', 'gxf', 'mp4', 'webm', 'ogv'])) {
			return true;
		}

		return false;
	}

	/**
	 * Check if this file is an audio
	 *
	 * @param ElggFile $file File
	 *
	 * @return bool
	 */
	public function isAudio(ElggFile $file) {

		if ($file->getSimpleType() == 'audio') {
			return true;
		}

		$ext = pathinfo($file->getFilenameOnFilestore(), PATHINFO_EXTENSION);
		if (in_array($ext, ['wav', 'ogg', 'mp3', 'mpeg'])) {
			return true;
		}

		return false;
	}

	/**
	 * Convert video file to web compatible format
	 *
	 * @param ElggFile $source File entity
	 *
	 * @return void
	 */
	public function convert(ElggFile $source) {

		$extensions = [];

		if ($this->isVideo($source)) {
			$extensions = (array) elgg_get_config('media:web_video_formats', ['mp4', 'webm', 'ogv']);
		} else if ($this->isAudio($source)) {
			$extensions = (array) elgg_get_config('media:web_audio_formats', ['mpeg', 'ogg', 'wav']);
		}

		foreach ($extensions as $extension) {
			$this->createConvertedFile($source, $extension);
		}

	}

	/**
	 * Check if file is of a given extension/format
	 *
	 * @param ElggFile $source     File entity
	 * @param string   $target_ext Extension
	 *
	 * @return bool
	 */
	public function matchesFormat(ElggFile $source, $target_ext) {
		if (!$source->exists()) {
			return false;
		}

		$file_mime = $source->getMimeType();
		list(, $file_ext) = explode('/', $file_mime);

		return $file_ext === $target_ext;
	}

	/**
	 * Get a converted file entity
	 *
	 * @note Check if the file exists before generating a download URL
	 * @see  ElggFile::exists()
	 *
	 * @param ElggFile $source     File entity
	 * @param string   $target_ext Target format/extension
	 * @param bool     $convert    Force file conversion, if it doesn't exist
	 *
	 * @return ElggFile
	 */
	public function getConvertedFile(ElggFile $source, $target_ext) {

		if ($this->matchesFormat($source, $target_ext)) {
			return $source;
		}

		$filename = pathinfo($source->getFilenameOnFilestore(), PATHINFO_FILENAME);

		$target = new ElggFile();
		$target->owner_guid = $source->owner_guid;

		// projekktor prefix is used to stay compatible with elgg_file_viewer plugin
		$target->setFilename("projekktor/$source->guid/$filename.$target_ext");

		return $target;
	}

	/**
	 * Create a version of the file converted to a target format
	 *
	 * @note Check if target file exists by calling ElggFile::exists() on the return value
	 *
	 * @param ElggFile $source     File entity
	 * @param string   $target_ext Target format/extension
	 *
	 * @return ElggFile
	 */
	public function createConvertedFile(ElggFile $source, $target_ext) {

		$target = $this->getConvertedFile($source, $target_ext);
		if ($target->exists()) {
			return $target;
		}

		$bin = elgg_get_plugin_setting('ffmpeg_bin', 'hypeMedia');
		if (!$bin) {
			return $target;
		}

		$bin = Paths::sanitize($bin, false);

		try {
			if (!$source->hasIcon('large')) {
				$converter = new \FFmpeg($bin);

				$icon = $this->getConvertedFile($source, 'jpg');

				$icon->open('write');
				$icon->close();

				$converter->input($source->getFilenameOnFilestore())
					->thumb(0, 1)
					->output($icon->getFilenameOnFilestore())
					->ready();

				if ($icon->getSize()) {
					$source->saveIconFromElggFile($icon);
				}

				$icon->delete();
			}

			elgg_log("Converting file $source->guid to $target_ext: $converter->command", 'NOTICE');

			$target->open('write');
			$target->close();

			$converter = new \FFmpeg($bin);
			$converter->input($source->getFilenameOnFilestore())
				->output($target->getFilenameOnFilestore())
				->ready();

			if (!$target->getSize()) {
				$target->delete();
			}
		} catch (\Exception $ex) {
			elgg_log($ex->getMessage(), 'ERROR');
		}

		return $target;
	}
}