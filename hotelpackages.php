<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage = "Hotels Packages"; 

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
							
			<article id="atrl" class="oneArticle" style="width:100% !important; background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important; box-shadow: none !important">

				<h2 class="deal_heading">TOP PACKAGES</h2>
				<div class="clear"></div>
				<div class="top_desti">
					<ul>
					<?php
						//$sql = "SELECT imageurl FROM hotelDeal_landingPage LIMIT 0,6";
						// $result = mysql_query($sql);

						//while($row = mysql_fetch_assoc($result)) { ?>
						<li class="col-sm-3 destination_li">
							<a href="" target="_blank"><img src="http://media.expedia.com/ads/hotels.com/merchandising/2014/us/aff images/atlanta.jpg" width="265" height="250" border="0"/></a>
							<div class="top_details">
								<div class="text_top_details">
									<h3>Memphis, TN, USA</h3>
									<span>Top packages for summer vacation...</span>
								</div>
								<a href="" target="_blank"><img src="../images/green_top.png"></a>
							</div>
						</li>

						<!-- <li class="col-sm-3 destination_li">
							<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1497539/hotels-chicago-illinois/?wapb1=deeplink" target="_blank"><img src="http://media.expedia.com/ads/hotels.com/merchandising/2014/us/aff images/chicago.jpg" width="265" height="250" border="0"/></a>
							<div class="top_details">
								<div class="text_top_details">
									<h3>Chicago, USA</h3>
									<span>Top hotel destination in Chicago</span>
								</div>
								<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1497539/hotels-chicago-illinois/?wapb1=deeplink" target="_blank"><img src="../images/green_top.png"></a>
							</div>
						</li>

						<li class="col-sm-3 destination_li">
							<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1504033/hotels-las-vegas-nevada/?wapb1=deeplink" target="_blank"><img src="http://media.expedia.com/ads/hotels.com/merchandising/2014/us/aff images/las vegas.jpg" width="265" height="250" border="0"/></a>
							<div class="top_details">
								<div class="text_top_details">
									<h3>Las Vegas, USA</h3>
									<span>Top hotel destination in Las Vegas</span>
								</div>
								<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1504033/hotels-las-vegas-nevada/?wapb1=deeplink" target="_blank"><img src="../images/green_top.png"></a>
							</div>
						</li>

						<li class="col-sm-3 destination_li">
							<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1447930/hotels-miami-beach-florida/?wapb1=deeplink" target="_blank"><img src="http://media.expedia.com/ads/hotels.com/merchandising/2014/us/aff images/miami.jpg" width="265" height="250" border="0"/></a>
							<div class="top_details">
								<div class="text_top_details">
									<h3>Miami, USA</h3>
									<span>Top hotel destination in Miami Beach</span>
								</div>
								<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1447930/hotels-miami-beach-florida/?wapb1=deeplink" target="_blank"><img src="../images/green_top.png"></a>
							</div>
						</li>

						<li class="col-sm-3 destination_li">
							<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1456744/hotels-new-orleans-louisiana/?wapb1=deeplink" target="_blank"><img src="http://media.expedia.com/ads/hotels.com/merchandising/2014/us/aff images/new orleans.jpg" width="265" height="250" border="0"/></a>
							<div class="top_details">
								<div class="text_top_details">
									<h3>New Orleans, USA</h3>
									<span>Top hotel destination in New Orleans</span>
								</div>
								<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1456744/hotels-new-orleans-louisiana/?wapb1=deeplink" target="_blank"><img src="../images/green_top.png"></a>
							</div>
						</li>

						<li class="col-sm-3 destination_li">
							<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1483250/hotels-san-diego-california/?wapb1=deeplink" target="_blank"><img src="http://media.expedia.com/ads/hotels.com/merchandising/2014/us/aff images/san diego.jpg" width="265" height="250" border="0"/></a>
							<div class="top_details">
								<div class="text_top_details">
									<h3>San Diego, USA</h3>
									<span>Top hotel destination in San Diego</span>
								</div>
								<a href="http://www.jdoqocy.com/click-8265264-10916388?sid=&url=https://www.hotels.com/de1483250/hotels-san-diego-california/?wapb1=deeplink" target="_blank"><img src="../images/green_top.png"></a>
							</div>
						</li> -->
						<?php //} ?>
					</ul>
				</div>
			
			</article>
		</div>
	</div>
</div>

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