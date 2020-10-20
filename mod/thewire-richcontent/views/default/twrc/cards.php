<?php
//Takes the text from the wire or river object
$post_text = $vars['text'];

$entity = get_entity($vars['entity_id']);

//Checks to see if there is a card for the text
$cards = elgg_view('twrc/card', ['text' => $post_text, 'entity' => $entity]);

if($cards) { ?>

<div class="twrc-cards">

    <?php echo $cards; ?>

</div>

<?php } ?>