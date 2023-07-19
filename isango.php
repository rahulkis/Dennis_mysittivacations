<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Breweries/Wineries"; 

if(isset($_SESSION['user_id']))

{
	include('NewHeadeHost.php'); // login
}

else
{
	include('Header.php');	// not login
}
?>

<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">  	
		  	<?php
		  		if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
					$session_city_name = empty($_SESSION['city_name']) ? $_SESSION['formatteds'] : $_SESSION['city_name'];
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$session_city_name."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];
				}elseif(!empty($_GET['city'])){
					$dropdown_city = $_GET['city'];
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_GET['city']."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];
				}else{
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];

				}
			?>
						
			<div id="loader"></div>
				
			<div class="container">
				<div class="planTap">
					Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>
			</div>
		</div>
		<div class="clear"></div>	
		<div class="container recommed-city brewery-desktop">
			<div class="brewery-groupon-deals">
			
			</div>
		</div>
<?php
///////////////
// Variables //
///////////////
$response = [
  'data' => [],
  'msg' => '',
];
// $key_city = $_SESSION['city_name'];
$key_city = "Chicago";

/////////////////////
// Api functions   //
/////////////////////
function isangoAccessTokenApi(){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://apistaging.isango.com/token",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "grant_type=password&username=stagingAPI&password=St%40ging123",
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: application/x-www-form-urlencoded",
	    "Postman-Token: 8501a77e-9a73-44ea-9d49-fd91c109ace3",
	    "cache-control: no-cache"
	  ),
	));

	$crul_response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	if ($err) {
	 	$response['msg'] 		= "cURL Error";
	 	$response['data'] 		= "cURL Error #:" . $err;
	} else {
	  	$response['msg'] 		= "Success" ;
		$response['data']   	= json_decode($crul_response, true);
	}
	// $response = ($err) ? $response['msg'] = "cURL Error #:" . $err : $response['data'] = json_decode($crul_response,  true);
	return $response;
}
function isangoApi($url,$acces_token){
	// $response = "Authorization: Bearer ".$acces_token;
	// return $response; 
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer ".$acces_token,
	    "Postman-Token: 3415f78f-e67e-4879-b5ae-00e16cec1d9a",
	    "cache-control: no-cache"
	  ),
	));

	$crul_response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	 	$response['msg'] 		= "cURL Error";
	 	$response['data'] 		= "cURL Error #:" . $err;
	} else {
	  	$response['msg'] 		= "Success" ;
		$response['data']   	= json_decode($crul_response, true);
	}
	return $response;
}
$access_token = isangoAccessTokenApi();
$access_token = $access_token['data']['access_token'];
// echo $access_token; 
$api_result  = isangoApi("http://apistaging.isango.com/DestinationList/v2", $access_token);

foreach ($api_result['data'] as $value) {

	if(strcmp(strtolower($key_city), strtolower($value['names']['en'])) ==0 ){
		$destinationId   = $value['id'] ;
		$destinationName = $value['names']['en'];
	}	
}
// echo $destinationName." And ". $destinationId;
$isango_url = "http://apistaging.isango.com/TicketFilterList/v2?criteriaFilter.language=en&criteriaFilter.currency=usd&criteriaFilter.destination=".$destinationId."&criteriaFilter.partner=ien&criteriaFilter.pageNumber=1&criteriaFilter.pageSize=10";
$detailed_data = isangoApi($isango_url, $access_token);
// echo "<pre>";
// print_r($detailed_data);
// echo "</pre>";
?>
	<article id="atrl" class="oneArticle main-listing-yelp article-one">				
<?php
foreach ($detailed_data['data'] as $detail) {
	// echo "<pre>";
	// print_r($detailed_data);
	// echo "</pre>";
?>
		<div class="row tab-two">
		    <div class="col-md-5 col-sm-12 col-xs-12">
				<div class="m_2 tour_images">
				 	<a href="<?php echo $detail['url'] ; ?>" target="_blank">
						 <?php if(!empty($detail['pictures'][0])) : ?>
							<img src="<?php echo $detail['pictures'][0]; ?>">
						<?php else : ?>
							<img src="https://mysitti.com/images/noimage-found.jpeg">
						<?php endif; ?>
					</a>
				</div>
			</div>
		  	<div class="col-md-7 col-sm-12 col-xs-12">
			    <h2 class="hu tour_names">
			    	<a href="<?php echo $detail['Url']; ?>" target="_blank"><?php echo $detail['title']; ?></a>
			    </h2>	
			 	<ul class="rating2 tour_ratingd">
				 	<?php for($x=1;$x<=$detail['rating'];$x++): ?>
					 	<li><img class="star_images"  src="imagesNew/star.png"></li>
					<?php endfor; ?>
					<?php if (strpos($detail['rating'],".")) : ?>
						<li><img class="star_images" src="images/halfstarnew.png"></li>
					<?php 
						$x++;
						endif; ?>
				</ul>           
	           	<p class="reviews yelpuser-review" style="color:#0355a9;"><?php echo $detail['TotalReviews'] ; ?> Reviews</p>
				<ul class="data_listing" style="color:black; list-style-type: disc; margin: 20px 20px 20px 20px;">
					<?php 
						foreach ($detail['bulletPoints'] as $details):
				  	?>
				  		<li><?php echo $details; ?></li>
				  	<?php
						endforeach; 
					?>
				</ul>
				<div class="col-md-8">
					<h3 style="color: black !important; display:inline-block; padding-bottom:10px;">Price: </h3>
					<h3 class="original_price tours_price"style=" display:inline-block; color: black;"><?php echo $detail['priceapp']."$(USD)" ; ?></h3>
				</div>
				<div class="col-md-8">
					<h3 style="color: black;display:inline-block; padding-bottom:10px;">Timings: </h3>
					<h3 class="original_price tours_price" style="display:inline-block; color: black !important;"><?php echo $detail['when']; ?></h3>
				</div>
				<!-- <div class="col-md-8">
					<ul class="list_f tour_address">
						<li><?php echo $tour_location_address1 ; ?></li>
						<li><?php echo $tour_location_address2 ; ?></li>
						<li><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?></li>
						<li><?php echo $tour_phone ; ?></li>
					</ul>
				</div>
				<div class="review_button">
					<button type="button" class="vewmenu yelpuser-review" data-toggle="modal" data-target="#myModal-review"  data-id=<?php echo $tour_id ; ?>>Reviews</button>
				</div> -->
		  	</div>
		</div>
<?php } ?>
	</article>
</div>
</div>
