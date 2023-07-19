<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";
$source = 'index';
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$checkIn = date("Y-m-d");
$update_date = date_create($checkIn);
date_add($update_date,date_interval_create_from_date_string("1 days"));
$checkOut =  date_format($update_date,"Y-m-d");
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>

<div class="slider-section flight-sec"> 
<div class="container">
	<div data-aos="zoom-in-left" class="myheader-sec">
	   <h2>Amazing All-Inclusive Discounts</h2>
	   <p>Checkout what we found for you from</p>
	</div>
	<div class="testimonial-section products">
      <div class="discounts_inner">
        <div class="row">
          
          
             
          <div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4 aos-init aos-animate">
            <div class="discount-block">
              <img src="/images/c2200x627.jpg" loading="lazy">
              <div class="discount-content">
              <h3>All Inclusive Invisalign</h3>
              <p>$30 for $1,500 Worth of Total Invisalign ..</p>
              </div>
              <div class="discount-action purple-bg">
              <div class="action-content">
              <p><b>Fort Collins</b> <span><b>$</b> 1500.00 <b>$30.00</b> 98% OFF</span></p>
              </div>
              <a href="https://www.tkqlhce.com/click-8265264-15193410?url=https%3A%2F%2Fwww.groupon.com%2Fdeals%2Fharbor-dental&cjsku=a93a15de-5c03-494b-b523-79d9fc3e47ee" target="_top"><img src="/mysitti-html/images/right-blue.png" loading="lazy"></a>
              </div>
            </div>
         
          </div>   
          <div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4 aos-init aos-animate">
            <div class="discount-block">
              <img src="/images/c3200x627.jpg" loading="lazy">
              <div class="discount-content">
              <h3>All inclusive Executive Limou.. </h3>
              <p>Executive Airport transfer Sedan..</p>
              </div>
              <div class="discount-action purple-bg">
              <div class="action-content">
              <p><b>Chicagorh3,</b> <span><b>$</b> 140.54 <b>$140.54</b> 0% OFF</span></p>
              </div>
              <a href="https://www.tkqlhce.com/click-8265264-15193410?url=https%3A%2F%2Fwww.groupon.com%2Fdeals%2Fviator-all-inclusive-executive-limousine&cjsku=eefd4180-b371-4c63-af02-8f35ae66999f" target="_top"><img src="/mysitti-html/images/right-blue.png" loading="lazy"></a>
              </div>
            </div>
         
          </div>  
           <div data-aos="zoom-in-right" class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4 aos-init aos-animate">
            <div class="discount-block">
              <img src="/images/c1200x627.jpg" loading="lazy">
              <div class="discount-content">
              <h3>All-Inclusive Resort Stay</h3>
              <p>5-Night All-Inclusive Grand Parad..</p>
              </div>
              <div class="discount-action purple-bg">
              <div class="action-content">
              <p><b>Fort Collins</b> <span><b>$</b> 792.06 <b>$499.00</b> 37% OFF</span></p>
              </div>
              <a href="https://www.jdoqocy.com/click-8265264-15193410?url=https%3A%2F%2Fwww.groupon.com%2Fdeals%2Fga-travel-by-jen-hotel-nyx-cancun-19&cjsku=ce021371-ae37-4ba1-9e51-8b01ebb67e33" target="_top"><img src="/mysitti-html/images/right-blue.png" loading="lazy"></a>
              </div>
            </div>
         
          </div>
     
        </div>
      </div>

	   <!--</div>-->
	   <div class="view-tag" data-aos="zoom-in-down">
			 <a href="random_deals.php?flag=All-Inclusive" class="">View all</a>
		</div>
	</div>
</div>
</div>
 <div class="slider-section new-for"> 
    <div class="container">
        <div data-aos="zoom-in-left" class="myheader-sec">
          <h2>Relaxing Beach Gateways</h2>
              <p>Here are some beautiful destinations</p>
        </div>
         <div class="travels_inner">
      <div class="row">
         <div class="testimonial-section products">
           <div class="owl-carousel owl-theme ProductSlide" id="ProductSlide">

            <?php 
          $sql = "SELECT * FROM beach limit 20 OFFSET 10";
            $result = $mysqli->query($sql);
            foreach ($result as $key => $row) {
              $print=preg_replace('/^([^,]*).*$/', '$1', $row['name']);
              $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
              $url = 'onclick="reloadLandingPage('."'".''.$print.''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"';
              ?>
              <div data-aos="zoom-in-right" class="testimonial-block product">
            <div class="cities">
                <a <?php echo $url; ?> style="color: #00002f !important;" class="cool_link">
                    <img src="<?php echo $SiteURL; ?><?php echo str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>" alt="<?php echo substr($row['name'], 0,10); ?>" loading="lazy" class="img-fluid w-100">
                  </a>
                 <a <?php echo $url; ?> style="color: #00002f !important;">
             
                    <p><?php echo substr($row['name'], 0,18); ?></p>
         
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

<div class="slider-section new-for"> 
	<div class="container">
		<div data-aos="zoom-in-left" class="myheader-sec">
		   <h2>Are You Looking To Travel In The US</h2>
		   <p>Take a look at these US travel destination ideas</p>
		</div>
		<div class="testimonial-section products">
		   <div class="owl-carousel owl-theme ProductSlide" id="ProductSlide">
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
            <a onclick="reloadLandingPage('Los Angeles',this)" href="random_deals.php?flag=Vacations&city=Los Angeles" class="cool_link">
						<img src="images/city_images/los_new_agn.jpg" loading="lazy">
          </a>
						<a onclick="reloadLandingPage('Los Angeles',this)" href="random_deals.php?flag=Vacations&city=Los Angeles">
						<p>los angeles</p></a>
						 
				   </div>
			   </div>
			   <div data-aos="zoom-in-left" class="testimonial-block product">
				  <div class="cities">
            <a onclick="reloadLandingPage('San Francisco',this)" href="random_deals.php?flag=Vacations&city=San Francisco" class="cool_link">
						<img src="images/city_images/san-francisc.jpeg" loading="lazy">
          </a>
						<a onclick="reloadLandingPage('San Francisco',this)" href="random_deals.php?flag=Vacations&city=San Francisco"><p>San Francisco</p></a>
				   </div>
			   </div>
           
			   <div data-aos="zoom-in-right" class="testimonial-block product">
				   <div class="cities">
            <a onclick="reloadLandingPage('Chicago',this)" href="random_deals.php?flag=Vacations&city=Chicago" class="cool_link">
						<img src="images/city_images/chicagoNew.jpg" loading="lazy">
          </a>
						  <a onclick="reloadLandingPage('Chicago',this)" href="random_deals.php?flag=Vacations&city=Chicago"><p>Chicago</p></a>
				   </div>
			   </div>
          
			   <div data-aos="zoom-in-left" class="testimonial-block product">
				  <div class="cities">
            <a onclick="reloadLandingPage('Las Vegas',this)" href="random_deals.php?flag=Vacations&city=Las Vegas" class="cool_link">
						<img src="images/city_images/las-vegas-1.jpg" loading="lazy">
          </a>
						<a onclick="reloadLandingPage('Las Vegas',this)" href="random_deals.php?flag=Vacations&city=Las Vegas"><p>las vegas</p></a>
				   </div>
			   </div>
			    
		   </div>
		</div>
		<div class="view-tag" data-aos="zoom-in-down">
			 <a href="random_deals.php?flag=Vacations" class="">View all</a>
		</div>
	</div>
</div>



<div class="slider-section flight-sec new-for"> 
<div class="container">
	<div data-aos="zoom-in-left" class="myheader-sec">
	   <h2>See Beautiful America</h2>
	   <p>Enjoy the scenic views of National Parks</p>
	</div>
	<div class="testimonial-section products">
	   <div class="ProductSlide1" id="ProductSlide1">
	   
<?php if(!$detect->isMobile()){ ?>
     <div class="see_beautiful_inner">
      <div class="row">
	  <?php $sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 3";
        $result = $mysqli->query($sql);?>
        <?php foreach($result as $key=>$value){ ?>
	  <div data-aos="zoom-in-right" class=" col-md-4  testimonial-block product">
		   <div class="cities">
         <a href="<?php echo $value['link']; ?>" class="cool_link">
				<img src="<?php echo $value['image_link']; ?>" loading="lazy">
      </a>
				 <a href="<?php echo $value['link']; ?>" ><?php echo substr($value['title'],0,25)."...";?></p></a>
		   </div>
	  </div>
	  <?php
		}?>
    </div>
  </div>
<?php }else{?>

 <div class="row">
  <?php
  $sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 3";
  $result = $mysqli->query($sql);?>
  <?php foreach($result as $key=>$value){ ?>
  <div data-aos="zoom-in-right" class=" col-md-4 testimonial-block product">
	   <div class="cities">
       <a href="<?php echo $value['link']; ?>" class="cool_link">
			<img src="<?php echo $value['image_link']; ?>" loading="lazy">
    </a>
			<a href="<?php echo $value['link']; ?>"><p><?php echo substr($value['title'],0,25)."...";?></p></a>
	   </div>
	</div>
  
<?php } ?>
</div>


<?php } ?>

	   </div>
	</div>
	<div class="view-tag" data-aos="zoom-in-down">
		  <a href="javascript:void();" class="viewAll" keyword="Beautiful America">View all</a>
	</div>
</div>
</div>


<!--end of see_beautiful -->

<div class="slider-section tour-sec discount-section general-world new-for"> 
		<div class="container">
		<div data-aos="zoom-in-left" class="myheader-sec aos-init aos-animate">
<h2>Want to see the World</h2>
              <p>Checkout are unbelievable tour packages</p>

</div>
			<div class="row">
				<div data-aos="zoom-in-right" class="col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="blog-block">
						<ul>
							<li class="discount-block" data-aos="zoom-in-right">
								<div class="cities">
                  <a href="https://www.dpbolvw.net/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fgalapagos-central-south-east-aboard-yolita%2FSEV10YB%2F&cjsku=SEV10YB" target="_blank" class="cool_link">
									<img src="images/my1.jpg" class="world_tour_img" loading="lazy">
                </a>
									<a href="https://www.dpbolvw.net/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fgalapagos-central-south-east-aboard-yolita%2FSEV10YB%2F&cjsku=SEV10YB" target="_blank"><p>South America</p></a>
								</div>
							</li>
							<li class="discount-block" data-aos="zoom-in-left">
								<div class="cities">
                    <a href="https://www.kqzyfj.com/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fa-month-in-central-america-beyond-tulum-and-tikal%2FCMMG%2F&cjsku=CMMG" target="_blank" class="cool_link">
									<img src="images/my2.jpg" class="world_tour_img" loading="lazy">
                </a>
									<a href="https://www.kqzyfj.com/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fa-month-in-central-america-beyond-tulum-and-tikal%2FCMMG%2F&cjsku=CMMG" target="_blank"><p>Central America</p></a>
								</div>
							</li>
							<li class="discount-block" data-aos="zoom-in-left">
								<div class="cities">
                  <a href="https://www.anrdoezrs.net/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fhimalayan-adventure-india-nepal-bhutan%2FAHDB%2F&cjsku=AHDB" target="_blank">
									<img src="images/my3.jpg" class="world_tour_img" loading="lazy">
                </a>
									<a href="https://www.anrdoezrs.net/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fhimalayan-adventure-india-nepal-bhutan%2FAHDB%2F&cjsku=AHDB" target="_blank"><p>Asia</p></a>
								</div>
							</li>
							<li class="discount-block" data-aos="zoom-in-left">
								<div class="cities">
                  <a href="https://www.jdoqocy.com/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fsouthern-africa-tour%2FDAVV%2F&cjsku=DAVV" target="_blank">
									<img src="images/my1.jpg" loading="lazy">
                </a>
									<a href="https://www.jdoqocy.com/click-8265264-14470047?url=https%3A%2F%2Fwww.gadventures.com%2Ftrips%2Fsouthern-africa-tour%2FDAVV%2F&cjsku=DAVV" target="_blank"><p style="width: 20%;">Africa</p></a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			  <div class="view-tag" data-aos="zoom-in-down">
        <a href="/random_deals.php?flag=adventure" class="">View all</a>
    </div>
			</div>
		</div>
	</div>

