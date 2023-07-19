<?php
$titleofpage="Cheap Car Rentals Deals | Book Online | MySittiVacations"; 
//include("header-new.php");
include('header-newfile.php');
session_start();

$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
$meta_description = "Do you want to rent from companies you know and trust?
There is a lot of competition out there. Companies are trying to sell their products to you. So why should you choose them? We've heard people say that you should only buy from a company you know and trust. But isn't it better to buy from someone you don't know if they are offering you a better price than the company you already know? We all like to get a bargain, but it's not always a good idea to shop around. If you are shopping for a new car, it might make sense to look at several different dealerships to see which one offers the best deal. But when it comes to your home, your health, or your retirement, it's usually a bad idea to shop around. You are in a unique position to make the right decision for you and your family, so don't take any risks. Just stick with the company you trust. When looking for your next apartment, you may be wondering where to go to find the best apartments. Some people make the mistake of picking companies at random, not knowing what they are getting into. It's because of this that we are introducing a new group of apartments that are available to you. We want you to join our family and enjoy the highest quality apartments at a fair price! We think you'll love our apartments because of the amenities and the friendly staff. These are only the beginning of the things that make our apartments special. You'll have to come see it for yourself!
With MySittiVacation, you can rent, save, and earn money with the companies you know and trust.
MySittiVacation is an online platform where you can earn money by renting and saving products you already use. You don't need to buy anything new, so you won't have to worry about breaking the bank. While there are many vacation rental services out there, not all of them are trustworthy and safe. By choosing MySittiVacation, you're choosing a great service that is both safe and easy to use. We have earned a great reputation among travelers and vacation house owners. By using our website, you can choose from a variety of resorts, villas, and apartments. You can book your stay at a popular resort or an exotic villa; the choice is yours! You can also choose the area you want to be in. You can choose to explore a new city, town, or area of your country. This is great for anyone who wants to see the best that their country has to offer, or is itching to travel abroad!
It's easy, cheaper, and safe.
There are a lot of things you can buy online for cheap, but they are not always worth your money. For example, buying a cheap car can cost you hundreds of dollars, and then you have to buy expensive repairs for maintenance. On the other hand, Not only that, but if you rent in, it is possible to save first until you have the time to buy it fully, and it's easy, safer, and cheaper. If your dream vacations are full of joy and excitement, you need to join mysittyvacations.com today! You can book an amazing vacation at an incredibly cheap price! How? By simply following the website's tips, guides, and information, It's easy if you know what to do!
Book your rental car today!
The best way to book your rental car is to do it online. Not only will it save you money, but you'll also get to pick the exact model that you want and get the best deal. We recommend that you do this when booking your rental car in advance, because there are always deals available.If you're searching for cheap rental cars, you're in luck. We've got a large selection of rental cars at prices you can afford. In fact, our prices are so cheap that we not only guarantee you'll save money, but that you'll have a smile on your face when you get behind the wheel! Whether you're planning a business trip or a vacation, you'll find that our cars are high quality and they're safe. Not only do we have many different types of cars, but we also have SUVs, vans, and more!";
?>

<style type="text/css">
	ul.popular__list.carRentelWidgrt {
    width: 100% !important;
}
.nearby-sec.popular-sec a .popular.img-sec img {
    border-radius: 10px;
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.nearby-sec.popular-sec a .popular.img-sec {
    margin: 0 10px 0 0;
}
.popular {
    padding: 6px 0 6px !important;
    background: unset !important;
}
.nearby-sec.popular-sec a {
    border-bottom: 1px solid #ccc;
    padding: 10px 10px 10px;
}
.nearby-sec a {
    display: flex;
    align-items: center;
    font-size: 18px;
    padding: 10px 10px 10px;
    border-radius: 0px;
    color: #000;
}
.nearby-sec.popular-sec {
    border: 0;
    margin: 0;
    padding: 0;
}
.popular-modal .modal-header input {
    width: 100%;
    border: 0 !important;
    border-bottom: 2px solid #000 !important;
    height: 50px;
    padding: 0 0 0 35px;
    margin: 0px;
    font-size: 16px;
}
.nearby-sec.popular-sec a .popular.content-sec p {
    margin: 0;
    font-weight: 600;
    font-size: 16px;
    line-height: 21px;
}
.nearby-sec.popular-sec a .popular.content-sec p span {
    display: block;
    font-weight: 400;
    font-size: 14px;
}
.popular-modal .modal-header i#hitAjaxCity {
    font-size: 21px !important;
    position: absolute !important;
    left: 0;
    top: 24px !important;
}
.popular-modal .modal-header {
    position: relative;
    padding: 10px 0 0px;
    display: flex;
    align-items: center;
}
.nearby-sec.popular-sec h3 {
    font-size: 12px;
    font-weight: 600;
    margin: 0 0 10px;
}
.rent-with {
    font-weight: 500;
}
.rent-flifgt-deals h2 {
    font-weight: 500;
}
#v2_wrapper {
    margin: 160px 0 0px !important;
}
.rent-with {
    line-height: 40px;
}
.v2_banner_top1.h_auto .bx-wrapper .bx-viewport {
  padding: 0;
  position: absolute !important;
}
.v2_header_wrapper.deals_wrapper {
    display: none;
}
.v2_content_inner_topslider.spacer1 {
    margin-top: 0px !important;
}
.new_fill {
   position: absolute;
left: 44%;
top: 70px;
z-index: 99999999;
color: #fff;
font-size: 18px;
font-weight: 600;
}
.v2_banner_top .v2_header_wrapper {
    height: 400px;
}
.v2_header_wrapper .bx-viewport {
    height: 440px!important;
}
#powered_by_3873 iframe#discoFrameId {
     background-color: #fff;
    padding: 15px;
    max-width: 550px;
    height: 475px;
    margin-left: 75px;
    margin-top: 15px;
    margin-right: 20px;
}
button#sb-form-submit {
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
    letter-spacing: .5px;
    padding: 10px 25px;
    border-radius: 100px;
    color: #fff;
    font-size: 21px;
    text-decoration: none;
    height: 75px;
    display: block;
    text-align: center;
    line-height: 60px;
}
.feature-section.car-feature {
    padding-top: 150px !important;
}
.pick-up .sb-select-box {
    margin: 0 10px 0 0;
    border: 0;
}

.pick-up .sb-select-box select {
    border: 1px solid #ccc;
    border-radius: 30px;
    margin: 0;
}
.free-trail-form .search-content {
    margin: 20px auto !important;
    max-width: 1050px !important;
}
@media (max-width: 767px){
	.cascoon.cascoon-4734.cascoon-4734_2, .cascoon.cascoon-4734.cascoon-4734_2 .cascoon-like-wrapper {
    height: 353px !important;
}
.popular-modal .modal-header i#hitAjaxCity {
    top: 0px !important;
}
ul.popular__list.carRentelWidgrt {
    white-space: normal!important;
}
.popular__list > li {
    width: 100%!important;
}
footer.footer.sec_pad {overflow: initial;padding: 0 !important;display: inline-block;text-align: center;}
footer.footer.sec_pad img.logo.footer_logo {margin: 0;}
.rent-with {font-size: 28px;font-weight: 600!important;margin: 10px auto;}
.category li {width: 47% !important;margin: 0 8px 0 0!important;}
.category li a {font-size: 14px!important;}
.category h4 {margin-bottom: 30px!important;}
.category {margin: 40px 0 40px!important;}
.category li:nth-child(2), .category li:nth-child(4), .category li:nth-child(6), .category li:nth-child(8) {margin: 0 0px 0 0 !important;}
.rent-logo img {border: 1px solid #ccc;height: 70px;object-fit: contain;}
.cascoon.cascoon-4734.cascoon-4734_2{height: 335px !important;}
.rent-logo li {height: 70px;width: 49%;}
.weedle-widget .weedle-offers_list {height: 174px !important;}
.rent-logo > ul {margin: 15px 0 0;}
	ul li .weedle-widget {padding: 0px!important;}
	#powered_by_3873 iframe#discoFrameId {
	background-color: #fff;
    padding: 0px;
    max-width: 93%;
    height: 480px;
    margin-left: 15px;
    margin-top: 50px;
    margin-right: 15px;
    margin-bottom: 20px;
}
	.v2_content_wrapper #aside-adds {
    height: auto !important;
}
	p.rent-with {
    float: left;
    width: 100%;
}
img.img-responsive {
    width: 100%;
}
.v2_header_wrapper .bx-wrapper img {
    height: 300px !important;
}
.car_rentals_form .widget-form {
    padding: 15px !important;
}
.v2_banner_top .v2_header_wrapper {
    height: 275px;
}
	#atrl .row{
		display: block !important; 
	}
.hotels-adds img {
    margin-top: 100px !important;
}
#v2_wrapper {
    margin: 110px 0 0px !important;
}
.new_fill {
	left: 0%;
	top: 75px;
	}
	.v2_content_inner2 #aside-adds{
		width: 100% !important;
	}
	.blissey-widget{
		display: block !important;
	}
  .rent-flifgt-deals .weedle-widget{
    max-width: 100% !important;
  }
  section.category li a {
    font-size: 13px !important;
}

.feature-section.car-feature {
    padding-top: 0px !important;
}
	}
    
    
	aside#aside-adds{
		width: 21% !important;
		height: 100vh !important;
		overflow: auto;
	}
.sidebar{box-shadow:none}@media(max-width:480px){.v2_header_wrapper .bx-wrapper{display:none}.v2_banner_top .v2_header_wrapper{margin-bottom:0}.v2_header_wrapper{position:absolute}}.innerCurrentCity1{margin-top:0;text-align:center;width:75%}aside.sidebar{width:30%!important}.v2_content_inner2 article.oneArticle{width:56%!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.new_header_top{position:static}.loading:before,.loading:not(:required):after{content:'';display:block}@media(max-width:991px){.v2_top_nav{position:fixed!important}}.loading,.loading:before{position:fixed;top:0;left:0}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
    
.rent-flifgt-deals .popular__list > li .cascoon{
    min-height: 350px !important;
}
iframe#discoFrameId {
    margin: 0 !important;
    max-width: 100% !important;
    padding: 0 !important;
    height: 450px !important;
}
iframe#discoFrameId .search-box-wrapper .container {
    width: 100%;
    max-width: 100%;
}
.business-block a img {
    margin: 0 10px 0 0;
}
.business-block a {
    padding: 20px 15px;
}
.business-block p {
   font-size: 22px;
   margin-bottom: 0;
}
.myheader-sec h2,.top-heading-section h1{
    font-weight: 700;
}
.feat-blogs .f-blog-content #title #title div {
    height: 220px !important;
    border-radius: 20px !important;
}
.feat-blogs .f-blog-content .cascoon-app .cascoon-widget-resize-container {
    border-radius: 20px !important;
    border: none !important;
}
.feat-blogs .f-blog-content .cascoon-app {
    margin-bottom: 0 !important;
}    
body .slider-section.feat-blogs.audio .discount-block .f-blog-content div#wrapper.cascoon-wrapper.cascoon-wrapper.cascoon-node.cascoon-s--12.cascoon-align--left div#title_origin div#title_origin.cascoon-form-text.cascoon-title_origin span {
    color: #000 !important;
}
.free-trail-form.car-rental {
    max-width: 70%;
    }

@media screen and (max-width:767px){
    .free-trail-form.car-rental {max-width: 100%;top: 0px;}
    iframe#discoFrameId { margin: 0 auto !important;max-width: 95% !important;padding: 0 !important;height: 470px !important;display: block;}
    .free-trail-form.car-rental .search-content {border-radius: 10px;padding: 10px 0 0;}
    .business-block p {font-size: 13px !important;line-height: 21px;}
    .business-block a {padding: 10px !important;}
    .banner-section.hotel-hero {padding: 40px 0 0;margin: 25px 0 20px;}
    .car-sec img { width: 100%;}
    .slider-section.car-multiple ul {margin: 50px 0 0;padding: 0;justify-content: space-between;}
    .slider-section.car-multiple ul li {width: 47%;margin: 0 3px 10px;}
    .mobile-hero {display: block;}
}
</style>

<div data-aos="zoom-in-right" class="banner-section hotel-hero comedy-sec car-rental" style="background-image:url(images/car-hero.png)"> 
			<div class="container">
				<div class="mobile-hero">
					<img src="images/car-hero.png">
				</div>
				<div class="view-all-sec">
					<div class="view-tag" data-aos="zoom-in-down">
						<a href="#">Search</a>
					</div>
				</div>
				<div class="free-trail-form car-rental">
			       <div class="container">
						<div class="row justify-content-center">
							<div class="col-md-12">
								<div class="search-content">
                                    <?php
        if(isset($_SESSION['city_name'])){
            $search = $_SESSION['city_name'];
        }else{
            $search = 'chicago';
        }
        if($search == 'Washington D.C.'){
            $search = 'washington';
        }
        $search_ci = str_replace(" ","-",$search);
        $guide_city = "SELECT * FROM  discover_cars WHERE location LIKE '%".$search_ci."%' LIMIT 2";
        $guide_city_result = $mysqli->query($guide_city);
        foreach ($guide_city_result as $key => $value) {
            $search_city = $value['location'];
        }
        $count = $guide_city_result->num_rows;
        if($count == 0){
            $search_city = 'chicago';
        }
         ?>
<script src="https://c117.travelpayouts.com/content?promo_id=3873&shmarker=iddqd&location=<?php echo $search_city; ?>&locale=en&bg_color=transparent&font_color=333333&button_color=0355a9&button_font_color=ffffff&button_text=Search&powered_by=true" charset="utf-8" async="true"></script>

								</div>
							</div>
						</div>
					</div>
				</div>
		   </div>
		</div>


<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
	
		<div class="v2_content_inner2">
		<div class="planTap custom-homestay-plan"></div>

		  <aside class="sidebar v2_sidebar" id="car-aside" style="display: none;">

          
			<div class="hotels-adds">
				

			<a href="https://www.kqzyfj.com/click-8265264-13333040" target="_top">
			<img src="https://www.awltovhc.com/image-8265264-13333040" width="100%" height="" alt="" border="0"/></a>


			</div>
		 </aside>

		<div id="loader"></div>
		
		
<div class="container recommed-city" style="text-align: center;">
    <?php include('category-newfile.php'); ?>
  <!--   <a href="https://www.tkqlhce.com/click-8265264-13799498" target="_top">
<img src="https://www.awltovhc.com/image-8265264-13799498" width="728" height="90" alt="" border="0"/></a> -->
      </div>

		  
		<div class="slider-section car-multiple"> 
			<div class="container">
			  <div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Rent With Companies You Know and Trust</h2>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="car-sec">
						   <img src="images/car-rent-logo/multiple-car.png">
						</div>
						  <ul>
							<li><img src="/images/car-rent-logo/brand1.png"></li>
							<li><img src="/images/car-rent-logo/brand2.png"></li>
							<li><img src="/images/car-rent-logo/brand3.png"></li>
							<li><img src="/images/car-rent-logo/brand4.png"></li>
							<li><img src="/images/car-rent-logo/brand5.png"></li>
							<li><img src="/images/car-rent-logo/brand6.png"></li>
						  </ul>
					</div>
			  </div>
			</div>
			</div>
			
		</div>
	</div>
</div>

<div class="slider-section feat-blogs audio"> 
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<div data-aos="zoom-in-left" class="myheader-sec">
						   <h2>Our Featured Blogs</h2>
						   <p>Find fun places to see and things to do experience the art, museums, music, zoos</p>
						</div>
					</div>
					<div class="col-12 col-sm-4 col-md-4 col-lg-4">
						<div class="discount-block">
							<div class="feat-blog-img">
								<!--<img src="images/f-blog1.png">-->
								<a href="#"><h3>London <span>United Kingdom</span></h3></a>
							</div>
							<div class="f-blog-content">
								<script async src="//www.travelpayouts.com/weedle/widget.js?marker=130544&host=flights.mysittivacations.com%2Fflights&locale=en&currency=usd&powered_by=false&secondary=%230C0909&destination=LON&destination_name=London" charset="UTF-8"></script>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-4 col-md-4 col-lg-4">
						<div class="discount-block">
							<div class="feat-blog-img">
								<!--<img src="images/f-blog2.png">-->
								<a href="#"><h3>London <span>United Kingdom</span></h3></a>
							</div>
							<div class="f-blog-content">
								<script async src="//www.travelpayouts.com/weedle/widget.js?marker=130544&host=flights.mysittivacations.com%2Fflights&locale=en&currency=usd&powered_by=false&secondary=%230C0909&destination=BKK&destination_name=Bangkok" charset="UTF-8"></script>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-4 col-md-4 col-lg-4">
						<div class="discount-block">
							<div class="feat-blog-img">
								<!--<img src="images/f-blog3.png">-->
								<a href="#"><h3>London <span>United Kingdom</span></h3></a>
							</div>
							<div class="f-blog-content">
								 <script async src="//www.travelpayouts.com/weedle/widget.js?marker=130544&host=flights.mysittivacations.com%2Fflights&locale=en&currency=usd&powered_by=false&secondary=%230C0909&destination=PAR&destination_name=Paris" charset="UTF-8"></script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
include('footer-newfile.php'); 
	//include('LandingPageFooter.php');

