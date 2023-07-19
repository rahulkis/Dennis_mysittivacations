<?php 
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$pg="success";

$email = $_REQUEST['email'];

$ThisPageTable = 'user';
$ValueArray = array('1');
$FieldArray = array('status');
$Success = $Obj->Update_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray,'email',$email);
$Obj->Redirect("login.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Sign Up</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script src="js_validation/signup.js" type="text/javascript"></script>
</head>

<body>
<div id="main">
    <div class="container">
    <?php include('header.php') ?>
    <div id="wrapper" class="space">
       <div id="title">Registration Successful!</div>
       <div id="left">
         <div class="advertise" style="border:0px;"></div>
         <div class="advertise" style="border:0px;"></div>
       </div>
       <div id="middle" style="min-height:0; background-color:#97BCE5; width:469px;">
         <div class="login" style="padding:60px 15px 30px 15px;">
           <div class="pagetitle">Thank you</div>
			<p>Thank you for registering for  Mysitti  account.</p>
	  		<p><strong>Now you can login with your email id and password.</strong><br />
	  				<br /><br />
	  				</p>
         </div>
       </div>
       <div id="right2">
         <div class="advertise" style="border:0px;"></div>
         <div class="advertise" style="border:0px;"></div>
       </div>
       
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>