<?php

if(!session_id()){
    session_start();
}
$userFbData=$_SESSION['userData']

$first_name=$userFbData['first_name'];
$last_name=$userFbData['last_name'];
$gender=$userFbData['gender']
$email=$userFbData['email']
?> <?php

include('facebook-login/facebook-login-setup.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>Simple Way to Integarate Facebook Login in PHP</title>
</head>
<body>
<div class="container">
    
   <h1>Welcome to dashboard</h1>
</div>
</body>
</html>