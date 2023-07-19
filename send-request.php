<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "Artist")
{
	$from_user_type = $_REQUEST['from_user_type'];
	$to_user_type = $_REQUEST['to_user_type'];
	$c_date=date('Y-m-d H:i:s');
	$da = date('YmdHis');
	if($_REQUEST['todo'] == "friendalso")
	{
	
		$ValueArray = array($_SESSION['user_id'],$_REQUEST['friend_id'],'pending',$from_user_type,$to_user_type);
		$FieldArray = array('friend_id','user_id','status','user_type','friend_type');
		$Success = $Obj->Insert_Dynamic_Query("friends",$ValueArray,$FieldArray);
	   
		$ins_id=mysql_insert_id();
		$shout_added_on = date('Y-m-d h:i:s');
		$c_identifier = "artist_".$da;
		mysql_query("INSERT INTO `artist_list` (`artist_id`,`host_id`,`status`) VALUES ('$_REQUEST[friend_id]','$_SESSION[user_id]','pending')  ");
		mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$_REQUEST['friend_id']."', 'artist_request_sent', '".$shout_added_on."', '1', '".$c_identifier."', '".$from_user_type."', '".$to_user_type."')");
			
		echo "Requested";
	}
	elseif($_REQUEST['todo'] == "artistonly")
	{
		$c_identifier = "artist_".$da;
		mysql_query("INSERT INTO `artist_list` (`artist_id`,`host_id`,`status`) VALUES ('$_REQUEST[friend_id]','$_SESSION[user_id]','pending')  ");
		mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$_REQUEST['friend_id']."', 'artist_request_sent', '".$shout_added_on."', '1', '".$c_identifier."', '".$from_user_type."', '".$to_user_type."')");
		echo "Requested";
	}
	
}
elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == "fighter")
{
	$from_user_type = $_REQUEST['from_user_type'];
	$to_user_type = $_REQUEST['to_user_type'];
	$c_date=date('Y-m-d H:i:s');
	
	$ValueArray = array($_SESSION['user_id'],$_REQUEST['friend_id'],'pending',$from_user_type,$to_user_type);
	$FieldArray = array('friend_id','user_id','status','user_type','friend_type');
	$Success = $Obj->Insert_Dynamic_Query("friends",$ValueArray,$FieldArray);
   
	$ins_id=mysql_insert_id();
	$shout_added_on = date('Y-m-d h:i:s');
	$c_identifier = "friends_".$ins_id;
	mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$_REQUEST['friend_id']."', 'friend_request_sent', '".$shout_added_on."', '1', '".$c_identifier."', '".$from_user_type."', '".$to_user_type."')");
		
	echo "Requested";
}
else
{
	if($_REQUEST['friend_id'])
	{

		$from_user_type = $_REQUEST['from_user_type'];
		$to_user_type = $_REQUEST['to_user_type'];
		$c_date=date('Y-m-d H:i:s');
		//if($to_user_type == "user")
		//{
		//	die('if');
			$ValueArray = array($_SESSION['user_id'],$_REQUEST['friend_id'],'pending',$_SESSION['user_type'],$to_user_type);
			$FieldArray = array('user_id','friend_id','status','user_type','friend_type');
			$Success = $Obj->Insert_Dynamic_Query("friends",$ValueArray,$FieldArray);

		//}
		//else
		//{
		//	die('dfdfdf');
			//$ValueArray = array($_REQUEST['friend_id'],$_SESSION['user_id'],'pending',$to_user_type,$from_user_type);
			//$FieldArray = array('user_id','friend_id','status','user_type','friend_type');
			//$Success = $Obj->Insert_Dynamic_Query("friends",$ValueArray,$FieldArray);
		//}
		
	   
		$ins_id=mysql_insert_id();
		$shout_added_on = date('Y-m-d h:i:s');
		$c_identifier = "friends_".$ins_id;
	   
	   	mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$_REQUEST['friend_id']."', 'friend_request_sent', '".$shout_added_on."', '1', '".$c_identifier."', '".$from_user_type."', '".$to_user_type."')");
		
		echo "Requested";
	}
}
?>