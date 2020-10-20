<input type='hidden' value='false' name='params[demo]'>

<input type="checkbox" value='true' id="demo_mode" name="params[demo]"
    <?php if (elgg_get_plugin_setting('demo', 'thewire-richcontent') == "true") { echo "checked"; } ?>>
<label for="demo_mode">Demo mode (example of extended wire functionality)</label>

<br /><br />

<label id="twrc_plugins">Hooks extending the wire actions:</label><br />

<?php 

$extending = elgg_get_plugin_setting('plugins_extending', 'thewire-richcontent');

foreach (elgg_get_ordered_hook_handlers("twrc", "add") as $hook) {

    echo "- $hook <br />";

}

?>
<br /><br />