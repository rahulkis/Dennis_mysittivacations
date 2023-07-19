<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
error_reporting(0);
$userID=$_SESSION['user_id'];
$videoURL = $_GET['file'];

?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" type="text/css" href="css/v2style.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1027910397223837";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<style>

#mask {

	position:absolute;

	left:0;

	top:0;

	z-index:500;

	background-color:#000;

	display:none;

}

	

 .window {

	position:fixed;

	left:0;

	top:0;

	display:none;

		z-index:9000;

	height: 400px;

	width: 600px;

}  



form#photos table

{

	background: none repeat scroll 0 0 transparent;

}



#lean_overlay{

	opacity: 0.60 !important;

}

.addorremove{

	float: left;

		height: auto;

	 

		min-height: 138px;

		min-width: 169px;

		width: auto;

}

.addorremovebutton{

	 float: left;

		height: 100%;

		margin-right: 8px;

		width: 24%

}

.uploadbuttons {

float: right;

width: 40%;

margin: 10px 0;

}

.jwplayer.playlist-none

{

	float: left;

	height: 350px !important;

}

.popupContainer {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
	border: 0 none;
	bottom: 0;
	left: 0;
	margin: auto;
	max-width: 570px;
	padding: 15px;
	position: absolute;
	right: 0;
	top: 0;
	width: 100%;
}

.button {

	display: table;

	float: right;

	margin: 20px 0;

}

.user_register {

background: #555 none repeat scroll 0 0;
	border: 4px solid #ccc;
	border-radius: 20px;
	box-sizing: border-box;
	float: left;
	padding: 29px 35px;
	width: 100%; 
	position:relative;

}

.user_register:before {
	width: 20px;
	height: 20px;
	background: #ccc;
	border-radius: 50%;
	content: "";
	position: absolute;
	left: 0;
	right: 0;
	margin: auto;
	bottom: 5px;
	z-index: 999;
}
.user_register a > div {width: 100% !important;}
 .user_register > a {

	text-decoration: none;

}
.topclose .button {
	background: #111 none repeat scroll 0 0;
	border: 2px solid #fff;
	border-radius: 4px;
	color: #fff !important;
	float: none;
	font-size: 14px;
	font-weight: bold;
	margin: 20px auto;
	text-transform: uppercase;
}
.topclose .button:hover {background:#fecd07; color:#000 !important}
.topclose {
	border-radius: 6px;
	box-sizing: border-box;
	float: left;
	margin-bottom: 15px;
	padding: 0 10px;
	width: 100%;
}
body {
	background: rgba(0, 0, 0, 0) url("../live2/stream.jpg") repeat scroll left top / cover ;
}
@media only screen and (max-width:479px) {
 .popupContainer {max-width:300px;}
}
</style>
<div id="modal" class="popupContainer">
	<section class="popupBody">
		<div class="user_register">
			<div class="fb-video" data-href="<?php echo $videoURL; ?>" data-width="500" data-show-text="false">
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="<?php echo $videoURL; ?>">
						<a href="<?php echo $videoURL; ?>">How to Share With Just Friends</a>
						Posted by <a href="https://www.facebook.com/facebook/">Facebook</a> on Friday, December 5, 2014
					</blockquote>
				</div>
			</div>
		</div>
		<br />
		<br />
		<div class="topclose">
			<a href="javascript:void(0);" onclick="window.close();" class="button">Close</a>
		</div>
	</section>
</div>
</body>
</html>