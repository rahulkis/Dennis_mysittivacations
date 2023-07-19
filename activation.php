<?php
include("Query.Inc.php");
include('constant.php');
$Obj = new Query($DBName);

$titleofpage = "Account Verification";
include('header_start.php');
include('header.php');
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$msg = '';

if(!empty($_GET['code']) && isset($_GET['code']))
{
	$code = mysql_real_escape_string($_GET['code']);
	$c = mysql_query("SELECT id FROM clubs WHERE activation_code = '".$code."'");
	
	if(mysql_num_rows($c) > 0)
	{
		
		$count = mysql_query("SELECT * FROM clubs WHERE activation_code = '".$code."' and status = '0'");
	
			if(mysql_num_rows($count) == 1)
			{
				
				mysql_query("UPDATE clubs SET status = '1' WHERE activation_code = '".$code."'");
				
				$msg = "Your account is activated. Please check your email for login credentials";
				
				$get_club_data = mysql_fetch_assoc($count);
				
				$base_url = "https://" . $_SERVER['SERVER_NAME']."/";
				$club_email = $get_club_data['club_email'];
				$password = $get_club_data['password'];
				$club_pass = $get_club_data['club_pass'];
				
				$username = $get_club_data['club_name'];
				$pieces = explode(" ", $username);
				$username_dash_separated = implode("-", $pieces);
				$name_club = $username_dash_separated;
				$getPlan = $get_club_data['plantype'];
				include("email_sent_to_host.php");
			
			}
			else
			{
				
				$msg = "Your account is already active, no need to activate again";
			
			}
	
	}
	else
	{
		
		$msg = "Wrong activation code.";
		
	}

}

?>
<style>
header,
#footer {
 display:none;
}
.outerActivation {
 width:100%;
 position:fixed;
 height:100%;
 left:0;
 right:0;
 top:0;
 bottom:0;
 background:#ccc;
}
.small_logo {
  text-align: center;
  margin-bottom:15px;
}

.innerCurrentCity1 {  margin-top: 160px;  text-align: center;  width: 75%;}
</style>
<div class="outerActivation">
  <div class=" ">
    <div class="main_home">
      <div class="thankyou">
        <div class="thankyou_inner">
          <div class="small_logo">  <a href="<?php echo $SiteURL;?>"><img alt="" src="https://mysittidev.com/images/v2_logo_round.png"></a> </div>
          <div id="title_thankyou">Account Verification !</div>
          <div class="thankyu_box">
            <h1>
              <p><?php echo $msg; ?></p>
            </h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('footer.php'); ?>
