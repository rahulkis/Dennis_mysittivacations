<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

$UserID = $_GET['Uid'];

$getUserDetails = mysql_query("SELECT * FROM `epk_host_info` WHERE `epkId` = '$UserID' "); 
$fetchUserDetails = mysql_fetch_assoc($getUserDetails);

$getClubName = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$fetchUserDetails[host_id]' ");
$fetchClubName = mysql_fetch_assoc($getClubName);


$getEPKphotos = mysql_query("SELECT * FROM `epk_host_photos` WHERE `epkID` = '$UserID' ");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysittidev.com || EPK Page</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<!-- ======== Include Main Stylesheet ===============  -->
<link href="<?php echo $SiteURL;?>css/EPKstyle.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL;?>css/responsive.css" rel="stylesheet" type="text/css">

<!-- ======== Include Main Javascript Library ===============  -->
<script src="<?php echo $SiteURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>

<!-- ======== Include Main Other Javascripts ===============  -->

</head>
<body style="padding:10px; background:#fff; background-image:none;">


<table width="100%" style="table-layout: fixed;">
<tr>
<td colspan="2"><h1 style="color: #000;
text-align:center;
	margin-left:20px;
font-size: 30px;
padding-bottom:10px; 
font-weight: bold;">
Electronic Press Kit
</h1></td>
</tr>
	<tr bgcolor="#fecd07" width="100%">
 <td style="padding:10px;" width="60%"><table style="table-layout: fixed;" bgcolor="#fecd07" width="100%">
							<tr>
								<td width="35%"><img height="110px"  style="margin-right:10px; max-width:130px;" src="<?php echo $SiteURL.$fetchUserDetails['primaryPhoto'];?>"></td>
								<td  width="65%"style="vertical-align:bottom;"><h1 style="color: #000;
float: left;
	margin-left:20px;
font-size: 30px;
text-transform:uppercase;
font-weight: bold;"><?php echo $fetchUserDetails['host_name'];?></h1>
									<div class="clear"></div>
									<h6 style="float: left; white-space:nowrap;  margin-left:20px;  margin-top:10px;"><?php echo $fetchUserDetails['hostEmail'];?></h6></td>
							</tr>
						</table></td>
 <td align="center"  width="40%" style="vertical-align: bottom;padding:10px;">
			<?php 
				if(!empty($fetchUserDetails['hostAddress']))
				{
			?>
			<img style="vertical-align:middle; margin-right:10px;max-width:100%; " src="<?php echo $SiteURL;?>images/locationEPK.png" alt="">
						<div  style="clear:both"></div>
						<?php echo $fetchUserDetails['hostAddress'];
				}
				?>

				</td>
	</tr>
	<tr  bgcolor="#fff"  cellpadding="10px" height="100%"  width="100%">
			<td style="padding: 10px; vertical-align: top;" width="40%"><div style="color:#000; font-size: 25px; font-weight: bold; margin-bottom: 10px ;text-transform: uppercase;display:block;"><font style="font-weight:bold"><strong>About</strong></font> </div>
						<div style="clear:both;"></div>
						<div style="width:100%; height:10px; display:table"></div>
						<?php echo $fetchUserDetails['about_host'];?></td>
					<td align="right" style="padding: 20px; text-align:right;" width="60%">
						<a  href="<?php echo $SiteURL.$fetchClubName['club_name'];?>&amp;page=EPK"> 
							<img alt="" src="<?php echo $SiteURL;?>images/videoThumb.png">
						</a>
					</td>
	</tr>
	<tr  bgcolor="#00BAFF" cellpadding="10px"  width="100%">
		<td colspan="2" style="color:#000; font-size: 25px; font-weight: bold; margin-bottom: 10px ;text-transform: uppercase; padding:20px">Photos
						<div style="clear:both"></div>
						<div style="width:100%; height:10px; display:table"></div>
						<?php 
					while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
					{
				?>
						<img height="180px" style="margin-right:10px; margin-bottom:10px; max-width:200px;"  src="https://mysittidev.com/<?php echo $EPKphotos['thumb'];?>"  />
						<?php	}	?></td>
	</tr>
	<tr  bgcolor="#fff" width="100%">
		 <td  style="color:#000; font-size: 25px; font-weight: bold; margin-bottom: 10px ;text-transform: uppercase; padding:20px"><strong>Specials</strong>
						<div style="clear:both"></div>
						<div style="width:100%; height:10px; display:table"></div>
						<img height="100px" src="<?php echo $SiteURL.$fetchUserDetails['specialPhotothumbPath'];?>" align=""></td>
					<td><h1 style="color:#000; font-size: 25px; font-weight: bold; text-transform: uppercase; padding: 20px 0 0px 0"> <strong> Reviews</strong></h1>
						<div style="clear:both"></div>
						<div style="width:100%; height:10px;"></div>
						
						<!-- div style="float:left;" class="reveiwIcon"> <img src="<?php echo $SiteURL;?>images/EpkReview.png" alt=""> </div -->
						
						<div style="width:95%; float:left;"> <?php echo $fetchUserDetails['Hostreviews'];?></div></td>
	</tr>
	<tr  bgcolor="#E8E8E8" width="100%"  cellpadding="10px" >
	<td colspan="2"  style="font-size:13px; padding:20px;"><h1 style="color:#000; font-size: 25px; font-weight: bold; text-transform: uppercase; padding:0px"><strong>Contact</strong></h1>
			<div style="clear:both"></div>
			<div style="width:100%; height:10px;"></div>
			<ul style="padding:10px">
			<?php 
				if(!empty($fetchUserDetails['hostAddress']))
				{
			?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%" src="<?php echo $SiteURL;?>images/locationEPK.png" alt=""> <?php echo $fetchUserDetails['hostAddress'];?> </li>
			<?php 	}
				if(!empty($fetchUserDetails['hostAddress']))
				{
			?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%"  src="<?php echo $SiteURL;?>images/EpkPhone.png" alt=""> <?php echo $fetchUserDetails['hostContact'];?> </li>
			<?php 	}	?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%"  src="<?php echo $SiteURL;?>images/EpkEmail.png" alt=""> <?php echo $fetchUserDetails['hostEmail'];?> </li>
				<?php 
												if(!empty($fetchUserDetails['webLink']))
												{
												?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%"  src="<?php echo $SiteURL;?>images/EpkWeb.png" alt=""> <?php echo $fetchUserDetails['webLink'];?> </li>
				<?php 
												}
												if(!empty($fetchUserDetails['facebookLink']))
												{
												?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%"   src="<?php echo $SiteURL;?>images/EpkFB.png" alt=""> <?php echo $fetchUserDetails['facebookLink'];?></li>
				<?php 
												}
												if(!empty($fetchUserDetails['twitterLink']))
												{
												?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px; max-width:100%"   src="<?php echo $SiteURL;?>images/EpkTw.png" alt=""> <?php echo $fetchUserDetails['twitterLink'];?></li>
				<?php 
												}
												if(!empty($fetchUserDetails['instagramLink']))
												{
													?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%"   src="<?php echo $SiteURL;?>images/EpkInst.png" alt=""> <?php echo $fetchUserDetails['instagramLink'];?></li>
				<?php 
												}
												if(!empty($fetchUserDetails['soundcloudLink']))
												{
													?>
				<li style="margin-bottom:10px"> <img style="vertical-align:middle; margin-right:10px;max-width:100%"   src="<?php echo $SiteURL;?>images/EpkScloud.png" alt=""> <?php echo $fetchUserDetails['soundcloudLink'];?></li>
				<?php } ?>
			</ul></td>
	</tr>
	<tr  bgcolor="#000" width="100%"  cellpadding="10px">
		<td colspan="2" align="right" width="0%" style="font-size:13px; padding:10px; color:#fff"> Powered by mysittidev.com <img  style="vertical-align:middle; margin-left:10px;max-width:50px"   src="<?php echo $SiteURL;?>images/MysittiEpkLogo.png" alt="">
		</td>
	</tr>
	</table>
 

</body>
</html>
