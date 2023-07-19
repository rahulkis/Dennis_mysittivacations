<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
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
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				
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
		$_POST['friendsdropdownselected']=	implode(", ", $_POST['friendsdropdownselected']);
		$_POST['groupdropdownselected']=	implode(", ", $_POST['groupdropdownselected']);
		$ValueArray = array('clique',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,"",$_POST['post_type'],$status,$_POST['friendsdropdownselected'],$_POST['groupdropdownselected']);
		$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
  }else{
  		$city = $_SESSION['usercity'];
	 	$ValueArray = array('clique',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,$city,$_POST['post_type'],$status,"","");
		$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
   
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
						$_SESSION['popup_add_post'] = "added";	
						echo "<script>opener.location.reload(true);self.close();</script>";
					}
					
				}

			}
			
		
			
		$_SESSION['popup_add_post'] = "added";	
		echo "<script>opener.location.reload(true);self.close();</script>";
} ?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<? include('suggest_friend.php');?>
<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />


<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />
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

function Validate_a_FileUpload(){
		var check_image_ext = $('#a_private_photo').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#a_private_photo').val('');
		}
}

function Validate_a_VideoUpload(){
		var check_image_ext = $('#a_private_video').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
				alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
					$('#a_private_video').val('');
		}
}
</script>
 <div id="modal" class="popupContainer" style=" width:99%;  height: 100%;   left: 1%; position: absolute; top:3px;" >
		<header class="popupHeader">
			<span class="header_title">Add Post</span>
 
		</header>
		<section class="popupBody">
			<?php if(isset($_SESSION['success'])) {  echo '<div id="successmessage" style="display:block;" class="message" >Post Added successfully</div>';
unset($_SESSION['success']) ;} ?>
			<div class="user_register">


           <form name="forum" action="" method="post" onsubmit="return validate_forum();" enctype="multipart/form-data">
             	<input type="hidden" name="action" value="<?php echo $_SERVER['REQUEST_URI'];?>" />
             	<div> 
                 	<label>Post:</label>
             	</div>
             	<div> 
                	<textarea name="forum" required class="txt_box" /></textarea>
          		</div>
          		<div>
	               	<label> Image:</label>
               		<input onchange="return Validate_a_FileUpload()" id="a_private_photo" type="file" name="forum_img" class="txt_box"  /> (Allowed exts's gif, png, jpg & jpeg)
               	</div>
               	<div>
                 <label> Video:</label>
                 <input onchange="return Validate_a_VideoUpload()" id="a_private_video"  type="file" name="forum_video" class="txt_box" /> (Allowed exts's .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v)
              	</div>
              	<input type="hidden" name="post_type" value="private" />
              	<input type="submit" name="submit" value="Submit" class="button" style="margin-left:151px;"  />
           </form>
           </div>

		</section>
	</div>
                 <?php /*<label>Posting Type</label>
                Private : <input type="radio" name="post_type" onclick="javascript:$('#groupsxcv').show();"  value="private" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 Public : <input type="radio" name="post_type" checked="checked"  value="public" onclick="javascript:$('#groupsxcv').hide();" /> 
              	<br>
              	<br>
              
              	
          <div id="groupsxcv" style="display:none;">
			 
		<div style="float:left; margin-bottom: 15px;">
    <select name="friendsdropdown"  id="friendsdropdown" multiple="multiple"  size="4" class="addorremove">
  
        <?
        if($_SESSION['user_type']=="club"){
		$rq_f=@mysql_query('SELECT user.id, user.first_name, user.last_name from user join friends on user.id=friends.friend_id where user_id="'.$_SESSION['user_id'].'"and friends.friend_type="user" and friends.status="active"');
        $f_req=@mysql_num_rows($rq_f);
        
	}else{
		$rq_f=@mysql_query('SELECT user.id, user.first_name, user.last_name from user join friends on user.id=friends.friend_id where user_id="'.$_SESSION['user_id'].'"and friends.friend_type="club" and friends.status="active"');
        $f_req=@mysql_num_rows($rq_f);
	}
         while($sql5=@mysql_fetch_array($rq_f))
                    {
						echo "<option value='".$sql5['id']."'>".$sql5['first_name']." ".$sql5['last_name']."</option>";
      
	}
        ?>
    </select>
      <div class="addorremovebutton">
    <input class="button" type="button" id="addfriend" value="Add" />
<input type="button"  class="button" id="removefriend" value="Remove" />
<input type="hidden" value="" id="hiddenfriend"  name="hiddenfriend"/>
</div>
  <select name="friendsdropdownselected[]" id="friendsdropdownselected" class="addorremove" multiple="multiple" ></select>  

</div>
<?   if($_SESSION['user_type']=="user"){?>
<div style="float:left;margin-bottom: 15px;">
 <select name="groupdropdown" multiple="multiple" id="groupdropdown"  class="addorremove" >
  
        <?
        if($_SESSION['user_type']=="user"){
		
		$rq_f=@mysql_query('SELECT id, group_name from chat_groups where create_by ="'.$_SESSION['user_id'].'"');
        $f_req=@mysql_num_rows($rq_f);
	}
         while($sql5=@mysql_fetch_array($rq_f))
                    {
						echo "<option value='".$sql5['id']."'>".$sql5['group_name']."</option>";
      
	}
        ?>
    </select>
    <div class="addorremovebutton">
    <input type="button" class="button"  id="addgroup" value="Add" />
<input type="button" class="button" id="removegroup" value="Remove" />
<input type="hidden"  value="" id="hiddengroup"  name="hiddengroup"/>
</div>
 <select name="groupdropdownselected[]"  class="addorremove" id="groupdropdownselected"  multiple="multiple" ></select>  

</div>
<? } ?>
<input type="hidden"  id="hidden1" />
<p id="selectedValues"></p>

       </div>
                <input type="submit" name="submit" value="Submit" class="button" style="margin-left:151px;"  />
           </form>
    <script>
    jQuery(document).ready(function(){
		jQuery('#addfriend').click(function(){
			realvalues=[];
			textvalues=[];
			opt="";
					jQuery('#friendsdropdown :selected').each(function(i, selected) {
						realvalues[i] = $(selected).val();
						textvalues[i] = $(selected).text();
						$(selected).remove();
						opt=opt+"<option selected='selected' value='"+realvalues[i]+"'>"+textvalues[i]+"</option>";
					});
					
					jQuery('#friendsdropdownselected').append(opt);
					jQuery('#friendsdropdownselected').each(function() {
						jQuery(this).prop('selected', true);
					});
					jQuery("#friendsdropdownselected").append($("#friendsdropdownselected option").remove().sort(function(a, b) {
					var at = $(a).text(), bt = $(b).text();
					return (at > bt)?1:((at < bt)?-1:0);
					}));
			});
			jQuery('#addgroup').click(function(){
			realvalues=[];
			textvalues=[];
			opt="";
					jQuery('#groupdropdown :selected').each(function(i, selected) {
						realvalues[i] = $(selected).val();
						textvalues[i] = $(selected).text();
						$(selected).remove();
						opt=opt+"<option selected='selected' value='"+realvalues[i]+"'>"+textvalues[i]+"</option>";
					});
					
					//alert(realvalues);
					jQuery('#groupdropdownselected').append(opt);
					jQuery('#groupdropdownselected').each(function() {
						jQuery(this).prop('selected', true);
					});	
					jQuery("#groupdropdownselected").append($("#groupdropdownselected option").remove().sort(function(a, b) {
					var at = $(a).text(), bt = $(b).text();
					return (at > bt)?1:((at < bt)?-1:0);
					}));		
			});
			/* remove 
			jQuery('#removefriend').click(function(){
			realvalues=[];
			textvalues=[];
			opt="";
					jQuery('#friendsdropdownselected :selected').each(function(i, selected) {
						realvalues[i] = $(selected).val();
						textvalues[i] = $(selected).text();
						$(selected).remove();
						opt=opt+"<option value='"+realvalues[i]+"'>"+textvalues[i]+"</option>";
					});
					//alert(realvalues);
					jQuery('#friendsdropdown').append(opt);
					jQuery("#friendsdropdown").append($("#friendsdropdown option").remove().sort(function(a, b) {
					var at = $(a).text(), bt = $(b).text();
					return (at > bt)?1:((at < bt)?-1:0);
					}));			
			
			});
			jQuery('#removegroup').click(function(){
			realvalues=[];
			textvalues=[];
			opt="";
					jQuery('#groupdropdownselected :selected').each(function(i, selected) {
						realvalues[i] = $(selected).val();
						textvalues[i] = $(selected).text();
						$(selected).remove();
						opt=opt+"<option value='"+realvalues[i]+"'>"+textvalues[i]+"</option>";
					});
					//alert(realvalues);
					jQuery('#groupdropdown').append(opt);	
					jQuery("#groupdropdown").append($("#groupdropdown option").remove().sort(function(a, b) {
					var at = $(a).text(), bt = $(b).text();
					return (at > bt)?1:((at < bt)?-1:0);
					}));			
			});
		
		});
    
    </script> 
       */?>
   
