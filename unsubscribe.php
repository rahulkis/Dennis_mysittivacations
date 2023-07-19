<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Unsubscribe"; 
include('Header.php');  // not login
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>
 <?php $SiteURL = "https://".$_SERVER['HTTP_HOST']."/";?>
<style>
.sub_inner {
    margin-top: 100px;
}
button.pop-btn-sec {
    display: none;
}
</style>
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
<?php

function syncMailchimp($data) {
    $apiKey = '917e3679b24102a3a902bc3246e60492-us20';
    $listId = '0e669ac09b';

    $memberId = md5(strtolower($data['email']));
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://us20.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

    $json = json_encode([
        'email_address' => $data['email'],
        'status'        => $data['status'] // "subscribed","unsubscribed","cleaned","pending"
    ]);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:917e3679b24102a3a902bc3246e60492-us20');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode;
}

if(isset($_POST['submit']))
{
$postemail = $_POST['unsubEmail'];
        $data = [
        'email'     => $postemail,
        'status'    => 'unsubscribed'
        ];
        syncMailchimp($data);
		$unsubscribed_email = "DELETE FROM user WHERE email = '".$postemail."'";
		$mysqli->query($unsubscribed_email);
		header('location: '.$SiteURL.'userconfirmsub.php');
}


?>
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
			<div class="heading_title"><h1>Unsubscribe?</h1></div>
			</div>
		<form method="post">
			<div class="form-group col-md-12">
				<label for="exampleInputEmail1">For Unsubscription Enter your Email Address</label>
				<input type="email" class="form-control" id="exampleInputEmail1" name="unsubEmail" aria-describedby="emailHelp" placeholder="Enter email" required>
			</div>
			<div class="form-group button_area_box col-md-12">
				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
		</div>
		</div>
	</div>

<style>
  .joinCaptcha{
    padding: 7px;
  }
</style>
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
