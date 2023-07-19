<?php
  include 'Query.Inc.php';
  $Obj = new Query($DBName);
  $json = file_get_contents('php://input');
  $requestData = json_decode($json, true);
  print_r($requestData);
  die();
  require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
  error_reporting(0);
  $SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";
  $info        = $requestData['info'];
  $source = $requestData['source'];
  $title = $requestData['title'];

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

if($source == "restaurants-deals"){
 ?>
      <div class="container recommed-city pcdesktop new_adds" style="text-align: center">
        <a href="https://www.jdoqocy.com/click-8265264-10639765" target="_blank">
          <img src="https://www.tqlkg.com/image-8265264-10639765" class="spcific_homeaway" width="728" height="90" alt="Beaches Negril Sale" border="0"/>
        </a>
      </div>
<?php } ?>
  <?php if (isset($info)): ?>
  <?php $s = 0; foreach ($info as $data): ?>
      <?php if($data):?>
        <div class="headingActivity-new new_activity container">
            <?php if( $source == "restaurants-deals"):?> 
              <a href="<?php echo $SiteURL; ?><?php echo $data['pageName'];?>" class="cites_links">
                <h2><?php echo $data['name']; ?></h2>
              </a>

              <a  data-toggle="modal" data-target="#popularcitiesModal" data-afflication="<?php echo $data['afflication_name'] ;?>" data-page="<?php echo $data['source']; ?>" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>"  class="open-CitiesDialog">See all</a>
        </div>

        <div class="container recommed-city pcdesktop">
          <ul class="us-city worldtop_city general_cities">
          <?php 
            if(isset($data['afflication_name'])):
              $sql = "SELECT * FROM ".$data['tableName']." WHERE afflication_name = '".$data['afflication_name']."' limit 3";
            else:
              $sql = "SELECT * FROM ".$data['tableName']." limit 3";
            endif;
          $result = mysql_query($sql);
          $k = 0;
          $y = 0;
          $s++;
          while($row = mysql_fetch_assoc($result)): $y++; ?>
          <?php if($source == "restaurants-deals"):
          $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($row['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
          if($row['name'] == 'Washington dc' || $row['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
          $row['name'] = 'Washington D.C.';
          }
          $url = ($data['pageName'] === "hotels/index.php") ? 'onclick="location.reload()" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$row['name'].'"' : 'href="'.$data['pageName'].'?city='.$row['name'].'"';
          ?>
          <li class="col-sm-4 col-md-4 col-xs-4 popular_cityy">
            <a <?php echo str_ireplace( 'http:', 'https:',$url ); ?>>
            <span class="dealscity_name cityes_cityes_name"><?php echo str_limit($row['name'], 18, '...'); ?></span>
            <img src="<?php echo str_ireplace( 'http:', 'https:',$row['image_url'] ); ?>"/>
            </a>
          </li>
<?php if($y == '3'){
    ?>
    </ul>
    </div>
    <div class="bs-example popular_city_in_mobile">
      <div class="carousels" >
        <div class="carousel-inners">
          <?php
          $sqll = "SELECT * FROM ".$data['tableName'];
          $yelp = mysql_query($sqll);
          $counter = '0';
          while($rowyelp = mysql_fetch_assoc($yelp)){
            $hotel_url = base64_encode('https://hotels.mysittivacations.com/hotels?destination='.str_replace(' ', '+', strtok($rowyelp['name'], ',')).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en_us&currency=usd');
            if($rowyelp['name'] == 'Washington dc' || $rowyelp['name'] == 'Washington DC' || $row['name'] == 'Washington Dc'){
              $rowyelp['name'] = 'Washington D.C.';
            }
            $url = ($data['pageName'] === "hotels/index.php") ? 'onclick="location.reload()" target="_blank" href="redirection.php?location='.$hotel_url.'&city='.$rowyelp['name'].'"' : 'href="'.$data['pageName'].'?city='.$rowyelp['name'].'"';
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

                      $sql = "SELECT * FROM ".$data['tableName']." limit 3";
                      $result = mysql_query($sql);
                      $y = 0;
                      while($row = mysql_fetch_assoc($result)){
                        $y++;
                  ?>
                        <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
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

                                    <?php if($y == '3'){
                          ?>
              </ul>
              </div>
	 <?php if($detect->isMobile()) { ?>
              <div class="bs-example popular_city_in_mobile">
                <div class="carousels" >
                  <div class="carousel-inners">
                    <?php
                    $sql = "SELECT * FROM ".$data['tableName']." limit 50";
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
 endforeach;
  endif;?>