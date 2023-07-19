<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
error_reporting(0);

$userID=$_SESSION['user_id'];

$contest_id = $_GET['contid'];
$sql="SELECT * FROM `contest` WHERE `status`='1' AND contest_id = '$contest_id' ";	
$contest_list = $Obj->select($sql) ;
$contestVideo = $contest_list[0]['help_video'];
?>
<meta name="viewport" content="width=device-width, initial-scale=1">


<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/v2style.css" />

<script src="js-webshim/minified/polyfiller.js"></script>
<script  type="text/javascript">	
	webshim.polyfill('es5 mediaelement forms');
</script>


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
</style>
  <script type="text/javascript" src="js/jquery.leanModal.min.js"></script>

<link type="text/css" rel="stylesheet" href="css/style_popup.css" />




 <div id="modal">
		<!--<header class="popupHeader">-->
		<!--	<span class="header_title">Video Clip : <?php echo $clip_data['company_name']; ?></span>-->
		<!--</header>-->
		<section class="popupBody">

			<div class="user_register">
				<video style="width: 97%;" id="tv_main_channel" controls  loop autoplay onmouseout="this.pause()" onmouseover="this.play()" >
					<?php if(isset($_GET['video'])){ ?>
					
						<source id="mp4Source" src="<?php echo $_GET['video']; ?>" type="video/mp4" />	
					
					<?php 	}
						elseif(isset($_GET['contid']))
						{
							if(!empty($contestVideo))
							{
								?>
								<source id="mp4Source" src="<?php echo str_replace("../", "", $contestVideo);?>" type="video/mp4" />
					<?php		}
							else
							{					
								if($_GET['contid'] == '128'){ ?><source id="mp4Source" src="video/StreamWithMicrophone.mp4" type="video/mp4" /><?php }
								if($_GET['contid'] == '112'){ ?><source id="mp4Source" src="video/MySItti-DJ-setup-using-GoLive.mp4" type="video/mp4" /><?php }
							}
						}
						else
						{ 
					?>
					
							<source id="mp4Source" src="video/mysittidev.com FMLE Connectivity DJ Battlev2.mp4" type="video/mp4" />
					
					<?php 	} ?>
					
				</video>
			</div>

		</section>
	</div>
               
