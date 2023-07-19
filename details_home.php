<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage="City Events"; 

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
						                url: 'ajax_req.php',
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
			<article id="atrl" class="oneArticle" style="width: 70% !important;">
			<?php
				//$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				// $get_city_name = mysql_fetch_assoc($city_name_query);
				// $dropdown_city = $get_city_name['city_name'];
			?>				
			<div class="search_filtering">
			<form action="hotel_all.php" method="request">
				<input name="hotel_filter" class="hotel_fil" value="" placeholder="Enter your destination" required="" type="text">
				<input name="enter_buton" class="filtering_button" type="submit">
			</form>
			</div>
			<?php
				
				if (isset($_GET['details'])) {
					
					$unique_Id = (int) $_GET['details'];
			        $url ="https://6df56f55f10e567550a2b39d6489d743@secure.homestaymanager.com/api/v1/partner/homestays?ids=".$unique_Id."";
			        $result_data = file_get_contents($url);
			        $get_all_data = json_decode($result_data, true);
			        $homevenues = $get_all_data['data'];
			       
			        foreach ($homevenues as $homevenue) 
				    {
				    	echo "<pre>";
				    	print_r($homevenue);
				    	echo "</pre>";
				    	
				    }
					die;
		
		    	    while($row = mysql_fetch_assoc($result)) {
		        
					$rows = mysql_num_rows(mysql_query("select * from hotel_data where city = ".$_REQUEST['hotel_filter'].""));
					$publisher = trim($row['city']);
					$str = trim($_REQUEST['hotel_filter']);
					if(strtolower($publisher) == strtolower($str)) 
					{ ?>
						<div class="hotel_list">
						<li><img src="<?php echo $row['imageurl']; ?>"></li>
						<div class="hotel_data">
							<h2><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
							<h4 class="city_nme"><?php echo $row['city']; ?></h4>
							<p><?php echo $row['keywords']; ?></p>
						</div>
						<div class="hotel_price">
							<li><a href="<?php echo $row['buyurl']; ?>"><?php echo $row['programname']; ?></a></br><span>$<?php echo $row['price']; ?></span></li>
						</div>
						<div class="hotel_check">
							<li>
								<a href="#"><?php echo $row['programname']; ?></a>
								</br>
								<span>$<?php echo $row['price']; ?></span>
							</li>
							<li><a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">Select Hotel</a></li>

						</div>
						</div> 
					<?php
					}
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