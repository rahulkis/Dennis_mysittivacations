<?php 
include('Const.Inc.php');

$rand= rand(100000,999999);
$str = "
	<div  style='background-color:#97BCE5; width:auto; height:405px; padding-left:25px'>
		<div class='logo'><img src='".$base_url."images/logo1.png' border='0' /></div>
		<hr>
		<p>
			<br />
			Thanks for registering! To complete the activation of your account please click the following link:
			<br /><br />
			<a href=".$base_url."success.php?email=".$email."&code=".$rand."'>Click Here</a>			
			<br><p> Thank you so much!<br>
			<a target='_blank' href='".$base_url."index.php'> MySitti</a>
                        <br> P.O.Box 11224
			<br>Memphis, TN 38111-9997
			<br>Phone: (866) 494-2026
                        <br>Email: mysitti@mysittidev.com
			<br /><br />
			All Rights Reserved. Copyright &copy; 2013 MySitti .  
		</p>
	</div>
 ";
$message = $str;


$to  = $club_email;


$subject = "Complete Registration For My Sitti ";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";


$headers .= 'From: MySitti <info@mysittidev.com>' . "\r\n";

/*echo $message;
echo $to ;
echo $subject;
echo $headers;
exit;*/

mail($to, $subject, $message, $headers) or die;

?>