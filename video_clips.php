<?php
include 'googleplus-config.php';
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){
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

$titleofpage="DJ Videos";


if(isset($_POST['Loadmusic']))
{
	
    $trackname = mysql_real_escape_string(trim($_POST['trackname']));

    
	$checkquery = mysql_query("SELECT * FROM dj_video WHERE trackname = '$trackname' ");
	if(mysql_numrows($checkquery) == 0)
	{
	//	echo "<pre>"; print_r($_POST); print_r($_FILES); die('dfdfdf');
		
		$label = mysql_real_escape_string($_POST['label']);
		$price = $_POST['price'];
		$releasedate = $_POST['releasedate'];
		$artist = mysql_real_escape_string($_POST['artist']);
		$genre = mysql_real_escape_string($_POST['genre']);
		$hostid = $_POST['host_id'];
		$director = mysql_real_escape_string($_POST['director']);
		$filename = mysql_real_escape_string($_FILES['file']['name']); 
		$temp_filename = mysql_real_escape_string($_FILES['file']['tmp_name']); 
		$filesize = mysql_real_escape_string($_FILES['file']['size']); 
		$mimetype = mysql_real_escape_string($_FILES['file']['type']);
		$filename = htmlentities($filename); 
		$mimetype = htmlentities($mimetype);
		
		if($mimetype != "video/quicktime" && $mimetype != "video/mov" && $mimetype != "video/avi" && $mimetype != "video/mp4" && $mimetype != "video/m4v" && $mimetype != "video/webm" && $mimetype != "video/flv" && $mimetype != "video/f4v")
		{
			//die('dfsdfsdfsdf');
			$error_msg[] = 'The file you are trying to upload does not contain expected data. 
			Are you sure that the file is an video one?'; 
			$error_flag = true; 
		}
	
		if($filename == "")
		{ 
			$error_msg[] = 'No file selected!'; 
			$error_flag = true; 
		}
		
		//die('dfdfdfdss11');
		$trackname1 = str_replace(' ', '_' , $trackname);
		$ext = substr(strrchr($filename, '.'), 1);
		$target_path = "upload/dj_video/";
		$filename = clean($trackname1)."-".$filename;
		$path = $target_path.strtotime('Y-m-d').$filename;
		
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
						//echo "INSERT INTO `dj_video` (`artist`,`trackname`,`price`,`label`,`genre`,`host_id`,`releasedate`,`tonightlist`,`musicpath`,`director`) VALUES ('$artist','$trackname','$price','$label','$genre','$hostid','$releasedate','','$path','$director')"; die;
						//$message['success'] = "Your File Uploaded Successfully !";
						
						$sql = mysql_query("INSERT INTO `dj_video` (`artist`,`trackname`,`price`,`label`,`genre`,`host_id`,`releasedate`,`tonightlist`,`musicpath`,`director`) VALUES ('".$artist."','".$trackname."','".$price."','".$label."','".$genre."','".$hostid."','".$releasedate."','','".$path."','".$director."')");
	
						if($sql)
						{
							$message['success'] = "Your Video is loaded successfully.";
						}
					}
					else
					{
						$message['error'] = " Video cannot be Uploaded !";
					}
				}
			   
			}
	}
	else
	{
		$message['error'] = " Video with name: ".$trackname." already exists. Please enter different video name  !";
	}

}

if($_POST['Save'])
{
	
		
		$sql1 = mysql_query("SELECT * FROM dj_video");
		while( $re = mysql_fetch_array($sql1))
		{
			$i = $re['id'];
			mysql_query("UPDATE dj_video SET `tonightlist` = '0' WHERE id = '$i' ");
		}
	if(!empty($_POST['tonightlist']))
	{
		foreach($_POST['tonightlist'] as $post)
		{
			$sql = mysql_query("UPDATE dj_video SET `tonightlist` = '1' WHERE id = '$post'");
		}
		
		
	}

    $message['success'] = "Tonight list is updated.";
}

$userID=$_SESSION['user_id'];

$myquery = mysql_query("SELECT * FROM dj_video where host_id = '$userID' ORDER BY trackname ASC");
?>

<?php

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
			<h3 id="title">Load Video</h3>
					
						     
		<div class="parent-message-div">
			<?php
			
			if((isset($_POST['Loadmusic'])  ||  (isset($_POST['Save']) ) ) && ($message['success'] != ""))
			{
				echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
			}
			if(($message['error'] != ""))
			{
				echo '<div id="errormessage" class="message NoRecordsFound" >'.$message['error']."</div>";
				unset($message);
			}
			?>

		</div>

		<form method="POST" action="cds.php?video=uploaded" enctype="multipart/form-data" class="musicadd">


		   <div class="field_ss"> 
		   
		   <label >Video Name<b><font color='red'><em>*</em></font></b></label>
		    <input id="VideoName" type="text" name="trackname" required  value="<?php if($message['error'] != ""){ echo $_POST['trackname']; } ?>" /></div>
		    
		    <div class="field_ss"> <label>Artist<b><font color='red'><em>*</em></font></b></label>
		    <input type="text"   name="artist" required value="<?php if($message['error'] != ""){ echo $_POST['artist']; } ?>"  /></div>
		    
		    <div class="field_ss"><label>Label</label>
		    <input type="text" name="label"  value="<?php if($message['error'] != ""){ echo $_POST['label']; } ?>" /></div>
		    <div class="field_ss"> <label>Genre</label>
		    <input type="text" name="genre"  value="<?php if($message['error'] != ""){ echo $_POST['genre']; } ?>" /></div>
		    
		    
		    <div class="field_ss"><label>Release Date</label>
		    <input class="date12" style=" " type="text" id="video_release"  name="releasedate" value="<?php if($message['error'] != ""){ echo $_POST['releasedate']; } ?>" /></div>
		    
		    <div class="field_ss"> <label >Price<b><font color='red'><em>*</em></font></b> <span>$</span></label>
		    <input id="VideoPrice" <?php if(empty($merchantID)){ ?> onclick='addmerchantID("VideoClips")'; <?php } ?> type="number" min="0"   max="9999" step="0.01" name="price" value="<?php if($message['error'] != ""){ echo $_POST['price']; } ?>" required  title="Enter a valid number"/></div>
		    
		     <div class="field_ss"> <label >Video Director</label>
		    <input type="text" name="director" value="<?php if($message['error'] != ""){ echo $_POST['director']; } ?>"  /></div>
		    

		    <div class="field_ss"><label>Browse Video<b><font color='red'><em>*</em></font></b></label>
		    <input type="file" onchange="return Validate_music_FileUpload()" id="music_upload" name="file" style=" color:white;"  accept="audio/*,video/*,image/*" required class="brwse_btn" /><div class="clear"><p style=" margin-left:35%">(Upload Only: .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v file extensions)</p></div></div>
		    
		     <div class="field_ss"><input type="hidden"  name="host_id" value="<?php echo $_SESSION['user_id'];?>" /></div>
		    
		   <div class="field_out"><input type="submit" name="Loadmusic" class="button btn_ss" value="Load" /></div>
		    
		</form>
		<?php 
		$count1 = mysql_numrows($myquery);
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
		    <table class='display loadmusic whitespace' id='example' style='margin-top:10px;' >
		        <thead>
		        <tr bgcolor='#ACD6FE'>
		            <th>Video</th>
		            <th>Artist</th>
		            <th>Director</th>
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
		        $count = mysql_numrows($myquery);
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
		                            <?php echo $res['director']; ?>
		                        </td>
		                        <td>
		                            <?php echo $res['label']; ?>
		                        </td>
		                        <td>
		                            <?php echo $res['genre']; ?>
		                        </td>
		                        <td>
		                            <?php
									if(!empty($res['releasedate'])){
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
									<a onClick="javascript:void window.open('play_video_clip.php?clip_id=<?php echo $res['id']; ?>','','width=500,height=500,resizable=true,left=0,top=0');return false;"><img src="images/play_icon.png" height="25px" width="25px;"></a>
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
		                        <td colspan="9">
		                            No Video records yet !
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
	
	if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
		alert('DJ Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
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
			url: 'deletevideoajax.php',
			data: {
				'id': id,
				'action': 'deletemusic',
			},
			success: function(data) {
				$('.parent-message-div').html(data);
				setTimeout(function() {
				      // Do something after 5 seconds
				      window.location.href = "";
				}, 2000);
				
			}

			});
		  }
		
	});


});


</script>
