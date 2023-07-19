<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
 require_once 'Mobile_Detect.php';
  $detect = new Mobile_Detect;
$titleofpage="Deals"; 
session_start();
if(isset($_GET['dream_city'])){
	$_SESSION['city_name']  = $_GET['dream_city'];
	$_SESSION['formatteds'] = $_GET['dream_city'];
}
if(isset($_GET['city'])){
	$_SESSION['city_name']  = $_GET['city'];
	$_SESSION['formatteds'] = $_GET['city'];
}
include('Header.php');	// not login

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/deals.css">

<script type="text/javascript">
$(document).ready(function() {
	$("body").on('click', '.top', function() {
		$("nav.menu").toggleClass("menu_show");
	});
	 if (window.matchMedia("(max-width: 767px)").matches)  
        { $('.incase_mobile').css('display','block');
            $('.incase_desktop').css('display','none');
        } else { 
        	$('.incase_mobile').css('display','none');
           
        } 
	    $('.menu_icon').click(function() {

	    $('html, body').animate({
	      scrollTop: $("#myCarousel").offset().top
	    }, 1000);
	})
});
</script>
<?php
function groupon_api_call($limit,$city,$key){
	if(!empty($city)):
		$prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
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
	endif;
	$result_get = file_get_contents($urlgo);
	$get_all_data = json_decode($result_get, true);
	$get_deals = $get_all_data['deals'];
	return $get_deals;
}
?>
<style>
.audio_tour_in img {
     max-width: 100%;
    margin: 0 auto;
	width:auto !important;
}
.custome_articl_vacat img {
    height: 220px !important;
}
article.white-panel.custome_articl_vacat {
    height: 240px !important;
    border: none !important;
}
.inspiratinSection {
    width: 100%;
 }
.cananda_tours_listing .worldtop_city li {
    min-height: 250px ;
}
.cananda_tours_listing .worldtop_city li{
	width: 33% !important;
}
span.cityes_cityes_name {
    text-align: center;
    padding: 0px;
}
h4.cananda_tours {
    text-align: center;
    width: 100%;
    font-size: 20px;
}
h4.origin_heading {
    width: 100%;
    padding: 11px 0px 0px 0px;
    font-size: 20px;
}
h2.tours_specific_city_h2 {
    width: 100%;
    font-size: 25px;
}
@media only screen and (max-width: 600px) {
.cananda_tours_listing .worldtop_city li {
    width: 100% !important;
}
.cananda_tours_listing .worldtop_city li {
    display: block !important;
}
h2.flght_specific_h2 {
	width: 100%;
	text-align: center;
	font-size: 20px;
	color: #000;
}
}
h2.flght_specific_h2 {
    width: 100%;
    color: #000;
    font-size: 20px;
}

</style>
<div class="v2_content_wrapper car_rental_main container">
<div class="random">
<?php if(empty($_SESSION['city_name'])){?>
<div class="container recommed-city" style="text-align: center;">
<a href="https://www.jdoqocy.com/click-8265264-14324545" target="_top">
<img src="https://www.ftjcfx.com/image-8265264-14324545" width="600" height="90" class="general_rest_add" alt="" border="0"/></a>
</div>
<?php }else{?>
<div class="container recommed-city" style="text-align: center; margin: 0px 0px 20px;">
<a href="https://www.jdoqocy.com/click-8265264-11454023" target="_top">
<img src="https://www.ftjcfx.com/image-8265264-11454023" width="700"  height="90" class="general_rest_add" alt="728x90 Get Quote" border="0"/></a>
</div>
<?php } ?>
<div class="v2_content_wrapper ">

	<div class="row random_change">

			<ul class="audio_tour_in">
				
				<li class="random_list <?php if(empty($_SESSION['city_name']) && empty($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_NAME'] == '/random_deals.php'){ echo 'active'; }
				elseif(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){ echo 'active'; }				?>"> <a  class="random_vacation general_page_link" data="All-Inclusive" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/all_inclusive.png" style="width:50%" class="img-responsive"></span>All</br> Inclusive</a></li>

				<li class="random_list <?php 
				if(empty($_SESSION['city_name']) && isset($_GET['keyword']) && $_GET['keyword'] == 'Hotels'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Hotels'){ echo 'active'; }       ?>"><a class="random_flight general_page_link" data="Hotels" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}" ><span><img src="/images/random/hotels.png" style="width:40px" class="img-responsive"></span>Hotels</a></li>

				<li class="random_list <?php 
				if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Flights'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Flights'){ echo 'active'; }       ?>"><a class="random_flight general_page_link" data="Flights" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}" ><span><img src="/images/random/flights.png" style="width:40px" class="img-responsive"></span>Flights</a></li>

				<li class="random_list <?php 
				if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Vacations'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Vacations'){ echo 'active'; }       ?>"><a class="random_vacation general_page_link"  data="Vacations" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"  ><span><img src="/images/random/vacations.png" style="width:40px" class="img-responsive"></span>Vacations</a></li>

				<li class="random_list  <?php if(!empty($_SESSION['city_name']) && empty($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_NAME'] == '/random_deals.php'){ echo 'active';}
				elseif(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Tours'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Tours'){ echo 'active'; }elseif(empty($_SESSION['city_name']) && isset($_GET['keyword']) && $_GET['keyword'] == 'Tours'){ echo 'active';}?>"><a class="random_tours general_page_link" data="Tours" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/tours.png" style="width:40px" class="img-responsive"></span>Tours</a></li>

				<li class="random_list <?php 
				if(empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Cruises'){ echo 'active'; }elseif(!empty($_SESSION['city_name']) && isset($_GET['flag']) && $_GET['flag'] == 'Cruises'){ echo 'active'; }       ?>"><a class="random_vacation general_page_link" data="Cruises" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/crusies.png" style="width:40px" class="img-responsive"></span>Cruises</a></li>

			</ul>
		<?php
		//all-inclusive screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'All-Inclusive'){
			if(!empty($_SESSION['city_name'])){
				$city = $_SESSION['city_name'];
			}else{
				$city = 'Chicago';
			}
			$data = groupon_api_call('80',$city,'all%20inclusive%20resort');
			if(count($data) > 0)
			{	 ?>
				<section id="pinBoot">
					<?php
					$i= 0;
					foreach($data as $homeData)
					{
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt = 	$homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['title']; 
						$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
							if($discountPercent != 0){
							$i++;
							?>
							<article class="white-panel">
								<a href="<?php echo  $homeData['dealUrl']; ?>"  target="_blank"><img src="<?php echo $homeData['grid4ImageUrl']; ?>" alt=""></a>
								<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
									
									<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center; font-size: 14px"><?php echo $out ; ?></h1>
								</a>
								<h1 class="pricelanding"><?php echo $value ;?></h1>
								<h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
								<h2 class="valuelanding"><?php echo $price ; ?></h2>
								<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
							</article>
							<?php
						}
					}
					?>
				</section>
				<?php
			} 
		}		//all-inclusive screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && empty($_GET['city']) &&  $_GET['flag'] == 'Flights'){
?>
<script src="//c111.travelpayouts.com/content?promo_id=3411&shmarker=130544&from_name=dallas%2Chouston%2Cchicago%2Clos%20angeles&locale=en&currency=USD&powered_by=true" charset="utf-8"></script>
<?php
		}
		//vacation deals screen
		if(isset($_GET['flag']) && empty($_SESSION['city_name']) && !empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && empty($_GET['dream']) && empty($_GET['dream_origin'])){?>
<div class="generalPageHeadingActivity inspiratinSection">
<?php
$urlchi ="https://mysittivacations.com/flight/redirection.php?origin_name=Chicago&origin_iata=CHI&destination_name=new+york&destination_iata=NYC&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";
  $urlla ="https://mysittivacations.com/flight/redirection.php?origin_name=Los+Angeles&origin_iata=LAX&destination_name=new+york&destination_iata=NYC&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";
  $urlat ="https://mysittivacations.com/flight/redirection.php?origin_name=Atlanta&origin_iata=ATL&destination_name=new+york&destination_iata=NYC&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";
  $urldl ="https://mysittivacations.com/flight/redirection.php?origin_name=dallas&origin_iata=DAL&destination_name=new+york&destination_iata=NYC&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";
 if(!$detect->isMobile()) {?> 

      <div class="headingActivity-new new_activity container general_flightd_h2">
          <h2 class="flght_specific_h2">Flight to US</h2>
      </div>
          <div class="container recommed-city pcdesktop generals_flight_us">
          <ul class="us-city worldtop_city general_cities">
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Chicago',this)" target="_blank" href="<?php echo $urlchi; ?>">
            <span class="dealscity_name cityes_cityes_name">Chicago</span>
              <img src="images/city_images/chicago-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Los Angeles',this)" target="_blank" href="<?php echo $urlla; ?>">
            <span class="dealscity_name cityes_cityes_name">LA</span>
              <img src="images/city_images/los-angeles-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Atlanta',this)" target="_blank" href="<?php echo $urlat; ?>">
            <span class="dealscity_name cityes_cityes_name">Atlanta</span>
              <img src="images/city_images/atlanta-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Dallas',this)" target="_blank" href="<?php echo $urldl; ?>">
            <span class="dealscity_name cityes_cityes_name">Dallas</span>
              <img src="images/city_images/Dallas-concert.jpg" loading="lazy">
            </a>
          </li> 
        </ul>
      </div>
    <?php }else{ ?>
       <div class="headingActivity-new new_activity container">       
        <h2 class="flght_specific_h2">Flight to US</h2>
      </div> 
      <div class="owl-carousel owl-theme">   

           <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
           <a onclick="reloadLandingPages('Chicago',this)" target="_blank" href="<?php echo $urlchi; ?>">
            <span class="dealscity_name cityes_cityes_name">Chicago</span>
              <img class="lazyload" src="images/city_images/chicago-1.jpg" style="height: 200px;object-fit: unset"/>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
           <a onclick="reloadLandingPages('Los Angeles',this)" target="_blank" href="<?php echo $urlla; ?>">
            <span class="dealscity_name cityes_cityes_name">LA</span>
              <img class="lazyload" src="images/city_images/los-angeles-1.jpg" style="height: 200px;object-fit: unset" />
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
                  <a onclick="reloadLandingPages('Atlanta',this)" target="_blank" href="<?php echo $urlat; ?>">
            <span class="dealscity_name cityes_cityes_name">Atlanta</span>
              <img class="lazyload" src="images/city_images/atlanta-1.jpg" style="height: 200px;object-fit: unset"/>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
             <a onclick="reloadLandingPages('Dallas',this)" target="_blank" href="<?php echo $urldl; ?>">
            <span class="dealscity_name cityes_cityes_name">Dallas</span>
              <img class="lazyload" src="images/city_images/Dallas-concert.jpg" style="height: 200px; object-fit: unset"/>
            </a>
          </div>
    <?php } ?>
    </div>
			<?php
			$randon_deals = "SELECT * FROM  us_vacation_package";
			$result = $mysqli->query($randon_deals);
			?>
			<section id="pinBoot" class="toursforfun_general">
				<?php
				foreach ($result as $keys => $values) {
				?>
				<article class="white-panel custome_articl_vacat">
				<a href="random_dealsDev.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
					<img src="images/city_images/<?php echo $values['image']; ?>" alt=""></a>
				<a href="">
				<h1 class="vacation_title" style= "text-align: center; font-size: 14px"><?php echo $values['city_name'] ; ?></h1>
				</a>
				</article>
				<?php			
				}

				?>
			</section>

			<?php 
		}
		if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && isset($_SESSION['city_name']) && empty($_GET['dream_city'])){?>
			<div class="generalPageHeadingActivity inspiratinSection">
<?php
   $popular = "SELECT * FROM popular_cities WHERE   name = '".$_SESSION['city_name']."'";
   $result = $mysqli->query($popular);
   $count = $result->num_rows;
  if($count > 0){
    foreach ($result as $key => $value) {
      $iata = $value['iata_code'];
    }
  }else{
  	$iata ='CHI';
  }

$urlchi ="https://mysittivacations.com/flight/redirection.php?origin_name=Chicago&origin_iata=CHI&destination_name=".$_SESSION['city_name']."k&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";

  $urlla ="https://mysittivacations.com/flight/redirection.php?origin_name=Los+Angeles&origin_iata=LAX&destination_name=".$_SESSION['city_name']."&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";

  $urlat ="https://mysittivacations.com/flight/redirection.php?origin_name=Atlanta&origin_iata=ATL&destination_name=".$_SESSION['city_name']."&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";

  $urldl ="https://mysittivacations.com/flight/redirection.php?origin_name=dallas&origin_iata=DAL&destination_name=".$_SESSION['city_name']."&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";

 if(!$detect->isMobile()) {?> 

      <div class="headingActivity-new new_activity container ">
          <h2 class="flght_specific_h2">Flight to <?php echo $_SESSION['city_name'];?></h2>
      </div>
          <div class="container recommed-city pcdesktop specific_flight_us">
          <ul class="us-city worldtop_city general_cities">
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Chicago',this)" target="_blank" href="<?php echo $urlchi; ?>">
            <span class="dealscity_name cityes_cityes_name">Chicago</span>
              <img src="images/city_images/chicago-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Los Angeles',this)" target="_blank" href="<?php echo $urlla; ?>">
            <span class="dealscity_name cityes_cityes_name">LA</span>
              <img src="images/city_images/los-angeles-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Atlanta',this)" target="_blank" href="<?php echo $urlat; ?>">
            <span class="dealscity_name cityes_cityes_name">Atlanta</span>
              <img src="images/city_images/atlanta-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a onclick="reloadLandingPages('Dallas',this)" target="_blank" href="<?php echo $urldl; ?>">
            <span class="dealscity_name cityes_cityes_name">Dallas</span>
              <img src="images/city_images/Dallas-concert.jpg" loading="lazy">
            </a>
          </li> 
        </ul>
      </div>
    <?php }else{ ?>
       <div class="headingActivity-new new_activity container specific_flightd_h2">       
        <h2 class="flght_specific_h2">Flight to <?php echo $_SESSION['city_name'];?></h2>
      </div> 
      <div class="owl-carousel owl-theme">   

           <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
           <a onclick="reloadLandingPages('Chicago',this)" target="_blank" href="<?php echo $urlchi; ?>">
            <span class="dealscity_name cityes_cityes_name">Chicago</span>
              <img class="lazyload" src="images/city_images/chicago-1.jpg" style="height: 200px; object-fit: unset"/>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
           <a onclick="reloadLandingPages('Los Angeles',this)" target="_blank" href="<?php echo $urlla; ?>">
            <span class="dealscity_name cityes_cityes_name">LA</span>
              <img class="lazyload" src="images/city_images/los-angeles-1.jpg" style="height: 200px; object-fit: unset"/>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
                  <a onclick="reloadLandingPages('Atlanta',this)" target="_blank" href="<?php echo $urlat; ?>">
            <span class="dealscity_name cityes_cityes_name">Atlanta</span>
              <img class="lazyload" src="images/city_images/atlanta-1.jpg" style="height: 200px; object-fit: unset"/>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
             <a onclick="reloadLandingPages('Dallas',this)" target="_blank" href="<?php echo $urldl; ?>">
            <span class="dealscity_name cityes_cityes_name">Dallas</span>
              <img class="lazyload" src="images/city_images/Dallas-concert.jpg" style="height: 200px; object-fit: unset"/>
            </a>
          </div>
    <?php } ?>
    </div>
			<?php
		$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' limit 40";
		$result = $mysqli->query($randon_deals);?>
		<h2 class="tours_specific_city_h2"><?php echo $_SESSION['city_name']; ?></h2>
		<div class="container recommed-city pcdesktop cananda_tours_listing">
          		<ul class="us-city worldtop_city general_cities">
		 	<?php
      foreach ($result as $keys => $values) {
            ?>
		<li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
					<a href="<?php echo $values['link']; ?>"  target="_blank">
					
					<img src="<?php echo $values['image_link']; ?>" alt="">
					<span class="cityes_cityes_name">$ <?php echo $values['price']; ?></span>
					<span class="cityes_cityes_name">

						<?php echo $str = substr($values['title'], 0, 25) . '...'; ?></span>

					</a>
					</li>  
      <?php     
          }
          ?>
		</ul> 
		</div>
</div>
          <?php
          }
          if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && $_GET['dream'] == 'all' && empty($_SESSION['city_name'])){?>
          	<section id="pinBoot" class="toursforfun_general">
				<?php
				$randon_deals = "SELECT * FROM  continantal limit 40";
				$result = $mysqli->query($randon_deals);
				foreach ($result as $keys => $values) {
				?>
				<article class="white-panel custome_articl_vacat">
				<a href="random_dealsDev.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
					<img src="images/<?php echo $values['image']; ?>" alt=""></a>
				<a href="">
				<h1 class="vacation_title" style= "text-align: center; font-size: 14px"><?php echo $values['city_name'] ; ?></h1>
				</a>
				</article>
				<?php			
				}

				?>
			</section>

          <?php } 
               if(!empty($_GET['flag']) && $_GET['flag'] == 'Vacations' && isset($_GET['dream_origin'])){?>
               <h4 class="origin_heading"><?php echo $_GET['dream_origin'];?></h4>
          	<section id="pinBoot" class="toursforfun_general">

				<?php
			echo $randon_deals = "SELECT * FROM  continantal where name LIKE '%".$_GET['dream_origin']."%'";
				$result = $mysqli->query($randon_deals);
				foreach ($result as $keys => $values) {
				?>
				<article class="white-panel custome_articl_vacat">
				<a href="random_dealsDev.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
					<img src="images/<?php echo $values['image']; ?>" alt=""></a>
				<a href="">
				<h1 class="vacation_title" style= "text-align: center; font-size: 14px"><?php echo $values['city_name'] ; ?></h1>
				</a>
				</article>
				<?php			
				}

				?>
			</section>

          <?php 
          if($_GET['dream_origin'] == 'USA'){?>
          	<h4 class="cananda_tours">CANADA</h4>
          	 	<div class="container recommed-city pcdesktop cananda_tours_listing">
          		<ul class="us-city worldtop_city general_cities">
				<?php
				$randon_deals = "SELECT * FROM  continantal where name LIKE '%canada%'";
				$result = $mysqli->query($randon_deals);
				foreach ($result as $keys => $values) {
				?>
					<li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
					<a href="random_dealsDev.php?flag=Vacations&city=<?php echo $values['city_name'] ; ?>">
					
					<img src="images/<?php echo $values['image']; ?>" alt="">
					<span class="cityes_cityes_name"><?php echo $values['city_name'] ; ?></span>
					</a>
					</li> 
				<?php			
				}

				?>
      </ul>
  </div>
         <?php }
      } 
		//cruises deals screen
		if(isset($_GET['flag']) && !empty($_GET['flag']) && $_GET['flag'] == 'Cruises'){
			?>
			<section id="pinBoot">
				<?php
				$rec_limit = 40;
				if( isset($_GET{'page'} ) ) {
					$page = $_GET{'page'} + 1;
					$offset = $rec_limit * $page ;
				}else {
					$page = 0;
					$offset = 0;
				}
				$randon_deals = "SELECT * FROM  new_cruises_deal_page ORDER BY  order_by LIMIT $offset, $rec_limit";
				$randon_deals_count = "SELECT id FROM  new_cruises_deal_page";
				$resultCount = $mysqli->query($randon_deals_count);
				$countCount = $resultCount->num_rows;
				 $left_rec = $countCount - ($page * $rec_limit);
				$result = $mysqli->query($randon_deals);
				$count = $result->num_rows;

					foreach ($result as $key => $value) {
					?>	
					<article class="white-panel cruisess_text">
						<a href="<?php echo $value['link']; ?>" class="text-dec"  target="_blank"><img src="<?php echo 'cruises_images/'.$value['image']; ?>" alt="">
							<p class="text-color"><?php echo $value['tittle']; ?></p>	
						</a>
					</article>

					<?php		
				}  
				?>
			</section>
			<div class="paggination_bottom">
				<?php
	
				if( $left_rec > $rec_limit && $page != '0') {
					$last = $page - 2;
					echo "<a href =random_deals.php?flag=Cruises&page=$last>Last 40 Records</a> |";
					echo "<a href = random_deals.php?flag=Cruises&page=$page>Next 40 Records</a>";
				}else if( $page == 0 ) {
					echo "<a href =random_deals.php?flag=Cruises&page=$page class='dealNext' >Next 40 Records</a>";
				}else if( $left_rec < $rec_limit ) {
					$last = $page - 2;
					echo "<a href =random_deals.php?flag=Cruises&page=$last class='dealLast' >Last 40 Records</a>";
				}
				
				?>
			</div>
			<?php 
		}
		//data with specific cities
		if(isset($_SESSION['city_name']) && !empty($_SESSION['city_name'])){
			if($_GET['flag'] == 'Flights'){
				$randon_deals = "SELECT * FROM  random_deal_widgets WHERE city LIKE '%".$_GET['city']."%'";	
			}elseif($_GET['flag'] == 'Hotels'){
				$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%".$_GET['city']."%'";
			}elseif(isset($_SESSION['city_name']) && $_SERVER['SCRIPT_NAME'] == '/random_deals.php') {
				$rec_limit = 20;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
           if($_SESSION['city_name'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
       $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
           }else{
				$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
			 $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";        
           }
			}
			$result = $mysqli->query($randon_deals);
			$resultpeek = $mysqli->query($randon_dealspeek);
		 $count = $result->num_rows;
		 $count2 = $resultpeek->num_rows;
		 $counts = ($count + $count2);
			if($counts > 0){
			if ($_SERVER['SCRIPT_NAME'] == '/random_deals.php' && empty($_SERVER['QUERY_STRING'])) {
					?>
			<section id="pinBoot">
				<?php 
				if($count > 0){


				 foreach ($result as $key => $value) {
					foreach ($resultpeek as $keys => $values) {
					if(!empty($values['tag'])){
						if($keys == $key){
						?>
				<article class="white-panel vacationss"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $values['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $values['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php			
					}
					}
					}
				?>
				<article class="white-panel vacationss"><a href="<?php echo $value['link']; ?>"  target="_blank"><img src="<?php echo $value['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $value['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $value['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $value['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php	
		 } }else{
	foreach ($resultpeek as $keys => $values) {

		?>
<article class="white-panel vacationss"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $values['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $values['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
		<?php
	}

		 }?>
			</section>
			<?php if($counts > 39){ ?>
				<div class="paggination_bottom">
					<?php
					$citysp =	$_SESSION['city_name'];
				    $city = str_replace(' ', '%20', $citysp);
					if( $page > 0 ) {
						$last = $page - 2;
						echo "<a href =random_deals.php?city=$city&flag=Tours&page=$last>Last 40 Records</a> |";
						echo "<a href = random_deals.php?city=$city&flag=Tours&page=$page>Next 40 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals.php?city=$city&flag=Tours&page=$page class='dealNext' >Next 40 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals.php?city=$city&flag=Tours&page=$last class='dealLast' >Last 40 Records</a>";
					}
					?>
				</div>
					<?php 
				}	 }elseif(!empty($_SESSION['city_name']) && !empty($_SERVER['QUERY_STRING']) && $_GET['flag'] == 'Tours'){
					
						$rec_limit = 20;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
                      if($_SESSION['city_name'] == 'Washington D.C.'){
  $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
  $randon_dealsCount = "SELECT id FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun'";
      
       $randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
$randon_dealspeekcount = "SELECT id FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com'";
           }else{
			$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'  LIMIT $offset, $rec_limit";
	$randon_dealsCount = "SELECT id FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun'";
			$randon_dealspeek = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Peek.com' LIMIT $offset, $rec_limit";
$randon_dealspeekcount = "SELECT id FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Peek.com'";
		}

    	$result = $mysqli->query($randon_deals);
		$resultpeek = $mysqli->query($randon_dealspeek);

		$resultCount = $mysqli->query($randon_dealsCount);
		$resultpeekCount = $mysqli->query($randon_dealspeekcount);

		 $count = $result->num_rows;
		 $count2 = $resultpeek->num_rows;
		 $countRow = $resultCount->num_rows;
		 $count2Row = $resultpeekCount->num_rows;
		$left_rec = ($countRow + $count2Row);
		$countss = ($count + $count2);
		$countsCount = ($countss - 19);
			if($countss > 0){
					?>
			<section id="pinBoot">
				<?php if($count > 0){
				 foreach ($result as $key => $value) {
					foreach ($resultpeek as $keys => $values) {
					if(!empty($values['tag'])){
						if($keys == $key){
						?>
				<article class="white-panel vacationss"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $values['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $values['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php			
					}
					}
					}
				?>
				<article class="white-panel vacationss"><a href="<?php echo $value['link']; ?>"  target="_blank"><img src="<?php echo $value['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $value['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $value['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $value['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
			<?php	
		 } }else{

	foreach ($resultpeek as $keys => $values) {

		?>
<article class="white-panel vacationss"><a href="<?php echo $values['link']; ?>"  target="_blank"><img src="<?php echo $values['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
						<div class="PictureCard-title"><?php echo $values['tag']; ?></div>
						<div class="PictureCard-wrapper">
							<div class="PictureCard-data">
								<span class="PictureCard-price length-5">$ <?php echo $values['price']; ?></span>
							</div>
							<div class="PictureCard-menu">
								<div>
									<div class="PictureCard-timebox _outbound">
										<div class="PictureCard-timebox-col">
											<span class=""><?php echo $values['title']; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div></a>
				</article>
		<?php
	}

		 } ?>
			</section>

				<div class="paggination_bottom">
					<?php
					$citysp =	$_SESSION['city_name'];
				    $city = str_replace(' ', '%20', $citysp);
					if( $countsCount > $rec_limit && $page != '0') {
						$last = $page - 2;
						echo "<a href =random_deals.php?city=$city&flag=Tours&page=$last>Last 40 Records</a> |";
						echo "<a href = random_deals.php?city=$city&flag=Tours&page=$page>Next 40 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals.php?city=$city&flag=Tours&page=$page class='dealNext' >Next 40 Records</a>";
					}else if( $countsCount < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals.php?city=$city&flag=Tours&page=$last class='dealLast' >Last 40 Records</a>";
					}
					?>
				</div>  
					<?php 
				}
				}
				if($_GET['flag'] == 'Hotels'){
					if(isset($_GET['categories']) && !empty($_GET['categories'])){
						$categories = explode(",", $_GET['categories']);
						// print_r($categories);
					}
					?>
					<div class="side-bar-new_n">

					<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
					<div class="top incase_mobile">
						<a href="#" class="menu_icon"><i class="fa fa-bars" aria-hidden="true"></i></a><span class="mobile_filter">List hotels with filters</span>
					</div>

					<nav class="menu incase_mobile">
						<ul class="incase_mobile">
					<!-- <li class="filter-btn_">List hotels with filters:
					</li> -->
					<li><input type="checkbox" name="categorie" class="filters" value="3stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('3stars', $categories)){ echo "checked"; } } ?>> 3 Stars</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="4stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('4stars', $categories)){ echo "checked"; } } ?> > 4 Stars</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="5stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('5stars', $categories)){ echo "checked"; } } ?> > 5 Stars</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="cheap"  <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('cheap', $categories)){ echo "checked"; } } ?> > Cheap</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="center" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('center', $categories)){ echo "checked"; } } ?> > Close to city center</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="tophotels"<?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('tophotels', $categories)){ echo "checked"; } } ?> > Top hotels</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="distance" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('distance', $categories)){ echo "checked"; } } ?> > Distance</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="highprice" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('highprice', $categories)){ echo "checked"; } } ?> > Expensive</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="lake_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('lake_view', $categories)){ echo "checked"; } } ?> > Lake view</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="luxury" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('luxury', $categories)){ echo "checked"; } } ?> > Luxury</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="panoramic_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('panoramic_view', $categories)){ echo "checked"; } } ?> > Panoramic view</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="pets" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pets', $categories)){ echo "checked"; } } ?> > Pet friendly</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="pool" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pool', $categories)){ echo "checked"; } } ?> > Pool</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="popularity" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('popularity', $categories)){ echo "checked"; } } ?> > Popularity</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="rating" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('rating', $categories)){ echo "checked"; } } ?> > Rating</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="restaurant" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('restaurant', $categories)){ echo "checked"; } } ?> > Restaurant</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="smoke" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('smoke', $categories)){ echo "checked"; } } ?> > Smoking friendly</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="river_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('river_view', $categories)){ echo "checked"; } } ?> > River view</li>
					
					<li><input type="checkbox" name="categorie" class="filters" value="sea_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('sea_view', $categories)){ echo "checked"; } } ?> > Sea view</li>
					<li class="filter-btn_"><input type="button" name="filter" class="main_filterss filters" value="Search"></li>
					</ul>
					</nav>

					<ul class="incase_desktop">
					<li class="filter-btn_">List hotels with filters:
					</li>
					<li><input type="checkbox" name="categories" class="filters" value="3stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('3stars', $categories)){ echo "checked"; } } ?>> 3 Stars</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="4stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('4stars', $categories)){ echo "checked"; } } ?> > 4 Stars</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="5stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('5stars', $categories)){ echo "checked"; } } ?> > 5 Stars</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="cheap"  <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('cheap', $categories)){ echo "checked"; } } ?> > Cheap</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="center" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('center', $categories)){ echo "checked"; } } ?> > Close to city center</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="tophotels"<?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('tophotels', $categories)){ echo "checked"; } } ?> > Top hotels</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="distance" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('distance', $categories)){ echo "checked"; } } ?> > Distance</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="highprice" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('highprice', $categories)){ echo "checked"; } } ?> > Expensive</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="lake_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('lake_view', $categories)){ echo "checked"; } } ?> > Lake view</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="luxury" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('luxury', $categories)){ echo "checked"; } } ?> > Luxury</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="panoramic_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('panoramic_view', $categories)){ echo "checked"; } } ?> > Panoramic view</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="pets" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pets', $categories)){ echo "checked"; } } ?> > Pet friendly</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="pool" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pool', $categories)){ echo "checked"; } } ?> > Pool</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="popularity" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('popularity', $categories)){ echo "checked"; } } ?> > Popularity</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="rating" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('rating', $categories)){ echo "checked"; } } ?> > Rating</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="restaurant" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('restaurant', $categories)){ echo "checked"; } } ?> > Restaurant</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="smoke" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('smoke', $categories)){ echo "checked"; } } ?> > Smoking friendly</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="river_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('river_view', $categories)){ echo "checked"; } } ?> > River view</li>
					
					<li><input type="checkbox" name="categories" class="filters" value="sea_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('sea_view', $categories)){ echo "checked"; } } ?> > Sea view</li>
					<li class="filter-btn_"><input type="button" name="filter" class="main_filters filters" value="Search"></li>
					</ul>
					</div>
					<?php
				}
				foreach ($result as $key => $value) {
				if($_GET['flag'] == 'Hotels' && empty($_GET['categories'])){
					echo $value['content'];
				}
				elseif($_GET['flag'] == 'Flights'){
						echo str_replace('&locale',' &to_name=United%20States&locale', $value['content']); 
					
				}elseif($_GET['flag'] == 'Hotels' && empty($_GET['categories'])){
				echo $value['content'];
				}elseif($_GET['flag'] == 'Hotels' && !empty($_GET['categories'])){
				 $position =  strpos($value['content'],"popularity");
				 echo $new_string = substr_replace($value['content'],$_GET['categories'].',', $position, 0);
				}
			}	

			}else{
			if($_GET['flag'] == 'Vacations' || $_GET['flag'] == 'All-Inclusive'){

			}else{

?>

<!--left-->
		<div class="left col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<!--first-section-->
			<div class="">
				<div class="">
					<div class="well">
						<div id="carousel" class="owl-carousel">
							<?php 
								$today = date('y-m-d');
								$randon_deals = "SELECT * FROM  random_deals WHERE status =1 and is_feature =1";
								$result = $mysqli->query($randon_deals);

								if(count($result) > 0)
								{
									$count = $result->num_rows;
									$no = 1; 
									foreach($result as $value)
									{
										preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $value['content'], $hrefResult);

										preg_match_all('/<img[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $value['content'], $srcResult);

										$img_href = $hrefResult['href'][0];
										$href = str_ireplace('http:','https:',$img_href);
										$img_src = $srcResult['src'][0];

										$src = str_ireplace('http:','https:',$img_src);

										$html .= '<div class="item">

										<a href="'.$href.'"class=""><img src="'.$src.'" alt="Image"></a>
										</div>';

									}
								} 
								else
								{

									$html = '<!-- Carousel items -->

									<div class="item active">
									<div class="row">
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									<div class="col-sm-3">
									<div class="img-section">
									<a href="#x" class="thumbnail"><img src="http://placehold.it/500x500" alt="Image" class="img-responsive"></a>
									<div class="overlay-area"></div>
									</div>
									</div>
									</div>
									<!--/row-->
									</div>
									<!--/item-->';

								}
								echo $html;
							?>

						</div>
					<!--/myCarousel-->
					</div>
				</div>
			</div>




			<!--banner-end-->

			<?php
			$rec_limit = 50;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
			if(isset($_GET['keyword'])){
				$today = date('y-m-d');
				$keyword = str_replace('-',' ', $_GET['keyword']); 

				$chekKeyword = "SELECT * FROM random_deals WHERE (INSTR(`category`, '".$keyword."') > 0 OR INSTR(`content`, '".$keyword."') > 0) AND status = 1 ORDER BY orderby LIMIT $offset, $rec_limit";
				$result = $mysqli->query($chekKeyword);
				$count = $result->num_rows;
				$left_rec = $count - ($page * $rec_limit);
				$rows[] = $result->fetch_assoc();
				if($count > 0){
					foreach($result as $value){
						?>
						<div class="random_content">
							<?php
							echo str_ireplace('http:','https:',$value['content']);
							?>
						</div>
						<?php
					} 
				}else{
					?>
					<div class="row left-section" style="text-align: center">
					No record found
					</div>
					<?php 
				}
			}else{
					$today = date('y-m-d');
					$randon_deals = "SELECT * FROM  random_deals WHERE status = 1 ORDER BY rand(".date("Ymd").")  LIMIT $offset, $rec_limit ";
					$result = $mysqli->query($randon_deals);
					$count = $result->num_rows;
					$left_rec = $count - ($page * $rec_limit);
					$rows[] = $result->fetch_assoc();
					if($count > 0){
						foreach($result as $value){
							?>
							<div class="random_content">
							<?php 
							//	$uid = $value['id'];
							//$string = preg_replace('~<a ([^>]*)href="[^"]+"([^>]*)>~', '<a \\1href="random_deal.php?id='.$uid.'"\\2>', $value['content']);
							echo str_ireplace('http:','https:',$value['content']);
							?>
							</div>
							<?php
						} 
					}else{
						?>
						<div class="row left-section" style="text-align: center">
							No record found
						</div>
						<?php 
					}
				}
			?>
				<div class="paggination_bottom">
					<?php
					if( $page > 0 ) {
						$last = $page - 2;
						echo "<a href =random_deals.php?page=$last>Last 50 Records</a> |";
						echo "<a href = random_deals.php?page=$page>Next 50 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals.php?page=$page class='dealNext' >Next 50 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals.php?page=last>Last 50 Records</a>";
					}
					?>
				</div>
		</div>
		<!--right-->
		<div class="right col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 20px">
			<?php 
			$randon_deals = "SELECT * FROM  add_advertisement where status = 1 ORDER BY orderby";
			$result = $mysqli->query($randon_deals);
			$rows[] = $result->fetch_assoc();
			foreach($result as $value){
				?>
				<div class="row right_ads_Deal_r">
					<?php 
					$newWidth = $value['height'];
					$newHeight = $value['width'];
					$content = preg_replace(array('/width="\d+"/i', '/height="\d+"/i'),array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),$value['affiliated']);
					//echo $content;
					$getrplace = str_replace("_top","_blank",$content);
					echo str_ireplace('http:','https:',$getrplace);
					?>
				</div>
				<?php
			}
			?>

		</div>


<?php

			
}}

		}else{
			if(isset($_GET['flag']) && $_GET['flag'] == 'Vacations' || $_GET['flag'] == 'Cruises' || $_GET['flag'] == 'Flights' || $_GET['flag'] == 'All-Inclusive'){
			}else{
			$data = groupon_api_call('80','Chicago','all%20inclusive%20resort');
			if(count($data) > 0)
			{	 ?>
				<section id="pinBoot">
					<?php
					$i= 0;
					foreach($data as $homeData)
					{
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt = 	$homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['title']; 
						$out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
							if($discountPercent != 0){
							$i++;
							?>
							<article class="white-panel">
								<a href="<?php echo  $homeData['dealUrl']; ?>"  target="_blank"><img src="<?php echo $homeData['grid4ImageUrl']; ?>" alt=""></a>
								<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
									
									<h1 class="nameIsan hotelandingnameIsan" style= "text-align: center; font-size: 14px"><?php echo $out ; ?></h1>
								</a>
								<h1 class="pricelanding"><?php echo $value ;?></h1>
								<h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
								<h2 class="valuelanding"><?php echo $price ; ?></h2>
								<h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
							</article>
							<?php
						}
					}
					?>
				</section>
				<?php
			} 
 } } ?>
	</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
}
// if($.urlParam('flag') == 'Vacations'){
// 	$('.right').css('display','none');
// 	$('.left').css('display','none');
// }
	$('#search-yelp-horizontal').hide();
	$('#search_result_dropdown').hide();
	$('#search_box_icon').click(function(){
		$('#search-yelp-horizontal').toggle(100);
	});
	$('.searchrandoms').click(function(){
		var keyword = $('.randomSearchs').val();
		if(keyword != ''){
			 window.location = "random_deals.php?keyword="+keyword;
		}else{
			 window.location = "random_deals.php";
		}
	})
	$('#searchrandoms').click(function(){
		var keyword = $('#searchbox-yelp').val();
		if(keyword != ''){
			 window.location = "random_deals.php?keyword="+keyword;
		}else{
			 window.location = "random_deals.php";
		}
	})
		$('.main_filters').click(function(){

		var favorite = [];

        $.each($("input[name='categories']:checked"), function(){

               favorite.push($(this).val());

        });
		var finalVal = favorite.join("%2C");

		var city = $('#target').val();
		   window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag=Hotels&categories='+'%2C'+finalVal;
	});
		$('.main_filterss').click(function(){

		var favorite = [];

        $.each($("input[name='categorie']:checked"), function(){

               favorite.push($(this).val());

        });
		var finalVal = favorite.join("%2C");
		var city = $('#target').val();
		   window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag=Hotels&categories='+'%2C'+finalVal;
	});

	$('.random_flight').on('click', function(){
		var flag = $(this).attr('data');
		var city = $('#target').val();
		if(flag == 'Tours'){
			if(city == 'Washington D.C.'){
				city = 'Washington';
			}
		}
		if(city != ''){
			 window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag='+flag;
		}else if(flag == 'Flights'){
			window.location.href="<?php echo $SiteURL; ?>random_deals.php?flag="+flag;
		}else{
			window.location.href="<?php echo $SiteURL; ?>random_deals.php?keyword="+flag;
		} 
	});
		$('.random_tours').on('click', function(){
		var flag = $(this).attr('data');
		var city = $('#target').val();
		if(flag == 'Tours'){
			if(city == 'Washington D.C.'){
				city = 'Washington';
			}
		}
		if(city != ''){
			 window.location.href="<?php echo $SiteURL; ?>random_deals.php";
		}else{
			window.location.href="<?php echo $SiteURL; ?>random_deals.php?keyword="+flag;
		} 
	});
	$('.random_vacation').on('click', function(){
		var flag = $(this).attr('data');
		// var city = $('#target').val();
			 window.location.href="<?php echo $SiteURL; ?>random_deals.php?flag="+flag;
	});
	$('.listing_view').on('click', function(){
		var city = $('#target').val();
		var queryArr = [];
		jQuery(".filters:checked").each(function(el) {
				var val = jQuery(this).val();
				queryArr.push(val);	
			});	
		var finalVal = queryArr.join("%2C");
		if(city != ''){
			 window.location.href="<?php echo $SiteURL; ?>random_deals.php?city="+city+'&flag=Hotels'+'&categories='+'%2C'+finalVal;
		}else{
			window.location.href="<?php echo $SiteURL; ?>random_deals.php?keyword="+flag;
		} 
	});
});


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
<script>

 $(document).ready(function() {
	$('#myCarousel').carousel({
	interval: 10000
	})
    
    $('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
	});
    
    
});

</script>

<script>
$("#carousel").owlCarousel({
  autoplay: true,
  lazyLoad: true,
  loop: true,
  
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 7000,
  smartSpeed: 800,
  nav: true,
  responsive: {
    0: {
      items: 1
    },

    600: {
      items: 3
    },

    1024: {
      items: 4
    },

    1366: {
      items: 4
    }
  }
});
</script>


 <script>
 $(document).ready(function() {
$('#pinBoot').pinterest_grid({
no_columns: 3,
padding_x: 5,
padding_y: 5,
margin_bottom: 100,
single_column_breakpoint: 700
});
});

;(function ($, window, document, undefined) {
    var pluginName = 'pinterest_grid',
        defaults = {
            padding_x: 5,
            padding_y: 5,
            no_columns: 3,
            margin_bottom: 100,
            single_column_breakpoint: 700
        },
        columns,
        $article,
        article_width;

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype.init = function () {
        var self = this,
            resize_finish;

        $(window).resize(function() {
            clearTimeout(resize_finish);
            resize_finish = setTimeout( function () {
                self.make_layout_change(self);
            }, 11);
        });

        self.make_layout_change(self);

        setTimeout(function() {
            $(window).resize();
        }, 500);
    };

    Plugin.prototype.calculate = function (single_column_mode) {
        var self = this,
            tallest = 0,
            row = 0,
            $container = $(this.element),
            container_width = $container.width();
            $article = $(this.element).children();

        if(single_column_mode === true) {
            article_width = $container.width() - self.options.padding_x;
        } else {
            article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
        }

        $article.each(function() {
            $(this).css('width', article_width);
        });

        columns = self.options.no_columns;

        $article.each(function(index) {
            var current_column,
                left_out = 0,
                top = 0,
                $this = $(this),
                prevAll = $this.prevAll(),
                tallest = 0;

            if(single_column_mode === false) {
                current_column = (index % columns);
            } else {
                current_column = 0;
            }

            for(var t = 0; t < columns; t++) {
                $this.removeClass('c'+t);
            }

            if(index % columns === 0) {
                row++;
            }

            $this.addClass('c' + current_column);
            $this.addClass('r' + row);

            prevAll.each(function(index) {
                if($(this).hasClass('c' + current_column)) {
                    top += $(this).outerHeight() + self.options.padding_y;
                }
            });

            if(single_column_mode === true) {
                left_out = 0;
            } else {
                left_out = (index % columns) * (article_width + self.options.padding_x);
            }

            $this.css({
                'left': left_out,
                'top' : top
            });
        });

        this.tallest($container);
        $(window).resize();
    };

    Plugin.prototype.tallest = function (_container) {
        var column_heights = [],
            largest = 0;

        for(var z = 0; z < columns; z++) {
            var temp_height = 0;
            _container.find('.c'+z).each(function() {
                temp_height += $(this).outerHeight();
            });
            column_heights[z] = temp_height;
        }

        largest = Math.max.apply(Math, column_heights);
        _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
    };

    Plugin.prototype.make_layout_change = function (_self) {
        if($(window).width() < _self.options.single_column_breakpoint) {
            _self.calculate(true);
        } else {
            _self.calculate(false);
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin(this, options));
            }
        });
    }

})(jQuery, window, document);
  $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
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
                    items: 3,
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
 <?php
	include('LandingPageFooter.php');
 ?>
