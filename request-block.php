<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if($_REQUEST['f_id'] && ($_REQUEST['action'] == 'block' ) && $_REQUEST['page'] == "connection" )
{

	// $getrs="select * from friends where id='".$_REQUEST['f_id']."'";
	// $rs=mysql_query($getrs);
	// $friends=@mysql_fetch_array($rs);

	$update="DELETE FROM friends WHERE friend_id='".$_REQUEST['f_id']."'  AND friend_type = '$_REQUEST[friendtype]' AND user_type= '$_SESSION[user_type]' AND  user_id = '".$_SESSION['user_id']."' ";
	@mysql_query($update);

	@mysql_query("DELETE FROM friends WHERE user_id='".$_REQUEST['f_id']."'  AND friend_type = '$_SESSION[user_type]' AND user_type= '$_REQUEST[friendtype]' AND friend_id = '".$_SESSION['user_id']."' ");

	//$update="update friends set status='block' where  user_id='".$friends['friend_id']."' AND friend_id='".$friends['user_id']."'";
	//@mysql_query($update);
	@mysql_query("DELETE FROM user_to_content WHERE user_id ='".$_REQUEST['f_id']."' AND owner_id = '".$_SESSION['user_id']."'  ");
	@mysql_query("DELETE FROM user_to_content WHERE owner_id ='".$_REQUEST['f_id']."' AND user_id = '".$_SESSION['user_id']."'  ");

	echo "Removed";
}
elseif($_REQUEST['f_id'] && ($_REQUEST['action'] == 'block' ) && !isset($_REQUEST['page']) )
{

	$getrs="select * from friends where id='".$_REQUEST['f_id']."'";
	$rs=mysql_query($getrs);
	$friends=@mysql_fetch_array($rs);

	/*$update="DELETE FROM friends WHERE friend_id='".$_REQUEST['f_id']."'  AND friend_type = 'user' AND user_type= 'user' AND  user_id = '".$_SESSION['user_id']."' ";
	@mysql_query($update);

	@mysql_query("DELETE FROM friends WHERE user_id='".$_REQUEST['f_id']."'  AND friend_type = 'user' AND user_type= 'user' AND friend_id = '".$_SESSION['user_id']."' ");

	//$update="update friends set status='block' where  user_id='".$friends['friend_id']."' AND friend_id='".$friends['user_id']."'";
	//@mysql_query($update);
	@mysql_query("DELETE FROM user_to_content WHERE user_id ='".$_REQUEST['f_id']."' AND owner_id = '".$_SESSION['user_id']."'  ");
	@mysql_query("DELETE FROM user_to_content WHERE owner_id ='".$_REQUEST['f_id']."' AND user_id = '".$_SESSION['user_id']."'  ");*/
	$update="DELETE FROM friends WHERE friend_id='".$friends['friend_id']."'  AND friend_type = '$friends[friend_type]' AND user_type= '$_SESSION[user_type]' AND  user_id = '".$_SESSION['user_id']."' ";
	@mysql_query($update);

	@mysql_query("DELETE FROM friends WHERE user_id='".$friends['friend_id']."'  AND friend_type = '$_SESSION[user_type]' AND user_type= '$friends[friend_type]' AND friend_id = '".$_SESSION['user_id']."' ");

	//$update="update friends set status='block' where  user_id='".$friends['friend_id']."' AND friend_id='".$friends['user_id']."'";
	//@mysql_query($update);
	@mysql_query("DELETE FROM user_to_content WHERE user_id ='".$friends['friend_id']."' AND owner_id = '".$_SESSION['user_id']."' AND user_type = '$friends[friend_type]' AND friend_type= '$_SESSION[user_type]'");
	@mysql_query("DELETE FROM user_to_content WHERE owner_id ='".$friends['friend_id']."' AND user_id = '".$_SESSION['user_id']."' AND friend_type = '$friends[friend_type]' AND user_type= '$_SESSION[user_type]'");

	echo "Removed";
}
// elseif($_REQUEST['f_id'] && ($_REQUEST['action'] == 'unblock' ) )
// {	

// 	// $getrs="select * from friends where id='".$_REQUEST['f_id']."'";
// 	// $rs=mysql_query($getrs);
// 	// $friends=@mysql_fetch_array($rs);

// 	//$update="update friends set status='active' where id='".$_REQUEST['f_id']."'";
// 	//@mysql_query($update);

// 	//$update="update friends set status='active' where  user_id='".$friends['friend_id']."' AND friend_id='".$friends['user_id']."'";
// 	//@mysql_query($update);


// 	//echo "UnBlocked";
// } 
?>