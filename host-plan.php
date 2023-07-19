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
		<div class="price-chart" style="float: left; margin: 20px 0;">
				<table class="table_full-width">
                 	<thead>
	                  	<th style="background: none #000;"></th>
	                  	<th class="title">Basic</th>
	                  	<th class="title last">Pro</th>
                 	</thead>
                 	<tbody>
                 		<tr>
							<td style="background: none #000; border:1px solid #000;"></td>
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
		 
<script language="javascript">	

</script>
 </div>
 <?
//include('club-right-panel.php');
?>
   
  </div>
</div>
<?
include('footer.php');
?>

   <!-- <form action="https://sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick-subscriptions">
   
<input type="hidden" name="business" value="jasonwalker.bwd-facilitator@gmail.com">

<input type="hidden" name="item_name" value="Ultra Membership plan for mysitti">

<input type="hidden" name="a3" value="29.99">

<input type="hidden" name="asd" value="asd">
<input type="hidden" name="currency_code" value="USD">
   
      <input type="hidden" value="http://mysittidev.com/thankyou.php?type=host" name="return">
            

 <input style="padding:0px; width: 96px;" type="submit"  class="big-button" value="Start">
</form> --> 
?>
<style>
.big-buttons{

  color: red;
  font-size: 15px;
  pointer-events: none;
  text-decoration: none;
}

</style>

