<?php
/**
 * Blog river view.
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */
$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$object = $item->getObjectEntity();

$excerpt = $object->excerpt ? $object->excerpt : $object->description;
$excerpt = strip_tags($excerpt);
$excerpt = elgg_get_excerpt($excerpt);
echo elgg_view('super-river/css');
echo elgg_view('river/elements/super-river/super-layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
));

$site = elgg_get_site_entity();
$siteName = $site->name;
$siteUrl = elgg_get_site_url();
$blogTitle = $object->title;
$blogDescription = $object->excerpt;
$blogUrl = $object->getUrl();
$icon = elgg_get_simplecache_url('favicon-128.png');

$cardPreview = 
<<<___HTML
<div class="card article" style="background-color: #f5f6f5;     min-width: 200px;
    padding: 40px; color: #464646;
    font-size: 16px;
    position: relative;
    width: auto;
    z-index: 1;">
    <div class="provider">
        <a class="provider-name" href="$siteUrl">
           <img src="$icon" width="16" height="16" class="provider-favicon"> $siteName
        </a>
    </div>
    
<div class="art-bd">
<center>
<a href="$blogUrl">
<span class="super-river-elgg-icon fa fa-newspaper-o"></span>
</a>
</center>
</div>
<div class="txt-bd">
<h2 class="title">
<a href="$blogUrl">
$blogTitle
</a>
    </h2>
    <p class="blog-description">
    $blogDescription
    </p><a class="action" href="$blogUrl">Read more... &gt;</a>
        </div>
   
</div>
</br>
___HTML;

echo $cardPreview;

$responses = elgg_view('river/elements/responses', $vars);
if ($responses) {
	$responses = "<div class=\"elgg-river-responses\">$responses</div>";
}

echo <<<RIVER
$menu
    </br></br>
$responses
    
RIVER;

echo '</br>';
