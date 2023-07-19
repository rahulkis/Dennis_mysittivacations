<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if($userType=='user'){
	$Obj->Redirect("index.php");
}

if(isset($_POST['video_set_action'])){
	
	$check_video = mysql_query("SELECT hostdj_video FROM host_dj_profile WHERE host_id = '".$_SESSION['user_id']."'");
	$count_video = mysql_num_rows($check_video);
		
	if($_POST['video_set_action'] == 'set'){
		
			if($count_video < 1){
				
				echo "Please add a video first to the bio";	
			}else{
		
				mysql_query("UPDATE host_dj_profile SET default_bio = 'video' WHERE host_id = '".$_SESSION['user_id']."'");
				echo "Default bio set to video";
			}
	}
	
	if($_POST['video_set_action'] == 'unset'){
		
		if($count_video == 1){
			
			mysql_query("UPDATE host_dj_profile SET default_bio = 'text' WHERE host_id = '".$_SESSION['user_id']."'");
			echo "Default bio set to text";
		}
	}
	
die;
}

$titleofpage=" Edit Bio";	
if(isset($_GET['edithostdj']))
{
	include('NewHeadeHost.php');
}
else
{
	include('HeaderHost.php');	
}

?>

<style>
span.formw {
	float: right;
	text-align: left;
	width: 480px;
}
div.row {
	clear: both;
	padding-top: 5px
}

.default_vid_outer{
	display: none;
}
</style>
<?php
if($_GET['edithostdj'] == 'edithostdj')
{
	$gethostdjprofile  = "select * from host_dj_profile where host_id = ".$_SESSION['user_id'] ;
	$resulquerythostdjprofile = @mysql_query($gethostdjprofile);
	$resulthostdjprofile = @mysql_fetch_assoc($resulquerythostdjprofile);

}

if(isset($_POST['hostdj_profile_edit']))
{
	$hostdj_profile_pic = $_FILES['forum_hodtdj_profile_img']['name'];
	$enable = $_POST['enable'];
	if($hostdj_profile_pic)
	{

	
		$temp = $_FILES["forum_hodtdj_profile_img"]["tmp_name"];
		$path = "hostdj_pics/profile_pic/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_img"]["name"];
		$temp = $_FILES["forum_hodtdj_profile_img"]["name"];
		$temp1 = explode(".", $_FILES["forum_hodtdj_profile_img"]["name"]);
		$extension = end($temp1);
		$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$getname."_thumbnail.".$extension;
		$thumbnail = "hostdj_pics/profile_pic/".$_SESSION['user_id']."/".$thumb;

		move_uploaded_file($_FILES["forum_hodtdj_profile_img"]["tmp_name"],"hostdj_pics/profile_pic/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_img"]["name"]);
		$file = $path;
			
		//indicate the path and name for the new resized file
		$resizedFile = $thumbnail;
		
		$hostdj_profile_pic = $resizedFile;
	
		$resizeObj = new resize($file);

		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$resizeObj -> resizeImage(300,200, 'auto');

		// *** 3) Save image ('image-name', 'quality [int]')
		$resizeObj -> saveImage($resizedFile, 100);	


	
	}
	else 
	{
		$hostdj_profile_pic = $resulthostdjprofile['hostdj_profile_pic'];
	}
	
	$count = count($_FILES['forum_hodtdj_profile_images']['name']);
	for($a=0;$a<$count;$a++)
	{
		$getname = $_FILES['forum_hodtdj_profile_images']['name'][$a];
		$getall .= $getname.",";
		$temp = $_FILES["forum_hodtdj_profile_images"]["tmp_name"][$a];
		$temp1 = explode(".", $_FILES["forum_hodtdj_profile_images"]["name"][$a]);
		$extension = end($temp1);
		$pathg = "hostdj_pics/gallery/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_images"]["name"][$a];

		$thumb = $getname;
		
		$thumbnailg = "hostdj_pics/gallery/".$_SESSION['user_id']."/".$thumb;


		move_uploaded_file($_FILES["forum_hodtdj_profile_images"]["tmp_name"][$a],"hostdj_pics/gallery/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_images"]["name"][$a]);
		$fileg = $pathg;
			
		//indicate the path and name for the new resized file
		$resizedFileg = $thumbnailg;
		

		$resizeObj = new resize($file);

		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$resizeObj -> resizeImage(300,200, 'auto');

		// *** 3) Save image ('image-name', 'quality [int]')
		$resizeObj -> saveImage($resizedFile, 100);	
				
							
				
	}
	$explodegallery =  explode("," , $resulthostdjprofile['hostdj_gallery_pic']);
	$gallercount = count($explodegallery);
	
	for($b=0;$b<$gallercount;$b++)
	{
		$getall1 .= $explodegallery[$b].",";
	}	
			
	$updatedimgagal .= $getall;
	$updatedimgagal .= $getall1;
	$updatedimgagal;
		 
	$file_type = $_FILES['add_post_video_distinct']['type'];
	$exp_file_type = explode('/', $file_type);
	$check_file_type = $exp_file_type[0];
	$video_name = "";
	
	if($check_file_type == "video" || $check_file_type == "application"){
		
		$forum_video=$_FILES['add_post_video_distinct']['name']; 
		$tmp = $_FILES["add_post_video_distinct"]["tmp_name"]; 
		$video_name = "video/bio_".time().strtotime(date("Y-m-d")).$forum_video; 
		move_uploaded_file($tmp,$video_name);
		
	}

	 $des = mysql_real_escape_string($_POST['hodtdj_profile_description']);
	 $nme = mysql_real_escape_string($_POST['hodtdj_profile_name']);

	if($video_name == ""){
		
			@mysql_query("UPDATE `host_dj_profile` SET `hostdj_name` = '$nme', `hostdj_description` = '$des'  , `hostdj_profile_pic` = '$hostdj_profile_pic' , `hostdj_gallery_pic` = '$updatedimgagal', `enable` = '1' WHERE `host_id` =".$_SESSION['user_id']);
		
	}else{
			
				@mysql_query("UPDATE `host_dj_profile` SET `hostdj_name` = '$nme', `hostdj_description` = '$des'  , `hostdj_profile_pic` = '$hostdj_profile_pic' , `hostdj_gallery_pic` = '$updatedimgagal', `enable` = '1', `hostdj_video` = '".$video_name."' WHERE `host_id` =".$_SESSION['user_id']);
			
	}
		
	$_SESSION['bio_edit_succ'] = "success";
	$Obj->Redirect("hostdj_profile.php");
	die;
}

if(isset($_POST['hostdj_profile']))
{
	$hostdj_prfilename = $_POST['hodtdj_profile_name'];
	$hostdj_description = $_POST['hodtdj_profile_description'];
	$hostdj_profile_pic = $_FILES['forum_hodtdj_profile_img']['name'];
	$enable = $_POST['enable'];
	
	$host_id = $_POST['host_id'];
	if(!is_dir("hostdj_pics/profile_pic/". $_SESSION['user_id'] ."/"))
	{
		mkdir("hostdj_pics/profile_pic/".  $_SESSION['user_id'] ."/");
	}
	if(!is_dir("hostdj_pics/gallery/". $_SESSION['user_id'] ."/"))
	{
		mkdir("hostdj_pics/gallery/".  $_SESSION['user_id'] ."/");
	} 			    
	
	$temp = $_FILES["forum_hodtdj_profile_img"]["tmp_name"];
	$path = "hostdj_pics/profile_pic/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_img"]["name"];
	$temp = $_FILES["forum_hodtdj_profile_img"]["name"];
	$temp1 = explode(".", $_FILES["forum_hodtdj_profile_img"]["name"]);
	$extension = end($temp1);
	$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$getname."_thumbnail.".$extension;
	$thumbnail = "hostdj_pics/profile_pic/".$_SESSION['user_id']."/".$thumb;

	move_uploaded_file($_FILES["forum_hodtdj_profile_img"]["tmp_name"],"hostdj_pics/profile_pic/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_img"]["name"]);
	$file = $path;
		
	//indicate the path and name for the new resized file
	$resizedFile = $thumbnail;
	
	$hostdj_profile_pic = $resizedFile;

	$resizeObj = new resize($file);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(300,200, 'auto');

	// *** 3) Save image ('image-name', 'quality [int]')
	$resizeObj -> saveImage($resizedFile, 100);									   

	$count = count($_FILES['forum_hodtdj_profile_images']['name']);
	for($a=0;$a<$count;$a++)
		{
			 $getname = $_FILES['forum_hodtdj_profile_images']['name'][$a];
			$getall .= $getname.",";
			move_uploaded_file($_FILES["forum_hodtdj_profile_images"]["tmp_name"][$a],
							"hostdj_pics/gallery/".$_SESSION['user_id']."/" . $_FILES["forum_hodtdj_profile_images"]["name"][$a]);
		}
		
	$getall;
	
	$file_type = $_FILES['add_post_video_distinct']['type'];
	$exp_file_type = explode('/', $file_type);
	$check_file_type = $exp_file_type[0];
	$video_name = "";
	
	if($check_file_type == "video" || $check_file_type == "application"){
		
		$forum_video=$_FILES['add_post_video_distinct']['name']; 
		$tmp = $_FILES["add_post_video_distinct"]["tmp_name"]; 
		$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
		move_uploaded_file($tmp,$video_name);
		
	}
	
	$des = mysql_real_escape_string($_POST['hodtdj_profile_description']);
	$nme = mysql_real_escape_string($_POST['hodtdj_profile_name']);
	$sql = @mysql_query("INSERT INTO `host_dj_profile` (`id`, `host_id`, `hostdj_name`, `hostdj_description`, `hostdj_profile_pic`, `hostdj_gallery_pic`, `enable`, `hostdj_video`) VALUES ('', '$host_id', '$nme', '$des', '$hostdj_profile_pic', '$getall', '1', '".$video_name."')");
	
	$Obj->Redirect("hostdj_profile.php");
	die;

	
}

  /******************/
?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('club-right-panel.php');?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						<h3 id="title">Edit Bio Profile</h3>
							<?php if($message['success'] != ""){ 

							echo '<div style="display:block;" id="successmessage" class="message" >'.$message['success']."</div>";
							}
							if($message['error'] != ""){ 

							echo '<div style="display:block;" id="errormessage" class="message" >'.$message['error']."</div>";
							} 

							?>
										
				<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
				<script>tinymce.init({
							selector:'.formw textarea',
							toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
							fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
							menubar: false
						});</script>
				<style type="text/css">
				.home_content_top button { background: none;}
				.hostdjinfo p span em strong {font-weight: bold;}
				.hostdjinfo p span em
				{
					font-style: italic;
				}


				</style>		
						<form method="POST" enctype="multipart/form-data" class="musicadd12" id="" action="">
							
						<!-- <div class="row"> 
							<span class="label">
								<label >Host Name:<b><font color='red'><em></em></font></b></label>
							</span>
							<span class="formw">
								
								<input type="text" name="hodtdj_profile_name" class="txt_box" value="<?php echo $_SESSION['username'];?>" required >
								
							</span>
						</div> -->
						<div id="middle">
						<div class="profile_djhost">
							<div class="hostdjinfo">
								<h4><?php echo $_SESSION['username'];?></h4>
								<span class="formw">
								<textarea name="hodtdj_profile_description" style="height:100px;"  class="txt_box" placeholder="Enter Description"/><?php echo $resulthostdjprofile['hostdj_description']; ?></textarea>
								</span>
							</div>
						</div>

						<div class="hostdjthumb">

							<a class="removeprofilepic">
							<img src="<?php echo $resulthostdjprofile['hostdj_profile_pic'];?>"/>
							</a>

						</div>

						</div>
						
						<!-- <div class="row"> 
							<span class="label"><label >Profile Image:<b>
								<font color='red'><em></em></font></b></label></span>
								<span class="formw">
									<input type="file" style="color: #fff; width: 100%;" name="forum_hodtdj_profile_img" class="txt_box" id="add_post_imgahd" onchange="return ValidateFileUploadahd()"/>
								<span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span>
							</span>
						
										
						
						</div> -->
						
						<!-- <div class="row">
						<span class="label">&nbsp;</span>
						<span class="formw"><?php if($_GET['edithostdj'] == 'edithostdj')
							{ ?>
							<a class="removeprofilepic"><span>Remove</span><img class="removeimg1" src="<?php echo $resulthostdjprofile['hostdj_profile_pic'];?>" width="50" height="50"/></a>
							<?php } ?>
		</span>
						</div> -->

						<div class="row"> 
							<span class="label"><label >Gallery Images:<b><font color='red'><em></em></font></b></label></span>
							<span class="formw">
								<input type="file" style="color: #fff; width:100%;" name="forum_hodtdj_profile_images[]" class="txt_box" id="add_post_videoahd" multiple onchange="return ValidateVideoUploadahd()"/> 
								<span class="text_allowed"> (Allowed exts's gif, png, jpg & jpeg)</span>
							</span>
						</div>
						
						<?php
						if($_GET['edithostdj'] == 'edithostdj')
						{
						$explodegallery =  explode("," , $resulthostdjprofile['hostdj_gallery_pic']);
						$gallercount = count($explodegallery);
						echo "<div class='vidoesgallery hostdj_pro'>";
						for($a=0;$a<$gallercount;$a++)
							{
								if(!empty($explodegallery[$a]))
								{
									?>
									<div class="gpic_host"><img class="removeimg" src="hostdj_pics/gallery/<?php echo $_SESSION['user_id']."/".$explodegallery[$a]; ?>" alt="" title="" /></div>
									<?php
								}
							}
							echo "</div>";
						
						}
						?>

															
						<?php
						$check_dj_video = mysql_query("SELECT default_bio, hostdj_video FROM host_dj_profile WHERE host_id  = '".$_SESSION['user_id']."'");
						$get_dj_video = mysql_fetch_assoc($check_dj_video);
						$dj_video_status = $get_dj_video['hostdj_video'];
						$dj_video_set = $get_dj_video['default_bio'];
						
						if(!empty($dj_video_status)){
							
							$dj_vid_class = "style='display: none;'";
							$dj_vid_class_inner = "style='display: block;'";
							
						}
						?>
									
						<div style="margin:0;" class="row" <?php echo $dj_vid_class; ?>> 
							<span class="label"><label >&nbsp;&nbsp;<b><font color='red'><em></em></font></b></label></span>
							<!-- <span class="formw">
								<div id="add_vid_btn" class="button btn">Add video to Bio</div>
							</span> -->
						</div>
						<?php if($_SESSION['user_type'] != "user" && !isset($_GET['host_id'])){ ?>
						<div class="storefunctionsetting">

							<h1 id="title">Settings</h1>
							<?php
							$getq = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'");

							$countrec = @mysql_num_rows($getq);

							if($countrec > 0)

							{

								$fetchstatus = @mysql_fetch_array($getq);

								$statuspage = $fetchstatus['bio'];

								$me = $fetchstatus['biomessage'];

								//die;

							}

							else

							{

								$statuspage = "Enable";

								$me= "";

							}
							?>
							<!-- <form method="POST" action="" name="storesettings" id="storesettingsform" >

								<div><input <?php if($statuspage == "Enable"){ echo "checked"; } ?> type="radio" name="function" value="Enable" />Enable your Bio for public viewing.</div>

								<div><input <?php if($statuspage == "Disable with message"){ echo "checked"; } ?> type="radio" name="function" value="Disable with message" id="disbleshow" />Bio not done yet? Leave a short message to inform the public.</div>

								

								<?php if($statuspage == "Disable with message"){ ?>

								

									<div id="disablemessage"><input  type="text" name="biomessage" value="<?php echo $me;?>" /></div>

								

								<?php }else{ ?>

								

									<div id="disablemessage" style="display: none;"><input  type="text" name="biomessage" value="<?php echo $me;?>" /></div>

								

								<?php } ?>

								
							</form> -->
						</div>	
						<?php } ?>
						
						<div class="row default_vid_outer" id="add_vid" <?php echo $dj_vid_class_inner; ?>> 
							<span class="label"><label >Add Video Here:<b><font color='red'><em></em></font></b></label></span>
							<span class="formw">
								<input type="file" style="color: #fff; width:100%;" name="add_post_video_distinct" class="txt_box" id="add_post_video_distinct" multiple onchange="return Validate_distinct_Upload()"/> 
								<span class="text_allowed"> (Allowed exts's mp4)</span>
								
								<video width="100%" controls onmouseout="this.pause()" onmouseover="this.play()">
								  <source src="<?php echo $resulthostdjprofile['hostdj_video']; ?>" type="video/mp4">
								</video>
								
							</span>
							
							<div class="row"> 
								<span class="label"><label >&nbsp;&nbsp;<b><font color='red'><em></em></font></b></label></span>
								<span class="formw">
									<input <?php if($dj_video_set == "video"){ echo "checked"; } ?> type="checkbox" name="default_bio_set" id="default_bio_set">Click here to Set video as Bio
								</span>
							</div>
						</div>
						
						<div class="btncenter" >
								
							<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" /> 
						
						</div>
						
						<ul class="btncenter_new add_profile" >
						<li>
							<?php
							if($_GET['edithostdj'] == 'edithostdj')
							{
								echo '<input type="submit" name="hostdj_profile_edit" value="Update" class="button addfrmbutton"  />';
								
							}else{
								
								echo '<input type="submit" name="hostdj_profile" value="Update" class="button addfrmbutton"  />';
							}
							?>
						</li>
								<li><?php if($_SESSION['user_type'] == "user"){ ?>				
								<a href="home_user.php" class="button">Cancel</a>		
								<?php }else{ ?>				
								<a href="hostdj_profile.php" class="button" style="float: right;">Cancel</a>				
								<?php } ?></li>
							</ul>
						</form>
					</div>
				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script language="javascript">
function ValidateFileUploadahd(){
		var check_image_ext = $('#add_post_imgahd').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Host Dj Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#add_post_imgahd').val('');
		}
}

function ValidateVideoUploadahd(){
		var check_image_ext = $('#add_post_videoahd').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Host Dj Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#add_post_videoahd').val('');
		}
}

function Validate_distinct_Upload(args) {
		var check_image_ext = $('#add_post_video_distinct').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['mp4']) == -1) {
			alert('Host Dj Video only allows file types of MP4');
			$('#add_post_video_distinct').val('');
		}
}
	
$(document).ready(function(){
	// $(".removeimgallery").click(function(){
	// 	if(confirm('Are you sure you want to delete this image?'))
	// 	{
	// 		//$(this).parent('div').hide();
	// 		var getimgsrc = $('img', $(this)).attr('src');
				
	// 		var splitsrc = getimgsrc.split('hostdj_pics/gallery/'+<?php echo $_SESSION['user_id']?>+'/');
			
	// 		var splitsrc = splitsrc[1];
	// 		$(this).remove();
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "hostdj_gallrey_ajax.php",
	// 			data: {
	// 			'splitsrc' : splitsrc            
	// 			},
	// 			success: function(data){
	// 			}
	// 		});
	// 	}
	// });
	
	
	
	$(".removeprofilepic").click(function(){
		if(confirm('Are you sure you want to delete this image?'))
		{
			var getimgsrc = $('img', $(this)).attr('src');
		
			var splitsrc = getimgsrc.split('hostdj_pics/profile_pic/'+<?php echo $_SESSION['user_id']?>+'/');
			var splitsrc = splitsrc[1];
			$(this).remove();
			$.ajax({
				type: "POST",
				url: "hostdj_gallrey_ajax.php",
				data: {
				'removeprofileimage' : splitsrc            
				},
				success: function(data){

				}
				});
		}
	});
	
	$("#add_vid_btn").click(function(){
	  $("#add_vid_btn").text(function(i, text){
		  return text === "Add video to Bio" ? "Cancel" : "Add video to Bio";
	  });

	$("#add_vid").toggle();
	});
	
	$("#default_bio_set").click(function(){
		
		if ($("#default_bio_set").is(":checked")) {
					$.post('add_hostdj_profile.php', {'video_set_action': 'set'}, function(response){
						if (response != "") {
							alert(response);
						}
						
			});
					
		}else{
					$.post('add_hostdj_profile.php', {'video_set_action': 'unset'}, function(response){
						if (response != "") {
							alert(response);
						}
			});
					
		}
			
	});
	
	});	
	

function cancelEdit(){
	window.location='hostdj_profile.php'
} 
</script>
<?php include('Footer.php');?>



