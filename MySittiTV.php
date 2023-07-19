<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="MySitti TV";

if(!isset($_SESSION['user_id']))
{
	include('Header.php');
	//$Obj->Redirect('index.php');
}
else
{
	include('NewHeadeHost.php');
}
// if(!isset($_GET['contest_id'])){
// header('Location: '.$SiteURL.'live2/battle.php?contest_id=112');
// die;
// }
if(!isset($_SESSION['user_id'])) 
{ ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
 <?php 
}

$CONTESTID = $_GET['contest_id'];

$cr_ct_id = "";

if(empty($CONTESTID)){
	
	$check_cur_cont = mysql_query("SELECT * FROM contest WHERE battle_status = 'active'");
	$cont_row = mysql_fetch_assoc($check_cur_cont);

	$CONTESTID = $cont_row['contest_id'];
}
      // date_default_timezone_set('America/Chicago');


$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
//$surl = "https://" . $_SERVER['SERVER_NAME']."/index.php";
//if(!isset($userID)){$Obj->Redirect($surl);}
//if(!isset($CONTESTID)){$Obj->Redirect($surl);}
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


?>
<style type="text/css">
.home_content_bottom:before
{
	background: none;
}
.main_home_live2battle {
  margin: 0 auto;
  max-width: 1200px;
  width: 100%;
}
.home_content {
	float: left;
	padding: 0 0;
	width: 100%;
}

.lv_brdcast {
	float: left;
	margin-bottom: 20px;
	width: 100%;
}

.inner_lv_brdcast {
	float: left;
	width: 100%;
}
/* CHAT CSS*/

.refresh {
	border: 1px solid #acd6fe;
	border-left: 4px solid #acd6fe;
	color: green;
	font-family: tahoma;
	font-size: 12px;
	height: 225px;
	overflow-y:auto;
	overflow-x:auto;
	/*width: 365px;*/
	padding:10px;/*background-color:#FFFFFF;*/
}
#title {
	border:0px;
	font-size:30px;
	color:#fff;
	margin-bottom:0px;
}
.grpone {
  float: left;
  padding: 10px;
  width: 100% !important;
  background: #fff;
  box-sizing: border-box;
}
.ulist {
  -moz-border-bottom-colors: none !important;
  -moz-border-left-colors: none !important;
  -moz-border-right-colors: none !important;
  -moz-border-top-colors: none !important;
  background: #fff none repeat scroll 0 0;
  border-color: -moz-use-text-color -moz-use-text-color #ccc !important;
  border-image: none !important;
  border-style: none none solid !important;
  border-width: 0 0 1px !important;
  box-sizing: border-box;
  color: green;
  float: left;
  font-family: tahoma;
  font-size: 12px;
  height: 225px;
  overflow: auto;
  padding: 10px;
  width: 100% !important;
}
.ulist > div {
  float: left;
  width: 100%;
  border-top: 0 !important;
}
.ulist p {
  border-top: 0px solid #333 !important;
}
#post_button {
	border: 1px solid #308ce4;
	background-color:#308ce4;
	width: 100px;
	color:#FFFFFF;
	font-weight: bold;
	margin-top: 0px !important;
	margin-bottom: 5px !important;
	padding:5px;
	cursor:pointer;
	border-radius:4px;
}
#textb {
	border: 1px solid #ccc;
	/*width: 283px;*/
	margin:0px 0 10px;
	width: 100%;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	border-radius:6px;
	-webkit-border-radius:6px;
	height:35px;
	width:100% !important;
	box-shadow: 0 0 4px #ccc inset;
}
#texta {
	border: 1px solid #000 !important;
	margin-bottom: 10px;
	padding:7px 5px;
}
.main_home p {
	border-bottom: 1px dashed #e5e5e5;
	width:100%;
	padding:4px 4px;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	border-radius:4px;
	margin-bottom:0px;
	text-align:left;
	max-width:300px;
	text-indent:0px;
	word-wrap:break-word;
}

#sc p span{
 width:100%;
 float:left;
 color:#505050;	
}
.fl {
	float:left
}
#sc{border:0px !important; border-top:1px solid #ccc !important;padding: 2px !important}  
#sc p:hover {background:#f2f2f2;}
#smilies {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	-webkit-box-shadow: #666 0px 2px 3px;
	-moz-box-shadow: #666 0px 2px 3px;
	box-shadow: #666 0px 2px 3px;
	background: #A0CFFB;
	background: -webkit-gradient(linear, 0 0, 0 bottom, from(#A0CFFB), to(#dfeffe));
	background: -webkit-linear-gradient(#A0CFFB, #dfeffe);
	background: -moz-linear-gradient(#A0CFFB, #dfeffe);
	background: -ms-linear-gradient(#A0CFFB, #dfeffe);
	background: -o-linear-gradient(#A0CFFB, #dfeffe);
	background: linear-gradient(#A0CFFB, #dfeffe);
	-pie-background: linear-gradient(#A0CFFB, #dfeffe);
}
.ulist > p {
	float: left;
	width: 100%;
}
.joinbutton {
	float: left;
	margin: 5% 0;
	width: 100%;
}
.groupchatname {
	float: left;
	margin: 10px 0;
	width: 100%;
}
.grp_ceond {
  background: #ccc none repeat scroll 0 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  float: right;
/*  max-height: 460px;*/
  overflow: hidden;
  padding: 10px;
  width: 32% !important;
}
.boject_container {width:66%; float:left; margin-right:2%;}
.main_home p {
	color: #000 !important;
}
.channel_bg {
	background: rgba(0, 0, 0, 0) url("../../images/channel-bg.jpg") no-repeat scroll left top / 100% auto;
	float: left;
	width: 100%;
}
.channer_container {
	margin: 0px auto !important;
	max-width: 1080px;
	width: 100%;
}
.channel_inner {
	box-shadow: 0 0 1px rgba(255, 255, 255, 0.3) inset;
	background: rgba(0, 0, 0, 0.3);
	margin-bottom: 30px;
	padding: 10px 10px 20px;
	width:100%;
	float:left;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
.webcame_live {
	padding: 10px;
	width:100%;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	max-width:1000px;
}
object, embed {
 
  max-width: 100%;
}
.boject_container {width:100%; margin:0;}
#sc {
  width: 100%;
  float: l;
  box-sizing: border-box;
  border: 0px !important;
}
#sc p span {font-weight:bold;}
.divider {width:100%; height:1px; background:#e7e7e7; float:left; margin:5px 0;}
.closepop {float:right; margin:10px 0;}

.ulist .groupchatname {
  padding-bottom: 10px;
  border-bottom: 1px solid #000;
  color: #000;
}
.main_home {
  margin: 0 auto !important;
  max-width: 1080px;
  width: 100%;
}
#chatMembers p span img {vertical-align:middle; margin-right:10px;}
#chatMembers p a {color:#000;}



.groupchatname > span#totalViewers 
{
	float: right;
}

.NewBand .v2_thumb_event a img {
	max-width: 100%;
	display: initial !important;
}


video {
	height: 98%;
	margin: 5px 0;
	width: 100%;
}


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
	/*position: absolute;*/
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


.tvwrapper .hoster
{
	z-index: 10;
}


.play_vid_current #tv_main_channel .jw-media video
{
	float: left;
	height: auto !important;
	width: auto !important;
}

.jw-media.jw-reset,  {
	float: left;
	max-width: 100% !important;
	width: 100% !important;
}


.iframe {
  float: left;
  margin: auto;
  max-height: 100% !important;
  width: 100%;
}
/*.play_vid_current video {
  	float: left;
}*/
#tv_main_channel
{
	width: 100% !important;
	height: 100% !important;
}
#tv_main_channel > iframe {
	height: 100% !important;
	width: 100% !important;
}


</style>

<script type="text/javascript">

	function checkStream()
	{
		$.ajax({
			type: "POST",
			cache: false,
			url: "checkStreamTv.php",
			data: {
				'host_id' : '497627',
				'usertype' : 'club',

			},
			success: function(data){
				//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
				var dd = data.split('++++');
				//alert(dd[1]);
				if($.trim(dd[0]) == "Streaming" )
				{
					
					if($('.battleTv').hasClass('changed'))
					{
					
					}
					else
					{
						$('.battleTv').removeClass('offline_stream').addClass('changed');
						$('.battleTv').html($.trim(dd[1]));
						$('.MySittiplaylist').html('');
					}
				}
				else
				{
					
					if($('.battleTv').hasClass('offline_stream'))
					{
					
					}
					else
					{
						
						$('.battleTv').removeClass('changed').addClass('offline_stream');
						$('.battleTv').html($.trim(dd[1]));
						$('.MySittiplaylist').html($.trim(dd[2]));
						// $('#GROUPid').val('');
						// $('#AjaxChatDiv').html(dd[2]);
						// //alert($('#mp4Source').attr('src'));
						var src = $('#mp4Source').attr('src');
						if($('#mp4Source').attr('type') == 'video/youtube')
						{
							//var player = new MediaElementPlayer('#tv_main_channel');
							jwplayer("tv_main_channel").setup({
									file: src,
									autostart: true,
							  	});
						}
						else
						{
							jwplayer("tv_main_channel").setup({
								file: src,
								autostart: true,
						  	});
						}
						//clearInterval(Groupfunction);
					}
				}


			}
		});
	}


	$(document).ready(function(){
		$.ajaxSetup({cache: false});
		var interval = setInterval(checkStream,10000);

		$('.events_slider_true').bxSlider({
			mode: 'horizontal', //mode: 'fade',            
			speed: 500,
			auto: true,
			slideWidth: 200, 
			slideMargin: 10,
			minSlides: 1,
			infiniteLoop: true,
			autoStart: true,
			hideControlOnEnd: true,
			useCSS: false,
			// position: 1,
		});


		$('.slider_body').remove();




	 	var playerInstance = jwplayer('tv_main_channel');
		var link = $('#mp4Source').attr('src');
		var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
		var current = 0;
		var playlist = $('#playlist');
		var tracks = playlist.find('li');
		var len = tracks.length;
		if(isYoutube)
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link,
					'link': 'youtube'
				},
				success: function( data ) 
				{
					$('.TV').html(data);
					playerInstance.setup({
						file: link,
					  	autostart: true,
					  	width: "100%",
						//aspectratio: "16:9",
						stretching : "uniform",
					  	events: {
							onComplete: function() {
								//alert('complete');
								//jwplayer().seek(0).play(true);
								current++;
								if(current >= len ){
									current = 0;
									link = playlist.find('a')[0];
									//var id = link.parent().index();
								}else{

									link = playlist.find('a')[current];    
								}
								var id = $(link).parent().attr('id');

								//alert(id);
								changeMedia(link,id);
							}
						}
				  	});
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link,
					'link': 'mp4'
				},
				success: function( data ) 
				{
					$('.TV').html(data);

					playerInstance.setup({
						file: link,
					  	autostart: true,
					  	width: "100%",
						//aspectratio: "16:9",
						stretching : "uniform",
					  	events: {
							onComplete: function() {
								//alert('complete');
								//jwplayer().seek(0).play(true);
								current++;
								if(current >= len ){
									current = 0;
									link = playlist.find('a')[0];
									//var id = link.parent().index();
								}else{

									link = playlist.find('a')[current];    
								}
								var id = $(link).parent().attr('id');

								//alert(id);
								changeMedia(link,id);
							}
						}
				  	});
				}
			});
		}
	});


function changeMedia(args,id)
{
	//event.preventDefault();
	var playerInstance = jwplayer('tv_main_channel');
	var link = $('li#'+id).find('a').find('#path_'+id).val();
	var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
	var newID = id;
	var link1 = $(this);
	var current = link1.parent().index();
	var playlist = $('#playlist');
	var tracks = playlist.find('li');
	var len = tracks.length;

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'action': "changeVideoInfo", 
			'videoid' : newID
		},
		success: function( data ) 
		{
			var dd = data.split('++++');
			$('#hostThumb').find('img').attr('src',dd[1]);
			$('#hostName').find('a').text(dd[0]);
			$('#hostName').find('a').attr('href',dd[2]);
		}
	});

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




	if(isYoutube)
	{
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'link': 'youtube'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				//player.play():
				//var player = new MediaElementPlayer('#tv_main_channel');
				playerInstance.setup({
						file: link,
					  	autostart: true,
					  	events: {
							onComplete: function() {
								//alert('complete');
								//jwplayer().seek(0).play(true);
								current++;
								if(current >= len ){
									current = 0;
									link = playlist.find('a')[0];
									//var id = link.parent().index();
								}else{

									link = playlist.find('a')[current];    
								}
								var id = $(link).parent().attr('id');

								//alert(id);
								changeMedia(link,id);
							}
						}
				  	});
			}
		});
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'link': 'mp4'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				playerInstance.setup({
						file: link,
					  	autostart: true,
					  	events: {
							onComplete: function() {
								//alert('complete');
								//jwplayer().seek(0).play(true);
								current++;
								if(current >= len ){
									current = 0;
									link = playlist.find('a')[0];
									//var id = link.parent().index();
								}else{

									link = playlist.find('a')[current];    
								}
								var id = $(link).parent().attr('id');

								//alert(id);
								changeMedia(link,id);
							}
						}
				  	});
				playerInstance.stop();
				if(playerInstance.getState() == "idle")
				{
					playerInstance.pause();
					playerInstance.play();
				}
			}
		});
	}
}
</script>

<style>
.home_wrapper {
/*  background: rgba(0, 0, 0, 0) url("../images/patteren1.png") repeat scroll left top;*/
  float: left;
  margin-top: 15px;
  padding-top: 20px;
  width: 100%;
}
#tv_main_channel_wrapper {width:100% !important; max-width:100% !important; height:100% !important;}
.v2_banner_top {margin-bottom:0;}
</style>
<div class="home_wrapper" style="margin-top:0;">
  	<div class="main_home_live2battle">
		<div class="home_content">
			<div class="home_content_bottom mbottom20" style="background:none;">
				<!--<div class="adLeft">
 					<?php 
						//$getAds = mysql_query("SELECT * FROM `pagesAds` WHERE `page_name` = 'mysittiTV' ORDER BY `adid` DESC LIMIT 0,2 ");
						//while ($res = mysql_fetch_assoc($getAds))
						//{
					?>
							<a href="<?php if(!empty($res['image_link'])){ echo str_replace("mysittidev.com/", 'mysittidev.com/', $res['image_link']);}else{ echo '#';} ?>">
								<img alt="" src="<?php echo $res['image_path'];?>">
							</a>
							<br> 
					<?php
						//}
					?>
				</div>-->
    				<div class="tvwrapper">
   					<div class="play_vid_current battleTv offline_stream">
       						<div class="hoster">
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
						</div>
	   				</div>
			   		<div class="MySittiplaylist">
			   			<h1>Programs</h1>
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
 				</div>
     <div class="clear"></div>	
     <div class="band_event_list tv_event_list">

								<!-- <h1>See all list of <a href="<?php echo $linkEvents; ?>">Upcoming Events</a></h1> -->
								<div class="event_list_container">
									<div class="NewBand"> 
								<?php 
									$date = date('Y-m-d H:i:s');
									
									$get_latest_events = mysql_query("SELECT `ev`.*, `for`.`event_date`
																	FROM `events` as `ev`, `forum` as `for` 
																	WHERE `for`.`event_date` >= '$date' 
																	AND `for`.`event_id` = `ev`.`id`
																	ORDER BY `for`.`event_date` ASC
																	LIMIT 0,20");
									


									$count_events = mysql_num_rows($get_latest_events);
									if($count_events > 0)
									{
										if($count_events > 3)
										{
											$newClass = ' events_slider_true';
										}
										else
										{
											$newClass = '';
										}
										echo '<ul class="event_slider2'.$newClass.'">';
										while($row = mysql_fetch_assoc($get_latest_events))
										{ 
								?>			
											<li> 
												<div class="v2_thumb_event">
													<div class=" "> 
													<?php 
														if(!empty($row['event_image']))
														{
													?>
															<a rel="group" class="fancybox" href="<?php echo str_replace('../', '', $row['event_image']); ?>"> 
																<img alt="" src="<?php echo str_replace('../', '', $row['event_image_thumb']); ?>"> 
															</a>
												<?php   	}
														else
														{
												?>
															<a rel="group" class="fancybox" href="<?php echo $SiteURL.'events_icons/'.$row['event_category'].'.jpg'; ?>"> 
																<img alt="" src="<?php echo $SiteURL.'events_icons/'.$row['event_category'].'.jpg'; ?>"> 
															</a>
												<?php
														}
											 	?>
													</div>
													<div class="clear"></div>
												</div>
												<div class="postDateNew">
													<div class="DateCont">
														<div class="date1"><?php echo date('M',strtotime($row['event_date'])); ?></div>
														<div class="date2"><?php echo date('d',strtotime($row['event_date'])); ?></div>
													</div>
													<div class="TimeCont">
														<div class="date3"><?php echo date('D',strtotime($row['event_date'])); ?></div>
														<div class="date4"><?php echo date('h:i',strtotime($row['event_date'])); ?></div>
														<div class="date5"><?php echo date('a',strtotime($row['event_date'])); ?></div>
													</div>
												</div>
												<div class="BuyMore">
													<a onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $row['id'] ?>&action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;">
														<img src="images/rmore.png" alt="More" />
													</a>
           												</div>
           												<div class="BuyMore BuyMoreTickets">
            
												  <?php 
													$check_ticket = mysql_Query("SELECT * FROM streaming_tickets WHERE event_id = '".$row['id']."'");
													$count_ticket_check = mysql_num_rows($check_ticket);

													/* PAID PASSES QUERY */
													$getPaidpass = mysql_query("SELECT * FROM `paid_passes` WHERE `event_id` = '$row[id]' ");
													$fetchRecords = mysql_fetch_assoc($getPaidpass);
													$countPaidpasses = $fetchRecords['no_of_tickets'];
													$currDate = strtotime(date('Y-m-d H:i:s'));
													$expiryPass = strtotime($fetchRecords['expiry_date']);
												?>
												<?php 
												if( ($count_ticket_check == "1" || $countPaidpasses > 0) && $_SESSION['user_type'] == 'user')
												{
											?>
									
													<div class="clear"></div>
								

											<?php
													if($countPaidpasses > 0 && $fetchRecords['pass_status'] == "active" && ( $expiryPass > $currDate) )
													{
														$HostID = $row['host_id'];
														$get_str_host_email = mysql_query("SELECT `merchant_id` FROM `clubs` WHERE `id` = '$HostID' ");
														$count_email = mysql_num_rows($get_str_host_email);
														
														if($count_email < 1){
															
															$host_email = "";
															
														}else{
															
															$set_host_email = mysql_fetch_assoc($get_str_host_email);
															$host_email = $set_host_email['merchant_id'];
															
														}
														
														$hide_btn = "style='display: none;'";
														
														$payment_amount =  trim(str_replace("$",'',$fetchRecords['amount']));
														$host_email_set = $host_email;
														$item_name = "Buy Ticket";
														?>
														<a  class="buyshowtickets"  href="buyStageTicket.php?host_id=<?php echo $HostID.'&str_amt='.$payment_amount.'&user_type='.$_SESSION['user_type'].'&passid='.$fetchRecords['pass_id'].'&event_id='.$row['id']; ?>">
														 Show Ticket
														</a>
													<?php

													}

													/**** check streaming ticket exists ****/

													if($count_ticket_check == 1 && $_SESSION['user_type'] == 'user')
													{
														
														$get_ticket_id = mysql_fetch_assoc($check_ticket);
														$ticket_id = $get_ticket_id['ticket_id'];
														
														$check_user_purchased_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$ticket_id."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."' AND event_id = '".$row['id']."'");
														$count_downloaded_ticket = mysql_num_rows($check_user_purchased_ticket);
														
														if($count_downloaded_ticket < 1)
														{ 
													?>
															<a class="buysttickets" href="OneTimePay.php?pay=b4da7e5003f85ef0055f8fb026d9354e&host_id=<?php echo $row['host_id']; ?>&user_type=club&ticket_id=<?php echo $ticket_id; ?>&event_id=<?php echo $row['id']; ?>">
													 Streaming Ticket
															</a> 
													<?php
														}
														else
														{ ?>
												 
														<span class="avail">Already Purchased Ticket</span>
													
													<?php }
													}
													/**** check ticket exists ****/
												}
												?>
													<!-- <a href="#">More</a>
													<div class="clear"></div>
													<a href="#">Buy</a> -->
												</div>
             <div class='clear'></div>
            
											</li>
								<?php 		} // END WHILE	?>		 
				 						</ul>
				 				<?php 	} // END COUNT CONDITION 	
				 					else
				 					{
				 						echo "<div class='NoRecordsFound' id='NoRecordsFound'>No events Yet!</div>";
				 					}
				 				?>
				 					</div> <!-- END NEW BAND -->
								</div>
								<!-- END EVENT CONTAINER --> 
							</div>
     </div>
			</div>
		</div>
  	</div>
</div>
<?php include('Footer.php') ?>