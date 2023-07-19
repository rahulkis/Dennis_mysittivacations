<?php
ob_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Profile";
include('LoginHeader2.php');

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
//include '../googleplus-config.php';

// ini_set("display_errors", "1");
// error_reporting(E_ALL);

if(!isset($userID)){ $Obj->Redirect($SiteURL); }


/* to check  user is friend with requested id */
if(isset($_GET['id']) && isset($_SESSION['user_id'])){	
$query_string = "SELECT count(id) as frnd FROM friends where user_id='".$_SESSION['user_id']."' AND friend_id='".$_GET['id']."'";
$result = @mysql_query($query_string);
$result=@mysql_fetch_array($result);
$both_are_friend=$result['frnd'];
}
/* */


$query_string = "SELECT id FROM user where id!='1' AND is_online='1' AND logged_date < DATE_SUB(CURDATE(), INTERVAL 2 HOUR)  ORDER BY id";
$result = @mysql_query($query_string);
while($row_a = @mysql_fetch_array($result))
{
	//mysql_query("update user set is_online='0' where id='".$row_a['id']."'");
}

$query_club = "SELECT id FROM club  is_online='1' AND logged_date < DATE_SUB(CURDATE(), INTERVAL 3 HOUR)  ORDER BY id";
$result_club = @mysql_query($query_club);
while($row_a_club = @mysql_fetch_array($result_club))
{
	//mysql_query("update club set is_online='0' where id='".$row_a_club['id']."'");
}

$userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}
 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
}

//include('../header_start.php');

include($ABSPATH.'suggest_friend.php');
require_once($ABSPATH."admin/paging.php");

?>

<!--<script src="<?php echo $SiteURL; ?>js/jquery-ui.js"></script>-->
<!--<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>-->
<!--<script type='text/javascript' src='<?php echo $SiteURL; ?>js/autocompletemultiple/jquery.autocomplete.js'></script>-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo $SiteURL; ?>js/autocompletemultiple/jquery.autocomplete.css" />-->
<!--<link rel="stylesheet" type="text/css" href="https://mysitti.com/css/new_portal/style.css" />-->
<style>
.show_all_comments .box3{
	color: rgb(254, 205, 7);
	
	text-decoration: underline;
}

.onload_comments{
	display: none;
}

.hide_cm{
	display: none;
}
</style>


<?php //include('header.php');?>


<?php
if(isset($_REQUEST['id'])){
	$userID=$_REQUEST['id'];
	}
	else {
	$userID=$_SESSION['user_id'];	
	}
	$sql = "select * from `user` where `id` = '".$userID."'";
	$userArray = $Obj->select($sql) ; 
	$first_name=$userArray[0]['first_name']; 
	$last_name=$userArray[0]['last_name'];
	$zipcode=$userArray[0]['zipcode'];
	$state=$userArray[0]['state'];
	$country=$userArray[0]['country'];
	if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
	$city=$userArray[0]['city'];
	$email=$userArray[0]['email'];
	$image_nm=$userArray[0]['image_nm'];
	$phone=$userArray[0]['phone'];

	$fullname = $first_name." ".$last_name;
	$profilename = $userArray[0]['profilename'];

	//echo "select g.group_name,g.id from  chat_users_groups as cgs  join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' group by g.id";die;
	$get_groups = mysql_query("select g.group_name,g.id from chat_users_groups as cgs join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' AND g.group_type = 'private' group by g.id");
	
	$get_friends = mysql_query("select u.first_name,u.profilename,u.last_name,u.email,u.id from friends as f join user as u on(u.id=f.friend_id) where f.user_id ='".$userID."' AND f.friend_id != '".$userID."' group by f.friend_id");
	/**********************************/
?> 

<?php
if($_POST['update']){
	
	if($_FILES['forum_img']['error'] == "0"){
		
				$file_type = $_FILES['forum_img']['type'];
				$exp_file_type = explode('/', $file_type);
				$check_file_type = $exp_file_type[0];
				
				if($check_file_type == "video" || $check_file_type == "application"){
					
					$forum_video=$_FILES['forum_img']['name']; 
					$tmp = $_FILES["forum_img"]["tmp_name"]; 
					$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
					move_uploaded_file($tmp,$video_name);
					
				}elseif($check_file_type == "image"){
					
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
						//smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
						//call the function (when passing pic as string)
						//smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );

						$resizeObj = new resize($file);

						// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
						$resizeObj -> resizeImage(300, 300, 'auto');

						// *** 3) Save image ('image-name', 'quality [int]')
						$resizeObj -> saveImage($resizedFile, 100);
						
						$forum_img=$thumbnail;
						$forum_video=$video_name;
						$user_id=$_SESSION['user_id'];
						$added_on=date("Y-m-d h:i:s");
						$status=1;
						//$forum_city=
						$ThisPageTable='forum';
					

					
				}
				
							$forum=mysql_escape_string($_POST['forum']);
							$forum_img=$thumbnail;
							$forum_video=$video_name;
							$user_id=$_SESSION['user_id'];
							$added_on=date("Y-m-d h:i:s");
							$status=1;
							//$forum_city=
							$ThisPageTable='forum';
							//$ValueArray = array('profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,$city_id,'public',$status);
							//$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status');
							//$Success = $Obj->Update_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray,'forum_id',$_POST['forum_id']);
								
								
								$forum = mysql_escape_string($_POST['forum']);
								$added_on = date("Y-m-d");
								
								if(!empty($_POST['common_identifier'])){
								
								mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."', forum_img = '".$path."', image_thumb = '".$forum_img."', forum_video = '".$forum_video."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0'");
								
								$_SESSION['post_edit_success'] = "updated";
								
								}
		
		}else{
		
		$forum = mysql_escape_string($_POST['forum']);
		$added_on=date("Y-m-d");
		
		mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0'");
		$_SESSION['post_edit_success'] = "updated";
		
	}
	
}


if($_POST['submit'])
{
//	
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//
//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";
//die;
	
	$file_type = $_FILES['forum_img']['type'];
	$exp_file_type = explode('/', $file_type);
	$check_file_type = $exp_file_type[0];
	
	if($check_file_type == "video" || $check_file_type == "application"){
		
		$forum_video=$_FILES['forum_img']['name']; 
		$tmp = $_FILES["forum_img"]["tmp_name"]; 
		$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
		move_uploaded_file($tmp,$video_name);
		
	}elseif($check_file_type == "image"){
		
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
		//	smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
			//call the function (when passing pic as string)
		//	smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );
			$resizeObj = new resize($file);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(324, 200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);
		
	}
  
	$forum=mysql_escape_string($_POST['forum']);
	$forum_img=$thumbnail;
	$forum_video=$video_name;
	$user_id=$_SESSION['user_id'];
	$added_on=date("Y-m-d h:i:s");
	$status=1;
	//$forum_city=
	$ThisPageTable='forum';
	$common_identifier = date("Ymdhis");
	if($_POST['post_type']=='private')
	{
		
	//		echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
	//die;
		$main_arr = array();
		$group_array1 = array();	
		$get_search_val = explode("," , $_POST['search_val']);
		
		array_pop($get_search_val);
		
		foreach($get_search_val as $single_val){
			
			$group_array1[] = trim($single_val);
			
			
		}
	
		$group_array2 = array_unique(array_filter($group_array1));
		$array_1 = array();
	
		foreach($group_array2 as $single_group_name)
		{
			
			$trimmed11 = trim($single_group_name);
			if(!empty($trimmed11) && $trimmed11 != ' ' && $trimmed11 != ''){
				
			$get_grp_id = mysql_query("SELECT id FROM chat_groups WHERE group_name = '".mysql_real_escape_string($trimmed11)."'");
			$group_idd = mysql_fetch_assoc($get_grp_id);
			
			$query_g1 = mysql_query("SELECT chat_users_groups.group_id, chat_users_groups.user_id FROM chat_users_groups INNER JOIN chat_groups ON chat_users_groups.group_id = chat_groups.id WHERE chat_groups.id = '".$group_idd['id']."'");
			
				while($row = mysql_fetch_assoc($query_g1)){
					
					$array_1[] = $row['user_id'];
				}
			}
			
		}
		
		$array_2 = array();
		$user_get_search_val = rtrim($_POST['search_val2'],",");
		$user_get_search_val2 = explode("," , $user_get_search_val);
		
		array_pop($user_get_search_val2);
		
		foreach($user_get_search_val2 as $single_user_val){
			
			$trimmed = trim($single_user_val);
			
			if(!empty($trimmed) && $trimmed != ' ' && $trimmed != ''){
			
			$get_usr_id = mysql_query("SELECT id FROM user WHERE profilename = '".mysql_real_escape_string($trimmed)."'");
			$usr_id = mysql_fetch_assoc($get_usr_id);

			$array_2[] = $usr_id['id'];
			}
		}
		
	   if(empty($array_1) && !empty($array_2)){
	   
			$main_arr[] = $array_2;
	   
	   }elseif(empty($array_2) && !empty($array_1)){
		
			$main_arr[] = $array_1;
		
		}else{  
			  
			  $main_arr[] = array_merge($array_1,$array_2);
			  
	   }
	   
	   $final_arr = array_unique($main_arr[0]);
		
		foreach($final_arr as $single_user_id){
			
			
			//print_r($user_ids_main_arr);
			//if($_SESSION['user_id'] == $single_user_id){
				//die('dfdfdfdf');
								
				
					//$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				if($_SESSION['user_id'] != $single_user_id){
				
					$ValueArray = array('profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$single_user_id,$added_on,"",'public',$status,$user_id, $common_identifier);
					$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status', 'from_user', 'common_identifier');				
					$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
					
					$inserted_event_id = mysql_insert_id();
					
					$post_added_on = date('Y-m-d h:i:s');
					$c_identifier = "forum_".$inserted_event_id;
			
					mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$single_user_id."', 'post', '".$post_added_on."', '1', '".$c_identifier."', 'user', 'user')");

			}
			
		}
		
		$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$_SESSION['user_id'],$added_on,"",'public',$status, $common_identifier);
					$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status', 'common_identifier');
					$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		
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
					$ValueArray = array($_SESSION['user_id'],'profile','user',$forum_img,$forum,$path,$forum_video,$uid,$added_on,$city,$_POST['post_type'],$status,"","", $common_identifier);
					$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
					$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
					
					
				$inserted_event_id = mysql_insert_id();
				
				$post_added_on = date('Y-m-d h:i:s');
				$c_identifier = "forum_".$inserted_event_id;
		
				mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$uid."', 'post', '".$post_added_on."', '1', '".$c_identifier."', 'user', 'user')");					
					
					
				}

			}
			//else
			//{

				$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$_SESSION['user_id'],$added_on,$city,$_POST['post_type'],$status,"","", $common_identifier);
				$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				
			//}
	}
	if($Success > 0)
	{
		$_SESSION['popup_add_post'] = "added";  
	}
} ?>

<script src="<?php echo $SiteURL; ?>js/private-zone.js"></script>

<?php
	while($rs = mysql_fetch_assoc($get_groups)) {
		$val[] = $rs['group_name'];
	}
	
	while($rs2 = mysql_fetch_assoc($get_friends)) {
	  
	  if(!empty($rs2['profilename'])){
		  $val2[] = $rs2['profilename'];						

	  }
	}	
?>

<script type="text/javascript">
$(document).ready(function(){
	
	var group_list = new Array();
    
	group_list = <?php echo json_encode($val); ?>;

	$("#search_val").autocomplete(group_list, {
		multiple: true,
		mustMatch: true,
		autoFill: true
	});
	
	var friend_list = new Array();
    
	friend_list = <?php echo json_encode($val2); ?>;

	$("#search_val2").autocomplete(friend_list, {
		multiple: true,
		mustMatch: true,
		autoFill: true
	});	

});

	function delete_comment(id) {
		
			var r = confirm("Are you sure want to delete !");
			if (r == true) {
		
				jQuery.post('ajaxcall.php', {'delete_commment_id':id}, function(response){
					
					if(response == "deleted"){
						$('.c_box_'+id).hide();
					}
					
				});
			}
	}
	
	function clear_fields(){
		
		$('.clear_flds').val('');
	}
	
  function newflike(id)
	{
		//Retrieve the contents of the textarea (the content)
		//Build the URL that we will send
		var url = 'f_id='+id;
		//Use jQuery's ajax function to send it
		 $.ajax({
		   type: "POST",
		   url: "flike.php",
		   data: url,
		   success: function(html){
		  	//$("#like_"+id).html(html);
			$("#glike_"+id).html("Shouts ( "+html+" ) |");
		  
		   }
		 });
		
		//We return false so when the button is clicked, it doesn't follow the action
		return false;
	}
	
	function selectFile()
	{  
		document.getElementById("file").click();  
	} 
	
	//var check_image_ext = $('#add_post_img').val().split('.').pop().toLowerCase();
	//if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
	//	alert('invalid extension!');
	//}	
</script>

</script>
<!-- end for toggle menu -->
</head>
<body>

<!-- header starts -->

<!-- header ends -->

 <!--<h4>Providing the highest quality </h4><h1>entertainment.</h1>
	<h1>Live </h1><h4>music and</h4><h1>nightlife</h1><h4>scene</h4>
	<h4>Enjoy dance freedom</h4>-->
<?php 
if(!empty($profilename))
{
	$pieces = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n = clean($username_dash_separated);

}
?>
<div class="v2_container">
  <div class="v2_inner_main">
	
	<?php
	if(isset($_GET['id']))
	{
		if($_SESSION['user_type'] == 'user')
		{
			include('friend-profile-panel.php');  
		}
		else
		{
			include('friend-profile-panel.php');  	
		}
	}
	else
	{
			include('friend-right-panel.php');
	}
	?>
	
	<article class="forum_content v2_contentbar">
		<div class="v2_rotate_neg">
			<div class="v2_rotate_pos">
				<div class="v2_inner_main_content">


			<h3 id="title" class="botmbordr">Profile
						<?php
							if(!isset($_GET['id'])){
						
								if($_SESSION['user_type'] == 'user'){?>
								
								<!--<a style=" float: right;font-size: 14px;font-weight: normal;" href="my_public_post.php" class="button"> Manage Posts</a>-->
								<a id="ad_new_pst" style=" display: none; float: right;font-size: 14px;font-weight: normal;" href="" class="button"> Add Post</a>
						<? } } ?>
			</h3>
			<?php if( ($_SESSION['user_type'] == 'user' ) && (!isset($_GET['id'])) ){?>
			<!--<a  class="button addpost" onClick="javascript:void window.open('add_post.php','','width=500,height=700,resizable=true,left=0,top=0');return false;"  style="font-size: 14px; float:right;">Add Post</a>-->
			<?php } ?>
			 <? if(isset($_GET['msg'])){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Successfully uploaded</div> 
				  
			  <?}?>
			  
			 <? if(isset($_SESSION['popup_add_post']) && $_SESSION['popup_add_post'] == "added"){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Successfully Added</div> 
				  
			  <?  unset($_SESSION['popup_add_post']); }?>
			  
			 <? if(isset($_SESSION['post_edit_success']) == "updated"){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Updated Successfully </div> 
				  
			  <?  unset($_SESSION['post_edit_success']); }?>
			  
						  
			 <? if(isset($_SESSION['p_post_del']) == "success"){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Deleted Successfully </div> 
				  
			  <?  unset($_SESSION['p_post_del']); }?>
			  
		<?php  
  if(isset($_REQUEST['id'])){
  $userID=$_REQUEST['id'];
  }
  else {
  $userID=$_SESSION['user_id']; 
  }

?>
<style type="text/css">

  
.button123 {  
	border: solid 1px #888;  
	padding: 6px 20px;  
	background-color: #DDD;  
	font-family: Georgia;  
	color: #555;  
	-webkit-border-radius: 5px;  
	-moz-border-radius: 5px;  
	border-radius: 5px;  
	-webkit-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.3);  
	-moz-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.3);  
	box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.3);  
}  
  
.button123:hover {  
	background-color: #CCC;  
	border: solid 1px #666;  
	cursor: pointer;  
}
	
	
</style>
<?php   

	if( (!isset($_GET['id'])) )
	{

?>
	<div id="ad_profile_pst">
			<form class="popupform" name="forum" action="" method="post" onSubmit="return validate_forum();" enctype="multipart/form-data">

			<div class="ppost_newdesign">
				<div class="lbl">  
					<label >What&#39;s happening ?</label>
					
									   <div id="u_0_s" class="_6a _m">
							
						<a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb">
						<span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
						<img src="<?php echo $SiteURL; ?>images/upload_camera.png">
						</i>Add Photo/Video<i class="_2wr"></i>
						</span>
						
						<div class="_3jk">
						<input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()">
							<span style="display: none;" id="file_upload_successs"><img src="<?php echo $SiteURL; ?>images/tick_green_small.png"></span>
						</div>
						</a>
						
					</div>

					<textarea id="add_post_text"  name="forum" class="txt_box clear_flds" /></textarea>
				</div>
				
			   <div class="private_pub_btn">
				   <div id="" class="pst_buttons">
	<div id="posting_type" class="public_new_btn">    
					<span class="pt_header pt_header1">Public</span>
						
				 <div class="radiosn">
					
					<div class="radioboxes_new">
						<div class="v2_pub">
						<input type="radio" name="post_type" checked="checked" value="public" onClick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();$('.pt_header').html('Public');"  > Public 
						<p>Anyone Can See.</p>
						</div>
						<?php 
						if($_SESSION['user_type'] == "user")
							{?>
								<div class="v2_priv"><input name="post_type"  value="private" onClick="javascript:$('#groups').show();$('#friends').show();$('#or').show();$('.pt_header').html('Private');"   type="radio" > Private 
								<p>Only Friends and Selected Groups.</p>
								</div>
								
						<?php } ?>
					</div>
					
					<div style="clear:both"></div>
				</div>
	
				</div>					
					
					<!--<label> Add Image/ Video</label>
					<input accept="image/* | video/*" id="add_post_img" type="file" name="forum_img" class="txt_box clear_flds"  style="color: #fff" onChange="return ValidateFileUpload()"/> <p class="sbtxt">(Allowed exts's : .gif, .png, .jpg, .jpeg, .mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv & .f4v)</p>
					-->  
					
					<input id="submit3" type="submit" name="submit" value="Post" class="button add_pub_p_post" style=""  />                    
					</div>
					
				  
					
					
			   </div>
			   
			</div>
			
			
						  
			
			
			<ul id="groups" style="display:none;" class="v2_privacy_fields">
			<li>
			<textarea placeholder="Send To groups" cols="50" rows="5" name="search_val" id="search_val"></textarea>
			<input type="hidden" name="group" id="txt2">
			<p>Please type first few letters</p>
			</li>
			</ul>
			
			<ul id="friends" style="display:none;"  class="v2_privacy_fields">
			<li></li>
			<li>
			<textarea placeholder="Send To Friends" cols="50" rows="5" id="search_val2" name="search_val2"></textarea>
			<input type="hidden" name="friend" id="txt_f">
			<p>Please type first few letters</p>
			</li>
			</ul>
			
			 
			
			<!--<ul class="btncenter_new new_btncenter_new" style="float: right;">

<li>

</li>
			 <li> 
				<input id="submit3" type="submit" name="submit" value="Post" class="button add_pub_p_post" style=""  />
			 </li>
		 </ul>-->
		   
				
		   </form>		
	</div>	

<?php 	} 	?>	
		 
	<div id="middle" style="min-height:329px;"  >      
		 <?php 
	$sql12 = @mysql_query("SELECT * FROM `forum` as f, `user` as u WHERE f.user_id = '$userID' AND f.user_id = u.id AND f.forum_type = 'public' AND f.status = '1' AND f.post_from = 'profile' ORDER BY `forum_id`  DESC");	
	$count = @mysql_num_rows($sql12);

$SQL = "SELECT * FROM `forum` as f, `user` as u WHERE f.user_id = '$userID' AND f.user_id = u.id AND f.forum_type = 'public' AND f.status = '1' AND f.post_from = 'profile' ORDER BY `forum_id`  DESC";
			$rowCount = 0;
	$total = 0;
	$total = $count;
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}
	else
	{
		$page = '1';
	}
	$limit = '10';  //limit
	$i=$limit*($page-1);

	$pager = Pager::getPagerData($total, $limit, $page);
	$offset = $pager->offset;
	$limit  = $pager->limit;
	$page   = $pager->page;
	$sql123 = $SQL . " limit $offset, $limit";
	$sq = @mysql_query($sql123);








		// echo "SELECT * FROM `forum` as f, `user` as u WHERE f.user_id = '$userID' AND f.user_id = u.id AND (f.forum_type = 'public' OR f.forum_type = 'public') AND f.status = '1'  ORDER BY added_on  DESC";



if(isset($_GET['id']) && $both_are_friend==0){
	if($profilename == "")
	{
		echo "<p style='color:white;font-size:17px;'>No post to show as you are not friend with ".$first_name." ".$last_name."</p>";
	}
	else
	{
		echo "<p style='color:white;font-size:17px;'>No post to show as you are not friend with ".$profilename."</p>";	
	}
	
}else{
if($count > 0)
{
	while($row = @mysql_fetch_assoc($sq))
	{
		if($row['from_user'] != '0')
		{

			//echo "SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ";
			$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");
			$fetchusersql = @mysql_fetch_array($getusersql);
			//echo "<pre>"; print_r($fetchusersql); die;
			$row['image_nm'] = $fetchusersql['image_nm'];
			$fullname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
			$pname = $fetchusersql['profilename'];
		}
		else
		{
			$row['image_nm'] = $row['image_nm'];
			$fullname = $row['first_name']." ".$row['last_name'];
			$pname = $fetchusersql['profilename'];
		}
	 
	 ?>
		<div class="post blog1 post blog1 v2_post_citytalk">   
			<div class="v2_blogpost_user">			
			<a href="#" class="pic">
				<?php
					  if($row['image_nm']==""){ ?>
						<img src="<?php echo $SiteURL; ?>images/man1.jpg" />
				<?php 
					  }else{ $imagesrc = $row['image_nm'];
				?>
						<img src="<?php echo $SiteURL.$imagesrc; ?>" />
						
				 <?php if($pname == ""){ echo $fullname; }else{ echo $pname; } ?>
				<?php } ?>
				
			</a>
            </div>
			<div class="sub_post blog_content">
					<div class="post_container_left" id="forumcontent">
                    
                    	 <div class="v2_post_container city_talk_image">
					  <?php $share_img='';if($row["forum_img"]!="") { ?>
						<a href="<?php echo $SiteURL.$row['forum_img']; ?>" rel="lightbox"><img src="<?php echo $SiteURL.$row['image_thumb']; ?>" alt="" /></a>
						
						<?php $share_img=$row["forum_img"]; } ?>
						<?php if($row["forum_video"]!="") { ?>
						<?php //echo $row['forum_video'];?>
							<a href="#dialogx" name="modal">
							<div id="a<?php echo $row["forum_id"];?>"></div>
								<script type="text/javascript">
								 jwplayer("a<?php echo $row["forum_id"];?>").setup({
									file: "<?php echo $row['forum_video'];?>",
									height : 140 ,
									width: 200
									});
								</script>
							</a>
						<?php  $share_img=$row["forum_video"];} ?>
					</div>
                    
					<div class="forumName v2_post_info v2_post_info_citytalk">
				 <h1 id="cntrls">
				 
					<div><?php echo $row['forum']; ?></div>   
				 </h1>
				 <?php
					
					if(isset($_GET['id'])){}else{
					if($row['from_user'] == $_SESSION['user_id']){ ?>
		<!-- edit controls -->
		<div class="manage_current_p_post manage">
						<a class="edit_post_pro" title="Edit" onClick="edit_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"><img src="<?php echo $SiteURL; ?>images/edti_post1.png"></a>
						<a  class="del_post_pro"  title="Delete" onClick="delete_post('<?php echo $row["common_identifier"]; ?>');" href="javascript:void(0);"><img src="<?php echo $SiteURL; ?>images/del_post.png"></a>
						</div>
					 <!-- /edit controls -->    
						 <?php }} ?>
				 </div>
				 
			
                    </div>
					<div class="comment_box commentdisplay">
						<div class="box">
							<div class="comment1 wauto">
								<?php
								  $sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."'");
									$like_tot= @mysql_num_rows($sql_like);
			 
									$sql_usr_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
									$is_like= @mysql_num_rows($sql_usr_like);
							?>
									<!-- <p id="report_error_<?php echo $row["forum_id"];?>" style="color:red; font-size:14px;"></p>
									<p id="report_send_<?php echo $row["forum_id"];?>" style="color:green font-size:14px;" ></p> -->
							<?php if($_SESSION['user_id']!="") {?>    
									<span id="glike_<?php echo $row["common_identifier"]; ?>">
						  <?php 	if($is_like <= 0) 
						  		{ 
						  ?>
									<a href="javascript:void(0);" onClick="newflike('<?php echo $row["common_identifier"];?>');">Shouts</a>
						<?php 		}
								else
								{ 
									echo "Shouts";
								}
					 	?> 		( <?php echo $like_tot; ?> )	
					 			| </span>
									<a href="javascript:void(0);" onClick="javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment</a>
									
									
									
									<?php
									$rep_abs = mysql_query("SELECT user_id FROM forum WHERE forum_id = '".$row["forum_id"]."'");
									
									$get_u_id = mysql_fetch_assoc($rep_abs);
									
									if($get_u_id['user_id'] != $_SESSION['user_id']){ ?>
									
										| <a href="javascript:void(0);" onClick="reportabuse('<?php echo $row["forum_id"];?>');">Report Abuse</a> 								
									<?php } ?>
	
							<?php } ?>
							</div>
							
						</div>
					    <div class="box2">
							<div class="like">
								<!-- <a href="javascript:void(0);"  <?php //if($is_like <= 0) { ?> onclick="flike('<?php //echo $row["forum_id"];?>');" <?php //} ?>>
									<img src="images/like.jpg" />
								</a> -->
							</div>
							<div class="icons">
 
							   
					<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onClick="return fbs_click('https://www.mysitti.com/<?php echo $share_img;?>', 'mysitti.com' )" target="_blank" style="text-decoration:none;"><img src="<?php echo $SiteURL; ?>fbook.png" alt="Share on Facebook"/></a>	
					
					<a href="#" onClick="return fbs_click123('https://www.mysitti.com/<?php echo $share_img;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="<?php echo $SiteURL; ?>twt.png" alt="Share on Twitter"/></a>				
					
					<a href="https://plus.google.com/share?url=https://www.mysitti.com/<?php echo $share_img;?>" onClick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?php echo $SiteURL; ?>g+.png" alt="Share on Google+"/></a>
				   
							</div>
						</div>
						<div class="cmnts_container" id="comment_all_<?php echo $row["forum_id"];?>">
							<?php
	
								$find = mysql_query("SELECT * FROM forum_comment where forum_id='".$row["forum_id"]."' ORDER BY id ASC");
								
									$count_comments = mysql_num_rows($find);
									?>
									<input type="hidden" id="num_comments_<?php echo $row['forum_id'];?>" value="<?php echo $count_comments; ?>" />
									<input type="hidden" id="set_show_val_<?php echo $row['forum_id']; ?>" value="0">
									<div class="box3 input_comment_area show_all_comments" id="show_count_comments_<?php echo $row["forum_id"]; ?>">
									
										<div class="box4">
											<div class="show_cmnt" onClick="show_all_comments('<?php echo $row['forum_id']; ?>');" id="show_cm_<?php echo $row['forum_id']; ?>">Show comments : <?php echo $count_comments; ?></div>
											<div class="hide_cm" onClick="hide_all_comments('<?php echo $row['forum_id']; ?>');" id="hide_cm_<?php echo $row['forum_id']; ?>">Hide all comments</div>
											
										</div>
		
							
									</div>						
								
								<?php
								$row_i = 0;
								while($row2 = @mysql_fetch_assoc($find)){
									
									if($row_i == 0){ ?>
									
									<div class="box3 box3_hide_rep hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">
 
									 <!-- <div class="pic1"> -->
									<?php
									if($row2['user_type'] == 'club')
									{
										$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
									}
									else
									{
										$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
									}
									
									$getdet = @mysql_fetch_assoc($getuser);
									
									?>
									
									
										<?php if($getdet['image_nm']=="") { ?> 
												<img src="<?php echo $SiteURL; ?>images/pic1.jpg" />
										<?php }else{ ?>
												<img width='40' height='40' src="<?php echo $SiteURL.$getdet['image_nm']; ?>"  />
										<?php } ?>
									<!-- </div> -->
								<p>
									<?php 
										if($_SESSION['user_id'] != '')
										{
									?>
										<!-- <img onclick="delete_comment('<?php echo $row2['id']; ?>');" width="16px" height="16px" src="images/del.png" style="float: right; cursor: pointer;"> -->
									<?php 

										}
									?>
									
									<?php 
										if($row2['user_type'] == 'club')
										{
											?>
											
											 <a class="commentuser"><?php echo $getdet['club_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
										else
										{
											?>
											 <a class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
									?>
 
									</div>									
									
									<?php }else{ ?>
									
									<div class="box3 box3_hide_rep onload_comments hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">

									<!-- <div class="pic1"> -->
									<?php
									if($row2['user_type'] == 'club')
									{
										$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
									}
									else
									{
										$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
									}
									
									$getdet = @mysql_fetch_assoc($getuser);
									
									?>
									
									
										<?php if($getdet['image_nm']=="") { ?> 
												<img src="<?php echo $SiteURL; ?>images/pic1.jpg" />
										<?php }else{ ?>
												<img width='40' height='40' src="<?php echo $getdet['image_nm']; ?>"  />
										<?php } ?>
									<!-- </div> -->
								<p>
									<?php 
										if($_SESSION['user_id'] != '')
										{
									?>
										<!-- <img onclick="delete_comment('<?php echo $row2['id']; ?>');" width="16px" height="16px" src="images/del.png" style="float: right; cursor: pointer;"> -->
									<?php 

										}
									?>
									
									<?php 
										if($row2['user_type'] == 'club')
										{
											?>
											
											 <a class="commentuser"><?php echo $getdet['club_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
										else
										{
											?>
											 <a class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
									?>									
									
									</div>									
									
									
									<?php } ?>

							<?php $row_i++; } ?>
						</div>
						
						<?php if($_SESSION['user_id']!=""){ ?>
						
						<div class="box3 input_comment_area">
							<input type="hidden" id="fid_<?php echo $row["forum_id"];?>" value="<?php echo $row["forum_id"];?>">

							<div class="comment_txt">
								<input name="comment"  onkeydown="javascript:return submitcom(event,'<?php echo $row["forum_id"];?>');"   id="content_<?php echo $row["forum_id"];?>" type="text" placeholder="Write a comment.." value=""/>
							</div>
							
							<div align='center'>
								<input name="button" class="button btn_sub_comnt" id="co_submit_<?php echo $row["forum_id"]; ?>"  onclick="addform('<?php echo $row["forum_id"];?>');" type="button" value="Add Comment" />
								<img id="comment_load_<?php echo $row["forum_id"]; ?>" src="<?php echo $SiteURL; ?>images/loading-plz.gif" style="margin: -19px 0px 0px 10px; display: none;">
							</div>
							
							<div id="comsuc_<?php echo $row["forum_id"];?>" style="float:right; color:green; display:none;"></div>
							<div class="pro_error" id="com_error<?php echo $row["forum_id"];?>" style="float:right; color:red; display:none;"></div>
						</div>
						

						<?php } ?>
						
						
					</div>
				 
			</div>
		</div>
		 
<?php 

	} 

?>
		   <?php if(!isset($_GET['id'])) { ?>
		   <!-- <div id="submit_btn" style="float:right; color:red; text-align: center;"><a style="font-size: 14px;width: 86px; margin-left: 12px;"  id="modal_trigger2" href="#modal" class="button">Add Post</a></div> -->
		   <?php }
		   
if(isset($_GET['id'])){

	$p_id = "&id=".$_GET['id'];
}		   

echo '<div class="pagination">';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$p_id.'"><span title="First">&laquo;</span></a>';
		if ($page <= 1)
			echo "<span>Previous</span>";
		else            
			//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."'><span>Previous</span></a>";
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1).$p_id."'><span>Previous</span></a>";
		echo "  ";
		for ($x=1;$x<=$pager->numPages;$x++){
			echo "  ";
			if ($x == $pager->page)
				echo "<span class='active'>$x</span>";
			else
				echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x.$p_id."'><span>".$x."</span></a>";
		}
		if($page == $pager->numPages) 
			echo "<span>Next</span>";
		else           
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1).$p_id."'><span>Next</span></a>";
								
		echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages.$p_id."'><span title='Last'>&raquo;</span></a>";
echo "</div>";		   
		   
}
else
{
		echo "<p id='errormessage' style='display:block;'>No Posts Yet.</p>";
}
}
 ?>
		 
   </div>				
				
				
				</div>
			</div>
		</div>
		<div class="equalizer">
		</div>	
	</article>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	




</div></div>
<?php include('Footer.php'); ?>

<!--<script src='js/jqueryvalidationforsignup.js'></script>-->
<!--<script src="js/register.js" type="text/javascript"></script> -->
<script type="text/javascript">
	$( document ).ready(function() {
		$(".pt_header").click(function() {
			//$(".radioboxes_new").slideToggle();
			if($(".radiosn").css("display")!=="block"){
				$(".radiosn").show("fast");
				$(".pt_header").css("background-position","83% 6px");
				}
			else{
				$(".radiosn").hide("fast");
				$(".pt_header").css("background-position","83% -26px");
				}
		});

	$(".radioboxes_new input").click(function() {
		$(".radiosn").slideUp();
		 
			if($(".radiosn").css("display")!=="block"){
			$(".radiosn").show("fast");
			$(".pt_header").css("background-position","83% 6px");
			}
			else{
			$(".radiosn").hide("fast");
			$(".pt_header").css("background-position","83% -26px");
			}

		 
		});
		

	});
</script>

<script type="text/javascript">
	function ValidateFileUpload(){
			var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
				alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
				$('#js_0').val('');
			}else{
				$('#file_upload_successs').show();
			}
	}
	
function validate_forum()
{
	
   var value = $('#add_post_text').val();
   if( $('#add_post_text').val() == "" || $('#add_post_text').val() == " " || value < 1)
   {
		alert( "Please provide post title!" );
		document.forum.forum.focus();
		return false;
	}
}		

function edit_post(id){
	
	jQuery("html, body").animate({ scrollTop: jQuery("#title").offset().top }, "slow");
	
	jQuery.post('edit_profile_post.php', {'forum_id': id}, function(response){
		
		jQuery("#ad_new_pst").show();
		jQuery("#ad_profile_pst").empty();
		jQuery("#ad_profile_pst").html(response);
		
	});
}

function delete_post(id){
	
	var r = confirm("Are you sure want to delete !");
	if (r == true) {

	 $.get( "deletepost.php?id="+id, function( data ) {
			window.location = "";
		});
	
	}
}
</script>