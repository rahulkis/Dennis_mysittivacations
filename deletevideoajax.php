<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if($_POST['action'] == "deletemusic")
{
	$id = $_POST['id'];
	
	$get_file_sql = @mysql_query("SELECT musicpath FROM `dj_video` WHERE `id` = '$id'");
	$get_file_path = mysql_fetch_assoc($get_file_sql);
	$file_path = $get_file_path['musicpath'];
	
	$sql = @mysql_query("DELETE FROM `dj_video` WHERE `id` = '$id' ");
	if($sql)
	{
		echo '<div id="successmessage" class="message" >Record Deleted Successfully.</div>';
		
		$file = $file_path;
		unlink($file);
	}
	
}

//if($_POST['action'] == "deletecd")
//{
//	
//	$id = $_POST['id'];
//	//echo "DELETE FROM `cds` WHERE `id` = '$id' ";die('dfdf');
//	$sql = @mysql_query("DELETE FROM `cds` WHERE `id` = '$id' ");
//	$sql = @mysql_query("DELETE FROM `cd_tracks` WHERE `cd_id` = '$id' ");
//	if($sql)
//	{
//		echo '<div id="successmessage" class="message" >Record Deleted Successfully.</div>';	
//	}
//	
//}


?>