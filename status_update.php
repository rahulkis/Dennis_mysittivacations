<?php
//echo '<pre>';print_r($_POST);die;
include("Query.Inc.php");
$Obj = new Query($DBName);
if(isset($_POST['id']) && isset($_POST['text'])){

	$sql = "update jukeboxplaylist set status = '".$_POST['testval']."' where id =".$_POST['id'];
	mysql_query($sql);
	$query = "select * from jukeboxplaylist where id =".$_POST['id'];
	$res = mysql_query($query);
	$result = mysql_fetch_assoc($res);
	//echo '<pre>';print_r($result);die;
	$listarray = array();
	$gettrackquery = @mysql_query("SELECT * FROM `userplaylist` WHERE `id` = '".$result['playlist_id']."' ");
	$fetchres = @mysql_fetch_array($gettrackquery);
	$getliststatusquery = @mysql_query("SELECT * FROM `jukeboxplaylist` WHERE `playlist_id` = '".$result['playlist_id']."' AND `status` = '2' ");
	$countliststatus = @mysql_num_rows($getliststatusquery);
	if($countliststatus == $fetchres['total_tracks'])
	{
		$liststatus = 'Complete';
		$updatestatus =  '2';
	}
	else
	{
		$getliststatusquery = @mysql_query("SELECT * FROM `jukeboxplaylist` WHERE `playlist_id` = '".$result['playlist_id']."' AND `status` = '0' ");
		$countliststatus = @mysql_num_rows($getliststatusquery);
		if($countliststatus == $fetchres['total_tracks'])
		{
			$liststatus = 'New';
			$updatestatus =  '1';
		}
		else
		{
			//echo "SELECT * FROM `jukeboxplaylist` WHERE `playlist_id` = '".$result['playlist_id']."' AND `status` = '2' "; die;
			$getliststatusquery1 = @mysql_query("SELECT * FROM `jukeboxplaylist` WHERE `playlist_id` = '".$result['playlist_id']."' AND `status` = '2' ");
			$countliststatus1 = @mysql_num_rows($getliststatusquery1);
			if($countliststatus1 > 0)
			{
				$liststatus = 'Playing';
				$updatestatus =  '0';
			}
			
		}
	}
//echo "UPDATE `userplaylist` SET `status` = '".$updatestatus."' WHERE `id` = '".$result['playlist_id']."' "; die;
	@mysql_query("UPDATE `userplaylist` SET `status` = '".$updatestatus."' WHERE `id` = '".$result['playlist_id']."' ");




}
echo $updatestatus;	
?>
