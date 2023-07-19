<?php
$json = file_get_contents('php://input');
$someArray = json_decode($json, true);
  include 'Query.Inc.php';
  require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
  $Obj = new Query($DBName);
  error_reporting(0);
  $SiteURL     = "https://".$_SERVER['HTTP_HOST']."/";

  $info        = $someArray['info'];
  $modal_link  = $_POST['modal_link'];
  $modal_title = $_POST['modal_title'];
  $modal_table = $_POST['modal_table'];
  $source      = $someArray['source'];
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
 function address($lat, $long)
{
  // echo $lat." + ".$long."<br>";
  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4";

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, "");
  $curlData = curl_exec($curl);
  curl_close($curl);

  $data = json_decode($curlData);
  // echo"<pre>";
  // print_r($data->results[0]->formatted_address);
  // echo"</pre>";

  $address = $data->results[0]->formatted_address;

  return empty($address) ? "Address Not Found" : $address ;
}
function yelp_api_data($limit,$city,$keyword){
  //$key = empty($keyword) ? 'things%20%to%20%do' : str_replace(' ', '%20%', $keyword);
  $prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
  $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
  // echo "geocode";
  // echo $geocode;
  $output= json_decode($geocode);
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;
  $ch = curl_init();   
    $key = str_replace(' ','+',$keyword);
  // $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
    $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
  
  // return $urlgo;
  curl_setopt($ch, CURLOPT_URL, $urlgo);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $headers = array();
  $headers[] = "Authorization: Bearer BjJKM-1ZSbav4VMbtIUvC4isdLkwrihG9XDUanCcbbknBWIXs1XHBbJnuzH5vgD0ETyCpxAg3FAvMvxB_z6QCnusskWwYEofgpkNvOY7ytK_HKGrGv-98bo44V-AWnYx";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  if (curl_errno($ch)):
      echo 'Error:' . curl_error($ch);
  endif;
  curl_close ($ch);
 // echo "result";
 // echo $result;
  $get_deals = json_decode($result);

  $getyelpTourData = $get_deals->businesses;
  return $getyelpTourData;
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

  function izi_travel_api_call($url, $trigger){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache",
      "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  return ($err) ? $err : json_decode($response);
}

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
    // endif;
    
  endif;
  // return $urlgo;
  $result_get = file_get_contents($urlgo);
  $get_all_data = json_decode($result_get, true);
  $get_deals = $get_all_data['deals'];
  return $get_deals;
}

  if(!empty($info)):
              ?>
   
      

      <?php 
  $dropcity =  rawurlencode( str_replace(' ','+',$_SESSION['city_name']));
$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl&type=tour&query=".$dropcity."&limit=1";
$get_deals = izi_travel_api_call($url);
    $sd = 0;
    foreach ($get_deals as $homeData):
      $mainuuid         = $homeData->uuid; 
      $languages        = $homeData->languages[0];
      $map          = $homeData->map->bounds;
      $content_provider_uuid  = $homeData->content_provider->uuid;
      $images_uuid      = $homeData->images[0]->uuid;
      $city_uuid        = $homeData->location->city_uuid;
      $country_code       = $homeData->location->country_code;
      $country_uuid       = $homeData->location->country_uuid;
      $latitude         = $homeData->location->latitude;
      $longitude        = $homeData->location->longitude;
      $title          = $homeData->title;
?>                
      <div class="headingActivity-new new_activity container max_containerr">
            <a  href= "city-guide.php"  class="add-AudioTour" target="_blank">View More</a>
           

          </div>
          <div class="container recommed-city pcdesktop max_containerr">
              <div class="us-city worldtop_city tour_listing specific_audio_tours" id="<?php echo $mainuuid; ?>">
              <?php if($sd == 0){?>
               <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
          <h2>Audio Tours</h2>
          <span>Listen to detail tours before or during your trip</span>
    </div>
    <div class="owl-carousel owl-theme">
    <?php } ?>
                <?php 
                  $tour_url =  "https://api.izi.travel/mtgobjects/".$mainuuid."/children?languages=en,nl,ru&limit=40";
                  $tours_data = izi_travel_api_call($tour_url);
                  $k = 0;
            foreach ($tours_data as $tour_data) :
              $main_uiid        = $tour_data->uuid;
              $circle_latitude    = $tour_data->trigger_zones[0]->circle_latitude;
              $circle_longitude     = $tour_data->trigger_zones[0]->circle_longitude;
              $content_provider_uiid  = $tour_data->content_provider->uuid;
              $images_uiid      = @$tour_data->images[0]->uuid;
              if(is_null($images_uiid) || trim($images_uiid)==""):
                // $image_url = "https://mysitti.com/images/placeholder.jpg";
              else:
              
              $image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';
              $title = $tour_data->title;
                $address = address($circle_latitude, $circle_longitude);
          ?>
                <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy">
                  <a target='_blank' data-trigger="audio_modal" data-uuid="<?php echo $main_uiid ?>" class="open-AudioTourDialog" data-toggle="modal" data-target="#more_audio_tour">
                    <img src= "<?php echo $image_url ?>" width='200' height='200'>
                    <img src='https://mysitti.com/images/paybutton.png' class='play-1'>
                  </a><br>
                  <h2 class="tours_detailss_h2 home_audio_tours"><?php echo str_limit($title, 21, '...'); ?></h2><br>
                  <h3><?php echo $address ?></h3><br>
   
                        </div>
          <?php
        
              $k++;
              endif;
        
              // endif;
            endforeach;
                ?> 
              
            </div>
    </div>
    </div>
<?php
$sd++;
    endforeach;
      $s = '0';
    foreach ($info as $data): 
          if($data['tableName'] === "specific_adrenaline"){
                $randon_deals = "SELECT link,image_link,image_name,title FROM specific_adrenaline WHERE city1 like '%".$data['city']."%' or city2 like '%".$data['city']."%' limit 30";
                           $result = $mysqli->query($randon_deals);
         $count = $result->num_rows;
                            if($count > 0){
              ?>
             
                     <div class="container recommed-city pcdesktop max_containerr">
                             <div class="us-city worldtop_city tour_listing spefic_adrk">
      <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
         <h2>Adrenaline Rush</h2>
         <span>amazing flight,helicopter tours, and tons of exciting things to do</span>
            
            </div>
       <div class="owl-carousel owl-theme">
                          <?php
                            $i= 0;
                            foreach ($result as $value) {
                            $i++;
                          ?>
                                  <div class="item col-sm-12 city-recom adrline_specifics">
                                      <a href="<?php echo $value['link'] ?>">
                                        <img src="<?php echo $value['image_link']?>" alt="<?php echo $value['image_name']; ?>">
                                        <span><?php echo str_limit($value['title'], 30, '...'); ?></span>
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
                }
              
      ?>
         
              <?php
                 if($data['tableName'] === "sports_categories"):
              ?>
              <h2 class="custom_sport"> Sport and Excitment </h2>
               <?php if(!$detect->isMobile()) { ?>
                    <div class="headingActivity-new new_activity">
                      
                      <?php if($_SESSION['city_name'] != "Washington D.C.") { ?>
                      <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="<?php echo $data['source']; ?>" data-trigger="specific_page_modal" data-info="<?php echo $data['pageName']; ?>" data-table="<?php echo $data['tableName']; ?>" data-title="<?php echo $data['name']; ?>" data-api="<?php echo $data['api']; ?>" data-city="<?php echo $data['city']; ?>" data-wherecity="<?php echo $data['where_city']; ?>" data-affiliationname="<?php echo $data['afflication_name'] ; ?>" data-table2="<?php echo $data['table2'];?>" class="open-CitiesDialog">See all</a>
                    <?php } ?>
                    </div>
                    <div class="container recommed-city pcdesktop sports_specific_deals max_containerr">
                      <div class="us-city worldtop_city">
                        <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
                        <a id="top_links" name="escape%20%room">
                          <h2>Sports Tickets</h2>
                          <span>Enjoy the local pass time</span>
                        </a>
                        </div>
                         <div class="owl-carousel owl-theme">

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
                                       if(strtolower($key) == 'nba'){
                                          $altCode = "basketball Match";
                                        }elseif(strtolower($key) == 'nfl'){
                                           $altCode = "Rugby match";
                                        }elseif(strtolower($key) == 'mlb'){
                                          $altCode = "baseball match";
                                        }else{
                                          $altCode="";
                                        }?>
                                     <div class="item col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
                                      <a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo strtok($value, ','); ?>&city=<?php echo $data['city']; ?>">
                                        <img src="images/<?php echo strtolower($key); ?>.jpg" alt="<?php echo $altCode; ?>">
                                        <span><?php echo  $key; ?></span>
                                      </a>
                                    </div>
                          <?php
                        
                                    $counter_sport++;
                                 
                                  endif;
                                endif;
                              endforeach;
                          endif;
                          ?>
                        </div>
                      </div>
                    </div>
              <?php
              }else{
                ?>
                <div class="container recommed-city pcdesktop">
                <div class="us-city worldtop_city tour_listing spefic_adrk">
                <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
                <h2>Sports Tickets</h2>
                <span>Enjoy the local pass time</span>
                </div>
               
                 <div class="owl-carousel owl-theme">
                  
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
                            $i = 0;
                              foreach ($row as $key => $value) :
                                if(!in_array($key, $ignore) && trim($key) != '') :
                                    // echo $value."</br>";
                                  if(strtok($value, ',') != ''):
                                    $i++;
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
                                    <div class="item col-sm-3 city-recom">
                                      <a href="<?php echo $SiteURL; ?>allSports.php?ticketmaster_trigger=<?php echo strtok($value, ','); ?>&city=<?php echo $data['city']; ?>">
                                        <img src="images/<?php echo strtolower($key); ?>.jpg" alt="<?php echo $altCode; ?>">
                                        <span><?php echo  $key; ?></span>
                                      </a>
                                    </div>
                          <?php
                                    $counter_sport++;
                                 
                                  endif;
                                endif;
                              endforeach;
                          endif;
                          ?>

                 </div>
                 </div>
                 </div>
              <?php 
            }
                endif;
    endforeach;
    endif;

    $get_deals = groupon_api_call('30',$someArray['formatted'],'Tours');
    if(!empty($get_deals)):
?>
      <div class="container recommed-city pcdesktop max_containerr">
       <div class="us-city worldtop_city tour_listing specific_amzingk thing_toDoGroupon">
      <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
           <h2> Tour Deals </h2>
        <span>amazing flight,helicopter tours, and sightseeing</span>
            
            </div>
       <div class="owl-carousel owl-theme">
          <?php 
          $i= 0;
          foreach ($get_deals as $homeData):
              $price = $homeData['options'][0]['price']['formattedAmount'];
              $value = $homeData['options'][0]['value']['formattedAmount'];
              $discountPercent = $homeData['options'][0]['discountPercent'];
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
              $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
              $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
              $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
              $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
              $tourname = $homeData['title']; 
            $out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
            if($discountPercent != 0){
              $i++;?>
            <div class="item col-md-12 col-sm-12 col-xs-12 homeGroupon city-recom">
              <div class='borderIsan hotelandingDeal'>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <img src="<?php echo $homeData['grid4ImageUrl']; ?>">
                </a>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
                  <h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
                </a>
                <h1 class="pricelanding"><?php echo $value ; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
                

                <h2 class="valuelanding"><?php echo $price ;?></h1>
                <h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
              </div>
            </div>
        <?php  }  endforeach; ?>
      </div>
      </div>
  </div>

      <?php
    endif;
                  $city_name = str_replace(' ','%20',$_SESSION['city_name']);
                  $cities_id_url = "https://developers.zomato.com/api/v2.1/locations?query=".$city_name."";
                  $zomato_cities_id = zomato_api_call($cities_id_url);
                  $zomato_cities_id = $zomato_cities_id->location_suggestions[0]->city_id;
                  $collection_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."&count=40";
                  $zomato_collections = zomato_api_call($collection_url);
                  $zomato_collections = $zomato_collections->collections;
                  if($zomato_collections != ""):
              ?>
              <h2 class="custom_sport"><?php echo $_SESSION['city_name']; ?> Favorites</h2>
                   <div class="container recommed-city" style="text-align: center;margin: 15px;">
   <a href="https://www.anrdoezrs.net/click-8265264-11725905?cm_mmc=CJ-_-4882762-_-8265264-_-Your%20Orlando%20Vacation%20Starts%20Here!" target="_top">
<img src="https://www.awltovhc.com/image-8265264-11725905" width="700" height="90" alt="Your Orlando Vacation Starts Here!" border="0"/></a>

      </div>
          <div class="container recommed-city pcdesktop max_containerr">
              <div class="us-city worldtop_city tour_listing">
             
               <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
          <h2>Handpicked Restraurants</h2>
        <span>Taste <?php echo $_SESSION['city_name']; ?> pizza, hot dogs, Italian, and local cusines</span>
    </div>
    <div class="owl-carousel owl-theme">
                          <?php
                          $i = 0;
                              foreach ($zomato_collections as $zomato_collection):
                                $i++;   
                                    ?>
                                <div class="item col-sm-3 col-md-3 col-xs-3 restaurant_spefics">
                                  <a target="_blank" href="<?php echo $zomato_collection->collection->share_url; ?>">
                                    <img src="<?php echo $zomato_collection->collection->image_url; ?>">
                                    <h3><?php echo $zomato_collection->collection->title; ?></h3>
                                    <p><?php echo str_limit($zomato_collection->collection->description, 30, '...'); ?></p>
                                  </a>   
                                </div>
                    <?php 
                              endforeach;
                    ?>
                       
                    </div>

                  </div>
              <?php endif;
$get_deals = groupon_api_call('30',$_SESSION['city_name'],'restaurants');
?>
          <div class="container recommed-city pcdesktop max_containerr">
              <div class="us-city worldtop_city tour_listing thing_toDoGroupon">
             
               <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
          <h2>Restraurant Deals</h2>
          <span>Save yourself or family money with meal deals</span>
    </div>
    <div class="owl-carousel owl-theme">
          <?php 
          $i= 0;
          foreach ($get_deals as $homeData):
              $price = $homeData['options'][0]['price']['formattedAmount'];
              $value = $homeData['options'][0]['value']['formattedAmount'];
              $discountPercent = $homeData['options'][0]['discountPercent'];
              $endAt =  $homeData['options'][0]['endAt'];
              $endDate = date('m/d/Y', strtotime($endAt));
              $cityName = $homeData['options'][0]['redemptionLocations'][0]['name'];
              $streetAddress1 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress1'];
              $streetAddress2 = $homeData['options'][0]['redemptionLocations'][0]['streetAddress2'];
              $postalCode = $homeData['options'][0]['redemptionLocations'][0]['postalCode'];
              $tourname = $homeData['title']; 
            $out = strlen($tourname) > 20 ? substr($tourname,0,20)."..." : $tourname;
            if($discountPercent != 0){
              $i++;?>
               
            <div class="item col-md-12 col-sm-12 col-xs-12 homeGroupon city-recom">
              <div class='borderIsan hotelandingDeal'>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <img src="<?php echo $homeData['grid4ImageUrl']; ?>">
                </a>
                <a href="<?php echo str_ireplace('http:','https:',$homeData['dealUrl']); ?>" target="_blank">
                  <!-- <h2 class="discountPercent"><?php echo $discountPercent; ?>% Off</h2> -->
                  <h1 class="nameIsan hotelandingnameIsan" style= "text-align: center;"><?php echo $out ; ?></h1>
                </a>
                <h1 class="pricelanding"><?php echo $value ; ?></h2>
                <h2 class="discountPercent groupon_per">(<?php echo $discountPercent; ?>% Off)</h2>
                

                <h2 class="valuelanding"><?php echo $price ;?></h1>
                <h1 class="saleend">Sales Ends: <?php echo $endDate ; ?></h1>
              </div>
            </div>
        <?php  }  endforeach; ?>
      </div>

</div>
<div class="us-city worldtop_city max_containerr">
                  <div class="col-sm-3 col-md-3 col-xs-3 popular_cityy thing_to_specific">
                  <a id="top_links" name="escape%20%room" >
                  <h2>Fine Dining</h2>
                  <span>Treat yourself to an amazing meal</span>
                  </a>
                  </div>
                  
<div class="owl-carousel owl-theme">
<?php 
if($_SESSION['city_name'] == 'Saint Petersburg'){
  $finedining = 'Tampa';
}else{
   $finedining = $_SESSION['city_name'];
}
    $ciountt = 0;
      $getyelpTourData = yelp_api_data('20',$finedining,'Fine Dining');      
      if(!empty($getyelpTourData)):
      foreach ($getyelpTourData as $homeData):
        $ciountt++;
          $tour_id = $homeData->id;
          $tour_name= $homeData->name;
          $tour_image = $homeData->image_url;
          $tour_url = $homeData->url;
          $tour_review_count = $homeData->review_count;
          $tour_rating = $homeData->rating;
          $tour_location_address1 = $homeData->location->address1;
          $tour_location_address2 = $homeData->location->address2;
          $tour_city = $homeData->location->city;
          $tour_zipCode = $homeData->location->zip_code;
          $tour_country = $homeData->location->country;
          $tour_state = $homeData->location->state; 
          $tour_phone = $homeData->display_phone;
  
      ?>
        <div class="item row tab-two">
            <div class="m_2 tour_images">
              <a href="<?php echo $tour_url ; ?>" target="_blank">
                 <?php if(!empty($tour_image)) : ?>
                  <img src="<?php echo $tour_image; ?>">
                <?php else : ?>
                  <img src="<?php echo $SiteURL; ?>images/noimage-found.jpeg">
                <?php endif; ?>
              </a>
            </div>
           
              <h2 class="hu tour_names">
                <a href="<?php echo $tour_url; ?>" target="_blank"><?php echo $tour_name; ?></a>
              </h2> 
            <ul class="rating2 tour_ratingd">
              <?php for($x=1;$x<=$tour_rating;$x++): ?>
                <li><img class="star_images"  src="imagesNew/star.png"></li>
              <?php endfor; ?>
              <?php if (strpos($tour_rating,".")) : ?>
                <li><img class="star_images" src="images/halfstarnew.png"></li>
              <?php 
                $x++;
                endif; ?>
            </ul>           
                    <p class="reviews yelpuser-review" style="color:#0355a9; cursor:pointer;" data-toggle="modal" data-target="#myModal-review" data-id="<?php echo $tour_id ; ?>" ><?php echo $tour_review_count ; ?> Reviews</p>
            <ul class="tour_cate_type" style="color:black";>
              <li>
                <?php 
                  $for_counter = 0 ;
                  $total = count((array)$homeData->categories)-1; 
                  foreach ($homeData->categories as $category):
                    echo $category->title;
                    if($for_counter != $total):
                      echo ", ";
                    endif; 
                    $for_counter++; 
                  endforeach; 
                ?>
              </li>
            </ul>
            <div class="col-md-12 home_review">
              <ul class="list_f tour_address">
                <li><?php echo $tour_location_address1 ; ?></li>
                <li><?php echo $tour_location_address2 ; ?></li>
                <li><?php echo $tour_city ; ?>  <?php echo $tour_state ; ?>  <?php echo $tour_zipCode ; ?></li>
                <li><?php echo $tour_phone ; ?></li>
              </ul>
            </div>
            
        </div>
  <?php
      endforeach;
      ?>
      </div>
      <?php
    else:
  ?>
      <div class="row tab-two text-muted">
          <div class="yelp-serach-null-result col-md-5 col-sm-5 col-xs-6">
            <p> No record Found</p>
          </div>
        </div>
<?php
    endif;?>
    </div> 
   