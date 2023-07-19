<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$value = $_POST["country_id"];

if(!empty($value)) {
	$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/GetStatesByCountryID?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7&CountryID=".$value."";
  		$xml = simplexml_load_file($completeurl);
  		
  		$get_d = json_decode( json_encode($xml), true);
      
  		$get_data = $get_d['State'];
  		$response = [];       
	        foreach ($get_data as $i => $data) {
	            $response[$i]['state'] = $data['@attributes'];
			}
      ?>
      
      <?php
  			foreach ($response as $stateList) {
  				echo "<option value='".$stateList['state']['ID']."'>".$stateList['state']['Name']."</option>";
  			}

}

?>