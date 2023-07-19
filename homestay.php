<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Vocational Rentals"; 
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

@media(max-width:480px){
.v2_header_wrapper .bx-wrapper {
  display: none;
}

.v2_banner_top .v2_header_wrapper {
  margin-bottom: 0px;
}

.slider_body {
	display: block;  position: absolute;
}

}

.innerCurrentCity1{margin-top:0;text-align:center;width:75%}aside.sidebar{width:30%!important}.v2_content_inner2 article.oneArticle{width:66%!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.new_header_top{position:static}
.loading:before,.loading:not(:required):after{content:'';display:block}@media(max-width:991px){.v2_top_nav{position:fixed!important}}.loading,.loading:before{position:fixed;top:0;left:0}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>


<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<?php 
	 		if(isset($_GET['activity'])) {
			$get_page = $_GET['activity'];
			$page_name1 = str_replace("-", "", $get_page);
			}
	 		if ($page_name1 == 'thingstodo') {
	 			$page_name = 'family';
	 		}
			$getAds = mysql_query("SELECT * FROM `affiliate_top_ads` WHERE `page_name` = 'vacationrentals' ORDER BY `id` DESC LIMIT 1 ");
			$res = mysql_fetch_assoc($getAds);
				
			?>
			<div class = "sidebar-ads" style="width: 100%; padding: 4px;">
				<?php echo $res['af_code']; ?>
			</div>            
            
            <div class = "sidebar-ads-mobile" style="width: 100%; padding: 4px; display: none;">
            	<script type="text/javascript" language="javascript" src="//www.awltovhc.com/widget-5b037247afd6559aa2e36db7-8265264?target=_top&mouseover=Y"></script>
            </div>

          

		<div class="v2_content_inner2">
		<div class="planTap custom-homestay-plan">Plan a Vacation. Plan a Night Out.<br>
					Plan Smarter!</div>
				
			<aside class="sidebar v2_sidebar">
				<div class="hotel-side">
				
					 <div data-role="page">
					  	 
						<h2 class="near_events_first">Vacation Rentals</h2>
						<div class="cj_banner">
							
						<?php 
						$getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE `page_name` = 'Vacationrentals' ORDER BY `id` DESC LIMIT 0,4");
						while ($res = mysql_fetch_assoc($getAds))
						{
						
							echo scrap_url($res['af_code'], $res['af_name']);
						?>

						<br><br>
						<?php 	}  ?>
						</div>
						
				    	<script type="text/javascript" charset="utf-8">

				    	function changeCountry(country) {
				    		var con = country.options[country.selectedIndex].value;
				    		
					            $.ajax({
					                    type: 'POST',
					                    url: 'ajax_homestay.php',
					                    data: {changeValue: con},
					                    beforeSend: function()
									    {
									        $("#loader").addClass("loading");
									    },
						                success: function(data) {
								            $('article#atrl').html(data);
								            $("#loader").removeClass("loading");
								        }
					             });
					        
					    };
				      		$(function(){
			           			$("#hitAjax_homestay").click(function(){

			           				var geodemo = $('.formatted_geocontrast').val();
									var cin = $('#dpd1').val();
									var cout = $('#dpd2').val();
									var guid = $('#guestid').val();
									 if (geodemo == '' || cin == '' || cout == '') {
						              alert("All fields are mandatory.");
						            } else {
						            	
									$.ajax({
									    url: "homestay_search.php",
									    type: "POST",
									    data: {
									      formatted: geodemo,
									      checkin: cin,
									      checkout: cout,
									      guest: guid
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
								  	return false;    
									}
									}); 
								});
				    	</script>
					</div> 
				</div>
			</aside>
			<div id="loader"></div>

			<article id="atrl" class="oneArticle">
			<?php
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = $get_city_name['city_name'];
			

			//$url1 = "https://6df56f55f10e567550a2b39d6489d743@secure.homestaymanager.com/api/v1/partner/homestays?country_code=US";

			$prepAddr = str_replace(' ','+',$dropdown_city);
			$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;		


			$url1 = "https://6df56f55f10e567550a2b39d6489d743@secure.homestaymanager.com/api/v1/partner/homestays?latitude=".$latitude."&longitude=".$longitude."&location=".rawurlencode($dropdown_city)."&order=best_match&country_code=US&radius=50000";


	  		$result_get = file_get_contents($url1);
	        $get_all_data = json_decode($result_get, true);

	        $get_allhome = $get_all_data['data'];
	        
	        foreach ($get_allhome as $homeData) 
	        {  	
	        	?>
	        	
	        	<div class="home_list">
					<div class="home_1">
					<?php
					foreach ($homeData['pictures'] as $picture) { ?>
			        	<img src="<?php echo $picture['small_url']; ?>">
			        <?php 
			        break;
			        } ?>
				        <div class="profhome_pic">
							<img src="<?php echo $homeData['profile_picture']; ?>">
						</div>
						<div class="home_city_1"><h4 class="home_nme"><?php echo $homeData['city']; ?></h4></div>
					</div>
					<div class="home_2">
						<h2><a href="<?php echo $homeData['url']; ?>" target="_blank"><?php echo $homeData['title']; ?></a></h2>
						
						<div class="home_par">	<p><?php echo $homeData['description']; ?></p></div>
					</div>
					<div class="home_3">
						<li>
							FROM <span>$<?php echo $homeData['minimum_price_per_night']; ?></span> PER NIGHT
						</li>
					</div>
					<li>
						<a href="redirect_aff.php?logo=homestay&url=<?php echo $homeData['url']; ?>" class="home_4" target="_blank">Checkout</a>
					</li>
					
				</div> 
	        
	        <?php } ?>
			</article>
		</div>
	</div>
</div>


<script type="text/javascript">
	 $(document).ready(function(){
     $("#hitAjax_homestay").click(function(){
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
$(document).ready(function(){
	 if( $(window).width() < 640 ) {
      $(".sidebar-ads-mobile").show();
      $(".sidebar-ads").hide(); 
	 
	 }	
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