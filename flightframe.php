<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage=" Flights"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<div id="loader"></div>
			<div id="ifrmae_menu" class="col-sm-12">
			   <iframe src="https://www.hotwire.com/flights/" scrolling="yes" width="100%" height="100%" frameborder="0" style="margin-top: -73px;"></iframe>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var $iFrameContents = $('iframe').contents(),
    $entryContent   = $iFrameContents.find('header#header').hide();
</script>

<?php
if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<?php
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>