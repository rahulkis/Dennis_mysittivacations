<?php

ob_start();

include("Query.Inc.php");

$Obj = new Query($DBName);

$titleofpage="Upload Video";

if(!isset($_SESSION['user_id']))

{

	include('PublicProfileHeader.php');

}

else

{

	include('NewHeadeHost.php');

}



$userID=$_SESSION['user_id'];

$userType= $_SESSION['user_type'];

//include '../googleplus-config.php';



// ini_set("display_errors", "1");

// error_reporting(E_ALL);



// if(!isset($userID)){ $Obj->Redirect($SiteURL); }



if(isset($_REQUEST['id'])){

	

	$userID=$_REQUEST['id'];

}

elseif(isset($_GET['host_id']))

{

	$userID=$_GET['host_id'];

}

else {

	

	$userID=$_SESSION['user_id'];

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



if(isset($_POST['delete_video']))

{

	foreach($_POST['delete_video'] as $ID)

	{

		$getImagepath = mysql_query("SELECT * FROM `uploaed_video` WHERE `video_id` = '$ID' ");

		while($result = mysql_fetch_assoc($getImagepath))

		{

			if($result['video_type'] == 'computer')

			{

				$filepath = $result['video_nm'];

				unlink($filepath);	

			}

			

		}

	}





 	$ids = implode(",",$_POST['delete_video']);

	 

 	$del = mysql_query("delete from uploaed_video where video_id IN(".$ids.")");

  	if($del)

  	{

		$Obj->Redirect("upload_video.php?msg=deleted");

		die;

  	}

}

		

		

//$titleofpage="Upload Videos";

//include('header_start.php');



?>



<script>

function ValidateVideoUploadnew(){

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

	

	//else

	//{

	//  

	// var FileExt = document.getElementById('file').value.lastIndexOf('.mp4');

	//if(FileExt==-1) {

	//  alert('Upload Only .mp4,m4v,.flv,.WebM,.f4v');    

	//  return false;

	//}     

	//}



}

function makelike(action,video_id,who_like_id)

{

	 $.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {

	$('#vid_'+video_id).html(data);

	});

}



</script>

<?php



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



  

?> 

<?

if(isset($_POST['submit']))

{   

	$imageTitle = mysql_real_escape_string($_POST['video_title']);

	if($_POST['video_file']!="") 

	{
			$getmax = mysql_query("SELECT MAX(track_no) FROM uploaed_video");
			$getmaxvalue = mysql_fetch_assoc($getmax);
			$plusone = $getmaxvalue['MAX(track_no)'] + 1;

		$video_nm= $_POST['video_file'];

		$ValueArray = array($imageTitle,$userID,$_SESSION['user_type'],$video_nm,'youtube',$plusone);

		$FieldArray = array('video_title','user_id','user_type','video_nm','video_type','track_no');

		$ThisPageTable="uploaed_video"; 

		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);  

	}
	

	 

	  if($_FILES["file"]["name"]!="")

	  {

			  if ($_FILES["file"]["error"] > 0)

			 {

					  echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; Exit;

			 }/*else if($_FILES["file"]["size"] > 26214400)

			 {

				$_SESSION['error_msg']="Please Upload Less than 25 MB";

				 $Obj->Redirect("upload_video.php"); exit;

			 }*/

			else

			{

				 $u_video=$_FILES["file"]["name"]; 

				$tmp = $_FILES["file"]["tmp_name"]; 

				$v_name = "user-video/".time().strtotime(date("Y-m-d")).$u_video; 

				  move_uploaded_file($tmp,$v_name);

				  
				  $getmax = mysql_query("SELECT MAX(track_no) FROM uploaed_video");
					$getmaxvalue = mysql_fetch_assoc($getmax);
					$plusone = $getmaxvalue['MAX(track_no)'] + 1;
					
				

				$ValueArray = array($imageTitle,$userID,$_SESSION['user_type'],$v_name,'computer','public',$plusone);

				$FieldArray = array('video_title','user_id','user_type','video_nm','video_type','uploaded_video_type','track_no');

				$ThisPageTable="uploaed_video"; 

				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);  

				

			}

	 }

		if($Success)

		 {

			  if(isset($_SESSION['user_club']) && $_SESSION['user_club']=='Club')

			 {

					$Obj->Redirect("upload_video.php?msg=uploaded");

				die;

			 }else

			 {

				$Obj->Redirect("upload_video.php?msg=uploaded");

				die;

			 }

		 }

}

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

	$getimage = mysql_query("SELECT * FROM uploaed_video WHERE video_id = '$img_id' ");

	$result12 = mysql_fetch_array($getimage);

 	$forum_img = $result12['video_nm'];

	$title = mysql_real_escape_string($_POST['title']);







	if($privacytype == 'blog_page'){

		

		$ValueArray = array(date('YmdHis'),$_SESSION['user_id'],'blog',$_SESSION['user_type'],'',$title,'',$forum_img,$_SESSION['user_id'],$added_on,$city,'public',$status,'','');

		$FieldArray = array('common_identifier','from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');

		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

		

	}

	

	if($privacytype == 'city_talk'){

		

		mysql_query("INSERT INTO forum (`common_identifier`,`forum`, `forum_img`, `image_thumb`, `forum_video`, `user_id`, `added_on`, `city_id`, `state_id`, `country_id`, `status`, `user_type`, `from_user`, `post_from`, `forum_type`) VALUES ('$common_identifier','".$title."', '', '', '".$forum_img."', '".$_SESSION['user_id']."', '".$added_on."', '".$city."', '".$state."', '".$country."', '".$status."', '".$user_type."', '".$_SESSION['user_id']."', 'city_talk', 'public')");

		

	}

	

	if($privacytype == 'profile_post'){

		

				$ValueArray = array($_SESSION['user_id'],'profile',$_SESSION['user_type'],'',$title,'',$forum_img,$_SESSION['user_id'],$added_on,$city,'public',$status,"","", $common_identifier);

				

				$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');

				

				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);		

		

	}

	

	/*

	

	//echo "update uploaded_video set uploaded_video_type='".$privacytype."' where user_id=".$user_id." AND video_id=".$img_id;;

	if($_POST['privacytype'] == 0)

	{

		$privacytype = 'public';

		$post_from = "profile";

	}

	else

	{

		$privacytype = 'private';

		$post_from = "clique";

	}

	$img_id =$_POST['img_id'];

	$user_id =$_POST['user_id'];

	$title = $_POST['title'];

	//$privacytype = $_POST['privacytype'];

	@mysql_query("update uploaed_video set uploaded_video_type='".$privacytype."' where user_id=".$user_id." AND video_id=".$img_id." ");

	$getimage = @mysql_query("SELECT * FROM uploaed_video WHERE video_id = '$img_id' ");

	$result12 = @mysql_fetch_array($getimage);

	$forum_img = $result12['video_nm'];

	$checkquery = mysql_query("SELECT * FROM `forum` WHERE `forum_video` = '".$forum_img."' ");

	$countrows = mysql_num_rows($checkquery);

	$checkres = mysql_fetch_array($checkquery);

	if($countrows > 0)

	{

		mysql_query("UPDATE `forum` SET `post_from`= '".$post_from."',`forum_type` = '".$privacytype."', `forum` = '".$title."' WHERE `forum_id` = ".$checkres['forum_id']." ");

	}

	else

	{

		$sqlprivacy="INSERT INTO `forum` (`forum_id`,`post_from`,`forum`,`forum_img`,`forum_video`,`user_id`,`added_on`,`city_id`,`forum_type`,`status`,`friends_id`,`group_id`,`user_type`)

					VALUES ('','".$post_from."','".$title."','','".$forum_img."','".$user_id."', NOW(),'".$city."','".$privacytype."','1','','','".$_SESSION['user_type']."' )";

		mysql_query($sqlprivacy);die;

	}





	

	*/

}



/* ends here */ 

?>





<script>

function remove_lower_file(){

	

		jQuery("#computer_file").val("");

	

	}

	

function remove_upper_file(){

	

		jQuery("#video_file").val("");

	

	}   

	

function postprivacy(type,img_id,user_id){  

		if(type=="public"){

			

			val=0;

			$('#posttype').addClass('public');

		}else{

			

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

			alert("Please select atleast one video!");

		}

	}); 

	$('.modal_close').on('click',function(){



		$('#posttype').val('');

		$('#posttype').removeClass('private');

		$('#posttype').removeClass('public');

		$('#modal112').css('display','none');

		$('#lean_overlay').css('display','none');

		$('.v2_signup_overlay_upload').hide();

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

	// $.ajax({

	// 	type: "POST",

	// 	url: "changeTitle.php",

	// 	data: "imgId="+imgid+"&title="+textValue,

	// 	success: function(result){

	// 		//alert("Photo added as "+ type + " Successfully");

	// 		//location.reload(true);

	// 	}

	// });

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

				//alert("Photo added as "+ type + " Successfully");

				//location.reload(true);

				$('#image_'+iD).html(result);

				$('#image_'+iD).attr('onclick', 'changeTitle("'+imgid+'")');

			}

		});

		event.preventDefault();

	}



	

	//return false;

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

.jwplayer, .jw-error

{

	width: 100% !important;

}



/*.photodata_2 .video_ss

{

	border: 5px solid #FFF;

}

.video_ss span.publicprivarecheck

{

	background-color: #000 !important;

	color: #FFF !important;

}*/



.sharepro {



  margin-left: 3px;

  padding: 5px 5px 0;

}

.popupContainer {

  border: 5px solid #fff !important;

  border-radius: 5px;

  bottom: 0;

  box-sizing: border-box;

  -webkit-box-sizing: border-box;

  -ms-box-sizing: border-box;

  left: 0;

  margin: auto;

  max-height: 200px;

  max-width: 400px;

  padding: 20px;

  position: fixed;

  right: 0;

  top: 0;

  display:none;

  width: 100%;

  z-index: 2147483647;

}

</style>

<!--<link rel="stylesheet" type="text/css" href="https://mysittidev.com/css/new_portal/style.css" />-->

  <script type="text/javascript" src="js/jquery.leanModal.min.js"></script>



<link type="text/css" rel="stylesheet" href="css/style_popup.css" />



	<?php 



	if(isset($_GET['host_id']))

	{

		$HostID = $_GET['host_id'];

	}

	else

	{

		$HostID = $_SESSION['user_id'];

	}

		$getStreaming = mysql_query("SELECT * FROM `saved_streaming` WHERE `host_id` = '$HostID' AND `active` = '1' ");





	 ?>

	 

<div class="v2_container">

  <div class="v2_inner_main">

	

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

	

	<article class="forum_content v2_contentbar">

		<div class="v2_rotate_neg">

			<div class="v2_rotate_pos">

				<div class="v2_inner_main_content">

				

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

			elseif ($_GET['msg'] == "deleted") 

			{

				# code...

				echo '<div id="successmessage" style="display: block;">Video deleted successfully</div>';

			}





			if( ($_SESSION['user_type'] == 'user' && isset($_GET['host_id']) ) || ($_SESSION['user_type'] == 'club') )

			{

				$countStreaming = mysql_num_rows($getStreaming);

				if($countStreaming > 0)

				{

			?>



				<div class="StreamingVideos">

					<h3 id="title">Streaming Videos</h3>

					<div id="profile_box_top" class="upload_photo_main">

						<?php

						

							while($fetchStreamingVideos = mysql_fetch_assoc($getStreaming))

							{

								?>

								<div class="video_ss streaming_vids">

						 			<video loop="" controls="true" style="float:left; width:100%;" id="">

										<source type="video/mp4" src="<?php echo $SiteURL.$fetchStreamingVideos['video_path']; ?>" id="mp4Source"></source>

									</video>

									

								</div>

								<?php

							}				

						?>

					</div>

				</div>

		<?php 		}

			} 

		?>

				<div class="UploadedVideos">

   <h3 id="title">Videos</h3>



	<div id="profile_box" class="upload_photo_main">

		<?php 

		



	if(isset($_REQUEST['id'])){

	$userID=$_REQUEST['id'];

	}

	else

	{

	$userID = $_SESSION['user_id'];

	}

	 if(isset($_GET['host_id'])){

		$swl= "SELECT * FROM `uploaed_video` WHERE `user_id` = '".$_GET['host_id']."' and user_type='club'";

	}elseif(isset($_GET['id'])){

		$swl= "SELECT * FROM `uploaed_video` WHERE `user_id` = '".$_GET['id']."' and user_type='user'";

	}else{

		$swl= "SELECT * FROM `uploaed_video` WHERE `user_id` = '".$userID."' and user_type='".$_SESSION['user_type']."'";

	}



	//die('123');

  $sql_video = mysql_query( $swl);

  $img_count= mysql_num_rows($sql_video);

	?>

<?php if(isset($_SESSION['success'])){ ?> 

		<div id="successmessage" class="message" > <?php echo $_SESSION['success']; ?></div>

		 <?php  unset($_SESSION['success']);

		 } ?>

	 <? if(!isset($_GET['host_id']) && !isset($_GET['id'])){?>

	 <!-- <input type="button" id="modal_trigger" href="#modal" class="button" value="Add Post" > -->

	 <input type="button" class="button"  id="deletephoto" value="Delete" style="margin-left:15px;">
	 <input type="button" class="button"  id="addvideo" value="Add" style="margin-right:15px;">

	 <? } ?>

	  <form name="photos" id="photos" method="post">

	<div id="error"></div>

	 

	<div class="uploadphotos"> 



	<div class="photos_row">

	<?php

		$i=0;

	?>

			

			<div class="photodata_2">

		   

			 <?php      

			  	while($video_row = mysql_fetch_array($sql_video))

				{ 



						if($video_row['video_type'] == "computer" ){



							$url = $SiteURL.$video_row['video_nm'];



						}

						else

						{

							$url = $video_row['video_nm'];

						}

					?>

						 <div class="video_ss">



						 	<?php if(!isset($_GET['host_id']) && !isset($_GET['id'])){

								

								if(empty($video_row['video_title'])){

									

									$video_title = "Shared Video";

								}else{

									

									$video_title = $video_row['video_title'];

								}

								?>

								<div class="check_del">

									<!-- <input type="checkbox" name="delete_photo[]" value="<?php echo $row['img_id']; ?>" class="others"> -->

									<input type="checkbox" name="delete_video[]" value="<?php echo $video_row['video_id']; ?>" class="others">

								</div>

								<div class="sharepro">

									<img src="images/share1.png" alt="Share on Facebook"/>  Share

									<div class="photoSharePro">

										<ul>

								

										<?php if($_SESSION['user_type'] == 'club'){ ?>

												<li>

											<a onclick="share_video('<?php echo $url; ?>', '<?php echo $video_title; ?>', 'blog_page','<?php echo $video_row['video_id'];?>');" href="javascript: void(0);" title="Blog Page">Fan Page</a>

										</li>

										<?php } ?>

										

										

										

											<?php if($_SESSION['user_type'] == 'user'){ ?>

											<li>	

										   <a onclick="share_video('<?php echo $url; ?>', '<?php echo $video_title; ?>', 'profile_post','<?php echo $video_row['video_id'];?>');" href="javascript: void(0);" title="Profile Post Page">Profile Page</a>

									</li>			<?php } ?>

									

										

										<li>

											<a onclick="share_video('<?php echo $url; ?>', '<?php echo $video_title; ?>', 'city_talk','<?php echo $video_row['video_id'];?>');" id="city_talk_share" href="javascript: void(0);" title="City Talk Page">City Talk</a>											

										</li>

										</ul>

									</div>

								</div>

								<div style="float: left; padding: 5px 2px;" class="featured">

									<input type="checkbox" id="<?php echo $video_row['video_id']; ?>" <?php if($video_row['featured'] == '1'){ echo "checked";} ?> onclick="addToPlayer('<?php echo $video_row['video_id']; ?>');">Featured Video

								</div>

								<div class="sharebox">

      

									<div class="photoShare">

										<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onClick="return fbs_click('<?php echo $url; ?>', 'mysittidev.com' )" target="_blank" style="text-decoration:none;"><img src="<?php echo $SiteURL; ?>fbook.png" alt="Share on Facebook"/></a>	

											

										<a href="#" onClick="return fbs_click123('<?php echo $url; ?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="<?php echo $SiteURL; ?>twt.png" alt="Share on Twitter"/></a>				

											

										<a href="https://plus.google.com/share?url=<?php echo $url; ?>" onClick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?php echo $SiteURL; ?>g+.png" alt="Share on Google+"/></a>

																				

									</div>

						         		</div>

						         		<div style="clear:both;"></div>

								

							<? } ?>

						<p>&nbsp;</p>

						<div class="VideoBox">

							<?php 

								if($_SESSION['user_type'] == $video_row['user_type'] && $_SESSION['user_id'] == $video_row['user_id']) 

								{

							?>

									<div class="MakeDefault">

										<input <?php if($video_row['default_video'] == '1'){ echo 'checked';} ?> class='makeDefault' id="default_<?php echo $video_row['video_id']; ?>" type="radio" onclick="makedefaultvideo(this.value);" value='<?php echo $video_row["video_id"];?>' /> Set Default

									</div>

						<?php 	}	



							if (strpos($url,'vimeo.com') !== false) { 



							$urlnew = explode('/',$url);

							$videoID = end($urlnew);



							?>



								<iframe src="https://player.vimeo.com/video/<?php echo $videoID;?>" width="200" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>



						<?php }else{ ?>

						

								<a class="jwplayerVideo" id="jw_<?php echo $video_row['video_id'];?>" href="#dialogx<?php echo $video_row['video_id'];?>" name="modal" style="">

							   		<div  id="a<?php echo $video_row['video_id'];?>" ></div>

								<script type="text/javascript">

								   	jwplayer("a<?php echo $video_row['video_id'];?>").setup({

										file: "<?php echo $url;?>",

									  	height : 200 ,

									  	

								  	});

								</script>

								</a>	   				

						

						<?php } ?>

						

						</div><!-- END VIDEOBOX -->

							 <span <?php if($_SESSION['user_type'] == $video_row['user_type'] && $_SESSION['user_id'] == $video_row['user_id']) {?>onclick="changeTitle(this.id);" <?php } ?> class="imageTitle publicprivarecheck" style="color: #FFF; cursor:pointer; text-align: center;"  id="image_<?php echo $video_row['video_id']; ?>">

							 	<?php if($video_row['video_title'] != ""){ echo $video_row['video_title']; }else{ echo  "&nbsp;"; } ?>

							 </span>

							<?php 

								$sel_like=mysql_query("select count(like_id) as tot_like  from like_img_video where video_id='".$video_row["video_id"]."'");

								$fech_like=@mysql_fetch_array($sel_like);

									

								$u_like=mysql_query("select count(like_id) as is_user_like  from like_img_video where video_id='".$video_row["video_id"]."' AND like_user_id='".$_SESSION['user_id']."'");

								$fech_u_like=@mysql_fetch_array($u_like); /*?>

							

								

							  <span id="vid_<?php echo $video_row["video_id"]; ?>">

							  <?php if($_SESSION['user_id']!=$userID){ ?>

				<a href="javascript:void(0);" 

				onclick="makelike('<?php if($fech_u_like['is_user_like'] > 0) { ?> unlike <?php }else{ ?>like<?php } ?>','<?php echo $video_row["video_id"]; ?>','<?php echo $_SESSION['user_id']; ?>');" >

				<?php if($fech_u_like[is_user_like] > 0) {?>UnLike <?php }else { ?>Like <?php } ?> </a> 

							  ,<?php } ?>  <?php echo $fech_like['tot_like']?> People Likes</span>

							  <? */ 

							if(($_SESSION['user_type'] == 'user') )

							{

								if(isset($_GET['host_id']))

								{



								}

								else

								{

								}

							}

							else

							{

							}

				?>

				

					</div> 

<?php

						}// END WHILE

					?>

						</div>

			</div></div>

			</form>

<script type="text/javascript">

	$('.jwplayerVideo').each(function(){

		var i = $(this).attr('id');

		i = i.split('_');

		var id = i[1];





		// $(this).hover(



		// 	function () {

		// 		var state = jwplayer('a'+id).getState();

		// 		if(state != 'PLAYING')

		// 		{

		// 			jwplayer('a'+id).play();

		// 		}

		// 	}, 



		// 	function () {

		// 		var state = jwplayer('a'+id).getState();

		// 		if(state == 'PLAYING')

		// 		{

		// 			jwplayer('a'+id).pause();

		// 		}

		// 		else if(state == 'BUFFERING')

		// 		{

		// 			jwplayer('a'+id).pause();

		// 		}

		// 		else if(state == 'IDLE')

		// 		{

		// 			jwplayer('a'+id).pause();

		// 		}

		// 	}

		// );

	});



	function makedefaultvideo(id)

	{

		$('.makeDefault').each(function(){

			var ID = $(this).attr('id');

			if( ID == 'default_'+id )

			{

				$(this).prop('checked', true);

				$.blockUI({ css: {

						border: 'none',

						padding: '15px',

						backgroundColor: '#fecd07',

								'-webkit-border-radius': '10px',

								'-moz-border-radius': '10px',

						opacity: .8,

						color: '#000'

					},

					message: '<h1 class="setting_default_video">Setting up the default Video.</h1>'

				});

				$.ajax({

					type: "POST",

					url: "refreshajax.php",

					data: {

						'action' : 'setDefaultVideo',

						'videoid' : id,

					},

					success: function(data){

						$.unblockUI();

						//$('ul.categoryList').html(data);

						//return false;

					}

				});

			}

			else

			{

				$(this).prop('checked', false);

			}

		});

	}



	function addToPlayer(videoid)

	{

		

		if($('input#'+videoid).is(':checked'))

		{

			var postaction = "Add";

			$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

			},

			message: '<h1 class="video_feature_list">Adding Video to Feature List.</h1>'

			});

		}

		else

		{

			var postaction = "Remove";

			$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

			},

			message: '<h1 class="video_feature_list">Removing Video from Feature List.</h1>'

			});

		}

		

		$.ajax({

			type: "POST",

			url: "refreshajax.php",

			data: {

				'videoId' : videoid,

				'action' : 'addToPlayer',

				'postAction' : postaction,

			},

			success: function(result){

				$.unblockUI();

			}

		});

	}









</script>

		<?php if(isset($_GET['host_id'])){ ?>

		

			<div style="float:right;">

				<a href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a>

			</div>

		

		<?php } ?>

			 

			</div>

	   	</div><!-- END OF LOWER DIV FOR UPLOADED VIDEOS -->

		</div>				

				

				</div>

			</div>

		</div>

	</article>

	</div>

</div>	 

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

	max-width: 400px !important;

	overflow: auto;

	padding: 0;

	position: fixed;

	right: 0;

	top: 0 !important;

	width: 100%;

	z-index: 2147483647 !important;

}

h2 {

  background: #fecd07 none repeat scroll 0 0;

  box-sizing: border-box;

  color: #000;

  float: left;

  font-size: 15px;

  margin: 20px 0 10px;

  padding: 5px;

  text-align: center;

  width: 100%;

}

.popupBody.postpopupz #forumtitle {

  box-sizing: border-box;

  padding: 10px 0;

  text-align: center;

  text-indent: 0;

  width: 100%;

}

.modal_close.clszxc.closetalk {

  cursor: pointer;

  position: absolute;

  right: 10px;

  top: 10px;

}

.popupBody {

  padding: 0;

}



.v2_signup_overlay_upload {

  background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0;

  display: none;

  height: 100%;

  left: 0;

  position: fixed;

  top: 0;

  width: 100%;

  z-index: 99;

}

</style>

<div id="modal112" class="popupContainer" >

	

<h2> Add Description for selected Video </h2>

	  <span class="modal_close clszxc closetalk"> <img title="Delete Event" src="images/delEvent.png"> </span>

	

	

	<section class="popupBody postpopupz">

	  

	  <div class="user_register">

		<input type="text" id="forumtitle" placeholder="Add Description.." value="" name="forumtitle" /><br /><br />

		<input type="button" onclick="addtoforumpage();" name="descrip" value="Post" class="button" />

		<input type="button" onclick="addtoforumpageclose();" name="cancel" value="Cancel" class="button" />

		<input type="hidden" value="" id="posttype" class="" />

		<input type="hidden" value="" id="imageID" class="" />

		<input type="hidden" value="" id="imagetitle" class="" />

		<input type="hidden" value="<?php echo $_SESSION['user_id'];?>" id="userid" class="" />

	  </div>

	</section>

  </div>

  <div class="v2_signup_overlay_upload" style="display: none;"></div>
  <div id="gallerypop">
        
         <form method="post" name="upvideo" id="upvideo" enctype="multipart/form-data" onsubmit="return validate_video();"> 

		 <?php if(isset($_SESSION['error_msg'])){ ?> 

		 <div style="color:#F00" align="center"> <?php echo $_SESSION['error_msg']; ?></div>

		 <?php  unset($_SESSION['error_msg']);

		 } ?>


			<div class="row">

				<span class="label" style="font-size:16px;font-weight:bold">Video Title:</span>

				<span class="formw"><input type="text" id="video_title" name="video_title" required />

				</span>

			</div>

		 <div class="row dashedBorder">
		 	<span class="label" style="font-size:16px;font-weight:bold">Enter the video YouTube share URL</span>
			<span class="formw new-border">
				<input type="text" id="video_file" name="video_file" placeholder="Paste Youtube/Vimeo URL link here" multiple onclick="remove_lower_file();">
					<span class="label" style="font-size:16px;float: left;font-weight:bold">Or</span>
					<span class="formw" style="float: left;"><input style="color:#FFF;" class="upload_vi" type="file"  name="file" id="computer_file" onchange="return ValidateVideoUploadnew();" onclick="remove_upper_file();"/>
			<p>.mov, .m2ts, .avi, .mp4, .m4v, .webm, .flv and .f4v</p>
			</span>
			</span>
		</div>

		<div class="row">
			<!--<span class="label" style="font-size:16px;font-weight:bold">YouTube, Vimeo URL Or Computer :</span>-->
		
		</div>
		<ul class="btncenter_new">

		 <li> <input name="submit" type="submit" class="button btn_add_venu" value="Upload" /></li>

		</ul>

		<input type="button" id="cancel_button" value="X">
        	
        </form>
        
</div>
  <script type="text/javascript">


    $(document).ready(function(){
        
         $("#addvideo").click(function(){
          showpopup();
         });
         $("#cancel_button").click(function(){
          hidepopup();
         });
         
    });

        function showpopup()
        {
         $("#gallerypop").fadeToggle();
         $("#gallerypop").css({"visibility":"visible","display":"block"});
        }

        function hidepopup()
        {
         $("#gallerypop").fadeToggle();
         $("#gallerypop").css({"visibility":"hidden","display":"none"});
        }

  //       function ValidateVideoUploadahd(){
		// 	var check_image_ext = $('#add_post_videoahd').val().split('.').pop().toLowerCase();
		// 	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
		// 		alert('Host Dj Image only allows file types of GIF, PNG, JPG and JPEG');
		// 		$('#add_post_videoahd').val('');
		// 	}
		// }
    
  	

  	function addtoforumpageclose()

  	{

  		$('#posttype').val('');

		$('#posttype').removeClass('private');

		$('#posttype').removeClass('public');

		$('#modal112').css('display','none');

		$('.v2_signup_overlay_upload').hide();

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

		$('.v2_signup_overlay_upload').hide();

		$.ajax({

			type: "POST",

			url: "upload_video.php",

			data: "privacytype="+type+"&img_id="+img_id+"&user_id="+user_id+'&title='+title,

			success: function(result){

				alert("Video shared Successfully");

				location.reload(true);

			}

		});

	}

	

	function share_video(image, title, type,imgid){



		$('#modal112').show();

		$('#posttype').val(type);

		$('#imagetitle').val(title);

		$('#imageID').val(imgid);

		$('.v2_signup_overlay_upload').show();

		return false;

		var r = confirm("Are you sure want to share Video !");

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





 <?php include('LandingPageFooter.php') ?>