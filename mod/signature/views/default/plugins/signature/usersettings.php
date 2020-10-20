<?php
	/**
	* signature - elgg
	* 
	* @package signature
	*/
	
	$plugin = $vars["entity"];

	echo "<div>";
	echo elgg_echo('signature:user:config') . '</br>' . '</br>';
	echo elgg_view("input/longtext", array("name" => "params[signature]", "value" => $plugin->getUserSetting("signature", elgg_get_page_owner_guid())));
	echo "</div>";
        
?>