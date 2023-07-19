<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
if(isset($_POST['splitsrc']))
	{
		$gethostdjprofile  = "select hostdj_gallery_pic from host_dj_profile where host_id = ".$_SESSION['user_id'] ;
		$resulquerythostdjprofile = @mysql_query($gethostdjprofile);
		$resulthostdjprofile = @mysql_fetch_assoc($resulquerythostdjprofile);
	        $resulthostdjprofile1 = $resulthostdjprofile['hostdj_gallery_pic'];
		
		$update = str_replace($_REQUEST['splitsrc'].",","",$resulthostdjprofile1);
		@mysql_query("UPDATE `host_dj_profile` SET `hostdj_gallery_pic` = '$update' WHERE `host_id` =".$_SESSION['user_id']);
		
		return false;		
			
	}
	
	
	if(isset($_POST['removeprofileimage']))
	{
		//echo "DELETE hostdj_profile_pic FROM `host_dj_profile` WHERE `host_id` = '".$_SESSION['user_id']."'";
	
		//@mysql_query("DELETE hostdj_profile_pic FROM `host_dj_profile` WHERE `host_id` = '".$_SESSION['user_id']."'");
		
		@mysql_query("UPDATE `host_dj_profile` SET `hostdj_profile_pic` = '' WHERE `host_id` =".$_SESSION['user_id']);
		
		return false;		
			
	}


?>