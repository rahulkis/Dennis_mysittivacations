<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if($_REQUEST['forum_id'])
{
	$getrs="select id from report_abuse where reported_by='".$_SESSION['user_id']."' AND forum_id='".$_REQUEST['forum_id']."'";
	$rs=mysql_query($getrs);
	$rep_check=@mysql_num_rows($rs);

	if($rep_check > 0)
	{
		echo "false";
	}else
	{
		$c_date=date('Y-m-d');
		$ValueArray = array($_REQUEST['forum_id'],$_SESSION['user_id'],$c_date);
		$FieldArray = array('forum_id','reported_by','date_report');
		$Success = $Obj->Insert_Dynamic_Query("report_abuse",$ValueArray,$FieldArray);
		echo "true";
	}
	
} 
?>