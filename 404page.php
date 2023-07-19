<?php
  header("HTTP/1.0 404 Not Found");
  include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Page Not Found";

include("header-new.php"); 


?>
<section class="inner_page_hero sec_pad resturent-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero_section_content">
                    <h2 class="mb-5">Page Not Found</h2>
                </div>
            </div>
            <div class="col-lg-12">
              <div class="content-bannersss">
                  <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

                  <input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['full_city_name'];?>" required="">

                  <a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
              </div>   
          </div>
      </div>
  </div>
</section>
<?php include('category-navigation.php'); ?>
<section class="travels sec_pad what_do pt-0">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h2 class="mb-5">Sorry, Page not found. Please try again.</h2>
       
    </div>

</div>
</div>
</section>
<style type="text/css">
    .v2_inner_main{
      min-height: 350px;
  }
</style>
<?php include('blog-resources.php');?>
<?php include('landingPage-footer.php'); ?>

