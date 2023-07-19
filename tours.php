<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Tours";

if(isset($_SESSION['user_id'])) {
	include('NewHeadeHost.php'); // login
} else {
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

<style type="text/css">
.loading:before,.loading:not(:required):after{content:'';display:block}.v2_content_inner2 article{box-shadow:none}aside::-webkit-scrollbar{width:6px}aside::-webkit-scrollbar-track{box-shadow:inset 0 0 5px grey;border-radius:10px}aside::-webkit-scrollbar-thumb{background:#1B9ED9;border-radius:6px}aside::-webkit-scrollbar-thumb:hover{background:#b30000}aside{float:left;margin-bottom:30px;margin-right:2%!important;position:relative;width:32%!important}.loading,.loading:before{position:fixed;top:0;left:0}.sidebar article{height:2220px;overflow-y:scroll}#toursFeed{width:65%}.v2_sidebar img{width:100%;padding:4px}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
	
	<div class="v2_content_inner2">
	<div class="planTap">Plan a Vacation. Plan a Night Out.<br>
					Plan Smarter!</div>
	
		<div class="custom-tour-slider cj-desktop">
			<div class="tour_affiliate">
				<?php 
				$getAds = mysql_query("SELECT * FROM `affiliate_top_ads` WHERE `page_name` = 'tours' ORDER BY `id` DESC LIMIT 1 ");
				$res = mysql_fetch_assoc($getAds);
				?>
				
				<div class = "sidebar-ads" style="width: 100%; padding: 4px;">
					<?php echo $res['af_code']; ?>
				</div>
			</div>
		</div>

		<div class="custom-tour-slider cj-mobile" style="display: none;">
			<div class="tour_affiliate">
				
				<div class = "sidebar-ads" style="width: 100%; padding: 4px;">

				<script type="text/javascript" language="javascript" src="//www.ftjcfx.com/widget-5b06252c0d79abe69e42b9fb-8265264?target=_top&mouseover=Y"></script>
					
				</div>
			</div>
		</div>		
	<aside class="sidebar v2_sidebar new-side-list">
	<div id="groupon">			

	<h2 class="near_events_first"><?php echo $dropdown_city; ?>  Tour</h2>
	<article style="width: 100% !important; padding: 4px !important;" >
	  <a href="https://mysitti.com/allgroupon-tours.php" class="tourseeall-pae" style="color: red;">See all</a>
		<?php

		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		$get_city_name = mysql_fetch_assoc($city_name_query);
		$dropdown_city = rawurlencode($get_city_name['city_name']);
       
        $address = $dropdown_city; 
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
        
        $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&division_id=".$dropdown_city."&lat=".$latitude."&lng=".$longitude."&query=Tour&division=".$dropdown_city."&locale=en_US&limit=10&campaign.currency=USD";

		$result_get = file_get_contents($urlgo);
		$get_all_data = json_decode($result_get, true);
       
		$get_deals = $get_all_data['deals'];
       
        foreach ($get_deals as $homeData)
        {   	

          if($homeData['options'][0]['price']['formattedAmount'] == $homeData['options'][0]['value']['formattedAmount']){
		
	    	}else{
			$price = $homeData['options'][0]['price']['formattedAmount'];
		    $value1 = $homeData['options'][0]['value']['formattedAmount'];
			$discount = $homeData['options'][0]['discount']['formattedAmount'];
			$save = 'Save ';
			$off = '% Off';
		    $discountPercent = $homeData['options'][0]['discountPercent'];
	    	}

	    	$endAt = 	$homeData['options'][0]['endAt'];
			$endDate = date('m/d/Y', strtotime($endAt));
        	?>
    	
    	<div class="home_list">
			<div class="home_image">
			   	<img src="<?php echo $homeData['grid4ImageUrl']; ?>" width="250" height="200">
	        </div>
			<div class="home_data">
				<h2><a href="<?php echo $homeData['dealUrl']; ?>" target="_blank"><?php echo $homeData['merchant']['name']; ?></a></h2>
				<div class='alldealset p3'>
					<h1 class='pricelanding-hotel p4 h11'><?php echo $price;?><span class='valuelanding-hotel p5 s11'><?php echo $value1;?></span></h1>
					<h1 class='saleend-hotel p6 s22'>Sales Ends: <?php echo $endDate;?></h1>
                </div>
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
					<a href="<?php echo $homeData['dealUrl']; ?>" class="homeLink" target="_blank">Get Deal</a>
				</li>
			</div>
		</div> 
    
    <?php } ?>
	</article>
</div>
</aside>

<div id="toursFeed">
<?php
	$start = 0;
		$limit = 15;
			if(isset($_GET['page']))
			{
			$page = $_GET['page'];
			$start = ($page-1)*$limit;
			}
		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		$get_city_name = mysql_fetch_assoc($city_name_query);
		$dropdown_city = $get_city_name['city_name'];
		if (empty($dropdown_city)) {

			$dropdown_city = "Memphis";
		}
			
		$sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%' OR `description` LIKE '%$dropdown_city%') LIMIT $start, $limit";
		$result = mysql_query($sql);
		$nurows = mysql_num_rows($result);
    	$rows = mysql_num_rows(mysql_query("SELECT name FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%')"));
		if(!empty($dropdown_city)) {
		if($nurows > 0) {
    	while($row = mysql_fetch_assoc($result)) {
    	?>	

    	  <div class="row tab-two">
		    <div class="col-md-5 col-sm-5 col-xs-12">
			 <div class="m_2"><a href="<?php echo $row['buyurl']; ?>" target="_blank">
			 <?php if(!empty($row['imageurl'])) { ?>
				<img src="<?php echo $row['imageurl']; ?>">
			<?php } else { ?>
				<img src="images/image-coming-soon-8.png">
			<?php } ?></a></div>
			</div>
				  <div class="col-md-7 col-sm-7 col-xs-12">
			    <h2 class="hu"><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
				<ul class="rating2">
					 <li><img src="imagesNew/star.png"></a></li>
					 <li><img src="imagesNew/star.png"></a></li>
					 <li><img src="imagesNew/star.png"></a></li>
					 <li><img src="imagesNew/star.png"></a></li>
					 <li><img src="imagesNew/star.png"></a></li>
				</ul>
				<div class="col-md-8">
				<ul class="list_f">
				  <li><?php echo $row['keywords']; ?></li>
				  <li>Duration: <?php echo $row['advertisercategory']; ?></li>
				  <li><?php echo $dropdown_city; ?></li>
				</ul>
				</div>
				<div class="col-md-4">
				  <dd class="usd">From USD</dd>
				  <dd class="pr_c">$<?php echo $row['price']; ?></dd>
				  <dd class="v_ie"><a href="<?php echo $row['buyurl']; ?>" target="_blank">View Details</a></dd>
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
			
?>			
	</div>				
					
			<script type="text/javascript" charset="utf-8">
		    	$(function(){
	           			$("#target").on('blur',function(){
						setTimeout(function(){ var geodemo = $('#target').val(); 
				      	if(geodemo.length > 0){
							if (geodemo == '') {
				              alert("Please fill city field.");
				            } else {
							$.ajax({
							    url: "toursduration.php",
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
								   	$('#toursFeed').html(response);
								   	$("#loader").removeClass("loading");
								}
						  	});
						  	return false;    
							}
						}
					},2000);
							}); 
						}); 

		  

		    </script>

		    <script type="text/javascript" charset="utf-8">
		    	$(function(){
	           			$("#target").on('blur',function(){
						setTimeout(function(){ var geodemo = $('#target').val(); 
				      	if(geodemo.length > 0){
							if (geodemo == '') {
				              alert("Please fill city field.");
				            } else {
							$.ajax({
							    url: "toursgroupon.php",
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
								   	$('#groupon').html(response);
								   	$("#loader").removeClass("loading");
								}
						  	});
						  	return false;    
							}
						}
					},2000);
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

<script type="text/javascript">
$(document).ready(function(){
	 if( $(window).width() < 640 ) {
	    
	   $(".cj-desktop").hide();
	   $(".cj-mobile").show();
	    
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