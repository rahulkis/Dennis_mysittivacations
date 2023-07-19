<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti.com || Packages</title>
<meta name="viewport" content="width=device-width">
<link href="css/v2style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,700,700italic' rel='stylesheet' type='text/css'>

<!-- for html5 support ie8 -->

<script type="text/javascript"> 

document.createElement('header'); 
document.createElement('nav'); 
document.createElement('menu');  
document.createElement('section');  
document.createElement('article'); 
document.createElement('aside');  
document.createElement('footer'); 
jQuery(document).ready(function()
{

	jQuery('.tab1').click(function()
	{

		jQuery(this).addClass('selected');
		jQuery('.tab2').removeClass('selected');
		jQuery('.tab3').removeClass('selected');
		jQuery('.tab4').removeClass('selected');
		jQuery('#tab1').show();
		jQuery('#tab2').hide();
		jQuery('#tab3').hide();
		jQuery('#tab4').hide();
	});
	jQuery('.tab2').click(function()
	{



			jQuery(this).addClass('selected');



			jQuery('.tab1').removeClass('selected');



			jQuery('.tab3').removeClass('selected');



			jQuery('.tab4').removeClass('selected');



			jQuery('#tab2').show();



			jQuery('#tab1').hide();



			jQuery('#tab3').hide();



			jQuery('#tab4').hide();
		});

		jQuery('.tab3').click(function()

		{



				jQuery(this).addClass('selected');



			jQuery('.tab1').removeClass('selected');



				jQuery('.tab2').removeClass('selected');



					jQuery('.tab4').removeClass('selected');



						jQuery('#tab3').show();



			jQuery('#tab1').hide();



			jQuery('#tab2').hide();



			jQuery('#tab4').hide();



		})



		



		



					jQuery('.tab4').click(function()



		{



				jQuery(this).addClass('selected');



			jQuery('.tab1').removeClass('selected');



				jQuery('.tab2').removeClass('selected');



					jQuery('.tab3').removeClass('selected');



						jQuery('#tab4').show();



			jQuery('#tab1').hide();



			jQuery('#tab2').hide();



			jQuery('#tab3').hide();



		})



});											



</script>
<style>
body {
 background-attachment: scroll !important;
 background-clip: border-box !important;
 background-color: rgba(0, 0, 0, 0) !important;
 background-image: url("../images/pack.jpg") !important;
 background-origin: padding-box !important;
 background-position: center top !important;
 background-repeat: repeat !important;
 background-size: cover;
 padding-top: 0;
}
.single-frame {
 background: #00baff none repeat scroll 0 0;
 color: #000;
 float: left;
 padding: 12px 20px;
 text-align: center;
}
.multi-frame {
 background: #00baff none repeat scroll 0 0;
 color: #000;
 float: left;
 padding: 12px 20px;
 text-align: center;
}
.tabs {
 cursor: pointer;
 float: left;
 margin-bottom: 0;
 width: 100%;
}
.selected {
 background: #fecd07 none repeat scroll 0 0;
 border-bottom: 0 solid turquoise;
 color: #000;
 position: relative;
}
 .selected::after {
 border-left: 10px solid transparent;
 border-right: 10px solid transparent;
 border-top: 10px solid #fecd07;
 bottom: -10px;
 content: "";
 height: 0;
 left: 0;
 margin: auto;
 position: absolute;
 right: 0;
 width: 0;
}
.product_disc {
 border:1px solid rgba(254, 254, 254, 0.3);
 box-sizing: border-box;
 float: left;
 font-size: 13px;
 line-height: 17px;
 padding: 15px;
 width: 100%;
 color:#ccc;
 margin-bottom:20px;
}
h5 strong {
 color: #fecd07;
}
.button_signup {
 color: #fff;
 text-decoration: none;
}
#newPlansWrapper .basicPlans .highlight {
  background-color: rgba(254, 254, 254, 0.2);
  border-radius: 6px;
  box-shadow: 0 0px 12px #000;
  -webkit-box-shadow: 0 0px 12px #000;
  -ms-box-shadow: 0 0px 12px #000;
}
#newPlansWrapper .basicPlans {
   
  border-radius: 6px;
  display: table;
  float: none;
  margin: auto;
  max-width: 1200px;
  width: 100%;
}
.premium-plan-column.basic {
  float: left;
  width: 40%;border-radius: 6px;
  -webkit-border-radius: 6px;
   background-color: rgba(254, 254, 254, 0.2);
}
.premium-plan-column.pro.highlight {
  float: right;
  width: 40%;
}
#SeperatorNew {
  float: left;
  min-height: 476px;
  position: relative;
  width: 20%;
}
#SeperatorNew strong { 
  border-radius: 50%; 
  bottom: 0;
  color: #fff;
  font-size: 53px;
  font-weight: 300;
  height: 100px;
  left: 0;
  line-height: 100px;
  margin: auto;
  padding: 0;
  position: absolute;
  right: 0;
  text-align: center;
  top: 0;
  vertical-align: middle;
  width: 100px;
}

.plan-prices.margin-b20 {
  float: left;
  width: 50%; 
  position:relative;
}

.plan-prices.margin-b20.crosstext {
  float: left;
  width: 50%; 
  position:relative;
  
}
.alternate {
  float: right;
  font-size: 15px;
  line-height: 23px;
  font-weight:bold;
}
.plan-prices.margin-b20.crosstext::after {
  background: rgba(0, 0, 0, 0) url("../images/crosslabel.png") no-repeat scroll left top;
  content: "";
  height: 80px;
  left: 0;
  position: absolute;
  width: 200px;
}
 @media only screen and (min-width:768px) and (max-width: 1024px) {
  .premium-plan-column.basic, .premium-plan-column.pro.highlight { 
  width: 40%;
}
#SeperatorNew strong {
  border-radius: 0;
  float: left;
  font-size: 20px;
  height: auto;
  line-height: normal;
  min-height: auto !important;
  padding: 10px 0;
  text-align: center;
  width: 100%;
  position: static;
}
#SeperatorNew { 
  width: 20%;
}
.plan-prices.margin-b20.crosstext::after { 
  width: 100%;
  background-position: center;
}
.plan-prices.margin-b20.crosstext { 
  text-align: center;
  width: 100%;
}
.alternate { 
  width: 100%;
  text-align: center;
}
#SeperatorNew strong { 
  margin-top: 180px; 
  
}
 }
 
  @media only screen and (max-width:767px) {
#SeperatorNew {
  float: left;
  min-height: auto;
  position: relative;
  width: 100%;
}
#SeperatorNew strong {
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: #ccc -moz-use-text-color;
  border-image: none;
  border-radius: 0;
  border-style: dotted none;
  border-width: 1px 0;
  float: left;
  height: auto !important;
  position: static;
  text-align: center;
  width: 100%;
  line-height: normal;
  margin: 10px 0;
  font-size: 30px;
}
.plan-prices.margin-b20.crosstext::after { 
  width: 100%;
  background-position: center;
}
.plan-prices.margin-b20.crosstext { 
  text-align: center;
  width: 100%;
}
.alternate { 
  width: 100%;
  text-align: center;
}
  }
</style>
</head>

<body>

<!-- header starts -->

<div class="page-header">
  <div class="v2_container">
	<div class="header">
	  <div class="v2_brand_packege"> <a href="https://mysitti.com/index.php"> <img alt="" src="images/v2_logo_round.png">
		<div class="clear"></div>
		</a> </div>
	  <h1>MySitti.com</h1>
	  <h2>Making Every City Your City</h2>
	</div>
  </div>
</div>
<div id="newPlansWrapper">
  	<div class="v2_container">
		<div class="basicPlans">
	  <?php 
		$query1 = @mysql_query("SELECT * FROM `packages` WHERE package_id IN ('3','6') ");
		$j=0;
		while($package1 = @mysql_fetch_array($query1))
		{
			if ($package1['package_id'] % 2 == 0) 
			{
				$plan_class = "pro highlight";
			}
			else
			{
				$plan_class = "basic";
			}
		?>
	  		<div class="premium-plan-column <?php echo $plan_class; ?>">
				<div class="hgroup">
		  			<h2><?php echo $package1['package_name'];?></h2>
		  			<div class="trial">First Month Free</div>
			  		<h6>
						<?php if($package1['package_id'] == "3"){ echo "Starter Kit"; } ?>
						<?php if($package1['package_id'] == "4"){ echo "All the Basic PLUS"; } ?>
						<?php if($package1['package_id'] == "5"){ echo "All the Silver PLUS"; } ?>
						<?php if($package1['package_id'] == "6"){ echo "All the Basic PLUS"; } ?>
			  		</h6>
				</div>
				<div class="premium-plan-features">
		  <?php 
		  	$i =0;
			$funcquery = @mysql_query("SELECT * FROM `hostpackagefunction` ORDER BY `function_name` ASC ");
			while($fetchFunctions = mysql_fetch_array($funcquery))
			{
				$functionname = $fetchFunctions['function_name'];
				$fid = $fetchFunctions['function_id'];
				$checkquery = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '3' ");
				$res1 = @mysql_fetch_array($checkquery);
				$functionarray = explode(',', $res1['functions']);
				asort($functionarray);
				// $checkquery2 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '4' ");
				// $res2 = @mysql_fetch_array($checkquery2);
				// $functionarray2 = explode(',', $res2['functions']);
				// asort($functionarray2);
				// $checkquery3 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '5' ");
				// $res3 = @mysql_fetch_array($checkquery3);
				// $functionarray3 = explode(',', $res3['functions']);
				// asort($functionarray3);
				$checkquery4 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '6' ");
				$res4 = @mysql_fetch_array($checkquery4);
				$functionarray4 = explode(',', $res4['functions']);
				asort($functionarray4);
				$checkTest = $i % 2;
				if($checkTest == "0" )
				{
					$ulClass = "even";
				}
				else
				{
					$ulClass = "odd";
				}
	?>
		  		<ul>
			<?php
				if($package1['package_id'] == "3")
				{
					if (in_array($fid, $functionarray))
					{ 
	?>
						<li><span><?php echo $functionname; ?></span></li>
			<?php 		}
				}
				/*if($package1['package_id'] == "4")
				{
					if($functionname == "Live Streaming" || $functionname == "Storage")
					{
						if($functionname == "Live Streaming")
						{ 
	?>
							<li><span><?php echo "Live Streaming For 1 hr"; ?></span></li>
			<?php 			}
						if($functionname == "Storage")
						{ 
	?>
							<li><span><?php echo "Storage 20 GB"; ?></span></li>
			<?php 			}
					}
					else
					{
						if(in_array($fid, $functionarray))
						{
						}
						elseif (in_array($fid, $functionarray2))
						{
							if($functionname == "Live Streaming")
							{ 
		?>
								<li><span><?php echo "Live Streaming For 1 hr"; ?></span></li>
			<?php 				}
							else
							{ 
		?>
								<li><span><?php echo $functionname; ?></span></li>
			<?php 				}
						}
					}
				}
				if($package1['package_id'] == "5")
				{
					if($functionname == "Live Streaming" || $functionname == "Storage")
					{
						if($functionname == "Live Streaming")
						{ 
	?>
							<li><span><?php echo "Live Streaming For 2 hrs"; ?></span></li>
		<?php 				}
						if($functionname == "Storage")
						{ 
	?>
							<li><span><?php echo "Storage 50 GB"; ?></span></li>
		<?php 				}
					}
					else
					{
						if(in_array($fid, $functionarray2))
						{
						}
						elseif (in_array($fid, $functionarray3))
						{ 
	?>
							<li><span><?php echo $functionname; ?></span></li>
			<?php 			}
					}
				}*/
				if($package1['package_id'] == "6")
				{
					if($functionname == "Live Streaming" || $functionname == "Storage")
					{
						if($functionname == "Live Streaming")
						{ 
	?>
							<li><span><?php echo "Live Streaming For 4 hrs"; ?></span></li>
			<?php 			}
						if($functionname == "Storage")
						{ 
	?>
							<li><span><?php echo "Storage 100 GB"; ?></span></li>
			<?php 			}
					}
					else
					{
						if(in_array($fid, $functionarray))
						{
						}
						elseif (in_array($fid, $functionarray4))
						{ 
	?>
							<li><span><?php echo $functionname; ?></span></li>
			<?php 			}
					}
				}
?>
		  		</ul>
		  <?php
	  		$i++;
			} // ENDWHILE
?>
		  
		  <!--<ul>







			<li><span>Unlimited Live Streams</span></li>







			<li><span>Live Stream Recording</span></li>







			<li><span>In-Stream Tipjar</span></li>







			<li><span>Basic Video Themes</span></li>







			<li><span>1 GB of Storage</span></li>







		  </ul>--> 
		  
		</div>
		<div class="premium-plan-cta">
		  <div class="plan-prices margin-b20 <?php if($package1['package_id'] == '6'){ echo 'crosstext'; }?>"> 
			
			<!--<h4>Free</h4>-->
			
			<h5> <em>
			  <?php if($package1['package_id'] != "3"){ ?>
			  <?php } ?>
			  <?php if($package1['amount'] == "Free"){ echo "(".$package1['amount'].")";}else{ echo "$".$package1['amount']; }?>
			  </em>
			  <?php if($package1['package_id'] != "3"){ ?>
			  <span> / Month</span>
			  <?php }	?>
			</h5>
			<?php 		if($package1['package_id'] != "3")







											{	?>
			<h5 class="strong"><strong>OR</strong></h5>
			<h5>
			  <div class="annual_p"> 
				
				<!--<i>$<?php //echo $package1['annually']; ?></i>







														<span>with annual plan</span>--> 
				
			  </div>
			  <div class="save_p"> <b>$<?php echo $package1['annual_monthly'] ?></b> <i> / Month</i> <span>with annual plan</span> </div>
			</h5>
			<?php }	?>
		  </div><!-- END plan-prices margin-b20  -->
		  <?php 
			if($package1['package_id'] == '6')
			{
		?>		<div class="alternate">
					"New Website Startup Price"<br />
					<strong style="color:#fecd07;">FREE</strong><br />
					for first 1000 users!
				</div>
		  <?php 
		  	}

			if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "club")
			{
				$getplanType = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
				$getPlan = mysql_fetch_assoc($getplanType);
				$VALUE = '';
				if($getPlan['plantype'] == 'host_free')
				{
					?>
		  <div class="premium-plan-cta-button">
			<h6 class="no-margin ">
			  <?php if($package1['package_id']  == 3){ ?>
			  <a href="javascript: void(0)" class="account-pro">Already Purchased</a>
			  <?php } /*?>
			  <?php if($package1['package_id']  == 4){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_silver" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 5){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_gold" class="account-pro">Upgrade Now</a>
			  <?php }*/ ?>
			  <?php if($package1['package_id']  == 6){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_platinum" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			</h6>
		  </div>
		  <?php
				}
				elseif($getPlan['plantype'] == 'host_silver')
				{
					?>
		  <div class="premium-plan-cta-button">
			<h6 class="no-margin ">
			  <?php if($package1['package_id']  == 3){ ?>
			  <a href="javascript: void(0)" class="account-pro">Free</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 4){ ?>
			  <a href="javascript:void(0);" class="account-pro">Already Purchased</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 5){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_gold" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 6){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_platinum" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			</h6>
		  </div>
		  <?php 
				}
				elseif($getPlan['plantype'] == 'host_gold')
				{
					?>
		  <div class="premium-plan-cta-button">
			<h6 class="no-margin ">
			  <?php if($package1['package_id']  == 3){ ?>
			  <a href="javascript: void(0)" class="account-pro">Free</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 4){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_silver" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 5){ ?>
			  <a href="javascript:void(0);" class="account-pro">Already Purchased</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 6){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_platinum" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			</h6>
		  </div>
		  <?php 
				}
				elseif($getPlan['plantype'] == 'host_platinum')
				{
					?>
		  <div class="premium-plan-cta-button">
			<h6 class="no-margin ">
			  <?php if($package1['package_id']  == 3){ ?>
			  <a href="javascript: void(0)" class="account-pro">Free</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 4){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_silver" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 5){ ?>
			  <a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_gold" class="account-pro">Upgrade Now</a>
			  <?php } ?>
			  <?php if($package1['package_id']  == 6){ ?>
			  <a href="javascript:void(0);" class="account-pro">Already Purchased</a>
			  <?php } ?>
			</h6>
		  </div>
		  <?php 
				}


							?>
		  <?php 	}	?>
		  
		  <!--<div class="premium-plan-cta-button">







			<h6 class="no-margin currentPlan">Current Plan ›</h6>







		  </div>--> 
		  
		</div>
	  </div>
	   <?php
		  		if($j == 0)
		  		{
		  			?>
		  					<div id="SeperatorNew">
		  						<strong>OR</strong>
		  					</div>
	  <?php 		}
	  		$j++;
	  		}
	   ?>
	</div>
  </div>
</div>
<div id="newPlansWrapper">
  <div class="v2_container">
	<div class="featuredTabs"> Featured Details 
	  
	  <!--div class="multi-frame">Plan Comparison</div --> 
	  
	</div>
	<?php

function seoUrl($string) {

	//Lower case everything

	$string = strtolower($string);

	//Make alphanumeric (removes all other characters)

	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

	//Clean up multiple dashes or whitespaces

	$string = preg_replace("/[\s-]+/", " ", $string);

	//Convert whitespaces and underscore to dash

	$string = preg_replace("/[\s_]/", "-", $string);

	return $string;

}


$funcquery1 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` IN ('3','6') ORDER BY `package_id` ASC ");

?>
	<div class="tab-nav">
	<?php
	$sm = 1;
	while($packageResult = mysql_fetch_assoc($funcquery1))
	{
	?>
	  	<div class="tab<?php echo $sm; if($sm == 1){ echo ' selected';}?> "><?php echo $packageResult['package_name'];?></div>
	  	<!-- <div class="tab2">Silver</div>
	  	<div class="tab3">Gold</div> -->
	  	<!-- <div class="tab2">Platinum</div> -->
<?php 	$sm++;
	}	?>
	</div>
	<?php

$package_array = array('3','6');

$i = 1;

foreach($package_array as $single_package_array){ ?>
	<div id="tab<?php echo $i ?>" class="product_disc" style="display: <?php if($i == 1){ echo "block"; }else{ echo "none"; } ?>">
	  <?php

// if($single_package_array == 3){ $head_text = "Starter Kit "; }

// // if($single_package_array == 4){ $head_text = "All the Basic PLUS "; }

// // if($single_package_array == 5){ $head_text = "All the Silver PLUS "; }

// if($single_package_array == 6){ $head_text = "All the Basic PLUS "; }

?>
	  <h1><?php echo $head_text; ?></h1>
	  <ul>
		<?php			

$funcquery = @mysql_query("SELECT * FROM `hostpackagefunction` ORDER BY `function_name` ASC ");

while($fetchFunctions = mysql_fetch_array($funcquery))

{

			$functionname = $fetchFunctions['function_name'];
			$host_package_description = $fetchFunctions['host_package_description'];
			
			if(empty($host_package_description)){
			
				$package_description = "";
			
			}else{
			
				$package_description = $host_package_description;
			
			}
			
			$fid = $fetchFunctions['function_id'];



			$checkquery = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '3' ");

			$res1 = @mysql_fetch_array($checkquery);

			$functionarray = explode(',', $res1['functions']);

			asort($functionarray);



			

			// $checkquery2 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '4' ");

			// $res2 = @mysql_fetch_array($checkquery2);

			// $functionarray2 = explode(',', $res2['functions']);

			// asort($functionarray2);



			

			// $checkquery3 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '5' ");

			// $res3 = @mysql_fetch_array($checkquery3);

			// $functionarray3 = explode(',', $res3['functions']);

			// asort($functionarray3);





			$checkquery4 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '6' ");

			$res4 = @mysql_fetch_array($checkquery4);

			$functionarray4 = explode(',', $res4['functions']);

			asort($functionarray4); 


//echo "<pre>"; print_r($functionarray); print_r($functionarray4); exit;


			if($single_package_array == '3' && in_array($fid, $functionarray) )
			{ 
				if($functionname == "Storage")
				{ 
?>
					<li>
					  <div class="icon_pack"> <img alt="" src="../images/packege_icons/<?php echo seoUrl($functionname); ?>.png"> </div>
					  <div class="pacinfo">
						<h2><?php echo $functionname; ?></h2>
						<div class="clear"></div>
						<p><?php echo "Storage 5 GB"; ?></p>
					  </div>
					</li>
<?php 				}
				else
				{ 
?>
					<li>
					  <div class="icon_pack"> <img alt="" src="../images/packege_icons/<?php echo seoUrl($functionname); ?>.png"> </div>
					  <div class="pacinfo">
						<h2><?php echo $functionname; ?></h2>
						<div class="clear"></div>
						<p><?php echo $package_description; ?></p>
					  </div>
					</li>
					<?php 
				} 
			}

								
			if($single_package_array == 6)
			{
				if($functionname == "Live Streaming" || $functionname == "Storage")
				{
					if($functionname == "Live Streaming")
					{ 
?>
						<li>
		  					<div class="icon_pack"> <img alt="" src="../images/packege_icons/<?php echo seoUrl($functionname); ?>.png"> </div>
							<div class="pacinfo">
								<h2><?php echo $functionname; ?></h2>
								<div class="clear"></div>
								<p><?php echo "Live Streaming For 4 hrs"; ?></p>
							</div>
						</li>
		<?php 			}
					if($functionname == "Storage")
					{ 
		?>
						<li>
						  	<div class="icon_pack"> <img alt="" src="../images/packege_icons/<?php echo seoUrl($functionname); ?>.png"> </div>
					  		<div class="pacinfo">
								<h2><?php echo $functionname; ?></h2>
								<div class="clear"></div>
								<p><?php echo "Storage 100 GB"; ?></p>
						  	</div>
						</li>
		<?php 			}
				}
				else
				{
					if(in_array($fid, $functionarray4))
					{
						if($functionname == "Live Streaming")
						{ 
		?>
							<li>
							  <div class="icon_pack"> <img alt="" src="../images/packege_icons/<?php echo seoUrl($functionname); ?>.png"> </div>
							  <div class="pacinfo">
								<h2><?php echo $functionname; ?></h2>
								<div class="clear"></div>
								<p><?php echo "Live Streaming For 4 hrs"; ?></p>
							  </div>
							</li>
		<?php 				}
						else
						{ 
	?>
							<li>
							  <div class="icon_pack"> <img alt="" src="../images/packege_icons/<?php echo seoUrl($functionname); ?>.png"> </div>
							  <div class="pacinfo">
								<h2><?php echo $functionname; ?></h2>
								<div class="clear"></div>
								<p><?php echo $package_description; ?></p>
							  </div>
							</li>
		<?php 				} 
					}
				}
			}
			$inc++; 
		} 
?>
	  </ul>
	</div>
	<?php $i++; } ?>
  </div>
</div>
