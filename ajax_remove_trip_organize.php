<?php 
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$location_id = $_POST["location_id"];
$location_name =$_POST['location_name'];
$location_desc =$_POST['location_desc'];
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$trip_date = $_POST['trip_date'];
echo $sql =  "Delete from `trip_organize` where user_id='".$user_id."' AND trip_id='".$trip_id."' AND trip_date='".$trip_date."' AND location_name='".$location_name."' AND location_desc='".$location_desc."'";
$result = mysqli_query($conn, $sql);
if($result){
	echo "Date Deleted";
}