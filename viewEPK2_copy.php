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



$getClubName = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$fetchUserDetails[host_id]' ");
$fetchClubName = mysql_fetch_assoc($getClubName);

$getEPKphotos = mysql_query("SELECT * FROM `epk_host_photos` WHERE `epkID` = '$EPKID' ");
	
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysittidev.com ||<?php echo $fetchUserDetails['host_name'];?>EPK Page</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<!-- ======== Include Main Stylesheet ===============  -->
<link href="<?php echo $SiteURL;?>css/EPK2style.css" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo $SiteURL;?>css/responsive.css" rel="stylesheet" type="text/css"> -->

<!-- ======== Include Main Javascript Library ===============  -->

<!-- ======== Include Main Other Javascripts ===============  -->
 
</head>
<body style="padding: 0px; background:#232523; background-image:none; font-size:10px;">
<table width="100%" border="0" style="table-layout:fixed; max-width:1200px; margin:auto;">
<tr>
<td><h1 style="color: #fff;
text-align:center; 
font-size: 30px;
padding-top:10px;
background:#000;
padding-bottom:10px; 
font-weight: bold;">
Electronic Press Kit
</h1></td>
</tr>
	<tr>
		<td><div style="display: inline-block; margin-right: 2%; width:25%; vertical-align: top;">
				<h1 style="font-size:20px;margin-bottom:10px; text-transform:uppercase; text-align:left; font-weight:bold; display:inline;color:#fecd07;"> <?php echo $fetchUserDetails['host_name'];?> </h1>
				<div style="clear:both"></div>
				<div style="width:100%; height:10px;"></div>
				<ul style="margin-top:0px;">
					<li style=""> <img style="border:2px solid #fff;"  max-width="200px" src="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>" alt="DP" align="center"> </li>
				</ul>
			</div>
			<div style="width: 70%; display: inline-block; vertical-align: top;color:#fff !important;">
				<div style="clear:both"></div>
   
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> About </h1>
				<div style="width:100%; height:10px;"></div>
				<?php echo $fetchUserDetails['about_host'];?> </div></td>
	</tr>
	<tr>
		<td><h1 style="font-size:20px;margin-bottom:10px; text-transform:uppercase; text-align:left; font-weight:bold;color:#fecd07; padding:5px;"> Photos </h1>
			<ul>
				<?php 
				while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
				{
			?>
				<li style="margin-bottom:10px; color:#fff; display:inline"> <img style="border:2px solid #fff; vertical-align:middle; margin-bottom:15px; margin-right:10px; height:120px" src="<?php echo $SiteURL.$EPKphotos['thumb'];?>" alt=""> </li>
				<?php   }   ?>
			</ul>
   </td>
	</tr>
	<tr>
		<td style="color:#fff; background:#232523; padding:10px 10px;">
			<div style="width: 31%; display: inline-block; vertical-align: top; text-align:left; margin-right:2%">
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Video </h1>		<div style="width:100%; height:10px;"></div>
				<ul style="display:table">
					<li style="margin-bottom:10px; color:#fff; display:inline"> <a  href="<?php echo $SiteURL.$fetchClubName['club_name'];?>&amp;page=EPK"> <img style="vertical-align:middle; margin-bottom:15px; margin-right:10px;max-width:100%;" src="<?php echo $SiteURL;?>images/vid.jpg" alt=""> </a> </li>
				</ul>
			</div>
			<div style="width: 31%; display: inline-block; vertical-align: top; text-align:left; margin-right:2%">
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Specials </h1>		<div style="width:100%; height:10px;"></div>
				<ul>
					<li style="margin-bottom:10px; color:#fff; display:inline"> <img style="border:2px solid #fff; vertical-align:middle; margin-bottom:15px; margin-right:10px;max-width:100%;" src="<?php echo $SiteURL.$fetchUserDetails['specialPhotothumbPath'];?>" alt=""> </li>
				</ul>
			</div>
			<div style="width: 32%; display: inline-block; vertical-align: top; text-align:left;">
				<h1 style="font-size:20px;margin-bottom:10px;color:#fecd07; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Reviews </h1>		<div style="width:100%; height:10px;"></div>
				<div style="clear:both;"></div>
				<div style="width:100%; color:#fff;"><?php echo $fetchUserDetails['Hostreviews'];?></div>
			</div></td>
	</tr>
	<tr>
		<td style="color:#fff; background:#353535; padding:10px 10px;"><div style="display: inline-block; margin-right: 2%; width:100%; vertical-align: top;">
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
			</div>
   <div style="background:#111; color:#fff; text-align:right; width:100%"> 
  Powered by mysittidev.com <img style="vertical-align:middle; width:50px; margin-left:10px;" src="<?php echo $SiteURL;?>images/MysittiEpkLogo.png" alt=""> 
  </div>
   </td>
	</tr>

</table>
</body>
</html>
