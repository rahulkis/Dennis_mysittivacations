<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage=" Sports Events"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}


if(isset($_GET['sports']))
{
	$category_val = $_GET['sports'];
?>
<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			

			 <!-- <h2>Events near Newark, NJ</h2>  -->
			<!-- <div class="filter_ticketCity">
			    
			    <input type="button" id="hitAjaxCity" class="button hotel_button" value="Search">
			     <input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> 
			</div> -->

					<!-- <div data-role="header">
				    	<h1>Filter by Category</h1>
				  	</div> -->
				  	
				  	<?php
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
						
					
		
			<script type="text/javascript" charset="utf-8">
		    // 	function getCategory(val)
		    // 		{
		    // 			var geodemo = $('#geo-demo').val();
		    // 			$.ajax({
						// type: "POST",
						// url: "ajax_category.php",
						// data:{
						// 	      category_val: val, formatted: geodemo
						// 	 },
						// beforeSend: function()
					 //    {
					 //        $("#loader").addClass("loading");
					 //    },
		    //             success: function(data) {
				  //           $('article#atrl').html(data);
				  //           $("#loader").removeClass("loading");
				  //       }
						// });
		    // 		}


					// $(function(){
	    //        			$("#hitAjaxCity").click(function(){

					// 	    var geodemo = $('#geo-demo').val();
					// 		if (geodemo == '') {
				 //              alert("Please fill city field.");
				 //            } else {
					// 		$.ajax({
					// 		    url: "get_city_inside.php",
					// 		    type: "POST",
					// 		    data: {
					// 		      formatted: geodemo
					// 		    },
					// 		    beforeSend: function()
					// 		    {
					// 		        $("#loader").addClass("loading");
					// 		    },
					// 		    success: function (response) 
					// 		    {
					// 			   	$('.hotel-side').html(response);
					// 			   	$("#loader").removeClass("loading");
					// 			}
					// 	  	});
					// 	  	return false;    
					// 		}
					// 		}); 
					// 	}); 

					// $(function(){
	    //        			$("#hitAjaxCity").click(function(){
	    //        				$(".near_events_first").css("display", "none");

					// 	    var geodemo = $('#geo-demo').val();
					// 		if (geodemo == '') {
				 //              alert("Please fill city field.");
				 //            } else {
					// 		$.ajax({
					// 		    url: "ticketSearch.php",
					// 		    type: "POST",
					// 		    data: {
					// 		      formatted: geodemo
					// 		    },
					// 		    beforeSend: function()
					// 		    {
					// 		        $("#loader").addClass("loading");
					// 		    },
					// 		    success: function (response) 
					// 		    {
					// 			   	$('article#atrl').html(response);
					// 			   	$("#loader").removeClass("loading");
					// 			}
					// 	  	});
					// 	  	return false;    
					// 		}
					// 		}); 
					// 	}); 


					$('.geo').geoContrast();

		    	
		    </script>
			<div id="loader"></div>
			<?php 
				// Your Access Key ID, as taken from the Your Account page
				$access_key_id = "AKIAJQAN4KM4OYIJI5LQ";

				// Your Secret Key corresponding to the above ID, as taken from the Your Account page
				$secret_key = "ijyb48jW7pYQhRgblos6XLPM+TA1c54tPbRuKh3t";

				// The region you are interested in
				$endpoint = "webservices.amazon.com";

				$uri = "/onca/xml";

				$params = array(
				    "Service" => "AWSECommerceService",
				    "Operation" => "ItemSearch",
				    "AWSAccessKeyId" => "AKIAJQAN4KM4OYIJI5LQ",
				    "AssociateTag" => "mysitti0b-20",
				    "SearchIndex" => "All",
				    "Keywords" => $category_val,
				    "ResponseGroup" => "Images,ItemAttributes,Offers"
				);

				// Set current timestamp if not set
				if (!isset($params["Timestamp"])) {
				    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
				}

				// Sort the parameters by key
				ksort($params);

				$pairs = array();

				foreach ($params as $key => $value) {
				    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
				}

				// Generate the canonical query
				$canonical_query_string = join("&", $pairs);

				// Generate the string to be signed
				$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

				// Generate the signature required by the Product Advertising API
				$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

				// Generate the signed URL
				$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

				$pxml = simplexml_load_file($request_url);

			?>
			<div class="container">
			<div class="planTap custom-viewsports-plan">Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>
			<div class="custom-sports-slider">
				<div class="row bxslider-deals">
				<?php foreach ($pxml->Items->Item as $value) { ?>
					<li class="col-md-4 col-sm-4 col-xs-12 b_oder">
						<div class="m_1">		 
							<a href="<?php echo $value->DetailPageURL; ?>" target="_blank"><img src="<?php 
									if($value->MediumImage->URL) {
										echo $value->MediumImage->URL;
									} else {
										echo "http://webservices.amazon.com/scratchpad/assets/images/amazon-no-image.jpg"; 
										} ?>"></a>
						</div>
					
						<div class="s_l">
							<h3 class="up"><a href="<?php echo $value->DetailPageURL; ?>" target="_blank"><?php
							$tournamelen = $value->ItemAttributes->Title; 
							echo $out = strlen($tournamelen) > 44 ? substr($tournamelen,0,44)."..." : $tournamelen;	
							 ?></a></h3>
							<h3 class="pr-i"><?php
										if($value->ItemAttributes->ListPrice->FormattedPrice)
										{
											echo $value->ItemAttributes->ListPrice->FormattedPrice;
										} else {
											echo 'N/A';
										} ?></h3>
						</div>
					</li>
							
				<?php } ?>	
				</div>	
			</div>	
			</div>
			</div>
			</div>
			<div class="headingActivity" style="margin-bottom: 20px;">
				<h2><?php echo $category_val; ?> Events</h2>
			</div>
			<aside id="asde" class="sidebar v2_sidebar">
			<!-- <h2>Events near Newark, NJ</h2>  -->
			

					<!-- <div data-role="header">
				    	<h1>Filter by Category</h1>
				  	</div> -->
				  	
				  	<?php
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
					<div class="hotel-side">
					<!-- <h2 class='near_events_first'>THEATRE near '<?php echo $dropdown_city; ?>'</h2> -->
					<div class="filter_ticketCity">
			    
					    <input type="text" name="teamName" class="team-search" value="" placeholder="Search Team">
					     <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
					</div>
					<div class="dateRange">
						<input type="text" id="dpd_team" name="checkin" value="" class="check_class hasDatepicker" placeholder="mm/dd/yyyy">
						<input type="text" id="dpdtm" name="checkout" value="" class="check_class hasDatepicker" placeholder="mm/dd/yyyy">
						<input type="submit" id="dateRangeteam" value="Browse">
					</div>

					<div class="sport-side-bar">
						<label>Tennessee</label>
						<div class="bar-block">
							<h2 class="hdg">NBA</h2>
							<ul>
								<li class="teamName">
									Memphis Grizzlies
								</li>
							</ul>
						</div>
						
						<div class="bar-block">
							<h2 class="hdg">NFL</h2>
							<ul>
								<li class="teamName">
									Tennessee Titans
								</li>
							</ul>
						</div>
						
						<div class="bar-block">
							<h2 class="hdg">NHL</h2>
							<ul>
								<li class="teamName">
									Nashville Predators
								</li>
							</ul>
						</div>

						<div class="bar-block">
							<h2 class="hdg">Colleges</h2>
							<ul>
								<li class="teamName">
									Governors / Lady Govs
								</li>
								<li class="teamName">
									Bruins
								</li>
								<li class="teamName">
									Buccaneers / Lady Buccaneers
								</li>
								<li class="teamName">
									Bisons / Lady Bisons
								</li>
								<li class="teamName">
									Tigers
								</li>
								<li class="teamName">
									Blue Raiders
								</li>
								<li class="teamName">
									Volunteers / Lady Vols
								</li>
								<li class="teamName">
									Mocs / Lady Mocs
								</li>
								<li class="teamName">
									Skyhawks
								</li>
								<li class="teamName">
									Tigers / Lady Tigers
								</li>
								<li class="teamName">
									Golden Eagles
								</li>
								<li class="teamName">
									Commodores
								</li>
							</ul>
						</div>
					</div>

				<?php

				//$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM `ticket_sportsevent` WHERE `startdate` > NOW() AND (`city` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%') AND `advertisercategory` = 'THEATRE' ORDER BY startdate ASC";
				//$result = mysql_query($sql);
				//$nurows = mysql_num_rows($result);	
															
					?>
				</div>

			</aside>
			<article id="atrl" class="oneArticle" style="width: 68% !important;">
			<?php
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = $get_city_name['city_name'];
			?>
			

			
			<?php
				
				// if(isset($_REQUEST['enter_buton'])) 
				// 	{
						
						
					// } else {
						$start = 0;
						$limit = 15;
							if(isset($_GET['page']))
							{
							$page = $_GET['page'];
							$start = ($page-1)*$limit;
							}
						if($category_val == "concerts")
						{
							$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE advertisercategory LIKE '%$category_val%' AND `startdate` > NOW() ORDER BY startdate ASC LIMIT $start, $limit";
						} else {

						$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE sport_category LIKE '%$category_val%' AND `startdate` > NOW() ORDER BY startdate ASC LIMIT $start, $limit";
						}
						$result = mysql_query($sql);
						$nurows = mysql_num_rows($result);
				    	
						if(!empty($dropdown_city)) {
						if($nurows > 0) {
				    	while($row = mysql_fetch_assoc($result)) {
						?>
							<div class="sports_list">
								<li>
									<?php if(!empty($row['imageurl'])) { ?>
									<img src="<?php echo $row['imageurl']; ?>">
								<?php } else { ?>
									<img src="images/image-coming-soon-8.png">
								<?php } ?>	
								</li>
								<div class="hotel_data">
									<h2><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
									<h4 class="city_nme"><?php echo $row['city']; ?></h4><br>
									<div class="evnt_nme">
										<span class="event_heading">Event Name: </span>
										<h3 class="sports_name"><?php echo $row['sport_events_name']; ?></h3>
									</div>
									<div class="evnt_nme">
										<span class="event_heading">Date Time: </span>
										<h3 class="sports_name"><?php echo $row['startdate']; ?></h3>
									</div>
									<div class="evnt_nme">
										<span class="event_heading">Sports Category: </span>
										<h3 class="sports_name"><?php echo $row['sport_category']; ?></h3>
									</div>
									<p><?php echo $row['description']; ?></p>
								</div>
								<div class="hotel_check">
									<li>
										<a href="<?php echo $row['buyurl']; ?>"><?php echo $row['programname']; ?></a>
										</br>
										<span>$<?php echo $row['price']; ?></span>
									</li>
									<li><a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">Select Events</a></li>

								</div>
							</div>
						<?php } 
							} else {
								echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Sports Events not found.</h1>";
							}
							} else {
				  				echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Please select your location. Currently you are not share our location.</h1>";
				  			} 
							

							$total=ceil($nurows/$limit);
							if($nurows > 15)
    						{
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
								echo "  ";
								if(!isset($_GET['page']))
								{
									$y = '1';
								}
								else
								{
									$y = $_GET['page'];
								}

								$z = '0';
								$pageNumber = (int) $_GET['page'];
								for ($x=$y;$x<=$total;$x++){
									if($z < 9)
									{
										echo "  ";
										if ($x == 1)
										{
											echo "<span class='active_range'>$x</span>";
										}
										else
										{ ?>
											<a href='?page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
						echo "</div>";
						}
					// }	
				 	?>
			</article>
		</div>
	</div>
</div>
<?php } ?>
<style type="text/css">
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
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>