<?php 
$key = empty($keyword) ? 'things%20%to%20%do' : str_replace(' ', '%20%', $keyword);
	$prepAddr =empty($city)?'Chicago': str_replace(' ','+',$city);
	$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key=AIzaSyDS4E5J5Jg-A4g4piaCfjyqJ2rc4uU_dN4');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$ch = curl_init();   
	// $urlgo = empty($limit) ? 'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'':'https://api.yelp.com/v3/businesses/search?term='.$key.'&latitude='.$latitude.'&longitude='.$longitude.'&limit='.$limit.'';
	 $urlgo ='https://api.yelp.com/v3/autocomplete?text=bars&latitude='.$latitude.'&longitude='.$longitude.'';
	// echo $urlgo;
	// $urlgo = "https://api.yelp.com/v3/businesses/search?term=".$key."&latitude=".$latitude."&longitude=".$longitude."&limit=".$limit."";
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

	$results = json_decode($result);
 
    $terms = array();

    if(count($results) > 0)
    {
      if($results->categories)
      {
             foreach ($results->categories as  $value) {
                 $terms[] = $value->title;
             }
      }  
      if($results->businesses)
      {
             foreach ($results->businesses as  $value) {
                 $terms[] = $value->name;
             }
      }
      if($results->terms)
      {
             foreach ($results->terms as  $value) {
                 $terms[] = $value->text;
             }
      }      
    }

   $terms = json_encode($terms);
   print_r($terms);
	
	
