<?php
header('Access-Control-Allow-Origin: *');
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
$email = $_POST['email'];
$password = $_POST['password'];
$captcha = $_POST['captcha'];
$captchahid = $_POST['captchahid'];
$today = date("Y-m-d h:i:s");
if($captcha == $captchahid){
	$checkEmail = "select id from user where email = '".$email."'";
	$resEmail = $mysqli->query($checkEmail);
	$count = $resEmail->num_rows;
	
	if($count > 0){
		echo "exist";
		die();
	}

	$url = 'https://us20.api.mailchimp.com/3.0/lists/0e669ac09b/members/';
  $pfb_data = array(
    'email_address' =>$email,
    'status'        => 'subscribed',
  );

  // Encode the data
  $encoded_pfb_data = json_encode($pfb_data);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERPWD, 'user:917e3679b24102a3a902bc3246e60492-us20');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_pfb_data);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $results = curl_exec($ch); // store response
  $response = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get HTTP CODE
  $errors = curl_error($ch); // store errors
  curl_close($ch);

	$random_key= substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
	$profilenameArray = explode('@', $email);
	$profilename = $profilenameArray[0];
 $randon_deals = "INSERT INTO user(club_pass,street,isd_code,is_online,about_yourself ,logged_date,IsAdmin,text_status,keepmelogin,reminderhours,default_category,sms_carrier,streamingCounter,streamingLaunchFrom,profile_count,user_timezone,hideaddress,newStreamUrl,appUserId,auth_token,appPassword,streamTitle,password_md5,profilename,first_name, last_name, email, password, hear_about, phone, user_address, country, state, zipcode, status, regi_date, DOB,city, plantype, longitude,latitude, random_key, formatted_address) VALUES ('NULL','NULL','0','0','NULL' ,'".$today."','0','0','0','0','0','0','0','0','0','NULL','0','NULL','0','0','0','null','".md5($password)."', '".$profilename."', '', '', '".$email."', '".$password."', 'NULL', '', '', '', '', '', '1', '".$today."', '".$today."', '', 'free', '','', '".$random_key."','')";
	$result = $mysqli->query($randon_deals);
}else{
	echo "captchaInvalid";
}

