<?php
/**
 * Elgg drop-down login form
 */

if (elgg_is_logged_in()) {
	return true;
}

$body = elgg_view_form('login', array(), array('returntoreferer' => TRUE));
?>
 <li class="nav-item dropdown">

	<?php 
		echo elgg_view('output/url', array(
			'href' => elgg_get_login_url([], '#login-dropdown-box'),
			'rel' => 'popup',
			'class' => 'nav-link count-indicator dropdown-toggle',
			'text' => elgg_echo('<i class="mdi mdi-account-circle ml-1"></i>'),
		)); 
		echo elgg_view_module('dropdown', '', $body, array('id' => 'login-dropdown-box', 'class'=>'dropdown-menu dropdown-menu-right navbar-dropdown preview-list')); 
	?>
</li>
