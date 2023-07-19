<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$location = $_POST['formatted'];


$post_limit = 30;


	if($location != "") // this for side search bar
	{
		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$location."&query=Family+activities&division=".$location."&locale=en_US&limit=".$post_limit." ";

	} 

		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];

       $html = "";
   
		foreach($get_deals as $homeData){

		 $html .= "
		    <div class='home_list'>
			<div class='new-home-image'>
		      <img src= '".$homeData['grid4ImageUrl']."' width='250' height='200'>   	   	
	        </div>
	        <div class='home_data'>
             <h2><a href= '".$homeData['dealUrl']."' target='_blank'>
               '".$homeData['merchant']['name']."'</a></h2>
               <div class='home_city'>
					<span>'".$homeData['announcementTitle']."'</span><br>
					<h3>'".$homeData['division']['name']."'</h3><br>
					<p><label>Key Highlights: </label></br>
					 '".$homeData['highlightsHtml']."'
					</p>
					<p>'".$homeData['title']."'</p>
				</div>
	        </div>
	        <div class='home_price'>
				<li>
					<a href='".$homeData['dealUrl']."' class='homeLink' target='_blank'>Get Deal</a>
				</li>
			</div>
			</div>";
		
		}
		echo $html;						  
	
         
    	
?>