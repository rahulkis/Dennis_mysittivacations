<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Sports Zone"; 
session_start();
// if(isset($_SESSION['city_name'])){

if(isset($_GET['city']))
{
$_SESSION['city_name'] = $_GET['city'];
}
include('header-newfile.php');	// not login 

// }else{
// 	header('location:https://mysittivacations.com/');
// }
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>

<style>
.view-tag button {
    letter-spacing: .5px;
    padding: 15px 55px;
    border-radius: 100px;
    color: #fff;
    font-size: 16px;
    margin: 20px 10px 0;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
    text-decoration: none;
    display: inline-block;
}
@media (max-width: 767px){
	.mobile-filter a {margin: 0px 5px 0;}
	.searcher-sec {border-bottom: 0px solid #ccc;}
}
</style>

<input type="hidden" name="ticketmaster_trigger" id="ticketmaster_trigger" value="<?php echo $_GET['ticketmaster_trigger']; ?>">
	<input type="hidden" name="ticketmaster_trigger_city" id="ticketmaster_trigger_city" value="<?php echo $_GET['city']; ?>">
	<?php 

	$access_key_id = "AKIAJGQOCN7MATLFXL6A";
	$secret_key = "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";
	$endpoint = "webservices.amazon.com";

	$uri = "/onca/xml";

	$params = array(
		"Service" => "AWSECommerceService",
		"Operation" => "ItemSearch",
		"AWSAccessKeyId" => "AKIAJQAN4KM4OYIJI5LQ",
		"AssociateTag" => "mysitti348905-20",
		"SearchIndex" => "All",
		"Keywords" => "$dropdown_city NBA",
		"ResponseGroup" => "Images,ItemAttributes,Offers"
	);

	if (!isset($params["Timestamp"])) {
		$params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
	}

	ksort($params);

	$pairs = array();

	foreach ($params as $key => $value) {
		array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
	}

	$canonical_query_string = join("&", $pairs);
	$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;
	$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));
	$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
	$pxml = simplexml_load_file($request_url);

	?>

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
	if(isset($_SESSION['city_name'])){
		$getAds = "SELECT * FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
		$result = $mysqli->query($getAds);
		$count = $result->num_rows;
		if($count > 0){
			foreach ($result as $key => $value) {
				$city_data =  $value['city_id_code'];
			}
		}
	} 
	?>

<style>.blissey-widget .blissey-info {
	order: 2;
	padding: 0px !important; 
	background: #fff !important;
}</style>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="v2_content_inner2">
	<div id="loader"></div>
	<span class='update-zero' style="display: none;">0</span>	
</div>
<!--<section class="inner_page_hero music_sec_bg sec_pad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="hero_section_content">
					<h2 class="mb-5">Concerts in  <?php //echo $_SESSION['city_name']; ?></h2>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="content-bannersss">
					<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

					<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php //echo $_SESSION['full_city_name'];?>" required="">

					<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</section>-->
<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec" style="background-image:url(images/Sports_Zone.jpg)"> 
	<div class="container">
		<div class="mobile-hero">
			<img src="images/Sports_Zone.jpg">
		</div>
		<div class="carousel-caption-top">
		   <h1>Sports Zone</h1>
		</div>
		<div class="view-all-sec">
			<div class="view-tag" data-aos="zoom-in-down">
				<a href="#">Search</a>
			</div>
		</div>
		<div class="free-trail-form">
		   <div class="container">
				<div class="row">
					<div class="col-md-12 col-12">
						<div class="search-content hotels">
							<ul>
								<li>
									<div class="form-group">
										<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">
										<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>" required="">
										<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#">Search</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
	   </div>
   </div>
</div>
<!--end of hero section-->
<?php include('category-newfile.php'); ?>
<!--end of category -->
<!-- product listing section -->
<?php function yelp_api_call($limit,$city,$keyword){
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
	?>
<div class="rind-the-right-section comedy-sec sport-sec">
		<div class="container n-contain ">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<div class="sidebar-listing">
						
						<div class="specialities-checkbox">
							<div class="searcher-sec">
								<label class="custom-control-label">Search By City</label>
								<div class="form-group">
									<input type="text" class="form-control" id="refine-result" value="<?php echo $_SESSION['city_name']; ?>" placeholder="Search by city name">
								</div>
							</div>
						</div>
						<div class="mobile-filter">
							<ul>
								<li>
									<div class="sorf-filter">
										<span>Sort By</span>
										<select class="form-select" aria-label="Default select example">
											<option selected="">Best Value</option>
											<option value="1">Value</option>
										</select>
									</div>
								</li>
								<li>
									<a href="#" data-toggle="modal" data-target="#filter-popups"><i class="fa fa-filter" aria-hidden="true"></i>Filter</a> 
								</li>
							</ul>
						</div>
		
						<div class="specialities-checkbox">
							<div class="listing-check">
								<h4>Sports Events</h4>
							</div>
							<?php
							$city_name_query = @mysql_query("SELECT city_name,state_id FROM capital_city WHERE city_name = '".$_SESSION['city_name']."'");
							$get_city_name = mysql_fetch_assoc($city_name_query);
							$dropdown_city = $get_city_name['city_name'];
							// echo $dropdown_city;
							$state_name_query = @mysql_query("select country_id,name,code FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
							$get_state_name = mysql_fetch_assoc($state_name_query);
							$_SESSION['country'] = $get_state_name['country_id'];
							$state_name = $get_state_name['name'];
							$state_code = $get_state_name['code'];

							$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
							$get_co_name = mysql_fetch_assoc($co_name_query);
							$conry_nm = $get_co_name['name'];
							$sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$state_code."' OR state_name = '".$state_name."'";
							$result = mysql_query($sql);

							$nurows = mysql_num_rows($result);
							
							if($nurows > 0) {
								
								while($row = mysql_fetch_assoc($result)){
									//echo "<pre>"; print_r($row); echo "</pre>";
									
									//$html .= "<h4>".$row['state_name']."</h5>";
									if(!empty($row['NBA'])){
										$html .= "<div class='listing-check'>
										<h4>NBA</h4>";
										$res = explode(",", $row['NBA']);
										$ki =101;
										for ($i=0; $i < count($res); $i++) { 
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$ki."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$ki."'>".$res[$i]."</label>
											</div>";
											
											$ki++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['NFL'])){
										$html .= "<div class='listing-check'>
										<h4>NFL</h4>";
										$res = explode(",", $row['NFL']);
										$ji =201;
										for ($i=0; $i < count($res); $i++) { 
											// echo $_GET['ticketmaster_trigger'];
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$ji."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$ji."'>".$res[$i]."</label>
											</div>";
											
											$ji++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['NHL'])){
										$html .= "<div class='listing-check'>
										<h4>NHL</h4>";
										$res = explode(",", $row['NHL']);
										$li =301;
										for ($i=0; $i < count($res); $i++) { 
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$li."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$li."'>".$res[$i]."</label>
											</div>";
											
											$li++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['MLB'])){
										$html .= "<div class='listing-check'>
										<h4>MLB</h4>";
										$res = explode(",", $row['MLB']);
										$mi =401;
										for ($i=0; $i < count($res); $i++) { 
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$mi."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$mi."'>".$res[$i]."</label>
											</div>";
											
											$mi++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['MLS'])){
										$html .= "<div class='listing-check'>
										<h4>MLS</h4>";
										$res = explode(",", $row['MLS']);
										$ni =501;
										for ($i=0; $i < count($res); $i++) { 
											
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$ni."'  value='".$res[$i]."'>
											  <label class='custom-control-label' for='styled-checkbox activity-".$ni."'>".$res[$i]."</label>
											</div>";
											
											$ni++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['CFL'])){
										$html .= "<div class='listing-check'>
										<h4>CFL</h4>";
										$res = explode(",", $row['CFL']);
										$oi =601;
										for ($i=0; $i < count($res); $i++) { 
											
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$oi."'  value='".$res[$i]."'>
											  <label class='custom-control-label' for='styled-checkbox activity-".$oi."'>".$res[$i]."</label>
											</div>";
											
											$oi++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['Colleges'])){
										$html .= "<div class='listing-check'>
										<h4>Colleges</h4>";
										$res = explode(",", $row['Colleges']);
										$pi =601;
										for ($i=0; $i < count($res); $i++) { 
											
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$pi."'  value='".$res[$i]."'>
											  <label class='custom-control-label' for='styled-checkbox activity-".$pi."'>".$res[$i]."</label>
											</div>";
											
											$pi++;
										}
										$html .= "</div>";
									}
									
									echo $html;
									
									
											
								}
							} else {
								$html .= "<h1 class='record_not_found'>Events not found.</h1>";
								echo $html;
							}
							?>
							
							
						<div class="map-search listing-check">
								<div class="sorts specialities-checkbox">
									<label class="custom-control-label">START & END TIMESLOT</label>
									<p>Powered by: Ticket Master</p>
									<div class="inpt-sec">
										<input type="text" id="dpd_team" name="checkin" value="" class="form-control clickable input-md check_class common_family" placeholder="Start Date">
										
										<span>to</span>
										
										<input type="text" id="dpdtm" name="checkout" value="" class="form-control clickable input-md common_family check_class" placeholder="End Date">

										<a href="#" class="selectRangeteams" id="dateRangeteam">GO</a>
									</div>
								</div>
						</div>

							<div class="listing-check">
								<h4>CATEGORY</h4>
	
										
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-1" value="Basketball">
								  <label class="custom-control-label" for="styled-checkbox activity-1">Basketball</label>
								</div>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-2" value="Football">
								  <label class="custom-control-label" for="styled-checkbox activity-2">Football</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-02" value="Hockey">
								  <label class="custom-control-label" for="styled-checkbox activity-02">Hockey</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-012" value="Baseball">
								  <label class="custom-control-label" for="styled-checkbox activity-012">Baseball</label>
								</div><div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-32" value="Soccer">
								  <label class="custom-control-label" for="styled-checkbox activity-32">Soccer</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-042" value="Motorsports">
								  <label class="custom-control-label" for="styled-checkbox activity-042">Motorsports</label>
								</div>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-041" value="Rodeo">
								  <label class="custom-control-label" for="styled-checkbox activity-041">Rodeo</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-052" value="Golf">
								  <label class="custom-control-label" for="styled-checkbox activity-052">Golf</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-62" value="Tennis">
								  <label class="custom-control-label" for="styled-checkbox activity-62">Tennis</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-062" value="Boxing">
								  <label class="custom-control-label" for="styled-checkbox activity-062">Boxing</label>
								</div>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-072" value="Curling">
								  <label class="custom-control-label" for="styled-checkbox activity-072">Curling</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-082" value="Lacrosse">
								  <label class="custom-control-label" for="styled-checkbox activity-082">Lacrosse</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-092" value="Skating">
								  <label class="custom-control-label" for="styled-checkbox activity-092">Skating</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-093" value="Bull Riding">
								  <label class="custom-control-label" for="styled-checkbox activity-093">Bull Riding</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-094" value="Volleyball">
								  <label class="custom-control-label" for="styled-checkbox activity-094">Volleyball</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-095" value="Handball">
								  <label class="custom-control-label" for="styled-checkbox activity-095">Handball</label>
								</div>
							</div>		
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
					<div class="white-box-area inner rest-deals sport-zone">
						<div class="row">
							
							<div class="col-md-12 col-12">
								<div class="sort-display-sec">
									<div class="sort-content">
											<p>Popular shows in <?php echo $_SESSION['city_name']; ?>. Displaying 1–10</p>
										</div>
										<div class="custom-select-box">
											<a href="#"><i class="fas fa-bars"></i></a>
											<a href="#"><i class="fas fa-th-large"></i></a>
											<span>Sort
											</span>
											<select class="form-select" aria-label="Default select example">
												<option selected="">Alphabetically</option>
												<option value="1">Ascending</option>
												<option value="2">Descending</option>
											</select>
										</div>
									</div>
									</div>
							<div class="col-lg-12 col-12">
							<section class="client-sec comedy sport-zone-sec">
									
									<div class="comedy-bottom-sec family-ticketMaster">
									
									<?php	function ticketmasterApi($city, $page, $key,$trigger,$filter_url){
							if($city == 'Washington D.C.'){
								$city = 'Washington';
							}elseif($dropCity == 'Washington DC'){
								$city = 'Washington';
							}
							$city =str_replace(' ','%20',strtok($city, ',')) ;
							$key =str_replace(' ','+',$key) ;
							$page =$page;
							if (isset($page)) :
								if(isset($trigger)):
									$key = (empty($key)) ?  $city : $key;
								echo 	$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=".$page."&classificationName=[".$trigger."]";
								else:
									$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=".$page."";
								endif;

							else:
								if(isset($trigger)):
									$key = (empty($key)) ? $city : $key;
									$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=0&classificationName=[".$trigger."]";
								else:
									$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=0";
								endif;
							endif;
							if(isset($filter_url)){
								$urlgo = $filter_url;
							}
		 //echo $urlgo;
		 //die;
							$curl = curl_init();

							curl_setopt_array($curl, array(
								CURLOPT_URL => $urlgo,
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "GET",
								CURLOPT_HTTPHEADER => array(
									"Postman-Token: 52ec54df-357c-4ae0-a02c-d6a9910d626d",
									"cache-control: no-cache"
								),
							));
							$response = curl_exec($curl);
							$err = curl_error($curl);

							curl_close($curl);
							if ($err) {
								return "cURL Error #:" . $err;
							} else {
								return json_decode($response, true);
							}
						}
						$dropdown_value = 'sports';

						$date1 = date("Y-m-d");
						$start_date = date("Y-m-d", strtotime($date1)).'T12:00:00Z'; 
						$date2 = date("Y-m-d", strtotime("tomorrow"));
						$end_date = date("Y-m-d", strtotime($date2 )).'T12:00:00Z';
						if(empty($_POST['end_date'])){
							if(isset($_POST['genric_dropdown'])){
								$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+', $_POST['genric_dropdown'])."&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."";

							}else{
								$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Music&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&classificationName=".$dropdown_value."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."";
							}
						}else{
							if(isset($_POST['genric_dropdown'])){
								$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".str_replace(' ','+', $_POST['genric_dropdown'])."&city=".str_replace(' ','%20',strtok($_POST['formatted'], ','))."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."&endDateTime=".$_POST['endDateTime']."";
							}else{

								$filter_url = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=Music&city=".str_replace(' ','%20',strtok($_SESSION['city_name'], ','))."&classificationName=".$dropdown_value."&sort=date,asc&countryCode=US&page=0&startDateTime=".$_POST['startDateTime']."&endDateTime=".$_POST['endDateTime']."";
							}
						}
						$get_all_data = ticketmasterApi($_SESSION['city_name'] , 0, $dropdown_value);

						$page_size = $get_all_data['page']['size'];
						$totalPages = $get_all_data['page']['totalPages'];
						$number = $get_all_data['page']['number'];
						$get_deals = $get_all_data['_embedded']['events'];

						if (!empty($get_deals)) {
							$html = '';

							foreach ($get_deals as $homeData)
							{
								$eventsName = $homeData['name'];
								$eventUrl = $homeData['url'];
								$start_date = $homeData['dates']['start']['localDate'];

								$timestamp = strtotime($start_date);
								$date_foemate = date('m/d/Y', $timestamp);

								$nameOfDay = date('D', strtotime($start_date));
								$time = $homeData['dates']['start']['localTime'];
								$strtime = date('h:i A', strtotime($time));
								$city = $homeData['_embedded']['venues'][0]['city']['name'];
								$state = $homeData['_embedded']['venues'][0]['state']['name'];
								$country = $homeData['_embedded']['venues'][0]['country']['countryCode'];
								$venue_name =$address1 = $homeData['_embedded']['venues'][0]['name'];
								$address1 = $homeData['_embedded']['venues'][0]['address']['line1'];
								$address2 = $homeData['_embedded']['venues'][0]['address']['line2'];
								$image_url = $homeData['images'][1]['url'];

								$image = "https://mysitti.com/images/noimage-found.jpeg"; 
								if(!empty($image_url)){
									$image =  $image_url ;
								}
								
								
								
									 
									
											 /*<a href=".$eventUrl." target='_blank'>*/
									$dataaos="zoom-in-right";
									$html .= "<div class='slide' data-aos='".$dataaos."'>
											
												<div class='discount-block'>
													<div class='cities'>
													<img src= ".$image." >
													</div>
													<div class='sport-cont'>
													<div class='discount-content'>
														<h3>".$eventsName."</h3> <span><i class='fa fa-map-marker' aria-hidden='true'></i>  ".$venue_name."</span>
													</div>
													<div class='comedy-add-details'>
														<p><i class='fa fa-map-marker' aria-hidden='true'></i> ".$address1."  ".$address2.", ".$city.", ".$country."</p>
														<p><i class='fa fa-calendar' aria-hidden='true'></i> ". $nameOfDay .','.$date_foemate."</p>
														<p><i class='fa fa-clock-o' aria-hidden='true'></i> ".$strtime."</p>
													</div>
													<div class='discount-action hotels'>
														<a class='hotel-book' href=".$eventUrl." target='_blank'>See Ticket </a>
													</div>
												</div>
												</div>
											
											</div>";
											$content++;
										}


									}else{
										echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
									}
									echo $html;?>
									
									
									<?php if ($totalPages > 1 ) { ?>
										<div class="view-tag" data-aos="zoom-in-down">

											<?php if($number == 0 ){ ?>
												<input type='text' value="<?php echo rawurlencode($dropdown_value); ?>" class='drop-value' style='display:none;'>	
												<button class='pagination_btn next-refine next' field='quantity'>Next</button>

											<?php } elseif($totalPages != $number+1) {?>
												<button class='pagination_btn prev-refine' field='quantity'>Previous</button>

												<input type='text' value="<?php echo rawurlencode($dropdown_value); ?>" class='drop-value' style='display:none;'>	
												<button class='pagination_btn next-refine' field='quantity'>Next</button>
											<?php } elseif($number == $totalPages-1) {?>
												<button class='pagination_btn prev-refine' field='quantity'>Previous</button>
											<?php } ?> 
										</div>
									<?php } ?>
						
									 
							</div>
						</section>
					</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- product listing section -->
	<!-- Us popular city -->
	<div class='modal fade' id='popularcitiesModal' role='dialog'>

		<div class='modal-dialog '>
			<div class='modal-content'>
				<div class='modal-header'>
					<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<div id="modal_loader"></div>
				</div>
				<div class="cities_modal">

				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			</div>
		</div>
	</div>
		<div class="modal fade" id="filter-popups" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="specialities-checkboxS">
							<div class="listing-check">
								<h4>Sports Events</h4>
							</div>
							<?php
							$city_name_query = @mysql_query("SELECT city_name,state_id FROM capital_city WHERE city_name = '".$_SESSION['city_name']."'");
							$get_city_name = mysql_fetch_assoc($city_name_query);
							$dropdown_city = $get_city_name['city_name'];
							// echo $dropdown_city;
							$state_name_query = @mysql_query("select country_id,name,code FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
							$get_state_name = mysql_fetch_assoc($state_name_query);
							$_SESSION['country'] = $get_state_name['country_id'];
							$state_name = $get_state_name['name'];
							$state_code = $get_state_name['code'];

							$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
							$get_co_name = mysql_fetch_assoc($co_name_query);
							$conry_nm = $get_co_name['name'];
							$sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$state_code."' OR state_name = '".$state_name."'";
							$result = mysql_query($sql);

							$nurows = mysql_num_rows($result);
							
							if($nurows > 0) {
								
								while($row = mysql_fetch_assoc($result)){
									//echo "<pre>"; print_r($row); echo "</pre>";
									
									//$html .= "<h4>".$row['state_name']."</h5>";
									if(!empty($row['NBA'])){
										$html .= "<div class='listing-check'>
										<h4>NBA</h4>";
										$res = explode(",", $row['NBA']);
										$ki =101;
										for ($i=0; $i < count($res); $i++) { 
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$ki."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$ki."'>".$res[$i]."</label>
											</div>";
											
											$ki++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['NFL'])){
										$html .= "<div class='listing-check'>
										<h4>NFL</h4>";
										$res = explode(",", $row['NFL']);
										$ji =201;
										for ($i=0; $i < count($res); $i++) { 
											// echo $_GET['ticketmaster_trigger'];
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$ji."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$ji."'>".$res[$i]."</label>
											</div>";
											
											$ji++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['NHL'])){
										$html .= "<div class='listing-check'>
										<h4>NHL</h4>";
										$res = explode(",", $row['NHL']);
										$li =301;
										for ($i=0; $i < count($res); $i++) { 
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$li."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$li."'>".$res[$i]."</label>
											</div>";
											
											$li++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['MLB'])){
										$html .= "<div class='listing-check'>
										<h4>MLB</h4>";
										$res = explode(",", $row['MLB']);
										$mi =401;
										for ($i=0; $i < count($res); $i++) { 
											if($res[$i] == $_GET['ticketmaster_trigger']){
												$check = 'checked=""';
											}else{
												$check = '';
											}
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$mi."'  value='".$res[$i]."' $check>
											  <label class='custom-control-label' for='styled-checkbox activity-".$mi."'>".$res[$i]."</label>
											</div>";
											
											$mi++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['MLS'])){
										$html .= "<div class='listing-check'>
										<h4>MLS</h4>";
										$res = explode(",", $row['MLS']);
										$ni =501;
										for ($i=0; $i < count($res); $i++) { 
											
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$ni."'  value='".$res[$i]."'>
											  <label class='custom-control-label' for='styled-checkbox activity-".$ni."'>".$res[$i]."</label>
											</div>";
											
											$ni++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['CFL'])){
										$html .= "<div class='listing-check'>
										<h4>CFL</h4>";
										$res = explode(",", $row['CFL']);
										$oi =601;
										for ($i=0; $i < count($res); $i++) { 
											
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$oi."'  value='".$res[$i]."'>
											  <label class='custom-control-label' for='styled-checkbox activity-".$oi."'>".$res[$i]."</label>
											</div>";
											
											$oi++;
										}
										$html .= "</div>";
									}
									
									if(!empty($row['Colleges'])){
										$html .= "<div class='listing-check'>
										<h4>Colleges</h4>";
										$res = explode(",", $row['Colleges']);
										$pi =601;
										for ($i=0; $i < count($res); $i++) { 
											
											$html .= "<div class='custom-control custom-checkbox'>
											  <input type='checkbox' class='custom-control-input activity' id='styled-checkbox activity-".$pi."'  value='".$res[$i]."'>
											  <label class='custom-control-label' for='styled-checkbox activity-".$pi."'>".$res[$i]."</label>
											</div>";
											
											$pi++;
										}
										$html .= "</div>";
									}
									
									echo $html;
									
									
											
								}
							} else {
								$html .= "<h1 class='record_not_found'>Events not found.</h1>";
								echo $html;
							}
							?>
							
							
						<div class="map-search listing-check">
								<div class="sorts specialities-checkbox">
									<label class="custom-control-label">START & END TIMESLOT</label>
									<p>Powered by: Ticket Master</p>
									<div class="inpt-sec">
										<input type="text" id="dpd_team" name="checkin" value="" class="form-control clickable input-md check_class common_family" placeholder="Start Date">
										
										<span>to</span>
										
										<input type="text" id="dpdtm" name="checkout" value="" class="form-control clickable input-md common_family check_class" placeholder="End Date">

										<a href="#" class="selectRangeteams" id="dateRangeteam">GO</a>
									</div>
								</div>
						</div>

							<div class="listing-check">
								<h4>CATEGORY</h4>
	
										
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-1" value="Basketball">
								  <label class="custom-control-label" for="styled-checkbox activity-1">Basketball</label>
								</div>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-2" value="Football">
								  <label class="custom-control-label" for="styled-checkbox activity-2">Football</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-02" value="Hockey">
								  <label class="custom-control-label" for="styled-checkbox activity-02">Hockey</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-012" value="Baseball">
								  <label class="custom-control-label" for="styled-checkbox activity-012">Baseball</label>
								</div><div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-32" value="Soccer">
								  <label class="custom-control-label" for="styled-checkbox activity-32">Soccer</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-042" value="Motorsports">
								  <label class="custom-control-label" for="styled-checkbox activity-042">Motorsports</label>
								</div>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-041" value="Rodeo">
								  <label class="custom-control-label" for="styled-checkbox activity-041">Rodeo</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-052" value="Golf">
								  <label class="custom-control-label" for="styled-checkbox activity-052">Golf</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-62" value="Tennis">
								  <label class="custom-control-label" for="styled-checkbox activity-62">Tennis</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-062" value="Boxing">
								  <label class="custom-control-label" for="styled-checkbox activity-062">Boxing</label>
								</div>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-072" value="Curling">
								  <label class="custom-control-label" for="styled-checkbox activity-072">Curling</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-082" value="Lacrosse">
								  <label class="custom-control-label" for="styled-checkbox activity-082">Lacrosse</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-092" value="Skating">
								  <label class="custom-control-label" for="styled-checkbox activity-092">Skating</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-093" value="Bull Riding">
								  <label class="custom-control-label" for="styled-checkbox activity-093">Bull Riding</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-094" value="Volleyball">
								  <label class="custom-control-label" for="styled-checkbox activity-094">Volleyball</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" name="dropDownId" id="styled-checkbox activity-095" value="Handball">
								  <label class="custom-control-label" for="styled-checkbox activity-095">Handball</label>
								</div>
							</div>		
						</div>
                  </div>
                </div>
              </div>
            </div>
	<div class='modal fade' id='myModal-review' role='dialog'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header'>
					
					<h4 class='modal-title'></h4>
				</div>
				<div class='tuorfun'>
					<ul class='modal-tour-review'>

					</ul>    
				</div>
				<div class='modal-footer'>
					<button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			</div>

		</div>
	</div>
	<!-- Us popular city End -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/autocomplete.js"></script>
	<script type="text/javascript">
		var today = new Date();
	// console.log(today);
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	// console.log(mm);
	var yyyy = today.getFullYear();
	var hh = today.getHours();
	var mi = today.getMinutes();
	// var ss = today.getSeconds();
	if(dd<10) {
		dd = '0'+dd;
	}
	if(mi<10 ) {
		mi = '0'+mi;
	}
	if(mm<10) {
		mm = '0'+mm;
	} 
	today = yyyy + '-' + mm + '-' + dd+'T'+hh+':'+mi+':'+'00Z';
	// console.log(today);
	$('.date_range').append($("<option/>", {
		value: today,
		text: 'Date Range'
	}));
	$('.date_range').append($("<option/>", {
		value: today,
		text: 'Today'
	}));
	var days =[7,14,31,60,90,180];
	$.each(days, function(index, value){
		var now = new Date();
		var unixTimestamp = now.setDate(now.getDate() + value);
		var tomorrow = new Date(unixTimestamp);
		// console.log(tomorrow);
		var t_dd   = tomorrow.getDate();
		var t_mm   = tomorrow.getMonth()+1; //January is 0!
		var t_yyyy = tomorrow.getFullYear();
		var t_hh = tomorrow.getHours();
		var t_mi = tomorrow.getMinutes();
		// var t_ss = tomorrow.getSeconds();
		if(t_dd<10) {
			t_dd = '0'+t_dd;
		} 
		if(t_mi<10 ) {
			t_mi = '0'+t_mi;
		} 
		if(t_mm<10) {
			t_mm = '0'+t_mm;
		} 
		// console.log(tomorrow);
		tomorrow = t_yyyy + '-' + t_mm + '-' + t_dd+'T'+t_hh+':'+t_mi+':'+'00Z';
		$('.date_range').append($("<option/>", {
			value: tomorrow,
			text: 'Next '+value+' Days'
		}));
	});
	$(window).load(function(){
		var myVar = $('#ticketmaster_trigger').val();
		// console.log(myVar);
		var team_city = $('#ticketmaster_trigger_city').val();
		if(team_city =='' || team_city == null){
			var team_city = $('#fullCityName').val();
		}
		var pageCounter = 0;
		// alert(myVar);
		// alert(team_city);
		// console.log(team_city);
				$.ajax({
			url: "ajax_ticketmaster_deals_sports_dev.php",
			type: "POST",
			data: {
				formatted: team_city,
				page     : pageCounter,
				key      : myVar,
				doropdown      : myVar
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				// alert('asd');
				console.log(response)
				$('.family-ticketMaster').html(response);
				$("#loader").removeClass("loading");
			}
		});
		var data = "<?php echo $_REQUEST['ticketmaster_trigger'] ?>";
		if(data == ''){
			var data = 'sports';
		}
		$.ajax({
			url: "ajax_groupon_deals.php",
			type: "POST",
			data: {
				formatted: team_city, 
				key      : data,
				title    : 'Sports Deals'
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
		    	// console.log(response);
		    	// alert(response);
		    	$('.cityguide-events-deals').html(response);
		    	$('.carousel-control-prev').trigger('click');
		    	var owl = $(".owl-carousel");
            owl.owlCarousel({
                items: 1,
                dots: false,
                navigation: true
            });
		    	$("#loader").removeClass("loading");
		    }
		});
	});
	$(document.body).on('click', '.teamName', function(e){
		var el = $(this);
		var team = el.text();
		team = $.trim(team);
		var teamCity =$('#refine-result').val();
	    // alert(team);
	    // alert(teamCity);

	    $.ajax({
	    	url: 'sports_groupon_deals.php',
	    	type: "POST",
	    	data: {
	    		key  : team,
	    		formatted : teamCity,
	    	},

	    	success: function (response) 
	    	{
	    		$('.cityguide-events-deals').html(response);
	    	}
	    });    
	});
	$(document).on("click", ".open-GrouponDialog", function () {
		var el = $(this);
		var modal_info  = el.data('info');
		var modal_title = el.data('title');
		var modal_limit = el.data('limit');
		var modal_city  = el.data('city');
		var modal_key   = el.data('key');
		var modal_url   = el.data('url');
		$.ajax({
			url: modal_url,
			type: "POST",
			data: {
				modal_info  : modal_info,
				modal_title : modal_title,
				modal_limit : modal_limit,
				modal_city  : modal_city,
				modal_key   : modal_key
			},
			beforeSend: function()
			{
				$("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.cities_modal').html(response);
				$("#modal_loader").removeClass("loading");
			}
		});    
	});
	$('input.styled-checkbox').on('change', function() {
    $('input.styled-checkbox').not(this).prop('checked', false);  
});
	$(document.body).on('click', '.teamName', function(e){
		var windowsize = $(window).width();
		var el = $(this);
		var datatt = $(this).attr('data'); 
		var team = el.text();
		team = $.trim(team);
		// console.log(team+'yes team');
		$("#ticketmaster_trigger").val(team);
		var teamCh =  $("#ticketmaster_trigger").val();
		// console.log(teamCh);
		var teamCity = $('#refine-result').val();
		if (team == '') {
			alert("Please fill city field.");
		} else {
			$.ajax({
				type: 'POST',
	            // url: 'teamMainlisting.php',
	            url: 'ajax_ticketmaster_deals_sports_dev.php',
	            data: {
	            	// landing_page_team: myVar,
	            	key: team,
	            	// ticketmaster_trigger_city :team_city
	            	datattr :datatt,
	            	trigger : 'Sports'
	            },
	            beforeSend: function()
	            {
	            	$("#loader").addClass("loading");
	            },
	            success: function(data) {
	            	// console.log(data);
	            	$('.family-ticketMaster').html(data);
	            	if(windowsize < 767){
	            		$("#minus").hide();
	            		$("#plus").show();
	            		$(".hotel-side").hide();
	            	}
	            	$("#loader").removeClass("loading");
	            }
	        });
		}
	});
	var pageCounter = 0;
	var currentTeam = $('#ticketmaster_trigger').val();
	// $(document.body).on('click','.next',function(){
	// 	var currentTeam = $("#ticketmaster_trigger").val();
	// console.log(currentTeam);
	// });
	// $(document.body).on('click','.next',function(e){
	// 	e.preventDefault();
	// 	// console.log(currentTeam);
	// 	if(currentTeam == "" || currentTeam == null){
	// 		currentTeam = $('#fullCityName').val();
	// 	}
	// 	// console.log(currentTeam);
	// 	pageCounter++;
	// 	$.ajax({
	// 		url: "ajax_ticketmaster_pagination_dev.php",
	// 		type: "POST",
	// 		data: {
	// 	      // formatted : geodemo,
	// 	      key 		: currentTeam,
	// 	      page      : pageCounter,
	// 	      trigger   : 'Sports'
	// 	  },
	// 	  beforeSend: function()
	// 	  {
	// 	  	$("#loader").addClass("loading");
	// 	  },
	// 	  success: function (response) 
	// 	  {
	// 	  	$('#games').html(response);
	// 	  	$("#loader").removeClass("loading");
	// 	  }
	// 	});

	// });
	$(document.body).on('click','.prev',function(e){
		e.preventDefault();
		pageCounter--;
		$.ajax({
			url: "ajax_ticketmaster_pagination_dev.php",
			type: "POST",
			data: {
		      // formatted : geodemo,
		      key 		: currentTeam,
		      page      : pageCounter,
		      trigger   : 'Sports'
		  },
		  beforeSend: function()
		  {
		  	$("#loader").addClass("loading");
		  },
		  success: function (response) 
		  {
		  	$('#games').html(response);
		  	$("#loader").removeClass("loading");
		  }
		});

	});
	$(document.body).on('change','.date_range',function(){
		var search_date_range = $('.date_range').val();
		var toDate = mm + '/' + dd + '/' + yyyy;
		var date = new Date(search_date_range);
		var day = date.getDate();
		var month = date.getMonth()+1;
		var year = date.getFullYear();
		var fromDate = month +'/' +  day +'/' + year;
		$("#dpd_team").datepicker().datepicker("setDate", new Date(toDate));
		$("#dpdtm").datepicker().datepicker("setDate", new Date(fromDate));
	});
	$(document.body).on('click', '#dateRangeteam',function(){
		var search_category = $('#refine-result').val();
		var search_sub_category = $("input[name='dropDownId']:checked").val();
		var get_fromDate = $('#dpd_team').val();
		var get_toDate = $('#dpdtm').val();
		/*var textBox_city = $('#refine-result').val();
		var date1 = $('#dpd_team').val();
		var date2 = $('#dpdtm').val();
		var drop_down_keyword = $("input[name='dropDownId']:checked").val();*/
		// console.log(get_fromDate);
		// console.log(get_toDate);
		if(get_fromDate == ""|| get_fromDate == null){
			var get_fromDate = new Date();
			var get_toDate = new Date();
		}
	    /////////////////////////////////////////////////////////////
    	// date for ticket master api: fromDate hours and minutes  //
	    /////////////////////////////////////////////////////////////
	    var tm_fromDate = new Date(get_fromDate);
	    // console.log(tm_fromDate);
	    var tm_f_dd  = tm_fromDate.getDate();
	    var tm_f_mm = tm_fromDate.getMonth()+1;
	    var tm_f_yyyy = tm_fromDate.getFullYear();
	    if(tm_f_dd<10) {
	    	tm_f_dd = '0'+tm_f_dd;
	    }
	    if(tm_f_mm<10) {
	    	tm_f_mm = '0'+tm_f_mm;
	    } 
	    var fromDate = tm_f_yyyy + '-' + tm_f_mm + '-' + tm_f_dd+'T23:59:00Z';
	    ///////////////////////////////////////////////////////////
    	// date for ticket master api: toDate hours and minutes  //
	    ///////////////////////////////////////////////////////////
	    var tm_toDate = new Date(get_toDate);
	    var tm_t_dd  = tm_toDate.getDate();
	    var tm_t_mm = tm_toDate.getMonth()+1;
	    var tm_t_yyyy = tm_toDate.getFullYear();
	    if(tm_t_dd<10) {
	    	tm_t_dd = '0'+tm_t_dd;
	    }
	    if(tm_t_mm<10) {
	    	tm_t_mm = '0'+tm_t_mm;
	    } 
	    var toDate = tm_t_yyyy + '-' + tm_t_mm + '-' + tm_t_dd +'T23:59:00Z';
	    // console.log(toDate+' '+fromDate);
	    if(toDate === fromDate){
	    	toDate ='';
	    }
	    var keywords = $('#refine-result').val();
	    if(keywords == '' || keywords == null){
	    	var keywords = $('#refine-result').val();
	    }
	    $.ajax({
	    	type: 'POST',
            // url: 'teamMainlisting.php',
            url: 'ajax_ticketmaster_deals_sports_dev.php',
            data: {
            	// landing_page_team: myVar,
            	key 			: keywords,
            //	trigger 		: search_category,
            	genre 			: search_sub_category,
            	startDateTime 	: fromDate,
            	endDateTime		: toDate
            	// ticketmaster_trigger_city :team_city,
            	// formatted :team_city,
            },
            beforeSend: function()
            {
            	$("#loader").addClass("loading");
            },
            success: function(data) {
            	$('.family-ticketMaster').html(data);
            	jQuery('html, body').animate({
					scrollTop: jQuery(".family-ticketMaster").offset().top
				}, 1000);
				$("#loader").removeClass("loading");
            	
            }
        });
	});
	$(document).ready(function() {
		$("#dpd_team").datepicker({
			minDate: 0,
			dateFormat: "mm/dd/yy",
			onSelect: function (date) {
				var date2 = $('#dpd_team').datepicker('getDate');
				date2.setDate(date2.getDate() +1);
				$('#dpdtm').datepicker('setDate', date2);
                //sets minDate to dateofbirth date + 1
                $('#dpdtm').datepicker('option', 'minDate', date2);
            }
        });
		$('#dpdtm').datepicker({
			dateFormat: "mm/dd/yy",
			onClose: function () {
				var dt1 = $('#dpd_team').datepicker('getDate');
				var dt2 = $('#dpdtm').datepicker('getDate');
				if (dt2 <= dt1) {
					var minDate = $('#dpdtm').datepicker('option', 'minDate');
					$('#dpdtm').datepicker('setDate', minDate);
				}
			}
		});
	});
</script>
<script>
	(function($){
		var jQuery_2_1_1 = $.noConflict(true);
		jQuery_2_1_1('#suggestion_search').autocomplete({
			serviceUrl: 'concert-search-data.php',
			groupBy: 'category',
			minChars:'2',
			formatResult: function(suggestion) {
				var html = '<a href="'+suggestion.data.url+'" target="_blank"><img src="'+suggestion.data.img+'">';
				html += '<div class="text-format"><h3>'+suggestion.value+'</h3><span>'+suggestion.data.class+'</span><span>'+suggestion.data.date+'</span></div></a>';
				return html;
			},
			onSelect: function (suggestion) {
			// alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
		}
	});
	})(jQuery);
</script>
<script type="text/javascript">
	$(document).on("click", ".open-GrouponDialog", function () {
		var el = $(this);
		var modal_info  = el.data('info');
		var modal_title = el.data('title');
		var modal_limit = el.data('limit');
		var modal_city  = el.data('city');
		var modal_key   = el.data('key');
		var modal_url   = el.data('url');
		$.ajax({
			url: modal_url,
			type: "POST",
			data: {
				modal_info  : modal_info,
				modal_title : modal_title,
				modal_limit : modal_limit,
				modal_city  : modal_city,
				modal_key   : modal_key
			},
			beforeSend: function()
			{
				$("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.cities_modal').html(response);
				$("#modal_loader").removeClass("loading");
			}
		});    
	});
	$(document.body).on('click', '.yelpuser-review', function(){  
		var tour_id = $(this).attr('data-id');
		$.ajax({
			type: 'POST',
			url: 'ajax_tour_review_data.php',
			data: {tourid: tour_id},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function(data) {
				$('.modal-tour-review').html(data);
				$("#loader").removeClass("loading");
			}
		});
	});
</script>
<script type="text/javascript">
	var app = new Vue({
		el: '#specificGenre',
		data:{
			genreData:'',
			checkSessionServer: '',
			formatted: '<?php echo $_SESSION['city_name']; ?>',
			tittle: 'Performing Arts Deals',
			key: 'performing arts',
			ajaxRequest: false
		},

		mounted: function(){
			this.getGenreData();
		},

		methods:{
			getGenreData: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_specific_genre.php', {formatted: vm.formatted,title: vm.tittle,key:vm.key});
				vm.checkSessionServer.then(function(response){
					app.genreData = response.data;
					vm.ajaxRequest = false;
				});
			}
		}
	})

	var pageCounter = 0;
	if ($('#target').val().length === 0) {
		var geodemo = $('#geo-demo').val();
	}else{
		var geodemo = $('#target').val();
	}
	$(window).load(function(){
		$.ajax({
			url: "ajax_yelp_deals.php",
			type: "POST",
			data: {
				formatted: geodemo,
				key: 'arts'
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.comedy-events-deals').html(response);
				$("#loader").removeClass("loading");
			}
		});

		// $.ajax({
		// 	url: "ajax_ticketmaster_deals_sports_dev.php",
		// 	type: "POST",
		// 	data: {
		// 		formatted: geodemo,
		// 		key      : 'Arts+and+Theater'
		// 	},
		// 	beforeSend: function()
		// 	{
		// 		$("#loader").addClass("loading");
		// 	},
		// 	success: function (response) 
		// 	{
		// 		$('.family-ticketMaster').html(response);
		// 		$("#loader").removeClass("loading");
		// 	}
		// });
	});
	// $(document.body).on('click','.next',function(e){
	// 	e.preventDefault();
	// 	pageCounter++;
	// 	$.ajax({
	// 		url: "ajax_ticketmaster_pagination_dev.php",
	// 		type: "POST",
	// 		data: {
	// 			formatted: geodemo,
	// 			page     : pageCounter,
	// 			key      : 'Arts+and+Theater'
	// 		},
	// 		beforeSend: function()
	// 		{
	// 			$("#loader").addClass("loading");
	// 		},
	// 		success: function (response) 
	// 		{
	// 			$('.family-ticketMaster').html(response);
	// 			$("#loader").removeClass("loading");
	// 		}
	// 	});

	// });
	$(document.body).on('click','.prev',function(e){
		e.preventDefault();
		pageCounter--;
		$.ajax({
			url: "ajax_ticketmaster_pagination_dev.php",
			type: "POST",
			data: {
				formatted: geodemo,
				page     : pageCounter,
				key      : 'Arts+and+Theater'
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.family-ticketMaster').html(response);
				$("#loader").removeClass("loading");
			}
		});

	});
</script>


<script type="text/javascript">
	$(document).ready(function(){
		$("#target").on('blur',function(){
			setTimeout(function(){ var geodemo = $('#target').val(); 
				if(geodemo.length > 0){
					$.ajax({
						url: "city_search_ajax.php",
						type: "POST",
						data: {
							formatteds: geodemo
						},
						beforeSend: function()
						{
							$("#loader").addClass("loading");
						},
						success: function (response) 
						{   

							$("#loader").removeClass("loading");
						}
					});
				} 
			},1000);                   
		})

	});	
</script>
<script type="text/javascript">
	$(".form-select").change(function(){
		var value = $(this).val();
		if(value == 1){

			$('.music_shows').sort(function(a, b) {
				if (a.textContent < b.textContent) {
					return -1;
				} else {
					return 1;
				}
			}).appendTo('.col-md-6');

		}else{
			$('.music_shows').sort(function(a, b) {
				if (a.textContent < b.textContent) {
					return 1;
				} else {
					return -1;
				}
			}).appendTo('.col-md-6');
		}

	}); 
/*	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

	var checkin = $('#dpd_team').datepicker({

		beforeShowDay: function(date) {
			return date.valueOf() >= now.valueOf();
		},
		autoclose: true

	}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > checkout.datepicker("getDate").valueOf() || !checkout.datepicker("getDate").valueOf()) {

			var newDate = new Date(ev.date);
			newDate.setDate(newDate.getDate() + 1);
			checkout.datepicker("update", newDate);

		}
		$('#dpdtm')[0].focus();
	});*/
/*	$(".selectRangeteam").click(function(){

		var textBox_city = $('#refine-result').val();
		var date1 = $('#dpd_team').val();
		var date2 = $('#dpdtm').val();
		var drop_down_keyword = $("input[name='dropDownId']:checked").val();
		alert(drop_down_keyword);

	if(textBox_city == ''){
		alert('Please Enter City Name');
		return false;
	}
	if(drop_down_keyword == '' || drop_down_keyword == undefined){
		alert('Please Select Category');
		return false;
	}else{

		$.ajax({
			url: "ajax_ticketmaster_deals_sports_dev.php",
			type: "POST",
			data: {
				formatted: textBox_city, startDateTime: date1, endDateTime : date2, doropdown : drop_down_keyword
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.family-ticketMaster').html(response);
				jQuery('html, body').animate({
					scrollTop: jQuery(".family-ticketMaster").offset().top
				}, 1000);
				$("#loader").removeClass("loading");
			}
		});	
	}

});  	*/

	
	$(document).on('click','.activity',function(){
		var textBox_city = $('#refine-result').val();
		var date1 = $('#dpd_team').val();
		var date2 = $('#dpdtm').val();
		var drop_down_keyword = $(this).val();
		// alert(drop_down_keyword);
		$.ajax({
			url: "ajax_ticketmaster_deals_sports_dev.php",
			type: "POST",
			data: {
				formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword,key:drop_down_keyword
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				// alert('asd');
				// $(".close").trigger('click');

				$('.family-ticketMaster').html(response);
				jQuery('html, body').animate({
					scrollTop: jQuery(".family-ticketMaster").offset().top
				}, 1000);
				$("#loader").removeClass("loading");
			}
		});
	});

	var checkout = $('#dpdtm').datepicker({
		beforeShowDay: function(date) {
			if (!checkin.datepicker("getDate").valueOf()) {
				return date.valueOf() >= new Date().valueOf();
			} else {
				return date.valueOf() > checkin.datepicker("getDate").valueOf();
			}
		},
		autoclose: true

	}).on('changeDate', function(ev) {});
	$(document.body).on('click','.next',function(e){
		var keys = $('.drop-value').val();
		e.preventDefault();
		pageCounter++;
		$.ajax({
			url: "ajax_ticketmaster_pagination_dev.php",
			type: "POST",
			data: {
				formatted: geodemo,
				page     : pageCounter,
				key      : keys
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.family-ticketMaster').html(response);
				jQuery('html, body').animate({
					scrollTop: jQuery(".family-ticketMaster").offset().top
				}, 1000);
				$("#loader").removeClass("loading");
			}
		});

	});
	$(document.body).on('click','.prev',function(e){
		e.preventDefault();
		pageCounter--;
		$.ajax({
			url: "ajax_ticketmaster_pagination_dev.php",
			type: "POST",
			data: {
				formatted: geodemo,
				page     : pageCounter,
				key      : 'sports'
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.family-ticketMaster').html(response);
				$("#loader").removeClass("loading");
			}
		});

	});
	$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
  	// alert('asd');
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $('input:checkbox').prop("checked", false);
    $box.prop("checked", true);
} else {
	$box.prop("checked", false);
}
});
</script>
<script> 
	AOS.init();
</script>
<?php //include('blog-resources-new.php');?>

<div class="mega-deal deals-sec blue-back sports">
		<div class="flips" id="flip1">
			<div class="flips-content" id="con-left">
				<img src="images/sale-vect.png">
				<ul>
					<li>
						<div class="heading-content">
							<div class="content-sec">
								<h2>See our awesome deals</h2>
								<p>Take a look at our deals page for New York. We will save your money on Tours, Hotels and Flights. While helping you plan a fantastic vacation.</p>
								<a href="https://mysittivacations.com/random_deals.php">Explore Deals</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="flips-img" id="img-left">
			<div class="flip-img">
								<?php $curl = curl_init();

								    $cityname =  $_SESSION['city_name'];

									curl_setopt_array($curl, array(
									  CURLOPT_URL => "https://pixabay.com/api/?key=18114906-9ead1ec1eb416a800cf9c119b&q=".$cityname."&image_type=photo",
									  CURLOPT_RETURNTRANSFER => true,
									  CURLOPT_FOLLOWLOCATION => true,
									  CURLOPT_ENCODING => "",
									  CURLOPT_MAXREDIRS => 10,
									  CURLOPT_TIMEOUT => 30,
									  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									  CURLOPT_CUSTOMREQUEST => "GET",
									  CURLOPT_HTTPHEADER => array(
									    "x-rapidapi-host: vegan-news.p.rapidapi.com",
									    "x-rapidapi-key: f22b55e076msh62c3c7685773c4fp1faceajsn0b6329507cc5"
									  ),
									));

									$response = curl_exec($curl);
									$err = curl_error($curl);
									curl_close($curl);
									$resultpix =json_decode($response, true);
									// print_r($resultpix['hits'][0]['largeImageURL']); ?>
								<img src="<?php print_r($resultpix['hits'][0]['largeImageURL']); ?>">
							</div>
			</div>
		</div>				
	</div>
<?php include('footer-newfile.php'); ?>

<style>

	.desktop-filter {display: block;}
	.mobile-filter {display: none;}
	.search {width: 100%;}
	.search input {height: 57px;text-indent: 10px;}

	@media screen and (max-width:767px){
    .modal-header .close {
        display: -webkit-inline-flex!important;
        display: inline-flex;
    }
		.modal-body .slide.aos-init.aos-animate {
    display: none;
}
		.desktop-filter {display: none;}
		.mobile-filter {display: block;}
		.resturant_listhead .sorf-filter a {display: none;}
		.sorf-filter span {margin: 0 10px 0 0px;}
		.add_img {display: none;}
		.mobile-filter ul {display: flex;align-items: center;justify-content: space-around;flex-wrap: wrap;margin: 0;}
		.mobile-filter ul li a {font-size: 16px;}
		.mobile-filter ul li a i {margin: 0 10px 0 0px;}
		.mobile-filter {border-top: 1px solid #ccc;padding: 0px 0 0px;border-bottom: 1px solid #ccc;margin: 0 0 20px;}
		.mobile-filter ul li {width: 50%;text-align: center;border-right: 1px solid #ccc;padding: 5px;}
		.mobile-filter ul li:last-child {border: 0;}
		.filter_box {padding-right: 0px;}
		h5.filter-heading {margin-bottom: 20px;}
		.search input {height: 57px;font-size: 15px;text-indent: 10px;}
		.modal-content {border-radius: 10px;box-shadow: 0 0px 5px rgb(0 0 0 / 25%);}
		.modal-header {padding: 15px 10px;}
		footer.footer.sec_pad {text-align: center;}
		/*.rind-the-right-section .sidebar-listing .specialities-checkbox .listing-check {display: none;}*/
		.banner-section.hotel-hero {margin: 25px 0 50px;}
	}
	.specialities-checkbox{
		display: block;
	}
	  @media screen and (max-width:767px){
        .specialities-checkbox {display: none !important;}
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		if( $(window).width() < 640 ) {
			$("#plus").show();
			$(".hotel-side").hide();
			$("#plus").click(function(){
				$(".hotel-side").slideDown("show");
				$("#plus").hide();
				$("#minus").show();
			});
			$("#minus").click(function(){
				$(".hotel-side").slideUp("hide");
				$("#plus").show();
				$("#minus").hide();
			});
		}	
	});	
</script>