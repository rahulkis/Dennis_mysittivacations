<?php 

include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

if (isset($_POST['session'])) {
	 $_SESSION['city_name'] = $_POST['session'];
	 $_SESSION['formatteds'] = $_POST['session'];

}elseif(isset($_POST['formatteds'])){
	$findData = mysql_query("SELECT city_id, city_name from capital_city WHERE city_name = '".strtok($_POST['formatteds'], ',')."'");
	$get_city = mysql_fetch_assoc($findData);
	if(empty($get_city)){
		$_SESSION['city_name'] = strtok($_POST['formatteds'], ',');
		$_SESSION['formatteds'] = strtok($_POST['formatteds'], ',');
		$hotel_city = explode(',', $_POST['formatteds'],3);
		if(count($hotel_city) > 2 ){
			array_pop($hotel_city);
		}
		$string_nw = implode(',',$hotel_city);
		$_SESSION['full_city_name'] = $string_nw;
	}else{
		$_SESSION['city_id'] = @$get_city['city_id'];
		$_SESSION['city_name'] = @$get_city['city_name'];
		$_SESSION['formatteds'] = strtok($_POST['formatteds'], ',');
		$hotel_city = explode(',', $_POST['formatteds'],3);
		if(count($hotel_city) > 2 ){
			array_pop($hotel_city);
		}
		$string_nw = implode(',',$hotel_city);
		$_SESSION['full_city_name'] = $string_nw;
	}
}else{
	$postdata = @$_POST['formatteds'];

	$findData = @mysql_query("SELECT city_id, city_name from capital_city WHERE city_name = '".$postdata."'");

	$get_city = mysql_fetch_assoc($findData);

	$_SESSION['city_id'] = @$get_city['city_id'];

	$_SESSION['city_name'] = @$get_city['city_name'];

	$_SESSION['formatteds'] = $postdata;
	$hotel_city = explode(',', $_POST['formatteds'],3);
	if(count($hotel_city) > 2 ){
		array_pop($hotel_city);
	}
	$string_nw = implode(',',$hotel_city);
	$_SESSION['full_city_name'] = $string_nw;

}

 ?>
