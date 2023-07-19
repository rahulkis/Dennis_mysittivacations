<?php
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];

$sql = "Delete  from `trip`  where user_id='".$user_id."' AND id='".$trip_id."' ";


$result = mysqli_query($conn, $sql);

if($result){
    echo "true";
}
die;
