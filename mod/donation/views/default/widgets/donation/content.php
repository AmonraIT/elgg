<?php
/**
 * Donation widget display view
 */

$num = $vars['entity']->num_display;

// Current time
$time = time();

$paypal_code = elgg_get_plugin_setting("paypal_code","donation");
$bank_account = elgg_get_plugin_setting("bank_account","donation");

$NameValuePairs[] = array('name' => 'donation', 'operand' => '>', 'value' => $time);
$order = array('name' => 'donation', 'direction' => 'DESC');
$query =  array(
		'type' => 'user',
		'limit' => $num,
    		'metadata_name_value_pairs' => $NameValuePairs, 
		'order_by_metadata' => $order);

$newest_donators = elgg_get_entities_from_metadata($query);


?>

<div class="donationWrapper">
<?php
echo "<center>" . elgg_echo('donation:desc', array(elgg_get_config('sitename'))) . "<br>";
if($paypal_code){
	echo elgg_echo('donation:paypal');
	echo $paypal_code;
}
if($bank_account){
	echo elgg_echo('donation:banktransfer');
	echo "<br>" . elgg_echo('donation:bank_account:text', array($bank_account)) . "<br>";
}

echo "<hr>";
echo elgg_echo('donation:latest');
echo "<br></center>";

if (!$newest_donators) {
	echo elgg_echo('donation:none');
} else {	
	echo "<ul class='elgg-gallery'>";
	foreach($newest_donators as $donator) {
		echo "<li class='elgg-item mrs'>";
		echo elgg_view_entity_icon($donator, $profile_show, array('hover' => false));
		echo "</li>";
	}
}
?>
<div class="clearfloat"></div>
<a href="<?php echo elgg_get_site_url(); ?>donation"><?php echo elgg_echo('donation:show:everyone'); ?></a>
</div>
