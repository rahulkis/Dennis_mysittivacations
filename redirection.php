<?php
	session_start();
	ob_start();
	$location               = base64_decode($_GET['location']);
	$_SESSION['city_name']  = strtok($_GET['city'], ',');
	$_SESSION['formatteds'] = strtok($_GET['city'], ',');
	$hotel_city = explode(',', $_GET['city'],3);
	if(count($hotel_city) > 2 ){
		array_pop($hotel_city);
	}
	$string_nw = implode(',',$hotel_city);
	$_SESSION['full_city_name'] = $string_nw;
	header('Location:'.$location);
	die();