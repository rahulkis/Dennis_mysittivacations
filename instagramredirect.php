<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

require 'instagram/instagram.class.php';
require 'instagram/instagram.config.php';
	/******** CODE FOR INSTAGRAM   **********/
	$code = $_GET['code'];

	// Check whether the user has granted access
	if (true === isset($code))
	{

	// Receive OAuth token object
		$data = $instagram->getOAuthToken($code);

		if(empty($data->user->username))
		{
			//die('IF');
			$url = 'index.php';
			$Obj->Redirect($url);
		}
		else
		{
			// session_start();
			// Storing instagram user data into session
		   // die('ELSE');
			$_SESSION['instadetails']=$data;
			$user=$data->user->username;
			$fullname=$data->user->full_name;
			$bio=$data->user->bio;
			$website=$data->user->website;
			$id=$data->user->id;
			$token=$data->access_token;
			// echo "<pre>";
			// print_r($_SESSION);
			// echo "</pre>";
			//die('123');profile_picture
			//$url = 'sociallogin.php?type='.$_SESSION['registertype'];
		//	$Obj->Redirect($url);
		}
	}

$userName = $_SESSION['instadetails']->user->username;
$fullName=$_SESSION['instadetails']->user->full_name;
$profile_picture = $_SESSION['instadetails']->user->profile_picture;
if(!empty($fullName))
{
	$fullName = explode(" ", $fullName);
}

if(isset($_POST['submitinfo']))
{
	
	$userEmail = $_POST['useremail'];
	$today = date('Y-m-d H:i:s');
	$checkuser = mysql_query("SELECT * FROM `user` WHERE email = '".$userEmail."' ");
	$checkhost = mysql_query("SELECT * FROM `clubs` WHERE club_email = '".$userEmail."' ");

	if(mysql_num_rows($checkhost) > 0 || mysql_num_rows($checkuser) > 0)
	{

	}
	else
	{
		$sql = "INSERT INTO `user` (`profilename`,`image_nm`,`hear_about`,`first_name`,`last_name`,`email`,`street`,`password`,`phone`,`user_address`,`country`,`state`,`zipcode`,`status`,`regi_date`,`DOB`,`city`,`plantype`,`longitude`,`latitude`) 
		  VALUES ('$userName','".$profile_picture."','instagram','$fullName[0]','$fullName[1]','".$userEmail."','','','','','','','','1','".$today."','','','free','','') ";
  		mysql_query($sql);
	}



	
	

  	$sql12 = "SELECT * FROM `user` WHERE email = '".$userEmail."' ";
		$DataArray = $Obj->select($sql12) ;
		
		$UserLoginId = $DataArray[0]['id'];
		$_SESSION['user_id'] = $UserLoginId ; 
		
		if(empty($DataArray[0]['first_name']))
		{
			$_SESSION['profile_name'] = $DataArray[0]['profilename'];
			$username = $DataArray[0]['profilename'];
		}
		else
		{
			$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];	
			$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
		}
		$_SESSION['username'] = $username ;
		$_SESSION['keepmelogin'] = '0';
		$_SESSION['user_type'] = 'user';
		$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
		
		$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
		$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
		$_SESSION['country']=$DataArray[0]['country'];

		//date_default_timezone_set('America/Los_Angeles');
		$current_time= date('Y-m-d H:i:s'); 
		$tdate=date('Y-m-d H:i:s');
		//echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
		mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
		//exit;
		//ob_start();
		
		session_write_close();
		$Obj->Redirect("profile.php");
		die;

}

// echo "SELECT * FROM `user` WHERE `profilename` = '$userName' ";
$checkuser = mysql_query("SELECT * FROM `user` WHERE `profilename` = '$userName' ");
$fetchUser = mysql_fetch_array($checkuser);


if(empty($fetchUser['email']) )
{

?>
<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script>
<script src="js/lk.popup.js"></script>
<link href="css/new_portal/style.css" rel="stylesheet" type="text/css">
<div id="popup2"  class="popoverlay" style="display:none;">
	<div class="bgpopup_overlay"> 
		<span class="b-close"> 
			<!-- <img src="images/closepopup.png" alt="Close" />  -->
		</span>
		<div id="mycontent" style="height: auto; width: auto;">
  			<h2>To continue Please Enter Your Email.<br /><br /> This Email will be required for MYSITTI to send you Notifications.</h2>
  			<div id="2" class="tab_contents tab_contents_active"  style="display:block">
  				<form action="" method="POST"  class="tab_standerd popSignup " id="signupes" name="signupes" novalidate="novalidate" onsubmit=" return ChkUserId1(); " >
  					<label> 
				           	<input type="text" required id="userEmail" placeholder="Email Address" onblur="ChkUserId(this.value,'user');" name="useremail">
				          </label>
				          <label class="termsn">
					          <input name="acknowledgement" id="acknowledgement" type="checkbox" value="1" style="margin:0 5px 0 0;" />
					          I have read and agree to the <a href="javascript:void(0)" onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');">Privacy Policy</a><span class="error">*</span> 
				      	</label>
				         
				          <div class="login_sbmit">
						<input type="hidden" value="POPSIGNUP" name="popsignup">
						<input type="submit" value="Save" name="submitinfo">
					</div>
  				</form>
  			</div>
		</div>
  	</div>
</div>
<style type="text/css">
#popup2 {
position:fixed;
	left:0 !important;
	top:0 !important;
	height:100%;
	z-index:99;
	zoom:1;
	width:100%;
	z-index:99;
	background:rgba(0, 0, 0, 0.7)!important;
}
#popup2 #zipcode {
  width: 95% !important;
  padding: 7px !important;
}
 
#popup2 #signupes > label {
  float: left;
  margin: 10px 0;
  width: 95% !important;
}
#popup2 #sources {
  height: 30px;
  overflow: visible;
  width: 100% !important;
}
.popoverlay input[type="text"], .popoverlay input[type="password"]{width:95%; padding:7px; border:1px solid #ccc;}
.popoverlay select{width:100%; padding:7px; border:1px solid #ccc;}
.bgpopup_overlay {
  background: #fff none repeat scroll 0 0;
  border: 5px solid #ccc;
  border-radius: 8px !important;
  bottom: 0;
  box-shadow: none;
  height: 300px;
  left: 0 !important;
  margin: auto;
  max-width: 450px;
  overflow: auto;
  padding: 0;
  position: absolute;
  right: 0;
  top: 0 !important;
  width: 100%;
  z-index: 2;
}
#popup2 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
#popup, .bMulti {
	background-color: #000;
	border-radius: 10px;
	color: #111;
	padding: 25px;
	display: none;
	
}
#popup2 span.b-close { border: none; float: right; cursor: pointer;}
	.b-modal{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}


#popup2 #signupes > label {
    float: left;
    margin: 10px 0;
    width: 68%;
}


#popup2 .styled-select
{
	margin: 0;
}

#popup2 label .styled-select select {
    float: left;
    width: 98%;
}

#popup2 .login_sbmit {
    margin: 20px 0;
}


#popup2 #mycontent > h2 {
    float: left;
    font-size: 17px;
    padding: 10px 0;
    text-align: center;
    width: 100%;
}

#popup2 .errorforsignup
{
	margin: 0;
	font-size: 13px;
}
.popoverlay #signupd, .popoverlay #signupes {
  margin: 0 !important;
}
</style>
<script type="text/javascript">
function ChkUserId(uemail,type)
{
	//alert(email);

	if(uemail != "" )
	{
		$.ajax({
			type: "POST",
			url: "ChkUserId.php",
			data: {
				'email_id' : uemail,
				'type' : type,
			},
			success: function(data){
				if(data ==0 )
				{
					alert("The email address is already taken. Please choose another one.");	
					if(type=='user')
					{
						$('#userEmail').val('');
						$('#userEmail').focus();
						$('#acknowledgement').prop('checked', false);
					}else{
						
					}
					return false;
				}

			}
		});

		
	}

}
function ChkUserId1()
{
	var uemail = $('#userEmail').val();
	$.ajax({
			type: "POST",
			url: "ChkUserId.php",
			data: {
				'email_id' : uemail,
				'type' : 'user',
			},
			success: function(data){
				if(data ==0 )
				{
					alert("The email address is already taken. Please choose another one.");	
					if(type=='user')
					{
						$('#userEmail').val('');
						$('#userEmail').focus();
						$('#acknowledgement').prop('checked', false);
					}else{
						
					}
					return false;
				}

			}
		});
}
</script>
<?php 	
}
else
{
	$user_email = $fetchUser['email'];
	$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
	$getemailquery = @mysql_query($sql);
	$countemail = @mysql_num_rows($getemailquery);
	$today = date("Y-m-d h:i:s");
	if($countemail > 0 )
	{
		//$dataArray = @mysql_fetch_array($getemailquery);
		$sql = "SELECT * FROM `user` WHERE email = '".$user_email."' ";
		$DataArray = $Obj->select($sql) ;
		$username = $DataArray[0]['first_name']."-".$DataArray[0]['last_name'];
		$UserLoginId = $DataArray[0]['id'];
		$_SESSION['user_id'] = $UserLoginId ; 
		$_SESSION['username'] = $username ;
		if(empty($DataArray[0]['first_name']))
		{
			$_SESSION['profile_name'] = $DataArray[0]['profilename'];
		}
		else
		{
			$_SESSION['profile_name'] = $DataArray[0]['first_name']." ".$DataArray[0]['last_name'];	
		}
		
		$_SESSION['keepmelogin'] = '0';
		$_SESSION['user_type'] = 'user';
		$_SESSION['img'] =  $DataArray[0]['image_nm'] ;
		
		$_SESSION['id']=$DataArray[0]['city'];// here we are storing city id of logged user
		$_SESSION['state']=$DataArray[0]['state']; // here we are storing state id of logged user
		$_SESSION['country']=$DataArray[0]['country'];

		//date_default_timezone_set('America/Los_Angeles');
		$current_time= date('Y-m-d H:i:s'); 
		$tdate=date('Y-m-d H:i:s');
		//echo "update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'"; die;
		mysql_query("update user set is_online='1',logged_date='".$tdate."', keepmelogin = '".$keepmelogin."' where id='".$UserLoginId ."'");
		//exit;
		//ob_start();
		
		session_write_close();
		$Obj->Redirect("profile.php");
		die;
	}
}	?>