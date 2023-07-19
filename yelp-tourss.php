<?php
$json = file_get_contents('php://input');
$someArray = json_decode($json, true);
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
$titleofpage="Book Tour Packages Online  | Yelp Tour | MySittiVacations"; 
if(isset($_REQUEST['city'])){
	$_SESSION['city_name'] = $_REQUEST['city'];
}
if(isset($_SESSION['city_name'])){

	include('Header-new.php');	// not login
}else{
	header('location:https://mysittivacations.com/');
}
?>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="v2_content_inner2">
	<div id="loader"></div>
</div>
<section class="inner_page_hero sec_pad things-to-do">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="hero_section_content">
					<h2 class="mb-5">Popular things to do
						in <?php echo $_SESSION['city_name']; ?>
					</h2>
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
</section>
<!--end of hero section-->
<?php include('category-navigation.php'); ?>
<!--end of category -->
<section class="travels sec_pad what_do pt-0">
	<div class="container">
		<div class="heading">
			<h4>Popular things to do</h4>
			<p>Find fun places to see and things to do experience the art, museums, music, zoos
			</p>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="what_do_slider owl-carousel owl-theme">
				<div class="grid">
					<a id="top_links" name="Museum" >
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img1.png" alt="Museum" class="img-fluid w-100">
						</div>
						<h3>Museum</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="Sightseeingguide" name="Sightseeing" >
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img2.png" alt="Sightseeing" class="img-fluid w-100">
						</div>
						<h3>SIGHTSEEING/TOURS</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="tourforfun" name="Tours" >
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img3.png" alt="DAY TRIP" class="img-fluid w-100">
						</div>
						<h3>DAY TRIP</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="nightlife_yelp" name="top attractions">
						<div class="image_sq_htfix"> 
							<img src="img/ss/ttd_img4.png"  alt="top attractions" class="img-fluid w-100">
						</div>
						<h3>TOP ATTRACTIONS</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="nightlife_yelp" name="nightlife" >
						<div class="image_sq_htfix"> 
							<img src="images/nightlife.jpg" alt="nightlife" class="img-fluid w-100">
						</div>
						<h3>Nightlife</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="top_links" name="Fine Dinning" >
						<div class="image_sq_htfix"> 
							<img src="images/fine-dining.jpg" class="img-fluid w-100" alt="Fine Dinning">
						</div>
						<h3>Fine Dinning</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a id="top_links" name="Shopping">
						<div class="image_sq_htfix"> 
							<img src="images/shopping-new.jpg" alt="Shopping"  class="img-fluid w-100">
						</div>
						<h3>Shopping</h3>

					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--end of travels-->
<section class="travels sec_pad bg_grey what_do pb-0">
	<div class="container">
		<div class="heading">
			<h4>Local Music</h4>
			<p>Enjoy the music of <?php echo $_SESSION['city_name']; ?> local artist </p>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="what_do_slider owl-carousel owl-theme">
				<?php
				$music = mysql_query("SELECT music_link,music_image,music_type,image_name FROM music_categories");
				$counter = '0';
				while($row = mysql_fetch_assoc($music)){ ?>
					<div class="item">
						<a href="<?php echo  $row['music_link']; ?>">
							<div class="image_sq_htfix"> 
								<img src="images/<?php echo  $row['music_image']; ?>" alt="<?php echo  $row['image_name']; ?>" class="img-fluid w-100">
							</div>
							<h3><?php echo  $row['music_type']; ?></h3>
						</a>
						<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<!--end of local music-->
<section class="travels sec_pad bg_grey what_do pb-0">
	<div class="container">
		<div class="heading">
			<h4>Popular Entertainment</h4>
			<p>Tons of exciting things for entertainment  </p>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="what_do_slider owl-carousel owl-theme">
				<div class="grid">
					<a id="top_links" name="escape%20%room" >
						<img src="img/ss/entertainment1.png" class="img-fluid w-100">
						<h3>escape room</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a href="family.php">
						<img src="img/ss/entertainment2.png" class="img-fluid w-100">
						<h3>family</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a href="performing-arts.php">
						<img src="img/ss/entertainment3.png" class="img-fluid w-100">
						<h3>performing arts</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a href="brewery.php">
						<img src="img/ss/entertainment4.png" class="img-fluid w-100">
						<h3>winery/brewery</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
				<div class="grid">
					<a href="comedy.php">
						<img src="images/comedy.png" alt="Comedy" class="img-fluid w-100">
						<h3>comedy</h3>
					</a>
					<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--end of popular entertainment-->
<section class="travels sec_pad bg_grey what_do ">
	<div class="container">
		<div class="heading">
			<h4>Sports Tickets</h4>
			<p>Enjoy the local pass time </p>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="what_do_slider owl-carousel owl-theme">
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
		                            // echo $sql;
				$result = mysql_query($sql);
				$nurows = mysql_num_rows($result);
				$ignore = ['id', 'state_name', 'state_code', 'city', 'Colleges'];
				if($nurows > 0){
					$row = mysql_fetch_assoc($result);
					$counter = 0;
					foreach ($row as $key => $value) {
						if(!in_array($key, $ignore) && trim($key) != '') {
			                                  // echo $value."</br>";
							if(strtok($value, ',') != ''){
								if(strtolower($key) == 'nba'){
									$altCode = "basketball Match";
								}elseif(strtolower($key) == 'nfl'){
									$altCode = "Rugby match";
								}elseif(strtolower($key) == 'mlb'){
									$altCode = "baseball match";
								}else{
									$altCode="";
								}
								?>

								<div class="grid">
									<a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo strtok($value, ','); ?>&city=<?php echo  $_SESSION['city_name']; ?>">
										<div class="image_sq_htfix">
											<img src="images/<?php echo strtolower($key); ?>.jpg" alt="<?php echo $altCode; ?>" class="img-fluid w-100">
										</div>
										<h3><?php echo  $key; ?></h3>
									</a>
									<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
								</div>
								<?php $counter++; 
								$counter_sport++;
							}
						}
					}
				}
				?>
			</div>
		</div>
	</div>
</section>
<!--end of travels-->
<section class="gateways sec_pad">
	<div class="container">
		<div class="heading">
			<div class="row">
				<div class="col-lg-9">
					<h4>Adrenaline Rush</h4>
					<p>Amazing flight,helicopter tours, and tons of exciting things to do</p>
				</div>
				<div class="col-lg-3 text-lg-end">
					<a data-toggle="modal" data-target="#popularcitiesModal" data-trigger="specific_page_modal" data-title="Adrenaline Rush"  data-city="<?php echo $_SESSION['city_name']; ?>" data-table2="specific_adrenaline" class="btn btn-outline-dark px-4">View all</a>
				</div>
			</div>
		</div>
		<div class="gateways_inner">
			<div class="row">
				<?php
				$randon_deals = "SELECT link,image_link,title,image_name FROM specific_adrenaline WHERE city1 like '%".$_SESSION['city_name']."%' or city2 like '%".$_SESSION['city_name']."%' limit 4";
				$result = $mysqli->query($randon_deals);
				$counter = '0';
				foreach ($result as $value) {
					?>
					<div class="col-lg-3 col-md-6">
						<div class="item">
							<a href="<?php echo $value['link'] ?>">
								<img src="<?php echo $value['image_link']?>" alt="<?php echo $value['image_name']; ?>" class="img-fluid w-100">
								<div class="item_content">
									<h3><?php echo substr($value['title'], 0, 20).'...'; ?></h3>
									<!-- <p>At vero eos et accusamus et iusto odio dignissimos ducimus  bla </p> -->
								</div>
							</a>
						</div>
					</div>
					<?php
					$counter++; 
				}
				?>
			</div>
		</div>
	</div>
</section>
<!--end of Adrenaline Rush -->
<section class="see_beautiful sec_pad bg_grey">
	<div class="container">
		<div class="heading">
			<div class="row">
				<div class="col-lg-9">
					<h4>Tours & Travel</h4>
					<p>Enjoy the scenic views of National Parks</p>
				</div>
				<div class="col-lg-3 text-lg-end">
					<a href="#" data-toggle="modal" data-target="#more_audio_tourss" target="_blank" class="btn btn-outline-dark px-4">View all</a>
				</div>
			</div>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="siteseen_slider owl-carousel owl-theme">
				<?php if($_SESSION['city_name'] == 'Washington D.C.'){
					$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 10";
				}else{
					$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 10";
				}
				$result = $mysqli->query($randon_deals);
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
						<div class="grid">
							<a href="<?php echo $buy_url; ?>"  target="_blank">
								<div class="image_htfix">
									<img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>" class="img-fluid w-100">
								</div>
								<div class="item_content">
									<h3><?php echo substr($value['title'], 0, 20).'...'; ?></h3>
								</div>
							</a>
						</div>
					<?php } 
				}?>
			</div>
		</div>
	</div>
</section>
<!--end of see_beautiful -->
<?php $get_deals = groupon_api_call('6',$someArray['formatted'],'Tours');
if(!empty($get_deals)){ ?>
	<section class="gateways sec_pad">
		<div class="container">
			<div class="heading">
				<div class="row">
					<div class="col-lg-9">
						<h4>Groupon Tour Discounts</h4>
						<p>Stories, tips, and guides</p>
					</div>
					<div class="col-lg-3 text-lg-end">
						<a href="/random_deals.php" class="btn btn-outline-dark px-4">View all</a>
					</div>
				</div>
			</div>
			<div class="gateways_inner">
				<div class="row">
					<?php  $i= 0;
					foreach ($get_deals as $homeData):
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt =  $homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['merchant']['name']; 
						$out =  substr($tourname,0,20).' ...';
						if($discountPercent != 0){
							$i++;?>
							<div class="col-lg-3 col-md-6">
								<div class="item groupon_item">
									<a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
										<div class="image_htfix_mid">
											<img src="<?php echo $homeData['grid4ImageUrl']; ?>" class="img-fluid w-100">
										</div>
										<div class="item_content">
											<h3><?php echo $out ; ?> </h3>
											<div class="groupon_price">
												<span class="offer_price"> <?php echo $homeData['options'][0]['price']['formattedAmount'] ;?></span>
												<span class="real_price"> <span><?php echo $homeData['options'][0]['value']['formattedAmount']; ?></span> (<?php echo $homeData['options'][0]['discountPercent']; ?>% Off) </span>
											</div>
										</div>
									</a>
								</div>
							</div>
						<?php } 
					endforeach;?>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
<?php function groupon_api_call($limit,$city,$key){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
    // echo $prepAddr;
		$key = str_replace(' ','+',$key);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
    // endif;
	else:

		if(!empty($key)):
			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
		else:

			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
		endif;
    // endif;

	endif;
  // return $urlgo;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}?>
<!--end of Grupon discount -->
<section>
	<div class="container">
		<hr>
	</div>
</section>
<section class="Hotel-sanf sec_pad">
	<div class="container">
		<div class="heading">
			<div class="row">
				<div class="col-lg-12">
					<h4><span class="top_title">Top Attractions</span> in <?php echo $_SESSION['city_name']; ?> </h4>
				</div>
				<!-- <div class="col-lg-12 text-lg-center">
					<a data-toggle="modal" data-target="#more_audio_tourss" target="_blank" class="btn btn-outline-dark px-4">View all</a>
				</div> -->
			</div>
		</div>
		<div class="oneArticle"></div>
		<div class="discounts_inner">
			<div class="row">
				<?php
				$guide_city = "SELECT * FROM  get_guide_tours WHERE city_name LIKE '%".$_SESSION['city_name']."%' LIMIT 1";
				$guide_city_result = $mysqli->query($guide_city);
				$guide_city_count = $guide_city_result->num_rows;
				if($guide_city_count > 0){
					foreach ($guide_city_result as $key => $value) {
						echo $value['content'];
					}
				}else{
					$string =  substr($_SESSION['city_name'], 0, 3);
					$string =  strtoupper(  $string ); 
					if( $_SESSION['city_name'] == "San Sebastián"){
						$string = "EAS";
					}
					if( $_SESSION['city_name'] == "İstanbul"){
						$string = "IST";
					}
					echo  $fiveStar = '<script src="//c108.travelpayouts.com/content?promo_id=4039&shmarker=iddqd&trs=26480&place=&items=25&locale=en-US&powered_by=true&iata='.$string.'" charset="utf-8"></script>';
				}?>
			</div>
		</div>
	</div>
</section>
<!--end of Top Attraction -->

<div class='modal fade' id='myModal' role='dialog'>

	<div class='modal-dialog'>

		<div class='modal-content'>
			<div class='modal-header'>

				<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

				<button type='button' class='close' data-dismiss='modal'>&times;</button>
				<h4 class='modal-title'></h4>
				<h1>Tours</h1>
			</div>
			<div class="tuorfun">
				<!-- <h1>Tours (tours4fun)</h1> -->
				<!-- <h1>Tours</h1> -->
				<ul class="modal-toour" id='tourdata'>

				</ul> 	 
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			</div>
		</div>

	</div>
</div>
<!-- Us popular city -->
<input type="hidden" id="inputCity" value="<?php if(isset($_SESSION['city_name'])){ echo $_SESSION['city_name']; } ?>">
<div class='modal fade' id='popularcitiesModal' role='dialog'>

	<div class='modal-dialog modal-dialog-centered modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5>Popular Cities</h5>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
				
			</div>
			<div class="modal-body">
				<div class="cities_modal">
					<p></p>

					<div id="modal_loader"></div> 
				</div>
			</div>
			
			<!-- <div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			</div> -->
		</div>
	</div>
</div>
<?php if(isset($_GET['yelp']) && $_GET['yelp'] != 'peek'){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var limit = "10";
			var geodemo = jQuery('#target').val();
			var quick_link = "<?php echo $_GET['yelp'] ?>";
			jQuery.ajax({
				url: "ajax_yelp_dev.php",
				type: "POST",
				data: {
					limit : limit,
					formatted: geodemo,
					key: quick_link
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
		})
	</script>
<?php } ?>
<?php if(isset($_GET['yelp']) && $_GET['yelp'] = 'peek'){ ?>
	<script>
		jQuery(document).ready(function(){
			var offset = '10';
			var geodemo = jQuery('#target').val();
			jQuery.ajax({
				url: "ajax_peek.php",
				type: "POST",
				data: {
					city_name: geodemo,
					offset:offset
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
		});
	</script>
<?php } ?>

<!-- Us popular city End -->
<?php if(isset($_GET['tours']) && $_GET['tours'] == 'escape %room'){ ?>
	<script type="text/javascript">
		var geodemo = jQuery('#inputCity').val();
		var limit = "10";
		var quick_link = 'escape-20-room';
		jQuery.ajax({
			url: "ajax_yelp_dev.php",
			type: "POST",
			data: {
				limit : limit,
				formatted: geodemo,
				key: quick_link
			},
			beforeSend: function()
			{
				jQuery("#loader").addClass("loading");
			},
			success: function (response) 
			{
		    	//alert(response);
		    	jQuery('.top_title').html('Escape Room');
		    	jQuery('.discounts_inner').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".discounts_inner").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});


	</script>
<?php }  elseif(isset($_GET['tours']) && $_GET['tours'] == 'Museum'){ ?>
	<script type="text/javascript">
		var geodemo = jQuery('#inputCity').val();
		var limit = "10";
		var quick_link = 'Museum';
		jQuery.ajax({
			url: "ajax_yelp_dev.php",
			type: "POST",
			data: {
				limit : limit,
				formatted: geodemo,
				key: quick_link
			},
			beforeSend: function()
			{
				jQuery("#loader").addClass("loading");
			},
			success: function (response) 
			{
		    	//alert(response);
		    	jQuery('.top_title').html('Museums');
		    	jQuery('.discounts_inner').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".discounts_inner").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});


	</script>
<?php } elseif(isset($_GET['tours']) && $_GET['tours'] == 'Shopping'){ ?>
	<script type="text/javascript">
		var geodemo = jQuery('#inputCity').val();
		var limit = "10";
		var quick_link = 'Shopping';
		jQuery.ajax({
			url: "ajax_yelp_dev.php",
			type: "POST",
			data: {
				limit : limit,
				formatted: geodemo,
				key: quick_link
			},
			beforeSend: function()
			{
				jQuery("#loader").addClass("loading");
			},
			success: function (response) 
			{
		    	//alert(response);
		    	jQuery('.top_title').html(quick_link);
		    	jQuery('.discounts_inner').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".discounts_inner").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});


	</script>
<?php } elseif (isset($_GET['tours']) && $_GET['tours'] == 'sightseeing'){ ?>
	<script type="text/javascript">
		var geodemo = jQuery('#inputCity').val();
		var limit = "10";
		var quick_link = 'sightseeing';
		jQuery.ajax({
			url: "ajax_yelp_dev.php",
			type: "POST",
			data: {
				limit : limit,
				formatted: geodemo,
				key: quick_link
			},
			beforeSend: function()
			{
				jQuery("#loader").addClass("loading");
			},
			success: function (response) 
			{
		    	//alert(response);
		    	jQuery('.top_title').html(quick_link);
		    	jQuery('.discounts_inner').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".discounts_inner").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});


	</script>
<?php } ?>
<script type="text/javascript">
	var app = new Vue({
		el: '#thingsToDo',
		data:{
			members:'',
			tours:'',
			groupon:'',
			debug: true,
			title: 'Tour Discounts',
			key: 'Museum',
			grouponkey: 'tours',
			formatted: '<?php echo $_SESSION['city_name']; ?>',
			checkSessionServer: '',
			limit :'10',
			ajaxRequest: false
		},

		mounted: function(){
			<?php if(!isset($_GET['yelp'])){ ?>
				this.getSpecificData();
			<?php } ?>
			this.getSpecificTours();
			this.getGrouponDeals();
		},

		methods:{
			getSpecificData: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_yelpRestDeals.php', {formatted: vm.formatted,key: vm.key,limit: vm.limit });
				vm.checkSessionServer.then(function(response){
					app.members = response.data;
					vm.ajaxRequest = false;
				});
			},
			getSpecificTours: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_things_tours.php', {formatted: vm.formatted});
				vm.checkSessionServer.then(function(response){
					app.tours = response.data;
					vm.ajaxRequest = false;
				});
			},	
			getGrouponDeals: function(){
				var vm = this;
				vm.ajaxRequest = true;
				vm.checkSessionServer =  axios.post('ajax_groupon_things.php', {formatted: vm.formatted,key: vm.grouponkey,title:vm.title});
				
			}
		}
	});
	jQuery(document).ready(function(){
		jQuery('#localShopping').click(function(){
			jQuery('#popularcitiesModalShopping').show();
		});
		jQuery('.yelpShopping').click(function(){
			jQuery('#popularcitiesModalShopping').hide();
		})
		if( jQuery(window).width() < 640 ) {
			jQuery(".tourmobile").show();
		}	
	});	
	jQuery(document).on("click", ".general_page_link", function () {

		var el = jQuery(this);
		var modal_title = el.data('title');
		var tableName = el.data('table');
		var typeofmodal = el.data('trigger');
		var modal_link =  el.data('link');
		jQuery.ajax({
			url: "ajax_general_page.php",
			type: "POST",
			data: {
				tableName : tableName,
				trigger : typeofmodal,
				title : modal_title,
				modal_link : modal_link
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});
	});
	//////////////////////////////////////////////////////////
  	// Function for yelp horizontal design top search box  //
	/////////////////////////////////////////////////////////
	function yelpHorizontalSearchs(new_val){
		var keyword = new_val;
		var geodemo = jQuery('#fullCityName').val();
		var limit = "10";
		if(keyword != '' && keyword != null){
			console.log(keyword);
			jQuery.ajax({
				url: "ajax_yelp_deals.php",
				type: "POST",
				data: {
					limit           : limit,
					new_val         :new_val,
					formatted 	   	: geodemo,
					design    		: 'Horizontal',
					key      			: keyword
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
					if(keyword =="Museum"){
						keyword ="Museums";
					}
					else if(keyword =="escape-20-room"){
						keyword ="Escape Room";
					}
					jQuery('.top_title').html(keyword);
					jQuery('.oneArticle').html(response);
					jQuery('html, body').animate({
						scrollTop: jQuery(".oneArticle").offset().top
					}, 2000);
					jQuery("#loader").removeClass("loading");
				}
			});
		}
		else{
			alert('Please Enter Keyword.')
		}
	}
	function yelpHorizontalSearch(new_val){
		var keyword = jQuery('#search-yelp-horizontal').val();
		var geodemo = jQuery('#fullCityName').val();
		var limit = "10";
		if(keyword != '' && keyword != null){
			console.log(keyword);
			jQuery.ajax({
				url: "ajax_yelp_deals.php",
				type: "POST",
				data: {
					limit           : limit,
					new_val         :new_val,
					formatted 	   	: geodemo,
					design    		: 'Horizontal',
					key      			: keyword
				},
				beforeSend: function()
				{
					jQuery("#loader").addClass("loading");
				},
				success: function (response) 
				{
					jQuery('.oneArticle').html(response);
					jQuery("#loader").removeClass("loading");
				}
			});
		}
		else{
			alert('Please Enter Keyword.')
		}
	}
	
	jQuery('body').on('keyup', '#search-yelp-horizontal', function () { 
		var key = jQuery(this).val();
		var city = jQuery('#fullCityName').val();

		jQuery.ajax({
			url: "ajax_yelp_auto1.php",
			type: "POST",
			data: {
				formatteds: key, city: city,
			},
			success: function (res) 
			{  
				console.log(res); 
				jQuery("#suggesstion-box").html('');
				jQuery("#suggesstion-box").show();  
				jQuery("#suggesstion-box").html(res);

			},
		});
	});

	jQuery('body').on('click','#suggesstion-box li' ,function()
	{
		var val = jQuery(this).text();
		jQuery("#search-yelp-horizontal").val(val);
		var new_val = jQuery("#search-yelp-horizontal").val();
		yelpHorizontalSearch(new_val);
		jQuery("#suggesstion-box").hide(); 
		jQuery('html, body').animate({
			scrollTop: jQuery("#suggesstion-box").offset().top
		}, 1000);  
	});
	jQuery(document).on('keydown','#search-yelp-horizontal',function(e){
		var keyword= jQuery(this).val();
		var city = jQuery('#fullCityName').val();

		jQuery.ajax({
			url: "ajax_yelp_auto1.php",
			type: "POST",
			async:false,
			data: {
				formatteds: keyword, city: city,
			},
			success: function (res) 
			{  
				console.log(res); 
				jQuery("#suggesstion-box").html('');
				jQuery("#suggesstion-box").show();  
				jQuery("#suggesstion-box").html(res);

			},
		});
	});

	jQuery(document).on('click', '#yelp-hitAjaxCity', function(){
		var new_val = jQuery("#search-yelp-horizontal").val();
		yelpHorizontalSearch(new_val);
	});
	
	jQuery(document).on('keydown','#search-yelp-horizontal',function(e){
		var key = e.which;
		if(key == 13)  // the enter key code
		{
			var new_val = jQuery("#search-yelp-horizontal").val();
			yelpHorizontalSearch(new_val);
		}	
	});
	/////////////////////
  	// End serach box  //
	/////////////////////
	jQuery(document).on("click", ".open-CitiesDialog", function () {

		var el = jQuery(this);
		var modal_link = el.data('info');
		var modal_title = el.data('title');
		var modal_table =el.data('table');
		jQuery.ajax({
			url: "ajax_general_page.php",
			type: "POST",
			data: {
				modal_link : modal_link,
				modal_title : modal_title,
				modal_table : modal_table
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});    
	});
	jQuery(document).on("click", ".open-SportsDialogs", function () {
		var el = jQuery(this);
		var modal_title = el.data('title');
		var modal_trigger =el.data('trigger');
		var modal_city =el.data('city');
		var modal_table2 =el.data('table2');
		jQuery.ajax({
			url: "ajax_specific_landingpage.php",
			type: "POST",
			data: {
				modal_title : modal_title,
				modal_trigger : modal_trigger,
				modal_city : modal_city,
				modal_table2 : modal_table2
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html("");
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});    
	});

	jQuery(document).on("click", ".open-GrouponDialog", function () {
		var el = jQuery(this);
		var modal_info = el.data('info');
		var modal_title = el.data('title');
		var modal_limit =el.data('limit');
		var modal_city =el.data('city');
		var modal_key =el.data('key');
		var modal_url =el.data('url');
		jQuery.ajax({
			url: modal_url,
			type: "POST",
			data: {
				modal_info : modal_info,
				modal_title : modal_title,
				modal_limit : modal_limit,
				modal_city : modal_city,
				modal_key : modal_key
			},
			beforeSend: function()
			{
				jQuery("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				jQuery('.cities_modal').html(response);
				jQuery("#modal_loader").removeClass("loading");
			}
		});    
	});
</script>
<?php if(empty($_SESSION['city_name']) ):?>
	<script type="text/javascript">
		jQuery(window).load(function(){
			var source="yelp-tour";
			var title="Things To Do";
			var info = [
			{"source":"yelp-tour","name":"Best Comedy Cities","pageName":"comedy.php","tableName":"comedy_scence"},
					// {"source":"yelp-tour","name":"Popular Cities","pageName":"yelp-tour.php","tableName":"popular_cities"},
					{"source":"yelp-tour","name":"Family Friendly Cities","pageName":"family.php","tableName":"Cities_for_Families"},
					{"source":"yelp-tour","name":"Cities For Music Lovers","pageName":"concert.php","tableName":"cities_for_musiclovers"},
					// {"source":"yelp-tour","name":"Concert","pageName":"concert.php","tableName":"concert_cities"},
					{"source":"yelp-tour","name":"Exotic Vacations","pageName":"hotels/index.php","tableName":"Exotic_vacations"},
					// {"source":"yelp-tour","name":"America Music Lover","pageName":"concert.php","tableName":"america_music_lover"},
					{"source":"yelp-tour","name":"Asia,Europe,Australia","pageName":"hotels/index.php","tableName":"asia"},
					// {"source":"yelp-tour","name":"Australia","pageName":"hotels/index.php","tableName":"australia"},
					{"source":"yelp-tour","name":"Beaches","pageName":"hotels/index.php","tableName":"beach"},
					// {"source":"yelp-tour","name":"Canada","pageName":"hotels/index.php","tableName":"canada"},
					// {"source":"yelp-tour","name":"Europe","pageName":"hotels/index.php","tableName":"europe"}
					];
					jQuery.ajax({
						url: "ajax_general_page.php",
						type: "POST",
						data: {
							info 	: info,
							source  : source,
							title 	: title

						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
							jQuery('.things-to-do-cities').html(response);
							jQuery('.carousel-control-prev').trigger('click');
							jQuery("#loader").removeClass("loading");
						}
					});
				});
			</script>
		<?php endif; ?>
		<?php if(!empty($_SESSION['city_name']) ):?>
			<script type="text/javascript">
				jQuery(document.body).on('click','#hitAjaxCity',function(e){
					e.preventDefault();
					var geodemo = jQuery('#target').val();
					jQuery.ajax({
						url: "city_search_ajax.php",
						type: "POST",
						data: {
							formatteds: geodemo
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{   
							window.location.reload();
							jQuery("#loader").removeClass("loading");
						}
					});
				});
				jQuery(document).on("click", "#top_links", function (e) {
					e.preventDefault();
					var el = jQuery(this);
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var limit = "10";
					var geodemo = jQuery('#inputCity').val();
					var quick_link = el.attr('name');
					var quick_link = quick_link.replace(/[_\W]+/g, "-")
					jQuery.ajax({
						url: "ajax_yelp_dev.php",
						type: "POST",
						data: {
							limit : limit,
							formatted: geodemo,
							key: quick_link
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);

		    	if(quick_link =="Museum"){
		    		quick_link ="Museums";
		    	}
		    	else if(quick_link =="escape-20-room"){
		    		quick_link ="Escape Room";
		    	}
		    	jQuery('.top_title').html(quick_link);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
				});

				jQuery(document).on("click", "#Sightseeingguide", function (e) {
				//jQuery('#sightseeingguide').click(function(){
					e.preventDefault();
					jQuery("#loader").addClass("loading");
					jQuery('.oneArticle').css('display','none');
					jQuery('.side_side_bar').css('display','none');
					jQuery('.discounts_inner').css('display','block');
					jQuery('.top_title').html('Sightseeing');
					jQuery('html, body').animate({
						scrollTop: jQuery(".discounts_inner").offset().top
					}, 2000);
					jQuery("#loader").removeClass("loading");
				});
				jQuery(document).on('click', '#nightlife_yelp', function(){
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var new_val = jQuery(this).attr('name');
					yelpHorizontalSearchs(new_val);
				});
				jQuery(document).on("click", ".browse_load_more", function (e) {
					e.preventDefault();
					var el = jQuery(this);
					var limits = jQuery(this).attr('data-limit');
					var limit = +limits+10;
					var geodemo = jQuery('#inputCity').val();
					var quick_link = jQuery(this).attr('data-key');
					var numItems = jQuery('.custom_column_one').length;
					jQuery.ajax({
						url: "ajax_yelp_dev.php",
						type: "POST",
						data: {
							limit : limit,
							formatted: geodemo,
							key: quick_link
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	/*jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);*/
		    	jQuery("#loader").removeClass("loading");
		    	if(numItems == limits){
		    		jQuery('.browse_load_more').css('display','none');
		    	}
		    }
		});
				});
				jQuery(document).on("click", ".tour_load_more", function (e) {
					e.preventDefault();
					var limit = jQuery(this).attr('data-limit');
					var offset = +limit+10;
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_tourforfun.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
			   	// jQuery('html, body').animate({
			    //     scrollTop: jQuery(".oneArticle").offset().top
			    // }, 2000);
			    jQuery("#loader").removeClass("loading");
			}
		});
				});
				jQuery(document).on("click", ".peek_load_more", function (e) {
					e.preventDefault();
					var limit = jQuery(this).attr('data-limit');
					var offset = +limit+10;
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_tourforfun.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);

			   	// jQuery('html, body').animate({
			    //     scrollTop: jQuery(".oneArticle").offset().top
			    // }, 2000);
			    jQuery("#loader").removeClass("loading");
			}
		});
				});
				jQuery(document).on("click", "#tourforfun", function (e) {
					e.preventDefault();
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var offset = '10';
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_tourforfun.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.top_title').html('Day Trip');
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
				});
				jQuery(document).on("click", "#toursSight", function (e) {
					e.preventDefault();
					var offset = '10';
					var geodemo = jQuery('#inputCity').val();
					jQuery.ajax({
						url: "ajax_peek.php",
						type: "POST",
						data: {
							city_name: geodemo,
							offset:offset
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{
		    	//alert(response);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".oneArticle").offset().top
		    	}, 2000);
		    	jQuery("#loader").removeClass("loading");
		    }
		});
				});
			</script>
		<?php endif;; ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){

				jQuery("#tourfunData").click(function(){

					var geodemo1 = jQuery('#inputCity').val(); 
					if(geodemo1.length > 0){
						var geodemo = jQuery('#target').val(); 
						var fullCityName = jQuery('#fullCityName').val();
					}else{
						var geodemo = jQuery('#geo-demo').val();
						var fullCityName = jQuery('#fullCityName').val();

					}

					jQuery.ajax({
						url: "ajax_tourfun_seeall_data.php",
						type: "POST",
						data: {
							formatted: geodemo
						},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function (response) 
						{   
							jQuery('#tourdata').html(response); 
							jQuery("#loader").removeClass("loading");
						}
					});                  
				}) 	

			});

			jQuery(document).on('click','.load_more_yelps',function(){
				var limits = jQuery(this).attr('data-id');
				var limit = +limits+10;
				var key = "Museum";
				var formatted = "<?php echo $_SESSION['city_name'] ?>";
				var numItems = jQuery('.custom_column').length;
				jQuery.ajax({
					type: 'POST',
					url: 'ajax_thing_yelps.php',
					data: {limit: limit, key:key, formatted:formatted},
					beforeSend: function()
					{
						jQuery("#loader").addClass("loading");
					},
					success: function(data) {
						jQuery('.oneArticle').html(data);
						jQuery("#loader").removeClass("loading");
						if(numItems == limits){
							jQuery('.load_more').css('display','none');
						}
					}
				});
			});     
			jQuery(document).on('click','.load_more_search',function(){
				var limits = jQuery(this).attr('data-id');
				var limit = +limits+10;
				var key = jQuery('#search-yelp-horizontal').val();
				var formatted = "<?php echo $_SESSION['city_name'] ?>";
				jQuery.ajax({
					type: 'POST',
					url: 'ajax_thing_yelps.php',
					data: {limit: limit, key:key, formatted:formatted},
					beforeSend: function()
					{
						jQuery("#loader").addClass("loading");
					},
					success: function(data) {
						jQuery('.oneArticle').html(data);
						jQuery("#loader").removeClass("loading");
					}
				});
			}); 
			jQuery(function(){
				jQuery(document.body).on('click', '.yelpuser-review', function(){	
					var tour_id = jQuery(this).attr('data-id');

					jQuery.ajax({
						type: 'POST',
						url: 'ajax_tour_review_data.php',
						data: {tourid: tour_id},
						beforeSend: function()
						{
							jQuery("#loader").addClass("loading");
						},
						success: function(data) {
							jQuery('.modal-tour-review').html(data);
							jQuery("#loader").removeClass("loading");
						}
					});
				});
			});	
			jQuery(document).ready(function(){
				jQuery(".dropdown-toggle").dropdown();
			});

		</script>
		<?php if(isset($_GET['tours']) && $_GET['tours'] == 'sightseeing'){?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#loader").addClass("loading");
					jQuery('.oneArticle').css('display','none');
					jQuery('.side_side_bar').css('display','none');
					jQuery('.discounts_inner').css('display','block');
					jQuery('.top_title').html('Sightseeing');
					jQuery('html, body').animate({
						scrollTop: jQuery(".discounts_inner").offset().top
					}, 2000);
					jQuery("#loader").removeClass("loading");
				})
			</script>

		<?php } ?>
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
		<?php if(isset($_SESSION['city_name'])){ ?>
			<div class='modal fade' id='more_audio_tourss'  tabindex="-1" data-focus-on="input:first"  role='dialog' style="top: 18px;">
				<div class='modal-dialog '>
					<div class='modal-content guide_modal'>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Tours</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
							</button>
						</div>
						<div class="audio_tour_modal">
							<?php
							if($_SESSION['city_name'] == 'Washington D.C.'){
								$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' LIMIT 50";
							}else{
								$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' LIMIT 50";
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
								<ul class="us-city-popup">
									<li class="col-sm-3 col-md-3 col-xs-6">

										<a href="<?php echo $buy_url; ?>">
											<img src="<?php echo $values['image_link']; ?>">
											<span class="dealscity_name cityes_cityes_name"><?php echo substr($values['title'], 0, 20).'...'; ?></span>
											<p class="dealscitssy_name" ><?php echo $values['price']; ?></p>
											

										</a>
									</li>
								</ul>
							<?php } ?>
							<?php
							$guide_city = "SELECT * FROM  get_guide_tours WHERE city_name LIKE '%".$_SESSION['city_name']."%' LIMIT 1";
							$guide_city_result = $mysqli->query($guide_city);
							$guide_city_count = $guide_city_result->num_rows;
							if($guide_city_count > 0){
								foreach ($guide_city_result as $key => $value) {
									echo $value['content'];
								}
							}?>
						</div>
						<div class='modal-footer'>
							<button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>
			<section class="adds sec_pad" style="padding-top:0px !important;">
				<div class="container">
					<div class="row">
						<div class="col-lg-3">
						</div>
						<div class="col-lg-3">
							<a href="https://www.tkqlhce.com/click-8265264-10492183" target="_top">
								<img src="images/things-to-do-ad-1.gif" width="300" height="250" alt="" border="0"/></a>
							</div>
							<div class="col-lg-3" >
								<a href="https://www.jdoqocy.com/click-8265264-10482597" target="_top">
									<img src="images/things-to-do-ad-2.gif" width="300" height="250"alt="Alaska Banner" border="0"/></a>
								</div>
								<div class="col-lg-3">
								</div>
							</div>
						</div>
					</section>
				<?php } ?>

				<?php include('blog-resources.php');?>
				<?php include('landingPage-footer.php'); ?>

				<style>
					.image_sq_htfix img {
						position: absolute;
						height: auto !important;  
						top: 50%;
						transform: translate(-50%,-50%) scale(1.8);
						left: 50%;
						width: auto!important;
					}
					.image_htfix_mid img {
						height: auto !important;
					}
					.testimonial-section .cities img {
						height: 300px;
						object-fit: cover;
						border-radius: 10px;
					}
					.testimonial-block.product .cities a p {
						margin-bottom: 0;
						font-size: 20px;
					}
					@media screen and (max-width:767px){
						.slider_nav .owl-nav.disabled {
							display: none !important;
						}
						.owl-dots {
							display: block !important;
						}
					}
				</style>
