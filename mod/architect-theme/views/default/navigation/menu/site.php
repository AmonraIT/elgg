<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());
$link_icon = '';
$item_class = '';
foreach ($default_items as $menu_item) {
    
    
    //$item_class = $menu_item->getItemClass();
    /*
if ($menu_item->getSelected() == 1) {
	$item_class = "mm-active";
}*/
    
    
    switch($menu_item->getName())
    {
        case "file":
            $link_icon = "metismenu-icon pe-7s-copy-file";
            break;
        
        case "activity":
            $link_icon = "metismenu-icon pe-7s-display2";
            break;
        case "groups":
            $link_icon = "metismenu-icon pe-7s-users";
            break;
        
        case "members":
            $link_icon = "metismenu-icon pe-7s-id";
            break;
        
        case "thewire":
            $link_icon = "metismenu-icon pe-7s-paper-plane";
            break;
        
        case "thewire":
            $link_icon = "metismenu-icon pe-7s-paper-plane";
            break;
        
        case "blog":
            $link_icon = "metismenu-icon pe-7s-pen";
            break;
        
         case "photos":
            $link_icon = "metismenu-icon pe-7s-photo";
            break;
        
        default: $link_icon = 'metismenu-icon pe-7s-plugin';
    }
    
    ?>
 <?php 
 if ($menu_item->getSelected() != null)
     $item_class = "mm-active";  
 else 
     $item_class = "";
 
 ?>
     
    <li>
            <a href="<?php echo $menu_item->getHref();  ?>" class="<?php echo $item_class;?>">
                 <i class="<?php echo $link_icon; ?>"></i>
                <?php echo $menu_item->getText();  ?>
            </a>
    </li>
    <?php
	//echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
}

if ($more_items) {
    
	echo '<li class="elgg-more">';

	$more = elgg_echo('more');
	echo "<a href=\"#\">$more</a>";
	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => 'elgg-menu elgg-menu-site elgg-menu-site-more', 
		'items' => $more_items,
	));
	
	echo '</li>';
      
}

