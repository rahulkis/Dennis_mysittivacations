<?php
// require_once 'csrest_campaigns.php';
require_once 'csrest_subscribers.php';
// require_once 'CMBase.php';

// $auth = array('api_key' => 'd57fa4b275c64ee68a55890bab76031e');
// $wrap = new CS_REST_General($auth);

// $result = $wrap->get_clients();

// echo"";print_r($result);

//var_dump($result->response);


// $api_key = 'd57fa4b275c64ee68a55890bab76031e';
// $client_id = '86b18186ae16bf14faabb0c78157d4b3';
// $campaign_id = null;
// $list_id = 'EE75E8F597AA0080';

$name="Vikal";
$email="vikal.singh@kindlebit.com";

// this stuff makes the API call
// replace 'Your list ID' and 'Your API key' with the values for your account
// once you've checked out the getting started link
$wrap = new CS_REST_Subscribers('EE75E8F597AA0080', 'd57fa4b275c64ee68a55890bab76031e');
$result = $wrap->add(array(
    'EmailAddress' => $email,
    'Name' => $name,
    'CustomFields' => array(), // no custom fields, can remove this line completely
    'Resubscribe' => true
));

// this is all being ignored by your javascript file anyway
// but i'll leave it in for completeness
echo "Result of POST /api/v3/subscribers/c268d1513b2cc51092acf2cf82658c4b.{format}\n<br />";
if($result->was_successful()) {
    echo "Subscribed with code ".$result->http_status_code;
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
    echo '</pre>';
}


?>