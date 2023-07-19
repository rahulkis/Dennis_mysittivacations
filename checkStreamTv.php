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
		$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/videowhisper-x/'.$hbhost.' 2>&1; echo $?';

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
			$st_qry = 'ffmpeg -i rtsp://54.174.85.75:1935/videowhisper-x/'.$hbhost.' 2>&1; echo $?';

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
	if(detect_stream($n)===true)
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
 		Streaming++++<div class="iframe"><iframe style='width:100%; max-width:100%;height:390px !important;' hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo $SiteURL;?>live2/channelIframe.php?n=<?php echo $n; ?>&host_id=<?php echo $hostID; ?>&user_type=club"></iframe></div>++++<?php echo $ID;?>++++<?php
 		if( ($typeclub == '97' || $typeclub == '108') && (strrpos($type_details_of_club, 'DJs') == true) )
 		{
 		 	echo ""; ?>++++Hello

 		<?php 	
 		}
 	}
 	else
 	{
 
 		$day = date('l');
		$getVideos1 = mysql_query("SELECT * FROM mysittiTV WHERE `weekDay` = '$day' ORDER BY `trackno` ASC ");
		$getDefault = mysql_fetch_assoc($getVideos1);
		if($getDefault['user_type'] == 'club')
		{
			$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$getDefault[host_id]'  ");
			$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
			if(!empty($fetchClubInfo['club_name']))
			{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
				$HostNAME = $fetchClubInfo['club_name'];
				$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
			}
			else
			{
				$HostNAME = 'MySitti';
				$HostImage = 'images/man4.jpg';
			}
			if(!isset($_SESSION['user_id']))
			{
				$profileURL = $SiteURL.$fetchClubInfo['club_name'];
			}
			else
			{
				$profileURL = $SiteURL.'host_profile.php?host_id='.$fetchClubInfo['id'];	
			}
			
		}
		else
		{
			$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$getDefault[host_id]'  ");
			$fetchClubInfo = mysql_fetch_assoc($getClubInfo);	
			if(!empty($fetchClubInfo['profilename']))
			{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
				$HostNAME = $fetchClubInfo['profilename'];
				$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
			}
			else
			{
				$HostNAME = 'MySitti';
				$HostImage = 'images/man4.jpg';
			}
			$profileURL = $SiteURL.'profile.php?id='.$fetchClubInfo['id'];
		}
		$getVideos = mysql_query("SELECT * FROM mysittiTV WHERE `weekDay` = '$day' /*AND `id` != '$getDefault[id]'*/ ORDER BY `trackno` ASC ");

	?>offline++++<div class="hoster">
	       			<div class="Hthumb" id='hostThumb'>
	       				<img src="<?php  echo $SiteURL.$HostImage;?>" alt=""/>
				</div>
				<div class="Hname" id='hostName'>
					<a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>"><?php  echo $HostNAME;?></a>
				</div>
			</div>
			<div class="TV">
				<video preload="auto" id="tv_main_channel" width="400" controls style="display:none;" >
					<source id="mp4Source" src="<?php echo str_replace('../', '', $getDefault['video_path']); ?>" type="video/mp4">
				</video>
			</div>++++<h1>Programs</h1>
	 					<ul id="playlist">
     					
			<?php 
			$i = 0;
				while($rowVideos = mysql_fetch_assoc($getVideos))
				{
					if($rowVideos['user_type'] == 'club')
					{
						$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$rowVideos[host_id]'  ");
						$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
						if(!empty($fetchClubInfo['club_name']))
						{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
							$HostNAME1 = $fetchClubInfo['club_name'];
							$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
						}
						else
						{
							$HostNAME1 = 'MySitti';
							$HostImage1 = 'images/man4.jpg';
						}
						
					}
					else
					{
						$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$rowVideos[host_id]'  ");
						$fetchClubInfo = mysql_fetch_assoc($getClubInfo);	
						if(!empty($fetchClubInfo['profilename']))
						{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
							$HostNAME1 = $fetchClubInfo['profilename'];
							$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
						}
						else
						{
							$HostNAME1 = 'MySitti';
							$HostImage1 = 'images/man4.jpg';
						}
					}
					$path = str_replace('../', '', $rowVideos['video_path']);


					?>
						<li  class='<?php if($i == '0'){ echo "active";} ?> list_play videourl_<?php echo $path;?>' id='<?php echo $rowVideos['id'];?>'>
							<a href="javascript:void(0);" class="vid_<?php echo $path;?>" onclick="changeMedia('<?php echo str_replace("../", "", $path); ?>','<?php echo $rowVideos['id']; ?>')" id='video_<?php echo $rowVideos['id'];?>' >
								<?php echo $rowVideos['video_title'].' <br />By '.$HostNAME1;?><br />
								<input type="hidden" id="path_<?php echo $rowVideos['id'];?>" value="<?php echo $path;?>" />
							</a>
						</li>
					<?php 
						$i++;
				}
			?>
		</ul>
	<?php
	}
}
else
{

	$day = date('l');
	$getVideos1 = mysql_query("SELECT * FROM mysittiTV WHERE `weekDay` = '$day' ORDER BY `trackno` ASC ");
	$getDefault = mysql_fetch_assoc($getVideos1);
	if($getDefault['user_type'] == 'club')
	{
		$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$getDefault[host_id]'  ");
		$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
		if(!empty($fetchClubInfo['club_name']))
		{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
			$HostNAME = $fetchClubInfo['club_name'];
			$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
		}
		else
		{
			$HostNAME = 'MySitti';
			$HostImage = 'images/man4.jpg';
		}
		if(!isset($_SESSION['user_id']))
		{
			$profileURL = $SiteURL.$fetchClubInfo['club_name'];
		}
		else
		{
			$profileURL = $SiteURL.'host_profile.php?host_id='.$fetchClubInfo['id'];	
		}
		
	}
	else
	{
		$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$getDefault[host_id]'  ");
		$fetchClubInfo = mysql_fetch_assoc($getClubInfo);	
		if(!empty($fetchClubInfo['profilename']))
		{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
			$HostNAME = $fetchClubInfo['profilename'];
			$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
		}
		else
		{
			$HostNAME = 'MySitti';
			$HostImage = 'images/man4.jpg';
		}
		$profileURL = $SiteURL.'profile.php?id='.$fetchClubInfo['id'];
	}


	$getVideos = mysql_query("SELECT * FROM mysittiTV WHERE `weekDay` = '$day' /*AND `id` != '$getDefault[id]'*/ ORDER BY `trackno` ASC ");








	?>offline++++<div class="hoster">
	       			<div class="Hthumb" id='hostThumb'>
	       				<img src="<?php  echo $SiteURL.$HostImage;?>" alt=""/>
				</div>
				<div class="Hname" id='hostName'>
					<a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>"><?php  echo $HostNAME;?></a>
				</div>
			</div>
			<div class="TV">
				<video preload="auto" id="tv_main_channel" width="400" controls style="display:none;" >
					<source id="mp4Source" src="<?php echo str_replace('../', '', $getDefault['video_path']); ?>" type="video/mp4">
				</video>
			</div>++++<h1>Programs</h1>
	 					<ul id="playlist">
     					
			<?php 
			$i = 0;
				while($rowVideos = mysql_fetch_assoc($getVideos))
				{
					if($rowVideos['user_type'] == 'club')
					{
						$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$rowVideos[host_id]'  ");
						$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
						if(!empty($fetchClubInfo['club_name']))
						{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
							$HostNAME1 = $fetchClubInfo['club_name'];
							$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
						}
						else
						{
							$HostNAME1 = 'MySitti';
							$HostImage1 = 'images/man4.jpg';
						}
						
					}
					else
					{
						$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$rowVideos[host_id]'  ");
						$fetchClubInfo = mysql_fetch_assoc($getClubInfo);	
						if(!empty($fetchClubInfo['profilename']))
						{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
							$HostNAME1 = $fetchClubInfo['profilename'];
							$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
						}
						else
						{
							$HostNAME1 = 'MySitti';
							$HostImage1 = 'images/man4.jpg';
						}
					}
					$path = str_replace('../', '', $rowVideos['video_path']);


					?>
						<li  class='<?php if($i == '0'){ echo "active";} ?> list_play videourl_<?php echo $path;?>' id='<?php echo $rowVideos['id'];?>'>
							<a href="javascript:void(0);" class="vid_<?php echo $path;?>" onclick="changeMedia('<?php echo str_replace("../", "", $path); ?>','<?php echo $rowVideos['id']; ?>')" id='video_<?php echo $rowVideos['id'];?>' >
								<?php echo $rowVideos['video_title'].' <br />By '.$HostNAME1;?><br />
								<input type="hidden" id="path_<?php echo $rowVideos['id'];?>" value="<?php echo $path;?>" />
							</a>
						</li>
					<?php 
						$i++;
				}
			?>
		</ul>
		<?php 

}