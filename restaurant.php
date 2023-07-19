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

?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
		<div class="planTap custom-isangoapi-plan">Plan a Vacation. Plan a Night Out. </br>
					Plan Smarter!</div>

			<div id="loader"></div>
			 <span class='update-zero' style="display:none;">1</span>

			<div class="todo_affiliate cj-desktop">
			
				<?php 
				$getAds1 = mysql_query("SELECT * FROM `affiliate_top_ads` WHERE `page_name` = 'restaurant' ORDER BY `id` DESC");
						 $res1 = mysql_fetch_assoc($getAds1);	
						 ?>
				
				<span><?php echo $res1['af_code'];?></span>
			</div>


			<div class="todo_affiliate cj-mobile" style="display: none;">
				<span><script type="text/javascript" language="javascript" src="//www.ftjcfx.com/widget-5b06271bafd6555166725017-8265264?target=_top&mouseover=Y"></script>
			</div>


				<div class="marGin"></div>
							<aside class="sidebar v2_sidebar">
				<div class="side">
				<h2 class="near_events_first"><?php echo $dropdown_city; ?> Restaurants Deals</h2>
				</div>
				<div class="plusmnus">
			        <a href="javascript:;" class="show_hide" id="plus" style="display: none;">+</a>
			        <a href="javascript:;" class="show_hide" id="minus" style="display: none;">-</a>
              
			     </div>
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
						<br><br>
						
				    	<script type="text/javascript" charset="utf-8">
				    	$(function(){
							$("#target").on('blur',function(){
		
						  setTimeout(function(){ var geodemo = $('#target').val(); 

					    if(geodemo.length > 0){ 
					            $.ajax({
					                    type: 'POST',
					                    url: 'ajax_resturant.php',
					                    data: {changeValue: geodemo},
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
					        },2000);
					            });
					    });

					    $(function(){

							$(window).load(function(){
				    		var geodemo = $('.formatted_geocontrast').val();
					            $.ajax({
				                    type: 'POST',
				                    url: 'ajax_resturant.php',
				                    data: {changeValue: geodemo},
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
	           			$("#target").on('blur',function(){
		
						  setTimeout(function(){ var geodemo = $('#target').val(); 

					    if(geodemo.length > 0){ 
			
							$.ajax({
							    url: "get_resturant_data.php",
							    type: "POST",
							    data: {
							      formatted: geodemo
							    },
							    beforeSend: function()
							    {
							        $("#loader").addClass("loading");
							    },
							    success: function (response) 
							    {
								   	$('.side').html(response);
								   	$('.near_events_first').hide();
								   	$("#loader").removeClass("loading");
								}
						  	});
						}
					},2000);
						  	return false;    
							
							}); 
						});

					$(function(){
                      $("#restaurantList li").click(function(){
                       	 var restaurant = this.id;

                       	 var geodemo1 = $('#target').val(); 
						 if(geodemo1.length > 0){
					   		var geodemo = $('#target').val(); 
						 }else{
						   var geodemo = $('#geo-demo').val();
						 	
						 }
						
                       	 
                       	 $.ajax({
							    url: "ajax_resturant.php",
							    type: "POST",
							    data: {
							      restaurantData: restaurant, city: geodemo
							    },
							    beforeSend: function()
							    {
							        $("#loader").addClass("loading");
								   	$('.restaurantName').removeClass("active_menu");
							    },
							    success: function (response) 
							    {
                                    $('article#atrl').html(response);
								   	$("#loader").removeClass("loading");
								   	$('#'+restaurant).addClass("active_menu");
								   	if( $(window).width() < 640 ) {
								   	$('html, body').animate({scrollTop: $("article#atrl").offset().top}, 2000);
								   	  	
								    }	

								}
						  	});
						  	return false;  

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

		<script type="text/javascript">
			$(document).ready(function(){
			    
			    $(document.body).on('click','.next',function(e){
			      
			      var geodemo = $('#geo-demo').val();	
			        e.preventDefault();
			       
			        fieldName = $(this).attr('field');
			       
			        var currentVal = parseInt($('.update-zero').html());

			        if (currentVal == 30) {
			            $('.update-zero').html(currentVal);
			        }
			        else if (!isNaN(currentVal) ) {
			          
			          $('.update-zero').html(currentVal + 1);

			        } 
			        else {
			           
			            $('.update-zero').html(0);
			       }

			    });
			    
			     $(document.body).on('click','.prev',function(e){
			       
			      var geodemo = $('#geo-demo').val();	
				   
			        e.preventDefault();
			        
			        fieldName = $(this).attr('field');
			        
			        var currentVal = parseInt($('.update-zero').html());

			       
			        if (!isNaN(currentVal) && currentVal > 0) {
			          
			            $('.update-zero').html(currentVal - 1);
			          
			        } else {
			           
			            $('.update-zero').html(0);
			       }

			    });
			});

			</script>


			<script type="text/javascript">

$(document).ready(function(){
    
    $(document.body).on('click','.next',function(e){
     
    var geodemo1 = $('#target').val(); 
	 if(geodemo1.length > 0){
     var geodemo = $('#target').val(); 
	 }else{
	   var geodemo = $('#geo-demo').val();	
	 }

      var key = $(".update-zero").text();


     $.ajax({
	    url: "ajax_resturant_next.php",
	    type: "POST",
	    data: {
	      formatted: geodemo, page : key
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

    });
    
     $(document.body).on('click','.prev',function(e){
       
     var geodemo1 = $('#target').val(); 
	 if(geodemo1.length > 0){
     var geodemo = $('#target').val(); 
	 }else{
	   var geodemo = $('#geo-demo').val();	
	 }

      var key = $(".update-zero").text();

	   
      $.ajax({
	    url: "ajax_resturant_next.php",
	    type: "POST",
	    data: {
	      formatted: geodemo, page : key
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

	  $(".cj-mobile").show();
	  $(".cj-desktop").hide();


	 }	
});	
</script>

					</div> 
			</aside>
			<article id="atrl" class="oneArticle">
			
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
		</div>
	</div>
</div>

<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.sidebar-ads img{width:100%}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.home_data{width:54%;float:left;padding:10px 0}.home_image{width:28%}.home_price{width:16%}.home_city{width:100%!important}.home_city label{font-weight:700}.home_city ul{padding-left:15px}.home_city ul li{list-style-type:disc}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}.sidebar-ads_1 li{clear:both;color:#333;font-weight:600;cursor:pointer;float:left;font-size:13px;margin:10px auto;padding-left:10px;width:100%}

	.active_menu {
   	 	background-color: #44bae8;
    	padding: 5px;
	}
	@media (max-width: 767px){
		.rating2.tour_ratingd {
		    display: flex;
		    align-items: center;
		}
		.tour_cate_type li {
		    text-align: left;
		}
		article#atrl .tab-two .rating2.tour_ratingd {
		    display: flex;
		    margin: 0 0px 8px 0;
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