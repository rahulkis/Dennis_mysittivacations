<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_GET['header_search'])){
 
$country_id = $_GET['country_id'];
$id=","; 
$sname="--Select State--,";

if($country_id=="-1")
{
 $response = $id."|".$sname;
 echo $response;
}
else
{

$result = @mysql_query("SELECT `zone_id`, `name` FROM `zone` WHERE `country_id` = ".$country_id." and status ='1' ORDER BY `name` ASC");
$car_arr = array();

  while($row = @mysql_fetch_array($result))
  { 
   $car_arr[] = $row['name']; 
  }
  
 echo json_encode($car_arr);
} 
 
 
 
 }else{

 $country_id = $_GET['country_id'];
  $id=","; 
 $sname="--Select State--,";
if($country_id=="-1")
{
 $response = $id."|".$sname;
 echo $response;
}
else
{

  $result = @mysql_query("SELECT `zone_id`, `name` FROM `zone` WHERE `country_id` = ".$country_id." and status ='1' ORDER BY `name` ASC");

 while($row = @mysql_fetch_array($result))
 {
  $id .=$row['zone_id'].","; 
  $sname .=$row['name'].","; 
 }
 $response = $id."|".$sname;
 echo $response;
}
}
?>
