<?php
/**
 * Tracker library of common functions
 *
 * @package Tracker
 */

// Function to save IP address on login
function tracker_log_ip($event, $object_type, $object) {
	if (($object) && ($object instanceof ElggUser)) {
		// Try to get IP address
		if (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_X_FORWARDED')) {
			$ip_address = getenv('HTTP_X_FORWARDED');
		} elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_FORWARDED_FOR');
		} elseif (getenv('HTTP_FORWARDED')) {
			$ip_address = getenv('HTTP_FORWARDED');
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		if (!empty($ip_address)) {
			create_metadata($object->guid, 'ip_address', $ip_address, '', 0, ACCESS_PUBLIC);
		}
	}
}
