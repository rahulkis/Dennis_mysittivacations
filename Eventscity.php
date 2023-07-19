<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
include 'pagination.class.php';
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage = "Events"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<aside class="sidebar v2_sidebar">
				<div class="hotel-side">
					<?php
						$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
						$get_city_name = mysql_fetch_assoc($city_name_query);
						$dropdown_city = $get_city_name['city_name'];
						$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
						$get_state_name = mysql_fetch_assoc($state_name_query);
						$_SESSION['country'] = $get_state_name['country_id'];
						
						$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
						$get_co_name = mysql_fetch_assoc($co_name_query);
						$conry_nm = $get_co_name['name'];
						$state_name = $get_state_name['name'];
					?>
					 <div data-role="page">
					  	 <div data-role="header">
					    	<h1>Filter by Country</h1>
					  	</div>
					  	<div class="filter_div">
						  	<label class="labelfilter">Country :</label>
						  	<select id="country" name="status" onchange="getState(this.value)">
						      <option value=""><?php echo $conry_nm; ?></option>
						    <?php
						    	$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/GetCountries?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7";
						  		$xml = simplexml_load_file($completeurl);
						  		
						  		$get_d = json_decode( json_encode($xml), true);
						  		$get_data = $get_d['Country'];
						  		$response = [];
							        foreach ($get_data as $i => $data) {
							            $response[$i]['country'] = $data['@attributes'];
									}
						  			foreach ($response as $countryList) {
						  			
						  					echo "<option value='".$countryList['country']['ID']."'>".$countryList['country']['Name']."</option>";
							  		}
							?>
							</select>
						  	<label class="labelfilter">State :</label>
							<select name="state" id="state-list" onchange="getCity(this.value)" class="demoInputBox">
								<option value=""><?php echo $state_name; ?></option>
							</select>
							<label class="labelfilter">City :</label>
							<select name="city" id="city-list" onchange="getList(this.value)" class="demoInputBox">
								<option value=""><?php echo $dropdown_city; ?></option>
							</select>
						</div>
				    	<script type="text/javascript" charset="utf-8">
				    		function getEevnts(region, cid, id)
				    		{
				    			$.ajax({
								type: "POST",
								url: "get_events.php",
								data: {region : region, cid : cid, id : id},
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

							function getState(val) {
								$.ajax({
								type: "POST",
								url: "get_state.php",
								data:'country_id='+val,
								success: function(data){
									$("#state-list").html(data);
								}
								});
								
								return getEevnts('GetEventsByCountryID', 'CountryID', val);
							}

							function getCity(val) {
								$.ajax({
								type: "POST",
								url: "get_city.php",
								data:'state_id='+val,
								success: function(data){
									$("#city-list").html(data);
								}
								});

								return getEevnts('GetEventsByStateID', 'StateID', val);
							}

						   	function getList(val) {
			    		   	    return getEevnts('GetEventsByCityID', 'CityID', val);
						    };

						    function getVenue(val) {
						    	return getEevnts('GetEventsByVenueID', 'VenueID', val);
						    };
				      		
				    	</script>
				    	<div data-role="header" class="filteration">
					    	<h1>Filter by Venue</h1>
					  	</div>
					  	<div class="filter_div">
					  	<select id="venues" name="venue" onchange="getVenue(this.value)">
					      <option value="">Select Venue</option>
					    <?php
					    	$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/GetVenues?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7";
					  		$xml = simplexml_load_file($completeurl);
					  		
					  		$get_d = json_decode( json_encode($xml), true);
					  		$get_data = $get_d['Venue'];
					  		$response = [];       
						        foreach ($get_data as $i => $data) {
						            $response[$i]['venue'] = $data['@attributes'];
								}
					  			foreach ($response as $countryList) {
					  				echo "<option value='".$countryList['venue']['ID']."'>".$countryList['venue']['Name']."</option>";
					  			}
						?>
						</select>
						</div>
						<!-- <div class="cj_banner">
						<a href="http://www.dpbolvw.net/click-8265264-12844903" target="_top">Broadway Tickets</a><img src="http://www.tqlkg.com/image-8265264-12844903" width="1" height="1" border="0"/>
						</div> -->

					  	
					</div>
					
				</div>
			</aside>
			<div id="loader"></div>
			<article id="atrl" class="oneArticle">
			<?php	
				$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/GetCities?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7";
		  		$xml = simplexml_load_file($completeurl);
		  		
		  		$get_d = json_decode( json_encode($xml), true);
		  		$get_data = $get_d['City'];
		  		$responsee = [];       
			        foreach ($get_data as $i => $data) {
			            $responsee[$i]['city'] = $data['@attributes'];
					}


			if(!empty($dropdown_city)) {
			foreach ($responsee as $countryMatch) {
			
			if($countryMatch['city']['Name'] == trim($dropdown_city)) {
			$countryMatch['city']['ID'] . "<br>";
			$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/GetEventsByCityID?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7&CityID=".$countryMatch['city']['ID']."";
	  		$xml = simplexml_load_file($completeurl);
	  		
	  		$get_d = json_decode( json_encode($xml), true);	  		
	  		$get_data = $get_d['Event'];
	        $response = [];       
	        foreach ($get_data as $i => $data) {
	            $response[$i]['event'] = $data['@attributes'];
	            $response[$i]['performer'] = $data['Performer']['@attributes'];
	            $response[$i]['venue'] = $data['Venue']['@attributes'];
	            $response[$i]['venue']['city'] = @$data['Venue']['City']['@attributes'];
	            $response[$i]['venue']['country'] = @$data['Venue']['Country']['@attributes'];
	        }  	

	        /* start for pagination used  */
	        foreach ($response as $value) {
	          $products[] = array(
	            'Product' => $value,
	          );
	        }
	        
	        if (count($products)) {
	          
	          $pagination = new pagination($products, (isset($_GET['page']) ? $_GET['page'] : 1), 15);
	          
	          $pagination->setShowFirstAndLast(false);
	          
	          $pagination->setMainSeperator(' | ');
	          
	          $productPages = $pagination->getResults();
	         /* end for pagination used  */
	          
	        // if (count($productPages) != 0) {
	        foreach ($productPages as $Data)
	        { 
	        	?>
	        	<div class="home_list">
						<div class="Event_Div">
							<?php 
								$timestamp = $Data['Product']['event']['EventDateTime']; 
								$splits =  explode(" ",$timestamp);
								
								$get_date = $splits[0];
								$orderdate = explode('/', $get_date);
								$month = $orderdate[0];
								$day   = $orderdate[1];
								$year  = $orderdate[2];
								$get_time = $splits[1];
							?>
							<div class="divEventDate">
								<div class="date_wrapper">
									<span class="month"><?php 
										$months = $month;
												switch ($months) {
												    case "01":
												        echo "JAN";
												        break;
												    case "02":
												        echo "FEB";
												        break;
												    case "03":
												        echo "MAR";
												        break;
												  case "04":
												        echo "APR";
												        break;
												  case "05":
												        echo "MAY";
												        break;
												  case "06":
												        echo "JUN";
												        break;
												  case "07":
												        echo "JUL";
												        break;
												  case "08":
												        echo "AUG";
												        break;
												  case "09":
												        echo "SEP";
												        break;
												  case "10":
												        echo "OCT";
												        break;
												  case "11":
												        echo "NOV";
												        break;
												  default:
												        echo "DEC";
												}
									 ?></span>
									<span class="date"><?php echo $day; ?></span>
									<span class="weekday"><?php echo $year; ?></span>
								</div>
							</div>
									        
					        <div class="divHeader">
					        	<span class="listingEventName"><?php echo $Data['Product']['event']['Name']; ?></span>
					        </div>

					        <div class="divVenue">
					        	<?php echo $Data['Product']['venue']['Name']; ?> - <?php echo $Data['Product']['venue']['city']['Name']; ?>, <?php echo $Data['Product']['venue']['country']['Name']; ?>
					        </div>
					        <span class="event_datetime"><?php echo $get_time; ?></span>
						</div>

						<div class="divViewTix">
							<a href="<?php echo $Data['Product']['event']['Page']; ?>" target="_blank">
								<span class="ic">></span>
								<span class="bText">Select</span>
							</a>
						</div>
				</div> 	
	  		
	  <?php }
	  			echo $pageNumbers = '<div class="numbers">'.$pagination->getLinks($_GET).'</div>';
	  		// }
	  		}
	  		
	  		} 
	  		}
	  		} else {
	  			echo "<h1 class='record_not_found'>Please select your location. Currently you are not share our location.</h1>";
	  		}
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
