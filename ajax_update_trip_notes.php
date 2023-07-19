<?php 
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$note_name = $_POST['note_name'];
$note_description = $_POST['note_description'];
$sql =  "UPDATE `trip` SET note_title='$note_name', note_description='$note_description' where user_id='".$user_id."' AND id='".$trip_id."'";
$result = mysqli_query($conn, $sql);
if($result){
	echo "Details Updated";
}