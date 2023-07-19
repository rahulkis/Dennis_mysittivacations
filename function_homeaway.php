<?php


function vacationIndex($urlcity) {
  $date = date('y-m-d');

  if(isset($_GET['geocity']) && !empty($_GET['geocity'])){

  $url = "https://channel.homeaway.com/channel/vacationRentalIndexFeed?_restfully=true&paged=true&fromDate=".$date."&geoCity=".urlencode($urlcity);
  }else{
    $url = "https://channel.homeaway.com/channel/vacationRentalIndexFeed?_restfully=true&paged=true&fromDate=".$date."&geoCity=chicago";
  }
//echo "https://channel-stage.homeaway.com/channel/vacationRentalIndexFeed?_restfully=true&paged=true&fromDate=".$date."T00%3A00%3A00.000Z";
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
      "authorization: Bearer N2FjMjAxM2MtZWI0MS00Y2ZhLWEzMmUtOWM1N2ZkYTRlYTk1",
      "cache-control: no-cache",
      "postman-token: f70639ae-af88-ea38-7831-78879bf4d569"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    return [];
  } else {
    $units =  json_decode($response, true);
    $response = [];
    $i = 0;
    foreach ($units['entries'] as $key => $unit) {
       if(@$unit['enabled'] == true) {
         $response[$i] = $unit['unitUrl'];
         $i++;
       }
    }
    return $response; 
  }

}

function vacationRenatals($units) {
  // array of curl handles
  $multiCurl = array();
  // data to be returned
  $result = array();
  // multi handle
  $mh = curl_multi_init();
  foreach ($units as $i => $unit) {
    // URL from which data will be fetched
    $fetchURL = $unit;
    $multiCurl[$i] = curl_init();
    curl_setopt($multiCurl[$i], CURLOPT_URL,$fetchURL);
    curl_setopt($multiCurl[$i], CURLOPT_HEADER,0);
    curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER,1);
    $headers[] = 'Authorization: Bearer N2FjMjAxM2MtZWI0MS00Y2ZhLWEzMmUtOWM1N2ZkYTRlYTk1';
    curl_setopt($multiCurl[$i], CURLOPT_HTTPHEADER, $headers);
    curl_multi_add_handle($mh, $multiCurl[$i]);
  }
  $index=null;
  do {
    curl_multi_exec($mh,$index);
  } while($index > 0);
  // get content and remove handles
  foreach($multiCurl as $k => $ch) {
    $result[$k] = json_decode(curl_multi_getcontent($ch), true);
    curl_multi_remove_handle($mh, $ch);
  }
  // close
  curl_multi_close($mh);

  return $result;
}

 