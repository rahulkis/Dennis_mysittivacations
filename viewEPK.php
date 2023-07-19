<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

$EPKID = $_GET['Uid'];


$HOSTID  = $_GET['host_id'];


$getUserDetails = mysql_query("SELECT * FROM `epk_host_info` WHERE `epkId` = '$EPKID' AND `host_id` = '$HOSTID' ");
$fetchUserDetails = mysql_fetch_assoc($getUserDetails);



$getEPKphotos = mysql_query("SELECT * FROM `epk_host_photos` WHERE `epkID` = '$EPKID' ");
$ShareFacebookURl = urlencode($SiteURL.$fetchUserDetails['host_name'].'&amp;page=EPK');
$ShareTitle = urlencode($fetchUserDetails['host_name'].' Electronic Press Kit Page');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysittidev.com ||<?php echo $fetchUserDetails['host_name'];?>EPK Page</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta property="og:title" content="<?php echo $fetchUserDetails['host_name'];?> Electronic Press Kit Page">
<meta property="og:image" content="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>">
<meta property="og:url" content="<?php echo $SiteURL.$fetchUserDetails['host_name'];?>&page=EPK" />

<!-- ======== Include Main Stylesheet ===============  -->
<link href="<?php echo $SiteURL;?>css/EPKstyle.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL;?>css/responsive.css" rel="stylesheet" type="text/css">

<!-- ======== Include Main Javascript Library ===============  -->
<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<!-- ======== Include Main Other Javascripts ===============  -->

<style>
.body {
 padding-top:0 !important;
}
@media only screen and (max-width: 767px) {
body {
 padding-top: 0px !important;
}
}
</style>
<style>
.epkAdmin a {
 float: left;
 padding: 0px 10px 5px;
}
.epkAdmin li {
 float: left;
 position: relative;
}
.epkAdmin li {
 position:relative;
}
.epkAdmin li ul {
 background: #fff none repeat scroll 0 0;
 border-radius: 4px;
 box-sizing: border-box;
 display:none;
 left: -100%;
 padding: 10px !important;
 position: absolute;
 top: 32px;
 width: 140px;
}
.epkAdmin li ul::before {
 border-bottom: 8px solid #fff;
 border-left: 6px solid transparent;
 border-right: 6px solid transparent;
 content: "";
 height: 0;
 left: 0;
 margin: auto;
 position: absolute;
 right: 0;
 top: -6px;
 width: 0;
}
.epkAdmin li:hover ul {
 display:block;
}
table p, table span, table i, table strong, table ul li {color:#fff !important;}
</style>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d1a0b5b3-5460-45ac-9d43-802d8c763b24", doNotHash: false, doNotCopy: false, hashAddressBar: false,shorten: false});</script>

</head>
<body>
<div id="Epk_wrapper" class="Epk2">
	<h1 style="color: #000;text-align:center;font-size: 30px;padding-bottom:10px; padding-top:5px;font-weight: bold;float:left; width:100%; background:#fff;">Electronic Press Kit</h1>
	<div id="EpkHeader">
	 
		<div class="Epk_container">
		 
			<div class="left">
				<div id="EpkProfile"><img src="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>" align=""></div>
			</div>
			
			<div class="right">
				<ul style="float:right;" class="epkAdmin">
					<?php 
					if($_SESSION['user_type'] == 'club' && $_SESSION['user_id'] == $_GET['host_id'])
					{
				?>
					<li style="display:inline; margin-right:10px;"> <a href="<?php echo $SiteURL;?>epk.php?epkID=<?php echo $_GET['Uid']; ?>&host_id=<?php echo $_GET['host_id'];?>"> <img src="<?php echo $SiteURL;?>images/editEPK_b.png"> </a> </li>
					<?php	} ?>
					<li style="display:inline; margin-right:10px; position:relative;"> <a href="javascript:void(0);"> <img src="<?php echo $SiteURL;?>images/shareEPK_b.png"> </a>
						<ul>
							<li> <!-- <span class='st_facebook_large' displayText='Facebook'></span> -->
									<a style="padding:0 5px 0 0;" href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $ShareFacebookURl;?>&pubid=ra-5208c23564631929&ct=1&title=EPK%20page&pco=tbxnj-1.0" target="_blank">
										<img style="border-radius: 5px;" src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/>
									</a>

							</li>
							<li> 
									<a style="padding:0 5px 0 0;" href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo $ShareFacebookURl;?>&pubid=ra-5208c23564631929&ct=1&title=<?php echo $ShareTitle;?>&pco=tbxnj-1.0" target="_blank">
									<img style="border-radius: 5px;"src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/>
								</a>
							</li>
							<li> <span class='st_email_large' displayText='Email'></span> </li>
						</ul>
					</li>
					<li style="display:inline; margin-right:10px;"> <a href="<?php echo $SiteURL;?>createPDF.php?Uid=<?php echo $_GET['Uid']; ?>&host_id=<?php echo $_GET['host_id'];?>"> <img src="<?php echo $SiteURL;?>images/downEPK_b.png"> </a> </li>
				</ul>
				<div class="clear"></div>
				<div class="hgroup">
					<h1><?php echo $fetchUserDetails['host_name'];?></h1>
					<div class="clear"></div>
					<h6><?php echo $fetchUserDetails['epkPagetitle'];?></h6>
				</div>
			</div>
		</div>
	</div>
	<div id="EpkAboutSection">
		<div class="Epk_container">
			<div class="left">
				<h2 class="h2">About</h2>
				<?php echo $fetchUserDetails['about_host'];?>
				<div class="clear"></div>
				<?php 
					if($_GET['host_id'] != '497627')
					{
				?>
						<div class="BookEPK">
							<ul>
								<li><a href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>">Book Now <img src="<?php echo $SiteURL;?>images/EPKarrow.png"></a></li>
								<li class="emailBook"><a href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>"> <?php echo $fetchUserDetails['hostEmail'];?></a></li>
							</ul>
						</div>
				<?php 	}	?>
			</div>
			<div class="right">
				<div class="video-frame">
					<?php  
						if (strpos($fetchUserDetails['videoLink'],'vimeo.com') === false) 
						{ 
					?>
					<!-- <video id="tv_main_channel" controls="true" loop >
						<source id="mp4Source" src="<?php echo $fetchUserDetails['videoLink']; ?>" type="video/mp4">
					</video> -->
							<a class="jwplayerVideo" id="jw_1" href="#dialogx1" name="modal" style="">
							   		<div  id="a1" ></div>
								<script type="text/javascript">
								   	jwplayer("a1").setup({
										file: "<?php echo $fetchUserDetails['videoLink']; ?>",
									  	//file: "https://www.youtube.com/watch?v=TvVPTk9Yowg",
									  	height : 200 ,
									  	width: 200,
									 //  	flashplayer: "<?php echo $SiteURL; ?>jwplayer/jwplayer.flash.swf",
										// html5player: "<?php echo $SiteURL; ?>jwplayer/jwplayer.html5.js",
										// primary: 'html5',
								  	});
								</script>
							</a>	   	
					<?php 	}	
						else
						{
					?>
							<iframe src="<?php echo str_replace('../', '', $fetchUserDetails['videoLink']);?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<?php
						}
					?>
				</div>
				<div class="clear"></div>
				<div class="h3">Video</div>
			</div>
		</div>
	</div>
	<div id="EpkPhotoSection">
		<div class="Epk_container">
			<div class="left">
				<h2 class="h2">Photos</h2>
				<div class="clear"></div>
				<ul class="EpkPhotosSlider">
					<?php 
					while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
					{
				?>
					<li> <a href="<?php echo $SiteURL.$EPKphotos['fullpath'];?>" class="fancybox" /> <img src="<?php echo $SiteURL.$EPKphotos['thumb'];?>" /> </a> </li>
					<?php	}	?>
				</ul>
			</div>
			<div class="right">
				<h2 class="h2">Specials</h2>
				<div class="clear"></div>
				<ul class="EpkSpecial">
					<li> <a href="#"> <img src="<?php echo $SiteURL.$fetchUserDetails['specialPhotothumbPath'];?>" align=""> </a> </li>
				</ul>
			</div>
		</div>
	</div>
	<div id="EpkContactSection">
		<div class="Epk_container">
			<div class="left">
				<h2 class="h2">Contact</h2>
				<div class="clear"></div>
				<div class="ContactFrameEPK">
					<table>
						<?php 
						if(!empty($fetchUserDetails['hostAddress']))
						{
					?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/locationEPK.png" alt=""> <?php echo $fetchUserDetails['hostAddress'];?></td>
						</tr>
						<?php 	
						}	
						if(!empty($fetchUserDetails['hostContact']))
						{
					?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkPhone.png" alt=""> <?php echo $fetchUserDetails['hostContact'];?></td>
						</tr>
						<?php 	}	?>
						<tr>
							<td><a href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>"><img src="<?php echo $SiteURL;?>images/EpkEmail.png" alt=""> <?php echo $fetchUserDetails['hostEmail'];?></</td>
						</tr>
						<?php 
						if(!empty($fetchUserDetails['webLink']))
						{
						?>
						<tr>
							<td><a href="<?php echo $fetchUserDetails['webLink'];?>"><img src="<?php echo $SiteURL;?>images/EpkWeb.png" alt=""><?php echo $fetchUserDetails['webLink'];?></a></td>
						</tr>
						<?php 
						}
						?>
					</table>
					<table>
						<?php 
						if(!empty($fetchUserDetails['facebookLink']))
						{
						?>
						<tr>
							<td><a href="<?php echo $fetchUserDetails['facebookLink'];?>"><img src="<?php echo $SiteURL;?>images/EpkFB.png" alt=""><?php echo $fetchUserDetails['facebookLink'];?></a></td>
						</tr>
						<?php 
						}
						if(!empty($fetchUserDetails['twitterLink']))
						{
						?>
						<tr>
							<td><a href="<?php echo $fetchUserDetails['twitterLink'];?>"><img src="<?php echo $SiteURL;?>images/EpkTw.png" alt=""><?php echo $fetchUserDetails['twitterLink'];?></a></td>
						</tr>
						<?php 
						}
						if(!empty($fetchUserDetails['instagramLink']))
						{
						?>
						<tr>
							<td><a href="<?php echo $fetchUserDetails['instagramLink'];?>"><img src="<?php echo $SiteURL;?>images/EpkInst.png" alt=""><?php echo $fetchUserDetails['instagramLink'];?></a></td>
						</tr>
						<?php 
						}
						if(!empty($fetchUserDetails['soundcloudLink']))
						{
						?>
						<tr>
							<td><a href="<?php echo $fetchUserDetails['soundcloudLink'];?>"><img src="<?php echo $SiteURL;?>images/EpkScloud.png" alt=""><?php echo $fetchUserDetails['soundcloudLink'];?></a></td>
						</tr>
						<?php 
						}
						?>
					</table>
				</div>
			</div>
			<div class="right EpkReview">
				<h2 class="h2">Reviews</h2>
				<div class="clear"></div>
				<img src="<?php echo $SiteURL;?>images/EpkReview.png" style="float:left; margin-right:10px;" alt=""> <?php echo $fetchUserDetails['Hostreviews'];?> </div>
		</div>
	</div>
	<div id="EpkFooter">
		<div class="Epk_container"> Powered by mysittidev.com <img src="<?php echo $SiteURL;?>images/MysittiEpkLogo.png" alt=""> </div>
	</div>
</div>
</body>
</html>
