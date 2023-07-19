<?
include("Query.Inc.php");
$Obj = new Query($DBName);

if(!empty($_POST))
{
	$email = $_POST['email_id']; 
	$type=$_POST['type']; 
}
else
{
	$email = $_GET['email_id']; 
	$type=$_GET['type']; 
}

$qry= "SELECT `email` FROM `user` WHERE `email` = '".$email."'";

$qry1= "SELECT `club_email` FROM `clubs` WHERE `club_email` = '".$email."'";

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
