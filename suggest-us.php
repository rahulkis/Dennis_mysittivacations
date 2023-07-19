<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
if(isset($_SESSION['suc_msg']))
{
 $message=$_SESSION['suc_msg'];
 unset($_SESSION['suc_msg']);
}

 $titleofpage="Suggest Us";
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php');
	//echo "<style>.v2_banner_top .v2_header_host{ margin-top: 0px !important;}</style>";
}
else
{
	include('Header.php');
	echo '<style>#v2_wrapper{ z-index: 0 !important;}</style>';
}
 $sql = "select * from `pages` where page_name like '%contact us%'";
 $policyArray = $Obj->select($sql) ; 
 $contact_us=$policyArray[0]['page_data'];


if($_POST['submit'])
{ 
	$today = date("Y-m-d h:i:s");
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$enquiry=$_POST['enquiry'];
	$ValueArray = array($fname,$lname,$email,$enquiry,$today);
	$FieldArray = array('fname','lname','email','suggestion','adde_on');
	$ThisPageTable='suggest_us';		
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
				if($Success > 0)
				{
				 
			$fetch_c_email = mysql_query("SELECT * FROM admin_contact_emails WHERE type = 'contact_suggest'");
				$f_count_e = mysql_num_rows($fetch_c_email);
				
				if($f_count_e > 0){
					
					$get_e_value = mysql_fetch_assoc($fetch_c_email);
					
					$e_value = $get_e_value['email'];
					
					}else{
					 
					 $e_value = "mysitti@mysittidev.com";
					 
					}
				 
					$to = $e_value;
										$subject = "New Enquiry";

										$message = "
										<html>
										<head>
										<title>Suggestion</title>
										</head>
										<body>
										<h1>Suggestion Details</h1>
										<table>
										<tr>
										<th>Firstname</th>
										<th>Lastname</th>
										<th>Email</th>
										<th>Suggestion</th>
										</tr>
										<tr>
										<td>".$fname."</td>
										<td>".$lname."</td>
										<td>".$email."</td>
										<td>".$enquiry."</td>
										</tr>
										</table>
										</body>
										</html>
										";

										// Always set content-type when sending HTML email
										$headers = "MIME-Version: 1.0" . "\r\n";
										$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

										// More headers
										$headers .= 'From: <'.$email.'>' . "\r\n";
										//$headers .= 'Cc: myboss@example.com' . "\r\n";

										mail($to,$subject,$message,$headers);
					$_SESSION['suc_msg']="Mysitti welcomes your suggestions for improving our services. ";
					$Obj->Redirect("suggest-us.php");
					die;
				}
										
	}
 
 ?>
 <style>
 .v2_header.fordesk {
	display: none;
}
.v2_banner_top {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
}
.v2_brand {
	float: left;
	max-width: 100%;
	text-align: center;
	width: 100%;
}
.v2_get_started { 
	display: none; 
}
.comman_main {
 margin-top:70px;
}
.error {
 color: red;
}
.thankyu_box {
 background: #f7f7f7 none repeat scroll 0 0;
 border: 4px solid #fff;
 border-radius: 4px;
 box-shadow: 0 0 4px #5d5d5d;
 box-sizing: border-box;
 -webkit-box-sizing: border-box;
 margin:0px auto;
 padding: 20px 0;
 text-align: center;
 width: 100%;
 margin-bottom:20px;
 max-width:900px;
 display:table;
 coilor:#000;
 padding:20px;
}
.box7 {
	border-right: 1px solid #ccc;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	float: left;
	width: 60%;
}
.content_cotact_txt {
	box-sizing: border-box;
	color: #000 !important;
	float: left;
	padding: 20px;
	width: 40%;
}
.content_cotact_txt table {
	font-size: 14px;
	font-style: normal;
	line-height: 21px;
	text-align: left;
	width: 100%;
}
.content_cotact_txt a {
	color: #000 !important;
	text-decoration:none;
}
#v2_wrapper2 {
	float: left;
	padding-top:47px;
	width: 100%;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
#contact_usFrom input {padding:5px 10px; border:1px solid #ccc; widows:60%; margin-bottom:10px;}
.thankyu_box p {
	color: #000;
	float: left;
	line-height: 20px;
	text-align: center;
	width: 100%;
}
#contact_usFrom label {
	float: left;
	width: 40%;
}
#contact_usFrom input, #contact_usFrom textarea {
	border: 1px solid #ccc;
	float: left;
	margin-bottom: 10px;
	padding: 5px 10px;
	width: 50%;
}
.content1 > h1 {
	font-size: 29px;
	margin-bottom: 20px;
}
.button {
	border: 1px solid #000 !important;
	color: #000 !important;
	width: 221px !important;
}
@media only screen and (max-width:767px) {
 #contact_usFrom label {
	float: left;
	text-align: left;
	width: 40%;
}
.box7 { 
	width: 100%;
	border:0;
} 
.content_cotact_txt { 
	width: 100%;
}
 #contact_usFrom .error {
	color: red;
	float: left;
	margin-left: 40%;
}
#contact_usFrom input, #contact_usFrom textarea {
	border: 1px solid #ccc;
	box-sizing: border-box;
	float: left;
	margin-bottom: 10px;
	padding: 5px 10px;
	width: 60%;
}
.box7 {
	width: 100%;
	border: 0;
}
.thankyu_box { 
	border: 0 none;
	border-radius: 0; 
}
}

@media only screen and (max-width:479px) {
	.error {
	color: red;
	float: left;
	margin-left: 0;
}
#contact_usFrom input, #contact_usFrom textarea { 
	width: 100%;
}
 #contact_usFrom label { 
	width: 100%;
}
}
</style>
 <script src='js/jquery.validate.js'></script>
 <script src="js/register.js" type="text/javascript"></script>
 <div id="v2_wrapper2">
 <div class="thankyu_box">
		<div class="content1">
<h1> Suggestion Box </h1>
			<?php
							 if($message!="")
							 {
							 ?>
			<div id="successmessage" class="message"style="display: block; background-color:#FFCCFF; color:green"> <?php echo $message; ?> </div>
			<?php
						 }
						 ?>
			<div class="box7">
				<form id="contact_usFrom" name="contact_us"  method="post" onsubmit="return validatecontact_us();">
				 <p>
				 <label>First name</label>
							<input required name="fname" id="fname" type="text" class="txt_box" placeholder="First Name"/>
							</p>
							<p>
			<label>Last name</label>
							<input required type="text" name="lname" class="txt_box" placeholder="Last Name"/>
			 </p>
						<p> <label>Your email</label> <input required type="email" name="email" class="txt_box" onblur="ChkUserId(this.value);" placeholder="Email"/></p>
				 
						 <p><label>Suggestion</label> <textarea required name="enquiry" class="txt_box" style="height:100px;" placeholder="Suggestion"/></textarea></p>
					
						<p> <label>&nbsp;</label> <input type="submit" name="submit" value="Submit" class="button"/></p>
			 
				</form>
			</div>
			<div class="content_cotact_txt" style="color:white;">
				<address>
				<table>
					<tr>
						<td><img src="images/new_portal/images/home.png" alt=""></td>
						<td>Memphis, TN 38111-9997<br />
							P.O.Box 11224<br />
							Phone: (866) 494-2026</td>
					</tr>
					
						<td><img src="images/new_portal/images/mail.png" alt=""></td>
						<?php
								 $fetch_c_email = mysql_query("SELECT * FROM admin_contact_emails WHERE type = 'contact_suggest'");
									 $f_count_e = mysql_num_rows($fetch_c_email);
									 
									 if($f_count_e > 0){
										 
										 $get_e_value = mysql_fetch_assoc($fetch_c_email);
										 
										 $e_value = $get_e_value['email'];
										 
										 }else{
											
											$e_value = "mysitti@mysittidev.com";
											
										 }								
								?>
						<td><a style="color: rgb(254, 205, 7);" href="mailto:<?php echo $e_value; ?>"><?php echo $e_value; ?></a></td>
					</tr>
					
						<td><img src="images/new_portal/images/web.png" alt=""></td>
						<td>mysittidev.com</td>
					</tr>
				</table>
				</address>
			</div>
		</div>
 </div>
</div>
<?php include('Footer.php') ?>
