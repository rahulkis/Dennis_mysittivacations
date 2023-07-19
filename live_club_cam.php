<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Show/Hide Publisher Manually Example</title>
	
	<link rel="stylesheet" type="text/css" href="common.css" />
	
	<script src="http://static.opentok.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	
	<!-- now begins the example, everything before is just standard web stuff -->
	
	<style type="text/css">
		#publisher_container
		{
			position: absolute;
			overflow: hidden;
			text-align: center;
			border: 1px solid black;
			background-color: #fff;
		}
		
		.publisher_hidden
		{
			width: 1px;
			height: 1px;
			left: -10px;
			top: -10px;	
		}
		
		#subscriber_container
		{
			width: 80%;
			margin: 0 auto;
		}
		
		#buttons
		{
			text-align: center;
		}
	</style>
	
	<script type="text/javascript">
		var api_key = '40073752';
		var session_id = '2_MX4zODk3ODQ2Mn4xMjcuMC4wLjF-TW9uIFNlcCAwMiAyMjoyOTozMCBQRFQgMjAxM34wLjU0Mzc0NzA3fg';
		var token = 'T1==cGFydG5lcl9pZD0zODk3ODQ2MiZzZGtfdmVyc2lvbj10YnJ1YnktdGJyYi12MC45MS4yMDExLTAyLTE3JnNpZz1mMjliMzZmMjc2MmRmZTI4OTRkN2JlZmEzM2YwOGMwNzJlZDZmMjBhOnJvbGU9cHVibGlzaGVyJnNlc3Npb25faWQ9Ml9NWDR6T0RrM09EUTJNbjR4TWpjdU1DNHdMakYtVFc5dUlGTmxjQ0F3TWlBeU1qb3lPVG96TUNCUVJGUWdNakF4TTM0d0xqVTBNemMwTnpBM2ZnJmNyZWF0ZV90aW1lPTEzNzgxODYyMDkmbm9uY2U9MC41ODM1MjE1MDg0MzQ0MzkyJmV4cGlyZV90aW1lPTEzODA3NzgyMDcmY29ubmVjdGlvbl9kYXRhPQ==';
		var session;
		
		var hidden = false;
		
		$(window).resize(function() {
			if (!hidden)
			{
				recenter_publisher();
			}
		});
		
		function recenter_publisher() {
			// this centers the publisher on the page
			$("#publisher_container").css("top", "" + Math.floor(($(window).height() - $("#publisher_container").height())/2) + "px");
			$("#publisher_container").css("left", "" + Math.floor(($(window).width() - $("#publisher_container").width())/2) + "px");
		}
		
		$(document).ready(function() {
			recenter_publisher();
			$("#show_publisher_button").hide();
			$("#hide_publisher_button").hide();
			
			$("#hide_publisher_button").click(function() {
				$("#publisher_container").addClass("publisher_hidden");
				$("#publisher_container").removeAttr("style");
				$(this).hide();
				$("#show_publisher_button").show();
				hidden = true;
			});
			
			$("#show_publisher_button").click(function() {
				$("#publisher_container").removeClass("publisher_hidden");
				recenter_publisher();
				$(this).hide();
				$("#hide_publisher_button").show();
				hidden = false;
			});
			
			
			TB.setLogLevel(5);
			session = TB.initSession(session_id);
			session.addEventListener("sessionConnected", sessionConnectedHandler);
			session.addEventListener("streamCreated", streamCreatedHandler);
			
			session.connect(api_key, token);
		});
		
		function sessionConnectedHandler(event)
		{
			$("#publisher_container").prepend($("<p id=\"click_allow_text\">Please click allow</p>"));
			session.publish("publisher_replace");
			
			recenter_publisher();
			console.log(event);
			streamCreatedHandler(event);
		}
		
		function streamCreatedHandler(event)
		{
			for (var i = 0; i < event.streams.length; i++)
			{
				var stream = event.streams[i];
				if (stream.connection.connectionId == session.connection.connectionId)
				{
					published = true;
					$("#click_allow_text").remove();
					$("#hide_publisher_button").show();
				}
				else
				{
					var new_div = $("<div id='subscribe_temp'></div>");
					$("#subscriber_container").append(new_div);
					session.subscribe(stream, 'subscribe_temp');
				}
			}
		}
	</script>
</head>
<body>
<div id="top_nav">
	<div id="top_nav_align"></div>
	<a href="index.php">Index of examples</a>
</div>	<div id='description_wrapper'>
		<div id='description_content'>
			<p>This example shows how to show/hide the publisher div. All it does is modify the CSS on a button click.</p>
		
			<p>Note: The user will not be able to click the hide/show button until he successfully publishes.</p>
		
			<p>You can <a href="http://digitaltsai.com/ot/examples/hide-publisher-manual.php?session_id=1_MX43MDE2MTYyfjExNi43NC4yMDguNjB-TW9uIFNlcCAwMiAyMjowODowOCBQRFQgMjAxM34wLjE2Njg4NDE4fg" target="new">load</a> the page in a new tab to see yourself being published</p>
		</div>
	</div>
	<div id="publisher_container">
		<div>
			<button id="hide_publisher_button">Hide Publisher</button>
		</div>
		<div id="publisher_replace">Connecting...</div>
	</div>
	<div id="buttons">
		<button id="show_publisher_button">Show Publisher</button>
	</div>
	<div id="subscriber_container">
	</div>
</body>
</html>