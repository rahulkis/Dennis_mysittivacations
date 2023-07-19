<?php

/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); } 
if ($_GET['action'] == "update") { update_web($_GET['session_id']); } 
if ($_GET['action'] == "closechat") { closeChat(); } 
if ($_GET['action'] == "startchatsession") { startChatSession(); } 

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();	
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();	
}

function chatHeartbeat() {
	
	  $sql = "select inv.*,u.first_name,u.last_name from cam_invite as inv
    left join  user as u on(u.id=inv.created_by) where (inv.sent_to = '".mysql_real_escape_string($_SESSION['user_id'])."' AND inv.recd = 0 AND inv.sent_to!='0' AND u.is_online='1' ) order by inv.id ASC";
	$query = mysql_query($sql);
	$items = '';
	$cnt = @mysql_num_rows($query);
	$cam = @mysql_fetch_array($query);
	 if($cnt > 0)
	 {
	   echo "<div id='cam_".$cam['id']."'>
	   <div class='chatboxhead_cam'>
	<div class='chatboxtitle_cam'>You Have Web Cam Invitation Send By: ".$cam['first_name']." ".$cam['last_name']."</div>
	<div class='chatboxoptions_cam'>
	<a href='javascript:void(0)' onclick='hide(".$cam['id'].");'>X</a></div><br clear='all'></div>
	<div class='chatboxcontent_cam' id='cont_cam'><a href='camstart.php?session=".$cam['session']."&token=".$cam['token']."'> Click Here To Continue Web Cam Chat </a> </div></div>";
	  
	 }else
	 {
	  return false;
	 }
	
}

function update_web($id) {
	
	 $sql = "update cam_invite set recd='1' where session='".$id."' AND sent_to='".$_SESSION['user_id']."'";
	 $query = mysql_query($sql);
	
	
}
?>


