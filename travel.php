<!DOCTYPE html>
<html>

	<?php
// ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

	include('Header.php');
?>

<body>
	<div class="container">
<?php  
if(!empty($_REQUEST['from_name'] && $_REQUEST['to_name'])) {


echo '<script src="//c111.travelpayouts.com/content?promo_id=3411&shmarker=130544.130544&locale=en&currency=USD&limit=25&powered_by=true&from_name='.$_REQUEST['from_name'].'&to_name='.$_REQUEST['to_name'].'" charset="utf-8"></script>';
}else{
	echo "<h3>Record not found</h3>";
}
?>
</div>
<?php
include('LandingPageFooter.php');
?>