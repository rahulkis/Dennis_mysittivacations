<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="HomeAway"; 
 
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}


$ch = curl_init();
//echo 'https://channel-stage.homeaway.com/channel/vacationRentalDetails?_restfully=true&unitUrl='.$_GET['id'];
curl_setopt($ch, CURLOPT_URL, 'https://channel.homeaway.com/channel/vacationRentalDetails?_restfully=true&unitUrl='.$_GET['id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Authorization: Bearer N2FjMjAxM2MtZWI0MS00Y2ZhLWEzMmUtOWM1N2ZkYTRlYTk1';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$data = json_decode($result, true);
?>
<style type="text/css">
	ul li {
    list-style-position: inside;
    list-style: disc;
    padding-left: 0px!important;
}
.imagelightbox-caption {
	display: none !important;
}
</style>
<link href='https://fonts.googleapis.com/css?family=Chivo:900' rel='stylesheet' type='text/css'>
    <!-- <link rel="stylesheet" type="text/css" href="slider2/homeawayview/stylesheets/stylesheet.css" media="screen"> -->
    <link rel="stylesheet" type="text/css" href="slider2/homeawayview/stylesheets/pygment_trac.css" media="screen">
    <link rel="stylesheet" type="text/css" href="slider2/homeawayview/stylesheets/print.css" media="print">
    <link rel="stylesheet" type="text/css" href="slider2/homeawayview/stylesheets/imagelightbox.css" media="screen">
<!--section1-->
	<script src="slider2/homeawayview/javascripts/jquery.min.js"></script>
    <script src="slider2/homeawayview/javascripts/imagelightbox.js"></script>
    <script src="slider2/homeawayview/javascripts/main.js"></script>

<!--secton2-->
<div class="container title_home">
	<div class="row">
		<div class="col-md-6 home_away_log">
		<img src="../images/home_logo.png" alt="Home Away" class="img-responsive img-thumbnail">
		</div>
	<div class="col-md-6">
		<h4 class="vacation_area">Questions? 1-800-552-0114 </h4>

	</div>
	</div>
	<div class="row">
		<div class="col-md-12 filter_box_main">
			<div class="sort_box ">
				<div class="col-md-12 filter_option">
					<ul class="nav navbar-nav bar">
						<li class="title_barr">Short By:</li>
						<li class="filter_listing"><a href="#">Featured</a></li>
						<li class="filter_listing"><a href="#">Price</a></li>
						<li class="filter_listing"><a href="#">Most Popular</a></li>
					</ul>
				</div>
			</div>
		</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!--<a href="#"><h4 class="back_link"><i class="glyphicon glyphicon-chevron-left"></i> Back to hotel search</h4></a>-->
				<h4 class="back_link">

<?php foreach($data['headline'] as $head){
				 if($head['locale'] == 'en'){
						echo $head['content'];
					 } } 

					?></H4>
			</div>
		</div>
</div>

<!--section1-->
<div class="container sec_title_home">
 	<div class="row">
		<!--left section-->
		<div class="col-md-8 left-side-area ">
			<div class="tab_home">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="pill" href="#home">Overview</a></li>
					<li><a data-toggle="pill" href="#menu1">Reviews</a></li>
					<li><a data-toggle="pill" href="#menu2">Map</a></li>
					<li><a data-toggle="pill" href="#menu3">Photos</a></li>
					<li><a data-toggle="pill" href="#menu4">Rates</a></li>
					<li><a data-toggle="pill" href="#menu5">Available</a></li>
				</ul>
			</div>
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<!--first-home-->			
					<div id="carousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<div class="item active" data-thumb="0">
								<img src="<?php echo $data['images'][0]['url'];?>" class="img-responsive">
							</div>
							<?php 
							foreach ($data['images'] as $key => $value) {
								?>
								<div class="item" data-thumb="0">
									<img src="<?php echo $value['url']; ?>" class="img-responsive">
								</div>
								<?php 
							} ?>
						</div>
					</div> 
					<div class="clearfix">
						<div id="thumbcarousel" class="carousel slide" data-interval="false">
							<div class="carousel-inner">
								<div class="item active">
									<?php 
									$i = 0;
									foreach ($data['images'] as $key => $value) {
										$i++;
										if($i <= 4){
											$arr[] = $value['url'];
											?>
											<div data-target="#carousel" data-slide-to="<?php echo $i; ?>" class="thumb"><img src="<?php echo $value['url']; ?>" style="height: 96px"  class="img-responsive"></div>
										<?php }
									} ?>
								</div><!-- /item -->

								<?php 
								$i = 3;
								$j = 0;
								foreach ($data['images'] as $key => $value) {
									$pos = array_search($arr[$j], $value);
									unset($value[$pos]);
									$j++;
									$araa[] = $value['url']; 
								}
								$t = 4;
								foreach ($araa as $key => $value) {
									if(!empty($value)){
										$i++;
										$t++;
										if($i == 4){
										?>
										<div class="item">
										<?php	
										}

										?>
										<div data-target="#carousel" data-slide-to="<?php echo $t; ?>" class="thumb"><img src="<?php echo $value; ?>" style="height: 96px"  class="img-responsive">

										</div>
										<?php

										if($i == 7){
										echo "</div>";
										$i=3;
										}
									}
								}?>
								<!-- /item -->
								</div><!-- /carousel-inner -->
							</div>
							<a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							</a>
							<a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</div> <!-- /thumbcarousel -->
					</div><!-- /clearfix -->
				</div>
				<div id="menu1" class="tab-pane fade">

				</div>
				<div id="menu2" class="tab-pane fade">
					<style>
						/* Set the size of the div element that contains the map */
						#map {
						height: 400px;  /* The height is 400 pixels */
						width: 100%;  /* The width is the width of the web page */
						}
					</style>


					<!--The div element for the map -->
					<div id="map"></div>
					<script>
						// Initialize and add the map
						function initMap() {
							var lat = <?php echo $data['latLng']['latitude'] ?>;
							var lang = <?php echo $data['latLng']['longitude'] ?>;
							// The location of Uluru
							var uluru = {lat: lat, lng: lang};
							console.log(uluru);
							// The map, centered at Uluru
							var map = new google.maps.Map(
							document.getElementById('map'), {zoom: 4, center: uluru});
							// The marker, positioned at Uluru
							var marker = new google.maps.Marker({position: uluru, map: map});
						}
					</script>
					<script async defer
					src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdAHPQKt-pTBl0iUiRMd3leFhe8F9TsL4&callback=initMap">
					</script>
				</div>
				<div id="menu3" class="tab-pane fade">
					<div class="item">
						<?php $k = 0;
						foreach ($data['images'] as $key => $value) {
							$k++;
							?>
							<div data-target="#carousel" data-slide="<?php echo $k; ?>" class="thumb"><a href="<?php echo $value['url']; ?>" style="width:40%;" data-imagelightbox="g" data-ilb2-caption="Sunset in Tanzania"><img src="<?php echo $value['url']; ?>" style="height: 96px"  class="img-responsive"></a></div>
							<?php 
						} ?>
					</div>
				</div>

				<div id="menu4" class="tab-pane fade">

				</div>
				<div id="menu5" class="tab-pane fade">

				</div>

				<div class="row descript">
					<div class="col-md-12">
						<!--<a href="#"><h4 class="back_link"><i class="glyphicon glyphicon-chevron-left"></i> Back to hotel search</h4></a>-->
						<h5 class="back_link">Oriando Villa Rental Photo and Description</h5>
						<p><?php foreach($data['description'] as $desc){?>
							<?php if($desc['locale'] == 'en'){?>
							<?php
							echo $stringCut = substr($desc['content'], 0, 500);

							?>
							<?php } ?>
							<?php } ?> 
						</p>
					</div>
				</div>
			</div>
		</div>
		<!--right section-->
		<div class="col-md-4">
		<div class="book_now">
		<div class="price_line">
		<h1>$234</h1>
		</div>
		<h3>7 night total <strong>Detailed PriceM</strong></h3>
		<h4>Your dates are <strong>Available!</strong></h4>


		<form class="form-inline">
		<div class="form-group  col-sm-6 col-md-6"> <!-- Date input -->
		<input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
		</div>
		<div class="form-group  col-sm-6 col-md-6"> <!-- Date input -->
		<input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
		</div>
		</form>
		<form class="form-group" >
		<div class="form-group col-sm-12 col-md-12">
		<input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
		</div>
		<button type="submit" class="btn btn-default book_now_btn">Book it now</button>
		<h5 class="bottom_link">Send a Message</h5>
		</form>
		</div>



		<!--right section3-->

		<div class="listingg">
		<ul class="list-group">
		<li class="list-group-item">
		<span class="badge1"><?php echo $data['sleeps']; ?></span>
		Sleeps
		</li>
		<li class="list-group-item">
		<span class="badge1"><?php echo $data['bedrooms']; ?></span>
		Bedrooms
		</li>
		<li class="list-group-item">
		<span class="badge1">2-5 night</span>
		Minimum Stay
		</li>
		</ul>
		</div>

		<!--right section4-->
		<div class="single_image">

		<img src="<?php echo $data['images'][0]['url']; ?>" class="img-responsive img-thumbnail">
		<h4>Property manager</h4>
		</div>

		</div>
	</div>
</div>
<script type="text/javascript">
 $('.slider-single').slick({
 	slidesToShow: 1,
 	slidesToScroll: 1,
 	arrows: true,
 	fade: false,
 	adaptiveHeight: true,
 	infinite: false,
	useTransform: true,
 	speed: 400,
 	cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
 });

 $('.slider-nav')
 	.on('init', function(event, slick) {
 		$('.slider-nav .slick-slide.slick-current').addClass('is-active');
 	})
 	.slick({
 		slidesToShow: 7,
 		slidesToScroll: 7,
 		dots: false,
 		focusOnSelect: false,
 		infinite: false,
 		responsive: [{
 			breakpoint: 1024,
 			settings: {
 				slidesToShow: 5,
 				slidesToScroll: 5,
 			}
 		}, {
 			breakpoint: 640,
 			settings: {
 				slidesToShow: 4,
 				slidesToScroll: 4,
			}
 		}, {
 			breakpoint: 420,
 			settings: {
 				slidesToShow: 3,
 				slidesToScroll: 3,
		}
 		}]
 	});

 $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
 	$('.slider-nav').slick('slickGoTo', currentSlide);
 	var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
 	$('.slider-nav .slick-slide.is-active').removeClass('is-active');
 	$(currrentNavSlideElem).addClass('is-active');
 });

 $('.slider-nav').on('click', '.slick-slide', function(event) {
 	event.preventDefault();
 	var goToSingleSlide = $(this).data('slick-index');

 	$('.slider-single').slick('slickGoTo', goToSingleSlide);
 });</script>


<?php
	include('LandingPageFooter.php');
 ?>