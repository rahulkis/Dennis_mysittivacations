<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="unsubscribe"; 
 
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
if(!empty($_REQUEST['email'])){
$url = 'https://hvongphit.api-us1.com';

$replace = str_replace('%','@', $_REQUEST['email']);

$params = array(

    // the API Key can be found on the "Your Settings" page under the "API" tab.
    // replace this with your API Key
    'api_key'      => '23ff986328c01377ce1d144a63305805104dfea34c09bec35e3c156d88d87256796633dd',

    // this is the action that fetches a contact info based on the ID you provide
    'api_action'   => 'contact_view_email',
    //'api_action' => 'contact_view', // this one also works

    // define the type of output you wish to get back
    // possible values:
    // - 'xml'  :      you have to write your own XML parser
    // - 'json' :      data is returned in JSON format and can be decoded with
    //                 json_decode() function (included in PHP since 5.2.0)
    // - 'serialize' : data is returned in a serialized format and can be decoded with
    //                 a native unserialize() function
    'api_output'   => 'serialize',

    'email'        => $replace,
);

// This section takes the input fields and converts them to the proper format
$query = "";
foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
$query = rtrim($query, '& ');

// clean up the url
$url = rtrim($url, '/ ');

// This sample code uses the CURL library for php to establish a connection,
// submit your request, and show (print out) the response.
if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

// If JSON is used, check if json_decode is present (PHP 5.2.0+)
if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
    die('JSON not supported. (introduced in PHP 5.2.0)');
}

// define a final API request - GET
$api = $url . '/admin/api.php?' . $query;

$request = curl_init($api); // initiate curl object
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

$response = (string)curl_exec($request); // execute curl fetch and store results in $response

// additional options may be required depending upon your server configuration
// you can find documentation on curl options at http://www.php.net/curl_setopt
curl_close($request); // close curl object

if ( !$response ) {
    die('Nothing was returned. Do you have a connection to Email Marketing server?');
}
$result = unserialize($response);
$emailid = $result['id'];

$params = array(

    // the API Key can be found on the "Your Settings" page under the "API" tab.
    // replace this with your API Key
    'api_key'      => '23ff986328c01377ce1d144a63305805104dfea34c09bec35e3c156d88d87256796633dd',

    // this is the action that deletes a contact based on the ID you provide
    'api_action'   => 'contact_delete',

    // define the type of output you wish to get back
    // possible values:
    // - 'xml'  :      you have to write your own XML parser
    // - 'json' :      data is returned in JSON format and can be decoded with
    //                 json_decode() function (included in PHP since 5.2.0)
    // - 'serialize' : data is returned in a serialized format and can be decoded with
    //                 a native unserialize() function
    'api_output'   => 'serialize',

    // ID of the contact you wish to delete
    'id'           => $emailid,

    // if you wish to delete the contact only from certain lists, list them here
    //'listids[123]' => 123,
    //'listids[345]' => 345,
);

// This section takes the input fields and converts them to the proper format
$query = "";
foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
$query = rtrim($query, '& ');

// clean up the url
$url = rtrim($url, '/ ');

// This sample code uses the CURL library for php to establish a connection,
// submit your data, and show (print out) the response.
if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

// If JSON is used, check if json_decode is present (PHP 5.2.0+)
if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
    die('JSON not supported. (introduced in PHP 5.2.0)');
}

// define a final API request - GET
$api = $url . '/admin/api.php?' . $query;

$request = curl_init($api); // initiate curl object
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

$response = (string)curl_exec($request); // execute curl fetch and store results in $response

// additional options may be required depending upon your server configuration
// you can find documentation on curl options at http://www.php.net/curl_setopt
curl_close($request); // close curl object


$unsubscribed_email = "DELETE FROM user WHERE email = '".$_REQUEST['email']."'";
  $result = $mysqli->query($unsubscribed_email);
}

?>

<!--section1-->
<div class="container unsub_contain">
	<div class="row">
		<div class="col-sm-12 col-md-12  unsub">
			<div class="heading_title"><h1>UNSUBSCRIBE CONFIRMATION</h1></div></div>
		
	<div class="confirmation-box">
    <div class="confirmation-text">
        <h5>We're sorry to see you go!</h5>
        <p>you are now unsubscribed from our email list.</p>
    </div>
    <div class="confirmation-text">
        <h5>Changed your mind?</h5>
    </div>
    <div class="confirmation-text">
        <h5>keep in touch!</h5>
        <p>Connect with us on social media</p>
    </div>
	<div class="connect-social">
	   <ul class="list-inline">
	      <li><a href="https://www.facebook.com/mysitti" target="_blank"><img src="upload/facebook.jpg"></a></li>
		  <li><a href="https://mysitti.com/blog/" target="_blank"><img src="upload/bingo.jpg"></a></li>
		  <li><a href="https://instagram.com/mysitti/" target="_blank"><img src="upload/insta.jpg"></a></li>
		  <li><a href="https://www.pinterest.com/mysitti/" target="_blank"><img src="upload/pintst.jpg"></a></li>
		  <li><a href="https://twitter.com/MysittiCom" target="_blank"><img src="upload/twitter.jpg"></a></li>
		  <li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA?sub_confirmation=1" target="_blank"><img src="upload/you-tube.jpg"></a></li>
	   </ul>
	<div>
		</div>
	</div>
	
	
	
	










<?php
	include('LandingPageFooter.php');
 ?>
 
 <style>
	.connect-social ul li a img {
    width: 30px;
	}
 </style>