<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$_SESSION['uid'] = $_GET['id'];
$titleofpage="Deals"; 
 $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<style type="text/css">
.random_list{
display: inline-table;
float: none;
margin: 0;
padding: 10px 20px;
text-align: center;
}
.audio_tour_in{
clear: both;
float: left;
margin: 0px auto;
text-align: center;
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
<div class="random">
<div class="v2_content_wrapper ">

	<div class="row">
	<!--left-->
	<ul class="audio_tour_in">
				<li class="random_list"> <a href=random_deal.php?id=<?php echo $_GET['id'];?>  class="general_page_link" ><span><img src="/images/random/exchange.png" class="img-responsive"></span>Random</br> Deals</a></li>
				<li class="random_list"> <a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=All-Inclusive class="general_page_link" ><span><img src="/images/random/all_inclusive.png" class="img-responsive"></span>All</br> Inclusive</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Hotels class="general_page_link" ><span><img src="/images/random/hotels.png" class="img-responsive"></span>Hotels</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Flights class="general_page_link" ><span><img src="/images/random/flights.png" class="img-responsive"></span>Flights</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Car-Rentals class="general_page_link" ><span><img src="/images/random/car_rental.png" class="img-responsive"></span>Car</br> Rentals</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Vacations class="general_page_link" ><span><img src="/images/random/vacations.png" class="img-responsive"></span>Vacations</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Tours class="general_page_link" ><span><img src="/images/random/tours.png" class="img-responsive"></span>Tours</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Cruises class="general_page_link" ><span><img src="/images/random/crusies.png" class="img-responsive"></span>Cruises</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Tickets class="general_page_link" ><span><img src="/images/random/tickets.png" class="img-responsive"></span>Tickets</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Travel class="general_page_link" ><span><img src="/images/random/travels.png" class="img-responsive"></span>Travel</a></li>
				<li class="random_list"><a href=random_deal.php?id=<?php echo $_GET['id'];?>&keyword=Vacation-Rentals class="general_page_link" ><span><img src="/images/random/vacationd_rentals.png" class="img-responsive"></span>Vacation</br> Rentals</a></li>
				<li class="random_list"> <span class="glyphicon glyphicon-search" id="search_box_icon" style="font-size: 19px;"></span></li>
			</ul>
			<div class="input-group stylish-input-group search-box-area-guide" id="search-yelp-horizontal">
                <input name="search-yelp-horizontal" placeholder="Search.." class="randomSearchs horizontal_yelp_content text-muted form-control" id="searchbox-yelp" type="text">
                <span class="input-group-addon iconss">
                    <button type="submit" id="searchrandoms">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
		<div class="left col-xs-12 col-sm-12 col-md-9 col-lg-9">
<div class="">
    <div class="">
        <div class="well">
            <div id="myCarousel" class="carousel slide">
                
                 <div class="carousel-inner">
                <?php 
                $today = date('y-m-d');
				$randon_deals = "SELECT * FROM  random_deals WHERE '".$today."' between start_date  AND expiry_date  or expiry_date = '0000-00-00' and is_feature =1";
				$result = $mysqli->query($randon_deals);
	
			    $html = '';
			    if(count($result) > 0)
			    {
	                 $count = $result->num_rows;
	                $no = 1; 
					foreach($result as $value)
					{
							preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $value['content'], $hrefResult);
					
							preg_match_all('/<img[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $value['content'], $srcResult);
						
							$href = $hrefResult['href'][0];
							$src = $srcResult['src'][0];

						  if($no == 1)
						  {
						    $html .= '<div class="item active"><div class="row">';	
						  }

						  $html .= '<div class="col-sm-3">
							   <div class="img-section">
							      <a href="'.$href.'" class="thumbnail"><img src="'.$src.'" alt="Image" class="img-responsive"></a>
								  <div class="overlay-area">'.$value['tittle'].'</div>
							   </div>
                            </div>';
                          
                          if($no%4 == 0 && $no != $count)
                          {
                          	 $html .='</div></div><div class="item"><div class="row">';
                          }
                          if($no == $count)
                          {
                           $html .= '</div></div>';	
                          }

                          $no++;
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
                <!--/carousel-inner-->  <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
            </div>
            <!--/myCarousel-->
        </div>
        <!--/well-->
    </div>
</div>
		<?php 
		if(isset($_GET['keyword'])){
			$today = date('y-m-d');
			$keyword = str_replace('-',' ', $_GET['keyword']); 
				$chekKeyword = "SELECT * FROM random_deals WHERE (INSTR(`category`, '".$keyword."') > 0 OR INSTR(`content`, '".$keyword."') > 0) AND status = 1 ORDER BY orderby";
				$result = $mysqli->query($chekKeyword);
				
			$count = $result->num_rows;
			$rows[] = $result->fetch_assoc();
			if($count > 0){
				foreach($result as $value){
					
					?>
					<div class="random_content">
					<?php echo  $value['content'];?>
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
			$randon_deals = "SELECT * FROM random_deals WHERE '".$today."' between start_date and expiry_date and id ='".$_GET['id']."' and status = 1 ORDER BY orderby";


			$result = $mysqli->query($randon_deals);
			$count = $result->num_rows;
			$rows[] = $result->fetch_assoc();
			if($count > 0){
				foreach($result as $value){
					?>
					<div class="random_content">
					<?php 

					echo  $value['content'];
					?>
					</div>
					<?php
				} 
			}else{
			$randon_deals = "SELECT * FROM random_deals WHERE id ='".$_GET['id']."' and expiry_date ='0000-00-00' and status = 1";
			$result = $mysqli->query($randon_deals);
			$count = $result->num_rows;
			foreach($result as $value){
					?>
					<div class="random_content">
					<?php 

					echo  $value['content'];
					?>
					</div>
					<?php
				} 

			}
			if($count > 0){
			$randon_deals1 = "SELECT * FROM  random_deals WHERE '".$today."' between start_date  AND expiry_date  or expiry_date = '0000-00-00' and status = 1 and  id != '".$_GET['id']."' ORDER BY orderby";


				$result1 = $mysqli->query($randon_deals1);
				$count1 = $result1->num_rows;
				$rows1[] = $result1->fetch_assoc();
				foreach($result1 as $value1){
					?>
					<div class="random_content">
					<?php 

					echo  $value1['content'];
					?>
					</div>
					<?php
				} 
			}else{
				?>
				<div class="row left-section" style="text-align: center">
				Advertisement has been expired.
				</div>
				<?php 
			}
		}
		?>
			<h2 style="font-size: 16px; text-align: center;"><a href="random_deals.php">View all</a></h2>
		</div>
		<!--right-->
		<div class="right col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 20px">
			<?php 
		$randon_deals = "SELECT * FROM  add_advertisement WHERE status = 1 ORDER BY orderby";
		$result = $mysqli->query($randon_deals);
		$rows[] = $result->fetch_assoc();
		foreach($result as $value){
			?>
			<div class="row right_ads_Deal_r">
				<?php 	$newWidth = $value['height'];
					$newHeight = $value['width'];

					$content = preg_replace(array('/width="\d+"/i', '/height="\d+"/i'),array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),$value['affiliated']);
				//	echo $content; 
				echo str_replace("_top","_blank",$content);
					?> 
			</div>
			<?php
		}?>
			
		</div>
		
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
	var id = <?php echo $_SESSION['uid'] ?>;
	var url = 'https://mysitti.com/random_deal.php?id='+id; 
	$('.searchrandoms').click(function(){
	 	
		var keyword = $('.randomSearchs').val();
		//alert(keyword);
		str = keyword.replace(/\s+/g, '-');

		if(keyword != ''){
			 window.location = url+"&keyword="+str;
		}else{
			 window.location = url;
		}
	})
		$('#searchrandoms').click(function(){
	 	
		var keyword = $('#searchbox-yelp').val();
		//alert(keyword);
		str = keyword.replace(/\s+/g, '-');

		if(keyword != ''){
			 window.location = url+"&keyword="+str;
		}else{
			 window.location = url;
		}
	})

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


<?php
	include('LandingPageFooter.php');
 ?>