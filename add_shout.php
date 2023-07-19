<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

FacebookSession::setDefaultApplication( FBAPPID,FBAPPSECRET );
  
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
$titleofpage="Add Shout";
include('LoginHeader.php');


 //echo "<pre>"; print_r($_SESSION);die;
        $userID = $_SESSION['user_id'];
	/******************/
	if(isset($_POST['submit']))
	{
				$file_type = $_FILES['shout_media']['type'];
				$exp_file_type = explode('/', $file_type);
				$check_file_type = $exp_file_type[0];
				
				if($check_file_type == "video" || $check_file_type == "application"){
					
					$forum_video=$_FILES['shout_media']['name']; 
					$tmp = $_FILES["shout_media"]["tmp_name"];
					$ext =substr($forum_video,strrpos($forum_video,'.'));
					$video = "upload/shout/video/".time().$forum_video;
					move_uploaded_file($tmp,$video);
					
				}elseif($check_file_type == "image"){
					
					$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
					$temp = explode(".", $_FILES["shout_media"]["name"]);
					$extension = end($temp);
					$name = $_FILES["shout_media"]["name"];
					$ext =substr($name,strrpos($name,'.'));
					$tmp1 = $_FILES["shout_media"]["tmp_name"];
					$path = "upload/shout/images/".time().$name;
					$thumbnail = "upload/shout/images/thumb_".time().$name;
					move_uploaded_file($tmp1,$path);

					//indicate which file to resize (can be any type jpg/png/gif/etc...)
					$file = $path;

					//indicate the path and name for the new resized file
					$resizedFile = $thumbnail;

					//call the function (when passing path to pic)
					//smart_resize_image($image , null, 324 , 200 , false , $resizedFile , false , false ,100 );
					//call the function (when passing pic as string)
					//smart_resize_image(null , file_get_contents($image), 324 , 200 , false , $resizedFile , false , false ,100);
					$resizeObj = new resize($file);

					// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
					$resizeObj -> resizeImage(300, 200, 'auto');

					// *** 3) Save image ('image-name', 'quality [int]')
					$resizeObj -> saveImage($resizedFile, 100);

				}

				 $message=mysql_real_escape_string($_POST['shout']);
				 $title=mysql_real_escape_string($_POST['sname']);
				 $user_type = $_SESSION['user_type'];
				 if(isset($_SESSION['subuser']))
				 {
				 	//echo "<pre>"; print_r($_SESSION); exit;
				 	$fetchhostquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$_SESSION['username']."' ");
				 	$fetres = @mysql_fetch_array($fetchhostquery);
				 	$user_id = $fetres['host_id'];
				 }
				 else
				 {
				 	$user_id =  $_SESSION['user_id'];	
				 }

				 $date = date("Y-m-d H:i:s");
				 $sql="INSERT INTO shouts (image_thumb,user_id,shout,added_date,user_type,shout_title,shout_image,shout_video)VALUES('$thumbnail','$user_id','$message','$date','$user_type','$title','$path','$video')";
				 mysql_query($sql);
				  $ins_id=mysql_insert_id();
				  
				  
				  
				  
				$forum = mysql_real_escape_string($_POST['sname']);
				$description = mysql_real_escape_string($_POST['shout']);
				//$user_id = $userID;
				$added_on = date('Y-m-d');
				$city = $_SESSION['id'];
				$state = $_SESSION['state'];
				$country = $_SESSION['country'];
				$forum_type = "public";
				$status = "1";
				$user_type = "club";
				$from_user = $user_id;
				$post_from = "city_talk";

				//mysql_query("INSERT INTO forum (`forum`, `forum_img`, `image_thumb`, `forum_video`, `user_id`, `added_on`, `city_id`, `forum_type`, `status`, `user_type`, `from_user`, `post_from`, `state_id`, `country_id`, `description`, `shout_id`)VALUES('".$forum."', '".$image."', '".$resizedFile."', '".$video."', '".$user_id."', '".$added_on."', '".$city."', '".$forum_type."', '".$status."', '".$user_type."', '".$from_user."', '".$post_from."', '".$state."', '".$country."', '".$description."', '".$ins_id."')");
				/* for shout_count */
				// $shout_count_sql="INSERT INTO shout_count (shout_id,user_id,total_read,total_sent,friends_id)
				// VALUES('$ins_id','$user_id','','','$friend')";
				// mysql_query($shout_count_sql);

				// $ValueArray_o = array($user_id,'shout',$ins_id,$user_id,$_SESSION['user_type'],$_SESSION['user_type']);	
				// $FieldArray_o = array('user_id','cont_type','cont_id','owner_id','user_type','friend_type');
				// $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_o,$FieldArray_o);

				 $get_fds=mysql_query("select f.friend_id,f.friend_type from  friends as f where f.user_id ='".$user_id."' AND f.user_type = '$_SESSION[user_type]' AND f.friend_id != '$_SESSION[user_id]' AND f.status = 'active' group by f.friend_id");
					
					while($al_fr=@mysql_fetch_assoc($get_fds)){
						
						$ValueArray_f = array($al_fr['friend_id'],'shout',$ins_id,$user_id,'club',$al_fr['friend_type']);	
						$FieldArray_f = array('user_id','cont_type','cont_id','owner_id','user_type','friend_type');
						$Success2 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_f,$FieldArray_f);

							$inserted_event_id = mysql_insert_id();
							
							$shout_added_on = date('Y-m-d h:i:s');
							$c_identifier = "shout_".$inserted_event_id;
					
							mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$al_fr['friend_id']."', 'shout', '".$shout_added_on."', '1', '".$c_identifier."', 'club', '$al_fr[friend_type]')");
					 
					}
				
				/***** FACEBOOK POST SHARE *****/
				if(isset($_SESSION['fb_token'])){
					
					if($video != ""){
						
						$share_link = $base_url.$video;
						$share_picture = $base_url."images/share_video_play_btn.png";
						
					}else{
					
						if(!empty($_FILES["shout_media"]["name"])){
							
							$share_link = $base_url.$thumbnail;
							$share_picture = $base_url.$thumbnail;
							
						}else{
							
							$share_link = $base_url;
							$share_picture = $base_url."images/logo.jpg";
							
						}
					}
					$session = new FacebookSession( $_SESSION['fb_token'] );
					
					// graph api request for user data
					$request = new FacebookRequest( $session, 'POST', '/me/feed', array(
					   //'name' => $_POST['shout'],
					   'caption' => 'mysitti.com',
					   'link' => $share_link,
					   'message' => 'New Shout Out'.$_POST['shout'].' on Mysitti',
					   'picture' => $share_picture
					  ) );
					$response = $request->execute();
				}
				/***** FACEBOOK POST SHARE *****/
				
				
				/** TWITTER POST SHARE **/
				
				if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
				{
					include_once("twitter/config.php");
					include_once("twitter/inc/twitteroauth.php");
					
					//Success, redirected back from process.php with varified status.
					//retrive variables
					$screenname 		= $_SESSION['request_vars']['screen_name'];
					$twitterid 			= $_SESSION['request_vars']['user_id'];
					$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
					$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
				
					//Show welcome message
					echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';
					$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
					
					//see if user wants to tweet using form.
					if(isset($_POST["shout"])) 
					{
						//Post text to twitter
						$my_update = $connection->post('statuses/update', array('status' => $_POST["shout"]));
						//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
					}
				}
				
				/**TWITTER POST SHARE**/

				 // end here 
				 $_SESSION['success']="Shout added successfully";
				 //header('Location: shout.php');
				$Obj->Redirect("shout.php?msg=add");
				//die;
				 
	}
        

    ?>
    <div class="v2_container">
<div class="v2_inner_main">

<div id="hide_sidebar">
                 <?	
				 	if(isset($_SESSION['subuser']))
				 	{
				 		include('sub-right-panel.php');
				 	}
				 	else
				 	{
				 		include('club-right-panel.php');
				 	}


			  ?>
</div>
<article class="forum_content v2_contentbar">
<div class="v2_rotate_neg">
<div class="v2_rotate_pos">
<div class="v2_inner_main_content">
					<?php
					  if($message!="")
					  {
					?>
						<div style="background-color:#6F9; color:#FF0000"><?php echo $message; ?> </div> 
					  <?php
					} ?>
					<div id="profile_box">
						<h3 id="title" class="">Shout Out</h3>       
					  <form name="shout_out" id="shout_out" method="post"   enctype="multipart/form-data">
					  
                      
                <div class="row">
                <span class="label" style="font-size:16px;font-weight:bold">Shout Name<span style="color:#F00;width:10px !important">*</span>:</span>
                <span class="formw"><input  type="text" name="sname" id="sname" value=""></span>
                </div>

                <div class="row">
                <span class="label" style="font-size:16px;font-weight:bold">Shout Message<span style="color:#F00;width:10px !important">*</span>:</span>
                <span class="formw"> <textarea  cols="50" rows="5" name="shout" id="shout"></textarea></span>
                </div>
				
                <div class="row">
					<span class="label" style="font-size:16px;font-weight:bold">Shout Media:</span>
					<span class="formw">
						<div class="_6a _m" id="u_0_s" style="float: left; width: 100%;">
							<a class="_9lb" aria-pressed="false" role="button" rel="ignore" id="u_0_t" style="float: left;">
							<span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
							<img src="images/upload_camera.png">
							</i>Add Photo/Video<i class="_2wr"></i>
							</span>
							
							<div class="_3jk">
							<input type="file" onchange="return ValidateFileUpload()" id="js_0" class="_n _5f0v" title="Choose a file to upload" name="shout_media" aria-label="Upload Photos/Video">
								<span id="file_upload_successs" style="display: none;"><img src="images/tick_green_small.png"></span>
							</div>
							</a>
						</div>
					</span>
                </div>

                <div class="row">
                <span class="label" style="font-size:16px;font-weight:bold"></span>
                <span class="formw"></span>
                </div>
                <div class="row">
                <span class="label" style="font-size:16px;font-weight:bold"></span>
                <span class="formw"></span>
                </div>
			 <div class="row">
                <span class="label" style="font-size:16px;"> &nbsp; </span>
                 <span class="formw">
    			   <div id="submit_btn"><input class="btn_ss" name="submit" type="submit" value="Send" />
					<div style="float: left;margin-left:15px;"><a class="btn_ss" href="shout.php">Back</a></div>				   
				   
				   </div>
                   </span>
				   </div>
					  </form>
					</div>              
				</div>
            </div>

	    </div>
    </div>
 <script type="text/javascript">	
	function Validate_shout_FileUpload(){
			var check_image_ext = $('#shout_img').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
				alert('Post Image only allows file types of GIF, PNG, JPG and JPEG');
				$('#shout_img').val('');
			}
	}
	
	function Validate_shout_VideoUpload(){
			var check_image_ext = $('#shout_video').val().split('.').pop().toLowerCase();
				if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
					alert('Post Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
						$('#shout_video').val('');
			}
	}
	
	function ValidateFileUpload(){
			var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
				alert('Shout Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
				$('#js_0').val('');
				$('#file_upload_successs').hide();
			}else{
				$('#file_upload_successs').show();
			}
	}	
 </script>    

</div>
</div>
</div>
<?php include('footer.php') ?>

