<?php
// echo $dropdowncity; die;
error_reporting(0);
if($_SESSION['user_type'] == 'club')
{
    $CountryNameQuery = mysql_query("SELECT `clubs`.`user_timezone`,`clubs`.`latitude`,`clubs`.`longitude`,`z`.`name`,`co`.`name` as `countryname`,`cc` .`city_name` as `cityname` FROM `country` as `co`, `capital_city` as `cc`,`zone` as `z`, `clubs` as `clubs`
                        WHERE `clubs`.`id` = '$_SESSION[user_id]'
                        AND `clubs`.`club_country` = `co`.`country_id`
                        AND `clubs`.`club_city` = `cc`.`city_id` 
                        AND `clubs`.`club_state` = `z`.`zone_id`
                    ");         
}
elseif($_SESSION['user_type'] == 'user')
{
    $CountryNameQuery = mysql_query("SELECT `clubs`.`user_timezone`,`clubs`.`latitude`,`clubs`.`longitude`,`z`.`name` as `stateName`,`co`.`name` as `countryname`,`cc` .`city_name` as `cityname` FROM `country` as `co`, `capital_city` as `cc`,`zone` as `z`, `user` as `clubs`
                        WHERE `clubs`.`id` = '$_SESSION[user_id]'
                        AND `clubs`.`country` = `co`.`country_id`
                        AND `clubs`.`city` = `cc`.`city_id`
                        AND `clubs`.`state` = `z`.`zone_id`
                    "); 
}

$FetchResults = mysql_fetch_assoc($CountryNameQuery);
if(empty($FetchResults['user_timezone']))
{

    function curl_contents($url) 
    {

        // Initiate the curl session 
        $ch = curl_init(); // Set the URL 
        curl_setopt($ch, CURLOPT_URL, $url); 
        // Removes the headers from the output 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        // Return the output instead of displaying it directly 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // Execute the curl session 
        $output = curl_exec($ch); 
        // Close the curl session 
        curl_close($ch); 
        // Return the output as a variable 
        return $output; 
    } 

    $data = curl_contents('https://maps.googleapis.com/maps/api/timezone/json?location='.$FetchResults['latitude'].','.$FetchResults['longitude'].'&timestamp='.time().'&key=AIzaSyDisVJr71LeXZPxn3iuIfjEdUcb0M3vXbs');
    $json = json_decode($data, true);
    //echo "<pre>"; print_r($json); exit;
    date_default_timezone_set($json['timeZoneId']);
    if($_SESSION['user_type'] == 'user')
    {
        mysql_query("UPDATE `user` SET `user_timezone` = '$json[timeZoneId]' WHERE `id` = '$_SESSION[user_id]' ");
    }
    else
    {
        mysql_query("UPDATE `clubs` SET `user_timezone` = '$json[timeZoneId]' WHERE `id` = '$_SESSION[user_id]' ");
    }
    
}
else
{//echo $FetchResults['user_timezone']; exit;
    date_default_timezone_set($FetchResults['user_timezone']);
}
// echo date('Y-m-d H:i:s');
?>