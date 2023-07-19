<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

// $conn = mysqli_connect("localhost", "root", "root", "book-library");

$info = json_decode(file_get_contents("php://input"));

if(count($info) > 0) {
	$name = $info->name;
	$email = $info->email;
	$age = $info->age;
	$query = "INSERT INTO userAng(name, email, age) VALUES ('$name', '$email', '$age')"; 
	if(mysql_query($query)) {
		echo "Insert Data Successfully";
	}
	else {
		echo "Failed";
	}
}
else {
	echo "zero item";
}
?>