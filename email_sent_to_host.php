<?php 
include('Const.Inc.php');
/*
	Send email to activation account.
*/
$rand= rand(100000,999999);

$str = "
	<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
		<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
		<hr>
		<p style='color: white;'>
			<br />
Welcome to mysittidev.com! You are now a part of the next social revolution.
<br />Sign in today and <b> MAKING EVERY CITY YOUR CITY! </b>
			<br /><br />
				Here is your account information on '".$base_url."' <br>
				Username: ".$club_email."<br>
				Password: ".$password."<br>
				Click the link below to see how easily you can start streaming your own events, watching live streaming, and share your experience with friends.<br>
				<a style='color: #FECD07;' target='_blank' href='".$base_url."support.php'>Get Started</a>
			<br /><br />
		</p>";
		if($getPlan != 'host_free')
		{	
			$str .= "<p style='color: white;'>
				<b>To broadcast from external encoder like Adobe Flash Media Live Encoder</b><br />
				FMS Url : rtmp://192.163.248.47/live?usr=".$club_email."&amp;pwd=".$club_pass."<br />
				Stream : ".$name_club."
			</p>";
		}

			$str .= "<p style='color: white;'> Thank you,<br><br>
			<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> mysittidev.com </a>
		    </p>
	</div>
 ";

$message = $str; 
$to  = $club_email;

$subject = "Welcome to mysittidev.com";
$message = $str;
//$from = "info@mysittidev.com";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MySitti <mysitti@mysittidev.com>' . "\r\n";
//$headers .= "From:" . $from;

mail($to,$subject,$message,$headers,"-finfo@mysittidev.com");
//echo "test Mail Sent.";
?> 
