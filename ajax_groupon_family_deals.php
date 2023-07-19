<?php
	include 'Query.Inc.php';
	$Obj = new Query($DBName);
	error_reporting(0);
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

	$dropCity = strtok($_POST['formatted'], ',');
	$prepAddr = str_replace(' ','-',$dropCity);
	$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_201236_212556_0&division_id=".$prepAddr."&offset=0&limit=5";
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
?>	
<?php 
	foreach ($get_deals as $homeData)
	{

		$price = $homeData['options'][0]['price']['formattedAmount'];
		$value = $homeData['options'][0]['value']['formattedAmount'];
		$discountPercent = $homeData['options'][0]['discountPercent'];
		$endAt = 	$homeData['options'][0]['endAt'];
		$endDate = date('m/d/Y', strtotime($endAt));
		$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
		$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
		$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
		$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
	    	
		$html .= "<li class='col-sm-3 city-recom' style='float: left; list-style: none; position: relative; width: 290px;'>
					<div class='borderIsan hotelandingDeal'>
						<a href='".$homeData['dealUrl']."' target='_blank'>
							<img src='".$homeData['grid4ImageUrl']."'>
						</a>
						<a href='".$homeData['dealUrl']."' target='_blank'>";
						$tourname = $homeData['merchant']['name']; 
						$out = strlen($tourname) > 24 ? substr($tourname,0,24)."..." : $tourname;
						$html .= "<h2 class='discountPercent'>".$discountPercent. '% Off'."</h2><h1 class='nameIsan hotelandingnameIsan' style= 'text-align: center;'>".$out."</h1></a>
						<h1 class='pricelanding'>".$price. "</h1><h2 class='valuelanding'>".$value."</h2>
						<h1 class='saleend'>".'Sales Ends: ' .$endDate."</h1>

					</div>
				</li>";
    	}	
	echo $html;
?>
