<?php

$user = elgg_get_logged_in_user_entity();
$site_url = elgg_get_site_url();

$menu = elgg()->menus->getMenu('user_hover', [
	'entity' => $user,
	'username' => $user->username,
]);

$actions = $menu->getSection('action', []);

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
	//$profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
	foreach ($actions as $action) {
		$item = elgg_view_menu_item($action);
		$profile_actions .= "<button type=\"button\" tabindex=\"0\" class=\"dropdown-item\" \">$item</li>";
	}
	//$profile_actions .= '</ul>';
        //echo $profile_actions;
        ?>
<a href="<?php echo $site_url ?>profile/<?php echo $user->username;?>/edit"
   style="text-decoration: none;"
   >
 <button type="button" tabindex="0" class="dropdown-item">
      <?php echo elgg_echo('architect:edit_profile'); ?>
 </button>
    </a>

<a href="<?php echo $site_url ?>settings/user/<?php echo $user->username;?>" style="text-decoration: none;">
    <button type="button" tabindex="0" class="dropdown-item">
         <?php echo elgg_echo('architect:settings'); ?>
    </button>
    </a>
<a href="<?php echo $site_url ?>profile/<?php echo $user->username;?>" style="text-decoration: none;">
<button type="button" tabindex="0" class="dropdown-item">
 <?php echo elgg_echo('architect:profile'); ?>
</button>
</a>
<div tabindex="-1" class="dropdown-divider"></div>
<a href="<?php echo $site_url ?>action/logout" style="text-decoration: none;">
    <button type="button" tabindex="0" class="dropdown-item">
        <?php echo elgg_echo('architect:logout'); ?>
    </button>
</a>
<div tabindex="-1" class="dropdown-divider"></div>
<?php
}

if (elgg_is_admin_logged_in())
{   
    ?>
<h6 tabindex="-1" class="dropdown-header"><?php echo elgg_echo('architect:divider'); ?></h6>
<a href="<?php echo $site_url ?>admin/" style="text-decoration: none;"> 
   <button type="button" tabindex="0" class="dropdown-item">  
   <?php echo elgg_echo('architect:administration'); ?>
    </button> 
</a>
    <?php
}
