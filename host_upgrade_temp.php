<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
$currendate = date('Y-m-d H:i:s');
$previous_date = date('Y-m-d H:i:s', strtotime($currendate .' -1 day'));

$end = date('Y-m-d'); // or your date as well

$get_temps = mysql_query("SELECT * FROM host_upgrade_temp");
if(mysql_num_rows($get_temps) > 0)
{
	while($row = mysql_fetch_assoc($get_temps))
	{
		$contID = $row['contest_id'];
		$contestQuery = mysql_query("SELECT * FROM `contest` WHERE `contest_id` = '$contID' ");
		$contestResult = mysql_fetch_assoc($contestQuery);
		$host_ID = $row['host_id'];
		$endDate = date('Y-m-d',strtotime($contestResult['battle_date_end']));

		if(strtotime($end) > strtotime($endDate))
		{
			mysql_query("UPDATE `clubs` SET `plantype` = 'host_free' WHERE `id` = '$host_ID' ");	
			mysql_query("DELETE FROM `host_upgrade_temp` WHERE `hid` = '$row[hid]' ");
		}
	}
}


?>