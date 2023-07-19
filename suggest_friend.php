<?
	
	$sql=mysql_query("SELECT distinct user.email FROM user join friends on user_id='".$_SESSION['user_id']."'  and friends.friend_id=user.id    union SELECT distinct clubs.club_email FROM clubs join friends on user_id=".$_SESSION['user_id']." and friends.friend_id=clubs.id "); 
 $count=mysql_num_rows($sql);
 $friendarray=array();
 $i=0;
 while($row=mysql_fetch_array($sql)){
	
	$get_email = trim($row['email']);
	
	if(!empty($get_email)){
		
		$friendarray[$i]=$get_email;
	}
	
	$i++;
 }
 ?>
 <?
		$sqlx=mysql_query("SELECT group_name  FROM `chat_groups` WHERE `create_by` = ".$_SESSION['user_id']); 
 $countx=mysql_num_rows($sqlx);
$grouparray=array();
 $i=0;
 while($rowx=mysql_fetch_array($sqlx)){
	
	$get_group_name = trim($rowx['group_name']);
	
	if(!empty($get_group_name)){
		
		$grouparray[$i]=$get_group_name;
	}	
	 $i++;
 }
 ?>
<script>
	var freindsListx=new Array();
    var grouplistx=new Array();
	<? if($friendarray){
		
	$filtered_friends_arr = array_filter($friendarray);	
	?>
	freindsListx=<? echo json_encode($filtered_friends_arr)?>;
	
	<? } ?>
		<? if($grouparray){
			
		$filtered_groups_arr = array_filter($grouparray);	
		?>
	grouplistx=<? echo json_encode($filtered_groups_arr)?>;
	
	<? } ?>
</script>
	
