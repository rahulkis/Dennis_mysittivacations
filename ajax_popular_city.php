<?php
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
 if($_POST['city_name'] == 'Clearwater'){
    $citysd = 'Tampa';
  }elseif($_POST['city_name'] == 'Panama City Beach'){
  $citysd = 'Panama City';
  }elseif($_POST['city_name'] == 'Siesta Key'){
    $citysd = 'Sarasota';
  }elseif($_POST['city_name'] == 'Lahaina'){
    $citysd = 'Kahului';
  }elseif($_POST['city_name'] == 'St. Pete Beach'){
    $citysd = 'Tampa';
  }elseif($_POST['city_name'] == 'Santa Monica'){
    $citysd = 'Los Angeles';
  }elseif($_POST['city_name'] == 'Wailea'){
    $citysd = 'Maui';
  }elseif($_POST['city_name'] == 'Puako'){
    $citysd = 'Kailua-Kona';
  }elseif($_POST['city_name'] == 'Poipu'){
    $citysd = 'Kauai island';
  }elseif($_POST['city_name'] == 'Manhattan Beach'){
    $citysd = 'Los Angeles';
  }elseif($_POST['city_name'] == 'La Jolla'){
    $citysd = 'San Diego';
  }elseif($_POST['city_name'] == 'Jekyll Island'){
    $citysd = 'Jacksonville';
  }elseif($_POST['city_name'] == 'Virginia Beach'){
    $citysd = 'Norfolk';
  }elseif($_POST['city_name'] == 'Miami Beach'){
    $citysd = 'Miami';
  }else{
     $citysd = $_POST['city_name'];
  }

   $popular = "SELECT * FROM popular_cities WHERE   name = '".$citysd."'";
   $result = $mysqli->query($popular);
   $count = $result->num_rows;
  if($count > 0){
    foreach ($result as $key => $value) {
      $iata = $value['iata_code'];
    }
  }else{
    $popular = "SELECT * FROM cities_for_musiclovers WHERE  name = '".$citysd."' limit 1";
     $result = $mysqli->query($popular);
     $count = $result->num_rows;
     if($count > 0){
      foreach ($result as $key => $value) {
        $iata = $value['iata_code'];
      }
     }
  }
    $flight_query = "SELECT * FROM popular_cities limit 60";
	$result = $mysqli->query($flight_query);
   foreach($result as $key=>$value){
if($_POST['city_name'] != $value['name']){
 $url ="https://mysittivacations.com/flight/redirection.php?origin_name=".$value['name']."&origin_iata=".$value['iata_code']."&destination_name=".$_POST['city_name']."&destination_iata=".$iata."&depart_date=2020-08-28&return_date=2020-09-11&with_request=true&adults=1&children=0&infants=0&trip_class=0&locale=en_us&one_way=false&currency=usd&ct_guests=1+passenger&ct_rooms=1&marker=130544.Zze682a1f45bb240db9459cdb5c45296";
?>
	 <li class="col-sm-3 col-md-3 col-xs-3 popular_cityy">
            <a href="<?php echo $url; ?>" target="blank">
            <span class="dealscity_name cityes_cityes_name"><?php echo $value['name']; ?> <i class="fa fa-plane" aria-hidden="true"></i> <?php echo $_POST['city_name']; ?></span>
              <img src="/<?php echo $value['image_url']; ?>" loading="lazy">
            </a>
          </li> 
<?php }
}
?>