<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];

if(isset($_GET['friend_type'])){
 
  mysql_query("DELETE FROM user_to_content WHERE cont_id='".$id."' AND friend_type = 'club' AND user_id = '".$_SESSION['user_id']."'");
  $_SESSION['s_deleted'] = "success";
 
}else{
 
  if($id!=""){
   $sql="delete from shouts where id='".$id."'";
   mysql_query($sql);
  $sql2=@mysql_query("DELETE  FROM  user_to_content WHERE cont_id='".$id."' AND cont_type='shout' ");
  $sql3 = @mysql_query(" DELETE FROM `shout_count` WHERE `shout_id` = '".$id."'  ");
  $sql4 = @mysql_query(" DELETE FROM `forum` WHERE `shout_id` = '".$id."'  ");
		@mysql_query($sshoutsql);
		$_SESSION['s_deleted'] = "success";
   //header('Location:user_shout.php');
  }
}
?>
