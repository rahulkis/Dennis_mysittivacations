<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$_SESSION['lat']=$_GET['lat'];
$_SESSION['long']=$_GET['long'];
?>