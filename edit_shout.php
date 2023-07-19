<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

$titleofpage=" Edit Shout";

if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}
?>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta name="google-site-verification" content="o-g5OxxDOWX2F__eELEb5UVS1lDerXIIc1hVhtJ4PpE" />
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<!-- ======== Include Main Stylesheet ===============  -->
<link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css">
<link href="css/stylesNew.css" rel="stylesheet"  type="text/css">
<link href="css/v2style.css" rel="stylesheet" type="text/css">
<link href="css/v1style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">

<link href="css/media.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<link href="css/landingPagestyle.css" rel="stylesheet" type="text/css">
<link href="css/landingPageresponsive.css" rel="stylesheet" type="text/css">
<link href="css/landingPagejquery.bxslider.css" rel="stylesheet" type="text/css">

<!-- ======== Include Main Javascript Library ===============  -->

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-migrate-1.0.0.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script>
<script src="js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="js/add.js" type="text/javascript"></script>

<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript" src="QapTcha-master/jquery/jquery-ui.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>

<script src="js/custom.js"></script>
<script src="js/functions.js"></script>
<script type="text/javascript" src="jwplayer-7.2.4/jwplayer.js"></script>

<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script type="text/javascript" src="js/chat.js"></script>
<script src="js/jquery.blockUI.js"></script>
<link rel="stylesheet" href="css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>
<link rel="stylesheet" href="lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="lightbox2-master/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" href="css/jslider.css" type="text/css">
	<script type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
	<script type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
	<script type="text/javascript" src="js/tmpl.js"></script>
	<script type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
	<script type="text/javascript" src="js/draggable-0.1.js"></script>
	<script type="text/javascript" src="js/jquery.slider.js"></script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>

<link href="datepick/foundation-datepicker.css" rel="stylesheet" type="text/css">
<script src="../datepick/foundation-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>
<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="emoji/emoji.css" type="text/css">
<script src="emoji/config.js"></script>
  <script src="emoji/util.js"></script>
  <script src="emoji/jquery.emojiarea.js"></script>
  <script src="emoji/emoji-picker.js"></script>

<meta name='B-verify' content='fc452fae810405f1fa3a7dba61393529df536296' />


<?php
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
// if(isset($_GET['host_id']))
// {
// 	include('NewHeadeHost.php');
// }
// else
// {
// 	include('NewHeadeHost.php');	
// }
// include('headhost.php');
if(isset($_GET['id']))
{
	$sql_up=@mysql_query("select * from shouts where id='".$_GET['id']."'");
	$op_shout=@mysql_fetch_assoc($sql_up);
}
			$userID = $_SESSION['user_id'];
	/******************/
if(isset($_POST['submit']))
{
	if(!empty($_FILES["shout_media"]["name"]))
	{
		$file_type = $_FILES['shout_media']['type'];
		$exp_file_type = explode('/', $file_type);
		$check_file_type = $exp_file_type[0];
		if($check_file_type == "video" || $check_file_type == "application")
		{
				
			$forum_video=$_FILES['shout_media']['name']; 
			$tmp = $_FILES["shout_media"]["tmp_name"];
			$ext =substr($forum_video,strrpos($forum_video,'.'));
			$video = "upload/shout/video/".time().$forum_video;
			move_uploaded_file($tmp,$video);
				
		}
		elseif($check_file_type == "image")
		{
			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
			$temp = explode(".", $_FILES["shout_media"]["name"]);
			$extension = end($temp);
			$name = $_FILES["shout_media"]["name"];
			$ext =substr($name,strrpos($name,'.'));
			$tmp1 = $_FILES["shout_media"]["tmp_name"];
			$path = "upload/shout/images/".time().$name;
			$thumbnail = "upload/shout/images/thumb_".time().$name;
			move_uploaded_file($tmp1,$path);
				
				
				//indicate which file to resize (can be any type jpg/png/gif/etc...)
			$file = $path;

			//indicate the path and name for the new resized file
			$resizedFile = $thumbnail;

			//call the function (when passing path to pic)
			//   smart_resize_image($image , null, 324 , 200 , false , $resizedFile , false , false ,100 );
			//call the function (when passing pic as string)
			//   smart_resize_image(null , file_get_contents($image), 324 , 200 , false , $resizedFile , false , false ,100);
			$resizeObj = new resize($file);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(300, 200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);

		}
		//echo "update shouts set image_thumb='".$thumbnail."',shout='".$_POST['shout']."',shout_title='".$_POST['sname']."',shout_image='".$path."',shout_video='".$video."' where id='".$_GET['id']."'"; exit;
		mysql_query("update shouts set image_thumb='".$thumbnail."',shout='".mysql_real_escape_string($_POST['shout'])."',shout_title='".mysql_real_escape_string($_POST['sname'])."',shout_image='".$path."',shout_video='".$video."' where id='".$_GET['id']."'");
	}
	else
	{
		mysql_query("update shouts set shout='".mysql_real_escape_string($_POST['shout'])."',shout_title='".mysql_real_escape_string($_POST['sname'])."' where id='".$_GET['id']."'");
	}
	$user_type = $_SESSION['user_type'];
	$user_id =  $_SESSION['id'];
	
	$_SESSION['success']="Shout Updated successfully";
	header('Location: shout.php');
	$Obj->Redirect("shout.php?msg=update");die;
}
?>
<style>
.v2_edit_shout ._n._5f0v {
  position: static;height:auto!important;
}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	 <?php 
		// if(isset($_SESSION['subuser']))
		// {
		// 	include('sub-right-panel.php');
		// }
		// else
		// {
		// 	include('club-right-panel.php');
		// } 

	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						<?php
						  	if($message!="")
						   	{
								echo '<div class="successmessage" id="successmessage">'.$message.'</div> ';
						 	} 
						 ?>
										<!--<div id="title">Shout Out</div>-->
										<h3 class="" id="title">Edit Shout Out</h3>
										<div class="profileright">
											<div id="profile_box">
                                            <div class="v2_edit_shout">
							   <form name="shout_out" id="shout_out" method="post"   enctype="multipart/form-data">
								
						<!--            <div class="row">
										<span class="label" style="font-size:16px;">Shout Name<span style="color:#F00;width:10px !important">*</span>:</span>
										<span class="formw"><input type="text" name="sname" id="sname"  value="<?php echo $op_shout['shout_title']; ?>"></span>
									</div>-->
									
									<div class="row">
										<span class="label" style="font-size:16px;">Shout Name<span style="color:#F00;width:10px !important">*</span>:</span>
										<span class="formw"><textarea  cols="50" rows="5" name="shout" id="shout"><?php echo $op_shout['shout']; ?></textarea></span>
									</div>
									
									<div class="row">
										<span class="label" style="font-size:16px;">Previously Attached Media:</span>
										<span class="formw">
										<? if($op_shout['shout_image'] != ""){
											
											$explode_img = explode("upload/shout/images/" , $op_shout['shout_image']);
											?>
											
											<img src="upload/shout/images/thumb_<?php echo $explode_img[1]; ?>" width="" height="">
										
										<?php }elseif($op_shout['shout_video'] != ""){ ?>
										
											<!-- <a  id="ve_<?php echo $op_shout["id"];?>" href="#dialogx<?php echo $op_shout["id"];?>" name="modal"></a> -->
										
											<a href="javascript:void(0);"  style="width:300px;">
												<div id="a<?php echo $op_shout["id"];?>"></div>
													<script type="text/javascript">
													jwplayer("a<?php echo $op_shout["id"];?>").setup({
													file: "<?php echo $op_shout["shout_video"];?>",
													height : 250 ,
													width: 300
													});
													</script>
											</a>
											
										<?php }else{
										
											echo "No Media Added";
										
												} ?>					
										</span>
									</div>			
									
									<div class="row">
										<span class="label" style="font-size:16px;font-weight:bold">Shout Media:</span>
										<span class="formw">
											<div class="_6a _m" id="u_0_s" style="float: left; width: 100%;">
												<a class="_9lb" aria-pressed="false" role="button" rel="ignore" id="u_0_t" style="float: left;">
												<div class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
												<img src="images/upload_camera.png">
												</i>Add Photo/Video<i class="_2wr"></i>
												</div>
												
												<div class="_3jk">
												<input type="file" onchange="return ValidateFileUpload()" id="js_0" class="_5f0v" title="Choose a file to upload" name="shout_media" aria-label="Upload Photos/Video">
													<span id="file_upload_successs" style="display: none;"><img src="images/tick_green_small.png"></span>
												</div>
												</a>
											</div>
										</span>
									</div>
									
									<div class="row">
										<span class="label" style="font-size:16px;"></span>
										<span class="formw"></span>
									</div>
									 <div class="row">
									<span class="label" style="font-size:16px;">&nbsp;</span>
									<span class="formw">
									<div id="submit_btn">
									 <input class="button pull-l" style="float:left !important" name="submit" type="submit" value="Update" />
									 <div style=""><a class="button back_edituser" href="shout.php">Back</a></div>
									</div>
									</span>
									</div>
							   	</form>
                                </div>
							</div>
			   			</div>
					</div>
				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

	 
 <script type="text/javascript">	
	function Validate_editshout_FileUpload(){
			var check_image_ext = $('#edit_shout_img').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
				$('#edit_shout_img').val('');
			}
	}
	
	function Validate_editshout_VideoUpload(){
			var check_image_ext = $('#edit_shout_video').val().split('.').pop().toLowerCase();
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#edit_shout_video').val('');
			}
	}
	
	function ValidateFileUpload(){
			var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
				alert('Shout Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
				$('#js_0').val('');
				$('#file_upload_successs').hide();
			}else{
				$('#file_upload_successs').show();
			}
	}
 </script>  
<?php //include('Footer.php') ?>

