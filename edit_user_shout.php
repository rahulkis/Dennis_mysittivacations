<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){ 	$Obj->Redirect("login.php"); }

$titleofpage="Edit ShoutOut";
include('LoginHeader.php');

if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$UserID=$_SESSION['user_id'];	
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

$first_name=$loggedin_user_data['first_name']; 
$last_name=$loggedin_user_data['last_name'];
$zipcode=$loggedin_user_data['zipcode'];
$state=$loggedin_user_data['state'];
$country=$loggedin_user_data['country'];
if($loggedin_user_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_user_data['DOB'];
$city=$loggedin_user_data['city'];
$email=$loggedin_user_data['email'];
$image_nm=$loggedin_user_data['image_nm'];
$phone=$loggedin_user_data['phone'];
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);

if(isset($_GET['shout_id']))
{
	$sql_up = mysql_query("select * from shouts where id='".$_GET['shout_id']."'");
	$op_shout = mysql_fetch_assoc($sql_up);
}
       
/******************/
if(isset($_POST['submit']))
{
	
	if($_FILES['shout_media']['error'] == "0")
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
			$path = "upload/shout/images/".time().$u_image.".".$ext;
			$thumbnail = "upload/shout/images/thumb_".time().$u_image.".".$ext;
			move_uploaded_file($tmp1,$path);
				
			//indicate which file to resize (can be any type jpg/png/gif/etc...)
		  	$file = $path;
		   
	  	 	//indicate the path and name for the new resized file
		   	$resizedFile = $thumbnail;
			$resizeObj = new resize($file);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(300, 200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);
		}
		mysql_query("update shouts set image_thumb='".$thumbnail."',shout='".mysql_real_escape_string($_POST['shout'])."',shout_title='".mysql_real_escape_string($_POST['sname'])."',shout_image='".$path."',shout_video='".$video."' where id='".$_GET['shout_id']."'");
			
	}
	elseif($_FILES['shout_media']['error'] == "4")
	{
		mysql_query("update shouts set image_thumb='".$_POST['previous_thumb']."',shout='".mysql_real_escape_string($_POST['shout'])."',shout_title='".mysql_real_escape_string($_POST['sname'])."',shout_image='".$_POST['previous_image']."',shout_video='".$_POST['previous_video']."' where id='".$_GET['shout_id']."'");
	}

 	$user_type = $_SESSION['user_type'];
	$user_id =  $_SESSION['id'];
	$_SESSION['success']="Shout updated successfully";
	//header('Location: user_shout.php');
			 
	if($user_type == "user")
	{
		$Obj->Redirect("user_shout.php?msg=update");die;
	}
	else
	{
		$Obj->Redirect("my_shout.php?msg=update");die;
	}
} 
?>
<style>
  @media only screen and (max-width:479px) {
   .form_format > ul li:nth-child(1) { 
  width: 100% !important;
  margin-bottom:5px;
}

   .form_format > ul li:nth-child(2) { 
  width: 100% !important;
}
#shout_out li, .form_format > ul li { 
  width: 100% !important;
}
  }

</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('friend-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Edit Shout Out</h3>
					<?php 
						if($message!="")
						{
							echo '<div id="successmessage" class="message" >'.$message."</div>";
						}
					?>
						<form name="shout_out" id="shout_out" method="post"   enctype="multipart/form-data" onsubmit="return validate_video();">
							<div class="form_format">     
								<ul>
									<li>Shout Name<span style="color:#F00">*</span>:</li>
							           		<li>
							          			<textarea  cols="40" rows="5" name="shout" id="shout"><?php echo $op_shout['shout']; ?></textarea>
							             	</li>
							         	</ul>
								<ul id="adv-img">  
									<li>Previously Attached Media:</li>
									<li>
									<? 
										if($op_shout['shout_image'] != "")
										{
											$explode_img = explode("upload/shout/images/" , $op_shout['shout_image']);
									?>
											<img src="upload/shout/images/thumb_<?php echo $explode_img[1]; ?>" width="" height="">
									<?php 	}
										elseif($op_shout['shout_video'] != "")
										{ 
									?>				
											<a  id="ve_<?php echo $op_shout["id"];?>" href="#dialogx<?php echo $op_shout["id"];?>" name="modal"></a>
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
									<?php 	}
										else
										{
											echo "No Media Added";
										} 
									?>
									</li>
								</ul>
								<ul id="adv-img">  
									<li>New Shout Media:</li>
									<li>
										<div class="_6a _m" id="u_0_s" style="float: left; width: 100%;">
											<a class="_9lb" aria-pressed="false" role="button" rel="ignore" id="u_0_t" style="float: left;">
												<span class="uiIconText _51z7">
													<i class="img sp_6gM6z_J0XH8 sx_a8afaf">
														<img src="images/upload_camera.png">
													</i>
													Add Photo/Video<i class="_2wr"></i>
												</span>
												<div class="_3jk">
													<input type="file" onchange="return ValidateFileUpload()" id="js_0" class="_n _5f0v" title="Choose a file to upload" name="shout_media" aria-label="Upload Photos/Video">
													<span id="file_upload_successs" style="display: none;">
														<img src="images/tick_green_small.png">
													</span>
												</div>
											</a>
										</div>
									</li>
								</ul>		
								<ul>
									<li>&nbsp;</li>
							          		<li>
											<input type="hidden" name="previous_thumb" value="<?php echo $op_shout['image_thumb']; ?>">
											<input type="hidden" name="previous_image" value="<?php echo $op_shout['shout_image']; ?>">
							    			<input type="hidden" name="previous_video" value="<?php echo $op_shout['shout_video']; ?>">
											<div id="submit_btn" class="mlelft">
							   	 			<input style="margin-right:15px" name="submit" class="button mtop" type="submit" value="Update" />
							   	 			<input style="" class="button mtop" type="button" value="Cancel" onclick="window.location='user_shout.php'" />
							    			</div>
									</li>
								</ul>
						          </div>
						</form>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>

<script>
function resetvideoimage(id){
	$("#"+id).val('');
	$("#"+id).val('');
}
function validate_video()
{
	if(document.getElementById('image_file').value){
		var ext = $('#image_file').val().split('.').pop().toLowerCase();
		if(ext){
		if($.inArray(ext, ['gif','png','jpg']) == -1) {
		alert( "Please valid image type" );return false;
		}
		}
	}
	if(document.getElementById('video_file').value)
	{	
		if(document.getElementById('video_file').value){
		var FileExt = document.getElementById('video_file').value.lastIndexOf('.mp4');
		if(FileExt==-1) {    
		alert('Upload Only .mp4,m4v,.flv,.WebM,.f4v');    
		return false;
		}	

		}
	}
	return true;
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
<? include('Footer.php'); ?>

