<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<?php 
$titleofpage="Thank You";
include('header_start.php');

?>
<?php include('header.php'); ?>

<div class="home_wrapper">
	<div class="main_home">
		<div class="thankyou">
			<div class="thankyou_inner">
				<div id="title_thankyou">
					Error While processing the payment.
				</div>
				<div class="thankyu_box">
				<h1>Your Transaction is not authorized. Please try again.</h1>
			</div>
		</div>
	</div>
</div>
</div>
<?php include('footer.php') ?>
