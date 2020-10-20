<?php
/**
 * Elgg drop-down login form
 */

if (elgg_is_logged_in()) {
	return true;
}

//$body = elgg_view_form('login', array(), array('returntoreferer' => TRUE));
?>
 

<div class="d-inline-block dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-user fa-w-20"></i>
                                            </span>
                                           Login
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                   <?php 
		$module = elgg_extract('module', $vars, 'aside');

$title = elgg_extract('title', $vars, elgg_echo('login'));

$body = elgg_view_form('login');

echo elgg_view_module($module, $title, $body);
	?>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                    </div>