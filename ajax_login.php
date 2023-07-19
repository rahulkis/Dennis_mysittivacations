<?php 
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$email = $_POST["email"]; 
$password = $_POST["password"];
$hash = password_hash($password,PASSWORD_DEFAULT);
$verify =  password_verify($password, $hash);
if($email!='' && $password!='' ){
 if ($verify) {
   $sql = "Select * from user where email='$email'";

   $result = mysqli_query($conn, $sql);

   $num = mysqli_num_rows($result); 

   if($num == 0) {
    echo "Sorry credentials are wrong";
  }else{
    echo "Login Successfully";
    $_SESSION['username'] = $email;
  }
}else{
  echo "Password not match";
}
}else{
 echo "Please fill the both fields.";
}