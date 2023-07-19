<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

// if(isset($_GET['host_id']))
// {
	include('LoginHeader.php');
// }
// else
// {
// 	include('HeaderHost.php');	
// }


include('Footer.php');
?>