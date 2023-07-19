<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
session_start();

$_SESSION['socialtype'] = $_POST['type'];

session_write_close();


