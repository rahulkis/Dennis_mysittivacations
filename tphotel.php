<?php
header('Access-Control-Allow-Origin: *');
function str_limit($value, $limit = 100, $end = '') {
    if (mb_strlen($value) <= $limit) {
      return $value;
    }
    return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
  }
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
			if($_POST['city_name']){
        if($_POST['city_name'] == 'Washington D.C.'){
      $city_names = "Washington";
      }else{
      $city_names = $_POST['city_name'];
      }
            $sql = "SELECT * FROM cj_xml_data WHERE afflication_name = 'Hotels.com' AND city like '%".$city_names."%' limit 20";
                  $result = $mysqli->query($sql);
                 $count = $result->num_rows;
         
                  if($count > 0){
              ?>
              <div class="container hotel_resuts">
                   <div class="headingActivity-new new_activity">
                        <div class="static-text">
                         <a href="Hotels.com" class="cites_links">
                           <h2 class='sec-text'><?php echo  $_POST['city_name']; ?></h2>
                        </a>
                        </div>
                         <h2 class="hotels_deakss">Hotel Deals</h2>
                  </div>
              <div class="owl-carousel owl-theme">
                <?php               
                foreach($result as $key=>$row):
                  $new = strstr($row['buy_url'], 'www.hotels.com');
                  $buy_urls = str_replace('%2F', '/', $new);
                  $buy_urlss = str_replace('%2F%3', '/', $buy_urls);
                  $buy_urlsss = str_replace('1%3', '/', $buy_urlss);
                  $buy_url = 'https://'.$buy_urlss; 
                    if(getimagesize($row['image_url']) === false){
                  } else{                 
                      ?>
                      <div class=" item  popular_cityy">
                        <a target="_blank" href="<?php echo $buy_url; ?>">
                          <?php  $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
                          <img src="<?php echo $url; ?>">
                          <h3><?php echo str_limit($row['product_name'] ,20,'...'); ?></h3>
                          <?php if(!empty($row['retail_price'])): ?>
                          <p><?php echo substr($row['description'],0,30); ?></p>
                          <h4 class="retail_hotel_price"><?php echo "$".$row['retail_price']." (".$row['currency'].")" ; ?></h4>
                          <?php endif; ?>
                          <h3 class="original_price tours_price"><?php echo "$".$row['price']." (".$row['currency'].")" ; ?></h3>
                        </a>
                      </div>
                      <?php  
                    }
                endforeach;
                ?>
              </div>
               </div>
       
     <?php  }else{

 $sql = "SELECT * FROM hotel_com WHERE keywords like '%".$_POST['city_name']."%' limit 30";
               $result = $mysqli->query($sql);
                 $count = $result->num_rows;
if($count > 0){
      ?>
<div class="container hotel_resuts">
                   <div class="headingActivity-new new_activity">
                        <div class="static-text">
                         <a href="Hotels.com" class="cites_links">
                           <h2 class='sec-text'><?php echo  $_POST['city_name']; ?></h2>
                        </a>
                        </div>
                         <h2 class="hotels_deakss">Hotel Deals</h2>
                  </div>
              <div class="owl-carousel owl-theme">
                <?php               
                foreach($result as $key=>$row):
                  $new = strstr($row['advertisercategory'], 'www.hotels.com');
                  $buy_urls = str_replace('%2F', '/', $new);
                  $buy_urlss = str_replace('%2F%3', '/', $buy_urls);
                  $buy_urlsss = str_replace('1%3', '/', $buy_urlss);
                  $buy_url = 'https://'.$buy_urlss; 
                    if(getimagesize($row['title']) === false){
                  } else{                 
                      ?>
                      <div class=" item  popular_cityy">
                        <a target="_blank" href="<?php echo $buy_url; ?>">
                          <?php  $url = str_ireplace( 'http:', 'https:', $row['title'] ); ?>
                          <img src="<?php echo $url; ?>">
                          <h3><?php echo str_limit($row['manufacturer'] ,20,'...'); ?></h3>
                          <?php if(!empty($row['saleprice'])): ?>
                          <p><?php echo substr($row['description'],0,30); ?></p>
                          <h4 class="retail_hotel_price"><?php echo "$".$row['saleprice']." (".$row['currency'].")" ; ?></h4>
                          <?php endif; ?>
                           <?php $real_price = ($row['price'] - 10); ?>
                          <h3 class="original_price tours_price"><?php echo "$".$real_price." (".$row['currency'].")" ; ?></h3>
                        </a>
                      </div>
                      <?php  
                    }
                endforeach;
                ?>
              </div>
               </div>

     <?php } } } ?>