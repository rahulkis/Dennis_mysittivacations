<?php 
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];

$sql =  "UPDATE `trip` SET note_title='', note_description='' where user_id='".$user_id."' AND id='".$trip_id."'";
$result = mysqli_query($conn, $sql);
if($result){
	echo "Details Updated";
}