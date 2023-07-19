<?php 
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$trip_name = $_POST['trip_name'];
$trip_desc = $_POST['trip_desc'];
$sql =  "UPDATE `trip` SET trip_name='$trip_name', trip_description='$trip_desc' where user_id='".$user_id."' AND id='".$trip_id."'";
$result = mysqli_query($conn, $sql);
if($result){
	echo "Details Updated";
}