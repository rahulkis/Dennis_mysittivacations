<?php


 $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");

$sql = "SELECT email FROM user limit 500";
	$result = $mysqli->query($sql);
	$count = $result->num_rows;
	$rows[] = $result->fetch_assoc();
	$i =0;
	//$email = array('Mgroos123@gmail.com','example@example.com');
	foreach ($result as $key => $value) {
$i++;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/address/validate?address='.$value['email']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_USERPWD, 'api' . ':' . 'pubkey-6873a46b5696de887ff2c6fdb0bec0c7');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$data = json_decode($result, true);
$update = "UPDATE user SET isvalid = '".$data['is_valid']."' WHERE email = '".$value['email']."'";
$result = $mysqli->query($update);
}

echo $i;

// if($data['is_valid'] == '1' && $data['mailbox_verification'] == true){
// 	echo $key."<br>";
// }