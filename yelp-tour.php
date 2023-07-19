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

	include('header-newfile.php');	// not login
}else{
	header('location:https://mysittivacations.com/');
}
?>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<div class="v2_content_inner2">
	<div id="loader"></div>
</div>

<div data-aos="zoom-in-right" class="banner-section hotel-hero things-todo" style="background-image:url(images/thing-to-do/things-hero.png)"> 
	<div class="container">
		<div class="mobile-hero">
			<img src="images/thing-to-do/things-hero.png">
		</div>
		<div class="carousel-caption-top">
		   <h1>Popular things to do in <?php echo $_SESSION['city_name']; ?></h1>
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

								<input id="target_location" type="text" data-cancel="" class="geo geocontrast form-control" placeholder="New York City, New York, United States" value="<?php echo $_SESSION['city_name'];?>" required="">

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






<div class="slider-section flight-sec"> 
			<div class="container">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Popular things to do</h2>
				   <p>Find fun places to see and things to do experience the art, museums, music, zoos</p>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme" id="ProductSlide">
					   
					   <div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
							    <img src="images/thing-to-do/things1.png">
								<a id="top_links" name="Museum"><p>Museum</p></a>
								<a href="#" class="starer"><i class="fa fa-star" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
							<div class="cities">
							    <img src="images/thing-to-do/seeingtours.png">
								<a id="Sightseeingguide" name="Sightseeing"><p>Sightseeing/tours</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
							</div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
							<div class="cities">
							    <img src="img/ss/ttd_img3.png">
								<a id="tourforfun" name="Tours"><p>DAY TRIP</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
							</div>
					   </div>
					   
					    <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/ttd_img4.png">
							    <a id="nightlife_yelp" name="top attractions"><p>TOP ATTRACTIONS</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="images/thing-to-do/Nightlife.png">
							    <a id="nightlife_yelp" name="nightlife"><p>Nightlife</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
								<img src="images/thing-to-do/Shopping.png">
								<a id="top_links" name="shopping"><p>Shopping</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="images/fine-dining.jpg">
								<a id="top_links" name="Fine Dinning"><p>Fine Dinning</p></a>
								<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
				   </div>
				</div>
			</div>
		</div>
		
		
		
<!--<section class="travels sec_pad what_do pt-0">
	<div class="container">
		<div class="heading">
			<h4>Popular things to do</h4>
			<p>
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
</section>-->
<!--end of travels-->

<!--local Music-->
<div class="slider-section flight-sec eat-sec"> 
	<div class="container">
		<div data-aos="zoom-in-left" class="myheader-sec">
		   <h2>Local Music</h2>
		   <p>Enjoy the music of <?php echo $_SESSION['city_name']; ?> local artist</p>
		</div>
		<div class="testimonial-section products">
		   <div class="owl-carousel owl-theme" id="ProductSlide-eat">
		   <?php
				$music = mysql_query("SELECT music_link,music_image,music_type,image_name FROM music_categories");
				$counter = 0;
				while($row = mysql_fetch_assoc($music)){ 
				if($counter%2==0){
					$class="zoom-in-right";
				}else{
					$class="zoom-in-left";
				}?>
			   <div data-aos="<?php echo $class;?>" class="testimonial-block product">
				   <div class="cities">
						<img src="images/<?php echo  $row['music_image']; ?>">
						<a href="<?php echo $row['music_link']; ?>"><p><?php echo  $row['music_type']; ?></p></a>
						<a href="<?php echo $row['music_link']; ?>" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
				   </div>
			   </div>
			   <?php 
			   $counter++;} ?>
			  
		   </div>
		</div>
	</div>
</div>

<!--end of Music -->


<!--<section class="travels sec_pad bg_grey what_do pb-0">
	<div class="container">
		<div class="heading">
			<h4>Local Music</h4>
			<p>Enjoy the music of <?php //echo $_SESSION['city_name']; ?> local artist </p>
		</div>
		<div class="travels_inner slider_nav mb-0">
			<div class="what_do_slider owl-carousel owl-theme">
				<?php
				//$music = mysql_query("SELECT music_link,music_image,music_type,image_name FROM music_categories");
				//$counter = '0';
				//while($row = mysql_fetch_assoc($music)){ ?>
					<div class="item">
						<a href="<?php //echo  $row['music_link']; ?>">
							<div class="image_sq_htfix"> 
								<img src="images/<?php //echo  $row['music_image']; ?>" alt="<?php //echo  $row['image_name']; ?>" class="img-fluid w-100">
							</div>
							<h3><?php //echo  $row['music_type']; ?></h3>
						</a>
						<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
					</div>
				<?php //} ?>
			</div>
		</div>
	</div>
</section>-->
<!--end of local music-->
<!--<section class="travels sec_pad bg_grey what_do pb-0">
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
</section>-->





<div class="slider-section flight-sec eat-sec"> 
			<div class="container">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Popular Entertainment</h2>
				   <p>Tons of exciting things for entertainment </p>
				</div>
				<div class="testimonial-section products">
				   <div class="owl-carousel owl-theme" id="ProductSlide-enter">
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/entertainment2.png">
								<a href="family.php"><p>Family</p></a>
								<a href="family.php" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
							    <img src="img/ss/entertainment3.png">
								<a href="performing-arts.php"><p>Performing Ats</p></a>
								<a href="performing-arts.php" class="starer"><i class="fa fa-star" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/entertainment4.png">
							    <a href="brewery.php"><p>Winery/Brewery</p></a>
								<a href="brewery.php" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
								<img src="images/comedy.png">
								<a href="comedy.php"><p>Comedy</p></a>
								<a href="comedy.php" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
					   <div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/entertainment2.png">
								<a href="family.php"><p>Family</p></a>
								<a href="family.php" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
					   </div>
				   </div>
				</div>
			</div>
		</div>
<!--end of popular entertainment-->

<input type="hidden" id="inputCity" value="<?php if(isset($_SESSION['city_name'])){ echo $_SESSION['city_name']; } ?>">

		<div class="slider-section discount-section stay-sec new-for"> 
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div data-aos="zoom-in-left" class="myheader-sec">
                           <h2>What to do</h2>
                           <p>Find fun place to see and  things to do experience the art,museums,music,zoos</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="heading-content">
                            <div class="content-sec">
                                <h2>Escape Room in <?php echo $_SESSION['city_name']; ?></h2>
                            </div>
                            <!--<div class="view-all-sec-new">
                                <a href="/yelp-tour.php?tours=escape%20%room">View All</a>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="row discounts_inners escape_room">
                
                </div>
            </div> 
        </div>
        
            <?php function yelp_api_data($limit,$city,$keyword){
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
        <div class="slider-section discount-section stay-sec new-for"> 
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="heading-content">
                            <div class="content-sec">
                                <h2>Family Top Attractions in <?php echo $_SESSION['city_name']; ?></h2>
                            </div>
                            <!--<div class="view-all-sec-new">
                                <a href="/family.php">View All</a>
                            </div>-->
                        </div>
                    </div>
                </div>
                
                <div class="row">
                
                <?php 
            $ciountt = 0;
            $getyelpTourData = yelp_api_data('3',$_SESSION['city_name'],'family attractions'); 
            if(!empty($getyelpTourData)) { ?>
                    <?php foreach ($getyelpTourData as $homeData):
                        
                        $ciountt++;
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
                        $tour_phone = $homeData->display_phone; ?>
                        
                        <div class="col-md-4 col-12">
                            <div class="dicount-offer-sec top-attr">
                                
                                <?php if(!empty($tour_image)) : ?>
                                    <img src="<?php echo $tour_image; ?>" class="nav-img" alt="<?php echo $tour_name ; ?> ">
                                <?php else : ?>
                                    <img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" class="nav-img" alt="<?php echo $tour_name ; ?> ">
                                <?php endif; ?>
                                
                                        
                                <div class="dis-content">
                                    <h3><?php echo $tour_name; ?></h3>
                                    <ul>
                                        <li><img class="nav-img" src="images/loc-n.png"><?php echo $tour_city; ?></li>
                                    </ul>
                                    <div class="review-sec">
                                        <a href="<?php echo $tour_url ; ?>" target="_blank" class="">
                                            <?php $for_counter = 0 ;
                                                $total = count((array)$homeData->categories)-1; 
                                                foreach ($homeData->categories as $category){
                                                    echo $category->title;
                                                    if($for_counter != $total){
                                                        echo ", ";
                                                    }
                                                    
                                                    $for_counter++; 
                                            } ?>
                                        
                                        </a>
                                        <div class="rating">
                                            <ul>
                                            
                                            <?php for($x=1;$x<=$tour_rating;$x++) { ?>
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                <?php } ?>
                                                <?php $x++;?>
                                                                            
                                            
                                            </ul>
                                            <p>(<?php echo $tour_review_count ; ?> Ratings)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php endforeach; ?>
                    
                <?php } else { ?>
                     
                        <div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6">
                            <p> No record Found</p>
                        </div>
                    
                <?php } ?>
                
            </div>
            </div>
        </div>
		
		 <div class="slider-section client-sec comedy winery-sec new-for"> 
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="heading-content">
                            <div class="content-sec">
                                <h2>Winery</h2>
                            </div>
                            <!--<div class="view-all-sec-new">
                                <a href="/brewery.php">View All</a>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="comedy-bottom-sec">
                            <div class="row">
                            
                            <?php if(isset($_POST['limit'])){
                            $limit = $_POST['limit'];
                        }else{
                            $limit = 4;
                        }
                        $getyelpTourData = yelp_api_call($limit,$_SESSION['city_name'],'Winery'); 
                        foreach ($getyelpTourData as $homeData){
                            $tour_id = $homeData->id;
                            $eventsName= $homeData->name;
                            $image_url = $homeData->image_url;
                            $eventUrl = $homeData->url;
                            $tour_review_count = $homeData->review_count;
                            $tour_rating = $homeData->rating;
                            $venue_name = $homeData->location->address1;
                            $address1 = $homeData->location->address1;
                            $address2 = $homeData->location->address2;
                            $city = $homeData->location->city;
                            $zipCode = $homeData->location->zip_code;
                            $country = $homeData->location->country;
                            $state = $homeData->location->state; 
                            $tour_phone = $homeData->display_phone;
                                
                                $image = "https://mysitti.com/images/noimage-found.jpeg"; 
                                if(!empty($image_url)){
                                    $image =  $image_url ;
                                }
                                
                                $html_winesty .= "<div class='col-12 col-sm-12 col-md-3 col-lg-3'>
                                    <div class='slide' data-aos='zoom-in-right'>
                                        <div class='discount-block'>
                                            <div class='cities'>
                                                <img src=".$image.">
                                            </div>
                                            <div class='discount-content'>
                                                <h3>".$eventsName."</h3> <span><i class='fa fa-map-marker' aria-hidden='true'></i> ".$venue_name."</span>
                                            </div>
                                            <div class='comedy-add-details'>
                                                <p><i class='fa fa-map-marker' aria-hidden='true'></i> ".$address1."  ".$address2.", ".$city.", ".$country."</p>
                                            </div>
                                            <div class='discount-action hotels'>
                                                <a class='hotel-book' href=".$eventUrl." target='_blank'>See More </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                                
                            }

                        echo $html_winesty;?>

                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="slider-section client-sec comedy winery-sec new-for"> 
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="heading-content">
                            <div class="content-sec">
                                <h2>Comedy</h2>
                            </div>
                            <!--<div class="view-all-sec-new">
                                <a href="/comedy.php">View All</a>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="testimonial-section products">
                   <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
                        <?php $getyelpTourData = yelp_api_call(4,$_SESSION['city_name'],'Comedy'); 
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
                        <div data-aos="zoom-in-left" class="testimonial-block product">
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
                                        <p>(<?php echo $tour_review_count ; ?> Ratings)</p>
                                    </div>
                                    <p><?php $for_counter = 0 ;
                                    $total = count((array)$homeData->categories)-1; 
                                    foreach ($homeData->categories as $category){
                                        echo $category->title;
                                        if($for_counter != $total){
                                            echo ", ";
                                        }
                                        $for_counter++; 
                                    } ?></p>
                                </div>
                                <div class="comedy-detail">
                                    <ul>
                                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_location_address1 ; ?> <?php echo $tour_location_address2 ; ?><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?> </li>
                                        <li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $tour_phone; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                   </div>
                </div>
            </div>
        </div>
            

<!--design end-->

       
 
<div class="slider-section flight-sec eat-sec"> 
	<div class="container">
		<div data-aos="zoom-in-left" class="myheader-sec">
		   <h2>Sports Tickets</h2>
		   <p>Enjoy the local pass time</p>
		</div>
		<div class="testimonial-section products">
		   <div class="owl-carousel owl-theme" id="ProductSlide-sport">
		   
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
							   <div data-aos="zoom-in-right" class="testimonial-block product">
								   <div class="cities">
										<img src="images/<?php echo strtolower($key); ?>.jpg">
										<a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo strtok($value, ','); ?>&city=<?php echo  $_SESSION['city_name']; ?>"><p><?php echo  strtoupper($key); ?></p></a>
										<a href="#" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
								   </div>
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
</div>
<div class="slider-section discount-section"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Adrenaline Rush</h2>
				   <p>Amazing flight,helicopter tours, and tons of exciting things to do</p>
				</div>
			</div>
		</div>
		<div class="row">
				<?php
				$randon_deals = "SELECT link,image_link,title,image_name FROM specific_adrenaline WHERE city1 like '%".$_SESSION['city_name']."%' or city2 like '%".$_SESSION['city_name']."%' limit 3";
				$result = $mysqli->query($randon_deals);
				
				$counter = '0';
				foreach ($result as $value) {
					?>
						<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
							<div class="discount-block">
								<a href="<?php echo $value['link'] ?>">
									<img src="<?php echo $value['image_link']?>" alt="<?php echo $value['image_name']; ?>">
									<div class="discount-content">
										<h3><?php echo substr($value['title'], 0, 20).'...'; ?></h3>
									</div>
								</a>
							</div>
						</div>
			<?php
					$counter++; 
				}
				?>
			
			<div class="view-tag" data-aos="zoom-in-down">
				<a data-toggle="modal" data-target="#popularcitiesModal" data-trigger="specific_page_modal" data-title="Adrenaline Rush"  data-city="<?php echo $_SESSION['city_name']; ?>" data-table2="specific_adrenaline" class="btn btn-outline-dark px-4">View all</a>
			</div>
		</div>
	</div>
</div>
		
		
		


<div class="slider-section discount-section travel-sec"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Tours & Travel</h2>
						   <p>Enjoy the scenic views of National Parks</p>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="travels_inner mb-0">
				<div class="what_do_slider22" id="city_deals_home">
					<div class="testimonial-section">
					   <div class="owl-carousel owl-theme" id="ProductSlide-audio2">
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
								<div data-aos="zoom-in-right" class="">
									<div class="discount-block">
										<a href="<?php echo $buy_url; ?>">
											<img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>">
											<div class="discount-content">
												<h3><?php echo substr($value['title'], 0, 20).'...'; ?></h3>
											</div>
										</a>
									</div>
								</div>
								<?php } 
							}?>
						</div>
					</div>
					<div class="view-tag" data-aos="zoom-in-down">
						<a href="#" data-toggle="modal" data-target="#more_audio_tourss" target="_blank" class="">View all</a>
					</div>
				</div>
				</div>
			</div>
		</div>
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
		$key = str_replace(' ','+',$key);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		$urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
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
<!--
<section>
	<div class="container">
		<hr>
	</div>
</section>
-->





<div class="slider-section discount-section travel-sec dig-sec dig_york_sec"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Dig Into <?php echo $_SESSION['city_name']; ?></h2>
						   <p>Stories, tips, and guides</p>
						</div>
					</div>
				</div>
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
					<!--<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-3 col-lg-3">
						<div class="discount-block dig">
							<img src="images/dig1.png">
							<div class="discount-content">
								<h3>NYC: SUMMIT One Vanderbilt Experience Ticket</h3>
								<div class="timer-sec">
									<img src="images/timer.png">
									<p>2 hours</p>
								</div>
							</div>
							
							<div class="stars">
								<ul>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
								</ul>
								<p>2754 Reviews</p>
							</div>
							<div class="sticker"><img src="images/dig.png"></div>
						</div>
					</div>-->
				</div>
			</div>
		</div>
		
		
		

<!--end of Top Attraction -->


<div class="slider-section discount-section stay-sec where_say_sec" id="where_say_section"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Where to stay</h2>
						   <p>Low hotel rates for luxury, comfort, pet-friendly rooms</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div data-aos="zoom-in-right" class="col-12 mb-4" id="where_say_inner_sec">
						  <?php
					   $getAds = "SELECT content FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
					   $result = $mysqli->query($getAds);
					   $count = $result->num_rows;
						   if($count > 0){
							foreach ($result as $key => $value) {
							  $fiveStar = str_replace('popularity', '5star', $value['content']);
							  echo "<div class='grid'>".str_replace('limit=50', 'limit=3', $fiveStar)."</div>";
						  }
						}
					  else{
						
						 $string =  substr($_SESSION['city_name'], 0, 3);
						 $string =  strtoupper(  $string ); 
						 if( $_SESSION['city_name'] == "San Sebastián"){
							$string = "EAS";
						}
						if( $_SESSION['city_name'] == "İstanbul"){
							$string = "IST";
						}
						 $fiveStar = '<script async src="//www.travelpayouts.com/blissey/scripts_en_us.js?categories=popularity&iata='.$string.'&type=full&currency=usd&host=hotels.mysittivacations.com%2Fhotels&marker=130544.&limit=3&powered_by=true" charset="UTF-8"></script>';
						 echo "<div class='grid'>".str_replace('limit=50', 'limit=3', $fiveStar)."</div>";
					 }
					?>
					</div>
					
					<div class="view-tag">
						 <a href="/hotels/index.php" class="">View all</a>
					</div>
					
				</div>
			</div>
		</div>



		<?php if(isset($_GET['tours'])){ ?>
	<div class="slider-section discount-section stay-sec new-for specific_escape">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
							<h2>Escape Room in <?php echo $_SESSION['city_name']; ?></h2>
						</div>

					</div>
				</div>
			</div>
			<div class="row">
				<?php
				
				$limit = 21;
$dropCity = $_SESSION['city_name'];
$key = str_replace(' ','+','escape-20-room');

$prepAddr = str_replace(' ','',$dropCity);

$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
$output= json_decode($geocode);
$latitude = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;


$ch = curl_init();   
$urlgo = "https://api.yelp.com/v3/businesses/search?term=".$key."&latitude=".$latitude."&longitude=".$longitude."&limit=".$limit."";
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

$get_deals = json_decode($result);

$getyelpTourData = $get_deals->businesses;
if(!empty($getyelpTourData)){

		    foreach ($getyelpTourData as $homeData)
		    {

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
		    	$tour_phone = $homeData->display_phone;

		    	$tour_category1 = @$homeData->categories[0]->title;
		    	$tour_category2 = @$homeData->categories[1]->title;
		    	$tour_category3 = @$homeData->categories[2]->title;

				$html .= "<div class='col-md-4 col-12'>
					<div class='dicount-offer-sec top-attr'>";
					
					
					if(!empty($tour_image)) {
		    		$html .= "<img class='nav-img' src='".$tour_image."'>";
		    	} else {
		    		$html .= "<img class='nav-img' src='https://mysitti.com/images/noimage-found.jpeg'>";
		    	}
				
				 		
						
						
						$html .= "<div class='dis-content'>
							<h3>".$tour_name."</h3>
							<ul>
								<li><img class='nav-img' src='images/loc-n.png'>".$tour_city. "</li>
							</ul>
							<div class='review-sec'>
								<a href='".$tour_url."' target='_blank' class=''>".$tour_category1."</a>
								<div class='rating'>
									<ul>";
										 
										
										for($x=1;$x<=$tour_rating;$x++) {

		    		$html .= " <li><i class='fa fa-star' aria-hidden='true'></i></li>";
		    	}
		    	if (strpos($tour_rating,'.')) {

		    		$html .= "<li><i class='fa fa-star' aria-hidden='true'></i></li>";

		    		$x++;
		    	}
									
									
									$html .= "</ul>
									<p>(".$tour_review_count." Ratings)</p>
								</div>
							</div>
						</div>
					</div>
				</div>";
				
		    	
		    }

		    echo $html;


		    ?>
		   
		<?php } else { ?>
			<div class="text-center">
				<h3> No Results Found </h3>
			</div>
			<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
	<section class="Hotel-sanf sec_pad new-for">
	<div class="container">
		<div class="heading heading-content">
			<div class="row">
				<div class="col-lg-12">
					<h2><span class="top_title">Top Attractions</span> in <?php echo $_SESSION['city_name']; ?> </h2>
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
<!-- <input type="hidden" id="inputCity" value="<?php //if(isset($_SESSION['city_name'])){ echo $_SESSION['city_name']; } ?>"> -->
	<div class='modal fade' id='popularcitiesModal'  tabindex="-1" data-focus-on="input:first"  role='dialog' style="top: 18px;">
				<div class='modal-dialog '>
					<div class='modal-content guide_modal'>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalScrollableTitle" style="font-size: 28px;">Adrenaline Rush</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" style="font-size: 36px;padding: 16px;">&times;</span>
							</button>
						</div>
						<div class="audio_tour_modal">
							<ul class="us-city-popup row">
							<?php
								$randon_deals = "SELECT link,image_link,title,image_name FROM specific_adrenaline WHERE city1 like '%".$_SESSION['city_name']."%' or city2 like '%".$_SESSION['city_name']."%' limit 21";
								$result = $mysqli->query($randon_deals);

								$counter = '0';
								foreach ($result as $value) {
								?>
								
									<li class="col-sm-3 col-md-3 col-xs-6">

										<a href="<?php echo $value['link'] ?>">
											<img src="<?php echo $value['image_link']?>">
											<span class="dealscity_name cityes_cityes_name"><?php echo substr($value['title'], 0, 20).'...'; ?></span>
											
										</a>
									</li>
								
							<?php } ?>
						
							</ul>
						</div>
						<div class='modal-footer'>
							<button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>


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

<script type="text/javascript"> 

        var geodemo = jQuery('#inputCity').val();
        var limit = "3";
        var quick_link = 'escape-20-room';
        jQuery.ajax({
            url: "ajax_yelp_home_dev.php",
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
                jQuery('.escape_room').html(response);
                jQuery('html, body').animate({
                    scrollTop: jQuery(".specific_escape").offset().top
                }, 2000);
                jQuery("#loader").removeClass("loading");
            }
        });
</script>

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
<?php if(isset($_GET['tours']) && $_GET['tours'] == 'escape%20room'){ ?>
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
		var geodemo = jQuery('#target_location').val();
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
		    	$('.Hotel-sanf').css('display','block');
		    	jQuery('.top_title').html(quick_link);
		    	jQuery('.oneArticle').html(response);
		    	jQuery('html, body').animate({
		    		scrollTop: jQuery(".Hotel-sanf").offset().top
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
						scrollTop: jQuery(".Hotel-sanf").offset().top
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
					// jQuery('.discounts_inners').css('display','none');
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
							<ul class="us-city-popup row">
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
								
									<li class="col-sm-3 col-md-3 col-xs-6">

										<a href="<?php echo $buy_url; ?>">
											<img src="<?php echo $values['image_link']; ?>">
											<span class="dealscity_name cityes_cityes_name"><?php echo substr($values['title'], 0, 20).'...'; ?></span>
											<p class="dealscitssy_name" ><?php echo $values['price']; ?></p>
											

										</a>
									</li>
								
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
							</ul>
						</div>
						<div class='modal-footer'>
							<button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
						</div>
					</div>
				</div>
			</div>
			<section class="adds sec_pad p-0">
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

				<?php include('blog-resources-new.php');?>
				
				
				<div class="mega-deal deals-sec blue-back">
					<div class="flips" id="flip1">
						<div class="flips-content" id="con-left">
							<img src="images/thing-to-do/sale-vect.png">
							<ul>
								<li>
									<div class="heading-content">
										<div class="content-sec">
											<h2>See our awesome deals</h2>
											<p>Take a look at our deals page for New York. We will save your money on Tours, Hotels and Flights. While helping you plan a fantastic vacation.</p>
											<a href="/random_deals.php">Explore Deals</a>
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
					.image_sq_htfix img {
						position: absolute;
						height: auto !important;  
						top: 50%;
						transform: translate(-50%,-50%) scale(1.8);
						left: 50%;
						width: auto!important;
					}
					ul.bxslider_banner {
						display: none;
					}
					.image_htfix_mid img {
						height: auto !important;
					}

                    #hitAjaxwithCity {
                        position: absolute;
                        right: 0;
                        width: 200px !important;
                        font-size: 21px;
                        border-radius: 50px;
                        line-height: 2;
                    }
                    .discount-section .discount-block img {
                        border-radius: 10px;
                        height: 256px;
                        object-fit: cover;
                    }
                    .discount-section .discount-block .discount-content h3 {
                        font-weight: 600;
                    }
                    .discount-section .discount-block a {
                        text-decoration: none;
                    }
                    #getyourguide-widget .activities__card a.activities__card__link {
                        position: relative;
                    }
                    #getyourguide-widget .activities__card a.activities__card__link {
                        position: relative;
                    }

                    #getyourguide-widget .activities__card .activities__card__content .badge {
                        top: 7px;
                        left: 5px;
                    }

                    
                
.feature-section.car-feature{
    padding-top: 0;
}  
.top-heading-section h1 {
    font-weight: 600;
}
.discount-block {
    box-shadow: 0px 0px 10px #0000002b;
    margin: 10px 5px;
}
.discount-block img {
    height: 190px;
    object-fit: cover;
    border-radius: 12px;
}
.testimonial-section.products a {
    text-decoration: none;
}
.discount-block .stars ul{
   padding: 0;     
}
.testimonial-section.products button {
    border-radius: 50% !important;
    margin: 10px !important;
}
.blog-block ul li:last-child {
    width: 65%;
}
.blog-block li.discount-block.first {
    width: 35%;
    margin: 0;
}
.filter_head.sort-display-sec .heading h4:after {
    content: none;
}
.filter_head.sort-display-sec .heading h4{ 
    padding-left: 0;
}
.filter_head.sort-display-sec {
    border: 1px solid #fd846b;
}
.rest-deals .accordian_info .accordion-body {
    margin: 30px 0 20px;
    background: #ffe6e1;
    padding: 20px;
    border-radius: 15px;
    text-align: center;
}
.rest-deals .blissey-widget .blissey-widget-tabs ul.blissey-widget-tabs-list {
    margin-top: 0 !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #5955b333 !important;
    padding: 15px 20px 15px 15px !important;
    display: inline-block !important;
    border: 1px solid #5955b3 !important;
    border-radius: 6px;
    color: #000 !important;
    font-weight: 600 !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-tabs-list__item--checked {
    background: #276ab5 !important;
    padding: 12px 20px 12px 15px !important;
    border: 1px solid #276ab5;
    border-radius: 5px;
    color: #fff !important;
    font-weight: 600 !important;
}
.filter_head.sort-display-sec .custom-select-box select {
    min-width: 140px;
}
.testimonial-section.products .head-yelp h3 {
    font-weight: 600;
}
.rest-deals .blissey-widget .blissey-widget-tabs {
    background: transparent !important;
}
.rest-deals .blissey-widget{
     border: none !important;   
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-body-hotels-compact-list__item {
    border-radius: 10px;
}
.rest-deals .accordian_info .blissey-widget .blissey-widget-footer {
    background-color: #ffe6e1!important;
    border-top: none !important;
}
.rest-deals .accordian_info .blissey-widget .blissey-info-price-wrapper-button a {
    background: #fe6e00 !important;
    color: #fff !important;
    border-radius: 50px !important;
}
.blog-section .discount-block .blog-details h3 {
    display: block;
    display: -webkit-box;
    margin: 0 auto;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 50px;
}
.blog-block li.discount-block.first img {
    height: 780px;
    object-fit: cover;
}
.view-tag a {
    min-width: 174.73px;
    border: none;
    text-transform: capitalize;
    font-family: poppins,sans-serif;
}   
.view-tag a:hover {
    color: #fff;
}
.slider-section.discount-section.travel-sec.dig-sec {
    background: #fff;
}
.slider-section.discount-section.stay-sec {
    margin-bottom: 50px;
}
.myheader-sec h2 {
    font-family: ubuntu,sans-serif;
    font-weight: bold;
}
.dig_york_sec .tp_powered_by {
    display: none !important;
} 
.modal-dialog-scrollable .audio_tour_modalss.national_parsd.modal-body {
    padding: 0;
    margin: 0 auto;
    display: block;
}
.modal-content.guide_modal ul.us-city-popup.row {
    width: 100%;
    padding: 0;
    margin: 10px 0 0;
}
.modal-content.guide_modal ul.us-city-popup.row li {
    position: relative;
    box-shadow: 0px 0px 10px #0000002b;
    padding: 5px;
    width: 31%;
    margin: 0 auto 15px;
    border-radius: 10px;
    overflow: hidden;
}
.modal-content.guide_modal ul.us-city-popup.row li a {
    height: auto;
    display: block;
}
.modal-content.guide_modal ul.us-city-popup.row li img {
    width: 100%;
    height: 180px;
    border-radius: 10px;
}
.modal-content.guide_modal ul.us-city-popup.row li a span.dealscity_name.cityes_cityes_name {
    margin: 0 !important;
    position: absolute;
    background: #fff;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 10px 0px;
    font-size: 14px;
    text-align: center;
}
.modal-content.guide_modal ul.us-city-popup.row li span.dealscity_name.cityes_cityes_name {
    position: relative;
    background: transparent;
    margin: 0 0 0px;
    display: block;
    padding: 10px 0 0;
}
.modal-content.guide_modal ul.us-city-popup.row li a {
    margin: 0;
    padding: 0;
}
.modal-content.guide_modal ul.us-city-popup.row li a p.dealscitssy_name {
    font-size: 14px;
}
.hotel_listitem .hotel_details.resturant_sprecification {padding: 0 20px 0;}
.hotel_listitem .hotel_details.resturant_sprecification .restro_btns .restro_deals {
    height: auto;
    padding: 0;
    justify-content: start;
    width: auto;
}

   .testimonial-block.product .cities a p {
    text-transform: uppercase;
}                 
    @media screen and (max-width:767px){
			.slider_nav .owl-nav.disabled {	display: none !important;}
						.owl-dots {display: block !important;}
						.new-for .heading-content h2:before {height: 4px;top: 12px;}
						.new-for .heading-content h2 {padding: 0 0 0 30px;font-size: 21px;}
					}
                    
                     
    @media (max-width: 480px){
        .blissey-widget {display: block;}
    }
.mega-deal .flip-img img {
    width: 90%;
}  
.Hotel-sanf{
	display: none;
}           
</style>


<script>
$('#ProductSlide').owlCarousel({
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
	$('#ProductSlide-eat').owlCarousel({
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
	
	$('#ProductSlide-enter').owlCarousel({
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
	$('#ProductSlide-sport').owlCarousel({
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
				loop:false
			}
		}
	})
</script>