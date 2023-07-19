<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
//mail("sumit.manchanda@kindlebit.com","My subject","Start");
$a= "";
//$mq = @mysql_query("SELECT * FROM `zone` WHERE `country_id` IN ('38','223') ORDER BY `zone_id` ASC ");
$mq = @mysql_query("SELECT * FROM `zone` WHERE `name` = 'Alaska'  ");
$flag = "OFF";
//$cityname = "";
$abc ="";
while ($res = @mysql_fetch_array($mq)) 
{
	$geteventcat = @mysql_query("SELECT * FROM `eventcategory`  ORDER BY `id` DESC ");
	
	while($row = @mysql_fetch_array($geteventcat))
	{
		$a .= $row['catslug'];
		$catid = $row['id'];
		$state = $res['name'];
		$date = date('Y-m-d');
		$checkcronq = @mysql_query("SELECT `cid` FROM `croncheck` WHERE `statename` = '$state' AND `catid` = '$catid' AND `executiondate` = '$date'  ");
		$countcroncheck = @mysql_num_rows($checkcronq);
		if($countcroncheck <= 0)
		{
			@mysql_query("INSERT INTO `croncheck` (`statename`,`executiondate`,`catid`) VALUES ('$state','$date','$catid')   ");

			/* COOUNT PAGE NUMBER CODE*/

			$data1 = file_get_contents("http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$row['catslug']."&location=".$res['name']."&date=Future&sort_order=date&sort_direction=ascending&image_sizes=large&page_size=100");
			$json1 = json_decode($data1, true);
			//echo "<pre>"; print_r($json1); exit;

			$countpages = $json1['page_count'];




			/*** END COUNT CODE ***/

			for($pagenumber=1;$pagenumber<=$countpages;$pagenumber++)
			{

				$data = file_get_contents("http://api.eventful.com/json/events/search?app_key=fxdqXV4J7Q4GJjQM&category=".$row['catslug']."&location=".$res['name']."&date=Future&sort_order=date&sort_direction=ascending&image_sizes=large&page_number=".$pagenumber."&page_size=100");
				$json = json_decode($data, true);
				 
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
						$getforum = @mysql_query("SELECT forum FROM `forum` WHERE  `event_category` = '$catid' AND `event_date` = '$eventtime'  ");
						$eventcount = @mysql_num_rows($getforum);
						while($r = @mysql_fetch_array($getforum))
						{
							$forumArray[] = $r['forum'];
						}
						$currentdate = strtotime(date('Y-m-d H:i:s'));
						$fetchtime = strtotime($eventtime);


						if(!in_array($eventttt,$forumArray))
						{
							$fulladdress = $eventaddress.", ".$cityname.", ".$event['region_abbr']." ".$event['postal_code'];	
							$statename = trim($event['region_name']);
							
			
								//$fetchstate = @mysql_fetch_array($getstateid);
							$stateid = $res['zone_id'];
	
							$Getcity = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '$cityname' AND `state_id` = '$stateid' "); 
							$countcity = @mysql_num_rows($Getcity);
														
							if($countcity < 1)
							{
			$abc .= "INSERT INTO `capital_city` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ";
								// @mysql_query("INSERT INTO `capital_city` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ");
								$Getcity1 = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '".$cityname."'  "); 
								$fetchcity1 = @mysql_fetch_array($Getcity1);
								$city_id = $fetchcity1['city_id'];
							}
							else
							{
								$abc .= "TEST";
								$fetchcity1 = @mysql_fetch_array($Getcity);
								$city_id = $fetchcity1['city_id'];
							}

							if(isset($event['image']) && !empty($event['image']))
							{

									
							//@mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
							// 		VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 ");
							$flag = "ON";
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


					if(!in_array($eventttt,$forumArray))
						{
							$fulladdress = $eventaddress.", ".$cityname.", ".$event['region_abbr']." ".$event['postal_code'];	
							$statename = trim($event['region_name']);
							//$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$statename' ");
							// $statecount = @mysql_num_rows($getstateid);
							// if($statecount > 0)
							// {
			
								//$fetchstate = @mysql_fetch_array($getstateid);
								//$stateid = $fetchstate['zone_id'];
								
			//				}
							$stateid = $res['zone_id'];


							$Getcity = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '$cityname' AND `state_id` = '$stateid' "); 
							$countcity = @mysql_num_rows($Getcity);
														
							if($countcity < 1)
							{
			$abc .= "INSERT INTO `capital_city` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ";
								//@mysql_query("INSERT INTO `capital_city` (`city_name`,`state_id`,`refresh`) VALUES ('$cityname','$stateid','1') ");
								$Getcity1 = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` =  '".$cityname."'  "); 
								$fetchcity1 = @mysql_fetch_array($Getcity1);
								$city_id = $fetchcity1['city_id'];
							}
							else
							{
								$abc .= "TEST";
								$fetchcity1 = @mysql_fetch_array($Getcity);
								$city_id = $fetchcity1['city_id'];
							}

							if(isset($event['image']) && !empty($event['image']))
							{

									
							//@mysql_query("INSERT INTO `forum` (`forum`,`forum_img`,`image_thumb`,`forum_video`,`user_id`,`added_on`,`city_id`,`status`,`user_type`,`post_from`,`event_date`,`event_address`,`description`,`venue_name`,`event_category`)
							 //		VALUES ('$eventname','$forumimage','$forumthumb','','','$added_on', '$city_id', '1','user','city_forum','$eventtime','$fulladdress','$description','$venuename','$catid' )	 ");
							$flag = "ON";
							}
						}
						
				}
			} // END FOR LOOP

		}
	
	}//END WHILE FOR CATEGORIES
	

mail("sumit.manchanda@kindlebit.com","My subject",$abc);
}

?>	