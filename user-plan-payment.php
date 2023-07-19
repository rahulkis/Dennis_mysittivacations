<?
session_start();
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$ThisPageTable = 'user';
if(isset($_GET['st'])){
	if($_GET['st']=="Completed"){
				$ValueArray=$_SESSION['signup_ValueArray'];
				$FieldArray= $_SESSION['signup_FieldArray'];				
				$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				
				
				if($Success > 0)
				{
					$email=$_SESSION['signup_ValueArray'][2];
					include("email_sent.php");
					$password=$_SESSION['signup_ValueArray'][3];
					$sql = "select * from `user` where `email` = '".$email."' && `password` = '".$password."' && status='1'";
					$DataArray = $Obj->select($sql) ;
					$lastinsertid = $DataArray[0]['id'];
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
						
						session_write_close();
						unset($_SESSION['signup_ValueArray']);
		            			unset($_SESSION['signup_FieldArray']);
						$Obj->Redirect("home_user.php");
						die;
					}
					
				}
			
		}
	else{
		echo "Not Completed";
	}

}


//$_SESSION['plan-payment-type']='user';
//  header("Location:https://mysittidev.com/sign_up.php#tabs1-html");
?>
