<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Coming Soon";
include('header_start.php');

$userID=$_SESSION['user_id'];

if(!isset($userID)){
  $Obj->Redirect("login.php");
}

include('header.php');

?>

<style>
.lbl{
  float: left;
  width: 100% !important;
}

#u_0_t{
  float: left !important;
}

#ad_support_pst{
  display: none;
}
</style>	
	
<div class="home_wrapper">
<div class="main_wrapper band_wrapper_bg">

	
    <h1 class="soon">Coming Soon</h1>
    <div class="clear"></div></div>
  </div>
</div>
    <?php include('footer.php') ?>
