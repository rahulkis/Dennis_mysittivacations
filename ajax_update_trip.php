<?php 
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$sql =  "UPDATE `trip` SET trip_start_date='$start_date', trip_end_date='$end_date' where user_id='".$user_id."' AND id='".$trip_id."'";
$result = mysqli_query($conn, $sql);
if($result){
	echo "Date Updated";
}