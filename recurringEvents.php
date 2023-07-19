<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
$currendate = date('Y-m-d H:i:s'); 
// date_default_timezone_set('America/Chicago');


// echo $newDate = date('Y-m-d H:i:s', strtotime('+7 day', strtotime($currendate)) );
// echo "<br />";
// echo $newDate = date('Y-m-d', strtotime("+1 months", strtotime($currendate)));




$getEvents = mysql_query("SELECT * FROM `events` WHERE `recurring` != 'none' ");
while($row = mysql_fetch_assoc($getEvents))
{
	if($currendate > $row['recurring_date'])
	{
		if($row['recurring'] == 'weekly')
		{
			$newDatetime = date('Y-m-d H:i:s', strtotime('+7 day', strtotime($row['recurring_date'])) );
			$newDate = date('Y-m-d', strtotime('+7 day', strtotime($row['recurring_date'])) );	
		}
		elseif($row['recurring'] == 'monthly')
		{
			$newDatetime = date('Y-m-d H:i:s', strtotime("+1 months", strtotime($row['recurring_date'])));
			$newDate = date('Y-m-d', strtotime('+7 day', strtotime($row['recurring_date'])) );
		}
		mysql_query("UPDATE `events` SET `recurring_date` = '$newDatetime', `date` = '$newDate' WHERE `id` = '$row[id]'  ");
		mysql_query("UPDATE `forum` SET `event_date` = '$newDatetime' WHERE `event_id` = '$row[id]'  ");			
	}
	
}