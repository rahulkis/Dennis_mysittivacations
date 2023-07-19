<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
// echo "<pre>"; print_r($_SESSION); exit;
include('defaultimeZone.php');
// ini_set("display_errors", "1");
// error_reporting(E_ALL);
if($_POST['action'] == 'FBComment')
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
	if($_POST['todo'] == 'postcomment')
	{
		$data = array();
		$data = [
			'message' => $_POST['data'],
		];
		$response = $fb->post('/'.$postID.'/comments', $data, $_SESSION['facebook_access_token']);
		$comments_request = $fb->get('/'.$postID.'/comments?limit=100000&order=reverse_chronological');
		$comments_response = $comments_request->getGraphEdge()->asArray();
		echo $commentsCount = count($comments_response);
		?>
++++<div class="mycommnt" id="commentContainer_<?php echo $comments_response[0]['id']; ?>">
			<em><?php echo $comments_response[0]['from']['name'];?></em>&nbsp;&nbsp;<?php echo $comments_response[0]['message'];?> 
			<span class="customsection">
				<a href="javascript:void(0);" onclick="deleteComment('<?php echo $postID;?>','<?php echo $comments_response[0]['id'];?>');" title="Delete Comment">
					<img src="images/delmycomment.png" alt="" />
				</a>
			</span>
		</div>
<?php
	}
	elseif($_POST['todo'] == 'deletecomment')
	{
		$commentID = $_POST['commentid'];
		$response = $fb->delete('/'.$commentID);
		$comments_request = $fb->get('/'.$postID.'/comments?limit=100000&order=reverse_chronological');
		$comments_response = $comments_request->getGraphEdge()->asArray();
		echo $commentsCount = count($comments_response);
		exit;
	}

}
elseif($_POST['action'] == 'InstaComment')
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
	if($_POST['todo'] == 'postcomment')
	{
		$data = $_POST['data'];
		$instagram->addMediaComment($postID, $data);
		$comments_response = $instagram->getMediaComments($postID);
		//echo "<pre>"; print_r($comments_response); exit;
		echo $commentsCount = count($comments_response);
		?>
++++<div class="mycommnt" id="commentContainer_<?php echo $comments_response[0]['id']; ?>">
			<em><?php echo $comments_response[0]['from']['name'];?></em>&nbsp;&nbsp;<?php echo $comments_response[0]['message'];?> 
			<span class="customsection">
				<a href="javascript:void(0);" onclick="deleteComment('<?php echo $postID;?>','<?php echo $comments_response[0]['id'];?>');" title="Delete Comment">
					<img src="images/delmycomment.png" alt="" />
				</a>
			</span>
		</div>
<?php
	}
	elseif($_POST['todo'] == 'deletecomment')
	{
		
		//echo $commentsCount = count($comments_response);
		exit;
	}

}