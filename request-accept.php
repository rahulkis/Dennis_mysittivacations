<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if($_REQUEST['f_id'])
{
	$update="update friends set status='active' where id='".$_REQUEST['f_id']."'";
	mysql_query($update);

  	// $ins_id = mysql_insert_id();
   	$shout_added_on = date('Y-m-d h:i:s');
   	$c_identifier = "friends_".$_REQUEST['f_id'];
   	mysql_query("UPDATE user_notification set type = 'friend_request_accept' WHERE common_identifier = '".$c_identifier."'");

	$getrs="select * from friends where id='".$_REQUEST['f_id']."'";
	$rs=mysql_query($getrs);
	$friends=mysql_fetch_array($rs);

	$c_date=date('Y-m-d H:i:s');
	$ValueArray = array($friends['friend_id'],$friends['user_id'],'active',$friends['friend_type'],$friends['user_type']);
	$FieldArray = array('user_id','friend_id','status','user_type','friend_type');
	$Success = $Obj->Insert_Dynamic_Query("friends",$ValueArray,$FieldArray);

	$getArtistList = mysql_query("SELECT * FROM `artist_list` WHERE `artist_id` = '$_SESSION[user_id]' AND `host_id` = '$friends[friend_id]' ");
	if(mysql_num_rows($getArtistList) > 0)
	{
		$fetchResult = mysql_fetch_assoc($getArtistList);
		mysql_query("UPDATE `artist_list` SET `status` = 'active' ");
	}


	$getCurrentUserFriends = mysql_query("SELECT * FROM `friends` WHERE `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' AND `status` = 'active' ");
	$getFriendUserFriends = mysql_query("SELECT * FROM `friends` WHERE `user_id` = '$friends[friend_id]' AND `user_type` = '$friends[friend_type]' AND `status` = 'active' ");

	$allFriendsarray = array();
	$i = 0;
	
	while($res = mysql_fetch_assoc($getFriendUserFriends))
	{
		if($res['friend_type'] == 'user')
		{
			$checkUser = mysql_query("SELECT `id` FROM `user` WHERE `id` = '$res[friend_id]'  ");
			if(mysql_num_rows($checkUser) > 0)
			{
				$allFriendsarray[$i]['id'] = $res['friend_id'];
				$allFriendsarray[$i]['type'] = $res['friend_type'];
				
			}
		}
		elseif($res['friend_type'] == 'club')
		{
			$checkUser = mysql_query("SELECT `id` FROM `clubs` WHERE `id` = '$res[friend_id]'  ");
			if(mysql_num_rows($checkUser) > 0)
			{
				$allFriendsarray[$i]['id'] = $res['friend_id'];
				$allFriendsarray[$i]['type'] = $res['friend_type'];
				
			}
		}
		$i++;
		
	}

	$y = $i;


	while($result = mysql_fetch_assoc($getCurrentUserFriends))
	{
		if($result['friend_type'] == 'user')
		{
			$checkUser = mysql_query("SELECT `id` FROM `user` WHERE `id` = '$result[friend_id]'  ");
			if(mysql_num_rows($checkUser) > 0)
			{
				$allFriendsarray[$i]['id'] = $result['friend_id'];
				$allFriendsarray[$i]['type'] = $result['friend_type'];
				
			}
		}
		elseif($result['friend_type'] == 'club')
		{
			$checkUser = mysql_query("SELECT `id` FROM `clubs` WHERE `id` = '$result[friend_id]'  ");
			if(mysql_num_rows($checkUser) > 0)
			{
				$allFriendsarray[$i]['id'] = $result['friend_id'];
				$allFriendsarray[$i]['type'] = $result['friend_type'];
				
			}
		}
		$y++;
	}

	$items_thread = array_unique($allFriendsarray, SORT_REGULAR);


	if($friends['user_type'] == 'user')
	{
		$getINFO = mysql_query("SELECT `profilename` as `profilename` FROM `user` WHERE `id` = '$friends[user_id]' ");
	}
	else
	{
		$getINFO = mysql_query("SELECT `club_name` as `profilename` FROM `clubs` WHERE `id` = '$friends[user_id]' ");
	}
	$RESULT = mysql_fetch_assoc($getINFO);
	$UserName = $RESULT['profilename'];


	if($friends['friend_type'] == 'user')
	{
		$getINFO1 = mysql_query("SELECT `profilename` as `profilename` FROM `user` WHERE `id` = '$friends[friend_id]' ");
	}
	else
	{
		$getINFO1 = mysql_query("SELECT `club_name` as `profilename` FROM `clubs` WHERE `id` = '$friends[friend_id]' ");
	}

	$RESULT1 = mysql_fetch_assoc($getINFO1);
	$UserName1 = $RESULT1['profilename'];


	foreach( $items_thread as $r )
	{
		mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)
				VALUES('".$_SESSION['user_id']."', '".$r['id']."', 'become_friends', '".$shout_added_on."', '1', '$UserName And $UserName1 are now friends.', '".$_SESSION['user_type']."', '".$r['type']."')");
	}



   	echo "Accepted";
}
?>