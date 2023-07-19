<?php
	include 'Query.Inc.php';
	$Obj = new Query($DBName);
	error_reporting(0);
	$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
	$dropCity = rawurlencode($_POST['formatted']);
	function str_limit($value, $limit = 100, $end = '') {
	    if (mb_strlen($value) <= $limit) {
	      return $value;
	    }
	    return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
	  }
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

	$city_name = str_replace(' ','%20',$data['city']);
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
	if($zomato_collections != ""):
?>
		<h2 class="deal_heading" style="margin-right: 1000px;">
			<span style="color:black;">Best of</span> <?php echo $_POST['formatted']; ?> 
		</h2>
		<div class="zomato_collection_data">
			<ul class="zomato_resturant_collection">
				<?php
					foreach ($zomato_collections as $zomato_collection):
				?>
						<li class="col-sm-3 col-md-3 col-xs-3">
						  <a target="_blank" href="<?php echo $zomato_collection->collection->share_url; ?>">
						    <img src="<?php echo $zomato_collection->collection->image_url; ?>">
						    <h3><?php echo $zomato_collection->collection->title; ?></h3>
						    <p><?php echo str_limit($zomato_collection->collection->description, 51, '...'); ?></p>
						  </a>   
						</li>
				<?php 
					endforeach;
				?>
			</ul>
		</div>
<?php
	else :
?>
		<h2 class="deal_heading" style="margin-right: 1000px;">
			<span style="color:black;">Sorry, no resturants collections in </span> <?php echo $_POST['formatted']; ?> 
		</h2>
<?php 
	endif;
?>