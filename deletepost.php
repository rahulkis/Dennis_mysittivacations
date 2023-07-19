<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];
$forum_id = $_GET['forum_id'];
$action = $_GET['action'];

if($action == "delcitytalk")
{
	$sql="delete from forum where forum_id = '".$id."'";
	 mysql_query($sql);
	 $_SESSION['popup_add_post'] = "DELETED";
}
elseif($id!=""){
 $sql="delete from forum where common_identifier = '".$id."'";
 mysql_query($sql);
 $_SESSION['popup_add_post'] = "DELETED";
}else{
 $sql="delete from forum where forum_id = '".$forum_id."'";
 mysql_query($sql);
 $_SESSION['popup_add_post'] = "DELETED"; 
}

?>
