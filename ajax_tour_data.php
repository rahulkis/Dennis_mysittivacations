<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$uuid = $_POST['formatted'];

    
   $ch = curl_init();

   $url = "https://api.izi.travel/mtgobjects/".$uuid."?languages=en,nl,ru";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


	$headers = array();
	$headers[] = "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);

	$get_deals = json_decode($result);

    $content_provider_uuid = $get_deals[0]->content_provider->uuid;
    $audio_uiid = $get_deals[0]->content[0]->audio[0]->uuid;
    $image_uiid = $get_deals[0]->content[0]->images[0]->uuid;
    $des =  $get_deals[0]->content[0]->desc;
    $title = $get_deals[0]->content[0]->title;

    $audio_url = "https://media.izi.travel/".$content_provider_uuid."/".$audio_uiid.".m4a";

    $image_url = 'https://media.izi.travel/'.$content_provider_uuid.'/'.$image_uiid.'_800x600.jpg';


    $html .= "

		 <div class='home_list home_list_pop'>

		   <h2>".$title."</h2>

		   <audio controls id='myAudio' >
			  <source src= ".$audio_url." type='audio/mp3'>
			</audio>

			<div class='home_image home_pop_img'>
			<a>
		      <img src= ".$image_url.">
		      
              </a>
	        </div>

	        <div class='home_data'>
               <div class='home_city'>
               <h3>".$des."</h3>
				</div>
	        </div>
		</div>
		
		
		";

	echo $html;


?>
     
