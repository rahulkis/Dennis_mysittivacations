<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
/**
 * This is a sample implementation of an IPN listener
 * that uses the SDK's PPIPNMessage class to process IPNs
 * 
 * This sample simply validates the incoming IPN message
 * and logs IPN variables. In a real application, you will
 * validate the IPN and initiate some action based on the 
 * incoming IPN variables.
 */
require_once('PPBootStrap.php');
// first param takes ipn data to be validated. if null, raw POST data is read from input stream
// For a full list of configuration parameters refer in wiki page (https://github.com/paypal/sdk-core-php/wiki/Configuring-the-SDK)
$ipnMessage = new PPIPNMessage(null, Configuration::getConfig());
mysql_query("INSERT INTO `paypal_log` (`id`, `txn_id`, `log`, `posted_date`, `invoice`) VALUES (NULL, ' asdasd', 'asdsd', 'now()','asdsd' )");
mysql_query("INSERT INTO `paypal_log` (`id`, `txn_id`, `log`, `posted_date`, `invoice`) VALUES (NULL, ' asdasd', 'asdsd', 'now()','asdsd' )");
foreach($ipnMessage->getRawData() as $key => $value) {
	error_log("IPN: $key => $value");
}

if($ipnMessage->validate()) {
	error_log("Success: Got valid IPN data");		
} else {
	error_log("Error: Got invalid IPN data");	
}
