<?php
// echo "Today is " . date("Y/m/d") . "<br>";
// echo "Today is " . date("Y.m.d") . "<br>";
// echo "Today is " . date("Y-m-d") . "<br>";
// echo "Today is " . date("l"). "<br>";
// echo date('Y-m-d H:i:s', strtotime('+1 hour')). "<br>";
// $UTC = new DateTimeZone("UTC");
// // $newTZ = new DateTimeZone("America/New_York");
// $date = new DateTime( date('Y-m-d H:i:s'), $UTC );
// $date->setTimezone( $UTC );
// echo $date->format('Y-m-d H:i:sa'). "<br>";
include("Query.Inc.php");
$Obj = new Query($DBName);

require 'mailwizz_setup.php';
$endpoint = new MailWizzApi_Endpoint_ListSubscribers(); 
$mwcampaign = new MailWizzApi_Endpoint_Campaigns();
$mailwizzTemplates = new MailWizzApi_Endpoint_Templates();

$titleofpage="Survey Questionnaire"; 

$email_url = 'ashish.chauhan@kindlebit.com';

////////////////////////
// API call functions //
////////////////////////


function ticket_master_api_call($city, $eventname)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(

	CURLOPT_URL => "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&city=".$city."&keyword=".$eventname."&size=4",

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
///////////////////////////////
//Loops to get data from API //
///////////////////////////////

// for ($i=0; $i < count($cities) ; $i++) { 
// 	if(!empty($cities[$i])){
// 		// echo $cities[$i].', <br>';
// 		for ($j=0; $j < count($musics); $j++) { 
// 			if (!empty($musics[$j])) {
// 				// echo $musics[$j].', <br>';
// 				$events = ticket_master_api_call(preg_replace('/\s+/', '%20', $cities[$i]), $musics[$j]);
// 				$events = (count($events) > 0 && isset($events['_embedded']['events']) ) ? $events['_embedded']['events'] : [];

// 				if (!empty($events['0']['name'])) {
// 					$music_imageUrl[] = $events['0']['images']['3']['url'];

// 					$dateTime = $events['0']['dates']['start']['dateTime'];

// 					$music_date[] = date("j/F/Y g:i a", strtotime($dateTime));

// 					$music_event[] = $events['0']['name'];

// 					$music_eventurl[] = $events['0']['url'];
// 				}
// 			}
// 		}
// 	}
// }
// $events = ticket_master_api_call('Chicago', 'comedy');
// $events = (count($events) > 0 && isset($events['_embedded']['events']) ) ? $events['_embedded']['events'] : [];
// // echo "<pre>";
// // print_r($events);
// // echo "</pre>";
// foreach ($events as $event) {
// 	$music_imageUrl[] = $event['images']['3']['url'];
// 	$dateTime = $event['dates']['start']['dateTime'];
// 	$music_date[] = date("j/F/Y g:i a", strtotime($dateTime));
// 	$music_date[] = date("j/F/Y g:i a", strtotime($event['dates']['start']['dateTime']));

// 	$music_event[] = $event['name'];

// 	$music_eventurl[] = $event['url'];
// }
// echo "<pre>";
// print_r($music_imageUrl);
// print_r($music_date);
// print_r($music_event);
// print_r($music_eventurl);
// echo "</pre>";
// // // Pause/Unpause CAMPAIGN
// // $response0 = $mwcampaign->pauseUnpause('ne306acwn86df');
// // // DISPLAY RESPONSE
// // echo '<hr /><pre>';
// // print_r($response0->body);
// // echo '</pre>';
// // GET ONE ITEM
// $response2 = $mwcampaign->getCampaign('kb283myz729e0');
// // DISPLAY RESPONSE
// echo '<pre>';
// print_r($response2->body);
// echo '</pre>';
// $music_response = $endpoint->emailSearchAllLists($email_url);
// $music_response = $endpoint->create('ys172c64md909', array(
// 	'EMAIL'     => $email_url, // the confirmation email will be sent!!! Use valid email address
// 	'IMGLINK1'  => $music_imageUrl['0'],
// 	'EVENTNAME1'=> $music_event['0'],
// 	'EVENTDATE1'=> $music_date['0'],
// 	'EVENTLINK1'=> $music_eventurl['0'],
// 	'IMGLINK2'  => $music_imageUrl['1'],
// 	'EVENTNAME2'=> $music_event['1'],
// 	'EVENTDATE2'=> $music_date['1'],
// 	'EVENTLINK2'=> $music_eventurl['1'],
// 	'IMGLINK3'  => $music_imageUrl['2'],
// 	'EVENTNAME3'=> $music_event['2'],
// 	'EVENTDATE3'=> $music_date['2'],
// 	'EVENTLINK3'=> $music_eventurl['2'],
// 	'IMGLINK4'  => $music_imageUrl['3'],
// 	'EVENTNAME4'=> $music_event['3'],
// 	'EVENTDATE4'=> $music_date['3'],
// 	'EVENTLINK4'=> $music_eventurl['3']
// ));
// echo "<pre>";
// print_r($music_response);
// echo "</pre>";
// $api_message = $music_response->body->toArray();
// // if ($api_message['status'] == 'error') {
// // 	echo "<script type='text/javascript'>alert('Thank you for valueable time. Subscriber you are already exists in our music list'); window.location.href = 'https://mysitti.com/'</script>";
// // }
// $response1 = $mwcampaign->update('kb283myz729e0', array(
//     'send_at'       => date('Y-m-d H:i:s', strtotime('+3 minutes')), //optional at update, this will use the timezone which customer selected
//     'list_uid'      => 'ys172c64md909', // optional at update
    
//     // optional block, defaults are shown
//     'options' => array(
//         'url_tracking'      => 'yes', // yes | no 
//         'json_feed'         => 'yes', // yes | no 
//         'xml_feed'          => 'yes', // yes | no  
//         'plain_text_email'  => 'yes',// yes | no 
//         'email_stats'       => null, // a valid email address where we should send the stats after campaign done
//     ),
// ));
// echo '<hr /><pre>';
// print_r($response1->body);
// echo '</pre>';

// // Pause/Unpause CAMPAIGN
// $response = $mwcampaign->pauseUnpause('kb283myz729e0');
// // DISPLAY RESPONSE
// echo '<hr /><pre>';
// print_r($response->body);
// echo '</pre>';

// // // Pause/Unpause CAMPAIGN
// // $response3 = $mwcampaign->pauseUnpause('kb283myz729e0');
// // // DISPLAY RESPONSE
// // echo '<hr /><pre>';
// // print_r($response3->body);
// // echo '</pre>';
// 
// GET ALL ITEMS
$responsetem = $mailwizzTemplates->getTemplates($pageNumber = 1, $perPage = 100);
// DISPLAY RESPONSE
echo '<pre>';
print_r($responsetem->body);
echo '</pre>';