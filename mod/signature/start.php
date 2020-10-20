<?php
/*****
 * plugin hook to be run when the signature is changed via the tool settings page
 ******/

function validate_signature($hook, $type, $value, $params)
{
    $plugin = $params['plugin'];

    if ($plugin->getID() == 'signature') // check if the signature plugin called this hook
    {
        if ($params['name'] == 'signature') // check if the signature variable is the one being changed by this hook
        {
            $value = strip_tags($value,"<br><a><b><strong><i><italic>"); // remove html tags from the signature, except the ones we want to keep
            return $value; // return the contents of the signature text box
        }
        else
        return null;
    }
    else
        return null;
}

/**
 * signature initialisation function
 */
function signature_init() {
	//register hooks
	elgg_register_plugin_hook_handler('usersetting', 'plugin', 'validate_signature'); // validate the input that is entered on the settings tool page
    //extend views
	elgg_extend_view('elgg.css', 'css/signature'); // add css styling to the main elgg css file
	elgg_extend_view('object/comment','output/signature'); // place the signature view at the bottom of the generic comment view
    elgg_extend_view('object/discussion_reply', 'output/signature');
    elgg_extend_view('object/discussion', 'output/signature');
}

elgg_register_event_handler('init', 'system', 'signature_init');
