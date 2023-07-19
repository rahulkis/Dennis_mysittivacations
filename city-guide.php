<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage= "United States Tour & Travel Online Guide | MySittiVacations"; 

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");

if(isset($_REQUEST['city'])){
	$_SESSION['city_name'] = $_REQUEST['city'];
}

if(isset($_SESSION['city_name'])){

	include('header-newfile.php');	// not login
}else{
	header('location:https://www.mysittivacations.com/');
}

?>
<!--end of header-->

<!--<section class="inner_page_hero music_sec_bg sec_pad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="hero_section_content">
					<h2 class="mb-5"><?php //echo $_SESSION['city_name']; ?> Audio Tours</h2>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="content-bannersss">
					<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

					<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php //echo $_SESSION['full_city_name'];?>" required="">

					<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#">csdfdgdg</a>
				</div>
			</div>
		</div>
	</div>
</section>-->

<div data-aos="zoom-in-right" class="banner-section hotel-hero city-hero" style="background-image:url(images/city_lat_tour.png)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/city_lat_tour.png">
				</div>
				<div class="carousel-caption-top">
				   <h1><?php echo $_SESSION['city_name']; ?> Audio Tours</h1>
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
												<a id="hitAjaxwithCity"  class="search-btn hitbutton" >Search </a>
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
<?php if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
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
<div id="audio_tour_result">
	
	<?php function izi_travel_api_call($url, $trigger){
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
function str_limit($value, $limit = 100, $end = '') {
	if (mb_strlen($value) <= $limit) {
		return $value;
	}
	return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
}
	$offset = 0;
	$formatted = $_SESSION['city_name'];
	if($formatted == 'Clearwater'){
		$formatted = 'Tampa';
	}
	if($formatted == 'St. Pete Beach'){
		$formatted = 'Tampa';
	}
	if($formatted == 'Manhattan Beach'){
		$formatted = 'Los Angeles';
	}
	if($formatted == 'Manhattan Beach'){
		$formatted = 'Los Angeles';
	}
	if($formatted == 'La Jolla'){
		$formatted = 'San Diego';
	}
	if($formatted == 'Jekyll Island'){
		$formatted = 'Jacksonville';
	}
	if($formatted == 'Virginia Beach'){
		$formatted = 'Virginia City';
	}
	$dropCity = rawurlencode(str_replace(' ','+',$formatted));
	if (isset($offset)) {
		$offset = $offset + $offset ;
	}else{
		$offset = 0 ;
	}
	if($offset === 5):
		$limit = 0 ;
	else:
		$limit = 5;
	endif;
	$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl&type=tour&query=".$dropCity."&limit=".$limit."&offset=".$offset."";
	$get_deals = izi_travel_api_call($url);
	$s = $offset ;
	foreach ($get_deals as $homeData):
		$mainuuid 				= $homeData->uuid; 
		$languages 				= $homeData->languages[0];
		$map 					= $homeData->map->bounds;
		$content_provider_uuid  = $homeData->content_provider->uuid;
		$images_uuid 			= $homeData->images[0]->uuid;
		$city_uuid 				= $homeData->location->city_uuid;
		$country_code 			= $homeData->location->country_code;
		$country_uuid 			= $homeData->location->country_uuid;
		$latitude 				= $homeData->location->latitude;
		$longitude 				= $homeData->location->longitude;
		$title 					= $homeData->title;
		?>

<div class="slider-section flight-sec audio"> 
			<div class="container">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2><?php echo $title; ?></h2>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme" id="<?php echo $mainuuid; ?>">
				   <?php 
						 $tour_url =  "https://api.izi.travel/mtgobjects/".$mainuuid."/children?languages=en,nl,ru&limit=15";
						$tours_data = izi_travel_api_call($tour_url);
						$k = 0;
						foreach ($tours_data as $tour_data) :
							$main_uiid 				= $tour_data->uuid;
							$circle_latitude 		= $tour_data->trigger_zones[0]->circle_latitude;
							$circle_longitude 		= $tour_data->trigger_zones[0]->circle_longitude;
							$content_provider_uiid  = $tour_data->content_provider->uuid;
							$images_uiid			= @$tour_data->images[0]->uuid;
							if(is_null($images_uiid) || trim($images_uiid)==""){
								$image_url = "https://dev.mysittivacations.com/no-image.png";
							} else{
								$image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';
							}
							$title = $tour_data->title;
							$address = address($circle_latitude, $circle_longitude);
							?>
						<div data-aos="zoom-in-right" class="testimonial-block product">
						   	<div class="discount-block">
								<img src="<?php echo $image_url ?>">
								<div class="discount-content">
									<h3><?php echo str_limit($title, 21, '...'); ?></h3>
								</div>
								<a target='_blank' data-trigger="audio_modal" data-uuid="<?php echo $main_uiid ?>" class="open-AudioTourDialog" data-toggle="modal" data-target="#more_audio_tour"><img class="play-button" src="images/audio-tour/play.png"></a>
							</div>
						</div>
						<?php endforeach; ?> 
				   </div>
				</div>
			</div>
		</div>		
		


	<?php
	$s++;
endforeach; ?>
<script>
	$('.carousel-control-prev').trigger('click');
					$("#loader").removeClass("loading");
					var owl = $(".owl-carousel");
					owl.owlCarousel({
						loop: true,
						margin: 10,
						autoplay: false,
						responsiveClass: true,
						responsive: {
							0: {
								items: 1,
								nav: true
							},
							600: {
								items: 1,
								nav: false
							}, 
							1000: {
								items: 4,
								nav: true,
								loop: false,
								margin: 20
							}
						}
					});
				</script>
</div>


<?php include('blog-resources-new.php');?>
<?php include('footer-newfile.php'); ?>
<div class='modal fade fg' id='more_audio_tour'  tabindex="-1"  data-focus-on="input:first"  role='dialog'>
		<div class='modal-dialog'>
			<div class='modal-content py-0'>
				<div class='modal-header p-4'>
					<h4></h4>
					    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>

				</div>
				<div class="audio_tour_modal p-3" id="audio_new_modal">

				</div>
				<div id="modal_loader"></div>

			</div>
		</div>
	</div>
<!-- Modal -->
<div class="modal fade video_model" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-body">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
			</button>
			<!-- 16:9 aspect ratio -->
			<div class="embed-responsive embed-responsive-16by9">
				<iframe width="100%" height="450" src="https://www.youtube.com/embed/9xwazD5SyVg"
				title="YouTube video player" frameborder="0"
				allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
				allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
</div>
<!-- JS -->
<script type="text/javascript">
	
	$(document).ready(function(){
		function pageAjaxCall(geodemo){
			var offset = '0';
			if ($geodemo='') {
				var geodemo = $('#geo-demo').val();
			}else{
				var geodemo = geodemo;
			}
			if(geodemo == 'Clearwater'){
				var geodemo = 'Tampa';
			}
			if(geodemo == 'St. Pete Beach'){
				var geodemo = 'Tampa';
			}
			if(geodemo == 'Manhattan Beach'){
				var geodemo = 'Los Angeles';
			}
			if(geodemo == 'Manhattan Beach'){
				var geodemo = 'Los Angeles';
			}
			if(geodemo == 'La Jolla'){
				var geodemo = 'San Diego';
			}
			if(geodemo == 'Jekyll Island'){
				var geodemo = 'Jacksonville';
			}
			if(geodemo == 'Virginia Beach'){
				var geodemo = 'Virginia City';
			}

			$.ajax({
			//	url: "ajax_izitravel_video.php",
				/*type: "POST",
				data: {
					formatted: geodemo,
					offset: offset
				},*/

				beforeSend: function()
				{
					//$("#loader").addClass("loading");
				},
				success: function (response) 
				{
				//	$('#audio_tour_result').append(response);
				//	$('.carousel-control-prev').trigger('click');
				//	$("#loader").removeClass("loading");
					var owl = $(".owl-carousel");
					owl.owlCarousel({
						loop: true,
						margin: 10,
						autoplay: false,
						responsiveClass: true,
						responsive: {
							0: {
								items: 1,
								nav: true
							},
							600: {
								items: 1,
								nav: false
							}, 
							1000: {
								items: 4,
								nav: true,
								loop: false,
								margin: 20
							}
						}
					});

				}
			});

		}

		var geodemo = "<?php echo $_SESSION['city_name'] ?>";
		pageAjaxCall(geodemo);

		
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
		$('#search-yelp-horizontal').hide();
		$('#search_result_dropdown').hide();
		$('#top_search_box_icon').click(function(){
			$('#search-yelp-horizontal, #search_result_dropdown').toggle(500);
			var tour_keyword = $('#searchbox-yelp').val();
			if(!tour_keyword){
				$("#search_result_dropdown").hide();
			}
		});	
	});	
</script>

<script type="text/javascript">

	$(document).on("click", ".open-CitiesDialog", function () {

		var el = $(this);
		var modal_link = el.data('info');
		var modal_title = el.data('title');
		var modal_table =el.data('table');
		var modal_page=el.data('page');
		$.ajax({
			url: "ajax_general_page.php",
			type: "POST",
			data: {
				modal_link : modal_link,
				modal_title : modal_title,
				modal_table : modal_table,
				modal_page : modal_page
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
	var offset = 0;
	var offsets ={};
	$(document).on("click", "#city_tour_detail" ,function(e){
		e.preventDefault();
		var el = $(this);
		var city_name = el.data('city');
		$.ajax({
			url: "city_search_ajax.php",
			type: "POST",
			data: {
				session : city_name
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{   
				window.location.reload();
				$("#loader").removeClass("loading");
			}
		});
	});
	$(document).on("click", ".load_more_tours", function(e){
		e.preventDefault();
		var el = $(this);
		offset = 5 ;
		if ($('#target').val().length === 0) {
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		if(geodemo == 'Clearwater'){
			var geodemo = 'Tampa';
		}
		if(geodemo == 'St. Pete Beach'){
			var geodemo = 'Tampa';
		}
		if(geodemo == 'Manhattan Beach'){
			var geodemo = 'Los Angeles';
		}
		if(geodemo == 'La Jolla'){
			var geodemo = 'San Diego';
		}
		if(geodemo == 'Virginia Beach'){
			var geodemo = 'San Diego';
		}
		if(geodemo == 'Jekyll Island'){
			var geodemo = 'Jacksonville';
		}
		if(geodemo == 'Virginia Beach'){
			var geodemo = 'Virginia City';
		}
		
		

		$.ajax({
			url: "ajax_izitravel_video.php",
			type: "POST",
			data: {
				formatted: geodemo,
				offset : offset
			},

			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('#audio_tour_result').append(response);
				$('.carousel-control-prev').trigger('click');
				$(".load_more_tours").addClass('hide');
				$("#loader").removeClass("loading");

			}
		});

	});
	$(document).on("click", ".add-AudioTour", function(e){
		e.preventDefault();
		var el = $(this);
		var uuid = el.data('uuid');
		// offsets[uuid] = (isNaN(offsets[uuid])) ? 4 : offsets[uuid] + 4 ;
		offsets[uuid] = 4 ;
		console.log(offsets);
		var data = JSON.stringify(offsets);
		// return;
		var typeofmodal = el.data('trigger');
		if ($('#target').val().length === 0) {
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		$.ajax({
			url: "ajax_izitravel_video.php",
			type: "POST",
			data: {
				uuid : uuid,
				trigger : typeofmodal,
				tours_offset : data
			},

			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('#'+uuid+'').html(response);
				$(".add_"+uuid+"").toggle();
				$(".remove_"+uuid+"").removeClass("hide");
				$(".remove_bottom_"+uuid+"").removeClass("hide");
				$("#loader").removeClass("loading");

			}
		});

	});
	$(document).on("click", ".remove-AudioTour", function(e){
		e.preventDefault();
		var el = $(this);
		var uuid = el.data('uuid');
		offsets[uuid] = 4 ;
		console.log(offsets);
		var data = JSON.stringify(offsets);
		var typeofmodal = el.data('trigger');
		if ($('#target').val().length === 0) {
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		$.ajax({
			url: "ajax_izitravel_video.php",
			type: "POST",
			data: {
				uuid : uuid,
				trigger : typeofmodal,
				tours_offset : data
			},

			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('#'+uuid+'').html(response);
				$(".add_"+uuid+"").toggle();
				$(".remove_"+uuid+"").addClass("hide");
				$(".remove_bottom_"+uuid+"").addClass("hide");
				$("#loader").removeClass("loading");

			}
		});

	});
	$(document).on("click", ".open-AudioTourDialog", function () {

		var el = $(this);
		if (typeof el.data('audioid') == 'undefined') {
			var uuid = el.data('uuid');
		}else{

			var uuid = el.data('audioid');
		}
		var typeofmodal = el.data('trigger');
	    // var modal_title = el.data('title');
	    console.log(uuid);
	    $.ajax({
	    	url: "ajax_izitravel_video.php",
	    	type: "POST",
	    	data: {
	    		uuid : uuid,
	    		trigger : typeofmodal
	    	},
	    	beforeSend: function()
	    	{
	    		$("#modal_loader").addClass("loading");
	    	},
	    	success: function (response) 
	    	{
	    		$('.audio_tour_modal').html(response);
	    		$("#modal_loader").removeClass("loading");
	    	}
	    });    
	});
	$(document).on("click", "#search_result_listing", function () {

		var el = $(this);
		var uuid = el.data('uuid');
		var title = el.data('title');
		var typeofmodal = el.data('trigger');
	    // var modal_title = el.data('title');
	    console.log(uuid);
	    $('#search_result_dropdown').hide();
	    $.ajax({
	    	url: "ajax_izitravel_video.php",
	    	type: "POST",
	    	data: {
	    		uuid 	: uuid,
	    		title  	: title,
	    		trigger : typeofmodal
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
	$(document).on("click", ".general_page_link", function () {

		var el = $(this);
		var modal_title = el.data('title');
		var tableName 	= el.data('table');
		var typeofmodal = el.data('trigger');
		$.ajax({
			url: "ajax_izitravel_video.php",
			type: "POST",
			data: {
				tableName : tableName,
				trigger : typeofmodal,
				title : modal_title
			},
			beforeSend: function()
			{
				$("#modal_loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.audio_tour_modal').html(response);
				$("#modal_loader").removeClass("loading");
			}
		});    
	});
</script>
<?php if(empty($_SESSION['city_name']) ):?>
	<script type="text/javascript">
		$(window).load(function(){
			var source="city-guide";
			var title="Audio Tours";
			var info =  [
			{"source":"city-guide","name":"Popular Cities", "tableName":"popular_cities"},
			{"source":"city-guide","name":"Music Cities", "tableName":"cities_for_musiclovers"},
			{"source":"city-guide","name":"Europe", "tableName":"europe"},
			{"source":"city-guide","name":"Asia", "tableName":"asia"},
			{"source":"city-guide","name":"Australia", "tableName":"australia"},
			{"source":"city-guide","name":"Canada", "tableName":"canada"}
			];
			$.ajax({
				url: "ajax_general_page.php",
				type: "POST",
				data: {
					info : info,
					title : title,
					source : source
				},
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.general_audio_page').html(response);
					$('.carousel-control-prev').trigger('click');
					$("#loader").removeClass("loading");
				}
			});
		});
		$(document).ready(function() {
			$('.owl-carousel').owlCarousel({
				loop: true,
				margin: 10,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
						nav: true
					},
					600: {
						items: 2,
						nav: false
					},
					1000: {
						items: 4,
						nav: true,
						loop: false,
						margin: 20
					}
				}
			})
		})
	</script>
<?php endif; ?>
<?php if(!empty($_SESSION['city_name']) ):?>

	<script type="text/javascript">
		

		$(document.body).on('click','#hitAjaxCity',function(e){
			e.preventDefault();
			var geodemo = $('#target').val();
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
					window.location.reload();
					$("#loader").removeClass("loading");
				}
			});
			pageAjaxCall(geodemo);
		});
		$(document).on('keyup','#searchbox-yelp',function(){
			if ($('#target').val().length === 0) {
				var geodemo = $('#geo-demo').val();
			}else{
				var geodemo = $('#target').val();
			}
			var tour_keyword = $(this).val();
			if(!tour_keyword){
				$("#search_result_dropdown").hide();
			}else{ 
				var trigger = 'top_search_trigger';
				console.log(geodemo+', '+tour_keyword+', '+ trigger);
				$.ajax({
					type: "POST",
					url: "ajax_izitravel_video.php",
					data: {
						tour_keyword  	 : tour_keyword,
						search_trigger 	 : trigger,
						city 		 	 : geodemo
					},
					beforeSend: function(){
						$("#search_result_dropdown").css("background","#FFF","text-align","left");
					},
					success: function(data){
						$("#search_result_dropdown").show();
						$("#search_result_dropdown").html(data);
					// $("#search-box-amazon").css("background","#FFF");
				}
			});
			}
		});
	</script>
<?php endif;?>

<script type="text/javascript" charset="utf-8">

		// AJAX call for autocomplete 
		$(document).ready(function(){
			$("#suggesstion-box").hide();
			$("#search-box").keyup(function(){
				$.ajax({
					type: "POST",
					url: "readTicket.php",
					data:'keyword='+$(this).val(),
					beforeSend: function(){
						$("#search-box").css("background","#FFF url(..imagesNew/loaderIcon.gif) no-repeat right");
					},
					success: function(data){
						$("#suggesstion-box").show();
						$("#suggesstion-box").html(data);
						$("#search-box").css("background","#FFF");
					}
				});
			});
		});
		//To select country name
		function selectTeam(val) {
			$("#search-box").val(val);
			$("#suggesstion-box").hide();
		}

		
		$(document).ready(function () {
			$("#showLess").hide();

			x=(x-20<0) ? 5 : x-20;
			$('#myList li').not(':lt('+x+')').hide();

			size_li = $("#myList li").size();
			var x=5;
			$('#myList li:lt('+x+')').show();
			$('#loadMore').click(function () {
				x= (x+20 <= size_li) ? x+20 : size_li;
				$('#myList li:lt('+x+')').show();
				$('#showLess').show();
				if(x == size_li){
					$('#loadMore').hide();
				}
			});
			$('#showLess').click(function () {
				x=(x-20<0) ? 5 : x-20;
				$('#myList li').not(':lt('+x+')').hide();
				$('#loadMore').show();
				$('#showLess').show();
				if(x == 5){
					$('#showLess').hide();
				}
			});
		});

		$('.geo').geoContrast();


	</script>

	<script type="text/javascript">
		$(document).ready(function() {

			$(document.body).on('click', '.audio', function(){
				var id = $(this).attr('id');
				var title = $(this).attr('class');

				$.ajax({
					url: "ajax_audio-tour-summary.php",
					type: "POST",
					data: {
						formatted: title,
						uiid : id
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

			$(document.body).on('click', '.audio-tour-data', function(){
				var id = $(this).attr("id");

				$.ajax({
					url: "ajax_tour_data.php",
					type: "POST",
					data: {
						formatted: id
					},
					beforeSend: function()
					{
						$("#loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.modal-body').html(response);
						$("#loader").removeClass("loading");
					}
				});

			});


			$(document.body).on('click', '.view-map', function(){
				var id = $(this).attr("id");

				$.ajax({
					url: "ajax_view_map.php",
					type: "POST",
					data: {
						formatted: id
					},
					beforeSend: function()
					{
						$("#loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.modal-body').html(response);
						$("#loader").removeClass("loading");
					}
				});

			});
		});

	</script>

	<script>

		$(document).on('click', '.cross-icons, #close_audio', function(){ 

			var audio_id = $('#myAudio')[0]; 
			audio_id.pause();    
			return false;   
		});

		$('#more_audio_tour').on('hidden.bs.modal', function () {
			var audio_id = $('#myAudio')[0]; 
			audio_id.pause();    
			return false;
		})

	</script>


	<script type="text/javascript">
		$(document).ready(function(){
			if( $(window).width() < 640 ) {

				$(".cj-destop").hide();
				$(".cj-mobile").show();

			}	
		});	
	</script> 

	<?php
	if(!isset($_SESSION['user_id'])) { ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".socialfixed").css("display", "none");
			});
		</script>
	<?php }
	?>

</body>

</html>
<style>
    
.testimonial-section .discount-block img:first-child {
    height: 291.91px;
    object-fit: cover;
    border-radius: 12px;
}
.testimonial-section .discount-block img.play-button {
    height: auto;
}
.testimonial-section .discount-content h3 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
    
	@media screen and (max-width:767px){
		.inner_page_hero.sec_pad {display: flex;align-items: center;}
		.hero_section_content h2 {font-size: 24px;}
		.heading h4 {font-size: 24px;}
		.travels .grid img {object-fit: cover !important;width: 100% !important;}
		.audio .testimonial-section .owl-nav {top: 40%;}
		.testimonial-section.products .owl-nav .owl-prev {position: absolute;}
		.testimonial-section.products .owl-nav .owl-next {position: absolute;}
	}
</style>

<script>
$('#48bf9958-ce66-47f1-8116-56338c308b8b').owlCarousel({
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
				items:4,
				loop:false
			}
		}
	})
	$('#148d568e-0517-4787-9be6-0934f2876ed2').owlCarousel({
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
				items:4,
				loop:false
			}
		}
	})
	$('#a5416244-b66c-413e-b040-cc9faa7ba62e').owlCarousel({
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
				items:4,
				loop:false
			}
		}
	})
	$('#b0c44ed8-f0be-4856-a7cf-ec62eb657e99').owlCarousel({
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
				items:4,
				loop:false
			}
		}
	})
	$('#3a3d52b0-0e4f-4283-9af5-27b826c7d40a').owlCarousel({
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
				items:4,
				loop:false
			}
		}
	})
</script>