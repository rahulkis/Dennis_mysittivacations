<?php
//ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage = "Cheap vacation places & family vacation destinations USA "; 

if(isset($_SESSION['user_id']))

{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
	if (!empty($_GET['city'])) {
		$dropdown_city = $_GET['city'];
		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_GET['city']."'");
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
	}elseif(isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])){
		$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_SESSION['city_name']."'");
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
	}else{
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

	}
?>
<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<style type="text/css">
.innerCurrentCity1{margin-top:160px;text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}
</style>

<div class="v2_content_wrapper">
	<div id="loader"></div>
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<div class="planTap">Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>

			<div class="headingActivity-new container">
				<h2>Popular US Cities</h2>
				<a class="italicSee destination_seeall" id='us-popular-cities' data-toggle='modal' data-target='#popularcitiesModal'>See all</a>
			</div>

		 <div class="container recommed-city pcdesktop">
		
			<ul class="us-city">
				<?php
				$sql = "SELECT name, city, buyurl, imageurl FROM hotelDeal_landingPage LIMIT 0,4";
				$result = mysql_query($sql);

				while($row = mysql_fetch_assoc($result)) { 
					?>
					<li class='col-sm-6 col-md-3 col-xs-12'>
						<span class="dealscity_name"><?php echo $row['city']; ?></span>
						<a href="../redirect_aff.php?logo=tphotel&url=<?php echo $row['buyurl']; ?>" target="_blank">
							<img src="<?php echo $row['imageurl']; ?>" width="212" height="219" border="0" alt="<?php echo $row['name']; ?>"/>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>


		<div class="headingActivity-new container">
				<h2>Luxury Sandals Beach Resorts</h2>
			    <a class="italicSee destination_seeall" id='luxuary-sandle' data-toggle='modal' data-target='#myModal'>See all</a>
			</div>

		 <div class="container recommed-city">
			<div class="Asia-trip">

			<?php
				$sql = "SELECT buyurl, imageurl FROM sandals_beaches LIMIT 0,3";
				 $result = mysql_query($sql);

				while($row = mysql_fetch_assoc($result)) { ?>
				<li class="col-sm-6 col-md-4 col-xs-12">
					<div class="m_1">		 
				    	<a href="<?php echo $row['buyurl']; ?>" target="_blank">
							<img src="<?php echo $row['imageurl']; ?>" width="212" height="219" border="0" ?>
						</a>
				  	</div>
				 </li>
				<?php } ?>

		   </div>
		</div>

		<div class="headingActivity-new container">
				<h2>Asia</h2>
			    <a class="italicSee destination_seeall" id='destination-asia' data-toggle='modal' data-target='#asiaModal'>See all</a>
			</div>

		 <div class="container recommed-city">
			<div class="Asia-trip">

			<?php
				$sql = "SELECT * FROM destination_asia LIMIT 0,4";
				 $result = mysql_query($sql);

				while($row = mysql_fetch_assoc($result)) { ?>
				<div class="col-sm-6 col-md-3">
				<div class="">
					<?php echo $row['image_link']; ?>
		
				</div>
				</div>
				<?php } ?>

		   </div>
		</div>


		<div class="headingActivity-new container">
				<h2>All Inclusive</h2>
			    <a class="italicSee destination_seeall" id='all-inclusives' data-toggle='modal' data-target='#inclusivesModal'>See all</a>
			</div>

		 <div class="container recommed-city">
			<div class="All-inclisive">

			<?php
				$sql = "SELECT * FROM destination_inclusive LIMIT 0,4";
				 $result = mysql_query($sql);

				while($row = mysql_fetch_assoc($result)) { ?>
				<div class="col-sm-6 col-md-3">
				<div class="">
					<?php echo $row['image_link']; ?>
		
				</div>
				</div>
				<?php } ?>

		   </div>
		</div>

		<div class="headingActivity-new container">
				<h2>Cruises</h2>
			    <a class="italicSee destination_seeall" id='cruises' data-toggle='modal' data-target='#cruiseModal'>See all</a>
			</div>

		 <div class="container recommed-city nm">
			<div class="col-sm-6 col-md-3">
				<a href="http://www.anrdoezrs.net/click-8265264-13322255" target="_blank">
				<img src="images/cruiseImage/cruse-1.png"></a>
			</div>

			<div class="col-sm-6 col-md-3">
				<a href="http://www.dpbolvw.net/click-8265264-13322256" target="_blank">
				<img src="images/cruiseImage/cruse-2.png"></a>
			</div>

			<div class="col-sm-6 col-md-3">
				<a href="http://www.jdoqocy.com/click-8265264-13322262" target="_blank">
				<img src="images/cruiseImage/cruse-3.png"></a>
			</div>

			<div class="col-sm-6 col-md-3">
				<a href="http://www.tkqlhce.com/click-8265264-13322265" target="_blank">
				<img src="images/cruiseImage/cruse-4.png"></a>
			</div>
		</div>

		
		<div class="clear"></div>
       
		<div class="headingActivity-new container">
				<h2>Flights Deals</h2>
			    <a class="italicSee destination_seeall" id='flights-deals' data-toggle='modal' data-target='#flightdealsModal'>See all</a>
		</div>

		 <div class="container recommed-city">
		<div class="top_flight-deals">
					
			<?php
				$sql = "SELECT * FROM destination_image LIMIT 0,4";
				 $result = mysql_query($sql);

				while($row = mysql_fetch_assoc($result)) { ?>
				<div class="col-sm-6 col-md-3">
				<div class="">
					<?php echo $row['image_link']; ?>
		
				</div>
				</div>
				<?php } ?>
				</div>
		</div>

			<div class="clear"></div>
		</div>
	</div>
</div>

<!-- Us popular city End -->

  <!-- Luxary Sandals -->
<div class='modal fade' id='myModal' role='dialog'>

<div class='modal-dialog'>

  <div class='modal-content'>
    <div class='modal-header'>

    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title'></h4>
    </div>
    <div class="tuorfun">
     <ul class="modal-toour" id='destinationData'>
		
	</ul> 	 
    </div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>
  
</div>
</div>
 <!-- Luxary Sandals end -->

<!-- Modal popup for Asia -->
<div class='modal fade' id='asiaModal' role='dialog'>

<div class='modal-dialog'>

  <div class='modal-content'>
    <div class='modal-header'>

    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title'></h4>
    </div>
     <div class="Asia-trip-popup">
	<?php
		$sql = "SELECT * FROM destination_asia";
		 $result = mysql_query($sql);

		while($row = mysql_fetch_assoc($result)) { ?>
		<div class="col-sm-4">
		<div class="">
			<?php echo $row['image_link']; ?>

		</div>
		</div>
		<?php } ?>
 </div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>
  
</div>
</div>
<!-- Modal popup for Asia close -->

<!-- All exclusive -->
<div class='modal fade' id='inclusivesModal' role='dialog'>

<div class='modal-dialog'>

  <div class='modal-content'>
    <div class='modal-header'>

    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title'></h4>
    </div>

    <div class="All-inclisive-popup">
		<?php
			$sql = "SELECT * FROM destination_inclusive";
			 $result = mysql_query($sql);

			while($row = mysql_fetch_assoc($result)) { ?>
			<div class="col-sm-4">
			<div class="">
				<?php echo $row['image_link']; ?>
	
			</div>
			</div>
			<?php } ?>

		   </div>
    
    <div class='modal-footer'>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>
  
</div>
</div>
 <!-- All inclusive close -->

 <!-- All Cruise -->
 <div class='modal fade' id='cruiseModal' role='dialog'>

<div class='modal-dialog'>

  <div class='modal-content'>
    <div class='modal-header'>
    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
      
      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title'></h4>
   
    <div class="cruise-mdl">
    <div class="col-sm-4">
		<a href="http://www.anrdoezrs.net/click-8265264-13322255" target="_blank">
		<img src="images/cruiseImage/cruse-1.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.dpbolvw.net/click-8265264-13322256" target="_blank">
		<img src="images/cruiseImage/cruse-2.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.jdoqocy.com/click-8265264-13322262" target="_blank">
		<img src="images/cruiseImage/cruse-3.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.tkqlhce.com/click-8265264-13322265" target="_blank">
		<img src="images/cruiseImage/cruse-4.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.dpbolvw.net/click-8265264-13322266" target="_blank">
		<img src="images/cruiseImage/cruse-5.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.kqzyfj.com/click-8265264-13322271" target="_blank">
		<img src="images/cruiseImage/cruse-6.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.dpbolvw.net/click-8265264-13322277" target="_blank">
		<img src="images/cruiseImage/cruse-7.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.kqzyfj.com/click-8265264-13322279" target="_blank">
		<img src="images/cruiseImage/cruse-8.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.jdoqocy.com/click-8265264-13322280" target="_blank">
		<img src="images/cruiseImage/cruse-9.png"></a>
	</div>

	<div class="col-sm-4">
		<a href="http://www.dpbolvw.net/click-8265264-13322333" target="_blank">
		<img src="images/cruiseImage/cruse-10.png"></a>
	</div>
	</div> 
     
    <div class='modal-footer'>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>
   </div>
</div>
 <!-- End All cruise -->

 <!-- flight deals modal close -->

<script type="text/javascript">
$(document).ready(function(){

   $("#luxuary-sandle").click(function(){

 	$.ajax({
	    url: "ajax_luxury_sandals_beach.php",
	    type: "POST",

	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {   
	   		$('#destinationData').html(response); 
		   	$("#loader").removeClass("loading");
		}
  	});      

 });


});  

</script>

<script type="text/javascript">
$(document).ready(function(){
 if( $(window).width() < 640 ) {
  $(".pcdesktop").hide();
  $(".pcmobile").show();
  
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