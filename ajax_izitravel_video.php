<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

if (empty($_POST['session'])) {
	$dropCity = rawurlencode( str_replace(' ','+',$_POST['formatted']));
}else{
	$_SESSION['city_name'] = $_POST['session'];
	$dropCity = rawurlencode(str_replace(' ','+',$_POST['formatted']));
}
if (isset($_POST['offset'])) {
	$offset = $offset + $_POST['offset'] ;
}else{
	$offset = 0 ;
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
function str_limit($value, $limit = 100, $end = '') {
	if (mb_strlen($value) <= $limit) {
		return $value;
	}
	return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
}
?>
<?php
if (isset($_POST['session']) or isset($_POST['formatted']) or isset($_POST['offset']) or $_POST['search_trigger'] ==='selected_result_data') : 
	if($_POST['offset'] === 5):
		$limit = 0 ;
	else:
		$limit = 5;
	endif;
	if (isset($_POST['search_main_uuid'])):

		$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl&type=tour&uuid=".$_POST['search_main_uuid']."";
	else:
		if($dropCity == 'Tokyo'):
			$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl,ru&type=tour&query=".$dropCity."&limit=".$limit."&offset=".$offset."";
		else:
			$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl&type=tour&query=".$dropCity."&limit=".$limit."&offset=".$offset."";
		endif;
	endif;
		// echo $url;
	$get_deals = izi_travel_api_call($url);
	$s = $_POST['offset'] ;
	foreach ($get_deals as $homeData):
		$mainuuid 				= $homeData->uuid; 
		$languages 				= $homeData->languages[0];
		$map 					= $homeData->map->bounds;
		$content_provider_uuid  = $homeData->content_provider->uuid;
		$images_uuid 			= $homeData->images[0]->uuid;
		$city_uuid 				= $homeData->location->city_uuid;
		$country_code 			= $homeData->location->country_code;
		$country_uuid 			= $homeData->location->country_uuid;
		$latitude 				= $homeData->location->latitude;
		$longitude 				= $homeData->location->longitude;
		$title 					= $homeData->title;
		?>		         		
		<section class="travels sec_pad bg_grey what_do pb-0 audio_resposs">
			<div class="container">
				<div class="heading">
					<h4><?php echo $title; ?></h4>
				</div>
				<div class="travels_inner slider_nav mb-0">
					<div class=" owl-carousel owl-theme" id="<?php echo $mainuuid; ?>">

						<?php 
						$tour_url =  "https://api.izi.travel/mtgobjects/".$mainuuid."/children?languages=en,nl,ru&limit=15";
						$tours_data = izi_travel_api_call($tour_url);
						$k = 0;
						foreach ($tours_data as $tour_data) :
							$main_uiid 				= $tour_data->uuid;
							$circle_latitude 		= $tour_data->trigger_zones[0]->circle_latitude;
							$circle_longitude 		= $tour_data->trigger_zones[0]->circle_longitude;
							$content_provider_uiid  = $tour_data->content_provider->uuid;
							$images_uiid			= @$tour_data->images[0]->uuid;
							if(is_null($images_uiid) || trim($images_uiid)==""){
								$image_url = "https://dev.mysittivacations.com/no-image.png";
							} else{
								$image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';
							}
							$title = $tour_data->title;
							$address = address($circle_latitude, $circle_longitude);
							?>
							<div class="grid video_grid">
								<a target='_blank' data-trigger="audio_modal" data-uuid="<?php echo $main_uiid ?>" class="open-AudioTourDialog" data-toggle="modal" data-target="#more_audio_tour">
									<div class="image_sq_htfix">
										<img src= "<?php echo $image_url ?>"  class="img-fluid w-100">
									</div>
									<!-- <img src='/images/paybutton.png' class='play-1'> -->
									<h3><?php echo str_limit($title, 21, '...'); ?></h3>
									<button type="button" class="btn btn-primary">
									<i class="fas fa-play-circle"></i>
								</button>
							</a>
						</div>
					<?php endforeach; ?> 
				</div>
			</div>
		</div>
	</section>


	<?php
	$s++;
endforeach;
elseif ($_POST['trigger'] == 'seeall_tours' || $_POST['trigger'] == 'seefew_tours') :
	$offsets = json_decode($_POST['tours_offset'], true);
	$tour_offset_value = $offsets[$_POST['uuid']];
	if($_POST['trigger'] == 'seefew_tours'):
		$tour_url =  "https://api.izi.travel/mtgobjects/".$_POST['uuid']."/children?languages=en,nl,ru&limit=4";
	else:
		$tour_url =  "https://api.izi.travel/mtgobjects/".$_POST['uuid']."/children?languages=en,nl,ru";
	endif;
	/////////////////////////////////////////////////////////////////////////////////////////
	// Call to izi api above you have to provide tour url as parameter is this function:-> //
	// izi_travel_api_call($url);                                                          //
	/////////////////////////////////////////////////////////////////////////////////////////
	$tours_data = izi_travel_api_call($tour_url);
	foreach ($tours_data as $tour_data) :
		$main_uiid 				= $tour_data->uuid;
		$circle_latitude 		= $tour_data->trigger_zones[0]->circle_latitude;
		$circle_longitude 		= $tour_data->trigger_zones[0]->circle_longitude;
		$content_provider_uiid  = $tour_data->content_provider->uuid;
		$images_uiid 			= @$tour_data->images[0]->uuid;
		if(is_null($images_uiid) || trim($images_uiid)==""):
				// $image_url ="https://maps.googleapis.com/maps/api/staticmap?center=".$circle_latitude.",".$circle_longitude."&zoom=13&size=400x400&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&key=AIzaSyDvcXMGhJrh_bMGNoygumOIt49uAOIKSdQ";
				// $image_url = "https://mysittidev.com/images/placeholder.jpg";
	else:
		$image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';
		$title = $tour_data->title;
			// $tour_content_url = "https://api.izi.travel/mtgobjects/".$main_uiid."?languages=en,nl,ru";
			// $type_of_tour_content = izi_travel_api_call($tour_content_url);
			// $type_of_tour_content = $type_of_tour_content[0]->type;
		$address = address($circle_latitude, $circle_longitude);
	  		// if($type_of_tour_content === "tourist_attraction"):
		?>
		<li class="col-sm-3 col-md-3 col-xs-3">
			<a data-toggle="modal" data-target="#more_audio_tour" data-trigger="audio_modal" data-audioid="<?php echo $main_uiid ?>" class="open-AudioTourDialog" >
				<img src= "<?php echo $image_url ?>" width='200' height='200'>
				<img src='https://mysitti.com/images/paybutton.png' class='play-1'>
			</a><br>
			<h2><?php echo str_limit($title,21,'...'); ?></h2><br>

			<a data-toggle="modal" data-target="#more_audio_tour" data-trigger="map_modal" data-audioid="<?php echo $main_uiid ?>" class="open-AudioTourDialog viewmap_button" >View Map</a>
		</li>			
		<?php	
	endif;

endforeach;
elseif ($_POST['trigger'] == 'search_trigger_modal') :
	$tour_url =  "https://api.izi.travel/mtgobjects/".$_POST['uuid']."/children?languages=en,nl,ru";
	/////////////////////////////////////////////////////////////////////////////////////////
	// Call to izi api above you have to provide tour url as parameter is this function:-> //
	// izi_travel_api_call($url);                                                          //
	/////////////////////////////////////////////////////////////////////////////////////////
	$tours_data = izi_travel_api_call($tour_url);
	?>
	<h2><?php echo $_POST['title']?></h2>
	<ul class="groupon_deals_modal">
		<?php
		foreach ($tours_data as $tour_data) :
			$main_uiid 				= $tour_data->uuid;
			$circle_latitude 		= $tour_data->trigger_zones[0]->circle_latitude;
			$circle_longitude 		= $tour_data->trigger_zones[0]->circle_longitude;
			$content_provider_uiid  = $tour_data->content_provider->uuid;
			$images_uiid 			= @$tour_data->images[0]->uuid;
			if(is_null($images_uiid) || trim($images_uiid)==""):
					// $image_url ="https://maps.googleapis.com/maps/api/staticmap?center=".$circle_latitude.",".$circle_longitude."&zoom=13&size=400x400&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&key=AIzaSyDvcXMGhJrh_bMGNoygumOIt49uAOIKSdQ";
					// $image_url = "https://mysittidev.com/images/placeholder.jpg";
		else:
			$image_url = 'https://media.izi.travel/'.$content_provider_uiid.'/'.$images_uiid.'_800x600.jpg';
			$title = $tour_data->title;

			$address = address($circle_latitude, $circle_longitude);
			?>
			<li class="col-sm-3 col-md-3 col-xs-3 city-recom" style="text-align:left; float: left; list-style: none; position: relative; width: 290px;">
				<a data-toggle="modal" data-target="#more_audio_tour" data-trigger="audio_modal" data-audioid="<?php echo $main_uiid ?>" class="open-AudioTourDialog" >
					<img src= "<?php echo $image_url ?>" width='200' height='200'>
					<img src='https://mysitti.com/images/paybutton.png' class='play-1'>
				</a><br>
				<h2 style="text-align: left;"><?php echo str_limit($title,20,'...'); ?></h2><br>

				<a data-toggle="modal" data-target="#more_audio_tour" data-trigger="map_modal" data-audioid="<?php echo $main_uiid ?>" class="open-AudioTourDialog viewmap_button" >View Map</a>
			</li>			
			<?php	
		endif;

			// endif;
	endforeach;	
	?>
</ul>
<?php	
elseif ($_POST['trigger'] == 'audio_modal'): 
	$tour_url 				= "https://api.izi.travel/mtgobjects/".$_POST['uuid']."?languages=en,nl,ru";
	$tours_data 			= izi_travel_api_call($tour_url);
	$content_provider_uuid  = $tours_data[0]->content_provider->uuid;
	$audio_uiid 			= $tours_data[0]->content[0]->audio[0]->uuid;
	$image_uiid 			= $tours_data[0]->content[0]->images[0]->uuid;
	$description 			= $tours_data[0]->content[0]->desc;
	$title 					= $tours_data[0]->content[0]->title;
	$audio_url 				= "https://media.izi.travel/".$content_provider_uuid."/".$audio_uiid.".m4a";
	$image_url 				= 'https://media.izi.travel/'.$content_provider_uuid.'/'.$image_uiid.'_800x600.jpg';
	?>
	<div class='home_list home_list_pop'>

		<h2><?php echo $title; ?></h2>

		<audio controls id='myAudio' >
			<source src= "<?php echo $audio_url; ?>" type='audio/mp3'>
			</audio>

			<div class='home_image home_pop_img'>
				<img src= "<?php echo $image_url; ?>">
			</div>

			<div class='home_data'>
				<div class='home_city'>
					<?php echo $description; ?>
				</div>
			</div>
		</div>
		<?php
	elseif($_POST['trigger'] == 'map_modal'):
		$tour_url = "https://api.izi.travel/mtgobjects/".$_POST['uuid']."?languages=en,nl,ru";

		$tours_data = izi_travel_api_call($tour_url, 'map_modal');
		$location   = $tours_data[0]->location;
		$latitude   =  $location->latitude;
		$longitude  = $location->longitude;
		?>
		<div class='home_list'>
			<div id='map'></div>
			<script>
				function initMap() {
					var uluru = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
					var map = new google.maps.Map(document.getElementById('map'), {
						zoom: 18,
						center: uluru
					});
					var marker = new google.maps.Marker({
						position: uluru,
						map: map
					});
				}
			</script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ8bxQApwVyI3IpuLbavOPYvHnuHbnsKc&callback=initMap" >	</script>

		</div>
		<?php 
	elseif ($_POST['trigger'] == 'genral_page_modal') :
		?>
		<h2 class='modal-title'><?php echo $_POST['title']; ?></h2>
		<?php 
		$sql = "SELECT * FROM ".$_POST['tableName'] ."";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result)): 
			?>
			<ul class="us-city-popup">
				<li class="col-sm-3 col-md-3 col-xs-3">
					<span class="dealscity_name cityes_cityes_name"><?php echo $row['name']; ?></span>
					<a href="" id="city_tour_detail" data-city="<?php echo $row['name']; ?>">
						<img src="<?php echo $row['image_url']; ?>"/>
					</a>
				</li>
			</ul>
		<?php	endwhile;
	elseif($_POST['search_trigger'] === 'top_search_trigger'):
		$tour_keyword = $_POST['tour_keyword'];
		$dropCity 	  = rawurlencode( str_replace(' ','+',$_POST['city']));
		if($dropCity == 'Tokyo'):
			$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl,ru&type=tour&query=".$dropCity."";
		else:
			$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl&type=tour&query=".$dropCity."";
		endif;
		// echo $url;
		$get_search_result = izi_travel_api_call($url);
		
		if(!empty($get_search_result)):
			$titles 	= [];
			?>
			<ul id="list-group">
				<?php 

				foreach ($get_search_result as $key => $homeData): 
					$titles[$homeData->uuid]	 = $homeData->title;
				endforeach;

				$result = array_filter($titles, function ($item) use ($tour_keyword) {
					if (stripos($item, $tour_keyword) !== false) {
						return true;
					}
					return false;
				});

				foreach($result as $key => $tourname):
					?>
					<!-- <li data-toggle="modal" data-target="#more_audio_tour" id="search_result_listing"  data-trigger="seeall_tours" data-uuid="<?php echo $key;?>" ><?php echo $tourname; ?></li> -->
					<li class="list-group-item-listing" data-toggle="modal" data-target="#popularcitiesModal" id="search_result_listing"  data-trigger="search_trigger_modal" data-title="<?php echo $tourname; ?>" data-uuid="<?php echo $key;?>" ><?php echo $tourname; ?></li>
					<!-- <li onClick="selectTour(<?php echo base64_encode($tourname); ?>);" id="<?php echo $key;?>" ><?php echo $tourname; ?></li> -->
					<?php 
				endforeach;
				?>
			</ul>
			<?php
		endif;
	endif;
	?>
	