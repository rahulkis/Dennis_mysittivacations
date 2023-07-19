<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
include 'googleplus-config.php';
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
if(isset($_REQUEST['id']))
{
	$UserID=$_REQUEST['id'];
}
else 
{
	$UserID=$_SESSION['user_id'];	
}
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="update")
	{
	$message="Shout added successfully";
	}
}

	$sql = "select * from `user` where `id` = '".$UserID."'";
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
	/**********************************/
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);

// get user groups 
  $get_groups=mysql_query("select g.group_name,g.id from  chat_users_groups as cgs 
   join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$UserID."' group by g.id");
// end here 

// get all friends
  $get_friends=mysql_query("select u.first_name,u.last_name,u.id from   friends as f 
   join user as u on(u.id=f.friend_id) where f.user_id 	='".$UserID."' AND f.user_type = 'user' AND f.friend_type = 'user' group by f.friend_id");
// end here 
$titleofpage="Shout Out";
include('LoginHeader.php');
?>
<!--<script src="js/jquery.autocomplete.js"></script>-->
<link rel="stylesheet" href="js/codejs/jquery-ui.css">
<script src="js/codejs/jquery-1.10.2.js"></script>
<script src="js/codejs/jquery-ui.js"></script>

<script>
function Validate_us_FileUpload(){
		var check_image_ext = $('#image_file').val().split('.').pop().toLowerCase();
		//alert(check_image_ext);
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg']) == -1) {
			alert('Usershout Image only allows file types of GIF, PNG, JPG and JPEG');
			$('#image_file').val('');
		}
}

function Validate_us_VideoUpload(){
		var check_image_ext = $('#video_file').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
				alert('Usershout Video only allows file types of MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
					$('#video_file').val('');
		}
}
	
$(function() {
				  <?php 
				  $i=0;
				  while($rs=@mysql_fetch_assoc($get_groups)) {
					  $val[$i]['id']=$rs['id'];
					 $val[$i]['label']=$rs['group_name'];
					 $i++;
				  }
				 $js_array = json_encode($val); 
				 
				   ?>
		var availableTags = <?php echo $js_array ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt2').val($('#txt2').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
			
			   <?php 
				  $l=0;
				  while($rs2=@mysql_fetch_assoc($get_friends)) {
					  $val2[$l]['id']=$rs2['id'];
					 $val2[$l]['label']=$rs2['first_name']." ".$rs2['last_name'];
					 $l++;
				  }
				 $js_array2 = json_encode($val2); 
				 
				   ?>
		var availableTags2 = <?php echo $js_array2 ?>;
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#search_val2" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags2, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					$('#txt_f').val($('#txt_f').val()+ui.item.id+',');
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					
					return false;
				}
			});
	});
</script>



 <?php
	$userID = $_SESSION['user_id'];
	/******************/
	if(isset($_POST['submit']))
	{

		//echo "<pre>"; print_r($_POST); 

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
			// smart_resize_image(null , file_get_contents($image), 324 , 200 , false , $resizedFile , false , false ,100);

			$resizeObj = new resize($file);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage(300, 200, 'auto');

			// *** 3) Save image ('image-name', 'quality [int]')
			$resizeObj -> saveImage($resizedFile, 100);

		}
		
		$message= mysql_real_escape_string($_POST['shout']);

		$title=mysql_real_escape_string($_POST['sname']);
		$user_type = $_SESSION['user_type'];
		$user_id =  $_SESSION['user_id'];
		$date = date("Y-m-d H:i:s");
		$shout_type=$_POST['shout_type'];
		if(isset($_POST['group']))
		{
			$groups=$_POST['group'];
		}
		else
		{
			$groups="";
		}
		if(isset($_POST['friend']))
		{
			$friend=$_POST['friend'];
		}
		else
		{
			$friend="";
		}

		$namesArray = explode(",", $_POST['search_val']);
		$string = "";
		foreach($namesArray as $v )
		{
			$val = trim($v);
			if(!empty($val))
			{
				$string .= "'".$val."',";
			}
		}

$String =  rtrim($string,',');
$groupString = "";
$friendString = "";
$clubString = "";
		$checkGroup = mysql_query("SELECT * FROM `chat_groups` WHERE `group_name` IN (".$String.") AND `group_type` != 'streaming'  ");
		if(mysql_num_rows($checkGroup) > 0)
		{
			while($fetchResult = mysql_fetch_assoc($checkGroup))
			{
				$groupString .= $fetchResult['id'].","; 
			}
			$groups = rtrim($groupString,',');

		}

		$checkfriend = mysql_query("SELECT * FROM `user` WHERE `profilename` IN (".$String.") ");
		if(mysql_num_rows($checkfriend) > 0)
		{
			while($fetchResult = mysql_fetch_assoc($checkfriend))
			{
				$friendString .= $fetchResult['id'].","; 
			}
			$friend = rtrim($friendString,',');

		}

		$checkclub = mysql_query("SELECT * FROM `clubs` WHERE `club_name` IN (".$String.") ");
		if(mysql_num_rows($checkclub) > 0)
		{
			while($fetchResult = mysql_fetch_assoc($checkclub))
			{
				$clubString .= $fetchResult['id'].","; 
			}
			$Clubstring = rtrim($clubString,',');

		}
		

// echo $friend."<br />".$Clubstring."<br />".$groups; exit;



		$sql = "INSERT INTO shouts (`image_thumb`,`user_id`,`shout`,`added_date`,`user_type`,`shout_title`,`shout_image`,`shout_video`,`shout_type`,`group_id`,`friends_id`)
		VALUES('".$thumbnail."','".$user_id."','".$message."','".$date."','".$user_type."','".$title."','".$path."','".$video."','".$shout_type."','".$groups."','".$friend."')";
		$ins_id1 = mysql_query($sql); 
		$ins_id = mysql_insert_id();
		
		if($_POST['shout_type'] == "public"){

			$forum = mysql_real_escape_string($_POST['sname']);
			$description = mysql_real_escape_string($_POST['shout']);
			$user_id = $userID;
			$added_on = date('Y-m-d');
			$city = $_SESSION['id'];
			$state = $_SESSION['state'];
			$country = $_SESSION['country'];
			$forum_type = "public";
			$status = "1";
			$user_type = "user";
			$from_user = $userID;
			$post_from = "city_talk";
			
		}		
		
		
		
		
		
		/* for shout_count */
		$shout_count_sql="INSERT INTO shout_count (shout_id,user_id,total_read,total_sent,friends_id)
		VALUES('$ins_id','$user_id','','','$friend')";
		mysql_query($shout_count_sql);
			/* */
		//if($ins_id)
		//{
			
		if(!empty($Clubstring))
		{
			$groups_clubs1 = rtrim($clubString,",");
			$groups_clubs = explode("," , $groups_clubs1);
			//echo "<pre>"; print_r($groups_clubs); exit;
			array_filter($groups_clubs);
			$uids_clubs_grps = array();
			
			// array_pop($groups_clubs);
			//echo "<pre>"; print_r($groups_clubs); exit;
			foreach($groups_clubs as $single_club_grp_id){
				$uids_clubs_grps[] = $single_club_grp_id;
						// $trimmed_clb = trim($single_club_grp_id);
						
						// if(!empty($trimmed_clb) && $trimmed_clb != ' ' && $trimmed_clb != ''){
						
						// 	$get_club_id = mysql_query("SELECT id FROM clubs WHERE club_name = '".mysql_real_escape_string($trimmed_clb)."'");
						// 	$clb_id = mysql_fetch_assoc($get_club_id);
				
						// 	$uids_clubs_grps[] = $clb_id['id'];
						
						// }
			}
			
			array_unique(array_filter($uids_clubs_grps));
			
			foreach($uids_clubs_grps as $club_user_id){
							
				$ValueArray_o = array($club_user_id,'shout',$ins_id,$user_id, 'club');	
				$FieldArray_o = array('user_id','cont_type','cont_id','owner_id', 'friend_type');
				$Success2 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_o,$FieldArray_o);
				
				$shout_added_on = date('Y-m-d h:i:s');
				$c_identifier = "shouts_".$ins_id;
				
				mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$user_id."', '".$club_user_id."', 'shout', '".$shout_added_on."', '1', '".$c_identifier."', 'user', 'club')");
					
			}
		}


		/* for host insertion in the user_to_content table */	

		
		/* for host insertion in the user_to_content table */	
			
			$ValueArray_o = array($user_id,'shout',$ins_id,$user_id);	
			$FieldArray_o = array('user_id','cont_type','cont_id','owner_id');
			$Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_o,$FieldArray_o);
			if($shout_type=='public')
			{
				
				$get_fds=mysql_query("select f.friend_id from  friends as f 
				where f.user_id ='".$_SESSION['user_id']."' AND f.user_type='user' AND f.status IN ('active') AND f.friend_type='user' group by f.friend_id");
				while($al_fr=@mysql_fetch_assoc($get_fds))
				{
					$ValueArray_f = array($al_fr['friend_id'],'shout',$ins_id,$user_id);	
					$FieldArray_f = array('user_id','cont_type','cont_id','owner_id');
					$Success2 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_f,$FieldArray_f);
					$shout_added_on = date('Y-m-d h:i:s');
					$c_identifier = "shouts_".$ins_id;
					
					mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$user_id."', '".$al_fr['friend_id']."', 'shout', '".$shout_added_on."', '1', '".$c_identifier."', 'user', 'user')");

				}
			}
			else
			{

				if(!empty($groupString))
				{
					$groups1 = $groups;
					$groups_main = explode("," , $groups1);
					array_filter($groups_main);					
					$uids_grps = array();
					
						foreach($groups_main as $single_grp_id){
							
							$trimmed_grp = trim($single_grp_id);
							
							if(!empty($trimmed_grp) && $trimmed_grp != ' ' && $trimmed_grp != ''){
								
								$grp_id = mysql_query("SELECT id FROM chat_groups WHERE id = '".mysql_real_escape_string($trimmed_grp)."'");
								$gid = mysql_fetch_assoc($grp_id);
							
									$g_user=mysql_query("SELECT user_id FROM `chat_users_groups` WHERE `group_id` = '".$gid['id']."'");
									while($al_gr = mysql_fetch_assoc($g_user))
									{
										$uids_grps[] = $al_gr['user_id'];
				
									}
							}
						}
						
						array_unique(array_filter($uids_grps));
				}
				
				//print_r($uids_grps);
				
				if(!empty($friendString))
				{
					$friend1 = $friend;
					$friend = explode(",",$friend1);
					array_filter($friend);
					$friend_ids = array();
					
					foreach($friend as $single_friend_ids1){
						$friend_ids[] = $single_friend_ids1;
						// $trimmedf = trim($single_friend_ids1);
						
						// if(!empty($trimmedf) && $trimmedf != ' ' && $trimmedf != ''){
						
						// $get_usr_id = mysql_query("SELECT id FROM user WHERE profilename = '".mysql_real_escape_string($trimmedf)."'");
						// $usr_id = mysql_fetch_assoc($get_usr_id);
			
						// $friend_ids[] = $usr_id['id'];
						// }
						
					}
					
					array_unique(array_filter($friend_ids));
				}
				
				
				if(empty($uids_grps)){
					
					$user_ids_main_arr = array_unique($friend_ids);
					
				}elseif(empty($friend_ids)){
					
					$user_ids_main_arr = array_unique($uids_grps);
					
				}else{
				
				$user_ids_main_arr = array_unique(array_merge($uids_grps,$friend_ids));
				
				}
				
				if(($key = array_search('1', $user_ids_main_arr)) !== false) {
					unset($user_ids_main_arr[$key]);
				}

					foreach($user_ids_main_arr as $s_id){
						
						$ValueArray_g = array($s_id,'shout',$ins_id,$user_id);	
						$FieldArray_g = array('user_id','cont_type','cont_id','owner_id');
						$Success3 = $Obj->Insert_Dynamic_Query("user_to_content",$ValueArray_g,$FieldArray_g);
						
						$shout_added_on = date('Y-m-d h:i:s');
						$c_identifier = "shouts_".$ins_id;
						
						mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$user_id."', '".$s_id."', 'shout', '".$shout_added_on."', '1', '".$c_identifier."', 'user', 'user')");						
						
						
					}
			}
			
		//}
	 // posting to facebook if login 
		include 'login/facebook.php';
		$appid 		= "688073574590787";
		$appsecret  = "acdbc4b9054bbc4c7e318b42a05d92fd";
		$facebook   = new Facebook(array(
			'appId' => $appid,
			'secret' => $appsecret,
			'cookie' => TRUE,
		));
		$fbuser = $facebook->getUser();
		if($fbuser)
		{
		   $user_profile = $facebook->api('/me');
			$attachment = array('message' => '',
				   'access_token' => $token,
					'name' => 'Sent by mySitti.com',
					'caption' => $_POST['sname'],
					'link' => 'https://mysitti.com',
					'message' => $_POST['shout'],
					'image' => '@' . realpath('https://mysitti.com/'.$v_name)
					);

				$result = $facebook->api('/me/feed/', 'post', $attachment);
		}
					
				 
		// end here 

		// for twitter posting 
		if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
		{	//Success, redirected back from process.php with varified status.
			include_once("twitter/config.php");
			include_once("twitter/inc/twitteroauth.php");
			//retrive variables
			$screenname 		= $_SESSION['request_vars']['screen_name'];
			$twitterid 			= $_SESSION['request_vars']['user_id'];
			$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
			$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
			//Post text to twitter
			$my_update = $connection->post('statuses/update', array('status' => $_POST['shout']."Posted From MySitti"));
		}
				 // end here 
				 
				 // google plus 
				  /*    $moment_body = new Google_Moment();
						$moment_body->setType("http://schemas.google.com/AddActivity");
						$item_scope = new Google_ItemScope();
						$item_scope->setId("target-id-1");
						$item_scope->setType("http://schemas.google.com/AddActivity");
						$item_scope->setName("The Google+ Platform");
						$item_scope->setDescription("A page that describes just how awesome Google+ is!");
						$item_scope->setImage("https://developers.google.com/+/plugins/snippet/examples/thing.png");
						$moment_body->setTarget($item_scope);
						$momentResult = $plus->moments->insert('me', 'vault', $moment_body);*/
										 
				 // end herte 
				 
				 
		//$_SESSION['success']="shout added successfully";
		//header('Location: shout.php');
		$Obj->Redirect("user_shout.php?msg=added");die;
				 
	}
		
		?>
		<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
				<h2>Shout Out</h2>
				
			 <?php
	   if($message!="")
	   {
	   ?>
	  <div style="display:block;" id="successmessage"><?php echo $message; ?> </div> 
	   <?php
	 } ?>
			
				
			
		 
		 
				<div class="profileright">
					<div id="profile_boxs">
	   <form name="shout_out" id="shout_out" method="post"   enctype="multipart/form-data" onsubmit="return validate_video();">
	   
		 <div class="form_format"> 
			<ul>
		   <li>Shout Name<span style="color:#F00">*</span>:</li>
		   <li>
			<input type="text" name="sname" required id="sname" value="">
			 </li>
		 </ul>
		 
			<ul>
			<li>Shout Message<span style="color:#F00">*</span>:</li>
			<li>
			<textarea  cols="40" rows="5" required name="shout" id="shout"></textarea>
			</li>
			</ul>
		
	<ul>
		<li class="label" style="font-size:16px;font-weight:bold">Shout Media:</li>
		<li class="formw">
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
		</li>
	</ul>

			<ul>
		   <li>Shout Type:</li>
		   <li >
		   Public: <input type="radio" name="shout_type" checked="checked" value="public" onclick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();"  style="width: 20px;">
			Private: <input name="shout_type"  value="private" onclick="javascript:$('#groups').show();$('#friends').show();$('#or').show();"   type="radio" style="width: 20px;">
			 </li>
		 </ul>
		 
		 
		  <ul id="groups" style="display:none;">
		   <li>Send To groups:</li>
		   <li>
		   <textarea cols="40" rows="5" id="search_val"></textarea>
			 <input type="hidden" name="group" id="txt2">
		 
				<p>Please type first few letters</p>
			 </li>
		 </ul>
<!--         <div id='or' style="display:none; margin-left:150px;"> <strong>OR</strong> </div>-->
		 <ul id="friends" style="display:none;">
		   <li>Send To Friends:</li>
		   <li>
		   <textarea cols="40" rows="5" id="search_val2"></textarea>
			 <input type="hidden" name="friend" id="txt_f">
				<p>Please type first few letters</p>
			 </li>
		 </ul>
		 
		<ul><li>&nbsp;</li>
		 
		  <li>  <div class="shoutout_btns" id="submit_btn"><input class="btn_ss button" name="submit" type="submit" value="Send" />
		  <!-- <input name="submit" class="button" type="button" value="Reset Video" onclick="resetvideoimage('video_file')" /> -->
			<!-- <input name="submit" class="button" type="button" value="Reset Image" onclick="resetvideoimage('image_file')" /> -->
			<a href="user_shout.php" class="button" style="width: 100px;">Cancel</a></div></li></ul>
			 </div>
	   </form>
		</div>              
				 </div>
				</div>    
		 </div>
		

				<!-- <h1>Shout Out</h1> -->
				 <?php include('friend-right-panel.php'); ?>
	 </div>
	 

</div>
<?php include('footer.php') ?>

<script>
function resetvideoimage(id){
	$("#"+id).val('');
	$("#"+id).val('');
}
function validate_video()
{
	if(document.getElementById('image_file').value){
		var ext = $('#image_file').val().split('.').pop().toLowerCase();
		if(ext){
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		alert( "Please valid image type" );return false;
		}
		}
	}
	if(document.getElementById('video_file').value)
	{	
		if(document.getElementById('video_file').value){
		var FileExt = document.getElementById('video_file').value.lastIndexOf('.mp4');
		if(FileExt==-1) {    
		alert('Upload Only .mp4,m4v,.flv,.WebM,.f4v');    
		return false;
		}	

		}
	}
	return true;
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
