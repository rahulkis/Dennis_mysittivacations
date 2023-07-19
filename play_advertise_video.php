<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
error_reporting(0);
$userID=$_SESSION['user_id'];
if($_GET['type']=='private')
{
	$type=$_GET['type'];
}
else
{
	$type='public';
}

if(isset($_GET['type']))
{

	$get_video_details = @mysql_query("select * from `contest` where `contest_id` = '".$_REQUEST['id']."'");

	$clip_data = mysql_fetch_assoc($get_video_details);

	$videoSrc = $clip_data['contest_video'];



}
elseif(isset($_GET['action']) && $_GET['action'] == "contestent")
{

	$get_video_details = @mysql_query("select * from `contestent` where `c_video_id` = '$_REQUEST[id]' ");

	$clip_data = mysql_fetch_assoc($get_video_details);

	$videoSrc = $clip_data['video_name'];
}
else

{

	$get_video_details = @mysql_query("select * from `advertise` where `id` = '".$_REQUEST['adv_id']."'");

	$clip_data = mysql_fetch_assoc($get_video_details);

	$videoSrc = $clip_data['adv_video'];

}

?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>

<link rel="stylesheet" type="text/css" href="css/v2style.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />

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

		<!--<header class="popupHeader">-->

		<!--	<span class="header_title">Video Clip : <?php echo $clip_data['company_name']; ?></span>-->

		<!--</header>-->

		<section class="popupBody">

	

			<div class="user_register">

					<?php 

						if($_REQUEST['adv_id'] == '46')

						{

							?>

							<iframe width="400" height="330" src="https://www.youtube.com/embed/XluEaJZvST4" frameborder="0" allowfullscreen></iframe>

							<?php 

						}

						else

						{

							$url = "https://".$_SERVER['SERVER_NAME']."/".$videoSrc; ?>

				

				                      	<a href="#dialogx1" name="modal" style="">

				                        		<div id="a1" onmouseover="jwplayer().play();" onmouseout="jwplayer().pause();"></div>

					                        	<script type="text/javascript">

					                         		jwplayer("a1").setup({

							                            	file: "<?php echo $url;?>",

							                            	//file: "user-video/14170027491416985200Internet Download.flv",

							                    	 	height : 284 ,

							                         //   	width: 400,

										autostart: true,

					                            		});

					                            	</script>

						 	</a>	

				<?php 		}	?>			

			</div><br /><br />

		
<div class="topclose"><a href="javascript:void(0);" onclick="window.close();" class="button">Close</a></div>
		</section>

	</div>