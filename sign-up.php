<?php

// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
/////////////////////////
// File to be included //
/////////////////////////
include "Query.Inc.php";
$Obj = new Query($DBName);
require 'mailwizz_setup.php';
require_once("ActiveCampaign/includes/ActiveCampaign.class.php");
$ac = new ActiveCampaign("https://hvongphit.api-us1.com", "23ff986328c01377ce1d144a63305805104dfea34c09bec35e3c156d88d87256796633dd");
$endpoint = new MailWizzApi_Endpoint_ListSubscribers();
ob_start();


///////////////
// Variables //
///////////////
$email = trim($_POST['email']);
$trigger = $_POST['trigger'];
$data_type =  $_POST['data_type'];
$domain = $_POST['domain'];
$domainTop = $_POST['domainTop'];

///////////////
// Functions //
///////////////
function checkEmail($email) {
	$emailQuery = mysql_query("SELECT email FROM user WHERE email ='".$email."'");
	return (mysql_num_rows($emailQuery) > 0) ? 0 : 1;
}
function checkDomain($domain) {
	$domainQuery = mysql_query("SELECT name FROM domain WHERE name ='".$domain."'");
	return (mysql_num_rows($domainQuery) > 0) ? 0 : 1;
}
function checkTopDomain($domainTop) {
	$domainbreak = substr($domainTop, strpos($domainTop, ".") + 1);    
	$domaintop = mysql_query("SELECT name FROM domain WHERE name ='".'.'.$domainbreak."'");
	return (mysql_num_rows($domaintop) > 0) ? 0 : 1;
}
if ($data_type == 'customeval') {
	// echo $email;
	//print_r($_POST);
	$checkDomain = checkDomain($domain);
	echo trim($checkDomain);
	// exit;
}
if ($data_type == 'topDomain') {
	// echo $email;
	//print_r($_POST);
	$checktopDomain = checkTopDomain($domainTop);
	echo trim($checktopDomain);
	// exit;
}

if ($trigger === 'emailChecker') {
	// echo $email;
	$checkEmail = checkEmail($email);
	echo trim($checkEmail);
	// exit;
}

////////////////////////////////////////////////
// Getting address from api using lat and lng //
////////////////////////////////////////////////
if (isset($_POST['input_data'])) {
	$address_filled = json_decode($_POST['input_data'], true);
	 //print_r($address_filled['value']);
	$city = $address_filled['value']['0'];
	$state = $address_filled['value']['1'];
	$country = $address_filled['value']['2'];
	$zipcode = $address_filled['value']['3'];
	$password = $address_filled['value']['5'];
	$md5Password = md5($address_filled['value']['5']);
	if ($_POST['trigger'] === 'cancelSelected') {
		$random_key = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
		$profilename = strtok($email, '@');
		$today = date("Y-m-d h:i:s");
		//$password = strtoupper($profilename);
		$password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
		// $md5Password = password_hash($password, PASSWORD_DEFAULT);
		$md5Password = md5($password);
		$ValueArray = array($md5Password, $profilename, '', '', $email, $password, $source, '', '', '', '', '', '1', $today, $dateofbirth, '', $plan, '', '', $random_key, '');
		$FieldArray = array('password_md5', 'profilename', 'first_name', 'last_name', 'email', 'password', 'hear_about', 'phone', 'user_address', 'country', 'state', 'zipcode', 'status', 'regi_date', 'DOB', 'city', 'plantype', 'longitude', 'latitude', 'random_key', 'formatted_address');

		$Success = $Obj->Insert_Dynamic_Query('user', $ValueArray, $FieldArray);

	} else {
		$random_key = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
		$profilename = strtok($email, '@');
		$today = date("Y-m-d h:i:s");
		if(empty($address_filled['value']['5'])){
			$password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
		}else{
			$password = $address_filled['value']['5'];
		}
		$md5Password = md5($password);
		$ValueArray = array($md5Password, $profilename, '', '', $email, $password, $source, '', '', $country, $state, $zipcode, '1', $today, $dateofbirth, $city, $plan, '', '', $random_key, '');
		$FieldArray = array('password_md5', 'profilename', 'first_name', 'last_name', 'email', 'password', 'hear_about', 'phone', 'user_address', 'country', 'state', 'zipcode', 'status', 'regi_date', 'DOB', 'city', 'plantype', 'longitude', 'latitude', 'random_key', 'formatted_address');
		// print_r($ValueArray);
		$Success = $Obj->Insert_Dynamic_Query('user', $ValueArray, $FieldArray);
	}
} else {
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $_POST['lat'] . "," . $_POST['lng'] . "&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: b38c85f9-9968-4e9f-83ed-4512d47b02ec",
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$response = json_decode($response, true);
		// print_r($response['results'][0]['formatted_address']);

		////////////////////////////////////////////////////////////////////////////////////////////
		// Important Note :=> Please do not change the sequence of $address_arr. It contains      //
		// locality as city, administrative_area_level_1 as state, country as country and         //
		// postal_code as zip code. If you add new type put is at end and remember it's indexing  //
		////////////////////////////////////////////////////////////////////////////////////////////
		$address_arr = ['locality', 'administrative_area_level_1', 'country', 'postal_code'];
		$formatted_address = [];
		foreach ($address_arr as $type) {
			foreach ($response['results'][0]['address_components'] as $key => $address_component) {
				// print_r($address_component);
				if (array_search($type, $address_component['types']) !== false) {
					$postal_code = $response['results'][0]['address_components'][$key]['long_name'];
					array_push($formatted_address, $postal_code);
				}
			}
		}
		array_push($formatted_address, str_replace(', ', ',', $response['results'][0]['formatted_address']));
		// print_r($formatted_address);

	}
}
if ($_POST['trigger'] === 'showData') {
	?>
<div style="text-align: center;">	
<p><a id="cancelBtn">Skip</a> for now</p><br>
  <input type="text" name="email" placeholder="Enter Your Email" id="info-email" class="swal2-input" value="<?php echo $email; ?> "><br>
  <input type="password" name="pwd" placeholder="Enter Password " id="pwd" class="swal2-input" value=""><br>
 <input type="password" name="conf_pwd"  placeholder="Enter Confim Password "id="conf_pwd" class="swal2-input" onChange="checkPasswordMatchnav();" value=""><br>
 <input type="text" name="city"  placeholder="Your City " id="info-city" class="swal2-input" value="<?php echo $formatted_address['0']; ?>"><br>
 <input type="text" name="state" placeholder="Your State " id="info-state" class="swal2-input" value="<?php echo $formatted_address['1']; ?>"><br>
 <input type="text" name="country" placeholder="Your Country " id="info-country" class="swal2-input" value="<?php echo $formatted_address['2']; ?>"><br>
 <input type="text" name="zipcode" placeholder="Your Zip Code " id="info-zipcode" class="swal2-input" value="<?php echo $formatted_address['3']; ?>"><br>
  <input type="hidden" name="formatted_address" id="info-formattedAddr" class="swal2-input" value="<?php echo $formatted_address['4']; ?>"><br>
</div>
<?php
}
elseif ($_POST['trigger'] === 'saveToDatabase') {
	$random_key = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
	$profilename = strtok($email, '@');
	$today = date("Y-m-d h:i:s");
	
	// $md5Password = password_hash($password, PASSWORD_DEFAULT);
	
	if (isset($_POST['edit_data'])) {
		$address_filled = json_decode($_POST['edit_data'], true);
	 //print_r($address_filled['value']);
		$city = $address_filled['value']['0'];
		$state = $address_filled['value']['1'];
		$country = $address_filled['value']['2'];
		$zipcode = $address_filled['value']['3'];
		$formatted_address = $address_filled['value']['4'];
		if(empty($address_filled['value']['5'])){
			$password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
		}else{
			$password = $address_filled['value']['5'];
		}
		$md5Password = md5($password);
		$ValueArray = array($md5Password, $profilename, '', '', $email, $password, $source, '', '', $country, $state, $zipcode, '1', $today, $dateofbirth, $city, $plan, '', '', $random_key, $formatted_address);
	} else {
		$ValueArray = array($md5Password, $profilename, '', '', $email, $password, $source, '', '', $formatted_address['2'], $formatted_address['1'], $formatted_address['3'], '1', $today, $dateofbirth, $formatted_address['0'], $plan, $_POST['lat'], $_POST['lng'], $random_key, $formatted_address['4']);
	}
	$FieldArray = array('password_md5', 'profilename', 'first_name', 'last_name', 'email', 'password', 'hear_about', 'phone', 'user_address', 'country', 'state', 'zipcode', 'status', 'regi_date', 'DOB', 'city', 'plantype', 'longitude', 'latitude', 'random_key', 'formatted_address');
	// print_r($ValueArray);
	$Success = $Obj->Insert_Dynamic_Query('user', $ValueArray, $FieldArray);
} elseif ($_POST['trigger'] === 'cancelSelected') {
	$random_key = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
	$profilename = strtok($email, '@');
	$today = date("Y-m-d h:i:s");
	$password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
	//$password = strtoupper($profilename);
	// $md5Password = password_hash($password, PASSWORD_DEFAULT);
	$md5Password = md5($password);
	$ValueArray = array($md5Password, $profilename, '', '', $email, $password, $source, '', '', '', '', '', '1', $today, $dateofbirth, '', $plan, '', '', $random_key, '');
	$FieldArray = array('password_md5', 'profilename', 'first_name', 'last_name', 'email', 'password', 'hear_about', 'phone', 'user_address', 'country', 'state', 'zipcode', 'status', 'regi_date', 'DOB', 'city', 'plantype', 'longitude', 'latitude', 'random_key', 'formatted_address');
	// print_r($ValueArray);
	$Success = $Obj->Insert_Dynamic_Query('user', $ValueArray, $FieldArray);
}