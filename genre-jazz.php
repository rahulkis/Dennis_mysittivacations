<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Jazz Music"; 
session_start();
if(isset($_SESSION['city_name'])){

	include('header-newfile.php');	// not login
}else{
	header('location:https://mysittivacations.com/');
}
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
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
					<h2 class="mb-5">Blue Music</h2>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="content-bannersss">
					<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

					<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>" required="">

					<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</section>-->
<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec" style="background-image:url(images/jazzs.jpg)"> 
	<div class="container">
		<div class="mobile-hero">
			<img src="images/jazzs.jpg">
		</div>
		<div class="carousel-caption-top">
		   <h1>Jazz Music</h1>
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
										<a  id="hitAjaxwithCity" class="search-btn hitbutton">Search </a>
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
}?>
<div class="rind-the-right-section comedy-sec">
		<div class="container n-contain ">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
					<div class="sidebar-listing">
						
						<div class="specialities-checkbox">
							<div class="searcher-sec">
								<label class="custom-control-label">Search By Name</label>
								<div class="form-group">
									<input type="text" id="refine-result" value="<?php echo $_SESSION['city_name']; ?>" class="form-control" placeholder="Search by city name"> 
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
									<a href="#" data-toggle="modal" data-target="#filter-popup"><i class="fa fa-filter" aria-hidden="true"></i>Filter</a> 
								</li>
							</ul>
						</div>
						<div class="modal fade" id="filter-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Category</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
										<div class="modal-body">
												<div class="listing-check">
								<h4>CATEGORY</h4>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck01" name ="dropDownId" value="all%20genre" >
								  <label class="custom-control-label" for="customCheck01">All Genre</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck02" name ="dropDownId" value="alternative">
								  <label class="custom-control-label" for="customCheck02">Alternative</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck03" name ="dropDownId" value="ballads/romantic">
								  <label class="custom-control-label" for="customCheck03">Ballads/Romantic</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck04" name ="dropDownId" value="blues">
								  <label class="custom-control-label" for="customCheck04">Blues</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck05" name ="dropDownId" value="chanson%20francaise">
								  <label class="custom-control-label" for="customCheck05">Chanson Francaise</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck06" name ="dropDownId" value="children%20music">
								  <label class="custom-control-label" for="customCheck06">Children's Music</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck07" name ="dropDownId" value="classical">
								  <label class="custom-control-label" for="customCheck07">Classical</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck08" name ="dropDownId" value="country">
								  <label class="custom-control-label" for="customCheck08">Country</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck09" name ="dropDownId" value="dance/electronic">
								  <label class="custom-control-label" for="customCheck09">Dance/Electronic</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck10" name ="dropDownId" value="folk">
								  <label class="custom-control-label" for="customCheck10">Folk</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck11" name ="dropDownId" value="hip-hop/rap">
								  <label class="custom-control-label" for="customCheck11">Hip-Hop/Rap</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck12" name ="dropDownId" value="holiday">
								  <label class="custom-control-label" for="customCheck12">Holiday</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck08" name ="dropDownId" value="jazz">
								  <label class="custom-control-label" for="customCheck08" checked="">Jazz</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck09" name ="dropDownId" value="latin">
								  <label class="custom-control-label" for="customCheck09">Latin</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck10" name ="dropDownId" value="metal">
								  <label class="custom-control-label" for="customCheck10">Metal</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck11" name ="dropDownId" value="new%20age">
								  <label class="custom-control-label" for="customCheck11">New Age</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck12" name ="dropDownId" value="other">
								  <label class="custom-control-label" for="customCheck12">Other</label>
								</div>
							</div>
										</div>
								</div>
							</div>
						</div>
						<!-- <div class="specialities-checkbox">
							<div class="listing-check">
								<h4>CATEGORY</h4>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck01" name ="dropDownId" value="Arts and Theater" >
								  <label class="custom-control-label" for="customCheck01">Arts and Theater</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck02" name ="dropDownId" value="Broadway">
								  <label class="custom-control-label" for="customCheck02">Broadway</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck03" name ="dropDownId" value="Off-Broadway">
								  <label class="custom-control-label" for="customCheck03">Off-Broadway</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck04" name ="dropDownId" value="Ballet and Dance">
								  <label class="custom-control-label" for="customCheck04">Ballet and Dance</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck05" name ="dropDownId" value="Classical">
								  <label class="custom-control-label" for="customCheck05">Classical</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck06" name ="dropDownId" value="Comedy">
								  <label class="custom-control-label" for="customCheck06">Comedy</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck07" name ="dropDownId" value="Film Festivals">
								  <label class="custom-control-label" for="customCheck07">Film Festivals</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck08" name ="dropDownId" value="Museums and Exhibits">
								  <label class="custom-control-label" for="customCheck08">Museums and Exhibits</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck09" name ="dropDownId" value="Music" checked="">
								  <label class="custom-control-label" for="customCheck09">Musicals</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck10" name ="dropDownId" value="Opera">
								  <label class="custom-control-label" for="customCheck10">Opera</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck11" name ="dropDownId" value="Plays">
								  <label class="custom-control-label" for="customCheck11">Plays</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck12" name ="dropDownId" value="More Arts and Theater">
								  <label class="custom-control-label" for="customCheck12">More Arts and Theater</label>
								</div>
							</div>
						</div> -->

							<div class="specialities-checkbox">
							<div class="listing-check">
								<h4>CATEGORY</h4>
								
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck01" name ="dropDownId" value="all%20genre" >
								  <label class="custom-control-label" for="customCheck01">All Genre</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck02" name ="dropDownId" value="alternative">
								  <label class="custom-control-label" for="customCheck02">Alternative</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck03" name ="dropDownId" value="ballads/romantic">
								  <label class="custom-control-label" for="customCheck03">Ballads/Romantic</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck04" name ="dropDownId" value="blues">
								  <label class="custom-control-label" for="customCheck04">Blues</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck05" name ="dropDownId" value="chanson%20francaise">
								  <label class="custom-control-label" for="customCheck05">Chanson Francaise</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck06" name ="dropDownId" value="children%20music">
								  <label class="custom-control-label" for="customCheck06">Children's Music</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck07" name ="dropDownId" value="classical">
								  <label class="custom-control-label" for="customCheck07">Classical</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck08" name ="dropDownId" value="country">
								  <label class="custom-control-label" for="customCheck08">Country</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck09" name ="dropDownId" value="dance/electronic">
								  <label class="custom-control-label" for="customCheck09">Dance/Electronic</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck10" name ="dropDownId" value="folk">
								  <label class="custom-control-label" for="customCheck10">Folk</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck11" name ="dropDownId" value="hip-hop/rap">
								  <label class="custom-control-label" for="customCheck11">Hip-Hop/Rap</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck12" name ="dropDownId" value="holiday">
								  <label class="custom-control-label" for="customCheck12">Holiday</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck08" name ="dropDownId" value="jazz">
								  <label class="custom-control-label" for="customCheck08" checked="">Jazz</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck09" name ="dropDownId" value="latin">
								  <label class="custom-control-label" for="customCheck09">Latin</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck10" name ="dropDownId" value="metal">
								  <label class="custom-control-label" for="customCheck10">Metal</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck11" name ="dropDownId" value="new%20age">
								  <label class="custom-control-label" for="customCheck11">New Age</label>
								</div>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input activity" id="customCheck12" name ="dropDownId" value="other">
								  <label class="custom-control-label" for="customCheck12">Other</label>
								</div>
							</div>
						</div>
						
						<div class="adver-comedy">
							<a href="https://www.dpbolvw.net/click-8265264-13165240" target="_top">
								<img src="https://www.lduhtrp.net/image-8265264-13165240" width="200" height="600" alt="" border="0"/>
							</a>
							<a href="https://www.tkqlhce.com/click-8265264-10417493" target="_top">
								<img src="https://www.tqlkg.com/image-8265264-10417493" width="300" height="250" alt="" border="0"/>
							</a>
						</div>
						<?php 
						function groupon_api_call($limit,$city,$key){
						$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&address=".urlencode($_SESSION['city_name']);

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
							$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
							$output= json_decode($geocode);
							$latitude = $output->results[0]->geometry->location->lat;
							$longitude = $output->results[0]->geometry->location->lng;
							$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
						else:

							if(!empty($key)):
						//		$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
									$urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(subcategory3:".$key.")&divisionLoc=".$latitude.",".$longitude."&pageType=holiday&includeHtml=true";
							else:

								$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
							endif;
						endif;
						$result_get = file_get_contents($urlgo);
						$get_all_data = json_decode($result_get, true);
						$get_deals = $get_all_data['deals'];
						return $get_deals;
					}
					?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
					<div class="white-box-area inner rest-deals">
						<div class="row">
							<div class="col-md-12 col-12">
								<div class="heading-content">
									<div class="content-sec">
									<h4>Groupon Performing Jazz Music</h4>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-12">
								<section class="client-sec comedy">
									<div class="testimonial-section products">
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio">
									   <?php
									   $get_deals = groupon_api_call('20','','jazz-blues');
									   if(!empty($get_deals)){ ?>

											
												<?php  $i= 0;
												foreach ($get_deals as $homeData):
												if($i%2==0){
													$dataaos='zoom-in-right';
												}else{
													$dataaos='zoom-in-left';
												}?>
													<div data-aos="<?php echo $dataaos?>" class="testimonial-block product section_<?php echo $i; ?>">
														<?php   $i++; 
														echo $homeData['cardHtml']; ?>
														
													</div>
													<?php 
												$i++;
												endforeach;?>
										<?php } ?>
									   </div>
									</div>
									
									<div class="testimonial-section products">
										<div class="head-yelp">
											<h3> Deals on <img src="images/yelpnew.png"></h3>
										</div>
									   <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
											<?php
											$getyelpTourData = yelp_api_call(20,$_SESSION['city_name'],'music');
											foreach ($getyelpTourData as $homeData):
											$tour_id = $homeData->id;
											$tour_name= $homeData->name;
											$tour_image = $homeData->image_url;
											$tour_url = $homeData->url;
											$tour_review_count = $homeData->review_count;
											$tour_rating = $homeData->rating;
											$tour_location_address1 = $homeData->location->address1;
											$tour_location_address2 = $homeData->location->address2;
											$tour_city = $homeData->location->city;
											$tour_zipCode = $homeData->location->zip_code;
											$tour_country = $homeData->location->country;
											$tour_state = $homeData->location->state; 
											$tour_phone = $homeData->display_phone;?>
											<div data-aos="zoom-in-right" class="testimonial-block product">
												<a href="<?php echo $tour_url; ?>" target="_blank">
													<div class="discount-block">
													<?php if(!empty($tour_image)) : ?>
														<img src="<?php echo $tour_image; ?>" alt="<?php echo $tour_name; ?>">
													<?php else : ?>
														<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" alt="no-image">
													<?php endif; ?>
														<div class="discount-content">
															<h3><?php echo $tour_name; ?></h3>
															<div class="stars">
																<ul>
																	<?php for($x=1;$x<=$tour_rating;$x++): ?>
																		<li><i class="fa fa-star" aria-hidden="true"></i></li>
																	<?php endfor; ?>
																	<?php if (strpos($tour_rating,".")) : ?>
																		<li><i class="fa fa-star" aria-hidden="true"></i></li>
																		<?php 
																		$x++;
																	endif; ?>
																</ul>
																<p style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
																		(<?php echo $tour_review_count ; ?> Ratings)
																	</p>
															</div>
														</div>
															
															<p>
																<?php $for_counter = 0 ;
																$total = count((array)$homeData->categories)-1; 
																foreach ($homeData->categories as $category){
																	echo $category->title;
																	if($for_counter != $total){
																		echo ", ";
																	}
																	$for_counter++; 
																} ?>
															</p>
															<div class="comedy-detail">
																<ul>
																	<li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_location_address1.' '.$tour_location_address2.' '.$tour_city.' '.$tour_state.' '.$tour_zipCode ; ?> </li>
																	<?php if ( $tour_phone != ''){?>
																	<li><i class="fa fa-phone" aria-hidden="true"></i>  <?php echo $tour_phone ; ?></li>
																	<?php } ?>
																	
																</ul>
															</div>
															
															
														
												</div>
												</a>
											</div>
										<?php endforeach;?>
											
											
									   </div>
									</div>
									
									<div class="sort-display-sec">
										<div class="sort-content">
											<p>Popular shows in <?php echo $_SESSION['city_name']; ?>. Displaying 1–10</p>
										</div>
										<div class="custom-select-box">
											<span>Sort</span>
										  <select class="form-select" aria-label="Default select example">
											  <option selected="">Alphabetically</option>
											  <option value="1">Ascending</option>
											  <option value="2">Descending</option>
											</select>
										</div>
									</div>
									<!--<div class="filter_head resturant_listhead">
										<div class="heading mb-0">
											<h4>Popular shows in <?php //echo $_SESSION['city_name']; ?>. Displaying 1–10</h4>
										</div>
										<div class="sorf-filter">
											<a href="#"><i class="fas fa-bars"></i></a>
											<a href="#"><i class="fas fa-th-large"></i></a>
											<span>Sort By
											</span>
											<select class="form-select" aria-label="Default select example">
												<option selected="">Alphabetically</option>
												<option value="1">Ascending</option>
												<option value="2">Descending</option>
											</select>
										</div>
									</div>-->
									
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
									$urlgo = "https://app.ticketmaster.com/discovery/v2/events?apikey=RfcE2uw4xpNzXAWjzvXzA5xxiKuuU9G4&keyword=".$key."&sort=date,asc&countryCode=US&city=".$city."&page=".$page."&classificationName=[".$trigger."]";
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
						$dropdown_value = 'jazz';

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
							$content=0;
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

								if($content%2==0){
									$dataaos="zoom-in-right";
								}else{
									$dataaos="zoom-in-left";
								}

								$html .= "<div class='slide' data-aos='".$dataaos."'>
								
								<a href=".$eventUrl." target='_blank'>
									<div class='discount-block'>
										<div class='cities'>
										<img src= ".$image." >
										</div>
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
								</a>
								</div>";
								$content++;
								
							}
						}else{
							echo '<h1 style="color:black; text-align:center; font-size:18px;">No Records Found</h2>';
						}
						echo $html;?>
								<div class='pagination'>
									<?php if ($totalPages > 1 ) { ?>
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

									<?php } ?>
								
								</div>
									</div>
								</section>
							</div>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
								
								<div class="powerdby" data-aos="zoom-in-down">
									<a href="#">Hotel rating provided by TrustYou™ <img src="images/pwrd.png"></a>
									<p>Powered by <b>Travelpayouts</b></p>
								</div>
							</div>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
								<div class="accordion comedy" id="accordionExample">
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingOne">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
											What are the hotels close to the center of <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=center&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script
										  </div>
										</div>
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingTwo">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											What are the best pet-friendly hotels in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=pets&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingThree">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											What are the best luxury hotels in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=luxury&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									  <div class="accordion-item">
										<h2 class="accordion-header" id="headingfour">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
											What are the top hotels in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=luxury&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
									   <div class="accordion-item">
										<h2 class="accordion-header" id="headingfive">
										  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
											Which hotels have the best ratings in <?php echo $_SESSION['city_name'];?>
										  </button>
										</h2>
										<div id="collapsefive" class="accordion-collapse collapse" aria-labelledby="headingfive" data-bs-parent="#accordionExample">
										  <div class="accordion-body">
											<script src="https://www.travelpayouts.com/blissey/scripts_en.js?currency=usd&categories=5stars&id=<?php echo $city_data; ?>&type=compact&marker=130544&trs=26480&powered_by=true&host=search.hotellook.com&locale=en&limit=5&nobooking=" charset="utf-8"></script>
										  </div>
										</div>
									  </div>
								</div>
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

			$.ajax({
				url: "ajax_ticketmaster_deals_dev.php",
				type: "POST",
				data: {
					formatted: geodemo,
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
	<script src="js/new/bootstrap-datepicker.min.js"></script>
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
		$(".selectRangeteam").click(function(){

			var textBox_city = $('#refine-result').val();
			var date1 = $('#dpd_team').val();
			var date2 = $('#dpdtm').val();
			var drop_down_keyword = $("input[name='dropDownId']:checked").val();
			//alert(drop_down_keyword);

			if(textBox_city == ''){
				alert('Please Enter City Name');
				return false;
			}
			if(drop_down_keyword == '' || drop_down_keyword == undefined){
				alert('Please Select Category');
				return false;
			}else{

				$.ajax({
					url: "ajax_ticketmaster_deals_dev.php",
					type: "POST",
					data: {
						formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
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

		});  	

		var nowTemp = new Date();
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
		});
		$(document).on('click','.activity',function(){
			var textBox_city = $('#refine-result').val();
			var date1 = $('#dpd_team').val();
			var date2 = $('#dpdtm').val();
			var drop_down_keyword = $("input[name='dropDownId']:checked").val();
			$.ajax({
				url: "ajax_ticketmaster_deals_dev.php",
				type: "POST",
				data: {
					formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
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
            var pageCounter = 0;
            var geodemo = $('#refine-result').val();
            var dropValue = $('.drop-value').val();
            e.preventDefault();
            pageCounter++;
            // alert(dropValue);
            $.ajax({
                url: "ajax_ticketmaster_pagination_dev.php",
                type: "POST",
                data: {
                    formatted: geodemo,
                    page     : 0,
                    key      : dropValue
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
            var pageCounter = 0;
            var geodemo = $('#refine-result').val();
            var dropValue = $('.drop-value').val();
            pageCounter--;
            $.ajax({
                url: "ajax_ticketmaster_pagination_dev.php",
                type: "POST",
                data: {
                    formatted: geodemo,
                    page     : pageCounter,
                    key      : dropValue
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
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
  	$box.prop("checked", false);
  }
});
</script>
<script>
	AOS.init();
</script>
<?php include('blog-resources-new.php');?>
<?php include('footer-newfile.php'); ?>

<style>

	.desktop-filter {display: block;}
	.mobile-filter {display: none;}
	.search {width: 100%;}
	.search input {height: 57px;text-indent: 10px;}

	@media screen and (max-width:767px){
		.desktop-filter {display: none;}
		.mobile-filter {display: block;}
		.resturant_listhead .sorf-filter a {display: none;}
		.sorf-filter span {margin: 0 10px 0 0px;}
		.add_img {display: none;}
		.mobile-filter ul {display: flex;align-items: center;justify-content: space-around;flex-wrap: wrap;}
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
	}
</style>

<script>
	jQuery(document).ready( function (){
		setTimeout(function(){
			for (var i = 1; i <= 20; i++) {
					//alert(i);
					 // console.log('.section_'+i+' .cui-image');
					 var pics_str = jQuery('.section_'+i+' .cui-image').attr('data-srcset');
                  // var pics_arr = '';
                  console.log(pics_str);
                  if( pics_str != undefined){
                  	
                  	var pics_arr = pics_str.split(',');
                  	pics_str = '';
                  	jQuery.each(pics_arr, function(index, el) {
                  		imgPath = this.trim();
                  		imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   console.log('section_'+i+'qa');
                   jQuery('.section_'+i+' .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
                 });
                  }
                }
              },3000);
	});
</script>


<script>
	
	$('#ProductSlide').owlCarousel({
		loop:true,
		margin:20,
		nav:false,
		responsiveClass:true,
		dots:true,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:1,
			},
			1100:{
				items:1,
				loop:true
			}
		}
	})
	$('#ProductSlide2').owlCarousel({
		loop:true,
		margin:20,
		nav:false,
		responsiveClass:true,
		dots:true,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:1,
			},
			1100:{
				items:1,
				loop:true
			}
		}
	})
	$('#ProductSlide3').owlCarousel({
		loop:true,
		margin:20,
		nav:false,
		responsiveClass:true,
		dots:true,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:1,
			},
			1100:{
				items:1,
				loop:true
			}
		}
	})
	$('#ProductSlide4').owlCarousel({
		loop:true,
		margin:20,
		nav:false,
		responsiveClass:true,
		dots:true,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:1,
			},
			1100:{
				items:1,
				loop:true
			}
		}
	})
	$('#ProductSlide-audio').owlCarousel({
		loop:true,
		margin:20,
		nav:true,
		responsiveClass:true,
		dots:false,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:2,
			},
			1100:{
				items:3,
				loop:true
			}
		}
	})
	$('#ProductSlide-audio2').owlCarousel({
		loop:true,
		margin:20,
		nav:true,
		responsiveClass:true,
		dots:false,
		responsive:{
			0:{
				items:1,
			},
			768:{
				items:2,
			},
			1100:{
				items:3,
				loop:true
			}
		}
	})
	
	</script>
	<script>
	  AOS.init();
	  
	  AOS.init({disable: 'mobile'});
	</script>
	<style type="text/css">
    @media screen and (max-width:767px){
        .specialities-checkbox {display: none !important;}
}
.specialities-checkbox {display: block;}
</style>