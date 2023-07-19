<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

//unset($_SESSION);
session_destroy();
die;

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
var x = document.getElementById("demo");

//function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
//}

function showPosition(position) {
	
	jQuery.post('ajaxcall.php', { 'longitude':position.coords.longitude, 'latitude':position.coords.latitude, 'get_visitor_geolocation': 'get_current_user_location' }, function(response){
		
		
		
	});
	
    //x.innerHTML = "Latitude: " + position.coords.latitude + 
    //"<br>Longitude: " + position.coords.longitude;	
}
</script>
<?php die; ?>