<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$cityname = $_POST['formatted'];


$city_name_query = @mysql_query("SELECT dma_id, country_name FROM us_country_dma WHERE country_name ='".$cityname."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$city_dma_id = $get_city_name['dma_id'];


$url = "https://app.ticketmaster.com/discovery/v2/classifications?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=jazz&preferredCountry=us"; 

   $response_content = file_get_contents($url);
	$response = json_decode($response_content, true);

	$classifications = $response['_embedded']['classifications'];

	$data = [];

	foreach ($classifications as $key => $classification) {

	$generes = $classification['segment']['_embedded']['genres'];
	$ids = implode(',', array_map(function($genere){
	return $genere['id'];
	}, $generes));

	$data[$key] = $ids;
	}

	$ids = implode(',', $data);

		$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."";

		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);

	    $get_deals = $get_all_data['_embedded']['events'];
        
	  	?>
     
	
	 <?php 
     foreach ($get_deals as $homeData)
	    {


	   $eventsName = $homeData['name'];
	   $eventUrl = $homeData['url'];
	   $start_date = $homeData['dates']['start']['localDate'];
	   $timestamp = strtotime($start_date);
	   $date_foemate = date('m/d/Y', $timestamp);
	   $vanues = $homeData['_embedded']['venue'][0]['name'];
	   $nameOfDay = date('D', strtotime($start_date));
	   $nameOfMonth = date('M', strtotime($start_date));
	   $dateName = date('d', strtotime($start_date));
        
    	
	$html .= "<div class='row new-h'>
		  <div class='col-sm-12' style='color:black;'>
				    <div class='well di'> 
				     <h2>".$eventsName."</h2>
				     <p>".$vanues."</p>
				    </div>
				  </div>
				  <div class='col-sm-4 col-xs-4' style='color:black;'>
				    <div class='well change_date_formaet'>
				     <p class='monthName'>".$nameOfMonth."</p>
				     <p>".$dateName."</p>
				     <p>".$nameOfDay."</p> 
				    </div>
				  </div>
			
				  <div class='col-sm-4 col-xs-4' style='color:black;'>
				    <div class='well chnage_formate'> 
				      <p>Goes On Sale:</p>
				      <p>". $nameOfDay .','.$date_foemate."</p>
				    </div>
				  </div>

				  <div class='col-sm-4 col-xs-4' style='color:black;'>
				    <div class='well btn-mor event_url'> 
				      <a href=".$eventUrl." target='_blank'>More Info</a>
				    </div>
				  </div>
			</div>";
    	}
    	
    	
    	echo $html;

	  ?>
