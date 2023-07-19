<?php
//if latitude and longitude are submitted
if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
     echo $_POST['latitude'];
    //send request and receive json data by latitude and longitude
    $url = 'https://maps.google.com/maps/api/geocode/json?latlng='.$_POST['latitude'].','.$_POST['longitude'].'&key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  '';
    }
    
    //return address to ajax 
    echo $location;
}
?>