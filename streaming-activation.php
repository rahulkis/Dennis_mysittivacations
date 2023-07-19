<?php
include("Query.Inc.php");
include('constant.php');
$Obj = new Query($DBName);

$titleofpage = "Streaming Verification";
include('header_start.php');
include('header.php');

$msg = '';

if(!empty($_GET['code']) && isset($_GET['code']))
{
	$code = mysql_real_escape_string($_GET['code']);
	$c = mysql_query("SELECT id FROM battle_settings WHERE activation_code = '".$code."'");
	
	if(mysql_num_rows($c) > 0)
	{
		//echo "SELECT * FROM battle_settings WHERE activation_code = '".$code."' and status = 'pending'";
		$count = mysql_query("SELECT * FROM battle_settings WHERE activation_code = '".$code."' and status = 'pending'");
	
			if(mysql_num_rows($count) == 1)
			{
				
				mysql_query("UPDATE battle_settings SET status = 'accepted' WHERE activation_code = '".$code."'");
				
				$msg = "Your streaming is activated. Please start the streaming at given time.";
				
				//$get_club_data = mysql_fetch_assoc($count);
				//
				//$base_url = "https://" . $_SERVER['SERVER_NAME']."/";
				//$club_email = $get_club_data['club_email'];
				//$password = $get_club_data['password'];
				//$club_pass = $get_club_data['club_pass'];
				//
				//$username = $get_club_data['club_name'];
				//$pieces = explode(" ", $username);
				//$username_dash_separated = implode("-", $pieces);
				//$name_club = $username_dash_separated;
				//$getPlan = $get_club_data['plantype'];
				//include("email_sent_to_host.php");
			
			}
			else
			{
				
				$msg = "Your already accepted the streaming request, no need to activate again";
			
			}
	
	}
	else
	{
		
		$msg = "Wrong activation code.";
		
	}

}

?>

<div class="home_wrapper">
  <div class="main_home">
    <div class="thankyou">
      <div class="thankyou_inner">
        <div id="title_thankyou">Streaming Verification !</div>
        <div class="thankyu_box">
          <h1> <p><?php echo $msg; ?></p></h1>
         
        </div>
      </div>
    </div>
  </div>
</div>


    <?php include('footer.php'); ?>