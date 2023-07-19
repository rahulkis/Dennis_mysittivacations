<?php
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$location_id = $_POST['location_id'];
$trip_sql = "Select * from trip_organize  where location_id='".$location_id."' AND user_id='".$user_id."' AND trip_id='".$trip_id."'";
$trip_result = mysqli_query($conn, $trip_sql);
$num_rows = mysqli_num_rows($trip_result);
if($num_rows > 1){
$sql = "Delete  from `trip_organize`  where location_id='".$location_id."' AND user_id='".$user_id."' AND trip_id='".$trip_id."' order by id desc limit 1";
}else{
$sql = "Delete  from `trip_location`  where id='".$location_id."' AND user_id='".$user_id."' AND trip_id='".$trip_id."' order by id desc limit 1";
$sql2 = "Delete  from `trip_organize`  where location_id='".$location_id."' AND user_id='".$user_id."' AND trip_id='".$trip_id."' order by id desc limit 1";
}
$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);
if($result){
    echo "true";
}
die;
