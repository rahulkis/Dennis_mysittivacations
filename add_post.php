<?  session_start(); ?>
 <?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

if($_GET['type']=='private')
{
	$type=$_GET['type'];
}else
{
$type='public';
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<? //include('suggest_friend.php');?>
<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />


<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />



<?php
include('image_upload_resize.php');
include('suggest_friend');
if($_POST['submit'])
{

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
		
		
			 //indicate which file to resize (can be any type jpg/png/gif/etc...)
			$file = $path;
			
			//indicate the path and name for the new resized file
			$resizedFile = $thumbnail;
			
			//call the function (when passing path to pic)
			smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
			//call the function (when passing pic as string)
			smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );				
		
		
//        list($width, $height) = getimagesize($path);
//        
//        $newwidth = 324; // This can be a set value or a percentage of original size ($width)
//        $newheight = 200; // This can be a set value or a percentage of original size ($height)
//        
//        // Load the images
//        $thumb = imagecreatetruecolor($newwidth, $newheight);
//        if(strtolower($extension) == 'png')
//			{
//				//die('png');
//				$source = imagecreatefrompng($path);
//				// $bgc = imagecolorallocate($source, 255, 255, 255);
//		  //       $tc  = imagecolorallocate($source, 0, 0, 0);
//		  //       imagefilledrectangle($source, 0, 0, 150, 30, $bgc);
//			}
//			elseif(strtolower($extension) == 'gif')
//			{
//				//die('gif');
//				$source = imagecreatefromgif($path);
//			}
//			else
//			{
//				//die('jpg');
//				$source = imagecreatefromjpeg($path);
//			}
//    	
//        // Resize the $thumb image.
//        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//        
//        // Save the new file to the location specified by $thumbnail
//        imagejpeg($thumb, $thumbnail, 100);
      }
  
    $forum=mysql_escape_string($_POST['forum']);
    $forum_img=$thumbnail;
    $forum_video=$video_name;
    $user_id=$_SESSION['user_id'];
    $added_on=date("Y-m-d h:i:s");
    $status=1;
    //$forum_city=
    $ThisPageTable='forum';
    if($_POST['post_type']=='private')
    {
		
		$group_array1 = array();	
		$get_search_val = explode("," , $_POST['search_val']);
		
		foreach($get_search_val as $single_val){
			
			$group_array1[] = trim($single_val);
			
			
		}
	
		$group_array2 = array_filter($group_array1);
		$groups_user_ids = array();
	
		foreach($group_array2 as $single_group_name)
		{
			
			$query_g1 = @mysql_query("SELECT chat_users_groups.group_id, chat_users_groups.user_id FROM chat_users_groups INNER JOIN chat_groups ON chat_users_groups.group_id = chat_groups.id WHERE chat_groups.group_name LIKE '%".$single_group_name."%'");
			
				while($row = mysql_fetch_assoc($query_g1)){
					
					$groups_user_ids[] = $row['user_id'];
				}
			
			
		}
		
		$users_array1 = array();
		$user_get_search_val = explode("," , $_POST['search_val2']);
		
		$user_email_list = array_filter($user_get_search_val);
		
		foreach($user_email_list as $single_user_val){
			
			$user_email = trim($single_user_val);
			
			if(!empty($user_email)){
				
				$query_u1 = @mysql_query("SELECT id FROM user WHERE email = '$user_email'");
				
					while($row_user = mysql_fetch_assoc($query_u1)){
						
						$users_array1[] = $row_user['id'];
					}
				
			}
		}
		

		$user_ids_main_arr = array_unique(array_merge($groups_user_ids,$users_array1));
		
		foreach($user_ids_main_arr as $single_user_id){
			
			if($_SESSION['user_id'] == $single_user_id){
				
					$ValueArray = array('profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$single_user_id,$added_on,"",'public',$status);
					$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status');				
				
				 	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				}else{
				
					$ValueArray = array('profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$single_user_id,$added_on,"",'public',$status,$user_id);
					$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status', 'from_user');				
				 	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
			}
			
		}
		$_SESSION['success']="Post added successfully";
  	}
  	else
  	{
  		//die('sss');
      		$city = $_SESSION['id'];
      		$getfriendsquery = @mysql_query("SELECT `f`.`friend_id` FROM `friends` as f  WHERE `f`.`user_id` = '$_SESSION[user_id]'  AND `f`.`friend_type` = 'user' AND `f`.`friend_id` != '$_SESSION[user_id]'  AND `f`.`status` = 'active'  ");
      		$countrows = @mysql_num_rows($getfriendsquery);
      		if($countrows > 0)
      		{
      			while($result = @mysql_fetch_array($getfriendsquery))
      			{
      				$uid = $result['friend_id'];
      				$ValueArray = array($_SESSION['user_id'],'profile','user',$forum_img,$forum,$path,$forum_video,$uid,$added_on,$city,$_POST['post_type'],$status,"","");
			    	$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
			    	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
      			}

      		}
      		//else
      		//{

		    	$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$_SESSION['user_id'],$added_on,$city,$_POST['post_type'],$status,"","");
		    	$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
		    	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	    	//}
  	}
   
    
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
			
			echo "<script>opener.location.reload(true);self.close();</script>";
			
		}else{
			   $_SESSION['success']="Post updated successfully";
		  }
          
        }
       
      }
	  
	$_SESSION['popup_add_post'] = "added";  
    echo "<script>opener.location.reload(true);self.close();</script>";	        
} ?>

<script type="text/javascript">
	
	    setTimeout(function() { $("#successmessage").fadeOut(1500); }, 5000);	
	
	
	function validate_forum(){
		
		if($("#add_post_text").val() || $("#add_post_img").val() || $("#add_post_video").val()){
			return  ture;
		}else{
		  alert("Atleast one field is required ");	return false;
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
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#add_post_video').val('');
			}
	}	
	
	  
</script>
 <div id="modal" class="popupContainer" style=" width:99%;  height: 100%;   left: 1%; position: absolute; top:3px;" >
		<header class="popupHeader">
			<span class="header_title">Add Post</span>
 
		</header>
		<section class="popupBody">
			<!-- Social Login -->
			<?php if(isset($_SESSION['success'])) {  echo '<div id="successmessage" style="display:block;" class="message" >Post Added successfully</div>';
unset($_SESSION['success']) ;} ?>
			<div class="user_register">

          
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
                     <input id="add_post_video" type="file" name="forum_video" class="txt_box clear_flds"  style="color: #fff" onchange="return ValidateVideoUpload()"/> (Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)
                </div>
                 
                <!--<br>-->
    
                 <div class="radios">
                    <label>Posting Type</label>
                    <div>
                    Public: <input type="radio" name="post_type" checked="checked" value="public" onclick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();"  style="width: 20px;"></div>
                    <?php 
                    if($_SESSION['user_type'] == "user")
                    	{?>
                    		<div>Private: <input name="post_type"  value="private" onclick="javascript:$('#groups').show();$('#friends').show();$('#or').show();"   type="radio" style="width: 20px;"></div>
                    <?php } ?>
                    <div style="clear:both"></div>
	          	</div>
            
           <ul id="groups" style="display:none;">
           <li>
           <label>Send To groups:</label>
           <textarea cols="50" rows="5" name="search_val" id="search_val"></textarea>
             <input type="hidden" name="group" id="txt2">
                <p>Please type first few letters</p>
             </li>
         </ul>
    <!--         <div id='or' style="display:none; margin-left:150px;"> <strong>OR</strong> </div>-->
         <ul id="friends" style="display:none;">
           <li></li>
           <li>
           <label>Send To Friends:</label>
           <textarea cols="50" rows="5" id="search_val2" name="search_val2"></textarea>
             <input type="hidden" name="friend" id="txt_f">
                <p>Please type first few letters</p>
             </li>
         </ul>
                
            <div id="submit_btn">
                <input id="submit3" type="submit" name="submit" value="Submit" class="button" style=""  />
				<a href="javascript:void(0);"><input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Cancel"/></a>
            </div>
           
                
           </form>
			</div>

		</section>
	</div>
 <script>

$().ready(function() {
	
	$("#search_val").autocomplete(grouplistx, {
		multiple: true,
		mustMatch: false,
		autoFill: false
	});
	$("#search_val2").autocomplete(freindsListx, {
		multiple: true,
		mustMatch: false,
		autoFill: false
	});
});
 
 </script>
               
