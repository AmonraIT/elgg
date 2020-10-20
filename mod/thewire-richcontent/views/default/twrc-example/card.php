<?php
$post_text = $vars['text'];

$entity = $vars['entity'];

//Checks to see if the wire post contains the string "world"
if (strpos($post_text, 'world') !== false || strpos($post_text, 'World') !== false ) { ?>

<div class="twrc-card">

    <img src="https://i2.wp.com/heartunbound.com/wp-content/uploads/2015/06/World-map.jpg" style="width: 100%;">

</div>

<?php } if (strpos($post_text, 'cow') !== false || strpos($post_text, 'cow') !== false ) { ?>

<div class="twrc-card">

    <img src="https://images.vice.com/motherboard/content-images/article/19438/1424985144724571.jpg" style="width: 100%;">

</div>

<?php } 

//This one is a little different. Will read the annotations of the post to see if "flamingo" == true

$flamingo = $entity->getAnnotations(array("name" => "flamingo"))[0]->value;

if ($flamingo == "true") { ?>

<div class="twrc-card">

    <img src="http://www.iocevre.com/images/d/library/991595d6-8867-45e0-a332-d28496f485e3.jpg" style="width: 100%;">

</div>

<?php } if (strpos($post_text, 'island') !== false || strpos($post_text, 'Island') !== false ) { ?>

<div class="twrc-card">

    <img src="https://www.jetsetter.com/uploads/sites/7/2018/06/du3xs53a-1380x690.jpeg" style="width: 100%;">

</div>

<?php }?>