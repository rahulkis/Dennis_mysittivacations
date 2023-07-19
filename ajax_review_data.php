<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$restaurant_id = $_POST['rest_id'];


        $url = "https://developers.zomato.com/api/v2.1/reviews?res_id=".$restaurant_id."";

    	$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "User-Key: 99868269a38bfabc5532b10a32fa75c7";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);

		$data = json_decode($result);

		$get_deals = $data->user_reviews;

        $html = "";

		foreach($get_deals as $homeData){
         
         $review_text = $homeData->review->review_text;
         $review_time = $homeData->review->review_time_friendly;
         $user_name = $homeData->review->user->name;
         $profile_url = $homeData->review->user->profile_url;
         $profile_image = $homeData->review->user->profile_image;
       
		 $html .= "

		 <div class='home_list_review'>
			<div class='home_image_review'>
			<a href=".$profile_url." target='_blank'>

		      <img src= ".$profile_image." width='250' height='200'>
		      
              </a>
             
               <div class='home_city_review'>
                <h2>".$user_name."</h2>
					<h3>".$review_time."</h3><br>
					 <p style='color: black;'>".$review_text."</p>
				</div>
			

	        </div>

	        <div class='home_data_review'>
             
	        </div>
		</div>
		
		
		";
		}

		echo $html;

         
    	
?>
