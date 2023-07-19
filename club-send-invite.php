<?php
include("Query.Inc.php");
require_once 'Opentok-PHP-SDK-master/API_Config.php';
require_once 'Opentok-PHP-SDK-master/OpenTokSDK.php';
$Obj = new Query($DBName);
 $send_user_id = $_GET['user_id'];
$apy_key="40073752";
$api_secrate="d64326aeb85ea41c54e6f6212d196566810f8409";
$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
// Creating an OpenTok Object
//$apiObj = new OpenTokSDK( $apy_key, $api_secrate );

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


//$token = $apiObj->generateToken($sessionId);

// Giving the token a moderator role, expire time 5 days from now, and connectionData to pass to other users in the session
//$token = $apiObj->generateToken($sessionId, RoleConstants::MODERATOR, time() + (5*24*60*60), "hello world!" );
      $sql = "select * from club_cam where user_id='".$_SESSION['user_id']."'";
	$query = mysql_query($sql);
	 $cnt = @mysql_num_rows($query);
	if($cnt <= 0)
	{
	$c_date=date('Y-m-d H:i:s');
	$ValueArray = array($_SESSION['user_id'],$session,$token);
	$FieldArray = array('user_id','session','token');
	$Success = $Obj->Insert_Dynamic_Query("club_cam",$ValueArray,$FieldArray);
	}


?>

<?php

  $sql_up="update clubs set is_launch='1' where id='".$_SESSION['user_id']."'";
  @mysql_query($sql_up);
  
  if (isset($_GET["moderator"]))
  {
    $token = $apiObj->generateToken($sessionId, "moderator", null, "moderator");
  }
  else
  {
    $token = $apiObj->generateToken($sessionId, "publisher", null, "publisher");
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Dividing Mods and Publishers</title>
	
	<link rel="stylesheet" type="text/css" href="http://meyerweb.com/eric/tools/css/reset/reset.css" />
	<link rel="stylesheet" type="text/css" href="common.css" />
	
	<script src="http://static.opentok.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	
	<!-- now begins the example, everything before is just standard web stuff -->
	<script type="text/javascript">
			var api_key = 7016162;
		var session_id = '2_MX43MDE2MTYyfjE5Mi4xNjguMTAuOTN-MjAxMi0wNS0wMSAyMDozMzoyNi44Mzc2OTgrMDA6MDB-MC4xNzUyMjY1MzU1NTR-';
		var token = 'T1==cGFydG5lcl9pZD03MDE2MTYyJnNka192ZXJzaW9uPXRicGhwLXYwLjkxLjIwMTEtMDctMDUmc2lnPTAyMjQ0ZDdkY2VlNGQzYWRkMGUwZTk3YTA0MWJjNzRhMzNmNTBhODk6c2Vzc2lvbl9pZD0yX01YNDNNREUyTVRZeWZqRTVNaTR4TmpndU1UQXVPVE4tTWpBeE1pMHdOUzB3TVNBeU1Eb3pNem95Tmk0NE16YzJPVGdyTURBNk1EQi1NQzR4TnpVeU1qWTFNelUxTlRSLSZjcmVhdGVfdGltZT0xMzc4MjAzNzEyJnJvbGU9cHVibGlzaGVyJm5vbmNlPTEzNzgyMDM3MTIuODQyNjE5ODYwMzE3MTMmY29ubmVjdGlvbl9kYXRhPXB1Ymxpc2hlcg==';
		var connections = {};
		
		$(document).ready(function() {
			TB.setLogLevel(5);
			session = TB.initSession(session_id);
			session.addEventListener("sessionConnected", sessionConnectedHandler);
			session.addEventListener("streamCreated", streamCreatedHandler);
			session.connect(api_key, token);
		});
		
		function sessionConnectedHandler(event) {
			if (session.connection.data == "moderator") {
				$("#moderators_container").append($("<div id='temp_publish_div'></div>"));
			} else {
				$("#publishers_container").append($("<div id='temp_publish_div'></div>"));
			}
			session.publish("temp_publish_div");
			
			streamCreatedHandler(event);
		}
		
		function streamCreatedHandler(event) {
			for (var i = 0; i < event.streams.length; i++) {
				if (event.streams[i].connection.connectionId != session.connection.connectionId) {
					if (event.streams[i].connection.data == "moderator") {
						$("#moderators_container").append($("<div id='temp_div'></div>"));
					} else {
						$("#publishers_container").append($("<div id='temp_div'></div>"));
					}
					session.subscribe(event.streams[i], "temp_div");
				}
			}
		}
	</script>
	<style type="text/css">
	
		
		.container2 {
			display: inline-block;
			margin: 10px;
			border: 1px solid black;
			width: 300px;
			vertical-align: top;
		}
		
		.container2 > object {
			display: block;
			margin: 10px auto;
		}
		
	</style>
</head>
<body>
<div id="main">
    <div class="container">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
  <?php include('header.php') ?>
		<div id="publishers_container" class="container2">Publishers</div>

	</div>
	</div>
</body>
  <?php include('footer.php') ?>
</html>
