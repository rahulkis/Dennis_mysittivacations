<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];

$file = $_GET['file'];
$filename = $_GET['filename'];
$filename = str_replace(' ', '_' , $filename);
header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=".$filename.".mp3;");
header("Content-Length: ".filesize($file));
readfile($file);
exit;