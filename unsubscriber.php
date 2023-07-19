<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Unsubscribe"; 
 
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
if(isset($_GET['list_id']) && !empty($_GET['list_id'])){
	$_SESSION['list_id'] =$_GET['list_id'];
	$_SESSION['submail'] = $_GET['email'];
}
if(isset($_POST['submit']))
{
	$list_id = $_SESSION['list_id'];
	$getemail = $_SESSION['submail'];
	$postemail = $_POST['unsubEmail'];
	if($getemail == $postemail)
	{
		require 'mailwizz_setup.php';
		$endpoint = new MailWizzApi_Endpoint_ListSubscribers(); 
		$response = $endpoint->deleteByEmail($list_id, $postemail);
		header('location:unsubscriberConfirm.php');
		unset($_SESSION['list_id']);
		unset($_SESSION['submail']);
	}
	else{
			?>
			<script>
				alert('Enter a valid email');
			</script>
			<?php
		}
}

?>

<!--section1-->
<div class="container unsub_contain">
	<div class="row">
		<div class="col-sm-12 col-md-12  unsub">
			<div class="heading_title"><h1>UNSUBSCRIBE</h1></div></div>
		<form method="post">
			<div class="form-group col-md-4">
				<label for="exampleInputEmail1">Email Address</label>
				<input type="email" class="form-control" id="exampleInputEmail1" name="unsubEmail" aria-describedby="emailHelp" placeholder="Enter email">
			</div>
			<div class="form-group button_area_box col-md-12">
				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
		</div>
	</div>
	
	
	
	<!--section2-->
	<div class="container new_designCate">
<div class="deals_banner">
	<ul class="banner_vacation_deals">			
		<li class="col-sm-6 col-md-6 col-xs-12">
			<a href="http://www.tkqlhce.com/click-8265264-12892733" target="_blank">
			<img src="http://www.tqlkg.com/image-8265264-12892733" width="1080" height="1080" alt="All-Inclusive Sandals Resorts - For Two People In Love" border="0"></a>          	
		</li>
		<li class="col-sm-6 col-md-6 col-xs-12">
			<a href="http://www.anrdoezrs.net/click-8265264-12896404" target="_blank">
			<img src="http://www.awltovhc.com/image-8265264-12896404" width="1080" height="1080" alt="FREE Wedding &amp; Honeymoon at Sandals Resorts" border="0"></a>          	
		</li>
	</ul>
</div>
</div>









<?php
	include('LandingPageFooter.php');
 ?>