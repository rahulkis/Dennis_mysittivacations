<?php
// phpinfo();
// die;
//ini_set("display_errors", "1");error_reporting(E_ALL);
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);


$titleofpage=" City Events";

if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}

if(isset($_SESSION['user_id']))
{
	$sql_city_id = mysql_query("select * from clubs where id='".$_SESSION['user_id']."'");

	$city_id2 = mysql_fetch_assoc($sql_city_id);
}
else
{

	$city_id2 = array();

	$city_id2['zipcode']='38125';

}

if(isset($_SESSION['clubs_filter']))

{

	$club_filter=$_SESSION['clubs_filter'];

	unset($_SESSION['clubs_filter']);

	$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";

}
else

{

	$cnd=" parrent_id='0'";

}

if($_SESSION['miles'])

{

	$miles_filter=$_SESSION['miles'];

	unset($_SESSION['miles']);

}



$sql_main_club=mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");

if(isset($_GET['code']) && isset($_GET['state']))
{
	$_SESSION['FBRLH_state'] = $_GET['state'];
}


if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<script language="javascript">


$(document).ready(function(){
	$( "#get_destination" ).keypress(function() {
		var urldes = '<?php echo $SiteURL;?>';
		var URLDES = urldes+'refreshajax.php?getaction=fetchdestinations';
		
		$('#get_destination').autocomplete(URLDES);
		// return false;
	});

});

function goto(url)

{

	window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=200');

	return false;

}

function goto1(url)

{

	window.open(url,'1396358792239','width=900,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=0');

	return false;

}

function changecity()

{

	var val=$('#city_name').val();

	$.get('set-session.php?city_id='+val, function(data) {

		window.location='searchEvents.php';

	});

}



</script>
<link rel="stylesheet" href="../css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#datetimepicker2').datetimepicker({
	  timepicker:false,
	  format:'m/d/Y'
	});
	$('#datetimepicker3').datetimepicker({
	  timepicker:false,
	  format:'m/d/Y'
	});

	$('#my_input').datetimepicker({
	  timepicker:false,
	  format:'m/d/Y'
	});
			
});
 
</script>

<script type="text/javascript">

 	$(document).ready(function() {
      $("#target").on('blur',function(){
		setTimeout(function(){ var geodemo = $('#target').val(); 
      	if(geodemo.length > 0){

	    $.ajax({
			    url: "ajax-handpick-restrnt.php",
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
				   	$('.activiteis_bx').html(response);
				   	$("#loader").removeClass("loading");
				}
		  });

		$.ajax({
		    url: "ajax_landingpage.php",
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
			   	$('.bxslider_food').html(response);
			   	$("#loader").removeClass("loading");
			}
	  	});
	  	return false;    
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

<script type="text/javascript">
$(window).load(function(){
  var geodemo = $('#geo-demo1').val();

    $.ajax({
	    url: "ajax-handpick-restrnt.php",
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
		   	$('.activiteis_bx').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});

	$.ajax({
	    url: "ajax_landingpage.php",
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
		   	$('.hotelsDeals_food').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});
  	return false;
});	

</script>

<script type="text/javascript">

	$(document).ready( function() {

		$('html, body').animate({

			scrollTop: $(".localBusiness").offset().top - 40

		}, 1000);

	});

</script>

<style type="text/css">
#hitAjaxCity1{float:right;position:absolute;right:0;top:0;width:70px!important}.citytalk_page .innerCurrentCity1{top:0}.home-page-c p{color:#fff;font-size:28px;font-weight:700;line-height:38px;margin:15px auto;text-align:center;width:70%}.v2_banner_top1 ul.new_height{height:460px!important;overflow:hidden}.bx-viewport{height:auto!important}.home-page-c{width:100%}.text-center{left:0;position:absolute;right:0;text-align:center;top:110px}.loading{position:fixed;z-index:999;height:2em;width:2em;overflow:show;margin:auto;top:0;left:0;bottom:0;right:0}.loading:before{content:'';display:block;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{content:'';display:block;font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1500ms infinite linear;-moz-animation:spinner 1500ms infinite linear;-ms-animation:spinner 1500ms infinite linear;-o-animation:spinner 1500ms infinite linear;animation:spinner 1500ms infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}
</style>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="text-center home-page-c">
                      
                       <p>
                      Plan a Vacation. Plan a Night Out. <br> Plan Smarter!
                       </p>
                  			
                    </div>
		<div class="topSilder"  style="display:none;">
  			<div class="fullblack">
				<div class="img_slider_btm">
	  				<div class=" ">			
	  				</div>
				</div>
  			</div>
		</div><!-- END topSilder -->
<?php
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


	<div class="v2_content_inner2 new_designCate">

	       <div id="loader"></div>
		<div class="clear"></div>
					

		<div class="emp"></div>
		<div class="headingActivity-new">
			<h2>Local Music</h2>
	
		</div>
		<div class="container recommed-city">
					
			<ul class="local_music">
			<?php 
			$rows = mysql_num_rows(mysql_query("SELECT id FROM `clubs` WHERE `type_details_of_club` LIKE '%Rock%' AND `club_city` = '$_SESSION[id]'"));
			if($rows > 0) {
			?>
				<li class="col-sm-3 city-recom">
					<a href="genre-rock.php"><img src="images/local-music4.jpg"></a>
					<span>Rock</span>
				</li>
			<?php } else { ?>
				<li class="col-sm-3 city-recom">
					<a href="genre-rock.php"><img src="images/local-music4.jpg"></a>
					<span>Rock</span>
				</li>
			<?php } ?>

			<?php 
			$rows = mysql_num_rows(mysql_query("SELECT id FROM `clubs` WHERE `type_details_of_club` LIKE '%Blues%' AND `club_city` = '$_SESSION[id]'"));
			if($rows > 0) {
			?>
				<li class="col-sm-3 city-recom">
					<a href="genre-blues.php"><img src="images/local-music3.jpg"></a>
					<span>Blues</span>
				</li>
				<?php } else { ?>
				<li class="col-sm-3 city-recom">
					<a href="genre-blues.php"><img src="images/local-music3.jpg"></a>
					<span>Blues</span>
				</li>
			<?php } ?>


			<?php 
			$rows = mysql_num_rows(mysql_query("SELECT id FROM `clubs` WHERE `type_details_of_club` LIKE '%Country%' AND `club_city` = '$_SESSION[id]'"));
			if($rows > 0) {
			?>
				<li class="col-sm-3 city-recom">
					<a href="genre-country.php"><img src="images/local-music1.jpg"></a>
					<span>Country</span>
				</li>
			<?php } else { ?>
				<li class="col-sm-3 city-recom">
					<a href="genre-country.php"><img src="images/local-music1.jpg"></a>
					<span>Country</span>
				</li>
			<?php } ?>

			<?php 
			$rows = mysql_num_rows(mysql_query("SELECT id FROM `clubs` WHERE `type_details_of_club` LIKE '%Jazz%' AND `club_city` = '$_SESSION[id]'"));
			if($rows > 0) {
			?>
				<li class="col-sm-3 city-recom">
					<a href="genre-jazz.php"><img src="images/local-music2.jpg"></a>
					<span>Jazz</span>
				</li>
			<?php } else { ?>
				<li class="col-sm-3 city-recom">
					<a href="genre-jazz.php"><img src="images/local-music2.jpg"></a>
					<span>Jazz</span>
				</li>
			<?php } ?>

			<li class="col-sm-3 city-recom">
				<a href="concert.php"><img src="imagesNew/concert.png"></a>
				<span>Concert</span>
			</li>
				
		</ul>
		</div>	

		<div class="headingActivity-new">
			<h2>Activities</h2>
			<a href="allSports.php" class="italicSee">See all</a>
		</div>
		<div class="container recommed-city">
		<ul class="activiteis_bx_seac">

			<li class="col-sm-3 city-recom">
				<a href="allSports.php"><img src="imagesNew/basketball.jpg"></a>
				<span>Sports</span>
			</li>

			<li class="col-sm-3 city-recom">
				<a href="family.php"><img src="images/fimaly.png"></a>
				<span>Family</span>
			</li>

			<li class="col-sm-3 city-recom">
				<a href="performing-arts.php"><img src="imagesNew/perform-arts.jpg"></a>
				<span>Performing Arts</span>
			</li>

			<li class="col-sm-3 city-recom">
				<a href="brewery.php"><img src="imagesNew/brewery.png"></a>
				<span>Winery/Brewery</span>
			</li>

			<li class="col-sm-3 city-recom">
				<a href="comedy.php"><img src="imagesNew/comedy.png"></a>
				<span>Comedy</span>
			</li>

			
		</ul>
		</div>


		<div class="headingActivity-new">
			<h2>Handpicked Restaurants</h2>
			<p><img src="https://mysitti.com/images/Zomato-Logo.jpg"></p>
			<a href="handpicked-restaurant.php" class="italicSee">See all</a>
		</div>
		<div class="container recommed-city">
		<ul class="activiteis_bx">


		</ul>
		</div>


		<div class="headingActivity-new">
				<h2>Hotels Deals</h2>
				<a href="https://mysitti.com/allhoteldeals.php" class="italicSee">See all</a>
			</div>

			<div class="container recommed-city">
		
				<ul class="hotelsDeals_food">
				
				</ul>
			</div>
	<?php
		//include('hotSpotsSidebar.php');
	?>


</div>
<div id="fullOverlay"></div>

<?php $activity = (isset($_GET['activity']) ? $_GET['activity'] : 0);
			
if($activity == 1) { ?>
	<script type="text/javascript">
		$(".active_access").show();
		$("#title").hide();
		$(".v2_blog_post").css("display", "none", "important");
	</script>
<?php } ?>



<?php 

	include('LandingPageFooter.php');

 ?>