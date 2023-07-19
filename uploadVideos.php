<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

 

$titleofpage="Upload Videos";
include('LoginHeader.php');

if(isset($_POST['default_host_video_id'])){
	
	$def_vid = mysql_query("SELECT * FROM battle_playlist WHERE user_type = '$_SESSION[user_type]' AND user_id = '".$_SESSION['user_id']."'");
	
	while($vid_row = mysql_fetch_assoc($def_vid)){
		
		if($vid_row['id'] == $_POST['default_host_video_id']){
			
			mysql_query("UPDATE battle_playlist SET default_video = '1' WHERE id = '".$vid_row['id']."'");
			
		}else{
		
			mysql_query("UPDATE battle_playlist SET default_video = '0' WHERE id = '".$vid_row['id']."'");	
			
		}
		
	}
	
	//echo "Default Video Set Successfully";
	//die;
}

$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="imagefail")
	{
		$message="Invalid Image.";
	}
	
}

if(isset($_GET['delete_video']))
{
	$ids = $_GET['delete_video'];
	$del = mysql_query("delete from battle_playlist where id = '".$ids."'");
	if($del)
	{
		unlink($_GET['del_path']);
		$_SESSION['vid_del'] = "Video Deleted Successfully";
		header('Location: uploadVideos.php');
		die;
	}
}
?>

<script>
function ValidateVideoUploadnew(){
	var check_image_ext = $('#computer_file').val().split('.').pop().toLowerCase();
	
	if($.inArray(check_image_ext, ['mp4']) == -1) {
		alert('Video only allows file type of MP4');
		$('#computer_file').val('');
	}
}

function validate_video() {
	if ($('#video_title').val() == "") {
		return false;
	}
	
	if ($('#computer_file').val() == "" && $('#video_file').val() == "") {
		return false;
	}
	if(document.getElementById('computer_file').value== "")
 	{
		if(document.getElementById('video_file').value=="" )
		 {
			alert( "Please provide video!" );
			document.getElementById('video_file').focus() ;
			return false;   
		}
	}

	if(document.getElementById('computer_file').value!= "")
 	{
		if(document.getElementById('video_file').value!="" )
		 {
			alert( "Please provide only 1 source!" );
			$('#video_file').val('');
			$('#computer_file').val('')
			document.getElementById('video_file').focus() ;
			return false;   
		}
	}


	if(($('#computer_file').val() != '' || $('#video_file').val() != '' ) && $('#video_title').val() != '')
	{
		$.blockUI({ css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#fecd07',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .8,
			color: '#000'
		},
		message: '<h1>Uploading Video</h1>'
		});
	}	
}

function confirmDelete(delUrl) {
  	if (confirm("Are you sure you want to delete?")) 
  	{
   		document.location = delUrl;
  	}
}

function default_video_Set(id) {
	$.blockUI({ css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#fecd07',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .8,
			color: '#000'
		},
		message: '<h1>Setting as Default Video..</h1>'
	});
	$.post('uploadVideos.php', {'default_host_video_id':id}, function(response){
		$.unblockUI({
			onUnblock: function(){
				alert('Default Video Set Successfully');
			}
		});
		
	});
}


function remove_lower_file(){
	
	$("#computer_file").val("");
	
}
	
function remove_upper_file(){
	
	$("#video_file").val("");
	
}   

</script>
<?php

if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')
{

	$first_name=$loggedin_host_data['club_name']; 
	$zipcode=$loggedin_host_data['zip_code'];
	$state=$loggedin_host_data['club_state'];
	$city=$loggedin_host_data['club_city'];
	$country=$loggedin_host_data['club_country'];     
	$email=$loggedin_host_data['club_email'];
	$image_nm=$loggedin_host_data['image_nm'];
	$phone=$loggedin_host_data['club_contact_no'];
	
	if($loggedin_host_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_host_data['DOB'];
}
else
{
 
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
}

 /******************/

if(isset($_POST['submitVideo']))
{
	//echo "<pre>"; print_r($_POST); print_r($_FILES); exit;
	$imageTitle = $_POST['video_title'];
	if($_POST['video_file']!="") 
	{
		$video_nm= $_POST['video_file'];
		$ValueArray = array($imageTitle,$_SESSION['user_id'],$_SESSION['user_type'],$video_nm);
		$FieldArray = array('video_title','user_id','user_type', 'video_path');
		$ThisPageTable="battle_playlist"; 
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);  
	 }  
	 
	if($_FILES["file"]["name"]!="")
	{
		if ($_FILES["file"]["error"] > 0)
	 	{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; Exit;
	 	}
	 	else
	 	{
			
			$u_video = $_FILES["file"]["name"]; 
			$tmp = $_FILES["file"]["tmp_name"]; 
			$v_name = "video/".time().strtotime(date("Y-m-d")).$u_video; 
			move_uploaded_file($tmp,$v_name);
		
			$ValueArray = array($imageTitle,$_SESSION['user_id'],$_SESSION['user_type'],$v_name);
			$FieldArray = array('video_title','user_id','user_type', 'video_path');
			$ThisPageTable = "battle_playlist"; 
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);  
			
		}
	}

	if($Success)
	{
		if(isset($_SESSION['user_club']) && $_SESSION['user_club'] == 'Club')
		{
			$Obj->Redirect("uploadVideos.php?msg=uploaded");
			die;
	 	}
	 	else
		{
			$Obj->Redirect("uploadVideos.php?msg=uploaded");
			die;
		}
	 }
}
/* ends here */ 

?>

<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		if($_SESSION['user_type']=='user')
		{ 
			if(isset($_GET['host_id']))
			{
				include('host_left_panel.php');
			}
			else
			{
				include('friend-right-panel.php');
			} 
		}
		else
		{
			if(isset($_GET['host_id']))
			{
				include('host_left_panel.php');
			}
			else
			{
				include('club-right-panel.php') ;
			}
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Videos</h3>
  						<div id="profile_box" class="upload_photo_main">
  						<?php 
							if($_GET['msg'] == "uploaded")
							{
								echo '<div id="successmessage" style="display: block;">Video Uploaded Successfully</div> ';
							}
							elseif ($_GET['msg'] == "imagefail") 
							{
								# code...
								echo '<div id="errormessage" style="display: block;">Video failed to upload!</div> ';
							}
							elseif ($_GET['msg'] == "deleted") 
							{
								# code...
								echo '<div id="successmessage" style="display: block;">Video deleted successfully</div>';
							}
							if(isset($_SESSION['vid_del']))
							{
								echo '<div id="successmessage" style="display: block;">'.$_SESSION['vid_del'].'</div>';
								unset($_SESSION['vid_del']);
							}		
							if(isset($_REQUEST['id']))
							{
								$userID=$_REQUEST['id'];
							}
							else
							{
								$userID = $_SESSION['user_id'];
							}

							if(isset($_GET['host_id']))
							{
								$swl= "SELECT * FROM `battle_playlist` WHERE `user_id` = '".$_GET['host_id']."' and user_type='club'";
							}
							else
							{
								$swl= "SELECT * FROM `battle_playlist` WHERE `user_id` = '".$userID."' and user_type='".$_SESSION['user_type']."'";
							}

							$sql_video = mysql_query( $swl);
  							$img_count= mysql_num_rows($sql_video);

  							if(isset($_SESSION['success']))
							{
								echo '<div id="successmessage" class="message" >'.$_SESSION['success'].'</div>';
		 						unset($_SESSION['success']);
		 					}

						?>
							<form name = "photos" id = "photos" method = "POST" onsubmit="return validateForm()">
								<div style=" border: 1px solid yellow;display:none; color: white;float: left;font-size: 18px;margin-top: 11px;padding: 10px;text-align: center;width: 97%;" id="error">
									
								</div>
								<div class="uploadphotos"> 
									<div class="photos_row">
										<div class="photodata_2 v2_uload_videos autoscroll">
											<table id="example1" class="display">
												<thead>
													<tr style="background-color:rgb(254, 205, 7);">
														<th>Video Title</th>
														<th>Set As Default</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
												<?php  
													while($video_row = mysql_fetch_array($sql_video))
													{
												?>		<tr>
															<td><?php if($video_row['video_title'] != ""){ echo $video_row['video_title']; }else{ echo  "&nbsp;"; } ?></td>
															<td><input <?php if($video_row['default_video'] == 1){ echo "checked"; } ?> onclick="default_video_Set('<?php echo $video_row['id']; ?>');" type="radio" name="set_default_vid" value="1"></td>
															<td><a href="javascript:confirmDelete('uploadVideos.php?delete_video=<?php echo $video_row['id']; ?>&del_path=<?php echo $video_row['video_path']; ?>')"><img height="20px" alt="Delete" src="../images/delete.jpg"></a></td>
														</tr>
				  								<?php 	} 	?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</form>
							<form method="POST" action="" name="upvideo" id="upvideo" enctype="multipart/form-data" onsubmit="return validate_video();">
							 	<?php 
							 		if(isset($_SESSION['error_msg']))
						 			{ 
						 				echo '<div style="color:#F00" align="center">'.$_SESSION['error_msg'].'</div>';
									 	unset($_SESSION['error_msg']);
									} 
								?>
								<div class="row">
									<span class="label" style="font-size:16px;font-weight:bold">Video Title:</span>
									<span class="formw"><input type="text" id="video_title" name="video_title" required />
									</span>
								</div>
								 <div class="row">
									<span class="label" style="font-size:16px;font-weight:bold">Upload Video:</span>
									<span class="formw"><input type="text" id="video_file" name="video_file" multiple onclick="remove_lower_file();">
										<p style="margin-bottom:0">Paste video link here Example<br />
										: http://www.youtube.com/watch?v=a7SJF3ErXZU <br />
										</p>

									</span>
							 	</div>
							 	<label class="seprator" style="margin-top:0"><div><span>OR</span></div></label>

								<div class="row">
									<span class="label" style="font-size:16px;font-weight:bold">Upload From Computer :</span>
									<span class="formw"><input style="color:#FFF;" type="file"  name="file" id="computer_file" onchange="return ValidateVideoUploadnew();" />
										<p>Upload Only : .mp4 file extension</p>
									</span>
								</div>

								<ul class="btncenter_new btn_upvid">
									<li><input style="float:left; margin:0px !important;" name="submitVideo" type="submit" class="button btn_add_venu" value="Upload" /></li>
									<?php
									if($_SESSION['user_type'] == 'user'){ ?>
									
										<li><a class="button" href="profile.php">Back</a></li>
									
									<?php }
									if($_SESSION['user_type'] == 'club'){ ?>
									
										<li><a class="button" href="home_club.php">Back</a></li>
									
									<?php }
									?>
									
								</ul>
							</form>
  						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php') ?>