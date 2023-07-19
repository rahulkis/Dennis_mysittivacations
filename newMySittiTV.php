<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="MySitti TV";

if(!isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('LoginHeader.php');
}
// if(!isset($_GET['contest_id'])){
// header('Location: '.$SiteURL.'live2/battle.php?contest_id=112');
// die;
// }
$CONTESTID = $_GET['contest_id'];

$cr_ct_id = "";

if(empty($CONTESTID)){
	
	$check_cur_cont = mysql_query("SELECT * FROM contest WHERE battle_status = 'active'");
	$cont_row = mysql_fetch_assoc($check_cur_cont);

	$CONTESTID = $cont_row['contest_id'];
}
      date_default_timezone_set('America/Chicago');


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
.home_content_bottom:before {
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
#sc p span {
 width:100%;
 float:left;
 color:#505050;
}
.fl {
 float:left
}
#sc {
 border:0px !important;
 border-top:1px solid #ccc !important;
 padding: 2px !important
}
#sc p:hover {
 background:#f2f2f2;
}
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
.boject_container {
 width:66%;
 float:left;
 margin-right:2%;
}
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
object,
embed {
 max-width: 100%;
}
.boject_container {
 width:100%;
 margin:0;
}
#sc {
 width: 100%;
 float: l;
 box-sizing: border-box;
 border: 0px !important;
}
#sc p span {
 font-weight:bold;
}
.divider {
 width:100%;
 height:1px;
 background:#e7e7e7;
 float:left;
 margin:5px 0;
}
.closepop {
 float:right;
 margin:10px 0;
}
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
#chatMembers p span img {
 vertical-align:middle;
 margin-right:10px;
}
#chatMembers p a {
 color:#000;
}
.groupchatname > span#totalViewers {
 float: right;
}
.NewBand .v2_thumb_event a img {
 max-width: 100%;
 display: initial !important;
}
.NewHeaderHostBanner {
 box-shadow: 0 0 5px #222;
 -webkit-box-shadow: 0 0 5px #222;
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		console.clear();
		getYoutubeLinks();
		init();

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


			$('html, body').animate({
				scrollTop: parseInt($(".home_wrapper").offset().top - 150)
			}, 2000);
			$('.slider_body').remove();


	});
	function getYoutubeLinks()
	{
		//console.clear();
		// videos = document.getElementById("tv_main_channel");
		videos = document.querySelectorAll("video");
		for (var i = 0, l = videos.length; i < l; i++) 
		{
			var video = videos[i];
			var src = video.src || (function () 
			{
				var sources = video.querySelectorAll("source");
				for (var j = 0, sl = sources.length; j < sl; j++) 
				{
					var source = sources[j];
					var type = source.type;
					var isMp4 = type.indexOf("mp4") != -1;
					if (isMp4) return source.src;
				}
				return null;
			})();
			if (src) 
			{
				var isYoutube = src && src.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
				if (isYoutube) 
				{
					var id = isYoutube[1].match(/watch\?v=|[\w\W]+/gi);
					id = (id.length > 1) ? id.splice(1) : id;
					id = id.toString();
					var mp4url = "http://www.youtubeinmp4.com/redirect.php?video=";
					video.src = mp4url + id;
					$('#mp4Source').attr('src',mp4url + id);
				}
			}
		}
	}
var audio;
var playlist;
var tracks;
var current;


function init()
{
	current = 0;
	audio = $('#tv_main_channel');
	playlist = $('#playlist');
	tracks = playlist.find('li');
	//alert(tracks);
	var tt = $('#playlist li').length;
	//
	len = tracks.length;
	//alert(len);
	audio[0].volume = .10;
	audio[0].play();
	playlist.find('a').click(function(e){
		e.preventDefault();
		link = $(this);
		current = link.parent().index();
		run(link, audio[0]);
		// return false;
	});
	audio[0].addEventListener('ended',function(e){
		current++;
		//current = current - 1;
		if(current >= len ){
			current = 0;
			link = playlist.find('a')[0];
		}else{
			link = playlist.find('a')[current];    
		}

		run($(link),audio[0]);

	});
}

function run(link, player){
	player.src = link.attr('href');
	var newID = link.attr('id');
	
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

	$('#mp4Source').attr('src',link.attr('href'));

	par = link.parent();
	par.addClass('active').siblings().removeClass('active');
	var isYoutube = link.attr('href') && link.attr('href').match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
	if (isYoutube) 
	{
		getYoutubeLinks();
	}
	audio[0].load();
	audio[0].play();
}


</script>
<style>
.home_wrapper {
  background: rgba(0, 0, 0, 0) url("../images/noice.png") repeat scroll left top;
  float: left;
  margin-top: 15px;
  padding-top: 20px;
  width: 100%;
}
.v2_banner_top {margin-bottom:0;}
</style>
<div class="home_wrapper" style="margin-top:0;">
  <div class="main_home_live2battle">
    <div class="home_content">
      <div class="home_content_bottom mbottom20" style="background:none;">
        <div class="wrapper">
          <div class="play_vid_current battleTv newTv">
            <div class="hoster">
              <div class="Hthumb" id='hostThumb'> <img src="<?php  echo $SiteURL.$HostImage;?>" alt=""/> </div>
              <div class="Hname" id='hostName'> <a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>">
                <?php  echo $HostNAME;?>
                </a> </div>
            </div>
            <video preload="auto" id="tv_main_channel" width="400" controls autoplay >
              <source id="mp4Source" src="<?php echo str_replace('../', '', $getDefault['video_path']); ?>" type="video/mp4">
            </video>
          </div>
          <div class="MySittiplaylist newPlayList">
            <ul id="playlist">
              <h1>Featured Artists</h1>
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
              <li  class='<?php if($i == '0'){ echo "active";} ?>' id='play_<?php echo $i;?>'> <a href="<?php echo $path;?>" id='video_<?php echo $rowVideos['id'];?>' > <?php echo $rowVideos['video_title'].' <br />By '.$HostNAME1;?><br />
                </a> </li>
              <?php 
						$i++;
				}
			?>
            </ul>
          </div>
          <div class="clear"></div>
          <div class="band_event_list tv_event_list fullblack NowStreamingListing">
            <h2> <img src="images/streaming-now.png" alt="" /> Streaming Now</h2>
            <a href="#" class="fullListView line-height">Full List <img alt="" src="images/arrows.png"></a>
            <div class="clear"></div>
            <div class="img_slider_btm">
              <div>
                <ul class="hostSlider">
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                  <li style="custom_slide"> <span class="city_users">California</span> <span class="state_users">Los Angeles</span> <a href="https://mysitti.com/host_profile.php?host_id=497797"> <img src="https://mysitti.com/upload/14488690591448863200photo.jpg" alt=""> </a>
                    <div class="live_stream_new"> </div>
                    <span class="name_users">sahil1234</span> </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="TonightArtistListing">
            <h2> <img src="images/artist.png" alt="" />Tonight Artists</h2>
            <div class="selCatArtist">
              <select id="SelectArtist">
                <option Value="0" selected="selected"> Select Category</option>
                <option Value="1" > Artist</option>
                <option Value="2" > Artist</option>
                <option Value="3" > Artist</option>
              </select>
            </div>
            <div class="searchBoxTop searchInnerBox pullRight ">
              <form id="searchUsersForm" action="https://mysittidev.com/searchUsers.php" method="POST">
                <input type="text" class="adSearch" placeholder="Search By Username" name="keyword_search" value="" id="searchUsers12">
                <input type="submit" value="" name="SearchAllUsers" class="searchBoxTopBtn" id="findContestant12">
              </form>
            </div>
            <div class="clear"></div>
            <div class="ListingInnerContain">
            <div class="ArtistBox">
            <a class="fullListView line-height" href="#">Full List <img src="images/arrow_yellow.png" alt=""></a>
            <div class="clear"></div>
            <div class="listingTitle">
           <span> R & B</span>
            </div>
            <div class="MainListingArtst">
            <div class="img_slider_btm">
							<div>
								<div class="bx-wrapper" style="max-width: 1204px; margin: 0px auto;"><div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 173px;"><ul class="hostSlider" style="width: 2415%; position: relative; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
									<li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li>
									<li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li>
								</ul></div><div class="bx-controls bx-has-controls-direction"><div class="bx-controls-direction"><a href="" class="bx-prev">Prev</a><a href="" class="bx-next">Next</a></div></div></div>
							</div>
						</div>
            </div>
            </div>
            
            <div class="ArtistBox">
            <a class="fullListView line-height" href="#">Full List <img src="images/arrow_yellow.png" alt=""></a>
            <div class="clear"></div>
            <div class="listingTitle">
           <span>JAZZ</span>
            </div>
            <div class="MainListingArtst">
            <div class="img_slider_btm">
							<div>
								<div class="bx-wrapper" style="max-width: 1204px; margin: 0px auto;"><div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 173px;"><ul class="hostSlider" style="width: 2415%; position: relative; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
									<li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li>
									<li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li>
								</ul></div><div class="bx-controls bx-has-controls-direction"><div class="bx-controls-direction"><a href="" class="bx-prev">Prev</a><a href="" class="bx-next">Next</a></div></div></div>
							</div>
						</div>
            </div>
            </div>
            
            <div class="ArtistBox">
            <a class="fullListView line-height" href="#">Full List <img src="images/arrow_yellow.png" alt=""></a>
            <div class="clear"></div>
            <div class="listingTitle">
           <span> Rappers</span>
            </div>
            <div class="MainListingArtst">
            <div class="img_slider_btm">
							<div>
								<div class="bx-wrapper" style="max-width: 1204px; margin: 0px auto;"><div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 173px;"><ul class="hostSlider" style="width: 2415%; position: relative; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
									<li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li>
									<li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li><li style="float: left; list-style: outside none none; position: relative; width: 160px; margin-right: 14px;">
										<span class="city_users">California</span> 
										<span class="state_users">Los Angeles</span> 
										<a href="https://mysitti.com/host_profile.php?host_id=497797"> 
											<img alt="" src="https://mysitti.com/upload/14488690591448863200photo.jpg"> 
										</a>
										<div class="live_stream_new">
			  							</div>
										<span class="name_users">sahil1234</span> 
									</li>
								</ul></div><div class="bx-controls bx-has-controls-direction"><div class="bx-controls-direction"><a href="" class="bx-prev">Prev</a><a href="" class="bx-next">Next</a></div></div></div>
							</div>
						</div>
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('.hostSlider').bxSlider({
		maxSlides: 7,

		minSlides: 1,

		slideWidth: 160,

		slideMargin: 14,

		infiniteLoop: false,

		//hideControlOnEnd: true,

		pager: false
	});
</script>
<?php include('Footer.php') ?>
