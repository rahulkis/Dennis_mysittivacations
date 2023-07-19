<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$country_id = $_GET['country_id'];
if($country_id=="Country")
{
 //$response = $id."|".$sname;
  echo "<option >Select Country</option>";
}
else
{

  $result = mysql_query("SELECT `zone_id`, `name` FROM `zone` WHERE `country_id` = ".$country_id." and status ='1' ORDER BY `name` ASC");
 /*$id=","; 
 $sname="Select,";
 while($row = mysql_fetch_assoc($result))
 {
  $id .=$row['zone_id'].","; 
  $sname .=$row['name'].","; 
 }
 $response = $id."|".$sname;
 echo $response;
}*/
 echo "<option >State</option>";
while($row_s = mysql_fetch_assoc($result))
 {
 echo "<option value='".$row_s['zone_id']."'>".$row_s['name']."</option>";
 }
}
?>
