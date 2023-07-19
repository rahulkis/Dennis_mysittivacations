<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
//mail("sumit.manchanda@kindlebit.com","My subject","Start");



$eventslug = $_GET['category'];
$catid = $_GET['catid'];
$eventcityname = $_GET['location'];
$pagenumber= $_GET['page'];
$city_id = $_GET['cityid'];

$data = file_get_contents("http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$eventslug."&location=".$eventcityname."&date=Future&sort_order=date&sort_direction=ascending&image_sizes=large&page_number=".$pagenumber."&page_size=100");
$json = json_decode($data, true);
//echo "<pre>"; print_r($json); exit;
if(count($json['events']['event']) > 1)
{
	foreach($json['events']['event'] as $event)
	{
		//echo $cityname .= trim(mysql_real_escape_string($event['city_name']))."<br>";
		
		$eventttt = $event['title'];
		$eventname = mysql_real_escape_string($event['title']);
		$venuename = mysql_real_escape_string($event['venue_name']);
		$forumimage = $event['image']['large']['url'];
		$forumthumb= $event['image']['large']['url'];
		$eventaddress = mysql_real_escape_string($event['venue_address']);
		$eventtime = $event['start_time'];
		$forumArray[] = "Test";
		$description = mysql_real_escape_string($event['description']);
		$cityname = trim(mysql_real_escape_string($event['city_name']));
		$countryname = trim(mysql_real_escape_string($event['country_name']));
		$getforum = @mysql_query("SELECT forum FROM `forum` WHERE  `event_category` = '$catid' AND `event_date` = '$eventtime'  AND  ( `forum` = '$eventname' OR `forum` = '$eventttt' ) ");
		$eventcount = @mysql_num_rows($getforum);
		$currentdate = strtotime(date('Y-m-d H:i:s'));
		$fetchtime = strtotime($eventtime);


		if($eventcount < 1)
		{
			$fulladdress = $eventaddress.", ".$cityname.", ".$event['region_abbr']." ".$event['postal_code'];	
			$statename = trim($event['region_name']);
			

				//$fetchstate = @mysql_fetch_array($getstateid);
			$stateid = $_GET['state'];

			$Getcity = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '$cityname' AND `state_id` = '$stateid' "); 
			$countcity = @mysql_num_rows($Getcity);
										
			if($countcity < 1)
			{

				@mysql_query("INSERT INTO `capital_city` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ");
				$Getcity1 = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '".$cityname."'  "); 
				$fetchcity1 = @mysql_fetch_array($Getcity1);
				$city_id = $fetchcity1['city_id'];
			}
			else
			{
				
				$fetchcity1 = @mysql_fetch_array($Getcity);
				$city_id = $fetchcity1['city_id'];
			}

			if(isset($event['image']) && !empty($event['image']))
			{

					//echo "INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
					//VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 "; exit;
			@mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
					VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 ");
			$flag = "ON";
			}
		}
		
	}
}
				

?>	