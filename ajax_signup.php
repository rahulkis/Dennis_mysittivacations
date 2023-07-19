 <?php 
/* ob_start("ob_gzhandler");
 include("Query.Inc.php");
 $Obj = new Query($DBName);*/
 session_start();
 $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
 $fname = $_POST["f_name"]; 
 $lname = $_POST["l_name"]; 
 $email = $_POST["email"]; 
 $password = $_POST["password"];
 $sql = "Select * from user where email='$email'";

 $result = mysqli_query($conn, $sql);

 $num = mysqli_num_rows($result); 
 if($email!='' && $password!='' && $lname!='' && $fname!=''){
  if($num == 0) {
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $sql = "INSERT INTO `user` ( `first_name`,`last_name`, `email`,`password`) VALUES ('$fname', 
      '$lname',  '$email',  '$hash')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "User created successfully.";
       $_SESSION['username'] = $email;
    }else{
      echo "OOPS..Something went wrong.";
    }
  } else{
    echo "User already exist";
  }
}else{
  echo "Please fill all the fields.";
}