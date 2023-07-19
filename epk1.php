<?php 

include("Query.Inc.php");
$Obj = new Query($DBName);


$titleofpage = "EPK template";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if($userType=='user' || !isset($_SESSION['user_id'])){
	$Obj->Redirect("index.php");
}


$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;

if($userArray[0][type_of_club]!=11){
//$Obj->Redirect("home_club.php");
}


?>

<?php 
	

	if(isset($_POST['submitEpk']) || isset($_POST['previewEpk']))
	{

	// echo "<pre>"; print_r($_POST); print_r($_FILES); exit;
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
		$template = $_POST['template'];
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


		$getEPKinfo12 = mysql_query("SELECT * FROM `epk_host_info` WHERE `epkId` = '$_GET[epkID]' ");
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





		if(mysql_num_rows($getEPKinfo12) > 0)
		{
			mysql_query("UPDATE `epk_host_info` SET `host_name` = '$HostName',
					`about_host` = '$HostBIO',
					`epkPagetitle` = '$epkPagetitle',
					`hostEmail` = '$HostEmail',
					`hostAddress` = '$hostAddress',
					`hostContact` = '$hostContact',
					`epkpageLink` = '$epkpageLink' ,
					`videoLink` = '$videoLink',
					`primaryPhoto` = '$resizedFile1',
					`primaryPhotothumbPath` = '$primaryPhotothumbPath',
					`specialPhototPath` = '$specialPhotoFullPath',
					`specialPhotothumbPath` = '$specialPhotothumbPath',
					`webLink` = '$webLink', 
					`facebookLink` = '$facebookLink',
					`twitterLink` = '$twitterLink',
					`instagramLink` = '$instagramLink', 
					`soundcloudLink` = '$soundcloudLink',
					`Hostreviews` = '$Hostreviews',
					`template` = '$template'
					WHERE  `epkId` = '$_GET[epkID]' 
					AND `host_id` = '$_SESSION[user_id]' ");
			$EPKid = $_GET['epkID'];
		}
		else
		{
			$getCountEPK = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$_SESSION[user_id]' ");
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
		}






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
					if(isset($_GET['epkID']))
					{
						$Obj->Redirect("epk1.php?epkID=".$_GET['epkID']);
					}
					else
					{
						$Obj->Redirect("epk1.php");	
					}
					
					die;
				}
			}
		}

// die;
		
		

		if(isset($_POST['previewEpk']))
		{
			if($template == '0')
			{
				$Obj->Redirect($SiteURL.'viewEPK.php?Uid='.$EPKid.'&host_id='.$_SESSION['user_id']);
				die;
			}
			elseif($template == '1' )
			{
				$Obj->Redirect($SiteURL.'viewEPK1.php?Uid='.$EPKid.'&host_id='.$_SESSION['user_id']);
				die;
			}
			elseif($template == '2')
			{
				$Obj->Redirect($SiteURL.'viewEPK2.php?Uid='.$EPKid.'&host_id='.$_SESSION['user_id']);
				die;
			}
		}
		else
		{
			$Obj->Redirect($SiteURL.'EPKlist.php');
			$_SESSION['epkInfo'] = 'Updated';
			die;
		}

		
		
	}
	/* SUBMIT CODE END */

	/* GET INFO */

	if(isset($_GET['action']) && $_GET['action'] == 'deletePhoto')
	{
		$photoId = $_GET['epkIDphoto'];
		mysql_query("DELETE FROM `epk_host_photos` WHERE `host_id` = '$_SESSION[user_id]' AND `epkphotoId` = '$photoId' ");
		$_SESSION['photoDeleted'] = 'Delete';
		$Obj->Redirect('epk1.php?epkID='.$_GET['epkID']);
	}

	$getEPKphotos = mysql_query("SELECT * FROM `epk_host_photos` WHERE `host_id` = '$_SESSION[user_id]' AND `epkID` = '$_GET[epkID]' ");

	
	$getHostDjDesc = mysql_query("SELECT * FROM `host_dj_profile` WHERE `host_id` = '$_SESSION[user_id]' ");
	$fetchHostDesc = mysql_fetch_assoc($getHostDjDesc);
	$getEPKinfo = mysql_query("SELECT * FROM `epk_host_info` WHERE `epkId` = '$_GET[epkID]' ");
	$EPKINFO = mysql_fetch_assoc($getEPKinfo);

	if(!empty($EPKINFO['host_name']))
	{
		$hostName = $EPKINFO['host_name'];
	}
	else
	{
		$hostName = $_SESSION['username'];	
	}


?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysittidev.com || Terry Wall And The Wallbangers EPK Page</title>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta property="og:title" content="Terry Wall And The Wallbangers Electronic Press Kit Page">
<meta property="og:image" content="https://mysitti.com/upload/_newthumb__15151399871515110400_1511247600balloon-on-mount-fuji-from-japan_SwZCvedhMg.jpg">
<meta property="og:url" content="https://mysitti.com/Terry Wall And The Wallbangers&page=EPK" />
<!-- ======== Include Main Stylesheet ===============  -->
<link href="https://mysitti.com/css/EPKstyle.css" rel="stylesheet" type="text/css">


<style>
.col5_epk input {
  color: black;
  height: 35px;
  width: 100%;
}
.ContactFrameEPK input {
  border: 1px solid #ddd;
  color: black;
  height: 35px;
  margin: auto;
  padding: 0 8px;
  width: 240px;
}
.col3_epk > label {
  color: white;
  margin: 10px auto;
}
.btncenter_new.btn_edit {
  display: block;
  float: left;
  margin: 20px auto;
  width: 100%;
  text-align: center;
}
.btncenter_new.btn_edit > li {
    background: white none repeat scroll 0 0;
    border: medium none;
    display: inline-block;
    margin: 9px;
    padding: 0 !important;
    text-align: center;
}
.btncenter_new.btn_edit > li input{
	color: black !important;
}
.btncenter_new.btn_edit > li a{
	color: black !important;
}
.txt_box {
  color: black;
  height: 35px;
  margin: 15px auto;
  padding: 6px;
  width: 100%;
}
.col1_epk > input {
  color: black;
  height: 35px;
  margin: 10px auto;
  padding: 0 10px;
  width: 100%;
}
.epk_2 tr td {
	vertical-align: top !important;
}
.NewHeaderHostBanner{
	display: none;
}
.kl {
  background: rgba(0, 0, 0, 0) url("images/bgEPK2.png") no-repeat fixed center top / cover ;
}
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
<div class="kl">

<table class="epk_2"  border="0" style="width:1200px; margin:auto;" align="center">
<tr>
<td colspan="3"><h1 style="color: #fff;
text-align:center; 
font-size: 30px;
padding-bottom:10px; 
margin-bottom:15px;
font-weight: bold; border-bottom:1px solid #fff;">

<h1 style="color: #000;text-align:center;font-size: 30px;padding-bottom:10px; padding-top:5px;font-weight: bold;float:left; width:100%; background:#fff;">EPK info</h1>

						<?php 
							if($_SESSION['photoDeleted'] == 'Deleted')
							{
								echo '<div style="display:block;" id="successmessage" class="message" >Photo Deleted Successfully.</div>';
								unset($_SESSION['epkInfo']);
								unset($_SESSION['imageError']);
								unset($_SESSION['videoError']);
								unset($_SESSION['photoDeleted']);
							}
							if($_SESSION['imageError'] == 'ImageFail')
							{
								echo '<div style="display:block;" id="errormessage" class="message" >Image Uploading failed</div>';
								unset($_SESSION['imageError']);
								unset($_SESSION['epkInfo']);unset($_SESSION['videoError']);
							}
							elseif($_SESSION['videoError'] == 'VideoFail')
							{
								echo '<div style="display:block;" id="errormessage" class="message" >Video Uploading Failed</div>';
								unset($_SESSION['videoError']);
								unset($_SESSION['imageError']);
								unset($_SESSION['epkInfo']);
							}
							if(isset($_SESSION['epkInfo']) && $_SESSION['epkInfo'] == 'Updated')
							{
								echo '<div style="display:block;" id="successmessage" class="message" >EPK Information Updated.</div>';
								unset($_SESSION['epkInfo']);
								unset($_SESSION['imageError']);
								unset($_SESSION['videoError']);
							}

						?>


</h1></td>
</tr>
	<form style="max-width:100% !important;" method="POST" action="" enctype="multipart/form-data" class="musicadd" id="EPKform">

	<tr>
		<td class="col1_epk" width="36%" style="padding:10px 2% 10px 10px; color:#fff; border-right:1px solid #fff;">
			
			<div style="clear:both"></div>

			<ul style="margin-top:20px;">
				<li>
						<label for="primaryPhoto">
					
							<?php 
					if(!empty($EPKINFO['primaryPhoto']))
					{
					?>
				
						<span class="label">
							<label >Uploaded Primary Photo: <!-- <b><font color='red'><em></em></font></b> --></label>
						</span>
						
							<img src="<?php echo $EPKINFO['primaryPhoto']; ?>" />
					
					
					<?php 
					}	?>
					</label>
					<input id="primaryPhoto" type="file" name="primaryPhoto" style="display: none;" name="primaryPhoto" onchange="return ValidateFileUploadprimary()" />
				</li>
			</ul>

			<div style="clear:both"></div>
			<h1 style="font-size:20px;margin-bottom:10px;margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; display:table;">BIOGRAPHY </h1>

			<textarea id="HostBio" type="text" name="hostBIO" class="txt_box" ><?php if(!empty($EPKINFO['about_host'])){ echo $EPKINFO['about_host']; }else{ echo $fetchHostDesc['hostdj_description']; } ?></textarea>
						<br/>
                        <label >Select EPK Page Template:</label>
					<div class="clear"></div>
					
					<select name='template' class="txt_box">
						<option value="0" <?php if($EPKINFO['template'] != '1' || $EPKINFO['template'] != '2' ){ echo 'selected';} ?>>Template 1</option>
						<option value="1" <?php if($EPKINFO['template'] == '1'){ echo 'selected';} ?>>Template 2</option>
						<option value="2" <?php if($EPKINFO['template'] == '2'  ){ echo 'selected';} ?>>Template 3</option>
					</select>
                    
					<div class="clear"></div>
                    <label >EPK Page Title:</label>
					<div class="clear"></div>

                     <input type="text" name="epkPagetitle" class="txt_box" value="<?php if(!empty($EPKINFO['epkPagetitle'])){ echo $EPKINFO['epkPagetitle']; } ?>" placeholder="EPK Page Title" required >
                    
                    <div class="clear"></div>
                    <label >Your Name:</label>
                    <div class="clear"></div>
                    <input readonly type="text" name="hostName" class="txt_box" value="<?php if(!empty($EPKINFO['host_name'])){ echo $EPKINFO['host_name']; }else{ echo $_SESSION['username']; } ?>" required >
                     <div class="clear"></div>
                     <label >Your EPK Page web address</label>

                     <div class="clear"></div>

                     <input  type="text" readonly  name="epkpageLink" value="<?php echo $SiteURL.$hostName;?>&amp;page=EPK" placeholder="https://mysittidev.com/" />

                     <div class="clear"></div>
					
						<div style="clear:both"></div>
			</td>
		<td class="col2_epk" width="2%">&nbsp;</td>
		<td class="col3_epk" width="60%"><h1 style="font-size:20px;margin-bottom:10px; text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px; margin-top: 55px;"> Photos </h1>
			
					<label>(You can select multiple photos also)</label></br>
						<input style="color: #fff !important;" type="file" id="image_file" name="file[]" multiple onchange="return ValidateFileUpload()" />

									<?php 
								if(mysql_num_rows($getEPKphotos) > 0) 
								{
							?> 		
									<div class="row photos"> 
		    <ul class="EpkPhotosSlider">
							<?php 			
										while($EPKphotos = mysql_fetch_assoc($getEPKphotos))
										{
									?>	
		    <li>
											<a href="<?php echo $EPKphotos['fullpath'];?>" class="fancybox" />
												<img src="<?php echo $EPKphotos['thumb'];?>" />	
		       											
											</a>
		      <div class="delEpkImg">
		       												<img onclick="deletePhotoEPK('<?php echo $EPKINFO['epkId'];?>','<?php echo $EPKphotos['epkphotoId'];?>');" src="<?php echo $SiteURL;?>images/delEpk.png" title="Delete" alt="Delete" />
		       											</div>
		      </li>
											<input type="hidden" name="uploadedFiles[]" value="<?php echo $EPKphotos['epkphotoId'];?>" />	
											
									<?php
										}	
									?>
		    </ul>
									
							<?php	}
							?>
			<div style="clear:both;"></div>
			<div style="display:table; width:100%">
				<div class="col5_epk" style="display:table-cell; padding-righ:25px;">
					<h1 style="font-size:20px;margin-bottom:10px; margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Video </h1>
					<ul style="display:table">
					 <li style=" margin-bottom:10px; color:#fff; display:inline"> 

					 <input type="text"  name="videoLink" placeholder="youtube.com/????? or vimeo.com/?????"  id="computer_file" value="<?php if(!empty($EPKINFO['videoLink'])){ echo $EPKINFO['videoLink']; }?>" />
														
						 
							</li> 
					</ul>
				</div>
				<div class="col6_epk"  style="display:table-cell; padding-left:25px;">
					<h1 style="font-size:20px;margin-bottom:10px; margin-top:20px;text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Specials </h1>

					<input style="color: #fff !important;" type="file" id="specialPhoto" name="specialPhoto" onchange="return ValidateFileUploadspecial()" />

				<ul class="EpkSpecial">
					<li><img src="<?php echo $EPKINFO['specialPhotothumbPath']; ?>" /></li>
				</ul>
				</div>
			</div>
			<div style="clear:both;"></div>
			
  <div style="display:table; width:100%; color:#fff;">
				<h1 style="font-size:20px;margin-bottom:10px; margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; background:#fecd07; color:#000; padding:5px;"> Reviews </h1>
				<textarea id="Hostreviews" type="text" name="Hostreviews" class="txt_box" ><?php if(!empty($EPKINFO['Hostreviews'])){ echo $EPKINFO['Hostreviews']; } ?></textarea>		
			</div>
		</td>
	</tr>
 <tr>
 <td class="col4_epk" colspan="3" style="color:#fff;">

   
   <h1 style="font-size:20px;margin-bottom:10px;margin-top:20px; text-transform:uppercase; text-align:left; font-weight:bold; display:table;"> Contact </h1>
   <div style="background:#111; padding:10px;">

    <div class="ContactFrameEPK">

     <table>
						<?php 
						
					?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/locationEPK.png" alt=""> <input id="hostAddress"  type="text" name="hostAddress" value="<?php if(!empty($EPKINFO['hostAddress'])){ echo $EPKINFO['hostAddress']; }?>"  /></td>
						</tr>
						<?php 	
						
					?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkPhone.png" alt=""> <input id="hostContact"  type="text"  name="hostContact" value="<?php if(!empty($EPKINFO['hostContact'])){ echo $EPKINFO['hostContact']; }?>"  /></td>
						</tr>
						<?php 		?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkEmail.png" alt=""> <input id="booking"  type="text" placeholder="Enter Your Booking Email"  name="HostEmail" value="<?php if(!empty($EPKINFO['hostEmail'])){ echo $EPKINFO['hostEmail']; }?>"  /></td>
						</tr>
						<?php 
						
						?>
						
						<?php 
						
						?>
					</table>
					<table>
						<?php 
						
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkFB.png" alt=""><input  value="<?php if(!empty($EPKINFO['facebookLink'])){ echo $EPKINFO['facebookLink']; }?>"  id="your-facebook-address" type="text"  name="facebookLink" value="" placeholder="http://facebook.com/" /></td>
						</tr>
						<?php 
						
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkTw.png" alt=""><input  value="<?php if(!empty($EPKINFO['twitterLink'])){ echo $EPKINFO['twitterLink']; }?>" id="your-twitter-address" type="text"  name="twitterLink" value="" placeholder="http://twitter.com/" /></td>
						</tr>
						<?php 
						
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkInst.png" alt=""><input  value="<?php if(!empty($EPKINFO['instagramLink'])){ echo $EPKINFO['instagramLink']; }?>" id="your-instagram-address"  type="text"  name="instagramLink" value="" placeholder="http://instagram.com/" /></td>
						</tr>
						<?php 
						
						?>
						<tr>
							<td><img src="<?php echo $SiteURL;?>images/EpkScloud.png" alt=""><input  value="<?php if(!empty($EPKINFO['soundcloudLink'])){ echo $EPKINFO['soundcloudLink']; }?>"  id="your-soundcloud-address" type="text"  name="soundcloudLink" value="" placeholder="http://soundcloud.com/" /></td>
						</tr>
						<?php 
						
						?>
					</table>
					</div>


			<span class="formw-epk">		
		<ul class="btncenter_new btn_edit" >
			<li>
				<input type="submit" name="submitEpk" value="Save" class="button addfrmbutton"  />
			</li>
			<li>
				<input type="submit" name="previewEpk" value="Preview" class="button addfrmbutton"  />
			</li>
			<li>
				<!-- <input type="submit" name="submit" value="Submit" class="button addfrmbutton"  /> -->
				<a href="<?php echo $SiteURL;?>EPKlist.php" class="button addfrmbutton" >Cancel</a>
			</li>
		</ul>
	</span>		
				
				
			</div>
 
 </td>
 </tr>
 </form>
</table>
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
