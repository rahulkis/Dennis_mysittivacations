<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Comedy"; 
 
if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}

?>
<div class="container">
<form class="form homeaway_search">
<div class="row">
<div class="col-md-12">
<h1 class="float-left search_heading">Find your HomeAway</h1>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="form-group has-success has-feedback">
  <label class="control-label sr-only" for="inputSuccess5">Hidden label</label>
  <input type="text" class="form-control" id="inputSuccess5" aria-describedby="inputSuccess5Status">
  <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
  <span id="inputSuccess5Status" class="sr-only">(success)</span>
</div></div>
</div>


<div class="row">
<div class="col-md-3 input-append  form_datetime">
<div class="input-group">
  <input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
  <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
</div>
</div>
<div class="col-md-3 input-append  form_datetime">
<div class="input-group">
  <input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
  <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
</div>
</div>
<div class="col-md-3 ">
 <div class="input-group">
  <input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
  <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-user"></i></span>
</div>
</div>
<div class="col-md-3">
  <a href="#" class="btn btn-info  search_boxess">
          <span class="glyphicon glyphicon-search"></span> Search
        </a>
</div>
</div>

<div class="row bottom_text">
<div class="col-md-6">
<div class="text_area text-left">
<div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1"><h3>I does't have specific date</h3></label>
  </div>
</div></div>
<div class="col-md-6">
<div class="map_area text-right">
<a href="">Browse By Map</a>
</div>
</div></div></form></div>


<div class="homeaway_main_div">


<div class="container">
<div class="row">
<div class="col-md-12 top_text">
<h1 class="float-left"> <span class="glyphicon glyphicon-home"></span> Top Vacation Rental in the United State</h1>
</div>
</div>
<!--first row-->
<div class="row">
<div class="col-md-6">
<div class="one">

<div class="col-md-4">
<div class="inner_img_homeaway">
 <img src="https://s3-media3.fl.yelpcdn.com/bphoto/HwwmnCMrRqWqdaT-3WRhqQ/o.jpg" class="img-responsive" alt="...">
</div></div>
<div class="col-md-8 float-left">
<h1 class="float-left">Polo Towers by Diamond Resorts</h1>
    <p class="location_homeway">3745 las vagas Blavs</p>
	 <div id="colorstar" class="starrr ratable">
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 </div>
	 
	  <p>Last booking 6 hours ago</p>
	  <p class="view">56 others viewing this property</p>
	 <p class="rating">4.2 out of 5</p>
	  <p class="description_part">Simulation in the middle of the action.Simulation in the middle of the action....</p>
	  <p class="see_all">See Review</p>
	  
	  
</div>

</div></div>
<div class="col-md-6">
<div class="one">

<div class="col-md-4">
<div class="inner_img_homeaway">
 <img src="https://s3-media3.fl.yelpcdn.com/bphoto/HwwmnCMrRqWqdaT-3WRhqQ/o.jpg" class="img-responsive" alt="...">
</div></div>
<div class="col-md-8 float-left">
<h1 class="float-left">Polo Towers by Diamond Resorts</h1>
    <p class="location_homeway">3745 las vagas Blavs</p>
	 <div id="colorstar" class="starrr ratable">
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 </div>
	  <p>Last booking 6 hours ago</p>
	  <p class="view">56 others viewing this property</p>
	  <p class="rating">4.2 out of 5</p>
	 <p class="description_part">Simulation in the middle of the action.Simulation in the middle of the action....</p>
	  <p class="see_all">See All</p>
	   
	  
</div>

</div>

</div></div>

<!--second row-->

<div class="row">
<div class="col-md-6">
<div class="one">
<div class="col-md-4">
<div class="inner_img_homeaway">
 <img src="https://s3-media3.fl.yelpcdn.com/bphoto/HwwmnCMrRqWqdaT-3WRhqQ/o.jpg" class="img-responsive" alt="...">
</div></div>
<div class="col-md-8 float-left">
<h1 class="float-left">Polo Towers by Diamond Resorts</h1>
    <p class="location_homeway">3745 las vagas Blavs</p>
	 <div id="colorstar" class="starrr ratable">
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 </div>
	  <p>Last booking 6 hours ago</p>
	  <p class="view">56 others viewing this property</p>
	  <p class="rating">4.2 out of 5</p>
	  <p class="description_part">Simulation in the middle of the action.Simulation in the middle of the action....</p>
	  <p class="see_all">See Review</p>
	   
	  
</div>

</div>
</div>
<div class="col-md-6">
<div class="one">
<div class="col-md-4">
<div class="inner_img_homeaway">
 <img src="https://s3-media3.fl.yelpcdn.com/bphoto/HwwmnCMrRqWqdaT-3WRhqQ/o.jpg" class="img-responsive" alt="...">
</div></div>
<div class="col-md-8 float-left">
<h1 class="float-left">Polo Towers by Diamond Resorts</h1>
    <p class="location_homeway">3745 las vagas Blavs</p>
	 <div id="colorstar" class="starrr ratable">
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 <span class="glyphicon .glyphicon-star-empty glyphicon-star-empty"></span>
	 </div>
	  <p>Last booking 6 hours ago</p>
	  <p class="view">56 others viewing this property</p>
	  <p class="rating">4.2 out of 5</p>
	 <p class="description_part">Simulation in the middle of the action.Simulation in the middle of the action....</p>
	  <p class="see_all">See All</p>
	  
	  
</div>
</div>
</div>

</div>

</div>
</div>








<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
</script>






<?php
	include('LandingPageFooter.php');
 ?>