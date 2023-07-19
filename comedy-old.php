<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Comedy";

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
$_SESSION['country'] = $get_state_name['country_id'];
$dropdown_state = $get_state_name['code'];

$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
$get_co_name = mysql_fetch_assoc($co_name_query);
$conry_nm = $get_co_name['name'];
$state_name = $get_state_name['name'];


?>


<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
	
	<div class="v2_content_inner2">
	<div class="planTap performing-phrase">Plan a Vacation. Plan a Night Out.<br>
					Plan Smarter!</div>
		
		<div class="custom-tour-slider">
			<div class="row bxslider-deals2">
			<?php 

		    $address = rawurlencode($dropdown_city); 
			$prepAddr = str_replace(' ','+',$address);
			$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;


			$urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$address."&lat=".$latitude."&lng=".$longitude."&query=comedy&division=".$address."&locale=en_US";
			
			$result_get = file_get_contents($urlgo);
			$get_all_data = json_decode($result_get, true);
			$get_deals = $get_all_data['deals'];

			foreach ($get_deals as $homeData)
			{ ?>
				<li class="col-sm-3 col-md-3 col-xs-12">
				<div class="m_1">		 
			    	<a href="<?php echo $homeData['dealUrl']; ?>" target="_blank"><img src="<?php echo $homeData['grid4ImageUrl']; ?>"></a>
			  	</div>
				<h3 class="up"><a href="<?php echo $homeData['dealUrl']; ?>" target="_blank"><?php
				$tourname = $homeData['merchant']['name']; 
				echo $out = strlen($tourname) > 44 ? substr($tourname,0,44)."..." : $tourname;
				?></a></h3>
				<dd class="pri_ce"><?php echo $homeData['division']['name']; ?></dd>
				 </li>
			<?php } ?>
				  
			</div>	
		</div>	
<!--End-->

<aside class="sidebar v2_sidebar" style="width: 30% !important;">
	<h2 class='near_events_first_1'><?php echo $dropdown_city; ?> Comedy</h2>
	<div class="hotel-side">
	
		
		<?php
			
	    $sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM `ticket_sportsevent` WHERE `startdate` > NOW() AND (`city` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%') AND `advertisercategory` = 'THEATRE' ORDER BY startdate ASC";
			$result = mysql_query($sql);
			$nurows = mysql_num_rows($result);	        
	  		
		if($nurows > 0) {
		while($row = mysql_fetch_assoc($result)) {
	        ?>
        	<div class="home_list">
				<div class="Event_Div">
					<?php 
						$timestamp = $row['startdate']; 
						$splits =  explode(" ",$timestamp);
						
						$get_date = $splits[0];
						$orderdate = explode('-', $get_date);
						$month = $orderdate[1];
						$day   = $orderdate[2];
						$year  = $orderdate[0];
						$get_time = $splits[1];
					?>
					<div class="divEventDate">
						<div class="date_wrapper">
							<span class="month">
							<?php 
								$months = $month;
										switch ($months) {
										    case "01":
										        echo "JAN";
										        break;
										    case "02":
										        echo "FEB";
										        break;
										    case "03":
										        echo "MAR";
										        break;
										  case "04":
										        echo "APR";
										        break;
										  case "05":
										        echo "MAY";
										        break;
										  case "06":
										        echo "JUN";
										        break;
										  case "07":
										        echo "JUL";
										        break;
										  case "08":
										        echo "AUG";
										        break;
										  case "09":
										        echo "SEP";
										        break;
										  case "10":
										        echo "OCT";
										        break;
										  case "11":
										        echo "NOV";
										        break;
										  default:
										        echo "DEC";
										}
							 ?></span>
							<span class="date"><?php echo $day; ?></span>
							<span class="weekday"><?php echo $year; ?></span>
						</div>
					</div>
						<div class="new-b">	        
			        <div class="divHeader">
			        	<a href="<?php echo $row['buyurl']; ?>" target="_blank"><span class="listingEventName"><?php echo $row['name']; ?></span></a>
			        </div>

			        <div class="divVenue">
			        	<?php echo $row['keywords']; ?> </br> <?php echo $row['sport_category']; ?>
			        </div>
			        <span class="event_datetime"><?php echo $get_time; ?></span>
			        <span class="event_datetime"><?php echo $row['price']; ?></span>

			        </div>
				</div>

			</div> 	
	  		
	  <?php }
	  		} else { ?>

	    		<h1 class="record_not_found">Events not found.</h1>
	    		
	    <?php	
	    	}
				    
	?>
	</div>
	
	<?php 
		$getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE `page_name` = 'tours' ORDER BY `id` DESC LIMIT 0,4 ");
		while ($res = mysql_fetch_assoc($getAds))
		{
			echo $res['af_code'];
		?>

		<br><br>
	<?php 	}  ?>
	
</aside>			
<div id="toursFeed" class="comedy_new">
<?php
	$start = 0;
		$limit = 30;
			if(isset($_GET['page']))
			{
			$page = $_GET['page'];
			$start = ($page-1)*$limit;
			}
		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		$get_city_name = mysql_fetch_assoc($city_name_query);
		$dropdown_city = $get_city_name['city_name'];

		$start = 0;
		$limit = 30;
		$teamnm = 'comedy';
			
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM ticket_sportsevent WHERE `startdate` > NOW() AND (keywords LIKE '%$teamnm%' OR description LIKE '%$teamnm%') ORDER BY startdate ASC LIMIT $start, $limit";

		$result = mysql_query($sql);

    	while($row = mysql_fetch_assoc($result)) 
	        {  	
	        	?>
	         <div class='sports_list'>
			
					<?php if(!empty($row['imageurl'])){  ?>
					<li><img src='<?php echo $row['imageurl']; ?>'></li>
					<?php }else{ ?>
					<li><img src='images/image-coming-soon-8.png'></li>
					<?php } ?>

					<div class='hotel_data'>
						<h2><a href='<?php echo $row['buyurl'] ?>' target='_blank'><?php echo $row['name']; ?></a></h2>
						<h4 class='city_nme'><?php echo $row['city']; ?></h4><br>
						<div class='evnt_nme'>
							<span class='event_heading'>Event Name: </span>
							<h3 class='sports_name'><?php echo $row['sport_events_name']; ?></h3>
						</div>
						<div class='evnt_nme'>
							<span class='event_heading'>Date Time: </span>
							<h3 class='sports_name'><?php echo $row['startdate']; ?></h3>
						</div>
						<div class='evnt_nme'>
			
						<?php if($category_val == "concerts"){  ?>
                          <span class='event_heading'>Concert Category: </span>
						<?php }else{ ?>
                          <span class='event_heading'>Sports Category: </span>
						<?php } ?>
						<h3 class='sports_name'><?php echo $row['sport_category']; ?></h3>
						</div>
						<p><?php echo $row['description']; ?></p>
					</div>
					<div class='hotel_check'>
						<li>
							<a href='<?php echo $row['buyurl']; ?>'><?php echo $row['programname']; ?></a>
							</br>
							<span><?php echo $row['price']; ?></span>
						</li>
						<li><a href='redirect_aff.php?logo=tn&url=<?php echo $row['buyurl']; ?>' class='hotelLink' target='_blank'>Select Events</a></li>

					</div>
					</div> 

	        <	
	        	
	        
	    	<?php  } ?>			
	</div>				
					
			<script type="text/javascript" charset="utf-8">

			$(function(){
	           			$("#hitAjaxCity").click(function(){

						    var geodemo = $('#geo-demo').val();
			
							$.ajax({
							    url: "get_comedy_inside.php",
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
								   	$('.hotel-side').html(response);
								   	$('.near_events_first_1').hide();
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
							    url: "get_comedy_groupon.php",
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
								   	$('.bxslider-deals2').html(response);
								   	$("#loader").removeClass("loading");
								}
						  	});
						  	return false;    
							
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
		   
			<div id="loader"></div>
				
			<?php
							

							$total=ceil($rows/$limit);
							if($rows > 30)
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
					
				 	?>
			</div>	
</div>
<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.sidebar.v2_sidebar img{display:inline-block;float:left!important;margin:10px auto;width:100%}.hotel-side{background:#fff;padding-bottom:20px;width:100%;float:left;height:2070px;overflow-y:scroll;display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
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