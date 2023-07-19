<?php
include("Query.Inc.php");
require_once 'Opentok-PHP-SDK-master/API_Config.php';
require_once 'Opentok-PHP-SDK-master/OpenTokSDK.php';
$Obj = new Query($DBName);

 $send_user_id = $_GET['user_id'];


// Creating an OpenTok Object
$apiObj = new OpenTokSDK( API_Config::API_KEY, API_Config::API_SECRET );

// Creating Simple Session object, passing IP address to determine closest production server
// Passing IP address to determine closest production server


$session = $apiObj->createSession($_SERVER["REMOTE_ADDR"]);

// Creating Simple Session object 
// Enable p2p connections
$session = $apiObj->createSession( $_SERVER["REMOTE_ADDR"], array(SessionPropertyConstants::P2P_PREFERENCE=> "disabled") );

// Getting sessionId from Sessions
// Option 1: Call getSessionId()
$sessionId = $session->getSessionId();
//echo $sessionId;
// Option 2: Return the object itself


$token = $apiObj->generateToken($sessionId);

// Giving the token a moderator role, expire time 5 days from now, and connectionData to pass to other users in the session
$token = $apiObj->generateToken($sessionId, RoleConstants::MODERATOR, time() + (5*24*60*60), "hello world!" );
	$c_date=date('Y-m-d H:i:s');
	$ValueArray = array($_SESSION['user_id'],$send_user_id,$session,$token,$c_date);
	$FieldArray = array('created_by','sent_to','session','token','sent');
	$Success = $Obj->Insert_Dynamic_Query("cam_invite",$ValueArray,$FieldArray);
	echo "session=".$session."&token=".$token."&sent_to=". $send_user_id;

?>