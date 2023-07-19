<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage="Hotels"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<aside class="sidebar v2_sidebar">
				<div class="hotel-side">
				
					 <div data-role="page">
					  	<div data-role="header">
					    	<h1>Price Range</h1>
					  	</div>

					  	<div class="layout-slider">
					      <input id="Slider2" type="text" name="range" value="50;500" />
					    </div>

					    <div class="cj_banner" style="margin-top: 20px;">
					    <ins class="bookingaff" data-aid="1261055" data-target_aid="1259500" data-prod="banner" data-width="265" data-height="250" data-banner_id="45580" data-lang="xu">
						    <!-- Anything inside will go away once widget is loaded. -->
						    <a href="//www.booking.com?aid=1259500">Booking.com</a>
						</ins>
						<script type="text/javascript">
						    (function(d, sc, u) {
						      var s = d.createElement(sc), p = d.getElementsByTagName(sc)[0];
						      s.type = 'text/javascript';
						      s.async = true;
						      s.src = u + '?v=' + (+new Date());
						      p.parentNode.insertBefore(s,p);
						      })(document, 'script', '//aff.bstatic.com/static/affiliate_base/js/flexiproduct.js');
						</script>
					    </div>
					    <div class="cj_banner">
					    <ins class="bookingaff" data-aid="1261055" data-target_aid="1259500" data-prod="banner" data-width="265" data-height="250" data-banner_id="45581">
							    <!-- Anything inside will go away once widget is loaded. -->
							    <a href="//www.booking.com?aid=1259500">Booking.com</a>
							</ins>
							<script type="text/javascript">
							    (function(d, sc, u) {
							      var s = d.createElement(sc), p = d.getElementsByTagName(sc)[0];
							      s.type = 'text/javascript';
							      s.async = true;
							      s.src = u + '?v=' + (+new Date());
							      p.parentNode.insertBefore(s,p);
							      })(document, 'script', '//aff.bstatic.com/static/affiliate_base/js/flexiproduct.js');
							</script>
					    </div>
					    <div class="cj_banner">
					    <ins class="bookingaff" data-aid="1269748" data-target_aid="1259500" data-prod="dfl2" data-width="265" data-height="300" data-dest_id="20123619" data-dest_type="city" data-df_num_properties="3">
							    <!-- Anything inside will go away once widget is loaded. -->
							    <a href="//www.booking.com?aid=1259500">Booking.com</a>
							</ins>
							<script type="text/javascript">
							    (function(d, sc, u) {
							      var s = d.createElement(sc), p = d.getElementsByTagName(sc)[0];
							      s.type = 'text/javascript';
							      s.async = true;
							      s.src = u + '?v=' + (+new Date());
							      p.parentNode.insertBefore(s,p);
							      })(document, 'script', '//aff.bstatic.com/static/affiliate_base/js/flexiproduct.js');
							</script>
					    </div>
				    	<script type="text/javascript" charset="utf-8">
				    	//http://egorkhmelev.github.io/jslider/
				      		jQuery("#Slider2").slider({ 
				      			from: 10, 
				      			to: 1000, 
				      			heterogeneity: ['50/500'], 
				      			step: 10, 
				      			dimension: '&nbsp;$',
				      			callback: function( value ){
				      				// $("#loader").addClass("loading");
								    $.ajax({
						                type: 'POST',
						                url: 'ajax_bk.php',
						                data: {range: value},
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
			?>
			
			<div class="search_filtering">
			<form action="hotel_bk.php" method="request">
				<input name="hotel_filter" class="hotel_fil" value="" placeholder="Enter your destination" required="" type="text">
				<input name="enter_buton" class="filtering_button" type="submit">
			</form>
			</div>
			<?php
				
				if(isset($_REQUEST['enter_buton'])) 
					{
						$getValue = trim($_REQUEST['hotel_filter']);
						$start = 0;
						$limit = 15;
							if(isset($_GET['page']))
							{
							$page = $_GET['page'];
							$start = ($page-1)*$limit;
							}
							$sql = "SELECT name, address, city_hotel, maxrate, hotel_url, photo_url, desc_en FROM hotel_booking WHERE city_hotel LIKE '%$getValue%' AND maxrate > 0 LIMIT $start, $limit";
							$result = mysql_query($sql);
							$nurows = mysql_num_rows($result);
							
							$rows = mysql_num_rows(mysql_query("SELECT name FROM hotel_booking WHERE city_hotel LIKE '%$getValue%' AND maxrate > 0"));
							if($nurows > 0) {
				    	    while($row = mysql_fetch_assoc($result)) {
				        	?>
								<div class="hotel_list">
								<li><img src="<?php echo $row['photo_url']; ?>"></li>
								<div class="hotel_data">
									<h2><a href="<?php echo $row['hotel_url']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
									<h4 class="city_nme"><?php echo $row['city_hotel']; ?></h4>
									<p><?php echo $row['desc_en']; ?></p>
								</div>
								<div class="hotel_price">
									<li><a href="<?php echo $row['hotel_url']; ?>">Booking.com</a></br><span>$<?php echo $row['maxrate']; ?></span></li>
								</div>
								<div class="hotel_check">
									<li>
										<a href="http://booking.com/">Booking.com</a>
										</br>
										<span>$<?php echo $row['maxrate']; ?></span>
									</li>
									<li><a href="<?php echo $row['hotel_url']; ?>" class="hotelLink" target="_blank">Select Hotel</a></li>

								</div>
							</div>
							<?php
						}
						} else {
							echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Hotels not found.</h1>";
						}
						$total=ceil($rows/$limit);
						if($rows > 15)
    					{
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=".($page-1)."'><span>Previous</span></a>";
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
											<a href='?hotel_filter=<?php echo $getValue; ?>&enter_buton=Submit+Query&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
							echo "</div>";
						}
										
					} else {
						$start=0;
						$limit = 15;
							if(isset($_GET['page']))
							{
							$page = $_GET['page'];
							$start = ($page-1)*$limit;
							}
						$sql = "SELECT name, address, city_hotel, maxrate, hotel_url, photo_url, desc_en FROM `hotel_booking` WHERE `city_hotel` LIKE '%$dropdown_city%' AND `maxrate` > '0' LIMIT $start, $limit";
						$result = mysql_query($sql);
						$nurows = mysql_num_rows($result);
						$rows = mysql_num_rows(mysql_query("SELECT name FROM `hotel_booking` WHERE `city_hotel` LIKE '%$dropdown_city%' AND `maxrate` > '0'"));			
						if(!empty($dropdown_city)) {
						if($nurows > 0) {
				    	while($row = mysql_fetch_assoc($result)) {
				    		
						?>
							<div class="hotel_list">
								<li><img src="<?php echo $row['photo_url']; ?>"></li>
								<div class="hotel_data">
									<h2><a href="<?php echo $row['hotel_url']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
									<h4 class="city_nme"><?php echo $row['city_hotel']; ?></h4>
									<p><?php echo $row['desc_en']; ?></p>
								</div>
								<div class="hotel_price">
									<li><a href="<?php echo $row['hotel_url']; ?>">Booking.com</a></br><span>$<?php echo $row['maxrate']; ?></span></li>
								</div>
								<div class="hotel_check">
									<li>
										<a href="http://booking.com/">Booking.com</a>
										</br>
										<span>$<?php echo $row['maxrate']; ?></span>
									</li>
									<li><a href="<?php echo $row['hotel_url']; ?>" class="hotelLink" target="_blank">Select Hotel</a></li>

								</div>
							</div>
						<?php }
							} else {
								echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Hotels not found.</h1>";
							}
							} else {
				  				echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Please select your location. Currently you are not share our location.</h1>";
				  			} 
													 	
							$total=ceil($rows/$limit);
							if($rows > 15) {
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
					}

				 	?>
			</article>
		</div>
	</div>
</div>

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