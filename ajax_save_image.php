<?php 
$url = $_POST['pic_url'];
$location_name = $_POST['location_name'];
 $location_name = preg_replace("/[^a-zA-Z]+/", "", $location_name); 
$date = date("Y-m-d-h-i-s");
$img_name = $location_name.$date.".jpg";

$img = '/var/www/html/Production/trip_images/'.$img_name; 
  
// Function to write image into file
file_put_contents($img, file_get_contents($url));
  
  
echo $img_path = "https://www.mysittivacations.com/trip_images/".$img_name;