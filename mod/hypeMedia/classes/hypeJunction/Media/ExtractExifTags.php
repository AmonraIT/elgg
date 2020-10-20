<?php

namespace hypeJunction\Media;

use Elgg\Event;
use ElggFile;

class ExtractExifTags {

	/**
	 * Extract exif metatags
	 *
	 * @param Event $event Event
	 *
	 * @return bool
	 */
	public function __invoke(Event $event) {

		$object = $event->getObject();

		if (!$object instanceof ElggFile) {
			return true;
		}

		$exif = $this->getData($object);

		if (!$exif) {
			return null;
		}

		if (!$object->description) {
			$description = '';
			if (isset($exif['ImageDescription'])) {
				$description = $exif['ImageDescription']['clean'];
			}
			if (isset($exif['UserComment'])) {
				$description .= $exif['UserComment']['clean'];
			}
			if ($description) {
				$object->description = $description;
			}
		}

		if (!$object->copyright) {
			if (isset($exif['Copyright'])) {
				$object->copyright = $exif['Copyright']['clean'];
			}
		}

		if (!$object->location) {

			if (isset($exif['GPSLatitude']) && isset($exif['GPSLongitude'])) {

				$params = [
					'lat' => $exif['GPSLatitude']['clean'],
					'lon' => $exif['GPSLongitude']['clean'],
					'zoom' => 15,
					'addressdetails' => false,
					'format' => 'json',
					'email' => elgg_get_config('siteemail'),
				];

				$query = http_build_query($params);

				$url = "http://nominatim.openstreetmap.org/reverse?$query";

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
				$json_data = curl_exec($curl);
				curl_close($curl);

				if ($data = json_decode($json_data, true)) {
					if (!isset($data['error'])) {
						$object->osm_id = $data['osm_id'];
						$object->setSearchLocation($data['display_name']);
						$object->setLatLong($data['lat'], $data['lon']);
					}
				}
			}
		}

		if (!$object->date) {
			if (isset($exif['DateTimeOriginal'])) {
				$object->date = strtotime($exif['DateTimeOriginal']['clean']);
			}
		}

		if (!$object->tags) {
			$tags = [];
			if (isset($exif['Model'])) {
				$tags[] = $exif['Model']['clean'];
			}
			if (isset($exif['LensModel'])) {
				$tags[] = $exif['LensModel']['clean'];
			}
			if ($tags) {
				$object->tags = $tags;
			}
		}

	}

	/**
	 * Parse and format meaningful EXIF tags
	 *
	 * @param ElggFile $entity Entity
	 *
	 * @return array|false
	 */
	public function getData($entity) {

		if (!($entity instanceof ElggFile) || !is_callable('exif_imagetype')) {
			return false;
		}

		// File is too small for exif to identify the type
		// or exif is not supported on this file type
		if (filesize($entity->getFilenameOnFilestore()) <= 11 || !exif_imagetype($entity->getFilenameOnFilestore())) {
			return false;
		}

		$exif = exif_read_data($entity->getFilenameOnFilestore(), null, true);

		$tags = [];

		foreach ($exif as $section => $data) {

			foreach ($data as $key => $value) {

				if (is_string($value)) {
					$value = trim($value);
				}

				if (empty($value)) {
					continue;
				}

				switch ($key) {

					case 'Model' :
					case 'LensInfo' :
					case 'LensModel' :
					case 'LensSerialNumber' :
					case 'XResolution' :
					case 'YResolution' :
					case 'Copyright' :
					case 'ImageDescription' :
					case 'Software' :
					case 'ModifyDate' :
					case 'FNumber' :
					case 'ExposureTime' :
					case 'ISO' :
					case 'ISOSpeedRatings' :
					case 'SensitivityType' :
					case 'SpectralSensitivity' :
					case 'RecommendedExposureIndex' :
					case 'DateTimeOriginal' :
					case 'DateTimeDigitized' :
					case 'CompressedBitsPerPixel' :
					case 'ShutterSpeedValue' :
					case 'ApertureValue' :
					case 'BrightnessValue' :
					case 'ExposureBiasValue' :
					case 'MaxApertureValue' :
					case 'SubjectDistance' :
					case 'FocalLength' :
					case 'UserComment' :
					case 'SubsecTime' :
					case 'SubsecTimeOriginal' :
					case 'SubsecTimeDigitized' :
					case 'Color Space' :
					case 'PixelXDimension' :
					case 'PixelYDimension' :
					case 'FlashEnergy' :
					case 'SpatialFrequencyResponse' :
					case 'FocalPlaneXResolution' :
					case 'FocalPlaneYResolution' :
					case 'ExposureIndex' :
					case 'SceneType' :
					case 'DigitalZoomRatio' :
					case 'FocalLengthIn35mmFilm' :
					case 'DeviceSettingDescription' :
					case 'ImageUniqueID' :
					case 'GPSAltitude' :
						$tags[$key] = [
							'label' => elgg_echo("exif.$key"),
							'raw' => $value,
							'clean' => $value,
						];
						break;

					case 'ExifVersion' :
					case 'FlashpixVersion' :
						$tags[$key] = [
							'label' => elgg_echo("exif.$key"),
							'raw' => $value,
							'clean' => number_format((int) $value / 100, 2),
						];
						break;

					case 'ExposureProgram' :
					case 'ComponentsConfiguration' :
					case 'MeteringMode' :
					case 'LightSource' :
					case 'Flash' :
					case 'Resolution Unit' :
					case 'FocalPlaneResolutionUnit' :
					case 'SensingMethod' :
					case 'CFAPattern' :
					case 'CustomRendered' :
					case 'ExposureMode' :
					case 'WhiteBalance' :
					case 'SceneCaptureType' :
					case 'GainControl' :
					case 'Contrast' :
					case 'Saturation' :
					case 'Sharpness' :
					case 'SubjectDistanceRange' :
					case 'GPSAltitudeRef' :
						if (is_numeric($value)) {
							$tags[$key] = [
								'label' => elgg_echo("exif.$key"),
								'raw' => $value,
								'clean' => elgg_echo("exif.$key.$value"),
							];
						}
						break;

					case 'SubjectArea' :
					case 'SubjectLocation' :
						$tags[$key] = [
							'label' => elgg_echo("exif.$key"),
							'raw' => $value,
							'clean' => (is_array($value)) ? implode(' ', $value) : $value,
						];
						break;

					case 'GPSVersionID' :
						$tags[$key] = [
							'label' => elgg_echo("exif.$key"),
							'raw' => $value,
							'clean' => (is_array($value)) ? implode('.', $value) : $value,
						];
						break;

					case 'GPSLatitude' :
						$tags[$key] = [
							'label' => elgg_echo("exif.$key"),
							'raw' => $value,
							'clean' => $this->getGPS($value, $data['GPSLatitudeRef']),
						];
						break;

					case 'GPSLongitude' :
						$tags[$key] = [
							'label' => elgg_echo("exif.$key"),
							'raw' => $value,
							'clean' => $this->getGPS($value, $data['GPSLongitudeRef']),
						];
						break;
				}
			}
		}

		return elgg_trigger_plugin_hook('format:exif', 'image', [
			'entity' => $entity,
			'exif' => $exif
		], $tags);
	}

	/**
	 * Helper function to convert exif GPS to proper coords
	 * @link http://stackoverflow.com/questions/2526304/php-extract-gps-exif-data
	 *
	 * @param array $exifCoord Exif coords
	 * @param string $hemi     Hemisphere
	 *
	 * @return float
	 */
	public function getGPS($exifCoord, $hemi) {

		$degrees = count($exifCoord) > 0 ? $this->GPS2Number($exifCoord[0]) : 0;
		$minutes = count($exifCoord) > 1 ? $this->GPS2Number($exifCoord[1]) : 0;
		$seconds = count($exifCoord) > 2 ? $this->GPS2Number($exifCoord[2]) : 0;

		$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

		return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
	}

	/**
	 * Helper function to convert exif GPS to proper coords
	 * @link http://stackoverflow.com/questions/2526304/php-extract-gps-exif-data
	 *
	 * @param string $coordPart GPS coords
	 *
	 * @return int
	 */
	public function GPS2Number($coordPart) {

		$parts = explode('/', $coordPart);

		if (count($parts) <= 0) {
			return 0;
		}

		if (count($parts) == 1) {
			return $parts[0];
		}

		return floatval($parts[0]) / floatval($parts[1]);
	}
}