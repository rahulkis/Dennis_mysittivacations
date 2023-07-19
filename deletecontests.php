<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];
if($id!=""){
  if($_GET['type']=='friend')
  {
	   if($_GET['action']=='shout')
	   {
	   $sql="delete from user_to_content where cont_id='".$id."' AND  user_id='".$_SESSION['user_id']."' AND  cont_type='shout'";
	   }else
	   {
	    $sql="delete from user_to_content where cont_id='".$id."' AND  user_id='".$_SESSION['user_id']."' AND  cont_type='content'";
	    }
 		mysql_query($sql);
  }else 
  {
		$sql="delete from contest where contest_id='".$id."'";
		mysql_query($sql);

		$sql2=mysql_query("delete from user_to_content where cont_id='".$id."' AND owner_id='".$_SESSION['user_id']."'");

		$sql2="delete from  contestent where contest_id='".$id."'";
		mysql_query($sql2);
		
		$common_identifier = "contest_".$id;
		mysql_query("DELETE FROM user_notification WHERE common_identifier = '".$common_identifier."'");
  }
 //header('Location: user_shout.php');
}

?>
