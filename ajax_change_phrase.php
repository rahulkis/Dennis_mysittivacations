<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$location = $_POST['formatted'];


     echo  $html = "<h4 class='letustell' style='color: black;'>Let us tell you about ".$location."</h4>";
   
	 	
?>