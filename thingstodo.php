<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);


$titleofpage="Things To Do"; 

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

$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
$get_co_name = mysql_fetch_assoc($co_name_query);
$conry_nm = $get_co_name['name'];
$state_name = $get_state_name['name'];
?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<div class="search_filtering">
				<input id="geo-demo" type="text" class="geo" placeholder="Enter a destination" value="" data-find-address="<?php echo $dropdown_city; ?>" required>
				<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>
			<div class="col-sm-12">
			<div id="isango" class="isango_class">
				<h2 class='todo_tours'>Things to do against your search for '<?php echo $dropdown_city; ?>'</h2>
					<div class="hotel-side">
						<?php
						$start = 0;
						$limit = 12;
						if(isset($_GET['page']))
						{
						$page = $_GET['page'];
						$start = ($page-1)*$limit;
						}
						$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl FROM `isango_xmlfeed` WHERE (`country` LIKE '%$dropdown_city%' OR `city` LIKE '%$dropdown_city%' OR `name` LIKE '%$dropdown_city%') LIMIT $start, $limit";
						$result = mysql_query($sql);
						$nurows = mysql_num_rows($result);
				    	$rows = mysql_num_rows(mysql_query("SELECT name FROM `isango_xmlfeed` WHERE (`country` LIKE '%$dropdown_city%' OR `city` LIKE '%$dropdown_city%')"));
						if(!empty($dropdown_city)) {
						if($nurows > 0) {
				    	while($row = mysql_fetch_assoc($result)) {
						?>
						<div class="thingstodo_list">
							<div class="col-sm-3">
								<div class="image_class">
									<?php if(!empty($row['imageurl'])) { ?>
										<img src="<?php echo $row['imageurl']; ?>">
									<?php } else { ?>
										<img src="images/image-coming-soon-8.png">
									<?php } ?>
								</div>
								
								<div class="price_class">
									<span>$<?php echo $row['price']; ?></span>
									</br>
									<a href="<?php echo $row['buyurl']; ?>" target="_blank"><img src="images/isango-png.png" alt="isango"></a>
								</div>
								
							</div>
							<div class="col-sm-9">
								<div class="name_class">
									<h2>
										<a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a>
										</h2>
								</div>
								<div class="highlight_class">
									<label>High Light: </label>
									<p>
										<?php echo $row['keywords']; ?>
									</p>
								</div>
								<div class="desc_class">
									<label>Description: </label>
									<p>
										<?php echo $row['description']; ?>
									</p>
								</div>
								<div class="viewdetails_class">
									<a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">View Details</a>
								</div>
							</div>
						</div>
						<?php }
							} else {
								echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Tours not found.</h1>";
							}
							} else {
				  				echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Please select your location. Currently you are not share our location.</h1>";
				  			} 
						
					
				 	?>
			</div>
			
			<script type="text/javascript" charset="utf-8">
		    	


					$(function(){
	           			$("#hitAjaxCity").click(function(){
	    					$(".todo_tours").css("display", "none");

						    var geodemo = $('#geo-demo').val();
							if (geodemo == '') {
				              alert("Please fill city field.");
				            } else {
							$.ajax({
							    url: "isango_search.php",
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
								   	$('#isango').html(response);
								   	$("#loader").removeClass("loading");
								}
						  	});
						  	return false;    
							}
							}); 
						}); 

					$('.geo').geoContrast();

					

				    
		
		    	
		    </script>
		    </div>
		    </div>
			<div id="loader"></div>
		
			
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
//if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
// }
// else{
// 	include('Footer.php');
// }
 ?>