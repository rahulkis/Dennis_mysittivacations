<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
if(isset($_REQUEST['ipnupgrade'])){
	$sql="UPDATE `user` SET `plantype` = 'ultra' WHERE `id` =".$_SESSION['user_id'];
	mysql_query($sql);
	$message['success']='Congrats you have successfully upgraded your plan';
	$Obj->Redirect("user-plan.php?type=upgrade");
}
$titleofpage="Select Your Plan";	
include('headhost.php');
include('header.php');
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
			
                    					 <!--
<form action="https://sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick-subscriptions">
   <input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="business" value="merchant1315@gmail.com">
<input type="hidden" name="lc" value="IN">
<input type="hidden" name="item_name" value="Ultra Membership plan for mysitti">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="src" value="1">
<input type="hidden" name="a3" value="7.99">
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="M">
<input type="hidden" name="asd" value="asdf">
<input type="hidden" name="currency_code" value="USD">
   <input type="hidden" value="https://mysitti.com/ipn.php" name="notify_url">
      <input type="hidden" value="https://mysittidev.com/user-plan-payment.php#tabs1-html" name="return">
            <input type="hidden" value="www.mysitti.com/ipn.php" name="cancel">
<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">
 <input style="padding:0px; width: 96px;" type="submit"  class="big-button" value="Start">
</form>   -->     


   
		 </div>
		 
<script language="javascript">	
function  disables()
{
	if(jQuery('#eventname').val()!='' && jQuery('#eventDate').val()!='' && jQuery('#description').val()!=''){
	
	jQuery("#addevent").attr('disabled',true);
	jQuery('#addeventform').submit();
}
}	
 function cancelEdit(){
   window.location='listevent.php'
 } 
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
<style>
.big-buttons{

  color: red;
  font-size: 15px;
  pointer-events: none;
  text-decoration: none;
}

</style>


