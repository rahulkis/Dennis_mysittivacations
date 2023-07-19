<?
include("Query.Inc.php") ;
include('constant.php');
$Obj = new Query($DBName) ;
$ThisPageTable = 'clubs';

ini_set("display_errors", "1");
error_reporting(E_ALL);

if(empty($_SESSION['signup_ValueArray_host']) && empty($_SESSION['signup_FieldArray_host'])){
	
	header('Location: index.php');
	
}

// echo "<pre>"; print_r($_POST);
// print_r($_GET);
// print_r($_REQUEST);

if(isset($_GET['st']))
{
	
	if($_GET['st']=="Completed")
	{

		$countvalueArray = count($_SESSION['signup_ValueArray_host']);
		$countfieldArray = count($_SESSION['signup_FieldArray_host']);

		$_SESSION['signup_FieldArray_host'][] = "payment_mode";
		$_SESSION['signup_ValueArray_host'][] = "Paypal";
	 	$_SESSION['signup_FieldArray_host'][] = "subscription_id";
		$_SESSION['signup_ValueArray_host'][] = $_GET['tx'];
		$_SESSION['signup_FieldArray_host'][] = "plan_duration";
		$_SESSION['signup_ValueArray_host'][] = $_SESSION['plan_duration'];

		

		$ValueArray = $_SESSION['signup_ValueArray_host'];
		$FieldArray = $_SESSION['signup_FieldArray_host'];
		
		//echo "<pre>"; print_r($ValueArray); print_r($FieldArray); die('HERE');
		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);

		if($Success > 0)
		{
			$club_email=$_SESSION['signup_ValueArray_host'][7];
			$password=$_SESSION['signup_ValueArray_host'][4];
			$sql = "select * from `clubs` where `club_email` = '".$club_email."' && `password` = '".$password."' && status='0'";

			$DataArray = $Obj->select($sql);
			$CountDataArray = count($DataArray);
			$lastinsertid = $DataArray[0]['id'];

			if($lastinsertid)
			{
				$cat1=CAT1;
				$cat2=CAT2;
				@mysql_query("INSERT INTO `host_category` (`id`, `host_id`, `category_name`, `status`, `created_date`) VALUES (NULL, '$lastinsertid', '$cat1', '1', 'now()'), (NULL, '$lastinsertid', '$cat2', '1', 'now()')");
			}
			if(!empty($club_email))
			{
				// username and password sent from Form
				$email = mysql_real_escape_string($club_email);
				$base_url = "https://" . $_SERVER['SERVER_NAME']."/";
				
				$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
				
				if(preg_match($regex, $email))
				{
					$activation = md5($email.time()); // Encrypted email+timestamp
					
					$count = mysql_query("SELECT id FROM clubs WHERE club_email = '".$email."'");
					
					if(mysql_num_rows($count) > 0)
					{
					
					mysql_query("UPDATE clubs SET activation_code = '".$activation."' WHERE club_email = '".$email."'");
						
						$str = "
							<div style='background-color: rgb(0, 0, 0); padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
								<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
								<hr>
								<p style='color: white;'>
									<br />
						Welcome to the MYSITTI family and be a part of the next social revolution.  Visit MYSITTI.com where we are 
						<br />MAKING EVERY CITY YOUR CITY!
									<br /><br />
									
						We need to make sure you are human. Please verify your email and get started using Mysitti Website account. <br/> <br/> <a href=".$base_url."activation.php?code=".$activation.">".$base_url."activation/".$activation."</a>
								</p>
							</div>
						 ";
						
						$message = $str; 
						$to  = $email;
						
						$subject = "Mysitti Email verification";
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
			
			
			}
			
			
			
			unset($_SESSION['signup_ValueArray_host']);
            		unset($_SESSION['signup_FieldArray_host']);
			unset($_SESSION['plan_duration']);
			header('Location: thankyou.php');
			
			die();
		}
			
	}

}
else
{
	$Obj->Redirect('errorpayment.php'); die;
}

?>
