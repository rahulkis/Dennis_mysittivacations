<?php

$Obj = new Query($DBName);
error_reporting(0);
$titleofpage="Streaming Videos";
if(!isset($_SESSION['user_id']))
{
	header('Location: index.php');
}


if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')
{
	$club_name=$loggedin_host_data['club_name']; 
	$zipcode=$loggedin_host_data['zip_code'];
	$state=$loggedin_host_data['club_state'];
	$city=$loggedin_host_data['club_city'];
	$country=$loggedin_host_data['club_country'];     
	$email=$loggedin_host_data['club_email'];
	$image_nm=$loggedin_host_data['image_nm'];
	$phone=$loggedin_host_data['club_contact_no'];
	
	if($loggedin_host_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_host_data['DOB'];
	
	/* ends here */ 
}

$userID = $_SESSION['user_id'];
$userType= $_SESSION['user_type'];

$clubNAme= explode(" ", $club_name);
$username_dash_separated = implode("-", $clubNAme);
$username_dash_separated = clean($username_dash_separated);


if(isset($_GET['deletefile']))
{
	$file = $_GET['deletefile'];
	$filedownload = unlink($file);

	$explode = explode("/home/mysitti/public_html/", $file);
	mysql_query("DELETE FROM `saved_streaming` WHERE `video_path` = '$explode[1]' AND `host_id` = '$userID'  ");

}



$dir    = $_SERVER['DOCUMENT_ROOT'].'/savedStreaming/'.$username_dash_separated;
$files1 = array_diff(scandir($dir), array('..', '.'));

$getStreamvideo = mysql_query("SELECT * FROM `saved_streaming` WHERE `host_id` = '$userID' AND `user_type` = '$userType' AND `active` = '1' ");
while($fetchStreamVideo = mysql_fetch_assoc($getStreamvideo))
{
	$videosArray[] = mysql_real_escape_string($fetchStreamVideo['video_path']);
}



// echo "<pre>"; print_r($videosArray); exit;

?>
<div class="clear"></div>
					<div class="v2_inner_main_content">
  						<h3 id="title" class="title_streaming">Streaming Videos</h3>
						<div id="profile_box" class="upload_photo_main">
			<?php 
					if($_GET['msg'] == "uploaded")
					{

						echo '<div id="successmessage" style="display: block;">Video Uploaded Successfully</div> ';
					}
					elseif ($_GET['msg'] == "imagefail") 
					{
						# code...
						echo '<div class="NoRecordsFound" id="errormessage" style="display: block;">Video failed to upload!</div> ';
					}
					elseif ($_GET['msg'] == "deleted") 
					{
						# code...
						echo '<div id="successmessage" style="display: block;">Streaming Video is not visible to User</div>';
					}
					elseif ($_GET['msg'] == "added") 
					{
						# code...
						echo '<div id="successmessage" style="display: block;">Streaming Video is visible to User</div>';
					}
	?>
		 
							<div class="uploadphotos upstream"> 
								<div class="photos_row stream_vid_wrapper">
								<?php
								$i=1;
								//echo "<pre>"; print_r($files1); exit;
								foreach($files1 as $file)
								{
									$temp = explode(".", $file);
									$extension = end($temp);
									if($extension == "mp4")
									{
								?>
							 		<div class="video_ss video_stream">
							 			<video  loop="" controls="true" style="float:left; width:100%;" id="">
											<source type="video/mp4" src="savedStreaming/<?php echo $username_dash_separated."/".$file;?>" id="mp4Source"></source>
										</video><div class="clear"></div>
										<div id="sendCheckbox" class="shsre_stream">
	                                    							<input <?php if(in_array('savedStreaming/'.$username_dash_separated."/".$file, $videosArray )){ echo "checked"; } ?> onclick="savetodatabase(this.id);" type="checkbox" name="sendtovideo" id="a_<?php echo $i; ?>" class="savedStreaming/<?php echo $username_dash_separated."/".$file;?>" /><span id="sendtoVideo">Share with Users</span>
	                               								<div class="down_del"> 
	                               									<a class="del_stream_vid" title="Delete" href="?deletefile=<?php echo $_SERVER['DOCUMENT_ROOT'].'savedStreaming/'.$username_dash_separated."/".$file; ?>"> </a> 
	                               									<a title="Download" class="download_stream_vid" href="downloadvideo.php?downloadfile=<?php echo 'savedStreaming/'.$username_dash_separated."/".$file; ?>"> </a>
	                               								</div>
	                                    						</div>
									</div>
							<?php 		}
									$i++;
								}	
							?>
								</div>
							</div>
	                       
		  					<div class="back_stream">
		  						<?php 
		  							if($_SESSION['user_type'] == "club")
		  							{
		  								echo '<a href="home_club.php" class="button backmargn">Back </a>';
		  							}
		  							else
		  							{
		  								echo '<a href="profile.php" class="button backmargn">Back </a>';
		  							}
		  						?>
								
							</div>
						</div>
  					</div>
  			<div class="equalizer"></div>
	
<script type="text/javascript">
function savetodatabase(id)
{
	var path = $("input#"+id).attr('class');
	if($("input#"+id).prop("checked") == true)
	{
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'host_id' : '<?php echo $userID; ?>',
				'path' : path,
				'action' : 'addStreamVideo',
			},
			success: function(data){
				window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?msg=added';

			}
		});
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'host_id' : '<?php echo $userID; ?>',
				'path' : path,
				'action' : 'deleteStreamVideo',
			},
			success: function(data){
				window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?msg=deleted';

			}
		});
	}
}
</script>