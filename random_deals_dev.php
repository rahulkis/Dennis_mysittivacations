<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Deals"; 
 
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style type="text/css">
.random_list{ display: inline-table;
    float: none;
    margin: 0;
    padding: 9px 11px;
    text-align: center;
}
.audio_tour_in{
clear: both;
    float: left;
    margin: 0px auto;
    text-align: center;
    width: 95%;
    border-bottom: 1px solid #808080;
}
.col {
    width: 0% !important;
}
.left .carousel-control.right {
    right: 13px;
    top: 74px;
    font-size: 39px;
    background: #1b1717 !important;
    width: 30px;
    height: 50px;
    border-radius: 50px 0px 0 50px;
    line-height: 1.1;
}
.left .carousel-control.left {
    left: 12px;
    top: 75px;
    font-size: 45px;
    right: 14px;
    top: 74px;
    font-size: 39px;
    background: #191717 !important;
    width: 30px;
    height: 50px;
    border-radius: 0px 50px 50px 0px;
    line-height: 1.1;
}
.random_flight.general_page_link:hover {
    color: #0056b3 !important;
    text-decoration: underline !important;
}
.side-bar-new_n {
    width: 29%;
    float: left;
	padding: 30px;
}
.side-bar-new_n ul li input {
    margin: 0px 6px 0 0;
}
.side-bar-new_n ul li {
    font-size: 16px;
}
.blissey-widget_type--full.blissey-widget--l {
    width: 69%;
}
.side-bar-new_n .main-action_tab {
    text-align: center;
    margin: 0;
}
.side-bar-new_n ul {
    text-align: left;
    margin: 30px 0;
}
.filter-btn_ input {
    background: #06af61;
    border: 0;
    color: white;
    padding: 4px 25px;
    border-radius: 30px;
}
.blissey-widget_wrapper .blissey-widget .blissey-widget-tabs {
    height: 90px !important;
}

</style>
<div class="random">

<div class="v2_content_wrapper ">

	<div class="row random_change">
		<ul class="audio_tour_in">
				<li class="random_list"> <a href=random_deals_dev.php class="general_page_link" ><span><img src="/images/random/exchange.png" class="img-responsive"></span>Random</br> Deals</a></li>
				<li class="random_list"> <a href=random_deals_dev.php?keyword=All-Inclusive class="general_page_link" ><span><img src="/images/random/all_inclusive.png" class="img-responsive"></span>All</br> Inclusive</a></li>
				<li class="random_list"><a class="random_flight general_page_link" data="Hotels" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}" ><span><img src="/images/random/hotels.png" class="img-responsive"></span>Hotels</a></li>
				<li class="random_list"><a class="random_flight general_page_link" data="Flights" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}" ><span><img src="/images/random/flights.png" class="img-responsive"></span>Flights</a></li>
				<li class="random_list"><a href=random_deals_dev.php?keyword=Car-Rentals class="general_page_link" ><span><img src="/images/random/car_rental.png" class="img-responsive"></span>Car</br> Rentals</a></li>
				<li class="random_list"><a href=random_deals_dev.php?keyword=Vacations class="general_page_link" ><span><img src="/images/random/vacations.png" class="img-responsive"></span>Vacations</a></li>
				<li class="random_list"><a class="random_flight general_page_link" data="Tours" style="color: #007bff; a:hover {color: #0056b3; text-decoration: underline;}"><span><img src="/images/random/tours.png" class="img-responsive"></span>Tours</a></li>
				<li class="random_list"><a href=random_deals_dev.php?keyword=Cruises class="general_page_link" ><span><img src="/images/random/crusies.png" class="img-responsive"></span>Cruises</a></li>
				<li class="random_list"><a href=random_deals_dev.php?keyword=Tickets class="general_page_link" ><span><img src="/images/random/tickets.png" class="img-responsive"></span>Tickets</a></li>
				<li class="random_list"><a href=random_deals_dev.php?keyword=Travel class="general_page_link" ><span><img src="/images/random/travels.png" class="img-responsive"></span>Travel</a></li>
				<li class="random_list"><a href=random_deals_dev.php?keyword=Vacation-Rentals class="general_page_link" ><span><img src="/images/random/vacationd_rentals.png" class="img-responsive"></span>Vacationl</br> Rentals</a></li>
				<li class="random_list"> <span class="glyphicon glyphicon-search" id="search_box_icon" style="font-size: 19px;"></span></li>
			</ul>
		<div class="input-group stylish-input-group search-box-area-guide" id="search-yelp-horizontal">
                <input name="search-yelp-horizontal" placeholder="Search.." class="randomSearchs horizontal_yelp_content text-muted form-control" id="searchbox-yelp" type="text">
                <span class="input-group-addon iconss">
                    <button type="submit" id="searchrandoms" style="padding: 0px;">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
		<?php

		if(isset($_GET['city']) && !empty($_GET['city'])){
			if($_GET['flag'] == 'Flights'){
				$randon_deals = "SELECT * FROM  random_deal_widgets WHERE city LIKE '%".$_GET['city']."%'";	
			}elseif($_GET['flag'] == 'Hotels'){
				$randon_deals = "SELECT * FROM  new_random_deal_hotel_widgets WHERE city LIKE '%".$_GET['city']."%'";
			}elseif($_GET['flag'] == 'Tours') {
				$rec_limit = 30;
			if( isset($_GET{'page'} ) ) {
	            $page = $_GET{'page'} + 1;
	            $offset = $rec_limit * $page ;
	         }else {
	            $page = 0;
	            $offset = 0;
	         }
				$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_GET['city']."%'LIMIT $offset, $rec_limit";
			}
			$result = $mysqli->query($randon_deals);
			$count = $result->num_rows;
			if($count > 0){
			if ($_GET['flag'] == 'Tours') {
					?>
			<section id="pinBoot">
				<?php foreach ($result as $key => $value) {
				?>
				<article class="white-panel"><a href="<?php echo $value['link']; ?>"  target="_blank"><img src="<?php echo $value['image_link']; ?>" alt="">
					<div class="PictureCard-overlay">
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
		 } ?>
			</section>
				<div class="paggination_bottom">
					<?php
					$citysp =	$_GET['city'];
				    $city = str_replace(' ', '%20', $citysp);
					if( $page > 0 ) {
						$last = $page - 2;
						echo "<a href =random_deals_dev.php?city=$city&flag=Tours&page=$last>Last 30 Records</a> |";
						echo "<a href = random_deals_dev.php?city=$city&flag=Tours&page=$page>Next 30 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals_dev.php?city=$city&flag=Tours&page=$page>Next 30 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals_dev.php?city=$city&flag=Tours&page=last>Last 30 Records</a>";
					}
					?>
				</div>
					<?php 
				}
				if($_GET['flag'] == 'Hotels'){
					if(!isset($_GET['listing_view'])){
						$checked = 'checked';
					}else{
						$checked = 'checked';
					}
					if(isset($_GET['categories']) && !empty($_GET['categories'])){
						$categories = explode(",", $_GET['categories']);
						// print_r($categories);
					}
					?>
					<div class="side-bar-new_n">
						<ul class="main-action_tab">
					<li><b>Display Hotels Listing</b></li>
					<li><input type="radio" name="hotels" value="compact" class="listing_view" <?php if($_GET['listing_view'] == 'compact'){ echo "checked"; }else{ echo $checked; }  ?>>Compact
					<input type="radio" name="hotels" value="full" class="listing_view" <?php if($_GET['listing_view'] == 'full'){ echo "checked"; }  ?>>Full </li>
					<ul>
					<li class="filter-btn_">List hotels with : <input type="button" name="filter" class="main_filters" value="Filter">
					</li>
					<li><input type="checkbox" name="" class="filters" value="3stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('3stars', $categories)){ echo "checked"; } } ?>> 3 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="4stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('4stars', $categories)){ echo "checked"; } } ?> > 4 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="5stars" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('5stars', $categories)){ echo "checked"; } } ?> > 5 Stars</li>
					
					<li><input type="checkbox" name="" class="filters" value="cheap"  <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('cheap', $categories)){ echo "checked"; } } ?> > Cheap</li>
					
					<li><input type="checkbox" name="" class="filters" value="center" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('center', $categories)){ echo "checked"; } } ?> > Close to city center</li>
					
					<li><input type="checkbox" name="" class="filters" value="tophotels"<?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('tophotels', $categories)){ echo "checked"; } } ?> > Top hotels</li>
					
					<li><input type="checkbox" name="" class="filters" value="distance" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('distance', $categories)){ echo "checked"; } } ?> > Distance</li>
					
					<li><input type="checkbox" name="" class="filters" value="highprice" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('highprice', $categories)){ echo "checked"; } } ?> > Expensive</li>
					
					<li><input type="checkbox" name="" class="filters" value="lake_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('lake_view', $categories)){ echo "checked"; } } ?> > Lake view</li>
					
					<li><input type="checkbox" name="" class="filters" value="luxury" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('luxury', $categories)){ echo "checked"; } } ?> > Luxury</li>
					
					<li><input type="checkbox" name="" class="filters" value="panoramic_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('panoramic_view', $categories)){ echo "checked"; } } ?> > Panoramic view</li>
					
					<li><input type="checkbox" name="" class="filters" value="pets" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pets', $categories)){ echo "checked"; } } ?> > Pet friendly</li>
					
					<li><input type="checkbox" name="" class="filters" value="pool" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('pool', $categories)){ echo "checked"; } } ?> > Pool</li>
					
					<li><input type="checkbox" name="" class="filters" value="popularity" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('popularity', $categories)){ echo "checked"; } } ?> > Popularity</li>
					
					<li><input type="checkbox" name="" class="filters" value="rating" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('rating', $categories)){ echo "checked"; } } ?> > Rating</li>
					
					<li><input type="checkbox" name="" class="filters" value="restaurant" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('restaurant', $categories)){ echo "checked"; } } ?> > Restaurant</li>
					
					<li><input type="checkbox" name="" class="filters" value="smoke" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('smoke', $categories)){ echo "checked"; } } ?> > Smoking friendly</li>
					
					<li><input type="checkbox" name="" class="filters" value="river_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('river_view', $categories)){ echo "checked"; } } ?> > River view</li>
					
					<li><input type="checkbox" name="" class="filters" value="sea_view" <?php if(isset($_GET['categories']) && !empty($_GET['categories'])){ if(in_array('sea_view', $categories)){ echo "checked"; } } ?> > Sea view</li>
					</ul>
					</div>
					<?php
				}
				foreach ($result as $key => $value) {
				if($_GET['flag'] == 'Hotels' && empty($_GET['listing_view']) && empty($_GET['categories'])){
					echo $value['content'];
				}
				elseif($_GET['flag'] == 'Flights'){
					echo $value['content'];
				}elseif($_GET['flag'] == 'Hotels' && !empty($_GET['listing_view']) && empty($_GET['categories'])){
					if($_GET['listing_view'] == 'compact'){
						$search = '&type=compact';
					}else{
						$search = '&type=full';
					}
				$data =	preg_replace('/type[\s\S]+?&/', '', $value['content']);
			 	$position =  strpos($data,"&currency");
				echo $new_string = substr_replace($data, $search, $position, 0);
				}elseif($_GET['flag'] == 'Hotels' && !empty($_GET['categories'])  && !empty($_GET['listing_view'])){
				if($_GET['listing_view'] == 'compact'){
				$search = '&type=compact';
				}else{
				$search = '&type=full';
				}
				$data =	preg_replace('/type[\s\S]+?&/', '', $value['content']);
				$positiontype =  strpos($data,"&currency");
				 $new_strings = substr_replace($data, $search, $positiontype, 0);
				 $position =  strpos($value['content'],"popularity");
				 echo $new_string = substr_replace($new_strings,$_GET['categories'].',', $position, 0);
				}
			}	

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
						echo "<a href =random_deals_dev.php?page=$last>Last 50 Records</a> |";
						echo "<a href = random_deals_dev.php?page=$page>Next 50 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals_dev.php?page=$page>Next 50 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals_dev.php?page=last>Last 50 Records</a>";
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

			
}

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
						echo "<a href =random_deals_dev.php?page=$last>Last 50 Records</a> |";
						echo "<a href = random_deals_dev.php?page=$page>Next 50 Records</a>";
					}else if( $page == 0 ) {
						echo "<a href =random_deals_dev.php?page=$page>Next 50 Records</a>";
					}else if( $left_rec < $rec_limit ) {
						$last = $page - 2;
						echo "<a href =random_deals_dev.php?page=last>Last 50 Records</a>";
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
	<?php } ?>
	</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#search-yelp-horizontal').hide();
	$('#search_result_dropdown').hide();
	$('#search_box_icon').click(function(){
		$('#search-yelp-horizontal').toggle(100);
	});
	$('.searchrandoms').click(function(){
		var keyword = $('.randomSearchs').val();
		if(keyword != ''){
			 window.location = "random_deals_dev.php?keyword="+keyword;
		}else{
			 window.location = "random_deals_dev.php";
		}
	})
	$('#searchrandoms').click(function(){
		var keyword = $('#searchbox-yelp').val();
		if(keyword != ''){
			 window.location = "random_deals_dev.php?keyword="+keyword;
		}else{
			 window.location = "random_deals_dev.php";
		}
	})
		$('.main_filters').click(function(){
		var queryArr = [];
			var city = $('#target').val();
			 var type = $('input[name=hotels]:checked').val();
			jQuery(".filters:checked").each(function(el) {
				var val = jQuery(this).val();
				queryArr.push(val);	
			});	
		var finalVal = queryArr.join("%2C");
		   window.location.href="http://mysitti.com/random_deals_dev.php?city="+city+'&listing_view='+type+'&flag=Hotels&categories='+'%2C'+finalVal;
	})

	$('.random_flight').on('click', function(){
		var flag = $(this).attr('data');
		var city = $('#target').val();
		if(flag == 'Tours'){
			if(city == 'Washington D.C.'){
				city = 'Washington';
			}
		}
		if(city != ''){
			 window.location.href="http://mysitti.com/random_deals_dev.php?city="+city+'&flag='+flag;
		}else{
			window.location.href="http://mysitti.com/random_deals_dev.php?keyword="+flag;
		} 
	});
	$('.listing_view').on('click', function(){
		var city = $('#target').val();
		var listing_view = $(this).val(); 
		var queryArr = [];
		jQuery(".filters:checked").each(function(el) {
				var val = jQuery(this).val();
				queryArr.push(val);	
			});	
		var finalVal = queryArr.join("%2C");
		if(city != ''){
			 window.location.href="http://mysitti.com/random_deals_dev.php?city="+city+'&flag=Hotels'+'&listing_view='+listing_view+'&categories='+'%2C'+finalVal;
		}else{
			window.location.href="http://mysitti.com/random_deals_dev.php?keyword="+flag;
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

<style>
.v2_content_wrapper .blissey-widget_type--compact.blissey-widget--l {
    max-width: 70% !important;
    width: 70%;
}
.blissey-widget {
    display: block;
}
	#powered_by_3411 {
    width: 100%;
}
.carousel {
    margin-bottom: 0;
	padding: 0 40px 30px 40px;
}
/* Reposition the controls slightly */
.carousel-control {
	left: -12px;
}
.carousel-control.right {
	right: -12px;
}
/* Changes the position of the indicators */
.carousel-indicators {
	right: 50%;
	top: auto;
	bottom: 0px;
	margin-right: -19px;
}
/* Changes the colour of the indicators */
.carousel-indicators li {
	background: #c0c0c0;
}
.carousel-indicators .active {
background: #333333;
}


.left .carousel-control.left {
    
    background: none !important;
}


.left .carousel-control.right {
    
    background: none !important;
}

.left .carousel-control.right {
    right: -36px;
    top: 75px;
    font-size: 45px;
}

.left .carousel-control.left {
    left: -36px;
    top: 75px;
    font-size: 45px;
}
/*.v2_header_wrapper.deals_wrapper {
    height: 300px;
}*/
.item img
{
    height: 185px;
}
</style>

<?php
	include('LandingPageFooter.php');
 ?>
 <style>

#pinBoot {
  position: relative;
  max-width: 100%;
  width: 100%;
  margin:70px 0;
}

.white-panel img {
  width: 100%;
  max-width: 100%;
  height: auto;
  position:relative;
}
.PictureCard-overlay {
    z-index: 3;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: end;
    -webkit-justify-content: flex-end;
    -ms-flex-pack: end;
    justify-content: flex-end;
    padding: 10px;
    box-sizing: border-box;
    -webkit-transition: .3s background-color;
    transition: .3s background-color;
}
.PictureCard-wrapper {
    color: #fff;
    font-weight: 700;
    -webkit-transition: .3s -webkit-transform;
    transition: .3s -webkit-transform;
    transition: .3s transform;
    transition: .3s transform,.3s -webkit-transform;
    -webkit-transform: translateY(28px);
    transform: translateY(28px);
}
.PictureCard-cityName {
    font-size: 24px;
}
.PictureCard-data {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: end;
    -webkit-align-items: flex-end;
    -ms-flex-align: end;
    align-items: flex-end;
}
.PictureCard-price {
    font-size: 20px;
}
.PictureCard-duration {
    line-height: 1.8;
}
.PictureCard-menu {
    height: 55px;
    /*opacity: 0;*/
}
.PictureCard-timebox._outbound {
    padding-top: 10px;
}
.PictureCard-timebox {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    font-size: 12px;
}
.white-panel {
  position: absolute;
  background: white;
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
  padding: 0px !important;
  width:370px !important;
  overflow:hidden;
}

.white-panel h1 {
  font-size: 1em;
}
.white-panel h1 a {
  color: #A92733;
}
@media only screen and (max-width: 767px) {
  .white-panel {
	width: 100% !important;
	}
	#pinBoot {
	margin: 70px 30px !important;
	}
}

</style>

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
 </script>