<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Breweries/Wineries"; 

if(isset($_SESSION['user_id']))

{
	include('NewHeadeHost.php'); // login
}
else

{
	include('Header.php');	// not login
}
if (!empty($dropdown_city)) {
	$dropdown_city_get = $dropdown_city;
}

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];
$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$_SESSION['country'] = $get_state_name['country_id'];

$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
$get_co_name = mysql_fetch_assoc($co_name_query);
$conry_nm = $get_co_name['name'];
$state_name = $get_state_name['name'];

$title = $_GET['title'];
$description = $_GET['description'];

$collection_id = $_GET['collection_id'];


?>
<style type="text/css">
	.bxslider_banner > li {
  height: 402px !important;
  left: 0;
}
.bxslider_banner img {
  height: 100%;
  width: 100%;
}
aside.category-data-side {
  width: 30% !important;
}
</style>
<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
		<div class="planTap custom-isangoapi-plan">Plan a Vacation. Plan a Night Out. </br>
					Plan Smarter!</div>

			<div id="loader"></div>
			<div class="todo_affiliate">

			</div>

				<div class="marGin"></div>
			<div class="cat-head">
				<h1 style="color: black;"><?php echo $title; ?></h1><br/>
				<h2 style="color: black;"><?php echo $description; ?></h2>
				<p class="power-by" id="zomato-icons">   Powered By : <img src="https://mysitti.com/images/Zomato-Logo.jpg"></p>
			</div>		
						
				     

							<aside class="sidebar v2_sidebar category-data-side" style="">
				<div class="side">
				<h2 class="near_events_first trending-page-logo">Meal Deals <img src="https://mysitti.com/images/Groupon-Logo.jpg"></h2>
			    
				<a href="https://mysitti.com/restaurant.php" class="seeall" style="color: red;">See All</a>

				</div>
				<div class="hotel-side category-data">
					 <div data-role="page">
					  
						<div class ="sidebar-ads_1" style="width: 100%; padding: 4px;">
						  <article style="width: 100% !important; padding: 4px !important;" >
						  <div class="mealseals"></div>
	
						<?php

						$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
						$get_city_name = mysql_fetch_assoc($city_name_query);
						$dropdown_city = rawurlencode($get_city_name['city_name']);
				       
				        $address = $dropdown_city; 
						$prepAddr = str_replace(' ','+',$address);
						$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
						$output= json_decode($geocode);
						$latitude = $output->results[0]->geometry->location->lat;
						$longitude = $output->results[0]->geometry->location->lng;
				        
				        $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$dropdown_city."&lat=".$latitude."&lng=".$longitude."&query=restaurant+deals&division=".$dropdown_city."&locale=en_US&limit=12&campaign.currency=USD";

						$result_get = file_get_contents($urlgo);
						$get_all_data = json_decode($result_get, true);
				       
						$get_deals = $get_all_data['deals'];
				       
				        foreach ($get_deals as $homeData)
				        { 

                              if($homeData['options'][0]['price']['formattedAmount'] == $homeData['options'][0]['value']['formattedAmount']){
		
						    	}else{
								$price = $homeData['options'][0]['price']['formattedAmount'];
							    $value1 = $homeData['options'][0]['value']['formattedAmount'];
								$discount = $homeData['options'][0]['discount']['formattedAmount'];
								$save = 'Save ';
								$off = '% Off';
							    $discountPercent = $homeData['options'][0]['discountPercent'];
						    	}

						    	$endAt = 	$homeData['options'][0]['endAt'];
	       					   $endDate = date('m/d/Y', strtotime($endAt));
                         

				          	?>
				    	
				    	<div class="home_list">
							<div class="home_image">
							   	<img src="<?php echo $homeData['grid4ImageUrl']; ?>" width="250" height="200">
					        </div>
							<div class="home_data">
								<h2><a href="<?php echo $homeData['dealUrl']; ?>" target="_blank"><?php echo $homeData['merchant']['name']; ?></a></h2>
								<div class='alldealset p3'>
									<h1 class='pricelanding-hotel p4 h11'><?php echo $price;?><span class='valuelanding-hotel p5 s11'><?php echo $value1;?></span></h1>
									<h1 class='saleend-hotel p6 s22'>Sales Ends: <?php echo $endDate;?></h1>
			                    </div>
								<div class="home_city">
									<span><?php echo $homeData['announcementTitle']; ?></span><br>
									<h3><?php echo $homeData['division']['name']; ?></h3><br>
									<?php echo $homeData['highlightsHtml']; ?>
									</p>
									<p><?php echo $homeData['title']; ?></p>
								</div>
							</div>
						   <div class="home_price">
							<li>
								<a href="<?php echo $homeData['dealUrl']; ?>" class="homeLink" target="_blank">View Deal</a>
							</li>
						  </div>
						   </div> 
				    
				    <?php } ?>
					</article>
					</div>
					<a href="https://mysitti.com/restaurant.php" class="seeall" style="color: red;">See All</a>

						</div>
						<br><br>
						
				    	<script type="text/javascript" charset="utf-8">
				    	$(function(){
							$("#hitAjaxCity").click(function(){
				    		var geodemo = $('#geo-demo').val();
				    		var collection_id = <?php echo $collection_id?>;

					            $.ajax({
					                    type: 'POST',
					                    url: 'ajax_category_data.php',
					                    data: {changeValue: geodemo, collection_data: collection_id},
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
					    });


					    $(function(){
						$("#hitAjaxCity").click(function(){
			    		var geodemo = $('#geo-demo').val();
				            $.ajax({
				                    type: 'POST',
				                    url: 'ajax_meal_deals.php',
				                    data: {changeValue: geodemo},
				                    beforeSend: function()
								    {
								        $("#loader").addClass("loading");
								    },
					                success: function(data) {
							            $('.mealseals').html(data);
							            $("#loader").removeClass("loading");
							        }
				                });
				            });
					    });

		
				    	</script>

				    	<script type="text/javascript">
						 $(document).ready(function(){
					     $("#hitAjaxCity").click(function(){
					      	var geodemo = $('#geo-demo').val();
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
					     }) 
						});	
				</script>
					</div> 
			</aside>
			<article id="atrl" class="oneArticle categoty-article">
			
			<?php
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = rawurlencode($get_city_name['city_name']);
				if (empty($dropdown_city)) {
					$dropdown_city = "Memphis";
				}

				$address = $dropdown_city; 
				$prepAddr = str_replace(' ','+',$address);
				// $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
				$output= json_decode($geocode);
				 $latitude = $output->results[0]->geometry->location->lat;
				 $longitude = $output->results[0]->geometry->location->lng;
                
                
				$collection_id = $_GET['collection_id'];
				$title = $_GET['title'];
				$description = $_GET['description'];

				$urls = "https://developers.zomato.com/api/v2.1/search?q=".$dropdown_city."&count=30&lat=".$latitude."&lon=".$longitude."&collection_id=".$collection_id;


				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $urls);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


				$headers = array();
				$headers[] = "Accept: application/json";
				$headers[] = "User-Key: 99868269a38bfabc5532b10a32fa75c7";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
				    echo 'Error:' . curl_error($ch);
				}
				curl_close ($ch);
                
               $data = json_decode($result); 

          
                $get_deals = $data->restaurants;

	            if (!count($get_deals)) {
			    	$urls = "https://developers.zomato.com/api/v2.1/search?q=".$location."&count=30&order=desc&lat=".$latitude."&lon=".$longitude;
			    	$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $urls);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
					$headers = array();
					$headers[] = "Accept: application/json";
					$headers[] = "User-Key: 99868269a38bfabc5532b10a32fa75c7";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close ($ch);
				  	$data = json_decode($result); 
				    $get_deals = $data->restaurants;
			    }

		   
                foreach ($get_deals as $homeData)
		        { 

                  	
		          ?>
		    	
		    	<div class="home_list">  
					<div class="home_image">
					<a href="<?php echo $homeData->restaurant->url; ?>" target="_blank">
					   <?php if(!empty($homeData->restaurant->thumb)){ ?>
					   	<img src="<?php echo $homeData->restaurant->thumb; ?>" width="250" height="200">
					   	<?php }else{ ?>
					   	<img src="https://mysitti.com/images/noimage-found.jpeg" width="250" height="200">
					   	<?php } ?>
					  </a>

			        </div>
					<div class="home_data">

				
						<h2><?php echo $homeData->restaurant->name; ?></h2>
						<div class="home_city">
							<span><?php echo $homeData->restaurant->location->locality; ?></span><br>
							<h3><?php echo $homeData->restaurant->location->city; ?></h3><br>
							<h4><?php echo $homeData->restaurant->location->address; ?></h4><br>

			
							<h4>CUISINES:<?php echo $homeData->restaurant->cuisines;?></h4><br>
							<h4>COST FOR TWO: <?php echo $homeData->restaurant->currency;?><?php echo $homeData->restaurant->average_cost_for_two;?></h4><br>
                            
                            <!-- popup open -->
							<div class="review-count">
							  <button type="button" class="vewmenu" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $homeData->restaurant->id; ?>">Reviews
							  </button>

							  <!-- Modal -->
							  <div class="modal fade" id="myModal" role="dialog">
							    
							    <div class="modal-dialog">
							      <!-- Modal content-->
							      <div class="modal-content">
							        <div class="modal-header">
							        <span class="cross-icons" data-dismiss="modal"><img src="images/cross-icon.png"></span>
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							        </div>
							        <div class="modal-body">
							        </div>
							        <div class="modal-footer">
							          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        </div>
							      </div>
							      
							    </div>
							  </div>
							</div>
							<!-- popup closed -->
						</div>
					</div>
					<div class="jk">
					  	  <h2><?php echo $homeData->restaurant->user_rating->aggregate_rating; ?></h2>
					  	 <h3 style="color: black;"><?php echo $homeData->restaurant->user_rating->votes; ?>votes</h3> 
					  	 </div>	

					  	 <!-- <div class="callmenu">
					  	 	
						  	 <button type="button" class="call" data-toggle="modal">Call
							</button>

							  <button type="button" class="menu" data-toggle="modal">Menu
							  </button>
					  	 </div> -->

				</div> 
		    
		    <?php }  ?>
					
			</article>

			<!-- Right Sidebar Start -->
			<aside class="sidebar v2_sidebar right_sidebar" style="margin-left: 15px;">
				<!-- <h2 class="near_events_first right_sidebar-adds"></h2> -->
				<div class="hotel-side">

					<ul>
						<?php $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = 'trending' ORDER BY `id` DESC LIMIT 4");
							while($res = mysql_fetch_assoc($getAds)) {		
						?>
						<li>
							 <div data-role="page">
						    	<div class="cj_banner" style="margin-top: 20px; text-align: center;">
						    		<?php echo $res['af_code']; ?>
								</div>
							</div> 
					    </li>
					    <?php } ?> 

			</aside>
			<!-- Right Sidebar End -->
				</div>
		</div>
	</div>
</div>


<script type="text/javascript">

$(function(){
$(document.body).on('click', '.vewmenu', function(){	
var res_id = $(this).attr('data-id');

    $.ajax({
            type: 'POST',
            url: 'ajax_review_data.php',
            data: {rest_id: res_id},
            beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
            success: function(data) {
	            $('.modal-body').html(data);
	            $("#loader").removeClass("loading");
	        }
        });
    });
});	
</script>

<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.sidebar-ads img{width:100%}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.home_data{width:54%;float:left;padding:10px 0}.home_image{width:28%}.home_price{width:16%}.home_city{width:100%!important}.home_city label{font-weight:700}.home_city ul{padding-left:15px}.home_city ul li{list-style-type:disc}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}.sidebar-ads_1 li{clear:both;color:#333;font-weight:600;cursor:pointer;float:left;font-size:13px;margin:10px auto;padding-left:10px;width:100%}

	aside.sidebar.v2_sidebar.category-data-side {
    	width: 25% !important;
	}
	aside.sidebar.v2_sidebar {
    	width: 20% !important;
	}

	.sidebar.v2_sidebar{
		margin: 0px 15px 0 0 !important;
		width:22% !important;
	}

	aside.sidebar.v2_sidebar.right_sidebar{
		width:120px !important;
		margin: 0 0 0px 15px !important;
	}

	.right_sidebar .hotel-side{
		padding: 3px;
	}

	.cj_banner{
		margin:0px !important;
		padding: 0px !important;
	}

	#atrl{
		margin:0px 15px !important;
		width: calc(78% - 220px) !important;
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