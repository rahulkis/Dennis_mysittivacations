<?php

require 'mailwizz_setup.php';
$endpoint = new MailWizzApi_Endpoint_ListSubscribers();

include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

$titleofpage="Payment Page";
//include('header_start.php'); 
include('Header.php'); 

session_start();


if(isset($_POST['UserType']) && $_POST['UserType'] != 'user' )
{

	/**** get plan details ****/
$ThisPageTable = 'clubs';
	$club_email=$_POST['email'];
	$type_of_club = $_POST['host_category'];

	$postedPlan = explode("-", $_POST['host_plan']);



		
	$get_plan_details_query = mysql_query("SELECT package_id FROM packages WHERE value = '".$postedPlan[0]."'");
	$plan_data = mysql_fetch_assoc($get_plan_details_query);
	$plan = $postedPlan[0];



	// if(!isset($_POST['host_plan']))
	// {
		
	// 	$plan = "host_free";
	// }
	// elseif(empty($plan))
	// {
	// 	$plan = "host_free";
	// }

	$plan = 'host_platinum';



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
			$city=$_POST['city'];
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
		
			if(empty($zipcode))
			{
				$getcountryid = @mysql_query("SELECT * FROM `country` WHERE `country_id` = '$country' ");
				$councnt = @mysql_num_rows($getcountryid);

				if($councnt > 0 )
				{
					$fetchcoutry = @mysql_fetch_array($getcountryid);
					$countryName = $fetchcoutry['name'];
					$countryCode = $fetchstate['iso_code_3'];
				}



				$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '$state' AND `country_id` = '$country' ");
				$counstate = @mysql_num_rows($getstateid);

				if($counstate > 0 )
				{
					$fetchstate = @mysql_fetch_array($getstateid);
					$stateName = $fetchstate['name'];
					$stateCode = $fetchstate['code'];
				}

				$getcityid = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$city' AND `state_id` = '$state' ");
				$countcity = @mysql_num_rows($getcityid);

				if($countcity > 0 )
				{
					
					$fetchcity = @mysql_fetch_array($getcityid);
					$cityName = $fetchcity['city_name'];
				}
				$add = $stateName.",".$cityName;
				$address = str_replace(" ", "", $add);
				$formatted_address = $cityName.", ".$stateCode." ".$countryName;
			}
			else
			{
				$address = str_replace(" ", "", $zipcode);	
			}

			
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


			if(!empty($zipcode))
			{
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
				$formatted_address = trim($response_a->results[0]->formatted_address);
			}

			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;	
				

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
			$md5Password = md5($password);
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
				if(!empty($zipcode))
				{

					$getcountryid = @mysql_query("SELECT * FROM `country` WHERE `name` = '$country' ");
					$councnt = @mysql_num_rows($getcountryid);

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


					$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$state' AND `country_id` = '$country' ");
					$counstate = @mysql_num_rows($getstateid);

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






					$getcityid = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` = '$city' AND `state_id` = '$state' ");
					$countcity = @mysql_num_rows($getcityid);

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
				}


				// echo "STATE=".$state."---CITY=".$city;				die;


				$club_add = $club_add." ".$formatted_address;
				$now = date('Y-m-d h:i:s');
				$ValueArray = array($md5Password,$now,$first_name,$last_name,$name_club,$club_pass,$type_of_club,$type_details_of_club,$club_email,$password,$source,'',$phone,$country,$state,$city,$zipcode,$club_google_map,'1',$plan,$long,$lat);
				$FieldArray = array('password_md5','club_add_date','first_name','last_name','club_name','club_pass','type_of_club','type_details_of_club','club_email','password','hear_about','club_address','club_contact_no','club_country','club_state','club_city','zip_code','google_map_url','status','plantype','longitude','latitude');
			
		
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
					/*if($plan=='host_silver')
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
					
					}*/
					if($plan == 'host_free' || $plan == 'host_platinum')
					{			
						// echo "<pre>"; print_r($_SESSION); exit;

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
									
									$count = mysql_query("SELECT id, password FROM clubs WHERE club_email = '".$email."'");
									$getHostId = mysql_fetch_assoc($count);
									
									if(mysql_num_rows($count) > 0)
									{
									
										mysql_query("UPDATE clubs SET activation_code = '".$activation."' WHERE club_email = '".$email."'");
										
										$str = "
											<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%; padding-bottom:20px color:#FFF;'>
												<div class='logo'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>
												<hr>
												<p>
													<br />
										Welcome to the MYSITTI family and be a part of the next social revolution.  Visit MYSITTI.com where we are 
										<br />MAKING EVERY CITY YOUR CITY!
													<br /><br />

										Email: ".$email."<br>													
										Password: ".$getHostId['password']."<br/><br/>												
										We need to make sure you are human. Please verify your email and get started using Mysitti Website account. <br/> <br/> <a href=".$base_url."activation.php?code=".$activation.">".$base_url."activation.php?code=".$activation."</a>
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

									$InsertID = $getHostId['id'];
									$INSERTSQL = "INSERT INTO `host_functions_setting`(`host_id`, `store`, `contest`, `bio`, `jukebox`, `booking`, `uploads`, `message`, `biomessage`, `jukeboxmessage`, `contestmessage`, `bookingmessage`, `uploadsmessage`) 
											VALUES ('$InsertID','Disable without message','Enable','Disable without message','Disable without message','Disable without message','Enable','','','','','','')";

									$insertFunction = mysql_query($INSERTSQL);

								}
							}
						}				
						
						unset($_SESSION['signup_ValueArray_host']);
						unset($_SESSION['signup_FieldArray_host']);				
						//include("email_sent_to_host.php");
						$_SESSION['dataActivation'] = $email;
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
elseif($_POST['UserType'] == 'user' )
{
	$errors = "";
	$email=$_POST['email'];
$ThisPageTable = 'user';

	$checkClubEmail = mysql_query("SELECT `id` FROM `user` WHERE `email` = '$email'  ");
	if(mysql_num_rows($checkClubEmail) > 0)
	{
		header("Location: index.php?msg=duplicate&plan=free");
		die;
	}



		if(empty($errors))
		{
// die('dfdfdfd');
			if($_POST["captcha"]==$_SESSION["code"]){
			if($_POST['submit'] == 'Sign Up')
			{

				
				$zipcode=$_POST['zipcode'];
				$password=$_POST['password'];
				$md5Password = md5($password);
				$plan=$_POST['plantype'];
				$planid=$_POST['planid'];
				$profilename=$_POST['profilename'];	
				$country=$_POST['country'];
				$state=$_POST['state'];
				$city=$_POST['city'];

				if(empty($profilename))
				{
					$profilenameArray = explode('@', $email);
					$profilename = $profilenameArray[0];
				}
				//$city=$_POST['city_name'];
				if(isset($_POST['other_source']))
				{
					$source = $_POST['other_source'];

					@mysql_query("INSERT INTO `source` (`name`) VALUES ('".$source."') ");
				}
				else
				{
					$source = $_POST['source'];
				}

				if(empty($zipcode))
				{
					$getcountryid = @mysql_query("SELECT * FROM `country` WHERE `country_id` = '$country' ");
					$councnt = @mysql_num_rows($getcountryid);

					if($councnt > 0 )
					{
						$fetchcoutry = @mysql_fetch_array($getcountryid);
						$countryName = $fetchcoutry['name'];
						$countryCode = $fetchstate['iso_code_3'];
					}



					$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '$state' AND `country_id` = '$country' ");
					$counstate = @mysql_num_rows($getstateid);

					if($counstate > 0 )
					{
						$fetchstate = @mysql_fetch_array($getstateid);
						$stateName = $fetchstate['name'];
						$stateCode = $fetchstate['code'];
					}

					$getcityid = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$city' AND `state_id` = '$state' ");
					$countcity = @mysql_num_rows($getcityid);

					if($countcity > 0 )
					{
						
						$fetchcity = @mysql_fetch_array($getcityid);
						$cityName = $fetchcity['city_name'];
					}
					$add = $stateName.",".$cityName;
					$address = str_replace(" ", "", $add);
					$formatted_address = $cityName.", ".$stateCode." ".$countryName;
				}
				else
				{
					$address = str_replace(" ", "", $zipcode);	
				}

			
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


				if(!empty($zipcode))
				{
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
					$formatted_address = trim($response_a->results[0]->formatted_address);
				}

				$lat = $response_a->results[0]->geometry->location->lat;
				$long = $response_a->results[0]->geometry->location->lng;
				

				$Status = 1;
				$today = date("Y-m-d h:i:s");
				if($_POST['month'] < 10)
				{
					$month = "0".$_POST['month'];
				}
				else
				{
					$month = $_POST['month'];
				}
				if($_POST['date'] < 10)
				{
					$date = "0".$_POST['date'];
				}
				else
				{
					$date = $_POST['date'];
				}

				$dateofbirth =$_POST['year']."-".$month."-".$date;
				
				
				
				$DataArray1 = $Obj->Select_Dynamic_Query($ThisPageTable,'',array('email'),array('='),array($email),'','','','');
				
				if(strcmp($email,$DataArray1[0]['email']) == 0)
				{
					
					header("Location: index.php?msg=duplicate&plan=".$_POST['plantype']);
					die;
				}
				else
				{
					if(!empty($zipcode))
					{

						$getcountryid = @mysql_query("SELECT * FROM `country` WHERE `name` = '$country' ");
						$councnt = @mysql_num_rows($getcountryid);

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


						$getstateid = @mysql_query("SELECT * FROM `zone` WHERE `name` = '$state' AND `country_id` = '$country' ");
						$counstate = @mysql_num_rows($getstateid);

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






						$getcityid = @mysql_query("SELECT * FROM `capital_city` WHERE `city_name` = '$city' AND `state_id` = '$state' ");
						$countcity = @mysql_num_rows($getcityid);

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
					}
					$random_key= substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0);
		
					$ValueArray = array($md5Password,$profilename,'','',$email,$password,$source,'','',$country,$state,$zipcode,$Status,$today,$dateofbirth,$city,$plan,$long,$lat,$random_key);
					$FieldArray = array('password_md5','profilename','first_name','last_name','email','password','hear_about','phone','user_address','country','state','zipcode','status','regi_date','DOB','city','plantype','longitude','latitude','random_key');

					unset($_SESSION['signup_ValueArray']);
					unset($_SESSION['signup_FieldArray']);
					$_SESSION['signup_ValueArray'] = $ValueArray ;
					$_SESSION['signup_FieldArray'] = $FieldArray ;
					//$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
					//$lastinsertid = mysql_insert_id();	this code moved to user-plan-payment.php 
					$Success=1;
					if($Success > 0)
					{
						if($plan=='ultra')
						{
							$query = array();
							$query['notify_url'] = 'https://mysitti.com/ipn.php';
							$query['cmd'] = '_xclick-subscriptions';
							$query['no_shipping'] ="1";	
							$query['business'] = PAYPAPOWNERID;
							$query['lc'] = 'IN';
							$query['item_name'] = "Ultra Membership plan for mysitti";
							$query['no_note'] = '1';
							$query['src'] = '1';
							$query['a3'] = '7.99';
							$query['p3'] = '1';
							$query['t3'] = 'M';
							$query['address_override'] = '1';
							$query['currency_code'] = 'USD';
							$query['return'] = 'https://mysitti.com/user-plan-payment.php';
							$query['cancel'] = 'https://mysitti.com/user-plan-payment.php';
							$query_string = http_build_query($query);
							//header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);	
							$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?' . $query_string;			
				      		}
				      		else
				      		{
					  		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);


// $response = $endpoint->emailSearchAllLists($email);
// // create the lists endpoint:
// $response = $endpoint->create('qa544ohopt874', array(
//     'EMAIL'    => $email, // the confirmation email will be sent!!! Use valid email address
//     'FNAME'    => 'test',
//     'LNAME'    => 'test'
// ));


					  		//include("email_sent.php");
							$sql = "select * from `user` where `email` = '".$email."' && `password` = '".$password."' && status='1'";
							$DataArray = $Obj->select($sql) ;
							$lastinsertid = $DataArray[0]['id'];
							$CountDataArray = count($DataArray) ; 
							if($CountDataArray > 0)
							{
								//echo "<pre>"; print_r($DataArray); exit;
								$UserLoginId = $DataArray[0]['id'] ;
								$city = $DataArray[0]['city'] ;
								$username = $DataArray[0]['profilename'];
								$_SESSION['user_id'] = $UserLoginId ;
								$_SESSION['userEmail'] = $DataArray[0]['email'] ;  
								$_SESSION['usercity'] = $city ;
								$_SESSION['username'] = $username ;
								$_SESSION['profile_name'] = $username;
								$_SESSION['keepmelogin'] = $keepmelogin;
								$_SESSION['user_type'] = 'user';
								$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
								
								$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
								$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
								$_SESSION['country']=$DataArray[0]['country'];
							
								// date_default_timezone_set('America/Los_Angeles');
								$current_time= date('Y-m-d H:i:s'); 
								$tdate=date('Y-m-d H:i:s');
								//echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
								@mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
								//exit;
								//ob_start();
								include('email_sent.php');
								session_write_close();
								setcookie("checkforblog", 'yes');
								$Obj->Redirect("profile.php"); die;
							}
						}
					}
					else
					{
						echo "1234";die;
					   	header("location: index.php?msg=failed&plan=".$_POST['plantype']); die;
					}
				}
			}
			else
			{
				 echo "123zxc4";die;
				header("location: index.php?msg=failed&plan=".$_POST['plantype']); die;
			}
		}else{
			header("location: index.php?captcha=failed"); die;
		}

		}
	}

$ThisPageTable = 'user';	
if(isset($_POST['upgrade_submit'])){
	$query['a3']=$_POST['amount'];
	$paypalurl=$_POST['paypal'];
	$upgradeorfresh=$_POST['upgradeorfresh'];
	if($upgradeorfresh=='largecontest'){
		$contid=$_POST['contid'];
	}else{
		$contid=0;
	}
	
}

$checkcontestsql = @mysql_query("SELECT * FROM `contest` WHERE contest_id = '".$contid."' ");
$getcheckarray = @mysql_fetch_array($checkcontestsql);
//echo "<pre>"; print_r($getcheckarray); die;
if( ($getcheckarray['user_id'] == 0 ) && ($getcheckarray['host_id'] != 0 ) )
{
	//die('if');
	$redirectval = "view_contestent.php?cont_id=".$contid."&hostID=".$getcheckarray['host_id']."  ";
}
else
{
	//die('else');
	$redirectval = "mysitti_contests.php?contid=".$contid." ";	
}

if($_SESSION['user_type'] == 'user')
{
	$user_id=$_SESSION['user_id'];

	$contestcheck = @mysql_query("SELECT * FROM `contestent` WHERE contest_id = '".$contid."' AND user_id = '".$user_id."'  ");
	$countrows = @mysql_num_rows($contestcheck);
}
else
{
	$countrows = 0;
}

?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<script src="js/lk.popup.js"></script>
<style type="text/css">
#popup2{position:fixed; width:400px; height:auto; overflow:auto; background:#000; z-index:2; top: 100px !important;}
#popup2 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
#popup, #popup2, .bMulti {
	background-color: #000;
	border-radius: 10px;
	box-shadow: 0 0 25px 5px #006099;
	color: #111;
	padding: 25px;
	display: none;
}
#popup2 span.b-close { border: none; float: right;}
	.b-modal{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:1; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
</style>
<div id="wrapper" class="space home_wrapper">
             
	<div class="main_home">
		<div class="content1">

			<?php 
       			if($countrows > 0)
       			{
       				?>

       					<script type="text/javascript">
		       				$(document).ready(function(){
		       					var id = '<?php echo $contid; ?>';
		       					var redirect = '<?php echo $redirectval; ?>';
		       					$.ajax({
									type: 'POST',
									url: 'contestError.php',
									data: {
										'id' : id,
										'redirect' : redirect
									},
									success: function(data) {
										$('#mycontent').html(data); 
									}
								});

       					
       						});

       			</script>
       			<div id="popup2" style="">
	        		<span class="button b-close"></span>
	        		<div id="mycontent" style="height: auto; width: auto;">
	        			<?php //include('agreement.php'); ?>
	        		</div>
    			</div>


			<div class="b-modal" id="b-modal __b-popup1__" style=""></div>
<?php } ?>



        	<div id="title" class="botmbordr">Choose Payment Method to make purchase of <?php echo $query['a3']; ?></div>
        	
            <div class="paymentmodes">
        		<h2 style="color: #FECD07;font-size:20px;">Pay with paypal</h2> <br>
	        	<a href="<?php echo $paypalurl;?>" ><img src="images/paypal-btn.png" alt="Pay with Paypal" /></a>
	        </div>
            
	         <div style=" float: left;width:100%;margin:20px 0; text-align: center;">
	         	<h2 style="color: #FECD07;font-size:20px;">OR</h2>
	        </div>
	        <div class="cardsselect">
	        	<h2 style="color:#FECD07;font-size:20px;">Select Your credit/debit card to pay </h2> <br>

	        	<div><img src="images/visa.png" alt="Pay with Visa" /><br /><input class="cardradio" onclick="authnetpay(this.value);" type="radio" value="Visa" name="Visa" id="byvisa" /></div>
	        	<div><img src="images/mastercard.png" alt="Pay with Master Card" /><br /><input class="cardradio" onclick="authnetpay(this.value);" type="radio" value="MasterCard" name="Master" id="bymaster" /></div>
	        	<div><img src="images/americanexpress.png"  alt="Pay with American Express" /><br /><input class="cardradio" type="radio" onclick="authnetpay(this.value);" value="AmericanExpress" name="american" id="byamerican" /></div>
	        	<div><img src="images/dinerclub.png" alt="Pay with Diners Club" /><br /><input type="radio" class="cardradio" onclick="authnetpay(this.value);" value="DinersClub" name="diner" id="bydinerclub" /></div>
	        </div>
        	<div style="display:none" id="authopayform">
        		<form action="payment.php" method="POST">
        			<div class="leftbox">
				        <div class="leftone pdetails" style="color: #0099FF">
				        	<strong>Personal Details</strong>
				        </div>
				        <div class="rightone" style="width:80px;">&nbsp;</div>
				        <div class="leftone">First Name</div>
				        <div class="rightone">
          					<input name="firstname" type="text" />
        				</div>
        				<div class="leftone">Last Name</div>
        				<div class="rightone">
          					<input name="lastname" type="text" />
				        </div>
				        <div class="leftone">Email</div>
				        <div class="rightone">
				          <input name="email" type="text" />
				        </div>
				        <div class="leftone">Address</div>
				        <div class="rightone">
				          <input name="address" type="text" />
				        </div>
				        <div class="leftone">City</div>
				        <div class="rightone">
				          <input name="city" type="text" />
				        </div>
				        <div class="leftone">State/Zip</div>
				        <div class="rightone">
				          <input name="state" type="text" maxlength="2" style="width:30px;" />
				          <span style="font:8pt arial;width:auto !important;padding-right:5px;vertical-align:middle;font:8pt/25px arial;">eg. NY</span>
				          <input name="zip" type="text" style="width:75px;" />
				        </div>
				      </div>
				      <div class="rightbox">
				        <div class="leftone pdetails" style="color: #0099FF"><strong>Payment Details</strong></div>
				        <div class="rightone" style="width:80px;">&nbsp;</div>

				        <div class="leftone">Cardholder Name</div>
				        <div class="rightone">
				          <input name="cardholder" type="text" />
				        </div>
				        <div class="leftone">Card Number</div>
				        <div class="rightone">
				          <input name="cardnumber" type="text" />
				        </div>
				        <div class="leftone">Expiration <span style=" font:7pt arial; color:gray;">[ mm / yyyy ]</span></div>
				        <div class="rightone">
				          <input name="cardmonth" class="sel" type="text" style="width:40px;" />
				          &nbsp;
				          <input type="text" name="cardyear" class="sel" style=" width:98px;" />
				        </div>
				        <div class="leftone">CVV Number</div>
				        <div class="rightone">				          <input style="width: 40px;" name="cardcvv" type="text" /></div>
				        <div class="leftone" style="width:255px; text-align:right;">
							<input name="upgradeorfresh" type="hidden" value="<? echo $upgradeorfresh;?> " />
							<input name="contid" type="hidden" value="<? echo $contid;?> " />
				        	<input type="hidden" name="amount" value="<?php echo $query['a3']; ?>" />
				        	<input type="hidden" name="cardtype" value="" id="selectedcard" />
				          <input class="button" name="submit" type="submit" value="Pay Now" />
				        </div>
				      </div>
				      <div class="clear"></div>
        		</form>


        	</div>
        </div>

	</div>
</div>
<?php include('footer.php') ?>

<style type="text/css">
.leftone, span{color: #fff;	margin: 10px 0;}
.paymentmodes{float:left;width:100%;text-align:center;}
.paymentmodes > a{	float: left;	width:100%;}
.cardsselect {float: left;width: 100%;margin: 5% 0;text-align: center;}
.cardsselect div {float: left;width: 25%;}
</style>


<script type="text/javascript">

function authnetpay(valuecard)
{
	
	//var getcheckvalue = $(this).val(); 
	$('#authopayform').fadeIn('slow');
	$('input#selectedcard').val(valuecard);
	$('.cardradio').each(function(){
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

