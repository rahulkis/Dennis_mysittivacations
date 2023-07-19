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
			<br />
			It is Awesome site Please have a look once 
			<a href='".$base_url."'>".$base_url."
		</p>
	</div>
 ";
$str = "
<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%;'>
	<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
		<hr>
	<p style='color: white;'>Hello ".$_POST['invite_message'].", </p>
	<p style='color: white;'>You have been invited by ".$_SESSION['username']." to join our MYSITTI.COM. To join, please follow the link below .</p>
	<a style='color: white;font-size:16px;' href='".$base_url."'>".$base_url."</a>
	
	<p>	
	<div style='margin-top:15px;'>
	<p style='color: white;'>
	Best Regards,</br>
       MYSITTI Administration </p></p>
       </div>
	</div>
 ";
$message = $str; 
$to  = $_POST['invite_emails'];


$subject = "You have received an invitation to join our MYSITTI.COM!";
$message = $str;
//$from = "info@mysitti.com";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: MySitti <jasonwalker.bwd@gmail.com>' . "\r\n";
//$headers .= "From:" . $from;

//mail($to,$subject,$message,$headers,"-finfo@mysitti.com")
//echo  "asfd".$message['success']="Invitation Sent to your friend";die;


if(@mail($to,$subject,$message,$headers,"-finfo@mysitti.com"))
{
	echo '<div id="successmessage" style="display: block;" class="message" >Mail Sent Successfully</div>';

}else{
	echo '<div id="errormessage" class="message" style="display: block;" >Mail Not Sent,Please try again later</div>';
  
}



?> 
