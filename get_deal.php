<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";


$value = $_POST['dealValue'];


	if($value == 'ticket') {
		echo "<h2 class='deal_heading'>TICKETS DEALS</h2>";
	} elseif($value == 'flight') {
		echo "<h2 class='deal_heading'>FLIGHTS DEALS</h2>";
	} else {
		echo "<h2 class='deal_heading'>HOTELS DEALS</h2>";
	}
	$getDeals = mysql_query("SELECT * FROM deals WHERE status = 1 AND deal_name = '".$value."' ");
	while ($res = mysql_fetch_assoc($getDeals)) 
	    {
	    	$html .= "<div class='col-sm-3 city-recom'>".$res['deal_code']."
							<div class='deal_text'>".$res['deal_text']."</div>
						</div>";
    	}
    	echo $html;
    	
    	
?>
<script type="text/javascript">
	$(document).ready(function(){
	  $('.city-recom a').attr('target', '_blank');
	});
</script>