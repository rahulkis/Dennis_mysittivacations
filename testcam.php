<script type="text/javascript">
  var apiKey    = "40073752";
  var sessionId = "1_MX4zODk3ODQ2Mn4xMTYuNzQuMjA4LjYwfk1vbiBTZXAgMDIgMDU6NDg6NTMgUERUIDIwMTN-MC45MjA1NTM1fg";
  var token     = "T1==cGFydG5lcl9pZD00MDA3Mzc1MiZzZGtfdmVyc2lvbj10YnJ1YnktdGJyYi12MC45MS4yMDExLTAyLTE3JnNpZz05ZmYyNTA0MjM0OGU4ZGM4ZTk5MGQwYzMzZGZjMmJlNjM5NjJkODMwOnJvbGU9cHVibGlzaGVyJnNlc3Npb25faWQ9MV9NWDR6T0RrM09EUTJNbjR4TVRZdU56UXVNakE0TGpZd2ZrMXZiaUJUWlhBZ01ESWdNRFU2TkRnNk5UTWdVRVJVSURJd01UTi1NQzQ1TWpBMU5UTTFmZyZjcmVhdGVfdGltZT0xMzc4MTI3MDQ2Jm5vbmNlPTAuNDczODgxMzM3NTYzMjAzODMmZXhwaXJlX3RpbWU9MTM3ODczMTg0NSZjb25uZWN0aW9uX2RhdGE9";
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
   $sql = "select inv.*,u.first_name,u.last_name from cam_invite as inv left join  user as u on(u.id=inv.created_by) where (inv.created_by = '".mysql_real_escape_string($_SESSION['user_id'])."' AND sent_to='".$_GET['sent_to']."') order by inv.id ASC"; 
	$query = mysql_query($sql);
	$cnt = @mysql_num_rows($query);
	if($cnt > 0)
	{
	 $sql = "update cam_invite set recd='0' where session='".$_GET['session']."' AND created_by='".$_SESSION['user_id']."'";
	 $query = mysql_query($sql);
	}else
	{
	$c_date=date('Y-m-d H:i:s');
	$ValueArray = array($_SESSION['user_id'],$_GET['sent_to'],$_GET['session'],$_GET['token'],$c_date);
	$FieldArray = array('created_by','sent_to','session','token','sent');
	$Success = $Obj->Insert_Dynamic_Query("cam_invite",$ValueArray,$FieldArray);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>OpenTok Hello World</title>
        <script src='http://static.opentok.com/v1.1/js/TB.min.js'></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" charset="utf-8">

// *** Fill the following variables using your own Project info from the Dashboard ***
// *** (https://dashboard.tokbox.com/projects) ***

var apiKey = '40073752'; // Replace with your own API key.
var sessionId = '1_MX4zODk3ODQ2Mn4xMTYuNzQuMjA4LjYwfk1vbiBTZXAgMDIgMDU6NDg6NTMgUERUIDIwMTN-MC45MjA1NTM1fg'; // Replace with your generated Session ID.'; // Replace with your generated Session ID.
var token = 'T1==cGFydG5lcl9pZD00MDA3Mzc1MiZzZGtfdmVyc2lvbj10YnJ1YnktdGJyYi12MC45MS4yMDExLTAyLTE3JnNpZz05ZmYyNTA0MjM0OGU4ZGM4ZTk5MGQwYzMzZGZjMmJlNjM5NjJkODMwOnJvbGU9cHVibGlzaGVyJnNlc3Npb25faWQ9MV9NWDR6T0RrM09EUTJNbjR4TVRZdU56UXVNakE0TGpZd2ZrMXZiaUJUWlhBZ01ESWdNRFU2TkRnNk5UTWdVRVJVSURJd01UTi1NQzQ1TWpBMU5UTTFmZyZjcmVhdGVfdGltZT0xMzc4MTI3MDQ2Jm5vbmNlPTAuNDczODgxMzM3NTYzMjAzODMmZXhwaXJlX3RpbWU9MTM3ODczMTg0NSZjb25uZWN0aW9uX2RhdGE9'; // Replace with your generated Token (use Project Tools or from a server-side library)

var session;
var publisher;
var subscribers = {};

// Un-comment either of the following to set automatic logging and exception handling.
// See the exceptionHandler() method below.
// TB.setLogLevel(TB.ALL);
// TB.addEventListener("exception", exceptionHandler);

session = TB.initSession(sessionId);	// Initialize session

// Add event listeners to the session
session.addEventListener('sessionConnected', sessionConnectedHandler);
session.addEventListener('sessionDisconnected', sessionDisconnectedHandler);
session.addEventListener('connectionCreated', connectionCreatedHandler);
session.addEventListener('connectionDestroyed', connectionDestroyedHandler);
session.addEventListener('streamCreated', streamCreatedHandler);
session.addEventListener('streamDestroyed', streamDestroyedHandler);

//--------------------------------------
// LINK CLICK HANDLERS
//--------------------------------------

/*
If testing the app from the desktop, be sure to check the Flash Player Global Security setting
to allow the page from communicating with SWF content loaded from the web. For more information,
see http://www.tokbox.com/opentok/docs/js/tutorials/helloworld.html#localTest
*/
function connect() {
session.connect(apiKey, token);
}

function disconnect() {
session.disconnect();
hide('disconnectLink');
hide('publishLink');
hide('unpublishLink');
}

// Called when user wants to start publishing to the session
function startPublishing() {
if (!publisher) {
var parentDiv = document.getElementById("myCamera");
var publisherDiv = document.createElement('div'); // Create a div for the publisher to replace
var publisherProperties = {};
publisherProperties.name = "A web-based OpenTok client";
publisherProperties.data = "Joe mama"
publisherDiv.setAttribute('id', 'opentok_publisher');
parentDiv.appendChild(publisherDiv);
publisher = session.publish(publisherDiv.id, publisherProperties); // Pass the replacement div id to the publish method
//show('unpublishLink');
//hide('publishLink');
}
  
}

function stopPublishing() {
if (publisher) {
session.unpublish(publisher);
}
publisher = null;

show('publishLink');
hide('unpublishLink');
}

//--------------------------------------
// OPENTOK EVENT HANDLERS
//--------------------------------------

function sessionConnectedHandler(event) {

 $.get('cam.php?action=update&session_id=<?php echo $_GET['session']; ?>', function(data) {
    // Now that we've completed the request schedule the next one.
  });
// Subscribe to all streams currently in the Session
for (var i = 0; i < event.streams.length; i++) {
addStream(event.streams[i]);
}
startPublishing();
show('disconnectLink');
//show('publishLink');
//hide('connectLink');
}

function streamCreatedHandler(event) {
// Subscribe to the newly created streams
for (var i = 0; i < event.streams.length; i++) {
TB.log("streamCreated - connectionId: " + event.streams[i].connection.connectionId);
TB.log("streamCreated - connectionData: " + event.streams[i].connection.data);
addStream(event.streams[i]);
}
}

function streamDestroyedHandler(event) {
// This signals that a stream was destroyed. Any Subscribers will automatically be removed.
// This default behaviour can be prevented using event.preventDefault()
}

function sessionDisconnectedHandler(event) {
// This signals that the user was disconnected from the Session. Any subscribers and publishers
// will automatically be removed. This default behaviour can be prevented using event.preventDefault()
publisher = null;

show('connectLink');
hide('disconnectLink');
hide('publishLink');
hide('unpublishLink');
}

function connectionDestroyedHandler(event) {
// This signals that connections were destroyed
}

function connectionCreatedHandler(event) {

// This signals new connections have been created.
}

/*
If you un-comment the call to TB.addEventListener("exception", exceptionHandler) above, OpenTok calls the
exceptionHandler() method when exception events occur. You can modify this method to further process exception events.
If you un-comment the call to TB.setLogLevel(), above, OpenTok automatically displays exception event messages.
*/
function exceptionHandler(event) {
alert("Exception: " + event.code + "::" + event.message);
}

//--------------------------------------
// HELPER METHODS
//--------------------------------------

function addStream(stream) 
{
// Check if this is the stream that I am publishing, and if so do not publish.
if (stream.connection.connectionId == session.connection.connectionId) {
return;
}
var subscriberDiv = document.createElement('div'); // Create a div for the subscriber to replace
subscriberDiv.setAttribute('id', stream.streamId); // Give the replacement div the id of the stream as its id.
document.getElementById("subscribers").appendChild(subscriberDiv);
subscribers[stream.streamId] = session.subscribe(stream, subscriberDiv.id);
}

function show(id) {
document.getElementById(id).style.display = 'block';
}

function hide(id) {
document.getElementById(id).style.display = 'none';
}

</script>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
</head>
<body>



<div id="main">
    <div class="container">
    <?php include('header.php') ?>
    <div id="wrapper" class="space">
       <div id="title">Contests</div>
      <div id="links">
        <input type="button" value="Connect" id ="connectLink" onClick="javascript:connect()" />
        <input type="button" value="Disconnect" id ="disconnectLink" onClick="javascript:disconnect()" style="display:none" />
        <input type="button" value="Publish" id ="publishLink" onClick="javascript:startPublishing()" style="display:none" />
        <input type="button" value="Unpublish" id ="unpublishLink" onClick="javascript:stopPublishing()" style="display:none" />
</div>
       <div id="myCamera" class="publisherContainer"></div>
<div id="subscribers"></div>


              </div>
            </div>
          </div>
		    <?php include('footer.php') ?>
</body>
</html>



