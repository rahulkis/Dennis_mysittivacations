<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Battle";
include('Header.php');

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

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
//$surl = "https://" . $_SERVER['SERVER_NAME']."/index.php";
//if(!isset($userID)){$Obj->Redirect($surl);}
//if(!isset($CONTESTID)){$Obj->Redirect($surl);}

$get_contest_viewers = mysql_query("SELECT counter FROM contest WHERE contest_id = '".$CONTESTID."'");
$count_viewers = mysql_fetch_assoc($get_contest_viewers);
$contest_viewers = $count_viewers['counter'];

if(!isset($_SESSION['contest_counter'])){
	
	$_SESSION['contest_counter'] = $contest_viewers + 1;

	mysql_query("UPDATE contest SET counter = '".$_SESSION['contest_counter']."' WHERE contest_id = '".$CONTESTID."'");
	
}

if(isset($_POST['sent_streaming_data'])){
	
		/* detect_stream added by kbimn on 30-01-2015 */
		function detect_stream($hbhost){
			$st_qry = 'ffmpeg -i rtsp://192.163.248.47:1935/live/'.$hbhost.' 2>&1; echo $?';
			//echo $st_qry;
			$st_res=(string)trim(shell_exec($st_qry));
			//echo $st_res;
			//die;
			if (strpos($st_res,'404 Not Found') === false) {
				return true;
			}
			
			return false;
		
		}	
	
		$get_streaming_contestents = mysql_query("SELECT * FROM battle_settings WHERE status = 'accepted' order by slot_start_time"); // check which host is streaming
		$count_streaming_contestents = mysql_num_rows($get_streaming_contestents);

		$curr_date = date('Y-m-d H:i:s');
		$streaming_host_array = array();
		$current_shout_date = date('Y-m-d');
		
		while($str_row = mysql_fetch_assoc($get_streaming_contestents)){
			
			$start_t = $str_row['slot_start_time'];
			$end_t = $str_row['slot_end_time'];
			
			if($curr_date >= $start_t && $curr_date <=$end_t){ // fetch host which is streaming within contest date

				$total_host_shouts = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND to_user = '".$str_row['user_id']."'"); // query to count total no. of shouts
				
				$count_user_shouts = mysql_num_rows($total_host_shouts); // Count total number of shouts

				$check_user_shout = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND from_user = '".$_SESSION['user_id']."' AND to_user = '".$str_row['user_id']."'"); // query to count current user total no. of shouts
				$count_current_user_shouts = mysql_num_rows($check_user_shout); // Count total number of shouts of current user
				
				
				if($count_current_user_shouts < 1){
					
					$shout_click = "<img id='user_shout_count' alt='' src='dummy_images/thumb_shouts_battle.png' style='cursor: pointer;' onClick=\"add_user_shout('".$_POST['contest_id']."','".$_SESSION['user_id']."', '".$_SESSION['user_type']."', '".$str_row['user_id']."' , 'club')\";>";
					
				}else{
					
					$shout_click = '<img src="dummy_images/thumb_shouts_battle.png">';
					
				}
				

				$get_club_data = mysql_query("SELECT club_name, image_nm FROM clubs WHERE id = '".$str_row['user_id']."'"); // fetch host data
				$get_club_details = mysql_fetch_assoc($get_club_data);
				
				$club_n = clean($get_club_details['club_name']);
				
				$streaming_host_array['streaming_hostname'] = $club_n;
				
				$host_end_date = date('D M d Y H:i:s O' , strtotime($end_t));
				$streaming_host_array['streaming_endtime'] = $host_end_date;
				
				if(empty($get_club_details['image_nm'])){
					
						$streaming_host_array['streaming_host_img'] = "man4.jpg";
					
				}else{
					
					    $streaming_host_array['streaming_host_img'] = $get_club_details['image_nm'];
					
				}
				
				
				$streaming_host_array['streaming_host_id'] = $str_row['user_id'];
				$streaming_host_array['streaming_host_shouts'] = $count_user_shouts;
				$streaming_host_array['shout_click'] = $shout_click;
			
			}
			
		}
		
		$streaming_host = $streaming_host_array['streaming_hostname'];
		$streaming_host_end_time = $streaming_host_array['streaming_endtime'];
		$streaming_host_thumb = $streaming_host_array['streaming_host_img'];
		$current_streaming_host_id = $streaming_host_array['streaming_host_id'];
		$host_total_shouts = $streaming_host_array['streaming_host_shouts'];
		$user_shout_check = $streaming_host_array['shout_click'];
		
		if(empty($streaming_host)){ // demo host i.e. MYSITTI
			
				$total_host_shouts = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND to_user = '497627'"); // query to count total no. of shouts
				
				$count_user_shouts = mysql_num_rows($total_host_shouts); // Count total number of shouts
				
				
				
				$check_user_shout = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND from_user = '".$_SESSION['user_id']."' AND to_user = '497627'"); // query to count current user total no. of shouts
				$count_current_user_shouts = mysql_num_rows($check_user_shout); // Count total number of shouts of current user
				
				
				if($count_current_user_shouts < 1){
					
					$shout_click = "<img id='user_shout_count' alt='' src='dummy_images/thumb_shouts_battle.png' style='cursor: pointer;' onClick=\"add_user_shout('".$_POST['contest_id']."','".$_SESSION['user_id']."', '".$_SESSION['user_type']."', '497627' , 'club')\";>";
					
				}else{
					
					$shout_click = '<img src="dummy_images/thumb_shouts_battle.png">';
					
				}			
			
			
			
				$get_club_data = mysql_query("SELECT club_name, image_nm FROM clubs WHERE id = '497627'");
				$get_club_details = mysql_fetch_assoc($get_club_data);
				
				$club_n = clean($get_club_details['club_name']);
				
				
				$streaming_host_array['streaming_hostname'] = $club_n;
				
				if(empty($get_club_details['image_nm'])){
					
					$streaming_host_array['streaming_host_img'] = "man4.jpg";
					
				}else{
					
					$streaming_host_array['streaming_host_img'] = $get_club_details['image_nm'];
					
				}
				
				$streaming_host_array['streaming_host_shouts'] = $count_user_shouts;
				$streaming_host_array['shout_click'] = $shout_click;
				
				
				//$streaming_hostname[] = $club_n;
				//$host_end_date = date('D M d Y H:i:s O' , strtotime($end_t));
				//$streaming_endtime[] = $host_end_date;
				//$streaming_host_img[] = $get_club_details['image_nm'];

					echo json_encode(
						array(
						"ADS" => "show",
						"HOSTNAME" => $streaming_host_array['streaming_hostname'],
						"HOSTADS" => "notshow",
						"HOSTTHUMB" => $streaming_host_array['streaming_host_img'],
						"HOSTID" => "497627",
						"TOTALSHOUTS" => $streaming_host_array['streaming_host_shouts'],
						"USERSHOUT" => $streaming_host_array['shout_click']
						)
					);
			
		}else{
		
			if(detect_stream($streaming_host)===true){
				
				echo json_encode(
					array(
					"ADS" => "notshow",
					"HOSTNAME" => $streaming_host,
					"HOSTADS" => "notshow",
					"ENDTIME" => $streaming_host_end_time,
					"HOSTTHUMB" => $streaming_host_thumb,
					"STRHOST" => "show",
					"HOSTID" => $current_streaming_host_id,
					"TOTALSHOUTS" => $host_total_shouts,
					"USERSHOUT" => $user_shout_check					
					)
				);				
				
			}else{
				
				//echo "SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND to_user = '497627'";
				
				$total_host_shouts = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND to_user = '497627'"); // query to count total no. of shouts
				
				$count_user_shouts = mysql_num_rows($total_host_shouts); // Count total number of shouts

				$check_user_shout = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND from_user = '".$_SESSION['user_id']."' AND to_user = '497627'"); // query to count current user total no. of shouts
				$count_current_user_shouts = mysql_num_rows($check_user_shout); // Count total number of shouts of current user
				
				
				if($count_current_user_shouts < 1){
					
					$shout_click = "<img id='user_shout_count' alt='' src='dummy_images/thumb_shouts_battle.png' style='cursor: pointer;' onClick=\"add_user_shout('".$_POST['contest_id']."','".$_SESSION['user_id']."', '".$_SESSION['user_type']."', '497627' , 'club')\";>";
					
				}else{
					
					$shout_click = '<img src="dummy_images/thumb_shouts_battle.png">';
					
				}			
			
			
			
				$get_club_data = mysql_query("SELECT club_name, image_nm FROM clubs WHERE id = '497627'");
				$get_club_details = mysql_fetch_assoc($get_club_data);
				
				$club_n = clean($get_club_details['club_name']);
				
				if(empty($get_club_details['image_nm'])){
					
					$streaming_host_array['streaming_host_img'] = "man4.jpg";
					
				}else{
					
					$streaming_host_array['streaming_host_img'] = $get_club_details['image_nm'];
					
				}
				
				$streaming_host_array['streaming_hostname'] = $club_n;
				
				$streaming_host_array['streaming_host_shouts'] = $count_user_shouts;
				$streaming_host_array['shout_click'] = $shout_click;
				
				
				//$streaming_hostname[] = $club_n;
				//$host_end_date = date('D M d Y H:i:s O' , strtotime($end_t));
				//$streaming_endtime[] = $host_end_date;
				//$streaming_host_img[] = $get_club_details['image_nm'];

					echo json_encode(
						array(
						"ADS" => "notshow",
						"HOSTNAME" => $streaming_host_array['streaming_hostname'],
						"HOSTADS" => "show",
						"HOSTTHUMB" => $streaming_host_array['streaming_host_img'],
						"HOSTID" => "497627",
						"TOTALSHOUTS" => $streaming_host_array['streaming_host_shouts'],
						"USERSHOUT" => $streaming_host_array['shout_click']
						)
					);				
				

				//echo json_encode(
				//	array(
				//	"ADS" => "notshow",
				//	"HOSTNAME" => $streaming_host,
				//	"HOSTADS" => "show",
				//	"ENDTIME" => $streaming_host_end_time,
				//	"HOSTTHUMB" => $streaming_host_thumb,
				//	"HOSTID" => $current_streaming_host_id,
				//	"TOTALSHOUTS" => $host_total_shouts,
				//	"USERSHOUT" => $user_shout_check
				//	)
				//);
				//
			}
		}
		
die;		
}

if(isset($_POST['live_battle_shout'])){

	$current_shout_date = date('Y-m-d');
	$check_shout = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND from_user = '".$_POST['from_user']."' AND to_user = '".$_POST['to_user']."' AND shouted_date = '".$current_shout_date."'");
	
	$check_shout = mysql_num_rows($check_shout);
	
		if($check_shout < 1){
			
			mysql_query("INSERT INTO live_battle_shouts (`contest_id`, `from_user`, `from_user_type`, `to_user`, `to_user_type`, `shouted_date`) VALUES ('".$_POST['contest_id']."', '".$_POST['from_user']."', '".$_POST['from_user_type']."', '".$_POST['to_user']."', '".$_POST['to_user_type']."', '".$current_shout_date."' )");
			
		}
		
	$restrict_user = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND to_user = '".$_POST['to_user']."'");
	
	$count_user_shouts = mysql_num_rows($restrict_user);
	
	$count_user_shouts_main = '<div id="outer_shouts_area"> Shouts <span id="total_shouts">'.$count_user_shouts.'</span></div>';
	
	$img = '<img src="dummy_images/thumb_shouts_battle.png">';
	
				echo json_encode(
					array(
					"RESTRICT" => $img,
					"TOTAL_S" => $count_user_shouts,
					"TOTAL_S_UPPER" => $count_user_shouts_main
					)
				);	
	
die;
}

if(isset($_POST['live_battle_shout_lower'])){

	$current_shout_date = date('Y-m-d');
	$check_shout = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND from_user = '".$_POST['from_user']."' AND to_user = '".$_POST['to_user']."' AND shouted_date = '".$current_shout_date."'");
	
	$check_shout = mysql_num_rows($check_shout);
	
		if($check_shout < 1){
			
			mysql_query("INSERT INTO live_battle_shouts (`contest_id`, `from_user`, `from_user_type`, `to_user`, `to_user_type`, `shouted_date`) VALUES ('".$_POST['contest_id']."', '".$_POST['from_user']."', '".$_POST['from_user_type']."', '".$_POST['to_user']."', '".$_POST['to_user_type']."', '".$current_shout_date."' )");
			
		}
		
	$restrict_user = mysql_query("SELECT * FROM live_battle_shouts WHERE contest_id = '".$_POST['contest_id']."' AND to_user = '".$_POST['to_user']."'");
	
	$count_user_shouts = mysql_num_rows($restrict_user);
	
	$img = '<img style="" src="dummy_images/thumb_shouts_battle.png">';
	
				echo json_encode(
					array(
					"RESTRICT" => $img,
					"TOTAL_S" => $count_user_shouts
					)
				);	
	
die;
}

if(isset($_POST['total_viewers_count'])){
	
	$check_cur_cont = mysql_query("SELECT * FROM contest WHERE battle_status = 'active'");
	$cont_row = mysql_fetch_assoc($check_cur_cont);

	$CONTESTID = $cont_row['contest_id'];
	
	if(!empty($CONTESTID)){
		
		if(!isset($_SESSION['start_contest_automatically'])){
		
			echo "contest";
			$_SESSION['start_contest_automatically'] = "started";
		
		}
		
		$get_counter = mysql_query("SELECT counter FROM contest WHERE contest_id = '".$CONTESTID."'");
		$counter_val = mysql_fetch_assoc($get_counter);
		echo $counter_val['counter'];		
		
	}else{
			
		$get_counter = mysql_query("SELECT counter FROM contest WHERE contest_id = '".$_POST['contest_id']."'");
		$counter_val = mysql_fetch_assoc($get_counter);
		echo $counter_val['counter'];
	
	}
die;	
}



$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() {

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}

$user_os        =   getOS();
$user_browser   =   getBrowser();
/*
if($user_os=="Mac OS X" || $user_os=="Mac OS 9"){
	if($user_browser=="Safari"){
		ob_end_clean();
		header("Location: channel2.php?n=".$_GET['n']);	
		exit;
	}
}
else if($user_os=="iPad"){
	ob_end_clean();
	header("Location: channel2.php?n=".$_GET['n']);	
	exit;
}
else if($user_os=="iPod" || $user_os=="iPhone"){
	ob_end_clean();
	header("Location: channel2.php?n=".$_GET['n']);	
	//header("Location: http://192.163.248.47:1935/live/".$_GET['n']."/playlist.m3u8");	
	exit;
}
elseif($user_os=="Android" || $user_os=="BlackBerry" || $user_os=="Mobile"){
	ob_end_clean();
	header("Location: rtsp://192.163.248.47:1935/live/".$_GET['n']);	
	exit;
}
*/
/* kbihm code end */
?>

<!--<head>-->
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<!--<title>Mysitti || LIVE BATTLE</title>-->
<!--<link rel="stylesheet" type="text/css" href="../css/new_portal/style.css" />-->
<!--<script src="../lightbox/js/jquery-1.7.2.min.js"></script>-->
<!-- <script language="javascript" src="../group-chat/jquery-1.2.6.min.js"></script> -->
<!-- <script language="javascript" src="../group-chat/jquery.timers-1.0.0.js"></script> -->
<!--</head>-->
<!--<body >-->
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


</style>

<script type="text/javascript">
$(document).ready(function(){
	setInterval(function(){
		
		var data_sent = "testing";
			$.ajax({
				  type: "POST",
				  url: "battle.php",
				  data: {'sent_streaming_data': data_sent, 'contest_id' : '<?php echo $CONTESTID; ?>'}
			 }).done(function( jsondata ) {
				
					var json = jsondata, obj = JSON.parse(json);
					
					var SHOWADS = obj.ADS;
					var SHOWHOSTNAME = obj.HOSTNAME;
					var SHOWHOSTADS = obj.HOSTADS;
					var HOSTENDTIME = obj.ENDTIME;
					var HOSTTHUMBNAIL = "../" + obj.HOSTTHUMB;
					var STREAMHOSTHOST = obj.STRHOST;
					var STREAMHOSTID = obj.HOSTID;
					var STREAMHOSTHOSTTOTALSHOUTS = obj.TOTALSHOUTS;
					var STREAMHOSTHOSTUSERSHOUT = obj.USERSHOUT;

					if (STREAMHOSTHOST == "show") {
						
						$('#total_shouts').html(STREAMHOSTHOSTTOTALSHOUTS); // set total shouts of streaming host
						
						var hidden_host = $('#hidden_host_val').val();
						
						if (hidden_host !== SHOWHOSTNAME){
							//alert('11');
								var end = new Date(HOSTENDTIME);
								
									var _second = 1000;
									var _minute = _second * 60;
									var _hour = _minute * 60;
									var _day = _hour * 24;
									var timer;
						
									timer = setInterval(function(){

									var now = new Date();
										var distance = end - now;
										if (distance < 0) {
								
											clearInterval(timer);
											//document.getElementById("timer_battle").innerHTML = "";
											$("#MyyIDD").html("");
											//document.getElementById('countdown').innerHTML = 'EXPIRED!';
								
											return;
										}
										var days = Math.floor(distance / _day);
										var hours = Math.floor((distance % _day) / _hour);
										var minutes = Math.floor((distance % _hour) / _minute);
										var seconds = Math.floor((distance % _minute) / _second);
										
										//document.getElementById("timer_battle").innerHTML = "(Streaming ends in " + hours + " hrs " + minutes + " mins " + seconds + " secs )";
										$("#MyyIDD").html("(" + hours + " hrs " + minutes + " mins " + seconds + " secs)");
										
										},1000);								
													
						
													var host_str_data = "<input type='hidden' id='hidden_host_val' value='"+SHOWHOSTNAME+"'><object width='100%' height='460'><param name='movie' value='live_video.swf?n="+SHOWHOSTNAME+"'><param name='scale' value='noborder'><param name='salign' value='lt'><param name='allowFullScreen' value='true'><param name='allowscriptaccess' value='always'><embed width='100%' height='460' scale='noborder' salign='lt' src='live_video.swf?n="+SHOWHOSTNAME+"' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true'></object>";					
													$("#custom_str").html("");
													$("#custom_str").html(host_str_data);
													$("#inner_shout_html").html(STREAMHOSTHOSTUSERSHOUT);
													
										document.getElementById('host_img_set').innerHTML = '<img src='+HOSTTHUMBNAIL+'>';
										var newStr = SHOWHOSTNAME.replace(/-/g, " ");
										
										$('#host_name_set').html(newStr);													
													
						}
						
					}
					 
					if (SHOWADS == "show") {
						
						// No one streaming show dummy host i.e. mysitti
						
						$('#total_shouts').html(STREAMHOSTHOSTTOTALSHOUTS); // set total shouts of streaming host
						
						var hidden_host = $('#hidden_host_val').val();
						
						if (hidden_host !== SHOWHOSTNAME){
						
								var host_str_data = "<input type='hidden' id='hidden_host_val' value='"+SHOWHOSTNAME+"'><object width='100%' height='460'><param name='movie' value='live_video.swf?n="+SHOWHOSTNAME+"'><param name='scale' value='noborder'><param name='salign' value='lt'><param name='allowFullScreen' value='true'><param name='allowscriptaccess' value='always'><embed width='100%' height='460' scale='noborder' salign='lt' src='live_video.swf?n="+SHOWHOSTNAME+"' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true'></object>";
								
								$("#custom_str").html("");
								$("#custom_str").html(host_str_data);
								

								$("#inner_shout_html").html(STREAMHOSTHOSTUSERSHOUT);
						
							}

								$('#host_img_set').empty();
								$('#host_name_set').empty();
								
								$('#host_img_set').html('<img src='+HOSTTHUMBNAIL+'>');
								$('#host_name_set').html(SHOWHOSTNAME);
								
					}
					
					if (SHOWHOSTADS == "show") { // When host time comes up and he's not streaming
						
						$('#total_shouts').html(STREAMHOSTHOSTTOTALSHOUTS); // set total shouts of streaming host
					
						var hidden_host = $('#hidden_host_val').val();
						
						if (hidden_host !== SHOWHOSTNAME){
							
								var host_str_data = "<input type='hidden' id='hidden_host_val' value='"+SHOWHOSTNAME+"'><object width='100%' height='460'><param name='movie' value='live_video.swf?n="+SHOWHOSTNAME+"'><param name='scale' value='noborder'><param name='salign' value='lt'><param name='allowFullScreen' value='true'><param name='allowscriptaccess' value='always'><embed width='100%' height='460' scale='noborder' salign='lt' src='live_video.swf?n="+SHOWHOSTNAME+"' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true'></object>";							
							$("#custom_str").html("");
							$("#custom_str").html(host_str_data);
							

							$("#inner_shout_html").html(STREAMHOSTHOSTUSERSHOUT);
								
							$("#host_img_set").addClass("hostadsimage");

							$(".hostadsimage").html("<img src="+HOSTTHUMBNAIL+">");

							
							$("#host_name_set").addClass("hostadsname");
							$(".hostadsname").html(SHOWHOSTNAME);
													
						}

							
						
												
						
					}
					
			 });
		
	}, 10000);
	
	
	setInterval(function(){
		
		var data_sent = "counter";
			$.ajax({
				  type: "POST",
				  url: "battle.php",
				  data: {'total_viewers_count': 'total_viewers_count', 'contest_id' : '<?php echo $CONTESTID; ?>'}
			 }).done(function( response ) {
				
				if (response == "contest") {
					window.location.href = "";
				}else{
				
					$("#total_viewers").html(response);
				}
				
			});
		
		}, 5000);	
	
});

function add_user_shout(contest_id, from_user, from_user_type, to_user, to_user_type) {
	
	//var number = $('#total_shouts').text();
	//var addition = parseInt(number) + 1;
	//$('#total_shouts').html(addition);
	
			$.ajax({
				  type: "POST",
				  url: "battle.php",
				  data: {
						'contest_id': contest_id,
						'from_user': from_user,
						'from_user_type': from_user_type,
						'to_user': to_user,
						'to_user_type': to_user_type,
						'live_battle_shout': 'live_battle_shout'
					}
			 }).done(function( jsondata ) {
				
				var json = jsondata, obj = JSON.parse(json);
				
					var RESTRICT = obj.RESTRICT;
					var TOTAL_S = obj.TOTAL_S;
					var TOTAL_S_UPPER = obj.TOTAL_S_UPPER;
				
				$('#inner_shout_html').html(RESTRICT);
				//$('#total_shouts').html(TOTAL_S);
				$('.shouts_curr_user').html(TOTAL_S_UPPER);
				
			});
}

function add_lower_shout(contest_id, from_user, from_user_type, to_user, to_user_type) {
	
			$.ajax({
				  type: "POST",
				  url: "battle.php",
				  data: {
						'contest_id': contest_id,
						'from_user': from_user,
						'from_user_type': from_user_type,
						'to_user': to_user,
						'to_user_type': to_user_type,
						'live_battle_shout_lower': 'live_battle_shout_lower'
					}
			 }).done(function( jsondata ) {
				
				var json = jsondata, obj = JSON.parse(json);
				
					var RESTRICT = obj.RESTRICT;
					var TOTAL_S = obj.TOTAL_S;
				
				$('.inner_shout_html_lower_'+to_user).html(RESTRICT);
				$('.lower_shout_count_'+to_user).html("Shouts "+TOTAL_S);
				
			});
}
</script>

<div class="home_wrapper">
  <div class="main_home_live2battle">
    <div class="home_content">
<script type="text/javascript">
	function change_src(args) {
      var player = document.getElementById('tv_main_channel');

      var mp4Vid = document.getElementById('mp4Source');

      player.pause();

      // Now simply set the 'src' attribute of the mp4Vid variable!!!!
      // (...using the jQuery library in this case)

      $(mp4Vid).attr('src', args);

      player.load();
      player.play();

	}
</script>
<?php
if(empty($CONTESTID)){
	
	$battle_videos = mysql_query("SELECT * FROM battle_playlist WHERE default_video = '1' AND user_type = 'user' AND user_id = '1'");
?>
<style>

	
</style>
<div class="home_content_bottom mbottom20">
   <div class="play_vid_current">
    <video id="tv_main_channel" width="400" controls autoplay loop>
		<?php
		$default_vid = mysql_fetch_assoc($battle_videos);
		
		if($default_vid['default_video'] == 1){ ?>
		
			<source id="mp4Source" src="<?php echo str_replace("../", "", $default_vid['video_path']); ?>" type="video/mp4">
		
		<?php }else{ ?>
		
			<source id="mp4Source" src="https://mysitti.com/upload/1428887022123de511f82d5bd8176c08e4f361fcb2MySitti_.mp4" type="video/mp4">
		
		<?php } ?>
 
  <!--<source src="https://mysitti.com/upload/1428887022123de511f82d5bd8176c08e4f361fcb2MySitti_.ogv" type="video/ogg">-->
  Your browser does not support HTML5 video.
</video>
   </div>
	<div class="thumb_list_battle newbattle">
    <?php
	$get_battle_videos = mysql_query("SELECT * FROM battle_playlist WHERE user_type = 'user' AND user_id = '1'");
	$count_battle_videos = mysql_num_rows($get_battle_videos);
	
	if($count_battle_videos < 1){
		
		echo "No video found";
		
	}else{
		
		while($b_row = mysql_fetch_assoc($get_battle_videos)){
	
			$explode_vid = explode("../video/" , $b_row['video_path']); ?>
			
			<a class="list_play" href="javascript: void(0);" onclick="change_src('<?php echo str_replace("../", "", $b_row['video_path']); ?>')"><?php echo $b_row['video_title']; ?></a>
		<?php }
	} ?>
    </div>
    
 

	

</div>

<?php } ?>
	  
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
$(".thumb_list_battle a.list_play").click(function() {
			$(".thumb_list_battle a.list_play").removeClass("active");
			$(this).addClass("active");
		});
				});
</script>
<?php include('Footer.php') ?>