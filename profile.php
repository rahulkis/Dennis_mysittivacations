<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Profile";

if(isset($_GET['id'])){
	
	if($_GET['id'] == $_SESSION['user_id'] && $_SESSION['user_type'] == 'user'){
		
		header('Location: profile.php');
		die;
	}
	
}
// include('LoginHeader2.php');
include('NewHeadeHost.php');

if(!isset($_SESSION['user_id'])){ $Obj->Redirect('index.php'); die;}
$AutoLoadStreaming = '';
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

    $streamingLaunch = $userArray[0]['streamingLaunch'];
    
    $StreamingLaunchFrom = $userArray[0]['streamingLaunchFrom'];
    
	$fullname = $first_name." ".$last_name;
	$profilename = $userArray[0]['profilename'];

if(!empty($profilename))
{
	$pieces = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n = clean($username_dash_separated);

}

	$streamCode = $userArray[0]['newStreamUrl'];


if(isset($_GET['id']))

{

	$userID_stream = $_GET['id'];

	$userID_type = 'user';

	if($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'user' )

	{

		$AutoLoadStreaming = 'NO';

	}

	else

	{

		$AutoLoadStreaming = 'YES';

	}

}

else

{

	$userID_stream = $_SESSION['user_id'];	

	$userID_type = $_SESSION['user_type'];





	$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `user` WHERE `id` = '$userID_stream'  ");

	$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
    
   

	if($fetchResultStreaming['streamingLaunch'] == '1')

	{

		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `user` WHERE `id` = '$userID_stream'  ");

		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);

		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] == 'encoder') || ($fetchResultStreaming['streamingLaunchFrom'] == 'phone') )

		{

			$AutoLoadStreaming = 'YES';

		}

		else

		{

			$AutoLoadStreaming = 'NO';

		}

	}

	else

	{

		$AutoLoadStreaming = 'YES';

	}

}

?>
<link rel="stylesheet" href="https://mediaelementjs.com/js/mejs-2.9.2/mediaelementplayer.min.css" />
<style type="text/css">
		@media only screen and (max-width: 480px) {
			.battleTv .TV .mejs-container
			{
				height: 320px !important;
			}
		}
		.mejs-mediaelement object, .mejs-mediaelement embed {
			max-width: 99%;
			width: 99% !important;
			height: 100% !important;
		}
		.me-plugin {
			position: absolute;
			float: left;
			width: 100% !important;
			height: 100% !important;
		}
		.mejs-container.mejs-video {
			float: left;
			height: 100% !important;
			width: 100% !important;
		}
		.mejs-mediaelement, .mejs-inner {
			float: left;
			width: 100%;
			height: 100%;
		}
.sxtreme_play_vid video {
	height: 98%;
	margin: 5px 0;
	width: 100%;
}

.mejs-layers .mejs-overlay {
  left: 0;
  position: static !important;
  top: 0;
}

.TV {
  float: left;
  height: 100%;
  width: 100%;
}


.sxtreme_play_vid .mejs-inner iframe
{
	margin: 0px !important;
}

#tv_main_channel
{
	width: 100% !important;
	height: 100% !important;
}
.v2_webcambutton > a, .v2_live_stresm_go > a { 
  float: left; 
}
.v2_webcambutton {
  float: left;
  width: 100%;
}
</style>



<div class="v2_container">
	<div class="v2_wrapper_video">

<?php 

$getStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `user` WHERE `id` = '$userID_stream'  ");

$ST = mysql_fetch_assoc($getStreamingLaunch);



?>



			<div class="v2_play_vid_current" style="height: auto !important;">

			<div class="sxtreme_play_vid <?php if($AutoLoadStreaming == 'YES' && $ST['streamingLaunch'] == '1'){ echo 'changed'; }else{ echo 'offline_stream';}?>" >

   

				<?php



					$swfurl= $SiteURL."live2/live_video.swf?n=".urlencode($n);

					$scale="noborder";

					if($ST['streamingLaunch'] == '1' && !empty($profilename) && $AutoLoadStreaming == 'YES')

					{

						if($userID == $_SESSION['user_id'] && $_SESSION['user_type'] == 'user')

						{



						}

						else

						{

							$getPreviousCounter = mysql_query("SELECT `streamingCounter` FROM `user` WHERE `id` = '$userID' ");

							$fetchCounter = mysql_fetch_assoc($getPreviousCounter);

							$NewstreamingCOUNTER =  $fetchCounter['streamingCounter'] + 1;

							mysql_query("UPDATE `user` SET `streamingCounter` = '$NewstreamingCOUNTER' WHERE `id` = '$userID' ");

						}

					?>

	 <div class="iframe">

<?php
    if($StreamingLaunchFrom == 'phone'){
        ?>
<iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="https://52.37.162.200/live/streamPlayerUrl.php?v=<?php echo $streamCode;?>">
</iframe>
<?php
    }
    else{
        ?>
<iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo $SiteURL;?>live2/channelIframe.php?n=<?php echo $n; ?>&host_id=<?php echo $userID; ?>&user_type=user">
</iframe>
<?php
    }
    ?>

</div>

						<?php

					}

					else

					{

	?>
		<div class="TV">
			<video id="tv_main_channel" style='width:100%;height:420px ;' controls="true"  loop style="display:none;">

	<?php

							if(isset($_GET['id']))
							{

								$userID = $_GET['id'];
							}
							else
							{

								$userID = $_SESSION['user_id'];
							}
							$UserTYPE = 'user';
							$getDefault = mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$userID'  AND `user_type` = 'user'  AND `featured` = '1' ");
							$default_vid = mysql_fetch_assoc($getDefault);
							$getDefault1= mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$userID'  AND `user_type` = '$UserTYPE' AND `featured` = '1' ORDER BY `video_id` DESC LIMIT 1 ");
							$default_vid1 = mysql_fetch_assoc($getDefault1);
							if(mysql_num_rows($getDefault1) > 0)
							{
								if(strrpos($default_vid1['video_nm'], 'youtube.') == true || strrpos($default_vid1['video_nm'], 'youtu.be') == true)
								{
									$type = 'video/youtube';
								}
								else
								{
									$type = 'video/mp4';
								}

					?>
								<source id="mp4Source" src="<?php echo str_replace("../", "",$default_vid1['video_nm']); ?>" type="<?php echo $type; ?>">
					<?php 			

							}

							else

							{

								$getMainDefault = mysql_query("SELECT * FROM `pages` WHERE `page_id` = '13' ");
								$fetchMainDefault = mysql_fetch_assoc($getMainDefault);
								if(strrpos($fetchMainDefault['default_video'], 'youtube.') == true || strrpos($fetchMainDefault['default_video'], 'youtu.be') == true)
								{
									$type = 'video/youtube';
								}
								else
								{
									$type = 'video/mp4';
								}
								?>
									<source id="mp4Source" src="<?php echo str_replace("../", "", $fetchMainDefault['default_video']); ?>" type="<?php echo $type;?>">
					<?php
							}
						?>
						</video>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		console.clear();
		var link = $('#mp4Source').attr('src');
		var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
		var vimeoLink = link && link.match(/(?:vimeo)(?:\.com|\.be)\/([\w\W]+)/i);
		if($('#mp4Source').attr('type') == 'video/youtube')
		{
			//var player = new MediaElementPlayer('#tv_main_channel');
			jwplayer("tv_main_channel").setup({
					file: link,
				});
		}
		else if(vimeoLink)
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link,
					'link': 'vimeo'
				},
				success: function( data ) 
				{
					$('.TV').html(data);
					
				}
			});
		}
		else
		{
			jwplayer("tv_main_channel").setup({
				file: link,
			});
		}


		$('.list_play').each(function(){
			if($(this).hasClass('videourl_'+link))
			{
				$(this).addClass('playing');
				$(this).addClass('active');
			}
			else
			{
				$(this).removeClass('playing');
				$(this).removeClass('active');
			}
		});

		



	});
</script>					
					</div>
	<?php 			}	?>

 </div>

			</div>

		

			<div class="v2_vid_list">

			<div class="thumb_list_battle newbattle extereme_playlist">

		   

			

				<?php

	$get_battle_videos = mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$userID'  AND `user_type` = '$UserTYPE' AND `featured` = '1' ORDER BY `video_id` DESC");

	$count_battle_videos = mysql_num_rows($get_battle_videos);

	

	if($count_battle_videos < 1){

		

		//echo "No video found";

		

	}else{

		

		while($b_row = mysql_fetch_assoc($get_battle_videos)){
?>
	
				<!-- <a id="list_<?php echo $b_row['id']; ?>" class="list_play" href="javascript: void(0);" onclick="change_src('<?php echo $b_row['video_path']; ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a> -->
				<a id="list_<?php echo $b_row['video_id']; ?>" class="list_play videourl_<?php echo str_replace("../", "", $b_row['video_nm']); ?>" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $b_row['video_nm']); ?>','<?php echo $b_row['video_id']; ?>')"><?php echo $b_row['video_title']; ?></a>
				<?php }

	} ?>

	

	</div>
	

			</div>

</div>

</div>
</div>



<?php


$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
//include '../googleplus-config.php';

// ini_set("display_errors", "1");
// error_reporting(E_ALL);




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
<!--<link rel="stylesheet" type="text/css" href="https://mysittidev.com/css/new_portal/style.css" />-->
<style>
.show_all_comments .box3 {
 color: rgb(254, 205, 7);
 text-decoration: underline;
}
.onload_comments {
 display: none;
}
.hide_cm {
 display: none;
}

.load_more_ex a {
  background: #fecd07 none repeat scroll 0 0;
  border: 1px solid #fecd07;
  color: #000;
  cursor: pointer;
  display: table;
  font-size: 15px;
  line-height: normal;
  margin: auto;
  padding: 6px 0;
  position: relative;
  text-align: center;
  text-decoration: none;
  text-transform: uppercase;
  width: 92%;
  z-index: 9;
}

</style>
<?php
$AutoLoadStreaming = '';

if(isset($_GET['id']))
{
	$userID_stream = $_GET['id'];
	$userID_type = 'user';
	if($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'user' )
	{
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom`,`profile_count` FROM `user` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1' && $fetchResultStreaming['streamingLaunchFrom'] == 'encoder')
		{
			$AutoLoadStreaming = 'YES';
		}
		else
		{
			$AutoLoadStreaming = 'YES';
		}
	}
	else
	{
		$AutoLoadStreaming = 'YES';
	}

	$profileViewCount = $fetchResultStreaming['profile_count'];

	if(!isset($_SESSION['Counter'][$userID_stream]) /*&& ($_SESSION['user_id'] != $hostID)*/ )
	{
		$_SESSION['Counter'][$userID_stream] = $profileViewCount + 1;
		$newCounter = $_SESSION['Counter'][$userID_stream];
		mysql_query("UPDATE `user` SET `profile_count` = '$newCounter' WHERE `id` = '$userID_stream' ");
	}







}
else
{
	$userID_stream = $_SESSION['user_id'];	
	$userID_type = $_SESSION['user_type'];


	$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch` FROM `user` WHERE `id` = '$userID_stream'  ");
	$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
	if($fetchResultStreaming['streamingLaunch'] == '1')
	{
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `user` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] == 'encoder') || ($fetchResultStreaming['streamingLaunchFrom'] == 'phone') )
		{
			$AutoLoadStreaming = 'YES';
		}
		else
		{
			$AutoLoadStreaming = 'YES';
		}
	}
	else
	{
		$AutoLoadStreaming = 'YES';
	}
}

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;



if( $AutoLoadStreaming == 'YES' )
{

	?>
<script type="text/javascript">
			$(document).ready(function(){
				setInterval(function()
				{
					$.ajax({
						type: "POST",
						url: "checkStream.php",
						data: {
							'host_id' : '<?php echo $userID_stream; ?>',
							'usertype' : '<?php echo $userID_type; ?>',

						},
						success: function(data){
							//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
							var dd = data.split('++++');
							//alert(dd[1]);
							if($.trim(dd[0]) == "Streaming" )
							{
								
								if($('.sxtreme_play_vid').hasClass('changed'))
								{
								
								}
								else
								{
									$('.sxtreme_play_vid').removeClass('offline_stream').addClass('changed');
									$('.sxtreme_play_vid').html($.trim(dd[1]));
									//$('#GROUPid').val(dd[2]);
									//$('#AjaxChatDiv').empty().append(dd[4]);
									//$('body').append(dd[3]);
									$.ajax({
										type: "POST",
										url: "refreshajax.php",
										data: {
											'host_id' : '<?php echo $userID_stream; ?>',
											'usertype' : '<?php echo $userID_type; ?>',
											'action' : 'updatestreamingcounter',
										},
										success: function(data){

										}
									});
								}
							}
							else
							{
								
								if($('.sxtreme_play_vid').hasClass('offline_stream'))
								{
								
								}
								else
								{
									
									$('.sxtreme_play_vid').removeClass('changed').addClass('offline_stream');
									$('.sxtreme_play_vid').html($.trim(dd[1]));
								//	$('#GROUPid').val('');
									//$('#AjaxChatDiv').html(dd[2]);
									var src = $('#mp4Source').attr('src');
									if($('#mp4Source').attr('type') == 'video/youtube')
									{
										//var player = new MediaElementPlayer('#tv_main_channel');
										jwplayer("tv_main_channel").setup({
												file: src,
											});
									}
									else
									{
										jwplayer("tv_main_channel").setup({
											file: src,
										});
									}
								}
							}


						}
					});
				}, 3000);
			});
		</script>
<?php
}









	//echo "select g.group_name,g.id from  chat_users_groups as cgs  join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' group by g.id";die;
	$get_groups = mysql_query("select g.group_name,g.id from chat_users_groups as cgs join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' AND g.group_type = 'private' group by g.id");
	
	$get_friends = mysql_query("select u.first_name,u.profilename,u.last_name,u.email,u.id from friends as f join user as u on(u.id=f.friend_id) where f.user_id ='".$userID."' AND f.friend_id != '".$userID."' group by f.friend_id");
	/**********************************/
?>
<?php
if($_POST['update'])
{
	
	if(!empty($_POST['thumbnailPhoto']) || !empty($_POST['postVideo']) || !empty($_POST['FullPhoto']) || !empty($_POST['postVideoURL']))
	{

				
		$forum=mysql_real_escape_string($_POST['forum']);
		$forum_img=$_POST['thumbnailPhoto'];
		$forum_video= "";
		$file = $_POST['FullPhoto'];
		if(!empty($_POST['postVideo']))
		{
			$forum_video=$_POST['postVideo'];
		}
		elseif(!empty($_POST['postVideoURL']))
		{
			$forum_video=$_POST['postVideoURL'];
		}
		$user_id=$_SESSION['user_id'];
		$added_on=date("Y-m-d h:i:s");
		$status=1;
		$ThisPageTable='forum';
			
		$forum = mysql_escape_string($_POST['forum']);
		$added_on = date("Y-m-d");
		
		if(!empty($_POST['common_identifier']))
		{
			
			mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."', forum_img = '".$file."', image_thumb = '".$forum_img."', forum_video = '".$forum_video."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0'");
			
			$_SESSION['post_edit_success'] = "updated";
			
		}
		
	}
	else
	{
		
		$forum = mysql_escape_string($_POST['forum']);
		$added_on=date("Y-m-d");
		
		mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0'");
		$_SESSION['post_edit_success'] = "updated";
		
	}
	
}


if($_POST['submit'])
{
	
	$forum=mysql_real_escape_string($_POST['forum']);
	$forum_img=$_POST['thumbnailPhoto'];
	$forum_video= "";
	$file = $_POST['FullPhoto'];
	if(!empty($_POST['postVideo']))
	{
		$forum_video=$_POST['postVideo'];
	}
	elseif(!empty($_POST['postVideoURL']))
	{
		$forum_video=$_POST['postVideoURL'];
	}

	$user_id=$_SESSION['user_id'];
	$added_on=date("Y-m-d h:i:s");
	$status=1;
	$ThisPageTable='forum';
	$common_identifier = date("Ymdhis");
	if($_POST['post_type']=='private')
	{

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

	function delete_comment(id, comments_val) {
		
		var hide_all_split = comments_val.split("show_cm_");
		
		var hide_all = hide_all_split[1];
		
		var get_comments_val = $('#'+comments_val).html();
	
		var split1 = get_comments_val.split("Comment ( ");

		var split2 = split1[1].split(")");
		
		var count = split2[0];
		
		var comments_count = count.trim();
		
		var calculated_comments =  parseFloat(comments_count) - 1;

			var r = confirm("Are you sure you want to delete the comment !");
			if (r == true) {
		
				jQuery.post('ajaxcall.php', {'delete_commment_id':id}, function(response){
					
					if(response == "deleted"){
						$('.c_box_'+id).remove();
						$('#'+comments_val).text('Comment ( '+calculated_comments+' )');
						
						if (calculated_comments == 0) {
							$('#showLess_'+hide_all).hide();
							$('#loadMore_'+hide_all).hide();
						}
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
		var url = 'f_id='+id+'&from=profile';
		$("#glike_"+id).html("Loading..");
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
	
</script>
</script>
<!-- end for toggle menu -->


<div class="clear"></div>
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
	<article class="forum_content v2_contentbar newArticle">
 
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

form {
  max-width: 100%;
}
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
	
a.commentuser{
	text-decoration: none;
	}	
</style>
		  <?php   

	if( (!isset($_GET['id'])) )
	{

?>
		  <div id="ad_profile_pst">
			<form id="CityTalkForm" class="popupform" name="forum" action="" method="post" onSubmit="return validate_forum();" enctype="multipart/form-data">
			  <div class="ppost_newdesign">
				<div class="lbl whbtn">
				  <label >What&#39;s happening ?</label>
				  <div id="u_0_s" class="_6a _m"> <a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb" onClick="ShowUploadPop();"> <span class="uiIconText _51z7"> <i class="img sp_6gM6z_J0XH8 sx_a8afaf"> <img src="<?php echo $SiteURL; ?>images/upload_camera.png"> </i>Add Photo/Video<i class="_2wr"></i> </span>
					<div class="_3jk">
					  <input type="hidden" name="thumbnailPhoto" value="" id="thumbnailPhoto"  />
					  <input type="hidden" name="FullPhoto" value="" id="FullPhoto"  />
					  <input type="hidden" name="postVideo" value="" id="postVideo"  />
					  <input type="hidden" name="postVideoURL" value="" id="postVideoURL"  />
					  <!-- <input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()"> --> 
					  <span style="display: none;" id="file_upload_successs"> <img src="<?php echo $SiteURL; ?>images/tick_green_small.png"> </span> </div>
					</a> </div>
				  <textarea id="add_post_text"  name="forum" class="txt_box clear_flds" /></textarea>
				</div>
				<div class="clear"></div>
				<div class="private_pub_btn whbtn">
				  <div id="" class="pst_buttons">
					<div id="posting_type" class="public_new_btn"> <span class="pt_header pt_header1">Public</span>
					  <div class="radiosn">
						<div class="radioboxes_new">
						  <div class="v2_pub">
							<input type="radio" name="post_type" checked="checked" value="public" onClick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();$('.pt_header').html('Public');"  >
							Public
							<p>Anyone Can See.</p>
						  </div>
						  <?php 
						if($_SESSION['user_type'] == "user")
							{?>
						  <div class="v2_priv">
							<input name="post_type"  value="private" onClick="javascript:$('#groups').show();$('#friends').show();$('#or').show();$('.pt_header').html('Private');"   type="radio" >
							Private
							<p>Only Friends and Selected Groups.</p>
						  </div>
						  <?php } ?>
						</div>
						<div style="clear:both"></div>
					  </div>
					</div>
					<div class="v2_btn_updat">
					  <input id="submit3" type="submit" name="submit" value="Post" class="button add_pub_p_post" style=""  />
					</div>
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
		  <div id="middle" style="min-height:329px;" class="profile_page">
			<?php 
	$sql12 = @mysql_query("SELECT * FROM `forum` as f, `user` as u WHERE f.user_id = '$userID' AND f.user_id = u.id AND f.forum_type IN ('public','regular') AND f.status = '1' AND f.post_from = 'profile' ORDER BY `forum_id`  DESC");	
	$count = @mysql_num_rows($sql12);

$SQL = "SELECT * FROM `forum` as f, `user` as u WHERE f.user_id = '$userID' AND f.user_id = u.id AND f.forum_type IN ('public','regular') AND f.status = '1' AND f.post_from = 'profile' ORDER BY `forum_id`  DESC";
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
			if($row['postfrom_usertype'] == 'user')
			{
				//echo "SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ";
				$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");
				$fetchusersql = @mysql_fetch_array($getusersql);
				//echo "<pre>"; print_r($fetchusersql); die;
				$row['image_nm'] = $fetchusersql['image_nm'];
				$fullname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
				$pname = $fetchusersql['profilename'];
				$pageLink = 'profile.php?id='.$fetchusersql['id'];
			}
			elseif($row['postfrom_usertype'] == 'club')
			{
				
				$getusersql = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$row['from_user']."' ");
				$fetchusersql = mysql_fetch_array($getusersql);
				
				$row['image_nm'] = $fetchusersql['image_nm'];
				$fullname = $fetchusersql['club_name'];
				$pname = $fetchusersql['club_name'];
				$pageLink = 'host_profile.php?host_id='.$fetchusersql['id'];
			}
			elseif(empty($row['postfrom_usertype'] ))
			{
				if($row['user_type'] == 'user')
				{
					//echo "SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ";
					$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");
					$fetchusersql = @mysql_fetch_array($getusersql);
					//echo "<pre>"; print_r($fetchusersql); die;
					$row['image_nm'] = $fetchusersql['image_nm'];
					$fullname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
					$pname = $fetchusersql['profilename'];
					$pageLink = 'profile.php?id='.$fetchusersql['id'];
				}
				elseif($row['user_type'] == 'club')
				{
					
					$getusersql = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$row['from_user']."' ");
					$fetchusersql = mysql_fetch_array($getusersql);
					
					$row['image_nm'] = $fetchusersql['image_nm'];
					$fullname = $fetchusersql['club_name'];
					$pname = $fetchusersql['club_name'];
					$pageLink = 'host_profile.php?host_id='.$fetchusersql['id'];
				}
			}

			
		}
		else
		{
			$row['image_nm'] = $row['image_nm'];
			$fullname = $row['first_name']." ".$row['last_name'];
			$pname = $fetchusersql['profilename'];
		}
	 
	 ?>
			<div class="post blog1 post blog1 v2_post_citytalk">
			  <div class="v2_blogpost_user_new">
				<div class="deletPost">
				  <?php
					
					//if(isset($_GET['id'])){}else{
					if( ( $row['user_id'] == $_SESSION['user_id'] && $row['user_type'] == $_SESSION['user_type'] ) || ($row['from_user'] == $_SESSION['user_id'] && $row['postfrom_usertype'] == $_SESSION['user_type'] )){ ?>
				  <!-- edit controls -->
				  <div class="manage_current_p_post manage"> <a class="edit_post_pro" title="Edit" onClick="edit_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"> <img src="<?php echo $SiteURL; ?>images/edti_post1.png"> </a>
					<?php if(empty($row["common_identifier"])){ ?>
					<a class="del_post_pro"  title="Delete" onClick="delete_forum_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"> <img src="<?php echo $SiteURL; ?>images/del_post.png"> </a>
					<?php }else{ ?>
					<a class="del_post_pro"  title="Delete" onClick="delete_post('<?php echo $row["common_identifier"]; ?>');" href="javascript:void(0);"> <img src="<?php echo $SiteURL; ?>images/del_post.png"> </a>
					<?php } ?>
				  </div>
				  <!-- /edit controls -->
				  <?php }//} ?>
				</div>
				<div class="thumb_user_profile"> <a href="<?php echo $pageLink; ?>" class="pic">
				  <?php
						if($row['image_nm']=="")
						{ 
					?>
				  <img src="<?php echo $SiteURL; ?>images/man1.jpg" />
				  <?php 
						}
						else
						{ 
							$imagesrc = $row['image_nm'];
				?>
				  <img src="<?php echo $SiteURL.$imagesrc; ?>" />
				  <?php 		}	?>
				  </a> </div>
				<div class="profileUserName"> <a href="<?php echo $pageLink; ?>" class="pic">
				  <?php if($pname == ""){ echo $fullname; }else{ echo $pname; } ?>
				  </a> 
				<br />
				<div class="clear"></div>
				<div class="dateposted">
				  <?php 
						if($row['added_on'] != '0000-00-00')
						{	
							echo date('F j, Y',strtotime($row['added_on'])); 
						}
						elseif($row['event_date'] != '0000-00-00 00:00:00')
						{
							echo date('F j, Y',strtotime($row['event_date'])); 	
						}
					?>
				</div></div>
			  </div>
			  <div class="sub_post blog_content_new">
				<div class="post_container_left" id="forumcontent">
				  <h1 id="cntrls" class="profileHead"> <?php echo $row['forum']; ?> </h1>
				  <?php 
						$share_img='';
						if($row["forum_img"]!="") { ?>
				  <div class="posted_image_box"> <a href="<?php echo str_replace('../', '', $row['forum_img']); ?>" rel="group" class="fancybox"><img src="<?php echo str_replace('../', '',$row['image_thumb']); ?>" alt="" /></a> </div>
				  <?php $share_img=$row["forum_img"]; } ?>
				  <?php if($row["forum_video"]!="") { ?>
				  <div class="posted_image_box">
					<?php 
						$url = $row["forum_video"];
						if (strpos($url,'vimeo.com') !== false) {
							$share_img=$url;
						?>
					<iframe src="<?php echo $url;?>" width="300" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<?php }else{ ?>
					<a class="videoPlayer" id="jw_<?php echo $row['forum_id'];?>" href="#dialogx" name="modal">
					<div id="a<?php echo $row["forum_id"];?>"></div>
					<script type="text/javascript">
								 jwplayer("a<?php echo $row["forum_id"];?>").setup({
									file: "<?php echo str_replace('../','',$row['forum_video']);?>",
									height : 140 ,
									width: 200
									});
						</script> 
					</a>
					<?php 	}	?>
				  </div>
				  <?php  $share_img=$row["forum_video"];} ?>
				</div>
				<div class="newCommentSys"> 
				  <!-- div class="like"> 
				  <a href="javascript:void(0);"  <?php //if($is_like <= 0) { ?> onclick="flike('<?php //echo $row["forum_id"];?>');" <?php //} ?>>
									<img src="images/like.jpg" />
								</a>  
					  </div --><div class="commentSys">
					  <?php
								  $sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."'");
									$like_tot= @mysql_num_rows($sql_like);
			 
									$sql_usr_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
									$is_like= @mysql_num_rows($sql_usr_like);
									$find = mysql_query("SELECT * FROM forum_comment where forum_id='".$row["forum_id"]."' ORDER BY id ASC");
									$count_comments = mysql_num_rows($find);
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
						?>
					  ( <?php echo $like_tot; ?> )	
					  | </span> 
					  <!-- <a href="javascript:void(0);" onClick="javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment</a> --> 
					  
					  <!--                        <a id="show_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" onclick="show_all_comments('<?php echo $row['forum_id']; ?>'); javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment ( <?php echo $count_comments; ?> )</a>--> 
					  <!--		<a id="hide_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" style="display:none;" onclick="hide_all_comments('<?php echo $row['forum_id']; ?>'); javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment ( <?php echo $count_comments; ?> )</a>-->
					  
					  <p id="show_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);">Comment ( <?php echo $count_comments; ?> )</p>
					  <p id="hide_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" style="display:none;">Comment ( <?php echo $count_comments; ?> )</p>
					  <?php
									$rep_abs = mysql_query("SELECT user_id FROM forum WHERE forum_id = '".$row["forum_id"]."'");
									
									$get_u_id = mysql_fetch_assoc($rep_abs);
									
									if($get_u_id['user_id'] != $_SESSION['user_id']){ ?>
					  <!-- | <a href="javascript:void(0);" onClick="reportabuse('<?php echo $row["forum_id"];?>');">Report Abuse</a> -->
					  <?php } ?>
					  <?php } ?>
					</div>
				  <ul class="shareit">
					<?php 
							if(isset($_SESSION['user_id']))
							{
							?>
					<li> <a href='javascript:void(0);'> <img src="<?php echo $SiteURL; ?>images/share_pst.png" alt="Share Post"/> </a>
					  <ul>
						<li> <a href="javascript:void(0);" onclick="sharepostPublic('<?php echo $row['forum_id'];?>');">Public</a> </li>
						<li> <a href="javascript:void(0);" onclick="sharepostPrivate('<?php echo $row['forum_id'];?>');">Friends List</a> </li>
					  </ul>
					</li>
					<?php }	?>
					<li> <a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onClick="return fbs_click('https://www.mysittidev.com/<?php echo $share_img;?>', 'mysittidev.com' )" target="_blank" style="text-decoration:none;"><img src="<?php echo $SiteURL; ?>fbook.png" alt="Share on Facebook"/></a> </li>
					<li> <a href="#" onClick="return fbs_click123('https://www.mysittidev.com/<?php echo $share_img;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="<?php echo $SiteURL; ?>twt.png" alt="Share on Twitter"/></a> </li>
					<li> <a href="https://plus.google.com/share?url=https://www.mysittidev.com/<?php echo $share_img;?>" onClick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?php echo $SiteURL; ?>g+.png" alt="Share on Google+"/></a> </li>
				  </ul>
						
				  </div>
				<div class="comment_box commentdisplay">
				  <div class="comments_load_more_section comments_load_more_section_main_<?php echo $row["forum_id"];?>">
					<button id="loadMore_<?php echo $row["forum_id"];?>" class="btn button">Show Previous Comments</button>
					<img src="images/post-19702-0-58437300-1327865075.gif"> </div>
				  <div class="cmnts_container" id="comment_all_<?php echo $row["forum_id"];?>">
					<input type="hidden" id="num_comments_<?php echo $row['forum_id'];?>" value="<?php echo $count_comments; ?>" />
					<input type="hidden" id="set_show_val_<?php echo $row['forum_id']; ?>" value="0">
					<div class="box3 input_comment_area show_all_comments" id="show_count_comments_<?php echo $row["forum_id"]; ?>">
					  <div class="box4"> 
						<!--   <div class="show_cmnt" onClick="show_all_comments('<?php echo $row['forum_id']; ?>');" id="show_cm_<?php echo $row['forum_id']; ?>">Show comments : <?php echo $count_comments; ?></div>
						  <div class="hide_cm" onClick="hide_all_comments('<?php echo $row['forum_id']; ?>');" id="hide_cm_<?php echo $row['forum_id']; ?>">Hide all comments</div> --> 
					  </div>
					</div>
					<?php
								$row_i = 0;
								while($row2 = @mysql_fetch_assoc($find)){ ?>
					<div class="jquery_unloaded_comments_<?php echo $row["forum_id"];?> box3 box3_hide_rep onload_comments hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>"> 
					  
					  <!-- <div class="pic1"> -->
					  <?php $commentDatetime = date('F j, g:i a',strtotime($row2['added_date']));
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
					  <div class="commentator">
						<?php if($row2['user_type'] == "user"){

								if($_SESSION['user_id'] == $row2['user_id']){ ?>
						<a href="profile.php">
						<?php }else{ ?>
						<a href="profile.php?id=<?php echo $row2['user_id']; ?>">
						<?php }
							
							 }elseif($row2['user_type'] == "club"){ ?>
						<a href="host_profile.php?host_id=<?php echo $row2['user_id']; ?>">
						<?php }								
								
								
								
								if($getdet['image_nm']=="") { ?>
						<img src="<?php echo $SiteURL; ?>images/pic1.jpg" />
						<?php }else{ ?>
						<img width='40' height='40' src="<?php echo $getdet['image_nm']; ?>"  />
						<?php } ?>
						<!-- </div> --> 
						</a> </div>
					  <div class="commentator_info">
						<?php 
										if($row2['user_type'] == 'club')
										{
											?>
						<a href="host_profile.php?host_id=<?php echo $row2['user_id']; ?>" class="commentuser"><?php echo $getdet['club_name']; ?></a><span class="commentDate"><?php echo $commentDatetime; ?></span>
						<div class="clear"></div>
						<?php echo $row2['content']; ?></div>
					  <?php 
										}
										else
										{
											
											if($_SESSION['user_id'] == $row2['user_id']){ ?>
					  <a href="profile.php" class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a>
					  <?php }else{ ?>
					  <a href="profile.php?id=<?php echo $row2['user_id']; ?>" class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a>
					  <?php } ?>
					  <span class="commentDate"><?php echo $commentDatetime; ?></span>
					  <div class="clear"></div>
					  <?php echo $row2['content']; ?> </div>
					<?php 
										}
									?>
					<?php 
										if($_SESSION['user_id'] != '' && $row2['user_id'] == $_SESSION['user_id'] && $row2['user_type'] == $_SESSION['user_type'])
										{
									?>
					<img class="delete_Comment" onClick="delete_comment('<?php echo $row2['id']; ?>', 'show_cm_<?php echo $row['forum_id']; ?>');" width="16px" height="16px" src="images/del-notification.png" style="float: right; cursor: pointer; border: medium none;">
					<?php 

										}elseif($row['from_user'] == $_SESSION['user_id'] && $_SESSION['user_type'] == 'user'){
											
												?>
					<img class="delete_Comment" onClick="delete_comment('<?php echo $row2['id']; ?>', 'show_cm_<?php echo $row['forum_id']; ?>');" width="16px" height="16px" src="images/del-notification.png" style="float: right; cursor: pointer; border: medium none;">
					<?php
						  
										}
									?>
				  </div>
				  <?php $row_i++; } ?>
				</div>
				<?php if($_SESSION['user_id']!=""){
						
					if($count_comments > 3){
					?>
				<script type="text/javascript">
							$(document).ready(function () {
								
								$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>').last().addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
								
								$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>:nth-last-child(2)').addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
								
								$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>:nth-last-child(3)').addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
								
								$('#loadMore_<?php echo $row["forum_id"];?>').click(function () {
									
									var count_li = $('.jquery_unloaded_comments_<?php echo $row["forum_id"];?>').length;
									
									if (count_li >= 13) {
										
												$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').show();
												
												setInterval(function(){
													
														
														$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>:gt("+($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length-11)+")").addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
														
														$('.comments_load_more_section > img').hide();
													
												}, 2000);
									
									}else{

										if ($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length == count_li) {							
											
												$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').show();
												
												setInterval(function(){
													
															$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>:gt("+($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length - count_li)+")").addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
															
															$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").first().addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
														
														$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').hide();
														
														$('#loadMore_<?php echo $row["forum_id"];?>').hide();
													
												}, 2000);
												
												return false;
											
										}else{
											
												$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').show();
												
												setInterval(function(){
													
														
														$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>:gt("+($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length - count_li)+")").addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
														
														$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').hide();
													
												}, 2000);
												
												return false;
											
										}
										
									}
								});
							});
						</script>
				<?php }else{ ?>
				<script type="text/javascript">
							$(document).ready(function () {
								$('#loadMore_<?php echo $row["forum_id"];?>').hide();
								$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>:lt(3)').addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
							});
						</script>
				<?php } ?>
				<div class="clear"></div>
				<div class="box3 input_comment_area">
				  <input type="hidden" id="fid_<?php echo $row["forum_id"];?>" value="<?php echo $row["forum_id"];?>">
				  <div class="commentwrap">
					<div align='center'>
					  <input name="button" class="button btn_sub_comnt" id="co_submit_<?php echo $row["forum_id"]; ?>"  onclick="addform('<?php echo $row["forum_id"];?>');" type="button" value="Add Comment" />
					  <img id="comment_load_<?php echo $row["forum_id"]; ?>" src="<?php echo $SiteURL; ?>images/loading-plz.gif" style="margin: -19px 0px 0px 10px; display: none;"> </div>
					<div class="clear"></div>
					<div class="comment_txt">
					  <input name="comment"  onkeydown="javascript:return submitcom(event,'<?php echo $row["forum_id"];?>');"   id="content_<?php echo $row["forum_id"];?>" type="text" placeholder="Write a comment.." value=""/>
					</div>
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
	if($pager->numPages > 1)
	{
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
	}
echo "</div>";		   
		   
}
else
{
		echo "<p id='errormessage' style='display:block;'>No Posts Yet.</p>";
}
}
/* FRIENDS QUERY */
						$getFriends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND `user_type` = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' AND fs.status IN ('active')
						GROUP BY friend_id ORDER BY id ASC");
 ?>
		</div>
	  </div>
<script type="text/javascript">
	$('.videoPlayer').each(function(){
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
</script>
  <div style="display: none;" id="popup3_album_515"> <span class="b-close-album-515">X</span>
	<div style="height: auto; width: auto;" id="mycontent-album-515">
	  <h2 class="shareselect">Select Friends to share Post</h2>
	  <div class="sel_all">
		<input type="checkbox" id="SelectALL" onclick="checkAllfriends();" name="selectAll"  />
		Select All Friends </div>
	  <ul class="SharingFriendslist">
		<?php 
				$i=0;
				while($fetchFriends=mysql_fetch_assoc($getFriends))
				{
					$i++;
					if($fetchFriends['friend_type'] == "user")
					{
						$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
											FROM `user` 
											WHERE `id` = '$fetchFriends[friend_id]'
										");
						$friendResult = mysql_fetch_assoc($friendQuery);
						if($friendResult['profilename'] != "")
						{
							$friendName = $friendResult['profilename'];
						}
						else
						{
							$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
						}

						$friendCityid = $friendResult['city'];
						$friendStateid = $friendResult['state'];
						$friendCountryid = $friendResult['country'];
						$friendID = $friendResult['id'];
						$friendZip = $friendResult['zipcode'];
						$friendSattus = $friendResult['status'];
						$imageSrc = $friendResult['image_nm'];
						$anchorPath =	"profile.php?id=".$friendID;
						$onlineStatus = $friendResult['is_online']; 

					}
					else
					{
						$friendQuery  = mysql_query("SELECT `id`,`is_online`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
											FROM `clubs` 
											WHERE `id` = '$fetchFriends[friend_id]'
											AND `non_member` = 0
										");
						$friendResult = mysql_fetch_assoc($friendQuery);
						$friendName = $friendResult['club_name'];
						$friendCityid = $friendResult['club_city'];
						$friendStateid = $friendResult['club_state'];
						$friendCountryid = $friendResult['club_country'];
						$friendID = $friendResult['id'];
						$friendZip = $friendResult['zip_code'];
						$friendSattus = $friendResult['status'];
						$imageSrc = $friendResult['image_nm'];
						$anchorPath =	"host_profile.php?host_id=".$friendID;
						$onlineStatus = $friendResult['is_online'];
					}
				?>
		<li>
		  <input type="checkbox" name="ShareFriends[]" value="<?php echo $friendID."-----".$fetchFriends['friend_type']; ?>" />
		  &nbsp; <?php echo $friendName;?> </li>
		<?php 	}	?>
	  </ul>
	  <input type="button" id="sharePostfriends" onclick="sharePostFriends();" value="Share" />
	  <input type="hidden" id="forumidtoshare" value="" />
	</div>
  </div>
  </article>
		<div class="adRightBar">
			<?php 
			$getAds = mysql_query("SELECT * FROM `pagesAds` WHERE `page_name` = 'profile' ORDER BY `adid` DESC LIMIT 0,2 ");
			while ($res = mysql_fetch_assoc($getAds))
			{
		?>
			<a href="<?php if(!empty($res['image_link'])){ echo str_replace("mysittidev.com/", 'mysittidev.com/', $res['image_link']);}else{ echo '#';} ?>">
					<img alt="" src="<?php echo $res['image_path'];?>">
				</a>
				<br> <br>
		<?php
			}
		?>
		</div>
</div>
<div id="popupUpload" style="">
  <div id="mycontent122" style="height: auto; width: auto;"> <span onClick="HideUploadPopEmpty();" class="closebutton" style="float:right; cursor:pointer;">X</span>
	<h1 id="title">Choose Upload Media:</h1>
	<div>
	  <label>From Computer: </label>
	  <input type="file" name="ComputerField" id="ComputerField" onChange="return ValidateFileUpload()" />
	</div>
	<div class="Seperator">
	  <label>OR</label>
	</div>
	<div>
	  <label>File Url: </label>
	  <input type="text" name="URLField" id="URLField" onClick="emptyComputerField();" />
	  <br/>
	  <p style="margin-bottom:0">Paste video link here Example:<br />
		http://www.youtube.com/watch?v=a7SJF3ErXZU <br />
		or<br />
		https://player.vimeo.com/video/27578410 </p>
	</div>
	<input type="button" onClick="HideUploadPop();" class="button" value="Upload">
  </div>
</div>
<div class="b-modal" id="modalpopupUpload" style=""></div>
<div class="clear"></div>
</div>
<style type="text/css">
#mycontent122 > .button {
	float: left;
	width: 10%;
	margin: 0 30%;
}
#mycontent122 input {
	float: left;
	width: 90%;
}
#mycontent122 p {
	float: left;
	margin: 5px 0 !important;
	width: 100%;
}
#mycontent122 label {
	float: left;
	margin: 5px 0;
	width: 100%;
}
#popupUpload #mycontent122 > div {
	float: left;
	margin: 10px 0;
	width: 100%;
}
#popupUpload > div#mycontent122 {
	color: #fff;
	float: left;
	padding: 20px;
	width: 100%;
}
#popupUpload h1 {
	color: #fecd07;
	float: left;
	font-size: 20px;
	width: 100%;
	text-decoration: underline;
	font-weight: bold;
	margin: 15px 0;
}

#popupUpload {
	position:fixed;
	width:400px;
	height:auto;
	overflow:auto;
	background:#000;
	z-index:2;
	top: 100px !important;
	color: #FFF;
}
#popupUpload span#close {
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
#popupUpload span.b-close {
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
#popupUpload {
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

 @media only screen and (min-width:768px) and (max-width: 1024px)   { 
 .contestFrm.form_format1 li {
  float: left;
  width: 100% !important;
}

 }
 
 @media only screen and (max-width: 767px) {
 article { 
  width: 100% !important;
}
 .contestFrm.form_format1 li {
  float: left;
  width: 100% !important;
}
#popupUpload {max-width:300px; padding:10px;}
.agreebuttons {
  margin-bottom: 32px;
}
 }
 
 @media only screen and (max-width: 540px) {
#popupUpload {max-width:300px; padding:10px; max-height:400px; overflow:auto;}
.agreebuttons {
  margin-bottom: 32px;
} 
 }


/* SHARE POST CSS */

#popup3_album_515 #sharePostfriends {
  float: left;
  margin: 20px 40%;
  text-align: center;
}
	#popup_adv {
										float: left;
										position: relative;
										width: 100%;
									}
									#inner_popup_adv {
										float: left;
										height: 100%;
										position: absolute;
										width: 100%;
										z-index: 99;
									}	
									#popup3_album_515 {
								  background: #000 none repeat scroll 0 0;
  border: 4px solid #ff0;
  bottom: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  height: auto;
  left: 0;
  margin: auto;
  max-height: 500px!important;
  max-width: 500px!important;
  overflow: auto;
  padding: 10px !important;
  position: fixed;
  right: 0;
  top: 0;
  width: 100% !important;
  z-index: 2;
									}
		 
		#popup3_album_515 h1 {
  padding: 10px 0;
  text-transform: uppercase;
  margin-bottom: 10px;
}
									#popup3_album_515 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
									#popup, #popup2, #popup3_album_515, .bMulti {
										background-color: #000;
										border-radius: 10px;
										box-shadow: 0 0 25px 5px #006099;
										color: #111;
										padding: 25px;
										display: none;
									}
									#popup3_album_515 span.b-close-album-515 { border: none; float: right;color: #fecd07; cursor: pointer;}
										.b-modal1-album-515{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
									
									#popup2 #mycontent-album-515 > p {
										color: white;
										font-size: 15px;
										font-weight: bold;
									}
									
									#popup2 #mycontent-album-515 > span {
										color: white;
									}
									#popup3_album_515									{
										z-index: 99999;
										color: #FFF;
									}
									#popup3_album_515 #mycontent-album-515 > p {
									  border-bottom: 1px solid #fff;
									  font-size: 20px;
									  margin-bottom: 10px;
									  padding-bottom: 10px;
									}
									

									#mycontent-album-515 li {
			background: #000 none repeat scroll 0 0;
float: left;
margin: 10px 1%;
max-height: 150px;
/*min-height: 150px;*/
overflow: hidden;
position: relative;
width: 31.3%;
									}
									
					#mycontent-album-515 li img{
	  max-width:100%; position:absolute; left:0; right:0; top:0; bottom:0; margin:auto;
	 }
									#mycontent-album-515 > ul {
										float: left;
										width: 100%;
									}
		 @media only screen and (min-width:540px) {
							#mycontent-album-515 li { 
width: 48%;
									}
		 }

/* END */






</style>
<script type="text/javascript">
function checkAllfriends()
{
	if($('#SelectALL').is(':checked'))
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', true);
		});	
	}
	else
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', false);
		});	
	}

	
}

/* SHARE POST SCRIPT */

$(document).ready(function(){
	$('.b-close-album-515').click(function(){
		$('#popup3_album_515').hide();
	});
});

function sharepostPublic(forumid)
{
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'forumid' : forumid,
			'action' : 'sharePostPublic',
		},
		success: function(data){
			//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
			alert('Post shared Publically!');
			return false;
		}
	});
}

function sharepostPrivate (forumid) 
{
	$('#popup3_album_515,#fullOverlay').show();
	$('#forumidtoshare').val(forumid);
	$('.SharingFriendslist li input').each(function(){
		$(this).prop('checked', false);
	});
}


function sharePostFriends()
{
	var forumid = $('#forumidtoshare').val();

	var stringids = $.map($(':checkbox[name=ShareFriends\\[\\]]:checked'), function (n, i) {
					return n.value;
			}).join(',');

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'string' : stringids,
			'forumid' : forumid,
			'action' : 'sharePostFriends',
		},
		success: function(data){
			//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
			alert('Post shared with selected Friends!');
			$('#popup3_album_515').hide();
			$('#fullOverlay').hide();
			return false;
		}
	});
}



/* END */






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
function emptyComputerField()
{
	$('#ComputerField').val('')
}
function HideUploadPop()
{
	if($('#URLField').val() == "")
	{

		var data = new FormData();
		$.each($('input[name^="ComputerField"]')[0].files, function(i, file) {
		data.append(i, file);
		});
		var SiteURL = $('#siteURL').val();
		$.blockUI({ css: {
				border: 'none',
				padding: '15px',
				backgroundColor: '#fecd07',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .8,
				color: '#000'
			},
			message: '<h1>Uploading Media</h1>'
		});
		$.ajax({
			url: SiteURL+'NewUploadFile.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(data){
				var result = data.split('+');
				if(result[0] == 'Video')
				{
					$('#postVideo').val(result[1]);
					$('#FullPhoto').val('');
					$('#postVideoURL').val('');
					$('#thumbnailPhoto').val('');
				}
				else
				{
					$('#postVideoURL').val('');
					$('#postVideo').val('');
					$('#FullPhoto').val(result[2]);
					$('#thumbnailPhoto').val(result[1]);

				}
				$.unblockUI({
					onUnblock: function(){
						if($('#CityTalkForm').hasClass('ajaxForm'))
						{
							$('.post_media').find('img').attr('src', result[1]);
						}
						$('#popupUpload').hide();
						$('#modalpopupUpload').hide();

					}
				});
			}
		});
	}
	else
	{
		$.blockUI({ css: {
				border: 'none',
				padding: '15px',
				backgroundColor: '#fecd07',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .8,
				color: '#000'
			},
			message: '<h1>Uploading Media</h1>'
		});
		$('#postVideoURL').val($('#URLField').val());
		$.unblockUI({
			onUnblock: function(){
				$('#popupUpload').hide();
				$('#modalpopupUpload').hide();
			}
		});
	}
}
function ShowUploadPop()
{
	$('#popupUpload').show();
	$('#modalpopupUpload').show();
}

function HideUploadPopEmpty()
{
	$('#popupUpload').hide();
	$('#modalpopupUpload').hide();
}
function ValidateFileUpload(){
	var check_image_ext = $('#ComputerField').val().split('.').pop().toLowerCase();
	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
		alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
		$('#ComputerField').val('');
	}else{
		$('#file_upload_successs').show();
	}
	$('#URLField').val('');
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

function delete_forum_post(forum_id){
	
	var r = confirm("Are you sure want to delete !");
	if (r == true) {

	 $.get( "deletepost.php?forum_id="+forum_id, function( data ) {
			window.location = "";
		});
	
	}
}
</script>
<?php include('LandingPageFooter.php'); ?>
