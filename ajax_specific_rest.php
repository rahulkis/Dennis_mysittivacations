
  <?php
    function zomato_api_call($url){
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
  $city_name = str_replace(' ','%20',$_POST['city']);
  $cities_id_url = "https://developers.zomato.com/api/v2.1/locations?query=".$city_name."";
  $zomato_cities_id = zomato_api_call($cities_id_url);
  $zomato_cities_id = $zomato_cities_id->location_suggestions[0]->city_id;
  $collection_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."&count=4";
  $collection_url_mob_url = "https://developers.zomato.com/api/v2.1/collections?city_id=".$zomato_cities_id."&count=30";
  $zomato_collections = zomato_api_call($collection_url);
  $zomato_collections = $zomato_collections->collections;
  $zomato_collections_mob = zomato_api_call($collection_url_mob_url);
  $zomato_collections_mob = $zomato_collections_mob->collections;
  if($zomato_collections != ""){
  ?>
  <div class="headingActivity-new new_activity container">
    <a href="" class="cites_links">
    <h2>Handpick restaurants</h2>
    </a>
    <a  data-toggle="modal" data-target="#popularcitiesModal" data-page="index" data-trigger="specific_page_modal" data-info="" data-table="" data-title="Handpick restaurants" data-api="zomato" data-city="<?php echo $_POST['city']; ?>" data-wherecity="" data-affiliationname="" class="open-CitiesDialog">See all</a>
  </div>
  <div class="container recommed-city pcdesktop">
    <ul class="us-city worldtop_city popular_cityy">
      <ul class="zomato_resturant_collection">
        <?php
        foreach ($zomato_collections as $zomato_collection){
        ?>
        <li class="col-sm-3 col-md-3 col-xs-3 restaurant_spefics">
          <a target="_blank" href="<?php echo $zomato_collection->collection->share_url; ?>">
            <img src="<?php echo $zomato_collection->collection->image_url; ?>">
            <h3><?php echo $zomato_collection->collection->title; ?></h3>
            <p><?php echo $zomato_collection->collection->description; ?></p>
          </a>   
        </li>
        <?php 
       }
        ?>
      </ul>
    </ul>

    <div class="bs-example popular_city_in_mobile">
      <div class="carousels" >
        <div class="carousel-inners" >
        <?php
        foreach ($zomato_collections_mob as $zomato_collections){ 
        ?>
          <div class="carousel_mobile tours_specificss">
            <a target="_blank" href="<?php echo $zomato_collections->collection->share_url; ?>">
              <img src="<?php echo $zomato_collections->collection->image_url; ?>">
              <h3><?php echo $zomato_collections->collection->title; ?></h3>
              <p><?php echo $zomato_collections->collection->description; ?></p>
            </a>  
          </div>
          <?php       
        }
        ?>
        </div>

      </div>
    </div>

  </div>
<?php } ?>