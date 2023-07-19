<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_POST['check_security_code'])){

	$check_ticket_exists = mysql_query("SELECT * FROM paid_passes WHERE security_code = '".$_POST['check_security_code']."' AND pass_id = '".$_GET['pass_id']."'");
	$count_check_ticket_exists = mysql_num_rows($check_ticket_exists);
	if($count_check_ticket_exists < 1)
	{
		echo "Wrong Security Code";
	}
	else
	{
	  
			  $check_ticket_exists = mysql_query("SELECT * FROM paid_pass_download WHERE barcode = '".$_POST['barcode_value']."'");
			  $check_redeem_status = mysql_fetch_assoc($check_ticket_exists);
			  
			  $count_check_ticket_exists = mysql_num_rows($check_ticket_exists);
			  if($count_check_ticket_exists < 1)
			  {
				  echo "Wrong Security Code";
			  }
			  else
			  {
				
				if($check_redeem_status['status'] == "redeemed"){
				  
				  echo "Ticket Already Redeemed";
				  
				}else{
				  
				  $cur_date = date('Y-m-d H:i:s');
				  $updt = mysql_query("UPDATE paid_pass_download SET `status` = 'redeemed', `redeem_date` = '".$cur_date."' WHERE barcode = '".$_POST['barcode_value']."'");
				  if($updt == 1)
				  {
					  echo "Verified";
					  
						$_SESSION['event_ticket_redeemed'] = "Your Ticket Has Been Successfully Claimed By The Host";
				  }				  
				  
				}

			  }

	}
	die;
}

$hostId = $_GET['host_id'];
$userID = $_GET['user_id'];
$passID = $_GET['pass_id'];
$pdID = $_GET['pd_id'];
$getCodeInfo = mysql_query("SELECT * FROM `paid_pass_download` WHERE `pd_id` = '$pdID' ");
$fetchCodeInfo = mysql_fetch_assoc($getCodeInfo);

$get_event_id = mysql_query("SELECT event_id FROM paid_passes WHERE pass_id = '".$passID."'");
$event_id_get = mysql_fetch_assoc($get_event_id);
$event_id = $event_id_get['event_id'];

$get_event_img = mysql_query("SELECT eventname, event_address, event_image FROM events WHERE id = '".$event_id."'");
$event_data = mysql_fetch_assoc($get_event_img);

$get_event_date = mysql_query("SELECT event_date FROM forum WHERE event_id = '".$event_id."'");
$event_date = mysql_fetch_assoc($get_event_date);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/v2style.css" />
<div id="modal" class="popupContainer" style="background-color: #fff !important; border:0px; width:100%; float:left; max-width:100%" >
	<!--<header class="popupHeader">-->
	<!--	<span class="header_title">Barcode For the Ticket</span>-->
	<!--</header>-->
	<!--<section class="popupBody redeem">-->
	<!--	<div class="barcode">-->
	<!--		<img src="barcode/barcode.php?text=<?php echo trim($fetchCodeInfo['barcode']); ?>&size=100&codetype=Code128" alt="Barcode for the Ticket" />-->
	<!--	</div>-->
	<!--</section>-->
	<style>
 body {background:#fff;}
 </style>

  <div class="ticketbarcode_container">
	<div class="ve_inner_main">
	  <div class="v2_recent_contests">
		
		<?php if(isset($_GET['host_sample_ticket'])){ ?>
		
		<div class="v2_item_main_ticket">
		  <div class="v2_ticket_head">
			<?php
			$get_hostname_query = mysql_query("SELECT club_name FROM clubs WHERE id = '".$hostId."'");
			$host_name = mysql_fetch_assoc($get_hostname_query);
			?>
		  <h1><?php echo $host_name['club_name']; ?></h1>
		  </div>
		  <div class="clear"></div>
		  <div class="v2_thumb_ticket"> <img src="<?php echo $event_data['event_image']; ?>" alt="">
		  </div>
		   <div class="v2_ticket_bottom">
		  <h1><?php echo $event_data['eventname']; ?></h1>
		  </div>
		  <div class="v2_ticket_address">
		  <!--<strong>DJ Rap Live</strong>-->
		  <p><?php echo $event_data['event_address']; ?></p>
		  <!--<p>Web Site: www.iamcrush.com</p>-->
		  </div>
		  <div class="v2_ticket_time">
			<?php echo date('l jS \of F Y h:i:s A', strtotime($event_date['event_date'])); ?>
		  </div>
		  <div class="v2_code_image">
		   <img src="images/code-image.png" alt="">
		  </div>
		  <div class="v2_ticket_admit">
		  <h1>Admit One</h1>
		  </div>
		</div>			
		
		<?php }else{ ?>
		
		<div class="v2_item_main_ticket">
		  <div class="v2_ticket_head">
			<?php
			$get_hostname_query = mysql_query("SELECT club_name FROM clubs WHERE id = '".$hostId."'");
			$host_name = mysql_fetch_assoc($get_hostname_query);
			?>
		  <h1><?php echo $host_name['club_name']; ?></h1>
		  </div>
		  <div class="clear"></div>
		  <div class="v2_thumb_ticket"> <img src="<?php echo $event_data['event_image']; ?>" alt="">
		  </div>
		   <div class="v2_ticket_bottom">
		  <h1><?php echo $event_data['eventname']; ?></h1>
		  </div>
		  <div class="v2_ticket_address">
		  <!--<strong>DJ Rap Live</strong>-->
		  <p style="font-weight: bold;"><?php echo $event_data['event_address']; ?></p>
		  <!--<p>Web Site: www.iamcrush.com</p>-->
		  <p><span style="font-weight: bold;">Ticket Number: <?php echo $fetchCodeInfo['barcode'];?></span></p>
			<input type="hidden" id="barcode_val" value="<?php echo $fetchCodeInfo['barcode'];?>">
		  </div>
		  <div class="v2_ticket_time" style="font-weight: bold;">
			<?php echo date('l jS \of F Y h:i:s A', strtotime($event_date['event_date'])); ?>
		  </div>
		<div class="barCode">
			
		</div>
		  <div class="v2_code_image">
		  <img src="barcode/barcode.php?text=<?php echo trim($fetchCodeInfo['barcode']); ?>&size=50&codetype=Code128" alt="Barcode for the Ticket" />
		  </div>
		  <div class="v2_ticket_admit">
		  <h1>Admit One</h1>
		  </div>
		</div>			
		
		<?php } ?>

	  </div>
	</div>


  <?php if(isset($_GET['ticket']) && $_GET['ticket'] == md5('redeem') ){ ?>

	<div class="print_ticket reedeemtick">
	  <div class="v2_ticket_admit">
		<input type="text" id="redeem_secuity_ticket_code" placeholder="Enter Secuirty Code">
		<button onclick="redeem_ticket();">Redeem</button>
	  </div>
	</div>

  <?php } ?>

  

	<div class="clear"></div>
  </div><div class="print_ticket">
  <a href="javascript: void(0)" onclick="print_ticket()">Print Ticket</a>
  </div>
	<div class="clear"></div></div>
	<style>
	.popupHeader {
  background: #000 none repeat scroll 0 0;
  border: 0 none;
  float: none;
  height: 40px;
  margin-top: 50px !important;
  margin-left: auto;
  margin-right: auto;
  margin-top: auto;
  max-width: 300px;
  position: relative;
  text-align: center;
  width: 300px;
  z-index: 999;
}
	.popupHeader span{
  background: #000 none repeat scroll 0 0;
	}
.v2_thumb_ticket {
  max-width: 100% !important;
  max-height: 100% !important;
  text-align: center;
  min-height:auto !important;}
 
 .v2_thumb_ticket img {position:static !important; margin:auto;}
	.popupBody {
  border: 1px solid #fff;
  display: table;
  margin: auto;
  max-width: 300px;
  padding: 40px 20px 20px;
}
.redeem {
  margin-top: 40px;
  text-align: center;
  top: -30px;
}
.redeem > div {
position:static;
}
.print_ticket button {
  background: #00baff none repeat scroll 0 0;
  border: 0 none;
  color: #fff;
  cursor:pointer;
  padding: 6px;
}
.print_ticket input[type="text"] {
  border: 0 none;
  padding: 7px;
}
	</style>

<script type="text/javascript">
  function print_ticket() {
	window.print();
  }
  
  function redeem_ticket(){
	
	var security_code_value = $('#redeem_secuity_ticket_code').val();
	var barcode_value = $('#barcode_val').val();
	
	//alert(security_code_value.trim());
	
	if(security_code_value.trim() != "") {
		  
			  $.post('', {'check_security_code': security_code_value, 'barcode_value': barcode_value}, function(response){
				  if (response == "Verified") {
					  opener.location.reload(true);self.close();
				  }else{
					  alert(response);
					  return false;
				  }
			  });
			
	}else{
	  alert("Please fill security code");
	  return false;
	}
  }
</script>  