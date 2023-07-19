<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
set_time_limit(0);


$citystring = "";

$getstates = mysql_query("SELECT * FROM `zone` WHERE `country_id` IN ('223','38') ");
while($res = mysql_fetch_array($getstates))
{
	$stateid = $res['zone_id']; 
	$getcities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateid' ");
	while($row = mysql_fetch_array($getcities))
	{
		$cityid = $row['city_id'];
		$cdate = date('Y-m-d H:i:s');
		$cityname = $row['city_name'];
		$checkcron = mysql_query("SELECT `id` FROM `citycron` WHERE `city_id` = '$cityid' ");
		if(mysql_num_rows($checkcron) < 1)
		{		
			//echo "SELECT `forum`  FROM `forum` WHERE `city_id` = '$cityid' AND `event_date` >= '$cdate' "; exit;
			$getresult = mysql_query("SELECT `forum`  FROM `forum` WHERE `city_id` = '$cityid' AND `event_date` >= '$cdate' ");
			$countres = mysql_num_rows($getresult);
			if($countres < 1)
			{
				mysql_query("INSERT INTO `capital_city_old` (`city_id`,`state_id`,`city_name`) VALUES ('$cityid','$stateid','$cityname') ");
				
			}
			mysql_query("INSERT INTO `citycron` (`city_id`,`state_id`) VALUES ('$cityid','$stateid') ");
		}
		
		
	}

}
