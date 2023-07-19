<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

//include("CheckLogIn_con.Inc.php");
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

if(isset($_POST['delete_video']))
{
	foreach($_POST['delete_video'] as $r)
	{
		$getAlldetails = mysql_query("SELECT * FROM `sponsors` WHERE `id` = '$r'  ");
		$FetchDeatils = mysql_fetch_assoc($getAlldetails);
		unlink($FetchDeatils['video']);
		unlink($FetchDeatils['image_nm']);
		unlink($FetchDeatils['image_thumb']);
	}
	
	$ids=implode(",",$_POST['delete_video']); 
	$del=mysql_query("delete from sponsors where ID IN(".$ids.")");
	if($del)
	{
		$_SESSION['sponsor_deleted'] = "deleted";
	}
}

if($_SESSION['hostType'] == '109'){
	
	$titleofpage=" Networking Corner";	
}else{

	$titleofpage=" Sponsor";
}		

if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	if(isset($_GET['host_id']))
	{
		include('NewHeadeHost.php');
	}
	else
	{
		include('NewHeadeHost.php');	
	}
}
?>
<script>
function ValidateVideoUploadnew()
{
	var check_image_ext = $('#computer_file').val().split('.').pop().toLowerCase();
	
	if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
		alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
		$('#computer_file').val('');
	}
}
	
function validate_video()
{
	
	if(document.getElementById('computer_file').value== "")
  	{
		if(document.getElementById('video_file').value=="" )
		 {
			alert( "Please provide video!" );
			document.getElementById('video_file').focus() ;
			return false;   
		}
	}
}
function makelike(action,video_id,who_like_id)
{
 	$.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {
		$('#vid_'+video_id).html(data);
	});
}
</script>
<?php
if(isset($_POST['submit']))
{   
	$sponsor_title = mysql_real_escape_string($_POST['sponsor_title']);
	$sponsor_link = mysql_real_escape_string($_POST['sponsor_link']);
	$added_on = date("Y-m-d H:i:s");
	
	$file_type = $_FILES['sponsor_img']['type'];
	$exp_file_type = explode('/', $file_type);
	$check_file_type = $exp_file_type[0];
	
	if($check_file_type == "video" || $check_file_type == "application"){
		
		$forum_video=$_FILES['sponsor_img']['name']; 
		$tmp = $_FILES["sponsor_img"]["tmp_name"]; 
		$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
		move_uploaded_file($tmp,$video_name);
		
	}elseif($check_file_type == "image"){
		
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["sponsor_img"]["name"]);
		$extension = end($temp);
		$name = $_FILES["sponsor_img"]["name"];
		$ext =substr($name,strrpos($name,'.'));
		$tmp1 = $_FILES["sponsor_img"]["tmp_name"];
		$path = "upload/forum_".time().strtotime(date("Y-m-d")).$name;
		$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
		$thumbnail = "upload/".$thumb;
		move_uploaded_file($tmp1,$path);
		
		
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
			$resizeObj -> resizeImage(300, 200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);
			
		
	}	
	
	$ValueArray = array($_SESSION['user_id'],$sponsor_title, $sponsor_link, $video_name, $file, $resizedFile, $added_on);
	$FieldArray = array('user_id','title', 'link', 'video', 'image_nm', 'image_thumb', 'added_on');
	$ThisPageTable = "sponsors"; 
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray); 	
	if($Success)
	{
		$_SESSION['sponsor_added'] = "success";
	}
}
?>


<script>
function remove_lower_file()
{
	jQuery("#computer_file").val("");
}
	
function remove_upper_file()
{
	jQuery("#video_file").val("");
}   
	
function postprivacy(type,img_id,user_id)
{
	if(type=="public")
	{		
		val=0;
		$('#posttype').addClass('public');
	}
	else
	{	
		val=1;
		$('#posttype').addClass('private');
	}
	$('#modal112').css('display','block');
	$('#lean_overlay').css('display','block');
	$('#posttype').val(img_id);
}
function hostposttoforum(posttype,img_id)
{
	$('#modal112').css('display','block');
	$('#posttype').val(img_id);
	$('#posttype').addClass('public');  
}
$(document).ready(function() {  
 	$('#deletephoto').click(function() {
	  
		if ($('.others').is(':checked')) 
		{
			var confm = confirm("Are you sure want to delete ?");
			if(confm == true)
			{
				$('#photos').submit();
			}
		}else
		{
			alert("Please select atleast one record!");
		}
	}); 
	$('.modal_close').on('click',function(){

		$('#posttype').val('');
		$('#posttype').removeClass('private');
		$('#posttype').removeClass('public');
		$('#modal112').css('display','none');
		$('#lean_overlay').css('display','none');
	});

	//select all the a tag with name equal to modal

});


function changeTitle(imgid)
{
	var iD = imgid.split('_');
	iD = iD[1];
	var textValue = $('#image_'+iD).text();
	textValue = $.trim(textValue);
	$('#image_'+iD).html('<input type="text" placeholder="Enter Title Here" onkeypress="updateTitle(event,this.id);" class="textField" id="textField_'+iD+'" style="width:100%;" value="'+textValue+'" />');
	$('#image_'+iD).removeAttr('onclick');
	$('#textField_'+iD).focus();
}

function updateTitle(event,imgid)
{
	var iD = imgid.split('_');
	iD = iD[1];
	var keycode = event.which || event.keyCode;
	//alert(keycode);
	var updateText = $('#textField_'+iD).val();
	if(keycode == 13)
	{
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: "imgId="+iD+"&title="+updateText+'&action=changeTitle',
			success: function(result){
				$('#image_'+iD).html(result);
				$('#image_'+iD).attr('onclick', 'changeTitle("'+imgid+'")');
			}
		});
		event.preventDefault();
	}
}



</script>

<style>
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
	z-index:9000;
	height: 400px;
	width: 600px;
}  

form#photos table
{
	background: none repeat scroll 0 0 transparent;
}

#lean_overlay{
  opacity: 0.60 !important;
}
.addorremove{
  float: left;
	height: auto;
   
	min-height: 138px;
	min-width: 169px;
	width: auto;
}
.addorremovebutton{
   float: left;
	height: 100%;
	margin-right: 8px;
	width: 24%
}
.uploadbuttons {
float: right;
width: 40%;
margin: 10px 0;
}
.modalwindow{
 bottom: 0;
	display: block;
	height: 260px;
	left: 0 !important;
	margin: auto;
	max-width: 498px;
	padding: 0 4%;
	position: fixed;
	right: 0;
	top: 0;
	width: 92%;
	z-index: 33333;
}
.title-inner-window {
  border-bottom: 1px solid #808080;
  color: #FECD07;
  font-size: 21px;
  padding: 20px 0;
 
  cursor:pointer;   
}

#u_0_s {
	float: left !important;
}

.check_del {
	padding-bottom: 10px;
	width: 100%;
}


</style>
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
  						<h3 id="title">
							<?php
							if($_SESSION['hostType'] == '109'){
								
								echo "Networking Cornor";	
							}else{
							
								echo "Sponsor";
							}	
							?>
						</h3>
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
						if(isset($_SESSION['sponsor_added']))
						{							
							echo '<div id="successmessage" style="display: block;">Sponsor added successfully</div>';
							unset($_SESSION['sponsor_added']);
						}
						if(isset($_SESSION['sponsor_deleted']))
						{
							echo '<div id="successmessage" style="display: block;">Sponsor deleted successfully</div>';
							unset($_SESSION['sponsor_deleted']);
						}			
						if(isset($_REQUEST['host_id']))
						{
							$userID=$_REQUEST['host_id'];
						}
						else
						{
							$userID = $_SESSION['user_id'];
						}
						$swl= "SELECT * FROM `sponsors` WHERE `user_id` = '$userID' ORDER BY added_on DESC";
					  	$sql_video = mysql_query( $swl);
					  	$img_count= mysql_num_rows($sql_video);
						if(isset($_SESSION['success']))
						{ 
							echo '<div id="successmessage" class="message" >'.$_SESSION['success'].'</div>';
							unset($_SESSION['success']);
					 	}
					 	if(!isset($_GET['host_id']))
					 	{
							if($img_count > 0)
							{
				?>				 <input type="button" class="button"  id="deletephoto" value="Delete" style="margin-left:15px;">
			 	<? 			}
			 			} 
			 	?>
					  		<form name="photos" id="photos" method="post">
								<div style=" border: 1px solid yellow;display:none; color: white;float: left;font-size: 18px;margin-top: 11px;padding: 10px;text-align: center;width: 97%;" id="error">
									
								</div>
								<div class="uploadphotos"> 
									<div class="photos_row sponsors">
					<?php
									if($img_count==0)
									{
										echo "<div>No Records Found</div>";   
						  			}
									$i=0;
					?>
										<div class="photodata_2">
					<?php      
										while($video_row = mysql_fetch_array($sql_video))
										{ 
					?>
											<div class="video_ss">
										<?php 
											if(!isset($_GET['host_id']))
											{ 
										?>
												<div class="check_del">
													<input class="others" type="checkbox" value="<?php echo $video_row['id']; ?>" name="delete_video[]">
												</div>
										<?php } ?>
												<div style="clear:both;"></div>
									<?php
											if(empty($video_row['video']))
											{ 
												if(empty($video_row['link']))
												{
										?>			<a rel="group" class="fancybox" href="<?php echo $video_row['image_nm']; ?>" style="margin-bottom:5px;">
										<?php 		}
												else
												{
										?>			<a target="_blank" href="<?php echo $video_row['link']; ?>" style="margin-bottom:5px;">
										<?php		}
										?>
												<img  src="<?php echo $video_row['image_thumb']; ?>">
												
												</a>
								<?php 			}
											else
											{
								?>				
													<div id="a<?php echo $video_row['id']; ?>_wrapper">
													</div>
													<script type="text/javascript">
														jwplayer("a<?php echo $video_row['id']; ?>_wrapper").setup({
															file: "<?php echo $video_row['video']; ?>",
															height : 200 ,
															width: "100%"
														});
													</script>
												
								<?php 			} 	?>
												<span id="image_<?php echo $video_row['id']; ?>" style="color: #FFF; cursor:pointer; text-align: center;" class="imageTitle publicprivarecheck" onclick="changeTitle(this.id);">
												&nbsp;</span>							
												<p style="color: #fecd07;">
													<?php echo $video_row['title']; ?>
												</p>

											</div><!-- END #video_ss -->
							<?php 			} // ENDWHILE	 ?>
										</div><!-- END photodata_2 -->
									</div>
								</div>
							</form>
						 <?php 
						 	if(isset($_GET['host_id']))
					 		{ 
					 	?>		<div class="backsponsors">
									<a href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a>
								</div>
					<?php 		} 	
						 	if(!isset($_GET['host_id']))
						 	{
					?>			<form method="post" name="upvideo" id="up_sponsor_video" enctype="multipart/form-data"> 
						 		<?php 
						 			if(isset($_SESSION['error_msg']))
					 				{
					 					echo '<div style="color:#F00" align="center">'.$_SESSION['error_msg'].'</div>';
							 			unset($_SESSION['error_msg']);
							 		} 
							 	?>
							 
									<div class="row">
										<span class="label" style="font-size:16px;font-weight:bold">Title:</span>
										<span class="formw"><input type="text" id="sponsor_title" name="sponsor_title" required />
										</span>
									</div>
									<div class="row">
										<span class="label" style="font-size:16px;font-weight:bold">Link:</span>
										<span class="formw"><input type="text" id="sponsor_link" name="sponsor_link" />
										</span>
									</div>
									<div class="row">
										<span class="label" style="font-size:16px;font-weight:bold">Add Media :</span>
										<span class="formw" id="Filetype">
											<div id="u_0_s" class="_6a _m">
												<a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb">
													<span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
														<img src="images/upload_camera.png">
														</i>Add Photo/Video<i class="_2wr"></i>
													</span>
													<div class="_3jk">
														<input type="file" aria-label="Upload Photos/Video" name="sponsor_img" required title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()">
														<span style="display: none;" id="file_upload_successs"><img src="images/tick_green_small.png"></span>
													</div>
												</a>
											</div>
										</span>
									</div>
									<div class="clear"></div>
									<div class="row">
										<span class="label" style="font-size:16px;font-weight:bold">&nbsp;</span>
									   	<input name="submit" type="submit" class="button btn_add_venu fleft_sub" value="Submit" /> 
									</div>
								</form>
						<?php 	} ?> 
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
	function ValidateFileUpload()
	{
		var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
			alert('Sponsor Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
			$('#js_0').val('');
			$('#file_upload_successs').hide();
		}else{
			$('#file_upload_successs').show();
		}
	}
  </script>


 <?php include('LandingPageFooter.php') ?>
