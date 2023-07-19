<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);

if($_POST['action'] == "checkGroup")
{
	$title = $_POST['title'];
	$SQL = mysql_query("SELECT * FROM `chat_groups` WHERE `group_name` = '$title' ");
	$SQL1 = mysql_query("SELECT * FROM `clubs` WHERE `club_name` = '$title' ");
	$SQL2 = mysql_query("SELECT * FROM `user` WHERE `profilename` = '$title' ");
	if(mysql_num_rows($SQL) > 0 || mysql_num_rows($SQL1) > 0 || mysql_num_rows($SQL2) > 0  )
	{
		echo "Yes";
	}
	else
	{
		echo "No";
	}
}

?>