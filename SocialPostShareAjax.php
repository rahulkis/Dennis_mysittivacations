<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

if($_POST['action'] == 'fbpostshare')
{
	// include required files form Facebook SDK
	require_once 'FacebookV5/autoload.php';
	$fb = new Facebook\Facebook([
		'app_id' => '1027910397223837',
		'app_secret' => '00175be1ff4053b4cb22bca7b51b947a',
		'default_graph_version' => 'v2.6',
	]);


	$permissions = ['email', 'user_posts','publish_actions']; // optional
	$redirect_url = $SiteURL.'searchEvents.php';
	$callback = $SiteURL.'searchEvents.php';
	$helper = $fb->getCanvasHelper();
	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

	$EventId = $_POST['eventid'];
	$geteventInfo = mysql_query("SELECT * FROM `forum` WHERE `forum_id` = '$EventId' ");
	$Result = mysql_fetch_assoc($geteventInfo);

	if($Result['forum_img'] != "")
	{
		if($Result['user_id'] == 0)
		{
			$image =$Result['forum_img'];
		}
		else
		{
			$image = $SiteURL.str_replace("../", "" , $Result['forum_img'] );	
		}
		
	}
	else
	{
		$eventimage = $Result['event_category'].".jpg";
		$image = $SiteURL."events_icons/".$eventimage;	
	}
	$data = array();
	$data = [
		'message' => $Result['forum'],
		'link' => $SiteURL.'read_more_cityevent.php?id='.$EventId,
		'picture' => $image,
		'description' => $Result['description'],
	];
	$response = $fb->post('/me/feed', $data);
}




?>