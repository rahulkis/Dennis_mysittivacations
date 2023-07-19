 <?php 
/* ob_start("ob_gzhandler");
 include("Query.Inc.php");
 $Obj = new Query($DBName);*/
 $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
 session_start();
$trip_visibility = $_POST["trip_visibility"]; 
$trip_name = $_POST["trip_name"];
$email = $_SESSION['username'];
$sql = "Select * from user where email='$email'";
$create_date =  date('Y-m-d H:i:s');
 $result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
 $id = $row[0];
 if($trip_name!=''){
  
    $sql = "INSERT INTO `trip` ( `trip_name`,`trip_visibility`, `user_id`,`create_date`, `update_date`) VALUES ('$trip_name', 
      '$trip_visibility',  '$id','$create_date', '$create_date')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "Trip created successfully.";
     
    }else{
      echo "OOPS..Something went wrong.";
    }
  } else{
  echo "Please fill all the fields.";
}