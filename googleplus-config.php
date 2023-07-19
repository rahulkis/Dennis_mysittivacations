<?php ########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
$google_client_id 		= '963258121060-s4lqovr9ikrbteehc0p055avffnrl503.apps.googleusercontent.com';
$google_client_secret 	= 'ZOSdPtpfZkgsm2l3yut24ksd';
$google_redirect_url 	= 'https://mysitti.com/user_social.php'; //path to your script
$google_developer_key 	= 'AIzaSyBEXmb6IRcJ5K24nItkd4NAuAMB9kRiLc4';
//include google api files
require_once 'google-login/src/Google_Client.php';
require_once 'google-login/src/contrib/Google_Oauth2Service.php';
require_once 'google-login/src/contrib/Google_PlusService.php';
require_once 'google-login/src/contrib/Google_PlusMomentsService.php';



$gClient = new Google_Client();
$gClient->setApplicationName('Login Mysitti.com');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);
$google_oauthV2 = new Google_Oauth2Service($gClient);
$gClient->setScopes(array('https://www.googleapis.com/auth/plus.login'));
$gClient->setScopes(array('https://www.googleapis.com/auth/prediction'));

$plus = new Google_PlusService($gClient);

if (isset($_GET['code'])) 
{ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}


if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);
}



if ($gClient->getAccessToken()) 
{
	//die('HERE');

	  //For logged in user, get details from google using access token
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_id 				= $user['id'];
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
}
else 
{
	//For Guest user, get google login url
	$authUrl = $gClient->createAuthUrl();
}
?>