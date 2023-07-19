<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Thank You";
if(isset($_SESSION['user_id']))
{
 	include('LoginHeader.php');
}
else
{
 	include('Header.php');
}


$USERMail = $_SESSION['dataActivation'];

$CheckUser = mysql_query("SELECT * FROM `clubs` WHERE `club_email` = '$USERMail' ");
if(mysql_num_rows($CheckUser) == 0)
{
	$CheckUser = mysql_query("SELECT * FROM `user` WHERE `email` = '$USERMail' ");
	
}
$fetchResult = mysql_fetch_assoc($CheckUser);
$md5Password = $fetchResult['password_md5'];

?>

<div class="clear"></div>
<div class="v2_container">
  <div class="v2_inner_main">
    <div class="home_wrapper">
      <div class="main_home">
        <div class="thankyou">
          <?php if(isset($_GET['action']) )
			{
		?>
          <div class="thankyou_inner">
            <div id="title_thankyou">Your Plan Upgraded Successfully!</div>
            <div class="thankyu_box">
              <h1>Thank you for Upgrading your plan.</h1>
              <p> Please check your email, including the junk/spam folder, for a confirmation message. </p>
            </div>
          </div>
          <?php
			}elseif(isset($_GET['stps']) && $_GET['stps'] == 'true'){
					
					$check_ticket = mysql_query("SELECT * FROM streaming_tickets_purchased WHERE ticket_id = '".$_GET['ticket_id']."' AND buyer_user_id = '".$_SESSION['user_id']."' AND buyer_user_type = '".$_SESSION['user_type']."'");
					$count_rows = mysql_num_rows($check_ticket);
					
					if($count_rows < 1){
						
						$buyer_code = rand().date('YmdHis');
						$purchase_date = date('Y-m-d H:i:s');
						
						mysql_query("INSERT INTO streaming_tickets_purchased (`ticket_id`, `buyer_code`, `buyer_user_id`, `buyer_user_type`, `purchase_date`, `event_id`) VALUES ('".$_GET['ticket_id']."', '".$buyer_code."', '".$_SESSION['user_id']."', '".$_SESSION['user_type']."', '".$purchase_date."', '".$_GET['event_id']."')");
						
						
						$inc_counter = mysql_query("SELECT total_downloads FROM streaming_tickets WHERE ticket_id = '".$_GET['ticket_id']."'");
						$get_inc_counter = mysql_fetch_assoc($inc_counter);
						$inc_counter_increase = $get_inc_counter['total_downloads'] + 1;
						
						mysql_query("UPDATE streaming_tickets SET total_downloads = '".$inc_counter_increase."' WHERE ticket_id = '".$_GET['ticket_id']."'");
					?>
          <div class="thankyou_inner">
            <div id="title_thankyou">You Purchased The Ticket Successfully</div>
            <div class="thankyu_box">
              <h1>Thank you.</h1>
              <!--<p> Please check your email, including the junk/spam folder, for a confirmation message. </p>--> 
            </div>
          </div>
          <?php }else{ ?>
          <div class="thankyou_inner">
            <div id="title_thankyou">You Already Purchased The Ticket</div>
            <div class="thankyu_box">
              <h1>Thank you.</h1>
              <!--<p> Please check your email, including the junk/spam folder, for a confirmation message. </p>--> 
            </div>
          </div>
          <?php }
			  
			}else{
		?>
          <div class="thankyu_box">
            <div class="thankyou_inner"> <img src="images/chk.png" alt="" align="center" />
              <div id="title_thankyou">Verify Your Account!</div>
              <h1>Thank you for your registration.</h1>
              <p> Please check your email, including the junk/spam folder, for a confirmation message. <br/>
                Click on the link to confirm your registration.</p>
              <div class="seperatorOR">OR</div>
              <form method="POST" action="<?php echo $SiteURL;?>main/login.php">
                <div class="ActivationText bookingsType"> Click the Activate button to get started. <br />
                  <br />
                  <input type="submit" name="submit" class="bookTick" value="Activate">
                  <input type="hidden" name="uname" class="valid" value="<?php echo $USERMail;?>" />
                  <input type="hidden" name="frompage" value="ThankYou" />
                  <input type="hidden" name="password" id="password2" value="<?php echo $md5Password; ?>" />
                </div>
              </form>
            </div>
            <div class="clear"></div>
          </div>
          <?php  }	
		unset($_SESSION['dataActivation']);
		?>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">

#v2_wrapper {
  background: rgba(0, 0, 0, 0) url("../images/noice.png") repeat scroll center center;
  float: left;
  padding-top: 47px;
  width: 100%;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
}
.thankyu_box h1 {
  color: #0dd808;
  display: block;
  float: left;
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 10px;
  padding: 0px 0;
  position: relative;
  text-align: center;
  width: 100% !important;
}

.thankyu_box p {
  color: #000;
  font-size: 15px;
  line-height: 29px;
  text-align: center;
}
.thankyou_inner > form {margin:0;}
#title_thankyou {
  color: #000;
  float: left;
  font-size: 22px;
  padding: 20px 0;
  text-align: center;
  width: 100%;
}
	.seperatorOR
	{
		padding: 15px;
		font-size: 20px;
		font-weight: bold;
		color: #000;
	}
	.ActivationText
	{
		color: #000;
		float: left;
		text-align: center;
		width: 100%;
		background: none;
		font-size: 20px;
	}
.bookTick {
  display: inline-block !important;
  float: none !important;
  font-size: 25px !important;
  padding: 10px 30px !important;
  width: auto !important;
  z-index: 0 !important;
}
  .thankyu_box {
  background: #f7f7f7 none repeat scroll 0 0;
  border: 4px solid #fff;
  border-radius: 4px;
  box-shadow: 0 0 4px #5d5d5d;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
 margin:0px auto;
  padding: 20px 0;
  text-align: center;
  width: 100%;
  margin-bottom:20px;
  max-width:900px;
  display:table;
}
.v2_header.fordesk {
  display: none;
}
.v2_banner_top {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
}
.v2_brand {
  float: left;
  max-width: 100%;
  text-align: center;
  width: 100%;
}
.v2_get_started { 
  display: none; 
}
</style>
<?php  include('Footer.php') ?>
