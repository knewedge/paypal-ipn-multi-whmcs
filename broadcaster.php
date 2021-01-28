<?php
/*
*
* PayPal IPN Multi WHMCS
* IPN broadcaster for PayPal to support multiple WHMCS installs.
*
* Version: 1.0.0.0
* Release: 25-10-2016
* Authors: Knewedge, Qarizma, and Codeseekah
* License: MIT License
* Website: https://github.com/knewedge/paypal-ipn-multi-whmcs
* Fork of: https://github.com/qarizma/paypal-octa-ipn
*
*/


// Never halt this script.
ini_set('max_execution_time', 0);

// Hide all errors.
error_reporting(0);
ini_set('display_errors', 0);

// Session queue
$urls = array();

// List of IPNs. Add here your different businesses.
$ipns = array(
	'whmcs1' => 'https://www.business1.com/billing/',
	'whmcs2' => 'https://www.business2.com/billing/',
	'whmcs3' => 'https://www.business3.com/billing/'
);

// Here we match the business name that WHMCS prepends to the item_name with IPN. You can also use other variables from the notification.log in $_POST.
if (stripos($_POST['item_name'],'business-name1') !== FALSE) $urls[] = $ipns['whmcs1'];
if (stripos($_POST['item_name'],'business-name2') !== FALSE) $urls[] = $ipns['whmcs2'];
if (stripos($_POST['item_name'],'business-name3') !== FALSE) $urls[] = $ipns['whmcs3'];

// If nothing has match, broadcast them all.
if (!sizeof($urls)) $urls = $ipns;

// Create an unique array.
$urls = array_unique($urls);

// For every matched URL we found we do a broadcast.
foreach($urls as $url) broadcastNow($url);

// Return status OK.
header('HTTP/1.1 200 OK', true, 200);
exit();

function broadcastNow($url)
{
	/* Format POST data accordingly */
	$data = array();
	foreach($_POST as $key => $value) $data[] = urlencode($key) . '=' . urlencode($value);
	$data = implode('&', $data);

	// Uncomment the following line if you want to log every IPN request.
	//file_put_contents('logsdir/' . time() . '.' . reverseLookup($url) . '-' . rand(1, 100).'.log', $data);

	// Start the broadcast process using cURL.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, count($data));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	curl_close($ch);
}

function reverseLookup($url)
{
	global $ipns;
	foreach($ipns as $tag => $_url) {
		if ($url == $_url) return $tag;
	}
	return 'unknown';
}

?>
