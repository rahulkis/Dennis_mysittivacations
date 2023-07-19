<?php 
include('Const.Inc.php');
/*
	Send email to activation account.
*/
$rand= rand(100000,999999);

$str = "
	<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%;'>
		<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
		<hr>
		<p style='color: white;'>
			<br />".$msgx."<br /><br />
			<br><p style='color: white;'> Thank you so much!<br>
			<a style='color: #FECD07;' target='_blank' href='".$base_url."index.php'> mySitti.com </a>
			<br> P.O.Box 11224
			<br>Memphis, TN 38111-9997
			<br>Phone: (866) 494-2026
                        <br>Email: mysitti@mysitti.com
			<br /><br />
			All Rights Reserved. Copyright &copy; 2013 MySitti .  
		</p>
	</div>
 ";

$message = $str; 
$to  = $email;
// $to  = "sumit.manchanda@kindlebit.com";


$subject = "Order Status";
$message = $str;
//$from = "info@mysitti.com";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
//$headers .= "From:" . $from;

mail($to,$subject,$message,$headers,"-finfo@mysitti.com");

?> 
