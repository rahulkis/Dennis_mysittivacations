<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Upload Banner";

include('HeaderHost.php');	


if(isset($_GET['host_id']) && ( $_GET['host_id'] != "" ))
{
	//die('sdsdsds');
	$userID = $_GET['host_id'];
}
else
{
	$userID = $_SESSION['user_id'];
}

$userType = $_SESSION['user_type'];

if(isset($_POST["uploadbanner"]))
{


		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			//  echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
		} else {
			//  echo "File is not an image.";
				$uploadOk = 0;
		}


list($width, $height, $type, $attr) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
$imgwidth = $width;

$imgheight = $height;

if($imgwidth < 1400)
{
	$uploadOk = 0;
	$error = "Image width minimum should be 1400px ";
}
if($height < 240)
{
	$uploadOk = 0;
	$error = "Image height minimum should be 240px ";
}
// Check if file already exists
if (file_exists($target_file)) {
	 $error ="Sorry, file already exists.";
		$uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
		$error ="Sorry, your file is too large. Size should be less than 1 MB.";
		$uploadOk = 0;
}
// Allow certain file formats
// Check if $uploadOk is set to 0 by an error
//if ($uploadOk == 0) {
//		$error =  $error;
// if everything is ok, try to upload file
//} else {

$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
					$temp = explode(".", $_FILES["fileToUpload"]["name"]);
					$extension = end($temp);
					$name = $userID.time().$_FILES["fileToUpload"]["name"];
					$ext =substr($name,strrpos($name,'.'));
					$temp = explode(".", $_FILES["fileToUpload"]["name"]);
					$extension = end($temp); 
					$tmp1 = $_FILES["fileToUpload"]["tmp_name"];
					$path = "host_banner/".$name;
					$thumb_name = $name."_thumbnail".$ext;
					$thumbnail = "host_banner/thumb/".$thumb_name;
					$image_path="host_banner/".$thumb_name;
					move_uploaded_file($tmp1,$path);	
					 //indicate which file to resize (can be any type jpg/png/gif/etc...)
					$file = $path;
					
					//indicate the path and name for the new resized file
					$resizedFile = $thumbnail;
					
					//call the function (when passing path to pic)
					smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
					//call the function (when passing pic as string)
					smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );

					mysql_query("INSERT INTO host_banner (`id`,`user_id`,`banner_name`,`thumb`,`user_type`) VALUES ('','".$userID."','".$name."','".$thumbnail."','".$userType."')");
	//}
}

if(!isset($userID)){
	$Obj->Redirect("login.php");	
}

if($userType=='user'){
	$Obj->Redirect("home_user.php");
}

//$titleofpage="Upload Banner";
//$userID=$_SESSION['user_id'];


if($_GET['page'] == edit)
			{

			}
elseif($_GET['page'] == del)
			{
		 mysql_query("DELETE FROM `host_banner` WHERE `id` = '".$_GET['id']."'");
		 $message="Banner deleted successfully.";
			} 
elseif($_GET['page'] == act)
			{
		 mysql_query("UPDATE `host_banner` SET `status` = '1' WHERE `id` = '$_GET[id]'  AND `user_id` = '$_SESSION[user_id]' ");
		 mysql_query("UPDATE `host_banner` SET `status` = '0' WHERE `id` != '$_GET[id]'  AND `user_id` = '$_SESSION[user_id]' ");
mysql_query("UPDATE `host_banner` SET `status` = '1' WHERE `id` = '".$_GET['id']."'");
		 $message = "Banner Activated successfully.";
			}
		
$hostquery = "select * from `clubs` where `id` = '".$userID."'";
//$hostArray = $Obj->select($hostquery);	
//$userArray = $Obj->select($hostquery);

//die("gghghgh");

//include('headerhost.php');

	if(isset($_GET['host_id']))
	{
		$hostID1 = $_GET['host_id'];
	}
	else
	{
		$hostID1 = $_SESSION['user_id'];
	}
	

?>

<div class="v2_container">
	<div class="v2_inner_main"> 
		<!-- SIDEBAR CODE  -->
		<?php   
		if(!isset($_GET['host_id']))
		{
			include('club-right-panel.php');	
		}
		else
		{ 
			include('host_left_panel.php');
		} 
	?>
		<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
				<?php 
					if($error != "")
					{ 
						?>
							<script type="text/javascript">
								alert('Warning: Image may appear distorted if minimum requirement not met 1400x240.');
							</script>
						<?php
						//echo '<div id="successmessage1" class="message nocontests" >'.$error."</div>";
					}
					

					?>
						<div id="profile_box" > 
							<!--<a href="host-background.php" class="button" style="float: right;">Background Image</a>				-->
							<h3 id="title" >Upload Banner</h3>
							<?php
$host_banner = "SELECT * FROM `host_banner` WHERE `user_id` = '".$hostID1."' order by id desc";
$host_banner_results = @mysql_query($host_banner);
$count = @mysql_num_rows($host_banner_results);
$class="";	
if($count > 9)
{
	$class = " class='scroll_Div1 tab_scroll'";
}
else
{
	$class = " class='scroll_Divno tab_scroll'";	
}
	
	
	?>
							<div <?php echo $class;?>>
								<?php

	echo "<table class='display uploadBannerNew' id='booktype' > <tr class='odd'><td colspan='5'> 
	
	<form id='uploadBanner' action='upload-banner.php' method='post' enctype='multipart/form-data'>
		
		<div class='ppost_newdesign vtop'>
		<p style='float: left; font-size:13px;' class='required_size'>To get Best Banner upload image 1400x240 minimum resolution.</p>
		<div class='lbl upload_input' style=' '>
		<input type='file' name='fileToUpload' id='fileToUpload' onchange='return ValidateFileUploadee()' style='color: #FFF;'>
		
		</div>
		<div class='submit_upload'><input class='upload_banner' type='submit' value='Upload Image' name='uploadbanner'></div>
		</div>
	
	</form> </td></tr></tbody></table>"  ; 

?>
								
								<!--Select image to upload:-->
								
								<div class='display' id='booktype'>
									<div class="booktype_listing upload_banner_new">
										<?php
				$i=1;
				 while($res = mysql_fetch_array($host_banner_results))
												{// echo '<pre>';print_r($res);die;
										if($i%2 == '0')
										{
												$class = " class='even' ";
										}
										else
										{
												$class = " class='odd' ";
										}
											 // echo $res['requeted_date'];die;
												
												
														
												 ?>
												 <div class="upload_banners">
														<div class="_u_b_img"><img src="<?php echo $res['thumb']; ?>"></div>
														<div class="currnt">
															<?php if($res['status'] == '0') 
						{
						?>
															<a href="?page=act&id=<?php echo $res['id'];?>" onclick="return confirm('Are you sure you want to set this as Banner image?')">
															<?php //echo '$'.$res['price']; ?>
															Set as banner</a>
															<?php
						}
						else
						{
						?>
															<?php //echo '$'.$res['price']; ?>
														 <a href="#"> Current banner</a>	
															<?php }
						?>
															<?php /*?><a href=?page=edit&id=".$res['id']."> <?php */?>
															<?php echo "
						<a class='_u_p_del' href=?page=del&id=".$res['id']." onclick='return confirm(\"Are you sure you want to delete?\")'>
						<img src='images/_udel.png' width='25px' title='Delete' height='25px'></a>"; ?> </div>
							</div>
										<?php $i++; }
		/*end else*/?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>
<script language="javascript">	
				 $(document).ready(function(){
				$('input[type="radio"]').click(function(){
								//alert('sss');
						if($(this).val() == "Disable with message")
						{
								$('#disablemessage').css('display','block');
						}
						else
						{
								$('#disablemessage').css('display','none');
						}
				});
				
				 });

	function ValidateFileUploadee()
	{
			var check_image_ext = $('#fileToUpload').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Banner only allows file types of GIF, PNG, JPG and JPEG');
				$('#fileToUpload').val('');
			}
	}
	
	function ValidateVideoUploadee(){
			var check_image_ext = $('#fileToUpload').val().split('.').pop().toLowerCase();
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Banner Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#fileToUpload').val('');
			}
	}
	</script>
<?php include('Footer.php'); ?>
