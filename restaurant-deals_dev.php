<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Restaurants"; 

if(isset($_SESSION['user_id']))

{
	include('NewHeadeHost.php'); // login
}
else

{
	include('Header.php');	// not login
}

if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
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
<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.sidebar-ads img{width:100%}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.home_data{width:54%;float:left;padding:10px 0}.home_image{width:28%}.home_price{width:16%}.home_city{width:100%!important}.home_city label{font-weight:700}.home_city ul{padding-left:15px}.home_city ul li{list-style-type:disc}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}.sidebar-ads_1 li{clear:both;color:#333;font-weight:600;cursor:pointer;float:left;font-size:13px;margin:10px auto;padding-left:10px;width:100%}

	.v2_content_inner2 article.oneArticle {  margin-right: 22px;  width: 50% !important;}
	.active_menu {
   	 	background-color: #44bae8;
    	padding: 5px;
	}

	.sidebar.v2_sidebar{
		margin: 0px 15px !important;
	}

	aside.sidebar.v2_sidebar.right_sidebar{
		width:120px !important;
		margin: 0px 15px !important;
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
		width: calc(78% - 240px) !important;
	}

</style>
<div class="container-fluid">
<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<div class="planTap custom-isangoapi-plan">
				Plan a Vacation. Plan a Night Out. </br>
				Plan Smarter!
			</div>
			<a class="italicSee" id='local-rest' data-toggle='modal' data-target='#rescategoty' style="display: none;">See all</a>

			<p style="color: black;" class="hj">Powered By:<img src="https://mysitti.com/images/yelp-logo.png"></p>
			<div id="loader"></div>
			<div class="headingActivity-new">

			</div>
			<div class="container recommed-city desktop-res">
				<ul class="zomato-cat" id='zomato-cat-id'>

					<li class="col-sm-3 city-recom" id="Breakfast">
						<img src="images/pocket-frnd.jpg">
						<span>Breakfast</span>
					</li>
					<li class="col-sm-3 city-recom dine-out" id="Vegetarian Vegan">
						<img src="images/dine-out.jpg">
						<span>Vegetarian & Vegan</span>
					</li>
					<li class="col-sm-3 city-recom" id="Dinner Live Music">
						<img src="images/night-life.jpg">
						<span>Dinner & Live Music</span>
					</li>
			
					<li class="col-sm-3 city-recom" id="Coffee Tea">
						<img src="images/cafes.jpg">
						<span>Coffee & Tea</span>
					</li>
					<li class="col-sm-3 city-recom" id="Cheap Eats">
						<img src="images/daily-menu.jpg">
						<span>Cheap Eats</span>
					</li>
					<li class="col-sm-3 city-recom" id="Lunch">
						<img src="images/break-fast.jpg">
						<span>Lunch</span>
					</li>
					<li class="col-sm-3 city-recom" id="Fine Dining">
						<img src="images/lunch.jpg">
						<span>Fine Dining</span>
					</li>
					<li class="col-sm-3 city-recom" id="Steak House">
						<img src="images/dinner.png">
						<span>Steakhouse</span>
					</li>
					<li class="col-sm-3 city-recom" id="Burgers">
						<img src="images/burger.jpg">
						<span>Burgers</span>
					</li>
					<li class="col-sm-3 city-recom" id="Sushi">
						<img src="images/suhi.jpg">
						<span>Sushi</span>
					</li>

				</ul>
			</div>

			<div class="container recommed-city mobile-res" style="display: none;">
				<ul class="zomato-cat" id='zomato-cat-id'>

					<li class="col-sm-3 city-recom" id="Breakfast">
						<img src="images/pocket-frnd.jpg">
						<span>Breakfast</span>
					</li>
					<li class="col-sm-3 city-recom dine-out" id="Vegetarian Vegan">
						<img src="images/dine-out.jpg">
						<span>Vegetarian & Vegan</span>
					</li>
					<li class="col-sm-3 city-recom" id="Dinner & Live Music">
						<img src="images/night-life.jpg">
						<span>Dinner & Live Music</span>
					</li>
				</ul>
			</div>

			<!-- Local Music modal pop up -->
			<div class='modal fade' id='rescategoty' role='dialog'>

			<div class='modal-dialog'>

			  <div class='modal-content'>
			    <div class='modal-header'>

			    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

			      <button type='button' class='close' data-dismiss='modal'>&times;</button>
			      <h4 class='modal-title'></h4>
			    </div>
			    
			     <div class="container recommed-city">
					<ul class="zomato-cat" id='zomato-cat-id'>

						<li class="col-sm-3 city-recom" id="Breakfast">
							<img src="images/pocket-frnd.jpg">
							<span>Breakfast</span>
						</li>
						<li class="col-sm-3 city-recom dine-out" id="Vegetarian Vegan">
							<img src="images/dine-out.jpg">
							<span>Vegetarian & Vegan</span>
						</li>
						<li class="col-sm-3 city-recom" id="Dinner Live Music">
							<img src="images/night-life.jpg">
							<span>Dinner & Live Music</span>
						</li>
				
						<li class="col-sm-3 city-recom" id="Coffee Tea">
							<img src="images/cafes.jpg">
							<span>Coffee & Tea</span>
						</li>
						<li class="col-sm-3 city-recom" id="Cheap Eats">
							<img src="images/daily-menu.jpg">
							<span>Cheap Eats</span>
						</li>
						<li class="col-sm-3 city-recom" id="Lunch">
							<img src="images/break-fast.jpg">
							<span>Lunch</span>
						</li>
						<li class="col-sm-3 city-recom" id="Fine Dining">
							<img src="images/lunch.jpg">
							<span>Fine Dining</span>
						</li>
						<li class="col-sm-3 city-recom" id="Steak House">
							<img src="images/dinner.png">
							<span>Steakhouse</span>
						</li>
						<li class="col-sm-3 city-recom" id="Burgers">
							<img src="images/burger.jpg">
							<span>Burgers</span>
						</li>
						<li class="col-sm-3 city-recom" id="Sushi">
							<img src="images/suhi.jpg">
							<span>Sushi</span>
						</li>

					</ul>
					</div>
			     
			    <div class='modal-footer'>
			      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			    </div>
			  </div>
			  
			</div>
			</div>	
			<!-- Local Music modal pop up end -->
	
            
    		<div class="clear"></div>

			<!-- <div class="headingActivity-new">
				<h2>Deals</h2>
				<p><img src="https://mysitti.com/images/Groupon-Logo.jpg"></p>
				<a href="https://mysitti.com/restaurant.php" class="italicSee">See all</a>
			</div> -->
			<div class="zomato_deals_resturant">
			</div>
			<div class="container recommed-city">
				<div class="Deals_food">
				
				</div>
			</div>
			<div class="clear"></div>
			<div class="marGin"></div>

			<aside class="sidebar v2_sidebar col-md-3">
				<!-- <div class="side">
					<h2 class="near_events_first"><?php echo $dropdown_city; ?> Restaurants Deals</h2>
				
					<div class="plusmnus">
				        <a href="javascript:;" class="show_hide" id="plus" style="display: none;">+</a>
				        <a href="javascript:;" class="show_hide" id="minus" style="display: none;">-</a>
				    </div>
				</div> -->
				<div class="hotel-side">
				 	<div data-role="page">
						<div class ="sidebar-ads_1" style="width: 100%; padding: 4px;">
							<?php $restaurant = mysql_query("SELECT restaurant_type, restaurant_slug FROM restaurants_deals"); ?>

                          	<ul id="restaurantList" >
								 <?php while($row = mysql_fetch_assoc($restaurant)){ ?>
		                          	<li class="restaurantName" id="<?php echo $row['restaurant_slug']; ?>"><?php echo  $row['restaurant_type']; ?></li>
							    <?php } ?>		
                          	</ul>

                          	<div id='loadMore'>Show More</div>
							<div id='showLess'>Show Less</div>
					 	</div>
					</div>
				</div> 
			</aside>

			<div class="col-md-7 ">
				<!-- <div class="filter_ticketCity amazon-search amazon-search-yelp11">
				    <input type="text" id="search-box-amazon" name="teamName" class="team-search" value="" placeholder="What are you looking for?">
				    <div id="suggesstion-box-amazon yelp-search-box"></div>
				     <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
					<input type="submit" id="yelp-hitAjaxCity" class="filtering_button" name="enter_buton">
				</div>  -->
				<article id="atrl" class="oneArticle categoty-article inner_rest" style="width: 100% !important;">					
					<?php
						$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
						$get_city_name = mysql_fetch_assoc($city_name_query);
						$dropdown_city = rawurlencode($get_city_name['city_name']);
						if (empty($dropdown_city)) {
							$dropdown_city = "Memphis";
						}
		        	?>
	        	</article>
			</div>
			
			<!-- Right Sidebar Start -->
			<aside class="sidebar v2_sidebar right_sidebar col-md-2">
				<div class="hotel-side">
					<ul>
						<?php $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = 'restaurant_deals' ORDER BY `id` DESC LIMIT 4");
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
				    </ul>
				</div>
			</aside>
			<!-- Right Sidebar End -->

				</div>
		</div>
		</div>
	</div>
</div>
<!-- Us popular city -->
<div class='modal fade' id='popularcitiesModal' role='dialog'>

	<div class='modal-dialog '>
		<div class='modal-content'>
		    <div class='modal-header'>
		    	<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
		      	<button type='button' class='close' data-dismiss='modal'>&times;</button>
		      	<div id="modal_loader"></div>
		    </div>
		    <div class="cities_modal">
		    	
		    </div>
		    <div class='modal-footer'>
		      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		    </div>
		</div>
	</div>
</div>
<!-- Us popular city End -->
<!-- Review Modal code -->
<div class='modal fade' id='myModal-review' role='dialog'>
	<div class='modal-dialog'>
	  <div class='modal-content'>
	    <div class='modal-header'>
	    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
	      <button type='button' class='close' data-dismiss='modal'>&times;</button>
	      <h4 class='modal-title'></h4>
	    </div>
	    <div class='tuorfun'>
		     <ul class='modal-tour-review'>
				
			</ul> 	 
	    </div>
	    <div class='modal-footer'>
	      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
	    </div>
	  </div>
	  
	</div>
</div>
<!-- Review modal Code end here -->		
<script type="text/javascript" charset="utf-8">
	function restaurantApi(key){
		if ($('#target').val().length === 0) {
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		$.ajax({
			url: "ajax_groupon_deals.php",
			type: "POST",
			data: {
				formatted: geodemo,
				key      : key,
				title    : 'Restaurants Deals'
			},
			beforeSend: function()
			{
				$("#loader").addClass("loading");
			},
			success: function (response) 
			{
				$('.Deals_food').html(response);
				$("#loader").removeClass("loading");
			}
		});
		$.ajax({
		    // url: "get_ajax_resturant_deals.php",
		    url: "ajax_yelp_deals.php",
		    type: "POST",
		    data: {
	      		formatted: geodemo, 
		      	key      : key,
		      	design   : 'Horizontal'
		    },
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
	}

	$(window).load(function() {
		// console.log('load');
		restaurantApi('restaurants');
		if ($('#target').val().length === 0) {
			var geodemo = $('#geo-demo').val();
		}else {
			var geodemo = $('#target').val();
		}
		if(geodemo === '' || geodemo === null){
			var geodemo = 'Chicago';
		}
		console.log(geodemo);
		var source="index";
		var info = [
					{"source":"index","name":"Handpick restaurants","city":geodemo,"api":"zomato"}
	               ];
       	$.ajax({
			    url: "ajax_specific_landingpage.php",
			    type: "POST",
			    data: {
			    	info 	: info,
			    	source  : source	
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.zomato_deals_resturant').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
	});
	$(document).on('click','#restaurantList li',function(){
		// var el =$(this);
		var category_name = this.id;
		// alert(category_name);
		restaurantApi(category_name);
		$('html, body').animate({
			scrollTop: $(".groupon_deals_common_class").offset().top
	    }, 2000);
	});
	$(document).on('click','#zomato-cat-id li',function(){
		// var el =$(this);
		var category_name = this.id;
		// alert(category_name);
		restaurantApi(category_name);
		$('html, body').animate({
			scrollTop: $("#atrl").offset().top
	    }, 2000);
	});
	$(document).on("click", ".open-CitiesDialog", function () {
	    var el = $(this);
	    var modal_link = el.data('info');
	    var modal_title = el.data('title');
	    var modal_table =el.data('table');
	    var modal_trigger =el.data('trigger');
	    var modal_api =el.data('api');
	    var modal_whereCity =el.data('wherecity');
	    var modal_city =el.data('city');
	    var modal_affiliationName =el.data('affiliationname');
	    var modal_table2 =el.data('table2');
	  	$.ajax({
		    url: "ajax_specific_landingpage.php",
		    type: "POST",
		    data: {
		    	modal_link : modal_link,
		    	modal_title : modal_title,
		    	modal_trigger : modal_trigger,
		    	modal_api : modal_api,
		    	modal_whereCity : modal_whereCity,
		    	modal_city : modal_city,
		    	modal_affiliationName : modal_affiliationName,
		    	modal_table : modal_table,
		    	modal_table2 : modal_table2
		    },
		    beforeSend: function()
		    {
		        $("#modal_loader").addClass("loading");
		    },
		    success: function (response) 
		    {
		    	$('.cities_modal').html("");
			   	$('.cities_modal').html(response);
			   	$("#modal_loader").removeClass("loading");
			}
	  	});
  	});
	$(document).on('click', '#yelp-hitAjaxCity', function(){
		var search_data = $("#search-box-amazon").val();
      	if(search_data.length>0){
		 	var geodemo1 = $('#target').val(); 
           	if(geodemo1.length > 0){
               var geodemo = $('#target').val(); 
           	}else{
           	   var geodemo = $('#geo-demo').val();	
       		}

			$.ajax({
				url: "ajax_yelp_deals.php",
				type: "POST",
				data: {
					formatted: geodemo, 
			      	key      : search_data,
			      	design   : 'Horizontal'
				},
				// console.log(data);
				beforeSend: function()
				{
					$("#loader").addClass("loading");
				},
				success: function (response) 
				{
					$('article#atrl').append(response);
					$("#loader").removeClass("loading");		
				}
			});
		  	return false;

      	}else{
      		alert('Please enter search Keyword');
      	}
           
  	});
	// $('#target').keypress(function (e) {
	// 	var key = e.which;
	// 	if(key == 13)  // the enter key code
	// 	{	
	// 		$('#hitAjaxCity').trigger('click');
	// 		return false;  
	// 	}
	// });
	// $(document).on('keydown','#target', function(e){
	// 	var key = e.which;
	// 	if(key == 13)  // the enter key code
	// 	{	
	// 		// alert('pressed');
	// 		$('#hitAjaxCity').trigger('click');
	// 		return false;  
	// 	}
	// }); 
	// $(document).on('click','#hitAjaxCity',function(e){
	// 	e.preventDefault();
	// 	var geodemo = $('#target').val();
	// 	$.ajax({
	//     url: "city_search_ajax.php",
	// 	    type: "POST",
	// 	    data: {
	// 	      formatteds: geodemo
	// 	    },
	// 	    beforeSend: function()
	// 	    {
	// 	        $("#loader").addClass("loading");
	// 	    },
	// 	    success: function (response) 
	// 	    {   
	// 	 		window.location.reload();
	// 		   	$("#loader").removeClass("loading");
	// 		}
	//   	});
	//   	restaurantApi('restaurants');
 //    });
	$(document).on("click", ".open-GrouponDialog", function () {
	    var el = $(this);
	    var modal_info = el.data('info');
	    var modal_title = el.data('title');
	    var modal_limit =el.data('limit');
	    var modal_city =el.data('city');
	    var modal_key =el.data('key');
	  	var modal_url =el.data('url');
	  	$.ajax({
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
		        $("#modal_loader").addClass("loading");
		    },
		    success: function (response) 
		    {
			   	$('.cities_modal').html(response);
			   	$("#modal_loader").removeClass("loading");
			}
	  	});    
	});
	$(document.body).on('click', '.yelpuser-review', function(){	
		var tour_id = $(this).attr('data-id');
		$.ajax({
	        type: 'POST',
	        url: 'ajax_tour_review_data.php',
	        data: {tourid: tour_id},
	        beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
	        success: function(data) {
	            $('.modal-tour-review').html(data);
	            $("#loader").removeClass("loading");
	        }
	    });
	});
	$(document).ready(function () {
	  	$("#showLess").hide();
	  	x=(x-20<0) ? 15 : x-20;
      	$('#restaurantList li').not(':lt('+x+')').hide();
      	size_li = $("#restaurantList li").size();
      	var x=15;
      	$('#restaurantList li:lt('+x+')').show();
      	$('#loadMore').click(function () {
      		x= (x+20 <= size_li) ? x+20 : size_li;
      		$('#restaurantList li:lt('+x+')').show();
       		$('#showLess').show();
		      if(x == size_li){
		      	$('#loadMore').hide();
		      }
      	});
      	$('#showLess').click(function () {
      
          	x=(x-18<0) ? 15 : x-18;
          	$('#restaurantList li').not(':lt('+x+')').hide();
          	$('#loadMore').show();
           	$('#showLess').hide();
          	if(x == 15){
              $('#showLess').hide();
          	}
      	});
 	}); 
</script> 
<script type="text/javascript">
$(document).ready(function(){
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

	  $(".mobile-res").show(); 
      $(".desktop-res").hide();
      $("#local-rest").show();
	 }	
});	
</script>

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