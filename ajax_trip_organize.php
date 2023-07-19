 <?php 
 $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
 $user_id = $_POST["user_id"];
 $trip_id = $_POST["trip_id"];
 $location_id = $_POST["location_id"];
 $location_name =$_POST['location_name'];
 $location_desc =$_POST['location_desc'];
 $trip_date =$_POST['trip_date'];
 if(  $location_name !='' &&  $location_desc!='' &&  $trip_date !='') 
 {
   $org_loc = "Select * from `trip_organize` where user_id='".$user_id."' AND trip_id='".$trip_id."' AND trip_date='".$trip_date."'  AND location_name='".$location_name."' AND location_desc='".$location_desc."'";
   $org_organize = mysqli_query($conn, $org_loc);
   $num_rows = mysqli_num_rows($org_organize);
   if( $num_rows <= 0){
    $sql = "INSERT INTO `trip_organize` ( `user_id`,`trip_id`, `location_id`,`location_name`,`location_desc`,`trip_date`) VALUES ('$user_id', 
      '$trip_id',  '$location_id', '$location_name',  '$location_desc',  '$trip_date')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Location has been added";

    }else{
      echo "OOPS..Something went wrong.";
    }
  }
}