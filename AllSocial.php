<?php
error_reporting(0);
include("Query.Inc.php");

$Obj = new Query($DBName);

$hostID=$_GET['host_id'];

$userType= $_SESSION['user_type'];

if( !isset($_SESSION['user_id']) )
{

	$Obj->Redirect("login.php");

}


// ini_set("display_errors", "1");
// error_reporting(E_ALL);

$titleofpage="Social Page";

include('HeaderHost.php');


?>
<style type="text/css" title="currentStyle">
@import "css/demo_page.css";
@import "css/demo_table.css";

h2.noresult {
  display: initial;
  float: left;
  font-size: 22px;
  padding: 100px 0;
  text-align: center;
  width: 100%;
}
</style>
<script type="text/javascript">

function deletecon(id)

{

	if(confirm('Are you sure you want delete this contests'))

	{

		$.get( "deletecontests.php?id="+id, function( data )

		{

			window.location='contests_list.php?id='+id;

			});

	}

}



$(document).ready(function(){

	$('input[type="radio"]').click(function(){

		if($(this).val() == "Disable with message")

		{

			$('#disablemessage').css('display','block');

		}

		else

		{

			$('#disablemessage').css('display','none');

		}

	});

});

function openVideo(url)
{
	window.open('playSocialVideo.php?file='+url,'_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=400, width=800, height=600');
}


</script>
<?php 
error_reporting(0);
$twitterArray = array();
$FacebookArray = array();
$instagramArray = array();


$st = 0;


if (isset($_SESSION['facebook_access_token'])) {
	require_once 'FacebookV5/autoload.php';

	$fb = new Facebook\Facebook([
		'app_id' => '1027910397223837',
		'app_secret' => '00175be1ff4053b4cb22bca7b51b947a',
		'default_graph_version' => 'v2.6',
	]);

	$helper = $fb->getCanvasHelper();
	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	try {
		$posts_request = $fb->get('/me/posts?limit=20');
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$total_posts = array();
	$posts_response = $posts_request->getGraphEdge()->asArray();

	$response = $fb->get('/me', $accessToken);
	$user = $response->getGraphUser();
	$fbID = $user->getId();



	$wholikesArray = array();
	$whoCommentsArray = array();

	foreach($posts_response as $post)
	{
		$postID = $post['id'];
		$postTitle = $post['story'];

		$attachments_request = $fb->get('/'.$postID.'/attachments');
		$attachments_response = $attachments_request->getGraphEdge()->asArray();

		// COUNT FB POST LIKES
		$likes_request = $fb->get('/'.$postID.'/likes?limit=100000');
		$likes_response = $likes_request->getGraphEdge()->asArray();
		$likesCount = count($likes_response);

		if($likesCount > 0)
		{
			foreach($likes_response as $likes)
			{
				$wholikesArray[] = $likes['id'];
			}
		}



		// COUNT FB POST COMMENTS
		$comments_request = $fb->get('/'.$postID.'/comments?limit=100000');
		$comments_response = $comments_request->getGraphEdge()->asArray();
		$commentsCount = count($comments_response);

		if($commentsCount > 0)
		{
			foreach($comments_response as $comments)
			{
				$whoCommentsArray[] = $comments;
			}
		}


		foreach($attachments_response as $attachments)
		{

			if($attachments['type'] == 'video_inline')
			{
				$FacebookArray[$st]['posttype'] = 'video';
				$FacebookArray[$st]['postimage'] = $attachments['media']['image']['src'];
				$FacebookArray[$st]['postVideo'] = $attachments['url'];
			}
			else
			{
				$FacebookArray[$st]['postimage'] = $attachments['media']['image']['src'];
			}

			if(isset($attachments['description']))
			{
				$FacebookArray[$st]['caption'] = $attachments['description'];
			}
			else
			{
				$FacebookArray[$st]['caption'] = $postTitle;
			}

		}

		$FacebookArray[$st]['userimage'] = 'https://graph.facebook.com/'.$fbID.'/picture?type=large';
		
		$FacebookArray[$st]['type'] = 'facebook';
		$FacebookArray[$st]['icon'] = 'facebook.png';
		$FacebookArray[$st]['mediaID'] = $postID;
		$FacebookArray[$st]['mediaLikes'] = $likesCount;
		$FacebookArray[$st]['MediaComments'] = $commentsCount;
		$FacebookArray[$st]['wholikes'] = $wholikesArray;
		$FacebookArray[$st]['whoComments'] = $whoCommentsArray;
		$st++;
		unset($wholikesArray);
		unset($whoCommentsArray);
	}
}



//     echo "<pre>"; print_r($FacebookArray);

// exit;



// require 'instagram/instagram.class.php';
// $instagram = new Instagram(array(
// 	'apiKey'      => '92f139720df84559ab02e9a5b3ddad94',
// 	'apiSecret'   => '20a722870a9d4a0cabe4c85345d21a23',
// 	'apiCallback' => 'https://mysittidev.com/AllSocial.php' // must point to success.php
// ));


require_once 'InstagramSDK/src/Instagram.php';
	$instagram = new Instagram(array(
		'apiKey'      => '92f139720df84559ab02e9a5b3ddad94',
		'apiSecret'   => '20a722870a9d4a0cabe4c85345d21a23',
		'apiCallback' => 'https://mysittidev.com/AllSocial.php'
	));



/* PINTERST FEEDS */


function fetchData($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$result = curl_exec($ch);
	curl_close($ch); 
	return $result;
}




/*INSTAGRAM FEEDS*/

$code = $_GET['code'];

// Check whether the user has granted access
if (true === isset($code))
{

// Receive OAuth token object
	$data = $instagram->getOAuthToken($code);
	if(empty($data->user->username) && !isset($_SESSION['instadetails']))
	{
		//die('IF');
		$url = 'user_social.php';
		$Obj->Redirect($url);
	}
	else
	{
		// session_start();
		// Storing instagram user data into session

		$_SESSION['instadetails']=$data;
		$url = 'AllSocial.php';
		$Obj->Redirect($url);
	}
}


if(isset($_SESSION['instadetails']))
{
	$wholikesArrayInsta = array();
	$whoCommentsArrayInsta = array();
	$data = $_SESSION['instadetails'];
	$user=$data->user->username;
	$fullname=$data->user->full_name;
	$bio=$data->user->bio;
	$website=$data->user->website;
	$id=$data->user->id;
	$instaUserId = $data->user->id;
	$token=$data->access_token;
	$instagram->setAccessToken($token);


	$result = fetchData("https://api.instagram.com/v1/users/".$id."/media/recent/?access_token=".$token);
	$result = json_decode($result);

 
	$i=0;
	foreach ($result->data as $post) 
	{
		// Do something with this data.
		$instagramArray[$i]['mediaID'] = $post->id;
		$instagramArray[$i]['postimage'] = $post->images->standard_resolution->url;
		$instagramArray[$i]['userimage'] = $post->user->profile_picture;
		$instagramArray[$i]['caption'] = $post->caption->text;
		$instagramArray[$i]['type'] = 'instagram';
		$instagramArray[$i]['icon'] = 'instagram.png';
		$instagramArray[$i]['mediaLikes'] = $post->likes->count;
		$instagramArray[$i]['MediaComments'] = $post->comments->count;

		// INSTA LIKES 
		if($post->likes->count > 0)
		{
			$postLikes = fetchData("https://api.instagram.com/v1/media/".$post->id."/likes?access_token=".$token);
			$likes_response = json_decode($postLikes);
			// 
			foreach($likes_response->data as $likes)
			{
				$wholikesArrayInsta[] = $likes->id;
			}
		}

		// INSTA COMMENTS 

		if($post->comments->count > 0)
		{
			$postComments = fetchData("https://api.instagram.com/v1/media/".$post->id."/comments?access_token=".$token);
			$Comments_response = json_decode($postComments);
			//  
			foreach($Comments_response->data as $likes)
			{
				$whoCommentsArrayInsta[] = $likes;
			}
		}

		$instagramArray[$i]['wholikes'] = $wholikesArrayInsta;
		$instagramArray[$i]['whoComments'] = $whoCommentsArrayInsta;
		unset($wholikesArrayInsta);
		unset($whoCommentsArrayInsta);
		
		$i++;
	}

}

if(isset($_SESSION['request_vars']['screen_name']))
{
/* TWITTER FEEDS */
$twitter_handle = $_SESSION['request_vars']['screen_name'];
 
function buildBaseString($baseURI, $method, $params) {
	$r = array();
	ksort($params);
	foreach($params as $key=>$value){
		$r[] = "$key=" . rawurlencode($value);
	}
	return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}
 
function buildAuthorizationHeader($oauth) {
	$r = 'Authorization: OAuth ';
	$values = array();
	foreach($oauth as $key=>$value)
		$values[] = "$key=\"" . rawurlencode($value) . "\"";
	$r .= implode(', ', $values);
	return $r;
}
 
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
 
$oauth_access_token = $_SESSION['token'] ;
$oauth_access_token_secret = $_SESSION['token_secret'];
$consumer_key = "CmrIqSha5jRZ99rsFSA";
$consumer_secret = "P4Qj8tjJ4kKv36K9LtRybrPM0I2BZjt8OoBQA2MsHo";
 
$oauth = array( 'oauth_consumer_key' => $consumer_key,
				'oauth_nonce' => time(),
				'oauth_signature_method' => 'HMAC-SHA1',
				'oauth_token' => $oauth_access_token,
				'oauth_timestamp' => time(),
				'oauth_version' => '1.0',
				'screen_name' => $twitter_handle);
 
$base_info = buildBaseString($url, 'GET', $oauth);
$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;
 
// Make Requests
$header = array(buildAuthorizationHeader($oauth), 'Content-Type: application/json', 'Expect:');
$options = array( CURLOPT_HTTPHEADER => $header,
				  //CURLOPT_POSTFIELDS => $postfields,
				  CURLOPT_HEADER => false,
				  CURLOPT_URL => $url . '?screen_name=' . $twitter_handle,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_SSL_VERIFYPEER => false);
$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);
$decode = json_decode($json, true); //getting the file content as array
 
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
$reg_exHash = "/#([a-z_0-9]+)/i";
$reg_exUser = "/@([a-z_0-9]+)/i";
 
$y = 0;
foreach($decode as $tweet)
{
		$tweet_text = $tweet["text"]; //get the tweet

	// make links link to URL
	// http://css-tricks.com/snippets/php/find-urls-in-text-make-links/
	if(preg_match($reg_exUrl, $tweet_text, $url)) {

	// make the urls hyper links
		$tweet_text = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a> ", $tweet_text);

	}

	if(preg_match($reg_exHash, $tweet_text, $hash)) {

	// make the hash tags hyper links    https://twitter.com/search?q=%23truth
		$tweet_text = preg_replace($reg_exHash, "<a href='https://twitter.com/search?q={$hash[0]}'>{$hash[0]}</a> ", $tweet_text);

	// swap out the # in the URL to make %23
		$tweet_text = str_replace("/search?q=#", "/search?q=%23", $tweet_text );

	}

	if(preg_match($reg_exUser, $tweet_text, $user)) {

		$tweet_text = preg_replace("/@([a-z_0-9]+)/i", "<a href='http://twitter.com/$1'>$0</a>", $tweet_text);

	}

	$profileImage = str_replace("_normal.", "_400x400.", $tweet['user']['profile_image_url']);

	$countMedia = $tweet['entities']['media'];

	$MediaUrl = $tweet['entities']['media'][0]['media_url']; 


	// Do something with this data.
	$twitterArray[$y]['postimage'] = $MediaUrl;
	$twitterArray[$y]['userimage'] = $profileImage;
	$twitterArray[$y]['caption'] = $tweet_text;
	$twitterArray[$y]['type'] = 'twitter';
	$twitterArray[$y]['icon'] = 'twt.png';
	$y++;




}


}

 // echo "<pre>"; print_r($instagramArray); print_r($twitterArray); print_r($FacebookArray); exit;

$mergedArray = array_merge($instagramArray,$twitterArray);
$finalmergedArray = array_merge($mergedArray,$FacebookArray);
shuffle($finalmergedArray);

   //echo "<pre>"; print_r($finalmergedArray); exit;

?>
<div class="clear"></div>
<div class="v2_container">
  <div class="v2_inner_main" style="background:#000; min-height: 365px;">
	<h3 id="socialsall">All Socials</h3>
	<div id="list" class="socialContainer grid">
	<?php 
	  	if(count($finalmergedArray) < 1)
	  	{
	  			echo "<h2 class='noresult'>Please Log in to atleast one of your Social Account.</h2>";
	  	}
	  	?>
   <div class="masonry">
	  <?php 
	  	if(count($finalmergedArray) > 0)
	  	{
			foreach($finalmergedArray as $result)
			{
		?>
   
	  <div class="item">
		<div class="SinglePostBox">
		  <div class="postLeftThumbnail">
			<?php
							if(isset($result['posttype']))
							{
						?>
			<div class="playoverlay">
			  <div class="iconplay"> <img onclick="openVideo('<?php echo $result['postVideo'];?>');" src="<?php echo $SiteURL; ?>images/play2.png" alt="" /> </div>
			</div>
			<?php 
							}

							if( !empty($result['postimage']) )
							{
								
								echo '<img src="'.$result['postimage'].'" alt="" />';
							}

						?>
			<div class="userShare"> <img src="<?php echo $result['userimage']; ?>" alt="" /> </div>
		  </div>
		  <div class="postRightContent">
			<p> <?php echo $result['caption']; ?> </p>
			<div class="actionbox">
			  <?php 
								if($result['type'] == 'twitter')
								{
							?>
			  <span class="likepost"> <a href="javascript:void(0);" title="Like"> <img src="<?php echo $SiteURL; ?>images/likethispost.png" alt="" /> </a> </span> <span class="likecounter" id=""><?php echo $result['mediaLikes'];?></span> <span class="sep">|</span> <span class="Commentsection"> <a href="javascript:void(0);"> <img src="<?php echo $SiteURL; ?>images/likethispost.png" alt="" /> </a> </span> <span class="commentscounter"> <?php echo $result['MediaComments'];?> </span>
			  <?php 
								}
								elseif($result['type'] == 'instagram')
								{
							?>
									<span class="likepost" id="instapost_<?php echo $result['mediaID'];?>">
			  <?php 
									if(in_array($instaUserId, $result['wholikes']))
									{
							?>
										<a href="javascript:void(0);" onclick="javascript:alert('We cannot post to Instagram due to security reasons.');" title="Like"> <img src="<?php echo $SiteURL; ?>images/insta_liked.png" alt="" /> </a>
			  <?php
									}
									else
									{
							?>
									  <a href="javascript:void(0);" onclick="javascript:alert('We cannot post to Instagram due to security reasons.');" title="Like"> <img src="<?php echo $SiteURL; ?>images/insta_ulliked.png" alt="" /> </a>
									  <?php	
									}
							?>
									</span> 
									<span class="likecounter" id="insta_<?php echo $result['mediaID'];?>"><?php echo $result['mediaLikes'];?></span> 
									<span class="sep">|</span> 
									<span class="Commentsection"> 
										<a href="javascript:void(0);" onclick="showcommentboxinsta('<?php echo $result['mediaID'];?>','post');"> 
											<img src="<?php echo $SiteURL; ?>images/social_comment.png" alt="" /> 
										</a> 
									</span> 
									<span class="commentscounter" id="insta_comments-<?php echo $result['mediaID'];?>">
										<?php echo $result['MediaComments'];?> 
									</span>
									<div class="clear"></div>
		
									<div class="allcomments" id="instacomment-<?php echo $result['mediaID'];?>">
										<div class="prevcomments"> 
											<div class="loadcomments" style="display:block">
												<div class="instaComments" id="appendCommentinsta-<?php echo $result['mediaID'];?>">
											<?php
												foreach ($result['whoComments'] as $getcomments) 
												{
											?>		<div class="mycommnt" id="commentContainerinsta_<?php echo $getcomments->id; ?>">
														<em><?php echo $getcomments->from->username;?></em>&nbsp;&nbsp;<?php echo $getcomments->text;?> 
														<?/*<span class="customsection">
															<a href="javascript:void(0);" onclick="deleteCommentinsta('<?php echo $result['mediaID'];?>','<?php echo $getcomments->id;?>');" title="Delete Comment">
																<img src="<?php echo $SiteURL; ?>images/delmycomment.png" alt="" />
															</a>
														</span> */?>
													</div>
											<?php 	
												}
											?>
												</div>
												<div class="clear"></div>
												<?/*<form>
													<input type="text" id="commentinsta-<?php echo $result['mediaID'];?>" value="" placeholder="Write your comment" />
													<input type="button" value="Post" onclick="postCommentinsta('<?php echo $result['mediaID'];?>','postcomment');" />
												</form>*/?>
											</div>
										</div>
									</div>
			  <?php
								} 
								elseif($result['type'] == 'facebook')
								{
							?>
									<span class="likepost" id="fbpost_<?php echo $result['mediaID'];?>">
			  <?php 
									if(in_array($fbID, $result['wholikes']))
									{
							?>
										<a href="javascript:void(0);" onclick="likeFBPost('<?php echo $result['mediaID'];?>','unlike');" title="Like"> <img src="<?php echo $SiteURL; ?>images/insta_liked.png" alt="" /> </a>
			  <?php
									}
									else
									{
							?>
									  <a href="javascript:void(0);" onclick="likeFBPost('<?php echo $result['mediaID'];?>','like');" title="Like"> <img src="<?php echo $SiteURL; ?>images/insta_ulliked.png" alt="" /> </a>
									  <?php	
									}
							?>
									</span> 
									<span class="likecounter" id="fb_<?php echo $result['mediaID'];?>"><?php echo $result['mediaLikes'];?></span> 
									<span class="sep">|</span> 
									<span class="Commentsection"> 
										<a href="javascript:void(0);" onclick="showcommentbox('<?php echo $result['mediaID'];?>','post');"> 
											<img src="<?php echo $SiteURL; ?>images/social_comment.png" alt="" /> 
										</a> 
									</span> 
									<span class="commentscounter" id="fb_comments-<?php echo $result['mediaID'];?>">
										<?php echo $result['MediaComments'];?> 
									</span>
									<div class="clear"></div>
		
									<div class="allcomments" id="fbcomment-<?php echo $result['mediaID'];?>">
										<div class="prevcomments"> 
											<div class="loadcomments" style="display:block">
												<div class="fbComments" id="appendComment-<?php echo $result['mediaID'];?>">
											<?php
												foreach ($result['whoComments'] as $getcomments) 
												{
											?>		<div class="mycommnt" id="commentContainer_<?php echo $getcomments['id']; ?>">
														<em><?php echo $getcomments['from']['name'];?></em>&nbsp;&nbsp;<?php echo $getcomments['message'];?> 
														<span class="customsection">
															<a href="javascript:void(0);" onclick="deleteComment('<?php echo $result['mediaID'];?>','<?php echo $getcomments['id'];?>');" title="Delete Comment">
																<img src="<?php echo $SiteURL; ?>images/delmycomment.png" alt="" />
															</a>
														</span> 
													</div>
											<?php 	
												}
											?>
												</div>
												<div class="clear"></div>
												<div id="commentSubmit" style="position: relative;">
													<input type="text" id="comment-<?php echo $result['mediaID'];?>" value="" placeholder="Write your comment" />
													<input type="button" value="Post" onclick="postComment('<?php echo $result['mediaID'];?>','postcomment');" />
												</div>
											</div>
										</div>
									</div>
		 
			  <?php				}				?>
					<div class="shared"> 
						<img src="<?php echo $SiteURL;?>images/<?php echo $result['icon'];?>" alt="" /> 
					</div>
				</div>
			</div>
		</div>
	  </div>
	
	  <?php 	}
	  		}	  	?>
	</div>
	  <div class="clear"></div>
	</div>
  </div>
  <div class="clear"></div>
</div>
<script type="text/javascript">
	function likeFBPost(id,action)
	{
		$.ajax({
			type: "POST",
			url: "SocialPostLike.php",
			data: {
			'action' : 'FBlike',
			'postID' : id,
			'todo' : action
			},
			success: function(data){
				var res = data.split('++++');
				$('#fb_'+id).text(res[0]);
				$('#fbpost_'+id).html(res[1]);
			}

	   });
	}
	
	function postComment(id,action)
	{
		var d = $('#comment-'+id).val();
		$.ajax({
			type: "POST",
			url: "SocialPostComment.php",
			data: {
			'action' : 'FBComment',
			'postID' : id,
			'todo' : action,
			'data' : d
			},
			success: function(data){
				var res = data.split('++++');
				$('#fb_comments-'+id).text(res[0]);
				$('#appendComment-'+id).append(res[1]);
				$('#comment-'+id).val('');
			}

	   });
	}

	function deleteComment(id,commentid)
	{
		var d = $('#comment-'+id).val();
		$.ajax({
			type: "POST",
			url: "SocialPostComment.php",
			data: {
			'action' : 'FBComment',
			'postID' : id,
			'todo' : 'deletecomment',
			'commentid' : commentid
			},
			success: function(data){
				var res = data.split('++++');
				$('#fb_comments-'+id).text(res[0]);
				$('#commentContainer_'+commentid).remove();
			}

	   });
	}

// 	INSTAGRAM FUNCTIONS

	function likeInstaPost(id,action)
	{
		$.ajax({
			type: "POST",
			url: "SocialPostLikeinsta.php",
			data: {
			'action' : 'Instalike',
			'postID' : id,
			'todo' : action
			},
			success: function(data){
				var res = data.split('++++');
				$('#insta_'+id).text(res[0]);
				$('#instapost_'+id).html(res[1]);
			}

	   });
	}
	
	function postCommentinsta(id,action)
	{
		var d = $('#comment-'+id).val();
		$.ajax({
			type: "POST",
			url: "SocialPostComment.php",
			data: {
			'action' : 'InstaComment',
			'postID' : id,
			'todo' : action,
			'data' : d
			},
			success: function(data){
				var res = data.split('++++');
				$('#insta_comments-'+id).text(res[0]);
				$('#appendCommentinsta-'+id).append(res[1]);
				$('#commentinsta-'+id).val('');
			}

	   });
	}

	function deleteCommentinsta(id,commentid)
	{
		var d = $('#commentinsta-'+id).val();
		$.ajax({
			type: "POST",
			url: "SocialPostComment.php",
			data: {
			'action' : 'InstaComment',
			'postID' : id,
			'todo' : 'deletecomment',
			'commentid' : commentid
			},
			success: function(data){
				var res = data.split('++++');
				$('#fb_commentsinsta-'+id).text(res[0]);
				$('#commentContainerinsta_'+commentid).remove();
			}

	   });
	}



</script> 
<script>
$(document).ready(function(){
	
	
$('.tips').hover(
function(){
	$('.hoverme').css('display', 'block');
	},
	function(){
	$('.hoverme').css('display', 'none');
	}
	);
	 
});

function showcommentbox(postid,action)
{
	$('.allcomments').each(function(){
		var id = $(this).attr('id');
		id = id.split('-');
		if(postid == id[1])
		{
			$('#fbcomment-'+postid).slideToggle();
		}
		// else
		// {
		// 	$(this).hide();
		// }

	});

}


function showcommentboxinsta(postid,action)
{
	$('.allcomments').each(function(){
		var id = $(this).attr('id');
		id = id.split('-');
		if(postid == id[1])
		{
			$('#instacomment-'+postid).slideToggle();
		}
		// else
		// {
		// 	$(this).hide();
		// }

	});

}

</script>
<?php include('Footer.php');?>
