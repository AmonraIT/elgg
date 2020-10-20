<?php

// outputs the signature that has been created via profile_manager for the creator of the current comment
$commenter = get_user($vars['entity']->owner_guid);

if ($commenter)
    $signature = elgg_get_plugin_user_setting('signature',$commenter->getGUID(), 'signature');
if (($signature != '')
  &&(($vars['full_view'])&&($vars['entity']->getSubtype() == 'comment'))
  ||($vars['entity']->getSubtype() == 'discussion_reply')
  ||($vars['entity']->getSubtype() == 'discussion'))
  $output = '<div class="elgg-signature">' . $signature . '</div>';

echo $output;
