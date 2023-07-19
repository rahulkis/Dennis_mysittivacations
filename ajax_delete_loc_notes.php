<?php 
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$location_id = $_POST['location_id'];

$sql =  "UPDATE `trip_location` SET notes='' where user_id='".$user_id."' AND trip_id='".$trip_id."' AND id='".$location_id."' ";
$result = mysqli_query($conn, $sql);
if($result){
	echo "Notes Deleted";
}