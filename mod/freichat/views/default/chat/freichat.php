<?php

$token = elgg_get_plugin_setting('token', 'freichat');
$showFriends = elgg_get_plugin_setting('friends', 'freichat');
$baseUrl = elgg_get_plugin_setting('baseUrl', 'freichat');


/**
 * Returns a where clause to find mutual relationships
 * Code borrowed from: https://elgg.org/discussion/view/2527409/how-to-get-a-list-of-friend
 * @return string
 */
function getWhereClauseForMutualFriendship()
{
    $db_prefix = get_config('dbprefix');
    return "EXISTS (
		SELECT 1 FROM {$db_prefix}entity_relationships r2
			WHERE r2.guid_one = r.guid_two
			AND r2.relationship = 'friend'
			AND r2.guid_two = r.guid_one)
	";
}

function getFreinds($guid)
{
    $options = array(
        'type' => 'user',
        'relationship' => 'friend',
        'relationship_guid' => $guid,
    );
    // add secondary clause for mutual relationships
    $options['wheres'][] = getWhereClauseForMutualFriendship();

    $friends = elgg_get_entities_from_relationship($options);

    $friendIds = [];
    foreach ($friends as $friend) {
        $friendIds[] = $friend->getGUID();
    }

    return $friendIds;
}

if ($token != null && elgg_is_logged_in()) {

    $user = elgg_get_logged_in_user_entity();

    $id = elgg_get_logged_in_user_guid();
    $name = base64_encode($user->getDisplayName());
    $avatar = base64_encode($user->getIconURL("small"));
    $pubKey = explode("$$", $token)[0];
    $change = date('Ymd');

    $friendIds = null;
    if ($showFriends === "yes") {
        $friendIds = getFreinds($user->getGUID());
    }
    $friendIdsEncoded = json_encode($friendIds);
    ?>

    <script type="text/javascript">

        FreiChatClient = {
            friendIds: `<?php echo $friendIdsEncoded; ?>`
        };

        import('<?php echo "$baseUrl/v1/freichat-float.js?pubKey=$pubKey&userId=$id&displayName=$name&displayImage=$avatar&change=$change"; ?>');
    </script>

<?php } ?>