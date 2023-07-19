<?php

header('Content-Type: application/json');

function ticket_master_api_call($category, $term)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(

	CURLOPT_URL => "https://app.ticketmaster.com/discovery/v2/".$category."?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&countryCode=US&keyword=".$term."",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"Cache-Control: no-cache",
		"Postman-Token: 14f4c548-bf32-463b-ad2b-5b5a244cd13d",
		"X-API-KEY: 1e3ee15f01afef534836990e31447c4038b6ccfd"
		),
	));

	$result = curl_exec($curl);
	$err = curl_error($curl);

	$data = [];
	curl_close($curl);

	return ($err) ? [] : json_decode($result, true);
}

$term = str_replace(' ', '%20', trim(strip_tags($_GET['query'])));
// echo "<pre>";
// print_r($term);
// echo "</pre>";
// die;

$response = [];

if (!empty($term)) {
	$i = 0;

	$events = ticket_master_api_call('events', $term);
	$events = (count($events) > 0 && isset($events['_embedded']['events']) ) ? $events['_embedded']['events'] : [];

	$venues = ticket_master_api_call('venues', $term);
	$venues = (count($venues) > 0 && isset($venues['_embedded']['venues']) ) ? $venues['_embedded']['venues'] : [];

	$attractions = ticket_master_api_call('attractions', $term);
	$attractions = (count($attractions) > 0 && isset($attractions['_embedded']['attractions']) ) ? $attractions['_embedded']['attractions'] : [];
	
	foreach ($attractions as $attraction) {

		if (empty($attraction['images']['3']['url'])) {
			$imageUrl = "../images/placeholder_event.png";
		}
		else{
			$imageUrl = $attraction['images']['3']['url'];
		}

		$response[$i]=['value' => $attraction['name'],'data'=>['category'=>'Attractions' ,'date' => '','class'=>$attraction['classifications']['0']['segment']['name'] , 'img'=>$imageUrl, 'url'=>$attraction['url']]];
		$i++;
	}

	foreach ($events as $event) {
		if (empty($event['images']['3']['url'])) {
			$imageUrl = "../images/placeholder_event.png";
		}
		else{
			$imageUrl = $event['images']['3']['url'];
		}

		$dateTime = $event['dates']['start']['dateTime'];

		$date = date("F j, Y, g:i a", strtotime($dateTime));

		$response[$i]=['value' => $event['name'],'data'=>['category'=>'Events','class'=>'','img'=>$imageUrl,'date' => $date ,'url'=>$event['url']]];
		$i++;
	}

	foreach ($venues as $venue) {
		
		if (empty($venue['images']['0']['url'])) {
			$imageUrl = "../images/placeholder_venue.png";
		}
		else{
			$imageUrl = $venue['images']['0']['url'];
		}

		$response[$i]=['value' => $venue['name'],'data'=>['category'=>'Venues','date' => '' ,'class'=>'','img'=>$imageUrl, 'url'=>$venue['url']]];
		$i++;
	}
	
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// die;
	$data = [
	  'query' => 'Unit',
	  'suggestions' => $response
	];

	$json = json_encode($data);

	// echo "<pre>";
	// print_r($json);
	// echo "</pre>";
	// die;

	echo $json;		

	// foreach ($events as $event) {
	// 	$response[$i]=['value' => $curlData['name'],'data'=>['category'=>'Events', 'img'=>'https://source.unsplash.com/user/erondu/50x50']];
	// 	$i++;
	// }



}




