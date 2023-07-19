<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

// 
 if(isset($_GET['id']))
 {
 $get_post_details=mysql_query("select * from forum where forum_id='".$_GET['id']."'");
 $post_dtl=@mysql_fetch_assoc($get_post_details);
 }
// 
if(isset($_POST['submit']))
{ 
	// echo "<pre>"; print_r($_POST); exit;
	
			$sq12="select city from user  where id='".$_SESSION['user_id']."'";
        			$res2=mysql_query($sq12);
		    	$city_id_arr = @mysql_fetch_array($res2);
			$city_id= $city_id_arr['city'];
		
		if($_FILES['forum_video']["name"]!="")
		{
				$forum_video=$_FILES['forum_video']['name']; 
				$tmp = $_FILES["forum_video"]["tmp_name"]; 
				$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
				move_uploaded_file($tmp,$video_name);
		}
		
		if($_FILES["forum_img"]["name"]!="")
			{
				$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
				$temp = explode(".", $_FILES["forum_img"]["name"]);
				$extension = end($temp);
				$name = $_FILES["forum_img"]["name"];
				$ext =substr($name,strrpos($name,'.'));
				$tmp1 = $_FILES["forum_img"]["tmp_name"];
				$path = "upload/forum_".time().strtotime(date("Y-m-d")).$name;
				$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
				$thumbnail = "upload/".$thumb;
				move_uploaded_file($tmp1,$path);	
				list($width, $height) = getimagesize($path);
				
				$newwidth = 324; // This can be a set value or a percentage of original size ($width)
				$newheight = 200; // This can be a set value or a percentage of original size ($height)
				
				// Load the images
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				if(strtolower($extension) == 'png')
				{
					$source = imagecreatefrompng($path);
					// $bgc = imagecolorallocate($source, 255, 255, 255);
			  //       $tc  = imagecolorallocate($source, 0, 0, 0);
			  //       imagefilledrectangle($source, 0, 0, 150, 30, $bgc);
				}
				elseif(strtolower($extension) == 'gif')
				{
					$source = imagecreatefromgif($path);
				}
				else
				{
					$source = imagecreatefromjpeg($path);
				}
		
				// Resize the $thumb image.
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				
				// Save the new file to the location specified by $thumbnail
				imagejpeg($thumb, $thumbnail, 100);
			}
			else
			{
				$thumbnail=$_POST['old_thumb'];
				$path = $_POST['old_image'];
			}
	
		$forum=mysql_escape_string($_POST['forum']);
		$forum_img=$thumbnail;
		$forum_video=$video_name;
		$user_id=$_SESSION['user_id'];
		$added_on=date("Y-m-d h:i:s");
		$status=1;
		//$forum_city=
		$ThisPageTable='forum';
		$ValueArray = array('profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,$city_id,'public',$status);
		$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status');
		$Success = $Obj->Update_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray,'forum_id',$_POST['forum_id']);
			if($Success > 0)
			{
				//echo "<script>opener.location.reload(true); self.close();</script>";

						$_SESSION['popup_update_post'] = "updated";  
						echo "<script>opener.location.reload(true);self.close();</script>";

			}
						
} ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<script src="js_validation/add_contest.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />
<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/shout_out.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<script src="js_validation/signup.js" type="text/javascript"></script>
<script>
function validate_forum()
{
	if( document.forum.forum.value== "" )
   {
		alert( "Please provide forum data!" );
     	document.forum.forum.focus() ;
     	return false;   
	}


}

	function Validate_editp_FileUpload(){
			var check_image_ext = $('#edit_p_img').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
				$('#edit_p_img').val('');
			}
	}
	
	function Validate_editp_VideoUpload(){
			var check_image_ext = $('#edit_p_video').val().split('.').pop().toLowerCase();
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#edit_p_video').val('');
			}
	}	
</script>

 <div id="modal" class="popupContainer" style=" width:99%;  height: auto; left: 1%; position: absolute; top:3px;" >
		<header class="popupHeader">
			<span class="header_title">Edit <?php echo ucfirst($post_dtl['forum_type']); ?> Post</span>

		</header>
		<section class="popupBody">
			<?php if(!empty($msg)){ ?><div id="successmessage" class="message" style="display: block;"><?php echo $msg; ?></div> <?php } ?>
			<!-- Social Login -->
			<div class="user_register">
           <form class="epost" name="forum" action="" method="post" onsubmit="return validate_forum();" enctype="multipart/form-data">
             <div>
                 <label>Post:</label>
                <textarea name="forum"  class="txt_box"  /><?php echo $post_dtl['forum']; ?></textarea>
              </div>
              <div>
                 <label> Image:</label>
                 <input type="hidden" name="old_image" value="<?php echo  $post_dtl['forum_img'];  ?>" />
                 <input type="hidden" name="old_thumb" value="<?php echo  $post_dtl['image_thumb'];  ?>" />
                               </div>
              <div>
                   <input type="hidden" name="forum_id" value="<?php echo $_GET['id'];  ?>">
                  <input type="file" id="edit_p_img" name="forum_img" class="txt_box" style="color: #fff;" onchange="return Validate_editp_FileUpload()"/> (Allowed exts's gif, png, jpg & jpeg)
                                </div>
                  <div class="pop_img_ss">
                  <?php  if(!empty($post_dtl['forum_img'])) { ?>
                  Old Image <br /> <img src="<?php echo $post_dtl['image_thumb']; ?>" width="300" height="200">
                  <?php } ?>
                  </div>
              <div>
                 <label> Video:</label>
                 <input type="file" id="edit_p_video" name="forum_video" class="txt_box" style="color: #fff;" onchange="return Validate_editp_VideoUpload()"/> (Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)
                           </div>
              <!--<div class="radios">-->
              <!--   <label>Posting Type</label>-->
              <!--   <div>-->
              <!--  Private : <input type="radio" name="post_type" <?php if($post_dtl['forum_type']=='private') { ?>-->
              <!--   checked="checked" <?php } ?> value="private" /> </div><div>Public : -->
              <!--   <input type="radio" name="post_type" value="public" <?php if($post_dtl['forum_type']=='public') { ?>  checked="checked" <?php } ?> /> </div>-->
              <!--              </div>-->
              <div>
                <input type="submit" name="submit" value="Submit" class="button"  />
                <input type="button" value="Close Window" class="button" onclick="javascript:self.close();"  />
                              </div>

           </form>
     
     	</div>

		</section>
	</div>
 

       
       
   