<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$sql = "select * from `pages` where page_name like '%About us%'";
$policyArray = $Obj->select($sql) ; 
$about_us=$policyArray[0]['page_data'];
$titleofpage="About Us | MySittiVacations";

// if(isset($_SESSION['user_id']))
// {
//       include('NewHeadeHost.php');
// }
// else {
include("home_header.php");

// }

?>
<style type="text/css">
	     .pac-container {
    z-index: 9999 !important;
}
iframe{
	width: 650px;
    height: 366px;
    margin: 0 auto;
    display: block;
}
.flight-sec:before{
	display: none;
}
</style>
<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec" style="background-image:url(images/aboutuss.jpg)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/aboutuss.jpg">
				</div>
			<!-- 	<div class="carousel-caption-top">
				   <h1>About US</h1>
				</div> -->
				<div class="view-all-sec">
					<div class="view-tag" data-aos="zoom-in-down">
						<a href="#">Search</a>
					</div>
				</div>
				<div class="free-trail-form">
			       <div class="container">
						<div class="row">
							<div class="col-md-12 col-12">
								<div class="search-content hotels">
									<ul>
										<li>
											<div class="form-group">
												<input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

											<input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>" required="">

											<a id="hitAjaxwithCity" class="search-btn hitbutton" href="#">Search</a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
			   </div>
		   </div>
		</div>
 <?php include('category-newfile.php'); ?>
<div class="slider-section flight-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="mb-3">About US</h2>
        <p><?php echo $about_us; ?></p>
    </div>

    <div class="col-lg-12">                  
        <div class="youtvideo546465">
          <!-- <iframe height="220" src="https://www.youtube.com/embed/kcr7pO451Yw" width="550"></iframe> -->
          <!-- <iframe height="220" src="https://mysitti.com/video/FINAL%20(DM%20Motion%20graphics).mp4" width="550"></iframe> -->

          <iframe height="220" src="https://mysittivacations.com/video/FINAL%20(DM%20Motion%20graphics).mp4" width="100%"></iframe>
      </div> 
  </div>
</div>
</div>
</section>
<style type="text/css">
    .v2_inner_main{
      min-height: 350px;
  }
</style>
<?php include('blog-resources-new.php');?>
<?php include('landingPage-footer.php'); ?>

