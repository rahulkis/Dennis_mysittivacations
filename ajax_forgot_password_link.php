 <?php 
 $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
 $email = $_POST["email"]; 
 $pass = $_POST["pass"]; 
 $re_pass = $_POST["re_pass"]; 
 $sql = "Select * from user where email='$email'";

 $result = mysqli_query($conn, $sql);

 $num = mysqli_num_rows($result); 
 if($email!='' && $pass!='' && $re_pass!=''){

   if($pass == $re_pass){
   
  
  if($num == 0) {
    echo "No user is registered with this email address!";
  }else{
   $hash = password_hash($pass,PASSWORD_DEFAULT);
   $sql =  "UPDATE `user` SET password='$hash' where email='".$email."'";
   $result = mysqli_query($conn, $sql);
    if ($result) {
      echo "Password Updated successfully.";
    }
 }
}else{
   echo "Password Not Matched. Please re-enter Password";
}
}else{
  echo "Please fill all the fields.";
}