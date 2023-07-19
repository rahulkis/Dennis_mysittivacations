<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$email = $_POST['email'];

$checkemail = @mysql_query("SELECT email FROM `user_subscriber_email` WHERE `email` = '".$email."' ");

$emailData = @mysql_fetch_array($checkemail);

$userEmail = $emailData['email'];

if($userEmail ==$email ){


$str = "
	<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
		<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
		<hr>
		<p style='color: white;'>
			<br />
Welcome to mysitti.com! You are now a part of the next social revolution.
<br />Sign in today and <b> MAKING EVERY CITY YOUR CITY! </b>
			<br /><br />
				Here is your account information on '".$base_url."' <br>
				Username: ".$email."<br>
				Click the link below to see how easily you can start streaming your own events, watching live streaming, and share your experience with friends.<br>
				<a style='color: #FECD07;' target='_blank' href='".$base_url."support.php'>Get Started</a>
			<br /><br />
		</p>";

		$str .= "<p style='color: white;'> Thank you,<br><br>
			<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> mysitti.com </a>
		    </p>
	</div>
 ";

$message = $str; 
$to  = $email;

$subject = "Welcome to mysitti.com";
$message = $str;
//$from = "info@mysitti.com";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
//$headers .= "From:" . $from;

mail($to,$subject,$message,$headers,"-finfo@mysitti.com");


}else{
$sql = "INSERT INTO user_subscriber_email(email)VALUES('".$email."')"; 

$result = mysql_query($sql);


$str = "
	<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
		<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
		<hr>
		<p style='color: white;'>
			<br />
Welcome to mysitti.com! You are now a part of the next social revolution.
<br />Sign in today and <b> MAKING EVERY CITY YOUR CITY! </b>
			<br /><br />
				Here is your account information on '".$base_url."' <br>
				Username: ".$email."<br>
				Click the link below to see how easily you can start streaming your own events, watching live streaming, and share your experience with friends.<br>
				<a style='color: #FECD07;' target='_blank' href='".$base_url."support.php'>Get Started</a>
			<br /><br />
		</p>";

		$str .= "<p style='color: white;'> Thank you,<br><br>
			<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> mysitti.com </a>
		    </p>
	</div>
 ";

$message = $str; 
$to  = $email;

$subject = "Welcome to mysitti.com";
$message = $str;
//$from = "info@mysitti.com";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
//$headers .= "From:" . $from;

mail($to,$subject,$message,$headers,"-finfo@mysitti.com");
	
}


    
  
?>
     
