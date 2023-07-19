<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";
$info        = $_POST['info'];
$source = 'index';
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$checkIn = date("Y-m-d");
$update_date = date_create($checkIn);
date_add($update_date,date_interval_create_from_date_string("1 days"));
$checkOut =  date_format($update_date,"Y-m-d");
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
function groupon_api_call($limit,$city,$key){
    $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&address=".urlencode($_SESSION['city_name']);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
    $responseJson = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($responseJson);

    if ($response->status == 'OK') {
      $latitude = $response->results[0]->geometry->location->lat;
      $longitude = $response->results[0]->geometry->location->lng;
    } 
    if(!empty($city)):
      $prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
      $key = str_replace(' ','+',$key);
      $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
      $output= json_decode($geocode);
      $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;

      $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
    // endif;
    else:

      if(!empty($key)):
        if($key == 'restaurants'){
          $urlgo = "https://www.groupon.com/occasion/deals-json?filterQuery=(subcategory:".$key.")&context=web_holiday&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=holiday&apiFacets=topcategory%7Ccategory%7Ccategory2%7Ccategory3%2Cdeal_type&sort=price:desc&includeHtml=true&offset=0&limit=3";
        } else {
          $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)&context=web_getaways&showBestOption=true&divisionLoc=".$latitude.",".$longitude."&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
        }
      else:
        $urlgo ="https://www.groupon.com/occasion/deals-json?filterQuery=(deal_type:groupon-deals-2987)%20AND%20context=web_getaways&showBestOption=true&divisionLoc=41.184,-96.15&divisionLocale=en_US&pageType=getaways&includeHtml=true&offset=0&limit=3";
      endif;
    endif;
    $result_get = file_get_contents($urlgo);
    $get_all_data = json_decode($result_get, true);
    $get_deals = $get_all_data['deals'];
    return $get_deals;
  }
  ?>
<?php if (isset($info)): 

  $get_deals = groupon_api_call('3','','all%20inclusive');
  //if(!empty($get_deals)):
  ?>

<section class="discounts sec_pad" data-aos="fade-up" data-aos-duration="1000">
  <div class="container">
    <div class="heading">
      <div class="row">
        <div class="col-lg-9">
          <h4>Amazing All-Inclusives  Discounts</h4>
          <p>Checkout what we found for you from </p>
        </div>
        <div class="col-lg-3 text-lg-end">
          <a href="random_deals.php" class="btn btn-outline-dark px-4">View all</a>
        </div>
      </div>
    </div>
    <?php

    ?>
    <?php if(!$detect->isMobile()){ ?>
      <div class="discounts_inner">
        <div class="row">
          <?php  $i=0; foreach ($get_deals as $homeData): ?>

          <div class="col-lg-4 all-inclusive section_<?php echo $i; ?>">
              <?php $i++; 
              echo $homeData['cardHtml'];
              
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
              $tourname = $homeData['merchant']['name']; 
              $out =  substr($tourname,0,60);
              ?> 
              <script>
                $(document).ready( function (){
                 var pics_str = $('.section_<?php echo $i; ?> .cui-image').data('srcset');
                  // var pics_arr = '';
                  if(pics_str != undefined){
                   var pics_arr = pics_str.split(',');
                   console.log('.section_<?php echo $i; ?>');
                   pics_str = '';
                   $.each(pics_arr, function(index, el) {
                    imgPath = this.trim();
                    imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   $('.section_<?php echo $i; ?> .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
                 });
                 }
               });
             </script> 
           </div>
             
          <?php endforeach; ?>
        </div>
      </div>
    <?php }else{ ?>
    <div class="discounts_inner">
      <div class="client  owl-theme">
        <?php  $i=0; foreach ($get_deals as $homeData): ?>

        <div class="item all-inclusive section_<?php echo $i; ?>">
              <?php $i++; 
              echo $homeData['cardHtml'];
              
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
              $tourname = $homeData['merchant']['name']; 
              $out =  substr($tourname,0,60);
              ?>  
            </div>
            <script>
              $(document).ready( function (){
               var pics_str = $('.section_<?php echo $i; ?> .cui-image').data('srcset');
                  // var pics_arr = '';
                  if(pics_str != undefined){
                   var pics_arr = pics_str.split(',');
                   console.log('.section_<?php echo $i; ?>');
                   pics_str = '';
                   $.each(pics_arr, function(index, el) {
                    imgPath = this.trim();
                    imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   $('.section_<?php echo $i; ?> .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
                 });
                 }
               });
             </script> 
          
          <?php endforeach; ?>
        </div>
      </div>

    <?php } ?>
  </div>
</section>
<!--end of discounts -->
<section class="travels sec_pad bg_grey inspiratinSection">
  <div class="container">
    <div class="heading">
      <div class="row">
        <div class="col-lg-9">
          <h4>Are You Looking To Travel In The US</h4>
          <p>Take a look at these US travel destination ideas</p>
        </div>
        <div class="col-lg-3 text-lg-end">
          <a href="random_deals.php?flag=Vacations" class="btn btn-outline-dark px-4">View all</a>
        </div>
      </div>
    </div>
    <div class="travels_inner">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1500">
          <div class="grid">
            <a onclick="reloadLandingPage('Los Angeles',this)" href="random_deals.php?flag=Vacations&city=Los Angeles">
              <div class="image_sq_htfix">  
                <img src="img/img8.png" class="img-fluid w-100" loading="lazy">
              </div>
              <h3>los angeles</h3>
            </a>
            <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1500">
          <div class="grid">
            <a onclick="reloadLandingPage('San Francisco',this)" href="random_deals.php?flag=Vacations&city=San Francisco">
              <div class="image_sq_htfix">  

                <img src="img/img9.png" class="img-fluid w-100" loading="lazy">
              </div>
              <h3>san francisco</h3>
            </a>
            <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1500">
          <div class="grid">
           <a onclick="reloadLandingPage('Chicago',this)" href="random_deals.php?flag=Vacations&city=Chicago">
             <div class="image_sq_htfix">  

               <img src="img/img10.png" class="img-fluid w-100" loading="lazy">
             </div>
             <h3>chicago</h3>
           </a>
           <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></i></a>
         </div>
       </div>
       <div class="col-lg-3 col-md-6 col-6" data-aos="fade-up" data-aos-duration="1500">
        <div class="grid">
         <a onclick="reloadLandingPage('Las Vegas',this)" href="random_deals.php?flag=Vacations&city=Las Vegas">
           <div class="image_sq_htfix">  

             <img src="img/img11.png" class="img-fluid w-100" loading="lazy">
           </div>
           <h3>las vegas</h3>
         </a>
         <a href="#" class="like"><i class="far fa-star"></i><i class="fas fa-star"></i></i></a>
       </div>
     </div>
   </div>
 </div>
</div>
</section>
<!--end of travels-->
<section class="memories sec_pad">
  <div class="container-fluid">
    <div class="memories_heading">
      <h4>Travel Inspirations</h4>
      <!--  <p>At vero eos et accusamus et iusto odio dignissimos ducimus blanditiis praesentium voluptatum deleniti atque corrupti </p> -->
      <a href="#" data-toggle="modal" data-target="#travel_inspiration" target="_blank" class="travel_inspiration_pas btn btn-outline-dark px-4">See More Inspirations</a>
    </div>
  </div>

  <div class="memories_inner">
    <div class="d-lg-flex">
      <div class="grid grid1" data-aos="fade-up" data-aos-duration="1500">
        <a href="javascript:void(0);" class="popular_des_travel" data-atr="New York"> <img src="img/img12-new.png" class="img-fluid w-100" loading="lazy"> </a>
      </div>

      <div class="grid grid2" data-aos="fade-down" data-aos-duration="1500">
        <a href="javascript:void(0);" class="popular_des_travel" data-atr="Chicago"><img src="img/img13-new.png" class="img-fluid w-100 memories2" loading="lazy"> </a>
      </div>

      <div class="grid grid3" data-aos="fade-up" data-aos-duration="1500">
       <a href="javascript:void(0);" class="popular_des_travel" data-atr="Los Angeles"> <img src="img/img14-new.png" class="img-fluid w-100 memories3" loading="lazy"></a>
     </div>
 <?php if(!$detect->isMobile()) { ?>
     <div class="grid grid4" data-aos="fade-down" data-aos-duration="1500">
      <a href="javascript:void(0);" class="popular_des_travel" data-atr="San Francisco"><img src="img/img15-new.png" class="img-fluid w-100 memories4" loading="lazy"></a>
    </div>

    <div class="grid grid5" data-aos="fade-up" data-aos-duration="1500">
      <a href="javascript:void(0);" class="popular_des_travel" data-atr="Austin"><img src="img/img16-new.png" class="img-fluid w-100 memories5" loading="lazy"></a>
    </div>
<?php } ?>
  </div>
  <input type="hidden" value="" class="general_popup_vel "> 
  <img src="img/bg3.png" class="memories_bg_img">
</div>

</section>
<!--end of memories-->
<section class="see_beautiful sec_pad">
  <div class="container">
    <div class="heading">
      <div class="row">
        <div class="col-lg-9">
          <h4>See Beautiful America</h4>
          <p>Enjoy the scenic views of National Parks</p>
        </div>
        <div class="col-lg-3 text-lg-end">
         <a href="#" data-toggle="modal" data-target="#national_parks" target="_blank" class="national_pas btn btn-outline-dark px-4">View all</a>
       </div>
     </div>
   </div>
   <?php if(!$detect->isMobile()){ ?>
     <div class="see_beautiful_inner">
      <div class="row">
        <?php
        $sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 3";
        $result = $mysqli->query($sql);?>
        <?php foreach($result as $key=>$value){ ?>
         <div class="col-lg-4">
          <div class="grid">
            <a href="<?php echo $value['link']; ?>" style="color: #00002f !important;">
              <div class="image_htfix">
                <img src="<?php echo $value['image_link']; ?>" loading="lazy" class="img-fluid w-100">
              </div>
              <div class="item_content">
                <h3><?php echo substr($value['title'],0,25)."...";?></h3>
                <!--  <p>At vero eos et accusamus et iusto odio dignissimos ducimus </p> -->
              </div>
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php }else{?>

 <div class="client owl-carousel owl-theme">
  <?php
  $sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 3";
  $result = $mysqli->query($sql);?>
  <?php foreach($result as $key=>$value){ ?>
   <div class="col-lg-4 item">
    <div class="grid">
      <a href="<?php echo $value['link']; ?>" style="color: #00002f !important;">
        <div class="image_htfix">
          <img src="<?php echo $value['image_link']; ?>" loading="lazy" class="img-fluid w-100">
        </div>
        <div class="item_content">
          <h3><?php echo substr($value['title'],0,25)."...";?></h3>
          <!--  <p>At vero eos et accusamus et iusto odio dignissimos ducimus </p> -->
        </div>
      </a>
    </div>
  </div>
<?php } ?>
</div>
<?php } ?>
</div>
</section>
<!--end of see_beautiful -->
<?php
//endif;
$s = 0; 
foreach ($info as $data): ?>
  <?php if($data):?>
    <section class="gateways sec_pad bg_grey">
      <div class="container">
        <div class="heading">
          <div class="row">
            <div class="col-lg-9">
              <h4>Relaxing Beach Gateways</h4>
              <p>Here are some beautiful destinations</p>
            </div>
            <div class="col-lg-3 text-lg-end">
              <a  href="#" data-toggle="modal" data-target="#popularcitiesModal" data-afflication="<?php echo $data['afflication_name'] ;?>" data-page="<?php echo $data['source']; ?>" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" class="open-CitiesDialog beach-seall btn btn-outline-dark px-4">View all</a>
            </div>
          </div>
        </div>
        <div class="gateways_inner">
          <div class="row">
            <?php 
            $sql = "SELECT * FROM ".$data['tableName']." limit 4 OFFSET 10";
            $result = $mysqli->query($sql);
            foreach ($result as $key => $row) {
              $print=preg_replace('/^([^,]*).*$/', '$1', $row['name']);
              $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
              $url = 'onclick="reloadLandingPage('."'".''.$print.''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"';
              ?>
              <div class="col-lg-3 col-md-6 col-6">
                <div class="item">
                 <a <?php echo $url; ?> style="color: #00002f !important;">
                   <div class="image_htfix_mid">
                    <img src="<?php echo $SiteURL; ?><?php echo str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>" alt="<?php echo substr($row['name'], 0,10); ?>" loading="lazy" class="img-fluid w-100">
                  </div>
                  <div class="item_content">
                    <h3><?php echo substr($row['name'], 0,18); ?></h3>
                  </div>
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php  endif; 
//end of gateways 

if($data['name'] == 'Top US Cities to Visit'){?>
  <div class="container recommed-city general_home_page_add " style="text-align: center;">
    <a href="https://www.dpbolvw.net/click-8265264-10471175" target="_top">
      <img src="https://www.lduhtrp.net/image-8265264-10471175" width="728" height="90" alt="Sandals Grande Antigua Resort & Spa" border="0"/ loading="lazy"></a>
    </div>
  <?php }
endforeach;
endif;
?>
