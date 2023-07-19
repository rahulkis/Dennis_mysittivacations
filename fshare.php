<?php 
include 'login/facebook.php';
	$appid 		= "688073574590787";
	$appsecret  = "acdbc4b9054bbc4c7e318b42a05d92fd";
	$facebook   = new Facebook(array(
  		'appId' => $appid,
  		'secret' => $appsecret,
  		'cookie' => TRUE,
	));
	$facebook->setFileUploadSupport(true);  
$fbuser = $facebook->getUser();
$video_details = array(   
            'access_token'=> $access_token,
            'message'=> 'Test video!',
            'source'=> 'Video.MOV'   

    );	
$post_video = $facebook->api('/'.$fbuser.'/videos', 'post', $video_details);

	?>

<html>
<head>
	<meta property="og:video" content="http://ahrengot.com/playground/circular-scrubbing/video-player.swf?url=http://ahrengot.com/playground/circular-scrubbing/assets/video/example.mp4" />
	<!-- <meta property="og:video:secure_url" content="https://secure.example.com/movie.swf" /> -->
	<meta property="og:video:type" content="application/x-shockwave-flash" />
	<meta property="og:video:width" content="400" />
	<meta property="og:video:height" content="300" />
	<script type="text/javascript">
window.fbAsyncInit = function() {
	FB.init({
	appId      : '688073574590787', // replace your app id here
	channelUrl : 'https://mysittidev.com/user_social.php', 
	status     : true, 
	cookie     : true, 
	xfbml      : true  
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function FBLogin(){
	FB.login(function(response){
		if(response.authResponse){
			window.location.href = "fshare.php?action=fblogin";
		}
	}, {scope: 'email,user_likes,publish_stream'});
}

function FBLogout(){
	FB.logout(function(response) {
		window.location.href = "index.php";
	});
}
</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "149feadf-b97c-4052-a20e-b78764f1429e", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</head>
<body>
	<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
</body>
</html>