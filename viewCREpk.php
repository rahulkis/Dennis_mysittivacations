<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

include('image_upload_resize.php');
include("resize-class.php");
include("user_upgrade.php");

$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
$ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";

// $EPKID = $_GET['Uid'];


// $HOSTID  = $_GET['host_id'];


	if(isset($_POST['submitEpk']))
	{

	
		$epkPagetitle = mysql_real_escape_string($_POST['epkPagetitle']);
		$HostName = mysql_real_escape_string($_POST['hostName']);
		$HostBIO = mysql_real_escape_string($_POST['hostBIO']);
		$Hostreviews  = mysql_real_escape_string($_POST['Hostreviews']);
		$hostContact  = mysql_real_escape_string($_POST['hostContact']);
		$hostAddress  = mysql_real_escape_string($_POST['hostAddress']);
		$HostEmail = mysql_real_escape_string($_POST['HostEmail']);
		$epkpageLink = mysql_real_escape_string($_POST['epkpageLink']);
		$webLink = mysql_real_escape_string($_POST['webLink']);
		$facebookLink = mysql_real_escape_string($_POST['facebookLink']);
		$twitterLink = mysql_real_escape_string($_POST['twitterLink']);
		$instagramLink = mysql_real_escape_string($_POST['instagramLink']);
		$soundcloudLink = mysql_real_escape_string($_POST['soundcloudLink']);
		$videoLink = mysql_real_escape_string($_POST['videoLink']);
		$template = 0;
		/* PRIMARY PIC UPLOAD*/

		if(!empty($_FILES["primaryPhoto"]["name"]))
		{

			$primaryPhotoName = trim($_FILES["primaryPhoto"]["name"]);
			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
			if(($_FILES["primaryPhoto"]["type"] == "image/gif") || ($_FILES["primaryPhoto"]["type"] == "image/jpeg") || ($_FILES["primaryPhoto"]["type"] == "image/jpg") || ($_FILES["primaryPhoto"]["type"] == "image/png"))
			{
				$primaryPhotoName = trim($_FILES["primaryPhoto"]["name"]);
				$primaryPhotoName = str_replace(' ', '', $_FILES["primaryPhoto"]["name"]);
				$tmp=$_FILES['primaryPhoto']['tmp_name'];
				$primaryPhotoPath = "_".time().strtotime(date("Y-m-d")).$primaryPhotoName;
				$primaryFullPath="upload/".$primaryPhotoPath;	
				$primaryFullPath1="upload/_newthumb_".$primaryPhotoPath;	
				$primaryPhotothumb = "_".time().md5(strtotime(date("Y-m-d")))."_thumbnail".$primaryPhotoName;
				$primaryPhotothumbPath = "upload/".$primaryPhotothumb;	
				move_uploaded_file($tmp,$primaryFullPath);

				
				 //indicate which file to resize (can be any type jpg/png/gif/etc...)
				$file = $primaryFullPath;
				$file1 = $primaryFullPath;
				//indicate the path and name for the new resized file
				$resizedFile = $primaryPhotothumbPath;
				$resizedFile1 = $primaryFullPath1;
				//call the function (when passing path to pic)
				//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
				//call the function (when passing pic as string)
				//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
				$resizeObj = new resize($file);
				$resizeObj1 = new resize($file1);

				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			//	$resizeObj -> resizeImage(500, 350, 'auto');
			$resizeObj -> resizeImage(200,150, 'auto');
			$resizeObj1 -> resizeImage(400,350, 'auto');
				// *** 3) Save image ('image-name', 'quality [int]')
				$resizeObj -> saveImage($resizedFile, 100);
				$resizeObj1 -> saveImage($resizedFile1, 100);
			}
		}

		/* SPECIAL PHOTO PATH */

		if(!empty($_FILES["specialPhoto"]["name"]))
		{

			$specialPhotoName = trim($_FILES["specialPhoto"]["name"]);
			$specialPhotoName = str_replace(' ', '', $_FILES["specialPhoto"]["name"]);
			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
			if(($_FILES["specialPhoto"]["type"] == "image/gif") || ($_FILES["specialPhoto"]["type"] == "image/jpeg") || ($_FILES["specialPhoto"]["type"] == "image/jpg") || ($_FILES["specialPhoto"]["type"] == "image/png"))
			{
				//$specialPhotoName = trim($_FILES["specialPhoto"]["name"]);
				$tmp=$_FILES['specialPhoto']['tmp_name'];
				$specialPhotoPath = "_".time().strtotime(date("Y-m-d")).$specialPhotoName;
				$specialPhotoFullPath="upload/".$specialPhotoPath;	
				$specialPhotothumb = "_".time().md5(strtotime(date("Y-m-d")))."_thumbnail".$specialPhotoName;
				$specialPhotothumbPath = "upload/".$specialPhotothumb;	
				move_uploaded_file($tmp,$specialPhotoFullPath);

				
				 //indicate which file to resize (can be any type jpg/png/gif/etc...)
				$file = $specialPhotoFullPath;
				
				//indicate the path and name for the new resized file
				$resizedFile = $specialPhotothumbPath;
				
				//call the function (when passing path to pic)
				//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
				//call the function (when passing pic as string)
				//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
				$resizeObj = new resize($file);

				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				//			$resizeObj -> resizeImage(500, 350, 'auto');
			$resizeObj -> resizeImage(200,150, 'auto');

				// *** 3) Save image ('image-name', 'quality [int]')
				$resizeObj -> saveImage($resizedFile, 100);
			}
		}


		$getEPKinfo12 = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$_GET[HOSTEID]' ");
		$FetchOldResult = mysql_fetch_assoc($getEPKinfo12);

		if(empty($_FILES["primaryPhoto"]["name"]))
		{
			$resizedFile1 = $FetchOldResult['primaryPhoto'];
			$primaryPhotothumbPath = $FetchOldResult['primaryPhotothumbPath'];
		}

		if(empty($_FILES["specialPhoto"]["name"]))
		{
			$specialPhotoFullPath = $FetchOldResult['specialPhototPath'];
			$specialPhotothumbPath = $FetchOldResult['specialPhotothumbPath'];
		}





		// if(mysql_num_rows($getEPKinfo12) > 0)
		// {
		// 	mysql_query("UPDATE `epk_host_info` SET `host_name` = '$HostName',
		// 			`about_host` = '$HostBIO',
		// 			`epkPagetitle` = '$epkPagetitle',
		// 			`hostEmail` = '$HostEmail',
		// 			`hostAddress` = '$hostAddress',
		// 			`hostContact` = '$hostContact',
		// 			`epkpageLink` = '$epkpageLink' ,
		// 			`videoLink` = '$videoLink',
		// 			`primaryPhoto` = '$resizedFile1',
		// 			`primaryPhotothumbPath` = '$primaryPhotothumbPath',
		// 			`specialPhototPath` = '$specialPhotoFullPath',
		// 			`specialPhotothumbPath` = '$specialPhotothumbPath',
		// 			`webLink` = '$webLink', 
		// 			`facebookLink` = '$facebookLink',
		// 			`twitterLink` = '$twitterLink',
		// 			`instagramLink` = '$instagramLink', 
		// 			`soundcloudLink` = '$soundcloudLink',
		// 			`Hostreviews` = '$Hostreviews',
		// 			`template` = '$template'
		// 			WHERE  `epkId` = '$_GET[epkID]' 
		// 			AND `host_id` = '$_SESSION[user_id]' ");
		// 	$EPKid = $_GET['epkID'];
		// }
		// else
		// {

			$getCountEPK = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$_SESSION[user_id]'");
			if(mysql_num_rows($getCountEPK) > 0 )
			{
				$def = '0';
			}
			else
			{
				$def = '1';
			}
			mysql_query("INSERT INTO `epk_host_info` (`template`,`epkPagetitle`,`hostAddress`,`hostContact`,`Hostreviews`,`host_name`,`host_id`,`about_host`,`hostEmail`,`videoLink`,`primaryPhoto`,`primaryPhotothumbPath`,`specialPhototPath`,`specialPhotothumbPath`,`webLink`,`facebookLink`,`twitterLink`,`instagramLink`,`soundcloudLink`,`epkpageLink`,`status`) VALUES ('$template','$epkPagetitle','$hostAddress','$hostContact','$Hostreviews','$HostName','$_SESSION[user_id]','$HostBIO','$HostEmail','$videoLink','$resizedFile1','$primaryPhotothumbPath','$specialPhotoFullPath','$specialPhotothumbPath','$webLink','$facebookLink','$twitterLink','$instagramLink','$soundcloudLink','$epkpageLink','$def')");
			$EPKid = mysql_insert_id();
		// }






		/* MULITPLE PHOTOS CODE UPLOAD */
		$no=count($_FILES['file']['name']);
		
		for ($i=0;$i<$no;$i++)
		{
			$fileName = trim($_FILES["file"]["name"][$i]);
			if(!empty($fileName))
			{

				$temp = explode(".", $_FILES["file"]["name"][$i]);
				$extension = end($temp);
				
				if ((($_FILES["file"]["type"][$i] == "image/gif")
				|| ($_FILES["file"]["type"][$i] == "image/jpeg")
				|| ($_FILES["file"]["type"][$i] == "image/jpg")
				|| ($_FILES["file"]["type"][$i] == "image/png")))
				//&& in_array($extension, $allowedExts))
				{
					$file_name= str_replace(' ', '', $_FILES['file']['name'][$i]);
					$tmp=$_FILES['file']['tmp_name'][$i];
					$img_path = "_".time().strtotime(date("Y-m-d")).$file_name;
					$path="upload/".$img_path;	
					$thumb = "_".time().md5(strtotime(date("Y-m-d")))."_thumbnail".$file_name;
					$thumbnail = "upload/".$thumb;	
					move_uploaded_file($tmp,$path);

					
					 //indicate which file to resize (can be any type jpg/png/gif/etc...)
					$file = $path;
					
					//indicate the path and name for the new resized file
					$resizedFile = $thumbnail;
					
					//call the function (when passing path to pic)
					//smart_resize_image($file , null, 200 , 200 , false , $resizedFile , false , false ,100 );
					//call the function (when passing pic as string)
					//smart_resize_image(null , file_get_contents($file), 200 , 200 , false , $resizedFile , false , false ,100 );			
					$resizeObj = new resize($file);

					// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				//	$resizeObj -> resizeImage(500, 350, 'auto');
					$resizeObj -> resizeImage(200,150, 'auto');

					// *** 3) Save image ('image-name', 'quality [int]')
					$resizeObj -> saveImage($resizedFile, 100);		
					//echo "INSERT INTO `epk_host_photos` (`epkID`,`host_id`,`thumb`,`fullpath`) VALUES ('$EPKid','$_SESSION[user_id]','$thumbnail','$path') ";
					mysql_query("INSERT INTO `epk_host_photos` (`epkID`,`host_id`,`thumb`,`fullpath`) VALUES ('$EPKid','$_SESSION[user_id]','$thumbnail','$path') ");
					
				}
				else
				{
					//die('dsfsfds');
					$_SESSION['imageError'] = 'ImageFail';
					if(isset($_GET['HOSTEID']))
					{
						$Obj->Redirect("epkTemplate.php?HOSTEID=".$_GET['HOSTEID']);
					}
					else
					{
						$Obj->Redirect("epkTemplate.php");
					}
					
					die;
				}
			}
		}

			// die;
		
		

		// if(isset($_POST['previewEpk']))
		// {
		// 	if($template == '0')
		// 	{
		// 		$Obj->Redirect($SiteURL.'viewEPK.php?Uid='.$EPKid.'&host_id='.$_SESSION['user_id']);
		// 		die;
		// 	}
		// 	elseif($template == '1' )
		// 	{
		// 		$Obj->Redirect($SiteURL.'viewEPK1.php?Uid='.$EPKid.'&host_id='.$_SESSION['user_id']);
		// 		die;
		// 	}
		// 	elseif($template == '2')
		// 	{
		// 		$Obj->Redirect($SiteURL.'viewEPK2.php?Uid='.$EPKid.'&host_id='.$_SESSION['user_id']);
		// 		die;
		// 	}
		// }
		// else
		// {
		// 	$Obj->Redirect($SiteURL.'EPKlist.php');
		// 	$_SESSION['epkInfo'] = 'Updated';
		// 	die;
		// }

		
		header("Location: https://mysitti.com/EPKlist.php");
		die();
	}
	/* SUBMIT CODE END */

	/* GET INFO */

	if(isset($_GET['action']) && $_GET['action'] == 'deletePhoto')
	{
		$photoId = $_GET['epkIDphoto'];
		mysql_query("DELETE FROM `epk_host_photos` WHERE `host_id` = '$_SESSION[user_id]' AND `epkphotoId` = '$photoId' ");
		$_SESSION['photoDeleted'] = 'Delete';
		$Obj->Redirect('epkTemplate.php?HOSTEID='.$_GET['HOSTEID']);
	}

	$getEPKphotos = mysql_query("SELECT * FROM `epk_host_photos` WHERE `host_id` = '$_SESSION[user_id]' AND `epkID` = '$_GET[HOSTEID]' ");

	
	$getHostDjDesc = mysql_query("SELECT * FROM `host_dj_profile` WHERE `host_id` = '$_SESSION[user_id]' ");
	$fetchHostDesc = mysql_fetch_assoc($getHostDjDesc);
	$getEPKinfo = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$_GET[HOSTEID]' ");
	$EPKINFO = mysql_fetch_assoc($getEPKinfo);

	if(!empty($EPKINFO['host_name']))
	{
		$hostName = $EPKINFO['host_name'];
	}
	else
	{
		$hostName = $_SESSION['username'];	
	}


$getUserDetails = mysql_query("SELECT * FROM `epk_host_info` WHERE `epkId` = '$EPKID' OR `host_id` = '$_GET[HOSTEID]'");
$fetchUserDetails = mysql_fetch_assoc($getUserDetails);



?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysitti.com ||<?php echo $fetchUserDetails['host_name'];?>EPK Page</title>
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

input#booking {
    padding: 10px;
}
.EpkPhotosSlider>li {
	width: 23% !important;
}
.ContactFrameEPK input {
	padding: 8px;
}
span.formw-epk {
    display: inline-block;
    position: relative;
    width: 100%;
    background: white;
}
.formw-epk ul.btncenter_new {
    margin: 0 auto;
    text-align: center;
    width: 20%;
}
.formw-epk li {
    float: left;
    padding: 11px;
    background: #32c741;
    margin-left: 10px;
    margin-bottom: 10px;
}
input.button.addfrmbutton {
    background: #32c741;
    border: none;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}
.yallow-cancel {
	background: #fecd07 !important;
    font-size: 15px;
    font-weight: 600; 
}
a.button.addfrmbutton {
    background: #fecd07;
}
li.yallow-cancel {
   padding: 13px !important;
}
input.txt_box {
    padding: 7px;
    margin-top: 10px;
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
	<form style="max-width:100% !important;" method="POST" action="" enctype="multipart/form-data" class="musicadd" id="EPKform">
	<div id="EpkHeader">
	 
		<div class="Epk_container">
		 
			<div class="left">
				<div id="EpkProfile">
				<label for="primaryPhoto">
				<img src="imagesNew/camera-logo-512.png" style="cursor: pointer;">
				</label>
				<input id="primaryPhoto" type="file" name="primaryPhoto" style="display: none;" />
				</div>
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
					<input readonly type="text" name="hostName" class="txt_box" value="<?php if(!empty($EPKINFO['host_name'])){ echo $EPKINFO['host_name']; }else{ echo $_SESSION['username']; } ?>" required >
					<div class="clear"></div>
					<input type="text" name="epkPagetitle" class="txt_box" value="" placeholder="Fill EPK Page Title" required />
				</div>
			</div>
		</div>
	</div>
	<div id="EpkAboutSection">
		<div class="Epk_container">
			<div class="left">
				<h2 class="h2">About</h2>
				
				<textarea id="HostBio" type="text" name="hostBIO" class="txt_box" ></textarea>
				
				<div class="clear"></div>
				<?php 
					if($_GET['host_id'] != '497627')
					{
				?>
						<div class="BookEPK">
							<ul>
								<li><a href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>">Book Now <img src="<?php echo $SiteURL;?>images/EPKarrow.png"></a></li>
								<!-- <li class="emailBook"><a href="mailto:<?php echo $fetchUserDetails['hostEmail'];?>"> <?php echo $fetchUserDetails['hostEmail'];?></a></li> -->
								<input id="booking"  type="text" placeholder="Enter Your Booking Email"  name="HostEmail" value="<?php if(!empty($EPKINFO['hostEmail'])){ echo $EPKINFO['hostEmail']; }?>"  />
							</ul>
						</div>
				<?php 	}	?>
			</div>
			<div class="right">
				<div class="video-frame">
					<?php  
						if (strpos($fetchUserDetails['videoLink'],'vimeo.com') === true) 
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
							<!-- <iframe src="<?php echo str_replace('../', '', $fetchUserDetails['videoLink']);?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->
							<img src="imagesNew/film-camera-alt-512.jpg">
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
				<label>(You can select multiple photos also)</label></br>
				<input style="color: #fff !important;" type="file" id="image_file" name="file[]" multiple onchange="return ValidateFileUpload()" />
				<ul class="EpkPhotosSlider">
					<?php 
					// while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
					// {
				?>
					<!-- <li> <a href="<?php echo $SiteURL.$EPKphotos['fullpath'];?>" class="fancybox" /> <img src="<?php echo $SiteURL.$EPKphotos['thumb'];?>" /> </a> </li> -->
					<?php	//}	?>
				<li><img src="imagesNew/empty-photo.png"></li>	
				<li><img src="imagesNew/empty-photo.png"></li>	
				<li><img src="imagesNew/empty-photo.png"></li>	
				</ul>
			</div>
			<div class="right">
				<h2 class="h2">Specials</h2>
				<div class="clear"></div>
				<input style="color: #fff !important;" type="file" id="specialPhoto" name="specialPhoto" onchange="return ValidateFileUploadspecial()" />
				<ul class="EpkSpecial">
					<li><img src="imagesNew/special.png"></li>
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
						// if(!empty($fetchUserDetails['hostAddress']))
						// {
					?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/locationEPK.png" alt=""> <input id="hostAddress" type="text" name="hostAddress" value="" placeholder="Enter Your Address"/></td>
						</tr>
						<?php 	
						// }	
						// if(!empty($fetchUserDetails['hostContact']))
						// {
					?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkPhone.png" alt=""> <input id="hostContact" type="text" name="hostContact" value="" placeholder="Enter Your Contact number"/></td>
						</tr>
						<?php 	//}	?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkEmail.png" alt=""> <input id="booking"  type="text" placeholder="Enter Your Booking Email"  name="HostEmail" value="" /></td>
						</tr>
						<?php 
						// if(!empty($fetchUserDetails['webLink']))
						// {
						?>
						
						<?php 
						// }
						?>
					</table>
					<table>
						<?php 
						// if(!empty($fetchUserDetails['facebookLink']))
						// {
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkFB.png" alt=""><input value="" id="your-facebook-address" type="text" name="facebookLink" placeholder="http://facebook.com/"/></td>
						</tr>
						<?php 
						//}
						// if(!empty($fetchUserDetails['twitterLink']))
						// {
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkTw.png" alt=""><input value="" id="your-twitter-address" type="text" name="twitterLink" placeholder="http://twitter.com/"/></td>
						</tr>
						<?php 
						//}
						// if(!empty($fetchUserDetails['instagramLink']))
						// {
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkInst.png" alt=""><input value="" id="your-instagram-address" type="text" name="instagramLink" placeholder="http://instagram.com/"/></td>
						</tr>
						<?php 
						//}
						// if(!empty($fetchUserDetails['soundcloudLink']))
						// {
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkScloud.png" alt=""><input value="" id="your-soundcloud-address" type="text" name="soundcloudLink" placeholder="http://soundcloud.com/"/></td>
						</tr>
						<?php 
						// }
						?>
					</table>
				</div>
			</div>
			<div class="right EpkReview">
				<h2 class="h2">Reviews</h2>
				<div class="clear"></div>
				<!-- <img src="<?php echo $SiteURL;?>images/EpkReview.png" style="float:left; margin-right:10px;" alt=""> <?php echo $fetchUserDetails['Hostreviews'];?>  -->
				<textarea id="Hostreviews" type="text" name="Hostreviews" class="txt_box" ></textarea>
			</div>
		</div>
	</div>
	<span class="formw-epk">		
		<ul class="btncenter_new" >
			<li>
				<input type="submit" name="submitEpk" value="Save" class="button addfrmbutton"  />
			</li>
			<!-- <li>
				<input type="submit" name="previewEpk" value="Preview" class="button addfrmbutton"  />
			</li> -->
			<li class="yallow-cancel">
			<!-- <input type="submit" name="submit" value="Submit" class="button addfrmbutton"  /> -->
			<a href="<?php echo $SiteURL;?>epkTemplate.php" class="button addfrmbutton" >Cancel</a>
			</li>
		</ul>
	</span>
	</form>
	<div id="EpkFooter">
		<div class="Epk_container"> Powered by mysitti.com <img src="<?php echo $SiteURL;?>images/MysittiEpkLogo.png" alt=""> </div>
	</div>
</div>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
	<script>tinymce.init({
				selector:'textarea#HostBio, textarea#Hostreviews',
				toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
				fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
				menubar: false
			});</script>
</body>
</html>
