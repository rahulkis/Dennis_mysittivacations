<?php
	include 'Query.Inc.php';
	$Obj = new Query($DBName);
	error_reporting(0);
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	function ticketmasterApi($city, $page, $key,$trigger){
		$city = str_replace(' ','%20',strtok($city, ','));
		$page =$page;
		$key = str_replace(" ", '%20%', $key);
		if(isset($trigger)){
			$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=aITXxLf5UxV3sX4Cie3KsqpkZAipeous&keyword=".$key."&sort=date,asc&countryCode=US&page=".$page."&classificationName=[".$trigger."]";
		}else{
			$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=aITXxLf5UxV3sX4Cie3KsqpkZAipeous&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=".$page."";
		}
		// echo $urlgo;
		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		return $get_all_data; 
	}
?> 
<?php 
	$get_all_data = ticketmasterApi($_POST['formatted'], $_POST['page'], $_POST['key'],$_POST['trigger']);
	$page_size = $get_all_data['page']['size'];
	$totalPages = $get_all_data['page']['totalPages'];
	$number = $get_all_data['page']['number'];
	$get_deals = $get_all_data['_embedded']['events']; 
	if (!empty($get_deals)):
		$content = 0;
		foreach($get_deals as $homeData): 

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

			$image = "https://mysittivacations.com/images/noimage-found.jpeg"; 

			if(!empty($image_url)):
				$image = $image_url;
			endif; 
		if($content%2==0){
									$dataaos="zoom-in-right";
								}else{
									$dataaos="zoom-in-left";
								}
?>
							<div class='slide' data-aos='<?php echo $dataaos ?>'>
								
								<!-- <a href="<?php echo $eventUrl ?>" target='_blank'> -->
									<div class='discount-block'>
										<div class='cities'>
										<img src= "<?php echo $image ?>" >
										</div>
										<div class='sport-cont'>
										<div class='discount-content'>
											<h3><?php echo $eventsName ?></h3> <span><i class='fa fa-map-marker' aria-hidden='true'></i>  <?php echo $venue_name ?> </span>
										</div>
										<div class='comedy-add-details'>
											<p><i class='fa fa-map-marker' aria-hidden='true'></i><?php echo $address1."  ".$address2.", ".$city.", ".$country ?></p>
											<p><i class='fa fa-calendar' aria-hidden='true'></i> <?php echo $nameOfDay .','.$date_foemate ?></p>
											<p><i class='fa fa-clock-o' aria-hidden='true'></i> <?php echo $strtime ?></p>
										</div>
										<div class='discount-action hotels'>
											<a class='hotel-book' href="<?php echo $eventUrl ?>" target='_blank'>See Ticket </a>
										</div>
									</div>
									</div>
								<!-- </a> -->
								</div>
									<input type='hidden' value="<?php echo rawurlencode($_POST['key']); ?>" class='drop-value'>	
								<?php
								$content++;
 endforeach; ?>
		<?php if ($totalPages > 1 ) : ?>
			<?php if($number == 0 ): ?>
				<div class='next-prev'>
					<button class='pagination_btn next' field='quantity'>Next</button>
				</div>
			<?php elseif($totalPages != $number+1):?>
				<div class='next-prev'>
					<button class='pagination_btn prev' field='quantity'>Prev</button>
					<button class='pagination_btn next' field='quantity'>Next</button>
				</div>
			<?php elseif($number == $totalPages-1):?>
				<div class='next-prev'>
					<button class='pagination_btn prev' field='quantity'>Prev</button>
				</div>
			<?php endif; ?> 
		<?php endif; ?>
	<?php else: ?>
		<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h1>
	<?php endif; ?>
