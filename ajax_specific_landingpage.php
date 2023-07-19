<?php
  include 'Query.Inc.php';
  $Obj = new Query($DBName);
  error_reporting(0);
  $SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";

  $info        = $_POST['info'];
  $modal_link  = $_POST['modal_link'];
  $modal_title = $_POST['modal_title'];
  $modal_table = $_POST['modal_table'];
  $source      = $_POST['source'];
  $title       = $_POST['title'];
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
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
  function yelp_api_call($city_name , $limit){
    $prepAddr = str_replace(' ','+',$city_name);
    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;
    $ch = curl_init();   
    $urlgo = "https://api.yelp.com/v3/businesses/search?term=things%20%to%20%do%20%indoors&latitude=".$latitude."&longitude=".$longitude."&limit=".$limit.""; 
    // echo $urlgo ;
    curl_setopt($ch, CURLOPT_URL, $urlgo);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }      
    $get_deals = json_decode($result);
    $getyelpTourData = $get_deals->businesses;
    curl_close($ch);
    return ($err) ? $err : $getyelpTourData;
    
  }
  function zomato_api_call($url){
    // echo"<pre>";
    // print_r ($url);
    // echo"</pre>";
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url, 
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "user-key: 99868269a38bfabc5532b10a32fa75c7"
      ),
    ));

    $response = curl_exec($curl);
    $zomato_data = json_decode($response);
    $err = curl_error($curl);
    curl_close($curl);
    return ($err) ? $err : $zomato_data;
  }

  if(!empty($info)):
      $s = '0';

      $new = '0';
    foreach ($info as $data): 
      $new++;
      if($new <= 0){
          if($data['tableName'] === "specific_adrenaline"){
                $randon_deals = "SELECT link,image_link,image_name,title FROM specific_adrenaline WHERE city1 like '%".$data['city']."%' or city2 like '%".$data['city']."%' limit 4";
                           $result = $mysqli->query($randon_deals);
         $count = $result->num_rows;
                            if($count > 0){
              ?>
               <div class="headingActivity-new new_activity">
                    <a href="<?php echo $data['afflication_link'];?>" class="cites_links">
                      <!-- <h2><?php echo $data['name']; ?></h2> -->
                      <h2>Adrenaline Rush</h2>
                    </a>
                    <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" class="open-CitiesDialog">See all</a>
              </div>
                     <div class="container recommed-city pcdesktop">
                      <ul class="us-city worldtop_city popular_cityy">
                        <ul class="local_music">
                          <?php
                          // print_r($results);
                            foreach ($result as $value) {
                          ?>
                                    <li class="col-sm-3 city-recom adrline_specifics">
                                      <a href="<?php echo $value['link'] ?>">
                                        <img src="<?php echo $value['image_link']?>" alt="<?php echo $value['image_name']; ?>">
                                        <span><?php echo str_limit($value['title'], 30, '...'); ?></span>
                                      </a>
                                    </li>
                          <?php
                             }
                          ?>
                        </ul>
                      </ul>
                    <div class="bs-example popular_city_in_mobile">
                      <div class="carousels" >
                        <div class="carousel-inners">
                          <?php
                           $randon_dealss = "SELECT link,image_link,image_name,title FROM specific_adrenaline WHERE city1 like '%".$data['city']."%' or city2 like '%".$data['city']."%' limit 50";
                           $results = $mysqli->query($randon_dealss);
                           foreach ($results as $value) {
                          ?>
                          <div class="carousel_mobile">
                            <a href="<?php echo $value['link'] ?>">
                              <img src="<?php echo $value['image_link']?>" alt="<?php echo $value['image_name']; ?>">
                              <span><?php echo str_limit($value['title'], 20, '...'); ?></span>
                            </a>
                          </div>
                          <?php
                          }
                          ?>
                        </div>
                        
                      </div>
                    </div>
                    </div>
                    <?php
                  }
                }
              }
      ?>


              <?php 
                if($data['api'] === "yelp"):
                  $things_to_do_indoor = yelp_api_call($data['city'], "4");
                  if(!empty($things_to_do_indoor)):
              ?>
              <div class="headingActivity-new new_activity">
                    <a href="<?php echo $data['afflication_link'];?>" class="cites_links">
                      <h2><?php echo $data['name']; ?></h2>
                    </a>
                    <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" class="open-CitiesDialog">See all</a>
              </div>
              <div class="container recommed-city pcdesktop">
                <ul class="us-city worldtop_city">
              <?php
            
                  foreach ($things_to_do_indoor as $thing_to_do_indoor):  
                  $s++; 
              ?>
                    <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
                      <a href="<?php echo $thing_to_do_indoor->url; ?>" target='_blank'>
                        <img src="<?php echo $thing_to_do_indoor->image_url; ?>">
                        <h2><?php echo str_limit($thing_to_do_indoor->name, 23, '...'); ?></h2>
                        <ul class="thing_to_do_categories" >
                          <li>
                          <?php 
                            $for_counter = 0 ;
                            $total = count((array)$thing_to_do_indoor->categories)-1; 
                            foreach ($thing_to_do_indoor->categories as $category): 
                          ?>
                            <?php 
                              echo $category->title;
                              if($for_counter != $total):
                                echo ", ";
                              endif; 
                              $for_counter++;
                            ?>
                          <?php 
                            endforeach; 
                          ?>
                          </li>
                        </ul>
                          <ul class="thing_to_do_ratings">
                          <?php for($x=1;$x<=$thing_to_do_indoor->rating;$x++): ?>
                                  <li><img src="imagesNew/star.png"></li>
                            <?php endfor; if(strpos($thing_to_do_indoor->rating,'.')): ?>
                                    <li><img src="images/halfstarnew.png"></li>                      
                          <?php endif;?>                      
                        </ul>
                      </a>
                    </li>
            <?php endforeach;
                  endif;
            ?>
                </ul>

              <div class="bs-example popular_city_in_mobile tours_specificss">
                <div class="carousels" >
                  <div class="carousel-inners">
                    <?php
                if($data['api'] === "yelp"){
                $things_to_do_mobile = yelp_api_call($data['city'], "20");
                }
                 foreach ($things_to_do_mobile as $thing_to_do_indoor){ 
                    ?>
                    <div class="carousel_mobile">
                    <a href="<?php echo $thing_to_do_indoor->url; ?>" target='_blank'>
                      <img src="<?php echo $thing_to_do_indoor->image_url; ?>">
                      <h2><?php echo str_limit($thing_to_do_indoor->name, 23, '...'); ?></h2>
                      <ul class="thing_to_do_ratings">
                        <?php for($x=1;$x<=$thing_to_do_indoor->rating;$x++): ?>
                        <li><img src="imagesNew/star.png"></li>
                          <?php endfor; if(strpos($thing_to_do_indoor->rating,'.')): ?>
                        <li><img src="images/halfstarnew.png"></li>                      
                        <?php endif;?>                      
                      </ul>
                      <ul class="thing_to_do_categories" >
                        <li>
                          <?php 
                          $for_counter = 0 ;
                          $total = count((array)$thing_to_do_indoor->categories)-1; 
                          foreach ($thing_to_do_indoor->categories as $category): 
                            ?>
                            <?php 
                            echo $category->title;
                            if($for_counter != $total):
                              echo ", ";
                            endif; 
                              $for_counter++;
                            ?>
                            <?php 
                          endforeach; 
                          ?>
                        </li>
                      </ul>
                    </a>
                    </div>
                    <?php
                    }
                    ?>
                  </div>
                 
                </div>
              </div>

              </div>
              <?php  
                elseif($data['api'] === "zomato"):
                  $city_name = str_replace(' ','%20',$data['city']);
                  $cities_id_url = "https://developers.zomato.com/api/v2.1/locations?query=".$city_name."";
                  $zomato_cities_id = zomato_api_call($cities_id_url);
                  $zomato_cities_id = $zomato_cities_id->location_suggestions[0]->city_id;
                  $collection_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."&count=4";
                  $collection_url_mob_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."&count=30";
                  $zomato_collections = zomato_api_call($collection_url);
                  $zomato_collections = $zomato_collections->collections;
                  $zomato_collections_mob = zomato_api_call($collection_url_mob_url);
                  $zomato_collections_mob = $zomato_collections_mob->collections;
                  if($zomato_collections != ""):
              ?>
                  <div class="headingActivity-new new_activity container">
                        <a href="<?php echo $data['afflication_link'];?>" class="cites_links">
                          <h2><?php echo $data['name']; ?></h2>
                        </a>
                        <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" class="open-CitiesDialog">See all</a>
                  </div>
                  <div class="container recommed-city pcdesktop">
                    <ul class="us-city worldtop_city popular_cityy">

                        <ul class="zomato_resturant_collection">
                          <?php
                              foreach ($zomato_collections as $zomato_collection):
                          ?>
                                <li class="col-sm-3 col-md-3 col-xs-3 restaurant_spefics">
                                  <a target="_blank" href="<?php echo $zomato_collection->collection->share_url; ?>">
                                    <img src="<?php echo $zomato_collection->collection->image_url; ?>">
                                    <h3><?php echo $zomato_collection->collection->title; ?></h3>
                                    <p><?php echo str_limit($zomato_collection->collection->description, 30, '...'); ?></p>
                                  </a>   
                                </li>
                    <?php 
                              endforeach;
                    ?>
                        </ul>
                    </ul>

                          <div class="bs-example popular_city_in_mobile">
                            <div class="carousels" >
                              <div class="carousel-inners" >
                                <?php
                            if($data['api'] === "yelp"){
                            $things_to_do_mobile = yelp_api_call($data['city'], "20");
                            }
                             foreach ($zomato_collections_mob as $zomato_collections){ 
                                ?>
                                <div class="carousel_mobile tours_specificss">
                                   <a target="_blank" href="<?php echo $zomato_collections->collection->share_url; ?>">
                                    <img src="<?php echo $zomato_collections->collection->image_url; ?>">
                                    <h3><?php echo $zomato_collections->collection->title; ?></h3>
                                    <p><?php echo str_limit($zomato_collections->collection->description, 20, '...'); ?></p>
                                  </a>  
                                </div>
                                <?php
                             
                                }
                                ?>
                              </div>
                             
                            </div>
                          </div>

                  </div>
              <?php 
                endif;
                elseif($data['tableName'] === "cj_xml_data"):
                  $sql = "SELECT buy_url,image_url,img_name,product_name,description,retail_price,currency,price FROM ".$data['tableName']." WHERE afflication_name = '".$data['afflication_name']."' AND description rlike '[[:<:]]".$data['where_city']."[[:>:]]' limit 20";
                  $result = mysql_query($sql);
                  $row = mysql_fetch_assoc($result);
                  if(!empty($row)):
              ?>
                   <div class="headingActivity-new new_activity">
                    <div class="static-text">
                       <a href="<?php echo $data['afflication_link'];?>" class="cites_links">
                        <?php if($data['name'] == 'Hotels Deals'){ ?>
                          <h2 style="color:red; margin-left: 0;"><?php echo $data['name']; ?></h2>
                       <?php }elseif ($data['name'] == 'Tours') {?>
                           <h2><?php echo $data['name']; ?></h2>
                       <?php }else{ ?>
                         <h2 style="color:red"><?php echo $data['name']; ?></h2>
                      <?php } ?>
             
                        </a>
                        </div>
                         <?php if($data['name'] == 'Hotels Deals'){ echo "<h2 class='sec-text'>".$_SESSION['city_name']."</h2>";} ?>
                        <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" class="open-CitiesDialog">See all</a>
                  </div>
                  <div class="container recommed-city pcdesktop">
                    <ul class="us-city worldtop_city">
                      <ul class="landing_page_hotel_deals">
                        <?php  
                        $imgcount = 0;                 
                            while($row = mysql_fetch_assoc($result)):
                                  if($data['name'] == 'Hotels Deals'){
                                     $new = strstr($row['buy_url'], 'www.hotels.com');
                                      $buy_urls = str_replace('%2F', '/', $new);
                                      $buy_urlss = str_replace('%2F%3', '/', $buy_urls);
                                      $buy_urlsss = str_replace('1%3', '/', $buy_urlss);
                                      $buy_url = 'https://'.$buy_urlss;
                                      $cust = '';
                                      $custfont = '';

                                  }elseif($data['name'] == 'Tours'){
                                      $new = strstr($row['buy_url'], 'www.tours4fun.com');
                                      $variable = substr($new, 4, strpos($new, "html"));
                                      $buy_urls = str_replace('%2F', '/', $variable);
                                      $buy_url = 'https://'.$buy_urls;
                                      $cust = 'tour_spcifics';
                                      $custfont = 'tour_spcifics_font';
                                  }else{
                                    $cust = '';
                                    $custfont = '';
                                  $buy_url =  $row['buy_url']; 
                                  }
									if($imgcount < 4){
										?>
										<li class="col-sm-3 col-md-3 col-xs-3 popular_cityy <?php echo $cust.' '.$custfont; ?>">
											<a target="_blank" href="<?php echo $buy_url; ?>">
												<?php  $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
                        <div class="hotelSpecific">
                          <img src="<?php echo $url; ?>" alt="<?php echo $row['img_name ']; ?>">
                        </div>
												<h3><?php echo str_limit($row['product_name'], 20,'...'); ?></h3>
												<?php if(!empty($row['retail_price'])): ?>
												
												<p><?php echo str_limit($row['description'], 70, '...'); ?></p>
                        <h4 class="retail_hotel_price"><?php echo "$".$row['retail_price']." (".$row['currency'].")" ; ?></h4>
                        <?php endif; ?>
                        <h3 class="original_price tours_price"><?php echo "$".$row['price']." (".$row['currency'].")" ; ?></h3>
											</a>
										</li>
										<?php
									}
									$imgcount++;  
							          endwhile;
                        ?>
                      </ul>
                    </ul>
                        <?php    if($data['name'] == 'Hotels Deals'){
                        $tour = '100';
                        $tour_hotle_icon = 'tour_hotle_icon';
                        }elseif($data['name'] == 'Tours'){
                          $tour = '101';
                          $tour_hotle_icon = 'tour_hotle_icon';
                        }else{
                             $tour_hotle_icon = '';
                        }
                        ?>
                    <div class="bs-example popular_city_in_mobile">
                      <div class="carousels" >
                        <div class="carousel-inners">
                          <?php
                          $sql = "SELECT buy_url,image_url,img_name,product_name,description,retail_price,currency,price FROM ".$data['tableName']." WHERE afflication_name = '".$data['afflication_name']."' AND description rlike '[[:<:]]".$data['where_city']."[[:>:]]'";
                          $result = mysql_query($sql);
                          while($row = mysql_fetch_assoc($result)){
                         if($data['name'] == 'Hotels Deals'){ 
                          $custt = 'hotels_mobiles';
                              $new = strstr($row['buy_url'], 'www.hotels.com');
                              $buy_urls = str_replace('%2F', '/', $new);
                              $buy_urlss = str_replace('%2F%3', '/', $buy_urls);
                              $buy_urlsss = str_replace('1%3', '/', $buy_urlss);
                              $buy_url = 'https://'.$buy_urlss;

                            }elseif($data['name'] == 'Tours'){
                              $custt = "tours_specificss";
                              $new = strstr($row['buy_url'], 'www.tours4fun.com');
                              $variable = substr($new, 4, strpos($new, "html"));
                              $buy_urls = str_replace('%2F', '/', $variable);
                              $buy_url = 'https://'.$buy_urls;
                            }else{
                              $custt ="";
                            $buy_url =  $row['buy_url']; 
                            }
                          ?>
                          <div class="carousel_mobile <?php echo $custt; ?>">
                            <a target="_blank" href="<?php echo $buy_url; ?>">
                              <?php  $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
                              <div class="hotel_imges hotel_imgaes">  
                              <img src="<?php echo $url; ?>" alt="<?php echo $row['img_name ']; ?>">
                              </div>
                              <h3><?php echo str_limit($row['product_name'], 20,'...'); ?></h3>
                              <?php if(!empty($row['retail_price'])): ?>
                              <p><?php echo str_limit($row['description'], 70, '...'); ?></p>
                              <h4 class="retail_hotel_price"><?php echo "$".$row['retail_price']." (".$row['currency'].")" ; ?></h4>
                                    <?php endif; ?>
                              <h3 class="original_price tours_price"><?php echo "$".$row['price']." (".$row['currency'].")" ; ?></h3>
                            </a>
                          </div>
                          <?php
                          }
                          ?>
                        </div>
                       
                      </div>
                    </div>
                  </div>
              <?php
                  endif; 
                elseif($data['tableName'] === "music_categories" ): 
              ?>
                  <div class="headingActivity-new new_activity">
                        <a href="<?php echo $data['afflication_link'];?>" class="cites_links">
                          <h2><?php echo $data['name']; ?></h2>
                        </a>
                        <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" data-table2="<?php echo $data['table2'];?>" class="open-CitiesDialog">See all</a>
                  </div>
                  <div class="container recommed-city pcdesktop music_list_deals">
                    <ul class="us-city worldtop_city popular_cityy">
                      <ul class="local_music">
                        <?php 
                            $sql = "SELECT music_link,music_image,music_type FROM ".$data['tableName']." limit 4";
                            $result = mysql_query($sql);
                            while($row = mysql_fetch_assoc($result)):
                        ?>
                                <li class="col-sm-3 city-recom">
                                  <a href="<?php echo  $row['music_link']; ?>">
                                    <img src="images/<?php echo  $row['music_image']; ?>">
                                    <span><?php echo  $row['music_type']; ?></span>
                                  </a>
                                </li>
                        <?php
                            endwhile;
                        ?>
                      </ul>
                    </ul>

                  <div class="bs-example popular_city_in_mobile">
                      <div class="carousels" >
                        <div class="carousel-inners" role="listbox">
                          <?php
                           $sql = "SELECT music_link,music_image,music_type FROM ".$data['tableName'];
                            $result = mysql_query($sql);
                         while($row = mysql_fetch_assoc($result)){
                          ?>
                          <div class="carousel_mobile">
                            <a href="<?php echo  $row['music_link']; ?>">
                              <img src="images/<?php echo  $row['music_image']; ?>">
                              <span><?php echo  $row['music_type']; ?></span>
                            </a>
                          </div>
                          <?php
                          }
                          ?>
                        </div>
                        
                      </div>
                    </div>

                  </div>
                             <div class="container recommed-city pcdesktop" style="text-align: center">
                             
                             <a href="https://www.anrdoezrs.net/click-8265264-12811684" target="_blank" >
<img src="https://www.awltovhc.com/image-8265264-12811684" class="spcific_homeaway" width="728" height="90" alt="HomeAway" border="0" /></a>

                             </div>

              <?php
                 elseif($data['tableName'] === "sports_categories"):
              ?>
                    <div class="headingActivity-new new_activity">
                      <a href="<?php echo $data['afflication_link'];?>" class="cites_links">
                        <h2><?php echo $data['name']; ?></h2>
                      </a>
                      <?php if($_SESSION['city_name'] != "Washington D.C.") { ?>
                      <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" data-table2="<?php echo $data['table2'];?>" class="open-CitiesDialog">See all</a>
                    <?php } ?>
                    </div>
                    <div class="container recommed-city pcdesktop sports_specific_deals">
                      <ul class="us-city worldtop_city popular_cityy">
                        <ul class="local_music">
                          <?php
                            $city_name_query = @mysql_query("SELECT city_name,state_id FROM capital_city WHERE city_name = '".$data['city']."'");
                            $get_city_name = mysql_fetch_assoc($city_name_query);
                            $dropdown_city = $get_city_name['city_name'];
                            // echo $dropdown_city;
                            $state_name_query = @mysql_query("select country_id,name,code FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
                            $get_state_name = mysql_fetch_assoc($state_name_query);
                            $_SESSION['country'] = $get_state_name['country_id'];
                            $state_name = $get_state_name['name'];
                            $state_code = $get_state_name['code'];
                            
                            $co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
                            $get_co_name = mysql_fetch_assoc($co_name_query);
                            $conry_nm = $get_co_name['name'];
                            $sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$state_code."' OR state_name = '".$state_name."'";
                            // echo $sql;
                            $result = mysql_query($sql);
                            $nurows = mysql_num_rows($result);
                            $ignore = ['id', 'state_name', 'state_code', 'city', 'Colleges'];
                            if($nurows > 0):
                            $row = mysql_fetch_assoc($result);
                            $counter_sport = 0;
                            // echo"<pre>";
                            // print_r ($row);
                            // echo"</pre>";
                            $i = 0;
                          		foreach ($row as $key => $value) :
                              	if(!in_array($key, $ignore) && trim($key) != '') :
	                                  // echo $value."</br>";
                                  if(strtok($value, ',') != ''):
                                    $i++;
                                    if($i < 5){
                                       if(strtolower($key) == 'nba'){
                                          $altCode = "basketball Match";
                                        }elseif(strtolower($key) == 'nfl'){
                                           $altCode = "Rugby match";
                                        }elseif(strtolower($key) == 'mlb'){
                                          $altCode = "baseball match";
                                        }else{
                                          $altCode="";
                                        }
                          ?>
                                    <li class="col-sm-3 city-recom">
                                      <a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo strtok($value, ','); ?>&city=<?php echo $data['city']; ?>">
                                        <img src="images/<?php echo strtolower($key); ?>.jpg" alt="<?php echo $altCode; ?>">
                                        <span><?php echo  $key; ?></span>
                                      </a>
                                    </li>
                          <?php
                           }
                                    $counter_sport++;
                                 
                          		    endif;
                                endif;
                            	endforeach;
                              if($counter_sport <= 4):  
                              if($_SESSION['city_name'] != "Washington D.C."){
                                                                           
                          ?>
                                <li class="col-sm-3 city-recom">
                                  <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" data-table2="<?php echo $data['table2'];?>" class="open-CitiesDialog">
                                    <img src="images/colleges.jpg">
                                    <span>COLLEGES</span>
                                  </a>
                                </li>
                              <?php } ?>
                          <?php
                              endif;
                          endif;
                          ?>
                        </ul>
                      </ul>

                    <div class="bs-example popular_city_in_mobile">
                      <div class="carousels" >
                        <div class="carousel-inners">
                          <?php
                         $city_name_query = @mysql_query("SELECT city_name,state_id FROM capital_city WHERE city_name = '".$data['city']."'");
                            $get_city_name = mysql_fetch_assoc($city_name_query);
                            $dropdown_city = $get_city_name['city_name'];
                            // echo $dropdown_city;
                            $state_name_query = @mysql_query("select country_id,name,code FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
                            $get_state_name = mysql_fetch_assoc($state_name_query);
                            $_SESSION['country'] = $get_state_name['country_id'];
                            $state_name = $get_state_name['name'];
                            $state_code = $get_state_name['code'];
                            
                            $co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
                            $get_co_name = mysql_fetch_assoc($co_name_query);
                            $conry_nm = $get_co_name['name'];
                            $sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$state_code."' OR state_name = '".$state_name."'";
                            // echo $sql;
                            $result = mysql_query($sql);
                            $nurows = mysql_num_rows($result);
                            $ignore = ['id', 'state_name', 'state_code', 'city', 'Colleges'];
                            if($nurows > 0){
                            $row = mysql_fetch_assoc($result);
                            $counter_sport = 0;
                            // echo"<pre>";
                            // print_r ($row);
                            // echo"</pre>";
                      
                              foreach ($row as $key => $value) {
                                if(!in_array($key, $ignore) && trim($key) != ''){
                                    // echo $value."</br>";
                                  if(strtok($value, ',') != ''){
                                          if(strtolower($key) == 'nba'){
                                          $altCode = "basketball Match";
                                        }elseif(strtolower($key) == 'nfl'){
                                          $altCode = "Rugby match";
                                        }elseif(strtolower($key) == 'mlb'){
                                          $altCode = "baseball match";
                                        }else{
                                          $altCode="";
                                        }
                            
                          ?>
                          <div class="carousel_mobile">
                           <a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo strtok($value, ','); ?>&city=<?php echo $data['city']; ?>">
                              <img src="images/<?php echo strtolower($key); ?>.jpg" alt="<?php echo $altCode; ?>">
                              <span><?php echo  $key; ?></span>
                            </a>
                          </div>
                          <?php
                       
                            $counter_sport++;
                          }
                           }
                        }
                          if($counter_sport <= 4){   
                          ?>
                          <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" data-table2="<?php echo $data['table2'];?>" class="open-CitiesDialog">
                                    <img src="images/colleges.jpg">
                                    <span>COLLEGES</span>
                                  </a>
                                  <?php
                              }
                         }
                          ?>
                        </div>
                        
                      </div>
                    </div>
                    </div>
              <?php
                endif;
              ?>
<?php
    endforeach;
?>
<?php 
  elseif($_POST['modal_link'] === "restaurant-deals.php"):
?>
    <h2 class='modal-title'><?php echo $_POST['modal_title']; ?></h2>
    <div class="container recommed-city pcdesktop restarent_modal_main">
      <ul class="us-city worldtop_city restarent_modal">
        <ul class="restaurant-cities">
          <?php 
            $sql = "SELECT name,image_url FROM ".$_POST['modal_table']."";
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)):
          ?>
              <li class="col-sm-3 city-recom">
                <a href="<?php echo $SiteURL; ?><?php echo  $_POST['modal_link']; ?>?city=<?php echo $row['name']; ?>">
                   <?php $url = str_ireplace( 'http:', 'https:', $row['image_url']); ?>
                  <img src="<?php echo $url; ?>">
                  <span><?php echo  str_limit($row['name'],'10','...'); ?></span>
                </a>
              </li>
          <?php 
            endwhile;
          ?>
        </ul>
      </ul>
    </div>
<?php
  elseif($_POST['modal_trigger'] === "specific_page_modal"):
    if($_POST['modal_table2'] === "sportsTeam"):
?>    
      <h2 class='modal-title'>Colleges of <?php echo $_POST['modal_city']; ?></h2>
<?php 
    elseif ($_POST['modal_api'] === 'yelp'):
?>
     <div class="input-group stylish-input-group search-box-area-top">
               
          <input type="text" name="yelp-modal-search" placeholder="What you are looking for?" class="modal-search-box text-muted form-control" id="yelp-modal-search" >

          <span class="input-group-addon iconss" id="yelp-modal-search-button">
              <button type="submit">
                  <i class="fas fa-search"></i>
              </button>  
          </span>
            
      </div>
      <p id="no_data_found"></p>
<?php
    else: 
   if($_POST['modal_table'] === "specific_adrenaline"){
?>
    <h2 class='modal-title'>Adrenaline Rush</h2>
<?php
   }else{?>
        <h2 class='modal-title'><?php echo $_POST['modal_title']; ?></h2>
       <!--  <h2 class='modal-title'>Adrenaline Rush</h2> -->
<?php }
    endif;
     if($_POST['modal_table'] === "specific_adrenaline"){?>
    <!-- if($_POST['modal_table'] === "sports_categories" || $_POST['modal_table'] === "music_categories"):?> -->
      <div class="container recommed-city pcdesktop">
        <ul class="us-city worldtop_city">
          <ul class="local_music">
            <?php 
              $sql = "SELECT link,image_link,image_name,title FROM ".$_POST['modal_table']." where city1 like '%".$_SESSION['city_name']."%' or city2 like '%".$_SESSION['city_name']."%' limit 40";
              $result = mysql_query($sql);
              while($row = mysql_fetch_assoc($result)){
            ?>
                  <li class="col-sm-3 city-recom">
                    <a href="<?php echo  $row['link']; ?>"><img src="<?php echo  $row['image_link']; ?>" alt="<?php echo $row['image_name']; ?>"></a>
                    <span><?php echo  $row['title']; ?></span>
                  </li>
            <?php
             }
            ?>
          </ul>
        </ul>
      </div>
      <?php
    }   
     if($_POST['modal_table2'] === "specific_adrenaline"){?>
    <!-- if($_POST['modal_table'] === "sports_categories" || $_POST['modal_table'] === "music_categories"):?> -->
      <div class="container recommed-city pcdesktop">
        <ul class="us-city worldtop_city">
          <ul class="local_music">
            <?php 
              $sql = "SELECT link,image_link,image_name,title FROM specific_adrenaline where city1 like '%".$_SESSION['city_name']."%' or city2 like '%".$_SESSION['city_name']."%' limit 40";
              $result = mysql_query($sql);
              while($row = mysql_fetch_assoc($result)){
            ?>
                  <li class="col-sm-4 city-recom">
                    <a href="<?php echo  $row['link']; ?>"><img src="<?php echo  $row['image_link']; ?>" alt="<?php echo $row['image_name']; ?>" ></a>
                    <span><?php echo  str_limit($row['title'],'20','..'); ?></span>
                  </li>
            <?php
             }
            ?>
          </ul>
        </ul>
      </div>
      <?php
    }
    if($_POST['modal_table'] === "music_categories"):?>
    <!-- if($_POST['modal_table'] === "sports_categories" || $_POST['modal_table'] === "music_categories"):?> -->
      <div class="container recommed-city pcdesktop">
        <ul class="us-city worldtop_city">
          <ul class="local_music">
            <?php 
              $sql = "SELECT * FROM ".$_POST['modal_table']."";
              $result = mysql_query($sql);
              while($row = mysql_fetch_assoc($result)):
                if(!empty($row['music_link'])):
            ?>
                  <li class="col-sm-3 city-recom landingpageMusicCat">
                    <a href="<?php echo  $row['music_link']; ?>"><img src="images/<?php echo  $row['music_image']; ?>"></a>
                    <span><?php echo  $row['music_type']; ?></span>
                  </li>
            <?php else:?>
                    <li class="col-sm-3 city-recom">
                      <a href="<?php echo $SiteURL; ?><?php echo  $row['page_link']; ?>">
                        <img src="images/<?php echo  $row['image_link']; ?>">
                        <span><?php echo  $row['sports_name']; ?></span>
                      </a>
                    </li>
            <?php
                endif;
              endwhile; 
            ?>
          </ul>
        </ul>
      </div>
<?php
      elseif($_POST['modal_table2'] === "sportsTeam"):
?> 
        <div class="container recommed-city pcdesktop">
          <ul class="us-city worldtop_city">
          <?php
            $city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_POST['modal_city']."'");
            $get_city_name = mysql_fetch_assoc($city_name_query);
            $dropdown_city = $get_city_name['city_name'];
            // echo $dropdown_city;
            $state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
            $get_state_name = mysql_fetch_assoc($state_name_query);
            $_SESSION['country'] = $get_state_name['country_id'];
            $state_name = $get_state_name['name'];
            $state_code = $get_state_name['code'];
            
            $co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
            $get_co_name = mysql_fetch_assoc($co_name_query);
            $conry_nm = $get_co_name['name'];
            $sql = "SELECT * FROM `sportsTeam` WHERE state_code = '".$state_code."' OR state_name = '".$state_name."'";
            // echo $sql;
            $result = mysql_query($sql);
            $nurows = mysql_num_rows($result);
              if($nurows > 0):
                $row = mysql_fetch_assoc($result);
                $res = explode(",", $row['Colleges']);         
                for($i=0; $i < count($res); $i++):
          ?>
                  <a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo $res[$i]; ?>&city=<?php echo $_POST['modal_city']; ?>">
                    <li class='teamName col-sm-3'><?php echo $res[$i]; ?></li>
                  </a>
          <?php 
                endfor;
              else:
          ?>
              <li>No Colleges Teams For <?php echo $_POST['modal_city']; ?></li>
          <?php
            endif;
          ?>
          </ul>
        </div>
<?php
      elseif($_POST['modal_table'] === "cj_xml_data"):
?>
        <ul class="landing_page_hotel_deals landing_page_hotel_modal">
          <?php
            // $sql = "SELECT * FROM ".$_POST['modal_table']." WHERE afflication_name = '".$_POST['modal_affiliationName']."' AND description LIKE '%".$_POST['modal_whereCity']."%'";
            $sql = "SELECT * FROM ".$_POST['modal_table']." WHERE afflication_name = '".$_POST['modal_affiliationName']."' AND description rlike '[[:<:]]".$_POST['modal_whereCity']."[[:>:]]'";
            $result = mysql_query($sql);
            while($row = mysql_fetch_assoc($result)):
				if($_POST['modal_title'] == 'Hotels Deals'){
				$new = strstr($row['buy_url'], 'www.hotels.com');
				$buy_urls = str_replace('%2F', '/', $new);
				$buy_urlss = str_replace('%2F%3', '/', $buy_urls);
				$buy_urlsss = str_replace('1%3', '/', $buy_urlss);
				 $buy_url = 'https://'.$buy_urlss;

				}elseif($_POST['modal_title'] == 'Tours'){
				$new = strstr($row['buy_url'], 'www.tours4fun.com');
				$variable = substr($new, 4, strpos($new, "html"));
				$buy_urls = str_replace('%2F', '/', $variable);
				$buy_url = 'https://'.$buy_urls;
				}else{
				$buy_url =  $row['buy_url']; 
				}         
            ?>
              <li class="col-sm-4 col-md-4 col-xs-6 li_hotel_modal">
                <a target="_blank" href="<?php echo $buy_url; ?>">
				<div class="hotel_imges hotel_imgaes">
           <?php   $url = str_ireplace( 'http:', 'https:', $row['image_url'] ); ?>
                  <img src="<?php echo $url; ?>"></div>
                  <h3><?php echo str_limit($row['product_name'], 18,'...'); ?></h3>
                  <?php if(!empty($row['retail_price'])): ?>
                   
                  <p><?php echo str_limit($row['description'], 50, '...'); ?></p>
                   <h4 class="retail_hotel_price"><?php echo "$".$row['retail_price']." (".$row['currency'].")" ; ?></h4>
                  <?php endif; ?>
                  <h3 class="original_price tours_price original_price_new"><?php echo "$".$row['price']." (".$row['currency'].")" ; ?></h3>
                </a>
              </li>
          <?php
              endwhile;
          ?>
        </ul>
<?php 
      elseif(!empty($_POST['modal_api'])): 
?>
        <ul class="us-city worldtop_city" id="modal-landing-yelp">
          <?php 
            if($_POST['modal_api'] === "yelp"):
              $things_to_do_indoor = yelp_api_call($_POST['modal_city'], "0");
              foreach ($things_to_do_indoor as $thing_to_do_indoor):   
          ?>
                <li class="col-sm-3 col-md-3 col-xs-3">
                  <a href="<?php echo $thing_to_do_indoor->url; ?>" target='_blank'>
                    <img src="<?php echo $thing_to_do_indoor->image_url; ?>">
                    <h2><?php echo str_limit($thing_to_do_indoor->name, 23, '...'); ?></h2>
                    <ul class="thing_to_do_ratings">
                      <?php for($x=1;$x<=$thing_to_do_indoor->rating;$x++): ?>
                              <li><img src="imagesNew/star.png"></li>
                        <?php endfor; if(strpos($thing_to_do_indoor->rating,'.')): ?>
                                <li><img src="images/halfstarnew.png"></li>                      
                      <?php endif;?>                      
                    </ul>
                    <ul class="thing_to_do_categories" >
                      <li>
                      <?php 
                        $for_counter = 0 ;
                        $total = count((array)$thing_to_do_indoor->categories)-1; 
                        foreach ($thing_to_do_indoor->categories as $category): 
                      ?>
                        <?php 
                         echo  str_limit($category->title, 18, '...');
                          if($for_counter != $total):
                            echo ", ";
                          endif; 
                          $for_counter++;
                        ?>
                      <?php 
                        endforeach; 
                      ?>
                      </li>
                    </ul>
                  </a>
                </li>
          <?php 
              endforeach; 
            elseif($_POST['modal_api'] === "zomato"):
              $city_name = str_replace(' ','%20',$_POST['modal_city']);
              $cities_id_url = "https://developers.zomato.com/api/v2.1/locations?query=".$city_name."";
              $zomato_cities_id = zomato_api_call($cities_id_url);
              // echo"<pre>";
              // print_r ($zomato_cities_id);
              // echo"</pre>";
              $zomato_cities_id = $zomato_cities_id->location_suggestions[0]->city_id;
              $collection_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."";
              $zomato_collections = zomato_api_call($collection_url);
              $zomato_collections = $zomato_collections->collections;
              // if($zomato_collections == ""):
              //   $resturants_search_url = "https://developers.zomato.com/api/v2.1/search?entity_id=".$zomato_cities_id->location_suggestions[0]->entity_id."&lat=".$zomato_cities_id->location_suggestions[0]->latitude."&lon=".$zomato_cities_id->location_suggestions[0]->longitude."";
              //   $zomato_resturants = zomato_api_call($resturants_search_url);
              //   echo"<pre>";
              //   print_r ($zomato_resturants);
              //   echo"</pre>";
              // endif;
          ?>
              <ul class="zomato_resturant_collection">
                <?php
                    foreach ($zomato_collections as $zomato_collection):
                ?>
                      <li class="col-sm-3 col-md-3 col-xs-3">
                        <a target="_blank" href="<?php echo $zomato_collection->collection->share_url; ?>">
                          <img src="<?php echo $zomato_collection->collection->image_url; ?>">
                          <h3><?php echo $zomato_collection->collection->title; ?></h3>
                          <p><?php echo str_limit($zomato_collection->collection->description, 45, '...'); ?></p>
                        </a>   
                      </li>
          <?php 
            endforeach;
          ?>
        </ul>
      <?php endif; ?>
  <?php endif; ?>         
<?php endif; ?>
