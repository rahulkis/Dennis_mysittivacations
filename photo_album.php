<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID = $_SESSION['user_id'];

// echo "<pre>"; print_r($_SESSION);exit;

// if(!isset($_SESSION['user_id'])){
// 	$Obj->Redirect($SiteURL);
// }
$titleofpage="Photo Album";
if(!isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');
}
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

if(isset($_GET['host_id']))
{
	$userID=$_GET['host_id'];
}
elseif(isset($_REQUEST['id'])){
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
if(isset($_POST['delete_photo']))
{

	foreach($_POST['delete_photo'] as $row)
	{
		$getimagePath = mysql_query("SELECT * FROM `uploaded` WHERE `img_id` = '$row' ");
		while($result = mysql_fetch_assoc($getimagePath))
		{
			unlink($result['img_name']);
			unlink($result['thumbnail']);
		}
	}


 	$ids=implode(",",$_POST['delete_photo']);
	$del=mysql_query("delete from uploaded where img_id IN(".$ids.")");
	if($del)
	{	
		$Obj->Redirect("photo_album.php?manage_album=".$_GET['manage_album']."&msg=deleted");
		die;
  	}
}


if(isset($_POST['delete_album']))
{

	foreach($_POST['delete_album'] as $row)
	{
		$getimagePath = mysql_query("SELECT * FROM `photo_album` WHERE `album_id` = '$row'");
		while($result = mysql_fetch_assoc($getimagePath))
		{
			unlink($result['album_cover']);
			unlink($result['album_cover_thumbnail']);
		}
	}

	foreach($_POST['delete_album'] as $row2)
	{
		if($row2 != 0){

			$getimagePath = mysql_query("SELECT * FROM `uploaded` WHERE `album_id` = '$row2'");
			while($result = mysql_fetch_assoc($getimagePath))
			{
				unlink($result['img_name']);
				unlink($result['thumbnail']);
			}
		}
	}


 	$ids=implode(",",$_POST['delete_album']);
	if($ids != 0){

		mysql_query("delete from uploaded where album_id IN(".$ids.")");
	}
	
 	$ids2 = implode(",",$_POST['delete_album']);

	mysql_query("delete from photo_album where album_id IN(".$ids2.")");

	$Obj->Redirect("photo_album.php?msg=album_deleted");
	die;
}
?>
<script>
function ValidateFileUpload(){
		var check_image_ext = $('#image_file').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#image_file').val('');
		}
}
	
	
function validate_image()
{
	if(document.getElementById('image_file').value== "" )
	 {
		alert( "Please provide image!" );
		document.getElementById('image_file').focus() ;
		return false;   
	}
	alert(getExtension(document.getElementById('image_file').value).toLowerCase());

}
</script>

<?php
if(isset($_REQUEST['like_img_id']))
	{
	 $like_img_id = $_REQUEST['like_img_id'];
	 $action=$_REQUEST['action'];
	 $img_user_id=$_REQUEST['img_user_id'];		
	 $who_like_id=$_SESSION['user_id'];
		if($action=="like")
		{
			$ThisPageTable='like_img_video';
			$ValueArray = array($who_like_id,$img_user_id,$like_img_id);
			$FieldArray = array('like_user_id','photo_user_id','img_id');
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		}
		else
		{
			$like_img_id = $_REQUEST['like_img_id'];
			$delete = "delete from like_img_video where img_id ='".$like_img_id."' && like_user_id='".$who_like_id."'";
			mysql_query($delete);			
		}
		
		if($_SESSION['user_id']!=$_REQUEST['img_user_id']){	
			$Obj->Redirect("upload_photo.php?id=".$img_user_id);
		}
		else{
			$Obj->Redirect("upload_photo.php");
		}
	 $sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE img_id='".$like_img_id."'");
	$total_like= mysql_num_rows($sql_total_like);
   }

   
   
   
   
   
   
   
   
   
if(isset($_POST['save_album']))
{

		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["album_cover"]["name"]);

		$extension = end($temp);
		
		if ((($_FILES["album_cover"]["type"]== "image/gif")
		|| ($_FILES["album_cover"]["type"] == "image/jpeg")
		|| ($_FILES["album_cover"]["type"] == "image/jpg")
		|| ($_FILES["album_cover"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts))
		{
			
			echo "<pre>"; print_r($_FILES); echo "</pre>";
			
			$get_extension = explode("image/", $_FILES["album_cover"]["type"]);
			$ext = ".".$get_extension[1];
			$file_name = $_FILES['album_cover']['name'];
			$tmp = $_FILES['album_cover']['tmp_name'];
			$img_path = "_".time().strtotime(date("Y-m-d")).$ext;
			$path = "upload/".$img_path;	
			$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$file_name."_thumbnail".$ext;
			$thumbnail = "upload/".$thumb;	
			move_uploaded_file($tmp,$path);

			
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
			$resizeObj -> resizeImage(500, 350, 'auto');
			//$resizeObj -> resizeImage(300,200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);		
			
		}
		else
		{
			$Obj->Redirect("photo_album.php?msg=imagefail");
			die;
		}
		
		/**/
		
		/**/
		$imageTitle = mysql_real_escape_string($_POST['album_name']);
				
					$ValueArray = array($imageTitle,$userID,$_SESSION['user_type'],$path,$thumbnail);
					$FieldArray = array('album_title','user_id','user_type','album_cover','album_cover_thumbnail');
					$ThisPageTable="photo_album";	
					$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

		if($Success)
		{
			if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')
			{
				$Obj->Redirect("photo_album.php?msg=album_uploaded");
				die;
			}
			else
			{
				$Obj->Redirect("photo_album.php?msg=album_uploaded");
				die;
			}
		}
		
}










if(isset($_POST['submit']))
{
	$no=count($_FILES['file']['name']);

//echo "<pre>"; print_r($_FILES); exit;

	for ($i=0;$i<$no;$i++)
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		$temp = explode(".", $_FILES["file"]["name"][$i]);
		$extension = end($temp);
		
		if ((($_FILES["file"]["type"][$i] == "image/gif")
		|| ($_FILES["file"]["type"][$i] == "image/jpeg")
		|| ($_FILES["file"]["type"][$i] == "image/jpg")
		|| ($_FILES["file"]["type"][$i] == "image/png"))
		&& in_array($extension, $allowedExts))
		{
			$file_name=$_FILES['file']['name'][$i];
			$tmp=$_FILES['file']['tmp_name'][$i];
			$ext =substr($file_name,strrpos($fname,'.'));
			$img_path = "_".time().strtotime(date("Y-m-d")).$i.$ext;
			$path="upload/".$img_path;	
			$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$file_name."_thumbnail".$ext;
			$thumbnail = "upload/".$thumb;	
			move_uploaded_file($tmp,$path);

			
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
			$resizeObj -> resizeImage(500, 350, 'auto');
			//$resizeObj -> resizeImage(300,200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);		
			
		}
		else
		{
			$Obj->Redirect("upload_photo.php?msg=imagefail");
			die;
		}
		
		/**/
		
		/**/
			$imageTitle = mysql_real_escape_string($_POST['image_title']);
			$album_id = $_POST['selected_album'];

			$ValueArray = array($imageTitle,$userID,$_SESSION['user_type'],$path,$thumbnail,'', $album_id);
			$FieldArray = array('image_title','user_id','user_type','img_name','thumbnail','uploaded_img_type', 'album_id');
			$ThisPageTable = "uploaded";
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

		}
		if($Success)
		{
			if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')
			{
				$Obj->Redirect("upload_photo.php?msg=uploaded");
				die;
			}
			else
			{
				$Obj->Redirect("upload_photo.php?msg=uploaded");
				die;
			}
		}
		
}

if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')
{
	$sql = "select * from `clubs` where `id` = '".$userID."'";
	$userArray = $Obj->select($sql) ; 
	$first_name=$userArray[0]['club_name'];	
	$zipcode=$userArray[0]['zip_code'];
	$state=$userArray[0]['club_state'];
	$city=$userArray[0]['club_city'];
	$country=$userArray[0]['club_country'];		
	$email=$userArray[0]['club_email'];
	$image_nm=$userArray[0]['image_nm'];
	$phone=$userArray[0]['club_contact_no'];
	
	if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
}else
{
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
}
  /******************/

/* to update photo privacy */
if(isset($_POST['privacytype']))
{	
	$privacytype = $_POST['privacytype'];
	$added_on = date("Y-m-d h:i:s");
	$city = $_SESSION['id'];
	$status = 1;
	$common_identifier = date("Ymdhis");
	$ThisPageTable='forum';
	$state = $_SESSION['state'];
	$country = $_SESSION['country'];
	$user_type = $_SESSION['user_type'];
	$img_id =$_POST['img_id'];
	$getimage = mysql_query("SELECT * FROM uploaded WHERE img_id = '$img_id' ");
	$result12 = mysql_fetch_array($getimage);
	$forum_thumb = $result12['thumbnail'];
	$forum_img = $result12['img_name'];
	$title = mysql_real_escape_string($_POST['title']);



	if($privacytype == 'blog_page'){
		
		$ValueArray = array(date('YmdHis'),$_SESSION['user_id'],'blog',$_SESSION['user_type'],$forum_thumb,$title,$forum_img,'',$_SESSION['user_id'],$added_on,$city,'public',$status,'','');
		$FieldArray = array('common_identifier','from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		
	}	
	
	if($privacytype == 'city_talk'){
		
		mysql_query("INSERT INTO forum (`common_identifier`,`forum`, `forum_img`, `image_thumb`, `forum_video`, `user_id`, `added_on`, `city_id`, `state_id`, `country_id`, `status`, `user_type`, `from_user`, `post_from`, `forum_type`) VALUES ('$common_identifier','".$title."', '".$forum_img."', '".$forum_thumb."', '', '".$_SESSION['user_id']."', '".$added_on."', '".$city."', '".$state."', '".$country."', '".$status."', '".$user_type."', '".$_SESSION['user_id']."', 'city_talk', 'public')");
		
	}
	
	if($privacytype == 'profile_post'){
		
				$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],$forum_thumb,$title,$forum_img,'',$_SESSION['user_id'],$added_on,$city,'public',$status,"","", $common_identifier);
				
				$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
				
				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);		
		
	}	




/*
COMMENT FOR FURTHER USE


	if($privacytype == "public")
	{
		$post_from = "profile";
	}
	else
	{
		$post_from = "clique";
	}	
	
	
	$user_id =$_POST['user_id'];
	$title = mysql_real_escape_string($_POST['title']);
	mysql_query("update uploaded set uploaded_img_type='".$privacytype."' where user_id=".$user_id." AND img_id=".$img_id." ");
	$getimage = @mysql_query("SELECT * FROM uploaded WHERE img_id = '$img_id' ");
	$result12 = @mysql_fetch_array($getimage);
	$forum_thumb = $result12['thumbnail'];
	$forum_img = $result12['img_name'];

	$checkquery = mysql_query("SELECT * FROM `forum` WHERE `forum_img` LIKE '%$forum_img%' ");
	$countrows = mysql_num_rows($checkquery);
	$checkres = mysql_fetch_array($checkquery);
	if($countrows > 0)
	{
		mysql_query("UPDATE `forum` SET `post_from` = '".$post_from."'  ,`forum_type` = '".$privacytype."', `forum` = '".$title."' WHERE `forum_id` = ".$checkres['forum_id']." ");
	}
	else
	{
		$sqlprivacy="INSERT INTO `forum` (`forum_id`,`image_thumb`,`forum`,`forum_img`,`forum_video`,`user_id`,`added_on`,`city_id`,`forum_type`,`status`,`friends_id`,`group_id`,`user_type`,`post_from`)
					VALUES ('','".$forum_thumb."','".$title."','".$forum_img."','','".$user_id."', NOW(),'".$city."','".$privacytype."','1','','','".$_SESSION['user_type']."', '".$post_from."' )";
		
					
		mysql_query($sqlprivacy);
		
		die;
	}
	*/
	
}

/* ends here */  

?>
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<style>

#lean_overlay{
  opacity: 0.79 !important;
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
margin:0 10px 0 0;
}
</style>

<script>
	function postprivacy12(type,img_id,user_id){	
		if(type=="public"){
			
			val=0;
			$('#posttype').addClass('public');
		}else{
			
			val=1;
			$('#posttype').addClass('private');
		}
		$('#modal112').css('display','block');
		$('#posttype').val(img_id);

	}

	function hostposttoforum(posttype,img_id)
	{
		$('#modal112').css('display','block');
		$('#posttype').val(img_id);
		$('#posttype').addClass('public');	
	}

$(document).ready(function() {
	$('a').smoothScroll({
		speed: 1000,
		easing: 'easeInOutCubic'
	});
	  
$('.modal_close').on('click',function(){

	$('#posttype').val('');
	$('#posttype').removeClass('private');
	$('#posttype').removeClass('public');
	$('#modal112').css('display','none');
	$('.v2_signup_overlay').hide();
});

   	$('#deletephoto').click(function() {

		if ($('.others').is(':checked')) {
			var confm = confirm("Are you sure want to delete ?");
			if(confm == true)
			{
				$('#photos').submit();
			}

		}else
		{
			alert("Please select atleast one Photo!");
		}
	});
	
   	$('#deletealbum').click(function() {

		if ($('.others').is(':checked')) {
			var confm = confirm("Are you sure want to delete ?");
			if(confm == true)
			{
				$('#albums').submit();
			}

		}else
		{
			alert("Please select atleast one Album!");
		}
	});	
	

  	$('.showOlderChanges').on('click', function(e){
		$('.changelog .old').slideDown('slow');
		$(this).fadeOut();
		e.preventDefault();
	});
	$(".modal_trigger").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
	$(".modal_trigger2").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
	  
});

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  


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
			data: "imgId="+iD+"&title="+updateText+"&action=changeTitle&type=photo",
			success: function(result){
				//alert("Photo added as "+ type + " Successfully");
				//location.reload(true);
				$('#image_'+iD).html(result);
				$('#image_'+iD).attr('onclick', 'changeTitle("'+imgid+'")');
			}
		});
		event.preventDefault();
	}
}
 

</script>	

<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php
		if(isset($_GET['id']))
		{
			include('friend-profile-panel.php');  	
		}
		elseif(isset($_GET['host_id']))
		{
			include('host_left_panel.php');
		}
		elseif($_SESSION['user_type'] == "user" && !isset($_GET['id']))
		{
			include('friend-right-panel.php');
		}
		elseif($_SESSION['user_type'] == "club")
		{
			include('club-right-panel.php');
		}
	?>

	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<div class="upload_photo_main">
						<?php
							if($_GET['msg'] == "uploaded")
							{

								echo '<div id="successmessage" style="display: block;">Image Uploaded Successfully</div> ';
							}
							elseif ($_GET['msg'] == "imagefail") 
							{
								# code...
								echo '<div id="errormessage" style="display: block;">Image failed to upload!</div> ';
							}
							elseif ($_GET['msg'] == "deleted") 
							{
								# code...
								echo '<div id="successmessage" style="display: block;">Images deleted successfully</div>';
							}elseif($_GET['msg'] == "album_uploaded"){
								
								echo '<div id="successmessage" style="display: block;">Album Created successfully</div>';
							}
						?>

						<div class="media_collection">
							<div class="meadia_tabs">
								<ul>
									<?php if(isset($_GET['id'])){ ?>
									
										<li>
											<a href="upload_photo.php?id=<?php echo $_GET['id']; ?>">Photos</a>
										</li>
										<li class="activem">
											<a href="photo_album.php?id=<?php echo $_GET['id']; ?>">Albums</a>
										</li>										
									<?php } elseif(isset($_GET['host_id'])){ ?>
									
										<li>
											<a href="upload_photo.php?host_id=<?php echo $_GET['host_id']; ?>">Photos</a>
										</li>
										<li class="activem">
											<a href="photo_album.php?host_id=<?php echo $_GET['host_id']; ?>">Albums</a>
										</li>
									<?php }else{ ?>
									
										<li>
											<a href="upload_photo.php">Photos</a>
										</li>
										<li class="activem">
											<a href="photo_album.php">Albums</a>
										</li>										
									
									<?php } ?>

								</ul>
							</div>
						</div>

						<?php if(isset($_GET['manage_album'])){
						
						$album_title = mysql_query("SELECT album_title FROM photo_album WHERE album_id = '".$_GET['manage_album']."'");
						$set_album_title = mysql_fetch_assoc($album_title);
						?>
						
							<h3 id="title">Photo Album: <?php echo $set_album_title['album_title']; ?></h3>
						
						<?php }else{ ?>
						
							<h3 id="title">Photo Albums</h3>
						
						<?php } ?>	
						
						<div class="album_main createalbum">
						<input type="button" class="button" id="addAlbum" value="Add Album" style="margin-left:15px;">
							
							
						</div>
						
						<?php if(isset($_GET['manage_album'])){ ?>
						
						
						<?php

							$sql = "select * from `clubs` where `id` = '".$userID."'";
							$userArray = $Obj->select($sql) ;

							if(isset($_GET['host_id'])){
								$swl= "SELECT * FROM `uploaded` WHERE `user_id` = '".$_GET['host_id']."' and user_type='club' and album_id = '".$_GET['manage_album']."'";
							}elseif(isset($_GET['id'])){
								$swl= "SELECT * FROM `uploaded` WHERE `user_id` = '".$_GET['id']."' and user_type='user' and album_id = '".$_GET['manage_album']."'";
							}else{
								$swl= "SELECT * FROM `uploaded` WHERE `user_id` = '".$userID."' and user_type='".$_SESSION['user_type']."' and album_id = '".$_GET['manage_album']."'";
							}
							
							$sql_img = mysql_query( $swl);

							$img_count= mysql_num_rows($sql_img);

							if(!isset($_GET['host_id']) && !isset($_GET['id'])){ ?>
							<div class="delealbum">
							<!--input type="button" id="modal_trigger" href="#modal" class="button" value="Add Post" -->&nbsp;&nbsp;
							 <input type="button" class="button deletephoto"  id="deletephoto" value="Delete" style="margin-left:15px;">
						     
						 </div>
							<? } ?>
						   
							<form name="photos" id="photos" method="post">
							<div style=" border: 1px solid yellow;display:none;  
							color: white;
							float: left;
							font-size: 18px;
							margin-top: 11px;
							padding: 10px;
							text-align: center;
							width: 97%;" id="error"></div>
						   
							<div class="uploadphotos"> 

							<div class="photos_row">
							<?php
							if($img_count==0){
							?>
								<div class="err">
							<?php echo "No Image available";	
							 ?>
							</div>	
							<?php
							} 
							$i=0;
							while($row = mysql_fetch_array($sql_img))
								{ 
								$sql_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE `like_user_id` = '".$_SESSION['user_id']."' && img_id='".$row["img_id"]."'");
								$is_like= mysql_num_rows($sql_like);
								$sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE img_id='".$row["img_id"]."'");
								$total_like= mysql_num_rows($sql_total_like);
								?>
								<div class="photodata uploadPhotos">   
								<? if(!isset($_GET['host_id']) && !isset($_GET['id'])){
									
									if(empty($row['image_title'])){
										$image_title = "Shared Photo";
									}else{
										$image_title = $row['image_title'];
									}
									?>
									
								<div class="check_del">
									<input type="checkbox" name="delete_photo[]" value="<?php echo $row['img_id']; ?>" class="others">
									<span><?php echo $userArray['club_name']; ?></span>
								</div>
								
								<div class="sharepro">
									<img src="images/share1.png" alt="Share on Facebook"/>  Share
									<div class="photoSharePro">
										<ul>
										
										<?php if($_SESSION['user_type'] == 'club'){ ?>
										<li>
											<a onclick="share_photo('<?php echo $row["thumbnail"]; ?>', '<?php echo $row['img_name']; ?>', '<?php echo $image_title; ?>', 'blog_page','<?php echo $row['img_id'];?>');" href="javascript: void(0);" title="Blog Page">Blog Page</a>
										</li>		
										<?php } ?>											
																			
										
										<?php if($_SESSION['user_type'] == 'user'){ ?>
										<li>
											<a onclick="share_photo('<?php echo $row["thumbnail"]; ?>', '<?php echo $row['img_name']; ?>', '<?php echo $image_title; ?>', 'profile_post','<?php echo $row['img_id'];?>');" href="javascript: void(0);" title="Profile Post Page">Profile Posts</a>
										</li>
										<?php } ?>											
										
										<li>
											<a onclick="share_photo('<?php echo $row["thumbnail"]; ?>', '<?php echo $row['img_name']; ?>', '<?php echo $image_title; ?>', 'city_talk','<?php echo $row['img_id'];?>');" id="city_talk_share" href="javascript: void(0);" title="City Talk Page">City Talk</a>											
										</li>
										</ul>
									</div>
								</div>
								
								<div class="sharebox">
									<div class="photoShare">
										<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onClick="return fbs_click('https://www.mysittidev.com/<?php echo $row['img_name']; ?>', 'mysittidev.com' )" target="_blank" style="text-decoration:none;"><img src="fbook.png" alt="Share on Facebook"/></a>	
											
										<a href="#" onClick="return fbs_click123('https://www.mysittidev.com/<?php echo $row['img_name']; ?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="twt.png" alt="Share on Twitter"/></a>				
											
										<a href="https://plus.google.com/share?url=https://www.mysittidev.com/<?php echo $row['img_name']; ?>" onClick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="g+.png" alt="Share on Google+"/></a>
									</div>
						         </div>
								
								<? } ?>
						        <div class="clear"></div>
								<a class="fancybox photo_thumb_bx uploadbox" rel="group" style="margin-bottom:5px;" href="<?php echo $row['img_name']; ?>"><img src="<?php echo $row["thumbnail"]; ?>"  /></a> 
								<span 	<?php if($_SESSION['user_type'] == $row['user_type'] && $_SESSION['user_id'] == $row['user_id']) {?>onclick="changeTitle(this.id);" <?php } ?> class="imageTitle" style="color: #FFF;cursor: pointer;" id="image_<?php echo $row['img_id']; ?>">
									<?php if($row['image_title'] != ""){ echo $row['image_title']; }else{ echo  "&nbsp;"; } ?>
								</span>
								 </div>
								<?
									$i++;
									if($i==4)
									{
									$i=0;
									?>
									</tr><tr>
									<?	
									}
								 }
								 ?>
								 </div>
								 </div>
								 </form>						
						
						
						
						<?php }else{

							$sql = "select * from `clubs` where `id` = '".$userID."'";
							$userArray = $Obj->select($sql) ;

							if(isset($_GET['host_id'])){
								$swl= "SELECT * FROM `photo_album` WHERE `user_id` = '".$_GET['host_id']."' and user_type='club'";
							}elseif(isset($_GET['id'])){
								$swl= "SELECT * FROM `photo_album` WHERE `user_id` = '".$_GET['id']."' and user_type='user'";
							}else{
								$swl= "SELECT * FROM `photo_album` WHERE `user_id` = '".$userID."' and user_type='".$_SESSION['user_type']."'";
							}
							
							$sql_img = mysql_query( $swl);

							$img_count= mysql_num_rows($sql_img);

							if(!isset($_GET['host_id']) && !isset($_GET['id'])){ ?>
							
							<div class="uploadbuttons delalbum">
							<!--input type="button" id="modal_trigger" href="#modal" class="button" value="Add Post" -->&nbsp;&nbsp;
							 <input type="button" class="button deletephoto"  id="deletealbum" value="Delete Album" style="margin-left:15px;">
						     
						 </div>
							<? } ?>
						   
							<form name="photos" id="albums" method="post">
							<div style=" border: 1px solid yellow;display:none;  
							color: white;
							float: left;
							font-size: 18px;
							margin-top: 11px;
							padding: 10px;
							text-align: center;
							width: 97%;" id="error"></div>
						   
							<div class="uploadphotos"> 

							<div class="photos_row">
							<?php
							if($img_count==0){
							?>
								<div class="err">
							<?php echo "No Image available";	
							 ?>
							</div>	
							<?php
							} 
							$i=0;
							while($row = mysql_fetch_array($sql_img))
								{
									
									
									//echo "<pre>";
									//print_r($row);
									//echo "</pre>";
									
								?>
								<div class="photodata uploadPhotos photoAlbum">   
								<? if(!isset($_GET['host_id']) && !isset($_GET['id'])){
									
									if(empty($row['image_title'])){
										$image_title = "Shared Album";
									}else{
										$image_title = $row['album_title'];
									}
									?>
									
								<div class="check_del">
									<input type="checkbox" name="delete_album[]" value="<?php echo $row['album_id']; ?>" class="others">
									<span><?php 
									$getHo = mysql_fetch_assoc(mysql_query("SELECT club_name FROM clubs WHERE id = ".$row['user_id'].""));
									echo $userIDHo = $getHo['club_name'];
									//echo $row['user_id']; ?></span>
								</div>

								
								<?php } ?>
								
						        <div class="clear"></div>

								<?php
								$counter = 1;
								
								if(isset($_GET['id'])){
									
									$album_user_id = $_GET['id'];
									$album_user_type = 'user';
									
								}
								elseif(isset($_GET['host_id'])){
									
									$album_user_id = $_GET['host_id'];
									$album_user_type = 'club';
									
								}else{
									
									$album_user_id = $_SESSION['user_id'];
									$album_user_type = $_SESSION['user_type'];									
									
								}
								
								$get_album_photos = mysql_query("SELECT * FROM uploaded WHERE album_id = '".$row['album_id']."' AND user_id = '".$album_user_id."' AND user_type = '".$album_user_type."'");
								$count_album_photos = mysql_num_rows($get_album_photos);
								
								if($count_album_photos < 1){ ?>
								
									<script type="text/javascript">
									$(document).ready(function(){
										$(".fancybox_<?php echo $row['album_id']; ?>").fancybox();
									});
									</script>								
								<div class="albumCover">
									<a class="fancybox_<?php echo $row['album_id']; ?> photo_thumb_bx uploadbox 1234" rel="group" style="margin-bottom:5px;" href="<?php echo $row['album_cover']; ?>">
										<img src="<?php echo $row["album_cover_thumbnail"]; ?>"  />
									</a>	
								</div>
								<?php }else{
								$counter = 1;
								while($album_photo_row = mysql_fetch_assoc($get_album_photos)){ ?>
									
									<script type="text/javascript">
									$(document).ready(function(){
										$(".fancybox_<?php echo $row['album_id']; ?>").fancybox();
									});
									</script>
									
									
									<?php
									if($counter > 1){
										$photo_hidden = "style='display: none;'";
									}else{
										$photo_hidden = "style='display: block;'";
									}
									?>
			
									<a <?php echo $photo_hidden; ?> class="1111 fancybox_<?php echo $row['album_id']; ?> photo_thumb_bx uploadbox" rel="group" style="margin-bottom:5px;" href="<?php echo $album_photo_row['img_name']; ?>">
										<img src="<?php echo $row["album_cover_thumbnail"]; ?>"  />
									</a>			
      
									
								<?php $counter++; }} ?>
								
									<span class="albTitle">
										<?php if($row['album_title'] != ""){ echo $row['album_title']; }else{ echo  "&nbsp;"; } ?>
									</span>
									
									<?php if(!isset($_GET['host_id']) && !isset($_GET['id'])){ ?>
									<!-- <span class="manageAlbum">
											<a href="photo_album.php?manage_album=<?php echo $row['album_id']; ?>">Manage Album</a>
										</span> -->
									<?php } ?>
								 </div>
								<?
									$i++;
									if($i==4)
									{
									$i=0;
									?>
									</tr><tr>
									<?	
									}
								 }
								 ?>
								 </div>
								 </div>
								 </form>						
						
						
						<?php } ?>
						
						</div>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<style>
.popupContainer{
   top: 47px !important;
}

</style>
<!-- <script src="js/lk.popup.js"></script> -->
<style type="text/css">
#popup2 {
	position:fixed;
	width:400px;
	height:auto;
	overflow:auto;
	background:#000;
	z-index:2;
	top: 100px !important;
}
#popup2 span#close {
	float:right;
	margin:10px;
	color:#fff;
	font-weight:bold;
}
#popup, .bMulti {
	background-color: #000;
	border-radius: 10px;
	color: #111;
	padding: 25px;
	display: none;
}
#popup2 span.b-close {
	border: none;
	float: right;
	min-width:auto!important
}
.b-modal {
	display: none;
	position:fixed;
	left:0;
	top:0;
	height:100%;
	background:#000;
	z-index:99;
	opacity: 0.5;
	filter: alpha(opacity = 50);
	zoom:1;
	width:100%;
}
#popup2 {
	background-color: #000;
	border: 5px solid #fecd07;
	border-radius: 10px;
	bottom: 0;
	box-shadow: none !important;
	color: #111;
	display: none;
	height: 500px;
	left: 0 !important;
	margin: auto;
	max-width: 400px;
	overflow: auto;
	padding: 0;
	position: fixed;
	right: 0;
	top: 0 !important;
	width: 100%;
	z-index: 2147483647 !important;
}
</style>
<div id="modal112" class="popupContainer" style="display:none; height: 260px; width:498px; margin-top:38px; top:84px!important; left: 30% !important; position: fixed; z-index:33333;">
	
	  <div class="header_title popheaderzx" style="border-bottom: 1px solid #808080;
  color: #FECD07;
  font-size: 21px;
  padding-bottom: 20px;
  padding-left: 12px;
  padding-top: 26px;cursor:pointer;
">Add Description for selected image</div>
	  <span style="font-size: 31px;
	position: absolute;
	right: 5px;
	top: 0; cursor:pointer;font-size:21px;"class="modal_close clszxc">X</span>
	
	
	<section class="popupBody postpopupz">
	  
	  <div class="user_register">
		<input type="text" id="forumtitle" placeholder="Add Description.." value="" name="forumtitle" /><br /><br />
		<input type="button" onclick="addtoforumpage();" name="descrip" value="Post" class="button" />&nbsp;&nbsp;
		<input type="button" onclick="addtoforumpageclose();" name="cancel" value="Cancel" class="button" />
		<input type="hidden" value="" id="posttype" class="" />
		<input type="hidden" value="" id="imageID" class="" />
		<input type="hidden" value="" id="imagetitle" class="" />
		<input type="hidden" value="<?php echo $_SESSION['user_id'];?>" id="userid" class="" />
	  </div>
	</section>
  </div>
  <div class="v2_signup_overlay" style="display: none;"></div>
  <div id="photoPop2">
	<form action="" id="create_album" name="create_album" method="POST" enctype="multipart/form-data">
	<div class="dragNdrop">
		<div class="row">
			<span class="label" style="font-size:16px;font-weight:bold">Album Name:</span>
			<span class="formw"><input type="text" name="album_name"></span>
		</div>
		<!-- <div class="row">
			<span class="formw"><input type="file" name="album_cover"></span>
		</div> -->
		<img src="images/drag.png">
			<span class="label" style="font-size:16px;font-weight:bold;float: left;">Album Cover:</span>
		<input type="file" style="color: #fff; width:100%;padding: 44px 0px 44px 4px;border: 1px dashed #cccccc;" name="album_cover" class="txt_box" id="image_file"/>
		<ul class="btncenter_new">
			<li>
				<input class="button floatRight" type="submit" value="Create" name="save_album" style="margin-right: 26px;">
			</li>
		</ul>
		<input type="button" id="cancel_button" value="X">
		</div>
	</form>
  </div>
  <script type="text/javascript">
  	$(document).ready(function(){
        
         $("#addAlbum").click(function(){
          showpopup();
         });
         $("#cancel_button").click(function(){
          hidepopup();
         });
         
        });

        function showpopup()
        {
         $("#photoPop2").fadeToggle();
         $("#photoPop2").css({"visibility":"visible","display":"block"});
        }

        function hidepopup()
        {
         $("#photoPop2").fadeToggle();
         $("#photoPop2").css({"visibility":"hidden","display":"none"});
        }



  	function addtoforumpageclose()
  	{
  		$('#posttype').val('');
		$('#posttype').removeClass('private');
		$('#posttype').removeClass('public');
		$('#modal112').css('display','none');
		$('.v2_signup_overlay').hide();
  	}
	function addtoforumpage()
	{
		var type = $('#posttype').val();
		var img_id = $('#imageID').val();
		var user_id = $('#userid').val();
		//var descrip = $('#descrip').val();

		var title = $('#forumtitle').val();
		//alert(title);
		$('#posttype').val('');
		$('#posttype').removeClass('private');
		$('#posttype').removeClass('public');
		$('#modal112').css('display','none');
		$('.v2_signup_overlay').hide();
		$.ajax({
			type: "POST",
			url: "upload_photo.php",
			data: "privacytype="+type+"&img_id="+img_id+"&user_id="+user_id+'&title='+title,
			success: function(result){
				alert("Photo shared Successfully");
				location.reload(true);
			}
		});
	}
	
	function share_photo(thumb, image, title, type,imgid){

		$('#modal112').show();
		$('#posttype').val(type);
		$('#imagetitle').val(title);
		$('#imageID').val(imgid);
		$('.v2_signup_overlay').css('display','block','important');
		return false;
		var r = confirm("Are you sure want to share photo !");
		if (r == true) {

			$.blockUI({ css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff' 
			} }); 

				$.post('ajaxcall.php', {'thumb': thumb, 'image': image, 'title': title, 'type': type, 'share_current_post': 'share_current_post'}, function(response){
						setTimeout($.unblockUI, 2000);
						alert("Photo successfully shared");
				});
		}
	}

  </script>
<?php include('Footer.php') ?>
