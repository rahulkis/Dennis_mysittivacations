<?php
	// ini_set('display_errors', 'On');
	// error_reporting(E_ALL | E_STRICT);
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
if($_POST['trigger'] == 'sidebar-tm-deal'){
	if(empty($_POST['endDateTime'])){
		if(isset($_POST['genric_dropdown'])){
			$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+', $_POST['genric_dropdown'])."&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."";

		}else{
			$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Music&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&classificationName=".$_POST['keyword']."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."";
		}
	}else{
		if(isset($_POST['genric_dropdown'])){
			$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+', $_POST['genric_dropdown'])."&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."&endDateTime=".$_POST['endDateTime']."";
		}else{

			$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Music&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&classificationName=".$_POST['keyword']."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."&endDateTime=".$_POST['endDateTime']."";
		}
	}
}
if(isset($_POST['doropdown'])){
	if(empty($_POST['endDateTime'])){
		$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+',$_POST['doropdown'])."&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."";
	}else{
		$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+',$_POST['doropdown'])."&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."&endDateTime=".$_POST['endDateTime']."";
	}
}
if(isset($_POST['genre'])){
	$_POST['genre'] = (empty($_POST['genre'])) ? 'Sports' : $_POST['genre'];
	if(empty($_POST['endDateTime'])){
		$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+',$_POST['key'])."&sort=date,asc&countryCode=US&page=0&classificationName=".$_POST['genre']."&startDateTime=".$_POST['startDateTime']."";
	}else{
		$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+',$_POST['key'])."&sort=date,asc&countryCode=US&page=0&classificationName=".$_POST['genre']."&startDateTime=".$_POST['startDateTime']."&endDateTime=".$_POST['endDateTime']."";
	}
		// echo $filter_url;
}
	// echo"<pre>";
	// print_r($filter_url);
	// die;

$get_all_data = ticketmasterApi($_POST['formatted'], $_POST['page'], $_POST['key'],$_POST['trigger'],$filter_url);
 	// echo $get_all_data;
 	// print_r($get_all_data);
 	// die();
$page_size = $get_all_data['page']['size'];
$totalPages = $get_all_data['page']['totalPages'];
$number = $get_all_data['page']['number'];
$get_deals = $get_all_data['_embedded']['events'];
if (!empty($get_deals)) : ?>	    
	<?php if($_POST['trigger'] == 'sidebar-tm-deal'): 
		foreach ($get_deals as $homeData):
			if($homeData['dates']['status']['code'] != 'cancelled'){
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

				$image = "https://mysittivacations.com/images/noimage-found.jpeg"; 

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
			<?php } endforeach; ?>
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
				$venue_name =$address1 = $homeData['_embedded']['venues'][0]['name'];
				$time = $homeData['dates']['start']['localTime'];
				$strtime = date('h:i A', strtotime($time));
				$city = $homeData['_embedded']['venues'][0]['city']['name'];
				$state = $homeData['_embedded']['venues'][0]['state']['name'];
				$country = $homeData['_embedded']['venues'][0]['country']['countryCode'];
				$address1 = $homeData['_embedded']['venues'][0]['address']['line1'];
				$address2 = $homeData['_embedded']['venues'][0]['address']['line2'];
				$image_url = $homeData['images'][1]['url'];

				$image = "https://mysitti.com/images/noimage-found.jpeg"; 

				if(!empty($image_url)):
					$image = $image_url;
				endif;
				if($_POST['datattr'] == 'Giants'){
					if (strpos($eventsName, 'Mets') == false) {
						
						$html .= '<div class="hotel_listitem sports_listing p-lg-0">
								<div class="hotel_img">
								<div class="image_htfix">
								<a href=" '.$eventUrl .' " target="_blank">
								<img src= "'.$image.'" class="img-fluid">
								</a>
								</div>
								</div>
								<div class="hotel_details resturant_sprecification">
								<div class="loc_details">
								<div class="hotel_name">
								<h5><a href=" '.$eventUrl .' " target="_blank">'.$eventsName.'</a></h5>
								</div>
								<div class="resturant_specl">
								<div class="resto_type">
								<p><i class="fa fa-map-marker"></i> '.$venue_name.'</p>
								</div>

								</div>
								</div>
								<div class="restro_btns">
								<div class="restro_deals">
								<p><i class="fa fa-map-marker"></i> '.$address1 . "" . $address2.'</p>
								</div>

								<div class="hotel_rating">
								<h6 class="mb-2"><?php echo $tour_name; ?></h6>
								<p class="contacts"><i class="fas fa-calendar"></i> '. $nameOfDay .','.$date_foemate.' </p>
								<p class="contacts"><i class="fas fa-clock"></i>'.$strtime.'</p>
								</div>
								</div>
								<div class="restro_btns">
								<div class="restro_deals_new">
								
								</div>

								<div class="hotel_rating">

								<div class="restro_deals_btn_new">
								<a href=" '.$eventUrl .' "  target="_blank" class="restro_btn">
								See Ticket
								</a>
								</div>
								
								</div>
								</div>
								</div>
								</div>';

					}
				}else{
					$html .= '<div class="hotel_listitem sports_listing p-lg-0">
								<div class="hotel_img">
								<div class="image_htfix">
								<a href=" '.$eventUrl .' " target="_blank">
								<img src= "'.$image.'" class="img-fluid">
								</a>
								</div>
								</div>
								<div class="hotel_details resturant_sprecification">
								<div class="loc_details">
								<div class="hotel_name">
								<h5><a href=" '.$eventUrl .' " target="_blank">'.$eventsName.'</a></h5>
								</div>
								<div class="resturant_specl">
								<div class="resto_type">
								<p><i class="fa fa-map-marker"></i> '.$venue_name.'</p>
								</div>

								</div>
								</div>
								<div class="restro_btns">
								<div class="restro_deals">
								<p><i class="fa fa-map-marker"></i> '.$address1 . "" . $address2.'</p>
								</div>

								<div class="hotel_rating">
								<h6 class="mb-2"><?php echo $tour_name; ?></h6>
								<p class="contacts"><i class="fas fa-calendar"></i> '. $nameOfDay .','.$date_foemate.' </p>
								<p class="contacts"><i class="fas fa-clock"></i>'.$strtime.'</p>
								</div>
								</div>
								<div class="restro_btns">
								<div class="restro_deals_new">
								
								</div>

								<div class="hotel_rating">

								<div class="restro_deals_btn_new">
								<a href=" '.$eventUrl .' "  target="_blank" class="restro_btn">
								See Ticket
								</a>
								</div>
								
								</div>
								</div>
								</div>
								</div>';
				} endforeach; echo $html;?>
				
					<?php if ($totalPages > 1 ) : ?>
						<div class='pagination'>
						<?php if($number == 0 ): ?>
							<input type='text' value="<?php echo rawurlencode($dropdown_value); ?>" class='drop-value' style='display:none;'>	
							<button class='pagination_btn next-refine next' field='quantity'>Next</button>
							
							<?php elseif($totalPages != $number+1):?>
								<button class='pagination_btn prev-refine' field='quantity'>Previous</button>
							
							<input type='text' value="<?php echo rawurlencode($dropdown_value); ?>" class='drop-value' style='display:none;'>	
							<button class='pagination_btn next-refine' field='quantity'>Next</button>
								<?php elseif($number == $totalPages-1):?>
									<button class='pagination_btn prev-refine' field='quantity'>Previous</button>
								<?php endif; ?>
								</div> 
							<?php endif; ?>
						<?php endif; ?>
					
					<?php else: ?>
						<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h1>
					<?php endif; ?>
