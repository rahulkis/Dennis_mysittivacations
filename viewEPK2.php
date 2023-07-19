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
$ShareFacebookURl = urlencode($SiteURL.$fetchUserDetails['host_name'].'&page=EPK');	
$ShareTitle = urlencode($fetchUserDetails['host_name'].' Electronic Press Kit Page');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysittidev.com || <?php echo $fetchUserDetails['host_name'];?> EPK Page</title>
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

<script type="text/javascript">
	$(document).ready(function(){
		console.clear();
		getYoutubeLinks();

	});
	function getYoutubeLinks()
	{
		console.clear();
		videos = document.getElementById("tv_main_channel");
		//for (var i = 0, l = videos.length; i < l; i++) 
		//{
			var video = videos;
			var src = video.src || (function () 
			{
				var sources = video.querySelectorAll("source");
				for (var j = 0, sl = sources.length; j < sl; j++) 
				{
					var source = sources[j];
					var type = source.type;
					var isMp4 = type.indexOf("mp4") != -1;
					if (isMp4) return source.src;
				}
				return null;
			})();
			if (src) 
			{
				var isYoutube = src && src.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
				if (isYoutube) 
				{
					var id = isYoutube[1].match(/watch\?v=|[\w\W]+/gi);
					id = (id.length > 1) ? id.splice(1) : id;
					id = id.toString();
					var mp4url = "http://www.youtubeinmp4.com/redirect.php?video=";
					video.src = mp4url + id;
					$('#mp4Source').attr('src',mp4url + id);
				}
			}
		//}
	}
</script>
<style>
.body {padding-top:0 !important;}
@media only screen and (max-width: 767px) {
body {
		padding-top: 0px !important;
}
}

@media only screen and (max-width: 1024px) {
   body{
   box-sizing:border-box;
  -webkit-box-sizing:border-box;
  padding:0px !important;
  }
 table.epk_2 {
  float: left !important;
  width: 98% !important;box-sizing:border-box;
  -webkit-box-sizing:border-box;
}
.col1_epk {
  float: left;
  width: 100% !important;
  box-sizing: border-box;
  border: 0!important;
  box-sizing:border-box;
  -webkit-box-sizing:border-box;
}
.col2_epk {
  float: left;
  width: 96% !important;box-sizing:border-box;
  -webkit-box-sizing:border-box;
}
.col3_epk {
  float: left;box-sizing:border-box;
  -webkit-box-sizing:border-box;
  width: 96%;
}
.col4_epk {
  float: left;box-sizing:border-box;
  -webkit-box-sizing:border-box;
  width: 96% !important;
}
}

@media only screen and (max-width: 767px) {
 table.epk_2 {
  float: left !important;
  width: 98% !important;
}
.col5_epk {
  float: left;
  width: 100% !important; 
}
.col6_epk {
  float: left;
  width: 100% !important;
}
.col7_epk {
  float: left;
  width: 100%;
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
.epkAdmin li{position:relative;}
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
.epkAdmin li:hover ul {display:block;}
table p span {color:#fff !important;} 
table p, table span, table i, table strong, table ul li {color:#fff !important;}

</style>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d1a0b5b3-5460-45ac-9d43-802d8c763b24", doNotHash: false, doNotCopy: false, hashAddressBar: false,shorten: false});</script>

</head>
<body style="padding: 0px; background:#000; background-image:none; font-size:10px;">
<table class="epk_2" border="0" style="table-layout:fixed; width:1200px; margin:auto;">
<tr>
<td class="col1_epk"><h1 style="color: #fff;
text-align:center; 
font-size: 30px;
padding-top:10px;
padding-bottom:10px; 
font-weight: bold;">
Electronic Press Kit
</h1></td>
</tr>
	<tr>
		<td class="col2_epk" style="color:#fff; background:#232523; padding:30px 10px;">
  <div class="col1_epk"  style="display: inline-block; margin-right: 2%; width:18%; vertical-align: top;">
				<h1 style="font-size:20px;margin-bottom:10px; text-transform:uppercase;  text-align:left; font-weight:bold; display:inline;color:#fecd07;"> <?php echo $fetchUserDetails['host_name'];?> </h1>
				<div style="clear:both"></div>
				<div style="width:100%; height:10px;"></div>
				<ul style="margin-top:0px;">
					<li style=""> <img style="border:2px solid #fff;"  max-width="100%" src="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>" alt="DP" align="center"> </li>
				</ul>
			</div>
			<div class="col1_epk" style="width: 79%; display: inline-block; vertical-align: top; color:#fff !important;">
				<div style="clear:both"></div>
     <ul style="float:right;" class="epkAdmin epk2admin">
				<?php 
					if($_SESSION['user_type'] == 'club' && $_SESSION['user_id'] == $_GET['host_id'])
					{
				?>
						<li style="display:inline; margin-right:10px;">
							<a href="<?php echo $SiteURL;?>epk2.php?epkID=<?php echo $_GET['Uid']; ?>&host_id=<?php echo $_GET['host_id'];?>">
								<img src="<?php echo $SiteURL;?>images/editEPK.png">
							</a>
						</li>
  
				<?php	} ?>
					<li style="display:inline; margin-right:10px; position:relative;">
						<a href="javascript:void(0);">
							<img src="<?php echo $SiteURL;?>images/shareEPK.png">
						</a>
						<ul>
							<li> 
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
					<li style="display:inline; margin-right:10px;">
						<a href="<?php echo $SiteURL;?>createPDF.php?Uid=<?php echo $_GET['Uid']; ?>&host_id=<?php echo $_GET['host_id'];?>">
							<img src="<?php echo $SiteURL;?>images/downEPK.png">
						</a>
					</li>
			</ul>
				<h1 class="epk2Heading" style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> About </h1>
				<div style="width:100%; height:10px;"></div>
				<?php echo $fetchUserDetails['about_host'];?> </div></td>
	</tr>
	<tr>
		<td bgcolor="#353535" style="padding:30px 10px;"><h1 style="font-size:20px;margin-bottom:10px; text-transform:uppercase; text-align:left; font-weight:bold;   color:#fecd07; padding:5px;"> Photos </h1>
			<ul>
				<?php 
				while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
				{
			?>
				<li style="margin-bottom:10px; color:#fff; display:inline"> <img style="border:2px solid #fff; vertical-align:middle; margin-bottom:15px; margin-right:10px; height:120px" src="<?php echo $SiteURL.$EPKphotos['thumb'];?>" alt=""> </li>
				<?php   }   ?>
			</ul></td>
	</tr>
	<tr>
		<td style="color:#fff; background:#232523; padding:30px 10px;"><div style="clear:both"></div>
			<div class="col5_epk" style="width: 31%; display: inline-block; vertical-align: top; text-align:left; margin-right:2%">
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Video </h1>
				<ul style="display:table">
					<li style="margin-bottom:10px; color:#fff; display:inline"> 
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
											  	height : 200 ,
											  	width: 200
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
					</li>
				</ul>
			</div>
			<div class="col5_epk"  style="width: 31%; display: inline-block; vertical-align: top; text-align:left; margin-right:2%">
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Specials </h1>
				<ul>
					<li style="margin-bottom:10px; color:#fff; display:inline"> <img style="border:2px solid #fff; vertical-align:middle; margin-bottom:15px; margin-right:10px;max-width:100%;" src="<?php echo $SiteURL.$fetchUserDetails['specialPhotothumbPath'];?>" alt=""> </li>
				</ul>
			</div>
			<div class="col5_epk"  style="width: 32%; display: inline-block; vertical-align: top; text-align:left;">
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Reviews </h1>
				<div style="clear:both;"></div>
				<div style="width:100%; color:#fff;"><?php echo $fetchUserDetails['Hostreviews'];?></div>
			</div></td>
	</tr>
	<tr>
		<td style="color:#fff; background:#353535; padding:30px 10px;"><div style="display: inline-block; margin-right: 2%; width:100%; vertical-align: top;">
				<h1 style="font-size:20px;margin-bottom:10px;margin-top:20px; text-transform:uppercase; text-align:left;color:#fecd07; font-weight:bold; display:table;"> Contact </h1>
				<ul style="padding:10px 0">
					<?php 
					if(!empty($fetchUserDetails['hostAddress']))
					{
					?>
					<li style="color:#fff; text-align:left;font-size: 14px; padding-top:10px; padding-bottom:10px;"> <img style="vertical-align:top; max-width:100%" src="<?php echo $SiteURL;?>images/locationEPK2.png" alt=""> <?php echo $fetchUserDetails['hostAddress'];?> </li>
					<?php 	}	
					if(!empty($fetchUserDetails['hostContact']))
					{
					?>
					<li style="margin-bottom:10px; color:#fff; font-size: 14px; text-align:left;padding-bottom:10px;padding-top:10px; "> <img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/phoneEPK2.png" alt=""> <?php echo $fetchUserDetails['hostContact'];?> </li>
					<?php 	}	
					if(!empty($fetchUserDetails['hostEmail']))
					{
					?>
					<li style="margin-bottom:10px; font-size: 14px;color:#fff; text-align:left;  padding-bottom:10px;"> <img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/emailEPK2.png" alt=""><?php echo $fetchUserDetails['hostEmail'];?> </li>
					<?php 	}	
					if(!empty($fetchUserDetails['webLink']))
					{
					?>
					<li style="margin-bottom:10px;font-size: 14px; color:#fff;text-align:left; padding-bottom:10px;"> <img style="vertical-align:middle; float:left; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/web_EPK2.png" alt=""> <?php echo $fetchUserDetails['webLink'];?> </li>
					<?php 	}	
					if(!empty($fetchUserDetails['facebookLink']))
					{
					?>
					<li style="margin-bottom:10px;font-size: 14px; color:#fff;word-wrap:break-word; word-break:break-all;text-align:left; padding-bottom:10px;"> <img style="vertical-align:middle; margin-right:10px;max-width:100%;" src="<?php echo $SiteURL;?>images/fb_epk2.png" alt=""><?php echo $fetchUserDetails['facebookLink'];?> </li>
					<?php 	}	
					if(!empty($fetchUserDetails['twitterLink']))
					{
					?>
					<li style="margin-bottom:10px;font-size: 14px; color:#fff;text-align:left;padding-bottom:10px;padding-top:10px;"> <img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/tw_epk2.png" alt=""><?php echo $fetchUserDetails['twitterLink'];?> </li>
					<?php 	}
					if(!empty($fetchUserDetails['instagramLink']))
					{
					?>
					<li style="margin-bottom:10px;color:#fff;text-align:left;font-size: 14px;"> <img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/instaEPK2.png" alt=""><?php echo $fetchUserDetails['instagramLink'];?> </li>
					<?php 	}
					if(!empty($fetchUserDetails['soundcloudLink']))
					{
					?>
					<li style="margin-bottom:10px; color:#fff;font-size: 14px;"> <img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/instaEPK2.png" alt=""><?php echo $fetchUserDetails['soundcloudLink'];?> </li>
					<?php 	}
					?>
				</ul>
			</div></td>
	</tr>
 <tr>
 <tr>
  <td style="background:#000; text-align:right; padding:3px 0;color:#fff;">
 	 
 Powered by mysittidev.com <img style="vertical-align:middle; margin-left:10px; width:50px;" src="<?php echo $SiteURL;?>images/MysittiEpkLogo.png" alt=""> 
 
 </td>
 </tr>
</table>
</body>
</html>
