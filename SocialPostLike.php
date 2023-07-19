<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
// echo "<pre>"; print_r($_SESSION); exit;
ini_set("display_errors", "1");
error_reporting(E_ALL);
if($_POST['action'] == 'FBlike')
{
	$postID = $_POST['postID'];
	require_once 'FacebookV5/autoload.php';

	$fb = new Facebook\Facebook([
		'app_id' => '1027910397223837',
		'app_secret' => '00175be1ff4053b4cb22bca7b51b947a',
		'default_graph_version' => 'v2.6',
	]);

	$helper = $fb->getCanvasHelper();
	// echo $_SESSION['facebook_access_token'];
	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	if($_POST['todo'] == 'like')
	{

		
		try {
			
			$response = $fb->post('/'.$postID.'/likes');
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$likes_request = $fb->get('/'.$postID.'/likes?limit=100000');
		$likes_response = $likes_request->getGraphEdge()->asArray();
		$likesCount = count($likes_response);
		echo $likesCount;
	?>
	++++<a title="Like" onclick="likeFBPost('<?php echo $postID?>','unlike');" href="javascript:void(0);"><img alt="" src="https://mysittidev.com/images/insta_liked.png"></a>
		<?php 
		exit;
	}
	elseif($_POST['todo'] == 'unlike')
	{

		try {
			
			$response = $fb->delete('/'.$postID.'/likes');
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$likes_request = $fb->get('/'.$postID.'/likes?limit=100000');
		$likes_response = $likes_request->getGraphEdge()->asArray();
		$likesCount = count($likes_response);
		echo $likesCount;
		?>
	++++<a title="UnLike" onclick="likeFBPost('<?php echo $postID?>','like');" href="javascript:void(0);"><img alt="" src="https://mysittidev.com/images/insta_ulliked.png"></a>
		<?php 
		exit;
	}
}
