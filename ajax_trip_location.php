 <?php 
 $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
 $location_name = $_POST["location_name"]; 
 $user_id = $_POST["user_id"];
 $trip_id = $_POST["trip_id"];
 $latitude =$_POST['latitude'];
 $longitude =$_POST['longitude'];
 $pic_url =$_POST['pic_url'];
    $sql = "INSERT INTO `trip_location` ( `user_id`,`trip_id`, `location_name`,`latitude`,`longitude`,`img_url`) VALUES ('$user_id', 
      '$trip_id',  '$location_name',  '$latitude',  '$longitude', '$pic_url')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Location has been added";
       
    }else{
      echo "OOPS..Something went wrong.";
    }
  