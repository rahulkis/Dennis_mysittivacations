<?php
header('Access-Control-Allow-Origin: *');
include 'Query.Inc.php';
require_once __DIR__ . "/depends/vendor/autoload.php";
$Obj = new Query($DBName);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer;
	$today = date("Y-m-d h:i:s");
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	// $fname=$_POST['fname'];
	$enquiry=$_POST['enquiry'];

		$ValueArray = array($fname,$lname,$email,$enquiry,$today);
		$FieldArray = array('fname','lname','email','enquiry','adde_on');
		$ThisPageTable='contact_us';		
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		if($Success > 0)
		{
			$mail->SMTPDebug = 3;                               
			//Set PHPMailer to use SMTP.
			$mail->isSMTP();            
			//Set SMTP host name                          
			$mail->Host = "smtp.mail.us-east-1.awsapps.com";
			//Set this to true if SMTP host requires authentication to send email
			$mail->SMTPAuth = true;                          
			//Provide username and password     
			$mail->Username = "vacations@mysittivacations.com";                 
			$mail->Password = "VaSuPp0RT_L0G!NN";                           
			//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "ssl";                           
			//Set TCP port to connect to 
			$mail->Port = 465;                                   

			$mail->From = $email;
			$mail->FromName = $fname.' '.$lname ;

			$mail->addAddress('vacations@mysittivacations.com', "MysittiVacations");

			$mail->isHTML(true);
			$subject = "New Enquiry";

			$message = "
			<html>
			<head>
			<title>Enquiry</title>
			</head>
			<body>
			<h1>Enquiry Details</h1>
			<table>
			<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Email</th>
			<th>Enquiry</th>
			</tr>
			<tr>
			<td>".$fname."</td>
			<td>".$lname."</td>
			<td>".$email."</td>
			<td>".$enquiry."</td>
			</tr>
			</table>
			</body>
			</html>
			";
			$mail->Subject = "New Enquiry";
			$mail->Body = $message;

			$mail->send();
		
		}

