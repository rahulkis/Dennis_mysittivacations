<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

$titleofpage="Payment Mode";


unset($_SESSION['signup_ValueArray_host']);
unset($_SESSION['signup_FieldArray_host']);
$ThisPageTable = 'clubs';
$base_url = "https://" . $_SERVER['SERVER_NAME']."/";

if(isset($_POST['submit']))
{
//echo "<pre>"; print_r($_POST); exit;
	/**** get plan details ****/

	$club_email=$_POST['email'];
	$type_of_club = $_POST['host_category'];

	$postedPlan = explode("-", $_POST['host_plan']);



		
	$get_plan_details_query = mysql_query("SELECT package_id FROM packages WHERE value = '".$postedPlan[0]."'");
	$plan_data = mysql_fetch_assoc($get_plan_details_query);
	$plan = $postedPlan[0];



	if(!isset($_POST['host_plan']))
	{
		
		$plan = "host_free";
	}
	elseif(empty($plan))
	{
		$plan = "host_free";
	}

	$checkClubEmail = mysql_query("SELECT `id` FROM `clubs` WHERE `club_email` = '$club_email'  ");
	if(mysql_num_rows($checkClubEmail) > 0)
	{
		header("Location: index.php?plan=".$plan."&msg=duplicate&t=".$type_of_club);
		die;
	}


	$plan_id = $plan_data['package_id'];
	$errors ="";
	if(empty($errors))
	{
		if($_POST['submit'] = 'Continue')
		{
			
			$country=$_POST['country'];
			$state=$_POST['state'];
			$city=$_POST['city_name'];
			$zipcode=$_POST['zipcode'];
			//$source=$_POST['source'];

			if(!empty($_POST['other_source']))
			{
				$source = $_POST['other_source'];
				@mysql_query("INSERT INTO `source` (`name`) VALUES ('".$source."') ");
			}
			else
			{
				$source = $_POST['source'];
			}
		
			$address = str_replace(" ", "", $zipcode);
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$i = 0;

			foreach($response_a->results[0]->address_components as $abc)
			{
				if($abc->types[0] == "country")
				{
					$country = $response_a->results[0]->address_components[$i]->long_name;
				}
				
				if($abc->types[0] == "administrative_area_level_1")
				{
					$state = $response_a->results[0]->address_components[$i]->long_name;
				}

				if($abc->types[0] == "locality")
				{
					$city = $response_a->results[0]->address_components[$i]->long_name;
				}


				$i++;


			}

			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;	
			$formatted_address = trim($response_a->results[0]->formatted_address);	

			$sq_id=mysql_query("select id from clubs order by id desc limit 1 ");
			$sq_newid= mysql_fetch_array($sq_id);
			$id1=$sq_newid['id'] + 1;
			$name_club= mysql_real_escape_string($_POST['profilename']);
			
			
			$type_details_of_club = '';
		
			if(isset($_POST['subcat']) )
			{			
				$type_details_of_club = implode(",", $_POST['subcat']);		
			}
			$club_add=mysql_real_escape_string($_POST['street']);
			$first_name=$_POST['first_name'];
			$last_name=$_POST['last_name'];
			$club_google_map=$_POST['club_google_map'];
			
			$club_pass=generatePassword(10);
			$phone=$_POST['phone1'];
			$password=$_POST['password'];
			$club_google_map = '<iframe src="http://maps.google.com/?q='.$lat.','.$long.' scrolling=yes frameborder=0"></iframe>';
			
			$status = 0;
			
			$DataArray1 = $Obj->Select_Dynamic_Query($ThisPageTable,'',array('club_email'),array('='),array($club_email),'','','','');

			$checkusername = mysql_query("SELECT `id` FROM `clubs` WHERE `club_name` = '$name_club'  ");
			$checkCount = mysql_num_rows($checkusername);


			if(strcmp($club_email,$DataArray1[0]['club_email']) == 0)
			{
				header("Location: index.php?plan=".$plan."&msg=duplicate&t=".$type_of_club);
				die;
			}
			else
			{ 

				$getcountryid = @mysql_query("SELECT * FROM `country` WHERE `name` = '$country' ");
				$councnt = @mysql_num_rows($getcountryid);

				$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$state' ");
				$counstate = @mysql_num_rows($getstateid);

				$getcityid = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` = '$city' ");
				$countcity = @mysql_num_rows($getcityid);

				if($councnt > 0 )
				{
					$fetchcoutry = @mysql_fetch_array($getcountryid);
					$country = $fetchcoutry['country_id'];
				}
				else
				{
					@mysql_query("INSERT INTO `country` (`name`,`iso_code_2`,`iso_code_3`,`status`) VALUES ('$country','$iso_code_2','','1') ");
					$getcountry  = @mysql_query("SELECT * FROM `country` WHERE `name` = '$country' ");
					$fetchcoutry = @mysql_fetch_array($getcountry);
					$country = $fetchcoutry['country_id'];
				}


			
				if($counstate > 0 )
				{
					$fetchstate = @mysql_fetch_array($getstateid);
					$state = $fetchstate['zone_id'];
				}
				else
				{
					@mysql_query("INSERT INTO `zone` (`name`,`country_id`,`code`,`status`) VALUES ('$state','$country','$statecode','1') ");
					$getstate  = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$state' ");
					$fetchstate = @mysql_fetch_array($getstate);
					$state = $fetchstate['zone_id'];
				}
			

			
				if($countcity > 0 )
				{
					
					$fetchcity = @mysql_fetch_array($getcityid);
					$city = $fetchcity['city_id'];
				}
				else
				{
					
					@mysql_query("INSERT INTO `capital_city` (`city_name`,`state_id`,`refresh`) VALUES ('$city','$state','') ");
					$getstate  = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` = '$city' ");
					$fetchcity = @mysql_fetch_array($getstate);
					$city = $fetchcity['city_id'];
				}
				$club_add = $club_add." ".$formatted_address;
				$now = date('Y-m-d h:i:s');
				$ValueArray = array($now,$first_name,$last_name,$name_club,$club_pass,$type_of_club,$type_details_of_club,$club_email,$password,$source,$club_add,$phone,$country,$state,$city,$zipcode,$club_google_map,$status,$plan,$long,$lat);
				$FieldArray = array('club_add_date','first_name','last_name','club_name','club_pass','type_of_club','type_details_of_club','club_email','password','hear_about','club_address','club_contact_no','club_country','club_state','club_city','zip_code','google_map_url','status','plantype','longitude','latitude');
			
		
				unset($_SESSION['signup_ValueArray_host']);
				unset($_SESSION['signup_FieldArray_host']);
				$_SESSION['signup_ValueArray_host'] = $ValueArray ;
				$_SESSION['signup_FieldArray_host'] = $FieldArray ;
				//$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				$Success =1;
				
				$packagequery = @mysql_query('SELECT * FROM `packages` WHERE `package_id` = "'.$plan_id.'"');
				$fetchpackagearray = @mysql_fetch_array($packagequery);
				//echo "<pre>";print_r($fetchpackagearray); exit;
				$plan_duration = "";
				if($Success > 0)
				{
					if($plan=='host_silver')
					{
						
						$query = array();
						
						if($postedPlan[1] == "M")
						{
							$plan_duration = "monthly";
							$query['a1'] = '0.01';
							$query['p1'] = '1';
							$query['t1'] = 'M';
							$query['a3'] = $fetchpackagearray['amount'];
							$query['p3'] = '1';
							$query['t3'] = 'M';

						}
						elseif($postedPlan[1] == "Y")
						{
							$plan_duration = "annually";
							$query['a3'] = $fetchpackagearray['annually'];
							$query['p3'] = '1';
							$query['t3'] = 'Y';
						}


						$query['notify_url'] = $base_url.'ipn.php';
						$query['cmd'] = '_xclick-subscriptions';
						$query['no_shipping'] ="1";	
						$query['business'] = PAYPAPOWNERID;
						$query['lc'] = 'US';
						//$query['item_name'] = "Pro Host Membership plan for mysitti";
						$query['item_name'] = "Host Silver plan for mysitti";
						$query['no_note'] = '1';
						$query['src'] = '1';
						
						
						$query['rm'] = '2';
						$query['address_override'] = '1';
						$query['currency_code'] = 'USD';
						$query['return'] = $base_url.'host-plan-payment.php';
						$query['cancel'] = $base_url.'host-plan-payment.php';
						$query_string = http_build_query($query);
						//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
						$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;
						//$paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
					
					}
					else if($plan=='host_gold')
					{
						
						$query = array();
						$query['notify_url'] = $base_url.'ipn.php';
						$query['cmd'] = '_xclick-subscriptions';
						$query['no_shipping'] ="1";	
						$query['business'] = PAYPAPOWNERID;
						$query['lc'] = 'US';
						//$query['item_name'] = "Basic Host Membership plan for mysitti get 1 month free";
						$query['item_name'] = "Host Gold plan for mysitti";
						$query['no_note'] = '1';
						$query['src'] = '1';
						// $query['a1'] = '0.01';
						// $query['p1'] = '1';
						// $query['t1'] = 'M';
						// $query['a3'] = $fetchpackagearray['amount'];
						// //$query['a3'] = '0.01';
						// $query['p3'] = '1';
						// //$query['p3'] = '5';
						// $query['t3'] = 'M';

						if($postedPlan[1] == "M")
						{
							$plan_duration = "monthly";
							$query['a1'] = '0.01';
							$query['p1'] = '1';
							$query['t1'] = 'M';
							$query['a3'] = $fetchpackagearray['amount'];
							$query['p3'] = '1';
							$query['t3'] = 'M';
						}
						elseif($postedPlan[1] == "Y")
						{
							$plan_duration = "annually";
							$query['a3'] = $fetchpackagearray['annually'];
							$query['p3'] = '1';
							$query['t3'] = 'Y';
						}

						$query['rm'] = '2';
						$query['address_override'] = '1';
						$query['currency_code'] = 'USD';
						$query['return'] = $base_url.'host-plan-payment.php';
						$query['cancel'] = $base_url.'host-plan-payment.php';
						$query_string = http_build_query($query);
						//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);	
						$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;
						//$paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
					
					}
					elseif($plan=='host_platinum')
					{
						
						$query = array();
						$query['notify_url'] = $base_url.'ipn.php';
						$query['cmd'] = '_xclick-subscriptions';
						$query['no_shipping'] ="1";	
						$query['business'] = PAYPAPOWNERID;
						$query['lc'] = 'US';
						//$query['item_name'] ="Basic Host Membership plan for mysitti get 2 month free";
						$query['item_name'] ="Host Platinum plan for mysitti";
						$query['no_note'] = '1';
						$query['src'] = '1';
						// $query['a1'] = '0.01';
						// $query['p1'] = '1';
						// $query['t1'] = 'M';
						// $query['a3'] = $fetchpackagearray['amount'];
						// //$query['a3'] = '0.01';
						// $query['p3'] = '1';
						// //$query['p3'] = '5';
						// $query['t3'] = 'M';


						if($postedPlan[1] == "M")
						{
							$plan_duration = "monthly";
							$query['a1'] = '0.01';
							$query['p1'] = '1';
							$query['t1'] = 'M';
							$query['a3'] = $fetchpackagearray['amount'];
							$query['p3'] = '1';
							$query['t3'] = 'M';
						}
						elseif($postedPlan[1] == "Y")
						{
							$plan_duration = "annually";
							$query['a3'] = $fetchpackagearray['annually'];
							$query['p3'] = '1';
							$query['t3'] = 'Y';
						}


						$query['rm'] = '2';
						$query['address_override'] = '1';
						$query['currency_code'] = 'USD';
						$query['return'] = $base_url.'host-plan-payment.php';
						$query['cancel'] = $base_url.'host-plan-payment.php';
						$query_string = http_build_query($query);
						// header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
						$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;
						//$paypalurl = 'https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
					
					}
					elseif($plan=='host_free')
					{				
						$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
						if(!empty($club_email))
						{
							// username and password sent from Form
							$email = mysql_real_escape_string($club_email);
							
							
							$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
							if(isset($_POST['popsignup']))
							{
								$sql = "select * from `clubs` where `club_email` = '".$email."' ";
								$DataArray = $Obj->select($sql) ;

								$pieces = explode(" ", $DataArray[0]['club_name']);
								$username_dash_separated = implode("-", $pieces);
								
								$UserLoginId = $DataArray[0]['id'] ;
								$User = "Club";
								$_SESSION['user_id'] = $UserLoginId ;
								$_SESSION['user_club'] = $User ;
								$_SESSION['user_type'] = 'club';
								$_SESSION['username'] = $username_dash_separated ;
								$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
								$_SESSION['keepmelogin'] = $keepmelogin;
								$_SESSION['id']=$DataArray[0]['club_city'];// here we are storing city id of logged user
								$_SESSION['state']=$DataArray[0]['club_state']; // here we are storing state id of logged user
								$_SESSION['country']=$DataArray[0]['club_country'];
								$_SESSION['hostType']=$DataArray[0]['type_of_club'];
								//date_default_timezone_set('America/Los_Angeles');
								$current_time= date('Y-m-d H:i:s'); 
								$tdate=date('Y-m-d H:i:s');
								mysql_query("update clubs set status='1',is_online='1', keepmelogin = '".$keepmelogin."' ,logged_date='".$tdate."' where id='".$UserLoginId ."'");
											
						                	$get_city_status_data = @mysql_query("SELECT * FROM default_city_selected WHERE user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."'");
					               	 	$count_c_status = mysql_num_rows($get_city_status_data);
						                
						                	if($count_c_status > 0)
						                	{
						                    
									$get_status_data = mysql_fetch_assoc($get_city_status_data);

									unset($_SESSION['id']);
									unset($_SESSION['state']);
									unset($_SESSION['country']);

									$_SESSION['id'] = $get_status_data['city'];// here we are storing city id of logged user
									$_SESSION['state'] = $get_status_data['state']; // here we are storing state id of logged user
									$_SESSION['country'] = $get_status_data['country'];
						                    
						                	}                    
			                
								session_write_close();
								$Obj->Redirect("live_host_contests.php");
								die;
								
							}
							else
							{
								if(preg_match($regex, $email))
								{
									$activation = md5($email.time()); // Encrypted email+timestamp
									
									$count = mysql_query("SELECT id FROM clubs WHERE club_email = '".$email."'");
									
									if(mysql_num_rows($count) > 0)
									{
									
										mysql_query("UPDATE clubs SET activation_code = '".$activation."' WHERE club_email = '".$email."'");
										
										$str = "
											<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px'>
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
									}
								}
							}
						}				
						
						unset($_SESSION['signup_ValueArray_host']);
						unset($_SESSION['signup_FieldArray_host']);				
						//include("email_sent_to_host.php");
						$Obj->Redirect('thankyou.php');
						die;
					}
				}
				else
				{
					header("location: index.php?msg=failed");
				}
			}
		}	
		else
		{
			header("location: index.php?msg=failed");
		}
	}
}
if(isset($_POST['upgrade_submit']))
{
	$query['a3']=$_POST['amount'];
	$paypalurl=$_POST['paypal'];
	$upgradeorfresh=$_POST['upgradeorfresh'];
	
}	


$_SESSION['plan_duration'] = $plan_duration;


include('headhost.php'); 
include('header.php'); 	
?>
<style type="text/css">
.paymentmodes div.AuthorizeNetSeal {
	float: left;
	width: 45%;
}
.paymentmodes div#payPalButton {
	float: left;
	width: 45%;
}
</style>
<div id="wrapper" class="space home_wrapper">
  <div class="main_home">
	<div class="content1">
	  <div id="title_pay" class="botmbordr">Choose Payment Method to make purchase of <?php echo $query['a3']; ?></div>
	  <div class="paymentmodes">
		<!-- <h2 id="title_paypal">Pay with paypal</h2> -->
		<br>
		<div id="payPalButton">
			<a href="<?php echo $paypalurl;?>" ><img src="images/paypal-btn.png" alt="Pay with Paypal" /></a> 
		</div>
		<div style=" float: left;width:10%;text-align: center;">
			<div class="oor">OR</div>
	  	</div>
		<div class="AuthorizeNetSeal" id="authorizeNetButton"> 
			<script type="text/javascript" language="javascript">var ANS_customer_id="3516696b-0575-4981-ba9a-84a96fa71d98";</script>
			<script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
	   	 	<!-- <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Credit Card Merchant Services</a> -->
	   	</div>

		
	</div>
	  
	  <!-- (c) 2005, 2015. Authorize.Net is a registered trademark of CyberSource Corporation --> 
	   



	  <div class="cardsselect spacer_card" style="display: none;"> 
		<!--<a href="javascript:void(0);" onclick="authnetpay();"><img src="../images/payment-authorize.net.png" alt="Pay with Authorize.Net" /></a>-->
		
		<div><img src="images/visa.png" alt="Pay with Visa" /><br />
		  <input onclick="authnetpay(this.value);" type="radio" value="Visa" name="Visa" id="byvisa" />
		</div>
		<div><img src="images/mastercard.png" alt="Pay with Master Card" /><br />
		  <input onclick="authnetpay(this.value);" type="radio" value="MasterCard" name="Master" id="bymaster" />
		</div>
		<div><img src="images/americanexpress.png"  alt="Pay with American Express" /><br />
		  <input type="radio" onclick="authnetpay(this.value);" value="AmericanExpress" name="american" id="byamerican" />
		</div>
		<div><img src="images/dinerclub.png" alt="Pay with Diners Club" /><br />
		  <input type="radio" onclick="authnetpay(this.value);" value="DinersClub" name="diner" id="bydinerclub" />
		</div>
	  </div>
	  <script type="text/javascript" src="telephone.js"></script>
	  <div id="authopayform" style="display:none">
		<h4 class="ttl_small">Payment Details</h4>
		<form action="Authorize/subscription_create.php" method="POST" class="paypalform">

		  <div class="leftone"> Cardholder First Name: </div>
		  <div class="rightone">
			<input type="text" name="firstName" />
		  </div>
		  <div class="leftone"> Cardholder Last Name: </div>
		  <div class="rightone">
			<input type="text" name="lastName" />
		  </div>
		  <div class="leftone"> Card Number: </div>
		  <div class="rightone">
			<input name="cardNumber" type="text" />
		  </div>
		  <div class="leftone"> Expiration Date: <span style=" font:8pt arial;">[ MM-YYYY ]</span> </div>
		  <div class="rightone">
			<input id="cardexpiryDate" name="expirationDate" class="sel" type="text" />
		  </div>
		  <div class="leftone"> Amount: </div>
		  <div class="rightone">
			<input type="text" readonly="readonly" name="amount" value='<?php echo $query['a3']; ?>' />
		  </div>
		  <div class="leftone"></div>
		  <div class="rightone">
			<input type="hidden" readonly="readonly" name="startDate" value='<?php echo date('Y-m-d'); ?>'>
		  </div>
		  <?php 
							$dd = date('Y-m-d H:i:s');
							$reference = strtotime($dd);

						?>
		 <div class="leftone"> &nbsp; </div>
		  <div class="rightone">
		  	<input type="hidden" name="name" value='<?php echo $fetchpackagearray['package_name'];?> Membership'>
		  	<?php 
		  		if($postedPlan[1] == "M")
		  		{
		  	?>
					<input type="hidden" name="trialOccurrences" value='1'>
					<input type="hidden" name="trialAmount" value='0.01'>
					<input type="hidden" name="length" value='1'>
					<input type="hidden" name="unit" value='months'>
			<?php 	}
				elseif($postedPlan[1] == "Y")
				{
			?>		
					<input type="hidden" name="length" value='365'>
					<input type="hidden" name="unit" value='days'>
			<?php	}	?>
			
			
			<input type="hidden" name="upgradeorfresh" type="<? echo $upgradeorfresh;?> " />
			<input type="hidden" name="cardtype" value="" id="selectedcard" />
			<input type="hidden" name="totalOccurrences" value='999'>
			<input type="hidden" name="refId" value='<?php echo $reference; ?>'>
			<!-- <input type="submit" name="submit" value="Submit"> -->
			<input name="submit" class="button_pay" type="submit" style="border:1px outset gray; width:100px;" value="Pay Now" />
		  </div>
		  <div class="clear"></div>
		</form>
	  </div>
	  <div class="clear"></div>
	</div>
  </div>
</div>
</div>
<style type="text/css">
.leftbox, .rightbox {
float: left;
width: 50%;
}
.leftone, span
{
	color: rgb(254, 205, 7);
	margin: 10px 0;
}
.paymentmodes
{
	float: left;
	width:100%;
	text-align: center;
}

.paymentmodes > a
{
	float: left;
	width:100%;
}

.cardsselect {
float: left;
width: 100%;
margin: 5% 0;
text-align: center;
}

.cardsselect div {
float: left;
width: 25%;
}

</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#authorizeNetButton').find('img').click(function(){
		$('.cardsselect').show();
	});
});

function authnetpay(valuecard)
{
	
	//var getcheckvalue = $(this).val(); 
	$('#authopayform').fadeIn('slow');
	$('input#selectedcard').val(valuecard);

	$('.cardsselect').find('input[type="radio"]').each(function(){
		if($(this).val() == valuecard)
		{
			$(this).attr('checked', true);
		}
		else
		{
			$(this).attr('checked', false);	
		}
	});

}

</script>
<?
include('footer.php');
?>
