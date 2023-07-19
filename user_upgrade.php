<?php
// 	ini_set("display_errors", "1");
// error_reporting(E_ALL);
if(isset($_SESSION['user_id'])){

	if($_SESSION['user_type']=='user')
	{
		$sql="select plantype  from user where id=".$_SESSION['user_id'];

		$data=mysql_query($sql);
		$data_upgrade=mysql_fetch_array($data);

	}
	/*elseif((!empty($userID) || !empty($hostID) ) && isset($_GET['user']) )
	{
		if(isset($_GET['host_id']))
		{
			$hostID = $_GET['host_id'];
		}
		elseif(isset($_GET['id']))
		{
			$hostID = $_GET['id'];
		}

		$sql1= @mysql_query("select * from clubs where id='".$hostID."' ");
		$data_upgrade1 = @mysql_fetch_array($sql1);
	}*/
	elseif($_SESSION['user_type']=='club')
	{
		$sql="select plantype from clubs where id=".$_SESSION['user_id'];

		$data=mysql_query($sql);
		$data_upgrade=mysql_fetch_array($data);
	}
	elseif( ((isset($_GET['host_id'])) && ($_GET['host_id'] != "") ) || isset($_GET['id']))
	{
		if(isset($_GET['host_id']))
		{
			$hostID = $_GET['host_id'];
		}
		elseif(isset($_GET['id']))
		{
			$hostID = $_GET['id'];
		}
		$sql1= @mysql_query("select * from clubs where id='".$hostID."' ");
		$data_upgrade1 = @mysql_fetch_array($sql1);
	}
}
function check_data(){


	if($_SESSION['user_type']=='user')
	{
		$sql="select plantype  from user where id=".$_SESSION['user_id'];

		$data=mysql_query($sql);
		$data_upgrade=mysql_fetch_array($data);
		$data=mysql_query($sql);
		$data_upgrade=mysql_fetch_array($data);

		if($data_upgrade['plantype']!="ultra"){
			
			$data_upgrade_needed=1;
			
		}else{
			$data_upgrade_needed=0;
		}
	}
	if($_SESSION['user_type']=='club')
	{
		$sql="select plantype  from clubs where id=".$_SESSION['user_id'];

		$data=mysql_query($sql);
		$data_upgrade=mysql_fetch_array($data);

		if($data_upgrade['plantype'] =="host_free"){
			
			$data_upgrade_needed=1;
			
		}else{
			$data_upgrade_needed=0;
		}
	}
	 return $data_upgrade_needed;
}
	

function get_plan_type($host_id){
	         $package_function=mysql_query("select plantype  from clubs  WHERE id =".$host_id);
			 $package_function=mysql_fetch_array($package_function);
			 $package_function=$package_function['plantype'];
			 if($package_function=='host_free'){
				 $needed=1;
			 }else{
				 $needed=0;
			 }
			 return $needed;
	
}
function chk_upgrade_needed($plantype, $pageId){
	if($_SESSION['user_type']=='club')
	{
		$package_function=mysql_query("SELECT functions FROM `packages` where value = '$plantype' ");
		$package_function=mysql_fetch_array($package_function);
		$package_function=$package_function['functions'];
		$package_function_arra=explode(',',$package_function);			
	 	if(in_array($pageId,$package_function_arra))
	 	{
		 	$data_upgrade_needed=0;
	     	}
	     	else
	     	{
		 	$data_upgrade_needed=1;
	 	}
			
	  	
	}
	if($_SESSION['user_type']=='user')
	{

		if(isset($_GET['host_id']))
		{
			//echo $plantype; die;
			//if($plantype == 'host_free' )
			//{
				$package_function=mysql_query("SELECT functions FROM `packages` where value = '$plantype' ");
				$package_function=mysql_fetch_array($package_function);
				$package_function=$package_function['functions'];
				$package_function_arra=explode(',',$package_function);			
				if(in_array($pageId,$package_function_arra))
				{
					$data_upgrade_needed=0;
				}
				else
				{
					$data_upgrade_needed=1;
				}

			//}
			//else
			//{
			//	$data_upgrade_needed=0;
			//}
		}
		else
		{
			//if($plantype!='ultra')
			//{
				$package_function=mysql_query("SELECT functions FROM `packages` where value = '$plantype' ");
				$package_function=mysql_fetch_array($package_function);
				$package_function=$package_function['functions'];
				$package_function_arra=explode(',',$package_function);			
				if(in_array($pageId,$package_function_arra))
				{
					$data_upgrade_needed=0;
				}
				else
				{
					$data_upgrade_needed=1;
				}

			//}
			//else
			//{
			//	$data_upgrade_needed=0;
			//}
		}
	}

	return $data_upgrade_needed;
}
function chk_upgrade_needed_shopping($plantype, $pageId,$hostId){
	 $plan_type=mysql_query("select plantype  from clubs where id=".$hostId);
			 $plan_type=mysql_fetch_array($plan_type);
			  $plan_type=$plan_type['plantype'];
	if($_SESSION['user_type']=='user'){
		  if($plan_type=='host_free'){
			 $package_function=mysql_query("SELECT functions FROM `packages` where package_id=3 ");
			 $package_function=mysql_fetch_array($package_function);
			 $package_function=$package_function['functions'];
			 $package_function_arra=explode(',',$package_function);			
			 if(in_array($pageId,$package_function_arra)){
			 $data_upgrade_needed=0;
		     }else{
			 $data_upgrade_needed=1;
		 }
			
		  }else{
			  $data_upgrade_needed=0;
		  }
	}
	return $data_upgrade_needed;

}
?>
<script>
function upgradePlan(plan){
	if(!plan)
	{
		plan="free";
	}
	$('#modal1').css('display','block');
	//alert("Please upgrde plan");
	return false;
	
}

	function model_close(){
		$('#modal1').css('display','none');
	}


</script>

<div id="modal1" class="popupContainer upgrade_popup" >
    
    <div class="bgmodalupgrade">
      <span class="modal_close clszxc" onclick="model_close()"><img src="images/closepopup.png" alt="X" /></span>
    
    
    <section class="popupBody postpopupz">
      
      <div class="user_register">
		  <span class="upgrade_span">Please upgrade your plan to access this page</span>
		  <form action="packages.php?action=upgrade" method="post"> 
		  	<input type="submit" value="Upgrade plan"  class="big-button" name="upgrade_submit">
		  	
		  </form>

	<?php/*	  
      	<form action="paymentoption.php" method="post">
			
			<? if($_SESSION['user_type']=='user'){
					$data=mysql_query("SELECT amount FROM `packages` where package_id=2");
					$datarow=mysql_fetch_array($data);
					$amount=$datarow['amount'];
					$query['notify_url'] = 'https://mysitti.com/user-plan.php?ipnupgrade=success';
					$query['cmd'] = '_xclick-subscriptions';
					$query['no_shipping'] ="1";	
					$query['business'] = 'merchant1315@gmail.com';
					$query['lc'] = 'IN';
					$query['item_name'] = "Upgrade to Ultra  user  Membership plan for mysitti";
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
					}else{
						
				    $data=mysql_query("SELECT amount FROM `packages` where package_id=4");
					$datarow=mysql_fetch_array($data);
					$amount=$datarow['amount'];
					$query['notify_url'] = 'https://mysitti.com/user-plan.php?ipnupgrade=success';
					$query['cmd'] = '_xclick-subscriptions';
					$query['no_shipping'] ="1";	
					$query['business'] = 'merchant1315@gmail.com';
					$query['lc'] = 'IN';
					$query['item_name'] = "Upgrade to Pro  Host  Membership plan for mysitti";
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
						} ?>
      	    <input type="hidden" name="amount" value="<? echo $query['a3'];?>">
      	    <input type="hidden" name="paypal" value="<? echo $paypalurl; ?> ">
      	     <input type="hidden" name="upgradeorfresh" value="upgrade">
      	    <input type="submit" value="Upgrade plan"  class="big-button" name="upgrade_submit">
      	</form> */ ?>
      </div>
    </section>
  </div>
  
  </div>
<style>
#modal1{
position:fixed;
	left:0 !important;
	top:0 !important;
	height:100%;
	z-index:99;
	zoom:1;
	display:none; 
	width:100%;
	max-width: 100%;
	z-index:2147483647;
	background:rgba(0, 0, 0, 0.9)!important;
}
.bgmodalupgrade{
  bottom: 0;
  box-shadow: none;
  height: 220px;
  left: 0 !important;
  margin: auto;
  max-width: 470px;
  overflow: auto;
  padding: 0;
  position: absolute;
  right: 0;
  top: 0 !important;
  width: 100%;
  z-index: 99;
  background:#fff;
}

.big-button {
  background: none repeat scroll 0 0 #4a980d;
  border: 1px solid #407718;
  border-radius: 5px;
  color: #fff;
  font-size: 24px;
  font-weight: 700;
  line-height: 50px;
  padding: 10px 20px;
  position: relative;
  text-decoration: none;
  text-shadow: 2px 2px rgba(0, 0, 0, 0.3);
  top: 18px;
  cursor:pointer;
}
.user_register {
  margin-top: 0;
  text-align: center;
}
.upgrade_span {
  background: #fecd07 none repeat scroll 0 0;
  color: #000;
  float: left;
  font-size: 19px;
  padding: 30px 0;
  text-align: center;
  width: 100%;
}
</style>
