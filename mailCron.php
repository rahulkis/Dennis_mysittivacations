<?php
include("Query.Inc.php");
set_time_limit(0);
$Obj = new Query($DBName);
error_reporting(E_ALL);
ini_set('display_errors', '1');
$currendate = date('Y-m-d');
$next_date = date('Y-m-d', strtotime($currendate .' +1 day'));
$month = date('m');
$year =date('Y');
 //mail("raman.deep@kindlebit.com","My subject22","test"); exit;
$query = "SELECT * FROM `forum` as f, `user_events` as uv WHERE uv.forum_id = f.forum_id AND uv.mail_status = '' ";
$sql = mysql_query($query);
while($row = mysql_fetch_array($sql))
{
	$userid = $row['uid'];
	$getuserinfo = mysql_query("SELECT `profilename`,`first_name`,`last_name`,`email`,`reminderhours` FROM `user` WHERE `id` = '$userid' ");
	$fetchuserinfo = mysql_fetch_array($getuserinfo);

	$eventtime = strtotime($row['event_date']);
	if($fetchuserinfo['reminderhours'] == '0')
	{
		$hours = 24;
	}
	else
	{
		$hours = $fetchuserinfo['reminderhours'];
	}

	echo $meeting_time = date('Y-m-d H', $eventtime - 60 * 60 * $hours); echo "<br>";
	echo $currenttime = date('Y-m-d H');echo "<br><br><br>";
	if($meeting_time == $currenttime)
	{

		if($fetchuserinfo['profilename'] != "")
		{
			$username = $fetchuserinfo['profilename'];
		}
		else
		{
			$username = $fetchuserinfo['first_name']." ".$fetchuserinfo['last_name'];
		}

		$message = "<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
			<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
			<hr>
			<p style='color: white;'>";
		$message .= "Hi ".$username.", <br><br>";
		$message .= "This Is a reminder mail that you have an upcoming Event. Below is the event Details: <br><br>";
		$message .= "<b>Event Name:</b> ".$row['forum']."<br>";
		$message .= "<b>Event Date: </b>".$row['event_date']."<br>";
		$message .= " <b>Event Address: </b>".$row['event_address']."<br><br>";
		$message .= " For More Information, Login to your account at <a style='color: #FECD07;' target='_blank' href='".$base_url."'>mySitti</a><br>";
		$message .= " Thanks <br>";
		$message .= " MySitti Team";
		$message .= "</p></div>";
		$subject = "Reminder For Upcoming Event!";
		// $to = "sumit.manchanda@kindlebit.com";
		$to = $fetchuserinfo['email'];

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
		$mail = mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");

		if($mail)
		{
			mysql_query("UPDATE `user_events` SET `mail_status` = 'mail_sent' WHERE `id` = '$row[id]'  ");
		}
	}
	
}