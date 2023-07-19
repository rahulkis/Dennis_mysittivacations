<?php
ob_start();
include("Query.Inc.php");
$Obj = new Query($DBName);

session_start();

// echo "<pre>"; print_r($_SESSION); exit;

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(0);
$n=$_GET["n"];

$o_watch_tkn="";

if( isset($_GET['host_id']) && isset($_GET['user_type']) ){
	$_SESSION['watch_tkn']="_".$_GET['host_id']."_".$_GET['user_type'];
	echo $o_watch_tkn = $userID."_".$userType."_".$_GET['host_id']."_".$_GET['user_type'];
}
?>
<script src="../lightbox/js/jquery-1.7.2.min.js"></script>
<div id="main" class="channel_bg">
<div class="channer_container">
<div class="channel_inner">
<div style="display:none";>
<?php 
/* added by kbihm on feb 25,2015 */
include("flash_detect.php") 
?>
</div>
<style>
#strm-payment-button{
display: none;
color: #fecd07;
float: left;
font-family: arial;
text-align: center;
text-decoration: none;
width: 98%;
margin: auto;
border: 1px solid #fecd07;
background-color: #111;
padding: 10px 0; 
position: absolute;
left: 50%;
top: 50%;
box-sizing:border-box;
-moz-box-sizing:border-box;
-webkit-box-sizing:border-box;
-webkit-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);

}
.redeemt{
display: none;
color: #fecd07;
float: left;
font-family: arial;
text-align: center;
text-decoration: none;
width: 70%;
margin: auto;
border: 1px solid #fecd07;
background-color: #111;
padding: 10px 0; 
position: absolute;
left: 50%;
top: 50%;
box-sizing:border-box;
-moz-box-sizing:border-box;
-webkit-box-sizing:border-box;
-webkit-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);

}
.redeemt a{text-decoration:none;color: #fecd07;}
.button {
background: rgba(0, 0, 0, 0) none repeat scroll 0 0;padding: 10px;	border: 1px solid #fecd07;
}

</style> 
<div id="wrapper" class="space">

<?php
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
/* detect_stream added by kbimn on 30-01-2015 */

/* code by kbihm code 19-01-2015
* Code to redirect to differnt url acc. to device 
* */

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() {

global $user_agent;

$os_platform = "Unknown OS Platform";

$os_array = array(
'/windows nt 6.3/i' => 'Windows 8.1',
'/windows nt 6.2/i' => 'Windows 8',
'/windows nt 6.1/i' => 'Windows 7',
'/windows nt 6.0/i' => 'Windows Vista',
'/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
'/windows nt 5.1/i' => 'Windows XP',
'/windows xp/i' => 'Windows XP',
'/windows nt 5.0/i' => 'Windows 2000',
'/windows me/i' => 'Windows ME',
'/win98/i' => 'Windows 98',
'/win95/i' => 'Windows 95',
'/win16/i' => 'Windows 3.11',
'/macintosh|mac os x/i' => 'Mac OS X',
'/mac_powerpc/i' => 'Mac OS 9',
'/linux/i' => 'Linux',
'/ubuntu/i' => 'Ubuntu',
'/iphone/i' => 'iPhone',
'/ipod/i' => 'iPod',
'/ipad/i' => 'iPad',
'/android/i' => 'Android',
'/blackberry/i' => 'BlackBerry',
'/webos/i' => 'Mobile'
);

foreach ($os_array as $regex => $value) { 

if (preg_match($regex, $user_agent)) {
$os_platform = $value;
}

} 

return $os_platform;

}

function getBrowser() {

global $user_agent;

$browser = "Unknown Browser";

$browser_array = array(
'/msie/i' => 'Internet Explorer',
'/firefox/i' => 'Firefox',
'/safari/i' => 'Safari',
'/chrome/i' => 'Chrome',
'/opera/i' => 'Opera',
'/netscape/i' => 'Netscape',
'/maxthon/i' => 'Maxthon',
'/konqueror/i' => 'Konqueror',
'/mobile/i' => 'Handheld Browser'
);

foreach ($browser_array as $regex => $value) { 

if (preg_match($regex, $user_agent)) {
$browser = $value;
}

}

return $browser;

}

$user_os = getOS();
$user_browser = getBrowser();

	if($user_os=="Mac OS X" || $user_os=="Mac OS 9"){
				if($user_browser=="Safari"){
					ob_end_clean();
					header("Location: https://192.163.248.47:1935/live/".$_GET['n']."/playlist.m3u8");	
					//header("Location: channel2.php?n=".$_GET['n']."&tkn=".$o_watch_tkn);	
					exit;
				}
			}
			else if($user_os=="iPad"){
				ob_end_clean();
				header("Location: channel2.php?n=".$_GET['n']."&tkn=".$o_watch_tkn);	
				exit;
			}
			else if($user_os=="iPod" || $user_os=="iPhone"){
				ob_end_clean();
				//header("Location: channel2.php?n=".$_GET['n']."&tkn=".$o_watch_tkn);	
				header("Location: https://192.163.248.47:1935/live/".$_GET['n']."/playlist.m3u8");	
				exit;
			}
			elseif($user_os=="Android" || $user_os=="BlackBerry" || $user_os=="Mobile"){
				ob_end_clean();
				 header("Location: rtsp://192.163.248.47:1935/live/".$_GET['n']."_360p?".$o_watch_tkn);	
				//header("Location: rtsp://54.174.85.75:1935/httplive/".$_GET['n']."_360p?".$o_watch_tkn);
				exit;
			}


/* kbihm code end */


$subusers_query = mysql_query("SELECT * FROM hostsubusers WHERE host_id = '".$_GET['host_id']."'");
while($get_subusers_row = mysql_fetch_assoc($subusers_query)){

	$n = $get_subusers_row['username'];

// echo "SELECT * FROM `chat_groups` WHERE `group_name` = '$n' ";
$getgroupinfo = mysql_query("SELECT * FROM `chat_groups` WHERE `group_name` = '$n' ");
$fetchGroup = mysql_fetch_array($getgroupinfo);
if(mysql_num_rows($getgroupinfo) > 0)
{
	$groupID = $fetchGroup['id'];

	$CountUser = mysql_query("SELECT `id` FROM `chat_users_groups` WHERE `group_id` = '$groupID' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' ");
	if(mysql_num_rows($CountUser) < 1 )
	{
	mysql_query("INSERT INTO `chat_users_groups` (`group_id`,`user_id`,`user_type`,`loggedin`) VALUES ('$groupID','$_SESSION[user_id]','$_SESSION[user_type]','1') ");
	}
}

//$swfurl="live_watch.swf?n=".urlencode($n);
$swfurl="live_video.swf?n=".urlencode($n);
$scale="noborder";
?> 

		<div id="middle" class="webcame_live" style="height:380px;">
			<div class="boject_container" style="width:100%; max-width:660px; margin:auto;">
				<div class="innerObjectContainer">
					<?php if(detect_stream($n)===true){ ?>
					<object width="660" height="360">
					<param name="movie" value="<?=$swfurl?>">
					</param>
					<param name="scale" value="<?=$scale?>" />
					<param name="salign" value="lt">
					</param>
					<param name="allowFullScreen" value="true">
					</param>
					<param name="allowscriptaccess" value="always">
					</param>
					<embed width="100%" height="360" scale="<?=$scale?>" salign="lt" src="<?=$swfurl?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
					</object>
		
					<?php } else{ ?>
					<span style="color:red;font-size:15px;font-weight:bold;">Channel Offline</span> 
					<?php } ?>
				</div>
			</div>
		</br>
		</div>
<?php } ?>
</div>
</div>

<script type="text/javascript">
	function count_vote(id,type,contid)
	{
		jQuery.get('../vote.php?c_id='+id+'&type='+type+'&contid='+contid, function(data) {
		//$('#'+type+'_'+id).html(data);
		jQuery('#yesnolikes_'+id).html(data);
		jQuery('.s_shout_' + id + ' a').replaceWith(data+"<span><img src='../images/s_like.png' alt='' /></span>");
		});
	}
</script>