<?php


$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID))
{
	$Obj->Redirect("index.php");	
}
if($userType=='user'){
	$Obj->Redirect("index.php");
}
	
if(isset($_REQUEST['id']))
{
	$UserID=$_REQUEST['id'];
}
else 
{
	$UserID=$_SESSION['user_id'];	
}

$titleofpage = "Music Upload";


// $merchantID = $loggedin_host_data['merchant_id'];


if(isset($_POST['Loadmusic']))
{
		
	
	$trackname = mysql_real_escape_string(trim($_POST['trackname']));
	
	$checkquery = mysql_query("SELECT * FROM music WHERE trackname = '$trackname' ");
	if(mysql_numrows($checkquery) == 0)
	{
		
		$label = mysql_real_escape_string($_POST['label']);
		$price = mysql_real_escape_string($_POST['price']);
		$releasedate = mysql_real_escape_string($_POST['releasedate']);
		$artist = mysql_real_escape_string($_POST['artist']);
		$genre = mysql_real_escape_string($_POST['genre']);
		$hostid = mysql_real_escape_string($_POST['host_id']);
		
		$filename =$_FILES['file']['name']; 
		$temp_filename = $_FILES['file']['tmp_name']; 
		$filesize = $_FILES['file']['size']; 
		$mimetype = $_FILES['file']['type'];
		//$filename = htmlentities($filename); 
		$mimetype = $mimetype;
		
		if($mimetype != "audio/x-mp3" && $mimetype != "audio/mp3" && $mimetype != "audio/mpeg")
		{ 
			$error_msg[] = 'The file you are trying to upload does not contain expected data. 
			Are you sure that the file is an MP3 one?'; 
			$error_flag = true; 
		}
	
		if($filename == "")
		{ 
			$error_msg[] = 'No file selected!'; 
			$error_flag = true; 
		}
		$trackname1 = str_replace(' ', '_' , $trackname);
		$ext = substr(strrchr($filename, '.'), 1);
		$target_path = "upload/music/";
		$filename = $trackname1."-".$filename;
		$path = $target_path.$filename;
		$message = array();
			if(file_exists($path))
			{
				$message['error'] = " File already exists. File cannot be Uploaded !";
			}
			else
			{
				if($error_flag)
				{
					$message['error'] = 'The file you are trying to upload does not contain expected data. 
			Are you sure that the file is an MP3 one?'; 
				}
				else
				{
					 if(move_uploaded_file($temp_filename, $path))
					{
						//$message['success'] = "Your File Uploaded Successfully !";
						$sql = mysql_query("INSERT INTO `music` (`artist`,`trackname`,`price`,`label`,`genre`,`host_id`,`releasedate`,`tonightlist`,`musicpath`) VALUES ('$artist','$trackname','$price','$label','$genre','$hostid','$releasedate','','$path')");
	
						if($sql)
						{
							$message['success'] = "Your Music is loaded successfully.";
						}
					}
					else
					{
						$message['error'] = " File cannot be Uploaded !";
					}
				}
			   
			}
		
	}
	else
	{
		$message['error'] = " Track with trackname: ".$trackname." already exists. Please enter different trackname  !";
	}

}

if($_POST['Save'])
{
	
		
		$sql1 = mysql_query("SELECT * FROM music");
		while( $re = mysql_fetch_array($sql1))
		{
			$i = $re['id'];
			mysql_query("UPDATE music SET `tonightlist` = '0' WHERE id = '$i' ");
		}
	if(!empty($_POST['tonightlist']))
	{
		foreach($_POST['tonightlist'] as $post)
		{
			$sql = mysql_query("UPDATE music SET `tonightlist` = '1' WHERE id = '$post'");
		}
		
		
	}

	$message['success'] = "Tonight list is updated.";
}

$userID=$_SESSION['user_id'];

$myquery = mysql_query("SELECT * FROM music where host_id = '$userID' ORDER BY trackname ASC");


  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?> 
<div class="v2_inner_main_content">
  						<h3 id="title">Load Music</h3>
						<div class="parent-message-div">
							<?php
							
							if((isset($_POST['Loadmusic'])  ||  (isset($_POST['Save']) ) ) && ($message['success'] != ""))
							{
								echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
							}
							if((isset($_POST['Loadmusic'])) && ($message['error'] != ""))
							{
								echo '<div id="errormessage" class="message NoRecordsFound" >'.$message['error']."</div>";
							}
							?>

						</div>

						<form method="POST" action="" enctype="multipart/form-data" class="musicadd">


						   <div class="field_ss"> 
						   
						   <label >Track Name<b><font color='red'><em>*</em></font></b></label>
							<input id="TrackName"  type="text" name="trackname" required  value="<?php if($message['error'] != ""){ echo $_POST['trackname']; } ?>" /></div>
							
							<div class="field_ss"> <label>Artist<b><font color='red'><em>*</em></font></b></label>
							<input type="text"   name="artist" required value="<?php if($message['error'] != ""){ echo $_POST['artist']; } ?>"  /></div>
							
							<div class="field_ss"><label>Label</label>
							<input type="text" name="label"  value="<?php if($message['error'] != ""){ echo $_POST['label']; } ?>" /></div>
							<div class="field_ss"> <label>Genre</label>
							<input type="text" name="genre"  value="<?php if($message['error'] != ""){ echo $_POST['genre']; } ?>" /></div>
							
							
							<div class="field_ss"><label>Release Date</label>
							<input class="date"   type="text"  name="releasedate" value="<?php if($message['error'] != ""){ echo $_POST['releasedate']; } ?>" /></div>
							
							<div class="field_ss"> <label >Price<b><font color='red'><em>*</em></font></b> <span>$</span></label>
							<input id="MusicPrice" <?php if(empty($merchantID)){ ?> onclick='addmerchantID("Music")'; <?php } ?> type="number" min="0"   max="9999" step="0.01" name="price" value="<?php if($message['error'] != ""){ echo $_POST['price']; } ?>" required  title="Enter a valid number"/></div>
							
							<div class="field_ss"><label>Browse Music<b><font color='red'><em>*</em></font></b></label>
							<input type="file" onchange="return Validate_music_FileUpload()" id="music_upload" name="file" style="color:white;"  accept="audio/*,video/*,image/*" required class="brwse_btn" /><div class="clear"></div><p style=" margin-left:35%">(Allowed exts's mp3, wma, aac & wav)</p></div>
							
							 <div class="field_ss"><input type="hidden"  name="host_id" value="<?php echo $_SESSION['user_id'];?>" /></div>
							
						   <div class="field_out"><input type="submit" name="Loadmusic" class="button btn_ss" value="Load" /></div>
							
						</form>
						<?php 
						$count1 = mysql_num_rows($myquery);
						$class="";
						if($count1 > 9)
						{
							$class=" class='autoscroll'";
						}
						else
						{
							$class=" class='autoscroll'";
						}
						?>
						<form method="POST" action="" >
						  <div <?php echo $class; ?>>
							<table class='display loadmusic' id='example' style='margin-top:10px;' >
								<thead>
								<tr bgcolor='#ACD6FE'>
									<th>Track Name</th>
									<th>Artist</th>
									<th>Label</th>
									<th>Genre</th>
									<th>Release Date</th>
									<th>Price</th>
									<th>Tonight List</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								<?php $i=1;
								$count = mysql_num_rows($myquery);
								if($count != 0){
										while($res = mysql_fetch_array($myquery))
										{
										
											if($i%2 == '0')
								{
									$class = " class='even' ";
								}
								else
								{
									$class = " class='odd' ";
								}
											?>
											<tr <?php echo $class;?>>
												<td>
													<?php echo $res['trackname']; ?>
												</td>
												<td>
													<?php echo $res['artist']; ?>
												</td>
												<td>
													<?php echo $res['label']; ?>
												</td>
												<td>
													<?php echo $res['genre']; ?>
												</td>
												<td>
													<?php 
														if(($res['releasedate'] != "0000-00-00") && ($res['releasedate'] != ""))
														{
															$date =  $res['releasedate'];
										$d = strtotime($date); 
										echo date('M d, Y',$d);
									}
													?>
												</td>
												<td>
													<?php echo "$".$res['price']; ?>
												</td>
												<td>
													<input <?php if($res['tonightlist'] == '1'){ echo "checked"; } ?> type="checkbox" name="tonightlist[]" onclick="enableclass();" value="<?php echo $res['id'];?>" />
												</td>
												<td>
													<a href="#focusonclick" class="deletemusicrecord" id="<?php echo $res['id'];?>"><img src="images/del.png" width="25px" title="Delete" height="25px"></a>
												</td>
											</tr>
											
											<?php
											$i++;
										}
								
								}
								else
								{
									?>
									<tr class="odd">
												<td colspan="8">
													No Music records yet !
												</td>
									</tr>
								<?php 	
									
								}
								?>
								</tbody>
							</table>
							</div>
							<?php 
							 if($count != 0){ ?>
							 <div class="field_out"><input id="Savetonightlist" type="submit" disabled="disabled" class="button btn_ss" name="Save" value="Save" /></div>
							<?php  }  ?>
						</form>
  					</div>

 <script language="javascript">
function Validate_music_FileUpload(){
	var check_image_ext = $('#music_upload').val().split('.').pop().toLowerCase();
	if($.inArray(check_image_ext, ['mp3','wma','aac','wav']) == -1) {
		alert('Post Image only allows file types of MP3, WMA, AAC and WAV');
		$('#music_upload').val('');
	}
}
	
function enableclass(){
	document.getElementById("Savetonightlist").removeAttribute("disabled"); 
}
	
	
function playvideo(id)
{
jwplayer('a'+id).stop();
$('#ve_'+id).click();
 
}
function  deletevideo(id)
{
var r=confirm("Are you sure you want delete this video");
if (r==true)
  {
	$.get('delete-video.php?video_id='+id, function(data) {
	 window.location='home_club.php';
	});
  }

 }
 
 function deletephoto(id)
 {
   var r=confirm("Are you sure you want delete this Photo");
if (r==true)
  {
	$.get('delete-video.php?type=img&image_id='+id, function(data)
	{
	 window.location='home_club.php';
	});
  }
 
 }

$(document).ready(function(){

	$('.deletemusicrecord').on('click',function(){
		var r=confirm("Are you sure you want delete this record?");
		if (r==true)
		  {
			var id = $(this).attr('id');
			$.ajax({

				type: 'POST',
			url: 'deletemusicajax.php',
			data: {
				'id': id,
				'action': 'deletemusic',
			},
			success: function(data) {
				$('.parent-message-div').html(data);
				setTimeout(function() {
					  // Do something after 5 seconds
					  window.location.href = "";
				}, 5000);

				
			}

			});
		  }
		
	});


});


</script>