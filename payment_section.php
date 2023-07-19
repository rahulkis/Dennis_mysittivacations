<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<?php 
$titleofpage="Streaming Payment";
include('header_start.php');

?>
<?php include('header.php'); ?>

<div class="home_wrapper">
  <div class="main_home">
	<div class="thankyou">
		<?php if(isset($_GET['action']) )
			{
		?>
				<div class="thankyou_inner">
					<div id="title_thankyou">Your Plan Upgraded Successfully!</div>
					<div class="thankyu_box">
						<h1>Thank you for Upgrading your plan.</h1>
						<p> Please check your email, including the junk/spam folder, for a confirmation message. </p>
					</div>
				</div>
		<?php
			}
			else
			{
		?>
				<div class="thankyou_inner">
					<div id="title_thankyou">Please pay before watching live streaming!</div>
					<div class="thankyu_box">
						<h1>Thank you</h1>
						<!--<p> Please check your email, including the junk/spam folder, for a confirmation message. <br/>
						Click on the link to confirm your registration.</p>-->
					</div>
				</div>
		<?php  }	?>
		</div>
  </div>
</div>
<?php include('footer.php') ?>
