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

<style type="text/css">
	.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.home_data{width:54%;float:left}.home_image{width:28%}.home_price{width:16%}.home_city{width:100%!important}.home_city label{font-weight:700}.home_city ul{padding-left:15px}.home_city ul li{list-style-type:disc}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="todo_affiliate">
	 		<?php 
	 		if(isset($_GET['activity'])) {
			$get_page = $_GET['activity'];
			$page_name = str_replace("-", "", $get_page);

			}
	 		if ($page_name == 'thingstodo') {
	 			$page_name = 'family';
	 		}
			$getAds = mysql_query("SELECT * FROM `affiliate_top_ads` WHERE `page_name` = '$page_name' ORDER BY `id` DESC LIMIT 1 ");
			$res = mysql_fetch_assoc($getAds);
				
			?>
			<div class = "sidebar-ads" style="width: 100%; padding: 4px;">
				<?php echo $res['af_code']; ?>
			</div>
	 	</div>
	 	
		<div class="v2_content_inner2">
		<div class="planTap">Plan a Vacation. Plan a Night Out.<br>
					Plan Smarter!</div>
		<?php 
		if(isset($_GET['activity']))
		{
		$new_cat = $_GET['activity'];
		$string = str_replace("-", " ", $new_cat);
		$page_name = str_replace("-", "", $new_cat);
		if ($page_name == 'thingstodo') {
			$string = 'Family';
		}
		?>
			<aside class="sidebar v2_sidebar">
				<h2 class="near_events_first"><?php echo ucfirst($string); ?> Fun</h2>
				<div class="hotel-side">

					<ul>
						<?php $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = '$page_name' ORDER BY `id` DESC LIMIT 8");
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
			<div id="loader"></div>
			<article id="atrl" class="oneArticle">
				<input type="hidden" id="gondesti" value="<?php echo $cityvalue; ?>">
			<?php

				$address = $dropdown_city; 
				$prepAddr = str_replace(' ','+',$address);
				$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				$output= json_decode($geocode);
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;


				$post_limit = '25';
				if($new_cat == "all")
				{
				$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_201236_212556_0&division_id=".rawurlencode($dropdown_city)."&offset=0&limit=".$post_limit." ";

				} elseif($new_cat == "sports-and-outdoors") {
				$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($dropdown_city)."&lat=".$latitude."&lng=".$longitude."&query=sports+outdoors&division=".rawurlencode($dropdown_city)."&locale=en_US&limit=".$post_limit." ";

				} else {
				$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".rawurlencode($dropdown_city)."&lat=".$latitude."&lng=".$longitude."&query=Family+activities&division=".rawurlencode($dropdown_city)."&locale=en_US&limit=".$post_limit." ";
				}
				$result_get = file_get_contents($urlgo);
				$get_all_data = json_decode($result_get, true);
				$get_deals = $get_all_data['deals'];
			
	        foreach ($get_deals as $homeData) {	?>
	           <div class="outdoor">
	        	<div class="home_list">
					<div class="new-home-image">
					   	<img src="<?php echo $homeData['grid4ImageUrl']; ?>" width="250" height="200">
			        </div>
					<div class="home_data">
						<h2><a href="<?php echo $homeData['dealUrl']; ?>" target="_blank"><?php echo $homeData['merchant']['name']; ?></a></h2>
						<div class="home_city">
							<span><?php echo $homeData['announcementTitle']; ?></span><br>
							<h3><?php echo $homeData['division']['name']; ?></h3><br>
							<p><label>Key Highlights: </label></br>
							<?php echo $homeData['highlightsHtml']; ?>
							</p>
							<p><?php echo $homeData['title']; ?></p>
						</div>
					</div>
					<div class="home_price">
						<li>
							<a href="redirect_aff.php?logo=groupon&url=<?php echo $homeData['dealUrl']; ?>" class="homeLink" target="_blank">Get Deal</a>
						</li>
					</div>
				</div> 
				</div>
	        
	        <?php } ?>
			</article>
		<?php } ?>
		</div>
	</div>
</div>

<?php if($new_cat == "sports-and-outdoors"){ ?>
<script type="text/javascript" charset="utf-8">
$(function(){
	$("#hitAjaxCity").click(function(){
    var geodemo = $('#geo-demo').val();
	$.ajax({
	    url: "ajax_outdoor.php",
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
		   	$('.outdoor').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});
  	return false;    
	
	}); 
}); 
	
 </script>

 <?php } ?>

 <?php if($new_cat == "family"){ ?>

<script type="text/javascript" charset="utf-8">
$(function(){
$("#hitAjaxCity").click(function(){
var geodemo = $('#geo-demo').val();
$.ajax({
    url: "ajax_family.php",
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
	   	$('.outdoor').html(response);
	   	$("#loader").removeClass("loading");
	}
	});
	return false;    

}); 
});

  $(function(){
      
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

 <?php } ?>

 <?php if($new_cat == "sports-and-outdoors"){ ?>

   <script type="text/javascript">
   	$(function(){
      
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
 <?php } ?>

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