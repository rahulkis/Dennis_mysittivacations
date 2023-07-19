<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', '1');
// phpinfo();
// exit;
// mail("sumit.manchanda@kindlebit.com","My subject","Start");
//echo "SELECT * FROM `zone` WHERE `country_id` IN ('223','38') ORDER BY `code` ASC  ";
$getzipsql = mysql_query("SELECT * FROM `zone` WHERE `country_id` IN ('223','38') ORDER BY `code` ASC  ");
while($res = mysql_fetch_array($getzipsql))
{
	$statename = trim($res['name']);
	$stateid = $res['zone_id'];
	$citysql = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateid' ");
	while($citys = mysql_fetch_array($citysql))
	{
		//print_r($citys);die('here');
		$cityname = trim($citys['city_name']);
		$cityid = $citys['city_id'];
		$address = str_replace(" ", "%20", $cityname.",".$statename);
		if($citys['lng'] == "0.000000")
		{

			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			//echo "<pre>"; print_r($response_a); die('dddd');
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;	
			mysql_query("UPDATE `capital_city` SET `lat` = '$lat', `lng` = '$long' WHERE `city_id` = '$cityid'  ");
		}
	}
}

