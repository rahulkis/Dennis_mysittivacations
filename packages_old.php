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
</script>
</head>
<body>

<!-- header starts -->
<style type="text/css">
h2.title_plan::before {
    background: #fecd07 none repeat scroll 0 0;
    bottom: -17px;
    content: "";
    height: 39px;
    margin: auto;
    position: absolute;
    right: -30px;
    width: 52px;
    z-index: -1;
}
h2.title_plan::after {
    background: #fecd07 none repeat scroll 0 0;
    bottom: -17px;
    content: "";
    height: 39px;
    left: -30px;
    margin: auto;
    position: absolute;
    width: 52px;
    z-index: -1;
}
h2.title_plan {
    color: #fff;
    margin: 30px auto 60px;
    max-width: 600px;
    position: relative;
    text-transform: uppercase;
    width: 100%;
    z-index: 999;
}
h2.title_plan span {
  background: #fecd07 none repeat scroll 0 0;
  box-shadow: 0 2px 3px #2b0909;
  color: #000;
  display: block;
  font-size: 28px;
  padding: 5px 0;
  text-align: center;
  width: 100%;
  z-index: 999;
}
.userplan_container {
  background: #fff none repeat scroll 0 0;
  border-radius: 6px;
  margin: 20px auto;
  max-width: 1080px;
  width: 100%;
}
.inner_plan {
  box-sizing: border-box;
  padding: 5px;
  width: 100%;
}
.listing_plans {
  box-sizing: border-box;
  float: left;
  font-family: arial;
  padding: 5px;
  width: 100%;
}
.plans {
  float: left;
  width: 20%;
}
.pricing {
  background: #fecd07 none repeat scroll 0 0;
  border-left: 5px solid #fff;
  box-sizing: border-box;
  float: left;
  height: 185px;
  width: 20%;
}
.head_plan {
  background: #1fa7cb none repeat scroll 0 0;
  float: left;
  height: 165px;
  padding: 10px 0;
  text-align: center;
  width: 100%;
}
.head_plan img {
  max-width: 100%;
  height: 100%;
}
.pricing .head_basic {
  background: rgba(0, 0, 0, 0) url("images/basic_bg.jpg") no-repeat scroll left top / 100% auto;
  float: left;
  height: 85px;
  position: relative;
  width: 100%;
}
.pricing h3 {
  color: #fff;
  float: right;
  font-size: 25px;
  font-weight: bold;
  line-height: normal;
  padding-right: 15px;
  padding-top: 47px;
  text-align: right;
  text-transform: uppercase;
  width: 100%;
}
.plans + .pricing .head_basic h3 {
  margin-top: 0;
  padding-right: 0;
  padding-top: 24px;
  text-align: center;
}
.intro_rate {
  float: left;
  font-family: Arial,Helvetica,sans-serif;
  height: 100px;
  position: relative;
  width: 100%;
}
.plans + .pricing .intro_rate h4 {
  border: 0 none;
  font-family: Arial,Helvetica,sans-serif;
  line-height: 100px;
  margin-top: 0;
  padding-left: 0;
  padding-right: 0;
  text-align: center;
  text-transform: uppercase;
}

.pricing h4 {
  border-bottom: 1px solid #e0af00;
  box-sizing: border-box;
  color: #000;
  float: left;
  font-size: 18px;
  font-weight: bold;
  height: 40px;
  line-height: 40px;
  padding-left: 0;
  position: relative;
  text-align: center;
  width: 100%;
}
.intro_rate h4 em, .save_p b {
  color: #e21f27;
  font-size: 20px;
  font-style: normal;
}
.listing_plans ul {
  display: table;
  width: 100%;
}
.even li:first-child {
  background: #fff none repeat scroll 0 0 !important;
  border-left: 0 none;
  color: #000 !important;
}
.listing_plans li {
  background: #d9d9d9 none repeat scroll 0 0;
  border-bottom: 5px solid #fff;
  border-left: 5px solid #fff;
  box-sizing: border-box;
  display: table-cell;
  font-weight: bold;
  padding: 10px 3px;
  text-align: center;
  vertical-align: middle;
  width: 20%;
  color: #000;
}

.even li {
  background: #fff none repeat scroll 0 0;
  color: #000 !important;
}

.listing_plans li:first-child {
  background: #1fa7cb none repeat scroll 0 0;
  border-left: 0 none;
  color: #fff;
}
.even li:hover, .even li:first-child:hover {
  background: #fecd07 none repeat scroll 0 0 !important;
}
.annual_p {
  bottom: 0;
  float: left;
  line-height: normal;
  position: absolute;
  text-align: center;
  width: 100%;
}
.save_p {
  border-top: 1px solid #fff832;
  color: #e21f27;
  float: right;
  font-size: 20px;
  height: auto !important;
  left: 0;
  line-height: normal;
  margin: auto;
  padding: 6px 12px;
  position: absolute;
  right: 0;
  text-align: center;
}
.intro_rate h4 em, .save_p b {
  color: #e21f27;
  font-size: 20px;
  font-style: normal;
}
.save_p i {
  color: #000;
  font-size: 18px;
  font-weight: normal;
}
.pricing h6 span {
  color: #000;
  float: left;
  font-family: arial;
  font-size: 13px;
  line-height: 18px;
  margin-top: 0;
  text-align: center;
  text-shadow: none;
  width: 100%;
}

body {
  background: rgba(0, 0, 0, 0) url("images/bgmain_band.jpg") no-repeat fixed center top / cover ;
}
.pricing h6 {
  box-sizing: border-box;
  color: #fff;
  float: right;
  font-size: 13px;
  font-weight: bold;
  height: 60px;
  line-height: 36px;
  padding-left: 0;
  position: relative;
  text-align: left;
  width: 100%;
}
.intro_rate span {
  font-weight: normal;
}
</style>
<!-- header ends -->
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
		<div class="v2_inner_main_content">
			<div class="support_inner v2_mysitti_contest_lissts">
				<h2 class="title_plan"><span>HOST Packages</span></h2>
				    <div class="plans_box">
				  	<div class="userplan_container">

						<div class="inner_plan">
							<div class="plans">
								<div class="head_plan"> <img src="images/imgo.png" alt=""> </div>
							</div>
							<?php 
								$query1 = @mysql_query("SELECT * FROM `packages` WHERE package_id IN ('3','4','5','6') ");
								while($package1 = @mysql_fetch_array($query1))
								{
							?>
									<div class="pricing">
										<div class="head_basic">
											<?php if($package1['package_id'] != "3"){?>
				                        					<h5>  </h5>
				                        					<?php } ?>
										  	<h3><?php echo $package1['package_name'];?></h3>
										</div>
										<div class="clear"></div>
										<div class="intro_rate">
					                            				<h4>
					                            					<em>
					                            						<?php if($package1['package_id'] != "3"){ ?><?php } ?>
					                            						<?php if($package1['amount'] == "Free"){ echo "(".$package1['amount'].")";}else{ echo "$".$package1['amount']; }?>
					                            					</em>
					                            					<?php if($package1['package_id'] != "3"){?>
					                            					<span> / Month</span>
					                            					<?php }	?>
					                            				</h4>
					                            
									<?php 		if($package1['package_id'] != "3")
											{	?>
												<h6>  
													<div class="annual_p">
														<!--<i>$<?php //echo $package1['annually']; ?></i>
														<span>with annual plan</span>-->
													</div>
					                                    				<div class="save_p"> 
					                                    					<b>$<?php echo $package1['annual_monthly'] ?></b>  <i> / Month</i> <span>with annual plan</span>
					                                    					</div> 
					                                    				</h6>
								<?php 			}	?>
												
										</div>
							 		</div>
							<?php 	}	?>
						</div>
						<div class="listing_plans">
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

				                     				$checkquery2 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '4' ");
				                     				$res2 = @mysql_fetch_array($checkquery2);
				                     				$functionarray2 = explode(',', $res2['functions']);
				                     				asort($functionarray2);

				                     				$checkquery3 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '5' ");
				                     				$res3 = @mysql_fetch_array($checkquery3);
				                     				$functionarray3 = explode(',', $res3['functions']);
				                     				asort($functionarray3);

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
				         				 <ul class="<?php echo $ulClass; ?>">
										<li><?php echo $functionname; ?></li>
										<li>
											<?php 
												if(in_array($fid, $functionarray))
							                     				{
							                     					if($functionname == "Storage")
							                     					{
							                     						echo "5 GB";
							                     					}
							                     					else
							                     					{
							                     						echo $mark = "X";	
							                     					}
							                     					
							                     				}
							                     				else
							                     				{
							                     					if($functionname == "Storage")
							                     					{
							                     						echo "5 GB";
							                     					}
							               				}
							                     			?>
										</li>
										<li>
											<?php 
												if(in_array($fid, $functionarray2))
							                     				{
							                     					if($functionname == "Storage")
							                     					{
							                     						echo "20 GB";
							                     					}
							                     					elseif($functionname == "Live Streaming")
							                     					{
							                     						echo "1 Hrs";
							                     					}	
							                     					else
							                     					{
							                     						echo $mark = "X";	
							                     					}
							                     				}
							                     			?>
										</li>
										<li>
											<?php 
												if(in_array($fid, $functionarray3))
							                     				{
							                     					if($functionname == "Storage")
							                     					{
							                     						echo "50 GB";
							                     					}
							                     					elseif($functionname == "Live Streaming")
							                     					{
							                     						echo "2 Hrs";
							                     					}
							                     					else
							                     					{
							                     						echo $mark = "X";	
							                     					}
							                     				}
							                     			?>
										</li>
										<li>
											<?php 
												if(in_array($fid, $functionarray4))
							                     				{
							                     					if($functionname == "Storage")
							                     					{
							                     						echo "100 GB";
							                     					}
							                     					elseif($functionname == "Live Streaming")
							                     					{
							                     						echo "4 Hrs";
							                     					}
							                     					else
							                     					{
							                     						echo $mark = "X";	
							                     					}
							                     				}
							                     			?>
										</li>
				                        
									</ul>
							<?php
									$i++;
								}
							?>
							<?php 
								if(isset($_GET['action']) && $_GET['action'] == "upgrade")
								{
							?>
									<ul>
										<li></li>
										<li></li>
										<li>
											<a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_silver" class="button_signup">Upgrade Now</a>
										</li>
										<li>
											<a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_gold" class="button_signup">Upgrade Now</a>
										</li>
										<li>
											<a href="upgradePlan.php?host_id=<?php echo $_SESSION['user_id'];?>&plan=host_platinum" class="button_signup">Upgrade Now</a>
										</li>

									</ul>
							<?php 	}	?>
						</div>
				    
						<div class="clear"></div>
				  	</div>
				        </div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include('Footer.php');?>

