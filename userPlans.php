<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(!isset($_GET['t'])){
   // $Obj->Redirect("sign_up_option.php");	
}
if(isset($_REQUEST['ipnupgrade'])){
	$sql="UPDATE `clubs` SET `plantype` = 'host_pro' WHERE `id` =".$_SESSION['user_id'];
	mysql_query($sql);
	$message['success']='Congrats you have successfully upgraded your plan';
	$Obj->Redirect("host-plan.php?type=upgrade");
}
$titleofpage="Select Your Plan";	
include('headhost.php');
include('header.php');

$planlist=array("mySitti App","Profile Page","Send Shout Out","Manage Shouts","Real-Time VIP Pass","Real-Time Advertisement","Auto Link to Social Media","Real Connection List","Lauch Live Streaming","Request Music Users interface","Shopping Cart","Usesrs can buy & download musics","Events Listing","Event Calender","Upcoming Event Schedule","BookMe");
$price="29.99";
//$planlist=array("mySitti App","Profile Page","Shout Out","Manage Shouts","Real-Time VIP Pass","Real-Time Advertisement","Auto Link to Social Media","Real Connection List","Lauch Live Streaming","View Own Live Streaming","Host own Contest","Contest Leader Board","Events Listing","Event Calender","Upcoming Event Schedule","Request Music Users interface","View Own Live Streaming","BookMe - VIP section & Party");

?>
<style>
.home_content_top:after{
	background:none;
}
.home_content_top:before{
	background:none;
}
.tab1 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: none repeat scroll 0 0 #5e5e6b;
    border-color: #999 #999 -moz-use-text-color;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 1px medium;
    display: inline-block;
    /*pointer-events: none;*/
}
.tab1 a {
    color: rgb(255, 255, 255);
    display: block;
    font-size: 16px;
    line-height: 2em;
    outline: medium none;
    padding: 0 25px;
    text-decoration: none;
}


.tab1.active {
    background: none repeat scroll 0 0 rgb(0, 91, 145);
    border-color: #666;
    padding-top: 2px;
    position: relative;
    top: 1px;
    /*display: block !important;*/
}

.tab1 a.active {
    font-weight: bold;
}
.tab-container .panel-container
{
	float: left;
}
</style>
<link rel="stylesheet" type="text/css" href="css/new_portal/plan.css" />
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content withoutsidebar">
			<div class="home_content_top">
					<h2>Select Your Plans</h2>
					<div style="clear:both;"></div>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					$message['success']="";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 

					?>
				
				<script src="js/jquery.hashchange.min.js" type="text/javascript"></script>
				<script src="js/jquery.easytabs.min.js" type="text/javascript"></script>
				<script type="text/javascript">

					function tabchange(id)
					{
						
						if(id=='user')
						{
							$('div.host').css('display','none');
							$('div.user').css('display','block');
							$('li#user').addClass('active');
							$('li#host').removeClass('active');

						}
						else
						{
							$('div.user').css('display','none');
							$('div.host').css('display','block');
							$('li#host').addClass('active');
							$('li#user').removeClass('active');
						}

					}
				</script>
		 		<div class="logininner">
			        <div id="tab-container" class='tab-container'>
						<ul class='etabs'>
							<li class='tab1 active' onclick="tabchange(this.id)" id="user"><a class="active" href="#tabs1-html">Standard User</a></li>
							<li class='tab1' onclick="tabchange(this.id)" id="host"><a href="#tabs1-js">Host</a></li>
						</ul>
						<div class='panel-container'>

							<div id="tabs1-html" class="user">

								<div class="price-chart" style="float: left; margin: 20px 0;">
									<table class="table_full-width">
					                 	<thead>
						                  	<th style="background: none #FFF;"></th>
						                  	<th class="title">Basic</th>
						                  	<th class="title last">Pro</th>
					                 	</thead>
					                 	<tbody>
					                 		<tr>
												<td></td>
												<?php 	$query1 = @mysql_query("SELECT * FROM `packages` WHERE package_id='1'");
														$package1 = @mysql_fetch_array($query1);
														$query2 = @mysql_query("SELECT * FROM `packages` WHERE package_id='2'");
														$package2 = @mysql_fetch_array($query2);

												?>
												<td class="fees">$<?php echo $package1['amount']?> <br > <?php echo $package1['description'];?></td>
												<td class="fees">$<?php echo $package2['amount']?> per month <br > <?php echo $package2['description'];?> </td>
					                     	</tr>
					                     	<?php 

					                     			$funcquery = @mysql_query("SELECT * FROM `userpackagefunction` as userpack ORDER BY `function_id` ASC ");
					                     			while($fnc = @mysql_fetch_array($funcquery))
					                     			{
					                     				$functionname = $fnc['function_name'];
					                     				$fid = $fnc['function_id'];
					                     				$checkquery = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '1' ");
					                     				$res1 = @mysql_fetch_array($checkquery);
					                     				$functionarray = explode(',', $res1['functions']);
					                     				$checkquery2 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '2' ");
					                     				$res2 = @mysql_fetch_array($checkquery2);
					                     				$functionarray2 = explode(',', $res2['functions']);
					                     				if(in_array($fid, $functionarray))
					                     				{
					                     					$free = "pt-yes";
					                     				}
					                     				else
					                     				{
					                     					$free = "pt-no";
					                     				}
					                     				if(in_array($fid, $functionarray2))
					                     				{
					                     					$free2 = "pt-yes";
					                     				}
					                     				else
					                     				{
					                     					$free2 = "pt-no";
					                     				}
					                     				
					                     			?>
														<tr>
															<td class="first-col"><?php echo $functionname; ?></td>
															<td class="<?php echo $free; ?>" id="<?php echo $fid; ?>"><br><br><?php if($fnc['function_price'] != ""){ echo $fnc['function_price'];  }?></td>
															<td class="<?php echo $free2; ?>"><br><br><?php if($fnc['function_price'] != ""){ echo $fnc['function_upgrade_price'];  }?></td>
														</tr>
											<?php 	} ?>
					                     
					                     				<tr class="fin" style="height: 100px;">
															<td class="first-col">&nbsp;</td>
															<? if(isset($_SESSION['user_id']) && isset($_GET['type']) && $_GET['type']=='upgrade'){	
																$sql="select plantype from user where id=".$_SESSION['user_id'];
																$data=mysql_query($sql);
																$datarow=mysql_fetch_array($data);
																$palntype=$datarow['plantype'];
																if($palntype=='ultra'){?>
																	
																	<td class="pt-3x" id=""><span><a href="sign_up.php?plan=free#tabs1-html" class="big-buttons">You have already subscribed Pro plan</a></span></td>
															        <td class="pt-3x" id=""><span><a href="sign_up.php?plan=free#tabs1-html" class="big-buttons">You have already subscribed this plan </a></span></td>
																<?}else{?>
																	<td class="pt-3x" id=""><a href="sign_up.php?plan=free#tabs1-html" class="big-buttons">You have already subscribed this plan</a></td>
																		<form action="paymentoption.php" method="post">
																	<? 
																	
																	$data=mysql_query("SELECT amount FROM `packages` where package_id=2;");
																	$datarow=mysql_fetch_array($data);
																	$amount=$datarow['amount'];
																	$query['notify_url'] = 'https://mysitti.com/user-plan.php?ipnupgrade=success';
																	$query['cmd'] = '_xclick-subscriptions';
																	$query['no_shipping'] ="1";	
																	$query['business'] = 'merchant1315@gmail.com';
																	$query['lc'] = 'IN';
																	$query['item_name'] = "Upgrade to Pro  user  Membership plan for mysitti";
																	$query['no_note'] = '1';
																	$query['src'] = '1';
																	$query['a3'] = $amount;
																	$query['p3'] = '1';
																	$query['t3'] = 'M';
																	$query['address_override'] = '1';
																	$query['currency_code'] = 'USD';
																	$query['return'] = 'https://mysitti.com/user-plan.php?ipnupgrade=success';
																	$query['cancel'] = 'https://mysitti.com/host-plan-payment.php?upgraded=cancel';
																	$query_string = http_build_query($query);
																	//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
																	 $paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;						
																	?><td class="pt-3x" id="">
																	    <input type="hidden" name="amount" value="<? echo $query['a3']?>">
																		<input type="hidden" name="paypal" value="<? echo $paypalurl; ?> ">
																		<input type="submit" value="Upgrade plan"  class="big-button" name="upgrade_submit">
																		</form>
															        <!--<a href="<? echo $paypalurl;?>" class="big-button">Upgrade</a>--></td>
																<?}?>									
															
																
															<?	}else if(isset($_SESSION['user_id'])){
																$Obj->Redirect("user-plan.php?type=upgrade");
																} if(!isset($_SESSION['user_id'])){ ?>
															<td class="pt-3x" id=""><a href="sign_up.php?plan=free#tabs1-html" class="big-button">Sign Up</a></td>
															<td class="pt-3x" id=""><a href="sign_up.php?plan=ultra#tabs1-html" class="big-button">Sign Up</a></td>
														    <? } 
														    
														    ?>
														</tr>
					                     
					                     </tbody>	                    
				                    </table>
            					</div>
							</div>
							<div id="tabs1-js" class="host" style="display:none;"> 
								<div class="price-chart" style="float: left; margin: 20px 0;">
									<table class="table_full-width">
		                 	<thead>
			                  	<th style="background: none #FFF;"></th>
			                  	<th class="title">Basic</th>
			                  	<th class="title last">Pro</th>
		                 	</thead>
		                 	<tbody>
		                 		<tr>
									<td></td>
									<?php 	$query1 = @mysql_query("SELECT * FROM `packages` WHERE package_id='3'");
											$package1 = @mysql_fetch_array($query1);
											$query2 = @mysql_query("SELECT * FROM `packages` WHERE package_id='4'");
											$package2 = @mysql_fetch_array($query2);

									?>
									<td class="fees">$<?php echo $package1['amount']?> <br > <?php echo $package1['description'];?></td>
									<td class="fees">$<?php echo $package2['amount']?> per month <br > <?php echo $package2['description'];?> </td>
		                     	</tr>
		                     	<?php 

		                     			$funcquery = @mysql_query("SELECT * FROM `hostpackagefunction` as userpack ORDER BY `function_id` ASC ");
		                     			while($fnc = @mysql_fetch_array($funcquery))
		                     			{
		                     				$functionname = $fnc['function_name'];
		                     				$fid = $fnc['function_id'];
		                     				$checkquery = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '3' ");
		                     				$res1 = @mysql_fetch_array($checkquery);
		                     				$functionarray = explode(',', $res1['functions']);
		                     				$checkquery2 = @mysql_query("SELECT * FROM `packages` WHERE `package_id` = '4' ");
		                     				$res2 = @mysql_fetch_array($checkquery2);
		                     				$functionarray2 = explode(',', $res2['functions']);
		                     				if(in_array($fid, $functionarray))
		                     				{
		                     					$free = "pt-yes";
		                     				}
		                     				else
		                     				{
		                     					$free = "pt-no";
		                     				}
		                     				if(in_array($fid, $functionarray2))
		                     				{
		                     					$free2 = "pt-yes";
		                     				}
		                     				else
		                     				{
		                     					$free2 = "pt-no";
		                     				}
		                     				
		                     			?>
											<tr>
												<td class="first-col"><?php echo $functionname; ?></td>
												<td class="<?php echo $free; ?>" id="<?php echo $fid; ?>"></td>
												<td class="<?php echo $free2; ?>"></td>
											</tr>
								<?php 	} ?>
		                     
		                     				<tr class="fin" style="height: 100px;">
												<td class="first-col">&nbsp;</td>
												<? if(isset($_SESSION['user_id']) && isset($_GET['type']) && $_GET['type']=='upgrade'){	
													$sql="select plantype from user where id=".$_SESSION['user_id'];
													$data=mysql_query($sql);
													$datarow=mysql_fetch_array($data);
													$palntype=$datarow['plantype'];
													if($palntype=='host_pro'){?>
														
														<td class="pt-3x" id=""><span><a href="sign_up.php?plan=host_free#tabs1-js" class="big-buttons">You have already subscribed Pro plan</a></span></td>
												        <td class="pt-3x" id=""><span><a href="sign_up.php?plan=host_free#tabs1-js" class="big-buttons">You have already subscribed this plan </a></span></td>
													<?}else{?>
														<td class="pt-3x" id=""><a href="sign_up.php?plan=host_free#tabs1-js" class="big-buttons">You have already subscribed this plan</a></td>
															<form action="paymentoption.php" method="post">
														<? 
														$merchant_id=PAYPAPOWNERID;
														$data=mysql_query("SELECT amount FROM `packages` where package_id=4;");
														$datarow=mysql_fetch_array($data);
														$amount=$datarow['amount'];
														$query['notify_url'] = 'https://mysitti.com/user-plan.php?ipnupgrade=success';
														$query['cmd'] = '_xclick-subscriptions';
														$query['no_shipping'] ="1";	
														$query['business'] = $merchant_id;
														$query['lc'] = 'IN';
														$query['item_name'] = "Upgrade to Pro  user  Membership plan for mysitti";
														$query['no_note'] = '1';
														$query['src'] = '1';
														$query['a3'] = $amount;
														$query['p3'] = '1';
														$query['t3'] = 'M';
														$query['address_override'] = '1';
														$query['currency_code'] = 'USD';
														$query['return'] = 'https://mysitti.com/user-plan.php?ipnupgrade=success';
														$query['cancel'] = 'https://mysitti.com/host-plan-payment.php?upgraded=cancel';
														$query_string = http_build_query($query);
														//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
														 $paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;						
														?><td class="pt-3x" id="">
														    <input type="hidden" name="amount" value="<? echo $query['a3']?>">
															<input type="hidden" name="paypal" value="<? echo $paypalurl; ?> ">
															<input type="submit" value="Upgrade plan"  class="big-button" name="upgrade_submit">
															</form>
												        <!--<a href="<? echo $paypalurl;?>" class="big-button">Upgrade</a>--></td>
													<?}?>									
												
													
												<?	}else if(isset($_SESSION['user_id'])){
													$Obj->Redirect("user-plan.php?type=upgrade");
													} if(!isset($_SESSION['user_id'])){ ?>
												<td class="pt-3x" id=""><a href="sign_up.php?plan=host_free#tabs1-js" class="big-button">Sign Up</a></td>
												<td class="pt-3x" id=""><a href="sign_up.php?plan=host_pro#tabs1-js" class="big-button">Sign Up</a></td>
											    <? }
											    
											    ?>
											</tr>
					                     </tbody>
				                    </table>
					 			</div>

							</div>


						</div>
					</div>
				</div>

 </div>
  </div>
</div>
<?
include('footer.php');
?>

?>
<style>
.big-buttons{

  color: red;
  font-size: 15px;
  pointer-events: none;
  text-decoration: none;
}

</style>

