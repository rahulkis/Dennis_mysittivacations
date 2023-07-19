<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$value = $_POST["state_id"];

if(!empty($value)) {
	$completeurl = "https://www.ticketcity.com/ws/xmlticketapiv3/xmlticketapiv3.asmx/GetCitiesByStateID?APIKey=e040f13b-094b-4b35-8aa0-2b10c1adc8e7&StateID=".$value."";
  		$xml = simplexml_load_file($completeurl);
  		
  		$get_d = json_decode( json_encode($xml), true);
      
  		$get_data = $get_d['City'];
  		$response = [];       
	        foreach ($get_data as $i => $data) {
	            $response[$i]['city'] = $data['@attributes'];
			} ?>
      <option value="">Select City</option>
      <?php
  			foreach ($response as $cityList) {
  				echo "<option value='".$cityList['city']['ID']."'>".$cityList['city']['Name']."</option>";
  			}

}

?>