<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Unsubscribe"; 
include('Header.php');  // not login
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <?php $SiteURL = "https://".$_SERVER['HTTP_HOST']."/";?>
<style>
.sub_inner {
    margin-top: 100px;
}
input#mce-EMAIL {
    border: 1px solid #afacac;
    border-radius: 3px;
    height: 45px !important;
    font-size: 15px;
}
div#mce-error-response {
    font-size: 15px;
}
div#mce-success-response{
	font-size: 15px;
	color: red;
}
.v2_header_wrapper.deals_wrapper {
    display: none;
}
button.pop-btn-sec {
    display: none;
}
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="sub_inner">
<div class="container unsub_contain">
	<div class="row">
		<div class="col-sm-12 col-md-12  unsub">
			<div class="heading_title"><h1>Subscribe?</h1></div>
			</div>
		<form action="https://mysittivacations.us20.list-manage.com/subscribe/post?u=0425720754466f04348f8e55f&amp;id=0e669ac09b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<div class="mc-field-group">
	<div id="mce-responses" class="clear">
	</div>
<label for="exampleInputEmail1">For Subscription Enter your Email Address</label>
	<input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" aria-describedby="emailHelp" placeholder="Enter email" required>
</div>
			<div class="form-group button_area_box col-md-12"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-primary">
    </div>
			</div>
		</form>
		</div>
		</div>
	</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='MMERGE5';ftypes[5]='dropdown';fnames[6]='MMERGE6';ftypes[6]='radio';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<style>
  .joinCaptcha{
    padding: 7px;
  }
</style>
<script>
$(document).ready(function(){
	$('#mc-embedded-subscribe').click(function(){
		setTimeout(function(){ swal("Thanks for the subscribe"); window.location.replace("https://mysittivacations.com/"); }, 2000);
	})
})
</script>
 <script>
    $(function(){ 
       var navMain = $(".navbar-collapse");

       navMain.on("click", "a", null, function () {
         navMain.collapse('hide');
       });
     });
  </script>
 <?php
    include('LandingPageFooter.php');
 ?>
