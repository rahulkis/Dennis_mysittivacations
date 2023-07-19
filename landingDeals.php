<div class="container recommed-city">				
	<?php
	$address = $dropdown_city; 
	$prepAddr = str_replace(' ','+',$address);
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
   
	$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($address)."&lat=".$latitude."&lng=".$longitude."&query=activities&division=".rawurlencode($address)."&locale=en_US";

	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];

							
	?>
	<ul class="bxslider_food">
	
	<?php

	foreach ($get_deals as $homeData)
	{ ?>
		<li class="col-sm-3 city-recom">
		<div class="borderIsan">
		<a href="redirect_aff.php?logo=groupon&url=<?php echo $homeData['dealUrl']; ?>" target="_blank"><img src="<?php echo $homeData['grid4ImageUrl']; ?>"></a>
		<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank"><h2 class="nameIsan" style=" text-align: center;"><?php 
			$tourname = $homeData['merchant']['name'];; 
		echo $out = strlen($tourname) > 24 ? substr($tourname,0,24)."..." : $tourname;
		  ?></h2></a>
		<span><?php echo $homeData['division']['name']; ?></span>
		</div>
	</li>
	<?php } ?>
	</ul>
</div>