<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="City Events"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
	$get_city_name = mysql_fetch_assoc($city_name_query);
	$dropdown_city = $get_city_name['city_name'];
	$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
	$get_state_name = mysql_fetch_assoc($state_name_query);
	$dropdown_state = $get_state_name['code'];

	$LATITUDE = $get_city_name['lat'];
	$LONGITUDE = $get_city_name['lng'];
	$CITYID = $get_city_name['city_id'];
	$_SESSION['city'] = $get_city_name['city_id'];
	$_SESSION['state'] = $get_city_name['state_id'];
	$_SESSION['country'] = $get_state_name['country_id'];
	$_SESSION['state_name'] = $get_state_name['name'];
?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
		<div class="planTap">Plan a Vacation. Plan a Night Out.<br>
					Plan Smarter!</div>
		
		<div class="headingActivity" style="margin-bottom: 20px;">
				<h2>Deals</h2>
			</div>
			<div class="plusmnus">
		        <a href="javascript:;" class="show_hide" id="plus" style="display: none;">+</a>
		        <a href="javascript:;" class="show_hide" id="minus" style="display: none;">-</a>
          
		     </div>
			<aside class="sidebar v2_sidebar">
				<div class="hotel-side">
				    <div class="filter_ticketCity filter-group-deals">
					    <input type="text" id="search-box" name="teamName" class="team-search deals-button1" value="" placeholder="Search Groupon Deals">
						<input type="submit" id="dateRangeteam" value="Browse" class="deals-sub">
					</div>
				
					 <div data-role="page">
					 	
						
						<div class="custom-side-bar">
							<div class="bar-block">
								<h2 class="hdg">local</h2>
								<ul>
									<li id="automotive">
										Automotive
									</li>
									
									<li id="beauty-and-spas">
										Beauty and Spas
									</li>
									
									<li id="food-and-drink">
										Food and Drink
									</li>
									
									<li id="health-and-fitness">
										Health and Fitness
									</li>
									
									<li id="home-improvement">
										Home Improvement
									</li>
									
									<li id="personal-services">
										Personal Services
									</li>

									<li id="retail">
										Retail
									</li>

									<li id="things-to-do">
										Things To Do
									</li>
								</ul>
							</div>
							
							<div class="bar-block">
								<h2 class="hdg">Goods</h2>
								<ul>
									<li id="auto-and-home-improvement">
										Auto and Home Improvement
									</li>
									
									<li id="baby-kids-and-toys">
										Baby Kids and Toys
									</li>
									
									<li id="collectibles">
										Collectibles
									</li>
									
									<li id="electronics">
										Electronics
									</li>
									
									<li id="entertainment-and-media">
										Entertainment and Media
									</li>
									
									<li id="for-the-home">
										For the Home
									</li>

									<li id="groceries-household-and-pets">
										Groceries Household and Pets
									</li>

									<li id="health-and-beauty">
										Health and Beauty
									</li>

									<li id="jewelry-and-watches">
										Jewelry and Watches
									</li>

									<li id="mens-clothing-shoes-and-accessories">
										Mens Clothing Shoes and Accessories
									</li>

									<li id="sports-and-outdoors">
										Sports and Outdoors
									</li>

									<li id="womens-clothing-shoes-and-accessories">
										Womens Clothing Shoes and Accessories
									</li>
									
								</ul>
							</div>
							
							<div class="bar-block">
								<h2 class="hdg">Travel</h2>
								<ul>
									<li id="cruise-travel">
										Cruise Travel
									</li>
									
									<li id="flights-and-transportation">
										Flights and Transportation
									</li>
									
									<li id="hotels-and-accommodations">
										Hotels and Accommodations
									</li>
									
									<li id="tour-travel">
										Tour Travel
									</li>
								</ul>
							</div>
							
							
						</div>
						
						<div class="cj_banner" style="margin-top: 20px; text-align: center;">
							<iframe src='//www.groupon.com/content-assembly/render/17296f80-92ef-11e7-90c4-0983c720d394' width='160' height ='600' frameBorder='0' scrolling='no'></iframe>
						</div>
						
				    	<script type="text/javascript" charset="utf-8">
				    	$(document).ready(function(){	
				    	$(".custom-side-bar li").click(function(){
				    		var con = $(this).attr('id');
				    		

				    		  var geodemo1 = $('#target').val(); 
							 if(geodemo1.length > 0){
						   	   var gondesti = $('#target').val(); 
							 }else{
							   var gondesti = $('#geo-demo').val();
							 	
							 }
				    	
					            $.ajax({
				                    type: 'POST',
				                    url: 'grouponFiltercat.php',
				                    data: {changeValue: con, citygon: gondesti},
				                    beforeSend: function()
								    {
								        $("#loader").addClass("loading");
								    },
					                success: function(data) {
							            $('article#atrl').html(data);
							            $("#loader").removeClass("loading");
							        }
					             });
					      		
					    });

							    $("#dateRangeteam").click(function(){
					    		  var value = $("#search-box").val();
					    		 if(value.length==''){
					    		 	alert('Please fill the deals')
					    		 }else{
					    		 	var geodemo1 = $('#target').val(); 
								 if(geodemo1.length > 0){
							     var gondesti = $('#target').val(); 
								 }else{
								   var gondesti = $('#geo-demo').val();
								 	
								 }
						           $.ajax({
					                    type: 'POST',
					                    url: 'ajax_seeallGrouponDeals.php',
					                    data: {changeValue: value, citygon: gondesti},
					                    beforeSend: function()
									    {
									        $("#loader").addClass("loading");
									    },
						                success: function(data) {
								            $('article#atrl').html(data);
								            $("#loader").removeClass("loading");
								        }
						             });
						         }   
						      		
						    }); 
					    });

					    $(document).ready(function(){
					    
		           			$("#target").on('blur',function(){

								setTimeout(function(){ var geodemo = $('#target').val(); 
							if(geodemo.length > 0){    
							if (geodemo == '') {
					           alert("Please fill any city.");
					            } else {
					            	
								$.ajax({
								    url: "grouponFilter-concerts.php",
								    type: "POST",
								    data: {formatted: geodemo},
								    beforeSend: function()
								    {
								        $("#loader").addClass("loading");
								    },
								    success: function (response) 
								    {
									   	$('article#atrl').html(response);
									   	$("#loader").removeClass("loading");
									}
							  	});
							  	return false;    
								 }
								}
							  },2000);	 
								 }); 
							}); 

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
							 },2000);                   
						     })

							});	
					   
				    	</script>


					</div> 
				</div>
			</aside>
			<div id="loader"></div>
			<article id="atrl" class="oneArticle">
				<input type="hidden" id="gondesti" value="<?php echo $cityvalue; ?>">
			<?php
			
		$prepAddr = str_replace(' ','+',$dropdown_city);
		$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;


	$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($dropdown_city)."&lat=".$latitude."&lng=".$longitude."&query=".rawurlencode($dropdown_city)."+concerts&offset=0&limit=50";

				$result_get = file_get_contents($urlgo);
				$get_all_data = json_decode($result_get, true);
				$get_deals = $get_all_data['deals'];
			
	        foreach ($get_deals as $homeData) 
	        {  	

	        	$price = $homeData['options'][0]['price']['formattedAmount'];
			    $value = $homeData['options'][0]['value']['formattedAmount'];
			    $discountPercent = $homeData['options'][0]['discountPercent'];
			    $discount = $homeData['options'][0]['discount']['formattedAmount'];
			    $endAt = 	$homeData['options'][0]['endAt'];
		        $endDate = date('m/d/Y', strtotime($endAt));
		        $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
		        $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
		        $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
		        $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
		        
	        	?>
	        	
	        	<div class="home_list">
					<div class="home_image newhotels-deals">
						<a href="<?php echo $homeData['dealUrl']; ?>" class="homeLink1" target="_blank">
					   	<img src="<?php echo $homeData['grid4ImageUrl']; ?>" width="250" height="200">
					   	</a>
					   		<h2 class='deals-name-new'>
					<a href='<?php echo $homeData['dealUrl'];?>' target='_blank'><?php echo $homeData['merchant']['name'];?></a>
                     	</h2>
                    <h1 class='addres1 p8'><?php echo $streetAddress1;?></h1>
					<h1 class='addres2 p9'><?php echo $streetAddress2;?></h1>
					<h1 class='cityNamelanding p10'><?php echo $cityName.', '.$postalCode;?></h1>
			        </div>
		
					<div class='home_data newHotelsdeals'>
						<h2 class='discountPercent p1'><?php echo $discountPercent.'% Off'?></h2>
						<span class='announcementTitledeasl p2' style='color: black;'><?php echo $homeData['announcementTitle'];?></span><br>
                       <div class='alldealset p3'>
						<h1 class='pricelanding-hotel p4'><?php echo $price;?><span class='valuelanding-hotel p5'><?php echo $value;?></span></h1>
						<h1 class='saleend-hotel p6'><?php echo 'Sales Ends: '.$endDate;?></h1>
                       </div>

						<div class='home_city'>
						<h1 class='discountNight p7'><?php echo 'Save '.$discount;?></h1>
							<p><?php echo $homeData['highlightsHtml'];?></p>
							<a href='<?php echo $homeData['dealUrl'];?>' target='_blank' class='read_more'>
					   	      Read More
					   		</a>
						</div>
					</div>

				</div> 
	        
	        <?php } ?>
			</article>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
 if( $(window).width() < 640 ) {
  $("#plus").show();
  $(".v2_sidebar").hide();

  $("#plus").click(function(){
  $(".v2_sidebar").slideDown("show");
  $("#plus").hide();
  $("#minus").show();
  });

  $("#minus").click(function(){
  $(".v2_sidebar").slideUp("hide");
  $("#plus").show();
  $("#minus").hide();
  }); 

 }	
});	
</script>

<style type="text/css">
.home_data {
    width: 54%;
    float: left;
}
.home_image {
	width: 28%;
}
.home_price {
	width: 16%;
}
.home_city {
	width: 100% !important;
}
.home_city label {
    font-weight: bold;
}
.home_city ul {
	padding-left: 15px;
}
.home_city ul li {
	list-style-type: disc;
}
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
<?php
if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<?php
	include('LandingPageFooter.php');
 ?>