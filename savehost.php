<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_POST['host_id'];
if($id!="" && $_POST['action']=='request')
{
//	echo "<pre>"; prin
	$ThisPageTable='friends';

	if($_SESSION['user_type'] == "user")
	{
		// die("yes") ;
		$ValueArray = array($id,$_SESSION['user_id'],'active','club','user');	
		$FieldArray = array('user_id','friend_id','status','user_type','friend_type');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		
		$ValueArray = array($_SESSION['user_id'],$id,'active','club','user');	
		$FieldArray = array('user_id','friend_id','status','friend_type','user_type');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		echo "success";
	}
	else
	{
		// die("else") ;
		$ValueArray = array($id,$_SESSION['user_id'],'active','club','club');	
		$FieldArray = array('user_id','friend_id','status','user_type','friend_type');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		
		$ValueArray = array($_SESSION['user_id'],$id,'active','club','club');	
		$FieldArray = array('user_id','friend_id','status','friend_type','user_type');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		echo "success";
	}
}
else if($_POST['action']=='unblock')
{
	$sql="update friends set status='active' where friend_id='".$id."' AND user_id='".$_SESSION['user_id']."' AND  friend_type='club'";
	@mysql_query($sql);
	echo "unblocked";
}
 else
{
	$sql="update friends set status='block' where friend_id='".$id."' AND user_id='".$_SESSION['user_id']."' AND  friend_type='club'";
	@mysql_query($sql);
	echo "blocked";
}

?>
