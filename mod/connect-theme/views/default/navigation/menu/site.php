<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());

$main_menu = $vars['main_menu'];
//echo '<ul class="elgg-menu elgg-menu-site elgg-menu-site-default clearfix">';
if($main_menu == 1)
{
foreach ($default_items as $menu_item) {
	//echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
    
    switch($menu_item->getName())
    {
        case "file":
            $link_icon = "mdi mdi-file-tree menu-icon";
            break;
        
        case "activity":
            $link_icon = "mdi mdi-crosshairs-gps menu-icon";
            break;
        case "groups":
            $link_icon = "mdi mdi-account-multiple-plus menu-icon";
            break;
        
        case "members":
            $link_icon = "mdi mdi-account-card-details menu-icon";
            break;
        
        case "thewire":
            $link_icon = "mdi mdi-lead-pencil menu-icon";
            break;
        
        case "blog":
            $link_icon = "mdi mdi-brush menu-icon";
            break;
        
         case "photos":
            $link_icon = "mdi mdi-camera menu-icon";
            break;
        
        default: $link_icon = 'mdi mdi-xaml menu-icon';
    }
    ?>
<a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="<?php echo $menu_item->getHref();  ?>">
                    <span><?php echo $menu_item->getText();  ?></span>
                    <i class="<?php echo $link_icon; ?>"></i>
                  </a>
<?php
}
}


if($main_menu == 2)
{
foreach ($more_items as $menu_item) {
	//echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
    switch($menu_item->getName())
    {
        case "file":
            $link_icon = "mdi mdi-file-tree menu-icon";
            break;
        
        case "activity":
            $link_icon = "mdi mdi-crosshairs-gps menu-icon";
            break;
        case "groups":
            $link_icon = "mdi mdi-account-multiple-plus menu-icon";
            break;
        
        case "members":
            $link_icon = "mdi mdi-account-card-details menu-icon";
            break;
        
        case "thewire":
            $link_icon = "mdi mdi-lead-pencil menu-icon";
            break;
        
        case "blog":
            $link_icon = "mdi mdi-brush menu-icon";
            break;
        
         case "photos":
            $link_icon = "mdi mdi-camera menu-icon";
            break;
        
        default: $link_icon = 'mdi mdi-xaml menu-icon';
    }
    ?>
<a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="<?php echo $menu_item->getHref();  ?>">
                    <span><?php echo $menu_item->getText();  ?></span>
                    <i class="<?php echo $link_icon; ?>"></i>
                  </a>
<?php
}
}

if ($more_items) {
    
    /*
	echo '<li class="elgg-more">';

	$more = elgg_echo('more');
	echo "<a href=\"#\">$more</a>";
	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => 'elgg-menu elgg-menu-site elgg-menu-site-more', 
		'items' => $more_items,
	));
	
	echo '</li>';
     * 
     */
}
//echo '</ul>';
