	<?php
	$mailwizz_path = '/var/www/html/Production';
include("../depends/vendor/autoload.php");

	// print_r(get_included_files());die;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	date_default_timezone_set('UTC');

	// error_reporting(0);
	// ini_set('display_errors', 'On');
	// error_reporting(E_ALL | E_STRICT);
	$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
	require $mailwizz_path.'/mailwizz_setup.php';
	$endpoint = new MailWizzApi_Endpoint_ListSubscribers(); 
	$mailwizzList = new MailWizzApi_Endpoint_Lists();
	$mailwizzCampaign = new MailWizzApi_Endpoint_Campaigns();
	$mailwizzTemplates = new MailWizzApi_Endpoint_Templates();
	$mailwizzListFields = new MailWizzApi_Endpoint_ListFields();
	$mailwizzSubscribers = new MailWizzApi_Endpoint_ListSubscribers();

	///////////////
	// Variables //
	///////////////
	$today = date('2019-02-28 17:53:00');
	//$today = date('2019-01-16 08:00:00');

 	$campaigns = "SELECT * FROM mailwizz_lists_cron WHERE cron_status = 0 AND campaign_status = 1 AND list_updation_start_at <=  '".$today."'";
  	// echo $campaigns;
	$result = $mysqli->query($campaigns);
  	// print_r($result);
	$rows = $result->fetch_assoc();
	$template = "SELECT * FROM mailwizz_campaign WHERE id = '".$rows['campaign_id']."'";
	$tmpresult = $mysqli->query($template);
	$tmprows = $tmpresult->fetch_assoc();
	$tempdata = base64_decode($tmprows['template_slug']);
	if(!empty($rows['list_id'])){
		// chmod($mailwizz_path."/admin/mailwizz_cron.php",0644);
		$mailwizz_sub_pages = $mailwizzSubscribers->getSubscribers($rows['list_id'], $pageNumber = 1, $perPage = 100);
		// DISPLAY RESPONSE
		echo "<pre>";
		$mailwizz_sub_pages = $mailwizz_sub_pages->body->toArray();
		//print_r($mailwizz_sub_pages['data']['records']);
		$emails = array();
		foreach ($mailwizz_sub_pages['data']['records'] as $key => $value) {
		$emails[] = $value['EMAIL'];

		}
		//print_r($emails);
		$mail = new PHPMailer;
		//Enable SMTP debugging. 
		$mail->SMTPDebug = 3;                               
		//Set PHPMailer to use SMTP.
		$mail->isSMTP();            
		//Set SMTP host name                          
		$mail->Host = "smtp.mail.us-east-1.awsapps.com";
		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;                          
		//Provide username and password     
		$mail->Username = "happy@mysittivacations.com";                 
		$mail->Password = "MySitt@123#";                           
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "ssl";                           
		//Set TCP port to connect to 
		$mail->Port = 465;                                   

		$mail->From = "happy@mysittivacations.com";
		$mail->FromName = "MySitti";
		$nb = count($emails);
		$mail->addAddress('ankuchauhan68@gmail.com', "Mysitti");

		$mail->isHTML(true);

		$str= $tempdata;
		$mail->Subject = "smtp test";
		$mail->Body = $str;
		$mail->AltBody = "This is the plain text version of the email content";

		if(!$mail->send()) 
		{
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
			echo "Message has been sent successfully";
		}
	}
