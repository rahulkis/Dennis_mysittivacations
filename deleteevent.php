<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];
$year = $_GET['year'];
$month =$_GET['month'];
$month = date("F", mktime(0, 0, 0, $month, 10));

$_SESSION['year_Edit'] = $year;
$_SESSION['month_Edit'] = $month;

if($id!=""){
 
 $sql="delete from events where id = '".$id."'";
 mysql_query($sql);

mysql_query("DELETE FROM `forum` WHERE `event_id` = '$id'");
mysql_query("DELETE FROM `dj_confirmation` WHERE `event_id` = '$id'");

$paid_pass_query = mysql_query("SELECT pass_id FROM paid_passes WHERE event_id = '".$id."'");
$pass_id = mysql_fetch_assoc($paid_pass_query);

$dpaid_pass_query = mysql_query("SELECT pd_id FROM paid_pass_download WHERE pass_id = '".$pass_id['pass_id']."'");
while($dpass_id = mysql_fetch_assoc($dpaid_pass_query)){
 
	$shared_ticket_id = "shared_ticket_".$dpass_id['pd_id'];
	mysql_query("DELETE FROM `user_notification` WHERE `common_identifier` = '".$shared_ticket_id."'");
 
}

mysql_query("DELETE FROM paid_pass_download WHERE pass_id = '".$pass_id['pass_id']."'");
mysql_query("DELETE FROM paid_passes WHERE event_id = '".$id."'");

	$shared_formid = "events_forum_".$id;
	mysql_query("DELETE FROM `user_notification` WHERE `common_identifier` = '".$shared_formid."'");

  $_SESSION['eventdeleted']="yes";
// header('Location:listevent.php');

}

?>
