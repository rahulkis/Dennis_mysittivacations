<?php  
session_start(); 
include("Query.Inc.php");

$Obj = new Query($DBName);

if(isset($_POST['check_security_code'])){

	$security_code = $_POST['check_security_code'];
	$pass_id = $_GET['pass_id'];
	
	$verify_security_code = mysql_query("SELECT * FROM host_coupon WHERE id = '".$pass_id."' AND security_code = '".$security_code."'");
	$check_code_exists = mysql_num_rows($verify_security_code);
	
	if($check_code_exists == 1){
		
		echo "Verified";
	}else{
		
		echo "Wrong Security Code";
		
	}
	
	die;
}


$userID=$_SESSION['user_id'];

if(!isset($_SESSION['user_id'])){

$Obj->Redirect("login.php");

}



if($_GET['type']=='private')
{
	$type=$_GET['type'];
}
else
{
	$type='public';
}



$get_cupon_img = @mysql_query("SELECT * FROM host_coupon WHERE id = '".$_GET['pass_id']."'");

$get_img = mysql_fetch_assoc($get_cupon_img);



//$now = time(); // or your date as well

//$your_date = strtotime($get_img['expiry_date']);

//$datediff =  $your_date - $now;

//$get_difference = floor($datediff/(60*60*24));



$date1 = date("Y-m-d");

$ts1 = strtotime($date1);

$ts2 = strtotime($get_img['expiry_date']);

$redeem_date = date('Y-m-d H:i:s');



$get_difference = $ts2 - $ts1;


if(isset($_GET['action']) == 'redeemPass')
{
   $del_pass = @mysql_query("SELECT * FROM downloadpasses WHERE user_id = '".$_GET['u_id']."' AND pass_id = '".$_GET['p_id']."'");

   $c_row = mysql_num_rows($del_pass);


	if($c_row >= 1){
	
	  
	
	  //$check = @mysql_query("DELETE FROM downloadpasses WHERE user_id = '".$_GET['u_id']."' AND pass_id = '".$_GET['p_id']."'");
	
	  
	
	  $check = @mysql_query("UPDATE downloadpasses SET status = '1', redeem_date = '".$redeem_date."' WHERE user_id = '".$_GET['u_id']."' AND pass_id = '".$_GET['p_id']."'");
	
	  
	
	  if($check == 1){
	
		die('asdadasdsad');
	
		$_SESSION['pass_redeemed'] = "Your Pass Has Successfully Claimed By The Host";
	
		echo "<script>opener.location.reload(true);self.close();</script>";			
	
		 
	
		$message = "Your Pass Has Successfully Claimed By The Host";
	
		 
	
	  }
	
	  
	
	}
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php //include('suggest_friend.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />

<!--echo "<script>opener.location.reload(true);self.close();</script>";-->

<style>
 body {
  background: rgba(0, 0, 0, 0) url("https://mysitti.com/images/noice.png") repeat scroll 0 0;
  color: #333;
  font-family: "Open Sans",sans-serif;
  font-size: 13px;
  line-height: 1;
  transition: all 0.9s ease-out 0s;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
    margin: 0 auto;
    padding: 20px;
}
.clear {
 clear:both;
}
 
.popupContainer {
  background: transparent none repeat scroll 0 0 !important;
  border: 0 none;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  height: 100%;
  margin: 20px auto auto;
  max-width: 400px;
  position: relative !important;
  width: 100%;
}
 
.thumb_event {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 0 none;
  float: none;
  margin: 0 auto;
  position: relative;
  text-align: center;
  width: 100%;
}
.thumb_event img { 
 text-align:center;
 margin:auto; 
 max-width:100%;
}
h3 {
  background: #fecd07 none repeat scroll 0 0;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  color: #000;
  float: left;
  font-size: 15px;
  font-weight: bold;
  margin-bottom: 0;
  padding: 10px;
  text-align: center;
  text-transform: uppercase;
  width: 100%;
}
.controlRedeem {
 
  bottom: 0;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  float: left;
  height: 100%;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
  width: 100%;
}
.innercontrol {
  background: rgba(0, 0, 0, 0.3) none repeat scroll 0 0;
  border: 0 none;
  bottom: 0;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  float: left;
  height: 63px;
  left: 0;
  margin: auto;
  padding: 10px;
  position: absolute;
  right: 0;
  top: 0;
  width: 100%;
}
.btn_redeem {
  background: red none repeat scroll 0 0;
  border: 0 none;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  color: #000 !important;
  float: left;
  font-size: 15px;
  font-weight: bold;
  height: 40px;
  line-height: 40px;
  padding: 0 20px;
  text-decoration: none;
  text-transform: uppercase;
  width: 29%;
  margin:0;
}
.sec_code {
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  float: left;
  margin: 0;
  width: 70%;
}

.sec_code input {
  border: 0 none;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  font-size: 13px;
  height: 40px;
  padding: 10px;
  text-align: center;
  width: 100%;
}
  .sec_code label {
  font-weight: bold;
  margin-bottom: 5px;
  float: left;text-align:center; width:100%;
}
 
.innerPass {
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  float: left;
  padding: 0;
  width: 100%;
}
.button.expiredpass {
  width: 100%;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  margin-bottom: 10px;
  background: #ff4e4e;
  color: #000 !important;
  font-weight: bold;
  text-transform: uppercase;
  padding: 10px;
  border: 0;
}
.pinner {
  border: 5px solid #fff;
  box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
  float: left;
  width: 100%;
  box-sizing: border-box;
}
@media only screen and (max-width:479px;) {
 .popupContainer {max-width:300px;}
}
</style>

<div id="modal" class="popupContainer">
<div class="pinner">
  <h3>Redeem Event Pass</h3>
  <div class="clear"></div>
  <div class="innerPass">
  <div class="thumb_event"> <img src="upload/coupon/<?php echo $get_img['coupon_image']; ?>"> 
  <div class="controlRedeem">
  <div class="innercontrol">
 
  <?php if($get_difference < 0){ ?>
  <div class="clear"></div>
  <a class="button expiredpass" href="javascript: void(0);"> <span>Expired</span> </a>
  <?php }else{ ?>
 
  <div class="sec_code">
   <input type="text" id="security_code_value" placeholder="Enter Security Code">
  
  </div>
  <a onclick="security_code_check(); return false;" class="button btn_redeem" href="javascript : void(0)"> <span>Redeem</span> </a>
  <?php } ?>
   
</div>
</div>
  </div>
  
  </div>
</div>
</div>
<script language=JavaScript>
function security_code_check(){
	
	if ($('#security_code_value').val().trim() == "" || $('#security_code_value').val().trim() == " ") {
		alert("Please Enter Security Code");
	}else{
		
		var security_code_value = $('#security_code_value').val();
		
			$.post('', {'check_security_code' :security_code_value}, function(response){
				if (response == "Verified") {
					window.location.href = "redeem_pass.php?p_id=<?php echo $_GET['pass_id']; ?>&u_id=<?php echo $_SESSION['user_id']; ?>&action=redeemPass";
				}else{
					alert(response);
					return false;
				}
			});		
		
	}
}

<!--



//Disable right mouse click Script

//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive

//For full source code, visit http://www.dynamicdrive.com


// --> 
</script>