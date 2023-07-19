<?php /*
$getcity = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$_SESSION['id']."' ");
$fetchcity = @mysql_fetch_array($getcity);
$cityname1 = strtolower($fetchcity['city_name']);
$currentdate = date('Ymd');

$d = strtotime($currentdate);

$t = 5*60*60*24;


$s = $d + $t;
$end =  date('Ymd', $s);
/*
if(isset($_POST['ssss']))
{
	$catid = $_POST['eventcat'];
}
else
{
	$catid = '9';
}

*/

$msg = "";
$geteventcat = @mysql_query("SELECT * FROM `eventcategory` ");
while($row = @mysql_fetch_array($geteventcat))
{

        $catid = $row['id'];
	$cityname1 = str_replace(" ", "%20", $cityname1);
	
	//echo "http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$row['catslug']."&location=".$cityname1."&date=Future&sort_order=date&sort_direction=ascending&image_sizes=large&page_size=25"; echo "<br>";
	$data = file_get_contents("http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$row['catslug']."&location=".$cityname1."&date=Future&sort_order=date&sort_direction=ascending&image_sizes=large&page_size=50");
	$json = json_decode($data, true);
	 //echo "<pre>"; print_r($json); exit;
	if(count($json['events']['event']) > 1)
	{
		foreach($json['events']['event'] as $event)
		{
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
			$getforum = @mysql_query("SELECT * FROM `forum` WHERE  `event_category` = '$catid' AND `event_date` = '$eventtime'  ");
			$eventcount = @mysql_num_rows($getforum);
			while($r = @mysql_fetch_array($getforum))
			{
				$forumArray[] = $r['forum'];
			}
			$currentdate = strtotime(date('Y-m-d H:i:s'));
			$fetchtime = strtotime($eventtime);


			if(!in_array($eventname, $forumArray))
			{
				$fulladdress = $eventaddress.", ".$cityname.", ".$event['region_abbr']." ".$event['postal_code'];	
				$Getcity = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '$cityname'  "); 
				$countcity = @mysql_num_rows($Getcity);
				$statename = trim($event['region_name']);
				
				if($countcity < 1)
				{
					$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$statename' ");
					$statecount = @mysql_num_rows($getstateid);
					if($statecount > 0)
					{
	
						$fetchstate = @mysql_fetch_array($getstateid);
						$stateid = $fetchstate['zone_id'];
						
					}
					else
					{
						// $getcountryid = @mysql_query("SELECT * FROM `country` WHERE  ");
						@mysql_query("INSERT INTO `zone` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ");
					}
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

					@mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
				 		VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 ");
				
				}
			}
		}
	}
	else
	{
		$event = $json['events']['event'];
		
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
		$getforum = @mysql_query("SELECT * FROM `forum` WHERE  `event_category` = '$catid' AND `event_date` = '$eventtime'  ");
		$eventcount = @mysql_num_rows($getforum);
		while($r = @mysql_fetch_array($getforum))
		{
			$forumArray[] = $r['forum'];
		}
		$currentdate = strtotime(date('Y-m-d H:i:s'));
		$fetchtime = strtotime($eventtime);


		if(!in_array($eventname, $forumArray))
		{
			$fulladdress = $eventaddress.", ".$cityname.", ".$event['region_abbr']." ".$event['postal_code'];	
			$Getcity = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '$cityname'  "); 
			$countcity = @mysql_num_rows($Getcity);
			$statename = trim($event['region_name']);
			
			if($countcity < 1)
			{
				$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$statename' ");
				$statecount = @mysql_num_rows($getstateid);
				if($statecount > 0)
				{

					$fetchstate = @mysql_fetch_array($getstateid);
					$stateid = $fetchstate['zone_id'];
					
				}
				else
				{
					@mysql_query("INSERT INTO `zone` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ");
				}
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
				@mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
				 		VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 ");
				
			}
		}	
	}
}



// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);
*/
// send email
//mail("mancsumit@gmail.com","Cron job completed",$msg);
?>