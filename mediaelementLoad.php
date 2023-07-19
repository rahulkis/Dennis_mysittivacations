<?php 
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
if(!isset($_SESSION['user_id']))
	{
		$profileURL = $SiteURL.'home_club.php';
	}
	else
	{
		$profileURL = $SiteURL.'host_profile.php?host_id='.$fetchClubInfo['id'];	
	}
if($_POST['link'] == 'youtube')
{
	$type = "video/youtube";
	$src = $_POST['videoid'];
	$ttl = $_POST['videottll'];
	?>
	<div class="Hname" id='hostName'> <a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>">
	<?php  echo $ttl;?>
	</a> </div>
	<div  id="tv_main_channel" ></div>
	<style type="text/css">
		span.jwvideo video
		{
			transform: none !important;
		}
		#tv_main_channel
		{
			height: 100% !important;
			width: 100% !important;
		}
	</style>
	<?php 
}
elseif($_POST['link'] == 'vimeo')
{
	$url = $_POST['videoid'];
	$urlnew = explode('/',$url);
	//echo "<pre>"; print_r($urlnew); die;
	$ttl = $_POST['videottll'];
	$videoID = end($urlnew);
	?>
	<div class="Hname" id='hostName'> <a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>">
	<?php  echo $ttl;?>
	</a> </div>
	<div  id="tv_main_channel" >
		<iframe src="https://player.vimeo.com/video/<?php echo $videoID;?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	</div>
	<style type="text/css">
		#tv_main_channel, #tv_main_channel iframe
		{
			height: 100% !important;
			width: 100% !important;
		}
	</style>
<?php
}
else
{
	$type = "video/mp4";
	$src = $SiteURL.$_POST['videoid'];
	$ttl = $_POST['videottll'];
	?>
	<!-- <a class="jwplayerVideo" id="jw_tv_main_channel" href="#dialogxtv_main_channel" name="modal" style=""> -->
	<div class="Hname" id='hostName'> <a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>">
	<?php  echo $ttl;?>
	</a> </div>
   		<div id="tv_main_channel" ></div>
	<!-- </a>	    -->
	<style type="text/css">
		span.jwvideo video
		{
			transform: none !important;
		}
		#tv_main_channel
		{
			height: 100% !important;
			width: 100% !important;
		}
	</style>
<?php 
}	

?>

