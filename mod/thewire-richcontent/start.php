<?php

elgg_register_event_handler('init', 'system', 'twrc_init');

function twrc_init() {
    
    //Adds the rich content area for the wire
    elgg_extend_view('forms/thewire/add', 'twrc/area');

    //Adds the "cards" below the wire post
    elgg_extend_view('object/thewire', 'twrc/thewire');
    elgg_extend_view('river/elements/body', 'twrc/river');

    //Demo Functions
    if ((elgg_get_plugin_setting('demo', 'thewire-richcontent') == "true")) {

        //Adds the buttons to add the pictures to a user's wire post
        elgg_extend_view('twrc/fields', 'twrc-example/field');

        //Adds the card to display the pictures
        elgg_extend_view('twrc/card', 'twrc-example/card');

        //Let's add our custom Javascript
        elgg_register_simplecache_view('twrc-example/icons.js');

        //And CSS of course :)
        elgg_extend_view('elgg.css', 'twrc-example/css');

        //Let's add our custom flamingo add action
        elgg_register_plugin_hook_handler('twrc', 'add', 'demo_hook');

        //Example hooks that runs right a wire post was created
        function demo_hook($hook, $type, $fields, $entity) {

            //Add's the "flamingo" as an annotation to a wire post
            $entity->annotate('flamingo', $fields['rc_flamingo'], $entity->access_id);

        }

    }

    //Our custom CSS
    elgg_extend_view('elgg.css', 'twrc/css');

    //Let's register our custom action to do custom things
    $action_base = __DIR__ . '/actions';
    elgg_unregister_action('thewire/add');
    elgg_register_action("thewire/add", "$action_base/add.php");

}
