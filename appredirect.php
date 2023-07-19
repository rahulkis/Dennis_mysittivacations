<?php
include("../Query.Inc.php");
$Obj = new Query($DBName);

$userid = $_GET['userid'];
$usertype = $_GET['usertype'];

// if(!isset($_SESSION['user_id'])){
// //$Obj->Redirect("login.php");
// }
// else
// {
	if($usertype== '2')
	{
	  	echo $query_string = "select * from `user` where id = '".$userid."' ";  die;
		$result = $Obj->select($query_string) ;
		$result_count = count($result) ; 
		if($result_count > 0)
		{
			$sql = "select * from `user` where id = '".$userid."' && status='1'";
			$DataArray = $Obj->select($sql) ;
			$CountDataArray = count($DataArray) ; 
			if($CountDataArray > 0)
			{
				//echo "<pre>"; print_r($DataArray); exit;
				$UserLoginId = $DataArray[0]['id'] ;
				$city = $DataArray[0]['city'] ;
				$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
				$_SESSION['user_id'] = $UserLoginId ; 
				$_SESSION['usercity'] = $city ;
				$_SESSION['username'] = $username ;
				$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];
				
				$_SESSION['user_type'] = 'user';
				$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
				
				$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
				$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
				$_SESSION['country']=$DataArray[0]['country'];
			
				// date_default_timezone_set('America/Los_Angeles');
				$current_time= date('Y-m-d H:i:s'); 
				$tdate=date('Y-m-d H:i:s');
				//echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '1' where id='".$UserLoginId ."'"; die;
				mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
				//exit;
				//ob_start();
				$_SESSION['keepmelogin'] = $keepmelogin;
				session_write_close();
				$Obj->Redirect("../index.php");
			}
			else
			{
				$Obj->Redirect("../login.php?msg=error2");
			}
		}
		else
		{
			$Obj->Redirect("../login.php?msg=error1");
		}
	}
	else
	{
		
		$query_string = "select * from `clubs` where id = '".$userid."' ";
		$result = $Obj->select($query_string) ;
		$result_count = count($result) ; 
		if($result_count > 0)
		{
			$sql = "select * from `clubs` where id = '".$userid."' && status='1'";
			$DataArray = $Obj->select($sql) ;
			$CountDataArray = count($DataArray) ; 
			if($CountDataArray > 0)
			{
				
				$pieces = explode(" ", $DataArray[0]['club_name']);
				$username_dash_separated = implode("-", $pieces);
				
				$UserLoginId = $DataArray[0]['id'] ;
				$User = "Club";
				$_SESSION['user_id'] = $UserLoginId ;
				$_SESSION['user_club'] = $User ;
				$_SESSION['user_type'] = 'club';
				$_SESSION['username'] = $username_dash_separated ;
				$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
				
				$_SESSION['id']=$DataArray[0]['club_city'];// here we are storing city id of logged user
				$_SESSION['state']=$DataArray[0]['club_state']; // here we are storing state id of logged user
				$_SESSION['country']=$DataArray[0]['club_country'];
				
				// date_default_timezone_set('America/Los_Angeles');
				$current_time= date('Y-m-d H:i:s'); 
				$tdate=date('Y-m-d H:i:s');
				mysql_query("update clubs set is_online='1', keepmelogin = '".$keepmelogin."' ,logged_date='".$tdate."' where id='".$UserLoginId ."'");
				$_SESSION['keepmelogin'] = $keepmelogin;
				session_write_close();
				$Obj->Redirect("../home_club.php");
				
			}
			else
			{
				$Obj->Redirect("../login.php?msg=error2");
			}
		}
		else
		{
			$Obj->Redirect("../login.php?msg=error1");
		}
		
		
	}

// }


