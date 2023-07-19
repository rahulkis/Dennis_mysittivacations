<?php
$json = file_get_contents('php://input');
$someArray = json_decode($json, true);
include 'Query.Inc.php';
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";

$info        = $someArray['info'];
$modal_link  = $_POST['modal_link'];
$modal_title = $_POST['modal_title'];
$modal_table = $_POST['modal_table'];
$source      = $someArray['source'];
$title       = $_POST['title'];
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
$checkIn = date("Y-m-d");
$update_date = date_create($checkIn);
date_add($update_date,date_interval_create_from_date_string("1 days"));
$checkOut =  date_format($update_date,"Y-m-d");
function str_limit($value, $limit = 100, $end = '') {
  if (mb_strlen($value) <= $limit) {
    return $value;
  }
  return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
}
function address($lat, $long)
{
  // echo $lat." + ".$long."<br>";
  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4";

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, "");
  $curlData = curl_exec($curl);
  curl_close($curl);

  $data = json_decode($curlData);
  // echo"<pre>";
  // print_r($data->results[0]->formatted_address);
  // echo"</pre>";

  $address = $data->results[0]->formatted_address;

  return empty($address) ? "Address Not Found" : $address ;
}
function yelp_api_data($limit,$city,$keyword){
  //$key = empty($keyword) ? 'things%20%to%20%do' : str_replace(' ', '%20%', $keyword);
  $prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
  $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
  // echo "geocode";
  // echo $geocode;
  $output= json_decode($geocode);
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;
  $ch = curl_init();   
  $key = str_replace(' ','+',$keyword);
  // $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
  $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
  
  // return $urlgo;
  curl_setopt($ch, CURLOPT_URL, $urlgo);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $headers = array();
  $headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  if (curl_errno($ch)):
    echo 'Error:' . curl_error($ch);
  endif;
  curl_close ($ch);
 // echo "result";
 // echo $result;
  $get_deals = json_decode($result);

  $getyelpTourData = $get_deals->businesses;
  return $getyelpTourData;
}
function yelp_api_call($city_name , $limit){
  $prepAddr = str_replace(' ','+',$city_name);
  $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
  $output= json_decode($geocode);
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;
  $ch = curl_init();   
  $urlgo = "https://api.yelp.com/v3/businesses/search?term=things%20%to%20%do%20%indoors&latitude=".$latitude."&longitude=".$longitude."&limit=".$limit.""; 
    // echo $urlgo ;
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
  $get_deals = json_decode($result);
  $getyelpTourData = $get_deals->businesses;
  curl_close($ch);
  return ($err) ? $err : $getyelpTourData;

}
function zomato_api_call($url){
    // echo"<pre>";
    // print_r ($url);
    // echo"</pre>";
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
      "Cache-Control: no-cache",
      "user-key: 99868269a38bfabc5532b10a32fa75c7"
    ),
  ));

  $response = curl_exec($curl);
  $zomato_data = json_decode($response);
  $err = curl_error($curl);
  curl_close($curl);
  return ($err) ? $err : $zomato_data;
}

function izi_travel_api_call($url, $trigger){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache",
      "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  return ($err) ? $err : json_decode($response);
}


//echo "fhfhf". get_lat_long($_SESSION['city_name']);
//echo  "gdhdf". $latitude;
function groupon_api_call($limit,$city,$key){
    $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&address=chicago";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
    $responseJson = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($responseJson);

    if ($response->status == 'OK') {
      $latitude = $response->results[0]->geometry->location->lat;
      $longitude = $response->results[0]->geometry->location->lng;
    } 
    if(!empty($city)):
      $prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
      $key = str_replace(' ','+',$key);
      $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI');
      $output= json_decode($geocode);
      $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;

      $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
    // endif;
    else:

      if(!empty($key)):
        if($key == 'restaurants'){
          $urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=3";
        } else {
          $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)&context=web_getaways&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
        }
      else:
        $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
      endif;
    endif;
    $result_get = file_get_contents($urlgo);
    $get_all_data = json_decode($result_get, true);
    $get_deals = $get_all_data['deals'];
    return $get_deals;
  }

if(!empty($info)):
  ?>
<!--<div class="slider-section flight-sec travels sec_pad  what_do  what_do_main"> 
	<div class="container">
		<div data-aos="zoom-in-left" class="myheader-sec">
		   <h2>What to do</h2>
		   <p>Find fun places to see and things to do experience the art, museums, music, zoos</p>
		</div>
		<div class="testimonial-section products">
		   <div class="owl-carousel owl-theme" id="ProductSlide">
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
						<img src="imagesNew/escape_room.jpg" alt="Escape Room">
						<a href="yelp-tour.php?tours=escape%20%room" id="top_links" name="escape%20%room"><p>Escape Room</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <div data-aos="zoom-in-left" class="testimonial-block product">
				  <div class="cities">
						<img src="images/fimaly.png" alt="Family">
						<a href="family.php"><p>Family</p></a>
						<a href="#" class="starer like"><i class="fa fa-star" aria-hidden="true"></i></a>
				   </div> 
			   </div>
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
						<img src="imagesNew/perform-arts.jpg" alt="Performing Arts">
						<a href="performing-arts.php"><p>Performing Arts</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <div data-aos="zoom-in-left" class="testimonial-block product">
				  <div class="cities">
						<img src="imagesNew/brewery.png" alt="Winery/Brewery">
						<a href="brewery.php"><p>Winery/Brewery</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
						<img src="images/what1.png">
						<a href=""><p>Escape Room</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			    <div data-aos="zoom-in-left" class="testimonial-block product">
				  <div class="cities">
						<img src="imagesNew/comedy.png" alt="Winery/Brewery">
						<a href="comedy.php"><p>Comedy</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
						<img src="images/museum.jpg">
						<a href="yelp-tour.php?tours=Museum"><p>Museum</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <div data-aos="zoom-in-left" class="testimonial-block product">
				  <div class="cities">
						<img src="images/sightseeing.jpg" alt="Sightseeing">
						<a href="yelp-tour.php?tours=sightseeing"><p>Comedy</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
						<img src="images/shopping.jpeg">
						<a href="yelp-tour.php?tours=Shopping"><p>Shopping</p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
		   </div>
		</div>
	</div>
</div>-->
<!--<section class="travels sec_pad bg_grey what_do pb-0  what_do_main">
  <div class="container">
    <div class="heading">
      <h4>What to do</h4>
      <p>Find fun places to see and things to do experience the art, museums, music, zoos </p>
    </div>
    <div class="travels_inner slider_nav mb-0">
      <div class="what_do_slider owl-carousel owl-theme">
        <div class="grid">
         <a href="yelp-tour.php?tours=escape%20%room" id="top_links" name="escape%20%room">
           <div class="image_htfix"> 
            <img src="imagesNew/escape_room.jpg" alt="Escape Room" class="img-fluid w-100">
          </div>
          <h3>Escape Room</h3>
        </a>
        <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
      </div>
      <div class="grid">
       <a href="family.php">
         <div class="image_htfix"> 
          <img src="images/fimaly.png" alt="Family" class="img-fluid w-100">
        </div>
        <h3>Family</h3>
        <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
      </div>
      <div class="grid">
       <a href="performing-arts.php" >
         <div class="image_htfix"> 
          <img src="imagesNew/perform-arts.jpg" alt="Performing Arts" class="img-fluid w-100">
        </div>
        <h3>Performing Arts</h3>
      </a>
      <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
    </div>
    <div class="grid">
      <a href="brewery.php">
       <div class="image_htfix"> 
        <img src="imagesNew/brewery.png" alt="Winery/Brewery" class="img-fluid w-100">
      </div>
      <h3>Winery/Brewery</h3>
      <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
    </div>
    <div class="grid">
      <a href="comedy.php">
       <div class="image_htfix"> 
        <img src="imagesNew/comedy.png" alt="Comedy" class="img-fluid w-100">
      </div>
      <h3>Comedy</h3>
      <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
    </div>
    <div class="grid">

      <a href="yelp-tour.php?tours=Museum" id="top_links" name="Museum">
       <div class="image_htfix"> 
        <img src="images/museum.jpg" alt="Museum" class="img-fluid w-100">
      </div>
      <h3>Museum</h3>
      <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
    </div>
    <div class="grid">
      <a href="yelp-tour.php?tours=sightseeing" id="top_links">
       <div class="image_htfix"> 
        <img src="images/sightseeing.jpg" alt="Sightseeing" class="img-fluid w-100">
      </div>
      <h3>Sightseeing/Tours</h3>
      <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
    </div>
    <div class="grid">
     <a href="yelp-tour.php?tours=Shopping" id="top_links" name="Shopping">
       <div class="image_htfix"> 
        <img src="images/shopping.jpeg" alt="Shopping" class="img-fluid w-100">
      </div>
      <h3>Shopping</h3>
      <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
    </div>
  </div>
</div>
</div>
</section>-->
<!--end of travels-->


<?php
$city_name = str_replace(' ','%20',$_SESSION['city_name']);
$cities_id_url = "https://developers.zomato.com/api/v2.1/locations?query=".$city_name."";
$zomato_cities_id = zomato_api_call($cities_id_url);
$zomato_cities_id = $zomato_cities_id->location_suggestions[0]->city_id;
$collection_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."&count=15";
$zomato_collections = zomato_api_call($collection_url);
$zomato_collections = $zomato_collections->collections;
if($zomato_collections != ""):
  ?>
 <div class=" travels slider-section flight-sec eat-sec what_do"> 
	<div class="container">
		<div data-aos="zoom-in-left" class="myheader-sec">
		   <h2>Where to eat</h2>
		   <p>Taste <?php echo strtolower($_SESSION['city_name']); ?> pizza, hot dogs, Italian, and local cusines</p>
		</div>
		<div class="testimonial-section products">
		   <div class="owl-carousel owl-theme" id="ProductSlide-eat">
		    <?php
          $i = 0;
          foreach ($zomato_collections as $zomato_collection):
		  if($i%2==0){
			  $dataaos="zoom-in-right";
		  }else{
			  $dataaos="zoom-in-left";
		  }
              
            ?>
			   <div data-aos="<?php echo $dataaos;?>" class="testimonial-block product">
			   
				   <div class="cities">
						<img src="<?php echo $zomato_collection->collection->image_url; ?>">
						<a href="<?php echo $zomato_collection->collection->share_url; ?>"><p><?php echo $zomato_collection->collection->title; ?></p></a>
						<a href="#" class="starer like"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			<?php 
			 $i++;
          endforeach;
          ?>
		   </div>
		</div>
	</div>
</div>

<?php if(isset($_SESSION['city_name'])){ ?>



<!---design food-->
<div class="slider-section eat-sec new-for pt-0"> 
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2><?php echo $_SESSION['city_name']; ?> by Food</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="testimonial-section products">
				<div class="owl-carousel owl-theme" id="ProductSlide-audio6" target="_blank">
				<a href="/restaurant-deal.php?food=Breakfast">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Breakfast">
						<div class="discount-block">
							<img src="images/brkfirstImg.jpg">
							<div class="discount-content">
								<h3>Breakfast</h3>
							</div>
						</div>
					</div>
        </a>
        <a href="/restaurant-deal.php?food=Seafood" target="_blank">
					<div data-aos="zoom-in-left" class="testimonial-block product" id="Seafood">
						<div class="discount-block">
							<img src="images/seafoodnew.jpg">
							<div class="discount-content">
								<h3>Seafood</h3>
							</div>
						</div>
					</div>
        </a>
          <a href="/restaurant-deal.php?food=Coffee Tea" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Coffee Tea">
						<div class="discount-block city">
							<img src="images/coffytea.jpg">
							<div class="discount-content">
								<h3>Coffee & Tea</h3>
							</div>
						</div>					  
					</div>
        </a>
          <a href="/restaurant-deal.php?food=Cheap Eats" target="_blank">
					<div data-aos="zoom-in-left" class="testimonial-block product" id="Cheap Eats">
						<div class="discount-block">
							<img src="images/cheapeat.jpg">
							<div class="discount-content">
								<h3>Cheap Eats</h3>
							</div>
						</div>
					</div>
        </a>
          <a href="/restaurant-deal.php?food=Lunch" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Lunch">
						<div class="discount-block city">
							<img src="images/lunchnew.jpg">
							<div class="discount-content">
								<h3>Lunch</h3>
							</div>
						</div>					  
					</div>
        </a>
					<a href="/restaurant-deal.php?food=Mexican" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Mexican">
						<div class="discount-block city">
							<img src="images/mexican-cuisine.jpg">
							<div class="discount-content">
								<h3>MEXICAN</h3>
							</div>
						</div>					  
					</div>
        </a>
          <a href="/restaurant-deal.php?food=Chinese" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Chinese">
						<div class="discount-block city">
							<img src="images/chinese-cuisine.jpg">
							<div class="discount-content">
								<h3>Chinese</h3>
							</div>
						</div>					  
					</div>
        </a>
          <a href="/restaurant-deal.php?food=Italian" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Italian">
						<div class="discount-block city">
							<img src="images/italian-cuisine.jpg">
							<div class="discount-content">
								<h3>Italian</h3>
							</div>
						</div>					  
					</div>
        </a>
					<a href="/restaurant-deal.php?food=Pizza" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Pizza">
						<div class="discount-block city">
							<img src="images/pizza-cuisine.jpg">
							<div class="discount-content">
								<h3>Pizza</h3>
							</div>
						</div>					  
					</div>
        </a>
					<a href="/restaurant-deal.php?food=Barbeque" target="_blank">
					<div data-aos="zoom-in-right" class="testimonial-block product" id="Barbeque">
						<div class="discount-block city">
							<img src="images/barbecue-beef.jpg">
							<div class="discount-content">
								<h3>Barbeque</h3>
							</div>
						</div>					  
					</div> 
					</a>
					
					
					
					
			   </div>
			</div>
			</div>
		</div>
		
		<?php function yelp_api_call1($limit,$city,$keyword){
	//$key = empty($keyword) ? 'things%20%to%20%do' : str_replace(' ', '%20%', $keyword);
	$prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
  // echo "geocode";
  // echo $geocode;
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$ch = curl_init();   
	$key = str_replace(' ','+',$keyword);
	// $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
	$urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
	
	// return $urlgo;
	curl_setopt($ch, CURLOPT_URL, $urlgo);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	$headers = array();
	$headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)):
		echo 'Error:' . curl_error($ch);
	endif;
	curl_close ($ch);
 // echo "result";
 // echo $result;
	$get_deals = json_decode($result);

	$getyelpTourData = $get_deals->businesses;
	return $getyelpTourData;
}?>
		
		<div class="slider-section discount-section eat-sec new-for"> 
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="heading-content">
							<div class="content-sec">
								<h2>Fine Dining</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme" id="ProductSlide-audio">
				   
				    <?php   $fineDining = yelp_api_call1('10',$_SESSION['city_name'],'fine dining');
            foreach ($fineDining as $homeData){
              $fineDining_image = $homeData->image_url;
              $tour_rating = $homeData->rating;
              $tour_id = $homeData->id;
              $fineDining_count = $homeData->review_count;
              ?>
			  
			  <div data-aos="zoom-in-right" class="testimonial-block product">
							<div class="discount-block">
                <a href="<?php echo $homeData->url; ?>">
								<img src="<?php echo $fineDining_image; ?>">
								<div class="discount-content">
									<h3><?php echo substr($homeData->name, 0, 20); ?></h3>
									<div class="stars">
										<ul>
										
										<?php for($x=1;$x<=$tour_rating;$x++): ?>
										   <li><i class="fa fa-star" aria-hidden="true"></i></li>
										 <?php endfor; ?>
				 
										</ul>
										<p>(<?php echo $fineDining_count; ?> Reviews)</p>
									</div>
								</div>
              </a>
							</div>
						</div>
						
       <?php } ?>
	   
						
				   </div>
				</div>
			</div>
		</div>


<?php } ?>
		
  <!--<section class="travels sec_pad bg_grey what_do">
    <div class="container">
      <div class="heading">
        <h4>Where to eat</h4>
        <p>Taste <?php //echo strtolower($_SESSION['city_name']); ?> pizza, hot dogs, Italian, and local cusines </p>
      </div>
      <div class="travels_inner slider_nav mb-0">
        <div class="what_do_slider owl-carousel owl-theme">
          <?php
          /*$i = 0;
          foreach ($zomato_collections as $zomato_collection):
            $i++;  */ 
            ?>
            <div class="grid">
              <a target="_blank" href="<?php //echo $zomato_collection->collection->share_url; ?>">
                <div class="image_htfix">
                  <img src="<?php //echo $zomato_collection->collection->image_url; ?>" class="img-fluid w-100">
                </div>
                <h3><?php// echo $zomato_collection->collection->title; ?></h3>
              </a>  
              <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a> 
            </div>
            <?php 
         // endforeach;
          ?>
        </div>
      </div>
    </div>
  </section>-->
<?php endif; ?>
<!--end of Restaurants-->

<?php if($_SESSION['city_name'] == 'Washington D.C.'){
  $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 3";
}else{
  $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 3";
}
$result = $mysqli->query($randon_deals);?>
<div class="see_beautiful sec_pad slider-section discount-section new-for"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>See Beautiful <?php echo $_SESSION['city_name']; ?></h2>
				   <p>Sightseeing, Tour and Passes</p>
				</div>
			</div>
		</div>
		<div class="row">
				<?php if(!$detect->isMobile()){ ?>
			 <div class="see_beautiful_inner row">
				<?php 
				foreach ($result as $keys => $values) {
				  if(!empty($values['tag'])){
					$new = substr($values['link'], strrpos($values['link'], '=' )+1);
					$buy_urls = str_replace('%3A%2F%2F', '://', $new);
					$buy_urlss = str_replace('%2F', '/', $buy_urls);
					$buy_urlsss = str_replace('%3F', '/', $buy_urlss);
					$buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
					$buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
					$buy_url = $buy_urlsssss; 
					?>
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
					<a href="<?php echo $buy_url; ?>">
						<div class="discount-block">
							<img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>">
							<div class="discount-content">
								<h3><?php echo $values['title']; ?></h3>
							</div>
						</div>
					</a>
					</div>
					<?php     
				  }
				}?>
			</div>
		  <?php }else{?> 
			<!--<div class="client owl-carousel owl-theme">-->
			<div class="row">
			  <?php 
        if($_SESSION['city_name'] == 'Washington D.C.'){
        $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 5";
        }else{
        $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 5";
        }
        $result = $mysqli->query($randon_deals);
			  foreach ($result as $keys => $values) {
				  $new = substr($values['link'], strrpos($values['link'], '=' )+1);
				  $buy_urls = str_replace('%3A%2F%2F', '://', $new);
				  $buy_urlss = str_replace('%2F', '/', $buy_urls);
				  $buy_urlsss = str_replace('%3F', '/', $buy_urlss);
				  $buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
				  $buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
				  $buy_url = $buy_urlsssss; 
				  ?>
				  <div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
					<a href="<?php echo $buy_url; ?>">
						<div class="discount-block">
							<img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>">
							<div class="discount-content">
								<h3><?php echo $values['title']; ?></h3>
							</div>
						</div>
					</a>
					</div>
				  <?php     
				
			  }?>
			</div>
		  <?php } ?>
			
			<div class="view-tag" data-aos="zoom-in-down">
				 <a href="#" data-toggle="modal" data-target="#beautiful_america_specific" target="_blank" class="">View all</a>
			</div>
	</div>
</div>

<?php


$endpoint = "https://ads.api.cj.com/query";
$authToken = "45agzktndc3f016pmtwwfdev51";
$qry = '{ travelExperienceProducts(companyId: "4882762", partnerIds:"5840172",keywords: "'.$_SESSION['city_name'].' tours", limit: 3 ) {totalCount,limit,resultList { advertiserId,advertiserName,categoryName, catalogId, id, title, description,sourceFeedType,imageLink,link,locationName, salePrice {amount,currency} price {amount, currency} linkCode(pid: "8265264") {clickUrl } }  } }';

$headers = array();
// $headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer '.$authToken;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $qry);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$dataGroupon = json_decode($result,true);

?>
<div class="slider-section discount-section tours-sec groupon_discount_sec"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2><?php echo $_SESSION['city_name']; ?> Tours</h2>
				   <p>We have searched Groupon for you, to find drastically discounted tours and sightseeing things to do, helping you save money while enjoying helicopter rides, bus tours, and much more</p>
				</div>
			</div>
			
		 <?php 
            foreach ($dataGroupon['data']['travelExperienceProducts']['resultList'] as $key => $value) {
              $percent = (($value['price']['amount'] - $value['salePrice']['amount'])*100) /$value['price']['amount'] ;
              ?>
             
          <div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4 aos-init aos-animate">
            <div class="discount-block">
              <img src="<?php echo $value['imageLink'] ?>">
              <div class="discount-content">
              <h3><?php echo $value['title']; ?></h3>
              <p><?php echo substr($value['description'],0,40).'..'; ?></p>
              </div>
              <div class="discount-action purple-bg">
              <div class="action-content">
              <p><b><?php echo $value['locationName']; ?></b> <span><b>$</b> <?php echo $value['price']['amount']; ?> <b>$<?php echo $value['salePrice']['amount']; ?></b> <?php echo number_format($percent); ?>% OFF</span></p>
              </div>
              <a href="<?php echo $value['linkCode']['clickUrl'] ?>" target="_top"><img class="specific_img_arrow" src="/mysitti-html/images/right-blue.png"></a>
              </div>
            </div>
         
          </div>
        <?php
            }
        ?>
		</div>
	</div>
</div>

<?php
//endif;
endif;
?>
<style>
.discounts_inner figure.card-ui .cui-udc-image-container img {
    /*height: 168px;*/
    width: 100%;
    object-fit: cover;
    border-radius: 4px;
    position: relative !important;
}
.specific_img_arrow{
    width: 50px !important;
    height: 50px !important;
}
#groupon_discounts .audio_tour_modalss {
    display: flex;
    flex-wrap: wrap;
      padding-right: 0;
}

#groupon_discounts .cui-udc-details {
    padding: 20px;
    position: relative;
}
#groupon_discounts .cui-udc-title {
    font-size: 20px;
    margin-bottom: 8px;
    text-transform: uppercase;
    font-weight: 600;
    font-family: 'ProductSansBold';
      white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  padding-bottom: 63px;
}
#groupon_discounts .cui-price {
    display: flex;
    align-items: center;
  margin:10px 0px;
}
#groupon_discounts .cui-price .cui-price-original {
    text-decoration: line-through;
    margin-right: 5px;
}

#groupon_discounts .cui-combined-section {
    display: flex;
    align-items: center;    
    position: relative;
  padding-bottom: 20px;
  padding-left:30px;
}
#groupon_discounts .cui-combined-section .cui-verbose-urgency-text {
    position: absolute;
    left: 0;
    bottom: 0;
  padding-left:30px;
}
#groupon_discounts .cui-single-section .cui-udc-subtitle {
    position: absolute;
    top: 63px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
#groupon_discounts .cui-single-section .cui-review-rating {
    display: none;
}
#groupon_discounts .cui-single-section .cui-location {
    position: relative;
    padding-left: 30px;
}
#groupon_discounts .cui-single-section .cui-location::before {
    content: "\f279";
    font-family: "Font Awesome 5 Free";
    position: absolute;
    left: 0;
    font-weight: 900;
    font-size: 14px;
    top: 2px;
}
#groupon_discounts .cui-price .cui-price-original::before {
    position: absolute;
    content: "\f155";
    left: 0;
    font-weight: 900;
    font-family: "Font Awesome 5 Free";
    font-size: 14px;
}
#groupon_discounts .cui-combined-section .cui-verbose-urgency-text::before {
    position: absolute;
    content: "\f017";
    left: 0;
    font-weight: 900;
    font-family: "Font Awesome 5 Free";
    font-size: 14px;
    top: 2px;
}

#groupon_discounts .cui-price .cui-price-discount {
    margin-right: 3px;
    text-decoration: line-through;
    font-weight: normal;
    color: #212529;
}
#groupon_discounts .cui-combined-section .cui-verbose-urgency-price {
    font-weight: 700;
    color: #276ab5;
    margin-left: 10px;
}

#groupon_discounts .cui-udc-details .cui-view-deal {
    display: none;
}

#groupon_discounts .all-inclusive{
  box-shadow: rgb(0 0 0 / 10%) 0px 4px 12px;
    border-radius: 4px;
    margin-right: 20px;
    margin-bottom: 20px;
  position:relative;
}
#groupon_discounts .all-inclusive::before {
    position: absolute;
    content: "\f054";
    font-weight: 900;
    font-family: "Font Awesome 5 Free";
    font-size: 14px;
    color: #fff;
    right: 10px;
    bottom: 10px;
    width: 30px;
    height: 30px;
    background: #276ab5;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

#ProductSlide-audio6 .discount-block img,#ProductSlide-audio .discount-block img{
    height: 189.55px;
    border-radius: 10px;
    object-fit: cover;
}
#ProductSlide-audio6 .discount-block {
    box-shadow: 5px 5px 10px #0000002b;
}
#ProductSlide-audio6 .discount-block {
    margin: 15px 5px;
}
#ProductSlide-audio .stars p {
    line-height: 32px;
}
#ProductSlide-audio .discount-block {
    box-shadow: 0px 5px 8px #0000002b;
    margin: 10px;
}
#ProductSlide-audio .stars ul{
   margin-bottom: 0;      
}
    
    
@media screen and (min-width:992px){
  
  #groupon_discounts .all-inclusive {    
    width: 31%;
}
#groupon_discounts .modal-dialog {
    max-width: 900px;
}
}
</style>
