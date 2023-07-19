<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Unsubscribe Confirmation"; 

include('Header.php');	// not login

session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/deals.css">

<script type="text/javascript">
$(document).ready(function() {
	$("body").on('click', '.top', function() {
		$("nav.menu").toggleClass("menu_show");
	});
	 if (window.matchMedia("(max-width: 767px)").matches)  
        { $('.incase_mobile').css('display','block');
            $('.incase_desktop').css('display','none');
        } else { 
        	$('.incase_mobile').css('display','none');
           
        } 
	    $('.menu_icon').click(function() {

	    $('html, body').animate({
	      scrollTop: $("#myCarousel").offset().top
	    }, 1000);
	})
});
</script>
<!--section1-->
<div class="container unsub_contain">
	<div class="row">
		<div class="col-sm-12 col-md-12  unsub">
			<div class="heading_title"><h1>UNSUBSCRIBE CONFIRMATION</h1></div></div>
		
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
	      <li><a href="https://www.facebook.com/mysitti" target="_blank"><img src="upload/facebook.jpg"></a></li>
		  <li><a href="<?php echo $SiteURL; ?>blog/" target="_blank"><img src="upload/bingo.jpg"></a></li>
		  <li><a href="https://instagram.com/mysitti/" target="_blank"><img src="upload/insta.jpg"></a></li>
		  <!-- <li><a href="https://www.pinterest.com/mysitti/" target="_blank"><img src="upload/pintst.jpg"></a></li> -->
		  <li><a href="https://twitter.com/MysittiCom" target="_blank"><img src="upload/twitter.jpg"></a></li>
		  <li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA?sub_confirmation=1" target="_blank"><img src="upload/you-tube.jpg"></a></li>
	   </ul>
	<div>
		</div>
	</div>
	
	
	
	










<?php
	include('LandingPageFooter.php');
 ?>
 
 <style>
	.connect-social ul li a img {
    width: 30px;
	}
 </style>
