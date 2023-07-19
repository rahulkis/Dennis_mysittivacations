<?php
//include("Query.Inc.php");
//$Obj = new Query($DBName);
if($_POST['submit'])
{ 

    
    if($_FILES['forum_video']["name"]!="")
    {
        $forum_video=$_FILES['forum_video']['name']; 
        $tmp = $_FILES["forum_video"]["tmp_name"]; 
        $video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
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
          //die('png');
          $source = imagecreatefrompng($path);
          // $bgc = imagecolorallocate($source, 255, 255, 255);
        //       $tc  = imagecolorallocate($source, 0, 0, 0);
        //       imagefilledrectangle($source, 0, 0, 150, 30, $bgc);
        }
        elseif(strtolower($extension) == 'gif')
        {
          //die('gif');
          $source = imagecreatefromgif($path);
        }
        else
        {
          //die('jpg');
          $source = imagecreatefromjpeg($path);
        }
    
        // Resize the $thumb image.
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        // Save the new file to the location specified by $thumbnail
        imagejpeg($thumb, $thumbnail, 100);
      }
  
    $forum=mysql_escape_string($_POST['forum']);
    $forum_img=$thumbnail;
    $forum_video=$video_name;
    $user_id=$_SESSION['user_id'];
    $added_on=date("Y-m-d h:i:s");
    $status=1;
    //$forum_city=
    $ThisPageTable='forum';
    if($_POST['post_type']=='private'){
    $_POST['friendsdropdownselected']=  implode(", ", $_POST['friendsdropdownselected']);
    $_POST['groupdropdownselected']=  implode(", ", $_POST['groupdropdownselected']);
    $ValueArray = array($forum,$forum_img,$forum_video,$user_id,$added_on,"",$_POST['post_type'],$status,$_POST['friendsdropdownselected'],$_POST['groupdropdownselected']);
    $FieldArray = array('forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
  }else{
      $city = $_SESSION['usercity'];
    $ValueArray = array($forum,$forum_img,$forum_video,$user_id,$added_on,$city,$_POST['post_type'],$status,"","");
    $FieldArray = array('forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
   
  }
    $Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
    move_uploaded_file($tmp,$video_name);
      if($Success > 0)
      {
        if($_POST['action']=="/upload_video.php")
        {
          header('location: upload_video.php');exit;
        }
        elseif ($_POST['action'] == "/upload_photo.php") {
          # code...
          header('location: upload_photo.php');exit;
        }
        else
        {
          if($_POST['post_type']=='private')
          {
            header('location: private_zone.php');exit;
          }
          
        }

      }
            
} ?>

<script type="text/javascript">
	function validate_forum(){
		if($("#add_post_text").val() || $("#add_post_img").val() || $("#add_post_video").val()){
			alert("Atleast one field is required ");return  false;
		}else{
			return true;
		}
		
	}
	function ValidateFileUpload(){
			var check_image_ext = $('#add_post_img').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
				$('#add_post_img').val('');
			}
	}
	
	function ValidateVideoUpload(){
			var check_image_ext = $('#add_post_video').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['mp4','f4v','flv','webm','m4v']) == -1) {
				alert('Post Video only allows file types of MP4, WEBM, F4V, M4V and FLV');
				$('#add_post_video').val('');
			}
	}	
	
	  
</script>

          <form class="popupform" name="forum" action="" method="post" onsubmit="return validate_forum();" enctype="multipart/form-data">
             
               <div>  
                    <label>Post:</label>
                    <textarea id="add_post_text" required name="forum" class="txt_box clear_flds" /></textarea>
                </div>
                <!--<br>-->
                
				<div>	
                   <label> Image:</label>
                   <input id="add_post_img" type="file" name="forum_img" class="txt_box clear_flds"  style="color: #fff" onchange="return ValidateFileUpload()"/> (Allowed exts's gif, png, jpg & jpeg)
				</div>
                
               <!-- <br>-->
                <div>
                     <label> Video:</label>
                     <input id="add_post_video" type="file" name="forum_video" class="txt_box clear_flds"  style="color: #fff" onchange="return ValidateVideoUpload()"/> (Allowed exts's mp4, webm, flv, m4v, f4v)
                </div>
                 
                <!--<br>-->
    
                 <div>
                    <label>Posting Type</label>
                    
                    Public: <input type="radio" name="post_type" checked="checked" value="public" onclick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();"  style="width: 20px;">
                    Private: <input name="post_type"  value="private" onclick="javascript:$('#groups').show();$('#friends').show();$('#or').show();"   type="radio" style="width: 20px;">
	          	</div>
            
           <ul id="groups" style="display:none;">
           <li>Send To groups:</li>
           
           <li>
           <textarea cols="50" rows="5" id="search_val"></textarea>
             <input type="hidden" name="group" id="txt2">
          <!--<br>-->
                Please type first few letters
             </li>
         </ul>
    <!--         <div id='or' style="display:none; margin-left:150px;"> <strong>OR</strong> </div>-->
         <ul id="friends" style="display:none;">
           <li>Send To Friends:</li>
           <li>
           <textarea cols="50" rows="5" id="search_val2"></textarea>
             <input type="hidden" name="friend" id="txt_f">
         <!-- <br>-->
                Please type first few letters
             </li>
         </ul>
                
            <div>
                <input type="submit" name="submit" value="Submit" class="button" style=""  />
            </div>
            
                
           </form>
     
       
   
