<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];
if($id!=""){
 $sql="delete from chat_groups where id='".$id."' and create_by=".$_SESSION['user_id'];
 mysql_query($sql);
$_SESSION['success']="yes";
 //header('Location: manage_groups.php');
}

?>
