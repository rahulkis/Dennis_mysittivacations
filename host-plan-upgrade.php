<?
include("Query.Inc.php") ;
include('constant.php');
$Obj = new Query($DBName) ;
$ThisPageTable = 'clubs';

ini_set("display_errors", "1");
error_reporting(E_ALL);

if(empty($_SESSION['userUpgrade']) ){
	
	header('Location: index.php');
	
}

// echo "<pre>"; print_r($_POST);
// print_r($_GET);
// print_r($_REQUEST);
  
if(isset($_GET['st']))
{
	
	if($_GET['st']=="Completed")
	{


//echo "UPDATE `clubs` SET `subscription_id` = '$_GET[tx]', `plantype` = '".$_SESSION['userUpgrade']['plan']."', `payment_mode` = 'Paypal' WHERE `id` = '".$_SESSION['userUpgrade']['hostID']."' "; exit;

		mysql_query("UPDATE `clubs` SET `subscription_id` = '$_GET[tx]', `plantype` = '".$_SESSION['userUpgrade']['plan']."', `payment_mode` = 'Paypal' WHERE `id` = '".$_SESSION['userUpgrade']['hostID']."' ");
		$sql = "SELECT * FROM `clubs` WHERE `id` = '".$_SESSION['userUpgrade']['hostID']."' ";
			$DataArray = $Obj->select($sql);
			$CountDataArray = count($DataArray);
			$lastinsertid = $_SESSION['userUpgrade']['hostID'];
			$club_email = $DataArray[0]['club_email'];
			if(!empty($club_email))
			{
				// username and password sent from Form
				$email = mysql_real_escape_string($club_email);
				$base_url = "https://" . $_SERVER['SERVER_NAME']."/";
				
				$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
				
				if(preg_match($regex, $email))
				{


						$str = "
							<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
								<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
								<hr>
								<p style='color: white;'>
									<br />
										Your Plan is successfully Upgraded. Please recheck the upgraded functions and let us know if you having any issues while accessing them.
									<br /><br />
								</p>
							</div>
						 ";
						
						$message = $str; 
						$to  = $email;
						
						$subject = "Plan Upgradation";
						$message = $str;
						//$from = "info@mysitti.com";
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: MySitti <mysitti@mysitti.com>' . "\r\n";
						//$headers .= "From:" . $from;
						
						mail($to,$subject,$message,$headers,"-finfo@mysitti.com");
						//echo "test Mail Sent.";
				
				}
			
			
			}

            		unset($_SESSION['userUpgrade']);
			// unset($_SESSION['userUpgrade']['plan']);
			header('Location: thankyou.php?action=upgrade');
			
			die();
		//}
			
	}

}
else
{
	$Obj->Redirect('errorpayment.php'); die;
}

?>
