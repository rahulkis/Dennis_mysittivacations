<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$type_of_club=$_GET['host_id'];
 $sql = mysql_query("select * from `clubs` where `id` = '".$type_of_club."' AND  club_city='".$_SESSION['id']."' "); 
 $sql2 = mysql_query("select * from `clubs` where `id` = '".$type_of_club."' AND club_city='".$_SESSION['id']."' ");
  $sql3 = mysql_query("select * from `clubs` where `id` = '".$type_of_club."' AND club_city='".$_SESSION['id']."' ");
  $row3 = @mysql_fetch_array($sql3);
  $num=@mysql_num_rows($sql); 

//$rw2=@mysql_fetch_assoc($sql2);
//print_r($_SESSION); die('dfdf');

  function ip_details($IPaddress) 
    {
        $json       = file_get_contents("http://ipinfo.io/{$IPaddress}");
        $details    = json_decode($json);
        return $details;
    }
    $IPaddress  =   $_SERVER['REMOTE_ADDR'];
    $details    =   ip_details("$IPaddress");
	$loc=explode(",",$details->loc);
	
	 
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
});

	
	  
	

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
	 
  var mapOptions = {
          zoom: 15
        };

   
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
   
    // Multiple Markers
    var markers = [
	 <?php $i=1;while($rw=@mysql_fetch_assoc($sql)){  
	 //echo 'http://maps.google.com/maps/api/geocode/json?sensor=false&address='.str_replace(" ","+",$rw['club_address']);
	  $json = file_get_contents('http://maps.google.com/maps/api/geocode/json?sensor=false&address='.str_replace(" ","+",$rw['club_address'])); // this WILL do an http request for you
	  $data=json_decode($json);
 	  $lat = $data->results[0]->geometry->location->lat;
	 $long = $data->results[0]->geometry->location->lng;
	 ?>	
        ['<?php echo $rw['club_name']; ?>', '<?php echo $lat; ?>','<?php echo $long; ?>'] <?php if($num!=$i){ ?>  , <?php } ?> 
     <?php $i++;} ?>	
    ];
	       
    // Info Window Content
    var infoWindowContent = [
	 <?php $j=1;while($rw2=@mysql_fetch_assoc($sql2)){  ?>
        ['<div class="info_content">' +
        '<h3><?php echo $rw2['club_name']; ?></h3>' +
        '<p><?php echo $rw2['club_address']; ?></p>' + '</div>']
		 <?php if($num!=$j){ ?>  , <?php } ?> 
		 <?php $j++;} ?>
    ];
        <?php if($_SESSION['lat']!=""){ ?>
		var pinImage = new google.maps.MarkerImage("https://mysitti.com/images/cancel.png",
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
	// get users current location
	 var position = new google.maps.LatLng('<?php echo $_SESSION['lat'] ?>','<?php echo $_SESSION['long'] ?>');
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
			 icon: pinImage,
            map: map,
            title:'My Location'
        });
        
        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
	// end here 
   <?php } ?>

    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }
	
	 
    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(15);
        google.maps.event.removeListener(boundsListener);
    });
}
</script>
<style>
#map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 100%;
    height: 100%;
}
</style>

<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />

<div id="modal" class="popupContainer" style=" width:99%;  height: 100%;   left: 1%; position: absolute; top:3px;" >
	<header class="popupHeader">
		<span class="header_title"><?php echo $row3['club_name']; ?> Host Details</span>

	</header>
	<section class="popupBody">

				<div class="post_container">

                    <div>
				<div id="map_wrapper">
				    <input type="hidden" name="lat" id="lat">
					 <input type="hidden" name="long" id="long">
				   <div id="map_canvas" class="mapping"></div>
			       </div>
						
					<h1 class="evt_title">
                      	<?php echo $row3['club_name']; ?>
                    </h1>
                    
                    
                    
                    <div class="location">
                    <p><span><?php echo $row3['club_address']; ?></span><br>
                    
                    </p>
                    <!--<p><a title="" target="_blank">Map</a></p>-->
                    
                    <div style="clear:both"></div>
                    </div>
                   
                    </div>
					
					<a href="javascript:void(0);"><input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Close"/></a>
                </div>		
		
</section>
</div>