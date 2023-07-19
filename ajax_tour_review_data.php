<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$tour_id = $_POST['tourid'];


   
    $ch = curl_init();   
	

	$urlgo = "https://api.yelp.com/v3/businesses/".$tour_id."/reviews?locale=en_US";

   	curl_setopt($ch, CURLOPT_URL, $urlgo);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	$headers = array();
	$headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
    
    $get_review = json_decode($result);
    $get_review_data = $get_review->reviews;

   
      $html = "";

		foreach($get_review_data as $homeData){

	        $review_url = $homeData->url;
	        $reviews_text = $homeData->text;
	        $reviews_rating = $homeData->rating;
	        $reviews_time = $homeData->time_created;
	        $user_image = $homeData->user->image_url;
	        $user_name = $homeData->user->name; 

	        $image = "https://mysitti.com/images/noimage-found.jpeg"; 
        	if(!empty($user_image)){
        		$image = $user_image;
            }
            
		 $html .= "

		 <div class='home_list_review'>
			<div class='home_image_review yelp_review_images'>
			<a href=".$review_url." target='_blank'>

		      <img src= ".$image." width='250' height='200'>
		      
              </a>
             
               <div class='home_city_review'>
                <h2 style='color:black;'>".$user_name."</h2>
					<h3>".$reviews_time."</h3><br>
					<ul class='rating2 review_ratingd'>";

						 for($x=1;$x<=$reviews_rating;$x++) {

						 	$html .= "<li><img src='imagesNew/star.png'></li>";
						 }
						 if (strpos($reviews_rating,'.')) {

						  $html .= "<li><img src='images/halfstar.png'></li>";

							$x++;
						}
					 $html .= "</ul>
					 <p style='color: black;'>".$reviews_text."</p>
				</div>
			

	        </div>

	        <div class='home_data_review'>
             
	        </div>
		</div>
		
		
		";
		}

		echo $html;
        echo $html1 = '<a href="'.$review_url.'" class="see-more-review" target="_blank">See More Reviews</a>';  

         
    	
?>
