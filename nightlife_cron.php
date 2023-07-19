<?php
include("Query.Inc.php");
function curl_contents($url) { 

	// Initiate the curl session 
	$ch = curl_init(); // Set the URL 
	curl_setopt($ch, CURLOPT_URL, $url); 
	// Removes the headers from the output 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	// Return the output instead of displaying it directly 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	// Execute the curl session 
	$output = curl_exec($ch); 
	// Close the curl session 
	curl_close($ch); 
	// Return the output as a variable 
	return $output; 
} 
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
$a= "";
$mq = @mysql_query("SELECT * FROM `capital_city` ORDER BY `city_id` ASC ");
$flag = "OFF";
$data1 = curl_contents("http://wowza:i-46066faf@54.174.85.75:1935/enginemanager/Home.htm#application/_defaultVHost_/httplive/live/main");
$json1 = json_decode($data1, true);



echo "<pre>"; print_r($data1); die('hhh');



/*  FOR DELETING THE RECORDS FROM CRONCHECK  */
$currentDay = date('d');
$previousDay = $currentDay - 1;
//mail("raman.deep@kindlebit.com","My subject","Start");


while ($res = @mysql_fetch_array($mq)) 
{

	$catid = 9;
	$date = date('Y-m-d');
	$city_id = $res['city_id'];
	$catslug = "singles_social";
	$checkcronq = @mysql_query("SELECT `cid` FROM `croncheck` WHERE `catid` = '$catid' AND `executiondate` = '$date'  AND `city_id` = '$city_id' ");
	$countcroncheck = @mysql_num_rows($checkcronq);
	if($countcroncheck < 1)
	{
		@mysql_query("INSERT INTO `croncheck` (`city_id`,`executiondate`,`catid`) VALUES ('$city_id','$date','$catid')   ");

		/* COOUNT PAGE NUMBER CODE*/

		$data1 = curl_contents("http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$catslug."&location=".$res['city_name']."&date=Future&count_only=true");
		$json1 = json_decode($data1, true);


		$countpages = ceil($json1['total_items']/100);


		/*** END COUNT CODE ***/

		for($pagenumber=1;$pagenumber<=$countpages;$pagenumber++)
		{

			$data = curl_contents("http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$catslug."&location=".$res['city_name']."&date=Future&sort_order=date&sort_direction=ascending&image_sizes=large&page_number=".$pagenumber."&page_size=100");
			$json = json_decode($data, true);
			 
			if(count($json['events']['event']) > 1)
			{
				foreach($json['events']['event'] as $event)
				{
					//echo $cityname .= trim(mysql_real_escape_string($event['city_name']))."<br>";
					
					$eventttt = $event['title'];
					$eventname = mysql_real_escape_string($event['title']);
					$venuename = mysql_real_escape_string($event['venue_name']);
					$eventtime = $event['start_time'];
					$currtime = date('Y-m-d H:i:s');
					if($eventtime >= $currtime)
					{


						if($event['image']['large']['url'] != "")
						{
							$forumimage = $event['image']['large']['url'];
						}
						else
						{
							$forumimage = "";
						}


						if($event['image']['large']['url'] != "")
						{
							$forumthumb= $event['image']['large']['url'];
						}
						else
						{
							$forumthumb = "";
						}

						
						
						$eventaddress = mysql_real_escape_string($event['venue_address']);
						
						$forumArray[] = "Test";
						$description = mysql_real_escape_string(addslashes($event['description']));
						$cityname = trim(mysql_real_escape_string($event['city_name']));
						$countryname = trim(mysql_real_escape_string($event['country_name']));
						$getforum = @mysql_query("SELECT forum FROM `forum` WHERE  `event_category` = '$catid' AND `event_date` = '$eventtime' AND (`forum` = '$eventname' OR `forum` = '$eventttt')  ");
						$eventcount = @mysql_num_rows($getforum);
						$currentdate = strtotime(date('Y-m-d H:i:s'));
						$fetchtime = strtotime($eventtime);
						$added_on = trim($event['created']);

						if($eventcount < 1)
						{
							$fulladdress = $eventaddress.", ".$cityname.", ".$event['region_abbr']." ".$event['postal_code'];	
							$statename = trim($event['region_name']);
							
							$getstateq = mysql_query("SELECT zone.name, zone.zone_id FROM `zone`, `capital_city` WHERE capital_city.state_id = zone.zone_id  ");
							$fetchstate = mysql_fetch_array($getstateq);

							$stateid = $fetchstate['zone_id'];


							// if(isset($event['image']) && !empty($event['image']))
							// {

	$mainsql = "INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
							 		VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 ";
							@mysql_query($mainsql);
							$flag = "ON";

							//}
						}
					}
					
				}
			}
		} // END FOR LOOP

	}
//mail("sumit.manchanda@kindlebit.com","My subject",$cityname);
}

?>	