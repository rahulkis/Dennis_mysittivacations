<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if($_POST['action'] == "deletemusic")
{
	$id = $_POST['id'];
	$sql = @mysql_query("DELETE FROM `music` WHERE `id` = '$id' ");
	if($sql)
	{
		echo '<div id="successmessage" class="message" >Record Deleted Successfully.</div>';	
	}
	
}

if($_POST['action'] == "deletecd")
{
	
	$id = $_POST['id'];
	//echo "DELETE FROM `cds` WHERE `id` = '$id' ";die('dfdf');
	$sql = @mysql_query("DELETE FROM `cds` WHERE `id` = '$id' ");
	$sql = @mysql_query("DELETE FROM `cd_tracks` WHERE `cd_id` = '$id' ");
	if($sql)
	{
		echo '<div id="successmessage" class="message" >Record Deleted Successfully.</div>';	
	}
	
}


?>