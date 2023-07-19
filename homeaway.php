<?php

// $ch = curl_init();   
// $urlgo = "https://ws.homeaway.com/oauth/token";

//   curl_setopt($ch, CURLOPT_URL, $urlgo);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

// $headers = array();
// $headers[] = "Authorization: Basic MWZlOGI0MDgtMzk1ZC00ZDJmLWJjNDAtM2VlMTYzMzQyNWI3N2Q1ZGY2MDktNGFiMS00OThlLTllZTYtODFjZGM2ZjkyMWMz";
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://ws.homeaway.com/oauth/token",
  // CURLOPT_URL => "https://ws-stage.homeaway.com/oauth/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic MWZlOGI0MDgtMzk1ZC00ZDJmLWJjNDAtM2VlMTYzMzQyNWI3N2Q1ZGY2MDktNGFiMS00OThlLTllZTYtODFjZGM2ZjkyMWMz",
    "Postman-Token: 1959ccd3-420f-456e-8519-8f86661b4ae0",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
