<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$_SESSION['uid'] = $_GET['id'];
$titleofpage="unsubscribe"; 
 $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>


<!--section1-->
<div class="v2_content_wrapper unsubcon_contain" >

		<div class="col-sm-12 col-md-12  unsub">
			<div class="heading_title"><h1>Unsubscribe Confirmation</h1>
			</div>
			</div>
		
	<div class="confirmation-box">
    <div class="confirmation-text">
        <h5>We're sorry to see you go!</h5>
        <p>you are now unsubscribed from our email list.</p>
    </div>
    <div class="confirmation-text">
        <h5>Changed your mind?</h5>
    </div>
    <div class="confirmation-text">
        <h5>keep in touch!</h5>
        <p>Connect with us on social media</p>
    </div>
	<div class="connect-social">
	   <ul class="list-inline">
	      <li><a href="https://www.facebook.com/mysitti" target="_blank"><img src="../upload/facebook.jpg"></a></li>
		  <li><a href="https://mysitti.com/blog/" target="_blank"><img src="../upload/bingo.jpg"></a></li>
		  <li><a href="https://instagram.com/mysitti/" target="_blank"><img src="../upload/insta.jpg"></a></li>
		  <li><a href="https://www.pinterest.com/mysitti/" target="_blank"><img src="../upload/pintst.jpg"></a></li>
		  <li><a href="https://twitter.com/MysittiCom" target="_blank"><img src="../upload/twitter.jpg"></a></li>
		  <li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA?sub_confirmation=1" target="_blank"><img src="../upload/you-tube.jpg"></a></li>
	   </ul>
	
	</div>
	</div>
	
	</div>
	
	
	
	
	










<?php
	include('LandingPageFooter.php');
 ?>
 
 