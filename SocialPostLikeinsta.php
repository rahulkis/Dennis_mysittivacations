<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
// echo "<pre>"; print_r($_SESSION); exit;
if($_POST['action'] == 'Instalike')
{
	$postID = $_POST['postID'];
	require 'InstagramSDK/src/Instagram.php';
	$instagram = new Instagram(array(
		'apiKey'      => '92f139720df84559ab02e9a5b3ddad94',
		'apiSecret'   => '20a722870a9d4a0cabe4c85345d21a23',
		'apiCallback' => 'https://mysittidev.com/SocialPostLikeinsta.php'
	));
	$token = $_SESSION['instadetails']->access_token;
	$instagram->setAccessToken($token);
	


	


	if($_POST['todo'] == 'like')
	{
		$result = $instagram->likeMedia($postID);
		// shell_exec("curl -F 'access_token=".$token."' \ https://api.instagram.com/v1/media/"$postID"/likes",$result);
		$mediaLikes = $instagram->getMedia($postID); 
		echo $mediaLikes->data->likes->count;
	?>++++<a title="Like" onclick="likeInstaPost('<?php echo $postID?>','unlike');" href="javascript:void(0);"><img alt="" src="https://mysittidev.com/images/insta_liked.png"></a>
		<?php 
		exit;
	}
	elseif($_POST['todo'] == 'unlike')
	{

		$result = $instagram->deleteLikedMedia($postID);
		$mediaLikes = $instagram->getMedia($postID); 
		echo $mediaLikes->data->likes->count;
		?>++++<a title="UnLike" onclick="likeInstaPost('<?php echo $postID?>','like');" href="javascript:void(0);"><img alt="" src="https://mysittidev.com/images/insta_ulliked.png"></a>
		<?php 
		exit;
	}
}