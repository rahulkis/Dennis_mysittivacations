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
<title>mysittidev.com || <?php echo $fetchUserDetails['host_name'];?> EPK Page</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta property="og:title" content="<?php echo $fetchUserDetails['host_name'];?> Electronic Press Kit Page">
<meta property="og:image" content="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>">
<meta property="og:url" content="<?php echo $SiteURL.$fetchUserDetails['host_name'];?>&page=EPK" />
<!-- ======== Include Main Stylesheet ===============  -->
<link href="<?php echo $SiteURL;?>css/EPKstyle.css" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo $SiteURL;?>css/responsive.css" rel="stylesheet" type="text/css"> -->
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


<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d1a0b5b3-5460-45ac-9d43-802d8c763b24", doNotHash: false, doNotCopy: false, hashAddressBar: false,shorten: false});</script>

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
 
 span {color:#fff !important;}
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
}
.col2_epk {
  float: left;box-sizing:border-box;
  -webkit-box-sizing:border-box;
  width: 96% !important;
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
  padding-left:0 !important;
}
.col7_epk {
  float: left;
  width: 100%;
}
 
}
table p, table span, table i, table strong, table ul li {color:#fff !important;}
 </style>

</head>
<body style="background:url(images/bgEPK2.png) center top no-repeat; background-attachment:fixed; background-size:cover;   padding:20px;">
<table class="epk_2"  border="0" style="width:1200px; margin:auto;" align="center">
<tr>
<td colspan="3"><h1 style="color: #fff;
text-align:center; 
font-size: 30px;
padding-bottom:10px; 
margin-bottom:15px;
font-weight: bold; border-bottom:1px solid #fff;">

Electronic Press Kit
</h1></td>
</tr>
	<tr>
		<td class="col1_epk" width="36%" style="padding:10px 2% 10px 10px; color:#fff; border-right:1px solid #fff;">
			<h1 style="font-size:20px;margin-bottom:20px; text-transform:uppercase; text-align:left; font-weight:bold; display:inline;">
				<?php echo $fetchUserDetails['host_name'];?>
			</h1>
			<ul style="float:right;" class="epkAdmin">
				<?php 
					if($_SESSION['user_type'] == 'club' && $_SESSION['user_id'] == $_GET['host_id'])
					{
				?>
						<li style="display:inline; margin-right:10px;">
							<a href="<?php echo $SiteURL;?>epk1.php?epkID=<?php echo $_GET['Uid']; ?>&host_id=<?php echo $_GET['host_id'];?>">
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
			<div style="clear:both"></div>
			<ul style="margin-top:20px;">
				<li>
					<img  height="200px" src="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>" alt="DP" style="border:1px solid #fff;">
				</li>
			</ul>
			<div style="clear:both"></div>
			<h1 style="font-size:20px;margin-bottom:10px;margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> About </h1>
			<?php echo $fetchUserDetails['about_host'];?>
			<?php 
				if($_GET['host_id'] != '497627')
				{
			?>
					<div class="BookEPK">
						<ul>
							<li>
								<a style="background:green; border:1px solid green" href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>">Book Now 
									<img src="<?php echo $SiteURL;?>images/EPKarrow.png">
								</a>
							</li>
							<li class="">
								<a style="padding:10px 0; background:none; border:0; color:#fecd07;" href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>">
									Email: <?php echo $fetchUserDetails['hostEmail'];?>
								</a>
							</li>
						</ul>
					</div>
			<?php 	}	?>
			<div style="clear:both"></div>
			</td>
		<td class="col2_epk" width="2%">&nbsp;</td>
		<td class="col3_epk" width="60%"><h1 style="font-size:20px;margin-bottom:10px; text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Photos </h1>
			<ul>
			<?php 
				while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
				{
			?>
					<li style="margin-bottom:10px; color:#fff; display:inline"> 
						<img style="border:1px solid #fff; vertical-align:middle; margin-bottom:15px; margin-right:10px;width:190px; height:150px" src="<?php echo $SiteURL.$EPKphotos['thumb'];?>" alt=""> 
					</li>
			<?php	}	?>
				
			</ul>
			<div style="clear:both;"></div>
			<div style="display:table; width:100%">
				<div class="col5_epk" style="display:table-cell; padding-righ:25px;">
					<h1 style="font-size:20px;margin-bottom:10px; margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Video </h1>
					<ul style="display:table">
					 <li style=" margin-bottom:10px; color:#fff; display:inline"> 
							<?php  
								if (strpos($fetchUserDetails['videoLink'],'vimeo.com') === false) 
								{ 
							?>
							<!-- <video style="border:1px solid #fff; vertical-align:middle;" id="tv_main_channel" controls="true" loop >
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
							<iframe style="border:1px solid #fff; vertical-align:middle;" src="<?php echo str_replace('../', '', $fetchUserDetails['videoLink']);?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							<?php
								}
							?>
						</li> 
					</ul>
				</div>
				<div class="col6_epk"  style="display:table-cell; padding-left:25px;">
					<h1 style="font-size:20px;margin-bottom:10px; margin-top:20px;text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Specials </h1>
					<ul>
						<li style="margin-bottom:10px; color:#fff; display:inline"> 
							<img style="border:1px solid #fff; vertical-align:middle; margin-bottom:15px; margin-right:10px;max-width:100%;" src="<?php echo $SiteURL.$fetchUserDetails['specialPhotothumbPath'];?>" alt=""> 
						</li>
					</ul>
				</div>
			</div>
			<div style="clear:both;"></div>
			
  <div style="display:table; width:100%; color:#fff;">
				<h1 style="font-size:20px;margin-bottom:10px; margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Reviews </h1>
				<?php echo $fetchUserDetails['Hostreviews'];?>		
			</div>
		</td>
	</tr>
 <tr>
 <td class="col4_epk" colspan="3" style="color:#fff;">

   
   <h1 style="font-size:20px;margin-bottom:10px;margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Contact </h1>
   <div style="background:#111; padding:10px;">
				
				<ul style="padding:10px">
					<?php 
					if(!empty($fetchUserDetails['hostAddress']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/locationEPK2.png" alt=""> 
							<?php echo $fetchUserDetails['hostAddress'];?>
						</li>		
				<?php 	}	
					if(!empty($fetchUserDetails['hostContact']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/phoneEPK2.png" alt=""> 
							<?php echo $fetchUserDetails['hostContact'];?>
						</li>	
				<?php 	}	
					if(!empty($fetchUserDetails['hostEmail']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/emailEPK2.png" alt=""> 
							<?php echo $fetchUserDetails['hostEmail'];?>
						</li>	
				<?php 	}	
					if(!empty($fetchUserDetails['webLink']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/web_EPK2.png" alt=""> 
							<?php echo $fetchUserDetails['webLink'];?>
						</li>	
				<?php 	}	
					if(!empty($fetchUserDetails['facebookLink']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/fb_epk2.png" alt="">
								<?php echo $fetchUserDetails['facebookLink'];?>
						</li>	
				<?php 	}	
					if(!empty($fetchUserDetails['twitterLink']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/tw_epk2.png" alt="">
							<?php echo $fetchUserDetails['twitterLink'];?>
						</li>	
				<?php 	}
					if(!empty($fetchUserDetails['instagramLink']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/instaEPK2.png" alt="">
							<?php echo $fetchUserDetails['instagramLink'];?>
						</li>
							
				<?php 	}
					if(!empty($fetchUserDetails['soundcloudLink']))
					{
					?>
						<li style="margin-bottom:10px; color:#fff;"> 
							<img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/instaEPK2.png" alt="">
							<?php echo $fetchUserDetails['soundcloudLink'];?>
						</li>
							
				<?php 	}
					?>

				</ul>
			</div>
   	<div style="background:#333; color:#fff; text-align:right; margin-top:10px;">
		  Powered by mysittidev.com <img style="vertical-align:middle; width:50px; margin-left:10px;" src="<?php echo $SiteURL;?>images/MysittiEpkLogo.png" alt="">  
	</div>
 </td>
 </tr>
</table>
</body>
</html>
