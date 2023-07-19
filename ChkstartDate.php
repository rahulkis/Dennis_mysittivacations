<?
include("../../Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_GET['c_type'])){
	
	$start_date = date("Y-m-d",strtotime($_GET['start_date'])); 
	$qry= "SELECT `contest_start` FROM `contest` WHERE contest_type = 'live' AND `contest_end` >= '".$start_date."'";
	$result = mysql_query("SELECT `contest_start` FROM `contest` WHERE contest_type = 'live' AND `contest_end` >= '".$start_date."'");
	
	if( @mysql_num_rows($result)>0)
	{
		$response = 0;
	}
	else{
		$response =1;
		echo $response;	
	}
	
}else{


$start_date = date("Y-m-d",strtotime($_GET['start_date'])); 
$qry= "SELECT `contest_start` FROM `contest` WHERE `contest_end` >= '".$start_date."'";
$result = mysql_query("SELECT `contest_start` FROM `contest` WHERE `contest_end` >= '".$start_date."'");

	if( @mysql_num_rows($result)>0)
	{
		$response = 0;
	}
	else{
		$response =1;
		echo $response;
	}
}
?>