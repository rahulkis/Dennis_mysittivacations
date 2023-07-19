<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);



$username = $_POST['username'];
$UserID = $_POST['user_id'];
$UserType = $_POST['user_type'];
//

// mail('sumit.manchanda@kindlebit.com','Test',$_POST);

	$sql4="select distinct(fs.friend_id),fs.status as freindstatus,u.phone,u.sms_carrier,u.first_name,u.image_nm,u.last_name,u.country,u.state,u.city,u.status,u.zipcode,fs.chat,fs.id as f_id from friends as fs,
			user as u
			where u.id=fs.friend_id AND fs.user_id='".$_POST['user_id']."' AND fs.friend_id != 1 AND fs.friend_type='user' AND fs.status IN ('active','block')
			GROUP BY friend_id ORDER BY u.zipcode ASC";
	$sql6=@mysql_query($sql4);
if(mysql_num_rows($sql6) > 0)
{
	while($smsCode = mysql_fetch_array($sql6))
	{
		if($smsCode['sms_carrier'] != 0)
		{
			$getSMS = mysql_query("SELECT * FROM `sms_carriers` WHERE `id` = '$smsCode[sms_carrier]' ");
			$fetchSMS = mysql_fetch_array($getSMS);

			$contactSMS = $smsCode['phone'].$fetchSMS['carrier_mail'];
			// $contactSMS = str_replace("-", "", $smsCode['phone']).$fetchSMS['carrier_mail'];
			// $contactSMS = 'hvongphit@gmail.com';					
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: mysittidev.com <mysitti@mysittidev.com>' . "\r\n";
			// $subject = $username." Live Streaming";
			$message =  "View Stream:";
		  	$message .= " <a href='https://mysittidev.com/live2/channel.php?n=".$username."&host_id=".$UserID."&user_type=".$UserType."'>https://mysittidev.com/live2/channel.php?n=".$username."&host_id=".$UserID."&user_type=".$UserType."</a>";
			mail($contactSMS,$subject,$message,$headers,"-finfo@mysittidev.com");
		}
	}
}


$currentTime = date('Y-m-d H:i:s');
$curdate = date('Y-m-d');

$getBroacastinfo = mysql_query("SELECT * FROM `broadcast_settings` WHERE `user_id` = '$UserID' AND `user_type` = '$UserType' ");

mysql_query("INSERT INTO `broadcast_settings` (`user_id`,`user_type`,`broadcast_time`,`check_date`) VALUES ('$UserID','$UserType','$currentTime','$curdate') ");




/* GROUP CHAT CODE */

$getAutoChat = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$UserID'  ");
$fetchAutoChat = mysql_fetch_array($getAutoChat);

$clubName = $username;

$checkGroup = mysql_query("SELECT * FROM `chat_groups` WHERE `create_by` = '$UserID'  AND `user_type` = '$UserType' AND `group_type` = 'streaming' ");
$fetchGroup = mysql_fetch_array($checkGroup);

mysql_query("DELETE FROM `chat_users_groups` WHERE `user_id` = '0' ");
$getChatUsers = mysql_query("SELECT * FROM `chat_users_groups` WHERE `group_id` = '$fetchGroup[id]' ");
$countUsers = mysql_num_rows($getChatUsers);

if($fetchAutoChat['auto_chat'] == "enable" && mysql_num_rows($checkGroup)  == "0" && $UserType == "club")
{
	//mail('sumit.manchanda@kindlebit.com','Test','1');
	if(!empty($UserID) && $UserID != '0')
	{
		mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 
			VALUES ('$clubName','streaming','$UserID','$UserType') ");
		$ID = mysql_insert_id();
		mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type,loggedin) VALUES ('$ID','$UserID','$UserType','1')");
	}

}
if(mysql_num_rows($checkGroup)  == "0" && $UserType == "user")
{
	//mail('sumit.manchanda@kindlebit.com','Test','2');
	if(!empty($UserID) && $UserID != '0')
	{
		mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 
			VALUES ('$clubName','streaming','$clubId','$UserType') ");
		$ID = mysql_insert_id();
		mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type,loggedin) VALUES ('$ID','$UserID','$UserType','1')");
	}
}
// elseif($fetchAutoChat['auto_chat'] == "enable" && $countUsers < 1 && mysql_num_rows($checkGroup) > 0 && $UserType == "user")
// {
// 	// echo "INSERT INTO chat_users_groups (group_id,user_id,user_type) VALUES ('$fetchGroup[id]','$clubId','$_SESSION[user_type]')";
// 	// die('2');
// 	mail('sumit.manchanda@kindlebit.com','Test','3');
// 	mysql_query("INSERT INTO `chat_users_groups` (`group_id`,`user_id`,`user_type`) VALUES ('$fetchGroup[id]','$clubId','$UserType')");
// 	$ID = $fetchGroup['id'];
// }
// elseif($fetchAutoChat['auto_chat'] == "enable" && $UserType == "club" && mysql_num_rows($checkGroup) > 0 && $countUsers > 0)
// {
// 	mail('sumit.manchanda@kindlebit.com','Test','4');
// 	$ID = $fetchGroup['id'];
// }
// elseif($UserType == "user" && mysql_num_rows($checkGroup) > 0 && $countUsers > 0)
// {
// 	mail('sumit.manchanda@kindlebit.com','Test','5');
// 	$ID = $fetchGroup['id'];
// }


mysql_query("DELETE FROM `chat_groups` WHERE `create_by` = '0'  ");
mysql_query("DELETE FROM `chat_users_groups` WHERE `user_id` = '0'  ");

/* END HERE */



if($UserType == "user")
{
	$SQL = mysql_query("SELECT `saved_streaming`,`streamingLaunch`,`streamingLaunchFrom` FROM `user` WHERE `id` = '$UserID' ");
	
}
else
{
	$SQL = mysql_query("SELECT `saved_streaming`,`streamingLaunch`,`streamingLaunchFrom` FROM `clubs` WHERE `id` = '$UserID' ");
	
}

$getResult = mysql_fetch_assoc($SQL);

if($getResult['streamingLaunch'] == '0')
{
	if($UserType == 'user')
	{
		mysql_query("UPDATE `user` SET `streamingLaunch` = '1',`streamingLaunchFrom` = 'encoder', `newStreamUrl` = '' WHERE `id` = '$UserID'  ");
	}
	elseif($UserType == 'club')
	{
		mysql_query("UPDATE `clubs` SET `streamingLaunch` = '1',`streamingLaunchFrom` = 'encoder', `newStreamUrl` = '' WHERE `id` = '$UserID'  ");
	}
}







if($getResult['saved_streaming'] == "1")
{
	$n=$username;
	$path = $_SERVER['DOCUMENT_ROOT'].'/savedStreaming/'.$n.'/';

	if (!file_exists($path) && !is_dir($path))
	{
		$oldmask = umask(0);
		mkdir($path, 0777);
		umask($oldmask);
	}
	else
	{

	}

	$fname = $n.'_'.strtotime(date('Y-m-d H:i:s'));

	//$n='XHost';
	//$path='/home/mysitti/public_html/myv/xhost/';
	//$fname='xhost';
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://mysittidev.com/trigger_rec.php',
		CURLOPT_USERAGENT => 'Codular Sample cURL Request',
		
		CURLOPT_FRESH_CONNECT => true,
		CURLOPT_TIMEOUT => 1,
		
		//CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => array(
			'host_name' => $n,
			'upload_path' => $path,
			'file_name' => $fname
		)
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);


}



?>
