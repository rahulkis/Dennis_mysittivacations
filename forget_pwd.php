<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

$para="";

if(isset($_REQUEST))

{

	$para=$_REQUEST['msg'];

}

if($para=="error")

{

	$message="The username is incorrect.";

}

?>

<script type="text/javascript">

function emailvali()

{

	if( document.forgt_pw.uname.value== "" )

	{

		alert( "Please provide valid email!" );

		document.forgt_pw.uname.focus() ;

		return false;   

	}

	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if (!filter.test(document.forgt_pw.uname.value)) 

	{

		alert('Please provide a valid email address');

		document.forgt_pw.uname.focus() ;

		return false;

	}

}



</script>
<style>
.v2_nav ul li ul {
  bottom: auto !important;
  top: 47px !important;
}
</style>
<?php

if($_POST['submit'])

{

	$email=$_POST['uname'];

 	

 	$sql = mysql_query("select password from `user` where `email` = '".$email."'");

 	$sql2 = mysql_query("select password from `clubs` where `club_email` = '".$email."'");

 	$DataArray = mysql_fetch_assoc($sql);
 	$DataArray2 = mysql_fetch_assoc($sql2);
 	
		$CountDataArray = mysql_num_rows($sql) ; 

		$CountDataArray2 = mysql_num_rows($sql2) ; 

		//echo "<pre>"; print_r($DataArray2); exit;

	if($CountDataArray > 0)

	{

			

		

		$str = "

			<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%;'>

				<div class='logo1'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>

				<hr>

				<p style='color: white;'>

					<br />

					<b> Your Password is: ".$DataArray['password']." </b> <br/>

				

				          To login <a href=https://mysitti.com/login.php><b> Click Here.</b> </a>

				 

				</p>

			</div>";

		$message = $str;

		$to  = $email;

		$subject = "Your Password For Mysitti ";

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

		

		

		$headers .= 'From: MySitti <info@mysittidev.com>' . "\r\n";

		

	

		mail($to, $subject, $message, $headers) or die;

		

		$success = "<div class='recoveryEmail'>Please check your registered email to reset the password.</div>";

 	}

 	elseif($CountDataArray2 > 0)

 	{

 		$str = "

			<div style='background-color: rgb(0, 0, 0); height: 405px; padding-left: 25px; float: left; width: 100%;'>

				<div class='logo1'><img src='".$base_url."images/new_portal/images/logo.png' border='0' /></div>

				<hr>

				<p style='color: white;'>

					<br />

					<b> Your Password is: ".$DataArray2['password']." </b> <br/>

				

				          To login <a href=https://mysitti.com/login.php><b> Click Here.</b> </a>

				 

				</p>

			</div> ";

			$message = $str;

			$to  = $email;

			$subject = "Your Password For Mysitti ";

			$headers  = 'MIME-Version: 1.0' . "\r\n";

			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

			

			

			$headers .= 'From: MySitti <info@mysittidev.com>' . "\r\n";

			

		

			mail($to, $subject, $message, $headers) or die;

			

			$success = "<div class='recoveryEmail'>Please check your registered email to reset the password.</div>";
			



 	}

	else

	{

		$message['error']="<div class='emailNotfound'>This email address is not found</div>";

		

	}		

}



$titleofpage="Forgot Password";

include('Header.php');



?>

<style type="text/css">


.v2_login_brand {margin-top:20px;}

 .v2_header {

  box-shadow: 0 0 3px #5a5a5a;

  height: 47px;

  margin-top: 0 !important;

  position: fixed;

  top: 40px;

  z-index: 99;

}

.loginbox {

	background: #F5FAFE;

	height: 444px;

	display: block;

	margin: auto;

	max-width: 459px;

	width: 100%;

	box-shadow:0px 0px 4px #333;

	-webkit-box-shadow:0px 0px 4px #333;

	z-index: 2147483647;

}

.loginheader {

	background: #FECD07;

	float: left;

	color:#000;

	padding: 12px;

	width: 100%;

	text-align:center;

	box-sizing: border-box;

	-webkit-box-sizing: border-box;

}

.logininner {

	

	box-sizing: border-box;

	-webkit-box-sizing: border-box;

	color: #000;

	float: left;

	padding:  0px;

	width: 100%;

}

.loginheader > h1 {

	color: #000;

	font-size: 18px;

	font-weight: 700;

	padding-top: 5px;

}

.logininner label {

	margin-top: 20px;

	float: left;

	font-weight:600;

}

.logininner > form {

	padding: 20px;

	width: 100%;

	box-sizing: border-box;

}

.logininner input[type="submit"] {

	background: #fecd07 none repeat scroll 0 0;

	border: 0 none;

	color: #000 !important;

	cursor: pointer;

	font-size: 14px;

	font-weight: 700;

	float:right;

	padding: 6px 14px;

	text-transform: capitalize;

}

.logininner input[type="submit"]:hover {background:#00BAFF;}

.v2_inner_main {

	margin: 20px 0 30px;

}

.accout {

	float: left;

	padding: 30px 0 0;

	position: relative;

	text-align: center;

	width: 100%;

}

.accout > a {

	background-color: #c6c6c6;

	box-sizing: border-box;

	-webkit-box-sizing: border-box;

	color: #0f0803;

	float: left;

	font-size: 14px;

	padding: 16px 15px;

	text-decoration: none;

	width: 100%;

}

.logininner input[type="email"], .logininner input[type="text"], .logininner input[type="password"] {

	border: 1px solid #ccc;

	float: none;

	margin: 15px 0;

	padding: 10px;

	width: 100%;

}



.logininner input[type="text"]:focus {

	border: 1px solid #000;

}

.clear {

	clear:both;

}

.v2_banner_top {

  height:auto !important;

  min-height:inherit;

}
@media only screen and (min-width:1025px) {
 .forgetpass {margin-top:80px;}
}
</style>

<div class="clear"></div>

<div class="v2_container">

  <div class="v2_inner_main">

    <div class="loginbox forgetpass">

      <div class="loginheader">

        <h1>FORGOT YOUR PASSWORD?</h1>

      </div>

      <div class="logininner">

        <?php if($success){ ?>

        <p style="background-color:#FFCCFF; color:#FF0000;padding-left: 10px;"><?php echo $success; ?> </p>

        <?php }else{



				if($message!="")

				{ ?>

        <p style="background-color:#FFCCFF; color:#FF0000;padding-left: 10px;"><?php echo $message['error']; ?> </p>

        <?php }

				} ?>

                <div class="v2_login_brand">

		<a href="index.php">  <img alt="" src="images/v2_logo_round_1.png"></a>

		  </div>

        <form name="forgt_pw" method="post" action="" onsubmit="return emailvali();">

          <span>Don't worry! just fill in your email and we'll help you reset your password.</span> <br />

          <p>

            <label>Email Address</label>

          </p>

          <p>

            <input name="uname" type="text" placeholder="Enter your email address" required="required">

          </p>

          <p>

            <input type="submit" name="submit" style="color:white;" value="Send Email" class="button"  />

          </p>

        </form>

        <div class="accout"> <a href="#" onclick="show_login_popop_forget_password(); return false;">Don't have account? Sign up</a> </div>

      </div>

    </div>

    <div class="clear"></div>

  </div>

  <div class="clear"></div>

</div>

<?php include('Footer.php') ?>

