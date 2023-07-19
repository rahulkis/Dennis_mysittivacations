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
  if(!empty($city)):
    $prepAddr = str_replace(' ','+',str_replace(', ', ' ', $city));
    // echo $prepAddr;
    $key = str_replace(' ','+',$key);
      $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
      $output= json_decode($geocode);
      $latitude = $output->results[0]->geometry->location->lat;
      $longitude = $output->results[0]->geometry->location->lng;
      $urlgo ="https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&lat=".$latitude."&lng=".$longitude."&offset=0&limit=".$limit."&locale=en_US";
    // endif;
  else:
    
    if(!empty($key)):
      $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=".$key."&offset=0&limit=".$limit."&locale=en_US";
    else:

      $urlgo = "https://partner-api.groupon.com/deals.json?tsToken=US_AFF_0_207698_212556_0&query=all+inclusive&offset=0&limit=".$limit."&locale=en_US";
    endif;
  endif;
  $result_get = file_get_contents($urlgo);
  $get_all_data = json_decode($result_get, true);
  $get_deals = $get_all_data['deals'];
  return $get_deals;
}
?>
  <?php if (isset($info)): 

    $get_deals = groupon_api_call('3','','');
    if(!empty($get_deals)):
?>
      <div class="container recommed-city">
      <div class="headingActivity-new1 groupon_deals_common_class container">
           <h2 class="general-sec-heading">Amazing All-Inclusive Discounts<span>Great for families or couples</span></h2>
            <a top href="random_deals.php" class="open-GrouponDialog" target="_blank">
              See all
            </a>
            </div>
       <?php   if(!$detect->isMobile()) {?>
      <ul class="popular_cityy">
          <?php 
          foreach ($get_deals as $homeData):
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
              $tourname = $homeData['merchant']['name']; 
            $out =  substr($tourname,0,60);
        ?>  
            <li class="col-md-3 col-sm-12 col-xs-12 city-recom" style="float: left; list-style: none; position: relative;padding:5px">
              <div class='borderIsan hotelandingDeal'>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <img src="<?php echo $homeData['grid4ImageUrl']; ?>" loading="lazy">
                </a>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" >
                  <h1 class="nameIsan hotelandingnameIsan" style= "text-align: left;"><?php echo $out ; ?></h1>
                </a>
                <span class="all_inclusive_address"><?php echo $homeData['options'][0]['redemptionLocations'][0]['name']; ?></span>
                <h1 class="pricelanding"><?php echo $homeData['options'][0]['value']['formattedAmount']; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $homeData['options'][0]['discountPercent']; ?>% Off)</h2>
                

                <h2 class="valuelanding"><?php echo $homeData['options'][0]['price']['formattedAmount'] ;?></h1>
                <h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
              </div>
            </li>
        <?php    endforeach; ?>
      </ul>
   <?php } else{

    $get_deals = groupon_api_call('4','','');
    ?>
    <div class="owl-carousel owl-theme">   

          <?php
        
          foreach ($get_deals as $homeData):
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
               $tourname = $homeData['merchant']['name']; 
            $out =  substr($tourname,0,20).' ...';
            ?>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
                <a href="<?php echo $homeData['dealUrl']; ?>">
                  <img src="<?php echo $homeData['grid4ImageUrl']; ?>" loading="lazy" >
                </a>
                <a href="<?php echo $homeData['dealUrl']; ?>" target="_blank">
                  <h1 class="nameIsan hotelandingnameIsan" style= "text-align: left;"><?php echo $out ; ?></h1>
                </a>
                <span class="all_inclusive_address"><?php echo $homeData['options'][0]['redemptionLocations'][0]['name'] ?></span>
                <h1 class="pricelanding"><?php echo $homeData['options'][0]['value']['formattedAmount'] ; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $homeData['options'][0]['discountPercent']; ?>% Off)</h2>
                
                <h2 class="valuelanding mod"><?php echo $homeData['options'][0]['price']['formattedAmount'];?></h1>
                <h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
              </div>

            <?php
          
          endforeach;
              
          ?>
          </div>
        </div>
      </div>

    <?php
  }
  ?>
</ul>
</div>
 <div class="generalPageHeadingActivity inspiratinSection">  
    <?php
 if(!$detect->isMobile()) {?>         
      <div class="headingActivity-new new_activity container us_vacation_pac">
        <a href="javaScript:void(0)" class="cites_links">
         <h2 class="general-sec-heading">Are You Looking To Travel In The US<span>Take a look at theese US travel destination ideas</span></h2>
        </a>
        <a href="random_deals.php?flag=Vacations" class="open-CitiesDialog">See all</a>

      </div>
          <div class="container recommed-city pcdesktop ">
          <ul class="us-city worldtop_city general_cities">
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-sec">
            <a onclick="reloadLandingPage('Los Angeles',this)" href="random_deals.php?flag=Vacations&city=Los Angeles">
            <span class="dealscity_name cityes_cityes_name">Los Angeles</span>
              <img src="images/city_images/los-angeles-1.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-sec">
            <a onclick="reloadLandingPage('San Francisco',this)" href="random_deals.php?flag=Vacations&city=San Francisco">
            <span class="dealscity_name cityes_cityes_name">San Francisco</span>
              <img src="images/city_images/san-francisc.jpg" loading="lazy">
            </a>
          </li> 
           <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-sec">
            <a onclick="reloadLandingPage('Las Vegas',this)" href="random_deals.php?flag=Vacations&city=Las Vegas">
            <span class="dealscity_name cityes_cityes_name">Las Vegas</span>
              <img src="images/city_images/los_vages.jpg" loading="lazy">
            </a>
          </li> 
         <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-sec">
            <a onclick="reloadLandingPage('Chicago',this)" href="random_deals.php?flag=Vacations&city=Chicago">
            <span class="dealscity_name cityes_cityes_name">Chicago</span>
              <img src="images/city_images/chicaaago.jpg" loading="lazy">
            </a>
          </li>
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-sec">
            <a onclick="reloadLandingPage('Dallas',this)" href="random_deals.php?flag=Vacations&city=Dallas">
            <span class="dealscity_name cityes_cityes_name">Dallas</span>
              <img src="images/city_images/dallas.jpg" loading="lazy">
            </a>
          </li>
        </ul>
      </div>
    <?php }else{ ?>
       <div class="headingActivity-new new_activity container us_vacation_pac">       
        <h2 class="general-sec-heading">Are You Looking To Travel In The US<span>Take a look at theese US travel destination ideas</span></h2>
          <a href="random_deals.php?flag=Vacations" class="open-CitiesDialog custom_see_all">See all</a>
      </div> 
      <div class="owl-carousel owl-theme">   

           <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-secm">
            <a onclick="reloadLandingPage('Los Angeles',this)" href="random_deals.php?flag=Vacations&city=Los Angeles">
              <img class="lazyload" src="images/city_images/los-angeles-1.jpg" loading="lazy"/>
               <span class="dealscity_name cityes_cityes_name">Los Angeles</span>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-secm">
            <a onclick="reloadLandingPage('San Francisco',this)" href="random_deals.php?flag=Vacations&city=San Francisco">
              <img class="lazyload" src="images/city_images/san-francisc.jpg" loading="lazy"/>
               <span class="dealscity_name cityes_cityes_name">San Francisco</span>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-secm">
            <a onclick="reloadLandingPage('Las Vegas',this)" href="random_deals.php?flag=Vacations&city=Las Vegas">
              <img class="lazyload" src="images/city_images/los_vages.jpg" loading="lazy"/>
               <span class="dealscity_name cityes_cityes_name">Las Vegas</span>
            </a>
          </div>
            <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-secm">
            <a onclick="reloadLandingPage('Dallas',this)" href="random_deals.php?flag=Vacations&city=Dallas">
              <img class="lazyload" src="images/city_images/dallas.jpg" loading="lazy"/>
               <span class="dealscity_name cityes_cityes_name">Dallas</span>
            </a>
          </div>
          <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy vacation-secm">
            <a onclick="reloadLandingPage('Chicago',this)" href="random_deals.php?flag=Vacations&city=Chicago">
              <img src="images/city_images/chicaaago.jpg" loading="lazy">
            <span class="dealscity_name cityes_cityes_name">Chicago</span>
            </a>
          </div>
    <?php } ?>
    </div>
     <div class="generalPageHeadingActivity inspiratinSection">  
    <?php
 if(!$detect->isMobile()) {?>         
      <div class="headingActivity-new new_activity container us_vacation_pac">
        <a href="javaScript:void(0)" class="cites_links">
          <h2 class="general-sec-heading">See Beautiful America<span>Enjoy the scenic views of National Parks</span></h2>
        </a>
       <a href="#" data-toggle="modal" data-target="#national_parks" target="_blank" class="national_pas">See all</a>

      </div>
      <?php
       $sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 3";
       $result = $mysqli->query($sql);?>
          <div class="container recommed-city pcdesktop ">
          <ul class="us-city worldtop_city general_cities">
          <?php foreach($result as $key=>$value){ ?>
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a href="<?php echo $value['link']; ?>">
            <span class="dealscity_name cityes_cityes_name"><?php echo substr($value['title'],0,20)."...";?></span>
              <img src="<?php echo $value['image_link']; ?>" loading="lazy">
            </a>
          </li> 
          <?php } ?>
        </ul>
      </div>
    <?php }else{ ?>
       <div class="headingActivity-new new_activity container us_vacation_pac natinal_parks">       
        <h2 class="general-sec-heading">See Beautiful America<span>Enjoy the scenic views of National Parks</span></h2>
          <a href="#" data-toggle="modal" data-target="#national_parks" target="_blank" class="open-CitiesDialog national_pas">See all</a>
      </div> 
      <div class="owl-carousel owl-theme">   
      <?php
       $sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 4";
       $result = $mysqli->query($sql);?>
       <?php foreach($result as $key=>$value){ ?>
           <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a href="<?php echo $value['link']; ?>">
              <img class="lazyload" src="<?php echo $value['image_link']; ?>"/>
              <span class="dealscity_name cityes_cityes_name"><?php echo substr($value['title'],0,20)."...";?></span>
            </a>
          </div>
          <?php } ?>
    <?php } ?>
    </div>

          <div class="container recommed-city pcdesktop general_adds">
              <?php
     if(!$detect->isMobile()) { 
      ?>
            <ul class="us-city worldtop_city general_cities">

            <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a href="https://www.dpbolvw.net/click-8265264-13096099" target="_top">
            <img src="/images/bookvip1.jpg" width="300" height="250" alt="" border="0" loading="lazy"/></a>
            </li> 
            <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a href="https://www.jdoqocy.com/click-8265264-13074241" target="_top">
            <img src="/images/bookivip2.jpg" width="300" height="250" alt="Cancun Vacation Package" border="0"/></a>
            </li> 
            </ul>
    <?php
    }else { 
      ?>
        <div class="owl-carousel owl-theme">

          <div class=" item  popular_cityy">
          <a href="https://www.dpbolvw.net/click-8265264-13096099" target="_top">
          <img src="/images/bookvip1.jpg" width="300" height="250" alt="" border="0" loading="lazy"/></a>
          </div>
          <div class=" item  popular_cityy">
          <a href="https://www.jdoqocy.com/click-8265264-13074241" target="_top">
          <img src="/images/bookivip2.jpg" width="300" height="250" alt="Cancun Vacation Package" border="0"/></a>
          </div>

        </div>
   <?php
    }
      ?>
      </div>

<?php
endif;
 $s = 0; 
 foreach ($info as $data): ?>
      <?php if($data):?>
        <div class="headingActivity-new new_activity container us_vacation_pac natinal_parks">
              <h2 class="general-sec-heading">Relaxing Beach Gateways<span>Here are some beautiful destinations</span></h2>
              <a  href="#" data-toggle="modal" data-target="#popularcitiesModal" data-afflication="<?php echo $data['afflication_name'] ;?>" data-page="<?php echo $data['source']; ?>" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>"  class="open-CitiesDialog beach-seall">See all</a>
        </div>
        <?php
     if(!$detect->isMobile()) { 
      ?>
        <div class="container recommed-city pcdesktop <?php echo $main; ?>">
          <ul class="us-city worldtop_city general_cities">
          <?php 
    $sql = "SELECT * FROM ".$data['tableName']." limit 4 OFFSET 10";
   $result = $mysqli->query($sql);
    foreach ($result as $key => $row) {
      $print=preg_replace('/^([^,]*).*$/', '$1', $row['name']);
      $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
       $url = 'onclick="reloadLandingPage('."'".''.$print.''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"';
      ?>
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy relaxing-beach">
            <a <?php echo $url; ?> >
            <span class="dealscity_name cityes_cityes_name"><?php echo substr($row['name'], 0,18); ?></span>
              <img src="<?php echo $SiteURL; ?><?php echo str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>" loading="lazy"/>
            </a>
          </li> 
    <?php } ?>
     </ul>
          </div> 

         <?php }else{
   $sql = "SELECT * FROM ".$data['tableName']." limit 4";
 $result = $mysqli->query($sql);?>
   <div class="owl-carousel owl-theme"> 
<?php
  foreach ($result as $key => $row) {
      $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
       $url = 'onclick="reloadLandingPage('."'".''.$row['name'].''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"';
      ?>
          <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a <?php echo $url; ?> >
           
              <img src="<?php echo $SiteURL; ?><?php echo str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>" loading="lazy"/>
               <span class="dealscity_name cityes_cityes_name"><?php echo substr($row['name'],0, 18); ?></span>
            </a>
          </div> 
    <?php }?>
    </div>
    
    <?php 
  } endif;

 if($data['name'] == 'Top US Cities to Visit'){?>
<div class="container recommed-city general_home_page_add " style="text-align: center;">
<a href="https://www.dpbolvw.net/click-8265264-10471175" target="_top">
<img src="https://www.lduhtrp.net/image-8265264-10471175" width="728" height="90" alt="Sandals Grande Antigua Resort & Spa" border="0"/></a>
</div>
 <?php }
 endforeach;
  endif;
?>