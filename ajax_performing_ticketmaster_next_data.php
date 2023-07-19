<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$city = $_POST['formatted'];
$page = $_POST['page'];

$city_name_query = @mysql_query("SELECT dma_id, country_name FROM us_country_dma WHERE country_name ='".$city."'");

$get_city_name = mysql_fetch_assoc($city_name_query);

$city_dma_id = $get_city_name['dma_id']; 

$url = "https://app.ticketmaster.com/discovery/v2/classifications?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Arts+and+Theater&preferredCountry=us";

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



	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&sort=date,asc&countryCode=US&classificationId=".$ids."&dmaId=".$city_dma_id."&page=".$page."";

     
		$result_get = file_get_contents($urlgo);

		$get_all_data = json_decode($result_get, true);
         
        $page_size = $get_all_data['page']['size'];
        $totalPages = $get_all_data['page']['totalPages'];
        $number = $get_all_data['page']['number'];
  
	    $get_deals = $get_all_data['_embedded']['events'];


	  	?>
     
	
	 <?php 

	 if(!empty($get_deals)){
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
        		$image = $image_url;
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
    	echo $html;

        }else{

        	echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
        }

    	echo $html1 = "<div class='next-prev'><button class='prev' field='quantity'>Prev</button>
						
						<button class='next' field='quantity'>Next</button></div>";
					

	  ?>
