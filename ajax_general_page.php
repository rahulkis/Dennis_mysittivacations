<?php
  include 'Query.Inc.php';
  $Obj = new Query($DBName);
  require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
  error_reporting(0);
  $SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";
  $info        = $_POST['info'];
  $modal_link  = $_POST['modal_link'];
  $modal_title = $_POST['modal_title'];
  $modal_table = $_POST['modal_table'];
  $source = $_POST['source'];
  $title = $_POST['title'];

  $checkIn = date("Y-m-d");
  $update_date = date_create($checkIn);
  date_add($update_date,date_interval_create_from_date_string("1 days"));
  $checkOut =  date_format($update_date,"Y-m-d");
  function str_limit($value, $limit = 100, $end = '') {
    if (mb_strlen($value) <= $limit) {
      return $value;
    }
    return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
  }
  if (isset($info)): ?>
<!--           <div class="general_page_top"><h2><?php echo $title; ?></h2></div> -->
  <?php $s = 0; foreach ($info as $data): ?>
      <?php if($data):
if($data['name'] != 'Asia,Europe,Australia'){
        ?>
             
        <div class="headingActivity-new new_activity container">
             <?php
 if($data['tableName'] == 'best_pizza_cities'){?>
<div class="container recommed-city pcdesktop new_adds restaurantsAdds" style="text-align: center;margin: 30px 0px 0px;">
<a href="https://www.jdoqocy.com/click-8265264-14324545" target="_top">
<img src="https://www.ftjcfx.com/image-8265264-14324545" width="600" height="90" alt="" border="0"/></a>
</div>
 <?php 
} ?>  
            <?php if($source == "yelp-tour" || $source == "index" || $source == "restaurants-deals"):?> 
              <a href="javaScript:void(0)" class="cites_links">
                <?php if($data['name'] == 'Asia,Europe,Australia'){ }else{?>
                <h2><?php echo $data['name']; ?></h2>
              <?php } ?>
              </a>
              <?php if($data['name'] == 'Asia,Europe,Australia'){ }else{?>
                
              <a href="#" data-toggle="modal" data-target="#popularcitiesModal" data-afflication="<?php echo $data['afflication_name'] ;?>" data-page="<?php echo $data['source']; ?>" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>"  class="open-CitiesDialog">See all</a>
            <?php  } ?>
            <?php elseif($source == "city-guide"):?>  
              <a class="cites_links"><h2><?php echo str_limit($data['name'], 15, '...') ?></h2></a>
              
              <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>"  class="open-CitiesDialog">See all</a>
            <?php  endif;?>  
        </div>
<?php } if($data['name'] == 'Asia,Europe,Australia,Canada'){
  $dataArr = explode(',', $data['name']);
  ?>
    <div class="container recommed-city pcdesktop">
    	 <?php if(!$detect->isMobile()) { ?>
          <ul class="us-city worldtop_city general_cities allCountryTours">
            <?php 
            // print_r($dataArr);
          foreach ($dataArr as $key => $value) {
              if(isset($data['afflication_name'])):
              $sql = "SELECT * FROM ".lcfirst($value)." WHERE afflication_name = '".$data['afflication_name']."' limit 1";
            else:
              $sql = "SELECT * FROM ".lcfirst($value)." limit 1";
            endif;
            // echo $sql;
            $result = mysql_query($sql);

           ?>
            <?php
              while($row = mysql_fetch_assoc($result)){ $y++;
            if($source == "yelp-tour"){
          $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
          if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
          $row['name'] = 'Washington D.C.';
          }
          $url = ($data['pageName'] === "hotels/index.php") ? 'onclick="location.reload()" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"' : 'href="'.$data['pageName'].'?city='.$row['name'].'"';
          ?>
          <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
             <span class="dealscity_name cityes_cityes_name allCityTours" style="top:210px !important"><?php echo $value; ?></span>
            <!-- <a href="redirection.php?location=<?php echo urlencode($url); ?>&city=<?php echo $row['name']; ?>"> -->
           <a href="#" data-toggle="modal" data-target="#popularcitiesModal" data-afflication="<?php echo $data['afflication_name'] ;?>" data-page="<?php echo $value; ?>" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo lcfirst($value); ?>" data-title="<?php echo $data['name']; ?>"  class="open-CitiesDialog">
           
            <img src="<?php echo str_ireplace( 'http:', 'https:',$row['image_url'] ); ?>"/>
            </a>
          </li>
          <?php }}} ?>
             
          </ul>
<?php } else{ ?>
      <div class="bs-example popular_city_in_mobile">
      <div class="carousels" >
         <div class="carousel-inners">
          <?php 
           foreach ($dataArr as $key => $value) {
           if(isset($data['afflication_name'])):
              $sql = "SELECT * FROM ".lcfirst($value)." WHERE afflication_name = '".$data['afflication_name']."' limit 1";
            else:
              $sql = "SELECT * FROM ".lcfirst($value)." limit 1";
            endif;
             // echo $sql;
            $result = mysql_query($sql);
              while($row = mysql_fetch_assoc($result)){ $y++;
            if($source == "yelp-tour"){
 
          if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
             $row['name'] = 'Washington D.C.';
          }
        
          ?>
          <div class="carousel_mobile">
           <a href="#" data-toggle="modal" data-target="#popularcitiesModal" data-afflication="<?php echo $data['afflication_name'] ;?>" data-page="<?php echo $value; ?>" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo lcfirst($value); ?>" data-title="<?php echo $data['name']; ?>"  class="open-CitiesDialog">
             
              <img src="<?php echo str_ireplace( 'http:', 'https:',$row['image_url'] ); ?>"/>
               <span class="dealscity_name cityes_cityes_name allCityTours"><?php echo $value; ?></span>
             
            </a>
            </div>



          <?php }}} ?>
         </div>
      </div>
    </div>
<?php } ?>
        </div>
<?php }

if($data['name'] == 'Asia,Europe,Australia'){
  $generaCount = 'genralYelpTours';
}else{
$generaCount = '';
}
 ?>

        <div class="container recommed-city pcdesktop <?php echo $generaCount; ?>">
          <ul class="us-city worldtop_city general_cities">
          <?php 
         
            if(isset($data['afflication_name'])):
              $sql = "SELECT * FROM ".$data['tableName']." WHERE afflication_name = '".$data['afflication_name']."' limit 4";
            else:
              $sql = "SELECT * FROM ".$data['tableName']." limit 4";
            endif;
          $result = mysql_query($sql);
          $k = 0;
          $y = 0;
          $s++;
          while($row = mysql_fetch_assoc($result)): $y++; ?>
          <?php if($source == "yelp-tour" || $source == "restaurants-deals"):
          $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
          if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
          $row['name'] = 'Washington D.C.';
          }
          $url = ($data['pageName'] === "hotels/index.php") ? 'onclick="reloadLandingPage('."'".''.$row['name'].''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"' : 'href="'.$data['pageName'].'?city='.$row['name'].'"';
          ?>
          <li class="col-sm-4 col-md-4 col-xs-4 popular_cityy">
            <a <?php echo str_ireplace( 'http:', 'https:',$url ); ?>>
            <span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['name'], 18, '...'); ?></span>
            <img src="<?php echo str_ireplace( 'http:', 'https:',$row['image_url'] ); ?>"/>
            </a>
          </li>
<?php if($y == '4'){
    ?>
    </ul>
    </div>
    <div class="bs-example popular_city_in_mobile <?php echo $generaCount; ?>">
      <div class="carousels" >
        <div class="carousel-inners">
          <?php
          $sqll = "SELECT * FROM ".$data['tableName']." limit 8";
          $yelp = mysql_query($sqll);
          $counter = '0';
          while($rowyelp = mysql_fetch_assoc($yelp)){
            $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($rowyelp['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
            if($rowyelp['name'] == 'Washington dc' || $rowyelp['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
              $rowyelp['name'] = 'Washington D.C.';
            }
            $url = ($data['pageName'] === "hotels/index.php") ? 'onclick="reloadLandingPage('."'".''.$row['name'].''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$rowyelp['name'].'"' : 'href="'.$data['pageName'].'?city='.$rowyelp['name'].'"';
            ?>
            <div class="carousel_mobile">
            <a <?php echo str_ireplace( 'http:', 'https:',$url ); ?>>
              <span class="dealscity_name cityes_cityes_name"><?php echo str_limit($rowyelp['name'], 18, '...'); ?></span>
              <img src="<?php echo str_ireplace( 'http:', 'https:',$rowyelp['image_url'] ); ?>"/>
            </a>
            </div>
            <?php
            $counter++; 
          }
          ?>
        </div>
      </div>
    </div>
    <?php

    $y = '0';   
  }  ?>
                <?php else:
                      $sql = "SELECT * FROM ".$data['tableName']." limit 4";
                      $result = mysql_query($sql);
                      $y = 0;
                      while($row = mysql_fetch_assoc($result)){
                        $y++;
                  ?>
                        <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy ">
	                          <a href="" id="city_tour_detail" data-city="<?php if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
							echo 'Washington D.C.';
							
                      }else{
                      	echo $row['name']; 
                      }
                         ?>">
                      			<span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['name'], 18, '...'); ?></span>
                            <img src="<?php echo str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>"/>
                          </a>
                        </li>

                                    <?php if($y == '4'){
                          ?>
              </ul>
              </div>
	 <?php if($detect->isMobile()) { ?>
              <div class="bs-example popular_city_in_mobile">
                <div class="carousels" >
                  <div class="carousel-inners">
                    <?php
                    $sql = "SELECT * FROM ".$data['tableName']." limit 8";
                      $result = mysql_query($sql);
                      $counter = '0';
                      while($row = mysql_fetch_assoc($result)){
                    ?>
                    <div class="carousel_mobile">
                        <a href="" id="city_tour_detail" data-city="<?php 
                          if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
                       echo 'Washington D.C.';
                       }else{
                         echo $row['name']; 
                       }
                      
                        ?>">
                            <span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['name'], 18, '...'); ?></span>
                            <img src="<?php echo str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>"/>
                          </a>
                    </div>
                    <?php
                   
                    }
                    ?>
                  </div>
                
                </div>
              </div>
              <?php
}
              $y = '0';   }  ?>

              <?php } ?>
              <?php endif;?>
              <?php endwhile; ?>
            </ul>
          </div> 
        <?php endif;?> 
<?php 
if($data['afflication_name'] == 'Best of Orlando'){
  ?>
  <div class="container recommed-city pcdesktop new_adds" style="text-align: center">
  <a href="https://www.tkqlhce.com/click-8265264-10882144?cm_mmc=CJ-_-4882762-_-8265264-_-Save%20on%20Orlando's%20Best%20Theme%20Parks!%20728x90" target="_blank">
<img src="https://www.lduhtrp.net/image-8265264-10882144" width="728" height="90" alt="Save on Orlando's Best Theme Parks!" border="0"/></a>
</div>
  <?php
}
if($data['name'] == 'Cities For Music Lovers'){
  ?>
  <div class="container recommed-city pcdesktop new_adds" style="text-align: center;  margin: 40px 0px 0px;">
 <a href="https://track.flexlinkspro.com/g.ashx?foid=156074.4221.271012&trid=1215297.159075&foc=16&fot=9999&fos=5" rel="nofollow" target="_blank" alt="Best Hotel Prices 728x90" title="Best Hotel Prices 728x90" ><img border="0" src="http://a.impactradius-go.com/display-ad/4221-271012" style="max-width: 100%;margin-top: 20px;" /></a><img src="https://track.flexlinkspro.com/i.ashx?foid=156074.4221.271012&trid=1215297.159075&foc=16&fot=9999&fos=5" border="0" width="0" height="0" style="opacity: 0;"/></div>
  <?php
}
if($data['name'] == 'Europe'){
  ?>
  <div class="container recommed-city pcdesktop new_adds urope_add" style="text-align: center;">
  <a href="https://www.jdoqocy.com/click-8265264-11454023" target="_top">
<img src="https://www.ftjcfx.com/image-8265264-11454023" width="900" class="urop_rest_add" height="90" alt="728x90 Get Quote" border="0"/></a>
</div>
  <?php
}
 endforeach;
  endif;?>
<?php if (isset($modal_table)):?>
  <?php if($modal_title == 'Asia,Europe,Australia'){?>
   <h2 class='modal-title'><?php echo ucfirst($modal_table); ?></h2>
 <?php  }else{?>
   <h2 class='modal-title'><?php echo $modal_title; ?></h2>
 <?php  } ?>
 
  <?php 
    if(trim($_POST['modal_afflication']) != ""):
      $sql = "SELECT * FROM ".$modal_table." WHERE afflication_name = '".$_POST['modal_afflication']."'";
    else :
      $sql = "SELECT * FROM ".$modal_table."";
    endif;
    $result = mysql_query($sql);
    while($row = mysql_fetch_assoc($result)):
           if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
                        $row['name'] = 'Washington D.C.';
                      } 
            if($row['name'] == 'St Louis'){
                        $row['name'] = 'St. Louis';
                      }
      ?>
      <ul class="us-city-popup">
          <?php if(trim($_POST['modal_afflication']) != ""):?> 
            <?php if($_POST['modal_afflication'] === "Adrenaline"):?>
                    <li class="col-sm-3 col-md-3 col-xs-6">
	                  	<span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['categories'],15,'...'); ?></span>
	                    <?php 
                        echo str_ireplace( 'http:', 'https:', base64_decode($row['code']) );
                      ?>
                    </li>
            <?php else:?>
                    <li class="col-sm-3 col-md-3 col-xs-6">
                      <?php   echo str_ireplace( 'http:', 'https:', base64_decode($row['code']) ); ?>
                    </li>
            <?php endif;?>
          <?php else: ?>
            <li class="col-sm-4 col-md-4 col-xs-4">
              <?php if(isset($modal_link)):
                      $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
                      $url = ($modal_link === "hotels/index.php") ? 'onclick="reloadLandingPage()" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"' : 'href="'.$modal_link.'?city='.$row['name'].'"';
              ?>
                      <a <?php echo $url; ?> >
              <?php elseif(isset($_POST['modal_pageName'])):
                      $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
                      $url = 'onclick="reloadLandingPage('."'".''.$row['name'].''."'".',this)" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"';
              ?>

                      <a <?php echo $url; ?> >
              <?php elseif(isset($_POST['modal_page'])):?>
                      <a href="" id="city_tour_detail" data-city="<?php echo $row['name']; ?>">
              <?php endif; ?>
              			<span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['name'], 15, '...'); ?></span>
                       <?php   $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
                        <img src="<?php echo $url; ?>"/>
                      </a>
            </li>
          <?php endif; ?>
    </ul>
    <?php endwhile;?>
<?php endif;?>
<?php 
  if ($_POST['trigger'] == 'genral_page_modal') :
?>
  <h2 class='modal-title'><?php echo $_POST['title']; ?></h2>
  <?php 
    $sql = "SELECT * FROM ".$_POST['tableName'] ."";
    $result = mysql_query($sql);
    while($row = mysql_fetch_assoc($result)): 
  ?>
    <ul class="us-city-popup">
        <li class="col-sm-3 col-md-3 col-xs-6">
          <?php if(isset($_POST['modal_link'])):
                $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
                $url = ($_POST['modal_link'] === "hotels/index.php") ? 'onclick="reloadLandingPage()" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"' : 'href="'.$_POST['modal_link'].'?city='.$row['name'].'"';
          ?>
              <a <?php echo $url; ?> >
          	 	<span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['name'], 15, '...'); ?></span>
                <img src="<?php echo $row['image_url']; ?>"/>
              </a>
        </li>
    </ul>
<?php       endif;
    endwhile;
  endif;
?>


                                     
