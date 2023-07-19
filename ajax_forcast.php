<h4 style="text-align: center;font-size: 20px;">  Forcast</h4>
						<div class="subscribe-list subscibe_list">
						<ul>
<?php
function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key => $value) {
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value) {
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    }
    $r .= implode(', ', $values);
    return $r;
}

$url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';
$app_id = '9mfvLOTp';
$consumer_key = 'dj0yJmk9V3RxOUVXV00xU1BHJnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PTc1';
$consumer_secret = '0ce1a5bb28ec09fd302763d122d610107c62a1a9';

$query = array(
    'location' => $_POST['location'],
    'format' => 'json',
);

$oauth = array(
    'oauth_consumer_key' => $consumer_key,
    'oauth_nonce' => uniqid(mt_rand(1, 1000)),
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_timestamp' => time(),
    'oauth_version' => '1.0'
);

$base_info = buildBaseString($url, 'GET', array_merge($query, $oauth));
$composite_key = rawurlencode($consumer_secret) . '&';
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

$header = array(
    buildAuthorizationHeader($oauth),
    'X-Yahoo-App-Id: ' . $app_id
);
$options = array(
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_HEADER => false,
    CURLOPT_URL => $url . '?' . http_build_query($query),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false
);

$ch = curl_init();
curl_setopt_array($ch, $options);
$response = curl_exec($ch);
curl_close($ch);
$return_data = json_decode($response);
if($return_data->forecasts){
foreach($return_data->forecasts as $key=>$val){
	if($key < 5){
   switch($val->code) {
    case "0":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/0d.png";
        break;            
    case "1":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/1d.png";
        break;
    case "2":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/2d.png";
        break;
    case "3":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/3d.png";
        break;
    case "4":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/4d.png";
        break;
    case "5":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/5d.png";
        break;
    case "6":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/6d.png";
        break;
    case "7":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/7d.png";
        break;
    case "8":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/8d.png";
        break;
    case "9":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/9d.png";
        break;
    case "10":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/10d.png";
        break;
    case "11":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/11d.png";
        break;
    case "12":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/12d.png";
        break;
    case "13":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/13d.png";
        break;
    case "14":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/14d.png";
        break;
    case "15":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/15d.png";
        break;
    case "16":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/16d.png";
        break;
    case "17":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/17d.png";
        break;
    case "18":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/18d.png";
        break;
    case "19":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/19d.png";
        break;
    case "20":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/20d.png";
        break;
    case "21":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/21d.png";
        break;
    case "22":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/22d.png";
        break;  
    case "23":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/23d.png";
        break;
    case "24":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/24d.png";
        break;
    case "25":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/25d.png";
        break;
    case "26":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/26d.png";
        break;
    case "27":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/27d.png";
        break;
    case "28":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/28d.png";
        break;
    case "29":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/29d.png";
        break;
    case "30":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/30d.png";
        break;
    case "31":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/31d.png";
        break;
    case "32":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/32d.png";
        break; 
    case "33":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/33d.png";
        break;
    case "34":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/34d.png";
        break;
    case "35":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/35d.png";
        break;
    case "36":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/36d.png";
        break;  
    case "37":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/37d.png";
        break;
    case "38":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/38d.png";
        break;
    case "39":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/39d.png";
        break;
    case "40":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/40d.png";
        break;
    case "41":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/41d.png";
        break;
    case "42":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/42d.png";
        break;
    case "43":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/43d.png";
        break;
    case "44":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/44d.png";
        break;
    case "45":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/45d.png";
        break;
    case "46":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/46d.png";
        break; 
    case "47":
        $img = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/47d.png";
        break;
    }
  ?>
  <li>
  <div class="img-cast">
  <img src="<?php echo $img ?>">
  </div>
  <div class="cast-test">
   <p class="days"><?php echo $val->day; ?></p>
  <p>
  Low: <?php echo $val->low; ?>/  High: <?php echo $val->high; ?> 
  </p>
  </div>
    <div class="party-cloudy">
  <p>
  <?php echo $val->text; ?> 
  </p>
  </div>
  </li>
 
  <?php
}
}
}
?>
						</ul>
						</div>