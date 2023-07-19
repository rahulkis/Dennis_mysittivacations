<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID = $_POST['user_id'];
$userTYPE = $_POST['user_type'];

$currentTime = date('Y-m-d H:i:s');




$getBroadcastinfo = mysql_query("SELECT * FROM `broadcast_settings` WHERE `user_id` = '$userID' AND `user_type` = '$userTYPE' ");
$fetchBroadcastinfo = mysql_fetch_assoc($getBroadcastinfo);


mysql_query("UPDATE `broadcast_settings` SET `broadcast_end_time` = '$currentTime' WHERE `user_id` = '$userID' AND `user_type` = '$userTYPE' AND `broadcast_end_time` = '0000-00-00 00:00:00' ");


$checkGroup = mysql_query("SELECT * FROM `chat_groups` WHERE `create_by` = '$userID' AND `user_type` = '$userTYPE' ");
$fetchGroup = mysql_fetch_array($checkGroup);
mysql_query("DELETE FROM `chat_users_groups` WHERE `group_id` = '$fetchGroup[id]' ");
mysql_query("DELETE FROM `message` WHERE `group_id` = '$fetchGroup[id]' ");

mysql_query("DELETE FROM `chat_groups`WHERE `create_by` = '$userID' AND `user_type` = '$userTYPE' ");


mysql_query("DELETE FROM `chat_groups` WHERE `create_by` = '0'  ");
mysql_query("DELETE FROM `chat_users_groups` WHERE `user_id` = '0'  ");


if($userTYPE == 'user')
{
	mysql_query("UPDATE `user` SET `streamingLaunch` = '0',`streamingLaunchFrom` = '', `is_launch` = '0', `newStreamUrl` = '' WHERE `id` = '$userID'  ");
	//mail('sumit.manchanda@kindlebit.com','Test',$userID);
}
else
{
	mysql_query("UPDATE `clubs` SET `streamingLaunch` = '0', `is_launch` = '0', `streamingLaunchFrom` = '', `newStreamUrl` = '' WHERE `id` = '$userID'  ");
}



// mail('sumit.manchanda@kindlebit.com', 'Streaming Check', 'Triggered Stop streaming File!');

?>



