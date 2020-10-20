<?php
/**
 * File river view.
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$menu = elgg_view_menu('river', array(
	'item' => $item,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$object = $item->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = thewire_filter($excerpt);
echo elgg_view('super-river/css');
$subject = $item->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$subject->username",
	'text' => elgg_echo('thewire:wire'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$summary = elgg_echo("river:create:object:thewire", array($subject_link, $object_link));

echo elgg_view('river/elements/super-river/super-layout', array(
	'item' => $item,
	'message' => $excerpt,
	'summary' => $summary,

	// truthy value to bypass responses rendering
	'responses' => ' ',
));

$site = elgg_get_site_entity();
$siteName = $site->name;
$siteUrl = elgg_get_site_url();
$wireDescription = $object->description;
$wireUrl = $object->getUrl();
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
<a href="$wireUrl">
<span class="super-river-elgg-icon fa fa-send-o"></span>
</a>
</center>
</div>
</br>
<div class="txt-bd">

 
    <p class="wire-description">
    $wireDescription
    </p><a class="action" href="$wireUrl">Continue the discussion &gt;</a>
        </div>
   
</div>
</br>
___HTML;

echo $cardPreview;


echo <<<RIVER
$menu
    </br>
    
RIVER;

echo '</br>';