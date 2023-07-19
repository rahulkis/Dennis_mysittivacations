<?php
include("Query.Inc.php");
$Obj = new Query($DBName);



$titleofpage="Breweries/Wineries"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
if (!empty($dropdown_city)) {
	$dropdown_city_get = $dropdown_city;
}

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];
$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$_SESSION['country'] = $get_state_name['country_id'];

$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
$get_co_name = mysql_fetch_assoc($co_name_query);
$conry_nm = $get_co_name['name'];
$state_name = $get_state_name['name'];

$tokenURL = "http://widgetapi2.isango.com/token";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenURL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "grant_type=password&username=mysitti&password=Sitti@1My");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);
$curl_jason = json_decode($server_output, true);

$TOKEN = $curl_jason['access_token'];


$urlgo = "http://widgetapi2.isango.com/TicketFilterList/v2?language=en&currency=usd&destination=6195&order=1&exclude=1,2&partner=isa&PageNumber=1&PageSize=15&direction=0";

//setup the request, you can also use CURLOPT_URL
$ch = curl_init($urlgo);

// Returns the data/output as a string instead of raw data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');

//Set your auth headers
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $TOKEN
    ));

// get stringified data/output. See CURLOPT_RETURNTRANSFER
$data = curl_exec($ch);

// get info about the request
$info = curl_getinfo($ch);

// close curl resource to free up system resources 
curl_close($ch);



?>