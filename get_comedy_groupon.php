<?php 

include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";


$drop_city = $_POST['formatted'];

$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$drop_city."&query=comedy&division=".$drop_city."&locale=en_US";
			
$result_get = file_get_contents($urlgo);
$get_all_data = json_decode($result_get, true);
$get_deals = $get_all_data['deals'];

$html = '';

foreach ($get_deals as $homeData){
  
  $html .= "<li class='col-sm-3 col-md-3 col-xs-12' style='float: left; list-style: none; position: relative; width: 260px;'>
			<div class='m_1'>
				<a href='".$homeData['dealUrl']."' target='_blank'>
					<img src='".$homeData['grid4ImageUrl']."'>
				</a>
			</div>
			<h3 class='up'>	
				<a href='".$homeData['dealUrl']."' target='_blank'>";
				$tourname = $homeData['merchant']['name']; 
				$out = strlen($tourname) > 44 ? substr($tourname,0,44)."..." : $tourname;
				$html .= "".$out."</a>
			</h3>	
			<dd class='pri_ce'>".$homeData['division']['name']."</dd>
		</li>";		
 
 } 

 echo $html;















 ?>