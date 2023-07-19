<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = "Genre Page";

if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('Header.php');
}
// date_default_timezone_set('America/Chicago');

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
$day = date('l');

$videosArray = array();
$st = 0;

$ct = $_GET['category'];
if($ct == 'R-B')
{
	$catNameUrl = 'R&B';
} else {
	$catNameUrl = $ct;
}

if($_GET['type'] == 'usersList')
{
	$USERTYPE = 'User';
	$getFearuredClubs = mysql_query("SELECT * FROM `user` WHERE `profileType` = 'Public' AND `profile_count` >= '0' AND `id` != '1' /*AND `city` = '$_SESSION[id]'*/  ORDER BY `profile_count` DESC ");

	// if(mysql_num_rows($getFearuredClubs) < 1)
	// {
	// 	//die('1');
	// 	$cityID = $_SESSION['id'];
	// 	$ccid = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$cityID' ");
	// 	$ccidfetch = mysql_fetch_array($ccid);
	// 	$cclong = $ccidfetch['lng'];
	// 	$cclat = $ccidfetch['lat'];
	// 	$stateId = $_SESSION['state'];
	// 	$distancesArray = array();
	// 	$rescities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateId' AND `city_id` != '$cityID' ");
	// 	while($fetchrescities = mysql_fetch_array($rescities))
	// 	{
	// 		if(strlen($fetchrescities['city_name']) > 2 )
	// 		{
	// 			if($fetchrescities['lng'] != 0.000000 && !empty($fetchrescities['lng']))
	// 			{
	// 				$restlong = $fetchrescities['lng'];
	// 				$restlat = $fetchrescities['lat'];
	// 				$distancemiles = distance($cclat, $cclong, $restlat, $restlong, "M");
	// 				$distancesArray[$fetchrescities['city_id']] = $distancemiles;
	// 			}
	// 		}
	// 	}

	// 	$citys = "";
	// 	asort($distancesArray);
	// 	$a=0;
	// 	foreach($distancesArray as $key=>$dis)
	// 	{
	// 		if($dis < 50)
	// 		{
	// 			$citys .= $key.",";
	// 		}
	// 	}
	// 	$citystring = rtrim($citys,",");

	// 	if(empty($citystring))
	// 	{
			
	// 		$getFearuredClubs = mysql_query("SELECT * FROM `user` WHERE `profileType` = 'Public' AND  `profile_count` >= '0' AND `id` != '1' AND `state` = '$_SESSION[state]'  ORDER BY `profile_count` DESC ");
	// 		if(mysql_num_rows($getFearuredClubs) < 1)
	// 		{
	// 			$getFearuredClubs = mysql_query("SELECT * FROM `user` WHERE `profileType` = 'Public' AND  `profile_count` >= '0' AND `id` != '1' AND `city` = '54'  ORDER BY `profile_count` DESC ");
	// 		}
	// 	}
	// 	else
	// 	{
			
	// 		$getFearuredClubs = mysql_query("SELECT * FROM `user` WHERE `profileType` = 'Public' AND  `profile_count` >= '0' AND `id` != '1' AND `city` IN  (".$citystring.")  ORDER BY `profile_count` DESC ");
	// 		if(mysql_num_rows($getFearuredClubs) < 1)
	// 		{
	// 			$getFearuredClubs = mysql_query("SELECT * FROM `user` WHERE `profileType` = 'Public' AND  `profile_count` >= '0' AND `id` != '1' AND `city` = '54'  ORDER BY `profile_count` DESC ");
	// 		}
	// 	}
	// }


	while($fetchClubs = mysql_fetch_assoc($getFearuredClubs))
	{
		$getVideos1 = mysql_query("SELECT * FROM uploaed_video  WHERE `user_id` = '$fetchClubs[id]'  AND `user_type` = 'user' AND `featured` = '1' ORDER BY `track_no` ASC");

		if(mysql_num_rows($getVideos1) > 0)
		{
			while($r = mysql_fetch_assoc($getVideos1))
			{
				if(!empty($r['video_nm']))
				{
					$videosArray[$st]['id'] = $r['video_id'] . "<br>";
					$videosArray[$st]['host_id'] = $r['user_id'] . "<br>";
					$videosArray[$st]['user_type'] = $r['user_type'] . "<br>";
					$videosArray[$st]['video_path'] = $r['video_nm'] . "<br>";
					$videosArray[$st]['video_title'] = $r['video_title'] . "<br>";
					$st++;
				}
			}
		}
		else
		{
			// $getVideos1 = mysql_query("SELECT * FROM battle_playlist WHERE `user_id` = '$fetchClubs[id]'  AND `user_type` = 'user'");
			// while($r = mysql_fetch_assoc($getVideos1))
			// {
			// 	if(!empty($r['video_path']))
			// 	{
			// 		$videosArray[$st]['id'] = $r['id'];
			// 		$videosArray[$st]['host_id'] = $r['user_id'];
			// 		$videosArray[$st]['user_type'] = $r['user_type'];
			// 		$videosArray[$st]['video_path'] = $r['video_path'];
			// 		$videosArray[$st]['video_title'] = $r['video_title'];
			// 		$st++;
			// 	}
			// }
		}
	}

	$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '".$videosArray['0']['host_id']."'  ");
	$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
	$pname = trim($fetchClubInfo['profilename']);
	if(!empty($pname))
	{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
		$HostNAME = $fetchClubInfo['profilename'];
		$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
	}
	elseif(!empty($fetchClubInfo['first_name']))
	{       						//echo "<pre>"; print_r($fetchClubInfo); exit;
		$HostNAME = $fetchClubInfo['first_name']." ".$fetchClubInfo['last_name'];
		$HostImage = str_replace('../', '', $fetchClubInfo['image_nm']);
	}
	else
	{
		$HostNAME = 'MySitti';
		$HostImage = 'images/man4.jpg';
	}
	if(!isset($_SESSION['user_id']))
	{
		$profileURL = $SiteURL."profile.php?id=".$fetchClubInfo['id'];
	}
	else
	{
		$profileURL = $SiteURL."profile.php?id=".$fetchClubInfo['id'];
	}

	$videoPath = str_replace("../", "", $videosArray['0']['video_path']);
	$TITLE = 'People';


}
else
{
	$USERTYPE = 'Clubs';
	if($_GET['category'] == 'Clubs')
	{
		$TITLE = 'Clubs';
		$GETCAT = mysql_query("SELECT * FROM `club_category` WHERE `name` = 'Club' ");
		$fetchID = mysql_fetch_assoc($GETCAT);
		$CATID = $fetchID['id'];
		$getFearuredClubs = mysql_query("SELECT * FROM `clubs` WHERE `profileType` = 'Public' AND `type_of_club` = '$CATID' AND  `profile_count` > '1' AND `non_member` = '0' /*AND `club_city` = '$_SESSION[id]'*/ ORDER BY `profile_count` DESC ");
	}
	elseif($_GET['category'] != 'Clubs')
	{
		$TITLE = 'Artists';
		$GETCAT = mysql_query("SELECT * FROM `club_category` WHERE `name` = '$_GET[category]' ");
		$fetchID = mysql_fetch_assoc($GETCAT);
		$CATID = $fetchID['id'];
		$getFearuredClubs = mysql_query("SELECT * FROM `clubs` WHERE `type_details_of_club` LIKE '%$fetchID[name]%' AND  `profile_count` > '1' AND `non_member` = '0' AND `club_city` = '$_SESSION[id]' ORDER BY `profile_count` DESC ");

	}


	// if(mysql_num_rows($getFearuredClubs) < 1)
	// {
	// 	//die('1');
	// 	$cityID = $_SESSION['id'];
	// 	$ccid = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$cityID' ");
	// 	$ccidfetch = mysql_fetch_array($ccid);
	// 	$cclong = $ccidfetch['lng'];
	// 	$cclat = $ccidfetch['lat'];
	// 	$stateId = $_SESSION['state'];
	// 	$distancesArray = array();
	// 	$rescities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateId' AND `city_id` != '$cityID' ");
	// 	while($fetchrescities = mysql_fetch_array($rescities))
	// 	{
	// 		if(strlen($fetchrescities['city_name']) > 2 )
	// 		{
	// 			if($fetchrescities['lng'] != 0.000000 && !empty($fetchrescities['lng']))
	// 			{
	// 				$restlong = $fetchrescities['lng'];
	// 				$restlat = $fetchrescities['lat'];
	// 				$distancemiles = distance($cclat, $cclong, $restlat, $restlong, "M");
	// 				$distancesArray[$fetchrescities['city_id']] = $distancemiles;
	// 			}
	// 		}
	// 	}

	// 	$citys = "";
	// 	asort($distancesArray);
	// 	$a=0;
	// 	foreach($distancesArray as $key=>$dis)
	// 	{
	// 		if($dis < 50)
	// 		{
	// 			$citys .= $key.",";
	// 		}
	// 	}
	// 	$citystring = rtrim($citys,",");

	// 	if(empty($citystring))
	// 	{
			
	// 		$getFearuredClubs = mysql_query("SELECT * FROM `clubs` WHERE `profile_count` >= '0'  AND `club_state` = '$_SESSION[state]'  ORDER BY `profile_count` DESC ");
	// 		if(mysql_num_rows($getFearuredClubs) < 1)
	// 		{
	// 			$getFearuredClubs = mysql_query("SELECT * FROM `clubs` WHERE `profile_count` >= '0' AND `id` != '1' AND `club_city` = '54'  ORDER BY `profile_count` DESC ");
	// 		}
	// 	}
	// 	else
	// 	{
			
	// 		$getFearuredClubs = mysql_query("SELECT * FROM `clubs` WHERE `profile_count` >= '0'  AND `club_city` IN  (".$citystring.")  ORDER BY `profile_count` DESC ");
	// 		if(mysql_num_rows($getFearuredClubs) < 1)
	// 		{
	// 			$getFearuredClubs = mysql_query("SELECT * FROM `clubs` WHERE `profile_count` >= '0' AND `id` != '1' AND `club_city` = '54'  ORDER BY `profile_count` DESC ");
	// 		}
	// 	}
	// }



	
	while($fetchClubs = mysql_fetch_assoc($getFearuredClubs))
	{
		$getVideos1 = mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$fetchClubs[id]'  AND `user_type` = 'club' AND `featured` = '1' ORDER BY `track_no` ASC");

		if(mysql_num_rows($getVideos1) > 0)
		{
			while($r = mysql_fetch_assoc($getVideos1))
			{
				if(!empty($r['video_nm']))
				{
					$videosArray[$st]['id'] = $r['video_id'];
					$videosArray[$st]['host_id'] = $r['user_id'];
					$videosArray[$st]['user_type'] = $r['user_type'];
					$videosArray[$st]['video_path'] = $r['video_nm'];
					$videosArray[$st]['video_title'] = $r['video_title'];
					$st++;
				}
			}
		}
		else
		{
			$getVideos1 = mysql_query("SELECT * FROM uploaed_video WHERE `user_id` = '$fetchClubs[id]'  AND `user_type` = 'club' AND `featured` = '1' ORDER BY `track_no` ASC");
			while($r = mysql_fetch_assoc($getVideos1))
			{
				if(!empty($r['video_nm']))
				{
					$videosArray[$st]['id'] = $r['video_id'];
					$videosArray[$st]['host_id'] = $r['user_id'];
					$videosArray[$st]['user_type'] = $r['user_type'];
					$videosArray[$st]['video_path'] = $r['video_nm'];
					$videosArray[$st]['video_title'] = $r['video_title'];
					$st++;
				}
			}
		}
	}
	
	$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `profileType` = 'Public' AND `id` = '".$videosArray['0']['host_id']."'  ");
	$fetchClubInfo = mysql_fetch_assoc($getClubInfo);

	if(!empty($fetchClubInfo['club_name']))
	{
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

	$videoPath = str_replace("../", "", $videosArray['0']['video_path']);
	
}


$currdate = date('Y-m-d');

// echo "<pre>"; print_r($videosArray); exit;


?>
<style type="text/css">

.v2_banner_top1.h_auto .bx-viewport {
   height: auto !important;
}
.v2_banner_top1.h_auto ul.new_height {
  height: 402px !important;  overflow: hidden;
}

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

.jw-skin-seven .jw-controlbar {
  margin: 0 auto !important;
  width: 720px !important;
}


</style>
<script type="text/javascript">
	$(document).ready(function(){
		
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

		var link = $('#mp4Source').attr('src');
		var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
		var current = 0;
		var playlist = $('#playlist');
		var videottl = $('#vtitle').val();
		var tracks = playlist.find('li');
		var len = tracks.length;
		if(isYoutube)
		{
				jwplayer("tv_main_channel").setup({
						file: link,
					  	autostart: false,
					  	mute: true,
					  	stretching: 'none',
					  	volume: 0,
					  	events: {
							onComplete: function() {
								
							},
							onReady: function() {
								playVideo(link,videottl);
							},
							onResume: function(){
								// alert(2);
							}
						}
				  	});
		
		}
		else
		{
			// alert(2);
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link,
					'videottll' : videottl,
					'link': 'mp4'
				},
				success: function( data ) 
				{
					
					$('.TV').html(data);
					if(link == '' || link == ' ')
					{
						link = 'video/Default_Intro_video.mp4';
					}
					jwplayer("tv_main_channel").setup({
						file: link,
					  	autostart: true,
					  	mute: true,
					  	// volume: 0,
					  	stretching: 'none',
					  	width: "100%",
						//aspectratio: "16:9",
						//stretching : "uniform",
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

function playVideo(link,videottl)
{

		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'videottll' : videottl,
				'link': 'youtube'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				//player.play():
				//var player = new MediaElementPlayer('#tv_main_channel');
			

					
				jwplayer("tv_main_channel").setup({
						file: link,
					  	autostart: true,
					  	mute: true,
					  	stretching: 'none',
					  	// volume: 0,
					  	events: {
							onComplete: function() {
								
								
								//alert('complete');
								jwplayer().seek(0).play(true);
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
	//});
}
function changeMedia(args,id)
{
	//event.preventDefault();
	var link = $('li#'+id).find('a').find('#path_'+id).val();
	var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
	var newID = id;
	var link1 = $(this);
	var current = link1.parent().index();
	var playlist = $('#playlist');
	var tracks = playlist.find('li');
	var len = tracks.length;
	var videottl = $('#vtitle_'+id).val();
	var userID  = $('li#'+id).find('a').find('#host_'+id).val();
	var userTYPE  = $('li#'+id).find('a').find('#hostType_'+id).val();

	// $.ajax({
	// 	type: "POST",
	// 	url: "refreshajax.php",
	// 	data: {
	// 		'action': "changeVideoInfoFeatured", 
	// 		'videoid' : newID,
	// 		'userID' : userID,
	// 		'userType' : userTYPE
	// 	},
	// 	success: function( data ) 
	// 	{
	// 		var dd = data.split('++++');
	// 		$('#hostThumb').find('img').attr('src',dd[1]);
	// 		$('#hostName').find('a').text(dd[0]);
	// 		$('#hostName').find('a').attr('href',dd[2]);
	// 	}
	// });

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
		playVideo(link,videottl);
	}
	else
	{
		// alert(2);
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'videottll' : videottl,
				'link': 'mp4'
			},

			success: function( data ) 
			{
				$('.TV').html(data);
				jwplayer("tv_main_channel").setup({
						file: link,
					  	autostart: true,
					  	mute: true,
					  	stretching: 'none',
					  	// volume: 0,
					  	events: {
							onComplete: function() {
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

	



}

</script>
<style>
.home_wrapper {
  background: white;
  float: left;
  margin-top: 15px;
  padding-top: 20px;
  width: 100%;
}
.v2_banner_top {margin-bottom:0;}

.TV {
	float: left;
	height: 100%;
	width: 100%;
}

.battleTv .hoster {
  z-index: 1;
}
</style>
<div class="home_wrapper" style="margin-top:0;">
  <div class="main_home_live2battle">
	<div class="home_content">
	  <div class="home_content_bottom mbottom20" style="background:none;">
		<div class="wrapper">
		  <div class="play_vid_current battleTv newTv">
			<div class="hoster">
			  <!-- <div class="Hthumb" id='hostThumb'> <img src="<?php  echo $SiteURL.$HostImage;?>" alt=""/> </div> -->
			  <!-- <div class="Hname" id='hostName'> <a style="color:#FFF;text-decoration: none;" href="<?php echo $profileURL;?>">
				
				</a> </div> -->
			</div>
			<div class="TV">
				<div id="tv_main_channel" style="display:none;">
					<source id="mp4Source" src="<?php echo strip_tags($videoPath); ?>" type="video/mp4">
				</div>
			</div><!-- END TV div -->
			
		  </div>
		  <div class="MySittiplaylist newPlayList artistDetailList">
			<ul id="playlist">
			  <h1><?php echo $catNameUrl;?> <?php 
					$citi = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$_SESSION[id]'");
					$fetchciti = mysql_fetch_assoc($citi);
					$city_name = $fetchciti['city_name'];
			  		echo $city_name; 
			  		$stat = mysql_query("SELECT code FROM `zone` WHERE `zone_id` = '$fetchciti[state_id]'");
					$fetchstat = mysql_fetch_assoc($stat);
					$satacode = $fetchstat['code'];
			  		?>, <?php echo $satacode; ?></h1>
			<?php 
			$i = 0;
			//while($rowVideos = mysql_fetch_assoc($getVideos))
			// echo "<pre>"; print_r($videosArray); exit;
				if(count($videosArray) > 0)
				{
					// var_dump($videosArray);
					foreach($videosArray as $rowVideos)
					{
					 if(strip_tags($rowVideos['user_type']) == 'user')
						{
							$getClubInfo = mysql_query("SELECT * FROM `user` WHERE `id` = '$rowVideos[host_id]' ");
							$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
							// print_r($fetchClubInfo);
							
							$PROFILENAME = trim($fetchClubInfo['profilename']); 
							if(!empty($PROFILENAME))
							{
								$HostNAME1 = $fetchClubInfo['profilename'];
								$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
							}
							elseif(!empty($fetchClubInfo['first_name']))
							{
								$HostNAME1 = $fetchClubInfo['first_name']." ".$fetchClubInfo['last_name'];
								$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
							}
							else
							{
								$HostNAME1 = 'MySitti';
								$HostImage1 = 'images/man4.jpg';
							}
							$path = str_replace('../', '', strip_tags($rowVideos['video_path']));
						}
						else
						{
							$getClubInfo = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$rowVideos[host_id]'");
							
							$fetchClubInfo = mysql_fetch_assoc($getClubInfo);
							$PROFILENAME = trim($fetchClubInfo['club_name']); 
							if(!empty($PROFILENAME))
							{
								$HostNAME1 = $fetchClubInfo['club_name'];
								$HostImage1 = str_replace('../', '', $fetchClubInfo['image_nm']);
							}
							else
							{
								$HostNAME1 = 'MySitti';
								$HostImage1 = 'images/man4.jpg';
							}
							$path = str_replace('../', '', $rowVideos['video_path']);

						}
						
						if(!empty($path))
						{

						?>
							<li class='<?php if($i == '0'){ echo "active";} ?> list_play videourl_<?php echo $path;?>' id='<?php echo strip_tags($rowVideos['id']);?>'>
								<a href="javascript:void(0);" class="vid_<?php echo $path;?>" onclick="changeMedia('','<?php echo strip_tags($rowVideos['id']); ?>')" id='video_<?php echo strip_tags($rowVideos['id']);?>' >
									<?php echo strip_tags($rowVideos['video_title']).' By '.$HostNAME1;?>
									<input type="hidden" id="path_<?php echo strip_tags($rowVideos['id']);?>" value="<?php echo $path;?>" />
									<input type="hidden" id="host_<?php echo strip_tags($rowVideos['id']);?>" value="<?php echo strip_tags($rowVideos['host_id']);?>" />
									<input type="hidden" id="hostType_<?php echo strip_tags($rowVideos['id']);?>" value="<?php echo strip_tags($rowVideos['user_type']);?>" />
									<input type="hidden" id="vtitle" value="<?php echo strip_tags($rowVideos['video_title']);?>" />
									<input type="hidden" id="vtitle_<?php echo strip_tags($rowVideos['id']);?>" value="<?php echo strip_tags($rowVideos['video_title']);?>" />
								</a>
							</li>
				  <?php 
				  		}
						$i++;
					}
				}
				else
				{
					?>
					<li  class='<?php if($i == '0'){ echo "active";} ?> list_play videourl_video/Default_Intro_video.mp4' id='1'>
						<a href="javascript:void(0);" class="vid_video/Default_Intro_video.mp4" onclick="changeMedia('<?php echo str_replace("../", "", "video/Default_Intro_video.mp4"); ?>','1')" id='video_1' >
							MySitti Intro<?php //echo $rowVideos['video_title'].' <br />By '.$HostNAME1;?><br />
							<input type="hidden" id="path_1" value="video/Default_Intro_video.mp4" />
						</a>
					</li>
	<?php			}
	?>
			</ul>
	  	</div>
	  	<div class="clear"></div>
  	<?php 
  		if($_GET['type'] == 'usersList')
		{

			$getAllStreamingHost = mysql_query("SELECT `c`.`id`,`c`.`first_name`,`c`.`last_name`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`profilename` as `profilename` FROM `user` as `c`, `capital_city` as cc, `zone` as `z` 
			WHERE `c`.`city` = `cc`.`city_id`
			AND `c`.`state` = `z`.`zone_id`
			AND `cc`.`state_id` = `z`.`zone_id`
			-- AND `c`.`city` = '$_SESSION[id]'
			AND `c`.`profileType` = 'Public'  
			/*AND `c`.`streamingLaunch` = '1'*/
			ORDER BY rand() LIMIT 0,500");
			$urlConcatenate = "profile.php?id=";
		}
		else
		{
			$getAllStreamingHost = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
			WHERE `c`.`club_city` = `cc`.`city_id`
			AND `c`.`club_state` = `z`.`zone_id`
			AND `cc`.`state_id` = `z`.`zone_id`
			-- AND `c`.`club_city` = '$_SESSION[id]'
			AND `c`.`profileType` = 'Public'  
			/*AND `c`.`streamingLaunch` = '1'*/
			AND `c`.`type_details_of_club` LIKE '%$fetchID[name]%'
			AND `c`.`non_member` = '0'
			ORDER BY rand() LIMIT 0,500 ");
			$urlConcatenate = "host_profile.php?host_id=";
		}
		if(mysql_num_rows($getAllStreamingHost) > 0)
		{
			if(isset($_GET['type']) && $_GET['type'] == 'usersList')
			{
				$viewURL = $SiteURL.'fullViewPage.php?fullPage=Streaming&type=Users';
			}
			else
			{
				$viewURL = $SiteURL.'fullViewPage.php?fullPage=Streaming&type=hosts';
			}
			
	?>
	  	<!--<div class="band_event_list tv_event_list fullblack NowStreamingListing">
			<h2> <img src="images/streaming-now.png" alt="" /> Streaming Now</h2>
			<a href="<?php echo $viewURL;?>" class="fullListView line-height">View All <img alt="" src="images/arrows.png"></a>
			<div class="clear"></div>
			<div class="img_slider_btm">
		  		<div>
		  		<ul class="hostSlider" id="streamingHosts">
		  		<?php 

				
		  			while($newres = mysql_fetch_assoc($getAllStreamingHost))
		  			{
		  				$profilename = trim($newres['profilename']);
		  				if(empty($profilename))
		  				{
		  					$firstname = trim($newres['first_name']);
		  					if(empty($firstname))
		  					{
		  						$noname = 'true';
		  					}
		  					else
		  					{
		  						$noname = 'false';
		  						$profilename = $newres['first_name']." ".$newres['last_name'];
		  					}
		  				}

		  				if(empty($newres['image_nm']))
		  				{
		  					$newres['image_nm'] = "images/man4.jpg";
		  				}

		  				if($noname != 'true')
		  				{
				?>
							<li style="custom_slide"> 
								<span class="city_users"><?php echo $newres['city_name'];?></span> 
								<span class="state_users"><?php echo $newres['zonename'];?></span>
								<a href="<?php echo $SiteURL.$urlConcatenate.$newres['id'];?>"> 
									<img src="<?php echo $SiteURL.$newres['image_nm'];?>" alt=""> 
								</a>
								<div class="live_stream_new"> </div>
								<span class="name_users">
									<?php echo $profilename;?>
								</span> 
							</li>
			<?php 			}
					}	?>
				</ul>
			  </div>
			</div>
	  	</div>-->
	  	<?php
	  	} // END Streaming Host Slider 
				if($_GET['category'] == 'Clubs')
				{
					$getCat = mysql_query("SELECT * FROM `club_category` WHERE `name` = 'Club' ");
					$fetchCatinfo = mysql_fetch_assoc($getCat);
					$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
					$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
				}
				elseif($_GET['type'] == 'usersList')
				{
					
				}
				else
				{
					if($_GET['category'] == 'Band')
					{
						$getCat = mysql_query("SELECT * FROM `club_category` WHERE `name` = 'Band' ");
						$fetchCatinfo = mysql_fetch_assoc($getCat);
						$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
						$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
						
					}
					if($_GET['category'] == 'Djs')
					{
						$getCat = mysql_query("SELECT * FROM `club_category` WHERE `name` = 'Djs' ");
						$fetchCatinfo = mysql_fetch_assoc($getCat);
						if($fetchCatinfo['parrent_id'] != '0')
						{
							$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
							$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
						}
						else
						{
							$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
							//$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
							$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
						}
					}
					if($_GET['category'] == 'Singer')
					{
						$getCat = mysql_query("SELECT * FROM `club_category` WHERE `name` = 'Singer' ");
						$fetchCatinfo = mysql_fetch_assoc($getCat);
						$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
						$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
					}
					if($_GET['category'] == 'Comedy Club')
					{
						$getCat = mysql_query("SELECT * FROM `club_category` WHERE `name` = 'Comedy Club' ");
						$fetchCatinfo = mysql_fetch_assoc($getCat);
						if($fetchCatinfo['parrent_id'] != '0')
						{
							$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
							$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
						}
						else
						{
							$getSubcats1 = mysql_query("SELECT * FROM `club_category` WHERE `id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
							//$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$fetchCatinfo[id]' ORDER BY `name` ASC ");
							$getSubcats2 = mysql_query("SELECT * FROM `club_category` WHERE `id` = '$fetchCatinfo[parrent_id]' ORDER BY `name` ASC ");
						}
					}
				}
				$categoryID = $fetchCatinfo['id'];
				$mainParrentId = $fetchCatinfo['parrent_id'];
		if($_GET['type'] == 'hosts')
		{
			//echo mysql_num_rows($getSubcats2);
		// if(mysql_num_rows($getSubcats2) > 0)
		// {
		?>
	  	<div class="TonightArtistListing">
			<h2> 
				<img src="images/artist.png" alt="" />Local <?php echo $TITLE;//echo $TITLE;?>
			</h2>
			<div class="selCatArtist">
				<!-- <select id="SelectArtist" onchange="changeresults();">
					<option Value="0" selected="selected"> Genre </option>
					<?php 
						// if(mysql_num_rows($getSubcats1) > 0)
						// {
						// 	while($rest = mysql_fetch_assoc($getSubcats1))
						// 	{
					?>
								<option  value="<?php echo $rest['name']; ?>"><?php echo $catNameUrl; ?></option>
					<?php 
						// 	}
						// }

					?>
				</select> -->
			</div>
			<!-- <div class="searchBoxTop searchInnerBox pullRight ">
			  	<form id="searchUsersForm">
					<input type="text" class="adSearch" placeholder="Search By Genre" name="keyword_search" value="" id="searchUsers12">
					<input type="button" value="" name="SearchCats" class="searchBoxTopBtn" id="findContestant12">
			  	</form>
			</div> -->
			<a class="seeall_genre line-height" href="<?php echo $SiteURL;?>viewAllArtist.php?allArtist=<?php echo $_GET['category']; ?>">See All</a>
								
			<div class="clear"></div>
			<div class="ListingInnerContain">
			<?php 
				
				// while($rest2 = mysql_fetch_assoc($getSubcats2))
				// {
	  				$getAllclubs = mysql_query("SELECT * FROM `clubs` 
						WHERE `type_details_of_club` LIKE '%$catNameUrl%' 
						AND `club_city` = '$_SESSION[id]' ORDER BY `profile_count` DESC LIMIT 6");
	  				// echo "SELECT * FROM `clubs` 
					// 	WHERE `type_details_of_club` LIKE '%$_GET[category]%' 
					// 	AND `club_city` = '$_SESSION[id]' ORDER BY `profile_count` DESC LIMIT 6";
					// 	die;
					
	  				if(mysql_num_rows($getAllclubs) > 0)
	  				{

					?>
						<div class="ArtistBox">
							
							<!-- <div class="listingTitle">
				   				<span><?php echo $rest2['name'];?></span>
							</div> -->
							<div class="MainListingArtst">
								<div class="img_slider_btm catsliderarea">
									<div>
										<ul class="hostSlider" <?php //if(mysql_num_rows($getAllclubs) > 6){ echo ' id="catsHosts" '; } ?>>
										<?php 						
							  				while($rest3 = mysql_fetch_assoc($getAllclubs))
											{
								  				$profilename = trim($rest3['club_name']);
								  				if(empty($profilename))
								  				{
								  					$firstname = trim($rest3['first_name']);
								  					if(empty($firstname))
								  					{
								  						$noname = 'true';
								  					}
								  					else
								  					{
								  						$noname = 'false';
								  						$profilename = $rest3['first_name']." ".$rest3['last_name'];
								  					}
								  				}

								  				if(empty($rest3['image_nm']))
								  				{
								  					$rest3['image_nm'] = "images/man4.jpg";
								  				}

											?>

												<li>
													
													<span class="state_users"><?php echo $city_name;?>, <?php echo $satacode;?></span> 
													<a href="artistPage.php?type=hosts&category=<?php echo $_GET['category']; ?>&artistId=<?php echo $rest3['id']; ?>"> 
														<img  alt="" src="<?php echo $SiteURL.str_replace("../", "", $rest3['image_nm']);?>"> 
													</a>
													<div class="live_stream_new">
													</div>
													<!-- <span class="name_users" style="cursor:pointer;" onclick="window.location.href='<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $rest3['id'];?>' "><?php echo $profilename;?></span> -->
													<span class="name_users"><?php echo $profilename;?></span>
												</li>
									<?php 		}	?>
										</ul>
									</div>
								</div>
							</div>
						</div>
			<?php 	}
					//}
				// }
				// else
				// {
					if($_GET['category'] == 'Clubs')
					{
						$getAllclubs = mysql_query("SELECT `ev`.`id` as `eventid`,`ev`.`event_image_thumb`,`c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z`, `events` as `ev`
						WHERE `c`.`profileType` = 'Public' 
						AND`c`.`club_city` = `cc`.`city_id`
						AND `c`.`club_state` = `z`.`zone_id`
						AND `cc`.`state_id` = `z`.`zone_id`
						AND `c`.`id` = 	`ev`.`host_id`
						/*AND `c`.`club_city` = '$_SESSION[id]'*/
						AND `c`.`non_member` = '0'
						AND `c`.`type_of_club` = '$fetchCatinfo[id]'
						AND date(`ev`.`date`) = '$currdate'
						ORDER BY rand() ");
						if(mysql_num_rows($getAllclubs) > 0)
						{
						
				?>
						<div class="ArtistBox">
							<a class="seeall_genre line-height" href="<?php echo $SiteURL;?>fullViewPage.php?fullPage=Clubs">See All <img src="images/arrow_yellow.png" alt=""></a>
							<div class="clear"></div>
							<div class="listingTitle">
				   				<span><?php echo $fetchCatinfo['name'];?></span>
							</div>
							<div class="MainListingArtst">
								<div class="img_slider_btm catsliderarea">
									<div>
										<ul class="hostSlider" id="catsHosts">
					<?php					
										while($rest3 = mysql_fetch_assoc($getAllclubs))
										{
											$profilename = trim($rest3['profilename']);
							  				if(empty($profilename))
							  				{
							  					$firstname = trim($rest3['first_name']);
							  					if(empty($firstname))
							  					{
							  						$noname = 'true';
							  					}
							  					else
							  					{
							  						$noname = 'false';
							  						$profilename = $rest3['first_name']." ".$rest3['last_name'];
							  					}
							  				}

							  				if(empty($rest3['image_nm']))
							  				{
							  					$rest3['image_nm'] = "images/man4.jpg";
							  				}
					?>
											<li>
												
												<span class="state_users"><?php echo $rest3['city_name'];?>, <?php echo $rest3['zonename'];?></span> 
												<a href="javascript:void(0);" onclick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $rest3['eventid'];?>&amp;action=event','','width=500,height=700,resizable=true,left=0,top=0');return false;"> 
													<img  alt="" src="<?php echo $SiteURL.str_replace("../", "", $rest3['event_image_thumb']);?>"> 
												</a>
												<div class="live_stream_new">
												</div>
												<span class="name_users" style="cursor:pointer;" onclick="window.location.href='<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $rest3['id'];?>' "><?php echo $rest3['profilename'];?></span>
											</li>
								<?php 		}	?>
										</ul>
									</div>
								</div>
							</div>
						</div>
				<?php 		}
					}
				//}

			?>
			</div>
		  </div>
		<?php 	
		//	} // CHECK LIST COUNT
		} // USERLIST CHECK	?>

		<div class="band_event_list tv_event_list fullblack NowStreamingListing">
			<h2> <img src="images/streaming-now.png" alt="" />Tonight Artist</h2>
			<!-- <form method="post">
				<input type="date" id="selectDate" name="dateTonight">
				<input type="button" name="submit" onclick="seeTonight()">
			</form> -->
			<!-- <a href="<?php echo $viewURL;?>" class="fullListView line-height">View All <img alt="" src="images/arrows.png"></a> -->
			<div class="clear"></div>
			<div class="img_slider_btm">
		  		<div>
		  		<ul class="hostSlider">
		  		<?php
		  		$date = date("Y-m-d");
		  		
		  			$getEvent = mysql_query("SELECT * FROM forum WHERE event_date = '$date' LIMIT 6");
						if(mysql_num_rows($getEvent) > 0)
						{
							while($event = mysql_fetch_assoc($getEvent))
							{ ?>
								<li class="custom_slide"> 
									<!-- <span class="city_users"><?php echo $event['forum'];?></span>  -->
									<span class="state_users"><?php echo $event['forum'];?></span>
									 <a href="">
									<?php if(empty($event['image_thumb']))
							  				{
							  					$event['image_thumb'] = "images/man4.jpg";
							  				} ?> 
										<img src="<?php echo $event['image_thumb'];?>" alt=""> 
									 </a>
									<div class="live_stream_new"> </div>
									<span class="name_users">
										<?php echo $event['event_address'];?>
									</span> 
								</li>
							<?php }
						}	?>
				</ul>
			    </div>
			</div>
	  	</div>



		</div>
	  </div>
	</div>
	<div id="myhiddenfield" style="display:none;" >
		
	</div>
  </div>
</div>
<script type="text/javascript">
	$('#streamingHosts, #catsHosts').bxSlider({
		maxSlides: 7,

		minSlides: 1,

		slideWidth: 160,

		slideMargin: 14,

		infiniteLoop: false,

		//hideControlOnEnd: true,

		pager: false
	});

	function changeresults()
	{
		$('#searchUsers12').val('');
		$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1>Loading Results</h1>'

		});
		var val = $('#SelectArtist').val();
		var maincat = '<?php echo $categoryID;?>';
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "changeCatresults", 
				'catname' : val,
				'maincat' : maincat,
			},
			success: function( data ) 
			{
				$('.ListingInnerContain').html(data);
				$.unblockUI();
			}	
		});
	}

	function seeTonight()
	{
		// $('#searchUsers12').val('');
		$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1>Loading Results</h1>'

		});
		var val = $('#selectDate').val();
		var maincat = '<?php echo $categoryID;?>';
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "tonightArtist", 
				'date' : val,
				'maincat' : maincat,
			},
			success: function( data ) 
			{
				$('.hostSlider').html(data);
				$.unblockUI();
			}	
		});
	}

	$('#searchUsers12').keypress(function() {
		var URL = 'refreshajax.php?action=fliersnames';

		$('#searchUsers12').autocomplete(URL);

	});

	function test()
	{

		$('#myhiddenfield').html($('.ac_over').html());
		var uname  = $('#myhiddenfield').text();

		var catid = "<?php echo $categoryID; ?>";
		$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1>Loading Results</h1>'

		});
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "changeCatresultsusingName",
				'uname' : uname,
				'catid' : catid,
			},
			success: function( data ) 
			{
				$('.ListingInnerContain').html(data);
				$('.ac_even12').html('');
				$.unblockUI();
			}	
		});
	}


</script>
<?php
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
?>