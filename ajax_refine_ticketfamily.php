<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropCity = $_POST['formatted'];
$dropdown_value = $_POST['doropdown'];

$date1 = $_POST['srartdate'];
$start_date = date("Y-m-d", strtotime($date1)).'T12:00:00Z';
$date2 = $_POST['enddate'];
$end_date = date("Y-m-d", strtotime($date2)).'T12:00:00Z';


$city_name_query = @mysql_query("SELECT dma_id, country_name FROM us_country_dma WHERE country_name ='".$dropCity."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$city_dma_id = $get_city_name['dma_id'];



$url = "https://app.ticketmaster.com/discovery/v2/classifications?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".rawurlencode($dropdown_value)."&preferredCountry=us";

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

    if($date1){
    	
    	 $urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&startDateTime=".$start_date."&endDateTime=".$end_date."&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=0"; 
   
    }else{

    $urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=0";
     
    }

  
	$result_get = file_get_contents($urlgo);
	$get_all_data1 = json_decode($result_get, true);

    $page_size = $get_all_data1['page']['size'];
    $totalPages = $get_all_data1['page']['totalPages'];
    $number = $get_all_data1['page']['number'];
  
    $get_deals = $get_all_data1['_embedded']['events']; 



?>
     
	
	 <?php 
	if(($city_dma_id) > 0){
     foreach ($get_deals as $homeData)
	    {

    
	   $eventsName = $homeData['name'];
	   $eventUrl = $homeData['url'];
	   $start_date = $homeData['dates']['start']['localDate'];

	   $timestamp = strtotime($start_date);
	   $date_foemate = date('m/d/Y', $timestamp);

	   $nameOfDay = date('D', strtotime($start_date));
	   $time = $homeData['dates']['start']['localTime'];
	   $strtime = date('h:i A', strtotime($time));
	   
	   $address1 = $homeData['_embedded']['venue'][0]['address']['line1'];
	   $address2 = $homeData['_embedded']['venue'][0]['address']['line2'];
	   $image_url = $homeData['images'][1]['url'];

	    $image = "https://mysitti.com/images/noimage-found.jpeg"; 
        		if(!empty($image_url)){
        		$image =  $image_url ;
        	}

    	
	$html .= "<div class='row ticketmaster_row'>
				  <div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
				    <a >
				      <img src= ".$image." width='150' height='63'>
		             </a>
			
				  </div>
				  <div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>

				   <div class='well new_name_formate'> 
				      ".$eventsName."
				    </div>

				    <div class='well new_address_formate'> 
				     <p>".$address1."<p><br>
				     <p>".$address2."</p>
				    </div>
				  </div>
				  <div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
				    <div class='well new_date_formate'> 
				      <p>". $nameOfDay .','.$date_foemate."</p>
				      <p>".$strtime."</p>
				    </div>
				  </div>

				  <div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
				    <div class='well btn-mor'> 
				      <a href=".$eventUrl." target='_blank'>See Tickets</a>
				    </div>
				  </div>
			</div>";
    	}
 
       }else{
       	 echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
       }
   	$html .= " <div class='next-prev'>
         <button class='prev-refine' field='quantity'>Prev</button>
					   <input type='text' value=".rawurlencode($dropdown_value)." class='drop-value' style='display:none;'>	
					  <button class='next-refine' field='quantity'>Next</button>
       </div> ";
           	echo $html;


	  ?>
