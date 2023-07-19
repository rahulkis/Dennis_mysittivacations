<?php session_start(); ?>
<?php include('customerHeader.php'); 
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>

		<div data-aos="zoom-in-right" class="banner-section hotel-hero city-hero" style="background-image:url(/mysitti-html/images/family-hero.png)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/family-hero.png">
				</div>
				<div class="carousel-caption-top">
				   <h1>Family Fun in New York</h1>
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
												<input type="Name" class="form-control" id="exampleFormControlInput1" placeholder="New York City, New York, United States">
												<a href="#">Search </a>
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
 <?php include('category-navigationDev.php'); ?>

		<div class="slider-section flight-sec"> 
			<div class="container">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Popular things to do</h2>
				   <p>Find fun places to see and things to do experience the art, museums, music, zoos</p>
				</div>
				<div class="testimonial-section products">
					<div class="owl-carousel owl-theme" id="ProductSlide">
						<div data-aos="zoom-in-right" class="testimonial-block product">
							<div class="cities">
							    <img src="img/ss/ttd_img2.png">
								<a id="Sightseeingguide" name="Sightseeing"><p>Sightseeing/tours</p></a>
								<a id="Sightseeingguide" name="Sightseeing" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
							</div>
						</div>
						<div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
							    <img src="img/ss/ttd_img1.png">
								<a id="top_links" name="Museum"><p>Museum</p></a>
								<a id="top_links" name="Museum" class="starer"><i class="fa fa-star" aria-hidden="true"></i></a>
						   </div>
						</div>
						<div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="images/nightlife.jpg">
							    <a id="nightlife_yelp" name="nightlife"><p>Nightlife</p></a>
								<a id="nightlife_yelp" name="nightlife" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
						</div>
						<div data-aos="zoom-in-left" class="testimonial-block product">
						  <div class="cities">
								<img src="images/shopping-new.jpg">
								<a id="top_links" name="Shopping"><p>Shopping</p></a>
								<a id="top_links" name="Shopping" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
						</div>
						<div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/ttd_img4.png">
								<a id="nightlife_yelp" name="top attractions"><p>TOP ATTRACTIONS</p></a>
								<a id="nightlife_yelp" name="top attractions" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
						</div>
						<div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="images/fine-dining.jpg">
								<a id="top_links" name="Fine Dinning"><p>Fine Dinning</p></a>
								<a id="top_links" name="Fine Dinning" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
						</div>	
						<div data-aos="zoom-in-right" class="testimonial-block product">
						   <div class="cities">
							    <img src="img/ss/ttd_img3.png">
								<a id="tourforfun" name="Tours" name="Fine Dinning"><p>DAY TRIP</p></a>
								<a id="tourforfun" name="Tours" class="starer"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						   </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="slider-section discount-section"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Groupon Tour Discounts</h2>
						   <p>Stories, tips, and guides</p>
						</div>
					</div>
					
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<img src="images/tour1.png">
							<div class="discount-content">
								<h3>Great Wolf Lodge Pocono Mou...</h3>
								<p>Great Wolf Lodge Waterpark Hotel</p>
							</div>
							<div class="discount-action purple-bg">
								<div class="action-content">
									<p><b>10 Hanover Square, New York • 0.8 mi</b> <span><b>$</b> 2150 <b>$1939</b> 10% OFF</span></p>
								</div>
								<a href="#"><img src="images/right-blue.png"></a>
							</div>
						</div>
					</div>
					<div data-aos="zoom-in-left" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<img src="images/tour2.png">
							<div class="discount-content">
								<h3>Great Wolf Lodge Pocono Mou...</h3>
								<p>Great Wolf Lodge Waterpark Hotel</p>
							</div>
							<div class="discount-action saff-bg">
								<div class="action-content">
									<p><b>205 Sea Breeze Avenue, Brooklyn • 9.6 mi</b> <span><b>$</b> 1300 <b>$1025</b> 21% OFF</span></p>
								</div>
								<a href="#"><img src="images/right-saff.png"></a>
							</div>
						</div>
					</div>
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
						<div class="discount-block">
							<img src="images/tour3.png">
							<div class="discount-content">
								<h3>Great Wolf Lodge Pocono Mou...</h3>
								<p>Great Wolf Lodge Waterpark Hotel</p>
							</div>
							<div class="discount-action green-bg">
								<div class="action-content">
									<p><b>Townes Harborview, Baltimore • 34.5 mi</b> <span><b>$</b> 899 <b>$1,809</b> 10% OFF</span></p>
								</div>
								<a href="#"><img src="images/right-green.png"></a>
							</div>
						</div>
					</div>
					<div class="view-tag" data-aos="zoom-in-down">
						<a href="#">View All</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="slider-section discount-section stay-sec blog-feat"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Top Attractions in <!-- New York --> <?php echo $_SESSION['city_name']; ?></h2>
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
				<?php 
				$ciountt = 0;
				$getyelpTourData = yelp_api_data('6',$_SESSION['city_name'],'family attractions'); 
				if(!empty($getyelpTourData)) { ?>
				<div class="row">
					<!-- <?php echo"<pre>";print_r($getyelpTourData);?> -->
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
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<a href=<?php echo $tour_url; ?>>
							<?php if(!empty($tour_image)) : ?>
								<img src="<?php echo $tour_image; ?>" class="img-fluid w-100" alt="<?php echo $tour_name ; ?> ">
							<?php else : ?>
								<img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg" class="img-fluid w-100" alt="<?php echo $tour_name ; ?> ">
							<?php endif; ?>
							<!-- <img src="images/top1.png"> -->
							<div class="blog-time">
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $tour_city ; ?></p>
								<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>
							</div>
							<div class="discount-content">
								<h3><?php echo $tour_name ; ?></h3>
							</div>
							<p class="trav-sec">
							<!-- Travel -->
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
						</a>
						</div>
					</div>
					<?php endforeach; ?>
					<!-- <div data-aos="zoom-in-left" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<img src="images/top2.png">
							<div class="blog-time">
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> Denver</p>
								<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>
							</div>
							<div class="discount-content">
								<h3>Intrepid Sea Air & Space Museu...</h3>
							</div>
							<p class="trav-sec">Travel</p>
						</div>
					</div>
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block city">
							<img src="images/top3.png">
							<div class="blog-time">
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> Denver</p>
								<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>
							</div>
							<div class="discount-content">
								<h3>Sugartooth Tours</h3>
							</div>
							<p class="trav-sec">Travel</p>
						</div>
					</div>
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<img src="images/top4.png">
							<div class="blog-time">
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> Denver</p>
								<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>
							</div>
							<div class="discount-content">
								<h3>Color Factory</h3>
							</div>
							<p class="trav-sec desti">Destination</p>
						</div>
					</div>
					<div data-aos="zoom-in-left" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<img src="images/top5.png">
							<div class="blog-time">
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> Denver</p>
								<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>
							</div>
							<div class="discount-content">
								<h3>Rubin Museum of Art</h3>
							</div>
							<p class="trav-sec desti">Destination <span>Travel</span></p>
						</div>
					</div>
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block city">
							<img src="images/top6.png">
							<div class="blog-time">
								<p><i class="fa fa-map-marker" aria-hidden="true"></i> Denver</p>
								<p><i class="fa fa-calendar" aria-hidden="true"></i> September 6, 2022</p>
							</div>
							<div class="discount-content">
								<h3>Children's Museum of the Arts</h3>
							</div>
							<p class="trav-sec desti">Destination <span>Travel</span></p>
						</div>
					</div> -->
				</div>
				<?php } else { ?>
					<div class="row">
						<!-- <div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6"> -->
							<p> No record Found</p>
						<!-- </div> -->
					</div>
				<?php } ?>
			</div>
		</div>
		
		<div class="slider-section tour-sec"> 
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
					<?php if($_SESSION['city_name'] == 'Washington D.C.'){
						$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 3";
					}else{
						$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 3";
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
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4">
						<div class="discount-block">
							<img src="<?php echo $values['image_link']; ?>">
							<div class="discount-content">
								<h3><?php echo substr($values['title'],0,20). '...'; ?></h3>
							</div>
						</div>
					</div>
					<?php }} ?>
					<div class="view-tag" data-aos="zoom-in-down">
						<a href="#">View All</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="slider-section discount-section"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Places to stay in <?php echo $_SESSION['city_name']; ?></h2>
						<p><?php echo $_SESSION['city_name']; ?> Hotels and Places to Stay</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
						
							<?php $getAds = "SELECT content FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
							$result = $mysqli->query($getAds);
							$count = $result->num_rows;
							if($count > 0){
							foreach ($result as $key => $value) {
							$fiveStar = str_replace('popularity', 'Pet Friendly&popularity', $value['content']);?>

							<?php   echo "<div class='grid'>".str_replace('limit=50', 'limit=3', $fiveStar)."</div>"; ?>
							<?php }
							}?>
						
					</div>
					
					<div class="view-tag">
						<a href="#">View All</a>
					</div>
				</div>
			</div>
		</div>
		
<section class="travels sec_pad what_do ">
	<?php  $get_deals = groupon_api_call('','','restaurants'); ?>
	<div class="container">
		<div class="heading">
			<h4>Restraurant Deals</h4>
			<p>Save Yourself Or Family Money With Meal Deals</p>
		</div>
		
		<div class="travels_inner slider_nav mb-0">
			<div class="discounts_inner owl-theme">
				<div class="row">
					<?php 
					$i= 0;

					foreach ($get_deals as $homeData){
					//print_r($homeData);
						$price = $homeData['options'][0]['price']['formattedAmount'];
						$value = $homeData['options'][0]['value']['formattedAmount'];
						$discountPercent = $homeData['options'][0]['discountPercent'];
						$endAt =  $homeData['options'][0]['endAt'];
						$endDate = date('m/d/Y', strtotime($endAt));
						$tour_review_count =$homeData['merchant']['recommendations'][0]['total'];
						$tour_rating = $homeData['merchant']['recommendations'][0]['rating'];
						$cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
						$streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
						$streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
						$postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
						$tourname = $homeData['merchant']['name']; 
						$out =  substr($tourname,0,60);
					//if($discountPercent != 0){
						//$i++;?>
						<div class="col-lg-4 all-inclusive sections_<?php echo $i; ?>">
							<?php   $i++; 
							echo $homeData['cardHtml']; ?>
							<!-- <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
								<div class='image_htfix_mid'>
									<img src="<?php echo $homeData['grid4ImageUrl']; ?>" class="img-fluid w-100">
								</div>
								<a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></a>
								<div class="restaurants_deals_content">
									<h4><?php echo $out ; ?></h4>

									<div class="star_rate">
										<?php for($x=1;$x<=$tour_rating;$x++): ?>
											<span class='fa fa-star checked'></span>
										<?php endfor; ?>
										<?php if (strpos($tour_rating,".")) : ?>
											<span class='fa fa-star checked'></span>
											<?php 
											$x++;
										endif; ?>
										<span  class="reviews yelpuser-review"  style="cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id; ?>">
											(<?php echo $tour_review_count ; ?> Reviews)
										</span>
									</div>
								</div>
							</a> -->
						</div>
						<script>
							$(document).ready( function (){
								var pics_str = $('.sections_<?php echo $i; ?> .cui-image').data('srcset');
                  // var pics_arr = '';
                  if(pics_str != undefined){
                  	var pics_arr = pics_str.split(',');
                  	console.log('.section_<?php echo $i; ?>');
                  	pics_str = '';
                  	$.each(pics_arr, function(index, el) {
                  		imgPath = this.trim();
                  		imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   $('.sections_<?php echo $i; ?> .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
               });
                  }
              });
          </script> 
						<?php //}
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>
		<div class="oneArticle"></div>
<div class="slider-section blog-section"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div data-aos="zoom-in-left" class="myheader-sec">
				   <h2>Blog & Resource</h2>
				   <p>Here are some beautiful destinations</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="blog-block">
					<ul>
					 <?php 
        require($_SERVER['DOCUMENT_ROOT'] . '/blog/wp-load.php');
            $args = array(
            'posts_per_page' => 5 // Specify how many posts you'd like to display
        );
            $latest_posts = new WP_Query( $args );
            if ( $latest_posts->have_posts() ) {
				$loop_Count=1;
                while ( $latest_posts->have_posts() ) {
                    $latest_posts->the_post(); 
					 $img_url = get_the_post_thumbnail_url(); 
					if($loop_Count==1){?>
						<li class="discount-block first" data-aos="zoom-in-right">
							<?php if ($img_url == ''){ ?>
                                   <img src="<?php echo $SiteURL; ?>image_2022_02_09T13_15_02_553Z.png" class="img-fluid" loading="lazy">
                               <?php } else {?>
                                <img src="<?php echo $img_url; ?>" class="img-fluid" loading="lazy">
                            <?php } ?>
							<div class="blog-details first">
								<div class="date-sec"><img src="images/thing-to-do/cal.png"> <?php the_time('M j, Y'); ?></div>
								<h3><?php the_title(); ?></h3>
							</div>
						</li>
					<?php }else{ 
						if ($img_url == ''){
							 $image_url=$SiteURL.''.'image_2022_02_09T13_15_02_553Z.png';
						} else {
							$image_url=$img_url; 
						} 
						
						$newhtml.= '<li class="discount-block" data-aos="zoom-in-left">
											<img src='.$image_url.'>
											<div class="blog-details">
												<div class="date-sec"><img src="images/thing-to-do/cal.png">'.get_the_date('M j, Y').'</div>
												<h3>'.get_the_title().'</h3>
											</div>
										</li>
										';
						
					}
						 $loop_Count++;
					}
						 echo '<li><ul>'.$newhtml.'</ul></li>';
					} else {
						echo '<p>There are no posts available</p>';
					}
					wp_reset_postdata();
					?>
					
				</div>
				<div class="view-tag" data-aos="zoom-in-down">
					<a href="/blog">View All</a>
				</div>
			</div>
		</div>
	</div>
</div>
		
		<footer class="footer-section">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
						<div class="footer-logo">
							<img src="images/logo-footer.png">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<p>We can help you plan the perfect vacation. Our travel website makes it easy to find the ideal trip and book one today! Check out our deals on flights, hotels, cruises, adventure tours, car rentals, tours, and more. We have partnered with more than 700+ airlines, over 500,000+ hotel locations, and thousands of travel sites worldwide. With so much to see and do, you want to ensure you've got the best travel plans. That's why we created our site: to help you find a great vacation package you can't find anywhere else.</p>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<ul>
							<li><a href="#">About Us</a></li>
							<li><a href="#">DMCA Policy</a></li>
							<li><a href="#">Terms & Conditions</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Other Terms & Conditions</a></li>
							<li><a href="#">Contact Us</a></li>
						</ul>
						<div class="mailer-sec">
							<img src="images/mail.png">
							<a href="#">vacations@mysittivacations.com</a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="copyright-section">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-4">
						<a href="#">© 2022 mysittivacations.com</a>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-8">
						<ul>
							<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	   
	
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/mysitti-html/js/bootstrap.bundle.min.js"></script>
    <script src="/mysitti-html/js/owl.carousel.min.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
	jQuery(document).on("click", "#tourforfun", function (e) {
					e.preventDefault();
					jQuery('.oneArticle').css('display','block');
					jQuery('.side_side_bar').css('display','block');
					jQuery('.discounts_inner').css('display','none');
					var offset = '9';
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
	</script>
	<script>
	  AOS.init();
	  
	  AOS.init({disable: 'mobile'});
	</script>
	<?php function groupon_api_call($limit,$city,$key){
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
		// echo $prepAddr;
			$key = str_replace(' ','+',$key);
			$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
			//$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=3";

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

				//$urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-4269)%20AND%20(category:things-to-do)&context=web_holiday&showBestOption=true&divisionLoc=41.8795,-87.6243&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=3";
				$urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
			endif;
		// endif;

		endif;
	// return $urlgo;
		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
		$get_deals = $get_all_data['deals'];
		return $get_deals;
	}
	?>
  </body>
</html>