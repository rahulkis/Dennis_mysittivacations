<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Hotels"; 

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

<div class="deal_menu">
	<ul>
		<li id="hotel_deal">HOTELS DEALS</li>
		<li id="flight_deal">FLIGHTS</li>
		<li id="ticket_deal">TICKETS</li>
		<a href="dealspage.php"><li id="all_deal">ALL DEALS</li></a>
		<li><form action="dealspage.php" method="post" style="margin: 0px;"><input type="search" class="dealTextbox" name="dealsearch" required><input type="submit" class="dealTextSubmit" name="dealsubmit" value=""></form></li>
	</ul>
</div>
<script type="text/javascript">
	$(".deal_menu li").click(function () {
	    $(".deal_menu li").removeClass("active_deal_menu");
	    $(this).addClass("active_deal_menu");        
	});

	$(function(){
	$("#hotel_deal").click(function() {

	    var con = "hotel";
            $.ajax({
                type: 'POST',
                url: 'get_deal.php',
                data: {dealValue: con},
                beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
                success: function(data) {
		            $('article#atrl').html(data);
		            $("#loader").removeClass("loading");
		        }
                });
            });
	    });
	$(function(){
	$("#flight_deal").click(function() {
	    var con = "flight";
            $.ajax({
                type: 'POST',
                url: 'get_deal.php',
                data: {dealValue: con},
                beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
                success: function(data) {
		            $('article#atrl').html(data);
		            $("#loader").removeClass("loading");
		        }
                });
            });
	    });
	$(function(){
	$("#ticket_deal").click(function() {
	    var con = "ticket";
            $.ajax({
                type: 'POST',
                url: 'get_deal.php',
                data: {dealValue: con},
                beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
                success: function(data) {
		            $('article#atrl').html(data);
		            $("#loader").removeClass("loading");
		        }
            });
        });
    });
	
</script>
<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<div id="loader"></div>
			<article id="atrl" class="oneArticle" style="width:100% !important; background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important; box-shadow: none !important">
				<?php 
				if(isset($_POST['dealsubmit']))
				{
					$cleanStr = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $_POST['dealsearch'])));
					echo "<h2 class='deal_heading'>Deals matching `".$cleanStr."`</h2>";
					$arr = explode(" ",$cleanStr);
					$uniqueArr = array();
					foreach ($arr as $key => $value)
					{
						$getDeals = mysql_query("SELECT * FROM `deals` WHERE deal_text LIKE '%".$value."%'");
						while ($res = mysql_fetch_assoc($getDeals)) 
						{ 
							$uniqueArr[] = $res;
						} 
					}

					if(!empty($uniqueArr))
					{
						$unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueArr)));
						foreach ($unique as $key => $value) 
							{ ?>
							<div class="col-sm-3 city-recom">
								<?php echo $value['deal_code'];?>
								<div class="deal_text"><?php echo $value['deal_text']; ?></div>
							</div>
						<?php }
					} else {
						echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Deals not found.</h1>";
					}
					
				} else { ?>
				<h2 class="deal_heading">HOTELS DEALS</h2>

				<?php 
					$getDeals = mysql_query("SELECT * FROM `deals` WHERE `status` = 1 AND deal_name = 'hotel'");
					while ($res = mysql_fetch_assoc($getDeals))
					{
				?>
				<div class="col-sm-3 city-recom">
					<?php echo $res['deal_code'];?>
					<div class="deal_text"><?php echo $res['deal_text']; ?></div>
				</div>
						
				<?php 	} ?>
        <div class="clearfix"></div>
        <h2 class="deal_heading">FLIGHTS DEALS</h2>

        <?php 
          $getDeals = mysql_query("SELECT * FROM `deals` WHERE `status` = 1 AND deal_name = 'flight'");
          while ($res = mysql_fetch_assoc($getDeals))
          {
        ?>
        <div class="col-sm-3 city-recom">
          <?php echo $res['deal_code'];?>
          <div class="deal_text"><?php echo $res['deal_text']; ?></div>
        </div>
            
        <?php   } ?>
        <div class="clearfix"></div>
        <h2 class="deal_heading">TICKETS DEALS</h2>

        <?php 
          $getDeals = mysql_query("SELECT * FROM `deals` WHERE `status` = 1 AND deal_name = 'ticket'");
          while ($res = mysql_fetch_assoc($getDeals))
          {
        ?>
        <div class="col-sm-3 city-recom">
          <?php echo $res['deal_code'];?>
          <div class="deal_text"><?php echo $res['deal_text']; ?></div>
        </div>
            
        <?php   }

				} ?>

			</article>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
	  $('.city-recom a').attr('target', '_blank');
	});
</script>
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