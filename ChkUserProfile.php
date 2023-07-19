<?
include("Query.Inc.php");
$Obj = new Query($DBName);

if(!empty($_POST))
{
	$email = $_POST['profilename']; 
	$type=$_POST['type']; 
}
else
{
	$email = $_GET['profilename']; 
	$type=$_GET['type']; 
}

$qry= "SELECT `profilename` FROM `user` WHERE `profilename` = '".$email."'";

$qry1= "SELECT `club_name` FROM `clubs` WHERE `club_name` = '".$email."'";

$result = mysql_query($qry);
$result1 = mysql_query($qry1);

if( mysql_num_rows($result1) > 0 || mysql_num_rows($result) > 0 )
{
	$response = 0;
}
else
{
 	$response =1;
}
 echo $response;

?>
