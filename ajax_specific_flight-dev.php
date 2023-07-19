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
   
<!--end of travels--> 

 

<?php if($_SESSION['city_name'] == 'Washington D.C.'){
  $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 3";
}else{
  $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_SESSION['city_name']."%' AND tag = 'Tours4Fun' LIMIT 3";
}
$result = $mysqli->query($randon_deals);?>

<!--<section class="see_beautiful sec_pad">
  <div class="container">
    <div class="heading">
      <div class="row">
        <div class="col-lg-9">
          <h4>Traveller Guides <?php echo $_SESSION['city_name']; ?></h4>
          <p>Enjoy the scenic views of National Parks</p>
        </div>
         
     </div>
   </div>
   <div class="see_beautiful_inner">
    <div class="row">
      <?php 
      foreach ($result as $keys => $values) {
        if(!empty($values['tag'])){
          $new = substr($values['link'], strrpos($values['link'], '=' )+1);
          $buy_urls = str_replace('%3A%2F%2F', '://', $new);
          $buy_urlss = str_replace('%2F', '/', $buy_urls);
          $buy_urlsss = str_replace('%3F', '/', $buy_urlss);
          $buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
          $buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
          $buy_url = $buy_urlsssss; 
          ?>
          <div class="col-lg-4">
            <div class="grid">
              <a href="<?php echo $buy_url; ?>"  target="_blank">
                <div class="image_htfix">
                <img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>" class="img-fluid w-100">
              </div>
                <div class="item_content">
                  <h3><?php echo $values['title']; ?></h3>
                  <p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
                </div>
              </a>
            </div>
          </div>
          <?php     
        }
      }?>
    </div>
  </div>
</div>
</section>-->
<div class="slider-section discount-section  dig-sec"> 
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<div  class="myheader-sec">
				   <h2>Traveller Guides <?php echo $_SESSION['city_name']; ?></h2>
				   <p>Enjoy the scenic views of National Parks</p>
				</div>
			</div>
		</div>
		<div class="row">
		   <?php 
		foreach ($result as $keys => $values) {
        if(!empty($values['tag'])){
          $new = substr($values['link'], strrpos($values['link'], '=' )+1);
          $buy_urls = str_replace('%3A%2F%2F', '://', $new);
          $buy_urlss = str_replace('%2F', '/', $buy_urls);
          $buy_urlsss = str_replace('%3F', '/', $buy_urlss);
          $buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
          $buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
          $buy_url = $buy_urlsssss; 
          ?>
		<div class="col-12 col-sm-6 col-md-4 col-lg-4">
		 <!--<a href="<?php //echo $buy_url; ?>"  target="_blank">-->
				<div class="discount-block">
					<img src="<?php echo $values['image_link']; ?>" alt="<?php echo $values['title']; ?>">
					<div class="discount-content">
						<h3><?php echo $values['title']; ?></h3>
						 <p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
					</div>
				</div>
		<!--</a>-->
		</div>
		
			 
			
		<?php     
        }
      }?>
		</div>
	</div>
</div>
<!--end of see_beautiful -->
<?php $get_deals = groupon_api_call('30',$someArray['formatted'],'Tours');
if(!empty($get_deals)):
  ?>
  
  <?php
endif;
endif;
?>


