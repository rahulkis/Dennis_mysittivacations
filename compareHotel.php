<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Hotels"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
	$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$dropdown_city = $get_city_name['city_name'];
	$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
	$get_state_name = mysql_fetch_assoc($state_name_query);
	$dropdown_state = $get_state_name['code'];

	$LATITUDE = $get_city_name['lat'];
	$LONGITUDE = $get_city_name['lng'];
	$CITYID = $get_city_name['city_id'];
	$_SESSION['city'] = $get_city_name['city_id'];
	$_SESSION['state'] = $get_city_name['state_id'];
	$_SESSION['country'] = $get_state_name['country_id'];
	$_SESSION['state_name'] = $get_state_name['name'];


?>


<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<!-- <aside class="sidebar v2_sidebar"> -->
				

						<!-- <div class="layout-slider">
					        <input id="Slider2" type="text" name="range" value="50;500" />
					    </div> -->
					 
				    	<script type="text/javascript" charset="utf-8">
				      		jQuery("#Slider2").slider({
				      			from: 10, 
				      			to: 1000, 
				      			heterogeneity: ['50/500'], 
				      			step: 10, 
				      			dimension: '&nbsp;$',
				      			callback: function( value ){
								    $.ajax({
						                type: 'POST',
						                url: 'hotel_filter_price.php',
						                data: {range: value},
						                beforeSend: function()
									    {
									        $("#loader").addClass("loading");
									    },
						                success: function(data) {
								            $('article#atrl').html(data);
								            $("#loader").removeClass("loading");
								        }
					         		});
								  }
				      		});

				      		$(function(){
				    		$("button").click(function() {
							    var con = $(this).val();
							    var con2 = $("#desti").val();
							    var con3 = $("#checkinin").val();
							    var con4 = $("#checkoutt").val();
							    var con5 = $("#room").val();
							    var con6 = $("#guest").val();
							    if (con3 == '' || con4 == '') {
						              alert("Please first by search widget.");
						            } else {
						            $.ajax({
						                    type: 'POST',
						                    url: 'get_star_hotel.php',
						                    data: {starValue: con, desti: con2, checkin: con3, checkout: con4, rom: con5, gust: con6},
						                    beforeSend: function()
										    {
										        $("#loader").addClass("loading");
										    },
							                success: function(data) {
									            $('article#atrl').html(data);
									            $("#loader").removeClass("loading");
									        }
						                });
						        	}
						            });
							    });


				      			$(function(){
			           			$("#hitAjax").click(function(){

								    var geodemo = $('#geo-demo').val();
									var cin = $('#dpd1').val();
									var cout = $('#dpd2').val();
									var room = $('#roomid').val();
									var guid = $('#guestid').val();
									 if (geodemo == '' || cin == '' || cout == '') {
						              alert("All fields are mandatory.");
						            } else {
									$.ajax({
									    url: "get_search_hotel.php",
									    type: "POST",
									    data: {
									      formatted: geodemo,
									      checkin: cin,
									      checkout: cout,
									      room: room,
									      guest: guid
									    },
									    beforeSend: function()
									    {
									        $("#loader").addClass("loading");
									    },
									    success: function (response) 
									    {
										   	$('article#atrl').html(response);
										   	$("#loader").removeClass("loading");
										}
								  	});
								  	return false;    
									}
									}); 
								}); 
				           	
				      		
				      		
				    	</script>
				
			<!-- </aside> -->
			<div id="loader"></div>
			<article id="atrl" class="oneArticleBookingBuddy">
			<?php

				// $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$dropdown_city."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

				// $details=file_get_contents($url);
				// $result = json_decode($details,true);

				// $lat=$result['results'][0]['geometry']['location']['lat'];
				// $lng=$result['results'][0]['geometry']['location']['lng'];

				// $url = "https://apim.expedia.com/wsapi/rest/hotel/v2/search?&location=".$lat.",".$lng."&radius=100&maxhotels=30&format=json&key=2f87cd1c-9af8-474b-ab7d-e193a13982cb";
				// $result = file_get_contents($url);
				
				// $get_all_data = json_decode($result, true);
				

				$start=0;
				$limit = 15;
				if(isset($_GET['page']))
				{
				$page = $_GET['page'];
				$start = ($page-1)*$limit;
				}
				
					
					 
				
				// $today = date("Y-m-d");
				// $next = date('Y-m-d', strtotime(' +1 day'));

				// $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$dropdown_city."&key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM";

				// $details=file_get_contents($url);
				// $result = json_decode($details,true);

				// $lat=$result['results'][0]['geometry']['location']['lat'];
				// $lng=$result['results'][0]['geometry']['location']['lng'];

				// $url2 ="https://apim.expedia.com/wsapi/rest/hotel/v2/search?&location=".$lat.",".$lng."&dates=".$today.",".$next."&sort=price&radius=100&maxhotels=270&format=json&key=2f87cd1c-9af8-474b-ab7d-e193a13982cb";
				// $result = file_get_contents($url2);
				// echo "<h1 class='deals_heading'>".$arr2." Hotels Deals</h1>";
				// $get_all_data = json_decode($result, true);

				// $urls = "https://api.tripexpert.com/v1/venues?order_by=distance&venue_type_id=1&latitude=".$lat."&longitude=".$lng."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
				// $result_tripn = file_get_contents($urls);
		  //       $get_all_data2 = json_decode($result_tripn, true);
		  //       $resto_venues = $get_all_data2['response']['venues'];

		  //       $array1 = array_column($get_all_data['HotelInfoList']['HotelInfo'], 'Name');
				// $array2 = array_column($resto_venues, 'name');

				
				// $comp = array_intersect($array2, $array1);

				// if(isset($_POST['q1']) || isset($_POST['q2']) || isset($_POST['q3']))
				// {
				// 	echo $destination = $_POST['q1'];
				// 	echo $checkin = $_POST['q2'];
				// 	echo $checkind = $_POST['q3'];
				// }
				
		  		// if ( isset( $_POST['submit_compare'] ) ) 
		  		// {
		  	// 		$destination = $_POST['desti'];
					// $checkin = $_POST['checkinin'];
					// $checkout = $_POST['checkoutt'];
					// $room = $_POST['room'];
					// $guest = $_POST['guest'];
					// $checkHt = $_POST['checkH'];
					
					if(isset($_POST['hw']))
					{
						$destination = $_POST['desti'];
						$checkin = $_POST['checkinin'];
						$checkout = $_POST['checkoutt'];
						$room = $_POST['room'];
						$guest = $_POST['guest'];
						// $checkHt = $_POST['hw'];

						$newcheckin = date("m-d-Y", strtotime($checkin));
						$newcheckout = date("m-d-Y", strtotime($checkout));
						echo $frmurl = "https://www.hotwire.com/hotels/results/".$destination."/".$newcheckin."/".$newcheckout."/".$room."/".$guest."/0";
						$html = "<iframe src='".$frmurl."' scrolling='yes' width='100%' height='100%' frameborder='0'></iframe>";
						echo $html;
					} 
					elseif(isset($_POST['bk']))
					{ 
						$destination = $_POST['desti'];
						$checkin = $_POST['checkinin'];
						$checkout = $_POST['checkoutt'];
						$room = $_POST['room'];
						$guest = $_POST['guest'];
						?>
						<iframe src="https://www.booking.com/?aid=1259500" scrolling="yes" width="100%" height="100%" frameborder="0"></iframe>
				<?php	} 
					elseif(isset($_POST['hc']))
					{
						$destination = $_POST['desti'];
						$checkin = $_POST['checkinin'];
						$checkout = $_POST['checkoutt'];
						$room = $_POST['room'];
						$guest = $_POST['guest'];

						$newcheckin = date("Y-m-d", strtotime($checkin));
						$newcheckout = date("Y-m-d", strtotime($checkout));

						if(strpos($destination, " ") !== false)
						{
						   $text = str_replace(" ", "_", $destination);
						} else {
							$text = $destination;
						}
						$frmurl = "https://www.hotelscombined.com/Hotels/Search?destination=place%3A".$text."&checkin=".$newcheckin."&checkout=".$newcheckout."&Rooms=".$room."&adults_1=".$guest."";
						$html = "<iframe src='".$frmurl."' scrolling='yes' width='100%' height='100%' frameborder='0'></iframe>";
						echo $html;
					}

				
				// }
					$total=ceil($rows/$limit);
					if($rows > 15)
					{
					echo '<div class="pagination_new">';
					if($total > 1)
					{
						echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
						if ($page <= 1)
							echo "<span>Previous</span>";
						else            
							echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
						echo "  ";
						if(!isset($_GET['page']))
						{
							$y = '1';
						}
						else
						{
							$y = $_GET['page'];
						}

						$z = '0';
						$pageNumber = (int) $_GET['page'];
						for ($x=$y;$x<=$total;$x++){
							if($z < 9)
							{
								echo "  ";
								if ($x == 1)
								{
									echo "<span class='active_range'>$x</span>";
								}
								else
								{ ?>
									<a href='?page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
							<?php	}
							}
							$z++;
						}
						if($page == $total) 
							echo "<span>Next</span>";
						else           
							echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

						echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
					}
				echo "</div>";
				}
				// }	
			?>
			</article>
		</div>
	</div>
</div>

<style type="text/css">


.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>


<?php
if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<?php
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>