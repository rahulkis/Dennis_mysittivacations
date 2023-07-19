<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage=" Sports Events"; 

if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}

else
{
	include('Header.php');	// not login
}

?>

<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>
<style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			  	
	  	<?php
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
		?>
						
			<div id="loader"></div>
			
			<div class="container">
			<div class="planTap">Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>
			</div>
			</div>

	    <div class="headingActivity-new">
				<h2>City Pass</h2>
		
		</div>

		<div class="bxslider-deals-ffff">
		
		<script type="text/javascript" language="javascript" src="//www.awltovhc.com/widget-5a9372160d79ab6c412b3bd4-8265264?target=_top&mouseover=Y"></script>
				
		</div>

		<div class="clear"></div>	
				

		<div class="headingActivity-new">
				<h2>Events Deals</h2>
					<p><img src="https://mysitti.com/images/Groupon-Logo.jpg"></p>
				<a href="city-guide-events-deals.php" class="italicSee">See all</a>
			</div>

			<div class="container recommed-city">
		
				<ul class="cityguide-events-deals">
				
				</ul>
		</div>

		<div class="clear"></div>	


			
			<aside id="asde" class="sidebar v2_sidebar">
			<h2 class="near_events_first">Events</h2>
				<div class="hotel-side">
					
					<div class="filter_ticketCity">
			    
					    <input type="text" id="search-box" name="teamName" class="team-search" value="" placeholder="Search">
					    <div id="suggesstion-box"></div>
					     <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
					</div>
					<div class="dateRange">
				
						<input type="submit" id="dateRangeteam" value="Browse">
					</div>
					<div class="sport-side-bar">
					<h3 style="color: black;">Just Announced</h3>
					<div class="ticketmaster-api"></div>
					
					</div>	
					
				</div>
				

			</aside>
			<?php $url_data = $_GET;
			 $uiid = $url_data['uiid'];
			 $main_title = $url_data['title']; ?>

			<article id="atrl" class="oneArticle custom-sports-article" style="width: 50% !important;">
			<div id="audio-guide"><h1 style="color: blue;">
			</h1><h2 style="color: black;"><?php echo $main_title; ?></h2></div>
			<a style="color: black;"><h1>Back</h1></a>
			<div class="audio-summary">

			<?php 
			 $url_data = $_GET;
			 $uiid = $url_data['uiid'];
			 $main_title = $url_data['title'];

			 $ch = curl_init();

		     $url = "https://api.izi.travel/mtgobjects/".$uiid."?languages=en";

	
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

			$headers = array();
			$headers[] = "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
			    echo 'Error:' . curl_error($ch);
			}
			curl_close ($ch);

			$get_data = json_decode($result);

			$tour_name = $get_data[0]->content[0]->title;
			$audio_uiid = $get_data[0]->content[0]->audio[0]->uuid;
			$children =   $get_data[0]->content[0]->children;

			foreach ($children as $homeData) 
			{
              
			$main_uiid = $homeData->uuid;
			$circle_latitude = $homeData->trigger_zones[0]->circle_latitude;
			$circle_longitude = $homeData->trigger_zones[0]->circle_longitude;
			$content_provider_uiid = $homeData->content_provider->uuid;
			$images_uiid = $homeData->images[0]->uuid;
			$title = $homeData->title;
			$desc = $homeData->desc;

			$audio_url = "https://media.izi.travel/".$content_provider_uiid."/".$audio_uiid.".m4a";

      		$image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';


			  	$lat = $circle_latitude; 
				$long = $circle_longitude; 

				$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_ENCODING, "");
				$curlData = curl_exec($curl);
				curl_close($curl);

				$data = json_decode($curlData);

				$address = $data->results[0]->formatted_address;
			 ?>

		  <div class='home_list'>
			<div class='home_image'>
			<a target='_blank' id="<?php echo $main_uiid;?>" class="audio-tour-data" data-toggle='modal' data-target='#myModal'>
		      <img src= "<?php echo $image_url;?>" width='200' height='200'>
             </a>
	        </div>

	        <div class='home_data'>
               <div class='home_city'>
             	<h2 style='margin-left:101px;'><?php echo $title;?></h2><br/>	
				</div>

			   <div class="home_address">
			   <?php if($address){ ?>
			   	<h3 style='margin-left:101px; color: black;'><?php echo $address;?></h3>
			   	<?php }else{?>
			   	<h3 style='margin-left:101px; color: black;'>Address Not Found.</h3>
			   	<?php } ?>
			   </div>

			   <div class="home_address_map">
			   	<a style='margin-left:101px;' id="<?php echo $main_uiid;?>" class="view-map" data-toggle='modal' data-target='#myModal'>View Map
               </a>
			   </div>

	        </div>
	        <!-- model-popup -->
	        <div class='modal fade' id='myModal' role='dialog'>
			    <div class='modal-dialog'>
			      <div class='modal-content'>
			        <div class='modal-header'>

			        <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

			          <button type='button' class='close' data-dismiss='modal'>&times;</button>
			          <h4 class='modal-title'></h4>
			        </div>
			        <div class='modal-body'>
			          
			        </div>
			        <div class='modal-footer'>
			          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
	        <!-- end model popup -->
		</div>
				
			<?php } ?>	
			</div>
			
			</article>
			<!-- sidebar amazon -->
				<div>
					<div class="side-listing-amazon">
						<div class="bxslider-deals">
						<a href="http://www.tkqlhce.com/click-8265264-11182520" target="_top">
							<img src="http://www.ftjcfx.com/image-8265264-11182520" width="120" height="90" alt="" border="0"/>
						</a>

						</div>	
					</div>	
					</div>
				</div>		
				<!-- sidebar amazon -->
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">

		// AJAX call for autocomplete 
		$(document).ready(function(){
			$("#suggesstion-box").hide();
			$("#search-box").keyup(function(){
				$.ajax({
				type: "POST",
				url: "readTeam.php",
				data:'keyword='+$(this).val(),
				beforeSend: function(){
					$("#search-box").css("background","#FFF url(..imagesNew/loaderIcon.gif) no-repeat right");
				},
				success: function(data){
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#search-box").css("background","#FFF");
				}
				});
			});
		});
		//To select country name
		function selectTeam(val) {
		$("#search-box").val(val);
		$("#suggesstion-box").hide();
		}

		
		$(document).ready(function () {
			  $("#showLess").hide();

			  x=(x-20<0) ? 5 : x-20;
		      $('#myList li').not(':lt('+x+')').hide();
		      
		      size_li = $("#myList li").size();
		      var x=5;
		      $('#myList li:lt('+x+')').show();
		      $('#loadMore').click(function () {
		          x= (x+20 <= size_li) ? x+20 : size_li;
		          $('#myList li:lt('+x+')').show();
		           $('#showLess').show();
		          if(x == size_li){
		              $('#loadMore').hide();
		          }
		      });
		      $('#showLess').click(function () {
		          x=(x-20<0) ? 5 : x-20;
		          $('#myList li').not(':lt('+x+')').hide();
		          $('#loadMore').show();
		           $('#showLess').show();
		          if(x == 5){
		              $('#showLess').hide();
		          }
		      });
		  });

		$('.geo').geoContrast();


	</script>


<!-- New javascript -->	
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

<script type="text/javascript">

	$(document).ready(function() {
	$("#hitAjaxCity").click(function(){

	var geodemo = $('#geo-demo').val();	

	$.ajax({
	    url: "ajax_groupon_events_deals.php",
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
		   	$('.cityguide-events-deals').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});

	
	});

}); 

$(function(){
	$("#dateRangeteam").click(function(){
    var geodemo = $('#search-box').val();

	if (geodemo == '') {
      alert("Please select team.");
    } else {
	$.ajax({
	    url: "ajax_titcketmaster.php",
	    type: "POST",
	    data: {
	      deal1: geodemo
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.ticketmaster-api').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});
	}
	}); 
});		

 </script>

 <script type="text/javascript">
$(window).load(function(){
  var geodemo = $('#geo-demo').val();

	$.ajax({
	    url: "ajax_groupon_events_deals.php",
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
		   	$('.cityguide-events-deals').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});

  	$.ajax({
	    url: "ajax_onload_ticketmaster.php",
	    type: "POST",
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.ticketmaster-api').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});

});

</script> 

<script type="text/javascript">

$(document).ready(function() {
	$(".audio-tour-data").click(function(){

	 var id = $(this).attr("id");

	$.ajax({
	    url: "ajax_tour_data.php",
	    type: "POST",
	    data: {
	      formatted: id
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		    $('.modal-body').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});

	});

}); 

$(document).ready(function() {
	$(".view-map").click(function(){

	 var id = $(this).attr("id");

	$.ajax({
	    url: "ajax_view_map.php",
	    type: "POST",
	    data: {
	      formatted: id
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		    $('.modal-body').html(response);
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
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>