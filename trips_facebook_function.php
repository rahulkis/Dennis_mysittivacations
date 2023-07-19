<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
/* FACEBOOK LOGIN CODE */
require_once 'FacebookV5/autoload.php';
$appid      = "744847823590672";
$appsecret  = "a9bff4efb76f68a453204de9d85af4a3";

$fb = new Facebook\Facebook([
	'app_id' => $appid,
	'app_secret' => $appsecret,
	'default_graph_version' => 'v2.6',
]);

$helperNew = $fb->getRedirectLoginHelper();
$accessToken = $helperNew->getAccessToken();
print_r($accessToken);die('gs');
$facebook_permissions = array('email');
$facebook_login_url = $helperNew->getLoginUrl('https://www.mysittivacations.com/trips.php', $facebook_permissions);
 $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken->getValue());
  return redirect('/trips.php/', 'refresh');
/* END FACEBOOK LOGIN CODE  */
/* GOOGLE LOGIN CODE */
?>