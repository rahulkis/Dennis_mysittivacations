<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

// echo "<pre>"; print_r($_SESSION); exit;

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("index.php?error=yes"); die;
}


if(isset($_SESSION['subuser']))
{
	$Obj->Redirect('musicrequestList.php');
	die;
}


$fetmetaquery = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
$fetchmetacontent = @mysql_fetch_array($fetmetaquery);
$countinfo = @mysql_num_rows($fetmetaquery);

if($countinfo > 0)
{
  	$image = $fetchmetacontent['image'];
  	$description = $fetchmetacontent['description'];
}
else
{
  	$image = "images/mySittiLogo.jpg";
  	$description = "Making Every City Your City";
}

$titleofpage=" Club Home";




// include('HostHeaderLogin.php');

