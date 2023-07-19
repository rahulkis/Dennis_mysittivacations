<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);

$hostID = $_POST['host_id'];
$userType = $_POST['usertype'];
$userID = $hostID;
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

	$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";

$AutoLoadStreaming = '';

function detect_stream_new($hbhost,$userType)
{
	$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/httplive/'.$hbhost.' 2>&1; echo $?';
	$st_res=shell_exec($st_qry);
	if (strpos($st_res,'404 Not Found') === false) 
	{
		if(strrpos($st_res, 'bitrate: N/A'))
		{
			if($userType == 'user')
			{
				mysql_query("UPDATE `user` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'desktop' WHERE `id` = '$hostID' ");
			}
			else
			{
				mysql_query("UPDATE `clubs` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'desktop' WHERE `id` = '$hostID' ");
			}
		}
		else
		{
			if($userType == 'user')
			{
				mysql_query("UPDATE `user` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'encoder' WHERE `id` = '$hostID' ");
			}
			else
			{
				mysql_query("UPDATE `clubs` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'encoder' WHERE `id` = '$hostID' ");
			}
		}
		return true;
		
	}
	else
	{ 
		$st_qry = 'ffmpeg -i rtsp://52.37.162.200:1935/live/'.$hbhost.' 2>&1; echo $?';

		$st_res=shell_exec($st_qry);

		if (strpos($st_res,'404 Not Found') === false) 
		{
			if(strrpos($st_res, 'bitrate: N/A'))
			{
				if($userType == 'user')
				{
					mysql_query("UPDATE `user` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'desktop' WHERE `id` = '$hostID' ");
				}
				else
				{
					mysql_query("UPDATE `clubs` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'desktop' WHERE `id` = '$hostID' ");
				}
			}
			else
			{
				if($userType == 'user')
				{
					mysql_query("UPDATE `user` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'encoder' WHERE `id` = '$hostID' ");
				}
				else
				{
					mysql_query("UPDATE `clubs` SET `streamingLaunch` = '1', `streamingLaunchFrom` = 'encoder' WHERE `id` = '$hostID' ");
				}
			}
			return true;
		}

	}
	return false;

}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}


// if($userType == 'user')
// {
// 	$getUserInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$hostID' ");
// 	$fetchUserinfo = mysql_fetch_assoc($getUserInfo);
// 	$h = clean($fetchUserinfo['profilename']);
// 	if($fetchUserinfo['streamingLaunch'] == '0')
// 	{
// 		detect_stream_new($h,$userType);
// 	}
// }
// else
// {
// 	$getUserInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$hostID' ");
// 	$fetchUserinfo = mysql_fetch_assoc($getUserInfo);
// 	$h = clean($fetchUserinfo['club_name']);
// 	if($fetchUserinfo['streamingLaunch'] == '0')
// 	{
// 		detect_stream_new($h,$userType);	
// 	}
// }






if(isset($hostID) && $userType == 'club')
{
	$userID_stream = $hostID;
	$userID_type = 'club';
	if($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'club' )
	{
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `clubs` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] != 'desktop') && (!empty($fetchResultStreaming['streamingLaunchFrom']) ) )
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
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch` FROM `clubs` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1')
		{
			$AutoLoadStreaming = 'YES';
		}
		else
		{
			$AutoLoadStreaming = 'NO';
		}
	}
}
elseif(isset($hostID) && $userType == 'user')
{
	$userID_stream = $hostID;
	$userID_type = 'user';
	if($userID_stream == $_SESSION['user_id'] && $_SESSION['user_type'] == 'user' )
	{
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch`,`streamingLaunchFrom` FROM `user` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1' && ($fetchResultStreaming['streamingLaunchFrom'] != 'desktop') && (!empty($fetchResultStreaming['streamingLaunchFrom']) ) )
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
		$checkStreamingLaunch = mysql_query("SELECT `streamingLaunch` FROM `user` WHERE `id` = '$userID_stream'  ");
		$fetchResultStreaming = mysql_fetch_assoc($checkStreamingLaunch);
		if($fetchResultStreaming['streamingLaunch'] == '1')
		{
			$AutoLoadStreaming = 'YES';
		}
		else
		{
			$AutoLoadStreaming = 'NO';
		}
	}
}





if( $AutoLoadStreaming == 'YES' )
{


	function detect_mobile()
	{
		/*
		 * commented by kbihm on 19-01-2015
		 if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
		return true;
		 
		else*/
		return false;
	}

	function detect_stream($hbhost)
	{
		$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/httplive/'.$hbhost.' 2>&1; echo $?';
		$st_res=shell_exec($st_qry);
		if (strpos($st_res,'404 Not Found') === false) 
		{
			return true;
		}
		else
		{ 
			$st_qry = 'ffmpeg -i rtsp://52.37.162.200:1935/live/'.$hbhost.' 2>&1; echo $?';

			$st_res=shell_exec($st_qry);

			if (strpos($st_res,'404 Not Found') === false) {
			return true;
			}

		}
		return false;

	}


	function detect_mobile_new()
	{

		 if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
		return true;
		 
		else
		return false;
	}


	$LoogedinID = $_SESSION['user_id'];
	if($userType == "user")
	{
		$sql = "select * from `user` where `id` = '".$hostID."'";
		$userArray = $Obj->select($sql) ; 
		 $plantype = $userArray[0]['plantype'];
		$profilename=$userArray[0]['profilename'];
		$user_address=$userArray[0]['user_address']; 
		$first_name=$userArray[0]['first_name']; 
		$last_name=$userArray[0]['last_name'];
		$fullname = $first_name." ".$last_name;
		$zipcode=$userArray[0]['zipcode'];
		$state=$userArray[0]['state'];
		$country=$userArray[0]['country'];
		if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
		$city=$userArray[0]['city'];
		$email=$userArray[0]['email'];
		$image_nm=$userArray[0]['image_nm'];
		$phone=$userArray[0]['phone'];
		$enablediablephone=$userArray[0]['text_status'];
		//$_SESSION['img']=$image_nm;
		$pieces = explode(" ", $profilename);
		$username_dash_separated = implode("-", $pieces);
		$streamCode = $userArray[0]['newStreamUrl'];
		$n = clean($username_dash_separated);
		if(detect_stream($stream_Code)===true)
	 	{
	 		$gname1=mysql_query("select * from  chat_groups where group_name = '$n' ");

			if(mysql_num_rows($gname1)  < 1 )
			{
				//die('dfdfd');
				mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 
						VALUES ('$n','streaming','$hostID','user') ");
				$ID = mysql_insert_id();
				mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type,loggedin) VALUES ('$ID','$hostID','user','1')");

			}
			else
			{
				$group_dtl=mysql_fetch_assoc($gname1);
				$nowtime = date('Y-m-d H:i:s');
				$ID = $group_dtl['id'];
			}

			


			
	 		?>
	 		Streaming++++<div class="iframe"><iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="https://52.37.162.200/live/streamPlayerUrl.php?v=<?php echo $streamCode;?>"></iframe><?/*<iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo $SiteURL;?>live2/channelIframe.php?n=<?php echo $n; ?>&host_id=<?php echo $hostID; ?>&user_type=user"></iframe>*/?></div>++++<?php echo $ID; ?>++++<?php echo "<script type='text/javascript'>
					function blockUser(uid)
					{
						var ID = $('#GROUPid').val();
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&deleteuserid='+uid,
							cache: false,
							success: function(html)
							{
								$('.refresh').html(html);
								$('#sc').animate({
								    	scrollTop: $('#sc').get(0).scrollHeight
							    	}, 3000);
						  	}
						});
					}

					function deleteMessage(msgid)
					{
						var ID = $('#GROUPid').val();
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&message_id='+msgid,
							cache: false,
							success: function(html)
							{
								console.clear();
								$('.refresh').html(html);
								$('#sc').animate({
								    	scrollTop: $('#sc').get(0).scrollHeight
							    	}, 3000);
						  	}
						});

					}

					function setchat(val)
					{
						$('#textb').val($('#textb').val() + val);
					}

					function Groupfunction()
					{
						console.clear();
						var ID = $('#GROUPid').val();
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID,
							cache: false,
							success: function(html)
							{
								console.clear();
								$('.refresh').html(html);
								$('#sc').animate({
								    	scrollTop: $('#sc').get(0).scrollHeight
							    	}, 1000);
						  	}
						});
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&count=users',
							cache: false,
							success: function(html)
							{
								console.clear();
								$('#chatMembers').html(html);
						  	}
						});
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&view=Viewers',
							cache: false,
							success: function(html)
							{
								console.clear();
								$('span#totalViewers').html(html);
						  	}
						});
					}
					$(document).ready(function() {
						$.ajaxSetup({cache: false});
						console.clear();
						var Interval = setInterval(Groupfunction, 3000);
						
						$('input').keypress(function(event) {
							console.clear();

							if (event.which == 13)
							{
								var ID = $('#GROUPid').val();
								event.preventDefault();
								var text = $('#textb').val();
								$('#textb').val('');
								if(text != '')
								{
									
									$.ajax({
										type: 'POST',
										cache: false,
										url: 'group-chat/save.php',
										data: 'text='+text+'&group_id='+ID+'&sender=".$LoogedinID."',
										success: function(data) {
										    	$('#sc').animate({
											    	scrollTop: $('#sc').get(0).scrollHeight
										    	}, 1000);
										}
									});
								}
							}
						});


						$('#post_button').click(function() {
							var text = $('#textb').val();
							$('#textb').val('');
							if(text != '')
							{
								var ID = $('#GROUPid').val();
								$.ajax({

									type: 'POST',
									cache: false,
									url: 'group-chat/save.php',
									data: 'text='+text+'&group_id='+ID+'&sender=".$LoogedinID."',
									success: function(data) {
										console.clear();
										$('#sc').animate({
										    	scrollTop: $('#sc').get(0).scrollHeight
									    	}, 1000);
									}
								});
							}
						});							
					});</script>"; ?>++++
				<div class="grp_ceond">

							<?php 
								$gname=mysql_query("select * from  chat_groups where group_name='$n' ");
								$group_dtl=mysql_fetch_assoc($gname);
								$nowtime = date('Y-m-d H:i:s');
								$groupID = $group_dtl['id'];
								$chk_user=mysql_query("select  user_id from  chat_users_groups where group_id=".$groupID."");
								$cnt_row=mysql_num_rows($chk_user);
								$my_smilies = array(
									'@!' => '<img src="group-chat/smilies/barmy.gif"/>',
									'||' => '<img src="group-chat/smilies/bash.gif"/>',
									'[]' => '<img src="group-chat/smilies/bottle.gif"/>',
									'%#' => '<img src="group-chat/smilies/bike2.gif"/>',
									'!@' => '<img src="group-chat/smilies/cheer.gif"/>'
									);
								?>
								

						<div class="grpone" >
							<input type="hidden" id="GROUPid" value="<?php echo $groupID; ?>" />
								<script type="text/javascript">
								function userPop(url)
								{
									window.open(url,'1396358792239','width=300,height=330,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=0,left=0,top=0');
									return false;
								}

								</script>
								<input name="message" type="text" id="textb"/>

								<input type="button" class="onlineUsers" onclick="userPop('fetchUsers.php?gID=<?php echo $groupID; ?>');" value="View Users" />
								
								<input name="submit1" type="button" value="Send" id="post_button" />

								<input name="sender" type="hidden" id="texta" value="<?php echo $_SESSION['username']?>"/>
	 							<div class="divider"></div>
							<div class="refresh" id="sc">

								<?php
								//where sent_time > NOW() - INTERVAL 1 HOUR 

								//echo "SELECT * FROM message where group_id=".$ID." AND group_type='streaming' AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id"; exit;

								$result = mysql_query("SELECT * FROM message where group_id=".$groupID." AND group_type='streaming' AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id");
								if(mysql_num_rows($result) > 0)
								{
									while($row = @mysql_fetch_array($result))
									{	
										if($row['sender_type'] == 'user')
										{
											$QQ = mysql_query("SELECT * FROM `user` WHERE `id` = '$row[sender]' ");
											$fetchUser = mysql_fetch_array($QQ);
											if($fetchUser['profilename'] == "" && $fetchUser['profilename'] == " ")
											{
												echo '<p>'.'<span>'.$row['first_name'].' '.$row['last_name'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
											}
											else
											{
												echo '<p>'.'<span>'.$row['profilename'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
											}
										}
										else
										{
											$QQ = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$row[sender]' ");
											$fetchUser = mysql_fetch_array($QQ);
											echo '<p>'.'<span>'.$row['club_name'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
										}
									 
									}
								 }
								 else
								 {
									echo "<p>Loading.....</p>";
								 }
								?>

							</div>
								
						</div>
								
					</div> 		<?php
	 	}
	 	else
	 	{
	 		$getDefault = mysql_query("SELECT * FROM uploaed_video WHERE `featured` = '1'  AND `user_id` = '$userID'  AND `user_type` = 'user' ORDER BY `video_id` DESC LIMIT 1 ");
		$default_vid = mysql_fetch_assoc($getDefault);
		$getDefault1= mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$userID'  AND `user_type` = 'user' AND `featured` = '1' AND `default_video` = '1'");
		$default_vid1 = mysql_fetch_assoc($getDefault1);
	 		if(mysql_num_rows($getDefault) < 1 )
	 		{
	 			$default_vid['video_path'] = 'adv_video/1434027094ec1fbf4a2a9784c6bb82a1f5e89552f9MYSITTIcom.mp4';
	 		}
	 		else
	 		{
	 			$default_vid = mysql_fetch_assoc($getDefault);
	 		}
			
			$userID = $hostID;
			if(strrpos($default_vid['video_path'], 'youtube.') == true || strrpos($default_vid['video_path'], 'youtu.be') == true)
			{
				$type = 'video/youtube';
			}
			else
			{
				$type = 'video/mp4';
			}
			$link = $default_vid["video_path"];
			?>
			offline++++
			<div class="TV">
			<video id="tv_main_channel" style='width:100%;height:92% !important;' controls="true"  loop  >
				<source id="mp4Source" src="<?php echo str_replace("../", "",$default_vid['video_path']); ?>" type="<?php echo $type;?>">
			</video></div>++++<div class="thumb_list_battle newbattle extereme_playlist">
				<?php
				$get_battle_videos = mysql_query("SELECT * FROM `uploaed_video` WHERE `user_id` = '$userID'  AND `user_type` = 'user' AND `featured` = '1' AND `default_video` = '0' ORDER BY `video_id` DESC ");
				$count_battle_videos = mysql_num_rows($get_battle_videos);

				if($count_battle_videos < 1){
	
				}else{
					
					while($b_row = mysql_fetch_assoc($get_battle_videos)){

						//$explode_vid = explode("../video/" , $b_row['video_path']); ?>
				<?/*<a id="list_<?php echo $b_row['id']; ?>" class="list_play" href="javascript: void(0);" onclick="change_src('<?php echo $b_row['video_path']; ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a> -->*/?>
				<a id="list_<?php echo $b_row['id']; ?>" class="list_play videourl_<?php echo str_replace("../", "", $b_row['video_path']); ?>" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $b_row['video_path']); ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a>
				<?php }
				} ?>
				</div>
				<?php 

	   		echo '<script src="http://mediaelementjs.com/js/mejs-2.9.2/mediaelement-and-player.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		console.clear();
		var link = "<?php echo $link; ?>";
		var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
		if(isYoutube)
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					"action": "changeVideoInfo", 
					"videoid" : link,
					"link": "youtube"
				},
				success: function( data ) 
				{
					console.clear();
					$(".TV").html(data);
					// var audio = $("#tv_main_channel");
					// audio[0].play();
					//var player = new MediaElementPlayer("#tv_main_channel");

					///$(".mejs-controls").find(".mejs-playpause-button").find("button").trigger("click");
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					"action": "changeVideoInfo", 
					"videoid" : link,
					"link": "mp4"
				},
				success: function( data ) 
				{
					console.clear();
					$(".TV").html(data);
					//player.play():
					//var player = new MediaElementPlayer("#tv_main_channel");
					//$(".mejs-controls").find(".mejs-playpause-button").find("button").trigger("click");
				}
			});
		}


		$(".list_play").each(function(){
			if($(this).hasClass("videourl_"+link))
			{
				$(this).addClass("playing");
				$(this).addClass("active");
			}
			else
			{
				$(this).removeClass("playing");
				$(this).removeClass("active");
			}
		});
	});

</script>';	
	 	}

	}
	else
	{
		$sql = "select * from `clubs` where `id` = '".$hostID."'";
		$userArray = $Obj->select($sql) ; 
		$profilename=$userArray[0]['club_name'];
		$plantype = $userArray[0]['plantype'];
		$typeclub = $userArray[0]['type_of_club'];
		$type_details_of_club = $userArray[0]['type_details_of_club'];
		$email=$userArray[0]['club_email'];
		$club_address=$userArray[0]['club_address'];
		$phone=$userArray[0]['club_contact_no']; 
		$country=$userArray[0]['club_country'];
		$state=$userArray[0]['club_state'];
		$club_city=$userArray[0]['club_city'];
		$web_url=$userArray[0]['web_url'];
		$zipcode=$userArray[0]['zip_code'];
		$google_map_url=$userArray[0]['google_map_url'];  
		$profileCounter=$userArray[0]['profile_count'];  
		$image_nm  =$userArray[0]['image_nm'];
		$hideaddress = $userArray[0]['hideaddress'];
		// $_SESSION['username']=$profilename;
		$memberType = $userArray[0]['non_member'];

		$pieces = explode(" ", $profilename);
		$username_dash_separated = implode("-", $pieces);
		$n = clean($username_dash_separated);
		$streamCode = $userArray[0]['newStreamUrl'];
		if(detect_stream($stream_Code)===true)
	 	{
	 		$gname1=mysql_query("SELECT  * FROM  chat_groups WHERE group_name ='$n' AND `group_type` = 'streaming' ");

			if(mysql_num_rows($gname1) <  1)
			{
				//die('dfdfd');
				mysql_query("INSERT INTO `chat_groups` (`group_name`,`group_type`,`create_by`,`user_type`) 
						VALUES ('$n','streaming','$hostID','club') ");
				$ID = mysql_insert_id();
				mysql_query("INSERT INTO chat_users_groups (group_id,user_id,user_type,loggedin) VALUES ('$ID','$hostID','club','1')");

			}
			else
			{
				$group_dtl=mysql_fetch_assoc($gname1);
				$nowtime = date('Y-m-d H:i:s');
				$ID = $group_dtl['id'];
			}
	 		?>
	 		Streaming++++<div class="iframe"><iframe style='width:660px; max-width:100%;height:420px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="https://52.37.162.200/live/streamPlayerUrl.php?v=<?php echo $streamCode;?>"></iframe></div>++++<?php echo $ID;?>++++<?php
	 		if( ($typeclub == '97' || $typeclub == '108') && (strrpos($type_details_of_club, 'DJs') == true) )
	 		{
	 		 	echo "<script type='text/javascript'>
					function blockUser(uid)
					{
						var ID = $('#GROUPid').val();
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&deleteuserid='+uid,
							cache: false,
							success: function(html)
							{
								console.clear();
								$('.refresh').html(html);
								$('#sc').animate({
								    	scrollTop: $('#sc').get(0).scrollHeight
							    	}, 3000);
						  	}
						});
					}

					function deleteMessage(msgid)
					{
						var ID = $('#GROUPid').val();
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&message_id='+msgid,
							cache: false,
							success: function(html)
							{
								console.clear();
								$('.refresh').html(html);
								$('#sc').animate({
								    	scrollTop: $('#sc').get(0).scrollHeight
							    	}, 3000);
						  	}
						});

					}

					function setchat(val)
					{
						$('#textb').val($('#textb').val() + val);
					}

					function Groupfunction()
					{
						var ID = $('#GROUPid').val();
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID,
							cache: false,
							success: function(html)
							{
								console.clear();
								$('.refresh').html(html);
								$('#sc').animate({
								    	scrollTop: $('#sc').get(0).scrollHeight
							    	}, 1000);
						  	}
						});
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&count=users',
							cache: false,
							success: function(html)
							{
								$('#chatMembers').html(html);
						  	}
						});
						$.ajax({
							url: 'group-chat/refresh.php?group_id='+ID+'&view=Viewers',
							cache: false,
							success: function(html)
							{
								$('span#totalViewers').html(html);
						  	}
						});
					}
					$(document).ready(function() {
						$.ajaxSetup({cache: false});
						console.clear();
						var Interval = setInterval(Groupfunction, 3000);

						$('input').keypress(function(event) {

							if (event.which == 13)
							{
								var ID = $('#GROUPid').val();
								event.preventDefault();
								var text = $('#textb').val();
								$('#textb').val('');
								if(text != '')
								{
									
									$.ajax({
										type: 'POST',
										cache: false,
										url: 'group-chat/save.php',
										data: 'text='+text+'&group_id='+ID+'&sender=".$LoogedinID."',
										success: function(data) {
											console.clear();
										    	$('#sc').animate({
											    	scrollTop: $('#sc').get(0).scrollHeight
										    	}, 1000);
										}
									});
								}
							}
						});


						$('#post_button').click(function() {
							var text = $('#textb').val();
							$('#textb').val('');
							if(text != '')
							{
								var ID = $('#GROUPid').val();
								$.ajax({

									type: 'POST',
									cache: false,
									url: 'group-chat/save.php',
									data: 'text='+text+'&group_id='+ID+'&sender=".$LoogedinID."',
									success: function(data) {
										console.clear();
										$('#sc').animate({
										    	scrollTop: $('#sc').get(0).scrollHeight
									    	}, 1000);
									}
								});
							}
						});							
					});</script>"; ?>++++
					<div class="grp_ceond">

							<?php 
								$gname=mysql_query("SELECT  * FROM  chat_groups WHERE group_name='$n' AND `group_type` = 'streaming' ");
								$group_dtl=mysql_fetch_assoc($gname);
								$nowtime = date('Y-m-d H:i:s');
								$groupID = $group_dtl['id'];
								$chk_user=mysql_query("select  user_id from  chat_users_groups where group_id=".$groupID."");
								$cnt_row=mysql_num_rows($chk_user);
								$my_smilies = array(
									'@!' => '<img src="group-chat/smilies/barmy.gif"/>',
									'||' => '<img src="group-chat/smilies/bash.gif"/>',
									'[]' => '<img src="group-chat/smilies/bottle.gif"/>',
									'%#' => '<img src="group-chat/smilies/bike2.gif"/>',
									'!@' => '<img src="group-chat/smilies/cheer.gif"/>'
									);
								?>
								

						<div class="grpone" >
							<input type="hidden" id="GROUPid" value="<?php echo $groupID; ?>" />
								<script type="text/javascript">
								function userPop(url)
								{
									window.open(url,'1396358792239','width=300,height=330,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=0,left=0,top=0');
									return false;
								}

								</script>
								<input name="message" type="text" id="textb"/>
								<input type="button" class="onlineUsers" onclick="userPop('fetchUsers.php?gID=<?php echo $groupID; ?>');" value="View Users" />
								
								<input name="submit1" type="button" value="Send" id="post_button" />

								<input name="sender" type="hidden" id="texta" value="<?php echo $_SESSION['username']?>"/>
	 							<div class="divider"></div>
							<div class="refresh" id="sc">

								<?php
								//where sent_time > NOW() - INTERVAL 1 HOUR 

								//echo "SELECT * FROM message where group_id=".$ID." AND group_type='streaming' AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id"; exit;

								$result = mysql_query("SELECT * FROM message where group_id=".$groupID." AND group_type='streaming' AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id");
								if(mysql_num_rows($result) > 0)
								{
									while($row = @mysql_fetch_array($result))
									{	
										if($row['sender_type'] == 'user')
										{
											$QQ = mysql_query("SELECT * FROM `user` WHERE `id` = '$row[sender]' ");
											$fetchUser = mysql_fetch_array($QQ);
											if($fetchUser['profilename'] == "" && $fetchUser['profilename'] == " ")
											{
												echo '<p>'.'<span>'.$row['first_name'].' '.$row['last_name'].':</span>'. '&nbsp;&nbsp;' . 	str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
											}
											else
											{
												echo '<p>'.'<span>'.$row['profilename'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
											}
										}
										else
										{
											$QQ = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$row[sender]' ");
											$fetchUser = mysql_fetch_array($QQ);
											echo '<p>'.'<span>'.$row['club_name'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
										}
									 
									}
								 }
								 else
								 {
									echo "<p>Loading.....</p>";
								 }
								?>

							</div>
								
						</div>
								
					</div>
	 		<?php 	
	 		}
	 	}
	 	else
	 	{
	 ?>
	 		offline++++<div class="TV">
				<video id="tv_main_channel" style='width:100%;height:92% !important;' controls="true" style="display:none;">

				 <?php
					$getDefault = mysql_query("SELECT * FROM uploaed_video WHERE `featured` = '1'  AND `user_id` = '$userID'  AND `user_type` = 'club' ORDER BY `video_id` DESC LIMIT 1 ");
		$default_vid = mysql_fetch_assoc($getDefault);
		$getDefault1= mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$userID'  AND `user_type` = 'club' AND `featured` = '1' AND `default_video` = '1'");
		$default_vid1 = mysql_fetch_assoc($getDefault1);
		if(mysql_num_rows($getDefault1) > 0 )
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
		elseif(mysql_num_rows($getDefault1) == 0 && mysql_num_rows($getDefault) > 0 )
		{
			if(strrpos($default_vid['video_nm'], 'youtube.') == true || strrpos($default_vid['video_nm'], 'youtu.be') == true)
			{
				$type = 'video/youtube';
			}
			else
			{
				$type = 'video/mp4';
			}

?>
			<source id="mp4Source" src="<?php echo str_replace("../", "",$default_vid['video_nm']); ?>" type="<?php echo $type; ?>">
<?php
		}
		elseif(mysql_num_rows($getDefault1) == 0 && mysql_num_rows($getDefault) == 0 )
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
			</div>++++<div class="thumb_list_battle newbattle extereme_playlist">
				<?php
				$get_battle_videos = mysql_query("SELECT * FROM `uploaed_video` WHERE `user_id` = '$userID'  AND `user_type` = 'club' AND `featured` = '1' AND `default_video` = '0' ORDER BY `video_id` DESC ");
				$count_battle_videos = mysql_num_rows($get_battle_videos);

				if($count_battle_videos < 1){
					
					//echo "No video found";
					
				}else{
					
					while($b_row = mysql_fetch_assoc($get_battle_videos)){

						//$explode_vid = explode("../video/" , $b_row['video_path']); ?>
				<!-- <a id="list_<?php echo $b_row['id']; ?>" class="list_play" href="javascript: void(0);" onclick="change_src('<?php echo $b_row['video_path']; ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a> -->
				<a id="list_<?php echo $b_row['id']; ?>" class="list_play videourl_<?php echo str_replace("../", "", $b_row['video_path']); ?>" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $b_row['video_path']); ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a>
				<?php }
				} ?>
				</div>
	   		<?php 	
	 	}
	}
}
else
{
	?>offline++++<div class="TV">
			<video id="tv_main_channel" style='width:100%;height:92% !important;' controls="true" style="display:none;">

	 <?php
		$getDefault = mysql_query("SELECT * FROM battle_playlist WHERE `user_id` = '$userID'  AND `user_type` = 'club' ");
		$default_vid = mysql_fetch_assoc($getDefault);
		$getDefault1= mysql_query("SELECT * FROM battle_playlist WHERE `user_id` = '$userID'  AND `user_type` = 'club' ORDER BY `id` DESC LIMIT 1 ");
		$default_vid1 = mysql_fetch_assoc($getDefault1);
		if(mysql_num_rows($getDefault1) > 0 || mysql_num_rows($getDefault) > 0 )
		{
			
			if($default_vid['default_video'] == 1)
			{
				$link = $default_vid["video_path"];
				if(strrpos($default_vid['video_path'], 'youtube.') == true || strrpos($default_vid['video_path'], 'youtu.be') == true)
				{
					$type = 'video/youtube';
				}
				else
				{
					$type = 'video/mp4';
				}
?>
				<source id="mp4Source" src="<?php echo str_replace("../", "", $default_vid['video_path']); ?>" type="<?php echo $type;?>">
<?php 			}
			else
			{
				$link = $default_vid1["video_path"];
				if(strrpos($default_vid1['video_path'], 'youtube.') == true || strrpos($default_vid1['video_path'], 'youtu.be') == true)
				{
					$type = 'video/youtube';
				}
				else
				{
					$type = 'video/mp4';
				}
?>
				<source id="mp4Source" src="<?php echo str_replace("../", "",$default_vid1['video_path']); ?>" type="<?php echo $type; ?>">
<?php 			}

		}
		else
		{
			$getMainDefault = mysql_query("SELECT * FROM `pages` WHERE `page_id` = '13' ");
			$fetchMainDefault = mysql_fetch_assoc($getMainDefault);
			$link = $fetchMainDefault["video_path"];
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
	</div>++++<div class="thumb_list_battle newbattle extereme_playlist">
		<?php
		$get_battle_videos = mysql_query("SELECT * FROM battle_playlist WHERE `user_id` = '$userID'  AND `user_type` = 'club' ");
		$count_battle_videos = mysql_num_rows($get_battle_videos);

		if($count_battle_videos < 1){
			
			//echo "No video found";
			
		}else{
			
			while($b_row = mysql_fetch_assoc($get_battle_videos)){

				//$explode_vid = explode("../video/" , $b_row['video_path']); ?>
		<!-- <a id="list_<?php echo $b_row['id']; ?>" class="list_play" href="javascript: void(0);" onclick="change_src('<?php echo $b_row['video_path']; ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a> -->
		<a id="list_<?php echo $b_row['id']; ?>" class="list_play videourl_<?php echo str_replace("../", "", $b_row['video_path']); ?>" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $b_row['video_path']); ?>','<?php echo $b_row['id']; ?>')"><?php echo $b_row['video_title']; ?></a>
		<?php }
		} ?>
		</div>
	<?php 	
}