<?php
	// ini_set('display_errors', 'On');
	// error_reporting(E_ALL | E_STRICT);
$json = file_get_contents('php://input');
$someArray = json_decode($json, true);
	include 'Query.Inc.php';
	$Obj = new Query($DBName);
	error_reporting(0);
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	function ticketmasterApi($city, $page, $key,$trigger,$filter_url){
		if($city == 'Washington D.C.'){
			$city = 'Washington';
		}elseif($dropCity == 'Washington DC'){
			$city = 'Washington';
		}
		$city =str_replace(' ','%20',strtok($city, ',')) ;
		$key =str_replace(' ','+',$key) ;
		$page =$page;
		if (isset($page)) :
			if(isset($trigger)):
				$key = (empty($key)) ?  $city : $key;
				$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=".$page."&classificationName=[".$trigger."]";
			else:
				$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=".$page."";
			endif;
				
		else:
			if(isset($trigger)):
				$key = (empty($key)) ? $city : $key;
				$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=0&classificationName=[".$trigger."]";
			else:
				$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=0";
			endif;
		endif;
		if(isset($filter_url)){
			$urlgo = $filter_url;
		}
		 //echo $urlgo;
		 //die;
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $urlgo,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
    		"Postman-Token: 52ec54df-357c-4ae0-a02c-d6a9910d626d",
		    "cache-control: no-cache"
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  return json_decode($response, true);
		}
		// return $response; 
	}
	function str_limit($value, $limit = 100, $end = '') {
	    if (mb_strlen($value) <= $limit) {
	      return $value;
	    }
		return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
	}

?>
     
	
 <?php 
 	if($someArray['trigger'] == 'sidebar-tm-deal'){
 		if(empty($someArray['endDateTime'])){
 			if(isset($someArray['genric_dropdown'])){
 				$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+', $someArray['genric_dropdown'])."&city=".str_replace(' ','%20',strtok($someArray['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$someArray['startDateTime']."";

 			}else{
				$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Music&city=".str_replace(' ','%20',strtok($someArray['formatted'], ','))."&classificationName=".$someArray['keyword']."&sort=date,asc&countryCode=US&page=0&startDateTime=".$someArray['startDateTime']."";
 			}
		}else{
			if(isset($someArray['genric_dropdown'])){
				$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+', $someArray['genric_dropdown'])."&city=".str_replace(' ','%20',strtok($someArray['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$someArray['startDateTime']."&endDateTime=".$someArray['endDateTime']."";
 			}else{
				
				$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Music&city=".str_replace(' ','%20',strtok($someArray['formatted'], ','))."&classificationName=".$someArray['keyword']."&sort=date,asc&countryCode=US&page=0&startDateTime=".$someArray['startDateTime']."&endDateTime=".$someArray['endDateTime']."";
			}
		}
 	}
 	$get_all_data = ticketmasterApi($someArray['formatted'], $someArray['page'], $someArray['key'],$someArray['trigger'],$filter_url);
 	// echo $get_all_data;
 	// print_r($get_all_data);
 	// die();
 	$page_size = $get_all_data['page']['size'];
	$totalPages = $get_all_data['page']['totalPages'];
	$number = $get_all_data['page']['number'];
	$get_deals = $get_all_data['_embedded']['events'];
 	if (!empty($get_deals)) : ?>	    
			<?php if($someArray['trigger'] == 'sidebar-tm-deal'): 
					foreach ($get_deals as $homeData):

			    	// echo"<pre>";
			    	// // print_r($homeData);
			    	// echo $homeData['_embedded']['venues'][0]['address']['line1'];
			    	// echo"</pre>";
			    	// die();
					$eventsName = $homeData['name'];
					$eventUrl = $homeData['url'];
					$start_date = $homeData['dates']['start']['localDate'];

					$timestamp = strtotime($start_date);
					$date_foemate = date('m/d/Y', $timestamp);

					$nameOfDay = date('D', strtotime($start_date));
					$nameOfMonth = date('M', strtotime($start_date));
			   		$dateName = date('d', strtotime($start_date));

					$time = $homeData['dates']['start']['localTime'];
					$strtime = date('h:i A', strtotime($time));

					$address1 = $homeData['_embedded']['venues'][0]['address']['line1'];
					$address2 = $homeData['_embedded']['venues'][0]['address']['line2'];
					$image_url = $homeData['images'][1]['url'];

					$image = "https://mysitti.com/images/noimage-found.jpeg"; 
					
					if(!empty($image_url)):
						$image = $image_url;
					endif;
			?>
				<div class="row new-h">
		  			<div class="col-sm-12" style="color:black;">
					    <div class="well di"> 
					    	<h2><?php echo str_limit($eventsName,30,'...'); ?> </h2>
					    	<h3><?php echo $homeData['_embedded']['venues'][0]['name']; ?></h3>
					    	<p><?php echo $address1; ?>, <?php echo $homeData['_embedded']['venues'][0]['city']['name'].", ".$homeData['_embedded']['venues'][0]['state']['name']; ?></p>
							<!-- <p><?php echo $homeData['_embedded']['venues'][0]['country']['name']; ?></p> -->
					    </div>
				  	</div>
				  	<div class="col-sm-4 col-xs-4" style="color:black;">
					    <div class="well change_date_formaet">
				     		<p class="monthName"><?php echo $nameOfMonth; ?> </p>
					     	<p><?php echo $dateName; ?> </p>
					     	<p><?php echo $nameOfDay; ?> </p> 
					    </div>
				  	</div>
				  	<div class="col-sm-5 col-xs-6" style="color:black;">
					    <div class="well chnage_formate"> 
				      		<p>Goes On Sale:</p>
			     		 	<p><?php echo $nameOfDay; ?>,<?php echo $date_foemate; ?> </p>
					    </div>
			  		</div>

				  	<div class="col-sm-3 col-xs-3" style="color:black;">
				   		<div class="well btn-mor event_url"> 
				      		<a href="<?php echo $eventUrl; ?>"  target="_blank">More Info</a>
				   		 </div>
				  	</div>
				</div>
		<?php endforeach; ?>
			<?php else: 
					foreach ($get_deals as $homeData):
			    	// echo"<pre>";
			    	// // print_r($homeData);
			    	// echo $homeData['_embedded']['venues'][0]['address']['line1'];
			    	// echo"</pre>";
			    	// die();
					$eventsName = $homeData['name'];
					$eventUrl = $homeData['url'];
					$start_date = $homeData['dates']['start']['localDate'];

					$timestamp = strtotime($start_date);
					$date_foemate = date('m/d/Y', $timestamp);

					$nameOfDay = date('D', strtotime($start_date));
					$nameOfMonth = date('M', strtotime($start_date));
			   		$dateName = date('d', strtotime($start_date));

					$time = $homeData['dates']['start']['localTime'];
					$strtime = date('h:i A', strtotime($time));

					$address1 = $homeData['_embedded']['venues'][0]['address']['line1'];
					$address2 = $homeData['_embedded']['venues'][0]['address']['line2'];
					$image_url = $homeData['images'][1]['url'];

					$image = "https://mysitti.com/images/noimage-found.jpeg"; 
					
					if(!empty($image_url)):
						$image = $image_url;
					endif;
						if($someArray['datattr'] == 'Giants'){
								if (strpos($eventsName, 'Mets') == false) {
									?>
				<div class='row ticketmaster_row'>
				  	<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black; text-align: left;'>
					    <!-- <a > -->
					      	<img src= "<?php echo $image; ?>" width='150' height='63'>
						   	<div class='well new_name_formate'> 
						      	<?php echo $eventsName; ?>
					    	</div>
			         	<!-- </a> -->

				  	</div>
				  	<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>


					    <div class='well new_address_formate'> 
					     <p><?php echo $homeData['_embedded']['venues'][0]['name']; ?></p>
					     <p><?php echo $address1; ?></p>
					     <p><?php echo $address2; ?></p>
					     <p><?php echo $homeData['_embedded']['venues'][0]['city']['name'].", ".$homeData['_embedded']['venues'][0]['state']['name']; ?></p>
					     <p><?php echo $homeData['_embedded']['venues'][0]['country']['name']; ?></p>
					    </div>
				  	</div>
				  	<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
				    	<div class='well new_date_formate'> 
					      	<p><?php echo $nameOfDay.','.$date_foemate; ?></p>
					      	<p><?php echo $strtime; ?></p>
					    </div>
				  	</div>

		  			<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
					    <div class='well btn-mor'> 
					      	<a href="<?php echo $eventUrl; ?>" target='_blank'>See Tickets</a>
					    </div>
				  	</div>
				</div>
				<?php
						}
					}else{
			?>
				<div class='row ticketmaster_row'>
				  	<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black; text-align: left;'>
					    <!-- <a > -->
					      	<img src= "<?php echo $image; ?>" width='150' height='63'>
						   	<div class='well new_name_formate'> 
						      	<?php echo $eventsName; ?>
					    	</div>
			         	<!-- </a> -->

				  	</div>
				  	<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>


					    <div class='well new_address_formate'> 
					     <p><?php echo $homeData['_embedded']['venues'][0]['name']; ?></p>
					     <p><?php echo $address1; ?></p>
					     <p><?php echo $address2; ?></p>
					     <p><?php echo $homeData['_embedded']['venues'][0]['city']['name'].", ".$homeData['_embedded']['venues'][0]['state']['name']; ?></p>
					     <p><?php echo $homeData['_embedded']['venues'][0]['country']['name']; ?></p>
					    </div>
				  	</div>
				  	<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
				    	<div class='well new_date_formate'> 
					      	<p><?php echo $nameOfDay.','.$date_foemate; ?></p>
					      	<p><?php echo $strtime; ?></p>
					    </div>
				  	</div>

		  			<div class='col-sm-3 col-xs-12 ticketmaster_maindata' style='color:black;'>
					    <div class='well btn-mor'> 
					      	<a href="<?php echo $eventUrl; ?>" target='_blank'>See Tickets</a>
					    </div>
				  	</div>
				</div>
		<?php } endforeach; ?>
				<?php if ($totalPages > 1 ) : ?>
					<?php if($number == 0 ): ?>
						<div class='next-prev'>
							<button class='next' field='quantity'>Next</button>
						</div>
					<?php elseif($totalPages != $number+1):?>
						<div class='next-prev'>
							<button class='prev' field='quantity'>Prev</button>
							<button class='next' field='quantity'>Next</button>
						</div>
					<?php elseif($number == $totalPages-1):?>
						<div class='next-prev'>
							<button class='prev' field='quantity'>Prev</button>
						</div>
					<?php endif; ?> 
				<?php endif; ?>
			<?php endif; ?>
			
	<?php else: ?>
		<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h1>
	<?php endif; ?>
